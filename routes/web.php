<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::group(
    ['prefix' => LaravelLocalization::setLocale(), 'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']],
    function () {
        Route::get('/', function() {
            return redirect()->route('admin.dashboard.index');
        })->name('website.index');

        Auth::routes();

        // Notifications
        Route::get('notifications/mark-as-read/{id}', 'NotificationController@markAsRead')->name('notifications.markAsRead');
        Route::get('notifications/mark-all-as-read', 'NotificationController@markAllAsRead')->name('notifications.markAllAsRead');
    }
);


