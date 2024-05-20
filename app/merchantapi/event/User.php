<?php

declare(strict_types=1);

// +----------------------------------------------------------------------
// | 骑士发卡 [ 平顶山若拉网络科技有限公司，并保留所有权利 ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016~2020 https://www.qqss.net All rights reserved.
// +----------------------------------------------------------------------
// | Licensed 骑士软件 并不是自由软件，商业用途务必到官方购买正版授权, 以免引起不必要的法律纠纷.
// +----------------------------------------------------------------------
// | Author: QQSS <admin@qqss.net>
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
        // 创建默认店铺
        $shop = [
            'user_id'     => $user_id,
            'shop_verify' => 1,
            'shop_status' => 1,
            'create_at'   => time(),
        ];
        $shop = \app\common\model\ShopList::create($shop);

    }

}
