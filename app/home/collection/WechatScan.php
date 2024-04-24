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

namespace app\home\collection;

use Yansongda\Pay\Pay;
use app\service\pay\PayService;
use app\home\collection\interfaces\CollectionInterface;

/**
 * @note 微信扫码支付 
 * @var $trade_no string 外部单号
 * @var  $order object 订单
 * @var $config array 配置
 * @field  params 商户号:mch_id|v3 商户私钥:mch_secret_key|商户私钥证书:mch_secret_cert|商户公钥证书:mch_public_cert_path
 * tips 未经测试
 */
class WechatScan extends PayService implements CollectionInterface
{
    private $trade_no = '';
    private $order;
    private $config = [];

    private function init($trade_no)
    {
        $this->trade_no = $trade_no;
        $this->order    = $this->loadOrder($trade_no);
        $this->config();
    }
    private function config()
    {
        if ($this->order === false) {
            return;
        }
        $this->config['wechat']['default'] = [
            // 必填-商户号，服务商模式下为服务商商户号
            // 可在 https://pay.weixin.qq.com/ 账户中心->商户信息 查看
            'mch_id'               => $this->order->channelAccount->params->mch_id,
            /// 必填-v3 商户秘钥
            // 即 API v3 密钥(32字节，形如md5值)，可在 账户中心->API安全 中设置
            'mch_secret_key'       => $this->order->channelAccount->params->mch_secret_key,

            // 必填-商户私钥 字符串或路径
            // 即 API证书 PRIVATE KEY，可在 账户中心->API安全->申请API证书 里获得
            // 文件名形如：apiclient_key.pem
            'mch_secret_cert'      => $this->order->channelAccount->params->mch_secret_cert,

            // 必填-商户公钥证书路径
            // 即 API证书 CERTIFICATE，可在 账户中心->API安全->申请API证书 里获得
            // 文件名形如：apiclient_cert.pem
            'mch_public_cert_path' => $this->order->channelAccount->params->mch_public_cert_path,
            'notify_url'           => conf('site_domain') . '/home/pay/notify',
            'service_provider_id'  => '',
            // 选填-默认为正常模式。可选为： MODE_NORMAL, MODE_SANDBOX, MODE_SERVICE
            'mode'                 => Pay::MODE_NORMAL,
        ];
    }

    /**
     * Web支付
     * @param string $trade_no 外部单号
     * @param string $subject 标题
     * @param float $totalAmount 支付金额
     */
    public function pay($trade_no, $subject, $totalAmount)
    {
        $this->init($trade_no);
        try {
            // 跳过pay 的单例模式，强制更新配置
            Pay::config(array_merge($this->config, ['_force' => true]));

            $data   = [
                'out_trade_no' => $trade_no,
                'amount'       => [
                    'total' => $totalAmount, //单位 元
                ],
                'description'  => $subject . '如有售后请返回购买页咨询', //订单标题
            ];
            $result = Pay::wechat()->scan($data);
            // 返回二维码内容
            return $result->code_url;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * 退款
     * @param string $trade_no 外部单号
     * @param float $totalAmount 支付金额
     */

    public function refund($order)
    {
        $this->init($order->trade_no);
        try {
            Pay::config($this->config);
            $res = Pay::wechat()->refund([
                'out_trade_no'  => $order->trade_no,
                'out_refund_no' => time(),
                'amount'        => [
                    'refund'   => $order->total_price,
                    'total'    => $order->total_price,
                    'currency' => 'CNY',
                ],
            ]);
            // 根据微信退款接口返回的状态码进行处理
            switch ($res['return_code']) {
                case 'SUCCESS':
                    $order->status = 3;
                    $order->save();
                    $res['code'] = 1;
                    $res['msg'] = '退款成功';
                    break;
                case 'FAIL':
                    $res['code'] = 0;
                    $res['msg'] = '退款失败';
                    break;
                default:
                    $res['code'] = 0;
                    $res['msg'] = '未知错误';
                    break;
            }
            return $res;
        } catch (\Exception $e) {
            $res['code'] = 0;
            $res['msg']  = $e->getMessage();
            return $res;
        }
    }

    /**
     * todo 回调 v3
     */
    public function notify($request)
    {
        $this->init($request['out_trade_no']);
        Pay::config($this->config);
        try {
            $result = Pay::wechat()->callback($request);
            // 根据微信支付回调接口返回的参数进行处理
            if ($result['return_code'] == 'SUCCESS' && $result['result_code'] == 'SUCCESS') {
                $this->order->transaction_id = $result['transaction_id'];
                $this->order->status->save();
                // 在订单模型中添加一个完成订单方法
                $this->order->completeOrder($this->order);
            } else {
                record_file_log('wechat_scan_notify',  $result);
                return false;
            }
        } catch (\Exception $e) {
            return false;
        }
        return true;
    }
}