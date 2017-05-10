<?php

namespace Appstract\Crud\Console\Properties;

trait HasFillable
{
    /**
     * [getTableNameInput description].
     * @return [type] [description]
     */
    public function getFillableInput()
    {
        return $this->hasArgument('fillable')
            ? $this->argument('fillable')
            : ($this->option('fillable') ?: null);
    }

    /**
     * Parse fillable.
     *
     * @return string
     */
    public function getFillable()
    {
        if (! $this->getFillableInput()) {
            return "['']";
        }

        $explode = explode(';', $this->getFillableInput());

        return $this->wrapWithBrackets(implode("', '", $explode));
    }
}
