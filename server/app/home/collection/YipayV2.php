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

use app\home\collection\interfaces\CollectionInterface;
use app\service\common\PayService;
use GuzzleHttp\Client;

/**
 * @note 易支付网页支付v2
 * @var $trade_no string 外部单号
 * @var $order object 订单
 * @var $config array
 * @field  params 接口地址:gateway|商户PID:pid|平台公钥:public_key|商户私钥:private_key|支付方式:type
 */
class YipayV2 extends PayService implements CollectionInterface
{
    /**
     * RSA SHA256 签名
     * @param string $data 待签名字符串
     * @param string $privateKey 商户私钥
     * @return string
     */
    private function rsaSign($data, $privateKey)
    {
        // 格式化私钥
        $privateKey = "-----BEGIN PRIVATE KEY-----\n" .
        wordwrap($privateKey, 64, "\n", true) .
            "\n-----END PRIVATE KEY-----";

        // 使用商户私钥进行 RSA 签名（SHA256WithRSA）
        openssl_sign($data, $signature, $privateKey, OPENSSL_ALGO_SHA256);

        // Base64 编码
        return base64_encode($signature);
    }

    public function pay($trade_no, $subject, $totalAmount)
    {
        $order = $this->loadOrder($trade_no);

        $channel_pid         = $order->channelAccount->params->pid;
        $channel_type        = $order->channelAccount->params->type;
        $channel_gateway     = $order->channelAccount->params->gateway;
        $channel_private_key = $order->channelAccount->params->private_key; // 商户私钥

        $callbackurl = conf('site_domain') . '/callback';
        $notifyurl   = conf('site_domain') . '/home/pay/notify';

        // pc使用jump到易支付页面。web是直接到对应的支付平台页面。所以pc使用jump，h5使用web
        $method = "jump";
        if (request()->isMobile()) {
            $method = "web";
        }
        // 对微信单独适配，使用跳转
        if ($channel_type == "wxpay") {
            $method = "jump";
        }
        $native = [
            "pid"          => $channel_pid,
            "type"         => $channel_type,
            "out_trade_no" => $trade_no,
            "notify_url"   => $notifyurl,
            "return_url"   => $callbackurl,
            "name"         => $subject,
            "money"        => $totalAmount,

            "method"       => $method,
            "sitename"     => conf('site_name'),
            "clientip"     => request()->ip(),
            "timestamp"    => time(),
        ];

        // 2. 按键名 ASCII 码升序排序
        ksort($native);

        // 3. 生成待签名字符串
        $arg = "";
        foreach ($native as $key => $val) {
            $arg .= $key . "=" . $val . "&";
        }
        $arg = substr($arg, 0, -1); // 去掉最后一个 &

        // 4. 使用商户私钥进行 RSA 签名
        $sign = $this->rsaSign($arg, $channel_private_key);

        // 5. 添加签名和签名类型
        $native['sign']      = $sign;
        $native['sign_type'] = "RSA";

        // 6. 发起支付请求
        $client = new Client([
            'headers' => ['Content-Type' => 'application/x-www-form-urlencoded'],
        ]);
        $channel_gateway_url = rtrim($channel_gateway, '/') . '/api/pay/create';

        $response = $client->post($channel_gateway_url, [
            'form_params' => $native,
        ]);
        $body = json_decode($response->getBody()->getContents(), true);

        if ($body['code'] != 0) {
            return view('exception', [
                'msg' => $body['msg'],
            ]);
        }

        $url = $body['pay_info'];
        return redirect($url);

    }

    public function paraFilter($para)
    {
        $para_filter = [];
        foreach ($para as $key => $val) {
            if ($key == "sign" || $key == "sign_type" || $val == "") {
                continue;
            } else {
                $para_filter[$key] = $para[$key];
            }

        }
        return $para_filter;
    }

    public function argSort($para)
    {
        ksort($para);
        reset($para);
        return $para;
    }

    public function createLinkstring($para)
    {
        $arg = "";
        foreach ($para as $key => $val) {
            $arg .= $key . "=" . $val . "&";
        }
        //去掉最后一个&字符
        $arg = substr($arg, 0, -1);
        return $arg;
    }

