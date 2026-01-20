<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Vivace Music Shop')</title>
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"> --}}
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"> --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
    :root {
  --body-bg: #252525; /* Matte Black */
  --body-color: #f5f0e8; /* Piano Ivory */

  --primary: #a68a5c; /* Brass Gold */
  --primary-rgb: 166, 138, 92;
  --secondary: #3d2617; /* Mahogany */
  --secondary-rgb: 61, 38, 23;

  --dark: #0a0a0a; /* Glossy Ebony */
  --light: #f5f0e8;


  --border-color-translucent: rgba(255, 255, 255, 0.1);
  --border-color: #6d6d6d;
  /* Custom colors */
  --color-card: #0a0a0a;
  --color-muted: #262626;
  --color-mute: #3d3d3d;
  --color-muted-foreground: #b8a98f;

  /* Custom effects */
  --gradient-primary: linear-gradient(135deg, #a68a5c, #8a7249);
  --gradient-hero: linear-gradient(180deg, rgba(10, 10, 10, 0.6), #1a1a1a);
  --glow-primary: 0 0 40px rgba(166, 138, 92, 0.5);
  --glow-secondary: 0 0 30px rgba(166, 138, 92, 0.3);

  --bs-border-radius: 0.5rem;
  --bs-border-radius-sm: 0.25rem;
  --bs-border-radius-lg: 0.75rem;

        }
        body { font-family: Playfair Display, -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', 'Oxygen', 'Ubuntu', 'Cantarell', 'Fira Sans', 'Droid Sans', 'Helvetica Neue', sans-serif;
        background-color: var(--body-bg); color: var(--body-color); }
        .navbar { background: linear-gradient(135deg, var(--dark) 0%, var(--primary) 100%);}
        .navbar-brand{font-family: Playfair Display, serif; color: var(--light);}
        .btn-primary { background-color: #B68C55; border-color: var(--border-color); }
        .btn-primary:hover { background-color: var(--secondary); border-color: var(--secondary); }
        .footer { background-color: var(--color-mute); color: white; }
        .product-card { transition: transform 0.3s; color:#0a0a0a;}
        .product-card:hover { transform: translateY(-5px); box-shadow: 0 4px 15px rgba(0,0,0,0.2); }
        .card{ background-color: var(--color-card); border-color: var(--border-color); color: var(--light);}
        .card-body { background-color: var(--color-card); border-color: var(--border-color); color: var(--light); border-radius: var(--bs-border-radius-lg);}
         p{font-family: Lora, sans-serif; color: var(--light);}
         h1, h4, h5 {font-family: Playfair Display, serif; color: var(--primary);}
         h2{font-family: Playfair Display, serif; font-size:2.5rem; padding-bottom: 20px; color: var(--primary);}
         h3{color: var(--light);}
        .form-label { color: var(--light); font-family: Helvetica Neue, sans-serif; font-size: medium; }
        .modal-body, .modal-header { background-color: var(--dark); color: var(--light); }
        .nav-link { color: white !important; }
        .nav-link:hover { color: var(--primary) !important; }
        .navbar-nav .nav-item{margin-right:10px; font-weight: 500;}
        .form-control { background-color: var(--color-mute); color: var(--light); border-color: var(--border-color); }
        .form-control::placeholder { color: var(--color-muted-foreground); opacity: 0.7; font-style: oblique; font-size: medium; }


    </style>
    @yield('styles')
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold fs-3" href="{{ route('home') }}">
              <img src="{{ asset('images/products/LOGO.png') }}" alt="Vivace Logo" style="height: 40px; width: auto;"> VIVACE
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('products.index') }}">Products</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('about') }}">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('contact') }}">Contact</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('cart.index') }}">
                        <i class="fas fa-shopping-cart"></i> Cart
                        @if(session('cart'))
                            <span class="badge bg-danger">{{ count(session('cart')) }}</span>
                        @endif
                    </a></li>
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
                </ul>
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

    <footer class="footer mt-5 py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-4" id="foot-box">
                    <h5><i class="fas fa-music"></i> Vivace</h5>
                    <p>Your premier destination for quality musical instruments.</p>
                </div>
                <div class="col-md-4" id="foot-box">
                    <h5>Quick Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('products.index') }}" class="text-white">Products</a></li>
                        <li><a href="{{ route('about') }}" class="text-white">About Us</a></li>
                        <li><a href="{{ route('contact') }}" class="text-white">Contact</a></li>
                    </ul>
                </div>
                <div class="col-md-4" id="foot-box">
                    <h5>Contact Info</h5>
                    <p><i class="fas fa-envelope"></i> info@vivace.com</p>
                    <p><i class="fas fa-phone"></i> (02) 1234-5678</p>
                </div>
            </div>
            <hr class="bg-white">
            <div class="text-center">
                <p>&copy; 2024 Vivace Music Shop. All rights reserved.</p>
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
                            <a href="#" class="text-primary fw-bold" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#registerModal">Register here</a>
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

    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> --}}
    {{-- <script src="{{ asset('js/cart-global.js') }}"></script> --}}
    <script>
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
        // Login modal
        setupPasswordToggle('toggleModalLoginPassword', 'modalLoginPassword', 'modalLoginPasswordIcon');
        
        // Register modal
        setupPasswordToggle('toggleModalRegPassword', 'modalRegPassword', 'modalRegPasswordIcon');
        setupPasswordToggle('toggleModalConfirmPassword', 'modalConfirmPassword', 'modalConfirmPasswordIcon');
    });
    </script>
    @stack('scripts')
    @yield('scripts')
</body>
</html>
