<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\BikeDetail;

class BikeController extends Controller
{
 public function index(Request $request)
{
    try {
        $slug = $request->query('slug');
        $type = $request->query('type');
        $sub_category = $request->query('sub_category');
        $sort = $request->query('sort', 'newest');
        $condition = $request->query('condition');
        $min_price = $request->query('min_price');
        $max_price = $request->query('max_price');

        $posts = Post::with(['bikeDetail', 'images', 'subCategory', 'category'])
            ->whereHas('bikeDetail')
            ->whereHas('category', function ($q) {
                $q->where('name', 'Bikes');
            });

        // Check slug against subcategory or kind in bikeDetail
        if ($slug) {
            $posts->where(function ($query) use ($slug) {
                $query->whereHas('subCategory', function ($q) use ($slug) {
                    $q->where('slug', $slug);
                })->orWhereHas('bikeDetail', function ($q) use ($slug) {
                    // Convert slug to match kind format (e.g., "road-bikes" to "Road Bikes")
                    $kindValue = ucwords(str_replace('-', ' ', $slug));
                    $q->where('kind', $kindValue);
                });
            });
        }

        if ($type) {
            $posts->whereHas('bikeDetail', function ($q) use ($type) {
                $q->where('kind', $type);
            });
        }

        if ($sub_category) {
            $posts->whereHas('subCategory', function ($q) use ($sub_category) {
                $q->where('slug', $sub_category);
            });
        }

        if ($condition && $condition !== 'all') {
            $posts->whereHas('bikeDetail', function ($q) use ($condition) {
                $q->where('condition', $condition);
            });
        }

        if ($min_price) {
            $posts->where('price', '>=', $min_price);
        }

        if ($max_price) {
            $posts->where('price', '<=', $max_price);
        }

        switch ($sort) {
            case 'price-low':
                $posts->orderBy('price', 'asc');
                break;
            case 'price-high':
                $posts->orderBy('price', 'desc');
                break;
            case 'popular':
                $posts->orderBy('views', 'desc');
                break;
            default:
                $posts->latest();
                break;
        }

        $bikePosts = $posts->get()->map(function ($post) {
            return [
                'id' => $post->id,
                'post_id' => $post->id,
                'title' => strip_tags($post->title),
                'price' => $post->price,
                'location' => $post->location,
                'posted_at' => $post->created_at->diffForHumans(),
                'brand' => $post->bikeDetail->make,
                'model' => $post->bikeDetail->model,
                'year' => $post->bikeDetail->year,
                'images' => $post->images->map(function ($image) {
                    return [
                        'url' => $image->path,
                        'is_featured' => $image->is_featured,
                        'order' => $image->order,
                    ];
                })->toArray(),
                'engine_capacity' => $post->bikeDetail->engine_capacity,
                'kms_driven' => $post->bikeDetail->kms_driven,
                'condition' => $post->bikeDetail->condition,
                'type' => $post->bikeDetail->kind, // Changed from type to kind
                'category' => $post->category->name ?? null,
                'sub_category' => $post->subCategory->name ?? null,
            ];
        });

        return response()->json($bikePosts);

    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
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