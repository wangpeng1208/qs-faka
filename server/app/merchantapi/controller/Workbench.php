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

namespace app\merchantapi\controller;

use app\common\model\Article;
use app\common\model\Goods as GoodsModel;
use app\common\model\Order as OrderModel;
use app\common\model\OrderApi as OrderApiModel;
use app\common\model\UserAnalysis as UserAnalysisModel;
use app\service\analysis\AnalysisService;

class Workbench extends Base
{
    // 公告通知
    public function notice()
    {
        $data = Article::where(['status' => 1])
            ->whereIn('cate_id', function ($query) {
                $query->table('article_category')->where(['status' => 1, 'type' => 2])->field('id');
            })
            ->field('id,title,create_at')
            ->order('top asc , create_at desc')
            ->limit(10)
            ->select()->each(
                function ($item) {
                    $item->cate_name = $item->category()->value('name');
                }
            );
        $this->success('success', $data);
    }

    /**
     * 一句话
     * @auth false
  */
    // public function hitokoto()
    // {
    //     try {
    //         $res = file_get_contents('https://v1.hitokoto.cn/?encode=json');
    //         $res = json_decode($res, true);
    //     } catch (\Exception $e) {
    //         $this->error('获取失败');
    //     }
    //     $this->success('获取成功', $res['hitokoto'] . '-' . $res['from']);
    // }

    /**
     * 后台首页统计
     * @auth false
     */
    public function analysis(AnalysisService $analysisService)
    {
        $data["res_week"]    = $analysisService->weekAnalysis($this->user->id);
        $data["res_month"]   = $analysisService->monthAnalysis($this->user->id);
        $this->success('获取成功', $data);
    }

    /**
     * 仪表盘
     * @auth false
     */
    public function dashboard()
    {
        $data                               = [];
        $data['today']["count"]             = UserAnalysisModel::where(["user_id" => $this->user->id])->whereTime('date', 'today')->value("order_count");
        $data['today']["transaction_money"] = UserAnalysisModel::where(["user_id" => $this->user->id,])->whereTime('date', 'today')->sum("day_amount");

        $data['today']["total_fee"]        = OrderModel::where(["user_id" => $this->user->id, "status" => 1, "fee_payer" => 1])->whereTime('success_at', 'today')->sum("fee");
        $data['today']["total_sms_price"]  = OrderModel::where(["user_id" => $this->user->id, "status" => 1, "sms_payer" => 1, "sms_price" => [">=", 0]])->whereTime('success_at', 'today')->sum("sms_price");
        $data['today']["total_cost_price"] = OrderModel::where(["user_id" => $this->user->id, "status" => 1])->whereTime('success_at', 'today')->sum("total_cost_price");
        $data['today']["profit"]           = UserAnalysisModel::where(["user_id" => $this->user->id])->whereTime('date', 'today')->sum("profit");

        $data['yesterday']["count"] = UserAnalysisModel::where(["user_id" => $this->user->id])->whereTime('date', 'yesterday')->value("order_count");

        $data['yesterday']["transaction_money"] = UserAnalysisModel::where(["user_id" => $this->user->id])->whereTime('date', 'yesterday')->sum("day_amount");
        $data['yesterday']["total_fee"]         = OrderModel::where(["user_id" => $this->user->id, "status" => 1, "fee_payer" => 1])->whereTime('success_at', 'yesterday')->sum("fee");
        $data['yesterday']["total_sms_price"]   = OrderModel::where(["user_id" => $this->user->id, "status" => 1, "sms_payer" => 1, "sms_price" => [">=", 0]])->whereTime('success_at', 'yesterday')->sum("sms_price");
        $data['yesterday']["profit"]            = UserAnalysisModel::where(["user_id" => $this->user->id])->whereTime('date', 'yesterday')->sum("profit");

        $data['goods_count'] = GoodsModel::where(["user_id" => $this->user->id])->count();
        $data['user']        = $this->user->visible(["username", "mobile", "money", "freeze_money", "qq"]);
        $data['time'] = date("Y-m-d H:i:s", time());
        $this->success("获取成功", $data);
    }


}
