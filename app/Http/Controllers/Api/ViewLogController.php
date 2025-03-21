<?php

namespace App\Http\Controllers\Api;

use App\Helper\Common;
use App\Http\Controllers\Controller;
use App\Models\ViewLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ViewLogController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'post_id' => 'required|exists:posts,id',
        ]);

        ViewLog::create([
            'user_id' => Auth::id() ?? null,
            'post_id' => $request->post_id,
            'ip' => $request->ip()
        ]);
        return Common::apiResponse(1,'View logged',[]);

    }
}