    /**
     * RSA SHA256 验签
     * @param string $data 待验签字符串
     * @param string $sign 签名
     * @param string $publicKey 平台公钥
     * @return bool
     */
    private function rsaVerify($data, $sign, $publicKey)
    {
        try {
            // 格式化公钥
            $publicKey = "-----BEGIN PUBLIC KEY-----\n" .
            wordwrap($publicKey, 64, "\n", true) .
                "\n-----END PUBLIC KEY-----";

            // 签名不需要 URL 解码，直接 Base64 解码
            $signature = base64_decode($sign);

            // 验签
            $result = openssl_verify($data, $signature, $publicKey, OPENSSL_ALGO_SHA256);

            if ($result === 1) {
                return true;
            } elseif ($result === 0) {
                return false;
            } else {
                return false;
            }
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * 服务器回调
     * @param array $request 请求参数
     * @param int $account_id 账号ID
     * @return bool
     */
    public function notify($request, $account_id)
    {
        try {
            // 1. 检查交易状态
            if (! isset($request['trade_status']) || $request['trade_status'] != 'TRADE_SUCCESS') {
                return false;
            }

            // 2. 获取签名信息
            if (! isset($request['sign']) || ! isset($request['sign_type'])) {
                return false;
            }

            $sign      = $request['sign'];
            $sign_type = $request['sign_type'];

            // 3. 获取订单信息
            $out_trade_no = $request['out_trade_no'] ?? '';
            if (empty($out_trade_no)) {
                return false;
            }

            $order = $this->loadOrder($out_trade_no);
            if (! $order) {
                return false;
            }

            // 4. 验证签名
            // 移除签名相关字段
            $verify_data = $request;
            unset($verify_data['sign']);
            unset($verify_data['sign_type']);

            // 过滤并排序
            $para_filter = $this->paraFilter($verify_data);
            $para_sort   = $this->argSort($para_filter);
            $prestr      = $this->createLinkstring($para_sort);

            $isSgin = false;
            if ($sign_type === 'RSA') {
                // RSA 验签 - 使用平台公钥
                $publicKey = $order->channelAccount->params->public_key;
                $isSgin    = $this->rsaVerify($prestr, $sign, $publicKey);
            }

            if (! $isSgin) {
                return false;
            }

            // 5. 验签成功，保存平台订单号并完成订单
            // 存在流水单号时 保留单号
            if (isset($order->transaction_id)) {
                $order->transaction_id = $request['trade_no'];
                $order->save();
            }
            $order->completeOrder($order);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * 退款
     * @param object $order 订单对象
     * @return array
     */
    public function refund($order)
    {
        $this->loadOrder($order->trade_no);
        try {
            // 准备退款参数
            $native = [
                'pid'       => $order->channelAccount->params->pid,
                'trade_no'  => $order->transaction_id, // 使用平台订单号
                'money'     => $order->total_price,
                'timestamp' => time(),
            ];

            // 按键名 ASCII 码升序排序
            ksort($native);

            // 生成待签名字符串
            $arg = "";
            foreach ($native as $key => $val) {
                $arg .= $key . "=" . $val . "&";
            }
            $arg = substr($arg, 0, -1); // 去掉最后一个 &

            // 使用商户私钥进行 RSA 签名
            $sign = $this->rsaSign($arg, $order->channelAccount->params->private_key);

            // 添加签名和签名类型
            $native['sign']      = $sign;
            $native['sign_type'] = "RSA";

            // 退款请求地址
            $channel_gateway = rtrim($order->channelAccount->params->gateway, '/') . '/api/pay/refund';

            $client = new Client([
                'headers' => ['Content-Type' => 'application/x-www-form-urlencoded'],
            ]);

            $response = $client->post($channel_gateway, [
                'form_params' => $native,
            ]);

            $body = json_decode($response->getBody()->getContents(), true);

            if ($body['code'] == 0) {
                // 退款成功
                $order->status = 3;
                $order->save();
                return [
                    'code' => 1,
                    'msg'  => '退款成功',
                    'data' => $body,
                ];
            } else {
                return [
                    'code' => 0,
                    'msg'  => $body['msg'] ?? '退款失败',
                    'data' => $body,
                ];
            }
        } catch (\Exception $e) {
            return [
                'code' => 0,
                'msg'  => $e->getMessage(),
            ];
        }
    }

}
