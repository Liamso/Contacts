<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateUserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testCreatesUser()
    {
        $this->artisan('make:user test@test.com')
        ->expectsQuestion('Please set a name for the user', 'Admin')
            ->expectsQuestion('Please set a password for the user', 'password')
            ->expectsOutput("User created! Use the email 'test@test.com' to login with the password you chose.")
            ->assertExitCode(0);

        $user = User::first();
        $this->assertEquals('test@test.com', $user->email);
        $this->assertEquals('Admin', $user->name);
        $this->assertEquals(1, User::count());

        $this->assertTrue(Auth::attempt([
            'email' => 'test@test.com',
            'password' => 'password'
        ]));
    }

    public function testValidatesInput()
    {
        $this->artisan('make:user test')
            ->expectsQuestion('Please set a name for the user', '')
            ->expectsQuestion('Please set a password for the user', 'a')
            ->expectsOutput('The following errors were encountered:')
            ->expectsOutput('The email must be a valid email address.')
            ->expectsOutput('The password must be at least 6 characters.')
            ->expectsOutput('The name field is required.')
            ->assertExitCode(1);
    }
}
