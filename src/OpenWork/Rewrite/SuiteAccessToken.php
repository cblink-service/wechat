<?php

namespace Cblink\Service\Wechat\OpenWork\Rewrite;

use Hyperf\Utils\Arr;

class SuiteAccessToken extends \EasyWeChat\OpenWork\SuiteAuth\AccessToken
{

    /**
     * 获取token
     *
     * @param array $credentials
     * @param $toArray
     * @return array
     */
    public function requestToken(array $credentials, $toArray = false)
    {
        $response = $this->app->service->auth->getAccessToken();

        $expires = (int) Arr::get($response, 'data.created_time', time()) + 7200 - time();

        return [
            $this->tokenKey => Arr::get($response, 'data.token'),
            'expires_in' => $expires,
        ];
    }

}
