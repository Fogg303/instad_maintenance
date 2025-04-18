<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Equipment;
use App\Models\EquipmentType;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class EquipmentController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        
        $equipments = Equipment::with(['type', 'user'])
            ->filter($search)
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        $stats = [
            'total' => Equipment::count(),
            'new' => Equipment::where('status', 'new')->count(),
            'broken' => Equipment::where('status', 'broken')->count()
        ];

        return view('admin.equipments.index', compact('equipments', 'stats'));
    }

    public function edit(Equipment $equipment)
    {
        return view('admin.equipments.edit', [
            'equipment' => $equipment->load('characteristicValues'),
            'statuses' => config('equipment.statuses'),
            'users' => User::with('direction')->get(),
            'types' => EquipmentType::all()
        ]);
    }

    public function update(Request $request, Equipment $equipment)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:50|unique:equipments,code,'.$equipment->id,
            'name' => 'required|string|max:255',
            'status' => 'required|in:'.implode(',', array_keys(config('equipment.statuses'))),
            'user_id' => 'nullable|exists:users,id',
            'equipment_type_id' => 'required|exists:equipment_types,id',
            'photo' => 'nullable|image|max:2048',
            'characteristics' => 'sometimes|array'
        ]);

        // Gestion de la photo
        if($request->hasFile('photo')) {
            if($equipment->photo_path) Storage::disk('public')->delete($equipment->photo_path);
            $validated['photo_path'] = $request->file('photo')->store('equipments/photos', 'public');
        }

        $equipment->update($validated);

        // Mise à jour des caractéristiques
        if($request->has('characteristics')) {
            foreach($request->characteristics as $characteristicId => $value) {
                $equipment->characteristicValues()->updateOrCreate(
                    ['characteristic_id' => $characteristicId],
                    ['value' => $value]
                );
            }
        }

        return redirect()->route('admin.equipments.index')
            ->with('toast', [
                'type' => 'success',
                'message' => 'Équipement mis à jour avec succès'
            ]);
    }

    public function destroy(Equipment $equipment)
    {
        if($equipment->photo_path) {
            Storage::disk('public')->delete($equipment->photo_path);
        }
        
        $equipment->delete();

        return redirect()->route('admin.equipments.index')
            ->with('toast', [
                'type' => 'success',
                'message' => 'Équipement supprimé définitivement'
            ]);
    }

    public function export(): StreamedResponse
    {
        $fileName = 'equipments-'.now()->format('Y-m-d').'.csv';

        return response()->streamDownload(function() {
            $handle = fopen('php://output', 'w');
            
            // Entête CSV
            fputcsv($handle, [
                'Code', 'Nom', 'Type', 'Utilisateur', 'Direction', 
                'Statut', 'Date création', 'Dernière mise à jour'
            ]);

            Equipment::with(['type', 'user.direction'])
                ->chunk(200, function($equipments) use ($handle) {
                    foreach ($equipments as $equipment) {
                        fputcsv($handle, [
                            $equipment->code,
                            $equipment->name,
                            $equipment->type->name,
                            $equipment->user?->name ?? 'Non attribué',
                            $equipment->user?->direction?->name ?? '-',
                            config("equipment.statuses.{$equipment->status}"),
                            $equipment->created_at->format('d/m/Y H:i'),
                            $equipment->updated_at->format('d/m/Y H:i')
                        ]);
                    }
                });

            fclose($handle);
        }, $fileName);
    }
}