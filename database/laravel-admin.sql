/*
 Navicat Premium Data Transfer

 Source Server         : 本地
 Source Server Type    : MySQL
 Source Server Version : 80012
 Source Host           : localhost:3306
 Source Schema         : padmin

 Target Server Type    : MySQL
 Target Server Version : 80012
 File Encoding         : 65001

 Date: 17/08/2023 19:04:57
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for administrators
-- ----------------------------
DROP TABLE IF EXISTS `administrators`;
CREATE TABLE `administrators`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `account` char(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `real_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `phone` char(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '状态 1:正常 2:禁用',
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  `deleted_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `administrators_account_unique`(`account`) USING BTREE,
  UNIQUE INDEX `administrators_phone_unique`(`phone`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 28 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of administrators
-- ----------------------------
INSERT INTO `administrators` VALUES (1, 'admin', '默认管理员', '13111111111', '$2y$10$4bVNH1nYAMp5JYku2qOjx.nuvpSg7rXqelaDdE5MJcY4vR7ZSvnKu', 1, '2021-09-12 16:10:03', '2023-08-16 13:42:18', NULL);
INSERT INTO `administrators` VALUES (2, 'admin1', '测试', '13311111111', '$2y$10$hsip2uQm5hDaAeeiQJ7wneOvK85JdwI3djoDmzj.YedXVxjLlTMPW', 1, '2022-07-22 10:48:00', '2022-11-17 16:16:15', NULL);
INSERT INTO `administrators` VALUES (3, 'cpzyxx', '产品专员小徐', '15824136350', '$2y$10$DXFkiVB9.QOKY9uHVXfO4.CmaB6desV24iwZV9/ZBI5sQRcUbcfr2', 1, '2022-07-26 14:34:48', '2022-07-26 14:34:48', NULL);
INSERT INTO `administrators` VALUES (5, 'cpzgbbq', '产品主管芭比Q', '15824136351', '$2y$10$dnU9a1YGHJ/PfFb0H8vUdudlI8A7ADpn9UaqWSoBmEJbFr0IVlkce', 1, '2022-07-28 17:11:30', '2022-07-28 17:11:30', NULL);
INSERT INTO `administrators` VALUES (7, 'cpzyxxx', '产品专员小小徐', '15824136352', '$2y$10$IkGK/JL5F4/uvHHhzTAzF.ZKb0aQm/BDTmCwmxiFQmsPMaV4mKn6y', 1, '2022-08-01 12:07:26', '2022-08-01 12:07:26', NULL);
INSERT INTO `administrators` VALUES (8, 'cpzydh', '产品专员大黄', '15824136354', '$2y$10$oG8k6dvASTR9aaNn6SSDnuJR2nzWnH04M11QdrTIH7b/uRTBSaJDi', 2, '2022-08-01 12:11:22', '2022-08-17 14:38:29', NULL);
INSERT INTO `administrators` VALUES (10, 'xpmgxx', '选品美工消息', '15824136353', '$2y$10$OXJ4rqr0nOhLQRS1HpMrAe98xGzZjlb0qXyQhi25Pfayd3qjlnCM2', 1, '2022-08-08 10:51:34', '2022-08-08 10:51:34', NULL);
INSERT INTO `administrators` VALUES (12, 'xpzbxx', '选品主播小徐', '15824136355', '$2y$10$JeDB.o3.RmsF0fcKlQyrZOoGbxwhK5.2onpJWF2ZEDFoC5xVmZSNm', 1, '2022-08-08 10:52:07', '2022-08-08 10:52:07', NULL);
INSERT INTO `administrators` VALUES (13, 'xpzbdh', '选品主播大黄', '15824136356', '$2y$10$/F2TGjpUy1rEdYWN4ZgJEujMBNtLJl27lxFlJH0xtrhHLPknMPjMm', 1, '2022-08-08 10:52:32', '2022-08-08 10:52:32', NULL);
INSERT INTO `administrators` VALUES (14, 'xpwaxx', '选品文案小徐', '15824136357', '$2y$10$7ZKY2ol9BR97KQkaS3rGouEZI9F2LurJ1gn622Q881R.l1Rjx1sTu', 1, '2022-08-08 15:05:07', '2022-08-08 15:05:07', NULL);
INSERT INTO `administrators` VALUES (15, 'xpsyxx', '选品摄影小徐', '15824136358', '$2y$10$j85DoE8xpam7SK45k41qR.e/CgiAz.PADsdfdWbyXX.zR1XLe5I5q', 1, '2022-08-08 15:05:47', '2022-08-08 15:05:47', NULL);
INSERT INTO `administrators` VALUES (16, 'test3', '开发测试3', '13000000003', '$2y$10$GXEVV8mgBzNdBSDdKqW8WewRTJLinbBuYMJxJ24OF2fzn435qUIxq', 1, '2022-11-17 11:13:28', '2022-11-17 11:13:28', NULL);
INSERT INTO `administrators` VALUES (17, 'test4', '开发测试4', '13000000004', '$2y$10$FMATlBSu.jHXDHWCTF9FA.OTHN8QjkEOYEsUbsfSOa.W5DQzqAmaC', 1, '2022-11-17 11:14:34', '2022-11-17 11:14:34', NULL);
INSERT INTO `administrators` VALUES (20, 'test5', '开发测试5', '13000000005', '$2y$10$Icx0K8UH93hnO/xVobv3.O5pxWAl8beeMyjCwrkXqaDm1smasfPuS', 1, '2022-11-17 11:17:15', '2022-11-19 18:38:43', NULL);
INSERT INTO `administrators` VALUES (22, 'test6', '开发测试6', '13000000006', '$2y$10$Ul1RfSyabLssiD2qfGUzY.bVNERMCAxiohqhuuucULQYqcpcYeoma', 1, '2022-11-17 11:48:57', '2022-11-17 11:48:57', NULL);
INSERT INTO `administrators` VALUES (26, '测试', 'l', '13000000007', '$2y$10$1cT09D1AtDAX4JeJpaRmL.1KNeR05Tz5eQFDPYxTk5DuNarxExqWi', 1, '2022-11-17 15:49:08', '2022-11-17 15:49:08', NULL);
INSERT INTO `administrators` VALUES (27, 'test', '测试', '1324343', '$2y$10$Tv4XwypFOf2ukR1n5kxSJegdiyiU1ueNX5PdtP5S1GsqaWnttJBlG', 1, '2023-08-17 17:33:54', '2023-08-17 17:33:54', NULL);

-- ----------------------------
-- Table structure for model_has_permissions
-- ----------------------------
DROP TABLE IF EXISTS `model_has_permissions`;
CREATE TABLE `model_has_permissions`  (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` char(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL,
  PRIMARY KEY (`permission_id`, `model_id`, `model_type`) USING BTREE,
  INDEX `model_has_permissions_model_id_model_type_index`(`model_id`, `model_type`) USING BTREE,
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of model_has_permissions
-- ----------------------------

-- ----------------------------
-- Table structure for model_has_roles
-- ----------------------------
DROP TABLE IF EXISTS `model_has_roles`;
CREATE TABLE `model_has_roles`  (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` char(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL,
  PRIMARY KEY (`role_id`, `model_id`, `model_type`) USING BTREE,
  INDEX `model_has_roles_model_id_model_type_index`(`model_id`, `model_type`) USING BTREE,
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of model_has_roles
-- ----------------------------
INSERT INTO `model_has_roles` VALUES (1, 'App\\Models\\Administrator', 1);
INSERT INTO `model_has_roles` VALUES (2, 'App\\Models\\Administrator', 1);
INSERT INTO `model_has_roles` VALUES (3, 'App\\Models\\Administrator', 1);
INSERT INTO `model_has_roles` VALUES (4, 'App\\Models\\Administrator', 1);
INSERT INTO `model_has_roles` VALUES (5, 'App\\Models\\Administrator', 1);
INSERT INTO `model_has_roles` VALUES (6, 'App\\Models\\Administrator', 1);
INSERT INTO `model_has_roles` VALUES (7, 'App\\Models\\Administrator', 1);
INSERT INTO `model_has_roles` VALUES (8, 'App\\Models\\Administrator', 1);
INSERT INTO `model_has_roles` VALUES (2, 'App\\Models\\Administrator', 2);
INSERT INTO `model_has_roles` VALUES (4, 'App\\Models\\Administrator', 3);
INSERT INTO `model_has_roles` VALUES (5, 'App\\Models\\Administrator', 5);
INSERT INTO `model_has_roles` VALUES (4, 'App\\Models\\Administrator', 7);
INSERT INTO `model_has_roles` VALUES (4, 'App\\Models\\Administrator', 8);
INSERT INTO `model_has_roles` VALUES (6, 'App\\Models\\Administrator', 10);
INSERT INTO `model_has_roles` VALUES (7, 'App\\Models\\Administrator', 12);
INSERT INTO `model_has_roles` VALUES (7, 'App\\Models\\Administrator', 13);
INSERT INTO `model_has_roles` VALUES (9, 'App\\Models\\Administrator', 14);
INSERT INTO `model_has_roles` VALUES (8, 'App\\Models\\Administrator', 15);
INSERT INTO `model_has_roles` VALUES (5, 'App\\Models\\Administrator', 17);
INSERT INTO `model_has_roles` VALUES (2, 'App\\Models\\Administrator', 20);
INSERT INTO `model_has_roles` VALUES (5, 'App\\Models\\Administrator', 20);
INSERT INTO `model_has_roles` VALUES (2, 'App\\Models\\Administrator', 22);
INSERT INTO `model_has_roles` VALUES (3, 'App\\Models\\Administrator', 22);
INSERT INTO `model_has_roles` VALUES (5, 'App\\Models\\Administrator', 22);
INSERT INTO `model_has_roles` VALUES (2, 'App\\Models\\Administrator', 27);

-- ----------------------------
-- Table structure for permissions
-- ----------------------------
DROP TABLE IF EXISTS `permissions`;
CREATE TABLE `permissions`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `guard_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  `is_menu` tinyint(3) UNSIGNED NOT NULL DEFAULT 0 COMMENT '是否是菜单(0 否; 1 是;)',
  `title` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '菜单名称',
  `route` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '路由名称',
  `pid` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '父级id',
  `param` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '参数',
  `sort` int(255) UNSIGNED NOT NULL DEFAULT 0 COMMENT '排序',
  `icon` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT 'icon',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 102 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of permissions
-- ----------------------------
INSERT INTO `permissions` VALUES (76, 'admin.permission-index', 'admin', NULL, '2023-08-17 17:00:43', 1, '菜单列表', 'admin.permission-index', 82, '', 0, 'layui-icon-form');
INSERT INTO `permissions` VALUES (77, 'admin.permission-add', 'admin', '2023-08-05 14:07:10', '2023-08-08 16:21:04', 0, '添加菜单', 'admin.permission-add', 76, '', 0, 'layui-icon-edit');
INSERT INTO `permissions` VALUES (78, 'admin.permission-edit', 'admin', '2023-08-05 14:07:55', '2023-08-08 16:21:11', 0, '更新菜单', 'admin.permission-edit', 76, '', 0, 'layui-icon-edit');
INSERT INTO `permissions` VALUES (79, 'admin.permission-delete', 'admin', '2023-08-05 14:09:15', '2023-08-08 16:21:18', 0, '删除菜单', 'admin.permission-delete', 76, '', 0, 'layui-icon-edit');
INSERT INTO `permissions` VALUES (80, 'admin.permission-sort', 'admin', '2023-08-05 14:10:47', '2023-08-08 16:21:25', 0, '菜单排序', 'admin.permission-sort', 76, '', 0, 'layui-icon-edit');
INSERT INTO `permissions` VALUES (81, 'admin.permission-menu', 'admin', '2023-08-05 14:11:07', '2023-08-17 10:45:26', 0, '设置菜单', 'admin.permission-menu', 76, '', 0, 'layui-icon-edit');
INSERT INTO `permissions` VALUES (82, 'admin.admin', 'admin', '2023-08-05 16:28:17', '2023-08-17 16:58:09', 1, '权限管理', 'admin.admin', 0, '', 1, 'layui-icon-note');
INSERT INTO `permissions` VALUES (83, 'admin.admin-index', 'admin', '2023-08-05 16:32:47', '2023-08-17 16:59:35', 1, '管理员列表', 'admin.admin-index', 82, '', 0, 'layui-icon-friends');
INSERT INTO `permissions` VALUES (85, 'admin.role-index', 'admin', '2023-08-07 12:07:24', '2023-08-17 16:59:16', 1, '角色列表', 'admin.role-index', 82, '', 0, 'layui-icon-user');
INSERT INTO `permissions` VALUES (93, 'admin.index', 'admin', '2023-08-11 13:31:41', '2023-08-17 16:52:23', 1, '首页', 'admin.index', 0, '', 0, 'layui-icon-home');
INSERT INTO `permissions` VALUES (95, 'admin.role-add', 'admin', '2023-08-16 18:16:08', '2023-08-16 18:16:08', 0, '添加角色', 'admin.role-add', 85, '', 0, 'fa-plus');
INSERT INTO `permissions` VALUES (96, 'admin.role-edit', 'admin', '2023-08-16 18:16:51', '2023-08-16 18:16:51', 0, '更新角色', 'admin.role-edit', 85, '', 0, 'fa-star-half-empty');
INSERT INTO `permissions` VALUES (97, 'admin.role-delete', 'admin', '2023-08-16 18:17:19', '2023-08-16 18:17:19', 0, '删除角色', 'admin.role-delete', 85, '', 0, 'fa-institution');
INSERT INTO `permissions` VALUES (98, 'admin.role-assign', 'admin', '2023-08-16 18:17:45', '2023-08-16 18:17:45', 0, '分配权限', 'admin.role-assign', 85, '', 0, 'layui-icon-edit');
INSERT INTO `permissions` VALUES (99, 'admin.admin-add', 'admin', '2023-08-16 18:18:16', '2023-08-16 18:18:16', 0, '添加管理员', 'admin.admin-add', 83, '', 0, 'layui-icon-edit');
INSERT INTO `permissions` VALUES (100, 'admin.admin-edit', 'admin', '2023-08-16 18:18:44', '2023-08-16 18:18:44', 0, '更新管理员', 'admin.admin-edit', 83, '', 0, 'layui-icon-edit');
INSERT INTO `permissions` VALUES (101, 'admin.admin-delete', 'admin', '2023-08-16 18:19:10', '2023-08-16 18:19:10', 0, '删除管理员', 'admin.admin-delete', 83, '', 0, 'layui-icon-edit');

-- ----------------------------
-- Table structure for role_has_permissions
-- ----------------------------
DROP TABLE IF EXISTS `role_has_permissions`;
CREATE TABLE `role_has_permissions`  (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL,
  PRIMARY KEY (`permission_id`, `role_id`) USING BTREE,
  INDEX `role_has_permissions_role_id_foreign`(`role_id`) USING BTREE,
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of role_has_permissions
-- ----------------------------
INSERT INTO `role_has_permissions` VALUES (76, 1);
INSERT INTO `role_has_permissions` VALUES (77, 1);
INSERT INTO `role_has_permissions` VALUES (82, 1);
INSERT INTO `role_has_permissions` VALUES (83, 1);
INSERT INTO `role_has_permissions` VALUES (85, 1);
INSERT INTO `role_has_permissions` VALUES (93, 1);
INSERT INTO `role_has_permissions` VALUES (82, 2);
INSERT INTO `role_has_permissions` VALUES (83, 2);
INSERT INTO `role_has_permissions` VALUES (93, 2);
INSERT INTO `role_has_permissions` VALUES (76, 3);
INSERT INTO `role_has_permissions` VALUES (77, 3);
INSERT INTO `role_has_permissions` VALUES (78, 3);
INSERT INTO `role_has_permissions` VALUES (80, 3);
INSERT INTO `role_has_permissions` VALUES (81, 3);
INSERT INTO `role_has_permissions` VALUES (82, 3);
INSERT INTO `role_has_permissions` VALUES (83, 3);
INSERT INTO `role_has_permissions` VALUES (85, 3);

-- ----------------------------
-- Table structure for roles
-- ----------------------------
DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `guard_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '状态 1:正常 2:禁用',
  `remark` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '备注',
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `name`(`name`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 12 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of roles
-- ----------------------------
INSERT INTO `roles` VALUES (1, '默认角色', 'admin', 1, '', '2021-09-12 16:10:03', '2021-09-12 16:10:03');
INSERT INTO `roles` VALUES (2, '测试角色', 'admin', 1, '', '2022-07-22 10:47:28', '2022-07-22 10:47:28');
INSERT INTO `roles` VALUES (3, '测试角色3', 'admin', 1, '', '2022-07-22 16:23:28', '2022-07-22 16:23:28');
INSERT INTO `roles` VALUES (4, '选品专员', 'admin', 1, '', '2022-07-26 14:34:12', '2022-07-28 18:27:55');
INSERT INTO `roles` VALUES (5, '选品主管', 'admin', 1, '', '2022-07-28 16:46:22', '2022-07-28 16:46:22');
INSERT INTO `roles` VALUES (6, '选品美工', 'admin', 1, '', '2022-08-08 10:50:34', '2022-08-08 10:50:34');
INSERT INTO `roles` VALUES (7, '选品主播', 'admin', 1, '', '2022-08-08 10:50:46', '2022-08-08 10:50:46');
INSERT INTO `roles` VALUES (8, '选品摄影', 'admin', 1, '', '2022-08-08 15:04:19', '2022-08-08 15:04:19');
INSERT INTO `roles` VALUES (9, '选品文案', 'admin', 1, '', '2022-08-08 15:04:36', '2022-08-08 15:04:36');
INSERT INTO `roles` VALUES (10, '合伙人', 'admin', 2, '合伙人', '2023-08-07 12:44:39', '2023-08-16 19:06:07');

SET FOREIGN_KEY_CHECKS = 1;
