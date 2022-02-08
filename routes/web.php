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

Route::get('/', function () { return view('imgur'); });
Route::get('/social-login', function () { return view('social'); });

Route::group(['namespace'=>'Api'], function(){
    //imgur
    Route::post('/get/access/token','ImageController@getAccessToken')->name('access.token');
    Route::post('/upload/image','ImageController@upload')->name('upload.image');
    Route::post('/check/album','ImageController@getAlbum')->name('check.album');
    //social-login
    Route::group(['prefix'=>'social'], function(){
        Route::post('/login', 'SocialLoginController@login')->name('user.login');
        Route::get('/logout', 'SocialLoginController@logout')->name('user.logout');
        Route::group(['prefix'=>'line'], function(){
            Route::get('/', 'SocialLoginController@line')->name('line.login');
            Route::get('callback', 'SocialLoginController@callback')->name('line.callback');
        });
    });
});
