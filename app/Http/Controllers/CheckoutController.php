<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty!');
        }

        // Validate cart before showing checkout
        $validatedCart = [];
        $total = 0;
        $errors = [];

        foreach ($cart as $id => $item) {
            $product = Product::find($id);
            
            if (!$product) {
                $errors[] = "{$item['name']} is no longer available.";
                continue;
            }

            if ($product->stock < $item['quantity']) {
                if ($product->stock > 0) {
                    $errors[] = "Only {$product->stock} units of {$product->name} available.";
                } else {
                    $errors[] = "{$product->name} is out of stock.";
                    continue;
                }
            }

            // Use current price from database
            $validatedCart[$id] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => min($item['quantity'], $product->stock),
                'image' => $item['image'],
            ];

            $total += $validatedCart[$id]['price'] * $validatedCart[$id]['quantity'];
        }

        // If there are errors, redirect back to cart
        if (!empty($errors)) {
            session()->put('cart', $validatedCart);
            return redirect()->route('cart.index')->with('error', implode(' ', $errors));
        }

        // Update cart with validated data
        session()->put('cart', $validatedCart);

        $user = auth()->user();
        return view('checkout.index', compact('validatedCart', 'total', 'user'));
    }

    public function process(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'shipping_name' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/',
            'shipping_phone' => 'required|string|regex:/^(\+63|0)?[0-9]{10}$/|max:20',
            'shipping_address' => 'required|string|min:10|max:500',
            'shipping_city' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/',
            'shipping_postal_code' => 'required|string|regex:/^[0-9]{4}$/',
            'payment_method' => ['required', 'in:cod,bank_transfer'],
            
            // Payment details for specific methods
            'card_number' => 'required_if:payment_method,card|nullable|digits:16',
            'card_name' => 'required_if:payment_method,card|nullable|string|max:255',
            'card_expiry' => 'required_if:payment_method,card|nullable|regex:/^(0[1-9]|1[0-2])\/[0-9]{2}$/',
            'card_cvv' => 'required_if:payment_method,card|nullable|digits:3',
            
            'gcash_number' => 'required_if:payment_method,gcash|nullable|regex:/^(\+63|0)?[0-9]{10}$/|max:20',
        ], [
            'shipping_name.required' => 'Name is required.',
            'shipping_name.regex' => 'Name should only contain letters and spaces.',
            'shipping_phone.required' => 'Phone number is required.',
            'shipping_phone.regex' => 'Please enter a valid Philippine phone number (e.g., 09171234567 or +639171234567).',
            'shipping_address.required' => 'Address is required.',
            'shipping_address.min' => 'Address must be at least 10 characters.',
            'shipping_city.required' => 'City is required.',
            'shipping_city.regex' => 'City should only contain letters and spaces.',
            'shipping_postal_code.required' => 'Postal code is required.',
            'shipping_postal_code.regex' => 'Postal code must be exactly 4 digits.',
            'payment_method.required' => 'Please select a payment method.',
            'card_number.digits' => 'Card number must be 16 digits.',
            'card_expiry.regex' => 'Card expiry must be in MM/YY format.',
            'card_cvv.digits' => 'CVV must be 3 digits.',
            'gcash_number.regex' => 'Please enter a valid GCash phone number.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Please fix the errors in the form.');
        }

        $validated = $validator->validated();
        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty!');
        }

        DB::beginTransaction();
        try {
            // Double-check stock availability and lock rows for update
            $stockErrors = [];
            $orderItems = [];
            $total = 0;

            foreach ($cart as $id => $item) {
                // Lock the product row to prevent race conditions
                $product = Product::where('id', $id)->lockForUpdate()->first();
                
                if (!$product) {
                    $stockErrors[] = "{$item['name']} is no longer available.";
                    continue;
                }

                // Check stock availability
                if ($product->stock < $item['quantity']) {
                    if ($product->stock > 0) {
                        $stockErrors[] = "Only {$product->stock} units of {$product->name} available (you requested {$item['quantity']}).";
                    } else {
                        $stockErrors[] = "{$product->name} is out of stock.";
                    }
                    continue;
                }

                // Prepare order item with current price from database
                $orderItems[] = [
                    'product' => $product,
                    'quantity' => $item['quantity'],
                    'price' => $product->price,
                ];

                $total += $product->price * $item['quantity'];
            }

            // If there are stock errors, rollback and redirect
            if (!empty($stockErrors)) {
                DB::rollback();
                return redirect()->route('cart.index')->with('error', implode(' ', $stockErrors));
            }

            // Create order
            $order = Order::create([
                'user_id' => auth()->id(),
                'order_number' => Order::generateOrderNumber(),
                'total_amount' => $total,
                'status' => 'to_pay',
                'shipping_name' => $validated['shipping_name'],
                'shipping_phone' => $validated['shipping_phone'],
                'shipping_address' => $validated['shipping_address'],
                'shipping_city' => $validated['shipping_city'],
                'shipping_postal_code' => $validated['shipping_postal_code'],
                'payment_method' => $validated['payment_method'],
            ]);

            // Create order items and update stock
            foreach ($orderItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product']->id,
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);

                // Decrement stock
                $newStock = $item['product']->stock - $item['quantity'];
                
                if ($newStock < 0) {
                    throw new \Exception("Insufficient stock for {$item['product']->name}");
                }

                $item['product']->update(['stock' => $newStock]);
            }

            // Process payment based on method
            $paymentStatus = 'pending';
            $transactionId = null;

            if ($validated['payment_method'] === 'cod') {
                $paymentStatus = 'pending';
            } elseif ($validated['payment_method'] === 'card') {
                // Simulate card payment processing
                $paymentResult = $this->processCardPayment([
                    'card_number' => $validated['card_number'],
                    'card_name' => $validated['card_name'],
                    'card_expiry' => $validated['card_expiry'],
                    'card_cvv' => $validated['card_cvv'],
                    'amount' => $total
                ]);
                
                if ($paymentResult['success']) {
                    $paymentStatus = 'completed';
                    $transactionId = $paymentResult['transaction_id'];
                    $order->update(['status' => 'to_ship']);
                } else {
                    DB::rollback();
                    return redirect()->back()
                        ->withInput()
                        ->with('error', 'Payment failed: ' . $paymentResult['message']);
                }
            } elseif ($validated['payment_method'] === 'gcash') {
                // Simulate GCash payment
                $paymentResult = $this->processGCashPayment([
                    'phone' => $validated['gcash_number'],
                    'amount' => $total
                ]);
                
                if ($paymentResult['success']) {
                    $paymentStatus = 'completed';
                    $transactionId = $paymentResult['transaction_id'];
                    $order->update(['status' => 'to_ship']);
                } else {
                    DB::rollback();
                    return redirect()->back()
                        ->withInput()
                        ->with('error', 'Payment failed: ' . $paymentResult['message']);
                }
            } elseif ($validated['payment_method'] === 'bank_transfer') {
                $paymentStatus = 'pending';
            }

            // Create payment record
            Payment::create([
                'order_id' => $order->id,
                'payment_method' => $validated['payment_method'],
                'amount' => $total,
                'status' => $paymentStatus,
                'transaction_id' => $transactionId,
                'payment_details' => json_encode([
                    'method' => $validated['payment_method'],
                    'processed_at' => now()->toDateTimeString()
                ])
            ]);

            // Clear cart
            session()->forget('cart');
            
            DB::commit();

            return redirect()->route('user.order.details', $order->id)
                           ->with('success', 'Order placed successfully! Order number: ' . $order->order_number);
                           
        } catch (\Exception $e) {
            DB::rollback();
            
            // Log the error for debugging
            \Log::error('Checkout failed: ' . $e->getMessage(), [
                'user_id' => auth()->id(),
                'cart' => $cart,
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'Something went wrong while processing your order. Please try again or contact support.');
        }
    }

    /**
     * Simulate card payment processing
     */
    private function processCardPayment($data)
    {
        // Simulate payment processing delay
        sleep(1);
        
        // For demo purposes: approve all valid cards
        // In production, this would integrate with actual payment gateway
        $cardNumber = $data['card_number'];
        
        // Simulate failure for specific test card
        if ($cardNumber === '4111111111111111') {
            return [
                'success' => false,
                'message' => 'Card declined. Please try another card.'
            ];
        }
        
        return [
            'success' => true,
            'transaction_id' => 'TXN' . strtoupper(uniqid()),
            'message' => 'Payment successful'
        ];
    }

    /**
     * Simulate GCash payment processing
     */
    private function processGCashPayment($data)
    {
        // Simulate payment processing delay
        sleep(1);
        
        // For demo purposes: approve all transactions
        // In production, this would integrate with GCash API
        return [
            'success' => true,
            'transaction_id' => 'GCASH' . strtoupper(uniqid()),
            'message' => 'Payment successful'
        ];
    }
}
