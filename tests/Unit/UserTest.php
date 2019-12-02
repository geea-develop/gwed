<?php

namespace Tests\Unit;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserTest extends TestCase
{
    use DatabaseMigrations;

    public function testUserWhileLoggedIn()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user, 'api');

        $response = $this->get('/api/user');

        $response->assertStatus(200);
    }
}
