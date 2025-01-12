<?php

/**
 * 缩我短网址suo.im
 */

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

class Suo implements Link
{
    const API_URL = 'http://api.3wt.cn/api.htm';

    public function create($url)
    {
        $key = conf('suo_app_key');
        if (empty($key)) {
            throw new \Exception('未配置缩我短网址配置');
        }
        $res = HttpService::get(self::API_URL, [
            'url'        => $url,
            'format'     => 'json',
            'key'        => $key,
            'expireDate' => date('Y-m-d', strtotime('+1 year')),
            'domain'     => '21',
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
