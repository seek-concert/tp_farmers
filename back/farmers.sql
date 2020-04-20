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

 Date: 20/04/2020 15:31:32
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

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
) ENGINE = InnoDB AUTO_INCREMENT = 19 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of pq_node
-- ----------------------------
INSERT INTO `pq_node` VALUES (1, '后台权限管理', '#', '#', 2, 0, 'fa fa-users', 99);
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
INSERT INTO `pq_user` VALUES (1, 'admin', 'e10adc3949ba59abbe56e057f20f883e', 91, '127.0.0.1', 1587365708, 'admin', 1, 1, 1556950116);

SET FOREIGN_KEY_CHECKS = 1;
