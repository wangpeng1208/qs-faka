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
