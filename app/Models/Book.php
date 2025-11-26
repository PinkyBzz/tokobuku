<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'category_id',
        'judul',
        'pengarang',
        'penerbit',
        'tahun_terbit',
        'sinopsis',
        'cover_photo',
        'harga',
        'stok',
        'isbn',
    ];

    /**
     * Relasi ke category
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Relasi ke reviews
     */
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Relasi ke cart
     */
    public function cart()
    {
        return $this->hasMany(Cart::class);
    }

    /**
     * Relasi ke order items
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Get average rating
     */
    public function averageRating()
    {
        return $this->reviews()->avg('rating') ?? 0;
    }

    /**
     * Cek stok tersedia
     */
    public function isAvailable()
    {
        return $this->stok > 0;
    }
}
