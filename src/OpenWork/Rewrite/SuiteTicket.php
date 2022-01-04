<?php

namespace Cblink\Service\Wechat\OpenWork\Rewrite;

use EasyWeChat\Kernel\Exceptions\RuntimeException;
use Hyperf\Utils\Arr;

class SuiteTicket extends \EasyWeChat\OpenWork\SuiteAuth\SuiteTicket
{

    public function getTicket(): string
    {
        if ($cached = $this->getCache()->get($this->getCacheKey())) {
            return $cached;
        }

        $ticket = $this->app->service->auth->getTicket();

        if (Arr::get($ticket, 'err_code') == 0){
            return Arr::get($ticket, 'data.ticket');
        }

        throw new RuntimeException('Credential "suite_ticket" does not exist in cache.');
    }

}
