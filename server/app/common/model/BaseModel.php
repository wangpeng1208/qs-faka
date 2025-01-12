<?php
declare(strict_types=1);

// +----------------------------------------------------------------------
// | 骑士虚拟产品寄售商城系统开源版 
// +----------------------------------------------------------------------
// | Copyright (c) 2023-2025 https://www.qqss.net All rights reserved.
// +----------------------------------------------------------------------
// | Licensed MIT 本系统开源仅仅是为了新手学习开发商城为目的，使用时请遵循当地法律法规
// +----------------------------------------------------------------------
// | Author: QQSS <990504246@qq.com>
// +----------------------------------------------------------------------

namespace app\common\model;

use think\Model;

abstract class BaseModel extends Model
{
    // 演示模式禁止修改 新增 删除 更新数据
    public static function onBeforeWrite($model)
    {
        if (getenv('ISDEMO')) {
            throw new \Exception('演示环境不支持写入数据');
        }
    }

    public static function onBeforeUpdate($model)
    {
        if (getenv('ISDEMO')) {
            throw new \Exception('演示环境不支持修改数据');
        }
    }

    public static function onBeforeDelete($model)
    {
        if (getenv('ISDEMO')) {
            throw new \Exception('演示环境不支持删除数据');
        }
    }

    public static function onBeforeInsert($model)
    {
        if (getenv('ISDEMO')) {
            throw new \Exception('演示环境不支持新增数据');
        }
    }

}
