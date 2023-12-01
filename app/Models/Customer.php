<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Customer extends Model
{
    use HasFactory;
    protected $table = 'customers';
    public $timestamps = false;
    protected $primaryKey = 'customer_id';
    protected $keyType = 'string';
    protected $fillable = [
        'user_id',
        'customer_name',
        'customer_phone',
        'customer_subdistrict',
        'customer_urban_village',
        'customer_address',
        'customer_vol',
        'customer_unit',
        'customer_nomenklatur',
        'customer_photo',
        'customer_lat',
        'customer_long',
    ];

    // public function user(): BelongsTo
    // {
    //     return $this->belongsTo(User::class, 'user_id');
    // }

    // public function cart(): HasOne {
    //     return $this->hasOne(Cart::class, 'customer_id');
    // }
    public function order(): HasMany {
        return $this->hasMany(Order::class, 'customer_id');
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
