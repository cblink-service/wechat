<?php

namespace Cblink\Service\Wechat\Kernel;

use Cblink\Service\Wechat\Kernel\Traits\ApiSignTrait;

class BaseApi extends \Cblink\Service\Foundation\BaseApi
{
    use ApiSignTrait;

    /**
     * 重写requesst
     *
     * @param string $method
     * @param string $url
     * @param array $options
     * @param $returnRaw
     * @return array|\Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function request(string $method = 'POST', string $url = '', array $options = [], $returnRaw = false)
    {
        return parent::request($method, $url,  $this->buildSign($url, $method, $options), $returnRaw);
    }
}
