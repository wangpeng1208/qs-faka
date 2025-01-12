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

namespace app\merchantapi\validate\user;

use taoser\Validate;
use support\Cache;
use app\common\model\User as UserModel;

class UserValidate extends Validate
{
    protected $rule = [
        'id'            => 'require',
        'email'         => 'require|email',
        'email_code'    => 'require|checkEmailCode',
        'password'      => 'require',
        'new_password'  => 'require',
        'new_password2' => 'require|confirm:new_password',
    ];

    protected $message = [
        'email.require'             => '邮箱不能为空',
        'email.email'               => '邮箱格式不正确',
        'email.checkEmailUnique'    => '邮箱已注册',
        'email_code.require'        => '验证码不能为空',
        'email_code.checkEmailCode' => '验证码错误',
        'password.require'          => '密码不能为空',
        'new_password.require'      => '新密码不能为空',
        'new_password2.require'     => '确认密码不能为空',
        'new_password2.confirm'     => '两次密码不一致',
        'password.checkPassword'    => '密码错误',
    ];

    protected function checkEmailCode($value, $rule, $data)
    {
        $cache_code = Cache::get('email_code_' . $data['email']);
        if ($value != $cache_code) {
            return false;
        } else {
            return true;
        }
    }
    // checkEmailUnique 验证邮箱是否唯一
    protected function checkEmailUnique($value, $rule, $data)
    {
        $user = UserModel::where('email|username', $value)->find();
        if (!empty($user)) {
            return false;
        } else {
            return true;
        }
    }

    public function sceneBindEmail()
    {
        return $this->only(['email', 'email_code']);
    }

    public function scenesendEmailCode()
    {
        return $this->only(['email'])
            ->append('email', 'checkEmailUnique');
    }

    protected function checkPassword($value, $rule, $data)
    {
        $user = UserModel::where('id', $data['id'])->find();
        if (!password_verify($value, $user->password)) {
            return false;
        } else {
            return true;
        }
    }

    public function sceneResetPassword()
    {
        return $this->only(['password', 'new_password', 'new_password2'])
            ->append('password', 'checkPassword');
    }
}