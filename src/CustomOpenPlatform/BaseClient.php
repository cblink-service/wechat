<?php

namespace Cblink\Service\Wechat\CustomOpenPlatform;

use InvalidArgumentException;
use EasyWeChat\OpenPlatform\Base\Client;

/**
 * @property-read Application $app
 */
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

        if (!$response->success()){
            throw new InvalidArgumentException('Get Url Fail: '. $response->errMsg());
        }

        return $response->get('url');
    }

    /**
     * 绑定公众号/小程序到账户下
     *
     * @param string $appId
     * @return bool
     */
    public function bindAppId(string $appId)
    {
        $result = $this->app->service->auth->bindAppId($appId);

        return $result->success();
    }
}
