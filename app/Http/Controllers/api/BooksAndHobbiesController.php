<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;

class BooksAndHobbiesController extends Controller
{
    public function index()
    {
        try {
            $booksAndHobbiesPosts = Post::with(['booksSportsDetail', 'images', 'category', 'subCategory'])
                ->whereHas('booksSportsDetail')
                ->whereHas('category', function($query) {
                    $query->where('name', 'Books, Sports & Hobbies');
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
                        'books_details' => $post->booksSportsDetail ? [
                            'sub_type' => $post->booksSportsDetail->sub_type,
                            'condition' => $post->booksSportsDetail->condition,
                            'language' => $post->booksSportsDetail->language,
                            'author' => $post->booksSportsDetail->author,
                        ] : null,
                    ];
                });

            return response()->json($booksAndHobbiesPosts);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
