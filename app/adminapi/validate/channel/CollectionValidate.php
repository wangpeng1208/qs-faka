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

namespace app\adminapi\validate\channel;

use taoser\Validate;

class CollectionValidate extends Validate
{

    protected $rule = [
        'title'          => 'require',
        'code'           => 'require',
        'show_name'      => 'require',
        'account_fields' => 'require',
    ];
    protected $message = [
        'title.require'          => '通道名称不能为空',
        'code.unique'            => '代码接口不能为空',
        'show_name.require'      => '显示名称不能为空',
        'account_fields.require' => '账号字段不能为空',
    ];
    public function sceneCollection()
    {
        return $this->only(['title', 'code', 'show_name', 'account_fields']);
    }

    public function sceneSettlement()
    {
        return $this->only(['title', 'code', 'account_fields']);
    }
}