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

use think\Model;
use app\service\shortlink\ShortLinkService;

class User extends Model
{
    protected $type = [
        'freeze_money'  => 'float',
        'money'         => 'float',
        'fee_money'     => 'float',
    ];
    public function role()
    {
        return $this->hasOneThrough('UserRole', 'UserRoleRelation', 'user_id', 'id', 'id', 'role_id');
    }

    public function userMoneyLog()
    {
        return $this->hasMany('UserMoneyLog', 'user_id');
    }

    /**
     * 店铺资料
     * document 用于统计店铺审核状态、开店时间、等基础信息
     */
    public function shop()
    {
        return $this->hasOne('ShopList', 'user_id');
    }

    public function cards()
    {
        return $this->hasMany("GoodsCard", "user_id");
    }

    public function verify()
    {
        return $this->hasMany('ShopVerify', 'user_id');
    }

    public function collect()
    {
        return $this->hasOne('UserCollect', 'user_id');
    }

    public function goods()
    {
        return $this->hasMany('Goods', 'user_id');
    }

    public function goodsCoupon()
    {
        return $this->hasMany('GoodsCoupon', 'user_id');
    }

    public function categorys()
    {
        return $this->hasMany('GoodsCategory', 'user_id');
    }

    public function orders()
    {
        return $this->hasMany('Order', 'user_id');
    }

    public function messagesByFrom()
    {
        return $this->hasMany('MerchantMessage', 'from_id');
    }

    public function messagesByTo()
    {
        return $this->hasMany('MerchantMessage', 'to_id');
    }

    public function messages()
    {
        return $this->hasMany('MerchantMessage', 'user_id');
    }

    // 搜索器开始
    public function searchFieldAttr($query, $value, $data)
    {
        if (empty($data['keyword'])) {
            return;
        }
        if ($value == 'username') {
            $query->where('username', 'like', '%' . $data['keyword'] . '%');
        }

        if ($value == 'id') {
            $query->where('id', $data['keyword']);
        }
        if ($value == 'mobile') {
            $query->where('mobile', $data['keyword']);
        }

        if ($value == 'qq') {
            $query->where('qq', $data['keyword']);
        }
    }
    public function searchKeywordAttr($query, $value, $data)
    {
    }
    public function searchStatusAttr($query, $value, $data)
    {
        $query->where('status', $value);
    }
    public function searchIsFreezeAttr($query, $value, $data)
    {
        $query->where('is_freeze', $value);
    }
    public function searchDateRangeAttr($query, $value, $data)
    {
        if (empty($value) || empty($value[0]) || empty($value[1])) {
            return;
        }
        $query->whereBetweenTime('create_at', strtotime($value[0]), strtotime($value[1]));
    }
    // 搜索器结束

    // avatar
    public function getAvatarAttr($value, $data)
    {
        if(empty($value)){
            return conf('site_domain') . '/static/common/images/noavatar.svg';
        }
        return  $value;
    }

    public function rate()
    {
        return $this->hasMany('UserRate', 'user_id');
    }

    public function cashs()
    {
        return $this->hasMany('Cash', 'user_id');
    }

    public function complaints()
    {
        return $this->hasMany('OrderComplaint', 'user_id');
    }

    /**
     * 获取投诉次数
     */
    public function getComplaintCountAttr($value, $data)
    {
        return $this->complaints()->count();
    }

    public function loginLogs()
    {
        return $this->hasMany('UserLoginLog', 'user_id');
    }

    public function channelStatus()
    {
        return $this->hasMany('UserChannel', 'user_id');
    }

    /**
     * 链接
     */
    public function link()
    {
        return $this->morphMany('Link', 'relation', 'user')->order('id desc');
    }


    /**
     * 获取店铺链接
     */
    public function getLinksAttr($value, $data)
    {
        return conf("site_shop_domain") . "/links/" . $this->link()->value('token');
    }

    public function getShortLinkAttr($value, $data)
    {
        return (new ShortLinkService())->getShortLink($data["id"], $data["id"], "user");
    }

    /**
     * 重置短连接
     */
    public function getResetShortLinkAttr($value, $data)
    {
        return (new ShortLinkService())->resetShortLink($data["id"], $data["id"], "user");
    }

    /**
     * 获取链接状态
     */
    public function getLinkStatusAttr($value, $data)
    {
        return $this->link()->value('status');
    }

    // test 用户资金更新
    public static function onAfterUpdate($user)
    {
        record_file_log("user", "用户{$user->id} 资金更新：" . $user->money);
    }
}
