<?php
declare(strict_types=1);

// +----------------------------------------------------------------------
// | 骑士发卡 [ 平顶山若拉网络科技有限公司，并保留所有权利 ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016~2020 https://www.qqss.net All rights reserved.
// +----------------------------------------------------------------------
// | Licensed 骑士软件 并不是自由软件，商业用途务必到官方购买正版授权, 以免引起不必要的法律纠纷.
// +----------------------------------------------------------------------
// | Author: QQSS <admin@qqss.net>
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
