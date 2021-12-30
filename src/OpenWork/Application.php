<?php

namespace Cblink\Service\Wechat\OpenWork;

use Cblink\Service\Foundation\Container;

class Application extends Container
{

    protected array $providers = [
        Auth\ServiceProvider::class,
    ];

}
