<?php

namespace berthott\InternalRequest\Facades;

use Illuminate\Support\Facades\Facade;

class InternalRequest extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'InternalRequest';
    }
}
