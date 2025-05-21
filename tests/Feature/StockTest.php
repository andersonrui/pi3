<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class StockTest extends TestCase
{
    public function test_fail_get_records_not_logged(): void
    {
        $response = $this->get('/estoque');

        $response->assertStatus(302);
    }

    public function test_get_records_logged():void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get('/estoque');
        $response->assertStatus(200);
    }
}
