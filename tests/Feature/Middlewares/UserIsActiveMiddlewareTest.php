<?php

namespace Tests\Feature\Middlewares;

use App\Http\Middleware\UserIsActive;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Tests\TestCase;

class UserIsActiveMiddlewareTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testCanUserIsActiveInCacheWhenUserLoggedIn()
    {
        $user = User::factory()->user()->create();
        $this->actingAs($user);
        $request = Request::create('/','GET');
        $middleware = new UserIsActive();
        $response = $middleware->handle($request, function () {});

        $this->assertNull($response);
        $this->assertEquals('online', cache("user-{$user->id}-status"));
        $this->travel(11)->second();
        $this->assertNull(cache("user-{$user->id}-status") );
    }
    public function testCanUserIsActiveInCacheWhenUserNotLoggedIn()
    {
        $request = Request::create('/','GET');
        $middleware = new UserIsActive();
        $response = $middleware->handle($request,function () {});

        $this->assertNull($response);
    }

    public function testUserIsActiveMiddlewareSetInApiGroupMiddleware()
    {
        $user = User::factory()->user()->create();
        $this
            ->actingAs($user)
            ->get(route('shop.index'))
            ->assertOk();
        $this->assertEquals('online',cache("user-{$user->id}-status"));
        $this->travel(11)->second();
        $this->assertNull(cache("user-{$user->id}-status") );
        $this->assertEquals(\request()->route()->middleware(),['api']);
    }
}
