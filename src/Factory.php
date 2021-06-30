<?php
namespace Cblink\Service\Wechat;

/**
 * Class Factory
 * @package Cblink\Service\Wechat
 */
class Factory extends \EasyWeChat\Factory
{
    /**
     * @param array $config
     * @return OpenPlatform
     */
    public static function openPlatform(array $config)
    {
        return new OpenPlatform($config);
    }
}
