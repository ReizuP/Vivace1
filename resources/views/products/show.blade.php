
@extends('layouts.app')

@section('content')
<div class="container my-5">
    <div class="row">
        <div class="col-md-6">
            <img src="{{ $product->image ? asset($product->image) : 'https://via.placeholder.com/500' }}" class="img-fluid rounded" alt="{{ $product->name }}">
        </div>
        <div class="col-md-6">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Products</a></li>
                    <li class="breadcrumb-item active">{{ $product->name }}</li>
                </ol>
            </nav>
            
            <h1>{{ $product->name }}</h1>
            <p class="text-muted">Category: {{ $product->category->name }}</p>
            <h3 class="text-primary">₱{{ number_format($product->price, 2) }}</h3>
            
            <p class="mt-3">{{ $product->description }}</p>
            
            <div class="alert alert-info">
                <strong>In Stock:</strong> {{ $product->stock }} units available
            </div>

            @if($product->stock > 0)
            <form action="{{ route('cart.add', $product->id) }}" method="POST" class="mt-4">
                @csrf
                <div class="input-group mb-3" style="max-width: 150px;">
                    <button class="btn btn-outline-secondary" type="button" onclick="this.nextElementSibling.stepDown()">-</button>
                    <input type="number" name="quantity" class="form-control text-center" value="1" min="1" max="{{ $product->stock }}">
                    <button class="btn btn-outline-secondary" type="button" onclick="this.previousElementSibling.stepUp()">+</button>
                </div>
                <button type="submit" class="btn btn-primary btn-lg">
                    <i class="fas fa-cart-plus"></i> Add to Cart
                </button>
            </form>
            @else
            <div class="alert alert-danger mt-4">Out of Stock</div>
            @endif
        </div>
    </div>

    @if($relatedProducts->count() > 0)
    <div class="mt-5">
        <h3>Related Products</h3>
        <div class="row">
            @foreach($relatedProducts as $related)
            <div class="col-md-3 mb-3">
                <div class="card product-card h-100">
                    <img src="{{ $related->image ? asset($related->image) : 'https://via.placeholder.com/200' }}" class="card-img-top" alt="{{ $related->name }}">
                    <div class="card-body">
                        <h6 class="card-title">{{ $related->name }}</h6>
                        <p class="text-primary fw-bold">₱{{ number_format($related->price, 2) }}</p>
                        <a href="{{ route('products.show', $related->slug) }}" class="btn btn-sm btn-outline-primary">View</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection