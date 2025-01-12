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