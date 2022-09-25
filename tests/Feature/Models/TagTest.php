<?php

namespace Tests\Feature\Models;


use App\Models\Product;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TagTest extends TestCase
{
    use ModelHelperTesting;

    public function testCategoryRelationshipWithProducts()
    {
        $count=rand(1,10);
        $category=Tag::factory()->hasProducts($count)->create();

        $this->assertCount($count,$category->products);
        $this->assertTrue($category->products->first() instanceof Product);
    }

    protected function model(): Model
    {
       return new Tag();
    }
}
