-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 10, 2022 at 12:25 PM
-- Server version: 10.5.12-MariaDB-0+deb11u1
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
  `createProduct` tinyint(1) NOT NULL DEFAULT 0,
  `modifyProduct` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `permission_group`
--

INSERT INTO `permission_group` (`id`, `name`, `showUser`, `modifyUser`, `deleteUser`, `createProduct`, `modifyProduct`) VALUES
(1, 'default', 0, 0, 0, 0, 0),
(2, 'admin', 1, 1, 1, 1, 1),
(3, 'employee', 1, 0, 0, 1, 1);

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
(1, 'Test', 'Test Description', 1, '10.00', '0.00', 20, '2022-02-07 15:24:08', '2022-03-08 18:32:41', 0),
(2, 'RTX 3080 TI', 'Ist der Hammer und nicht überteuert', 2, '1500.00', '900.00', 200, '2022-02-10 05:38:03', '2022-03-08 18:31:58', 1),
(3, 'RTX 3070 TI', 'Ist der Hammer', 2, '1500.00', '900.00', 200, '2022-02-10 05:38:19', '2022-03-08 18:32:03', 1),
(4, 'RTX 3070', 'Ist der Hammer', 2, '1500.00', '900.00', 19, '2022-02-10 05:38:39', '2022-03-08 18:32:07', 1),
(5, 'Uhr', 'Ist der Hammer', 1, '120.00', '140.00', 6, '2022-02-10 05:39:19', '2022-03-08 18:32:11', 1),
(6, 'RTX 3060', 'Ist der Hammer und nicht überteuert', 2, '1500.00', '900.00', 5, '2022-03-06 05:38:03', '2022-03-08 18:32:14', 1),
(7, 'Test', 'Test Description', 1, '10.00', '0.00', 0, '2022-02-07 15:24:08', '2022-03-08 19:21:02', 1);

-- --------------------------------------------------------

--
-- Table structure for table `products_types`
--

CREATE TABLE `products_types` (
  `id` int(10) NOT NULL,
  `type` varchar(255) NOT NULL,
  `img` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `products_types`
--

INSERT INTO `products_types` (`id`, `type`, `img`, `created_at`, `updated_at`) VALUES
(1, 'Test', '', '2022-02-07 15:22:54', '2022-02-07 15:22:54'),
(2, 'Grafikkarte', '', '2022-02-10 05:36:35', '2022-02-10 05:36:35');

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
(8, 'test.jpg', 7);

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
(47, 4, 2, 1),
(48, 6, 3, 200),
(50, 6, 2, 200),
(51, 6, 4, 19),
(52, 6, 5, 6),
(53, 6, 6, 5);

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

--
-- Dumping data for table `securitytokens`
--

INSERT INTO `securitytokens` (`id`, `user_id`, `identifier`, `securitytoken`, `created_at`) VALUES
(5, 3, 'cabdab583aa4be27614eba1ea75329a2', 'df21c3e0cb55927075d1ab68f1f83db310fa6ab4', '2022-03-09 08:09:23'),
(6, 1, '04fef56f661f51f6ce00398b6cb8f085', 'e80a28ff6d8123c71ee97a21bcc25ab2b0aeecb2', '2022-03-09 08:09:46'),
(7, 1, '172d003be4f62a4ec0d42eedede7c865', 'f254fae7749d182b43178ed674e3ff6c203e3710', '2022-03-09 08:10:11'),
(8, 1, '09a631c1ac41e600a5dec89f913633db', '06801b5b4970a7faa017a019f82e97f1f7f21002', '2022-03-09 09:35:40'),
(9, 3, 'de2e79e9c828fd854988ca3285a243b2', '8d3b07c5bac26a26e5cbf4454b2069bd749b643d', '2022-03-09 10:05:04'),
(10, 17, '0ed0dae9ef2190d5b60f71b165745f09', 'b40e28d639410ed1a42ea226d1369067ba200c21', '2022-03-09 11:58:17'),
(13, 3, 'bc8d2f5bc72a32e357f020ff0acf5ac8', '8323a7394669355181464ce8dc2ebadfcc168b07', '2022-03-09 12:06:34'),
(15, 1, '69767b877f28ffa0cde719133b157d43', 'd1e25147466b90b9954d726cd3da1d0110575fac', '2022-03-09 14:18:19'),
(16, 3, '4346f307eee5a5b63672ef37d52c5030', '1945fe923ddd57393000b20ff2704f34a4178696', '2022-03-09 15:30:16'),
(18, 1, '321e4164bc7b42a3949672dae3c441c7', '81b9ce38287b6f85c7f4119489bd2c99b13a1da1', '2022-03-09 17:35:42'),
(19, 1, '001edcb807f5931ade3e5c9753d5f399', '486a1ffb8684647b95eb2e5b5fd965ebc5731b29', '2022-03-09 17:59:00'),
(20, 1, '92d9599eae3a9661256347cfd3f7a6de', '25021352fa9afda640029bab912b8e5f6b9bf7de', '2022-03-09 20:02:37'),
(21, 1, 'e3ed3590159de4fa2b6744ee80f38873', 'c3c1954c351390e71d3d9ef7bfc1d06c7a7492a0', '2022-03-09 20:45:18'),
(22, 1, '84e3c987fec10155a4b9c5c6d3c75ae6', '662ea61ad94957fa45bc2a318b661fbf1777dcec', '2022-03-10 08:00:32'),
(23, 2, '4e228bb0c07b999a2ac56f32d2900a57', '8a8c728baf605f821e7bb029f86fd51649afd87e', '2022-03-10 08:03:29'),
(24, 3, '4adc7a452cd77f30eb5203f46f4e6b24', 'ee2c5af6ad5d303cb893fdc4c9cf62428b7a8165', '2022-03-10 09:49:10'),
(25, 20, 'e7347c8a97ec60625841dddcfda2db6e', 'ef5dbff1e312e4209c97ead57c5b75d0763a5ddc', '2022-03-10 11:47:22'),
(26, 3, 'eed80a99855990ca31a64198de350715', 'eae9b1d9da4f9558310dbe89b46e77d7f0012a79', '2022-03-10 11:49:33'),
(27, 20, '59d27a0e3311dcaff21f4a0d422930e6', '182112ce2d2ffb8936cc662d28b54c46bca22732', '2022-03-10 12:08:18'),
(28, 20, '6a6d0c8f7ae3ea5fe8251754963a7d74', '1a33f0a082890dd44b419b11bd08bc500c6d396f', '2022-03-10 12:08:46');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `passwort` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `vorname` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `nachname` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `passwortcode` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `passwortcode_time` timestamp NULL DEFAULT NULL,
  `permission_group` int(10) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `passwort`, `vorname`, `nachname`, `created_at`, `updated_at`, `passwortcode`, `passwortcode_time`, `permission_group`) VALUES
