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

namespace app\service\shortlink;


use app\common\model\Link as LinkModel;
use app\service\shortlink\DwzService;

class ShortLinkService
{

    /**
     * 创建短链接
     * @param $user_id 用户ID
     * @param $relation_id 关联ID
     * @param $relation_type 关联类型
     * @return string
     */
    private function create($user_id, $relation_id, $relation_type)
    {
        $token     = substr(md5(uniqid(md5(microtime(true)), true)), 0, 8);
        $url       = conf("site_shop_domain") . "/links/" . $token;
        $short_url = (new DwzService())->create($url);
        record_file_log('trest', $relation_type);
        LinkModel::create([
            "user_id"       => $user_id,
            "relation_type" => $relation_type,
            "relation_id"   => $relation_id,
            "token"         => $token,
            "short_url"     => $short_url,
            "status"        => 1,
            "create_at"     => time()
        ]);

        return $short_url;
    }

    /**
     * 获取短链接
     */
    public function getShortLink($user_id, $relation_id, $relation_type)
    {
        $link = LinkModel::where(["user_id" => $user_id, "relation_type" => $relation_type, "relation_id" => $relation_id])->find();
        if (empty($link)) {
            $link = $this->create($user_id, $relation_id, $relation_type);
        }
        return $link;
    }

    /**
     * 重置短链接
     */
    public function resetShortLink($user_id, $relation_id, $relation_type)
    {
        $link = LinkModel::where(["user_id" => $user_id, "relation_type" => $relation_type, "relation_id" => $relation_id])->field('token')->find();
        if ($link) {
            $url             = conf("site_shop_domain") . "/links/" . $link->token;
            $short_url       = (new DwzService())->create($url, $relation_type);
            $link->short_url = $short_url;
            $link->save();
            return $short_url;
        }
        throw new \Exception('Link not found');
    }
}
