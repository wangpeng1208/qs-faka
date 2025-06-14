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

namespace app\adminapi\controller\merchant;

use think\facade\Db;
use app\adminapi\controller\Base;
use app\service\message\EmailMessageService;
use app\common\model\{User as UserModel, UserCollect as UserCollectModel, Channel as ChannelModel, UserLoginLog, UserRate as UserRateModel, UserRoleRelation, UserLoginErrorLog};
use app\service\message\MessageService;
use Webman\Event\Event;
// use Webman\RedisQueue\Redis;

/**
 * 商户管理
 */
class User extends Base
{
    /**
     * @notes 商户列表
     * @auth true
     */
    public function list()
    {
        $where = $this->request->params([
            ['username', ''],
            ['mobile', ''],
            ['date_range', ''],
        ]);
        $res   = UserModel::withSearch($where[0], $where[1])->order("id desc")->paginate($this->limit)->each(function ($item) {
            $user_collect = UserCollectModel::where("user_id", $item->id)->find();
            if (!empty($user_collect)) {
                $item->idcard_number = $user_collect?->info?->idcard_number ?? '';
            }
            $item->shop_name       = $item->shop->shop_name ?? '';
            $item->complaint_count = $item->complaints()->count();
        });
        $this->success('获取成功', [
            'list'  => $res->items(),
            'total' => $res->total(),
        ]);
    }

    /**
     * @notes 商户详情
     */
    public function detail()
    {
        $id   = inputs('id/d', 0);
        $data = UserModel::findOrFail($id)->toArray();
        unset($data['password']);
        return $this->success('success', $data);
    }

    private function post()
    {
        $data     = [
            'id'              => inputs('id/d', 0),
            'username'        => inputs('username/s', ''),
            'email'           => inputs('email/s', ''),
            'mobile'          => inputs('mobile/s', ''),
            'qq'              => inputs('qq/s', ''),
            'statis_code'     => inputs('statis_code/s', ''),
            'pay_theme'       => inputs('pay_theme/s', 'default'),
            'password'        => inputs('password/s', ''),
            'settlement_type' => inputs('settlement_type/d', ''),
            'payapi'          => inputs('payapi/d', 0),
        ];
        $validate = new \app\adminapi\validate\merchant\UserValidate;
        if ($data['id'] > 0) {
            $validate->scene('edit')->failException(true)->check($data);
            if (empty($data['password'])) {
                unset($data['password']);
            } else {
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
            }
        } else {
            $validate->scene('add')->failException(true)->check($data);
            unset($data['id']);
            $data["create_at"] = time();
            $data["rate_type"] = 0;
            $data["password"]  = password_hash($data['password'], PASSWORD_DEFAULT);
        }
        return $data;
    }

    /**
     * @notes 商户添加
     * @auth true
     */
    public function add()
    {
        $data = $this->post();
        $res  = UserModel::create($data);
        Event::emit('user.addafter', $res->id);
        return $res ? $this->success("操作成功！") : $this->error("操作失败！");
    }

    /**
     * @notes 商户编辑
     * @auth true
     */
    public function edit()
    {
        $data = $this->post();
        $res  = UserModel::update($data);
        return $res ? $this->success("操作成功！") : $this->error("操作失败！");
    }

    /**
     * @notes 商户删除
     * @auth true
     */
    public function del()
    {
        $id = inputs('id/d', 0);
        UserModel::destroy($id);


        // 删除分组
        // $queue = 'del-merchant';
        // 数据，可以直接传数组，无需序列化
        // $data = ['user_id' => $id];
        // 投递消息
        // Redis::send($queue, $data);
        // 投递延迟消息，消息会在60秒后处理
        // Redis::send($queue, $data, 60);



        $this->success('操作成功');
    }

    /**
     * @notes 商户消息
     * @auth true
     */
    public function message()
    {
        $user_id = inputs("user_id/d", 0);
        $user    = UserModel::findOrFail($user_id);
        $title   = inputs("title/s", "") ?: $this->error("请输入标题！");
        $content = inputs("content/s", "") ?: $this->error("请输入内容！");
        $type    = inputs("type/d", 'site');
        if ($type == 'site') {
            $title  = '【站内信】' . $title;
            $result = MessageService::send(0, $user_id, $title, $content);
        }
        if ($type == 'email') {
            $title = '【邮件】' . $title;
            if ($user->email == '')
                $this->error('该用户未绑定邮箱！');
            $result = EmailMessageService::send($user->email, $title, $content);
        }

        if ($result !== false) {
            return $this->success("发送成功！");
        } else {
            return $this->error("发送失败，请重试！");
        }
    }

