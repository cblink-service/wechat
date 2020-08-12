<?php
namespace Cblink\Service\Wechat;

/**
 * Class Factory
 * @package Cblink\Service\Wechat
 */
class Factory
{
    /**
     * @param $config
     * @return OpenPlatform
     */
    public static function openPlatform($config)
    {
        return new OpenPlatform($config);
    }

    public static function officialAccount($config)
    {
        return new OfficialAccount($config);
    }
}
