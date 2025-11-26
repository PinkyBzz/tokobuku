<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
            'penulis' => 'required|max:255',
            'penerbit' => 'required|max:255',
            'tahun_terbit' => 'required|integer|min:1900|max:' . date('Y'),
            'isbn' => 'required|unique:books,isbn',
            'jumlah_halaman' => 'required|integer|min:1',
            'berat' => 'required|numeric|min:0.1',
            'lebar' => 'required|numeric|min:0.1',
            'panjang' => 'required|numeric|min:0.1',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'deskripsi' => 'required',
            'category_id' => 'required|exists:categories,id',
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $gambarPath = null;
        if ($request->hasFile('gambar')) {
            $gambarPath = $request->file('gambar')->store('books', 'public');
        }

        Book::create([
            'judul' => $request->judul,
            'penulis' => $request->penulis,
            'penerbit' => $request->penerbit,
            'tahun_terbit' => $request->tahun_terbit,
            'isbn' => $request->isbn,
            'jumlah_halaman' => $request->jumlah_halaman,
            'berat' => $request->berat,
            'lebar' => $request->lebar,
            'panjang' => $request->panjang,
            'harga' => $request->harga,
            'stok' => $request->stok,
            'deskripsi' => $request->deskripsi,
            'category_id' => $request->category_id,
            'gambar' => $gambarPath
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
            'cover_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
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
