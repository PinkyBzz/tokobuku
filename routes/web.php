<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\BookController as AdminBookController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\BookController;
use App\Http\Controllers\User\BooksController;
use App\Http\Controllers\User\CartController;
use App\Http\Controllers\User\CheckoutController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\ReviewController;

// Landing Page
Route::get('/', function () {
    $books = \App\Models\Book::with('category')
        ->where('stok', '>', 0)
        ->latest()
        ->take(12)
        ->get();
    $categories = \App\Models\Category::withCount('books')->get();
    return view('landing', compact('books', 'categories'));
})->name('landing');

// About Page
Route::get('/about', function () {
    return view('about');
})->name('about');

// Contact Page
Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::post('/contact', function (Illuminate\Http\Request $request) {
    // Handle contact form submission
    $request->validate([
        'name' => 'required',
        'email' => 'required|email',
        'subject' => 'required',
        'message' => 'required'
    ]);
    
    // In a real application, you would send an email here
    // For now, just return success message
    return back()->with('success', 'Thank you for your message! We will get back to you soon.');
})->name('contact.submit');

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Books Management
    Route::resource('books', AdminBookController::class);
    
    // Categories Management
    Route::resource('categories', CategoryController::class);
    
    // Orders Management
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::patch('/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.update-status');
    Route::put('/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.status');
    Route::put('/orders/{order}/payment', [AdminOrderController::class, 'verifyPayment'])->name('orders.payment');
    Route::get('/orders/{order}/invoice', [AdminOrderController::class, 'invoice'])->name('orders.invoice');
    
    // Users Management
    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
    Route::patch('/users/{user}/toggle-role', [AdminUserController::class, 'toggleRole'])->name('users.toggle-role');
    Route::delete('/users/{user}', [AdminUserController::class, 'destroy'])->name('users.destroy');
    
    // Reports
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/export', [ReportController::class, 'export'])->name('reports.export');
});

// User Routes
Route::middleware(['auth'])->group(function () {
    // Dashboard (User Home)
    Route::get('/dashboard', [HomeController::class, 'index'])->name('user.home');
    Route::get('/books', [BooksController::class, 'index'])->name('user.books.index');
    Route::get('/books/{book}', [BookController::class, 'show'])->name('user.books.show');
    Route::post('/books/{book}/reviews', [BookController::class, 'storeReview'])->name('user.books.reviews.store');
    
    // Cart
    Route::get('/cart', [CartController::class, 'index'])->name('user.cart.index');
    Route::post('/cart/add/{book}', [CartController::class, 'add'])->name('user.cart.add');
    Route::patch('/cart/update/{item}', [CartController::class, 'update'])->name('user.cart.update');
    Route::delete('/cart/remove/{item}', [CartController::class, 'remove'])->name('user.cart.remove');
    
    // Checkout
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('user.checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'process'])->name('user.checkout.process');
    Route::get('/orders', [CheckoutController::class, 'orders'])->name('user.orders.index');
    Route::get('/orders/{order}', [CheckoutController::class, 'show'])->name('user.orders.show');
    Route::post('/orders/{order}/upload-payment', [CheckoutController::class, 'uploadPayment'])->name('user.orders.upload-payment');
    
    // Profile
    Route::get('/profile', [ProfileController::class, 'index'])->name('user.profile.index');
    Route::put('/profile', [ProfileController::class, 'update'])->name('user.profile.update');
    
    // Reviews
    Route::post('/reviews', [ReviewController::class, 'store'])->name('user.reviews.store');
});
