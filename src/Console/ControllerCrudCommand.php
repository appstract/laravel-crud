<?php

namespace Appstract\Crud\Console;

use Appstract\Crud\Console\Generators\GeneratorCommand;
use Appstract\Crud\Console\Properties\HasModel;

class ControllerCrudCommand extends CrudCommand
{
    use HasModel;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'crud:controller
                            {name : Name of the class}
                            {model : Name of the model}
                            {--p|prompt : Run in prompt}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new CRUD controller';

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
    protected function replace($name)
    {
        $controllerNamespace = $this->getNamespace($name);

        $model = $this->getModel($this->getModelInput());

        $this->replace = [
            "use {$controllerNamespace}\Controller;\n" => '',

            '{{{fullModelClass}}}' => $model->fullModelClass,
            '{{{modelClass}}}'     => $model->modelClass,
            '{{{modelVariable}}}'  => lcfirst($model->modelClass),
            '{{{modelPlural}}}'    => $model->modelPlural,
            '{{{modelSingular}}}'  => strtolower($model->modelClass),
            '{{{view}}}'           => $model->modelPlural,
            '{{{route}}}'          => $model->modelPlural,
        ];

        return parent::replace($name);
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
            'model'      => $this->argument('model'),
        ]);
    }
}
