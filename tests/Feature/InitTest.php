<?php

namespace Tests\Feature;

use Tests\TestCase;

class InitTest extends TestCase
{
    public function test_home_route()
    {
        $response = $this->get('/');
        // $response->dd();
        dd($response->getContent());
        // $response->assertStatus(200)->assertJsonStructure();
    }
}
