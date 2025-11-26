<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Book;
use App\Models\Order;
use App\Models\ExpenseIncome;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        try {
            // Statistics
            $totalUsers = User::where('role', 'user')->count();
            $totalBooks = Book::count();
            $totalOrders = Order::count();
            $totalRevenue = Order::where('status', '!=', 'cancelled')->sum('total_harga');
            
            // Recent orders
            $recentOrders = Order::with(['user', 'orderItems.book'])
                ->latest()
                ->take(10)
                ->get();
            
            // Monthly sales data for chart
            $monthlySales = Order::select(
                    DB::raw('MONTH(created_at) as month'),
                    DB::raw('SUM(total_harga) as total')
                )
                ->whereYear('created_at', date('Y'))
                ->where('status', '!=', 'cancelled')
                ->groupBy(DB::raw('MONTH(created_at)'))
                ->orderBy('month')
                ->get()
                ->pluck('total', 'month')
                ->toArray();
            
            // Fill missing months with 0
            $salesData = [];
            for ($i = 1; $i <= 12; $i++) {
                $salesData[] = $monthlySales[$i] ?? 0;
            }
            
            // Top selling books - simplified approach
            $topBooks = collect();
            try {
                $topBookIds = DB::table('order_items')
                    ->join('orders', 'order_items.order_id', '=', 'orders.id')
                    ->where('orders.status', '!=', 'cancelled')
                    ->select('order_items.book_id', DB::raw('SUM(order_items.qty) as total_sold'))
                    ->groupBy('order_items.book_id')
                    ->orderBy('total_sold', 'desc')
                    ->take(5)
                    ->get();
                
                foreach ($topBookIds as $bookData) {
                    $book = Book::find($bookData->book_id);
                    if ($book) {
                        $book->total_sold = $bookData->total_sold;
                        $topBooks->push($book);
                    }
                }
            } catch (\Exception $e) {
                // If top books query fails, just show empty collection
                $topBooks = collect();
            }
            
            // Low stock books
            $lowStockBooks = Book::where('stock', '<=', 10)
                ->orderBy('stock')
                ->take(5)
                ->get();
            
            // Orders by status
            $ordersByStatus = [
                'pending' => Order::where('status', 'pending')->count(),
                'paid' => Order::where('status', 'paid')->count(),
                'processed' => Order::where('status', 'processed')->count(),
                'shipped' => Order::where('status', 'shipped')->count(),
                'delivered' => Order::where('status', 'delivered')->count(),
                'cancelled' => Order::where('status', 'cancelled')->count(),
            ];
            
            return view('admin.dashboard', compact(
                'totalUsers',
                'totalBooks',
                'totalOrders',
                'totalRevenue',
                'recentOrders',
                'salesData',
                'topBooks',
                'lowStockBooks',
                'ordersByStatus'
            ));
            
        } catch (\Exception $e) {
            // Fallback with empty data if there are any errors
            return view('admin.dashboard', [
                'totalUsers' => 0,
                'totalBooks' => 0,
                'totalOrders' => 0,
                'totalRevenue' => 0,
                'recentOrders' => collect(),
                'salesData' => array_fill(0, 12, 0),
                'topBooks' => collect(),
                'lowStockBooks' => collect(),
                'ordersByStatus' => [
                    'pending' => 0,
                    'paid' => 0,
                    'processed' => 0,
                    'shipped' => 0,
                    'delivered' => 0,
                    'cancelled' => 0,
                ]
            ]);
        }
    }
}
