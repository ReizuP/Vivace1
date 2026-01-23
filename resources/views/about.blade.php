@extends('layouts.app')

@section('title', 'About Us - Vivace')

@section('content')
<!-- Hero Section -->
<div class="about-hero text-center py-5" style="background: linear-gradient(135deg, var(--color-muted), var(--color-card)); border-bottom: 3px solid var(--primary);">
    <div class="container">
        <h1 class="display-4 mb-3" style="color: var(--primary);">About Vivace Music Shop</h1>
        <p class="lead" style="color: var(--body-color); max-width: 800px; margin: 0 auto;">
            We've been helping musicians find their voice through quality instruments and exceptional service.
        </p>
    </div>
</div>

<!-- Our Story Section -->
<section class="container my-5 py-4">
    <div class="row align-items-center">
        <div class="col-lg-6 mb-4 mb-lg-0">
            <h2 class="mb-4">Our Story</h2>
            <p class="lead mb-4">Vivace Music Shop was born from a simple belief: every musician deserves access to quality instruments that inspire creativity and passion.</p>
            <p>Founded in 2026, we started as a small shop with a big dream. Today, we're proud to serve musicians of all levels—from curious beginners taking their first steps into music, to seasoned professionals seeking that perfect sound.</p>
            <p>Our mission remains unchanged: to help you find the instrument that speaks to your soul and supports your musical journey, wherever it may lead.</p>
        </div>
        <div class="col-lg-6">
            <img src="https://www.theamericanacademy.com/cdn/shop/products/art212_3024x.jpg?v=1566336034" 
                 alt="Vivace Music Shop Interior" 
                 class="img-fluid rounded shadow-lg"
                 style="border: 3px solid var(--primary);">
        </div>
    </div>
</section>

<!-- Why Choose Us Section -->
<section class="py-5" style="background-color: var(--color-muted);">
    <div class="container">
        <h2 class="text-center mb-5">Why Choose Vivace?</h2>
        <div class="row g-4">
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 border-0 shadow-sm" style="transition: transform 0.3s ease;">
                    <div class="card-body text-center p-4">
                        <div class="mb-3" style="color: var(--primary); font-size: 3rem;">
                            <i class="fas fa-guitar"></i>
                        </div>
                        <h4 class="card-title mb-3" style="color: var(--primary);">Wide Selection</h4>
                        <p class="card-text">From guitars and keyboards to orchestral instruments, our curated inventory features time-tested classics and innovative new designs from renowned manufacturers.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 border-0 shadow-sm" style="transition: transform 0.3s ease;">
                    <div class="card-body text-center p-4">
                        <div class="mb-3" style="color: var(--primary); font-size: 3rem;">
                            <i class="fas fa-user-tie"></i>
                        </div>
                        <h4 class="card-title mb-3" style="color: var(--primary);">Expert Advice</h4>
                        <p class="card-text">Our team are passionate musicians who understand the nuances of each instrument. You'll get genuine advice from people who truly understand your needs.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 border-0 shadow-sm" style="transition: transform 0.3s ease;">
                    <div class="card-body text-center p-4">
                        <div class="mb-3" style="color: var(--primary); font-size: 3rem;">
                            <i class="fas fa-tag"></i>
                        </div>
                        <h4 class="card-title mb-3" style="color: var(--primary);">Competitive Pricing</h4>
                        <p class="card-text">Quality instruments should be accessible. We offer competitive pricing, flexible payment options, and regular promotions to make your dream instrument attainable.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 border-0 shadow-sm" style="transition: transform 0.3s ease;">
                    <div class="card-body text-center p-4">
                        <div class="mb-3" style="color: var(--primary); font-size: 3rem;">
                            <i class="fas fa-tools"></i>
                        </div>
                        <h4 class="card-title mb-3" style="color: var(--primary);">After-Sales Support</h4>
                        <p class="card-text">Our relationship doesn't end at checkout. We provide instrument setup, maintenance advice, repair services, and ongoing guidance as your skills develop.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 border-0 shadow-sm" style="transition: transform 0.3s ease;">
                    <div class="card-body text-center p-4">
                        <div class="mb-3" style="color: var(--primary); font-size: 3rem;">
                            <i class="fas fa-award"></i>
                        </div>
                        <h4 class="card-title mb-3" style="color: var(--primary);">Trusted Reputation</h4>
                        <p class="card-text">Built on decades of satisfied customers, from weekend hobbyists to touring professionals. Music teachers recommend us, and families trust us.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 border-0 shadow-sm" style="transition: transform 0.3s ease;">
                    <div class="card-body text-center p-4">
                        <div class="mb-3" style="color: var(--primary); font-size: 3rem;">
                            <i class="fas fa-heart"></i>
                        </div>
                        <h4 class="card-title mb-3" style="color: var(--primary);">Passion for Music</h4>
                        <p class="card-text">We're not just a store—we're a community of music lovers dedicated to helping you find instruments that inspire creativity and bring joy to your life.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Meet the Team Section -->
