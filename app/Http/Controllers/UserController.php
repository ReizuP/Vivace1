<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function profile()
    {
        $user = auth()->user();
        return view('user.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:10',
            'current_password' => 'nullable|required_with:new_password',
            'new_password' => 'nullable|min:6|confirmed',
        ]);

        if ($request->filled('current_password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Current password is incorrect']);
            }
            $validated['password'] = Hash::make($request->new_password);
        }

        $user->update($validated);

        return redirect()->back()->with('success', 'Profile updated successfully!');
    }

    public function orders(Request $request)
    {
        $status = $request->get('status');
        
        $query = Order::where('user_id', auth()->id())->with('items.product');

        if ($status && in_array($status, ['to_pay', 'to_ship', 'on_transit', 'delivered'])) {
            $query->where('status', $status);
        }

        $orders = $query->latest()->paginate(10);

        return view('user.orders', compact('orders', 'status'));
    }

    public function orderDetails($id)
    {
        $order = Order::where('user_id', auth()->id())
                     ->where('id', $id)
                     ->with(['items.product', 'payment'])
                     ->firstOrFail();

        return view('user.order-details', compact('order'));
    }
}