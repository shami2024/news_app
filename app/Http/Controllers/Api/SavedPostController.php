<?php

namespace App\Http\Controllers\Api;


use App\Helper\Common;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\SavedPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SavedPostController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'post_id' => 'required|exists:posts,id',
        ]);

        $user = Auth::user();

        if ($user->savedPosts()->where('post_id', $request->post_id)->exists()) {
            return Common::apiResponse(1,'Post already saved',[]);

            
        }

        $savedPost = SavedPost::create([
            'user_id' => $user->id,
            'post_id' => $request->post_id,
        ]);
        return Common::apiResponse(1,'Post saved successfully',[]);

    }

    public function index()
    {
        $user = Auth::user();
        $savedPosts = $user->savedPosts()->with(['post'])->get();

        return Common::apiResponse(1,'', PostResource::collection($savedPosts->pluck('post')));
    }

    public function destroy($id)
    {
        $user = Auth::user();
        $savedPost = $user->savedPosts()->where('post_id', $id)->first();

        if (!$savedPost) {
            return Common::apiResponse(0,'Post not found in saved list',[],404);

        }

        $savedPost->delete();
        return Common::apiResponse(1,'Post removed from saved list');

    }
}
