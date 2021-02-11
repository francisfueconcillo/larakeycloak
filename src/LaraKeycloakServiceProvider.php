<?php

namespace PepperTech\LaraKeycloak;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Auth;

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
        $this->publishes([ 
            __DIR__ . '/../resources/Controllers' => app_path('Http/Controllers'),
            __DIR__ . '/../resources/Policies' => app_path('Policies'),
            __DIR__ . '/../resources/views' => resource_path('views'),
        ], 'larakeycloak');
    }
}
