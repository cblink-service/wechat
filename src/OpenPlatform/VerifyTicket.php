<?php
namespace Cblink\Service\Wechat\OpenPlatform;

use EasyWeChat\Kernel\Exceptions\RuntimeException;
use EasyWeChat\OpenPlatform\Application;
use Cblink\Service\Wechat\OpenPlatform\Application as OpenPlatformApp;
use EasyWeChat\OpenPlatform\Auth\VerifyTicket as EasyWechatVerifyTicket;

/**
 * Class VerfyTicket
 * @package Cblink\Service\Wechat\OpenPlatform
 */
class VerifyTicket extends EasyWechatVerifyTicket
{
    /**
     * @var \Cblink\Service\Wechat\OpenPlatform\Application
     */
    protected $openPlatformApp;

    public function __construct(Application $app, OpenPlatformApp $openPlatformApp)
    {
        parent::__construct($app);
        $this->openPlatformApp = $openPlatformApp;
    }

    /**
     * Get the credential `component_verify_ticket` from cache.
     *
     * @return string
     *
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidArgumentException
     * @throws \EasyWeChat\Kernel\Exceptions\RuntimeException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function getTicket(): string
    {
        if ($cached = $this->getCache()->get($this->getCacheKey())) {
            return $cached;
        }

        $ticket = $this->openPlatformApp->auth->getTicket();

        if ($ticket->success()){
            return $ticket->get('ticket');
        }

        throw new RuntimeException('Credential "component_verify_ticket" does not exist in cache.');
    }
}
