@extends('layouts.app')

@section('content')
<div class="container my-5">
    <h1 class="mb-4">Products</h1>

    <div class="row mb-4">
        <div class="col-md-12">
            <form action="{{ route('products.index') }}" method="GET" class="row g-3" id="productFilters">
                <div class="col-md-6 position-relative">
                    <input type="text" name="search" class="form-control" id="productPageSearch" placeholder="Search products..." value="{{ request('search') }}" autocomplete="off">
                    <div class="search-wrap">
                        <div class="search-autocomplete product-search-autocomplete" id="productPageSearchAutocomplete"></div>
                    </div>
                </div>
                <div class="col-md-3">
                    <select name="category" class="form-select" id="categorySelect">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" data-slug="{{ $category->slug }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="sort" class="form-select" id="sortSelect">
                        <option value="">Sort By</option>
                        <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Name: A-Z</option>
                        <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Name: Z-A</option>
                        <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                        <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                    </select>
                </div>
            </form>
        </div>
    </div>

    <div class="row g-4">
        @forelse($products as $product)
        <div class="col-lg-3 col-md-4 col-sm-6">
            <x-product-card :product="$product" />
        </div>
        @empty
        <div class="col-12">
            <p class="text-center">No products found.</p>
        </div>
        @endforelse
    </div>

    <div class="d-flex justify-content-center mt-4">
        @if ($products->hasPages())
            <nav aria-label="Page navigation">
                <ul class="pagination">
                    {{-- Previous Page Link --}}
                    @if ($products->onFirstPage())
                        <li class="page-item disabled" aria-disabled="true">
                            <span class="page-link">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <polyline points="15 18 9 12 15 6"></polyline>
                                </svg>
                            </span>
                        </li>
                    @else
                        <li class="page-item">
                            <a class="page-link" href="{{ $products->appends(request()->query())->previousPageUrl() }}" rel="prev">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <polyline points="15 18 9 12 15 6"></polyline>
                                </svg>
                            </a>
                        </li>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($products->appends(request()->query())->getUrlRange(1, $products->lastPage()) as $page => $url)
                        @if ($page == $products->currentPage())
                            <li class="page-item active" aria-current="page"><span class="page-link">{{ $page }}</span></li>
                        @else
                            <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($products->hasMorePages())
                        <li class="page-item">
                            <a class="page-link" href="{{ $products->appends(request()->query())->nextPageUrl() }}" rel="next">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <polyline points="9 18 15 12 9 6"></polyline>
                                </svg>
                            </a>
                        </li>
                    @else
                        <li class="page-item disabled" aria-disabled="true">
                            <span class="page-link">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <polyline points="9 18 15 12 9 6"></polyline>
                                </svg>
                            </span>
                        </li>
                    @endif
                </ul>
            </nav>
        @endif
    </div>
</div>

@push('scripts')
<script>
// Auto-apply filters (no manual Filter button)
(function() {
    const form = document.getElementById('productFilters');
    const categorySelect = document.getElementById('categorySelect');
    const sortSelect = document.getElementById('sortSelect');

    if (!form) return;

    // auto-submit on sort change
    if (sortSelect) {
        sortSelect.addEventListener('change', () => form.submit());
    }

    // auto-filter on category change:
    // If a category is chosen, redirect to /products/category/{slug} to keep URLs clean.
    if (categorySelect) {
        categorySelect.addEventListener('change', () => {
            const categoryId = categorySelect.value;
            if (!categoryId) {
                form.submit();
                return;
            }

            const selected = categorySelect.options[categorySelect.selectedIndex];
            const slug = selected ? selected.getAttribute('data-slug') : null;
            if (slug) {
                const params = new URLSearchParams(new FormData(form));
                // remove category id; slug route handles it
                params.delete('category');
                const qs = params.toString();
                window.location.href = `{{ url('/products/category') }}/${encodeURIComponent(slug)}${qs ? '?' + qs : ''}`;
                return;
            }

            // fallback: submit query-based filter
            form.submit();
        });
    }
})();
</script>
@endpush
@endsection
