<?php

namespace Tests\Feature;

use App\Models\User;

trait AdminHelperTesting
{
    protected function actionAsWhenUserIsAdmin(): self
    {
        return $this->actingAs(User::factory()->admin()->create());
    }
}
