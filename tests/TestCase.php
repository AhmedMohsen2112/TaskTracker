<?php

namespace Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase {

    use CreatesApplication;
    use RefreshDatabase;

    protected function signIn($user = null,$guard='admin') {
        $user = factory_create(\App\Models\User::class);
        $this->actingAs($user,$guard);
        return $this;
    }

    protected function check_authenticated($guard = 'admin') {
        if (!auth()->guard($guard)->user()) {
            $this->expectException(\Illuminate\Auth\AuthenticationException::class);
        }
    }

}
