-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 14, 2020 at 05:35 PM
-- Server version: 10.2.32-MariaDB-log-cll-lve
-- PHP Version: 7.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `laravelm_deaamartya`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`laravelm`@`localhost` PROCEDURE `getMonths` ()  BEGIN
SELECT DATE_FORMAT(nota_date,"%b") as namabulan
FROM `sales`
GROUP BY MONTH(nota_date);
END$$

CREATE DEFINER=`laravelm`@`localhost` PROCEDURE `getTopSales` ()  BEGIN
SELECT categories.category_name,count(sales_detail.nota_id) as total_penjualan
FROM sales_detail
JOIN product on product.product_id = sales_detail.product_id
JOIN categories on categories.category_id = product.category_id
WHERE product.category_id = categories.category_id
GROUP BY product.category_id
ORDER BY total_penjualan DESC
LIMIT 4;
END$$

--
-- Functions
--
CREATE DEFINER=`laravelm`@`localhost` FUNCTION `getEarning` (`mon` VARCHAR(20), `year` CHAR(4)) RETURNS INT(11) BEGIN
DECLARE total int; 
SELECT SUM(total_payment)
INTO total FROM sales
WHERE (DATE_FORMAT(nota_date,"%M") = mon OR DATE_FORMAT(nota_date,"%b") = mon)AND DATE_FORMAT(nota_date,"%Y") = year;
RETURN total;
END$$

CREATE DEFINER=`laravelm`@`localhost` FUNCTION `penjualanBulanIni` () RETURNS INT(11) BEGIN
DECLARE total int; 
SELECT IFNULL(SUM(total_payment),0) INTO total FROM sales
WHERE DATE_FORMAT(nota_date,"%M") = DATE_FORMAT(CURRENT_DATE,"%M")
GROUP BY DATE_FORMAT(nota_date,"%M");
RETURN total;
END$$

CREATE DEFINER=`laravelm`@`localhost` FUNCTION `penjualanTahunIni` () RETURNS INT(11) BEGIN
DECLARE total int; 
SELECT IFNULL(SUM(total_payment),0) INTO total FROM sales
WHERE DATE_FORMAT(nota_date,"%Y") = DATE_FORMAT(CURRENT_DATE,"%Y")
GROUP BY DATE_FORMAT(nota_date,"%Y");
RETURN total;
END$$

CREATE DEFINER=`laravelm`@`localhost` FUNCTION `totalPenjualan` () RETURNS INT(11) BEGIN
DECLARE total int; 
SELECT IFNULL(SUM(total_payment),0) INTO total FROM sales;
RETURN total;
END$$

CREATE DEFINER=`laravelm`@`localhost` FUNCTION `totalProdukTerjual` () RETURNS INT(11) BEGIN
DECLARE total int; 
SELECT IFNULL(SUM(quantity),0) INTO total FROM sales_detail;
RETURN total;
END$$

CREATE DEFINER=`laravelm`@`localhost` FUNCTION `totalProdukTerjualBulanIni` () RETURNS INT(11) BEGIN
DECLARE total int; 
SELECT SUM(quantity) INTO total FROM sales_detail
JOIN sales s ON sales_detail.nota_id = s.nota_id
WHERE DATE_FORMAT(s.nota_date,"%M") = DATE_FORMAT(CURRENT_DATE,"%M")
GROUP BY DATE_FORMAT(s.nota_date,"%M");
RETURN total;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` char(10) COLLATE utf8_unicode_ci NOT NULL,
  `category_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `category_name`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
