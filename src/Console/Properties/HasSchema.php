<?php

namespace Appstract\Crud\Console\Properties;

trait HasSchema
{
    /**
     * [getModelInput description].
     * @return [type] [description]
     */
    public function getSchemaInput()
    {
        return $this->hasArgument('schema')
            ? $this->argument('schema')
            : ($this->option('schema') ?: null);
    }

    /**
     * [parseSchema description].
     * @return [type] [description]
     */
    public function getSchema()
    {
        $columns = $this->getSchemaInput() ? explode(';', $this->getSchemaInput()) : [];

        $code = "\n\t\t\t".'$table->increments('.$this->wrapWithQuotes($this->getPrimaryKey()).');'."\n";

        foreach ($columns as $column) {
            $parts = collect(explode('#', $column));

            // Name available
            if (in_array($parts->get(1), $this->columnTypes)) {
                $code .= "\n\t\t\t".'$table->'.$parts->get(1).'('.$this->wrapWithQuotes($parts->get(0)).');';
            }

            // Empty function, eg timestamps
            else {
                $code .= "\n\t\t\t".'$table->'.$parts->get(0).'();'."\n";
            }
        }

        return $code;
    }

    /**
     *  Migration column types collection.
     *
     * @var array
     */
    protected $columnTypes = [
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
     * [$columnModifiers description].
     * @var [type]
     */
    protected $columnModifiers = [
        'after',
        'comment',
        'default',
        'first',
        'nullable',
        'storedAs',
        'unsigned',
        'virtualAs',
    ];
}
