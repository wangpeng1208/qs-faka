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
      if ($good->status == 0 || ($good->is_proxy == 1 && (!$good->pgoods || $good->pgoods->status == 0))) {
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
