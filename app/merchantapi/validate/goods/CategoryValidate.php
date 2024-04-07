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

namespace app\merchantapi\validate\goods;

use taoser\Validate;

class CategoryValidate extends Validate
{
    protected $rule = [
        'id'   => 'require',
        'name' => 'require|checkWordfilter',
    ];

    protected $message = [
        'id.require'   => 'id不能为空',
        'name.require' => '分类名不能为空',
    ];

    protected function checkWordfilter($value, $rule, $data)
    {

        $check_name = check_wordfilter($value);
        if ($check_name) {
            return '包含违禁词' . $check_name;
        } else {
            return true;
        }
    }

    // edit
    public function sceneEdit()
    {
        return $this->only(['id', 'name']);
    }
    // add
    public function sceneAdd()
    {
        return $this->only(['name']);
    }

}