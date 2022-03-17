-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 17, 2022 at 02:29 PM
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
  `deleteUser` tinyint(1) NOT NULL DEFAULT 0,
  `showUserPerms` tinyint(1) NOT NULL DEFAULT 0,
  `modifyUserPerms` tinyint(1) NOT NULL DEFAULT 0,
  `createProduct` tinyint(1) NOT NULL DEFAULT 0,
  `modifyProduct` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `permission_group`
--

INSERT INTO `permission_group` (`id`, `name`, `showUser`, `modifyUser`, `deleteUser`, `showUserPerms`, `modifyUserPerms`, `createProduct`, `modifyProduct`) VALUES
(1, 'default', 0, 0, 0, 0, 0, 0, 0),
(2, 'admin', 1, 1, 1, 1, 1, 1, 1),
(3, 'employee', 1, 0, 0, 0, 0, 1, 1);

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
(1, 'Test', 'Test Description', 99999, '10.00', '0.00', 20, '2022-02-07 15:24:08', '2022-03-12 19:42:29', 0),
(2, 'RTX 3080 TI', 'Ist der Hammer und nicht überteuert', 54, '1500.00', '900.00', 200, '2022-02-10 05:38:03', '2022-03-12 19:42:41', 1),
(3, 'RTX 3070 TI', 'Ist der Hammer', 54, '1500.00', '900.00', 200, '2022-02-10 05:38:19', '2022-03-12 19:43:13', 1),
(4, 'RTX 3070', 'Ist der Hammer', 54, '1500.00', '900.00', 19, '2022-02-10 05:38:39', '2022-03-12 19:43:13', 1),
(5, 'Uhr', 'Ist der Hammer', 99999, '120.00', '140.00', 6, '2022-02-10 05:39:19', '2022-03-12 19:43:13', 1),
(6, 'RTX 3060', 'Ist der Hammer und nicht überteuert', 54, '1500.00', '900.00', 5, '2022-03-06 05:38:03', '2022-03-12 19:43:13', 1),
(7, 'Test', 'Test Description', 99999, '10.00', '0.00', 0, '2022-02-07 15:24:08', '2022-03-12 19:43:13', 1),
(8, 'Classic Vintage Monitor', 'Best Device ever.', 106, '1099.99', '1099.99', 5, '2022-03-13 19:03:15', '2022-03-13 19:03:15', 1);

-- --------------------------------------------------------

--
-- Table structure for table `products_types`
--

