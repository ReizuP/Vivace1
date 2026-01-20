<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Get cart items (from database for auth users, session for guests)
     */
    private function getCartItems()
    {
        if (Auth::check()) {
            return CartItem::where('user_id', Auth::id())
                ->with('product')
                ->get();
        }
        
        return session()->get('cart', []);
    }

    /**
     * Get cart count
     */
    private function getCartCount()
    {
        if (Auth::check()) {
            return CartItem::where('user_id', Auth::id())->count();
        }
        
        return count(session()->get('cart', []));
    }

    /**
     * Sync session cart to database when user logs in
     */
    public static function syncSessionCartToDatabase($userId)
    {
        $sessionCart = session()->get('cart', []);
        
        if (empty($sessionCart)) {
            return;
        }

        foreach ($sessionCart as $productId => $item) {
            $product = Product::find($productId);
            
            if (!$product || $product->stock <= 0) {
                continue;
            }

            $existingCartItem = CartItem::where('user_id', $userId)
                ->where('product_id', $productId)
                ->first();

            if ($existingCartItem) {
                // Add to existing quantity
                $newQuantity = min(
                    $existingCartItem->quantity + $item['quantity'],
                    $product->stock
                );
                $existingCartItem->update(['quantity' => $newQuantity]);
            } else {
                // Create new cart item
                CartItem::create([
                    'user_id' => $userId,
                    'product_id' => $productId,
                    'quantity' => min($item['quantity'], $product->stock)
                ]);
            }
        }

        // Clear session cart after sync
        session()->forget('cart');
    }

    public function index()
    {
        $cart = [];
        $total = 0;
        $errors = [];

        if (Auth::check()) {
            // Database cart
            $cartItems = CartItem::where('user_id', Auth::id())
                ->with('product')
                ->get();

            foreach ($cartItems as $cartItem) {
                $product = $cartItem->product;
                
                if (!$product) {
                    $cartItem->delete();
                    $errors[] = "A product is no longer available and has been removed from your cart.";
                    continue;
                }

                // Check stock availability
                if ($product->stock < $cartItem->quantity) {
                    if ($product->stock > 0) {
                        $cartItem->update(['quantity' => $product->stock]);
                        $errors[] = "Only {$product->stock} units of {$product->name} available. Quantity updated.";
                    } else {
                        $cartItem->delete();
                        $errors[] = "{$product->name} is out of stock and has been removed from your cart.";
                        continue;
                    }
                }

                $cart[$product->id] = [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => $product->price,
                    'quantity' => $cartItem->quantity,
                    'image' => $product->image,
                ];

                $total += $product->price * $cartItem->quantity;
            }
        } else {
            // Session cart
            $sessionCart = session()->get('cart', []);

            foreach ($sessionCart as $id => $item) {
                $product = Product::find($id);
                
                if (!$product) {
                    unset($sessionCart[$id]);
                    $errors[] = "{$item['name']} is no longer available and has been removed from your cart.";
                    continue;
                }

                if ($product->price != $item['price']) {
                    $sessionCart[$id]['price'] = $product->price;
                    $errors[] = "Price for {$product->name} has been updated.";
                }

                if ($product->stock < $item['quantity']) {
                    if ($product->stock > 0) {
                        $sessionCart[$id]['quantity'] = $product->stock;
                        $errors[] = "Only {$product->stock} units of {$product->name} available. Quantity updated.";
                    } else {
                        unset($sessionCart[$id]);
                        $errors[] = "{$product->name} is out of stock and has been removed from your cart.";
                        continue;
                    }
                }

                $total += $sessionCart[$id]['price'] * $sessionCart[$id]['quantity'];
            }

            session()->put('cart', $sessionCart);
            $cart = $sessionCart;
        }

        if (!empty($errors)) {
            session()->flash('warning', implode(' ', $errors));
        }

        return view('cart.index', compact('cart', 'total'));
    }

    public function add(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'quantity' => 'nullable|integer|min:1|max:999'
        ]);

        if ($validator->fails()) {
            return $this->jsonOrRedirect($request, false, 'Invalid quantity provided.', 422);
        }

        $product = Product::find($id);
        
        if (!$product) {
            return $this->jsonOrRedirect($request, false, 'Product not found.', 404);
        }
        
        if ($product->stock <= 0) {
            return $this->jsonOrRedirect($request, false, 'Sorry, this product is out of stock.', 400);
        }

        $requestedQuantity = max(1, (int)($request->quantity ?? 1));

        if (Auth::check()) {
            // Database cart
            $cartItem = CartItem::where('user_id', Auth::id())
                ->where('product_id', $id)
                ->first();

            $currentQuantity = $cartItem ? $cartItem->quantity : 0;
            $newQuantity = $currentQuantity + $requestedQuantity;

            if ($newQuantity > $product->stock) {
                $availableToAdd = $product->stock - $currentQuantity;
                
                if ($availableToAdd <= 0) {
                    return $this->jsonOrRedirect($request, false, "You already have the maximum available quantity ({$product->stock}) in your cart.", 400);
                }
                
                return $this->jsonOrRedirect($request, false, "Only {$availableToAdd} more units available. You currently have {$currentQuantity} in your cart.", 400);
            }

            if ($cartItem) {
                $cartItem->update(['quantity' => $newQuantity]);
            } else {
                CartItem::create([
                    'user_id' => Auth::id(),
                    'product_id' => $id,
                    'quantity' => $requestedQuantity
                ]);
            }

            $cartCount = $this->getCartCount();
        } else {
            // Session cart
            $cart = session()->get('cart', []);
            $currentQuantity = isset($cart[$id]) ? $cart[$id]['quantity'] : 0;
            $newQuantity = $currentQuantity + $requestedQuantity;

            if ($newQuantity > $product->stock) {
                $availableToAdd = $product->stock - $currentQuantity;
                
                if ($availableToAdd <= 0) {
                    return $this->jsonOrRedirect($request, false, "You already have the maximum available quantity ({$product->stock}) in your cart.", 400);
                }
                
                return $this->jsonOrRedirect($request, false, "Only {$availableToAdd} more units available. You currently have {$currentQuantity} in your cart.", 400);
            }

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
            $cartCount = count($cart);
        }

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Product added to cart!',
                'cartCount' => $cartCount
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
            return $this->jsonOrRedirect($request, false, 'Quantity must be between 1 and 999.', 422);
        }

        $product = Product::find($id);
        
        if (!$product) {
            // Remove from cart
            if (Auth::check()) {
                CartItem::where('user_id', Auth::id())->where('product_id', $id)->delete();
            } else {
                $cart = session()->get('cart', []);
                unset($cart[$id]);
                session()->put('cart', $cart);
            }
            
            return $this->jsonOrRedirect($request, false, 'Product is no longer available and has been removed from your cart.', 404);
        }

        $requestedQuantity = (int)$request->quantity;

        if ($requestedQuantity > $product->stock) {
            return $this->jsonOrRedirect($request, false, "Only {$product->stock} units available in stock.", 400, ['maxStock' => $product->stock]);
        }

        if (Auth::check()) {
            $cartItem = CartItem::where('user_id', Auth::id())
                ->where('product_id', $id)
                ->first();

            if (!$cartItem) {
                return $this->jsonOrRedirect($request, false, 'Item not found in cart.', 404);
            }

            $cartItem->update(['quantity' => $requestedQuantity]);
            
            $itemTotal = $product->price * $requestedQuantity;
            $cartTotal = CartItem::where('user_id', Auth::id())
                ->with('product')
                ->get()
                ->sum(function($item) {
                    return $item->product->price * $item->quantity;
                });
        } else {
            $cart = session()->get('cart', []);

            if (!isset($cart[$id])) {
                return $this->jsonOrRedirect($request, false, 'Item not found in cart.', 404);
            }

            $cart[$id]['quantity'] = $requestedQuantity;
            $cart[$id]['price'] = $product->price;
            
            session()->put('cart', $cart);
            
            $itemTotal = $product->price * $requestedQuantity;
            $cartTotal = 0;
            foreach ($cart as $item) {
                $cartTotal += $item['price'] * $item['quantity'];
            }
        }
        
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Cart updated!',
                'itemTotal' => $itemTotal,
                'cartTotal' => $cartTotal
            ]);
        }
        
        return redirect()->back()->with('success', 'Cart updated!');
    }

    public function remove(Request $request, $id)
    {
        if (Auth::check()) {
            $deleted = CartItem::where('user_id', Auth::id())
                ->where('product_id', $id)
                ->delete();

            if (!$deleted) {
                return $this->jsonOrRedirect($request, false, 'Item not found in cart.', 404);
            }

            $cartCount = $this->getCartCount();
            $cartTotal = CartItem::where('user_id', Auth::id())
                ->with('product')
                ->get()
                ->sum(function($item) {
                    return $item->product ? ($item->product->price * $item->quantity) : 0;
                });
        } else {
            $cart = session()->get('cart', []);

            if (!isset($cart[$id])) {
                return $this->jsonOrRedirect($request, false, 'Item not found in cart.', 404);
            }

            unset($cart[$id]);
            session()->put('cart', $cart);
            
            $cartCount = count($cart);
            $cartTotal = 0;
            foreach ($cart as $item) {
                $cartTotal += $item['price'] * $item['quantity'];
            }
        }
        
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Item removed from cart!',
                'cartCount' => $cartCount,
                'cartTotal' => $cartTotal,
                'isEmpty' => $cartCount === 0
            ]);
        }
        
        return redirect()->back()->with('success', 'Item removed from cart!');
    }

    public function clear(Request $request)
    {
        if (Auth::check()) {
            CartItem::where('user_id', Auth::id())->delete();
        } else {
            session()->forget('cart');
        }
        
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
        return response()->json([
            'count' => $this->getCartCount()
        ]);
    }

    /**
     * Helper method to return JSON for AJAX or redirect for regular requests
     */
    private function jsonOrRedirect($request, $success, $message, $status = 200, $extra = [])
    {
        if ($request->ajax()) {
            return response()->json(array_merge([
                'success' => $success,
                'message' => $message
            ], $extra), $status);
        }
        
        if ($success) {
            return redirect()->back()->with('success', $message);
        }
        
        return redirect()->back()->with('error', $message);
    }
}
