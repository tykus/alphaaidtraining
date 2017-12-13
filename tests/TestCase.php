<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\TestResponse;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    function setUp()
    {
        parent::setUp();
        
        TestResponse::macro('assertJsonHasErrors', function ($key) {
            $this->assertArrayHasKey('errors', $this->getData());
            dd($this->data);
        });
    }
}
