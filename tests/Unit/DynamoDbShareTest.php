<?php

namespace Tests\Unit;

use App\DynamoDbShare;
use Tests\TestCase;

/**
 * Class DynamoDbShareTest
 * @package Tests\Unit
 * @covers \App\DynamoDbShare
 */
class DynamoDbShareTest extends TestCase
{
    /** @test */
    function it_should_generate_an_uuid_as_primary_key()
    {
        $share = factory(DynamoDbShare::class)->make();

        $this->assertIsString($share->id);
        $this->assertEquals(36, strlen($share->id));
    }

    /** @test */
    function it_should_use_the_primary_key_as_route_key()
    {
        $share = factory(DynamoDbShare::class)->make();

        $this->assertIsString($share->getRouteKey());
        $this->assertEquals(36, strlen($share->getRouteKey()));
    }
}
