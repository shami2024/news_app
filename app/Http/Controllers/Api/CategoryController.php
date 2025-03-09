<?php

namespace App\Http\Controllers\Api;

use App\Helper\Common;
use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use Illuminate\Http\Request;
use TCG\Voyager\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return Common::apiResponse(1,'',CategoryResource::collection($categories));

    }
}
