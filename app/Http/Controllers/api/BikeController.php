<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\BikeDetail;

class BikeController extends Controller
{
   public function index()
{
    $bikes = Post::with(['bikeDetail', 'images'])
        ->whereHas('bikeDetail')
        ->get()
        ->map(function ($post) {
            return [
                'id' => $post->id,
                'title' => strip_tags($post->title),
                'price' => $post->price,
                'location' => $post->location,
                'posted_at' => $post->created_at->diffForHumans(),
                'make' => $post->bikeDetail->make,
                'model' => $post->bikeDetail->model,
                'year' => $post->bikeDetail->year,
                'images' => $post->images->map(function ($image) {
                    return [
                        'url' => $image->path, 
                        'is_featured' => $image->is_featured,
                        'order' => $image->order,
                    ];
                })->toArray(), // Ensure it is an array
                'engine_capacity' => $post->bikeDetail->engine_capacity,
                'kms_driven' => $post->bikeDetail->kms_driven,
                'condition' => $post->bikeDetail->condition,
            ];
        });

    return response()->json($bikes);
}


    public function show($id)
{
    $post = Post::with(['bikeDetail', 'images', 'videos'])
        ->whereHas('bikeDetail')
        ->findOrFail($id);

    return response()->json([
        'id' => $post->id,
        'title' => $post->title,
        'price' => $post->price,
        'location' => $post->location,
        'posted_at' => $post->created_at->diffForHumans(),
        'description' => $post->description,
        'make' => $post->bikeDetail->make,
        'model' => $post->bikeDetail->model,
        'year' => $post->bikeDetail->year,
        'engine_type' => $post->bikeDetail->engine_type,
        'engine_capacity' => $post->bikeDetail->engine_capacity,
        'kms_driven' => $post->bikeDetail->kms_driven,
        'ignition_type' => $post->bikeDetail->ignition_type,
        'origin' => $post->bikeDetail->origin,
        'condition' => $post->bikeDetail->condition,
        'registration_city' => $post->bikeDetail->registration_city,
        'kind' => $post->bikeDetail->kind,
        'specifications' => [
            'engine_type' => $post->bikeDetail->engine_type,
            'ignition_type' => $post->bikeDetail->ignition_type,
            'origin' => $post->bikeDetail->origin,
        ],
        'features' => [
            'registration_city' => $post->bikeDetail->registration_city,
            'kind' => $post->bikeDetail->kind,
        ],
        'images' => $post->images->map(function ($image) {
            return [
                'url' => asset('storage/' . $image->path),
                'is_featured' => $image->is_featured,
                'order' => $image->order,
            ];
        }),
        'videos' => $post->videos->map(function ($video) {
            return [
                'url' => asset('storage/' . $video->path),
                'thumbnail' => asset('storage/' . $video->thumbnail_path),
                'duration' => $video->duration,
            ];
        }),
    ]);
}

}