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

namespace app\home\validate;

use taoser\Validate;
use app\common\model\Order as OrderModel;
use app\common\model\OrderComplaint as ComplaintModel;

class ComplaintValidate extends Validate
{
    protected $order;
    protected $rule = [
        'qq'       => 'require|qqreg',
        'mobile'   => 'require|mobile',
        'desc'     => 'require',
        'trade_no' => 'require|checkOrderExists|checkOrderStatus|checkComplaintExists|checkOrderToday',
    ];

    protected $message = [
        'qq.require'                    => 'qq未填写',
        'qq.qqreg'                      => 'qq格式不正确',
        'mobile.require'                => '手机号未填写',
        'mobile.mobile'                 => '这不是一个有效的手机号格式 !',
        'desc'                          => '请输入投诉说明！',
        'trade_no.require'              => '订单号未填写！',
        'trade_no.checkOrderExists'     => '订单号不存在！',
        'trade_no.checkOrderStatus'     => '该订单未完成，暂不能受理投诉！',
        'trade_no.checkComplaintExists' => '您已投诉过该订单！',
        'trade_no.checkOrderToday'      => '该订单已经超过投诉时间，请在当天投诉！',
    ];

    protected function qqreg($value, $rule, $data = [])
    {
        return preg_match('/^[1-9][0-9]{4,}$/', $value) ? true : false;
    }

    protected function getOrder($value)
    {
        if ($this->order === null) {
            $this->order = OrderModel::where(["trade_no" => $value])->find();
        }
        return $this->order;
    }

    // 定义验证方法
    protected function checkOrderExists($value, $rule, $data = [])
    {
        return $this->getOrder($value) ? true : false;
    }

    protected function checkOrderStatus($value, $rule, $data = [])
    {
        $order = $this->getOrder($value);
        return $order && $order->status !== 0;
    }

    protected function checkComplaintExists($value, $rule, $data = [])
    {
        $complaint = ComplaintModel::where(["trade_no" => $value])->count();
        return $complaint ? false : true;
    }
    // 检测订单是否是今天的订单 create_at时间戳在今日0到24点之间
    protected function checkOrderToday($value, $rule, $data = [])
    {
        $count = OrderModel::where(["trade_no" => $value])->whereTime('create_at', 'today')->count();
        return empty($count) ? false : true;

    }
}
