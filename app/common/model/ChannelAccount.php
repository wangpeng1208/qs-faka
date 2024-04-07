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

namespace app\common\model;

class ChannelAccount extends BaseModel
{
  public function channel()
  {
    return $this->belongsTo('Channel');
  }

  protected function setParamsAttr($value)
  {
    return json_encode($value);
  }

  protected function getParamsAttr($value)
  {
    return json_decode($value);
  }

  public function orders()
  {
    return $this->hasMany('Order', 'channel_account_id');
  }
}
