@extends('layouts.app')

@section('content')
<div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Order Details</h1>
        <a href="{{ route('user.orders') }}" class="btn btn-outline-secondary">Back to Orders</a>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h5>Order #{{ $order->order_number }}</h5>
                    <small class="text-muted">Placed on {{ $order->created_at->format('M d, Y h:i A') }}</small>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <strong>Status: </strong>
                        <span class="badge 
                            @if($order->status == 'to_pay') bg-warning
                            @elseif($order->status == 'to_ship') bg-info
                            @elseif($order->status == 'on_transit') bg-primary
                            @else bg-success
                            @endif">
                            {{ ucwords(str_replace('_', ' ', $order->status)) }}
                        </span>
                    </div>

                    <h6>Items Ordered</h6>
                    @foreach($order->items as $item)
                    <div class="d-flex border-bottom pb-3 mb-3">
                        <img src="{{ $item->product->image ? asset($item->product->image) : 'https://via.placeholder.com/80' }}" width="80" class="me-3">
                        <div class="flex-grow-1">
                            <h6>{{ $item->product->name }}</h6>
                            <p class="text-muted mb-1">Quantity: {{ $item->quantity }}</p>
                            <p class="text-muted mb-0">Price: ₱{{ number_format($item->price, 2) }}</p>
                        </div>
                        <div class="text-end">
                            <strong>₱{{ number_format($item->price * $item->quantity, 2) }}</strong>
                        </div>
                    </div>
                    @endforeach

                    <div class="text-end">
                        <h5>Total: <span class="text-primary">₱{{ number_format($order->total_amount, 2) }}</span></h5>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card mb-3">
                <div class="card-header">
                    <h6>Shipping Information</h6>
                </div>
                <div class="card-body">
                    <p class="mb-1"><strong>{{ $order->shipping_name }}</strong></p>
                    <p class="mb-1">{{ $order->shipping_phone }}</p>
                    <p class="mb-1">{{ $order->shipping_address }}</p>
                    <p class="mb-0">{{ $order->shipping_city }}, {{ $order->shipping_postal_code }}</p>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h6>Payment Information</h6>
                </div>
                <div class="card-body">
                    <p class="mb-0">
                        <strong>Method:</strong> 
                        {{ $order->payment_method == 'cod' ? 'Cash on Delivery' : 'Bank Transfer' }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection