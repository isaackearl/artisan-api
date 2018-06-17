<?php

namespace IsaacKenEarl\LaravelApi\Providers;


use Illuminate\Support\ServiceProvider;
use IsaacKenEarl\LaravelApi\ArtisanApiService;
use IsaacKenEarl\LaravelApi\Interfaces\ArtisanApiServiceInterface;
use Spatie\Fractal\FractalServiceProvider;

class ArtisanApiServiceProvider extends ServiceProvider
{

    public function boot()
    {

        $this->publishes([
            realpath(__DIR__ . '/../config/api.php') => config_path('api.php'),
        ]);

        $this->app['api.service'] = function ($app) {
            return $app[ArtisanApiServiceInterface::class];
        };
    }

    public function register()
    {
        $this->app->register(FractalServiceProvider::class);
        $this->app->singleton(ArtisanApiServiceInterface::class, ArtisanApiService::class);
    }

}