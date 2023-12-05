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

 Date: 06/12/2023 01:26:25
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for armadas
-- ----------------------------
DROP TABLE IF EXISTS `armadas`;
CREATE TABLE `armadas`  (
  `armada_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `user_id` int NULL DEFAULT NULL,
  `armada_driver` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `armada_plat` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `armada_id_gps` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `armada_subdistinct` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `armada_driver_photo` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  PRIMARY KEY (`armada_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of armadas
-- ----------------------------
INSERT INTO `armadas` VALUES ('AMD0000000001', 13, 'Saiful', 'KT 1234 ZL', '?', '727101', '/image/1701792026_.jpg');

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
  `customer_nomenklatur` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `customer_photo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `customer_lat` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `customer_long` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`customer_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of customers
-- ----------------------------
INSERT INTO `customers` VALUES (1, 5, 'Samsul Bahri', '081277057373', 'JL Flamboyan RT 23 Kelurahan Baru Ulu', 'Palu Timur', 'Lolu Selatan', 'HOTEL', '/image/1701791041__1.jpg', '-5.1511296', '119.4524672');

-- ----------------------------
-- Table structure for detail_order_sepithanks
-- ----------------------------
DROP TABLE IF EXISTS `detail_order_sepithanks`;
CREATE TABLE `detail_order_sepithanks`  (
  `detail_order_sepithank_id` int NOT NULL AUTO_INCREMENT,
  `order_id` int NULL DEFAULT NULL,
  `sepithank_id` int NULL DEFAULT NULL,
  `price` int NULL DEFAULT NULL,
  PRIMARY KEY (`detail_order_sepithank_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of detail_order_sepithanks
-- ----------------------------
INSERT INTO `detail_order_sepithanks` VALUES (1, 7, 2, 300000);
INSERT INTO `detail_order_sepithanks` VALUES (2, 7, 3, 300000);
INSERT INTO `detail_order_sepithanks` VALUES (3, 4, 2, 300000);

-- ----------------------------
-- Table structure for kecamatan
-- ----------------------------
DROP TABLE IF EXISTS `kecamatan`;
CREATE TABLE `kecamatan`  (
  `kecamatan_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`kecamatan_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of kecamatan
-- ----------------------------
INSERT INTO `kecamatan` VALUES ('727101', 'Palu Timur');
INSERT INTO `kecamatan` VALUES ('727102', 'Palu Barat');
INSERT INTO `kecamatan` VALUES ('727103', 'Palu Selatan');
INSERT INTO `kecamatan` VALUES ('727104', 'Palu Utara');
INSERT INTO `kecamatan` VALUES ('727105', 'Ulujadi');
INSERT INTO `kecamatan` VALUES ('727106', 'Tatanga');
INSERT INTO `kecamatan` VALUES ('727107', 'Tawaeli');
INSERT INTO `kecamatan` VALUES ('727108', 'Mantikulore');

-- ----------------------------
-- Table structure for kelurahan
-- ----------------------------
DROP TABLE IF EXISTS `kelurahan`;
CREATE TABLE `kelurahan`  (
  `kelurahan_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `kecamatan_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`kelurahan_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of kelurahan
-- ----------------------------
INSERT INTO `kelurahan` VALUES ('7271011004', '727101', 'Besusu Barat');
INSERT INTO `kelurahan` VALUES ('7271011006', '727101', 'Besusu Tengah');
INSERT INTO `kelurahan` VALUES ('7271011007', '727101', 'Besusu Timur');
INSERT INTO `kelurahan` VALUES ('7271011009', '727101', 'Lolu Selatan');
INSERT INTO `kelurahan` VALUES ('7271011010', '727101', 'Lolu Utara');
INSERT INTO `kelurahan` VALUES ('7271021002', '727101', 'Ujuna');
INSERT INTO `kelurahan` VALUES ('7271021005', '727101', 'Balaroa');
INSERT INTO `kelurahan` VALUES ('7271021007', '727101', 'Kamonji');
INSERT INTO `kelurahan` VALUES ('7271021008', '727101', 'Baru');
INSERT INTO `kelurahan` VALUES ('7271021009', '727101', 'Lere');
INSERT INTO `kelurahan` VALUES ('7271021015', '727101', 'Siranindi');
INSERT INTO `kelurahan` VALUES ('7271031001', '727101', 'Tatura Utara');
INSERT INTO `kelurahan` VALUES ('7271031002', '727101', 'Birobuli Utara');
INSERT INTO `kelurahan` VALUES ('7271031003', '727101', 'Petobo');
INSERT INTO `kelurahan` VALUES ('7271031011', '727101', 'Birobuli Selatan');
INSERT INTO `kelurahan` VALUES ('7271031012', '727101', 'Tatura Selatan');
INSERT INTO `kelurahan` VALUES ('7271041001', '727101', 'Mamboro');
INSERT INTO `kelurahan` VALUES ('7271041002', '727101', 'Taipa');
INSERT INTO `kelurahan` VALUES ('7271041003', '727101', 'Kayumalue Ngapa');
INSERT INTO `kelurahan` VALUES ('7271041004', '727101', 'Kayumalue Pajeko');
INSERT INTO `kelurahan` VALUES ('7271041010', '727101', 'Mamboro Barat');
INSERT INTO `kelurahan` VALUES ('7271051001', '727101', 'Buluri');
INSERT INTO `kelurahan` VALUES ('7271051002', '727101', 'Donggala Kodi');
INSERT INTO `kelurahan` VALUES ('7271051003', '727101', 'Kabonena');
INSERT INTO `kelurahan` VALUES ('7271051004', '727101', 'Silae');
INSERT INTO `kelurahan` VALUES ('7271051005', '727101', 'Watusampu');
INSERT INTO `kelurahan` VALUES ('7271051006', '727101', 'Tipo');
INSERT INTO `kelurahan` VALUES ('7271061001', '727101', 'Nunu');
INSERT INTO `kelurahan` VALUES ('7271061002', '727101', 'Palupi');
INSERT INTO `kelurahan` VALUES ('7271061003', '727101', 'Tawanjuka');
INSERT INTO `kelurahan` VALUES ('7271061004', '727101', 'Pengawu');
INSERT INTO `kelurahan` VALUES ('7271061005', '727101', 'Duyu');
INSERT INTO `kelurahan` VALUES ('7271061006', '727101', 'Boyaoge');
INSERT INTO `kelurahan` VALUES ('7271071001', '727101', 'Pantoloan');
INSERT INTO `kelurahan` VALUES ('7271071002', '727101', 'Pantoloan Boya');
INSERT INTO `kelurahan` VALUES ('7271071003', '727101', 'Baiya');
INSERT INTO `kelurahan` VALUES ('7271071004', '727101', 'Lambara');
INSERT INTO `kelurahan` VALUES ('7271071005', '727101', 'Panawu');
INSERT INTO `kelurahan` VALUES ('7271081001', '727101', 'Layana Indah');
INSERT INTO `kelurahan` VALUES ('7271081002', '727101', 'Tondo');
INSERT INTO `kelurahan` VALUES ('7271081003', '727101', 'Talise');
INSERT INTO `kelurahan` VALUES ('7271081004', '727101', 'Tanamodindi');
INSERT INTO `kelurahan` VALUES ('7271081005', '727101', 'Lasoani');
INSERT INTO `kelurahan` VALUES ('7271081006', '727101', 'Poboya');
INSERT INTO `kelurahan` VALUES ('7271081007', '727101', 'Kawatuna');

-- ----------------------------
-- Table structure for orders
-- ----------------------------
DROP TABLE IF EXISTS `orders`;
CREATE TABLE `orders`  (
  `order_id` int NOT NULL AUTO_INCREMENT,
  `customer_id` int NULL DEFAULT NULL,
  `channel_id` int NULL DEFAULT NULL,
  `armada_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `order_invoice` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `order_lat` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `order_long` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `order_price` int NULL DEFAULT NULL,
  `order_status_payment` enum('ordered','fail_pay','payed','refunded') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `order_status_job` enum('not_start','on_queue','on_the_way','on_process','done','rejected') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `order_date` datetime NULL DEFAULT NULL,
  `order_payment_method` enum('tunai','non_tunai') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `payment_invoice` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `payment_expired` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `payment_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `payment_message` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `order_proof_photo` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  PRIMARY KEY (`order_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of orders
-- ----------------------------
INSERT INTO `orders` VALUES (4, 1, 11, NULL, 'LBW0000000001', '-5.1511296', '119.4524672', 300000, 'ordered', 'not_start', '2023-12-01 15:32:31', 'non_tunai', 'DEV-T23605133293WQ8AG', '1701448330', 'https://tripay.co.id/checkout/DEV-T23605133293WQ8AG', NULL, NULL);
INSERT INTO `orders` VALUES (7, 1, NULL, 'AMD0000000001', 'DBY0000000001', '-1.2230876', '116.8134612', 600000, 'ordered', 'done', '2023-12-05 06:33:51', 'tunai', NULL, NULL, NULL, NULL, '/image/1701795809_.jpg');

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
-- Table structure for sepithanks
-- ----------------------------
DROP TABLE IF EXISTS `sepithanks`;
CREATE TABLE `sepithanks`  (
  `sepithank_id` int NOT NULL AUTO_INCREMENT,
  `customer_id` int NULL DEFAULT NULL,
  `sepithank_vol` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `sepithank_unit` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`sepithank_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of sepithanks
-- ----------------------------
INSERT INTO `sepithanks` VALUES (2, 1, '5000', 'M2');
INSERT INTO `sepithanks` VALUES (3, 1, '10000', 'M2');

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
  `level` enum('administrator','customer','armada') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`user_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 14 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES (1, 'anureta', '$2y$10$f4fU2f9INDGEPD8OyamsXuFS8dxNghUYZRZmSOXqhx/Knpzk4z9Du', 'administrator');
INSERT INTO `users` VALUES (5, 'samsulbahri', '$2y$10$f4fU2f9INDGEPD8OyamsXuFS8dxNghUYZRZmSOXqhx/Knpzk4z9Du', 'customer');
INSERT INTO `users` VALUES (7, '86216871628', '$2y$12$t2oniBt6zZgsXYehX3.wAu5ag1tCPKC3DaibL96CI7pF9Y248Z0hm', 'customer');
INSERT INTO `users` VALUES (13, 'AMD0000000001', '$2y$12$wuQXvzPmPVbU/GcZcqV8H.5bNg7x.20/.Dkbg3yOd4omPTU6kwaOm', 'armada');

SET FOREIGN_KEY_CHECKS = 1;
