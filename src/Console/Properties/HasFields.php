<?php

namespace Appstract\Crud\Console\Properties;

trait HasFields
{
    /**
     * [getModelInput description].
     * @return [type] [description]
     */
    public function getFieldsInput()
    {
        return $this->hasArgument('fields')
            ? $this->argument('fields')
            : ($this->option('fields') ?: null);
    }

    /**
     * [getModel description].
     * @param  [type] $name [description]
     * @return [type]       [description]
     */
    public function getFields()
    {
        $fields = $this->getFieldsInput() ? explode(';', $this->getFieldsInput()) : [];

        $array = [];

        foreach($fields as $field) {
            $field = collect(explode('#', $field));

            $array[$field->get(0)] = $field->get(1);
        }

        return collect($array);
    }

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
}
