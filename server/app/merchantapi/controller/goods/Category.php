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

class category extends Base
{

    /**
     * 分类列表
     * @auth true
     */
    public function list()
    {
        $with_search = $this->request->params([
            ['name/s', ''],
        ]);
        $list        = $this->user->categorys()->withSearch($with_search[0], $with_search[1])->order('sort desc, id desc')->paginate($this->limit)->each(function ($item) {
            $item->goods_count = $item->goods()->count();
        });
        $this->success('获取成功', [
            'list'  => $list->items(),
            'total' => $list->total()
        ]);
    }

    /**
     * 分类数据筛选 - 简短
     * @auth false
     */
    public function listSimple()
    {
        $list = $this->user->categorys()->field('id as value,name as label')->select();
        $this->success('获取成功', ['list' => $list]);
    }

    private function post($type = 'add')
    {
        $data = [
            'id'           => inputs('id/d', 0),
            'name'         => inputs('name/s', ''),
            'sort'         => inputs('sort/d', 0),
            'is_show'      => inputs('is_show/d', 1),
            'status'       => inputs('status/d', 1),
            'create_at'    => time()
        ];
        // 数据校验
        $validate = new \app\merchantapi\validate\goods\CategoryValidate;
        return $validate->data($type, $data);
    }

    /**
     * @notes 添加商品分类
     * @auth true
     */
    public function add()
    {
        $data = $this->post('add');
        $res  = $this->user->categorys()->save($data);
        if (empty($res->sort)) {
            $res::update(['sort' => $res->id], ['id' => $res->id]);
        }
        return $res ? $this->success("添加成功！") : $this->error("添加失败！");
    }

    /**
     * @notes 编辑商品分类
     * @auth true
     */
    public function edit()
    {
        $data = $this->post('edit');
        print_r($data);
        $res  = $this->getCategory($data['id'])->save($data);
        return $res ? $this->success("保存成功！") : $this->error("保存失败！");
    }

    public function del()
    {
        $ids = inputs('ids/a', []);
        if (empty($ids)) {
            $this->error("请选择要删除的商品栏目！");
        }
        foreach ($ids as $id) {
            $data = $this->getCategory($id);
            if ($data->goods()->count()) {
                $this->error("该分类下存在商品，暂时不能删除！");
            }
            $data->delete();
        }
        $this->success("删除成功！");
    }

    public function status()
    {
        $cate  = $this->getCategory(inputs('id/d', 0));
        $field = inputs("field/s");
        $value = inputs("value/d");
        $res   = $cate->allowField(['status', 'sort', 'is_show'])->save([$field => $value]);
        return $res ? $this->success("操作成功！") : $this->error("操作失败！");
    }

    // 获取分类
    private function getCategory($id)
    {
        return $this->user->categorys()->find($id) ?: $this->error("分类不存在！");
    }

}
