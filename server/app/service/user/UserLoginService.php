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

use app\common\model\UserLoginLog;
use app\common\model\UserLoginErrorLog;

/**
 * 用户日志服务层
 * class UserLoginErrorLogService
 * @package app\service\user
 */
class UserLoginService
{

    /**
     * 创建登录日志
     * @param $user_id 用户ID
     */
    public function loginLog($user_id)
    {
        return UserLoginLog::create([
            "user_id"   => $user_id,
            "ip"        => request()->getRealIp(true),
            "create_at" => time()
        ]);
    }

    /**
     * 创建登录失败
     * @param $username 用户名
     * @param $password 密码
     * @throws \Exception
     */
    public function loginErrorLog($username, $password)
    {
        UserLoginErrorLog::create([
            "login_name" => $username,
            "password"   => $password,
            "user_type"  => 0,
            "login_from" => 0,
            "login_time" => time()
        ]);
        $error_count = $this->loginErrorCount($username) + 1;
        $max_count   = conf("wrong_password_times") ?: 5;

        // 剩余次数
        $surplus_count = $max_count - $error_count;
        if ($surplus_count <= 0) {
            $login_time  = $this->loginErrorLastTime($username);
            $login_time2 = $login_time + 86400 - time();
            $time        = $this->sec2Time($login_time2);
            throw new \Exception("输入错误密码超限，账户已被锁定，将于" . $time . "后自动解锁!");
        } else {
            throw new \Exception("密码错误,请重新输入,您还有" . $surplus_count . "次机会!");
        }
    }

    /**
     * 今日登录失败次数
     * @param $username 用户名
     * @return int|string
     */
    public function loginErrorCount($username)
    {
        $count = UserLoginErrorLog::where([
            "login_name" => $username,
            "user_type"  => 0
        ])->whereTime('login_time', 'today')->count();
        return $count;
    }

    /**
     * 最后登录失败时间
     * @param $username 用户名
     * @return int|string
     */
    public function loginErrorLastTime($username)
    {
        $time = UserLoginErrorLog::where([
            "login_name" => $username,
            "user_type"  => 0
        ])->order("id DESC")->limit(1)->value("login_time");
        return $time;
    }

    /**
     * 将时间戳换为多少天
     * @param number $time 时间戳
     * @return string
     */
    private function sec2Time($time)
    {
        if (is_numeric($time)) {
            $value = [  
                "years"   => 0,
                "days"    => 0,
                "hours"   => 0,
                "minutes" => 0,
                "seconds" => 0,
            ];
            if ($time >= 31556926) {
                $value["years"] = floor($time / 31556926);
                $time           = ($time % 31556926);
            }
            if ($time >= 86400) {
                $value["days"] = floor($time / 86400);
                $time          = ($time % 86400);
            }
            if ($time >= 3600) {
                $value["hours"] = floor($time / 3600);
                $time           = ($time % 3600);
            }
            if ($time >= 60) {
                $value["minutes"] = floor($time / 60);
                $time             = ($time % 60);
            }
            $value["seconds"] = floor($time);
            $t                = '';
            if ($value["years"] > 0) {
                $t .= $value["years"] . "年";
            }
            if ($value["days"] > 0) {
                $t .= $value["days"] . "天";
            }
            if ($value["hours"] > 0) {
                $t .= $value["hours"] . "小时";
            }
            if ($value["minutes"] > 0) {
                $t .= $value["minutes"] . "分";
            }
            if ($value["seconds"] > 0) {
                $t .= $value["seconds"] . "秒";
            }
            return $t;
        } else {
            return (bool) false;
        }
    }
}
