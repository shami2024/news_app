<?php

namespace App\Http\Controllers\Api;

use App\Helper\Common;
use App\Http\Controllers\Controller;
use App\Models\Share;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShareController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'post_id' => 'required|exists:posts,id',
        ]);

        Share::create([
            'user_id' => Auth::id(),
            'post_id' => $request->post_id
        ]);

        return Common::apiResponse(1,'Post shared successfully',[]);

    }
}
