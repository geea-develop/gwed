<?php

namespace Tests\Unit;

use Tests\TestCase;

class SimpleRoutesTest extends TestCase
{
    public function testGetShopPage()
    {
        $response = $this->get('/shop');

        $response->assertStatus(200);
    }

    public function testGetAboutPage()
    {
        $response = $this->get('/about');

        $response->assertStatus(200);
    }

    public function testGetDocumentationPage()
    {
        $response = $this->get('/documentation');

        $response->assertStatus(200);
    }

    public function testGetContactPage()
    {
        $response = $this->get('/contact');

        $response->assertStatus(200);
    }

}
