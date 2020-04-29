/*
 Navicat Premium Data Transfer

 Source Server         : 本地
 Source Server Type    : MySQL
 Source Server Version : 50554
 Source Host           : 127.0.0.1:3306
 Source Schema         : farmers

 Target Server Type    : MySQL
 Target Server Version : 50554
 File Encoding         : 65001

 Date: 29/04/2020 18:03:39
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for pq_level
-- ----------------------------
DROP TABLE IF EXISTS `pq_level`;
CREATE TABLE `pq_level`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type_id` int(11) NOT NULL COMMENT '父级节点id',
  `name` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '农户名称/产销售地名称',
  `level` tinyint(8) NOT NULL DEFAULT 1 COMMENT '层级',
  `yield` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '产量',
  `sales` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '销量',
  `is_menu` smallint(4) NOT NULL DEFAULT 1 COMMENT '是否农户【1-不是  2-是 】',
  `num` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '唯一编码',
  `linkurl` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '跳转地址',
  `imgurl` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '图片一地址',
  `imgurls` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '图片二地址',
  `sort` tinyint(4) NOT NULL DEFAULT 0 COMMENT '排序',
  `update_time` int(11) NULL DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 40 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of pq_level
-- ----------------------------
INSERT INTO `pq_level` VALUES (1, 0, '米脂县', 0, '500000', '50000', 1, NULL, NULL, NULL, NULL, 0, NULL);
INSERT INTO `pq_level` VALUES (2, 1, '铃木村', 1, '400000', '40000', 1, NULL, NULL, NULL, NULL, 0, NULL);
INSERT INTO `pq_level` VALUES (3, 2, '枫木乡', 2, '300000', '30000', 1, NULL, NULL, NULL, NULL, 0, NULL);
INSERT INTO `pq_level` VALUES (4, 3, '张三', 3, '200000', '20000', 1, '54654613213213', 'www.p7ing.com', '/upload/imgs/20200429/7c937430a9c7b5493200f3c3db1db081.png', '/upload/imgs/20200429/eaabeb37a9c39bfa1263db3509fb5d54.jpg', 0, NULL);
INSERT INTO `pq_level` VALUES (5, 0, '丰都县', 0, '50000', '5000', 1, NULL, NULL, NULL, NULL, 0, NULL);
INSERT INTO `pq_level` VALUES (6, 5, 'XX村', 1, '40000', '4000', 1, NULL, NULL, NULL, NULL, 0, NULL);
INSERT INTO `pq_level` VALUES (7, 5, 'D村', 1, '40000', '4000', 1, NULL, NULL, NULL, NULL, 0, NULL);
INSERT INTO `pq_level` VALUES (8, 7, '111', 2, '30000', '3000', 1, NULL, NULL, NULL, NULL, 0, NULL);
INSERT INTO `pq_level` VALUES (10, 8, '教育', 3, '2000', '2000', 1, '54654613213213', 'p7ing.com', '/upload/imgs/20200429/a8d44946642180af24f9fc56e9d003a3.jpg', '/upload/imgs/20200429/abe49c5beb8cb29408ccb16ae4ff790a.png', 0, NULL);
INSERT INTO `pq_level` VALUES (11, 8, 'XXX', 3, '1000', '800', 1, '3123123', 'p7ing.com', '/upload/imgs/20200429/e90176ef73b21a9dece1cf94a5e3ef6d.jpg', '/upload/imgs/20200429/a5cd077c447f6488e27604ebbbf23798.png', 0, NULL);
INSERT INTO `pq_level` VALUES (33, 8, 'AAA', 3, '10000', '123', 2, '1', '/', './upload/excel/imgs/20200429/F26077.png', './upload/excel/imgs/20200429/G26672.jpg', 0, 1588154389);
INSERT INTO `pq_level` VALUES (34, 8, 'BBBB', 3, '7000', '454', 2, '2', '/', './upload/excel/imgs/20200429/F38469.jpg', '', 0, 1588154389);
INSERT INTO `pq_level` VALUES (35, 8, 'CCCCC', 3, '50000', '789', 2, '3', '/', '', '', 0, 1588154389);
INSERT INTO `pq_level` VALUES (36, 8, 'DDDD', 3, '1000', '456', 2, '4', '/', '', '', 0, 1588154389);
INSERT INTO `pq_level` VALUES (37, 8, 'EEE', 3, '3000', '987', 2, '5', '/', '', '', 0, 1588154389);
INSERT INTO `pq_level` VALUES (38, 8, 'XCX', 3, '77000', '654', 2, '6', '/', '', '', 0, 1588154389);
INSERT INTO `pq_level` VALUES (39, 8, 'XCZ', 3, '66000', '321', 2, '7', '/', '', '', 0, 1588154389);

-- ----------------------------
-- Table structure for pq_node
-- ----------------------------
DROP TABLE IF EXISTS `pq_node`;
CREATE TABLE `pq_node`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `node_name` varchar(155) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '节点名称',
  `control_name` varchar(155) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '控制器名',
  `action_name` varchar(155) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '方法名',
  `is_menu` tinyint(1) NOT NULL DEFAULT 1 COMMENT '是否是菜单项 1不是 2是',
  `type_id` int(11) NOT NULL COMMENT '父级节点id',
  `style` varchar(155) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '菜单样式',
  `sort` tinyint(4) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 25 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of pq_node
-- ----------------------------
INSERT INTO `pq_node` VALUES (1, '后台权限管理', '#', '#', 2, 0, 'fa fa-desktop', 99);
INSERT INTO `pq_node` VALUES (2, '管理员管理', 'user', 'index', 2, 1, '', 0);
INSERT INTO `pq_node` VALUES (3, '添加管理员', 'user', 'useradd', 1, 2, '', 0);
INSERT INTO `pq_node` VALUES (4, '编辑管理员', 'user', 'useredit', 1, 2, '', 0);
INSERT INTO `pq_node` VALUES (5, '删除管理员', 'user', 'userdel', 1, 2, '', 0);
INSERT INTO `pq_node` VALUES (6, '角色管理', 'role', 'index', 2, 1, '', 0);
INSERT INTO `pq_node` VALUES (7, '添加角色', 'role', 'roleadd', 1, 6, '', 0);
INSERT INTO `pq_node` VALUES (8, '编辑角色', 'role', 'roleedit', 1, 6, '', 0);
INSERT INTO `pq_node` VALUES (9, '删除角色', 'role', 'roledel', 1, 6, '', 0);
INSERT INTO `pq_node` VALUES (10, '分配权限', 'role', 'giveaccess', 1, 6, '', 0);
INSERT INTO `pq_node` VALUES (11, '系统管理', '#', '#', 2, 0, 'fa fa-desktop', 98);
INSERT INTO `pq_node` VALUES (12, '数据备份/还原', 'data', 'index', 2, 11, '', 0);
INSERT INTO `pq_node` VALUES (13, '备份数据', 'data', 'importdata', 1, 12, '', 0);
INSERT INTO `pq_node` VALUES (14, '还原数据', 'data', 'backdata', 1, 12, '', 0);
INSERT INTO `pq_node` VALUES (15, '节点管理', 'node', 'index', 2, 1, '', 0);
INSERT INTO `pq_node` VALUES (16, '添加节点', 'node', 'nodeadd', 1, 15, '', 0);
INSERT INTO `pq_node` VALUES (17, '编辑节点', 'node', 'nodeedit', 1, 15, '', 0);
INSERT INTO `pq_node` VALUES (18, '删除节点', 'node', 'nodedel', 1, 15, '', 0);
INSERT INTO `pq_node` VALUES (19, '产销管理', '#', '#', 2, 0, 'fa fa-desktop', 0);
INSERT INTO `pq_node` VALUES (20, '产销管理', 'level', 'index', 2, 19, '', 0);
INSERT INTO `pq_node` VALUES (21, '添加产销地', 'level', 'leveladd', 1, 20, '', 0);
INSERT INTO `pq_node` VALUES (22, '编辑产销地', 'level', 'leveledit', 1, 20, '', 0);
INSERT INTO `pq_node` VALUES (23, '删除产销地', 'level', 'leveldel', 1, 20, '', 0);
INSERT INTO `pq_node` VALUES (24, '导入Excel文件', 'level', 'exceldata', 1, 20, '', 0);

-- ----------------------------
-- Table structure for pq_role
-- ----------------------------
DROP TABLE IF EXISTS `pq_role`;
CREATE TABLE `pq_role`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `role_name` varchar(155) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '角色名称',
  `rule` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '权限节点数据',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of pq_role
-- ----------------------------
INSERT INTO `pq_role` VALUES (1, '超级管理员', '*');
INSERT INTO `pq_role` VALUES (2, '系统维护员', '1,2,3,4,5,6,7,8,9,10,15,16,17,18,19,20,22');

-- ----------------------------
-- Table structure for pq_sales
-- ----------------------------
DROP TABLE IF EXISTS `pq_sales`;
CREATE TABLE `pq_sales`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `l_id` int(11) NULL DEFAULT NULL COMMENT '农户ID',
  `buyer` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '买家名称',
  `sold_to` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '买家地址',
  `order_num` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '订单号',
  `sales_time` int(11) NULL DEFAULT NULL COMMENT '销售时间',
  `update_time` int(11) NULL DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '农户销售记录表' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of pq_sales
-- ----------------------------
INSERT INTO `pq_sales` VALUES (1, 11, 'AAA', '重庆市XX县', '20200404', 1587398400, 1588153079);
INSERT INTO `pq_sales` VALUES (2, 11, 'BBB', '重庆市XX县', '20200405', 1587398400, 1588153079);
INSERT INTO `pq_sales` VALUES (3, 11, 'CCC', '重庆市XX县', '20200406', 1587484800, 1588153079);
INSERT INTO `pq_sales` VALUES (4, 11, 'DDD', '重庆市XX县', '20200407', 1587571200, 1588153079);

-- ----------------------------
-- Table structure for pq_user
-- ----------------------------
DROP TABLE IF EXISTS `pq_user`;
CREATE TABLE `pq_user`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '用户名',
  `password` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '密码',
  `login_times` int(11) NOT NULL DEFAULT 0 COMMENT '登陆次数',
  `last_login_ip` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '最后登录IP',
  `last_login_time` int(11) NOT NULL DEFAULT 0 COMMENT '最后登录时间',
  `real_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '真实姓名',
  `status` int(1) NOT NULL DEFAULT 0 COMMENT '状态',
  `role_id` int(11) NOT NULL DEFAULT 1 COMMENT '用户角色id',
  `update_time` int(11) NULL DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Compact;

-- ----------------------------
-- Records of pq_user
-- ----------------------------
INSERT INTO `pq_user` VALUES (1, 'admin', 'e10adc3949ba59abbe56e057f20f883e', 109, '127.0.0.1', 1588145483, 'admin', 1, 1, 1556950116);

SET FOREIGN_KEY_CHECKS = 1;
