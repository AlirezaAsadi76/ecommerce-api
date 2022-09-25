<?php

namespace Tests\Feature\Models;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Tests\TestCase;

class CartTest extends TestCase
{
    use ModelHelperTesting;

    public function testCartRelationshipWithCartItems()
    {
        $count = rand(1,10);
        $cart = Cart::factory()->hasItems($count)->create();

        $this->assertTrue($cart->items()->first() instanceof CartItem);
        $this->assertCount($count, $cart->items);
    }

    public function testCartRelationshipWithUser()
    {
        $cart = Cart::factory()->for(User::factory())->create();

        $this->assertTrue(isset($cart->user->id));
        $this->assertTrue($cart->user instanceof User);
    }

    protected function model(): Model
    {
        return new Cart();
    }

}
