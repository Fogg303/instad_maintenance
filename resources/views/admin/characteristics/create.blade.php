@extends('layouts.base_admin')
@section('title', 'Nouvelle caractéristique')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-3xl mx-auto">
        <!-- En-tête avec bouton de retour -->
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-2xl font-bold text-gray-900">Création d'une caractéristique</h1>
            <a href="{{ route('admin.characteristics.index') }}" 
               class="text-blue-600 hover:text-blue-800 flex items-center">
                <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Retour
            </a>
        </div>

        <!-- Carte du formulaire -->
        <div class="bg-white rounded-xl shadow-md p-6">
            <form action="{{ route('admin.characteristics.store') }}" method="POST">
                @csrf

                <!-- Champ Nom -->
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-semibold mb-2">Nom de la caractéristique</label>
                    <input type="text" 
                           name="name" 
                           value="{{ old('name') }}"
                           class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500 @error('name') border-red-500 @enderror"
                           required>
                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Valeur par défaut -->
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-semibold mb-2">Valeur par défaut</label>
                    <input type="text" 
                           name="default_value" 
                           value="{{ old('default_value') }}"
                           class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500 @error('default_value') border-red-500 @enderror">
                    @error('default_value')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Sélection du type -->
                <div class="mb-8">
                    <label class="block text-gray-700 text-sm font-semibold mb-2">Type d'équipement associé</label>
                    <select name="type_id" 
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500 @error('type_id') border-red-500 @enderror" 
                            required>
                        <option value="">-- Sélectionner un type --</option>
                        @foreach($equipmentTypes as $type)
                            <option value="{{ $type->id }}" {{ old('type_id') == $type->id ? 'selected' : '' }}>
                                {{ $type->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('type_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Boutons -->
                <div class="flex justify-end space-x-4 border-t pt-6">
                    <a href="{{ route('admin.characteristics.index') }}" 
                       class="bg-gray-100 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-200 transition">
                        Annuler
                    </a>
                    <button type="submit" 
                            class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Enregistrer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection