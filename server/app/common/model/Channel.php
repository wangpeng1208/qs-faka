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

namespace app\common\model;

use think\Exception;

class Channel extends BaseModel
{
  protected $name = 'pay_channel';
  public function orders()
  {
    return $this->hasMany('Order', 'channel_id');
  }
  public function activeOrders()
  {
    return $this->hasMany('Order', 'channel_id')->where('status', 1);
  }

  public function accounts()
  {
    return $this->hasMany('ChannelAccount', 'channel_id');
  }

  public function paytypes()
  {
    return $this->belongsTo('PayType', 'paytype');
  }

  public function getAccountingDateTextAttr($value, $data)
  {
    $type = [1 => 'D+0', 2 => 'D+1', 3 => 'T+0', 4 => 'T+1'];
    return $type[$data['accounting_date']];
  }

  public function getTypeTextAttr($value, $data)
  {
    $type = [0 => '通用', 1 => '手机', 2 => '电脑', 3 => '通用'];
    return $type[$data['is_available']];
  }

  public function channelStatus()
  {
    return $this->hasMany('UserChannel', 'channel_id');
  }

  public function userRates()
  {
    return $this->hasMany('UserRate', 'channel_id');
  }

  private static function updateChannel($id, $data)
  {
    try {
      Channel::findOrFail($id)->update($data);
      return ['status' => true];
    } catch (Exception $e) {
      return ['status' => false, 'msg' => $e->getMessage()];
    }
  }
}
