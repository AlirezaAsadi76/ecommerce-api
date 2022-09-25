<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Testing\Fluent\AssertableJson;
use Illuminate\Testing\TestResponse;

trait ControllerHelperTesting
{
    protected function responseGetJson(string $name = 'index', array $params = null): TestResponse
    {
        $model = $this->model();
        $model::factory(10)->create();
        $route = $params ? route($model->getTable().'.'.$name, $params) : route($model->getTable().'.'.$name);
        return $this
            ->actionAs()
            ->getJson($route);
    }

    protected function responsePostJson(array $data, string $name = 'store', array $params = null): TestResponse
    {
        $model = $this->model();
        $route = $params ? route($model->getTable().'.'.$name, $params) : route($model->getTable().'.'.$name);

        return $this
            ->actionAs()
            ->postJson($route,$data);
    }

    protected function responsePutJson(array $data, string $name = 'update',array $params = null): TestResponse
    {
        $model = $this->model();
        $route = $params ? route($model->getTable().'.'.$name, $params) : route($model->getTable().'.'.$name);

        return $this
            ->actionAs()
            ->putJson($route, $data);
    }

    protected function responseDeleteJson(string $name = 'destroy', array $params = null): TestResponse
    {
        $model = $this->model();
        $route = $params ? route($model->getTable().'.'.$name, $params) : route($model->getTable().'.'.$name);

        return $this
            ->actionAs()
            ->deleteJson($route);
    }

    protected function assertMiddleware(array $middleware = ['api','auth','admin'])
    {
        $this->assertEquals(request()->route()->middleware(), $middleware);
    }




    abstract protected function model(): Model;
    abstract protected function actionAs();
}
