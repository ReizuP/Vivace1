<?php


namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function category(Category $category, Request $request)
    {
        // Merge category into request and reuse index flow
        $request->merge(['category' => $category->id]);
        return $this->index($request);
    }

    public function index(Request $request)
    {
        $query = Product::with('category');

        // Search functionality
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Category filter
        if ($request->has('category') && $request->category != '') {
            $query->where('category_id', $request->category);
        }

        // Sorting
        if ($request->has('sort')) {
            switch ($request->sort) {
                case 'price_asc':
                    $query->orderBy('price', 'asc');
                    break;
                case 'price_desc':
                    $query->orderBy('price', 'desc');
                    break;
                case 'name_asc':
                    $query->orderBy('name', 'asc');
                    break;
                case 'name_desc':
                    $query->orderBy('name', 'desc');
                    break;
                default:
                    $query->latest();
            }
        } else {
            $query->latest();
        }

        $products = $query->paginate(12);
        $categories = Category::all();

        return view('products.index', compact('products', 'categories'));
    }

    public function show($slug)
    {
        $product = Product::where('slug', $slug)->with('category')->firstOrFail();
        $relatedProducts = Product::where('category_id', $product->category_id)
                                  ->where('id', '!=', $product->id)
                                  ->take(4)
                                  ->get();

        // Track recently viewed products
        $recentlyViewed = session('recently_viewed', []);
        // Remove if already exists
        $recentlyViewed = array_diff($recentlyViewed, [$product->id]);
        // Add to beginning
        array_unshift($recentlyViewed, $product->id);
        // Keep only last 20
        $recentlyViewed = array_slice($recentlyViewed, 0, 20);
        session(['recently_viewed' => $recentlyViewed]);

        return view('products.show', compact('product', 'relatedProducts'));
    }
}
