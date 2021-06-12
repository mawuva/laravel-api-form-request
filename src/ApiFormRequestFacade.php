<?php

namespace Mawuekom\ApiFormRequest;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Mawuekom\ApiFormRequest\Skeleton\SkeletonClass
 */
class ApiFormRequestFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'api-form-request';
    }
}
