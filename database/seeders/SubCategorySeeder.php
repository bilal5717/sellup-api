<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Support\Str;

class SubCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'mobiles' => ['Tablets', 'Accessories', 'Mobile Phones', 'Smart Watches'],
            'vehicles' => [
                'Cars', 'Cars On Installments', 'Car Care', 'Car Accessories',
                ['name' => 'Spare Parts', 'slug' => 'spare-parts-vehicle'],
                'Oil & Lubricant', 'Buses,Vans&Trucks', 'Rikshaw&Chingchi', 'Tractors&Trailers', 'Boats', 'Other Vehicles'
            ],
            'property-for-rent' => [
                ['name' => 'Houses', 'slug' => 'house_rent'], ['name' => 'Apartments & Flats', 'slug' => 'apartment_rent'],
                ['name' => 'Portions & Floors', 'slug' => 'portion_rent'], ['name' => 'Shops, Offices & Commercial Spaces', 'slug' => 'commercial_rent'],
                ['name' => 'Land & Plots', 'slug' => 'land_rent'], 'Roommates & Paying Guests', 'Rooms', 'Vacation Rentals & Guest Houses'
            ],
            'property-for-sale' => [
                ['name' => 'Houses', 'slug' => 'house_sale'], ['name' => 'Apartments & Flats', 'slug' => 'apartment_sale'],
                ['name' => 'Portions & Floors', 'slug' => 'portion_sale'], ['name' => 'Shops, Offices & Commercial Spaces', 'slug' => 'commercial_sale'],
                ['name' => 'Land & Plots', 'slug' => 'land_sale']
            ],
            'electronics-home-appliances' => [
                'Computer & Accessories', 'Games & Entertainment', 'Cameras & Accessories', 'Videos & Audios',
                'AC & Coolers', 'Fans', 'Heaters And Gysers', 'Washing Machines & dryers', 'Irons & Steamers', 'Sewing Machines',
                'Generators,UPS And Power Solutions', 'Refrigerator & Freezers', 'Air Purifier & Humidfier', 'water dispensers',
                'Microwave & Ovens', 'Kitchen Appliances', 'Other Electronics'
            ],
            'bikes' => [
                ['name' => 'MotorCycles', 'slug' => 'motorcycles'], ['name' => 'Spare Parts', 'slug' => 'spare-parts-bike'],
                ['name' => 'Bike Accessories', 'slug' => 'bike-accessories'], ['name' => 'Bicycle', 'slug' => 'bicycle'],
                ['name' => 'ATV & Quads', 'slug' => 'atv-quads'], ['name' => 'Scooters', 'slug' => 'scooters'],
                ['name' => 'Others', 'slug' => 'others-bikes']
            ],
            'business-industrial-agriculture' => [
                'Business For Sale', 'Food & Restaurant', 'Construction & Heavy Machinery', 'Agriculture',
                'Medical & Pharma', 'Trade & Industrial Machinery', 'Farming Supplies', 'Commercial Kitchen Equipment',
                'Packaging Machinery', 'Other Business & Industry'
            ],
            'services' => [
                ['name' => 'Architecture & Interior Design', 'slug' => 'architecture-service'], 'Camera Installation', 'Car Rental', 'Car Services',
                'Catering & Restaurent', 'Construction Services', 'Consolatancy Services', 'Domestic Help', 'Driver & Taxi',
                'Tution & academics', 'Electronic & Computer Repair', 'Event Services', 'Farm & Fresh Food', 'Health & Beauty',
                'Home & Office Repair', 'Insurances Services', 'Movers & Packers', 'Renting Services', 'Tailor Services',
                'Travel & Visa', 'Video & Photography', 'Web Developement', 'Other Services'
            ],
            'jobs' => [
                ['name' => 'Architecture & Interior Design', 'slug' => 'architecture-job'], 'Clerical & Administration', 'Content Writing',
                'Customer Service', 'Delivery Riders', 'Domestic Staff', 'Education', 'Engineering', 'Graphic Design',
                'Hotels & Tourism', 'Human Resources', 'Internships', 'IT & Networking', 'Manufacturing', 'Marketing',
                'Medical', 'Online', 'Part Time', 'Real Estate', 'Restaurents & Hospitals', 'Sales', 'Security'
            ],
            'animals' => ['Pets', 'Aquarium', 'Birds', 'Livestock', 'Animal Supplies', 'Others'],
            'books-sports-hobbies' => ['Sports Equipment', 'Musical Instruments', 'Gym & Fitness', 'Books & Magazines', 'Others'],
            'furniture-home-decor' => [
                'Sofa & Chair', 'Beds & Wardrobes', 'Tables & Dining', 'Bathroom & Accessories', 'Garden & Outdoor',
                'Painting & Mirror', 'Rugs & Carpets', 'Curtains & Blinds', 'Office Furniture', 'Home Decoration', 'Other Household items'
            ],
            'fashion-beauty' => [
                'Clothes', 'Fashion Accessories', 'Makeup', 'Skin & Hair', 'Wedding', 'Footwear', 'Bags',
                'Jewellery', 'Watches', 'Fragrance', 'Others'
            ],
            'kids' => [
                'Kids Furniture', 'Toys & Games', 'Bath & Diapers', 'Swings & Slides', 'Kids Accessories',
                'Kids Books', 'Kids Vehicle', 'Baby Gear', 'Kids Clothing', 'Others'
            ],
        ];

        foreach ($categories as $categorySlug => $subcategories) {
            $category = Category::where('slug', $categorySlug)->first();
            if ($category) {
                foreach ($subcategories as $sub) {
                    if (is_array($sub)) {
                        $name = $sub['name'];
                        $slug = $sub['slug'];
                    } else {
                        $name = $sub;
                        $slug = Str::slug($sub);
                    }

                    // Ensure slug is unique across all subcategories
                    $originalSlug = $slug;
                    $i = 1;
                    while (SubCategory::where('slug', $slug)->exists()) {
                        $slug = $originalSlug . '-' . $i;
                        $i++;
                    }

                    SubCategory::updateOrCreate(
                        ['name' => $name, 'category_id' => $category->id],
                        ['slug' => $slug]
                    );
                }
            }
        }
    }
}
