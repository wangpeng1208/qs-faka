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

namespace app\adminapi\controller;

use app\service\common\UploadService;

class Upload extends Base
{
    /**
     * 文件上传
     * @auth false
     */
    public function upload()
    {
        $app     = 'admin';
        $file    = request()->file('file');
        $type    = inputs('type', 'image');
        $user_id = $this->user->id;
        if ($file && $file->isValid()) {
            try {
                $url = (new UploadService())->upload($app, $file, $type, $user_id);
            } catch (\Exception $e) {
                $this->error($e->getMessage(), [
                    'error' => $e->getMessage(),
                ]);
            }
            $this->success('上传成功', ['url' => $url]);
        } else {
            $this->error('请选择文件');
        }
    }

}