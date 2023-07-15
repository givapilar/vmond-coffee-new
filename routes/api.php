<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Payment\XenditController;
use App\Http\Controllers\OrderController;

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
Route::post('/v1/feedback-customer/{token}/{id}',[OrderController::class,'feedback'])->name('feedback');
