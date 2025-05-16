<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;

class ServicesController extends Controller
{
    public function index()
    {
        try {
            $servicePosts = Post::with(['serviceDetail', 'images', 'category', 'subCategory'])
                ->whereHas('serviceDetail')
                ->whereHas('category', function($query) {
                    $query->where('name', 'Services');
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
                        'service_details' => $post->serviceDetail ? [
                            'service_type' => $post->serviceDetail->service_type,
                            'business_type' => $post->serviceDetail->business_type,
                            'business_name' => $post->serviceDetail->business_name,
                            'availability' => $post->serviceDetail->availability,
                            'experience_level' => $post->serviceDetail->experience_level,
                            'special_field' => $post->serviceDetail->special_field,
                            'special_type_field' => $post->serviceDetail->special_type_field,
                            'type_for_catering' => $post->serviceDetail->type_for_catering,
                            'type_for_carpool' => $post->serviceDetail->type_for_carpool,
                        ] : null,
                    ];
                });

            return response()->json($servicePosts);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
