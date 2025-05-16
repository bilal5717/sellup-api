<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ElectronicsDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'post_id',
        'type',
        'brand',
        'model',
        'sub_type',
        'sensor_size',
        'wifi',
        'doors',
        'water_dispensers',
        'no_taps',
        'wattage',
        'kilowatt',
        'capacity',
        'condition',
        'power',
        'fuel_type',
        'dryer_load',
        'heater_type',
        'function_type',
    ];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
