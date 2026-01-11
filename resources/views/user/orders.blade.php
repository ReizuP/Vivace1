@extends('layouts.app')

@section('content')
<div class="container my-5">
    <h1 class="mb-4">My Orders</h1>

    <ul class="nav nav-tabs mb-4">
        <li class="nav-item">
            <a class="nav-link {{ !request('status') ? 'active' : '' }}" href="{{ route('user.orders') }}">All</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request('status') == 'to_pay' ? 'active' : '' }}" href="{{ route('user.orders', ['status' => 'to_pay']) }}">To Pay</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request('status') == 'to_ship' ? 'active' : '' }}" href="{{ route('user.orders', ['status' => 'to_ship']) }}">To Ship</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request('status') == 'on_transit' ? 'active' : '' }}" href="{{ route('user.orders', ['status' => 'on_transit']) }}">On Transit</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request('status') == 'delivered' ? 'active' : '' }}" href="{{ route('user.orders', ['status' => 'delivered']) }}">Delivered</a>
        </li>
    </ul>

    @forelse($orders as $order)
    <div class="card mb-3">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <strong>Order #{{ $order->order_number }}</strong>
                <span class="text-muted ms-3">{{ $order->created_at->format('M d, Y') }}</span>
            </div>
            <span class="badge 
                @if($order->status == 'to_pay') bg-warning
                @elseif($order->status == 'to_ship') bg-info
                @elseif($order->status == 'on_transit') bg-primary
                @else bg-success
                @endif">
                {{ ucwords(str_replace('_', ' ', $order->status)) }}
            </span>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-8">
                    @foreach($order->items->take(3) as $item)
                    <div class="d-flex mb-2">
                        <img src="{{ $item->product->image ? asset($item->product->image) : 'https://via.placeholder.com/60' }}" width="60" class="me-3">
                        <div>
                            <strong>{{ $item->product->name }}</strong>
                            <p class="text-muted mb-0">Qty: {{ $item->quantity }} × ₱{{ number_format($item->price, 2) }}</p>
                        </div>
                    </div>
                    @endforeach
                    @if($order->items->count() > 3)
                        <p class="text-muted">+{{ $order->items->count() - 3 }} more item(s)</p>
                    @endif
                </div>
                <div class="col-md-4 text-end">
                    <p class="mb-1">Total Amount</p>
                    <h4 class="text-primary">₱{{ number_format($order->total_amount, 2) }}</h4>
                    <a href="{{ route('user.order.details', $order->id) }}" class="btn btn-outline-primary">View Details</a>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="text-center py-5">
        <i class="fas fa-box fa-5x text-muted mb-3"></i>
        <h3>No orders found</h3>
        <a href="{{ route('products.index') }}" class="btn btn-primary mt-3">Start Shopping</a>
    </div>
    @endforelse

    <div class="d-flex justify-content-center">
        {{ $orders->links() }}
    </div>
</div>
@endsection