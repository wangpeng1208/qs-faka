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

class Cash extends BaseModel
{
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
