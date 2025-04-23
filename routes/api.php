<?php

use App\Http\Controllers\PurchaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/paypal/create-payment' , [PurchaseController::class , 'createPayment']);
Route::post('/paypal/execute-payment' , [PurchaseController::class , 'executePayment']);
