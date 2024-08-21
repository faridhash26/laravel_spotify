<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\player\SongController;

Route::group([
    'middleware' => 'api',
    'prefix' => 'v1/song'
],function ($router) {
    Route::group([
        'middleware' => 'auth',
    ],function(){ 
        Route::get('/',[SongController::class ,'index']);
        Route::get('/{id}',[SongController::class ,'view']);
        Route::delete('/{id}',[SongController::class ,'softDelete']);
        Route::delete('/remove/{id}',[SongController::class ,'deletePermanently']);
        Route::post('/',[SongController::class ,'create']);
    });
});