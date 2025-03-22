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

namespace app\common\model;

class UserMoneyLog extends BaseModel
{
    protected $autoWriteTimestamp = true;
    protected $createTime = 'create_at';

    // 模型操作字典 资金操作类型
    public static $businessTypeDict = [
        'unfreeze'                => '解冻金额',
        'freeze'                  => '冻结金额',
        'cash_notpass'            => '提现未通过',
        'cash_success'            => '提现成功',
        'apply_cash'              => '申请提现',
        'admin_inc'               => '后台操作加钱',
        'admin_dec'               => '后台操作扣钱',
        'fee'                     => '手续费',
        'goods_sold'              => '卖出商品',
        'goods_refund'            => '商品退款',
        'sub_register'            => '推广注册奖励',
        'reward'                  => '奖励金',
        'admin_deposit_money_inc' => '管理员手动操作增加押金',
        'admin_deposit_money_dec' => '管理员手动操作扣除押金',
    ];
    
    public function user()
    {
        return $this->belongsTo('User', 'user_id');
    }

    public function searchUserIdAttr($query, $value, $data)
    {
        $query->where('user_id', $value);
    }

    public function searchUsernameAttr($query, $value, $data)
    {
        $query->hasWhere('user', function ($query) use ($value) {
            $query->where('username', 'like', '%' . $value . '%');
        });
    }

    public function searchBusinessTypeAttr($query, $value, $data)
    {
        $query->where('business_type', $value);
    }

    public function searchDateRangeAttr($query, $value, $data)
    {
        if (empty($value) || empty(trim($value[0])) || empty(trim($value[1]))) {
            return;
        } else {
            $query->whereBetweenTime('create_at', $value[0], $value[1]);
        }
    }
}
