<?php

namespace Cblink\Service\Wechat\OpenWork;

use Cblink\Service\Foundation\Container;

class Application extends Container
{

    protected array $providers = [
        Auth\ServiceProvider::class,
    ];

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
