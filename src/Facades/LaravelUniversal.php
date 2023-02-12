<?php

namespace Asddaniel\UniversalLaravel\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Asddaniel\LaravelPackageSkeleton\LaravelPackageSkeleton
 */
class LaravelUniversal extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Asddaniel\UniversalLaravel\LaravelUniversal::class;
    }
}
