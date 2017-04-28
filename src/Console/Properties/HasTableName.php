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
        return $this->getOption('table', strtolower(str_plural($this->getPrimaryArgument())));
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