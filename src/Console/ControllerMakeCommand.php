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
    protected $name = 'crud:controller';

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

        $modelClass = $this->parseModel($this->option('model'));

        $this->replace = [
            'DummyFullModelClass' => $modelClass,
            'DummyModelClass'     => class_basename($modelClass),
            'DummyModelVariable'  => lcfirst(class_basename($modelClass)),
            "use {$controllerNamespace}\Controller;\n" => '',

            '{{table}}'      => $this->getTableName(),
            '{{primaryKey}}' => $this->option('primary'),
            '{{fillable}}'   => $this->parseFillable(),
            '{{relations}}'  => $this->parseRelations()
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
}
