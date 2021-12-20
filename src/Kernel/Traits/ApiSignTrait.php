<?php

namespace Cblink\Service\Wechat\Kernel\Traits;

use Cblink\Service\Foundation\Container;
use Hyperf\Utils\Arr;
use Ramsey\Uuid\Uuid;

/**
 * Trait BuildSignTrait
 * @property Container $app
 * @package Cblink\Service\Kennel\Traits
 */
trait ApiSignTrait
{
    /**
     * @param $uri
     * @param $method
     * @param array $options
     * @return array
     * @throws \Exception
     */
    protected function buildSign($uri, $method, array $options = [])
    {
        $params = $this->sortByArray($options['query'] ?? []);

        $buildUrl = '/' . (empty($params) ? $uri : $uri . '?' . urldecode(http_build_query($params)));

        $content = empty($options['json']) ? '' : base64_encode(md5(json_encode($options['json']), true));

        $signString = $method . "\n" . $content . "\nx-ca-proxy-signature-secret-key:" . $this->app->getKey() . "\n" . $buildUrl;

        $signature = base64_encode(hash_hmac('sha256', $signString, $this->app->getSecret(), true));

        $options['headers'] = array_merge(Arr::get($options, 'headers', []), [
            'X-App-Id' => $this->app->getAppId(),
            'X-App-Request-Id' => Uuid::uuid4()->toString(),
            'X-Ca-Proxy-Signature-headers' => 'x-ca-proxy-signature-secret-key',
            'X-Ca-Proxy-Signature-secret-key' => $this->app->getKey(),
            'X-Ca-Proxy-Signature' => $signature
        ]);

        return $options;
    }

    /**
     * @param array $array
     * @return array
     */
    protected function sortByArray(array $array = []): array
    {
        foreach ($array as $key => $val) {
            if (is_array($val)) {
                $array[$key] = $this->sortByArray($val);
            }
        }
        ksort($array);

        return $array;
    }
}
