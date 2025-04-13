<div class="bg-white p-4 rounded-lg shadow mb-6" id="filter-form">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Recherche</label>
            <input 
                type="search" 
                name="search" 
                value="{{ $filters['search'] ?? '' }}"
                placeholder="Nom, email ou direction..."
                class="w-full px-3 py-2 border rounded-md focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
            >
        </div>
        
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Rôle</label>
            <select 
                name="role" 
                class="w-full px-3 py-2 border rounded-md focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
            >
                <option value="">Tous les rôles</option>
                <option value="admin" {{ ($filters['role'] ?? '') == 'admin' ? 'selected' : '' }}>Administrateur</option>
                <option value="technician" {{ ($filters['role'] ?? '') == 'technician' ? 'selected' : '' }}>Technicien</option>
                <option value="user" {{ ($filters['role'] ?? '') == 'user' ? 'selected' : '' }}>Utilisateur</option>
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Direction</label>
            <select 
                name="direction" 
                class="w-full px-3 py-2 border rounded-md focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
            >
                <option value="">Toutes directions</option>
                @foreach($directions as $direction)
                <option value="{{ $direction->id }}" {{ ($filters['direction'] ?? '') == $direction->id ? 'selected' : '' }}>
                    {{ $direction->name }}
                </option>
                @endforeach
            </select>
        </div>

        <div>
            <button 
                type="submit" 
                class="w-full bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 transition-colors"
            >
                <i class="bi bi-funnel mr-2"></i>Filtrer
            </button>
        </div>
    </div>
</div>