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

namespace app\adminapi\validate;

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
            throw new \think\Exception('场景不能为空');
        } 
        $this->scene($scene)->failException(true)->check($params);
        return $params;
    }
}