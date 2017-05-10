<?php

namespace Appstract\Crud\Console\Views;

class Create extends View
{
    /**
     * [build description]
     * @return [type] [description]
     */
    protected function build()
    {
        $this->replace = [
            '{{{modelPluralCapitalized}}}' => $this->getCommand()->getModel()->Plural,
        ];
    }
}