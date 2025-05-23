<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CategoryType;
use Illuminate\Support\Str;

class CategoryTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $typesData = [

            // Accessory
            'Accessory' => [
                'Charging Cables', 'Converters', 'Chargers', 'Screens', 'Screen Protector',
                'Mobile Stands', 'Ring Lights', 'Selfie Sticks', 'Power Banks', 'Headphones',
                'EarPhones', 'Covers & Cases', 'External Memory', 'Other'
            ],

            // Car Care
            'Car Care' => [
                'Air Fresher', 'Cleaners', 'Compound Polishes', 'Covers', 'Microfiber Clothes',
                'Shampoos', 'Waxes', 'Other'
            ],

            // Car Accessory
            'Car Accessory' => [
                'Tools & Gadget', 'Safety & Security', 'Interior', 'Exterior', 'Audio & Multimedia', 'Other'
            ],

            // Spare Parts
            'Spare Parts' => [
                'Engines', 'Fenders', 'Filters', 'Front Grills', 'Fuel Pump', 'Gasket & Seals', 'Horns',
                'Ignition Coil', 'Ignition Switches', 'Insulation Sheets', 'Lights', 'Mirrors', 'Oxygen Sensors',
                'Power Steering', 'Radiators & Coolants', 'Spark Plugs', 'Sun Visor', 'Suspension Parts', 'Trunk Parts',
                'Tyres', 'Windscreens', 'Wipers', 'AC & Heating', 'Antennas', 'Batteries', 'Belts & Cables', 'Bonnets',
                'Brakes', 'Bumpers', 'Bushing', 'Buttons', 'Catalytic Converters', 'Door & Components', 'Engine Shields'
            ],

            // Oil & Lubricants
            'Oil & Lubricants' => [
                'Chain Lubes And Cleaners', 'Brake Oil', 'CUTE Oil', 'Engine Oil', 'Fuel Additives',
                'Gear Oil', 'Multipurpose Grease', 'Oil additives', 'Coolants'
            ],

            // Fashion and Beauty
            'Fashion & Beauty' => [
                'Eastern', 'Western', 'Hijabs & Abayas', 'Sports Clothes', 'Kids Clothes', 'Others',
                'Caps', 'Scarves', 'Ties', 'Belts', 'Socks', 'Gloves', 'Cufflinks', 'Sunglasses',
                'Brushes', 'Lips', 'Eyes', 'Face', 'Nails', 'Accessories', 'Others',
                'Hair Care', 'Skin Care', 'Bridal', 'Grooms', 'Formal'
            ],
        ];

        foreach ($typesData as $parent => $childTypes) {
            foreach ($childTypes as $type) {
                CategoryType::create([
                    'name' => $type,
                    'slug' => Str::slug($type),  // Generate slug
                    'parent' => $parent
                ]);
            }
        }
    }
}
