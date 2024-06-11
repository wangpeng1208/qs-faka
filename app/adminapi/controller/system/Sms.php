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

namespace app\adminapi\controller\system;

use app\adminapi\controller\Base;
use app\service\sms\SmsConfigService;

class Sms extends Base
{
    public function list()
    {
        $list = SmsConfigService::list();
        return $this->success('获取成功', [
            'list'  => $list,
            'total' => count($list),
        ]);
    }

    // 返回各个平台的配置信息字段
    public function smsConfig()
    {
        $type   = inputs('type');
        $config = [];
        switch ($type) {
            case 'qcloud':
                $config = [
                    ['label' => 'AppID', 'value' => 'sdk_app_id'],
                    ['label' => 'SECRET ID', 'value' => 'secret_id'],
                    ['label' => 'SECRET KEY', 'value' => 'secret_key'],
                    ['label' => '签名', 'value' => 'sign_name'],
                ];
                break;
            case 'ucloud':
                $config = [
                    ['label' => '公钥', 'value' => 'public_key'],
                    ['label' => '私钥', 'value' => 'private_key'],
                    ['label' => '短信签名', 'value' => 'sig_content'],
                    ['label' => '项目ID', 'value' => 'project_id'],
                ];
                break;
            case 'qiniu':
                $config = [
                    ['label' => 'AccessKey', 'value' => 'access_key'],
                    ['label' => 'SecretKey', 'value' => 'secret_key'],
                ];
                break;
            case 'sendcloud':
                $config = [
                    ['label' => 'sms_user', 'value' => 'sms_user'],
                    ['label' => 'sms_key', 'value' => 'sms_key'],
                    ['label' => '是否启用时间戳', 'value' => 'timestamp'],
                ];
                break;
            case 'aliyun':
                $config = [
                    ['label' => 'AccessKeyID', 'value' => 'access_key_id'],
                    ['label' => 'AccessKeySecret', 'value' => 'access_key_secret'],
                    ['label' => '签名', 'value' => 'sign_name'],
                ];
                break;
            case 'yunpian':
                $config = [
                    ['label' => 'API_KEY', 'value' => 'api_key'],
                    ['label' => '【默认签名】', 'value' => 'signature'],
                ];
                break;
            // 按自己需求配置更多 配置教程 https://github.com/overtrue/easy-sms
        }

        return $this->success('获取成功', $config);
    }

    // 获取短信配置信息
    public function getSmsConfig()
    {
        $type = inputs('type');
        $data = conf('sms.' . $type);
        return $this->success('获取成功', $data);
    }

    // 设置短信配置信息
    public function setSmsConfig()
    {
        // 短信类型
        $type = inputs('type');
        // 配置信息
        $data = inputs('data/a', []);
        // 保存到 sms.配置名
        conf('sms.' . $type, $data);
        return $this->success('设置成功');
    }

}