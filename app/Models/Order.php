<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
        'armada_id',
        'order_invoice',
        'order_lat',
        'order_long',
        'order_price',
        'order_status_payment',
        'order_status_job',
        'order_date',
        'order_payment_method',
        'payment_invoice',
        'payment_expired',
        'payment_url',
        'payment_message',
        'order_proof_photo',
    ];

    public function tripay_channel(): BelongsTo
    {
        return $this->belongsTo(TripayChannel::class, 'channel_id');
    }
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function detailOrderSepithank(): HasMany {
        return $this->hasMany(DetailOrderSepithank::class, 'order_id');
    }

    public function armada(): BelongsTo {
        return $this->belongsTo(Armada::class, 'armada_id');
    }
}
