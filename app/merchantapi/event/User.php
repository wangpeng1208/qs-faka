<?php

declare(strict_types=1);

// +----------------------------------------------------------------------
// | 骑士虚拟产品寄售商城系统开源版 
// +----------------------------------------------------------------------
// | Copyright (c) 2023-2025 https://www.qqss.net All rights reserved.
// +----------------------------------------------------------------------
// | Licensed MIT 本系统开源仅仅是为了新手学习开发商城为目的，使用时请遵循当地法律法规
// +----------------------------------------------------------------------
// | Author: QQSS <990504246@qq.com>
// +----------------------------------------------------------------------

namespace app\merchantapi\event;

use app\common\model\UserRoleRelation;

class User
{
    /**
     * 注册推广
     *
     * @param [type] $userInfo
     * @return void
     */
    function addAfter($userInfo)
    {
        // 用户组权限
        $this->userRole($userInfo["user_id"]);
        // 创建默认店铺
        $this->createShop($userInfo["user_id"]);
    }

    private function userRole($user_id)
    {
        // 商户默认权限分组
        if (!UserRoleRelation::where(["user_id" => $user_id])->count()) {
            UserRoleRelation::create(["role_id" => 1, "user_id" => $user_id]);
        }
    }

    // 创建默认店铺
    function createShop($user_id)
    {
        $merchant_end_day = conf('merchant_end_time') ?? 365 * 10;
        // 创建默认店铺
        $shop = [
            'user_id'           => $user_id,
            'shop_verify'       => 1,
            'shop_status'       => 1,
            'create_at'         => time(),
            'merchant_time'     => time(),
            'merchant_end_time' => time() + 86400 * $merchant_end_day,
        ];
        $shop = \app\common\model\ShopList::create($shop);

    }

}
