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

namespace app\home\controller;

use app\service\home\ArticleService;

class Article extends Base
{

    public function type(ArticleService $articleService)
    {
        $data = $articleService->articleType();
        $this->success('获取成功', $data);
    }

    /**
     * 文章列表
     * @return void
     */
    public function list(ArticleService $articleService)
    {
        $data = $articleService->articleList();
        $this->success('获取成功', $data);
    }

    /**
     * 文章详情
     * @return void
     */
    public function detail(ArticleService $articleService)
    {
        $data = $articleService->articleDetail();
        $this->success('获取成功', $data);
    }
}
