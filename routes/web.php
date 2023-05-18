<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartOrdersController;
use App\Http\Controllers\UserController;

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
Route::get('/', function () {
    return view('auth.login');
});

Route::get('/home', function () {
    $global_url = 'http://management-vmond.test/api/v1/vmond/tokoonline/';
    $rest_api_url = $global_url .'resto';
    $rest_api_biliard = $global_url .'biliard';
    $rest_api_meeting_room = $global_url .'meetingroom';
    $rest_api_banner = $global_url .'banner';
    // Reads the JSON file.
    try {
        $json_data = file_get_contents($rest_api_url);
        $json_data_biliard = file_get_contents($rest_api_biliard);
        $json_data_meeting_room = file_get_contents($rest_api_meeting_room);
        $json_data_banner = file_get_contents($rest_api_banner);
        // Decodes the JSON data into a PHP array.
        $response_data = json_decode($json_data);
        $response_data_biliard = json_decode($json_data_biliard);
        $response_data_meeting_room = json_decode($json_data_meeting_room);
        $response_data_banner = json_decode($json_data_banner);
    } catch (\Throwable $th) {
        $response_data = [];
        $response_data_biliard =[];
        $response_data_meeting_room =[];
        $response_data_banner =[];
    }

    return view('homepage.index', compact(['response_data','response_data_biliard','response_data_meeting_room','response_data_banner']));
})->name('homepage');

Route::get('/daftarmenu/restaurant', function () {
    return view('daftarmenu.restaurant');
})->name('daftar-restaurant');

Route::get('/daftarmenu/billiard', function () {
    return view('daftarmenu.billiard');
})->name('daftar-billiard');

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

// Route::get('/cart', function () {
//     return view('cart.index');
// })->name('cart');

Route::get('/checkout', function () {
    return view('checkout.index');
})->name('checkout');

// Route::get('/checkout', function () {
//     return view('checkout.index');
// })->name('checkout');

// Route::get('/profile-user', function () {
//         return view('user.profile');
//     })->name('user-profile');

// Cart Meeting Room
Route::get('/cart-meeting', function () {
    return view('cart.meeting-room');
})->name('cart-meeting-room');

// User-profile
// Route::get('/user-profile', [UserController::class, 'userProfile'])->name('user-profile');
Route::resource('/users', UserController::class);

// Meeting Room Cart
// Route::post('/add-chart',[CartOrdersController::class, 'addCart'])->name('add-chart');
Route::get('/cart-meeting-room/{id}',[CartOrdersController::class, 'addCartMeeting'])->name('add-chart');
Route::get('/cart-meeting',[CartOrdersController::class, 'viewCartMeetingRoom'])->name('cart-meeting-room');
Route::get('/delete-chart/{id}',[CartOrdersController::class, 'deleteCart'])->name('delete-cart');
Route::get('cart_meeting-room/{id}/edit', [CartOrdersController::class, 'editMeeting'])->name('cart-meeting-edit');

// Biliard
Route::get('cart_biliard/{id}/edit', [CartOrdersController::class, 'editBiliard'])->name('cart-biliard-edit');


// Restaurant Cart
Route::get('/add-chart-restaurant/{id}',[CartOrdersController::class, 'addCartRestaurant'])->name('restaurant-cart');
Route::get('/cart',[CartOrdersController::class, 'index'])->name('cart');
Route::get('/delete-chart-restaurant/{id}',[CartOrdersController::class, 'deleteCartRestaurant'])->name('delete-restaurant-cart');

