<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Kelurahan extends Model
{
    use HasFactory;

    protected $table = 'kelurahan';
    public $timestamps = false;
    protected $primaryKey = 'kelurahan_id';
    protected $keyType = 'string';
    protected $fillable = [
        'kecamatan_id',
        'nama',
    ];

    public function kecamatan(): BelongsTo
    {
        return $this->belongsTo(Kecamatan::class, 'kecamatan_id');
    }
}
