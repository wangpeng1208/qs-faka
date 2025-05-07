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
use support\Log;

/**
 * @note 支付宝网页支付
 * @var $trade_no string 外部单号
 * @var  $order object 订单
 * @var $config array 配置
 * @field  params 支付宝app_id:app_id|应用秘钥:app_secret_cert|应用公钥证书:app_public_cert_path|支付宝公钥证书:alipay_public_cert_path|支付宝根证书:alipay_root_cert_path
 */
class AlipayWeb extends PayService implements CollectionInterface
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
    $this->config['alipay']['default'] = [
      // 必填-支付宝分配的 app_id
      'app_id'                  => $this->order->channelAccount->params->app_id,
      // 必填-应用私钥 字符串或路径
      // 在 https://open.alipay.com/develop/manage 《应用详情->开发设置->接口加签方式》中设置
      // 'app_secret_cert' => $order->channelAccount->params->merchant_private_key,
      'app_secret_cert'         => $this->order->channelAccount->params->app_secret_cert,
      // 必填-应用公钥证书 路径
      // 设置应用私钥后，即可下载得到以下3个证书
      'app_public_cert_path'    => $this->order->channelAccount->params->app_public_cert_path,
      // 必填-支付宝公钥证书 路径
      'alipay_public_cert_path' => $this->order->channelAccount->params->alipay_public_cert_path,
      // 必填-支付宝根证书 路径
      'alipay_root_cert_path'   => $this->order->channelAccount->params->alipay_root_cert_path,
      'return_url'              => conf('site_domain') . '/callback',
      'notify_url'              => conf('site_domain') . '/home/pay/notify',
      // 选填-第三方应用授权token
      'app_auth_token'          => '',
      // 选填-服务商模式下的服务商 id，当 mode 为 Pay::MODE_SERVICE 时使用该参数
      'service_provider_id'     => '',
      // 选填-默认为正常模式。可选为： MODE_NORMAL, MODE_SANDBOX, MODE_SERVICE
      'mode'                    => Pay::MODE_NORMAL,
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

      $data = [
        'out_trade_no' => $trade_no,
        'total_amount' => $totalAmount, //单位 元
        'subject'      => $subject . '如有售后请返回购买页咨询', //订单标题
      ];
      return Pay::alipay()->web($data)->getBody()->getContents();
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
      Pay::config(array_merge($this->config, ['_force' => true]));
      $res = Pay::alipay()->refund([
        'out_trade_no'  => $order->trade_no,
        'refund_amount' => $order->total_price
      ]);
      if ($res['code'] == 10000) {
        $order->status = 3;
        $order->save();
        $res['code'] = 1;
      }
      // 记录退款日志
      config('app.debug') && Log::channel('pay')->info("【API退款】支付宝用户名：$res[buyer_logon_id]，支付宝用户ID：$res[buyer_user_id]，退款金额：$res[refund_fee]，退款时间：$res[gmt_refund_pay]，订单号：$res[out_trade_no]，交易号：$res[trade_no]，退款状态：$res[fund_change]");
      return $res;
    } catch (\Exception $e) {
      $res['code'] = 0;
      $res['msg']  = $e->getMessage();
      return $res;
    }
  }

  /**
   * 支付宝回调 v3
   */
  public function notify($request, $account_id)
  {
    $this->init($request['out_trade_no']);
    Pay::config(array_merge($this->config, ['_force' => true]));
    try {
      $result = Pay::alipay()->callback($request);
      if ($result['trade_status'] == 'TRADE_SUCCESS') {
        // 在订单模型中添加一个完成订单方法
        $this->order->completeOrder($this->order);
        config('app.debug') && Log::channel('pay')->info($result['out_trade_no'] . '支付成功');
      } else {
        $result = json_encode($result);
        config('app.debug') && Log::channel('pay')->error($result);
      }
    } catch (\Exception $e) {
      config('app.debug') && Log::channel('pay')->error($request['out_trade_no'] . '支付失败，错误信息：' . $e->getMessage());
    }
    return true;
  }
}
