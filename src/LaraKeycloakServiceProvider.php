<?php

namespace PepperTech\LaraKeycloak;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;

class LaraKeycloakServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $router = $this->app->make(Router::class);
        $router->pushMiddlewareToGroup('web', AuthnMiddleware::class);
        $router->pushMiddlewareToGroup('api', AuthnMiddleware::class);
        
        $this->loadRoutesFrom(__DIR__.'/Routes.php');
    }
}
