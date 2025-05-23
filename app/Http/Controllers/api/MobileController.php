<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\MobileDetail;
use Illuminate\Support\Str;
class MobileController extends Controller
{
    public function index(Request $request)
{
    $query = Post::with(['mobileDetail', 'images', 'category', 'subCategory'])
        ->whereHas('mobileDetail');

    // Apply filters
    if ($request->has('category')) {
        $query->whereHas('category', function($q) use ($request) {
            $q->where('name', $request->category);
        });
    }

    if ($request->has('sub_category')) {
        $query->whereHas('subCategory', function($q) use ($request) {
            $q->where('name', $request->sub_category);
        });
    }

    if ($request->has('condition')) {
        $query->whereHas('mobileDetail', function($q) use ($request) {
            $q->where('condition', $request->condition);
        });
    }

    if ($request->has('min_price')) {
        $query->where('price', '>=', $request->min_price);
    }

    if ($request->has('max_price')) {
        $query->where('price', '<=', $request->max_price);
    }

    $mobiles = $query->get()->map(function ($post) {
        return [
            'id' => $post->id,
            'title' => strip_tags($post->title),
            'price' => $post->price,
            'location' => $post->location,
            'posted_at' => $post->created_at->diffForHumans(),
            'category' => $post->category->name ?? 'Unknown',
            'sub_category' => $post->subCategory->name ?? 'Unknown',
            'pta_status' => $post->mobileDetail->pta_status ?? 'N/A',
            'condition' => $post->mobileDetail->condition ?? 'New',
            'brand' => $post->mobileDetail->brand ?? 'Unknown',
            'model' => $post->mobileDetail->model ?? 'Unknown',
            'images' => $post->images->map(function ($image) {
                            return [
                                'url' => $image->path,
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
        $post = Post::with(['mobileDetail', 'images', 'category', 'subCategory'])
            ->whereHas('mobileDetail')
            ->findOrFail($id);

        return response()->json([
            'id' => $post->id,
            'title' => $post->title,
            'price' => $post->price,
            'location' => $post->location,
            'posted_at' => $post->created_at->diffForHumans(),
            'category' => $post->category->name ?? 'Unknown',
            'sub_category' => $post->subCategory->name ?? 'Unknown',
            'pta_status' => $post->mobileDetail->pta_status,
            'condition' => $post->mobileDetail->condition,
            'brand' => $post->mobileDetail->brand,
            'model' => $post->mobileDetail->model,
            'description' => $post->description,
            'storage' => $post->mobileDetail->storage,
            'memory' => $post->mobileDetail->memory,
            'battery_status' => $post->mobileDetail->battery_status,
            'accessories' => [
                'charging_cable_type' => $post->mobileDetail->charging_cable_type,
                'charger_type' => $post->mobileDetail->charger_type,
                'headphone_type' => $post->mobileDetail->headphone_type,
            ],
            'images' => $post->images->map(function ($image) {
                return [
                    'url' => asset('storage/' . $image->path),
                    'is_featured' => $image->is_featured,
                    'order' => $image->order,
                ];
            }),
        ]);
    }

  public function getTabletProducts(Request $request)
{
    $query = Post::with(['mobileDetail', 'images', 'category', 'subCategory'])
        ->whereHas('subCategory', function($q) {
            $q->where('name', 'Tablets'); // Only fetch products where subcategory is Tablets
        });

    // Apply additional filters if present in the request
    if ($request->has('condition')) {
        $query->whereHas('mobileDetail', function($q) use ($request) {
            $q->where('condition', $request->condition);
        });
    }

    if ($request->has('min_price')) {
        $query->where('price', '>=', $request->min_price);
    }

    if ($request->has('max_price')) {
        $query->where('price', '<=', $request->max_price);
    }

    if ($request->has('brand')) {
        $query->whereHas('mobileDetail', function($q) use ($request) {
            $q->where('brand', $request->brand);
        });
    }

    // Fetch and format the results
    $tablets = $query->get()->map(function ($post) {
        return [
            'id' => $post->id,
            'title' => strip_tags($post->title),
            'price' => $post->price,
            'location' => $post->location,
            'posted_at' => $post->created_at->diffForHumans(),
            'category' => $post->category->name ?? 'Unknown',
            'sub_category' => $post->subCategory->name ?? 'Unknown',
            'pta_status' => $post->mobileDetail->pta_status ?? 'N/A',
            'condition' => $post->mobileDetail->condition ?? 'New',
            'brand' => $post->mobileDetail->brand ?? 'Unknown',
            'model' => $post->mobileDetail->model ?? 'Unknown',
            'images' => $post->images->map(function ($image) {
                return [
                    'url' => $image->path,
                    'is_featured' => $image->is_featured,
                    'order' => $image->order,
                ];
            }),
        ];
    });

    return response()->json($tablets);
}

  public function getWatchesProducts(Request $request)
{
    $query = Post::with(['mobileDetail', 'images', 'category', 'subCategory'])
        ->whereHas('subCategory', function($q) {
            $q->where('name', 'Smart Watches'); // Only fetch products where subcategory is Tablets
        });

    // Apply additional filters if present in the request
    if ($request->has('condition')) {
        $query->whereHas('mobileDetail', function($q) use ($request) {
            $q->where('condition', $request->condition);
        });
    }

    if ($request->has('min_price')) {
        $query->where('price', '>=', $request->min_price);
    }

    if ($request->has('max_price')) {
        $query->where('price', '<=', $request->max_price);
    }

    if ($request->has('brand')) {
        $query->whereHas('mobileDetail', function($q) use ($request) {
            $q->where('brand', $request->brand);
        });
    }

    // Fetch and format the results
    $tablets = $query->get()->map(function ($post) {
        return [
            'id' => $post->id,
            'title' => strip_tags($post->title),
            'price' => $post->price,
            'location' => $post->location,
            'posted_at' => $post->created_at->diffForHumans(),
            'category' => $post->category->name ?? 'Unknown',
            'sub_category' => $post->subCategory->name ?? 'Unknown',
            'pta_status' => $post->mobileDetail->pta_status ?? 'N/A',
            'condition' => $post->mobileDetail->condition ?? 'New',
            'brand' => $post->mobileDetail->brand ?? 'Unknown',
            'model' => $post->mobileDetail->model ?? 'Unknown',
            'images' => $post->images->map(function ($image) {
                return [
                    'url' => $image->path,
                    'is_featured' => $image->is_featured,
                    'order' => $image->order,
                ];
            }),
        ];
    });

    return response()->json($tablets);
}
public function getMobileProducts(Request $request)
{
    $query = Post::with(['mobileDetail', 'images', 'category', 'subCategory'])
        ->whereHas('subCategory', function($q) {
            $q->where('name', 'Mobile Phones'); // Only fetch products where subcategory is Tablets
        });

    // Apply additional filters if present in the request
    if ($request->has('condition')) {
        $query->whereHas('mobileDetail', function($q) use ($request) {
            $q->where('condition', $request->condition);
        });
    }

    if ($request->has('min_price')) {
        $query->where('price', '>=', $request->min_price);
    }

    if ($request->has('max_price')) {
        $query->where('price', '<=', $request->max_price);
    }

    if ($request->has('brand')) {
        $query->whereHas('mobileDetail', function($q) use ($request) {
            $q->where('brand', $request->brand);
        });
    }

    // Fetch and format the results
    $tablets = $query->get()->map(function ($post) {
        return [
            'id' => $post->id,
            'title' => strip_tags($post->title),
            'price' => $post->price,
            'location' => $post->location,
            'posted_at' => $post->created_at->diffForHumans(),
            'category' => $post->category->name ?? 'Unknown',
            'sub_category' => $post->subCategory->name ?? 'Unknown',
            'pta_status' => $post->mobileDetail->pta_status ?? 'N/A',
            'condition' => $post->mobileDetail->condition ?? 'New',
            'brand' => $post->mobileDetail->brand ?? 'Unknown',
            'model' => $post->mobileDetail->model ?? 'Unknown',
            'images' => $post->images->map(function ($image) {
                return [
                    'url' => $image->path,
                    'is_featured' => $image->is_featured,
                    'order' => $image->order,
                ];
            }),
        ];
    });

    return response()->json($tablets);
}

public function getAccessoryProducts(Request $request)
    {
        try {
            $query = Post::with(['mobileDetail', 'images', 'category', 'subCategory'])
                ->whereHas('subCategory', function ($q) {
                    $q->where('name', 'Accessories');
                });

            // Filter by sub-category if provided
            if ($request->has('sub_category')) {
                $query->whereHas('subCategory', function ($q) use ($request) {
                    $q->where('name', $request->sub_category);
                });
            }

            // Filter by type if provided
            if ($request->has('type')) {
                $query->whereHas('mobileDetail', function ($q) use ($request) {
                    $q->where('type', $request->type);
                });
            }

            // Filter by condition if provided
            if ($request->has('condition')) {
                $query->whereHas('mobileDetail', function ($q) use ($request) {
                    $q->where('condition', $request->condition);
                });
            }

            // Price range filters
            if ($request->has('min_price')) {
                $query->where('price', '>=', $request->min_price);
            }

            if ($request->has('max_price')) {
                $query->where('price', '<=', $request->max_price);
            }

            $accessories = $query->latest()->get()->map(function ($post) {
                return [
                    'id' => $post->id,
                    'post_id' => $post->id,
                    'title' => strip_tags($post->title),
                    'price' => $post->price,
                    'location' => $post->location,
                    'posted_at' => $post->created_at->diffForHumans(),
                    'category' => $post->category->name ?? 'Unknown',
                    'sub_category' => $post->subCategory->name ?? 'Unknown',
                    'type' => $post->mobileDetail->type ?? 'N/A',
                    'condition' => $post->mobileDetail->condition ?? 'New',
                    'brand' => $post->mobileDetail->brand ?? 'Unknown',
                    'model' => $post->mobileDetail->model ?? 'Unknown',
                    'compatibility' => $post->mobileDetail->compatibility ?? '',
                     'images' => $post->images->map(function ($image) {
                return [
                    'url' => $image->path,
                    'is_featured' => $image->is_featured,
                    'order' => $image->order,
                ];
            }),
                ];
            });

            return response()->json($accessories);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'trace' => $e->getTrace()
            ], 500);
        }
    }

   public function getAccessoriesByType ($slug)
{
    try {
        $post = Post::with(['mobileDetail', 'images', 'category', 'subCategory'])
            ->whereHas('mobileDetail', function ($query) use ($slug) {
                $query->whereRaw('LOWER(accessory_type) = ?', [strtolower($slug)]);
            })
            ->firstOrFail();

        return response()->json([
            'id' => $post->id,
            'post_id' => $post->id,
            'brand' => $post->mobileDetail->brand ?? '',
            'model' => $post->mobileDetail->model ?? '',
            'condition' => $post->mobileDetail->condition ?? '',
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
            'compatibility' => $post->mobileDetail->compatibility ?? '',
            'title' => $post->title,
            'description' => $post->description,
            'sub_category' => $post->subCategory->name ?? '',
            'type' => $post->mobileDetail->type ?? '',
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'error' => 'Product not found',
            'message' => $e->getMessage()
        ], 404);
    }
}




}
