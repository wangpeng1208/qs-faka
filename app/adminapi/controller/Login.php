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

namespace app\adminapi\controller;

use app\common\model\AdminUser;
use app\service\user\UserService;

class Login extends Base
{
    protected $noLoginAction = ['login', 'quickLogin', 'config'];

    public function login()
    {
        // 管理员登陆
        $data     = $this->request->post();
        $validate = new \app\adminapi\validate\LoginValidate;
        $validate->failException(true)->check($data);
        $user = AdminUser::where('username', $data['username'])->findOrEmpty();
        if ($user->isEmpty()) {
            throw new \Exception('账号不存在');
        }
        if (!password_verify($data['password'], $user->password)) {
            throw new \Exception('密码错误');
        }

        $token = (new UserService())->createToken($user->toArray(), 'admin');
        $data  = array_merge($user->toArray(), $token);
        $this->success('登陆成功', $data);
    }

}