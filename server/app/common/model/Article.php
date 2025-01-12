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


class Article extends BaseModel
{
    // protected $autoWriteTimestamp = true;
    // protected $createTime = 'create_at';
    // protected $updateTime = "update_at";

    public function category()
    {
        return $this->belongsTo('ArticleCategory', 'cate_id');
    }

    public function searchTitleAttr($query, $value, $data)
    {
        $query->where('title', 'like', '%' . $value . '%');
    }

    public function searchStatusAttr($query, $value, $data)
    {
        $query->where('status', $value);
    }

    public function searchDateRangeAttr($query, $value, $data)
    {
        if (empty ($value[0]) || empty ($value[1])) {
            return;
        }
        $query->whereBetweenTime('create_at', strtotime($value[0]), strtotime($value[1]));
    }

    public function setCreateAtAttr($value)
    {
        return $value / 1000;
    }

    public function setUpdateAtAttr($value)
    {
        return $value / 1000;
    }

    public function getContentAttr($value)
    {
        return paramFilter(htmlspecialchars_decode($value));
    }

  

    public static function onAfterRead($article)
    {
        $article->inc('views')->save();
    }
}