('CAT0000001', 'Pakaian Pria', 1, NULL, NULL, NULL),
('CAT0000002', 'Pakaian Wanita', 1, NULL, NULL, NULL),
('CAT0000003', 'Handphone & Aksesoris', 1, NULL, NULL, NULL),
('CAT0000004', 'MakeUp', 1, NULL, NULL, NULL),
('CAT0000005', 'Komputer & Aksesoris', 1, NULL, NULL, NULL),
('CAT0000006', 'Perlengkapan Rumah', 1, NULL, NULL, NULL),
('CAT0000007', 'Fashion Bayi & Anak', 1, NULL, NULL, NULL),
('CAT0000008', 'Ibu & Bayi', 1, NULL, NULL, NULL),
('CAT0000009', 'Sepatu Pria', 1, NULL, NULL, NULL),
('CAT0000010', 'Sepatu Wanita', 1, NULL, NULL, NULL),
('CAT0000011', 'Tas Pria', 1, NULL, NULL, NULL),
('CAT0000012', 'Tas Wanita', 1, NULL, NULL, NULL),
('CAT0000013', 'Jam Tangan', 1, NULL, NULL, NULL),
('CAT0000014', 'Fashion Muslim', 1, NULL, NULL, NULL),
('CAT0000015', 'Elektronik', 1, NULL, NULL, NULL),
('CAT0000016', 'Aksesoris Fashion', 1, NULL, NULL, NULL),
('CAT0000017', 'Kesehatan', 1, NULL, NULL, NULL),
('CAT0000018', 'Hobi & Koleksi', 1, NULL, NULL, NULL),
('CAT0000019', 'Fotografi', 1, NULL, NULL, NULL),
('CAT0000020', 'Makanan & Minuman', 1, NULL, NULL, NULL),
('CAT0000021', 'Olahraga & Outdoor', 1, NULL, NULL, NULL),
('CAT0000022', 'Otomotif', 1, NULL, NULL, NULL),
('CAT0000023', 'Voucher', 1, NULL, NULL, NULL);

--
-- Triggers `categories`
--
DELIMITER $$
CREATE TRIGGER `auto_id_cat` BEFORE INSERT ON `categories` FOR EACH ROW BEGIN 
SELECT SUBSTRING((MAX(`category_id`)),4,7) INTO @total FROM categories; 
IF (@total >= 1) THEN 
SET new.category_id = CONCAT('CAT',LPAD(@total+1,7,'0')); 
ELSE 
SET new.category_id = CONCAT('CAT',LPAD(1,7,'0')); 
END IF; 
SET NEW.status = 1;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `customer_id` char(10) COLLATE utf8_unicode_ci NOT NULL,
  `first_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` decimal(12,0) NOT NULL,
  `email` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `street` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `city` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `state` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `zip_code` decimal(5,0) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`customer_id`, `first_name`, `last_name`, `phone`, `email`, `street`, `city`, `state`, `zip_code`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
