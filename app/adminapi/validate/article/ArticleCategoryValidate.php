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

namespace app\adminapi\validate\article;

use taoser\Validate;

class ArticleCategoryValidate extends Validate
{
    protected $rule = [
        'id'    => 'require',
        'name'  => 'require',
        'alias' => 'require|unique:article_category',
    ];

    protected $message = [
        'id.require'    => 'ID不能为空',
        'name.require'  => '分类名不能为空',
        'alias.require' => '别名不能为空',
        'alias.unique'  => '别名已存在'
    ];

    public function sceneAdd()
    {
        return $this->only(['name', 'alias']);
    }

    public function sceneEdit()
    {
        return $this->only(['id', 'name', 'alias']);
    }
}