    /**
     * notes 商户登录日志
     * @auth false
     */
    public function loginlog()
    {

        $where = $this->request->params([
            ['field', ''],
            ['keyword', ''],
            ['ip', ''],
            ['date_range', '']
        ]);
        $res   = UserLoginLog::withSearch($where[0], $where[1])->order("id desc")->paginate($this->limit)
            ->each(function ($item) {
                $item->username = UserModel::where("id", $item->user_id)->value("username");
            });
        $this->success('获取成功', [
            'list'  => $res->items(),
            'total' => $res->total(),
        ]);
    }

    /**
     * @notes 商户资金变动
     * @auth true
     */
    public function money()
    {
        $user_id = inputs("user_id/d", 0);
        $user    = UserModel::findOrFail($user_id);
        $action  = inputs("action/s", "");
        $money   = inputs("money/f", 0);
        $mark    = inputs("mark/s", "");
        if ($money <= 0) {
            $this->error("操作金额不能小于等于零！");
        }
        switch ($action) {
            case "inc":
                $user->money += $money;
                $reason = "增加金额" . $money . "元，备注：" . $mark;
                $business_type = "admin_inc";
                $operation = 1;
                break;
            case "dec":
                if ($user->money < $money) {
                    $this->error("可用余额不足！");
                }
                $user->money -= $money;
                $reason = "扣除金额" . $money . "元，备注：" . $mark;
                $business_type = "admin_dec";
                $operation = -1;
                break;
            case "unfreeze":
                if ($user->freeze_money < $money) {
                    $this->error("可用冻结余额不足！");
                }
                $user->money += $money;
                $user->freeze_money -= $money;
                $reason = "解冻金额" . $money . "元，备注：" . $mark;
                $business_type = "unfreeze";
                $operation = 1;
                break;
            case "freeze":
                if ($user->money < $money) {
                    $this->error("可用余额不足！");
                }
                $user->money -= $money;
                $user->freeze_money += $money;
                $reason = "冻结金额" . $money . "元，备注：" . $mark;
                $business_type = "freeze";
                $operation = -1;
                break;
            case "customchannelfeeadd": // 加预存
                $user->fee_money += $money;
                $reason = "增加预存金额" . $money . "元，备注：" . $mark;
                $business_type = "admin_fee_money_inc";
                $operation = 1;
                break;
            case "customchannelfeedec": // 扣预存
                if ($user->fee_money < $money) {
                    $this->error("可用预存余额不足！");
                }
                $user->fee_money -= $money;
                $reason = "扣除预存金额" . $money . "元，备注：" . $mark;
                $business_type = "admin_fee_money_dec";
                $operation = -1;
                break;
            default:
                $this->error("未知操作！");
                break;
        }
        Db::startTrans();
        try {
            $user->save();
            record_user_money_log($business_type, $user->id, $operation * $money, $user->money, $reason);
            Db::commit();
        } catch (\Exception $e) {
            Db::rollback();
            $this->error("操作失败，原因：" . $e->getMessage());
        }
        $this->success("操作成功！", "");

    }

    // role
    public function role()
    {
        $user_id = inputs("id/d", 0);
        $res     = UserRoleRelation::where("user_id", $user_id)->find();
        $this->success("获取成功", $res);
    }

    public function setRole()
    {
        $data = [
            'user_id' => inputs('user_id/d', 0),
            'role_id' => inputs('role_id/d', 0),
        ];
        $res  = UserRoleRelation::update($data, ['user_id' => $data['user_id']]);
        $this->success("success", $res);
    }

