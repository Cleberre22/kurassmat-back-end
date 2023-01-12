<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ChildrenTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_new_children_created()
    {
        $response = $this->post('api/childs', [
            'firstnameChild' => 'Aurélien',
            'lastnameChild' => 'Cotentin',
            'birthDate' => '2023-01-12',
            // 'imageChild' => "image.png",
        ]);

        $response->assertStatus(200);
    }

    public function test_children_listed_successfully()
    {
        $this->json('GET', 'api/childs', ['Accept' => 'application/json'])
            ->assertStatus(200);
    }
}
