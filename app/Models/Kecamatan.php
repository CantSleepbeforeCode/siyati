<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kecamatan extends Model
{
    use HasFactory;

    protected $table = 'kecamatan';
    public $timestamps = false;
    protected $primaryKey = 'kecamatan_id';
    protected $keyType = 'string';
    protected $fillable = [
        'nama',
    ];
    public function kelurahan(): HasMany {
        return $this->hasMany(Kelurahan::class, 'kecamatan_id');
    }
    public function armada(): HasMany {
        return $this->hasMany(Armada::class, 'kecamatan_id');
    }
}
