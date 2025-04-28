<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class BulkGateServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register()
    {
        // Register the BulkGateOTPService as a singleton
        $this->app->singleton(BulkGateOTPService::class, function ($app) {
            return new BulkGateOTPService();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
