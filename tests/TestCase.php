<?php
namespace Cblink\Service\Wechat\Tests;

use Cblink\Service\Wechat\Factory;
use PHPUnit\Framework\TestCase as BaseTestCase;

/**
 * Class TestCase
 * @package Cblink\Service\Wechat\Tests
 */
class TestCase extends BaseTestCase
{

    /**
     * @param $path
     * @return string
     */
    public function basePath($path = '')
    {
        return __DIR__ . '/../' . $path;
    }

    public function openPlatform()
    {
        $config = [
            // 配置信息
            'private' => true,
            'base_url' => 'http://127.0.0.1//',
            'app_id' => 1,
            'key' => 'test',
            'secret' => 'test',
            'open-platform' => [
                'app_id' => 'test',
                'secret' => 'test',
                'token' => 'test',
                'aes_key' => 'test'
            ]
        ];

        if (file_exists($fileName =__DIR__.'/../config/service-wechat.php')){
            $config = include $fileName;
        }

        return Factory::openPlatform($config);
    }
}
