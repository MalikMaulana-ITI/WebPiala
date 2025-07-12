<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Invoice extends Model
{
    use HasFactory;

    protected $primaryKey = 'invoice_id';
    protected $fillable = [
        'order_id',
        'invoice_number',
        'amount',
        'payment_status',
        'midtrans_transaction_id',
        'midtrans_snap_token',
    ];

    /**
     * Get the order that owns the invoice.
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id', 'order_id');
    }
}