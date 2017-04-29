<?php

namespace Appstract\Crud\Console\Properties;

use Illuminate\Support\Str;

trait HasNameSpace
{
    /**
     * Replace the class name for the given stub.
     *
     * @param  string  $stub
     * @param  string  $name
     * @return string
     */
    protected function getClass($name)
    {
        return str_replace($this->getNamespace($name).'\\', '', $name);
    }
}