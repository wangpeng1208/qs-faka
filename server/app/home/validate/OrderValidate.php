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

use app\common\model\Channel;
use taoser\Validate;
use app\common\model\Goods;
use app\common\model\GoodsCoupon;

class OrderValidate extends Validate
{
    protected $goods = null;

    protected $rule = [
        'goods_id' => 'require|checkGoodsExists|checkGoodsStatus|checkGoodsUser|checkMore',
        'contact'  => 'require|checkContact|checkBlacklist|checkContactType',
        'quantity' => 'require|checkStock|checkMinQuantity|checkMaxQuantity',
        'pid'      => 'require|checkPid',
    ];

    protected $message = [
        'goods_id.require'          => '商品选择错误！',
        'goods_id.checkGoodsExists' => '商品不存在！',
        'goods_id.checkGoodsStatus' => '该商品已下架！',
        'goods_id.checkGoodsUser'   => '该商品所在的用户不存在！',
        'contact.require'           => '请填写联系方式！',
        'contact.checkBlacklist'    => '联系方式不能太简单！',
        'contact.checkContactType'  => '请填写正确的联系方式！',
        'quantity.require'          => '请填写购买数量！',
        'quantity.checkStock'       => '库存不足！',
        'quantity.checkMinQuantity' => '起购数量不能少于 :limit 张！',
        'quantity.checkMaxQuantity' => '购买数量不能大于 :limit 张！',
        'pid.require'               => '请选择付款方式！',
        'pid.checkPid'              => '付款方式选择错误！',
    ];

    // 定义验证方法
    protected function checkGoodsExists($value, $rule, $data = [])
    {
        $this->goods = Goods::where(["id" => $value])->find();
        return $this->goods ? true : false;
    }


    protected function checkGoodsStatus($value, $rule, $data = [])
    {
        $goods = Goods::where(["id" => $value])->find();
        return $goods->status === 1 ? true : false;
    }

    // 商品所在的用户和店铺
    protected function checkGoodsUser($value, $rule, $data = [])
    {
        $goods = Goods::where(["id" => $value])->find();
        $user  = $goods->user;
        if (empty($user)) {
            return '该商品所在的用户不存在！';
        }
        if ($user->status != 1) {
            return '商家未通过审核！';
        }
        if ($user->is_freeze) {
            return '商家已被冻结！';
        }
        $shop = $user->shop;
        if (empty($shop)) {
            return '商家店铺不存在！';
        }
        if (empty($shop->shop_status)) {
            return '商家店铺未通过审核！';
        }
        if ($shop->is_freeze) {
            return '商家店铺已被冻结！';
        }
        if ($shop->shop_close) {
            return '商家已经主动歇业！';
        }
        return true;
    }


    protected function checkContact($value, $rule, $data = [])
    {
        return $value !== '' ? true : false;
    }

    protected function checkBlacklist($value, $rule, $data = [])
    {
        $blacklist = explode('|', trim(conf('order_query_blackcontact'), '|'));
        foreach ($blacklist as $item) {
            if ($value == $item) {
                return '联系方式太简单：' . $item . '，请重新输入！';
            }
        }
        return true;
    }

    protected function checkContactType($value, $rule, $data = [])
    {
        switch ($this->goods->contact_limit) {
            case 'qq':
                return preg_match('/^[1-9][0-9]{4,}$/', $value) ? true : '请填写正确的QQ号码！';
            case 'email':
                return preg_match('/^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/', $value) ? true : '请填写正确的邮箱地址！';
            case 'mobile':
                return preg_match('/^1[3456789]\d{9}$/', $value) ? true : '请填写正确的手机号码！';
            default:
                return true;
        }
    }

    protected function checkStock($value, $rule, $data = [])
    {

        return $value <= $this->goods->cards_stock_count ? true : false;
    }

    protected function checkMinQuantity($value, $rule, $data = [])
    {
        if ($value < $this->goods->limit_quantity) {
            return '起购数量不能少于 ' . $this->goods->limit_quantity . ' 张！';
        }
        return true;
    }

    protected function checkMaxQuantity($value, $rule, $data = [])
    {
        if ($this->goods->limit_quantity_max != 0 && $value > $this->goods->limit_quantity_max) {
            return '购买数量不能大于 ' . $this->goods->limit_quantity_max . ' 张！';
        }
        return true;
    }

    // 非require的自定义验证器未能正确识别，故附加验证统一放到checkMore方法中
    protected function checkMore($value, $rule, $data = [])
    {
        if (isset($data['is_coupon']) && $data['is_coupon'] && $this->goods->coupon_type) {
            if ($data['coupon_code']) {
                $coupon = GoodsCoupon::where('code', $data['coupon_code'])->find();
                if (empty($coupon))
                    return '优惠券不存在！';
                if ($coupon->user_id != $this->goods->user_id)
                    return '优惠券不能在当前店铺使用！';
                if ($coupon->status == 0)
                    return '优惠券已被其他订单占用！';
                if ($coupon->status == 2)
                    return '优惠券已被使用！';
                if ($coupon->expire_at < time())
                    return '优惠券已过期！';
                if ($coupon->min_banlance > $data["goods_price"] * $data["quantity"])
                    return '优惠券最低消费金额不足，总价满' . $coupon->min_banlance . '元，方可使用！';
            }
        }
        if ($this->goods->take_card_type == 2 && $data['card_password'] == '') {
            return '请输入取卡密码！';
        }
        return true;
    }


    // 支付方式检测
    protected function checkPid($value, $rule, $data = [])
    {
        $channel = Channel::where(["id" => $value])->find();
        if (empty($channel)) {
            return '支付方式不存在';
        }
        if ($channel->status != 1) {
            return '支付方式已关闭【系统关闭】，请切换其他支付方式';
        }
        return true;
    }


    // 创建订单时的 验证场景
    public function sceneCreate()
    {
        $create = ['goods_id', 'contact', 'quantity', 'pid'];
        return $this->only($create);
    }
}