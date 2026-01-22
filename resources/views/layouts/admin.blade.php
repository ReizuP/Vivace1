<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel - Vivace')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
        --primary: #c9a961; /* Gold */
        --primary-rgb: 212, 175, 55;
        --primary-dark: #a68a5c; /* Darker Gold */
        --secondary: #8b6f47; /* Warm Brown */
        --secondary-rgb: 139, 111, 71;
        --dark: #0a0a0a; /* Glossy Ebony */
        --light: #f5f0e8;

        }
        body{
            background-color: var(--primary) !important;
            color: var(--dark);
        }
        .sidebar {
            min-height: 100vh;
            background: linear-gradient(180deg, var(--dark) 0%, var(--primary) 100%);
        }
        .sidebar a {
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            padding: 10px 20px;
            display: block;
            transition: 0.3s;
        }
        .sidebar a:hover, .sidebar a.active {
            background-color: rgba(255,255,255,0.1);
            color: white;
        }
        .content-wrapper {
            min-height: 100vh;
            background-color: #f8f9fa;
        }
        h4{
        font-family: 'Playfair Display', serif;
        color: var(--light);
        font-size: 1.7rem;
        }
        h5{
        font-family: 'Playfair Display', serif;
        font-weight: bold
        }
        h2, h3, h6, h1{
        font-family: 'Playfair Display', serif;
        }

        #sidebar-icon {
            margin-right: 10px;
        color: var(--primary-dark) !important;
        }
    </style>
    @yield('styles')
</head>
<body>
    <div class="d-flex">
        <div class="sidebar text-white" style="width: 250px;">
            <div class="p-3 text-center border-bottom">
                <h4><i class="fas fa-music" id="sidebar-icon"></i> Vivace Admin</h4>
            </div>
            <div class="mt-3">
                <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-chart-line"id="sidebar-icon"></i> Dashboard
                </a>
                <a href="{{ route('admin.categories.index') }}" class="{{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                    <i class="fas fa-folder"id="sidebar-icon"></i> Categories
                </a>
                <a href="{{ route('admin.products.index') }}" class="{{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                    <i class="fas fa-box"id="sidebar-icon"></i> Products
                </a>
                <a href="{{ route('admin.orders.index') }}" class="{{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                    <i class="fas fa-shopping-cart"id="sidebar-icon"></i> Orders
                </a>
                <a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                    <i class="fas fa-users"id="sidebar-icon"></i> Users
                </a>
                <hr class="bg-white">
                <a href="{{ route('home') }}" target="_blank">
                    <i class="fas fa-external-link-alt" id="sidebar-icon"></i> View Website
                </a>
                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-link text-white text-start w-100" style="text-decoration: none; padding: 10px 20px;">
                        <i class="fas fa-sign-out-alt" id="sidebar-icon"></i> Logout
                    </button>
                </form>
            </div>
        </div>

        <div class="content-wrapper flex-grow-1">
            <nav class="navbar navbar-light bg-white shadow-sm">
                <div class="container-fluid">
                    <span class="navbar-text">
                        Welcome, {{ Auth::guard('admin')->user()->name }}
                    </span>
                </div>
            </nav>

            <div class="p-4">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @yield('content')
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>
