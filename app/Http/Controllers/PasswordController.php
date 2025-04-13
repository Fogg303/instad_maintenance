<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class PasswordController extends Controller
{
    public function showChangeForm()
    {
        return view('auth.force-password-change');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $request->user()->update([
            'password' => Hash::make($request->password),
            'force_password_change' => false,
            'password_changed_at' => now()
        ]);

        auth()->logout();

        return redirect()->route('login')
            ->with('toast', [
                'type' => 'success',
                'title' => 'Succès',
                'message' => 'Mot de passe modifié avec succès' // Modification ici
            ]);
    }

    public function adminChangePassword()
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        return view('admin.auth.change-password');
    }
}