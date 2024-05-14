<?php

// CartController.php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Pertanyaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function showCart()
    {
        // Retrieve the cart for the currently authenticated user
        $cart = Auth::user()->cart;

        // Pass the $cart variable to the view
        return view('cart.index', ['cart' => $cart]);
    }

    public function addItemToCart(Request $request, $pertanyaanId)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please log in to add items to the cart.');
        }

        $pertanyaan = Pertanyaan::findOrFail($pertanyaanId);
        $cart = auth()->user()->cart;

        // Check if the item is already in the cart, if yes, update quantity
        $existingItem = $cart->items()->where('pertanyaan_id', $pertanyaanId)->first();

        if ($existingItem) {
            $existingItem->update([
                'quantity' => $existingItem->quantity + $request->quantity,
            ]);
        } else {
            // Otherwise, create a new cart item
            $cart->items()->create([
                'pertanyaan_id' => $pertanyaanId,
                'quantity' => $request->quantity,
            ]);
        }

        // Update the total in the cart
        $cart->updateTotal();

        return redirect()->route('cart.index')->with('success', 'Item added to cart successfully.');
    }
}



