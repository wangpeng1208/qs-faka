# Tefaka
> 骑士发卡免费开源版本，后端基于webman框架开发，前端基于TDesign框架开发。目标人群：对发卡需求度一般的小型企业用户免费开放后端源码。注释清晰方便二次开发。

tag:发卡源码，vue版发卡源码，高性能发卡源码，企业发卡源码

#### 运行环境要求

*  PHP8.0。 禁用函数删除 putenv proc_open pcntl_signal pcntl_signal_dispatch pcntl_wait， php 安装扩展fileinfo、redis
* nginx 最新版
* mysql > 5.7 ，推荐MariaDB



# 安装方法

* BT后台 添加站点 php版本-静态 ，创建一个mysql数据库。
* 将程序放到 该站点目录下。打开命令行 使用 php start.php start -d 命令启动。
* 数据库
    还原sql到数据库中（数据库文件在 public/static/mysql.sql）
    在.env.example 改名为 .env 配置数据库配置
* 设置网站
    反向代理  目标URL : http://127.0.0.1:8787
* 启动服务
    php start.php start -d
* 喝杯咖啡


# 访问地址

### 后台访问地址：

http://域名/admin/login

### 商户后台访问地址

http://域名/merchant/login



## 主要特性

有详细的代码注释，有完整系统手册
### Webman框架
使用最新的 Webman 框架开发
### 前端采用Vue CLI框架
前端使用Vue CLI框架nodejs打包，页面加载更流畅，用户体验更好
### 标准接口
标准接口、前后端分离，二次开发更方便
### 支持邮件发送
### 支持短信发送
### 支持事件机制
行为扩展更方便，方便二次开发
### 强大的后台权限管理和商户管理权限后台
后台多种角色、多重身份权限管理，权限精确到了按钮
### 支持composer
支持使用composer安装插件



#### 设计规范
* 控制器与验证与前台目录；方法与权限 需要一一对应
* 返回数据使用 HttpResponseException()

#### 语法规范
* 需要记录访问日志的方法 注释 携带 @notes，
* 需要验证权限的方法 注释 携带@auth的验证权限；示例
~~~
    /**
     * @notes 中文注释
     * @auth true
     */
    public function index()
    {
        return json('hello world');
    }
~~~


# 帮助

### 环境变量文件

 * .env文件更改后，需要重启服务。

### composer 后 input函数无法使用

*  注释掉 /support/helpers.php 内的input函数。

### 命令

. 启动服务 ：  php start.php start -d

``````
-------------------------------------------- WORKERMAN --------------------------------------------
Workerman version:4.1.15          PHP version:8.0.26           Event-Loop:\Workerman\Events\Select
--------------------------------------------- WORKERS ---------------------------------------------
proto   user            worker          listen                 processes    status           
tcp     root            webmans         http://0.0.0.0:8787    8             [OK]            
tcp     root            monitor         none                   1             [OK]            
tcp     root            rpc             text://0.0.0.0:3015    8             [OK]            
---------------------------------------------------------------------------------------------------
``````

. 停止服务 ：   php start.php stop

#### 网站其他命令

. 创建自动提现 ：  php start.php auto:cash

. 自动代付任务 ：   php start.php auto:daifu

. 自动解冻订单金额 ：  php start.php  unfreeze:money

. 更多命令详见： php start.php list

### 目录文件结构


```
.
├── app                           应用目录
├── public                        静态资源目录
│   ├── static                    系统初始静态资源目录
│   ├── upload                    文件上传目录
│   └── web                       网站前台目录
└── runtime                       应用的运行时目录，需要可写权限
│   ├── logs                      系统运行日志及站点日志目录
│   ├── crt                       证书目录
│   └── file                      下载缓存目录
└── .env                          环境变量文件
```
### 开源版联系方式
* 可提供部分技术帮助
* QQ 990504246
* 平顶山若拉网络科技有限公司 开发

### 授权版本联系方式

* QQ 286204069
* 微信 echo-todo
* 诚邀同行共建高性能发卡项目


All rights reserved。

本项目包含的第三方源码和二进制文件之版权信息另行标注。

QSSOFT® 商标和著作权所有者为平顶山若拉网络科技有限公司。