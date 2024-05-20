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

namespace app\service\user;

use app\common\util\TokenAuth;

/**
 * 公共用户服务层
 * class UserService
 * @package app\service\user
 */
class UserService
{

    /**
     * 创建token
     * @param array $user 用户信息
     * @param string $type 场景（admin，merchant）
     * @return array
     */
    public function createToken($user, $type = 'merchant')
    {
        return [
            'access_token' => TokenAuth::createToken($user['id'], $type, $user, 3600 * 24 * 30)['token']
        ];
    }
}
