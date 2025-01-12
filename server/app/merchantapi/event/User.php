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
     * 注册后置操作
     *
     * @param int $user_id 商户ID
     */
    function addAfter($user_id)
    {
        // 用户组权限
        $this->userRole($user_id);
        // 创建默认店铺
        $this->createShop($user_id);
    }

    /**
     * 用户组权限
     *
     * @param int $user_id
     * @return void
     */
    private function userRole($user_id)
    {
        if (!UserRoleRelation::where(["user_id" => $user_id])->count()) {
            UserRoleRelation::create(["role_id" => 1, "user_id" => $user_id]);
        }
    }

    /**
     * 创建默认店铺
     *
     * @param int $user_id
     * @return void
     */
    private function createShop($user_id)
    {
        $merchant_end_day = 365 * 10;
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
