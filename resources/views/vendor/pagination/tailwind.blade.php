@if ($paginator->hasPages())
<nav role="navigation" aria-label="Pagination">
    <div class="flex justify-between items-center">
        <!-- Bouton Précédent -->
        @if ($paginator->onFirstPage())
            <span class="px-4 py-2 bg-gray-100 text-gray-400 rounded-xl cursor-not-allowed">
                <i class="bi bi-chevron-left mr-2"></i>Précédent
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" 
               class="px-4 py-2 bg-indigo-50 text-indigo-600 rounded-xl hover:bg-indigo-100 transition-colors">
                <i class="bi bi-chevron-left mr-2"></i>Précédent
            </a>
        @endif

        <!-- Statistiques -->
        <div class="text-sm text-gray-600">
            Page {{ $paginator->currentPage() }} sur {{ $paginator->lastPage() }}
        </div>

        <!-- Bouton Suivant -->
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" 
               class="px-4 py-2 bg-indigo-50 text-indigo-600 rounded-xl hover:bg-indigo-100 transition-colors">
                Suivant<i class="bi bi-chevron-right ml-2"></i>
            </a>
        @else
            <span class="px-4 py-2 bg-gray-100 text-gray-400 rounded-xl cursor-not-allowed">
                Suivant<i class="bi bi-chevron-right ml-2"></i>
            </span>
        @endif
    </div>
</nav>
@endif