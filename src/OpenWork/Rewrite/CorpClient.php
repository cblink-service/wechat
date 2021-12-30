<?php

namespace Cblink\Service\Wechat\OpenWork\Rewrite;

use Cblink\Service\Wechat\Kernel\WechatException;
use EasyWeChat\OpenWork\Corp\Client;
use Hyperf\Utils\Arr;

class CorpClient extends Client
{
    /**
     *  获取授权链接
     *
     * @param string $authType
     * @param string $redirectUri
     * @param string $state
     * @return array|\Psr\Http\Message\ResponseInterface|string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getPreAuthorizationUrl(string $authType = '', string $redirectUri = '', string $state = '')
    {
        $response = $this->app->service->auth->getAuthUrl(['url' => $redirectUri, 'auth_type' => $authType]);

        if (!Arr::has($response, 'data.url')) {
            throw new WechatException(sprintf('pre auth url get fail: %s', $response['err_msg']));
        }

        return $response['data']['url'];
    }
}
