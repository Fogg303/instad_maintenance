@extends('base_user')

@section('content')
<div class="container mx-auto px-4">
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-userDark">Mes Équipements</h2>
            <a href="{{ route('equipments.create') }}" 
               class="bg-userPrimary text-white px-4 py-2 rounded hover:bg-userSecondary">
                <i class="bi bi-plus-circle mr-2"></i>Nouvel Équipement
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($equipments as $equipment)
            <div class="bg-userLight rounded-lg p-4 shadow">
                <div class="flex justify-between items-start mb-2">
                    <h3 class="text-lg font-semibold text-userDark">{{ $equipment->name }}</h3>
                    <span class="text-sm px-2 py-1 rounded 
                        {{ $equipment->status === 'new' ? 'bg-green-100 text-green-800' : 
                           ($equipment->status === 'broken' ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800') }}">
                        {{ __("status.{$equipment->status}") }}
                    </span>
                </div>
                <p class="text-sm text-gray-600 mb-2">
                    <i class="bi bi-tag mr-2"></i>{{ $equipment->code }}
                </p>
                <p class="text-sm text-gray-600">
                    <i class="bi bi-calendar mr-2"></i>
                    {{ $equipment->acquisition_date->format('d/m/Y') }}
                </p>
                <div class="mt-4 flex justify-end space-x-2">
                    <a href="{{ route('equipments.edit', $equipment) }}" 
                       class="text-userPrimary hover:text-userDark">
                        <i class="bi bi-pencil-square"></i>
                    </a>
                    <a href="{{ route('equipments.show', $equipment) }}" 
                       class="text-userPrimary hover:text-userDark">
                        <i class="bi bi-eye"></i>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection