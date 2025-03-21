<?php

namespace App\Http\Controllers\Admin;

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
        $posts = Post::latest()->paginate(10);
        return view('admin.posts.index', compact('posts'));
    }

}