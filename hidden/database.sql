-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 26, 2022 at 09:23 AM
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
-- Table structure for table `address`
--

CREATE TABLE `address` (
  `id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `citys_id` int(10) NOT NULL,
  `street` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `number` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `default` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `address`
--

INSERT INTO `address` (`id`, `user_id`, `citys_id`, `street`, `number`, `default`, `created_at`, `updated_at`) VALUES
(1, 3, 1, 'Ludwigstr.', '25', 1, '2022-04-25 09:01:17', '2022-04-25 09:37:10'),
(2, 2, 1, 'ApfelStarße', '123', 0, '2022-04-25 09:01:40', '2022-04-25 15:45:22'),
(3, 2, 2, 'Defaultstarße', '1', 0, '2022-04-25 09:02:09', '2022-04-25 09:23:26'),
(4, 3, 2, 'Notdefault', '12/2', 0, '2022-04-25 09:02:45', '2022-04-25 09:37:10'),
(5, 2, 3, 'Test', '123/4B', 1, '2022-04-25 12:42:37', '2022-04-25 15:45:22');

-- --------------------------------------------------------

--
-- Table structure for table `citys`
--

CREATE TABLE `citys` (
  `id` int(10) NOT NULL,
  `PLZ` int(6) NOT NULL,
  `city` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `citys`
--

INSERT INTO `citys` (`id`, `PLZ`, `city`) VALUES
(1, 73614, 'Schorndorf'),
(2, 12313, 'Berlin'),
(3, 72555, 'Metzingen');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(10) NOT NULL,
  `kunden_id` int(10) NOT NULL,
  `rechnungsadresse` int(10) DEFAULT NULL,
  `lieferadresse` int(10) DEFAULT NULL,
  `ordered` tinyint(1) NOT NULL DEFAULT 0,
  `ordered_date` datetime DEFAULT NULL,
  `sent` tinyint(1) NOT NULL DEFAULT 0,
  `sent_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `kunden_id`, `rechnungsadresse`, `lieferadresse`, `ordered`, `ordered_date`, `sent`, `sent_date`) VALUES
