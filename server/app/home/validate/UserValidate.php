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

namespace app\home\validate;

use taoser\Validate;

class UserValidate extends Validate
{
    protected $rule = [
        'username'    => 'require|unique:user|checkWordFilter',
        'email'       => 'email|require|unique:user,username^mobile',
        'mobile'      => 'mobile|require|unique:user,username^mobile',
        'password'    => 'require|min:8|max:16',
        'email_code'  => 'require',
        'mobile_code' => 'require',
        'checkboxEd'  => 'require',
    ];
    protected $message = [
        'username.require'    => '请输入用户名',
        'username.unique'     => '用户名已存在',
        'email.require'       => '邮箱未填写!',
        'email.unique'        => '邮箱已被使用',
        'email.email'         => '邮箱格式不正确',
        'mobile.require'      => '手机号未填写',
        'mobile.mobile'       => '手机号格式不正确',
        'mobile.unique'       => '手机号已被使用',
        'password.require'    => '密码未填写',
        'password.min'        => '密码位数必须在8~16位之间',
        'password.max'        => '密码位数必须在8~16位之间',
        'email_code.require'  => '邮箱验证码未填写',
        'mobile_code.require' => '手机验证码未填写',
        'checkboxEd.require'  => '请勾选同意协议',
    ];

    // checkWordFilter
    protected function checkWordFilter($value, $rule, $data = [], $field = '')
    {
        $res = check_wordfilter($value);
        if ($res) {
            return "包含敏感词汇“" . $res . "”！";
        }
        // 不能是手机号或者邮箱
        // 正则
        $isMobile = '/^1[3456789]\d{9}$/';
        $isEmail  = '/^[\w-]+(\.[\w-]+)*@[\w-]+(\.[\w-]+)+$/';
        if (preg_match($isMobile, $value)) {
            return '用户名不能是手机号格式';
        }
        if (preg_match($isEmail, $value)) {
            return '用户名不能是邮箱格式';
        }
        return true;
    }

    public function sceneRegister()
    {
        // 如果用户名必填
        $register = [];
        if (conf('site_register_need_username')) {
            $register = array_merge($register, ['username']);
        }
        // 如果邮箱必填
        if (conf('site_register_need_email')) {
            $register = array_merge($register, ['email']);
        }
        // 如果手机必填
        if (conf('site_register_need_mobile')) {
            $register = array_merge($register, ['mobile']);
        }
        // 如果邮箱验证码必填
        if (conf('site_register_need_email') && conf('site_register_need_email_check')) {
            $register = array_merge($register, ['email_code']);
        }
        // 如果手机验证码必填
        if (conf('site_register_need_mobile') && conf('site_register_need_mobile_check')) {
            $register = array_merge($register, ['mobile_code']);
        }
        $register = array_merge($register, ['password', 'checkboxEd']);
        return $this->only($register);
    }

    public function sceneEmailCode()
    {
        return $this->only(['email']);
    }

    public function sceneMobile()
    {
        return $this->only(['mobile']);
    }
}
