<?php

namespace App\Http\Controllers;

use App\Models\Direction;
use App\Models\Characteristic;
use App\Models\EquipmentType;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // Afficher toutes les directions
  /*   public function showDirections()
    {
        $directions = Direction::latest()->paginate(10);
        return view('admin.directions.index', compact('directions'));
    } */

    public function index()
    {
        $directions = Direction::latest()->paginate(10);
        return view('admin.directions.index', compact('directions'));
    }

    // Afficher le formulaire de création
    public function create()
    {
        return view('admin.directions.create');
    }

    // Sauvegarder une nouvelle direction
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:directions,name',
        ]);

        Direction::create($request->only('name'));

        return redirect()->route('admin.directions.index')
                        ->with('success', 'Direction créée avec succès.');
    }

    // Afficher le formulaire de modification
    public function edit($id)
    {
        $direction = Direction::findOrFail($id);
        return view('admin.directions.edit', compact('direction'));
    }

    // Mettre à jour une direction
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:directions,name,'.$id,
        ]);

        $direction = Direction::findOrFail($id);
        $direction->update($request->only('name'));

        return redirect()->route('admin.directions.index')
                        ->with('success', 'Direction mise à jour avec succès.');
    }

    // Supprimer une direction
    public function destroy($id)
    {
        $direction = Direction::findOrFail($id);
        $direction->delete();

        return redirect()->route('admin.directions.index')
                        ->with('success', 'Direction supprimée avec succès.');
    }



     // Gestion des types d'équipements
     public function equipmentTypes()
     {
         $types = EquipmentType::with('characteristics')->get();
         return view('admin.types.index', compact('types'));
     }
 
     public function createType()
     {
         return view('admin.types.create');
     }
 
     public function storeType(Request $request)
     {
         $validated = $request->validate([
             'name' => 'required|string|max:255|unique:equipment_types,name',
             'description' => 'nullable|string'
         ]);
 
         $type = EquipmentType::create($validated);
 
         // Gestion des caractéristiques
         foreach ($request->characteristics as $char) {
             Characteristic::create([
                 'name' => $char['name'],
                 'default_value' => $char['default_value'],
                 'type_id' => $type->id
             ]);
         }
 
         return redirect()->route('admin.types')->with('success', 'Type créé avec ses caractéristiques');
     }
 
     public function editType(EquipmentType $type)
     {
         return view('admin.types.edit', compact('type'));
     }
 
     public function updateType(Request $request, EquipmentType $type)
     {
         $validated = $request->validate([
             'name' => 'required|string|max:255|unique:equipment_types,name,'.$type->id,
             'description' => 'nullable|string',
             'is_active' => 'boolean'
         ]);
 
         $type->update($validated);
         return redirect()->route('admin.types')->with('success', 'Type mis à jour');
     }
 
     // Gestion des caractéristiques
     public function editCharacteristic(Characteristic $characteristic)
     {
         return view('admin.characteristics.edit', compact('characteristic'));
     }
 
     public function updateCharacteristic(Request $request, Characteristic $characteristic)
     {
         $validated = $request->validate([
             'name' => 'required|string|max:255',
             'default_value' => 'required|string'
         ]);
 
         $characteristic->update($validated);
         return redirect()->route('admin.types')->with('success', 'Caractéristique mise à jour');
     }
 
     public function destroyCharacteristic(Characteristic $characteristic)
     {
         $characteristic->delete();
         return back()->with('success', 'Caractéristique supprimée');
     }
 
}








   