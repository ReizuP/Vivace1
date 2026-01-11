@extends('layouts.admin')

@section('content')
<h1 class="mb-4">Dashboard</h1>

<div class="row mb-4">
    <div class="col-md-3">
        <div class="card text-white bg-primary">
            <div class="card-body">
                <h5 class="card-title">Total Orders</h5>
                <h2>{{ $stats['total_orders'] }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-success">
            <div class="card-body">
                <h5 class="card-title">Total Products</h5>
                <h2>{{ $stats['total_products'] }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-info">
            <div class="card-body">
                <h5 class="card-title">Total Users</h5>
                <h2>{{ $stats['total_users'] }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-warning">
            <div class="card-body">
                <h5 class="card-title">Total Revenue</h5>
                <h2>₱{{ number_format($stats['total_revenue'], 0) }}</h2>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5>Recent Orders</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Order #</th>
                                <th>Customer</th>
                                <th>Amount</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentOrders as $order)
                            <tr>
                                <td>{{ $order->order_number }}</td>
                                <td>{{ $order->user->name }}</td>
                                <td>₱{{ number_format($order->total_amount, 2) }}</td>
                                <td>
                                    <span class="badge 
                                        @if($order->status == 'to_pay') bg-warning
                                        @elseif($order->status == 'to_ship') bg-info
                                        @elseif($order->status == 'on_transit') bg-primary
                                        @else bg-success
                                        @endif">
                                        {{ ucwords(str_replace('_', ' ', $order->status)) }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-primary">View All Orders</a>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5>Low Stock Products</h5>
            </div>
            <div class="card-body">
                @if($lowStockProducts->count() > 0)
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Stock</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($lowStockProducts as $product)
                            <tr>
                                <td>{{ $product->name }}</td>
                                <td><span class="badge bg-danger">{{ $product->stock }}</span></td>
                                <td>
                                    <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-sm btn-warning">Restock</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <p class="text-muted">All products are well stocked!</p>
                @endif
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">
                <h5>Orders by Status</h5>
            </div>
            <div class="card-body">
                @foreach($ordersByStatus as $status)
                <div class="d-flex justify-content-between mb-2">
                    <span>{{ ucwords(str_replace('_', ' ', $status->status)) }}</span>
                    <span class="badge bg-secondary">{{ $status->count }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection