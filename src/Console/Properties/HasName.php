<?php

namespace Appstract\Crud\Console\Properties;

trait HasName
{
    /**
     * [getModelInput description].
     * @return [type] [description]
     */
    public function getNameInput()
    {
        return $this->hasArgument('name')
            ? $this->argument('name')
            : ($this->option('name') ?: null);
    }
}
