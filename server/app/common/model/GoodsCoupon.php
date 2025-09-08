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
}
