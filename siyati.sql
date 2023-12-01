/*
 Navicat Premium Data Transfer

 Source Server         : local
 Source Server Type    : MySQL
 Source Server Version : 100427
 Source Host           : localhost:3306
 Source Schema         : siyati

 Target Server Type    : MySQL
 Target Server Version : 100427
 File Encoding         : 65001

 Date: 30/11/2023 13:08:45
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for customers
-- ----------------------------
DROP TABLE IF EXISTS `customers`;
CREATE TABLE `customers`  (
  `customer_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NULL DEFAULT NULL,
  `customer_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `customer_phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `customer_address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `customer_subdistrict` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `customer_urban_village` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `customer_vol` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `customer_unit` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `customer_nomenklatur` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `customer_photo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `customer_lat` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `customer_long` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`customer_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of customers
-- ----------------------------
INSERT INTO `customers` VALUES (1, 5, 'Samsul Bahri', '081277057373', 'JL Flamboyan RT 23 Kelurahan Baru Ulu', 'PALU TIMUR', 'TANAMODINDI', '1', 'M2', 'HOTEL', '/image/1700725138_86216871628.jpg', '-5.1511296', '119.4524672');

-- ----------------------------
-- Table structure for orders
-- ----------------------------
DROP TABLE IF EXISTS `orders`;
CREATE TABLE `orders`  (
  `order_id` int NOT NULL AUTO_INCREMENT,
  `customer_id` int NULL DEFAULT NULL,
  `channel_id` int NULL DEFAULT NULL,
  `order_invoice` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `order_lat` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `order_long` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `order_price` int NULL DEFAULT NULL,
  `order_status` enum('ordered','fail_pay','payed','process','failed','done') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `order_date` datetime NULL DEFAULT NULL,
  `order_payment_method` enum('tunai','non_tunai') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `payment_invoice` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `payment_expired` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `payment_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `payment_message` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`order_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of orders
-- ----------------------------
INSERT INTO `orders` VALUES (1, 1, 11, 'LAR0000000001', '-5.1511296', '119.4524672', 300000, 'ordered', '2023-11-28 05:26:57', 'non_tunai', 'DEV-T23605132077VMO5K', '1701160605', 'https://tripay.co.id/checkout/DEV-T23605132077VMO5K', NULL);

-- ----------------------------
-- Table structure for price_references
-- ----------------------------
DROP TABLE IF EXISTS `price_references`;
CREATE TABLE `price_references`  (
  `price_reference_id` int NOT NULL AUTO_INCREMENT,
  `type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `minimum_size` double NULL DEFAULT NULL,
  `maximum_size` double NULL DEFAULT NULL,
  `price` int NULL DEFAULT NULL,
  PRIMARY KEY (`price_reference_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of price_references
-- ----------------------------
INSERT INTO `price_references` VALUES (1, 'M2', 1, 2000, 300000);

-- ----------------------------
-- Table structure for tripay_channels
-- ----------------------------
DROP TABLE IF EXISTS `tripay_channels`;
CREATE TABLE `tripay_channels`  (
  `channel_id` int NOT NULL AUTO_INCREMENT,
  `channel_code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `channel_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `channel_group` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `channel_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `fee_merchant_flat` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `fee_merchant_percent` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `fee_customer_flat` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `fee_customer_percent` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `total_fee_flat` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `total_fee_percent` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `minimum_fee` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `maximum_fee` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `channel_icon_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `channel_active` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`channel_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 14 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tripay_channels
-- ----------------------------
INSERT INTO `tripay_channels` VALUES (1, 'MYBVA', 'Maybank Virtual Account', 'Virtual Account', 'direct', '0', '0', '4250', '0', '4250', '0.00', NULL, NULL, 'https://assets.tripay.co.id/upload/payment-icon/ZT91lrOEad1582929126.png', '1');
INSERT INTO `tripay_channels` VALUES (2, 'PERMATAVA', 'Permata Virtual Account', 'Virtual Account', 'direct', '0', '0', '4250', '0', '4250', '0.00', NULL, NULL, 'https://assets.tripay.co.id/upload/payment-icon/szezRhAALB1583408731.png', '1');
INSERT INTO `tripay_channels` VALUES (3, 'BRIVA', 'BRI Virtual Account', 'Virtual Account', 'direct', '0', '0', '4250', '0', '4250', '0.00', NULL, NULL, 'https://assets.tripay.co.id/upload/payment-icon/8WQ3APST5s1579461828.png', '1');
INSERT INTO `tripay_channels` VALUES (4, 'MANDIRIVA', 'Mandiri Virtual Account', 'Virtual Account', 'direct', '0', '0', '4250', '0', '4250', '0.00', NULL, NULL, 'https://assets.tripay.co.id/upload/payment-icon/T9Z012UE331583531536.png', '1');
INSERT INTO `tripay_channels` VALUES (5, 'BCAVA', 'BCA Virtual Account', 'Virtual Account', 'direct', '0', '0', '5500', '0', '5500', '0.00', NULL, NULL, 'https://assets.tripay.co.id/upload/payment-icon/ytBKvaleGy1605201833.png', '1');
INSERT INTO `tripay_channels` VALUES (6, 'BSIVA', 'BSI Virtual Account', 'Virtual Account', 'direct', '0', '0', '4250', '0', '4250', '0.00', NULL, NULL, 'https://assets.tripay.co.id/upload/payment-icon/tEclz5Assb1643375216.png', '1');
INSERT INTO `tripay_channels` VALUES (7, 'DANAMONVA', 'Danamon Virtual Account', 'Virtual Account', 'direct', '0', '0', '4250', '0', '4250', '0.00', NULL, NULL, 'https://assets.tripay.co.id/upload/payment-icon/F3pGzDOLUz1644245546.png', '1');
INSERT INTO `tripay_channels` VALUES (8, 'ALFAMART', 'Alfamart', 'Convenience Store', 'direct', '0', '0', '3500', '0', '3500', '0.00', NULL, NULL, 'https://assets.tripay.co.id/upload/payment-icon/jiGZMKp2RD1583433506.png', '1');
INSERT INTO `tripay_channels` VALUES (9, 'INDOMARET', 'Indomaret', 'Convenience Store', 'direct', '0', '0', '3500', '0', '3500', '0.00', NULL, NULL, 'https://assets.tripay.co.id/upload/payment-icon/zNzuO5AuLw1583513974.png', '1');
INSERT INTO `tripay_channels` VALUES (10, 'OVO', 'OVO', 'E-Wallet', 'redirect', '0', '0', '0', '3', '0', '3.00', '1000', NULL, 'https://assets.tripay.co.id/upload/payment-icon/fH6Y7wDT171586199243.png', '1');
INSERT INTO `tripay_channels` VALUES (11, 'QRIS2', 'QRIS', 'E-Wallet', 'direct', '0', '0', '750', '0.7', '750', '0.70', NULL, NULL, 'https://assets.tripay.co.id/upload/payment-icon/8ewGzP6SWe1649667701.png', '1');
INSERT INTO `tripay_channels` VALUES (12, 'DANA', 'DANA', 'E-Wallet', 'redirect', '0', '0', '0', '3', '0', '3.00', '1000', NULL, 'https://assets.tripay.co.id/upload/payment-icon/sj3UHLu8Tu1655719621.png', '1');
INSERT INTO `tripay_channels` VALUES (13, 'SHOPEEPAY', 'ShopeePay', 'E-Wallet', 'redirect', '0', '0', '0', '3', '0', '3.00', '1000', NULL, 'https://assets.tripay.co.id/upload/payment-icon/d204uajhlS1655719774.png', '1');

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `user_id` int NOT NULL AUTO_INCREMENT,
  `nik` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `level` enum('administrator','customer') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`user_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES (1, 'anureta', '$2y$10$f4fU2f9INDGEPD8OyamsXuFS8dxNghUYZRZmSOXqhx/Knpzk4z9Du', 'administrator');
INSERT INTO `users` VALUES (5, 'samsulbahri', '$2y$10$f4fU2f9INDGEPD8OyamsXuFS8dxNghUYZRZmSOXqhx/Knpzk4z9Du', 'customer');
INSERT INTO `users` VALUES (7, '86216871628', '$2y$12$t2oniBt6zZgsXYehX3.wAu5ag1tCPKC3DaibL96CI7pF9Y248Z0hm', 'customer');

SET FOREIGN_KEY_CHECKS = 1;
