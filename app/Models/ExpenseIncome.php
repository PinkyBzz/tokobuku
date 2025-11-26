<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExpenseIncome extends Model
{
    protected $table = 'expenses_income';
    
    protected $fillable = [
        'tipe',
        'nominal',
        'keterangan',
        'tanggal',
        'order_id',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    /**
     * Relasi ke order
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
