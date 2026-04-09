/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `admin_log` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `ip` char(15) NOT NULL DEFAULT '' COMMENT '操作者IP地址',
  `params` varchar(255) DEFAULT '',
  `username` varchar(32) NOT NULL DEFAULT '' COMMENT '操作人用户名',
  `action` varchar(200) NOT NULL DEFAULT '' COMMENT '操作行为',
  `content` text NOT NULL COMMENT '操作内容描述',
  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COMMENT='系统操作日志表';
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `admin_log` WRITE;
/*!40000 ALTER TABLE `admin_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `admin_log` ENABLE KEYS */;
UNLOCK TABLES;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `admin_menu` (
  `id` mediumint NOT NULL AUTO_INCREMENT,
  `user_id` mediumint NOT NULL,
  `menu_id` mediumint NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=60 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='用户快捷菜单';
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `admin_menu` WRITE;
/*!40000 ALTER TABLE `admin_menu` DISABLE KEYS */;
INSERT INTO `admin_menu` VALUES (40,1,38),(41,1,35),(42,1,40),(43,1,43),(47,1,47),(49,1,62),(50,1,135),(51,1,98),(52,1,150),(53,1,89),(54,1,67),(55,1,39),(56,1,69),(57,1,76),(58,1,136);
/*!40000 ALTER TABLE `admin_menu` ENABLE KEYS */;
UNLOCK TABLES;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `admin_role_relation` (
  `id` int NOT NULL AUTO_INCREMENT COMMENT '主键',
  `role_id` int NOT NULL COMMENT '角色id',
  `admin_id` int NOT NULL COMMENT '管理员id',
  PRIMARY KEY (`id`),
  UNIQUE KEY `role_admin_id` (`role_id`,`admin_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='管理员角色表';
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `admin_role_relation` WRITE;
/*!40000 ALTER TABLE `admin_role_relation` DISABLE KEYS */;
INSERT INTO `admin_role_relation` VALUES (1,1,1);
/*!40000 ALTER TABLE `admin_role_relation` ENABLE KEYS */;
UNLOCK TABLES;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `admin_roles` (
  `id` int unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `name` varchar(80) COLLATE utf8mb4_general_ci NOT NULL COMMENT '角色组',
  `rules` text COLLATE utf8mb4_general_ci COMMENT '权限',
  `created_at` datetime NOT NULL COMMENT '创建时间',
  `updated_at` datetime NOT NULL COMMENT '更新时间',
  `pid` int unsigned DEFAULT NULL COMMENT '父级',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='管理员角色';
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `admin_roles` WRITE;
/*!40000 ALTER TABLE `admin_roles` DISABLE KEYS */;
INSERT INTO `admin_roles` VALUES (1,'超级管理员','*','2022-08-13 16:15:01','2022-12-23 12:05:07',0);
/*!40000 ALTER TABLE `admin_roles` ENABLE KEYS */;
UNLOCK TABLES;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `admin_user` (
  `id` int unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `username` varchar(32) COLLATE utf8mb4_general_ci NOT NULL COMMENT '用户名',
  `nickname` varchar(40) COLLATE utf8mb4_general_ci NOT NULL COMMENT '昵称',
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL COMMENT '密码',
  `avatar` varchar(255) COLLATE utf8mb4_general_ci DEFAULT '/app/admin/avatar.png' COMMENT '头像',
  `email` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT '邮箱',
  `mobile` varchar(16) COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT '手机',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `login_at` datetime DEFAULT NULL COMMENT '登录时间',
  `status` tinyint DEFAULT '1' COMMENT '禁用',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='管理员表';
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `admin_user` WRITE;
/*!40000 ALTER TABLE `admin_user` DISABLE KEYS */;
INSERT INTO `admin_user` VALUES (1,'admin','超级管理员','$2y$10$Nm1O59pvJimLXHGmb0/a2OEdbw1VSwzNJsK0qkeyjUSn16/HimuRG','/static/common/images/noavatar.svg','','','2023-04-29 17:09:09','2024-02-18 15:16:51','2024-02-18 15:16:51',NULL);
/*!40000 ALTER TABLE `admin_user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `article` (
  `id` int unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `cate_id` int unsigned NOT NULL DEFAULT '0' COMMENT '文章栏目',
  `title` varchar(50) NOT NULL DEFAULT '' COMMENT '文章标题',
  `title_img` varchar(255) NOT NULL DEFAULT '' COMMENT '标题图',
  `content` text NOT NULL COMMENT '文章内容',
  `status` tinyint NOT NULL DEFAULT '0' COMMENT '文章状态',
  `views` int unsigned NOT NULL DEFAULT '0' COMMENT '浏览量',
  `create_at` int unsigned NOT NULL COMMENT '创建时间',
  `update_at` int unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `is_system` tinyint(1) NOT NULL DEFAULT '0' COMMENT '系统调用',
  `top` tinyint(1) NOT NULL DEFAULT '0' COMMENT '置顶',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COMMENT='文章表';
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `article` WRITE;
/*!40000 ALTER TABLE `article` DISABLE KEYS */;
/*!40000 ALTER TABLE `article` ENABLE KEYS */;
UNLOCK TABLES;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `article_category` (
  `id` int unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `pid` int unsigned NOT NULL DEFAULT '0' COMMENT '父ID',
  `path` varchar(1024) NOT NULL COMMENT '路径',
  `name` varchar(30) NOT NULL DEFAULT '' COMMENT '名称',
  `alias` varchar(30) NOT NULL DEFAULT '' COMMENT '别名',
  `remark` varchar(255) NOT NULL DEFAULT '' COMMENT '备注',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态',
  `create_at` int unsigned NOT NULL COMMENT '创建时间',
  `update_at` int unsigned DEFAULT '0' COMMENT '更新时间',
  `type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1前台列表；2后台列表；3单页',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COMMENT='文章栏目表';
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `article_category` WRITE;
/*!40000 ALTER TABLE `article_category` DISABLE KEYS */;
/*!40000 ALTER TABLE `article_category` ENABLE KEYS */;
UNLOCK TABLES;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `article_read` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `news_id` int DEFAULT NULL,
  `create_time` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `article_read` WRITE;
/*!40000 ALTER TABLE `article_read` DISABLE KEYS */;
/*!40000 ALTER TABLE `article_read` ENABLE KEYS */;
UNLOCK TABLES;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `goods` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int unsigned NOT NULL,
  `cate_id` int unsigned NOT NULL,
  `theme` varchar(15) NOT NULL DEFAULT 'default' COMMENT '主题',
  `sort` int unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `name` varchar(500) NOT NULL DEFAULT '',
  `price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00',
  `cost_price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '成本价',
  `wholesale_discount` tinyint unsigned NOT NULL DEFAULT '0' COMMENT '批发优惠',
  `wholesale_discount_list` varchar(255) DEFAULT NULL COMMENT '批发价',
  `limit_quantity_max` int NOT NULL DEFAULT '0' COMMENT '限购数量',
  `limit_quantity` int unsigned NOT NULL DEFAULT '0' COMMENT '起购数量',
  `inventory_notify` tinyint unsigned NOT NULL DEFAULT '0' COMMENT '库存预警 0表示不报警',
  `inventory_notify_type` tinyint unsigned NOT NULL DEFAULT '1' COMMENT '库存预警通知方式 1站内信 2邮件',
  `coupon_type` tinyint unsigned NOT NULL DEFAULT '0' COMMENT '优惠券 0不支持 1支持',
  `sold_notify` tinyint unsigned NOT NULL DEFAULT '0' COMMENT '售出通知',
  `take_card_type` tinyint unsigned NOT NULL DEFAULT '0' COMMENT '取卡密码 0关闭 1必填 2选填',
  `visit_type` tinyint unsigned NOT NULL DEFAULT '0' COMMENT '访问密码',
  `visit_password` varchar(30) NOT NULL DEFAULT '' COMMENT '访问密码',
  `contact_limit` enum('mobile','email','qq','any','default') NOT NULL DEFAULT 'default' COMMENT '客户信息',
  `content` text NOT NULL COMMENT '商品说明',
  `remark` varchar(200) NOT NULL DEFAULT '' COMMENT '使用说明',
  `status` tinyint NOT NULL DEFAULT '1' COMMENT '0下架 1上架',
  `create_at` int unsigned NOT NULL DEFAULT '0',
  `is_freeze` tinyint DEFAULT '0',
  `sms_payer` tinyint unsigned NOT NULL DEFAULT '0' COMMENT '短信付费方：0买家 1商户',
  `delete_at` int DEFAULT NULL COMMENT '删除标记',
  `card_order` tinyint NOT NULL DEFAULT '0' COMMENT '发卡顺序 0现卖老卡 1先卖新卡',
  `event_give` varchar(255) DEFAULT NULL COMMENT '活动赠送',
  `addtion_give` varchar(255) DEFAULT NULL COMMENT '附加赠送',
  `mobile_theme` varchar(255) NOT NULL DEFAULT 'default',
  PRIMARY KEY (`id`),
  KEY `cate_id` (`cate_id`) USING BTREE,
  KEY `user_id` (`user_id`) USING BTREE,
  KEY `stauts` (`status`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `goods` WRITE;
/*!40000 ALTER TABLE `goods` DISABLE KEYS */;
/*!40000 ALTER TABLE `goods` ENABLE KEYS */;
UNLOCK TABLES;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `goods_card` (
  `id` int unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `user_id` int unsigned NOT NULL COMMENT '用户id',
  `goods_id` int unsigned NOT NULL COMMENT '商品id',
  `number` text COMMENT '卡号',
  `secret` text COMMENT '卡密',
  `status` tinyint NOT NULL DEFAULT '1' COMMENT '-1删除 0不可用 1可用 2已使用',
  `create_at` int unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `delete_at` int DEFAULT NULL COMMENT '删除标记',
  `sell_time` int DEFAULT NULL COMMENT '售出时间',
  `is_cross` tinyint DEFAULT '0',
  `is_first` int DEFAULT '0' COMMENT '优先销售',
  `unfreeze_at` int DEFAULT '0' COMMENT '锁卡时间',
  `is_pre` smallint NOT NULL DEFAULT '0' COMMENT '是否显示前缀',
  PRIMARY KEY (`id`),
  KEY `goods_card_goods_id_index` (`goods_id`),
  KEY `delete_at` (`delete_at`),
  KEY `unfreeze_at` (`unfreeze_at`),
  KEY `idx_goods_status_unfreeze_delete` (`goods_id`,`status`,`unfreeze_at`,`delete_at`),
  KEY `status` (`status`),
  KEY `idx_user_status_delete` (`user_id`,`status`,`delete_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `goods_card` WRITE;
/*!40000 ALTER TABLE `goods_card` DISABLE KEYS */;
/*!40000 ALTER TABLE `goods_card` ENABLE KEYS */;
UNLOCK TABLES;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `goods_category` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int unsigned NOT NULL,
  `name` varchar(100) NOT NULL,
  `sort` int unsigned NOT NULL DEFAULT '0',
  `status` tinyint NOT NULL,
  `create_at` int unsigned NOT NULL,
  `theme` varchar(15) NOT NULL DEFAULT 'default' COMMENT '主题',
  `mobile_theme` varchar(50) NOT NULL DEFAULT '' COMMENT '手机版主题',
  `is_show` tinyint(1) NOT NULL DEFAULT '1' COMMENT '首页显示1，不显示0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `goods_category` WRITE;
/*!40000 ALTER TABLE `goods_category` DISABLE KEYS */;
/*!40000 ALTER TABLE `goods_category` ENABLE KEYS */;
UNLOCK TABLES;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `goods_coupon` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int unsigned NOT NULL,
  `cate_id` int unsigned NOT NULL DEFAULT '0' COMMENT '全部',
  `type` tinyint unsigned NOT NULL DEFAULT '1' COMMENT '类型 1、元  100、%',
  `amount` decimal(10,2) unsigned NOT NULL DEFAULT '0.00',
  `code` varchar(255) NOT NULL DEFAULT '',
  `remark` varchar(100) NOT NULL DEFAULT '' COMMENT '备注',
  `status` tinyint unsigned NOT NULL DEFAULT '1' COMMENT '1未使用 2已用',
  `expire_at` int unsigned NOT NULL,
  `create_at` int unsigned NOT NULL,
  `delete_at` int DEFAULT NULL COMMENT '删除标记',
  `min_banlance` int DEFAULT '0' COMMENT '最低使用限额',
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id` (`user_id`,`code`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `goods_coupon` WRITE;
/*!40000 ALTER TABLE `goods_coupon` DISABLE KEYS */;
/*!40000 ALTER TABLE `goods_coupon` ENABLE KEYS */;
UNLOCK TABLES;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `order` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int unsigned NOT NULL,
  `goods_id` int unsigned NOT NULL,
  `trade_no` varchar(255) DEFAULT NULL,
  `transaction_id` varchar(60) NOT NULL DEFAULT '' COMMENT '流水号',
  `paytype` tinyint unsigned NOT NULL DEFAULT '0',
  `channel_id` int unsigned NOT NULL DEFAULT '0' COMMENT '支付渠道',
  `channel_account_id` int unsigned NOT NULL DEFAULT '0' COMMENT '渠道账号',
  `goods_name` varchar(500) NOT NULL DEFAULT '' COMMENT '商品名称',
  `goods_price` decimal(10,3) unsigned NOT NULL DEFAULT '0.000' COMMENT '商品单价',
  `goods_cost_price` decimal(10,3) unsigned NOT NULL DEFAULT '0.000' COMMENT '成本价',
  `quantity` int unsigned NOT NULL DEFAULT '0' COMMENT '数量',
  `coupon_type` tinyint unsigned NOT NULL DEFAULT '0' COMMENT '是否使用优惠券',
  `coupon_id` int unsigned NOT NULL DEFAULT '0' COMMENT '优惠券ID',
  `coupon_price` decimal(10,3) unsigned NOT NULL DEFAULT '0.000' COMMENT '优惠价格',
  `total_price` decimal(10,3) unsigned NOT NULL DEFAULT '0.000' COMMENT '总价（买家实付款）',
  `total_cost_price` decimal(10,3) unsigned NOT NULL DEFAULT '0.000' COMMENT '总成本价',
  `sold_notify` tinyint unsigned NOT NULL DEFAULT '0' COMMENT '售出通知（买家）',
  `take_card_type` tinyint unsigned NOT NULL DEFAULT '0' COMMENT '是否需要取卡密码',
  `take_card_password` varchar(20) NOT NULL DEFAULT '' COMMENT '取卡密码',
  `contact` varchar(20) NOT NULL DEFAULT '' COMMENT '联系方式',
  `email_notify` tinyint unsigned NOT NULL DEFAULT '0' COMMENT '是否邮件通知',
  `email` varchar(60) NOT NULL DEFAULT '' COMMENT '邮箱号',
  `sms_notify` tinyint unsigned NOT NULL DEFAULT '0' COMMENT '是否短信通知',
  `rate` decimal(10,4) unsigned NOT NULL DEFAULT '0.0000' COMMENT '手续费率',
  `fee` decimal(10,3) unsigned NOT NULL DEFAULT '0.000' COMMENT '手续费',
  `sms_price` decimal(10,3) unsigned NOT NULL DEFAULT '0.000' COMMENT '短信费',
  `status` tinyint NOT NULL DEFAULT '0' COMMENT '订单状态 0未支付 1已支付 2已关闭 3已退款',
  `is_freeze` tinyint unsigned NOT NULL DEFAULT '0' COMMENT '冻结状态',
  `create_at` int unsigned NOT NULL COMMENT '创建时间',
  `create_ip` varchar(15) NOT NULL DEFAULT '' COMMENT 'IP',
  `success_at` int unsigned NOT NULL DEFAULT '0' COMMENT '支付成功时间',
  `first_query` tinyint NOT NULL DEFAULT '0' COMMENT '订单第一次查询无需验证码',
  `sms_payer` tinyint unsigned NOT NULL DEFAULT '0' COMMENT '短信付费方：0买家 1商户',
  `total_product_price` decimal(10,3) unsigned NOT NULL DEFAULT '0.000' COMMENT '商品总价（不含短信费）',
  `sendout` int unsigned NOT NULL DEFAULT '0' COMMENT '已发货数量',
  `fee_payer` tinyint NOT NULL DEFAULT '1' COMMENT '订单手续费支付方，1：商家承担，2买家承担',
  `settlement_type` tinyint unsigned NOT NULL DEFAULT '1' COMMENT '结算方式，1:T1结算，0:T0结算',
  `finally_money` decimal(10,4) NOT NULL DEFAULT '0.0000' COMMENT '商户订单最终收入（已扣除短信费，手续费）',
  PRIMARY KEY (`id`),
  KEY `order_create_at_index` (`create_at`),
  KEY `index_contract` (`contact`,`status`) USING BTREE,
  KEY `index_tp_count` (`user_id`,`status`,`success_at`,`channel_id`) USING BTREE,
  KEY `user_id` (`user_id`) USING BTREE,
  KEY `goods_id` (`goods_id`) USING BTREE,
  KEY `trade_no` (`trade_no`) USING BTREE,
  KEY `channel_id` (`channel_id`) USING BTREE,
  KEY `status` (`status`) USING BTREE,
  KEY `is_freeze` (`is_freeze`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `order` WRITE;
/*!40000 ALTER TABLE `order` DISABLE KEYS */;
/*!40000 ALTER TABLE `order` ENABLE KEYS */;
UNLOCK TABLES;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `order_card` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `order_id` int unsigned NOT NULL,
  `number` text,
  `secret` text,
  `card_id` int NOT NULL DEFAULT '0' COMMENT '虚拟卡ID',
  PRIMARY KEY (`id`),
  KEY `order_card_order_id_index` (`order_id`),
  KEY `order_card_card_id_index` (`card_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `order_card` WRITE;
/*!40000 ALTER TABLE `order_card` DISABLE KEYS */;
/*!40000 ALTER TABLE `order_card` ENABLE KEYS */;
UNLOCK TABLES;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `order_complaint` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int unsigned NOT NULL,
  `trade_no` char(50) NOT NULL DEFAULT '',
  `type` varchar(20) NOT NULL DEFAULT '',
  `qq` varchar(15) NOT NULL DEFAULT '',
  `mobile` varchar(15) NOT NULL DEFAULT '',
  `desc` varchar(1000) NOT NULL DEFAULT '',
  `status` tinyint NOT NULL DEFAULT '0' COMMENT '0待处理 1已处理',
  `admin_read` tinyint unsigned NOT NULL DEFAULT '0' COMMENT '管理员查看状态',
  `create_at` int unsigned NOT NULL,
  `create_ip` varchar(15) NOT NULL DEFAULT '',
  `pwd` char(10) NOT NULL DEFAULT '123456' COMMENT '投诉单查询密码',
  `result` tinyint NOT NULL DEFAULT '0' COMMENT '申诉结果',
  `expire_at` int unsigned NOT NULL DEFAULT '0' COMMENT '申诉过期时间',
  `proxy_parent_user_id` int unsigned NOT NULL DEFAULT '0' COMMENT '上级代理商ID',
  `buyer_qrcode` varchar(1000) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `order_complaint` WRITE;
/*!40000 ALTER TABLE `order_complaint` DISABLE KEYS */;
/*!40000 ALTER TABLE `order_complaint` ENABLE KEYS */;
UNLOCK TABLES;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `order_complaint_message` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `trade_no` varchar(255) NOT NULL DEFAULT '0' COMMENT '投诉所属订单',
  `from` int unsigned NOT NULL DEFAULT '0' COMMENT '发送人，0为管理员发送的消息',
  `content` varchar(1024) NOT NULL DEFAULT '' COMMENT '对话内容',
  `status` tinyint NOT NULL DEFAULT '0' COMMENT '0未读  1已读',
  `create_at` int unsigned NOT NULL DEFAULT '0' COMMENT '发送时间',
  `type` varchar(255) NOT NULL DEFAULT '0' COMMENT '消息属性：admin merchant',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COMMENT='投诉会话信息';
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `order_complaint_message` WRITE;
/*!40000 ALTER TABLE `order_complaint_message` DISABLE KEYS */;
/*!40000 ALTER TABLE `order_complaint_message` ENABLE KEYS */;
UNLOCK TABLES;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `order_master` (
  `id` int NOT NULL AUTO_INCREMENT,
  `trade_no` varchar(255) DEFAULT NULL,
  `model` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `order_master` WRITE;
/*!40000 ALTER TABLE `order_master` DISABLE KEYS */;
/*!40000 ALTER TABLE `order_master` ENABLE KEYS */;
UNLOCK TABLES;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pay_auto_unfreeze` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  `money` decimal(10,3) unsigned NOT NULL DEFAULT '0.000' COMMENT '冻结金额',
  `unfreeze_time` int NOT NULL DEFAULT '0' COMMENT '解冻时间',
  `created_at` int NOT NULL DEFAULT '0' COMMENT '更新时间',
  `trade_no` varchar(255) NOT NULL DEFAULT '0' COMMENT '冻结资金来源订单号',
  `status` tinyint NOT NULL DEFAULT '1' COMMENT '冻结资金记录状态，1：可用，-1：不可用（订单申诉中等情况）',
  PRIMARY KEY (`id`),
  KEY `unfreeze_time` (`unfreeze_time`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COMMENT='订单金额T+1日自动解冻表';
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `pay_auto_unfreeze` WRITE;
/*!40000 ALTER TABLE `pay_auto_unfreeze` DISABLE KEYS */;
/*!40000 ALTER TABLE `pay_auto_unfreeze` ENABLE KEYS */;
UNLOCK TABLES;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pay_channel` (
  `id` int unsigned NOT NULL AUTO_INCREMENT COMMENT '通道ID',
  `title` varchar(255) NOT NULL DEFAULT '' COMMENT '通道名称',
  `code` varchar(50) NOT NULL DEFAULT '' COMMENT '通道代码',
  `status` tinyint unsigned NOT NULL DEFAULT '0' COMMENT '状态 1 开启 0 关闭',
  `lowrate` decimal(10,4) unsigned NOT NULL DEFAULT '0.0000' COMMENT '充值费率',
  `accounting_date` tinyint unsigned NOT NULL DEFAULT '1' COMMENT '结算时间 1、D0 2、D1 3、T0 4、T1',
  `account_fields` varchar(1024) NOT NULL DEFAULT '' COMMENT '账户字段',
  `updatetime` int unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `paytype` tinyint unsigned NOT NULL DEFAULT '0' COMMENT '支付类型 1 微信扫码 2 微信公众号 3 支付宝扫码 4 支付宝手机 5 网银支付 6',
  `show_name` varchar(255) NOT NULL DEFAULT '' COMMENT '前台展示名称',
  `is_available` tinyint NOT NULL DEFAULT '0' COMMENT '接口可用 0通用 1手机 2电脑',
  `default_fields` varchar(1024) NOT NULL DEFAULT '' COMMENT '字段默认值',
  `sort` int NOT NULL DEFAULT '0' COMMENT '渠道排序',
  `type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '类型：1支付，2提现',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb3 COMMENT='支付网关';
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `pay_channel` WRITE;
/*!40000 ALTER TABLE `pay_channel` DISABLE KEYS */;
INSERT INTO `pay_channel` VALUES (2,'打款','AliTransfer',1,0.0000,1,'支付宝app_id:app_id|应用秘钥:app_secret_cert|应用公钥证书:app_public_cert_path|支付宝公钥证书:alipay_public_cert_path|支付宝根证书:alipay_root_cert_path',0,1,'支付宝证书转账',0,'',0,2),(12,'支付宝','支付宝H',1,0.0020,1,'1',0,2,'支付宝',1,'',12,1);
/*!40000 ALTER TABLE `pay_channel` ENABLE KEYS */;
UNLOCK TABLES;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pay_channel_account` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `channel_id` int unsigned NOT NULL COMMENT '渠道ID',
  `name` varchar(32) NOT NULL DEFAULT '' COMMENT '账户名',
  `params` text NOT NULL COMMENT '参数',
  `status` tinyint unsigned NOT NULL DEFAULT '0' COMMENT '状态 1启用 0禁用',
  `lowrate` decimal(10,4) unsigned NOT NULL DEFAULT '0.0000' COMMENT '充值费率',
  `rate_type` tinyint NOT NULL DEFAULT '0' COMMENT '费率设置 0 继承接口  1单独设置',
  `user_id` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `pay_channel_account` WRITE;
/*!40000 ALTER TABLE `pay_channel_account` DISABLE KEYS */;
/*!40000 ALTER TABLE `pay_channel_account` ENABLE KEYS */;
UNLOCK TABLES;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pay_type` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL COMMENT '支付名',
  `logo` varchar(255) NOT NULL DEFAULT '' COMMENT 'logo',
  `ico` varchar(255) NOT NULL DEFAULT '' COMMENT '图标',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb3 COMMENT='支付类型表';
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `pay_type` WRITE;
/*!40000 ALTER TABLE `pay_type` DISABLE KEYS */;
INSERT INTO `pay_type` VALUES (2,'支付宝H5','/static/payment/icon_zfb.jpg','/static/payment/zfb.png'),(3,'微信','/static/payment/icon_wx.jpg','/static/payment/wx.png'),(4,'微信H5','/static/payment/icon_wx.jpg','/static/payment/wx.png'),(5,'QQ钱包扫码','/static/payment/icon_qq.jpg','/static/payment/qq.png'),(6,'QQ钱包H5','/static/payment/icon_qq.jpg','/static/payment/qq.png'),(7,'网银支付','/static/payment/icon_bank.jpg','/static/payment/bank.png'),(9,'京东钱包','/static/payment/icon_jd.jpg','/static/payment/icon_jd.jpg'),(10,'度小满支付','/static/payment/icon_bd.jpg','/static/payment/bd.png');
/*!40000 ALTER TABLE `pay_type` ENABLE KEYS */;
UNLOCK TABLES;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `shop_iplist` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `ip` varchar(255) DEFAULT NULL,
  `user_id` int unsigned NOT NULL,
  `create_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=804 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `shop_iplist` WRITE;
/*!40000 ALTER TABLE `shop_iplist` DISABLE KEYS */;
INSERT INTO `shop_iplist` VALUES (1,'115.58.213.18',3,1713875484),(2,'115.58.213.18',3,1713902288),(3,'115.58.213.18',4,1713902641),(4,'220.196.160.95',4,1713912185),(5,'115.59.168.26',4,1713984252),(6,'115.59.168.26',4,1713984273),(7,'115.59.168.26',4,1713984283),(8,'115.59.168.26',4,1713984303),(9,'115.59.168.26',4,1713984304),(10,'115.59.168.26',4,1713984305),(11,'115.59.168.26',4,1713984317),(12,'115.59.168.26',4,1713984329),(13,'115.59.168.26',4,1713984372),(14,'115.59.168.26',4,1713984725),(15,'115.59.168.26',4,1713984756),(16,'115.59.168.26',4,1713984921),(17,'115.59.168.26',4,1713984927),(18,'115.59.168.26',4,1713984933),(19,'115.59.168.26',4,1713984938),(20,'115.59.168.26',4,1713984942),(21,'115.59.168.26',4,1713985054),(22,'115.59.168.26',4,1713985056),(23,'115.59.168.26',4,1713985063),(24,'115.59.168.26',4,1713985089),(25,'115.59.168.26',4,1713985155),(26,'115.59.168.26',4,1713985196),(27,'115.59.168.26',4,1713985256),(28,'115.59.168.26',4,1713985260),(29,'115.59.168.26',4,1713985298),(30,'115.59.168.26',4,1713985358),(31,'115.59.168.26',4,1713985384),(32,'115.59.168.26',4,1713985542),(33,'115.59.168.26',4,1713985553),(34,'115.59.168.26',4,1713985562),(35,'115.59.168.26',4,1713985582),(36,'115.59.168.26',4,1713985602),(37,'115.59.168.26',4,1713985615),(38,'115.59.168.26',4,1713985638),(39,'115.59.168.26',4,1713985685),(40,'115.59.168.26',4,1713985809),(41,'115.59.168.26',4,1713985851),(42,'115.59.168.26',4,1713985853),(43,'115.59.168.26',4,1713985855),(44,'115.59.168.26',4,1713985873),(45,'116.9.79.16',5,1714228582),(46,'116.9.79.16',5,1714228630),(47,'116.9.79.16',5,1714228699),(48,'116.9.79.16',5,1714228732),(49,'171.110.9.181',7,1715100519),(50,'171.110.9.181',7,1715100565),(51,'171.110.9.181',7,1715100570),(52,'171.110.9.181',7,1715100573),(53,'171.110.9.181',7,1715100593),(54,'171.110.9.181',7,1715100636),(55,'112.3.69.95',8,1715173103),(56,'112.3.69.95',8,1715173105),(57,'112.3.69.95',8,1715173121),(58,'112.3.69.95',8,1715173126),(59,'112.3.69.95',8,1715173128),(60,'112.3.69.95',8,1715173278),(61,'117.61.24.27',9,1715186720),(62,'117.61.24.27',9,1715186768),(63,'1.196.5.184',10,1715326871),(64,'1.196.5.184',10,1715326907),(65,'171.110.9.181',7,1715356703),(66,'171.110.9.181',7,1715356709),(67,'171.110.9.181',7,1715356711),(68,'183.9.75.117',11,1715450377),(69,'183.9.75.117',11,1715450381),(70,'183.9.75.117',11,1715450398),(71,'39.144.160.197',14,1715618208),(72,'39.144.160.197',14,1715618211),(73,'39.144.160.197',14,1715618232),(74,'117.28.220.54',15,1715850627),(75,'117.28.220.54',15,1715850666),(76,'117.28.220.54',15,1715850710),(77,'1.207.78.121',16,1716129810),(78,'183.147.219.201',17,1716400643),(79,'183.147.219.201',17,1716400646),(80,'183.147.219.201',17,1716400652),(81,'116.23.170.133',18,1716450442),(82,'116.23.170.133',18,1716450450),(83,'220.196.160.117',18,1716460952),(84,'220.196.160.76',18,1716476078),(85,'125.74.226.43',9,1716751636),(86,'125.74.226.43',9,1716771542),(87,'117.153.11.24',20,1716788181),(88,'117.153.11.24',20,1716788192),(89,'117.153.11.24',20,1716788193),(90,'117.153.11.24',20,1716788197),(91,'117.153.11.24',20,1716788211),(92,'59.83.208.106',9,1716792883),(93,'221.14.243.197',21,1716797318),(94,'221.14.243.197',21,1716797321),(95,'221.14.243.197',21,1716798659),(96,'182.122.96.158',1,1716903643),(97,'182.122.96.158',1,1716903832),(98,'202.97.159.66',26,1717034056),(99,'202.97.159.66',26,1717034403),(100,'202.97.159.66',26,1717034485),(101,'202.97.159.66',26,1717034640),(102,'220.196.160.61',26,1717034718),(103,'116.8.49.10',29,1717057225),(104,'116.8.49.10',29,1717057308),(105,'183.147.218.58',17,1717079095),(106,'183.147.218.58',17,1717079107),(107,'183.147.218.58',17,1717079118),(108,'220.196.160.84',17,1717088734),(109,'117.61.195.133',9,1717326167),(110,'220.196.160.117',9,1717347816),(111,'1.197.130.27',33,1717661558),(112,'1.197.130.27',33,1717661657),(113,'1.197.130.27',33,1717661669),(114,'123.162.214.61',34,1717789102),(115,'123.162.214.61',34,1717789106),(116,'123.162.214.61',34,1717789158),(117,'123.162.214.61',34,1717789161),(118,'123.162.214.61',34,1717789164),(119,'123.162.214.61',34,1717789285),(120,'123.162.214.61',34,1717789287),(121,'123.162.214.61',34,1717789293),(122,'123.162.214.61',34,1717789295),(123,'220.196.160.101',34,1717794104),(124,'125.47.188.5',1,1717976610),(125,'125.47.188.5',1,1717976616),(126,'125.47.188.5',1,1717976622),(127,'123.162.215.18',34,1717978799),(128,'123.162.215.18',34,1717978804),(129,'123.162.215.18',34,1717978807),(130,'222.139.2.82',37,1718011878),(131,'223.89.118.186',38,1718103500),(132,'14.134.17.13',39,1718116286),(133,'42.233.170.104',37,1718116493),(134,'125.45.144.20',34,1718250558),(135,'202.97.159.66',26,1718344723),(136,'116.11.83.213',39,1718560272),(137,'116.11.83.213',39,1718560286),(138,'116.11.83.213',39,1718560302),(139,'116.11.83.213',39,1718560340),(140,'144.52.146.100',37,1719747074),(141,'144.52.146.100',37,1719747155),(142,'144.52.146.100',37,1719747167),(143,'144.52.146.100',37,1719747217),(144,'144.52.146.100',37,1719749729),(145,'144.52.146.100',37,1719749735),(146,'144.52.146.100',37,1719749742),(147,'180.101.245.249',37,1719756040),(148,'111.194.205.111',34,1720097552),(149,'115.58.229.79',2,1720097822),(150,'115.58.229.79',2,1720097854),(151,'115.58.229.79',2,1720097870),(152,'59.83.208.107',34,1720097896),(153,'115.58.229.79',2,1720097908),(154,'123.5.50.243',2,1720182187),(155,'112.224.199.82',2,1720184360),(156,'112.113.15.107',2,1720184615),(157,'58.16.15.32',2,1720203303),(158,'219.156.249.187',2,1720237295),(159,'223.149.150.220',2,1720240640),(160,'220.196.160.84',2,1720247726),(161,'123.5.50.243',2,1720269826),(162,'123.5.50.243',2,1720269841),(163,'123.5.50.243',2,1720269866),(164,'183.253.15.241',2,1720279753),(165,'223.97.181.140',2,1720285784),(166,'223.97.181.140',2,1720285821),(167,'223.97.181.140',2,1720285827),(168,'220.196.160.124',2,1720288318),(169,'183.209.125.255',2,1720292665),(170,'58.21.106.66',2,1720294728),(171,'120.242.179.172',2,1720320229),(172,'120.242.179.172',2,1720320305),(173,'120.242.179.172',2,1720320584),(174,'123.162.185.108',2,1720328256),(175,'180.101.245.253',2,1720328348),(176,'8.139.242.192',2,1720350058),(177,'111.194.205.111',2,1720365035),(178,'116.26.128.196',2,1720498203),(179,'116.26.128.196',2,1720498206),(180,'61.136.114.170',2,1720513415),(181,'180.101.245.250',2,1720519710),(182,'39.128.26.152',2,1720531948),(183,'223.74.75.3',2,1720541872),(184,'223.74.75.3',2,1720541934),(185,'223.74.75.3',2,1720541941),(186,'220.196.160.51',2,1720554654),(187,'112.224.198.91',1,1720597376),(188,'112.224.198.91',2,1720597392),(189,'123.113.28.98',2,1720605569),(190,'180.101.245.251',2,1720615579),(191,'116.169.2.49',2,1720628678),(192,'112.224.158.83',2,1720650094),(193,'36.28.72.19',2,1720659786),(194,'220.196.160.124',2,1720660420),(195,'39.130.63.181',2,1720682071),(196,'1.196.174.66',2,1720690448),(197,'220.196.160.84',2,1720693352),(198,'183.221.16.169',2,1720703811),(199,'183.221.16.169',2,1720704049),(200,'183.221.16.169',2,1720704077),(201,'112.224.159.4',2,1720753576),(202,'106.46.8.50',2,1720754152),(203,'220.196.160.124',2,1720770990),(204,'116.179.37.144',2,1720792136),(205,'111.224.84.255',2,1720800922),(206,'111.224.84.255',2,1720801377),(207,'117.182.134.193',2,1720843715),(208,'39.130.63.72',2,1720857563),(209,'180.101.244.12',2,1720861346),(210,'58.246.230.218',2,1720879943),(211,'120.244.50.201',2,1720891105),(212,'42.232.202.200',2,1720911157),(213,'220.196.160.117',2,1720911869),(214,'39.67.70.113',2,1720922139),(215,'223.104.204.31',2,1720927695),(216,'36.44.106.158',2,1720934865),(217,'220.196.160.124',2,1720943401),(218,'106.58.143.126',2,1720973594),(219,'116.230.173.14',2,1721013442),(220,'113.106.190.235',2,1721014994),(221,'180.101.244.12',2,1721036955),(222,'118.80.40.108',2,1721043966),(223,'223.160.172.120',2,1721099416),(224,'113.106.190.235',2,1721099793),(225,'113.106.190.235',2,1721099808),(226,'113.106.190.235',2,1721099819),(227,'36.44.100.68',1,1721106882),(228,'180.101.245.248',2,1721120439),(229,'113.106.190.235',2,1721183677),(230,'220.196.160.117',2,1721184298),(231,'43.227.136.179',2,1721192995),(232,'43.227.136.179',2,1721193128),(233,'43.227.138.128',2,1721193194),(234,'43.227.138.128',2,1721193385),(235,'43.227.138.128',2,1721193471),(236,'183.21.109.111',2,1721318045),(237,'120.231.246.229',2,1721318405),(238,'120.231.246.229',2,1721323152),(239,'120.231.246.229',2,1721323154),(240,'180.101.245.252',2,1721329242),(241,'112.224.33.175',2,1721383126),(242,'39.130.38.51',2,1721383663),(243,'39.130.38.51',2,1721383714),(244,'39.130.38.51',2,1721383718),(245,'220.196.160.45',2,1721390337),(246,'112.45.179.177',2,1721400216),(247,'182.244.169.55',2,1721453678),(248,'103.149.247.124',2,1721454956),(249,'103.149.247.124',2,1721455015),(250,'113.69.227.144',2,1721469036),(251,'118.113.89.176',2,1721489621),(252,'59.83.208.106',2,1721507806),(253,'36.62.163.90',2,1721540547),(254,'220.196.160.53',2,1721545596),(255,'223.104.170.135',2,1721549018),(256,'223.73.210.194',2,1721636542),(257,'180.101.245.251',2,1721640373),(258,'183.238.28.202',2,1721642401),(259,'183.237.254.106',2,1721642670),(260,'49.83.240.153',2,1721655058),(261,'49.83.240.153',2,1721655190),(262,'110.84.195.193',2,1721754455),(263,'220.196.160.53',2,1721754857),(264,'27.38.212.213',2,1721806800),(265,'180.101.245.247',2,1721828922),(266,'27.38.212.213',2,1721892265),(267,'49.83.240.153',2,1721894556),(268,'103.57.137.104',2,1721896236),(269,'125.77.70.195',2,1721911415),(270,'115.59.171.166',2,1721913306),(271,'115.59.171.166',2,1721913318),(272,'49.83.240.153',2,1721919058),(273,'180.101.245.251',2,1721936965),(274,'183.192.36.123',2,1721956915),(275,'59.83.208.105',2,1721967908),(276,'219.232.72.127',2,1721987100),(277,'118.248.39.125',2,1721995909),(278,'115.59.171.166',2,1721999080),(279,'180.101.244.16',2,1722012219),(280,'39.67.70.74',42,1723532728),(281,'163.125.230.156',42,1723532743),(282,'39.67.70.74',42,1723532753),(283,'163.125.230.156',42,1723532768),(284,'163.125.230.156',42,1723532833),(285,'163.125.230.156',42,1723532840),(286,'163.125.230.156',42,1723532887),(287,'163.125.230.156',42,1723533033),(288,'163.125.230.156',42,1723533109),(289,'163.125.230.156',42,1723533159),(290,'163.125.230.156',42,1723533668),(291,'180.101.245.247',42,1723533675),(292,'14.152.91.139',42,1723555193),(293,'182.114.162.57',1,1723694463),(294,'59.61.129.226',1,1723694473),(295,'182.114.162.57',1,1723694632),(296,'59.61.129.226',1,1723702017),(297,'59.61.129.226',1,1723702028),(298,'27.44.125.106',1,1723710130),(299,'14.152.91.206',1,1723710837),(300,'222.184.47.176',42,1723732365),(301,'222.184.47.176',42,1723732374),(302,'222.184.47.176',42,1723732384),(303,'120.227.108.64',42,1723809367),(304,'120.227.108.64',42,1723809379),(305,'120.227.108.64',42,1723809449),(306,'120.227.108.64',42,1723809511),(307,'120.227.108.64',42,1723809519),(308,'120.227.108.64',42,1723809544),(309,'120.227.108.64',42,1723809587),(310,'220.196.160.61',42,1723813680),(311,'106.224.137.65',44,1723978048),(312,'106.224.137.65',44,1723978079),(313,'106.224.137.65',44,1723978105),(314,'106.224.137.65',44,1723978123),(315,'118.249.83.122',45,1723981955),(316,'118.249.83.122',45,1723982078),(317,'118.249.83.122',45,1723982599),(318,'118.249.83.122',45,1723982616),(319,'118.249.83.122',45,1723983007),(320,'118.249.83.122',45,1723983082),(321,'118.249.83.122',45,1724044201),(322,'59.83.208.107',45,1724064320),(323,'42.238.63.236',1,1724182481),(324,'42.238.63.236',1,1724182569),(325,'120.225.57.15',46,1724324024),(326,'36.112.202.8',47,1724411470),(327,'182.116.129.171',1,1724426729),(328,'113.110.218.40',46,1724509508),(329,'113.110.218.40',46,1724509554),(330,'113.110.218.40',46,1724509576),(331,'220.196.160.144',46,1724509686),(332,'40.77.188.156',2,1725789600),(333,'59.173.209.65',48,1726202898),(334,'59.173.209.65',48,1726202944),(335,'59.173.209.65',48,1726202945),(336,'59.173.209.65',48,1726202946),(337,'59.173.209.65',48,1726202946),(338,'59.173.209.65',48,1726202947),(339,'59.173.209.65',48,1726202947),(340,'27.23.180.198',50,1726803332),(341,'27.23.180.198',50,1726803351),(342,'27.23.180.198',50,1726803369),(343,'220.196.160.125',50,1726803907),(344,'39.187.207.151',51,1727343841),(345,'39.187.207.151',51,1727343856),(346,'39.187.207.151',51,1727343865),(347,'39.187.207.151',51,1727343875),(348,'183.199.186.139',9,1727415320),(349,'183.199.186.139',9,1727415364),(350,'180.101.245.251',9,1727415431),(351,'211.110.208.31',52,1727463972),(352,'211.110.208.31',52,1727464004),(353,'211.110.208.31',52,1727464103),(354,'211.110.208.31',52,1727464128),(355,'129.211.167.128',52,1727464441),(356,'59.83.208.107',52,1727464444),(357,'39.146.251.29',53,1727869545),(358,'59.83.208.106',53,1727869702),(359,'39.146.251.29',53,1727869779),(360,'39.146.251.29',53,1727869798),(361,'223.104.195.108',53,1727869803),(362,'223.104.195.108',53,1727869827),(363,'39.146.251.29',53,1727870137),(364,'39.146.251.29',53,1727870145),(365,'39.146.251.29',53,1727870156),(366,'39.146.251.29',53,1727870171),(367,'39.146.251.29',53,1727870173),(368,'39.146.251.29',53,1727870205),(369,'39.146.251.29',53,1727870211),(370,'39.146.251.29',53,1727870214),(371,'39.146.251.29',53,1727870268),(372,'39.146.251.29',53,1727870278),(373,'39.146.251.29',53,1727870288),(374,'39.146.251.29',53,1727870386),(375,'39.146.251.29',53,1727870392),(376,'39.146.251.29',53,1727870403),(377,'39.146.251.29',53,1727870420),(378,'39.146.251.29',53,1727870430),(379,'39.146.251.29',53,1727870447),(380,'39.146.251.29',53,1727871038),(381,'39.146.251.29',53,1727871109),(382,'39.146.251.29',53,1727871193),(383,'39.146.251.29',53,1727871195),(384,'39.146.251.29',53,1727871216),(385,'39.146.251.29',53,1727871239),(386,'39.146.251.29',53,1727871325),(387,'39.146.251.29',53,1727871391),(388,'39.146.251.29',53,1727871401),(389,'39.146.251.29',53,1727871412),(390,'39.146.251.29',53,1727871418),(391,'39.146.251.29',53,1727871428),(392,'39.146.251.29',53,1727871435),(393,'39.146.251.29',53,1727871444),(394,'39.146.251.29',53,1727871461),(395,'39.146.251.29',53,1727871466),(396,'39.146.251.29',53,1727871505),(397,'39.146.251.29',53,1727871952),(398,'39.146.251.29',53,1727872008),(399,'39.146.251.29',53,1727872014),(400,'39.146.251.29',53,1727872099),(401,'39.146.251.29',53,1727872102),(402,'39.146.251.29',53,1727872108),(403,'39.146.251.29',53,1727872119),(404,'39.146.251.29',53,1727872427),(405,'39.146.251.29',53,1727872444),(406,'39.146.251.29',53,1727872484),(407,'106.53.102.224',53,1727882078),(408,'39.146.251.29',53,1728010145),(409,'39.146.251.29',53,1728010180),(410,'27.218.38.88',42,1728029265),(411,'27.218.38.88',42,1728029317),(412,'27.218.38.88',42,1728029335),(413,'112.0.21.176',54,1728052528),(414,'112.0.21.176',54,1728052574),(415,'223.215.219.208',53,1728135003),(416,'223.215.219.208',53,1728135027),(417,'139.226.191.233',1,1728241163),(418,'139.226.191.233',1,1728241220),(419,'58.100.162.35',55,1728526492),(420,'112.47.216.152',57,1729263837),(421,'125.47.190.101',1,1729322917),(422,'125.47.190.101',1,1729322950),(423,'125.47.190.101',1,1729323205),(424,'125.47.190.101',1,1729323270),(425,'125.47.190.101',1,1729323291),(426,'180.101.245.250',1,1729323296),(427,'36.148.33.201',58,1729398892),(428,'36.148.33.201',58,1729398926),(429,'119.39.248.21',58,1729402907),(430,'27.220.189.125',59,1729551690),(431,'27.220.189.125',59,1729551692),(432,'36.148.33.201',58,1729572972),(433,'36.148.33.201',58,1729573086),(434,'36.148.33.201',58,1729573157),(435,'36.148.33.201',58,1729573283),(436,'36.148.33.201',58,1729573367),(437,'180.101.245.248',58,1729573443),(438,'59.83.208.106',59,1729577251),(439,'43.250.200.37',58,1729581459),(440,'127.0.0.1',58,1729589148),(441,'43.250.200.37',58,1729599881),(442,'36.148.32.17',58,1729769508),(443,'36.148.32.17',58,1729769513),(444,'180.101.245.246',58,1729769647),(445,'39.146.252.7',53,1729855761),(446,'39.146.252.7',53,1729855811),(447,'39.146.252.7',53,1729855844),(448,'39.146.252.7',53,1729855856),(449,'39.146.252.7',53,1729855861),(450,'39.146.252.7',53,1729855874),(451,'220.196.160.125',53,1729855976),(452,'39.146.252.7',53,1729856628),(453,'1.116.124.78',53,1729856785),(454,'39.146.252.7',53,1729856871),(455,'39.146.252.7',53,1729856878),(456,'39.146.252.7',53,1729864373),(457,'117.185.153.3',53,1729871903),(458,'39.146.252.7',53,1730119040),(459,'180.101.244.12',53,1730119399),(460,'182.116.129.25',1,1736701724),(461,'182.116.129.25',1,1736701765),(462,'182.116.129.25',1,1736701840),(463,'182.116.129.25',1,1736701849),(464,'182.116.129.25',1,1736701850),(465,'182.116.129.25',1,1736701854),(466,'182.116.129.25',1,1736701865),(467,'182.116.129.25',1,1736714041),(468,'182.116.129.25',1,1736714049),(469,'182.116.128.61',1,1736735827),(470,'221.14.222.188',1,1737605055),(471,'221.14.222.188',1,1737605063),(472,'123.5.44.242',69,1737736664),(473,'58.16.238.194',65,1737810670),(474,'58.16.238.194',65,1737810736),(475,'58.16.238.194',65,1737862256),(476,'125.43.76.31',7,1738943439),(477,'125.43.76.31',7,1738943443),(478,'125.43.76.31',7,1738943451),(479,'125.43.76.31',7,1738943455),(480,'125.43.76.31',7,1738943465),(481,'125.43.76.31',7,1738943531),(482,'112.20.253.63',66,1738975126),(483,'223.246.49.232',66,1738980513),(484,'115.58.231.1',1,1739350642),(485,'115.58.231.1',1,1739350648),(486,'115.58.231.1',1,1739350654),(487,'115.58.231.1',1,1739350668),(488,'115.58.231.1',1,1739350704),(489,'115.58.231.1',1,1739350975),(490,'115.58.231.1',1,1739350982),(491,'115.58.231.1',1,1739351005),(492,'39.146.252.136',53,1740131809),(493,'39.146.252.136',53,1740132030),(494,'39.146.252.136',53,1740132040),(495,'39.146.252.136',53,1740132050),(496,'39.146.252.136',53,1740132057),(497,'39.146.252.136',53,1740132068),(498,'39.146.252.136',53,1740132091),(499,'39.146.252.136',53,1740132100),(500,'39.146.252.136',53,1740132112),(501,'39.146.252.136',53,1740132148),(502,'39.146.252.136',53,1740132385),(503,'39.146.252.136',53,1740132405),(504,'39.146.252.136',53,1740132406),(505,'39.146.252.136',53,1740132407),(506,'39.146.252.136',53,1740132428),(507,'39.146.252.136',53,1740132433),(508,'39.146.252.136',53,1740132443),(509,'39.146.252.136',53,1740132585),(510,'39.146.252.136',53,1740132604),(511,'39.146.252.136',53,1740132621),(512,'39.146.252.136',53,1740132655),(513,'39.146.252.136',53,1740132661),(514,'39.146.252.136',53,1740132661),(515,'39.146.252.136',53,1740132677),(516,'39.146.252.136',53,1740132720),(517,'39.146.252.136',53,1740132754),(518,'39.146.252.136',53,1740132756),(519,'39.146.252.136',53,1740132757),(520,'39.146.252.136',53,1740132759),(521,'39.146.252.136',53,1740132760),(522,'39.146.252.136',53,1740132772),(523,'39.146.252.136',53,1740132817),(524,'39.146.252.136',53,1740132845),(525,'39.146.252.136',53,1740132853),(526,'39.146.252.136',53,1740132873),(527,'39.146.252.136',53,1740132926),(528,'39.146.252.136',53,1740132948),(529,'39.146.252.136',53,1740132963),(530,'39.146.252.136',53,1740132992),(531,'39.146.252.136',53,1740133012),(532,'39.146.252.136',53,1740133745),(533,'39.146.252.136',53,1740133756),(534,'39.146.252.136',53,1740133867),(535,'39.146.252.136',53,1740134210),(536,'39.146.252.136',53,1740134392),(537,'39.146.252.136',53,1740134422),(538,'39.146.252.136',53,1740134457),(539,'112.17.242.57',53,1740228124),(540,'39.146.252.136',53,1740228153),(541,'39.146.252.136',53,1740228187),(542,'39.146.252.136',53,1740228208),(543,'112.17.242.57',53,1740228229),(544,'39.184.36.233',71,1740401354),(545,'39.184.36.233',71,1740401401),(546,'183.14.88.215',72,1740575912),(547,'183.14.88.215',72,1740575973),(548,'183.14.88.215',72,1740575989),(549,'183.14.88.215',72,1740575992),(550,'183.14.88.215',72,1740576010),(551,'183.14.88.215',72,1740576015),(552,'183.14.88.215',72,1740576016),(553,'183.14.88.215',72,1740581741),(554,'49.83.240.156',72,1740819947),(555,'49.83.240.156',72,1740819956),(556,'49.83.240.156',72,1740819961),(557,'218.12.16.38',72,1740822200),(558,'218.12.16.38',72,1740822284),(559,'49.83.240.156',72,1740823484),(560,'49.83.240.156',72,1740825947),(561,'118.31.5.185',53,1740995355),(562,'27.155.180.64',73,1741067929),(563,'27.155.180.64',73,1741068022),(564,'27.155.180.64',73,1741068031),(565,'27.155.180.64',73,1741068135),(566,'27.155.180.64',73,1741068141),(567,'39.128.33.176',74,1741078844),(568,'39.128.33.176',74,1741078887),(569,'39.128.33.176',74,1741078908),(570,'39.128.33.176',74,1741078961),(571,'39.128.33.176',74,1741078966),(572,'39.128.33.176',74,1741079001),(573,'39.128.33.176',74,1741079022),(574,'39.128.33.176',74,1741079038),(575,'112.97.217.119',75,1741199898),(576,'112.97.217.119',75,1741199949),(577,'112.97.217.119',75,1741224675),(578,'221.219.0.157',34,1741553428),(579,'221.219.0.157',34,1741553436),(580,'112.27.70.2',77,1742002043),(581,'112.27.70.2',77,1742002048),(582,'180.165.170.129',78,1742259837),(583,'180.165.170.129',78,1742260204),(584,'180.165.170.129',78,1742260208),(585,'180.165.170.129',78,1742260222),(586,'180.165.170.129',78,1742260253),(587,'112.97.54.170',79,1742451343),(588,'112.97.54.170',79,1742451359),(589,'112.97.54.170',79,1742451380),(590,'119.248.27.229',80,1742461823),(591,'119.248.27.229',80,1742461828),(592,'119.248.27.229',80,1742461861),(593,'115.58.206.231',1,1742526416),(594,'115.58.206.231',1,1742526428),(595,'61.140.95.232',82,1742795143),(596,'113.66.228.246',82,1742795213),(597,'113.66.228.246',82,1742795428),(598,'113.66.228.246',82,1742795509),(599,'42.231.124.247',85,1743027360),(600,'42.231.124.247',85,1743027371),(601,'175.10.192.220',86,1743071904),(602,'175.10.192.220',86,1743071909),(603,'220.198.246.26',87,1743200093),(604,'220.198.246.26',87,1743200162),(605,'220.198.246.26',87,1743200189),(606,'220.198.246.26',87,1743200238),(607,'220.198.246.26',87,1743200261),(608,'36.113.146.145',88,1743244694),(609,'36.113.146.145',88,1743244824),(610,'36.113.146.145',88,1743244887),(611,'180.165.170.129',78,1743511496),(612,'180.165.170.129',78,1743511510),(613,'180.165.170.129',78,1743511756),(614,'180.165.170.129',78,1743511869),(615,'182.46.115.22',90,1743579368),(616,'182.46.115.22',90,1743579408),(617,'112.224.175.12',91,1743670534),(618,'112.224.175.12',91,1743670537),(619,'112.224.175.12',91,1743670574),(620,'112.224.175.12',91,1743670586),(621,'112.224.175.12',91,1743670593),(622,'112.224.175.12',91,1743670650),(623,'112.224.175.12',91,1743670681),(624,'112.224.175.12',91,1743670750),(625,'183.200.108.95',92,1743743871),(626,'183.200.108.95',92,1743744108),(627,'120.219.29.175',93,1743753208),(628,'120.219.29.175',93,1743753278),(629,'120.219.29.175',93,1743753288),(630,'113.104.188.211',94,1743841626),(631,'113.104.188.211',94,1743841641),(632,'113.104.188.211',94,1743841659),(633,'223.88.6.205',96,1743921759),(634,'223.88.6.205',96,1743921800),(635,'223.88.6.205',96,1743921810),(636,'223.88.6.205',96,1743921820),(637,'223.88.6.205',96,1743921827),(638,'223.88.6.205',96,1743921833),(639,'113.104.188.211',94,1743940636),(640,'27.187.26.131',97,1744070298),(641,'27.187.26.131',97,1744070303),(642,'27.187.26.131',97,1744070322),(643,'222.137.131.171',96,1744212494),(644,'222.137.131.171',96,1744212601),(645,'222.137.131.171',96,1744212624),(646,'223.66.55.244',99,1744215226),(647,'223.66.55.244',99,1744215323),(648,'163.142.255.230',100,1744225243),(649,'42.239.69.29',101,1744285223),(650,'42.239.69.29',101,1744285270),(651,'42.239.69.29',101,1744285293),(652,'113.110.218.251',102,1744354036),(653,'113.110.218.251',102,1744354069),(654,'113.110.218.251',102,1744354069),(655,'113.110.218.251',102,1744354302),(656,'113.110.218.251',102,1744354369),(657,'113.110.218.251',102,1744354491),(658,'113.110.218.251',102,1744354609),(659,'171.213.251.234',98,1744684239),(660,'171.213.251.234',98,1744684241),(661,'171.213.251.234',98,1744684265),(662,'171.213.251.234',98,1744684395),(663,'171.213.251.234',98,1744684405),(664,'60.255.166.226',98,1744700994),(665,'36.41.149.227',105,1744794979),(666,'36.41.149.227',105,1744795015),(667,'36.41.149.227',105,1744795032),(668,'36.41.149.227',105,1744795037),(669,'36.41.149.227',105,1744795762),(670,'36.41.149.227',105,1744795780),(671,'211.90.253.146',106,1744800938),(672,'211.90.253.146',106,1744800963),(673,'211.90.253.146',106,1744800964),(674,'211.90.253.146',106,1744800969),(675,'211.90.253.146',106,1744800975),(676,'123.55.176.237',104,1744816741),(677,'123.55.176.237',104,1744816859),(678,'123.55.176.237',104,1744816949),(679,'27.23.176.58',1,1744850180),(680,'111.55.180.170',107,1744860133),(681,'112.225.250.235',1,1745180782),(682,'112.225.250.235',1,1745180787),(683,'112.225.250.235',1,1745180794),(684,'112.225.250.235',1,1745180798),(685,'112.225.250.235',1,1745180831),(686,'112.225.250.235',1,1745180858),(687,'39.191.218.119',104,1745212060),(688,'39.191.218.119',104,1745212066),(689,'36.143.135.246',109,1745245044),(690,'36.143.135.246',109,1745245100),(691,'60.208.236.30',110,1745460803),(692,'27.23.184.234',1,1745506592),(693,'221.219.4.189',34,1745782145),(694,'221.219.4.189',34,1745782148),(695,'221.219.4.189',34,1745782153),(696,'221.219.4.189',34,1745782159),(697,'221.219.4.189',34,1745782169),(698,'221.219.4.189',34,1745782172),(699,'221.219.4.189',34,1745782175),(700,'221.219.4.189',34,1745782178),(701,'221.219.4.189',34,1745902856),(702,'221.219.4.189',34,1745902886),(703,'221.219.4.189',34,1745902919),(704,'221.219.4.189',34,1745902929),(705,'221.219.4.189',34,1745902934),(706,'221.219.4.189',34,1745902936),(707,'221.219.4.189',34,1745902941),(708,'123.174.127.219',112,1746004462),(709,'123.174.127.219',112,1746004562),(710,'111.201.149.155',34,1746438237),(711,'111.201.149.155',34,1746438242),(712,'111.201.149.155',34,1746438253),(713,'111.201.149.155',34,1746438532),(714,'111.18.224.208',114,1746461840),(715,'111.18.224.208',114,1746461844),(716,'111.18.224.208',114,1746461897),(717,'107.175.224.113',114,1746464114),(718,'39.149.51.254',114,1746464576),(719,'111.201.149.155',34,1746526056),(720,'111.201.149.155',34,1746526060),(721,'112.8.58.23',121,1746540821),(722,'112.8.58.23',121,1746540857),(723,'112.8.58.23',121,1746540951),(724,'112.8.58.23',121,1746541018),(725,'112.8.58.23',121,1746542071),(726,'112.224.2.101',121,1746588489),(727,'27.23.182.124',1,1746625766),(728,'27.23.182.124',1,1746625870),(729,'112.32.130.88',122,1746796710),(730,'112.32.130.88',122,1746796840),(731,'112.32.130.88',122,1746796848),(732,'42.91.17.172',124,1746902973),(733,'42.91.17.172',124,1746903036),(734,'112.44.101.84',122,1746927472),(735,'112.44.101.84',122,1746927671),(736,'112.44.101.84',122,1746927680),(737,'112.44.101.84',122,1746927697),(738,'112.44.101.84',122,1746927760),(739,'222.93.190.8',126,1746971853),(740,'222.93.190.8',126,1746971876),(741,'222.93.190.8',126,1746971975),(742,'222.93.190.8',126,1746972019),(743,'222.93.190.8',126,1746972159),(744,'222.93.190.8',126,1746972388),(745,'222.93.190.8',126,1746972392),(746,'222.93.190.8',126,1746972393),(747,'222.93.190.8',126,1746984575),(748,'222.93.190.8',126,1747041020),(749,'27.23.182.124',1,1747207559),(750,'112.8.56.189',121,1747307625),(751,'112.8.56.189',121,1747308864),(752,'118.112.73.186',127,1747383535),(753,'118.112.73.186',127,1747383607),(754,'118.112.73.186',127,1747383609),(755,'112.32.130.88',122,1747400076),(756,'112.32.130.88',122,1747400107),(757,'36.41.149.179',105,1747453744),(758,'36.41.149.179',105,1747453752),(759,'36.41.149.179',105,1747453797),(760,'62.192.175.15',128,1747898571),(761,'62.192.175.15',128,1747898629),(762,'62.192.175.15',128,1747898639),(763,'62.192.175.15',128,1747898661),(764,'182.114.163.62',1,1747956622),(765,'182.114.163.62',1,1747956626),(766,'182.114.163.62',1,1747956628),(767,'182.114.163.62',1,1747956631),(768,'182.114.163.62',1,1747956634),(769,'182.114.163.62',1,1747956744),(770,'182.114.163.62',1,1747956746),(771,'182.114.163.62',1,1747956749),(772,'182.114.163.62',1,1747956898),(773,'182.114.163.62',1,1747956907),(774,'182.114.163.62',1,1747956919),(775,'182.114.163.62',1,1747956957),(776,'182.114.163.62',1,1747956985),(777,'182.114.163.62',1,1747957485),(778,'182.114.163.62',1,1747957721),(779,'182.114.163.62',1,1747957729),(780,'182.114.163.62',1,1747957733),(781,'182.114.163.62',1,1747958921),(782,'1.197.43.167',130,1748463761),(783,'183.199.247.9',131,1748597012),(784,'183.199.247.9',131,1748597046),(785,'124.90.106.8',134,1749777312),(786,'124.90.106.8',134,1749777466),(787,'124.90.106.8',134,1749778218),(788,'39.180.78.254',135,1749807169),(789,'42.233.194.10',1,1749866597),(790,'112.8.58.206',121,1750172376),(791,'127.0.0.1',121,1750180613),(792,'180.136.208.111',138,1750663405),(793,'180.136.208.111',138,1750663438),(794,'180.136.208.111',138,1750663523),(795,'180.136.208.111',138,1750663536),(796,'182.114.137.38',1,1757260557),(797,'182.114.137.38',1,1757260563),(798,'182.114.137.38',1,1757260577),(799,'182.114.137.38',1,1757260582),(800,'182.114.137.38',1,1757260593),(801,'182.114.137.38',1,1757260599),(802,'182.114.137.38',1,1757261783),(803,'182.114.137.38',1,1757261788);
/*!40000 ALTER TABLE `shop_iplist` ENABLE KEYS */;
UNLOCK TABLES;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `shop_link` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int unsigned NOT NULL DEFAULT '0',
  `relation_type` varchar(20) NOT NULL DEFAULT '',
  `relation_id` int unsigned NOT NULL DEFAULT '0',
  `token` char(16) NOT NULL DEFAULT '',
  `short_url` varchar(30) NOT NULL,
  `status` tinyint unsigned NOT NULL,
  `create_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id` (`user_id`,`relation_type`,`relation_id`),
  UNIQUE KEY `token_uindex` (`token`),
  UNIQUE KEY `user_link_index` (`relation_id`,`relation_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `shop_link` WRITE;
/*!40000 ALTER TABLE `shop_link` DISABLE KEYS */;
/*!40000 ALTER TABLE `shop_link` ENABLE KEYS */;
UNLOCK TABLES;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `shop_list` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL COMMENT '用户id',
  `shop_name` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT '商铺名称',
  `shop_notice_show` tinyint(1) NOT NULL DEFAULT '0',
  `shop_notice` varchar(200) COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT '公告通知',
  `shop_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '店铺状态:通过审核后1',
  `shop_verify` tinyint(1) NOT NULL DEFAULT '0' COMMENT '审核状态：0待审核；-1审核中，1通过',
  `shop_freeze` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否冻结 0否 1是',
  `create_at` int DEFAULT NULL COMMENT '店铺通过时间',
  `merchant_end_time` int DEFAULT NULL COMMENT '店铺过期时间',
  `pc_template` varchar(50) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'default' COMMENT '店铺电脑端模板',
  `mobile_template` varchar(50) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'default' COMMENT '店铺手机端模板',
  `shop_qq` varchar(16) COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT '店铺QQ',
  `pay_theme` varchar(50) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'default' COMMENT '支付页风格',
  `pay_theme_mobile` varchar(50) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'default' COMMENT '支付模板手机端',
  `stock_display` tinyint unsigned NOT NULL DEFAULT '2' COMMENT '库存展示方式 1实际库存 2库存范围	',
  `merchant_time` int DEFAULT NULL COMMENT '开店时间',
  `shop_contact` varchar(100) COLLATE utf8mb4_general_ci DEFAULT '{qq: '''',mobile: '''',wechat: ''''}' COMMENT '店铺联系方式',
  `show_contact` int NOT NULL DEFAULT '0' COMMENT '是否显示店铺联系方式0不显示1显示',
  `shop_close` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否关闭店铺 0否 1是',
  `fee_payer` tinyint DEFAULT '0' COMMENT '订单手续费支付方，0：跟随系统，1：商家承担，2买家承担',
  `shop_close_notice` varchar(255) COLLATE utf8mb4_general_ci DEFAULT '店铺歇业中' COMMENT '歇业提示语',
  `shop_logo` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='商户资料表';
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `shop_list` WRITE;
/*!40000 ALTER TABLE `shop_list` DISABLE KEYS */;
/*!40000 ALTER TABLE `shop_list` ENABLE KEYS */;
UNLOCK TABLES;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `system_config` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL COMMENT '配置编码',
  `value` mediumtext COMMENT '配置值',
  PRIMARY KEY (`id`),
  KEY `index_system_config_name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=81 DEFAULT CHARSET=utf8mb3 ROW_FORMAT=COMPACT COMMENT='系统参数配置';
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `system_config` WRITE;
/*!40000 ALTER TABLE `system_config` DISABLE KEYS */;
INSERT INTO `system_config` VALUES (1,'site_status','1'),(2,'site_close_tips',''),(3,'site_name','骑士寄售开源版演'),(4,'site_subtitle','骑士寄售免费开源版'),(5,'site_keywords','骑士寄售免费开源版'),(6,'site_desc','11111'),(7,'site_logo','http://f2.qqss.net/upload/admin/1/image/20240816/66bee6f3310e.png'),(8,'merchant_logo','http://f2.qqss.net/upload/admin/1/image/20240816/66bee6f63c0f.png'),(9,'merchant_logo_sm','http://f2.qqss.net/upload/admin/1/image/20240816/66bee6d7507a.png'),(10,'site_info_address','河南平顶山'),(11,'site_info_email','123456@qq.com'),(12,'site_info_copyright','© 2022-2025 f2.qqss.net 公司：xxx'),(13,'site_shop_copyright',''),(14,'site_info_icp','豫ICP备2024064321'),(15,'site_info_tel','15612341234'),(16,'site_info_tel_desc',''),(17,'site_info_qq','123456'),(18,'site_info_qq_desc','7*24小时'),(19,'site_domain','https://f2.qqss.net'),(20,'site_shop_domain','https://f2.qqss.net'),(21,'site_domain_short','Suo'),(26,'site_wordfilter_status','0'),(27,'site_wordfilter_danger',''),(28,'site_register_status','1'),(29,'site_register_need_username','1'),(30,'site_register_need_mobile','0'),(31,'site_register_need_mobile_check',''),(32,'site_register_need_email','0'),(33,'site_register_need_email_check','0'),(34,'site_register_smscode_max_count','3'),(35,'site_register_smscode_max_time','60'),(36,'sms_error_limit','5'),(37,'sms_error_time','10'),(38,'site_register_smscode_expire_time','300'),(39,'ip_register_limit','5'),(40,'site_register_verify','1'),(47,'order_trade_no_type','0'),(48,'order_trade_no_profix',''),(49,'order_title_type','2'),(50,'order_title_profix','T'),(51,'order_title_str',''),(52,'order_auto_close_time','5'),(53,'order_query_blackcontact',''),(54,'complaint_refund','0'),(55,'transaction_min_fee','0'),(56,'fee_payer','1'),(57,'purchase_agreement',''),(58,'settlement_type',''),(59,'settlement_frezze_endtime',''),(60,'cash_status','1'),(61,'auto_cash','0'),(62,'auto_cash_time','3'),(63,'cash_type','[1,2,3]'),(64,'auto_cash_money','50'),(65,'cash_close_tips','满50每天12点自动结算，无须手动结算。'),(66,'cash_limit_time_start','10'),(67,'cash_limit_time_end','18'),(68,'cash_min_money','50'),(69,'cash_fee_type','100'),(70,'cash_fee','1'),(71,'auto_cash_fee_type','100'),(72,'auto_cash_fee','0'),(73,'cash_limit_num','5'),(74,'cash_limit_num_tips','已达到今日最多提现次数！'),(75,'cash_weixinnotify_open','0'),(76,'cash_emailnotify_open','1'),(79,'sms.qcloud','{\"status\":1}'),(80,'site_shortlink_other_option','{\n  \"api\": \"http://api.3wt.cn/api.htm\",\n  \"from\": \"url\",\n  \"method\": \"get\",\n  \"params\": {\n    \"format\": \"json\",\n    \"key\": \"6209ae6d41fb7cd01413eb4d45@ebe9e520aa886c17517c5aad213d730e\",\n    \"domain\": \"21\"\n  }\n}');
/*!40000 ALTER TABLE `system_config` ENABLE KEYS */;
UNLOCK TABLES;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `system_menu` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `path` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `title` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `component` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `icon` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `pid` int NOT NULL DEFAULT '0',
  `app` varchar(10) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'pc' COMMENT '应用',
  `orderNo` tinyint unsigned NOT NULL DEFAULT '0',
  `hidden` tinyint(1) NOT NULL DEFAULT '0',
  `redirect` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `type` varchar(5) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'M' COMMENT '类型',
  `perms` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT '权限标识',
  `keep_alive` tinyint(1) DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=187 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `system_menu` WRITE;
/*!40000 ALTER TABLE `system_menu` DISABLE KEYS */;
INSERT INTO `system_menu` VALUES (1,'merchantUser','user','我的账户','Layout','user-1',0,'merchant',2,0,'/merchant/user/setting','L','',0,1),(2,'merchantWorkbench','workbench','信息汇总','merchant/workbench/index','laptop',0,'merchant',0,0,'','M','merchantapi/workbench/index',0,1),(3,'merchantUserLink','link','店铺链接','merchant/shop/link/index','',151,'merchant',0,0,'','M','11',0,1),(4,'merchantUserSetting','setting','商户信息','merchant/user/setting/index','',1,'merchant',0,0,'','M',NULL,0,1),(5,'merchantFinanceCash','cash/index','提现记录','merchant/finance/cash/index','',29,'merchant',5,0,'','M',NULL,0,1),(6,'merchantUserLoginLog','loginlog','登录日志','merchant/user/loginLog/index','',1,'merchant',0,0,'','M','merchantapi/user/loginLog',0,1),(7,'merchantUserPassword','password','修改密码','merchant/user/password/index','',1,'merchant',0,1,'','M',NULL,0,1),(8,'merchantUserNotice','message','通知列表','merchant/user/message/index','',1,'merchant',0,1,'','M','merchantapi/user/message/list',0,1),(10,'merchantGoods','goods','商品管理','Layout','shop',0,'merchant',3,0,'/merchant/goods/category','L','',0,1),(11,'merchantGoodsCategory','category','商品分类','merchant/goods/category/index','',10,'merchant',0,0,'','M','merchantapi/goods/category/list',0,1),(12,'merchantGoodsAdd','add','添加商品','merchant/goods/good/add','',10,'merchant',0,1,'','M','merchantapi/goods/good/add',0,1),(13,'merchantGoodsEdit','edit','编辑商品','merchant/goods/good/add','',10,'merchant',0,1,'','M','merchantapi/goods/good/edit',0,1),(14,'merchantGoodsList','index','商品列表','merchant/goods/good/index','',10,'merchant',0,0,'','M',NULL,0,1),(15,'merchantGoodsTrash','trash','商品回收站','merchant/goods/good/trash','',10,'merchant',0,1,NULL,'M',NULL,0,1),(16,'merchantGoodsCardList','card','库存管理','merchant/goods/card/index','',10,'merchant',0,0,'','M','merchantapi/goods/card',0,1),(17,'merchantGoodsCardTrash','card/trash','库存回收站','merchant/goods/card/trash','',10,'merchant',0,1,'','M',NULL,0,1),(18,'merchantGoodsCardAdd','card/add','添加库存','merchant/goods/card/add','',10,'merchant',0,1,'','M',NULL,0,1),(19,'merchantGoodsCoupon','coupon','优惠券','merchant/goods/coupon/index','',10,'merchant',0,0,'','M',NULL,0,1),(20,'merchantGoodsCouponAdd','coupon/add','添加优惠券','merchant/goods/coupon/add','',10,'merchant',0,1,'','M','merchantapi/goods/coupon/add',0,1),(21,'merchantGoodsCouponTrash','coupon/trash','优惠券回收站','merchant/goods/coupon/trash','',10,'merchant',0,1,'','M',NULL,0,1),(23,'merchantOrderComplaintIndex','complaint','投诉管理','merchant/order/complaint/index','',24,'merchant',100,0,'','M','merchantapi/order/complaint/list',0,1),(24,'merchantOrder','order','交易数据','Layout','keyboard',0,'merchant',3,0,'/merchant/order/list','L','',0,1),(25,'merchantOrderOrderList','list','订单管理','merchant/order/order/list','',24,'merchant',0,0,'','M','merchantapi/order/order/list',0,1),(26,'merchantOrderOrderCard','card','查看卡密','merchant/order/order/card','',24,'merchant',0,1,'','M','merchantapi/order/order/card',0,1),(27,'merchantCharts','charts','数据统计','Layout','chart',0,'merchant',8,0,'/merchant/charts/ranklist','L','',0,1),(28,'merchantChartsRanklist','ranklist','累计消费','merchant/charts/ranklist','',27,'merchant',0,0,NULL,'M',NULL,0,1),(29,'merchantFinance','finance','财务管理','Layout','wallet',0,'merchant',12,0,'/merchant/finance/collect','L','',0,1),(30,'merchantFinanceCollect','collect','收款设置','merchant/finance/collect','',29,'merchant',1,0,'','M',NULL,0,1),(31,'merchantFinanceMoney','money','收益统计','merchant/charts/money','',27,'merchant',10,0,'','M','merchantapi/charts/money',0,1),(32,'merchantFinanceTranslist','translist','资金明细','merchant/finance/translist','',29,'merchant',8,0,'','M',NULL,0,1),(33,'merchantFinanceCashApply','cash/apply','提现申请','merchant/finance/cash/apply','',29,'merchant',3,0,'','M',NULL,0,1),(34,'adminPermission','permission','权限管理','Layout','setting-1',0,'admin',3,0,'/admin/permission/menu','L','',0,1),(37,'adminOrder','order','交易管理','Layout','cart',0,'admin',5,0,'/admin/order/list','L','',0,1),(38,'AdminOrderList','list','订单列表','/admin/order/list/index','',37,'admin',0,0,'','M','adminapi/order/order/list',0,1),(39,'adminWorkbench','workbench','工作台','admin/workbench/index','desktop',0,'admin',1,0,'','M','workbench',0,1),(40,'adminPermissionAdmin','admin','管理员','admin/permission/admin/index','',34,'admin',0,0,'','M','adminapi/permission/adminapi/list',0,1),(41,'adminSetting','setting','系统设置','layout','setting',0,'admin',2,0,'/admin/setting/website','L','',0,1),(43,'adminSettingWebsite','website','站点配置','admin/setting/website/index','',41,'admin',0,0,'','M','adminapi/config/config/getConfig',0,1),(44,'adminSettingRegister','register','注册设置','admin/setting/register/index','',41,'admin',0,0,'','M','adminapi/config/config/getConfig',0,1),(46,'adminChannel','channel','通道管理','layout','money',0,'admin',8,0,'/admin/channel/pay_type','L','',0,1),(47,'adminChannelCollection','collection','收款通道','admin/channel/collection/index','',46,'admin',20,0,'','M','adminapi/channel/collection/list',0,1),(48,'adminChannelPay_type','pay_type','支付方式分类','admin/channel/pay_type/index','',46,'admin',0,0,'','M','adminapi/channel/payType/list',0,1),(49,'adminMerchant','merchant','商户管理','layout','user-1',0,'admin',49,0,'/admin/merchant/user','L','',0,1),(50,'adminMerchantUser','user','用户管理','admin/merchant/user/index','',49,'admin',50,0,'','M','adminapi/merchant/user/list',0,1),(54,'adminShop','shop','商城管理','Layout','layers',0,'admin',54,0,'/admin/shop/goods','L','',0,1),(62,'adminShopGoods','goods','商品管理','admin/goods/goods/index','',54,'admin',62,0,'','M','adminapi/goods/goods/list',0,1),(63,'adminOrderConfig','config','订单配置','admin/order/config/index','',37,'admin',63,0,'','M','adminapi/order/order/list',0,1),(66,'adminMerchantMoney_log','money_log','资金日志','admin/merchant/money-log/index','',49,'admin',66,0,'','M','adminapi/merchant/moneylog/list',0,1),(67,'adminChannelSettlement','settlement','结算通道','admin/channel/settlement/index','',46,'admin',67,0,'','M','adminapi/channel/collection/list',0,1),(69,'adminChannelCollectionAccount','collection/account','账号管理','admin/channel/collection/account/index','',46,'admin',69,1,'','M','adminapi/channel/collection/list',0,1),(70,'adminChannelSettlement/account','settlement/account','结算账号','admin/channel/settlement/account/index','',46,'admin',70,1,'','M','adminapi/channel/collection/list',0,1),(71,'adminChannelConfig','config','结算配置','admin/channel/settlement/config/index','',46,'admin',71,0,'','M','adminapi/config/config/getConfig',0,1),(72,'adminOrderMerchant','merchant','商户分析','admin/order/analysis/merchant/index','',37,'admin',72,0,'','M','adminapi/order/analysis/merchant',0,1),(73,'adminOrderChannel','channel','渠道分析','admin/order/analysis/channel/index','',37,'admin',73,0,'','M','adminapi/order/analysis/channel',0,1),(76,'adminMerchantLoginlog','loginlog','登录日志','admin/merchant/loginlog/index','',49,'admin',76,0,'','M','adminapi/merchant/user/loginlog',0,1),(88,'adminMerchantRole','role','商户角色','admin/merchant/role/index','',49,'admin',88,0,'','M','adminapi/merchant/role/list',0,1),(89,'adminMerchantCash','cash','提现管理','admin/merchant/cash/index','',49,'admin',89,0,'','M','adminapi/merchant/cash/list',0,1),(97,'adminPermissionMenu','menu','菜单管理','admin/permission/menu/index','',34,'admin',97,0,'','M','adminapi/permission/log/list',0,1),(98,'adminPermissionLog','log','操作日志','admin/permission/log/index','',34,'admin',98,0,'','M','adminapi/permission/log/list',0,1),(135,'adminOrderComplaint','complaint','投诉管理','admin/order/complaint/index','',37,'admin',135,0,'','M','adminapi/order/complaint/list',0,1),(136,'adminOrderComplaint/detail','complaint/detail','投诉详情','admin/order/complaint/detail','',37,'admin',136,1,'','M','adminapi/order/complaint/detail',0,1),(137,'merchantComplaintDetail','complaint/detail','投诉详情','merchant/order/complaint/detail','',24,'merchant',137,1,'','M','merchantapi/order/complaint/detail',0,1),(141,'adminArticle','article','文章管理','LAYOUT','component-dropdown',0,'admin',141,0,'/admin/article/category','L','',0,1),(142,'adminArticleIndex','index','文章管理','admin/article/article/index','',141,'admin',142,0,'','M','adminapi/article/article/list',0,1),(145,'adminArticleCategory','category','文章分类','admin/article/category/index','',141,'admin',145,0,'','M','adminapi/article/articleCategory/list',0,1),(150,'adminMerchantShop','shop','店铺管理','admin/merchant/shop/index','',49,'admin',150,0,'','M','adminapi/merchant/shop/list',0,1),(151,'merchantShop','shop','店铺管理','Layout','address-book',0,'merchant',151,0,'/merchant/shop/link','L','',0,1),(152,'merchantShopConfig','config','店铺设置','merchant/shop/config/index','',151,'merchant',152,0,'','M','11',0,1),(158,'merchantGoodsCategory','','商品分类添加','','',11,'merchant',158,0,'','B','merchantapi/goods/category/add',0,1),(163,'merchantUserNews','news','公告列表','merchant/user/news/list','',1,'merchant',163,0,'','M','merchantapi/user/news/list',0,1),(164,'merchantUserNews_detail/:id','news/detail/:id','文章详情','merchant/user/news/detail','',1,'merchant',164,1,'','M','merchantapi/user/news/detail',0,1),(165,'merchantUserNotice','','标记全部已读','','',8,'merchant',165,0,'','B','merchantapi/user/message/readAll',0,1),(166,'merchantUserNotice','','标记已读','','',8,'merchant',166,0,'','B','merchantapi/user/message/read',0,1),(167,'merchantUserNotice','','删除','','',8,'merchant',167,0,'','B','merchantapi/user/message/del',0,1),(168,'adminSettingNotification','notification','消息通知','BLANK','',41,'admin',168,0,'','L','',0,1),(169,'merchantGoodsCategory','','商品分类链接','','',11,'merchant',169,0,'','B','merchantapi/goods/category',0,1),(170,'merchantGoodsCategory','','商品分类编辑','','',11,'merchant',170,0,'','B','merchantapi/goods/category/edit',0,1),(171,'merchantGoodsCategory','','商品分类删除','','',11,'merchant',171,0,'','B','merchantapi/goods/category/del',0,1),(177,'adminSettingNotificationList','list','通知设置','admin/setting/notification/index','',168,'admin',177,0,'','M','adminapi/system/notification/index',0,1),(178,'adminSettingNotificationSms','sms','短信配置','admin/setting/notification/sms','',168,'admin',178,0,'','M','adminapi/system/notification/smsType',0,1),(179,'adminSettingNotificationEmail','email','邮箱配置','admin/setting/notification/email','',168,'admin',179,0,'','M','adminapi/config/config/editConfig',0,1),(180,'adminSettingSystem','system','系统维护','BLANK','',41,'admin',180,0,'','L','',0,1),(181,'adminSettingSystemEnvironment','environment','系统环境','admin/setting/system/environment','',180,'admin',181,0,'','M','adminapi/setting/system/environment',0,1),(182,'adminSettingSystemCache','cache','系统缓存','admin/setting/system/cache','',180,'admin',182,0,'','M','adminapi/system/system/cache',0,1),(184,'merchantUserPayment','payment','付款方式','merchant/user/payment/index','',1,'merchant',184,0,'','M','merchantapi/user/payment/list',0,1),(186,'adminMerchantMenu','menu','菜单管理','admin/merchant/menu/index','',49,'admin',186,0,'','M','adminapi/merchant/menu/list',0,1);
/*!40000 ALTER TABLE `system_menu` ENABLE KEYS */;
UNLOCK TABLES;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `system_notification` (
  `id` int NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `mark` varchar(50) NOT NULL DEFAULT '' COMMENT '标识',
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '通知类型',
  `title` varchar(100) NOT NULL DEFAULT '' COMMENT '通知场景说明',
  `is_sms` tinyint(1) NOT NULL DEFAULT '0' COMMENT '发送短信（0：不存在，1：开启，2：关闭）',
  `sms_config` varchar(512) NOT NULL DEFAULT '' COMMENT '短信配置',
  `system` tinyint(1) NOT NULL DEFAULT '0' COMMENT '系统调用',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb3 COMMENT='通知设置';
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `system_notification` WRITE;
/*!40000 ALTER TABLE `system_notification` DISABLE KEYS */;
INSERT INTO `system_notification` VALUES (1,'register','注册短信验证码','短信验证码',0,'{\"id\":1,\"status\":0,\"sms_gateway\":\"aliyun\",\"sms_template_content\":\"\\u60a8\\u6b63\\u5728\\u6ce8\\u518c\\uff0c\\u9a8c\\u8bc1\\u7801${code}\\uff0c\\u5207\\u52ff\\u5c06\\u9a8c\\u8bc1\\u7801\\u6cc4\\u9732\\u4e8e\\u4ed6\\u4eba\\uff0c\\u672c\\u6761\\u9a8c\\u8bc1\\u7801\\u6709\\u6548\\u671f5\\u5206\\u949f\\u3002\",\"sms_template_id\":\"SMS_123456\"}',1),(3,'complaint_to_buyer','投诉短信【买家】','买家投诉短信密码',1,'{\"id\":3,\"status\":1,\"sms_template_content\":\"\\u60a8\\u7684\\u8ba2\\u5355{$trade_no}\\u5df2\\u6295\\u8bc9\\u6210\\u529f\\u3002\\u6295\\u8bc9\\u5bc6\\u7801\\u4e3a{$pwd}\\uff0c\\u5728\\u5356\\u5bb6\\u672a\\u7ed9\\u60a8\\u5904\\u7406\\u597d\\u95ee\\u9898\\u524d\\uff0c\\u8bf7\\u52ff\\u5c06\\u5bc6\\u7801\\u544a\\u77e5\\u4efb\\u4f55\\u4eba\\uff01\",\"sms_gateway\":\"aliyun\"}',1),(4,'complaint_to_merchant','通知有投诉【卖家】','通知卖家有投诉的订单',1,'{\"id\":4,\"status\":1,\"sms_template_content\":\"\\u60a8\\u7684\\u8ba2\\u5355\\uff1a{$trade_no}\\uff0c\\u5df2\\u7ecf\\u6709\\u4e70\\u5bb6\\u6295\\u8bc9\\uff0c\\u8bf7\\u60a8\\u53ca\\u65f6\\u767b\\u5f55\\u540e\\u53f0\\u5904\\u7406\\u3002\",\"sms_gateway\":\"aliyun\"}',1),(5,'order_to_buyer','订单通知【买家】','付款后发送后买家购买信息的短信',1,'{\"id\":5,\"status\":0,\"sms_template_content\":\"\\u60a8\\u7684\\u8ba2\\u5355\\u5df2\\u652f\\u4ed8\\u6210\\u529f\\uff0c\\u8ba2\\u5355\\u53f7\\uff1a{$trade_no}\\uff0c\\u82e5\\u60a8\\u4ed8\\u6b3e\\u6210\\u529f\\u540e\\u6ca1\\u6709\\u9886\\u53d6\\u865a\\u62df\\u5361\\u4fe1\\u606f\\uff0c\\u8bf7\\u60a8\\u53ca\\u65f6\\u901a\\u8fc7\\u8ba2\\u5355\\u67e5\\u8be2\\u63d0\\u53d6\\u3002\",\"sms_gateway\":\"aliyun\"}',1);
/*!40000 ALTER TABLE `system_notification` ENABLE KEYS */;
UNLOCK TABLES;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `system_uploads` (
  `id` int NOT NULL AUTO_INCREMENT COMMENT '主键',
  `name` varchar(128) COLLATE utf8mb4_general_ci NOT NULL COMMENT '名称',
  `url` varchar(255) COLLATE utf8mb4_general_ci NOT NULL COMMENT '文件',
  `admin_id` int DEFAULT NULL COMMENT '管理员',
  `file_size` int NOT NULL COMMENT '文件大小',
  `mime_type` varchar(255) COLLATE utf8mb4_general_ci NOT NULL COMMENT 'mime类型',
  `image_width` int DEFAULT NULL COMMENT '图片宽度',
  `image_height` int DEFAULT NULL COMMENT '图片高度',
  `ext` varchar(128) COLLATE utf8mb4_general_ci NOT NULL COMMENT '扩展名',
  `storage` varchar(255) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'local' COMMENT '存储位置',
  `created_at` date DEFAULT NULL COMMENT '上传时间',
  `category` varchar(128) COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT '类别',
  `updated_at` date DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `category` (`category`),
  KEY `admin_id` (`admin_id`),
  KEY `name` (`name`),
  KEY `ext` (`ext`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='附件';
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `system_uploads` WRITE;
/*!40000 ALTER TABLE `system_uploads` DISABLE KEYS */;
/*!40000 ALTER TABLE `system_uploads` ENABLE KEYS */;
UNLOCK TABLES;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int unsigned NOT NULL DEFAULT '0' COMMENT '上级ID',
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `mobile` varchar(15) DEFAULT '' COMMENT '手机号',
  `email` varchar(50) NOT NULL DEFAULT '',
  `money` decimal(10,3) NOT NULL DEFAULT '0.000',
  `freeze_money` decimal(10,3) NOT NULL DEFAULT '0.000',
  `status` tinyint unsigned NOT NULL DEFAULT '1' COMMENT '0未审核 1已审核',
  `is_freeze` tinyint unsigned NOT NULL DEFAULT '0' COMMENT '是否冻结 0否 1是',
  `create_at` int unsigned NOT NULL,
  `ip` varchar(50) DEFAULT '' COMMENT 'IP地址',
  `shop_notice_auto_pop` tinyint NOT NULL DEFAULT '1' COMMENT '商家公告是否自动弹出',
  `cash_type` tinyint NOT NULL DEFAULT '1' COMMENT '提现方式 1自动 2手动',
  `shop_gouka_protocol_pop` tinyint NOT NULL DEFAULT '0' COMMENT '购卡协议是否自动弹出',
  `user_notice_auto_pop` tinyint NOT NULL DEFAULT '1' COMMENT '商家是否自动弹出',
  `fee_payer` tinyint NOT NULL DEFAULT '0' COMMENT '订单手续费支付方，0：跟随系统，1：商家承担，2买家承担',
  `settlement_type` tinyint NOT NULL DEFAULT '1' COMMENT '结算周期，1:T1结算，0:T0结算；只允许后台更改',
  `rate_type` tinyint(1) DEFAULT '0' COMMENT '0使用角色费率 1自定义通道费率',
  `fee_money` decimal(10,3) DEFAULT '0.000' COMMENT '预存金额',
  `avatar` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`) USING BTREE,
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_analysis` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL DEFAULT '0',
  `date` date NOT NULL,
  `day_amount` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT '交易额',
  `order_count` int NOT NULL DEFAULT '0',
  `finally_amount` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT '结算额',
  `profit` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT '利润',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `user_analysis` WRITE;
/*!40000 ALTER TABLE `user_analysis` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_analysis` ENABLE KEYS */;
UNLOCK TABLES;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_cash` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int unsigned NOT NULL,
  `type` tinyint unsigned NOT NULL COMMENT '收款产品类型 1支付宝 2微信',
  `collect_info` varchar(1024) NOT NULL DEFAULT '' COMMENT '提现信息',
  `money` decimal(10,2) unsigned NOT NULL COMMENT '提现金额',
  `fee` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '手续费',
  `actual_money` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '实际到账',
  `status` tinyint unsigned NOT NULL DEFAULT '0' COMMENT '状态 0审核中 1审核通过 2审核未通过',
  `create_at` int unsigned NOT NULL COMMENT '创建时间',
  `complete_at` int unsigned NOT NULL DEFAULT '0' COMMENT '完成时间',
  `collect_img` tinytext COMMENT '收款二维码',
  `auto_cash` tinyint NOT NULL DEFAULT '0' COMMENT '1 表示自动提现',
  `bank_name` varchar(50) NOT NULL DEFAULT '' COMMENT '银行名称',
  `bank_branch` varchar(150) NOT NULL DEFAULT '' COMMENT '开户地址',
  `bank_card` varchar(50) NOT NULL DEFAULT '' COMMENT '银行卡号',
  `realname` varchar(50) NOT NULL DEFAULT '' COMMENT '真实姓名',
  `idcard_number` varchar(50) NOT NULL DEFAULT '' COMMENT '身份证号码',
  `trade_no` varchar(50) NOT NULL DEFAULT '' COMMENT '订单号',
  `channel_account_id` int NOT NULL DEFAULT '0' COMMENT '代付账号',
  `channel_id` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `user_cash` WRITE;
/*!40000 ALTER TABLE `user_cash` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_cash` ENABLE KEYS */;
UNLOCK TABLES;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_channel` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int unsigned NOT NULL,
  `channel_id` int unsigned NOT NULL,
  `status` tinyint unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id` (`user_id`,`channel_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `user_channel` WRITE;
/*!40000 ALTER TABLE `user_channel` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_channel` ENABLE KEYS */;
UNLOCK TABLES;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_collect` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int unsigned NOT NULL,
  `type` tinyint unsigned NOT NULL DEFAULT '1' COMMENT '类型 1支付宝 2微信 3银行卡',
  `info` text NOT NULL,
  `create_at` int unsigned NOT NULL DEFAULT '0',
  `collect_img` tinytext,
  `allow_update` tinyint NOT NULL DEFAULT '0' COMMENT '1为允许用户修改收款信息',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `user_collect` WRITE;
/*!40000 ALTER TABLE `user_collect` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_collect` ENABLE KEYS */;
UNLOCK TABLES;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_log` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `ip` char(15) NOT NULL DEFAULT '' COMMENT '操作者IP地址',
  `params` varchar(255) NOT NULL DEFAULT '' COMMENT '参数',
  `user_id` int NOT NULL DEFAULT '0' COMMENT '操作人用户ID',
  `username` varchar(32) NOT NULL DEFAULT '' COMMENT '用户名',
  `action` varchar(200) NOT NULL DEFAULT '' COMMENT '操作行为',
  `content` text NOT NULL COMMENT '操作内容描述',
  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COMMENT='系统操作日志表';
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `user_log` WRITE;
/*!40000 ALTER TABLE `user_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_log` ENABLE KEYS */;
UNLOCK TABLES;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_login_error_log` (
  `id` int NOT NULL AUTO_INCREMENT,
  `login_name` varchar(50) NOT NULL DEFAULT '' COMMENT '登录名',
  `password` varchar(255) NOT NULL DEFAULT '' COMMENT '尝试密码',
  `user_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0：普通用户 1：后台管理员账号',
  `login_from` int NOT NULL DEFAULT '0' COMMENT '登录来源：0：前台 1：总后台',
  `login_time` int NOT NULL DEFAULT '0' COMMENT '登录时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `user_login_error_log` WRITE;
/*!40000 ALTER TABLE `user_login_error_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_login_error_log` ENABLE KEYS */;
UNLOCK TABLES;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_login_log` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int unsigned NOT NULL,
  `ip` varchar(15) NOT NULL DEFAULT '',
  `create_at` int unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `user_login_log` WRITE;
/*!40000 ALTER TABLE `user_login_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_login_log` ENABLE KEYS */;
UNLOCK TABLES;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_message` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `from_id` int unsigned NOT NULL DEFAULT '0' COMMENT '0为管理员',
  `to_id` int unsigned NOT NULL DEFAULT '0',
  `title` varchar(60) NOT NULL DEFAULT '',
  `content` varchar(1024) NOT NULL DEFAULT '',
  `status` tinyint NOT NULL DEFAULT '0' COMMENT '0未读  1已读',
  `create_at` int unsigned NOT NULL DEFAULT '0' COMMENT '发送时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `user_message` WRITE;
/*!40000 ALTER TABLE `user_message` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_message` ENABLE KEYS */;
UNLOCK TABLES;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_money_log` (
  `id` int NOT NULL AUTO_INCREMENT,
  `business_type` varchar(100) NOT NULL,
  `user_id` int unsigned NOT NULL COMMENT '用户ID',
  `from_user_id` int unsigned NOT NULL DEFAULT '0' COMMENT '来源用户ID',
  `agent_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '代理模式 1：普通代理 2：全站代理',
  `trade_no` varchar(255) NOT NULL DEFAULT '' COMMENT '相关订单号',
  `money` decimal(10,3) NOT NULL COMMENT '变动金额',
  `balance` decimal(10,3) NOT NULL COMMENT '剩余',
  `reason` varchar(255) NOT NULL DEFAULT '' COMMENT '变动原因',
  `create_at` int unsigned NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`),
  KEY `business_type` (`business_type`) USING BTREE,
  KEY `user_id` (`user_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `user_money_log` WRITE;
/*!40000 ALTER TABLE `user_money_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_money_log` ENABLE KEYS */;
UNLOCK TABLES;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_rate` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int unsigned NOT NULL COMMENT '用户ID',
  `channel_id` int unsigned NOT NULL COMMENT '渠道ID',
  `rate` decimal(10,4) unsigned NOT NULL COMMENT '费率',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id` (`user_id`,`channel_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `user_rate` WRITE;
/*!40000 ALTER TABLE `user_rate` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_rate` ENABLE KEYS */;
UNLOCK TABLES;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_role` (
  `id` int NOT NULL AUTO_INCREMENT,
  `role_pc` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `role_wap` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `name` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `remark` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `user_role` WRITE;
/*!40000 ALTER TABLE `user_role` DISABLE KEYS */;
INSERT INTO `user_role` VALUES (1,'1,4,6,7,8,165,166,167,163,164,184,2,10,11,158,169,170,171,12,13,14,15,16,17,18,19,20,21,24,23,25,140,26,137,27,28,31,29,5,30,32,33,185,151,3,152,153,154,155,156,157,159,161,176','1,10,24,27,29,151,3','默认分组',''),(2,'','','2',''),(3,'','','11',''),(4,'','','1111','');
/*!40000 ALTER TABLE `user_role` ENABLE KEYS */;
UNLOCK TABLES;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_role_rate` (
  `id` int NOT NULL AUTO_INCREMENT,
  `role_id` int NOT NULL,
  `channel_id` int NOT NULL,
  `rate` decimal(10,4) NOT NULL,
  `status` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `role_id` (`role_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `user_role_rate` WRITE;
/*!40000 ALTER TABLE `user_role_rate` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_role_rate` ENABLE KEYS */;
UNLOCK TABLES;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_role_relation` (
  `user_id` int NOT NULL,
  `role_id` int NOT NULL,
  UNIQUE KEY `user_id` (`user_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='会员关联role';
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `user_role_relation` WRITE;
/*!40000 ALTER TABLE `user_role_relation` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_role_relation` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

