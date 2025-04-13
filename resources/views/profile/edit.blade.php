@php
    $layout = match(auth()->user()->role) {
        'admin' => 'layouts.base_admin',
        'technician' => 'layouts.base_technician',
        default => 'layouts.base_user'
    };
@endphp

@extends($layout)

@section('title', 'Gestion du Profil')

@section('content')
<div class="bg-white rounded-xl shadow-sm overflow-hidden max-w-2xl mx-auto mt-8">
    <!-- En-tête -->
    <div class="px-6 py-4 border-b flex items-center bg-gray-50">
        <i class="bi bi-person-gear text-userPrimary mr-2"></i>
        <h3 class="text-lg font-semibold">Modifier votre profil</h3>
    </div>

    <!-- Contenu -->
    <div class="p-6 space-y-8">
        <!-- Messages de statut -->
        @if(session('status') || session('success'))
        <div class="p-4 bg-green-100 border-l-4 border-green-500 text-green-700 rounded-lg">
            {{ session('status') ?? session('success') }}
        </div>
        @endif

        <!-- Information du profil -->
        <div class="space-y-6">
            <div class="flex items-center gap-3 text-userPrimary">
                <i class="bi bi-person-circle text-xl"></i>
                <h4 class="text-lg font-medium">Informations personnelles</h4>
            </div>
            @include('profile.update-profile-information-form')
        </div>

        <!-- Mot de passe -->
        <div class="space-y-6 pt-6 border-t">
            <div class="flex items-center gap-3 text-userPrimary">
                <i class="bi bi-shield-lock text-xl"></i>
                <h4 class="text-lg font-medium">Sécurité du compte</h4>
            </div>
            @include('profile.update-password-form')
        </div>

        <!-- Suppression du compte -->
        <div class="space-y-6 pt-6 border-t">
            <div class="flex items-center gap-3 text-red-500">
                <i class="bi bi-trash3 text-xl"></i>
                <h4 class="text-lg font-medium">Zone dangereuse</h4>
            </div>
            @include('profile.delete-user-form')
        </div>
    </div>
</div>
@endsection