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

use app\service\common\PayService;
use app\home\collection\interfaces\CollectionInterface;

/**
 * @note 易支付网页支付
 * @var $trade_no string 外部单号
 * @var $order object 订单
 * @var $config array
 * @field params  网关:gateway|pid:pid|key:key|支付类型:type
 */
class Yipay extends PayService implements CollectionInterface
{
    public function pay($trade_no, $subject, $totalAmount)
    {
        $order = $this->loadOrder($trade_no);

        $channel_pid     = $order->channelAccount->params->pid;
        $channel_key     = $order->channelAccount->params->key;
        $channel_type    = $order->channelAccount->params->type;
        $channel_gateway = $order->channelAccount->params->gateway;

        $callbackurl = conf('site_domain') . '/callback';
        $notifyurl   = conf('site_domain') . '/home/pay/notify';

        $native = [
            "pid"          => $channel_pid,
            "type"         => $channel_type,
            "out_trade_no" => $trade_no,
            "notify_url"   => $notifyurl,
            "return_url"   => $callbackurl,
            "name"         => $subject,
            "money"        => $totalAmount,
            "sitename"     => "发卡平台",
        ];
        ksort($native);
        $arg = "";
        foreach ($native as $key => $val) {
            $arg .= $key . "=" . ($val) . "&";
        }
        $arg                 = substr($arg, 0, -1);
        $sign                = md5($arg . $channel_key);
        $native["sign"]      = $sign;
        $native['sign_type'] = "MD5";

        $html = '<form  name="form1" class="form-inline" method="post" action="' . $channel_gateway . '">';
        foreach ($native as $key => $val) {
            $html .= '<input type="hidden" name="' . $key . '" value="' . $val . '">';
        }
        $html .= '</form>';
        $html .= '<script type="text/javascript">document.form1.submit()</script>';
        return $html;
    }

    function paraFilter($para)
    {
        $para_filter = [];
        foreach ($para as $key => $val) {
            if ($key == "sign" || $key == "sign_type" || $val == "")
                continue;
            else
                $para_filter[$key] = $para[$key];
        }
        return $para_filter;
    }

    function argSort($para)
    {
        ksort($para);
        reset($para);
        return $para;
    }

    function createLinkstring($para)
    {
        $arg = "";
        foreach ($para as $key => $val) {
            $arg .= $key . "=" . $val . "&";
        }
        //去掉最后一个&字符
        $arg = substr($arg, 0, -1);
        return $arg;
    }

    function md5Verify($prestr, $sign, $key)
    {
        $prestr = $prestr . $key;
        $mysgin = md5($prestr);
        if ($mysgin == $sign) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 服务器回调
     */
    public function notify($request, $account_id)
    {
        $out_trade_no = $request['out_trade_no'];
        $order        = $this->loadOrder($out_trade_no);
        $para_filter = $this->paraFilter($request);
        $para_sort   = $this->argSort($para_filter);
        $prestr      = $this->createLinkstring($para_sort);
        $isSgin      = false;
        $isSgin      = $this->md5Verify($prestr, $request['sign'], $order->channelAccount->params->key);
        if ($isSgin) {
            $order->transaction_id = $request['trade_no'];
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
