<?php

namespace Tests\Feature\Models;

use App\Models\Cart;
use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testInsertData()
    {
        $data=User::factory()->make()->toArray();
        $data['password']="123456789";
        User::create($data);

        $this->assertDatabaseHas('users',$data);
    }

    public function testUserRelationshipWithCarts()
    {
        $count=rand(1,10);
        $user=User::factory()->hasCarts($count)->create();

        $this->assertCount($count,$user->carts);
        $this->assertTrue($user->carts->first() instanceof Cart);
    }

    public function testUserRelationshipWithOrders()
    {
        $count=rand(1,10);
        $user=User::factory()->hasOrders($count)->create();

        $this->assertCount($count,$user->orders);
        $this->assertTrue($user->orders->first() instanceof Order);
    }
}
