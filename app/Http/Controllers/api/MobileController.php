<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\MobileDetail;

class MobileController extends Controller
{
    public function index()
    {
        $mobiles = Post::with(['mobileDetail', 'images'])
            ->whereHas('mobileDetail')
            ->get()
            ->map(function ($post) {
                return [
                    'id' => $post->id,
                    'title' => strip_tags($post->title),
                    'price' => $post->price,
                    'location' => $post->location,
                    'posted_at' => $post->created_at->diffForHumans(),
                    'pta_status' => $post->mobileDetail->pta_status ?? 'N/A',
                    'condition' => $post->mobileDetail->condition ?? 'New',
                    'brand' => $post->mobileDetail->brand ?? 'Unknown',
                    'model' => $post->mobileDetail->model ?? 'Unknown',
                    'images' => $post->images->map(function ($image) {
                        return [
                            'url' => $image->path, // Directly return the stored URL from DB
                            'is_featured' => $image->is_featured,
                            'order' => $image->order,
                        ];
                    }),
                ];
            });
    
        return response()->json($mobiles);
    }
    

    public function show($id)
    {
        $post = Post::with(['mobileDetail', 'images'])
            ->whereHas('mobileDetail')
            ->findOrFail($id);

        return response()->json([
            'id' => $post->id,
            'title' => $post->title,
            'price' => $post->price,
            'location' => $post->location,
            'posted_at' => $post->created_at->diffForHumans(),
            'pta_status' => $post->mobileDetail->pta_status,
            'condition' => $post->mobileDetail->condition,
            'brand' => $post->mobileDetail->brand,
            'model' => $post->mobileDetail->model,
            'images' => $post->images->map(function ($image) {
                return [
                    'url' => asset('storage/' . $image->path), 
                    'is_featured' => $image->is_featured,
                    'order' => $image->order,
                ];
            }),
            'description' => $post->description,
            'storage' => $post->mobileDetail->storage,
            'memory' => $post->mobileDetail->memory,
            'battery_status' => $post->mobileDetail->battery_status,
            'accessories' => [
                'charging_cable_type' => $post->mobileDetail->charging_cable_type,
                'charger_type' => $post->mobileDetail->charger_type,
                'headphone_type' => $post->mobileDetail->headphone_type,
            ],
        ]);
    }

    public function showMobileDetails($id)
    {
        try {
            $post = Post::with(['mobileDetail', 'images', 'video'])
                ->where('id', $id)
                ->whereHas('mobileDetail') // Ensures only posts with mobile details are fetched
                ->firstOrFail();
    
            return response()->json([
                'id' => $post->id,
                'title' => $post->title,
                'description' => $post->description,
                'price' => $post->price,
                'location' => $post->location,
                'posted_at' => $post->created_at->diffForHumans(),
                'created_at' => $post->created_at,
                'mobile_details' => [
                    'pta_status' => $post->mobileDetail->pta_status ?? 'N/A',
                    'condition' => $post->mobileDetail->condition ?? 'New',
                    'brand' => $post->mobileDetail->brand ?? 'Unknown',
                    'model' => $post->mobileDetail->model ?? 'Unknown',
                    'storage' => $post->mobileDetail->storage ?? 'N/A',
                    'memory' => $post->mobileDetail->memory ?? 'N/A',
                    'battery_status' => $post->mobileDetail->battery_status ?? 'N/A',
                    'accessory_type' => $post->mobileDetail->accessory_type ?? 'N/A',
                    'charging_cable_type' => $post->mobileDetail->charging_cable_type ?? 'N/A',
                    'device_type' => $post->mobileDetail->device_type ?? 'N/A',
                    'charger_type' => $post->mobileDetail->charger_type ?? 'N/A',
                    'headphone_type' => $post->mobileDetail->headphone_type ?? 'N/A',
                ],
                'images' => $post->images->map(function ($image) {
                    return [
                        'url' => $image->path,
                        'is_featured' => $image->is_featured,
                        'order' => $image->order,
                    ];
                }),
                'videos' => $post->video->map(function ($video) {
                    return [
                        'url' => $video->path,
                        'is_featured' => $video->is_featured,
                        'order' => $video->order,
                    ];
                }),
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Mobile post not found'], 404);
        }
    }
    
  public function showAllProducts()
{
    try {
        $mobileProducts = MobileDetail::with('post')->get();
        return response()->json($mobileProducts);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}

}
