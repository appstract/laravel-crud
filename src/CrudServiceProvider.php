<?php

namespace Appstract\Crud;

use Illuminate\Support\ServiceProvider;

use Appstract\Crud\Console;

class CrudServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                Console\ModelCrudCommand::class,
                Console\ControllerCrudCommand::class,
                Console\MigrationCrudCommand::class,
                Console\ViewsCrudCommand::class,
                Console\ViewCrudCommand::class,
            ]);
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        //
    }
}
