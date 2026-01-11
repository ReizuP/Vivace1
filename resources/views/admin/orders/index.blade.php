@extends('layouts.admin')

@section('content')
<h1 class="mb-4">Orders Management</h1>

<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.orders.index') }}" method="GET" class="mb-3">
            <div class="row">
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control" placeholder="Search by order number..." value="{{ request('search') }}">
                </div>
                <div class="col-md-4">
                    <select name="status" class="form-select">
                        <option value="">All Status</option>
                        <option value="to_pay" {{ request('status') == 'to_pay' ? 'selected' : '' }}>To Pay</option>
                        <option value="to_ship" {{ request('status') == 'to_ship' ? 'selected' : '' }}>To Ship</option>
                        <option value="on_transit" {{ request('status') == 'on_transit' ? 'selected' : '' }}>On Transit</option>
                        <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>Delivered</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">Filter</button>
                </div>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Order #</th>
                        <th>Customer</th>
                        <th>Date</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                    <tr>
                        <td>{{ $order->order_number }}</td>
                        <td>{{ $order->user->name }}</td>
                        <td>{{ $order->created_at->format('M d, Y') }}</td>
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
                        <td>
                            <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-primary">
                                <i class="fas fa-eye"></i> View
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">No orders found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center">
            {{ $orders->links() }}
        </div>
    </div>
</div>
@endsection
