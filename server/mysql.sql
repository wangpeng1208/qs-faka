/*M!999999\- enable the sandbox mode */ 
-- MariaDB dump 10.19  Distrib 10.11.10-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: f2_qqss_net
-- ------------------------------------------------------
-- Server version	10.11.10-MariaDB-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `admin_log`
--

DROP TABLE IF EXISTS `admin_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin_log` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `ip` char(15) NOT NULL DEFAULT '' COMMENT '操作者IP地址',
  `params` varchar(255) DEFAULT '',
  `username` varchar(32) NOT NULL DEFAULT '' COMMENT '操作人用户名',
  `action` varchar(200) NOT NULL DEFAULT '' COMMENT '操作行为',
  `content` text NOT NULL COMMENT '操作内容描述',
  `create_at` timestamp NOT NULL DEFAULT current_timestamp() COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci COMMENT='系统操作日志表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin_log`
--

LOCK TABLES `admin_log` WRITE;
/*!40000 ALTER TABLE `admin_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `admin_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `admin_menu`
--

DROP TABLE IF EXISTS `admin_menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin_menu` (
  `id` mediumint(9) NOT NULL AUTO_INCREMENT,
  `user_id` mediumint(9) NOT NULL,
  `menu_id` mediumint(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='用户快捷菜单';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin_menu`
--

LOCK TABLES `admin_menu` WRITE;
/*!40000 ALTER TABLE `admin_menu` DISABLE KEYS */;
INSERT INTO `admin_menu` VALUES
(40,1,38),
(41,1,35),
(42,1,40),
(43,1,43),
(47,1,47),
(49,1,62),
(50,1,135),
(51,1,98),
(52,1,150);
/*!40000 ALTER TABLE `admin_menu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `admin_role_relation`
--

DROP TABLE IF EXISTS `admin_role_relation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin_role_relation` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `role_id` int(11) NOT NULL COMMENT '角色id',
  `admin_id` int(11) NOT NULL COMMENT '管理员id',
  PRIMARY KEY (`id`),
  UNIQUE KEY `role_admin_id` (`role_id`,`admin_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='管理员角色表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin_role_relation`
--

LOCK TABLES `admin_role_relation` WRITE;
/*!40000 ALTER TABLE `admin_role_relation` DISABLE KEYS */;
INSERT INTO `admin_role_relation` VALUES
(1,1,1);
/*!40000 ALTER TABLE `admin_role_relation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `admin_roles`
--

DROP TABLE IF EXISTS `admin_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin_roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `name` varchar(80) NOT NULL COMMENT '角色组',
  `rules` text DEFAULT NULL COMMENT '权限',
  `created_at` datetime NOT NULL COMMENT '创建时间',
  `updated_at` datetime NOT NULL COMMENT '更新时间',
  `pid` int(10) unsigned DEFAULT NULL COMMENT '父级',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='管理员角色';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin_roles`
--

LOCK TABLES `admin_roles` WRITE;
/*!40000 ALTER TABLE `admin_roles` DISABLE KEYS */;
INSERT INTO `admin_roles` VALUES
(1,'超级管理员','*','2022-08-13 16:15:01','2022-12-23 12:05:07',0);
/*!40000 ALTER TABLE `admin_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `admin_user`
--

DROP TABLE IF EXISTS `admin_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `username` varchar(32) NOT NULL COMMENT '用户名',
  `nickname` varchar(40) NOT NULL COMMENT '昵称',
  `password` varchar(255) NOT NULL COMMENT '密码',
  `avatar` varchar(255) DEFAULT '/app/admin/avatar.png' COMMENT '头像',
  `email` varchar(100) DEFAULT NULL COMMENT '邮箱',
  `mobile` varchar(16) DEFAULT NULL COMMENT '手机',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `login_at` datetime DEFAULT NULL COMMENT '登录时间',
  `status` tinyint(4) DEFAULT 1 COMMENT '禁用',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='管理员表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin_user`
--

LOCK TABLES `admin_user` WRITE;
/*!40000 ALTER TABLE `admin_user` DISABLE KEYS */;
INSERT INTO `admin_user` VALUES
(1,'admin','超级管理员','$2y$10$Nm1O59pvJimLXHGmb0/a2OEdbw1VSwzNJsK0qkeyjUSn16/HimuRG','http://f2.qqss.net/static/common/images/noavatar.svg','','','2023-04-29 17:09:09','2024-02-18 15:16:51','2024-02-18 15:16:51',NULL);
/*!40000 ALTER TABLE `admin_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `article`
--

DROP TABLE IF EXISTS `article`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `article` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `cate_id` int(10) unsigned NOT NULL DEFAULT 0 COMMENT '文章栏目',
  `title` varchar(50) NOT NULL DEFAULT '' COMMENT '文章标题',
  `title_img` varchar(255) NOT NULL DEFAULT '' COMMENT '标题图',
  `content` text NOT NULL COMMENT '文章内容',
  `status` tinyint(4) NOT NULL DEFAULT 0 COMMENT '文章状态',
  `views` int(10) unsigned NOT NULL DEFAULT 0 COMMENT '浏览量',
  `create_at` int(10) unsigned NOT NULL COMMENT '创建时间',
  `update_at` int(10) unsigned NOT NULL DEFAULT 0 COMMENT '更新时间',
  `is_system` tinyint(1) NOT NULL DEFAULT 0 COMMENT '系统调用',
  `top` tinyint(1) NOT NULL DEFAULT 0 COMMENT '置顶',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci COMMENT='文章表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `article`
--

LOCK TABLES `article` WRITE;
/*!40000 ALTER TABLE `article` DISABLE KEYS */;
/*!40000 ALTER TABLE `article` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `article_category`
--

DROP TABLE IF EXISTS `article_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `article_category` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `pid` int(10) unsigned NOT NULL DEFAULT 0 COMMENT '父ID',
  `path` varchar(1024) NOT NULL COMMENT '路径',
  `name` varchar(30) NOT NULL DEFAULT '' COMMENT '名称',
  `alias` varchar(30) NOT NULL DEFAULT '' COMMENT '别名',
  `remark` varchar(255) NOT NULL DEFAULT '' COMMENT '备注',
  `status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '状态',
  `create_at` int(10) unsigned NOT NULL COMMENT '创建时间',
  `update_at` int(10) unsigned DEFAULT 0 COMMENT '更新时间',
  `type` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1前台列表；2后台列表；3单页',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci COMMENT='文章栏目表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `article_category`
--

LOCK TABLES `article_category` WRITE;
/*!40000 ALTER TABLE `article_category` DISABLE KEYS */;
/*!40000 ALTER TABLE `article_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `article_read`
--

DROP TABLE IF EXISTS `article_read`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `article_read` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `news_id` int(11) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `article_read`
--

LOCK TABLES `article_read` WRITE;
/*!40000 ALTER TABLE `article_read` DISABLE KEYS */;
/*!40000 ALTER TABLE `article_read` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `goods`
--

DROP TABLE IF EXISTS `goods`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `goods` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `cate_id` int(10) unsigned NOT NULL,
  `theme` varchar(15) NOT NULL DEFAULT 'default' COMMENT '主题',
  `sort` int(10) unsigned NOT NULL DEFAULT 0 COMMENT '排序',
  `name` varchar(500) NOT NULL DEFAULT '',
  `price` decimal(10,2) unsigned NOT NULL DEFAULT 0.00,
  `cost_price` decimal(10,2) unsigned NOT NULL DEFAULT 0.00 COMMENT '成本价',
  `wholesale_discount` tinyint(3) unsigned NOT NULL DEFAULT 0 COMMENT '批发优惠',
  `wholesale_discount_list` varchar(255) DEFAULT NULL COMMENT '批发价',
  `limit_quantity_max` int(10) NOT NULL DEFAULT 0 COMMENT '限购数量',
  `limit_quantity` int(10) unsigned NOT NULL DEFAULT 0 COMMENT '起购数量',
  `inventory_notify` tinyint(3) unsigned NOT NULL DEFAULT 0 COMMENT '库存预警 0表示不报警',
  `inventory_notify_type` tinyint(3) unsigned NOT NULL DEFAULT 1 COMMENT '库存预警通知方式 1站内信 2邮件',
  `coupon_type` tinyint(3) unsigned NOT NULL DEFAULT 0 COMMENT '优惠券 0不支持 1支持',
  `sold_notify` tinyint(3) unsigned NOT NULL DEFAULT 0 COMMENT '售出通知',
  `take_card_type` tinyint(3) unsigned NOT NULL DEFAULT 0 COMMENT '取卡密码 0关闭 1必填 2选填',
  `visit_type` tinyint(3) unsigned NOT NULL DEFAULT 0 COMMENT '访问密码',
  `visit_password` varchar(30) NOT NULL DEFAULT '' COMMENT '访问密码',
  `contact_limit` enum('mobile','email','qq','any','default') NOT NULL DEFAULT 'default' COMMENT '客户信息',
  `content` text NOT NULL COMMENT '商品说明',
  `remark` varchar(200) NOT NULL DEFAULT '' COMMENT '使用说明',
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '0下架 1上架',
  `create_at` int(10) unsigned NOT NULL DEFAULT 0,
  `is_freeze` tinyint(4) DEFAULT 0,
  `sms_payer` tinyint(3) unsigned NOT NULL DEFAULT 0 COMMENT '短信付费方：0买家 1商户',
  `delete_at` int(11) DEFAULT NULL COMMENT '删除标记',
  `card_order` tinyint(3) NOT NULL DEFAULT 0 COMMENT '发卡顺序 0现卖老卡 1先卖新卡',
  `event_give` varchar(255) DEFAULT NULL COMMENT '活动赠送',
  `addtion_give` varchar(255) DEFAULT NULL COMMENT '附加赠送',
  `mobile_theme` varchar(255) NOT NULL DEFAULT 'default',
  PRIMARY KEY (`id`),
  KEY `cate_id` (`cate_id`) USING BTREE,
  KEY `user_id` (`user_id`) USING BTREE,
  KEY `stauts` (`status`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `goods`
--

LOCK TABLES `goods` WRITE;
/*!40000 ALTER TABLE `goods` DISABLE KEYS */;
/*!40000 ALTER TABLE `goods` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `goods_card`
--

DROP TABLE IF EXISTS `goods_card`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `goods_card` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `user_id` int(10) unsigned NOT NULL COMMENT '用户id',
  `goods_id` int(10) unsigned NOT NULL COMMENT '商品id',
  `number` text DEFAULT NULL COMMENT '卡号',
  `secret` text DEFAULT NULL COMMENT '卡密',
  `status` tinyint(3) NOT NULL DEFAULT 1 COMMENT '-1删除 0不可用 1可用 2已使用',
  `create_at` int(10) unsigned NOT NULL DEFAULT 0 COMMENT '创建时间',
  `delete_at` int(11) DEFAULT NULL COMMENT '删除标记',
  `sell_time` int(11) DEFAULT NULL COMMENT '售出时间',
  `is_cross` tinyint(4) DEFAULT 0,
  `is_first` int(11) DEFAULT 0 COMMENT '优先销售',
  `unfreeze_at` int(11) DEFAULT 0 COMMENT '锁卡时间',
  `is_pre` smallint(1) NOT NULL DEFAULT 0 COMMENT '是否显示前缀',
  PRIMARY KEY (`id`),
  KEY `goods_card_goods_id_index` (`goods_id`),
  KEY `delete_at` (`delete_at`),
  KEY `unfreeze_at` (`unfreeze_at`),
  KEY `idx_goods_status_unfreeze_delete` (`goods_id`,`status`,`unfreeze_at`,`delete_at`),
  KEY `status` (`status`),
  KEY `idx_user_status_delete` (`user_id`,`status`,`delete_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `goods_card`
--

LOCK TABLES `goods_card` WRITE;
/*!40000 ALTER TABLE `goods_card` DISABLE KEYS */;
/*!40000 ALTER TABLE `goods_card` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `goods_category`
--

DROP TABLE IF EXISTS `goods_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `goods_category` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `name` varchar(100) NOT NULL,
  `sort` int(10) unsigned NOT NULL DEFAULT 0,
  `status` tinyint(4) NOT NULL,
  `create_at` int(10) unsigned NOT NULL,
  `theme` varchar(15) NOT NULL DEFAULT 'default' COMMENT '主题',
  `mobile_theme` varchar(50) NOT NULL DEFAULT '' COMMENT '手机版主题',
  `is_show` tinyint(1) NOT NULL DEFAULT 1 COMMENT '首页显示1，不显示0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `goods_category`
--

LOCK TABLES `goods_category` WRITE;
/*!40000 ALTER TABLE `goods_category` DISABLE KEYS */;
/*!40000 ALTER TABLE `goods_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `goods_coupon`
--

DROP TABLE IF EXISTS `goods_coupon`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `goods_coupon` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `cate_id` int(10) unsigned NOT NULL DEFAULT 0 COMMENT '全部',
  `type` tinyint(3) unsigned NOT NULL DEFAULT 1 COMMENT '类型 1、元  100、%',
  `amount` decimal(10,2) unsigned NOT NULL DEFAULT 0.00,
  `code` varchar(255) NOT NULL DEFAULT '',
  `remark` varchar(100) NOT NULL DEFAULT '' COMMENT '备注',
  `status` tinyint(3) unsigned NOT NULL DEFAULT 1 COMMENT '1未使用 2已用',
  `expire_at` int(10) unsigned NOT NULL,
  `create_at` int(10) unsigned NOT NULL,
  `delete_at` int(11) DEFAULT NULL COMMENT '删除标记',
  `min_banlance` int(11) DEFAULT 0 COMMENT '最低使用限额',
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id` (`user_id`,`code`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `goods_coupon`
--

LOCK TABLES `goods_coupon` WRITE;
/*!40000 ALTER TABLE `goods_coupon` DISABLE KEYS */;
/*!40000 ALTER TABLE `goods_coupon` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order`
--

DROP TABLE IF EXISTS `order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `goods_id` int(10) unsigned NOT NULL,
  `trade_no` varchar(255) DEFAULT NULL,
  `transaction_id` varchar(60) NOT NULL DEFAULT '' COMMENT '流水号',
  `paytype` tinyint(3) unsigned NOT NULL DEFAULT 0,
  `channel_id` int(10) unsigned NOT NULL DEFAULT 0 COMMENT '支付渠道',
  `channel_account_id` int(10) unsigned NOT NULL DEFAULT 0 COMMENT '渠道账号',
  `goods_name` varchar(500) NOT NULL DEFAULT '' COMMENT '商品名称',
  `goods_price` decimal(10,3) unsigned NOT NULL DEFAULT 0.000 COMMENT '商品单价',
  `goods_cost_price` decimal(10,3) unsigned NOT NULL DEFAULT 0.000 COMMENT '成本价',
  `quantity` int(10) unsigned NOT NULL DEFAULT 0 COMMENT '数量',
  `coupon_type` tinyint(3) unsigned NOT NULL DEFAULT 0 COMMENT '是否使用优惠券',
  `coupon_id` int(10) unsigned NOT NULL DEFAULT 0 COMMENT '优惠券ID',
  `coupon_price` decimal(10,3) unsigned NOT NULL DEFAULT 0.000 COMMENT '优惠价格',
  `total_price` decimal(10,3) unsigned NOT NULL DEFAULT 0.000 COMMENT '总价（买家实付款）',
  `total_cost_price` decimal(10,3) unsigned NOT NULL DEFAULT 0.000 COMMENT '总成本价',
  `sold_notify` tinyint(3) unsigned NOT NULL DEFAULT 0 COMMENT '售出通知（买家）',
  `take_card_type` tinyint(3) unsigned NOT NULL DEFAULT 0 COMMENT '是否需要取卡密码',
  `take_card_password` varchar(20) NOT NULL DEFAULT '' COMMENT '取卡密码',
  `contact` varchar(20) NOT NULL DEFAULT '' COMMENT '联系方式',
  `email_notify` tinyint(3) unsigned NOT NULL DEFAULT 0 COMMENT '是否邮件通知',
  `email` varchar(60) NOT NULL DEFAULT '' COMMENT '邮箱号',
  `sms_notify` tinyint(3) unsigned NOT NULL DEFAULT 0 COMMENT '是否短信通知',
  `rate` decimal(10,4) unsigned NOT NULL DEFAULT 0.0000 COMMENT '手续费率',
  `fee` decimal(10,3) unsigned NOT NULL DEFAULT 0.000 COMMENT '手续费',
  `sms_price` decimal(10,3) unsigned NOT NULL DEFAULT 0.000 COMMENT '短信费',
  `status` tinyint(3) NOT NULL DEFAULT 0 COMMENT '订单状态 0未支付 1已支付 2已关闭 3已退款',
  `is_freeze` tinyint(3) unsigned NOT NULL DEFAULT 0 COMMENT '冻结状态',
  `create_at` int(10) unsigned NOT NULL COMMENT '创建时间',
  `create_ip` varchar(15) NOT NULL DEFAULT '' COMMENT 'IP',
  `success_at` int(10) unsigned NOT NULL DEFAULT 0 COMMENT '支付成功时间',
  `first_query` tinyint(4) NOT NULL DEFAULT 0 COMMENT '订单第一次查询无需验证码',
  `sms_payer` tinyint(3) unsigned NOT NULL DEFAULT 0 COMMENT '短信付费方：0买家 1商户',
  `total_product_price` decimal(10,3) unsigned NOT NULL DEFAULT 0.000 COMMENT '商品总价（不含短信费）',
  `sendout` int(10) unsigned NOT NULL DEFAULT 0 COMMENT '已发货数量',
  `fee_payer` tinyint(4) NOT NULL DEFAULT 1 COMMENT '订单手续费支付方，1：商家承担，2买家承担',
  `settlement_type` tinyint(4) unsigned NOT NULL DEFAULT 1 COMMENT '结算方式，1:T1结算，0:T0结算',
  `finally_money` decimal(10,4) NOT NULL DEFAULT 0.0000 COMMENT '商户订单最终收入（已扣除短信费，手续费）',
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order`
--

LOCK TABLES `order` WRITE;
/*!40000 ALTER TABLE `order` DISABLE KEYS */;
/*!40000 ALTER TABLE `order` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_card`
--

DROP TABLE IF EXISTS `order_card`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_card` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` int(10) unsigned NOT NULL,
  `number` text DEFAULT NULL,
  `secret` text DEFAULT NULL,
  `card_id` int(10) NOT NULL DEFAULT 0 COMMENT '虚拟卡ID',
  PRIMARY KEY (`id`),
  KEY `order_card_order_id_index` (`order_id`),
  KEY `order_card_card_id_index` (`card_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_card`
--

LOCK TABLES `order_card` WRITE;
/*!40000 ALTER TABLE `order_card` DISABLE KEYS */;
/*!40000 ALTER TABLE `order_card` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_complaint`
--

DROP TABLE IF EXISTS `order_complaint`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_complaint` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `trade_no` char(50) NOT NULL DEFAULT '',
  `type` varchar(20) NOT NULL DEFAULT '',
  `qq` varchar(15) NOT NULL DEFAULT '',
  `mobile` varchar(15) NOT NULL DEFAULT '',
  `desc` varchar(1000) NOT NULL DEFAULT '',
  `status` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0待处理 1已处理',
  `admin_read` tinyint(3) unsigned NOT NULL DEFAULT 0 COMMENT '管理员查看状态',
  `create_at` int(10) unsigned NOT NULL,
  `create_ip` varchar(15) NOT NULL DEFAULT '',
  `pwd` char(10) NOT NULL DEFAULT '123456' COMMENT '投诉单查询密码',
  `result` tinyint(4) NOT NULL DEFAULT 0 COMMENT '申诉结果',
  `expire_at` int(10) unsigned NOT NULL DEFAULT 0 COMMENT '申诉过期时间',
  `proxy_parent_user_id` int(10) unsigned NOT NULL DEFAULT 0 COMMENT '上级代理商ID',
  `buyer_qrcode` varchar(1000) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_complaint`
--

LOCK TABLES `order_complaint` WRITE;
/*!40000 ALTER TABLE `order_complaint` DISABLE KEYS */;
/*!40000 ALTER TABLE `order_complaint` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_complaint_message`
--

DROP TABLE IF EXISTS `order_complaint_message`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_complaint_message` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `trade_no` varchar(255) NOT NULL DEFAULT '0' COMMENT '投诉所属订单',
  `from` int(10) unsigned NOT NULL DEFAULT 0 COMMENT '发送人，0为管理员发送的消息',
  `content` varchar(1024) NOT NULL DEFAULT '' COMMENT '对话内容',
  `status` tinyint(3) NOT NULL DEFAULT 0 COMMENT '0未读  1已读',
  `create_at` int(10) unsigned NOT NULL DEFAULT 0 COMMENT '发送时间',
  `type` varchar(255) NOT NULL DEFAULT '0' COMMENT '消息属性：admin merchant',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci COMMENT='投诉会话信息';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_complaint_message`
--

LOCK TABLES `order_complaint_message` WRITE;
/*!40000 ALTER TABLE `order_complaint_message` DISABLE KEYS */;
/*!40000 ALTER TABLE `order_complaint_message` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_master`
--

DROP TABLE IF EXISTS `order_master`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_master` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `trade_no` varchar(255) DEFAULT NULL,
  `model` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_master`
--

LOCK TABLES `order_master` WRITE;
/*!40000 ALTER TABLE `order_master` DISABLE KEYS */;
/*!40000 ALTER TABLE `order_master` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pay_auto_unfreeze`
--

DROP TABLE IF EXISTS `pay_auto_unfreeze`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pay_auto_unfreeze` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL DEFAULT 0 COMMENT '用户id',
  `money` decimal(10,3) unsigned NOT NULL DEFAULT 0.000 COMMENT '冻结金额',
  `unfreeze_time` int(11) NOT NULL DEFAULT 0 COMMENT '解冻时间',
  `created_at` int(11) NOT NULL DEFAULT 0 COMMENT '更新时间',
  `trade_no` varchar(255) NOT NULL DEFAULT '0' COMMENT '冻结资金来源订单号',
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '冻结资金记录状态，1：可用，-1：不可用（订单申诉中等情况）',
  PRIMARY KEY (`id`),
  KEY `unfreeze_time` (`unfreeze_time`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci COMMENT='订单金额T+1日自动解冻表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pay_auto_unfreeze`
--

LOCK TABLES `pay_auto_unfreeze` WRITE;
/*!40000 ALTER TABLE `pay_auto_unfreeze` DISABLE KEYS */;
/*!40000 ALTER TABLE `pay_auto_unfreeze` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pay_channel`
--

DROP TABLE IF EXISTS `pay_channel`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pay_channel` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '通道ID',
  `title` varchar(255) NOT NULL DEFAULT '' COMMENT '通道名称',
  `code` varchar(50) NOT NULL DEFAULT '' COMMENT '通道代码',
  `status` tinyint(1) unsigned NOT NULL DEFAULT 0 COMMENT '状态 1 开启 0 关闭',
  `lowrate` decimal(10,4) unsigned NOT NULL DEFAULT 0.0000 COMMENT '充值费率',
  `accounting_date` tinyint(3) unsigned NOT NULL DEFAULT 1 COMMENT '结算时间 1、D0 2、D1 3、T0 4、T1',
  `account_fields` varchar(1024) NOT NULL DEFAULT '' COMMENT '账户字段',
  `updatetime` int(11) unsigned NOT NULL DEFAULT 0 COMMENT '更新时间',
  `paytype` tinyint(1) unsigned NOT NULL DEFAULT 0 COMMENT '支付类型 1 微信扫码 2 微信公众号 3 支付宝扫码 4 支付宝手机 5 网银支付 6',
  `show_name` varchar(255) NOT NULL DEFAULT '' COMMENT '前台展示名称',
  `is_available` tinyint(4) NOT NULL DEFAULT 0 COMMENT '接口可用 0通用 1手机 2电脑',
  `default_fields` varchar(1024) NOT NULL DEFAULT '' COMMENT '字段默认值',
  `sort` int(10) NOT NULL DEFAULT 0 COMMENT '渠道排序',
  `type` tinyint(1) NOT NULL DEFAULT 1 COMMENT '类型：1支付，2提现',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci COMMENT='支付网关';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pay_channel`
--

LOCK TABLES `pay_channel` WRITE;
/*!40000 ALTER TABLE `pay_channel` DISABLE KEYS */;
INSERT INTO `pay_channel` VALUES
(1,'支付宝网页支付','AlipayWeb',1,0.0300,1,'支付宝app_id:app_id|应用秘钥:app_secret_cert|应用公钥证书:app_public_cert_path|支付宝公钥证书:alipay_public_cert_path|支付宝根证书:alipay_root_cert_path',0,1,'支付宝',2,'','1',0,1),
(2,'打款','AliTransfer',1,0.0000,1,'支付宝app_id:app_id|应用秘钥:app_secret_cert|应用公钥证书:app_public_cert_path|支付宝公钥证书:alipay_public_cert_path|支付宝根证书:alipay_root_cert_path',0,1,'支付宝证书转账',0,'','',0,2);
/*!40000 ALTER TABLE `pay_channel` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pay_channel_account`
--

DROP TABLE IF EXISTS `pay_channel_account`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pay_channel_account` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `channel_id` int(10) unsigned NOT NULL COMMENT '渠道ID',
  `name` varchar(32) NOT NULL DEFAULT '' COMMENT '账户名',
  `params` text NOT NULL COMMENT '参数',
  `status` tinyint(3) unsigned NOT NULL DEFAULT 0 COMMENT '状态 1启用 0禁用',
  `lowrate` decimal(10,4) unsigned NOT NULL DEFAULT 0.0000 COMMENT '充值费率',
  `rate_type` tinyint(4) NOT NULL DEFAULT 0 COMMENT '费率设置 0 继承接口  1单独设置',
  `user_id` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pay_channel_account`
--

LOCK TABLES `pay_channel_account` WRITE;
/*!40000 ALTER TABLE `pay_channel_account` DISABLE KEYS */;
/*!40000 ALTER TABLE `pay_channel_account` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pay_type`
--

DROP TABLE IF EXISTS `pay_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pay_type` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL COMMENT '支付名',
  `logo` varchar(255) NOT NULL DEFAULT '' COMMENT 'logo',
  `ico` varchar(255) NOT NULL DEFAULT '' COMMENT '图标',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci COMMENT='支付类型表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pay_type`
--

LOCK TABLES `pay_type` WRITE;
/*!40000 ALTER TABLE `pay_type` DISABLE KEYS */;
INSERT INTO `pay_type` VALUES
(1,'支付宝','/static/payment/icon_zfb.jpg','/static/payment/zfb.png'),
(2,'支付宝H5','/static/payment/icon_zfb.jpg','/static/payment/zfb.png'),
(3,'微信','/static/payment/icon_wx.jpg','/static/payment/wx.png'),
(4,'微信H5','/static/payment/icon_wx.jpg','/static/payment/wx.png'),
(5,'QQ钱包扫码','/static/payment/icon_qq.jpg','/static/payment/qq.png'),
(6,'QQ钱包H5','/static/payment/icon_qq.jpg','/static/payment/qq.png'),
(7,'网银支付','/static/payment/icon_bank.jpg','/static/payment/bank.png'),
(9,'京东钱包','/static/payment/icon_jd.jpg','/static/payment/icon_jd.jpg'),
(10,'度小满支付','/static/payment/icon_bd.jpg','/static/payment/bd.png');
/*!40000 ALTER TABLE `pay_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shop_link`
--

DROP TABLE IF EXISTS `shop_link`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shop_link` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL DEFAULT 0,
  `relation_type` varchar(20) NOT NULL DEFAULT '',
  `relation_id` int(10) unsigned NOT NULL DEFAULT 0,
  `token` char(16) NOT NULL DEFAULT '',
  `short_url` varchar(30) NOT NULL,
  `status` tinyint(3) unsigned NOT NULL,
  `create_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id` (`user_id`,`relation_type`,`relation_id`),
  UNIQUE KEY `token_uindex` (`token`),
  UNIQUE KEY `user_link_index` (`relation_id`,`relation_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shop_link`
--

LOCK TABLES `shop_link` WRITE;
/*!40000 ALTER TABLE `shop_link` DISABLE KEYS */;
/*!40000 ALTER TABLE `shop_link` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shop_list`
--

DROP TABLE IF EXISTS `shop_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shop_list` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NOT NULL COMMENT '用户id',
  `shop_name` varchar(20) DEFAULT NULL COMMENT '商铺名称',
  `shop_notice_show` tinyint(1) NOT NULL DEFAULT 0,
  `shop_notice` varchar(200) DEFAULT NULL COMMENT '公告通知',
  `shop_status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '店铺状态:通过审核后1',
  `shop_verify` tinyint(1) NOT NULL DEFAULT 0 COMMENT '审核状态：0待审核；-1审核中，1通过',
  `shop_freeze` tinyint(1) NOT NULL DEFAULT 0 COMMENT '是否冻结 0否 1是',
  `create_at` int(10) DEFAULT NULL COMMENT '店铺通过时间',
  `merchant_end_time` int(10) DEFAULT NULL COMMENT '店铺过期时间',
  `pc_template` varchar(50) NOT NULL DEFAULT 'default' COMMENT '店铺电脑端模板',
  `mobile_template` varchar(50) NOT NULL DEFAULT 'default' COMMENT '店铺手机端模板',
  `shop_qq` varchar(16) DEFAULT NULL COMMENT '店铺QQ',
  `pay_theme` varchar(50) NOT NULL DEFAULT 'default' COMMENT '支付页风格',
  `pay_theme_mobile` varchar(50) NOT NULL DEFAULT 'default' COMMENT '支付模板手机端',
  `stock_display` tinyint(3) unsigned NOT NULL DEFAULT 2 COMMENT '库存展示方式 1实际库存 2库存范围	',
  `merchant_time` int(11) DEFAULT NULL COMMENT '开店时间',
  `shop_contact` varchar(100) DEFAULT '{qq: '''',mobile: '''',wechat: ''''}' COMMENT '店铺联系方式',
  `show_contact` int(1) NOT NULL DEFAULT 0 COMMENT '是否显示店铺联系方式0不显示1显示',
  `shop_close` tinyint(1) NOT NULL DEFAULT 0 COMMENT '是否关闭店铺 0否 1是',
  `fee_payer` tinyint(4) DEFAULT 0 COMMENT '订单手续费支付方，0：跟随系统，1：商家承担，2买家承担',
  `shop_close_notice` varchar(255) DEFAULT '店铺歇业中' COMMENT '歇业提示语',
  `shop_logo` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='商户资料表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shop_list`
--

LOCK TABLES `shop_list` WRITE;
/*!40000 ALTER TABLE `shop_list` DISABLE KEYS */;
/*!40000 ALTER TABLE `shop_list` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `system_config`
--

DROP TABLE IF EXISTS `system_config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `system_config` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL COMMENT '配置编码',
  `value` mediumtext DEFAULT NULL COMMENT '配置值',
  PRIMARY KEY (`id`),
  KEY `index_system_config_name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=80 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci ROW_FORMAT=COMPACT COMMENT='系统参数配置';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `system_config`
--

LOCK TABLES `system_config` WRITE;
/*!40000 ALTER TABLE `system_config` DISABLE KEYS */;
INSERT INTO `system_config` (`id`, `name`, `value`) VALUES
(1, 'site_status', '1'),
(2, 'site_close_tips', ''),
(3, 'site_name', '骑士寄售开源版演示'),
(4, 'site_subtitle', '骑士寄售免费开源版'),
(5, 'site_keywords', '骑士寄售免费开源版'),
(6, 'site_desc', '11111'),
(7, 'site_logo', 'http://f2.qqss.net/upload/admin/1/image/20240816/66bee6f3310e.png'),
(8, 'merchant_logo', 'http://f2.qqss.net/upload/admin/1/image/20240816/66bee6f63c0f.png'),
(9, 'merchant_logo_sm', 'http://f2.qqss.net/upload/admin/1/image/20240816/66bee6d7507a.png'),
(10, 'site_info_address', '河南平顶山'),
(11, 'site_info_email', '123456@qq.com'),
(12, 'site_info_copyright', '© 2022-2025 f2.qqss.net 公司：xxx'),
(13, 'site_shop_copyright', ''),
(14, 'site_info_icp', '豫ICP备2024064321'),
(15, 'site_info_tel', '15612341234'),
(16, 'site_info_tel_desc', ''),
(17, 'site_info_qq', '123456'),
(18, 'site_info_qq_desc', '7*24小时'),
(19, 'site_domain', 'http://f2.qqss.net'),
(20, 'site_shop_domain', 'http://f2.qqss.net'),
(21, 'site_domain_short', 'Suo'),
(26, 'site_wordfilter_status', '0'),
(27, 'site_wordfilter_danger', ''),
(28, 'site_register_status', '1'),
(29, 'site_register_need_username', '1'),
(30, 'site_register_need_mobile', '0'),
(31, 'site_register_need_mobile_check', ''),
(32, 'site_register_need_email', '0'),
(33, 'site_register_need_email_check', '0'),
(34, 'site_register_smscode_max_count', '3'),
(35, 'site_register_smscode_max_time', '60'),
(36, 'sms_error_limit', '5'),
(37, 'sms_error_time', '10'),
(38, 'site_register_smscode_expire_time', '300'),
(39, 'ip_register_limit', '5'),
(40, 'site_register_verify', '1'),
(47, 'order_trade_no_type', '0'),
(48, 'order_trade_no_profix', ''),
(49, 'order_title_type', '2'),
(50, 'order_title_profix', 'T'),
(51, 'order_title_str', ''),
(52, 'order_auto_close_time', '5'),
(53, 'order_query_blackcontact', ''),
(54, 'complaint_refund', '0'),
(55, 'transaction_min_fee', '0'),
(56, 'fee_payer', '1'),
(57, 'purchase_agreement', ''),
(58, 'settlement_type', ''),
(59, 'settlement_frezze_endtime', ''),
(60, 'cash_status', '1'),
(61, 'auto_cash', '0'),
(62, 'auto_cash_time', '3'),
(63, 'cash_type', '[1,2,3]'),
(64, 'auto_cash_money', '50'),
(65, 'cash_close_tips', '满50每天12点自动结算，无须手动结算。'),
(66, 'cash_limit_time_start', '10'),
(67, 'cash_limit_time_end', '18'),
(68, 'cash_min_money', '50'),
(69, 'cash_fee_type', '100'),
(70, 'cash_fee', '1'),
(71, 'auto_cash_fee_type', '100'),
(72, 'auto_cash_fee', '0'),
(73, 'cash_limit_num', '5'),
(74, 'cash_limit_num_tips', '已达到今日最多提现次数！'),
(75, 'cash_weixinnotify_open', '0'),
(76, 'cash_emailnotify_open', '1'),
(79, 'sms.qcloud', '{\"status\":1}'),
(80, 'site_shortlink_other_option', '{\n  \"api\": \"http://api.3wt.cn/api.htm\",\n  \"from\": \"url\",\n  \"method\": \"get\",\n  \"params\": {\n    \"format\": \"json\",\n    \"key\": \"6209ae6d41fb7cd01413eb4d45@ebe9e520aa886c17517c5aad213d730e\",\n    \"domain\": \"21\"\n  }\n}');
/*!40000 ALTER TABLE `system_config` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `system_menu`
--

DROP TABLE IF EXISTS `system_menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `system_menu` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `path` varchar(20) NOT NULL,
  `title` varchar(20) NOT NULL,
  `component` varchar(255) NOT NULL,
  `icon` varchar(100) DEFAULT NULL,
  `pid` int(10) NOT NULL DEFAULT 0,
  `app` varchar(10) NOT NULL DEFAULT 'pc' COMMENT '应用',
  `orderNo` tinyint(3) unsigned NOT NULL DEFAULT 0,
  `hidden` tinyint(1) NOT NULL DEFAULT 0,
  `redirect` varchar(50) DEFAULT NULL,
  `type` varchar(5) NOT NULL DEFAULT 'M' COMMENT '类型',
  `perms` varchar(255) DEFAULT NULL COMMENT '权限标识',
  `keep_alive` tinyint(1) DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=185 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `system_menu`
--

LOCK TABLES `system_menu` WRITE;
/*!40000 ALTER TABLE `system_menu` DISABLE KEYS */;

