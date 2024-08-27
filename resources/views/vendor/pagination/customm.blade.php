<!-- resources/views/vendor/pagination/customm.blade.php -->
<nav>
    <ul class="pagination">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li class="page-item disabled">
                <span class="page-link">«</span>
            </li>
        @else
            <li class="page-item">
                <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">«</a>
            </li>
        @endif

        {{-- Page Links --}}
        @php
            $start = max($paginator->currentPage() - 2, 1);
            $end = min($paginator->currentPage() + 2, $paginator->lastPage());
        @endphp

        @if ($start > 1)
            <li class="page-item">
                <a class="page-link" href="{{ $paginator->url(1) }}">1</a>
            </li>
            @if ($start > 2)
                <li class="page-item disabled">
                    <span class="page-link">...</span>
                </li>
            @endif
        @endif

        @for ($i = $start; $i <= $end; $i++)
            @if ($i == $paginator->currentPage())
                <li class="page-item active" aria-current="page">
                    <span class="page-link">{{ $i }}</span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->url($i) }}">{{ $i }}</a>
                </li>
            @endif
        @endfor

        @if ($end < $paginator->lastPage())
            @if ($end < $paginator->lastPage() - 1)
                <li class="page-item disabled">
                    <span class="page-link">...</span>
                </li>
            @endif
            <li class="page-item">
                <a class="page-link" href="{{ $paginator->url($paginator->lastPage()) }}">{{ $paginator->lastPage() }}</a>
            </li>
        @endif

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li class="page-item">
                <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">»</a>
            </li>
        @else
            <li class="page-item disabled">
                <span class="page-link">»</span>
            </li>
        @endif
    </ul>
</nav>
