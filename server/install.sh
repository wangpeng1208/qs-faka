#!/bin/bash
echo "------------骑士发卡开源版 一键安装程序--------------------"
echo "安装须知：本系统前后端完全开源，仅供学习交流之用！
如果有bug请自行修复，此版本无任何技术支持！
如线上使用请务必遵守当地法律法规！
"
echo "开始检测环境..."
# 环境检测 
# 检测 php环境，且必须 大于等于php8.1
php_version=$(php -v | grep -oP "PHP \K[0-9]+\.[0-9]+")
IFS='.' read -ra php_version_parts <<< "$php_version"
major=${php_version_parts[0]}
minor=${php_version_parts[1]}

if ((major < 8 || (major == 8 && minor < 1))); then
    echo "PHP版本必须大于等于8.1，当前版本为 $php_version"
    exit 1
fi
# 检查MySQL是否已经安装运行
which mysql > /dev/null
if [ $? -ne 0 ]; then
    echo "MySQL没有安装或运行，自动安装已经退出"
    exit 1
fi
# 检测端口占用情况 
# 检测端口占用情况 free
ports=(8786 3014)
clear_ports="N"
for port in ${ports[@]}; do
    if lsof -Pi :$port -sTCP:LISTEN -t >/dev/null ; then
        echo -e "------------"
        echo "$port 端口已经被占用，请确认是全新安装，获取先停止$port端口服务，不然无法启动服务"
        if [ "$clear_ports" != "Y" ]; then
            echo "是否要清理该端口并继续安装？(Y/n)"
            read answer
            answer=${answer:-Y}
            if [ "$answer" == "Y" ] || [ "$answer" == "y" ]; then
                clear_ports="Y"
            else
                exit 1
            fi
        fi
        if [ "$clear_ports" == "Y" ]; then
            kill -9 $(lsof -t -i:$port)
            if [ $? -ne 0 ]; then
                echo "清理端口失败，已退出安装"
                exit 1
            else
                echo "已清理占用的 $port 端口"
            fi
        fi
    fi
done

# 执行删除禁用函数 
echo "开始执行删除禁用函数"
curl -Ss https://www.workerman.net/webman/fix-disable-functions | php

# 升级 composer
echo "开始升级composer，回车继续"
composer update

echo "提示：请确认已经创建了mysql数据库"

echo "环境通过检测，开始获取远程安装包..."
# 获取最新版本号
version=v1.5.2
if [ $? -ne 0 ]; then
    echo "获取远程版本号失败"
    exit 1
fi
echo "请输入要安装在哪个目录下，回车直接继续[默认:/www/wwwroot/qssoft-default]："
read wwwroot
wwwroot=${wwwroot:-/www/wwwroot/qssoft-default}

# 创建目录
mkdir -p $wwwroot
if [ $? -ne 0 ]; then
    echo "创建目录失败"
    exit 1
fi
# 进入目录
cd $wwwroot
# 下载文件 主链接和备用链接
links=("http://sc.soufk.com/${version}.zip" "http://sc.soufk.com/${version}.zip")

# 尝试从每个链接下载文件
for link in "${links[@]}"; do
    wget $link
    if [ $? -eq 0 ]; then
        # 下载成功，退出循环
        break
    else
        echo "从链接 $link 下载文件失败，尝试从下一个链接下载"
    fi
done

# 检查是否成功下载文件
if [ ! -f ${version}.zip ]; then
    echo "从所有链接下载文件都失败。"
    exit 1
fi
# 解压文件
unzip -o ${version}.zip
# 删除安装文件
rm -rf ${version}.zip
# 删除 composer.lock
rm -rf composer.lock
# 重命名文件
mv .env.example .env
# 提示用户输入数据库用户名
echo "[提示 终端中是鼠标右键粘贴 回车确认 ；密码类的不会显示明文，直接右键后回车即可]"
echo "请输入或粘贴 数据库用户名:"
read db_username
# 提示用户输入数据库名
echo "请输入或粘贴 数据库名:"
read db_name
# 提示用户输入数据库密码
echo "请输入或粘贴 数据库密码:"
read -s db_password
# 替换数据库用户名
sed -i "s/^USERNAME = .*$/USERNAME = ${db_username}/g" .env
# 替换数据库名
sed -i "s/^DATABASE = .*$/DATABASE = ${db_name}/g" .env
# 替换数据库密码
sed -i "s/^PASSWORD = .*$/PASSWORD = ${db_password}/g" .env
# 检测数据库链接是否正常
if ! mysql -u${db_username} -p${db_password} -e "use ${db_name};" > /dev/null 2>&1; then
    echo "数据库链接失败，请检查数据库用户名、数据库名和数据库密码是否正确"
    exit 1
fi
# 开始 还原数据库
echo "开始还原数据库"
mysql -u${db_username} -p${db_password} ${db_name} < ./mysql.sql
# 数据库还原完成
echo "数据库还原完成"
# 删除数据库文件
rm -rf ${wwwroot}/mysql.sql

# 开始安装php扩展
echo "开始composer安装php扩展，回车以继续"
composer install
# 安装完成
echo "composer安装php扩展完成"
echo  " 
安装完成。开始启动服务
如需使用域名或80端口访问，请添加反向代理
目标URL：http://127.0.0.1：8786 发送域名：\$host
"
# 启动服务
php start.php start

# 退出脚本
exit 0