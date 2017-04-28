<?php

namespace Appstract\Crud\Console;

class ViewCrudCommand extends CrudCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'crud:views
                            {name : Name of the model.}
                            {--fields= : Fields}
                            {--p|prompt : Run in prompt}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new CRUD view';

    /**
     * [$views description].
     * @var [type]
     */
    protected $views = [
        'index'  => \Appstract\Crud\Console\View\IndexCommand::class,
        'create' => \Appstract\Crud\Console\View\CreateCommand::class,
        'show'   => \Appstract\Crud\Console\View\ShowCommand::class,
        'edit'   => \Appstract\Crud\Console\View\EditCommand::class,
    ];

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function fire()
    {
        foreach($this->views as $view => $command) {
            //
        }
    }

    /**
     * Prompt.
     *
     * @return void
     */
    protected function prompt($prepend = [])
    {
        parent::prompt();
    }
}
