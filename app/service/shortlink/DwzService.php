<?php

// +----------------------------------------------------------------------
// | 骑士发卡 [ 平顶山若拉网络科技有限公司，并保留所有权利 ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016~2020 https://www.qqss.net All rights reserved.
// +----------------------------------------------------------------------
// | Licensed 骑士软件 并不是自由软件，商业用途务必到官方购买正版授权, 以免引起不必要的法律纠纷.
// +----------------------------------------------------------------------
// | Author: QQSS <admin@qqss.net>
// +----------------------------------------------------------------------

namespace app\service\shortlink;


use support\Container;

class DwzService
{
    public function invoke($type)
    {
        $class = '\\app\\service\\shortlink\\src\\' . $type;
        return Container::get($class);
    }

    /**
     * 创建短链接
     */
    public function create($url, $type = '')
    {
        $type = conf('site_domain_short');
        $dwz = $this->invoke($type);
        return $dwz->create($url) ?? '';
    }
}
