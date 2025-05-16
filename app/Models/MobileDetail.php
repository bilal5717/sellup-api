<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MobileDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'post_id',
        'brand',
        'model',
        'condition',
        'pta_status',
        'storage',
        'memory',
        'battery_status',
        'accessory_type',
        'charging_cable_type',
        'device_type',
        'charger_type',
        'headphone_type',
    ];
    public function post() {
        return $this->belongsTo(Post::class);
    }
}
