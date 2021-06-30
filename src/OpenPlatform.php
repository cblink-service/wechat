<?php
namespace Cblink\Service\Wechat;

use Cblink\Service\Wechat\CustomOpenPlatform\Auth\AccessToken;
use Cblink\Service\Wechat\OpenPlatform\Application;
use Cblink\Service\Wechat\CustomOpenPlatform\Auth\VerifyTicket;
use Illuminate\Support\Facades\Cache;
use InvalidArgumentException;
use EasyWeChat\OpenPlatform\Application as EasyWechatOpenPlatformApplication;

/**
 * Class OpenPlatform
 * @mixin EasyWechatOpenPlatformApplication
 * @property-read AccessToken $access_token
 * @property-read VerifyTicket $verify_ticket
 */
class OpenPlatform extends EasyWechatOpenPlatformApplication
{
    /**
     * @var \Cblink\Service\Wechat\CustomOpenPlatform\Application
     */
    protected $service;

    /**
     * @var array
     */
    protected $providers = [
        \EasyWeChat\OpenPlatform\Base\ServiceProvider::class,
        CustomOpenPlatform\Auth\ServiceProvider::class,
        \EasyWeChat\OpenPlatform\Server\ServiceProvider::class,
        \EasyWeChat\OpenPlatform\CodeTemplate\ServiceProvider::class,
        \EasyWeChat\OpenPlatform\Component\ServiceProvider::class,
    ];

    public function __construct($config)
    {
        // service config
        $this->service = new Application($config);
        // init
        parent::__construct($this->getConfigure()->toArray());
    }

    /**
     * 获取web端授权链接
     *
     * @param string $callbackUrl
     * @param array $optional
     * @return string
     */
    public function getPreAuthorizationUrl(string $callbackUrl, $optional = []): string
    {
        return $this->getAuthorizationUrl(array_merge($optional,[
            'type' => 'scan',
            'url' =>  $callbackUrl
        ]));
    }

    /**
     * 获取移动端授权链接
     * @param string $callbackUrl
     * @param array $optional
     * @return string
     */
    public function getMobilePreAuthorizationUrl(string $callbackUrl, $optional = []): string
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
        $response = $this->getService()->auth->getAuthUrl($payload);

        if (!$response->success()){
            throw new InvalidArgumentException('Get Url Fail: '. $response->errMsg());
        }

        return $response->get('url');
    }

    /**
     * @return $this
     */
    public function clearConfigCache()
    {
        $cacheKey = sprintf('open-platform-%s', $this->getService()->getUuid());

        Cache::forget($cacheKey);

        return $this;
    }

    /**
     * 绑定公众号/小程序到账户下
     *
     * @param string $appId
     * @return bool
     */
    public function bindAppId(string $appId)
    {
        $result = $this->getService()->auth->bindAppId($appId);

        return $result->success();
    }

    /**
     * @return mixed
     */
    protected function getConfigure()
    {
        $cacheKey = sprintf('open-platform-%s', $this->getService()->getUuid());

        return Cache::remember($cacheKey, 7200, function(){
            return $this->getService()->configure->show();
        });
    }

    /**
     * @return Application
     */
    public function getService()
    {
        return $this->service;
    }
}
