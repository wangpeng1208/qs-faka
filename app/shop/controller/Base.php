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

namespace app\shop\controller;

use app\common\model\Link;
use app\common\model\ShopIplist;
use app\service\common\Api;
use app\service\sms\SmsService;
use app\common\model\Channel;
use app\common\model\UserChannel;

class Base extends Api
{
    public $user;
    public $token;
    public $shop;
    public $relation;
    public $goods;
    public $goods_category;
    public $pcTemplate;
    public $mobileTemplate;
    protected $shop_visible = ['id', 'user_id', 'parent_id', 'qq', 'shop_name', 'shop_notice', 'statis_code', 'pay_theme', 'pay_theme_mobile', 'stock_display', 'status', 'is_freeze', 'website', 'shop_close', 'cash_type', 'login_auth', 'shop_gouka_protocol_pop', 'user_notice_auto_pop', 'music', 'mobile_template', 'is_award', 'shop_notice_show', 'show_contact', 'shop_contact', 'shop_logo', 'fee_payer'];
    protected $goods_visible = ['id', 'coupon_type', 'wholesale_discount', 'visit_type', 'take_card_type', 'limit_quantity', 'limit_quantity_max', 'price', 'contact_limit', 'sms_payer', 'sms_price', 'name', 'card_order', 'stockStr', 'content', 'cards_stock_count', 'event_give', 'addtion_give', 'wholesale_discount_list'];

    /**
     * 初始化
     *
     */
    public function __construct()
    {
        parent::__construct();
    }
    
    public function init()
    {
        // header('Cache-Control: max-age=0');
        // 站点关闭
        if (conf('site_status') == -1) {
            $this->error(conf('site_close_tips'));
        }
        // 链接token标识
        $this->token = inputs("token/s", "");
        $link        = Link::where("token", $this->token)->findOrEmpty();
        if ($link->isEmpty()) {
            $this->error("链接不存在!");
        }
        if ($link->status === 0) {
            $this->error("链接已关闭");
        }

        // 关联类型 user,goods,goods_category
        $this->relation = $link->relation;
        $sms_price      = (new SmsService())->getSmsPrice('order_to_buyer');
        switch ($link->relation_type) {
            case 'user':
                // $this->user = $link->relation;   
                if(!$link->relation->shop) {
                    $this->error("店铺不存在,请先完成店铺审核");
                }
                $this->shop = $link->relation->shop->visible($this->shop_visible);
                $this->goods_category = $this->shop->categorys()->where(["status" => 1, "is_show" => 1])->order("sort DESC")->select()->each(function ($item) {
                    $item->goodsCount = $item->count;
                });
                if ($this->goods_category->isEmpty()) {
                    $this->goods_category = [];
                    $this->goods          = [];
                } else {
                    // 第一个栏目下的商品
                    $this->goods = $this->goods_category[0]->goods()->where("status", 1)->visible($this->goods_visible)->order("sort DESC")->select()->each(function ($item) use ($sms_price) {
                        $item->sms_price         = $sms_price;
                        $item->cards_stock_count = $item->cards_stock_count ?: 0;
                        $item->stockStr = $this->stock_display($item);
                        $item->user     = null;
                        $item->category = null;
                    });
                }
                $this->pcTemplate = $this->shop->pc_template;
                $this->mobileTemplate = $this->shop->mobile_template;
                break;
            case 'goods':
                $this->shop = $link->relation->user->shop->visible($this->shop_visible);
                // 商品所属栏目
                $this->goods_category = [$link->relation->category];
                // // 商品数量
                $this->goods_category[0]->goodsCount = $link->relation->category->count;

                $this->goods = [$link->relation->visible($this->goods_visible)];
                // echo $link->relation->is_freeze;
                if ($link->relation->status === 0 || $link->relation->is_freeze === 1) {
                    $this->goods = [];
                } else {
                    $this->goods[0]->sms_price         = $sms_price;
                    $this->goods[0]->cards_stock_count = $this->goods[0]->cards_stock_count ?: 0;
                    $this->goods[0]->stockStr          = $this->stock_display($this->goods[0]);
                    $this->goods[0]->user              = null;
                    $this->goods[0]->category          = null;
                }
                $this->pcTemplate = $link->relation->theme;
                $this->mobileTemplate = $link->relation->mobile_theme;
                break;
            case 'goods_category':
                $this->shop = $link->relation->user->shop->visible($this->shop_visible);
                $this->goods_category[] = $link->relation;
                $this->goods_category[0]['goodsCount'] = $link->relation->goods()->where("status", 1)->visible($this->goods_visible)->count();
                // 栏目下的商品
                $this->goods = $link->relation->goods()->where("status", 1)->visible($this->goods_visible)->order("sort DESC")->select()->each(function ($item) use ($sms_price) {
                    $item->sms_price         = $sms_price;
                    $item->cards_stock_count = $item->cards_stock_count ?: 0;
                    $item->stockStr = $this->stock_display($item);
                    $item->user = null;
                });
                $this->pcTemplate = $this->goods_category[0]->theme;
                $this->mobileTemplate = 'default';
                break;
            default:
                $this->error("链接关联类型错误");
        }
        if (empty ($this->shop))
            $this->error("店铺不存在");
        if ($this->shop->shop_status === 0)
            $this->error("店铺未审核!"); // 用户提交 后台审核
        if ($this->shop->shop_close === 1)
            $this->error($this->shop->shop_close_notice); // 用户自己关闭
        if ($this->shop->shop_freeze === 1)
            $this->error("店铺已冻结"); // 管理员冻结店铺
        ShopIplist::visit($this->shop->id, $this->request->ip());
    }

