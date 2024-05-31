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
        $article->inc('views')->update();
    }
}
