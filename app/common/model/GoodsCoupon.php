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

use think\model\concern\SoftDelete;

class GoodsCoupon extends BaseModel
{
  use SoftDelete;
  protected $deleteTime = 'delete_at';

  public function user()
	{
		return $this->belongsTo("User", "user_id");
	}
  public function category()
  {
    return $this->belongsTo('GoodsCategory', 'cate_id');
  }

  public function searchCateIdAttr($query, $value, $data)
  {
    $query->where('cate_id', $value);
  }

  public function searchStatusAttr($query, $value, $data)
  {
    $query->where('status', $value);
  }

  protected function getStatusTextAttr($value, $data)
  {
    if ($data['status'] == 1 && $data['expire_at'] <= time()) {
      return '已过期';
    }
    $status = [
      0 => '使用中',
      1 => '未使用',
      2 => '已使用',
    ];
    return $status[$data['status']];
  }

  // 获取有效期
  protected function getExpireDayAttr($value, $data)
  {
    if ($data['status'] == 1) {
      if ($data['expire_at'] <= time()) {
        return '已过期';
      } else {
        return date('Y-m-d H:i:s', $data['expire_at']);
      }
    }
    if ($data['status'] == 2) {
      return '已使用';
    }
    if ($data['status'] == 0) {
      return '使用中';
    }
  }
}
