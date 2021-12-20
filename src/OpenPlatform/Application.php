<?php

namespace Cblink\Service\Wechat\OpenPlatform;

use Cblink\Service\Foundation\Container;

/**
 * Class Application
 * @property Auth\Client $auth
 * @property Configure\Client $configure
 * @package Cblink\Service\Wechat
 */
class Application extends Container
{
    /**
     * @inheritDoc
     */
    protected function getCustomProviders(): array
    {
        return [
            Auth\ServiceProvider::class,
            Configure\ServiceProvider::class,
        ];
    }

    /**
     * @return mixed
     */
    public function getUuid(): string
    {
        return $this['config']->get('uuid');
    }

    /**
     * @return mixed
     */
    public function getAppid(): string
    {
        return $this['config']->get('app_id');
    }

    /**
     * @return mixed
     */
    public function getKey(): string
    {
        return $this['config']->get('key');
    }

    /**
     * @return mixed
     */
    public function getSecret(): string
    {
        return $this['config']->get('secret');
    }
}
