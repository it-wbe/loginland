<?php

namespace Wbe\Loginland;

use Illuminate\Support\ServiceProvider;

class LoginServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        // load routes
        $this->loadRoutesFrom(__DIR__ . '/routes.php');
        $this->loadViewsFrom(__DIR__ . '/views', 'loginland');
        $this->loadTranslationsFrom(__DIR__ . '/../lang', 'loginland');
        $this->loadMigrationsFrom(__DIR__ . '/../migrations');

        $this->publishes([
            __DIR__ . '/../public/assets' => public_path('packages/wbe/loginland/assets'),
        ], 'public');

        $this->publishes([
            __DIR__ . '/../config/login.php' => config_path('login.php'),
            __DIR__ . '/../config/services.php' => config_path('services.php'),
        ], 'config');
        $this->app['view']->addNamespace('loginland', base_path() . '/vendor/wbe/loginland/views');

//        dd($this->app['view']);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
    }
}
