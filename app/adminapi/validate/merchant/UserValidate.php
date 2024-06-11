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

namespace app\adminapi\validate\merchant;

use taoser\Validate;

class UserValidate extends Validate
{
  protected $rule = [
    'id'       => 'require',
    'password' => 'require|length:6,20',
    'username' => 'require|length:2,20|unique:user|checkUsernameMobile|checkUsernameEmail',
    'mobile'   => 'mobile|unique:user',
    'email'    => 'email',
  ];

  protected $message = [
    'username.require'             => '用户名不能为空',
    'username.length'              => '用户名长度为2-20个字符',
    'username.unique'              => '用户名已存在',
    'username.checkUsernameMobile' => '用户名不能是手机箱格式',
    'username.checkUsernameEmail'  => '用户名不能是邮箱格式',

    'password.length'              => '密码长度为6-20个字符',
    'mobile.mobile'                => '手机号格式不正确',
    'email.email'                  => '邮箱格式不正确',
  ];

  protected function checkUsernameMobile($value, $rule, $data)
  {
    // username 不能是手机或者邮箱格式
    if (preg_match('/^1[3456789]\d{9}$/', $value)) {
      return false;
    }
    return true;
  }

  protected function checkUsernameEmail($value, $rule, $data)
  {
    if (preg_match('/^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/', $value)) {
      return false;
    }
    return true;
  }

  public function sceneAdd()
  {
    return $this->only(['username', 'password', 'mobile', 'email']);
  }

  public function sceneEdit()
  {
    return $this->only(['username', 'mobile', 'email']);
  }
}