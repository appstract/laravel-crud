<?php

namespace Appstract\Crud\Console;

class MigrationCrudCommand extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'crud:migration
                            {name : Name of the model.}
                            {--table= : Table name.}
                            {--schema= : Table schema.}
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
        $this->replace = [
            '{{{table}}}' => $this->parseTableName(),
            '{{{schema}}}' => $this->parseSchema(),
        ];

        return parent::buildClass($name);
    }

    /**
     * [parseTableName description].
     * @param  [type] $name [description]
     * @return [type]       [description]
     */
    public function parseTableName()
    {
        return str_replace($this->laravel->getNamespace(), '', $this->getNameInput());
    }

    /**
     * [parseSchema description].
     * @return [type] [description]
     */
    public function parseSchema()
    {
        $columns = $this->option('schema') ? explode(';', $this->option('schema')) : [];

        $code = "\n\t\t\t".'$table->increments('.$this->wrapWithQuotes($this->parsePrimaryKey()).');'."\n";

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
     * Prompt.
     *
     * @return void
     */
    protected function prompt($prepend = [])
    {
        $this->info('Creating migration: '.$this->getNameInput());

        $this->setOption('table', $this->ask('Table name', $this->parseTableName()));

        $this->setOption('schema', $this->ask('Schema', $this->getOption('schema')));

        $this->setOption('primary', $this->ask('Primary key', $this->getOption('primary', 'id')));

        parent::prompt([
            'model' => $this->argument('name'),
        ]);
    }
}
