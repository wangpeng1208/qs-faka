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
// +----------------------------------------------------------------------

namespace app\home\collection;

use app\service\common\PayService;
use app\home\collection\interfaces\CollectionInterface;
use GuzzleHttp\Client;

/**
 * @note 两头羊支付
 * @var $trade_no string 外部单号
 * @var $order object 订单
 * @var $config array
 * @field  params 网关:gateway|appid:pid|秘钥:key|支付类型:type|返回类型:device
 */
class Liangtouyang extends PayService implements CollectionInterface
{
    public function pay($trade_no, $subject, $totalAmount)
    {
        $order           = $this->loadOrder($trade_no);
        $channel_pid     = $order->channelAccount->params->pid;
        $channel_key     = $order->channelAccount->params->key;
        $channel_type    = $order->channelAccount->params->type;
        $channel_gateway = $order->channelAccount->params->gateway;
        $device          = $order->channelAccount->params->device;

        // $callbackurl = conf('site_domain') . '/callback';

        $native         = [
            "appid"        => $channel_pid,
            "type"         => $channel_type,
            "out_trade_no" => $trade_no,
            "money"        => number_format($totalAmount, 2, '.', ','),
            "notify_url"   => conf('site_domain') . '/home/pay/notify',
            "device"       => $device,
        ];
        $sign           = $this->generateSign($native, $channel_key);
        $native["sign"] = $sign;

        $client   = new Client([
            'headers' => ['Content-Type' => 'application/json']
        ]);
        $response = $client->post($channel_gateway, ['body' => json_encode($native)]);
        $body     = json_decode($response->getBody()->getContents(), true);

        if ($body['code'] != 20000) {
            return view('exception', [
                'msg' => $body['msg']
            ]);
        }
        if ($device == 1) {
            // 二维码扫码地址
            return $body['data']['payurl'];
        } else {
            return redirect($body['data']['payurl']);
        }
    }

    /**
     * 生成签名
     *
     * @param array $params 参数数组
     * @param string $secretKey 密钥
     * @return string 签名
     */
    function generateSign(array $params, $secretKey): string
    {
        // 检查是否存在 sign 参数，并移除
        if (isset($params['sign'])) {
            unset($params['sign']);
        }

        ksort($params);

        // 将参数拼接成字符串
        $paramString = '';
        foreach ($params as $key => $value) {
            $paramString .= $key . '=' . $value . '&';
        }

        // 去除末尾的&
        $paramString = rtrim($paramString, '&');

        // 在拼接的字符串后面加上密钥
        $paramString .= $secretKey;

        // 计算MD5签名
        $signature = md5($paramString);

        return $signature;
    }

    /**
     * 验证回调签名是否正确
     * @param array $data 回调数据数组
     * @param string $secretKey 密钥
     * @return bool 验证结果
     */
    function verifyCallbackSignature($data, $secretKey): bool
    {
        // 从回调数据中取出签名
        $signature = $data['sign'];
        // 在回调数据中移除签名字段
        unset($data['sign']);
        // 将参数按照键名进行字典序排序
        ksort($data);
        // 将参数拼接成字符串
        $paramString = '';
        foreach ($data as $key => $value) {
            $paramString .= $key . '=' . $value . '&';
        }
        // 去除末尾的&
        $paramString = rtrim($paramString, '&');
        // 在拼接的字符串后面加上密钥
        $paramString .= $secretKey;
        // 计算MD5签名
        $computedSignature = md5($paramString);
        // 验证签名是否正确
        return $signature === $computedSignature;
    }


    /**
     * 服务器回调
     */
    public function notify($request, $account_id)
    {
        $out_trade_no = $request['out_trade_no'];
        $order        = $this->loadOrder($out_trade_no);

        $isSgin = $this->verifyCallbackSignature($request, $order->channelAccount->params->key);

        if ($isSgin) {
            $order->transaction_id = $request['trade_no'];
            // 保存外部单号
            $order->save();
            // 完成订单
            $order->completeOrder($order);
            return true;
        }
        return false;
    }

    public function refund($order)
    {
        throw new \Exception('不支持退款');
    }

}
