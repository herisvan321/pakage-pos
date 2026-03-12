<?php

namespace Herisvanhendra\Pos;

use Illuminate\Support\ServiceProvider;

class PosServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->register(\Spatie\Permission\PermissionServiceProvider::class);
    }

    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/routes/web.php');
        $this->loadViewsFrom(__DIR__ . '/resources/views', 'pos');
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');
        
        $this->publishes([
            __DIR__ . '/resources/views' => resource_path('views/vendor/pos'),
        ], 'pos-views');

        $this->publishes([
            __DIR__ . '/database/migrations' => database_path('migrations'),
        ], 'pos-migrations');
    }
}

