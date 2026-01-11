@extends('layouts.app')

@section('content')
<div class="bg-light py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="display-4 fw-bold">Welcome to Vivace</h1>
                <p class="lead">Discover the perfect instrument to bring your music to life</p>
                <a href="{{ route('products.index') }}" class="btn btn-primary btn-lg">Shop Now</a>
            </div>
            <div class="col-lg-6">
                <img src="https://via.placeholder.com/500x400" alt="Music" class="img-fluid rounded">
            </div>
        </div>
    </div>
</div>

<div class="container my-5">
    <h2 class="text-center mb-4">Featured Products</h2>
    <div class="row">
        @foreach($featuredProducts as $product)
        <div class="col-md-4 mb-4">
            <div class="card product-card h-100">
                <img src="{{ $product->image ? asset($product->image) : 'https://via.placeholder.com/300' }}" class="card-img-top" alt="{{ $product->name }}">
                <div class="card-body">
                    <h5 class="card-title">{{ $product->name }}</h5>
                    <p class="card-text text-muted">{{ Str::limit($product->description, 80) }}</p>
                    <p class="fw-bold text-primary">₱{{ number_format($product->price, 2) }}</p>
                    <a href="{{ route('products.show', $product->slug) }}" class="btn btn-primary">View Details</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