CREATE TABLE `products_types` (
  `id` int(10) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `type` varchar(255) NOT NULL,
  `img` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `products_types`
--

INSERT INTO `products_types` (`id`, `parent_id`, `type`, `img`, `created_at`, `updated_at`) VALUES
(1, 0, 'Hardware', '', '2022-02-07 15:22:54', '2022-03-12 19:32:20'),
(2, 0, 'Monitore', '', '2022-03-12 19:39:16', '2022-03-12 19:40:58'),
(3, 0, 'Peripherie', '', '2022-03-12 19:49:04', '2022-03-12 19:49:04'),
(4, 0, 'Netzwerktechnik', '', '2022-03-12 19:53:02', '2022-03-12 19:53:02'),
(5, 0, 'Audio', '', '2022-03-12 19:56:55', '2022-03-12 19:56:55'),
(50, 1, 'Arbeitsspeicher', '', '2022-03-11 11:34:41', '2022-03-12 19:39:38'),
(51, 1, 'CPUs', '', '2022-03-11 11:34:57', '2022-03-12 19:39:43'),
(52, 1, 'CPU Kühler', '', '2022-03-11 11:43:53', '2022-03-12 19:39:48'),
(53, 1, 'Festplatten & SSDs', '', '2022-03-11 11:43:53', '2022-03-12 19:39:54'),
(54, 1, 'Grafikkarten', '', '2022-02-10 05:36:35', '2022-03-12 19:39:59'),
(55, 1, 'Laufwerke', '', '2022-03-11 11:43:53', '2022-03-12 19:41:10'),
(56, 1, 'Mainboards', '', '2022-03-11 11:43:53', '2022-03-12 19:41:17'),
(57, 1, 'Netzteile', '', '2022-03-11 11:43:53', '2022-03-12 19:41:24'),
(58, 1, 'Gehäuse', '', '2022-03-11 11:43:53', '2022-03-12 19:41:45'),
(59, 1, 'Kühlung', '', '2022-03-11 11:43:53', '2022-03-12 19:41:54'),
(60, 1, 'Serverschrank', '', '2022-03-11 11:43:53', '2022-03-12 19:42:10'),
(100, 2, '24 Zoll', '', '2022-03-11 11:43:53', '2022-03-12 19:44:03'),
(101, 2, '27 Zoll', '', '2022-03-11 11:43:53', '2022-03-12 19:49:50'),
(102, 2, '32 Zoll', '', '2022-03-11 11:43:53', '2022-03-12 19:49:57'),
(103, 2, '34 Zoll', '', '2022-03-11 11:43:53', '2022-03-12 19:49:57'),
(104, 2, '49 Zoll', '', '2022-03-11 11:43:53', '2022-03-12 19:49:57'),
(105, 2, 'Monitorzubehör', '', '2022-03-11 11:43:53', '2022-03-13 18:59:58'),
(106, 2, 'High-End', '', '2022-03-13 19:00:09', '2022-03-13 19:00:09'),
(150, 3, 'Office-Mäuse', '', '2022-03-11 11:43:53', '2022-03-12 19:52:34'),
(151, 3, 'Gaming-Mäuse', '', '2022-03-11 11:43:53', '2022-03-12 19:52:26'),
(152, 3, 'Mauspads', '', '2022-03-11 11:43:53', '2022-03-12 19:51:34'),
(153, 3, 'Office-Tastaturen', '', '2022-03-11 11:43:53', '2022-03-12 19:51:46'),
(154, 3, 'Gaming-Tastaturen', '', '2022-03-11 11:43:53', '2022-03-12 19:51:53'),
(155, 3, 'Joystick', '', '2022-03-11 11:43:53', '2022-03-12 19:52:03'),
(156, 3, 'Lenkräder', '', '2022-03-11 11:43:53', '2022-03-12 19:52:12'),
(157, 3, 'Controller', '', '2022-03-11 11:43:53', '2022-03-12 19:52:47'),
(158, 3, 'USB-Hubs', '', '2022-03-11 11:43:53', '2022-03-12 19:55:37'),
(200, 4, 'Access-Points', '', '2022-03-11 11:43:53', '2022-03-12 19:53:20'),
(201, 4, 'Bluetooth Adapter', '', '2022-03-11 11:43:53', '2022-03-12 19:53:29'),
(202, 4, 'Netzwerkswitches', '', '2022-03-11 11:43:53', '2022-03-12 19:53:47'),
(203, 4, 'Router', '', '2022-03-11 11:43:53', '2022-03-12 19:54:01'),
(204, 4, 'WLAN Repeater', '', '2022-03-11 11:43:53', '2022-03-12 19:54:12'),
(250, 5, 'Headsets', '', '2022-03-11 11:43:53', '2022-03-12 19:55:49'),
(251, 5, 'Kopfhörer', '', '2022-03-11 11:43:53', '2022-03-12 19:55:59'),
(252, 5, 'Mikrofone', '', '2022-03-11 11:43:53', '2022-03-12 19:56:06'),
(253, 5, 'Lautsprecher', '', '2022-03-11 11:43:53', '2022-03-12 19:56:15'),
(254, 5, 'Soundbar', '', '2022-03-11 11:43:53', '2022-03-12 19:56:24'),
(255, 5, 'Soundkarten', '', '2022-03-11 11:43:53', '2022-03-12 19:56:29'),
(99998, 0, 'To be Removed', '', '2022-03-12 20:49:43', '2022-03-12 20:50:11'),
(99999, 99998, 'Test', '', '2022-03-12 19:37:57', '2022-03-12 20:49:51');

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
(9, 'High-end-monitor.jpg', 8);

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
(47, 4, 2, 2),
(50, 6, 2, 200),
(51, 6, 4, 19);

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
(8, 1, '09a631c1ac41e600a5dec89f913633db', 'bfe8e5ee11a546ca2725b40d573a563c38b165c2', '2022-03-09 09:35:40'),
(9, 3, 'de2e79e9c828fd854988ca3285a243b2', '8d3b07c5bac26a26e5cbf4454b2069bd749b643d', '2022-03-09 10:05:04'),
(13, 3, 'bc8d2f5bc72a32e357f020ff0acf5ac8', '8323a7394669355181464ce8dc2ebadfcc168b07', '2022-03-09 12:06:34'),
(15, 1, '69767b877f28ffa0cde719133b157d43', 'd1e25147466b90b9954d726cd3da1d0110575fac', '2022-03-09 14:18:19'),
(16, 3, '4346f307eee5a5b63672ef37d52c5030', '95bae45040fdafd0b2ae75e41bbcf602d05b09f2', '2022-03-09 15:30:16'),
(18, 1, '321e4164bc7b42a3949672dae3c441c7', '549c3bc5d2e854e7a295c8891339b820b011565a', '2022-03-09 17:35:42'),
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
(48, 3, '35b761ece6c975c9f6fb73ecae3aba2c', 'f7a7437ab0444e8a46d1f82327446731358cb1e2', '2022-03-10 13:38:30'),
(49, 3, '8c903088befb79cae987019d5cebe60f', '2251dbf536eb14894bc32142d78571060a3cf16f', '2022-03-10 14:28:52'),
(50, 2, 'a5794a0611682ef13c1794c0c2319e6b', 'a8432e61ca6fb8c17aa24435419ff5d555a57dbc', '2022-03-10 17:27:45'),
(51, 1, '8b5a64dcf7b3a30bd0168401a6e37620', 'e7347fb08089b53ed6c870010302426d964db410', '2022-03-10 21:16:05'),
(52, 3, 'be752f6d4105401debb15eaa44c0d6b8', '3682b3f1a4d60cad36dce828a00863df98403b3a', '2022-03-11 07:52:05'),
(53, 1, '60540c7523f9b451b9bc3af0445ee34f', '1cc3c6c44ed7ee40695f9f98dcf1ff99154b6843', '2022-03-11 08:07:59'),
(54, 3, 'd2213b93647317a9889d360c18472921', 'c1baba6c3671c7e539381ffaeefc19b55918cdf0', '2022-03-11 19:13:00'),
(55, 3, '1e66e4d104c9aabdb48e4bcc9cbe13ab', '5fbd65d1954b5b26e291a5e05fc0dd5613b72487', '2022-03-12 00:56:51'),
(56, 3, 'f9a49a11ca1597c44ce7afa87037642e', 'd2311f9783348135e77a104417a3f1607f21c33f', '2022-03-12 01:05:33'),
(57, 3, '2b527732847819205b88266df8f61bf4', 'c2cb96f041c7009d12ec781199251ad21df493d8', '2022-03-12 11:02:07'),
(58, 1, '2a03ad70ca6930f06c9b6e2662a536ab', 'cca2f5b5b689d9924408192e92c16ef809d0af66', '2022-03-12 21:56:51'),
(59, 3, '85ca5dbed29566ebb16e4a44d0aa2404', '33f0995a9256113b1d335bff7dcad3367d7c2b1b', '2022-03-12 21:57:23'),
(60, 3, '8c7b764bbaa66063436e3665f3bf3abb', '77336895c0deefbae7213e5addc564fed33aec89', '2022-03-13 00:06:08'),
(61, 25, '2ef05953fdc6d724e33a16c9b4c868d5', '02da9a9d0601be886fcbabbfc89726c3731fa2d0', '2022-03-13 00:22:30'),
(62, 1, '0a221e78a792f7ee2141b6c883390a2b', '39cd9ca50c435d4842dfed55122d4e3028f33607', '2022-03-13 00:23:40'),
(63, 3, '8562348382b4cafb8f433bd6868df3a9', '3ab519dd6c74cb159209bc79a7b3500f02ce1f51', '2022-03-13 00:23:45'),
(64, 25, '8da902e1bd0f06c94832e4cfe6745e36', '41beca957b19c738e676789d3b7e42d89be3607a', '2022-03-13 00:25:13'),
(65, 25, '3737ccaedbbcae62c337597779bd688d', '3da3368c0b611c5e220eb8207d19314b41407e4b', '2022-03-13 00:27:47'),
(66, 25, 'c2f932ee7999e4da0a607c746522a061', '030893ee79ca25276343ea3414ad98030bdbbeab', '2022-03-13 00:27:58'),
(67, 3, 'b7e77cd687197a1d648375a2d922abe6', '223ac0e12a11568699a447ef6c4d7f182bcf5581', '2022-03-13 00:28:00'),
(68, 25, 'e885c66b79e33b1a968e6bdb0a2f8f62', '0bfb62587da3477c7424cbd0deb773e80c63b2e7', '2022-03-13 00:28:58'),
(69, 3, 'baa9c9346a6de63944ae0c601df61156', '85f028e815020bf19936be83f1e3b62c9b79e2a8', '2022-03-13 00:29:19'),
(70, 3, '31566f2241e95a3e7741acc54298af9a', '1925ff84695c35c0e1d075f8372587490b0599ac', '2022-03-13 00:31:11'),
(71, 2, '900d5c82d7080da2f015411ca542d5fc', 'e0e9d0034d9c6a992dd47cba64f7913e2e1b4f22', '2022-03-13 00:33:51'),
(72, 3, 'c1ebe14b599ae587100f73583eb02d09', '422be9e807df436e1a64c6546619586bf26746bd', '2022-03-13 00:34:29'),
(73, 1, '760ec85b87612831fb2c8e067b483f7d', 'd6bdb92ef6c6d9024a33dd19ec2c77683b09b546', '2022-03-14 07:15:20'),
(74, 1, '3439e27f150b66d110c21ead81152878', 'bedf7af4f2393cd173b01aaa5bf58d8d43578518', '2022-03-14 08:28:57'),
(75, 1, '58dc617385a60bbb67c6ec4dfedc7a80', '42ccb4e481e7e5bb49b6e2899ad76f9c196e8e47', '2022-03-14 16:18:14'),
(76, 1, '1312da64adcaf8dae2c82320450401af', '69872b35f81283bc3bc20f61378e6f2ab6bcd60e', '2022-03-14 17:35:10'),
(77, 1, '302bdff57c2043e1725445b893cf1a2b', 'c1215ca34ae28c9b35869336665bb1addc6ce9b1', '2022-03-14 18:04:48'),
(78, 1, 'c338241078954322f036e34166064659', '9f374c529f5bb8ceaba1f126373f59fa29eafcb5', '2022-03-15 07:06:44'),
(79, 1, '78b87fcf032ea84af7d96d91b8e84997', '12f758bf02e7c0549719ceacd97605f0cc7b68c3', '2022-03-15 07:07:36'),
(80, 1, '4a8e0d6b56e15730b8f7719d45bb29af', 'e1bdfca09bc7a0f69c32261422e3685a0b6a57ab', '2022-03-15 17:05:33'),
(81, 1, '39d72e8e479ba40e4c7393e56437dea6', '6ac3c3c42823ece24ac5abcf5febb789ab2aee49', '2022-03-15 17:07:26'),
(82, 1, '3112476c8821f5271dc0ed024547c770', 'ba9a85e9da00b639090a59f7fa792ccbb8ab8196', '2022-03-15 17:09:07'),
(83, 1, 'c5666244715b4744b8d472cbbfa9c65f', '20c1e0de0b5bc1b6581b16b1734f6dcc3a2e6abb', '2022-03-15 17:09:24'),
(84, 1, '98f7cd234b50f4dd7433f6bffe4b975e', 'b5d26935d351018daeafeda9f63be9a45fd4b532', '2022-03-15 17:10:56'),
(85, 1, '0e1844966f9227946b344f7f77616ea2', '3f456fb80ff6dec3b6833d8bb14ba6d4cee04d16', '2022-03-15 17:14:34'),
(86, 1, '44b385dbeb2b8d321de5f418ebf063fe', '739946b3aa1fa2960e2981bdc92ed19588a05020', '2022-03-15 20:14:19'),
(87, 1, '1f77ec3d3b3a75a434e73283a67da7e5', 'c022109f20db8df39c33cd5b03a19f0b16ede697', '2022-03-16 07:44:57'),
(88, 1, 'b661b0745320fda7c5c10e26b6ba58b6', 'ba42b9bdc235b8d6ff8bf396928f8aac3a28c177', '2022-03-17 07:10:23'),
(89, 2, '046ab8981034a45f19c419f628199546', '344b13c9d8eb9aa345f40267de28ce407930f31e', '2022-03-17 08:54:42');

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
(1, 'test@test.com', '$2y$10$SfhYIDtn.iOuCW7zfoFLuuZHX6lja4lF4XA4JqNmpiH/.P3zB8JCa', 'Vorname', 'Nachname', '2022-02-04 08:57:26', '2022-03-12 23:23:31', NULL, NULL, 1),
(2, 'ich@paul-vassen.de', '$2y$10$AjGihIboyCYY/gnDq7J08.spp4N6Du.wog2anlhRsFALSZj9DPrPq', 'Paul', 'Vaßen', '2022-02-04 15:34:37', '2022-03-10 07:04:28', NULL, NULL, 2),
(3, 'jan@schniebs.com', '$2y$10$xlYaMlJc0JLTBAhHLrgC5.Y1ECi5y8IbxBY74W4nzCmuNLio.NwFO', 'Jan', 'Schniebs', '2022-02-23 07:14:00', '2022-03-11 18:28:52', NULL, NULL, 2),
(5, 'g.einkaufstute@edeka.de', '$2y$10$unifQHy15eQr./VQXD1lj.Zouy/HURsgZYUtbUNy0VDA/mtrqrf8i', 'Gerhard', 'Einkaufstüte', '2022-02-23 09:36:25', '2022-02-23 09:36:25', NULL, NULL, 1),
(25, 'max@musterman.de', '$2y$10$FWcz3DcRpbAPJgs2UBbp5.1ECDidXnFYxYif63d9XuCyhyBqnMZoe', 'Max', 'Musterman', '2022-03-10 12:32:01', '2022-03-12 19:59:58', NULL, NULL, 3);

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
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `permission_group`
--
ALTER TABLE `permission_group`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `products_types`
--
ALTER TABLE `products_types`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100000;

--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `product_list`
--
ALTER TABLE `product_list`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `securitytokens`
--
ALTER TABLE `securitytokens`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;

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