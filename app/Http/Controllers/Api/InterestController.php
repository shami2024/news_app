<?php

namespace App\Http\Controllers\Api;

use App\Helper\Common;
use App\Http\Controllers\Controller;
use App\Models\Interest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use TCG\Voyager\Models\Post;
use function Laravel\Prompts\select;

class InterestController extends Controller
{
    public function addUserInterests(Request $request)
    {
        $request->validate([
            'interests' => 'required|array',
            'interests.*' => 'exists:interests,id'
        ]);
    
        $userDeviceId = $request->header('devise_id');    
    
        foreach ($request->interests as $interestId) {
            DB::table('user_interests')->insert([
                'dev_id' => $userDeviceId,
                'interest_id' => $interestId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        return Common::apiResponse(1,'Interests inserted successfully',[]);

    }
    public function getInterests()
    {
        $interest = Interest::select('id','name')->get();
        return Common::apiResponse(1,'',$interest);
    }
    

    public function getPostsByInterests()
    {
        $user = auth()->user();
        $interests = $user->interests()->pluck('id');

        $posts = Post::whereHas('interests', function ($query) use ($interests) {
            $query->whereIn('interest_id', $interests);
        })->get();

        return response()->json($posts);
    }
}
