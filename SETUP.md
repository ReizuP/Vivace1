# Vivace Music Shop - Developer Setup Guide

## Prerequisites

Before you begin, ensure you have the following installed:
- PHP 8.1 or higher
- Composer
- MySQL (or XAMPP)
- Git

---

## Setup Instructions

### 1. Clone the Repository

```bash
git clone <your-repository-url>
cd vivace1
```

### 2. Install PHP Dependencies

```bash
composer install
```

This installs all Laravel packages and dependencies from `composer.json`.

### 3. Create Environment File

Copy the example environment file:

```bash
# Windows
copy .env.example .env

# Mac/Linux
cp .env.example .env
```

### 4. Generate Application Key

```bash
php artisan key:generate
```

This creates a unique encryption key for your application.

### 5. Configure Database

Open `.env` file and update these lines with your database credentials:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=vivace_shop
DB_USERNAME=root
DB_PASSWORD=
```

**Note:** Change `DB_USERNAME` and `DB_PASSWORD` if your MySQL has different credentials.

### 6. Create Database

Using MySQL Workbench or command line:

```sql
CREATE DATABASE vivace_shop;
```

**Or via command line:**

```bash
# Windows (XAMPP)
cd C:\xampp\mysql\bin
mysql -u root -p

# Mac/Linux
mysql -u root -p

# Then in MySQL prompt:
CREATE DATABASE vivace_shop;
EXIT;
```

### 7. Run Migrations

Create all database tables:

```bash
php artisan migrate
```

This creates 7 tables:
- users
- admins
- categories
- products
- orders
- order_items
- sessions

### 8. Seed the Database

Add sample data (admin, user, categories, products):

```bash
php artisan db:seed
```

### 9. Create Storage Link (for image uploads)

```bash
php artisan storage:link
```

### 10. Create Required Directories

Make sure the images directory exists:

```bash
# Windows
mkdir public\images\products

# Mac/Linux
mkdir -p public/images/products
```

### 11. Clear All Caches

```bash
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
```

### 12. Start Development Server

```bash
php artisan serve
```

The application will be available at: `http://localhost:8000`

---

## Default Login Credentials

### Admin Panel
- URL: `http://localhost:8000/admin/login`
- Email: `admin@vivace.com`
- Password: `admin123`

### Customer Account
- URL: `http://localhost:8000/login`
- Email: `user@vivace.com`
- Password: `user123`

---

## Project Structure

```
vivace/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Auth/          # User authentication
│   │   │   ├── Admin/         # Admin controllers
│   │   │   └── ...            # Other controllers
│   │   └── Middleware/        # Custom middleware
│   └── Models/                # Database models
├── database/
│   ├── migrations/            # Database structure
│   └── seeders/               # Sample data
├── resources/
│   └── views/                 # Blade templates
│       ├── layouts/           # Master layouts
│       ├── auth/              # Login/Register views
│       ├── admin/             # Admin panel views
│       └── ...                # Other views
├── routes/
│   └── web.php                # Application routes
└── public/
    └── images/
        └── products/          # Product images storage
```

---

## Common Issues & Solutions

### Issue: "SQLSTATE[HY000] [1049] Unknown database"
**Solution:** Database doesn't exist. Create it using Step 6.

### Issue: "SQLSTATE[42S02]: Base table or view not found"
**Solution:** Tables haven't been created. Run `php artisan migrate`.

### Issue: "No application encryption key has been set"
**Solution:** Run `php artisan key:generate`.

### Issue: "Class 'Authenticate' not found"
**Solution:** Run `composer dump-autoload` and clear caches.

### Issue: Can't upload product images
**Solution:** 
1. Make sure `public/images/products` folder exists
2. Check folder permissions (755 on Linux/Mac)
3. Run `php artisan storage:link`

### Issue: "Route [login] not defined"
**Solution:** Clear route cache: `php artisan route:clear`

---

## Development Workflow

### Running the Application
```bash
php artisan serve
```

### Resetting Database (WARNING: Deletes all data)
```bash
php artisan migrate:fresh --seed
```

### Clearing Caches
```bash
php artisan optimize:clear
```

### Viewing Routes
```bash
php artisan route:list
```

### Creating New Admin User
```bash
php artisan tinker
```
Then in tinker:
```php
App\Models\Admin::create([
    'name' => 'New Admin',
    'email' => 'newadmin@vivace.com',
    'password' => bcrypt('password123')
]);
```

---

## Environment Variables Reference

Key variables in `.env`:

| Variable | Description | Example |
|----------|-------------|---------|
| `APP_NAME` | Application name | Vivace |
| `APP_ENV` | Environment | local, production |
| `APP_DEBUG` | Debug mode | true, false |
| `APP_URL` | Application URL | http://localhost:8000 |
| `DB_DATABASE` | Database name | vivace_shop |
| `DB_USERNAME` | Database user | root |
| `DB_PASSWORD` | Database password | (your password) |
| `SESSION_DRIVER` | Session storage | database, file |

---

## Testing Checklist

After setup, verify these features work:

- [ ] Homepage loads
- [ ] Can view products page
- [ ] Can search products
- [ ] Can view product details
- [ ] Can register new user
- [ ] Can login as user
- [ ] Can add items to cart
- [ ] Can checkout
- [ ] Can view user profile
- [ ] Can view orders
- [ ] Can login to admin panel
- [ ] Can view admin dashboard
- [ ] Can manage products
- [ ] Can view orders
- [ ] Can update order status
- [ ] Can view users

---

## Additional Setup for Production

When deploying to production server:

1. Set `APP_ENV=production` in `.env`
2. Set `APP_DEBUG=false` in `.env`
3. Run `php artisan config:cache`
4. Run `php artisan route:cache`
5. Run `php artisan view:cache`
6. Set proper file permissions
7. Configure web server (Apache/Nginx)
8. Set up SSL certificate
9. Configure email settings
10. Set up backups

---

## Getting Help

If you encounter issues:
1. Check the error message carefully
2. Review the Common Issues section
3. Check Laravel logs in `storage/logs/laravel.log`
4. Search the error on Google or Stack Overflow
5. Contact the project maintainer

---

## Contributing

When making changes:
1. Create a new branch
2. Make your changes
3. Test thoroughly
4. Commit with clear messages
5. Push and create pull request

---

**Last Updated:** January 2025  
**Laravel Version:** 11.x  
**PHP Version:** 8.1+