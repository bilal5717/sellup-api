<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class vehicleDetails extends Model
{
    use HasFactory;
    protected $fillable = [
        'post_id', 'vehicle_type', 'make', 'model', 'year',
        'kms_driven', 'monthly_installment', 'transmission',
        'assembly', 'condition', 'registration_city', 'doc_type',
        'number_of_owners', 'fuel_type', 'registered', 'install_plan',
        'down_payment', 'features'
    ];
     protected $casts = [
        'features' => 'array'
    ];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
