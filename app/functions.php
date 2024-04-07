<?php

use think\facade\Db;
use app\common\model\Config;

//  自动导入 各个应用下的函数文件
$files = glob(__DIR__ . '/*/function.php');
foreach ($files as $file) {
    require $file;
}

// 所有input都需要是post请求
if (!function_exists('input')) {
    /**
     * 获取输入参数 支持默认值和过滤
     * @param string $name 变量名
     * @param mixed  $default 默认值
     * @return mixed
     */
    function input(string $name, $default = null)
    {
        if (strpos($name, '/') !== false) {
            [$name, $type] = explode('/', $name);
            if ($type && in_array($type, ['d', 'a', 'f', 's'])) {
                switch ($type) {
                    case 'd':
                        $default = intval($default);
                        break;
                    case 'a':
                        $default = (array) $default;
                        break;
                    case 'f':
                        $default = floatval($default);
                        break;
                    case 's':
                        $default = strval($default);
                        break;
                    default:
                        $default = NULL;
                        break;
                }
            }
        }
        return request()->input($name, $default);
    }
}

/**
 * 设备或配置系统参数或者新增系统参数
 * @param string $name  参数名称
 * @param bool   $value 默认是null为获取值，否则为更新
 * @return string|bool|array
 */
function conf($name, $value = null)
{
    if (is_null($value)) {
        // 模型查询 用于被BaseModel的onAfterRead事件拦截
        $res   = Config::where('name', $name)->find();
        $value = $res ? $res->value : '';
        // 如果是数字，转换成数字
        if (is_numeric($value)) {
            $value = $value + 0;
        }
        // 如果是 JSON
        $json = json_decode($value, true);
        if (json_last_error() == JSON_ERROR_NONE) {
            $value = $json;
        }
        return $value;
    } else {
        // 如果$value是数组或者对象，转换成json
        if (is_array($value) || is_object($value)) {
            $value = json_encode($value, JSON_UNESCAPED_UNICODE);
        }
        return Config::where('name', $name)->find() ? Config::update(['value' => $value], ['name' => $name]) : Config::insert(['name' => $name, 'value' => $value]);
    }
}

/**
 * 记录文件日志
 * @param string $filename 文件名
 * @param string $content 内容
 * @return void
 */
function record_file_log($filename, $content)
{
    if (!is_dir(runtime_path())) {
        mkdir(runtime_path(), 0755, true);
    }
    $log_path = runtime_path() . '/logs/';
    if (!is_dir($log_path)) {
        mkdir($log_path, 0755, true);
    }
    // 如果$content是数组或者对象，转换成json
    if (is_array($content)) {
        $content = json_encode($content, JSON_UNESCAPED_UNICODE);
    }
    file_put_contents($log_path . $filename . '.log', date('【Y-m-d H:i:s】') . "{$content}" . PHP_EOL, FILE_APPEND);
}


/**
 * 返回接口数据
 * @param int    $code 状态码
 * @param string $msg  信息
 * @param array  $data 数据
 *
 * @return string json数据
 */
function J($code, $msg = '', $data = [], $url = null)
{
    $return = [
        'code'      => $code,
        'msg'       => $msg,
        'data'      => $data,
        'url'       => $url,
        'timestamp' => time(),
    ];
    return json($return);
}

/**
 * 返回接口数据
 * @param int    $code 状态码
 * @param string $msg  信息
 * @param array  $data 数据
 */
function A($code, $msg = '', $data = [], $url = null)
{
    $return = [
        'code'      => $code,
        'msg'       => $msg,
        'data'      => $data,
        'url'       => $url,
        'timestamp' => time(),
    ];
    // 兼容default_ajax_return=json，防止被双重json_encode，添加appliaction/json头
    return $return;
}

/**
 * 获取支付类型名称
 * @param int $paytype 支付类型
 */
function get_paytype($paytype)
{
    return \app\common\model\PayType::find($paytype);
}

/**
 * 生成随机字符串
 * @param int $length 长度
 * @return string
 */
function get_random_string($length = 32)
{
    $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $str   = '';
    for ($i = 0; $i < $length; $i++) {
        $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
    }
    return $str;
}

/**
 * 资金操作类型
 * @return array
 */
function business_types()
{
    return [
        'unfreeze'                => '解冻金额',
        'freeze'                  => '冻结金额',
        'sub_sold_rebate'         => '下级卖出商品返佣',
        'sub_fee_rebate'          => '下级手续费返佣',
        'cash_notpass'            => '提现未通过',
        'cash_success'            => '提现成功',
        'apply_cash'              => '申请提现',
        'admin_inc'               => '后台操作加钱',
        'admin_dec'               => '后台操作扣钱',
        'fee'                     => '手续费',
        'goods_sold'              => '卖出商品',
        'goods_refund'            => '商品退款',
        'sub_register'            => '推广注册奖励',
        'reward'                  => '奖励金',
        'admin_fee_money_inc'     => '管理员手动操作增加预存',
        'admin_fee_money_dec'     => '管理员手动操作扣除预存',
        'admin_deposit_money_inc' => '管理员手动操作增加保证金',
        'admin_deposit_money_dec' => '管理员手动操作扣除保证金',
        'gatewaygoods_sold'       => '网关产品卖出'
    ];
}

