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
use app\common\util\TokenAuth;
use app\service\common\Api;
use app\common\exception\HttpResponseException;

class Base extends Api
{
    // 用户信息
    protected $user;
    // 每页显示条数
    protected $limit;
    // 不需要登录的方法
    protected $noLoginAction = [];

    public function __construct()
    {
        parent::__construct();
        $this->checkLogin();
        $this->setList();
    }

    /**
     * 检查登录
     */
    private function checkLogin()
    {
        // 如果是不需要登录的方法，直接通过
        if (in_array(request()->action, $this->noLoginAction)) {
            return true;
        }
        // 检查token
        try {
            $user = TokenAuth::parseToken('admin');
        } catch (\Exception $e) {
            throw new HttpResponseException(401, ['msg' => $e->getMessage()]);
        }
        // 开始检测用户权限
        $this->user = AdminUser::find($user['id']);
        // 设置request的user , 用于日志记录
        request()->user = $this->user;
    }
    
    /**
     * 列表分页设置
     */
    private function setList()
    {
        $this->limit = $this->request->post('limit', 20);
    }

}
