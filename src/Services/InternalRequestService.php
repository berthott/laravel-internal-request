<?php

namespace berthott\InternalRequest\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class InternalRequestService
{
    public function request(string $action, string $route, array $data = [])
    {
        $request = Request::create($route, $action, $data, [], [], [
            'HTTP_ACCEPT' => 'application/json',
            'HTTP_HOST' => 'internal'
        ]);
        $request->headers->add(request()->headers->all());
        return Route::dispatch($request)->content();
    }

    public function get(string $route, array $data = [])
    {
        return $this->request('GET', $route, $data);
    }

    public function post(string $route, array $data = [])
    {
        return $this->request('POST', $route, $data);
    }
}
