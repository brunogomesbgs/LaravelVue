<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class Deposit extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_make_deposit(): void
    {
        $user = \App\Models\User::factory()->create([
            'name' => 'Deise10',
            'password' => 'deiserocks',
            'email' => 'deise10@test.com'
        ]);

        $response = $this->postJson(
            '/api/deposits/makeDeposit',
            [
                'userId' => $user->id,
                'value' => 10
            ]
        );

        $response->assertStatus(200);
    }

    public function test_check_user_balance(): void
    {
        $user = \App\Models\User::factory()->create([
            'name' => 'Deise11',
            'password' => 'deiserocks',
            'email' => 'deise11@test.com'
        ]);

        $response = $this->postJson(
            '/api/deposits/makeDeposit',
            [
                'userId' => $user->id,
                'value' => 10
            ]
        );

        $response->assertStatus(200)->assertJson(fn (AssertableJson $json) => $json->where('userId', $user->id));
    }

    public function test_list_user_balance(): void
    {
        $user = \App\Models\User::factory()->create([
            'name' => 'Deise12',
            'password' => 'deiserocks',
            'email' => 'deise12@test.com'
        ]);

        $response = $this->getJson(
            '/api/deposits/listUserBalance',
            [
                'userId' => $user->id
            ]
        );

        $response->assertStatus(200)->assertJson(fn (AssertableJson $json) => $json->where('userId', $user->id));
    }

    public function test_list_pending_deposit(): void
    {
        $user = \App\Models\User::factory()->create([
            'name' => 'Deise12',
            'password' => 'deiserocks',
            'email' => 'deise12@test.com'
        ]);

        $deposit = \App\Models\Deposit::factory()->create([
            'userId' => $user->id,
            'value' => 10
        ]);

        $response = $this->getJson(
            '/api/deposits/listPendingDeposit'
        );

        $response->assertStatus(200)->assertJson(
            fn (AssertableJson $json) => $json
                ->where('id', $deposit->id)
                ->where('value', $deposit->value)
        );
    }

    public function test_evaluate_deposit(): void
    {
        $user = \App\Models\User::factory()->create([
            'name' => 'Deise14',
            'password' => 'deiserocks',
            'email' => 'deise14@test.com',
        ]);

        $deposit = \App\Models\Deposit::factory()->create([
            'userId' => $user->id,
            'value' => 10
        ]);

        $response = $this->postJson(
            '/api/deposits/evaluateDeposit',
            [
                'depositId' => $user->id,
                'evaluation' => 1
            ]
        );

        $response->assertStatus(200);
    }
}
