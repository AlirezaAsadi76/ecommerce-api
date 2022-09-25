<?php

namespace Tests\Feature\Controllers\Admin;

use App\Models\Category;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\Feature\Controllers\ControllerHelperTesting;

class CategoryControllerTest extends BaseController
{
    use ControllerHelperTesting;

    public function testIndexMethod()
    {
        $response = $this->responseGetJson();
        $response
            ->assertOk()
            ->assertJson( fn (AssertableJson $json) =>
            $json
                ->each( fn (AssertableJson $element) =>
                $element
                    ->hasAll(['id','slug','name'])
                    ->etc()
                )
                ->etc()
            );
        $this->assertMiddleware();
    }

    public function testStoreMethod()
    {
        $data = Tag::factory()->make()->toArray();
        unset($data['created_at'],$data['updated_at']);

        $response = $this->responsePostJson(data: $data);

        $this->assertDatabaseHas('categories',$data);

        $response
            ->assertStatus(201)
            ->assertJson(fn (AssertableJson $json) =>
            $json->whereAll(
                [
                    'name' => $data['name'],
                    'slug' => $data['slug']
                ]
            )
                ->etc()
            );
        $this->assertMiddleware();
    }

    public function testUpdateMethod()
    {
        $category = Category::factory()->create();
        $data = Category::factory()->make()->toArray();
        unset($data['created_at'],$data['updated_at']);

        $response = $this->responsePutJson(data: $data, params: ['category' => $category->id]);

        $this->assertDatabaseHas('categories', array_merge(['id' => $category->id], $data));

        $response
            ->assertOk()
            ->assertJson(fn (AssertableJson $json) =>
            $json->whereAll(
                [
                    'name' => $data['name'],
                    'slug' => $data['slug']
                ]
            )
                ->etc()
            );
        $this->assertMiddleware();
    }

    public function testDestroyMethod()
    {
        $category = Category::factory()->create();

        $response = $this->responseDeleteJson(params: ['category' => $category->id]);

        $this->assertDatabaseMissing('categories', $category->toArray());

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
        return new Category();
    }


    protected function actionAs()
    {
        return $this->actionAsWhenUserIsAdmin();
    }
}
