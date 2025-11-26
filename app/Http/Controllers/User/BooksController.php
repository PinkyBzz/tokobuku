<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Category;

class BooksController extends Controller
{
    public function index(Request $request)
    {
        $query = Book::with('category')->where('stok', '>', 0);
        
        // Filter by category
        if ($request->has('category') && $request->category != '') {
            $query->where('category_id', $request->category);
        }
        
        // Search by title or author
        if ($request->has('search') && $request->search != '') {
            $query->where(function($q) use ($request) {
                $q->where('judul', 'like', '%' . $request->search . '%')
                  ->orWhere('pengarang', 'like', '%' . $request->search . '%');
            });
        }
        
        // Sort
        $sortBy = $request->get('sort', 'latest');
        switch ($sortBy) {
            case 'price_low':
                $query->orderBy('harga', 'asc');
                break;
            case 'price_high':
                $query->orderBy('harga', 'desc');
                break;
            case 'name':
                $query->orderBy('judul', 'asc');
                break;
            default:
                $query->latest();
        }
        
        $books = $query->paginate(12);
        $categories = Category::withCount('books')->get();
        $totalBooks = Book::where('stok', '>', 0)->count();
        
        return view('user.books.index', compact('books', 'categories', 'totalBooks'));
    }
}
