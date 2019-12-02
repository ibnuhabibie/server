<?php

namespace Tests\Unit\Http\Requests;

use App\Http\Requests\DeleteShareRequest;
use App\Share;
use Tests\TestCase;

/**
 * Class DeleteShareRequestTest
 * @package Tests\Unit\Http\Requests
 * @covers \App\Http\Requests\DeleteShareRequest
 */
class DeleteShareRequestTest extends TestCase
{
    protected $request;

    public function setUp(): void
    {
        parent::setUp();

        $this->request = $this->createPartialMock(DeleteShareRequest::class, ['route', 'get']);
    }

    /** @test */
    function it_should_not_authorize_the_request_if_an_existing_share_is_not_provided()
    {
        $this->request
            ->expects($this->once())
            ->method('route')
            ->with('share')
            ->willReturn(null);

        $this->assertFalse($this->request->authorize());
    }

    /** @test */
    function it_should_not_authorize_the_request_if_the_token_does_not_match()
    {
        $share = factory(Share::class)->make([
            'token' => 123456
        ]);

        $this->request
            ->expects($this->once())
            ->method('route')
            ->with('share')
            ->willReturn($share);

        $this->request
            ->expects($this->once())
            ->method('get')
            ->with('token')
            ->willReturn(654321);

        $this->assertFalse($this->request->authorize());
    }

    /** @test */
    function it_should_authorize_the_request_if_the_token_matches()
    {
        $share = factory(Share::class)->make([
            'token' => 123456
        ]);

        $this->request
            ->expects($this->once())
            ->method('route')
            ->with('share')
            ->willReturn($share);

        $this->request
            ->expects($this->once())
            ->method('get')
            ->with('token')
            ->willReturn(123456);

        $this->assertTrue($this->request->authorize());
    }
}
