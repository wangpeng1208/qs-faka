<?php

/**
 * 自写短网址平台
 */

// +----------------------------------------------------------------------
// | 骑士虚拟产品寄售商城系统开源版 
// +----------------------------------------------------------------------
// | Copyright (c) 2023-2025 https://www.qqss.net All rights reserved.
// +----------------------------------------------------------------------
// | Licensed MIT 本系统开源仅仅是为了新手学习开发商城为目的，使用时请遵循当地法律法规
// +----------------------------------------------------------------------
// | Author: QQSS <990504246@qq.com>
// +----------------------------------------------------------------------

namespace app\service\shortlink\src;
use app\common\model\LinkShort;
use support\Cache;
use app\service\shortlink\interfaces\Link;

class Mysite implements Link
{
  public function create($url)
  {
    $val = get_random_string(6);
    $short_url = conf('site_shortlink_domain') . '/' . $val;
    // url地址与 short_url地址绑定
    $data = [
      'url' => $url,
      'short_url' => $short_url,
      'create_at' => time(),
      'expire_at' => time() + 365 * 24 * 3600,
    ];
    $res = LinkShort::create($data);
    // 写入缓存
    if ($res) {
      Cache::set($short_url, $url, 365 * 24 * 3600);
    }
    return $url;
  }

}
