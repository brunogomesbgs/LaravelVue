<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;
use App\Models\User as Users;
use App\Models\Deposit as Deposits;

class DepositTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_make_deposit(): void
    {
        $user = Users::factory()->make();

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
        $user = Users::factory()->make();

        $response = $this->postJson(
            '/api/deposits/makeDeposit',
            [
                'userId' => $user->id,
                'value' => 10
            ]
        );

        $response->assertStatus(200)
            ->assertJson(
                fn (AssertableJson $json) => $json
                    ->where('userId', $user->id)
                    ->etc()
            );
    }

    public function test_list_user_balance(): void
    {
        $user = Users::factory()->make();

        $response = $this->getJson(
            '/api/deposits/listUserBalance',
            [
                'userId' => $user->id
            ]
        );

        $response->assertStatus(200)
            ->assertJson(
                fn (AssertableJson $json) => $json
                    ->where('userId', $user->id)
                    ->etc()
            );
    }

    public function test_list_pending_deposit(): void
    {
        $user = Users::factory()->make();

        $deposit = Deposits::factory()->make([
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
                ->etc()
        );
    }

    public function test_evaluate_deposit(): void
    {
        $user = Users::factory()->make();

        Deposits::factory()->make([
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
