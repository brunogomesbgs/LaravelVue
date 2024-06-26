<?php

namespace Tests\Feature;

use App\Models\Url;
use App\Models\User as Users;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class UrlTest extends TestCase
{
    use RefreshDatabase;

    public function test_make_url(): void
    {
        $user = Users::factory()->make();
        $name = "New York Times";
        $url = "https://www.nytimes.com/";

        $response = $this->postJson(
            '/api/urls/',
            [
                'userId' => $user->id,
                'name' => $name,
                'url' => $url
            ],
            [
                'Content-Type' => 'application/json'
            ]
        );

        $response->assertStatus(201);
    }

    public function test_list_all_urls(): void
    {
        $user = Users::factory()->make();
        Url::factory()->make();

        $response = $this->postJson(
            '/api/urls/listAll',
            [
                'userId' => $user->id
            ]
        );

        $response->assertStatus(200)->assertJson(
            fn (AssertableJson $json) => $json->where('user_id', $user->id)->etc()
        );
    }

    public function test_create_url_link(): void
    {
        $url = Url::factory()->make();
        $response = $this->getJson("/api/urls/$url->id",[]);

        $response->assertStatus(200)->assertJson(
            fn (AssertableJson $json) => $json->where('id', $url->id)->etc()
        );
    }
}
