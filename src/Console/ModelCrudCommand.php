<?php

namespace Appstract\Crud\Console;

class ModelCrudCommand extends CrudCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'crud:model
                            {name : Name of the class.}
                            {--p|prompt : Run in prompt}
                            {--t|table= : The name of the table.}
                            {--fillable= : The names of the fillable columns.}
                            {--relations= : The relations for the model}
                            {--primary=id : The name of the primary key.}';

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
    protected function buildClass($name)
    {
        $this->replace = [
            '{{{table}}}'      => $this->parseTableName(),
            '{{{primaryKey}}}' => $this->parsePrimaryKey(),
            '{{{fillable}}}'   => $this->parseFillable(),
            '{{{relations}}}'  => $this->parseRelations(),
        ];

        return parent::buildClass($name);
    }

    /**
     * Parse fillable.
     *
     * @return string
     */
    protected function parseFillable()
    {
        if (! $this->option('fillable')) {
            return "['']";
        }

        $explode = explode(';', $this->option('fillable'));

        return $this->wrapWithBrackets(implode("', '", $explode));
    }

    /**
     * Parse relations.
     *
     * @return string
     */
    protected function parseRelations()
    {
        $relations = $this->option('relations') ? explode(';', $this->option('relations')) : [];

        $code = null;

        foreach ($relations as $relation) {
            $parts = collect(explode('#', $relation));
            $args = collect(explode('|', $parts->last()));
            $class = $this->wrapWithQuotes($args->first());
            $args = $this->wrapWithQuotes($args->forget(0)->implode("', '", $args));
            $name = $parts->first();

            $code .= "/**\n     * ".ucfirst($name)." relation.\n     */\n    public function ".$name."()\n    {\n        ".'return $this->'.$parts->get(1)."($class".($args ? ", $args" : '').');'."\n    }\n\n";
        }

        return $code;
    }

    /**
     * Get table name.
     *
     * @return string
     */
    protected function parseTableName()
    {
        return $this->getOption('table', strtolower(str_plural($this->getNameInput())));
    }

    /**
     * Prompt.
     *
     * @return void
     */
    protected function prompt($prepend = [])
    {
        $this->info('Creating model: '.$this->getNameInput());

        $this->setOption('table', $this->ask('Table name', $this->parseTableName()));

        $this->setOption('fillable', $this->ask('Fillable', $this->getOption('fillable', false)));

        $this->setOption('relations', $this->ask('Relations', $this->getOption('relations', false)));

        $this->setOption('primary', $this->ask('Primary key', $this->getOption('primary', 'id')));

        parent::prompt([
            'model' => $this->argument('name'),
        ]);
    }
}
