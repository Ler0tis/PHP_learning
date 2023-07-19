<?php

use App\Models\Family;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Listing;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// All families
Route::get('/', function () {
    return view('families', [
        'heading' => 'All Families',
        'families' => Family::all()  
    ]);
});

// A family where Family is the name of the model
Route::get('/families/{family}', function(Family $family) {
    // in plaats van $family = Family::find($id);
    return view('family', [
        'family' => $family
    ]);
});











//Route::get('/hello', function () {
//    return response('<h1>Hello World</h1>');
//});
//
//Route::get('/posts/{id}', function($id) {
//    return response('Post ' . $id);
//})->where('id', '[0-9]+');
//
//Route::get('/search', function(Request $request) {
//    dd($request);
//});