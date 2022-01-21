<?php

namespace Cblink\Service\Wechat\OpenPlatform\Rewrite;

use EasyWeChat\OpenPlatform\Base\Client;
use Hyperf\Utils\Arr;
use InvalidArgumentException;

class BaseClient extends Client
{
    /**
     * @param array $payload
     * @return string
     * @throws InvalidArgumentException
     */
    public function getAuthorizationUrl(array $payload = [])
    {
        $response = $this->app->service->auth->getAuthUrl($payload);

        if (Arr::get($response, 'err_code') != 0){
            throw new InvalidArgumentException('Get Url Fail: '. Arr::get($response, 'err_msg'));
        }

        return Arr::get($response, 'data.url');
    }

    /**
     * 绑定公众号/小程序到账户下
     *
     * @param string $appId
     * @return bool
     */
    public function bindAppId(string $appId)
    {
        $response = $this->app->service->auth->bindAppId($appId);

        return Arr::get($response, 'err_code') == 0;
    }

    /**
     * 获取web端授权链接
     *
     * @param string $callbackUrl
     * @param array $optional
     * @return string
     */
    public function getPreAuthorizationUrl(string $callbackUrl, $optional = []): string
    {
        return $this->getAuthorizationUrl(array_merge($optional,[
            'type' => 'scan',
            'url' =>  $callbackUrl,
        ]));
    }

    /**
     * 获取移动端授权链接
     * @param string $callbackUrl
     * @param array $optional
     * @return string
     */
    public function getMobilePreAuthorizationUrl(string $callbackUrl, $optional = []): string
    {
        return $this->getAuthorizationUrl(array_merge($optional,[
            'type' => 'mobile',
            'url' =>  $callbackUrl
        ]));
    }
}
