<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnimalDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'post_id',
        'animal_type',
        'sub_animal_type',
        'breed',
        'gender',
        'age',
        'is_vaccinated'
    ];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
