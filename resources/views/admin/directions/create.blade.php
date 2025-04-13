<!-- resources/views/admin/directions/create.blade.php -->
@extends('layouts.base_admin')

@section('title', 'Créer une Direction')

@section('content')
<div class="bg-white rounded-xl shadow-sm overflow-hidden max-w-2xl mx-auto">
    <div class="px-6 py-4 border-b flex justify-between items-center bg-gray-50">
            <h3 class="text-lg font-semibold flex items-center">
            <i class="bi bi-building text-instadBlue mr-2"></i>
            Créer une Nouvelle Direction
        </h3>
        <a href="{{ route('admin.directions.index') }}" 
           class="flex items-center text-instadBlue hover:text-blue-700">
            <i class="bi bi-arrow-left mr-2"></i> Retour à la liste
        </a>
    </div>
    
    <div class="p-6">
        <form method="POST" action="{{ route('admin.directions.store') }}">
            @csrf
            
            <div class="mb-6">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                    Nom de la Direction <span class="text-red-500">*</span>
                </label>
                <input type="text" id="name" name="name" value="{{ old('name') }}"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-instadBlue focus:border-instadBlue
                              @error('name') border-red-500 @enderror"
                       placeholder="Direction des Systèmes d'Information">
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="flex justify-end space-x-4 pt-4 border-t">
                <a href="{{ route('admin.directions.index') }}" 
                   class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                    Annuler
                </a>
                <button type="submit" 
                        class="px-6 py-2 bg-instadBlue text-white rounded-lg hover:bg-blue-700 flex items-center">
                    <i class="bi bi-check-circle mr-2"></i>
                    Créer
                </button>
            </div>
        </form>
    </div>
</div>
@endsection