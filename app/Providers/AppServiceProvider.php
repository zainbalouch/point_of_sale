<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\ResponseFactory;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        ResponseFactory::macro('api', function($data = null, $error = 0, $message = '') {
            return response()->json([
                'data' => $data,
                'error' => $error,
                'message' => $message
            ]);
        });

        Paginator::useBootstrap();
    }
}
