<?php

namespace Tests\Feature\Controllers\User;

use App\Models\Cart;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\Feature\Controllers\ControllerHelperTesting;
use Tests\TestCase;

class CartControllersTest extends BaseController
{

    use ControllerHelperTesting;

    public function testIndexMethod()
    {
        $this->withoutExceptionHandling();
        $user = User::factory()->create();
        Cart::factory(3)->state(['user_id' => $user->id])->hasItems(10)->create();

        $response = $this->actionAs($user)->getJson(route('carts.index'));
        $response
            ->assertOk()
            ->assertJson( fn (AssertableJson $json) =>
                $json
                    ->has('success')
                    ->etc()
            );

        $this->assertMiddleware(['api','auth']);
    }

    protected function model(): Model
    {
        return new Cart();
    }

    protected function actionAs()
    {
        return $this->actionAsWhenUserIsNotAdmin();
    }
}
