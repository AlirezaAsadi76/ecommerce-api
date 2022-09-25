<?php

namespace Tests\Feature\Controllers\Admin;

use App\Models\Order;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\Feature\Controllers\ControllerHelperTesting;

class OrderControllerTest extends BaseController
{
    use ControllerHelperTesting;

    public function testIndexMethod()
    {
//        $this->withoutExceptionHandling();
        $response = $this->responseGetJson();
        $response
            ->assertOk()
            ->assertJson( fn (AssertableJson $json) =>
            $json
                ->each( fn (AssertableJson $element) =>
                $element
                    ->hasAll(['id','user','billing_email','billing_name'])
                    ->etc()
                )
                ->etc()
            );
        $this->assertMiddleware();
    }
    protected function model(): Model
    {
        return new Order();
    }

    protected function actionAs()
    {
        return $this->actionAsWhenUserIsAdmin();
    }
}
