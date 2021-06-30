<?php

namespace Cblink\Service\Wechat\CustomOpenPlatform\Auth;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

/**
 * Class ServiceProvider
 * @package Cblink\Service\Wechat\OpenPlatform\Auth
 */
class ServiceProvider implements ServiceProviderInterface
{
    /**
     * {@inheritdoc}.
     */
    public function register(Container $app)
    {
        $app['verify_ticket'] = function ($app) {
            return new VerifyTicket($app);
        };

        $app['access_token'] = function ($app) {
            return new AccessToken($app);
        };
    }
}
