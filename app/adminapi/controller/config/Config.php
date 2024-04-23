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

namespace app\adminapi\controller\config;

use app\adminapi\controller\Base;
use app\service\message\EmailMessageService;

class Config extends Base
{
    /**
     * notes 获取配置
     * @auth true
     */
    public function getConfig()
    {
        $field = inputs('field/a', []);
        $data  = [];
        foreach ($field as $value) {
            $data[$value] = conf($value);
        }
        return $this->success('获取成功', $data);
    }

    /**
     * @notes 编辑配置
     * @auth true
     */
    public function editConfig()
    {
        $data = inputs('data/a', []);
        foreach ($data as $key => $value) {
            conf($key, $value);
        }
        return $this->success('编辑成功');
    }

    /**
     * @notes 邮箱测试
     * @return void
     */
    public function emailTest()
    {
        $address = inputs('address');
        if (!preg_match('/(\w)+(\.\w+)*@(\w)+((\.\w+)+)/', $address)) {
            $this->error('请输入正确的邮箱号！');
        }
        $res = EmailMessageService::send($address, '邮箱测试', '这是一份来自【' . conf('site_name') . '】的邮箱测试！');
        if ($res) {
            return $this->success('发送成功！');
        } 
    }
}