<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Review;

class BookController extends Controller
{
    public function show($id)
    {
        $book = Book::with(['category', 'reviews.user'])->findOrFail($id);
        
        // Calculate rating statistics
        $totalReviews = $book->reviews->count();
        $averageRating = $book->reviews->avg('rating') ?? 0;
        
        // Rating distribution
        $ratingDistribution = [
            5 => $book->reviews->where('rating', 5)->count(),
            4 => $book->reviews->where('rating', 4)->count(),
            3 => $book->reviews->where('rating', 3)->count(),
            2 => $book->reviews->where('rating', 2)->count(),
            1 => $book->reviews->where('rating', 1)->count(),
        ];
        
        // Check if user already reviewed
        $userReview = null;
        if (auth()->check()) {
            $userReview = $book->reviews()->where('user_id', auth()->id())->first();
        }
        
        // Related books from same category
        $relatedBooks = Book::where('category_id', $book->category_id)
            ->where('id', '!=', $book->id)
            ->where('stok', '>', 0)
            ->take(4)
            ->get();
        
        return view('user.books.show', compact(
            'book',
            'totalReviews',
            'averageRating',
            'ratingDistribution',
            'userReview',
            'relatedBooks'
        ));
    }
    
    public function storeReview(Request $request, $id)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'komentar' => 'required|string|max:1000',
        ]);
        
        $book = Book::findOrFail($id);
        
        // Check if user already reviewed
        $existingReview = Review::where('user_id', auth()->id())
            ->where('book_id', $book->id)
            ->first();
        
        if ($existingReview) {
            // Update existing review
            $existingReview->update([
                'rating' => $request->rating,
                'komentar' => $request->komentar,
            ]);
            
            return redirect()->back()->with('success', 'Review updated successfully!');
        } else {
            // Create new review
            Review::create([
                'user_id' => auth()->id(),
                'book_id' => $book->id,
                'rating' => $request->rating,
                'komentar' => $request->komentar,
            ]);
            
            return redirect()->back()->with('success', 'Review submitted successfully!');
        }
    }
}
