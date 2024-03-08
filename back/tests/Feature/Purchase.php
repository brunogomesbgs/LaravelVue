<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class Purchase extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_make_purchase(): void
    {
        $user = \App\Models\User::factory()->create([
            'name' => 'Deise15',
            'password' => 'deiserocks',
            'email' => 'deise15@test.com'
        ]);

        $response = $this->postJson(
            '/api/purchases/makePurchase',
            [
                'userId' => $user->id,
                'value' => 10,
                'description' => 'test purchase'
            ]
        );

        $response->assertStatus(200);
    }
}
