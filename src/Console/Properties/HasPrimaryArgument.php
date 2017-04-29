<?php

namespace Appstract\Crud\Console\Properties;

use Illuminate\Support\Str;

trait HasPrimaryArgument
{
    /**
     * [getPrimaryArgumentInput description]
     * @return [type] [description]
     */
    protected function getPrimaryArgumentInput()
    {
        return $this->argument($this->primaryArgument);
    }

    /**
     * Get the value of the primary argument.
     *
     * @return string
     */
    protected function getPrimaryArgument()
    {
        $rootNamespace = $this->laravel->getNamespace();

        $name = $this->getPrimaryArgumentInput();

        if (Str::startsWith($name, $rootNamespace)) {
            return $name;
        }

        if (Str::contains($name, '/')) {
            $name = str_replace('/', '\\', $name);
        }

        return $this->getDefaultNamespace(trim($rootNamespace, '\\')).'\\'.$name;
    }
}