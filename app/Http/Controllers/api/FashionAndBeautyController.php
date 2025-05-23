<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;

class FashionAndBeautyController extends Controller
{
    public function index(Request $request)
    {
        try {
            $query = Post::with(['fashionBeautyDetail', 'images', 'category', 'subCategory'])
                ->whereHas('fashionBeautyDetail')
                ->whereHas('category', function($query) {
                    $query->where('name', 'Fashion & Beauty');
                });

            // Apply subcategory filter if provided
            if ($request->has('subcategory')) {
                $query->whereHas('subCategory', function($q) use ($request) {
                    $q->where('slug', $request->subcategory);
                });
            }

            // Apply type filter if provided
            if ($request->has('type')) {
                $query->whereHas('fashionBeautyDetail', function($q) use ($request) {
                    $q->where('type', $request->type);
                });
            }

            $fashionBeautyPosts = $query->get()
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
                        'fashion_beauty_details' => $post->fashionBeautyDetail ? [
                            'type' => $post->fashionBeautyDetail->type,
                            'gender' => $post->fashionBeautyDetail->gender,
                            'fabric' => $post->fashionBeautyDetail->fabric,
                            'material' => $post->fashionBeautyDetail->material,
                            'footcategory' => $post->fashionBeautyDetail->Footcategory,
                            'condition' => $post->fashionBeautyDetail->condition,
                            'age' => $post->fashionBeautyDetail->age,
                            'language' => $post->fashionBeautyDetail->language,
                        ] : null,
                        'sub_category' => $post->subCategory ? [
                            'name' => $post->subCategory->name,
                            'slug' => $post->subCategory->slug,
                        ] : null,
                    ];
                });

            return response()->json($fashionBeautyPosts);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}