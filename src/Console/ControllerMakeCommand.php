<?php

namespace Appstract\Crud\Console;

use Illuminate\Support\Str;
use InvalidArgumentException;

class ControllerMakeCommand extends MakeCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'crud:controller
                            {name : Name of the class.}
                            {model : Name of the model}
                            {--p|prompt : Run in prompt}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new CRUD controller class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Controller';

    /**
     * Build the class with the given name.
     *
     * Remove the base controller import if we are already in base namespace.
     *
     * @param  string  $name
     * @return string
     */
    protected function buildClass($name)
    {
        $controllerNamespace = $this->getNamespace($name);

        $fullModelClass = $this->parseModel($this->argument('model'));

        $modelClass = class_basename($fullModelClass);

        $modelClassPlural = strtolower(str_plural($modelClass));

        $this->replace = [
            'DummyFullModelClass' => $fullModelClass,
            'DummyModelClass'     => $modelClass,
            'DummyModelVariable'  => lcfirst($modelClass),
            "use {$controllerNamespace}\Controller;\n" => '',

            '{{modelPlural}}'   => $modelClassPlural,
            '{{modelSingular}}' => strtolower($modelClass),
            '{{view}}'          => $modelClassPlural,
            '{{route}}'         => $modelClassPlural
        ];

        return parent::buildClass($name);
    }

    /**
     * Get the fully-qualified model class name.
     *
     * @param  string  $model
     * @return string
     */
    protected function parseModel($model)
    {
        if (preg_match('([^A-Za-z0-9_/\\\\])', $model)) {
            throw new InvalidArgumentException('Model name contains invalid characters.');
        }

        $model = trim(str_replace('/', '\\', $model), '\\');

        if (! Str::startsWith($model, $rootNamespace = $this->laravel->getNamespace())) {
            $model = $rootNamespace.$model;
        }

        return $model;
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\Http\Controllers';
    }

    /**
     * Prompt.
     *
     * @return void
     */
    protected function prompt($append = [])
    {
        $this->info('Creating controller: '.$this->getNameInput());

        parent::prompt([
            'controller' => $this->argument('name'),
            'model'      => $this->argument('model')
        ]);
    }
}
