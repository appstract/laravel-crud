<?php

namespace Appstract\Crud\Console\Generators;

use Illuminate\Support\Str;
use Illuminate\Console\GeneratorCommand as Command;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class GeneratorCommand extends Command
{
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
     * Primary argument.
     *
     * @var string
     */
    protected $primaryArgument = 'name';

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
        if ($this->option('prompt')) {
            $this->prompt();
        }

        $name = $this->argument($this->primaryArgument);
        $path = $this->getPath($name);

        if ($this->alreadyExists($this->primaryArgument)) {
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
        $stub = $this->files->get($this->getStub());
        $stub = $this->replaceNamespace($stub, $name);
        $stub = $this->replaceClass($stub, $name);

        return str_replace(
            array_keys($this->replace),
            array_values($this->replace),
            $stub
        );
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__.'/../stubs/'.strtolower($this->type).'.stub';
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
     * Parse the name and format according to the root namespace.
     *
     * @param  string  $name
     * @return string
     */
    protected function parsePrimaryArgument($name)
    {
        $rootNamespace = $this->laravel->getNamespace();

        if (Str::startsWith($name, $rootNamespace)) {
            return $name;
        }

        if (Str::contains($name, '/')) {
            $name = str_replace('/', '\\', $name);
        }

        return $this->parsePrimaryArgument($this->getDefaultNamespace(trim($rootNamespace, '\\')).'\\'.$name);
    }

    /**
     * Get the full namespace name for a given class.
     *
     * @param  string  $name
     * @return string
     */
    protected function getNamespace($name)
    {
        return trim(implode('\\', array_slice(explode('\\', $name), 0, -1)), '\\');
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

    /**
     * Replace the namespace for the given stub.
     *
     * @param  string  $stub
     * @param  string  $name
     * @return $this
     */
    protected function replaceNamespace(&$stub, $name)
    {
        $stub = str_replace(
            '{{{namespace}}}', $this->getNamespace($name), $stub
        );

        $stub = str_replace(
            '{{{rootNamespace}}}', $this->laravel->getNamespace(), $stub
        );

        return $stub;
    }

    /**
     * Replace the class name for the given stub.
     *
     * @param  string  $stub
     * @param  string  $name
     * @return string
     */
    protected function replaceClass($stub, $name)
    {
        $class = str_replace($this->getNamespace($name).'\\', '', $name);

        return str_replace('{{{class}}}', $class, $stub);
    }

    /**
     * Get the value of the primary argument.
     *
     * @return string
     */
    protected function getPrimaryArgument()
    {
        return $this->argument($this->primaryArgument);
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
