<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TripayChannel extends Model
{
    use HasFactory;
    protected $table = 'tripay_channels';
    public $timestamps = false;
    protected $primaryKey = 'channel_id';
    protected $keyType = 'string';

    protected $fillable = [
        'channel_code',
        'channel_name',
        'channel_group',
        'channel_type',
        'fee_merchant_flat',
        'fee_merchant_percent',
        'fee_customer_flat',
        'fee_customer_percent',
        'total_fee_flat',
        'total_fee_percent',
        'minimum_fee',
        'maximum_fee',
        'channel_icon_url',
        'channel_active',
    ];

    public function order(): HasMany {
        return $this->hasMany(Order::class, 'channel_id');
    }
}
