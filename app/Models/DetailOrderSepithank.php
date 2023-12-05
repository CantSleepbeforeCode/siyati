<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetailOrderSepithank extends Model
{
    use HasFactory;
    protected $table = 'detail_order_sepithanks';
    public $timestamps = false;
    protected $primaryKey = 'detail_order_sepithank_id';
    protected $keyType = 'string';
    protected $fillable = [
        'order_id',
        'sepithank_id',
        'price',
    ];
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
    public function sepithank(): BelongsTo
    {
        return $this->belongsTo(Sepithank::class, 'sepithank_id');
    }
}
