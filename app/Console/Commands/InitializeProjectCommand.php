<?php

namespace App\Console\Commands;

use Artisan;
use Illuminate\Console\Command;

class InitializeProjectCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'project:init';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Initialize the project by running migrations, seeders and generating a test token';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        $this->info('Running Migrations...');
        Artisan::call('migrate');

        $this->info('Running Database Seeder...');
        Artisan::call('db:seed');

        $this->info('Generating Test Token...');
        Artisan::call('token:test');
    }
}
