<?php

namespace Appstract\Crud\Console\Views;

class Index extends View
{
    /**
     * [build description]
     * @return [type] [description]
     */
    protected function build()
    {
        $this->replace = [
            '{{{tableHeadColumns}}}' => $this->getTableHeadColumns(),
            '{{{tableBodyColumns}}}' => $this->getTableBodyColumns(),
        ];
    }

    /**
     * [getTableHeadColumns description]
     * @return [type] [description]
     */
    protected function getTableHeadColumns()
    {
        return $this->getCommand()->getFields()->map(function($type, $name) {
            return "<th>".ucfirst($name)."</th>\n";
        })->values()->implode('');
    }

    /**
     * [getTableBodyColumns description]
     * @return [type] [description]
     */
    protected function getTableBodyColumns()
    {
        $model = $this->getCommand()->getModel()->singular;

        return $this->getCommand()->getFields()->map(function($type, $name) use ($model) {
            return "<td>{{ \$$model->$name }}</td>\n";
        })->values()->implode('');
    }
}