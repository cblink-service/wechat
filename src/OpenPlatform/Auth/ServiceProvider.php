<?php

namespace Cblink\Service\Wechat\OpenPlatform\Auth;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

/**
 * Class ServiceProvider
 * @package Cblink\Service\Wechat\Auth
 */
class ServiceProvider implements ServiceProviderInterface
{
    /**
     * @inheritDoc
     */
    public function register(Container $pimple)
    {
        $pimple['auth'] = function ($pimple) {
            return new Client($pimple);
        };
    }
}
