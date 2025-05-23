<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;

class VehicleController extends Controller
{
  public function index(Request $request)
{
    try {
        $slug = $request->query('slug');

        $posts = Post::with(['vehicleDetail', 'images', 'category', 'subCategory', 'categoryType'])
            ->whereHas('vehicleDetail')
            ->whereHas('category', function ($q) {
                $q->where('name', 'Vehicles');
            });

        if ($slug) {
            $posts->where(function ($query) use ($slug) {
                $query->whereHas('subCategory', function ($q) use ($slug) {
                    $q->where('slug', $slug);
                })->orWhereHas('vehicleDetail', function ($q) use ($slug) {
                    $q->whereRaw('LOWER(vehicle_type) = ?', [strtolower(str_replace('-', ' ', $slug))]);
                });
            });
        }

        $vehiclePosts = $posts->get()->map(function ($post) {
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
                'vehicle_details' => $post->vehicleDetail ? [
                    'vehicle_type' => $post->vehicleDetail->vehicle_type,
                    'make' => $post->vehicleDetail->make,
                    'model' => $post->vehicleDetail->model,
                    'year' => $post->vehicleDetail->year,
                    'kms_driven' => $post->vehicleDetail->kms_driven,
                    'monthly_installment' => $post->vehicleDetail->monthly_installment,
                    'transmission' => $post->vehicleDetail->transmission,
                    'assembly' => $post->vehicleDetail->assembly,
                    'condition' => $post->vehicleDetail->condition,
                    'registration_city' => $post->vehicleDetail->registration_city,
                    'doc_type' => $post->vehicleDetail->doc_type,
                    'number_of_owners' => $post->vehicleDetail->number_of_owners,
                    'fuel_type' => $post->vehicleDetail->fuel_type,
                    'registered' => $post->vehicleDetail->registered,
                    'install_plan' => $post->vehicleDetail->install_plan,
                    'down_payment' => $post->vehicleDetail->down_payment,
                    'features' => $post->vehicleDetail->features,
                ] : null,
            ];
        });

        return response()->json($vehiclePosts);

    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}

}
