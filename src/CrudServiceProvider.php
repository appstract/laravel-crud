<?php

namespace Appstract\Crud;

use Illuminate\Support\ServiceProvider;
use Appstract\Crud\Console\ModelMakeCommand;
use Appstract\Crud\Console\ControllerMakeCommand;

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
                ModelMakeCommand::class,
                ControllerMakeCommand::class,
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
