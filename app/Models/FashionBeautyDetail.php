<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FashionBeautyDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'post_id',
        'type',
        'gender',
        'fabric',
        'Footcategory',
        'material',
        'condition',
        'age',
        'language',
    ];
    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
