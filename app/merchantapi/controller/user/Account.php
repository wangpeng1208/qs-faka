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

namespace app\merchantapi\controller\user;

use app\service\user\MerchantUserService;
use app\merchantapi\controller\Base;

class Account extends Base
{
    protected $noLoginAction = ['registerConfig', 'register', 'login', 'sendSmsCode', 'sendEmailCode', 'createVerify', 'checkVerify'];

    /**
     * 注册配置
     */
    public function registerConfig(MerchantUserService $merchantUserService)
    {
        $this->success("获取成功", $merchantUserService->userRegisterConfig());
    }

    /**
     * 用户注册
     */
    public function register(MerchantUserService $merchantUserService)
    {
        $merchantUserService->register();
        $this->success("注册成功");
    }

    /**
     * 用户登录
     */
    public function login(MerchantUserService $merchantUserService)
    {
        $params   = $this->request->post();
        $username = $params['username'];
        $password = $params['password'];
        $user     = $merchantUserService->login($username, $password);
        $this->success('登录成功', $user);
    }

    /**
     * 检查注册状态
     * @return mixed
     */
    private function registerStatusCheck()
    {
        if (conf("site_register_status") == 0) {
            $this->error("抱歉，目前站点禁止新用户注册");
        }
    }

    /**
     * 发送短信验证码
     */
    public function sendSmsCode(MerchantUserService $merchantUserService)
    {
        $merchantUserService->sendSmsCode();
        $this->success("已发送验证码到你的手机，请注意查收！！");
    }

    /**
     * 发送邮箱验证码
     */
    public function sendEmailCode(MerchantUserService $merchantUserService)
    {
        $merchantUserService->sendEmailCode();
        $this->success("已发送验证码到你的邮箱，请注意查收！！");
    }

}
