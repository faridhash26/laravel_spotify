<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\player\AlbumController;


Route::group([
    'middleware' => 'api',
    'prefix' => 'v1/album'
],function ($router) {
    Route::group([
        'middleware' => 'auth',
    ],function(){ 
        Route::get('/',[AlbumController::class ,'index']);
        Route::get('/{id}',[AlbumController::class ,'view']);
        Route::delete('/{id}',[AlbumController::class ,'softDelete']);
        Route::delete('/remove/{id}',[AlbumController::class ,'deletePermanently']);
        Route::post('/',[AlbumController::class ,'create']);
    });
});