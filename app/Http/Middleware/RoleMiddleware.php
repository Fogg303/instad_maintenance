<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    // RoleMiddleware.php
public function handle(Request $request, Closure $next, $role)
{
    if (!Auth::check()) {
        return redirect()->route('login');
    }

    $user = Auth::user();
    
    // Autoriser admin + roles spécifiques
    $allowedRoles = explode('|', $role);
    
    if ($user->role === 'admin' || in_array($user->role, $allowedRoles)) {
        return $next($request);
    }

    return response('Accès refusé', 403);
}
}