<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        $total = 0;
        $errors = [];

        // Validate cart items against current database state
        foreach ($cart as $id => $item) {
            $product = Product::find($id);
            
            if (!$product) {
                // Product no longer exists
                unset($cart[$id]);
                $errors[] = "{$item['name']} is no longer available and has been removed from your cart.";
                continue;
            }

            // Check if price has changed
            if ($product->price != $item['price']) {
                $cart[$id]['price'] = $product->price;
                $errors[] = "Price for {$product->name} has been updated.";
            }

            // Check stock availability
            if ($product->stock < $item['quantity']) {
                if ($product->stock > 0) {
                    $cart[$id]['quantity'] = $product->stock;
                    $errors[] = "Only {$product->stock} units of {$product->name} available. Quantity updated.";
                } else {
                    unset($cart[$id]);
                    $errors[] = "{$product->name} is out of stock and has been removed from your cart.";
                    continue;
                }
            }

            $total += $cart[$id]['price'] * $cart[$id]['quantity'];
        }

        // Update session with validated cart
        session()->put('cart', $cart);

        // Show errors if any
        if (!empty($errors)) {
            session()->flash('warning', implode(' ', $errors));
        }

        return view('cart.index', compact('cart', 'total'));
    }

    public function add(Request $request, $id)
    {
        // Validate input
        $validator = Validator::make($request->all(), [
            'quantity' => 'nullable|integer|min:1|max:999'
        ]);

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid quantity provided.'
                ], 422);
            }
            return redirect()->back()->withErrors($validator)->with('error', 'Invalid quantity provided.');
        }

        $product = Product::find($id);
        
        if (!$product) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Product not found.'
                ], 404);
            }
            return redirect()->back()->with('error', 'Product not found.');
        }
        
        // Validate stock availability
        if ($product->stock <= 0) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Sorry, this product is out of stock.'
                ], 400);
            }
            return redirect()->back()->with('error', 'Sorry, this product is out of stock.');
        }

        $requestedQuantity = max(1, (int)($request->quantity ?? 1));
        $cart = session()->get('cart', []);

        // Check current cart quantity
        $currentQuantity = isset($cart[$id]) ? $cart[$id]['quantity'] : 0;
        $newQuantity = $currentQuantity + $requestedQuantity;

        // Validate total quantity against stock
        if ($newQuantity > $product->stock) {
            $availableToAdd = $product->stock - $currentQuantity;
            
            if ($availableToAdd <= 0) {
                $message = "You already have the maximum available quantity ({$product->stock}) in your cart.";
                if ($request->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => $message
                    ], 400);
                }
                return redirect()->back()->with('error', $message);
            }
            
            $message = "Only {$availableToAdd} more units available. You currently have {$currentQuantity} in your cart.";
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => $message
                ], 400);
            }
            return redirect()->back()->with('error', $message);
        }

        // Add or update cart
        if (isset($cart[$id])) {
            $cart[$id]['quantity'] = $newQuantity;
        } else {
            $cart[$id] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => $requestedQuantity,
                'image' => $product->image,
            ];
        }

        session()->put('cart', $cart);
        
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Product added to cart!',
                'cartCount' => count($cart),
                'cart' => $cart
            ]);
        }
        
        return redirect()->back()->with('success', 'Product added to cart!');
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'quantity' => 'required|integer|min:1|max:999'
        ]);

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Quantity must be between 1 and 999.'
                ], 422);
            }
            return redirect()->back()->withErrors($validator);
        }

        $cart = session()->get('cart', []);

        if (!isset($cart[$id])) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Item not found in cart.'
                ], 404);
            }
            return redirect()->back()->with('error', 'Item not found in cart.');
        }

        // Fetch fresh product data
        $product = Product::find($id);
        
        if (!$product) {
            unset($cart[$id]);
            session()->put('cart', $cart);
            
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Product is no longer available and has been removed from your cart.',
                    'cartCount' => count($cart)
                ], 404);
            }
            return redirect()->back()->with('error', 'Product is no longer available and has been removed from your cart.');
        }

        $requestedQuantity = (int)$request->quantity;

        // Validate against current stock
        if ($requestedQuantity > $product->stock) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => "Only {$product->stock} units available in stock.",
                    'maxStock' => $product->stock
                ], 400);
            }
            return redirect()->back()->with('error', "Only {$product->stock} units available in stock.");
        }

        // Update quantity and price (in case price changed)
        $cart[$id]['quantity'] = $requestedQuantity;
        $cart[$id]['price'] = $product->price;
        
        session()->put('cart', $cart);
        
        // Calculate new totals
        $itemTotal = $product->price * $requestedQuantity;
        $cartTotal = 0;
        foreach ($cart as $item) {
            $cartTotal += $item['price'] * $item['quantity'];
        }
        
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Cart updated!',
                'itemTotal' => $itemTotal,
                'cartTotal' => $cartTotal,
                'cart' => $cart
            ]);
        }
        
        return redirect()->back()->with('success', 'Cart updated!');
    }

    public function remove(Request $request, $id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $productName = $cart[$id]['name'];
            unset($cart[$id]);
            session()->put('cart', $cart);
            
            if ($request->ajax()) {
                $cartTotal = 0;
                foreach ($cart as $item) {
                    $cartTotal += $item['price'] * $item['quantity'];
                }
                
                return response()->json([
                    'success' => true,
                    'message' => 'Item removed from cart!',
                    'cartCount' => count($cart),
                    'cartTotal' => $cartTotal,
                    'isEmpty' => count($cart) === 0
                ]);
            }
            
            return redirect()->back()->with('success', 'Item removed from cart!');
        }

        if ($request->ajax()) {
            return response()->json([
                'success' => false,
                'message' => 'Item not found in cart.'
            ], 404);
        }
        
        return redirect()->back()->with('error', 'Item not found in cart.');
    }

    public function clear(Request $request)
    {
        session()->forget('cart');
        
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Cart cleared!',
                'cartCount' => 0
            ]);
        }
        
        return redirect()->back()->with('success', 'Cart cleared!');
    }

    public function getCount()
    {
        $cart = session()->get('cart', []);
        return response()->json([
            'count' => count($cart)
        ]);
    }
}
