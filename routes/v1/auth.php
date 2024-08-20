<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {

    Route::post('login',[AuthController::class ,'login']);
    Route::post('register',[AuthController::class ,'register']);
    Route::group([
        'middleware' => 'auth',
    ],function(){
        Route::post('refresh',[AuthController::class ,'refresh']);
        Route::post('logout', [AuthController::class ,'logout']);
    });
});