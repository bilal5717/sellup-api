<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StorePostRequest;
use App\Models\Post;
use App\Models\MobileDetail;
use App\Models\PropertySaleDetail;
use App\Models\PropertyRentDetails;
use App\Models\Category;
use App\Models\KidsDetail;
use App\Models\BooksSportsDetail;
use App\Models\ServiceDetail;
use App\Models\FurnitureDetail;
use App\Models\FashionBeautyDetail;
use App\Models\JobDetail;
use App\Models\vehicleDetails;
use App\Models\AnimalDetail;
use App\Models\BusinessIndustrialDetail;
use App\Models\SubCategory;
use App\Models\BikeDetail;
use App\Models\PostImage;
use App\Models\ElectronicsDetail;
use App\Models\PostVideo;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Mews\Purifier\Facades\Purifier;

class PostController extends Controller
{
    public function store(StorePostRequest $request)
    {
        DB::beginTransaction();

        try {
            $validated = $request->validated();
            $imageUrls = [];
            if ($request->has('imageUrls')) {
                $imageUrls = json_decode($request->input('imageUrls'), true);
            }
            $category = Category::firstOrCreate(
                ['name' => $validated['category']],
                [
                    'slug' => Str::slug($validated['category']),
                    'icon' => $this->getCategoryIcon($validated['category'])
                ]
            );

            $subCategory = SubCategory::firstOrCreate(
                ['name' => $validated['subCategory'], 'category_id' => $category->id],
                ['slug' => Str::slug($validated['subCategory'])]
            );

            $post = Post::create([
                'user_id' => auth()->id() ?? 1,
                'category_id' => $category->id,
                'sub_category_id' => $subCategory->id,
                'title' => Purifier::clean($validated['title']),
                'description' => Purifier::clean($validated['description']),
                'price' => $validated['price'],
                'location' => $validated['location'],
                'contact_name' => $validated['contactName'],
                'phone_number' => auth()->user()->phone_number ?? '848764568998',
                'status' => 'pending',
            ]);

            // Save attributes based on category
            switch (strtolower($validated['category'])) {
                case 'mobiles':
                    MobileDetail::create([
                        'post_id' => $post->id,
                        'brand' => $validated['brand'] ?? null,
                        'model' => $validated['model'] ?? null,
                        'condition' => $validated['condition'] ?? null,
                        'pta_status' => $validated['ptaStatus'] ?? null,
                        'storage' => $validated['storage'] ?? null,
                        'memory' => $validated['memory'] ?? null,
                        'battery_status' => isset($validated['batteryStatus']) ? $validated['batteryStatus'] . '%' : null,
                        'accessory_type' => $validated['accessoryType'] ?? null,
                        'charging_cable_type' => $validated['chargingCableType'] ?? null,
                        'device_type' => $validated['deviceType'] ?? null,
                        'charger_type' => $validated['chargerType'] ?? null,
                        'headphone_type' => $validated['headphoneType'] ?? null,
                    ]);
                    break;
                case 'vehicles':
    $vehicleData = [
        'post_id' => $post->id,
        'vehicle_type' => $validated['vehicleType'] ?? null,
        'make' => $validated['make'] ?? null,
        'model' => $validated['model'] ?? null,
        'year' => $validated['year'] ?? null,
        'fuel_type' => $validated['fuelType'] ?? null,
        'kms_driven' => $validated['kmsDriven'] ?? null,
        'transmission' => $validated['transmission'] ?? null,
        'assembly' => $validated['assembly'] ?? null,
        'condition' => $validated['condition'] ?? null,
        'registration_city' => $validated['registrationCity'] ?? null,
        'doc_type' => $validated['docType'] ?? null,
        'number_of_owners' => $validated['numberOfOwners'] ?? null,
        'price' => $validated['price'] ?? null,
        'location' => $validated['location'] ?? null,
        'features' => isset($validated['features']) ? json_encode($validated['features']) : null,
    ];
    vehicleDetails::create($vehicleData);
    break;

                case 'property for sale':
                    PropertySaleDetail::create([
                        'post_id' => $post->id,
                        'sub_type' => $validated['subType'] ?? null,
                        'furnish' => $validated['furnish'] ?? null,
                        'bedrooms' => $validated['bedrooms'] ?? null,
                        'bathrooms' => $validated['bathrooms'] ?? null,
                        'storeys' => $validated['storeys'] ?? null,
                        'floor_level' => $validated['floorlevel'] ?? null,
                        'area' => $validated['area'] ?? null,
                        'area_unit' => $validated['areaUnit'] ?? null,
                        'features' => isset($validated['features']) ? (is_string($validated['features']) ? json_decode($validated['features'], true) : $validated['features']) : null,
                        'other_feature' => $validated['otherFeature'] ?? null,
                    ]);                    
                    break;

                    case 'property for rent':
                        PropertyRentDetails::create([
                            'post_id' => $post->id,
                            'sub_type' => $validated['subType'] ?? null,
                            'furnish' => $validated['furnish'] ?? null,
                            'bedrooms' => $validated['bedrooms'] ?? null,
                            'bathrooms' => $validated['bathrooms'] ?? null,
                            'storeys' => $validated['storeys'] ?? null,
                            'floor_level' => $validated['floorlevel'] ?? null,
                            'area' => $validated['area'] ?? null,
                            'area_unit' => $validated['areaUnit'] ?? null,
                            'features' => isset($validated['features']) ? 
                                (is_string($validated['features']) ? 
                                    json_decode($validated['features'], true) : 
                                    $validated['features']) : null,
                            'other_feature' => $validated['otherFeature'] ?? null,
                            'rent_period' => $validated['pricePeriod'] ?? 'monthly',
                            'utilities_included' => $validated['utilitiesIncluded'] ?? false,
                        ]);
                        break;
                        case 'electronics & home appliances':
                            ElectronicsDetail::create([
                                'post_id' => $post->id,
                                'type' => $validated['type'] ?? null,
                                'brand' => $validated['brand'] ?? null,
                                'water_dispensers' => $validated['water_dispensers'] ?? null,
                                'no_taps' => $validated['no_taps'] ?? null,
                                'model' => $validated['model'] ?? null,
                                'sub_type' => $validated['sub_type'] ?? null,
                                'function_type' => $validated['functionType'] ?? null,
                                'doors' => $validated['doors'] ?? null,
                                'power' => $validated['power'] ?? null,
                                'heater_type' => $validated['heaterType'] ?? null,
                                'fuel_type' => $validated['fuelType'] ?? null,
                                'dryer_load' => $validated['dryerLoad'] ?? null,
                                'kilowatt' => $validated['kilowatt'] ?? null,
                                'wattage' => $validated['wattage'] ?? null,
                                'wattageups' => $validated['wattageups'] ?? null,
                                'sensor_size' => $validated['sensor_size'] ?? null,
                                'capacity' => $validated['capacity'] ?? null,
                                'condition' => $validated['condition'] ?? null,
                                'wifi' => $validated['wifi'] ?? null,
                                'warranty' => $validated['warranty'] ?? null,
                                'age' => $validated['age'] ?? null,
                            ]);
                            break;
                            case 'bikes':
                                BikeDetail::create([
                                    'post_id' => $post->id,
                                    'make' => $validated['make'] ?? null,
                                    'model' => $validated['model'] ?? null,
                                    'year' => $validated['year'] ?? null,
                                    'engine_type' => $validated['engineType'] ?? null,
                                    'engine_capacity' => $validated['engineCapacity'] ?? null,
                                    'kms_driven' => $validated['kmsDriven'] ?? null,
                                    'ignition_type' => $validated['ignitionType'] ?? null,
                                    'origin' => $validated['origin'] ?? null,
                                    'condition' => $validated['condition'] ?? null,
                                    'registration_city' => $validated['registrationCity'] ?? null,
                                    'kind' => $validated['kind'] ?? null,
                                ]);
                                break;
                                case 'business, industrial & agriculture':
                                    BusinessIndustrialDetail::create([
                                        'post_id' => $post->id,
                                        'business_type' => $validated['businessType'] ?? null,
                                        'special_field' => $validated['specialField'] ?? null,
                                        'sub_category_type' => $validated['subCategoryType'] ?? null,
                                        'company_name' => $validated['companyName'] ?? null,
                                        'seller_type' => $validated['sellerType'] ?? null,
                                        'condition' => $validated['condition'] ?? null,
                                        'operation_scale' => $validated['operationScale'] ?? null,
                                        'specifications' => $validated['specifications'] ?? null,
                                    ]);
                                    break;
                                    case 'services':
                                        ServiceDetail::create([
                                            'post_id' => $post->id,
                                            'service_type' => $validated['serviceType'] ?? null,
                                            'business_type' => $validated['businessType'] ?? 'individual',
                                            'business_name' => $validated['businessName'] ?? null,
                                            'availability' => $validated['availability'] ?? null,
                                            'experience_level' => $validated['experienceLevel'] ?? null,
                                            'special_field' => $validated['specialField'] ?? null,
                                            'special_type_field' => $validated['specialTypeField'] ?? null,
                                            'type_for_catering' => $validated['typeforCatering'] ?? null,
                                            'type_for_carpool' => $validated['typeforCarPool'] ?? null,
                                        ]);
                                        break;
                                        case 'jobs':
                                            JobDetail::create([
                                                'post_id' => $post->id,
                                                'job_type' => $validated['jobType'] ?? null,
                                                'hiring_type' => $validated['hiringType'] ?? 'company',
                                                'company_name' => $validated['companyName'] ?? null,
                                                'salary_from' => $validated['salaryFrom'] ?? null,
                                                'salary_to' => $validated['salaryTo'] ?? null,
                                                'career_level' => $validated['careerLevel'] ?? null,
                                                'salary_period' => $validated['salaryPeriod'] ?? null,
                                                'position_type' => $validated['positionType'] ?? null,
                                            ]);
                                            break;
                                            case 'animals':
                                                AnimalDetail::create([
                                                    'post_id' => $post->id,
                                                    'animal_type' => $validated['animalType'] ?? null,
                                                    'sub_animal_type' => $validated['subAnimalType'] ?? null,
                                                    'breed' => $validated['breed'] ?? null,
                                                    'gender' => $validated['gender'] ?? null,
                                                    'age' => $validated['age'] ?? null,
                                                    'is_vaccinated' => $validated['isVaccinated'] ?? false,
                                                ]);
                                                break;
                                                case 'books, sports & hobbies':
                                                    BooksSportsDetail::create([
                                                        'post_id' => $post->id,
                                                        'sub_type' => $validated['subType'] ?? null,
                                                        'condition' => $validated['condition'] ?? null,
                                                        'language' => $validated['language'] ?? null,
                                                        'author' => $validated['author'] ?? null,
                                                    ]);
                                                 break;
                                                 case 'furniture & home decor':
                                                    FurnitureDetail::create([
                                                        'post_id' => $post->id,
                                                        'furniture_type' => $validated['furnitureType'] ?? null,
                                                        'material' => $validated['material'] ?? null,
                                                        'dimensions' => $validated['dimensions'] ?? null,
                                                        'color' => $validated['color'] ?? null,
                                                        'condition' => $validated['condition'] ?? null,
                                                        'warranty' => $validated['warranty'] ?? null,
                                                        'folding' => $validated['folding'] ?? null,
                                                        'age' => $validated['age'] ?? null,
                                                        'length' => $validated['length'] ?? null,
                                                        'width' => $validated['width'] ?? null,
                                                        'handmade' => $validated['handmade'] === 'Yes' ? true : false, // Convert to boolean
                                                        'origin' => $validated['origin'] ?? null
                                                    ]);
                                                    break;
                                                    case 'fashion & beauty':
                                                        FashionBeautyDetail::create([
                                                            'post_id' => $post->id,
                                                            'type' => $validated['type'] ?? null,
                                                            'gender' => $validated['gender'] ?? null,
                                                            'fabric' => $validated['fabric'] ?? null,
                                                            'material' => $validated['material'] ?? null,
                                                            'Footcategory' => $validated['Footcategory'] ?? null,
                                                            'condition' => $validated['condition'] ?? null,
                                                            'age' => $validated['age'] ?? null,
                                                            'language' => $validated['language'] ?? null,
                                                        ]);
                                                        break;
                                                        case 'kids':
                                                            KidsDetail::create([
                                                                'post_id' => $post->id,
                                                                'type' => $validated['type'] ?? null,
                                                                'condition' => $validated['condition'] ?? null,
                                                                'age' => $validated['age'] ?? null,
                                                                'gender' => $validated['gender'] ?? null,
                                                            ]);
                                                            break;
            }

            if (!empty($imageUrls)) {
                foreach ($imageUrls as $imageUrl) {
                    PostImage::create([
                        'post_id' => $post->id,
                        'path' => $imageUrl,
                    ]);
                }
            }

            // Save video
// Save video URLs if provided
if ($request->has('videoUrls')) {
    $videoUrls = json_decode($request->input('videoUrls'), true);
    foreach ($videoUrls as $videoUrl) {
        PostVideo::create([
            'post_id' => $post->id,
            'path' => $videoUrl,
        ]);
    }
}



            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Post created successfully',
                'post_id' => $post->id,
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Error creating post: ' . $e->getMessage(),
            ], 500);
        }
    }

    private function getCategoryIcon($categoryName)
    {
        $icons = [
            'Mobiles' => '📱',
            'Vehicles' => '🚗',
            'Property for Rent' => '🏠',
            'Property for Sale' => '🏘️',
            'Electronics & Home Appliances' => '💻',
            'Bikes' => '🚲',
            'Business, Industrial & Agriculture' => '🏭',
            'Services' => '🔧',
            'Jobs' => '💼',
            'Animals' => '🐕',
            'Books, Sports & Hobbies' => '📚',
            'Furniture & Home Decor' => '🛋️',
            'Fashion & Beauty' => '👗',
            'Kids' => '👶',
            'Others' => '🗂️',
        ];

        return $icons[$categoryName] ?? '📦';
    }
}
