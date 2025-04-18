@extends('layouts.base_user')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">
        {{ $equipment->exists ? 'Modifier' : 'Ajouter' }} un équipement
    </h1>
    
    <form action="{{ $action }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-lg shadow-md">
        @csrf
        @method($method)

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Champ Nom -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Nom *</label>
                <input type="text" name="name" id="name" required value="{{ old('name', $equipment->name) }}"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <!-- Champ Code (lecture seule) -->
            <div>
                <label for="code" class="block text-sm font-medium text-gray-700">Code</label>
                <input type="text" id="code" value="{{ $equipment->code ?? 'Généré automatiquement' }}" 
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm bg-gray-100" readonly>
            </div>

            <!-- Champ Type -->
            <div>
                <label for="type_id" class="block text-sm font-medium text-gray-700">Type *</label>
                <select name="type_id" id="type_id" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="">Sélectionnez un type</option>
                    @foreach($types as $type)
                        <option value="{{ $type->id }}" {{ old('type_id', $equipment->type_id) == $type->id ? 'selected' : '' }}>
                            {{ $type->name }}
                        </option>
                    @endforeach
                </select>
                @error('type_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <!-- Champ Statut -->
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700">Statut *</label>
                <select name="status" id="status" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    @foreach($statuses as $key => $status)
                        <option value="{{ $key }}" {{ old('status', $equipment->status) == $key ? 'selected' : '' }}>
                            {{ $status }}
                        </option>
                    @endforeach
                </select>
                @error('status') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <!-- Champ Date d'acquisition -->
            <div>
                <label for="acquisition_date" class="block text-sm font-medium text-gray-700">Date d'acquisition *</label>
                <input type="date" name="acquisition_date" id="acquisition_date" required
                value="{{ old('acquisition_date', optional($equipment->acquisition_date)->format('Y-m-d')) }}"       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                @error('acquisition_date') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <!-- Champ Photo -->
            <div>
                <label for="photo" class="block text-sm font-medium text-gray-700">Photo</label>
                @if($equipment->photo_path)
                    <div class="mb-2">
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="remove_photo" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                            <span class="ml-2 text-sm text-gray-600">Supprimer la photo</span>
                        </label>
                    </div>
                @endif
                <input type="file" name="photo" id="photo"
                       class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                @error('photo') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        <!-- Caractéristiques dynamiques -->
        <div id="characteristics-container" class="mt-6 space-y-4">
            @if($equipment->exists && $equipment->characteristicValues->isNotEmpty())
                @foreach($equipment->characteristicValues as $charValue)
                    <div>
                        <label class="block text-sm font-medium text-gray-700">
                            {{ $charValue->characteristic->name }}
                        </label>
                        <input type="text" 
                               name="characteristics[{{ $charValue->characteristic_id }}]"
                               value="{{ old("characteristics.{$charValue->characteristic_id}", $charValue->value) }}"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                @endforeach
            @endif
        </div>

        <div class="mt-8 flex justify-end space-x-4">
            <a href="{{ route('user.equipments.index') }}" class="px-4 py-2 bg-gray-300 text-gray-800 rounded-md hover:bg-gray-400">
                Annuler
            </a>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                {{ $equipment->exists ? 'Mettre à jour' : 'Créer' }}
            </button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const typeSelect = document.getElementById('type_id');
    const container = document.getElementById('characteristics-container');

    async function loadCharacteristics(typeId) {
        if (!typeId) {
            container.innerHTML = '';
            return;
        }

        try {
            const response = await fetch(`/api/equipment-types/${typeId}/characteristics`);
            const characteristics = await response.json();
            
            let html = '';
            characteristics.forEach(char => {
                html += `
                <div>
                    <label class="block text-sm font-medium text-gray-700">${char.name}</label>
                    <input type="text" name="characteristics[${char.id}]"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>
                `;
            });
            container.innerHTML = html;
        } catch (error) {
            console.error('Erreur lors du chargement des caractéristiques:', error);
        }
    }

    typeSelect.addEventListener('change', () => loadCharacteristics(typeSelect.value));
    
    // Charger au démarrage si valeur existante
    if (typeSelect.value) {
        loadCharacteristics(typeSelect.value);
    }
});
</script>
@endsection