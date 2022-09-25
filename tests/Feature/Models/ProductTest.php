<?php

namespace Tests\Feature\Models;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductTest extends TestCase
{
   use ModelHelperTesting;

    public function testProductRelationshipWithCategory()
    {
        $product=Product::factory()->for(Category::factory())->create();

        $this->assertTrue(isset($product->category->id));
        $this->assertTrue($product->category instanceof Category);
    }

    public function testProductRelationshipWithTags()
    {
        $count=rand(1,10);
        $product=Product::factory()->hasTags($count)->create();

        $this->assertCount($count,$product->tags);
        $this->assertTrue($product->tags->first() instanceof Tag);
    }
    public function testUserRelationshipWithOrders()
    {
        $count=rand(1,10);
        $product=Product::factory()->hasOrders($count)->create();

        $this->assertCount($count,$product->orders);
        $this->assertTrue($product->orders->first() instanceof Order);
    }

    protected function model(): Model
    {
       return new Product();
    }
}
