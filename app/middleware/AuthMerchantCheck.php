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

namespace app\middleware;

use Webman\MiddlewareInterface;
use Webman\Http\Response;
use Webman\Http\Request;
use app\common\exception\HttpResponseException;
use app\common\model\User as UserModel;
use app\common\util\TokenAuth;

class AuthMerchantCheck implements MiddlewareInterface
{
    public function process(Request $request, callable $handler): Response
    {
        request()->userType = 'merchant';
        try {
            $user = TokenAuth::parseToken('merchant');
        } catch (\Exception $e) {
            throw new HttpResponseException(401, ['msg' => $e->getMessage()]);
        }
        $user = UserModel::where("id", $user['id'])->find();
        if ($user) {
            if ($user->status != 1) {
                throw new HttpResponseException(401, ['msg' => '账号未审核']);
            }
            if ($user->is_freeze === 1) {
                throw new HttpResponseException(401, ['msg' => '账号被冻结']);
            }
        } else {
            throw new HttpResponseException(401, ['msg' => '账号不存在']);
        }
        request()->user = $user;
        // 请求继续向洋葱芯穿越
        return $handler($request);
    }
}
