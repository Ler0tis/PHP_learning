<?php

use App\Http\Controllers\ContributionController;
use App\Models\Family;
use GuzzleHttp\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FamilyController;
use App\Http\Controllers\MembershipController;
use App\Http\Controllers\FamilymemberController;
use App\Http\Controllers\FinancialYearController;

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
// index - Show all entities
// show - show single Entity
// create - Show form to create new Entity
// store - Store new Entity
// edit - Show form to edit Entity
// update - Update Entity
// destroy - Delete Entity

*/

// Redirect for getting back to the family page (werkt nog niet 
// Route::get('/families/{family}', [FamilyController::class, 'show'])->name('families.show');


///////////////////////////// Families ////////////////////////////////////
// All families
Route::get('/', [FamilyController::class,
 'index'])->Middleware('auth');

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



 ///////////// FAMILY MEMBERS////////////////////////////////////////
 // Show FamilyMember create form
Route::get('/familymembers/create/{family_id?}', [FamilymemberController::class, 'create'])
    ->name('familymembers.create');

// Store family member data
Route::post('/familymembers', [FamilymemberController::class, 'store'])->Middleware('auth');

//Show Family member edit form
Route::get('/familymembers/{familymember}/edit', [FamilymemberController::class, 'edit'])->name('familymembers.edit')->Middleware('auth');


// Update Family members
Route::put('/familymembers/{familymember}', [FamilymemberController::class, 'update'])->name('familymembers.update')->Middleware('auth');


// Delete familymember
Route::delete('/familymembers/{id}', [FamilymemberController::class,'destroy'])->Middleware('auth');

/////////////////////////// Memberships ///////////////////////////////////////
// Show Memberships
Route::get('/memberships', [MembershipController::class, 'index'])->Middleware('auth');

// Show create form 
Route::get('/memberships/create', [MembershipController::class, 'create'])->Middleware('auth');

// Store Memberships data
Route::post('/memberships', [MembershipController::class, 'store'])->Middleware('auth');

// Show Memberships edit form
Route::get('/memberships/{membership}/edit', [MembershipController::class, 'edit'])->name('memberships.edit')->Middleware('auth');

// Update Memberships
Route::put('/memberships/{membership}', [MembershipController::class, 'update'])->name('memberships.update')->Middleware('auth');

// Delete Membership
Route::delete('/memberships/{id}', [MembershipController::class, 'destroy'])->Middleware('auth');



/////////// CONTRIBUTION ////////////////
// All contributions
Route::get('/contributions', [ContributionController::class, 'index'])->name('contributions.index')->Middleware('auth');

Route::post('contributions', [ContributionController::class, 'store'])->name('contributions.store')->Middleware('auth');

// Show create form 
Route::get('/contributions/create', [ContributionController::class, 'create'])->Middleware('auth');

// Show Contribution edit form
Route::get('/contributions/{contribution}/edit', [ContributionController::class, 'edit'])->name('contributions.edit')->Middleware('auth');

// Update Contribution
Route::put('/contributions/{contribution}', [ContributionController::class, 'update'])->name('contributions.update')->Middleware('auth');

// Delete
Route::delete('/contributions/{id}', [ContributionController::class, 'destroy'])->Middleware('auth');


/////////// Financial Years ////////////////


Route::get('/financialyears', [FinancialYearController::class, 'index'])->name('financialyears.index')->Middleware('auth');

Route::resource('financial-years', FinancialYearController::class)->Middleware('auth');





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
 











