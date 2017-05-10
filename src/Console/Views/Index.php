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
        $code = '';

        foreach($this->getCommand()->getFields() as $name => $type) {
            $code .= '<th>'.ucfirst($name).'</th>';
        }

        return $code;
    }

    /**
     * [getTableBodyColumns description]
     * @return [type] [description]
     */
    protected function getTableBodyColumns()
    {
        $model = $this->getCommand()->getModel()->singular;

        $code = '';

        foreach($this->getCommand()->getFields() as $name => $type) {
            $code .= "<td>{{ \$$model->$name }}</td>\n";
        }

        return $code;
    }
}