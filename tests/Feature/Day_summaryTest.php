<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DaySummaryTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_new_daySummary_created()
    {
        $response = $this->post('api/daysummary', [
            'contentDaySummary' => 'Repas: purée , Sieste: 2h10, Sortie au parc',
            'users_id' => 1,
            'childs_id' => 16,
            ]);
            
        $response->assertStatus(200);
    }

    public function test_daySummary_listed_successfully()
    {
        $this->json('GET', 'api/daysummary', ['Accept' => 'application/json'])
            ->assertStatus(200);
    }
}