    /**
     * @notes 获取用户通道费率
     * @auth true
     */
    public function rateList()
    {
        $id   = inputs('id/d', 0);
        $user = UserModel::find($id);
        $res  = ChannelModel::where('type', 1)->paginate($this->limit)->each(function ($item) use ($user, $id) {
            $role_rate = $user->rate()->where(['channel_id' => $item->id, 'user_id' => $id])->find();
            if (empty($role_rate)) {
                $item->rate       = $item->lowrate * 1000;
                $item->status     = 0;
                $item->status_tip = '未设置，当前使用通道费率';
            } else {
                $item->rate       = $role_rate->rate * 1000;
                $item->status     = $role_rate->status;
                $item->status_tip = '已设置';
            }
        });
        $this->success('获取成功', [
            'user'  => $user,
            'list'  => $res->items(),
            'total' => $res->total(),
        ]);
    }

    /**
     * @notes 编辑用户通道费率
     * @auth true
     */
    public function editRate()
    {
        $data = [
            'user_id'    => inputs('user_id/d', 0),
            'channel_id' => inputs('channel_id/d', 0),
            'status'     => inputs('status/d', 0),
            'rate'       => inputs('rate/d', 0) / 1000,
        ];
        $info = UserRateModel::where(['user_id' => $data['user_id'], 'channel_id' => $data['channel_id']])->find();
        if (empty($info)) {
            $res = UserRateModel::create($data);
        } else {
            $res = UserRateModel::update($data, [
                'user_id'    => $data['user_id'],
                'channel_id' => $data['channel_id'],
            ]);
        }
        return $res ? $this->success('操作成功') : $this->error('操作失败');
    }

    /**
     * @notes 设置选择用户费率模式
     * @auth true
     */
    public function setRateType()
    {
        $user_id = inputs('user_id/d', 0);
        $type    = inputs('type/d', 0);
        $res     = UserModel::update(['id' => $user_id, 'rate_type' => $type]);
        return $res ? $this->success('操作成功') : $this->error('操作失败');
    }

    /**
     * @notes 用户登录解锁
     * @auth true
     */
    public function unlock()
    {
        $user_id   = inputs('user_id/d', 0);
        $username  = UserModel::where('id', $user_id)->value('username');
        $max_count = conf("wrong_password_times") ?: 5;
        $res       = UserLoginErrorLog::where([
            "login_name" => $username,
            "user_type"  => 0
        ])->whereTime('login_time', 'today')->count();
        if ($res < $max_count) {
            $this->error('用户未被锁定');
        }
        $res = UserLoginErrorLog::where([
            "login_name" => $username,
            "user_type"  => 0
        ])->whereTime('login_time', 'today')->delete();
        return $res ? $this->success('操作成功') : $this->error('操作失败');
    }

    /**
     * @notes 商户收款信息详情
     * @auth true
     */
    public function collectDetail()
    {
        $user_id           = inputs('id/d', 0);
        $data = UserCollectModel::where('user_id', $user_id)->find() ?? [];
        $data['user_id'] = $user_id;
        return $this->success('success', $data);
    }

    /**
     * @notes 商户收款信息编辑
     * @auth true
     */
    public function collectEdit()
    {
        $data = [
            'id'           => inputs('id/d', 0),
            'user_id'      => inputs("user_id/d", 0),
            'type'         => inputs('type/d', 0),
            'info'         => inputs('info/a', []),
            'allow_update' => inputs('allow_update/d', 0),
            'create_at'    => time(),
        ];
        $this->validateInfo($data);
        if ($data['id']) {
            $res = UserCollectModel::update($data);
        } else {
            unset($data['id']);
            $res = UserCollectModel::create($data);
        }

        return $res ? $this->success('操作成功') : $this->error('操作失败');
    }

    private function validateInfo($data)
    {
        $requiredFields = [
            1 => ['account' => '请填写账户信息', 'realname' => '请填写真实姓名', 'idcard_number' => '请填写身份证号码'],
            2 => ['account' => '请填写账户信息', 'realname' => '请填写真实姓名', 'idcard_number' => '请填写身份证号码'],
            3 => ['bank_name' => '请填写银行名称', 'bank_branch' => '请填写银行开户行', 'bank_card' => '请填写银行卡号', 'realname' => '请填写真实姓名', 'idcard_number' => '请填写身份证号码'],
        ];

        if (isset($requiredFields[$data['type']])) {
            foreach ($requiredFields[$data['type']] as $field => $message) {
                if (empty($data['info'][$field])) {
                    $this->error($message);
                }
            }
        }
    }

}