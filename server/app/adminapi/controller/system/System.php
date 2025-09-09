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

namespace app\adminapi\controller\system;

use think\facade\Db;
use app\adminapi\controller\Base;

class System extends Base
{
    // 定义 缓存路径静态属性
    private $CACHE_PATH;
    // 定义 日志路径静态属性
    private $LOG_PATH;
    // 定义 文件路径静态属性
    private $FILE_PATH;

    public function __construct()
    {
        $this->CACHE_PATH = runtime_path() . '/cache';
        $this->LOG_PATH   = runtime_path() . '/logs';
        $this->FILE_PATH  = runtime_path() . '/file';
    }

    public function cache()
    {
        return $this->success('获取成功', [
            'list'  => [
                ['param' => '日志缓存', 'dir' => $this->LOG_PATH, 'value' => $this->getDirSize($this->LOG_PATH)],
                ['param' => '文件缓存', 'dir' => $this->FILE_PATH, 'value' => $this->getDirSize($this->FILE_PATH)],
                ['param' => '缓存文件', 'dir' => $this->CACHE_PATH, 'value' => $this->getDirSize($this->CACHE_PATH)],
            ],
            'total' => '3'
        ]);
    }

    private function getDirSize($dir)
    {
        // 如果目录不存在 则 返回 0
        if (!is_dir($dir)) {
            return 0;
        }
        $handle = opendir($dir);
        $size   = 0;
        while (false !== ($file = readdir($handle))) {
            if ($file != '.' && $file != '..') {
                $cur_path = $dir . '/' . $file;
                if (is_dir($cur_path)) {
                    $size += $this->getDirSize($cur_path);
                } else {
                    $size += filesize($cur_path);
                }
            }
        }
        closedir($handle);
        return $size;
    }

    // 按文件目录清空缓存
    public function clearCache()
    {
        $dir = inputs('dir', $this->FILE_PATH);
        // 判断$dir是否是上面定义的常量
        if (!in_array($dir, [$this->CACHE_PATH, $this->LOG_PATH, $this->FILE_PATH])) {
            return $this->error('非法操作');
        }
        // 删除$dir目录下的所有文件及文件夹
        $this->delDir($dir);
        $this->success('清除成功');
    }
    // delDir
    private function delDir($dir)
    {
        // 如果目录不存在 则 返回 0
        if (!is_dir($dir)) {
            return 0;
        }
        $handle = opendir($dir);
        while (false !== ($file = readdir($handle))) {
            if ($file != '.' && $file != '..') {
                $cur_path = $dir . '/' . $file;
                if (is_dir($cur_path)) {
                    $this->delDir($cur_path);
                } else {
                    unlink($cur_path);
                }
            }
        }
        closedir($handle);
        rmdir($dir);
    }
    
    public function getInfo()
    {
        $server = [
            ['param' => '服务器操作系统', 'value' => PHP_OS],
            ['param' => 'PHP版本', 'value' => PHP_VERSION],
            ['param' => 'MySQL版本', 'value' => Db::query('select version() as ver')[0]['ver']],
            ['param' => '系统版本号', 'value' => config('site.version')],
        ];

        $env = [
            ['option' => 'PHP版本',
                'require' => '>=8.2',
                'status'  => version_compare(PHP_VERSION, '8.0.0') >= 0 ? true : false,
                'remark'  => ''
            ],
            // redis扩展是否开启
            ['option' => 'Redis扩展',
                'require' => '缓存使用redis时、使用Redis队列时 按需开启',
                'status'  => extension_loaded('redis') ? true : false,
                'remark'  => ''
            ],
        ];

        $auth = [
            [
                'dir'     => '/runtime',
                'require' => 'runtime目录可写',
                'status'  => is_writable(runtime_path()) ? true : false,
                'remark'  => '用于存储各种运行日志文件，需要目录可写'
            ],
            [
                'dir'     => '/public/uploads',
                'require' => 'uploads目录可写',
                'status'  => is_writable(public_path() . '/upload') ? true : false,
                'remark'  => '用于文件前台访问例如图片的访问，需要目录可写'
            ],
        ];

        $this->success('获取成功', [
            'list'  => [
                'server' => $server,
                'env'    => $env,
                'auth'   => $auth
            ],
            'total' => '3'
        ]);
    }



}