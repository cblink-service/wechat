<?php

namespace Cblink\Service\Wechat\OpenPlatform\Auth;

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
        return $this->httpGet('api/open/auth/url', array_merge([
            'uuid' => $this->app->getUuid(),
            'auth_type' => 1
        ], $payload));
    }

    /**
     * 绑定公众号到应用
     *
     * @param $appId
     * @return array|\Psr\Http\Message\ResponseInterface|string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function bindAppId($appId)
    {
        return $this->httpPost('api/open/auth/bind', [
            'uuid' => $this->app->getUuid(),
            'app_id' => $appId
        ]);
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
        return $this->httpGet("api/open/auth/{$this->app->getUuid()}/ticket", $payload);
    }

    /**
     * 获取access token
     *
     * @param array $payload
     * @return array|\Psr\Http\Message\ResponseInterface|string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getAccessToken(array $payload = [])
    {
        return $this->httpGet("api/open/auth/{$this->app->getUuid()}/token", $payload);
    }
}
