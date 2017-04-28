<?php

namespace Appstract\Crud\Console\Properties;

trait HasModel
{
    /**
     * [getModel description].
     * @param  [type] $name [description]
     * @return [type]       [description]
     */
    public function getModel($name)
    {
        $model = new \StdClass;

        $model->fullModelClass = $this->parseModel($name);
        $model->modelClass = class_basename($model->fullModelClass);
        $model->modelPlural = strtolower(str_plural($model->modelClass));

        return $model;
    }

    /**
     * [getModelInput description].
     * @return [type] [description]
     */
    protected function getModelInput()
    {
        return $this->argument('model') ?: ($this->option('model') ?: null);
    }
}