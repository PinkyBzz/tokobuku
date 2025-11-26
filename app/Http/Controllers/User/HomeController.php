<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Category;
use App\Models\Order;
use App\Models\Cart;

class HomeController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // Get latest books
        $latestBooks = Book::with('category')
            ->where('stok', '>', 0)
            ->latest()
            ->take(8)
            ->get();
        
        // Get all categories with book count
        $categories = Category::withCount('books')->get();
        
        // Get user's cart count
        $cart = Cart::where('user_id', $user->id)->first();
        $cartItemsCount = $cart ? $cart->items()->count() : 0;
        
        // Get user's orders statistics
        $totalOrders = Order::where('user_id', $user->id)->count();
        $pendingOrders = Order::where('user_id', $user->id)
            ->where('status', 'pending')
            ->count();
        $completedOrders = Order::where('user_id', $user->id)
            ->where('status', 'completed')
            ->count();
        
        return view('user.home', compact(
            'latestBooks',
            'categories',
            'cartItemsCount',
            'totalOrders',
            'pendingOrders',
            'completedOrders'
        ));
    }
}
