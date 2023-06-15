<?php

use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartOrdersController;
use App\Http\Controllers\DaftarMenuController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\HomepageController;

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
// Route::auth();
Route::get('/', function () {
    return view('auth.login');
});
Route::get('/register', [RegisterController::class, 'index'])->name('register');
Route::post('/register', [RegisterController::class, 'store'])->name('register');

Route::get('/home', [HomepageController::class, 'index'])->name('homepage');

Route::get('/daftarmenu/restaurant', [DaftarMenuController::class, 'restaurant'])->name('daftar-restaurant');

Route::get('/daftarmenu/biliard', [DaftarMenuController::class, 'biliard'])->name('daftar-billiard');
// Route::get('/daftarmenu/billiard', function () {
//     return view('daftarmenu.billiard');
// })->name('daftar-billiard');

Route::get('/daftarmenu/meetingroom', function () {
    return view('daftarmenu.meeting-room');
})->name('daftar-meeting-room');

Route::get('/detailmenu/{type}/{slug}', function (Request $request,$type, $slug) {
    $global_url = 'http://management-vmond.test/api/v1/vmond/tokoonline/detail/';
    $rest_api_url = $global_url.$type.'/'.$slug;
    // Belum selesai
    $getData = file_get_contents($rest_api_url);
    try {
        $getJSON = json_decode($getData);
        // $getJSON = $getJSON->data;
    } catch (\Throwable $th) {
        $getJSON = [];
    }
    return view('detail-menu.index', compact('getJSON'));
})->name('detail-menu');

Route::get('/reservation', function () {
    return view('reservation.index');
})->name('reservation');

// Route::get('/checkout', function () {
//     return view('checkout.index');
// })->name('checkout');


// Cart Meeting Room
Route::get('/cart-meeting', function () {
    return view('cart.meeting-room');
})->name('cart-meeting-room');

// User-profile
// Route::get('/user-profile', [UserController::class, 'userProfile'])->name('user-profile');
Route::get('/user-profile/edit/{id}', [UserController::class, 'edit'])->name('edit-account');
Route::patch('/user-profile/{id}', [UserController::class, 'update'])->name('update-account');

// Restaurant Cart
Route::get('/add-chart-restaurant/{id}',[CartOrdersController::class, 'addCartRestaurant'])->name('restaurant-cart');
Route::get('/cart',[CartOrdersController::class, 'index'])->name('cart');
Route::post('/cart-update',[CartOrdersController::class, 'updateCart'])->name('cart-update');
Route::get('/delete-chart-restaurant/{id}',[CartOrdersController::class, 'deleteCartRestaurant'])->name('delete-restaurant-cart');

// Biliard
// Route::get('cart_biliard/{id}/edit', [CartOrdersController::class, 'editBiliard'])->name('cart-biliard-edit');
Route::get('/cart-billiard',[CartOrdersController::class, 'viewCartBilliard'])->name('cart-billiard');
Route::get('/cart-billiard/{id}',[CartOrdersController::class, 'addCartBilliard'])->name('add-cart-billiard');
Route::get('cart_billiard/{id}/edit', [CartOrdersController::class, 'editBilliard'])->name('edit-cart-billiard');
Route::get('/delete-chart-biliard/{id}',[CartOrdersController::class, 'deleteCartBilliard'])->name('delete-cart-billiard');

// Meeting Room Cart
// Route::post('/add-chart',[CartOrdersController::class, 'addCart'])->name('add-chart');
Route::get('/cart-meeting-room/{id}',[CartOrdersController::class, 'addCartMeeting'])->name('add-chart');
Route::get('/cart-meeting',[CartOrdersController::class, 'viewCartMeetingRoom'])->name('cart-meeting-room');
Route::get('/delete-chart/{id}',[CartOrdersController::class, 'deleteCart'])->name('delete-cart');
Route::get('cart_meeting-room/{id}/edit', [CartOrdersController::class, 'editMeeting'])->name('cart-meeting-edit');



// Route Midtrans
Route::get('midtrans',[CartOrdersController::class,'midtransCheck'])->name('midtrans-check');

// Route Orders
Route::get('orders',[OrderController::class,'index'])->name('order.index');
// Route::post('/checkout-order',[OrderController::class,'checkout'])->name('checkout-order');
Route::post('/checkout',[OrderController::class,'checkout'])->name('checkout-order');
Route::get('/invoice/{id}',[OrderController::class,'invoice'])->name('invoice');

// Route History Penjualan
Route::get('/history-penjualan/{id}',[HistoryController::class,'index'])->name('history-penjualan');
Route::get('/history-penjualan/cetak-pdf/{id}',[HistoryController::class,'pdfExport'])->name('cetak-pdf');

// Route Pesanan detail
Route::get('/pesanan-detail/{id}',[HistoryController::class,'pesananOrder'])->name('pesanan-order');

// Route Xendit Payment
Route::post('/ewallets/charges',[OrderController::class,'xenditOrder'])->name('xendit-order');

// Route Xendit Payment Callback
Route::get('/callback-xendit',[OrderController::class,'callbackXendit'])->name('callback-xendit');

// Route Xendit Payment Success
Route::get('/callback-xendit-success',[OrderController::class,'success'])->name('callback-xendit-success');
Route::get('/callback-xendit-failed',[OrderController::class,'failed'])->name('callback-xendit-failed');
