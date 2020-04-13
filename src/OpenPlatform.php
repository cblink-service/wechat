<?php
namespace Cblink\Service\Wechat;

use InvalidArgumentException;
use EasyWeChat\OpenPlatform\Application;
use Cblink\Service\Wechat\OpenPlatform\Application as ClinkApplication;

/**
 * Class OpenPlatform
 * @mixin Application
 */
class OpenPlatform
{
    /**
     * @var array
     */
    protected $config = [];

    /**
     * @var Application
     */
    protected $app;

    /**
     * @var ClinkApplication
     */
    protected $cblinkApp;

    public function __construct(array $config = [], ClinkApplication $cblinkApp = null)
    {
        $this->config = $config;
        $this->app = new Application($config['wechat']);
        $this->cblinkApp = $cblinkApp ?? new ClinkApplication($config);
    }

    /**
     * 获取web端授权链接
     *
     * @param string $callbackUrl
     * @param array $optional
     * @return string
     */
    public function getPreAuthorizationUrl(string $callbackUrl, $optional = [])
    {
        return $this->getAuthorizationUrl(array_merge($optional,[
            'type' => 'scan',
            'url' =>  $callbackUrl
        ]));
    }

    /**
     * 获取移动端授权链接
     *
     * @param string $callbackUrl
     * @param array $optional
     * @return string
     */
    public function getMobilePreAuthorizationUrl(string $callbackUrl, $optional = [])
    {
        return $this->getAuthorizationUrl(array_merge($optional,[
            'type' => 'mobile',
            'url' =>  $callbackUrl
        ]));
    }

    /**
     * @param array $payload
     * @return string
     * @throws InvalidArgumentException
     */
    protected function getAuthorizationUrl(array $payload = [])
    {
        $response = $this->cblinkApp->auth->getAuthUrl($payload);

        if (!$response->success()){
            throw new InvalidArgumentException('Get Url Fail: '. $response->errMsg());
        }

        return $response->get('url');
    }

    /**
     * @param $name
     * @param $arguments
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        return call_user_func_array([$this->app, 'name'], $arguments);
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
