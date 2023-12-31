<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Armada extends Model
{
    use HasFactory;
    protected $table = 'armadas';
    public $timestamps = false;
    protected $primaryKey = 'armada_id';
    protected $keyType = 'string';
    protected $fillable = [
        'user_id',
        'armada_driver',
        'armada_plat',
        'armada_id_gps',
        'armada_subdistinct',
        'armada_driver_photo',
        'armada_phone',
    ];
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function kecamatan(): BelongsTo
    {
        return $this->belongsTo(Kecamatan::class, 'armada_subdistinct');
    }

    public function order(): HasMany {
        return $this->hasMany(Order::class, 'armada_id');
    }
}
