<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Admin
        Admin::create([
            'name' => 'Admin Vivace',
            'email' => 'admin@vivace.com',
            'password' => Hash::make('admin123'),
        ]);

        // Create Test User
        User::create([
            'name' => 'John Doe',
            'email' => 'user@vivace.com',
            'password' => Hash::make('user123'),
            'phone' => '09123456789',
            'address' => '123 Music Street',
            'city' => 'Manila',
            'postal_code' => '1000',
        ]);

        // Create Categories
        $categories = [
            ['name' => 'Guitars', 'slug' => 'guitars'],
            ['name' => 'Pianos & Keyboards', 'slug' => 'pianos-keyboards'],
            ['name' => 'Drums & Percussion', 'slug' => 'drums-percussion'],
            ['name' => 'Brass Instruments', 'slug' => 'brass-instruments'],
            ['name' => 'Woodwind Instruments', 'slug' => 'woodwind-instruments'],
            ['name' => 'String Instruments', 'slug' => 'string-instruments'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        // Create Products
        $products = [
            // Guitars
            [
                'category_id' => 1,
                'name' => 'Fender Stratocaster',
                'slug' => 'fender-stratocaster',
                'description' => 'Classic electric guitar with legendary tone and timeless design. Perfect for all music genres.',
                'price' => 45000.00,
                'stock' => 15,
                'featured' => true,
            ],
            [
                'category_id' => 1,
                'name' => 'Yamaha C40 Classical Guitar',
                'slug' => 'yamaha-c40-classical',
                'description' => 'Full-size classical guitar ideal for beginners and intermediate players.',
                'price' => 8500.00,
                'stock' => 25,
                'featured' => true,
            ],
            [
                'category_id' => 1,
                'name' => 'Gibson Les Paul',
                'slug' => 'gibson-les-paul',
                'description' => 'Iconic rock guitar with rich, warm tone and stunning aesthetics.',
                'price' => 85000.00,
                'stock' => 8,
                'featured' => false,
            ],
            
            // Pianos & Keyboards
            [
                'category_id' => 2,
                'name' => 'Yamaha P-45 Digital Piano',
                'slug' => 'yamaha-p45-digital-piano',
                'description' => '88-key weighted digital piano with authentic piano sound.',
                'price' => 32000.00,
                'stock' => 12,
                'featured' => true,
            ],
            [
                'category_id' => 2,
                'name' => 'Casio CT-S300 Keyboard',
                'slug' => 'casio-cts300-keyboard',
                'description' => 'Portable keyboard with 61 keys and 400 tones.',
                'price' => 9500.00,
                'stock' => 20,
                'featured' => false,
            ],
            
            // Drums & Percussion
            [
                'category_id' => 3,
                'name' => 'Pearl Export 5-Piece Drum Set',
                'slug' => 'pearl-export-drum-set',
                'description' => 'Complete drum set perfect for beginners and intermediate drummers.',
                'price' => 38000.00,
                'stock' => 6,
                'featured' => true,
            ],
            [
                'category_id' => 3,
                'name' => 'Zildjian A Custom Cymbal Set',
                'slug' => 'zildjian-cymbal-set',
                'description' => 'Professional cymbal set with brilliant sound.',
                'price' => 28000.00,
                'stock' => 10,
                'featured' => false,
            ],
            
            // Brass Instruments
            [
                'category_id' => 4,
                'name' => 'Yamaha YTR-2330 Trumpet',
                'slug' => 'yamaha-ytr2330-trumpet',
                'description' => 'Student trumpet with excellent playability and tone.',
                'price' => 18000.00,
                'stock' => 8,
                'featured' => false,
            ],
            [
                'category_id' => 4,
                'name' => 'Bach Stradivarius Trombone',
                'slug' => 'bach-stradivarius-trombone',
                'description' => 'Professional trombone with exceptional sound quality.',
                'price' => 55000.00,
                'stock' => 4,
                'featured' => true,
            ],
            
            // Woodwind Instruments
            [
                'category_id' => 5,
                'name' => 'Yamaha YCL-255 Clarinet',
                'slug' => 'yamaha-ycl255-clarinet',
                'description' => 'Student clarinet with warm tone and easy playability.',
                'price' => 16000.00,
                'stock' => 12,
                'featured' => false,
            ],
            [
                'category_id' => 5,
                'name' => 'Selmer Paris Alto Saxophone',
                'slug' => 'selmer-paris-alto-sax',
                'description' => 'Professional alto saxophone with rich, expressive tone.',
                'price' => 125000.00,
                'stock' => 3,
                'featured' => true,
            ],
            
            // String Instruments
            [
                'category_id' => 6,
                'name' => 'Stentor Student Violin 4/4',
                'slug' => 'stentor-student-violin',
                'description' => 'Full-size violin perfect for beginners with bow and case included.',
                'price' => 8000.00,
                'stock' => 15,
                'featured' => false,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }

        $this->command->info('Database seeded successfully!');
        $this->command->info('Admin Login: admin@vivace.com / admin123');
        $this->command->info('User Login: user@vivace.com / user123');
    }
}