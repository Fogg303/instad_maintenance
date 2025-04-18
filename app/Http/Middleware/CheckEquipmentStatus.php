<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckEquipmentStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
   // Dans app/Http/Middleware/CheckEquipmentStatus.php
    public function handle(Request $request, Closure $next)
    {
        $equipment = $request->route('equipment');
        
        if ($equipment->status === 'broken') {
            abort(403, "Les demandes ne sont pas autorisées pour cet équipement");
        }

        return $next($request);
    }
}
