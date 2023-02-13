-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 07, 2023 at 03:10 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `booking_2`
--

-- --------------------------------------------------------

--
-- Table structure for table `agents`
--

CREATE TABLE `agents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `full_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `location_id` bigint(20) UNSIGNED NOT NULL,
  `contact_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `full_address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `agents`
--

INSERT INTO `agents` (`id`, `full_name`, `location_id`, `contact_number`, `full_address`, `email_address`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 'JUANITO MULAT', 1, '09166879413', 'CAGAYAN DE ORO CITY', '', 1, '2021-07-16 20:32:10', '2021-07-16 20:32:10'),
(2, 'JAYSON VERGARA', 1, '09658308430', 'GUINSILIBAN,CAMIGUIN,PROVINCE.', 'macahilosjaymar@yahoo.com', 1, '2021-09-17 20:45:00', '2021-09-17 20:45:00'),
(3, 'JOIE VICENTE', 1, '09533844872', 'CAGAYAN DE ORO CITY', 'joei@gmail.com', 1, '2021-10-28 16:50:34', '2021-10-28 16:50:34'),
(4, 'JONAS IVIE TUPOS', 1, '09100260196', 'CONSOLACION DISTRICT 7', 'jhamaivie@gmail.com', 1, '2021-11-05 15:48:32', '2021-11-05 15:48:32'),
(5, 'JOSELF PACHECO', 1, '09265695609', 'MULOGAN, ELSALVADOR', 'joself@gmail.com', 1, '2021-11-25 19:20:11', '2021-11-25 19:20:11'),
(6, 'RICHARD BAGAY NACAR', 4, '09559283222', 'BONTONG ZONR  6, STA. ANA , TAGOLOAN , MISAMIS ORIENTAL', 'NONE@gmail.com', 1, '2021-12-09 16:43:37', '2021-12-09 16:43:37'),
(7, 'AXEL BAQUIL', 5, '639551466973', 'CENTRO DUMARAIT, BALINGASAG, MIS. OR', 'none@gmail.com', 1, '2021-12-09 16:47:35', '2021-12-09 16:47:35'),
(8, 'ROWIN ARIBE BELTRAN', 6, '09263188734', 'LUYONG BONBON, OPOL MISAMIS ORIENTAL', 'none@gmail.com', 1, '2021-12-09 16:48:14', '2021-12-09 16:48:14'),
(9, 'RAY JOHN PAMISA', 7, '09678719103', 'OPOL , MIS. OR', 'none@gmail.com', 1, '2021-12-09 16:48:52', '2021-12-09 16:48:52'),
(10, 'JAY JAGUING', 8, '09759401662', 'ZONE 2 SAN LAZARO, LAPASAN, CDOC', 'none@gmail.com', 1, '2021-12-09 16:49:40', '2021-12-09 16:49:40'),
(11, 'JAYSON CONDEMINA', 9, '639164334300', 'UPPER MACAPAYA, INDAHAG CDOC', 'none@gmail.com', 1, '2021-12-09 16:50:45', '2021-12-09 16:50:45'),
(12, 'JOVERT EMPIL', 10, '09972618276', 'DE CASTRO, ARMEN, CDOC', 'none@gmail.com', 1, '2021-12-09 16:51:18', '2021-12-09 16:51:18'),
(13, 'MARJORIE UBAN', 5, '09533844872', 'N/A', 'marjorieuban@gmail.com', 1, '2022-01-03 19:16:47', '2022-01-03 19:16:47'),
(14, 'VENDER', 1, '095338448716', 'ADDRES', 'vender@gmail.com', 1, '2022-02-08 00:47:43', '2022-02-08 00:47:43'),
(15, 'WALTER ABAI', 4, '09061883381', 'VILLA ANGELA', 'walterabao@gmail.com', 1, '2022-02-11 18:10:11', '2022-02-11 18:10:11'),
(16, 'ALMER COMALENG', 1, '09533844872', 'CAGAYAN DE ORO CITY', 'comaleng@gmail.com', 1, '2022-03-18 16:51:07', '2022-03-18 16:51:07'),
(17, 'ARGEL JALINON', 7, '09551251287', 'NORTH BUKIDNON', 'argel@gmail.com', 1, '2022-04-13 19:44:59', '2022-04-13 19:44:59'),
(18, 'NELSON DELAVICTORIA', 6, '09651725740', 'DAMULOG BUKIDNON', 'junrick@gmail.com', 34, '2022-04-25 00:54:45', '2022-04-25 00:54:45'),
(19, 'JOVIL DY', 2, '09978351108', 'KAUSWAGAN CAGAYAN DE ORO', 'jovildy1@gmail.com', 34, '2022-04-25 17:16:49', '2022-04-25 17:16:49'),
(20, 'ALVIN PAUL DELA DRUZ', 6, 'NONE', 'CAGAYAN DE ORO', 'alvin@gmail.com', 34, '2022-06-13 22:25:33', '2022-06-13 22:25:33'),
(21, 'REGIEL DELEGENCIA', 4, '09971777046', 'CAGAYAN DE ORO', 'regiel@gmail.com', 34, '2022-06-19 18:21:08', '2022-06-19 18:21:08');

-- --------------------------------------------------------

--
-- Table structure for table `agent_applied_customers`
--

CREATE TABLE `agent_applied_customers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `agent_id` bigint(20) UNSIGNED NOT NULL,
  `location_id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `agent_principals`
--

CREATE TABLE `agent_principals` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `agent_id` bigint(20) UNSIGNED NOT NULL,
  `principal_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ar_ledgers`
--

CREATE TABLE `ar_ledgers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `sales_order_print_id` bigint(20) UNSIGNED DEFAULT NULL,
  `van_selling_print_id` int(11) DEFAULT NULL,
  `agent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `cm_for_bo_id` bigint(20) UNSIGNED DEFAULT NULL,
  `cm_for_rgs_id` bigint(20) UNSIGNED DEFAULT NULL,
  `customer_payment_details_id` bigint(20) UNSIGNED DEFAULT NULL,
  `principal_id` int(10) UNSIGNED DEFAULT NULL,
  `date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bodega_outs`
--

CREATE TABLE `bodega_outs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `principal_id` int(10) UNSIGNED NOT NULL,
  `remarks` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bodega_out_details`
--

CREATE TABLE `bodega_out_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `bodega_out_id` bigint(20) UNSIGNED NOT NULL,
  `sku_id` int(10) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  `fuc_prices` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `transfer_to_sku_id` int(11) NOT NULL,
  `transfer_quantity` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bo_allowance_adjustments`
--

CREATE TABLE `bo_allowance_adjustments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `principal_id` int(10) UNSIGNED NOT NULL,
  `received_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `particulars` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `bo_allowance_deduction` decimal(15,4) NOT NULL,
  `vat_deduction` decimal(15,4) NOT NULL,
  `net_deduction` decimal(15,4) NOT NULL,
  `date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bo_allowance_adjustments_details`
--

CREATE TABLE `bo_allowance_adjustments_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `bo_allowance_id` bigint(20) UNSIGNED NOT NULL,
  `sku_id` int(10) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  `unit_cost` decimal(15,4) NOT NULL,
  `adjusted_amount` decimal(15,4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bo_allowance_adjustments_jers`
--

