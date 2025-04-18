@php use App\Models\Equipment; @endphp
@extends('layouts.base_user')

@section('title', $equipment->exists ? 'Modifier l\'équipement' : 'Nouvel équipement')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    <!-- En-tête -->
    <div class="bg-gradient-to-r from-blue-600 to-blue-500 rounded-t-2xl p-6 mb-8 shadow-lg">
        <h1 class="text-2xl font-bold text-white flex items-center space-x-3">
            <i class="bi bi-pc-display text-3xl"></i>
            <span>{{ $equipment->exists ? 'Modifier' : 'Ajouter' }} un équipement</span>
        </h1>
    </div>

    <form action="{{ $action }}" method="POST" enctype="multipart/form-data" 
          x-data="{
              loadingCharacteristics: false,
              selectedType: '{{ old('type_id', $equipment->type_id) }}',
              characteristics: [],
              async loadCharacteristics() {
                  if(!this.selectedType) {
                      this.characteristics = [];
                      return;
                  }
                  this.loadingCharacteristics = true;
                  try {
                      const response = await fetch(`/api/equipment-types/${this.selectedType}/characteristics`);
                      this.characteristics = await response.json();
                  } catch (error) {
                      console.error('Erreur:', error);
                      this.characteristics = [];
                  }
                  this.loadingCharacteristics = false;
              }
          }"
          x-init="if(selectedType) loadCharacteristics()"
          class="bg-white rounded-b-2xl shadow-xl p-6 md:p-8 space-y-8">
        @csrf
        @method($method)

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Colonne de gauche -->
            <div class="space-y-6">
                <!-- Carte Informations de Base -->
                <div class="bg-gray-50 p-6 rounded-xl border border-blue-100">
                    <h2 class="text-lg font-semibold text-blue-800 mb-4 flex items-center">
                        <i class="bi bi-info-circle mr-2"></i>
                        Informations générales
                    </h2>

                    <!-- Nom -->
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700">Nom *</label>
                        <input type="text" name="name" required 
                               value="{{ old('name', $equipment->name) }}"
                               class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition-all">
                        @error('name')<p class="text-sm text-red-600 mt-1"><i class="bi bi-exclamation-circle mr-1"></i>{{ $message }}</p>@enderror
                    </div>

                    <!-- Type -->
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700">Type *</label>
                        <select name="type_id" x-model="selectedType" @change="loadCharacteristics()"
                                class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition-all appearance-none bg-select-arrow">
                            <option value="">Sélectionnez un type</option>
                            @foreach($types as $type)
                            <option value="{{ $type->id }}" {{ old('type_id', $equipment->type_id) == $type->id ? 'selected' : '' }}>
                                {{ $type->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('type_id')<p class="text-sm text-red-600 mt-1"><i class="bi bi-exclamation-circle mr-1"></i>{{ $message }}</p>@enderror
                    </div>
                </div>

                <!-- Carte Statut -->
                <div class="bg-gray-50 p-6 rounded-xl border border-blue-100">
                    <h2 class="text-lg font-semibold text-blue-800 mb-4 flex items-center">
                        <i class="bi bi-clipboard-check mr-2"></i>
                        État de l'équipement
                    </h2>

                    <div class="grid grid-cols-2 gap-3">
                        @foreach(Equipment::STATUSES as $key => $status)
                        <label class="relative flex items-center p-3 rounded-lg border-2 cursor-pointer transition-all 
                                    {{ old('status', $equipment->status) == $key ? 'border-blue-500 bg-blue-50' : 'border-gray-200 hover:border-blue-200' }}">
                            <input type="radio" name="status" value="{{ $key }}" 
                                   {{ old('status', $equipment->status) == $key ? 'checked' : '' }}
                                   class="sr-only">
                            <div class="flex-1">
                                <div class="text-sm font-medium text-gray-700">{{ $status }}</div>
                            </div>
                            <i class="bi bi-check2-circle text-blue-500 ml-2" x-show="$el.previousElementSibling.checked"></i>
                        </label>
                        @endforeach
                    </div>
                    @error('status')<p class="text-sm text-red-600 mt-2"><i class="bi bi-exclamation-circle mr-1"></i>{{ $message }}</p>@enderror
                </div>
            </div>

            <!-- Colonne de droite -->
            <div class="space-y-6">
                <!-- Carte Métadonnées -->
                <div class="bg-gray-50 p-6 rounded-xl border border-blue-100">
                    <h2 class="text-lg font-semibold text-blue-800 mb-4 flex items-center">
                        <i class="bi bi-calendar2-date mr-2"></i>
                        Métadonnées
                    </h2>

                    <!-- Date d'acquisition -->
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700">Date d'acquisition *</label>
                        <input type="date" name="acquisition_date" required
                               value="{{ old('acquisition_date', optional($equipment->acquisition_date)->format('Y-m-d') )}}"
                               class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition-all">
                        @error('acquisition_date')<p class="text-sm text-red-600 mt-1"><i class="bi bi-exclamation-circle mr-1"></i>{{ $message }}</p>@enderror
                    </div>

                    <!-- Code -->
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700">Identifiant unique</label>
                        <div class="px-4 py-3 bg-gray-100 rounded-lg text-gray-600">
                            {{ $equipment->code ?? 'Généré après enregistrement' }}
                        </div>
                    </div>
                </div>

                <!-- Carte Photo -->
                <div class="bg-gray-50 p-6 rounded-xl border border-blue-100" 
                     x-data="{ showPreview: {{ $equipment->photo_url ? 'true' : 'false' }} }">
                    <h2 class="text-lg font-semibold text-blue-800 mb-4 flex items-center">
                        <i class="bi bi-camera mr-2"></i>
                        Visuel de l'équipement
                    </h2>

                    <!-- Prévisualisation -->
                    <template x-if="showPreview">
                        <div class="mb-4 relative group">
                            <img src="{{ $equipment->photo_url ?? '' }}" 
                                 class="w-full h-40 object-cover rounded-lg border-2 border-dashed border-blue-200">
                            <button type="button" @click="showPreview = false" 
                                    class="absolute top-2 right-2 bg-white/90 p-1.5 rounded-full shadow-sm hover:bg-red-100 transition-colors">
                                <i class="bi bi-x-lg text-red-600 text-sm"></i>
                            </button>
                        </div>
                    </template>

                    <!-- Upload -->
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center cursor-pointer transition-colors hover:border-blue-400"
                         @click="$refs.photoInput.click()"
                         @dragover.prevent="$event.dataTransfer.dropEffect = 'copy'"
                         @drop.prevent="showPreview = true; $refs.photoInput.files = $event.dataTransfer.files">
                        <input type="file" name="photo" id="photo" x-ref="photoInput" class="hidden"
                               @change="showPreview = !!$refs.photoInput.files.length">
                        
                        <div class="space-y-2">
                            <i class="bi bi-cloud-arrow-up text-3xl text-gray-400"></i>
                            <p class="text-sm text-gray-600">
                                Glissez votre photo ici ou<br>
                                <span class="text-blue-600 font-medium">cliquez pour choisir</span>
                            </p>
                            <p class="text-xs text-gray-400">JPEG, PNG - 5MB max</p>
                        </div>
                    </div>
                    @error('photo')<p class="text-sm text-red-600 mt-2"><i class="bi bi-exclamation-circle mr-1"></i>{{ $message }}</p>@enderror
                </div>
            </div>
        </div>

        <!-- Section Caractéristiques -->
        <div class="bg-gray-50 p-6 rounded-xl border border-blue-100">
            <h2 class="text-lg font-semibold text-blue-800 mb-4 flex items-center">
                <i class="bi bi-gear-wide-connected mr-2"></i>
                Caractéristiques techniques
            </h2>
            
            <div id="characteristics-container" class="space-y-4">
                <!-- Chargement -->
                <template x-if="loadingCharacteristics">
                    <div class="text-center py-4">
                        <i class="bi bi-arrow-repeat animate-spin text-2xl text-blue-600"></i>
                    </div>
                </template>

                <!-- Aucune caractéristique -->
                <template x-if="!loadingCharacteristics && characteristics.length === 0 && !{{ $equipment->exists ? 'true' : 'false' }}">
                    <p class="text-gray-500 text-center py-4">
                        Sélectionnez un type d'équipement pour voir ses caractéristiques
                    </p>
                </template>

                <!-- Caractéristiques dynamiques -->
                <template x-for="char in characteristics" :key="char.id">
                    <div class="animate-fade-in">
                        <label class="block text-sm font-medium text-gray-700 mb-1" x-text="char.name + (char.data_type === 'boolean' ? '' : ' (' + char.data_type + ')')"></label>
                        <template x-if="char.data_type === 'boolean'">
                            <label class="inline-flex items-center mt-2">
                                <input type="checkbox" 
                                       :name="`characteristics[${char.id}]`"
                                       class="form-checkbox h-5 w-5 text-blue-600 rounded transition-all"
                                       :checked="char.default_value === '1'">
                                <span class="ml-2 text-gray-600">Activé</span>
                            </label>
                        </template>
                        <template x-if="char.data_type !== 'boolean'">
                            <input :type="char.data_type === 'date' ? 'date' : char.data_type === 'number' ? 'number' : 'text'"
                                   :name="`characteristics[${char.id}]`"
                                   :step="char.data_type === 'number' ? '0.01' : null"
                                   :value="char.default_value"
                                   class="w-full px-4 py-2 rounded-lg border-2 border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition-all">
                        </template>
                    </div>
                </template>

                <!-- Caractéristiques existantes (édition) -->
                @if($equipment->exists)
                    @foreach($equipment->characteristicValues as $charValue)
                        <div class="animate-fade-in">
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                {{ $charValue->characteristic->name }}
                            </label>
                            <input type="text" 
                                   name="characteristics[{{ $charValue->characteristic_id }}]"
                                   value="{{ old("characteristics.{$charValue->characteristic_id}", $charValue->value) }}"
                                   class="w-full px-4 py-2 rounded-lg border-2 border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition-all">
                        </div>
                    @endforeach
                @endif
            </div>
        </div>

        <!-- Actions -->
        <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
            <a href="{{ route('user.equipments.index') }}" 
               class="px-6 py-3 text-gray-600 hover:text-blue-600 transition-colors font-medium">
                Annuler
            </a>
            <button type="submit" 
                    class="px-8 py-3.5 bg-gradient-to-r from-blue-600 to-blue-500 hover:to-blue-600 text-white 
                           rounded-xl font-medium shadow-lg hover:shadow-xl transition-all flex items-center">
                <i class="bi bi-check2-circle mr-2"></i>
                {{ $equipment->exists ? 'Mettre à jour' : 'Créer l\'équipement' }}
            </button>
        </div>
    </form>
</div>

<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endsection