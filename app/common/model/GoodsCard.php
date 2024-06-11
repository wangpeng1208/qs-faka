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

class GoodsCard extends BaseModel
{

  // 大数据下使用软删除 查询的时候带有delete_at = null 需要考虑数据库查询压力
  use SoftDelete;

  protected $deleteTime = 'delete_at';

  public function goods()
  {
    return $this->belongsTo('Goods', 'goods_id');
  }

  public function order_card()
  {
    return $this->belongsTo('OrderCard', 'card_id');
  }

  public function searchCateIdAttr($query, $value, $data)
  {
    $goods_ids = Goods::where('cate_id', $value)->column('id');
    $query->whereIn('goods_id', $goods_ids);
  }

  public function searchGoodsIdAttr($query, $value, $data)
  {
    $query->where('goods_id', $value);
  }

  public function searchStatusAttr($query, $value, $data)
  {
    $query->where('status', $value);
  }

  public function searchTradeNoAttr($query, $value, $data)
  {
    $query->hasWhere('order_card', function ($query) use ($value) {
      $query->where('trade_no', $value);
    });
  }

  // public function searchContactAttr($query, $value, $data)
  // {
  //   $query->hasWhere('order_card', function ($query) use ($value) {
  //     $query->where('contact', $value);
  //   });
  // }

  public function searchNumberAttr($query, $value, $data)
  {
    $query->where('number', $value);
  }
  // sell_time 时间区间
  public function searchDateRangeAttr($query, $value, $data)
  {
    if (empty($value) || empty($value[0]) || empty($value[1])) {
      return;
    }
    $query->whereBetweenTime('sell_time', strtotime($value[0]), strtotime($value[1]));
  }

  protected function getStatusTextAttr($value, $data)
  {
    $status = [
      1 => '未售出',
      2 => '已售出',
    ];
    return $status[$data['status']];
  }

}
