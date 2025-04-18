<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use App\Models\MaintenanceRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class MaintenanceController extends Controller
{
    public function index(): View
    {
        $requests = MaintenanceRequest::with(['equipment', 'technician'])
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('user.maintenance.index', [
            'requests' => $requests,
            'statuses' => MaintenanceRequest::$statuses
        ]);
    }

    public function selectEquipment(): View|RedirectResponse
    {
        $equipments = Auth::user()->equipments;

        if ($equipments->isEmpty()) {
            return redirect()->route('user.equipments.create')
                ->with('warning', 'Vous devez d\'abord créer un équipement');
        }

        return view('user.maintenance.select-equipment', compact('equipments'));
    }

    public function create(Equipment $equipment): View
    {
        Gate::authorize('create-maintenance', $equipment);

        return view('user.maintenance.create', [
            'equipment' => $equipment->load('type'),
            'priorities' => MaintenanceRequest::$priorities
        ]);
    }

    public function store(Request $request, Equipment $equipment): RedirectResponse
    {
        Gate::authorize('create-maintenance', $equipment);

        $validated = $request->validate([
            'description' => 'required|string|max:1000',
            'priority' => 'required|in:' . implode(',', array_keys(MaintenanceRequest::$priorities)),
            'attachments.*' => 'nullable|file|max:2048'
        ]);

        $maintenance = $equipment->maintenanceRequests()->create([
            'user_id' => Auth::id(),
            'description' => $validated['description'],
            'priority' => $validated['priority'],
            'status' => MaintenanceRequest::STATUS_OUVERT
        ]);

        $this->handleAttachments($request, $maintenance);

        return redirect()->route('user.maintenance.index')
            ->with('success', 'Demande enregistrée avec succès');
    }

    public function show(MaintenanceRequest $maintenance): View
    {
        Gate::authorize('view', $maintenance);

        return view('user.maintenance.show', [
            'request' => $maintenance->load([
                'equipment.type',
                'technician.direction',
                'attachments'
            ])
        ]);
    }

    private function handleAttachments(Request $request, MaintenanceRequest $maintenance): void
    {
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store(
                    "maintenance_attachments/{$maintenance->id}",
                    'public'
                );

                $maintenance->attachments()->create([
                    'path' => $path,
                    'original_name' => $file->getClientOriginalName()
                ]);
            }
        }
    }
}