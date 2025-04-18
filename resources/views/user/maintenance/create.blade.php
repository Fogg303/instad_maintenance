@extends('layouts.base_user')

@section('title', 'Nouvelle demande')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-8 animate-fade-in-up">
    <div class="bg-white rounded-2xl shadow-lg p-6 md:p-8 transition-all duration-300 hover:shadow-xl">
        <!-- Header avec effet de profondeur -->
        <div class="flex items-center justify-between mb-8 pb-4 border-b border-gray-100">
            <div class="flex items-center space-x-4">
                <div class="p-3 bg-userPrimary/10 rounded-xl">
                    <i class="bi bi-tools text-2xl text-userPrimary"></i>
                </div>
                <h1 class="text-2xl font-bold text-gray-800">
                    Maintenance pour 
                    <span class="text-userPrimary">{{ $equipment->name }}</span>
                </h1>
            </div>
            <a href="{{ route('user.maintenance.index') }}" 
               class="flex items-center space-x-2 text-gray-500 hover:text-userPrimary transition-colors">
                <i class="bi bi-arrow-left-short text-lg"></i>
                <span class="font-medium">Retour</span>
            </a>
        </div>

        <form action="{{ route('user.maintenance.store', $equipment) }}" 
              method="POST" 
              enctype="multipart/form-data"
              x-data="{ isSubmitting: false }"
              @submit="isSubmitting = true">
            @csrf

            <div class="space-y-8">
                <!-- Description -->
                <div class="relative">
                    <label class="block mb-2 text-sm font-medium text-gray-700">
                        <i class="bi bi-card-text mr-1"></i>
                        Description détaillée *
                    </label>
                    <textarea name="description" 
                        rows="5"
                        required
                        class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-userPrimary focus:ring-2 focus:ring-userPrimary/20 transition-all"
                        placeholder="Décrire précisément le problème rencontré..."
                        x-input></textarea>
                    @error('description')
                        <p class="mt-2 text-sm text-red-600"><i class="bi bi-exclamation-circle mr-1"></i>{{ $message }}</p>
                    @enderror
                </div>

                <!-- Priorité -->
                <div class="relative">
                    <label class="block mb-2 text-sm font-medium text-gray-700">
                        <i class="bi bi-exclamation-triangle mr-1"></i>
                        Niveau de priorité *
                    </label>
                    <select name="priority" 
                        x-model="priority"
                        class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-userPrimary focus:ring-2 focus:ring-userPrimary/20 appearance-none bg-[url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxNiIgaGVpZ2h0PSIxNiIgZmlsbD0iY3VycmVudENvbG9yIiBjbGFzcz0iYmkgYmktY2hldnJvbi1kb3duIiB2aWV3Qm94PSIwIDAgMTYgMTYiPgogIDxwYXRoIGZpbGwtcnVsZT0iZXZlbm9kZCIgZD0iTTEuNjQ2IDQuNjQ2YS41LjUgMCAwIDEgLjcwOCAwTDggMTAuMjkzbDUuNjQ2LTUuNjQ3YS41LjUgMCAwIDEgLjcwOC43MDhsLTYgNmEuNS41IDAgMCAxLS43MDggMGwtNi02YS41LjUgMCAwIDEgMC0uNzA4eiIvPgo8L3N2Zz4K')] bg-no-repeat bg-[right_1rem_center] bg-[length:14px_14px] cursor-pointer transition-colors"
                        :class="{
                            'border-red-200': priority === 'high',
                            'border-amber-200': priority === 'medium',
                            'border-blue-200': priority === 'low'
                        }">
                        @foreach($priorities as $key => $label)
                            <option value="{{ $key }}" 
                                    class="{{ $key === 'high' ? 'text-red-600' : '' }}
                                           {{ $key === 'medium' ? 'text-amber-600' : '' }}
                                           {{ $key === 'low' ? 'text-blue-600' : '' }}">
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                    @error('priority')
                        <p class="mt-2 text-sm text-red-600"><i class="bi bi-exclamation-circle mr-1"></i>{{ $message }}</p>
                    @enderror
                </div>

                <!-- Upload de fichiers -->
                <div class="relative"
                     x-data="{ files: [] }"
                     x-on:livewire-upload-start="isUploading = true"
                     x-on:livewire-upload-finish="isUploading = false"
                     x-on:livewire-upload-error="isUploading = false">
                    <label class="block mb-2 text-sm font-medium text-gray-700">
                        <i class="bi bi-paperclip mr-1"></i>
                        Fichiers joints
                    </label>
                    <div class="relative border-2 border-dashed border-gray-200 rounded-xl p-8 text-center transition-colors hover:border-userPrimary"
                         @dragover.prevent="$event.dataTransfer.dropEffect = 'copy';"
                         @drop.prevent="files = Array.from($event.dataTransfer.files)">
                        <input type="file" 
                               name="attachments[]" 
                               multiple
                               class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                               x-on:change="files = Array.from($event.target.files)">
                        
                        <div class="space-y-2">
                            <i class="bi bi-cloud-arrow-up text-3xl text-gray-400"></i>
                            <p class="text-sm text-gray-500">
                                Glissez-déposez vos fichiers ou 
                                <span class="text-userPrimary font-medium">parcourir</span>
                            </p>
                            <p class="text-xs text-gray-400">Formats supportés : JPG, PNG, PDF (max 2Mo)</p>
                        </div>
                    </div>
                    
                    <!-- Liste des fichiers -->
                    <template x-if="files.length > 0">
                        <div class="mt-4 space-y-2">
                            <div class="text-sm text-gray-600">Fichiers sélectionnés :</div>
                            <div class="flex flex-wrap gap-2">
                                <template x-for="(file, index) in files" :key="index">
                                    <div class="px-3 py-1.5 bg-gray-100 rounded-full text-sm flex items-center space-x-2">
                                        <span x-text="file.name"></span>
                                        <button type="button" 
                                                @click="files.splice(index, 1)"
                                                class="text-gray-400 hover:text-red-500">
                                            <i class="bi bi-x text-sm"></i>
                                        </button>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </template>
                </div>

                <!-- Bouton de soumission -->
                <div class="pt-6 border-t border-gray-100">
                    <button type="submit" 
                            class="w-full md:w-auto px-8 py-3.5 bg-gradient-to-r from-userPrimary to-userDark hover:to-userPrimary text-white rounded-xl font-medium transition-all transform hover:scale-[1.02] shadow-md hover:shadow-lg flex items-center justify-center space-x-2"
                            :disabled="isSubmitting"
                            :class="{ 'opacity-75 cursor-wait': isSubmitting }">
                        <i class="bi bi-send-check" x-show="!isSubmitting"></i>
                        <i class="bi bi-arrow-repeat animate-spin" x-show="isSubmitting"></i>
                        <span x-text="isSubmitting ? 'Envoi en cours...' : 'Soumettre la demande'"></span>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Script Alpine pour les interactions -->
<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endsection