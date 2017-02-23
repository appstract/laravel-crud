<?php

namespace Appstract\Crud\Console;

use Illuminate\Support\Str;
use Illuminate\Console\GeneratorCommand;

class CrudCommand extends GeneratorCommand
{
    /**
     * [$replace description].
     * @var [type]
     */
    protected $replace;

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function fire()
    {
        if ($this->option('prompt')) {
            $this->prompt();
        }

        parent::fire();
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
     * Build the class with the given name.
     *
     * Remove the base controller import if we are already in base namespace.
     *
     * @param  string  $name
     * @return string
     */
    protected function buildClass($name)
    {
        return str_replace(
            array_keys($this->replace), array_values($this->replace), parent::buildClass($name)
        );
    }

    /**
     * Get the fully-qualified model class name.
     *
     * @param  string  $model
     * @return string
     */
    protected function parseModel($model)
    {
        if (preg_match('([^A-Za-z0-9_/\\\\])', $model)) {
            throw new InvalidArgumentException('Model name contains invalid characters.');
        }

        $model = trim(str_replace('/', '\\', $model), '\\');

        if (! Str::startsWith($model, $rootNamespace = $this->laravel->getNamespace())) {
            $model = $rootNamespace.$model;
        }

        return $model;
    }

    /**
     * [parsePrimaryKey description].
     * @return [type] [description]
     */
    protected function parsePrimaryKey()
    {
        return $this->getOption('primary', 'id');
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
     * [getModelInput description].
     * @return [type] [description]
     */
    protected function getModelInput()
    {
        return $this->argument('model') ?: ($this->option('model') ?: null);
    }

    /**
     * [getModel description].
     * @param  [type] $name [description]
     * @return [type]       [description]
     */
    public function getModel($name)
    {
        $model = new \StdClass;

        $model->fullModelClass = $this->parseModel($name);
        $model->modelClass = class_basename($model->fullModelClass);
        $model->modelPlural = strtolower(str_plural($model->modelClass));

        return $model;
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
