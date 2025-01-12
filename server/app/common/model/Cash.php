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

class Cash extends BaseModel
{
    protected $name = 'user_cash';
    
    public function user()
    {
        return $this->belongsTo('User', 'user_id');
    }

    public function channel()
	{
		return $this->belongsTo("Channel", "channel_id");
	}

    public function channelAccount()
	{
		return $this->belongsTo("ChannelAccount", "channel_account_id");
	}

    public function searchStatusAttr($query, $value, $data)
    {
        $query->where('status', $value);
    }

    public function searchDateTypeAttr($query, $value, $data)
    {
        if(empty($value)){
            return;
        }
        //    month 本月 week 本周 day 今日 yesterday 昨日
        switch ($value) {
            case 'month':
                $query->whereTime('create_at', 'month');
                break;
            case 'week':
                $query->whereTime('create_at', 'week');
                break;
            case 'day':
                $query->whereTime('create_at', 'today');
                break;
            case 'yesterday':
                $query->whereTime('create_at', 'yesterday');
                break;
        }
    }

    public function searchUsernameAttr($query, $value, $data)
    {
        $query->hasWhere('user', function ($query) use ($value) {
            $query->where('username', 'like', '%' . $value . '%');
        });
    }

    public function searchTypeAttr($query, $value, $data)
    {
        $query->where('type', $value);
    }

    public function searchDateRangeAttr($query, $value, $data)
    {
        if (empty(trim($value[0])) || empty(trim($value[1]))) {
            return;
        } else {
            $query->whereBetweenTime('create_at', $value[0], $value[1]);
        }
    }

}
