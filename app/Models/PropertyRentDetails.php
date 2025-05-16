<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyRentDetails extends Model
{
    use HasFactory;
    protected $table = 'property_rent_details';
    protected $fillable = [
        'post_id', 'sub_type', 'furnish', 'bedrooms', 'bathrooms', 
        'storeys', 'floor_level', 'area', 'area_unit', 'features', 
        'other_feature', 'rent_period', 'utilities_included'
    ];
    protected $casts = [
        'features' => 'array',
        'utilities_included' => 'boolean'
    ];
    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
