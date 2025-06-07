<?php

use think\facade\Db;
use app\common\model\Config;
use app\common\model\UserMoneyLog;

/**
 * 获取输入参数 支持默认值和过滤
 * @param string $name 变量名
 * @param mixed  $default 默认值
 * @return mixed
 */
if (!function_exists('inputs')) {
    function inputs(string $name, $default = null)
    {
        if (strpos($name, '/') !== false) {
            [$name, $type] = explode('/', $name);

            if ($type && in_array($type, ['d', 'a', 'f', 's'])) {
                if ($type === 'd') {
                    $default = intval($default);
                } elseif ($type === 'a') {
                    $default = (array) $default;
                } elseif ($type === 'f') {
                    $default = floatval($default);
                } elseif ($type === 's') {
                    $default = strval($default);
                }
            }
        }

        $value = request()->input($name, $default);
        
        // 处理返回值类型转换
        if (isset($type) && in_array($type, ['d', 'a', 'f', 's'])) {
            if ($type === 'd') {
                $value = intval($value);
            } elseif ($type === 'a') {
                $value = (array) $value;
            } elseif ($type === 'f') {
                $value = floatval($value);
            } elseif ($type === 's') {
                $value = strval($value);
            }
        }
        
        return $value;
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
    if ($value === null) {
        // 模型查询 用于被BaseModel的onAfterRead事件拦截
        $res   = Config::where('name', $name)->find();
        $value = $res ? $res->value : '';
        // 如果是数字，转换成数字
        if (is_numeric($value)) {
            $value += 0;
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
 * 记录用户金额变动日志
 * @param string    $business_type 业务类型
 * @param int    $user_id 用户id
 * @param float  $money 金额
 * @param float  $balance 余额
 * @param string $reason 原因
 */
function record_user_money_log($business_type, $user_id, $money, $balance, $reason): void
{
    try {
        Db::startTrans();
        UserMoneyLog::create([
            'business_type' => $business_type,
            'user_id'       => $user_id,
            'money'         => round($money, 3),
            'balance'       => round($balance, 3),
            'reason'        => $reason,
        ]);
        Db::commit();
    } catch (\Exception $e) {
        Db::rollback();
        throw new \Exception($e->getMessage());
    }
}

/**
 * 费率计算规则
 * rate_type = 1时为 手动给用户自定义 如果是0  如果是0 则走支付接口的费率
 * rate_type = 0时为 查用户权限表里的费率 如果是0 则走支付接口的费率
 * @param int $user_id 用户id
 * @param int $channel_id 通道id
 * 后台操作说明：编辑商户角色费率时选择 `通道费率` 则意味着 该角色 使用的是对应通道的费率；如果需要自定义该角色的费率 则需把模式改为` 角色费率`
 * 如果`单独定义`了用户的费率 ,那么使用模式 `用户费率` 优先级最高
 */
function get_user_rate($user_id, $channel_id)
{
    $lowrate = Db::name("pay_channel")->where(["id" => $channel_id])->value("lowrate");

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

    return round($rate, 4);
}


/**
 * 生成订单号后缀 - 用于防止订单号扫描
 * @return string
 */
function generate_trade_no_suffix()
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
        $trade_no = conf('order_trade_no_profix') . date('ymdHis') . explode('-', generate_trade_no_suffix())[0];
    } else {
        $trade_no = $userid . date('ymdHis') . explode('-', generate_trade_no_suffix())[0];
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

/**
 * 过滤 xss 攻击
 * @param string $param 参数
 * @param bool   $filter 是否过滤
 * @return string
 */
function paramFilter($param, bool $filter = true)
{
    if (!$param || !$filter || !is_string($param)) {
        return $param;
    }
    $param       = htmlspecialchars_decode($param);
    $filter_rule = [
        "/<(\\/?)(script|i?frame|style|html|body|title|link|meta|object|\\?|\\%)([^>]*?)>/isU",
        "/(<[^>]*)on[a-zA-Z]+\s*=([^>]*>)/isU",
        "/select|join|where|drop|like|modify|rename|insert|update|table|database|alter|truncate|\'|\/\*|\.\.\/|\.\/|union|into|load_file|outfile/is"
    ];
    return preg_replace($filter_rule, '', $param);
}