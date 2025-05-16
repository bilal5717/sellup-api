<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessIndustrialDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'post_id',
        'business_type',
        'special_field',
        'sub_category_type',
        'company_name',
        'seller_type',
        'condition',
        'operation_scale',
        'specifications'
    ];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
