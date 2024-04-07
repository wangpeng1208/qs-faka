<?php

/**
 * 缩我短网址suo.im
 */

// +----------------------------------------------------------------------
// | 骑士发卡 [ 平顶山若拉网络科技有限公司，并保留所有权利 ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016~2020 https://www.qqss.net All rights reserved.
// +----------------------------------------------------------------------
// | Licensed 骑士软件 并不是自由软件，商业用途务必到官方购买正版授权, 以免引起不必要的法律纠纷.
// +----------------------------------------------------------------------
// | Author: QQSS <admin@qqss.net>
// +----------------------------------------------------------------------

namespace app\service\shortlink\src;

use app\service\http\HttpService;
use app\service\shortlink\interfaces\Link;

class Suo implements Link
{
    const API_URL = 'http://api.3wt.cn/api.htm';
    protected $key;

    public function __construct()
    {
        $this->key = conf('suo_app_key');
    }

    public function create($url)
    {
        $res = HttpService::get(self::API_URL, [
            'url'        => $url,
            'format'     => 'json',
            'key'        => $this->key,
            'expireDate' => date('Y-m-d', strtotime('+1 year')),
            'domain'     => '21',
        ]);
        if ($res === false) {
            return false;
        }
        $json = json_decode($res);
        if (!$json) {
            return false;
        }
        if ($json->err != '') {
            return false;
        }
        return $json->url;
    }
}
