<!-- resources/views/admin/directions/index.blade.php -->
@extends('layouts.base_admin')

@section('title', 'Gestion des Directions')

@section('content')
<div class="bg-white rounded-xl shadow-sm overflow-hidden">
    <div class="px-6 py-4 border-b flex justify-between items-center">
        <h3 class="text-lg font-semibold flex items-center">
            <i class="bi bi-building mr-2 text-instadBlue"></i>
            Liste des Directions
        </h3>
        <a href="{{ route('admin.directions.create') }}" 
           class="bg-instadBlue text-white px-4 py-2 rounded-lg hover:bg-blue-700 flex items-center">
            <i class="bi bi-plus-circle mr-2"></i> Ajouter
        </a>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase">Nom</th>
                    <th class="px-6 py-3 text-right text-sm font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse($directions as $direction)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4">
                        <div class="flex items-center">
                            <div class="p-2 rounded-full bg-blue-100 text-instadBlue mr-3">
                                <i class="bi bi-building"></i>
                            </div>
                            <span class="font-medium">{{ $direction->name }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex justify-end space-x-3">
                            <a href="{{ route('admin.directions.edit', $direction->id) }}" 
                               class="text-instadBlue hover:text-blue-700 p-2 rounded-full hover:bg-blue-50"
                               title="Modifier">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <form action="{{ route('admin.directions.destroy', $direction->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="text-red-500 hover:text-red-700 p-2 rounded-full hover:bg-red-50"
                                        onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette direction ?')"
                                        title="Supprimer">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="2" class="px-6 py-4 text-center text-gray-500">
                        Aucune direction enregistrée
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($directions->hasPages())
    <div class="px-6 py-4 border-t bg-gray-50">
        {{ $directions->links() }}
    </div>
    @endif
</div>

@if(session('success'))
<div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)"
     class="fixed bottom-6 right-6 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg flex items-center">
    <i class="bi bi-check-circle-fill mr-2"></i>
    {{ session('success') }}
    <button @click="show = false" class="ml-4">
        <i class="bi bi-x"></i>
    </button>
</div>
@endif
@endsection