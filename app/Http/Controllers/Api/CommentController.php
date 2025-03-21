<?php

namespace App\Http\Controllers\Api;

use App\Helper\Common;
use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'post_id' => 'required|exists:posts,id',
            'content' => 'required|string'
        ]);

        Comment::create([
            'user_id' => Auth::id(),
            'post_id' => $request->post_id,
            'content' => $request->content
        ]);
        return Common::apiResponse(1,'Comment added',[]);

    }

    public function destroy($id)
    {
        $userId = Auth::id();
        
        $comment = Comment::where('id', $id)
                        ->where('user_id', $userId)
                        ->first();

        if (!$comment) {
            return Common::apiResponse(0, 'Comment not found or you are not authorized', []);
        }

        $comment->delete();

        return Common::apiResponse(1, 'Comment deleted successfully', []);
    }

}
