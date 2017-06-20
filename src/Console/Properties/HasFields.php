<?php

namespace Appstract\Crud\Console\Properties;

trait HasFields
{
    /**
     * [getModelInput description].
     * @return [type] [description]
     */
    public function getFieldsInput()
    {
        return $this->hasArgument('fields')
            ? $this->argument('fields')
            : ($this->option('fields') ?: null);
    }

    /**
     * [getModel description].
     * @param  [type] $name [description]
     * @return [type]       [description]
     */
    public function getFields()
    {
        $fields = $this->getFieldsInput() ? explode(';', $this->getFieldsInput()) : [];

        $array = [];

        foreach($fields as $field) {
            $field = collect(explode('#', $field));

            $array[$field->get(0)] = $field->get(1);
        }

        return collect($array);
    }
}
