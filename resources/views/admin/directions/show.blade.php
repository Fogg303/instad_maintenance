<!-- resources/views/admin/directions/show.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-6">
        <h1 class="text-4xl font-semibold mb-4">Détails de la Direction</h1>

        <div class="bg-white p-6 shadow-md rounded-md">
            <h2 class="text-xl font-medium mb-2">Nom de la Direction</h2>
            <p class="text-gray-700">{{ $direction->name }}</p>
        </div>

        <div class="mt-4 text-right">
            <a href="{{ route('admin.directions.edit', $direction->id) }}" class="bg-yellow-500 text-white px-4 py-2 rounded-md hover:bg-yellow-600 transition duration-300">Modifier</a>
            <form action="{{ route('admin.directions.delete', $direction->id) }}" method="POST" class="inline-block ml-2">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600 transition duration-300">Supprimer</button>
            </form>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>