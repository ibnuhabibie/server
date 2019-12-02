<?php

namespace Tests\Unit\Http\Requests;

use App\Http\Requests\ShareRequest;
use Illuminate\Support\Facades\Redis;
use Tests\TestCase;

/**
 * Class ShareRequestTest
 * @package Tests\Unit\Http\Requests
 * @covers \App\Http\Requests\ShareRequest
 */
class ShareRequestTest extends TestCase
{
    protected $rules;

    public function setUp(): void
    {
        parent::setUp();

        $this->rules = with(new ShareRequest())->rules();
    }

    /** @test */
    function it_should_authorize_the_request_if_it_is_unique()
    {
        $request = new ShareRequest();

        Redis::shouldReceive('exists')
            ->once()
            ->andReturn(false);

        $this->assertTrue($request->authorize());
    }

    /** @test */
    function it_should_not_authorize_the_request_if_it_is_not_unique()
    {
        $request = new ShareRequest();

        Redis::shouldReceive('exists')
            ->once()
            ->andReturn(true);

        $this->assertFalse($request->authorize());
    }

    /** @test */
    function it_should_fail_validation_if_report_is_not_provided()
    {
        $this->assertFalse(app()->get('validator')->make([
            'tabs' => [],
            'lineSelection' => 'random'
        ], $this->rules)->passes());
    }

    /** @test */
    function it_should_fail_validation_if_tabs_is_not_provided()
    {
        $this->assertFalse(app()->get('validator')->make([
            'report' => [],
            'lineSelection' => 'random'
        ], $this->rules)->passes());
    }

    /** @test */
    function it_should_fail_validation_if_lineSelection_is_not_provided()
    {
        $this->assertFalse(app()->get('validator')->make([
            'report' => [],
            'tabs' => []
        ], $this->rules)->passes());
    }

    function it_should_pass_validation_if_all_parameters_are_provided()
    {
        $this->assertTrue(app()->get('validator')->make([
            'report' => [],
            'tabs' => [],
            'lineSelection' => 'random'
        ], $this->rules)->passes());
    }
}
