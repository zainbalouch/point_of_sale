<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/register', 'AuthController@register');
Route::post('/login', 'AuthController@login');

// Properties
Route::post('/properties/search', 'PropertyController@search')->name('properties.search');
Route::get('/properties', 'PropertyController@index');

// Tags
Route::get('/tags', 'TagController@index');


Route::middleware('auth:sanctum')->group(function() {
    // Authentication
    Route::get('/logout', 'AuthController@logout');

    // User
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Properties
    Route::get('/properties/toggle-wishlist', 'PropertyController@toggleWishList');
});




