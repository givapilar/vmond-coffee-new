<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;


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
    // Reads the JSON file.
    try {
        $json_data = file_get_contents($rest_api_url);
        $json_data_biliard = file_get_contents($rest_api_biliard);
        $json_data_meeting_room = file_get_contents($rest_api_meeting_room);
        // Decodes the JSON data into a PHP array.
        $response_data = json_decode($json_data);
        $response_data_biliard = json_decode($json_data_biliard);
        $response_data_meeting_room = json_decode($json_data_meeting_room);
    } catch (\Throwable $th) {
        $response_data = [];
        $response_data_biliard =[];
        $response_data_meeting_room =[];
    }

    return view('homepage.index', compact(['response_data','response_data_biliard','response_data_meeting_room']));
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

Route::get('/cart', function () {
    return view('cart.index');
})->name('cart');

Route::get('/checkout', function () {
    return view('checkout.index');
})->name('checkout');

Route::get('/checkout', function () {
    return view('checkout.index');
})->name('checkout');
