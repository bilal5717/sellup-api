<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\JobDetail;
class JobsController extends Controller
{
    public function index()
    {
        $jobs = Post::with(['jobDetail', 'images', 'category', 'subCategory'])
            ->whereHas('JobDetail')
            ->whereHas('category', function($query) {
                    $query->where('name', 'Jobs');
                })
            ->get()
            ->map(function ($post) {
                return [
                    'id' => $post->id,
                    'title' => strip_tags($post->title),
                    'price' => $post->price,
                    'location' => $post->location,
                    'posted_at' => $post->created_at->diffForHumans(),
                    'job_type' => $post->jobDetail->job_type,
                    'company_name' => $post->jobDetail->company_name,
                   'images' => $post->images->map(function ($image) {
                            return [
                                'url' => $image->path,
                                'is_featured' => $image->is_featured,
                                'order' => $image->order,
                            ];
                        }),
                    'salary_from' => $post->jobDetail->salary_from,
                    'salary_to' => $post->jobDetail->salary_to,
                    'condition' => $post->jobDetail->position_type,
                ];
            });

        return response()->json($jobs);
    }

     public function getjobsProducts()
    {
        try {
            $jobPosts = Post::with(['jobDetail', 'images', 'category', 'subCategory'])
                ->whereHas('jobDetail')
                ->whereHas('category', function($query) {
                    $query->where('name', 'Jobs');
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
                        'job_details' => $post->jobDetail ? [
                            'job_type' => $post->jobDetail->job_type,
                            'hiring_type' => $post->jobDetail->hiring_type,
                            'company_name' => $post->jobDetail->company_name,
                            'salary_from' => $post->jobDetail->salary_from,
                            'salary_to' => $post->jobDetail->salary_to,
                            'career_level' => $post->jobDetail->career_level,
                            'salary_period' => $post->jobDetail->salary_period,
                            'position_type' => $post->jobDetail->position_type,
                        ] : null,
                    ];
                });

            return response()->json($jobPosts);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
