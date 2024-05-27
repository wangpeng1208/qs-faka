<?php
// +----------------------------------------------------------------------
// | 骑士发卡 [ 平顶山若拉网络科技有限公司，并保留所有权利 ]
// +----------------------------------------------------------------------
// | Copyright (c) 2022-2025 https://www.qqss.net All rights reserved.
// +----------------------------------------------------------------------
// | Licensed 骑士软件 并不是自由软件，商业用途务必到官方购买正版授权, 以免引起不必要的法律纠纷.
// +----------------------------------------------------------------------
// | Author: QQSS <admin@qqss.net>
// +----------------------------------------------------------------------

namespace app\service\shortlink\src;

use app\service\http\HttpService;
use app\service\shortlink\interfaces\Link;

class Suolink implements Link
{
    const API_URL = 'http://api.suolink.cn/api.htm';

    public function create($url)
    {
        $key    = conf('suolink_app_key');
        $domain = conf('suolink_app_domain');
        if (empty($key)) {
            throw new \Exception('未配置缩链短网址配置Key');
        }
        if (empty($domain)) {
            throw new \Exception('未配置缩链短网址的独立域名!');
        }
        $res = HttpService::get(self::API_URL, [
            'url'        => urlencode($url),
            'format'     => 'json',
            'key'        => $key,
            'expireDate' => date('Y-m-d', strtotime('+10 year')),
            'domain'     => $domain,
        ]);
        if ($res === false) {
            throw new \Exception('请求失败，请检测缩我客短网址配置（KEY）');
        }
        $json = json_decode($res);
        if (!$json) {
            throw new \Exception($res);
        }
        if ($json->err != '') {
            throw new \Exception($json->err);
        }
        return $json->url;
    }
}