    /**
     * 获取支付通道
     *
     * @param [type] $user_id 用户id
     * @return array
     */
    protected function channel($user_id)
    {
        $platform = Channel::where(["status" => 1, "is_custom" => 0, "type" => 1])->field(['id', 'title', 'is_available', 'paytype', 'is_custom', 'lowrate', 'show_name'])->order("sort desc")->select()->filter(
            function ($item) use ($user_id) {
                // 如果用户自定义了这个通道【状态关闭】，就不显示
                if (UserChannel::where(['user_id' => $user_id, 'channel_id' => $item->id, 'status' => 0])->find()) {
                    return false;
                }
                $item->user_id      = $user_id;
                $item->channel_id   = $item->id;
                $item->rate         = get_user_rate($user_id, $item->id);
                $item->product_name = get_paytype($item->paytype)->name; // 支付类型名
                $item->type_text = $item->type_text;
                $item->ico = get_paytype($item->paytype)->ico;
                unset ($item->id);
                return true;
            }
        );
        $custom   = UserChannel::where(['user_id' => $user_id, 'status' => 1])->select()->filter(
            function ($item) use ($user_id) {
                // 如果官方通道关闭了，就不显示
                if ($item->channel->status == 0) {
                    return false;
                }
                $item->title        = $item->channel->title;
                $item->rate         = get_user_rate($user_id, $item->channel->id);
                $item->product_name = get_paytype($item->channel->paytype)->name; // 支付类型名
                $item->type_text    = $item->channel->type_text;
                $item->ico          = get_paytype($item->channel->paytype)->ico;
                $item->is_available = $item->channel->is_available;
                $item->is_custom  = $item->channel->is_custom;
                $item->channel_id = $item->channel->id;
                $item->show_name = $item->channel->show_name;
                // unset ($item->id);
                return true;
            }
        );
        $res    = array_merge($platform->toArray(), $custom->toArray());
        $result = [];

        // 创建一个数组来存储已经存在的 channel_id
        $channel_ids = [];

        // 遍历 $res 数组
        foreach ($res as $item) {
            // 如果这个 channel_id 还没有出现过
            if (!in_array($item['channel_id'], $channel_ids)) {
                // 将这个 channel_id 添加到 $channel_ids 数组中
                $channel_ids[] = $item['channel_id'];
                // 将这个 item 添加到结果数组中
                $result[] = $item;
            }
        }
        // 电脑Or手机
        foreach ($result as $key => $item) {
            if ($this->request->isMobile()) {
                if ($item["is_available"] == 2) {
                    unset($result[$key]);
                }
            } else {
                if (!$this->request->isMobile() && $item["is_available"] == 1) {
                    unset($result[$key]);
                }
            }
        }
        return array_values($result);
    }


    /**
     * 库存显示
     *
     * todo 这里传入 goods模型 会再一次调用数据库查询；v3版本等待优化传入的是卡数量
     * @param [type] $goods 商品模型
     * @return string
     */
    protected function stock_display($goods)
    {
        if (!$goods->user) {
            return '库存' . $goods->cards_stock_count . '张';
        }

        $stockDisplay = $goods->user->shop->stock_display;
        $cardsCount   = $goods->cards_stock_count;

        if ($stockDisplay == 0) {
            return '';
        }

        if ($stockDisplay != 2) {
            return '库存' . $cardsCount . '张';
        }

        $stockStatuses = [
            ['limit' => 100, 'message' => '库存非常多'],
            ['limit' => 30, 'message' => '库存很多'],
            ['limit' => 10, 'message' => '库存一般'],
            ['limit' => 0, 'message' => '库存少量'],
        ];

        foreach ($stockStatuses as $status) {
            if ($cardsCount > $status['limit']) {
                return $status['message'];
            }
        }

        return '缺货';
    }
}
