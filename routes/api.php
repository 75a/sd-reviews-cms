<?php

use App\Http\Controllers\SiteSettingController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\MustBeAdmin;
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



Route::group(['prefix' => 'v1'], function () {
    Route::fallback(function(){
        return response()->json(['message' => 'Resource not Found'], 404);
    });

    Route::post('/auth/login', 'App\Http\Controllers\AuthController@login');

    Route::get('/users', [UserController::class, 'index']);
    Route::post('/users', [UserController::class, 'store']);
    Route::group(['middleware' => ['auth:api', 'admin']], function() {
        Route::get('/users/{user}',     [UserController::class, 'show']);
        Route::put('/users/{user}',     [UserController::class, 'update']);
        Route::delete('/users/{user}',  [UserController::class, 'destroy']);
    });

    Route::get('/sitesettings',                 [SiteSettingController::class, 'index']);
    Route::get('/sitesettings/{siteSetting}',   [SiteSettingController::class, 'show']);
    Route::put('/sitesettings/{siteSetting}',   [SiteSettingController::class, 'update']);

});


