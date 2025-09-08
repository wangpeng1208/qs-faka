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

class UserLoginLog extends Model
{
    public function user()
    {
        return $this->belongsTo('User', 'user_id');
    }

    // 搜索器
    public function searchFieldAttr($query, $value, $data)
    {
        if (empty($data['keyword'])) {
            return;
        }
        if ($value == 'username') {
            // 查user模型里的username字段
            $query->hasWhere('user', ['username' => $data['keyword']]);
        }

        if ($value == 'id') {
            $query->where('user_id', $data['keyword']);
        }
        if ($value == 'mobile') {
            // 查user模型里的mobile字段
            $query->hasWhere('user', ['mobile' => $data['keyword']]);
        }

        if ($value == 'qq') {
            // 查user模型里的qq字段
            $query->hasWhere('user', ['qq' => $data['keyword']]);
        }
    }

    public function searchKeywordAttr($query, $value, $data)
    {
    }

    public function searchIpAttr($query, $value)
    {
        $query->where('ip', $value);
    }

    public function searchDateRangeAttr($query, $value, $data)
    {
        if (empty($value) || empty($value[0]) || empty($value[1])) {
            return;
        }
        $query->whereBetweenTime('create_at', strtotime($value[0]), strtotime($value[1]));
    }

    public function getCreateAtAttr($value)
    {
        return date('Y-m-d H:i:s', $value);
    }
}
