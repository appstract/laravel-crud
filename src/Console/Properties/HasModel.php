<?php

namespace Appstract\Crud\Console\Properties;

trait HasModel
{
    /**
     * [getModelInput description].
     * @return [type] [description]
     */
    protected function getModelInput()
    {
        return $this->hasArgument('model')
            ? $this->argument('model')
            : ($this->option('model') ?: null);
    }

    /**
     * [getModel description].
     * @param  [type] $name [description]
     * @return [type]       [description]
     */
    public function getModel()
    {
        $name = $this->getModelInput();

        $model = new \StdClass;

        $model->namespaced = 'App\\'.$name;
        $model->class      = class_basename($model->namespaced);
        $model->plural     = strtolower(str_plural($model->class));

        return $model;
    }
}