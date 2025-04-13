@extends('layouts.base_admin')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Barre de recherche premium -->
    <div class="mb-8 relative group transition-all duration-300">
        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
            <i class="bi bi-search text-xl text-gray-400 group-focus-within:text-indigo-500 transition-colors"></i>
        </div>
        
        <input 
            type="search" 
            id="globalSearch"
            placeholder="Rechercher par nom, email ou direction..."
            class="w-full pl-12 pr-32 py-4 rounded-2xl border-3 border-gray-200 
                   focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 
                   placeholder-gray-400 text-gray-700 text-lg
                   shadow-lg hover:shadow-xl transition-all"
            autocomplete="off"
        >
        
        <div class="absolute inset-y-0 right-0 pr-4 flex items-center">
            <span class="text-sm font-medium text-indigo-500 bg-indigo-50 px-3 py-1 rounded-xl border border-indigo-100">
                <span id="resultsCount">{{ $users->total() }}</span> résultats
            </span>
        </div>
    </div>

    <!-- Conteneur dynamique -->
    <div id="dynamicContent">
        <!-- Tableau -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            @include('admin.users.partials.table', ['users' => $users])
        </div>

        <!-- Pagination -->
        <div id="dynamicPagination" class="mt-6">
            {{ $users->links('vendor.pagination.tailwind') }}
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const globalSearch = document.getElementById('globalSearch');
    let timeout = null;

    // Gestionnaire de recherche avec anti-rebond
    globalSearch.addEventListener('input', function(e) {
        clearTimeout(timeout);
        timeout = setTimeout(() => {
            const searchValue = e.target.value;
            const params = new URLSearchParams({ search: searchValue });

            fetch(`{{ route('admin.users.index') }}?${params}`, {
                headers: { 
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                document.querySelector('#dynamicContent').innerHTML = `
                    <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                        ${data.table}
                    </div>
                `;
                document.getElementById('dynamicPagination').innerHTML = data.pagination;
                document.getElementById('resultsCount').textContent = data.count;
                window.history.replaceState({}, '', `?${params}`);
            });
        }, 300);
    });

    // Gestion de la pagination
    document.addEventListener('click', function(e) {
        const pageLink = e.target.closest('.page-link');
        if (pageLink) {
            e.preventDefault();
            const url = new URL(pageLink.href);
            const searchParams = new URLSearchParams(window.location.search);
            
            url.searchParams.set('search', searchParams.get('search') || '');
            
            fetch(url, {
                headers: { 
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                document.querySelector('#dynamicContent').innerHTML = `
                    <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                        ${data.table}
                    </div>
                `;
                document.getElementById('dynamicPagination').innerHTML = data.pagination;
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });
        }
    });
});
</script>
@endsection