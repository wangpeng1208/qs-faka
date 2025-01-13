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

use app\service\shortlink\ShortLinkService;

class GoodsCategory extends BaseModel
{

  public function user()
  {
    return $this->belongsTo('User', 'user_id');
  }

  public function goods()
  {
    return $this->hasMany('Goods', 'cate_id');
  }

  public function coupons()
  {
    return $this->hasMany('GoodsCoupon', 'cate_id');
  }

  // 搜索器
  public function searchNameAttr($query, $value, $data)
  {
    $query->where('name', 'like', '%' . $value . '%');
  }
  // status
  public function searchStatusAttr($query, $value, $data)
  {
    if ($value != '') {
      $query->where('status', $value);
    }
  }

  public function getCountAttr()
  {
    $goods = $this->goods()->select();
    $i = 0;
    foreach (collect($goods) as $good) {
      if ($good->status == 0) {
        continue;
      }
      $i++;
    }
    return $i;
  }

  /**
   * 链接
   */
  public function link()
  {
    return $this->morphOne('Link', 'relation', 'goods_category')->order('id desc');
  }

  /**
   * 获取店铺链接
   */
  public function getLinksAttr()
  {
    return conf("site_shop_domain") . "/links/" . $this->link()->value('token');
  }

  /**
   * 获取短链接
   */
  public function getShortLinkAttr($value, $data)
  {
    return (new ShortLinkService())->getShortLink($data["user_id"], $data["id"], "goods_category");
  }

  /**
   * 重置短连接
   */
  public function getResetShortLinkAttr($value, $data)
  {
    return (new ShortLinkService())->resetShortLink($data["user_id"], $data["id"], "goods_category");
  }

  /**
   * 获取链接状态
   */
  public function getLinkStatusAttr()
  {
    return $this->link()->value('status');
  }
}
