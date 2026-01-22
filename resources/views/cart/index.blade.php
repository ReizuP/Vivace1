@extends('layouts.app')

@section('content')
<div class="container my-5">
    <h1 class="mb-4">Shopping Cart</h1>

    @if(session('warning'))
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        {{ session('warning') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div id="cart-content">
    @if(count($cart) > 0)
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body" id="cart-items">
                    @foreach($cart as $id => $item)
                    @php
                        $product = \App\Models\Product::find($id);
                        $stockStatus = $product ? ($product->stock < $item['quantity'] ? 'warning' : 'success') : 'danger';
                    @endphp
                    <div class="cart-item row mb-3 pb-3 border-bottom align-items-center" data-id="{{ $id }}">
                        <div class="col-md-2">
                            <img src="{{ $item['image'] ? asset($item['image']) : 'https://via.placeholder.com/100' }}" class="img-fluid rounded" alt="{{ $item['name'] }}">
                        </div>
                        <div class="col-md-4">
                            <h5 class="mb-1">{{ $item['name'] }}</h5>
                            <p class="text-muted mb-1">₱<span class="item-price">{{ number_format($item['price'], 2) }}</span></p>
                            @if($product)
                                @if($product->stock <= 0)
                                    <span class="badge bg-danger stock-badge">Out of Stock</span>
                                @elseif($product->stock < $item['quantity'])
                                    <span class="badge bg-warning text-dark stock-badge">Only {{ $product->stock }} left</span>
                                @elseif($product->stock < 10)
                                    <span class="badge bg-info text-dark stock-badge">{{ $product->stock }} in stock</span>
                                @endif
                            @else
                                <span class="badge bg-danger stock-badge">Product unavailable</span>
                            @endif
                        </div>
                        <div class="col-md-3">
                            <div class="input-group input-group-sm">
                                <button class="btn btn-outline-secondary qty-btn" type="button" onclick="updateQuantity({{ $id }}, 'decrease')" {{ !$product || $product->stock <= 0 ? 'disabled' : '' }}>
                                    <i class="fas fa-minus"></i>
                                </button>
                                <input type="number"
                                       class="form-control text-center quantity-input"
                                       value="{{ $item['quantity'] }}"
                                       min="1"
                                       max="{{ $product ? $product->stock : $item['quantity'] }}"
                                       data-id="{{ $id }}"
                                       onchange="updateQuantityInput({{ $id }})"
                                       {{ !$product || $product->stock <= 0 ? 'disabled' : '' }}>
                                <button class="btn btn-outline-secondary qty-btn" type="button" onclick="updateQuantity({{ $id }}, 'increase')" {{ !$product || $product->stock <= 0 ? 'disabled' : '' }}>
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                            @if($product && $product->stock > 0)
                                <small class="text-muted">Max: {{ $product->stock }}</small>
                            @endif
                        </div>
                        <div class="col-md-2 text-end">
                            <p class="fw-bold mb-0">₱<span class="item-total">{{ number_format($item['price'] * $item['quantity'], 2) }}</span></p>
                        </div>
                        <div class="col-md-1 text-end">
                            <button class="btn btn-danger btn-sm" onclick="removeItem({{ $id }})" title="Remove item">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                    @endforeach

                    <div class="mt-3">
                        <button class="btn btn-outline-danger" onclick="clearCart()">
                            <i class="fas fa-trash-alt"></i> Clear Cart
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card sticky-top" style="top: 20px;">
                <div class="card-header bg-primary text-white" >
                    <h5 class="mb-0" id="modal-title">Order Summary</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span>Subtotal (<span id="cart-count">{{ count($cart) }}</span> items):</span>
                        <span>₱<span id="cart-subtotal">{{ number_format($total, 2) }}</span></span>
                    </div>
                    <div class="d-flex justify-content-between mb-2 text-muted">
                        <small>Shipping:</small>
                        <small>Calculated at checkout</small>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between mb-3">
                        <strong>Total:</strong>
                        <strong class="text-primary fs-4">₱<span id="cart-total">{{ number_format($total, 2) }}</span></strong>
                    </div>

                    @php
                        $hasOutOfStock = false;
                        foreach($cart as $id => $item) {
                            $product = \App\Models\Product::find($id);
                            if (!$product || $product->stock <= 0) {
                                $hasOutOfStock = true;
                                break;
                            }
                        }
                    @endphp

                    <div id="stock-warning" class="alert alert-danger mb-3" style="display: {{ $hasOutOfStock ? 'block' : 'none' }}">
                        <small>Please remove out-of-stock items before checkout.</small>
                    </div>

                    @auth
                        <a href="{{ route('checkout.index') }}"
                           id="checkout-btn"
                           class="btn btn-primary w-100 {{ $hasOutOfStock ? 'disabled' : '' }}"
                           {{ $hasOutOfStock ? 'aria-disabled=true' : '' }}>
                            Proceed to Checkout
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-primary w-100">Login to Checkout</a>
                    @endauth
                    <a href="{{ route('products.index') }}" class="btn btn-outline-secondary w-100 mt-2">Continue Shopping</a>
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="text-center py-5" id="empty-cart">
        <i class="fas fa-shopping-cart fa-5x text-muted mb-3"></i>
        <h3>Your cart is empty</h3>
        <p class="text-muted">Add some products to get started!</p>
        <a href="{{ route('products.index') }}" class="btn btn-primary mt-3">
            <i class="fas fa-shopping-bag"></i> Start Shopping
        </a>
    </div>
    @endif
    </div>
</div>

<!-- Toast for notifications -->
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
    <div id="cartToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
            <strong class="me-auto">Cart</strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body" id="toast-message"></div>
    </div>
</div>
@endsection

@push('scripts')
<script>
const csrf = '{{ csrf_token() }}';

function showToast(message, type = 'success') {
    // Use the global showGlobalToast function if available
    if (window.showGlobalToast) {
        window.showGlobalToast(message, type);
        return;
    }

    // Fallback to local toast
    const toast = document.getElementById('cartToast');
    const toastBody = document.getElementById('toast-message');
    const toastHeader = toast.querySelector('.toast-header');

    toastHeader.className = `toast-header bg-${type === 'success' ? 'success' : 'danger'} text-white`;
    toastBody.textContent = message;

    const bsToast = new window.bootstrap.Toast(toast);
    bsToast.show();
}

function updateCartUI(data) {
    if (data.cartTotal !== undefined) {
        document.getElementById('cart-total').textContent = parseFloat(data.cartTotal).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        document.getElementById('cart-subtotal').textContent = parseFloat(data.cartTotal).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

    if (data.cartCount !== undefined) {
        document.getElementById('cart-count').textContent = data.cartCount;
        const badge = document.querySelector('.navbar .badge');
        if (badge) {
            if (data.cartCount > 0) {
                badge.textContent = data.cartCount;
                badge.style.display = 'inline-block';
            } else {
                badge.style.display = 'none';
            }
        }
    }
}

function updateQuantity(id, action) {
    const input = document.querySelector(`input[data-id="${id}"]`);
    let currentQty = parseInt(input.value);
    const max = parseInt(input.max);

    if (action === 'increase' && currentQty < max) {
        currentQty++;
    } else if (action === 'decrease' && currentQty > 1) {
        currentQty--;
    } else {
        return;
    }

    input.value = currentQty;
    updateCart(id, currentQty);
}

function updateQuantityInput(id) {
    const input = document.querySelector(`input[data-id="${id}"]`);
    const qty = parseInt(input.value);
    const max = parseInt(input.max);

    if (isNaN(qty) || qty < 1) {
        input.value = 1;
        updateCart(id, 1);
    } else if (qty > max) {
        input.value = max;
        showToast(`Only ${max} units available`, 'danger');
        updateCart(id, max);
    } else {
        updateCart(id, qty);
    }
}

function updateCart(id, quantity) {
    // Disable all quantity buttons during update
    document.querySelectorAll('.qty-btn').forEach(btn => btn.disabled = true);

    fetch(`/cart/update/${id}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrf,
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify({ quantity: quantity })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update item total
            const itemElement = document.querySelector(`.cart-item[data-id="${id}"]`);
            if (itemElement) {
                const itemTotal = itemElement.querySelector('.item-total');
                itemTotal.textContent = parseFloat(data.itemTotal).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            }

            // Update cart totals
            updateCartUI(data);

            showToast(data.message);
        } else {
            showToast(data.message, 'danger');

            // Revert quantity on error
            if (data.maxStock) {
                document.querySelector(`input[data-id="${id}"]`).value = data.maxStock;
            }
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('Failed to update cart', 'danger');
    })
    .finally(() => {
        // Re-enable quantity buttons
        document.querySelectorAll('.qty-btn').forEach(btn => btn.disabled = false);
    });
}

function removeItem(id) {
    if (!confirm('Remove this item from cart?')) return;

    fetch(`/cart/remove/${id}`, {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrf,
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Remove item from DOM
            const itemElement = document.querySelector(`.cart-item[data-id="${id}"]`);
            if (itemElement) {
                itemElement.remove();
            }

            // Update cart UI
            updateCartUI(data);

            // Show empty cart message if no items left
            if (data.isEmpty) {
                document.getElementById('cart-content').innerHTML = `
                    <div class="text-center py-5" id="empty-cart">
                        <i class="fas fa-shopping-cart fa-5x text-muted mb-3"></i>
                        <h3>Your cart is empty</h3>
                        <p class="text-muted">Add some products to get started!</p>
                        <a href="{{ route('products.index') }}" class="btn btn-primary mt-3">
                            <i class="fas fa-shopping-bag"></i> Start Shopping
                        </a>
                    </div>
                `;
            }

            showToast(data.message);
        } else {
            showToast(data.message, 'danger');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('Failed to remove item', 'danger');
    });
}

function clearCart() {
    if (!confirm('Are you sure you want to clear your cart?')) return;

    fetch('/cart/clear', {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrf,
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            showToast(data.message, 'danger');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('Failed to clear cart', 'danger');
    });
}
</script>
@endpush
