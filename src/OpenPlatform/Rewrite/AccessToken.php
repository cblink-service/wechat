<?php

namespace Cblink\Service\Wechat\OpenPlatform\Rewrite;


use Hyperf\Utils\Arr;

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

        $expires = (int) Arr::get($response, 'data.created_time', time()) + 7200 - time();

        return [
            $this->tokenKey => Arr::get($response, 'data.token'),
            'expires_in' => $expires
        ];
    }
}
