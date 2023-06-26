<?php

namespace berthott\InternalRequest;

use berthott\InternalRequest\Facades\InternalRequest;
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
            return new InternalRequestService($this->app);
        });

        /**
         * disable middleware for internal request
         * 
         * @link https://github.com/laravel/framework/blob/aef89589ea70e0081c139b06550220cc75f20ea6/src/Illuminate/Routing/Router.php#L791 middleware.disable
         */
        $this->app->bind('middleware.disable', function () {
            return InternalRequest::isMiddlewareDisabled();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
    }
}
