<?php

namespace Appstract\Crud\Console;

use Illuminate\Support\Composer;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Console\GeneratorCommand;

class MakeCommand extends GeneratorCommand
{
    /**
     * [$replace description]
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
        if($this->option('prompt')) {
            $this->prompt();
        }

        parent::fire();
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
        return "['".$string."']";
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
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__.'/stubs/'.strtolower($this->type).'.stub';
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

    /**
     * Conclude the prompt.
     *
     * @return void
     */
    protected function prompt()
    {
        $filled = collect($this->options())->filter(function($value, $key){
            return $value;
        })->forget('prompt')->prepend($this->argument('name'), 'model')->map(function($value, $key){
            return ['option' => $key, 'value' => $value];
        });

        $this->table(['option', 'value'], $filled);

        if(! $this->confirm('Is this correct?')) {
            return $this->prompt();
        }
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the '.strtolower($this->type).'.'],
        ];
    }
}