<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Book;

class CartController extends Controller
{
    public function index()
    {
        $cart = Cart::where('user_id', auth()->id())->first();
        
        if (!$cart) {
            $cart = Cart::create(['user_id' => auth()->id()]);
        }
        
        $cartItems = $cart->items()->with('book.category')->get();
        
        // Calculate totals
        $subtotal = 0;
        foreach ($cartItems as $item) {
            $subtotal += $item->book->harga * $item->qty;
        }
        
        $tax = $subtotal * 0.1; // 10% tax
        $total = $subtotal + $tax;
        
        return view('user.cart.index', compact('cart', 'cartItems', 'subtotal', 'tax', 'total'));
    }
    
    public function add(Request $request, $bookId)
    {
        $book = Book::findOrFail($bookId);
        
        // Check stock
        if ($book->stok < 1) {
            return redirect()->back()->with('error', 'Book is out of stock!');
        }
        
        // Get or create cart
        $cart = Cart::firstOrCreate(
            ['user_id' => auth()->id()]
        );
        
        // Check if item already in cart
        $cartItem = CartItem::where('cart_id', $cart->id)
            ->where('book_id', $bookId)
            ->first();
        
        if ($cartItem) {
            // Update quantity if not exceeding stock
            if ($cartItem->qty + 1 > $book->stok) {
                return redirect()->back()->with('error', 'Cannot add more items. Stock limit reached!');
            }
            $cartItem->increment('qty');
        } else {
            // Create new cart item
            CartItem::create([
                'cart_id' => $cart->id,
                'book_id' => $bookId,
                'qty' => 1
            ]);
        }
        
        return redirect()->back()->with('success', 'Book added to cart!');
    }
    
    public function update(Request $request, $itemId)
    {
        $request->validate([
            'qty' => 'required|integer|min:1'
        ]);
        
        $cartItem = CartItem::findOrFail($itemId);
        
        // Check if item belongs to user's cart
        if ($cartItem->cart->user_id !== auth()->id()) {
            abort(403);
        }
        
        // Check stock
        if ($request->qty > $cartItem->book->stok) {
            return redirect()->back()->with('error', 'Quantity exceeds available stock!');
        }
        
        $cartItem->update(['qty' => $request->qty]);
        
        return redirect()->back()->with('success', 'Cart updated!');
    }
    
    public function remove($itemId)
    {
        $cartItem = CartItem::findOrFail($itemId);
        
        // Check if item belongs to user's cart
        if ($cartItem->cart->user_id !== auth()->id()) {
            abort(403);
        }
        
        $cartItem->delete();
        
        return redirect()->back()->with('success', 'Item removed from cart!');
    }
}
