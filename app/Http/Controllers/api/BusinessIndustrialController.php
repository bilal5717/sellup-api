<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BusinessIndustrialDetail;
use App\Models\Post;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\PostImage;
use App\Models\PostVideo;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Mews\Purifier\Facades\Purifier;

class BusinessIndustrialController extends Controller
{
    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255|min:10',
                'description' => 'required|string|min:20|max:2000',
                'category' => 'required|string|max:255',
                'subCategory' => 'required|string|max:255',
                'price' => 'required|numeric|min:0|max:9999999',
                'location' => 'required|string|max:255',
                'contactName' => 'required|string|max:100',
                'businessType' => 'nullable|string|max:255',
                'specialField' => 'nullable|string|max:255',
                'subCategoryType' => 'nullable|string|max:255',
                'companyName' => 'nullable|string|max:255',
                'sellerType' => 'nullable|string|in:business,individual',
                'condition' => 'nullable|string|in:New,Used,Refurbished',
                'operationScale' => 'nullable|string|in:Small,Medium,Large',
                'specifications' => 'nullable|string|max:2000',
                'imageUrls' => 'sometimes|json',
                'videoUrls' => 'sometimes|json',
            ]);

            $imageUrls = $request->has('imageUrls') ? json_decode($request->input('imageUrls'), true) : [];
            $videoUrls = $request->has('videoUrls') ? json_decode($request->input('videoUrls'), true) : [];

            // Create or find category and subcategory
            $category = Category::firstOrCreate(
                ['name' => $validated['category']],
                ['slug' => Str::slug($validated['category'])]
            );

            $subCategory = SubCategory::firstOrCreate(
                ['name' => $validated['subCategory'], 'category_id' => $category->id],
                ['slug' => Str::slug($validated['subCategory'])]
            );

            // Create the post
            $post = Post::create([
                'user_id' => auth()->id() ?? 1,
                'category_id' => $category->id,
                'sub_category_id' => $subCategory->id,
                'title' => Purifier::clean($validated['title']),
                'description' => Purifier::clean($validated['description']),
                'price' => $validated['price'],
                'location' => $validated['location'],
                'contact_name' => $validated['contactName'],
                'phone_number' => auth()->user()->phone_number ?? '848764568998',
                'status' => 'pending',
            ]);

            // Create business industrial detail
            BusinessIndustrialDetail::create([
                'post_id' => $post->id,
                'business_type' => $validated['businessType'] ?? null,
                'special_field' => $validated['specialField'] ?? null,
                'sub_category_type' => $validated['subCategoryType'] ?? null,
                'company_name' => $validated['companyName'] ?? null,
                'seller_type' => $validated['sellerType'] ?? null,
                'condition' => $validated['condition'] ?? null,
                'operation_scale' => $validated['operationScale'] ?? null,
                'specifications' => $validated['specifications'] ?? null,
            ]);

            // Save image URLs
            foreach ($imageUrls as $imageUrl) {
                PostImage::create([
                    'post_id' => $post->id,
                    'path' => $imageUrl,
                ]);
            }

            // Save video URLs
            foreach ($videoUrls as $videoUrl) {
                PostVideo::create([
                    'post_id' => $post->id,
                    'path' => $videoUrl,
                ]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Business post created successfully',
                'post_id' => $post->id,
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error creating business post: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function index()
{
    try {
        $businessProducts = Post::with(['businessIndustrialDetail', 'images', 'category', 'subCategory'])
            ->whereHas('businessIndustrialDetail')
            ->whereHas('category', function($query) {
                $query->where('name', 'Business, Industrial & Agriculture');
            })
            ->get()
            ->map(function ($post) {
                return [
                    'id' => $post->id,
                    'title' => strip_tags($post->title),
                    'price' => $post->price,
                    'location' => $post->location,
                    'condition' => $post->businessIndustrialDetail ? $post->businessIndustrialDetail->condition : null,
                    'posted_at' => $post->created_at->diffForHumans(),
                    'images' => $post->images->map(function ($image) {
                        return [
                            'url' => $image->path,
                            'is_featured' => $image->is_featured,
                            'order' => $image->order,
                        ];
                    }),
                    'business_detail' => $post->businessIndustrialDetail ? [
                        'business_type' => $post->businessIndustrialDetail->business_type,
                        'special_field' => $post->businessIndustrialDetail->special_field,
                        'sub_category_type' => $post->businessIndustrialDetail->sub_category_type,
                        'company_name' => $post->businessIndustrialDetail->company_name,
                        'seller_type' => $post->businessIndustrialDetail->seller_type,
                        'operation_scale' => $post->businessIndustrialDetail->operation_scale,
                        'specifications' => $post->businessIndustrialDetail->specifications,
                    ] : null,
                ];
            });

        return response()->json($businessProducts);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}

}
