<?php

namespace Appstract\Crud\Console\Views;

class Show extends View
{
    /**
     * [build description]
     * @return [type] [description]
     */
    protected function build()
    {
        $this->replace = [
            '{{{tableBodyRows}}}' => $this->getTableBodyRows(),
        ];
    }

    /**
     * [getTableBodyRows description]
     * @return [type] [description]
     */
    protected function getTableBodyRows()
    {
        $model = $this->getCommand()->getModel()->singular;

        return $this->getCommand()->getFields()->map(function($type, $name) use ($model) {
            return "<tr>\n".
                "<th>".ucfirst($name)."</th>\n".
                "<td>{{ \$$model->$name }}</td>\n".
            "</tr>\n";
        })->values()->implode('');
    }
}