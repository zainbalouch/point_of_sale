<?php

declare(strict_types=1);

use App\Http\Controllers\InvoiceController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

/*
|--------------------------------------------------------------------------
| Tenant Routes
|--------------------------------------------------------------------------
|
| Here you can register the tenant routes for your application.
| These routes are loaded by the TenantRouteServiceProvider.
|
| Feel free to customize them however you want. Good luck!
|
*/

Route::middleware([
    'web',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {
    Route::group(
        ['prefix' => LaravelLocalization::setLocale(), 'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']],
        function () {
            Route::get('/', function() {
                Artisan::call('filament:clear-cached-components');
                Artisan::call('optimize:clear');
                return redirect()->route('filament.admin.auth.login');
            })->name('website.index');

            Route::get('notifications/mark-as-read/{id}', 'NotificationController@markAsRead')->name('notifications.markAsRead');
            Route::get('notifications/mark-all-as-read', 'NotificationController@markAllAsRead')->name('notifications.markAllAsRead');

            Route::get('order-invoice/{order}', [InvoiceController::class, 'showOrderInvoice'])->name('order.invoice.show');
            Route::get('invoice/{invoice}', [InvoiceController::class, 'showInvoice'])->name('invoice.show');

            Auth::routes();

        }
    );

});
