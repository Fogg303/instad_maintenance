@extends('layouts.base_admin')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header avec recherche + bouton -->
    <div class="flex flex-col md:flex-row gap-6 mb-8 items-start md:items-center justify-between">
        <!-- Conteneur recherche + résultats -->
        <div class="flex-grow relative group transition-all duration-300 w-full md:w-auto">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                <i class="bi bi-search text-xl text-gray-400 group-focus-within:text-indigo-500 transition-colors"></i>
            </div>
            
            <input 
                type="search" 
                id="globalSearch"
                placeholder="Rechercher un utilisateur..."
                class="w-full pl-12 pr-32 py-3.5 rounded-xl border-2 border-gray-200 
                       focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 
                       placeholder-gray-400 text-gray-700 text-base
                       shadow-sm hover:shadow-md transition-all"
                autocomplete="off"
            >
            
            <div class="absolute inset-y-0 right-0 pr-4 flex items-center space-x-3">
                <span class="text-sm font-medium text-indigo-600 bg-indigo-50 px-2.5 py-1 rounded-lg border border-indigo-100">
                    <span id="resultsCount">{{ $users->total() }}</span> résultats
                </span>
            </div>
        </div>

        <!-- Bouton Nouvel utilisateur -->
        <a href="{{ route('admin.users.create') }}" 
           class="w-full md:w-auto flex items-center justify-center gap-2 
                  px-5 py-2.5 bg-gradient-to-br from-indigo-600 to-indigo-700 
                  hover:from-indigo-700 hover:to-indigo-800 text-white font-medium
                  rounded-lg transition-all shadow-sm hover:shadow-md
                  transform hover:scale-[1.02] active:scale-95
                  border border-indigo-700 hover:border-indigo-800">
            <i class="bi bi-plus-lg text-lg leading-none"></i>
            <span>Nouvel utilisateur</span>
        </a>
    </div>

    <!-- Conteneur principal -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <!-- En-tête du tableau -->
        <div class="px-5 py-4 border-b border-gray-100 bg-gray-50">
            <h3 class="text-sm font-semibold text-gray-700 uppercase tracking-wide">
                Liste des utilisateurs
            </h3>
        </div>

        <!-- Contenu dynamique -->
        <div id="dynamicContent">
            @include('admin.users.partials.table', ['users' => $users])
            
            <!-- Pagination -->
            <div id="dynamicPagination" class="px-5 py-4 border-t border-gray-100">
                {{ $users->links('vendor.pagination.tailwind') }}
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const globalSearch = document.getElementById('globalSearch');
    const resultsCount = document.getElementById('resultsCount');
    let timeout = null;
    
    const showError = (message) => {
        const errorDiv = document.getElementById('ajaxErrors');
        if(errorDiv) {
            errorDiv.textContent = message;
            errorDiv.classList.remove('hidden');
            setTimeout(() => errorDiv.classList.add('hidden'), 5000);
        }
    };

    // Gestion recherche
    if(globalSearch) {
        globalSearch.addEventListener('input', function(e) {
            clearTimeout(timeout);
            document.querySelector('#dynamicContent').innerHTML = `
                <div class="p-8 flex justify-center">
                    <div class="animate-spin rounded-full h-8 w-8 border-2 border-indigo-500 border-t-transparent"></div>
                </div>`;
            
            timeout = setTimeout(() => {
                const searchValue = e.target.value.trim();
                const params = new URLSearchParams({ 
                    search: searchValue,
                    ajax: true
                });

                fetch(`{{ route('admin.users.index') }}?${params}`, {
                    headers: { 
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(response => {
                    if (!response.ok) throw new Error('Erreur HTTP: ' + response.status);
                    return response.json();
                })
                .then(data => {
                    if(!data.table || !data.pagination || !data.count) {
                        throw new Error('Réponse serveur invalide');
                    }
                    
                    // Mise à jour dynamique
                    const dynamicContent = document.querySelector('#dynamicContent');
                    const dynamicPagination = document.querySelector('#dynamicPagination');
                    
                    if(dynamicContent) dynamicContent.innerHTML = data.table;
                    if(dynamicPagination) dynamicPagination.innerHTML = data.pagination;
                    if(resultsCount) resultsCount.textContent = data.count;
                    
                    window.history.replaceState({}, '', `?${params}`);
                })
                .catch(error => {
                    console.error('Erreur:', error);
                    showError(error.message);
                    document.querySelector('#dynamicContent').innerHTML = `
                        <div class="p-8 text-center text-gray-500">
                            Aucun résultat trouvé pour "${searchValue}"
                        </div>`;
                });
            }, 350);
        });
    }

    // Gestion pagination
    document.addEventListener('click', function(e) {
        const pageLink = e.target.closest('a.page-link:not(.disabled)');
        if(pageLink) {
            e.preventDefault();
            const url = new URL(pageLink.href);
            const searchParams = new URLSearchParams(window.location.search);
            
            // Conservation des paramètres
            url.searchParams.set('search', searchParams.get('search') || '');
            url.searchParams.set('ajax', true);
            
            document.querySelector('#dynamicContent').innerHTML = `
                <div class="p-8 flex justify-center">
                    <div class="animate-spin rounded-full h-8 w-8 border-2 border-indigo-500 border-t-transparent"></div>
                </div>`;
            
            fetch(url, {
                headers: { 
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => {
                if (!response.ok) throw new Error('Erreur HTTP: ' + response.status);
                return response.json();
            })
            .then(data => {
                if(!data.table || !data.pagination || !data.count) {
                    throw new Error('Réponse serveur invalide');
                }
                
                const dynamicContent = document.querySelector('#dynamicContent');
                const dynamicPagination = document.querySelector('#dynamicPagination');
                
                if(dynamicContent) dynamicContent.innerHTML = data.table;
                if(dynamicPagination) dynamicPagination.innerHTML = data.pagination;
                if(resultsCount) resultsCount.textContent = data.count;
                
                window.history.replaceState({}, '', url);
                window.scrollTo({ top: 0, behavior: 'smooth' });
            })
            .catch(error => {
                console.error('Erreur:', error);
                showError(error.message);
                document.querySelector('#dynamicContent').innerHTML = `
                    <div class="p-8 text-center text-red-500">
                        Erreur de chargement de la page
                    </div>`;
            });
        }
    });
});
</script>
@endsection