/**
 * 记录用户金额变动日志
 * @param string    $business_type 业务类型
 * @param int    $user_id 用户id
 * @param float  $money 金额
 * @param float  $balance 余额
 * @param string $reason 原因
 */
function record_user_money_log($business_type, $user_id, $money, $balance, $reason)
{
    $businessTypes = business_types();
    $tag           = isset($businessTypes[$business_type]) ? "【{$businessTypes[$business_type]}】" : '';
    Db::name('UserMoneyLog')->insert([
        'business_type' => $business_type,
        'user_id'       => $user_id,
        'money'         => round($money, 3),
        'balance'       => round($balance, 3),
        'reason'        => $tag . $reason,
        'create_at'     => time(),
    ]);
}


/**
 * 用户是否被处罚
 * v3 todo 处罚机制
 * @param [type] $user_id
 * @return boolean
 */
function is_punish($user_id)
{
    return 0;
}

/**
 * 费率计算规则
 * rate_type = 1时为 手动给用户自定义 如果是0  如果是0 则走支付接口的费率
 * rate_type = 0时为 查用户权限表里的费率 如果是0 则走支付接口的费率
 * @param int $user_id 用户id
 * @param int $channel_id 通道id
 */
function get_user_rate($user_id, $channel_id)
{
    $lowrate = Db::name("channel")->where(["id" => $channel_id])->value("lowrate");

    $rate_type = Db::name("user")->where(["id" => $user_id])->value("rate_type");
    if ($rate_type == 0) {
        $user_role_relation = Db::name("user_role_relation")->where("user_id", $user_id)->find();
        if (!empty($user_role_relation)) {
            $user_role_rate = Db::name("user_role_rate")->where(["role_id" => $user_role_relation["role_id"], "channel_id" => $channel_id, "status" => 1])->find();
            $rate           = !empty($user_role_rate) ? $user_role_rate["rate"] : $lowrate;
        } else {
            $rate = $lowrate;
        }
    } else {
        $user_rate = Db::name("user_rate")->where(["user_id" => $user_id, "channel_id" => $channel_id])->find();
        $rate      = !empty($user_rate) ? $user_rate["rate"] : $lowrate;
    }

    if (is_punish($user_id) == 1) {
        $rate = $rate + conf("punish")['add_rate'] / 100;
    }

    return round($rate, 4);
}


// 生成代理码 全球唯一的识别码
function generateProxyKey()
{
    $key = md5(uniqid(md5(microtime(true)), true));
    return substr($key, 0, 8) . '-' . substr($key, 8, 4) . '-' . substr($key, 12, 4) . '-' . substr($key, 16, 4) . '-' . substr($key, 20, 12);
}


/**
 * 生成订单号
 * @param string $flag 订单标识
 * @param int    $userid 用户id
 * @return string 订单号
 */
function generate_trade_no($flag = 'A', $userid = 0)
{
    //订单自定义
    if (conf('order_trade_no_type') == 0) {
        $trade_no = conf('order_trade_no_profix') . date('ymdHis') . explode('-', generateProxyKey())[0];
    } else {
        $trade_no = $userid . date('ymdHis') . explode('-', generateProxyKey())[0];
    }
    // 打款订单号
    if ($flag == 'G') {
        $trade_no = $flag . date('ymdHis') . str_pad(abs($userid - 10000), 4, 0) . str_pad(mt_rand(0, 99), 2, '0');
    }

    // 商户后台充值订单号
    if ($flag == 'M') {
        $trade_no = $flag . date('ymdHis') . str_pad(abs($userid - 10000), 4, 0) . str_pad(mt_rand(0, 99), 2, '0');
    }

    //校验是否有重复订单号
    $res = \app\common\model\OrderMaster::where(['trade_no' => $trade_no])->find();
    if (!empty($res)) {
        //需要重新生成订单号
        $trade_no = generate_trade_no($flag, $userid);
    }

    return $trade_no;
}

/**
 * 违禁词检测
 * @param string $str 待检测字符串
 * @return bool|string FALSE/敏感词汇
 */
function check_wordfilter($str)
{
    if (conf('site_wordfilter_status') == 1) {
        $dangerWords = conf('site_wordfilter_danger');
        $words       = array_filter(explode('|', trim($dangerWords, '|')));
        foreach ($words as $item) {
            if (strpos($str, $item) !== false) {
                return $item;
            }
        }
    }
    return false;
}