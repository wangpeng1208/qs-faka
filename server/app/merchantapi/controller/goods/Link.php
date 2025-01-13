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

namespace app\merchantapi\controller\goods;

use app\merchantapi\controller\Base;

/**
 * 商品类目主题及链接管理
 */
class Link extends Base
{

    /**
     * 商品主题获取
     */
    public function getTheme()
    {
        $id   = inputs('id/d', 0);
        $type = inputs("type/s", "");
        switch ($type) {
            case "category":
                $categorys = $this->user->categorys()->find($id) ?: $this->error("分类不存在！");
                $pc_template = $categorys->theme ?: 'default';
                $mobile_template = $categorys->mobile_theme ?: 'default';
                break;
            case "good":
                $id = inputs("id/d", 0);
                $goods = $this->user->goods()->find($id) ?: $this->error("商品不存在！");
                $pc_template = $goods->theme ?: 'default';
                $mobile_template = $goods->mobile_theme ?: 'default';
                break;
            default:
                $this->error("参数错误！");
        }
        $data = ['pc_template' => $pc_template, 'mobile_template' => $mobile_template];
        $this->success('获取成功', $data);
    }

    /**
     * 商品主题修改
     */
    public function saveTheme()
    {
        $id    = inputs('id/d', 0);
        $type  = inputs("type/s", "");
        $field = inputs('field', '');
        $value = inputs('value', '');
        switch ($type) {
            case "category":
                $categorys = $this->user->categorys()->find($id) ?: $this->error("分类不存在！");
                $categorys->$field = $value;
                $categorys->allowField(['theme', 'mobile_theme'])->save();
                break;
            case "good":
                $id = inputs("id/d", 0);
                $goods = $this->user->goods()->find($id) ?: $this->error("商品不存在！");
                $goods->$field = $value;
                $goods->allowField(['theme', 'mobile_theme'])->save();
                break;
            default:
                $this->error("参数错误！");
        }
        $this->success('修改成功');
    }


    /**
     * 商品分类链接
     */
    public function category()
    {
        $id  = inputs('id/d', 0);
        $res = $this->user->categorys()->find($id) ?: $this->error("不存在该分类！");
        $this->success('获取成功', [
            'id'         => $id,
            'link'       => $res->links,
            'status'     => $res->linkStatus ?? 1,
            'short_link' => $res->shortLink,
        ]);
    }

    /**
     * 商品链接
     */
    public function good()
    {
        $id   = inputs("id/d", 0);
        $good = $this->user->goods()->find($id) ?: $this->error("不存在该商品！");
        $this->success('获取成功', [
            'id'         => $good->id,
            'short_link' => $good->short_link,
            'link'       => $good->links,
            'status'     => $good->link_status,
        ]);
    }

    /**
     * 重置链接
     * input type : shop category good
     * input target : 0 重置 1 重新生成
     */
    public function reset()
    {
        $type   = inputs("type/s", "");
        $status = inputs("status/d", 1);
        switch ($type) {
            case "category":
                $id = inputs("id/d", 0);
                $categorys = $this->user->categorys()->where("id", $id)->find() ?: $this->error("分类不存在！");
                if ($status == 0) {
                    $categorys->resetShortLink;
                } else {
                    $categorys->link()->delete();
                    $categorys->shortLink;
                }
                break;
            case "good":
                $id = inputs("id/d", 0);
                $goods = $this->user->goods()->where("id", $id)->find() ?: $this->error("商品不存在！");
                if ($status == 0) {
                    $goods->resetShortLink;
                } else {
                    $goods->link()->delete();
                    $goods->shortLink;
                }
                break;
            default:
                $this->error("参数错误！");
        }
        $this->success("链接重置成功！");
    }

    /**
     * 关闭链接
     * input type : shop category good
     * input status  : 0 关闭 1 开启
     * input id  : 分类或商品id
     * @throws \think\Exception
     */
    public function close()
    {
        $type        = inputs("type/s", "");
        $status      = inputs("status/d", 1);
        $status_text = $status == 1 ? "开启" : "关闭";
        switch ($type) {
            case "category":
                $id = inputs("id/d", 0);
                $res = $this->user->categorys()->where("id", $id)->find();
                if ($res) {
                    $res->link()->update(["status" => $status]);
                }
                break;
            case "good":
                $id = inputs("id/d", 0);
                $res = $this->user->goods()->where("id", $id)->find();
                if ($res) {
                    $res->link()->update(["status" => $status]);
                } else {
                    return $this->error("该链接" . $status_text . "失败");
                }
                break;
            default:
                $this->error("参数错误！");
        }
        $this->success("该链接已" . $status_text . "成功！");
    }
}