<section class="container my-5 py-5">
    <div class="text-center mb-5">
        <h2 class="display-5 mb-3" style="color: var(--primary);">Meet the Team</h2>
        <p class="lead text-muted">The passionate musicians behind Vivace Music Shop</p>
    </div>
    
    <div class="row justify-content-center g-4">
        <!-- Team Member 1 -->
        <div class="col-6 col-md-4 col-lg-2 text-center">
            <div class="team-member">
                <div class="team-image-circle mb-3">
                    <img src="https://i.pinimg.com/736x/b7/a9/83/b7a983f4417a79a0b208d94a6971b852.jpg" 
                         alt="Danzel Bordeos" 
                         class="rounded-circle" 
                         style="width: 150px; height: 150px; object-fit: cover; border: 3px solid var(--primary);">
                </div>
                <h5 class="mb-1" style="color: var(--primary);">Danzel Bordeos</h5>
                <p class="text-muted small mb-0">Backend Developer</p>
            </div>
        </div>

        <!-- Team Member 2 -->
        <div class="col-6 col-md-4 col-lg-2 text-center">
            <div class="team-member">
                <div class="team-image-circle mb-3">
                    <img src="https://i.pinimg.com/736x/44/4c/6f/444c6f0ef0449622ed64d10f7814f0d1.jpg" 
                         alt="Leigh Andrew Tubo" 
                         class="rounded-circle" 
                         style="width: 150px; height: 150px; object-fit: cover; border: 3px solid var(--primary);">
                </div>
                <h5 class="mb-1" style="color: var(--primary);">Leigh Andrew Tubo</h5>
                <p class="text-muted small mb-0">Frontend Developer</p>
            </div>
        </div>

        <!-- Team Member 3 -->
        <div class="col-6 col-md-4 col-lg-2 text-center">
            <div class="team-member">
                <div class="team-image-circle mb-3">
                    <img src="https://i.pinimg.com/1200x/90/97/57/909757379021d77bd2bbf73e214d4d72.jpg" 
                         alt="Mary Ann Iniego" 
                         class="rounded-circle" 
                         style="width: 150px; height: 150px; object-fit: cover; border: 3px solid var(--primary);">
                </div>
                <h5 class="mb-1" style="color: var(--primary);">Mary Ann Iniego</h5>
                <p class="text-muted small mb-0">UI/UX Designer</p>
            </div>
        </div>

        <!-- Team Member 4 -->
        <div class="col-6 col-md-4 col-lg-2 text-center">
            <div class="team-member">
                <div class="team-image-circle mb-3">
                    <img src="https://i.pinimg.com/1200x/14/76/d8/1476d887b509305319b9d603a9b71df5.jpg" 
                         alt="Irish May Arabaca" 
                         class="rounded-circle" 
                         style="width: 150px; height: 150px; object-fit: cover; border: 3px solid var(--primary);">
                </div>
                <h5 class="mb-1" style="color: var(--primary);">Irish May Arabaca</h5>
                <p class="text-muted small mb-0">Documentation</p>
            </div>
        </div>

        <!-- Team Member 5 -->
        <div class="col-6 col-md-4 col-lg-2 text-center">
            <div class="team-member">
                <div class="team-image-circle mb-3">
                    <img src="https://i.pinimg.com/1200x/6c/72/0d/6c720dae20d73f219ddc6f08438c14e7.jpg" 
                         alt="Jhon Paul Bascara" 
                         class="rounded-circle" 
                         style="width: 150px; height: 150px; object-fit: cover; border: 3px solid var(--primary);">
                </div>
                <h5 class="mb-1" style="color: var(--primary);">Jhon Paul Bascara</h5>
                <p class="text-muted small mb-0">Documentation</p>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="py-5 text-center" style="background: linear-gradient(135deg, var(--primary), var(--primary-dark)); color: white;">
    <div class="container">
        <h2 class="mb-3" style="color: var(--light);">Ready to Find Your Perfect Instrument?</h2>
        <p class="lead mb-4" style="color: var(--light); opacity: 0.9;">Visit our shop or browse our collection online. Our team is here to help you every step of the way.</p>
        <a href="{{ route('products.index') }}" class="btn btn-light btn-lg me-3 mb-2" style="color: var(--primary); font-weight: 600;">
            <i class="fas fa-shopping-bag me-2"></i>Browse Products
        </a>
        <a href="{{ route('contact') }}" class="btn btn-outline-light btn-lg mb-2">
            <i class="fas fa-envelope me-2"></i>Contact Us
        </a>
    </div>
</section>

<style>
/* Card Hover Effects for Why Choose Us */
.card:hover {
    transform: translateY(-5px);
}

/* Smooth Transitions */
.card {
    transition: transform 0.3s ease;
}

/* Team Member Hover Effects */
.team-member {
    transition: transform 0.3s ease;
}

.team-member:hover {
    transform: translateY(-5px);
}

.team-member img {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.team-member:hover img {
    transform: scale(1.05);
    box-shadow: 0 8px 16px rgba(0,0,0,0.2);
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .display-4 {
        font-size: 2.5rem;
    }
    
    .display-5 {
        font-size: 2rem;
    }
    
    .team-member img {
        width: 120px !important;
        height: 120px !important;
    }
}
</style>
@endsection
