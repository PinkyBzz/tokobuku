<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'order_id',
        'status',
        'payment_proof',
        'method',
        'amount',
        'payment_date',
        'verified_at',
        'verified_by',
    ];

    protected $casts = [
        'payment_date' => 'datetime',
        'verified_at' => 'datetime',
    ];

    /**
     * Relasi ke order
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Relasi ke verifier
     */
    public function verifier()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }
}
