# webman-validate

The webman validate Package。

基于thinkphp6全功能版，用于webman框架的validate数据验证器。
* 支持助手函数validate()
* 支持facade门面模式
* 支持场景验证scene
* 支持j表单令牌token
* 支持unquire唯一性验证(基于TP Db类)

用法完全跟tp6验证一致,更多参考https://www.kancloud.cn/manual/thinkphp6_0/1037623

## 安装
~~~
composer require taoser/webman-validate
~~~

## 用法

>定义验证器

```php
namespace app\validate;

use taoser\Validate;

class User extends Validate
{
    protected $rule = [
        'name'  =>  'require|max:25',
        'email' =>  'email',
    ];

}
```

支持创建验证器进行数据验证

```php
<?php
namespace app\index\validate;

use taoser\Validate;

class User extends Validate
{
	// 定义规则
    protected $rule =   [
        'name'  => 'require|max:25',
        'age'   => 'number|between:1,120',
        'email' => 'email',    
    ];
    
	// 定义信息
    protected $message  =   [
        'name.require' => '名称必须',
        'name.max'     => '名称最多不能超过25个字符',
        'age.number'   => '年龄必须是数字',
        'age.between'  => '年龄只能在1-120之间',
        'email'        => '邮箱格式错误',    
    ];
	
	//定义场景
	protected $scene = [
        'edit'  =>  ['name','age'],
    ];
    
}
```

验证器调用代码如下：

```php
<?php
namespace app\controller;

use app\validate\User;
use taoser\exception\ValidateException;

class Index
{
    public function index()
    {
        try {
            validate(User::class)->check([
                'name'  => 'thinkphp',
                'email' => 'thinkphp@qq.com',
            ]);
        } catch (ValidateException $e) {
            // 验证失败 输出错误信息
            dump($e->getError());
        }
    }
}


	//场景校验方法
	$data = [
		'name'  => 'thinkphp',
		'age'   => 10,
		'email' => 'thinkphp@qq.com',
	];

	try {
		validate(app\validate\User::class)
			->scene('edit')
			->check($data);
	} catch (ValidateException $e) {
		// 验证失败 输出错误信息
		dump($e->getError());
	}
	
	// 门面方法验证
	
	$validate = \taoser\facade\Validate::rule('age', 'number|between:1,120')
	->rule([
		'name'  => 'require|max:25',
		'email' => 'email'
	]);

	$data = [
		'name'  => 'thinkphp',
		'email' => 'thinkphp@qq.com'
	];

	if (!$validate->check($data)) {
		dump($validate->getError());
	}


```

更多用法可以参考6.0完全开发手册的[验证](https://www.kancloud.cn/manual/thinkphp6_0/1037623)章节


## 特别说明

感谢 ThinkPHP，webman-plugin