INSERT INTO `system_menu` (`id`, `name`, `path`, `title`, `component`, `icon`, `pid`, `app`, `orderNo`, `hidden`, `redirect`, `type`, `perms`, `keep_alive`, `status`) VALUES
(1, 'merchantUser', 'user', '我的账户', 'Layout', 'user-1', 0, 'merchant', 2, 0, '/merchant/user/setting', 'L', '', 0, 1),
(2, 'merchantWorkbench', 'workbench', '信息汇总', 'merchant/workbench/index', 'laptop', 0, 'merchant', 0, 0, '', 'M', 'merchantapi/workbench/index', 0, 1),
(3, 'merchantUserLink', 'link', '店铺链接', 'merchant/shop/link/index', '', 151, 'merchant', 0, 0, '', 'M', '11', 0, 1),
(4, 'merchantUserSetting', 'setting', '商户信息', 'merchant/user/setting/index', '', 1, 'merchant', 0, 0, '', 'M', NULL, 0, 1),
(5, 'merchantFinanceCash', 'cash/index', '提现记录', 'merchant/finance/cash/index', '', 29, 'merchant', 5, 0, '', 'M', NULL, 0, 1),
(6, 'merchantUserLoginLog', 'loginlog', '登录日志', 'merchant/user/loginLog/index', '', 1, 'merchant', 0, 0, '', 'M', 'merchantapi/user/loginLog', 0, 1),
(7, 'merchantUserPassword', 'password', '修改密码', 'merchant/user/password/index', '', 1, 'merchant', 0, 1, '', 'M', NULL, 0, 1),
(8, 'merchantUserNotice', 'message', '通知列表', 'merchant/user/message/index', '', 1, 'merchant', 0, 1, '', 'M', 'merchantapi/user/message/list', 0, 1),
(10, 'merchantGoods', 'goods', '商品管理', 'Layout', 'shop', 0, 'merchant', 3, 0, '/merchant/goods/category', 'L', '', 0, 1),
(11, 'merchantGoodsCategory', 'category', '商品分类', 'merchant/goods/category/index', '', 10, 'merchant', 0, 0, '', 'M', 'merchantapi/goods/category/list', 0, 1),
(12, 'merchantGoodsAdd', 'add', '添加商品', 'merchant/goods/good/add', '', 10, 'merchant', 0, 1, '', 'M', 'merchantapi/goods/good/add', 0, 1),
(13, 'merchantGoodsEdit', 'edit', '编辑商品', 'merchant/goods/good/add', '', 10, 'merchant', 0, 1, '', 'M', 'merchantapi/goods/good/edit', 0, 1),
(14, 'merchantGoodsList', 'index', '商品列表', 'merchant/goods/good/index', '', 10, 'merchant', 0, 0, '', 'M', NULL, 0, 1),
(15, 'merchantGoodsTrash', 'trash', '商品回收站', 'merchant/goods/good/trash', '', 10, 'merchant', 0, 1, NULL, 'M', NULL, 0, 1),
(16, 'merchantGoodsCardList', 'card', '库存管理', 'merchant/goods/card/index', '', 10, 'merchant', 0, 0, '', 'M', 'merchantapi/goods/card', 0, 1),
(17, 'merchantGoodsCardTrash', 'card/trash', '库存回收站', 'merchant/goods/card/trash', '', 10, 'merchant', 0, 1, '', 'M', NULL, 0, 1),
(18, 'merchantGoodsCardAdd', 'card/add', '添加库存', 'merchant/goods/card/add', '', 10, 'merchant', 0, 1, '', 'M', NULL, 0, 1),
(19, 'merchantGoodsCoupon', 'coupon', '优惠券', 'merchant/goods/coupon/index', '', 10, 'merchant', 0, 0, '', 'M', NULL, 0, 1),
(20, 'merchantGoodsCouponAdd', 'coupon/add', '添加优惠券', 'merchant/goods/coupon/add', '', 10, 'merchant', 0, 1, '', 'M', 'merchantapi/goods/coupon/add', 0, 1),
(21, 'merchantGoodsCouponTrash', 'coupon/trash', '优惠券回收站', 'merchant/goods/coupon/trash', '', 10, 'merchant', 0, 1, '', 'M', NULL, 0, 1),
(23, 'merchantOrderComplaintIndex', 'complaint', '投诉管理', 'merchant/order/complaint/index', '', 24, 'merchant', 100, 0, '', 'M', 'merchantapi/order/complaint/list', 0, 1),
(24, 'merchantOrder', 'order', '交易数据', 'Layout', 'keyboard', 0, 'merchant', 3, 0, '/merchant/order/list', 'L', '', 0, 1),
(25, 'merchantOrderOrderList', 'list', '订单管理', 'merchant/order/order/list', '', 24, 'merchant', 0, 0, '', 'M', 'merchantapi/order/order/list', 0, 1),
(26, 'merchantOrderOrderCard', 'card', '查看卡密', 'merchant/order/order/card', '', 24, 'merchant', 0, 1, '', 'M', 'merchantapi/order/order/card', 0, 1),
(27, 'merchantCharts', 'charts', '数据统计', 'Layout', 'chart', 0, 'merchant', 8, 0, '/merchant/charts/ranklist', 'L', '', 0, 1),
(28, 'merchantChartsRanklist', 'ranklist', '累计消费', 'merchant/charts/ranklist', '', 27, 'merchant', 0, 0, NULL, 'M', NULL, 0, 1),
(29, 'merchantFinance', 'finance', '财务管理', 'Layout', 'wallet', 0, 'merchant', 12, 0, '/merchant/finance/collect', 'L', '', 0, 1),
(30, 'merchantFinanceCollect', 'collect', '收款设置', 'merchant/finance/collect', '', 29, 'merchant', 1, 0, '', 'M', NULL, 0, 1),
(31, 'merchantFinanceMoney', 'money', '收益统计', 'merchant/charts/money', '', 27, 'merchant', 10, 0, '', 'M', 'merchantapi/charts/money', 0, 1),
(32, 'merchantFinanceTranslist', 'translist', '资金明细', 'merchant/finance/translist', '', 29, 'merchant', 8, 0, '', 'M', NULL, 0, 1),
(33, 'merchantFinanceCashApply', 'cash/apply', '提现申请', 'merchant/finance/cash/apply', '', 29, 'merchant', 3, 0, '', 'M', NULL, 0, 1),
(34, 'adminPermission', 'permission', '权限管理', 'Layout', 'setting-1', 0, 'admin', 3, 0, '/admin/permission/menu', 'L', '', 0, 1),
(37, 'adminOrder', 'order', '交易管理', 'Layout', 'cart', 0, 'admin', 5, 0, '/admin/order/list', 'L', '', 0, 1),
(38, 'AdminOrderList', 'list', '订单列表', '/admin/order/list/index', '', 37, 'admin', 0, 0, '', 'M', 'adminapi/order/order/list', 0, 1),
(39, 'adminWorkbench', 'workbench', '工作台', 'admin/workbench/index', 'desktop', 0, 'admin', 1, 0, '', 'M', 'workbench', 0, 1),
(40, 'adminPermissionAdmin', 'admin', '管理员', 'admin/permission/admin/index', '', 34, 'admin', 0, 0, '', 'M', 'adminapi/permission/adminapi/list', 0, 1),
(41, 'adminSetting', 'setting', '系统设置', 'layout', 'setting', 0, 'admin', 2, 0, '/admin/setting/website', 'L', '', 0, 1),
(43, 'adminSettingWebsite', 'website', '站点配置', 'admin/setting/website/index', '', 41, 'admin', 0, 0, '', 'M', 'adminapi/config/config/getConfig', 0, 1),
(44, 'adminSettingRegister', 'register', '注册设置', 'admin/setting/register/index', '', 41, 'admin', 0, 0, '', 'M', 'adminapi/config/config/getConfig', 0, 1),
(46, 'adminChannel', 'channel', '通道管理', 'layout', 'money', 0, 'admin', 8, 0, '/admin/channel/pay_type', 'L', '', 0, 1),
(47, 'adminChannelCollection', 'collection', '收款通道', 'admin/channel/collection/index', '', 46, 'admin', 20, 0, '', 'M', 'adminapi/channel/collection/list', 0, 1),
(48, 'adminChannelPay_type', 'pay_type', '支付方式分类', 'admin/channel/pay_type/index', '', 46, 'admin', 0, 0, '', 'M', 'adminapi/channel/payType/list', 0, 1),
(49, 'adminMerchant', 'merchant', '商户管理', 'layout', 'user-1', 0, 'admin', 49, 0, '/admin/merchant/user', 'L', '', 0, 1),
(50, 'adminMerchantUser', 'user', '用户管理', 'admin/merchant/user/index', '', 49, 'admin', 50, 0, '', 'M', 'adminapi/merchant/user/list', 0, 1),
(54, 'adminShop', 'shop', '商城管理', 'Layout', 'layers', 0, 'admin', 54, 0, '/admin/shop/goods', 'L', '', 0, 1),
(62, 'adminShopGoods', 'goods', '商品管理', 'admin/goods/goods/index', '', 54, 'admin', 62, 0, '', 'M', 'adminapi/goods/goods/list', 0, 1),
(63, 'adminOrderConfig', 'config', '订单配置', 'admin/order/config/index', '', 37, 'admin', 63, 0, '', 'M', 'adminapi/order/order/list', 0, 1),
(66, 'adminMerchantMoney_log', 'money_log', '资金日志', 'admin/merchant/money-log/index', '', 49, 'admin', 66, 0, '', 'M', 'adminapi/merchant/moneylog/list', 0, 1),
(67, 'adminChannelSettlement', 'settlement', '结算通道', 'admin/channel/settlement/index', '', 46, 'admin', 67, 0, '', 'M', 'adminapi/channel/collection/list', 0, 1),
(69, 'adminChannelCollectionAccount', 'collection/account', '账号管理', 'admin/channel/collection/account/index', '', 46, 'admin', 69, 1, '', 'M', 'adminapi/channel/collection/list', 0, 1),
(70, 'adminChannelSettlement/account', 'settlement/account', '结算账号', 'admin/channel/settlement/account/index', '', 46, 'admin', 70, 1, '', 'M', 'adminapi/channel/collection/list', 0, 1),
(71, 'adminChannelConfig', 'config', '结算配置', 'admin/channel/settlement/config/index', '', 46, 'admin', 71, 0, '', 'M', 'adminapi/config/config/getConfig', 0, 1),
(72, 'adminOrderMerchant', 'merchant', '商户分析', 'admin/order/analysis/merchant/index', '', 37, 'admin', 72, 0, '', 'M', 'adminapi/order/analysis/merchant', 0, 1),
(73, 'adminOrderChannel', 'channel', '渠道分析', 'admin/order/analysis/channel/index', '', 37, 'admin', 73, 0, '', 'M', 'adminapi/order/analysis/channel', 0, 1),
(76, 'adminMerchantLoginlog', 'loginlog', '登录日志', 'admin/merchant/loginlog/index', '', 49, 'admin', 76, 0, '', 'M', 'adminapi/merchant/user/loginlog', 0, 1),
(88, 'adminMerchantRole', 'role', '商户角色', 'admin/merchant/role/index', '', 49, 'admin', 88, 0, '', 'M', 'adminapi/merchant/role/list', 0, 1),
(89, 'adminMerchantCash', 'cash', '提现管理', 'admin/merchant/cash/index', '', 49, 'admin', 89, 0, '', 'M', 'adminapi/merchant/cash/list', 0, 1),
(97, 'adminPermissionMenu', 'menu', '菜单管理', 'admin/permission/menu/index', '', 34, 'admin', 97, 0, '', 'M', 'adminapi/permission/log/list', 0, 1),
(98, 'adminPermissionLog', 'log', '操作日志', 'admin/permission/log/index', '', 34, 'admin', 98, 0, '', 'M', 'adminapi/permission/log/list', 0, 1),
(135, 'adminOrderComplaint', 'complaint', '投诉管理', 'admin/order/complaint/index', '', 37, 'admin', 135, 0, '', 'M', 'adminapi/order/complaint/list', 0, 1),
(136, 'adminOrderComplaint/detail', 'complaint/detail', '投诉详情', 'admin/order/complaint/detail', '', 37, 'admin', 136, 1, '', 'M', 'adminapi/order/complaint/detail', 0, 1),
(137, 'merchantComplaintDetail', 'complaint/detail', '投诉详情', 'merchant/order/complaint/detail', '', 24, 'merchant', 137, 1, '', 'M', 'merchantapi/order/complaint/detail', 0, 1),
(141, 'adminArticle', 'article', '文章管理', 'LAYOUT', 'component-dropdown', 0, 'admin', 141, 0, '/admin/article/category', 'L', '', 0, 1),
(142, 'adminArticleIndex', 'index', '文章管理', 'admin/article/article/index', '', 141, 'admin', 142, 0, '', 'M', 'adminapi/article/article/list', 0, 1),
(145, 'adminArticleCategory', 'category', '文章分类', 'admin/article/category/index', '', 141, 'admin', 145, 0, '', 'M', 'adminapi/article/articleCategory/list', 0, 1),
(150, 'adminMerchantShop', 'shop', '店铺管理', 'admin/merchant/shop/index', '', 49, 'admin', 150, 0, '', 'M', 'adminapi/merchant/shop/list', 0, 1),
(151, 'merchantShop', 'shop', '店铺管理', 'Layout', 'address-book', 0, 'merchant', 151, 0, '/merchant/shop/link', 'L', '', 0, 1),
(152, 'merchantShopConfig', 'config', '店铺设置', 'merchant/shop/config/index', '', 151, 'merchant', 152, 0, '', 'M', '11', 0, 1),
(158, 'merchantGoodsCategory', '', '商品分类添加', '', '', 11, 'merchant', 158, 0, '', 'B', 'merchantapi/goods/category/add', 0, 1),
(163, 'merchantUserNews', 'news', '公告列表', 'merchant/user/news/list', '', 1, 'merchant', 163, 0, '', 'M', 'merchantapi/user/news/list', 0, 1),
(164, 'merchantUserNews_detail/:id', 'news/detail/:id', '文章详情', 'merchant/user/news/detail', '', 1, 'merchant', 164, 1, '', 'M', 'merchantapi/user/news/detail', 0, 1),
(165, 'merchantUserNotice', '', '标记全部已读', '', '', 8, 'merchant', 165, 0, '', 'B', 'merchantapi/user/message/readAll', 0, 1),
(166, 'merchantUserNotice', '', '标记已读', '', '', 8, 'merchant', 166, 0, '', 'B', 'merchantapi/user/message/read', 0, 1),
(167, 'merchantUserNotice', '', '删除', '', '', 8, 'merchant', 167, 0, '', 'B', 'merchantapi/user/message/del', 0, 1),
(168, 'adminSettingNotification', 'notification', '消息通知', 'BLANK', '', 41, 'admin', 168, 0, '', 'L', '', 0, 1),
(169, 'merchantGoodsCategory', '', '商品分类链接', '', '', 11, 'merchant', 169, 0, '', 'B', 'merchantapi/goods/category', 0, 1),
(170, 'merchantGoodsCategory', '', '商品分类编辑', '', '', 11, 'merchant', 170, 0, '', 'B', 'merchantapi/goods/category/edit', 0, 1),
(171, 'merchantGoodsCategory', '', '商品分类删除', '', '', 11, 'merchant', 171, 0, '', 'B', 'merchantapi/goods/category/del', 0, 1),
(177, 'adminSettingNotificationList', 'list', '通知设置', 'admin/setting/notification/index', '', 168, 'admin', 177, 0, '', 'M', 'adminapi/system/notification/index', 0, 1),
(178, 'adminSettingNotificationSms', 'sms', '短信配置', 'admin/setting/notification/sms', '', 168, 'admin', 178, 0, '', 'M', 'adminapi/system/notification/smsType', 0, 1),
(179, 'adminSettingNotificationEmail', 'email', '邮箱配置', 'admin/setting/notification/email', '', 168, 'admin', 179, 0, '', 'M', 'adminapi/config/config/editConfig', 0, 1),
(180, 'adminSettingSystem', 'system', '系统维护', 'BLANK', '', 41, 'admin', 180, 0, '', 'L', '', 0, 1),
(181, 'adminSettingSystemEnvironment', 'environment', '系统环境', 'admin/setting/system/environment', '', 180, 'admin', 181, 0, '', 'M', 'adminapi/setting/system/environment', 0, 1),
(182, 'adminSettingSystemCache', 'cache', '系统缓存', 'admin/setting/system/cache', '', 180, 'admin', 182, 0, '', 'M', 'adminapi/system/system/cache', 0, 1),
(184, 'merchantUserPayment', 'payment', '付款方式', 'merchant/user/payment/index', '', 1, 'merchant', 184, 0, '', 'M', 'merchantapi/user/payment/list', 0, 1),
(186, 'adminMerchantMenu', 'menu', '菜单管理', 'admin/merchant/menu/index', '', 49, 'admin', 186, 0, '', 'M', 'adminapi/merchant/menu/list', 0, 1);
/*!40000 ALTER TABLE `system_menu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `system_notification`
--

DROP TABLE IF EXISTS `system_notification`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `system_notification` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `mark` varchar(50) NOT NULL DEFAULT '' COMMENT '标识',
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '通知类型',
  `title` varchar(100) NOT NULL DEFAULT '' COMMENT '通知场景说明',
  `is_sms` tinyint(1) NOT NULL DEFAULT 0 COMMENT '发送短信（0：不存在，1：开启，2：关闭）',
  `sms_config` varchar(512) NOT NULL DEFAULT '' COMMENT '短信配置',
  `system` tinyint(1) NOT NULL DEFAULT 0 COMMENT '系统调用',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci COMMENT='通知设置';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `system_notification`
--

LOCK TABLES `system_notification` WRITE;
/*!40000 ALTER TABLE `system_notification` DISABLE KEYS */;
INSERT INTO `system_notification` VALUES
(1,'register','注册短信验证码','短信验证码',1,'{\"id\":1,\"status\":1,\"sms_gateway\":\"aliyun\",\"sms_template_content\":\"\\u60a8\\u6b63\\u5728\\u6ce8\\u518c\\uff0c\\u9a8c\\u8bc1\\u7801${code}\\uff0c\\u5207\\u52ff\\u5c06\\u9a8c\\u8bc1\\u7801\\u6cc4\\u9732\\u4e8e\\u4ed6\\u4eba\\uff0c\\u672c\\u6761\\u9a8c\\u8bc1\\u7801\\u6709\\u6548\\u671f5\\u5206\\u949f\\u3002\",\"sms_template_id\":\"SMS_123456\"}',1),
(3,'complaint_to_buyer','投诉短信【买家】','买家投诉短信密码',1,'{\"id\":3,\"status\":1,\"sms_template_content\":\"\\u60a8\\u7684\\u8ba2\\u5355{$trade_no}\\u5df2\\u6295\\u8bc9\\u6210\\u529f\\u3002\\u6295\\u8bc9\\u5bc6\\u7801\\u4e3a{$pwd}\\uff0c\\u5728\\u5356\\u5bb6\\u672a\\u7ed9\\u60a8\\u5904\\u7406\\u597d\\u95ee\\u9898\\u524d\\uff0c\\u8bf7\\u52ff\\u5c06\\u5bc6\\u7801\\u544a\\u77e5\\u4efb\\u4f55\\u4eba\\uff01\",\"sms_gateway\":\"aliyun\"}',1),
(4,'complaint_to_merchant','通知有投诉【卖家】','通知卖家有投诉的订单',1,'{\"id\":4,\"status\":1,\"sms_template_content\":\"\\u60a8\\u7684\\u8ba2\\u5355\\uff1a{$trade_no}\\uff0c\\u5df2\\u7ecf\\u6709\\u4e70\\u5bb6\\u6295\\u8bc9\\uff0c\\u8bf7\\u60a8\\u53ca\\u65f6\\u767b\\u5f55\\u540e\\u53f0\\u5904\\u7406\\u3002\",\"sms_gateway\":\"aliyun\"}',1),
(5,'order_to_buyer','订单通知【买家】','付款后发送后买家购买信息的短信',1,'{\"id\":5,\"status\":0,\"sms_template_content\":\"\\u60a8\\u7684\\u8ba2\\u5355\\u5df2\\u652f\\u4ed8\\u6210\\u529f\\uff0c\\u8ba2\\u5355\\u53f7\\uff1a{$trade_no}\\uff0c\\u82e5\\u60a8\\u4ed8\\u6b3e\\u6210\\u529f\\u540e\\u6ca1\\u6709\\u9886\\u53d6\\u865a\\u62df\\u5361\\u4fe1\\u606f\\uff0c\\u8bf7\\u60a8\\u53ca\\u65f6\\u901a\\u8fc7\\u8ba2\\u5355\\u67e5\\u8be2\\u63d0\\u53d6\\u3002\",\"sms_gateway\":\"aliyun\"}',1);
/*!40000 ALTER TABLE `system_notification` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `system_uploads`
--

DROP TABLE IF EXISTS `system_uploads`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `system_uploads` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `name` varchar(128) NOT NULL COMMENT '名称',
  `url` varchar(255) NOT NULL COMMENT '文件',
  `admin_id` int(11) DEFAULT NULL COMMENT '管理员',
  `file_size` int(11) NOT NULL COMMENT '文件大小',
  `mime_type` varchar(255) NOT NULL COMMENT 'mime类型',
  `image_width` int(11) DEFAULT NULL COMMENT '图片宽度',
  `image_height` int(11) DEFAULT NULL COMMENT '图片高度',
  `ext` varchar(128) NOT NULL COMMENT '扩展名',
  `storage` varchar(255) NOT NULL DEFAULT 'local' COMMENT '存储位置',
  `created_at` date DEFAULT NULL COMMENT '上传时间',
  `category` varchar(128) DEFAULT NULL COMMENT '类别',
  `updated_at` date DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `category` (`category`),
  KEY `admin_id` (`admin_id`),
  KEY `name` (`name`),
  KEY `ext` (`ext`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='附件';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `system_uploads`
--

LOCK TABLES `system_uploads` WRITE;
/*!40000 ALTER TABLE `system_uploads` DISABLE KEYS */;
/*!40000 ALTER TABLE `system_uploads` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) unsigned NOT NULL DEFAULT 0 COMMENT '上级ID',
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `mobile` varchar(15) DEFAULT '' COMMENT '手机号',
  `email` varchar(50) NOT NULL DEFAULT '',
  `money` decimal(10,3) NOT NULL DEFAULT 0.000,
  `freeze_money` decimal(10,3) NOT NULL DEFAULT 0.000,
  `status` tinyint(3) unsigned NOT NULL DEFAULT 1 COMMENT '0未审核 1已审核',
  `is_freeze` tinyint(3) unsigned NOT NULL DEFAULT 0 COMMENT '是否冻结 0否 1是',
  `create_at` int(10) unsigned NOT NULL,
  `ip` varchar(50) DEFAULT '' COMMENT 'IP地址',
  `shop_notice_auto_pop` tinyint(4) NOT NULL DEFAULT 1 COMMENT '商家公告是否自动弹出',
  `cash_type` tinyint(4) NOT NULL DEFAULT 1 COMMENT '提现方式 1自动 2手动',
  `shop_gouka_protocol_pop` tinyint(4) NOT NULL DEFAULT 0 COMMENT '购卡协议是否自动弹出',
  `user_notice_auto_pop` tinyint(4) NOT NULL DEFAULT 1 COMMENT '商家是否自动弹出',
  `fee_payer` tinyint(4) NOT NULL DEFAULT 0 COMMENT '订单手续费支付方，0：跟随系统，1：商家承担，2买家承担',
  `settlement_type` tinyint(4) NOT NULL DEFAULT 1 COMMENT '结算周期，1:T1结算，0:T0结算；只允许后台更改',
  `rate_type` tinyint(1) DEFAULT 0 COMMENT '0使用角色费率 1自定义通道费率',
  `fee_money` decimal(10,3) DEFAULT 0.000 COMMENT '预存金额',
  `avatar` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`) USING BTREE,
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_analysis`
--

DROP TABLE IF EXISTS `user_analysis`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_analysis` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `date` date NOT NULL,
  `day_amount` decimal(10,3) NOT NULL DEFAULT 0.000 COMMENT '交易额',
  `order_count` int(11) NOT NULL DEFAULT 0,
  `finally_amount` decimal(10,3) NOT NULL DEFAULT 0.000 COMMENT '结算额',
  `profit` decimal(10,3) NOT NULL DEFAULT 0.000 COMMENT '利润',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_analysis`
--

LOCK TABLES `user_analysis` WRITE;
/*!40000 ALTER TABLE `user_analysis` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_analysis` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_cash`
--

DROP TABLE IF EXISTS `user_cash`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_cash` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `type` tinyint(3) unsigned NOT NULL COMMENT '收款产品类型 1支付宝 2微信',
  `collect_info` varchar(1024) NOT NULL DEFAULT '' COMMENT '提现信息',
  `money` decimal(10,2) unsigned NOT NULL COMMENT '提现金额',
  `fee` decimal(10,2) unsigned NOT NULL DEFAULT 0.00 COMMENT '手续费',
  `actual_money` decimal(10,2) unsigned NOT NULL DEFAULT 0.00 COMMENT '实际到账',
  `status` tinyint(3) unsigned NOT NULL DEFAULT 0 COMMENT '状态 0审核中 1审核通过 2审核未通过',
  `create_at` int(10) unsigned NOT NULL COMMENT '创建时间',
  `complete_at` int(10) unsigned NOT NULL DEFAULT 0 COMMENT '完成时间',
  `collect_img` tinytext DEFAULT NULL COMMENT '收款二维码',
  `auto_cash` tinyint(4) NOT NULL DEFAULT 0 COMMENT '1 表示自动提现',
  `bank_name` varchar(50) NOT NULL DEFAULT '' COMMENT '银行名称',
  `bank_branch` varchar(150) NOT NULL DEFAULT '' COMMENT '开户地址',
  `bank_card` varchar(50) NOT NULL DEFAULT '' COMMENT '银行卡号',
  `realname` varchar(50) NOT NULL DEFAULT '' COMMENT '真实姓名',
  `idcard_number` varchar(50) NOT NULL DEFAULT '' COMMENT '身份证号码',
  `trade_no` varchar(50) NOT NULL DEFAULT '' COMMENT '订单号',
  `channel_account_id` int(11) NOT NULL DEFAULT 0 COMMENT '代付账号',
  `channel_id` int(10) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_cash`
--

LOCK TABLES `user_cash` WRITE;
/*!40000 ALTER TABLE `user_cash` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_cash` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_channel`
--

DROP TABLE IF EXISTS `user_channel`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_channel` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `channel_id` int(10) unsigned NOT NULL,
  `status` tinyint(3) unsigned NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id` (`user_id`,`channel_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_channel`
--

LOCK TABLES `user_channel` WRITE;
/*!40000 ALTER TABLE `user_channel` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_channel` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_collect`
--

DROP TABLE IF EXISTS `user_collect`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_collect` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `type` tinyint(3) unsigned NOT NULL DEFAULT 1 COMMENT '类型 1支付宝 2微信 3银行卡',
  `info` text NOT NULL,
  `create_at` int(10) unsigned NOT NULL DEFAULT 0,
  `collect_img` tinytext DEFAULT NULL,
  `allow_update` tinyint(4) NOT NULL DEFAULT 0 COMMENT '1为允许用户修改收款信息',
  `status` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_collect`
--

LOCK TABLES `user_collect` WRITE;
/*!40000 ALTER TABLE `user_collect` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_collect` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_log`
--

DROP TABLE IF EXISTS `user_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_log` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `ip` char(15) NOT NULL DEFAULT '' COMMENT '操作者IP地址',
  `params` varchar(255) NOT NULL DEFAULT '' COMMENT '参数',
  `user_id` int(11) NOT NULL DEFAULT 0 COMMENT '操作人用户ID',
  `username` varchar(32) NOT NULL DEFAULT '' COMMENT '用户名',
  `action` varchar(200) NOT NULL DEFAULT '' COMMENT '操作行为',
  `content` text NOT NULL COMMENT '操作内容描述',
  `create_at` timestamp NOT NULL DEFAULT current_timestamp() COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci COMMENT='系统操作日志表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_log`
--

LOCK TABLES `user_log` WRITE;
/*!40000 ALTER TABLE `user_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_login_error_log`
--

DROP TABLE IF EXISTS `user_login_error_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_login_error_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login_name` varchar(50) NOT NULL DEFAULT '' COMMENT '登录名',
  `password` varchar(255) NOT NULL DEFAULT '' COMMENT '尝试密码',
  `user_type` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0：普通用户 1：后台管理员账号',
  `login_from` int(1) NOT NULL DEFAULT 0 COMMENT '登录来源：0：前台 1：总后台',
  `login_time` int(11) NOT NULL DEFAULT 0 COMMENT '登录时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_login_error_log`
--

LOCK TABLES `user_login_error_log` WRITE;
/*!40000 ALTER TABLE `user_login_error_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_login_error_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_login_log`
--

DROP TABLE IF EXISTS `user_login_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_login_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `ip` varchar(15) NOT NULL DEFAULT '',
  `create_at` int(10) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_login_log`
--

LOCK TABLES `user_login_log` WRITE;
/*!40000 ALTER TABLE `user_login_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_login_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_message`
--

DROP TABLE IF EXISTS `user_message`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_message` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `from_id` int(10) unsigned NOT NULL DEFAULT 0 COMMENT '0为管理员',
  `to_id` int(10) unsigned NOT NULL DEFAULT 0,
  `title` varchar(60) NOT NULL DEFAULT '',
  `content` varchar(1024) NOT NULL DEFAULT '',
  `status` tinyint(3) NOT NULL DEFAULT 0 COMMENT '0未读  1已读',
  `create_at` int(10) unsigned NOT NULL DEFAULT 0 COMMENT '发送时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_message`
--

LOCK TABLES `user_message` WRITE;
/*!40000 ALTER TABLE `user_message` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_message` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_money_log`
--

DROP TABLE IF EXISTS `user_money_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_money_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `business_type` varchar(100) NOT NULL,
  `user_id` int(10) unsigned NOT NULL COMMENT '用户ID',
  `from_user_id` int(10) unsigned NOT NULL DEFAULT 0 COMMENT '来源用户ID',
  `agent_type` tinyint(1) NOT NULL DEFAULT 0 COMMENT '代理模式 1：普通代理 2：全站代理',
  `trade_no` varchar(255) NOT NULL DEFAULT '' COMMENT '相关订单号',
  `money` decimal(10,3) NOT NULL COMMENT '变动金额',
  `balance` decimal(10,3) NOT NULL COMMENT '剩余',
  `reason` varchar(255) NOT NULL DEFAULT '' COMMENT '变动原因',
  `create_at` int(10) unsigned NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`),
  KEY `business_type` (`business_type`) USING BTREE,
  KEY `user_id` (`user_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_money_log`
--

LOCK TABLES `user_money_log` WRITE;
/*!40000 ALTER TABLE `user_money_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_money_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_rate`
--

DROP TABLE IF EXISTS `user_rate`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_rate` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL COMMENT '用户ID',
  `channel_id` int(10) unsigned NOT NULL COMMENT '渠道ID',
  `rate` decimal(10,4) unsigned NOT NULL COMMENT '费率',
  `status` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id` (`user_id`,`channel_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_rate`
--

LOCK TABLES `user_rate` WRITE;
/*!40000 ALTER TABLE `user_rate` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_rate` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_role`
--

DROP TABLE IF EXISTS `user_role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_role` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `role_pc` varchar(255) DEFAULT NULL,
  `role_wap` varchar(255) DEFAULT NULL,
  `name` varchar(20) NOT NULL,
  `remark` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_role`
--

LOCK TABLES `user_role` WRITE;
/*!40000 ALTER TABLE `user_role` DISABLE KEYS */;
INSERT INTO `user_role` VALUES
(1,'1,4,6,7,8,165,166,167,163,164,184,2,10,11,158,169,170,171,12,13,14,15,16,17,18,19,20,21,24,23,25,140,26,137,27,28,31,29,5,30,32,33,185,151,3,152,153,154,155,156,157,159,161,176','1,10,24,27,29,151,3','默认分组',''),
(2,'','','2',''),
(3,'','','11',''),
(4,'','','1111','');
/*!40000 ALTER TABLE `user_role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_role_rate`
--

DROP TABLE IF EXISTS `user_role_rate`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_role_rate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) NOT NULL,
  `channel_id` int(11) NOT NULL,
  `rate` decimal(10,4) NOT NULL,
  `status` tinyint(1) DEFAULT 1,
  PRIMARY KEY (`id`),
  KEY `role_id` (`role_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_role_rate`
--

LOCK TABLES `user_role_rate` WRITE;
/*!40000 ALTER TABLE `user_role_rate` DISABLE KEYS */;
INSERT INTO `user_role_rate` VALUES
(1,1,1,0.0300,0),
(2,2,1,0.0600,1);
/*!40000 ALTER TABLE `user_role_rate` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_role_relation`
--

DROP TABLE IF EXISTS `user_role_relation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_role_relation` (
  `user_id` int(10) NOT NULL,
  `role_id` int(10) NOT NULL,
  UNIQUE KEY `user_id` (`user_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='会员关联role';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_role_relation`
--

LOCK TABLES `user_role_relation` WRITE;
/*!40000 ALTER TABLE `user_role_relation` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_role_relation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'f2_qqss_net'
--

--
-- Dumping routines for database 'f2_qqss_net'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-09-09  3:41:41
