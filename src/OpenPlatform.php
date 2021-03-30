<?php
namespace Cblink\Service\Wechat;

use Cblink\Service\Wechat\OpenPlatform\AccessToken;
use Cblink\Service\Wechat\OpenPlatform\VerifyTicket;
use Illuminate\Support\Facades\Cache;
use InvalidArgumentException;
use EasyWeChat\OpenPlatform\Application;
use Cblink\Service\Wechat\OpenPlatform\Application as OpenPlatformApp;

/**
 * Class OpenPlatform
 * @mixin Application
 * @property-read AccessToken $access_token
 * @property-read VerifyTicket $verify_ticket
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
     * @var OpenPlatformApp
     */
    protected $openPlatformApp;

    public function __construct(OpenPlatformApp $openPlatformApp)
    {
        $this->openPlatformApp = $openPlatformApp;
        $this->app = $this->initApp();
    }

    /**
     * @return Application
     */
    protected function initApp(): Application
    {
        $app = new Application($this->getConfigure()->toArray());

        $app->rebind('verify_ticket', function($app){
            return new VerifyTicket($app, $this->openPlatformApp);
        });

        $app->rebind('access_token', function($app){
            return new AccessToken($app, $this->openPlatformApp);
        });

        return $app;
    }

    /**
     * @return mixed
     */
    protected function getConfigure()
    {
        $cacheKey = sprintf('open-platform-%s', $this->openPlatformApp->getUuid());

        return Cache::remember($cacheKey, 7200, function(){
            return $this->openPlatformApp->configure->show();
        });
    }

    /**
     * @return $this
     */
    public function clearConfigCache()
    {
        $cacheKey = sprintf('open-platform-%s', $this->openPlatformApp->getUuid());

        Cache::forget($cacheKey);

        return $this;
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
     * 绑定公众号/小程序到账户下
     *
     * @param string $appId
     * @return bool
     */
    public function bindAppId(string $appId)
    {
        $result = $this->openPlatformApp->auth->bindAppId($appId);

        return $result->success();
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
        $response = $this->openPlatformApp->auth->getAuthUrl($payload);

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
