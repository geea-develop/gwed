<?php

namespace Tests\Unit;

use App\User;
use App\Wedding;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class WeddingTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testWeddingWhileNotLoggedIn()
    {
        $response = $this->get('/api/wedding');

        $response->assertRedirect('login');
    }

    use DatabaseMigrations;

    public function testWeddingWhileLoggedIn()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user, 'api');

        $response = $this->get('/api/wedding');

        $response->assertStatus(200);
    }

    public function testCreateWedding()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user, 'api');

        $wedding = [
            "brideName" => "bride name",
            "groomName" => "groom name",
            "location" => "location",
            "budget"    => rand(10000,800000),
            "guests" => rand(1,800),
            "date" => Carbon::now()->addMonth()
        ];

        $response = $this->withoutMiddleware()->call('POST', '/api/wedding', $wedding);

        $response->assertJsonStructure(['wedding']);

    }

    public function testUpdateWedding()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user, 'api');

        $wedding = factory(Wedding::class)->create();

        $params = [
            "brideName" => "bride name",
            "groomName" => "groom name",
            "location" => "location",
            "guests" => rand(1,800),
            "date" => Carbon::now()->addMonth()
        ];

        $response = $this->withoutMiddleware()->call('PUT', '/api/wedding/' . $wedding->_id, $params);

        $response->assertJsonStructure(['wedding']);

    }

    public function testDeleteWedding()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user, 'api');

        $wedding = factory(Wedding::class)->create();

        $response = $this->withoutMiddleware()->call('DELETE', '/api/wedding/' . $wedding->_id);

        $response->assertJson([]);

    }
}
