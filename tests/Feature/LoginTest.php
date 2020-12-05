<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testGuestCannotAccessAuthRoute()
    {
        $response = $this->get('/contacts');
        $response->assertStatus(302);
    }

    public function testUserCanLogin()
    {
        $user = User::factory()->create();

        $this->followingRedirects();
        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertStatus(200);
        $this->assertTrue(Auth::check());
    }
}
