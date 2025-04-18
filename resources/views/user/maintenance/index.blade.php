@extends('layouts.base_user')

@section('title', 'Mes demandes de maintenance')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- En-tête amélioré -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
        <div class="space-y-2">
            <div class="flex items-center gap-3">
                <i class="bi bi-clipboard2-data text-3xl text-userPrimary"></i>
                <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Historique des demandes</h1>
            </div>
            <p class="ml-1 text-sm text-gray-500 font-medium">
                <span class="text-userPrimary">{{ $requests->total() }}</span> demandes trouvées
            </p>
        </div>
        <a href="{{ route('user.maintenance.select-equipment') }}" 
           class="flex items-center gap-2 px-5 py-3 bg-userPrimary hover:bg-userDark text-white rounded-xl transition-all 
                  shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
            <i class="bi bi-plus-circle text-lg"></i>
            <span class="font-semibold">Nouvelle demande</span>
        </a>
    </div>

    <!-- Carte avec tableau -->
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100/50">
        <div class="overflow-x-auto">
            <table class="w-full">
                <!-- En-tête stylisé -->
                <thead class="bg-gradient-to-r from-userPrimary/5 to-blue-100/10">
                    <tr>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">Équipement</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">Description</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">Priorité</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">Statut</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">Date</th>
                    </tr>
                </thead>
                
                <!-- Corps du tableau avec animations -->
                <tbody class="divide-y divide-gray-100">
                    @forelse($requests as $request)
                    <tr class="hover:bg-gray-50/80 transition-colors duration-150 ease-in-out">
                        <td class="px-6 py-4 font-medium text-gray-900">
                            <div class="flex items-center gap-3">
                                <i class="bi bi-hdd-stack text-gray-400"></i>
                                {{ $request->equipment->name }}
                            </div>
                        </td>
                        <td class="px-6 py-4 max-w-[300px] text-gray-600">
                            <div class="line-clamp-2">{{ $request->description }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold {{ $request->priority_class }}">
                                <i class="bi bi-exclamation-circle mr-1.5"></i>
                                {{ $request->priority_label }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold {{ $request->status_class }}">
                                <i class="bi bi-clock-history mr-1.5 text-sm"></i>
                                {{ $request->status_label }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">
                            {{ $request->created_at->format('d/m/Y H:i') }}
                        </td>
                    </tr>
                    @empty
                    <!-- État vide amélioré -->
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center">
                            <div class="max-w-md mx-auto space-y-4">
                                <i class="bi bi-inbox text-4xl text-gray-300"></i>
                                <div class="text-gray-500 font-medium">Aucune demande trouvée</div>
                                <p class="text-sm text-gray-400">Commencez par créer une nouvelle demande</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination stylisée -->
        @if($requests->hasPages())
        <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50">
            {{ $requests->onEachSide(1)->links('vendor.pagination.tailwind', [
                'style' => 'color: #3B82F6; font-weight: 500;',
                'active_class' => 'bg-userPrimary text-white',
                'hover_class' => 'bg-userPrimary/10'
            ]) }}
        </div>
        @endif
    </div>
</div>
@endsection