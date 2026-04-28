<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\Back\UserController;

class CreateTemplateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:template';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create Excel template for users import';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $controller = new UserController();

        // Use reflection to call private method
        $reflection = new \ReflectionClass($controller);
        $method = $reflection->getMethod('createTemplateFile');
        $method->setAccessible(true);
        $method->invoke($controller);

        $this->info('✅ Excel template created successfully!');
        $this->info('📁 Location: public/templates/users_import_template.xlsx');
        $this->info('📋 Template includes 3 sample users with different roles');
        $this->info('📖 Instructions are included at the top of the file');

        return 0;
    }
}
