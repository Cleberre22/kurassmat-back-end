<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UsersTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_new_users_created()
    {
        $response = $this->post('api/users', [
            'firstname' => 'Aurélien',
            'lastname' => 'Cotentin',
            'email' => 'c.leberre@hotmail.fr',
            'password' => 'Azerty1234$',
            'role' => 'employer',
            ]);
            
        $response->assertStatus(200);
    }

    public function test_users_listed_successfully()
    {
        $this->json('GET', 'api/users', ['Accept' => 'application/json'])
            ->assertStatus(200);
    }
}
