@if($equipments->isEmpty())
    <div class="p-8 text-center bg-white rounded-2xl shadow-xl">
        <div class="inline-block mb-4 text-instadBlue">
            <i class="bi bi-pc-display-horizontal text-6xl"></i>
        </div>
        <h3 class="text-2xl font-semibold text-instaddark mb-2">
            @if(!empty($search))
                Aucun résultat pour "{{ $search }}"
            @else
                Aucun équipement enregistré
            @endif
        </h3>
        <p class="text-gray-500">
            {{ empty($search) ? 'Commencez par créer un nouvel équipement' : 'Essayez avec d\'autres termes de recherche' }}
        </p>
    </div>
@else
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-instadBlue/10">
                <tr>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-instaddark uppercase tracking-wider">Code</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-instaddark uppercase tracking-wider">Équipement</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-instaddark uppercase tracking-wider">Type</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-instaddark uppercase tracking-wider">Utilisateur</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-instaddark uppercase tracking-wider">Statut</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-instaddark uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($equipments as $equipment)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 whitespace-nowrap font-mono text-instaddark">{{ $equipment->code }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center gap-3">
                            @if($equipment->photo_path)
                            <img src="{{ Storage::url($equipment->photo_path) }}" 
                                 class="w-10 h-10 rounded-lg object-cover shadow-sm">
                            @endif
                            <span class="font-medium text-instaddark">{{ $equipment->name }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-sm">
                            {{ $equipment->type->name }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center gap-2">
                            @if($equipment->user)
                            <div class="w-8 h-8 rounded-full bg-instadBlue text-white flex items-center justify-center text-xs">
                                {{ substr($equipment->user->name, 0, 1) }}
                            </div>
                            <span class="text-sm">{{ $equipment->user->name }}</span>
                            @else
                            <span class="text-gray-400 text-sm">-</span>
                            @endif
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-3 py-1.5 inline-flex text-sm leading-5 font-semibold rounded-full 
                            @switch($equipment->status)
                                @case('new') bg-green-100 text-green-800 @break
                                @case('broken') bg-red-100 text-red-800 @break
                                @case('repaired') bg-blue-100 text-blue-800 @break
                                @default bg-gray-100 text-gray-800
                            @endswitch">
                            {{ config("equipment.statuses.{$equipment->status}") }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex space-x-3">
                            <a href="{{ route('admin.equipments.edit', $equipment) }}" 
                               class="text-instadBlue hover:text-blue-600 transition-colors"
                               data-tooltip="Modifier">
                                <i class="bi bi-pencil-square text-lg"></i>
                            </a>
                            <form action="{{ route('admin.equipments.destroy', $equipment) }}" method="POST">
                                @csrf @method('DELETE')
                                <button type="submit" 
                                        class="text-red-500 hover:text-red-600 transition-colors"
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
    </div>
@endif