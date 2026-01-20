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
                <strong>In Stock:</strong> <span id="stock-count">{{ $product->stock }}</span> units available
            </div>

            @if($product->stock > 0)
            <form id="addToCartForm" class="mt-4">
                @csrf
                <div class="input-group mb-3" style="max-width: 200px;">
                    <button class="btn btn-outline-secondary" type="button" onclick="decrementQty()">
                        <i class="fas fa-minus"></i>
                    </button>
                    <input type="number" 
                           id="quantity" 
                           name="quantity" 
                           class="form-control text-center" 
                           value="1" 
                           min="1" 
                           max="{{ $product->stock }}">
                    <button class="btn btn-outline-secondary" type="button" onclick="incrementQty()">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>
                <button type="submit" class="btn btn-primary btn-lg" id="addToCartBtn">
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

<!-- Toast for notifications -->
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
    <div id="productToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
            <strong class="me-auto">Notification</strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body" id="toast-message"></div>
    </div>
</div>
@endsection

@push('scripts')
<script>
const maxStock = {{ $product->stock }};

function incrementQty() {
    const input = document.getElementById('quantity');
    const currentValue = parseInt(input.value);
    if (currentValue < maxStock) {
        input.value = currentValue + 1;
    }
}

function decrementQty() {
    const input = document.getElementById('quantity');
    const currentValue = parseInt(input.value);
    if (currentValue > 1) {
        input.value = currentValue - 1;
    }
}

function showToast(message, type = 'success') {
    // Use the global showGlobalToast function if available
    if (window.showGlobalToast) {
        window.showGlobalToast(message, type);
        return;
    }
    
    // Fallback to local toast
    const toast = document.getElementById('productToast');
    const toastBody = document.getElementById('toast-message');
    const toastHeader = toast.querySelector('.toast-header');
    
    toastHeader.className = `toast-header bg-${type === 'success' ? 'success' : 'danger'} text-white`;
    toastBody.textContent = message;
    
    const bsToast = new window.bootstrap.Toast(toast);
    bsToast.show();
}

function updateCartBadge(count) {
    const badge = document.querySelector('.navbar .badge');
    if (badge) {
        if (count > 0) {
            badge.textContent = count;
            badge.style.display = 'inline-block';
        } else {
            badge.style.display = 'none';
        }
    }
}

document.getElementById('addToCartForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const btn = document.getElementById('addToCartBtn');
    const originalText = btn.innerHTML;
    btn.disabled = true;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Adding...';
    
    const quantity = document.getElementById('quantity').value;
    const productId = {{ $product->id }};
    
    fetch(`/cart/add/${productId}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify({ quantity: quantity })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showToast(data.message, 'success');
            updateCartBadge(data.cartCount);
            
            // Reset quantity to 1
            document.getElementById('quantity').value = 1;
        } else {
            showToast(data.message, 'danger');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('Failed to add to cart. Please try again.', 'danger');
    })
    .finally(() => {
        btn.disabled = false;
        btn.innerHTML = originalText;
    });
});

// Validate quantity input
document.getElementById('quantity').addEventListener('input', function() {
    let value = parseInt(this.value);
    if (isNaN(value) || value < 1) {
        this.value = 1;
    } else if (value > maxStock) {
        this.value = maxStock;
        showToast(`Only ${maxStock} units available`, 'danger');
    }
});
</script>
@endpush
