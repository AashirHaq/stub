<?php

namespace Aashirhaq\Stub\Tests\Unit;

use Aashirhaq\Stub\Tests\TestCase;
use Illuminate\Support\Facades\Artisan;

class StubTest extends TestCase
{
    public function test_stub_generation()
    {
        Artisan::call('generate:skeleton', ['name' => 'Product']);

        $this->assertTrue(true);
    }
}