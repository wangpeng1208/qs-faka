<?php

// +----------------------------------------------------------------------
// | 骑士发卡 [ 平顶山若拉网络科技有限公司，并保留所有权利 ]
// +----------------------------------------------------------------------
// | Copyright (c) 2022-2025 https://www.qqss.net All rights reserved.
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
     * 获取短链接
     */
    public function getShortLink($user_id, $relation_id, $relation_type)
    {
        $res       = LinkModel::where(["user_id" => $user_id, "relation_type" => $relation_type, "relation_id" => $relation_id])->find();
        $error_msg = '';
        // 链接关系不存在则创建
        if (!$res) {
            $token = substr(md5(uniqid(md5(microtime(true)), true)), 0, 8);
            $url   = conf("site_shop_domain") . '/' . conf('shop_link_str') . '/' . $token;
            try {
                $short_url = (new DwzService())->create($url);
            } catch (\Exception $e) {
                $short_url = '';
                $error_msg = $e->getMessage();
            }

            $res = LinkModel::create([
                "user_id"       => $user_id,
                "relation_type" => $relation_type,
                "relation_id"   => $relation_id,
                "token"         => $token,
                "short_url"     => $short_url,
                "status"        => 1,
                "create_at"     => time()
            ]);
        } else {
            if (empty($res->short_url)) {
                $url = conf("site_shop_domain") . '/' . conf('shop_link_str') . '/' . $res->token;
                try {
                    $short_url = (new DwzService())->create($url);
                } catch (\Exception $e) {
                    $short_url = '';
                    $error_msg = $e->getMessage();
                }
                $res->short_url = $short_url;
                $res->save();
            }
        }
        $link = $res->short_url ?: $error_msg;

        return $link;
    }

    /**
     * 重置短链接
     */
    public function resetShortLink($user_id, $relation_id, $relation_type)
    {
        $link = LinkModel::where(["user_id" => $user_id, "relation_type" => $relation_type, "relation_id" => $relation_id])->field('token')->find();
        if ($link) {
            $url             = conf("site_shop_domain") . '/' . conf('shop_link_str') . '/' . $link->token;
            $short_url       = (new DwzService())->create($url);
            $link->short_url = $short_url;
            $link->save();
            return $short_url;
        }
        throw new \Exception('Link not found');
    }
}
