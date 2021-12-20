<?php
namespace Cblink\Service\Wechat\OpenPlatform\Rewrite;

use EasyWeChat\Kernel\Exceptions\RuntimeException;
use EasyWeChat\OpenPlatform\Auth\VerifyTicket as EasyWechatVerifyTicket;
use Hyperf\Utils\Arr;

class VerifyTicket extends EasyWechatVerifyTicket
{
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

        $ticket = $this->app->service->auth->getTicket();

        if (Arr::get($ticket, 'err_code') == 0){
            return Arr::get($ticket, 'data.ticket');
        }

        throw new RuntimeException('Credential "component_verify_ticket" does not exist in cache.');
    }
}
