<?php

namespace Tests\Feature\Models;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OrderTest extends TestCase
{
    use ModelHelperTesting;

    public function testOrderRelationshipWithUser()
    {
        $order=Order::factory()->for(User::factory())->create();

        $this->assertTrue(isset($order->user->id));
        $this->assertTrue($order->user instanceof User);
    }

    public function testOrderRelationshipWithProducts()
    {
        $count=rand(1,10);
        $order=Order::factory()->hasProducts($count)->create();

        $this->assertCount($count,$order->products);
        $this->assertTrue($order->products->first() instanceof Product);
    }

    protected function model(): Model
    {
       return new Order();
    }
}
