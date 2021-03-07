<?php

use App\Http\Controllers\MenuLinkController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SiteSettingController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WidgetController;
use App\Http\Controllers\ReviewAttributeController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\RatingController;


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

    Route::group(['middleware' => ['auth:api', 'admin']], function() {
        Route::get('/users', [UserController::class, 'index']);
        Route::post('/users', [UserController::class, 'store']);
        Route::get('/users/{user}',     [UserController::class, 'show']);
        Route::put('/users/{user}',     [UserController::class, 'update']);
        Route::delete('/users/{user}',  [UserController::class, 'destroy']);
    });

    Route::get('/sitesettings',                 [SiteSettingController::class, 'index']);
    Route::get('/sitesettings/{siteSetting}',   [SiteSettingController::class, 'show']);
    Route::put('/sitesettings/{siteSetting}',   [SiteSettingController::class, 'update']);

    Route::get('/menulinks',                [MenuLinkController::class, 'index']);
    Route::post('/menulinks',               [MenuLinkController::class, 'store']);
    Route::get('/menulinks/{menuLink}',     [MenuLinkController::class, 'show']);
    Route::put('/menulinks/{menuLink}',     [MenuLinkController::class, 'update']);
    Route::delete('/menulinks/{menuLink}',  [MenuLinkController::class, 'destroy']);

    Route::get('/reviews',              [ReviewController::class, 'index']);
    Route::post('/reviews',             [ReviewController::class, 'store']);
    Route::get('/reviews/{review}',     [ReviewController::class, 'show']);
    Route::put('/reviews/{review}',     [ReviewController::class, 'update']);
    Route::delete('/reviews/{review}',  [ReviewController::class, 'destroy']);

    Route::get('/widgets',              [WidgetController::class, 'index']);
    Route::post('/widgets',             [WidgetController::class, 'store']);
    Route::get('/widgets/{widget}',     [WidgetController::class, 'show']);
    Route::put('/widgets/{widget}',     [WidgetController::class, 'update']);
    Route::delete('/widgets/{widget}',  [WidgetController::class, 'destroy']);

    Route::get('/reviewattributes',                       [ReviewAttributeController::class, 'index']);
    Route::post('/reviewattributes',                      [ReviewAttributeController::class, 'store']);
    Route::get('/reviewattributes/{reviewAttribute}',     [ReviewAttributeController::class, 'show']);
    Route::put('/reviewattributes/{reviewAttribute}',     [ReviewAttributeController::class, 'update']);
    Route::delete('/reviewattributes/{reviewAttribute}',  [ReviewAttributeController::class, 'destroy']);

    Route::get('/reviews/{review}/comments',               [CommentController::class, 'index']);
    Route::post('/reviews/{review}/comments',              [CommentController::class, 'store']);
    Route::get('/reviews/{review}/comments/{comment}',     [CommentController::class, 'show']);
    Route::put('/reviews/{review}/comments/{comment}',     [CommentController::class, 'update']);
    Route::delete('/reviews/{review}/comments/{comment}',  [CommentController::class, 'destroy']);

    Route::get('/reviews/{review}/ratings',               [RatingController::class, 'index']);
    Route::post('/reviews/{review}/ratings',              [RatingController::class, 'store']);
    Route::get('/reviews/{review}/ratings/{rating}',     [RatingController::class, 'show']);
    Route::put('/reviews/{review}/ratings/{rating}',     [RatingController::class, 'update']);
    Route::delete('/reviews/{review}/ratings/{rating}',  [RatingController::class, 'destroy']);
});


