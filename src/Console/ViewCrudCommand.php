<?php

namespace Appstract\Crud\Console;

class ViewCrudCommand extends GeneratorCommand
{
    use Properties\HasFields,
        Properties\HasModel;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'crud:view
                            {name : Name of the view}
                            {--model= : Name of the model}
                            {--fields= : Fields}
                            {--p|prompt : Run in prompt}';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'View';

    /**
     * Build the class with the given name.
     *
     * @param  string  $name
     * @return string
     */
    protected function replace($name)
    {
        $builder = $this->getViewBuilder();

        $this->replace = (new $builder($this))->getReplacers();

        return parent::replace($name);
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__.'/stubs/views/'.strtolower($this->getNameInput()).'.stub';
    }

    /**
     * Get the destination class path.
     *
     * @param  string  $name
     * @return string
     */
    protected function getPath($name)
    {
        return $this->laravel->resourcePath().'/views/'.$this->getModel()->plural.'/'.$this->getNameInput().'.blade.php';
    }

    /**
     * Get classname of the builder.
     *
     * @param  [type] $name [description]
     * @return [type]       [description]
     */
    protected function getViewBuilder()
    {
        return 'Appstract\\Crud\\Console\\Views\\'.ucfirst($this->getNameInput());
    }

    /**
     * Prompt.
     *
     * @return void
     */
    protected function prompt($prepend = [])
    {
        parent::prompt();
    }
}
