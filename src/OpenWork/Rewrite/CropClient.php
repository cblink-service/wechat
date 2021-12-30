<?php

namespace Cblink\Service\Wechat\OpenWork\Rewrite;

use EasyWeChat\OpenWork\Corp\Client;

/**
 * @property \Cblink\Service\Wechat\OpenWork\Auth\Client $service
 */
class CropClient extends Client
{
    /**
     *  获取授权链接
     *
     * @param string $preAuthCode
     * @param string $redirectUri
     * @param string $state
     * @return array|\Psr\Http\Message\ResponseInterface|string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getPreAuthorizationUrl(string $preAuthCode = '', string $redirectUri = '', string $state = '')
    {
        return $this->service->getAuthUrl(['url' => $redirectUri]);
    }
}
