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


class ShopList extends BaseModel
{
  protected $json = ['shop_contact'];

  public function user()
  {
    return $this->belongsTo('User', 'user_id');
  }

  public function categorys()
  {
    return $this->hasMany('GoodsCategory', 'user_id', 'user_id');
  }

  public function getShopNoticeAttr($value)
  {
    return paramFilter($value);
  }

}
