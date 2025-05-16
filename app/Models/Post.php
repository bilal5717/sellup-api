<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'user_id', 'category_id', 'sub_category_id', 'title', 
        'description', 'price', 'location', 'contact_name', 'phone_number'
    ];
    public function mobileDetail() {
        return $this->hasOne(MobileDetail::class);
    }
    public function bikeDetail() {
        return $this->hasOne(BikeDetail::class);
    }
  public function fashionBeautyDetail()
{
    return $this->hasOne(FashionBeautyDetail::class, 'post_id');
}


    public function propertySaleDetails()
{
    return $this->hasOne(PropertySaleDetail::class, 'post_id');
}

    public function images() {
        return $this->hasMany(PostImage::class);
    }
    
    public function video() {
        return $this->hasMany(PostVideo::class); // Changed to hasMany for multiple videos
    }
    
    public function category() {
        return $this->belongsTo(Category::class);
    }
    
    public function subCategory() {
        return $this->belongsTo(SubCategory::class);
    }
    // Add to your Post model
public function propertyRentDetails()
{
    return $this->hasOne(PropertyRentDetails::class, 'post_id');
}
public function jobDetail()
{
    return $this->hasOne(JobDetail::class);
}
public function electronicsDetail()
{
    return $this->hasOne(ElectronicsDetail::class, 'post_id');
}
public function businessIndustrialDetail()
{
    return $this->hasOne(BusinessIndustrialDetail::class, 'post_id');
}

public function serviceDetail()
{
    return $this->hasOne(ServiceDetail::class, 'post_id');
}

public function animalDetail()
{
    return $this->hasOne(AnimalDetail::class, 'post_id');
}
public function booksSportsDetail()
{
    return $this->hasOne(BooksSportsDetail::class, 'post_id');
}
public function furnitureDetail()
{
    return $this->hasOne(FurnitureDetail::class, 'post_id');
}

}
