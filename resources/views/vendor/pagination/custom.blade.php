

<style> .pagination {
    justify-content: center;
    margin-top: 20px;
}

.pagination .page-item {
    margin: 0 2px;
}

.pagination .page-link {
    padding: 10px 15px;
    border-radius: 5px;
    background-color: #f8f9fa;
    color: #007bff;
    border: 1px solid #dee2e6;
}

.pagination .page-item.active .page-link {
    background-color: #007bff;
    color: #fff;
    border-color: #007bff;
}

.pagination .page-item.disabled .page-link {
    background-color: #e9ecef;
    color: #6c757d;
}
</style>
@if ($paginator->hasPages())
    <ul class="pagination">
        {{-- Liens des pages --}}
        @foreach ($elements as $element)
            {{-- "Array" est utilisé pour une liste de pages --}}
            @if (is_string($element))
                <li class="page-item disabled"><span class="page-link">{{ $element }}</span></li>
            @endif

            {{-- "Array" est utilisé pour une liste de pages --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="page-item active" aria-current="page"><span class="page-link">{{ $page }}</span></li>
                    @else
                        <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach
    </ul>
@endif
