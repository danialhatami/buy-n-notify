<?php

namespace App\Console\Commands;

use Artisan;
use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

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

        $this->info('Generating Application Key...');
        Artisan::call('key:generate');

        $this->info('Enabling Telescope...');
        Artisan::call('telescope:install');
        Artisan::call('migrate');

        $this->info('Generating Test Token...');
        $createTestTokenProcess = new Process(['php', 'artisan', 'token:test']);
        $createTestTokenProcess->run();
        if ($createTestTokenProcess->isSuccessful()) {
            $this->warn($createTestTokenProcess->getOutput());
        } else {
            $this->error('Failed to generate token');
        }
    }
}
