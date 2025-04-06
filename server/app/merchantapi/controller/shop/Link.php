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

namespace app\merchantapi\controller\shop;

use app\merchantapi\controller\Base;

class Link extends Base
{
    /**
     * 获取店铺链接
     * @auth false
     */
    public function index()
    {
        $this->success('获取成功', [
            'shortLink'   => $this->user->shortLink,
            'link_status' => $this->user->link_status,
            'link'        => $this->user->links,
        ]);
    }

    /**
     * @notes 重置店铺链接
     * @auth false
     */
    public function reset()
    {
        $status = inputs("status/d", 1);
        if ($status == 0) {
            $this->user->resetShortLink;
        } else {
            $this->user->link()->delete();
            $this->user->shortLink;
        }
        $this->success('重置成功');
    }

    /**
     * @notes 关闭店铺链接
     * @auth false
     */
    public function close()
    {
        $status      = inputs("status/d", 1);
        $status_text = $status == 1 ? "开启" : "关闭";
        $this->user->link()->update(["status" => $status]);
        $this->success("该链接已" . $status_text . "成功！");
    }

    /**
     * @notes 获取店铺主题
     * @auth false
     */
    public function getTemplate()
    {
        if (empty($this->user->shop)) {
            $this->error('请先完成店鋪审核');
        }
        $this->success('获取成功', $this->user->shop->visible(['pc_template', 'mobile_template']));
    }

    /**
     * @notes 设置店铺主题
     * @auth false
     */
    public function setTemplate()
    {
        $field = inputs('field', '');
        $value = inputs('value', '');
        (empty($field) || empty($value)) && $this->error('参数错误');
        empty($this->user->shop) && $this->error('请先完成店鋪审核');
        $this->user->shop->$field = $value;
        $this->user->shop->allowField(['pc_template', 'mobile_template'])->save();
        $this->success('修改成功');
    }

    /**
     * PC端主题列表
     * @auth false
     */
    public function pcTemplate()
    {
        $thems = config('site.pc_template');
        $thems = array_map(function ($v, $k) {
            return [
                'label' => $v,
                'value' => $k,
            ];
        }, $thems, array_keys($thems));
        $this->success(1, $thems);
    }

    /**
     * 移动端主题列表
     * @auth false
     */
    public function mobileTemplate()
    {
        $thems = config('site.mobile_template');
        $thems = array_map(function ($v, $k) {
            return [
                'label' => $v,
                'value' => $k,
            ];
        }, $thems, array_keys($thems));
        $this->success(1, $thems);
    }

}