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

namespace app\service\common;

use app\common\model\AdminLog;
use app\common\model\MerchantLog;

/**
 * 操作日志服务
 * Class LogService
 * @package service
 */
class LogService
{
    
    protected $sence;

    // 设置场景
    public function sence($sence)
    {
        $this->sence = $sence;
        return $this;
    }

    // 写入日志
    public  function write(){
        switch ($this->sence) {
            case 'admin':
                $this->adminLog(...func_get_args());
                break;
            case 'merchant':
                $this->merchantLog(...func_get_args());
                break;
            default:
                # code...
                break;
        }
    }
    
    // 管理员操作日志
    public  function adminLog($user, $params, $action = '行为', $content = "内容描述")
    {
        $data = [
            'ip'       => request()->ip(),
            'params'   => $params ?? '',
            'username' => $user->username,
            'action'   => $action,
            'content'  => $content
        ];
        AdminLog::create($data);
    }

    //  商户操作日志
    public  function merchantLog($user, $params, $action = '行为', $content = "内容描述")
    {
        $data = [
            'ip'       => request()->ip(),
            'params'   => $params ?? '',
            'username' => $user->username,
            'user_id'  => $user->id,
            'action'   => $action,
            'content'  => $content
        ];
        MerchantLog::create($data);
    }
}
