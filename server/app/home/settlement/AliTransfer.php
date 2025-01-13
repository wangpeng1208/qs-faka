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

namespace app\home\settlement;

use Yansongda\Pay\Pay;
use app\service\common\PayService;
use app\home\settlement\interfaces\SettlementInterface;

/**
 * @note 支付宝转账
 * @var $trade_no string 外部单号
 * @var $order object 订单
 * @var $config array 配置
 */
class AliTransfer implements SettlementInterface
{
  private $trade_no = '';
  private $order;
  private $config = [];

  private function init($trade_no)
  {
    $this->trade_no = $trade_no;
    $this->order    = (new PayService())->loadOrder($trade_no);
    $this->config();
  }
  private function config()
  {
    if ($this->order === false) {
      throw new \Exception('订单不存在');
    }
    // 检测是否有支付宝配置 应用私钥是否存在
    if (empty($this->order->channelAccount->params->app_secret_cert)) {
      throw new \Exception('支付宝应用私钥不存在,无法对商户进行结算,请检查您的配置');
    }
    // 检测证书是否存在
    if (!file_exists($this->order->channelAccount->params->app_public_cert_path) || !file_exists($this->order->channelAccount->params->alipay_public_cert_path) || !file_exists($this->order->channelAccount->params->alipay_root_cert_path)) {
      throw new \Exception('支付宝证书不存在,无法对商户进行结算,请检查您的配置');
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
      'notify_url'              => conf('site_domain') . '/pay/alipay/notify',
      // 选填-第三方应用授权token
      'app_auth_token'          => '',
      // 选填-服务商模式下的服务商 id，当 mode 为 Pay::MODE_SERVICE 时使用该参数
      'service_provider_id'     => '',
      // 选填-默认为正常模式。可选为： MODE_NORMAL, MODE_SANDBOX, MODE_SERVICE
      'mode'                    => Pay::MODE_NORMAL,
    ];
  }

  /**
   * ali转账
   */
  public function pay($cash, $user)
  {
    if ($user->collect->type != 1) {
      return [
        'code' => 0,
        'msg'  => '用户结算信息不是支付宝'
      ];
    }
    $this->init($cash->trade_no);
    try {
      Pay::config(array_merge($this->config, ['_force' => true]));
      $data = [
        'out_biz_no'   => $cash->trade_no,
        'trans_amount' => $cash->actual_money,
        'product_code' => 'TRANS_ACCOUNT_NO_PWD',
        'biz_scene'    => 'DIRECT_TRANSFER',
        'payee_info'   => [
          'identity'      => $cash->bank_card,
          'identity_type' => 'ALIPAY_LOGON_ID',
          'name'          => $cash->realname,
        ]
      ];

      $result = Pay::alipay()->transfer($data);

      if ($result['code'] == 10000) {
        $cash->status       = 1;
        $cash->complete_at  = time();
        $cash->save();
        return [
          'code' => 1,
          'msg'  => '支付成功'
        ];
      }

    } catch (\Exception $e) {
      return [
        'code' => 0,
        'msg'  => $e->getMessage()
      ];
    }
  }

}
