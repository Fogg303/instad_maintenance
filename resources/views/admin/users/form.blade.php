@extends('layouts.base_admin')

@section('title', $user->exists ? 'Modifier Utilisateur' : 'Créer Utilisateur')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-6">
    <!-- En-tête -->
    <div class="flex items-center justify-between mb-8">
        <div class="flex items-center">
            <div class="bg-indigo-100 p-3 rounded-full mr-4">
                <i class="bi bi-person-{{ $user->exists ? 'gear' : 'plus' }} text-indigo-600 text-xl"></i>
            </div>
            <h1 class="text-2xl font-bold text-gray-800">
                {{ $user->exists ? 'Modifier l\'utilisateur' : 'Créer un nouvel utilisateur' }}
            </h1>
        </div>
        <a href="{{ route('admin.users.index') }}" class="text-gray-500 hover:text-gray-700">
            <i class="bi bi-x-lg text-2xl"></i>
        </a>
    </div>

    <!-- Formulaire -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100">
        <form method="POST" action="{{ $user->exists ? route('admin.users.update', $user) : route('admin.users.store') }}">
            @csrf
            @if($user->exists) @method('PUT') @endif

            <div class="p-6 space-y-6">
                <!-- Grille responsive -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Colonne gauche -->
                    <div class="space-y-6">
                        <!-- Nom -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nom complet</label>
                            <input type="text" id="name" name="name" 
                                   value="{{ old('name', $user->name) }}"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
                                   required>
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                            <input type="email" id="email" name="email"
                                   value="{{ old('email', $user->email) }}"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
                                   required>
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Colonne droite -->
                    <div class="space-y-6">
                        <!-- Rôle -->
                        <div>
                            <label for="role" class="block text-sm font-medium text-gray-700 mb-1">Rôle</label>
                            <select id="role" name="role" 
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
                                    required>
                                @foreach($roles as $value => $label)
                                    <option value="{{ $value }}" 
                                        {{ old('role', $user->role) === $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                            @error('role')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Direction -->
                        <div>
                            <label for="direction_id" class="block text-sm font-medium text-gray-700 mb-1">Direction</label>
                            <select id="direction_id" name="direction_id" 
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                                <option value="">Non assigné</option>
                                @foreach($directions as $direction)
                                    <option value="{{ $direction->id }}"
                                        {{ old('direction_id', $user->direction_id) == $direction->id ? 'selected' : '' }}>
                                        {{ $direction->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('direction_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Mot de passe -->
                <div class="pt-6 border-t border-gray-200 space-y-6">
                    <h3 class="text-lg font-medium text-gray-900 flex items-center">
                        <i class="bi bi-shield-lock mr-2 text-indigo-500"></i>
                        {{ $user->exists ? 'Changer le mot de passe' : 'Définir le mot de passe' }}
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Mot de passe -->
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
                                {{ $user->exists ? 'Nouveau mot de passe' : 'Mot de passe' }}
                            </label>
                            <input type="password" id="password" name="password"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
                                   {{ $user->exists ? '' : 'required' }}>
                            @error('password')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Confirmation -->
                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">
                                Confirmation
                            </label>
                            <input type="password" id="password_confirmation" 
                                   name="password_confirmation"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
                                   {{ $user->exists ? '' : 'required' }}>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pied de page -->
            <div class="bg-gray-50 px-6 py-4 flex justify-end space-x-4 border-t border-gray-200">
                <a href="{{ route('admin.users.index') }}" 
                   class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-100 transition-colors">
                    Annuler
                </a>
                <button type="submit" 
                        class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors flex items-center">
                    <i class="bi bi-check-circle mr-2"></i>
                    {{ $user->exists ? 'Mettre à jour' : 'Créer l\'utilisateur' }}
                </button>
            </div>
        </form>
    </div>
</div>

<style>
    /* Animation des champs */
    input, select {
        transition: all 0.2s ease;
    }
    
    /* Style des erreurs */
    .text-red-600 {
        color: #dc2626;
    }
    
    /* Style des icônes */
    .bi {
        display: inline-block;
        vertical-align: middle;
    }
</style>
@endsection