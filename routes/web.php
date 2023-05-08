<?php

use Illuminate\Support\Facades\Route;

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
    $rest_api_url = 'http://management-vmond.test/api/v1/vmond/tokoonline/resto';
    $rest_api_biliard = 'http://management-vmond.test/api/v1/vmond/tokoonline/biliard';
    // Reads the JSON file.
    $json_data = file_get_contents($rest_api_url);
    $json_data_biliard = file_get_contents($rest_api_biliard);
    // Decodes the JSON data into a PHP array.
    $response_data = json_decode($json_data);
    $response_data_biliard = json_decode($json_data_biliard);

    return view('homepage.index', compact(['response_data','response_data_biliard']));
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

Route::get('/detailmenu', function () {
    return view('detail-menu.index');
})->name('detail-menu');

Route::get('/reservation', function () {
    return view('reservation.index');
})->name('reservation');

Route::get('/cart', function () {
    return view('cart.index');
})->name('cart');

Route::get('/checkout', function () {
    return view('checkout.index');
})->name('checkout');

Route::get('/checkout', function () {
    return view('checkout.index');
})->name('checkout');
