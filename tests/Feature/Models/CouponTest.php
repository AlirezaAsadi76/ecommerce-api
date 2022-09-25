<?php

namespace Tests\Feature\Models;

use App\Models\Coupon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CouponTest extends TestCase
{
   use ModelHelperTesting;

    protected function model(): Model
    {
        return new Coupon();
    }
}
