<?php

namespace Tests\Unit;

use App\Share;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

/**
 * Class ShareTest
 * @package Tests\Unit
 * @covers \App\Share
 */
class ShareTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function it_casts_json_data_to_array()
    {
        $share = factory(Share::class)->create([
            'data' => [
                'key' => 'value'
            ]
        ]);

        $this->assertIsArray($share->data);
        $this->assertEquals(['key' => 'value'], $share->data);
    }

    /** @test */
    function it_should_generate_an_uuid_as_primary_key()
    {
        $share = factory(Share::class)->create();

        $this->assertIsString($share->id);
        $this->assertEquals(36, strlen($share->id));
    }

    /** @test */
    function it_should_use_the_primary_key_as_route_key()
    {
        $share = factory(Share::class)->create();

        $this->assertIsString($share->getRouteKey());
        $this->assertEquals(36, strlen($share->getRouteKey()));
    }
}
