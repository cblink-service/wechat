<?php

namespace Cblink\Service\Wechat\OpenPlatform\Configure;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

/**
 * Class ServiceProvider
 * @package Cblink\Service\Wechat\Config
 */
class ServiceProvider implements ServiceProviderInterface
{

    /**
     * @inheritDoc
     */
    public function register(Container $pimple)
    {
        $pimple['configure'] = function ($pimple) {
            return new Client($pimple);
        };
    }
}
