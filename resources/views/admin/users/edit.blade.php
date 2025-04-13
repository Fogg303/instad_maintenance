@extends('layouts.base_admin')

@section('title', 'Modifier Utilisateur')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- En-tête -->
    <div class="flex items-center justify-between mb-8">
        <div class="flex items-center space-x-4">
            <div class="p-3 bg-indigo-100 rounded-full">
                <i class="bi bi-person-gear text-indigo-600 text-xl"></i>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Modifier l'utilisateur</h1>
                <p class="text-sm text-gray-500">Mettez à jour les informations de l'utilisateur</p>
            </div>
        </div>
        <a href="{{ route('admin.users.index') }}" class="btn-secondary">
            <i class="bi bi-arrow-left mr-2"></i> Retour
        </a>
    </div>

    <!-- Carte du formulaire -->
    <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-gray-200">
        <form method="POST" action="{{ route('admin.users.update', $user) }}">
            @csrf
            @method('PUT')

            <!-- Contenu du formulaire -->
            <div class="p-6 space-y-8">
                <!-- Section informations de base -->
                <div class="space-y-6">
                    <h3 class="text-lg font-medium text-gray-900 flex items-center">
                        <i class="bi bi-info-circle mr-2 text-indigo-500"></i>
                        Informations de base
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Nom -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nom complet *</label>
                            <input type="text" id="name" name="name" 
                                   value="{{ old('name', $user->name) }}"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-200"
                                   required>
                            @error('name')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                            <input type="email" id="email" name="email"
                                   value="{{ old('email', $user->email) }}"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-200"
                                   required>
                            @error('email')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Section rôle et direction -->
                <div class="space-y-6">
                    <h3 class="text-lg font-medium text-gray-900 flex items-center">
                        <i class="bi bi-person-badge mr-2 text-indigo-500"></i>
                        Rôle et affectation
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Rôle -->
                        <div>
                            <label for="role" class="block text-sm font-medium text-gray-700 mb-2">Rôle *</label>
                            <select id="role" name="role" 
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-200"
                                    required>
                                <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Administrateur</option>
                                <option value="technician" {{ old('role', $user->role) === 'technician' ? 'selected' : '' }}>Technicien</option>
                                <option value="user" {{ old('role', $user->role) === 'user' ? 'selected' : '' }}>Utilisateur</option>
                            </select>
                            @error('role')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Direction -->
                        <div>
                            <label for="direction_id" class="block text-sm font-medium text-gray-700 mb-2">Direction</label>
                            <select id="direction_id" name="direction_id" 
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-200">
                                <option value="">Non assigné</option>
                                @foreach($directions as $direction)
                                    <option value="{{ $direction->id }}"
                                        {{ old('direction_id', $user->direction_id) == $direction->id ? 'selected' : '' }}>
                                        {{ $direction->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('direction_id')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Section mot de passe -->
                <div class="space-y-6 pt-6 border-t border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900 flex items-center">
                        <i class="bi bi-shield-lock mr-2 text-indigo-500"></i>
                        Modifier le mot de passe
                    </h3>
                    <p class="text-sm text-gray-500">Laissez vide pour conserver le mot de passe actuel</p>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Nouveau mot de passe -->
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Nouveau mot de passe</label>
                            <input type="password" id="password" name="password"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-200">
                            @error('password')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Confirmation -->
                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Confirmer le mot de passe</label>
                            <input type="password" id="password_confirmation" 
                                   name="password_confirmation"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-200">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="bg-gray-50 px-6 py-4 flex justify-between items-center border-t border-gray-200">
                <div>
                    @if($user->created_at)
                        <p class="text-xs text-gray-500">
                            Créé le {{ $user->created_at->format('d/m/Y à H:i') }}
                            @if($user->updated_at->gt($user->created_at))
                                <br>Dernière modification le {{ $user->updated_at->format('d/m/Y à H:i') }}
                            @endif
                        </p>
                    @endif
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('admin.users.index') }}" class="btn-secondary">
                        Annuler
                    </a>
                    <button type="submit" class="btn-primary">
                        <i class="bi bi-check-circle mr-2"></i>
                        Enregistrer les modifications
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<style>
    /* Styles personnalisés */
    .btn-primary {
        @apply px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors duration-200 flex items-center;
    }
    .btn-secondary {
        @apply px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-100 transition-colors duration-200;
    }
    /* Animation des champs */
    input, select {
        transition: all 0.2s ease;
    }
    /* Effet de focus */
    .focus\:ring-indigo-500:focus {
        box-shadow: 0 0 0 2px rgba(99, 102, 241, 0.25);
    }
</style>
@endsection