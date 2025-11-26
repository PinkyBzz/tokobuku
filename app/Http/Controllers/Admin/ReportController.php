<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Book;
use App\Models\User;
use App\Models\ExpenseIncome;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $days = $request->get('days', 30);
        $startDate = now()->subDays($days)->startOfDay();
        $endDate = now()->endOfDay();
        
        // Summary Stats
        $totalRevenue = Order::whereBetween('created_at', [$startDate, $endDate])
            ->where('status', '!=', 'cancelled')
            ->sum('total_harga') ?? 0;
            
        $totalOrders = Order::whereBetween('created_at', [$startDate, $endDate])
            ->where('status', '!=', 'cancelled')
            ->count();
        
        $booksSold = DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->whereBetween('orders.created_at', [$startDate, $endDate])
            ->where('orders.status', '!=', 'cancelled')
            ->sum('order_items.qty') ?? 0;
            
        $avgOrderValue = $totalOrders > 0 ? ($totalRevenue / $totalOrders) : 0;
        
        // Sales Trend Data (for chart)
        $salesTrendData = Order::whereBetween('created_at', [$startDate, $endDate])
            ->where('status', '!=', 'cancelled')
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(total_harga) as revenue')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get();
            
        $salesTrendLabels = $salesTrendData->pluck('date')->map(function($date) {
            return Carbon::parse($date)->format('M d');
        })->toArray();
        
        $salesTrendData = $salesTrendData->pluck('revenue')->toArray();
        
        // Top Categories Data (for chart)
        $categoryData = DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('books', 'order_items.book_id', '=', 'books.id')
            ->join('categories', 'books.category_id', '=', 'categories.id')
            ->whereBetween('orders.created_at', [$startDate, $endDate])
            ->where('orders.status', '!=', 'cancelled')
            ->select(
                'categories.name',
                DB::raw('SUM(order_items.qty) as total_sold')
            )
            ->groupBy('categories.id', 'categories.name')
            ->orderBy('total_sold', 'desc')
            ->take(5)
            ->get();
            
        $categoryLabels = $categoryData->pluck('name')->toArray();
        $categoryData = $categoryData->pluck('total_sold')->toArray();
            
        // Top Selling Books
        $topBooks = DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('books', 'order_items.book_id', '=', 'books.id')
            ->whereBetween('orders.created_at', [$startDate, $endDate])
            ->where('orders.status', '!=', 'cancelled')
            ->select(
                'books.id',
                'books.judul',
                'books.pengarang',
                'books.cover_photo',
                DB::raw('SUM(order_items.qty) as total_sold'),
                DB::raw('SUM(order_items.subtotal) as revenue')
            )
            ->groupBy('books.id', 'books.judul', 'books.pengarang', 'books.cover_photo')
            ->orderBy('total_sold', 'desc')
            ->take(5)
            ->get();
        
        // Top Customers
        $topCustomers = DB::table('orders')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->whereBetween('orders.created_at', [$startDate, $endDate])
            ->where('orders.status', '!=', 'cancelled')
            ->select(
                'users.id',
                'users.name',
                'users.email',
                'users.photo',
                DB::raw('COUNT(orders.id) as orders_count'),
                DB::raw('SUM(orders.total_harga) as total_spent')
            )
            ->groupBy('users.id', 'users.name', 'users.email', 'users.photo')
            ->orderBy('total_spent', 'desc')
            ->take(5)
            ->get();
            
        return view('admin.reports.index', compact(
            'totalRevenue',
            'totalOrders',
            'booksSold',
            'avgOrderValue',
            'salesTrendLabels',
            'salesTrendData',
            'categoryLabels',
            'categoryData',
            'topBooks',
            'topCustomers'
        ));
    }

    public function export(Request $request)
    {
        $days = $request->get('days', 30);
        $startDate = now()->subDays($days)->startOfDay();
        $endDate = now()->endOfDay();
        
        // Get all data
        $totalRevenue = Order::whereBetween('created_at', [$startDate, $endDate])
            ->where('status', '!=', 'cancelled')
            ->sum('total_harga') ?? 0;
            
        $totalOrders = Order::whereBetween('created_at', [$startDate, $endDate])
            ->where('status', '!=', 'cancelled')
            ->count();
        
        $booksSold = DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->whereBetween('orders.created_at', [$startDate, $endDate])
            ->where('orders.status', '!=', 'cancelled')
            ->sum('order_items.qty') ?? 0;
            
        $avgOrderValue = $totalOrders > 0 ? ($totalRevenue / $totalOrders) : 0;
        
        // Top Selling Books
        $topBooks = DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('books', 'order_items.book_id', '=', 'books.id')
            ->whereBetween('orders.created_at', [$startDate, $endDate])
            ->where('orders.status', '!=', 'cancelled')
            ->select(
                'books.id',
                'books.judul',
                'books.pengarang',
                DB::raw('SUM(order_items.qty) as total_sold'),
                DB::raw('SUM(order_items.subtotal) as revenue')
            )
            ->groupBy('books.id', 'books.judul', 'books.pengarang')
            ->orderBy('total_sold', 'desc')
            ->take(10)
            ->get();
        
        // Top Customers
        $topCustomers = DB::table('orders')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->whereBetween('orders.created_at', [$startDate, $endDate])
            ->where('orders.status', '!=', 'cancelled')
            ->select(
                'users.name',
                'users.email',
                DB::raw('COUNT(orders.id) as orders_count'),
                DB::raw('SUM(orders.total_harga) as total_spent')
            )
            ->groupBy('users.id', 'users.name', 'users.email')
            ->orderBy('total_spent', 'desc')
            ->take(10)
            ->get();

        $data = compact(
            'totalRevenue',
            'totalOrders',
            'booksSold',
            'avgOrderValue',
            'topBooks',
            'topCustomers',
            'startDate',
            'endDate'
        );

        $pdf = Pdf::loadView('admin.reports.pdf', $data);
        return $pdf->download('laporan-penjualan-' . now()->format('Y-m-d') . '.pdf');
    }
}
