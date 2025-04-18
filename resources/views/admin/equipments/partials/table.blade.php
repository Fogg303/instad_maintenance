<table class="w-full">
    <thead class="bg-gray-50">
        <tr>
            <th class="px-4 py-3 text-left text-sm font-medium text-instaddark">Code</th>
            <th class="px-4 py-3 text-left text-sm font-medium text-instaddark">Équipement</th>
            <th class="px-4 py-3 text-left text-sm font-medium text-instaddark">Type</th>
            <th class="px-4 py-3 text-left text-sm font-medium text-instaddark">Utilisateur</th>
            <th class="px-4 py-3 text-left text-sm font-medium text-instaddark">Statut</th>
            <th class="px-4 py-3 text-sm font-medium text-instaddark w-32">Actions</th>
        </tr>
    </thead>
    <tbody class="divide-y divide-gray-100">
        @forelse($equipments as $equipment)
        <tr class="hover:bg-gray-50 transition-colors">
            <td class="px-4 py-3 font-mono text-sm">{{ $equipment->code }}</td>
            
            <td class="px-4 py-3">
                <div class="flex items-center gap-3">
                    @if($equipment->photo_path)
                    <img src="{{ Storage::url($equipment->photo_path) }}" 
                         class="w-12 h-12 rounded-lg object-cover shadow-sm">
                    @endif
                    <div>
                        <div class="font-medium">{{ $equipment->name }}</div>
                        <div class="text-xs text-gray-500">
                            {{ $equipment->created_at->diffForHumans() }}
                        </div>
                    </div>
                </div>
            </td>
            
            <td class="px-4 py-3">
                <span class="bg-gray-100 text-gray-700 px-2 py-1 rounded-full text-xs">
                    {{ $equipment->type->name }}
                </span>
            </td>
            
            <td class="px-4 py-3">
                @if($equipment->user)
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-full bg-instadBlue text-white flex items-center justify-center text-xs">
                        {{ substr($equipment->user->name, 0, 1) }}
                    </div>
                    <div class="text-sm">
                        <div>{{ $equipment->user->name }}</div>
                        <div class="text-xs text-gray-500">
                            {{ $equipment->user->direction->name ?? '-' }}
                        </div>
                    </div>
                </div>
                @else
                <span class="text-gray-400 text-sm">Non attribué</span>
                @endif
            </td>
            
            <td class="px-4 py-3">
                <div class="flex items-center gap-2">
                    <span class="status-dot {{ $equipment->status }}"></span>
                    <span class="text-sm {{ $equipment->status === 'new' ? 'text-green-600' : 'text-red-600' }}">
                        {{ config("equipment.statuses.{$equipment->status}") }}
                    </span>
                </div>
            </td>
            
            <td class="px-4 py-3">
                <div class="flex justify-center gap-2">
                    <a href="{{ route('admin.equipments.edit', $equipment) }}" 
                       class="text-instadBlue hover:text-blue-600 p-1 rounded hover:bg-gray-100"
                       title="Modifier">
                        <i class="bi bi-pencil text-lg"></i>
                    </a>
                    <form action="{{ route('admin.equipments.destroy', $equipment->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="text-red-500 hover:text-red-700 p-2 rounded-full hover:bg-red-50"
                                        onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette direction ?')"
                                        title="Supprimer">
                                    <i class="bi bi-trash"></i>
                                </button>
                    </form>
                </div>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="6" class="px-4 py-6 text-center text-gray-500">
                <i class="bi bi-inbox text-3xl mb-2"></i>
                <div>Aucun équipement trouvé</div>
            </td>
        </tr>
        @endforelse
    </tbody>
</table>

@if($equipments->hasPages())
<div class="px-4 py-3 border-t border-gray-100">
    {{ $equipments->links('vendor.pagination.tailwind') }}
</div>
@endif