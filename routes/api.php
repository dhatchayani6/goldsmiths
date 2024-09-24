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

// admin part

//user part
Route::get('/fetch_jewel', action: [UserController::class, 'fetch_jewels'])->name('fetchjewel');
Route::get('/purchasepageshow/{id}',[PurchaseController::class,'show_purchase']);
Route::get('/purchasepageshow', [PurchaseController::class, 'purchases']); // Fetch all jewels


// admin part
Route::get('/jewellery_page',[JewelController::class,'showjewel_page'])->name('jewellerypage');
Route::get('show_jewel_store',[JewelController::class,'show_store_jewellery'])->name('showstorejewellery');
Route::post( '/jewel_store', action: [JewelController::class, 'store_jewel'])->name('jewel.store');
Route::get('/jewel/queries', [JewelController::class, 'showQueries'])->name('jewel.queries');
Route::post('/query/customize-payment', [JewelController::class, 'customizePayment'])->name('query.customizePayment');

Route::post('/queries/{id}/accept', [JewelController::class, 'accept'])->name('queries.accept');
Route::post('/queries/{id}/reject', [JewelController::class, 'reject'])->name('queries.reject');
Route::post('/jewel/{id}/query', [JewelQueryController::class, 'submitQuery'])->name('jewel.query');

//userpart
Route::get('/fetch_jewel', action: [UserController::class, 'fetch_jewels'])->name('fetchjewel');

Route::get('/jewel/{id}', [UserController::class,'show_jewe'])->name('jewel.show');

Route::get('/jewel/status', [UserController::class, 'showJewelStatus'])->name('jewel.status');

Route::get('/jewel/status/{id}', [UserController::class, 'showJewelStatus'])->name('jewel.status');
Route::get('/showcustomizationqueries',[UserController::class,'showcustomizationqueries'])->name('show_customization_queries');

Route::get('/purchasepageshow/{id}',[PurchaseController::class,'show_purchase']);

Route::post('/addpurchase',[PurchaseController::class,'storepurchasedetails'])->name('purchase.store');



Route::get('/get_purchase',[PurchaseController::class,'getpurchase'])->name('get_purchases');
Route::post('/update-status', [PurchaseController::class, 'updateStatus'])->name('update.status');

Route::get('/customize-jewel/{id}', [UserQueriesController::class, 'create'])->name('customize.jewel');
Route::post('/customize_design',[UserQueriesController::class,'store_customize'])->name('store.customizedesign');
Route::get('/custom-queries', [UserQueriesController::class, 'getCustomQueries'])->name('getcustomqueries');

Route::post('/query/accept/{id}', [UserQueriesController::class, 'accept']);
Route::post('/query/reject/{id}', [UserQueriesController::class, 'reject']);

Route::post('/query/customize-payment', [CustomqueriesController::class, 'store_customqueries'])->name('query.customizePayment');







//correct api file

//login and register
Route::post('/login',[LoginController::class,'login']);
Route::post('/register',[LoginController::class,'register']);

//add jewelery part
Route::post( '/jewel_store', action: [JewelController::class, 'store_jewel'])->name('jewel.store');
