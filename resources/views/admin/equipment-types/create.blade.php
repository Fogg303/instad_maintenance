@extends('layouts.base_admin')
@section('title', 'Nouveau type d\'équipement')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-3xl mx-auto">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-2xl font-bold text-gray-900">Création d'un type d'équipement</h1>
            <a href="{{ route('admin.equipment-types.index') }}" 
               class="text-blue-600 hover:text-blue-800 flex items-center">
                <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Retour
            </a>
        </div>

        <div class="bg-white rounded-xl shadow-md p-6">
            <form method="POST" action="{{ route('admin.equipment-types.store') }}">
                @csrf

                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-semibold mb-2">Nom du type</label>
                    <input type="text" 
                           name="name" 
                           value="{{ old('name') }}"
                           class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500 @error('name') border-red-500 @enderror"
                           required>
                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-semibold mb-2">Description</label>
                    <textarea name="description" 
                              rows="3"
                              class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500 @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-8 flex items-center">
                    <label class="flex items-center space-x-3">
                        <input type="checkbox" 
                               name="is_active" 
                               value="1" 
                               @checked(old('is_active', true))
                               class="h-5 w-5 rounded border-gray-300 text-blue-600 focus:ring-blue-500 transition">
                        <span class="text-gray-700 text-sm font-semibold">Activer ce type</span>
                    </label>
                </div>

                <div class="flex justify-end space-x-4 border-t pt-6">
                    <a href="{{ route('admin.equipment-types.index') }}" 
                       class="bg-gray-100 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-200 transition">
                        Annuler
                    </a>
                    <button type="submit" 
                            class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Créer le type
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection