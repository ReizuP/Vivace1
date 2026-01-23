@extends('layouts.app')

@section('title', 'Vivace - Premium Musical Instruments')

@section('content')
<!-- Breadcrumb Navigation -->
<x-breadcrumb :items="[]" />

<!-- Hero Section with Slider -->
<section class="hero-slider position-relative">
    @php
        // Hero background images - using high-quality Unsplash images
        $heroSlides = [
            [
                'image' => 'https://images.unsplash.com/photo-1493225457124-a3eb161ffa5f?w=1920&q=80',
                'title' => 'Quality You Can Trust',
                'subtitle' => '100% authentic instruments from trusted brands worldwide.'
            ],
            [
                'image' => 'https://images.unsplash.com/photo-1511379938547-c1f69419868d?w=1920&q=80',
                'title' => 'Quality You Can Trust',
                'subtitle' => '100% authentic instruments from trusted brands worldwide.'
            ],
            [
                'image' => 'https://images.unsplash.com/photo-1520523839897-bd0b52f945a0?w=1920&q=80',
                'title' => 'Quality You Can Trust',
                'subtitle' => '100% authentic instruments from trusted brands worldwide.'
            ]
        ];
        
        // Fallback to local image if available
        $localImage = asset('images/products/Banner no text.png');
        if (file_exists(public_path('images/products/Banner no text.png'))) {
            $heroSlides[0]['image'] = $localImage;
        }
    @endphp
    
    @foreach($heroSlides as $index => $slide)
        <div class="hero-slide {{ $index === 0 ? 'active' : '' }}" 
             style="background-image: url('{{ $slide['image'] }}');">
        </div>
    @endforeach
    
    <div class="hero-overlay"></div>
    
    <div class="hero-content">
        <div class="container">
            <h1 id="heroTitle">Quality You Can Trust</h1>
            <p id="heroSubtitle">100% authentic instruments from trusted brands worldwide.</p>
            
            <!-- Hero Search Bar -->
            <div class="hero-search">
                <form action="{{ route('products.index') }}" method="GET" id="heroSearchForm">
                    <div class="input-group input-group-lg position-relative">
                        <input type="text" 
                               class="form-control" 
                               name="search" 
                               id="heroSearch" 
                               placeholder="Search for guitars, keyboards, drums..." 
                               autocomplete="off">
                        <button class="btn btn-primary" type="submit">
                            <i class="fas fa-search"></i> Search
                        </button>
                    </div>
                </form>
                <div class="search-wrap">
                    <div class="search-autocomplete hero-search-autocomplete" id="heroSearchAutocomplete"></div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Shop by Category Section -->
<section class="section">
    <div class="container">
        <div class="section-title">
            <h2>Shop by Category</h2>
            <p class="text-muted">Explore our wide range of musical instruments</p>
        </div>
        <div class="row g-4">
            @foreach($categories as $category)
                <div class="col-lg-2 col-md-4 col-sm-6">
                    <x-category-card :category="$category" />
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Featured Products Section -->
<section class="section" style="background-color: var(--color-muted);">
    <div class="container">
        <div class="section-title">
            <h2>Featured Products</h2>
            <p class="text-muted">Handpicked premium instruments for you</p>
        </div>
        <div class="row g-4">
            @forelse($featuredProducts as $product)
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <x-product-card :product="$product" :showSocialProof="true" />
                </div>
            @empty
                <div class="col-12 text-center">
                    <p class="text-muted">No featured products available at the moment.</p>
                </div>
            @endforelse
        </div>
        <div class="text-center mt-4">
            <a href="{{ route('products.index') }}" class="btn btn-primary btn-lg">
                View All Products <i class="fas fa-arrow-right ms-2"></i>
            </a>
        </div>
    </div>
</section>

<!-- Best Sellers Section -->
<section class="section">
    <div class="container">
        <div class="section-title">
            <h2>🔥 Best Sellers</h2>
            <p class="text-muted">Most popular instruments loved by musicians</p>
        </div>
        <div class="row g-4">
            @forelse($bestSellers as $product)
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="position-relative">
                        <span class="badge bg-danger position-absolute top-0 start-0 m-2" style="z-index: 10;">
                            🔥 Best Seller
                        </span>
                        <x-product-card :product="$product" :showSocialProof="true" />
                    </div>
                </div>
            @empty
                <div class="col-12 text-center">
                    <p class="text-muted">No best sellers available at the moment.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>

<!-- Recently Viewed Products Section -->
@if($recentlyViewed->count() > 0)
<section class="section" style="background-color: var(--color-muted);">
    <div class="container">
        <div class="section-title">
            <h2>Recently Viewed</h2>
            <p class="text-muted">Continue exploring what caught your eye</p>
        </div>
        <div class="row g-4">
            @foreach($recentlyViewed as $product)
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <x-product-card :product="$product" />
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Why Choose VIVACE Section -->
<section class="section">
    <div class="container">
        <div class="section-title">
            <h2>Why Choose VIVACE</h2>
            <p class="text-muted">Experience the difference of premium service</p>
        </div>
        <div class="row g-4">
            <div class="col-lg-3 col-md-6">
                <x-feature-button title="Fast & Secure Shipping" description="Tracked delivery, careful handling, and insured transit.">
                    <x-slot:icon>
                        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M3 7h11v10H3z"/>
                            <path d="M14 10h4l3 3v4h-7z"/>
                            <circle cx="7" cy="18" r="2"/>
                            <circle cx="18" cy="18" r="2"/>
                        </svg>
                    </x-slot:icon>
                </x-feature-button>
            </div>
            <div class="col-lg-3 col-md-6">
                <x-feature-button title="Authentic Instruments" description="Only trusted brands and verified stock—no replicas.">
                    <x-slot:icon>
                        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 2l7 4v6c0 5-3 9-7 10C8 21 5 17 5 12V6z"/>
                            <path d="M9 12l2 2 4-5"/>
                        </svg>
                    </x-slot:icon>
                </x-feature-button>
            </div>
            <div class="col-lg-3 col-md-6">
                <x-feature-button title="Safe Checkout" description="Secure payments with encrypted processing and fraud checks.">
                    <x-slot:icon>
                        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <rect x="3" y="6" width="18" height="12" rx="2"/>
                            <path d="M3 10h18"/>
                            <path d="M7 15h4"/>
                        </svg>
                    </x-slot:icon>
                </x-feature-button>
            </div>
            <div class="col-lg-3 col-md-6">
                <x-feature-button title="Music Expert Support" description="Get recommendations from musicians who know the gear.">
                    <x-slot:icon>
                        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M4 12a8 8 0 0 1 16 0"/>
                            <path d="M4 12v5a2 2 0 0 0 2 2h2v-7H6a2 2 0 0 0-2 2z"/>
                            <path d="M20 12v5a2 2 0 0 1-2 2h-2v-7h2a2 2 0 0 1 2 2z"/>
                            <path d="M12 20v2"/>
                        </svg>
                    </x-slot:icon>
                </x-feature-button>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
// Hero Slider Functionality
let currentSlide = 0;
const slides = document.querySelectorAll('.hero-slide');
const heroTitle = document.getElementById('heroTitle');
const heroSubtitle = document.getElementById('heroSubtitle');
const heroSlides = @json($heroSlides);

// Rotating hero copy (clean + shop-focused)
const heroCopy = [
    { title: 'Quality You Can Trust', subtitle: '100% authentic instruments from trusted brands worldwide.' },
    { title: 'Find Your Next Instrument', subtitle: 'Browse guitars, keys, drums, winds, strings, and more.' },
    { title: 'Built for Musicians', subtitle: 'Premium gear with dependable support and fast delivery.' },
];
let currentCopy = 0;

function setHeroCopy(nextIdx) {
    if (!heroTitle || !heroSubtitle) return;
    heroTitle.classList.add('hero-fade');
    heroSubtitle.classList.add('hero-fade');
    setTimeout(() => {
        heroTitle.textContent = heroCopy[nextIdx].title;
        heroSubtitle.textContent = heroCopy[nextIdx].subtitle;
        heroTitle.classList.remove('hero-fade');
        heroSubtitle.classList.remove('hero-fade');
    }, 250);
}

function showSlide(index) {
    // Hide all slides
    slides.forEach(slide => slide.classList.remove('active'));
    
    // Show current slide
    if (slides[index]) {
        slides[index].classList.add('active');
    }
}

function changeSlide(direction) {
    currentSlide += direction;
    if (currentSlide >= slides.length) {
        currentSlide = 0;
    } else if (currentSlide < 0) {
        currentSlide = slides.length - 1;
    }
    showSlide(currentSlide);
}

// Auto-rotate slider
let sliderInterval = setInterval(() => {
    changeSlide(1);
}, 5000); // Change slide every 5 seconds

// Pause on hover
const heroSlider = document.querySelector('.hero-slider');
if (heroSlider) {
    heroSlider.addEventListener('mouseenter', () => {
        clearInterval(sliderInterval);
    });
    
    heroSlider.addEventListener('mouseleave', () => {
        sliderInterval = setInterval(() => {
            changeSlide(1);
        }, 5000);
    });
}

// Hero Search Autocomplete
(function() {
    const heroSearchInput = document.getElementById('heroSearch');
    if (heroSearchInput) {
        heroSearchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                document.getElementById('heroSearchForm').submit();
            }
        });
    }
})();

// Auto-rotate hero text every 5s
setInterval(() => {
    currentCopy = (currentCopy + 1) % heroCopy.length;
    setHeroCopy(currentCopy);
}, 5000);
</script>
@endpush
