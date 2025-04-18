@extends('layouts.base_user') {{-- Assurez-vous d'étendre le bon layout --}}

@section('content')
<div class="max-w-3xl mx-auto px-4 py-8">
    <div class="bg-white rounded-xl shadow-sm p-6">
        <h2 class="text-xl font-semibold mb-6">Sélectionnez un équipement</h2>
        
        @if($equipments->isEmpty())
            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4">
                <p>Aucun équipement disponible pour la maintenance</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach($equipments as $equipment)
                    @unless($equipment->status === 'broken')
                        <a href="{{ route('user.maintenance.create', $equipment) }}"
                           class="block border rounded-lg p-4 hover:bg-gray-50 transition {{ $equipment->status === 'broken' ? 'opacity-50 cursor-not-allowed' : '' }}">
                            <div class="flex items-center gap-4">
                                <div class="bg-blue-100 p-3 rounded-lg">
                                    <i class="bi bi-pc-display text-xl text-blue-600"></i>
                                </div>
                                <div>
                                    <h3 class="font-medium">{{ $equipment->name }}</h3>
                                    <p class="text-sm text-gray-500">
                                        {{ optional($equipment->type)->name ?? 'Non spécifié' }}
                                    </p>
                                </div>
                            </div>
                        </a>
                    @endunless
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection