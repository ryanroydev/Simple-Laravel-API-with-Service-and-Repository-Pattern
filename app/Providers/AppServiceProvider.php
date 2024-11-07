<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Response;
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
        
         Response::macro('success', function ($message = '', $data = null, $statusCode = 200) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'data' => $data
            ], $statusCode);
        });

        
        Response::macro('error', function ($message, $statusCode = 400) {
            return response()->json([
                'success' => false,
                'message' => $message,
            ], $statusCode);
        });
    }
}
