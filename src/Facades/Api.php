<?php
/**
 * Created by PhpStorm.
 * User: isaacearl
 * Date: 4/26/15
 * Time: 12:45 AM
 */

namespace IsaacKenEarl\LaravelApi\Facades;


use Illuminate\Support\Facades\Facade;

class Api extends Facade
{

    protected static function getFacadeAccessor()
    {
        return 'api.service';
    }

}