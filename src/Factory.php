<?php
namespace Cblink\Service\Wechat;

use Cblink\Service\Wechat\OpenPlatform\Application as OpenPlatformApp;

/**
 * Class Factory
 * @package Cblink\Service\Wechat
 */
class Factory extends \EasyWeChat\Factory
{
    /**
     * @param $config
     * @return OpenPlatform
     */
    public static function openPlatform(array $config)
    {
        $app = new OpenPlatformApp($config);

        return new OpenPlatform($app);
    }
}
