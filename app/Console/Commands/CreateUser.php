<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CreateUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:user {email : The email of the user}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a user given an email address.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Creates a user given email and password inputs.
     *
     * @return int
     */
    public function handle()
    {
        $email = $this->argument('email');
        $name = $this->ask('Please set a name for the user');
        $password = $this->secret('Please set a password for the user');

        $validator = Validator::make([
            'email' => $email,
            'password' => $password,
            'name' => $name,
        ], [
            'email' => 'required|email|max:1000',
            'password' => 'required|min:6|max:1000',
            'name' => 'required|min:3|max:1000',
        ]);

        // Check for valid inputs
        if ($validator->fails()) {
            // Display errors to the user
            $this->error('The following errors were encountered:');
            array_map(
                fn ($error) => $this->error(implode(' ', $error)), 
                $validator->errors()->toArray()
            );

            return 1;
        }

        User::create([
            'email' => $email,
            'password' => Hash::make($password),
            'name' => $name,
        ]);

        $this->info("User created! Use the email '{$email}' to login with the password you chose.");
        return 0;
    }
}
