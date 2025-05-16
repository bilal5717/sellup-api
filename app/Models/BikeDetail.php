<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BikeDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'post_id',
        'make',
        'model',
        'year',
        'engine_type',
        'engine_capacity',
        'kms_driven',
        'ignition_type',
        'origin',
        'condition',
        'registration_city',
        'kind',
    ];
    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
