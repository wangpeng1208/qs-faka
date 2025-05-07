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

namespace app\home\collection;

use Yansongda\Pay\Pay;
use app\service\common\PayService;
use app\home\collection\interfaces\CollectionInterface;
use app\common\model\ChannelAccount;
use support\Log;

/**
 * @note 微信公众号支付 即JSAPI支付
 * @var $trade_no string 外部单号
 * @var $order object 订单
 * @var $config array 配置
 * @field  params 商户号:mch_id|公众号APPID:appid|v3 商户私钥:mch_secret_key|商户私钥证书:mch_secret_cert|商户公钥证书:mch_public_cert_path
 */
class WechatMp extends PayService implements CollectionInterface
{
    private $trade_no = '';
    private $order;
    private $config = [];

    private function init($type, $value)
    {
        if ($type == 'trade_no') {
            $this->trade_no = $value;
            $this->order    = $this->loadOrder($value);

            $this->config['wechat']['default'] = [
                'app_id'               => $this->order->channelAccount->params->app_id,
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
                'notify_url'           => conf('site_domain') . '/home/pay/notify?account_id=' . $this->order->channel_account_id,
                'service_provider_id'  => '',
                // 选填-默认为正常模式。可选为： MODE_NORMAL, MODE_SANDBOX, MODE_SERVICE
                'attach'               => $this->trade_no,

                'mode'                 => Pay::MODE_NORMAL,
            ];
        }
        if ($type == 'account_id') {
            $channelAccount = ChannelAccount::where('status', 1)->findOrFail($value);

            $this->config['wechat']['default'] = [
                'app_id'               => $channelAccount->params->appid,
                'mch_id'               => $channelAccount->params->mch_id,
                'mch_secret_key'       => $channelAccount->params->mch_secret_key,
                'mch_secret_cert'      => $channelAccount->params->mch_secret_cert,
                'mch_public_cert_path' => $channelAccount->params->mch_public_cert_path,
                'notify_url'           => conf('site_domain') . '/home/pay/notify?account_id=' . $channelAccount->id,
                'mode'                 => Pay::MODE_NORMAL,
            ];
        }
    }

    /**
     * Web支付
     * @param string $trade_no 外部单号
     * @param string $subject 标题
     * @param float $totalAmount 支付金额
     */
    public function pay($trade_no, $subject, $totalAmount)
    {
        $this->init('trade_no', $trade_no);

        try {
            // 跳过pay 的单例模式，强制更新配置
            Pay::config(array_merge($this->config, ['_force' => true]));

            $data = [
                'out_trade_no' => $trade_no,
                'amount'       => [
                    'total' => $totalAmount * 100, //单位 分
                ],
                'description'  => $subject . '如有售后请返回购买页咨询', //订单标题
            ];
            // 返回 Collection 实例。包含了调用 JSAPI 的所有参数，如appId，timeStamp，nonceStr，package，signType，paySign 等；
            $result = Pay::wechat()->mp($data);
            // 构造html页面
            $html = <<<EOF
            <script>
                function onBridgeReady() {
                    WeixinJSBridge.invoke(
                        'getBrandWCPayRequest', {
                            "appId": "{$result['appId']}",
                            "timeStamp": "{$result['timeStamp']}",
                            "nonceStr": "{$result['nonceStr']}",
                            "package": "{$result['package']}",
                            "signType": "{$result['signType']}",
                            "paySign": "{$result['paySign']}"
                        },
                        function(res) {
                            if (res.err_msg == "get_brand_wcpay_request:ok") {
                                alert('支付成功');
                                window.location.href = "{$result['success_url']}";
                            } else {
                                alert('支付失败');
                                window.location.href = "{$result['fail_url']}";
                            }
                        }
                    );
                }
                if (typeof WeixinJSBridge == "undefined") {
                    if (document.addEventListener) {
                        document.addEventListener('WeixinJSBridgeReady', onBridgeReady, false);
                    } else if (document.attachEvent) {
                        document.attachEvent('WeixinJSBridgeReady', onBridgeReady);
                        document.attachEvent('onWeixinJSBridgeReady', onBridgeReady);
                    }
                } else {
                    onBridgeReady();
                }
            </script>
EOF;

            return $html;
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
        $this->init('trade_no', $order->trade_no);
        try {
            Pay::config(array_merge($this->config, ['_force' => true]));
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
     * 回调 v3
     */
    public function notify($request, $account_id)
    {
        if ($request['summary'] != '支付成功') {
            return false;
        }
        $this->init('account_id', $account_id);
        Pay::config(array_merge($this->config, ['_force' => true]));
        try {
            $result = Pay::wechat()->callback($request);
            // 根据微信支付回调接口返回的参数进行处理
            if ($result['resource']['ciphertext']['trade_state'] == 'SUCCESS') {
                // 通过自定义数据查询订单
                $this->order = $this->loadOrder($result['resource']['ciphertext']['out_trade_no']);
                // 保存微信返回的支付订单号
                $this->order->transaction_id = $result['resource']['ciphertext']['transaction_id'];
                $this->order->save();
                // 在订单模型中添加一个完成订单方法
                $this->order->completeOrder($this->order);
            } else {
                config('app.debug') && Log::channel('pay')->error($result);
                return false;
            }
        } catch (\Exception $e) {
            return false;
        }
        return true;
    }
}
