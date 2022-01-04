<?php

namespace Cblink\Service\Wechat;

use Cblink\Service\Wechat\OpenWork\Rewrite\SuiteTicket;
use EasyWeChat\OpenWork\Application;
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
        // 优先使用企微开放平台uuid
        $config['uuid'] = $config['open_uuid'] ?? $config['uuid'];

        $client = new OpenPlatform\Application($config);

        $application = \EasyWeChat\Factory::openPlatform(self::getConfigure($client, $cache));

        $application->rebind('service', function () use ($client) {
            return $client;
        });

        // 绑定基础信息
        $application->rebind('base', function ($app) {
            return new OpenPlatform\Rewrite\BaseClient($app);
        });

        // 绑定ticket
        $application->rebind('verify_ticket', function ($app) {
            return new OpenPlatform\Rewrite\VerifyTicket($app);
        });

        // 绑定access_token
        $application->rebind('access_token', function ($app) {
            return new OpenPlatform\Rewrite\AccessToken($app);
        });

        return $application;
    }

    /**
     * 更换easywechat组件
     *
     * @param array $config
     * @param $cache
     * @return \EasyWeChat\OpenWork\Application
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public static function openWork(array $config = [], $cache = null)
    {
        // 优先使用企微开放平台uuid
        $config['uuid'] = $config['work_uuid'] ?? $config['uuid'];

        $client = new OpenWork\Application($config);

        $response = self::getConfigure($client, $cache);

        // 处理一下参数
        $data = Arr::only($response, ['corp_id', 'aes_key', 'token']);
        $data['secret'] = Arr::get($response, 'providerSecret');
        $data['suite_id'] = Arr::get($response, 'app_id');
        $data['suite_secret'] = Arr::get($response, 'secret');

        // 这里需要预先加入 token信息
        $application = new Application($data);

        $application->rebind('service', function () use ($client) {
            return $client;
        });

        $application->rebind('suite_ticket', function ($app) {
            return new SuiteTicket($app);
        });

        $application->rebind('corp', function($app){
            return new OpenWork\Rewrite\CorpClient($app);
        });

        return $application;
    }

    /**
     * @param OpenPlatform\Application|OpenWork\Application $client
     * @param Psr16Cache $cache
     * @return array|mixed
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    protected static function getConfigure($client, $cache = null)
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
