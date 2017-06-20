<?php

namespace Appstract\Crud\Console;

use Artisan;
use Illuminate\Console\Command;

class ViewsCrudCommand extends Command
{
    use Properties\HasName,
        Properties\HasFields;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'crud:views
                            {name : Name of the model}
                            {--fields= : Fields}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create all CRUD views';

    /**
     * [$views description].
     * @var [type]
     */
    protected $views = [
        'index',
        'create',
        'show',
        'edit',
    ];

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        foreach ($this->views as $view) {
            Artisan::call('crud:view', [
                'name'     => $view,
                '--model'  => $this->getNameInput(),
                '--fields' => $this->getFieldsInput(),
            ]);
        }

        $this->info('Views created successfully.');
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
