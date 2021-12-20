<?php

namespace Cblink\Service\Wechat\OpenPlatform\Configure;


use Cblink\Service\Wechat\Kernel\BaseApi;

/**
 * Class Client
 * @package Cblink\Service\Wechat\Config
 */
class Client extends BaseApi
{
    /**
     * 绑定账号
     *
     * @param array $payload
     * @return array|\Psr\Http\Message\ResponseInterface|string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function create(array $payload = [])
    {
        return $this->httpPost('api/open/config', $payload);
    }

    /**
     * 获取配置信息
     *
     * @param $uuid
     * @return array|\Psr\Http\Message\ResponseInterface|string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function show($uuid = null)
    {
        return $this->httpGet(sprintf('api/open/config/%s', $uuid ?: $this->app->getUuid()));
    }

    /**
     * 修改账号配置信息
     *
     * @param array $payload
     * @return array|\Psr\Http\Message\ResponseInterface|string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function update(array $payload = [])
    {
        return $this->httpPut("api/open/config/{$this->app->getUuid()}", $payload);
    }

    /**
     * 保存配置的url
     *
     * @param array $payload
     * @return array|\Psr\Http\Message\ResponseInterface|string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function storeUrl(array $payload = [])
    {
        return $this->httpPost("api/open/config/{$this->app->getUuid()}/url", $payload);
    }

    /**
     * 获取配置的url
     *
     * @param array $payload
     * @return array|\Psr\Http\Message\ResponseInterface|string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getUrl(array $payload = [])
    {
        return $this->httpGet("api/open/config/{$this->app->getUuid()}/url", $payload);
    }
}
