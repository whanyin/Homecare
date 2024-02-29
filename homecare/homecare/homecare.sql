/*
 Navicat Premium Data Transfer

 Source Server         : 127.0.0.1
 Source Server Type    : MySQL
 Source Server Version : 80012
 Source Host           : 127.0.0.1:3306
 Source Schema         : heroku

 Target Server Type    : MySQL
 Target Server Version : 80012
 File Encoding         : 65001

 Date: 02/01/2024 12:37:18
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for blog
-- ----------------------------


-- ----------------------------
-- Table structure for category
-- ----------------------------
DROP TABLE IF EXISTS `category`;
CREATE TABLE `category`  (
  `cate_id` int NOT NULL AUTO_INCREMENT,
  `cate_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'category name',
  `cate_desc` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT 'Category description',
  `cate_remark` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`cate_id`) USING BTREE,
  UNIQUE INDEX `cate_name`(`cate_name`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of category
-- ----------------------------
INSERT INTO `category` VALUES (2, 'Online consultation', '2', 'Online consultation');
INSERT INTO `category` VALUES (3, 'Reservation', '3', 'Reservation');
INSERT INTO `category` VALUES (4, 'Record', '4', 'Record');



-- ----------------------------
-- Table structure for consultation
-- ----------------------------
DROP TABLE IF EXISTS `consultation`;
CREATE TABLE `consultation`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL COMMENT 'Consultant',
  `type` tinyint(1) NOT NULL COMMENT '1 Regular health assessment; 2 Medication management; 3 Rehabilitation services; 4 Home care; 5 Others (please specify):',
  `consultation_content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL COMMENT 'content',
  `cate_id` int NOT NULL COMMENT 'id of the type',
  `consultation_time` datetime NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Publish time, use the current time directly',
  `doctor_answer` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL COMMENT 'answer',
  `doctor_id` int NULL DEFAULT NULL COMMENT 'Answer',
  `doctor_time` datetime NULL DEFAULT NULL COMMENT 'Answer time',
  `pay_type` tinyint(1) NULL DEFAULT 1 COMMENT '1credit card 2cash',
  `amount` int NULL DEFAULT 0 COMMENT 'price',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;


-- ----------------------------
-- Table structure for patient_files
-- ----------------------------
DROP TABLE IF EXISTS `patient_files`;
CREATE TABLE `patient_files`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL COMMENT '用户id',
  `type` tinyint(1) NOT NULL,
  `doctor_content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL COMMENT 'Doctor orders',
  `doctor_id` int NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;




-- ----------------------------
-- Table structure for reservation
-- ----------------------------
DROP TABLE IF EXISTS `reservation`;
CREATE TABLE `reservation`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL COMMENT 'Reservation person',
  `type` tinyint(1) NOT NULL COMMENT '1 Regular health assessment; 2 Medication management; 3 Rehabilitation services; 4 Home care; 5 Others (please specify):',
  `reservation_content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL COMMENT 'content',
  `cate_id` int NOT NULL COMMENT 'id of the type',
  `reservation_time` datetime NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'reservation time',
  `doctor_id` int NULL DEFAULT NULL COMMENT 'doctor id',
   `status` tinyint(1) NULL DEFAULT NULL COMMENT '0: Wait 1: Success; 2 Failure',
   `answer_time` datetime NULL DEFAULT NULL COMMENT 'Answer time',
   `pay_type` tinyint(1) NULL DEFAULT 1 COMMENT '1 credit card 2 cash',
   `amount` int NULL DEFAULT 0 COMMENT 'price',
   `withdraw` int NULL DEFAULT 0 COMMENT 'Withdraw amount',
   PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;



-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
   `user_id` int NOT NULL AUTO_INCREMENT,
   `user_name` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
   `user_pass` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT 'md5 encryption result',
   `user_mail` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT 'email address',
   `login_times` int NULL DEFAULT NULL COMMENT 'number of logins',
   `flag` tinyint NULL DEFAULT NULL COMMENT 'User type: 1 means administrator, 2 means ordinary user',
   `phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT 'Mobile phone number',
   `status` tinyint(1) NULL DEFAULT NULL COMMENT 'status',
   `capacity` tinyint(1) NULL DEFAULT NULL COMMENT 'capacity',
   PRIMARY KEY (`user_id`) USING BTREE,
   UNIQUE INDEX `user_name`(`user_name`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES (1, 'admin', 'e10adc3949ba59abbe56e057f20f883e', 'admin@gmail.com', 0, 1, '12345678', 0, 0);
INSERT INTO `user` VALUES (5, 'Dr. Li', 'e10adc3949ba59abbe56e057f20f883e', '123@qq.com', NULL, 3, '12345678', 1, 1);
INSERT INTO `user` VALUES (6, 'Dr.wang', 'e10adc3949ba59abbe56e057f20f883e', '456@gmail.com', NULL, 3, '12345678', 0, 0);

SET FOREIGN_KEY_CHECKS = 1;
