<?php

namespace Tests\Unit\Http\Middleware;

use App\Http\Middleware\UserAgentAuth;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Tests\TestCase;

/**
 * Class UserAgentAuthTest
 * @package Tests\Unit\Http\Middleware
 * @covers UserAgentAuth
 */
class UserAgentAuthTest extends TestCase
{
    /** @test */
    function it_should_throw_not_found_http_exception_if_the_request_does_not_contain_the_user_agent_header()
    {
        $this->expectException(NotFoundHttpException::class);

        $request = Request::create('/share', 'POST');

        $middleware = new UserAgentAuth();

        $middleware->handle($request, function () {});
    }

    /** @test */
    function it_should_throw_not_found_http_exception_if_the_request_does_not_contain_the_correct_user_agent_value()
    {
        $this->expectException(NotFoundHttpException::class);

        $request = Request::create('/share', 'POST', [], [], [], [
            'HTTP_USER_AGENT' => 'Laracatch_WRONG_Client'
        ]);

        $middleware = new UserAgentAuth();

        $middleware->handle($request, function () {});
    }

    /** @test */
    function it_should_allow_the_request_if_it_contains_the_correct_user_agent_value()
    {
        $request = Request::create('/share', 'POST', [], [], [], [
            'HTTP_USER_AGENT' => 'Laracatch/Client'
        ]);

        $middleware = new UserAgentAuth();

        $ret = $middleware->handle($request, function ()
        {
            return true;
        });

        $this->assertTrue($ret);
    }
}
