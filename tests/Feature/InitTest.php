<?php

namespace Tests\Feature;

use Tests\TestCase;

class InitTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_home_route()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }
}
