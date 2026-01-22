<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Featured products
        $featuredProducts = Product::where('featured', true)
            ->where('stock', '>', 0)
            ->take(8)
            ->get();

        // Best sellers - products with most order items
        $bestSellers = Product::withCount('orderItems')
            ->where('stock', '>', 0)
            ->orderBy('order_items_count', 'desc')
            ->take(8)
            ->get();

        // Categories for shop by category
        $categories = Category::withCount('products')
            ->having('products_count', '>', 0)
            ->get();

        // Recently viewed products (from session)
        $recentlyViewedIds = session('recently_viewed', []);
        $recentlyViewed = collect();
        if (!empty($recentlyViewedIds)) {
            $recentlyViewed = Product::whereIn('id', array_reverse($recentlyViewedIds))
                ->where('stock', '>', 0)
                ->take(8)
                ->get();
        }

        return view('home', compact('featuredProducts', 'bestSellers', 'categories', 'recentlyViewed'));
    }

    public function searchAutocomplete(Request $request)
    {
        $query = $request->get('q', '');
        
        if (strlen($query) < 2) {
            return response()->json([]);
        }

        // Match products
        $products = Product::where(function($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                  ->orWhere('description', 'like', "%{$query}%");
            })
            ->where('stock', '>', 0)
            ->take(6)
            ->get(['id', 'name', 'slug', 'price', 'image']);

        // Match categories
        $categories = Category::where('name', 'like', "%{$query}%")
            ->take(4)
            ->get(['id', 'name', 'slug']);

        $results = [];

        foreach ($categories as $category) {
            $results[] = [
                'type' => 'category',
                'id' => $category->id,
                'name' => $category->name,
                'slug' => $category->slug,
                'url'  => route('products.category', $category),
            ];
        }

        foreach ($products as $product) {
            $results[] = [
                'type'  => 'product',
                'id'    => $product->id,
                'name'  => $product->name,
                'slug'  => $product->slug,
                'price' => (string) $product->price,
                'image' => $product->image ? asset($product->image) : null,
                'url'   => route('products.show', $product->slug),
            ];
        }

        return response()->json($results);
    }

    public function about()
    {
        return view('about');
    }

    public function contact()
    {
        return view('contact');
    }

    public function sendContact(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'message' => 'required|string',
        ]);

        // Here you would send an email or store the message
        return redirect()->back()->with('success', 'Thank you for contacting us! We will get back to you soon.');
    }
}