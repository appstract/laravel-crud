<?php

namespace Appstract\Crud\Console\Properties;

trait HasRelations
{
    /**
     * [getTableNameInput description].
     * @return [type] [description]
     */
    public function getRelationsInput()
    {
        return $this->hasArgument('relations')
            ? $this->argument('relations')
            : ($this->option('relations') ?: null);
    }

    /**
     * Parse relations.
     * images#hasMany#App\Image|foreign_key|local_key.
     *
     * @return string
     */
    public function getRelations()
    {
        $relations = $this->getRelationsInput() ? explode(';', $this->getRelationsInput()) : [];

        $code = null;

        foreach ($relations as $relation) {
            $parts = collect(explode('#', $relation));
            $args = collect(explode('|', $parts->last()));
            $class = $this->wrapWithQuotes($args->first());
            $args = $this->wrapWithQuotes($args->forget(0)->implode("', '", $args));
            $name = $parts->first();

            $code .= "/**\n     * ".ucfirst($name)." relation.\n     */\n    public function ".$name."()\n    {\n        ".'return $this->'.$parts->get(1)."($class".($args ? ", $args" : '').');'."\n    }\n\n";
        }

        return $code;
    }
}
