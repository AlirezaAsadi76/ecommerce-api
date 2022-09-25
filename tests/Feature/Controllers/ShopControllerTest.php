<?php

namespace Tests\Feature\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class ShopControllerTest extends TestCase
{

    public function testIndexMethod()
    {
        Category::factory(rand(1,10))->hasProducts(20)->create();

        $response = $this->getJson(route('shop.index'));
        $response
            ->assertOk()
            ->assertJson(fn (AssertableJson $json) =>
                $json
                    ->hasAll(['products','categories'])
                    ->etc()
            );
    }

    public function testShowMethod()
    {
        $this->withoutExceptionHandling();
        $product = Product::factory()->create();

        $response = $this->getJson(route('shop.show',['slug' => $product->slug]));
        $response
            ->assertOk()
            ->assertJson(fn (AssertableJson $json) =>
            $json
                ->where('slug' , $product->slug)
                ->etc()
            );
    }
//    public function testShowMethod()
//    {
//         Product::factory(rand(1,10))->state(['slug' => 'this is for testing'])->create();
//
//        $response = $this->getJson(route('shop.show',['slug' => 'this is for testing']));
//        $response
//            ->assertOk()
//            ->assertJson(fn (AssertableJson $json) =>
//            $json
//                ->hasAll(['products'])
//                ->each( fn (AssertableJson $element) =>
//                    $element->where('slug','this is for testing')
//                )
//                ->etc()
//            );
//    }
}
