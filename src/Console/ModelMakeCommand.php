<?php

namespace Appstract\Crud\Console;

use Symfony\Component\Console\Input\InputOption;

class ModelMakeCommand extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'crud:model
                            {name : The name of the model.}
                            {--table= : The name of the table.}
                            {--fillable= : The names of the fillable columns.}
                            {--relations= : The relations for the model}
                            {--primary=id : The name of the primary key.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new CRUD model class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Model';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function fire()
    {
        parent::fire();
    }

    /**
     * Build the class with the given name.
     *
     * @param  string  $name
     * @return string
     */
    protected function buildClass($name)
    {
        $stub = $this->files->get($this->getStub());

        $stub = $this->replacePlaceholders($stub);

        return $this->replaceNamespace($stub, $name)->replaceClass($stub, $name);
    }

    /**
     * Replace all placeholders.
     *
     * @param  [type] &$stub [description]
     * @return [type]        [description]
     */
    protected function replacePlaceholders(&$stub)
    {
        $this->replacers = [
            '{{table}}'      => $this->option('table') ?: strtolower(str_plural($this->argument('name'))),
            '{{primaryKey}}' => $this->option('primary'),
            '{{fillable}}'   => $this->parseFillable(),
            '{{relations}}'  => $this->parseRelations()
        ];

        return parent::replacePlaceholders($stub);
    }

    /**
     * Parse fillable.
     *
     * @return [type] [description]
     */
    protected function parseFillable()
    {
        if(! $this->option('fillable')) {
            return "['']";
        }

        $explode = explode(';', $this->option('fillable'));

        return "['".implode("', '", $explode)."']";
    }

    /**
     * Parse relations.
     *
     * @return [type] [description]
     */
    protected function parseRelations()
    {
        $relations = $this->option('relations') ? explode(';', $this->option('relations')) : [];

        foreach($relations as $relation) {
            $parts = collect(explode('#', $relation));
            $args  = collect(explode('|', $parts->get(2)));
            $class = $this->wrapWithQuotes($args->get(0));
            $args  = $this->wrapWithQuotes($args->forget(0)->implode("', '", $args));
            $name  = $parts->get(0);

            @$code .= "/**\n     * ".ucfirst($name)." relation.\n     */\n    public function ".$name."()\n    {\n        "."return \$this->".$parts->get(1)."($class".($args ? ", $args" : '').");". "\n    }\n\n";
        }

        return $code;
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__.'/stubs/model.stub';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace;
    }
}