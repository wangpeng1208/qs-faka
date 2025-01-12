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

namespace app\merchantapi\controller\user;

use support\Cache;
use app\merchantapi\controller\Base;
use app\common\util\RoleMerchantAuth;
use app\service\message\EmailMessageService;

class User extends Base
{

    /**
     * 设置用户头像
     */
    public function setAvatar()
    {
        $avatar             = inputs('avatar', '');
        $this->user->avatar = $avatar;
        $result             = $this->user->save();
        return $result ? $this->success("保存成功") : $this->error("保存失败");
    }


    /**
     * @notes 绑定邮箱
     * @auth false
     */
    public function bindEmail()
    {
        $data     = [
            'email'      => inputs('email', ''),
            'email_code' => inputs('code', '')
        ];
        $validate = new \app\merchantapi\validate\user\UserValidate;
        $validate->scene('bindEmail')->failException(true)->check($data);

        $this->user->email = $data['email'];
        $result            = $this->user->save();
        return $result ? $this->success("保存成功") : $this->error("保存失败");
    }

    /**
     * @notes 发送邮箱验证码
     * @auth false
     */
    public function sendEmailCode()
    {
        $data     = [
            'email' => inputs('email', '')
        ];
        $validate = new \app\merchantapi\validate\user\UserValidate;
        $validate->scene('sendEmailCode')->failException(true)->check($data);
        $code = rand(100000, 999999);
        EmailMessageService::send($data['email'], '绑定邮箱验证码', '您的验证码为：' . $code);
        Cache::set('email_code_' . $data['email'], $code, 300);
        $this->success('发送成功');
    }

    /**
     * @notes 商户重置密码
     * @auth false
     */
    public function resetPassword()
    {
        $data     = [
            'password'      => inputs('password', ''),
            'new_password'  => inputs('new_password', ''),
            'new_password2' => inputs('new_password2', ''),
            'id'            => $this->user->id
        ];
        $validate = new \app\merchantapi\validate\user\UserValidate;
        $validate->scene('resetPassword')->failException(true)->check($data);
        $result = $this->user->update(
            [
                'password' => password_hash($data['new_password'], PASSWORD_DEFAULT)
            ],
            ['id' => $this->user->id]
        );
        return $result ? $this->success("重置成功") : $this->error("重置失败");
    }

    /**
     * notes 商户登录日志
     * @auth false
     */
    public function loginLog()
    {
        $time = strtotime("-30 day");
        $res  = $this->user->loginLogs()->whereTime("create_at", ">=", $time)->order("id desc")->paginate($this->limit)->each(function ($item) {
            $item->username = $this->user->username;
        });
        $this->success('获取成功', [
            'list'  => $res->items(),
            'total' => $res->total(),
        ]);
    }

    /**
     * notes 商户资料请求
     * @auth false
     */
    public function userDetail()
    {
        $user_visible_field = ['id', 'username', 'status', 'mobile', 'email', 'lastlogintime', 'is_freeze', 'create_at', 'avatar'];

        $data = [
            'shop'  => $this->user->shop,
            'user'  => $this->user->hidden(['shop'])->visible($user_visible_field),
            'perms' => (new RoleMerchantAuth())->getUserPerms($this->user)
        ];

        $this->success('获取成功', $data);
    }

}