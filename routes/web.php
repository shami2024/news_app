<?php

use App\Models\Redaction;
use Illuminate\Support\Facades\Route;
use TCG\Voyager\Facades\Voyager;
use TCG\Voyager\Models\Category;
use App\Http\Controllers\Admin\PostController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    $cat =Redaction::latest()->first();
    $url = asset('storage/' . $cat->logo);

    return $url;
    return view('welcome');
});
use App\Models\Interest;

Route::get('/test-interests', function () {
    return Interest::all();
});


Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();

});
