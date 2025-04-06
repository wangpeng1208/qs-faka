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

namespace app\merchantapi\controller\user;


use app\common\model\{Article as ArticleModel, ArticleCategory as ArticleCategoryModel, ArticleRead, MerchantMessage};
use think\facade\Db;
use app\merchantapi\controller\Base;

class News extends Base
{
    /**
     * 获取商户文章通知
     * @auth true
     */
    public function list()
    {
        // is_read 表 表示 用户是否已读，如果加上这个呢，就可以实现用户已读文章，不再显示
        $articles = ArticleModel::where(['status' => 1])
            ->whereIn('cate_id', function ($query) {
                $query->table('article_category')->where(['status' => 1, 'type' => 2])->field('id');
            })
            ->order('top desc, id desc')
            ->paginate($this->limit)->each(function ($item) {
                $item->cate_name = ArticleCategoryModel::where(['id' => $item->cate_id])->value('name');
                $item->is_read = ArticleRead::where(['user_id' => $this->user->id, 'news_id' => $item->id])->find() ? true : false;
                // 截取20个字符 并过滤html标签 空白字符
                $item->content = preg_replace('/\s+/', '', mb_substr(strip_tags(htmlspecialchars_decode($item->content)), 0, 20, 'utf-8'));
            });

        $this->success('获取成功', $articles);
    }

    public function unReadCount()
    {
        $unreadArticlesCount = ArticleModel::where(['status' => 1])
            ->whereIn('cate_id', function ($query) {
                $query->table('article_category')->where(['status' => 1, 'type' => 2])->field('id');
            })
            ->whereNotExists(function ($query) {
                $query->table('article_read')->whereColumn('news_id', 'article.id')->where(['user_id' => $this->user->id]);
            })
            ->count();
        $messagesCount       = MerchantMessage::where(['status' => 0, 'to_id' => $this->user->id])->order('id desc')->count();
        $count               = $unreadArticlesCount + $messagesCount;
        $this->success('获取成功', [
            'count' => $count
        ]);
    }

    /**
     * 标记已读文章通知
     * @auth false
     */
    public function read()
    {
        $news_id = inputs('id');
        $res     = Db::table('article_read')->where(['user_id' => $this->user->id, 'news_id' => $news_id])->find();
        if ($res) {
            $this->error('已读');
        } else {
            Db::table('article_read')->insert(['user_id' => $this->user->id, 'news_id' => $news_id, 'create_time' => time()]);
            $this->success('标记成功');
        }
    }

    /**
     * 标记全部已读文章通知
     * @auth false
     */
    public function readAll()
    {

        $articles = ArticleModel::where(['status' => 1])
            ->field('id')
            ->whereIn('cate_id', function ($query) {
                $query->table('article_category')->where(['status' => 1, 'type' => 2])->field('id');
            })
            ->order('top desc, id desc')
            ->select();
        foreach (collect($articles) as $key => $value) {
            $res = Db::table('article_read')->where(['user_id' => $this->user->id, 'news_id' => $value->id])->find();
            empty($res) && Db::table('article_read')->insert(['user_id' => $this->user->id, 'news_id' => $value->id, 'create_time' => time()]);
        }
        $this->success('标记成功');
    }

    /**
     * 获取文章详情
     * @auth falsea
     */
    public function detail()
    {
        $id      = inputs('id');
        $article = ArticleModel::find($id);

        $article->cate_name = ArticleCategoryModel::where(['id' => $article->cate_id])->value('name');
        $article->content   = htmlspecialchars_decode($article->content);
        $this->success('获取成功', $article);
    }
}