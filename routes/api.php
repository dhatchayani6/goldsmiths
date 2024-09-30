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


Route::get('/userqueries/{id}',[UserController::class,'fetchUserQueries']);

