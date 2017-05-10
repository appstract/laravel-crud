<?php

namespace Appstract\Crud\Console\Properties;

trait HasPrimaryKey
{
    /**
     * [getTableNameInput description].
     * @return [type] [description]
     */
    public function getPrimaryKeyInput()
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
    public function getPrimaryKey()
    {
        return $this->getPrimaryKeyInput();
    }
}
