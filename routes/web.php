<?php

use App\Http\Controllers\InvoiceController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

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
            return redirect()->route('filament.admin.auth.login');
        })->name('website.index');

        Auth::routes();

        // Notifications
        Route::get('notifications/mark-as-read/{id}', 'NotificationController@markAsRead')->name('notifications.markAsRead');
        Route::get('notifications/mark-all-as-read', 'NotificationController@markAllAsRead')->name('notifications.markAllAsRead');

        Route::get('order-invoice/{order}', [InvoiceController::class, 'showOrderInvoice'])->name('order.invoice.show');
        Route::get('invoice/{invoice}', [InvoiceController::class, 'showInvoice'])->name('invoice.show');

    }
);


