<?php

use App\Http\Controllers\LoginController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JewelController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\UserQueriesController;
use App\Http\Controllers\JewelQueryController;
use App\Http\Controllers\CustomqueriesController;




/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
//login and register
Route::post('/login',[LoginController::class,'login']);
Route::post('/register',[LoginController::class,'register']);

//add jewelery part
Route::post( '/jewel_store', action: [JewelController::class, 'store_jewel'])->name('jewel.store');

// user part 
Route::get('/fetch_jewel', action: [UserController::class, 'fetch_jewels'])->name('fetchjewel');


//view click particlar jewel detail fetching here
Route::get('/jewel/{id}', [UserController::class,'show_jewe'])->name('jewel.show');

//to purchase a particluar jewel
Route::get('/purchasepageshow/{id}', [PurchaseController::class, 'purchases']); // Fetch all jewels

//to addd purchase 
Route::post('/addpurchase',[PurchaseController::class,'storepurchasedetails'])->name('purchase.store');


//to customize purchase
Route::get('/customize-jewel/{id}', [UserQueriesController::class, 'create'])->name('customize.jewel');

//to store the cutomize 
Route::post('/customize_design',[UserQueriesController::class,'store_customize'])->name('store.customizedesign');


Route::get('/userqueries/{id}', [UserController::class, 'fetchUserQueries'])->name('fetchuserqueries');

//to get th eimage in smith side
Route::get('/manage_jewels',[JewelController::class,'manage']);


// Show edit form for a specific jewel
Route::get('/jewel/edit/{id}', [JewelController::class, 'edit']);

// Update a specific jewel
Route::post('/jewel/update/{id}', [JewelController::class, 'update']);

// Delete a specific jewel
Route::delete('/jewel/delete/{id}', [JewelController::class, 'destroy']);
//jewel statsu

Route::get('/jewel/status', [UserController::class, 'showJewelStatus'])->name('jewel.status');


Route::get('/jewel/status/{id}', [UserController::class, 'showJewel_Status'])->name('jewel.status');


Route::get('/get_purchase',[PurchaseController::class,'getpurchase'])->name('get_purchases');



Route::middleware('auth')->group(function () {
    // Route for fetching contacts
    Route::get('/fetch-contacts/{usertype}', [UserController::class, 'fetchContacts'])->name('fetch.contacts');
});


Route::get('/fetch_jewel',[JewelController::class,'fetch_jewel']);
Route::get('/userqueries/{id}', [UserController::class, 'fetchUser_Queries'])->name('fetchuserqueries');


// Show edit form for a specific jewel
Route::get('/jewel/edit/{id}', [JewelController::class, 'jewel_edit']);

// Update a specific jewel
Route::post('/jewel/jewelupdate/{id}', [JewelController::class, 'jewel_update']);

// Delete a specific jewel
// Route::delete('/jewel/delete/{id}', [JewelController::class, 'destroy']);
// In routes/api.php
Route::delete('/jewel/delete/{id}', [JewelController::class, 'destroy'])->name('jewel.destroy');



Route::get('/user-queries', [UserQueriesController::class, 'getCustom_Queries'])->name('getcustomqueries');
Route::post('/query/accept/{id}', [UserQueriesController::class, 'accept']);
Route::post('/query/reject/{id}', [UserQueriesController::class, 'reject']);
Route::post('/query/customize-payment', [CustomqueriesController::class, 'store_customqueries'])->name('query.customizePayment');
