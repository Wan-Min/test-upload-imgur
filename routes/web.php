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
    return view('welcome');
});

Route::group(['namespace'=>'Api'], function(){
    Route::post('/get/access/token','ImageController@getAccessToken')->name('access.token');
    Route::post('/upload/image','ImageController@upload')->name('upload.image');
    Route::post('/check/album','ImageController@getAlbum')->name('check.album');
});
