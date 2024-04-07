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

use app\common\model\GoodsCategory;
use app\merchantapi\validate\Base;

class CouponValidate extends Base
{
    protected $rule = [
        'cate_id'   => 'checkCategory',
        'type'      => 'require',
        'amount'    => 'require|checkAmount',
        'quantity'  => 'require|integer|checkQuantity',
        'expire_at' => 'require',
    ];

    protected $message = [
        'cate_id.checkCategory'  => '分类不存在',
        'type.require'           => '请选择类型',
        'amount.require'         => '请输入折扣',
        'amount.checkAmount'     => '折扣不能小于0',
        'quantity.require'       => '请输入发放数量',
        'quantity.integer'       => '发放数量必须是整数',
        'quantity.checkQuantity' => '发放数量不能小于0',
        'expire_at.require'      => '请选择过期时间',
    ];

    protected function checkCategory($value, $rule, $data)
    {
        $category = GoodsCategory::where([
            'user_id' => $data['user_id'],
            'id'      => $value,
        ])->find();
        return $category ? true : false;
    }

    protected function checkAmount($value, $rule, $data)
    {
        if ($value <= 0) {
            return '折扣不能小于0！';
        }
        if ($data['type'] == 100) {
            if ($value >= 100) {
                return '折扣不能大于等于100%！';
            }
        }

        return true;
    }

    protected function checkQuantity($value, $rule, $data)
    {
        if ($value <= 0) {
            return '发放数量不能小于0！';
        }
        if ($value > 1000) {
            return '发放数量不能大于1000！';
        }

        return true;
    }

    public function sceneAdd()
    {
        return $this->only(['cate_id', 'type', 'amount', 'quantity', 'expire_at']);
    }

}