('CST0000001', 'Mursanih', NULL, 82151241413, 'mursanih@gmail.com', 'Jl. Siwalankerto Timur', 'Surabaya', 'Jawa Timur', 61245, 1, NULL, NULL, NULL),
('CST0000002', 'Siswanto', NULL, 85716215261, 'siswanto@gmail.com', 'Jl. Jemursari', 'Surabaya', 'Jawa Timur', 54565, 1, NULL, NULL, NULL),
('CST0000003', 'Sumanto', 'Basori', 81936374572, 'sumanto@gmail.com', 'Jl. Margorejo', 'Surabaya', 'Jawa Timur', 61278, 1, NULL, NULL, NULL),
('CST0000004', 'Mahsuri', 'Lasimin', 85283374364, 'mahsuri@gmail.com', 'Jl. Margorejo Indah', 'Surabaya', 'Jawa Timur', 61245, 1, NULL, NULL, NULL),
('CST0000005', 'Nurendro', 'Adrian', 81338276279, 'nurendro@gmail.com', 'Jl. Jemur Andayani', 'Surabaya', 'Jawa Timur', 63454, 1, NULL, NULL, NULL),
('CST0000006', 'Syahnami', 'Bagus', 82128237230, 'syahnami@gmail.com', 'Jl. Prapen', 'Surabaya', 'Jawa Timur', 61245, 1, NULL, NULL, NULL),
('CST0000007', 'Gustiningsih', 'Gustiningsih', 81273273634, 'gustiningsih@gmail.com', 'Jl. Ngagel', 'Surabaya', 'Jawa Timur', 61245, 1, NULL, NULL, NULL),
('CST0000008', 'Sumiarti', 'Lilis', 85273627362, 'sumiarti@gmail.com', 'Jl. Bendul Merisi', 'Surabaya', 'Jawa Timur', 61245, 1, NULL, NULL, NULL),
('CST0000009', 'Aisyah', 'Siti', 82273627368, 'aisyah@gmail.com', 'Jl. Bendul Merisi 2', 'Surabaya', 'Jawa Timur', 61245, 1, NULL, NULL, NULL),
('CST0000010', 'Nurhayanti', 'Nurhayanti', 81236236229, 'nurhayanti@gmail.com', 'Jl. Bung Tomo', 'Surabaya', 'Jawa Timur', 61245, 1, NULL, NULL, NULL),
('CST0000011', 'Darmatia', 'Rismauli', 81822736274, 'darmatia@gmail.com', 'Jl. Mayjen Sungkono', 'Surabaya', 'Jawa Timur', 61245, 1, NULL, NULL, NULL),
('CST0000012', 'Gunawan', 'Gunawan', 85673623766, 'gunawan@gmail.com', 'Jl. Mayjen Sungkono 1', 'Bandung', 'Jawa Barat', 61245, 1, NULL, NULL, NULL),
('CST0000013', 'Hermansyah', 'Hermansyah', 85232532353, 'hermansyah@gmail.com', 'Jl. Mayjen Sungkono 3', 'Bandung', 'Jawa Barat', 61245, 1, NULL, NULL, NULL),
('CST0000014', 'Budiantoro', 'Apri', 89763736272, 'budiantoro@gmail.com', 'Jl. Dukuh Kupang 2', 'Bandung', 'Jawa Barat', 61245, 1, NULL, NULL, NULL),
('CST0000015', 'Susanto', 'Ucahyo', 85273627377, 'susanto@gmail.com', 'Jl. Balas Klumprik', 'Bandung', 'Jawa Barat', 61245, 1, NULL, NULL, NULL),
('CST0000016', 'Mania', 'Susanti', 81253526158, 'mania@gmail.com', 'Jl. Ngagel Jaya Selatan', 'Bandung', 'Jawa Barat', 61245, 1, NULL, NULL, NULL),
('CST0000017', 'Budianto', 'Eko', 81723265654, 'budianto@gmail.com', 'Jl. Ngagel Rejo', 'Bandung', 'Jawa Barat', 61245, 1, NULL, '2020-06-17 14:22:05', '2020-06-17 14:22:05'),
('CST0000018', 'Budi', 'Budi', 81261561512, 'budi@gmail.com', 'Jl. Ngagel Rejo Kidul', 'Bandung', 'Jawa Barat', 61245, 1, NULL, NULL, NULL),
('CST0000019', 'Lur', 'Faisal', 81263262611, 'lur@gmail.com', 'Jl. Darmo?', 'Bandung', 'Jawa Barat', 61245, 1, NULL, NULL, NULL),
('CST0000020', 'Naini', 'Latiful', 89265636410, 'naini@gmail.com', 'Jl. Pasar Kembang', 'Bandung', 'Jawa Barat', 61245, 1, NULL, NULL, NULL),
('CST0000021', 'Masya', 'Nisya', 81625216254, 'masya@gmail.com', 'Jl. Arjuno', 'Bandung', 'Jawa Barat', 61245, 1, NULL, NULL, NULL),
('CST0000022', 'Maharani', 'Maharani', 85121252530, 'maharani@gmail.com', 'Jl. Girilaya', 'Bandung', 'Jawa Barat', 61245, 1, NULL, '2020-06-17 14:21:52', '2020-06-17 14:21:52'),
('CST0000023', 'Putri', 'Neni', 81216216352, 'putri@gmail.com', 'Jl. Putat Jaya', 'Bandung', 'Jawa Barat', 61245, 1, NULL, NULL, NULL),
('CST0000024', 'Pramadita', 'Putra', 83162516511, 'pramadita@gmail.com', 'Jl. Banyu Urip', 'Bandung', 'Jawa Barat', 61245, 1, NULL, NULL, NULL),
('CST0000025', 'Zuliansyah', 'Risky', 81612516530, 'zuliansyah@gmail.com', 'Jl. Kupang Gunung', 'Bandung', 'Jawa Barat', 61245, 1, NULL, NULL, NULL),
('CST0000026', 'Dea', 'Damayanti', 81542413454, 'deaamartya@gmail.com', 'Jalan Gubeng Kertajaya 5B No 60', 'Surabaya', 'Jawa Timur', 54124, 1, NULL, NULL, NULL),
('CST0000027', 'Diva', 'Hapsari', 84564564132, 'divahapsari1@gmail.com', 'Jalan Ir. Soekarno No. 50', 'Sidoarjo', 'Jawa Timur', 31124, 1, NULL, NULL, NULL);

