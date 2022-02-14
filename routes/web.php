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

Route::get('login-page','LoginController@loginPage')->name('login');
Route::post('/login-page', 'LoginController@login')->name('user.login');
Route::get('logout', 'LoginController@logout')->name('user.logout');
Route::group(['middleware'=>'auth:web'], function(){
    Route::get('dashboard', 'LoginController@dashboard')->name('dashboard');
});

Route::group(['namespace'=>'Api'], function(){
    //imgur
    Route::post('/get/access/token','ImageController@getAccessToken')->name('access.token');
    Route::post('/upload/image','ImageController@upload')->name('upload.image');
    Route::post('/check/album','ImageController@getAlbum')->name('check.album');
    
    //social-login
    Route::group(['prefix'=>'social'], function(){
        Route::group(['prefix'=>'line'], function(){
            Route::get('/', 'SocialLoginController@line')->name('line.login');
            Route::get('callback', 'SocialLoginController@lineCallback')->name('line.callback');
        });
        Route::group(['prefix'=>'google'], function(){
            Route::get('/', 'SocialLoginController@google')->name('google.login');
            Route::get('callback', 'SocialLoginController@googleCallback')->name('google.callback');
        });
        Route::group(['prefix'=>'facebook'], function(){
            Route::get('/', 'SocialLoginController@facebook')->name('facebook.login');
            Route::get('callback', 'SocialLoginController@facebookCallback')->name('facebook.callback');
        });
    });
});
