<?php

namespace Appstract\Crud\Console\Views;

class Edit extends View
{
    /**
     * [build description]
     * @return [type] [description]
     */
    protected function build()
    {
        $this->replace = [
            '{{{tableBodyRows}}}' => $this->getCommand()->getModel()->Plural,
        ];
    }
}