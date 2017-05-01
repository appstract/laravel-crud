<?php

namespace Appstract\Crud\Console\Properties;

trait HasPrimaryKey
{
    /**
     * [getTableNameInput description]
     * @return [type] [description]
     */
    protected function getPrimaryKeyInput()
    {
        return $this->hasArgument('primary')
            ? $this->argument('primary')
            : ($this->option('primary') ?: null);
    }

    /**
     * Parse fillable.
     *
     * @return string
     */
    protected function getPrimaryKey()
    {
        return $this->getPrimaryKeyInput();
    }
}