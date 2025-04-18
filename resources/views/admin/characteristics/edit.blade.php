@extends('layouts.base_admin')
@section('title', 'Modifier la caractéristique')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-md p-6">
        <!-- En-tête avec bouton de retour -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Modifier la caractéristique</h1>
            <a href="{{ route('admin.characteristics.index') }}" 
               class="text-blue-600 hover:text-blue-800 flex items-center">
                <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Retour
            </a>
        </div>

        <!-- Formulaire -->
        <form action="{{ route('admin.characteristics.update', $characteristic->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Champ Nom -->
            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-semibold mb-2">Nom</label>
                <input type="text" name="name" 
                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500 @error('name') border-red-500 @enderror"
                       value="{{ old('name', $characteristic->name) }}" 
                       required>
                @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Valeur par défaut -->
            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-semibold mb-2">Valeur par défaut</label>
                <input type="text" name="default_value" 
                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500 @error('default_value') border-red-500 @enderror"
                       value="{{ old('default_value', $characteristic->default_value) }}">
                @error('default_value')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Type d'équipement -->
            <div class="mb-8">
                <label class="block text-gray-700 text-sm font-semibold mb-2">Type d'équipement</label>
                <select name="type_id" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500 @error('type_id') border-red-500 @enderror" required>
                    <option value="">-- Sélectionner --</option>
                    @foreach($types as $type)
                        <option value="{{ $type->id }}" 
                            {{ $characteristic->type_id == $type->id || old('type_id') == $type->id ? 'selected' : '' }}>
                            {{ $type->name }}
                        </option>
                    @endforeach
                </select>
                @error('type_id')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Boutons -->
            <div class="flex justify-end space-x-4">
                <a href="{{ route('admin.characteristics.index') }}" 
                   class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-300 transition duration-150">
                    Annuler
                </a>
                <button type="submit" 
                        class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition duration-150 flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Mettre à jour
                </button>
            </div>
        </form>
    </div>
</div>
@endsection