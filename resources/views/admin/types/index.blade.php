@extends('layouts.base_admin')

@section('content')
<div class="container mx-auto px-4">
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-instaddark">Gestion des Types d'Équipements</h2>
            <a href="{{ route('admin.equipment-types.create') }}" class="bg-instadblue text-white px-4 py-2 rounded hover:bg-instadsecondary">
                <i class="bi bi-plus-circle mr-2"></i>Nouveau Type
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nom</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Caractéristiques</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Statut</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($types as $type)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $type->name }}</td>
                        <td class="px-6 py-4">
                            @foreach($type->characteristics as $char)
                            <span class="bg-blue-100 text-blue-800 text-sm font-medium mr-2 px-2.5 py-0.5 rounded">
                                {{ $char->name }} ({{ $char->data_type }})
                            </span>
                            @endforeach
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                {{ $type->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $type->is_active ? 'Actif' : 'Inactif' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex space-x-2">
                                <a href="{{ route('admin.equipment-types.edit', $type) }}" 
                                   class="text-instadblue hover:text-instaddark">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <form action="{{ route('admin.equipment-types.destroy', $type) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection