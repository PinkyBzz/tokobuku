<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Book::with('category');
        
        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('judul', 'LIKE', "%{$search}%")
                  ->orWhere('pengarang', 'LIKE', "%{$search}%")
                  ->orWhere('isbn', 'LIKE', "%{$search}%");
            });
        }
        
        // Category filter
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }
        
        $books = $query->latest()->paginate(12);
        $categories = Category::all();
            
        return view('admin.books.index', compact('books', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.books.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|max:255',
            'pengarang' => 'required|max:255',
            'penerbit' => 'required|max:255',
            'tahun_terbit' => 'required|integer|min:1900|max:' . date('Y'),
            'isbn' => 'nullable|unique:books,isbn',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'sinopsis' => 'required',
            'category_id' => 'required|exists:categories,id',
            'cover_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'cover_url' => 'nullable|url'
        ]);

        $coverPath = null;
        
        if ($request->hasFile('cover_photo')) {
            $coverPath = $request->file('cover_photo')->store('books', 'public');
        } elseif ($request->filled('cover_url')) {
            try {
                $url = $request->cover_url;
                $response = Http::get($url);
                
                if ($response->successful()) {
                    $contents = $response->body();
                    $name = 'books/' . uniqid() . '.jpg';
                    Storage::disk('public')->put($name, $contents);
                    $coverPath = $name;
                } else {
                    Log::error('Failed to download image from URL: ' . $url . ' Status: ' . $response->status());
                }
            } catch (\Exception $e) {
                Log::error('Exception downloading image: ' . $e->getMessage());
            }
        }

        Book::create([
            'judul' => $request->judul,
            'pengarang' => $request->pengarang,
            'penerbit' => $request->penerbit,
            'tahun_terbit' => $request->tahun_terbit,
            'isbn' => $request->isbn,
            'harga' => $request->harga,
            'stok' => $request->stok,
            'sinopsis' => $request->sinopsis,
            'category_id' => $request->category_id,
            'cover_photo' => $coverPath
        ]);

        return redirect()->route('admin.books.index')->with('success', 'Buku berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $book = Book::with('category')->findOrFail($id);
        return view('admin.books.show', compact('book'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $book = Book::findOrFail($id);
        $categories = Category::all();
        return view('admin.books.edit', compact('book', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $book = Book::findOrFail($id);
        
        $validated = $request->validate([
            'judul' => 'required|max:255',
            'pengarang' => 'required|max:255',
            'penerbit' => 'nullable|max:255',
            'tahun_terbit' => 'required|integer|min:1900|max:' . date('Y'),
            'isbn' => 'nullable|unique:books,isbn,' . $id,
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'sinopsis' => 'required',
            'category_id' => 'required|exists:categories,id',
            'cover_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'cover_url' => 'nullable|url'
        ]);

        // Update book data
        $book->judul = $request->judul;
        $book->pengarang = $request->pengarang;
        $book->penerbit = $request->penerbit;
        $book->tahun_terbit = $request->tahun_terbit;
        $book->isbn = $request->isbn;
        $book->harga = $request->harga;
        $book->stok = $request->stok;
        $book->sinopsis = $request->sinopsis;
        $book->category_id = $request->category_id;

        if ($request->hasFile('cover_photo')) {
            // Delete old image
            if ($book->cover_photo) {
                Storage::disk('public')->delete($book->cover_photo);
            }
            $book->cover_photo = $request->file('cover_photo')->store('books', 'public');
        } elseif ($request->filled('cover_url')) {
             try {
                $url = $request->cover_url;
                $response = Http::get($url);
                
                if ($response->successful()) {
                    // Delete old image
                    if ($book->cover_photo) {
                        Storage::disk('public')->delete($book->cover_photo);
                    }
                    
                    $contents = $response->body();
                    $name = 'books/' . uniqid() . '.jpg';
                    Storage::disk('public')->put($name, $contents);
                    $book->cover_photo = $name;
                } else {
                    Log::error('Failed to download image from URL: ' . $url . ' Status: ' . $response->status());
                }
            } catch (\Exception $e) {
                Log::error('Exception downloading image: ' . $e->getMessage());
            }
        }

        $book->save();

        return redirect()->route('admin.books.index')->with('success', 'Buku berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $book = Book::findOrFail($id);
        
        // Delete image file
        if ($book->gambar) {
            Storage::disk('public')->delete($book->gambar);
        }
        
        $book->delete();

        return redirect()->route('admin.books.index')->with('success', 'Buku berhasil dihapus!');
    }
}
