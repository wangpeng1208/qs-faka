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