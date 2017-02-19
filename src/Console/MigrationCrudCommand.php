<?php

namespace Appstract\Crud\Console;

use Symfony\Component\Console\Input\InputOption;

class MigrationCrudCommand extends CrudCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'crud:migration
                            {name : Name of the model.}
                            {--p|prompt : Run in prompt}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new CRUD migration';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Migration';

    /**
     * Get the destination class path.
     *
     * @param  string  $name
     * @return string
     */
    protected function getPath($name)
    {
        $fullModelClass = $this->parseModel($this->argument('name'));
        $modelClass     = class_basename($fullModelClass);
        $modelPlural    = strtolower(str_plural($modelClass));

        $name = str_replace($this->laravel->getNamespace(), '', $modelPlural);
        $date = date('Y_m_d_His');

        return database_path('/migrations/').$date.'_create_'.$name.'_table.php';
    }

    /**
     * Build the class with the given name.
     *
     * @param  string  $name
     * @return string
     */
    protected function buildClass($name)
    {
        $fullModelClass = $this->parseModel($this->argument('name'));
        $modelClass     = class_basename($fullModelClass);
        $modelPlural    = strtolower(str_plural($modelClass));

        $this->replace = [
            '{{{table}}}' => $modelPlural,
            '{{{schema}}}' => $this->parseSchema()
        ];

        return parent::buildClass($name);
    }

    /**
     * [parseSchema description]
     * @return [type] [description]
     */
    public function parseSchema()
    {
        return '';
    }

    /**
     * Prompt.
     *
     * @return void
     */
    protected function prompt($prepend = [])
    {
        parent::prompt([
            'model' => $this->argument('name')
        ]);
    }
}