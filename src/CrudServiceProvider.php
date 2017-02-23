<?php

namespace Appstract\Crud;

use Illuminate\Support\ServiceProvider;
use Appstract\Crud\Console\ViewCrudCommand;
use Appstract\Crud\Console\ModelCrudCommand;
use Appstract\Crud\Console\MigrationCrudCommand;
use Appstract\Crud\Console\ControllerCrudCommand;

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
                ModelCrudCommand::class,
                ControllerCrudCommand::class,
                MigrationCrudCommand::class,
                ViewCrudCommand::class,
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
