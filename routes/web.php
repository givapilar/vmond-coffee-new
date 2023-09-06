<?php

use App\Http\Controllers\APIController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartOrdersController;
use App\Http\Controllers\DaftarMenuController;
use App\Http\Controllers\DetailController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\HomepageController;
use App\Models\Banner;
use App\Models\CartOrders;
use Illuminate\Support\Facades\Auth;

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
    if (Auth::check()) {
        return redirect()->route('homepage');
    }
    return view('Auth.login');
});
Route::get('/register', [RegisterController::class, 'index'])->name('register');
Route::post('/register', [RegisterController::class, 'store'])->name('register');

Route::get('/home', [HomepageController::class, 'index'])->name('homepage');

Route::get('/create-qris', [OrderController::class, 'createQris'])->name('createQris');

// daftar menu
Route::get('/daftarmenu/restaurant', [DaftarMenuController::class, 'restaurant'])->name('daftar-restaurant');
// Detial Resto
// Route::get('/daftarmenu/detail-resto/{$id}', [DetailController::class, 'restaurant'])->name('detail-resto');
Route::get('/daftarmenu/restaurant/{id}/{category}', [DetailController::class, 'detailRestaurant'])->name('detail-resto');
Route::get('/daftarmenu/billiard/{id}', [DetailController::class, 'detailBilliard'])->name('detail-billiard');
Route::get('/daftarmenu/billiard-guest/{id}', [DetailController::class, 'detailBilliardGuest'])->name('detail-billiard-guest');
Route::get('/daftarmenu/meeting-room/{id}', [DetailController::class, 'detailMeeting'])->name('detail-meeting');

Route::get('/daftarmenu/biliard', [DaftarMenuController::class, 'biliard'])->name('daftar-billiard');
// Route::get('/daftarmenu/billiard', function () {
//     return view('daftarmenu.billiard');
// })->name('daftar-billiard');

Route::get('/daftarmenu/meetingroom', [DaftarMenuController::class, 'meetingRoom'])->name('daftar-meeting-room');

// Route::get('/daftarmenu/meetingroom', function () {
//     return view('daftarmenu.meeting-room');
// })->name('daftar-meeting-room');

Route::get('/detailmenu/{type}/{slug}', function (Request $request,$type, $slug) {
    $global_url = 'https://managementvmond.controlindo.com/api/v1/vmond/tokoonline/detail/';
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

Route::get('/restaurant/menu', function () {
    $data['banners'] = Banner::get();
    return view('homepage.restaurant', $data);
})->name('homepage-restaurant');

Route::get('/aktivasi-bjb', function () {
    return view('aktivasi-bjb.index');
});

Route::post('/aktivasi-bjb',[APIController::class,'aktivasi'])->name('aktivasi');

// User-profile
// Route::get('/user-profile', [UserController::class, 'userProfile'])->name('user-profile');
Route::get('/user-profile/edit/{id}', [UserController::class, 'edit'])->name('edit-account');
Route::patch('/user-profile/{id}', [UserController::class, 'update'])->name('update-account');

// Restaurant Cart
Route::get('/add-chart-restaurant/{id}',[CartOrdersController::class, 'addCartRestaurant'])->name('restaurant-cart');
// Route::post('/add-chart-restaurant/{id}',[CartOrdersController::class, 'addCartRestaurant'])->name('restaurant-cart');
Route::get('/cart',[CartOrdersController::class, 'index'])->name('cart');
Route::post('/cart-update',[CartOrdersController::class, 'updateCart'])->name('cart-update');
// Route::patch('cart-update', [CartOrdersController::class, 'updateCart'])->name('cart-update');
Route::post('/cart-update-guest',[CartOrdersController::class, 'updateCartGuest'])->name('cart-update-guest');
Route::get('/delete-chart-restaurant/{id}',[CartOrdersController::class, 'deleteCartRestaurant'])->name('delete-restaurant-cart');

// Biliard
// Route::get('cart_biliard/{id}/edit', [CartOrdersController::class, 'editBiliard'])->name('cart-biliard-edit');
Route::get('/cart-billiard',[CartOrdersController::class, 'viewCartBilliard'])->name('cart-billiard');
Route::get('/cart-billiard/{id}',[CartOrdersController::class, 'addCartBilliard'])->name('add-cart-billiard');
Route::get('cart_billiard/{id}/edit', [CartOrdersController::class, 'editBilliard'])->name('edit-cart-billiard');
Route::get('/delete-chart-biliard/{id}',[CartOrdersController::class, 'deleteCartBilliard'])->name('delete-cart-billiard');

// Meeting Room Cart
// Route::post('/add-chart',[CartOrdersController::class, 'addCart'])->name('add-chart');
Route::get('/cart-meeting',[CartOrdersController::class, 'viewCartMeetingRoom'])->name('cart-meeting-room');
Route::get('/cart-meeting-room/{id}',[CartOrdersController::class, 'addCartMeeting'])->name('add-cart-meeting-room');
Route::get('cart_meeting-room/{id}/edit', [CartOrdersController::class, 'editMeeting'])->name('edit-cart-meeting-room');
Route::get('/delete-chart/{id}',[CartOrdersController::class, 'deleteCart'])->name('delete-cart');



// Route Midtrans
Route::get('midtrans',[CartOrdersController::class,'midtransCheck'])->name('midtrans-check');

// Route Orders
Route::get('orders',[OrderController::class,'index'])->name('order.index');
// Route::post('/checkout-order',[OrderController::class,'checkout'])->name('checkout-order');
Route::post('/checkout/{token}',[OrderController::class,'checkout'])->name('checkout-order');
Route::post('/checkout-guest/{token}',[OrderController::class,'checkoutGuest'])->name('checkout-order-guest');
Route::post('/checkout-billiard/{token}',[OrderController::class,'checkoutBilliard'])->name('checkout-billiard');
Route::post('/checkout-billiard-guest/{token}',[OrderController::class,'checkoutBilliardGuest'])->name('checkout-billiard-guest');
Route::post('/checkout-meeting',[OrderController::class,'checkoutMeeting'])->name('checkout-meeting');
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


// Cek Schedule Untuk Checkout
Route::post('/check-schedule',[APIController::class,'checkDateSchedule'])->name('check-schedule');
Route::post('/check-schedule-meeting',[APIController::class,'checkDateScheduleMeeting'])->name('check-schedule-meeting');

Route::post('/data/success-order',[OrderController::class,'successOrder'])->name('success-order');

// Success order Waiters
Route::post('/checkout/checkout-waiters/{token}',[OrderController::class,'checkoutWaiters'])->name('checkout-waiters');

// delete meja id
Route::get('/checkout/destroy',[OrderController::class,'resetMeja'])->name('reset-meja');