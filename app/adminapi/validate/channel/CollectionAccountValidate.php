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

class CollectionAccountValidate extends Validate
{
    protected $rule = [
        'name'  => 'require',
        'params' => 'require',
    ];
    protected $message = [
        'title.require' => '接口名称不能为空',
        'params.unique' => '账号资料不能为空',

    ];
}