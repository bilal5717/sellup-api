<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertySaleDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'post_id',
        'sub_type',
        'furnish',
        'bedrooms',
        'bathrooms',
        'storeys',
        'floor_level',
        'area',
        'area_unit',
        'features',
        'other_feature',
    ];
    protected $casts = [
        'features' => 'array', // Auto cast features JSON into array
    ];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
