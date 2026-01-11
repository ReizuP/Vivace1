@extends('layouts.app')

@section('content')
<div class="container my-5">
    <h1 class="mb-4">Shopping Cart</h1>

    @if(count($cart) > 0)
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    @foreach($cart as $id => $item)
                    <div class="row mb-3 pb-3 border-bottom">
                        <div class="col-md-2">
                            <img src="{{ $item['image'] ? asset($item['image']) : 'https://via.placeholder.com/100' }}" class="img-fluid" alt="{{ $item['name'] }}">
                        </div>
                        <div class="col-md-4">
                            <h5>{{ $item['name'] }}</h5>
                            <p class="text-muted">₱{{ number_format($item['price'], 2) }}</p>
                        </div>
                        <div class="col-md-3">
                            <form action="{{ route('cart.update', $id) }}" method="POST">
                                @csrf
                                <div class="input-group">
                                    <input type="number" name="quantity" class="form-control" value="{{ $item['quantity'] }}" min="1">
                                    <button class="btn btn-outline-primary" type="submit">Update</button>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-2">
                            <p class="fw-bold">₱{{ number_format($item['price'] * $item['quantity'], 2) }}</p>
                        </div>
                        <div class="col-md-1">
                            <form action="{{ route('cart.remove', $id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm" type="submit">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5>Order Summary</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span>Subtotal:</span>
                        <span>₱{{ number_format($total, 2) }}</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between mb-3">
                        <strong>Total:</strong>
                        <strong class="text-primary fs-4">₱{{ number_format($total, 2) }}</strong>
                    </div>
                    @auth
                        <a href="{{ route('checkout.index') }}" class="btn btn-primary w-100">Proceed to Checkout</a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-primary w-100">Login to Checkout</a>
                    @endauth
                    <a href="{{ route('products.index') }}" class="btn btn-outline-secondary w-100 mt-2">Continue Shopping</a>
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="text-center py-5">
        <i class="fas fa-shopping-cart fa-5x text-muted mb-3"></i>
        <h3>Your cart is empty</h3>
        <a href="{{ route('products.index') }}" class="btn btn-primary mt-3">Start Shopping</a>
    </div>
    @endif
</div>
@endsection