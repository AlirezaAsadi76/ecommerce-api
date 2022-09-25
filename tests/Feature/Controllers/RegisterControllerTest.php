<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class RegisterControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testRegisterMethod()
    {
        $data=User::factory()->make()->toArray();
        $data['password']="123456789";
        unset($data['email_verified_at']);
        $response=$this->postJson(route('register'),$data);
        $response->assertOk();
        $response->assertJson(fn (AssertableJson $json) =>
        $json
            ->whereNot('authorisation.token',"")
            ->where('status',"success")
            ->where('message','User created successfully')
            ->where('authorisation.type',"bearer")
            ->etc());
        $this->assertEquals(['api'],request()->route()->middleware());
    }
}
