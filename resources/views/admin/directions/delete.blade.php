<!-- resources/views/admin/directions/delete.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-6">
        <h1 class="text-4xl font-semibold mb-4">Êtes-vous sûr de vouloir supprimer cette direction ?</h1>

        <div class="bg-white p-6 shadow-md rounded-md">
            <h2 class="text-xl font-medium mb-2">Nom de la Direction</h2>
            <p class="text-gray-700">{{ $direction->name }}</p>
        </div>

        <div class="mt-6">
            <form action="{{ route('admin.directions.delete', $direction->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-500 text-white px-6 py-3 rounded-md hover:bg-red-600 transition duration-300">Supprimer la Direction</button>
            </form>

            <a href="{{ route('admin.directions.index') }}" class="ml-4 text-blue-500 hover:underline">Annuler</a>
        </div>
    </div>
@endsection
