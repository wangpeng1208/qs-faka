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

namespace app\merchantapi\validate\order;

use app\merchantapi\validate\Base;

class ComplaintValidate extends Base
{
    protected $rule = [
        'id' => 'require',
    ];

    protected $message = [
        'id.require' => 'id不能为空',
    ];


    protected function checkComplaintId($value)
    {
        $complaint = request()->user->complaints()->findOrEmpty($value);
        if ($complaint->isEmpty()) {
            return '投诉不存在';
        }
        return true;
    }

    // edit
    public function sceneDdetail()
    {
        return $this->only(['id'])
            ->append('id', 'checkComplaintId')
        ;
    }
    // add
    public function sceneAdd()
    {
        return $this->only(['name']);
    }

}