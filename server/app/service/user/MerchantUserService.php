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

namespace app\service\user;

use support\Cache;
use Webman\Event\Event;
use app\common\model\User;
use app\service\sms\SmsService;
use app\service\message\EmailMessageService;

class MerchantUserService
{
    /**
     * 商户注册配置
     * @return array
     */
    public function userRegisterConfig()
    {
        return [
            // 是否开启注册
            'site_register_status'            => conf('site_register_status') ? true : false,
            // 是否开启验证状态
            'site_register_smscode_status'    => conf('site_register_smscode_status') ? true : false,
            'site_register_need_username'     => conf('site_register_need_username') ? true : false,
            'site_register_need_mobile'       => conf('site_register_need_mobile') ? true : false,
            'site_register_need_email'        => conf('site_register_need_email') ? true : false,
            'site_register_need_mobile_check' => conf('site_register_need_mobile_check') ? true : false,
            'site_register_need_email_check'  => conf('site_register_need_email_check') ? true : false,
        ];
    }

    /**
     * 注册手机验证码检查
     */
    private function mobile_code_check($mobile, $mobile_code)
    {
        $cache_mobile_code = Cache::get('mobile_code_register_' . $mobile);
        if ($mobile_code != $cache_mobile_code) {
            throw new \Exception("手机验证码错误");
        }
    }

    /**
     * 注册邮箱验证码验证
     */
    private function email_code_check($email, $code)
    {
        $code_cache = Cache::get('email_code_register_' . $email);
        if ($code_cache != $code) {
            throw new \Exception("邮箱验证码错误");
        }
    }

    /**
     * 检查注册状态
     * @return mixed
     */
    private function registerStatusCheck()
    {
        if (conf("site_register_status") == 0) {
            throw new \Exception("抱歉，目前站点禁止新用户注册");
        }
    }

    /**
     * 商户注册
     */
    public function register()
    {
        $data = inputs("reginfo/a", []);
        // 检查注册状态
        $this->registerStatusCheck();
        // 检查IP注册次数
        $data["ip"] = $this->registerIpCheck();
        $validate   = new \app\home\validate\UserValidate;
        $validate->scene('register')->failException(true)->check($data);
        // 如果$data 则使用mobile或者email
        // 生成随机用户名
        $username         = '商户' . get_random_string(6);
        $data["username"] = $data["username"] ?: $username;
        // 如果手机验证码必填
        if (conf('site_register_need_mobile') && conf('site_register_need_mobile_check')) {
            // 检查手机验证码
            $this->mobile_code_check($data["mobile"], $data["mobile_code"]);
        }
        // 如果邮箱验证码必填
        if (conf('site_register_need_email') && conf('site_register_need_email_check')) {
            // 检查邮箱验证码
            $this->email_code_check($data["email"], $data["email_code"]);
        }
        $data["password"]  = password_hash($data["password"], PASSWORD_DEFAULT);
        $data["money"]     = 0;
        $data["status"]    = conf("site_register_verify") == 1 ? 1 : 0;
        $data["create_at"] = time();
        $data["rate_type"] = 0;

        $user = User::create($data);
        if ($user) {
            Event::emit('user.addafter', $user->id);
            return true;
        } else {
            throw new \Exception("注册失败");
        }
    }

    /**
     * 检查IP注册次数
     * @dec 限制IP每天注册次数，防止恶意注册;未开启|未满时返回IP
     * @return mixed 
     */
    private function registerIpCheck()
    {
        $ip    = request()->ip();
        $count = User::where("ip", $ip)->whereTime("create_at", "today")->count();
        if ($count <= conf("ip_register_limit")) {
            return $ip;
        } else {
            throw new \Exception("IP：{$ip}今日注册次数超限！");
        }
    }

    /**
     * 用户登录
     * @param $username
     * @param $password
     * @return array
     * @throws \Exception
     */
    public function login($username, $password)
    {
        if (empty($username) || empty($password)) {
            throw new \Exception("账号密码不得为空");
        }

        $user = User::where(["username|mobile|email" => $username])->find();

        if (empty($user)) {
            throw new \Exception("账号不存在!");
        }
        if ($user->is_freeze == 1) {
            throw new \Exception("该账号已被冻结!");
        }
        if ($user->status == 0) {
            throw new \Exception("该账号未通过审核！");
        }
        if (!password_verify($password, $user->password)) {
            (new UserLoginService())->loginErrorLog($username, $password);
        }

        return $this->loginSuccess($user);
    }

    /**
     * 用户登录成功
     * @param User $user
     * @return array
     * @throws \Exception
     */
    public function loginSuccess(User $user)
    {
        (new UserLoginService())->loginLog($user->id);
        // 登陆时记录店铺状态和审核资料
        $shop['shop_status'] = $user->shop->shop_status ?? 0;
        $shop['shop_verify'] = $user->shop->shop_verify ?? 0;

        $user  = $user->toArray();
        $token = (new UserService())->createToken($user, 'merchant');
        $allowFields = ['id', 'username', 'status', 'mobile', 'lastlogintime', 'is_freeze'];
        $user        = array_intersect_key($user, array_flip($allowFields));
        Event::emit('user.login', $user);

        return array_merge($user, $token, $shop);
    }


    /**
     * 发送注册短信验证码
     * @param $screen 为发送场景
     */
    public function sendSmsCode()
    {
        $this->registerStatusCheck();
        $mobile   = request()->post('mobile');
        $validate = new \app\home\validate\UserValidate;
        $validate->scene('mobile')->failException(true)->check([
            'mobile' => $mobile,
        ]);
        $code   = rand(1000, 9999);
        $screen = inputs("screen/s", "register");

        Cache::set('mobile_code_register_' . $mobile, $code, 300);

        $sms = new SmsService();
        $res = $sms->sendSms($screen, $mobile, ['code' => $code]);
        if ($res === false) {
            throw new \Exception($sms->getErrorMessage());
        }
        // 记录验证码
        Cache::set('mobile_code_register_' . $mobile, $code, 300);
    }

    /**
     * 发送邮箱验证码
     */
    public function sendEmailCode()
    {
        $this->registerStatusCheck();
        $email    = inputs('email', '');
        $validate = new \app\home\validate\UserValidate;
        $validate->scene('emailCode')->failException(true)->check([
            'email' => $email,
        ]);
        $code = rand(100000, 999999);
        EmailMessageService::send($email, '绑定邮箱验证码', '您的验证码为：' . $code);
        Cache::set('email_code_register_' . $email, $code, 300);
    }

}