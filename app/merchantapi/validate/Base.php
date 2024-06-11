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

namespace app\merchantapi\validate;

use taoser\Validate;

class Base extends Validate
{
    // 验证完数据 返回验证的数据
    public function data($scene = null, array $validateData = [])
    {
        $params = request()->post();
        $params = array_merge($params, $validateData);
        //场景
        if ($scene == null) {
            throw new \think\Exception('场景不能为空,防止数据混乱');
        } 
        $this->scene($scene)->failException(true)->check($params);
        return $params;
    }
}