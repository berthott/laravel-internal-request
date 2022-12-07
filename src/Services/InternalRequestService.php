<?php

namespace berthott\InternalRequest\Services;

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

class InternalRequestService
{
    /**
     * The app instance
     *
     * @var $app
     */
    protected $app;

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

    public function request(string $action, string $route, array $data = [])
    {
        $request = Request::create($route, $action, $data, [], [], [
            'HTTP_ACCEPT' => 'application/json',
            'HTTP_HOST' => 'internal'
        ]);
        $request->headers->add(request()->headers->all());
        return $this->app->handle($request);
    }

    public function get(string $route, array $data = [])
    {
        return $this->request('GET', $route, $data);
    }

    public function post(string $route, array $data = [])
    {
        return $this->request('POST', $route, $data);
    }

    public function put(string $route, array $data = [])
    {
        return $this->request('PUT', $route, $data);
    }

    public function delete(string $route, array $data = [])
    {
        return $this->request('DELETE', $route, $data);
    }
}
