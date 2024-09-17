<?php

use App\Http\Controllers\JewelController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\JewelQueryController;
use App\Http\Controllers\PayPalTransactionController;
use App\Http\Controllers\PurchaseController;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::get('/',[LoginController::class,'index']);

Route::get('/homepage',[LoginController::class,'home']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


// admin part
Route::get('/jewellery_page',[JewelController::class,'showjewel_page'])->name('jewellery_page');
Route::post( '/jewel_store', action: [JewelController::class, 'store_jewel'])->name('jewel.store');
Route::get('/jewel/queries', [JewelController::class, 'showQueries'])->name('jewel.queries');
Route::post('/queries/{id}/accept', [JewelController::class, 'accept'])->name('queries.accept');
Route::post('/queries/{id}/reject', [JewelController::class, 'reject'])->name('queries.reject');
Route::post('/jewel/{id}/query', [JewelQueryController::class, 'submitQuery'])->name('jewel.query');

//userpart
Route::get('/fetch_jewel', action: [UserController::class, 'fetch_jewels'])->name('fetchjewel');

Route::get('/jewel/{id}', [UserController::class,'show_jewe'])->name('jewel.show');

Route::get('/jewel/status', [UserController::class, 'showJewelStatus'])->name('jewel.status');

Route::get('/jewel/status/{id}', [UserController::class, 'showJewelStatus'])->name('jewel.status');
Route::get('/purchasepageshow/{id}',[PurchaseController::class,'show_purchase']);

Route::post('/addpurchase',[PurchaseController::class,'storepurchasedetails'])->name('purchase.store');

Route::post('/create-order', [PayPalTransactionController::class, 'createOrder']);
Route::post('/capture-order/{orderId}', [PayPalTransactionController::class, 'captureOrder']);