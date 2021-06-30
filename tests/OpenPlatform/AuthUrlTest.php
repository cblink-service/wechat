<?php
namespace Cblink\Service\Wechat\Tests\Platform;

use Cblink\Service\Wechat\Tests\TestCase;
use function GuzzleHttp\default_user_agent;

/**
 * Class AuthUrlTest
 * @package Cblink\Service\Wechat\Tests\Platform
 */
class AuthUrlTest extends TestCase
{
    public function testAuthPreUrl()
    {
        $authUrl = $this->openPlatform()
            ->getPreAuthorizationUrl('http://localhost', ['auth_type' => 3]);

        // var_dump($authUrl);

        $this->assertTrue((boolean) filter_var($authUrl, FILTER_VALIDATE_URL));
    }

    public function testTicket()
    {
        $ticket = $this->openPlatform()
            ->verify_ticket
            ->getTicket();

        // var_dump($ticket);

        $this->assertIsString($ticket);
    }

    public function testAccessToken()
    {
        $token = $this->openPlatform()
            ->access_token
            ->getToken();

        $this->assertIsString($token['component_access_token']);
    }
}
