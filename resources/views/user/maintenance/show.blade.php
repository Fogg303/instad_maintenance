@extends('layouts.base_user')

@section('title', 'Détails de la demande')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    <div class="bg-white rounded-xl shadow-sm p-6">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-xl font-semibold">Demande #{{ $request->id }}</h1>
            <a href="{{ route('maintenance.index') }}" class="text-userPrimary hover:text-userDark">
                <i class="bi bi-arrow-left"></i> Retour
            </a>
        </div>

        <div class="space-y-6">
            <!-- Section Équipement -->
            <div>
                <h2 class="text-lg font-semibold mb-3">Équipement concerné</h2>
                <div class="bg-gray-50 rounded-lg p-4">
                    <div class="flex items-center gap-4">
                        <div class="bg-userPrimary/10 p-3 rounded-lg">
                            <i class="bi bi-pc-display text-xl text-userPrimary"></i>
                        </div>
                        <div>
                            <h3 class="font-medium">{{ $request->equipment->name }}</h3>
                            <p class="text-sm text-gray-500">{{ $request->equipment->type->name }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Détails de la demande -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h2 class="text-lg font-semibold mb-3">Description</h2>
                    <p class="text-gray-600">{{ $request->description }}</p>
                </div>

                <div>
                    <h2 class="text-lg font-semibold mb-3">Détails techniques</h2>
                    <dl class="space-y-2">
                        <div class="flex justify-between">
                            <dt class="text-gray-500">Statut</dt>
                            <dd class="font-medium">{{ $statuses[$request->status] }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-gray-500">Priorité</dt>
                            <dd class="font-medium">{{ MaintenanceRequest::PRIORITIES[$request->priority] }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-gray-500">Date de création</dt>
                            <dd class="font-medium">{{ $request->created_at->format('d/m/Y H:i') }}</dd>
                        </div>
                    </dl>
                </div>
            </div>

            <!-- Pièces jointes -->
            @if($request->attachments->count() > 0)
            <div>
                <h2 class="text-lg font-semibold mb-3">Pièces jointes</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($request->attachments as $attachment)
                    <div class="flex items-center justify-between bg-gray-50 rounded-lg p-3">
                        <div class="flex items-center gap-3">
                            <i class="bi bi-paperclip text-userPrimary"></i>
                            <span class="text-sm">{{ $attachment->original_name }}</span>
                        </div>
                        <a href="{{ Storage::url($attachment->path) }}" 
                           download
                           class="text-userPrimary hover:text-userDark">
                            <i class="bi bi-download"></i>
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection