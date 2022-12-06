<?php

namespace berthott\InternalRequest;

use berthott\InternalRequest\Services\InternalRequestService;
use Illuminate\Support\ServiceProvider;

class InternalRequestServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // bind singletons
        $this->app->singleton('InternalRequest', function () {
            return new InternalRequestService();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
    }
}
