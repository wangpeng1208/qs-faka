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

namespace app\service\common;


class UploadService
{

    /**
     * 文件上传
     * @param $app 所属应用
     * @param $file 文件
     * @param $type 文件类型
     * @param $user_id  用户id
     */
    public function upload($app, $file, $type, $user_id)
    {
        // 获取文件后缀
        $ext               = strtolower($file->getUploadExtension());
        $ext_forbidden_map = ['php', 'php3', 'php5', 'css', 'js', 'html', 'htm', 'asp', 'jsp'];
        if (in_array($ext, $ext_forbidden_map)) {
            throw new \Exception('不支持该格式的文件上传');
        }
        switch ($type) {
            case 'image':
                $allow_type = ['jpg', 'jpeg', 'gif', 'png'];
                $error_msg = '仅支持 jpg jpeg gif png格式';
                // 访问路径
                $view_path = '/upload/' . $app . '/' . $user_id . '/image/' . date('Ymd');
                // 存放的绝对路径
                $real_path = public_path() . $view_path;
                break;
            case 'video':
                $allow_type = ['mp4', 'avi', 'rmvb', 'rm', 'asf', 'divx', 'mpg', 'mpeg', 'mpe', 'wmv', 'mkv', 'vob'];
                $error_msg = '仅支持 mp4 avi rmvb rm asf divx mpg mpeg mpe wmv mkv vob格式';
                $view_path = '/upload/' . $app . '/' . $user_id . '/video/' . date('Ymd');
                $real_path = public_path() . $view_path;
                break;
            // 如果是证书文件
            case 'certificate':
                $allow_type = ['pem', 'crt', 'cer', 'p12', 'pfx', 'der'];
                $error_msg = '仅支持 pem crt cer p12 pfx der格式的证书文件';
                // 需要上传到禁止外网访问的目录
                $view_path = "/crt/{$app}/{$user_id}/" . date('Ymd');
                $real_path = runtime_path() . $view_path;
                break;
            default:
                $allow_type = [];
                $error_msg = '文件格式错误';
                break;
        }
        $this->mkdir($real_path);
        $name = bin2hex(pack('Nn', time(), random_int(1, 65535))) . '.' . $ext;
        // 格式校验
        if (!in_array($ext, $allow_type)) {
            throw new \Exception($error_msg);
        }
        $file->move($real_path . '/' . $name);
        // 如果是证书文件 返回本地绝对路径
        if ($type === 'certificate') {
            return $real_path . '/' . $name;
        }
        // 如果使用站内资源
        return conf('site_domain') . $view_path . '/' . $name;
        // todo 云OSS存储
    }

    /**
     * 目录创建
     */
    public function mkdir($path)
    {
        if (!is_dir($path)) {
            try {
                mkdir($path, 0777, true);
            } catch (\Exception $e) {
                throw new \Exception('目录创建失败');
            }
        }

        // 检查目录是否可写
        if (!is_writable($path)) {
            try {
                chmod($path, 0777);
            } catch (\Exception $e) {
                throw new \Exception('目录不可写');
            }
        }
    }

}