<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\player\AlbumController;


Route::group([
    'middleware' => 'api',
    'prefix' => 'album'
],function ($router) {
    Route::group([
        'middleware' => 'auth',
    ],function(){ 
        Route::get('/',[AlbumController::class ,'index']);
        Route::post('/',[AlbumController::class ,'create']);
    });
});