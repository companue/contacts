<?php

namespace Companue\Contacts\Tests\Unit;

use Companue\Contacts\Facades\Contacts;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Companue\Contacts\Tests\TestCase;

class UnitTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function it_returns_ok()
    {
        $this->assertEquals('OK', Contacts::installed());
    }
}
