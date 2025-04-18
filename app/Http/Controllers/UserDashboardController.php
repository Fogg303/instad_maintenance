<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use App\Models\MaintenanceRequest;
use Illuminate\Support\Facades\Auth;

class UserDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        return view('user.dashboard', [
            'stats' => [
                'open_tickets' => MaintenanceRequest::where('user_id', $user->id)
                    ->where('status', 'open')->count(),
                'resolved_tickets' => MaintenanceRequest::where('user_id', $user->id)
                    ->where('status', 'resolved')->count(),
                'pending_tickets' => MaintenanceRequest::where('user_id', $user->id)
                    ->whereIn('status', ['open', 'in_progress'])->count(),
            ],
            'recent_requests' => MaintenanceRequest::with(['equipment', 'technician'])
                ->where('user_id', $user->id)
                ->latest()
                ->take(5)
                ->get(),
            'equipments' => Equipment::with(['type', 'maintenanceRequests'])
                ->where('user_id', $user->id)
                ->get()
        ]);
    }
}