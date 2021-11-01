<?php

namespace Cblink\Service\Wechat;

use Cblink\Service\Wechat\CustomOpenPlatform\AccessToken;
use Cblink\Service\Wechat\CustomOpenPlatform\BaseClient;
use Cblink\Service\Wechat\CustomOpenPlatform\VerifyTicket;
use Illuminate\Support\Facades\Cache;

class Factory
{
    /**
     * 更换easywechat组件
     *
     * @param array $config
     * @return \EasyWeChat\OpenPlatform\Application
     */
    public static function openPlatform(array $config = [])
    {
        $client = new \Cblink\Service\Wechat\OpenPlatform\Application($config);

        $application = \EasyWeChat\Factory::openPlatform(self::getConfigure($client));

        $application->rebind('service', function() use ($client){
            return $client;
        });

        // 绑定基础信息
        $application->rebind('base', function($app){
            return new BaseClient($app);
        });

        // 绑定ticket
        $application->rebind('verify_ticket', function($app){
            return new VerifyTicket($app);
        });

        // 绑定access_token
        $application->rebind('access_token', function($app){
            return new AccessToken($app);
        });

        return $application;
    }


    /**
     * @return mixed
     */
    protected static function getConfigure(\Cblink\Service\Wechat\OpenPlatform\Application $client)
    {
        $cacheKey = sprintf('open-platform-%s', $client->getUuid());

        return Cache::remember($cacheKey, 7200, function() use($client){
            return $client->configure->show()->toArray();
        });
    }
}
