<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'book_id',
        'qty',
        'harga_satuan',
        'subtotal',
    ];

    /**
     * Relasi ke order
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Relasi ke book
     */
    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}
