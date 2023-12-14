<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nomenclature extends Model
{
    use HasFactory;

    protected $table = 'nomenclatures';
    public $timestamps = false;
    protected $primaryKey = 'nomenclature_id';
    protected $keyType = 'string';
    protected $fillable = [
        'nomenclature_name',
    ];
}
