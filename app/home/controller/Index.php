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
