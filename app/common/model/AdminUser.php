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
