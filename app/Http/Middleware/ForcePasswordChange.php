<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ForcePasswordChange
{
    public function handle(Request $request, Closure $next): Response
{
    $user = $request->user();

    // Ajouter une condition pour éviter la redirection sur la page de changement
    if ($user && 
        $user->role !== 'admin' && 
        $user->force_password_change && 
        !$request->is('password/change') // <-- Solution clé ici
    ) {
        return redirect()->route('password.change');
    }

    return $next($request);
}
}