<?php

namespace Appstract\Crud\Console\Properties;

trait HasModel
{
    /**
     * [getModelInput description].
     * @return [type] [description]
     */
    public function getModelInput()
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
        $model->class = class_basename($model->namespaced);
        $model->singular = strtolower($model->class);
        $model->plural = str_plural($model->singular);
        $model->Singular = ucfirst($model->singular);
        $model->Plural = ucfirst($model->plural);

        return $model;
    }
}
