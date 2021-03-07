<?php

use App\Http\Controllers\AuthController;

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
        return response(null, 404);
    });

    Route::post('/auth/login', [AuthController::class, 'login']);

    Route::group(
        [
            'middleware' => ['auth:api', 'admin'],
            'namespace' => 'App\Http\Controllers\Admin',
            'prefix' => 'admin'
        ], function() {
            Route::resource('menu-links', 'MenuLinkController');
            Route::resource('review-attributes', 'ReviewAttributeController');
            Route::resource('reviews', 'ReviewController');
            Route::resource('reviews/{review}/comments', 'CommentController');
            Route::resource('reviews/{review}/ratings', 'RatingController');
            Route::resource('site-settings', 'SiteSettingController');
            Route::resource('users', 'UserController');
            Route::resource('widgets', 'WidgetController');
        }
    );
});


