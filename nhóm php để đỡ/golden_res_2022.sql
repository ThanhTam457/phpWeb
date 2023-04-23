-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Nov 09, 2022 at 12:25 PM
-- Server version: 8.0.27
-- PHP Version: 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `golden_res_2022`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

DROP TABLE IF EXISTS `accounts`;
CREATE TABLE IF NOT EXISTS `accounts` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `phone_num` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `F_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `L_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `role` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id`, `phone_num`, `password_hash`, `F_name`, `L_name`, `address`, `role`) VALUES
(1, '0765984722', '$2y$10$xkZ9CFoY/NDZOL7V7XdxOOPD5ojc826bHMcqYSFVL4LwMEGG9K5/K', 'Chau', 'Minh', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `bills`
--

DROP TABLE IF EXISTS `bills`;
CREATE TABLE IF NOT EXISTS `bills` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `custom_id` bigint NOT NULL,
  `employ_id` bigint DEFAULT NULL,
  `total_pay_amount` float NOT NULL,
  `bill_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `FK_customID_id` (`custom_id`),
  KEY `FK_employID_id` (`employ_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `bills`
--

INSERT INTO `bills` (`id`, `custom_id`, `employ_id`, `total_pay_amount`, `bill_date`) VALUES
(1, 1, NULL, 5, '2022-11-06 14:20:22'),
(2, 1, NULL, 5, '2022-11-06 14:20:22'),
(3, 1, NULL, 5, '2022-11-06 14:20:22'),
(4, 1, NULL, 21.3, '2022-11-06 17:04:35'),
(5, 1, NULL, 21.3, '2022-11-06 17:05:51'),
(6, 1, NULL, 18, '2022-11-06 17:07:55'),
(7, 1, NULL, 14.05, '2022-11-08 21:22:45');

-- --------------------------------------------------------

--
-- Table structure for table `booking_tables`
--

DROP TABLE IF EXISTS `booking_tables`;
CREATE TABLE IF NOT EXISTS `booking_tables` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `custom_id` bigint NOT NULL,
  `table_id` bigint NOT NULL,
  `bill_id` bigint NOT NULL,
  `booking_date` datetime NOT NULL,
  `exp_date` datetime NOT NULL,
  `num_people` int NOT NULL,
  `status` tinyint NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_cusID_id` (`custom_id`),
  KEY `FK_tableID_id` (`table_id`),
  KEY `FK_bilIDbookingtable_id` (`bill_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `booking_tables`
--

INSERT INTO `booking_tables` (`id`, `custom_id`, `table_id`, `bill_id`, `booking_date`, `exp_date`, `num_people`, `status`) VALUES
(1, 1, 1, 1, '2022-11-20 10:00:00', '0000-00-00 00:00:00', 4, 0),
(2, 1, 12, 2, '2022-11-20 10:00:00', '0000-00-00 00:00:00', 5, 1),
(3, 1, 10, 3, '2022-11-20 10:00:00', '0000-00-00 00:00:00', 7, 0);

-- --------------------------------------------------------

--
-- Table structure for table `custom_foods`
--

DROP TABLE IF EXISTS `custom_foods`;
CREATE TABLE IF NOT EXISTS `custom_foods` (
  `custom_id` bigint NOT NULL,
  `food_id` bigint NOT NULL,
  `bill_id` bigint NOT NULL,
  `num_item` int NOT NULL,
  KEY `FK_cID_id` (`custom_id`),
  KEY `FK_foodID_id` (`food_id`),
  KEY `FK_bilID_id` (`bill_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `custom_foods`
--

INSERT INTO `custom_foods` (`custom_id`, `food_id`, `bill_id`, `num_item`) VALUES
(1, 1, 4, 1),
(1, 5, 4, 2),
(1, 9, 4, 1),
(1, 17, 4, 1),
(1, 18, 4, 2),
(1, 16, 4, 1),
(1, 2, 5, 1),
(1, 8, 5, 2),
(1, 22, 5, 2),
(1, 19, 5, 1),
(1, 11, 6, 1),
(1, 10, 6, 2),
(1, 15, 6, 1),
(1, 14, 6, 1),
(1, 7, 7, 1),
(1, 1, 7, 1),
(1, 22, 7, 1),
(1, 19, 7, 1);

-- --------------------------------------------------------

--
-- Table structure for table `foods`
--

DROP TABLE IF EXISTS `foods`;
CREATE TABLE IF NOT EXISTS `foods` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `price` float NOT NULL,
  `img` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `foods`
--

INSERT INTO `foods` (`id`, `name`, `description`, `price`, `img`, `type`) VALUES
(1, 'Vietnamese Bread', NULL, 3, 'images/Foods/MainCoursed/BanhMi.jpg', 'main coursed'),
(2, 'Banh Xeo', NULL, 4.5, 'images/Foods/MainCoursed/BanhXeo.jpg', 'main coursed'),
(3, 'Bun Bo', NULL, 5, 'images/Foods/MainCoursed/BunBo.jpg', 'main coursed'),
(4, 'Pork Organ Congee', NULL, 4.5, 'images/Foods/MainCoursed/ChaoLong.jpg', 'main coursed'),
(5, 'Spring Roll', NULL, 3.5, 'images/Foods/MainCoursed/GoiCuon.jpg', 'main coursed'),
(6, 'White Noodle', NULL, 4.5, 'images/Foods/MainCoursed/HuTieu.jpg', 'main coursed'),
(7, 'Mixed Steamed Vermicelli', NULL, 6, 'images/Foods/MainCoursed/MienHapThapCam.jpg', 'main coursed'),
(8, 'Quang Noodle', NULL, 4.5, 'images/Foods/MainCoursed/MiQuang.jpg', 'main coursed'),
(9, 'Pho', NULL, 5, 'images/Foods/MainCoursed/Pho.jpg', 'main coursed'),
(10, 'Crab Soup', NULL, 5, 'images/Foods/MainCoursed/SupCua.jpg', 'main coursed'),
(11, 'Pudding', NULL, 1.5, 'images/Foods/Desserts/BanhFlan.jpg', 'dessert'),
(12, 'Sticky Rice Balls', NULL, 2, 'images/Foods/Desserts/CheTroiNuoc.jpg', 'dessert'),
(13, 'Avocado Ice Cream', NULL, 3, 'images/Foods/Desserts/KemBo.jpg', 'dessert'),
(14, 'Coffee Ice Cream', NULL, 3, 'images/Foods/Desserts/KemCaPhe.jpg', 'dessert'),
(15, 'Matcha Latte', NULL, 3.5, 'images/Foods/Desserts/KemBo.jpg', 'dessert'),
(16, 'Milk Coffee', NULL, 2, 'images/Foods/Beverages/CaPheSua.jpg', 'beverage'),
(17, 'Coca', NULL, 2.3, 'images/Foods/Beverages/Coca.jpg', 'beverage'),
(18, 'Aquafina', NULL, 1, 'images/Foods/Beverages/NuocSuoi.jpg', 'beverage'),
(19, 'Pepsi', NULL, 2.3, 'images/Foods/Beverages/Pepsi.jpg', 'beverage'),
(20, 'Peach Tea', NULL, 2.75, 'images/Foods/Beverages/TraDao.jpg', 'beverage'),
(21, 'Milk Tea', NULL, 3, 'images/Foods/Beverages/TraSua.jpg', 'beverage'),
(22, 'Lychee Tea', NULL, 2.75, 'images/Foods/Beverages/TraVai.jpg', 'beverage');

-- --------------------------------------------------------

--
-- Table structure for table `tables`
--

DROP TABLE IF EXISTS `tables`;
CREATE TABLE IF NOT EXISTS `tables` (
  `id` bigint NOT NULL,
  `num_seat` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tables`
--

INSERT INTO `tables` (`id`, `num_seat`) VALUES
(1, 4),
(2, 4),
(3, 4),
(4, 4),
(5, 4),
(6, 4),
(7, 4),
(8, 4),
(9, 8),
(10, 6),
(11, 6),
(12, 8),
(13, 4),
(14, 4),
(15, 4),
(16, 4),
(17, 4),
(18, 4),
(19, 4),
(20, 4);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bills`
--
ALTER TABLE `bills`
  ADD CONSTRAINT `FK_customID_id` FOREIGN KEY (`custom_id`) REFERENCES `accounts` (`id`),
  ADD CONSTRAINT `FK_employID_id` FOREIGN KEY (`employ_id`) REFERENCES `accounts` (`id`);

--
-- Constraints for table `booking_tables`
--
ALTER TABLE `booking_tables`
  ADD CONSTRAINT `FK_bilIDbookingtable_id` FOREIGN KEY (`bill_id`) REFERENCES `bills` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `FK_cusID_id` FOREIGN KEY (`custom_id`) REFERENCES `accounts` (`id`),
  ADD CONSTRAINT `FK_tableID_id` FOREIGN KEY (`table_id`) REFERENCES `tables` (`id`);

--
-- Constraints for table `custom_foods`
--
ALTER TABLE `custom_foods`
  ADD CONSTRAINT `FK_bilID_id` FOREIGN KEY (`bill_id`) REFERENCES `bills` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `FK_cID_id` FOREIGN KEY (`custom_id`) REFERENCES `accounts` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `FK_foodID_id` FOREIGN KEY (`food_id`) REFERENCES `foods` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
