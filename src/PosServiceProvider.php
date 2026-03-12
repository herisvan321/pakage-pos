<?php

namespace Herisvanhendra\Pos;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\ServiceProvider;
use Spatie\Permission\PermissionServiceProvider;

class PosServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->register(PermissionServiceProvider::class);
    }

    public function boot(Filesystem $filesystem)
    {
        $this->loadRoutesFrom(__DIR__ . '/routes/web.php');
        $this->loadViewsFrom(__DIR__ . '/resources/views', 'pos');
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');
        
        // Publish Spatie permission config
        $this->publishes([
            __DIR__ . '/../config/permission.php' => config_path('permission.php'),
        ], 'pos-config');

        // Publish migrations
        $this->publishes([
            __DIR__ . '/database/migrations' => database_path('migrations'),
        ], 'pos-migrations');

        // Publish views
        $this->publishes([
            __DIR__ . '/resources/views' => resource_path('views/vendor/pos'),
        ], 'pos-views');

        // Publish all package assets (config, migrations, views)
        $this->publishes([
            __DIR__ . '/../config/permission.php' => config_path('permission.php'),
            __DIR__ . '/database/migrations' => database_path('migrations'),
            __DIR__ . '/resources/views' => resource_path('views/vendor/pos'),
        ], 'pos-all');

        // Auto-publish Spatie permission config if not exists
        $this->publishSpatieConfig($filesystem);
    }

    protected function publishSpatieConfig(Filesystem $filesystem)
    {
        $spatieConfigPath = config_path('permission.php');
        
        if (!$filesystem->exists($spatieConfigPath)) {
            $this->publishes([
                __DIR__ . '/../config/permission.php' => $spatieConfigPath,
            ], 'pos-permission-config');
        }
    }
}

