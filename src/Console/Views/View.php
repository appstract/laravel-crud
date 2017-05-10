<?php

namespace Appstract\Crud\Console\Views;

abstract class View
{
    /**
     * [$replace description]
     * @var array
     */
    protected $replace = [];

    /**
     * [$command description]
     * @var [type]
     */
    protected $command;

    /**
     * [__construct description]
     * @param [type] $command [description]
     */
    public function __construct($command)
    {
        $this->command = $command;

        $this->build();
    }

    /**
     * [build description]
     */
    abstract protected function build();

    /**
     * [getCommand description]
     * @return [type] [description]
     */
    protected function getCommand()
    {
        return $this->command;
    }

    /**
     * [getReplacers description]
     * @return [type] [description]
     */
    public function getReplacers()
    {
        return $this->replace;
    }
}