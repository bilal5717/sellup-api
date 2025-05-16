<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KidsDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'post_id',
        'type',
        'condition',
        'age',
        'gender',
    ];
    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
