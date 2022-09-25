<?php

namespace Tests\Feature\Middlewares;

use App\Http\Middleware\IsAdmin;

use Illuminate\Http\Request;
use Tests\Feature\AdminHelperTesting;
use Tests\Feature\UserHelperTesting;
use Tests\TestCase;

class CheckUserIsAdminMiddlewareTest extends TestCase
{
    use AdminHelperTesting;
    use UserHelperTesting;

    public function testUserWhenIsNotAdmin()
    {
        $this->actionAsWhenUserIsNotAdmin();
        $request = Request::create('/admin','GET');
        $middleware = new IsAdmin();
        $response = $middleware->handle($request, function () {});

        $this->assertEquals($response->getStatusCode(), 302);
    }

    public function testUserWhenIsAdmin()
    {
        $this->actionAsWhenUserIsAdmin();
        $request = Request::create('/admin','GET');
        $middleware = new IsAdmin();
        $response = $middleware->handle($request, function () {});

        $this->assertEquals($response, null);
    }

    public function testUserWhenIsNotLoggedIn()
    {
        $request = Request::create('/admin','GET');
        $middleware = new IsAdmin();
        $response = $middleware->handle($request, function () {});

        $this->assertEquals($response->getStatusCode(), 302);
    }
}
