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

namespace app\adminapi\controller\article;

use app\adminapi\controller\Base;
use app\common\model\Article as ArticleModel;

class Article extends Base
{
    /**
     * @notes文章分列表
     * @auth true
     */
    public function list()
    {
        $where = $this->request->params([
            ['title', ''],
            ['status', ''],
            ['date_range', ''],
        ]);
        $res   = ArticleModel::withSearch($where[0], $where[1])->order('top desc,id desc')->paginate($this->limit)->each(function ($item) {
            $item->cate_name = $item->category->name ?? '';
        });
        $this->success('获取成功', [
            'list'  => $res->items(),
            'total' => $res->total(),
        ]);
    }

    private function post()
    {
        $data     = [
            'id'          => inputs('id/d', 0),
            'cate_id'     => inputs('cate_id/d', 0),
            'title'       => inputs('title/s', ''),
            'title_img'   => inputs('title_img/s', ''),
            'content'     => inputs('content/s', ''),
            'status'      => inputs('status/d', 1),
            'create_at'   => inputs('create_at/d'),
            'is_system'   => inputs('is_system/d', 0),
            'top'         => inputs('top/d', 0),
        ];
        $validate = new \app\adminapi\validate\article\ArticleValidate;
        if ($data['id'] > 0) {
            $validate->scene('edit')->failException(true)->check($data);
        } else {
            unset($data['id']);
            $validate->scene('add')->failException(true)->check($data);
        }
        return $data;
    }

    /**
     * @notes 添加文章
     * @auth true 
     */
    public function add()
    {
        $data = $this->post();
        $res  = ArticleModel::create($data);
        return $res ? $this->success('添加成功', ) : $this->error('添加失败');
    }

    /**
     * @notes 编辑文章
     * @auth true 
     */
    public function edit()
    {
        $data = $this->post();
        $res = ArticleModel::update($data);
        return $res ? $this->success('编辑成功') : $this->error('编辑失败');
    }

    /**
     * @notes 删除文章
     * @auth true   
     */
    public function del()
    {
        $id = inputs('id/d', 0);
        $article = ArticleModel::findOrFail($id);
        if($article->is_system == 1){
            $this->error('文章禁止删除，请先取消系统调用');
        }
        $article->delete();
        $this->success('删除成功');
    }
}
