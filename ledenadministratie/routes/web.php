<?php

use App\Http\Controllers\FamilyController;
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
Route::get('/', [FamilyController::class, 'index'] );

// Show create form
Route::get('/families/create', [FamilyController::class, 'create']);

// Store familie data
Route::post('/families', [FamilyController::class, 'store']);

//Show edit form
Route::get('/families/{family}/edit', [FamilyController::class, 'edit']);

// Update family
Route::put('/families/{family}', [FamilyController::class, 'update']);

// Delete family
Route::delete('/families/{family}', [FamilyController::class, 'destroy']);

//Single family
// A family where Family is the name of the model
Route::get('/families/{family}', [FamilyController::class, 'show']);












