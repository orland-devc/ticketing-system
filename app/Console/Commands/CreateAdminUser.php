<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CreateAdminUser extends Command
{
    protected $signature = 'app:create-admin 
                            {name : The name of the administrator}
                            {email : The email of the administrator}
                            {password : The password for the administrator}';

    protected $description = 'Create a new Administrator user with a hashed password';

    public function handle()
    {
        $name = $this->argument('name');
        $email = $this->argument('email');
        $password = $this->argument('password');

        // Check if the user already exists
        if (User::where('email', $email)->exists()) {
            $this->error("User with email {$email} already exists.");
            return;
        }

        // Create the user
        $user = User::create([
            'role' => 'Administrator',
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
        ]);

        $this->info("{$user->user_code} created successfully!");
    }
}
