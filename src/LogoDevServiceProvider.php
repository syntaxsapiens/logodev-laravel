<?php

namespace Syntaxsapiens\LogoDev;

use Illuminate\Support\ServiceProvider;

class LogoDevServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('logodev', function ($app) {
            return new LogoDev;
        });
    }

    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/logodev.php' => config_path('logodev.php'),
        ], 'logodev-laravel-config');
    }
}
