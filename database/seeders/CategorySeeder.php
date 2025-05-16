<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Mobiles', 'slug' => 'mobiles', 'icon' => '📱'],
            ['name' => 'Vehicles', 'slug' => 'vehicles', 'icon' => '🚗'],
            ['name' => 'Property for Rent', 'slug' => 'property-for-rent', 'icon' => '🏠'],
            ['name' => 'Property for Sale', 'slug' => 'property-for-sale', 'icon' => '🏘️'],
            ['name' => 'Electronics & Home Appliances', 'slug' => 'electronics-home-appliances', 'icon' => '💻'],
            ['name' => 'Bikes', 'slug' => 'bikes', 'icon' => '🚲'],
            ['name' => 'Business, Industrial & Agriculture', 'slug' => 'business-industrial-agriculture', 'icon' => '🏭'],
            ['name' => 'Services', 'slug' => 'services', 'icon' => '🔧'],
            ['name' => 'Jobs', 'slug' => 'jobs', 'icon' => '💼'],
            ['name' => 'Animals', 'slug' => 'animals', 'icon' => '🐕'],
            ['name' => 'Books, Sports & Hobbies', 'slug' => 'books-sports-hobbies', 'icon' => '📚'],
            ['name' => 'Furniture & Home Decor', 'slug' => 'furniture-home-decor', 'icon' => '🛋️'],
            ['name' => 'Fashion & Beauty', 'slug' => 'fashion-beauty', 'icon' => '👗'],
            ['name' => 'Kids', 'slug' => 'kids', 'icon' => '👶'],
            ['name' => 'Others', 'slug' => 'others', 'icon' => '🗂️'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
