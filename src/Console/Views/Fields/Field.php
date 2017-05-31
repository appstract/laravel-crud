<?php

namespace Appstract\Crud\Console\Views\Fields;

use Illuminate\Filesystem\Filesystem;

class Field
{
    /**
     * [$type description].
     * @var [type]
     */
    protected $type;

    /**
     * [$name description].
     * @var [type]
     */
    protected $name;

    /**
     * [$code description].
     * @var [type]
     */
    protected $code;

    /**
     * [$files description].
     * @var [type]
     */
    protected $files;

    /**
     * [__construct description].
     */
    public function __construct($type, $name)
    {
        $this->files = new Filesystem;

        $this->type = $type;
        $this->name = $name;

        $this->build();
    }

    /**
     * [build description].
     * @return [type] [description]
     */
    public function build()
    {
        $this->code = str_replace(
            '{{{name}}}',
            $this->name,
            $this->files->get($this->getStub())
        );
    }

    /**
     * [getStub description].
     * @return [type] [description]
     */
    protected function getStub()
    {
        return __DIR__.'/../../stubs/views/fields/'.strtolower($this->type).'.stub';
    }

    /**
     * [getCode description].
     * @return [type] [description]
     */
    public function getCode()
    {
        return $this->code;
    }
}
