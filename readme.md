# Laravel-Internal-Request

Laravel Helper for running internal requests.

## Installation

```
$ composer require berthott/laravel-internal-request
```

## Usage

* Import the facade `berthott\InternalRequest\Facades\InternalRequest`
* For the API see `berthott\InternalRequest\Services\InternalRequestService`

```php
use berthott\InternalRequest\Facades\InternalRequest;

/**
 * Use any http method using the request() method.
 */
InternalRequest::request('GET', $route, $data, $user);

/**
 * Use one of the convenience methods get(), post(), put(), delete().
 */
InternalRequest::get($route, $data, $user);

/**
 * Disable all middleware for a single request.
 */
InternalRequest::disableMiddleware()->get($route, $data, $user);
```

## Compatibility

Tested with Laravel 10.x.

## License

See [License File](license.md). Copyright © 2023 Jan Bladt.