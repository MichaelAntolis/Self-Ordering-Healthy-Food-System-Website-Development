@if ($paginator->hasPages())
<nav aria-label="Page navigation" class="d-flex justify-content-center mt-4">
    <ul class="pagination pagination-custom">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li class="page-item disabled">
                <span class="page-link">
                    <i class="fas fa-chevron-left"></i>
                    <span class="d-none d-sm-inline ms-1">Previous</span>
                </span>
            </li>
        @else
            <li class="page-item">
                <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">
                    <i class="fas fa-chevron-left"></i>
                    <span class="d-none d-sm-inline ms-1">Previous</span>
                </a>
            </li>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <li class="page-item disabled">
                    <span class="page-link">{{ $element }}</span>
                </li>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="page-item active">
                            <span class="page-link">{{ $page }}</span>
                        </li>
                    @else
                        <li class="page-item">
                            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                        </li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li class="page-item">
                <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">
                    <span class="d-none d-sm-inline me-1">Next</span>
                    <i class="fas fa-chevron-right"></i>
                </a>
            </li>
        @else
            <li class="page-item disabled">
                <span class="page-link">
                    <span class="d-none d-sm-inline me-1">Next</span>
                    <i class="fas fa-chevron-right"></i>
                </span>
            </li>
        @endif
    </ul>
</nav>

@endif

<style>
.pagination-custom {
    --bs-pagination-padding-x: 0.75rem;
    --bs-pagination-padding-y: 0.5rem;
    --bs-pagination-font-size: 0.9rem;
    --bs-pagination-color: #6c757d;
    --bs-pagination-bg: #fff;
    --bs-pagination-border-width: 1px;
    --bs-pagination-border-color: #dee2e6;
    --bs-pagination-border-radius: 0.5rem;
    --bs-pagination-hover-color: #495057;
    --bs-pagination-hover-bg: #f8f9fa;
    --bs-pagination-hover-border-color: #dee2e6;
    --bs-pagination-focus-color: #495057;
    --bs-pagination-focus-bg: #e9ecef;
    --bs-pagination-focus-box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    --bs-pagination-active-color: #fff;
    --bs-pagination-active-bg: #28a745;
    --bs-pagination-active-border-color: #28a745;
    --bs-pagination-disabled-color: #adb5bd;
    --bs-pagination-disabled-bg: #fff;
    --bs-pagination-disabled-border-color: #dee2e6;
    margin-bottom: 0;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.pagination-custom .page-link {
    position: relative;
    display: block;
    padding: var(--bs-pagination-padding-y) var(--bs-pagination-padding-x);
    font-size: var(--bs-pagination-font-size);
    color: var(--bs-pagination-color);
    text-decoration: none;
    background-color: var(--bs-pagination-bg);
    border: var(--bs-pagination-border-width) solid var(--bs-pagination-border-color);
    transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
}

.pagination-custom .page-link:hover {
    z-index: 2;
    color: var(--bs-pagination-hover-color);
    background-color: var(--bs-pagination-hover-bg);
    border-color: var(--bs-pagination-hover-border-color);
    transform: translateY(-1px);
}

.pagination-custom .page-link:focus {
    z-index: 3;
    color: var(--bs-pagination-focus-color);
    background-color: var(--bs-pagination-focus-bg);
    outline: 0;
    box-shadow: var(--bs-pagination-focus-box-shadow);
}

.pagination-custom .page-item:not(:first-child) .page-link {
    margin-left: -1px;
}

.pagination-custom .page-item.active .page-link {
    z-index: 3;
    color: var(--bs-pagination-active-color);
    background-color: var(--bs-pagination-active-bg);
    border-color: var(--bs-pagination-active-border-color);
    transform: scale(1.05);
    box-shadow: 0 4px 8px rgba(40, 167, 69, 0.3);
}

.pagination-custom .page-item.disabled .page-link {
    color: var(--bs-pagination-disabled-color);
    pointer-events: none;
    background-color: var(--bs-pagination-disabled-bg);
    border-color: var(--bs-pagination-disabled-border-color);
}

.pagination-custom .page-item:first-child .page-link {
    border-top-left-radius: var(--bs-pagination-border-radius);
    border-bottom-left-radius: var(--bs-pagination-border-radius);
}

.pagination-custom .page-item:last-child .page-link {
    border-top-right-radius: var(--bs-pagination-border-radius);
    border-bottom-right-radius: var(--bs-pagination-border-radius);
}

@media (max-width: 576px) {
    .pagination-custom {
        --bs-pagination-padding-x: 0.5rem;
        --bs-pagination-padding-y: 0.375rem;
        --bs-pagination-font-size: 0.8rem;
    }
}
</style>