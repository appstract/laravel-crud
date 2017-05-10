<?php

namespace Appstract\Crud\Console;

class MigrationCrudCommand extends GeneratorCommand
{
    use Properties\HasPrimaryKey,
        Properties\HasTableName,
        Properties\HasSchema;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'crud:migration
                            {name : Name of the model}
                            {--table= : Table name}
                            {--schema= : Table schema}
                            {--primary=id : Primary key}
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
        $name = $this->getTableName($name);

        $date = date('Y_m_d_His');

        return database_path('/migrations/').$date.'_create_'.$name.'_table.php';
    }

    /**
     * Build the class with the given name.
     *
     * @param  string  $name
     * @return string
     */
    protected function replace($name)
    {
        $this->replace = [
            '{{{table}}}' => $this->getTableName(),
            '{{{schema}}}' => $this->getSchema(),
        ];

        return parent::replace($name);
    }

    /**
     * Prompt.
     *
     * @return void
     */
    protected function prompt($prepend = [])
    {
        $this->info('Creating migration: '.$this->getNameInput());

        $this->setOption('table', $this->ask('Table name', $this->getTableName()));

        $this->setOption('schema', $this->ask('Schema', $this->getOption('schema')));

        $this->setOption('primary', $this->ask('Primary key', $this->getOption('primary', 'id')));

        parent::prompt([
            'model' => $this->argument('name'),
        ]);
    }
}
