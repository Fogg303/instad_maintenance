@extends('layouts.base_admin')

@section('title', 'Gestion des Équipements')

@section('content')
<div class="px-6 py-8 space-y-6">
    <!-- En-tête avec statistiques -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-white p-4 rounded-lg shadow border-l-4 border-instadBlue">
            <div class="text-gray-500 text-sm">Équipements actifs</div>
            <div class="text-2xl font-bold mt-2">{{ $stats['total'] }}</div>
        </div>
        <div class="bg-white p-4 rounded-lg shadow border-l-4 border-green-500">
            <div class="text-gray-500 text-sm">En bon état</div>
            <div class="text-2xl font-bold mt-2">{{ $stats['new'] }}</div>
        </div>
        <div class="bg-white p-4 rounded-lg shadow border-l-4 border-red-500">
            <div class="text-gray-500 text-sm">En réparation</div>
            <div class="text-2xl font-bold mt-2">{{ $stats['broken'] }}</div>
        </div>
    </div>


    <!-- Barre d'actions -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div class="flex items-center gap-3">
            <input type="text" id="searchInput" placeholder="Rechercher..." 
                   class="px-4 py-2 border rounded-lg w-full md:w-64">
            <a href="{{ route('admin.equipments.export') }}" 
               class="flex items-center gap-2 px-4 py-2 text-sm text-instadBlue hover:bg-gray-100 rounded-lg">
                <i class="bi bi-file-earmark-arrow-down"></i>
                Exporter CSV
            </a>
        </div>
    </div>

    <!-- Tableau principal -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div id="equipmentTable">
            @include('admin.equipments.partials.table', ['equipments' => $equipments])
        </div>
    </div>
</div>

<!-- Modal de suppression (identique à précédemment) -->
@endsection