<?php

namespace Appstract\Crud\Console;

class ControllerCrudCommand extends GeneratorCommand
{
    use Properties\HasModel;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'crud:controller
                            {name : Name of the class}
                            {--model= : Name of the model}
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

        $model = $this->getModel();

        $this->replace = [
            "use {$controllerNamespace}\Controller;\n" => '',
            '{{{view}}}' => $model->plural,
            '{{{route}}}' => $model->plural,
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
