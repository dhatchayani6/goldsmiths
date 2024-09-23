<?php

use App\Http\Controllers\ChatController;
use App\Http\Controllers\JewelController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\JewelQueryController;
use App\Http\Controllers\UserQueriesController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\CustomqueriesController;

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
Route::get('/purchasepageshow', [PurchaseController::class, 'purchases']); // Fetch all jewels


Route::post('/addpurchase',[PurchaseController::class,'storepurchasedetails'])->name('purchase.store');

Route::post('/api/orders', action: [PurchaseController::class, 'createOrder'])->name('paypal.createOrder');
Route::post('/api/orders/{orderId}/capture', [PurchaseController::class, 'captureOrder'])->name('paypal.capture');

Route::get('/get_purchase',[PurchaseController::class,'getpurchase'])->name('get_purchases');
Route::post('/update-status', [PurchaseController::class, 'updateStatus'])->name('update.status');

Route::get('/customize-jewel/{id}', [UserQueriesController::class, 'create'])->name('customize.jewel');
Route::post('/customize_design',[UserQueriesController::class,'store_customize'])->name('store.customizedesign');
Route::get('/custom-queries', [UserQueriesController::class, 'getCustomQueries'])->name('getcustomqueries');

Route::post('/query/accept/{id}', [UserQueriesController::class, 'accept']);
Route::post('/query/reject/{id}', [UserQueriesController::class, 'reject']);

Route::post('/query/customize-payment', [CustomqueriesController::class, 'store_customqueries'])->name('query.customizePayment');


// profile part
Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show'); // Display the profile
Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update'); // Update profile info

//chat part
Route::get('/chat', [ChatController::class, 'chat'])->name('chat');
