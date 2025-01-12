<?php
// +----------------------------------------------------------------------
// | 骑士虚拟产品寄售商城系统开源版 
// +----------------------------------------------------------------------
// | Copyright (c) 2022-2025 https://www.qqss.net All rights reserved.
// +----------------------------------------------------------------------
// | Licensed MIT 本系统开源仅仅是为了新手学习开发商城为目的，使用时请遵循当地法律法规
// +----------------------------------------------------------------------
// | Author: QQSS <990504246@qq.com>
// +----------------------------------------------------------------------

namespace app\service\shortlink\src;

use app\service\common\HttpService;
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