(1, 1, 1, 1, 1, '2022-04-04 11:28:37', 1, '2022-04-07 11:28:37'),
(4, 2, NULL, NULL, 1, '2022-03-30 14:04:09', 1, '2022-04-07 11:28:41'),
(6, 3, NULL, NULL, 1, '2022-04-04 20:55:14', 1, '2022-04-07 11:26:42'),
(7, 5, NULL, NULL, 0, NULL, 0, NULL),
(20, 2, NULL, NULL, 1, '2022-04-12 10:41:23', 0, NULL),
(21, 1, NULL, NULL, 1, '2022-03-30 20:49:22', 1, '2022-04-07 11:26:33'),
(22, 1, NULL, NULL, 1, '2022-04-25 09:20:43', 0, NULL),
(23, 1, NULL, NULL, 1, '2022-04-07 10:21:32', 1, '2022-04-07 17:20:03'),
(24, 3, NULL, NULL, 1, '2022-04-07 10:21:34', 1, '2022-04-12 12:29:54'),
(25, 1, NULL, NULL, 1, '2022-04-11 11:56:35', 1, '2022-04-12 12:29:59'),
(26, 3, NULL, NULL, 1, '2022-04-12 09:59:49', 1, '2022-04-12 12:30:01'),
(27, 51, NULL, NULL, 1, '2022-04-07 10:24:35', 1, '2022-04-08 18:17:08'),
(28, 51, NULL, NULL, 0, NULL, 0, NULL),
(33, 52, NULL, NULL, 0, NULL, 0, NULL),
(34, 1, NULL, NULL, 1, '2022-04-12 12:13:04', 0, NULL),
(35, 3, NULL, NULL, 1, '2022-04-12 10:41:26', 1, '2022-04-12 12:30:05'),
(36, 53, NULL, NULL, 1, '2022-04-12 10:04:26', 1, '2022-04-12 10:04:50'),
(37, 53, NULL, NULL, 0, NULL, 0, NULL),
(38, 2, NULL, NULL, 1, '2022-04-12 11:22:01', 1, '2022-04-12 11:23:04'),
(39, 3, NULL, NULL, 1, '2022-04-12 11:22:20', 1, '2022-04-12 12:30:08'),
(41, 3, NULL, NULL, 1, '2022-04-12 12:12:06', 0, NULL),
(42, 3, NULL, NULL, 1, '2022-04-12 12:13:11', 0, NULL),
(43, 1, NULL, NULL, 0, NULL, 0, NULL),
(44, 3, NULL, NULL, 1, '2022-04-12 13:31:56', 0, NULL),
(45, 3, NULL, NULL, 1, '2022-04-12 21:34:08', 0, NULL),
(46, 3, NULL, NULL, 1, '2022-04-19 10:53:19', 1, '2022-04-19 10:53:31'),
(47, 2, NULL, NULL, 1, '2022-04-14 15:18:36', 0, NULL),
(50, 3, NULL, NULL, 1, '2022-04-25 09:06:23', 0, NULL),
(52, 1, NULL, NULL, 0, NULL, 0, NULL),
(53, 3, NULL, NULL, 1, '2022-04-25 11:02:53', 1, '2022-04-25 12:10:20'),
(54, 3, NULL, NULL, 1, '2022-04-25 12:10:05', 1, '2022-04-25 12:10:23'),
(59, 3, 1, 1, 1, '2022-04-26 08:38:46', 0, NULL),
(61, 3, NULL, NULL, 0, NULL, 0, NULL),
(62, 2, NULL, NULL, 0, NULL, 0, NULL);

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
(3, 'employee', 1, 0, 0, 1, 0, 1, 0, 0, 1, 0, 0, 0, 1, 1);

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
(8, 'Classic Vintage Monitor', 'Best Device ever.', 106, '1099.99', '1099.99', 4, '2022-03-13 19:03:15', '2022-04-26 06:38:40', 1),
(11, 'Rick Astley\'s Mikrofon', 'This Mikrofon never gonna gives you up', 252, '69420.00', '69421.00', 0, '2022-03-23 07:57:08', '2022-04-25 15:47:02', 1),
(13, 'SAMSUNG 24 Zoll Full-HD Monitor', 'SAMSUNG LF24T350FHRXEN 24 Zoll Full-HD Monitor, 5 ms Reaktionszeit & 75 Hz', 100, '150.00', '150.00', 10, '2022-04-11 07:26:58', '2022-04-26 06:47:38', 1),
(14, 'Lenovo 27\" Monitor', 'Lenovo 27\" Monitor D27-30 - 27\" FHD LED Monitor - Schwarz - 4 ms AMD FreeSync', 101, '129.00', '129.00', 14, '2022-04-11 07:29:17', '2022-04-26 06:38:46', 1),
(15, 'Lenovo D32qc', 'Lenovo D32qc-20 - 80 cm (32 Zoll), LED, Curved, VA-Panel, WQHD-Auflösung', 102, '200.00', '200.00', 10, '2022-04-13 06:42:05', '2022-04-13 06:42:05', 1),
(16, 'LG UltraWide 34WP500 ', 'LG UltraWide 34WP500 ', 103, '280.00', '280.00', 5, '2022-04-13 06:51:27', '2022-04-13 06:51:27', 1),
(17, '32GB G.Skill Trident Z Neo DDR4-3600 DIMM CL16 Dual Kit', 'Speicherleistung und lebendige RGB-Beleuchtung für jeden Gaming-PC oder jede Workstation mit AMD Ryzen™ 3000 CPUs und AMD X570 Mainboards.\r\n\r\nDer Trident Z Neo wurde entwickelt, um die Speicherleistung mit den neuesten Prozessoren der AMD Ryzen 3000 Serie auf der X570-Plattform zu skalieren, und ist optimiert, um die Plattform auf ihre maximale Geschwindigkeit zu bringen.\r\n\r\nEntworfen mit einem Kontrast aus schwarzem gebürstetem Aluminium und pulverbeschichtetem Silber, verleiht der Trident Z Neo zweifarbige Wärmeverteiler Ihrer nächsten Generation Kraft und Kühnheit.\r\n\r\nInspiriert von den Rennstreifen von Sportwagen und Supersportwagen, verfügt der Trident Z Neo über eine abgeschrägte Kante an der Oberseite des charakteristischen Tri-Finnen-Designs mit der asymmetrischen Neigung für einen eleganten und sauberen Look.\r\n\r\nJedes Modul wurde mit handgefertigten Speicher-ICs und kundenspezifischen 10-Lagen-Leiterplatten hergestellt und ist für die Aufrechterhaltung der besten Signalintegrität und schnelle Übertaktungsleistung ausgelegt.\r\n\r\nDie Trident Z-Serie von G.Skill umfasst verschiedene Unterkategorien wie RGB, Royal und Neo. Eines haben jedoch alle gemeinsam: Sie zeichnen sich durch extrem niedrige Latenzen und einzigartige Leistung aus. Die hohe Stabilität sorgt für endlose Stunden Vergnügen. Moderne Designs runden den RAM ab.\r\n\r\nHohe Taktfrequenzen von bis zu 3.600 MHz in Kombination mit niedrigen Latenzen und Overclocking sorgen für beste Voraussetzungen. Kompromisslose Leistung erlaubt es, selbst bei sehr CPU-lastigen Anwendungen beste Ergebnisse zu erzielen.\r\n\r\n\r\nDie G.Skill Trident Z-Serie präsentiert sich nicht nur in verschiedenen Designs. Sie eignet sich auch für diverse Systeme und harmoniert mit vielen Komponenten. Mit AMD-Hardware werden die Vorteile besonders deutlich.\r\n\r\n\r\nTrident Z RAM sind ausschließlich auf DDR4-Basis erhältlich. Benötigen Sie CPU mit DDR3-Slot, erwarten Sie bei G.Skill andere Serien für performantes Gaming.\r\n\r\n\r\nJe nach RAM sind Taktraten von 2.400 MHz bis zu 4.600 MHz möglich. Single Kits erhalten Sie mit einer Gesamtkapazität von 8 bis 16 GB, Dual/Quad-Kits mit 16 bis 32 GB.\r\n\r\nModellname:	Trident Z Neo\r\nGesamtkapazität:	32GB\r\nAnzahl der Module:	2x\r\nKapazität der Einzelmodule:	16GB\r\nArt des Speichers:	DDR4-3600\r\nJEDEC Norm:	PC4-28800U\r\nSpeichertyp:	unbuffered\r\nBauform:	DIMM\r\nSpeicherinterface:	DDR4\r\nMax. Frequenz:	3600MHz\r\nVerpackung:	Dual Kit\r\nSpannung:	1.35V\r\nAnschluss des Speichers:	288-pin\r\nLatenz (CL):	CL16\r\nRAS to CAS Delay (tRCD):	19\r\nRas Precharge Time (tRP):	19\r\nRow Active Time (tRAS):	39\r\nBesonderheiten:	RGB-Beleuchtung, XMP 2.0 Unterstützung', 50, '194.00', '230.00', 34, '2022-04-13 06:55:38', '2022-04-26 06:45:03', 1),
(18, 'AMD Ryzen 7 5800X 8x 3.80GHz So.AM4 WOF', 'Konzipiert, um Erwartungen zu übertreffen\r\nDer Prozessor aus der Vermeer-Familie mit Zen-3-Architektur ist nicht ohne Grund ein Elite-Gaming-Modell. Er verfügt über 8 CPU-Kerne, 16 Threads und einer Taktrate von 3.80 bis 4.70 GHz. Gaming mit hohen FPS ist also kein Problem. Wie alle CPUs der 5000er Ryzen™-Serie verringert der neu gestaltete L3-Cache mit 32MB Latenzen\r\n\r\nAMD Ryzen™ Prozessoren bieten die besten Features, um im Spiel zu bleiben.\r\nNeueste Technologien zur Unterstützung außergewöhnlicher Performance. Alle AMD Ryzen™ 5000 Prozessoren bieten eine vollständige Suite von Technologien, die für mehr Performance auf Ihrem PC sorgt - darunter Precision Boost 2, Precision Boost Overdrive und PCIe® 4.0.\r\n\r\nAMD Ryzen™ Prozessoren sind einfach konfigurierbar und anpassbar.\r\nFür einander geschaffen. Mainboards mit neuestem AMD 500 Chipsatz und AMD Ryzen 5000 Prozessoren. Optimiere den neuen Ryzen™ 5000 mit Ryzen™ Master und AMD StoreMI.\r\n\r\nDie \"Zen 3\"-Architektur basiert auf dem neuen \"Unified Complex\"-Konzept, das 8 Kerne und einen 32-MB-L3-Cache zu einer einzigen Ressourcengruppe vereint. Mehr Anweisungen pro Takt und geringere Latenzen sind insbesondere für PC-Spiele ein großer Vorteil. 19 % höhere Befehlsraten pro Zyklus und geringere Latenz gehen ganz ohne eine Erhöhung des Stromverbrauchs einher.\r\n\r\nWie alle Ryzen-CPUs verfügt auch der 5800X-Prozessor werksseitig über einen freigeschalteten Multiplikator, um die Leistung exakt auf die eigenen Anforderungen anpassen zu können.\r\n\r\nWer gern in die Virtual Reality abtaucht, ist beim AMD Ryzen™ 7 5800X beim richtigen Prozessor angekommen. Die VR-Ready-Prozessoren geben Gewissheit, dass genügend Rechnerleistung für die Workloads von VR-Erlebnissen vorhanden ist. Die Modelle mit diesem Label erfüllen oder übertreffen sogar die minimalen Spezifikationen für Prozessoren der aktuell besten VR-HMD-Hersteller wie Oculus Rift, HTC Vive oder Microsoft Windows® Mixed Reality.', 51, '309.00', '328.00', 3, '2022-04-13 06:58:20', '2022-04-13 06:58:20', 1),
(19, 'Samsung C49HG90DMR', 'Samsung C49HG90DMR - 49 Zoll, UltraWide Full HD (3840 x 1080), VA-Panel, 144Hz, 1ms, 350cd/m², DisplayHDR 600 (LC49HG90DMRXEN)', 104, '718.00', '718.00', 4, '2022-04-13 06:58:38', '2022-04-26 06:45:03', 1),
(20, 'AMD Ryzen 5 5600X 6x 3.70GHz So.AM4 BOX', 'Konzipiert, um Erwartungen zu übertreffen\r\nDer AMD Ryzen™ 5 5600X ist ein echter Preistipp unter den Alltags- und Gaming-Prozessoren, der auch in günstigen Gaming-Rechnern eine gute Figur abgibt. Der Prozessor verfügt über sechs Kerne mit Multithreading (12 Threads) zur parallelen Bearbeitung mehrerer Tasks. Die CPU taktet von 3,7 bis 4,6 Gigahertz und unterstützt DDR4-3200-RAM. Die L1- und L2-Caches sind im Vergleich zur Vorgängergeneration mehr oder weniger gleich geblieben, dafür hat sich beim L3-Cache etwas getan: Auf diesen greifen nun je nach Modell bis zu acht Kerne gleichzeitig zu. Dieses neue Cache-Modell verringert die Latenzen, was gerade dem Gaming zugutekommt.\r\n\r\nAMD Ryzen™ Prozessoren bieten die besten Features, um im Spiel zu bleiben.\r\nNeueste Technologien zur Unterstützung außergewöhnlicher Performance. Alle AMD Ryzen™ 5000 Prozessoren bieten eine vollständige Suite von Technologien, die für mehr Performance auf Ihrem PC sorgt - darunter Precision Boost 2, Precision Boost Overdrive und PCIe® 4.0.\r\n\r\nAMD Ryzen™ Prozessoren sind einfach konfigurierbar und anpassbar.\r\nFür einander geschaffen. Mainboards mit neuestem AMD 500 Chipsatz und AMD Ryzen 5000 Prozessoren. Optimieren Sie den neuen Ryzen™ 5000 mit Ryzen™ Master und AMD StoreMI.\r\n\r\nDie \"Zen 3\"-Architektur basiert auf dem neuen \"Unified Complex\"-Konzept, das bis zu acht Kerne und einen 32-MB-L3-Cache zu einer einzigen Ressourcengruppe vereint. Mehr Anweisungen pro Takt und geringere Latenzen sind insbesondere für PC-Spiele ein großer Vorteil. 19 % höhere Befehlsraten pro Zyklus und geringere Latenz kommen ganz ohne eine Erhöhung des Stromverbrauchs aus.\r\n\r\nWie alle RyzenTM-CPUs ist auch beim 5600X-Prozessor werksseitig der Multiplikator freigeschaltet. Mithilfe des AMD-RyzenTM-Master-Dienstprogramms kann die Leistung der CPU an individuelle Anforderungen angepasst werden.', 51, '224.00', '240.00', 12, '2022-04-13 07:01:14', '2022-04-13 07:01:14', 1),
(21, 'AMD Ryzen 9 5900X 12x 3.70GHz So.AM4 WOF', 'Konzipiert, um Erwartungen zu übertreffen\r\nDer AMD Ryzen™ 9 5900X besitzt 12 CPU-Kerne auf Basis der Zen-3-Architektur, der inzwischen vierten Zen-Generation. Im Vergleich zu den Vorgängern hat nun jeder Prozessorkern Zugriff auf den gesamten L3-Cache. 24 Threads und eine Taktfrequenz von bis zu 4.80 GHz bieten High-Performance bei Gaming, Streaming, Videobearbeitung oder 3D-Renderings. Alle AMD-Ryzen™-5000-Prozessoren, so auch der 5900er, bieten Technologien, die für mehr Performance auf Ihrem PC sorgen; unter anderem Precision Boost 2, Precision Boost Overdrive und PCIe® 4.0.\r\n\r\nAMD Ryzen™ Prozessoren bieten die besten Features, um im Spiel zu bleiben.\r\nNeueste Technologien zur Unterstützung außergewöhnlicher Performance. Alle AMD Ryzen™ 5000 Prozessoren bieten eine vollständige Suite von Technologien, die für mehr Performance auf Ihrem PC sorgt - darunter Precision Boost 2, Precision Boost Overdrive und PCIe® 4.0.\r\n\r\nAMD Ryzen™ Prozessoren sind einfach konfigurierbar und anpassbar.\r\nFür einander geschaffen. Mainboards mit neuestem AMD 500 Chipsatz und AMD Ryzen 5000 Prozessoren. Optimiere den neuen Ryzen™ 5000 mit Ryzen™ Master und AMD StoreMI.\r\n\r\nDer \"Zen 3\"-Architektur liegt das neue \"Unified Complex\"-Konzept zugrunde, das bis zu acht Kerne und einen 32-MB-L3-Cache zu einer einzigen Ressourcengruppe zusammenfügt. Mehr Anweisungen pro Takt und geringere Latenzen sind insbesondere für latenzkritische Anwendungen wie Spiele ein großer Vorteil.\r\n\r\nWie bei allen Ryzen™-CPUs ist auch beim 5600X-Prozessor werksseitig der Multiplikator freigeschaltet. Mithilfe des AMD-Ryzen™-Master-Dienstprogramms ist die Leistung des Prozessors individuell anpassbar.\r\n\r\nDank VR-Ready-Premium-Siegel können Sie mit diesem Prozessor voll und ganz in die virtuelle Welt abtauchen. Die geforderten Spezifikationen für Oculus Rift, HTC Vive oder Microsoft Windows® Mixed Reality werden dabei mühelos erreicht und sogar übertroffen.\r\n***ACHTUNG:****\r\nDie Verwendung der CPU ist nur in Verbindung der Mainboards mit AMD 500-Serie Chipset möglich. Bitte prüfen Sie die Kompatibilität auf der Herstellerseite.', 51, '409.00', '409.00', 1, '2022-04-13 07:02:40', '2022-04-26 06:45:03', 1),
(22, 'RAZER KRAKEN X, Over-ear Gaming Headset', 'RAZER KRAKEN X, Over-ear Gaming Headset Schwarz', 250, '49.99', '49.99', 19, '2022-04-13 07:02:59', '2022-04-26 06:45:03', 1),
(23, '1TB Samsung SSD 980 M.2 PCIe 3.0 x4 3D-NAND TLC (MZ-V8V1T0BW)', 'Schöpfen Sie das Potenzial Ihres PCs mit der Samsung SSD 980 aus. Egal, ob Sie einen Boost für Spiele oder einen nahtlosen Workflow für umfangreiche Grafiken benötigen, die 980 ist eine kluge Wahl für herausragende SSD-Leistung - und all das wird durch eine NVMe-Schnittstelle und PCIe 3.0-Technologie unterstützt. Halten Sie Ihre SSD mit dem Full-Power-Modus auf Hochtouren, der für kontinuierliche und zuverlässige Höchstleistung sorgt. Aktivieren Sie die Samsung Magician-Software, um Ihre SSD ohne Latenz im aktiven Modus zu halten, sodass Sie sofort wieder in große, intensive Arbeitsdateien oder grafikintensive Spiele zurückkehren können.', 53, '93.00', '104.00', 72, '2022-04-13 07:03:57', '2022-04-13 07:03:57', 1),
(24, 'AMD Ryzen 5 5600G 6x 3.90GHz So.AM4 BOX', 'Mit der Highspeed Gaming-Performance der AMD Ryzen™ 5000G Serie sind Sie selbst in den neuesten Games nicht mehr aufzuhalten. Auch Videobearbeitung und 3D Rendering meistern die Ryzen™ 5000G Prozessoren problemlos. Bis zu 8 Kerne, 16 Threads, Taktfrequenzen von bis zu 4,6 GHz und bis zu 16 MB Cache lassen Sie bahnbrechende Performance erleben. Die integrierte AMD Radeon™ Grafikeinheit führt Sie blitzschnell zum Sieg. Spielen Sie Top-Games in flüssigem 1080p direkt ab Werk oder holen Sie sich eine Grafikkarte für noch mehr Leistung.\r\n\r\nMit der Ryzen™ 5000G Serie gehören Hardware-Limits der Vergangenheit an. Mit neuesten Technologien wie Precision Boost 3 und Precision Boost Overdrive wird Ihnen Performance ohne gleichen geboten. Die 5000G-Serie bleibt auch unter Belastung kühl und folgt damit der Tradition der herausragenden Performance der 7nm-Architektur.\r\n\r\nMit einem einfachen BIOS-Update auf AMD 500 Mainboards sowie auf ausgewählten Boards der 400 Serie ist der AMD Ryzen™ 5000G sofort einsatzbereit. Das Konfigurieren Ihres Gaming-PCs wird damit zum Kinderspiel. Installieren Sie AMD StoreMI, um Ihre Festplatte mit der SSD zu kombinieren und Ihre Spiele noch schneller zu laden.\r\n', 51, '199.00', '230.00', 25, '2022-04-13 07:04:53', '2022-04-14 13:18:36', 1),
(25, 'HYPERX Cloud Stinger Gaming Headset', 'HYPERX Cloud Stinger Kabelloses Core Gaming Headset + 7.1 Over-ear Schwarz', 250, '74.99', '74.99', 10, '2022-04-13 07:05:03', '2022-04-13 07:06:11', 1),
(26, 'be quiet! Pure Base 500DX Midi Tower ohne Netzteil schwarz', '\r\nAirflow und Performance-optimierte Bauteile\r\n\r\nFür alle, die besonders viel Wert auf maximale Performance und wassergekühlte Systeme legen, ist das extrem luftdurchlässige Top-Cover die richtige Wahl.\r\nDie Staubschutzfilter am Frontpanel und am Boden sind zum Reinigen leicht zu entfernen.\r\n\r\nDREI VORINSTALLIERTE PURE WINGS 2\r\n\r\nFlüsterleiser Betrieb\r\nDrei vorinstallierte Pure Wings 2 Lüfter mit luftstromoptimierten Lüfterblättern versprechen einen perfekten Luftstrom und solide Kühlleistung. Trotz des kompakten Designs stellen die drei 140mm Lüfter einen geräuscharmen Betrieb sicher. Bis zu zwei weitere 140mm Lüfter können optional installiert werden.\r\n\r\nBEEINDRUCKENDE BELEUCHTUNG\r\n\r\nARGB-Licht an der Front und im Gehäuse\r\nARGB LEDs bieten mehrere Farben und Modi, um die Optik des Gehäuses sowohl von innen als auch von außen individuell abzustimmen. Die Beleuchtung kann optional mit dem Motherboard oder der ARGB-Steuerung synchronisiert werden.\r\n\r\nINTELLIGENTES I/O-PANEL\r\n\r\nHochmoderne Technologie für dein System\r\nDas Front I/O-Panel verfügt über einen modernen USB 3.1 Gen. 2 Type C Anschluss für den Einsatz modernster Hardware. Es gibt außerdem einen Schalter, um die LEDs im Innen- und Außenbereich einzustellen.\r\n\r\nAUSGEKLÜGELTES DESIGN\r\n\r\nReichlich Platz für High-End Komponenten\r\nDas Pure Base 500DX Black bietet einen großzügigen Innenraum um High-End Grafikkarten und Kühler von bis zu 190mm Höhe zu installieren. Lüfter oder Radiatoren bis zu 360mm können leicht an der Vorderseite installiert werden. Die Oberseite bietet Platz für Lüfter und Radiatoren mit einer Größe von bis zu 240mm.\r\n\r\nAUFFÄLLIGE FEATURES\r\n\r\nSowie eine durchdachte Kabelführung\r\nDas Pure Base 500DX bietet zahlreiche Möglichkeiten, um bis zu fünf SSDs zu installieren. Zwei SSDs können sichtbar im Innenraum installiert werden. Dank der durchdachten Kabelführung können ungewünschte Kabel leicht versteckt werden.\r\n\r\nFUNKTIONALES PSU-COVER\r\n\r\nHält den Innenraum übersichtlich\r\nDas PSU-Cover versteckt nicht nur das Netzteil und Kabel, sondern beinhaltet auch einen Doppel-HDD-Käfig. Durch die entkoppelte Installation werden Vibrationen reduziert und ein geräuscharmer Betrieb unterstützt. Um einen 360mm-Radiator an der Front installieren zu können, kann der Doppel-HDD-Käfig versetzt werden. Das Netzteil kann benutzerfreundlich von der Rückseite des Gehäuses installiert werden.\r\n\r\nTEMPERGLAS\r\n\r\nDie perfekte Sicht in den PC\r\nDas elegante, verglaste Seitenfenster bietet einen perfekten Einblick auf die Komponenten in Ihrem PC. Das Seitenfenster ist mit getöntem Temperglas ausgestattet und verfügt über geschwärzte Seitenrahmen.', 58, '97.00', '97.00', 11, '2022-04-13 07:06:42', '2022-04-13 07:06:42', 1),
(27, '1TB Samsung 970 Evo Plus M.2 2280 PCIe 3.0 x4 NVMe 1.3 3D-NAND TLC (MZ-V7S1T0BW)', 'Eine herausragende SSD\r\nSo wird hohe Leistung noch gesteigert. Die mit modernster V-NAND-Technologie ausgestattete 970 EVO Plus ist noch schneller als die 970 EVO und verfügt zudem über eine Firmware-Optimierung. Damit reizt sie das Potential der PCIe-Schnittstelle und des NVMe Protokolls für noch schnellere Zugriffszeiten voll aus. Bei einer Speicherkapazität von 2 TB beträgt die spezifizierte Gesamtschreibdatenmenge (TBW = Total Bytes Written) 1.200 TB TBW.\r\n\r\nLeistung auf dem nächsten Level\r\nMit bis zu 3.500 MB/s1 Lese- und bis zu 3.300 MB/s2 Schreibgeschwindigkeit ist die 970 EVO Plus bis zu 53%3 schneller als das Vorgängermodell 970 EVO. Die neueste Generation der V-NAND-Technologie sorgt für eine herausragende Leistung und verbesserte Energieeffizienz. Zusätzlich zeichnet sich die 970 EVO Plus durch optimierte Firmware, den bewährten Phoenix-Controller sowie die Intelligent TurboWrite-Technologie für die Beschleunigung von Schreibvorgängen aus.\r\n\r\nFlexibilität durch gutes Produktdesign\r\nDie 970 EVO Plus zeigt die Weiterentwicklung im Bereich der NVMe-SSDs. Neben einer hohen Performance bietet sie eine Speicherkapazität von bis zu 2 TB Speicherkapazität im kompakten M.2-Formfaktor (2280). Sie bietet damit viel Speicherplatz bei geringen Abmessungen und spart damit wertvollen Platz für andere Komponenten. Innovative Samsung-Technologien ermöglichen es Ihnen damit, den Freiraum zu haben, den sie benötigen um viel zu erreichen und noch mehr zu bewerkstelligen.\r\n\r\nUnbedingte Zuverlässigkeit\r\nHaben Sie noch mehr Vertrauen. Der bewährte Samsung Phoenix-Controller ist mit einer Schicht aus Nickel überzogen und das Laufwerksmodul der 970 EVO Plus mit einem dünnen Heat Spreader versehen, so dass die entstehende Wärme im Betrieb effektiv abgeführt wird. Darüber hinaus wacht die Dynamic Thermal Guard-Funktion ständig über das Laufwerk, so dass optimale Betriebstemperaturen eingehalten werden und die Performance konstant gehalten werden kann.\r\n\r\nSamsung Magician\r\nSo wird die Laufwerksverwaltung zum Kinderspiel. Die kostenlose Samsung Magician-Software hilft Ihnen dabei, immer ein Auge auf Ihre SSD zu haben. Die benutzerfreundliche Software-Lösung hält das Laufwerk mit Updates immer auf dem neuesten Stand, überwacht Statusparameter und optimiert für Sie die Leistungsfähigkeit.', 53, '112.00', '130.00', 128, '2022-04-13 07:10:36', '2022-04-25 09:02:53', 1),
(28, '1TB Samsung 980 Pro M.2 PCIe 4. 3D-NAND TLC (MZ-V8P1T0BW)', 'Bringen Sie Ihre PC-Leistung auf das nächste Level mit der 1000 GB Samsung 980 PRO PCIe 4.0 NVMe® M.2 SSD. Die 980 PRO bietet mit PCIe 4.0 eine doppelt so hohe Übertragungsrate wie PCIe Gen3 SSDs, bei gleichzeitiger Abwärtskompatibilität mit PCIe 3.0. Als NVMe® SSD verfügt die 980 PRO mit einer Lesegeschwindigkeit von bis zu 7.000 MB/s und einer Schreibgeschwindigkeit von bis zu 5.000 MB/s über herausragende Geschwindigkeiten.\r\n\r\nDie 980 PRO überzeugt mit hoher Performance und einer Speicherkapazität von 1000 GB im kompakten M.2-Formfaktor. Sie bietet damit viel Speicherplatz bei geringen Abmessungen und spart damit wertvollen Platz für andere Komponenten. Innovative Samsung-Technologien geben Ihnen den Freiraum, den sie benötigen um viel zu erreichen und noch mehr zu bewerkstelligen. Das macht die 980 PRO ideal für Ihr High-Performance System.\r\n\r\nDie 980 PRO ist mit einer Nickelschicht überzeugen und das Laufwerksmodul ist mit einem dünnen Heat Spreader versehen, sodass die entstehende Wärme im Betrieb effektiv abgeführt wird. Darüber hinaus wacht die Dynamic Thermal Guard-Funktion ständig über das Laufwerk, so dass optimale Betriebstemperaturen eingehalten werden und die Performance konstant gehalten werden kann.\r\n\r\nDie Samsung Magician-Software hilft Ihnen dabei, immer ein Auge auf Ihre SSD zu haben. So wird die Laufwerksverwaltung zum Kinderspiel. Die benutzerfreundliche Software-Lösung hält das Laufwerk mit Updates immer auf dem neuesten Stand, überwacht Statusparameter und optimiert für Sie die Leistungsfähigkeit.', 53, '138.00', '170.00', 12, '2022-04-13 07:11:38', '2022-04-26 06:45:03', 1),
(29, 'Arctic MX-4 2019 Waermeleitpaste 4g', 'Arctic MX-4 2019 Edition Hochleistungs-Wärmeleitpaste, Spritze mit 4 g, thermische Leitfähigkeit von 8,5 W/mK', 7, '4.00', '4.00', 62, '2022-04-13 07:15:16', '2022-04-26 06:45:03', 1),
(30, 'Intel Core i5 12400F 6x 2.50GHz So.1700 BOX', 'Intel® Directed-I/O-Virtualisierungstechnik (VT-d)\r\nDie Intel® Directed-I/O-Virtualisierungstechnik (VT-d) setzt die bestehende Unterstützung von Virtualisierungslösungen für die IA-32 (VT-x) und Systeme mit Itanium® Prozessoren (VT-i) fort und erweitert diese um neue Unterstützung für die I/O-Gerätevirtualisierung. Die Intel VT-d kann Benutzern helfen, die Sicherheit und Zuverlässigkeit von Systemen sowie die Leistung von I/O-Geräten in virtualisierten Umgebungen zu verbessern.\r\n\r\nIntel® Virtualisierungstechnik (VT-x)\r\nMit der Intel® Virtualisierungstechnik (VT-x) kann eine Hardwareplattform als mehrere \"virtuelle\" Plattformen eingesetzt werden. Sie bietet verbesserte Verwaltbarkeit durch weniger Ausfallzeiten und eine Beibehaltung der Produktivität, indem die Rechenvorgänge in separate Partitionen verschoben werden.\r\n\r\nIntel® 64\r\nIn Verbindung mit der entsprechenden Software ermöglicht die Intel® 64 Architektur die 64-Bit-Verarbeitung bei Servern, Workstations, PCs und Mobilplattformen.¹ Intel 64 verbessert die Leistung, da das System durch diese Prozessorerweiterung mehr als 4 GB virtuellen und physischen Speicher adressieren kann.\r\n\r\nCache\r\nDer CPU-Cache ist ein Bereich des schnellen Speichers, der sich im Prozessor befindet. Intel® Smart-Cache bezieht sich auf die Architektur, die ermöglicht, dass alle Kerne den Zugriff auf den Last-Level-Cache dynamisch teilen.\r\n\r\nIntel® AES New Instructions\r\nIntel® AES New Instructions (Intel® AES-NI) ist eine Zusammenstellung von Anweisungen zur schnellen und sicheren Verschlüsselung und Entschlüsselung von Daten. AES-NI sind wertvolle Komponenten für kryptografische Anwendungen, z. B. für: Anwendungen zur Massenverschlüsselung/-entschlüsselung, Authentifizierung, Generierung von zufälligen Nummern und Authentifizierungsverschlüsselung.\r\n\r\nRuhezustände\r\nRuhezustände (C-Zustände) werden genutzt, um Energie zu sparen, wenn der Prozessor sich im Leerlauf befindet. C0 ist der Betriebszustand, d. h. die CPU führt sinnvolle Aufgaben aus. C1 ist der erste Leerlaufzustand, C2 der zweite usw., wobei für höhere Nummern des C-Zustands mehr Energiesparmaßnahmen durchgeführt werden.\r\n\r\nIntel® Turbo-Boost-Technik\r\nDie Intel® Turbo-Boost-Technik erhöht dynamisch die Frequenz eines Prozessors nach Bedarf, indem die Temperatur- und Leistungsreserven ausgenutzt werden, um bei Bedarf mehr Geschwindigkeit und andernfalls mehr Energieeffizienz zu bieten.\r\n\r\nMax. Turbo-Taktfrequenz\r\nDie maximale Turbo-Taktfrequenz ist die maximale Einzelkern-Taktfrequenz, zu der der Prozessor mit der Intel® Turbo-Boost-Technik und, falls vorhanden, mit Intel® Thermal Velocity Boost betrieben werden kann. Die Frequenz wird in Gigahertz (GHz) gemessen bzw. in Milliarden Takten pro Sekunde.\r\n\r\nExecute-Disable-Bit\r\nDie Execute-Disable-Bit ist eine hardwarebasierte Sicherheitsfunktion, die das Risiko von Vireninfektionen verringert und verhindern kann, dass bösartige Software auf dem Server bzw. im Netzwerk ausgeführt wird.\r\n\r\nIntel® Hyper-Threading-Technik\r\nDie Intel® Hyper-Threading-Technik ermöglicht zwei Verarbeitungs-Threads pro physischem Kern. Anwendungen mit vielen Threads können mehr Aufgaben parallel erledigen und Tasks früher beenden.\r\n\r\nBefehlssatz\r\nEin Befehlssatz bezeichnet den Satz grundlegender Befehle und Anweisungen, die ein Mikroprozessor versteht und ausführen kann. Der angezeigte Wert gibt an, mit welchem Intel Befehlssatz dieser Prozessor kompatibel ist.\r\n\r\nIntel® VT-x mit Extended Page Tables (EPT)\r\nIntel® VT-x mit Extended Page Tables (EPT), auch bekannt als Second Level Address Translation (SLAT), beschleunigt speicherintensive Virtualisierungsanwendungen. Der Einsatz von Extended Page Tables bei Plattformen mit Intel® Virtualisierungstechnik reduziert die Gesamtkosten für Speicher und Stromversorgung und erhöht die Akkulaufzeit durch Hardwareoptimierung der Seitentabellenverwaltung.\r\n\r\nIntel® Optane™ Speicher unterstützt\r\nIntel® Optane™ Speicher ist eine revolutionäre neue Klasse von nichtflüchtigem Speicher, der zwischen dem Systemspeicher und dem Datenspeicher angesiedelt ist, um die Leistung und Reaktionsgeschwindigkeit des Systems zu beschleunigen. In Kombination mit dem Intel® Rapid-Storage-Technik-Treiber verwaltet er nahtlos mehrere Speicherstufen, bei Bereitstellung eines virtuellen Laufwerks für das Betriebssystem. Dadurch wird sichergestellt, dass sich häufig verwendete Daten auf der schnellsten Speicherstufe befinden. Intel® Optane™ Speicher erfordert eine spezifische Hardware- und Softwarekonfiguration. Die Konfigurationsvoraussetzungen finden Sie unter .\r\n\r\nErweiterte Intel SpeedStep® Technologie\r\nDie Erweiterte Intel SpeedStep® Technologie ist eine fortschrittliche Funktionalität für die auf Mobilgeräten benötigte Kombination von hoher Leistung bei einem möglichst niedrigen Energieverbrauch. Die herkömmliche Intel SpeedStep® Technologie schaltet die Spannung und die Frequenz je nach Prozessorauslastung gleichzeitig zwischen hohen und niedrigen Werten um. Die Erweiterte Intel SpeedStep® Technologie baut auf dieser Architektur auf und nutzt Designstrategien wie Trennung zwischen Spannungs- und Frequenzänderungen sowie Taktpartitionierung und Wiederherstellung.\r\n\r\nSecure Key\r\nIntel® Secure Key basiert auf einem digitalen Zufallszahlengenerator, der vollkommen zufällige Zahlen generiert und so Verschlüsselungsalgorithmen stärkt.\r\n\r\nIntel® Speed Shift Technology\r\nDie Intel® Speed Shift Technology nutzt hardware-gesteuerte P-Stati, um mit vorübergehenden Single-Thread-Workloads von kurzer Dauer (wie beim Browsen im Internet) eine bedeutend schnellere Reaktionszeit zu erzielen. Dazu wird es dem Prozessor ermöglicht, die jeweils beste Betriebsfrequenz und Spannung zu wählen, um optimale Leistung und Energieeffizienz zu erzielen.\r\n\r\nIntel® Deep Learning Boost (Intel® DL Boost)\r\nEin neuer Satz mit Embedded-Prozessor-Technologien zur Beschleunigung von KI-Deep-Learning-Anwendungsfällen. Damit wird Intel AVX-512 mit einer neuen VNNI (Vector Neural Network Instruction) erweitert, welche die Deep-Learning-Leistung im Vergleich zu früheren Generationen bedeutend verbessert.\r\n\r\nBefehlssatzerweiterungen\r\nBefehlssatzerweiterungen sind zusätzliche Anweisungen zur Erhöhung der Leistung, wenn die gleichen Vorgänge auf mehreren Datenobjekten ausgeführt werden. Diese können SSE (Streaming SIMD Extensions) und AVX (Advanced Vector Extensions) umfassen.\r\n\r\nIntel® Turbo Boost Max-Technik 3.0\r\nIntel® Turbo Boost Max-Technik 3.0 identifiziert den/die Kern(e) mit der besten Leistung und liefert an diese Kerne erhöhte Leistung, indem sie die Taktfrequenz nach Bedarf steigert und dabei Strom- und Temperaturreserven verwendet.\r\n\r\nThermal-Monitoring-Technologien\r\nThermal-Monitoring-Technologien schützen das Prozessorpaket und das System über Temperaturverwaltungsfunktionen vor temperaturbedingten Ausfällen. Ein digitaler Temperatursensor auf dem Chip erkennt die Temperatur des Kerns, und die Temperaturverwaltungsfunktionen senken bei Bedarf den Energieverbrauch des Pakets und damit die Temperatur, um die Grenzwerte für den normalen Betrieb einzuhalten.\r\n\r\nIntel® Volume Management Device (VMD)\r\nIntel® Volume Management Device (VMD) bietet eine allgemeine, robuste Hot-Plug- und LED-Management-Methode für NVME-Solid-State-Laufwerke.\r\n\r\nIntel® Gauß- und neuraler Beschleuniger\r\nDer Intel® Gauß- und neuraler Beschleuniger (GNA) ist ein bei äußerst niedrigem Stromverbrauch laufender Beschleunigerblock, der für Audio- und geschwindigkeitszentrierte KI-Workloads entwickelt wurde. Intel® GNA wurde entwickelt, um audiobasierte neurale Netzwerke bei äußerst niedrigem Stromverbrauch auszuführen und gleichzeitig der CPU diese Arbeitslast abzunehmen.\r\n\r\nMBE (Mode-based Execute Control, modusbasierte Ausführungssteuerung)\r\nModusbasierte Ausführungssteuerung kann die Integrität des Codes auf Kernel-Ebene zuverlässiger verifizieren und durchsetzen.\r\n\r\nIntel® Boot Guard\r\nDie Intel® Device Protection Technology mit Boot Guard trägt zum Schutz der Umgebung vor Viren und bösartigen Softwareangriffen vor der Aktivierung des Betriebssystem bei.\r\n\r\nIntel® Control-Flow Enforcement Technology\r\nCET - Intel Control-Flow Enforcement Technology (CET) schützt vor dem Missbrauch legitimer Code-Ausschnitte durch ROP-Angriffe (return-oriented programming) zur Übernahme der Kontrollstruktur.', 51, '176.00', '176.00', 8, '2022-04-13 07:16:18', '2022-04-13 07:16:18', 1),
(31, 'AMD Ryzen 7 5700G 8x 3.80GHz So.AM4 BOX', 'Mit der Highspeed Gaming-Performance der AMD Ryzen™ 5000G Serie sind Sie selbst in den neuesten Games nicht mehr aufzuhalten. Auch Videobearbeitung und 3D Rendering meistern die Ryzen™ 5000G Prozessoren problemlos. Bis zu 8 Kerne, 16 Threads, Taktfrequenzen von bis zu 4,6 GHz und bis zu 16 MB Cache lassen Sie bahnbrechende Performance erleben. Die integrierte AMD Radeon™ Grafikeinheit führt Sie blitzschnell zum Sieg. Spielen Sie Top-Games in flüssigem 1080p direkt ab Werk oder holen Sie sich eine Grafikkarte für noch mehr Leistung.\r\n\r\nMit der Ryzen™ 5000G Serie gehören Hardware-Limits der Vergangenheit an. Mit neuesten Technologien wie Precision Boost 3 und Precision Boost Overdrive wird Ihnen Performance ohne gleichen geboten. Die 5000G-Serie bleibt auch unter Belastung kühl und folgt damit der Tradition der herausragenden Performance der 7nm-Architektur.\r\n\r\nMit einem einfachen BIOS-Update auf AMD 500 Mainboards sowie auf ausgewählten Boards der 400 Serie ist der AMD Ryzen™ 5000G sofort einsatzbereit. Das Konfigurieren Ihres Gaming-PCs wird damit zum Kinderspiel. Installieren Sie AMD StoreMI, um Ihre Festplatte mit der SSD zu kombinieren und Ihre Spiele noch schneller zu laden.\r\n\r\n***ACHTUNG:****\r\nDie Verwendung der CPU ist nur in Verbindung der Mainboards mit AMD 500-Serie Chipsatz sowie ausgewählte Modelle mit B450- und X470-Chipsatz möglich. Bitte prüfen Sie die Kompatibilität auf der Herstellerseite.\r\n\r\n', 51, '288.00', '300.00', 2, '2022-04-13 07:17:50', '2022-04-13 07:17:50', 1),
(32, '16GB G.Skill Aegis DDR4-3200 DIMM CL16 Dual Kit', 'Benannt nach dem mächtigen Schild der griechischen Götter, symbolisiert Aegis Stärke und Macht. Diese neue Ergänzung des DDR4-Speichers zur AEGIS-Gaming-Speicherfamilie wurde für verbesserte Leistung und hohe Stabilität auf den neuesten PC-Gaming-Systemen entwickelt. Geben Sie Ihrem Gaming-Rig die Qualitätsleistungssteigerung, die es verdient, egal für welches Spiel. Ob FPS, RTS, MOBA oder MMORPG - AEGIS Gaming DDR4 Memory ist die Stärke Ihres Gaming-Arsenals!\r\n\r\nVerfügbar ab einer Standard-Startgeschwindigkeit von DDR4-2133MHz, steigern Sie die Leistung Ihres Systems, indem Sie die Anzahl der Übertragungen pro Sekunde erhöhen. Der neue DDR4-Speicher ist mit den Intel® Core™-Prozessoren der 6. Generation kompatibel, um ein reibungsloses Gaming für die neuesten Spiele zu ermöglichen.', 50, '62.00', '71.00', 20, '2022-04-13 07:18:59', '2022-04-14 13:18:36', 1),
(33, '750 Watt be quiet! Straight Power 11 Modular 80+ Gold', 'STRAIGHT POWER 11\r\n750W\r\n\r\nDas be quiet! Straight Power 11 750W setzt neue Maßstäbe für flüsterleise Systeme, ohne auch nur geringste Kompromisse bei der Stromversorgung einzugehen.\r\n\r\nNahezu unhörbarer Silent Wings 3 135mm Lüfter\r\nTrichterförmiger Lufteinlass am Netzteilgehäuse erhöht den Luftdurchsatz\r\nKabelloses Design im Netzteil auf der DC-Seite steigert Kühlung und Langlebigkeit\r\nVollmodulares Kabelmanagement für maximale Flexibilität\r\n80PLUS® Gold Effizienz von bis zu 93%\r\nVier PCI-Express-Anschlüsse für leistungsstarke Multi-GPU-Systeme\r\nJapanische 105°C Kondensatoren sichern einen stabilen, zuverlässigen Betrieb\r\nErfüllt die ErP und Energy Star 6.1 Richtlinien\r\nProduktkonzeption, Design und Qualitätskontrolle in Deutschland', 57, '112.00', '127.00', 31, '2022-04-13 07:20:35', '2022-04-26 06:45:03', 1),
(34, 'MIXIE R520 Maus Drahtlos', 'MIXIE R520 Maus 2,4 GHz Drahtlose Stummschalttaste Einstellbare 800-1600 DPI Tragbare ergonomische Mäuse für Office', 150, '10.00', '10.00', 50, '2022-04-13 07:20:48', '2022-04-13 07:20:48', 1),
(35, '2TB Samsung 970 Evo Plus M.2 2280 PCIe 3.0 x4 3D-NAND TLC (MZ-V7S2T0BW)', 'So wird hohe Leistung noch gesteigert. Die mit modernster V-NAND-Technologie ausgestattete 970 EVO Plus ist noch schneller als die 970 EVO und verfügt zudem über eine Firmware-Optimierung. Damit reizt sie das Potential der PCIe®-Schnittstelle und des NVMe™ Protokolls für noch schnellere Zugriffszeiten voll aus.\r\n\r\nMit bis zu 3.500 MB/s Lese- und bis zu 3.300 MB/s Schreibgeschwindigkeit ist die 970 EVO Plus bis zu 53% schneller als das Vorgängermodell 970 EVO. Die neueste Generation der V-NAND-Technologie sorgt für eine herausragende Leistung und verbesserte Energieeffizienz. Zusätzlich zeichnet sich die 970 EVO Plus durch den bewährten Samsung Controller sowie die Intelligent TurboWrite-Technologie für die Beschleunigung von Schreibvorgängen aus.', 53, '196.00', '196.00', 2, '2022-04-13 07:21:30', '2022-04-13 07:21:30', 1),
(36, 'Logitech G502 Hero', 'Logitech G502 Hero USB schwarz (kabelgebunden)', 151, '49.99', '49.99', 19, '2022-04-13 07:23:14', '2022-04-26 06:45:03', 1),
(37, '2TB Seagate Barracuda Compute ST2000DM008 256MB 3.5', 'Zuverlässige 3,5-Zoll-HDD von Seagate, 2 TB Kapazität, 256 MB Cache, 220 MB/s kontinuierliche Datenübertragungsrate, SATA-6G-Schnittstelle', 53, '45.00', '50.00', 113, '2022-04-13 07:23:15', '2022-04-14 11:48:05', 1),
(38, 'be quiet! Pure Rock 2 Black', 'Mit 150 W Kühlleistung deckt der Pure Rock 2 Black von be quiet!® alle Anforderungen für Multimedia- und Grafikanwendungen ab. Die 4 Heatpipes sind auf maximale Performance ausgelegt und leiten die Hitze des Prozessors in Rekordzeit an den Kühlkörper aus Aluminium. Für die nötige Luftzirkulation sorgt der PMW-Lüfter Pure Wings 2, der die Geräuschkulisse mit strömungsoptimierten Lüfterblättern auf ein Minimum reduziert.\r\n\r\nBeim Kauf des be quiet!® Pure Rock 2 Black können Sie nichts falsch machen: Dank seiner Größe ist der Kühler platzsparend und deshalb mit zahlreichen Gehäusen kompatibel. Auch Ihren RAM installieren Sie sorgenfrei, denn die asymmetrische Bauform bietet genügend Raum für die Speicherbänke. Zusätzlich zum Kühler bekommen Sie ein leicht verständliches Installationskit, mit dem die Montage auf der CPU - egal ob AMD oder Intel® - kein Problem darstellt.\r\n\r\nWenn der Pure Rock 2 Black von be quiet!® Sie nicht schon mit seinem Preis-Leistungs-Verhältnis überzeugt, dann sicherlich mit seiner Optik. Das gebürstete Aluminium mit schwarzem Finish und die hochwertigen Kappen machen den CPU-Kühler zu einem echten Hingucker. Dank schlichter Farbwahl integriert er sich problemlos in jedes System.', 52, '35.00', '41.00', 11, '2022-04-13 07:24:24', '2022-04-14 13:18:36', 1),
(39, 'be quiet! Dark Rock Pro 4 Tower Kühler', 'Der Dark Rock Pro 4 von be quiet!® steht für Kühlperformance der Superlative. Er liefert eine beeindruckende TDP von 250 W - mehr als genug für High-End-CPUs und übertaktete PC-Systeme. Die schnelle Wärmeableitung erfolgt über 7 Kupfer-Heatpipes und luftstromoptimierte Kühllamellen. Selbst unter Höchstauslastung sorgt der CPU-Kühler für niedrige Temperaturen und damit optimale Performance in allen Situationen.\r\n\r\nUm den höchsten Anforderungen gerecht zu werden, setzt be quiet!® beim Dark Rock Pro 4 auf zwei luftstromoptimierte Kühlkörper aus Aluminium mit einer speziellen Keramikpartikel-Beschichtung. Dabei sorgen Aussparungen für eine verbesserte RAM-Kompatibilität. Zum Einsatz kommen außerdem zwei Lüfter, die eine schnelle Luftzirkulation ermöglichen. Einen dritten Lüfter können Sie bei Bedarf nachrüsten. Abgerundet wird das Design von einer Abdeckung aus gebürstetem Aluminium im edlen Diamond-Cut.\r\n\r\nIn gewohnter be quiet!®-Manier setzt der Hersteller auch beim Dark Rock Pro 4 auf einen möglichst leisen Betrieb. Selbst unter Volllast erreicht der CPU-Kühler nur 24,3 db(A). Zu verdanken ist das den Silent-Wings-PWM-Lüftern mit laufruhigen Motoren und langlebigen Fluid-Dynamic-Lagern, die vibrationsisolierend montiert werden. Über die Steuerung können Sie die Lüfterkurve anpassen und so die Systemtemperaturen und die Lautstärke Ihres Systems optimieren.\r\n\r\n', 52, '74.00', '87.00', 53, '2022-04-13 07:26:11', '2022-04-26 06:45:03', 1),
(40, '500GB Samsung 970 Evo Plus M.2 2280 PCIe 3.0 x4 NVMe 1.3 3D-NAND TLC (MZ-V7S500BW)', 'Eine herausragende SSD\r\nSo wird hohe Leistung noch gesteigert. Die mit modernster V-NAND-Technologie ausgestattete 970 EVO Plus ist noch schneller als die 970 EVO und verfügt zudem über eine Firmware-Optimierung. Damit reizt sie das Potential der PCIe-Schnittstelle und des NVMe Protokolls für noch schnellere Zugriffszeiten voll aus. Bei einer Speicherkapazität von 2 TB beträgt die spezifizierte Gesamtschreibdatenmenge (TBW = Total Bytes Written) 1.200 TB TBW.\r\n\r\nLeistung auf dem nächsten Level\r\nMit bis zu 3.500 MB/s1 Lese- und bis zu 3.300 MB/s2 Schreibgeschwindigkeit ist die 970 EVO Plus bis zu 53%3 schneller als das Vorgängermodell 970 EVO. Die neueste Generation der V-NAND-Technologie sorgt für eine herausragende Leistung und verbesserte Energieeffizienz. Zusätzlich zeichnet sich die 970 EVO Plus durch optimierte Firmware, den bewährten Phoenix-Controller sowie die Intelligent TurboWrite-Technologie für die Beschleunigung von Schreibvorgängen aus.\r\n\r\nFlexibilität durch gutes Produktdesign\r\nDie 970 EVO Plus zeigt die Weiterentwicklung im Bereich der NVMe-SSDs. Neben einer hohen Performance bietet sie eine Speicherkapazität von bis zu 2 TB Speicherkapazität im kompakten M.2-Formfaktor (2280). Sie bietet damit viel Speicherplatz bei geringen Abmessungen und spart damit wertvollen Platz für andere Komponenten. Innovative Samsung-Technologien ermöglichen es Ihnen damit, den Freiraum zu haben, den sie benötigen um viel zu erreichen und noch mehr zu bewerkstelligen.\r\n\r\nUnbedingte Zuverlässigkeit\r\nHaben Sie noch mehr Vertrauen. Der bewährte Samsung Phoenix-Controller ist mit einer Schicht aus Nickel überzogen und das Laufwerksmodul der 970 EVO Plus mit einem dünnen Heat Spreader versehen, so dass die entstehende Wärme im Betrieb effektiv abgeführt wird. Darüber hinaus wacht die Dynamic Thermal Guard-Funktion ständig über das Laufwerk, so dass optimale Betriebstemperaturen eingehalten werden und die Performance konstant gehalten werden kann.\r\n\r\nSamsung Magician\r\nSo wird die Laufwerksverwaltung zum Kinderspiel. Die kostenlose Samsung Magician-Software hilft Ihnen dabei, immer ein Auge auf Ihre SSD zu haben. Die benutzerfreundliche Software-Lösung hält das Laufwerk mit Updates immer auf dem neuesten Stand, überwacht Statusparameter und optimiert für Sie die Leistungsfähigkeit.', 53, '66.00', '66.00', 11, '2022-04-13 07:27:32', '2022-04-26 06:19:28', 1),
(41, '18TB Toshiba Enterprise Capacity MG09ACA 512e SATA 6Gb/s', 'Toshiba MG09. HDD Größe: 3.5 Zoll, HDD Kapazität: 18000 GB, HDD Geschwindigkeit: 7200 RPM', 53, '283.00', '283.00', 4, '2022-04-13 07:28:42', '2022-04-13 07:28:42', 1),
(42, '4TB WD Red Plus WD40EFZX 128MB 3.5\" (8.9cm) SATA 6Gb/', 'Schnelle 3,5 Zoll Festplatte mit 4 TB, mit NAS-Technologie und 128 MB Cache, NASware 3.0 und 3D Active Balance Plus-Technologie, heliumgefüllt für maximale Kapazität & Effizienz im Dauerbetrieb, optimiert für NAS- und RAID-Systeme', 53, '89.00', '96.00', 30, '2022-04-13 07:29:58', '2022-04-25 09:02:53', 1),
(43, 'NZXT H710 Midi Tower ohne Netzteil schwarz/rot', 'NEUE FUNKTIONEN: Front-I / O-USB-Typ-C-Anschluss und Seitenwand aus gehärtetem Glas mit Einzelschraubenmontage\r\nMODERNER: Mit einem USB 3.1 Gen 2-kompatiblen USB-C-Anschluss an der Vorderseite ist es einfacher denn je, die neuesten Smartphones, externen Hochgeschwindigkeitsspeicher oder die neuesten Peripheriegeräte an Ihren PC anzuschließen\r\nNOCH SCHÖN: Das klare, moderne Design, die kultige Kabelführungsleiste und die durchgehende Seitenverkleidung aus gehärtetem Glas unterstreichen Ihre beeindruckende Bauweise.\r\nVERBESSERTE KABELVERWALTUNG: Unser patentiertes Kabelverlegungskit mit vorinstallierten Kanälen und Bändern macht die Verkabelung einfach und intuitiv und einfach\r\nSTREAMLINED-KÜHLUNG: Zwei F120-mm-Aer-Lüfter * sorgen für eine optimale Luftzirkulation. Die Frontplatte und die Netzteileinlässe enthalten abnehmbare Filter und eine abnehmbare Halterung für Heizkörper mit bis zu 240 mm Durchmesser', 58, '140.00', '140.00', 10, '2022-04-13 07:34:37', '2022-04-26 06:45:03', 1),
(44, '12 HE Serverschrank', '12 HE Serverschrank, Wandgehäuse, mit Glastür (BxTxH) 600 x 450 x 634mm', 60, '215.00', '215.00', 10, '2022-04-25 08:19:15', '2022-04-25 08:19:15', 1),
(45, 'ASUS PRIME X299-A II ATX Mainboard ', 'ASUS PRIME X299-A II ATX Mainboard Sockel 2066 USB3.1(Typ C-Gen2)/M.2', 56, '350.00', '350.00', 10, '2022-04-25 09:15:26', '2022-04-25 09:15:26', 1),
(46, 'LOGITECH K120 Tastatur', 'LOGITECH K120 Business, Tastatur, kabelgebunden, Schwarz', 153, '12.00', '12.00', 20, '2022-04-25 09:18:32', '2022-04-25 09:18:32', 1),
(47, 'Microsoft Windows 10 Pro 64 Bit Deutsch DSP/SB', 'Seit dem 03.07.2015 im Sortiment\r\n\r\nMicrosoft Windows 10 Pro (64 Bit) in der deutschen DSP/SB-Version auf einer guten alten DVD als Installationsmedium\r\n\r\nTechnische Details:\r\n\r\nVersion: Microsoft Windows 10 Pro 64 Bit, DSP/SB - DVD (deutsch)\r\nSystemvoraussetzungen\r\nProzessor: 1 GHz oder schneller\r\nRAM: 2 GB\r\nFestplattenspeicher: 20 GB\r\nGrafikkarte: Microsoft DirectX 9-Grafikkarte mit WDDM-2.0-Treiber', 8, '128.00', '300.00', 13, '2022-04-25 09:50:12', '2022-04-25 09:52:36', 1),
(48, 'Iceberg Thermal IceSleet G4 OC Black - AM4/Intel (ICESLEETG4OC-BBT-00A', 'Der Iceberg Thermal IceSleet G4 OC wurde für den Mainstream-Gamer entwickelt, der nach der perfekten Mischung aus Qualität, Handwerkskunst und Leistung strebt.\r\n\r\nDie innovative Fan-Slide-Lock Technologie wurde entwickelt, damit Sie sich nicht mehr mit Clips herumschlagen müssen, um Ihren Lüfter am Kühlkörper zu befestigen. Schieben Sie einfach Ihren Lüfter nach unten und Sie können loslegen! Es ist nicht nur einfach, es verbessert auch die RAM-Freigabe.\r\n\r\nDie Ventilatoren sind für die Ewigkeit gebaut. Die Lüfter der Kühler haben TRUE Fluid Dynamic Bearing und sind auf zwei Ebenen ausbalanciert, sodass die Lebensdauer Ihrer Lüfter erheblich verlängert wird. Selbst bei einem Luftstrom von 58,5 CFM hat unser Lüfter mit 600-1400 U/min einen maximalen Geräuschpegel von 22,5 dBA.\r\n\r\nDie Kühler verfügen über 4 symmetrisch abgestimmte und vollständig vernickelte Kühler für ein elegantes Finish dieses sorgfältig gestalteten CPU-Kühlers. Mit einem TDP-Bereich von 140 W bis 180 W ist der G4 OverClock flexibel für Ihre zukünftigen PC-Upgrades.\r\n\r\nMit der ARGB-Funktion können Sie die Farben anpassen, die Sie auf Ihrem CPU-Kühler haben möchten. Der Kühler ist ausgestattet mit 16 ARGB-LEDs, um einen nahtlosen Lichteffekt zu ermöglichen.\r\n\r\n\r\nIceberg Thermal IceSLEET G4 OC. Typ: Kühler, Lüfterdurchmesser: 12 cm, Rotationsgeschwindigkeit (min.): 600 RPM, Rotationsgeschwindigkeit (max.): 1400 RPM, Geräuschpegel (hohe Geschwindigkeit): 22,5 dB, Maximaler Luftstrom: 58,5 cfm, Maximum Luftdruck: 1,5 mmH2O, Lagertyp: Fluid Dynamic Bearing (FDB). Spannung: 5 - 12 V. Breite: 139 mm, Tiefe: 81 mm, Höhe: 156 mm. Produktfarbe: Schwarz', 52, '54.00', '54.00', 153, '2022-04-25 09:54:24', '2022-04-25 09:58:39', 1),
(49, '12GB KFA2 GeForce RTX 3080 Ti SG (1-Click OC) Aktiv PCIe 4.0 x16', 'Die GeForce RTX™ 3080 Ti-GPUs werden von der NVIDIA® Ampere-Architektur angetrieben und bieten einen unglaublichen Sprung in Leistung und Wiedergabetreue mit gefeierten Funktionen wie Raytracing, NVIDIA® DLSS leistungssteigernder KI, NVIDIA® Reflex-Latenzreduzierung, NVIDIA® Broadcast-Streaming-Funktionen und zusätzlichem Speicher. Dies ermöglicht es, auch die beliebtesten Creator-Anwendungen optimal auszuführen.\r\n\r\nDer neue Lüfter-Stopp-Mechanismus überwacht sowohl die GPU- als auch die Speichertemperatur und schaltet die Lüfter intelligent ein und aus, um die perfekte Balance zwischen Geräusch und Leistung zu erzielen. Die Lüfter verfügen über elf innovative Flügellüfterblätter, die nicht nur durch ihr gutes Aussehen überzeugen, sondern auch einen hohen Luftdurchsatz und Luftdruck bei minimalem Geräuschpegel ermöglichen.\r\n\r\nPersonalisieren Sie Ihre RGB-Beleuchtung mit Xtreme Tuner oder synchronisieren Sie die Beleuchtung mit dem Rest Ihrer Komponenten.\r\n\r\n', 54, '1300.00', '1400.00', 1, '2022-04-25 09:56:37', '2022-04-25 09:56:37', 1),
(50, 'Corsair LL Series LL120 RGB 120x120x25mm 2200 U/min 35.9 dB(A) schwarz/weiß', '120-mm-PWM-Lüfter von Corsair, adressierbare Beleuchtung mit 16 RGB-LEDs, 360 - 2.200 U/min, 36 dB(A), max. 107,3 m³/h & 3,00 mmH2O, Hinweis: benötigt LUCS-085', 59, '37.81', '37.81', 199, '2022-04-25 10:05:41', '2022-04-26 06:13:42', 1),
(51, 'Corsair SP Series, SP120 RGB ELITE, 120mm RGB LED Fan with AirGuide, Single Pack, weiss', '120 x 120 x 25 / Hydraulic / 18-26.5 dBA / 4-pin', 59, '16.34', '16.34', 200, '2022-04-25 11:18:46', '2022-04-26 06:13:42', 1),
(52, 'Corsair iCUE QL140 (CO-9050105-WW) RGB LED PWM Single Fan weiss', 'Corsair iCUE QL140. Typ: Ventilator, Lüfterdurchmesser: 14 cm, Rotationsgeschwindigkeit (min.): 550 RPM, Rotationsgeschwindigkeit (max.): 1250 RPM, Geräuschpegel (hohe Geschwindigkeit): 26 dB, Maximaler Luftstrom: 50,2 cfm, Maximum Luftdruck: 1,4 mmH2O, Lagertyp: Hydraulisch. Spannung: 6 - 13.2 V. Produktfarbe: Weiß', 59, '35.50', '35.50', 200, '2022-04-25 11:21:50', '2022-04-26 06:13:42', 1),
(53, 'Corsair LL120 RGB 120x120x25mm 1500 U/min 24.8 dB(A) schwarz', 'Der CORSAIR LL120 RGB-Lüfter ist maßgeschneidert für Benutzer, die einen hervorragenden Luftstrom, einen leisen Betrieb und eine leistungsstarke Beleuchtung suchen, und macht deinen PC wieder flott.', 59, '26.77', '26.77', 2000, '2022-04-25 11:28:19', '2022-04-26 06:13:42', 1),
(54, 'Corsair ML Series 120 Pro RGB LED Premium Magnetic Levitation Fan 120x120x25mm 400-1600 U/min 25 dB(A) schwarz', 'Der CORSAIR ML120 PRO RGB-PWM-Lüfter vereint einzigartige Performance und geräuscharmen Betrieb mit einer lebendigen RGB-Beleuchtung, die in der CORSAIR LINK-Software gesteuert wird.', 59, '31.35', '31.35', 2000, '2022-04-25 11:31:09', '2022-04-26 06:13:42', 1),
(55, 'Corsair iCUE QL140 RGB PWM, 140mm (CO-9050099-WW)', 'Corsair CO-9050099-WW. Typ: Ventilator, Lüfterdurchmesser: 14 cm, Rotationsgeschwindigkeit (max.): 1250 RPM, Geräuschpegel (hohe Geschwindigkeit): 26 dB, Maximaler Luftstrom: 41,8 cfm, Maximum Luftdruck: 1,4 mmH2O, Lagertyp: Hydraulisch. Spannung: 6 - 13.2 V. Produktfarbe: Schwarz, Grau', 59, '39.85', '39.85', 1020, '2022-04-25 11:33:24', '2022-04-26 06:13:42', 1),
(56, 'Roccat Sense AIMO Gaming Mauspad', 'Roccat Sense AIMO Gaming Mauspad - AIMO LED Beleuchtung, Höchstmaß an Präzision, gummierte Unterseite, (350 mm x 250 mm x 3,5 mm), schwarz', 152, '39.99', '39.99', 25, '2022-04-26 06:06:03', '2022-04-26 06:06:03', 1),
(57, 'ROCCAT Gaming-Tastatur', 'ROCCAT Vulcan TKL Pro Gaming-Tastatur', 154, '149.95', '149.95', 5, '2022-04-26 06:10:35', '2022-04-26 06:10:35', 1),
(58, 'Logitech G Saitek Farm Sim Controller', 'Logitech G Saitek Farm Sim Controller, Farming Simulator Bundle bestehend aus Lenkrad, Steuerkonsole, Gas- und Bremspedal, 900° Lenkbereich, 38+ Tasten, USB-Anschluss, PC/Mac - Schwarz', 156, '160.00', '160.00', 5, '2022-04-26 06:13:57', '2022-04-26 06:13:57', 1),
(59, 'Superdrive - Rennlenkrad SV750', 'Superdrive - Rennlenkrad SV750 Drive Pro Sport Lenkrâd mit Pedal, Shift und Vibration - Xbox Serie X/S, PS4, Xbox One, Switch, PC', 156, '130.00', '130.00', 10, '2022-04-26 06:18:20', '2022-04-26 06:18:20', 1),
(60, 'JBL TUNE 760NC - Over-Ear Kopfhörer', 'JBL TUNE 760NC - Over-Ear Bluetooth-Kopfhörer, Noise Cancelling, schwarz', 251, '129.99', '129.99', 10, '2022-04-26 06:22:34', '2022-04-26 06:22:34', 1),
(61, 'Sony WH-CH710N kabellose Bluetooth-Kopfhörer', 'Sony WH-CH710N kabellose Bluetooth Noise Cancelling Kopfhörer (bis zu 35 Stunden Akkulaufzeit, Around-Ear-Style, Freisprecheinrichtung, Headset mit Mikrofon, wireless) Schwarz', 251, '120.00', '120.00', 10, '2022-04-26 06:26:31', '2022-04-26 06:26:31', 1),
(62, 'Hama Monitorhalterung für 2 Monitore 13 – 35 Zoll', 'Hama Monitorhalterung für 2 Monitore 13 – 35 Zoll (Monitorhalter höhenverstellbar bis 40 cm, schwenkbar 180°, neigbar +/- 35°, ausziehbar, Bildschirmhalterung 15 kg Traglast, VESA 75 x75, 100 x 100)', 105, '94.99', '94.99', 15, '2022-04-26 06:38:45', '2022-04-26 06:38:45', 1);

