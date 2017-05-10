<?php

namespace Appstract\Crud\Console;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Console\GeneratorCommand as Command;

class GeneratorCommand extends Command
{
    // use Properties\HasName;

    /**
     * The filesystem instance.
     *
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $files;

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type;

    /**
     * [$replace description].
     * @var [type]
     */
    protected $replace;

    /**
     * Create a new controller creator command instance.
     *
     * @param  \Illuminate\Filesystem\Filesystem  $files
     * @return void
     */
    public function __construct(Filesystem $files)
    {
        parent::__construct($files);

        $this->files = $files;
    }

    /**
     * Execute the console command.
     *
     * @return bool|null
     */
    public function fire()
    {
        $name = $this->parseName($this->getNameInput());

        $path = $this->getPath($name);

        if ($this->option('prompt')) {
            $this->prompt();
        }

        if ($this->alreadyExists($this->getNameInput())) {
            $this->error($this->type.' already exists!');

            return false;
        }

        $this->makeDirectory($path);

        $this->files->put($path, $this->replace($name));

        $this->info($this->type.' created successfully.');
    }

    /**
     * Build the class with the given name.
     *
     * @param  string  $name
     * @return string
     */
    protected function replace($name)
    {
        $model = $this->getModel();

        $this->replace = array_merge($this->replace, [
            '{{{namespace}}}' => $this->getNamespace($name),
            '{{{rootNamespace}}}' => $this->laravel->getNamespace(),
            '{{{class}}}' => str_replace($this->getNamespace($name).'\\', '', $name),

            '{{{modelNamespaced}}}' => $model->namespaced,
            '{{{modelClass}}}' => $model->class,
            '{{{modelSingular}}}' => $model->singular,
            '{{{modelPlural}}}' => $model->plural,
            '{{{modelSingularCapitalized}}}' => $model->Singular,
            '{{{modelPluralCapitalized}}}' => $model->Plural,
        ]);

        return str_replace(
            array_keys($this->replace),
            array_values($this->replace),
            $this->files->get($this->getStub())
        );
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__.'/stubs/'.strtolower($this->type).'.stub';
    }

    /**
     * Conclude the prompt.
     *
     * @return void
     */
    protected function prompt($prepend = [])
    {
        $array = $prepend + $this->options();

        $filled = collect($array)->filter(function ($value, $key) {
            return $value;
        })->forget('prompt')->map(function ($value, $key) {
            return ['option' => $key, 'value' => $value];
        });

        $this->table(['option', 'value'], $filled);

        if (! $this->confirm('Is this correct?')) {
            return $this->prompt();
        }
    }

    /**
     * Wrap quotes.
     *
     * @param  [type] $string [description]
     * @return [type]         [description]
     */
    public function wrapWithQuotes($string)
    {
        return ! empty($string) ? "'".$string."'" : null;
    }

    /**
     * Wrap with brackets.
     *
     * @param  [type] $string [description]
     * @return [type]         [description]
     */
    public function wrapWithBrackets($string)
    {
        return ! empty($string) ? "['".$string."']" : null;
    }

    /**
     * [getArgument description].
     * @param  [type] $key [description]
     * @return [type]           [description]
     */
    public function setArgument($key, $value)
    {
        $this->input->setArgument($key, $value);
    }

    /**
     * Get option with default possibility.
     *
     * @param  [type] $option  [description]
     * @param  [type] $default [description]
     * @return [type]          [description]
     */
    protected function getOption($option, $default = null)
    {
        return $this->option($option) ?: $default;
    }

    /**
     * Set an option.
     *
     * @param [type] $key   [description]
     * @param [type] $value [description]
     */
    protected function setOption($key, $value)
    {
        $this->input->setOption($key, $value);
    }
}
