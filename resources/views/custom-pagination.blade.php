@if ($paginator->hasPages())
<div class="row">
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <!-- Results Info -->
                    <div class="pagination-info">
                        <p class="text-sm text-muted mb-0">
                            <i class="material-icons text-sm me-1">info</i>
                            Showing {{ $paginator->firstItem() }} to {{ $paginator->lastItem() }} of {{ $paginator->total() }} results
                        </p>
                    </div>

                    <!-- Pagination Links -->
                    <nav aria-label="Page navigation">
                        <ul class="pagination pagination-rounded mb-0">
                            {{-- Previous Page Link --}}
                            @if ($paginator->onFirstPage())
                                <li class="page-item disabled">
                                    <span class="page-link">
                                        <i class="material-icons">keyboard_arrow_left</i>
                                    </span>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">
                                        <i class="material-icons">keyboard_arrow_left</i>
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
                                                <span class="page-link bg-gradient-primary text-white">
                                                    {{ $page }}
                                                </span>
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
                                        <i class="material-icons">keyboard_arrow_right</i>
                                    </a>
                                </li>
                            @else
                                <li class="page-item disabled">
                                    <span class="page-link">
                                        <i class="material-icons">keyboard_arrow_right</i>
                                    </span>
                                </li>
                            @endif
                        </ul>
                    </nav>
                </div>

                <!-- Mobile Pagination (Simplified) -->
                <div class="d-flex justify-content-between d-md-none mt-3">
                    @if ($paginator->onFirstPage())
                        <span class="btn btn-outline-secondary disabled">
                            <i class="material-icons">keyboard_arrow_left</i> Previous
                        </span>
                    @else
                        <a href="{{ $paginator->previousPageUrl() }}" class="btn btn-outline-primary">
                            <i class="material-icons">keyboard_arrow_left</i> Previous
                        </a>
                    @endif

                    <span class="btn btn-primary">
                        Page {{ $paginator->currentPage() }} of {{ $paginator->lastPage() }}
                    </span>

                    @if ($paginator->hasMorePages())
                        <a href="{{ $paginator->nextPageUrl() }}" class="btn btn-outline-primary">
                            Next <i class="material-icons">keyboard_arrow_right</i>
                        </a>
                    @else
                        <span class="btn btn-outline-secondary disabled">
                            Next <i class="material-icons">keyboard_arrow_right</i>
                        </span>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endif

<style>
.pagination-rounded .page-link {
    border-radius: 0.5rem !important;
    margin: 0 2px;
    border: 1px solid #dee2e6;
    color: #344767;
    font-weight: 500;
    transition: all 0.15s ease-in;
    min-width: 40px;
    text-align: center;
    display: flex;
    align-items: center;
    justify-content: center;
}

.pagination-rounded .page-link:hover {
    background-color: #f8f9fa;
    transform: translateY(-1px);
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.pagination-rounded .page-item.active .page-link {
    border-color: #e91e63;
    box-shadow: 0 4px 7px -1px rgba(233, 30, 99, 0.3);
    color: white !important;
    font-weight: 600;
}

.pagination-rounded .page-item.disabled .page-link {
    color: #6c757d;
    background-color: #f8f9fa;
    border-color: #dee2e6;
}

.pagination-info i {
    vertical-align: middle;
}

@media (max-width: 768px) {
    .pagination {
        display: none;
    }
}

@media (min-width: 769px) {
    .d-md-none {
        display: none !important;
    }
}
</style>
