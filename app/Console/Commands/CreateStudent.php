<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateStudent extends Command
{
    protected $signature = 'make:student 
                            {name : The name of the administrator}
                            {email : The email of the administrator}
                            {password : The password for the administrator}
                            {student_id? : The student ID (optional)}';

    protected $description = 'Create a new Administrator user with a hashed password';

    public function handle()
    {
        $name = $this->argument('name');
        $email = $this->argument('email');
        $password = $this->argument('password');
        $student_id = $this->argument('student_id');

        // Check if the user already exists
        if (User::where('email', $email)->exists()) {
            $this->error("User with email {$email} already exists.");

            return;
        }

        // Create the user
        $user = User::create([
            'role' => 'Student',
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'student_id' => $student_id,
        ]);

        $this->info("{$user->user_code} created successfully!");
    }
}
