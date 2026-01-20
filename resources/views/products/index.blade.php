@extends('layouts.app')

<style>
    .form-control, .form-select {
        background-color: var(--dark);
        color: var(--primary);
        border: 1px solid #ced4da;
        border-radius: 0.25rem;
        padding: 0.5rem 1rem;
        font-size: 1rem;
    }
    .form-control:focus, .form-select:focus {
        border-color: #a68a5c;
        box-shadow: 0 0 0 0.2rem rgba(166, 138, 92, 0.25);
    }
</style>

@section('content')
<div class="container my-5">
    <h1 class="mb-4">Our Products</h1>

    <div class="row mb-4">
        <div class="col-md-12">
            <form action="{{ route('products.index') }}" method="GET" class="row g-3">
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control" placeholder="Search products..." value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <select name="category" class="form-select">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="sort" class="form-select">
                        <option value="">Sort By</option>
                        <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                        <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">Filter</button>
                </div>
            </form>
        </div>
    </div>

    <div class="row">
        @forelse($products as $product)
        <div class="col-lg-3 col-md-3 col-sm-6 mb-4">
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
            <p class="text-center">No products found.</p>
        </div>
        @endforelse
    </div>

    <div class="d-flex justify-content-center">
        {{ $products->links() }}
    </div>
</div>
@endsection
