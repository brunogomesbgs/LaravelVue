<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;
use App\Models\User as Users;

class UserTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_login(): void
    {
        $user = Users::factory()->make([
            'name' => 'Deise1',
            'password' => 'deiserocks'
        ]);

        $response = $this->postJson(
            '/api/users/logIn',
            [
                'name' => 'Deise1',
                'password' => 'deiserocks'
            ]
        );

        $response->assertStatus(200)
            ->assertJson(
                fn (AssertableJson $json) => $json
                    ->where('id', $user->id)
                    ->where('name', 'Deise1')
                    ->etc()
            );
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
        Users::factory()->count(2)->make();

        $response = $this->getJson(
            '/api/users/getAll'
        );

        $response->assertStatus(200)
            ->assertJsonCount(2);
    }
}
