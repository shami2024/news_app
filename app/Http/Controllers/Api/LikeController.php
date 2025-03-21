<?php

namespace App\Http\Controllers\Api;

use App\Helper\Common;
use App\Http\Controllers\Controller;
use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'post_id' => 'required|exists:posts,id',
        ]);
    
        $userId = Auth::id();
        $postId = $request->post_id;
    
        $like = Like::where('user_id', $userId)
                    ->where('post_id', $postId)
                    ->first();
    
        if ($like) {
            $like->delete();
            return Common::apiResponse(1, 'Disliked successfully', []);
        } else {
            Like::create([
                'user_id' => $userId,
                'post_id' => $postId,
            ]);
            return Common::apiResponse(1, 'Liked successfully', []);
        }

    }
}
