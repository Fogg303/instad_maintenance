@extends('layouts.base_admin')
@section('title', 'Types d\'équipements')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-7xl mx-auto">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Gestion des types d'équipements</h1>
                <p class="mt-1 text-sm text-gray-600">{{ $types->total() }} type(s) enregistré(s)</p>
            </div>
            <a href="{{ route('admin.equipment-types.create') }}" 
               class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 transition">
                <i class="bi bi-plus-circle mr-2"></i>
                Nouveau type
            </a>
        </div>

        <div class="bg-white rounded-xl shadow overflow-hidden">
            <!-- Sélecteur d'éléments par page -->
            <div class="px-4 py-3 border-b flex justify-end items-center space-x-4">
                <span class="text-sm text-gray-600">Éléments par page :</span>
                <select onchange="window.location.href = this.value" class="border rounded px-2 py-1 text-sm">
                    @foreach([10, 25, 50] as $value)
                        <option value="{{ request()->fullUrlWithQuery(['per_page' => $value]) }}" {{ $types->perPage() == $value ? 'selected' : '' }}>
                            {{ $value }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nom</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Caractéristiques</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($types as $type)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $type->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ $type->characteristics_count }} caractéristique(s)
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        {{ $type->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $type->is_active ? 'Actif' : 'Inactif' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm space-x-3">
                                    <a href="{{ route('admin.equipment-types.edit', $type) }}" 
                                       class="inline-flex items-center text-blue-600 hover:text-blue-900 transition"
                                       title="Modifier">
                                        <i class="bi bi-pencil-square mr-1"></i>
                                        <span class="hidden sm:inline">Éditer</span>
                                    </a>
                                    <form action="{{ route('admin.equipment-types.destroy', $type) }}" 
                                          method="POST" 
                                          class="inline-block"
                                          x-data="{ confirmDelete() { if(confirm('Supprimer définitivement ce type ?')) this.$el.submit() } }">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" 
                                                @click="confirmDelete"
                                                class="text-red-600 hover:text-red-900 transition"
                                                title="Supprimer">
                                            <i class="bi bi-trash mr-1"></i>
                                            <span class="hidden sm:inline">Supprimer</span>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-8 text-center text-gray-500">
                                    <div class="flex flex-col items-center justify-center space-y-2">
                                        <i class="bi bi-inbox text-3xl text-gray-400"></i>
                                        <p class="text-sm">Aucun type d'équipement trouvé</p>
                                        <a href="{{ route('admin.equipment-types.create') }}" class="text-blue-600 hover:text-blue-800 text-sm">
                                            Créer un premier type
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($types->hasPages())
                <div class="border-t border-gray-200 px-4 py-3 sm:px-6 bg-gray-50">
                    {{ $types->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection