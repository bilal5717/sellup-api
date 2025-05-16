<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
class AnimalsController extends Controller
{
   public function index()
    {
        try {
            $animalPosts = Post::with(['animalDetail', 'images', 'category', 'subCategory'])
                ->whereHas('animalDetail')
                ->whereHas('category', function($query) {
                    $query->where('name', 'Animals');
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
                        'animal_details' => $post->animalDetail ? [
                            'animal_type' => $post->animalDetail->animal_type,
                            'sub_animal_type' => $post->animalDetail->sub_animal_type,
                            'breed' => $post->animalDetail->breed,
                            'gender' => $post->animalDetail->gender,
                            'age' => $post->animalDetail->age,
                            'is_vaccinated' => $post->animalDetail->is_vaccinated ? 'Yes' : 'No',
                        ] : null,
                    ];
                });

            return response()->json($animalPosts);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
