<?php

use App\Http\Controllers\LoginController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JewelController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PurchaseController;

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

Route::post('/login',[LoginController::class,'login']);
Route::post('/register',[LoginController::class,'register']);

// admin part
Route::get('/jewellery_page',[JewelController::class,'showjewel_page']);
Route::post( '/jewel_store', action: [JewelController::class, 'store_jewel'])->name('jewel.store');

//user part
Route::get('/fetch_jewel', action: [UserController::class, 'fetch_jewels'])->name('fetchjewel');
Route::get('/purchasepageshow/{id}',[PurchaseController::class,'show_purchase']);
Route::get('/purchasepageshow', [PurchaseController::class, 'purchases']); // Fetch all jewels



Route::post('/api/orders', action: [PurchaseController::class, 'createOrder'])->name('paypal.createOrder');
Route::post('/api/orders/{orderId}/capture', [PurchaseController::class, 'captureOrder'])->name('paypal.capture');