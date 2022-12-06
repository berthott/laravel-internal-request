<?php

namespace berthott\InternalRequest\Tests\BasicRequest;

use Illuminate\Support\Facades\Route;

class InternalRequestTest extends TestCase
{
    public function test_routes_exist(): void
    {
        $expectedRoutes = [
            'internal.get',
            'internal.post',
            'external.get',
            'external.post',
        ];
        $registeredRoutes = array_keys(Route::getRoutes()->getRoutesByName());
        foreach ($expectedRoutes as $route) {
            $this->assertContains($route, $registeredRoutes);
        }
    }

    public function test_internal_get_request(): void
    {
        $route = $this->get(route('external.get'))->assertSuccessful();
        $this->assertSame('InternalRoute', $route->content());
    }

    public function test_internal_post_request(): void
    {
        $route = $this->post(route('external.post', ['test_param' => 123]))->assertSuccessful();
        $this->assertSame('123', $route->content());
    }
}
