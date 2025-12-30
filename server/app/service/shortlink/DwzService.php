<?php

// +----------------------------------------------------------------------
// | 骑士虚拟产品寄售商城系统开源版 
// +----------------------------------------------------------------------
// | Copyright (c) 2023-2025 https://www.qqss.net All rights reserved.
// +----------------------------------------------------------------------
// | Licensed MIT 本系统开源仅仅是为了新手学习开发商城为目的，使用时请遵循当地法律法规
// +----------------------------------------------------------------------
// | Author: QQSS <990504246@qq.com>
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
    public function create($url)
    {
        // $type = conf('site_domain_short');
        $type = "Other";
        $dwz  = $this->invoke($type);
        return $dwz->create($url) ?? '';
    }
}
