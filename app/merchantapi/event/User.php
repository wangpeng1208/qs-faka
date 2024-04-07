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

use app\common\model\User as UserModel;
use app\common\model\UserRoleRelation;
use app\common\model\InviteCode;
use app\service\notify\SigninNotifyService;

class User
{
    /**
     * 注册推广
     *
     * @param [type] $userInfo
     * @return void
     */
    function signinSpread($userInfo)
    {
        // 用户组权限
        $this->userRole($userInfo["user_id"]);
        // 邀请码|推广奖励 
        $this->invite($userInfo);
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

    private function invite($userInfo)
    {
        // 不要使用函数 extract
        // extract($userInfo);

        // 直接从数组中获取需要的值
        $invite_code = $userInfo['invite_code'] ?? null;
        $parent_id   = $userInfo['parent_id'] ?? null;
        $user_id     = $userInfo['user_id'] ?? null;
        $invite_type = $userInfo['invite_type'] ?? null;
        $username    = $userInfo['username'] ?? null;

        // 如果存在邀请码
        if ($invite_code) {
            // 标记邀请码已使用
            InviteCode::where(['code' => $invite_code, 'user_id' => $parent_id])->update(['status' => 1, 'invite_uid' => $user_id, 'invite_at' => time()]);
        }
        // 如果有上级
        if ($parent_id) {
            // 绑定推广关系
            UserModel::where("id", $user_id)->update(["parent_id" => $parent_id]);
            // 开启了推广奖励
            if (conf("spread_reward")) {
                // 奖励方式一 赠送积分 spread_reward_money
                $spread_reward_money = (float) conf("spread_reward_money");
                $text                = $invite_type == 1 ? "通过邀请码" : "通过推广链接";
                if ($spread_reward_money > 0) {
                    $puser = UserModel::where("id", $parent_id)->find();
                    $puser->inc("money", $spread_reward_money)->update();
                    record_user_money_log("sub_register", $parent_id, $spread_reward_money, $puser->money + $spread_reward_money, $text . "成功推荐用户【{$username}】");
                }
            }
        }
    }

    // 创建默认店铺
    function createShop($user_id)
    {
        // 获取店铺默认审核配置
        $shop_config = conf("shop_verify");
        if ($shop_config == 1) {
            // 创建默认店铺
            $shop = [
                'user_id'     => $user_id,
                'shop_verify' => $shop_config,
                'shop_status' => 1,
                'create_at'   => time(),
            ];
            $shop = \app\common\model\ShopList::create($shop);
        }
    }

    // 登录通知
    function signinNotify($user)
    {
        $SigninNotify = new SigninNotifyService();
        $SigninNotify->notify($user);
    }
}
