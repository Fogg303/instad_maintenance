<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Direction;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Notifications\TemporaryPasswordNotification;
use Symfony\Component\Mailer\Exception\TransportException;

class AdminMakeUserController extends Controller
{
    public function index(Request $request)
    {
        try {
            $search = $request->input('search');
            
            $users = User::with('direction')
                ->when($search, function($query) use ($search) {
                    $query->where(function($q) use ($search) {
                        $q->where('name', 'like', "%$search%")
                          ->orWhere('email', 'like', "%$search%")
                          ->orWhereHas('direction', function($q) use ($search) {
                              $q->where('name', 'like', "%$search%");
                          });
                    });
                })
                ->orderBy('created_at', 'desc')
                ->paginate(10);
    
            if($request->ajax()) {
                return response()->json([
                    'table' => view('admin.users.partials.table', [
                        'users' => $users,
                        'searchTerm' => $search // Ajout du terme de recherche
                    ])->render(),
                    'pagination' => $users->links()->toHtml(),
                    'count' => $users->total()
                ]);
            }
    
            return view('admin.users.index', [
                'users' => $users,
                'directions' => Direction::all()
            ]);
    
        } catch (\Exception $e) {
            logger()->error('Erreur recherche utilisateurs : ' . $e->getMessage());
            
            if($request->ajax()) {
                return response()->json([
                    'error' => 'Erreur serveur : ' . $e->getMessage()
                ], 500);
            }
            
            return back()->withError('Une erreur est survenue');
        }
    }
    public function create()
    {
        return view('admin.users.form', [
            'user' => new User(),
            'directions' => Direction::orderBy('name')->get(),
            'roles' => $this->getAllowedRoles()
        ]);
    }

    public function store(Request $request)
    {
        $this->authorize('create', User::class);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'role' => 'required|in:admin,technician,user',
            'direction_id' => 'nullable|exists:directions,id'
        ]);

        try {
            $tempPassword = Str::random(10);
            
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($tempPassword),
                'role' => $validated['role'],
                'direction_id' => $validated['direction_id'],
                'email_verified_at' => now(),
                'force_password_change' => true,
                'password_changed_at' => null,
            ]);

            $user->notify(
                (new TemporaryPasswordNotification($tempPassword))
                    ->onConnection(config('mail.queue_driver'))
            );

            Log::info("Nouvel utilisateur créé", ['user_id' => $user->id]);

            return redirect()->route('admin.users.index')
                ->with('toast', $this->toastData('success', 'Utilisateur créé - Mot de passe temporaire envoyé'));

        } catch (TransportException $e) {
            Log::error('ERREUR SMTP', [
                'error' => $e->getMessage(),
                'user' => $validated['email']
            ]);
            
            return back()->withInput()
                ->with('toast', $this->toastData(
                    'error',
                    $this->getSmtpError($e)
                ));

        } catch (\Exception $e) {
            Log::error('Erreur création utilisateur', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return back()->withInput()
                ->with('toast', $this->toastData(
                    'error',
                    'Erreur technique - Réessayez ou contactez le support'
                ));
        }
    }

    public function edit(User $user)
    {
        return view('admin.users.form', [
            'user' => $user,
            'directions' => Direction::orderBy('name')->get(),
            'roles' => $this->getAllowedRoles()
        ]);
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate($this->validationRules($user));

        $updateData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role'],
            'direction_id' => $validated['direction_id']
        ];

        if (!empty($validated['password'])) {
            $updateData['password'] = Hash::make($validated['password']);
            $updateData['force_password_change'] = false;
            $updateData['password_changed_at'] = now();
        }

        $user->update($updateData);

        return redirect()->route('admin.users.index')
            ->with('toast', $this->toastData('success', 'Utilisateur mis à jour'));
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('toast', 
                $this->toastData('error', 'Impossible de supprimer votre propre compte'));
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('toast', $this->toastData('success', 'Utilisateur supprimé'));
    }

    public function forcePasswordReset(User $user)
    {
        $tempPassword = Str::random(10);
        
        $user->update([
            'password' => Hash::make($tempPassword),
            'force_password_change' => true,
            'password_changed_at' => null
        ]);
        
        try {
            $user->notify(
                (new TemporaryPasswordNotification($tempPassword))
                    ->onConnection(config('mail.queue_driver'))
            );
            
            return back()->with('toast', 
                $this->toastData(
                    'success', 
                    'Mot de passe réinitialisé - Nouveau mot de passe temporaire envoyé'
                ));
                
        } catch (TransportException $e) {
            Log::error('ERREUR SMTP', [
                'error' => $e->getMessage(),
                'user' => $user->email
            ]);
            
            return back()->with('toast', 
                $this->toastData(
                    'error',
                    'Mot de passe réinitialisé mais échec d\'envoi par email - ' . $this->getSmtpError($e)
                ));
        }
    }

    private function validationRules(?User $user = null): array
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'role' => 'required|in:admin,technician,user',
            'direction_id' => 'nullable|exists:directions,id',
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()]
        ];

        if ($user) {
            $rules['email'] .= ',' . $user->id;
        }

        return $rules;
    }

    private function getAllowedRoles(): array
    {
        return [
            'admin' => 'Administrateur',
            'technician' => 'Technicien',
            'user' => 'Utilisateur'
        ];
    }

    private function toastData(string $type, string $message): array
    {
        return [
            'type' => $type,
            'title' => ucfirst($type),
            'message' => $message
        ];
    }

    private function getSmtpError(TransportException $e): string
    {
        return match(true) {
            str_contains($e->getMessage(), 'Connection refused') => 
                'Erreur réseau - Vérifiez votre connexion internet',
            str_contains($e->getMessage(), 'Invalid login') => 
                'Erreur d\'authentification - Vérifiez la configuration email',
            str_contains($e->getMessage(), 'Timed Out') => 
                'Timeout SMTP - Réessayez plus tard',
            default => 'Erreur email (Code: '.$e->getCode().')'
        };
    }
}