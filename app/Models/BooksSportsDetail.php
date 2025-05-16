<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BooksSportsDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'post_id',
        'sub_type',
        'condition',
        'language',
        'author'
    ];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
