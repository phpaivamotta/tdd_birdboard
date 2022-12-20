<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function signIn($user = null) 
    {
        if($user) {
            return $this->actingAs($user);
        }

        return $this->actingAs(User::factory()->create());
    }
}
