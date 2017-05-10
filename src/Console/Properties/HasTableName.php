<?php

namespace Appstract\Crud\Console\Properties;

trait HasTableName
{
    /**
     * [getTableNameInput description].
     * @return [type] [description]
     */
    public function getTableNameInput()
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
    public function getTableName()
    {
        return $this->getTableNameInput();
    }
}
