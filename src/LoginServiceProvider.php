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
        $this->loadViewsFrom(__DIR__ . '/views', 'loginlang');
        $this->loadTranslationsFrom(__DIR__ . '/../lang', 'loginlang');
        $this->loadMigrationsFrom(__DIR__ . '/../migrations');

        $this->publishes([
            __DIR__ . '/../public/assets' => public_path('packages/wbe/loginlang/assets'),
        ], 'public');

        $this->app['view']->addNamespace('login', base_path() . '/vendor/wbe/loginlang/views');
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
