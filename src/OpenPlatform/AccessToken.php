<?php


namespace Cblink\Service\Wechat\OpenPlatform;

use EasyWeChat\Kernel\ServiceContainer;

/**
 * Class AccessToken
 * @package Cblink\Service\Wechat\OpenPlatform
 */
class AccessToken extends \EasyWeChat\OpenPlatform\Auth\AccessToken
{
    /**
     * @var \Cblink\Service\Wechat\OpenPlatform\Application
     */
    protected $openPlatformApp;

    public function __construct(ServiceContainer $app, $openPlatformApp = null)
    {
        parent::__construct($app);
        $this->openPlatformApp = $openPlatformApp;
    }

    /**
     * 获取token
     *
     * @param array $credentials
     * @param false $toArray
     * @return array|\EasyWeChat\Kernel\Support\Collection|\Illuminate\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     */
    public function requestToken(array $credentials, $toArray = false)
    {
        $response = $this->openPlatformApp->auth->getAccessToken();

        return [
            $this->tokenKey => $response->get('token'),
            'expires_in' => ((int) $response->get('created_time') + 7200 - time())
        ];
    }
}
