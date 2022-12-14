<?php

namespace berthott\InternalRequest\Services;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

class InternalRequestService
{
    /**
     * The app instance
     */
    protected Application $app;

    protected bool $skipMiddleware = false;

    /**
     * Constructor
     *
     * @param Application $app        The app instance.
     * @return void
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function request(string $action, string $route, array $data = [], Authenticatable $user = null)
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
     */
    public function isMiddlewareDisabled(): bool
    {
        return $this->skipMiddleware;
    }

    /**
     * Whether the middleware should be skipped for this request.
     */
    public function skipMiddleware($skip = true): self
    {
        $this->skipMiddleware = $skip;
        return $this;
    }

    public function get(string $route, array $data = [], Authenticatable $user = null)
    {
        return $this->request('GET', $route, $data, $user);
    }

    public function post(string $route, array $data = [], Authenticatable $user = null)
    {
        return $this->request('POST', $route, $data, $user);
    }

    public function put(string $route, array $data = [], Authenticatable $user = null)
    {
        return $this->request('PUT', $route, $data, $user);
    }

    public function delete(string $route, array $data = [], Authenticatable $user = null)
    {
        return $this->request('DELETE', $route, $data, $user);
    }
}
