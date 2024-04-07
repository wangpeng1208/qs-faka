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
