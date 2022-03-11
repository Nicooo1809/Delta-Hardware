-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 11, 2022 at 12:45 PM
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
-- Table structure for table `menu_items`
--

CREATE TABLE `menu_items` (
  `item_id` int(11) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `item_text` varchar(255) NOT NULL,
  `item_link` varchar(255) NOT NULL,
  `item_target` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `menu_items`
--

INSERT INTO `menu_items` (`item_id`, `parent_id`, `item_text`, `item_link`, `item_target`) VALUES
(1, NULL, 'Home', '/', NULL),
(2, NULL, 'Blog', 'blog/', NULL),
(3, NULL, 'Reviews', 'reviews/', NULL),
(4, NULL, 'Shop', 'shop/', '_BLANK'),
(5, 2, 'How To', 'blog/how/', NULL),
(6, 2, 'Technology', 'blog/tech/', NULL),
(7, 2, 'Hacks', 'blog/hacks/', NULL),
(8, 5, 'test', '/test', '/test1');

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
(7, 5, 0, NULL, 0, NULL),
(10, 25, 0, NULL, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `permission_group`
--

CREATE TABLE `permission_group` (
  `id` int(10) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `showUser` tinyint(1) NOT NULL DEFAULT 0,
  `modifyUser` tinyint(1) NOT NULL DEFAULT 0,
  `modifyUserPerms` tinyint(1) NOT NULL DEFAULT 0,
  `deleteUser` tinyint(1) NOT NULL DEFAULT 0,
  `createProduct` tinyint(1) NOT NULL DEFAULT 0,
  `modifyProduct` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `permission_group`
--

INSERT INTO `permission_group` (`id`, `name`, `showUser`, `modifyUser`, `modifyUserPerms`, `deleteUser`, `createProduct`, `modifyProduct`) VALUES
(1, 'default', 0, 0, 0, 0, 0, 0),
(2, 'admin', 1, 1, 1, 1, 1, 1),
(3, 'employee', 1, 0, 0, 0, 1, 1);

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
(2, 'Grafikkarte', '', '2022-02-10 05:36:35', '2022-02-10 05:36:35'),
(3, 'Arbeitsspeicher', '', '2022-03-11 11:34:41', '2022-03-11 11:34:41'),
(4, 'CPUs', '', '2022-03-11 11:34:57', '2022-03-11 11:34:57'),
(5, 'CPUKuehler', '', '2022-03-11 11:43:53', '2022-03-11 11:43:53'),
(6, 'FestplattenundSSDs', '', '2022-03-11 11:43:53', '2022-03-11 11:43:53'),
(7, 'Laufwerke', '', '2022-03-11 11:43:53', '2022-03-11 11:43:53'),
(8, 'Mainboards', '', '2022-03-11 11:43:53', '2022-03-11 11:43:53'),
(9, 'Netzteile', '', '2022-03-11 11:43:53', '2022-03-11 11:43:53'),
(10, 'Gehauuse', '', '2022-03-11 11:43:53', '2022-03-11 11:43:53'),
(11, 'Kuehlung', '', '2022-03-11 11:43:53', '2022-03-11 11:43:53'),
(12, 'Serverschrank', '', '2022-03-11 11:43:53', '2022-03-11 11:43:53'),
(13, '24Zoll', '', '2022-03-11 11:43:53', '2022-03-11 11:43:53'),
(14, '27Zoll', '', '2022-03-11 11:43:53', '2022-03-11 11:43:53'),
(15, '32Zoll', '', '2022-03-11 11:43:53', '2022-03-11 11:43:53'),
(16, '34Zoll', '', '2022-03-11 11:43:53', '2022-03-11 11:43:53'),
(17, '49Zoll', '', '2022-03-11 11:43:53', '2022-03-11 11:43:53'),
(18, 'Monitorzubehoer', '', '2022-03-11 11:43:53', '2022-03-11 11:43:53'),
(19, 'Office-Maeuse', '', '2022-03-11 11:43:53', '2022-03-11 11:43:53'),
(20, 'Gaming-Maeuse', '', '2022-03-11 11:43:53', '2022-03-11 11:43:53'),
(21, 'Mauspads', '', '2022-03-11 11:43:53', '2022-03-11 11:43:53'),
(22, 'Office-Tastaturen', '', '2022-03-11 11:43:53', '2022-03-11 11:43:53'),
(23, 'Gaming-Tastaturen', '', '2022-03-11 11:43:53', '2022-03-11 11:43:53'),
(24, 'Joystick', '', '2022-03-11 11:43:53', '2022-03-11 11:43:53'),
(25, 'Lenkraeder', '', '2022-03-11 11:43:53', '2022-03-11 11:43:53'),
(26, 'Controller', '', '2022-03-11 11:43:53', '2022-03-11 11:43:53'),
(27, 'Access-Points', '', '2022-03-11 11:43:53', '2022-03-11 11:43:53'),
(28, 'BluetoothAdapter', '', '2022-03-11 11:43:53', '2022-03-11 11:43:53'),
(29, 'Netzwerkswitches', '', '2022-03-11 11:43:53', '2022-03-11 11:43:53'),
(30, 'Router', '', '2022-03-11 11:43:53', '2022-03-11 11:43:53'),
(31, 'WLANRepeater', '', '2022-03-11 11:43:53', '2022-03-11 11:43:53'),
(32, 'USB-Hubs', '', '2022-03-11 11:43:53', '2022-03-11 11:43:53'),
(33, 'WLANRepeater', '', '2022-03-11 11:43:53', '2022-03-11 11:43:53'),
(34, 'Headsets', '', '2022-03-11 11:43:53', '2022-03-11 11:43:53'),
(35, 'Kopfhoerer', '', '2022-03-11 11:43:53', '2022-03-11 11:43:53'),
(36, 'Mikrofone', '', '2022-03-11 11:43:53', '2022-03-11 11:43:53'),
(37, 'Lautsprecher', '', '2022-03-11 11:43:53', '2022-03-11 11:43:53'),
(38, 'Soundbar', '', '2022-03-11 11:43:53', '2022-03-11 11:43:53'),
(39, 'Soundkarten', '', '2022-03-11 11:43:53', '2022-03-11 11:43:53');

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
(13, 3, 'bc8d2f5bc72a32e357f020ff0acf5ac8', '8323a7394669355181464ce8dc2ebadfcc168b07', '2022-03-09 12:06:34'),
(15, 1, '69767b877f28ffa0cde719133b157d43', 'd1e25147466b90b9954d726cd3da1d0110575fac', '2022-03-09 14:18:19'),
(16, 3, '4346f307eee5a5b63672ef37d52c5030', '64b4dfdceade484bc4b4e17fe22ebfd8f48a41f5', '2022-03-09 15:30:16'),
(18, 1, '321e4164bc7b42a3949672dae3c441c7', '81b9ce38287b6f85c7f4119489bd2c99b13a1da1', '2022-03-09 17:35:42'),
(19, 1, '001edcb807f5931ade3e5c9753d5f399', '486a1ffb8684647b95eb2e5b5fd965ebc5731b29', '2022-03-09 17:59:00'),
(20, 1, '92d9599eae3a9661256347cfd3f7a6de', '166f65c343654463b920ea7e20e256b9bf046ee1', '2022-03-09 20:02:37'),
(21, 1, 'e3ed3590159de4fa2b6744ee80f38873', '01c2c9fbf122f978870ac9e3e73c36fe2557aff7', '2022-03-09 20:45:18'),
(22, 1, '84e3c987fec10155a4b9c5c6d3c75ae6', '662ea61ad94957fa45bc2a318b661fbf1777dcec', '2022-03-10 08:00:32'),
(23, 2, '4e228bb0c07b999a2ac56f32d2900a57', '8a8c728baf605f821e7bb029f86fd51649afd87e', '2022-03-10 08:03:29'),
(24, 3, '4adc7a452cd77f30eb5203f46f4e6b24', 'ee2c5af6ad5d303cb893fdc4c9cf62428b7a8165', '2022-03-10 09:49:10'),
(26, 3, 'eed80a99855990ca31a64198de350715', 'eae9b1d9da4f9558310dbe89b46e77d7f0012a79', '2022-03-10 11:49:33'),
(29, 2, '76b6c9dd22f73444fd5dc5203623171c', 'af69bd6681a968e56ceca573ac76ae1840b95c1d', '2022-03-10 12:25:29'),
(30, 3, 'bc7417357e75b5f68b26a71ec76d31f8', 'df15fdfc39a01a4bf7daa5f73579926aac4119e4', '2022-03-10 12:38:38'),
(31, 1, 'd42ee9e3f84e80a3d624d1078293b01e', '62bde6e421b6592a169e2860b84b33f3e5f6ca69', '2022-03-10 12:38:56'),
(32, 3, '7abdb05807fd2c53ff0ce28b8a6419c1', 'dd12220ae6f0acfeee3ef091a450748f350c4d9a', '2022-03-10 12:39:04'),
(35, 3, '8cde337adfb9eba4b5d14513f38f8383', 'e1305254969cece3ba4aa3eaff5f6e7753a8c9e9', '2022-03-10 12:49:26'),
(39, 3, '2bc76eb26aaec4b14f8c88ebd9b8c0c0', 'a2d7024de13ff19d7251d9088942cf96e27c61d4', '2022-03-10 13:18:45'),
(40, 3, '8d46486373aea3ef4f0ee4b433064ac9', 'ada179777e938aab3cb03e4bc3e423edf2018ec1', '2022-03-10 13:19:13'),
(42, 3, 'e0ddf6638310229c963eed4d62ee8757', '19bdeedefcdc2bfe80e94b81b6987403a9d23952', '2022-03-10 13:19:38'),
(44, 3, '6f612b22fc9fa9665d6cd282579c25cd', 'deffe5327b9e168b1db17027e8307e3e524fb9b6', '2022-03-10 13:20:05'),
(46, 3, '225b1921b03b77979dd6c33e34db14d1', '1180ba6ca7deda77854e73b94522288ff5ede93b', '2022-03-10 13:30:22'),
(47, 3, 'd99a85346c735d34168e0dbc9da5b498', '2790f09836f3c415265f985c35f0a81d97771f46', '2022-03-10 13:33:41'),
(48, 3, '35b761ece6c975c9f6fb73ecae3aba2c', '957e59f83c795ca3a082b5eb948de1a84a1a52dd', '2022-03-10 13:38:30'),
(49, 3, '8c903088befb79cae987019d5cebe60f', '2251dbf536eb14894bc32142d78571060a3cf16f', '2022-03-10 14:28:52'),
(50, 2, 'a5794a0611682ef13c1794c0c2319e6b', '1c30e33533dda155cf7433b94e38fc20ea7f0ece', '2022-03-10 17:27:45'),
(51, 1, '8b5a64dcf7b3a30bd0168401a6e37620', 'd9f07edc6f5fea253665a895990b65a54ae9d4c9', '2022-03-10 21:16:05'),
(52, 3, 'be752f6d4105401debb15eaa44c0d6b8', '3682b3f1a4d60cad36dce828a00863df98403b3a', '2022-03-11 07:52:05'),
(53, 1, '60540c7523f9b451b9bc3af0445ee34f', '1cc3c6c44ed7ee40695f9f98dcf1ff99154b6843', '2022-03-11 08:07:59');

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
(1, 'test@test.com', '$2y$10$SfhYIDtn.iOuCW7zfoFLuuZHX6lja4lF4XA4JqNmpiH/.P3zB8JCa', 'Vorname', 'Nachname', '2022-02-04 08:57:26', '2022-03-11 08:05:40', NULL, NULL, 3),
(2, 'ich@paul-vassen.de', '$2y$10$AjGihIboyCYY/gnDq7J08.spp4N6Du.wog2anlhRsFALSZj9DPrPq', 'Paul', 'Vaßen', '2022-02-04 15:34:37', '2022-03-10 07:04:28', NULL, NULL, 2),
(3, 'jan@schniebs.com', '$2y$10$xlYaMlJc0JLTBAhHLrgC5.Y1ECi5y8IbxBY74W4nzCmuNLio.NwFO', 'Jan', 'Schniebs', '2022-02-23 07:14:00', '2022-03-08 21:57:49', NULL, NULL, 2),
(5, 'g.einkaufstute@edeka.de', '$2y$10$unifQHy15eQr./VQXD1lj.Zouy/HURsgZYUtbUNy0VDA/mtrqrf8i', 'Gerhard', 'Einkaufstüte', '2022-02-23 09:36:25', '2022-02-23 09:36:25', NULL, NULL, 1),
(25, 'max@musterman.de', '$2y$10$FWcz3DcRpbAPJgs2UBbp5.1ECDidXnFYxYif63d9XuCyhyBqnMZoe', 'Maximilian', 'Musterman', '2022-03-10 12:32:01', '2022-03-10 12:32:01', NULL, NULL, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `menu_items`
--
ALTER TABLE `menu_items`
  ADD PRIMARY KEY (`item_id`);

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
-- AUTO_INCREMENT for table `menu_items`
--
ALTER TABLE `menu_items`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

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
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

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
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

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
