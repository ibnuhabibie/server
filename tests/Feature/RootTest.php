<?php

namespace Tests\Feature;

use Tests\TestCase;

class RootTest extends TestCase
{
    /** @test */
    function it_should_visit_the_root_url()
    {
        $response = $this->get('/');

        $response->assertOk();
    }
}
