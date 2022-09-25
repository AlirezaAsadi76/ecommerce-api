<?php

namespace Tests\Feature;

use App\Models\User;

trait UserHelperTesting
{
    protected function actionAsWhenUserIsNotAdmin(): self
    {
        return $this->actingAs(User::factory()->user()->create());
    }
}
