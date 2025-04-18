@extends('layouts.base_admin')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-7xl mx-auto">
        <!-- Header avec bouton -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Gestion des caractéristiques</h1>
                <p class="mt-1 text-sm text-gray-600">{{ $characteristics->total() }} caractéristique(s) au total</p>
            </div>
            <a href="{{ route('admin.characteristics.create') }}" 
               class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 transition">
                <i class="bi bi-plus-circle mr-2"></i>
                Nouvelle caractéristique
            </a>
        </div>

        <!-- Tableau -->
        <div class="bg-white rounded-xl shadow overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nom</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Valeur par défaut</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type de donnée</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type d'équipement</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($characteristics as $characteristic)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $characteristic->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <span class="px-2 py-1 bg-gray-100 rounded-md">{{ $characteristic->formatted_default }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 capitalize">{{ $characteristic->data_type }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ $characteristic->equipmentType->name ?? '-' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm space-x-3">
                                    <a href="{{ route('admin.characteristics.edit', $characteristic->id) }}" 
                                       class="inline-flex items-center text-blue-600 hover:text-blue-900 transition"
                                       title="Modifier">
                                        <i class="bi bi-pencil-square mr-1"></i>
                                        <span class="hidden sm:inline">Éditer</span>
                                    </a>
                                    <form action="{{ route('admin.characteristics.destroy', $characteristic->id) }}" 
                                          method="POST" 
                                          class="inline-block"
                                          x-data="{ confirmDelete() { if(confirm('Êtes-vous sûr de vouloir supprimer cette caractéristique ?')) this.$el.submit() } }">
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
                                <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                                    <div class="flex flex-col items-center justify-center space-y-2">
                                        <i class="bi bi-inbox text-3xl text-gray-400"></i>
                                        <p class="text-sm">Aucune caractéristique trouvée</p>
                                        <a href="{{ route('admin.characteristics.create') }}" class="text-blue-600 hover:text-blue-800 text-sm">
                                            Créer une première caractéristique
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($characteristics->hasPages())
                <div class="border-t border-gray-200 px-4 py-3 sm:px-6">
                    {{ $characteristics->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection