<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PriceReference extends Model
{
    use HasFactory;
    protected $table = 'price_references';
    public $timestamps = false;
    protected $primaryKey = 'price_reference_id';
    protected $keyType = 'string';
    protected $fillable = [
        'type',
        'minimum_size',
        'maximum_size',
        'price',
    ];
}
