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

use app\service\home\IndexService;

class Index extends Base
{
    /**
     * 首页统计
     */
    public function indexCount(IndexService $indexService)
    {
        $data = $indexService->indexCount();
        $this->success("获取成功", $data);
    }

    /**
     * 获取网站配置
     */
    public function siteConfig(IndexService $indexService)
    {
        $data = $indexService->siteConfig();
        $this->success("获取成功", $data);
    }

}
