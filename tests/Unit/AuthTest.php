<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AuthTest extends TestCase
{
    use DatabaseMigrations;

    public function testLoginPage()
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    public function testLogin()
    {
        $user = factory(User::class)->create();

        $response = $this->call('POST', '/login', [
            '_token' => csrf_token(),
            'email'    => $user->email,
            'password' => 'secret'
        ]);

        $response->assertRedirect('dashboard');
    }

    public function testRegistrationPage()
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function testRegister()
    {
        $user = factory(User::class)->make();

        $response = $this->call('POST', '/register', [
            '_token' => csrf_token(),
            'name'    => $user->name,
            'email'    => $user->email,
            'password' => 'secret',
            'password_confirmation' => 'secret'
        ]);

        $response->assertRedirect('dashboard');

    }

    public function testPasswordResetPage()
    {
        $response = $this->get('/password/reset');

        $response->assertStatus(200);
    }

    public function testGetResetPasswordToken()
    {
        $user = factory(User::class)->make();

        $response = $this->call('POST', '/password/email', [
            '_token' => csrf_token(),
            'email'    => $user->email
        ]);

        $response->assertRedirect('/');

    }
}
