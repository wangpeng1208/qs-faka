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

use Overtrue\EasySms\EasySms;
use Overtrue\EasySms\Strategies\OrderStrategy;

class SmsConfigService
{
    
    /**
     * 短信配置
     * @param  $channel 通道 暂时选择单通道模式，后面如果需要在考虑多通道轮询
     */
    public function config($channel)
    {
        $config = [
            'default'  => [
                // 网关调用策略，默认：顺序调用
                'strategy' => OrderStrategy::class,
                // 默认可用的发送网关
                'gateways' => self::getGatewaysType($channel),
            ],
            'gateways' => self::getGatewaysConfig(),
        ];
        return new EasySms($config);
    }

    public static function getGatewaysType($channel)
    {
        $list = self::list();
        // status 为 1 的短信通道
        $gateways = array_column(array_filter($list, function ($item) {
            return $item['status'] == 1;
        }), 'value');
        if (!in_array($channel, $gateways)) {
            throw new \Exception('短信通道不存在或未开启');
        }
        return [$channel];
    }

    public static function getGatewaysConfig()
    {
        $list = self::list();
        // status 为 1 的短信通道的配置
        $gateways = array_column(array_filter($list, function ($item) {
            return $item['status'] == 1;
        }), 'config', 'value');
        return $gateways;
    }

    public static function list()
    {
        $list = [
            ['label' => '腾讯云 SMS', 'value' => 'qcloud'],
            ['label' => 'Ucloud', 'value' => 'ucloud'],
            ['label' => '七牛云', 'value' => 'qiniu'],
            ['label' => 'SendCloud', 'value' => 'sendcloud'],
            ['label' => '阿里云', 'value' => 'aliyun'],
            ['label' => '云片', 'value' => 'yunpian'],
            // ['label' => 'Submail', 'value' => 'submail'],
            // ['label' => '螺丝帽', 'value' => 'luosimao'],
            // ['label' => '容联云通讯', 'value' => 'yuntongxun'],
            // ['label' => '互亿无线', 'value' => 'huyi'],
            // ['label' => '聚合数据', 'value' => 'juhe'],
            // ['label' => '百度云', 'value' => 'baidu'],
            // ['label' => '华信短信平台', 'value' => 'huaxin'],
            // ['label' => '253云通讯（创蓝）', 'value' => 'chuanglan'],
            // ['label' => '创蓝云智', 'value' => 'chuanglancloud'],
            // ['label' => '融云', 'value' => 'rongcloud'],
            // ['label' => '天毅无线', 'value' => 'tianyiwuxian'],
            // ['label' => '阿凡达数据', 'value' => 'avatardata'],
            // ['label' => '华为云', 'value' => 'huawei'],
            // ['label' => '网易云信', 'value' => 'netease'],
            // ['label' => '云之讯', 'value' => 'yunzhixun'],
            // ['label' => '凯信通', 'value' => 'kaixintong'],
            // ['label' => 'UE35.net', 'value' => 'ue35'],
            // ['label' => '短信宝', 'value' => 'duanxinbao'],
            // ['label' => 'Tiniyo', 'value' => 'tiniyo'],
            // ['label' => '摩杜云', 'value' => 'moduyun'],
            // ['label' => '融合云（助通）', 'value' => 'rongheyun'],
            // ['label' => '蜘蛛云', 'value' => 'zhizhuyun'],
            // ['label' => '融合云信', 'value' => 'rongheyunxin'],
            // ['label' => '天瑞云', 'value' => 'tianruiyun'],
            // ['label' => '时代互联', 'value' => 'shidaihulian'],
            // ['label' => '火山引擎', 'value' => 'huoshanyinqing'],
        ];
        foreach ($list as $key => $value) {
            $list[$key]['config'] = conf('sms.' . $value['value']);
            if (empty($list[$key]['config'])) {
                $list[$key]['status'] = 0;
            } else {
                $list[$key]['status'] = $list[$key]['config']['status'] ?? 0;
            }
        }
        return $list;
    }

}
