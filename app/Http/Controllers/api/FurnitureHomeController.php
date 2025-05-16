<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
class FurnitureHomeController extends Controller
{
    public function index()
    {
        try {
            $furniturePosts = Post::with(['furnitureDetail', 'images', 'category', 'subCategory'])
                ->whereHas('furnitureDetail')
                ->whereHas('category', function($query) {
                    $query->where('name', 'Furniture & Home Decor');
                })
                ->get()
                ->map(function ($post) {
                    return [
                        'id' => $post->id,
                        'title' => strip_tags($post->title),
                        'price' => $post->price,
                        'location' => $post->location,
                        'contact_name' => $post->contact_name,
                        'posted_at' => $post->created_at->diffForHumans(),
                        'images' => $post->images->map(function ($image) {
                            return [
                                'url' => $image->path,
                                'is_featured' => $image->is_featured,
                                'order' => $image->order,
                            ];
                        }),
                        'furniture_details' => $post->furnitureDetail ? [
                            'furniture_type' => $post->furnitureDetail->furniture_type,
                            'material' => $post->furnitureDetail->material,
                            'dimensions' => $post->furnitureDetail->dimensions,
                            'color' => $post->furnitureDetail->color,
                            'condition' => $post->furnitureDetail->condition,
                            'warranty' => $post->furnitureDetail->warranty,
                            'folding' => $post->furnitureDetail->folding,
                            'age' => $post->furnitureDetail->age,
                            'length' => $post->furnitureDetail->length,
                            'width' => $post->furnitureDetail->width,
                            'handmade' => $post->furnitureDetail->handmade ? 'Yes' : 'No',
                            'origin' => $post->furnitureDetail->origin,
                        ] : null,
                    ];
                });

            return response()->json($furniturePosts);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
