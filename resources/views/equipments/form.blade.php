@extends('base_user')

@section('content')
<div class="container mx-auto px-4">
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-2xl font-bold text-userDark mb-6">{{ isset($equipment) ? 'Modifier' : 'Nouvel' }} Équipement</h2>
        
        <form method="POST" action="{{ isset($equipment) ? route('equipments.update', $equipment) : route('equipments.store') }}">
            @csrf
            @isset($equipment) @method('PUT') @endisset

            <!-- Dynamic Fields Implementation -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Type d'équipement</label>
                <select name="type_id" id="typeSelect" class="w-full px-3 py-2 border rounded" required
                    x-data="{ characteristics: [] }"
                    @change="fetch(`/api/equipment-types/${$event.target.value}/characteristics`)
                        .then(r => r.json())
                        .then(data => characteristics = data)">
                    
                    @foreach($types as $type)
                    <option value="{{ $type->id }}" 
                        {{ (isset($equipment) && $equipment->type_id === $type->id) ? 'selected' : '' }}>
                        {{ $type->name }}
                    </option>
                    @endforeach
                </select>
            </div>

            <!-- Dynamic Characteristics -->
            <div class="mb-4" x-show="characteristics.length > 0">
                <template x-for="char in characteristics" :key="char.id">
                    <div class="mb-3">
                        <label class="block text-gray-700 text-sm font-bold mb-2" x-text="char.name"></label>
                        <template x-if="char.data_type === 'number'">
                            <input type="number" :name="`characteristics[${char.id}]`" 
                                   class="w-full px-3 py-2 border rounded" step="0.01" required>
                        </template>
                        <!-- Ajouter les autres types de champs -->
                    </div>
                </template>
            </div>

            <!-- Reste du formulaire -->
            <div class="flex justify-end mt-6">
                <button type="submit" class="bg-userPrimary text-white px-6 py-2 rounded hover:bg-userSecondary">
                    Enregistrer
                </button>
            </div>
        </form>
    </div>
</div>
@endsection