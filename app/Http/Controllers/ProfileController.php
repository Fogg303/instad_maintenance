<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Afficher le formulaire de profil
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());
    
        // Supprimer ou commenter ce bloc
        // if ($request->user()->isDirty('email')) {
        //     $request->user()->email_verified_at = null;
        // }
    
        if ($request->filled('current_password') && $request->filled('password')) {
            if (Hash::check($request->current_password, $request->user()->password)) {
                $request->user()->password = Hash::make($request->password);
            } else {
                return back()->withErrors(['current_password' => 'Le mot de passe actuel est incorrect']);
            }
        }
    
        $request->user()->save();
    
        return Redirect::route('profile.edit')
            ->with('success', 'Profil mis à jour avec succès!');
    }
    /**
     * Supprimer le compte utilisateur
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/')->with('status', 'Votre compte a été supprimé avec succès.');
    }
}