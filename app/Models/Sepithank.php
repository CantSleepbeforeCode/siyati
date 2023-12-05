<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Sepithank extends Model
{
    use HasFactory;
    protected $table = 'sepithanks';
    public $timestamps = false;
    protected $primaryKey = 'sepithank_id';
    protected $keyType = 'string';
    protected $fillable = [
        'customer_id',
        'sepithank_vol',
        'sepithank_unit',
    ];
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function detailOrderSepithank(): HasOne {
        return $this->hasOne(DetailOrderSepithank::class, 'sepithank_id');
    }
}
