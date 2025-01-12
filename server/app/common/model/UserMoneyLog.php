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
