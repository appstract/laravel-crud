<?php

namespace Appstract\Crud\Console\View;

use Appstract\Crud\Console\ViewCrudCommand;

class ViewCommand extends ViewCrudCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'crud:view
                            {name : Name of the model.}
                            {--fields= : Fields}
                            {--p|prompt : Run in prompt}';

    /**
     *  Migration column types collection.
     *
     * @var array
     */
    protected $fieldTypes = [
        'bigIncrements',
        'bigInteger',
        'binary',
        'boolean',
        'char',
        'date',
        'dateTime',
        'dateTimeTz',
        'decimal',
        'double',
        'enum',
        'float',
        'increments',
        'integer',
        'ipAddress',
        'json',
        'jsonb',
        'longText',
        'macAddress',
        'mediumIncrements',
        'mediumInteger',
        'mediumText',
        'morphs',
        'nullableMorphs',
        'nullableTimestamps',
        'rememberToken',
        'smallIncrements',
        'smallInteger',
        'softDeletes',
        'string',
        'string',
        'text',
        'time',
        'timeTz',
        'tinyInteger',
        'timestamp',
        'timestampTz',
        'timestamps',
        'timestampsTz',
        'unsignedBigInteger',
        'unsignedInteger',
        'unsignedMediumInteger',
        'unsignedSmallInteger',
        'unsignedTinyInteger',
        'uuid',
    ];

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Index';

    /**
     * Build the class with the given name.
     *
     * @param  string  $name
     * @return string
     */
    protected function buildClass($name)
    {
        $this->replace = [
            '{{{blabla}}}' => 'blabla',
        ];

        return parent::buildClass($name);
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__.'/stubs/views/'.strtolower($this->type).'.stub';
    }

    /**
     * Get the destination class path.
     *
     * @param  string  $name
     * @return string
     */
    protected function getPath($name)
    {
        return $this->laravel->resourcePath().'/views/'.$name.'.php';
    }

    /**
     * Prompt.
     *
     * @return void
     */
    protected function prompt($prepend = [])
    {
        parent::prompt();
    }
}