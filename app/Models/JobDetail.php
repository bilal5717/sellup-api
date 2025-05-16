<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'post_id',
        'job_type',
        'hiring_type',
        'company_name',
        'salary_from',
        'salary_to',
        'career_level',
        'salary_period',
        'position_type'
    ];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
