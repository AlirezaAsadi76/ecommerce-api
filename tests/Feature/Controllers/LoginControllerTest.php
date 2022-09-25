<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class LoginControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testLoginMethodWhenUserIsRegister()
    {
        $user=User::factory()->create()->toArray();

        $response=$this->postJson(route('login'),[
            "email" => $user['email'],
            "password" => "123456789"
            ]);
        $response->assertOk();
        $response->assertJson(fn (AssertableJson $json) =>
        $json
            ->whereNot('authorisation.token',"")
            ->where('status',"success")
            ->where('authorisation.type',"bearer")
            ->etc());
        $this->assertEquals(['api','throttle:login'],request()->route()->middleware());
    }
    public function testLoginMethodWhenUserUnauthorized()
    {
        $response=$this->postJson(route('login'),[
            "email" => "ali@gmail.com",
            "password" => "123456789"
        ]);
        $response->assertStatus(401);
        $response->assertJson(fn (AssertableJson $json) =>
        $json
            ->where('status',"error")
            ->where('message',"Unauthorized")
            ->etc());
        $this->assertEquals(['api','throttle:login'],request()->route()->middleware());
    }
}
