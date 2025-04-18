<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use App\Models\EquipmentType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use App\Models\Characteristic;

class EquipementController extends Controller
{
    public function index()
    {
        $equipments = Equipment::with(['type', 'user'])
                      ->where('user_id', auth()->id())
                      ->paginate(10);
                      
        return view('user.equipments.index', compact('equipments'));
    }
    public function show(Equipment $equipment)
    {
        // Vérification manuelle de l'autorisation
        if ($equipment->user_id !== auth()->id()) {
            abort(403, 'Accès non autorisé');
        }
    
        return view('user.equipments.show', [
            'equipment' => $equipment->load(['type', 'characteristicValues.characteristic'])
        ]);
    }
    public function create()
    {
        return $this->formView(new Equipment());
    }
    

    public function store(Request $request)
    {
        $validated = $request->validate(Equipment::validationRules());
        $validated['user_id'] = auth()->id();
        $validated['code'] = Equipment::generateUniqueCode();
    
        // Création de l'équipement
        $equipment = Equipment::create($validated);
        
        // Traitement global (photo + caractéristiques)
        $this->processEquipment($request, $equipment);
    
        return redirect()->route('user.equipments.index')
               ->with('success', 'Équipement créé avec succès');
    }

    public function edit(Equipment $equipment)
    {
        $this->authorize('update', $equipment);
        return $this->formView($equipment);
    }

    public function update(Request $request, Equipment $equipment)
    {
        $this->authorize('update', $equipment);
        
        $validated = $request->validate(Equipment::validationRules($equipment->id));
        $equipment->update($validated);
        $this->processEquipment($request, $equipment);
        
        return redirect()->route('user.equipments.index')
               ->with('success', 'Équipement mis à jour');
    }

    public function destroy(Equipment $equipment)
    {
        $this->authorize('delete', $equipment);
        $equipment->delete();
        
        return redirect()->route('user.equipments.index')
               ->with('success', 'Équipement supprimé');
    }

    protected function formView(Equipment $equipment)
    {
        return view('user.equipments.form', [
            'equipment' => $equipment,
            'types' => EquipmentType::with('characteristics')->get(),
            'statuses' => Equipment::STATUSES,
            'action' => $equipment->exists 
                ? route('user.equipments.update', $equipment)
                : route('user.equipments.store'),
            'method' => $equipment->exists ? 'PUT' : 'POST'
        ]);
    }

    protected function processEquipment(Request $request, Equipment $equipment)
    {
        // Gestion de la photo
        if ($request->has('remove_photo')) {
            Storage::disk('public')->delete($equipment->photo_path);
            $equipment->photo_path = null;
            $equipment->save();
        } 
        elseif ($request->hasFile('photo')) {
            try {
                // Suppression ancienne photo
                if ($equipment->photo_path) {
                    Storage::disk('public')->delete($equipment->photo_path);
                }
                
                // Sauvegarde nouvelle photo
                $path = $request->file('photo')->store('equipments', 'public');
                $equipment->photo_path = $path;
                $equipment->save();
            } catch (\Exception $e) {
                Log::error('Erreur gestion photo : ' . $e->getMessage());
            }
        }

        if ($request->has('characteristics')) {
            foreach ($request->characteristics as $charId => $value) {
                $characteristic = Characteristic::find($charId);
                
                $column = match($characteristic->data_type) {
                    'number' => 'numeric_value',
                    'boolean' => 'boolean_value',
                    'date' => 'date_value',
                    default => 'string_value'
                };
    
                $equipment->characteristicValues()->updateOrCreate(
                    ['characteristic_id' => $charId],
                    [$column => $value]
                );
            }
        }
    }}