<?php

namespace Tests\Feature\Controllers\Admin;

use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\Feature\Controllers\ControllerHelperTesting;

class TagControllerTest extends BaseController
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

        $this->assertDatabaseHas('tags',$data);

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
        $tag = Tag::factory()->create();
        $data = Tag::factory()->make()->toArray();
        unset($data['created_at'],$data['updated_at']);

        $response = $this->responsePutJson(data: $data, params: ['tag' => $tag->id]);

        $this->assertDatabaseHas('tags', array_merge(['id' => $tag->id], $data));

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
        $tag = Tag::factory()->create();

        $response = $this->responseDeleteJson(params: ['tag' => $tag->id]);

        $this->assertDatabaseMissing('tags', $tag->toArray());

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
        return new Tag();
    }


    protected function actionAs()
    {
        return $this->actionAsWhenUserIsAdmin();
    }
}
