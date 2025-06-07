#!/bin/bash
# 工具功能说明
# 查询最近几天修改过的文件并复制到指定文件夹
# 使用方法
# chmod +x upfile.sh
# ./upfile.sh

# 目标文件夹
TARGET_DIR="recent_changes"

# 创建目标文件夹
mkdir -p "$TARGET_DIR"

# 询问需要输入的天数
read -p "请输入需要查询的天数: " DAYS

# 如果天数为空，则默认查询10天
if [ -z "$DAYS" ]; then
  DAYS=30
fi

# 找到最近30天内修改过的文件
git diff --name-only HEAD@{"$DAYS days ago"} HEAD | while read file; do
  # 检查文件是否存在（避免删除的文件被包含）
  if [ -e "$file" ]; then
    # 创建目标文件夹的目录结构
    mkdir -p "$TARGET_DIR/$(dirname "$file")"
    # 复制文件到目标文件夹
    cp "$file" "$TARGET_DIR/$file"
  fi
done

echo "最近$DAYS天内修改过的文件已复制到 $TARGET_DIR"