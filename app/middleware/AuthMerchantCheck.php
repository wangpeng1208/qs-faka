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
