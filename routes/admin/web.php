<?php

use Illuminate\Support\Facades\Route;

Route::group(
    ['prefix' => LaravelLocalization::setLocale(), 'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']],
    function () {
        Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
            Route::get('/', function () {
                return redirect()->route('admin.dashboard.index');
            });
            // Dashboard
            Route::prefix('dashboard')->name('dashboard.')->group(function () {
                Route::get('/', 'DashboardController@index')->name('index');
            });

            // Product Categories
            Route::get('/product-categories/data', 'ProductCategoryController@data')->name('product_categories.data');
            Route::resource('product-categories', 'ProductCategoryController')->names('product_categories');

            // Products
            Route::get('/products/data', 'ProductController@data')->name('products.data');
            Route::resource('products', 'ProductController')->names('products');

            // Users
            Route::resource('users', 'UserController')->except(['show']);

            Route::get('/home', 'HomeController@index')->name('home');

            // Settings
            Route::prefix('settings')->name('settings.')->group(function () {
                Route::get('/general', 'SettingController@general')->name('general');
                Route::post('/store', 'SettingController@store')->name('store');
            });
        });
    }
);
