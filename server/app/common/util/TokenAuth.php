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

namespace app\common\util;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\BeforeValidException;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\SignatureInvalidException;

class TokenAuth
{
    /**
     * 获取JWT密钥
     */
    private static function getSecretKey()
    {
        $key = config('jwt.secret_key');
        if (!$key) {
            throw new \Exception('JWT secret key not configured');
        }
        return $key;
    }

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
        $host          = request()->host();
        $time          = time();
        $params += [
            'iss' => $host,
            'aud' => $host,
            'iat' => $time,
            'nbf' => $time,
            'exp' => $time + $expire_time,
        ];
        $alg           = 'HS256';
        $params['jti'] = $id . "_" . $type;
        $token         = JWT::encode($params, self::getSecretKey(), $alg);
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
            $payload = JWT::decode($token, new Key(self::getSecretKey(), 'HS256'));
        } catch (SignatureInvalidException $e) {
            throw new \Exception('身份验证令牌无效');
        } catch (BeforeValidException $e) {
            throw new \Exception('身份验证令牌尚未生效');
        } catch (ExpiredException $e) {
            throw new \Exception('身份验证会话已过期，请重新登录！');
        } catch (\Exception $e) {
            throw new \Exception('身份验证令牌无效');
        }
        if (!empty($payload)) {
            $token_info = json_decode(json_encode($payload), true, 512, JSON_THROW_ON_ERROR);

            if (explode("_", $token_info['jti'])[1] != $type) {
                throw new \Exception('身份验证令牌类型无效');
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
        
    }
}
