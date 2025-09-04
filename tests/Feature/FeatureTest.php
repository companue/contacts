<?php

namespace Companue\Contacts\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Companue\Contacts\Tests\TestCase;

class FeatureTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function can_do_somthing()
    {
        $this->assertTrue(true);
    }
}
