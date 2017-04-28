<?php

namespace Appstract\Crud;

use Illuminate\Support\ServiceProvider;

class CrudServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/crud.php' => config_path('crud.php'),
            ], 'config');

            $this->commands([
                \Appstract\Crud\Console\ModelCrudCommand::class,
                \Appstract\Crud\Console\ControllerCrudCommand::class,
                \Appstract\Crud\Console\MigrationCrudCommand::class,
                \Appstract\Crud\Console\ViewCrudCommand::class,
            ]);
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/crud.php', 'crud');
    }
}
