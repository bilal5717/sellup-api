<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;

class KidsController extends Controller
{
    public function index ()
    {
        try {
            $kidsPosts = Post::with(['kidsDetail', 'images', 'category', 'subCategory'])
                ->whereHas('kidsDetail')
                ->whereHas('category', function($query) {
                    $query->where('name', 'Kids');
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
                        'kids_details' => $post->kidsDetail ? [
                            'type' => $post->kidsDetail->type,
                            'condition' => $post->kidsDetail->condition,
                            'age' => $post->kidsDetail->age,
                            'gender' => $post->kidsDetail->gender,
                        ] : null,
                    ];
                });

            return response()->json($kidsPosts);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
