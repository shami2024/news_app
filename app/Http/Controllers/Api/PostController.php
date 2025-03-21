<?php

namespace App\Http\Controllers\Api;

use App\Helper\Common;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Http\Resources\RedactionResource;
use App\Models\Interest;
use App\Models\Redaction;
use App\Models\UserInterest;
use Illuminate\Http\Request;
use TCG\Voyager\Models\Post;

class PostController extends Controller
{
    public function index()
    {  
        $page = request('page', 1);
        $perPage = request('perPage', 10);
        $slug = request('slug');
    
        // جلب المنشورات مع العلاقات
        $posts = Post::with(['comments','comments.user', 'redaction', 'category'])
        ->withCount(['likes', 'comments', 'shares']);
    
        if (!empty($slug)) {
            $posts->where('interests', 'LIKE', "%$slug%");
        }
    
        // ترتيب عشوائي ثم تطبيق `paginate` بشكل صحيح
        $posts = $posts->inRandomOrder()->paginate($perPage, ['*'], 'page', $page);
        return Common::apiResponse(
            true, 
            '', 
            PostResource::collection($posts), 
            200, 
            $posts
        );
    }
    

    public function show($id)
    { 
        $posts = Post::with(['comments','comments.user', 'redaction', 'category'])
        ->withCount(['likes', 'comments', 'shares'])
        ->where('id','=',$id)->first();
        return Common::apiResponse(1,'',new PostResource($posts));
    }

    public function getPostsByCategory($categoryId)
    {
        $posts = Post::where('category_id', $categoryId)
        ->with(['comments','comments.user', 'redaction', 'category'])
        ->withCount(['likes', 'comments', 'shares'])
        ->inRandomOrder()
        ->paginate(10);

        if ($posts->isEmpty()) {
            return response()->json(['message' => 'No posts found for this category'], 404);
        }
        return Common::apiResponse(1,'',PostResource::collection($posts));

    }


    public function getRedactions()
    {
        $redaction = Redaction::select('id','name','logo')->paginate(10);
        return Common::apiResponse(1,'',RedactionResource::collection($redaction));
    }


    
    public function getRedactionPosts($id)
    {
        $posts = Post::where('redaction_id', $id)
        ->with(['comments','comments.user', 'redaction', 'category'])
        ->withCount(['likes', 'comments', 'shares'])
        ->inRandomOrder()
        ->paginate(10);

        if ($posts->isEmpty()) {
            return Common::apiResponse(0,'No posts found for this Redaction',[],400);
        }
        return Common::apiResponse(1,'',PostResource::collection($posts));

    }

    public function trendingPosts()
{
    $trendingPosts = Post::
    with(['comments','comments.user', 'redaction', 'category'])
    ->withCount(['likes', 'comments', 'shares', 'viewLogs'])
        ->orderByDesc('view_logs_count')
        ->orderByDesc('likes_count')
        ->orderByDesc('comments_count')
        ->orderByDesc('shares_count')
        ->take(10)
        ->get();
        return Common::apiResponse(1,'',PostResource::collection($trendingPosts));

}

public function recentPosts()
{
    $last24Hours = now()->subDay(); // الحصول على الوقت منذ 24 ساعة

    $posts = Post::with(['comments','comments.user', 'redaction', 'category'])
      ->withCount(['likes', 'comments', 'shares', 'viewLogs'])
        ->where('created_at', '>=', $last24Hours)
        ->withCount(['likes', 'shares']) // حساب عدد الإعجابات والمشاركات
        ->orderBy('created_at', 'desc') // ترتيب من الأحدث إلى الأقدم
        ->paginate(10); // تقسيم الصفحات كل 10 منشورات

    return Common::apiResponse(
        true,
        'Recent posts from last 24 hours',
        PostResource::collection($posts),
        200,
        $posts
    );
}

}
