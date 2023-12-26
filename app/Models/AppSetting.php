<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppSetting extends Model
{
    use HasFactory;
    protected $table = 'app_setting';
    public $timestamps = false;
    protected $primaryKey = 'app_setting_id';
    protected $keyType = 'string';
    protected $fillable = [
        'admin_wa',
        'price_per_cubic'
    ];
}
