<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\PropertySaleDetail;
use App\Models\PropertyRentDetails;
class PropertyController extends Controller
{
 public function index()
{
    try {
        $properties = Post::with(['propertySaleDetail', 'images', 'category', 'subCategory'])
            ->whereHas('propertySaleDetail')  // Corrected method name
            ->whereHas('category', function($query) {
                $query->where('name', 'Property for Sale');
            })
            ->whereHas('subCategory', function($query) {
                $query->where('name', 'Houses');
            })
            ->get()
            ->map(function ($post) {
                return [
                    'id' => $post->id,
                    'title' => strip_tags($post->title),
                    'price' => $post->price,
                    'location' => $post->location,
                    'posted_at' => $post->created_at->diffForHumans(),
                    'images' => $post->images->map(function ($image) {
                        return [
                            'url' => $image->path,
                            'is_featured' => $image->is_featured,
                            'order' => $image->order,
                        ];
                    }),
                    'property_sale_detail' => optional($post->propertySaleDetail)->exists() ? [
                        'bedrooms' => optional($post->propertySaleDetail)->bedrooms,
                        'bathrooms' => optional($post->propertySaleDetail)->bathrooms,
                        'area' => optional($post->propertySaleDetail)->area,
                        'area_unit' => optional($post->propertySaleDetail)->area_unit,
                        'features' => optional($post->propertySaleDetail)->features,
                    ] : null
                ];
            });

        return response()->json($properties);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}



   public function showLandsDetails()
{
    try {
        $lands = Post::with(['propertySaleDetail', 'images', 'category', 'subCategory'])
            ->whereHas('propertySaleDetail')
            ->whereHas('category', function($query) {
                $query->where('name', 'Property for Sale');
            })
            ->whereHas('subCategory', function($query) {
                $query->where('name', 'Land & Plots');
            })
            ->get()
            ->map(function ($post) {
                return [
                    'id' => $post->id,
                    'title' => strip_tags($post->title),
                    'price' => $post->price,
                    'location' => $post->location,
                    'posted_at' => $post->created_at->diffForHumans(),
                     'images' => $post->images->map(function ($image) {
                        return [
                            'url' => $image->path,
                            'is_featured' => $image->is_featured,
                            'order' => $image->order,
                        ];
                    }),
                    'property_sale_detail' => [
                        'area' => optional($post->propertySaleDetail)->area,
                        'area_unit' => optional($post->propertySaleDetail)->area_unit,
                        'land_type' => optional($post->propertySaleDetail)->sub_type,
                    ]
                ];
            });

        return response()->json($lands);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}


 public function propertyRentAllDetails()
{
    try {
        $query = Post::with(['propertyRentDetails', 'images', 'subCategory'])
            ->whereHas('propertyRentDetails')
            ->whereHas('category', function($query) {
                $query->where('slug', 'property-for-rent');
            });

        // Filter by subCategory slug if provided
        if (request()->has('subCategory') && request()->input('subCategory')) {
            $query->whereHas('subCategory', function($query) {
                $query->where('slug', request()->input('subCategory'));
            });
        }

        // Filter by price range
        if (request()->has('minPrice') && request()->input('minPrice')) {
            $query->where('price', '>=', request()->input('minPrice'));
        }
        if (request()->has('maxPrice') && request()->input('maxPrice')) {
            $query->where('price', '<=', request()->input('maxPrice'));
        }

        // Filter by city
        if (request()->has('city') && request()->input('city')) {
            $query->where('location', 'like', '%' . request()->input('city') . '%');
        }

        $properties = $query->get()->map(function ($post) {
            return [
                'id' => $post->id,
                'title' => strip_tags($post->title),
                'price' => $post->price,
                'location' => $post->location,
                'posted_at' => $post->created_at->diffForHumans(),
                'images' => $post->images->map(function ($image) {
                    return [
                        'url' => $image->path,
                        'is_featured' => $image->is_featured,
                        'order' => $image->order,
                    ];
                })->toArray(),
                'property_rent_details' => [
                    'sub_type' => $post->propertyRentDetails->sub_type,
                    'furnish' => $post->propertyRentDetails->furnish,
                    'bedrooms' => $post->propertyRentDetails->bedrooms,
                    'bathrooms' => $post->propertyRentDetails->bathrooms,
                    'storeys' => $post->propertyRentDetails->storeys,
                    'floor_level' => $post->propertyRentDetails->floor_level,
                    'area' => $post->propertyRentDetails->area,
                    'area_unit' => $post->propertyRentDetails->area_unit,
                    'features' => $post->propertyRentDetails->features,
                    'other_feature' => $post->propertyRentDetails->other_feature,
                    'rent_period' => $post->propertyRentDetails->rent_period,
                    'utilities_included' => $post->propertyRentDetails->utilities_included,
                ]
            ];
        });

        return response()->json($properties);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}

public function propertySaleAllDetails($slug = null)
{
    try {
        $query = Post::with(['propertySaleDetail', 'images', 'subCategory'])
            ->whereHas('propertySaleDetail')
            ->whereHas('category', function($query) {
                $query->where('slug', 'property-for-sale');
            });

        // Filter by subCategory slug if provided
        if ($slug) {
            $query->whereHas('subCategory', function($query) use ($slug) {
                $query->where('slug', $slug);
            });
        }

        // Filter by price range if provided
        if (request()->has('min_price') && request()->input('min_price')) {
            $query->where('price', '>=', request()->input('min_price'));
        }
        if (request()->has('max_price') && request()->input('max_price')) {
            $query->where('price', '<=', request()->input('max_price'));
        }

        // Filter by location if provided
        if (request()->has('location') && request()->input('location')) {
            $query->where('location', 'like', '%' . request()->input('location') . '%');
        }

        // Pagination
        $perPage = request()->input('per_page', 12);
        $properties = $query->paginate($perPage);

        $formattedProperties = $properties->getCollection()->map(function ($post) {
            return [
                'id' => $post->id,
                'post_id' => $post->id,
                'title' => strip_tags($post->title),
                'price' => $post->price,
                'location' => $post->location,
                'posted_at' => $post->created_at->diffForHumans(),
                'images' => $post->images->map(function ($image) {
                    return [
                        'url' => $image->path,
                        'is_featured' => $image->is_featured,
                        'order' => $image->order,
                    ];
                }),
                'property_sale_detail' => $post->propertySaleDetails ? [
                    'sub_type' => $post->propertySaleDetails->sub_type,
                    'furnish' => $post->propertySaleDetails->furnish,
                    'bedrooms' => $post->propertySaleDetails->bedrooms,
                    'bathrooms' => $post->propertySaleDetails->bathrooms,
                    'storeys' => $post->propertySaleDetails->storeys,
                    'floor_level' => $post->propertySaleDetails->floor_level,
                    'area' => $post->propertySaleDetails->area,
                    'area_unit' => $post->propertySaleDetails->area_unit,
                    'features' => $post->propertySaleDetails->features,
                    'other_feature' => $post->propertySaleDetails->other_feature,
                ] : null
            ];
        });

        return response()->json([
            'data' => $formattedProperties,
            'pagination' => [
                'current_page' => $properties->currentPage(),
                'last_page' => $properties->lastPage(),
                'per_page' => $properties->perPage(),
                'total' => $properties->total(),
            ]
        ]);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}


}
