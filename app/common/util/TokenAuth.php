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

namespace app\common\util;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\BeforeValidException;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\SignatureInvalidException;
use support\Cache;

class TokenAuth
{

    /**
     *创建token
     * @param int $id 编码  一般传入用户id
     * @param string $type 场景（admin，api）
     * @param array $params 参数  传入id, name
     * @param int $expire_time 有效期
     * @return array
     */
    public static function createToken(int $id, string $type, array $params = [], int $expire_time = 0): array
    {
        $host              = request()->host();
        $time              = time();
        $params += [
            'iss' => $host,
            'aud' => $host,
            'iat' => $time,
            'nbf' => $time,
            'exp' => $time + $expire_time,
        ];
        $alg               = 'HS256';
        $params['jti']     = $id . "_" . $type;
        $token             = JWT::encode($params, 'rolaa456$%^', $alg);
        $cache_token       = Cache::get("token_" . $params['jti']);
        $cache_token_arr   = $cache_token ?: [];
        $cache_token_arr[] = $token;
        Cache::set("token_" . $params['jti'], $cache_token_arr);
        return compact('token', 'params');
    }

    /**
     * 解析token
     * @param string $token
     * @param string $type
     * @return array
     */
    public static function parseToken(string $type): array
    {
        $token = request()->header('authorization');
        $token = str_replace('Bearer ', '', $token);
        return self::parseCommonmToken($type, $token);
    }

    /**
     * 解析token及验证
     * @param string $type
     * @param string $token
     * @return array
     * @throws \Exception
     */
    public static function parseCommonmToken($type, $token)
    {
        try {
            $payload = JWT::decode($token, new Key('rolaa456$%^', 'HS256'));
        } catch (SignatureInvalidException $signatureInvalidException) {
            throw new \Exception('身份验证令牌无效');
        } catch (BeforeValidException $beforeValidException) {
            throw new \Exception('身份验证令牌尚未生效');
        } catch (ExpiredException $expiredException) {
            throw new \Exception('身份验证会话已过期，请重新登录！');
        } catch (\Exception $exception) {
            throw new \Exception('身份验证令牌无效');
        }
        if (!empty($payload)) {
            $token_info = json_decode(json_encode($payload), true, 512, JSON_THROW_ON_ERROR);

            if (explode("_", $token_info['jti'])[1] != $type) {
                throw new \Exception('身份验证令牌无效');
            }
            if (!empty($token_info) && !in_array($token, Cache::get('token_' . $token_info['jti'], []))) {
                throw new \Exception('身份验证会话已过期，请重新登录！');
            }
            $token_info['type'] = $type;
            return $token_info;
        } else {
            throw new \Exception('身份验证令牌尚未生效');
        }
    }

    /**
     * 清理token 退出登录
     * @param int $id
     * @param string $type
     * @param string|null $token
     */
    public static function clearToken(int $id, string $type, ?string $token = '')
    {
        if (!empty($token)) {
            $token_cache = Cache::get("token_" . $id . "_" . $type, []);
            //todo 也可以通过修改过期时间来实现 todo 单点登录
            if (!empty($token_cache)) {
                if (($key = array_search($token, $token_cache)) !== false) {
                    array_splice($token_cache, $key, 1);
                }
                Cache::set("token_" . $id . "_" . $type, $token_cache);
            }
        } else {
            Cache::set("token_" . $id . "_" . $type, []);
        }
        return true;
    }
}
