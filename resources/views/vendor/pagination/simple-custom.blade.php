@if (isset($paginator) && $paginator->hasPages())
    <nav aria-label="Page navigation">
        <ul class="pagination">
            <!-- Premier bouton -->
            @if ($paginator->onFirstPage())
                <li class="page-item disabled"><span class="page-link">←</span></li>
            @else
                <li class="page-item"><a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">←</a></li>
            @endif

            <!-- Page 1 -->
            @if ($paginator->currentPage() > 3)
                <li class="page-item"><a class="page-link" href="{{ $paginator->url(1) }}">1</a></li>
                <li class="page-item"><a class="page-link" href="{{ $paginator->url(2) }}">2</a></li>
                <li class="page-item disabled"><span class="page-link">...</span></li>
            @endif

            <!-- Pages de la plage actuelle -->
            @for ($page = max(1, $paginator->currentPage() - 2); $page <= min($paginator->lastPage(), $paginator->currentPage() + 2); $page++)
                @if ($page == $paginator->currentPage())
                    <li class="page-item active" aria-current="page"><span class="page-link">{{ $page }}</span></li>
                @else
                    <li class="page-item"><a class="page-link" href="{{ $paginator->url($page) }}">{{ $page }}</a></li>
                @endif
            @endfor

            <!-- Dernières pages -->
            @if ($paginator->currentPage() < $paginator->lastPage() - 2)
                <li class="page-item disabled"><span class="page-link">...</span></li>
                <li class="page-item"><a class="page-link" href="{{ $paginator->url($paginator->lastPage() - 1) }}">{{ $paginator->lastPage() - 1 }}</a></li>
                <li class="page-item"><a class="page-link" href="{{ $paginator->url($paginator->lastPage()) }}">{{ $paginator->lastPage() }}</a></li>
            @endif

            <!-- Dernier bouton -->
            @if ($paginator->hasMorePages())
                <li class="page-item"><a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">→</a></li>
            @else
                <li class="page-item disabled"><span class="page-link">→</span></li>
            @endif
        </ul>
    </nav>
@endif
