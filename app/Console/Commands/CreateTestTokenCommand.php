<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class CreateTestTokenCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'token:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a token for the first user in the database';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $user = User::first();
        if ($user) {
            $token = $user->createToken('token', [])->plainTextToken;
            $this->info("Generated Token: Bearer $token");
        } else {
            $this->error('No user found');
        }
    }
}
