<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class DashboardTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testDashboardWhileNotLoggedIn()
    {
        $response = $this->get('/dashboard');

        $response->assertRedirect('login');
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testDashboardWhileLoggedIn()
    {
        $response = $this->withoutMiddleware()
            ->get('/dashboard');

        $response->assertStatus(200);
    }
}
