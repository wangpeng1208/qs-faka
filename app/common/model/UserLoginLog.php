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
            $query->where('id', $data['keyword']);
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
