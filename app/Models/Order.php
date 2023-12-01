<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';
    public $timestamps = false;
    protected $primaryKey = 'order_id';
    protected $keyType = 'string';
    protected $fillable = [
        'customer_id',
        'channel_id',
        'order_invoice',
        'order_lat',
        'order_long',
        'order_price',
        'order_status',
        'order_date',
        'order_payment_method',
        'payment_invoice',
        'payment_expired',
        'payment_url',
        'payment_message',
    ];

    public function tripay_channel(): BelongsTo
    {
        return $this->belongsTo(TripayChannel::class, 'channel_id');
    }
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
}
