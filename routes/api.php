<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Payment\XenditController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentBriController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/xendit/va/list', [XenditController::class, 'getListVa']);
Route::post('/xendit/va/invoice', [XenditController::class, 'createVa']);
Route::post('/midtrans-callback',[OrderController::class,'callback'])->name('callback');
Route::post('/callback-bjb',[OrderController::class,'callbackBJB'])->name('callbackBJB');
Route::post('/v1/feedback-customer/{token}/{id}',[OrderController::class,'feedback'])->name('feedback');
Route::post('/data/success-order-bjb',[OrderController::class,'successOrderBJB'])->name('success-order-bjb');
Route::post('/data/success-order-bri',[OrderController::class,'successOrderBRI'])->name('success-order-bri');
Route::post('/data/checkData',[OrderController::class,'checkData'])->name('check-data');

// route
Route::get('/v1/create-qr-bri-endpoint/',[PaymentBriController::class,'endpoint'])->name('endpoint-bri');