--
-- Triggers `customer`
--
DELIMITER $$
CREATE TRIGGER `auto_id_cust` BEFORE INSERT ON `customer` FOR EACH ROW BEGIN
	SELECT SUBSTRING((MAX(`customer_id`)),4,7) INTO @total FROM customer;
    IF (@total >= 1) THEN
		SET new.customer_id = CONCAT('CST',LPAD(@total+1,7,'0'));
    ELSE
    	SET new.customer_id = CONCAT('CST',LPAD(1,7,'0'));
    END IF;
SET NEW.status = 1;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `job_type`
--

CREATE TABLE `job_type` (
  `id` int(11) NOT NULL,
  `nama_job` varchar(30) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `job_type`
--

INSERT INTO `job_type` (`id`, `nama_job`) VALUES
(2, 'Owner'),
(4, 'Product Administrator'),
(3, 'Sales Administrator'),
(1, 'Super Admin');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `product_id` char(10) COLLATE utf8_unicode_ci NOT NULL,
  `category_id` char(10) COLLATE utf8_unicode_ci NOT NULL,
  `product_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `product_price` float(10,0) NOT NULL,
  `product_stock` decimal(3,0) NOT NULL,
  `explanation` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`product_id`, `category_id`, `product_name`, `product_price`, `product_stock`, `explanation`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
('PRD0000001', 'CAT0000001', 'Celana Panjang Chino Pria', 65800, 229, NULL, 1, NULL, NULL, NULL),
('PRD0000002', 'CAT0000002', 'Overall Lola', 14900, 405, NULL, 1, NULL, NULL, NULL),
('PRD0000003', 'CAT0000003', 'Oppo A5S 3Gb Ram 32Gb Rom', 2099000, 43, NULL, 1, NULL, NULL, NULL),
('PRD0000004', 'CAT0000004', 'Maybelline Push Up Drama Waterproof Mascara Makeup', 108700, 692, NULL, 1, NULL, NULL, NULL),
('PRD0000005', 'CAT0000005', 'Logitech Wireless Mouse M170', 95060, 494, NULL, 1, NULL, NULL, NULL),
('PRD0000006', 'CAT0000006', 'Tumbler Botol Minum Motif', 34000, 658, NULL, 1, NULL, NULL, NULL),
('PRD0000007', 'CAT0000007', 'Jam Tangan Anak Lol', 18200, 231, NULL, 1, NULL, NULL, NULL),
('PRD0000008', 'CAT0000008', 'Baby Happy Body Fit Pants M34', 39000, 62, NULL, 1, NULL, NULL, NULL),
('PRD0000009', 'CAT0000009', 'Sepatu Converse 70S Egret High Bnib', 160000, 59, NULL, 1, NULL, NULL, NULL),
('PRD0000010', 'CAT0000010', 'Sandal Elmo Jelly Sol Hitam', 15500, 123, NULL, 1, NULL, NULL, NULL),
('PRD0000011', 'CAT0000011', 'Tas Kanvas Waterproof Slempang', 59500, 338, NULL, 1, NULL, NULL, NULL),
('PRD0000012', 'CAT0000012', 'Morymony Pocket Dora', 7500, 109, NULL, 1, NULL, NULL, NULL),
('PRD0000013', 'CAT0000020', 'Paket PaNas 1 Krispi', 36000, 24, 'Ayam Krispi', 1, NULL, NULL, NULL),
('PRD0000014', 'CAT0000005', 'Logitech Pebble Mouse', 298000, 14, 'Mouse keluaran terbaru', 1, NULL, NULL, NULL),
('PRD0000015', 'CAT0000004', 'Emina Cream Matte', 40000, 9, 'Warna pink', 1, NULL, NULL, NULL),
('PRD0000016', 'CAT0000004', 'Wardah Lip Cream', 40000, 20, 'Warna peach', 1, NULL, NULL, NULL);

--
-- Triggers `product`
--
DELIMITER $$
CREATE TRIGGER `auto_id_product` BEFORE INSERT ON `product` FOR EACH ROW BEGIN
	SELECT SUBSTRING((MAX(`product_id`)),4,7) INTO @total FROM product;
    IF (@total >= 1) THEN
		SET new.product_id = CONCAT('PRD',LPAD(@total+1,7,'0'));
    ELSE
    	SET new.product_id = CONCAT('PRD',LPAD(1,7,'0'));
    END IF;
SET NEW.status = 1;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `nota_id` char(10) COLLATE utf8_unicode_ci NOT NULL,
  `customer_id` char(10) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` char(10) COLLATE utf8_unicode_ci NOT NULL,
  `nota_date` date NOT NULL,
  `total_payment` float(20,0) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`nota_id`, `customer_id`, `user_id`, `nota_date`, `total_payment`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
('2004280001', 'CST0000008', 'USR0000003', '2020-01-28', 447370, 1, '2020-04-28 07:56:32', '2020-04-28 07:56:32', NULL),
('2004280002', 'CST0000005', 'USR0000003', '2020-02-20', 327800, 1, '2020-04-28 07:56:53', '2020-04-28 07:56:53', NULL),
('2004280003', 'CST0000021', 'USR0000003', '2020-03-13', 74900, 1, '2020-04-28 07:57:30', '2020-04-28 07:57:30', NULL),
('2004280004', 'CST0000009', 'USR0000003', '2020-04-28', 418673, 1, '2020-04-28 08:04:59', '2020-04-28 08:04:59', NULL),
('2004280005', 'CST0000010', 'USR0000003', '2020-04-18', 82680, 1, '2020-04-28 08:06:21', '2020-04-28 08:06:21', NULL),
('2005020001', 'CST0000008', 'USR0000003', '2020-05-02', 695813, 1, '2020-05-02 13:17:56', '2020-05-02 13:17:56', NULL),
('2005060001', 'CST0000024', 'USR0000003', '2020-05-06', 2308900, 1, '2020-05-06 14:33:17', '2020-05-06 14:33:17', NULL),
('2005060002', 'CST0000005', 'USR0000003', '2020-01-06', 74800, 1, '2020-05-06 14:34:20', '2020-05-06 14:34:20', NULL),
('2005140001', 'CST0000006', 'USR0000003', '2020-05-14', 371800, 1, '2020-05-14 23:39:43', '2020-05-14 23:39:43', NULL),
('2005140002', 'CST0000025', 'USR0000003', '2020-05-14', 176000, 1, '2020-05-14 23:40:04', '2020-05-14 23:40:04', NULL),
('2005140003', 'CST0000023', 'USR0000003', '2020-05-14', 39600, 1, '2020-05-14 23:40:28', '2020-05-14 23:40:28', NULL);

--
-- Triggers `sales`
--
DELIMITER $$
CREATE TRIGGER `auto_id_sales` BEFORE INSERT ON `sales` FOR EACH ROW BEGIN
DECLARE max integer DEFAULT 0;
SELECT SUBSTRING((MAX(`nota_id`)),1,6) INTO @tgl FROM sales;
SELECT DATE_FORMAT(CURRENT_DATE, "%y%m%d") INTO @today;
SELECT SUBSTRING((MAX(`nota_id`)),7,4) INTO @max FROM sales;
SELECT STRCMP(@tgl,@today) INTO @check;

     IF(@max >=1) THEN
        IF(@check = 0) THEN
            SET new.nota_id = CONCAT(@today,LPAD(@max+1,4,'0'));
		ELSE
			SET new.nota_id = CONCAT(@today,LPAD(1,4,'0'));
		END IF;
     ELSE
         SET new.nota_id = CONCAT(@today,LPAD(1,4,'0'));
     END IF;
SET NEW.status = 1;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `sales_detail`
--

CREATE TABLE `sales_detail` (
  `nota_id` char(10) COLLATE utf8_unicode_ci NOT NULL,
  `product_id` char(10) COLLATE utf8_unicode_ci NOT NULL,
  `quantity` decimal(2,0) NOT NULL,
  `selling_price` float(10,0) NOT NULL,
  `discount` float(10,0) NOT NULL,
  `total_price` float(10,0) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `sales_detail`
--

INSERT INTO `sales_detail` (`nota_id`, `product_id`, `quantity`, `selling_price`, `discount`, `total_price`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
('2004280001', 'PRD0000004', 1, 108700, 0, 108700, 1, '2020-04-28 07:56:32', '2020-04-28 07:56:32', NULL),
('2004280001', 'PRD0000014', 1, 298000, 0, 298000, 1, '2020-04-28 07:56:32', '2020-04-28 07:56:32', NULL),
('2004280002', 'PRD0000014', 1, 298000, 0, 298000, 1, '2020-04-28 07:56:53', '2020-04-28 07:56:53', NULL),
('2004280003', 'PRD0000008', 1, 39000, 0, 39000, 1, '2020-04-28 07:57:30', '2020-04-28 07:57:30', NULL),
('2004280003', 'PRD0000010', 1, 15500, 1550, 13950, 1, '2020-04-28 07:57:30', '2020-04-28 07:57:30', NULL),
('2004280003', 'PRD0000012', 2, 7500, 0, 15000, 1, '2020-04-28 07:57:30', '2020-04-28 07:57:30', NULL),
('2004280004', 'PRD0000005', 1, 95060, 4753, 90307, 1, '2020-04-28 08:04:59', '2020-04-28 08:04:59', NULL),
('2004280004', 'PRD0000014', 1, 298000, 8940, 289060, 1, '2020-04-28 08:04:59', '2020-04-28 08:04:59', NULL),
('2004280005', 'PRD0000008', 2, 39000, 3120, 74880, 1, '2020-04-28 08:06:21', '2020-04-28 08:06:21', NULL),
('2005020001', 'PRD0000005', 1, 95060, 4753, 90307, 1, '2020-05-02 13:17:56', '2020-05-02 13:17:56', NULL),
('2005020001', 'PRD0000014', 2, 298000, 59600, 536400, 1, '2020-05-02 13:17:56', '2020-05-02 13:17:56', NULL),
('2005060001', 'PRD0000003', 1, 2099000, 0, 2099000, 1, '2020-05-06 14:33:17', '2020-05-06 14:33:17', NULL),
('2005060002', 'PRD0000006', 2, 34000, 0, 68000, 1, '2020-05-06 14:34:20', '2020-05-06 14:34:20', NULL),
('2005140001', 'PRD0000014', 1, 298000, 0, 298000, 1, '2020-05-14 23:39:43', '2020-05-14 23:39:43', NULL),
('2005140001', 'PRD0000015', 1, 40000, 0, 40000, 1, '2020-05-14 23:39:43', '2020-05-14 23:39:43', NULL),
('2005140002', 'PRD0000009', 1, 160000, 0, 160000, 1, '2020-05-14 23:40:04', '2020-05-14 23:40:04', NULL),
('2005140003', 'PRD0000013', 1, 36000, 0, 36000, 1, '2020-05-14 23:40:28', '2020-05-14 23:40:28', NULL);

--
-- Triggers `sales_detail`
--
DELIMITER $$
CREATE TRIGGER `del_updateStock` AFTER DELETE ON `sales_detail` FOR EACH ROW BEGIN
    UPDATE product
	SET product.product_stock= product.product_stock+OLD.quantity
	WHERE product.product_id=OLD.product_id;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `ins_updateStock` BEFORE INSERT ON `sales_detail` FOR EACH ROW BEGIN

UPDATE product
SET product.product_stock= product.product_stock-NEW.quantity
WHERE product.product_id=NEW.product_id;
SET NEW.status = 1;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `upd_updateStock` AFTER UPDATE ON `sales_detail` FOR EACH ROW BEGIN
    UPDATE product
	SET product.product_stock= product.product_stock-NEW.quantity+OLD.quantity
	WHERE product.product_id=NEW.product_id;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` char(10) COLLATE utf8_unicode_ci NOT NULL,
  `first_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `phone` decimal(12,0) NOT NULL,
  `password` char(8) COLLATE utf8_unicode_ci NOT NULL,
  `job_status` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `first_name`, `last_name`, `email`, `phone`, `password`, `job_status`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
('USR0000001', 'Dina', 'Amalia', 'dinaamalia@gmail.com', 81333654616, 'dinadina', 1, 1, NULL, NULL, NULL),
('USR0000002', 'Diva', 'Hapsari', 'divamaya@gmail.com', 81333654787, 'divadiva', 2, 1, NULL, NULL, NULL),
('USR0000003', 'Dewi', 'Istiqomah', 'dewiistiqomah@gmail.com', 81378645239, 'dewidewi', 3, 1, NULL, NULL, NULL),
('USR0000004', 'Dea', 'Damayanti', 'deaamartya3@gmail.com', 816457942, 'deadea', 4, 1, NULL, NULL, NULL);

--
-- Triggers `user`
--
DELIMITER $$
CREATE TRIGGER `auto_id_user` BEFORE INSERT ON `user` FOR EACH ROW BEGIN
	SELECT SUBSTRING((MAX(`user_id`)),4,7) INTO @total FROM user;
    IF (@total >= 1) THEN
		SET new.user_id = CONCAT('USR',LPAD(@total+1,7,'0'));
    ELSE
    	SET new.user_id = CONCAT('USR',LPAD(1,7,'0'));
    END IF;
SET NEW.status = 1;
END
$$
DELIMITER ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `job_type`
--
ALTER TABLE `job_type`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nama_job` (`nama_job`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `product_ibfk_1` (`category_id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`nota_id`),
  ADD KEY `sales_ibfk_2` (`user_id`),
  ADD KEY `sales_ibfk_1` (`customer_id`);

--
-- Indexes for table `sales_detail`
--
ALTER TABLE `sales_detail`
  ADD PRIMARY KEY (`nota_id`,`product_id`),
  ADD KEY `sales_detail_ibfk_2` (`product_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `user_ibfk_1` (`job_status`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`);

--
-- Constraints for table `sales`
--
ALTER TABLE `sales`
  ADD CONSTRAINT `sales_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`),
  ADD CONSTRAINT `sales_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);

--
-- Constraints for table `sales_detail`
--
ALTER TABLE `sales_detail`
  ADD CONSTRAINT `sales_detail_ibfk_1` FOREIGN KEY (`nota_id`) REFERENCES `sales` (`nota_id`),
  ADD CONSTRAINT `sales_detail_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`);

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`job_status`) REFERENCES `job_type` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
