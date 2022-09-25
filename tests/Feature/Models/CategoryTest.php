<?php

namespace Tests\Feature\Models;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use ModelHelperTesting;

    public function testCategoryRelationshipWithProducts()
    {
        $count=rand(1,10);
        $category=Category::factory()->hasProducts($count)->create();

        $this->assertCount($count,$category->products);
        $this->assertTrue($category->products->first() instanceof Product);
    }
   protected function model(): Model
   {
       return new Category();
   }
}
