@extends('layouts.base_user')
@section('title', 'Détails de l\'équipement')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    <div class="bg-white rounded-xl shadow-lg p-6">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-900">{{ $equipment->name }}</h1>
            <a href="{{ route('user.equipments.index') }}" class="text-userPrimary hover:text-userDark">
                <i class="bi bi-arrow-left"></i> Retour
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Détails de base -->
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-500">Code</label>
                    <p class="mt-1 text-gray-900">{{ $equipment->code }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500">Type</label>
                    <p class="mt-1 text-gray-900">{{ $equipment->type->name }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500">Statut</label>
                    <span class="mt-1 inline-flex items-center px-2.5 py-0.5 rounded-full text-sm font-medium 
                          {{ $equipment->status === 'new' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ config("equipment.statuses.{$equipment->status}") }}
                    </span>
                </div>
            </div>

            <!-- Caractéristiques techniques -->
            <div class="border-t md:border-t-0 md:border-l pt-4 md:pt-0 md:pl-6">
                <h3 class="text-lg font-semibold mb-4">Spécifications</h3>
                <dl class="space-y-3">
                    @foreach($equipment->characteristicValues as $value)
                    <div class="flex justify-between">
                        <dt class="text-gray-500">{{ $value->characteristic->name }}</dt>
                        <dd class="text-gray-900">{{ $value->value }}</dd>
                    </div>
                    @endforeach
                </dl>
            </div>
        </div>
    </div>
</div>
@endsection