<?php

namespace Cblink\Service\Wechat;

use Cblink\Service\Wechat\OpenPlatform\Rewrite\AccessToken;
use Cblink\Service\Wechat\OpenPlatform\Rewrite\BaseClient;
use Cblink\Service\Wechat\OpenPlatform\Rewrite\VerifyTicket;
use Hyperf\Utils\Arr;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\Cache\Psr16Cache;

class Factory
{
    /**
     * 更换easywechat组件
     *
     * @param array $config
     * @param null $cache
     * @return \EasyWeChat\OpenPlatform\Application
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public static function openPlatform(array $config = [], $cache = null)
    {
        $client = new OpenPlatform\Application($config);

        $application = \EasyWeChat\Factory::openPlatform(self::getConfigure($client, $cache));

        $application->rebind('service', function () use ($client) {
            return $client;
        });

        // 绑定基础信息
        $application->rebind('base', function ($app) {
            return new BaseClient($app);
        });

        // 绑定ticket
        $application->rebind('verify_ticket', function ($app) {
            return new VerifyTicket($app);
        });

        // 绑定access_token
        $application->rebind('access_token', function ($app) {
            return new AccessToken($app);
        });

        return $application;
    }

    /**
     * @param OpenPlatform\Application $client
     * @param Psr16Cache $cache
     * @return array|mixed
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    protected static function getConfigure(\Cblink\Service\Wechat\OpenPlatform\Application $client, $cache = null)
    {
        $cacheKey = sprintf('open-platform-%s', $client->getUuid());

        if (!$cache) {
            $cache = new Psr16Cache(new FilesystemAdapter('cb-wechat', 1500));
        }

        if ($cache->has($cacheKey)) {
            return unserialize($cache->get($cacheKey));
        }

        $response = Arr::get($client->configure->show(), 'data', []);

        $cache->set($cacheKey, serialize($response));

        return $response;
    }
}
