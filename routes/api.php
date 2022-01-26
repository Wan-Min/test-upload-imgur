<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::get('/clear/cache',function(){ 
    Artisan::call('cache:clear');   
    Artisan::call('config:clear');   
    Artisan::call('config:cache');   
    Artisan::call('route:clear');   
    Artisan::call('view:clear');   
    return response()->json([
        'result' => true  
    ]);
});