(1, 'test@test.com', '$2y$10$SfhYIDtn.iOuCW7zfoFLuuZHX6lja4lF4XA4JqNmpiH/.P3zB8JCa', 'Vorname', 'Nachname', '2022-02-04 08:57:26', '2022-02-08 11:14:46', NULL, NULL, 1),
(2, 'ich@paul-vassen.de', '$2y$10$AjGihIboyCYY/gnDq7J08.spp4N6Du.wog2anlhRsFALSZj9DPrPq', 'Paul', 'Vaßen', '2022-02-04 15:34:37', '2022-03-10 07:04:28', NULL, NULL, 2),
(3, 'jan@schniebs.com', '$2y$10$xlYaMlJc0JLTBAhHLrgC5.Y1ECi5y8IbxBY74W4nzCmuNLio.NwFO', 'Jan', 'Schniebs', '2022-02-23 07:14:00', '2022-03-08 21:57:49', NULL, NULL, 2),
(5, 'g.einkaufstute@edeka.de', '$2y$10$unifQHy15eQr./VQXD1lj.Zouy/HURsgZYUtbUNy0VDA/mtrqrf8i', 'Gerhard', 'Einkaufstüte', '2022-02-23 09:36:25', '2022-02-23 09:36:25', NULL, NULL, 1),
(17, 'jan@jan.com', '$2y$10$FkgirZYJH4wb.ocNUDqHp.A2LwLHjR5X.Zjo68GT2N1QqTP2aPAEm', 'Jan', 'Seitz', '2022-03-09 10:56:33', '2022-03-09 10:56:33', NULL, NULL, 1),
(20, 'max@musterman.de', '$2y$10$EeWHkxh2yAHs5UfPyXF3v.IndEHxtDfZ/e8srZzTd/6zoV9rIQOom', 'test1', 'sdfsdfdsf1', '2022-03-10 08:24:37', '2022-03-10 11:08:38', NULL, NULL, 1);

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
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `permission_group`
--
ALTER TABLE `permission_group`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `products_types`
--
ALTER TABLE `products_types`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `product_list`
--
ALTER TABLE `product_list`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `securitytokens`
--
ALTER TABLE `securitytokens`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

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
