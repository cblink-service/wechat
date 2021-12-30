<?php

namespace Cblink\Service\Wechat\OpenWork\Auth;

use Cblink\Service\Wechat\Kernel\BaseApi;

/**
 * Class Client
 * @package Cblink\Service\Wechat\Work
 */
class Client extends BaseApi
{
    /**
     * 获取授权url
     *
     * @param array $payload
     * @return array|\Psr\Http\Message\ResponseInterface|string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getAuthUrl(array $payload = [])
    {
        return $this->httpGet('api/wework/auth/url', array_merge([
            'uuid' => $this->app->getUuid(),
        ], $payload));
    }

    /**
     * 获取ticket
     *
     * @param array $payload
     * @return array|\Psr\Http\Message\ResponseInterface|string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getTicket(array $payload = [])
    {
        return $this->httpGet("api/wework/auth/{$this->app->getUuid()}/ticket", $payload);
    }
}
