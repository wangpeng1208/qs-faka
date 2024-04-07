<?php

/**
 * 自写短网址平台
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
use app\common\model\LinkShort;
use think\facade\Cache;
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
