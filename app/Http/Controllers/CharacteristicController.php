<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Characteristic;
use App\Models\EquipmentType;
use Illuminate\Http\Request;

class CharacteristicController extends Controller
{
    public function index()
    {
        $characteristics = Characteristic::with('equipmentType')->paginate(10);
        return view('admin.characteristics.index', compact('characteristics'));
    }

// In CharacteristicController.php
public function create()
{
    $equipmentTypes = EquipmentType::all(); // Rename variable
    return view('admin.characteristics.create', compact('equipmentTypes'));
}

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'default_value' => 'required',
            'type_id' => 'required|exists:equipment_types,id'
        ]);

        Characteristic::create($validated);

        return redirect()->route('admin.characteristics.index')
            ->with('success', 'Caractéristique créée avec succès');
    }

    public function show(Characteristic $characteristic)
    {
        return view('admin.characteristics.show', compact('characteristic'));
    }

    public function edit(Characteristic $characteristic)
    {
        $types = EquipmentType::all();
        return view('admin.characteristics.edit', compact('characteristic', 'types'));
    }

    public function update(Request $request, Characteristic $characteristic)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'default_value' => 'required',
            'type_id' => 'required|exists:equipment_types,id'
        ]);

        $characteristic->update($validated);

        return redirect()->route('admin.characteristics.index')
            ->with('success', 'Caractéristique mise à jour');
    }

    public function destroy(Characteristic $characteristic)
    {
        $characteristic->delete();
        return redirect()->route('admin.characteristics.index')
            ->with('success', 'Caractéristique supprimée');
    }
}