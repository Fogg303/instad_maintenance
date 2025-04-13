<?php

namespace App\Http\Controllers;

use App\Models\Direction;
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
}