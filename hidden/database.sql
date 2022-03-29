-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 29, 2022 at 12:05 PM
-- Server version: 10.5.15-MariaDB-0+deb11u1
-- PHP Version: 7.4.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shop`
--

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(10) NOT NULL,
  `kunden_id` int(10) NOT NULL,
  `ordered` tinyint(1) NOT NULL DEFAULT 0,
  `ordered_date` datetime DEFAULT NULL,
  `sent` tinyint(1) NOT NULL DEFAULT 0,
  `sent_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `kunden_id`, `ordered`, `ordered_date`, `sent`, `sent_date`) VALUES
(1, 1, 0, NULL, 0, NULL),
(4, 2, 0, NULL, 0, NULL),
(6, 3, 0, NULL, 0, NULL),
(7, 5, 0, NULL, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `permission_group`
--

CREATE TABLE `permission_group` (
  `id` int(10) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `showUser` tinyint(1) NOT NULL DEFAULT 0,
  `modifyUser` tinyint(1) NOT NULL DEFAULT 0,
  `deleteUser` tinyint(1) NOT NULL DEFAULT 0,
  `showUserPerms` tinyint(1) NOT NULL DEFAULT 0,
  `modifyUserPerms` tinyint(1) NOT NULL DEFAULT 0,
  `showProduct` tinyint(1) NOT NULL DEFAULT 0,
  `createProduct` tinyint(1) NOT NULL DEFAULT 0,
  `modifyProduct` tinyint(1) NOT NULL DEFAULT 0,
  `showCategories` tinyint(1) NOT NULL DEFAULT 0,
  `modifyCategories` tinyint(1) NOT NULL DEFAULT 0,
  `deleteCategories` tinyint(1) NOT NULL DEFAULT 0,
  `createCategories` tinyint(1) NOT NULL DEFAULT 0,
  `showOrders` tinyint(1) NOT NULL DEFAULT 0,
  `markOrders` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `permission_group`
--

INSERT INTO `permission_group` (`id`, `name`, `showUser`, `modifyUser`, `deleteUser`, `showUserPerms`, `modifyUserPerms`, `showProduct`, `createProduct`, `modifyProduct`, `showCategories`, `modifyCategories`, `deleteCategories`, `createCategories`, `showOrders`, `markOrders`) VALUES
(1, 'default', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(2, 'admin', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1),
(3, 'employee', 1, 0, 0, 0, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(10) NOT NULL,
  `name` varchar(255) NOT NULL,
  `desc` mediumtext NOT NULL,
  `product_type_id` int(10) NOT NULL,
  `price` decimal(7,2) NOT NULL,
  `rrp` decimal(7,2) NOT NULL DEFAULT 0.00,
  `quantity` int(10) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `visible` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `desc`, `product_type_id`, `price`, `rrp`, `quantity`, `created_at`, `updated_at`, `visible`) VALUES
(1, 'Test', 'Test Description', 100000, '10.00', '0.00', 20, '2022-02-07 15:24:08', '2022-03-23 21:13:16', 0),
(2, 'RTX 3080 TI', 'Ist der Hammer und nicht überteuert', 54, '1500.00', '900.00', 200, '2022-02-10 05:38:03', '2022-03-12 19:42:41', 1),
(3, 'RTX 3070 TI', 'Ist der Hammer', 54, '1500.00', '900.00', 200, '2022-02-10 05:38:19', '2022-03-12 19:43:13', 1),
(4, 'RTX 3070', 'Ist der Hammer', 54, '1500.00', '900.00', 19, '2022-02-10 05:38:39', '2022-03-12 19:43:13', 1),
(5, 'Uhr', 'Ist der Hammer', 100000, '120.00', '140.00', 6, '2022-02-10 05:39:19', '2022-03-23 21:13:16', 1),
(6, 'RTX 3060', 'Ist der Hammer und nicht überteuert', 54, '1500.00', '900.00', 5, '2022-03-06 05:38:03', '2022-03-12 19:43:13', 1),
(7, 'Test', 'Test Description', 100000, '10.00', '0.00', 0, '2022-02-07 15:24:08', '2022-03-23 21:13:16', 1),
(8, 'Classic Vintage Monitor', 'Best Device ever.', 106, '1099.99', '1099.99', 5, '2022-03-13 19:03:15', '2022-03-13 19:03:15', 1),
(9, 'Test2', 'Test2 Description', 100000, '10.00', '0.00', 0, '2022-02-07 15:24:08', '2022-03-23 21:13:16', 1),
(10, 'RTX 307023 TI', 'Ist der Hammer', 54, '1500.00', '900.00', 200, '2022-03-31 04:38:19', '2022-04-01 18:43:13', 1),
(11, 'Rick Astley\'s Mikrofon', 'This Mikrofon never gonna gives you up', 252, '69420.00', '69421.00', 24, '2022-03-23 07:57:08', '2022-03-23 07:57:08', 1);

-- --------------------------------------------------------

--
-- Table structure for table `products_types`
--

CREATE TABLE `products_types` (
  `id` int(10) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `type` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `products_types`
--

INSERT INTO `products_types` (`id`, `parent_id`, `type`, `created_at`, `updated_at`) VALUES
(1, 0, 'Hardware', '2022-02-07 15:22:54', '2022-03-12 19:32:20'),
(2, 0, 'Monitore', '2022-03-12 19:39:16', '2022-03-12 19:40:58'),
(3, 0, 'Peripherie', '2022-03-12 19:49:04', '2022-03-12 19:49:04'),
(4, 0, 'Netzwerktechnik', '2022-03-12 19:53:02', '2022-03-12 19:53:02'),
(5, 0, 'Audio', '2022-03-12 19:56:55', '2022-03-12 19:56:55'),
(50, 1, 'Arbeitsspeicher', '2022-03-11 11:34:41', '2022-03-12 19:39:38'),
(51, 1, 'CPUs', '2022-03-11 11:34:57', '2022-03-12 19:39:43'),
(52, 1, 'CPU Kühler', '2022-03-11 11:43:53', '2022-03-12 19:39:48'),
(53, 1, 'Festplatten & SSDs', '2022-03-11 11:43:53', '2022-03-12 19:39:54'),
(54, 1, 'Grafikkarten', '2022-02-10 05:36:35', '2022-03-12 19:39:59'),
(55, 1, 'Laufwerke', '2022-03-11 11:43:53', '2022-03-12 19:41:10'),
(56, 1, 'Mainboards', '2022-03-11 11:43:53', '2022-03-12 19:41:17'),
(57, 1, 'Netzteile', '2022-03-11 11:43:53', '2022-03-12 19:41:24'),
(58, 1, 'Gehäuse', '2022-03-11 11:43:53', '2022-03-12 19:41:45'),
(59, 1, 'Kühlung', '2022-03-11 11:43:53', '2022-03-12 19:41:54'),
(60, 1, 'Serverschrank', '2022-03-11 11:43:53', '2022-03-12 19:42:10'),
(100, 2, '24 Zoll', '2022-03-11 11:43:53', '2022-03-12 19:44:03'),
(101, 2, '27 Zoll', '2022-03-11 11:43:53', '2022-03-12 19:49:50'),
(102, 2, '32 Zoll', '2022-03-11 11:43:53', '2022-03-12 19:49:57'),
(103, 2, '34 Zoll', '2022-03-11 11:43:53', '2022-03-12 19:49:57'),
(104, 2, '49 Zoll', '2022-03-11 11:43:53', '2022-03-12 19:49:57'),
(105, 2, 'Monitorzubehör', '2022-03-11 11:43:53', '2022-03-13 18:59:58'),
(106, 2, 'High-End', '2022-03-13 19:00:09', '2022-03-13 19:00:09'),
(150, 3, 'Office-Mäuse', '2022-03-11 11:43:53', '2022-03-12 19:52:34'),
(151, 3, 'Gaming-Mäuse', '2022-03-11 11:43:53', '2022-03-12 19:52:26'),
(152, 3, 'Mauspads', '2022-03-11 11:43:53', '2022-03-12 19:51:34'),
(153, 3, 'Office-Tastaturen', '2022-03-11 11:43:53', '2022-03-12 19:51:46'),
(154, 3, 'Gaming-Tastaturen', '2022-03-11 11:43:53', '2022-03-12 19:51:53'),
(155, 3, 'Joystick', '2022-03-11 11:43:53', '2022-03-12 19:52:03'),
(156, 3, 'Lenkräder', '2022-03-11 11:43:53', '2022-03-12 19:52:12'),
(157, 3, 'Controller', '2022-03-11 11:43:53', '2022-03-12 19:52:47'),
(158, 3, 'USB-Hubs', '2022-03-11 11:43:53', '2022-03-12 19:55:37'),
(200, 4, 'Access-Points', '2022-03-11 11:43:53', '2022-03-12 19:53:20'),
(201, 4, 'Bluetooth Adapter', '2022-03-11 11:43:53', '2022-03-12 19:53:29'),
(202, 4, 'Netzwerkswitches', '2022-03-11 11:43:53', '2022-03-12 19:53:47'),
(203, 4, 'Router', '2022-03-11 11:43:53', '2022-03-12 19:54:01'),
(204, 4, 'WLAN Repeater', '2022-03-11 11:43:53', '2022-03-12 19:54:12'),
(250, 5, 'Headsets', '2022-03-11 11:43:53', '2022-03-12 19:55:49'),
(251, 5, 'Kopfhörer', '2022-03-11 11:43:53', '2022-03-12 19:55:59'),
(252, 5, 'Mikrofone', '2022-03-11 11:43:53', '2022-03-12 19:56:06'),
(253, 5, 'Lautsprecher', '2022-03-11 11:43:53', '2022-03-12 19:56:15'),
(254, 5, 'Soundbar', '2022-03-11 11:43:53', '2022-03-12 19:56:24'),
(255, 5, 'Soundkarten', '2022-03-11 11:43:53', '2022-03-12 19:56:29'),
(99998, 0, 'To be Removed', '2022-03-12 20:49:43', '2022-03-12 20:50:11'),
(100000, 99998, 'test', '2022-03-23 20:03:10', '2022-03-23 21:13:39');

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

CREATE TABLE `product_images` (
  `id` int(10) NOT NULL,
  `img` varchar(255) NOT NULL,
  `product_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product_images`
--

INSERT INTO `product_images` (`id`, `img`, `product_id`) VALUES
(1, 'RTX3080_TI.jpg', 2),
(2, 'RTX3070_TI.jpg', 2),
(3, 'test.jpg', 1),
(4, 'RTX3070_TI.jpg', 3),
(5, 'RTX3080_TI.jpg', 6),
(6, 'RTX3070.jpg', 4),
(7, 'RTX3070.jpg', 4),
(8, 'test.jpg', 7),
(9, 'High-end-monitor.jpg', 8),
(10, 'CapOwhpQaQn8MquiO5nNNe.webp', 8),
(11, 'test.jpg', 9),
(12, 'RTX3070_TI.jpg', 10),
(13, 'CapOwhpQaQn8MquiO5nNNe.webp', 11);

-- --------------------------------------------------------

--
-- Table structure for table `product_list`
--

CREATE TABLE `product_list` (
  `id` int(10) NOT NULL,
  `list_id` int(10) NOT NULL,
  `product_id` int(10) NOT NULL,
  `quantity` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product_list`
--

INSERT INTO `product_list` (`id`, `list_id`, `product_id`, `quantity`) VALUES
(1, 1, 1, 10),
(2, 1, 2, 200),
(40, 1, 3, 100),
(46, 1, 5, 6),
(47, 4, 2, 3),
(50, 6, 2, 199),
(55, 6, 3, 2),
(56, 6, 4, 2),
(57, 1, 8, 5),
(58, 6, 11, 1);

-- --------------------------------------------------------

--
-- Table structure for table `securitytokens`
--

CREATE TABLE `securitytokens` (
  `id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `identifier` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `securitytoken` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `passwort` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `gender` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `vorname` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `nachname` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `streetHouseNr` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `passwortcode` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `passwortcode_time` timestamp NULL DEFAULT NULL,
  `permission_group` int(10) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `passwort`, `gender`, `vorname`, `nachname`, `streetHouseNr`, `city`, `created_at`, `updated_at`, `passwortcode`, `passwortcode_time`, `permission_group`) VALUES
(1, 'test@test.com', '$2y$10$SfhYIDtn.iOuCW7zfoFLuuZHX6lja4lF4XA4JqNmpiH/.P3zB8JCa', '', 'Vorname', 'Nachname', '', '', '2022-02-04 07:57:26', '2022-03-12 22:23:31', NULL, NULL, 1),
(2, 'ich@paul-vassen.de', '$2y$10$AjGihIboyCYY/gnDq7J08.spp4N6Du.wog2anlhRsFALSZj9DPrPq', '', 'Paul', 'Vaßen', '', '', '2022-02-04 15:34:37', '2022-03-21 11:08:26', NULL, NULL, 2),
(3, 'jan@schniebs.com', '$2y$10$xlYaMlJc0JLTBAhHLrgC5.Y1ECi5y8IbxBY74W4nzCmuNLio.NwFO', '', 'Jan', 'Schniebs', '', '', '2022-02-23 07:14:00', '2022-03-21 11:06:26', NULL, NULL, 2),
(5, 'g.einkaufstute@edeka.de', '$2y$10$unifQHy15eQr./VQXD1lj.Zouy/HURsgZYUtbUNy0VDA/mtrqrf8i', '', 'Gerhard', 'Einkaufstüte', '', '', '2022-02-23 09:36:25', '2022-02-23 09:36:25', NULL, NULL, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kunden_id` (`kunden_id`);

--
-- Indexes for table `permission_group`
--
ALTER TABLE `permission_group`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_type_id` (`product_type_id`);

--
-- Indexes for table `products_types`
--
ALTER TABLE `products_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `product_list`
--
ALTER TABLE `product_list`
  ADD PRIMARY KEY (`id`),
  ADD KEY `list_id` (`list_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `securitytokens`
--
ALTER TABLE `securitytokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `permission_group` (`permission_group`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `permission_group`
--
ALTER TABLE `permission_group`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `products_types`
--
ALTER TABLE `products_types`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100001;

--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `product_list`
--
ALTER TABLE `product_list`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `securitytokens`
--
ALTER TABLE `securitytokens`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`kunden_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`product_type_id`) REFERENCES `products_types` (`id`);

--
-- Constraints for table `product_images`
--
ALTER TABLE `product_images`
  ADD CONSTRAINT `product_images_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `product_list`
--
ALTER TABLE `product_list`
  ADD CONSTRAINT `product_list_ibfk_1` FOREIGN KEY (`list_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `product_list_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `securitytokens`
--
ALTER TABLE `securitytokens`
  ADD CONSTRAINT `securitytokens_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;