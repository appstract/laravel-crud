<?php

namespace Appstract\Crud\Console;

use Illuminate\Support\Composer;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Console\GeneratorCommand as BaseGeneratorCommand;

class GeneratorCommand extends BaseGeneratorCommand
{
    /**
     * The Composer instance.
     *
     * @var \Illuminate\Support\Composer
     */
    protected $composer;

    /**
     * [$replacers description]
     * @var [type]
     */
    protected $replacers = [];

    /**
     * Create a new command instance.
     *
     * @param  \Illuminate\Filesystem\Filesystem  $files
     * @param  \Illuminate\Support\Composer  $composer
     * @return void
     */
    public function __construct(Filesystem $files, Composer $composer)
    {
        parent::__construct($files);

        $this->composer = $composer;
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function fire()
    {
        parent::fire();

        $this->composer->dumpAutoloads();
    }

    /**
     * Wrap quotes.
     *
     * @param  [type] $string [description]
     * @return [type]         [description]
     */
    public function wrapWithQuotes($string)
    {
        return "'".$string."'";
    }

    /**
     * Replace all placeholders.
     *
     * @param  [type] &$stub [description]
     * @return [type]        [description]
     */
    protected function replacePlaceholders(&$stub)
    {
        foreach($this->replacers as $placeholder => $replacer) {
            $stub = str_replace($placeholder, $replacer, $stub);
        }

        return $stub;
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
     * Get the destination class path.
     *
     * @param  string  $name
     * @return string
     */
    // protected function getPath($name)
    // {
    //     return $this->laravel->databasePath().'/seeds/'.$name.'.php';
    // }
}