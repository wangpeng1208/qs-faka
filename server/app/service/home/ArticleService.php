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

namespace app\service\home;

use app\common\model\{Article as ArticleModel, ArticleCategory as ArticleCategoryModel};

class ArticleService
{
    public function articleType()
    {
        $category = ArticleCategoryModel::where(['status' => 1, 'type' => 1])->column('name,alias');
        return array_map(function ($value) {
            return [
                'alias' => $value['alias'],
                'label' => $value['name'],
            ];
        }, $category);
    }

    public function articleList()
    {
        $alias    = inputs('alias');
        $limit    = inputs('limit/d', 10);
        $category = ArticleCategoryModel::where(['alias' => $alias, 'status' => 1])->find();
        $list     = $category->articles()->where('status', 1)->order('top desc, id desc')->paginate($limit);
        return [
            'category' => $category,
            'list'     => $list->items(),
        ];
    }

    public function articleDetail()
    {
        $id     = inputs('id/d', 0);
        $detail = ArticleModel::findOrEmpty($id);
        if ($detail->isEmpty()) {
            throw new \Exception('文章不存在!');
        }
        // 文字阅读量 +1
        $detail->inc('views', 1)->save();
        return [
            'category' => $detail->category,
            'detail'   => $detail
        ];
    }
}