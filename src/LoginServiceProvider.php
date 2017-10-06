<?php

namespace Wbe\Login;

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
        //include __DIR__.'/routes.php';
        $this->loadRoutesFrom(__DIR__ . '/routes.php');
        $this->loadViewsFrom(__DIR__ . '/views', 'login');
        $this->loadTranslationsFrom(__DIR__ . '/../lang', 'login');
        $this->loadMigrationsFrom(__DIR__ . '/../migrations');

        $this->publishes([
            __DIR__ . '/../public/assets' => public_path('packages/wbe/login/assets'),
        ], 'public');

        $this->app['view']->addNamespace('login', base_path() . '/vendor/wbe/login/views');
        //assets
        //$this->publishes([__DIR__.'/../public/assets' => public_path('packages/zofe/rapyd/assets')], 'assets');

    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        // load routes
        /*include __DIR__.'/routes.php';

        $this->loadRoutesFrom(__DIR__ . '/routes.php');
        $this->loadViewsFrom(__DIR__ . '/views/', 'crud');*/
    }

    /**
     * Register helpers file
     */
//    public function registerHelper($fn)
//    {
//        // Load the helpers in app/Http/helpers.php
//        if (file_exists($file = $fn)) {
//            require $file;
//        } else die('no helper found: ' . $file);
//    }
}
