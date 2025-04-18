@extends('layouts.base_user')
@section('title', 'Mes équipements')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8 space-y-6">
    <!-- En-tête avec titre et actions -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div class="space-y-2">
            <h1 class="text-2xl font-bold text-gray-900">Gestion des équipements</h1>
            <p class="text-sm text-gray-500">{{ $equipments->total() }} équipements enregistrés</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('user.dashboard') }}" 
               class="flex items-center gap-2 px-4 py-2.5 text-gray-600 hover:text-userPrimary transition-colors">
                <i class="bi bi-arrow-left-circle text-lg"></i>
                <span class="font-medium">Retour au dashboard</span>
            </a>
            <a href="{{ route('user.equipments.create') }}" 
               class="flex items-center gap-2 px-4 py-2.5 bg-userPrimary hover:bg-userDark text-white rounded-lg transition-all shadow-sm hover:shadow-md">
                <i class="bi bi-plus-circle text-lg"></i>
                <span class="font-medium">Nouvel équipement</span>
            </a>
        </div>
    </div>

    <!-- Carte principale -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
        <!-- En-tête du tableau -->
        <div class="px-6 py-4 bg-gradient-to-r from-userPrimary to-userDark">
            <h2 class="text-lg font-semibold text-white">Inventaire des équipements</h2>
        </div>

        <!-- Contenu -->
        <div class="overflow-x-auto relative">
            <table class="w-full">
                <thead class="bg-gray-50 sticky top-0">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700 min-w-[200px]">
                            <button class="flex items-center gap-1 sortable" data-column="name">
                                Nom
                                <i class="bi bi-arrow-down-up text-xs opacity-50"></i>
                            </button>
                        </th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Type</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700 min-w-[150px]">Statut</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700 min-w-[150px]">
                            <button class="flex items-center gap-1 sortable" data-column="date">
                                Date d'acquisition
                                <i class="bi bi-arrow-down-up text-xs opacity-50"></i>
                            </button>
                        </th>
                        <th class="px-6 py-3 text-sm font-semibold text-gray-700 w-20">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($equipments as $equipment)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 font-medium text-gray-900">
                            <div class="flex items-center gap-3">
                                <i class="bi bi-pc-display text-xl text-userPrimary"></i>
                                {{ $equipment->name }}
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="bg-userPrimary/10 text-userPrimary px-2.5 py-1 rounded-full text-sm">
                                {{ $equipment->type->name }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <span class="status-dot {{ $equipment->status }}"></span>
                                <span class="font-medium {{ $equipment->status === 'new' ? 'text-green-600' : 'text-red-600' }}">
                                    {{ config("equipment.statuses.{$equipment->status}") }}
                                </span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-gray-900">{{ $equipment->acquisition_date->format('d/m/Y') }}</div>
                            <div class="text-sm text-gray-500">Âge : {{ $equipment->acquisition_date->diffForHumans() }}</div>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <a href="{{ route('user.equipments.show', $equipment) }}" 
                               class="text-userPrimary hover:text-userDark"
                               title="Voir les détails">
                                <i class="bi bi-eye text-lg"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                            <i class="bi bi-inbox text-3xl mb-2"></i>
                            <div>Aucun équipement enregistré</div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($equipments->hasPages())
        <div class="px-6 py-4 border-t border-gray-100">
            {{ $equipments->links('vendor.pagination.tailwind') }}
        </div>
        @endif
    </div>
</div>

<style>
.status-dot {
    @apply w-3 h-3 rounded-full;
    box-shadow: 0 0 8px currentColor;
}
.status-dot.new { @apply bg-green-500; }
.status-dot.broken { @apply bg-red-500; }
.status-dot.repaired { @apply bg-blue-500; }

.sortable {
    transition: all 0.2s;
}
.sortable:hover {
    opacity: 0.8;
    transform: translateY(-1px);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.sortable').forEach(button => {
        button.addEventListener('click', function() {
            const column = this.dataset.column;
            const isAsc = this.classList.toggle('asc');
            // Implémenter la logique de tri ici
            console.log(`Tri ${column} en ${isAsc ? 'ascendant' : 'descendant'}`);
        });
    });
});
</script>
@endsection