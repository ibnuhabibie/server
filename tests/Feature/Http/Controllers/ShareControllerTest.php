<?php

namespace Tests\Feature\Http\Controllers;

use App\Http\Controllers\ShareController;
use App\Share;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Str;
use Tests\TestCase;

/**
 * Class ShareControllerTest
 * @package Tests\Feature\Http\Controllers
 * @see ShareController
 */
class ShareControllerTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function it_should_return_404_when_visiting_a_share_that_does_not_exist()
    {
        $response = $this->get('/share/' . Str::random(10));

        $response->assertNotFound();
    }

    /** @test */
    function it_should_show_the_public_share_view()
    {
        $share = factory(Share::class)->create();

        $response = $this->get('/share/' . $share->getRouteKey());

        $response->assertOk();
        $response->assertViewHas('share', $share);
        $response->assertDontSeeText('Delete');
    }

    /** @test */
    function it_should_not_show_the_admin_share_view_if_the_request_has_the_wrong_token()
    {
        $share = factory(Share::class)->create([
            'token' => 123456
        ]);

        $response = $this->get('/share/' . $share->getRouteKey() . '?' . http_build_query([
            'token' => 654321
        ]));

        $response->assertOk();
        $response->assertViewHas('share', $share);
        $response->assertDontSeeText('Delete');
    }

    /** @test */
    function it_should_show_the_admin_share_view_if_the_request_has_the_correct_token()
    {
        $share = factory(Share::class)->create();

        $response = $this->get('/share/' . $share->getRouteKey() . '?' . http_build_query([
            'token' => $share->token
        ]));

        $response->assertOk();
        $response->assertViewHas('share', $share);
        $response->assertSeeText('Delete');
    }

    /** @test */
    function it_should_return_404_when_deleting_a_share_that_does_not_exist()
    {
        $response = $this->delete('/share/' . Str::random(10));

        $response->assertNotFound();
    }

    /** @test */
    function it_should_fail_to_delete_a_share_if_the_token_does_not_match()
    {
        $share = factory(Share::class)->create([
            'token' => 123456
        ]);

        $response = $this->delete('/share/' . $share->getRouteKey(), [
            'token' => 654321
        ]);

        $response->assertForbidden();
    }

    /** @test */
    function it_should_successfully_delete_a_share()
    {
        $share = factory(Share::class)->create();

        $response = $this->delete('/share/' . $share->getRouteKey(), [
            'token' => $share->token
        ]);

        $response->assertRedirect('/');

        $this->assertDatabaseMissing('shares', [
            'id' => $share->id
        ]);
    }
}
