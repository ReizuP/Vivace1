@extends('layouts.app')

@section('content')
<div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">Our Products</h1>
        @if(request()->hasAny(['search', 'category', 'sort']))
            <a href="{{ route('products.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="fas fa-times"></i> Clear Filters
            </a>
        @endif
    </div>
    
    <div class="row mb-4">
        <div class="col-md-12">
            <form action="{{ route('products.index') }}" method="GET" class="row g-3" id="filterForm">
                <div class="col-md-4">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Search products..." value="{{ request('search') }}">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
                <div class="col-md-3">
                    <select name="category" class="form-select" id="categorySelect">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="sort" class="form-select" id="sortSelect">
                        <option value="">Sort By</option>
                        <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                        <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                        <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Name: A to Z</option>
                        <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Name: Z to A</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-filter"></i> Filter
                    </button>
                </div>
            </form>
        </div>
    </div>
    
    @if(request()->hasAny(['search', 'category', 'sort']))
    <div class="mb-3">
        <small class="text-muted">
            @if(request('search'))
                Searching for: <strong>"{{ request('search') }}"</strong>
            @endif
            @if(request('category'))
                @php
                    $selectedCategory = $categories->firstWhere('id', request('category'));
                @endphp
                @if($selectedCategory)
                    | Category: <strong>{{ $selectedCategory->name }}</strong>
                @endif
            @endif
            @if(request('sort'))
                | Sorted by: <strong>
                    @switch(request('sort'))
                        @case('price_asc') Price: Low to High @break
                        @case('price_desc') Price: High to Low @break
                        @case('name_asc') Name: A to Z @break
                        @case('name_desc') Name: Z to A @break
                    @endswitch
                </strong>
            @endif
            | {{ $products->total() }} product(s) found
        </small>
    </div>
    @endif

    <div class="row">
        @forelse($products as $product)
        <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
            <div class="card product-card h-100">
                <img src="{{ $product->image ? asset($product->image) : 'https://via.placeholder.com/300' }}" class="card-img-top" alt="{{ $product->name }}" style="height: 200px; object-fit: cover;">
                <div class="card-body d-flex flex-column">
                    <span class="badge bg-secondary mb-2 align-self-start">{{ $product->category->name }}</span>
                    <h6 class="card-title">{{ $product->name }}</h6>
                    <p class="card-text text-muted small flex-grow-1">{{ Str::limit($product->description, 50) }}</p>
                    <p class="fw-bold text-primary mb-1">₱{{ number_format($product->price, 2) }}</p>
                    <p class="text-muted small mb-2">Stock: {{ $product->stock }}</p>
                    <a href="{{ route('products.show', $product->slug) }}" class="btn btn-primary btn-sm w-100 mt-auto">View Details</a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="text-center py-5">
                <i class="fas fa-search fa-3x text-muted mb-3"></i>
                <h4>No products found</h4>
                <p class="text-muted">Try adjusting your search or filter criteria</p>
                @if(request()->hasAny(['search', 'category', 'sort']))
                    <a href="{{ route('products.index') }}" class="btn btn-primary mt-2">
                        <i class="fas fa-refresh"></i> Show All Products
                    </a>
                @endif
            </div>
        </div>
        @endforelse
    </div>

    @if($products->hasPages())
    <div class="d-flex justify-content-center mt-4">
        {{ $products->appends(request()->query())->links() }}
    </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
// Auto-submit form when category or sort changes
document.getElementById('categorySelect').addEventListener('change', function() {
    document.getElementById('filterForm').submit();
});

document.getElementById('sortSelect').addEventListener('change', function() {
    document.getElementById('filterForm').submit();
});

// Allow search on Enter key
document.querySelector('input[name="search"]').addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
        e.preventDefault();
        document.getElementById('filterForm').submit();
    }
});
</script>
@endpush