CREATE TABLE `bo_allowance_adjustments_jers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `bo_allowance_id` bigint(20) UNSIGNED NOT NULL,
  `dr` decimal(15,4) NOT NULL,
  `cr` decimal(15,4) NOT NULL,
  `date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cm_for_bos`
--

CREATE TABLE `cm_for_bos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `agent_id` int(11) NOT NULL,
  `pcm_number` int(11) NOT NULL,
  `pcm_upload_id` int(11) NOT NULL,
  `sales_order_printed_id` bigint(20) UNSIGNED NOT NULL,
  `total_bo_amount` decimal(8,2) NOT NULL,
  `total_customer_discount` decimal(15,4) NOT NULL,
  `status` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `converted_by` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `posted_by` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_confirmed` date NOT NULL,
  `date_posted` date NOT NULL,
  `personnels_involved` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount_involved` decimal(15,4) NOT NULL,
  `involved_in` char(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cm_for_bo_details`
--

CREATE TABLE `cm_for_bo_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cm_for_bo_id` bigint(20) UNSIGNED NOT NULL,
  `sku_id` int(10) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  `bo_quantity_expired` int(11) NOT NULL,
  `price` decimal(15,4) NOT NULL,
  `bo_amount` decimal(15,4) NOT NULL,
  `category_discount` decimal(15,4) NOT NULL,
  `remarks` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cm_for_bo_jers`
--

CREATE TABLE `cm_for_bo_jers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cm_for_bo_id` bigint(20) UNSIGNED NOT NULL,
  `sales` decimal(15,4) NOT NULL,
  `accounts_receivable` decimal(15,4) NOT NULL,
  `sales_return_and_allowances` decimal(15,4) NOT NULL,
  `cost_of_sales` decimal(15,4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cm_for_others`
--

CREATE TABLE `cm_for_others` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `personnel_id` bigint(20) UNSIGNED NOT NULL,
  `total_amount` decimal(15,4) NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `approved_by` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `transaction_remarks` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cm_for_others_details`
--

CREATE TABLE `cm_for_others_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cm_for_others_id` bigint(20) UNSIGNED NOT NULL,
  `sku_id` int(10) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(8,2) NOT NULL,
  `amount` decimal(8,2) NOT NULL,
  `remarks` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cm_for_rgs`
--

CREATE TABLE `cm_for_rgs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `agent_id` int(11) NOT NULL,
  `pcm_number` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sales_order_printed_id` bigint(20) UNSIGNED NOT NULL,
  `pcm_upload_id` int(11) NOT NULL,
  `total_rgs_amount` decimal(15,4) NOT NULL,
  `status` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `converted_by` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `posted_by` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_confirmed` date NOT NULL,
  `date_posted` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cm_for_rgs_details`
--

CREATE TABLE `cm_for_rgs_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cm_for_rgs_id` bigint(20) UNSIGNED NOT NULL,
  `sku_id` int(10) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(15,4) NOT NULL,
  `remarks` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cm_for_rgs_jers`
--

CREATE TABLE `cm_for_rgs_jers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cm_for_rgs_id` bigint(20) UNSIGNED NOT NULL,
  `sales` decimal(15,4) NOT NULL,
  `accounts_receivable` decimal(15,4) NOT NULL,
  `inventory` decimal(15,4) NOT NULL,
  `cost_of_sales` decimal(15,4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `store_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `location_id` bigint(20) UNSIGNED NOT NULL,
  `detailed_location` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `credit_term` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `credit_line_amount` decimal(15,4) NOT NULL,
  `contact_person` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kind_of_business` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` char(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `max_number_of_transactions` int(11) DEFAULT NULL,
  `mode_of_transaction` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `longitude` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `latitude` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customer_category_discounts`
--

CREATE TABLE `customer_category_discounts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `principal_id` int(10) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `category_id` int(10) UNSIGNED NOT NULL,
  `category_discount_rate` decimal(10,4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customer_discounts`
--

CREATE TABLE `customer_discounts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `principal_id` int(10) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `customer_discount` decimal(10,4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customer_ledgers`
--

CREATE TABLE `customer_ledgers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `customer_payment_id` int(11) NOT NULL,
  `van_selling_payment_id` int(11) NOT NULL,
  `principal_id` int(10) UNSIGNED NOT NULL,
  `delivery_receipt` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sales_order_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `transaction_reference` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `accounts_receivable_previous` double(15,4) NOT NULL,
  `sales` double(15,4) NOT NULL,
  `bo` decimal(15,4) NOT NULL,
  `rgs` decimal(15,4) NOT NULL,
  `adjustments` double(15,4) NOT NULL,
  `payment` double(15,4) NOT NULL,
  `accounts_receivable_end` double(15,4) NOT NULL,
  `credit_line_amount` decimal(15,4) NOT NULL,
  `update_credit_line_amount` decimal(15,4) NOT NULL,
  `credit_line_balance` decimal(15,4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customer_ledgers`
--

INSERT INTO `customer_ledgers` (`id`, `customer_id`, `customer_payment_id`, `van_selling_payment_id`, `principal_id`, `delivery_receipt`, `sales_order_number`, `transaction_reference`, `accounts_receivable_previous`, `sales`, `bo`, `rgs`, `adjustments`, `payment`, `accounts_receivable_end`, `credit_line_amount`, `update_credit_line_amount`, `credit_line_balance`, `created_at`, `updated_at`) VALUES
(1, 1, 0, 0, 0, '', '', 'new customer', 0.0000, 0.0000, '0.0000', '0.0000', 0.0000, 0.0000, 0.0000, '1000000.0000', '0.0000', '1000000.0000', '2021-07-17 00:54:24', '2021-07-17 00:54:24'),
(124, 2, 0, 0, 0, '', '', 'new customer', 0.0000, 0.0000, '0.0000', '0.0000', 0.0000, 0.0000, 0.0000, '1000000.0000', '0.0000', '1000000.0000', '2021-09-18 04:46:20', '2021-09-18 04:46:20'),
(215, 2, 0, 0, 8, 'PPMCC21-09-0562', 'VS-2-8-2021-10-01090242', 'VAN WITHDRAWAL', 0.0000, 2720.6400, '0.0000', '0.0000', 0.0000, 0.0000, 2720.6400, '1000000.0000', '0.0000', '997279.3600', '2021-10-01 01:02:45', '2021-10-01 01:02:45'),
(216, 2, 0, 0, 2, 'E12M27929', 'VS-2-2-2021-10-01090456', 'VAN WITHDRAWAL', 2720.6400, 5057.1624, '0.0000', '0.0000', 0.0000, 0.0000, 7777.8024, '1000000.0000', '0.0000', '992222.1976', '2021-10-01 01:05:00', '2021-10-01 01:05:00'),
(217, 2, 0, 0, 4, 'EPI21-09-0392', 'VS-2-4-2021-10-01090555', 'VAN WITHDRAWAL', 7777.8024, 2214.0000, '0.0000', '0.0000', 0.0000, 0.0000, 9991.8024, '1000000.0000', '0.0000', '990008.1976', '2021-10-01 01:05:59', '2021-10-01 01:05:59'),
(218, 2, 0, 0, 8, 'PPMCC21-10-0034', 'VS-2-8-2021-10-02084853', 'VAN WITHDRAWAL', 9991.8024, 1236.0000, '0.0000', '0.0000', 0.0000, 0.0000, 11227.8024, '1000000.0000', '0.0000', '988772.1976', '2021-10-02 00:49:19', '2021-10-02 00:49:19'),
(219, 2, 0, 0, 2, 'SAMPLE GCI 0001', 'VS-2-2-2021-10-02135129', 'VAN WITHDRAWAL', 11227.8024, 151237.9600, '0.0000', '0.0000', 0.0000, 0.0000, 162465.7624, '1000000.0000', '0.0000', '837534.2376', '2021-10-02 05:51:47', '2021-10-02 05:51:47'),
(220, 2, 0, 0, 2, 'GCI0001', 'VS-2-2-2021-10-02141116', 'VAN WITHDRAWAL', 162465.7624, 150837.1000, '0.0000', '0.0000', 0.0000, 0.0000, 313302.8624, '1000000.0000', '0.0000', '686697.1376', '2021-10-02 06:11:18', '2021-10-02 06:11:18'),
(221, 1, 0, 0, 2, 'EQWEQWE', 'VS-1-2-2021-10-02141436', 'VAN WITHDRAWAL', 0.0000, 151237.9600, '0.0000', '0.0000', 0.0000, 0.0000, 151237.9600, '1000000.0000', '0.0000', '848762.0400', '2021-10-02 06:14:38', '2021-10-02 06:14:38'),
(222, 1, 0, 0, 2, 'DEQWEQWEQWE', 'VS-1-2-2021-10-02142950', 'VAN WITHDRAWAL', 151237.9600, 151237.9600, '0.0000', '0.0000', 0.0000, 0.0000, 302475.9200, '1000000.0000', '0.0000', '697524.0800', '2021-10-02 06:29:52', '2021-10-02 06:29:52'),
(223, 1, 0, 0, 2, 'QWEQWEQWE', 'VS-1-2-2021-10-02143012', 'VAN WITHDRAWAL', 302475.9200, 151237.9600, '0.0000', '0.0000', 0.0000, 0.0000, 453713.8800, '1000000.0000', '0.0000', '546286.1200', '2021-10-02 06:30:13', '2021-10-02 06:30:13'),
(224, 2, 0, 0, 2, 'ASDASDASD', 'VS-2-2-2021-10-02152250', 'VAN WITHDRAWAL', 313302.8624, 151237.9600, '0.0000', '0.0000', 0.0000, 0.0000, 464540.8224, '1000000.0000', '0.0000', '535459.1776', '2021-10-02 07:22:52', '2021-10-02 07:22:52'),
(225, 2, 0, 0, 2, 'QADASDASD', 'VS-2-2-2021-10-02152600', 'VAN WITHDRAWAL', 464540.8224, 151237.9600, '0.0000', '0.0000', 0.0000, 0.0000, 615778.7824, '1000000.0000', '0.0000', '384221.2176', '2021-10-02 07:26:01', '2021-10-02 07:26:01'),
(226, 3, 0, 0, 0, '', '', 'new customer', 0.0000, 0.0000, '0.0000', '0.0000', 0.0000, 0.0000, 0.0000, '1000000.0000', '0.0000', '1000000.0000', '2021-10-29 00:51:27', '2021-10-29 00:51:27'),
(227, 4, 0, 0, 0, '', '', 'new customer', 0.0000, 0.0000, '0.0000', '0.0000', 0.0000, 0.0000, 0.0000, '1000000.0000', '0.0000', '1000000.0000', '2021-11-05 23:49:44', '2021-11-05 23:49:44'),
(228, 5, 0, 0, 0, '', '', 'new customer', 0.0000, 0.0000, '0.0000', '0.0000', 0.0000, 0.0000, 0.0000, '1000000.0000', '0.0000', '1000000.0000', '2021-11-26 03:21:19', '2021-11-26 03:21:19'),
(229, 6, 0, 0, 0, '', '', 'new customer', 0.0000, 0.0000, '0.0000', '0.0000', 0.0000, 0.0000, 0.0000, '1000000.0000', '0.0000', '1000000.0000', '2021-12-10 00:52:51', '2021-12-10 00:52:51'),
(230, 7, 0, 0, 0, '', '', 'new customer', 0.0000, 0.0000, '0.0000', '0.0000', 0.0000, 0.0000, 0.0000, '1000000.0000', '0.0000', '1000000.0000', '2021-12-10 00:53:49', '2021-12-10 00:53:49'),
(231, 8, 0, 0, 0, '', '', 'new customer', 0.0000, 0.0000, '0.0000', '0.0000', 0.0000, 0.0000, 0.0000, '1000000.0000', '0.0000', '1000000.0000', '2021-12-10 00:55:03', '2021-12-10 00:55:03'),
(232, 9, 0, 0, 0, '', '', 'new customer', 0.0000, 0.0000, '0.0000', '0.0000', 0.0000, 0.0000, 0.0000, '1000000.0000', '0.0000', '1000000.0000', '2021-12-10 00:55:34', '2021-12-10 00:55:34'),
(233, 10, 0, 0, 0, '', '', 'new customer', 0.0000, 0.0000, '0.0000', '0.0000', 0.0000, 0.0000, 0.0000, '1000000.0000', '0.0000', '1000000.0000', '2021-12-10 00:56:09', '2021-12-10 00:56:09'),
(234, 11, 0, 0, 0, '', '', 'new customer', 0.0000, 0.0000, '0.0000', '0.0000', 0.0000, 0.0000, 0.0000, '1000000.0000', '0.0000', '1000000.0000', '2021-12-10 00:56:43', '2021-12-10 00:56:43'),
(235, 12, 0, 0, 0, '', '', 'new customer', 0.0000, 0.0000, '0.0000', '0.0000', 0.0000, 0.0000, 0.0000, '1000000.0000', '0.0000', '1000000.0000', '2021-12-10 00:57:13', '2021-12-10 00:57:13'),
(236, 13, 0, 0, 0, '', '', 'new customer', 0.0000, 0.0000, '0.0000', '0.0000', 0.0000, 0.0000, 0.0000, '1000000.0000', '0.0000', '1000000.0000', '2022-01-04 03:14:37', '2022-01-04 03:14:37'),
(237, 14, 0, 0, 0, '', '', 'new customer', 0.0000, 0.0000, '0.0000', '0.0000', 0.0000, 0.0000, 0.0000, '1000000.0000', '0.0000', '1000000.0000', '2022-02-08 08:49:43', '2022-02-08 08:49:43'),
(238, 15, 0, 0, 0, '', '', 'new customer', 0.0000, 0.0000, '0.0000', '0.0000', 0.0000, 0.0000, 0.0000, '1000000.0000', '0.0000', '1000000.0000', '2022-02-12 02:11:47', '2022-02-12 02:11:47'),
(239, 16, 0, 0, 0, '', '', 'new customer', 0.0000, 0.0000, '0.0000', '0.0000', 0.0000, 0.0000, 0.0000, '1000000.0000', '0.0000', '1000000.0000', '2022-03-19 00:51:41', '2022-03-19 00:51:41'),
(240, 17, 0, 0, 0, '', '', 'new customer', 0.0000, 0.0000, '0.0000', '0.0000', 0.0000, 0.0000, 0.0000, '1000000.0000', '0.0000', '1000000.0000', '2022-04-14 03:44:17', '2022-04-14 03:44:17'),
(241, 18, 0, 0, 0, '', '', 'new customer', 0.0000, 0.0000, '0.0000', '0.0000', 0.0000, 0.0000, 0.0000, '1000000.0000', '0.0000', '1000000.0000', '2022-04-25 08:56:25', '2022-04-25 08:56:25'),
(242, 19, 0, 0, 0, '', '', 'new customer', 0.0000, 0.0000, '0.0000', '0.0000', 0.0000, 0.0000, 0.0000, '1000000.0000', '0.0000', '1000000.0000', '2022-04-26 01:18:22', '2022-04-26 01:18:22'),
(243, 20, 0, 0, 0, '', '', 'new customer', 0.0000, 0.0000, '0.0000', '0.0000', 0.0000, 0.0000, 0.0000, '1000000.0000', '0.0000', '1000000.0000', '2022-06-14 06:27:54', '2022-06-14 06:27:54'),
(244, 21, 0, 0, 0, '', '', 'new customer', 0.0000, 0.0000, '0.0000', '0.0000', 0.0000, 0.0000, 0.0000, '1000000.0000', '0.0000', '1000000.0000', '2022-06-20 02:21:54', '2022-06-20 02:21:54');

-- --------------------------------------------------------

--
-- Table structure for table `customer_payments`
--

CREATE TABLE `customer_payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `remitted_by` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customer_payment_details`
--

CREATE TABLE `customer_payment_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_payment_id` bigint(20) UNSIGNED NOT NULL,
  `sales_order_printed_id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` int(11) NOT NULL,
  `or_number` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `check_number` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `check_date` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cash_amount` double(15,4) NOT NULL,
  `check_amount` double(15,4) NOT NULL,
  `refer_cash_amount` double(15,4) NOT NULL,
  `refer_check_amount` double(15,4) NOT NULL,
  `refer_check_number` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `refer_check_date` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `refer_remarks` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` decimal(15,4) NOT NULL,
  `balance` decimal(15,4) NOT NULL,
  `remarks` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customer_payment_jers`
--

CREATE TABLE `customer_payment_jers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_payment_id` bigint(20) UNSIGNED NOT NULL,
  `cash_cheque` decimal(15,4) NOT NULL,
  `accounts_receivable` decimal(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customer_principal_codes`
--

CREATE TABLE `customer_principal_codes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `principal_id` int(10) UNSIGNED NOT NULL,
  `store_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customer_principal_prices`
--

CREATE TABLE `customer_principal_prices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `principal_id` int(10) UNSIGNED NOT NULL,
  `price_level` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customer_uploads`
--

CREATE TABLE `customer_uploads` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `export_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `driver_helpers`
--

CREATE TABLE `driver_helpers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `full_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `full_address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `truck_unit_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `work_description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `driver_helper_charges`
--

CREATE TABLE `driver_helper_charges` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `driver_helper_id` bigint(20) UNSIGNED NOT NULL,
  `amount` decimal(15,4) NOT NULL,
  `remarks` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `invoice_cost_adjustments`
--

CREATE TABLE `invoice_cost_adjustments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `received_id` bigint(20) UNSIGNED NOT NULL,
  `principal_id` int(10) UNSIGNED NOT NULL,
  `particulars` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_invoice_adjusted` decimal(15,4) NOT NULL,
  `total_bo_allowance` decimal(15,4) NOT NULL,
  `vatable_purchase` decimal(15,4) NOT NULL,
  `less_discount` decimal(15,4) NOT NULL,
  `net_discount` decimal(15,4) NOT NULL,
  `vat_amount` decimal(15,4) NOT NULL,
  `net_adjustment` decimal(15,4) NOT NULL,
  `date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `invoice_cost_adjustments_jers`
--

CREATE TABLE `invoice_cost_adjustments_jers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `invoice_cost_id` bigint(20) UNSIGNED NOT NULL,
  `dr` decimal(15,4) NOT NULL,
  `cr` decimal(15,4) NOT NULL,
  `date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `invoice_cost_adjustment_details`
--

CREATE TABLE `invoice_cost_adjustment_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `invoice_cost_id` bigint(20) UNSIGNED NOT NULL,
  `sku_id` int(10) UNSIGNED NOT NULL,
  `adjustments` decimal(15,4) NOT NULL,
  `quantity` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `locations`
--

CREATE TABLE `locations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `locations`
--

INSERT INTO `locations` (`id`, `location`, `created_at`, `updated_at`) VALUES
(1, 'CAGAYAN DE ORO CITY', '2021-01-31 16:23:28', '2021-01-31 16:23:28'),
(2, 'MISAMIS ORIENTAL EAST', '2021-09-17 19:21:52', '2021-09-17 19:21:52'),
(4, 'SOUTH BUKIDNON', '2021-12-09 16:40:51', '2021-12-09 16:40:51'),
(5, 'ILIGAN', '2021-12-09 16:40:57', '2021-12-09 16:40:57'),
(6, 'WEST MIS. OR', '2021-12-09 16:41:09', '2021-12-09 16:41:09'),
(7, 'NORTH BUKIDNON', '2021-12-09 16:41:19', '2021-12-09 16:41:19'),
(8, 'LANAO', '2021-12-09 16:41:27', '2021-12-09 16:41:27'),
(9, 'MISAMIS ORIENTAL', '2021-12-09 16:41:36', '2021-12-09 16:41:36'),
(10, 'CENTRAL BUKIDNON', '2021-12-09 16:41:43', '2021-12-09 16:41:43');

-- --------------------------------------------------------

--
-- Table structure for table `location_details`
--

CREATE TABLE `location_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `location_id` bigint(20) UNSIGNED NOT NULL,
  `barangay` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `street` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `location_details`
--

INSERT INTO `location_details` (`id`, `location_id`, `barangay`, `street`, `created_at`, `updated_at`) VALUES
(1, 1, 'Cogon', 'Cogon', '2021-01-31 16:25:12', '2021-01-31 16:25:12'),
(2, 1, 'Carmen', 'Carmen', '2021-01-31 16:25:20', '2021-01-31 16:25:20'),
(3, 1, 'Puerto', 'Puerto', '2021-01-31 16:25:39', '2021-01-31 16:25:39'),
(5, 1, 'Cugman', 'Cugman', '2021-01-31 16:25:54', '2021-01-31 16:25:54'),
(8, 1, 'Agora', 'Agora', '2021-01-31 16:30:11', '2021-01-31 16:30:11'),
(11, 1, 'JULMAR', 'JULMAR WH', '2021-02-04 17:04:45', '2021-02-04 17:04:45'),
(12, 1, 'JULMAR', 'JULMAR COMMERCIAL', '2021-02-04 17:04:58', '2021-02-04 17:04:58');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2020_02_19_062751_create_sku_categories_table', 1),
(4, '2020_02_19_062806_create_sku_principals_table', 1),
(5, '2020_02_20_060400_create_sku_price_details_table', 1),
(6, '2020_02_21_095810_create_sku_adds_table', 1),
(7, '2020_02_21_121049_create_purchase_orders_table', 1),
(8, '2020_02_21_121158_create_purchase_order_details_table', 1),
(9, '2020_02_28_061705_create_principal_discount_gcis_table', 1),
(10, '2020_02_29_011534_create_principal_discount_cifpis_table', 1),
(11, '2020_02_29_015024_create_principal_discount_ppmcs_table', 1),
(12, '2020_02_29_065540_create_personnel_descriptions_table', 1),
(13, '2020_03_01_092252_create_personnel_adds_table', 1),
(14, '2020_03_04_024206_create_received_purchase_orders_table', 1),
(15, '2020_03_04_024345_create_sku_add_details_table', 1),
(16, '2020_03_04_024527_create_received_jers_table', 1),
(17, '2020_03_05_060909_create_sku_ledgers_table', 1),
(18, '2020_03_10_054220_create_return_to_principals_table', 1),
(19, '2020_03_10_054819_create_return_to_principal_details_table', 1),
(20, '2020_03_11_064633_create_bo_allowance_adjustments_table', 1),
(21, '2020_03_11_075746_create_bo_allowance_adjustments_details_table', 1),
(22, '2020_03_11_081040_create_bo_allowance_adjustments_jers_table', 1),
(23, '2020_03_12_035653_create_return_to_principal_jers_table', 1),
(24, '2020_03_12_134358_create_invoice_cost_adjustments_table', 1),
(25, '2020_03_12_140415_create_invoice_cost_adjustment_details_table', 1),
(26, '2020_03_12_143225_create_invoice_cost_adjustments_jers_table', 1),
(27, '2020_03_13_035028_create_bodega_outs_table', 1),
(28, '2020_03_13_035058_create_bodega_out_details_table', 1),
(29, '2020_03_28_033525_create_transfer_to_brans_table', 1),
(30, '2020_03_28_033626_create_transfer_to_bran_details_table', 1),
(31, '2020_05_21_011325_create_principal_discount_pfcs_table', 2),
(32, '2020_05_22_052142_create_principal_discount_epis_table', 3),
(33, '2020_06_03_021903_create_principal_discount_doles_table', 4),
(34, '2020_06_08_050053_create_principal_discount_alaskas_table', 5),
(35, '2020_06_15_031342_create_principal_discount_cifpis_table', 6),
(36, '2020_08_05_011705_create_sales_order_temporaries_table', 7),
(37, '2020_08_05_012010_create_sales_order_details_temporaries_table', 7),
(38, '2020_08_07_021756_create_locations_table', 8),
(39, '2020_08_08_025230_create_location_details_table', 9),
(40, '2020_08_12_011848_create_customers_table', 10),
(41, '2020_08_12_021740_create_personnel_adds_table', 11),
(42, '2020_08_12_065039_create_personnel_add_details_table', 12),
(43, '2020_08_25_052339_create_customers_table', 13),
(44, '2020_08_25_070935_create_customer_discounts_table', 14),
(45, '2020_08_28_012901_create_sales_order_agents_table', 15),
(46, '2020_08_28_012918_create_sales_order_details_agents_table', 15),
(47, '2020_08_28_021740_create_sales_order_details_agents_table', 16),
(48, '2020_08_28_022817_create_sales_order_details_agents_table', 17),
(49, '2020_08_28_023702_create_sales_order_details_agents_table', 18),
(50, '2020_08_29_024939_create_sales_order_agent_holders_table', 19),
(51, '2020_08_29_024957_create_sales_order_agent_details_holders_table', 19),
(52, '2020_09_07_010245_create_principal_discounts_table', 20),
(53, '2020_09_07_010302_create_principal_discount_details_table', 20),
(54, '2020_09_20_023855_create_customer_ledgers_table', 21),
(55, '2020_09_20_024733_create_customer_ledgers_table', 22),
(56, '2020_09_20_034340_create_customer_ledgers_table', 23),
(57, '2020_09_21_011043_create_sales_order_printeds_table', 24),
(58, '2020_09_21_011651_create_sales_order_printed_details_table', 25),
(59, '2020_09_21_012252_create_sales_order_printed_details_table', 26),
(60, '2020_09_21_022951_create_sales_order_printeds_table', 27),
(61, '2020_09_21_023118_create_sales_order_printed_details_table', 28),
(62, '2020_09_25_004200_create_customer_category_discounts_table', 29),
(63, '2020_10_05_051749_create_sales_order_agent_details_holders_table', 30),
(64, '2020_11_02_031926_create_sales_order_prited_jers_table', 31),
(65, '2020_11_02_053847_create_sales_order_printed_jers_table', 32),
(66, '2020_11_02_065019_create_sales_order_printed_jers_table', 33),
(67, '2020_11_02_065110_create_sales_order_printed_jer_details_table', 34),
(68, '2020_11_25_020529_create_customer_payments_table', 35),
(69, '2020_11_25_020538_create_customer_payment_details_table', 35),
(70, '2020_11_25_020547_create_customer_payment_jers_table', 35),
(71, '2020_11_25_033250_create_customer_payments_table', 36),
(72, '2020_11_25_072215_create_cm_for_bos_table', 37),
(73, '2020_11_25_072224_create_cm_for_bo_details_table', 38),
(74, '2020_11_25_072238_create_cm_for_bo_jers_table', 38),
(75, '2020_11_26_062116_create_cm_for_rgs_table', 39),
(76, '2020_11_26_062130_create_cm_for_rgs_details_table', 39),
(77, '2020_11_26_062143_create_cm_for_rgs_jers_table', 39),
(78, '2020_11_28_051243_create_transfer_to_branch_jers_table', 40),
(79, '2020_12_29_011608_create_cm_for_others_table', 41),
(80, '2020_12_29_011621_create_cm_for_others_details_table', 41),
(81, '2020_12_29_013433_create_cm_for_others_details_table', 42),
(82, '2021_01_25_021506_create_principal_ledgers_table', 43),
(83, '2021_01_25_053451_create_principal_payments_table', 44),
(84, '2021_01_27_013537_add_new_fields_to_users_table', 45),
(85, '2021_02_12_020656_create_van_selling_ledger_models_table', 46),
(86, '2021_02_19_023407_create_van_selling_printeds_table', 47),
(87, '2021_02_19_023417_create_van_selling_printed_details_table', 47),
(88, '2021_02_23_023711_create_customer_principal_prices_table', 48),
(89, '2021_02_23_025443_create_driver_3rdmen_table', 49),
(90, '2021_02_23_030835_create_driver_helpers_table', 50),
(91, '2021_02_23_030846_create_driver_helper_charges_table', 50),
(92, '2021_02_23_034128_create_agents_table', 51),
(93, '2021_02_23_034821_create_agent_principals_table', 52),
(94, '2021_02_23_131018_create_agent_applied_customers_table', 53),
(95, '2021_03_16_014133_create_customer_principal_codes_table', 54),
(96, '2021_03_23_005843_create_sales_orders_table', 55),
(97, '2021_03_23_020406_create_sales_order_details_table', 56),
(98, '2021_03_25_012324_create_sales_order_prints_table', 57),
(99, '2021_03_25_012336_create_sales_order_print_details_table', 58),
(100, '2021_03_27_000537_create_sales_order_print_jers_table', 59),
(101, '2021_03_27_000552_create_sales_order_print_jer_details_table', 59),
(102, '2021_05_06_025004_create_van_selling_uploads_table', 60),
(103, '2021_05_20_005556_create_van_selling_upload_ledgers_table', 61),
(104, '2021_05_28_061032_create_van_selling_payments_table', 62),
(105, '2021_05_28_061549_create_van_selling_payment_details_table', 63),
(106, '2021_05_28_064043_create_van_selling_payment_details_table', 64),
(107, '2021_05_30_074929_create_pcm_uploads_table', 65),
(108, '2021_06_02_013401_create_pcm_upload_details_table', 66),
(109, '2021_07_01_073723_create_ar_ledgers_table', 67),
(110, '2021_07_10_025944_create_van_selling_ar_ledgers_table', 68),
(111, '2021_07_14_064423_create_pcm_upload_vs_table', 69),
(112, '2021_07_14_065527_create_pcm_upload_vs_details_table', 69),
(113, '2021_08_12_043223_create_van_selling_adjustments_table', 70),
(114, '2021_08_12_043232_create_van_selling_adjustments_details_table', 70),
(115, '2021_08_12_044651_create_van_selling_adjustments_details_table', 71),
(116, '2021_08_12_045204_create_van_selling_adjustments_table', 72),
(117, '2021_08_12_050231_create_van_selling_adjustments_table', 73),
(118, '2021_08_12_050545_create_van_selling_adjustments_details_table', 74),
(119, '2021_09_27_090846_create_van_selling_pcms_table', 75),
(120, '2021_09_27_090856_create_van_selling_pcm_details_table', 75),
(121, '2021_10_07_073138_create_van_selling_price_differences_table', 76),
(122, '2021_10_07_073147_create_van_selling_price_difference_details_table', 76),
(123, '2021_10_17_080928_create_van_selling_inventory_adjustments_table', 77),
(124, '2021_10_17_081818_create_van_selling_inventory_adjustments_details_table', 77),
(125, '2021_10_25_113850_create_van_selling_inventory_clearings_table', 78),
(126, '2022_02_24_131431_create_van_selling_sales_table', 79),
(127, '2022_02_28_114949_create_van_selling_beginnings_table', 80),
(128, '2022_03_10_103822_add_remarks_to_table_van_selling_ar_ledger', 80),
(129, '2022_03_11_122703_create_van_selling_transfer_inventories_table', 80),
(130, '2022_03_11_122807_create_van_selling_transfer_inventory_details_table', 80),
(131, '2022_03_11_152658_add_column_to_van_selling_transfer', 80),
(132, '2022_03_29_135216_add_column_to_table_pcm', 81),
(133, '2022_03_29_135441_add_column_to_table_pcm_details', 81),
(134, '2022_04_09_113032_add_column_outstanding_balance_to_table_van_selling_ar_ledger', 82),
(135, '2022_04_30_125633_add_column_to_table_inventory_adjustments_details', 83),
(136, '2022_07_29_190004_create_customer_uploads_table', 84),
(137, '2022_08_04_123829_create_sales_order_drafts_table', 84),
(138, '2022_08_04_124930_create_sales_order_draft_details_table', 84),
(139, '2022_08_04_125258_add_status_sales_order_draft', 84),
(140, '2022_08_05_122342_create_sales_invoices_table', 84),
(141, '2022_08_05_125820_add_total_sales_invoice', 84),
(142, '2022_08_05_130545_add_sales_invoice_status', 84),
(143, '2022_08_05_130721_add_sales_invoice_cancelled_date', 84),
(144, '2022_08_05_132142_create_sales_invoice_details_table', 84),
(145, '2022_08_05_132856_add_sales_invoice_id_on_details', 84),
(146, '2022_08_08_115823_add_weight_to_sales_invoice', 84),
(147, '2022_08_08_115957_add_separated_weight_to_sku_add', 84),
(148, '2022_08_08_123835_add_logistic_status_to_sales_invoice', 84),
(149, '2022_08_10_101632_add_control_to_sales_invoices', 84),
(150, '2022_08_10_102713_add_column_sales_invoices_printed', 84),
(151, '2022_08_10_113027_add_total_amount_per_sku_to_sales_invoice_details', 84),
(152, '2022_08_10_132305_add_customer_discount_column_to_sales_invoice', 84),
(153, '2022_08_10_224454_create_trucks_table', 84),
(154, '2022_08_10_225555_add_2_columns_to_sales_invoice', 84),
(155, '2022_08_11_115109_create_sales_invoice_status_logs_table', 84),
(156, '2022_08_11_120944_add_no_of_days_to_invoice_logs', 84),
(157, '2022_08_11_122153_add_date_delivered_sales_invoice', 84),
(158, '2022_08_11_124859_add_truck_status', 84),
(159, '2022_08_11_130304_create_truck_and_sales_invoices_table', 84),
(160, '2022_08_11_130648_create_truck_and_sales_invoice_details_table', 84),
(161, '2022_08_11_130813_add_user_id_to_sales_invoice_status_logs', 84),
(162, '2022_08_12_063215_add_columns_to_truck_and_sales_invoice', 84),
(163, '2022_08_12_231204_add_column_to_customer_table', 84),
(164, '2022_08_12_231405_add_coordinates_to_customer', 84),
(165, '2022_11_02_124457_create_van_selling_customers_table', 84),
(166, '2022_11_15_111740_create_van_selling_os_datas_table', 84),
(167, '2022_11_16_113837_add_customer_id_to_os_data', 84),
(168, '2022_11_16_114108_create_van_selling_calls_table', 84),
(169, '2023_01_31_061827_add_payment_status', 85),
(170, '2023_01_31_062634_add_total_paid', 86),
(171, '2023_01_31_070344_create_sales_invoice_deposit_check_slips_table', 87),
(172, '2023_02_06_103301_add_barcode_to_sku_adds', 88),
(173, '2023_02_06_105032_add_sub_category', 89),
(174, '2023_02_06_110059_create_sku_sub_categories_table', 90);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_resets`
--

INSERT INTO `password_resets` (`email`, `token`, `created_at`) VALUES
('salazarjohnsidney@gmail.com', '$2y$10$mLjGayn62Fw52Kqr.H2oCOdUt.guz1FkRFgh5xHVNgnf7khbpSZwa', '2021-02-01 22:38:15'),
('delimamelanie0@gmail.com', '$2y$10$4iQ04NHa.k0y.2cDolRkD.d5hmX7VkYI0308V.BicDK1oIQ3Kv3k2', '2021-11-15 17:03:41'),
('pqueennierutchin25@gmail.com', '$2y$10$fbX4wpZ/EVwgADbBJFYwU.5vzCGb7vM2dEp9E3A2Z1yS3yFCeouwS', '2022-01-09 17:30:28'),
('almajaca73@gmail.com', '$2y$10$trRlD0X6Vqr63Jf2h8DziOiaayx0ChedxH5bqcO0q5IMmbXbm3Mla', '2022-03-27 18:52:14'),
('dacillojanine29@gmail.com', '$2y$10$MG7Tmt361VRDFwK9V2ag7uD1vij1KU1AfZQWAlltnEFNZOVKZniVO', '2022-03-27 22:08:17'),
('d.renavie@yahoo.com', '$2y$10$uPSnqmGNflb3zQx1ReCV6.9hqZrfYnsr/jYPHRNI61XNZkuCeb7pe', '2022-04-01 18:48:02'),
('almhercomaling@gmail.com', '$2y$10$qJPansxlz0y9gCcVL/bl5OTzZJ4l1E.6kbo9W4nl5zQoCVhLb1QQ6', '2022-08-12 15:39:03');

-- --------------------------------------------------------

--
-- Table structure for table `pcm_uploads`
--

CREATE TABLE `pcm_uploads` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `bo_rgs_export_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `agent_id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `principal_id` int(10) UNSIGNED NOT NULL,
  `delivery_receipt` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `rgs_status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bo_status` char(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `returned_by` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pcm_upload_details`
--

CREATE TABLE `pcm_upload_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `pcm_upload_id` int(11) NOT NULL,
  `sku_id` int(10) UNSIGNED NOT NULL,
  `rgs_quantity` int(11) NOT NULL,
  `bo_quantity` int(11) NOT NULL,
  `unit_price` decimal(8,2) NOT NULL,
  `remarks` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pcm_upload_vs`
--

CREATE TABLE `pcm_upload_vs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `rgs_status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bo_status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pcm_upload_vs_details`
--

CREATE TABLE `pcm_upload_vs_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `pcm_upload_vs_id` bigint(20) UNSIGNED NOT NULL,
  `sku_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rgs_quantity` int(11) NOT NULL,
  `bo_quantity` int(11) NOT NULL,
  `unit_price` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remarks` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personnel_adds`
--

CREATE TABLE `personnel_adds` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `full_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `principal_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `personnel_description_id` bigint(20) UNSIGNED NOT NULL,
  `gender` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personnel_add_details`
--

CREATE TABLE `personnel_add_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `personnel_id` bigint(20) UNSIGNED NOT NULL,
  `principal_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personnel_descriptions`
--

CREATE TABLE `personnel_descriptions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `personnel_description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `principal_discounts`
--

CREATE TABLE `principal_discounts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `principal_id` int(10) UNSIGNED DEFAULT NULL,
  `total_discount` decimal(8,2) NOT NULL,
  `total_bo_allowance_discount` decimal(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `principal_discount_details`
--

CREATE TABLE `principal_discount_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `principal_discount_id` bigint(20) UNSIGNED NOT NULL,
  `discount_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `discount_rate` decimal(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `principal_discount_details`
--

INSERT INTO `principal_discount_details` (`id`, `principal_discount_id`, `discount_name`, `discount_rate`, `created_at`, `updated_at`) VALUES
(1, 1, 'D1', '2.00', '2021-10-01 17:37:18', '2021-10-01 17:37:18'),
(2, 1, 'D2', '2.00', '2021-10-01 17:37:18', '2021-10-01 17:37:18'),
(3, 1, 'D3', '2.00', '2021-10-01 17:37:19', '2021-10-01 17:37:19'),
(4, 1, 'D4', '2.00', '2021-10-01 17:37:19', '2021-10-01 17:37:19'),
(5, 1, 'D5', '2.00', '2021-10-01 17:37:19', '2021-10-01 17:37:19'),
(6, 1, 'D6', '1.00', '2021-10-01 17:37:19', '2021-10-01 17:37:19'),
(7, 2, 'D1', '2.00', '2021-10-01 17:38:01', '2021-10-01 17:38:01'),
(8, 2, 'D2', '2.00', '2021-10-01 17:38:01', '2021-10-01 17:38:01'),
(9, 2, 'D3', '2.00', '2021-10-01 17:38:01', '2021-10-01 17:38:01'),
(10, 2, 'D4', '2.00', '2021-10-01 17:38:01', '2021-10-01 17:38:01'),
(11, 2, 'D5', '2.00', '2021-10-01 17:38:01', '2021-10-01 17:38:01'),
(12, 2, 'D6', '1.00', '2021-10-01 17:38:01', '2021-10-01 17:38:01'),
(13, 3, 'D1', '16.68', '2021-10-01 17:42:00', '2021-10-01 17:42:00'),
(14, 4, 'D1', '0.17', '2021-10-01 17:42:18', '2021-10-01 17:42:18'),
(15, 5, 'D1', '17.65', '2021-10-01 17:42:31', '2021-10-01 17:42:31'),
(16, 6, 'D1', '7.00', '2021-10-01 17:42:42', '2021-10-01 17:42:42'),
(17, 7, 'D1', '11.50', '2021-10-01 17:43:03', '2021-10-01 17:43:03'),
(18, 8, 'D1', '8.00', '2021-10-01 17:45:32', '2021-10-01 17:45:32'),
(19, 9, 'discount', '16.68', '2021-10-08 23:44:55', '2021-10-08 23:44:55'),
(20, 10, 'SUNPRIDE', '5.00', '2022-03-13 18:37:17', '2022-03-13 18:37:17'),
(21, 11, 'SUNPRIDE', '5.00', '2022-03-13 19:00:38', '2022-03-13 19:00:38');

-- --------------------------------------------------------

--
-- Table structure for table `principal_ledgers`
--

CREATE TABLE `principal_ledgers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `principal_id` int(10) UNSIGNED NOT NULL,
  `rr_dr` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `principal_invoice` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `transaction` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `accounts_payable_beginning` decimal(15,4) NOT NULL,
  `received` decimal(15,4) NOT NULL,
  `returned` decimal(15,4) NOT NULL,
  `adjustment` decimal(15,4) NOT NULL,
  `payment` decimal(15,4) NOT NULL,
  `accounts_payable_end` decimal(15,4) NOT NULL,
  `date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `principal_payments`
--

CREATE TABLE `principal_payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `principal_id` int(10) UNSIGNED NOT NULL,
  `paid_by` int(11) NOT NULL,
  `cheque_number` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `disbursement_number` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `current_accounts_payable` decimal(15,4) NOT NULL,
  `payment` decimal(15,4) NOT NULL,
  `date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_orders`
--

CREATE TABLE `purchase_orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `purchase_id` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `principal_id` int(10) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `sales_order_number` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_term` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `delivery_term` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `particulars` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `po_confirmation_image` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `remarks` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_order_details`
--

CREATE TABLE `purchase_order_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `purchase_order_id` bigint(20) UNSIGNED NOT NULL,
  `sku_id` int(10) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  `receive` int(11) NOT NULL,
  `unit_cost` double(15,4) NOT NULL,
  `discount_rate` decimal(15,4) NOT NULL,
  `remarks` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `received_jers`
--

CREATE TABLE `received_jers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `principal_id` int(10) UNSIGNED NOT NULL,
  `received_id` bigint(20) UNSIGNED DEFAULT NULL,
  `dr` decimal(15,4) NOT NULL,
  `cr` decimal(15,4) NOT NULL,
  `date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `received_purchase_orders`
--

CREATE TABLE `received_purchase_orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `principal_discount_id` int(11) NOT NULL,
  `principal_id` int(10) UNSIGNED DEFAULT NULL,
  `purchase_order_id` bigint(20) UNSIGNED NOT NULL,
  `dr_si` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `truck_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `courier` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `invoice_date` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remarks` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `invoice_image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_freight` double(15,4) NOT NULL,
  `total_vatable_purchase` double(15,4) NOT NULL,
  `total_discount` double(15,4) NOT NULL,
  `total_bo_allowance_discount` double(15,4) NOT NULL,
  `total_vat_amount` double(15,4) NOT NULL,
  `grand_total_final_cost` double(15,4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `return_to_principals`
--

CREATE TABLE `return_to_principals` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `principal_id` int(10) UNSIGNED NOT NULL,
  `personnel_id` bigint(20) UNSIGNED NOT NULL,
  `received_id` bigint(20) UNSIGNED NOT NULL,
  `discount_id` int(11) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `return_vatable_purchase` decimal(15,4) NOT NULL,
  `return_less_discount` decimal(15,4) NOT NULL,
  `return_net_discount` decimal(15,4) NOT NULL,
  `return_vat_amount` decimal(15,4) NOT NULL,
  `return_net_of_deduction` decimal(15,4) NOT NULL,
  `remarks` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `total_amount_return` decimal(15,4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `return_to_principal_details`
--

CREATE TABLE `return_to_principal_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sku_id` int(10) UNSIGNED NOT NULL,
  `return_to_principal_id` bigint(20) UNSIGNED NOT NULL,
  `quantity_return` int(11) NOT NULL,
  `unit_cost` decimal(15,4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `return_to_principal_jers`
--

CREATE TABLE `return_to_principal_jers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `return_to_principal_id` bigint(20) UNSIGNED NOT NULL,
  `dr` decimal(15,4) NOT NULL,
  `cr` decimal(15,4) NOT NULL,
  `date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sales_invoices`
--

CREATE TABLE `sales_invoices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sales_order_draft_id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `principal_id` int(10) UNSIGNED DEFAULT NULL,
  `agent_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `mode_of_transaction` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sku_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sales_order_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `delivery_receipt` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `discount_rate` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `total` double(15,4) NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cancelled_date` date DEFAULT NULL,
  `cancelled_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `approved_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_weight` double(15,4) NOT NULL,
  `logistic_status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `control` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sales_invoice_printed` date DEFAULT NULL,
  `customer_discount` double(15,4) NOT NULL,
  `delivery_status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `delivery_date` date DEFAULT NULL,
  `delivered_date` date DEFAULT NULL,
  `payment_status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_payment` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sales_invoice_deposit_check_slips`
--

CREATE TABLE `sales_invoice_deposit_check_slips` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `file` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sales_invoice_deposit_check_slips`
--

INSERT INTO `sales_invoice_deposit_check_slips` (`id`, `customer_id`, `file`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 22, 'file-1675148939.png', 1, '2023-01-30 23:08:59', '2023-01-30 23:08:59');

-- --------------------------------------------------------

--
-- Table structure for table `sales_invoice_details`
--

CREATE TABLE `sales_invoice_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sku_id` int(10) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  `unit_price` double(15,4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `sales_invoice_id` bigint(20) UNSIGNED NOT NULL,
  `total_amount_per_sku` double(15,4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sales_invoice_details`
--

INSERT INTO `sales_invoice_details` (`id`, `sku_id`, `quantity`, `unit_price`, `created_at`, `updated_at`, `sales_invoice_id`, `total_amount_per_sku`) VALUES
(1, 956, 2, 10.3450, '2023-01-30 03:33:05', '2023-01-30 03:33:05', 1, 20.6900),
(2, 957, 1, 10.3500, '2023-01-30 03:33:05', '2023-01-30 03:33:05', 1, 10.3500),
(3, 958, 2, 10.3500, '2023-01-30 03:33:05', '2023-01-30 03:33:05', 1, 20.7000),
(4, 959, 2, 10.3500, '2023-01-30 03:33:05', '2023-01-30 03:33:05', 1, 20.7000),
(5, 963, 482, 10.3500, '2023-01-30 03:33:05', '2023-01-30 03:33:05', 1, 4988.7000),
(6, 971, 326, 73.1400, '2023-01-30 03:33:05', '2023-01-30 03:33:05', 1, 23843.6400),
(7, 983, 807, 0.0000, '2023-01-30 03:33:05', '2023-01-30 03:33:05', 1, 0.0000),
(8, 984, 651, 0.0000, '2023-01-30 03:33:05', '2023-01-30 03:33:05', 1, 0.0000),
(9, 956, 2, 10.3450, '2023-01-31 03:13:02', '2023-01-31 03:13:02', 2, 20.6900),
(10, 957, 1, 10.3500, '2023-01-31 03:13:02', '2023-01-31 03:13:02', 2, 10.3500),
(11, 958, 2, 10.3500, '2023-01-31 03:13:02', '2023-01-31 03:13:02', 2, 20.7000),
(12, 959, 2, 10.3500, '2023-01-31 03:13:02', '2023-01-31 03:13:02', 2, 20.7000),
(13, 963, 482, 10.3500, '2023-01-31 03:13:02', '2023-01-31 03:13:02', 2, 4988.7000),
(14, 971, 326, 73.1400, '2023-01-31 03:13:02', '2023-01-31 03:13:02', 2, 23843.6400),
(15, 983, 807, 0.0000, '2023-01-31 03:13:02', '2023-01-31 03:13:02', 2, 0.0000),
(16, 984, 651, 0.0000, '2023-01-31 03:13:02', '2023-01-31 03:13:02', 2, 0.0000),
(17, 956, 2, 10.3450, '2023-01-31 04:27:52', '2023-01-31 04:27:52', 3, 20.6900),
(18, 957, 1, 10.3500, '2023-01-31 04:27:52', '2023-01-31 04:27:52', 3, 10.3500),
(19, 958, 2, 10.3500, '2023-01-31 04:27:52', '2023-01-31 04:27:52', 3, 20.7000),
(20, 959, 2, 10.3500, '2023-01-31 04:27:52', '2023-01-31 04:27:52', 3, 20.7000),
(21, 963, 482, 10.3500, '2023-01-31 04:27:52', '2023-01-31 04:27:52', 3, 4988.7000),
(22, 971, 326, 73.1400, '2023-01-31 04:27:52', '2023-01-31 04:27:52', 3, 23843.6400),
(23, 983, 807, 0.0000, '2023-01-31 04:27:52', '2023-01-31 04:27:52', 3, 0.0000),
(24, 984, 651, 0.0000, '2023-01-31 04:27:52', '2023-01-31 04:27:52', 3, 0.0000);

-- --------------------------------------------------------

--
-- Table structure for table `sales_invoice_status_logs`
--

CREATE TABLE `sales_invoice_status_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sales_invoice_id` bigint(20) UNSIGNED NOT NULL,
  `posted` date DEFAULT NULL,
  `updated` date DEFAULT NULL,
  `status` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `no_of_days` int(11) DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sales_order_drafts`
--

CREATE TABLE `sales_order_drafts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `principal_id` int(10) UNSIGNED DEFAULT NULL,
  `agent_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `mode_of_transaction` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sku_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sales_order_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sales_order_draft_details`
--

CREATE TABLE `sales_order_draft_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sku_id` int(10) UNSIGNED NOT NULL,
  `sales_order_draft_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sales_order_prints`
--

CREATE TABLE `sales_order_prints` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `sales_order_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `agent_id` bigint(20) UNSIGNED NOT NULL,
  `principal_id` int(10) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `mode_of_transaction` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sku_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remarks` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `control` char(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status_cancel` char(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_paid_or_cancelled` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dr` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `date_delivered` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remitted_by` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `received_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `total_amount` decimal(15,4) NOT NULL,
  `total_customer_discount` decimal(15,4) NOT NULL,
  `total_line_discount` decimal(15,4) NOT NULL,
  `customer_discount_rate` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `vatable_amount` decimal(15,4) NOT NULL,
  `vat_amount` decimal(15,4) NOT NULL,
  `total_line_discount_1` decimal(15,4) NOT NULL,
  `total_line_discount_2` decimal(15,4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sales_order_print_jers`
--

CREATE TABLE `sales_order_print_jers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sales_order_print_id` bigint(20) UNSIGNED NOT NULL,
  `accounts_receivable` decimal(15,4) NOT NULL,
  `sales` decimal(15,4) NOT NULL,
  `remarks` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sku_adds`
--

CREATE TABLE `sku_adds` (
  `id` int(10) UNSIGNED NOT NULL,
  `sku_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_id` int(10) UNSIGNED DEFAULT NULL,
  `principal_id` int(10) UNSIGNED DEFAULT NULL,
  `unit_of_measurement` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sku_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `equivalent_sku_entryNo` int(11) DEFAULT NULL,
  `equivalent_butal_pcs` int(11) DEFAULT NULL,
  `reorder_point` int(11) DEFAULT NULL,
  `remarks` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `kilograms` double(15,4) NOT NULL,
  `grams` double(15,4) NOT NULL,
  `barcode` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sub_category` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sku_add_details`
--

CREATE TABLE `sku_add_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `received_id` bigint(20) UNSIGNED NOT NULL,
  `sku_id` int(10) UNSIGNED NOT NULL,
  `quantity_per_sku` int(11) NOT NULL,
  `quantity_return_per_sku` int(11) NOT NULL,
  `unit_cost_per_sku` double(15,4) NOT NULL,
  `final_unit_cost_per_sku` double(15,4) NOT NULL,
  `final_total_cost_per_sku` double(15,4) NOT NULL,
  `bo_allowance_discount_per_sku` double(15,4) NOT NULL,
  `bo_allowance_discount_rate_per_sku` double(15,4) NOT NULL,
  `discount_rate_per_sku` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `freight_per_sku` double(15,4) NOT NULL,
  `expiration_date` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remarks` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sku_categories`
--

CREATE TABLE `sku_categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `category` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `principal_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sku_categories`
--

INSERT INTO `sku_categories` (`id`, `category`, `created_at`, `updated_at`, `principal_id`) VALUES
(1, 'Alcohol', '2023-02-06 06:27:17', '2023-02-06 06:27:17', 2),
(2, 'Sampple', '2023-02-07 05:49:11', '2023-02-07 05:49:11', 2),
(3, 'Sample', '2023-02-07 05:49:41', '2023-02-07 05:49:41', 3);

-- --------------------------------------------------------

--
-- Table structure for table `sku_ledgers`
--

CREATE TABLE `sku_ledgers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sku_id` int(10) UNSIGNED NOT NULL,
  `principal_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `sku_type` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `in_out_adjustments` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rr_dr` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sales_order_number` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `principal_invoice` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` int(11) NOT NULL,
  `running_balance` int(11) NOT NULL,
  `unit_cost` double(15,4) NOT NULL,
  `total_cost` double(15,4) NOT NULL,
  `adjustments` double(15,4) NOT NULL,
  `running_total_cost` double(15,4) NOT NULL,
  `final_unit_cost` double(15,4) NOT NULL,
  `transaction_date` date NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sku_price_details`
--

CREATE TABLE `sku_price_details` (
  `id` int(10) UNSIGNED NOT NULL,
  `sku_id` int(11) NOT NULL,
  `unit_cost` decimal(15,4) NOT NULL,
  `price_1` decimal(15,4) NOT NULL,
  `price_2` decimal(15,4) NOT NULL,
  `price_3` decimal(15,4) NOT NULL,
  `price_4` decimal(15,4) NOT NULL,
  `price_5` decimal(15,4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sku_principals`
--

CREATE TABLE `sku_principals` (
  `id` int(10) UNSIGNED NOT NULL,
  `principal` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sku_principals`
--

INSERT INTO `sku_principals` (`id`, `principal`, `contact_number`, `created_at`, `updated_at`) VALUES
(0, 'None', '', NULL, NULL),
(2, 'GCI', '09455946843', '2020-05-12 17:07:59', '2020-05-12 17:07:59'),
(3, 'PFC', '09455946843', '2020-05-20 16:50:32', '2020-05-20 16:50:32'),
(4, 'EPI', '09455946843', '2020-05-21 21:06:50', '2020-05-21 21:06:50'),
(5, 'DOLE', '09455946843', '2020-06-02 17:01:25', '2020-06-02 17:01:25'),
(6, 'ALASKA', '09455946843', '2020-06-07 18:28:54', '2020-06-07 18:28:54'),
(7, 'CIFPI', '09455946843', '2020-06-14 16:50:09', '2020-06-14 16:50:09'),
(8, 'PPMC', '09455946843', '2020-06-17 20:51:13', '2020-06-17 20:51:13'),
(10, 'SUNPRIDE FOODS', '00000000', '2022-01-04 18:53:18', '2022-01-04 18:53:18'),
(11, 'GCI', '09533844872', '2023-02-07 05:10:43', '2023-02-07 05:10:43'),
(12, 'sample', '09533844872', '2023-02-07 05:13:01', '2023-02-07 05:13:01');

-- --------------------------------------------------------

--
-- Table structure for table `sku_sub_categories`
--

CREATE TABLE `sku_sub_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `main_category_id` int(10) UNSIGNED NOT NULL,
  `sub_category` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sku_sub_categories`
--

INSERT INTO `sku_sub_categories` (`id`, `main_category_id`, `sub_category`, `created_at`, `updated_at`) VALUES
(1, 1, 'Alcohol sub', '2023-02-06 06:33:08', '2023-02-06 06:33:08'),
(2, 1, 'Sample sub', '2023-02-07 05:50:00', '2023-02-07 05:50:00');

-- --------------------------------------------------------

--
-- Table structure for table `transfer_to_branch_jers`
--

CREATE TABLE `transfer_to_branch_jers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `received_id` bigint(20) UNSIGNED NOT NULL,
  `principal_id` int(10) UNSIGNED NOT NULL,
  `inventory_into_branch` double(15,4) NOT NULL,
  `inventory_out_origin` double(15,4) NOT NULL,
  `branch_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transfer_to_brans`
--

CREATE TABLE `transfer_to_brans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `received_id` bigint(20) UNSIGNED NOT NULL,
  `principal_id` int(10) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `branch` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transfer_to_bran_details`
--

CREATE TABLE `transfer_to_bran_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `transfer_id` bigint(20) UNSIGNED NOT NULL,
  `sku_id` int(10) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  `final_unit_cost` double(15,4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `trucks`
--

CREATE TABLE `trucks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `plate_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `capacity` double(15,4) NOT NULL,
  `model` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `trucks`
--

INSERT INTO `trucks` (`id`, `plate_no`, `capacity`, `model`, `created_at`, `updated_at`, `status`) VALUES
(1, 'KGB 7691', 1000.0000, '321123', '2023-01-30 04:35:56', '2023-01-30 12:46:14', 'On Going Delivery');

-- --------------------------------------------------------

--
-- Table structure for table `truck_and_sales_invoices`
--

CREATE TABLE `truck_and_sales_invoices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `truck_id` bigint(20) UNSIGNED NOT NULL,
  `driver` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `assistant` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `departure_date` date DEFAULT NULL,
  `departure_time` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `arrival_date` date DEFAULT NULL,
  `arrival_time` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `truck_and_sales_invoices`
--

INSERT INTO `truck_and_sales_invoices` (`id`, `truck_id`, `driver`, `assistant`, `user_id`, `created_at`, `updated_at`, `departure_date`, `departure_time`, `arrival_date`, `arrival_time`) VALUES
(1, 1, 'Tony Mantos', 'Assistant 1, Assistant 2', 1, '2023-01-30 12:37:15', '2023-01-30 12:46:14', '2023-01-30', '20:46', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `truck_and_sales_invoice_details`
--

CREATE TABLE `truck_and_sales_invoice_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `truck_si_id` bigint(20) UNSIGNED NOT NULL,
  `sales_invoice_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `truck_and_sales_invoice_details`
--

INSERT INTO `truck_and_sales_invoice_details` (`id`, `truck_si_id`, `sales_invoice_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '2023-01-30 12:37:15', '2023-01-30 12:37:15');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `position` char(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `secret_key` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `position`, `secret_key`, `created_at`, `updated_at`) VALUES
(1, 'Sidney Salazar Admin', 'salazarjohnsidney@gmail.com', NULL, '$2y$10$H/xQr1bKsf4kzvBAVJ5o1uLrSBXZr.GUd7yP2XWxfMmSHYeTln4eC', 'V5U52WwkfQP9pVFt5ftv8kHlZMZZVYlqH3BcRL5hUGUvKCxGujLN3D6NxHBv', 'System_admin', 'salazar', '2020-05-12 17:06:12', '2021-02-03 17:07:07'),
(2, 'Arlyn Fuentes', 'arlyn.fuentes14@yahoo.com', NULL, '$2y$10$RMZdCwGC8AhpyW2tP.YSJej9dtdR8WbdHqqllvnRuO4CXHoH4hvve', NULL, 'Inventory_head', 'salazar', '2020-07-14 22:36:17', '2020-07-14 22:36:17'),
(3, 'catherine maglinte', 'catherineyba003@gmail.com', NULL, '$2y$10$0xsvc4N0tYe3jHaHlahRieAGcIQl/OS8E2TYRFEmtvSN9inz564ny', 'PumXZZWTwU5OY3EO030RzyAlcmm0xpyHdadIot0PPAdM5CUqk22bAyk08TQv', '', '', '2021-01-28 18:49:22', '2021-01-28 18:49:22'),
(4, 'Rucel N. Lagman', 'rucel.torres.lagman@gmail.com', NULL, '$2y$10$iB3i8V87vL6riMNiefjL1OtP9E5rHTcVuPUNVmJiwYk9k2RQRGM0K', 'zEsE2DhTpDmZFS6IGBb2IiffFNPuOxDy6Gw0xvrfXvmtd554viEYhu43PliN', '', '', '2021-01-29 16:23:00', '2021-01-29 16:23:00'),
(5, 'catherine maglinte', 'catherinemalinte@yahoo.com', NULL, '$2y$10$WT7okYtV5JUQDZewPXGiUu93eBH5FFo1pShzFhK29oFXT.ch68K2G', NULL, '', '', '2021-02-02 17:33:22', '2021-02-02 17:33:22'),
(6, 'catherine maglinte', 'maglinte_catherine@yahoo.com', NULL, '$2y$10$CDosKvk62E9gb2tWUNQZDOrRm865nWD.7ZBch1zNd.kS3aN2o.3k2', 'qZqCwJRITllwc3cIbSebnOSrV5HXrV1CIZuXKa8ZBgPpNf6S38bjKEbjqgA7', '', '', '2021-02-03 21:52:52', '2021-02-03 21:52:52'),
(7, 'Vanessa Chiu', 'vanessachiu710@gmail.com', NULL, '$2y$10$M/exixXgwSwpiIAwd.CVpOSrpN1urgAjUxrNIFDvGbKC8Q.Ul23Be', 'kNXeeHisjp17N5BdqvGSpWNrzrghSupnqZhqR50cByN1sYrBMkhGK4gJ7c5K', '', '', '2021-02-05 21:34:20', '2021-02-05 21:34:20'),
(8, 'EMELIE DEXIMO', 'emeliedeximo12345@gmail.com', NULL, '$2y$10$UEJFwCvAoxwIDev6Ec9FN.OmokydrVDEJ2/8QrVvw9Yp/GRbIIkS2', 'ptc80gPZE9xH7XgG37BnMuyCOCSSy23xENPkZO4QutXbhi8XWyplj3Lj4EXy', '', '', '2021-07-16 16:10:30', '2021-07-16 16:10:30'),
(9, 'ROWENA G. CASTIL', 'dawendinz15@gmail.com', NULL, '$2y$10$N.kh5IY9N8O01otmHGf8DO2jxX5wUfm5HzlzV0hdWn9k2/gdKHH/m', NULL, '', '', '2021-07-19 00:32:30', '2021-07-19 00:32:30'),
(10, 'ALYSSA MACAN', 'assylamacan@gmail.com', NULL, '$2y$10$CnZ1j6hsr25E5toMhJ90sOppuGwEARoVrdnDCoEPj4vUjSy6c74ba', 'CPIio5Vs5jVFqhf7YIjuZsh3vjnk2U6g5IkdsKeWvxfHuvw5OAB5Rnv7se7S', '', '', '2021-07-21 18:37:01', '2021-07-21 18:37:01'),
(11, 'Reyna', 'reynaaguinot@gmail.com', NULL, '$2y$10$xfeySIOjXeU5FH0FDONdwuG2PZpDjjjoKNrlX1Hki3PuJ9ld/CJE2', 'W55vQSjh9sDYpUE4daA4WDO74PWNmKvapaYNoLxKqf4YDMRSRnjzBT8HZLfP', '', '', '2021-09-05 17:48:36', '2021-09-05 17:48:36'),
(12, 'ROSEMARIE ALUBA ABEJO', 'ROSEABEJO70@GMAIL.COM', NULL, '$2y$10$vzbb.3CboUt.9Y8AZbM8oOlasDtmi9nzrqtFbvQxMRlrY.Z8mryT6', NULL, '', '', '2021-09-12 16:47:01', '2021-09-12 16:47:01'),
(13, 'MELANIE G. DELIMA', 'delimamelanie0@gmail.com', NULL, '$2y$10$HfwHjXcLZGf4KbYgCMJD9OF0ZrnsSKY8UsVkicxZcJBJ4/daXPxCy', NULL, '', '', '2021-09-14 16:24:25', '2021-09-14 16:24:25'),
(14, 'MELANIE G. DELIMA', 'generalaomelanie25@gmail.com', NULL, '$2y$10$Tx8AHuAfpoxvzW2xVEyRWu0cvu8LA8p2ElDqZLsVZy6yGo2bPenmm', 'oM0vt3ScufnJz9cMcDfAsZDl2YeHpImirdkcc8eOjgC3PwCQH6Nnpb54illb', '', '', '2021-09-17 16:06:56', '2021-09-17 16:06:56'),
(15, 'CLUZ CLARITA BELA-ONG', 'cluzclarita28@gmail.com', NULL, '$2y$10$KO5aheGytvnaMCQzLxgRAe9WzRVvpnYZPctgt7t72tisrxmc1cK8K', NULL, '', '', '2021-10-05 17:17:29', '2021-10-05 17:17:29'),
(16, 'RAI', 'eerehsej24@gmail.com', NULL, '$2y$10$S5CfmYHhC6g7PLTDyAng0u.nlOLKKxlXSpt/dIGbwK7zMjClZBYIy', NULL, '', '', '2021-10-05 17:17:58', '2021-10-05 17:17:58'),
(17, 'RENAVIE2', 'd.renavie@yahoo.com', NULL, '$2y$10$gD9KIIJX51X2GHdzx3d4huI16MCkedzAa1jXaU9/lIhPR6FGWmo8q', NULL, '', '', '2021-10-05 17:19:26', '2021-10-05 17:19:26'),
(18, 'LESLIE', 'ee.joy56356@gmail.com', NULL, '$2y$10$1nNNR68kZxWuYorgX9w0oe7EoyRpwN.A2MPJemeg0.I57eZQxxpzq', 'xrn4J3rQQ8HIQCtwcR2kiJKVgQ6A1BsX2s1aNo9WN1rAc92Eb5neOMBNNrHp', '', '', '2021-10-05 17:20:31', '2021-10-05 17:20:31'),
(19, 'RUTCHIN', 'pqueennierutchin25@gmail.com', NULL, '$2y$10$W.EFV6rjy7haw3ZtkoBkhuc8bM07FPxfBKbKtsH49nKB7b85M5KTe', NULL, '', '', '2021-10-05 17:21:49', '2021-10-05 17:21:49'),
(20, 'Alma Jaca', 'almajaca73@gmail.com', NULL, '$2y$10$pIh7Z/VH4Y/.Qq2Y04HdpeEpVUXPYpM264IYIDkLBgBGyhipWXEZO', NULL, '', '', '2021-10-05 17:30:19', '2021-10-05 17:30:19'),
(21, 'RUTCHIN', 'rutchin@gmail.com', NULL, '$2y$10$xmwRWq3uEUqCj.nyIOFV2e7y3NwrbgFLgcj.4Umd4jO6HWASDyMxS', NULL, '', '', '2021-10-15 17:07:16', '2021-10-15 17:07:16'),
(22, 'ALMHER P.COMLAING', 'almhercomaling@gmail.com', NULL, '$2y$10$aF5pXZG/gn7/ThDfN4tHou8MVe/Vus8sCxb/j.XcDoNEfH3i9fTAq', NULL, 'Audit_head', 'almer', '2021-10-15 23:09:29', '2021-10-15 23:09:29'),
(23, 'JANINE', 'dacillojanine29@gmail.com', NULL, '$2y$10$kGXI1DMTO5q9/PjQCoZxiOvPl8P3GJ9wADEAywf3Y140uaWVaQk1C', NULL, '', '', '2021-10-28 21:49:23', '2021-10-28 21:49:23'),
(24, 'Sarah Belle Hero', 'julmarcommercial@yahoo.com', NULL, '$2y$10$SmJcL70ivQFBfqTfLsBPouBSjNnj6HEIsSj8mqvvi.GeiD69CeC5e', NULL, '', '', '2021-10-29 15:52:57', '2021-10-29 15:52:57'),
(25, 'emelie deximo', 'emeliedeximo123456@gmail.com', NULL, '$2y$10$B1pEFtSN9WUI8MnRbI60bO68iDfTCo.X0nxAuLPBihCwg0mo6w6Zy', 'cyTiOLxsbfxoTBcwNArbD99OlDGBNRZL6VKGyZreuW7ZdQrd1GwJZDIcntY3', '', '', '2021-11-09 16:32:28', '2021-11-09 16:32:28'),
(26, 'JANINE ANDOY DACILLO', 'janine_dacillo@yahoo.com', NULL, '$2y$10$r3K9Ec5jXIZq4dISTDamiOWtzuVGIOi0VesfZaW1gi3rFfDD7RNWO', NULL, '', '', '2021-12-12 21:47:11', '2021-12-12 21:47:11'),
(27, 'ANDY B. ANDOY', 'andyandoy195@yahoo.com', NULL, '$2y$10$gBo4S19bprTxZ1pKvUwwU.yykDgiBL4ycq9aYZAwEHrhIdVVl3HPC', 'PWPAhtyI1l1Pzn02s7ElzLV0BbiRVZl6WSCNdkQBc07zOEu85MGRXDHP2KKc', 'Audit_head', 'xyz23arc', '2021-12-26 17:30:55', '2022-01-18 20:19:57'),
(28, 'Raymond Lloyd M. Bahade', 'RAYMONDBAHADE16@GMAIL.COM', NULL, '$2y$10$zJOcrG3IsictfYU5yicDd.v.9aEoKa53aWUdqVOrNzzii1OjbnX6a', 'PBE81wDLo6hOBD6XtCAdvqG06QUkMPcA7ndSy7NvY8DxETXL3c120CBab43h', 'Audit_staff', '', '2021-12-26 17:32:25', '2021-12-26 17:32:25'),
(29, 'Kent Marvin Caballero', 'kentcaballero13@gmail.com', NULL, '$2y$10$v7Le59vkLucoVwkDetYh3uyJ4.W.8e.ANR/AFRstFro8qfrDJgSpq', NULL, 'Audit_staff', '', '2021-12-26 18:53:19', '2021-12-26 18:53:19'),
(30, 'RUTCHIN', 'prutchin25@gmail.com', NULL, '$2y$10$yjaJOOAiHP1JW8ks9WYhZe/q71vrO/vt0BmpM2pjkfpyQJHwmMUvS', NULL, 'Audit_staff', '', '2022-01-09 17:33:02', '2022-01-09 17:33:02'),
(31, 'ALYSSA MACAN', 'macanalyssa@yahoo.com', NULL, '$2y$10$LaPCbZDTgUA2dx3L/.oX1eT0L6f2u3wDLNzSVP82zusIM9lgXkY1y', NULL, '', '', '2022-02-09 22:48:18', '2022-02-09 22:48:18'),
(32, 'Alma Jaca', 'almajaca1@gmail.com', NULL, '$2y$10$03sPhjGiPMM3dj/P0G8./eGU7Xm4CREFomRVV6tJFVmmITnnfR4ai', NULL, '', '', '2022-02-10 19:38:29', '2022-02-10 19:38:29'),
(33, 'JESSA PITOGO', 'JEFL.PITOGO@COC.PHINMA.EDU.PH', NULL, '$2y$10$TXrYyZuJ5rLcGSZEB9im8uskTGevEZd1JhpmTrHQ6fyfq8/FOy0Jm', NULL, '', '', '2022-02-10 19:46:40', '2022-02-10 19:46:40'),
(34, 'Geraldine Sajulan', 'sajulangeraldine@gmail.com', NULL, '$2y$10$TN5scsio6j7hS4dn.rkH2OseM7ruXx7w.G3cufZd3TkFJNdNtXloC', NULL, '', '', '2022-02-13 21:07:15', '2022-02-13 21:07:15'),
(35, 'HAZEL LACANLALE', 'hazellacanlale63@yahoo.com', NULL, '$2y$10$2J/V21WFT/IEeqmGCKltdem.u/Wp.PSWca9opG/36k6J1D8y0fifW', 'sfwHb4lm8MFu8F1B0DTiXlwTZGKlu4M5U67Il6PzasS8li5QjAeIBBOTNZD6', '', '', '2022-02-16 22:12:54', '2022-02-16 22:12:54'),
(36, 'Alma Jaca', 'almajaca01@gmail.com', NULL, '$2y$10$xEMUUu5lkHtBHRNPrWkXP.Ik5L.sPxwkPiy3np23VQIefU0.ltm6O', NULL, '', '', '2022-02-21 19:39:50', '2022-02-21 19:39:50'),
(37, 'RENAVIE', 'Lyncha1309@yahoo.com', NULL, '$2y$10$06FMZT7YVPde6F.L9dpQoehl3piYl5L3oVdAcu7.QmDo9ZSnIupcO', NULL, '', '', '2022-03-04 18:01:35', '2022-03-04 18:01:35'),
(38, 'JANINE ANDOY DACILLO', 'janine_dacillo29@gmail.com', NULL, '$2y$10$d.PhcEbA8LbbAuanweJtYOQ2Mwr9EluC7hDJx.uWwBO5cdfGU1wJi', 'puKJu3uSBr4MlC6vleypMbQRG6q3V8XJmSetv8nbprUiWIbx6oJIXCZc4TrH', '', '', '2022-03-27 22:14:28', '2022-03-27 22:14:28'),
(39, 'JESSA PITOGO', 'batman1993@gmail.com', NULL, '$2y$10$8P/wLICYRuDSozd5EVkNqe5zxAxkHnEb2XwOBZLvTymfNosJND3R2', NULL, '', '', '2022-03-29 00:24:32', '2022-03-29 00:24:32'),
(40, 'RUTCHIN', 'prutchin2595@gmail.com', NULL, '$2y$10$5csim1JR3N8qs0dnFy8e8.GWxPHEi.rxlXpaVJ6Dr/JVENa5sKP3i', 'tMCAVxEQ2oKgI7K31O2P6mUqQQEJpXbve0qj2xgqMXq9ti33NJflzUyRkjBb', '', '', '2022-04-01 18:47:20', '2022-04-01 18:47:20'),
(41, 'renavie', 'bebe_121@yahoo.com', NULL, '$2y$10$oUS7K9N6u8XbhtBAFyl8DO8TUDHp8ZcNCZa7ALpGvR2lGytcO1mNS', NULL, '', '', '2022-04-01 18:49:41', '2022-04-01 18:49:41'),
(42, 'RENAVIE S DELA CRUZ', 'rerna@yahoo.com', NULL, '$2y$10$r91MDwQL0uIRxuc7N63rze6nTFFTwWg5.YYF2DZLDQyde/0tvhFMO', NULL, '', '', '2022-04-17 22:28:13', '2022-04-17 22:28:13'),
(43, 'RUTCHIN', 'queen_rutchin@gmail.com', NULL, '$2y$10$ExXyykKk9fqIESEOzQH1fekDZzvOSV19JY23oUhqPaAma9IAMGg3C', NULL, '', '', '2022-04-19 00:14:12', '2022-04-19 00:14:12'),
(44, 'JESSA PITOGO', 'JEFL.PITOGO13@COC.PHINMA.EDU.PH', NULL, '$2y$10$rus5ZQPeMpEdYRxZqFKSee.Fh3O9718U/OHt6z7eytFIUTbPj96a6', 'oC46BN3Gx9jMPG5K1x9ZEM61WdeTwvfPULSc5OiTHotRmcsTGH3lZyOSK2y9', '', '', '2022-04-22 20:39:37', '2022-04-22 20:39:37'),
(45, 'RECA MAE PADICA', 'recamaepadica8@gmail.com', NULL, '$2y$10$wbSEGF1QuZOK1l/SojomlOu/j865vjhg5we3ZEaKEKSJQv9y/1si6', 'jE69gOi8BSZs2LJYtencsv3ZojyJd0J67vIDmHtBsN3VdrohDAB9jv4a30Fb', '', '', '2022-05-02 17:25:12', '2022-05-02 17:25:12'),
(46, 'Agustin Herrera', 'agustinherrera@gmail.com', NULL, '$2y$10$eTGxxHfUxfuviCV8nkwxq.cZYN5xU5RYaQUczB4JIwN9no5jAZ6ce', NULL, '', '', '2022-06-24 22:18:21', '2022-06-24 22:18:21'),
(47, 'Almher Comaling', 'almhercomaling1@gmail.com', NULL, '$2y$10$D.Pi/p7xAfGcfHOw9B91zem1KSHX1BLR6isadD3AXSIyqIF.FvlN2', NULL, '', '', '2022-06-24 22:29:57', '2022-06-24 22:29:57'),
(48, 'Merry Flor  J. Go', 'merryflorgo@gmail.com', NULL, '$2y$10$/.QwRZhZ42DbzHts4.PQVeJdJIW45QmdEEo1XLjLggXWl9vpd7P.m', 'hYJgavRWtYsNkbIReOJr9KFK47XlZZHDGounB8srOdfS22uQcCX05AoAI7kH', '', '', '2022-06-29 23:17:39', '2022-06-29 23:17:39'),
(49, 'MERRY GRACE', 'merrygrace@gmail.com', NULL, '$2y$10$UlIS7nOqciF.A.PTSWrSOujtPOQmFwQ7kWbr5pBdF2VYcarsG4ob2', NULL, '', '', '2022-08-26 23:12:10', '2022-08-26 23:12:10'),
(50, 'hazel lacanlale', 'hazellacanlale4@yahoo.com', NULL, '$2y$10$/mXX53vLNcG8tgBDVljePedhrysjRR/qyRqgcNGhQI0ZlQXkZCUIW', NULL, '', '', '2022-09-22 00:04:45', '2022-09-22 00:04:45'),
(51, 'CRESIL JOY', 'tapayan.cresiljoy@gmail.com', NULL, '$2y$10$rRTwP/hA4RAJyxP4aSXJKOeZBaPhRd1i6mAra75JOM74Kmh9g3K2.', NULL, '', '', '2022-10-06 21:22:42', '2022-10-06 21:22:42'),
(52, 'Bernil Gallereno', 'bernilgallereno@gmail.com', NULL, '$2y$10$zQQ7TsTkvAI9ZQvJyEZJFetzbwIAAd5l8NjO5Pdc50uUNu7SaUEaK', NULL, '', '', '2022-10-11 17:24:07', '2022-10-11 17:24:07'),
(53, 'Arnel Ardiza', 'arnelardiza@gmail.com', NULL, '$2y$10$El61U1a2Wl6RL01GGhTSae324nk953r997Ru32RItDVbMLYlyqn02', NULL, '', '', '2022-10-11 17:27:56', '2022-10-11 17:27:56'),
(54, 'Jonathan Amihan', 'jonathanamihan@gmail.com', NULL, '$2y$10$5/mGdEloVedYnuGjlR.p/u4Komv96fmMJTjl2FH5VAaFVfnyC1Ibq', NULL, '', '', '2022-10-11 17:30:07', '2022-10-11 17:30:07'),
(55, 'Jolly Corpuz', 'corpuzjolly@gmail.com', NULL, '$2y$10$g0UqOBhzMONJRUgUkhVZSeSqSgBqTDz3Vi/DN1MiGCBbyPmqF4KB6', NULL, '', '', '2022-10-11 17:33:33', '2022-10-11 17:33:33'),
(56, 'Alex Tura', 'alextura@gmail.com', NULL, '$2y$10$LkqJNwXBhng.p7pwjYQ6YOV.VOouaWrtePgrUuxqBZcibPgz5mOpG', NULL, '', '', '2022-10-11 17:36:44', '2022-10-11 17:36:44'),
(57, 'Joy Aguilar', 'aguilarjoy@gmail.com', NULL, '$2y$10$1p7vKqUYa/Pm5B1qZEHV6uGAC7Wx0i3aao89on.DTOdbPfNXv1lHK', NULL, '', '', '2022-10-11 17:37:51', '2022-10-11 17:37:51');

-- --------------------------------------------------------

--
-- Table structure for table `van_selling_adjustments`
--

CREATE TABLE `van_selling_adjustments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `van_selling_printed_id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `approved_by` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `remarks` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `van_selling_adjustments_details`
--

CREATE TABLE `van_selling_adjustments_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `vs_adjustments_id` bigint(20) UNSIGNED NOT NULL,
  `sku_id` int(10) UNSIGNED NOT NULL,
  `original_quantity` int(11) NOT NULL,
  `adjusted_quantity` int(11) NOT NULL,
  `price` double(15,4) NOT NULL,
  `remarks` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `van_selling_ar_ledgers`
--

CREATE TABLE `van_selling_ar_ledgers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `van_selling_print_id` bigint(20) UNSIGNED DEFAULT NULL,
  `van_selling_payment_id` bigint(20) UNSIGNED DEFAULT NULL,
  `vs_inv_adj_id` int(11) DEFAULT NULL,
  `vs_adjustments_id` int(11) DEFAULT NULL,
  `vs_price_diff_id` int(11) DEFAULT NULL,
  `vs_inv_clear_id` int(11) DEFAULT NULL,
  `running_balance` double(15,4) NOT NULL,
  `should_be` double(15,4) NOT NULL,
  `principal_id` int(10) UNSIGNED DEFAULT NULL,
  `amount` double(15,4) DEFAULT NULL,
  `collection` double(15,4) DEFAULT NULL,
  `cm_amount` double(15,4) NOT NULL,
  `cancelled_amount` double(15,4) NOT NULL,
  `price_update` double(15,4) NOT NULL,
  `ns_adjustments` double(15,4) NOT NULL,
  `adjustments` double(15,4) NOT NULL,
  `sku_price_adjustments` double(15,4) NOT NULL,
  `inventory_adjustments` double(15,4) NOT NULL,
  `clearing` double(15,4) NOT NULL,
  `charge_payment` double(15,4) NOT NULL,
  `actual_stocks_on_hand` double(15,4) NOT NULL,
  `over_short` double(15,4) NOT NULL,
  `van_selling_pcm_id` int(11) DEFAULT NULL,
  `date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `remarks` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `outstanding_balance` double(15,4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `van_selling_ar_ledgers`
--

INSERT INTO `van_selling_ar_ledgers` (`id`, `customer_id`, `user_id`, `van_selling_print_id`, `van_selling_payment_id`, `vs_inv_adj_id`, `vs_adjustments_id`, `vs_price_diff_id`, `vs_inv_clear_id`, `running_balance`, `should_be`, `principal_id`, `amount`, `collection`, `cm_amount`, `cancelled_amount`, `price_update`, `ns_adjustments`, `adjustments`, `sku_price_adjustments`, `inventory_adjustments`, `clearing`, `charge_payment`, `actual_stocks_on_hand`, `over_short`, `van_selling_pcm_id`, `date`, `created_at`, `updated_at`, `remarks`, `outstanding_balance`) VALUES
(2600, 20, 34, 1407, NULL, NULL, NULL, NULL, NULL, 201309.2000, 0.0000, 5, 1924.5600, NULL, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 18520.7400, NULL, '2022-10-24', '2022-10-24 07:04:46', '2022-10-24 07:04:46', '', 201309.2000),
(2601, 20, 34, 1408, NULL, NULL, NULL, NULL, NULL, 207027.1600, 0.0000, 3, 5717.9600, NULL, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 18520.7400, NULL, '2022-10-26', '2022-10-26 07:14:45', '2022-10-26 07:14:45', '', 207027.1600),
(2602, 20, 34, 1409, NULL, NULL, NULL, NULL, NULL, 208951.7200, 0.0000, 5, 1924.5600, NULL, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 18520.7400, NULL, '2022-10-26', '2022-10-26 07:16:25', '2022-10-26 07:16:25', '', 208951.7200),
(2603, 20, 34, 1410, NULL, NULL, NULL, NULL, NULL, 217374.6900, 0.0000, 2, 8422.9700, NULL, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 18520.7400, NULL, '2022-10-26', '2022-10-26 07:18:53', '2022-10-26 07:18:53', '', 217374.6900),
(2604, 20, 34, 1411, NULL, NULL, NULL, NULL, NULL, 221922.9300, 0.0000, 8, 4548.2400, NULL, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 18520.7400, NULL, '2022-10-26', '2022-10-26 07:20:20', '2022-10-26 07:20:20', '', 221922.9300),
(2605, 20, 34, 1412, NULL, NULL, NULL, NULL, NULL, 237444.9300, 0.0000, 10, 15522.0000, NULL, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 18520.7400, NULL, '2022-10-26', '2022-10-26 07:21:41', '2022-10-26 07:21:41', '', 237444.9300),
(2606, 20, 34, 1413, NULL, NULL, NULL, NULL, NULL, 253719.3300, 0.0000, 7, 16274.4000, NULL, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 18520.7400, NULL, '2022-10-26', '2022-10-26 08:11:41', '2022-10-26 08:11:41', '', 253719.3300),
(2607, 20, 47, NULL, NULL, NULL, NULL, NULL, NULL, 253719.3300, 0.0000, NULL, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 160955.8300, 111284.2400, NULL, '2022-10-29', '2022-10-29 03:26:14', '2022-10-29 03:26:14', '', 253719.3300),
(2608, 20, 34, 1414, NULL, NULL, NULL, NULL, NULL, 279374.0500, 0.0000, 2, 25654.7200, NULL, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 111284.2400, NULL, '2022-11-02', '2022-11-02 04:52:52', '2022-11-02 04:52:52', '', 279374.0500),
(2609, 20, 34, 1415, NULL, NULL, NULL, NULL, NULL, 288953.3500, 0.0000, 7, 9579.3000, NULL, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 111284.2400, NULL, '2022-11-02', '2022-11-02 04:54:07', '2022-11-02 04:54:07', '', 288953.3500),
(2610, 20, 34, 1416, NULL, NULL, NULL, NULL, NULL, 299183.6900, 0.0000, 3, 10230.3400, NULL, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 111284.2400, NULL, '2022-11-02', '2022-11-02 05:33:21', '2022-11-02 05:33:21', '', 299183.6900),
(2611, 20, 34, 1417, NULL, NULL, NULL, NULL, NULL, 301263.5900, 0.0000, 3, 2079.9000, NULL, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 111284.2400, NULL, '2022-11-02', '2022-11-02 08:23:38', '2022-11-02 08:23:38', '', 301263.5900),
(2612, 20, 34, NULL, 506, NULL, NULL, NULL, NULL, 285178.5900, 0.0000, NULL, 0.0000, 16085.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 111284.2400, NULL, '2022-11-03', '2022-11-03 01:27:05', '2022-11-03 01:27:05', 'COLLECTION  LAST  OCT 21', 285178.5900),
(2613, 20, 34, NULL, 507, NULL, NULL, NULL, NULL, 282728.5900, 0.0000, NULL, 0.0000, 2450.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 111284.2400, NULL, '2022-11-03', '2022-11-03 01:32:01', '2022-11-03 01:32:01', 'COLLECTION  LAST  OCT 24', 282728.5900),
(2614, 20, 34, NULL, 508, NULL, NULL, NULL, NULL, 260213.5900, 0.0000, NULL, 0.0000, 22515.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 111284.2400, NULL, '2022-11-03', '2022-11-03 01:33:07', '2022-11-03 01:33:07', 'COLLECTION  LAST  OCT 25', 260213.5900),
(2615, 20, 34, NULL, 509, NULL, NULL, NULL, NULL, 247667.5900, 0.0000, NULL, 0.0000, 12546.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 111284.2400, NULL, '2022-11-03', '2022-11-03 01:34:03', '2022-11-03 01:34:03', 'COLLECTION  LAST  OCT 26', 247667.5900),
(2616, 20, 34, NULL, 510, NULL, NULL, NULL, NULL, 209887.5900, 0.0000, NULL, 0.0000, 37780.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 111284.2400, NULL, '2022-11-03', '2022-11-03 01:35:03', '2022-11-03 01:35:03', 'COLLECTION  LAST  OCT 28', 209887.5900),
(2617, 20, 34, NULL, 511, NULL, NULL, NULL, NULL, 204397.5900, 0.0000, NULL, 0.0000, 5490.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 111284.2400, NULL, '2022-11-03', '2022-11-03 01:37:10', '2022-11-03 01:37:10', 'COLLECTION  LAST  NOV 2', 204397.5900),
(2618, 20, 34, NULL, NULL, NULL, NULL, NULL, NULL, 204080.1600, 0.0000, NULL, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 317.4300, 0.0000, 110966.8100, NULL, '2022-11-03', '2022-11-03 01:43:54', '2022-11-03 01:43:54', 'SHORT', 204080.1600),
(2619, 20, 34, NULL, NULL, NULL, NULL, NULL, NULL, 203453.0200, 0.0000, 0, 0.0000, 0.0000, 627.1400, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 110966.8100, 136, '2022-11-03', '2022-11-03 01:44:45', '2022-11-03 01:44:45', '', 203453.0200),
(2620, 20, 34, NULL, NULL, NULL, NULL, NULL, NULL, 203391.8700, 0.0000, 0, 0.0000, 0.0000, 61.1500, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 110966.8100, 135, '2022-11-03', '2022-11-03 01:44:57', '2022-11-03 01:44:57', '', 203391.8700),
(2621, 20, 34, NULL, NULL, NULL, NULL, NULL, NULL, 92425.0600, 0.0000, NULL, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 110966.8100, 0.0000, 0.0000, NULL, '2022-11-03', '2022-11-03 01:49:42', '2022-11-03 01:49:42', 'CHARGE PAYMENT', 92425.0600),
(2622, 20, 34, NULL, NULL, NULL, NULL, NULL, NULL, 203391.8700, 0.0000, 0, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 110966.8100, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, NULL, '2022-11-03', '2022-11-03 01:50:25', '2022-11-03 01:50:25', 'ADJUSTMENT', 203391.8700),
(2623, 20, 34, NULL, NULL, NULL, NULL, NULL, NULL, 156910.6200, 0.0000, 0, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, -46481.2500, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, NULL, '2022-11-03', '2022-11-03 01:51:25', '2022-11-03 01:51:25', 'LESS ADJUSTMENT', 156910.6200),
(2624, 20, 34, 1418, NULL, NULL, NULL, NULL, NULL, 158061.0200, 0.0000, 3, 1150.4000, NULL, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, NULL, '2022-11-03', '2022-11-03 08:27:41', '2022-11-03 08:27:41', '', 158061.0200),
(2625, 20, 34, 1419, NULL, NULL, NULL, NULL, NULL, 159211.4200, 0.0000, 3, 1150.4000, NULL, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, NULL, '2022-11-03', '2022-11-03 08:41:45', '2022-11-03 08:41:45', '', 159211.4200),
(2626, 20, 34, 1420, NULL, NULL, NULL, NULL, NULL, 160361.8200, 0.0000, 3, 1150.4000, NULL, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, NULL, '2022-11-04', '2022-11-04 00:43:00', '2022-11-04 00:43:00', '', 160361.8200),
(2627, 20, 48, NULL, NULL, NULL, NULL, NULL, NULL, 161410.5700, 0.0000, 0, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 1048.7500, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, NULL, '2022-11-04', '2022-11-04 01:20:49', '2022-11-04 01:20:49', 'DEBIT MEMO', 161410.5700),
(2628, 20, 48, NULL, 512, NULL, NULL, NULL, NULL, 147230.5700, 0.0000, NULL, 0.0000, 14180.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, NULL, '2022-11-04', '2022-11-04 01:23:05', '2022-11-04 01:23:05', 'Collection', 147230.5700),
(2629, 20, 48, NULL, 513, NULL, NULL, NULL, NULL, 137417.5700, 0.0000, NULL, 0.0000, 9813.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, NULL, '2022-11-04', '2022-11-04 08:20:08', '2022-11-04 08:20:08', 'Collection', 137417.5700),
(2630, 20, 47, NULL, NULL, NULL, NULL, NULL, NULL, 137417.5700, 0.0000, NULL, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 182015.0600, 0.0000, NULL, '2022-11-05', '2022-11-05 03:12:32', '2022-11-05 03:12:32', '', 137417.5700),
(2631, 20, 34, 1421, NULL, NULL, NULL, NULL, NULL, 146456.7700, 0.0000, 3, 9039.2000, NULL, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, NULL, '2022-11-05', '2022-11-05 07:35:30', '2022-11-05 07:35:30', '', 146456.7700),
(2632, 20, 34, 1422, NULL, NULL, NULL, NULL, NULL, 151362.9000, 0.0000, 2, 4906.1300, NULL, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, NULL, '2022-11-05', '2022-11-05 07:36:34', '2022-11-05 07:36:34', '', 151362.9000),
(2633, 20, 34, 1423, NULL, NULL, NULL, NULL, NULL, 160262.9400, 0.0000, 8, 8900.0400, NULL, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, NULL, '2022-11-05', '2022-11-05 07:37:58', '2022-11-05 07:37:58', '', 160262.9400),
(2634, 20, 34, 1424, NULL, NULL, NULL, NULL, NULL, 164889.2600, 0.0000, 2, 4626.3200, NULL, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, NULL, '2022-11-09', '2022-11-09 06:17:47', '2022-11-09 06:17:47', '', 164889.2600),
(2635, 20, 34, 1425, NULL, NULL, NULL, NULL, NULL, 179312.2800, 0.0000, 3, 14423.0200, NULL, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, NULL, '2022-11-09', '2022-11-09 07:11:06', '2022-11-09 07:11:06', '', 179312.2800),
(2636, 20, 34, 1426, NULL, NULL, NULL, NULL, NULL, 188962.2800, 0.0000, 10, 9650.0000, NULL, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, NULL, '2022-11-09', '2022-11-09 07:15:49', '2022-11-09 07:15:49', '', 188962.2800),
(2637, 20, 48, NULL, 514, NULL, NULL, NULL, NULL, 129319.2800, 0.0000, NULL, 0.0000, 59643.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, NULL, '2022-11-09', '2022-11-09 07:49:35', '2022-11-09 07:49:35', 'COLLECTION', 129319.2800),
(2638, 20, 48, NULL, 515, NULL, NULL, NULL, NULL, 121624.2800, 0.0000, NULL, 0.0000, 7695.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, NULL, '2022-11-09', '2022-11-09 07:50:50', '2022-11-09 07:50:50', 'COLLECTION', 121624.2800),
(2639, 20, 8, 1427, NULL, NULL, NULL, NULL, NULL, 127459.7500, 0.0000, 2, 5835.4700, NULL, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, NULL, '2022-11-12', '2022-11-12 06:28:45', '2022-11-12 06:28:45', '', 127459.7500),
(2640, 20, 29, NULL, NULL, NULL, NULL, NULL, NULL, 127459.7500, 0.0000, NULL, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 136938.8900, 0.0000, NULL, '2022-11-12', '2022-11-12 06:52:32', '2022-11-12 06:52:32', '', 127459.7500),
(2641, 20, 34, 1428, NULL, NULL, NULL, NULL, NULL, 135109.7500, 0.0000, 10, 7650.0000, NULL, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, NULL, '2022-11-14', '2022-11-14 09:04:43', '2022-11-14 09:04:43', '', 135109.7500),
(2642, 20, 34, 1429, NULL, NULL, NULL, NULL, NULL, 138182.7100, 0.0000, 7, 3072.9600, NULL, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, NULL, '2022-11-14', '2022-11-14 09:05:33', '2022-11-14 09:05:33', '', 138182.7100),
(2643, 20, 34, 1430, NULL, NULL, NULL, NULL, NULL, 141633.9100, 0.0000, 3, 3451.2000, NULL, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, NULL, '2022-11-14', '2022-11-14 09:06:32', '2022-11-14 09:06:32', '', 141633.9100),
(2644, 20, 34, 1431, NULL, NULL, NULL, NULL, NULL, 145428.7900, 0.0000, 8, 3794.8800, NULL, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, NULL, '2022-11-14', '2022-11-14 09:07:32', '2022-11-14 09:07:32', '', 145428.7900),
(2645, 20, 34, 1432, NULL, NULL, NULL, NULL, NULL, 149223.6700, 0.0000, 8, 3794.8800, NULL, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, NULL, '2022-11-15', '2022-11-15 00:33:15', '2022-11-15 00:33:15', '', 149223.6700),
(2646, 20, 34, 1433, NULL, NULL, NULL, NULL, NULL, 152296.6300, 0.0000, 7, 3072.9600, NULL, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, NULL, '2022-11-15', '2022-11-15 00:33:54', '2022-11-15 00:33:54', '', 152296.6300),
(2647, 20, 34, 1434, NULL, NULL, NULL, NULL, NULL, 155747.8300, 0.0000, 3, 3451.2000, NULL, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, NULL, '2022-11-15', '2022-11-15 00:34:54', '2022-11-15 00:34:54', '', 155747.8300),
(2648, 20, 34, 1435, NULL, NULL, NULL, NULL, NULL, 163397.8300, 0.0000, 10, 7650.0000, NULL, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, NULL, '2022-11-15', '2022-11-15 00:35:57', '2022-11-15 00:35:57', '', 163397.8300),
(2649, 20, 34, 1436, NULL, NULL, NULL, NULL, NULL, 169262.7100, 0.0000, 3, 5864.8800, NULL, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, NULL, '2022-11-15', '2022-11-15 07:57:34', '2022-11-15 07:57:34', '', 169262.7100),
(2650, 20, 34, 1437, NULL, NULL, NULL, NULL, NULL, 175412.2300, 0.0000, 8, 6149.5200, NULL, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, NULL, '2022-11-15', '2022-11-15 07:58:45', '2022-11-15 07:58:45', '', 175412.2300),
(2651, 20, 34, 1438, NULL, NULL, NULL, NULL, NULL, 194742.4400, 0.0000, 2, 19330.2100, NULL, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, NULL, '2022-11-15', '2022-11-15 08:01:00', '2022-11-15 08:01:00', '', 194742.4400),
(2652, 20, 34, 1439, NULL, NULL, NULL, NULL, NULL, 202392.4400, 0.0000, 10, 7650.0000, NULL, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, NULL, '2022-11-15', '2022-11-15 08:02:07', '2022-11-15 08:02:07', '', 202392.4400),
(2653, 20, 34, NULL, 516, NULL, NULL, NULL, NULL, 173235.9400, 0.0000, NULL, 0.0000, 29156.5000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, NULL, '2022-11-16', '2022-11-16 05:07:58', '2022-11-16 05:07:58', 'COLLECTION  LAST NOV 11', 173235.9400),
(2654, 20, 34, NULL, NULL, NULL, NULL, NULL, NULL, 199738.0000, 0.0000, 0, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 26502.0600, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, NULL, '2022-11-16', '2022-11-16 06:33:49', '2022-11-16 06:33:49', 'ADD ADJUSTMENT', 199738.0000),
(2655, 20, 49, NULL, 517, NULL, NULL, NULL, NULL, 187502.0000, 0.0000, NULL, 0.0000, 12236.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, NULL, '2022-11-16', '2022-11-16 06:41:11', '2022-11-16 06:41:11', 'COLLECTION', 187502.0000),
(2656, 20, 49, NULL, 518, NULL, NULL, NULL, NULL, 175053.0000, 0.0000, NULL, 0.0000, 12449.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, NULL, '2022-11-16', '2022-11-16 06:43:03', '2022-11-16 06:43:03', 'COLLECTION', 175053.0000),
(2657, 20, 34, 1440, NULL, NULL, NULL, NULL, NULL, 180469.4100, 0.0000, 2, 5416.4100, NULL, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, NULL, '2022-11-16', '2022-11-16 07:46:08', '2022-11-16 07:46:08', '', 180469.4100),
(2658, 20, 34, 1441, NULL, NULL, NULL, NULL, NULL, 185063.0100, 0.0000, 7, 4593.6000, NULL, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, NULL, '2022-11-16', '2022-11-16 08:55:20', '2022-11-16 08:55:20', '', 185063.0100),
(2659, 20, 34, 1442, NULL, NULL, NULL, NULL, NULL, 198485.9100, 0.0000, 3, 13422.9000, NULL, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, NULL, '2022-11-17', '2022-11-17 02:37:08', '2022-11-17 02:37:08', '', 198485.9100),
(2660, 20, 34, 1443, NULL, NULL, NULL, NULL, NULL, 201470.1100, 0.0000, 3, 2984.2000, NULL, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, NULL, '2022-11-17', '2022-11-17 02:38:03', '2022-11-17 02:38:03', '', 201470.1100),
(2661, 20, 49, NULL, 519, NULL, NULL, NULL, NULL, 156861.1100, 0.0000, NULL, 0.0000, 44609.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, NULL, '2022-11-17', '2022-11-17 05:56:21', '2022-11-17 05:56:21', 'COLLECTION', 156861.1100),
(2662, 20, 34, 1444, NULL, NULL, NULL, NULL, NULL, 164905.9100, 0.0000, 3, 8044.8000, NULL, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, NULL, '2022-11-21', '2022-11-21 08:57:24', '2022-11-21 08:57:24', '', 164905.9100),
(2663, 20, 34, 1445, NULL, NULL, NULL, NULL, NULL, 168903.1100, 0.0000, 8, 3997.2000, NULL, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, NULL, '2022-11-21', '2022-11-21 08:58:23', '2022-11-21 08:58:23', '', 168903.1100);

-- --------------------------------------------------------

--
-- Table structure for table `van_selling_beginnings`
--

CREATE TABLE `van_selling_beginnings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `van_selling_calls`
--

CREATE TABLE `van_selling_calls` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` int(11) NOT NULL,
  `store_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remarks` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `van_selling_customers`
--

CREATE TABLE `van_selling_customers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `location_id` bigint(20) UNSIGNED NOT NULL,
  `store_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `store_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `barangay` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact_person` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `latitude` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `longitude` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `van_selling_inventory_adjustments`
--

CREATE TABLE `van_selling_inventory_adjustments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `total_amount` double(15,4) NOT NULL,
  `date` date NOT NULL,
  `remarks` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `van_selling_inventory_adjustments_details`
--

CREATE TABLE `van_selling_inventory_adjustments_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `vs_inv_adj_id` bigint(20) UNSIGNED NOT NULL,
  `sku_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `principal` char(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `old_quantity` int(11) NOT NULL,
  `adjusted_quantity` int(11) NOT NULL,
  `unit_price` double(15,4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `remarks` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `van_selling_inventory_clearings`
--

CREATE TABLE `van_selling_inventory_clearings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `vs_ar_ending_balance` double(15,4) NOT NULL,
  `vs_inventory_running_balance` double(15,4) NOT NULL,
  `adjustments` double(15,4) NOT NULL,
  `total_adjustments` double(15,4) NOT NULL,
  `date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `van_selling_os_datas`
--

CREATE TABLE `van_selling_os_datas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `store_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sku_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` int(11) NOT NULL,
  `os_unit_price` double(15,4) NOT NULL,
  `os_sub_total` double(15,4) NOT NULL,
  `os_date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `served_quantity` int(11) DEFAULT NULL,
  `served_unit_price` double(15,4) DEFAULT NULL,
  `served_sub_total` double(15,4) DEFAULT NULL,
  `served_date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `principal` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `os_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `customer_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `van_selling_payments`
--

CREATE TABLE `van_selling_payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `cash_cheque` decimal(15,4) NOT NULL,
  `bank_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cheque_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cheque_date` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remitted_by` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `van_selling_payment_details`
--

CREATE TABLE `van_selling_payment_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `van_selling_payment_id` bigint(20) UNSIGNED NOT NULL,
  `van_selling_printed_id` bigint(20) UNSIGNED NOT NULL,
  `amount` decimal(15,4) NOT NULL,
  `balance` decimal(15,4) NOT NULL,
  `remarks` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `van_selling_pcms`
--

CREATE TABLE `van_selling_pcms` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `pcm_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pcm_type` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remarks` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` double(15,4) NOT NULL,
  `date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `remitted_by` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `store_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `van_selling_pcm_details`
--

CREATE TABLE `van_selling_pcm_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `van_selling_pcm_id` bigint(20) UNSIGNED NOT NULL,
  `sku_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `principal` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `unit_price` double(15,4) NOT NULL,
  `quantity` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `remarks` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `van_selling_price_differences`
--

CREATE TABLE `van_selling_price_differences` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `van_selling_printed_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `principal_id` int(10) UNSIGNED NOT NULL,
  `total_price_difference` double(15,4) NOT NULL,
  `date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `van_selling_price_difference_details`
--

CREATE TABLE `van_selling_price_difference_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `vs_price_diff_id` bigint(20) UNSIGNED NOT NULL,
  `sku_id` int(10) UNSIGNED NOT NULL,
  `total_quantity` int(11) NOT NULL,
  `price` double(15,4) NOT NULL,
  `price_update` double(15,4) NOT NULL,
  `difference` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `van_selling_printeds`
--

CREATE TABLE `van_selling_printeds` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `principal_id` int(10) UNSIGNED NOT NULL,
  `sales_order_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mode_of_transaction` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `delivery_receipt` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price_level` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remarks` char(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_amount` decimal(15,4) NOT NULL,
  `date_paid_or_cancelled` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `sku_type` char(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `van_selling_printed_details`
--

CREATE TABLE `van_selling_printed_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `van_selling_printed_id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` int(11) NOT NULL,
  `sales_order_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sku_id` int(10) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  `butal_quantity` int(11) NOT NULL,
  `price` decimal(15,4) NOT NULL,
  `amount_per_sku` decimal(15,4) NOT NULL,
  `remarks` char(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `van_selling_sales`
--

CREATE TABLE `van_selling_sales` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `vs_upload_id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `principal` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sku_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `unit_of_measurement` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sku_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `butal_equivalent` int(11) NOT NULL,
  `reference` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `store_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sales` int(11) NOT NULL,
  `unit_price` double(15,4) NOT NULL,
  `total` double(15,4) NOT NULL,
  `date` date NOT NULL,
  `location` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_sold` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `van_selling_transfer_inventories`
--

CREATE TABLE `van_selling_transfer_inventories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `transfered_amount` double NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `van_selling_transfer_inventory_details`
--

CREATE TABLE `van_selling_transfer_inventory_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `vs_transfer_id` bigint(20) UNSIGNED NOT NULL,
  `sku_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `principal` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `unit_of_measurement` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` int(11) NOT NULL,
  `unit_price` double(15,4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `sku_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `butal_equivalent` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `van_selling_uploads`
--

CREATE TABLE `van_selling_uploads` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `van_selling_export_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `date_range` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `van_selling_upload_ledgers`
--

CREATE TABLE `van_selling_upload_ledgers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `van_selling_printed_id` int(11) NOT NULL,
  `vs_upload_id` int(11) DEFAULT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `principal` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sku_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `unit_of_measurement` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sku_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `butal_equivalent` int(11) NOT NULL,
  `reference` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `beg` int(11) NOT NULL,
  `van_load` int(11) NOT NULL,
  `sales` int(11) NOT NULL,
  `adjustments` int(11) NOT NULL,
  `inventory_adjustments` int(11) NOT NULL,
  `pcm` int(11) NOT NULL,
  `clearing` int(11) NOT NULL,
  `end` int(11) NOT NULL,
  `unit_price` decimal(15,4) NOT NULL,
  `total` decimal(15,4) NOT NULL,
  `running_balance` decimal(15,4) NOT NULL,
  `date` date NOT NULL,
  `remarks` char(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `agents`
--
ALTER TABLE `agents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `agents_location_id_index` (`location_id`);

--
-- Indexes for table `agent_applied_customers`
--
ALTER TABLE `agent_applied_customers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `agent_applied_customers_agent_id_index` (`agent_id`),
  ADD KEY `agent_applied_customers_location_id_index` (`location_id`),
  ADD KEY `agent_applied_customers_customer_id_index` (`customer_id`),
  ADD KEY `agent_applied_customers_user_id_index` (`user_id`);

--
-- Indexes for table `agent_principals`
--
ALTER TABLE `agent_principals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `agent_principals_agent_id_index` (`agent_id`),
  ADD KEY `agent_principals_principal_id_index` (`principal_id`);

--
-- Indexes for table `ar_ledgers`
--
ALTER TABLE `ar_ledgers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ar_ledgers_customer_id_index` (`customer_id`),
  ADD KEY `ar_ledgers_user_id_index` (`user_id`),
  ADD KEY `ar_ledgers_sales_order_print_id_index` (`sales_order_print_id`),
  ADD KEY `ar_ledgers_agent_id_index` (`agent_id`),
  ADD KEY `ar_ledgers_cm_for_bo_id_index` (`cm_for_bo_id`),
  ADD KEY `ar_ledgers_cm_for_rgs_id_index` (`cm_for_rgs_id`),
  ADD KEY `ar_ledgers_customer_payment_details_id_index` (`customer_payment_details_id`),
  ADD KEY `ar_ledgers_principal_id_index` (`principal_id`),
  ADD KEY `ar_ledgers_date_index` (`date`);

--
-- Indexes for table `bodega_outs`
--
ALTER TABLE `bodega_outs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bodega_outs_user_id_index` (`user_id`),
  ADD KEY `bodega_outs_principal_id_index` (`principal_id`),
  ADD KEY `bodega_outs_date_index` (`date`);

--
-- Indexes for table `bodega_out_details`
--
ALTER TABLE `bodega_out_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bodega_out_details_bodega_out_id_index` (`bodega_out_id`),
  ADD KEY `bodega_out_details_sku_id_index` (`sku_id`);

--
-- Indexes for table `bo_allowance_adjustments`
--
ALTER TABLE `bo_allowance_adjustments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bo_allowance_adjustments_principal_id_index` (`principal_id`),
  ADD KEY `bo_allowance_adjustments_received_id_index` (`received_id`),
  ADD KEY `bo_allowance_adjustments_user_id_index` (`user_id`),
  ADD KEY `bo_allowance_adjustments_date_index` (`date`);

--
-- Indexes for table `bo_allowance_adjustments_details`
--
ALTER TABLE `bo_allowance_adjustments_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bo_allowance_adjustments_details_bo_allowance_id_index` (`bo_allowance_id`),
  ADD KEY `bo_allowance_adjustments_details_sku_id_index` (`sku_id`);

--
-- Indexes for table `bo_allowance_adjustments_jers`
--
ALTER TABLE `bo_allowance_adjustments_jers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bo_allowance_adjustments_jers_bo_allowance_id_index` (`bo_allowance_id`),
  ADD KEY `bo_allowance_adjustments_jers_date_index` (`date`);

--
-- Indexes for table `cm_for_bos`
--
ALTER TABLE `cm_for_bos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cm_for_bos_customer_id_index` (`customer_id`),
  ADD KEY `cm_for_bos_sales_order_printed_id_index` (`sales_order_printed_id`);

--
-- Indexes for table `cm_for_bo_details`
--
ALTER TABLE `cm_for_bo_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cm_for_bo_details_cm_for_bo_id_index` (`cm_for_bo_id`),
  ADD KEY `cm_for_bo_details_sku_id_index` (`sku_id`);

--
-- Indexes for table `cm_for_bo_jers`
--
ALTER TABLE `cm_for_bo_jers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cm_for_bo_jers_cm_for_bo_id_index` (`cm_for_bo_id`);

--
-- Indexes for table `cm_for_others`
--
ALTER TABLE `cm_for_others`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cm_for_others_customer_id_index` (`customer_id`),
  ADD KEY `cm_for_others_personnel_id_index` (`personnel_id`);

--
-- Indexes for table `cm_for_others_details`
--
ALTER TABLE `cm_for_others_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cm_for_others_details_cm_for_others_id_index` (`cm_for_others_id`),
  ADD KEY `cm_for_others_details_sku_id_index` (`sku_id`);

--
-- Indexes for table `cm_for_rgs`
--
ALTER TABLE `cm_for_rgs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cm_for_rgs_customer_id_index` (`customer_id`),
  ADD KEY `cm_for_rgs_sales_order_printed_id_index` (`sales_order_printed_id`);

--
-- Indexes for table `cm_for_rgs_details`
--
ALTER TABLE `cm_for_rgs_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cm_for_rgs_details_cm_for_rgs_id_index` (`cm_for_rgs_id`),
  ADD KEY `cm_for_rgs_details_sku_id_index` (`sku_id`);

--
-- Indexes for table `cm_for_rgs_jers`
--
ALTER TABLE `cm_for_rgs_jers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cm_for_rgs_jers_cm_for_rgs_id_index` (`cm_for_rgs_id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customers_location_id_index` (`location_id`);

--
-- Indexes for table `customer_category_discounts`
--
ALTER TABLE `customer_category_discounts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_category_discounts_principal_id_index` (`principal_id`),
  ADD KEY `customer_category_discounts_customer_id_index` (`customer_id`),
  ADD KEY `customer_category_discounts_category_id_index` (`category_id`);

--
-- Indexes for table `customer_discounts`
--
ALTER TABLE `customer_discounts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_discounts_principal_id_index` (`principal_id`),
  ADD KEY `customer_discounts_customer_id_index` (`customer_id`);

--
-- Indexes for table `customer_ledgers`
--
ALTER TABLE `customer_ledgers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_ledgers_customer_id_index` (`customer_id`),
  ADD KEY `customer_ledgers_principal_id_index` (`principal_id`);

--
-- Indexes for table `customer_payments`
--
ALTER TABLE `customer_payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer_payment_details`
--
ALTER TABLE `customer_payment_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_payment_details_customer_payment_id_index` (`customer_payment_id`),
  ADD KEY `customer_payment_details_sales_order_printed_id_index` (`sales_order_printed_id`);

--
-- Indexes for table `customer_payment_jers`
--
ALTER TABLE `customer_payment_jers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_payment_jers_customer_payment_id_index` (`customer_payment_id`);

--
-- Indexes for table `customer_principal_codes`
--
ALTER TABLE `customer_principal_codes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_principal_codes_customer_id_index` (`customer_id`),
  ADD KEY `customer_principal_codes_principal_id_index` (`principal_id`);

--
-- Indexes for table `customer_principal_prices`
--
ALTER TABLE `customer_principal_prices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_principal_prices_customer_id_index` (`customer_id`),
  ADD KEY `customer_principal_prices_principal_id_index` (`principal_id`),
  ADD KEY `customer_principal_prices_user_id_index` (`user_id`);

--
-- Indexes for table `customer_uploads`
--
ALTER TABLE `customer_uploads`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `driver_helpers`
--
ALTER TABLE `driver_helpers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `driver_helpers_user_id_index` (`user_id`);

--
-- Indexes for table `driver_helper_charges`
--
ALTER TABLE `driver_helper_charges`
  ADD PRIMARY KEY (`id`),
  ADD KEY `driver_helper_charges_driver_helper_id_index` (`driver_helper_id`);

--
-- Indexes for table `invoice_cost_adjustments`
--
ALTER TABLE `invoice_cost_adjustments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `invoice_cost_adjustments_received_id_index` (`received_id`),
  ADD KEY `invoice_cost_adjustments_principal_id_index` (`principal_id`),
  ADD KEY `invoice_cost_adjustments_date_index` (`date`);

--
-- Indexes for table `invoice_cost_adjustments_jers`
--
ALTER TABLE `invoice_cost_adjustments_jers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `invoice_cost_adjustments_jers_invoice_cost_id_index` (`invoice_cost_id`),
  ADD KEY `invoice_cost_adjustments_jers_date_index` (`date`);

--
-- Indexes for table `invoice_cost_adjustment_details`
--
ALTER TABLE `invoice_cost_adjustment_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `invoice_cost_adjustment_details_invoice_cost_id_index` (`invoice_cost_id`),
  ADD KEY `invoice_cost_adjustment_details_sku_id_index` (`sku_id`);

--
-- Indexes for table `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `location_details`
--
ALTER TABLE `location_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `location_details_location_id_index` (`location_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `pcm_uploads`
--
ALTER TABLE `pcm_uploads`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pcm_uploads_agent_id_index` (`agent_id`),
  ADD KEY `pcm_uploads_customer_id_index` (`customer_id`),
  ADD KEY `pcm_uploads_principal_id_index` (`principal_id`),
  ADD KEY `pcm_uploads_date_index` (`date`);

--
-- Indexes for table `pcm_upload_details`
--
ALTER TABLE `pcm_upload_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pcm_upload_details_sku_id_index` (`sku_id`);

--
-- Indexes for table `pcm_upload_vs`
--
ALTER TABLE `pcm_upload_vs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pcm_upload_vs_customer_id_index` (`customer_id`);

--
-- Indexes for table `pcm_upload_vs_details`
--
ALTER TABLE `pcm_upload_vs_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pcm_upload_vs_details_pcm_upload_vs_id_index` (`pcm_upload_vs_id`);

--
-- Indexes for table `personnel_adds`
--
ALTER TABLE `personnel_adds`
  ADD PRIMARY KEY (`id`),
  ADD KEY `personnel_adds_personnel_description_id_index` (`personnel_description_id`);

--
-- Indexes for table `personnel_add_details`
--
ALTER TABLE `personnel_add_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `personnel_add_details_personnel_id_index` (`personnel_id`),
  ADD KEY `personnel_add_details_principal_id_index` (`principal_id`);

--
-- Indexes for table `personnel_descriptions`
--
ALTER TABLE `personnel_descriptions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `principal_discounts`
--
ALTER TABLE `principal_discounts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `principal_discounts_principal_id_index` (`principal_id`);

--
-- Indexes for table `principal_discount_details`
--
ALTER TABLE `principal_discount_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `principal_discount_details_principal_discount_id_index` (`principal_discount_id`);

--
-- Indexes for table `principal_ledgers`
--
ALTER TABLE `principal_ledgers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `principal_ledgers_principal_id_index` (`principal_id`),
  ADD KEY `principal_ledgers_date_index` (`date`);

--
-- Indexes for table `principal_payments`
--
ALTER TABLE `principal_payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `principal_payments_principal_id_index` (`principal_id`),
  ADD KEY `principal_payments_date_index` (`date`);

--
-- Indexes for table `purchase_orders`
--
ALTER TABLE `purchase_orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `purchase_orders_principal_id_index` (`principal_id`),
  ADD KEY `purchase_orders_user_id_index` (`user_id`),
  ADD KEY `purchase_orders_date_index` (`date`);

--
-- Indexes for table `purchase_order_details`
--
ALTER TABLE `purchase_order_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `purchase_order_details_purchase_order_id_index` (`purchase_order_id`),
  ADD KEY `purchase_order_details_sku_id_index` (`sku_id`);

--
-- Indexes for table `received_jers`
--
ALTER TABLE `received_jers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `received_jers_principal_id_index` (`principal_id`),
  ADD KEY `received_jers_received_id_index` (`received_id`),
  ADD KEY `received_jers_date_index` (`date`);

--
-- Indexes for table `received_purchase_orders`
--
ALTER TABLE `received_purchase_orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `received_purchase_orders_principal_id_index` (`principal_id`),
  ADD KEY `received_purchase_orders_purchase_order_id_index` (`purchase_order_id`),
  ADD KEY `received_purchase_orders_dr_si_index` (`dr_si`),
  ADD KEY `received_purchase_orders_truck_number_index` (`truck_number`),
  ADD KEY `received_purchase_orders_courier_index` (`courier`),
  ADD KEY `received_purchase_orders_invoice_date_index` (`invoice_date`),
  ADD KEY `received_purchase_orders_remarks_index` (`remarks`),
  ADD KEY `received_purchase_orders_date_index` (`date`);

--
-- Indexes for table `return_to_principals`
--
ALTER TABLE `return_to_principals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `return_to_principals_principal_id_index` (`principal_id`),
  ADD KEY `return_to_principals_personnel_id_index` (`personnel_id`),
  ADD KEY `return_to_principals_received_id_index` (`received_id`),
  ADD KEY `return_to_principals_user_id_index` (`user_id`),
  ADD KEY `return_to_principals_date_index` (`date`);

--
-- Indexes for table `return_to_principal_details`
--
ALTER TABLE `return_to_principal_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `return_to_principal_details_sku_id_index` (`sku_id`),
  ADD KEY `return_to_principal_details_return_to_principal_id_index` (`return_to_principal_id`);

--
-- Indexes for table `return_to_principal_jers`
--
ALTER TABLE `return_to_principal_jers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `return_to_principal_jers_return_to_principal_id_index` (`return_to_principal_id`),
  ADD KEY `return_to_principal_jers_date_index` (`date`);

--
-- Indexes for table `sales_invoices`
--
ALTER TABLE `sales_invoices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sales_invoices_sales_order_draft_id_index` (`sales_order_draft_id`),
  ADD KEY `sales_invoices_customer_id_index` (`customer_id`),
  ADD KEY `sales_invoices_principal_id_index` (`principal_id`),
  ADD KEY `sales_invoices_agent_id_index` (`agent_id`),
  ADD KEY `sales_invoices_user_id_index` (`user_id`);

--
-- Indexes for table `sales_invoice_deposit_check_slips`
--
ALTER TABLE `sales_invoice_deposit_check_slips`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sales_invoice_deposit_check_slips_customer_id_index` (`customer_id`),
  ADD KEY `sales_invoice_deposit_check_slips_user_id_index` (`user_id`);

--
-- Indexes for table `sales_invoice_details`
--
ALTER TABLE `sales_invoice_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sales_invoice_details_sku_id_index` (`sku_id`),
  ADD KEY `sales_invoice_details_sales_invoice_id_index` (`sales_invoice_id`);

--
-- Indexes for table `sales_invoice_status_logs`
--
ALTER TABLE `sales_invoice_status_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sales_invoice_status_logs_sales_invoice_id_index` (`sales_invoice_id`),
  ADD KEY `sales_invoice_status_logs_user_id_index` (`user_id`);

--
-- Indexes for table `sales_order_drafts`
--
ALTER TABLE `sales_order_drafts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sales_order_drafts_customer_id_index` (`customer_id`),
  ADD KEY `sales_order_drafts_principal_id_index` (`principal_id`),
  ADD KEY `sales_order_drafts_agent_id_index` (`agent_id`),
  ADD KEY `sales_order_drafts_user_id_index` (`user_id`);

--
-- Indexes for table `sales_order_draft_details`
--
ALTER TABLE `sales_order_draft_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sales_order_draft_details_sku_id_index` (`sku_id`),
  ADD KEY `sales_order_draft_details_sales_order_draft_id_index` (`sales_order_draft_id`);

--
-- Indexes for table `sales_order_prints`
--
ALTER TABLE `sales_order_prints`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sales_order_prints_customer_id_index` (`customer_id`),
  ADD KEY `sales_order_prints_agent_id_index` (`agent_id`),
  ADD KEY `sales_order_prints_principal_id_index` (`principal_id`),
  ADD KEY `sales_order_prints_user_id_index` (`user_id`);

--
-- Indexes for table `sales_order_print_jers`
--
ALTER TABLE `sales_order_print_jers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sales_order_print_jers_sales_order_print_id_index` (`sales_order_print_id`);

--
-- Indexes for table `sku_adds`
--
ALTER TABLE `sku_adds`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sku_adds_category_id_index` (`category_id`),
  ADD KEY `sku_adds_principal_id_index` (`principal_id`);

--
-- Indexes for table `sku_add_details`
--
ALTER TABLE `sku_add_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sku_add_details_received_id_index` (`received_id`),
  ADD KEY `sku_add_details_sku_id_index` (`sku_id`);

--
-- Indexes for table `sku_categories`
--
ALTER TABLE `sku_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sku_ledgers`
--
ALTER TABLE `sku_ledgers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sku_ledgers_sku_id_index` (`sku_id`),
  ADD KEY `sku_ledgers_transaction_date_index` (`transaction_date`),
  ADD KEY `sku_ledgers_user_id_index` (`user_id`);

--
-- Indexes for table `sku_price_details`
--
ALTER TABLE `sku_price_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sku_principals`
--
ALTER TABLE `sku_principals`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sku_sub_categories`
--
ALTER TABLE `sku_sub_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sku_sub_categories_main_category_id_index` (`main_category_id`);

--
-- Indexes for table `transfer_to_branch_jers`
--
ALTER TABLE `transfer_to_branch_jers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transfer_to_branch_jers_received_id_index` (`received_id`),
  ADD KEY `transfer_to_branch_jers_principal_id_index` (`principal_id`);

--
-- Indexes for table `transfer_to_brans`
--
ALTER TABLE `transfer_to_brans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transfer_to_brans_received_id_index` (`received_id`),
  ADD KEY `transfer_to_brans_principal_id_index` (`principal_id`),
  ADD KEY `transfer_to_brans_user_id_index` (`user_id`),
  ADD KEY `transfer_to_brans_branch_index` (`branch`),
  ADD KEY `transfer_to_brans_date_index` (`date`);

--
-- Indexes for table `transfer_to_bran_details`
--
ALTER TABLE `transfer_to_bran_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transfer_to_bran_details_transfer_id_index` (`transfer_id`),
  ADD KEY `transfer_to_bran_details_sku_id_index` (`sku_id`);

--
-- Indexes for table `trucks`
--
ALTER TABLE `trucks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `truck_and_sales_invoices`
--
ALTER TABLE `truck_and_sales_invoices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `truck_and_sales_invoices_truck_id_index` (`truck_id`),
  ADD KEY `truck_and_sales_invoices_user_id_index` (`user_id`);

--
-- Indexes for table `truck_and_sales_invoice_details`
--
ALTER TABLE `truck_and_sales_invoice_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `truck_and_sales_invoice_details_truck_si_id_index` (`truck_si_id`),
  ADD KEY `truck_and_sales_invoice_details_sales_invoice_id_index` (`sales_invoice_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `van_selling_adjustments`
--
ALTER TABLE `van_selling_adjustments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `van_selling_adjustments_van_selling_printed_id_index` (`van_selling_printed_id`),
  ADD KEY `van_selling_adjustments_customer_id_index` (`customer_id`),
  ADD KEY `van_selling_adjustments_user_id_index` (`user_id`),
  ADD KEY `van_selling_adjustments_date_index` (`date`);

--
-- Indexes for table `van_selling_adjustments_details`
--
ALTER TABLE `van_selling_adjustments_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `van_selling_adjustments_details_vs_adjustments_id_index` (`vs_adjustments_id`),
  ADD KEY `van_selling_adjustments_details_sku_id_index` (`sku_id`);

--
-- Indexes for table `van_selling_ar_ledgers`
--
ALTER TABLE `van_selling_ar_ledgers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `van_selling_ar_ledgers_customer_id_index` (`customer_id`),
  ADD KEY `van_selling_ar_ledgers_user_id_index` (`user_id`),
  ADD KEY `van_selling_ar_ledgers_van_selling_print_id_index` (`van_selling_print_id`),
  ADD KEY `van_selling_ar_ledgers_van_selling_payment_id_index` (`van_selling_payment_id`),
  ADD KEY `van_selling_ar_ledgers_principal_id_index` (`principal_id`),
  ADD KEY `van_selling_ar_ledgers_date_index` (`date`);

--
-- Indexes for table `van_selling_beginnings`
--
ALTER TABLE `van_selling_beginnings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `van_selling_beginnings_customer_id_index` (`customer_id`),
  ADD KEY `van_selling_beginnings_date_index` (`date`),
  ADD KEY `van_selling_beginnings_user_id_index` (`user_id`);

--
-- Indexes for table `van_selling_calls`
--
ALTER TABLE `van_selling_calls`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `van_selling_customers`
--
ALTER TABLE `van_selling_customers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `van_selling_customers_location_id_index` (`location_id`);

--
-- Indexes for table `van_selling_inventory_adjustments`
--
ALTER TABLE `van_selling_inventory_adjustments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `van_selling_inventory_adjustments_user_id_index` (`user_id`),
  ADD KEY `van_selling_inventory_adjustments_customer_id_index` (`customer_id`),
  ADD KEY `van_selling_inventory_adjustments_date_index` (`date`);

--
-- Indexes for table `van_selling_inventory_adjustments_details`
--
ALTER TABLE `van_selling_inventory_adjustments_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `van_selling_inventory_adjustments_details_vs_inv_adj_id_index` (`vs_inv_adj_id`);

--
-- Indexes for table `van_selling_inventory_clearings`
--
ALTER TABLE `van_selling_inventory_clearings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `van_selling_inventory_clearings_customer_id_index` (`customer_id`),
  ADD KEY `van_selling_inventory_clearings_date_index` (`date`);

--
-- Indexes for table `van_selling_os_datas`
--
ALTER TABLE `van_selling_os_datas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `van_selling_payments`
--
ALTER TABLE `van_selling_payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `van_selling_payments_customer_id_index` (`customer_id`),
  ADD KEY `van_selling_payments_user_id_index` (`user_id`);

--
-- Indexes for table `van_selling_payment_details`
--
ALTER TABLE `van_selling_payment_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `van_selling_payment_details_van_selling_payment_id_index` (`van_selling_payment_id`),
  ADD KEY `van_selling_payment_details_van_selling_printed_id_index` (`van_selling_printed_id`);

--
-- Indexes for table `van_selling_pcms`
--
ALTER TABLE `van_selling_pcms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `van_selling_pcms_customer_id_index` (`customer_id`),
  ADD KEY `van_selling_pcms_user_id_index` (`user_id`),
  ADD KEY `van_selling_pcms_date_index` (`date`);

--
-- Indexes for table `van_selling_pcm_details`
--
ALTER TABLE `van_selling_pcm_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `van_selling_pcm_details_van_selling_pcm_id_index` (`van_selling_pcm_id`);

--
-- Indexes for table `van_selling_price_differences`
--
ALTER TABLE `van_selling_price_differences`
  ADD PRIMARY KEY (`id`),
  ADD KEY `van_selling_price_differences_van_selling_printed_id_index` (`van_selling_printed_id`),
  ADD KEY `van_selling_price_differences_user_id_index` (`user_id`),
  ADD KEY `van_selling_price_differences_principal_id_index` (`principal_id`),
  ADD KEY `van_selling_price_differences_date_index` (`date`);

--
-- Indexes for table `van_selling_price_difference_details`
--
ALTER TABLE `van_selling_price_difference_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `van_selling_price_difference_details_vs_price_diff_id_index` (`vs_price_diff_id`),
  ADD KEY `van_selling_price_difference_details_sku_id_index` (`sku_id`);

--
-- Indexes for table `van_selling_printeds`
--
ALTER TABLE `van_selling_printeds`
  ADD PRIMARY KEY (`id`),
  ADD KEY `van_selling_printeds_customer_id_index` (`customer_id`),
  ADD KEY `van_selling_printeds_principal_id_index` (`principal_id`);

--
-- Indexes for table `van_selling_printed_details`
--
ALTER TABLE `van_selling_printed_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `van_selling_printed_details_van_selling_printed_id_index` (`van_selling_printed_id`),
  ADD KEY `van_selling_printed_details_sku_id_index` (`sku_id`);

--
-- Indexes for table `van_selling_sales`
--
ALTER TABLE `van_selling_sales`
  ADD PRIMARY KEY (`id`),
  ADD KEY `van_selling_sales_vs_upload_id_index` (`vs_upload_id`),
  ADD KEY `van_selling_sales_customer_id_index` (`customer_id`),
  ADD KEY `van_selling_sales_date_sold_index` (`date_sold`);

--
-- Indexes for table `van_selling_transfer_inventories`
--
ALTER TABLE `van_selling_transfer_inventories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `van_selling_transfer_inventories_customer_id_index` (`customer_id`),
  ADD KEY `van_selling_transfer_inventories_user_id_index` (`user_id`),
  ADD KEY `van_selling_transfer_inventories_date_index` (`date`);

--
-- Indexes for table `van_selling_transfer_inventory_details`
--
ALTER TABLE `van_selling_transfer_inventory_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `van_selling_transfer_inventory_details_vs_transfer_id_index` (`vs_transfer_id`);

--
-- Indexes for table `van_selling_uploads`
--
ALTER TABLE `van_selling_uploads`
  ADD PRIMARY KEY (`id`),
  ADD KEY `van_selling_uploads_customer_id_index` (`customer_id`),
  ADD KEY `van_selling_uploads_date_index` (`date`);

--
-- Indexes for table `van_selling_upload_ledgers`
--
ALTER TABLE `van_selling_upload_ledgers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `van_selling_upload_ledgers_customer_id_index` (`customer_id`),
  ADD KEY `principal` (`principal`),
  ADD KEY `date` (`date`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `agents`
--
ALTER TABLE `agents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `agent_applied_customers`
--
ALTER TABLE `agent_applied_customers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `agent_principals`
--
ALTER TABLE `agent_principals`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ar_ledgers`
--
ALTER TABLE `ar_ledgers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bodega_outs`
--
ALTER TABLE `bodega_outs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bodega_out_details`
--
ALTER TABLE `bodega_out_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bo_allowance_adjustments`
--
ALTER TABLE `bo_allowance_adjustments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bo_allowance_adjustments_details`
--
ALTER TABLE `bo_allowance_adjustments_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bo_allowance_adjustments_jers`
--
ALTER TABLE `bo_allowance_adjustments_jers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cm_for_bos`
--
ALTER TABLE `cm_for_bos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cm_for_bo_details`
--
ALTER TABLE `cm_for_bo_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cm_for_bo_jers`
--
ALTER TABLE `cm_for_bo_jers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cm_for_others`
--
ALTER TABLE `cm_for_others`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cm_for_others_details`
--
ALTER TABLE `cm_for_others_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cm_for_rgs`
--
ALTER TABLE `cm_for_rgs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cm_for_rgs_details`
--
ALTER TABLE `cm_for_rgs_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cm_for_rgs_jers`
--
ALTER TABLE `cm_for_rgs_jers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customer_category_discounts`
--
ALTER TABLE `customer_category_discounts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customer_discounts`
--
ALTER TABLE `customer_discounts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customer_ledgers`
--
ALTER TABLE `customer_ledgers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=245;

--
-- AUTO_INCREMENT for table `customer_payments`
--
ALTER TABLE `customer_payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customer_payment_details`
--
ALTER TABLE `customer_payment_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customer_payment_jers`
--
ALTER TABLE `customer_payment_jers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customer_principal_codes`
--
ALTER TABLE `customer_principal_codes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customer_principal_prices`
--
ALTER TABLE `customer_principal_prices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customer_uploads`
--
ALTER TABLE `customer_uploads`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `driver_helpers`
--
ALTER TABLE `driver_helpers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `driver_helper_charges`
--
ALTER TABLE `driver_helper_charges`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invoice_cost_adjustments`
--
ALTER TABLE `invoice_cost_adjustments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invoice_cost_adjustments_jers`
--
ALTER TABLE `invoice_cost_adjustments_jers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invoice_cost_adjustment_details`
--
ALTER TABLE `invoice_cost_adjustment_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `locations`
--
ALTER TABLE `locations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `location_details`
--
ALTER TABLE `location_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=175;

--
-- AUTO_INCREMENT for table `pcm_uploads`
--
ALTER TABLE `pcm_uploads`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pcm_upload_details`
--
ALTER TABLE `pcm_upload_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pcm_upload_vs`
--
ALTER TABLE `pcm_upload_vs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pcm_upload_vs_details`
--
ALTER TABLE `pcm_upload_vs_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `personnel_adds`
--
ALTER TABLE `personnel_adds`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `personnel_add_details`
--
ALTER TABLE `personnel_add_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `personnel_descriptions`
--
ALTER TABLE `personnel_descriptions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `principal_discounts`
--
ALTER TABLE `principal_discounts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `principal_discount_details`
--
ALTER TABLE `principal_discount_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `principal_ledgers`
--
ALTER TABLE `principal_ledgers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `principal_payments`
--
ALTER TABLE `principal_payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchase_orders`
--
ALTER TABLE `purchase_orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchase_order_details`
--
ALTER TABLE `purchase_order_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `received_jers`
--
ALTER TABLE `received_jers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `received_purchase_orders`
--
ALTER TABLE `received_purchase_orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `return_to_principals`
--
ALTER TABLE `return_to_principals`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `return_to_principal_details`
--
ALTER TABLE `return_to_principal_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `return_to_principal_jers`
--
ALTER TABLE `return_to_principal_jers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sales_invoices`
--
ALTER TABLE `sales_invoices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sales_invoice_deposit_check_slips`
--
ALTER TABLE `sales_invoice_deposit_check_slips`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sales_invoice_details`
--
ALTER TABLE `sales_invoice_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `sales_invoice_status_logs`
--
ALTER TABLE `sales_invoice_status_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sales_order_drafts`
--
ALTER TABLE `sales_order_drafts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sales_order_draft_details`
--
ALTER TABLE `sales_order_draft_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sales_order_prints`
--
ALTER TABLE `sales_order_prints`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sales_order_print_jers`
--
ALTER TABLE `sales_order_print_jers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sku_adds`
--
ALTER TABLE `sku_adds`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sku_add_details`
--
ALTER TABLE `sku_add_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sku_categories`
--
ALTER TABLE `sku_categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `sku_ledgers`
--
ALTER TABLE `sku_ledgers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sku_price_details`
--
ALTER TABLE `sku_price_details`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sku_principals`
--
ALTER TABLE `sku_principals`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `sku_sub_categories`
--
ALTER TABLE `sku_sub_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `transfer_to_branch_jers`
--
ALTER TABLE `transfer_to_branch_jers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transfer_to_brans`
--
ALTER TABLE `transfer_to_brans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transfer_to_bran_details`
--
ALTER TABLE `transfer_to_bran_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `trucks`
--
ALTER TABLE `trucks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `truck_and_sales_invoices`
--
ALTER TABLE `truck_and_sales_invoices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `truck_and_sales_invoice_details`
--
ALTER TABLE `truck_and_sales_invoice_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `van_selling_adjustments`
--
ALTER TABLE `van_selling_adjustments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `van_selling_adjustments_details`
--
ALTER TABLE `van_selling_adjustments_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `van_selling_ar_ledgers`
--
ALTER TABLE `van_selling_ar_ledgers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2664;

--
-- AUTO_INCREMENT for table `van_selling_beginnings`
--
ALTER TABLE `van_selling_beginnings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=224;

--
-- AUTO_INCREMENT for table `van_selling_calls`
--
ALTER TABLE `van_selling_calls`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `van_selling_customers`
--
ALTER TABLE `van_selling_customers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `van_selling_inventory_adjustments`
--
ALTER TABLE `van_selling_inventory_adjustments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `van_selling_inventory_adjustments_details`
--
ALTER TABLE `van_selling_inventory_adjustments_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `van_selling_inventory_clearings`
--
ALTER TABLE `van_selling_inventory_clearings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `van_selling_os_datas`
--
ALTER TABLE `van_selling_os_datas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `van_selling_payments`
--
ALTER TABLE `van_selling_payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `van_selling_payment_details`
--
ALTER TABLE `van_selling_payment_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `van_selling_pcms`
--
ALTER TABLE `van_selling_pcms`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `van_selling_pcm_details`
--
ALTER TABLE `van_selling_pcm_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `van_selling_price_differences`
--
ALTER TABLE `van_selling_price_differences`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `van_selling_price_difference_details`
--
ALTER TABLE `van_selling_price_difference_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `van_selling_printeds`
--
ALTER TABLE `van_selling_printeds`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `van_selling_printed_details`
--
ALTER TABLE `van_selling_printed_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `van_selling_sales`
--
ALTER TABLE `van_selling_sales`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `van_selling_transfer_inventories`
--
ALTER TABLE `van_selling_transfer_inventories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `van_selling_transfer_inventory_details`
--
ALTER TABLE `van_selling_transfer_inventory_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `van_selling_uploads`
--
ALTER TABLE `van_selling_uploads`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=905;

--
-- AUTO_INCREMENT for table `van_selling_upload_ledgers`
--
ALTER TABLE `van_selling_upload_ledgers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `agents`
--
ALTER TABLE `agents`
  ADD CONSTRAINT `agents_location_id_foreign` FOREIGN KEY (`location_id`) REFERENCES `locations` (`id`);

--
-- Constraints for table `agent_applied_customers`
--
ALTER TABLE `agent_applied_customers`
  ADD CONSTRAINT `agent_applied_customers_agent_id_foreign` FOREIGN KEY (`agent_id`) REFERENCES `agents` (`id`),
  ADD CONSTRAINT `agent_applied_customers_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`),
  ADD CONSTRAINT `agent_applied_customers_location_id_foreign` FOREIGN KEY (`location_id`) REFERENCES `locations` (`id`),
  ADD CONSTRAINT `agent_applied_customers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `agent_principals`
--
ALTER TABLE `agent_principals`
  ADD CONSTRAINT `agent_principals_agent_id_foreign` FOREIGN KEY (`agent_id`) REFERENCES `agents` (`id`),
  ADD CONSTRAINT `agent_principals_principal_id_foreign` FOREIGN KEY (`principal_id`) REFERENCES `sku_principals` (`id`);

--
-- Constraints for table `ar_ledgers`
--
ALTER TABLE `ar_ledgers`
  ADD CONSTRAINT `ar_ledgers_agent_id_foreign` FOREIGN KEY (`agent_id`) REFERENCES `agents` (`id`),
  ADD CONSTRAINT `ar_ledgers_cm_for_bo_id_foreign` FOREIGN KEY (`cm_for_bo_id`) REFERENCES `cm_for_bos` (`id`),
  ADD CONSTRAINT `ar_ledgers_cm_for_rgs_id_foreign` FOREIGN KEY (`cm_for_rgs_id`) REFERENCES `cm_for_rgs` (`id`),
  ADD CONSTRAINT `ar_ledgers_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`),
  ADD CONSTRAINT `ar_ledgers_customer_payment_details_id_foreign` FOREIGN KEY (`customer_payment_details_id`) REFERENCES `customer_payment_details` (`id`),
  ADD CONSTRAINT `ar_ledgers_principal_id_foreign` FOREIGN KEY (`principal_id`) REFERENCES `sku_principals` (`id`),
  ADD CONSTRAINT `ar_ledgers_sales_order_print_id_foreign` FOREIGN KEY (`sales_order_print_id`) REFERENCES `sales_order_prints` (`id`),
  ADD CONSTRAINT `ar_ledgers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `bodega_outs`
--
ALTER TABLE `bodega_outs`
  ADD CONSTRAINT `bodega_outs_principal_id_foreign` FOREIGN KEY (`principal_id`) REFERENCES `sku_principals` (`id`),
  ADD CONSTRAINT `bodega_outs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `bodega_out_details`
--
ALTER TABLE `bodega_out_details`
  ADD CONSTRAINT `bodega_out_details_bodega_out_id_foreign` FOREIGN KEY (`bodega_out_id`) REFERENCES `bodega_outs` (`id`),
  ADD CONSTRAINT `bodega_out_details_sku_id_foreign` FOREIGN KEY (`sku_id`) REFERENCES `sku_adds` (`id`);

--
-- Constraints for table `bo_allowance_adjustments_details`
--
ALTER TABLE `bo_allowance_adjustments_details`
  ADD CONSTRAINT `bo_allowance_adjustments_details_bo_allowance_id_foreign` FOREIGN KEY (`bo_allowance_id`) REFERENCES `bo_allowance_adjustments` (`id`),
  ADD CONSTRAINT `bo_allowance_adjustments_details_sku_id_foreign` FOREIGN KEY (`sku_id`) REFERENCES `sku_adds` (`id`);

--
-- Constraints for table `customer_principal_codes`
--
ALTER TABLE `customer_principal_codes`
  ADD CONSTRAINT `customer_principal_codes_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`),
  ADD CONSTRAINT `customer_principal_codes_principal_id_foreign` FOREIGN KEY (`principal_id`) REFERENCES `sku_principals` (`id`);

--
-- Constraints for table `customer_principal_prices`
--
ALTER TABLE `customer_principal_prices`
  ADD CONSTRAINT `customer_principal_prices_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`),
  ADD CONSTRAINT `customer_principal_prices_principal_id_foreign` FOREIGN KEY (`principal_id`) REFERENCES `sku_principals` (`id`),
  ADD CONSTRAINT `customer_principal_prices_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `driver_helpers`
--
ALTER TABLE `driver_helpers`
  ADD CONSTRAINT `driver_helpers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `driver_helper_charges`
--
ALTER TABLE `driver_helper_charges`
  ADD CONSTRAINT `driver_helper_charges_driver_helper_id_foreign` FOREIGN KEY (`driver_helper_id`) REFERENCES `driver_helpers` (`id`);

--
-- Constraints for table `pcm_uploads`
--
ALTER TABLE `pcm_uploads`
  ADD CONSTRAINT `pcm_uploads_agent_id_foreign` FOREIGN KEY (`agent_id`) REFERENCES `agents` (`id`),
  ADD CONSTRAINT `pcm_uploads_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`),
  ADD CONSTRAINT `pcm_uploads_principal_id_foreign` FOREIGN KEY (`principal_id`) REFERENCES `sku_principals` (`id`);

--
-- Constraints for table `pcm_upload_details`
--
ALTER TABLE `pcm_upload_details`
  ADD CONSTRAINT `pcm_upload_details_sku_id_foreign` FOREIGN KEY (`sku_id`) REFERENCES `sku_adds` (`id`);

--
-- Constraints for table `pcm_upload_vs`
--
ALTER TABLE `pcm_upload_vs`
  ADD CONSTRAINT `pcm_upload_vs_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`);

--
-- Constraints for table `pcm_upload_vs_details`
--
ALTER TABLE `pcm_upload_vs_details`
  ADD CONSTRAINT `pcm_upload_vs_details_pcm_upload_vs_id_foreign` FOREIGN KEY (`pcm_upload_vs_id`) REFERENCES `pcm_upload_vs` (`id`);

--
-- Constraints for table `sales_invoices`
--
ALTER TABLE `sales_invoices`
  ADD CONSTRAINT `sales_invoices_agent_id_foreign` FOREIGN KEY (`agent_id`) REFERENCES `agents` (`id`),
  ADD CONSTRAINT `sales_invoices_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`),
  ADD CONSTRAINT `sales_invoices_principal_id_foreign` FOREIGN KEY (`principal_id`) REFERENCES `sku_principals` (`id`),
  ADD CONSTRAINT `sales_invoices_sales_order_draft_id_foreign` FOREIGN KEY (`sales_order_draft_id`) REFERENCES `sales_order_drafts` (`id`),
  ADD CONSTRAINT `sales_invoices_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `sales_invoice_deposit_check_slips`
--
ALTER TABLE `sales_invoice_deposit_check_slips`
  ADD CONSTRAINT `sales_invoice_deposit_check_slips_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`),
  ADD CONSTRAINT `sales_invoice_deposit_check_slips_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `sales_invoice_details`
--
ALTER TABLE `sales_invoice_details`
  ADD CONSTRAINT `sales_invoice_details_sales_invoice_id_foreign` FOREIGN KEY (`sales_invoice_id`) REFERENCES `sales_invoices` (`id`),
  ADD CONSTRAINT `sales_invoice_details_sku_id_foreign` FOREIGN KEY (`sku_id`) REFERENCES `sku_adds` (`id`);

--
-- Constraints for table `sales_invoice_status_logs`
--
ALTER TABLE `sales_invoice_status_logs`
  ADD CONSTRAINT `sales_invoice_status_logs_sales_invoice_id_foreign` FOREIGN KEY (`sales_invoice_id`) REFERENCES `sales_invoices` (`id`),
  ADD CONSTRAINT `sales_invoice_status_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `sales_order_drafts`
--
ALTER TABLE `sales_order_drafts`
  ADD CONSTRAINT `sales_order_drafts_agent_id_foreign` FOREIGN KEY (`agent_id`) REFERENCES `agents` (`id`),
  ADD CONSTRAINT `sales_order_drafts_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`),
  ADD CONSTRAINT `sales_order_drafts_principal_id_foreign` FOREIGN KEY (`principal_id`) REFERENCES `sku_principals` (`id`),
  ADD CONSTRAINT `sales_order_drafts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `sales_order_draft_details`
--
ALTER TABLE `sales_order_draft_details`
  ADD CONSTRAINT `sales_order_draft_details_sales_order_draft_id_foreign` FOREIGN KEY (`sales_order_draft_id`) REFERENCES `sales_order_drafts` (`id`),
  ADD CONSTRAINT `sales_order_draft_details_sku_id_foreign` FOREIGN KEY (`sku_id`) REFERENCES `sku_adds` (`id`);

--
-- Constraints for table `sales_order_prints`
--
ALTER TABLE `sales_order_prints`
  ADD CONSTRAINT `sales_order_prints_agent_id_foreign` FOREIGN KEY (`agent_id`) REFERENCES `agents` (`id`),
  ADD CONSTRAINT `sales_order_prints_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`),
  ADD CONSTRAINT `sales_order_prints_principal_id_foreign` FOREIGN KEY (`principal_id`) REFERENCES `sku_principals` (`id`),
  ADD CONSTRAINT `sales_order_prints_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `sku_sub_categories`
--
ALTER TABLE `sku_sub_categories`
  ADD CONSTRAINT `sku_sub_categories_main_category_id_foreign` FOREIGN KEY (`main_category_id`) REFERENCES `sku_categories` (`id`);

--
-- Constraints for table `truck_and_sales_invoices`
--
ALTER TABLE `truck_and_sales_invoices`
  ADD CONSTRAINT `truck_and_sales_invoices_truck_id_foreign` FOREIGN KEY (`truck_id`) REFERENCES `trucks` (`id`),
  ADD CONSTRAINT `truck_and_sales_invoices_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `truck_and_sales_invoice_details`
--
ALTER TABLE `truck_and_sales_invoice_details`
  ADD CONSTRAINT `truck_and_sales_invoice_details_sales_invoice_id_foreign` FOREIGN KEY (`sales_invoice_id`) REFERENCES `sales_invoices` (`id`),
  ADD CONSTRAINT `truck_and_sales_invoice_details_truck_si_id_foreign` FOREIGN KEY (`truck_si_id`) REFERENCES `truck_and_sales_invoices` (`id`);

--
-- Constraints for table `van_selling_adjustments`
--
ALTER TABLE `van_selling_adjustments`
  ADD CONSTRAINT `van_selling_adjustments_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`),
  ADD CONSTRAINT `van_selling_adjustments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `van_selling_adjustments_van_selling_printed_id_foreign` FOREIGN KEY (`van_selling_printed_id`) REFERENCES `van_selling_printeds` (`id`);

--
-- Constraints for table `van_selling_adjustments_details`
--
ALTER TABLE `van_selling_adjustments_details`
  ADD CONSTRAINT `van_selling_adjustments_details_sku_id_foreign` FOREIGN KEY (`sku_id`) REFERENCES `sku_adds` (`id`),
  ADD CONSTRAINT `van_selling_adjustments_details_vs_adjustments_id_foreign` FOREIGN KEY (`vs_adjustments_id`) REFERENCES `van_selling_adjustments` (`id`);

--
-- Constraints for table `van_selling_ar_ledgers`
--
ALTER TABLE `van_selling_ar_ledgers`
  ADD CONSTRAINT `van_selling_ar_ledgers_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`),
  ADD CONSTRAINT `van_selling_ar_ledgers_principal_id_foreign` FOREIGN KEY (`principal_id`) REFERENCES `sku_principals` (`id`),
  ADD CONSTRAINT `van_selling_ar_ledgers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `van_selling_ar_ledgers_van_selling_payment_id_foreign` FOREIGN KEY (`van_selling_payment_id`) REFERENCES `van_selling_payments` (`id`),
  ADD CONSTRAINT `van_selling_ar_ledgers_van_selling_print_id_foreign` FOREIGN KEY (`van_selling_print_id`) REFERENCES `van_selling_printeds` (`id`);

--
-- Constraints for table `van_selling_beginnings`
--
ALTER TABLE `van_selling_beginnings`
  ADD CONSTRAINT `van_selling_beginnings_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`),
  ADD CONSTRAINT `van_selling_beginnings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `van_selling_customers`
--
ALTER TABLE `van_selling_customers`
  ADD CONSTRAINT `van_selling_customers_location_id_foreign` FOREIGN KEY (`location_id`) REFERENCES `locations` (`id`);

--
-- Constraints for table `van_selling_inventory_adjustments`
--
ALTER TABLE `van_selling_inventory_adjustments`
  ADD CONSTRAINT `van_selling_inventory_adjustments_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`),
  ADD CONSTRAINT `van_selling_inventory_adjustments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `van_selling_inventory_clearings`
--
ALTER TABLE `van_selling_inventory_clearings`
  ADD CONSTRAINT `van_selling_inventory_clearings_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`);

--
-- Constraints for table `van_selling_sales`
--
ALTER TABLE `van_selling_sales`
  ADD CONSTRAINT `van_selling_sales_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`),
  ADD CONSTRAINT `van_selling_sales_vs_upload_id_foreign` FOREIGN KEY (`vs_upload_id`) REFERENCES `van_selling_uploads` (`id`);

--
-- Constraints for table `van_selling_transfer_inventories`
--
ALTER TABLE `van_selling_transfer_inventories`
  ADD CONSTRAINT `van_selling_transfer_inventories_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`),
  ADD CONSTRAINT `van_selling_transfer_inventories_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `van_selling_transfer_inventory_details`
--
ALTER TABLE `van_selling_transfer_inventory_details`
  ADD CONSTRAINT `van_selling_transfer_inventory_details_vs_transfer_id_foreign` FOREIGN KEY (`vs_transfer_id`) REFERENCES `van_selling_transfer_inventories` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
