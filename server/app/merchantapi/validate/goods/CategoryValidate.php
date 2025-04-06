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

namespace app\merchantapi\validate\goods;

use app\merchantapi\validate\Base;

class CategoryValidate extends Base
{
    protected $rule = [
        'id'   => 'require',
        'name' => 'require|checkWordfilter',
        'sort' => 'number',
        'is_show' => 'require|number',
        'status' => 'require|number',
        'create_at' => 'require|number',
    ];

    protected $message = [
        'id.require'   => 'id不能为空',
        'name.require' => '分类名不能为空',
        'sort.number' => '排序必须为数字',
        'is_show.require' => '是否显示不能为空',
        'is_show.number' => '是否显示必须为数字',
        'status.require' => '状态不能为空',
        'status.number' => '状态必须为数字',
        'create_at.require' => '创建时间不能为空',
        'create_at.number' => '创建时间必须为数字',
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

    public function sceneEdit()
    {
        return $this->only(['id', 'name', 'sort', 'is_show', 'status', 'create_at']);
    }

    public function sceneAdd()
    {
        return $this->only(['name', 'sort', 'is_show', 'status', 'create_at']);
    }

    public function sceneStatus()
    {
        return $this->only(['id', 'status', 'is_show']);
    }

}