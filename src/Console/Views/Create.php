<?php

namespace Appstract\Crud\Console\Views;

class Create extends View
{
    /**
     * [build description].
     * @return [type] [description]
     */
    protected function build()
    {
        $this->replace = [
            '{{{fields}}}' => $this->getFields(),
        ];
    }

    /**
     * [getFields description].
     * @return [type] [description]
     */
    protected function getFields()
    {
        $code = $this->getCommand()->getFields()->map(function ($type, $name) {
            return (new Fields\Field($type, $name))->getCode();
        });

        dd($code);
    }
}
