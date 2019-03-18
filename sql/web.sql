/*
 Navicat Premium Data Transfer

 Source Server         : localhost_3306
 Source Server Type    : MySQL
 Source Server Version : 50723
 Source Host           : localhost:3306
 Source Schema         : web

 Target Server Type    : MySQL
 Target Server Version : 50723
 File Encoding         : 65001

 Date: 18/03/2019 13:06:05
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for admin
-- ----------------------------
DROP TABLE IF EXISTS `admin`;
CREATE TABLE `admin`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `password` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 4 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of admin
-- ----------------------------
INSERT INTO `admin` VALUES (1, 'admin', '21232f297a57a5a743894a0e4a801fc3');
INSERT INTO `admin` VALUES (2, 'user1', 'e10adc3949ba59abbe56e057f20f883e');
INSERT INTO `admin` VALUES (3, 'user2', 'e10adc3949ba59abbe56e057f20f883e');

-- ----------------------------
-- Table structure for eg
-- ----------------------------
DROP TABLE IF EXISTS `eg`;
CREATE TABLE `eg`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `class_id` int(11) NULL DEFAULT NULL,
  `user_id` int(255) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 5 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of eg
-- ----------------------------
INSERT INTO `eg` VALUES (2, '测试案例', 1, 1);
INSERT INTO `eg` VALUES (3, '测试案例2', 3, 1);
INSERT INTO `eg` VALUES (4, '测试案例3', 1, 1);

-- ----------------------------
-- Table structure for iclass
-- ----------------------------
DROP TABLE IF EXISTS `iclass`;
CREATE TABLE `iclass`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 11 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of iclass
-- ----------------------------
INSERT INTO `iclass` VALUES (1, '布局');
INSERT INTO `iclass` VALUES (2, '按钮');
INSERT INTO `iclass` VALUES (3, '表单');
INSERT INTO `iclass` VALUES (4, '导航');
INSERT INTO `iclass` VALUES (5, '选项卡');
INSERT INTO `iclass` VALUES (6, '进度条');
INSERT INTO `iclass` VALUES (7, '面板');
INSERT INTO `iclass` VALUES (8, '表格');
INSERT INTO `iclass` VALUES (9, '徽章');
INSERT INTO `iclass` VALUES (10, '辅助');

SET FOREIGN_KEY_CHECKS = 1;
