<?php

namespace Appstract\Crud;

use Appstract\Crud\Console\ModelMakeCommand;
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
                ModelMakeCommand::class,
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
