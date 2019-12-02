<?php

namespace Tests\Feature\Http\Api;

use App\Share;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Redis;
use Tests\TestCase;

class ShareControllerTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function it_should_return_not_found_if_the_request_does_not_use_the_correct_user_agent()
    {
        $response = $this->json('POST', route('api.share'), [
            'error' => [],
            'tabs' => [],
            'lineSelection' => 'random'
        ]);

        $response->assertNotFound();
    }

    /** @test */
    function it_should_store_a_new_share_and_return_the_links_for_it_if_the_error_is_unique()
    {
        Redis::shouldReceive('exists')
            ->once()
            ->andReturn(false);

        Redis::shouldReceive('set')
            ->once();

        $response = $this->json('POST', route('api.share'), [
            'error' => [
                'key' => 'value'
            ],
            'tabs' => [
                'one' => 'two'
            ],
            'lineSelection' => ''
        ], [
            'HTTP_USER_AGENT' => 'Laracatch/Client'
        ]);

        $share = Share::first();

        $response->assertOk();
        $response->assertJsonStructure([
            'public_url',
            'owner_url'
        ]);

        $this->assertDatabaseHas('shares', [
            'id' => $share->id
        ]);

        $this->assertEquals(route('share.show', $share->getRouteKey()), $response->getOriginalContent()['public_url']);
        $this->assertEquals(route('share.show', [
            'share' => $share->getRouteKey(),
            'token' => $share->token
        ]), $response->getOriginalContent()['owner_url']);
    }

    /** @test */
    function it_should_store_a_new_share_with_file_and_line_selection_if_the_error_is_unique()
    {
        Redis::shouldReceive('exists')
            ->once()
            ->andReturn(false);

        Redis::shouldReceive('set')
            ->once();

        $lineSelection = '#F2L17';

        $response = $this->json('POST', route('api.share'), [
            'error' => [
                'key' => 'value'
            ],
            'tabs' => [
                'one' => 'two'
            ],
            'lineSelection' => $lineSelection
        ], [
            'HTTP_USER_AGENT' => 'Laracatch/Client'
        ]);

        $share = Share::first();

        $response->assertOk();
        $response->assertJsonStructure([
            'public_url',
            'owner_url'
        ]);

        $this->assertDatabaseHas('shares', [
            'id' => $share->id,
            'selection' => '#F2L17'
        ]);

        $this->assertEquals(route('share.show', $share->getRouteKey()) . $lineSelection, $response->getOriginalContent()['public_url']);
        $this->assertEquals(route('share.show', [
            'share' => $share->getRouteKey(),
            'token' => $share->token
        ]) . $lineSelection, $response->getOriginalContent()['owner_url']);
    }

    /** @test */
    function it_should_not_store_a_new_share_if_the_error_is_duplicated()
    {
        Redis::shouldReceive('exists')
            ->once()
            ->andReturn(true);

        $response = $this->json('POST', route('api.share'), [
            'error' => [
                'key' => 'value'
            ],
            'tabs' => [
                'one' => 'two'
            ],
            'lineSelection' => 'random'
        ], [
            'HTTP_USER_AGENT' => 'Laracatch/Client'
        ]);

        $response->assertForbidden();
    }
}
