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

use think\Model;


class AdminLog extends Model
{

  protected $createTime = 'create_at';
  protected $updateTime = false;

  // username 
  public function searchUsernameAttr($query, $value, $data)
  {
    $query->where('username', '=', $value);
  }

  // ip
  public function searchIpAttr($query, $value, $data)
  {
    $query->where('ip', '=', $value);
  }

  // action
  public function searchActionAttr($query, $value, $data)
  {
    $query->where('action', '=', $value);
  }

  // date_range
  public function searchDateRangeAttr($query, $value, $data)
  {
    if (empty(trim($value[0])) || empty(trim($value[1]))) {
      return;
    } else {
      $query->whereBetweenTime('create_at', strtotime($value[0]), strtotime($value[1]));
    }
  }
}