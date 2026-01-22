<!DOCTYPE html>
<html lang="en" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Vivace Music Shop')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
    /* Dark Mode (Default) */
    [data-theme="dark"] {
        --body-bg: #1a1a1a; /* Charcoal / Near-black */
        --body-color: #f5f0e8; /* Piano Ivory */
        --primary: #8b6f47; /* Gold */
        --primary-rgb: 212, 175, 55;
        --primary-dark: #a68a5c; /* Darker Gold */
        --secondary: #8b6f47; /* Warm Brown */
        --secondary-rgb: 139, 111, 71;
        --dark: #0a0a0a; /* Glossy Ebony */
        --light: #f5f0e8;
        --border-color-translucent: rgba(255, 255, 255, 0.1);
        --border-color: #6d6d6d;
        --color-card: #252525;
        --color-muted: #2d2d2d;
        --color-mute: #3d3d3d;
        --color-muted-foreground: #b8a98f;
        --gradient-primary: linear-gradient(135deg, #8b6f47, #a68a5c);
        --gradient-hero: linear-gradient(180deg, rgba(10, 10, 10, 0.7), #1a1a1a);
        --glow-primary: 0 0 40px rgba(212, 175, 55, 0.4);
        --glow-secondary: 0 0 30px rgba(212, 175, 55, 0.2);
        --shadow-card: 0 4px 20px rgba(0, 0, 0, 0.5);
        --shadow-hover: 0 8px 30px rgba(212, 175, 55, 0.3);
        --bs-border-radius: 0.5rem;
        --bs-border-radius-sm: 0.25rem;
        --bs-border-radius-lg: 0.75rem;
    }

    /* Light Mode - Golden/Warm Yellow Tones */
    [data-theme="light"] {
        --body-bg: #f5e6d3; /* Soft gold / warm yellow (main background) */
        --body-color: #2b1f16; /* Dark brown (not pure black) */
        --primary: #c9a961; /* Deeper gold accent */
        --primary-rgb: 201, 169, 97;
        --primary-dark: #a6894d;
        --secondary: #8b6f47; /* Warm brown */
        --secondary-rgb: 139, 111, 71;
        --dark: #2b1f16;
        --light: #f5e6d3;
        --border-color-translucent: rgba(0, 0, 0, 0.1);
        --border-color: #d4b896; /* Golden border */
        --color-card: #fef9f0; /* Warm off-white / light beige cards - lighter for contrast */
        --color-muted: #ead8c0; /* Slightly darker gold section blocks */
        --color-mute: #e0c9a8; /* Form inputs - golden tone */
        --color-muted-foreground: #6b5a45; /* Muted text */
        --gradient-primary: linear-gradient(135deg, #c9a961, #a6894d);
        --gradient-hero: linear-gradient(180deg, rgba(245, 230, 211, 0.85), rgba(245, 230, 211, 0.85));
        --glow-primary: 0 0 40px rgba(201, 169, 97, 0.3);
        --glow-secondary: 0 0 30px rgba(201, 169, 97, 0.2);
        --shadow-card: 0 4px 20px rgba(0, 0, 0, 0.12);
        --shadow-hover: 0 10px 30px rgba(201, 169, 97, 0.25);
        --bs-border-radius: 0.5rem;
        --bs-border-radius-sm: 0.25rem;
        --bs-border-radius-lg: 0.75rem;
    }
.bg-primary{ /* login- modal header  */
    background: var(--primary) !important;
    color: var(--light) !important;

}
.card-header{
    background: var(--primary) !important;
    color: var(--light) !important;
}
#modal-header{
    background: var(--primary) !important;
    color: var(--light) !important;
}
.form-select{ /*filterbar*/
    background-color: var(--color-muted);
    color: var(--body-color);
    border-color: var(--border-color);
}
option{ /*filterbar*/
    background-color: var(--color-card);
    color: var(--body-color);
}
    * {
        transition: background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease;
    }

    body {
        font-family: 'Playfair Display', -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', 'Oxygen', 'Ubuntu', 'Cantarell', 'Fira Sans', 'Droid Sans', 'Helvetica Neue', sans-serif;
        background-color: var(--body-bg);
        color: var(--body-color);
        min-height: 100vh;
    }


    /* Navbar */
    .navbar {
        background: linear-gradient(135deg, var(--dark) 0%, var(--primary) 100%);
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
    }

    .navbar-brand {
        font-family: 'Playfair Display', serif;
        color: var(--light);
        font-weight: 700;
    }

    .nav-link {
        color: white !important;
        transition: color 0.3s ease;
    }

    .nav-link:hover {
        color: var(--secondary) !important;
    }

    .navbar-nav .nav-item {
        margin-right: 10px;
        font-weight: 500;
    }

    .nav-link.active {
        color: var(--primary) !important;
        position: relative;
    }

    .nav-link.active::after {
        content: '';
        position: absolute;
        left: 0;
        right: 0;
        bottom: -4px;
        height: 2px;
        background: var(--primary);
        border-radius: 999px;
    }

    /* Prevent suggestion dropdown clipping */
    .navbar,
    .navbar .container,
    .navbar .collapse,
    .navbar .navbar-collapse {
        overflow: visible !important;
    }

    /* Search Bar */
    .navbar-search {
        flex: 1;
        max-width: 600px;
        width: 100%;
    }

    .search-wrap {
        position: relative;
        overflow: visible;
    }

    .navbar-search .navbar-nav {
        flex-direction: row;
    }

    .navbar-search .navbar-nav .nav-link {
        padding: 0.5rem 1rem;
    }

    .search-autocomplete {
        position: absolute;
        top: calc(100% + 6px);
        left: 0;
        width: 100%;
        background: var(--color-card);
        border: 1px solid var(--border-color);
        border-radius: var(--bs-border-radius);
        box-shadow: var(--shadow-card);
        max-height: 400px;
        overflow-y: auto;
        z-index: 3000;
        display: none;
    }

    .hero-search-autocomplete,
    .product-search-autocomplete {
        position: absolute;
        top: calc(100% + 6px);
        left: 0;
        width: 100%;
        background: var(--color-card);
        border: 1px solid var(--border-color);
        border-radius: var(--bs-border-radius);
        box-shadow: var(--shadow-card);
        max-height: 400px;
        overflow-y: auto;
        z-index: 3000;
        display: none;
    }

    .search-autocomplete.show {
        display: block;
    }

    .search-result-item {
        padding: 12px;
        border-bottom: 1px solid var(--border-color);
        cursor: pointer;
        display: flex;
        align-items: center;
        transition: background-color 0.2s;
    }

    .search-result-item:hover {
        background-color: var(--color-muted);
    }

    .search-result-item.active {
        background-color: var(--color-muted);
    }

    .search-result-item:last-child {
        border-bottom: none;
    }

    .search-result-image {
        width: 50px;
        height: 50px;
        object-fit: cover;
        border-radius: var(--bs-border-radius-sm);
        margin-right: 12px;
    }

    .search-match {
        font-weight: 600;
        color: var(--primary);
    }

    /* Theme Toggle */
    .theme-toggle {
        background: transparent;
        border: 2px solid var(--light);
        color: var(--light);
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .theme-toggle:hover {
        background: var(--primary);
        border-color: var(--primary);
        transform: scale(1.1);
    }

    /* Buttons */
    .btn-primary {
        background: var(--gradient-primary);
        border: none;
        color: var(--light);
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: var(--glow-primary);
        color: var(--light);
    }

    /* Cards */
    .card {
        background-color: var(--color-card);
        border-color: var(--border-color);
        color: var(--body-color);
        border-radius: var(--bs-border-radius-lg);
        box-shadow: var(--shadow-card);
        transition: all 0.3s ease;
    }

    .card-body {
        background-color: var(--color-card);
        color: var(--body-color);
    }

    .product-card {
        transition: all 0.3s ease;
        border: 2px solid transparent;
    }

    .product-card:hover {
        transform: translateY(-8px);
        box-shadow: var(--shadow-hover);
        border-color: var(--primary);
    }

    .product-card-link {
        text-decoration: none;
        color: inherit;
    }

    .product-image-wrapper {
        overflow: hidden;
        border-radius: var(--bs-border-radius-lg) var(--bs-border-radius-lg) 0 0;
    }

    .product-card:hover .product-image {
        transform: scale(1.1);
    }

    .category-card {
        transition: all 0.3s ease;
        border: 1px solid var(--border-color);
        background: var(--color-card);
        border-radius: 12px;
    }

    .category-card:hover {
        transform: translateY(-6px);
        box-shadow: var(--shadow-hover);
        border-color: var(--primary);
    }

    .category-card-link {
        text-decoration: none;
        color: inherit;
    }

    .category-icon {
        width: 64px;
        height: 64px;
        margin: 0 auto;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .category-icon svg {
        width: 100%;
        height: 100%;
        stroke: var(--primary);
        fill: none;
        stroke-width: 1.5;
        transition: all 0.3s ease;
    }

    .category-card:hover .category-icon svg {
        stroke: var(--primary);
        stroke-width: 2;
        transform: scale(1.1);
    }

    [data-theme="dark"] .category-icon svg {
        stroke: #d4af6a;
    }

    [data-theme="light"] .category-icon svg {
        stroke: #8a6a3f;
    }

    /* Feature button cards (homepage bottom) */
    .feature-btn {
        border: 1px solid var(--border-color);
        background: var(--color-card);
        cursor: default;
    }

    .feature-btn:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-hover);
        border-color: var(--primary);
    }

    .feature-icon {
        width: 48px;
        height: 48px;
        display: grid;
        place-items: center;
        flex: 0 0 auto;
    }

    .feature-icon svg {
        width: 100%;
        height: 100%;
        stroke: var(--primary);
        fill: none;
        stroke-width: 1.75;
        stroke-linecap: round;
        stroke-linejoin: round;
    }

    .feature-title {
        color: var(--body-color);
    }

    /* Typography */
    p {
        font-family: 'Lora', sans-serif;
        color: var(--body-color);
    }

    h1, h5, h4 {
        font-family: 'Playfair Display', serif;
        color: var(--primary);
    }
    #modal-title {
        font-family: 'Playfair Display', serif;
        color: var(--light) !important;
    }

    h2 {
        font-family: 'Playfair Display', serif;
        font-size: 2.5rem;
        padding-bottom: 20px;
        color: var(--primary);
    }

    h3 {
        color: var(--body-color);
    }

    /* Forms */
    .form-label {
        color: var(--body-color);
        font-family: 'Helvetica Neue', sans-serif;
        font-size: medium;
    }

    .form-control {
        background-color: var(--color-mute);
        color: var(--body-color);
        border-color: var(--border-color);
    }

    .form-control:focus {
        background-color: var(--color-mute);
        color: var(--body-color);
        border-color: var(--primary);
        box-shadow: 0 0 0 0.2rem rgba(var(--primary-rgb), 0.25);
    }

    .form-control::placeholder {
        color: var(--color-muted-foreground);
        opacity: 0.7;
    }

    /* Footer */
    .footer {
        color: var(--light);
        padding: 3rem 0 1.5rem;
        margin-top: 4rem;
    }

    [data-theme="dark"] .footer {
        background: linear-gradient(135deg, var(--dark) 0%, var(--color-muted) 100%);
    }

    [data-theme="light"] .footer {
        background: linear-gradient(135deg, #6b5a45 0%, #8a6a3f 100%);
        color: #f6f1e7;
    }

    .footer a {
        color: var(--light);
        text-decoration: none;
        transition: color 0.3s ease;
    }

    [data-theme="light"] .footer a {
        color: #f6f1e7;
    }

    .footer a:hover {
        color: var(--primary);
    }

    [data-theme="light"] .footer a:hover {
        color: #d4af6a;
    }

    .footer-social {
        font-size: 1.5rem;
    }

    .footer-social a {
        margin: 0 10px;
        display: inline-block;
        transition: transform 0.3s ease;
    }

    .footer-social a:hover {
        transform: translateY(-3px);
        color: var(--primary);
    }

    /* Breadcrumb */
    .breadcrumb-nav {
        background-color: var(--color-muted);
        border-bottom: 1px solid var(--border-color);
    }

    .breadcrumb {
        background: transparent;
        margin: 0;
    }

    .breadcrumb-item a {
        color: var(--primary);
        text-decoration: none;
    }

    .breadcrumb-item.active {
        color: var(--body-color);
    }

    /* Modals */
    .modal-body, .modal-header {
        background-color: var(--color-card);
        color: var(--body-color);
    }

    .modal-content {
        background-color: var(--color-card);
        border-color: var(--border-color);
    }

    /* Alerts */
    .alert-success {
        background-color: rgba(var(--primary-rgb), 0.15) !important;
        border: 1px solid var(--primary) !important;
        color: var(--primary) !important;
    }

    .text-muted {
        color: var(--color-muted-foreground) !important;
    }

    /* Badges */
    .badge {
        font-weight: 600;
    }

    /* Hero Slider */
    .hero-slider {
        position: relative;
        height: 600px;
        overflow: hidden;
        background: var(--body-bg);
    }

    .hero-slide {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        transition: opacity 1s ease-in-out;
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
    }

    .hero-slide.active {
        opacity: 1;
    }

    .hero-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 1;
    }

    [data-theme="dark"] .hero-overlay {
        background: linear-gradient(180deg, rgba(10, 10, 10, 0.7), rgba(26, 26, 26, 0.9));
    }

    [data-theme="light"] .hero-overlay {
        background: linear-gradient(180deg, rgba(245, 230, 211, 0.75), rgba(245, 230, 211, 0.9));
    }

    .hero-content {
        position: relative;
        z-index: 2;
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        text-align: center;
        padding: 2rem;
    }

    .hero-content .container {
        display: flex;
        flex-direction: column;
        align-items: center;
        width: 100%;
    }

    /* Hero text fade */
    .hero-fade {
        opacity: 0;
        transform: translateY(6px);
        transition: opacity 250ms ease, transform 250ms ease;
    }

    [data-theme="dark"] .hero-content {
        color: var(--light);
    }

    [data-theme="light"] .hero-content {
        color: var(--dark);
    }

    .hero-content h1 {
        font-size: 4rem;
        font-weight: 700;
        margin-bottom: 1.5rem;
        text-align: center;
    }

    [data-theme="dark"] .hero-content h1 {
        color: var(--light);
        text-shadow: 2px 2px 10px rgba(0, 0, 0, 0.5);
    }

    [data-theme="light"] .hero-content h1 {
        color: var(--dark);
        text-shadow: 1px 1px 3px rgba(255, 255, 255, 0.8);
    }

    .hero-content p {
        font-size: 1.5rem;
        margin-bottom: 2.5rem;
        text-align: center;
    }

    [data-theme="dark"] .hero-content p {
        color: var(--light);
    }

    [data-theme="light"] .hero-content p {
        color: var(--dark);
    }

    .hero-search {
        max-width: 600px;
        width: 100%;
        margin: 2rem auto;
        display: flex;
        justify-content: center;
        position: relative;
    }

    .hero-search .input-group {
        display: flex;
        align-items: stretch;
        position: relative;
        width: 100%;
    }

    .hero-search .input-group .form-control {
        flex: 1;
    }

    .hero-search .input-group .btn {
        display: flex;
        align-items: center;
        justify-content: center;
        white-space: nowrap;
    }


    .slider-controls {
        position: absolute;
        bottom: 20px;
        left: 50%;
        transform: translateX(-50%);
        z-index: 3;
        display: flex;
        gap: 10px;
    }

    .slider-dot {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.5);
        border: 2px solid var(--light);
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .slider-dot.active {
        background: var(--primary);
        border-color: var(--primary);
        transform: scale(1.2);
    }

    .slider-arrow {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        z-index: 3;
        background: rgba(0, 0, 0, 0.5);
        color: var(--light);
        border: none;
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .slider-arrow:hover {
        background: var(--primary);
    }

    .slider-arrow.prev {
        left: 20px;
    }

    .slider-arrow.next {
        right: 20px;
    }

    /* Trust Indicators */
    .trust-indicators {
        display: flex;
        gap: 2rem;
        flex-wrap: wrap;
        justify-content: center;
        margin-top: 2rem;
    }

    .trust-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    [data-theme="dark"] .trust-item {
        color: var(--light);
    }

    [data-theme="light"] .trust-item {
        color: var(--dark);
    }

    .trust-item i {
        color: var(--primary);
    }

    /* Section Spacing */
    .section {
        padding: 4rem 0;
    }

    [data-theme="light"] .section:nth-child(even) {
        background-color: var(--color-muted);
    }

    [data-theme="dark"] .section:nth-child(even) {
        background-color: var(--color-muted);
    }

    /* Ensure hero has proper background */
    .hero-slider {
        min-height: 600px;
    }

    .section-title {
        text-align: center;
        margin-bottom: 3rem;
    }

    /* Product Image Placeholder */
    .product-image {
        background: var(--color-muted);
    }

    [data-theme="light"] .product-image {
        background: linear-gradient(135deg, #e7dcc8, #f6f1e7);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .hero-content h1 {
            font-size: 2.5rem;
        }

        .hero-content p {
            font-size: 1.2rem;
        }

        .navbar-search {
            max-width: 100%;
            margin: 10px 0;
            flex-direction: column;
        }

        .navbar-search .navbar-nav {
            width: 100%;
            justify-content: center;
            margin-bottom: 10px;
        }

        .navbar-search form {
            width: 100%;
        }
    }
    </style>
    @yield('styles')
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
        <div class="container d-flex align-items-center justify-content-between">
            <!-- Left: Brand -->
            <a class="navbar-brand fw-bold fs-3" href="{{ route('home') }}">
                <img src="{{ asset('images/products/LOGO.png') }}" alt="Vivace Logo" style="height: 40px; width: auto;"> VIVACE
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Right: Nav + Search + Actions -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <div class="d-flex align-items-center justify-content-end gap-3 w-100">
                    <ul class="navbar-nav align-items-center">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}" href="{{ route('products.index') }}">Products</a>
                        </li>
                    </ul>

                    <div class="navbar-search">
                        <div class="search-wrap">
                            <form action="{{ route('products.index') }}" method="GET" id="searchForm">
                                <div class="input-group">
                                    <input type="text"
                                           class="form-control"
                                           name="search"
                                           id="globalSearch"
                                           placeholder="Search instruments..."
                                           autocomplete="off">
                                    <button class="btn btn-primary" type="submit">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </form>
                            <div class="search-autocomplete" id="searchAutocomplete"></div>
                        </div>
                    </div>

                    <ul class="navbar-nav align-items-center">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('about.*') ? 'active' : '' }}" href="{{ route('about') }}">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('contact.*') ? 'active' : '' }}" href="{{ route('contact') }}">Contact</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('cart.index') }}">
                            <i class="fas fa-shopping-cart"></i> Cart
                            @php
                                $cartCount = 0;
                                if(session('cart')) {
                                    $cartCount = count(session('cart'));
                                }
                            @endphp
                            @if($cartCount > 0)
                                <span class="badge bg-danger">{{ $cartCount }}</span>
                            @endif
                        </a>
                    </li>
                    @auth
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user"></i> {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('user.profile') }}">Profile</a></li>
                                <li><a class="dropdown-item" href="{{ route('user.orders') }}">My Orders</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button class="dropdown-item" type="submit">Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#loginModal">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#registerModal">Register</a>
                        </li>
                    @endauth
                    <li class="nav-item">
                        <button class="theme-toggle ms-2" id="themeToggle" aria-label="Toggle theme">
                            <i class="fas fa-moon" id="themeIcon"></i>
                        </button>
                    </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show m-3" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @yield('content')

    <footer class="footer mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-3 mb-4">
                    <h5><i class="fas fa-music"></i> VIVACE</h5>
                    <p>Your premier destination for quality musical instruments. Play your passion with premium instruments for beginners and professionals.</p>
                </div>
                <div class="col-md-3 mb-4">
                    <h5>Quick Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('home') }}">Home</a></li>
                        <li><a href="{{ route('products.index') }}">Products</a></li>
                    </ul>
                </div>
                <div class="col-md-3 mb-4">
                    <h5>Contact Info</h5>
                    <p><i class="fas fa-envelope"></i> info@vivace.com</p>
                    <p><i class="fas fa-phone"></i> (02) 1234-5678</p>
                    <p><i class="fas fa-map-marker-alt"></i> Manila, Philippines</p>
                </div>
                <div class="col-md-3 mb-4">
                    <h5>Follow Us</h5>
                    <div class="footer-social">
                        <a href="#" aria-label="Facebook"><i class="fab fa-facebook"></i></a>
                        <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                        <a href="#" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                        <a href="#" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
                    </div>
                    <div class="mt-3">
                        <h6 class="mb-2">Payment Methods</h6>
                        <div class="d-flex gap-2 flex-wrap">
                            <i class="fab fa-cc-visa fa-2x"></i>
                            <i class="fab fa-cc-mastercard fa-2x"></i>
                            <i class="fab fa-cc-paypal fa-2x"></i>
                            <i class="fab fa-cc-amex fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
            <hr class="bg-white my-4">
            <div class="text-center">
                <p class="mb-0">&copy; {{ date('Y') }} Vivace Music Shop. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Login Modal -->
    <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header" style="background-color: var(--dark); color: var(--primary);">
                    <h5 class="modal-title" id="loginModalLabel">
                        <i class="fas fa-sign-in-alt me-2"></i>Login to Vivace
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <form action="{{ route('login') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Email Address</label>
                            <input type="email" name="email" class="form-control" placeholder="Enter your email" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <div class="input-group">
                                <input type="password" name="password" id="modalLoginPassword" class="form-control" placeholder="Enter your password" required>
                                <button class="btn btn-outline-secondary" type="button" id="toggleModalLoginPassword">
                                    <i class="fas fa-eye" id="modalLoginPasswordIcon"></i>
                                </button>
                            </div>
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" name="remember" class="form-check-input" id="rememberMe">
                            <label class="form-check-label" for="rememberMe">Remember Me</label>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 mb-2">
                            <i class="fas fa-sign-in-alt me-2"></i>Login
                        </button>
                        <a href="{{ route('login') }}" class="btn btn-outline-secondary w-100 btn-sm">
                            <i class="fas fa-external-link-alt me-2"></i>Open Full Login Page
                        </a>
                    </form>
                    <hr class="my-4">
                    <div class="text-center">
                        <p class="mb-0">
                            Don't have an account?
                            <a href="#" class="text-primary fw-bold" id="link" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#registerModal">Register here</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Register Modal -->
    <div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header" style="background-color: var(--primary); color: white;">
                    <h5 class="modal-title" id="registerModalLabel">
                        <i class="fas fa-user-plus me-2"></i>Create Account
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <form action="{{ route('register') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Full Name</label>
                            <input type="text" name="name" class="form-control" placeholder="Enter your full name" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email Address</label>
                            <input type="email" name="email" class="form-control" placeholder="Enter your email" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Phone Number</label>
                            <input type="text" name="phone" class="form-control" placeholder="Enter your phone number">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <div class="input-group">
                                <input type="password" name="password" id="modalRegPassword" class="form-control" placeholder="Create a password" required>
                                <button class="btn btn-outline-secondary" type="button" id="toggleModalRegPassword">
                                    <i class="fas fa-eye" id="modalRegPasswordIcon"></i>
                                </button>
                            </div>
                            <small class="text-muted">Minimum 8 characters</small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Confirm Password</label>
                            <div class="input-group">
                                <input type="password" name="password_confirmation" id="modalConfirmPassword" class="form-control" placeholder="Confirm your password" required>
                                <button class="btn btn-outline-secondary" type="button" id="toggleModalConfirmPassword">
                                    <i class="fas fa-eye" id="modalConfirmPasswordIcon"></i>
                                </button>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 mb-2">
                            <i class="fas fa-user-plus me-2"></i>Create Account
                        </button>
                        <a href="{{ route('register') }}" class="btn btn-outline-secondary w-100 btn-sm">
                            <i class="fas fa-external-link-alt me-2"></i>Open Full Registration Page
                        </a>
                    </form>
                    <hr class="my-4">
                    <div class="text-center">
                        <p class="mb-0">
                            Already have an account?
                            <a href="#" class="text-primary fw-bold" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#loginModal">Login here</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    // Theme Toggle
    (function() {
        const themeToggle = document.getElementById('themeToggle');
        const themeIcon = document.getElementById('themeIcon');
        const html = document.documentElement;

        // Get saved theme or default to dark
        const savedTheme = localStorage.getItem('theme') || 'dark';
        html.setAttribute('data-theme', savedTheme);
        updateThemeIcon(savedTheme);

        themeToggle.addEventListener('click', function() {
            const currentTheme = html.getAttribute('data-theme');
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
            html.setAttribute('data-theme', newTheme);
            localStorage.setItem('theme', newTheme);
            updateThemeIcon(newTheme);
        });

        function updateThemeIcon(theme) {
            if (theme === 'dark') {
                themeIcon.classList.remove('fa-sun');
                themeIcon.classList.add('fa-moon');
            } else {
                themeIcon.classList.remove('fa-moon');
                themeIcon.classList.add('fa-sun');
            }
        }
    })();

    // Reusable Search Autocomplete Function
    function initSearchAutocomplete(inputId, autocompleteId) {
        const searchInput = document.getElementById(inputId);
        const autocomplete = document.getElementById(autocompleteId);
        if (!searchInput || !autocomplete) return;

        let searchTimeout;
        let activeIndex = -1;

        function clearSuggestions() {
            autocomplete.classList.remove('show');
            autocomplete.innerHTML = '';
            activeIndex = -1;
        }

        function escapeHtml(str) {
            return str.replace(/[&<>"']/g, function(m) {
                return ({
                    '&': '&amp;',
                    '<': '&lt;',
                    '>': '&gt;',
                    '"': '&quot;',
                    "'": '&#39;'
                })[m];
            });
        }

        function highlightMatch(text, query) {
            const safeText = escapeHtml(text);
            const escaped = query.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
            const regex = new RegExp(`(${escaped})`, 'ig');
            return safeText.replace(regex, '<span class="search-match">$1</span>');
        }

        function renderSuggestions(items, query) {
            if (!items.length) {
                clearSuggestions();
                return;
            }

            const html = items.map((item, idx) => {
                const isProduct = item.type === 'product';
                const labelHtml = highlightMatch(item.name, query);

                if (isProduct) {
                    const price = item.price
                        ? `₱${parseFloat(item.price).toLocaleString('en-US', { minimumFractionDigits: 2 })}`
                        : '';
                    const imageSrc = item.image || 'https://via.placeholder.com/50';
                    return `
                        <div class="search-result-item" data-index="${idx}" data-url="${item.url}" data-type="product" tabindex="-1">
                            <img src="${imageSrc}" class="search-result-image" alt="${escapeHtml(item.name)}">
                            <div>
                                <div class="fw-bold">${labelHtml}</div>
                                ${price ? `<small class="text-muted">${price}</small>` : ''}
                            </div>
                        </div>
                    `;
                } else {
                    // category
                    return `
                        <div class="search-result-item" data-index="${idx}" data-url="${item.url}" data-type="category" tabindex="-1">
                            <div>
                                <div class="fw-bold">${labelHtml}</div>
                                <small class="text-muted">Category</small>
                            </div>
                        </div>
                    `;
                }
            }).join('');

            autocomplete.innerHTML = html;
            autocomplete.classList.add('show');
            activeIndex = -1;
        }

        function updateActiveItem(delta) {
            const items = autocomplete.querySelectorAll('.search-result-item');
            if (!items.length) return;

            activeIndex = (activeIndex + delta + items.length) % items.length;
            items.forEach((el, idx) => {
                el.classList.toggle('active', idx === activeIndex);
            });
        }

        function activateItem(index) {
            const item = autocomplete.querySelector(`.search-result-item[data-index="${index}"]`);
            if (item) {
                const url = item.getAttribute('data-url');
                if (url) {
                    window.location.href = url;
                }
            }
        }

        searchInput.addEventListener('input', function() {
            const query = this.value.trim();

            clearTimeout(searchTimeout);

            if (query.length < 2) {
                clearSuggestions();
                return;
            }

            searchTimeout = setTimeout(function() {
                fetch(`{{ route('search.autocomplete') }}?q=${encodeURIComponent(query)}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    renderSuggestions(data, query);
                })
                .catch(error => {
                    console.error('Search error:', error);
                });
            }, 250);
        });

        // Keyboard navigation
        searchInput.addEventListener('keydown', function(e) {
            const items = autocomplete.querySelectorAll('.search-result-item');
            if (!items.length) return;

            if (e.key === 'ArrowDown') {
                e.preventDefault();
                updateActiveItem(1);
            } else if (e.key === 'ArrowUp') {
                e.preventDefault();
                updateActiveItem(-1);
            } else if (e.key === 'Enter') {
                if (activeIndex >= 0) {
                    e.preventDefault();
                    activateItem(activeIndex);
                }
            } else if (e.key === 'Escape') {
                clearSuggestions();
            }
        });

        // Mouse click handling
        autocomplete.addEventListener('click', function(e) {
            const item = e.target.closest('.search-result-item');
            if (!item) return;
            const url = item.getAttribute('data-url');
            if (url) {
                window.location.href = url;
            }
        });

        // Hide autocomplete when clicking outside
        document.addEventListener('click', function(e) {
            if (!searchInput.contains(e.target) && !autocomplete.contains(e.target)) {
                clearSuggestions();
            }
        });
    }

    // Initialize autocomplete for all search bars
    document.addEventListener('DOMContentLoaded', function() {
        // Navbar search
        initSearchAutocomplete('globalSearch', 'searchAutocomplete');
        // Hero search (homepage)
        initSearchAutocomplete('heroSearch', 'heroSearchAutocomplete');
        // Products page search
        initSearchAutocomplete('productPageSearch', 'productPageSearchAutocomplete');
    });

    // Password toggle function for modals
    function setupPasswordToggle(buttonId, inputId, iconId) {
        const button = document.getElementById(buttonId);
        if (button) {
            button.addEventListener('click', function() {
                const input = document.getElementById(inputId);
                const icon = document.getElementById(iconId);

                if (input.type === 'password') {
                    input.type = 'text';
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                } else {
                    input.type = 'password';
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                }
            });
        }
    }

    // Initialize modal password toggles when DOM is ready
    document.addEventListener('DOMContentLoaded', function() {
        setupPasswordToggle('toggleModalLoginPassword', 'modalLoginPassword', 'modalLoginPasswordIcon');
        setupPasswordToggle('toggleModalRegPassword', 'modalRegPassword', 'modalRegPasswordIcon');
        setupPasswordToggle('toggleModalConfirmPassword', 'modalConfirmPassword', 'modalConfirmPasswordIcon');
    });
    </script>
    @stack('scripts')
    @yield('scripts')
</body>
</html>