-- --------------------------------------------------------

--
-- Table structure for table `products_types`
--

CREATE TABLE `products_types` (
  `id` int(10) NOT NULL,
  `parent_id` int(10) DEFAULT NULL,
  `type` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `products_types`
--

INSERT INTO `products_types` (`id`, `parent_id`, `type`, `created_at`, `updated_at`) VALUES
(1, 0, 'Hardware', '2022-02-07 14:22:54', '2022-03-12 18:32:20'),
(2, 0, 'Monitore', '2022-03-12 18:39:16', '2022-03-12 18:40:58'),
(3, 0, 'Peripherie', '2022-03-12 18:49:04', '2022-03-12 18:49:04'),
(4, 0, 'Netzwerktechnik', '2022-03-12 18:53:02', '2022-03-12 18:53:02'),
(5, 0, 'Audio', '2022-03-12 18:56:55', '2022-03-12 18:56:55'),
(6, 0, 'Zubehör', '2022-03-12 19:49:43', '2022-04-25 09:50:59'),
(7, 6, 'Wartung', '2022-03-23 19:03:10', '2022-04-25 09:52:03'),
(8, 6, 'Software', '2022-04-25 09:47:37', '2022-04-25 09:52:11'),
(50, 1, 'Arbeitsspeicher', '2022-03-11 10:34:41', '2022-03-12 18:39:38'),
(51, 1, 'CPUs', '2022-03-11 10:34:57', '2022-03-12 18:39:43'),
(52, 1, 'CPU Kühler', '2022-03-11 10:43:53', '2022-03-12 18:39:48'),
(53, 1, 'Festplatten & SSDs', '2022-03-11 10:43:53', '2022-03-12 18:39:54'),
(54, 1, 'Grafikkarten', '2022-02-10 04:36:35', '2022-03-12 18:39:59'),
(55, 1, 'Laufwerke', '2022-03-11 10:43:53', '2022-03-12 18:41:10'),
(56, 1, 'Mainboards', '2022-03-11 10:43:53', '2022-03-12 18:41:17'),
(57, 1, 'Netzteile', '2022-03-11 10:43:53', '2022-03-12 18:41:24'),
(58, 1, 'Gehäuse', '2022-03-11 10:43:53', '2022-03-12 18:41:45'),
(59, 1, 'Kühlung', '2022-03-11 10:43:53', '2022-03-12 18:41:54'),
(60, 1, 'Serverschrank', '2022-03-11 10:43:53', '2022-03-12 18:42:10'),
(100, 2, '24 Zoll', '2022-03-11 10:43:53', '2022-03-12 18:44:03'),
(101, 2, '27 Zoll', '2022-03-11 10:43:53', '2022-03-12 18:49:50'),
(102, 2, '32 Zoll', '2022-03-11 10:43:53', '2022-03-12 18:49:57'),
(103, 2, '34 Zoll', '2022-03-11 10:43:53', '2022-03-12 18:49:57'),
(104, 2, '49 Zoll', '2022-03-11 10:43:53', '2022-03-12 18:49:57'),
(105, 2, 'Monitorzubehör', '2022-03-11 10:43:53', '2022-03-13 17:59:58'),
(106, 2, 'High-End', '2022-03-13 18:00:09', '2022-03-13 18:00:09'),
(150, 3, 'Office-Mäuse', '2022-03-11 10:43:53', '2022-03-12 18:52:34'),
(151, 3, 'Gaming-Mäuse', '2022-03-11 10:43:53', '2022-03-12 18:52:26'),
(152, 3, 'Mauspads', '2022-03-11 10:43:53', '2022-03-12 18:51:34'),
(153, 3, 'Office-Tastaturen', '2022-03-11 10:43:53', '2022-03-12 18:51:46'),
(154, 3, 'Gaming-Tastaturen', '2022-03-11 10:43:53', '2022-03-12 18:51:53'),
(155, 3, 'Joystick', '2022-03-11 10:43:53', '2022-03-12 18:52:03'),
(156, 3, 'Lenkräder', '2022-03-11 10:43:53', '2022-03-12 18:52:12'),
(157, 3, 'Controller', '2022-03-11 10:43:53', '2022-03-12 18:52:47'),
(158, 3, 'USB-Hubs', '2022-03-11 10:43:53', '2022-03-12 18:55:37'),
(200, 4, 'Access-Points', '2022-03-11 10:43:53', '2022-03-12 18:53:20'),
(201, 4, 'Bluetooth Adapter', '2022-03-11 10:43:53', '2022-03-12 18:53:29'),
(202, 4, 'Netzwerkswitches', '2022-03-11 10:43:53', '2022-03-12 18:53:47'),
(203, 4, 'Router', '2022-03-11 10:43:53', '2022-03-12 18:54:01'),
(204, 4, 'WLAN Repeater', '2022-03-11 10:43:53', '2022-03-12 18:54:12'),
(250, 5, 'Headsets', '2022-03-11 10:43:53', '2022-03-12 18:55:49'),
(251, 5, 'Kopfhörer', '2022-03-11 10:43:53', '2022-03-12 18:55:59'),
(252, 5, 'Mikrofone', '2022-03-11 10:43:53', '2022-03-12 18:56:06'),
(253, 5, 'Lautsprecher', '2022-03-11 10:43:53', '2022-03-12 18:56:15'),
(254, 5, 'Soundbar', '2022-03-11 10:43:53', '2022-03-12 18:56:24'),
(255, 5, 'Soundkarten', '2022-03-11 10:43:53', '2022-03-12 18:56:29');

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
(9, 'High-end-monitor.jpg', 8),
(10, 'CapOwhpQaQn8MquiO5nNNe.webp', 8),
(16, 'image_6253d842d403e_monitor.png', 13),
(17, 'image_6253d8cd95357_lenovo-d27-30.jpg', 14),
(19, 'image_625670bdaf9e9_323223.jpg', 15),
(20, 'image_625672efae726_343434.jpg', 16),
(21, 'image_625673ea8886e_1325223_0__8935272.jpg', 17),
(22, 'image_625673ea8a767_1325223_1__8935272-1.jpg', 17),
(23, 'image_6256748cf1c46_1380727_0__74529.jpg', 18),
(24, 'image_6256748d01e2f_1380727_1__74529-1.jpg', 18),
(25, 'image_6256749e5edc5_81Z4sem5oJL._AC_SY450_.jpg', 19),
(26, 'image_6256753a2e908_1380726_0__74528.jpg', 20),
(27, 'image_6256759030b9d_1380728_1__74530-1.jpg', 21),
(28, 'image_625675a3ad8d2_18290067134-1600-2wtClJdJy4Xs3E.jpg', 22),
(29, 'image_625675dde3982_1401241_2__75135-2.jpg', 23),
(30, 'image_625675dde46c4_1401241_1__75135-1.jpg', 23),
(31, 'image_625675dde6466_1401241_0__75135.jpg', 23),
(32, 'image_62567616186d4_1419324_0__70406.jpg', 24),
(33, 'image_62567663213a1_320_asset_mms_76742273_fee_786_587_png.jpg', 25),
(34, 'image_62567682874db_1358986_7__74112-8.jpg', 26),
(35, 'image_6256768288064_1358986_6__74112-6.jpg', 26),
(36, 'image_6256768289018_1358986_5__74112-5.jpg', 26),
(37, 'image_625676828a13d_1358986_4__74112-4.jpg', 26),
(38, 'image_625676828ab29_1358986_3__74112-3.jpg', 26),
(39, 'image_625676828b46a_1358986_2__74112-2.jpg', 26),
(40, 'image_625676828bd47_1358986_1__74112-1.jpg', 26),
(41, 'image_625676828f00b_1358986_0__74112.jpg', 26),
(42, 'image_6256776c3ad57_1292800_0__72488.jpg', 27),
(43, 'image_6256776c3bb64_1292800_1__72488-1.jpg', 27),
(44, 'image_625677aabda7c_1374976_0__74300.jpg', 28),
(45, 'image_62567884d0563_1290084_0__72355.jpg', 29),
(46, 'image_625678c2aae77_1440079_0__72436.jpg', 30),
(47, 'image_6256791e8033e_1419174_1__70405-1.jpg', 31),
(48, 'image_6256796339567_1332120_1__8941948-1.jpg', 32),
(49, 'image_6256796339e2f_1332120_0__8941948.jpg', 32),
(50, 'image_625679c364bb4_1223022_6__8836863-6.jpg', 33),
(51, 'image_625679c365831_1223022_5__8836863-5.jpg', 33),
(52, 'image_625679c36608e_1223022_3__8836863-4.jpg', 33),
(53, 'image_625679c366aee_1223022_0__8836863.jpg', 33),
(54, 'image_625679d082afd_mixie-r520-mouse-2-4ghz-wireless-mute-button-adjustable-800-1600dpi-portable-ergonomic-mice-for-office-business-pc-laptop.jpg', 34),
(55, 'image_625679fa5e11b_1310140_0__66640305_3366121081.jpg', 35),
(56, 'image_62567a62234bb_1289657_0__8901273.jpg', 36),
(57, 'image_62567a639f896_1233627_0__8847114.jpg', 37),
(58, 'image_62567aa80bd51_1359907_3__74129-3.jpg', 38),
(59, 'image_62567aa80c5fb_1359907_0__74129.jpg', 38),
(60, 'image_62567b13a87d3_1237725_5__8850997-5.jpg', 39),
(61, 'image_62567b13a9183_1237725_4__8850997-4.jpg', 39),
(62, 'image_62567b13aa0c5_1237725_3__8850997-3.jpg', 39),
(63, 'image_62567b13abab7_1237725_0__8850997.jpg', 39),
(64, 'image_62567b6451bb7_1292721_7__72487-7.jpg', 40),
(65, 'image_62567b6452459_1292721_5__72487-5.jpg', 40),
(66, 'image_62567b6452a64_1292721_4__72487-4.jpg', 40),
(67, 'image_62567b6452f9e_1292721_0__72487.jpg', 40),
(68, 'image_62567baa966eb_1424019_0__89583223_7206678036.jpg', 41),
(69, 'image_62567bf65faa6_1393203_0__9000198.jpg', 42),
(70, 'image_62567d0da172a_1325888_2__8935902-2.jpg', 43),
(71, 'image_62567d0da1e16_1325888_4__8935902-4.jpg', 43),
(72, 'image_62567d0da24f4_1325888_6__8935902-6.jpg', 43),
(73, 'image_62567d0da2b89_1325888_9__8935902-9.jpg', 43),
(74, 'image_62567d0da3192_1325888_0__8935902.jpg', 43),
(75, 'image_62567d786fb5d_schema_org_16_9.jpg', 11),
(76, 'image_626659832e95e_ds6412_voorkant (1).jpg', 44),
(77, 'image_626666aec6870_Mainooooard.jpg', 45),
(78, 'image_626667681325b_image.jpg', 46),
(79, 'image_62666ed4e9bf5_1008331_0__8631259.jpg', 47),
(80, 'image_62666fd01adac_1434640_3__9040176-3.jpg', 48),
(81, 'image_62666fd01b6c2_1434640_1__9040176-1.jpg', 48),
(82, 'image_62666fd01be85_1434640_0__9040176.jpg', 48),
(83, 'image_626670555f898_1414346_4__70027-4.jpg', 49),
(84, 'image_6266705560210_1414346_3__70027-3.jpg', 49),
(85, 'image_626670556092f_1414346_1__70027-1.jpg', 49),
(86, 'image_6266705560f36_1414346_0__70027.jpg', 49),
(91, 'image_626672755e0cd_51293465_0__8904809.jpg', 50),
(92, 'image_6266728ddf2a4_41293465_1__8904809-1.jpg', 50),
(93, 'image_62667297623f6_31293465_2__8904809-2.jpg', 50),
(94, 'image_626672a1daf5f_21293465_3__8904809-3.jpg', 50),
(95, 'image_626672aeccdf0_11293465_4__8904809-4.jpg', 50),
(96, 'image_62668396723f4_1406034_0__9012435.jpg', 51),
(97, 'image_6266839676a6b_1406034_1__9012435-1.jpg', 51),
(98, 'image_6266839677481_1406034_2__9012435-2.jpg', 51),
(99, 'image_6266839677aba_1406034_3__9012435-3.jpg', 51),
(100, 'image_62668396780c6_1406034_4__9012435-4.jpg', 51),
(101, 'image_6266844e45165_1351961_0__8960821.jpg', 52),
(102, 'image_6266844e45ad3_1351961_1__8960821-1.jpg', 52),
(103, 'image_6266844e46420_1351961_2__8960821-2.jpg', 52),
(104, 'image_6266844e46bc3_1351961_3__8960821-3.jpg', 52),
(105, 'image_6266844e47327_1351961_4__8960821-4.jpg', 52),
(106, 'image_626685d39833d_1202395_0__38224224_8441623204.jpg', 53),
(107, 'image_626685d398bdb_1202395_1__38224224_3891528397.jpg', 53),
(108, 'image_626685d399f25_1202395_2__38224224_4358007567.jpg', 53),
(109, 'image_626685d39a8d8_1202395_3__38224224_1360212160.jpg', 53),
(110, 'image_626685d39b0db_1202395_4__38224224_8630106049.jpg', 53),
(111, 'image_626685d39b8e1_1202395_5__38224224_2779476454.jpg', 53),
(112, 'image_626685d39c0c0_1202395_6__38224224_4323443170.jpg', 53),
(113, 'image_626685d39c939_1202395_7__38224224_8834690570.jpg', 53),
(114, 'image_626685d39d157_1202395_8__38224224_9579319797.jpg', 53),
(115, 'image_626685d39dc3f_1202395_9__38224224_1525803886.jpg', 53),
(116, 'image_6266867d0fbfc_1216313_0__39302413_0506537755.jpg', 54),
(117, 'image_6266867d1056b_1216313_1__39302413_5561804988.jpg', 54),
(118, 'image_6266867d112dc_1216313_2__39302413_2028748782.jpg', 54),
(119, 'image_6266867d11998_1216313_3__39302413_9510222928.jpg', 54),
(120, 'image_6266867d12046_1216313_4__39302413_5890025330.jpg', 54),
(121, 'image_6266867d155e6_1216313_5__39302413_5991831995.jpg', 54),
(122, 'image_6266867d15d5d_1216313_6__39302413_8422898108.jpg', 54),
(123, 'image_6266867d16508_1216313_7__39302413_0237180659.jpg', 54),
(124, 'image_6266867d16cf6_1216313_8__39302413_2279244352.jpg', 54),
(125, 'image_6266867d17497_1216313_9__39302413_8170766640.jpg', 54),
(126, 'image_626687049685d_1339796_0__8949367.jpg', 55),
(127, 'image_6266870497070_1339796_1__8949367-1.jpg', 55),
(128, 'image_6266870497711_1339796_2__8949367-2.jpg', 55),
(129, 'image_6266870497e93_1339796_3__8949367-3.jpg', 55),
(130, 'image_6266870498748_1339796_4__8949367-4.jpg', 55),
(131, 'image_6266870499577_1339796_5__8949367-5.jpg', 55),
(132, 'image_6266870499e8d_1339796_6__8949367-6.jpg', 55),
(133, 'image_626687049aa0b_1339796_7__8949367-7.jpg', 55),
(134, 'image_626687049b466_1339796_8__8949367-8.jpg', 55),
(135, 'image_62678bcb6a4bd_A1+-s-uZ3xL._AC_SX450_.jpg', 56),
(136, 'image_62678cdb3a82d_roccat-vulcan-tkl-pro-gaming-tastatur-608523.jpg', 57),
(137, 'image_62678da55ae95_61dPleuUgmS._AC_SX679_.jpg', 58),
(138, 'image_62678eac19979_71hOE+eDCyS._SX522_.jpg', 59),
(139, 'image_62678faa7664a_210617091926600701900079K.jpg', 60),
(140, 'image_62679097e0a5c_51JnfYw9-tL._AC_SY450_.jpg', 61),
(141, 'image_626793754e57d_41iTU4Cn6fL._AC_SX679_.jpg', 62);

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
(57, 1, 8, 5),
(58, 6, 11, 1),
(78, 21, 8, 2),
(82, 23, 8, 1),
(91, 36, 8, 1),
(93, 39, 11, 24),
(94, 38, 11, 19),
(111, 47, 32, 2),
(113, 47, 38, 1),
(114, 47, 40, 1),
(116, 47, 24, 1),
(117, 47, 33, 1),
(118, 47, 43, 1),
(119, 47, 19, 1),
(120, 47, 36, 1),
(121, 47, 22, 1),
(122, 47, 29, 1),
(125, 46, 42, 1),
(134, 53, 42, 1),
(135, 53, 17, 1),
(137, 53, 27, 1),
(139, 54, 50, 1),
(140, 54, 43, 1),
(152, 59, 14, 1);

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
(1, 2, '57ffdb9d05d4ba6ffff84e3de7404eaa', 'f2c8e5c951709fa9287a06707b1a463c96af9079', '2022-03-30 13:19:17'),
(2, 2, '96a1e0a70cb3c1d4e05c03693ed6fb00', '7a3ffecebeadc5fd1633496e1c70a3ece4a18090', '2022-03-30 20:05:42'),
(5, 2, '7bc72843a0e21cfd993be714c10e1835', '5e1fd0bcfaa7c2029c368bf8c990ac38c757f468', '2022-03-30 20:50:15'),
(6, 3, 'fd678cd181897c725a415e9a346ba82e', 'd15cdabf301da4dc62abf6910e167c8fcc6a8b47', '2022-04-04 10:39:09'),
(8, 3, '9436cf4a5d6bd4ff9b99bc0c2d79b1d2', 'a4cd7c29e939dad5312a6167f385867d9254235f', '2022-04-04 20:52:40'),
(9, 3, '1974ad8e969b574ae2acff4f844701e4', 'c0e136c542104ffd34c3bb6c618132c75c0346f8', '2022-04-06 10:34:18'),
(11, 2, 'ee3e96af1b4abbd4dd6d03b6092c0672', '3230b326f9e07f8eab96514e579c82ed0a9b8741', '2022-04-08 18:10:31'),
(12, 3, 'b68287ff4ae14915dbe02501b8baa059', 'fe52e1309664dabd53eaccd2d4437df02f63f794', '2022-04-11 07:57:11'),
(13, 3, 'deee7a788f2f0967b8bf3e2fa2891b99', '201c9deb6baccb777a53a32d618136e89e3fb37e', '2022-04-11 08:00:02'),
(14, 52, 'cd506f53fbc30de7aad2029a28d7fbe4', '3e816157cf4b88e8b9174517a050e639f6519ed2', '2022-04-11 08:30:31'),
(15, 2, '23291c091d9234063f8dfff289e49fd8', 'acd1cbaf42f769349966ece9c249285171ec9bf7', '2022-04-11 11:55:20'),
(17, 3, 'ed2b4635643b7654aa1e0ef277b71660', 'd47179d97584447eb9f0520fab16bb7f1caf4e2c', '2022-04-11 16:07:46'),
(18, 53, 'f689a5ef42404f42f6ac2923fa41b854', '01e7b19ad08383a1efcb82106584496229aabe52', '2022-04-12 10:03:02'),
(19, 3, '3ee0706ff1d9060f0f8eaddfaf813e42', '44da6f560edbd429104a13f46011b100b2555e8b', '2022-04-12 10:04:38'),
(20, 2, '050906da162cbe36d69a40c234cf6b38', '09842a0149a05c6020a7c3d1fd51a6a9df17ddb4', '2022-04-12 10:12:46'),
(23, 3, 'a58ff898f69030ae54a7e55b5675d2b9', 'b912627777b6798514a0b3e7939ed19eb54a784c', '2022-04-12 12:32:02'),
(24, 2, 'd7a766e692bb27980b77feab7254370d', '8a71f47639ae2cade285df3d1fc567f0102635d8', '2022-04-13 08:32:08'),
(25, 5, '28a4849198b6501445ed4293bedb8775', '35cf4417fe220105ec748c52c724fe8f0d3e7333', '2022-04-13 08:48:26'),
(26, 5, '4a931fdd09453877927a28cc9ecbc508', '6df66dab47743184643acbedfa6706730b37800e', '2022-04-13 09:33:09'),
(27, 3, 'fb32875c037c8be50f78255466726e97', 'e35faa3a2d4b02070e299eb78910a3d3f7ac50bb', '2022-04-16 18:08:02'),
(29, 3, '47d25852935410eae3293b33c63c1fde', '70ace270361be57cfdb008c2877d8ec0fed6182a', '2022-04-25 09:05:40'),
(30, 2, 'c76e34ec8f49e242cdd714877e8f0b47', '5995048c8c07cf64f4ca47e9e998ac5f4838c48d', '2022-04-25 09:09:10'),
(31, 3, '6f72adba637fb83eec05a4a81baa55c8', 'ed42cd5b48422c05a8c739d9f252f971f70fd780', '2022-04-25 09:13:21'),
(32, 3, '1e35ccf595b28e7d5877965319b15e23', '805eeaa65432e67abc2dd3e0dab6431439fbc18b', '2022-04-25 09:14:33'),
(33, 2, '6b720539d85cf40ad95d7e5d5e925c2d', '590ae186bba4484c226ad31d4f85cdd42e03953f', '2022-04-25 09:16:26'),
(35, 2, '141aa0ccb591fbf06fe17d46cdaf4fed', 'db7747da7b8bd45bc4fdd554c805ea8b1fdba108', '2022-04-25 09:21:07'),
(36, 55, 'b7651f30856bec4ade02c56f3d3d9cf9', 'd6dc25e5103fc5a6ba6f8d94b9012784c8e803fa', '2022-04-25 10:14:21'),
(37, 3, '5dafdc67266ce1e5806571e980cd2219', '5e8cc29e246f4bcd474cac8d769cefbb3d66254d', '2022-04-25 10:48:12'),
(38, 55, '8048870f024b87cb484b80dbf5674e5e', 'e12fa4968a798f8d310cc3ea1d9cd122669a094c', '2022-04-25 10:48:17'),
(39, 5, 'f6c4edf4080704fd2d39afd92a1b06c0', 'a37305b91401c6cdf578717098a74fce25887170', '2022-04-25 10:48:45'),
(40, 2, '4f46d537aae24c3f9b9ac1702b8eb7fa', '3f70542cc5bcf1254514e3d38ab4fceb2491d44b', '2022-04-25 11:02:29'),
(41, 55, '1e5b6e21aba01363ae780572f848888a', 'e4032230d95d7f503217363ca5417db28041dd2c', '2022-04-25 11:13:58');

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
(1, 'admin@delta-hardware.de', '$2y$1$2y$10$SfhYIDtn.iOuCW7zfoFLuuZHX6lja4lF4XA4JqNmpiH/.P3zB8JCa0$SfhYIDtn.iOu$2y$10$SfhYIDtn.iOuCW7zfoFLuuZHX6lja4lF4XA4JqNmpiH/.P3zB8JCa$2y$10$SfhYIDtn.iOuCW7zfoFLuuZHX6lja4lF4XA4JqNmp$2y$10$SfhYIDtn.iOuCW7zfoFLuuZH', 'Admin', 'User', '2022-02-04 07:57:26', '2022-04-25 06:08:37', NULL, NULL, 1),
(2, 'ich@paul-vassen.de', '$2y$10$AjGihIboyCYY/gnDq7J08.spp4N6Du.wog2anlhRsFALSZj9DPrPq', 'Paul', 'Vaßen', '2022-02-04 15:34:37', '2022-03-30 09:45:13', NULL, NULL, 2),
(3, 'jan@schniebs.com', '$2y$10$xlYaMlJc0JLTBAhHLrgC5.Y1ECi5y8IbxBY74W4nzCmuNLio.NwFO', 'Jan', 'Schniebs', '2022-02-23 07:14:00', '2022-04-25 09:26:07', NULL, NULL, 2),
(5, 'g.einkaufstute@edeka.de', '$2y$10$/ldJ25RAMZluANTOcQKj8O0W0HJAHKz.8XBpChFmdd78C6kDTpTnC', 'Gerhard', 'Einkaufstüte', '2022-02-23 09:36:25', '2022-04-25 08:48:51', NULL, NULL, 2),
(51, 'nico@nico.de', '$2y$10$LkKrTIzF8e11d.avACuKjugw9RkQoFQdulrCh1yfN6pCIwWzBwpeC', 'Nico', 'Nö', '2022-04-07 08:22:55', '2022-04-25 07:28:50', NULL, NULL, 3),
(52, 'jan@jantest.com', '$2y$10$VtBT4HBOtU/hfg2.ta3tTev7JFEFnYV3aa0r2kk9RLRkw9NKTHvBS', 'Jan', 'Test', '2022-04-11 06:30:18', '2022-04-25 07:28:41', NULL, NULL, 3),
(53, 'apfel@peter.com', '$2y$10$4ocSyv2Onn1qQQQMQG4XZOv3gno9e52nvNM9egoIGrt.eVC21kWcW', 'Peter', 'Lustig', '2022-04-12 08:02:45', '2022-04-12 08:04:17', NULL, NULL, 1),
(54, 't@te.de', '$2y$10$ZI8lof9xCoZXRzcCEm4Vh.nG7lxln5Y3Xngr1kpCC4KOfSwkFjUC2', 't1', 't2', '2022-04-18 10:19:56', '2022-04-18 10:19:56', NULL, NULL, 1),
(55, 'ajan@test.com', '$2y$10$nye26RCQ3UCZ6KoxzITH5.2x0O94OEUYHUcblUBxc5neIn.nYAUla', 'jan', 'test', '2022-04-25 08:14:14', '2022-04-25 08:15:01', NULL, NULL, 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `address`
--
ALTER TABLE `address`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `citys_id` (`citys_id`);

--
-- Indexes for table `citys`
--
ALTER TABLE `citys`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kunden_id` (`kunden_id`),
  ADD KEY `rechnungsadresse` (`rechnungsadresse`),
  ADD KEY `leiferadresse` (`lieferadresse`);

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
-- AUTO_INCREMENT for table `address`
--
ALTER TABLE `address`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `citys`
--
ALTER TABLE `citys`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `permission_group`
--
ALTER TABLE `permission_group`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `products_types`
--
ALTER TABLE `products_types`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=256;

--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=142;

--
-- AUTO_INCREMENT for table `product_list`
--
ALTER TABLE `product_list`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=154;

--
-- AUTO_INCREMENT for table `securitytokens`
--
ALTER TABLE `securitytokens`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `address`
--
ALTER TABLE `address`
  ADD CONSTRAINT `address_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `address_ibfk_2` FOREIGN KEY (`citys_id`) REFERENCES `citys` (`id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`kunden_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`rechnungsadresse`) REFERENCES `address` (`id`),
  ADD CONSTRAINT `orders_ibfk_3` FOREIGN KEY (`lieferadresse`) REFERENCES `address` (`id`);

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

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`permission_group`) REFERENCES `permission_group` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
