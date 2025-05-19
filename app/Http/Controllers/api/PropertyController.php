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
        $properties = Post::with(['propertyRentDetails', 'images'])
            ->whereHas('propertyRentDetails')
            ->whereHas('category', function($query) {
                $query->where('name', 'Property for Rent');
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
                            'url' => $image->path, // Directly return the stored URL from DB
                            'is_featured' => $image->is_featured,
                            'order' => $image->order,
                        ];
                    }),
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

public function propertySaleAllDetails()
{
    try {
        $properties = Post::with(['propertySaleDetails', 'images'])
            ->whereHas('propertySaleDetails')
            ->whereHas('category', function($query) {
                $query->where('name', 'Property for Sale');
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
                    'property_sale_details' => $post->propertySaleDetails ? [
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

        return response()->json($properties);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}


}
