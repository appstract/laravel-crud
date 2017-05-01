<?php

namespace Appstract\Crud\Console\Properties;

trait HasTableName
{
    /**
     * [getTableNameInput description]
     * @return [type] [description]
     */
    protected function getTableNameInput()
    {
        return $this->hasArgument('table')
            ? $this->argument('table')
            : ($this->option('table') ?: strtolower(str_plural($this->getNameInput())));
    }

    /**
     * Get table name.
     *
     * @return string
     */
    protected function getTableName()
    {
        return $this->getTableNameInput();
    }
}