<?php

namespace Appstract\Crud\Console;

class ModelCrudCommand extends GeneratorCommand
{
    use Properties\HasModel,
        Properties\HasPrimaryKey,
        Properties\HasTableName,
        Properties\HasFillable,
        Properties\HasRelations;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'crud:model
                            {name : Name of the class}
                            {--p|prompt : Run in prompt}
                            {--t|table= : The name of the table}
                            {--fillable= : The names of the fillable columns}
                            {--relations= : The relations for the model}
                            {--primary=id : The name of the primary key}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new CRUD model';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Model';

    /**
     * Build the class with the given name.
     *
     * @param  string  $name
     * @return string
     */
    protected function replace($name)
    {
        $this->replace = [
            '{{{table}}}'      => $this->getTableName(),
            '{{{primaryKey}}}' => $this->getPrimaryKey(),
            '{{{fillable}}}'   => $this->getFillable(),
            '{{{relations}}}'  => $this->getRelations(),
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
        $this->info('Creating model: '.$this->getNameInput());

        $this->setOption('table', $this->ask('Table name', $this->getTableName()));

        $this->setOption('fillable', $this->ask('Fillable', $this->getOption('fillable', false)));

        $this->setOption('relations', $this->ask('Relations', $this->getOption('relations', false)));

        $this->setOption('primary', $this->ask('Primary key', $this->getOption('primary', 'id')));

        parent::prompt([
            'model' => $this->argument('name'),
        ]);
    }
}
