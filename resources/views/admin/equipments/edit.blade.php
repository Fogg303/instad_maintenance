@extends('layouts.base_admin')

@section('title', 'Modifier Équipement')

@section('content')
<div class="max-w-3xl mx-auto px-6 py-8">
    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="flex justify-between items-start mb-6">
            <h2 class="text-xl font-semibold text-instaddark">Modifier {{ $equipment->name }}</h2>
            <a href="{{ route('admin.equipments.index') }}" 
               class="text-gray-500 hover:text-instaddark">
                <i class="bi bi-x-lg"></i>
            </a>
        </div>

        <form method="POST" action="{{ route('admin.equipments.update', $equipment) }}" enctype="multipart/form-data">
            @csrf @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Colonne gauche -->
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium mb-1">Code identifiant</label>
                        <input type="text" name="code" value="{{ old('code', $equipment->code) }}" 
                               class="w-full px-3 py-2 border rounded-lg focus:ring-instadBlue focus:border-instadBlue">
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1">Statut</label>
                        <select name="status" class="w-full px-3 py-2 border rounded-lg">
                            @foreach($statuses as $key => $label)
                            <option value="{{ $key }}" {{ $equipment->status === $key ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1">Type d'équipement</label>
                        <select name="equipment_type_id" class="w-full px-3 py-2 border rounded-lg">
                            @foreach($types as $type)
                            <option value="{{ $type->id }}" {{ $equipment->equipment_type_id === $type->id ? 'selected' : '' }}>
                                {{ $type->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Colonne droite -->
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium mb-1">Attribution</label>
                        <select name="user_id" class="w-full px-3 py-2 border rounded-lg">
                            <option value="">Non attribué</option>
                            @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ $equipment->user_id === $user->id ? 'selected' : '' }}>
                                {{ $user->name }} ({{ $user->direction->name ?? '-' }})
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1">Photo</label>
                        <div class="flex items-center gap-4">
                            <div class="relative">
                                @if($equipment->photo_path)
                                <img src="{{ Storage::url($equipment->photo_path) }}" 
                                     class="w-24 h-24 rounded-lg object-cover shadow-sm"
                                     id="photoPreview">
                                @else
                                <div class="w-24 h-24 bg-gray-100 rounded-lg flex items-center justify-center">
                                    <i class="bi bi-camera text-2xl text-gray-400"></i>
                                </div>
                                @endif
                                <input type="file" name="photo" id="photoInput" class="hidden">
                            </div>
                            <button type="button" onclick="document.getElementById('photoInput').click()" 
                                    class="px-3 py-2 text-sm bg-gray-100 hover:bg-gray-200 rounded-lg">
                                Changer
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Caractéristiques -->
            <div class="mt-6 pt-6 border-t border-gray-100">
                <h3 class="text-sm font-semibold mb-4">Caractéristiques techniques</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($equipment->type->characteristics as $characteristic)
                    <div>
                        <label class="block text-sm text-gray-600 mb-1">{{ $characteristic->name }}</label>
                        <input type="text" 
                               name="characteristics[{{ $characteristic->id }}]" 
                               value="{{ $equipment->characteristicValues->where('characteristic_id', $characteristic->id)->first()->value ?? '' }}" 
                               class="w-full px-3 py-2 border rounded-lg">
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <button type="submit" 
                        class="px-4 py-2 bg-instadBlue text-white rounded-lg hover:bg-blue-600">
                    Enregistrer les modifications
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const photoInput = document.getElementById('photoInput');
    const photoPreview = document.getElementById('photoPreview');

    photoInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                if (photoPreview.tagName === 'IMG') {
                    photoPreview.src = e.target.result;
                } else {
                    photoPreview.innerHTML = `<img src="${e.target.result}" 
                        class="w-24 h-24 rounded-lg object-cover shadow-sm">`;
                }
            }
            reader.readAsDataURL(file);
        }
    });
});
</script>
@endsection