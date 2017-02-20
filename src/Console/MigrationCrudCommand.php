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
                            {--table= : Table name.}
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
        $name = $this->parseTableName($name);

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
        $model = $this->getModel($name);

        $this->replace = [
            '{{{table}}}' => $this->parseTableName($model->modelPlural),
            '{{{schema}}}' => $this->parseSchema()
        ];

        return parent::buildClass($name);
    }

    /**
     * [parseTableName description]
     * @param  [type] $name [description]
     * @return [type]       [description]
     */
    public function parseTableName($name)
    {
        $model = $this->getModel($name);

        $table = str_replace($this->laravel->getNamespace(), '', $model->modelPlural);

        return $this->getOption('table', $table);
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