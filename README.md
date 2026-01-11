# 🎵 Vivace Music Shop

A full-featured e-commerce platform for musical instruments built with Laravel.

## Features

### Customer Features
- 🏠 Browse products with search and filters
- 🛒 Shopping cart functionality
- 💳 Checkout process
- 👤 User registration and authentication
- 📦 Order tracking (To Pay, To Ship, On Transit, Delivered)
- 👨‍💼 User profile management

### Admin Features
- 📊 Dashboard with statistics
- 📦 Product management (CRUD)
- 🛍️ Order management
- 👥 User management
- 🔍 Low stock alerts
- 📈 Sales overview

## Tech Stack

- **Framework:** Laravel 11
- **Database:** MySQL
- **Frontend:** Bootstrap 5, Font Awesome
- **Authentication:** Laravel Session-based Auth
- **PHP:** 8.1+

## Quick Start

```bash
# Clone repository
git clone <your-repo-url>
cd vivace

# Install dependencies
composer install

# Setup environment
cp .env.example .env
php artisan key:generate

# Create database 'vivace_shop' in MySQL

# Configure .env with your database credentials

# Run migrations and seeders
php artisan migrate
php artisan db:seed

# Start server
php artisan serve
```

Visit: `http://localhost:8000`

## Default Login Credentials

**Admin:** admin@vivace.com / admin123  
**User:** user@vivace.com / user123

## Full Setup Guide

See [SETUP.md](SETUP.md) for detailed installation instructions.

## Screenshots

[Add screenshots of your application here]

## License

[Your License Here]

## Contact

[Your Contact Information]