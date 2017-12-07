<?php

namespace Loid\Module\Manager\Role\Support\Facades\Logic;

use Loid\Module\Manager\Role\Logic\Role as LogicRole;
use Illuminate\Support\Facades\Facade;

class Role extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return LogicRole::class;
    }
}
