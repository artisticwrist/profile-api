<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProfileControllerTest extends TestCase
{
    /**
     * Test the /me endpoint returns expected JSON structure and status.
     *
     * @return void
     */
    public function testMyProfileEndpoint()
    {
        $response = $this->getJson(route('profile')); 

        $response->assertStatus(200)
            ->assertHeader('Content-Type', 'application/json')
            ->assertJsonStructure([
                'status',
                'user' => ['email', 'name', 'stack'],
                'timestamp',
                'fact',
            ])
            ->assertJson([
                'status' => true,
                'user' => [
                    'email' => 'contactdev.bigjoe@gmail.com',
                    'name' => 'George, Joseph Emmanuel',
                    
                ],
            ]);

        // timestamp check
        $timestamp = $response->json('timestamp');
        $this->assertTrue(\DateTime::createFromFormat(\DateTime::ATOM, $timestamp) !== false);

        // Check fact is a non-empty string
        $fact = $response->json('fact');
        $this->assertIsString($fact);
        $this->assertNotEmpty($fact);
    }
}

