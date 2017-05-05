<?php

namespace Appstract\Crud\Console\Properties;

trait HasSchema
{
    /**
     * [getModelInput description].
     * @return [type] [description]
     */
    protected function getSchemaInput()
    {
        return $this->hasArgument('schema')
            ? $this->argument('schema')
            : ($this->option('schema') ?: null);
    }

    /**
     * [parseSchema description].
     * @return [type] [description]
     */
    public function getSchema()
    {
        $columns = $this->getSchemaInput() ? explode(';', $this->getSchemaInput()) : [];

        $code = "\n\t\t\t".'$table->increments('.$this->wrapWithQuotes($this->getPrimaryKey()).');'."\n";

        foreach ($columns as $column) {
            $parts = collect(explode('#', $column));

            // Name available
            if (in_array($parts->get(1), $this->columnTypes)) {
                $code .= "\n\t\t\t".'$table->'.$parts->get(1).'('.$this->wrapWithQuotes($parts->get(0)).');';
            }

            // Empty function, eg timestamps
            else {
                $code .= "\n\t\t\t".'$table->'.$parts->get(0).'();'."\n";
            }
        }

        return $code;
    }
}
