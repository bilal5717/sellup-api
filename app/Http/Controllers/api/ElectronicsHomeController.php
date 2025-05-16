<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;

class ElectronicsHomeController extends Controller
{
    public function index()
{
    try {
        $electronicsProducts = Post::with(['electronicsDetail', 'images', 'category', 'subCategory'])
            ->whereHas('electronicsDetail')
            ->whereHas('category', function($query) {
                $query->where('name', 'Electronics & Home Appliances');
            })
            ->get()
            ->map(function ($post) {
                return [
                    'id' => $post->id,
                    'title' => strip_tags($post->title),
                    'price' => $post->price,
                    'location' => $post->location,
                    'condition' => $post->electronicsDetail ? $post->electronicsDetail->condition : null,
                    'posted_at' => $post->created_at->diffForHumans(),
                    'images' => $post->images->map(function ($image) {
                        return [
                            'url' => $image->path,
                            'is_featured' => $image->is_featured,
                            'order' => $image->order,
                        ];
                    }),
                    'electronics_detail' => $post->electronicsDetail ? [
                        'type' => $post->electronicsDetail->type,
                        'brand' => $post->electronicsDetail->brand,
                        'model' => $post->electronicsDetail->model,
                        'condition' => $post->electronicsDetail->condition,
                    ] : null,
                ];
            });

        return response()->json($electronicsProducts);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}

}
