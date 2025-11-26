<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    protected $table = 'cart_items';
    
    protected $fillable = [
        'cart_id',
        'book_id',
        'qty',
    ];

    /**
     * Relasi ke cart
     */
    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    /**
     * Relasi ke book
     */
    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    /**
     * Get subtotal for this item
     */
    public function getSubtotal()
    {
        return $this->qty * $this->book->harga;
    }
}
