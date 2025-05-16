<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FurnitureDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'post_id',
        'furniture_type',
        'material',
        'dimensions',
        'color',
        'condition',
        'warranty',
        'folding',
        'age',
        'length',
        'width',
        'handmade',
        'origin'
    ];

   
    protected $casts = [
        'handmade' => 'boolean',
    ];
    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
