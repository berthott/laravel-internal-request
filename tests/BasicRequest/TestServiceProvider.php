<?php

namespace berthott\InternalRequest\Tests\BasicRequest;

use berthott\InternalRequest\Facades\InternalRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class TestServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // add routes
        Route::get('/internal-route', function(Request $request) {
            return 'InternalRoute';
        })->name('internal.get');
        Route::get('/external-route', function() {
            return InternalRequest::get(route('internal.get'));
        })->name('external.get');
        Route::post('/internal-route', function(Request $request) {
            if ($request->has('test_param')) {
                return $request->test_param;
            }
            return 'no param';
        })->name('internal.post');
        Route::post('/external-route', function(Request $request) {
            return InternalRequest::post(route('internal.post'), $request->all());
        })->name('external.post');
    }
}
