<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class User extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_login(): void
    {
        $user = User::factory()->create([
            'name' => 'Deise1',
            'password' => 'deiserocks',
            'email' => 'deise1@test.com'
        ]);

        $response = $this->postJson(
            '/api/users/logIn',
            [
                'name' => 'Deise1',
                'password' => 'deiserocks'
            ]
        );

        $response->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) => $json->where('id', $user->id)->etc());
    }

    public function test_add_user(): void
    {
        $response = $this->postJson(
            '/api/users/addUser',
            [
                'name' => 'Deise',
                'email' => 'deise@test.com',
                'password' => 'deiserocks'
            ]
        );

        $response->assertStatus(201)
            ->assertJson(
                fn (AssertableJson $json) => $json
                ->where('name', 'Deise')
                ->where('email', 'deise@test.com')
                ->etc()
            );
    }

    public function test_get_all(): void
    {
        $user = \App\Models\User::factory()->create([
            'name' => 'Deise2',
            'password' => 'deiserocks',
            'email' => 'deise2@test.com'
        ]);

        \App\Models\User::factory()->create([
            'name' => 'Deise3',
            'password' => 'deiserocks',
            'email' => 'deise3@test.com'
        ]);

        $response = $this->getJson(
            '/api/users/getAll'
        );

        $response->assertStatus(200)
            ->assertJsonCount(2)
            ->assertJson(fn (AssertableJson $json) => $json->where('id', $user->id)->etc());
    }
}
