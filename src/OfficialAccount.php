<?php

namespace Cblink\Service\Wechat;

use EasyWeChat\OfficialAccount\Application;

class OfficialAccount
{
    /**
     * @var array
     */
    protected $config = [];

    /**
     * @var Application
     */
    protected $app;

    public function __construct(array $config = [])
    {
        $this->config = $config;
        $this->app = $this->initApp($config['official-account']);
    }

    protected function initApp($config)
    {
        $app = new Application($config);

        return $app;
    }

    /**
     * @param $name
     * @param $arguments
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        return call_user_func_array([$this->app, $name], $arguments);
    }

    /**
     * @param $name
     * @return mixed
     */
    public function __get($name)
    {
        return $this->app->{$name};
    }
}