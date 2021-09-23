<?php

namespace Aashirhaq\Stub\Tests;

use Aashirhaq\Stub\StubServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase
{
    public function setUp(): void
    {
      parent::setUp();
    }

    protected function getPackageProviders($app)
    {
      return [
        StubServiceProvider::class,
      ];
    }

    protected function getEnvironmentSetUp($app)
    {
      // perform environment setup
    }
}
