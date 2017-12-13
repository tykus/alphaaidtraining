<?php

namespace Tests;

use PHPUnit\Framework\Assert;
use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    function setUp()
    {
        parent::setUp();

        TestResponse::macro('assertJsonHasErrors', function ($key) {
            Assert::assertArrayHasKey('errors', json_decode($this->getContent(), true));
        });
    }
}
