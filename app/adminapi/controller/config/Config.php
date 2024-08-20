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

namespace app\adminapi\controller\config;

use app\adminapi\controller\Base;
use app\service\message\EmailMessageService;

class Config extends Base
{
    /**
     * @notes 获取配置
     * @auth true
     */
    public function getConfig()
    {
        $field = inputs('field/a', []);
        $data  = [];
        foreach ($field as $value) {
            $data[$value] = conf($value);
        }
        $this->success('获取成功', $data);
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
        $this->success('编辑成功');
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
        // 从发送中捕捉异常
        EmailMessageService::send($address, '邮箱测试', '这是一份来自【' . conf('site_name') . '】的邮箱测试！');
        $this->success('发送成功！');

    }
}