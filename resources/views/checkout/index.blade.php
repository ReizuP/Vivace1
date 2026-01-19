@extends('layouts.app')

@section('content')
<div class="container my-5">
    <h1 class="mb-4">Checkout</h1>
    
    <form action="{{ route('checkout.process') }}" method="POST" id="checkoutForm">
        @csrf
        <div class="row">
            <div class="col-md-8">
                <!-- Shipping Information -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-shipping-fast"></i> Shipping Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Full Name <span class="text-danger">*</span></label>
                            <input type="text" 
                                   name="shipping_name" 
                                   class="form-control @error('shipping_name') is-invalid @enderror" 
                                   value="{{ old('shipping_name', $user->name) }}" 
                                   required>
                            @error('shipping_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Letters and spaces only</small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Phone Number <span class="text-danger">*</span></label>
                            <input type="text" 
                                   name="shipping_phone" 
                                   class="form-control @error('shipping_phone') is-invalid @enderror" 
                                   value="{{ old('shipping_phone', $user->phone) }}" 
                                   placeholder="09171234567 or +639171234567"
                                   required>
                            @error('shipping_phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Philippine mobile number</small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Address <span class="text-danger">*</span></label>
                            <textarea name="shipping_address" 
                                      class="form-control @error('shipping_address') is-invalid @enderror" 
                                      rows="3" 
                                      placeholder="House/Building No., Street Name, Barangay"
                                      required>{{ old('shipping_address', $user->address) }}</textarea>
                            @error('shipping_address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Minimum 10 characters</small>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">City <span class="text-danger">*</span></label>
                                <input type="text" 
                                       name="shipping_city" 
                                       class="form-control @error('shipping_city') is-invalid @enderror" 
                                       value="{{ old('shipping_city', $user->city) }}" 
                                       required>
                                @error('shipping_city')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Postal Code <span class="text-danger">*</span></label>
                                <input type="text" 
                                       name="shipping_postal_code" 
                                       class="form-control @error('shipping_postal_code') is-invalid @enderror" 
                                       value="{{ old('shipping_postal_code', $user->postal_code) }}" 
                                       placeholder="1234"
                                       maxlength="4"
                                       required>
                                @error('shipping_postal_code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">4 digits</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Payment Method -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-credit-card"></i> Payment Method</h5>
                    </div>
                    <div class="card-body">
                        <!-- Cash on Delivery -->
                        <div class="form-check mb-3 p-3 border rounded payment-option" data-method="cod">
                            <input class="form-check-input" 
                                   type="radio" 
                                   name="payment_method" 
                                   id="cod" 
                                   value="cod" 
                                   {{ old('payment_method', 'cod') == 'cod' ? 'checked' : '' }}>
                            <label class="form-check-label w-100" for="cod">
                                <strong><i class="fas fa-money-bill-wave me-2"></i>Cash on Delivery (COD)</strong>
                                <p class="text-muted mb-0 small">Pay when you receive your order</p>
                            </label>
                        </div>

                        <!-- Credit/Debit Card -->
                        <div class="form-check mb-3 p-3 border rounded payment-option" data-method="card">
                            <input class="form-check-input" 
                                   type="radio" 
                                   name="payment_method" 
                                   id="card" 
                                   value="card"
                                   {{ old('payment_method') == 'card' ? 'checked' : '' }}>
                            <label class="form-check-label w-100" for="card">
                                <strong><i class="fas fa-credit-card me-2"></i>Credit/Debit Card</strong>
                                <p class="text-muted mb-0 small">Pay securely with your card</p>
                            </label>
                            
                            <div class="payment-details mt-3" id="card-details" style="display: {{ old('payment_method') == 'card' ? 'block' : 'none' }}">
                                <div class="mb-3">
                                    <label class="form-label">Card Number</label>
                                    <input type="text" 
                                           name="card_number" 
                                           class="form-control @error('card_number') is-invalid @enderror" 
                                           placeholder="1234 5678 9012 3456"
                                           maxlength="16"
                                           value="{{ old('card_number') }}">
                                    @error('card_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Test card: 4532015112830366 (Success) | 4111111111111111 (Decline)</small>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Cardholder Name</label>
                                    <input type="text" 
                                           name="card_name" 
                                           class="form-control @error('card_name') is-invalid @enderror" 
                                           placeholder="John Doe"
                                           value="{{ old('card_name') }}">
                                    @error('card_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Expiry Date</label>
                                        <input type="text" 
                                               name="card_expiry" 
                                               class="form-control @error('card_expiry') is-invalid @enderror" 
                                               placeholder="MM/YY"
                                               maxlength="5"
                                               value="{{ old('card_expiry') }}">
                                        @error('card_expiry')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">CVV</label>
                                        <input type="text" 
                                               name="card_cvv" 
                                               class="form-control @error('card_cvv') is-invalid @enderror" 
                                               placeholder="123"
                                               maxlength="3"
                                               value="{{ old('card_cvv') }}">
                                        @error('card_cvv')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- GCash -->
                        <div class="form-check mb-3 p-3 border rounded payment-option" data-method="gcash">
                            <input class="form-check-input" 
                                   type="radio" 
                                   name="payment_method" 
                                   id="gcash" 
                                   value="gcash"
                                   {{ old('payment_method') == 'gcash' ? 'checked' : '' }}>
                            <label class="form-check-label w-100" for="gcash">
                                <strong><i class="fas fa-mobile-alt me-2"></i>GCash</strong>
                                <p class="text-muted mb-0 small">Pay using your GCash wallet</p>
                            </label>
                            
                            <div class="payment-details mt-3" id="gcash-details" style="display: {{ old('payment_method') == 'gcash' ? 'block' : 'none' }}">
                                <div class="mb-3">
                                    <label class="form-label">GCash Mobile Number</label>
                                    <input type="text" 
                                           name="gcash_number" 
                                           class="form-control @error('gcash_number') is-invalid @enderror" 
                                           placeholder="09171234567"
                                           value="{{ old('gcash_number') }}">
                                    @error('gcash_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="alert alert-info">
                                    <small><i class="fas fa-info-circle"></i> You'll be redirected to GCash to complete payment</small>
                                </div>
                            </div>
                        </div>

                        <!-- Bank Transfer -->
                        <div class="form-check p-3 border rounded payment-option" data-method="bank">
                            <input class="form-check-input" 
                                   type="radio" 
                                   name="payment_method" 
                                   id="bank" 
                                   value="bank_transfer"
                                   {{ old('payment_method') == 'bank_transfer' ? 'checked' : '' }}>
                            <label class="form-check-label w-100" for="bank">
                                <strong><i class="fas fa-university me-2"></i>Bank Transfer</strong>
                                <p class="text-muted mb-0 small">Transfer to our bank account</p>
                            </label>
                        </div>

                        @error('payment_method')
                            <div class="text-danger small mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="col-md-4">
                <div class="card sticky-top" style="top: 20px;">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Order Summary</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3" style="max-height: 300px; overflow-y: auto;">
                            @foreach($validatedCart as $item)
                            <div class="d-flex justify-content-between mb-2 pb-2 border-bottom">
                                <div class="flex-grow-1">
                                    <small class="d-block">{{ $item['name'] }}</small>
                                    <small class="text-muted">₱{{ number_format($item['price'], 2) }} × {{ $item['quantity'] }}</small>
                                </div>
                                <div class="text-end">
                                    <small class="fw-bold">₱{{ number_format($item['price'] * $item['quantity'], 2) }}</small>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        
                        <hr>
                        
                        <div class="d-flex justify-content-between mb-2">
                            <span>Subtotal:</span>
                            <span>₱{{ number_format($total, 2) }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2 text-muted">
                            <small>Shipping:</small>
                            <small>FREE</small>
                        </div>
                        
                        <hr>
                        
                        <div class="d-flex justify-content-between mb-3">
                            <strong>Total:</strong>
                            <strong class="text-primary fs-4">₱{{ number_format($total, 2) }}</strong>
                        </div>
                        
                        <button type="submit" class="btn btn-primary w-100 btn-lg mb-2" id="placeOrderBtn">
                            <i class="fas fa-lock"></i> Place Order
                        </button>
                        
                        <a href="{{ route('cart.index') }}" class="btn btn-outline-secondary w-100">
                            <i class="fas fa-arrow-left"></i> Back to Cart
                        </a>
                        
                        <div class="mt-3 text-center">
                            <small class="text-muted">
                                <i class="fas fa-shield-alt"></i> Secure Checkout
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
// Handle payment method selection
document.querySelectorAll('input[name="payment_method"]').forEach(radio => {
    radio.addEventListener('change', function() {
        // Hide all payment details
        document.querySelectorAll('.payment-details').forEach(details => {
            details.style.display = 'none';
        });
        
        // Show selected payment details
        if (this.value === 'card') {
            document.getElementById('card-details').style.display = 'block';
        } else if (this.value === 'gcash') {
            document.getElementById('gcash-details').style.display = 'block';
        }
    });
});

// Format card number input
document.querySelector('input[name="card_number"]')?.addEventListener('input', function(e) {
    this.value = this.value.replace(/\D/g, '');
});

// Format card expiry input
document.querySelector('input[name="card_expiry"]')?.addEventListener('input', function(e) {
    let value = this.value.replace(/\D/g, '');
    if (value.length >= 2) {
        value = value.substring(0, 2) + '/' + value.substring(2, 4);
    }
    this.value = value;
});

// Format CVV input
document.querySelector('input[name="card_cvv"]')?.addEventListener('input', function(e) {
    this.value = this.value.replace(/\D/g, '');
});

// Form submission
document.getElementById('checkoutForm').addEventListener('submit', function(e) {
    const btn = document.getElementById('placeOrderBtn');
    btn.disabled = true;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Processing...';
});

// Postal code validation
document.querySelector('input[name="shipping_postal_code"]')?.addEventListener('input', function(e) {
    this.value = this.value.replace(/\D/g, '');
});
</script>
@endpush
