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

class OrderComplaint extends BaseModel
{
    public function user()
    {
        return $this->belongsTo('User', 'user_id');
    }

    public function parentUser()
    {
        return $this->belongsTo('User', 'proxy_parent_user_id');
    }
    // 不得使用order 避免被识别成排序
    public function orders()
    {
        return $this->belongsTo('Order', 'trade_no', 'trade_no');
    }

    public function messages()
    {
        return $this->hasMany('OrderComplaintMessage', 'trade_no', 'trade_no')->order('create_at', 'desc');
    }

    // 搜索器
    public function searchIdAttr($query, $value, $data)
    {
        $query->where('id', $value);
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

    public function searchTradeNoAttr($query, $value, $data)
    {
        $query->where('trade_no', $value);
    }

    public function searchStatusAttr($query, $value, $data)
    {
        $query->where('status', $value);
    }

    public function searchAdminReadAttr($query, $value, $data)
    {
        $query->where('admin_read', $value);
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

    public function getCreateAtAttr($value, $data)
    {
        return date('Y-m-d H:i:s', $value);
    }

    public function getExpireAtAttr($value, $data)
    {
        return date('Y-m-d H:i:s', $value);
    }

    // 创建完成后 发送通知
    public static function onAfterInsert($complaint)
    {
        $notify = new \app\service\notify\ComplaintService();
        $notify->notify($complaint->user, $complaint->trade_no);
    }
}
