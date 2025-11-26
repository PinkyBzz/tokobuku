<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $table = 'carts';
    
    protected $fillable = [
        'user_id',
    ];

    /**
     * Relasi ke user
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke cart items
     */
    public function items()
    {
        return $this->hasMany(CartItem::class, 'cart_id');
    }

    /**
     * Get total cart amount
     */
    public function getTotal()
    {
        return $this->items->sum(function($item) {
            return $item->qty * $item->book->harga;
        });
    }
}
