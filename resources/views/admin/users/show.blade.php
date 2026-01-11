@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>User Details</h1>
    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Back
    </a>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5>User Information</h5>
            </div>
            <div class="card-body">
                <p class="mb-2"><strong>Name:</strong> {{ $user->name }}</p>
                <p class="mb-2"><strong>Email:</strong> {{ $user->email }}</p>
                <p class="mb-2"><strong>Phone:</strong> {{ $user->phone ?? 'N/A' }}</p>
                <p class="mb-2"><strong>Address:</strong> {{ $user->address ?? 'N/A' }}</p>
                <p class="mb-2"><strong>City:</strong> {{ $user->city ?? 'N/A' }}</p>
                <p class="mb-2"><strong>Postal Code:</strong> {{ $user->postal_code ?? 'N/A' }}</p>
                <p class="mb-0"><strong>Member Since:</strong> {{ $user->created_at->format('M d, Y') }}</p>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5>Order History ({{ $user->orders->count() }} orders)</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Order #</th>
                                <th>Date</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($user->orders as $order)
                            <tr>
                                <td>{{ $order->order_number }}</td>
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
                                    <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-primary">View</a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center">No orders yet</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection