<?php

namespace App\Http\Controllers\Api;

use App\Helper\Common;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use Illuminate\Http\Request;
use TCG\Voyager\Models\Post;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with('category')->paginate(10);
        return Common::apiResponse(1,'',PostResource::collection($posts));
    }

    public function getPostsByCategory($categoryId)
    {
        $posts = Post::where('category_id', $categoryId)->with('category')->paginate(10);

        if ($posts->isEmpty()) {
            return response()->json(['message' => 'No posts found for this category'], 404);
        }
        return Common::apiResponse(1,'',PostResource::collection($posts));

    }
}
