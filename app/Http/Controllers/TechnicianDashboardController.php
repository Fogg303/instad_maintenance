<?php

// app/Http/Controllers/TechnicianDashboardController.php

namespace App\Http\Controllers;

use App\Models\MaintenanceRequest;
use Illuminate\Support\Facades\Auth;

class TechnicianDashboardController extends Controller
{
    public function index()
    {
        $requests = MaintenanceRequest::with('equipment')
            ->where('technician_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('technician.dashboard', compact('requests'));
    }
}