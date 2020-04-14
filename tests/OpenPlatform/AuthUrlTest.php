<?php
namespace Cblink\Service\Wechat\Tests\Platform;

use Cblink\Service\Wechat\Tests\TestCase;

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

        $this->assertTrue((boolean) filter_var($authUrl, FILTER_VALIDATE_URL));
    }

    public function testTicket()
    {
        $ticket = $this->openPlatform()
            ->verify_ticket
            ->getTicket();

        $this->assertIsString($ticket);
    }
}
