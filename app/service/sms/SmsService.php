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

namespace app\service\sms;

use app\common\model\SystemNotification;
use Overtrue\EasySms\Exceptions\NoGatewayAvailableException;
use app\service\sms\SmsConfigService;

class SmsService
{
    // 部分短信通知，不要求短信必达，所以使用errorMessage记录错误信息，而不要使用异常抛出
    protected $errorMessage;

    /**
     * 发送短信通知
     * @param  $screen 短信场景
     * @param  $mobile 手机号
     * @param  $params 短信参数
     */
    public function sendSms($screen, $mobile, $params)
    {
        // $mobile 验证是否是手机号
        if (!preg_match("/^1[3456789]\d{9}$/", $mobile)) {
            $this->errorMessage = '手机号格式错误';
            return false;
        }
        $channel = $this->getNotificationChannel($screen);
        if (!$channel) {
            return false;
        }
        try {
            $server = (new SmsConfigService())->config($channel['sms_gateway']);
            $result = $server->send($mobile, [
                // 'content'  => (!empty($params) && isset($params['code'])) ? '您的验证码为' . $params['code'] : null,
                'template' => $channel['sms_template_id'],
                'data'     => $params,
            ]);
            if ($result[$channel['sms_gateway']]['status'] === 'success') {
                return true;
            }
        } catch (NoGatewayAvailableException $e) {
            $this->errorMessage = '短信服务：' . $e->getException($channel['sms_gateway'])->getMessage();
            return false;
        }
    }

    /**
     * 短信场景获取短信平台
     * @param  $screen 短信场景
     * @return string 短信平台 
     */
    public function getNotificationChannel($screen)
    {
        $notification = SystemNotification::where('mark', $screen)->find();
        if (empty($notification)) {
            $this->errorMessage = '通知场景不存在';
            return false;
        }
        if ($notification->is_sms == 0) {
            $this->errorMessage = '通知场景:' . $notification->name . ' 已禁用短信通知，请联系管理员开启';
            return false;
        }
        if (empty($notification->sms_config->sms_gateway)) {
            $this->errorMessage = '通知场景:' . $notification->name . '未配置选择短信平台';
            return false;
        }

        $data['sms_template_id'] = $notification->sms_config->sms_template_id ?? '';
        $data['sms_gateway']     = $notification->sms_config->sms_gateway;
        return $data;
    }

    /**
     * 获取短信费用
     */
    public function getSmsPrice($screen)
    {
        $price        = 0;
        $notification = SystemNotification::where('mark', $screen)->find();
        if (!empty($notification) && $notification->is_sms != 0 && !empty($notification->sms_config->sms_gateway)) {
            $sms_gateway = $notification->sms_config->sms_gateway;
            $config      = conf('sms.' . $sms_gateway);
            if (!empty($config)) {
                $price = $config['price'] ?? 0;
            }
        }
        return $price;
    }

    public function getErrorMessage()
    {
        return $this->errorMessage;
    }
}
