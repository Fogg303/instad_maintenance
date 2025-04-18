@extends('base_admin')

@section('content')
<div class="container mx-auto px-4">
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-2xl font-bold text-instaddark mb-6">{{ $title }}</h2>
        
        <form method="POST" action="{{ $action }}">
            @csrf
            @if(isset($method)) @method($method) @endif

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Nom du Type</label>
                <input type="text" name="name" value="{{ old('name', $type->name ?? '') }}"
                    class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-instadblue">
                @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Description</label>
                <textarea name="description" rows="3"
                    class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-instadblue">{{ old('description', $type->description ?? '') }}</textarea>
            </div>

            <div class="flex items-center justify-end mt-6">
                <button type="submit" 
                    class="bg-instadblue text-white px-6 py-2 rounded hover:bg-instadsecondary transition-colors">
                    Enregistrer
                </button>
            </div>
        </form>
    </div>
</div>
@endsection