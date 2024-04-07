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

class UserMoneyLog extends BaseModel
{
    protected $autoWriteTimestamp = true;
    protected $createTime = 'create_at';
    public function user()
    {
        return $this->belongsTo('User', 'user_id');
    }

    public function searchUserIdAttr($query, $value, $data)
    {
        $query->where('user_id', $value);
    }

    public function searchUsernameAttr($query, $value, $data)
    {
        $query->hasWhere('user', function ($query) use ($value) {
            $query->where('username', 'like', '%' . $value . '%');
        });
    }

    public function searchBusinessTypeAttr($query, $value, $data)
    {
        $query->where('business_type', $value);
    }

    public function searchDateRangeAttr($query, $value, $data)
    {
        if (empty ($value) || empty (trim($value[0])) || empty (trim($value[1]))) {
            return;
        } else {
            $query->whereBetweenTime('create_at', $value[0], $value[1]);
        }
    }
}
