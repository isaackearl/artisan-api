<?php
/**
 * Created by PhpStorm.
 * User: isaacearl
 * Date: 3/25/15
 * Time: 2:10 PM
 */

namespace IsaacKenEarl\LaravelApi\Providers;


use Illuminate\Support\ServiceProvider;
use IsaacKenEarl\LaravelApi\ApiService;
use IsaacKenEarl\LaravelApi\Interfaces\ApiServiceInterface;

class LaravelApiServiceProvider extends ServiceProvider
{

    public function boot()
    {
        $this->app['api.service'] = function ($app) {
            return $app[ApiServiceInterface::class];
        };
    }

    public function register()
    {
        $this->app->singleton(ApiServiceInterface::class, ApiService::class);
    }

}