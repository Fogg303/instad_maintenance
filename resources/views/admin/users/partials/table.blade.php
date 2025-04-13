@if($users->isEmpty())
<div class="p-8 text-center bg-white rounded-2xl shadow-xl">
    <div class="inline-block mb-4 text-indigo-500">
        <i class="bi bi-search-heart text-6xl"></i>
    </div>
    <h3 class="text-2xl font-semibold text-gray-700 mb-2">Aucun résultat trouvé</h3>
    <p class="text-gray-500">Essayez avec d'autres termes de recherche</p>
</div>
@else
<table class="min-w-full divide-y divide-gray-200">
    <thead class="bg-indigo-50">
        <tr>
            <th class="px-6 py-4 text-left text-sm font-semibold text-indigo-700 uppercase tracking-wider">Nom</th>
            <th class="px-6 py-4 text-left text-sm font-semibold text-indigo-700 uppercase tracking-wider">Email</th>
            <th class="px-6 py-4 text-left text-sm font-semibold text-indigo-700 uppercase tracking-wider">Rôle</th>
            <th class="px-6 py-4 text-left text-sm font-semibold text-indigo-700 uppercase tracking-wider">Direction</th>
            <th class="px-6 py-4 text-left text-sm font-semibold text-indigo-700 uppercase tracking-wider">Actions</th>
        </tr>
    </thead>
    <tbody class="bg-white divide-y divide-gray-200">
        @foreach($users as $user)
        <tr class="hover:bg-gray-50 transition-colors">
            <td class="px-6 py-4 whitespace-nowrap text-gray-800 font-medium">{{ $user->name }}</td>
            <td class="px-6 py-4 whitespace-nowrap text-gray-600">{{ $user->email }}</td>
            <td class="px-6 py-4 whitespace-nowrap">
                <span class="px-3 py-1.5 inline-flex text-sm leading-5 font-semibold rounded-full 
                    @switch($user->role)
                        @case('admin') bg-red-100 text-red-800 @break
                        @case('technician') bg-indigo-100 text-indigo-800 @break
                        @default bg-gray-100 text-gray-800
                    @endswitch">
                    {{ $user->role }}
                </span>
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-gray-600">
                <div class="flex items-center">
                    <i class="bi bi-building mr-2 text-gray-400"></i>
                    {{ $user->direction->name ?? '-' }}
                </div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
                <div class="flex space-x-3">
                    <a href="{{ route('admin.users.edit', $user) }}" 
                       class="text-indigo-500 hover:text-indigo-700 transition-colors"
                       data-tooltip="Modifier">
                        <i class="bi bi-pencil-square text-lg"></i>
                    </a>
                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST">
                        @csrf @method('DELETE')
                        <button type="submit" 
                                class="text-red-500 hover:text-red-700 transition-colors"
                                data-tooltip="Supprimer"
                                onclick="return confirm('Confirmer la suppression ?')">
                            <i class="bi bi-trash text-lg"></i>
                        </button>
                    </form>
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endif