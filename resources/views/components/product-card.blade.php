@props(['product'])

<div class="product-card-wrapper">
    <a href="{{ route('products.show', $product->slug) }}" class="text-decoration-none product-card-link">
        <div class="card product-card h-100 position-relative">
            @if($product->featured)
                <span class="badge bg-warning text-dark position-absolute top-0 end-0 m-2">✨ Featured</span>
            @endif
            
            <div class="product-image-wrapper position-relative overflow-hidden">
                @if($product->image && file_exists(public_path($product->image)))
                    <img src="{{ asset($product->image) }}" 
                         class="card-img-top product-image" 
                         alt="{{ $product->name }}" 
                         style="height: 250px; object-fit: cover; transition: transform 0.3s ease;">
                @else
                    <div class="product-image-placeholder" style="height: 250px; display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, var(--color-muted), var(--color-mute));">
                        <i class="fas fa-music" style="font-size: 3rem; color: var(--color-muted-foreground); opacity: 0.3;"></i>
                    </div>
                @endif
            </div>
            
            <div class="card-body d-flex flex-column">
                <h6 class="card-title product-name mb-2">{{ $product->name }}</h6>
                <p class="card-text text-muted small mb-2 flex-grow-1">{{ Str::limit($product->description, 60) }}</p>
                
                <div class="d-flex align-items-center mb-2">
                    <div class="rating-stars text-warning">
                        @for($i = 0; $i < 5; $i++)
                            <i class="fas fa-star{{ $i < 4 ? '' : '-half-alt' }}"></i>
                        @endfor
                    </div>
                    <small class="text-muted ms-2">(4.5)</small>
                </div>
                
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <p class="fw-bold mb-0 product-price">₱{{ number_format($product->price, 2) }}</p>
                    @if($product->stock > 0)
                        <small class="text-success">
                            <i class="fas fa-check-circle"></i> In Stock
                        </small>
                    @else
                        <small class="text-danger">
                            <i class="fas fa-times-circle"></i> Out of Stock
                        </small>
                    @endif
                </div>
                
                @if(isset($showSocialProof) && $showSocialProof)
                    <div class="social-proof mb-2">
                        <small class="text-muted">
                            <i class="fas fa-eye"></i> {{ rand(5, 50) }} viewing
                        </small>
                        <small class="text-muted ms-3">
                            <i class="fas fa-fire"></i> {{ rand(1, 20) }} sold today
                        </small>
                    </div>
                @endif
                
                @if($product->stock > 0)
                    <form action="{{ route('cart.add', $product->id) }}" method="POST" class="mt-auto" onclick="event.stopPropagation();">
                        @csrf
                        <button type="submit" class="btn btn-primary w-100 btn-sm">
                            <i class="fas fa-shopping-cart me-1"></i> Add to Cart
                        </button>
                    </form>
                @else
                    <button class="btn btn-secondary w-100 btn-sm" disabled>
                        <i class="fas fa-ban me-1"></i> Out of Stock
                    </button>
                @endif
            </div>
        </div>
    </a>
</div>

