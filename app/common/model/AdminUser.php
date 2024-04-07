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

class AdminUser extends BaseModel
{
    // 自动时间
    protected $autoWriteTimestamp = true;
    // created_at
    protected $createTime = 'created_at';
    public function role()
    {
        return $this->hasManyThrough('AdminRoles', 'AdminRole', 'admin_id', 'id', 'id', 'role_id');
    }
    // roles relation
    public function roles()
    {
        return $this->hasMany('AdminRole', 'admin_id', 'id');
    }

    // search username
    public function searchUsernameAttr($query, $value)
    {
        if ($value) {
            $query->where('username', 'like', "%{$value}%");
        }
    }
    // search nickname
    public function searchNicknameAttr($query, $value)
    {
        if ($value) {
            $query->where('nickname', 'like', "%{$value}%");
        }
    }

    // search status
    public function searchStatusAttr($query, $value)
    {
        if ($value) {
            $query->where('status', '=', $value);
        }
    }

    // search id
    public function searchIdAttr($query, $value)
    {
        if ($value) {
            $query->where('id', '=', $value);
        }
    }

    public function getAvatarAttr($value, $data)
    {
        if(empty($value)){
            return conf('site_domain') . '/static/common/images/noavatar.svg';
        }
        return  $value;
    }


}
