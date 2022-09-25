<?php

namespace Tests\Feature\Controllers\Admin;

use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductResource;
use App\Models\Category;
use App\Models\Product;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\Feature\Controllers\ControllerHelperTesting;
use Tests\TestCase;

class ProductControllerTest extends BaseController
{
    use ControllerHelperTesting;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testIndexMethod()
    {
        $response=$this->responseGetJson();
        $response
            ->assertOk()
            ->assertJson(fn (AssertableJson $json) =>
                $json
                    ->hasAll(['data','links'])
                    ->etc()
            );

       $this->assertMiddleware();
    }

    public function testCreateMethod()
    {
        $response=$this->responseGetJson(name: 'create');
        $response
            ->assertOk()
            ->assertJson(fn (AssertableJson $json) =>
            $json
                ->hasAll(['tags','categories'])
                ->etc()
            );

        $this->assertMiddleware();
    }

    public function testStoreMethod()
    {
        $tags = Tag::factory(10)->create();
        $category = Category::factory()->create();
        $data = Product::factory()->make()->toArray();
        unset($data['created_at'], $data['updated_at']);
        $data['category_id'] = $category->id;

        $response=$this->responsePostJson(data: array_merge($data, ['tags' => $tags->pluck('id')->toArray()]));

        $this->assertDatabaseHas('products', $data);

        $product = Product::where($data)->first();
        $this->assertEquals($product->category->id, $category->id);
        $this->assertEquals($product->tags->pluck('id')->toArray(), $tags->pluck('id')->toArray());

        $response
            ->assertOk()
            ->assertJson(fn (AssertableJson $json) =>
            $json
                ->hasAll(['category','tags'])
                ->where('id',$product->id)
                ->where('name',$product->name)
                ->where('slug',$product->slug)
                ->etc()
            );
        $this->assertMiddleware();
    }

    public function testEditMethod()
    {
        $product = Product::factory()->create();
        Tag::factory(10)->create();
        Category::factory(10)->create();

        $response = $this->responseGetJson('edit', params: ['product' => $product->id]);
        $response
            ->assertOk()
            ->assertJson(fn (AssertableJson $json) =>
                $json
                    ->hasAll(['product','categories','tags'])
                    ->where('product.id',$product->id)
                    ->where('product.name',$product->name)
                    ->where('product.slug',$product->slug)
                    ->etc()
            );

        $this->assertMiddleware();
    }

    public function testUpdateMethod()
    {
        $product = Product::factory()->hasTags(5)->create();
        $data = Product::factory()->make()->toArray();
        $tags = Tag::factory(10)->create();
        unset($data['created_at'], $data['updated_at']);

        $response = $this->responsePutJson(
            data: array_merge(['tags' => $tags->pluck('id')->toArray()], $data),
            params: ['product' => $product->id]
        );
        $response
            ->assertOk()
            ->assertJson(fn (AssertableJson $json) =>
            $json
                ->whereAll([
                    'id' => $product->id,
                    'name' => $data['name'],
                    'slug' => $data['slug'],
                    'category.id' => $data['category_id'],
                    'description' => $data['description']
                ])
                ->etc()
            );

        $updateProduct = Product::where($data)->first();
        $this->assertDatabaseHas('products', array_merge(['id' => $product->id], $data));
        $this->assertEquals(
            $tags->pluck('id')->toArray(),
            $updateProduct->tags->pluck('id')->toArray()
        );
        $this->assertMiddleware();
    }

    public function testDestroyMethod()
    {
        $product = Product::factory()->hasTags(10)->create();

        $response = $this->responseDeleteJson(params: ['product' => $product->id]);

        $this->assertEmpty($product->tags);
        $data=$product->toArray();
        unset($data['tags']);
        $this->assertDatabaseMissing('products', $data);

        $response
            ->assertOk()
            ->assertJson(fn (AssertableJson $json) =>
                $json
                    ->where('success','deleted successfully')
                    ->etc()
            );

        $this->assertMiddleware();
    }

    protected function model(): Model
    {
        return new Product();
    }

    protected function actionAs()
    {
        return $this->actionAsWhenUserIsAdmin();
    }
}
