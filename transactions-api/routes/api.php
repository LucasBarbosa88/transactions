<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ClientController;
use App\Http\Controllers\Api\TransactionController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('/login',[AuthController::class,'login']);

Route::middleware('auth:sanctum')->group(function(){
    Route::get('/me',[AuthController::class,'me']);
    Route::post('/logout',[AuthController::class,'logout']);

    Route::post('/client',[ClientController::class,'store']);
    Route::get('/clients',[ClientController::class,'index']);
    Route::get('/clients/{client}',[ClientController::class,'show']);
    Route::post('/clients/{client}/transactions',[TransactionController::class,'store']);
});

