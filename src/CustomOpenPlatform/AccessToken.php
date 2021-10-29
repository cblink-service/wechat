<?php

namespace Cblink\Service\Wechat\CustomOpenPlatform;


use Cblink\Service\Wechat\OpenPlatform;

/**
 * Class AccessToken
 * @package Cblink\Service\Wechat\OpenPlatform
 * @property-read Application $app
 */
class AccessToken extends \EasyWeChat\OpenPlatform\Auth\AccessToken
{
    /**
     * 获取token
     *
     * @param array $credentials
     * @param false $toArray
     * @return array|\EasyWeChat\Kernel\Support\Collection|\Illuminate\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     */
    public function requestToken(array $credentials, $toArray = false)
    {
        $response = $this->app->service->auth->getAccessToken();

        $expires = (int) $response->get('created_time') + 7200 - time();

        return [
            $this->tokenKey => $response->get('token'),
            'expires_in' => $expires
        ];
    }
}
