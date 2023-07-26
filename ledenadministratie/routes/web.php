<?php

use App\Models\Family;
use GuzzleHttp\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FamilyController;
use App\Http\Controllers\FamilymemberController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
// Common Resource Routes:
// index - Show all families
// show - show single Family
// create - Show form to create new Family
// store - Store new Family
// edit - Show form to edit family
// update - Update Family
// destroy - Delete family

*/

// All families
Route::get('/', [FamilyController::class,
 'index']);

// Show Family create form
Route::get('/families/create', [FamilyController::class,
 'create'])->Middleware('auth');

// Store familie data
Route::post('/families', [FamilyController::class,
 'store'])->Middleware('auth');

// Manage families
Route::get('/families/manage', [FamilyController::class,
 'manage'])->Middleware('auth');

//Show Family edit form
Route::get('/families/{family}/edit', [FamilyController::class,
 'edit'])->Middleware('auth');

// Update family
Route::put('/families/{family}', [FamilyController::class,
 'update'])->Middleware('auth');

// Delete family
Route::delete('/families/{family}', [FamilyController::class,
 'destroy'])->Middleware('auth');

//Single family
// A family where Family is the name of the model
Route::get('/families/{family}', [FamilyController::class,
 'show'])->Middleware('auth');

 // FAMILY MEMBERS
 // Show FamilyMember create form
// web.php

Route::get('/familymembers/create/{family_id?}', [FamilymemberController::class, 'create'])
    ->name('familymembers.create');

// Store familie data
Route::post('/familymembers', [FamilymemberController::class, 'store'])->middleware('auth');



// Show USER register form
Route::get('/register', [UserController::class,
 'create'])->Middleware('guest');

// Create new USER
Route::post('/users', [UserController::class,
 'store']);

// Log out USER
Route::post('/logout', [UserController::class,
 'logout'])->Middleware('auth');

// Show login form
Route::get('/login', [UserController::class,
 'login'])->name('login')->Middleware('guest');

// Login USER
Route::post('/users/authenticate', [UserController::class,
 'authenticate']);
 











