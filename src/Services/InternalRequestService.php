<?php

namespace berthott\InternalRequest\Services;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Wrapper around Illuminate\Http\Request.
 */
class InternalRequestService
{
    protected bool $skipMiddleware = false;

    /**
     * Constructor
     *
     * @param Application $app        The app instance.
     * @return void
     */
    public function __construct(protected Application $app)
    {
    }

    /**
     * Run an internal request and return it's result.
     * 
     * @api
     */
    public function request(string $action, string $route, array $data = [], Authenticatable $user = null): Response
    {
        $request = Request::create($route, $action, $data, [], [], [
            'HTTP_ACCEPT' => 'application/json',
            'HTTP_HOST' => 'internal'
        ]);
        $request->headers->add(request()->headers->all());
        $request->setUserResolver(fn () => $user);
        $response = $this->app->handle($request);
        $this->skipMiddleware = false;
        return $response;
    }

    /**
     * Whether the middleware should be skipped for this request.
     * 
     * @see \berthott\InternalRequest\InternalRequestServiceProvider::register()
     * @link https://github.com/laravel/framework/blob/aef89589ea70e0081c139b06550220cc75f20ea6/src/Illuminate/Routing/Router.php#L791 middleware.disable
     */
    public function isMiddlewareDisabled(): bool
    {
        return $this->skipMiddleware;
    }

    /**
     * Skip the middleware for this request.
     * 
     * @see \berthott\InternalRequest\InternalRequestServiceProvider::register()
     * @link https://github.com/laravel/framework/blob/aef89589ea70e0081c139b06550220cc75f20ea6/src/Illuminate/Routing/Router.php#L791 middleware.disable
     * @api
     */
    public function skipMiddleware($skip = true): self
    {
        $this->skipMiddleware = $skip;
        return $this;
    }

    /**
     * Convenience wrapper for get requests.
     * 
     * @api
     */
    public function get(string $route, array $data = [], Authenticatable $user = null): Response
    {
        return $this->request('GET', $route, $data, $user);
    }

    /**
     * Convenience wrapper for get requests.
     * 
     * @api
     */
    public function post(string $route, array $data = [], Authenticatable $user = null): Response
    {
        return $this->request('POST', $route, $data, $user);
    }

    /**
     * Convenience wrapper for get requests.
     * 
     * @api
     */
    public function put(string $route, array $data = [], Authenticatable $user = null): Response
    {
        return $this->request('PUT', $route, $data, $user);
    }

    /**
     * Convenience wrapper for get requests.
     * 
     * @api
     */
    public function delete(string $route, array $data = [], Authenticatable $user = null): Response
    {
        return $this->request('DELETE', $route, $data, $user);
    }
}
