<?php

namespace Sina\Shuttle\Facades;

use Illuminate\Support\Facades\Facade;

class Shuttle extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'shuttle';
    }
}
