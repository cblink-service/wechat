<?php

namespace Cblink\Service\Wechat\CustomOpenPlatform;

use EasyWeChat\OpenPlatform\Application as BaseApplication;

/**
 * @property-read \Cblink\Service\Wechat\OpenPlatform\Application $service
 * @property-read BaseClient $base
 */
class Application extends BaseApplication
{

    /**
     * 获取web端授权链接
     *
     * @param string $callbackUrl
     * @param array $optional
     * @return string
     */
    public function getPreAuthorizationUrl(string $callbackUrl, $optional = []): string
    {
        return $this->base->getAuthorizationUrl(array_merge($optional,[
            'type' => 'scan',
            'url' =>  $callbackUrl
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
        return $this->base->getAuthorizationUrl(array_merge($optional,[
            'type' => 'mobile',
            'url' =>  $callbackUrl
        ]));
    }

}
