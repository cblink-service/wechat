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
    protected $cblinkApp;

    public function __construct(ServiceContainer $app, $cblinkApp = null)
    {
        parent::__construct($app);
        $this->cblinkApp = $cblinkApp;
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
        $response = $this->cblinkApp->auth->getAccessToken();

        return [
            $this->tokenKey => $response->get('token'),
            'expires_in' => ((int) $response->get('created_time') + 7200 - time())
        ];
    }
}
