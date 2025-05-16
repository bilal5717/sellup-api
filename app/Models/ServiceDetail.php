<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'post_id',
        'service_type',
        'business_type',
        'business_name',
        'availability',
        'experience_level',
        'special_field',
        'special_type_field',
        'type_for_catering',
        'type_for_carpool'
    ];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
