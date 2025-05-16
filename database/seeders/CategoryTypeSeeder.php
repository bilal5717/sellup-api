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
                'Engines','Fenders','Filters','Front Grills','Fuel Pump','Gasket&seals','Horns',
                'Ignition Coil','Ignition Switchers','Insulation Sheets','Lights','Mirrors','Oxygen Sensors',
                'Power Stearings','Radiators&Coolants','Spark Plugs','Sun Visor','Suspension Parts','Trunk Parts',
                'Tyres','Windscreens','Wipers','Ac&Heating','Antennas','Batteries','Belt & Cables','Bonnets',
                'Brakes','Bumpers','Bushing','Buttons','Catalytic Converters','Door & Components','Engine Shields'
            ],

            // Oil & Lubricants
            'Oil & Lubricants' => [
                'Chain Lubes And Cleaners','Brake Oil','CUTE Oil','Engine Oil','Fuel Additives',
                'Gear Oil','Multipurpose Grease','Oil additives','Coolants'
            ],

            // Electronics Types
            'Electronics' => [
                'Desktops', 'Workstations', 'Gaming Pcs', 'Laptops', 'Computer & Laptop Accessories', 'Computer components', 'Servers', 'Softwares', 'Networking', 'Printers & photocopier', 'Inks & Toners',
                'Gaming console', 'Video Games', 'Controllers', 'Gaming Accessories', 'Other',
                'Digital Camera', 'CCTV Camera', 'Drones', 'Binowlars', 'Video Cameras', 'Camera lenses', 'Flash Guns', 'Bags & cases', 'Tripods & Stands', 'Camera Batteries', 'Professional Microphone', 'Video Lights', 'Gimbles & Stablizers', 'Other Cameras Accessories',
                'Radios', 'Microphone', 'Home Theater system', 'Amplifiers', 'Sound Bars', 'Speaker', 'Audio interface', 'Digital Recorders', 'Audio Mixer', 'Walkie Talkie', 'CD DVD Player', 'Turntable & Accessories', 'Cassette Player & Recorders', 'Mp3 Player', 'Car Audio Video', 'Other Video-audios',
                'Air Conditions', 'Air Coolers', 'AC & Cooler Accessories', 'Other',
                'Heaters', 'Geysers', 'Heating Rods', 'Other',
                'Ovens', 'Microwaves',
                'Generators', 'UPS', 'Solar Panels', 'Solar Inverters', 'Solar Accessories', 'Batteries', 'Other',
                'Refigerators', 'Freezers', 'Mini',
                'Irons', 'steamers',
                'Washer', 'Spin Dryer','Washer&Dryer',
                'juicers','Food Factory','Stover','Blenders','Air Fryers','Choppers','Grilss','Water pori frers','Mixers','Electric Kettles','Toasters','Cookers','Hot Plates','Coffee & TeaMachines','Hobs','Dinner Seats','Sandwich Makers','Vegetable slicers','Hoods','Meat Grinders','Dishwashers','Roti Maker','Sinks','Food Steamers','Other Kitchen appliances',
                'Other'
            ],

            // Bikes Types
            'Bikes' => [
                'Standard','Sports & Heavy Bikes', 'Cruiser' , 'Trail', 'Cafe Racers', 'Electric Bikes', 'Others',
                'Air filter','Carburelors','Bearing','Side Mirrors','Motorcycle Batteries','Switches','Lighting','Cylinders','Clutches','Pistons','Chain,cover & sprockets','Brakes','Handle Bavs & Grips','Levers','Seats','Exhausts','Fuel Tanks','Horns','Speedometers','Plugs','Stands','Tyres & Tubes','Other spareparts','Body & Frume','Slincer','Steering','Suspension','Transmission',
                'Bicycle,Air pumps','Oil,Lubricants','Bike Covers','Bike Gloves','Helmets','Tail Boxes','Bike jackets','Bike locks','Safe Guards Other Bike-accessories','Chargers sticker & emblems',
                'Road Bikes','Mountain Bikes','Hybrid Bikes','BMX Bike','Electric Bicycle','Folding bikes','Other Bicycle',
                'Petrol', 'Electric', 'Other'
            ],

            // Business Industrial Types
            'Business Industrial' => [
                'Mobile Shops', 'Water Plants', 'Beauty Salons', 'Grocery Store', 'Hotel & Resturant', 'Pharmacies','Snooker Clubs','Cosmetic & jewellery Shop','Gyms','Clinics','Franchises','Gift and Toy Shops','Petrol Pump','Auto parts shop','Other Bussiness',
                'Construction Material','Concrete Grinders','Drill Machines','Road Roller','Cranes','Construction Lifters','Pavers','Excavators','Concrete Cutters','Compactors','Water Pumps','Air Compressors','Domp Truck','Motor Granders','Other Heavy Equipment',
                'Ultrasound Machines','Surgical Masks','patient Beds','Wheelchairs','Oxygen Cylinders','Pulse Oximeters','Hearing aid','Blood pressure Monitors','Themometers','Walkers','Nebulizer','Breast Pump','Surgical instrument','Microscopes','Other Medical Supplies',
                'Woodworking Machines','Currency counting machine','Plastic & Rubber processing machine','Molding Machine','Packing Machine','Welding equipemnt','paper machine','Air compressors','Sealing Machine','Lathe Machines','Liquid Filling Machine','Marking Machine','Textile Machinery','Sewing Machine','Knithing Machine','Embroidery Machine','Printing Machine','Other bussiness & Industrial Machines',
                'Baking equipment','Food display counters','Ovens & Tandoor','Fryers','Tables & Platform','Fruit & Vegetable Machine','Chillers','Food Stall','Delivery Bags','Crockery & Cutlery','Ic-Cream Machines','Other resturant equipment',
                'Farm Machinery and equipment','Seads','Crops','Pesticides & Fertilizer','Plant & Tree','Other agriculture Silage'
            ],

            // Services
            'Services' => [
                'Maids', 'Babysitters', 'Cooks', 'Nursing Staff', 'Other Domestic Help',
                'Drivers', 'Pick & drop', 'CarPool',
                'Beauty &SPA', 'Fitness Trainer', 'Health Services',
                'Plumber', 'Electrician', 'Carpenters', 'Painters', 'AC services', 'Pest Control' ,'Water Tank Cleaning','Deep Cleaning','Geyser Services','Other Repair Services'
            ],

            // Animals
            'Animals' => [
                'Dogs', 'Cats', 'Rabbits', 'Hamsters',
                'Cows', 'Goats', 'Sheep', 'Horses',
                'Tropical Fish', 'Goldfish', 'Shrimp', 'Snails',
                'Parrots', 'Canaries', 'Pigeons',
                'Food&Accessories', 'Medicine', 'Others'
            ],

            // Kids
            'Kids' => [
                'Kids Bikes', 'Kids Cars', 'Kids Cycles', 'Kids Scooties', 'Others',
                'Prams & Walkers', 'Baby Bouncers', 'Baby Carriers', 'Baby Cots', 'Baby Swings','Baby Seats','Baby High Chairs','Other baby Gears',
                'Kids Costumes', 'Kids Cloths', 'Kids Shoes', 'Kids Uniform', 'Others'
            ],

            // Books and Sports
            'Books & Sports' => [
                'Books', 'Magazines', 'Dictionaries', 'Stationary Items','Calculators'
            ],

            // Fashion and Beauty
            'Fashion & Beauty' => [
                'Eastern', 'Western', 'Hijabs & Abayas', 'Sports Clothes', 'Kids Clothes','Others',
                'Caps', 'Scarves', 'Ties', 'Belts', 'Soacks','Gloves','Cufflinks','Sunglasses',
                'Brushes', 'Lips', 'Eyes', 'Face', 'Nails','Accessories','Others',
                'Hair Care','Skin Care',
                'Bridal', 'Grooms', 'Formal'
            ],
        ];

        foreach ($typesData as $parent => $childTypes) {
            foreach ($childTypes as $type) {
                CategoryType::create([
                    'name' => $type,
                    'parent' => $parent
                ]);
            }
        }
    }
}
