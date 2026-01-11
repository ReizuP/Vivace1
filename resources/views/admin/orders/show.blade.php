@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Order Details</h1>
    <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Back
    </a>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5>Order #{{ $order->order_number }}</h5>
                <small class="text-muted">{{ $order->created_at->format('M d, Y h:i A') }}</small>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST" class="d-flex align-items-center">
                        @csrf
                        @method('PUT')
                        <label class="me-2"><strong>Status:</strong></label>
                        <select name="status" class="form-select form-select-sm" style="width: auto;">
                            <option value="to_pay" {{ $order->status == 'to_pay' ? 'selected' : '' }}>To Pay</option>
                            <option value="to_ship" {{ $order->status == 'to_ship' ? 'selected' : '' }}>To Ship</option>
                            <option value="on_transit" {{ $order->status == 'on_transit' ? 'selected' : '' }}>On Transit</option>
                            <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                        </select>
                        <button type="submit" class="btn btn-sm btn-primary ms-2">Update</button>
                    </form>
                </div>

                <h6>Order Items</h6>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->items as $item)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="{{ $item->product->image ? asset($item->product->image) : 'https://via.placeholder.com/50' }}" width="50" class="me-2 rounded">
                                        <span>{{ $item->product->name }}</span>
                                    </div>
                                </td>
                                <td>{{ $item->quantity }}</td>
                                <td>₱{{ number_format($item->price, 2) }}</td>
                                <td>₱{{ number_format($item->price * $item->quantity, 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" class="text-end"><strong>Total:</strong></td>
                                <td><strong>₱{{ number_format($order->total_amount, 2) }}</strong></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card mb-3">
            <div class="card-header">
                <h6>Customer Information</h6>
            </div>
            <div class="card-body">
                <p class="mb-1"><strong>Name:</strong> {{ $order->user->name }}</p>
                <p class="mb-1"><strong>Email:</strong> {{ $order->user->email }}</p>
                <p class="mb-0"><strong>Phone:</strong> {{ $order->user->phone ?? 'N/A' }}</p>
            </div>
        </div>

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
@endsection
