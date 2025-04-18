<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EquipmentType;
use Illuminate\Http\Request;

class EquipmentTypeController extends Controller
{
    public function index()
    {
        $types = EquipmentType::withCount('characteristics')
            ->orderBy('created_at', 'desc')
            ->paginate(10); // Modification ici (ajout de paginate)

        return view('admin.equipment-types.index', compact('types'));
    }

    // Le reste du contrôleur reste inchangé
    public function create()
    {
        return view('admin.equipment-types.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|unique:equipment_types|max:255',
            'description' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        EquipmentType::create($validated);

        return redirect()->route('admin.equipment-types.index')
            ->with('success', 'Type d\'équipement créé avec succès');
    }

    public function show(EquipmentType $equipmentType)
    {
        return view('admin.equipment-types.show', compact('equipmentType'));
    }

    public function edit(EquipmentType $equipmentType)
    {
        return view('admin.equipment-types.edit', compact('equipmentType'));
    }

    public function update(Request $request, EquipmentType $equipmentType)
    {
        $validated = $request->validate([
            'name' => 'required|max:255|unique:equipment_types,name,'.$equipmentType->id,
            'description' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        $equipmentType->update($validated);

        return redirect()->route('admin.equipment-types.index')
            ->with('success', 'Type d\'équipement mis à jour');
    }

    public function destroy(EquipmentType $equipmentType)
    {
        $equipmentType->delete();
        return redirect()->route('admin.equipment-types.index')
            ->with('success', 'Type d\'équipement supprimé');
    }
}