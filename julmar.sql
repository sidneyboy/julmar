/*
SQLyog Community v13.2.1 (64 bit)
MySQL - 8.2.0 : Database - fresh_julmar
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`fresh_julmar` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;

USE `fresh_julmar`;

/*Table structure for table `agent_applied_customers` */

DROP TABLE IF EXISTS `agent_applied_customers`;

CREATE TABLE `agent_applied_customers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `agent_id` bigint unsigned NOT NULL,
  `location_id` bigint unsigned NOT NULL,
  `customer_id` bigint unsigned NOT NULL,
  `user_id` int unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `agent_applied_customers_agent_id_index` (`agent_id`),
  KEY `agent_applied_customers_location_id_index` (`location_id`),
  KEY `agent_applied_customers_customer_id_index` (`customer_id`),
  KEY `agent_applied_customers_user_id_index` (`user_id`),
  CONSTRAINT `agent_applied_customers_agent_id_foreign` FOREIGN KEY (`agent_id`) REFERENCES `agents` (`id`),
  CONSTRAINT `agent_applied_customers_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`),
  CONSTRAINT `agent_applied_customers_location_id_foreign` FOREIGN KEY (`location_id`) REFERENCES `locations` (`id`),
  CONSTRAINT `agent_applied_customers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `agent_applied_customers` */

/*Table structure for table `agent_principals` */

DROP TABLE IF EXISTS `agent_principals`;

CREATE TABLE `agent_principals` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `agent_id` bigint unsigned NOT NULL,
  `principal_id` int unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `agent_principals_agent_id_index` (`agent_id`),
  KEY `agent_principals_principal_id_index` (`principal_id`),
  CONSTRAINT `agent_principals_agent_id_foreign` FOREIGN KEY (`agent_id`) REFERENCES `agents` (`id`),
  CONSTRAINT `agent_principals_principal_id_foreign` FOREIGN KEY (`principal_id`) REFERENCES `sku_principals` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `agent_principals` */

insert  into `agent_principals`(`id`,`agent_id`,`principal_id`,`created_at`,`updated_at`) values 
(1,1,2,'2023-06-30 03:33:27','2023-06-30 03:33:27'),
(2,1,3,'2023-06-30 03:33:27','2023-06-30 03:33:27'),
(3,1,4,'2023-06-30 03:33:27','2023-06-30 03:33:27'),
(4,1,5,'2023-06-30 03:33:27','2023-06-30 03:33:27'),
(5,1,6,'2023-06-30 03:33:27','2023-06-30 03:33:27'),
(6,1,7,'2023-06-30 03:33:27','2023-06-30 03:33:27'),
(7,1,8,'2023-06-30 03:33:27','2023-06-30 03:33:27'),
(8,1,10,'2023-06-30 03:33:27','2023-06-30 03:33:27'),
(9,2,7,'2023-06-30 03:33:49','2023-06-30 03:33:49');

/*Table structure for table `agents` */

DROP TABLE IF EXISTS `agents`;

CREATE TABLE `agents` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `full_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `location_id` bigint unsigned NOT NULL,
  `contact_number` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `full_address` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_address` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `agents_location_id_index` (`location_id`),
  KEY `agents_user_id_index` (`user_id`),
  CONSTRAINT `agents_location_id_foreign` FOREIGN KEY (`location_id`) REFERENCES `locations` (`id`),
  CONSTRAINT `agents_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `agents` */

insert  into `agents`(`id`,`full_name`,`location_id`,`contact_number`,`full_address`,`email_address`,`user_id`,`created_at`,`updated_at`,`status`) values 
(1,'JOEL TAMBIS',1,'09533844872','KAUSWAGAN','johnsidneysalazar.cowd@gmail.com',1,'2023-06-30 03:33:27','2023-06-30 03:33:27','active'),
(2,'JOHN REY PAMIS',1,'09533844872','KAUSWAGAN','johnsidneysalazar.cowd@gmail.com',1,'2023-06-30 03:33:49','2023-06-30 03:33:49','active');

/*Table structure for table `ap_ledgers` */

DROP TABLE IF EXISTS `ap_ledgers`;

CREATE TABLE `ap_ledgers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `principal_id` int unsigned DEFAULT NULL,
  `user_id` int unsigned DEFAULT NULL,
  `transaction_date` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `debit_record` double(15,4) NOT NULL,
  `credit_record` double(15,4) NOT NULL,
  `running_balance` double(15,4) NOT NULL,
  `transaction` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `reference` int DEFAULT NULL,
  `remarks` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `close_date` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ap_ledgers_principal_id_index` (`principal_id`),
  KEY `ap_ledgers_user_id_index` (`user_id`),
  CONSTRAINT `ap_ledgers_principal_id_foreign` FOREIGN KEY (`principal_id`) REFERENCES `sku_principals` (`id`),
  CONSTRAINT `ap_ledgers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `ap_ledgers` */

insert  into `ap_ledgers`(`id`,`principal_id`,`user_id`,`transaction_date`,`description`,`debit_record`,`credit_record`,`running_balance`,`transaction`,`reference`,`remarks`,`close_date`,`created_at`,`updated_at`) values 
(1,2,1,'2023-11-14','Received PO#: GCI-11-2023-2',0.0000,1439196.6960,1439196.6960,'received',1,'',NULL,'2023-11-13 11:47:18','2023-11-13 11:47:18'),
(2,2,1,'2023-11-13','Return to principal from PO#: GCI-11-2023-2 and RR#: 1',34421.7838,0.0000,1404774.9122,'return to principal',1,'Good Stock, returned by Mantos',NULL,'2023-11-13 11:48:46','2023-11-13 11:48:46'),
(3,2,1,'2023-11-13','Bo Allowance Adjustment from PO#: GCI-11-2023-2 and RR#: 1',3900.0000,0.0000,1400874.9122,'bo allowance adjustment',1,'samplesa',NULL,'2023-11-13 11:57:43','2023-11-13 11:57:43'),
(4,2,1,'2023-11-13','Bo Allowance Adjustment from PO#: GCI-11-2023-2 and RR#: 1',0.0000,3900.0000,1404774.9122,'bo allowance adjustment',2,'test 1',NULL,'2023-11-13 12:15:09','2023-11-13 12:15:09'),
(8,2,1,'2023-11-13','Payment to Principal',1404774.9091,0.0000,0.0031,'payment to principal',2,'Particulars, ',NULL,'2023-11-13 14:19:09','2023-11-13 14:19:09'),
(9,2,1,'2023-12-08','Received PO#: GCI-12-2023-4',0.0000,37793.9016,37793.9047,'received',2,'',NULL,'2023-12-23 05:16:19','2023-12-23 05:16:19'),
(10,2,1,'2023-12-23','Return to principal from PO#: GCI-12-2023-4 and RR#: 2',3779.3902,0.0000,34014.5145,'return to principal',2,'Good Stock, returned by Mantos',NULL,'2023-12-23 05:35:35','2023-12-23 05:35:35'),
(11,2,1,'2023-12-23','Bo Allowance Adjustment from PO#: GCI-12-2023-4 and RR#: 2',90.0000,0.0000,33924.5145,'bo allowance adjustment',3,'sample',NULL,'2023-12-23 06:08:25','2023-12-23 06:08:25'),
(12,2,1,'2023-12-27','Received PO#: GCI-12-2023-5',0.0000,377939.0160,411863.5305,'received',3,'',NULL,'2023-12-28 04:46:33','2023-12-28 04:46:33');

/*Table structure for table `ar_ledgers` */

DROP TABLE IF EXISTS `ar_ledgers`;

CREATE TABLE `ar_ledgers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` bigint unsigned NOT NULL,
  `user_id` int unsigned NOT NULL,
  `agent_id` bigint unsigned NOT NULL,
  `cm_for_bo_id` bigint unsigned NOT NULL,
  `cm_for_rgs_id` bigint unsigned NOT NULL,
  `customer_payment_details_id` bigint unsigned NOT NULL,
  `principal_id` int unsigned DEFAULT NULL,
  `date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ar_ledgers_customer_id_index` (`customer_id`),
  KEY `ar_ledgers_user_id_index` (`user_id`),
  KEY `ar_ledgers_agent_id_index` (`agent_id`),
  KEY `ar_ledgers_cm_for_bo_id_index` (`cm_for_bo_id`),
  KEY `ar_ledgers_cm_for_rgs_id_index` (`cm_for_rgs_id`),
  KEY `ar_ledgers_customer_payment_details_id_index` (`customer_payment_details_id`),
  KEY `ar_ledgers_principal_id_index` (`principal_id`),
  KEY `ar_ledgers_date_index` (`date`),
  CONSTRAINT `ar_ledgers_agent_id_foreign` FOREIGN KEY (`agent_id`) REFERENCES `agents` (`id`),
  CONSTRAINT `ar_ledgers_cm_for_bo_id_foreign` FOREIGN KEY (`cm_for_bo_id`) REFERENCES `cm_for_bos` (`id`),
  CONSTRAINT `ar_ledgers_cm_for_rgs_id_foreign` FOREIGN KEY (`cm_for_rgs_id`) REFERENCES `cm_for_rgs` (`id`),
  CONSTRAINT `ar_ledgers_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`),
  CONSTRAINT `ar_ledgers_customer_payment_details_id_foreign` FOREIGN KEY (`customer_payment_details_id`) REFERENCES `customer_payment_details` (`id`),
  CONSTRAINT `ar_ledgers_principal_id_foreign` FOREIGN KEY (`principal_id`) REFERENCES `sku_principals` (`id`),
  CONSTRAINT `ar_ledgers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `ar_ledgers` */

/*Table structure for table `bad_order_details` */

DROP TABLE IF EXISTS `bad_order_details`;

CREATE TABLE `bad_order_details` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `bad_order_id` bigint unsigned NOT NULL,
  `sku_id` int unsigned NOT NULL,
  `quantity` int NOT NULL,
  `unit_price` double(15,4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `confirmed_quantity` int DEFAULT NULL,
  `remarks` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` int unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `bad_order_details_bad_order_id_index` (`bad_order_id`),
  KEY `bad_order_details_sku_id_index` (`sku_id`),
  KEY `bad_order_details_user_id_index` (`user_id`),
  CONSTRAINT `bad_order_details_bad_order_id_foreign` FOREIGN KEY (`bad_order_id`) REFERENCES `bad_orders` (`id`),
  CONSTRAINT `bad_order_details_sku_id_foreign` FOREIGN KEY (`sku_id`) REFERENCES `sku_adds` (`id`),
  CONSTRAINT `bad_order_details_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `bad_order_details` */

insert  into `bad_order_details`(`id`,`bad_order_id`,`sku_id`,`quantity`,`unit_price`,`created_at`,`updated_at`,`confirmed_quantity`,`remarks`,`user_id`) values 
(1,1,212,5,0.0000,'2024-01-04 21:33:43','2024-01-05 05:34:28',5,'scanned',1),
(2,1,213,5,0.0000,'2024-01-04 21:33:43','2024-01-05 05:34:28',5,'scanned',1),
(3,2,212,5,470.0000,'2024-01-06 10:22:28','2018-09-15 15:40:33',2,'scanned',1),
(4,2,213,5,400.0000,'2024-01-06 10:22:28','2018-09-15 15:40:33',3,'scanned',1),
(5,3,212,5,0.0000,'2024-01-08 19:38:06','2024-01-09 03:38:48',4,'scanned',1),
(6,3,213,5,0.0000,'2024-01-08 19:38:06','2024-01-09 03:38:48',3,'scanned',1);

/*Table structure for table `bad_order_discounts` */

DROP TABLE IF EXISTS `bad_order_discounts`;

CREATE TABLE `bad_order_discounts` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `bad_order_id` bigint unsigned NOT NULL,
  `discount_rate` double(5,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `bad_order_discounts_bad_order_id_index` (`bad_order_id`),
  CONSTRAINT `bad_order_discounts_bad_order_id_foreign` FOREIGN KEY (`bad_order_id`) REFERENCES `bad_orders` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `bad_order_discounts` */

insert  into `bad_order_discounts`(`id`,`bad_order_id`,`discount_rate`,`created_at`,`updated_at`) values 
(3,2,2.00,'2024-01-06 10:57:15','2024-01-06 10:57:15'),
(4,2,1.00,'2024-01-06 10:57:15','2024-01-06 10:57:15'),
(5,2,2.00,'2018-09-15 15:39:53','2018-09-15 15:39:53'),
(6,2,1.00,'2018-09-15 15:39:53','2018-09-15 15:39:53'),
(7,2,2.00,'2018-09-15 15:40:33','2018-09-15 15:40:33'),
(8,2,1.00,'2018-09-15 15:40:33','2018-09-15 15:40:33');

/*Table structure for table `bad_order_drafts` */

DROP TABLE IF EXISTS `bad_order_drafts`;

CREATE TABLE `bad_order_drafts` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `sku_id` int NOT NULL,
  `quantity` int DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `bad_order_drafts` */

/*Table structure for table `bad_orders` */

DROP TABLE IF EXISTS `bad_orders`;

CREATE TABLE `bad_orders` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int unsigned DEFAULT NULL,
  `principal_id` int unsigned DEFAULT NULL,
  `sku_type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `agent_id` bigint unsigned NOT NULL,
  `pcm_number` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_amount` double(15,4) NOT NULL,
  `customer_id` bigint unsigned DEFAULT NULL,
  `status` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `verified_date` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `verified_by` int DEFAULT NULL,
  `final_status` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `si_id` bigint unsigned DEFAULT NULL,
  `confirm_status` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `confirmed_by` int unsigned DEFAULT NULL,
  `confirmed_date` date DEFAULT NULL,
  `spoiled_goods` decimal(15,4) DEFAULT NULL,
  `accounts_receivable` decimal(15,4) DEFAULT NULL,
  `posted_amount` decimal(15,4) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `bad_orders_user_id_index` (`user_id`),
  KEY `bad_orders_principal_id_index` (`principal_id`),
  KEY `bad_orders_agent_id_index` (`agent_id`),
  KEY `bad_orders_customer_id_index` (`customer_id`),
  KEY `bad_orders_si_id_index` (`si_id`),
  KEY `bad_orders_confirmed_by_index` (`confirmed_by`),
  CONSTRAINT `bad_orders_agent_id_foreign` FOREIGN KEY (`agent_id`) REFERENCES `agents` (`id`),
  CONSTRAINT `bad_orders_confirmed_by_foreign` FOREIGN KEY (`confirmed_by`) REFERENCES `users` (`id`),
  CONSTRAINT `bad_orders_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`),
  CONSTRAINT `bad_orders_principal_id_foreign` FOREIGN KEY (`principal_id`) REFERENCES `sku_principals` (`id`),
  CONSTRAINT `bad_orders_si_id_foreign` FOREIGN KEY (`si_id`) REFERENCES `sales_invoices` (`id`),
  CONSTRAINT `bad_orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `bad_orders` */

insert  into `bad_orders`(`id`,`user_id`,`principal_id`,`sku_type`,`created_at`,`updated_at`,`agent_id`,`pcm_number`,`total_amount`,`customer_id`,`status`,`verified_date`,`verified_by`,`final_status`,`si_id`,`confirm_status`,`confirmed_by`,`confirmed_date`,`spoiled_goods`,`accounts_receivable`,`posted_amount`) values 
(1,1,2,'CASE','2024-01-04 21:33:43','2024-01-05 05:34:28',1,'PCM-BO-MAS-ALFE COMM\'L-1-0002',0.0000,23,'verified','2024-01-05',1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(2,1,2,'CASE','2024-01-06 10:22:28','2024-01-18 14:16:14',1,'PCM-BO-MAS-ALFE COMM\'L-1-54355234234',2076.2280,23,'verified','2024-01-06',1,NULL,1,'confirmed',1,'2018-09-15',2076.2280,2076.2280,700.0000),
(3,1,2,'CASE','2024-01-08 19:38:06','2024-01-09 04:28:23',1,'PCM-BO-MAS-ALFE COMM\'L-1-22222211111111',3333.0000,23,'verified','2024-01-09',1,NULL,NULL,'confirmed',1,'2024-01-09',3333.0000,3333.0000,NULL);

/*Table structure for table `bo_allowance_adjustments` */

DROP TABLE IF EXISTS `bo_allowance_adjustments`;

CREATE TABLE `bo_allowance_adjustments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `principal_id` int unsigned NOT NULL,
  `received_id` bigint unsigned NOT NULL,
  `user_id` int unsigned NOT NULL,
  `particulars` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `bo_allowance_deduction` double(15,4) NOT NULL,
  `net_deduction` double(15,4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `bo_allowance_adjustments_principal_id_index` (`principal_id`),
  KEY `bo_allowance_adjustments_received_id_index` (`received_id`),
  KEY `bo_allowance_adjustments_user_id_index` (`user_id`),
  CONSTRAINT `bo_allowance_adjustments_principal_id_foreign` FOREIGN KEY (`principal_id`) REFERENCES `sku_principals` (`id`),
  CONSTRAINT `bo_allowance_adjustments_received_id_foreign` FOREIGN KEY (`received_id`) REFERENCES `received_purchase_orders` (`id`),
  CONSTRAINT `bo_allowance_adjustments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `bo_allowance_adjustments` */

insert  into `bo_allowance_adjustments`(`id`,`principal_id`,`received_id`,`user_id`,`particulars`,`bo_allowance_deduction`,`net_deduction`,`created_at`,`updated_at`) values 
(1,2,1,1,'samplesa',-3900.0000,-3900.0000,'2023-11-13 11:57:43','2023-11-13 11:57:43'),
(2,2,1,1,'test 1',3900.0000,3900.0000,'2023-11-13 12:15:09','2023-11-13 12:15:09'),
(3,2,2,1,'sample',-90.0000,-90.0000,'2023-12-23 06:08:25','2023-12-23 06:08:25');

/*Table structure for table `bo_allowance_adjustments_details` */

DROP TABLE IF EXISTS `bo_allowance_adjustments_details`;

CREATE TABLE `bo_allowance_adjustments_details` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `bo_allowance_id` bigint unsigned NOT NULL,
  `sku_id` int unsigned NOT NULL,
  `quantity` int NOT NULL,
  `unit_cost` double(15,4) NOT NULL,
  `adjusted_amount` double(15,4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `bo_allowance_adjustments_details_bo_allowance_id_index` (`bo_allowance_id`),
  KEY `bo_allowance_adjustments_details_sku_id_index` (`sku_id`),
  CONSTRAINT `bo_allowance_adjustments_details_bo_allowance_id_foreign` FOREIGN KEY (`bo_allowance_id`) REFERENCES `bo_allowance_adjustments` (`id`),
  CONSTRAINT `bo_allowance_adjustments_details_sku_id_foreign` FOREIGN KEY (`sku_id`) REFERENCES `sku_adds` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `bo_allowance_adjustments_details` */

insert  into `bo_allowance_adjustments_details`(`id`,`bo_allowance_id`,`sku_id`,`quantity`,`unit_cost`,`adjusted_amount`,`created_at`,`updated_at`) values 
(1,1,211,990,377.9390,1.0000,'2023-11-13 11:57:43','2023-11-13 11:57:43'),
(2,1,212,980,403.9157,1.0000,'2023-11-13 11:57:43','2023-11-13 11:57:43'),
(3,1,213,970,372.9600,1.0000,'2023-11-13 11:57:43','2023-11-13 11:57:43'),
(4,1,214,960,284.3820,1.0000,'2023-11-13 11:57:43','2023-11-13 11:57:43'),
(5,2,211,990,377.9390,-1.0000,'2023-11-13 12:15:09','2023-11-13 12:15:09'),
(6,2,212,980,403.9157,-1.0000,'2023-11-13 12:15:09','2023-11-13 12:15:09'),
(7,2,213,970,372.9600,-1.0000,'2023-11-13 12:15:09','2023-11-13 12:15:09'),
(8,2,214,960,284.3820,-1.0000,'2023-11-13 12:15:09','2023-11-13 12:15:09'),
(9,3,211,90,377.9390,1.0000,'2023-12-23 06:08:25','2023-12-23 06:08:25');

/*Table structure for table `bo_allowance_adjustments_jers` */

DROP TABLE IF EXISTS `bo_allowance_adjustments_jers`;

CREATE TABLE `bo_allowance_adjustments_jers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `bo_allowance_id` bigint unsigned NOT NULL,
  `dr` double(15,4) NOT NULL,
  `cr` double(15,4) NOT NULL,
  `date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `bo_allowance_adjustments_jers_bo_allowance_id_index` (`bo_allowance_id`),
  KEY `bo_allowance_adjustments_jers_date_index` (`date`),
  CONSTRAINT `bo_allowance_adjustments_jers_bo_allowance_id_foreign` FOREIGN KEY (`bo_allowance_id`) REFERENCES `bo_allowance_adjustments` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `bo_allowance_adjustments_jers` */

insert  into `bo_allowance_adjustments_jers`(`id`,`bo_allowance_id`,`dr`,`cr`,`date`,`created_at`,`updated_at`) values 
(1,1,-3900.0000,-3900.0000,'2023-11-13','2023-11-13 11:57:43','2023-11-13 11:57:43'),
(2,2,3900.0000,3900.0000,'2023-11-13','2023-11-13 12:15:09','2023-11-13 12:15:09'),
(3,3,-90.0000,-90.0000,'2023-12-23','2023-12-23 06:08:25','2023-12-23 06:08:25');

/*Table structure for table `bodega_out_details` */

DROP TABLE IF EXISTS `bodega_out_details`;

CREATE TABLE `bodega_out_details` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `bodega_out_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `out_from_sku_id` int unsigned NOT NULL,
  `out_from_quantity` int NOT NULL,
  `in_to_sku_id` int unsigned NOT NULL,
  `in_to_quantity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `bodega_out_details_bodega_out_id_index` (`bodega_out_id`),
  KEY `bodega_out_details_out_from_sku_id_index` (`out_from_sku_id`),
  KEY `bodega_out_details_in_to_sku_id_index` (`in_to_sku_id`),
  CONSTRAINT `bodega_out_details_bodega_out_id_foreign` FOREIGN KEY (`bodega_out_id`) REFERENCES `bodega_outs` (`id`),
  CONSTRAINT `bodega_out_details_in_to_sku_id_foreign` FOREIGN KEY (`in_to_sku_id`) REFERENCES `sku_adds` (`id`),
  CONSTRAINT `bodega_out_details_out_from_sku_id_foreign` FOREIGN KEY (`out_from_sku_id`) REFERENCES `sku_adds` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `bodega_out_details` */

/*Table structure for table `bodega_outs` */

DROP TABLE IF EXISTS `bodega_outs`;

CREATE TABLE `bodega_outs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int unsigned NOT NULL,
  `principal_id` int unsigned NOT NULL,
  `remarks` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `bodega_outs_user_id_index` (`user_id`),
  KEY `bodega_outs_principal_id_index` (`principal_id`),
  KEY `bodega_outs_date_index` (`date`),
  CONSTRAINT `bodega_outs_principal_id_foreign` FOREIGN KEY (`principal_id`) REFERENCES `sku_principals` (`id`),
  CONSTRAINT `bodega_outs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `bodega_outs` */

/*Table structure for table `chart_of_accounts` */

DROP TABLE IF EXISTS `chart_of_accounts`;

CREATE TABLE `chart_of_accounts` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `account_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `account_number` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `principal` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=115 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `chart_of_accounts` */

insert  into `chart_of_accounts`(`id`,`account_name`,`account_number`,`created_at`,`updated_at`,`principal`) values 
(1,'CASH ON HAND','100100','2023-12-10 11:00:04','2023-12-10 11:00:04',NULL),
(2,'CASH IN BANK','100200','2023-12-10 11:04:33','2023-12-10 11:04:33',NULL),
(3,'ALLOWANCE FOR IMPAIRMENT - ACCOUNTS RECEIVABLE','100308','2023-12-10 11:14:11','2023-12-10 11:14:11',NULL),
(4,'VALE DUE FROM OFFICERS AND  EMPLOYEES','101100','2023-12-10 11:14:47','2023-12-10 11:14:47',NULL),
(5,'OTHER RECEIVABLES - CHARGES EMPLOYEES','101110','2023-12-10 11:15:19','2023-12-10 11:15:19',NULL),
(6,'ALLOWANCE FOR IMPAIRMENT - OTHER RECEIVABLES','101120','2023-12-10 11:15:48','2023-12-10 11:15:48',NULL),
(9,'MERCHANDISE INVENTORY','102000','2023-12-17 09:56:40','2023-12-17 09:56:40',1),
(10,'ACCOUNTS PAYABLE','200200','2023-12-17 09:57:43','2023-12-17 09:57:43',1),
(11,'SALES','400100','2023-12-17 09:58:15','2023-12-17 09:58:15',1),
(12,'COST OF SALES','400300','2023-12-17 09:58:36','2023-12-17 09:58:36',1),
(13,'ACCOUNTS RECEIVABLE','100300','2023-12-27 21:05:02','2023-12-27 21:05:02',NULL),
(16,'DUE TO BIR - CREDITABLE WITHHOLDING TAX','200250','2024-01-05 11:21:24','2024-01-05 11:21:24',NULL),
(19,'INVENTORY','103000','2024-01-06 09:39:33','2024-01-06 09:39:33',NULL),
(20,'LANDS','104000','2024-01-06 09:41:28','2024-01-06 09:41:28',NULL),
(21,'BUILDINGS','104010','2024-01-06 09:47:56','2024-01-06 09:47:56',NULL),
(22,'ACCUMULATED DEPRECIATION-BUILDINGS','104011','2024-01-06 09:49:09','2024-01-06 09:49:09',NULL),
(23,'MACHINERY','104020','2024-01-06 09:50:58','2024-01-06 09:50:58',NULL),
(24,'ACCUMULATED DEPRECIATION-MACHINERY','104021','2024-01-06 09:51:45','2024-01-06 09:51:45',NULL),
(25,'OFFICE EQUIPMENTS','104030','2024-01-06 09:52:22','2024-01-06 09:52:22',NULL),
(26,'ACCUMULATED DEPRECIATION-OFFICE EQUIPMENTS','104031','2024-01-06 09:52:58','2024-01-06 09:52:58',NULL),
(27,'INFORMATION AND COMMUNICATION TECHNOLOGY EQUIPMENT','104040','2024-01-06 09:53:43','2024-01-06 09:53:43',NULL),
(28,'ACCUMULATED DEPRECIATION-INFORMATION AND COMMUNICATION','104041','2024-01-06 09:54:38','2024-01-06 09:54:38',NULL),
(29,'COMMUNICATION EQUIPMENT','104050','2024-01-11 23:10:14','2024-01-11 23:10:14',NULL),
(30,'ACCUMULATED DEPRECIATION-COMMUNICATION EQUIPMENT','104051','2024-01-11 23:11:05','2024-01-11 23:11:05',NULL),
(31,'CONSTRUCTION AND HEAVY EQUIPMENT','104060','2024-01-11 23:12:08','2024-01-11 23:12:08',NULL),
(32,'ACCUMULATED DEPRECIATION-CONSTRUCTION AND HEAVY EQUIPMENT','104061','2024-01-11 23:12:58','2024-01-11 23:12:58',NULL),
(33,'DISASTER RESPONSE AND RESCUE EQUIPMENT','104070','2024-01-11 23:13:52','2024-01-11 23:13:52',NULL),
(34,'ACCUMULATED DEPRECIATION-DISASTER RESPONSE AND RES','104071','2024-01-11 23:14:52','2024-01-11 23:14:52',NULL),
(35,'SPORTS EQUIPMENT','104080','2024-01-11 23:15:19','2024-01-11 23:15:19',NULL),
(36,'TECHNICAL & SCIENTIFIC  EQUIPMENT','104081','2024-01-11 23:16:00','2024-01-11 23:16:00',NULL),
(37,'OTHER EQUIPMENT','104090','2024-01-11 23:16:42','2024-01-11 23:16:42',NULL),
(38,'ACCUMULATED DEPRECIATION-OTHER EQUIPMENT','104091','2024-01-11 23:17:36','2024-01-11 23:17:36',NULL),
(39,'MOTOR VEHICLES','104100','2024-01-11 23:18:15','2024-01-11 23:18:15',NULL),
(40,'ACCUMULATED DEPRECIATION-MOTOR VEHICLES','104101','2024-01-11 23:18:41','2024-01-11 23:18:41',NULL),
(41,'FURNITURE, FIXTURES AND BOOKS','104110','2024-01-11 23:19:20','2024-01-11 23:19:20',NULL),
(42,'ACCUMULATED DEPRECIATION-FURNITURE, FIXTURES AND B','104111','2024-01-11 23:19:45','2024-01-11 23:19:45',NULL),
(43,'CONSTRUCTION IN PROGRESS-INFRASTRUCTURE ASSETS','104120','2024-01-11 23:20:18','2024-01-11 23:20:18',NULL),
(44,'CONSTRUCTION IN PROGRESS-BUILDINGS AND OTHER STRUC','104121','2024-01-11 23:20:58','2024-01-11 23:20:58',NULL),
(45,'COMPUTER SOFTWARE','104130','2024-01-11 23:21:46','2024-01-11 23:21:46',NULL),
(46,'ACCUMULATED DEPRECIATION-COMPUTER SOFTWARE','104131','2024-01-11 23:22:14','2024-01-11 23:22:14',NULL),
(47,'OTHER INTANGIBLE ASSETS','104140','2024-01-11 23:22:38','2024-01-11 23:22:38',NULL),
(48,'ACCUMULATED DEPRECIATION-OTHER INTANGIBLE ASSETS','104141','2024-01-11 23:23:41','2024-01-11 23:23:41',NULL),
(49,'ADVANCES TO OFFICERS AND EMPLOYEES','105010','2024-01-11 23:24:19','2024-01-11 23:24:19',NULL),
(50,'ADVANCES TO CONTRACTOR','105020','2024-01-11 23:25:10','2024-01-11 23:25:10',NULL),
(51,'PREPAID REGISTRATION','105030','2024-01-11 23:25:51','2024-01-11 23:25:51',NULL),
(52,'PREPAID  INSURANCE','105040','2024-01-11 23:26:27','2024-01-11 23:26:27',NULL),
(53,'OTHER PREPAYMENTS','105050','2024-01-11 23:26:49','2024-01-11 23:26:49',NULL),
(54,'OTHER ASSET','105060','2024-01-11 23:27:12','2024-01-11 23:27:12',NULL),
(55,'DUE TO OFFICERS AND  EMPLOYEES - DEPOSIT','200220','2024-01-11 23:28:44','2024-01-11 23:28:44',NULL),
(56,'LOANS PAYABLE-DOMESTIC','200230','2024-01-11 23:29:02','2024-01-11 23:29:02',NULL),
(57,'DUE TO BIR - WITHHOLDING TAX COMPENSATION','200240','2024-01-11 23:29:41','2024-01-11 23:29:41',NULL),
(58,'DUE TO BIR - CREDITABLE WITHHOLDING TAX','200250','2024-01-11 23:30:29','2024-01-11 23:30:29',NULL),
(59,'DUE TO SSS - CONTRIBUTION','200260','2024-01-11 23:30:56','2024-01-11 23:30:56',NULL),
(61,'DUE TO SSS - EMPLOYEES LOAN','200270','2024-01-11 23:32:06','2024-01-11 23:32:06',NULL),
(62,'DUE TO PAG-IBIG - CONTRIBUTION','200280','2024-01-11 23:32:23','2024-01-11 23:32:23',NULL),
(63,'DUE TO PAG-IBIG - EMPLOYEES LOAN','200290','2024-01-11 23:32:48','2024-01-11 23:32:48',NULL),
(64,'DUE TO PHILHEALTH - CONTRIBUTION','200300','2024-01-11 23:33:08','2024-01-11 23:33:08',NULL),
(65,'RETAINED EARNINGS/ (DEFICIT)','300000','2024-01-11 23:34:00','2024-01-11 23:34:00',NULL),
(66,'SALES RETURNS AND ALLOWANCES','400107','2024-01-11 23:53:13','2024-01-11 23:53:13',NULL),
(67,'SALES DISCOUNTS','400108','2024-01-11 23:53:40','2024-01-11 23:53:40',NULL),
(68,'INTEREST  INCOME','400200','2024-01-11 23:54:27','2024-01-11 23:54:27',NULL),
(69,'FINES AND PENALTIES-BUSINESS INCOME','400210','2024-01-11 23:54:56','2024-01-11 23:54:56',NULL),
(70,'OTHER BUSINESS AND BUSINESS INCOME','400220','2024-01-11 23:55:21','2024-01-11 23:55:21',NULL),
(71,'MISCELLANEOUS INCOME','400230','2024-01-11 23:56:04','2024-01-11 23:56:04',NULL),
(72,'BO ALLOWANCE','400307','2024-01-11 23:56:38','2024-01-11 23:56:38',NULL),
(73,'PERSONNEL BENEFITS','400400','2024-01-12 00:09:08','2024-01-12 00:09:08',NULL),
(74,'SPOILED GOODS','00000','2024-01-12 04:05:48','2024-01-12 04:05:48',NULL),
(75,'TRAVEL EXPENSES-LOCAL','400501','2024-01-12 20:10:00','2024-01-12 20:10:00',NULL),
(76,'TRAINING EXPENSES','400510','2024-01-12 20:10:17','2024-01-12 20:10:17',NULL),
(77,'OFFICE SUPPLIES EXPENSE','400520','2024-01-12 20:10:35','2024-01-12 20:10:35',NULL),
(78,'ACCOUNTABLE FORMS EXPENSES','400530','2024-01-12 20:10:57','2024-01-12 20:10:57',NULL),
(79,'NON-ACCOUNTABLE FORMS EXPENSES','400540','2024-01-12 20:11:19','2024-01-12 20:11:19',NULL),
(80,'DRUGS AND MEDICINES EXPENSES','400550','2024-01-12 20:11:39','2024-01-12 20:11:39',NULL),
(81,'MEDICAL, DENTAL AND LABORATORY SUPPLIES EXPENSES','400560','2024-01-12 20:12:00','2024-01-12 20:12:00',NULL),
(82,'FUEL, OIL AND LUBRICANTS EXPENSES','400570','2024-01-12 20:12:19','2024-01-12 20:12:19',NULL),
(83,'SEMI-EXPENDABLE MACHINERY AND EQUIPMENT EXPENSES','400580','2024-01-12 20:12:37','2024-01-12 20:12:37',NULL),
(84,'SEMI-EXPENDABLE FURNITURE, FIXTURES AND BOOKS EXPE','400590','2024-01-12 20:12:59','2024-01-12 20:12:59',NULL),
(85,'OTHER SUPPLIES AND MATERIALS EXPENSES EXPENSES','400600','2024-01-12 20:13:19','2024-01-12 20:13:19',NULL),
(86,'UTILITIES EXPENSE - ELECTRICITY','400610','2024-01-12 20:13:37','2024-01-12 20:13:37',NULL),
(87,'UTILITIES EXPENSE - WATER UTILITIES','400611','2024-01-12 20:13:56','2024-01-12 20:13:56',NULL),
(88,'POSTAGE AND COURIER SERVICES','400620','2024-01-12 20:14:14','2024-01-12 20:14:14',NULL),
(89,'COMMUNICATION EXPENSES','400630','2024-01-12 20:14:33','2024-01-12 20:14:33',NULL),
(90,'INTERNET SUBSCRIPTION EXPENSES','400640','2024-01-12 20:14:50','2024-01-12 20:14:50',NULL),
(91,'CABLE, SATELLITE, TELEGRAPH AND RADIO  EXPENSES','400650','2024-01-12 20:15:10','2024-01-12 20:15:10',NULL),
(92,'LEGAL SERVICES','400660','2024-01-12 20:15:26','2024-01-12 20:15:26',NULL),
(93,'AUDITING SERVICES','400670','2024-01-12 20:15:59','2024-01-12 20:15:59',NULL),
(94,'CONSULTANCY SERVICES','400680','2024-01-12 20:17:10','2024-01-12 20:17:10',NULL),
(95,'OTHER PROFESSIONAL SERVICES','400690','2024-01-12 20:17:28','2024-01-12 20:17:28',NULL),
(96,'JANITORIAL SERVICES','400700','2024-01-12 20:17:56','2024-01-12 20:17:56',NULL),
(97,'SECURITY SERVICES','400710','2024-01-12 20:19:57','2024-01-12 20:19:57',NULL),
(98,'REPAIRS AND MAINTENANCE-BUILDINGS AND OTHER STRUCT','400720','2024-01-12 20:20:16','2024-01-12 20:20:16',NULL),
(99,'REPAIRS AND MAINTENANCE-MACHINERY & EQUIPMENT','400730','2024-01-12 20:20:30','2024-01-12 20:20:30',NULL),
(100,'REPAIRS AND MAINTENANCE- TRANSPORTATION EQUIPMENT','400740','2024-01-12 20:20:46','2024-01-12 20:20:46',NULL),
(101,'TAXES, DUTIES AND LICENSES','400750','2024-01-12 20:21:01','2024-01-12 20:21:01',NULL),
(102,'INSURANCE EXPENSES','400760','2024-01-12 20:21:14','2024-01-12 20:21:14',NULL),
(103,'ADVERTISING, PROMOTIONAL AND MARKETING EXPENSES','400770','2024-01-12 20:21:33','2024-01-12 20:21:33',NULL),
(104,'PRINTING AND PUBLICATION EXPENSES','400780','2024-01-12 20:21:46','2024-01-12 20:21:46',NULL),
(105,'TRANSPORTATION AND DELIVERY EXPENSES','400790','2024-01-12 20:22:08','2024-01-12 20:22:08',NULL),
(106,'RENT/ LEASE EXPENSES','400800','2024-01-12 20:22:21','2024-01-12 20:22:21',NULL),
(107,'MEMBERSHIP DUES AND CONTRIBUTIONS TO ORGANIZATIONS','400810','2024-01-12 20:35:07','2024-01-12 20:35:07',NULL),
(108,'DONATIONS','400820','2024-01-12 20:35:27','2024-01-12 20:35:27',NULL),
(109,'DIRECTORS AND COMMITTEE MEMBER\'S FEE','400830','2024-01-12 20:35:42','2024-01-12 20:35:42',NULL),
(110,'MAJOR EVENTS AND CONVENTIONS EXPENSES','400840','2024-01-12 20:35:55','2024-01-12 20:35:55',NULL),
(111,'INTEREST EXPENSES','400860','2024-01-12 20:36:12','2024-01-12 20:36:12',NULL),
(112,'BANK CHARGES','400870','2024-01-12 20:36:25','2024-01-12 20:36:25',NULL),
(113,'DEPRECIATION EXPENSES','400900','2024-01-12 20:37:11','2024-01-12 20:37:11',NULL),
(114,'AMORTIZATION-INTANGIBLE ASSETS','401000','2024-01-12 20:37:33','2024-01-12 20:37:33',NULL);

/*Table structure for table `chart_of_accounts_details` */

DROP TABLE IF EXISTS `chart_of_accounts_details`;

CREATE TABLE `chart_of_accounts_details` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `chart_of_accounts_id` int unsigned DEFAULT NULL,
  `account_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `account_number` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `principal_id` int unsigned DEFAULT NULL,
  `customer_id` bigint unsigned DEFAULT NULL,
  `normal_balance` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `chart_of_accounts_details_chart_of_accounts_id_index` (`chart_of_accounts_id`),
  KEY `chart_of_accounts_details_principal_id_index` (`principal_id`),
  KEY `chart_of_accounts_details_customer_id_index` (`customer_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1291 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `chart_of_accounts_details` */

insert  into `chart_of_accounts_details`(`id`,`chart_of_accounts_id`,`account_name`,`account_number`,`created_at`,`updated_at`,`principal_id`,`customer_id`,`normal_balance`) values 
(1,1,'PETTY CASH','100101','2023-12-10 11:00:04','2023-12-10 11:00:04',NULL,NULL,'debit'),
(2,2,'CASH IN BANK - BDO','100201','2023-12-10 11:04:33','2023-12-10 11:04:33',NULL,NULL,'debit'),
(3,2,'CASH IN BANK - CHINA BANK','100202','2023-12-10 11:04:33','2023-12-10 11:04:33',NULL,NULL,'debit'),
(4,2,'CASH IN BANK - UNION BANK','100203','2023-12-10 11:04:33','2023-12-10 11:04:33',NULL,NULL,'debit'),
(5,2,'CASH IN BANK - METROBANK','100204','2023-12-10 11:04:33','2023-12-10 11:04:33',NULL,NULL,'debit'),
(6,2,'CASH IN BANK - BPI','100205','2023-12-10 11:04:33','2023-12-10 11:04:33',NULL,NULL,'debit'),
(7,3,'ALLOWANCE FOR IMPAIRMENT-ACCOUNTS RECEIVABLE','100308','2023-12-10 11:14:11','2023-12-10 11:14:11',NULL,NULL,'credit'),
(8,4,'VALE DUE FROM OFFICERS AND  EMPLOYEES','101100','2023-12-10 11:14:47','2023-12-10 11:14:47',NULL,NULL,'debit'),
(9,5,'OTHER RECEIVABLES - CHARGES EMPLOYEES','101110','2023-12-10 11:15:19','2023-12-10 11:15:19',NULL,NULL,'debit'),
(10,6,'ALLOWANCE FOR IMPAIRMENT-OTHER RECEIVABLES','101120','2023-12-10 11:15:48','2023-12-10 11:15:48',NULL,NULL,'credit '),
(82,10,'ACCOUNTS PAYABLE - PPMC','200207','2023-12-17 11:39:34','2023-12-17 11:39:34',8,NULL,'credit'),
(81,10,'ACCOUNTS PAYABLE - CIFPI','200206','2023-12-17 11:39:34','2023-12-17 11:39:34',7,NULL,'credit'),
(80,10,'ACCOUNTS PAYABLE - ALASKA','200205','2023-12-17 11:39:34','2023-12-17 11:39:34',6,NULL,'credit'),
(79,10,'ACCOUNTS PAYABLE - DOLE','200204','2023-12-17 11:39:34','2023-12-17 11:39:34',5,NULL,'credit'),
(78,10,'ACCOUNTS PAYABLE - EPI','200203','2023-12-17 11:39:34','2023-12-17 11:39:34',4,NULL,'credit'),
(77,10,'ACCOUNTS PAYABLE - PFC','200202','2023-12-17 11:39:34','2023-12-17 11:39:34',3,NULL,'credit'),
(76,10,'ACCOUNTS PAYABLE - GCI','200201','2023-12-17 11:39:34','2023-12-17 11:39:34',2,NULL,'credit'),
(74,11,'SALES - PPMC','400107','2023-12-17 11:38:55','2023-12-17 11:38:55',8,NULL,'credit'),
(75,11,'SALES - SUNPRIDE FOODS','400108','2023-12-17 11:38:55','2023-12-17 11:38:55',10,NULL,'credit'),
(73,11,'SALES - CIFPI','400106','2023-12-17 11:38:55','2023-12-17 11:38:55',7,NULL,'credit'),
(72,11,'SALES - ALASKA','400105','2023-12-17 11:38:55','2023-12-17 11:38:55',6,NULL,'credit'),
(71,11,'SALES - DOLE','400104','2023-12-17 11:38:55','2023-12-17 11:38:55',5,NULL,'credit'),
(70,11,'SALES - EPI','400103','2023-12-17 11:38:55','2023-12-17 11:38:55',4,NULL,'credit'),
(69,11,'SALES - PFC','400102','2023-12-17 11:38:55','2023-12-17 11:38:55',3,NULL,'credit'),
(68,11,'SALES - GCI','400101','2023-12-17 11:38:55','2023-12-17 11:38:55',2,NULL,'credit'),
(83,10,'ACCOUNTS PAYABLE - SUNPRIDE FOODS','200208','2023-12-17 11:39:34','2023-12-17 11:39:34',10,NULL,'credit'),
(98,12,'COST OF SALES - PPMC','400307','2023-12-17 11:42:14','2023-12-17 11:42:14',8,NULL,'debit'),
(97,12,'COST OF SALES - CIFPI','400306','2023-12-17 11:42:14','2023-12-17 11:42:14',7,NULL,'debit'),
(96,12,'COST OF SALES - ALASKA','400305','2023-12-17 11:42:14','2023-12-17 11:42:14',6,NULL,'debit'),
(95,12,'COST OF SALES - DOLE','400304','2023-12-17 11:42:14','2023-12-17 11:42:14',5,NULL,'debit'),
(94,12,'COST OF SALES - EPI','400303','2023-12-17 11:42:14','2023-12-17 11:42:14',4,NULL,'debit'),
(93,12,'COST OF SALES - PFC','400302','2023-12-17 11:42:14','2023-12-17 11:42:14',3,NULL,'debit'),
(92,12,'COST OF SALES - GCI','400301','2023-12-17 11:42:14','2023-12-17 11:42:14',2,NULL,'debit'),
(99,12,'COST OF SALES - SUNPRIDE FOODS','400308','2023-12-17 11:42:14','2023-12-17 11:42:14',10,NULL,'debit'),
(118,9,'MERCHANDISE INVENTORY - ALASKA','102005','2023-12-17 12:40:35','2023-12-17 12:40:35',6,NULL,'debit'),
(119,9,'MERCHANDISE INVENTORY - CIFPI','102006','2023-12-17 12:40:35','2023-12-17 12:40:35',7,NULL,'debit'),
(117,9,'MERCHANDISE INVENTORY - DOLE','102004','2023-12-17 12:40:35','2023-12-17 12:40:35',5,NULL,'debit'),
(116,9,'MERCHANDISE INVENTORY - EPI','102003','2023-12-17 12:40:35','2023-12-17 12:40:35',4,NULL,'debit'),
(115,9,'MERCHANDISE INVENTORY - PFC','102002','2023-12-17 12:40:35','2023-12-17 12:40:35',3,NULL,'debit'),
(114,9,'MERCHANDISE INVENTORY - GCI','102001','2023-12-17 12:40:35','2023-12-17 12:40:35',2,NULL,'debit'),
(120,9,'MERCHANDISE INVENTORY - PPMC','102007','2023-12-17 12:40:35','2023-12-17 12:40:35',8,NULL,'debit'),
(121,9,'MERCHANDISE INVENTORY - SUNPRIDE FOODS','102008','2023-12-17 12:40:35','2023-12-17 12:40:35',10,NULL,'debit'),
(1157,13,'ACCOUNTS RECEIVABLE - SIDNEY SALAZAR STORE','100469','2023-12-28 06:05:28','2023-12-28 06:05:28',NULL,190,'debit'),
(1156,13,'ACCOUNTS RECEIVABLE - VAN SELLING','100468','2023-12-28 06:05:28','2023-12-28 06:05:28',NULL,189,'debit'),
(1155,13,'ACCOUNTS RECEIVABLE - QWEQW','100467','2023-12-28 06:05:28','2023-12-28 06:05:28',NULL,188,'debit'),
(1154,13,'ACCOUNTS RECEIVABLE - STORE','100466','2023-12-28 06:05:28','2023-12-28 06:05:28',NULL,187,'debit'),
(1152,13,'ACCOUNTS RECEIVABLE - WADHUS','100464','2023-12-28 06:05:28','2023-12-28 06:05:28',NULL,185,'debit'),
(1153,13,'ACCOUNTS RECEIVABLE - WESTERN ENT','100465','2023-12-28 06:05:28','2023-12-28 06:05:28',NULL,186,'debit'),
(1151,13,'ACCOUNTS RECEIVABLE - VMED MARKETING','100463','2023-12-28 06:05:28','2023-12-28 06:05:28',NULL,184,'debit'),
(1150,13,'ACCOUNTS RECEIVABLE - UP MARKETING','100462','2023-12-28 06:05:28','2023-12-28 06:05:28',NULL,183,'debit'),
(1149,13,'ACCOUNTS RECEIVABLE - UNIVERSAL CAGAYAN','100461','2023-12-28 06:05:28','2023-12-28 06:05:28',NULL,182,'debit'),
(1148,13,'ACCOUNTS RECEIVABLE - UNITOP GENERAL MERCHANDISE INC.-COGON','100460','2023-12-28 06:05:28','2023-12-28 06:05:28',NULL,181,'debit'),
(1147,13,'ACCOUNTS RECEIVABLE - UNITOP GENERAL MERCHANDISE INC.- CARMEN','100459','2023-12-28 06:05:28','2023-12-28 06:05:28',NULL,180,'debit'),
(1146,13,'ACCOUNTS RECEIVABLE - UN ELECTRONICS','100458','2023-12-28 06:05:28','2023-12-28 06:05:28',NULL,179,'debit'),
(1145,13,'ACCOUNTS RECEIVABLE - TUNA MARKETING','100457','2023-12-28 06:05:28','2023-12-28 06:05:28',NULL,178,'debit'),
(1144,13,'ACCOUNTS RECEIVABLE - TRU PARTS','100456','2023-12-28 06:05:28','2023-12-28 06:05:28',NULL,177,'debit'),
(1143,13,'ACCOUNTS RECEIVABLE - TH CAGAYAN','100455','2023-12-28 06:05:28','2023-12-28 06:05:28',NULL,176,'debit'),
(1142,13,'ACCOUNTS RECEIVABLE - SUCCESS ENTERPRISE','100454','2023-12-28 06:05:28','2023-12-28 06:05:28',NULL,175,'debit'),
(1141,13,'ACCOUNTS RECEIVABLE - STRZ ELECTRONICS','100453','2023-12-28 06:05:28','2023-12-28 06:05:28',NULL,174,'debit'),
(1140,13,'ACCOUNTS RECEIVABLE - SOLID SHIPPING LINES','100452','2023-12-28 06:05:28','2023-12-28 06:05:28',NULL,173,'debit'),
(1139,13,'ACCOUNTS RECEIVABLE - SIA BON SUAN (GIFTMATE GIFTSHOP)','100451','2023-12-28 06:05:28','2023-12-28 06:05:28',NULL,172,'debit'),
(1138,13,'ACCOUNTS RECEIVABLE - SCC','100450','2023-12-28 06:05:28','2023-12-28 06:05:28',NULL,171,'debit'),
(1137,13,'ACCOUNTS RECEIVABLE - SAVEMORE PHARMACY','100449','2023-12-28 06:05:28','2023-12-28 06:05:28',NULL,170,'debit'),
(1136,13,'ACCOUNTS RECEIVABLE - SALWIN MART','100448','2023-12-28 06:05:28','2023-12-28 06:05:28',NULL,169,'debit'),
(1133,13,'ACCOUNTS RECEIVABLE - ROSE PHAR.INC.(AGORA)','100445','2023-12-28 06:05:28','2023-12-28 06:05:28',NULL,166,'debit'),
(1134,13,'ACCOUNTS RECEIVABLE - ROSE PHARMACY - GAISANO BULUA 2','100446','2023-12-28 06:05:28','2023-12-28 06:05:28',NULL,167,'debit'),
(1135,13,'ACCOUNTS RECEIVABLE - SALAHID','100447','2023-12-28 06:05:28','2023-12-28 06:05:28',NULL,168,'debit'),
(1132,13,'ACCOUNTS RECEIVABLE - ROSE PHAR.INC (ORORAMA COGON)','100444','2023-12-28 06:05:28','2023-12-28 06:05:28',NULL,165,'debit'),
(1131,13,'ACCOUNTS RECEIVABLE - ROSE PHAR.INC (ORORAMA CARMEN)','100443','2023-12-28 06:05:28','2023-12-28 06:05:28',NULL,164,'debit'),
(1127,13,'ACCOUNTS RECEIVABLE - ROSE PHAR. INC.( ABEJUELA)','100439','2023-12-28 06:05:28','2023-12-28 06:05:28',NULL,160,'debit'),
(1128,13,'ACCOUNTS RECEIVABLE - ROSE PHAR. INC.(BULUA)','100440','2023-12-28 06:05:28','2023-12-28 06:05:28',NULL,161,'debit'),
(1129,13,'ACCOUNTS RECEIVABLE - ROSE PHAR.INC (AYALA CENTRIO)','100441','2023-12-28 06:05:28','2023-12-28 06:05:28',NULL,162,'debit'),
(1130,13,'ACCOUNTS RECEIVABLE - ROSE PHAR.INC (LIMKETKAI)','100442','2023-12-28 06:05:28','2023-12-28 06:05:28',NULL,163,'debit'),
(1126,13,'ACCOUNTS RECEIVABLE - ROSE PHAR. INC. (VAMENTA)','100438','2023-12-28 06:05:28','2023-12-28 06:05:28',NULL,159,'debit'),
(1125,13,'ACCOUNTS RECEIVABLE - ROSE PHAR. INC. (GAISANO)','100437','2023-12-28 06:05:28','2023-12-28 06:05:28',NULL,158,'debit'),
(1124,13,'ACCOUNTS RECEIVABLE - ROSE PHAR. INC. (CARMEN)','100436','2023-12-28 06:05:28','2023-12-28 06:05:28',NULL,157,'debit'),
(1123,13,'ACCOUNTS RECEIVABLE - ROSE PHAR. INC. ( CRUZ TAAL)','100435','2023-12-28 06:05:28','2023-12-28 06:05:28',NULL,156,'debit'),
(1122,13,'ACCOUNTS RECEIVABLE - ROSE PHAR. INC. - (BULUA GAISANO)','100434','2023-12-28 06:05:28','2023-12-28 06:05:28',NULL,155,'debit'),
(1121,13,'ACCOUNTS RECEIVABLE - ROSE PHAR. INC (PUERTO)','100433','2023-12-28 06:05:28','2023-12-28 06:05:28',NULL,154,'debit'),
(1120,13,'ACCOUNTS RECEIVABLE - ROSE PHAR. INC (MACASANDIG)','100432','2023-12-28 06:05:28','2023-12-28 06:05:28',NULL,153,'debit'),
(1119,13,'ACCOUNTS RECEIVABLE - ROSE PHAR. INC (LAPASAN)','100431','2023-12-28 06:05:28','2023-12-28 06:05:28',NULL,152,'debit'),
(1118,13,'ACCOUNTS RECEIVABLE - ROSE PHAR. INC (KAUSWAGAN)','100430','2023-12-28 06:05:28','2023-12-28 06:05:28',NULL,151,'debit'),
(1117,13,'ACCOUNTS RECEIVABLE - ROSE PHAR. INC (JR.BORJA)','100429','2023-12-28 06:05:28','2023-12-28 06:05:28',NULL,150,'debit'),
(1114,13,'ACCOUNTS RECEIVABLE - ROSE PHAR. INC ( DAUMAR)','100426','2023-12-28 06:05:28','2023-12-28 06:05:28',NULL,147,'debit'),
(1115,13,'ACCOUNTS RECEIVABLE - ROSE PHAR. INC ( PUEBLO)','100427','2023-12-28 06:05:28','2023-12-28 06:05:28',NULL,148,'debit'),
(1116,13,'ACCOUNTS RECEIVABLE - ROSE PHAR. INC (GUSA)','100428','2023-12-28 06:05:28','2023-12-28 06:05:28',NULL,149,'debit'),
(1111,13,'ACCOUNTS RECEIVABLE - ROJON PHARMACY CORPORATION -PUERTO','100423','2023-12-28 06:05:28','2023-12-28 06:05:28',NULL,144,'debit'),
(1112,13,'ACCOUNTS RECEIVABLE - ROSE PHAR.  INC. (SHOPWISE)','100424','2023-12-28 06:05:28','2023-12-28 06:05:28',NULL,145,'debit'),
(1113,13,'ACCOUNTS RECEIVABLE - ROSE PHAR. (GUSA WAREHOUSE)','100425','2023-12-28 06:05:28','2023-12-28 06:05:28',NULL,146,'debit'),
(1105,13,'ACCOUNTS RECEIVABLE - RIKA DRUGSTORE(PUERTO)','100417','2023-12-28 06:05:28','2023-12-28 06:05:28',NULL,138,'debit'),
(1106,13,'ACCOUNTS RECEIVABLE - RIKA DRUGSTORE(UPTOWN CITY)','100418','2023-12-28 06:05:28','2023-12-28 06:05:28',NULL,139,'debit'),
(1107,13,'ACCOUNTS RECEIVABLE - RIKA DRUGSTORE-VILLA ERNESTO','100419','2023-12-28 06:05:28','2023-12-28 06:05:28',NULL,140,'debit'),
(1108,13,'ACCOUNTS RECEIVABLE - ROJON PHARMACY CORPORATION -CARMEN','100420','2023-12-28 06:05:28','2023-12-28 06:05:28',NULL,141,'debit'),
(1109,13,'ACCOUNTS RECEIVABLE - ROJON PHARMACY CORPORATION -COGON','100421','2023-12-28 06:05:28','2023-12-28 06:05:28',NULL,142,'debit'),
(1110,13,'ACCOUNTS RECEIVABLE - ROJON PHARMACY CORPORATION -OPOL','100422','2023-12-28 06:05:28','2023-12-28 06:05:28',NULL,143,'debit'),
(1102,13,'ACCOUNTS RECEIVABLE - RIKA DRUGSTORE- TAGOLOAN','100414','2023-12-28 06:05:28','2023-12-28 06:05:28',NULL,135,'debit'),
(1103,13,'ACCOUNTS RECEIVABLE - RIKA DRUGSTORE- VELEZ','100415','2023-12-28 06:05:28','2023-12-28 06:05:28',NULL,136,'debit'),
(1104,13,'ACCOUNTS RECEIVABLE - RIKA DRUGSTORE(OSME?A)','100416','2023-12-28 06:05:28','2023-12-28 06:05:28',NULL,137,'debit'),
(1100,13,'ACCOUNTS RECEIVABLE - RIKA DRUGSTORE -DIVISORIA','100412','2023-12-28 06:05:28','2023-12-28 06:05:28',NULL,133,'debit'),
(1101,13,'ACCOUNTS RECEIVABLE - RIKA DRUGSTORE- NERI PABAYO','100413','2023-12-28 06:05:28','2023-12-28 06:05:28',NULL,134,'debit'),
(1096,13,'ACCOUNTS RECEIVABLE - RIKA DRUGSTORE (UPTOWN)','100408','2023-12-28 06:05:28','2023-12-28 06:05:28',NULL,129,'debit'),
(1097,13,'ACCOUNTS RECEIVABLE - RIKA DRUGSTORE (VELEZ)','100409','2023-12-28 06:05:28','2023-12-28 06:05:28',NULL,130,'debit'),
(1098,13,'ACCOUNTS RECEIVABLE - RIKA DRUGSTORE (VILLA ERNESTO)','100410','2023-12-28 06:05:28','2023-12-28 06:05:28',NULL,131,'debit'),
(1099,13,'ACCOUNTS RECEIVABLE - RIKA DRUGSTORE (YACAPIN)','100411','2023-12-28 06:05:28','2023-12-28 06:05:28',NULL,132,'debit'),
(1095,13,'ACCOUNTS RECEIVABLE - RIKA DRUGSTORE (KAUSWAGAN)','100407','2023-12-28 06:05:28','2023-12-28 06:05:28',NULL,128,'debit'),
(1094,13,'ACCOUNTS RECEIVABLE - RIKA DRUGSTORE (JR BORJA)','100406','2023-12-28 06:05:28','2023-12-28 06:05:28',NULL,127,'debit'),
(1093,13,'ACCOUNTS RECEIVABLE - RIKA DRUGSTORE (GUSA)','100405','2023-12-28 06:05:28','2023-12-28 06:05:28',NULL,126,'debit'),
(1092,13,'ACCOUNTS RECEIVABLE - RIKA DRUGSTORE (DIVISORIA)','100404','2023-12-28 06:05:28','2023-12-28 06:05:28',NULL,125,'debit'),
(1091,13,'ACCOUNTS RECEIVABLE - RIKA DRUGSTORE (CARMEN MARKET)','100403','2023-12-28 06:05:28','2023-12-28 06:05:28',NULL,124,'debit'),
(1090,13,'ACCOUNTS RECEIVABLE - RIKA DRUGSTORE (ALUBIJID)','100402','2023-12-28 06:05:28','2023-12-28 06:05:28',NULL,123,'debit'),
(1089,13,'ACCOUNTS RECEIVABLE - RIKA DRUGSTORE (AGORA)','100401','2023-12-28 06:05:28','2023-12-28 06:05:28',NULL,122,'debit'),
(1088,13,'ACCOUNTS RECEIVABLE - RIKA DRUGSTORE - OPOL','100400','2023-12-28 06:05:28','2023-12-28 06:05:28',NULL,121,'debit'),
(1087,13,'ACCOUNTS RECEIVABLE - RIKA DRUGSTORE - MAHOGANY','100399','2023-12-28 06:05:28','2023-12-28 06:05:28',NULL,120,'debit'),
(1084,13,'ACCOUNTS RECEIVABLE - RASHIDA STORE (PALA?A STORE)','100396','2023-12-28 06:05:28','2023-12-28 06:05:28',NULL,117,'debit'),
(1085,13,'ACCOUNTS RECEIVABLE - RIKA  DRUGSTORE (PATAG)','100397','2023-12-28 06:05:28','2023-12-28 06:05:28',NULL,118,'debit'),
(1086,13,'ACCOUNTS RECEIVABLE - RIKA DRUGSTORE - CAPITOL P.','100398','2023-12-28 06:05:28','2023-12-28 06:05:28',NULL,119,'debit'),
(1083,13,'ACCOUNTS RECEIVABLE - PROGRESS TRADING','100395','2023-12-28 06:05:28','2023-12-28 06:05:28',NULL,116,'debit'),
(1082,13,'ACCOUNTS RECEIVABLE - PRINCEMIN CORPORATION (OPOL)','100394','2023-12-28 06:05:28','2023-12-28 06:05:28',NULL,115,'debit'),
(1081,13,'ACCOUNTS RECEIVABLE - ORORAMA SUPERCENTER (COGON)','100393','2023-12-28 06:05:28','2023-12-28 06:05:28',NULL,114,'debit'),
(1080,13,'ACCOUNTS RECEIVABLE - ORORAMA SUPERSTORE (CARMEN)','100392','2023-12-28 06:05:27','2023-12-28 06:05:27',NULL,113,'debit'),
(1079,13,'ACCOUNTS RECEIVABLE - ORO SOLID','100391','2023-12-28 06:05:27','2023-12-28 06:05:27',NULL,112,'debit'),
(1078,13,'ACCOUNTS RECEIVABLE - ORO REAL','100390','2023-12-28 06:05:27','2023-12-28 06:05:27',NULL,111,'debit'),
(1077,13,'ACCOUNTS RECEIVABLE - NORTHERN SALES','100389','2023-12-28 06:05:27','2023-12-28 06:05:27',NULL,110,'debit'),
(1076,13,'ACCOUNTS RECEIVABLE - NORSAIDA STORE','100388','2023-12-28 06:05:27','2023-12-28 06:05:27',NULL,109,'debit'),
(1075,13,'ACCOUNTS RECEIVABLE - MERRYMART GROCERY CENTERS  INC.-IPONAN','100387','2023-12-28 06:05:27','2023-12-28 06:05:27',NULL,108,'debit'),
(1074,13,'ACCOUNTS RECEIVABLE - MERRYMART GROCERY CENTERS  INC.-BULUA','100386','2023-12-28 06:05:27','2023-12-28 06:05:27',NULL,107,'debit'),
(1073,13,'ACCOUNTS RECEIVABLE - MED ASIA','100385','2023-12-28 06:05:27','2023-12-28 06:05:27',NULL,106,'debit'),
(1072,13,'ACCOUNTS RECEIVABLE - MC ALBA FOODS CORPORATION','100384','2023-12-28 06:05:27','2023-12-28 06:05:27',NULL,105,'debit'),
(1071,13,'ACCOUNTS RECEIVABLE - MARALEX PHARMACY','100383','2023-12-28 06:05:27','2023-12-28 06:05:27',NULL,104,'debit'),
(1070,13,'ACCOUNTS RECEIVABLE - LUKE MEDICAL SUPPLIES','100382','2023-12-28 06:05:27','2023-12-28 06:05:27',NULL,103,'debit'),
(1069,13,'ACCOUNTS RECEIVABLE - LIONS DEN','100381','2023-12-28 06:05:27','2023-12-28 06:05:27',NULL,102,'debit'),
(1068,13,'ACCOUNTS RECEIVABLE - LIFE CORPS MEDCARE','100380','2023-12-28 06:05:27','2023-12-28 06:05:27',NULL,101,'debit'),
(1067,13,'ACCOUNTS RECEIVABLE - LG ELECTRONICS','100379','2023-12-28 06:05:27','2023-12-28 06:05:27',NULL,100,'debit'),
(1066,13,'ACCOUNTS RECEIVABLE - KAKING','100378','2023-12-28 06:05:27','2023-12-28 06:05:27',NULL,99,'debit'),
(1065,13,'ACCOUNTS RECEIVABLE - JVS AUDIO ','100377','2023-12-28 06:05:27','2023-12-28 06:05:27',NULL,98,'debit'),
(1064,13,'ACCOUNTS RECEIVABLE - JULMAR COMMERCIAL INC','100376','2023-12-28 06:05:27','2023-12-28 06:05:27',NULL,97,'debit'),
(1063,13,'ACCOUNTS RECEIVABLE - JR CLAD BUILDERS ENT.','100375','2023-12-28 06:05:27','2023-12-28 06:05:27',NULL,96,'debit'),
(1062,13,'ACCOUNTS RECEIVABLE - JINSING STORE (CUGMAN)','100374','2023-12-28 06:05:27','2023-12-28 06:05:27',NULL,95,'debit'),
(1061,13,'ACCOUNTS RECEIVABLE - JINSING 2','100373','2023-12-28 06:05:27','2023-12-28 06:05:27',NULL,94,'debit'),
(1060,13,'ACCOUNTS RECEIVABLE - JIMAR CONSTRUCTION','100372','2023-12-28 06:05:27','2023-12-28 06:05:27',NULL,93,'debit'),
(1059,13,'ACCOUNTS RECEIVABLE - IC MKTG.','100371','2023-12-28 06:05:27','2023-12-28 06:05:27',NULL,92,'debit'),
(1058,13,'ACCOUNTS RECEIVABLE - HOLLYSON STORE (CARMEN)','100370','2023-12-28 06:05:27','2023-12-28 06:05:27',NULL,91,'debit'),
(1057,13,'ACCOUNTS RECEIVABLE - HBL MARKETING (BORJA)','100369','2023-12-28 06:05:27','2023-12-28 06:05:27',NULL,90,'debit'),
(1056,13,'ACCOUNTS RECEIVABLE - HADJI JAMILAH (BODEGA)','100368','2023-12-28 06:05:27','2023-12-28 06:05:27',NULL,89,'debit'),
(1055,13,'ACCOUNTS RECEIVABLE - HADJI JAMILAH (STORE)','100367','2023-12-28 06:05:27','2023-12-28 06:05:27',NULL,88,'debit'),
(1054,13,'ACCOUNTS RECEIVABLE - GRAPHICS','100366','2023-12-28 06:05:27','2023-12-28 06:05:27',NULL,87,'debit'),
(1053,13,'ACCOUNTS RECEIVABLE - GOLDEN FAMILY','100365','2023-12-28 06:05:27','2023-12-28 06:05:27',NULL,86,'debit'),
(1051,13,'ACCOUNTS RECEIVABLE - GOLD CREST','100363','2023-12-28 06:05:27','2023-12-28 06:05:27',NULL,84,'debit'),
(1052,13,'ACCOUNTS RECEIVABLE - GOLDEN ACE','100364','2023-12-28 06:05:27','2023-12-28 06:05:27',NULL,85,'debit'),
(1050,13,'ACCOUNTS RECEIVABLE - GAISANO OSME?A','100362','2023-12-28 06:05:27','2023-12-28 06:05:27',NULL,83,'debit'),
(1049,13,'ACCOUNTS RECEIVABLE - GAISANO SUKI CLUB/NEOPACE INC.','100361','2023-12-28 06:05:27','2023-12-28 06:05:27',NULL,82,'debit'),
(1047,13,'ACCOUNTS RECEIVABLE - GAISANO CITY-MALL','100359','2023-12-28 06:05:27','2023-12-28 06:05:27',NULL,80,'debit'),
(1048,13,'ACCOUNTS RECEIVABLE - GAISANO MALL PUERTO','100360','2023-12-28 06:05:27','2023-12-28 06:05:27',NULL,81,'debit'),
(1046,13,'ACCOUNTS RECEIVABLE - GAISANO CARMEN','100358','2023-12-28 06:05:27','2023-12-28 06:05:27',NULL,79,'debit'),
(1045,13,'ACCOUNTS RECEIVABLE - GAISANO CITI SUPER MALL-BULUA','100357','2023-12-28 06:05:27','2023-12-28 06:05:27',NULL,78,'debit'),
(1044,13,'ACCOUNTS RECEIVABLE - GAISANO CAPITAL','100356','2023-12-28 06:05:27','2023-12-28 06:05:27',NULL,77,'debit'),
(1043,13,'ACCOUNTS RECEIVABLE - GAISANO (J.R BORJA)','100355','2023-12-28 06:05:27','2023-12-28 06:05:27',NULL,76,'debit'),
(1042,13,'ACCOUNTS RECEIVABLE - FORTUNE ENTERPRISE','100354','2023-12-28 06:05:27','2023-12-28 06:05:27',NULL,75,'debit'),
(1041,13,'ACCOUNTS RECEIVABLE - FB BUDGETAL CORP.','100353','2023-12-28 06:05:27','2023-12-28 06:05:27',NULL,74,'debit'),
(1040,13,'ACCOUNTS RECEIVABLE - FAT CHEF','100352','2023-12-28 06:05:27','2023-12-28 06:05:27',NULL,73,'debit'),
(1039,13,'ACCOUNTS RECEIVABLE - EXCEL TRADING','100351','2023-12-28 06:05:27','2023-12-28 06:05:27',NULL,72,'debit'),
(1038,13,'ACCOUNTS RECEIVABLE - EVERBEST','100350','2023-12-28 06:05:27','2023-12-28 06:05:27',NULL,71,'debit'),
(1037,13,'ACCOUNTS RECEIVABLE - ELGFERS AUTO SUPPLY','100349','2023-12-28 06:05:27','2023-12-28 06:05:27',NULL,70,'debit'),
(1036,13,'ACCOUNTS RECEIVABLE - EJ CONV. ','100348','2023-12-28 06:05:27','2023-12-28 06:05:27',NULL,69,'debit'),
(1035,13,'ACCOUNTS RECEIVABLE - EDUCATIONAL SUPPLY','100347','2023-12-28 06:05:27','2023-12-28 06:05:27',NULL,68,'debit'),
(1034,13,'ACCOUNTS RECEIVABLE - E & H STORE','100346','2023-12-28 06:05:27','2023-12-28 06:05:27',NULL,67,'debit'),
(1030,13,'ACCOUNTS RECEIVABLE - DISTRICT MINI MARKT.','100342','2023-12-28 06:05:27','2023-12-28 06:05:27',NULL,63,'debit'),
(1031,13,'ACCOUNTS RECEIVABLE - DOLS COMMERCIAL','100343','2023-12-28 06:05:27','2023-12-28 06:05:27',NULL,64,'debit'),
(1032,13,'ACCOUNTS RECEIVABLE - DOP COMMERCIAL','100344','2023-12-28 06:05:27','2023-12-28 06:05:27',NULL,65,'debit'),
(1033,13,'ACCOUNTS RECEIVABLE - E & H -2','100345','2023-12-28 06:05:27','2023-12-28 06:05:27',NULL,66,'debit'),
(1029,13,'ACCOUNTS RECEIVABLE - DILAO SHOPPING CENTER','100341','2023-12-28 06:05:27','2023-12-28 06:05:27',NULL,62,'debit'),
(1028,13,'ACCOUNTS RECEIVABLE - DIAMOND DRUGSTORE','100340','2023-12-28 06:05:27','2023-12-28 06:05:27',NULL,61,'debit'),
(1027,13,'ACCOUNTS RECEIVABLE - CROWN PAPER','100339','2023-12-28 06:05:27','2023-12-28 06:05:27',NULL,60,'debit'),
(1026,13,'ACCOUNTS RECEIVABLE - CITI DRUG','100338','2023-12-28 06:05:27','2023-12-28 06:05:27',NULL,59,'debit'),
(1025,13,'ACCOUNTS RECEIVABLE - CHINA COMMERCIAL','100337','2023-12-28 06:05:27','2023-12-28 06:05:27',NULL,58,'debit'),
(1024,13,'ACCOUNTS RECEIVABLE - CHARLES MINIMART- PUERTO','100336','2023-12-28 06:05:27','2023-12-28 06:05:27',NULL,57,'debit'),
(1022,13,'ACCOUNTS RECEIVABLE - CHARLES MINIMART BUGO','100334','2023-12-28 06:05:27','2023-12-28 06:05:27',NULL,55,'debit'),
(1023,13,'ACCOUNTS RECEIVABLE - CHARLES MINIMART- BUGO','100335','2023-12-28 06:05:27','2023-12-28 06:05:27',NULL,56,'debit'),
(1021,13,'ACCOUNTS RECEIVABLE - CHAM\'S CONVENIENCE (UPTOWN)','100333','2023-12-28 06:05:27','2023-12-28 06:05:27',NULL,54,'debit'),
(1018,13,'ACCOUNTS RECEIVABLE - CHAM\'S CONVENIENCE (PUEBLO)','100330','2023-12-28 06:05:27','2023-12-28 06:05:27',NULL,51,'debit'),
(1019,13,'ACCOUNTS RECEIVABLE - CHAM\'S CONVENIENCE (PUNTOD)','100331','2023-12-28 06:05:27','2023-12-28 06:05:27',NULL,52,'debit'),
(1020,13,'ACCOUNTS RECEIVABLE - CHAM\'S CONVENIENCE (REGATTA)','100332','2023-12-28 06:05:27','2023-12-28 06:05:27',NULL,53,'debit'),
(1015,13,'ACCOUNTS RECEIVABLE - CHAM\'S CONVENIENCE (NAZARETH)','100327','2023-12-28 06:05:27','2023-12-28 06:05:27',NULL,48,'debit'),
(1016,13,'ACCOUNTS RECEIVABLE - CHAM\'S CONVENIENCE (NHA)','100328','2023-12-28 06:05:27','2023-12-28 06:05:27',NULL,49,'debit'),
(1017,13,'ACCOUNTS RECEIVABLE - CHAM\'S CONVENIENCE (PATAG)','100329','2023-12-28 06:05:27','2023-12-28 06:05:27',NULL,50,'debit'),
(1014,13,'ACCOUNTS RECEIVABLE - CHAM\'S CONVENIENCE (MACASANDIG)','100326','2023-12-28 06:05:27','2023-12-28 06:05:27',NULL,47,'debit'),
(1011,13,'ACCOUNTS RECEIVABLE - CHAM\'S CONVENIENCE (KAUSWAGAN)','100323','2023-12-28 06:05:27','2023-12-28 06:05:27',NULL,44,'debit'),
(1012,13,'ACCOUNTS RECEIVABLE - CHAM\'S CONVENIENCE (KONG HUA)','100324','2023-12-28 06:05:27','2023-12-28 06:05:27',NULL,45,'debit'),
(1013,13,'ACCOUNTS RECEIVABLE - CHAM\'S CONVENIENCE (LUNA)','100325','2023-12-28 06:05:27','2023-12-28 06:05:27',NULL,46,'debit'),
(1010,13,'ACCOUNTS RECEIVABLE - CHAM\'S CONVENIENCE (IPONAN)','100322','2023-12-28 06:05:27','2023-12-28 06:05:27',NULL,43,'debit'),
(1009,13,'ACCOUNTS RECEIVABLE - CHAM\'S CONVENIENCE (ELIPE)','100321','2023-12-28 06:05:27','2023-12-28 06:05:27',NULL,42,'debit'),
(1006,13,'ACCOUNTS RECEIVABLE - CHAM\'S CONVENIENCE (CITY HALL)','100318','2023-12-28 06:05:27','2023-12-28 06:05:27',NULL,39,'debit'),
(1007,13,'ACCOUNTS RECEIVABLE - CHAM\'S CONVENIENCE (CORALES)','100319','2023-12-28 06:05:27','2023-12-28 06:05:27',NULL,40,'debit'),
(1008,13,'ACCOUNTS RECEIVABLE - CHAM\'S CONVENIENCE (DUNLOP)','100320','2023-12-28 06:05:27','2023-12-28 06:05:27',NULL,41,'debit'),
(1002,13,'ACCOUNTS RECEIVABLE - CF ELECTRICAL','100314','2023-12-28 06:05:27','2023-12-28 06:05:27',NULL,35,'debit'),
(1003,13,'ACCOUNTS RECEIVABLE - CHAM\'S CONVENIENCE (BUGO)','100315','2023-12-28 06:05:27','2023-12-28 06:05:27',NULL,36,'debit'),
(1004,13,'ACCOUNTS RECEIVABLE - CHAM\'S CONVENIENCE (CAMP.EVANG.)','100316','2023-12-28 06:05:27','2023-12-28 06:05:27',NULL,37,'debit'),
(1005,13,'ACCOUNTS RECEIVABLE - CHAM\'S CONVENIENCE (CC)','100317','2023-12-28 06:05:27','2023-12-28 06:05:27',NULL,38,'debit'),
(1001,13,'ACCOUNTS RECEIVABLE - CENTRAL CALTEX STATION','100313','2023-12-28 06:05:27','2023-12-28 06:05:27',NULL,34,'debit'),
(1000,13,'ACCOUNTS RECEIVABLE - CCH HARDWARE','100312','2023-12-28 06:05:27','2023-12-28 06:05:27',NULL,33,'debit'),
(999,13,'ACCOUNTS RECEIVABLE - CARMEN CDO MART CORP.','100311','2023-12-28 06:05:27','2023-12-28 06:05:27',NULL,32,'debit'),
(998,13,'ACCOUNTS RECEIVABLE - CANDY\'S CAFE','100310','2023-12-28 06:05:27','2023-12-28 06:05:27',NULL,31,'debit'),
(995,13,'ACCOUNTS RECEIVABLE - BOTICA PANGMASA','100307','2023-12-28 06:05:27','2023-12-28 06:05:27',NULL,28,'debit'),
(996,13,'ACCOUNTS RECEIVABLE - BS ELECTRICAL','100308','2023-12-28 06:05:27','2023-12-28 06:05:27',NULL,29,'debit'),
(997,13,'ACCOUNTS RECEIVABLE - CAGAYAN EDUCATIONAL SUPPLY','100309','2023-12-28 06:05:27','2023-12-28 06:05:27',NULL,30,'debit'),
(993,13,'ACCOUNTS RECEIVABLE - BLUE DRAGON','100305','2023-12-28 06:05:27','2023-12-28 06:05:27',NULL,26,'debit'),
(991,13,'ACCOUNTS RECEIVABLE - AYA COMMERCIAL','100303','2023-12-28 06:05:27','2023-12-28 06:05:27',NULL,24,'debit'),
(994,13,'ACCOUNTS RECEIVABLE - BLUE STAR','100306','2023-12-28 06:05:27','2023-12-28 06:05:27',NULL,27,'debit'),
(992,13,'ACCOUNTS RECEIVABLE - BAYANIHAN','100304','2023-12-28 06:05:27','2023-12-28 06:05:27',NULL,25,'debit'),
(990,13,'ACCOUNTS RECEIVABLE - ALFE COMM\'L','100302','2023-12-28 06:05:27','2023-12-28 06:05:27',NULL,23,'debit'),
(989,13,'ACCOUNTS RECEIVABLE - ACE DE ORO COMMERCIAL','100301','2023-12-28 06:05:27','2023-12-28 06:05:27',NULL,22,'debit'),
(1158,16,'DUE TO BIR - CREDITABLE WITHHOLDING TAX','200250','2024-01-05 11:21:24','2024-01-05 11:21:24',NULL,NULL,'credit'),
(1163,19,'OFFICE SUPPLIES  INVENTORY','103001','2024-01-06 09:39:33','2024-01-06 09:39:33',NULL,NULL,'Debit'),
(1164,19,'ACCOUNTABLE FORMS, PLATES AND STICKERS','103002','2024-01-06 09:39:33','2024-01-06 09:39:33',NULL,NULL,'Debit'),
(1165,19,'FUEL, OIL AND LUBRICANT INVENTORY','103003','2024-01-06 09:39:33','2024-01-06 09:39:33',NULL,NULL,'Debit'),
(1166,19,'CHEMICALS AND  FILTERING SUPPLIES INVENTORY','103004','2024-01-06 09:39:33','2024-01-06 09:39:33',NULL,NULL,'Debit'),
(1167,19,'CONSTRUCTION, MATERIALS INVENTORY','103005','2024-01-06 09:39:33','2024-01-06 09:39:33',NULL,NULL,'Debit'),
(1168,19,'OTHER SUPPLIES AND MATERIALS INVENTORY','103006','2024-01-06 09:39:33','2024-01-06 09:39:33',NULL,NULL,'Debit'),
(1169,19,'SEMI-EXPENDABLE OFFICE EQUIPMENT INVENTORY','103007','2024-01-06 09:39:33','2024-01-06 09:39:33',NULL,NULL,'Debit'),
(1170,19,'SEMI-EXPENDABLE FURNITURE AND FIXTURES  INVENTORY','103008','2024-01-06 09:39:33','2024-01-06 09:39:33',NULL,NULL,'Debit'),
(1171,20,'LANDS','104000','2024-01-06 09:41:28','2024-01-06 09:41:28',NULL,NULL,'Debit'),
(1172,21,'BUILDINGS','104010','2024-01-06 09:47:56','2024-01-06 09:47:56',NULL,NULL,'Debit'),
(1173,22,'ACCUMULATED DEPRECIATION-BUILDINGS','104011','2024-01-06 09:49:09','2024-01-06 09:49:09',NULL,NULL,'Credit'),
(1174,23,'MACHINERY','104020','2024-01-06 09:50:58','2024-01-06 09:50:58',NULL,NULL,'Debit'),
(1175,24,'ACCUMULATED DEPRECIATION-MACHINERY','104021','2024-01-06 09:51:45','2024-01-06 09:51:45',NULL,NULL,'Credit'),
(1176,25,'OFFICE EQUIPMENTS','104030','2024-01-06 09:52:22','2024-01-06 09:52:22',NULL,NULL,'Debit'),
(1177,26,'ACCUMULATED DEPRECIATION-OFFICE EQUIPMENTS','104031','2024-01-06 09:52:58','2024-01-06 09:52:58',NULL,NULL,'Credit'),
(1178,27,'INFORMATION AND COMMUNICATION TECHNOLOGY EQUIPMENT','104040','2024-01-06 09:53:43','2024-01-06 09:53:43',NULL,NULL,'Debit'),
(1179,28,'ACCUMULATED DEPRECIATION-INFORMATION AND COMMUNICATION','104041','2024-01-06 09:54:38','2024-01-06 09:54:38',NULL,NULL,'Credit'),
(1180,29,'COMMUNICATION EQUIPMENT','104050','2024-01-11 23:10:14','2024-01-11 23:10:14',NULL,NULL,'Debit'),
(1181,30,'ACCUMULATED DEPRECIATION-COMMUNICATION EQUIPMENT','104051','2024-01-11 23:11:05','2024-01-11 23:11:05',NULL,NULL,'Credit'),
(1182,31,'CONSTRUCTION AND HEAVY EQUIPMENT','104060','2024-01-11 23:12:08','2024-01-11 23:12:08',NULL,NULL,'Debit'),
(1183,32,'ACCUMULATED DEPRECIATION-CONSTRUCTION AND HEAVY EQUIPMENT','104061','2024-01-11 23:12:58','2024-01-11 23:12:58',NULL,NULL,'Credit'),
(1184,33,'DISASTER RESPONSE AND RESCUE EQUIPMENT','104070','2024-01-11 23:13:52','2024-01-11 23:13:52',NULL,NULL,'Debit'),
(1185,34,'ACCUMULATED DEPRECIATION-DISASTER RESPONSE AND RES','104071','2024-01-11 23:14:52','2024-01-11 23:14:52',NULL,NULL,'Credit'),
(1186,35,'SPORTS EQUIPMENT','104080','2024-01-11 23:15:19','2024-01-11 23:15:19',NULL,NULL,'Debit'),
(1187,36,'TECHNICAL & SCIENTIFIC  EQUIPMENT','104081','2024-01-11 23:16:00','2024-01-11 23:16:00',NULL,NULL,'Debit'),
(1188,37,'OTHER EQUIPMENT','104090','2024-01-11 23:16:42','2024-01-11 23:16:42',NULL,NULL,'Debit'),
(1189,38,'ACCUMULATED DEPRECIATION-OTHER EQUIPMENT','104091','2024-01-11 23:17:36','2024-01-11 23:17:36',NULL,NULL,'Credit'),
(1190,39,'MOTOR VEHICLES','104100','2024-01-11 23:18:15','2024-01-11 23:18:15',NULL,NULL,'Debit'),
(1191,40,'ACCUMULATED DEPRECIATION-MOTOR VEHICLES','104101','2024-01-11 23:18:41','2024-01-11 23:18:41',NULL,NULL,'Credit'),
(1192,41,'FURNITURE, FIXTURES AND BOOKS','104110','2024-01-11 23:19:20','2024-01-11 23:19:20',NULL,NULL,'Debit'),
(1193,42,'ACCUMULATED DEPRECIATION-FURNITURE, FIXTURES AND B','104111','2024-01-11 23:19:45','2024-01-11 23:19:45',NULL,NULL,'Credit'),
(1194,43,'CONSTRUCTION IN PROGRESS-INFRASTRUCTURE ASSETS','104120','2024-01-11 23:20:18','2024-01-11 23:20:18',NULL,NULL,'Debit'),
(1195,44,'CONSTRUCTION IN PROGRESS-BUILDINGS AND OTHER STRUC','104121','2024-01-11 23:20:58','2024-01-11 23:20:58',NULL,NULL,'Debit'),
(1196,45,'COMPUTER SOFTWARE','104130','2024-01-11 23:21:46','2024-01-11 23:21:46',NULL,NULL,'Debit'),
(1197,46,'ACCUMULATED DEPRECIATION-COMPUTER SOFTWARE','104131','2024-01-11 23:22:14','2024-01-11 23:22:14',NULL,NULL,'Credit'),
(1198,47,'OTHER INTANGIBLE ASSETS','104140','2024-01-11 23:22:38','2024-01-11 23:22:38',NULL,NULL,'Debit'),
(1199,48,'ACCUMULATED DEPRECIATION-OTHER INTANGIBLE ASSETS','104141','2024-01-11 23:23:41','2024-01-11 23:23:41',NULL,NULL,'Credit'),
(1200,49,'ADVANCES TO OFFICERS AND EMPLOYEES','105010','2024-01-11 23:24:19','2024-01-11 23:24:19',NULL,NULL,'Debit'),
(1201,50,'ADVANCES TO CONTRACTOR','105020','2024-01-11 23:25:10','2024-01-11 23:25:10',NULL,NULL,'Debit'),
(1202,51,'PREPAID REGISTRATION','105030','2024-01-11 23:25:51','2024-01-11 23:25:51',NULL,NULL,'Debit'),
(1203,52,'PREPAID  INSURANCE','105040','2024-01-11 23:26:27','2024-01-11 23:26:27',NULL,NULL,'Debit'),
(1204,53,'OTHER PREPAYMENTS','105050','2024-01-11 23:26:49','2024-01-11 23:26:49',NULL,NULL,'Debit'),
(1205,54,'OTHER ASSET','105060','2024-01-11 23:27:12','2024-01-11 23:27:12',NULL,NULL,'Debit'),
(1206,55,'DUE TO OFFICERS AND  EMPLOYEES - DEPOSIT','200220','2024-01-11 23:28:44','2024-01-11 23:28:44',NULL,NULL,'Credit'),
(1207,56,'LOANS PAYABLE-DOMESTIC','200230','2024-01-11 23:29:02','2024-01-11 23:29:02',NULL,NULL,'Credit'),
(1208,57,'DUE TO BIR - WITHHOLDING TAX COMPENSATION','200240','2024-01-11 23:29:41','2024-01-11 23:29:41',NULL,NULL,'Credit'),
(1209,58,'DUE TO BIR - CREDITABLE WITHHOLDING TAX','200250','2024-01-11 23:30:29','2024-01-11 23:30:29',NULL,NULL,'Credit'),
(1210,59,'DUE TO SSS - CONTRIBUTION','200260','2024-01-11 23:30:56','2024-01-11 23:30:56',NULL,NULL,'Credit'),
(1212,61,'DUE TO SSS - EMPLOYEES LOAN','200270','2024-01-11 23:32:06','2024-01-11 23:32:06',NULL,NULL,'Credit'),
(1213,62,'DUE TO PAG-IBIG - CONTRIBUTION','200280','2024-01-11 23:32:23','2024-01-11 23:32:23',NULL,NULL,'Credit'),
(1214,63,'DUE TO PAG-IBIG - EMPLOYEES LOAN','200290','2024-01-11 23:32:48','2024-01-11 23:32:48',NULL,NULL,'Credit'),
(1215,64,'DUE TO PHILHEALTH - CONTRIBUTION','200300','2024-01-11 23:33:08','2024-01-11 23:33:08',NULL,NULL,'Credit'),
(1216,65,'RETAINED EARNINGS/ (DEFICIT)','300000','2024-01-11 23:34:00','2024-01-11 23:34:00',NULL,NULL,'Credit'),
(1217,66,'SALES RETURNS AND ALLOWANCES','400107','2024-01-11 23:53:13','2024-01-11 23:53:13',NULL,NULL,'Debit'),
(1218,67,'SALES DISCOUNTS','400108','2024-01-11 23:53:40','2024-01-11 23:53:40',NULL,NULL,'Debit'),
(1219,68,'INTEREST  INCOME','400200','2024-01-11 23:54:27','2024-01-11 23:54:27',NULL,NULL,'Credit'),
(1220,69,'FINES AND PENALTIES-BUSINESS INCOME','400210','2024-01-11 23:54:56','2024-01-11 23:54:56',NULL,NULL,'Credit'),
(1221,70,'OTHER BUSINESS AND BUSINESS INCOME','400220','2024-01-11 23:55:21','2024-01-11 23:55:21',NULL,NULL,'Credit'),
(1222,71,'MISCELLANEOUS INCOME','400230','2024-01-11 23:56:04','2024-01-11 23:56:04',NULL,NULL,'Credit'),
(1223,72,'BO ALLOWANCE','400307','2024-01-11 23:56:39','2024-01-11 23:56:39',NULL,NULL,'Debit'),
(1224,73,'SALARIES AND WAGES','400401','2024-01-12 00:09:08','2024-01-12 00:09:08',NULL,NULL,'Debit'),
(1225,73,'TRANSPORTATION ALLOWANCE (TA)','400402','2024-01-12 00:09:08','2024-01-12 00:09:08',NULL,NULL,'Debit'),
(1226,73,'CLOTHING/ UNIFORM ALLOWANCE','400403','2024-01-12 00:09:08','2024-01-12 00:09:08',NULL,NULL,'Debit'),
(1227,73,'HONORARIA','400404','2024-01-12 00:09:08','2024-01-12 00:09:08',NULL,NULL,'Debit'),
(1228,73,'OVERTIME AND NIGHT PAY','400405','2024-01-12 00:09:08','2024-01-12 00:09:08',NULL,NULL,'Debit'),
(1229,73,'YEAR  END BONUS','400406','2024-01-12 00:09:08','2024-01-12 00:09:08',NULL,NULL,'Debit'),
(1230,73,'CASH GIFT','400407','2024-01-12 00:09:08','2024-01-12 00:09:08',NULL,NULL,'Debit'),
(1231,73,'OTHER BONUSES AND ALLOWANCES','400408','2024-01-12 00:09:08','2024-01-12 00:09:08',NULL,NULL,'Debit'),
(1232,73,'RETIREMENT AND LIFE INSURANCE PREMIUMS','400409','2024-01-12 00:09:08','2024-01-12 00:09:08',NULL,NULL,'Debit'),
(1233,73,'PAG-IBIG CONTRIBUTIONS','400410','2024-01-12 00:09:08','2024-01-12 00:09:08',NULL,NULL,'Debit'),
(1234,73,'PHILHEALTH CONTRIBUTIONS','400411','2024-01-12 00:09:08','2024-01-12 00:09:08',NULL,NULL,'Debit'),
(1235,73,'EMPLOYEES COMPENSATION INSURANCE PREMIUMS','400412','2024-01-12 00:09:08','2024-01-12 00:09:08',NULL,NULL,'Debit'),
(1236,73,'SSS CONTRIBUTIONS','400413','2024-01-12 00:09:08','2024-01-12 00:09:08',NULL,NULL,'Debit'),
(1237,73,'OTHER PERSONNEL BENEFITS','400414','2024-01-12 00:09:08','2024-01-12 00:09:08',NULL,NULL,'Debit'),
(1238,12,'PURCHASE DISCOUNT - GCI','400309','2024-01-12 03:40:56','2024-01-12 03:40:56',2,NULL,'Credit'),
(1239,12,'PURCHASE DISCOUNT - PFC','400310','2024-01-12 03:40:56','2024-01-12 03:40:56',3,NULL,'Credit'),
(1240,12,'PURCHASE DISCOUNT - EPI','400311','2024-01-12 03:40:56','2024-01-12 03:40:56',4,NULL,'Credit'),
(1241,12,'PURCHASE DISCOUNT - DOLE','400312','2024-01-12 03:40:56','2024-01-12 03:40:56',5,NULL,'Credit'),
(1242,12,'PURCHASE DISCOUNT - ALASKA','400313','2024-01-12 03:40:56','2024-01-12 03:40:56',6,NULL,'Credit'),
(1243,12,'PURCHASE DISCOUNT - CIFPI','400314','2024-01-12 03:40:56','2024-01-12 03:40:56',7,NULL,'Credit'),
(1244,12,'PURCHASE DISCOUNT - PPMC','400315','2024-01-12 03:40:56','2024-01-12 03:40:56',8,NULL,'Credit'),
(1245,12,'PURCHASE DISCOUNT - SUNPRIDE FOODS','400316','2024-01-12 03:40:56','2024-01-12 03:40:56',10,NULL,'Credit'),
(1246,74,'SPOILED GOODS','00000','2024-01-12 04:05:48','2024-01-12 04:05:48',NULL,NULL,'Debit'),
(1247,75,'TRAVEL EXPENSES-LOCAL','400501','2024-01-12 20:10:00','2024-01-12 20:10:00',NULL,NULL,'Debit'),
(1248,76,'TRAINING EXPENSES','400510','2024-01-12 20:10:17','2024-01-12 20:10:17',NULL,NULL,'Debit'),
(1249,77,'OFFICE SUPPLIES EXPENSE','400520','2024-01-12 20:10:35','2024-01-12 20:10:35',NULL,NULL,'Debit'),
(1250,78,'ACCOUNTABLE FORMS EXPENSES','400530','2024-01-12 20:10:57','2024-01-12 20:10:57',NULL,NULL,'Debit'),
(1251,79,'NON-ACCOUNTABLE FORMS EXPENSES','400540','2024-01-12 20:11:19','2024-01-12 20:11:19',NULL,NULL,'Debit'),
(1252,80,'DRUGS AND MEDICINES EXPENSES','400550','2024-01-12 20:11:39','2024-01-12 20:11:39',NULL,NULL,'Debit'),
(1253,81,'MEDICAL, DENTAL AND LABORATORY SUPPLIES EXPENSES','400560','2024-01-12 20:12:00','2024-01-12 20:12:00',NULL,NULL,'Debit'),
(1254,82,'FUEL, OIL AND LUBRICANTS EXPENSES','400570','2024-01-12 20:12:19','2024-01-12 20:12:19',NULL,NULL,'Debit'),
(1255,83,'SEMI-EXPENDABLE MACHINERY AND EQUIPMENT EXPENSES','400580','2024-01-12 20:12:37','2024-01-12 20:12:37',NULL,NULL,'Debit'),
(1256,84,'SEMI-EXPENDABLE FURNITURE, FIXTURES AND BOOKS EXPE','400590','2024-01-12 20:12:59','2024-01-12 20:12:59',NULL,NULL,'Debit'),
(1257,85,'OTHER SUPPLIES AND MATERIALS EXPENSES EXPENSES','400600','2024-01-12 20:13:19','2024-01-12 20:13:19',NULL,NULL,'Debit'),
(1258,86,'UTILITIES EXPENSE - ELECTRICITY','400610','2024-01-12 20:13:37','2024-01-12 20:13:37',NULL,NULL,'Debit'),
(1259,87,'UTILITIES EXPENSE - WATER UTILITIES','400611','2024-01-12 20:13:56','2024-01-12 20:13:56',NULL,NULL,'Debit'),
(1260,88,'POSTAGE AND COURIER SERVICES','400620','2024-01-12 20:14:14','2024-01-12 20:14:14',NULL,NULL,'Debit'),
(1261,89,'COMMUNICATION EXPENSES','400630','2024-01-12 20:14:33','2024-01-12 20:14:33',NULL,NULL,'Debit'),
(1262,90,'INTERNET SUBSCRIPTION EXPENSES','400640','2024-01-12 20:14:50','2024-01-12 20:14:50',NULL,NULL,'Debit'),
(1263,91,'CABLE, SATELLITE, TELEGRAPH AND RADIO  EXPENSES','400650','2024-01-12 20:15:10','2024-01-12 20:15:10',NULL,NULL,'Debit'),
(1264,92,'LEGAL SERVICES','400660','2024-01-12 20:15:26','2024-01-12 20:15:26',NULL,NULL,'Debit'),
(1265,93,'AUDITING SERVICES','400670','2024-01-12 20:15:59','2024-01-12 20:15:59',NULL,NULL,'Debit'),
(1266,94,'CONSULTANCY SERVICES','400680','2024-01-12 20:17:10','2024-01-12 20:17:10',NULL,NULL,'Debit'),
(1267,95,'OTHER PROFESSIONAL SERVICES','400690','2024-01-12 20:17:28','2024-01-12 20:17:28',NULL,NULL,'Debit'),
(1268,96,'JANITORIAL SERVICES','400700','2024-01-12 20:17:56','2024-01-12 20:17:56',NULL,NULL,'Debit'),
(1269,97,'SECURITY SERVICES','400710','2024-01-12 20:19:57','2024-01-12 20:19:57',NULL,NULL,'Debit'),
(1270,98,'REPAIRS AND MAINTENANCE-BUILDINGS AND OTHER STRUCT','400720','2024-01-12 20:20:16','2024-01-12 20:20:16',NULL,NULL,'Debit'),
(1271,99,'REPAIRS AND MAINTENANCE-MACHINERY & EQUIPMENT','400730','2024-01-12 20:20:30','2024-01-12 20:20:30',NULL,NULL,'Debit'),
(1272,100,'REPAIRS AND MAINTENANCE- TRANSPORTATION EQUIPMENT','400740','2024-01-12 20:20:46','2024-01-12 20:20:46',NULL,NULL,'Debit'),
(1273,101,'TAXES, DUTIES AND LICENSES','400750','2024-01-12 20:21:01','2024-01-12 20:21:01',NULL,NULL,'Debit'),
(1274,102,'INSURANCE EXPENSES','400760','2024-01-12 20:21:14','2024-01-12 20:21:14',NULL,NULL,'Debit'),
(1275,103,'ADVERTISING, PROMOTIONAL AND MARKETING EXPENSES','400770','2024-01-12 20:21:33','2024-01-12 20:21:33',NULL,NULL,'Debit'),
(1276,104,'PRINTING AND PUBLICATION EXPENSES','400780','2024-01-12 20:21:46','2024-01-12 20:21:46',NULL,NULL,'Debit'),
(1277,105,'TRANSPORTATION AND DELIVERY EXPENSES','400790','2024-01-12 20:22:08','2024-01-12 20:22:08',NULL,NULL,'Debit'),
(1278,106,'RENT/ LEASE EXPENSES','400800','2024-01-12 20:22:21','2024-01-12 20:22:21',NULL,NULL,'Debit'),
(1279,107,'MEMBERSHIP DUES AND CONTRIBUTIONS TO ORGANIZATIONS','400810','2024-01-12 20:35:07','2024-01-12 20:35:07',NULL,NULL,'Debit'),
(1280,108,'DONATIONS','400820','2024-01-12 20:35:27','2024-01-12 20:35:27',NULL,NULL,'Debit'),
(1281,109,'DIRECTORS AND COMMITTEE MEMBER\'S FEE','400830','2024-01-12 20:35:42','2024-01-12 20:35:42',NULL,NULL,'Debit'),
(1282,110,'MAJOR EVENTS AND CONVENTIONS EXPENSES','400840','2024-01-12 20:35:55','2024-01-12 20:35:55',NULL,NULL,'Debit'),
(1283,111,'INTEREST EXPENSES','400860','2024-01-12 20:36:12','2024-01-12 20:36:12',NULL,NULL,'Debit'),
(1284,112,'BANK CHARGES','400870','2024-01-12 20:36:25','2024-01-12 20:36:25',NULL,NULL,'Debit'),
(1285,113,'DEPRECIATION-INFRASTRUCTURE ASSETS','400901','2024-01-12 20:37:11','2024-01-12 20:37:11',NULL,NULL,'Debit'),
(1286,113,'DEPRECIATION-BUILDINGS AND OTHER STRUCTURES','400902','2024-01-12 20:37:11','2024-01-12 20:37:11',NULL,NULL,'Debit'),
(1287,113,'DEPRECIATION-MACHINERY AND EQUIPMENT','400903','2024-01-12 20:37:11','2024-01-12 20:37:11',NULL,NULL,'Debit'),
(1288,113,'DEPRECIATION-TRANSPORTATION EQUIPMENT','400904','2024-01-12 20:37:11','2024-01-12 20:37:11',NULL,NULL,'Debit'),
(1289,113,'DEPRECIATION-FURNITURE, FIXTURES AND BOOKS','400905','2024-01-12 20:37:11','2024-01-12 20:37:11',NULL,NULL,'Debit'),
(1290,114,'AMORTIZATION-INTANGIBLE ASSETS','401000','2024-01-12 20:37:33','2024-01-12 20:37:33',NULL,NULL,'Debit');

/*Table structure for table `cm_for_bo_details` */

DROP TABLE IF EXISTS `cm_for_bo_details`;

CREATE TABLE `cm_for_bo_details` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `cm_for_bo_id` bigint unsigned NOT NULL,
  `sku_id` int unsigned NOT NULL,
  `quantity` int NOT NULL,
  `price` double(15,4) NOT NULL,
  `bo_amount` double(15,4) NOT NULL,
  `remarks` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cm_for_bo_details_cm_for_bo_id_index` (`cm_for_bo_id`),
  KEY `cm_for_bo_details_sku_id_index` (`sku_id`),
  CONSTRAINT `cm_for_bo_details_cm_for_bo_id_foreign` FOREIGN KEY (`cm_for_bo_id`) REFERENCES `cm_for_bos` (`id`),
  CONSTRAINT `cm_for_bo_details_sku_id_foreign` FOREIGN KEY (`sku_id`) REFERENCES `sku_adds` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `cm_for_bo_details` */

/*Table structure for table `cm_for_bo_jers` */

DROP TABLE IF EXISTS `cm_for_bo_jers`;

CREATE TABLE `cm_for_bo_jers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `cm_for_bo_id` bigint unsigned NOT NULL,
  `sales` double(15,4) NOT NULL,
  `accounts_receivable` double(15,4) NOT NULL,
  `sales_return_and_allowances` double(15,4) NOT NULL,
  `cost_of_sales` double(15,4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cm_for_bo_jers_cm_for_bo_id_index` (`cm_for_bo_id`),
  CONSTRAINT `cm_for_bo_jers_cm_for_bo_id_foreign` FOREIGN KEY (`cm_for_bo_id`) REFERENCES `cm_for_bos` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `cm_for_bo_jers` */

/*Table structure for table `cm_for_bos` */

DROP TABLE IF EXISTS `cm_for_bos`;

CREATE TABLE `cm_for_bos` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` bigint unsigned NOT NULL,
  `total_bo_amount` double(15,4) NOT NULL,
  `personnel_id` bigint unsigned NOT NULL,
  `created_by` int NOT NULL,
  `approved_by` int NOT NULL,
  `date` date NOT NULL,
  `status` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cm_for_bos_customer_id_index` (`customer_id`),
  KEY `cm_for_bos_personnel_id_index` (`personnel_id`),
  CONSTRAINT `cm_for_bos_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`),
  CONSTRAINT `cm_for_bos_personnel_id_foreign` FOREIGN KEY (`personnel_id`) REFERENCES `personnel_adds` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `cm_for_bos` */

/*Table structure for table `cm_for_others` */

DROP TABLE IF EXISTS `cm_for_others`;

CREATE TABLE `cm_for_others` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` bigint unsigned NOT NULL,
  `personnel_id` bigint unsigned NOT NULL,
  `total_amount` double(15,4) NOT NULL,
  `date` date NOT NULL,
  `status` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `approved_by` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `transaction_remarks` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cm_for_others_customer_id_index` (`customer_id`),
  KEY `cm_for_others_personnel_id_index` (`personnel_id`),
  CONSTRAINT `cm_for_others_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`),
  CONSTRAINT `cm_for_others_personnel_id_foreign` FOREIGN KEY (`personnel_id`) REFERENCES `personnel_adds` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `cm_for_others` */

/*Table structure for table `cm_for_others_details` */

DROP TABLE IF EXISTS `cm_for_others_details`;

CREATE TABLE `cm_for_others_details` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `cm_for_others_id` bigint unsigned NOT NULL,
  `sku_id` int unsigned NOT NULL,
  `quantity` int NOT NULL,
  `price` double(15,4) NOT NULL,
  `amount` double(15,4) NOT NULL,
  `remarks` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cm_for_others_details_cm_for_others_id_index` (`cm_for_others_id`),
  KEY `cm_for_others_details_sku_id_index` (`sku_id`),
  CONSTRAINT `cm_for_others_details_cm_for_others_id_foreign` FOREIGN KEY (`cm_for_others_id`) REFERENCES `cm_for_others` (`id`),
  CONSTRAINT `cm_for_others_details_sku_id_foreign` FOREIGN KEY (`sku_id`) REFERENCES `sku_adds` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `cm_for_others_details` */

/*Table structure for table `cm_for_rgs` */

DROP TABLE IF EXISTS `cm_for_rgs`;

CREATE TABLE `cm_for_rgs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` bigint unsigned NOT NULL,
  `total_rgs_amount` double(15,4) NOT NULL,
  `personnel_id` bigint unsigned NOT NULL,
  `date` date NOT NULL,
  `created_by` int NOT NULL,
  `approved_by` int NOT NULL,
  `status` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cm_for_rgs_customer_id_index` (`customer_id`),
  KEY `cm_for_rgs_personnel_id_index` (`personnel_id`),
  CONSTRAINT `cm_for_rgs_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`),
  CONSTRAINT `cm_for_rgs_personnel_id_foreign` FOREIGN KEY (`personnel_id`) REFERENCES `personnel_adds` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `cm_for_rgs` */

/*Table structure for table `cm_for_rgs_details` */

DROP TABLE IF EXISTS `cm_for_rgs_details`;

CREATE TABLE `cm_for_rgs_details` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `cm_for_rgs_id` bigint unsigned NOT NULL,
  `sku_id` int unsigned NOT NULL,
  `quantity` int NOT NULL,
  `price` double(15,4) NOT NULL,
  `remarks` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cm_for_rgs_details_cm_for_rgs_id_index` (`cm_for_rgs_id`),
  KEY `cm_for_rgs_details_sku_id_index` (`sku_id`),
  CONSTRAINT `cm_for_rgs_details_cm_for_rgs_id_foreign` FOREIGN KEY (`cm_for_rgs_id`) REFERENCES `cm_for_rgs` (`id`),
  CONSTRAINT `cm_for_rgs_details_sku_id_foreign` FOREIGN KEY (`sku_id`) REFERENCES `sku_adds` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `cm_for_rgs_details` */

/*Table structure for table `cm_for_rgs_jers` */

DROP TABLE IF EXISTS `cm_for_rgs_jers`;

CREATE TABLE `cm_for_rgs_jers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `cm_for_rgs_id` bigint unsigned NOT NULL,
  `sales` double(15,4) NOT NULL,
  `accounts_receivable` double(15,4) NOT NULL,
  `inventory` double(15,4) NOT NULL,
  `cost_of_sales` double(15,4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cm_for_rgs_jers_cm_for_rgs_id_index` (`cm_for_rgs_id`),
  CONSTRAINT `cm_for_rgs_jers_cm_for_rgs_id_foreign` FOREIGN KEY (`cm_for_rgs_id`) REFERENCES `cm_for_rgs` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `cm_for_rgs_jers` */

/*Table structure for table `customer_category_discounts` */

DROP TABLE IF EXISTS `customer_category_discounts`;

CREATE TABLE `customer_category_discounts` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `principal_id` int unsigned NOT NULL,
  `customer_id` bigint unsigned NOT NULL,
  `category_id` int unsigned NOT NULL,
  `category_discount_rate` double(10,4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `customer_category_discounts_principal_id_index` (`principal_id`),
  KEY `customer_category_discounts_customer_id_index` (`customer_id`),
  KEY `customer_category_discounts_category_id_index` (`category_id`),
  CONSTRAINT `customer_category_discounts_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `sku_categories` (`id`),
  CONSTRAINT `customer_category_discounts_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`),
  CONSTRAINT `customer_category_discounts_principal_id_foreign` FOREIGN KEY (`principal_id`) REFERENCES `sku_principals` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `customer_category_discounts` */

/*Table structure for table `customer_discounts` */

DROP TABLE IF EXISTS `customer_discounts`;

CREATE TABLE `customer_discounts` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `principal_id` int unsigned NOT NULL,
  `customer_id` bigint unsigned NOT NULL,
  `customer_discount` double(10,4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `customer_discounts_principal_id_index` (`principal_id`),
  KEY `customer_discounts_customer_id_index` (`customer_id`),
  CONSTRAINT `customer_discounts_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`),
  CONSTRAINT `customer_discounts_principal_id_foreign` FOREIGN KEY (`principal_id`) REFERENCES `sku_principals` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `customer_discounts` */

insert  into `customer_discounts`(`id`,`principal_id`,`customer_id`,`customer_discount`,`created_at`,`updated_at`) values 
(1,7,25,1.0000,'2023-09-28 02:11:16','2023-09-28 02:11:16'),
(2,2,25,1.0000,'2023-10-02 05:04:54','2023-10-02 05:04:54'),
(3,2,25,2.0000,'2023-10-02 05:04:54','2023-10-02 05:04:54'),
(4,2,23,2.0000,'2023-10-29 21:50:21','2023-10-29 21:50:21'),
(5,2,23,1.0000,'2023-10-29 21:50:21','2023-10-29 21:50:21');

/*Table structure for table `customer_ledgers` */

DROP TABLE IF EXISTS `customer_ledgers`;

CREATE TABLE `customer_ledgers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` bigint unsigned NOT NULL,
  `customer_payment_id` bigint DEFAULT NULL,
  `van_selling_payment_id` bigint DEFAULT NULL,
  `sales_order_number` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transaction_reference` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `accounts_receivable_previous` double(15,4) DEFAULT NULL,
  `sales` double(15,4) DEFAULT NULL,
  `payment` double(15,4) DEFAULT NULL,
  `bo` double(15,4) DEFAULT NULL,
  `rgs` double(15,4) DEFAULT NULL,
  `adjustments` double(15,4) DEFAULT NULL,
  `accounts_receivable_end` double(15,4) DEFAULT NULL,
  `credit_line_amount` double DEFAULT NULL,
  `credit_line_balance` double DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `customer_ledgers_customer_id_index` (`customer_id`),
  CONSTRAINT `customer_ledgers_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `customer_ledgers` */

/*Table structure for table `customer_payment_details` */

DROP TABLE IF EXISTS `customer_payment_details`;

CREATE TABLE `customer_payment_details` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `customer_payment_id` bigint NOT NULL,
  `amount` double(15,4) NOT NULL,
  `balance` double(15,4) NOT NULL,
  `remarks` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `customer_payment_details` */

/*Table structure for table `customer_payment_jers` */

DROP TABLE IF EXISTS `customer_payment_jers`;

CREATE TABLE `customer_payment_jers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `customer_payment_id` bigint NOT NULL,
  `cash_cheque` double(15,4) NOT NULL,
  `accounts_receivable` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `customer_payment_jers` */

/*Table structure for table `customer_payments` */

DROP TABLE IF EXISTS `customer_payments`;

CREATE TABLE `customer_payments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` bigint unsigned NOT NULL,
  `cash_cheque` double(15,4) NOT NULL,
  `bank_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `cheque_number` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `cheque_date` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remitted_by` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int unsigned NOT NULL,
  `date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `customer_payments_customer_id_index` (`customer_id`),
  KEY `customer_payments_user_id_index` (`user_id`),
  CONSTRAINT `customer_payments_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`),
  CONSTRAINT `customer_payments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `customer_payments` */

/*Table structure for table `customer_principal_codes` */

DROP TABLE IF EXISTS `customer_principal_codes`;

CREATE TABLE `customer_principal_codes` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` bigint unsigned NOT NULL,
  `principal_id` int unsigned NOT NULL,
  `store_code` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `customer_principal_codes_customer_id_index` (`customer_id`),
  KEY `customer_principal_codes_principal_id_index` (`principal_id`),
  KEY `customer_principal_codes_user_id_index` (`user_id`),
  CONSTRAINT `customer_principal_codes_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`),
  CONSTRAINT `customer_principal_codes_principal_id_foreign` FOREIGN KEY (`principal_id`) REFERENCES `sku_principals` (`id`),
  CONSTRAINT `customer_principal_codes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `customer_principal_codes` */

insert  into `customer_principal_codes`(`id`,`customer_id`,`principal_id`,`store_code`,`user_id`,`created_at`,`updated_at`) values 
(1,23,2,'GCI1',1,'2023-06-08 02:15:57','2023-06-08 02:15:57'),
(2,23,3,'PFC1',1,'2023-06-08 02:15:57','2023-06-08 02:15:57'),
(3,23,4,'EPI1',1,'2023-06-08 02:15:57','2023-06-08 02:15:57'),
(4,23,5,'DOLE1',1,'2023-06-08 02:15:57','2023-06-08 02:15:57'),
(5,23,6,'ALASKA1',1,'2023-06-08 02:15:57','2023-06-08 02:15:57'),
(6,23,7,'CIFPI1',1,'2023-06-08 02:15:57','2023-06-12 16:00:27'),
(7,23,8,'PPMC1',1,'2023-06-08 02:15:57','2023-06-08 02:15:57'),
(8,23,10,'SUNPRIDE1',1,'2023-06-08 02:15:57','2023-06-08 02:15:57'),
(9,26,7,'321321',1,'2023-06-30 17:01:17','2023-06-30 17:01:17'),
(10,27,2,'321321',1,'2023-06-30 17:02:13','2023-06-30 17:02:13'),
(11,30,2,'321321',1,'2023-06-30 17:07:57','2023-06-30 17:07:57'),
(12,28,2,'321321',1,'2023-06-30 17:08:46','2023-06-30 17:08:46'),
(13,24,7,'321321',1,'2023-06-30 17:10:04','2023-06-30 17:10:04'),
(14,22,3,'321321',1,'2023-08-27 00:29:04','2023-08-27 00:29:04'),
(15,25,7,'321321',1,'2023-09-28 01:51:57','2023-09-28 01:51:57'),
(16,25,2,'GCI123123123',1,'2023-10-02 04:47:52','2023-10-02 04:47:52'),
(17,190,2,'321321',1,'2023-10-29 21:48:04','2023-10-29 21:48:04'),
(18,22,2,'55555544444',1,'2024-01-04 21:18:00','2024-01-04 21:18:00');

/*Table structure for table `customer_principal_prices` */

DROP TABLE IF EXISTS `customer_principal_prices`;

CREATE TABLE `customer_principal_prices` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` bigint unsigned NOT NULL,
  `principal_id` int unsigned NOT NULL,
  `price_level` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `customer_principal_prices_customer_id_index` (`customer_id`),
  KEY `customer_principal_prices_principal_id_index` (`principal_id`),
  KEY `customer_principal_prices_user_id_index` (`user_id`),
  CONSTRAINT `customer_principal_prices_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`),
  CONSTRAINT `customer_principal_prices_principal_id_foreign` FOREIGN KEY (`principal_id`) REFERENCES `sku_principals` (`id`),
  CONSTRAINT `customer_principal_prices_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `customer_principal_prices` */

insert  into `customer_principal_prices`(`id`,`customer_id`,`principal_id`,`price_level`,`user_id`,`created_at`,`updated_at`) values 
(1,23,2,'price_1',1,'2023-06-08 02:15:57','2023-06-08 02:15:57'),
(2,23,3,'price_1',1,'2023-06-08 02:15:57','2023-06-08 02:15:57'),
(3,23,4,'price_1',1,'2023-06-08 02:15:57','2023-06-08 02:15:57'),
(4,23,5,'price_1',1,'2023-06-08 02:15:57','2023-06-08 02:15:57'),
(5,23,6,'price_1',1,'2023-06-08 02:15:57','2023-06-08 02:15:57'),
(6,23,7,'price_1',1,'2023-06-08 02:15:57','2023-06-12 16:00:27'),
(7,23,8,'price_1',1,'2023-06-08 02:15:57','2023-06-08 02:15:57'),
(8,23,10,'price_1',1,'2023-06-08 02:15:57','2023-06-08 02:15:57'),
(9,26,7,'price_1',1,'2023-06-30 17:01:17','2023-06-30 17:01:17'),
(10,27,2,'price_1',1,'2023-06-30 17:02:13','2023-06-30 17:02:13'),
(11,30,2,'price_1',1,'2023-06-30 17:07:57','2023-06-30 17:07:57'),
(12,28,2,'price_1',1,'2023-06-30 17:08:46','2023-06-30 17:08:46'),
(13,24,7,'price_1',1,'2023-06-30 17:10:04','2023-06-30 17:10:04'),
(14,22,3,'price_1',1,'2023-08-27 00:29:04','2023-08-27 00:29:04'),
(15,25,7,'price_1',1,'2023-09-28 01:51:57','2023-09-28 01:51:57'),
(16,25,2,'price_1',1,'2023-10-02 04:47:52','2023-10-02 04:47:52'),
(17,190,2,'price_1',1,'2023-10-29 21:48:04','2023-10-29 21:48:04'),
(18,22,2,'price_1',1,'2024-01-04 21:18:00','2024-01-04 21:18:00');

/*Table structure for table `customer_uploads` */

DROP TABLE IF EXISTS `customer_uploads`;

CREATE TABLE `customer_uploads` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `export_code` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `customer_uploads` */

/*Table structure for table `customers` */

DROP TABLE IF EXISTS `customers`;

CREATE TABLE `customers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `store_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `location_id` bigint unsigned NOT NULL,
  `detailed_location` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `credit_term` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `credit_line_amount` double NOT NULL,
  `contact_person` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact_number` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `kind_of_business` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `max_number_of_transactions` int DEFAULT NULL,
  `mode_of_transaction` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `longitude` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `latitude` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `allowed_number_of_sales_order` int DEFAULT NULL,
  `location_details_id` bigint unsigned DEFAULT NULL,
  `account_number` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `customers_location_id_index` (`location_id`),
  KEY `customers_location_details_id_index` (`location_details_id`),
  CONSTRAINT `customers_location_details_id_foreign` FOREIGN KEY (`location_details_id`) REFERENCES `location_details` (`id`),
  CONSTRAINT `customers_location_id_foreign` FOREIGN KEY (`location_id`) REFERENCES `locations` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=191 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `customers` */

insert  into `customers`(`id`,`store_name`,`location_id`,`detailed_location`,`credit_term`,`credit_line_amount`,`contact_person`,`contact_number`,`kind_of_business`,`status`,`created_at`,`updated_at`,`max_number_of_transactions`,`mode_of_transaction`,`longitude`,`latitude`,`allowed_number_of_sales_order`,`location_details_id`,`account_number`) values 
(22,'ACE DE ORO COMMERCIAL',1,'COGON CAGAYAN DE ORO','15',100000000,'CHERY MAE MONARES','9169811098','SOS','Approved',NULL,'2024-01-04 21:20:02',2147483647,'COD','124.63069654484406','8.49978462505641',NULL,NULL,NULL),
(23,'ALFE COMM\'L',1,'VELEZ STREET  CAGAYAN DE ORO?.','15',100000000,'DEJAYLYN BACONAWA','9533844872','SOS','Approved',NULL,'2023-06-12 16:00:46',2147483647,'COD','124.63069654484406','8.49978462505641',NULL,NULL,NULL),
(24,'AYA COMMERCIAL',1,'JR. BORJA COGON','15',100000000,'ROCHELLE','9177011832','EGR','Approved',NULL,'2023-06-30 17:10:16',2147483647,'COD','124.63069654484406','8.49978462505641',NULL,NULL,NULL),
(25,'BAYANIHAN',1,'COGON','15',100000000,'BAYANIHAN','09533844872','HDWR','Approved',NULL,'2023-10-02 04:48:17',2147483647,'COD','124.63069654484406','8.49978462505641',NULL,NULL,NULL),
(26,'BLUE DRAGON',1,'COGON','15',100000000,'MEZIL PABAYDA','9177064131','ASU','Approved',NULL,'2023-06-30 17:01:45',2147483647,'COD','124.63069654484406','8.49978462505641',NULL,NULL,NULL),
(27,'BLUE STAR',1,'COGON','15',100000000,'WILSON GAW','9173279151','EGR','Approved',NULL,'2023-06-30 17:02:24',2147483647,'COD','124.63069654484406','8.49978462505641',NULL,NULL,NULL),
(28,'BOTICA PANGMASA',1,'R. N. PELAEZ BLVD  CDO','15',100000000,'JOHN SIDNEY SALAZAR','09533844872','MDR','Approved',NULL,'2023-06-30 17:09:38',2147483647,'COD','124.63069654484406','8.49978462505641',NULL,NULL,NULL),
(29,'BS ELECTRICAL',1,'Corner Tiano Brothers  Cruz Taal St','15',100000000,'','','HDWR','Pending Approval',NULL,NULL,2147483647,NULL,NULL,NULL,NULL,NULL,NULL),
(30,'CAGAYAN EDUCATIONAL SUPPLY',1,'COGON','15',100000000,'RECHEL ALBACINO','9177069996','QIN','Approved',NULL,'2023-06-30 17:08:11',2147483647,'COD','124.63069654484406','8.49978462505641',NULL,NULL,NULL),
(31,'CANDY\'S CAFE',1,'OSME?A  DUOL LCG','15',100000000,'','','QIN','Pending Approval',NULL,NULL,2147483647,NULL,NULL,NULL,NULL,NULL,NULL),
(32,'CARMEN CDO MART CORP.',1,'CARMEN','15',100000000,'TERESITA GOMAGON','9362567619','EGR','Pending Approval',NULL,NULL,2147483647,NULL,NULL,NULL,NULL,NULL,NULL),
(33,'CCH HARDWARE',1,'CARMEN','15',100000000,'','','HDWR','Pending Approval',NULL,NULL,2147483647,NULL,NULL,NULL,NULL,NULL,NULL),
(34,'CENTRAL CALTEX STATION',1,'VELEZ MACAHAMBUS ST. ','15',100000000,'','','QIN','Pending Approval',NULL,NULL,2147483647,NULL,NULL,NULL,NULL,NULL,NULL),
(35,'CF ELECTRICAL',1,'PATAG CDO','15',100000000,'','','HDWR','Pending Approval',NULL,NULL,2147483647,NULL,NULL,NULL,NULL,NULL,NULL),
(36,'CHAM\'S CONVENIENCE (BUGO)',1,'BUGO','15',100000000,'RENALYN','953841036','GCO','Pending Approval',NULL,NULL,2147483647,NULL,NULL,NULL,NULL,NULL,NULL),
(37,'CHAM\'S CONVENIENCE (CAMP.EVANG.)',1,'CAMP.EVANGELISTA PATAG','15',100000000,'RENALYN','953841036','GCO','Pending Approval',NULL,NULL,2147483647,NULL,NULL,NULL,NULL,NULL,NULL),
(38,'CHAM\'S CONVENIENCE (CC)',1,'CORPUS CHRISTI CDO','15',100000000,'RENALYN','953841036','GCO','Pending Approval',NULL,NULL,2147483647,NULL,NULL,NULL,NULL,NULL,NULL),
(39,'CHAM\'S CONVENIENCE (CITY HALL)',1,'CITY HALL','15',100000000,'RENALYN','953841036','GCO','Pending Approval',NULL,NULL,2147483647,NULL,NULL,NULL,NULL,NULL,NULL),
(40,'CHAM\'S CONVENIENCE (CORALES)',1,'CORALES ST','15',100000000,'RENALYN','953841036','GCO','Pending Approval',NULL,NULL,2147483647,NULL,NULL,NULL,NULL,NULL,NULL),
(41,'CHAM\'S CONVENIENCE (DUNLOP)',1,'DUNLOP PATAG','15',100000000,'RENALYN','953841036','GCO','Pending Approval',NULL,NULL,2147483647,NULL,NULL,NULL,NULL,NULL,NULL),
(42,'CHAM\'S CONVENIENCE (ELIPE)',1,'ELIPE BLD. CDO','15',100000000,'RENALYN','953841036','GCO','Pending Approval',NULL,NULL,2147483647,NULL,NULL,NULL,NULL,NULL,NULL),
(43,'CHAM\'S CONVENIENCE (IPONAN)',1,'IPONAN','15',100000000,'RENALYN','953841036','GCO','Pending Approval',NULL,NULL,2147483647,NULL,NULL,NULL,NULL,NULL,NULL),
(44,'CHAM\'S CONVENIENCE (KAUSWAGAN)',1,'KAUSWAGAN','15',100000000,'RENALYN','953841036','GCO','Pending Approval',NULL,NULL,2147483647,NULL,NULL,NULL,NULL,NULL,NULL),
(45,'CHAM\'S CONVENIENCE (KONG HUA)',1,'KONG HUA KAUSWAGAN','15',100000000,'RENALYN','953841036','GCO','Pending Approval',NULL,NULL,2147483647,NULL,NULL,NULL,NULL,NULL,NULL),
(46,'CHAM\'S CONVENIENCE (LUNA)',1,'LUNA ST.','15',100000000,'RENALYN','953841036','GCO','Pending Approval',NULL,NULL,2147483647,NULL,NULL,NULL,NULL,NULL,NULL),
(47,'CHAM\'S CONVENIENCE (MACASANDIG)',1,'MACASANDIG  CDO','15',100000000,'RENALYN','953841036','GCO','Pending Approval',NULL,NULL,2147483647,NULL,NULL,NULL,NULL,NULL,NULL),
(48,'CHAM\'S CONVENIENCE (NAZARETH)',1,'8TH-21TH ST. NAZARETH','15',100000000,'RENALYN','953841036','GCO','Pending Approval',NULL,NULL,2147483647,NULL,NULL,NULL,NULL,NULL,NULL),
(49,'CHAM\'S CONVENIENCE (NHA)',1,'NHA KAUSWAGAN','15',100000000,'RENALYN','953841036','GCO','Pending Approval',NULL,NULL,2147483647,NULL,NULL,NULL,NULL,NULL,NULL),
(50,'CHAM\'S CONVENIENCE (PATAG)',1,'PATAG CDO','15',100000000,'RENALYN','953841036','GCO','Pending Approval',NULL,NULL,2147483647,NULL,NULL,NULL,NULL,NULL,NULL),
(51,'CHAM\'S CONVENIENCE (PUEBLO)',1,'PUEBLO DE ORO','15',100000000,'RENALYN','953841036','GCO','Pending Approval',NULL,NULL,2147483647,NULL,NULL,NULL,NULL,NULL,NULL),
(52,'CHAM\'S CONVENIENCE (PUNTOD)',1,'PUNTOD','15',100000000,'RENALYN','953841036','GCO','Pending Approval',NULL,NULL,2147483647,NULL,NULL,NULL,NULL,NULL,NULL),
(53,'CHAM\'S CONVENIENCE (REGATTA)',1,'CDO-REGATTA','15',100000000,'RENALYN','953841036','GCO','Pending Approval',NULL,NULL,2147483647,NULL,NULL,NULL,NULL,NULL,NULL),
(54,'CHAM\'S CONVENIENCE (UPTOWN)',1,'UPTOWN','15',100000000,'RENALYN','953841036','GCO','Pending Approval',NULL,NULL,2147483647,NULL,NULL,NULL,NULL,NULL,NULL),
(55,'CHARLES MINIMART BUGO',1,'BUGO','15',100000000,'AYA','9278511717','EGR','Pending Approval',NULL,NULL,2147483647,NULL,NULL,NULL,NULL,NULL,NULL),
(56,'CHARLES MINIMART- BUGO',1,'BUGO','21 DAYS',100000000,'AYA','9278511717','EGR','Pending Approval',NULL,NULL,2147483647,NULL,NULL,NULL,NULL,NULL,NULL),
(57,'CHARLES MINIMART- PUERTO',1,'PUERTO','15',100000000,'GIL CHUA','742-231','EGR','Pending Approval',NULL,NULL,2147483647,NULL,NULL,NULL,NULL,NULL,NULL),
(58,'CHINA COMMERCIAL',1,'PUERTO','15',100000000,'EVANGELINE PARAN','','QIN','Pending Approval',NULL,NULL,2147483647,NULL,NULL,NULL,NULL,NULL,NULL),
(59,'CITI DRUG',1,'BULUA','15',100000000,'','','MDR','Pending Approval',NULL,NULL,2147483647,NULL,NULL,NULL,NULL,NULL,NULL),
(60,'CROWN PAPER',1,'VELEZ STREET DIVISORIA','15',100000000,'','','SOS','Pending Approval',NULL,NULL,2147483647,NULL,NULL,NULL,NULL,NULL,NULL),
(61,'DIAMOND DRUGSTORE',1,'COGON','15',100000000,'','','MDR','Pending Approval',NULL,NULL,2147483647,NULL,NULL,NULL,NULL,NULL,NULL),
(62,'DILAO SHOPPING CENTER',1,'COGON','15',100000000,'','','CDE','Pending Approval',NULL,NULL,2147483647,NULL,NULL,NULL,NULL,NULL,NULL),
(63,'DISTRICT MINI MARKT.',1,'NHA HIGHWAY','15',100000000,'','','GCO','Pending Approval',NULL,NULL,2147483647,NULL,NULL,NULL,NULL,NULL,NULL),
(64,'DOLS COMMERCIAL',1,'COGON CAGAYAN DE ORO','15',100000000,'DIANNE LOOI','9276233668','RET','Pending Approval',NULL,NULL,2147483647,NULL,NULL,NULL,NULL,NULL,NULL),
(65,'DOP COMMERCIAL',1,'COGON CAGAYAN DE ORO','15',100000000,'','','EGR','Pending Approval',NULL,NULL,2147483647,NULL,NULL,NULL,NULL,NULL,NULL),
(66,'E & H -2',1,'BUGO CDO','21 DAYS',100000000,'CHARLES CHUA','9278511717','EGR','Pending Approval',NULL,NULL,2147483647,NULL,NULL,NULL,NULL,NULL,NULL),
(67,'E & H STORE',1,'PUERTO','21 DAYS',100000000,'GIL CHUA','742231','EGR','Pending Approval',NULL,NULL,2147483647,NULL,NULL,NULL,NULL,NULL,NULL),
(68,'EDUCATIONAL SUPPLY',1,'COGON','15',100000000,'','','SOS','Pending Approval',NULL,NULL,2147483647,NULL,NULL,NULL,NULL,NULL,NULL),
(69,'EJ CONV. ',1,'LAPSAN W/ CSI','15',100000000,'','','GCO','Pending Approval',NULL,NULL,2147483647,NULL,NULL,NULL,NULL,NULL,NULL),
(70,'ELGFERS AUTO SUPPLY',1,'ATBANG SPEED AXCEL','15',100000000,'','','HDWR','Pending Approval',NULL,NULL,2147483647,NULL,NULL,NULL,NULL,NULL,NULL),
(71,'EVERBEST',1,'CDO','15',100000000,'','','KSA','Pending Approval',NULL,NULL,2147483647,NULL,NULL,NULL,NULL,NULL,NULL),
(72,'EXCEL TRADING',1,'CAPISTRANO','15',100000000,'','','HDWR','Pending Approval',NULL,NULL,2147483647,NULL,NULL,NULL,NULL,NULL,NULL),
(73,'FAT CHEF',1,'ANTONIO LUNA ST.','15',100000000,'JEIZEL','9173209764','QIN','Pending Approval',NULL,NULL,2147483647,NULL,NULL,NULL,NULL,NULL,NULL),
(74,'FB BUDGETAL CORP.',1,'CDO','15',100000000,'','','QIN','Pending Approval',NULL,NULL,2147483647,NULL,NULL,NULL,NULL,NULL,NULL),
(75,'FORTUNE ENTERPRISE',1,'CARMEN  CAGAYAN DE ORO','15',100000000,'LISA CHAN','9975699418','EGR','Pending Approval',NULL,NULL,2147483647,NULL,NULL,NULL,NULL,NULL,NULL),
(76,'GAISANO (J.R BORJA)',1,'  Jr Borja Cagayan de Oro City','15',100000000,'JO-ANN DE ASIS','9177067445','ASU','Pending Approval',NULL,NULL,2147483647,NULL,NULL,NULL,NULL,NULL,NULL),
(77,'GAISANO CAPITAL',1,'BALINGASAG','15',100000000,'MEDOLINA ECHAVEZ','9257722061','ASU','Pending Approval',NULL,NULL,2147483647,NULL,NULL,NULL,NULL,NULL,NULL),
(78,'GAISANO CITI SUPER MALL-BULUA',1,'  Zone 6 Bulua Highway ','15',100000000,'MEYSAEL MONANI','9178404667','ASU','Pending Approval',NULL,NULL,2147483647,NULL,NULL,NULL,NULL,NULL,NULL),
(79,'GAISANO CARMEN',1,'Carmen Cagayan De Oro City','15',100000000,'GIRLIE GERBOLINGO','9338655019','ASU','Pending Approval',NULL,NULL,2147483647,NULL,NULL,NULL,NULL,NULL,NULL),
(80,'GAISANO CITY-MALL',1,'C.m Recto Ave. Cor. Corrales','15',100000000,'MONETH BUENDIA','9978435477','ASU','Pending Approval',NULL,NULL,2147483647,NULL,NULL,NULL,NULL,NULL,NULL),
(81,'GAISANO MALL PUERTO',1,'  Puerto Cagayan De Oro 9000','15',100000000,'MITCHELYN BASA','9338655030','ASU','Pending Approval',NULL,NULL,2147483647,NULL,NULL,NULL,NULL,NULL,NULL),
(82,'GAISANO SUKI CLUB/NEOPACE INC.',1,'YACAPIN-DAUMAR STS.','15',100000000,'ROSELYN BASA','9175074291','ASU','Pending Approval',NULL,NULL,2147483647,NULL,NULL,NULL,NULL,NULL,NULL),
(83,'GAISANO OSME?A',1,'  Osme?a Cogon','15',100000000,'CATHY','9175074291','ASU','Pending Approval',NULL,NULL,2147483647,NULL,NULL,NULL,NULL,NULL,NULL),
(84,'GOLD CREST',1,'DIVISORIA','15',100000000,'JOY','9176344768','QIN','Pending Approval',NULL,NULL,2147483647,NULL,NULL,NULL,NULL,NULL,NULL),
(85,'GOLDEN ACE',1,'CARMEN CAGAYAN DE ORO','15',100000000,'ADING BOTALID','942860009','EGR','Pending Approval',NULL,NULL,2147483647,NULL,NULL,NULL,NULL,NULL,NULL),
(86,'GOLDEN FAMILY',1,'COGON  CAGAYAN DE ORO','15',100000000,'NEZEN PACTO','9676653865','EGR','Pending Approval',NULL,NULL,2147483647,NULL,NULL,NULL,NULL,NULL,NULL),
(87,'GRAPHICS',1,'VICENTE ROA ST. ','15',100000000,'','','QIN','Pending Approval',NULL,NULL,2147483647,NULL,NULL,NULL,NULL,NULL,NULL),
(88,'HADJI JAMILAH (STORE)',1,'OSME?A ST.','15',100000000,'GLENDA SIA','9177996310','UWH','Pending Approval',NULL,NULL,2147483647,NULL,NULL,NULL,NULL,NULL,NULL),
(89,'HADJI JAMILAH (BODEGA)',1,'LICUAN','15',100000000,'GLENDA SIA','9177199634','UWH','Pending Approval',NULL,NULL,2147483647,NULL,NULL,NULL,NULL,NULL,NULL),
(90,'HBL MARKETING (BORJA)',1,'JR BORJA','15',100000000,'','','HDWR','Pending Approval',NULL,NULL,2147483647,NULL,NULL,NULL,NULL,NULL,NULL),
(91,'HOLLYSON STORE (CARMEN)',1,'CARMEN ','15',100000000,'','9565730979','RET','Pending Approval',NULL,NULL,2147483647,NULL,NULL,NULL,NULL,NULL,NULL),
(92,'IC MKTG.',1,'DIVISORIA','15',100000000,'','','HDWR','Pending Approval',NULL,NULL,2147483647,NULL,NULL,NULL,NULL,NULL,NULL),
(93,'JIMAR CONSTRUCTION',1,'GOMEZ ST.CDO','15',100000000,'','','HDWR','Pending Approval',NULL,NULL,2147483647,NULL,NULL,NULL,NULL,NULL,NULL),
(94,'JINSING 2',1,'COGON  CAGAYAN DE ORO CITY','15',100000000,'MARGIE SUMAGAYBAY','9177711131','RET','Pending Approval',NULL,NULL,2147483647,NULL,NULL,NULL,NULL,NULL,NULL),
(95,'JINSING STORE (CUGMAN)',1,'CUGMAN','15',100000000,'MARGIE SUMAGAYBAY','9177711131','RET','Pending Approval',NULL,NULL,2147483647,NULL,NULL,NULL,NULL,NULL,NULL),
(96,'JR CLAD BUILDERS ENT.',1,'DIVISORIA','15',100000000,'','','HDWR','Pending Approval',NULL,NULL,2147483647,NULL,NULL,NULL,NULL,NULL,NULL),
(97,'JULMAR COMMERCIAL INC',1,'COGON MARKET CAGAYAN DE ORO','15',100000000,'VIVIANA','9060335375','EGR','Pending Approval',NULL,NULL,2147483647,NULL,NULL,NULL,NULL,NULL,NULL),
(98,'JVS AUDIO ',1,'LUNA W/ CSI','15',100000000,'','','QIN','Pending Approval',NULL,NULL,2147483647,NULL,NULL,NULL,NULL,NULL,NULL),
(99,'KAKING',1,'COGON','15',100000000,'','','CDE','Pending Approval',NULL,NULL,2147483647,NULL,NULL,NULL,NULL,NULL,NULL),
(100,'LG ELECTRONICS',1,'GOMEZ ST.','15',100000000,'','','QIN','Pending Approval',NULL,NULL,2147483647,NULL,NULL,NULL,NULL,NULL,NULL),
(101,'LIFE CORPS MEDCARE',1,'OLD ROAD  GUSA','15',100000000,'','','MDS','Pending Approval',NULL,NULL,2147483647,NULL,NULL,NULL,NULL,NULL,NULL),
(102,'LIONS DEN',1,'TOMA SACO 1ST ST. NAZARETH','15',100000000,'','','GYM','Pending Approval',NULL,NULL,2147483647,NULL,NULL,NULL,NULL,NULL,NULL),
(103,'LUKE MEDICAL SUPPLIES',1,'HAYES ST.','15',100000000,'','','QIN','Pending Approval',NULL,NULL,2147483647,NULL,NULL,NULL,NULL,NULL,NULL),
(104,'MARALEX PHARMACY',1,'NHA PHASE 1','15',100000000,'','','MDR','Pending Approval',NULL,NULL,2147483647,NULL,NULL,NULL,NULL,NULL,NULL),
(105,'MC ALBA FOODS CORPORATION',1,'CANITOAN  TAMBO SCION  PHASE 2','15',100000000,'','','QIN','Pending Approval',NULL,NULL,2147483647,NULL,NULL,NULL,NULL,NULL,NULL),
(106,'MED ASIA',1,'LICOAN ST. CDO','15',100000000,'','','MDR','Pending Approval',NULL,NULL,2147483647,NULL,NULL,NULL,NULL,NULL,NULL),
(107,'MERRYMART GROCERY CENTERS  INC.-BULUA',1,'BULUA','15',100000000,'JESSA TAGLINAO','9177015151','ASU','Pending Approval',NULL,NULL,2147483647,NULL,NULL,NULL,NULL,NULL,NULL),
(108,'MERRYMART GROCERY CENTERS  INC.-IPONAN',1,'IPONAN','15',100000000,'JESSA TAGLINAO','9177015151','ASU','Pending Approval',NULL,NULL,2147483647,NULL,NULL,NULL,NULL,NULL,NULL),
(109,'NORSAIDA STORE',1,'COGON','15',100000000,'','','ASU','Pending Approval',NULL,NULL,2147483647,NULL,NULL,NULL,NULL,NULL,NULL),
(110,'NORTHERN SALES',1,'J.R BORJA STREET','15',100000000,'DAISY/WILSON GAW','9193279151','ASU','Pending Approval',NULL,NULL,2147483647,NULL,NULL,NULL,NULL,NULL,NULL),
(111,'ORO REAL',1,'CARMEN','15',100000000,'','','HDWR','Pending Approval',NULL,NULL,2147483647,NULL,NULL,NULL,NULL,NULL,NULL),
(112,'ORO SOLID',1,'COGON W/ CSI','15',100000000,'','','HDWR','Pending Approval',NULL,NULL,2147483647,NULL,NULL,NULL,NULL,NULL,NULL),
(113,'ORORAMA SUPERSTORE (CARMEN)',1,'CARMEN CAGAYAN DE ORO','15',100000000,'MENCY BABA','9363965354','ASU','Pending Approval',NULL,NULL,2147483647,NULL,NULL,NULL,NULL,NULL,NULL),
(114,'ORORAMA SUPERCENTER (COGON)',1,'J.R BORJA STREET  COGON','15',100000000,'ISABEL TABUAN','9176347353','ASU','Pending Approval',NULL,NULL,2147483647,NULL,NULL,NULL,NULL,NULL,NULL),
(115,'PRINCEMIN CORPORATION (OPOL)',1,'ZONE 2  POBLACION  OPOL','15',100000000,'MARY GRACE CA?ADA','9924387917','ASU','Pending Approval',NULL,NULL,2147483647,NULL,NULL,NULL,NULL,NULL,NULL),
(116,'PROGRESS TRADING',1,'JR BORJA ST. COGON','15',100000000,'WILSON GAW','9173279151','EGR','Pending Approval',NULL,NULL,2147483647,NULL,NULL,NULL,NULL,NULL,NULL),
(117,'RASHIDA STORE (PALA?A STORE)',1,'COGON CAGAYAN DE ORO','15',100000000,'MELIE PADAYDA','9173279151','ASU','Pending Approval',NULL,NULL,2147483647,NULL,NULL,NULL,NULL,NULL,NULL),
(118,'RIKA  DRUGSTORE (PATAG)',1,'PATAG','15',100000000,'RUTCHEL','9364193500','MDR','Pending Approval',NULL,NULL,2147483647,NULL,NULL,NULL,NULL,NULL,NULL),
(119,'RIKA DRUGSTORE - CAPITOL P.',1,'PROVINCIAL CAPITOL','15',100000000,'RUTCHEL','9364193500','MDR','Pending Approval',NULL,NULL,2147483647,NULL,NULL,NULL,NULL,NULL,NULL),
(120,'RIKA DRUGSTORE - MAHOGANY',1,'MAHOGANY','15',100000000,'RUTCHEL','9364193500','MDR','Pending Approval',NULL,NULL,2147483647,NULL,NULL,NULL,NULL,NULL,NULL),
(121,'RIKA DRUGSTORE - OPOL',1,'OPOL','15',100000000,'RUTCHEL','9364193500','MDR','Pending Approval',NULL,NULL,2147483647,NULL,NULL,NULL,NULL,NULL,NULL),
(122,'RIKA DRUGSTORE (AGORA)',1,'AGORA  CDO','15',100000000,'RUTCHEL','9364193500','MDR','Pending Approval',NULL,NULL,2147483647,NULL,NULL,NULL,NULL,NULL,NULL),
(123,'RIKA DRUGSTORE (ALUBIJID)',1,'ALUBIJID','15',100000000,'RUTCHEL','9364193500','MDR','Pending Approval',NULL,NULL,2147483647,NULL,NULL,NULL,NULL,NULL,NULL),
(124,'RIKA DRUGSTORE (CARMEN MARKET)',1,'CARMEN MARKET','15',100000000,'RUTCHEL','9364193500','MDR','Pending Approval',NULL,NULL,2147483647,NULL,NULL,NULL,NULL,NULL,NULL),
(125,'RIKA DRUGSTORE (DIVISORIA)',1,'DIVISORIA TIN:464-495-972','15',100000000,'RUTCHEL','9364193500','MDR','Pending Approval',NULL,NULL,2147483647,NULL,NULL,NULL,NULL,NULL,NULL),
(126,'RIKA DRUGSTORE (GUSA)',1,'GUSA TIN:464-495-972','15',100000000,'RUTCHEL','9364193500','MDR','Pending Approval',NULL,NULL,2147483647,NULL,NULL,NULL,NULL,NULL,NULL),
(127,'RIKA DRUGSTORE (JR BORJA)',1,'JR.BORJA TIN:464-495-972','15',100000000,'RUTCHEL','9364193500','MDR','Pending Approval',NULL,NULL,2147483647,NULL,NULL,NULL,NULL,NULL,NULL),
(128,'RIKA DRUGSTORE (KAUSWAGAN)',1,'KAUSWAGAN TIN:464-495-972','15',100000000,'RUTCHEL','9364193500','MDR','Pending Approval',NULL,NULL,2147483647,NULL,NULL,NULL,NULL,NULL,NULL),
(129,'RIKA DRUGSTORE (UPTOWN)',1,'UPTOWN TIN:464-495-972','15',100000000,'RUTCHEL','9364193500','MDR','Pending Approval',NULL,NULL,2147483647,NULL,NULL,NULL,NULL,NULL,NULL),
(130,'RIKA DRUGSTORE (VELEZ)',1,'VELEZ TIN:464-495-972','15',100000000,'RUTCHEL','9364193500','MDR','Pending Approval',NULL,NULL,2147483647,NULL,NULL,NULL,NULL,NULL,NULL),
(131,'RIKA DRUGSTORE (VILLA ERNESTO)',1,'VILLA ERNESTO TIN:464-495-972','15',100000000,'RUTCHEL','9364193500','MDR','Pending Approval',NULL,NULL,2147483647,NULL,NULL,NULL,NULL,NULL,NULL),
(132,'RIKA DRUGSTORE (YACAPIN)',1,'YACAPIN ST. COGON','15',100000000,'RUTCHEL','9364193500','MDR','Pending Approval',NULL,NULL,2147483647,NULL,NULL,NULL,NULL,NULL,NULL),
(133,'RIKA DRUGSTORE -DIVISORIA',1,'BARANGAY 5   DIVISORIA','15',100000000,'RUTCHEL','9364193500','MDR','Pending Approval',NULL,NULL,2147483647,NULL,NULL,NULL,NULL,NULL,NULL),
(134,'RIKA DRUGSTORE- NERI PABAYO',1,'NERI PABAYO DIVISORIA','15',100000000,'RUTCHEL','9364193500','MDR','Pending Approval',NULL,NULL,2147483647,NULL,NULL,NULL,NULL,NULL,NULL),
(135,'RIKA DRUGSTORE- TAGOLOAN',1,'TAGOLOAN','15',100000000,'RUTCHEL','9364193500','MDR','Pending Approval',NULL,NULL,2147483647,NULL,NULL,NULL,NULL,NULL,NULL),
(136,'RIKA DRUGSTORE- VELEZ',1,'CAGAYAN DE ORO CITY','15',100000000,'RUTCHEL','9364193500','MDR','Pending Approval',NULL,NULL,2147483647,NULL,NULL,NULL,NULL,NULL,NULL),
(137,'RIKA DRUGSTORE(OSME?A)',1,'OSME?A COGON','15',100000000,'RUTCHEL','9364193500','MDR','Pending Approval',NULL,NULL,2147483647,NULL,NULL,NULL,NULL,NULL,NULL),
(138,'RIKA DRUGSTORE(PUERTO)',1,'PUERTO','15',100000000,'RUTCHEL','9364193500','MDR','Pending Approval',NULL,NULL,2147483647,NULL,NULL,NULL,NULL,NULL,NULL),
(139,'RIKA DRUGSTORE(UPTOWN CITY)',1,'PUEBLO','15',100000000,'RUTCHEL','9364193500','MDR','Pending Approval',NULL,NULL,2147483647,NULL,NULL,NULL,NULL,NULL,NULL),
(140,'RIKA DRUGSTORE-VILLA ERNESTO',1,'VILLA ERNESTO GUSA','15',100000000,'RUTCHEL','9364193500','MDR','Pending Approval',NULL,NULL,2147483647,NULL,NULL,NULL,NULL,NULL,NULL),
(141,'ROJON PHARMACY CORPORATION -CARMEN',1,'CARMEN','15',100000000,'','','MDR','Pending Approval',NULL,NULL,2147483647,NULL,NULL,NULL,NULL,NULL,NULL),
(142,'ROJON PHARMACY CORPORATION -COGON',1,'COGON','15',100000000,'','','MDR','Pending Approval',NULL,NULL,2147483647,NULL,NULL,NULL,NULL,NULL,NULL),
(143,'ROJON PHARMACY CORPORATION -OPOL',1,'OPOL','15',100000000,'','','MDR','Pending Approval',NULL,NULL,2147483647,NULL,NULL,NULL,NULL,NULL,NULL),
(144,'ROJON PHARMACY CORPORATION -PUERTO',1,'PUERTO','15',100000000,'','','MDR','Pending Approval',NULL,NULL,2147483647,NULL,NULL,NULL,NULL,NULL,NULL),
(145,'ROSE PHAR.  INC. (SHOPWISE)',1,'TIN: 000-310-457-256','15',100000000,'','','MDR','Pending Approval',NULL,NULL,2147483647,NULL,NULL,NULL,NULL,NULL,NULL),
(146,'ROSE PHAR. (GUSA WAREHOUSE)',1,'GUSA','15',100000000,'','','MDR','Pending Approval',NULL,NULL,2147483647,NULL,NULL,NULL,NULL,NULL,NULL),
(147,'ROSE PHAR. INC ( DAUMAR)',1,'DAUMAR - TIN: 000-310-457-122','15',100000000,'','','MDR','Pending Approval',NULL,NULL,2147483647,NULL,NULL,NULL,NULL,NULL,NULL),
(148,'ROSE PHAR. INC ( PUEBLO)',1,'PUEBLO - TIN: 000-310-457-238','15',100000000,'','','MDR','Pending Approval',NULL,NULL,2147483647,NULL,NULL,NULL,NULL,NULL,NULL),
(149,'ROSE PHAR. INC (GUSA)',1,'GUSA - TIN: 000-310-457-144','15',100000000,'','','MDR','Pending Approval',NULL,NULL,2147483647,NULL,NULL,NULL,NULL,NULL,NULL),
(150,'ROSE PHAR. INC (JR.BORJA)',1,'JR BORJA - TIN: 000-310-457-050','15',100000000,'','','MDR','Pending Approval',NULL,NULL,2147483647,NULL,NULL,NULL,NULL,NULL,NULL),
(151,'ROSE PHAR. INC (KAUSWAGAN)',1,'KAUSWAGAN - TIN: 000-310-457-263','15',100000000,'','','MDR','Pending Approval',NULL,NULL,2147483647,NULL,NULL,NULL,NULL,NULL,NULL),
(152,'ROSE PHAR. INC (LAPASAN)',1,'LAPASAN - TIN: 000-310-457-080','15',100000000,'','','MDR','Pending Approval',NULL,NULL,2147483647,NULL,NULL,NULL,NULL,NULL,NULL),
(153,'ROSE PHAR. INC (MACASANDIG)',1,'MACASANDIG - TIN: 000-310-457-166','15',100000000,'','','MDR','Pending Approval',NULL,NULL,2147483647,NULL,NULL,NULL,NULL,NULL,NULL),
(154,'ROSE PHAR. INC (PUERTO)',1,'PUERTO - TIN: 000-310-457-145','15',100000000,'','','MDR','Pending Approval',NULL,NULL,2147483647,NULL,NULL,NULL,NULL,NULL,NULL),
(155,'ROSE PHAR. INC. - (BULUA GAISANO)',1,'TIN: 000-310-457-215','15',100000000,'','','MDR','Pending Approval',NULL,NULL,2147483647,NULL,NULL,NULL,NULL,NULL,NULL),
(156,'ROSE PHAR. INC. ( CRUZ TAAL)',1,'TIN: 000-310-457-051','15',100000000,'','','MDR','Pending Approval',NULL,NULL,2147483647,NULL,NULL,NULL,NULL,NULL,NULL),
(157,'ROSE PHAR. INC. (CARMEN)',1,'CARMEN - TIN: 000-310-457-069','15',100000000,'','','MDR','Pending Approval',NULL,NULL,2147483647,NULL,NULL,NULL,NULL,NULL,NULL),
(158,'ROSE PHAR. INC. (GAISANO)',1,'TIN: 000-310-457-067','15',100000000,'','','MDR','Pending Approval',NULL,NULL,2147483647,NULL,NULL,NULL,NULL,NULL,NULL),
(159,'ROSE PHAR. INC. (VAMENTA)',1,'VAMENTA - TIN: 000-310-457-045','15',100000000,'','','MDR','Pending Approval',NULL,NULL,2147483647,NULL,NULL,NULL,NULL,NULL,NULL),
(160,'ROSE PHAR. INC.( ABEJUELA)',1,'ABEJUELA ST','15',100000000,'','','MDR','Pending Approval',NULL,NULL,2147483647,NULL,NULL,NULL,NULL,NULL,NULL),
(161,'ROSE PHAR. INC.(BULUA)',1,'BULUA - TIN: 000-310-457-198','15',100000000,'','','MDR','Pending Approval',NULL,NULL,2147483647,NULL,NULL,NULL,NULL,NULL,NULL),
(162,'ROSE PHAR.INC (AYALA CENTRIO)',1,'TIN:000-310-457-225','15',100000000,'','','MDR','Pending Approval',NULL,NULL,2147483647,NULL,NULL,NULL,NULL,NULL,NULL),
(163,'ROSE PHAR.INC (LIMKETKAI)',1,'TIN: 000-310-457-162','15',100000000,'','','MDR','Pending Approval',NULL,NULL,2147483647,NULL,NULL,NULL,NULL,NULL,NULL),
(164,'ROSE PHAR.INC (ORORAMA CARMEN)',1,'TIN: 000-310-457-303','15',100000000,'','','MDR','Pending Approval',NULL,NULL,2147483647,NULL,NULL,NULL,NULL,NULL,NULL),
(165,'ROSE PHAR.INC (ORORAMA COGON)',1,'TIN: 000-310-457-304','15',100000000,'','','MDR','Pending Approval',NULL,NULL,2147483647,NULL,NULL,NULL,NULL,NULL,NULL),
(166,'ROSE PHAR.INC.(AGORA)',1,'TIN: 000-310-457-194','15',100000000,'','','MDR','Pending Approval',NULL,NULL,2147483647,NULL,NULL,NULL,NULL,NULL,NULL),
(167,'ROSE PHARMACY - GAISANO BULUA 2',1,'TIN#:000-310-457-163','15',100000000,'','','MDR','Pending Approval',NULL,NULL,2147483647,NULL,NULL,NULL,NULL,NULL,NULL),
(168,'SALAHID',1,'MACASANDIG','15',100000000,'','','GCO','Pending Approval',NULL,NULL,2147483647,NULL,NULL,NULL,NULL,NULL,NULL),
(169,'SALWIN MART',1,'AGORA  CDO','15',100000000,'SHERWIN UY','9178475865','EGR','Pending Approval',NULL,NULL,2147483647,NULL,NULL,NULL,NULL,NULL,NULL),
(170,'SAVEMORE PHARMACY',1,'COGON  CDO','15',100000000,'','','MDR','Pending Approval',NULL,NULL,2147483647,NULL,NULL,NULL,NULL,NULL,NULL),
(171,'SCC',1,'PUERTO','15',100000000,'','','EGR','Pending Approval',NULL,NULL,2147483647,NULL,NULL,NULL,NULL,NULL,NULL),
(172,'SIA BON SUAN (GIFTMATE GIFTSHOP)',1,'DIVISORIA','15',100000000,'','','QIN','Pending Approval',NULL,NULL,2147483647,NULL,NULL,NULL,NULL,NULL,NULL),
(173,'SOLID SHIPPING LINES',1,'AGORA CAGAYAN DE ORO CITY','15',100000000,'','','QIN','Pending Approval',NULL,NULL,2147483647,NULL,NULL,NULL,NULL,NULL,NULL),
(174,'STRZ ELECTRONICS',1,'?Rizal St  Cagayan de Oro ','15',100000000,'','','HDWR','Pending Approval',NULL,NULL,2147483647,NULL,NULL,NULL,NULL,NULL,NULL),
(175,'SUCCESS ENTERPRISE',1,'YACAPIN EXTENSION  COGON','15',100000000,'GRACE BOOC','9177048723','EGR','Pending Approval',NULL,NULL,2147483647,NULL,NULL,NULL,NULL,NULL,NULL),
(176,'TH CAGAYAN',1,'COGON','15',100000000,'BETH','9464476955','EGR','Pending Approval',NULL,NULL,2147483647,NULL,NULL,NULL,NULL,NULL,NULL),
(177,'TRU PARTS',1,'OSME?A ST.','15',100000000,'','','HDWR','Pending Approval',NULL,NULL,2147483647,NULL,NULL,NULL,NULL,NULL,NULL),
(178,'TUNA MARKETING',1,'COGON','15',100000000,'','','HDWR','Pending Approval',NULL,NULL,2147483647,NULL,NULL,NULL,NULL,NULL,NULL),
(179,'UN ELECTRONICS',1,'VELEZ','15',100000000,'','','HDWR','Pending Approval',NULL,NULL,2147483647,NULL,NULL,NULL,NULL,NULL,NULL),
(180,'UNITOP GENERAL MERCHANDISE INC.- CARMEN',1,'  Carmen Cagayan de Oro City     TIN# 246-347-154-000','15',100000000,'','','ASU','Pending Approval',NULL,NULL,2147483647,NULL,NULL,NULL,NULL,NULL,NULL),
(181,'UNITOP GENERAL MERCHANDISE INC.-COGON',1,' Captain V.Roa St.Cogon Market TIN # 246-347-154-000','15',100000000,'','','ASU','Pending Approval',NULL,NULL,2147483647,NULL,NULL,NULL,NULL,NULL,NULL),
(182,'UNIVERSAL CAGAYAN',1,'VICENTE ROA ST.','15',100000000,'','','HDWR','Pending Approval',NULL,NULL,2147483647,NULL,NULL,NULL,NULL,NULL,NULL),
(183,'UP MARKETING',1,'LAPASAN HIGH-WAY','15',100000000,'','','HDWR','Pending Approval',NULL,NULL,2147483647,NULL,NULL,NULL,NULL,NULL,NULL),
(184,'VMED MARKETING',1,'DIVISORIA','15',100000000,'','','MDR','Pending Approval',NULL,NULL,2147483647,NULL,NULL,NULL,NULL,NULL,NULL),
(185,'WADHUS',1,'DIVISORIA','15',100000000,'','','QIN','Pending Approval',NULL,NULL,2147483647,NULL,NULL,NULL,NULL,NULL,NULL),
(186,'WESTERN ENT',1,'COGON  CAGAYAN DE ORO CITY','15',100000000,'','','ASU','Pending Approval',NULL,NULL,2147483647,NULL,NULL,NULL,NULL,NULL,NULL),
(187,'STORE',1,'PUERTO, DIVISORIA, COGON','15 days',1000000,'JOHN SIDNEY SALAZAR','09533844872','SSS','UNLOCKED','2023-06-29 10:33:29','2023-06-29 10:33:29',NULL,'COD',NULL,NULL,999999,1,NULL),
(188,'QWEQW',1,'QWEQWE','15 days',123,'EQWEQWE','09533844872','SM','UNLOCKED','2023-08-25 04:07:14','2023-08-25 04:07:14',NULL,'COD',NULL,NULL,12,1,NULL),
(189,'VAN SELLING',1,'PUERTO, DIVISORIA, COGON','15 days',123123123123,'JOHN SIDNEY SALAZAR','09533844872','VAN SELLING','UNLOCKED','2023-10-25 13:56:29','2023-10-25 13:56:29',NULL,'COD',NULL,NULL,2147483647,1,NULL),
(190,'SIDNEY SALAZAR STORE',1,'KAUSWAGAN','15',100000,'JOHN SIDNEY SALAZAR','09533844872','SSS','Approved','2023-10-30 05:44:58','2023-10-29 21:49:21',1,'COD','124.1972736','8.1035264',NULL,NULL,NULL);

/*Table structure for table `disbursement_jers` */

DROP TABLE IF EXISTS `disbursement_jers`;

CREATE TABLE `disbursement_jers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `principal_id` int unsigned DEFAULT NULL,
  `debit_record` double(15,4) NOT NULL,
  `credit_record` double(15,4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `disbursement_id` bigint unsigned DEFAULT NULL,
  `journal_entry` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `accounts_payable` double(15,4) DEFAULT NULL,
  `cash_in_bank` double(15,4) DEFAULT NULL,
  `withholding_tax` double(15,4) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `disbursement_jers_principal_id_index` (`principal_id`),
  KEY `disbursement_jers_disbursement_id_index` (`disbursement_id`),
  CONSTRAINT `disbursement_jers_disbursement_id_foreign` FOREIGN KEY (`disbursement_id`) REFERENCES `disbursements` (`id`),
  CONSTRAINT `disbursement_jers_principal_id_foreign` FOREIGN KEY (`principal_id`) REFERENCES `sku_principals` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `disbursement_jers` */

insert  into `disbursement_jers`(`id`,`principal_id`,`debit_record`,`credit_record`,`created_at`,`updated_at`,`disbursement_id`,`journal_entry`,`accounts_payable`,`cash_in_bank`,`withholding_tax`) values 
(2,2,0.0000,0.0000,'2023-11-13 14:19:09','2023-11-13 14:19:09',2,NULL,1404774.9091,1390727.1600,14047.7491);

/*Table structure for table `disbursement_others` */

DROP TABLE IF EXISTS `disbursement_others`;

CREATE TABLE `disbursement_others` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `payee` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `transaction_date` date NOT NULL,
  `invoice_number` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `check_ref` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `bank` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `transaction_date_from` date NOT NULL,
  `transaction_date_to` date NOT NULL,
  `user_id` int unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `disbursement_others_user_id_index` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `disbursement_others` */

insert  into `disbursement_others`(`id`,`payee`,`transaction_date`,`invoice_number`,`check_ref`,`description`,`bank`,`transaction_date_from`,`transaction_date_to`,`user_id`,`created_at`,`updated_at`) values 
(1,'Julmar Commercial Inc','2024-01-06','1111','2222','CASH ON HAND','CASH IN BANK - BDO','2024-01-05','2024-01-05',1,'2024-01-06 05:52:50','2024-01-06 05:52:50');

/*Table structure for table `disbursements` */

DROP TABLE IF EXISTS `disbursements`;

CREATE TABLE `disbursements` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int unsigned DEFAULT NULL,
  `disbursement` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `bank` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `check_deposit_slip` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `principal_id` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` double(15,4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `payee` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount_in_words` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `debit` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `credit` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `particulars` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cv_number` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remarks` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `po_rr_id` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount_payable` double(15,4) DEFAULT NULL,
  `transaction` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payable_amount` double(15,4) DEFAULT NULL,
  `ewt_amount` double(15,4) DEFAULT NULL,
  `net_payable` double(15,4) DEFAULT NULL,
  `amount_paid` double(15,4) DEFAULT NULL,
  `purchase_discount` decimal(15,4) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `disbursements_user_id_index` (`user_id`),
  CONSTRAINT `disbursements_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `disbursements` */

insert  into `disbursements`(`id`,`user_id`,`disbursement`,`bank`,`check_deposit_slip`,`principal_id`,`amount`,`created_at`,`updated_at`,`payee`,`amount_in_words`,`title`,`debit`,`credit`,`particulars`,`cv_number`,`remarks`,`po_rr_id`,`amount_payable`,`transaction`,`payable_amount`,`ewt_amount`,`net_payable`,`amount_paid`,`purchase_discount`) values 
(2,1,'payment to principal','BDO','10005','2',0.0000,'2023-11-13 14:19:09','2023-11-13 14:19:09',NULL,NULL,NULL,NULL,NULL,'Particulars','ref',NULL,' 1',NULL,'RR ',1404774.9122,14047.7491,1390727.1631,1390727.1600,NULL);

/*Table structure for table `driver_helper_charges` */

DROP TABLE IF EXISTS `driver_helper_charges`;

CREATE TABLE `driver_helper_charges` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `driver_helper_id` bigint unsigned NOT NULL,
  `amount` double(15,4) NOT NULL,
  `remarks` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `driver_helper_charges_driver_helper_id_index` (`driver_helper_id`),
  CONSTRAINT `driver_helper_charges_driver_helper_id_foreign` FOREIGN KEY (`driver_helper_id`) REFERENCES `driver_helpers` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `driver_helper_charges` */

/*Table structure for table `driver_helpers` */

DROP TABLE IF EXISTS `driver_helpers`;

CREATE TABLE `driver_helpers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `full_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact_number` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `full_address` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `truck_unit_number` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `work_description` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `driver_helpers_user_id_index` (`user_id`),
  CONSTRAINT `driver_helpers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `driver_helpers` */

insert  into `driver_helpers`(`id`,`full_name`,`contact_number`,`full_address`,`truck_unit_number`,`work_description`,`user_id`,`created_at`,`updated_at`,`status`) values 
(1,'TONY MANTOS','09533844872','','','DRIVER',1,'2024-01-31 08:03:49','2024-01-31 08:03:49',NULL),
(2,'HELPER 1','09533844872','','','HELPER',1,'2024-01-31 08:09:58','2024-01-31 08:09:58',NULL);

/*Table structure for table `ewt_rates` */

DROP TABLE IF EXISTS `ewt_rates`;

CREATE TABLE `ewt_rates` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int unsigned DEFAULT NULL,
  `ewt_rate` double(15,4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ewt_rates_user_id_index` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `ewt_rates` */

insert  into `ewt_rates`(`id`,`user_id`,`ewt_rate`,`created_at`,`updated_at`) values 
(1,1,1.0000,'2023-11-13 04:58:40','2023-11-13 04:58:40');

/*Table structure for table `failed_jobs` */

DROP TABLE IF EXISTS `failed_jobs`;

CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `failed_jobs` */

/*Table structure for table `general_ledgers` */

DROP TABLE IF EXISTS `general_ledgers`;

CREATE TABLE `general_ledgers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `principal_id` int unsigned DEFAULT NULL,
  `account_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `account_number` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `debit_record` decimal(15,4) NOT NULL,
  `credit_record` decimal(15,4) NOT NULL,
  `transaction_date` date DEFAULT NULL,
  `user_id` int unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `general_account_number` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `running_balance` decimal(15,4) NOT NULL,
  `transaction` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `branch` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `customer_id` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `general_ledgers_principal_id_index` (`principal_id`),
  KEY `general_ledgers_user_id_index` (`user_id`),
  KEY `general_ledgers_customer_id_index` (`customer_id`)
) ENGINE=MyISAM AUTO_INCREMENT=146 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `general_ledgers` */

insert  into `general_ledgers`(`id`,`principal_id`,`account_name`,`account_number`,`debit_record`,`credit_record`,`transaction_date`,`user_id`,`created_at`,`updated_at`,`general_account_number`,`running_balance`,`transaction`,`branch`,`customer_id`) values 
(17,2,'ACCOUNTS PAYABLE - GCI','200201',3779.3902,0.0000,'2023-12-22',1,'2023-12-23 05:35:34','2023-12-23 05:35:34','200200',34014.5114,'RETURN TO PRINCIPAL',NULL,NULL),
(18,2,'MERCHANDISE INVENTORY - GCI','102001',0.0000,3779.3902,'2023-12-22',1,'2023-12-23 05:35:34','2023-12-23 05:35:34','102000',34014.5114,'RETURN TO PRINCIPAL',NULL,NULL),
(7,2,'MERCHANDISE INVENTORY - GCI','102001',37793.9016,0.0000,'2023-12-08',1,'2023-12-23 05:16:18','2023-12-23 05:16:18','102000',37793.9016,'RECEIVED SKU',NULL,NULL),
(8,2,'ACCOUNTS PAYABLE - GCI','200201',0.0000,37793.9016,'2023-12-08',1,'2023-12-23 05:16:18','2023-12-23 05:16:18','200200',37793.9016,'RECEIVED SKU',NULL,NULL),
(27,2,'MERCHANDISE INVENTORY - GCI','102001',90.0000,0.0000,'2023-12-23',1,'2023-12-23 06:00:58','2023-12-23 06:00:58','102000',34104.5114,'BO ALLOWANCE ADJUSTMENT',NULL,NULL),
(28,2,'ACCOUNTS PAYABLE - GCI','200201',0.0000,90.0000,'2023-12-23',1,'2023-12-23 06:00:58','2023-12-23 06:00:58','200200',34104.5114,'BO ALLOWANCE ADJUSTMENT',NULL,NULL),
(32,2,'MERCHANDISE INVENTORY - GCI','102001',0.0000,90.0000,'2023-12-23',1,'2023-12-23 06:08:25','2023-12-23 06:08:25','102000',34014.5114,'BO ALLOWANCE ADJUSTMENT',NULL,NULL),
(31,2,'ACCOUNTS PAYABLE - GCI','200201',90.0000,0.0000,'2023-12-23',1,'2023-12-23 06:08:25','2023-12-23 06:08:25','200200',34014.5114,'BO ALLOWANCE ADJUSTMENT',NULL,NULL),
(43,2,'ACCOUNTS PAYABLE - GCI','200201',448.1114,0.0000,'2023-12-25',1,'2023-12-25 20:25:10','2023-12-25 20:25:10','200200',33705.7006,'INVOICE COST ADJUSTMENT',NULL,NULL),
(41,2,'MERCHANDISE INVENTORY - GCI','102001',139.3006,0.0000,'2023-12-25',1,'2023-12-25 20:24:40','2023-12-25 20:24:40','102000',34153.8120,'INVOICE COST ADJUSTMENT',NULL,NULL),
(42,2,'ACCOUNTS PAYABLE - GCI','200201',0.0000,139.3006,'2023-12-25',1,'2023-12-25 20:24:40','2023-12-25 20:24:40','200200',34153.8120,'INVOICE COST ADJUSTMENT',NULL,NULL),
(44,2,'MERCHANDISE INVENTORY - GCI','102001',0.0000,448.1114,'2023-12-25',1,'2023-12-25 20:25:10','2023-12-25 20:25:10','102000',33705.7006,'INVOICE COST ADJUSTMENT',NULL,NULL),
(45,2,'MERCHANDISE INVENTORY - GCI','102001',377939.0160,0.0000,'2023-12-27',1,'2023-12-28 04:46:33','2023-12-28 04:46:33','102000',411644.7166,'RECEIVED SKU',NULL,NULL),
(46,2,'ACCOUNTS PAYABLE - GCI','200201',0.0000,377939.0160,'2023-12-27',1,'2023-12-28 04:46:33','2023-12-28 04:46:33','200200',411644.7166,'RECEIVED SKU',NULL,NULL),
(48,2,'MERCHANDISE INVENTORY - GCI','102001',0.0000,377939.0000,'2023-12-27',1,'2023-12-28 04:58:00','2023-12-28 04:58:00','102000',33705.7166,'TRANSFER TO CARAGA','NORTH MIN',NULL),
(88,2,'MERCHANDISE INVENTORY - GCI','102001',0.0000,3310.4802,'2024-01-05',1,'2024-01-05 05:20:47','2024-01-05 05:20:47','102000',27084.7562,'SALES INVOICE',NULL,22),
(87,2,'COST OF SALES - GCI','400301',3310.4802,0.0000,'2024-01-05',1,'2024-01-05 05:20:47','2024-01-05 05:20:47','400300',6620.9604,'SALES INVOICE',NULL,22),
(86,2,'SALES - GCI','400101',0.0000,8125.0000,'2024-01-05',1,'2024-01-05 05:20:47','2024-01-05 05:20:47','400100',16007.8750,'SALES INVOICE',NULL,22),
(81,2,'ACCOUNTS RECEIVABLE - ALFE COMM\'L','100302',7882.8750,0.0000,'2024-01-05',1,'2024-01-05 05:16:32','2024-01-05 05:16:32','100300',7882.8750,'SALES INVOICE',NULL,23),
(82,2,'SALES - GCI','400101',0.0000,7882.8750,'2024-01-05',1,'2024-01-05 05:16:32','2024-01-05 05:16:32','400100',7882.8750,'SALES INVOICE',NULL,23),
(83,2,'COST OF SALES - GCI','400301',3310.4802,0.0000,'2024-01-05',1,'2024-01-05 05:16:32','2024-01-05 05:16:32','400300',3310.4802,'SALES INVOICE',NULL,23),
(84,2,'MERCHANDISE INVENTORY - GCI','102001',0.0000,3310.4802,'2024-01-05',1,'2024-01-05 05:16:32','2024-01-05 05:16:32','102000',30395.2364,'SALES INVOICE',NULL,23),
(85,2,'ACCOUNTS RECEIVABLE - ACE DE ORO COMMERCIAL','100301',8125.0000,0.0000,'2024-01-05',1,'2024-01-05 05:20:47','2024-01-05 05:20:47','100300',8125.0000,'SALES INVOICE',NULL,22),
(101,2,'DUE TO BIR - CREDITABLE WITHHOLDING TAX','200250',0.0000,3779.3902,'2024-01-05',1,'2024-01-05 19:44:36','2024-01-05 19:44:36','200250',3779.3902,'PAYMENT TO PRINCIPAL',NULL,NULL),
(95,NULL,'CASH IN BANK - BDO','100201',533.0000,0.0000,'2024-01-04',1,'2024-01-04 21:31:32','2024-01-04 21:31:32','100200',533.0000,'COLLECTION',NULL,23),
(96,NULL,'ACCOUNTS RECEIVABLE - ALFE COMM\'L','100302',0.0000,533.0000,'2024-01-04',1,'2024-01-04 21:31:32','2024-01-04 21:31:32','100300',7349.8750,'COLLECTION',NULL,23),
(97,2,'ACCOUNTS PAYABLE - GCI','200201',377939.0202,0.0000,'2024-01-05',1,'2024-01-05 19:34:10','2024-01-05 19:34:10','200200',33705.6964,'PAYMENT TO PRINCIPAL',NULL,NULL),
(100,2,'CASH IN BANK - BDO','100201',0.0000,374159.6300,'2024-01-05',1,'2024-01-05 19:41:35','2024-01-05 19:41:35','100200',-373626.6300,'PAYMENT TO PRINCIPAL',NULL,NULL),
(114,NULL,'CASH IN BANK - BDO','100201',1600.0000,0.0000,'2024-01-05',1,'2024-01-06 10:17:45','2024-01-06 10:17:45','100200',-372026.6300,'COLLECTION',NULL,23),
(115,NULL,'ACCOUNTS RECEIVABLE - ALFE COMM\'L','100302',0.0000,1600.0000,'2024-01-05',1,'2024-01-06 10:17:45','2024-01-06 10:17:45','100300',5749.8750,'COLLECTION',NULL,23),
(123,NULL,'CASH IN BANK - BDO','100201',2076.2280,0.0000,'2024-01-12',1,'2024-01-12 22:09:41','2024-01-12 22:09:41','100200',-369950.4020,'COLLECTION',NULL,23),
(124,NULL,'ACCOUNTS RECEIVABLE - ALFE COMM\'L','100302',0.0000,2076.2280,'2024-01-12',1,'2024-01-12 22:09:41','2024-01-12 22:09:41','100300',3673.6470,'COLLECTION',NULL,23),
(122,NULL,'SPOILED GOODS','00000',2076.2280,0.0000,'2024-01-12',1,'2024-01-12 22:09:41','2024-01-12 22:09:41','00000',2076.2280,'CREDIT MEMO - BO',NULL,23),
(125,NULL,'SPOILED GOODS','00000',2076.2280,0.0000,'2024-01-12',1,'2024-01-12 22:14:29','2024-01-12 22:14:29','00000',4152.4560,'CREDIT MEMO - BO',NULL,23),
(126,NULL,'CASH IN BANK - BDO','100201',2076.2280,0.0000,'2024-01-12',1,'2024-01-12 22:14:29','2024-01-12 22:14:29','100200',-367874.1740,'COLLECTION',NULL,23),
(127,NULL,'ACCOUNTS RECEIVABLE - ALFE COMM\'L','100302',0.0000,2076.2280,'2024-01-12',1,'2024-01-12 22:14:29','2024-01-12 22:14:29','100300',1597.4190,'COLLECTION',NULL,23),
(128,NULL,'CASH IN BANK - BDO','100201',300.0000,0.0000,'2024-01-15',1,'2024-01-15 08:04:52','2024-01-15 08:04:52','100200',-367574.1740,'COLLECTION',NULL,23),
(129,NULL,'ACCOUNTS RECEIVABLE - ALFE COMM\'L','100302',0.0000,300.0000,'2024-01-15',1,'2024-01-15 08:04:52','2024-01-15 08:04:52','100300',1297.4190,'COLLECTION',NULL,23),
(130,NULL,'SPOILED GOODS','00000',786.3450,0.0000,'2024-01-17',1,'2024-01-17 16:19:17','2024-01-17 16:19:17','00000',4938.8010,'CREDIT MEMO - BO',NULL,23),
(131,NULL,'ACCOUNTS RECEIVABLE - ALFE COMM\'L','100302',0.0000,786.3450,'2024-01-17',1,'2024-01-17 16:23:16','2024-01-17 16:23:16','100300',511.0740,'CREDIT MEMO - BO',NULL,23),
(135,NULL,'ACCOUNTS RECEIVABLE - ALFE COMM\'L','100302',0.0000,700.0000,'2024-01-18',1,'2024-01-18 14:10:48','2024-01-18 14:10:48','100300',-188.9260,'CREDIT MEMO - BO',NULL,23),
(134,NULL,'SPOILED GOODS','00000',700.0000,0.0000,'2024-01-18',1,'2024-01-18 14:10:48','2024-01-18 14:10:48','00000',5638.8010,'CREDIT MEMO - BO',NULL,23),
(136,NULL,'SPOILED GOODS','00000',700.0000,0.0000,'2024-01-18',1,'2024-01-18 14:16:14','2024-01-18 14:16:14','00000',6338.8010,'CREDIT MEMO - BO',NULL,23),
(137,NULL,'ACCOUNTS RECEIVABLE - ALFE COMM\'L','100302',0.0000,700.0000,'2024-01-18',1,'2024-01-18 14:16:14','2024-01-18 14:16:14','100300',-888.9260,'CREDIT MEMO - BO',NULL,23),
(138,2,'ACCOUNTS RECEIVABLE - ALFE COMM\'L','100302',7882.8750,0.0000,'2024-01-30',1,'2024-01-30 14:41:18','2024-01-30 14:41:18','100300',6993.9490,'SALES INVOICE',NULL,23),
(139,2,'SALES - GCI','400101',0.0000,7882.8750,'2024-01-30',1,'2024-01-30 14:41:18','2024-01-30 14:41:18','400100',23890.7500,'SALES INVOICE',NULL,23),
(140,2,'COST OF SALES - GCI','400301',5226.8347,0.0000,'2024-01-30',1,'2024-01-30 14:41:18','2024-01-30 14:41:18','400300',11847.7951,'SALES INVOICE',NULL,23),
(141,2,'MERCHANDISE INVENTORY - GCI','102001',0.0000,5226.8347,'2024-01-30',1,'2024-01-30 14:41:18','2024-01-30 14:41:18','102000',21857.9215,'SALES INVOICE',NULL,23),
(142,2,'ACCOUNTS RECEIVABLE - ALFE COMM\'L','100302',8775.4590,0.0000,'2024-01-30',1,'2024-01-30 15:17:14','2024-01-30 15:17:14','100300',15769.4080,'SALES INVOICE',NULL,23),
(143,2,'SALES - GCI','400101',0.0000,8775.4590,'2024-01-30',1,'2024-01-30 15:17:14','2024-01-30 15:17:14','400100',32666.2090,'SALES INVOICE',NULL,23),
(144,2,'COST OF SALES - GCI','400301',5804.6486,0.0000,'2024-01-30',1,'2024-01-30 15:17:14','2024-01-30 15:17:14','400300',17652.4437,'SALES INVOICE',NULL,23),
(145,2,'MERCHANDISE INVENTORY - GCI','102001',0.0000,5804.6486,'2024-01-30',1,'2024-01-30 15:17:14','2024-01-30 15:17:14','102000',16053.2729,'SALES INVOICE',NULL,23);

/*Table structure for table `invoice_cost_adjustment_details` */

DROP TABLE IF EXISTS `invoice_cost_adjustment_details`;

CREATE TABLE `invoice_cost_adjustment_details` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `invoice_cost_id` bigint unsigned NOT NULL,
  `sku_id` int unsigned NOT NULL,
  `adjustments` double(15,4) NOT NULL,
  `quantity` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `original_unit_cost` double(15,4) DEFAULT NULL,
  `adjusted_amount` double(15,4) DEFAULT NULL,
  `freight` double(15,4) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `invoice_cost_adjustment_details_invoice_cost_id_index` (`invoice_cost_id`),
  KEY `invoice_cost_adjustment_details_sku_id_index` (`sku_id`),
  CONSTRAINT `invoice_cost_adjustment_details_invoice_cost_id_foreign` FOREIGN KEY (`invoice_cost_id`) REFERENCES `invoice_cost_adjustments` (`id`),
  CONSTRAINT `invoice_cost_adjustment_details_sku_id_foreign` FOREIGN KEY (`sku_id`) REFERENCES `sku_adds` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `invoice_cost_adjustment_details` */

/*Table structure for table `invoice_cost_adjustments` */

DROP TABLE IF EXISTS `invoice_cost_adjustments`;

CREATE TABLE `invoice_cost_adjustments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `received_id` bigint unsigned NOT NULL,
  `particulars` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `gross_purchase` double(15,4) NOT NULL,
  `total_less_discount` double(15,4) NOT NULL,
  `bo_discount` double(15,4) NOT NULL,
  `vatable_purchase` double(15,4) NOT NULL,
  `vat` double(15,4) NOT NULL,
  `freight` double(15,4) NOT NULL,
  `total_final_cost` double(15,4) NOT NULL,
  `total_less_other_discount` double(15,4) DEFAULT NULL,
  `net_payable` double(15,4) DEFAULT NULL,
  `user_id` int unsigned DEFAULT NULL,
  `principal_id` int unsigned DEFAULT NULL,
  `cwo_discount` double(15,4) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `invoice_cost_adjustments_received_id_index` (`received_id`),
  KEY `invoice_cost_adjustments_user_id_index` (`user_id`),
  KEY `invoice_cost_adjustments_principal_id_index` (`principal_id`),
  CONSTRAINT `invoice_cost_adjustments_principal_id_foreign` FOREIGN KEY (`principal_id`) REFERENCES `sku_principals` (`id`),
  CONSTRAINT `invoice_cost_adjustments_received_id_foreign` FOREIGN KEY (`received_id`) REFERENCES `received_purchase_orders` (`id`),
  CONSTRAINT `invoice_cost_adjustments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `invoice_cost_adjustments` */

/*Table structure for table `invoice_cost_adjustments_jers` */

DROP TABLE IF EXISTS `invoice_cost_adjustments_jers`;

CREATE TABLE `invoice_cost_adjustments_jers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `invoice_cost_id` bigint unsigned NOT NULL,
  `dr` double(15,4) NOT NULL,
  `cr` double(15,4) NOT NULL,
  `date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `invoice_cost_adjustments_jers_invoice_cost_id_index` (`invoice_cost_id`),
  KEY `invoice_cost_adjustments_jers_date_index` (`date`),
  CONSTRAINT `invoice_cost_adjustments_jers_invoice_cost_id_foreign` FOREIGN KEY (`invoice_cost_id`) REFERENCES `invoice_cost_adjustments` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `invoice_cost_adjustments_jers` */

/*Table structure for table `invoice_draft_details` */

DROP TABLE IF EXISTS `invoice_draft_details`;

CREATE TABLE `invoice_draft_details` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `invoice_draft_id` bigint unsigned DEFAULT NULL,
  `sku_id` int unsigned DEFAULT NULL,
  `unit_price` double(15,4) NOT NULL,
  `line_discount` double(15,4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `quantity` int NOT NULL,
  `quantity_out` int DEFAULT NULL,
  `scanned_remarks` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `invoice_draft_details_invoice_draft_id_index` (`invoice_draft_id`),
  KEY `invoice_draft_details_sku_id_index` (`sku_id`),
  CONSTRAINT `invoice_draft_details_invoice_draft_id_foreign` FOREIGN KEY (`invoice_draft_id`) REFERENCES `invoice_drafts` (`id`),
  CONSTRAINT `invoice_draft_details_sku_id_foreign` FOREIGN KEY (`sku_id`) REFERENCES `sku_adds` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `invoice_draft_details` */

/*Table structure for table `invoice_drafts` */

DROP TABLE IF EXISTS `invoice_drafts`;

CREATE TABLE `invoice_drafts` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `agent` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `principal_id` int unsigned DEFAULT NULL,
  `customer_id` bigint unsigned DEFAULT NULL,
  `user_id` int unsigned DEFAULT NULL,
  `mode_of_transaction` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sku_type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `other_discount` double(15,4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `total_amount` double(15,4) NOT NULL,
  `delivery_receipt` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `scanned_by` int DEFAULT NULL,
  `status` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `invoice_drafts_principal_id_index` (`principal_id`),
  KEY `invoice_drafts_customer_id_index` (`customer_id`),
  KEY `invoice_drafts_user_id_index` (`user_id`),
  KEY `invoice_drafts_scanned_by_index` (`scanned_by`),
  CONSTRAINT `invoice_drafts_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`),
  CONSTRAINT `invoice_drafts_principal_id_foreign` FOREIGN KEY (`principal_id`) REFERENCES `sku_principals` (`id`),
  CONSTRAINT `invoice_drafts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `invoice_drafts` */

/*Table structure for table `invoice_raws` */

DROP TABLE IF EXISTS `invoice_raws`;

CREATE TABLE `invoice_raws` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `invoice_data` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `delivery_receipt` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sales_representative` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sku_code` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `customer` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sku_type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `principal` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remarks` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `barcode` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `release_date` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `final_quantity` int DEFAULT NULL,
  `sku_id` int DEFAULT NULL,
  `rgs` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bo` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `unit_price` double(15,4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `invoice_raws` */

/*Table structure for table `load_sheet_details` */

DROP TABLE IF EXISTS `load_sheet_details`;

CREATE TABLE `load_sheet_details` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `load_sheet_id` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sku_id` int unsigned NOT NULL,
  `quantity` int NOT NULL,
  `unit_price` double(15,4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `load_sheet_details_sku_id_index` (`sku_id`),
  CONSTRAINT `load_sheet_details_sku_id_foreign` FOREIGN KEY (`sku_id`) REFERENCES `sku_adds` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `load_sheet_details` */

/*Table structure for table `load_sheets` */

DROP TABLE IF EXISTS `load_sheets`;

CREATE TABLE `load_sheets` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `load_sheet_id` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `agent` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `customer` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `customer_id` bigint unsigned DEFAULT NULL,
  `agent_id` bigint unsigned DEFAULT NULL,
  `user_id` int unsigned DEFAULT NULL,
  `principal_id` int unsigned DEFAULT NULL,
  `status` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `load_sheets_customer_id_index` (`customer_id`),
  KEY `load_sheets_agent_id_index` (`agent_id`),
  KEY `load_sheets_user_id_index` (`user_id`),
  KEY `load_sheets_principal_id_index` (`principal_id`),
  CONSTRAINT `load_sheets_agent_id_foreign` FOREIGN KEY (`agent_id`) REFERENCES `agents` (`id`),
  CONSTRAINT `load_sheets_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`),
  CONSTRAINT `load_sheets_principal_id_foreign` FOREIGN KEY (`principal_id`) REFERENCES `sku_principals` (`id`),
  CONSTRAINT `load_sheets_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `load_sheets` */

/*Table structure for table `location_details` */

DROP TABLE IF EXISTS `location_details`;

CREATE TABLE `location_details` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `location_id` bigint unsigned NOT NULL,
  `barangay` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `street` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `location_details_location_id_index` (`location_id`),
  CONSTRAINT `location_details_location_id_foreign` FOREIGN KEY (`location_id`) REFERENCES `locations` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `location_details` */

insert  into `location_details`(`id`,`location_id`,`barangay`,`street`,`created_at`,`updated_at`) values 
(1,1,'VILLANUEVA','none','2023-06-27 20:55:31','2023-06-27 20:55:31');

/*Table structure for table `locations` */

DROP TABLE IF EXISTS `locations`;

CREATE TABLE `locations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `location` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `detailed_location` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `locations` */

insert  into `locations`(`id`,`location`,`created_at`,`updated_at`,`detailed_location`) values 
(1,'MAS1','2023-06-26 03:54:29','2023-06-26 03:54:29','VILLANUEVA');

/*Table structure for table `logistics` */

DROP TABLE IF EXISTS `logistics`;

CREATE TABLE `logistics` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `truck_id` bigint unsigned DEFAULT NULL,
  `driver` int NOT NULL,
  `contact_number` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `helper_1` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `helper_2` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_outlet` int NOT NULL,
  `loading_date` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `loading_date_updated_by` int unsigned DEFAULT NULL,
  `departure_date` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `departure_date_updated_by` int unsigned DEFAULT NULL,
  `arrival_date` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `arrival_date_updated_by` int unsigned DEFAULT NULL,
  `sg_departure_noted_by` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sg_arrival_noted_by` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fuel_given_amount` double(15,4) DEFAULT NULL,
  `remarks` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` int unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `trucking_company` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `number_of_invoices` int DEFAULT NULL,
  `location_id` bigint unsigned DEFAULT NULL,
  `total_expense` double(15,4) DEFAULT NULL,
  `total_expense_updated_by` int unsigned DEFAULT NULL,
  `status` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fuel_given_updated_by` int unsigned DEFAULT NULL,
  `controler` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `control` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `logistics_truck_id_index` (`truck_id`),
  KEY `logistics_loading_date_updated_by_index` (`loading_date_updated_by`),
  KEY `logistics_departure_date_updated_by_index` (`departure_date_updated_by`),
  KEY `logistics_arrival_date_updated_by_index` (`arrival_date_updated_by`),
  KEY `logistics_user_id_index` (`user_id`),
  KEY `logistics_location_id_index` (`location_id`),
  KEY `logistics_total_expense_updated_by_index` (`total_expense_updated_by`),
  KEY `logistics_fuel_given_updated_by_index` (`fuel_given_updated_by`),
  CONSTRAINT `logistics_arrival_date_updated_by_foreign` FOREIGN KEY (`arrival_date_updated_by`) REFERENCES `users` (`id`),
  CONSTRAINT `logistics_departure_date_updated_by_foreign` FOREIGN KEY (`departure_date_updated_by`) REFERENCES `users` (`id`),
  CONSTRAINT `logistics_fuel_given_updated_by_foreign` FOREIGN KEY (`fuel_given_updated_by`) REFERENCES `users` (`id`),
  CONSTRAINT `logistics_loading_date_updated_by_foreign` FOREIGN KEY (`loading_date_updated_by`) REFERENCES `users` (`id`),
  CONSTRAINT `logistics_location_id_foreign` FOREIGN KEY (`location_id`) REFERENCES `locations` (`id`),
  CONSTRAINT `logistics_total_expense_updated_by_foreign` FOREIGN KEY (`total_expense_updated_by`) REFERENCES `users` (`id`),
  CONSTRAINT `logistics_truck_id_foreign` FOREIGN KEY (`truck_id`) REFERENCES `trucks` (`id`),
  CONSTRAINT `logistics_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `logistics` */

insert  into `logistics`(`id`,`truck_id`,`driver`,`contact_number`,`helper_1`,`helper_2`,`total_outlet`,`loading_date`,`loading_date_updated_by`,`departure_date`,`departure_date_updated_by`,`arrival_date`,`arrival_date_updated_by`,`sg_departure_noted_by`,`sg_arrival_noted_by`,`fuel_given_amount`,`remarks`,`user_id`,`created_at`,`updated_at`,`trucking_company`,`number_of_invoices`,`location_id`,`total_expense`,`total_expense_updated_by`,`status`,`fuel_given_updated_by`,`controler`,`control`) values 
(1,1,1,'09533844872','HELPER 1','HELPER 2',1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'2024-01-31 16:28:09','2024-02-05 15:32:26','JULMAR',2,1,NULL,NULL,NULL,NULL,'dfsdfsdf','printed');

/*Table structure for table `logistics_details` */

DROP TABLE IF EXISTS `logistics_details`;

CREATE TABLE `logistics_details` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `logistics_id` bigint unsigned DEFAULT NULL,
  `principal_id` int unsigned DEFAULT NULL,
  `case` double(15,4) NOT NULL,
  `butal` double(15,4) NOT NULL,
  `conversion` double(15,4) NOT NULL,
  `amount` double(15,4) NOT NULL,
  `percentage` double(15,4) NOT NULL,
  `equivalent` double(15,4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `weight` double(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `logistics_details_logistics_id_index` (`logistics_id`),
  KEY `logistics_details_principal_id_index` (`principal_id`),
  CONSTRAINT `logistics_details_logistics_id_foreign` FOREIGN KEY (`logistics_id`) REFERENCES `logistics` (`id`),
  CONSTRAINT `logistics_details_principal_id_foreign` FOREIGN KEY (`principal_id`) REFERENCES `sku_principals` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `logistics_details` */

insert  into `logistics_details`(`id`,`logistics_id`,`principal_id`,`case`,`butal`,`conversion`,`amount`,`percentage`,`equivalent`,`created_at`,`updated_at`,`weight`) values 
(1,1,2,40.0000,0.0000,0.0000,15765.7500,1.0000,0.0000,'2024-01-31 16:28:09','2024-01-31 16:28:09',29.00);

/*Table structure for table `logistics_invoices` */

DROP TABLE IF EXISTS `logistics_invoices`;

CREATE TABLE `logistics_invoices` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `logistics_id` bigint unsigned DEFAULT NULL,
  `sales_invoice_id` bigint unsigned DEFAULT NULL,
  `principal_id` int unsigned DEFAULT NULL,
  `case` double(15,4) NOT NULL,
  `butal` double(15,4) NOT NULL,
  `conversion` double(15,4) NOT NULL,
  `amount` double(15,4) NOT NULL,
  `percentage` double(15,4) NOT NULL,
  `equivalent` double(15,4) DEFAULT NULL,
  `weight` double(15,4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `delivered_date` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `logistics_invoices_logistics_id_index` (`logistics_id`),
  KEY `logistics_invoices_sales_invoice_id_index` (`sales_invoice_id`),
  KEY `logistics_invoices_principal_id_index` (`principal_id`),
  CONSTRAINT `logistics_invoices_logistics_id_foreign` FOREIGN KEY (`logistics_id`) REFERENCES `logistics` (`id`),
  CONSTRAINT `logistics_invoices_principal_id_foreign` FOREIGN KEY (`principal_id`) REFERENCES `sku_principals` (`id`),
  CONSTRAINT `logistics_invoices_sales_invoice_id_foreign` FOREIGN KEY (`sales_invoice_id`) REFERENCES `sales_invoices` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `logistics_invoices` */

insert  into `logistics_invoices`(`id`,`logistics_id`,`sales_invoice_id`,`principal_id`,`case`,`butal`,`conversion`,`amount`,`percentage`,`equivalent`,`weight`,`created_at`,`updated_at`,`delivered_date`) values 
(1,1,1,2,20.0000,0.0000,0.0000,7882.8750,0.0000,0.0000,14.5000,'2024-01-31 16:28:09','2024-01-31 16:28:09',NULL),
(2,1,2,2,20.0000,0.0000,0.0000,7882.8750,0.0000,0.0000,14.5000,'2024-01-31 16:28:09','2024-01-31 16:28:09',NULL);

/*Table structure for table `migrations` */

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=348 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `migrations` */

insert  into `migrations`(`id`,`migration`,`batch`) values 
(1,'2014_10_12_000000_create_users_table',1),
(2,'2014_10_12_100000_create_password_resets_table',1),
(3,'2019_08_19_000000_create_failed_jobs_table',1),
(4,'2020_02_19_062751_create_sku_categories_table',1),
(5,'2020_02_19_062806_create_sku_principals_table',1),
(6,'2020_02_20_060400_create_sku_price_details_table',1),
(7,'2020_02_21_095810_create_sku_adds_table',1),
(8,'2020_02_21_121049_create_purchase_orders_table',1),
(9,'2020_02_21_121158_create_purchase_order_details_table',1),
(10,'2020_02_29_065540_create_personnel_descriptions_table',1),
(12,'2020_03_04_024345_create_sku_add_details_table',1),
(13,'2020_03_04_024527_create_received_jers_table',1),
(14,'2020_03_05_060909_create_sku_ledgers_table',1),
(15,'2020_03_10_054220_create_return_to_principals_table',1),
(16,'2020_03_10_054819_create_return_to_principal_details_table',1),
(17,'2020_03_11_064633_create_bo_allowance_adjustments_table',1),
(18,'2020_03_11_075746_create_bo_allowance_adjustments_details_table',1),
(19,'2020_03_11_081040_create_bo_allowance_adjustments_jers_table',1),
(20,'2020_03_12_035653_create_return_to_principal_jers_table',1),
(21,'2020_03_12_134358_create_invoice_cost_adjustments_table',1),
(22,'2020_03_12_140415_create_invoice_cost_adjustment_details_table',1),
(23,'2020_03_12_143225_create_invoice_cost_adjustments_jers_table',1),
(24,'2020_03_13_035028_create_bodega_outs_table',1),
(25,'2020_03_13_035058_create_bodega_out_details_table',1),
(26,'2020_03_28_033525_create_transfer_to_brans_table',1),
(27,'2020_03_28_033626_create_transfer_to_bran_details_table',1),
(28,'2020_08_07_021756_create_locations_table',1),
(29,'2020_08_08_025230_create_location_details_table',1),
(30,'2020_08_12_021740_create_personnel_adds_table',1),
(31,'2020_08_12_065039_create_personnel_add_details_table',1),
(32,'2020_08_25_052339_create_customers_table',1),
(33,'2020_08_25_070935_create_customer_discounts_table',1),
(34,'2020_09_07_010245_create_principal_discounts_table',1),
(35,'2020_09_07_010302_create_principal_discount_details_table',1),
(36,'2020_09_20_034340_create_customer_ledgers_table',1),
(37,'2020_09_25_004200_create_customer_category_discounts_table',1),
(38,'2020_11_25_020538_create_customer_payment_details_table',1),
(39,'2020_11_25_020547_create_customer_payment_jers_table',1),
(40,'2020_11_25_033250_create_customer_payments_table',1),
(41,'2020_11_25_072215_create_cm_for_bos_table',1),
(42,'2020_11_25_072224_create_cm_for_bo_details_table',1),
(43,'2020_11_25_072238_create_cm_for_bo_jers_table',1),
(44,'2020_11_26_062116_create_cm_for_rgs_table',1),
(45,'2020_11_26_062130_create_cm_for_rgs_details_table',1),
(46,'2020_11_26_062143_create_cm_for_rgs_jers_table',1),
(47,'2020_11_28_051243_create_transfer_to_branch_jers_table',1),
(48,'2020_12_29_011608_create_cm_for_others_table',1),
(49,'2020_12_29_013433_create_cm_for_others_details_table',1),
(50,'2021_01_25_021506_create_principal_ledgers_table',1),
(51,'2021_01_25_053451_create_principal_payments_table',1),
(52,'2021_02_12_020656_create_van_selling_ledger_models_table',1),
(53,'2021_02_19_023407_create_van_selling_printeds_table',1),
(54,'2021_02_19_023417_create_van_selling_printed_details_table',1),
(55,'2021_02_23_023711_create_customer_principal_prices_table',1),
(56,'2021_02_23_030835_create_driver_helpers_table',1),
(57,'2021_02_23_030846_create_driver_helper_charges_table',1),
(58,'2021_02_23_034128_create_agents_table',1),
(59,'2021_02_23_034821_create_agent_principals_table',1),
(60,'2021_02_23_131018_create_agent_applied_customers_table',1),
(61,'2021_03_16_014133_create_customer_principal_codes_table',1),
(62,'2021_05_06_025004_create_van_selling_uploads_table',1),
(63,'2021_05_20_005556_create_van_selling_upload_ledgers_table',1),
(64,'2021_05_28_061032_create_van_selling_payments_table',1),
(65,'2021_05_28_064043_create_van_selling_payment_details_table',1),
(66,'2021_05_30_074929_create_pcm_uploads_table',1),
(67,'2021_06_02_013401_create_pcm_upload_details_table',1),
(68,'2021_07_01_073723_create_ar_ledgers_table',1),
(69,'2021_07_10_025944_create_van_selling_ar_ledgers_table',1),
(70,'2021_07_14_064423_create_pcm_upload_vs_table',1),
(71,'2021_07_14_065527_create_pcm_upload_vs_details_table',1),
(72,'2021_08_12_050231_create_van_selling_adjustments_table',1),
(73,'2021_08_12_050545_create_van_selling_adjustments_details_table',1),
(74,'2021_09_27_090846_create_van_selling_pcms_table',1),
(75,'2021_09_27_090856_create_van_selling_pcm_details_table',1),
(76,'2021_10_07_073138_create_van_selling_price_differences_table',1),
(77,'2021_10_07_073147_create_van_selling_price_difference_details_table',1),
(78,'2021_10_17_080928_create_van_selling_inventory_adjustments_table',1),
(79,'2021_10_17_081818_create_van_selling_inventory_adjustments_details_table',1),
(80,'2021_10_25_113850_create_van_selling_inventory_clearings_table',1),
(81,'2022_02_24_131431_create_van_selling_sales_table',1),
(82,'2022_02_28_114949_create_van_selling_beginnings_table',1),
(83,'2022_03_10_103822_add_remarks_to_table_van_selling_ar_ledger',1),
(84,'2022_03_11_122703_create_van_selling_transfer_inventories_table',1),
(85,'2022_03_11_122807_create_van_selling_transfer_inventory_details_table',1),
(86,'2022_03_11_152658_add_column_to_van_selling_transfer',1),
(87,'2022_03_29_135216_add_column_to_table_pcm',1),
(88,'2022_03_29_135441_add_column_to_table_pcm_details',1),
(89,'2022_04_09_113032_add_column_outstanding_balance_to_table_van_selling_ar_ledger',1),
(90,'2022_04_30_125633_add_column_to_table_inventory_adjustments_details',1),
(91,'2022_07_29_190004_create_customer_uploads_table',1),
(92,'2022_08_04_123829_create_sales_order_drafts_table',1),
(93,'2022_08_04_124930_create_sales_order_draft_details_table',1),
(94,'2022_08_04_125258_add_status_sales_order_draft',1),
(95,'2022_08_05_122342_create_sales_invoices_table',1),
(96,'2022_08_05_125820_add_total_sales_invoice',1),
(97,'2022_08_05_130545_add_sales_invoice_status',1),
(98,'2022_08_05_130721_add_sales_invoice_cancelled_date',1),
(99,'2022_08_05_132142_create_sales_invoice_details_table',1),
(100,'2022_08_05_132856_add_sales_invoice_id_on_details',1),
(101,'2022_08_08_115823_add_weight_to_sales_invoice',1),
(102,'2022_08_08_115957_add_separated_weight_to_sku_add',1),
(103,'2022_08_08_123835_add_logistic_status_to_sales_invoice',1),
(104,'2022_08_10_101632_add_control_to_sales_invoices',1),
(105,'2022_08_10_102713_add_column_sales_invoices_printed',1),
(106,'2022_08_10_113027_add_total_amount_per_sku_to_sales_invoice_details',1),
(107,'2022_08_10_132305_add_customer_discount_column_to_sales_invoice',1),
(108,'2022_08_10_224454_create_trucks_table',1),
(109,'2022_08_10_225555_add_2_columns_to_sales_invoice',1),
(110,'2022_08_11_115109_create_sales_invoice_status_logs_table',1),
(111,'2022_08_11_120944_add_no_of_days_to_invoice_logs',1),
(112,'2022_08_11_122153_add_date_delivered_sales_invoice',1),
(113,'2022_08_11_124859_add_truck_status',1),
(114,'2022_08_11_130304_create_truck_and_sales_invoices_table',1),
(115,'2022_08_11_130648_create_truck_and_sales_invoice_details_table',1),
(116,'2022_08_11_130813_add_user_id_to_sales_invoice_status_logs',1),
(117,'2022_08_12_063215_add_columns_to_truck_and_sales_invoice',1),
(118,'2022_08_12_231204_add_column_to_customer_table',1),
(119,'2022_08_12_231405_add_coordinates_to_customer',1),
(120,'2022_11_02_124457_create_van_selling_customers_table',1),
(121,'2022_11_15_111740_create_van_selling_os_datas_table',1),
(122,'2022_11_16_113837_add_customer_id_to_os_data',1),
(123,'2022_11_16_114108_create_van_selling_calls_table',1),
(124,'2023_01_31_061827_add_payment_status',1),
(125,'2023_01_31_062634_add_total_paid',1),
(126,'2023_01_31_070344_create_sales_invoice_deposit_check_slips_table',1),
(127,'2023_02_06_103301_add_barcode_to_sku_adds',1),
(128,'2023_02_06_105032_add_sub_category',1),
(129,'2023_02_06_110059_create_sku_sub_categories_table',1),
(130,'2023_02_06_112559_add_principal_id_to_category',1),
(131,'2023_02_08_132633_add_sub_category_id_to_sku',1),
(132,'2023_02_09_231848_add_price_5_to_price_details',1),
(133,'2023_02_11_013232_add_columnt_to_purchase_order_sales_order_number',2),
(134,'2023_02_11_013350_add_columnt_to_purchase_order_sales_order_numbers',3),
(135,'2023_02_11_013529_add_columnt_to_purchase_order_sales_order_numbersss',4),
(136,'2023_02_13_123604_create_receiving_drafts_table',5),
(137,'2023_02_13_130116_add_column_id_to_receiving_draft',6),
(138,'2023_02_13_130405_add_column_user_to_receiving_draft',7),
(140,'2023_02_13_134053_create_receiving_draft_mains_table',8),
(141,'2023_02_14_115815_add_scanned_remarks_to_purchase_order_details',9),
(142,'2023_02_14_122248_add_discount_type_to_receive',10),
(143,'2023_02_14_122547_create_received_purchase_order_details_table',11),
(144,'2023_02_14_123648_add_users_to_received_purchase_orders',12),
(145,'2023_02_14_123853_add_branch_received_purchase_orders',13),
(146,'2023_02_14_132122_add_column_transaction_and_all_id_to_table_sku_ledger',14),
(147,'2023_02_15_004155_add_quantity_returned_to_received_purchase_order_details',15),
(148,'2023_02_17_004417_add_final_unit_cost_to_received_purchase_order_details',16),
(149,'2023_02_18_044549_add_columntovansellingarledger',17),
(150,'2023_02_19_063454_create_received_discount_details_table',18),
(151,'2023_02_19_063925_create_received_other_discount_details_table',19),
(152,'2020_03_04_024206_create_received_purchase_orders_table',20),
(153,'2023_02_19_064803_add_many_columns_to_table_received_purchase_order',21),
(154,'2023_02_19_071117_add_discount_type',22),
(155,'2023_02_19_081706_add_scanned_and_finalized',23),
(156,'2023_02_19_081834_add_branch_to_received_purchase_orders',24),
(157,'2023_02_20_112539_add_many_columns_to_return_to_principals',25),
(158,'2023_02_21_131512_add_many_columns_to_invoice_cost_adjustments',26),
(159,'2023_02_21_132753_add_adjusted_amount_to_invoice_cost_adjustment_details',27),
(160,'2023_02_22_112737_add_freight_to_return_to_principal_details',28),
(161,'2023_02_22_122059_add_principal_id_to_invoice_cost_adjustments',29),
(162,'2023_02_22_125321_add_freight_to_invoice_cost_adjustment_details',30),
(163,'2023_02_22_133313_add_many_columns_to_principal_payment',31),
(164,'2023_02_22_134757_add_principal_id_to_sku_ledger',32),
(165,'2023_02_23_044103_create_invoice_drafts_table',33),
(166,'2023_02_23_044322_create_invoice_draft_details_table',34),
(167,'2023_02_23_044706_add_total_amount_to_invoice_draft',35),
(168,'2023_02_23_045123_add_delivery_receipt_to_invoice_draft',36),
(169,'2023_02_23_050204_add_scanned_by_to_invoice_draft',37),
(170,'2023_02_23_050635_add_quantity_to_invoice_draft_details',38),
(171,'2023_02_23_051502_add_status_to_invoice_draft',39),
(172,'2023_02_23_055930_add_quantity_out_to_invoice_draft_dtails',40),
(173,'2023_02_23_065900_add_scanned_remarks_to_invoice_draft_details',41),
(174,'2023_02_24_010140_add_many_columns_to_bodega_out_details',42),
(175,'2023_02_24_023711_add_many_columns_to_transfer_to_brans',43),
(176,'2023_02_24_024657_add_final_unit_cost_to_transfer_to_brans_details',44),
(177,'2023_02_25_055009_add_status_to_purchase_order',45),
(178,'2023_02_25_055053_add_quantity_confirmed_to_purchase_order_details',46),
(179,'2023_02_25_075317_add_sku_type_to_purchase_order',47),
(180,'2023_02_25_075921_add_many_columns_to_purchase_order_details',48),
(181,'2023_02_26_012926_add_many_columns_to_purchase_order',49),
(182,'2023_02_26_013853_add_discount_type_to_purchase_order',50),
(183,'2023_02_26_014650_create_purchase_order_other_discount_details_table',51),
(184,'2023_02_26_020053_add_time_stamp_to_po_other_discounts',52),
(185,'2023_02_26_020252_create_purchase_order_discount_details_table',53),
(186,'2023_02_26_030944_add_user_id_to_principal_ledger',54),
(187,'2023_02_27_121150_add_bo_allowance_discount_rate_to_purchase_order',54),
(188,'2023_02_27_124819_add_unit_cost_to_receiving_draft',55),
(189,'2023_02_28_132348_add_sku_type_to_sku_ledger',56),
(190,'2023_03_02_123309_create_disbursements_table',57),
(191,'2023_03_04_031951_add_adjustment_to_sku_ledger',58),
(192,'2023_03_05_010357_create_invoice_raws_table',59),
(193,'2023_03_05_010926_add_customer_to_invoice_raw',60),
(194,'2023_03_05_011456_add_sku_type_to_invoice_raw',61),
(195,'2023_03_05_043455_add_status_to_invoice_raw',62),
(196,'2023_03_06_115347_add_principal_to_invoice_raw',63),
(197,'2023_03_06_115545_add_principal_to_users',64),
(198,'2023_03_06_122224_add_barcode_to_invoice_raws',65),
(199,'2023_03_06_130529_add_manycolumns_to_invoice_raw',66),
(200,'2023_03_06_132448_add_final_quantity_to_invoice_raw',67),
(201,'2023_03_06_133634_add_sku_id_to_invoice_raw',68),
(202,'2023_03_07_112448_add_bo_rgs_to_invoice_raw',69),
(203,'2023_03_07_113714_create_return_good_stocks_table',70),
(204,'2023_03_07_113913_create_return_good_stock_details_table',71),
(205,'2023_03_07_121209_create_bad_orders_table',72),
(206,'2023_03_07_121234_create_bad_order_details_table',73),
(207,'2023_03_07_122317_create_bad_order_drafts_table',74),
(208,'2023_03_07_124313_add_agent_id_to_bad_order',75),
(209,'2023_03_14_114637_add_many_columns_to_disbursement',76),
(210,'2023_03_20_121415_add_many_columns_to_van_selling_ar_ledger',77),
(211,'2023_03_20_123724_add_price_to_van_selling_printed_details',78),
(212,'2023_03_21_121443_create_vs_withdrawals_table',79),
(213,'2023_03_21_122319_create_vs_withdrawal_details_table',80),
(214,'2023_03_21_122847_add_sku_type_to_vs_withdrawal_details',81),
(215,'2023_03_21_123905_create_vs_inventory_ledgers_table',82),
(216,'2023_03_21_125206_add_all_id_to_vs_inventory_ledger',83),
(217,'2023_03_23_100530_add_cash_with_order_to_principal_discount',84),
(218,'2023_03_23_114446_add_sku_code_to_vs_withdrawal_details',85),
(219,'2023_03_23_120405_add_sku_code_to_vs_inventory_ledgers',86),
(220,'2023_03_23_121821_create_vs_sales_table',87),
(221,'2023_03_23_133451_create_vs_inventory_adjustments_table',88),
(222,'2023_03_24_112141_create_vs_collections_table',89),
(223,'2023_03_24_125252_create_vs_pcms_table',90),
(224,'2023_03_24_132002_add_columns_to_vs_pcm',91),
(225,'2023_03_24_133036_create_vs_pcm_details_table',92),
(226,'2023_03_24_140110_add_posted_by_to_vs_pcm',93),
(227,'2023_03_27_121949_add_cwo_discount_to_purchase_order',94),
(228,'2023_03_27_122542_add_cwo_discount_amount_to_purchase_order',95),
(229,'2023_03_27_133600_add_columns_to_receive_purchase_order',96),
(230,'2023_03_27_134555_add_columns_to_return_to_principal',97),
(231,'2023_03_29_125845_add_total_to_return_good_stock',98),
(232,'2023_03_29_130117_add_pcm_to_return_good_stock',99),
(233,'2023_03_29_130809_add_columns_to_bad_order',100),
(234,'2023_03_29_131207_add_agent_id_to_return_good_stock',101),
(235,'2023_03_29_131403_add_custoemr_id_to_bad_orders',102),
(236,'2023_03_30_104717_add_many_columns_to_return_good_stock_details',103),
(237,'2023_03_30_120237_add_status_to_return_good_stock',104),
(238,'2023_03_30_121248_add_manymanycolumns_to_bad_order_details',105),
(239,'2023_03_30_121503_add_status_to_bad_order',106),
(240,'2023_03_31_114633_add_cwo_discount_to_invoice_adjustments',107),
(241,'2023_04_01_034853_add_amount_to_sku_ledger',108),
(242,'2023_04_01_054738_add_running_amount_to_sku_ledger',109),
(243,'2023_04_03_103715_add_date_to_invoice_raw',110),
(244,'2023_04_03_110144_add_price_to_invoice_raw',111),
(245,'2023_04_05_104145_create_load_sheets_table',112),
(246,'2023_04_05_110421_create_load_sheet_details_table',113),
(247,'2023_04_08_013217_add_final_unit_cost_to_sku_price_details',114),
(248,'2023_04_13_024818_add_remarks_to_vs_withdrawals_details',115),
(249,'2023_05_14_035941_add_allowed_number_of_sales_order',116),
(250,'2023_05_18_004935_add_remarks_to_sales_invoice_details',116),
(251,'2023_05_31_050030_add_agent_id_to_sales_invoice_details',117),
(252,'2023_06_01_035819_add_principal_id_to_sales_invoice_details',118),
(253,'2023_06_02_044046_create_sku_price_histories_table',119),
(254,'2023_06_02_061345_add_sku_price_5_to_sku_price_history',120),
(255,'2023_06_02_131711_create_bad_order_discounts_table',121),
(256,'2023_06_02_131915_create_return_good_stock_discounts_table',122),
(257,'2023_06_02_132645_add_user_details_to_bad_orders',123),
(258,'2023_06_02_133145_add_user_details_to_return_good_stocks',124),
(259,'2023_06_02_133236_add_user_to_price_history',125),
(260,'2023_06_26_114617_add_detail_to_location',126),
(261,'2023_06_27_110628_create_logistics_table',127),
(262,'2023_06_27_113542_create_logistics_table',128),
(263,'2023_06_27_114013_add_data_to_logistics',129),
(264,'2023_06_27_114921_add_invoice_to_logistics',130),
(265,'2023_06_27_115304_add_location_id_to_logistics',131),
(266,'2023_06_27_115735_create_logistics_details_table',132),
(267,'2023_06_27_120116_add_equivalent_updated_by_to_logistics',133),
(268,'2023_06_27_120404_add_total_expense_to_logistics',134),
(269,'2023_06_27_225745_add_weight_to_sales_invoice_details',135),
(270,'2023_06_28_002513_add_weight_to_logistics',136),
(271,'2023_06_28_002654_add_weight_to_logistics_details',137),
(272,'2023_06_28_002959_create_logistics_invoices_table',138),
(273,'2023_06_28_052300_add_status_to_logistics',139),
(274,'2023_06_29_103037_add_location_details_id_to_customer',140),
(275,'2023_08_08_130821_create_ap_ledgers_table',141),
(276,'2023_08_25_021033_add_fuc_to_sku_ledger',142),
(277,'2023_09_04_111554_add_truck_load_status',143),
(278,'2023_09_23_043344_add_location_details_id_to_van_selling_customer',143),
(279,'2023_09_27_101214_add_payment_status_to_purchase_order',143),
(280,'2023_09_27_101452_add_payment_status_to_receive_purchase_orders',144),
(281,'2023_09_27_110316_create_disbursement_jers_table',145),
(282,'2023_09_27_110725_add_po_rr_id_to_disbursements',146),
(283,'2023_09_27_111908_add_disbursement_id_to_disbursements',147),
(284,'2023_09_27_112756_add_disbursement_id_to_disbursements',148),
(285,'2023_09_28_120523_create_sales_invoice_jers_table',149),
(286,'2023_09_28_121914_create_sales_invoice_accounts_receivables_table',150),
(287,'2023_09_28_123456_create_sales_invoice_sales_table',151),
(288,'2023_09_28_124340_create_sales_invoice_cost_of_sales_table',152),
(289,'2023_10_05_125737_add_amount_payment_to_disbursements',153),
(290,'2023_10_05_125955_add_amount_payment_to_disbursements',154),
(291,'2023_10_05_130328_add_transaction_to_disbursements',155),
(292,'2023_10_07_143408_add_total_discount_per_sku_to_sales_invoice_details',156),
(293,'2023_10_11_112714_create_sales_invoice_collection_receipts_table',157),
(294,'2023_10_11_113327_create_sales_invoice_collection_receipt_details_table',158),
(295,'2023_10_11_115532_create_sales_invoice_collection_jers_table',159),
(296,'2023_10_13_135836_create_transaction_entries_table',160),
(297,'2023_10_25_123826_create_vs_os_datas_table',161),
(298,'2023_10_25_124615_create_vs_os_details_table',161),
(299,'2023_10_25_130811_add_date_to_vs_os_details',161),
(300,'2023_10_25_131435_add_unit_price_to_vs_os_details',161),
(301,'2023_10_30_130733_add_fuel_given_amount_updated_by',162),
(302,'2023_10_31_113447_add_delivery_date_to_logistics_invoices',163),
(303,'2023_11_02_120213_add_payment_status_to__sales_invoice_collection_receipt_details',164),
(304,'2023_11_04_022444_add_status_to_agent',165),
(305,'2023_11_04_085435_add_sales_invoice_id_to_return_good_stock',165),
(306,'2023_11_04_085755_add_returned_by_to_return_good_stock',165),
(307,'2023_11_06_113232_add_verified_by_name_to_return_good_stock',166),
(308,'2023_11_07_131845_add_quantity_returned_to_sales_invoice_details',167),
(309,'2023_11_07_135805_add_total_returned_amount_to_sales_invoice',168),
(310,'2023_11_08_105327_add_final_status_return_good_stock',169),
(311,'2023_11_08_105341_add_final_status_bad_order',169),
(312,'2023_11_10_145613_add_si_id_to_bad_order',170),
(313,'2023_11_10_153018_add_status_to_sales_invoice_accounts_receivable',170),
(314,'2023_11_13_124923_create_ewt_rates_table',171),
(315,'2023_11_13_133353_add_many_column_to_disbursements',172),
(316,'2023_11_13_135629_add_many_columns_to_disbursements_jer',173),
(317,'2023_11_13_140437_add_many_columns_to_disbursements_jer',174),
(318,'2023_12_09_113057_add_transaction_to_transaction_entry',175),
(319,'2023_12_10_090628_add_account_number_to_customer',176),
(320,'2023_12_10_090802_create_chart_of_accounts_table',177),
(321,'2023_12_10_091438_create_chart_of_accounts_details_table',178),
(322,'2023_12_17_093247_add_principal_id_to_chart_of_accounts_details',179),
(323,'2023_12_17_122758_add_principal_boolean_to_chart_of_accounts',180),
(324,'2023_12_17_130620_create_general_ledgers_table',181),
(325,'2023_12_22_204715_add_details_to_general_ledger',182),
(326,'2023_12_22_215526_add_transaction_to_general_ledger',183),
(327,'2023_12_27_203312_add_branch_to_general_ledger',184),
(328,'2023_12_27_212006_add_customer_id_to__chart_of_accounts_details',185),
(329,'2023_12_28_194616_add_customer_id_to_general_ledger',186),
(330,'2024_01_05_204700_add_normal_balance_to_chart_of_accounts_details',187),
(331,'2024_01_05_214222_create_disbursement_others_table',188),
(332,'2024_01_08_201253_add_confirmed_by_user',189),
(333,'2024_01_08_201413_add_confirmed_by_to_return_goods_stock',190),
(334,'2024_01_08_201541_add_confirm_data_to_bad_orders',191),
(335,'2024_01_08_201628_add_confirmed_date_to_rgs',192),
(336,'2024_01_09_194432_add_entry_to_bad_orders',193),
(337,'2018_09_15_074452_add_entry_to_return_good_stocks',194),
(338,'2024_01_12_214438_add_purchase_discount_to_disbursements',195),
(339,'2024_01_17_080240_add_posted_amount_to_bad_orders',196),
(340,'2024_01_17_084924_add_cm_amount_to_sales_invoice',197),
(341,'2024_01_17_092124_add_posted_amount_to_return_goods_stock',198),
(342,'2024_01_23_175351_add_more_column_to_rgs_table',199),
(343,'2024_01_31_075959_add_status_to_driver_table',200),
(344,'2024_01_31_085323_add_control_to_logistics',201),
(345,'2024_01_31_090003_add_control_to_logistics',202),
(346,'2024_02_05_083019_create_warehouse_outs_table',203),
(347,'2024_02_05_083133_create_warehouse_out_details_table',204);

/*Table structure for table `password_resets` */

DROP TABLE IF EXISTS `password_resets`;

CREATE TABLE `password_resets` (
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `password_resets` */

/*Table structure for table `pcm_upload_details` */

DROP TABLE IF EXISTS `pcm_upload_details`;

CREATE TABLE `pcm_upload_details` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `pcm_upload_id` bigint unsigned NOT NULL,
  `sku_id` int unsigned NOT NULL,
  `rgs_quantity` int NOT NULL,
  `bo_quantity` int NOT NULL,
  `unit_price` double NOT NULL,
  `remarks` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pcm_upload_details_pcm_upload_id_index` (`pcm_upload_id`),
  KEY `pcm_upload_details_sku_id_index` (`sku_id`),
  CONSTRAINT `pcm_upload_details_pcm_upload_id_foreign` FOREIGN KEY (`pcm_upload_id`) REFERENCES `pcm_uploads` (`id`),
  CONSTRAINT `pcm_upload_details_sku_id_foreign` FOREIGN KEY (`sku_id`) REFERENCES `sku_adds` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `pcm_upload_details` */

/*Table structure for table `pcm_upload_vs` */

DROP TABLE IF EXISTS `pcm_upload_vs`;

CREATE TABLE `pcm_upload_vs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` bigint unsigned NOT NULL,
  `rgs_status` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `bo_status` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pcm_upload_vs_customer_id_index` (`customer_id`),
  CONSTRAINT `pcm_upload_vs_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `pcm_upload_vs` */

/*Table structure for table `pcm_upload_vs_details` */

DROP TABLE IF EXISTS `pcm_upload_vs_details`;

CREATE TABLE `pcm_upload_vs_details` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `pcm_upload_vs_id` bigint unsigned NOT NULL,
  `sku_code` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `rgs_quantity` int NOT NULL,
  `bo_quantity` int NOT NULL,
  `unit_price` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remarks` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pcm_upload_vs_details_pcm_upload_vs_id_index` (`pcm_upload_vs_id`),
  CONSTRAINT `pcm_upload_vs_details_pcm_upload_vs_id_foreign` FOREIGN KEY (`pcm_upload_vs_id`) REFERENCES `pcm_upload_vs` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `pcm_upload_vs_details` */

/*Table structure for table `pcm_uploads` */

DROP TABLE IF EXISTS `pcm_uploads`;

CREATE TABLE `pcm_uploads` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `bo_rgs_export_code` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `agent_id` bigint unsigned NOT NULL,
  `customer_id` bigint unsigned NOT NULL,
  `principal_id` int unsigned NOT NULL,
  `delivery_receipt` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `rgs_status` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `bo_status` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `returned_by` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pcm_uploads_agent_id_index` (`agent_id`),
  KEY `pcm_uploads_customer_id_index` (`customer_id`),
  KEY `pcm_uploads_principal_id_index` (`principal_id`),
  KEY `pcm_uploads_date_index` (`date`),
  CONSTRAINT `pcm_uploads_agent_id_foreign` FOREIGN KEY (`agent_id`) REFERENCES `agents` (`id`),
  CONSTRAINT `pcm_uploads_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`),
  CONSTRAINT `pcm_uploads_principal_id_foreign` FOREIGN KEY (`principal_id`) REFERENCES `sku_principals` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `pcm_uploads` */

/*Table structure for table `personnel_add_details` */

DROP TABLE IF EXISTS `personnel_add_details`;

CREATE TABLE `personnel_add_details` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `personnel_id` bigint NOT NULL,
  `principal_id` int unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `personnel_add_details_principal_id_index` (`principal_id`),
  CONSTRAINT `personnel_add_details_principal_id_foreign` FOREIGN KEY (`principal_id`) REFERENCES `sku_principals` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `personnel_add_details` */

/*Table structure for table `personnel_adds` */

DROP TABLE IF EXISTS `personnel_adds`;

CREATE TABLE `personnel_adds` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `full_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `principal_id` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `personnel_description_id` bigint unsigned NOT NULL,
  `gender` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact_number` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `personnel_adds_personnel_description_id_index` (`personnel_description_id`),
  CONSTRAINT `personnel_adds_personnel_description_id_foreign` FOREIGN KEY (`personnel_description_id`) REFERENCES `personnel_descriptions` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `personnel_adds` */

/*Table structure for table `personnel_descriptions` */

DROP TABLE IF EXISTS `personnel_descriptions`;

CREATE TABLE `personnel_descriptions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `personnel_description` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `personnel_descriptions` */

/*Table structure for table `principal_discount_details` */

DROP TABLE IF EXISTS `principal_discount_details`;

CREATE TABLE `principal_discount_details` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `principal_discount_id` bigint unsigned NOT NULL,
  `discount_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `discount_rate` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `principal_discount_details_principal_discount_id_index` (`principal_discount_id`),
  CONSTRAINT `principal_discount_details_principal_discount_id_foreign` FOREIGN KEY (`principal_discount_id`) REFERENCES `principal_discounts` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `principal_discount_details` */

insert  into `principal_discount_details`(`id`,`principal_discount_id`,`discount_name`,`discount_rate`,`created_at`,`updated_at`) values 
(1,1,'Trade Discount',2,'2023-04-14 04:57:23','2023-04-14 04:57:23'),
(2,1,'Cash with Order',2,'2023-04-14 04:57:23','2023-04-14 04:57:23'),
(3,1,'Operating Fund (1)',2,'2023-04-14 04:57:23','2023-04-14 04:57:23'),
(4,1,'Operating Fund (1)',2,'2023-04-14 04:57:23','2023-04-14 04:57:23'),
(5,1,'Profit Margin/Volume Discount',2,'2023-04-14 04:57:23','2023-04-14 04:57:23'),
(6,1,'OF/MF/LF',1,'2023-04-14 04:57:23','2023-04-14 04:57:23'),
(7,1,'BO',0.75,'2023-04-14 04:57:23','2023-04-14 04:57:23'),
(8,1,'CWO',0.75,'2023-04-14 04:57:23','2023-04-14 04:57:23'),
(9,2,'Trade Discount',2,'2023-04-14 04:58:30','2023-04-14 04:58:30'),
(10,2,'Cash with order',2,'2023-04-14 04:58:30','2023-04-14 04:58:30'),
(11,2,'Operating Fund (1)',2,'2023-04-14 04:58:30','2023-04-14 04:58:30'),
(12,2,'Operating Fund (2)',2,'2023-04-14 04:58:30','2023-04-14 04:58:30'),
(13,2,'Profit Margin/Volume Discount',2,'2023-04-14 04:58:30','2023-04-14 04:58:30'),
(14,2,'OF/MF/LF',1,'2023-04-14 04:58:30','2023-04-14 04:58:30'),
(15,2,'BO',0.5,'2023-04-14 04:58:30','2023-04-14 04:58:30'),
(16,2,'CWO',0.5,'2023-04-14 04:58:30','2023-04-14 04:58:30'),
(17,3,'Trade Discount',2,'2023-04-14 20:35:19','2023-04-14 20:35:19'),
(18,3,'CWO',2,'2023-04-14 20:35:19','2023-04-14 20:35:19'),
(19,3,'OF 1',2,'2023-04-14 20:35:19','2023-04-14 20:35:19'),
(20,3,'OF 2',2,'2023-04-14 20:35:19','2023-04-14 20:35:19'),
(21,3,'Profit Margin',2,'2023-04-14 20:35:19','2023-04-14 20:35:19'),
(22,3,'OP/MF/LF',1,'2023-04-14 20:35:19','2023-04-14 20:35:19'),
(23,3,'BO',0.75,'2023-04-14 20:35:19','2023-04-14 20:35:19'),
(24,3,'CWO',0,'2023-04-14 20:35:19','2023-04-14 20:35:19'),
(25,4,'Trade Discount',2,'2023-04-14 21:13:34','2023-04-14 21:13:34'),
(26,4,'Cash with Order',2,'2023-04-14 21:13:34','2023-04-14 21:13:34'),
(27,4,'Operating Fund 1',2,'2023-04-14 21:13:34','2023-04-14 21:13:34'),
(28,4,'Operating Fund 2',2,'2023-04-14 21:13:34','2023-04-14 21:13:34'),
(29,4,'Profit Margin/Volume Discount',2,'2023-04-14 21:13:34','2023-04-14 21:13:34'),
(30,4,'Operation Fund/Marketing Fund/Listing Fee',1,'2023-04-14 21:13:34','2023-04-14 21:13:34'),
(31,4,'BO',0.5,'2023-04-14 21:13:34','2023-04-14 21:13:34'),
(32,4,'CWO',0,'2023-04-14 21:13:34','2023-04-14 21:13:34'),
(36,6,'Price Dec',16,'2023-08-11 18:24:22','2023-08-11 18:24:22'),
(37,6,'BO',0.75,'2023-08-11 18:24:22','2023-08-11 18:24:22'),
(38,6,'CWO',0,'2023-08-11 18:24:22','2023-08-11 18:24:22');

/*Table structure for table `principal_discounts` */

DROP TABLE IF EXISTS `principal_discounts`;

CREATE TABLE `principal_discounts` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int unsigned DEFAULT NULL,
  `principal_id` int unsigned DEFAULT NULL,
  `total_discount` double DEFAULT NULL,
  `total_bo_allowance_discount` double DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `cash_with_order_discount` double(15,4) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `principal_discounts_user_id_index` (`user_id`),
  KEY `principal_discounts_principal_id_index` (`principal_id`),
  CONSTRAINT `principal_discounts_principal_id_foreign` FOREIGN KEY (`principal_id`) REFERENCES `sku_principals` (`id`),
  CONSTRAINT `principal_discounts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `principal_discounts` */

insert  into `principal_discounts`(`id`,`user_id`,`principal_id`,`total_discount`,`total_bo_allowance_discount`,`created_at`,`updated_at`,`cash_with_order_discount`) values 
(1,1,7,11,0.75,'2023-04-14 04:57:23','2023-04-14 04:57:23',0.7500),
(2,1,7,11,0.5,'2023-04-14 04:58:30','2023-04-14 04:58:30',0.5000),
(3,2,7,11,0.75,'2023-04-14 20:35:19','2023-04-14 20:35:19',0.0000),
(4,2,7,11,0.5,'2023-04-14 21:13:34','2023-04-14 21:13:34',0.0000),
(6,1,2,16,0.75,'2023-08-11 18:24:22','2023-08-11 18:24:22',0.0000);

/*Table structure for table `principal_ledgers` */

DROP TABLE IF EXISTS `principal_ledgers`;

CREATE TABLE `principal_ledgers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `principal_id` int unsigned NOT NULL,
  `all_id` int DEFAULT NULL,
  `transaction` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `accounts_payable_beginning` double(15,4) DEFAULT NULL,
  `received` double(15,4) DEFAULT NULL,
  `returned` double(15,4) DEFAULT NULL,
  `adjustment` double(15,4) DEFAULT NULL,
  `payment` double(15,4) DEFAULT NULL,
  `accounts_payable_end` double(15,4) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` int unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `principal_ledgers_principal_id_index` (`principal_id`),
  KEY `principal_ledgers_date_index` (`date`),
  KEY `principal_ledgers_user_id_index` (`user_id`),
  CONSTRAINT `principal_ledgers_principal_id_foreign` FOREIGN KEY (`principal_id`) REFERENCES `sku_principals` (`id`),
  CONSTRAINT `principal_ledgers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `principal_ledgers` */

insert  into `principal_ledgers`(`id`,`principal_id`,`all_id`,`transaction`,`accounts_payable_beginning`,`received`,`returned`,`adjustment`,`payment`,`accounts_payable_end`,`date`,`created_at`,`updated_at`,`user_id`) values 
(1,2,1,'received',0.0000,1439196.6960,0.0000,0.0000,0.0000,1439196.6960,'2023-11-13','2023-11-13 11:47:18','2023-11-13 11:47:18',1),
(2,2,1,'returned',1439196.6960,0.0000,34421.7838,0.0000,0.0000,1404774.9122,NULL,'2023-11-13 11:48:46','2023-11-13 11:48:46',1),
(3,2,1,'bo adjustment',1404774.9122,0.0000,0.0000,3900.0000,0.0000,1408674.9122,'2023-11-13','2023-11-13 11:57:43','2023-11-13 11:57:43',1),
(4,2,2,'bo adjustment',1408674.9122,0.0000,0.0000,-3900.0000,0.0000,1404774.9122,'2023-11-13','2023-11-13 12:15:09','2023-11-13 12:15:09',1),
(5,2,4,'payment to principal',1404774.9122,0.0000,0.0000,0.0000,1390727.1600,14047.7522,'2023-11-13','2023-11-13 14:10:54','2023-11-13 14:10:54',1),
(6,2,1,'payment to principal',14047.7522,0.0000,0.0000,0.0000,1404774.9091,-1362631.6587,'2023-11-13','2023-11-13 14:15:02','2023-11-13 14:15:02',1),
(7,2,2,'payment to principal',-1362631.6587,0.0000,0.0000,0.0000,1404774.9091,-2739311.0696,'2023-11-13','2023-11-13 14:19:09','2023-11-13 14:19:09',1),
(8,2,2,'received',-2739311.0696,37793.9016,0.0000,0.0000,0.0000,-2701517.1680,'2023-12-23','2023-12-23 05:16:19','2023-12-23 05:16:19',1),
(9,2,2,'returned',-2701517.1680,0.0000,3779.3902,0.0000,0.0000,-2705296.5582,NULL,'2023-12-23 05:35:35','2023-12-23 05:35:35',1),
(10,2,3,'bo adjustment',-2705296.5582,0.0000,0.0000,90.0000,0.0000,-2705206.5582,'2023-12-23','2023-12-23 06:08:25','2023-12-23 06:08:25',1),
(11,2,3,'received',-2705206.5582,377939.0160,0.0000,0.0000,0.0000,-2327267.5422,'2023-12-28','2023-12-28 04:46:33','2023-12-28 04:46:33',1);

/*Table structure for table `principal_payments` */

DROP TABLE IF EXISTS `principal_payments`;

CREATE TABLE `principal_payments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `principal_id` int unsigned NOT NULL,
  `payment` double(15,4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `current_accounts_payable_final` double(15,4) NOT NULL,
  `user_id` int NOT NULL,
  `cheque_number` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `disbursement_number` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `principal_payments_principal_id_index` (`principal_id`),
  CONSTRAINT `principal_payments_principal_id_foreign` FOREIGN KEY (`principal_id`) REFERENCES `sku_principals` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `principal_payments` */

/*Table structure for table `purchase_order_details` */

DROP TABLE IF EXISTS `purchase_order_details`;

CREATE TABLE `purchase_order_details` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `purchase_order_id` bigint unsigned NOT NULL,
  `sku_id` int unsigned NOT NULL,
  `quantity` int NOT NULL,
  `receive` int DEFAULT NULL,
  `unit_cost` double(15,4) DEFAULT NULL,
  `remarks` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `scanned_remarks` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `confirmed_quantity` int DEFAULT NULL,
  `freight` double(15,4) DEFAULT NULL,
  `final_unit_cost` double(15,4) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `purchase_order_details_purchase_order_id_index` (`purchase_order_id`),
  KEY `purchase_order_details_sku_id_index` (`sku_id`),
  CONSTRAINT `purchase_order_details_purchase_order_id_foreign` FOREIGN KEY (`purchase_order_id`) REFERENCES `purchase_orders` (`id`),
  CONSTRAINT `purchase_order_details_sku_id_foreign` FOREIGN KEY (`sku_id`) REFERENCES `sku_adds` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `purchase_order_details` */

insert  into `purchase_order_details`(`id`,`purchase_order_id`,`sku_id`,`quantity`,`receive`,`unit_cost`,`remarks`,`created_at`,`updated_at`,`scanned_remarks`,`confirmed_quantity`,`freight`,`final_unit_cost`) values 
(1,3,211,1000,1000,405.3400,'received','2023-11-13 11:41:19','2023-11-13 11:47:18',NULL,1000,0.0000,377.9390),
(2,3,212,1000,1000,433.2000,'received','2023-11-13 11:41:19','2023-11-13 11:47:18',NULL,1000,0.0000,403.9157),
(3,3,213,1000,1000,400.0000,'received','2023-11-13 11:41:19','2023-11-13 11:47:18',NULL,1000,0.0000,372.9600),
(4,3,214,1000,1000,305.0000,'received','2023-11-13 11:41:19','2023-11-13 11:47:18',NULL,1000,0.0000,284.3820),
(5,4,211,10000,NULL,NULL,NULL,'2023-11-15 09:57:52','2023-11-15 09:57:52',NULL,NULL,NULL,NULL),
(6,5,211,100,100,405.3400,'received','2023-12-17 04:07:21','2023-12-23 05:16:19',NULL,100,0.0000,377.9390),
(7,6,211,1000,1000,405.3400,'received','2023-12-28 04:44:56','2023-12-28 04:46:33',NULL,1000,0.0000,377.9390);

/*Table structure for table `purchase_order_discount_details` */

DROP TABLE IF EXISTS `purchase_order_discount_details`;

CREATE TABLE `purchase_order_discount_details` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `purchase_order_id` bigint unsigned NOT NULL,
  `discount_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `discount_rate` double(15,4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `purchase_order_discount_details_purchase_order_id_index` (`purchase_order_id`),
  CONSTRAINT `purchase_order_discount_details_purchase_order_id_foreign` FOREIGN KEY (`purchase_order_id`) REFERENCES `purchase_orders` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `purchase_order_discount_details` */

insert  into `purchase_order_discount_details`(`id`,`purchase_order_id`,`discount_name`,`discount_rate`,`created_at`,`updated_at`) values 
(1,3,'Price Dec',16.0000,'2023-11-13 11:41:56','2023-11-13 11:41:56'),
(2,5,'Price Dec',16.0000,'2023-12-17 04:09:09','2023-12-17 04:09:09'),
(3,6,'Price Dec',16.0000,'2023-12-28 04:45:27','2023-12-28 04:45:27');

/*Table structure for table `purchase_order_other_discount_details` */

DROP TABLE IF EXISTS `purchase_order_other_discount_details`;

CREATE TABLE `purchase_order_other_discount_details` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `purchase_order_id` bigint unsigned NOT NULL,
  `discount_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `discount_rate` double(15,4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `purchase_order_other_discount_details_purchase_order_id_index` (`purchase_order_id`),
  CONSTRAINT `purchase_order_other_discount_details_purchase_order_id_foreign` FOREIGN KEY (`purchase_order_id`) REFERENCES `purchase_orders` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `purchase_order_other_discount_details` */

/*Table structure for table `purchase_orders` */

DROP TABLE IF EXISTS `purchase_orders`;

CREATE TABLE `purchase_orders` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `purchase_id` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `principal_id` int unsigned DEFAULT NULL,
  `user_id` int unsigned DEFAULT NULL,
  `payment_term` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `delivery_term` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `particulars` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remarks` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `van_number` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `po_confirmation_image` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sku_type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gross_purchase` double(15,4) DEFAULT NULL,
  `total_less_discount` double(15,4) DEFAULT NULL,
  `bo_discount` double(15,4) DEFAULT NULL,
  `vatable_purchase` double(15,4) DEFAULT NULL,
  `vat` double(15,4) DEFAULT NULL,
  `freight` double(15,4) DEFAULT NULL,
  `total_final_cost` double(15,4) DEFAULT NULL,
  `total_less_other_discount` double(15,4) DEFAULT NULL,
  `net_payable` double(15,4) DEFAULT NULL,
  `discount_type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bo_allowance_discount_rate` double(3,2) DEFAULT NULL,
  `cwo_discount_rate` double(5,2) DEFAULT NULL,
  `cwo_discount` double(15,4) DEFAULT NULL,
  `payment_status` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `purchase_orders_principal_id_index` (`principal_id`),
  KEY `purchase_orders_user_id_index` (`user_id`),
  CONSTRAINT `purchase_orders_principal_id_foreign` FOREIGN KEY (`principal_id`) REFERENCES `sku_principals` (`id`),
  CONSTRAINT `purchase_orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `purchase_orders` */

insert  into `purchase_orders`(`id`,`purchase_id`,`principal_id`,`user_id`,`payment_term`,`delivery_term`,`particulars`,`remarks`,`created_at`,`updated_at`,`van_number`,`po_confirmation_image`,`status`,`sku_type`,`gross_purchase`,`total_less_discount`,`bo_discount`,`vatable_purchase`,`vat`,`freight`,`total_final_cost`,`total_less_other_discount`,`net_payable`,`discount_type`,`bo_allowance_discount_rate`,`cwo_discount_rate`,`cwo_discount`,`payment_status`) values 
(3,'GCI-11-2023-2',2,1,'cash with order','15 days',NULL,'received','2023-11-13 11:41:19','2023-11-13 11:47:18','54321',NULL,'completed','Case',1543540.0000,246966.4000,11576.5500,1284997.0500,154199.6460,0.0000,1439196.6960,0.0000,0.0000,'type_a',0.75,0.00,0.0000,NULL),
(4,'GCI-11-2023-3',2,1,NULL,NULL,NULL,NULL,'2023-11-15 09:57:52','2023-11-15 09:57:52',NULL,NULL,NULL,'Case',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(5,'GCI-12-2023-4',2,1,'cash with order','15 days',NULL,'received','2023-12-17 04:07:21','2023-12-23 05:16:19','0001',NULL,'completed','Case',40534.0000,6485.4400,304.0050,33744.5550,4049.3466,0.0000,37793.9016,0.0000,0.0000,'type_a',0.75,0.00,0.0000,NULL),
(6,'GCI-12-2023-5',2,1,'cash with order','15 days',NULL,'received','2023-12-28 04:44:56','2023-12-28 04:46:33','009944',NULL,'completed','Case',405340.0000,64854.4000,3040.0500,337445.5500,40493.4660,0.0000,377939.0160,0.0000,0.0000,'type_a',0.75,0.00,0.0000,NULL);

/*Table structure for table `received_discount_details` */

DROP TABLE IF EXISTS `received_discount_details`;

CREATE TABLE `received_discount_details` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `received_id` bigint unsigned DEFAULT NULL,
  `discount_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `discount_rate` double(15,4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `received_discount_details_received_id_index` (`received_id`),
  CONSTRAINT `received_discount_details_received_id_foreign` FOREIGN KEY (`received_id`) REFERENCES `received_purchase_orders` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `received_discount_details` */

insert  into `received_discount_details`(`id`,`received_id`,`discount_name`,`discount_rate`,`created_at`,`updated_at`) values 
(1,1,'Price Dec',16.0000,'2023-11-13 11:47:18','2023-11-13 11:47:18'),
(2,2,'Price Dec',16.0000,'2023-12-23 05:16:19','2023-12-23 05:16:19'),
(3,3,'Price Dec',16.0000,'2023-12-28 04:46:33','2023-12-28 04:46:33');

/*Table structure for table `received_jers` */

DROP TABLE IF EXISTS `received_jers`;

CREATE TABLE `received_jers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `principal_id` int unsigned NOT NULL,
  `received_id` bigint unsigned DEFAULT NULL,
  `dr` double(15,4) NOT NULL,
  `cr` double(15,4) NOT NULL,
  `date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `received_jers_principal_id_index` (`principal_id`),
  KEY `received_jers_received_id_index` (`received_id`),
  KEY `received_jers_date_index` (`date`),
  CONSTRAINT `received_jers_principal_id_foreign` FOREIGN KEY (`principal_id`) REFERENCES `sku_principals` (`id`),
  CONSTRAINT `received_jers_received_id_foreign` FOREIGN KEY (`received_id`) REFERENCES `received_purchase_orders` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `received_jers` */

insert  into `received_jers`(`id`,`principal_id`,`received_id`,`dr`,`cr`,`date`,`created_at`,`updated_at`) values 
(1,2,1,1439196.6960,1439196.6960,'2023-11-13','2023-11-13 11:47:18','2023-11-13 11:47:18'),
(2,2,2,37793.9016,37793.9016,'2023-12-23','2023-12-23 05:16:19','2023-12-23 05:16:19'),
(3,2,3,377939.0160,377939.0160,'2023-12-28','2023-12-28 04:46:33','2023-12-28 04:46:33');

/*Table structure for table `received_other_discount_details` */

DROP TABLE IF EXISTS `received_other_discount_details`;

CREATE TABLE `received_other_discount_details` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `received_id` bigint unsigned DEFAULT NULL,
  `discount_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `discount_rate` double(15,4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `received_other_discount_details_received_id_index` (`received_id`),
  CONSTRAINT `received_other_discount_details_received_id_foreign` FOREIGN KEY (`received_id`) REFERENCES `received_purchase_orders` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `received_other_discount_details` */

/*Table structure for table `received_purchase_order_details` */

DROP TABLE IF EXISTS `received_purchase_order_details`;

CREATE TABLE `received_purchase_order_details` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `received_id` bigint unsigned NOT NULL,
  `sku_id` int unsigned NOT NULL,
  `quantity` int NOT NULL,
  `unit_cost` double(15,4) NOT NULL,
  `freight` double(15,4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `quantity_returned` int DEFAULT NULL,
  `final_unit_cost` double(15,4) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `received_purchase_order_details_received_id_index` (`received_id`),
  KEY `received_purchase_order_details_sku_id_index` (`sku_id`),
  CONSTRAINT `received_purchase_order_details_received_id_foreign` FOREIGN KEY (`received_id`) REFERENCES `received_purchase_orders` (`id`),
  CONSTRAINT `received_purchase_order_details_sku_id_foreign` FOREIGN KEY (`sku_id`) REFERENCES `sku_adds` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `received_purchase_order_details` */

insert  into `received_purchase_order_details`(`id`,`received_id`,`sku_id`,`quantity`,`unit_cost`,`freight`,`created_at`,`updated_at`,`quantity_returned`,`final_unit_cost`) values 
(1,1,211,1000,405.3400,0.0000,'2023-11-13 11:47:18','2023-11-13 11:48:46',10,377.9390),
(2,1,212,1000,433.2000,0.0000,'2023-11-13 11:47:18','2023-11-13 11:48:46',20,403.9157),
(3,1,213,1000,400.0000,0.0000,'2023-11-13 11:47:18','2023-11-13 11:48:46',30,372.9600),
(4,1,214,1000,305.0000,0.0000,'2023-11-13 11:47:18','2023-11-13 11:48:46',40,284.3820),
(5,2,211,100,405.3400,0.0000,'2023-12-23 05:16:19','2023-12-23 05:35:35',10,377.9390),
(6,3,211,1000,405.3400,0.0000,'2023-12-28 04:46:33','2023-12-28 04:46:33',NULL,377.9390);

/*Table structure for table `received_purchase_orders` */

DROP TABLE IF EXISTS `received_purchase_orders`;

CREATE TABLE `received_purchase_orders` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `bo_allowance_discount_rate` double(5,4) NOT NULL,
  `principal_id` int unsigned DEFAULT NULL,
  `purchase_order_id` bigint unsigned NOT NULL,
  `dr_si` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `truck_number` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `courier` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `invoice_date` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remarks` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date` date DEFAULT NULL,
  `invoice_image` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `gross_purchase` double(15,4) NOT NULL,
  `total_less_discount` double(15,4) NOT NULL,
  `bo_discount` double(15,4) NOT NULL,
  `vatable_purchase` double(15,4) NOT NULL,
  `vat` double(15,4) NOT NULL,
  `freight` double(15,4) NOT NULL,
  `total_final_cost` double(15,4) NOT NULL,
  `total_less_other_discount` double(15,4) DEFAULT NULL,
  `net_payable` double(15,4) DEFAULT NULL,
  `discount_type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scanned_by` int unsigned NOT NULL,
  `finalized_by` int unsigned NOT NULL,
  `branch` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cwo_discount_rate` double(5,4) DEFAULT NULL,
  `cwo_discount` double(15,4) DEFAULT NULL,
  `payment_status` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `received_purchase_orders_principal_id_index` (`principal_id`),
  KEY `received_purchase_orders_purchase_order_id_index` (`purchase_order_id`),
  KEY `received_purchase_orders_dr_si_index` (`dr_si`),
  KEY `received_purchase_orders_truck_number_index` (`truck_number`),
  KEY `received_purchase_orders_courier_index` (`courier`),
  KEY `received_purchase_orders_invoice_date_index` (`invoice_date`),
  KEY `received_purchase_orders_remarks_index` (`remarks`),
  KEY `received_purchase_orders_date_index` (`date`),
  KEY `received_purchase_orders_scanned_by_index` (`scanned_by`),
  KEY `received_purchase_orders_finalized_by_index` (`finalized_by`),
  CONSTRAINT `received_purchase_orders_finalized_by_foreign` FOREIGN KEY (`finalized_by`) REFERENCES `users` (`id`),
  CONSTRAINT `received_purchase_orders_principal_id_foreign` FOREIGN KEY (`principal_id`) REFERENCES `sku_principals` (`id`),
  CONSTRAINT `received_purchase_orders_purchase_order_id_foreign` FOREIGN KEY (`purchase_order_id`) REFERENCES `purchase_orders` (`id`),
  CONSTRAINT `received_purchase_orders_scanned_by_foreign` FOREIGN KEY (`scanned_by`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `received_purchase_orders` */

insert  into `received_purchase_orders`(`id`,`bo_allowance_discount_rate`,`principal_id`,`purchase_order_id`,`dr_si`,`truck_number`,`courier`,`invoice_date`,`remarks`,`date`,`invoice_image`,`created_at`,`updated_at`,`gross_purchase`,`total_less_discount`,`bo_discount`,`vatable_purchase`,`vat`,`freight`,`total_final_cost`,`total_less_other_discount`,`net_payable`,`discount_type`,`scanned_by`,`finalized_by`,`branch`,`cwo_discount_rate`,`cwo_discount`,`payment_status`) values 
(1,0.7500,2,3,'eqweqw','123123','SOLID','2023-11-14',NULL,NULL,'No Sales Invoice Yet','2023-11-13 11:47:18','2023-11-13 11:47:18',1543540.0000,246966.4000,11576.5500,1284997.0500,154199.6460,0.0000,1439196.6960,0.0000,0.0000,'type_a',1,1,'NORTH MIN',0.0000,0.0000,NULL),
(2,0.7500,2,5,'dr12321','123123','SOLID','2023-12-08',NULL,NULL,'No Sales Invoice Yet','2023-12-23 05:16:18','2023-12-23 05:16:18',40534.0000,6485.4400,304.0050,33744.5550,4049.3466,0.0000,37793.9016,0.0000,0.0000,'type_a',1,1,'NORTH MIN',0.0000,0.0000,NULL),
(3,0.7500,2,6,'0005','dac9932','SOLID','2023-12-27',NULL,NULL,'No Sales Invoice Yet','2023-12-28 04:46:33','2023-12-28 04:46:33',405340.0000,64854.4000,3040.0500,337445.5500,40493.4660,0.0000,377939.0160,0.0000,0.0000,'type_a',1,1,'NORTH MIN',0.0000,0.0000,NULL);

/*Table structure for table `receiving_draft_mains` */

DROP TABLE IF EXISTS `receiving_draft_mains`;

CREATE TABLE `receiving_draft_mains` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `purchase_order_id` bigint unsigned NOT NULL,
  `session_id` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` int unsigned NOT NULL,
  `status` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `receiving_draft_mains_purchase_order_id_index` (`purchase_order_id`),
  KEY `receiving_draft_mains_user_id_index` (`user_id`),
  CONSTRAINT `receiving_draft_mains_purchase_order_id_foreign` FOREIGN KEY (`purchase_order_id`) REFERENCES `purchase_orders` (`id`),
  CONSTRAINT `receiving_draft_mains_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `receiving_draft_mains` */

insert  into `receiving_draft_mains`(`id`,`purchase_order_id`,`session_id`,`user_id`,`status`,`created_at`,`updated_at`) values 
(1,3,'65520bf2ecd71',1,'completed','2023-11-13 03:44:04','2023-11-13 11:47:18'),
(2,5,'657e041aadd76',1,'completed','2023-12-16 20:10:13','2023-12-23 05:16:19'),
(3,6,'658c8cf4c0952',1,'completed','2023-12-27 20:45:47','2023-12-28 04:46:33');

/*Table structure for table `receiving_drafts` */

DROP TABLE IF EXISTS `receiving_drafts`;

CREATE TABLE `receiving_drafts` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `sku_id` int unsigned NOT NULL,
  `quantity` int DEFAULT NULL,
  `remarks` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `session_id` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` int NOT NULL,
  `unit_cost` double(15,4) DEFAULT NULL,
  `freight` double(15,4) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `receiving_drafts_sku_id_index` (`sku_id`),
  CONSTRAINT `receiving_drafts_sku_id_foreign` FOREIGN KEY (`sku_id`) REFERENCES `sku_adds` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `receiving_drafts` */

insert  into `receiving_drafts`(`id`,`sku_id`,`quantity`,`remarks`,`created_at`,`updated_at`,`session_id`,`user_id`,`unit_cost`,`freight`) values 
(1,211,1000,'complete','2023-11-13 03:43:51','2023-11-13 03:44:04','65520bf2ecd71',1,405.3400,0.0000),
(2,212,1000,'complete','2023-11-13 03:43:55','2023-11-13 03:44:04','65520bf2ecd71',1,433.2000,0.0000),
(3,213,1000,'complete','2023-11-13 03:43:58','2023-11-13 03:44:04','65520bf2ecd71',1,400.0000,0.0000),
(4,214,1000,'complete','2023-11-13 03:44:02','2023-11-13 03:44:04','65520bf2ecd71',1,305.0000,0.0000),
(5,211,100,'complete','2023-12-16 20:10:09','2023-12-16 20:10:14','657e041aadd76',1,405.3400,0.0000),
(6,211,1000,'complete','2023-12-27 20:45:45','2023-12-27 20:45:47','658c8cf4c0952',1,405.3400,0.0000);

/*Table structure for table `return_good_stock_details` */

DROP TABLE IF EXISTS `return_good_stock_details`;

CREATE TABLE `return_good_stock_details` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `return_good_stock_id` bigint unsigned NOT NULL,
  `sku_id` int unsigned NOT NULL,
  `quantity` int NOT NULL,
  `unit_price` double(15,4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `confirmed_quantity` int DEFAULT NULL,
  `remarks` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scanned_by` int DEFAULT NULL,
  `user_id` int unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `return_good_stock_details_return_good_stock_id_index` (`return_good_stock_id`),
  KEY `return_good_stock_details_sku_id_index` (`sku_id`),
  KEY `return_good_stock_details_user_id_index` (`user_id`),
  CONSTRAINT `return_good_stock_details_return_good_stock_id_foreign` FOREIGN KEY (`return_good_stock_id`) REFERENCES `return_good_stocks` (`id`),
  CONSTRAINT `return_good_stock_details_sku_id_foreign` FOREIGN KEY (`sku_id`) REFERENCES `sku_adds` (`id`),
  CONSTRAINT `return_good_stock_details_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `return_good_stock_details` */

insert  into `return_good_stock_details`(`id`,`return_good_stock_id`,`sku_id`,`quantity`,`unit_price`,`created_at`,`updated_at`,`confirmed_quantity`,`remarks`,`scanned_by`,`user_id`) values 
(1,1,212,10,470.0000,'2023-11-24 13:05:10','2023-11-24 13:11:07',3,'scanned',1,1),
(2,1,213,10,400.0000,'2023-11-24 13:05:10','2023-11-24 13:11:07',4,'scanned',1,1),
(3,2,212,10,0.0000,'2024-01-08 20:53:56','2024-01-09 05:00:48',10,'scanned',1,1),
(4,2,213,10,0.0000,'2024-01-08 20:53:56','2024-01-09 05:00:48',10,'scanned',1,1);

/*Table structure for table `return_good_stock_discounts` */

DROP TABLE IF EXISTS `return_good_stock_discounts`;

CREATE TABLE `return_good_stock_discounts` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `return_good_stock_id` bigint unsigned NOT NULL,
  `discount_rate` double(5,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `return_good_stock_discounts_return_good_stock_id_index` (`return_good_stock_id`),
  CONSTRAINT `return_good_stock_discounts_return_good_stock_id_foreign` FOREIGN KEY (`return_good_stock_id`) REFERENCES `return_good_stocks` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `return_good_stock_discounts` */

insert  into `return_good_stock_discounts`(`id`,`return_good_stock_id`,`discount_rate`,`created_at`,`updated_at`) values 
(5,1,2.00,'2023-11-24 13:11:07','2023-11-24 13:11:07'),
(6,1,1.00,'2023-11-24 13:11:07','2023-11-24 13:11:07');

/*Table structure for table `return_good_stocks` */

DROP TABLE IF EXISTS `return_good_stocks`;

CREATE TABLE `return_good_stocks` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `delivery_receipt` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` int unsigned DEFAULT NULL,
  `principal_id` int unsigned DEFAULT NULL,
  `sku_type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `total_amount` double(15,4) DEFAULT NULL,
  `pcm_number` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `agent_id` bigint unsigned DEFAULT NULL,
  `customer_id` bigint unsigned DEFAULT NULL,
  `status` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `verified_date` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `verified_by` int DEFAULT NULL,
  `si_id` bigint unsigned DEFAULT NULL,
  `returned_by` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `verified_by_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `final_status` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `confirm_status` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `confirmed_by` int unsigned DEFAULT NULL,
  `confirmed_date` date DEFAULT NULL,
  `sales_return_and_allowances` decimal(15,4) DEFAULT NULL,
  `accounts_receivable` decimal(15,4) DEFAULT NULL,
  `inventory` decimal(15,4) DEFAULT NULL,
  `cost_of_goods_sold` decimal(15,4) DEFAULT NULL,
  `posted_amount` decimal(15,4) DEFAULT NULL,
  `deducted_inventory` decimal(15,4) DEFAULT NULL,
  `deducted_cost_of_goods_sold` decimal(15,4) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `return_good_stocks_user_id_index` (`user_id`),
  KEY `return_good_stocks_principal_id_index` (`principal_id`),
  KEY `return_good_stocks_agent_id_index` (`agent_id`),
  KEY `return_good_stocks_customer_id_index` (`customer_id`),
  KEY `return_good_stocks_si_id_index` (`si_id`),
  KEY `return_good_stocks_confirmed_by_index` (`confirmed_by`),
  CONSTRAINT `return_good_stocks_agent_id_foreign` FOREIGN KEY (`agent_id`) REFERENCES `agents` (`id`),
  CONSTRAINT `return_good_stocks_confirmed_by_foreign` FOREIGN KEY (`confirmed_by`) REFERENCES `users` (`id`),
  CONSTRAINT `return_good_stocks_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`),
  CONSTRAINT `return_good_stocks_principal_id_foreign` FOREIGN KEY (`principal_id`) REFERENCES `sku_principals` (`id`),
  CONSTRAINT `return_good_stocks_si_id_foreign` FOREIGN KEY (`si_id`) REFERENCES `sales_invoices` (`id`),
  CONSTRAINT `return_good_stocks_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `return_good_stocks` */

insert  into `return_good_stocks`(`id`,`delivery_receipt`,`user_id`,`principal_id`,`sku_type`,`created_at`,`updated_at`,`total_amount`,`pcm_number`,`agent_id`,`customer_id`,`status`,`verified_date`,`verified_by`,`si_id`,`returned_by`,`verified_by_name`,`final_status`,`confirm_status`,`confirmed_by`,`confirmed_date`,`sales_return_and_allowances`,`accounts_receivable`,`inventory`,`cost_of_goods_sold`,`posted_amount`,`deducted_inventory`,`deducted_cost_of_goods_sold`) values 
(1,'Previous RGS',1,2,'CASE','2023-11-24 13:05:10','2023-11-24 13:11:07',0.0000,'PCM-RGS-MAS-ALFE COMM\'L-1-0003',1,23,'verified','2023-11-24',1,1,NULL,NULL,'posted',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(2,'sample',1,2,'CASE','2024-01-08 20:53:56','2018-09-15 15:48:13',8700.0000,'PCM-RGS-MAS-ALFE COMM\'L-1-222222222',1,23,'verified','2024-01-09',1,NULL,NULL,NULL,NULL,'confirmed',1,'2018-09-15',8700.0000,8700.0000,3832.7090,3832.7090,NULL,NULL,NULL);

/*Table structure for table `return_to_principal_details` */

DROP TABLE IF EXISTS `return_to_principal_details`;

CREATE TABLE `return_to_principal_details` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `sku_id` int unsigned NOT NULL,
  `return_to_principal_id` bigint unsigned NOT NULL,
  `quantity_return` int NOT NULL,
  `unit_cost` double(15,4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `freight` double(15,4) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `return_to_principal_details_sku_id_index` (`sku_id`),
  KEY `return_to_principal_details_return_to_principal_id_index` (`return_to_principal_id`),
  CONSTRAINT `return_to_principal_details_return_to_principal_id_foreign` FOREIGN KEY (`return_to_principal_id`) REFERENCES `return_to_principals` (`id`),
  CONSTRAINT `return_to_principal_details_sku_id_foreign` FOREIGN KEY (`sku_id`) REFERENCES `sku_adds` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `return_to_principal_details` */

insert  into `return_to_principal_details`(`id`,`sku_id`,`return_to_principal_id`,`quantity_return`,`unit_cost`,`created_at`,`updated_at`,`freight`) values 
(1,211,1,10,405.3400,'2023-11-13 11:48:46','2023-11-13 11:48:46',0.0000),
(2,212,1,20,433.2000,'2023-11-13 11:48:46','2023-11-13 11:48:46',0.0000),
(3,213,1,30,400.0000,'2023-11-13 11:48:46','2023-11-13 11:48:46',0.0000),
(4,214,1,40,305.0000,'2023-11-13 11:48:46','2023-11-13 11:48:46',0.0000),
(5,211,2,10,405.3400,'2023-12-23 05:35:35','2023-12-23 05:35:35',0.0000);

/*Table structure for table `return_to_principal_jers` */

DROP TABLE IF EXISTS `return_to_principal_jers`;

CREATE TABLE `return_to_principal_jers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `return_to_principal_id` bigint unsigned NOT NULL,
  `dr` double(15,4) NOT NULL,
  `cr` double(15,4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `return_to_principal_jers_return_to_principal_id_index` (`return_to_principal_id`),
  CONSTRAINT `return_to_principal_jers_return_to_principal_id_foreign` FOREIGN KEY (`return_to_principal_id`) REFERENCES `return_to_principals` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `return_to_principal_jers` */

insert  into `return_to_principal_jers`(`id`,`return_to_principal_id`,`dr`,`cr`,`created_at`,`updated_at`) values 
(1,1,34421.7838,34421.7838,'2023-11-13 11:48:46','2023-11-13 11:48:46'),
(2,2,3779.3902,3779.3902,'2023-12-23 05:35:35','2023-12-23 05:35:35');

/*Table structure for table `return_to_principals` */

DROP TABLE IF EXISTS `return_to_principals`;

CREATE TABLE `return_to_principals` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `principal_id` int unsigned NOT NULL,
  `personnel` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `received_id` bigint unsigned NOT NULL,
  `user_id` int unsigned NOT NULL,
  `remarks` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `gross_purchase` double(15,4) NOT NULL,
  `total_less_discount` double(15,4) NOT NULL,
  `bo_discount` double(15,4) NOT NULL,
  `vatable_purchase` double(15,4) NOT NULL,
  `vat` double(15,4) NOT NULL,
  `freight` double(15,4) NOT NULL,
  `total_final_cost` double(15,4) NOT NULL,
  `total_less_other_discount` double(15,4) DEFAULT NULL,
  `net_payable` double(15,4) DEFAULT NULL,
  `cwo_discount` double(15,4) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `return_to_principals_principal_id_index` (`principal_id`),
  KEY `return_to_principals_received_id_index` (`received_id`),
  KEY `return_to_principals_user_id_index` (`user_id`),
  CONSTRAINT `return_to_principals_principal_id_foreign` FOREIGN KEY (`principal_id`) REFERENCES `sku_principals` (`id`),
  CONSTRAINT `return_to_principals_received_id_foreign` FOREIGN KEY (`received_id`) REFERENCES `received_purchase_orders` (`id`),
  CONSTRAINT `return_to_principals_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `return_to_principals` */

insert  into `return_to_principals`(`id`,`principal_id`,`personnel`,`received_id`,`user_id`,`remarks`,`created_at`,`updated_at`,`gross_purchase`,`total_less_discount`,`bo_discount`,`vatable_purchase`,`vat`,`freight`,`total_final_cost`,`total_less_other_discount`,`net_payable`,`cwo_discount`) values 
(1,2,'Mantos',1,1,NULL,'2023-11-13 11:48:46','2023-11-13 11:48:46',36917.4000,5906.7840,276.8805,30733.7355,3688.0483,0.0000,-34421.7838,NULL,NULL,0.0000),
(2,2,'Mantos',2,1,NULL,'2023-12-23 05:35:34','2023-12-23 05:35:34',4053.4000,648.5440,30.4005,3374.4555,404.9347,0.0000,-3779.3902,NULL,NULL,0.0000);

/*Table structure for table `sales_invoice_accounts_receivables` */

DROP TABLE IF EXISTS `sales_invoice_accounts_receivables`;

CREATE TABLE `sales_invoice_accounts_receivables` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int unsigned DEFAULT NULL,
  `principal_id` int unsigned DEFAULT NULL,
  `customer_id` bigint unsigned DEFAULT NULL,
  `transaction` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `all_id` int NOT NULL,
  `debit_record` double(15,4) NOT NULL,
  `credit_record` double(15,4) NOT NULL,
  `running_balance` double(15,4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sales_invoice_accounts_receivables_user_id_index` (`user_id`),
  KEY `sales_invoice_accounts_receivables_principal_id_index` (`principal_id`),
  KEY `sales_invoice_accounts_receivables_customer_id_index` (`customer_id`),
  CONSTRAINT `sales_invoice_accounts_receivables_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`),
  CONSTRAINT `sales_invoice_accounts_receivables_principal_id_foreign` FOREIGN KEY (`principal_id`) REFERENCES `sku_principals` (`id`),
  CONSTRAINT `sales_invoice_accounts_receivables_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `sales_invoice_accounts_receivables` */

insert  into `sales_invoice_accounts_receivables`(`id`,`user_id`,`principal_id`,`customer_id`,`transaction`,`all_id`,`debit_record`,`credit_record`,`running_balance`,`created_at`,`updated_at`,`status`) values 
(1,1,2,23,'sales invoice',1,7882.8750,0.0000,7882.8750,'2023-11-14 06:31:20','2023-11-14 06:31:20',NULL),
(3,1,2,23,'credit memo rgs',1,0.0000,2920.3020,4962.5730,'2023-11-24 13:11:07','2023-11-24 13:11:07',NULL),
(4,1,2,23,'collection receipt',1,0.0000,1000.0000,3962.5730,'2023-12-29 22:04:42','2023-12-29 22:04:42',NULL),
(5,1,2,23,'sales invoice',2,7882.8750,0.0000,11845.4480,'2024-01-05 04:56:55','2024-01-05 04:56:55',NULL),
(6,1,2,23,'sales invoice',3,7882.8750,0.0000,19728.3230,'2024-01-05 05:16:32','2024-01-05 05:16:32',NULL),
(7,1,2,22,'sales invoice',4,8125.0000,0.0000,8125.0000,'2024-01-05 05:20:47','2024-01-05 05:20:47',NULL),
(8,1,2,23,'collection receipt',2,0.0000,1000.0000,18728.3230,'2024-01-06 10:17:45','2024-01-06 10:17:45',NULL),
(9,1,2,23,'collection receipt',2,0.0000,500.0000,18228.3230,'2024-01-06 10:17:45','2024-01-06 10:17:45',NULL),
(10,1,2,23,'collection receipt',2,0.0000,100.0000,18128.3230,'2024-01-06 10:17:45','2024-01-06 10:17:45',NULL),
(17,1,2,23,'credit memo bo',2,0.0000,2076.2280,16052.0950,'2024-01-12 22:14:29','2024-01-12 22:14:29',NULL),
(18,1,2,23,'credit memo bo',2,0.0000,786.3450,15265.7500,'2024-01-17 08:13:50','2024-01-17 08:13:50',NULL),
(19,1,2,23,'credit memo bo',2,0.0000,786.3450,14479.4050,'2024-01-17 16:26:48','2024-01-17 16:26:48',NULL),
(20,1,2,23,'credit memo bo',2,0.0000,700.0000,13779.4050,'2024-01-18 14:10:48','2024-01-18 14:10:48',NULL),
(21,1,2,23,'credit memo bo',2,0.0000,700.0000,13079.4050,'2024-01-18 14:16:14','2024-01-18 14:16:14',NULL),
(22,1,2,23,'sales invoice',5,7882.8750,0.0000,20962.2800,'2024-01-30 14:41:18','2024-01-30 14:41:18',NULL),
(23,1,2,23,'sales invoice',6,8775.4590,0.0000,29737.7390,'2024-01-30 15:17:14','2024-01-30 15:17:14',NULL);

/*Table structure for table `sales_invoice_collection_jers` */

DROP TABLE IF EXISTS `sales_invoice_collection_jers`;

CREATE TABLE `sales_invoice_collection_jers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `sicrd_id` bigint unsigned DEFAULT NULL,
  `debit_record` double(15,4) NOT NULL,
  `credit_record` double(15,4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sales_invoice_collection_jers_sicrd_id_index` (`sicrd_id`),
  CONSTRAINT `sales_invoice_collection_jers_sicrd_id_foreign` FOREIGN KEY (`sicrd_id`) REFERENCES `sales_invoice_collection_receipts` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `sales_invoice_collection_jers` */

insert  into `sales_invoice_collection_jers`(`id`,`sicrd_id`,`debit_record`,`credit_record`,`created_at`,`updated_at`) values 
(1,1,1000.0000,1000.0000,'2023-12-29 22:04:42','2023-12-29 22:04:42'),
(2,2,1600.0000,1600.0000,'2024-01-06 10:17:45','2024-01-06 10:17:45'),
(3,3,2076.2280,2076.2280,'2024-01-12 22:06:33','2024-01-12 22:06:33'),
(4,4,2076.2280,2076.2280,'2024-01-12 22:09:05','2024-01-12 22:09:05'),
(5,5,2076.2280,2076.2280,'2024-01-12 22:09:41','2024-01-12 22:09:41'),
(6,6,2076.2280,2076.2280,'2024-01-12 22:14:29','2024-01-12 22:14:29'),
(7,7,300.0000,300.0000,'2024-01-15 08:04:52','2024-01-15 08:04:52');

/*Table structure for table `sales_invoice_collection_receipt_details` */

DROP TABLE IF EXISTS `sales_invoice_collection_receipt_details`;

CREATE TABLE `sales_invoice_collection_receipt_details` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `sicrd_id` bigint unsigned DEFAULT NULL,
  `si_id` bigint unsigned DEFAULT NULL,
  `ar_balance` double(15,4) NOT NULL,
  `amount_collected` double(15,4) NOT NULL,
  `outstanding_balance` double(15,4) NOT NULL,
  `remarks` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `payment_status` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sales_invoice_collection_receipt_details_sicrd_id_index` (`sicrd_id`),
  KEY `sales_invoice_collection_receipt_details_si_id_index` (`si_id`),
  CONSTRAINT `sales_invoice_collection_receipt_details_si_id_foreign` FOREIGN KEY (`si_id`) REFERENCES `sales_invoices` (`id`),
  CONSTRAINT `sales_invoice_collection_receipt_details_sicrd_id_foreign` FOREIGN KEY (`sicrd_id`) REFERENCES `sales_invoice_collection_receipts` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `sales_invoice_collection_receipt_details` */

insert  into `sales_invoice_collection_receipt_details`(`id`,`sicrd_id`,`si_id`,`ar_balance`,`amount_collected`,`outstanding_balance`,`remarks`,`created_at`,`updated_at`,`payment_status`) values 
(1,1,1,4962.5730,1000.0000,3962.5730,'none','2023-12-29 22:04:42','2023-12-29 22:04:42',NULL),
(2,2,1,3962.5730,1000.0000,2962.5730,'remark 1','2024-01-06 10:17:45','2024-01-06 10:17:45',NULL),
(3,2,2,7882.8750,500.0000,7382.8750,NULL,'2024-01-06 10:17:45','2024-01-06 10:17:45',NULL),
(4,2,3,7882.8750,100.0000,7782.8750,'remark 2','2024-01-06 10:17:45','2024-01-06 10:17:45',NULL),
(5,3,2,7382.8750,2076.2280,5306.6470,NULL,'2024-01-12 22:06:33','2024-01-12 22:06:33',NULL),
(6,4,2,5306.6470,2076.2280,3230.4190,NULL,'2024-01-12 22:09:05','2024-01-12 22:09:05',NULL),
(7,5,2,3230.4190,2076.2280,1154.1910,NULL,'2024-01-12 22:09:41','2024-01-12 22:09:41',NULL),
(8,6,2,3230.4190,2076.2280,1154.1910,NULL,'2024-01-12 22:14:29','2024-01-12 22:14:29',NULL),
(9,7,1,886.3450,100.0000,786.3450,NULL,'2024-01-15 08:04:52','2024-01-15 08:04:52',NULL),
(10,7,3,7782.8750,200.0000,7582.8750,NULL,'2024-01-15 08:04:52','2024-01-15 08:04:52',NULL);

/*Table structure for table `sales_invoice_collection_receipts` */

DROP TABLE IF EXISTS `sales_invoice_collection_receipts`;

CREATE TABLE `sales_invoice_collection_receipts` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int unsigned DEFAULT NULL,
  `customer_id` bigint unsigned DEFAULT NULL,
  `agent_id` bigint unsigned DEFAULT NULL,
  `check_ref_cash` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `official_receipt` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_date` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sales_invoice_collection_receipts_user_id_index` (`user_id`),
  KEY `sales_invoice_collection_receipts_customer_id_index` (`customer_id`),
  KEY `sales_invoice_collection_receipts_agent_id_index` (`agent_id`),
  CONSTRAINT `sales_invoice_collection_receipts_agent_id_foreign` FOREIGN KEY (`agent_id`) REFERENCES `agents` (`id`),
  CONSTRAINT `sales_invoice_collection_receipts_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`),
  CONSTRAINT `sales_invoice_collection_receipts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `sales_invoice_collection_receipts` */

insert  into `sales_invoice_collection_receipts`(`id`,`user_id`,`customer_id`,`agent_id`,`check_ref_cash`,`official_receipt`,`bank`,`payment_date`,`created_at`,`updated_at`) values 
(1,1,23,1,'123123','9999','CASH IN BANK - BDO','2023-12-29','2023-12-29 22:04:42','2023-12-29 22:04:42'),
(2,1,23,1,'12345','00005','CASH IN BANK - BDO','2024-01-05','2024-01-06 10:17:45','2024-01-06 10:17:45'),
(3,1,23,1,'C123123','OR123','CASH IN BANK - BDO','2024-01-12','2024-01-12 22:06:33','2024-01-12 22:06:33'),
(4,1,23,1,'C123123','OR123','CASH IN BANK - BDO','2024-01-12','2024-01-12 22:09:05','2024-01-12 22:09:05'),
(5,1,23,1,'C123123','OR123','CASH IN BANK - BDO','2024-01-12','2024-01-12 22:09:41','2024-01-12 22:09:41'),
(6,1,23,1,'C123123','OR123','CASH IN BANK - BDO','2024-01-12','2024-01-12 22:14:29','2024-01-12 22:14:29'),
(7,1,23,1,'C123123','OR123','CASH IN BANK - BDO','2024-01-15','2024-01-15 08:04:52','2024-01-15 08:04:52');

/*Table structure for table `sales_invoice_cost_of_sales` */

DROP TABLE IF EXISTS `sales_invoice_cost_of_sales`;

CREATE TABLE `sales_invoice_cost_of_sales` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int unsigned DEFAULT NULL,
  `principal_id` int unsigned DEFAULT NULL,
  `customer_id` bigint unsigned DEFAULT NULL,
  `transaction` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `all_id` int NOT NULL,
  `debit_record` double(15,4) NOT NULL,
  `credit_record` double(15,4) NOT NULL,
  `running_balance` double(15,4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sales_invoice_cost_of_sales_user_id_index` (`user_id`),
  KEY `sales_invoice_cost_of_sales_principal_id_index` (`principal_id`),
  KEY `sales_invoice_cost_of_sales_customer_id_index` (`customer_id`),
  CONSTRAINT `sales_invoice_cost_of_sales_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`),
  CONSTRAINT `sales_invoice_cost_of_sales_principal_id_foreign` FOREIGN KEY (`principal_id`) REFERENCES `sku_principals` (`id`),
  CONSTRAINT `sales_invoice_cost_of_sales_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `sales_invoice_cost_of_sales` */

insert  into `sales_invoice_cost_of_sales`(`id`,`user_id`,`principal_id`,`customer_id`,`transaction`,`all_id`,`debit_record`,`credit_record`,`running_balance`,`created_at`,`updated_at`) values 
(1,1,2,23,'sales invoice',1,5227.2226,0.0000,5227.2226,'2023-11-14 06:31:20','2023-11-14 06:31:20'),
(2,1,2,23,'sales invoice',2,3310.4802,0.0000,8537.7028,'2024-01-05 04:56:55','2024-01-05 04:56:55'),
(3,1,2,23,'sales invoice',3,3310.4802,0.0000,11848.1830,'2024-01-05 05:16:32','2024-01-05 05:16:32'),
(4,1,2,22,'sales invoice',4,3310.4802,0.0000,3310.4802,'2024-01-05 05:20:47','2024-01-05 05:20:47'),
(5,1,2,23,'sales invoice',5,5226.8347,0.0000,17075.0177,'2024-01-30 14:41:18','2024-01-30 14:41:18'),
(6,1,2,23,'sales invoice',6,5804.6486,0.0000,22879.6663,'2024-01-30 15:17:14','2024-01-30 15:17:14');

/*Table structure for table `sales_invoice_deposit_check_slips` */

DROP TABLE IF EXISTS `sales_invoice_deposit_check_slips`;

CREATE TABLE `sales_invoice_deposit_check_slips` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` bigint unsigned NOT NULL,
  `file` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sales_invoice_deposit_check_slips_customer_id_index` (`customer_id`),
  KEY `sales_invoice_deposit_check_slips_user_id_index` (`user_id`),
  CONSTRAINT `sales_invoice_deposit_check_slips_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`),
  CONSTRAINT `sales_invoice_deposit_check_slips_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `sales_invoice_deposit_check_slips` */

/*Table structure for table `sales_invoice_details` */

DROP TABLE IF EXISTS `sales_invoice_details`;

CREATE TABLE `sales_invoice_details` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `sku_id` int unsigned NOT NULL,
  `quantity` int NOT NULL,
  `unit_price` double(15,4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `sales_invoice_id` bigint unsigned NOT NULL,
  `total_amount_per_sku` double(15,4) NOT NULL,
  `remarks` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `agent_id` int NOT NULL,
  `principal_id` int unsigned DEFAULT NULL,
  `sku_type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `kilograms` double(10,4) DEFAULT NULL,
  `total_discount_per_sku` double(15,4) DEFAULT NULL,
  `quantity_returned` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sales_invoice_details_sku_id_index` (`sku_id`),
  KEY `sales_invoice_details_sales_invoice_id_index` (`sales_invoice_id`),
  KEY `sales_invoice_details_principal_id_index` (`principal_id`),
  CONSTRAINT `sales_invoice_details_principal_id_foreign` FOREIGN KEY (`principal_id`) REFERENCES `sku_principals` (`id`),
  CONSTRAINT `sales_invoice_details_sales_invoice_id_foreign` FOREIGN KEY (`sales_invoice_id`) REFERENCES `sales_invoices` (`id`),
  CONSTRAINT `sales_invoice_details_sku_id_foreign` FOREIGN KEY (`sku_id`) REFERENCES `sku_adds` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `sales_invoice_details` */

insert  into `sales_invoice_details`(`id`,`sku_id`,`quantity`,`unit_price`,`created_at`,`updated_at`,`sales_invoice_id`,`total_amount_per_sku`,`remarks`,`agent_id`,`principal_id`,`sku_type`,`kilograms`,`total_discount_per_sku`,`quantity_returned`) values 
(1,211,5,450.0000,'2023-11-14 06:31:20','2024-02-05 08:12:17',1,2182.9500,'scanned',1,2,'CASE',13.2000,67.0500,NULL),
(2,212,5,470.0000,'2023-11-14 06:31:20','2023-11-24 13:11:07',1,2279.9700,'out',1,2,'CASE',1.3000,70.0300,13),
(3,213,5,400.0000,'2023-11-14 06:31:21','2023-11-24 13:11:07',1,1940.4000,'out',1,2,'CASE',0.0000,59.6000,14),
(4,214,5,305.0000,'2023-11-14 06:31:21','2023-11-14 14:33:12',1,1479.5550,'out',1,2,'CASE',0.0000,45.4450,NULL),
(5,211,5,450.0000,'2024-01-05 04:56:55','2024-02-05 16:43:22',2,2182.9500,'out',1,2,'CASE',13.2000,67.0500,NULL),
(6,212,5,470.0000,'2024-01-05 04:56:55','2024-02-05 16:43:22',2,2279.9700,'out',1,2,'CASE',1.3000,70.0300,NULL),
(7,213,5,400.0000,'2024-01-05 04:56:55','2024-02-05 16:43:22',2,1940.4000,'out',1,2,'CASE',0.0000,59.6000,NULL),
(8,214,5,305.0000,'2024-01-05 04:56:55','2024-02-05 16:43:22',2,1479.5550,'out',1,2,'CASE',0.0000,45.4450,NULL),
(9,211,5,450.0000,'2024-01-05 05:16:32','2024-02-05 08:57:14',3,2182.9500,'scanned',1,2,'CASE',13.2000,67.0500,NULL),
(10,212,5,470.0000,'2024-01-05 05:16:32','2024-02-05 08:57:17',3,2279.9700,'scanned',1,2,'CASE',1.3000,70.0300,NULL),
(11,213,5,400.0000,'2024-01-05 05:16:32','2024-02-05 08:57:18',3,1940.4000,'scanned',1,2,'CASE',0.0000,59.6000,NULL),
(12,214,5,305.0000,'2024-01-05 05:16:32','2024-02-05 09:00:07',3,1479.5550,'scanned',1,2,'CASE',0.0000,45.4450,NULL),
(13,211,5,450.0000,'2024-01-05 05:20:47','2024-01-05 05:20:47',4,2250.0000,NULL,1,2,'CASE',13.2000,0.0000,NULL),
(14,212,5,470.0000,'2024-01-05 05:20:47','2024-01-05 05:20:47',4,2350.0000,NULL,1,2,'CASE',1.3000,0.0000,NULL),
(15,213,5,400.0000,'2024-01-05 05:20:47','2024-01-05 05:20:47',4,2000.0000,NULL,1,2,'CASE',0.0000,0.0000,NULL),
(16,214,5,305.0000,'2024-01-05 05:20:47','2024-01-05 05:20:47',4,1525.0000,NULL,1,2,'CASE',0.0000,0.0000,NULL),
(17,211,5,450.0000,'2024-01-30 14:41:18','2024-01-30 14:41:18',5,2182.9500,NULL,1,2,'CASE',13.2000,67.0500,NULL),
(18,212,5,470.0000,'2024-01-30 14:41:18','2024-01-30 14:41:18',5,2279.9700,NULL,1,2,'CASE',1.3000,70.0300,NULL),
(19,213,5,400.0000,'2024-01-30 14:41:18','2024-01-30 14:41:18',5,1940.4000,NULL,1,2,'CASE',0.0000,59.6000,NULL),
(20,214,5,305.0000,'2024-01-30 14:41:18','2024-01-30 14:41:18',5,1479.5550,NULL,1,2,'CASE',0.0000,45.4450,NULL),
(21,211,6,450.0000,'2024-01-30 15:17:14','2024-01-30 15:17:14',6,2619.5400,NULL,1,2,'CASE',13.2000,80.4600,NULL),
(22,212,6,470.0000,'2024-01-30 15:17:14','2024-01-30 15:17:14',6,2735.9640,NULL,1,2,'CASE',1.3000,84.0360,NULL),
(23,213,5,400.0000,'2024-01-30 15:17:14','2024-01-30 15:17:14',6,1940.4000,NULL,1,2,'CASE',0.0000,59.6000,NULL),
(24,214,5,305.0000,'2024-01-30 15:17:15','2024-01-30 15:17:15',6,1479.5550,NULL,1,2,'CASE',0.0000,45.4450,NULL);

/*Table structure for table `sales_invoice_jers` */

DROP TABLE IF EXISTS `sales_invoice_jers`;

CREATE TABLE `sales_invoice_jers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `sales_invoice_id` bigint unsigned DEFAULT NULL,
  `debit_record_ar` double(15,4) NOT NULL,
  `credit_record_sales` double(15,4) NOT NULL,
  `debit_record_cost_of_sales` double(15,4) NOT NULL,
  `credit_record_inventory` double(15,4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sales_invoice_jers_sales_invoice_id_index` (`sales_invoice_id`),
  CONSTRAINT `sales_invoice_jers_sales_invoice_id_foreign` FOREIGN KEY (`sales_invoice_id`) REFERENCES `sales_invoices` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `sales_invoice_jers` */

insert  into `sales_invoice_jers`(`id`,`sales_invoice_id`,`debit_record_ar`,`credit_record_sales`,`debit_record_cost_of_sales`,`credit_record_inventory`,`created_at`,`updated_at`) values 
(1,1,7882.8750,7882.8750,5227.2226,5227.2226,'2023-11-14 06:31:20','2023-11-14 06:31:20'),
(2,2,7882.8750,7882.8750,3310.4802,3310.4802,'2024-01-05 04:56:55','2024-01-05 04:56:55'),
(3,3,7882.8750,7882.8750,3310.4802,3310.4802,'2024-01-05 05:16:32','2024-01-05 05:16:32'),
(4,4,8125.0000,8125.0000,3310.4802,3310.4802,'2024-01-05 05:20:47','2024-01-05 05:20:47'),
(5,5,7882.8750,7882.8750,5226.8347,5226.8347,'2024-01-30 14:41:18','2024-01-30 14:41:18'),
(6,6,8775.4590,8775.4590,5804.6486,5804.6486,'2024-01-30 15:17:14','2024-01-30 15:17:14');

/*Table structure for table `sales_invoice_sales` */

DROP TABLE IF EXISTS `sales_invoice_sales`;

CREATE TABLE `sales_invoice_sales` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int unsigned DEFAULT NULL,
  `principal_id` int unsigned DEFAULT NULL,
  `customer_id` bigint unsigned DEFAULT NULL,
  `transaction` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `all_id` int NOT NULL,
  `debit_record` double(15,4) NOT NULL,
  `credit_record` double(15,4) NOT NULL,
  `running_balance` double(15,4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sales_invoice_sales_user_id_index` (`user_id`),
  KEY `sales_invoice_sales_principal_id_index` (`principal_id`),
  KEY `sales_invoice_sales_customer_id_index` (`customer_id`),
  CONSTRAINT `sales_invoice_sales_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`),
  CONSTRAINT `sales_invoice_sales_principal_id_foreign` FOREIGN KEY (`principal_id`) REFERENCES `sku_principals` (`id`),
  CONSTRAINT `sales_invoice_sales_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `sales_invoice_sales` */

insert  into `sales_invoice_sales`(`id`,`user_id`,`principal_id`,`customer_id`,`transaction`,`all_id`,`debit_record`,`credit_record`,`running_balance`,`created_at`,`updated_at`) values 
(1,1,2,23,'sales invoice',1,0.0000,7882.8750,7882.8750,'2023-11-14 06:31:20','2023-11-14 06:31:20'),
(2,1,2,23,'sales invoice',2,0.0000,7882.8750,15765.7500,'2024-01-05 04:56:55','2024-01-05 04:56:55'),
(3,1,2,23,'sales invoice',3,0.0000,7882.8750,23648.6250,'2024-01-05 05:16:32','2024-01-05 05:16:32'),
(4,1,2,22,'sales invoice',4,0.0000,8125.0000,8125.0000,'2024-01-05 05:20:47','2024-01-05 05:20:47'),
(5,1,2,23,'sales invoice',5,0.0000,7882.8750,31531.5000,'2024-01-30 14:41:18','2024-01-30 14:41:18'),
(6,1,2,23,'sales invoice',6,0.0000,8775.4590,40306.9590,'2024-01-30 15:17:14','2024-01-30 15:17:14');

/*Table structure for table `sales_invoice_status_logs` */

DROP TABLE IF EXISTS `sales_invoice_status_logs`;

CREATE TABLE `sales_invoice_status_logs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `sales_invoice_id` bigint unsigned NOT NULL,
  `posted` date DEFAULT NULL,
  `updated` date DEFAULT NULL,
  `status` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `no_of_days` int DEFAULT NULL,
  `user_id` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sales_invoice_status_logs_sales_invoice_id_index` (`sales_invoice_id`),
  KEY `sales_invoice_status_logs_user_id_index` (`user_id`),
  CONSTRAINT `sales_invoice_status_logs_sales_invoice_id_foreign` FOREIGN KEY (`sales_invoice_id`) REFERENCES `sales_invoices` (`id`),
  CONSTRAINT `sales_invoice_status_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `sales_invoice_status_logs` */

insert  into `sales_invoice_status_logs`(`id`,`sales_invoice_id`,`posted`,`updated`,`status`,`created_at`,`updated_at`,`no_of_days`,`user_id`) values 
(1,1,'2023-11-14','2024-01-31','Printed DR','2023-11-14 14:32:22','2024-01-31 15:48:03',78,1),
(2,2,'2024-01-31','2024-01-31','Printed DR','2024-01-31 15:24:26','2024-01-31 15:48:03',0,1),
(3,3,'2024-01-31','2024-01-31','Printed DR','2024-01-31 15:25:36','2024-01-31 15:48:03',0,1),
(22,1,'2024-01-31','2024-01-31','Printed Encoder Control','2024-01-31 15:48:03','2024-01-31 16:28:09',0,1),
(23,2,'2024-01-31','2024-01-31','Printed Encoder Control','2024-01-31 15:48:03','2024-01-31 17:45:10',0,1),
(24,3,'2024-01-31','2024-02-05','Printed Encoder Control','2024-01-31 15:48:03','2024-02-05 17:00:43',5,1),
(30,1,'2024-01-31','2024-01-31','Loadsheet','2024-01-31 16:28:09','2024-01-31 17:45:10',0,1),
(38,1,'2024-01-31','2024-02-05','Printed Loadsheet Control','2024-01-31 17:45:10','2024-02-05 15:30:12',5,1),
(39,2,'2024-01-31','2024-02-05','Printed Loadsheet Control','2024-01-31 17:45:10','2024-02-05 15:30:12',5,1),
(44,1,'2024-02-05','2024-02-05','Printed Loadsheet Control','2024-02-05 15:30:12','2024-02-05 15:32:26',0,1),
(45,2,'2024-02-05','2024-02-05','Printed Loadsheet Control','2024-02-05 15:30:12','2024-02-05 15:32:26',0,1),
(49,3,'2024-02-05','0000-00-00','Out From Warehouse','2024-02-05 17:00:43','2024-02-05 17:00:43',NULL,1);

/*Table structure for table `sales_invoices` */

DROP TABLE IF EXISTS `sales_invoices`;

CREATE TABLE `sales_invoices` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `sales_order_draft_id` bigint unsigned NOT NULL,
  `customer_id` bigint unsigned NOT NULL,
  `principal_id` int unsigned DEFAULT NULL,
  `agent_id` bigint unsigned NOT NULL,
  `user_id` int unsigned NOT NULL,
  `mode_of_transaction` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sku_type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sales_order_number` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `delivery_receipt` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `discount_rate` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `total` double(15,4) NOT NULL,
  `status` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `cancelled_date` date DEFAULT NULL,
  `cancelled_by` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `approved_by` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_weight` double(15,4) NOT NULL,
  `logistic_status` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `control` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sales_invoice_printed` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `customer_discount` double(15,4) NOT NULL,
  `delivery_status` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `delivery_date` date DEFAULT NULL,
  `delivered_date` date DEFAULT NULL,
  `payment_status` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_payment` double DEFAULT NULL,
  `truck_load_status` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_returned_amount` double(15,4) DEFAULT NULL,
  `cm_amount_deducted` decimal(15,4) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sales_invoices_sales_order_draft_id_index` (`sales_order_draft_id`),
  KEY `sales_invoices_customer_id_index` (`customer_id`),
  KEY `sales_invoices_principal_id_index` (`principal_id`),
  KEY `sales_invoices_agent_id_index` (`agent_id`),
  KEY `sales_invoices_user_id_index` (`user_id`),
  CONSTRAINT `sales_invoices_agent_id_foreign` FOREIGN KEY (`agent_id`) REFERENCES `agents` (`id`),
  CONSTRAINT `sales_invoices_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`),
  CONSTRAINT `sales_invoices_principal_id_foreign` FOREIGN KEY (`principal_id`) REFERENCES `sku_principals` (`id`),
  CONSTRAINT `sales_invoices_sales_order_draft_id_foreign` FOREIGN KEY (`sales_order_draft_id`) REFERENCES `sales_order_drafts` (`id`),
  CONSTRAINT `sales_invoices_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `sales_invoices` */

insert  into `sales_invoices`(`id`,`sales_order_draft_id`,`customer_id`,`principal_id`,`agent_id`,`user_id`,`mode_of_transaction`,`sku_type`,`sales_order_number`,`delivery_receipt`,`discount_rate`,`created_at`,`updated_at`,`total`,`status`,`cancelled_date`,`cancelled_by`,`approved_by`,`total_weight`,`logistic_status`,`control`,`sales_invoice_printed`,`customer_discount`,`delivery_status`,`delivery_date`,`delivered_date`,`payment_status`,`total_payment`,`truck_load_status`,`total_returned_amount`,`cm_amount_deducted`) values 
(1,1,23,2,1,1,'COD','CASE','SO-ALFE COMM\'L-1-2023-10-0001','E12M59136123123','2-1','2023-11-14 06:31:20','2024-01-31 16:28:09',700.0000,'out',NULL,NULL,NULL,0.0000,'','printed','2023-11-14',242.1250,'',NULL,NULL,NULL,0,'loaded',0.0000,0.0000),
(2,8,23,2,1,1,'COD','CASE','SO-ALFE COMM\'L-1-2023-10-5433323112','e123123123','2-1','2024-01-05 04:56:55','2024-02-05 16:43:22',7882.8750,'out',NULL,NULL,NULL,0.0000,'','printed','2024-01-31',242.1250,'',NULL,NULL,'paid',8804.912,'loaded',NULL,NULL),
(3,9,23,2,1,1,'COD','CASE','SO-ALFE COMM\'L-1-2023-10-11111111111111','E23123123','2-1','2024-01-05 05:16:32','2024-01-31 15:45:47',7882.8750,'printed',NULL,NULL,NULL,0.0000,'','printed','2024-01-31',242.1250,'',NULL,NULL,'partial',300,NULL,NULL,NULL),
(4,11,22,2,1,1,'COD','CASE','SO-ALFE COMM\'L-1-2023-10-0000000000000','e00000000000','none','2024-01-05 05:20:47','2024-01-30 07:57:13',8125.0000,'invoice',NULL,NULL,NULL,0.0000,'',NULL,NULL,0.0000,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(5,12,23,2,1,1,'COD','CASE','SO-ALFE COMM\'L-1-2023-10-0010','E0010','2-1','2024-01-30 14:41:18','2024-01-30 07:53:43',7882.8750,'invoice',NULL,NULL,NULL,0.0000,'',NULL,NULL,242.1250,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(6,13,23,2,1,1,'COD','CASE','SO-ALFE COMM\'L-1-2023-10-0011','E0011','2-1','2024-01-30 15:17:14','2024-01-30 07:53:43',8775.4590,'invoice',NULL,NULL,NULL,0.0000,'',NULL,NULL,269.5410,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL);

/*Table structure for table `sales_order_draft_details` */

DROP TABLE IF EXISTS `sales_order_draft_details`;

CREATE TABLE `sales_order_draft_details` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `sku_id` int unsigned NOT NULL,
  `sales_order_draft_id` bigint unsigned NOT NULL,
  `quantity` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sales_order_draft_details_sku_id_index` (`sku_id`),
  KEY `sales_order_draft_details_sales_order_draft_id_index` (`sales_order_draft_id`),
  CONSTRAINT `sales_order_draft_details_sales_order_draft_id_foreign` FOREIGN KEY (`sales_order_draft_id`) REFERENCES `sales_order_drafts` (`id`),
  CONSTRAINT `sales_order_draft_details_sku_id_foreign` FOREIGN KEY (`sku_id`) REFERENCES `sku_adds` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `sales_order_draft_details` */

insert  into `sales_order_draft_details`(`id`,`sku_id`,`sales_order_draft_id`,`quantity`,`created_at`,`updated_at`) values 
(5,211,7,5,'2023-12-25 20:45:37','2023-12-25 20:45:37'),
(6,212,7,5,'2023-12-25 20:45:37','2023-12-25 20:45:37'),
(7,213,7,5,'2023-12-25 20:45:37','2023-12-25 20:45:37'),
(8,214,7,5,'2023-12-25 20:45:37','2023-12-25 20:45:37'),
(9,211,8,5,'2024-01-05 04:04:11','2024-01-05 04:04:11'),
(10,212,8,5,'2024-01-05 04:04:11','2024-01-05 04:04:11'),
(11,213,8,5,'2024-01-05 04:04:11','2024-01-05 04:04:11'),
(12,214,8,5,'2024-01-05 04:04:11','2024-01-05 04:04:11'),
(13,211,9,5,'2024-01-05 05:15:38','2024-01-05 05:15:38'),
(14,212,9,5,'2024-01-05 05:15:38','2024-01-05 05:15:38'),
(15,213,9,5,'2024-01-05 05:15:38','2024-01-05 05:15:38'),
(16,214,9,5,'2024-01-05 05:15:38','2024-01-05 05:15:38'),
(17,211,10,5,'2024-01-05 05:15:59','2024-01-05 05:15:59'),
(18,212,10,5,'2024-01-05 05:15:59','2024-01-05 05:15:59'),
(19,213,10,5,'2024-01-05 05:15:59','2024-01-05 05:15:59'),
(20,214,10,5,'2024-01-05 05:15:59','2024-01-05 05:15:59'),
(21,211,11,5,'2024-01-05 05:17:35','2024-01-05 05:17:35'),
(22,212,11,5,'2024-01-05 05:17:35','2024-01-05 05:17:35'),
(23,213,11,5,'2024-01-05 05:17:35','2024-01-05 05:17:35'),
(24,214,11,5,'2024-01-05 05:17:35','2024-01-05 05:17:35'),
(25,211,12,5,'2024-01-30 14:40:50','2024-01-30 14:40:50'),
(26,212,12,5,'2024-01-30 14:40:50','2024-01-30 14:40:50'),
(27,213,12,5,'2024-01-30 14:40:50','2024-01-30 14:40:50'),
(28,214,12,5,'2024-01-30 14:40:50','2024-01-30 14:40:50'),
(29,211,13,5,'2024-01-30 15:16:45','2024-01-30 15:16:45'),
(30,212,13,5,'2024-01-30 15:16:45','2024-01-30 15:16:45'),
(31,213,13,5,'2024-01-30 15:16:45','2024-01-30 15:16:45'),
(32,214,13,5,'2024-01-30 15:16:45','2024-01-30 15:16:45'),
(33,211,14,5,'2024-01-30 15:17:40','2024-01-30 15:17:40'),
(34,212,14,5,'2024-01-30 15:17:40','2024-01-30 15:17:40'),
(35,213,14,5,'2024-01-30 15:17:40','2024-01-30 15:17:40'),
(36,214,14,5,'2024-01-30 15:17:40','2024-01-30 15:17:40');

/*Table structure for table `sales_order_drafts` */

DROP TABLE IF EXISTS `sales_order_drafts`;

CREATE TABLE `sales_order_drafts` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` bigint unsigned NOT NULL,
  `principal_id` int unsigned DEFAULT NULL,
  `agent_id` bigint unsigned NOT NULL,
  `user_id` int unsigned NOT NULL,
  `mode_of_transaction` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sku_type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sales_order_number` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sales_order_drafts_customer_id_index` (`customer_id`),
  KEY `sales_order_drafts_principal_id_index` (`principal_id`),
  KEY `sales_order_drafts_agent_id_index` (`agent_id`),
  KEY `sales_order_drafts_user_id_index` (`user_id`),
  CONSTRAINT `sales_order_drafts_agent_id_foreign` FOREIGN KEY (`agent_id`) REFERENCES `agents` (`id`),
  CONSTRAINT `sales_order_drafts_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`),
  CONSTRAINT `sales_order_drafts_principal_id_foreign` FOREIGN KEY (`principal_id`) REFERENCES `sku_principals` (`id`),
  CONSTRAINT `sales_order_drafts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `sales_order_drafts` */

insert  into `sales_order_drafts`(`id`,`customer_id`,`principal_id`,`agent_id`,`user_id`,`mode_of_transaction`,`sku_type`,`sales_order_number`,`created_at`,`updated_at`,`status`) values 
(7,23,2,1,1,'COD','CASE','SO-ALFE COMM\'L-1-2023-10-534234123432','2023-12-25 20:45:37','2023-12-25 20:45:37','draft'),
(8,23,2,1,1,'COD','CASE','SO-ALFE COMM\'L-1-2023-10-5433323112','2024-01-05 04:04:11','2024-01-05 04:56:55','invoice'),
(9,23,2,1,1,'COD','CASE','SO-ALFE COMM\'L-1-2023-10-11111111111111','2024-01-05 05:15:38','2024-01-05 05:16:32','invoice'),
(10,23,2,1,1,'COD','CASE','SO-ALFE COMM\'L-1-2023-10-534534523123','2024-01-05 05:15:59','2024-01-05 05:15:59','draft'),
(11,22,2,1,1,'COD','CASE','SO-ALFE COMM\'L-1-2023-10-0000000000000','2024-01-05 05:17:35','2024-01-05 05:20:47','invoice'),
(12,23,2,1,1,'COD','CASE','SO-ALFE COMM\'L-1-2023-10-0010','2024-01-30 14:40:50','2024-01-30 14:41:18','invoice'),
(13,23,2,1,1,'COD','CASE','SO-ALFE COMM\'L-1-2023-10-0011','2024-01-30 15:16:45','2024-01-30 15:17:15','invoice'),
(14,23,2,1,1,'COD','CASE','SO-ALFE COMM\'L-1-2023-10-0012','2024-01-30 15:17:40','2024-01-30 15:17:40','draft');

/*Table structure for table `sku_add_details` */

DROP TABLE IF EXISTS `sku_add_details`;

CREATE TABLE `sku_add_details` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `received_id` bigint unsigned NOT NULL,
  `sku_id` int unsigned NOT NULL,
  `discounts` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` int NOT NULL,
  `freight` double(15,4) NOT NULL,
  `unit_cost` double(15,4) NOT NULL,
  `final_unit_cost` double(15,4) NOT NULL,
  `quantity_return` int NOT NULL,
  `expiration_date` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sku_add_details_received_id_index` (`received_id`),
  KEY `sku_add_details_sku_id_index` (`sku_id`),
  CONSTRAINT `sku_add_details_received_id_foreign` FOREIGN KEY (`received_id`) REFERENCES `received_purchase_orders` (`id`),
  CONSTRAINT `sku_add_details_sku_id_foreign` FOREIGN KEY (`sku_id`) REFERENCES `sku_adds` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `sku_add_details` */

/*Table structure for table `sku_adds` */

DROP TABLE IF EXISTS `sku_adds`;

CREATE TABLE `sku_adds` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `sku_code` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_id` int unsigned DEFAULT NULL,
  `principal_id` int unsigned DEFAULT NULL,
  `unit_of_measurement` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sku_type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `equivalent_sku_entryNo` int NOT NULL,
  `equivalent_butal_pcs` int NOT NULL,
  `reorder_point` int NOT NULL,
  `remarks` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `kilograms` double(10,2) NOT NULL,
  `grams` double(10,2) NOT NULL,
  `barcode` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sub_category` int DEFAULT NULL,
  `sub_category_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sku_adds_category_id_index` (`category_id`),
  KEY `sku_adds_principal_id_index` (`principal_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1704 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `sku_adds` */

insert  into `sku_adds`(`id`,`sku_code`,`description`,`category_id`,`principal_id`,`unit_of_measurement`,`sku_type`,`equivalent_sku_entryNo`,`equivalent_butal_pcs`,`reorder_point`,`remarks`,`created_at`,`updated_at`,`kilograms`,`grams`,`barcode`,`sub_category`,`sub_category_id`) values 
(1,'40M150','GREEN CROSS ALCOHOL W/ MOISTURIZER 40% 150 ML',27,2,'BOT','BUTAL',211,48,0,'FAST MOVING ',NULL,'2023-03-23 02:02:29',3.00,0.00,'001',NULL,0),
(2,'40M250','GREEN CROSS ALCOHOL W/ MOISTURIZER 40% 250 ML',27,2,'BOT','BUTAL',212,48,0,'FAST MOVING ',NULL,'2023-03-23 02:02:38',2.30,0.00,'002',NULL,0),
(3,'40M500','GREEN CROSS ALCOHOL W/ MOISTURIZER 40% 500 ML',27,2,'BOT','BUTAL',213,24,0,'FAST MOVING ',NULL,'2023-03-23 02:02:45',0.00,0.00,'003',NULL,0),
(4,'40P150','GREEN CROSS ALCOHOL 40% 150 ML',27,2,'BOT','BUTAL',214,60,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(5,'40P250','GREEN CROSS  ALCOHOL 40% 250 ML',27,2,'BOT','BUTAL',215,60,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(6,'40P500','GREEN CROSS ALCOHOL 40% 500 ML',27,2,'BOT','BUTAL',216,36,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(7,'70D075','GREEN CROSS ETHYL ALCOHOL 70% 75 ML',27,2,'BOT','BUTAL',217,24,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(8,'70D150','GREEN CROSS ETHYL ALCOHOL 70% 150 ML',27,2,'BOT','BUTAL',218,48,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(9,'70D250','GREEN CROSS ETHYL ALCOHOL 70% 250 ML',27,2,'BOT','BUTAL',219,48,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(10,'70D3L5','GREEN CROSS ETHYL ALCOHOL 70% 3.5L',27,2,'BOT','BUTAL',220,3,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(11,'70D500','GREEN CROSS ETHYL ALCOHOL 70% 500 ML',27,2,'BOT','BUTAL',221,24,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(12,'70DGAL','GREEN CROSS ETHYL ALCOHOL 70% 3785ML',27,2,'GAL','BUTAL',222,6,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(13,'70DGLN','GREEN CROSS ETHYL ALCOHOL 70% 3785ML',27,2,'GAL','BUTAL',223,3,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(14,'70DGLO','GREEN CROSS ETHYL ALCOHOL 70% 3785ML',27,2,'GAL','BUTAL',224,3,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(15,'70F500','GC 70% ETHYL ALCOHOL PUMP 500ML',27,2,'BOT','BUTAL',225,6,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(16,'70FLIT','GC 70% ETHYL ALCOHOL PUMP 1L',27,2,'BOT','BUTAL',226,6,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(17,'70M060','GREEN CROSS ALCOHOL W/ MOISTURIZER 70% 60ML',27,2,'BOT','BUTAL',227,24,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(18,'70M150','GREEN CROSS ALCOHOL W/ MOISTURIZER 70% 150 ML',27,2,'BOT','BUTAL',228,48,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(19,'70M250','GREEN CROSS ALCOHOL W/ MOISTURIZER 70% 250 ML',27,2,'BOT','BUTAL',229,48,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(20,'70M300','GREEN CROSS ALCOHOL W/ MOISTURIZER 70% 300ML',27,2,'BOT','BUTAL',230,12,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(21,'70M500','GREEN CROSS ALCOHOL W/ MOISTURIZER 70% 500 ML',27,2,'BOT','BUTAL',231,24,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(22,'70MGAL','GC ISOPROPYL ALC W/ MOIST 70% 3785ML',27,2,'GAL','BUTAL',232,6,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(23,'70MGLN','GC ISOPROPYL ALC W/ MOIST 70% 3785ML',27,2,'GAL','BUTAL',233,3,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(24,'70N500','GC ISOPROPYL ALC W/ MOIST 70% PUMP 500ML',27,2,'BOT','BUTAL',234,6,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(25,'70NLIT','GC ISOPROPYL ALC W/ MOIST 70% PUMP 1L',27,2,'BOT','BUTAL',235,6,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(26,'70P075','GREEN CROSS  ALCOHOL 70% 75 ML',27,2,'BOT','BUTAL',236,24,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(27,'70P150','GREEN CROSS  ALCOHOL 70% 150 ML',27,2,'BOT','BUTAL',237,60,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(28,'70P250','GREEN CROSS  ALCOHOL 70% 250 ML',27,2,'BOT','BUTAL',238,60,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(29,'70P500','GREEN CROSS ALCOHOL 70% 500 ML',27,2,'BOT','BUTAL',239,36,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(30,'70PGAL','GREEN CROSS ALCOHOL 70%  3785ML',27,2,'GAL','BUTAL',240,6,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(31,'70PGLN','GREEN CROSS ALCOHOL 70%  3785ML',27,2,'GAL','BUTAL',241,3,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(32,'70Q500','GREEN CROSS ALCOHOL 70% PUMP 500ML',27,2,'BOT','BUTAL',242,6,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(33,'70QLIT','GREEN CROSS ALCOHOL 70% PUMP 1L',27,2,'BOT','BUTAL',243,6,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(34,'ATD040','GC TOTAL DEFENSE ANTIBACTERIAL HAND SPRAY 40ML',27,2,'BOT','BUTAL',244,24,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(35,'ATD250','GREEN CROSS TOTAL DEFENSE ANTIBACTERIAL SANITIZER 250ML',27,2,'BOT','BUTAL',245,48,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(36,'ATD300','GC TOTAL DEFENSE ANTIBAC SANITIZER 300ML',27,2,'BOT','BUTAL',246,12,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(37,'ATDGAL','GC TOTAL DEFENSE 3785ML',27,2,'GAL','BUTAL',247,6,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(38,'ATDGLN','GC TOTAL DEFENSE 3785ML',27,2,'GAL','BUTAL',248,3,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(39,'ATP500','GC TOTAL DEFENSE PUMP 500ML',27,2,'BOT','BUTAL',249,6,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(40,'ATPLIT','GC TOTAL DEFENSE PUMP 1L',27,2,'BOT','BUTAL',250,6,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(41,'DBBLIT','DEL FABRIC SOFTENER BLUE 1000ML',28,2,'BOT','BUTAL',251,12,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(42,'DBPLIT','DEL FABRIC SOFTENER BLUE 1000ML SUP',28,2,'PCH','BUTAL',252,12,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(43,'DBS022','DEL FABRIC SOFTENER BLUE 22ML SAC',28,2,'SCH','BUTAL',253,480,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(44,'DBS033','DEL FABRIC SOFTENER BLUE 33 ML',28,2,'SCH','BUTAL',254,336,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(45,'DBS240','DEL FABRIC SOFTENER BLUE 240ML SAC',28,2,'SCH','BUTAL',255,12,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(46,'DHPLIT','DEL GENTLE PROTECT FABRIC SOFTENER 1L SUP',28,2,'PCH','BUTAL',256,12,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(47,'DHS026','DEL GENTLE PROTECT FABRIC SOFTENER 26ML',28,2,'SCH','BUTAL',257,480,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(48,'DJPLIT','DEL FABRIC SOFTENER FOREVER JOY 1000ML SUP',28,2,'PCH','BUTAL',258,12,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(49,'DJS026','DEL FABRIC SOFTENER FOREVER JOY 26ML',28,2,'SCH','BUTAL',259,480,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(50,'DJS240','DEL FABRIC SOFTENER FOREVER JOY 240ML',28,2,'SCH','BUTAL',260,12,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(51,'DLBLIT','DEL FABRIC SOFTENER LAVENDER 1000ML',28,2,'BOT','BUTAL',261,12,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(52,'DLPLIT','DEL FABRIC SOFTENER LAVENDER 1000ML SUP',28,2,'PCH','BUTAL',262,12,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(53,'DLS022','DEL FABRIC SOFTENER LAVENDER 22ML SAC',28,2,'SCH','BUTAL',263,480,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(54,'DLS033','DEL FABRIC SOFTENER LAVENDER BREEZE 33 ML',28,2,'SCH','BUTAL',264,336,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(55,'DLS240','DEL FABRIC SOFTENER LAVENDER 240ML SAC',28,2,'SCH','BUTAL',265,12,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(56,'DOPLIT','DEL FABRIC SOFTENER FOREVER LOVE 1000ML SUP',28,2,'PCH','BUTAL',266,12,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(57,'DOS026','DEL FABRIC SOFTENER FOREVER LOVE 26ML',28,2,'SCH','BUTAL',267,480,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(58,'DOS240','DEL FABRIC SOFTENER FOREVER LOVE 240ML',28,2,'SCH','BUTAL',268,12,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(59,'DPBLIT','DEL FABRIC SOFTENER PINK 1000ML',28,2,'BOT','BUTAL',269,12,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(60,'DPPLIT','DEL FABRIC SOFTENER PINK 1000ML SUP',28,2,'PCH','BUTAL',270,12,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(61,'DPS022','DEL FABRIC SOFTENER PINK 22ML SAC',28,2,'SCH','BUTAL',271,480,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(62,'DPS033','DEL FABRIC SOFTENER PINK 33 ML',28,2,'SCH','BUTAL',272,336,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(63,'DPS240','DEL FABRIC SOFTENER PINK 240ML SAC',28,2,'SCH','BUTAL',273,12,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(64,'ENS040','GC GENTLE PROTECT NO-STING SANITIZER 40ML',27,2,'BOT','BUTAL',274,24,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(65,'ENS040M1H','GTG BUY 2PCS GC GP NO-STING SANITIZER 40ML FREE 1PC GC SANGEL BERRY 60',27,2,'BOT','BUTAL',275,7,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(66,'ENS250','GC GENTLE PROTECT NO-STING SANITIZER 250ML',27,2,'BOT','BUTAL',276,48,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(67,'GFB500','GLIDE IRONING AID FRESH BOUQUET SPRAY 500ML',40,2,'BOT','BUTAL',277,24,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(68,'GFS240','GLIDE IRONING AID FRESH BOUQUET SACHET 240ML',40,2,'BOT','BUTAL',278,12,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(69,'GNE250','GREENEX APC W/ POWER OF BLEACH LEMON 250ML',41,2,'BOT','BUTAL',279,36,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(70,'GNE500','GREENEX APC W/ POWER OF BLEACH LEMON 500ML',41,2,'BOT','BUTAL',280,12,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(71,'GNELIT','GREENEX APC W/ POWER OF BLEACH LEMON 1000ML',41,2,'BOT','BUTAL',281,12,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(72,'GNM250','GREENEX APC W/ POWER OF BLEACH COOL MENTHOL 250ML',41,2,'BOT','BUTAL',282,36,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(73,'GNM500','GREENEX APC W/ POWER OF BLEACH COOL MENTHOL 500ML',41,2,'BOT','BUTAL',283,12,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(74,'GNMLIT','GREENEX APC W/ POWER OF BLEACH COOL MENTHOL 1000ML',41,2,'BOT','BUTAL',284,12,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(75,'GNO250','GREENEX APC W/ POWER OF BLEACH ORIG 250ML',41,2,'BOT','BUTAL',285,36,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(76,'GNO500','GREENEX APC W/ POWER OF BLEACH ORIG 500ML',41,2,'BOT','BUTAL',286,12,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(77,'GNOLIT','GREENEX APC W/ POWER OF BLEACH ORIG 1000ML',41,2,'BOT','BUTAL',287,12,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(78,'GPP500','GLIDE IRONING AID 7 PURE SPRAY 500ML',40,2,'BOT','BUTAL',288,24,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(79,'GPS240','GLIDE IRONING AID 7 PURE SACHET 240ML',40,2,'BOT','BUTAL',289,12,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(80,'GSP500','GLIDE STARCH SPRAY 7 PURE SPRAY 500ML',40,2,'BOT','BUTAL',290,24,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(81,'GSS240','GLIDE STARCH SPRAY 7 PURE POUCH 240ML',40,2,'BOT','BUTAL',291,12,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(82,'HRE060','GREEN CROSS SANITIZING GEL 60ML',42,2,'BOT','BUTAL',292,24,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(83,'HREGAL','GC SANITIZING GEL REGULAR 3785ML',42,2,'GAL','BUTAL',293,6,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(84,'HREGLN','GC SANITIZING GEL REGULAR 3785ML',42,2,'GAL','BUTAL',294,3,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(85,'HRP250','GREEN CROSS SANITIZING GEL REGULAR 250ML',42,2,'BOT','BUTAL',295,12,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(86,'HRP500','GC SANITIZING GEL REGULAR PUMP 500ML',42,2,'BOT','BUTAL',296,6,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(87,'HRPLIT','GC SANITIZING GEL REGULAR PUMP 1L',42,2,'BOT','BUTAL',297,6,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(88,'HSB060','GREEN CROSS SANITIZING GEL SPARKLING BERRY 60ML',42,2,'BOT','BUTAL',298,24,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(89,'LBN025','L&P SCENTSHOP COLOGNE BLUE NAVY 25ML',31,2,'BOT','BUTAL',299,36,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(90,'LBN050','L&P SCENTSHOP COLOGNE BLUE NAVY 50ML',31,2,'BOT','BUTAL',300,36,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(91,'LBN075','L&P SCENTSHOP COLOGNE BLUE NAVY 75ML',31,2,'BOT','BUTAL',301,24,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(92,'LBN125','L&P SCENTSHOP COLOGNE BLUE NAVY 125ML',31,2,'BOT','BUTAL',302,24,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(93,'LBN125M2A','BUY L&P SCENTSHOP BLUE NAVY 125ML + 70D075 GTG',31,2,'BOT','BUTAL',303,14,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(94,'LBS070','L&P SCENTSHOP FRAGRANCE MIST CHERRY BLOSSOM 70ML',31,2,'BOT','BUTAL',304,18,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(95,'LBY075','L&P SCENTSHOP COLOGNE SPRAY BLUE NAVY 75ML',31,2,'BOT','BUTAL',305,24,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(96,'LCK025','L&P SCENTSHOP CANDY KISS 25ML',31,2,'BOT','BUTAL',306,36,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(97,'LCK050','L&P SCENTSHOP CANDY KISS 50ML',31,2,'BOT','BUTAL',307,36,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(98,'LCK075','L&P SCENTSHOP CANDY KISS 75ML',31,2,'BOT','BUTAL',308,24,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(99,'LCK125','L&P SCENTSHOP CANDY KISS 125ML',31,2,'BOT','BUTAL',309,24,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(100,'LCK125M2A','BUY L&P SCENTSHOP CANDY KISS 125ML + 70D075 GTG',31,2,'BOT','BUTAL',310,14,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(101,'LCL025','L&P SCENTSHOP COLOGNE COOL FANTASY 25ML',31,2,'BOT','BUTAL',311,36,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(102,'LCL050','L&P SCENTSHOP COLOGNE COOL FANTASY 50ML',31,2,'BOT','BUTAL',312,36,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(103,'LCL075','L&P SCENTSHOP COLOGNE COOL FANTASY 75ML',31,2,'BOT','BUTAL',313,24,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(104,'LCL125','L&P SCENTSHOP COLOGNE COOL FANTASY 125ML',31,2,'BOT','BUTAL',314,24,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(105,'LCL125M2A','BUY L&P SCENTSHOP COOL FANTASY 125ML + 70D075 GTG',31,2,'BOT','BUTAL',315,14,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(106,'LDM025','L&P SCENTSHOP COLOGNE DREAM 25ML',31,2,'BOT','BUTAL',316,36,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(107,'LDM050','L&P SCENTSHOP COLOGNE DREAM 50ML',31,2,'BOT','BUTAL',317,36,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(108,'LDM075','L&P SCENTSHOP COLOGNE DREAM 75ML',31,2,'BOT','BUTAL',318,24,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(109,'LDM125','L&P SCENTSHOP COLOGNE DREAM 125ML',31,2,'BOT','BUTAL',319,24,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(110,'LDM125M2A','BUY L&P SCENTSHOP DREAM 125ML + 70D075 GTG',31,2,'BOT','BUTAL',320,14,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(111,'LIW025','L&P SCENTSHOP COLOGNE ICE WATER 25ML',31,2,'BOT','BUTAL',321,36,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(112,'LIW050','L&P SCENTSHOP COLOGNE ICE WATER 50ML',31,2,'BOT','BUTAL',322,36,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(113,'LIW075','L&P SCENTSHOP COLOGNE ICE WATER 75ML',31,2,'BOT','BUTAL',323,24,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(114,'LIW125','L&P SCENTSHOP COLOGNE ICE WATER 125ML',31,2,'BOT','BUTAL',324,24,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(115,'LIW125M2A','BUY L&P SCENTSHOP ICE WATER 125ML + 70D075 GTG',31,2,'BOT','BUTAL',325,14,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(116,'LNE025','L&P SCENTSHOP COLOGNE NEW YORK BEATS 25ML',31,2,'BOT','BUTAL',326,36,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(117,'LNE050','L&P SCENTSHOP COLOGNE NEW YORK BEATS 50ML',31,2,'BOT','BUTAL',327,36,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(118,'LNE075','L&P SCENTSHOP COLOGNE NEW YORK BEATS 75ML',31,2,'BOT','BUTAL',328,24,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(119,'LNE125','L&P SCENTSHOP COLOGNE NEW YORK BEATS 125ML',31,2,'BOT','BUTAL',329,24,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(120,'LPN070','L&P SCENTSHOP FRAGRANCE MIST PRINCESS 70ML',31,2,'BOT','BUTAL',330,18,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(121,'LPS025','L&P SCENTSHOP PINK PASSION 25ML',31,2,'BOT','BUTAL',331,36,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(122,'LPS050','L&P SCENTSHOP PINK PASSION 50ML',31,2,'BOT','BUTAL',332,36,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(123,'LPS075','L&P SCENTSHOP PINK PASSION 75ML',31,2,'BOT','BUTAL',333,24,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(124,'LPS125','L&P SCENTSHOP PINK PASSION 125ML',31,2,'BOT','BUTAL',334,24,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(125,'LRN025','L&P SCENTSHOP COLOGNE RAIN 25ML',31,2,'BOT','BUTAL',335,36,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(126,'LRN050','L&P SCENTSHOP COLOGNE RAIN 50ML',31,2,'BOT','BUTAL',336,36,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(127,'LRN075','L&P SCENTSHOP COLOGNE RAIN 75ML',31,2,'BOT','BUTAL',337,24,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(128,'LRN125','L&P SCENTSHOP COLOGNE RAIN 125ML',31,2,'BOT','BUTAL',338,24,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(129,'LRU025','L&P SCENTSHOP RUSH 25ML',31,2,'BOT','BUTAL',339,36,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(130,'LRU050','L&P SCENTSHOP RUSH 50ML',31,2,'BOT','BUTAL',340,36,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(131,'LRU075','L&P SCENTSHOP RUSH 75ML',31,2,'BOT','BUTAL',341,24,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(132,'LRU125','L&P SCENTSHOP RUSH 125ML',31,2,'BOT','BUTAL',342,24,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(133,'LRU125M2A','BUY L&P SCENTSHOP RUSH 125ML + 70D075 GTG',31,2,'BOT','BUTAL',343,14,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(134,'LRY075','L&P SCENTSHOP COLOGNE SPRAY RUSH 75ML',31,2,'BOT','BUTAL',344,24,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(135,'LSE025','L&P SCENTSHOP COLOGNE SWEET PARIS 25ML',31,2,'BOT','BUTAL',345,36,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(136,'LSE050','L&P SCENTSHOP COLOGNE SWEET PARIS 50ML',31,2,'BOT','BUTAL',346,36,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(137,'LSE075','L&P SCENTSHOP COLOGNE SWEET PARIS 75ML',31,2,'BOT','BUTAL',347,24,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(138,'LSE125','L&P SCENTSHOP COLOGNE SWEET PARIS 125ML',31,2,'BOT','BUTAL',348,24,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(139,'LSE125M2A','BUY L&P SCENTSHOP SWEET PARIS 125ML + 70D075 GTG',31,2,'BOT','BUTAL',349,14,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(140,'LWH070','L&P SCENTSHOP FRAGRANCE MIST WISH 70ML',31,2,'BOT','BUTAL',350,18,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(141,'PCH050','L&P FACE & BODY 7 CHILL 50G',32,2,'BOT','BUTAL',351,36,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(142,'PJG050','L&P BODY & FACE 7 JASMIN GARDEN 50G',32,2,'BOT','BUTAL',352,36,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(143,'PRL050','L&P BODY & FACE 7 ROSE AND LILY 50G',32,2,'BOT','BUTAL',353,36,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(144,'PRN050','L&P FACE & BODY 7 RAIN 50G',32,2,'BOT','BUTAL',354,36,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(145,'PZYX06M4P','BUY 1PC PWB050, 1PC PCH050, 1PC PRL050 FREE 1PC PRL050',32,2,'BOT','BUTAL',355,9,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(146,'SAC055','GC MOIST PROTECTION 9 AQUA CLEAN 55G',43,2,'PCS','BUTAL',356,72,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(147,'SAC085','GC MOIST PROTECTION 9 AQUA CLEAN 85G',43,2,'PCS','BUTAL',357,60,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(148,'SAC125','GC MOIST PROTECTION 9 AQUA CLEAN 125G',43,2,'PCS','BUTAL',358,48,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(149,'SCM055','GC MOIST PROTECTION 9 COOL MOUNTAIN 55G',43,2,'PCS','BUTAL',359,72,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(150,'SCM085','GC MOIST PROTECTION 9 COOL MOUNTAIN 85G',43,2,'PCS','BUTAL',360,60,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(151,'SCM125','GC MOIST PROTECTION 9 COOL MOUNTAIN 125G',43,2,'PCS','BUTAL',361,48,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(152,'SCR055','GC MOIST PROTECTION 9 CLEAR RADIANCE 55G',43,2,'PCS','BUTAL',362,72,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(153,'SCR085','GC MOIST PROTECTION 9 CLEAR RADIANCE 85G',43,2,'PCS','BUTAL',363,60,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(154,'SCR125','GC MOIST PROTECTION 9 CLEAR RADIANCE 125G',43,2,'PCS','BUTAL',364,48,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(155,'SPC055','GC MOIST PROTECTION 9 PURE CARE 55G',43,2,'PCS','BUTAL',365,72,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(156,'SPC085','GC MOIST PROTECTION 9 PURE CARE 85G',43,2,'PCS','BUTAL',366,60,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(157,'SPC125','GC MOIST PROTECTION 9 PURE CARE 125G',43,2,'PCS','BUTAL',367,48,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(158,'SPH055','GC MOIST PROTECTION 9 PAPAYA & HONEY 55G',43,2,'PCS','BUTAL',368,72,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(159,'SPH085','GC MOIST PROTECTION 9 PAPAYA & HONEY 85G',43,2,'PCS','BUTAL',369,60,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(160,'SPH125','GC MOIST PROTECTION 9 PAPAYA & HONEY 125G',43,2,'PCS','BUTAL',370,48,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(161,'XCO030','ZONROX COLORSAFE BLEACH BLOSSOM FRESH 30ML',34,2,'SCH','BUTAL',371,360,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(162,'XCO095','ZONROX COLORSAFE BLEACH BLOSSOM FRESH 95ML',34,2,'BOT','BUTAL',372,72,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(163,'XCO225','ZONROX COLORSAFE BLEACH BLOSSOM FRESH 225ML',34,2,'BOT','BUTAL',373,48,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(164,'XCO450','ZONROX COLORSAFE BLEACH BLOSSOM FRESH 450ML',34,2,'BOT','BUTAL',374,36,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(165,'XCO900','ZONROX COLORSAFE BLEACH BLOSSOM FRESH 900ML',34,2,'BOT','BUTAL',375,24,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(166,'XCOGAL','ZONROX COLORSAFE BLEACH 3600 ML',34,2,'GAL','BUTAL',376,3,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(167,'ZFR.5G','ZONROX SCENTED FRESH 1/2 GAL',34,2,'BOT','BUTAL',377,12,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(168,'ZFR.5L','ZONROX SCENTED FRESH 500 ML',34,2,'BOT','BUTAL',378,36,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(169,'ZFR4OZ','ZONROX SCENTED FRESH 100 ML',34,2,'BOT','BUTAL',379,72,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(170,'ZFR8OZ','ZONROX SCENTED FRESH 250 ML',34,2,'BOT','BUTAL',380,48,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(171,'ZFRGAL','ZONROX SCENTED FRESH GAL',34,2,'GAL','BUTAL',381,6,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(172,'ZFRGLN','ZONROX SCENTED FRESH GAL',34,2,'GAL','BUTAL',382,3,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(173,'ZFRLIT','ZONROX SCENTED FRESH 1 LITER',34,2,'BOT','BUTAL',383,24,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(174,'ZGC095','ZONROX GENTLE CLEAN BLEACH 95ML',34,2,'BOT','BUTAL',384,72,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(175,'ZGC225','ZONROX GENTLE CLEAN BLEACH 225ML',34,2,'BOT','BUTAL',385,48,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(176,'ZGC450','ZONROX GENTLE CLEAN BLEACH 450ML',34,2,'BOT','BUTAL',386,36,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(177,'ZGC900','ZONROX GENTLE CLEAN BLEACH 900ML',34,2,'BOT','BUTAL',387,24,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(178,'ZLE.5G','ZONROX SCENTED LEMON 1/2 GAL',34,2,'BOT','BUTAL',388,12,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(179,'ZLE.5L','ZONROX SCENTED LEMON 500 ML',34,2,'BOT','BUTAL',389,36,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(180,'ZLE4OZ','ZONROX SCENTED LEMON 100 ML',34,2,'BOT','BUTAL',390,72,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(181,'ZLE8OZ','ZONROX SCENTED LEMON 250 ML',34,2,'BOT','BUTAL',391,48,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(182,'ZLEGAL','ZONROX SCENTED LEMON GAL',34,2,'GAL','BUTAL',392,6,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(183,'ZLEGLN','ZONROX SCENTED LEMON GAL',34,2,'GAL','BUTAL',393,3,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(184,'ZLELIT','ZONROX SCENTED LEMON 1 LITER',34,2,'BOT','BUTAL',394,24,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(185,'ZML450','ZONROX MULTI CLEAN LEMON SPLASH 450ML',34,2,'BOT','BUTAL',395,12,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(186,'ZML450M2X','BUY 1PC ZMC LEMON 450ML FREE 3PCS ZNRX COLORSAFE BLOSSOM 30ML',34,2,'BOT','BUTAL',396,9,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(187,'ZML900','ZONROX MULTI CLEAN LEMON SPLASH 900ML',34,2,'BOT','BUTAL',397,12,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(188,'ZML900M2X','BUY 1PC ZMC LEMON 900ML FREE 3PCS ZNRX COLORSAFE BLOSSOM 225ML',34,2,'BOT','BUTAL',398,8,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(189,'ZMR450','ZONROX MULTI CLEAN FLORAL BLAST 450ML',34,2,'BOT','BUTAL',399,12,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(190,'ZMR450M2X','BUY 1PC ZMC FLORAL 450ML FREE 3PCS ZNRX COLORSAFE BLOSSOM 30ML',34,2,'BOT','BUTAL',400,9,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(191,'ZMR900','ZONROX MULTI CLEAN FLORAL BLAST 900ML',34,2,'BOT','BUTAL',401,12,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(192,'ZMR900M2X','BUY 1PC ZMC FLORAL 900ML FREE 3PCS ZNRX COLORSAFE BLOSSOM 225ML',34,2,'BOT','BUTAL',402,8,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(193,'ZON.5G','ZONROX BLEACH ORIGINAL 1/2 GAL',34,2,'BOT','BUTAL',403,12,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(194,'ZON.5L','ZONROX BLEACH ORIGINAL 500 ML',34,2,'BOT','BUTAL',404,36,0,'FAST MOVING ',NULL,'2023-02-17 17:36:19',0.00,0.00,'4800011736044',NULL,0),
(195,'ZON4OZ','ZONROX BLEACH ORIGINAL 100 ML',34,2,'BOT','BUTAL',405,72,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(196,'ZON8OZ','ZONROX BLEACH ORIGINAL 250 ML',34,2,'BOT','BUTAL',406,48,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(197,'ZONGAL','ZONROX BLEACH ORIGINAL GAL',34,2,'GAL','BUTAL',407,6,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(198,'ZONGLN','ZONROX BLEACH ORIGINAL GAL',34,2,'GAL','BUTAL',408,3,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(199,'ZONLIT','ZONROX BLEACH ORIGINAL 1 LITER',34,2,'BOT','BUTAL',409,24,0,'FAST MOVING ',NULL,'2023-02-17 17:36:05',0.00,0.00,'4800011159034',NULL,0),
(200,'ZPL095','ZONROX PLUS 95ML',34,2,'BOT','BUTAL',410,72,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(201,'ZPL225','ZONROX PLUS 225ML',34,2,'BOT','BUTAL',411,48,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(202,'ZPL450','ZONROX PLUS 450ML',34,2,'BOT','BUTAL',412,36,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(203,'ZPL900','ZONROX PLUS 900ML',34,2,'BOT','BUTAL',413,24,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(204,'ZRL.5G','ZONROX SCENTED FLORAL 1/2 GAL',34,2,'BOT','BUTAL',414,12,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(205,'ZRL.5L','ZONROX SCENTED FLORAL 500 ML',34,2,'BOT','BUTAL',415,36,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(206,'ZRL4OZ','ZONROX SCENTED FLORAL 100 ML',34,2,'BOT','BUTAL',416,72,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(207,'ZRL8OZ','ZONROX SCENTED FLORAL 250 ML',34,2,'BOT','BUTAL',417,48,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(208,'ZRLGAL','ZONROX SCENTED FLORAL GAL',34,2,'GAL','BUTAL',418,6,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(209,'ZRLGLN','ZONROX SCENTED FLORAL GAL',34,2,'GAL','BUTAL',419,3,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(210,'ZRLLIT','ZONROX SCENTED FLORAL 1 LITER',34,2,'BOT','BUTAL',420,24,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(211,'40M150','GREEN CROSS ALCOHOL W/ MOISTURIZER 40% 150 ML',27,2,'CASE','CASE',1,48,0,'FAST MOVING ',NULL,'2023-03-23 02:01:58',13.20,0.00,'01',NULL,0),
(212,'40M250','GREEN CROSS ALCOHOL W/ MOISTURIZER 40% 250 ML',27,2,'CASE','CASE',2,48,0,'FAST MOVING ',NULL,'2023-03-23 02:02:13',1.30,0.00,'02',NULL,0),
(213,'40M500','GREEN CROSS ALCOHOL W/ MOISTURIZER 40% 500 ML',27,2,'CASE','CASE',3,24,0,'FAST MOVING ',NULL,'2023-03-23 02:02:21',0.00,0.00,'03',NULL,0),
(214,'40P150','GREEN CROSS ALCOHOL 40% 150 ML',27,2,'CASE','CASE',4,60,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(215,'40P250','GREEN CROSS  ALCOHOL 40% 250 ML',27,2,'CASE','CASE',5,60,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(216,'40P500','GREEN CROSS ALCOHOL 40% 500 ML',27,2,'CASE','CASE',6,36,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(217,'70D075','GREEN CROSS ETHYL ALCOHOL 70% 75 ML',27,2,'CASE','CASE',7,24,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(218,'70D150','GREEN CROSS ETHYL ALCOHOL 70% 150 ML',27,2,'CASE','CASE',8,48,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(219,'70D250','GREEN CROSS ETHYL ALCOHOL 70% 250 ML',27,2,'CASE','CASE',9,48,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(220,'70D3L5','GREEN CROSS ETHYL ALCOHOL 70% 3.5L',27,2,'CASE','CASE',10,3,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(221,'70D500','GREEN CROSS ETHYL ALCOHOL 70% 500 ML',27,2,'CASE','CASE',11,24,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(222,'70DGAL','GREEN CROSS ETHYL ALCOHOL 70% 3785ML',27,2,'GAL','CASE',12,6,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(223,'70DGLN','GREEN CROSS ETHYL ALCOHOL 70% 3785ML',27,2,'GAL','CASE',13,3,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(224,'70DGLO','GREEN CROSS ETHYL ALCOHOL 70% 3785ML',27,2,'GAL','CASE',14,3,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(225,'70F500','GC 70% ETHYL ALCOHOL PUMP 500ML',27,2,'BOT','CASE',15,6,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(226,'70FLIT','GC 70% ETHYL ALCOHOL PUMP 1L',27,2,'BOT','CASE',16,6,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(227,'70M060','GREEN CROSS ALCOHOL W/ MOISTURIZER 70% 60ML',27,2,'BOT','CASE',17,24,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(228,'70M150','GREEN CROSS ALCOHOL W/ MOISTURIZER 70% 150 ML',27,2,'BOT','CASE',18,48,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(229,'70M250','GREEN CROSS ALCOHOL W/ MOISTURIZER 70% 250 ML',27,2,'BOT','CASE',19,48,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(230,'70M300','GREEN CROSS ALCOHOL W/ MOISTURIZER 70% 300ML',27,2,'BOT','CASE',20,12,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(231,'70M500','GREEN CROSS ALCOHOL W/ MOISTURIZER 70% 500 ML',27,2,'BOT','CASE',21,24,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(232,'70MGAL','GC ISOPROPYL ALC W/ MOIST 70% 3785ML',27,2,'GAL','CASE',22,6,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(233,'70MGLN','GC ISOPROPYL ALC W/ MOIST 70% 3785ML',27,2,'GAL','CASE',23,3,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(234,'70N500','GC ISOPROPYL ALC W/ MOIST 70% PUMP 500ML',27,2,'BOT','CASE',24,6,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(235,'70NLIT','GC ISOPROPYL ALC W/ MOIST 70% PUMP 1L',27,2,'BOT','CASE',25,6,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(236,'70P075','GREEN CROSS  ALCOHOL 70% 75 ML',27,2,'BOT','CASE',26,24,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(237,'70P150','GREEN CROSS  ALCOHOL 70% 150 ML',27,2,'BOT','CASE',27,60,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(238,'70P250','GREEN CROSS  ALCOHOL 70% 250 ML',27,2,'BOT','CASE',28,60,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(239,'70P500','GREEN CROSS ALCOHOL 70% 500 ML',27,2,'BOT','CASE',29,36,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(240,'70PGAL','GREEN CROSS ALCOHOL 70%  3785ML',27,2,'GAL','CASE',30,6,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(241,'70PGLN','GREEN CROSS ALCOHOL 70%  3785ML',27,2,'GAL','CASE',31,3,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(242,'70Q500','GREEN CROSS ALCOHOL 70% PUMP 500ML',27,2,'BOT','CASE',32,6,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(243,'70QLIT','GREEN CROSS ALCOHOL 70% PUMP 1L',27,2,'BOT','CASE',33,6,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(244,'ATD040','GC TOTAL DEFENSE ANTIBACTERIAL HAND SPRAY 40ML',27,2,'BOT','CASE',34,24,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(245,'ATD250','GREEN CROSS TOTAL DEFENSE ANTIBACTERIAL SANITIZER 250ML',27,2,'BOT','CASE',35,48,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(246,'ATD300','GC TOTAL DEFENSE ANTIBAC SANITIZER 300ML',27,2,'BOT','CASE',36,12,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(247,'ATDGAL','GC TOTAL DEFENSE 3785ML',27,2,'GAL','CASE',37,6,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(248,'ATDGLN','GC TOTAL DEFENSE 3785ML',27,2,'GAL','CASE',38,3,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(249,'ATP500','GC TOTAL DEFENSE PUMP 500ML',27,2,'BOT','CASE',39,6,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(250,'ATPLIT','GC TOTAL DEFENSE PUMP 1L',27,2,'BOT','CASE',40,6,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(251,'DBBLIT','DEL FABRIC SOFTENER BLUE 1000ML',28,2,'BOT','CASE',41,12,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(252,'DBPLIT','DEL FABRIC SOFTENER BLUE 1000ML SUP',28,2,'PCH','CASE',42,12,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(253,'DBS022','DEL FABRIC SOFTENER BLUE 22ML SAC',28,2,'SCH','CASE',43,480,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(254,'DBS033','DEL FABRIC SOFTENER BLUE 33 ML',28,2,'SCH','CASE',44,336,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(255,'DBS240','DEL FABRIC SOFTENER BLUE 240ML SAC',28,2,'SCH','CASE',45,12,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(256,'DHPLIT','DEL GENTLE PROTECT FABRIC SOFTENER 1L SUP',28,2,'PCH','CASE',46,12,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(257,'DHS026','DEL GENTLE PROTECT FABRIC SOFTENER 26ML',28,2,'SCH','CASE',47,480,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(258,'DJPLIT','DEL FABRIC SOFTENER FOREVER JOY 1000ML SUP',28,2,'PCH','CASE',48,12,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(259,'DJS026','DEL FABRIC SOFTENER FOREVER JOY 26ML',28,2,'SCH','CASE',49,480,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(260,'DJS240','DEL FABRIC SOFTENER FOREVER JOY 240ML',28,2,'SCH','CASE',50,12,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(261,'DLBLIT','DEL FABRIC SOFTENER LAVENDER 1000ML',28,2,'BOT','CASE',51,12,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(262,'DLPLIT','DEL FABRIC SOFTENER LAVENDER 1000ML SUP',28,2,'PCH','CASE',52,12,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(263,'DLS022','DEL FABRIC SOFTENER LAVENDER 22ML SAC',28,2,'SCH','CASE',53,480,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(264,'DLS033','DEL FABRIC SOFTENER LAVENDER BREEZE 33 ML',28,2,'SCH','CASE',54,336,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(265,'DLS240','DEL FABRIC SOFTENER LAVENDER 240ML SAC',28,2,'SCH','CASE',55,12,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(266,'DOPLIT','DEL FABRIC SOFTENER FOREVER LOVE 1000ML SUP',28,2,'PCH','CASE',56,12,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(267,'DOS026','DEL FABRIC SOFTENER FOREVER LOVE 26ML',28,2,'SCH','CASE',57,480,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(268,'DOS240','DEL FABRIC SOFTENER FOREVER LOVE 240ML',28,2,'SCH','CASE',58,12,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(269,'DPBLIT','DEL FABRIC SOFTENER PINK 1000ML',28,2,'BOT','CASE',59,12,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(270,'DPPLIT','DEL FABRIC SOFTENER PINK 1000ML SUP',28,2,'PCH','CASE',60,12,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(271,'DPS022','DEL FABRIC SOFTENER PINK 22ML SAC',28,2,'SCH','CASE',61,480,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(272,'DPS033','DEL FABRIC SOFTENER PINK 33 ML',28,2,'SCH','CASE',62,336,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(273,'DPS240','DEL FABRIC SOFTENER PINK 240ML SAC',28,2,'SCH','CASE',63,12,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(274,'ENS040','GC GENTLE PROTECT NO-STING SANITIZER 40ML',27,2,'BOT','CASE',64,24,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(275,'ENS040M1H','GTG BUY 2PCS GC GP NO-STING SANITIZER 40ML FREE 1PC GC SANGEL BERRY 60',27,2,'BOT','CASE',65,7,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(276,'ENS250','GC GENTLE PROTECT NO-STING SANITIZER 250ML',27,2,'BOT','CASE',66,48,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(277,'GFB500','GLIDE IRONING AID FRESH BOUQUET SPRAY 500ML',40,2,'BOT','CASE',67,24,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(278,'GFS240','GLIDE IRONING AID FRESH BOUQUET SACHET 240ML',40,2,'BOT','CASE',68,12,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(279,'GNE250','GREENEX APC W/ POWER OF BLEACH LEMON 250ML',41,2,'BOT','CASE',69,36,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(280,'GNE500','GREENEX APC W/ POWER OF BLEACH LEMON 500ML',41,2,'BOT','CASE',70,12,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(281,'GNELIT','GREENEX APC W/ POWER OF BLEACH LEMON 1000ML',41,2,'BOT','CASE',71,12,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(282,'GNM250','GREENEX APC W/ POWER OF BLEACH COOL MENTHOL 250ML',41,2,'BOT','CASE',72,36,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(283,'GNM500','GREENEX APC W/ POWER OF BLEACH COOL MENTHOL 500ML',41,2,'BOT','CASE',73,12,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(284,'GNMLIT','GREENEX APC W/ POWER OF BLEACH COOL MENTHOL 1000ML',41,2,'BOT','CASE',74,12,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(285,'GNO250','GREENEX APC W/ POWER OF BLEACH ORIG 250ML',41,2,'BOT','CASE',75,36,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(286,'GNO500','GREENEX APC W/ POWER OF BLEACH ORIG 500ML',41,2,'BOT','CASE',76,12,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(287,'GNOLIT','GREENEX APC W/ POWER OF BLEACH ORIG 1000ML',41,2,'BOT','CASE',77,12,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(288,'GPP500','GLIDE IRONING AID 7 PURE SPRAY 500ML',40,2,'BOT','CASE',78,24,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(289,'GPS240','GLIDE IRONING AID 7 PURE SACHET 240ML',40,2,'BOT','CASE',79,12,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(290,'GSP500','GLIDE STARCH SPRAY 7 PURE SPRAY 500ML',40,2,'BOT','CASE',80,24,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(291,'GSS240','GLIDE STARCH SPRAY 7 PURE POUCH 240ML',40,2,'BOT','CASE',81,12,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(292,'HRE060','GREEN CROSS SANITIZING GEL 60ML',42,2,'BOT','CASE',82,24,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(293,'HREGAL','GC SANITIZING GEL REGULAR 3785ML',42,2,'GAL','CASE',83,6,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(294,'HREGLN','GC SANITIZING GEL REGULAR 3785ML',42,2,'GAL','CASE',84,3,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(295,'HRP250','GREEN CROSS SANITIZING GEL REGULAR 250ML',42,2,'BOT','CASE',85,12,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(296,'HRP500','GC SANITIZING GEL REGULAR PUMP 500ML',42,2,'BOT','CASE',86,6,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(297,'HRPLIT','GC SANITIZING GEL REGULAR PUMP 1L',42,2,'BOT','CASE',87,6,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(298,'HSB060','GREEN CROSS SANITIZING GEL SPARKLING BERRY 60ML',42,2,'BOT','CASE',88,24,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(299,'LBN025','L&P SCENTSHOP COLOGNE BLUE NAVY 25ML',31,2,'BOT','CASE',89,36,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(300,'LBN050','L&P SCENTSHOP COLOGNE BLUE NAVY 50ML',31,2,'BOT','CASE',90,36,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(301,'LBN075','L&P SCENTSHOP COLOGNE BLUE NAVY 75ML',31,2,'BOT','CASE',91,24,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(302,'LBN125','L&P SCENTSHOP COLOGNE BLUE NAVY 125ML',31,2,'BOT','CASE',92,24,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(303,'LBN125M2A','BUY L&P SCENTSHOP BLUE NAVY 125ML + 70D075 GTG',31,2,'BOT','CASE',93,14,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(304,'LBS070','L&P SCENTSHOP FRAGRANCE MIST CHERRY BLOSSOM 70ML',31,2,'BOT','CASE',94,18,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(305,'LBY075','L&P SCENTSHOP COLOGNE SPRAY BLUE NAVY 75ML',31,2,'BOT','CASE',95,24,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(306,'LCK025','L&P SCENTSHOP CANDY KISS 25ML',31,2,'BOT','CASE',96,36,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(307,'LCK050','L&P SCENTSHOP CANDY KISS 50ML',31,2,'BOT','CASE',97,36,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(308,'LCK075','L&P SCENTSHOP CANDY KISS 75ML',31,2,'BOT','CASE',98,24,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(309,'LCK125','L&P SCENTSHOP CANDY KISS 125ML',31,2,'BOT','CASE',99,24,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(310,'LCK125M2A','BUY L&P SCENTSHOP CANDY KISS 125ML + 70D075 GTG',31,2,'BOT','CASE',100,14,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(311,'LCL025','L&P SCENTSHOP COLOGNE COOL FANTASY 25ML',31,2,'BOT','CASE',101,36,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(312,'LCL050','L&P SCENTSHOP COLOGNE COOL FANTASY 50ML',31,2,'BOT','CASE',102,36,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(313,'LCL075','L&P SCENTSHOP COLOGNE COOL FANTASY 75ML',31,2,'BOT','CASE',103,24,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(314,'LCL125','L&P SCENTSHOP COLOGNE COOL FANTASY 125ML',31,2,'BOT','CASE',104,24,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(315,'LCL125M2A','BUY L&P SCENTSHOP COOL FANTASY 125ML + 70D075 GTG',31,2,'BOT','CASE',105,14,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(316,'LDM025','L&P SCENTSHOP COLOGNE DREAM 25ML',31,2,'BOT','CASE',106,36,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(317,'LDM050','L&P SCENTSHOP COLOGNE DREAM 50ML',31,2,'BOT','CASE',107,36,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(318,'LDM075','L&P SCENTSHOP COLOGNE DREAM 75ML',31,2,'BOT','CASE',108,24,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(319,'LDM125','L&P SCENTSHOP COLOGNE DREAM 125ML',31,2,'BOT','CASE',109,24,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(320,'LDM125M2A','BUY L&P SCENTSHOP DREAM 125ML + 70D075 GTG',31,2,'BOT','CASE',110,14,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(321,'LIW025','L&P SCENTSHOP COLOGNE ICE WATER 25ML',31,2,'BOT','CASE',111,36,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(322,'LIW050','L&P SCENTSHOP COLOGNE ICE WATER 50ML',31,2,'BOT','CASE',112,36,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(323,'LIW075','L&P SCENTSHOP COLOGNE ICE WATER 75ML',31,2,'BOT','CASE',113,24,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(324,'LIW125','L&P SCENTSHOP COLOGNE ICE WATER 125ML',31,2,'BOT','CASE',114,24,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(325,'LIW125M2A','BUY L&P SCENTSHOP ICE WATER 125ML + 70D075 GTG',31,2,'BOT','CASE',115,14,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(326,'LNE025','L&P SCENTSHOP COLOGNE NEW YORK BEATS 25ML',31,2,'BOT','CASE',116,36,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(327,'LNE050','L&P SCENTSHOP COLOGNE NEW YORK BEATS 50ML',31,2,'BOT','CASE',117,36,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(328,'LNE075','L&P SCENTSHOP COLOGNE NEW YORK BEATS 75ML',31,2,'BOT','CASE',118,24,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(329,'LNE125','L&P SCENTSHOP COLOGNE NEW YORK BEATS 125ML',31,2,'BOT','CASE',119,24,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(330,'LPN070','L&P SCENTSHOP FRAGRANCE MIST PRINCESS 70ML',31,2,'BOT','CASE',120,18,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(331,'LPS025','L&P SCENTSHOP PINK PASSION 25ML',31,2,'BOT','CASE',121,36,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(332,'LPS050','L&P SCENTSHOP PINK PASSION 50ML',31,2,'BOT','CASE',122,36,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(333,'LPS075','L&P SCENTSHOP PINK PASSION 75ML',31,2,'BOT','CASE',123,24,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(334,'LPS125','L&P SCENTSHOP PINK PASSION 125ML',31,2,'BOT','CASE',124,24,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(335,'LRN025','L&P SCENTSHOP COLOGNE RAIN 25ML',31,2,'BOT','CASE',125,36,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(336,'LRN050','L&P SCENTSHOP COLOGNE RAIN 50ML',31,2,'BOT','CASE',126,36,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(337,'LRN075','L&P SCENTSHOP COLOGNE RAIN 75ML',31,2,'BOT','CASE',127,24,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(338,'LRN125','L&P SCENTSHOP COLOGNE RAIN 125ML',31,2,'BOT','CASE',128,24,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(339,'LRU025','L&P SCENTSHOP RUSH 25ML',31,2,'BOT','CASE',129,36,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(340,'LRU050','L&P SCENTSHOP RUSH 50ML',31,2,'BOT','CASE',130,36,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(341,'LRU075','L&P SCENTSHOP RUSH 75ML',31,2,'BOT','CASE',131,24,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(342,'LRU125','L&P SCENTSHOP RUSH 125ML',31,2,'BOT','CASE',132,24,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(343,'LRU125M2A','BUY L&P SCENTSHOP RUSH 125ML + 70D075 GTG',31,2,'BOT','CASE',133,14,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(344,'LRY075','L&P SCENTSHOP COLOGNE SPRAY RUSH 75ML',31,2,'BOT','CASE',134,24,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(345,'LSE025','L&P SCENTSHOP COLOGNE SWEET PARIS 25ML',31,2,'BOT','CASE',135,36,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(346,'LSE050','L&P SCENTSHOP COLOGNE SWEET PARIS 50ML',31,2,'BOT','CASE',136,36,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(347,'LSE075','L&P SCENTSHOP COLOGNE SWEET PARIS 75ML',31,2,'BOT','CASE',137,24,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(348,'LSE125','L&P SCENTSHOP COLOGNE SWEET PARIS 125ML',31,2,'BOT','CASE',138,24,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(349,'LSE125M2A','BUY L&P SCENTSHOP SWEET PARIS 125ML + 70D075 GTG',31,2,'BOT','CASE',139,14,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(350,'LWH070','L&P SCENTSHOP FRAGRANCE MIST WISH 70ML',31,2,'BOT','CASE',140,18,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(351,'PCH050','L&P FACE & BODY 7 CHILL 50G',32,2,'BOT','CASE',141,36,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(352,'PJG050','L&P BODY & FACE 7 JASMIN GARDEN 50G',32,2,'BOT','CASE',142,36,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(353,'PRL050','L&P BODY & FACE 7 ROSE AND LILY 50G',32,2,'BOT','CASE',143,36,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(354,'PRN050','L&P FACE & BODY 7 RAIN 50G',32,2,'BOT','CASE',144,36,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(355,'PZYX06M4P','BUY 1PC PWB050, 1PC PCH050, 1PC PRL050 FREE 1PC PRL050',32,2,'BOT','CASE',145,9,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(356,'SAC055','GC MOIST PROTECTION 9 AQUA CLEAN 55G',43,2,'PCS','CASE',146,72,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(357,'SAC085','GC MOIST PROTECTION 9 AQUA CLEAN 85G',43,2,'PCS','CASE',147,60,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(358,'SAC125','GC MOIST PROTECTION 9 AQUA CLEAN 125G',43,2,'PCS','CASE',148,48,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(359,'SCM055','GC MOIST PROTECTION 9 COOL MOUNTAIN 55G',43,2,'PCS','CASE',149,72,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(360,'SCM085','GC MOIST PROTECTION 9 COOL MOUNTAIN 85G',43,2,'PCS','CASE',150,60,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(361,'SCM125','GC MOIST PROTECTION 9 COOL MOUNTAIN 125G',43,2,'PCS','CASE',151,48,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(362,'SCR055','GC MOIST PROTECTION 9 CLEAR RADIANCE 55G',43,2,'PCS','CASE',152,72,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(363,'SCR085','GC MOIST PROTECTION 9 CLEAR RADIANCE 85G',43,2,'PCS','CASE',153,60,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(364,'SCR125','GC MOIST PROTECTION 9 CLEAR RADIANCE 125G',43,2,'PCS','CASE',154,48,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(365,'SPC055','GC MOIST PROTECTION 9 PURE CARE 55G',43,2,'PCS','CASE',155,72,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(366,'SPC085','GC MOIST PROTECTION 9 PURE CARE 85G',43,2,'PCS','CASE',156,60,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(367,'SPC125','GC MOIST PROTECTION 9 PURE CARE 125G',43,2,'PCS','CASE',157,48,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(368,'SPH055','GC MOIST PROTECTION 9 PAPAYA & HONEY 55G',43,2,'PCS','CASE',158,72,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(369,'SPH085','GC MOIST PROTECTION 9 PAPAYA & HONEY 85G',43,2,'PCS','CASE',159,60,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(370,'SPH125','GC MOIST PROTECTION 9 PAPAYA & HONEY 125G',43,2,'PCS','CASE',160,48,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(371,'XCO030','ZONROX COLORSAFE BLEACH BLOSSOM FRESH 30ML',34,2,'SCH','CASE',161,360,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(372,'XCO095','ZONROX COLORSAFE BLEACH BLOSSOM FRESH 95ML',34,2,'BOT','CASE',162,72,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(373,'XCO225','ZONROX COLORSAFE BLEACH BLOSSOM FRESH 225ML',34,2,'BOT','CASE',163,48,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(374,'XCO450','ZONROX COLORSAFE BLEACH BLOSSOM FRESH 450ML',34,2,'BOT','CASE',164,36,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(375,'XCO900','ZONROX COLORSAFE BLEACH BLOSSOM FRESH 900ML',34,2,'BOT','CASE',165,24,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(376,'XCOGAL','ZONROX COLORSAFE BLEACH 3600 ML',34,2,'GAL','CASE',166,3,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(377,'ZFR.5G','ZONROX SCENTED FRESH 1/2 GAL',34,2,'BOT','CASE',167,12,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(378,'ZFR.5L','ZONROX SCENTED FRESH 500 ML',34,2,'BOT','CASE',168,36,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(379,'ZFR4OZ','ZONROX SCENTED FRESH 100 ML',34,2,'BOT','CASE',169,72,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(380,'ZFR8OZ','ZONROX SCENTED FRESH 250 ML',34,2,'BOT','CASE',170,48,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(381,'ZFRGAL','ZONROX SCENTED FRESH GAL',34,2,'GAL','CASE',171,6,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(382,'ZFRGLN','ZONROX SCENTED FRESH GAL',34,2,'GAL','CASE',172,3,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(383,'ZFRLIT','ZONROX SCENTED FRESH 1 LITER',34,2,'BOT','CASE',173,24,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(384,'ZGC095','ZONROX GENTLE CLEAN BLEACH 95ML',34,2,'BOT','CASE',174,72,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(385,'ZGC225','ZONROX GENTLE CLEAN BLEACH 225ML',34,2,'BOT','CASE',175,48,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(386,'ZGC450','ZONROX GENTLE CLEAN BLEACH 450ML',34,2,'BOT','CASE',176,36,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(387,'ZGC900','ZONROX GENTLE CLEAN BLEACH 900ML',34,2,'BOT','CASE',177,24,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(388,'ZLE.5G','ZONROX SCENTED LEMON 1/2 GAL',34,2,'BOT','CASE',178,12,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(389,'ZLE.5L','ZONROX SCENTED LEMON 500 ML',34,2,'BOT','CASE',179,36,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(390,'ZLE4OZ','ZONROX SCENTED LEMON 100 ML',34,2,'BOT','CASE',180,72,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(391,'ZLE8OZ','ZONROX SCENTED LEMON 250 ML',34,2,'BOT','CASE',181,48,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(392,'ZLEGAL','ZONROX SCENTED LEMON GAL',34,2,'GAL','CASE',182,6,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(393,'ZLEGLN','ZONROX SCENTED LEMON GAL',34,2,'GAL','CASE',183,3,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(394,'ZLELIT','ZONROX SCENTED LEMON 1 LITER',34,2,'BOT','CASE',184,24,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(395,'ZML450','ZONROX MULTI CLEAN LEMON SPLASH 450ML',34,2,'BOT','CASE',185,12,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(396,'ZML450M2X','BUY 1PC ZMC LEMON 450ML FREE 3PCS ZNRX COLORSAFE BLOSSOM 30ML',34,2,'BOT','CASE',186,9,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(397,'ZML900','ZONROX MULTI CLEAN LEMON SPLASH 900ML',34,2,'BOT','CASE',187,12,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(398,'ZML900M2X','BUY 1PC ZMC LEMON 900ML FREE 3PCS ZNRX COLORSAFE BLOSSOM 225ML',34,2,'BOT','CASE',188,8,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(399,'ZMR450','ZONROX MULTI CLEAN FLORAL BLAST 450ML',34,2,'BOT','CASE',189,12,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(400,'ZMR450M2X','BUY 1PC ZMC FLORAL 450ML FREE 3PCS ZNRX COLORSAFE BLOSSOM 30ML',34,2,'BOT','CASE',190,9,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(401,'ZMR900','ZONROX MULTI CLEAN FLORAL BLAST 900ML',34,2,'BOT','CASE',191,12,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(402,'ZMR900M2X','BUY 1PC ZMC FLORAL 900ML FREE 3PCS ZNRX COLORSAFE BLOSSOM 225ML',34,2,'BOT','CASE',192,8,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(403,'ZON.5G','ZONROX BLEACH ORIGINAL 1/2 GAL',34,2,'BOT','CASE',193,12,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(404,'ZON.5L','ZONROX BLEACH ORIGINAL 500 ML',34,2,'BOT','CASE',194,36,0,'FAST MOVING ',NULL,'2023-02-17 17:36:19',0.00,0.00,'4800011736044',NULL,0),
(405,'ZON4OZ','ZONROX BLEACH ORIGINAL 100 ML',34,2,'BOT','CASE',195,72,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(406,'ZON8OZ','ZONROX BLEACH ORIGINAL 250 ML',34,2,'BOT','CASE',196,48,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(407,'ZONGAL','ZONROX BLEACH ORIGINAL GAL',34,2,'GAL','CASE',197,6,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(408,'ZONGLN','ZONROX BLEACH ORIGINAL GAL',34,2,'GAL','CASE',198,3,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(409,'ZONLIT','ZONROX BLEACH ORIGINAL 1 LITER',34,2,'BOT','CASE',199,24,0,'FAST MOVING ',NULL,'2023-02-17 17:36:05',0.00,0.00,'4800011159034',NULL,0),
(410,'ZPL095','ZONROX PLUS 95ML',34,2,'BOT','CASE',200,72,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(411,'ZPL225','ZONROX PLUS 225ML',34,2,'BOT','CASE',201,48,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(412,'ZPL450','ZONROX PLUS 450ML',34,2,'BOT','CASE',202,36,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(413,'ZPL900','ZONROX PLUS 900ML',34,2,'BOT','CASE',203,24,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(414,'ZRL.5G','ZONROX SCENTED FLORAL 1/2 GAL',34,2,'BOT','CASE',204,12,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(415,'ZRL.5L','ZONROX SCENTED FLORAL 500 ML',34,2,'BOT','CASE',205,36,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(416,'ZRL4OZ','ZONROX SCENTED FLORAL 100 ML',34,2,'BOT','CASE',206,72,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(417,'ZRL8OZ','ZONROX SCENTED FLORAL 250 ML',34,2,'BOT','CASE',207,48,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(418,'ZRLGAL','ZONROX SCENTED FLORAL GAL',34,2,'GAL','CASE',208,6,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(419,'ZRLGLN','ZONROX SCENTED FLORAL GAL',34,2,'GAL','CASE',209,3,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(420,'ZRLLIT','ZONROX SCENTED FLORAL 1 LITER',34,2,'BOT','CASE',210,24,0,'FAST MOVING ',NULL,NULL,0.00,0.00,NULL,NULL,0),
(421,'7604','ALL NATURAL SPARKLING CUCUMBER VALUE PACK BY 4\'S X 6',16,5,'PACK','BUTAL',484,6,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(422,'7605','ALL NATURAL SPARKLING PASSION FRUIT VALUE PACK BY 4\'S X 6',16,5,'PACK','BUTAL',485,6,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(423,'7606','ALL NATURAL SPARKLING LEMON LIME VALUE PACK BY 4\'S X 6',16,5,'PACK','BUTAL',486,6,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(424,'7607','ALL NATURAL SPARKLING STRAWBERRY VALUE PACK BY 4\'S X 6',16,5,'PACK','BUTAL',487,6,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(425,'142','PINEAPPLE SLICES 227G X 24 CANS',14,5,'CAN','BUTAL',488,24,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(426,'1234','PINEAPPLE SLICES 432G X 24 CANS',14,5,'CAN','BUTAL',489,24,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(427,'1253','PINEAPPLE SLICES 560G X 24 CANS',14,5,'CAN','BUTAL',490,24,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(428,'1274','PINEAPPLE SLICES 822G X 24 CANS',14,5,'CAN','BUTAL',491,24,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(429,'205','PINEAPPLE SLICES 3KG X 6 CANS',14,5,'CAN','BUTAL',492,6,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(430,'1275','PINEAPPLE CHUNKS 200G X 24 CANS',14,5,'CAN','BUTAL',493,24,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(431,'1402','PINEAPPLE CHUNKS 227G X 24 CANS',14,5,'CAN','BUTAL',494,24,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(432,'1766','PINEAPPLE CHUNKS 432G X 24 CANS',14,5,'CAN','BUTAL',495,24,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(433,'1162','PINEAPPLE CHUNKS 560G X 24 CANS',14,5,'CAN','BUTAL',496,24,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(434,'1884','PINEAPPLE CHUNKS 822G X 24 CANS',14,5,'CAN','BUTAL',497,24,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(435,'460','PINEAPPLE CHUNKS 3KG X 6 CANS',14,5,'CAN','BUTAL',498,6,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(436,'508','PINEAPPLE TIDBITS 115G X 48 CANS',14,5,'CAN','BUTAL',499,48,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(437,'5517','PINEAPPLE TIDBITS 227G X 24 CANS',14,5,'CAN','BUTAL',500,24,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(438,'5513','PINEAPPLE TIDBITS 432G X 24 CANS',14,5,'CAN','BUTAL',501,24,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(439,'5515','PINEAPPLE TIDBITS 560G X 24 CANS',14,5,'CAN','BUTAL',502,24,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(440,'5512','PINEAPPLE TIDBITS 822G X 24 CANS',14,5,'CAN','BUTAL',503,24,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(441,'535','PINEAPPLE TIDBITS 3KG X 6 CANS',14,5,'CAN','BUTAL',504,6,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(442,'611','PINEAPPLE CRUSHED 234G X 24 CANS',14,5,'CAN','BUTAL',505,24,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(443,'616','PINEAPPLE CRUSHED 439G X 24 CANS',14,5,'CAN','BUTAL',506,24,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(444,'603','PINEAPPLE CRUSHED 567G X 24 CANS',14,5,'CAN','BUTAL',507,24,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(445,'625','PINEAPPLE CRUSHED 3.17KG X 6 CANS',14,5,'CAN','BUTAL',508,6,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(446,'19014','TROPICAL FRUIT COCKTAIL 432G X 24 CANS',44,5,'CAN','BUTAL',509,24,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(447,'9007','TROPICAL FRUIT COCKTAIL 822G X 24 CANS',44,5,'CAN','BUTAL',510,24,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(448,'9144','TROPICAL FRUIT COCKTAIL 3KG X 6 CANS',44,5,'CAN','BUTAL',511,6,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(449,'58148','SEASONS FRUIT MIX 432G X 24 CANS',45,5,'CAN','BUTAL',512,24,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(450,'59189','SEASONS FRUIT MIX 822G X 24 CANS',45,5,'CAN','BUTAL',513,24,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(451,'56424','SEASONS FRUIT MIX 3KG X 6 CANS',45,5,'CAN','BUTAL',514,6,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(452,'7512','100%  PINEAPPLE JUICE 190ML X 24',16,5,'CAN','BUTAL',515,24,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(453,'7513','100%  PINEAPPLE JUICE 240ML X 24',16,5,'CAN','BUTAL',516,24,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(454,'822','100%  PINEAPPLE JUICE 532ML X 24',16,5,'CAN','BUTAL',517,24,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(455,'816','100%  PINEAPPLE JUICE 1.36L X 12',16,5,'CAN','BUTAL',518,12,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(456,'858','100%  PINEAPPLE JUICE 2.90L X 6',16,5,'CAN','BUTAL',519,6,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(457,'7519','PINEAPPLE ORANGE 190ML X 24',16,5,'CAN','BUTAL',520,24,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(458,'7534','PINEAPPLE ORANGE 240ML X 24',16,5,'CAN','BUTAL',521,24,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(459,'7545','PINEAPPLE ORANGE 1.36L X 12',16,5,'CAN','BUTAL',522,12,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(460,'7548','PINEAPPLE ORANGE 2.90L X 6',16,5,'CAN','BUTAL',523,6,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(461,'7546','FOUR SEASONS DRINK 190ML X 24',16,5,'CAN','BUTAL',524,24,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(462,'7566','FOUR SEASONS DRINK 240ML X 24',16,5,'CAN','BUTAL',525,24,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(463,'7509','FOUR SEASONS DRINK 1.36L X 12',16,5,'CAN','BUTAL',526,12,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(464,'7547','SWEETENED PINEAPPLE JUICE 240ML X 24',16,5,'CAN','BUTAL',527,24,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(465,'7568','SWEETENED PINEAPPLE JUICE 1.36L X 12',16,5,'CAN','BUTAL',528,12,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(466,'7513P','100%  PINEAPPLE JUICE 240ML X 5+1 X 4 PACKS',16,5,'PACK','BUTAL',529,4,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(467,'7534P','PINEAPPLE ORANGE DRINK 240ML X 5+1 X 4 PACKS',16,5,'PACK','BUTAL',530,4,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(468,'7588','SEASONS MANGO JUICE DRINK 240ML X 24',16,5,'CAN','BUTAL',531,24,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(469,'55111','SEASONS PINEAPPLE BANANA JUICE 200ML X 12',16,5,'CAN','BUTAL',532,12,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(470,'55112','SEASONS PINEAPPLE ORANGE JUICE 200ML X 12',16,5,'CAN','BUTAL',533,12,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(471,'55113','SEASONS PINEAPPLE MANGO JUICE 200ML X 12',16,5,'CAN','BUTAL',534,12,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(472,'55114','SEASONS PINEAPPLE COCONUT JUICE 200ML X 12',16,5,'CAN','BUTAL',535,12,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(473,'55101','SEASONS PINEAPPLE BANANA JUICE 1L X 12',16,5,'CAN','BUTAL',536,12,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(474,'55102','SEASONS PINEAPPLE ORANGE JUICE 1L X 12',16,5,'CAN','BUTAL',537,12,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(475,'55103','SEASONS PINEAPPLE MANGO JUICE 1L X 12',16,5,'CAN','BUTAL',538,12,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(476,'55104','SEASONS PINEAPPLE COCONUT JUICE 1L X 12',16,5,'CAN','BUTAL',539,12,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(477,'7600','DOLE 100% ALL NATURAL SPARKLING CUCUMBER 240MLX24',16,5,'CAN','BUTAL',540,24,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(478,'7601','DOLE 100% ALL NATURAL SPARKLING PASSION FRUIT 240MLX24',16,5,'CAN','BUTAL',541,24,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(479,'7602','DOLE 100% ALL NATURAL SPARKLING LEMON LIME 240MLX24',16,5,'CAN','BUTAL',542,24,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(480,'7603','DOLE 100% ALL NATURAL SPARKLING STRAWBERRY 240MLX24',16,5,'CAN','BUTAL',543,24,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(481,'4179','DOLE SLICED PEACHES IN LS 665G X 8',46,5,'CAN','BUTAL',544,8,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(482,'4178','DOLE MANDARIN ORANGE IN LS 665G X 8',46,5,'CAN','BUTAL',545,8,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(483,'5814867','SEASONS FRUIT MIX 432G X 12 ANGEL EVAP SAVE P5',45,5,'CAN','BUTAL',546,12,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(484,'7604','ALL NATURAL SPARKLING CUCUMBER VALUE PACK BY 4\'S X 6',16,5,'CASE','CASE',421,6,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(485,'7605','ALL NATURAL SPARKLING PASSION FRUIT VALUE PACK BY 4\'S X 6',16,5,'CASE','CASE',422,6,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(486,'7606','ALL NATURAL SPARKLING LEMON LIME VALUE PACK BY 4\'S X 6',16,5,'CASE','CASE',423,6,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(487,'7607','ALL NATURAL SPARKLING STRAWBERRY VALUE PACK BY 4\'S X 6',16,5,'CASE','CASE',424,6,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(488,'142','PINEAPPLE SLICES 227G X 24 CANS',14,5,'CASE','CASE',425,24,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(489,'1234','PINEAPPLE SLICES 432G X 24 CANS',14,5,'CASE','CASE',426,24,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(490,'1253','PINEAPPLE SLICES 560G X 24 CANS',14,5,'CASE','CASE',427,24,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(491,'1274','PINEAPPLE SLICES 822G X 24 CANS',14,5,'CASE','CASE',428,24,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(492,'205','PINEAPPLE SLICES 3KG X 6 CANS',14,5,'CASE','CASE',429,6,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(493,'1275','PINEAPPLE CHUNKS 200G X 24 CANS',14,5,'CASE','CASE',430,24,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(494,'1402','PINEAPPLE CHUNKS 227G X 24 CANS',14,5,'CASE','CASE',431,24,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(495,'1766','PINEAPPLE CHUNKS 432G X 24 CANS',14,5,'CASE','CASE',432,24,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(496,'1162','PINEAPPLE CHUNKS 560G X 24 CANS',14,5,'CASE','CASE',433,24,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(497,'1884','PINEAPPLE CHUNKS 822G X 24 CANS',14,5,'CASE','CASE',434,24,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(498,'460','PINEAPPLE CHUNKS 3KG X 6 CANS',14,5,'CASE','CASE',435,6,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(499,'508','PINEAPPLE TIDBITS 115G X 48 CANS',14,5,'CASE','CASE',436,48,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(500,'5517','PINEAPPLE TIDBITS 227G X 24 CANS',14,5,'CASE','CASE',437,24,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(501,'5513','PINEAPPLE TIDBITS 432G X 24 CANS',14,5,'CASE','CASE',438,24,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(502,'5515','PINEAPPLE TIDBITS 560G X 24 CANS',14,5,'CASE','CASE',439,24,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(503,'5512','PINEAPPLE TIDBITS 822G X 24 CANS',14,5,'CASE','CASE',440,24,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(504,'535','PINEAPPLE TIDBITS 3KG X 6 CANS',14,5,'CASE','CASE',441,6,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(505,'611','PINEAPPLE CRUSHED 234G X 24 CANS',14,5,'CASE','CASE',442,24,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(506,'616','PINEAPPLE CRUSHED 439G X 24 CANS',14,5,'CASE','CASE',443,24,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(507,'603','PINEAPPLE CRUSHED 567G X 24 CANS',14,5,'CASE','CASE',444,24,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(508,'625','PINEAPPLE CRUSHED 3.17KG X 6 CANS',14,5,'CASE','CASE',445,6,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(509,'19014','TROPICAL FRUIT COCKTAIL 432G X 24 CANS',44,5,'CASE','CASE',446,24,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(510,'9007','TROPICAL FRUIT COCKTAIL 822G X 24 CANS',44,5,'CASE','CASE',447,24,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(511,'9144','TROPICAL FRUIT COCKTAIL 3KG X 6 CANS',44,5,'CASE','CASE',448,6,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(512,'58148','SEASONS FRUIT MIX 432G X 24 CANS',45,5,'CASE','CASE',449,24,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(513,'59189','SEASONS FRUIT MIX 822G X 24 CANS',45,5,'CASE','CASE',450,24,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(514,'56424','SEASONS FRUIT MIX 3KG X 6 CANS',45,5,'CASE','CASE',451,6,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(515,'7512','100%  PINEAPPLE JUICE 190ML X 24',16,5,'CASE','CASE',452,24,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(516,'7513','100%  PINEAPPLE JUICE 240ML X 24',16,5,'CASE','CASE',453,24,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(517,'822','100%  PINEAPPLE JUICE 532ML X 24',16,5,'CASE','CASE',454,24,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(518,'816','100%  PINEAPPLE JUICE 1.36L X 12',16,5,'CASE','CASE',455,12,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(519,'858','100%  PINEAPPLE JUICE 2.90L X 6',16,5,'CASE','CASE',456,6,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(520,'7519','PINEAPPLE ORANGE 190ML X 24',16,5,'CASE','CASE',457,24,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(521,'7534','PINEAPPLE ORANGE 240ML X 24',16,5,'CASE','CASE',458,24,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(522,'7545','PINEAPPLE ORANGE 1.36L X 12',16,5,'CASE','CASE',459,12,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(523,'7548','PINEAPPLE ORANGE 2.90L X 6',16,5,'CASE','CASE',460,6,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(524,'7546','FOUR SEASONS DRINK 190ML X 24',16,5,'CASE','CASE',461,24,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(525,'7566','FOUR SEASONS DRINK 240ML X 24',16,5,'CASE','CASE',462,24,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(526,'7509','FOUR SEASONS DRINK 1.36L X 12',16,5,'CASE','CASE',463,12,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(527,'7547','SWEETENED PINEAPPLE JUICE 240ML X 24',16,5,'CASE','CASE',464,24,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(528,'7568','SWEETENED PINEAPPLE JUICE 1.36L X 12',16,5,'CASE','CASE',465,12,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(529,'7513P','100%  PINEAPPLE JUICE 240ML X 5+1 X 4 PACKS',16,5,'CASE','CASE',466,4,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(530,'7534P','PINEAPPLE ORANGE DRINK 240ML X 5+1 X 4 PACKS',16,5,'CASE','CASE',467,4,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(531,'7588','SEASONS MANGO JUICE DRINK 240ML X 24',16,5,'CASE','CASE',468,24,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(532,'55111','SEASONS PINEAPPLE BANANA JUICE 200ML X 12',16,5,'CASE','CASE',469,12,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(533,'55112','SEASONS PINEAPPLE ORANGE JUICE 200ML X 12',16,5,'CASE','CASE',470,12,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(534,'55113','SEASONS PINEAPPLE MANGO JUICE 200ML X 12',16,5,'CASE','CASE',471,12,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(535,'55114','SEASONS PINEAPPLE COCONUT JUICE 200ML X 12',16,5,'CASE','CASE',472,12,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(536,'55101','SEASONS PINEAPPLE BANANA JUICE 1L X 12',16,5,'CASE','CASE',473,12,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(537,'55102','SEASONS PINEAPPLE ORANGE JUICE 1L X 12',16,5,'CASE','CASE',474,12,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(538,'55103','SEASONS PINEAPPLE MANGO JUICE 1L X 12',16,5,'CASE','CASE',475,12,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(539,'55104','SEASONS PINEAPPLE COCONUT JUICE 1L X 12',16,5,'CASE','CASE',476,12,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(540,'7600','DOLE 100% ALL NATURAL SPARKLING CUCUMBER 240MLX24',16,5,'CASE','CASE',477,24,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(541,'7601','DOLE 100% ALL NATURAL SPARKLING PASSION FRUIT 240MLX24',16,5,'CASE','CASE',478,24,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(542,'7602','DOLE 100% ALL NATURAL SPARKLING LEMON LIME 240MLX24',16,5,'CASE','CASE',479,24,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(543,'7603','DOLE 100% ALL NATURAL SPARKLING STRAWBERRY 240MLX24',16,5,'CASE','CASE',480,24,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(544,'4179','DOLE SLICED PEACHES IN LS 665G X 8',46,5,'CASE','CASE',481,8,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(545,'4178','DOLE MANDARIN ORANGE IN LS 665G X 8',46,5,'CASE','CASE',482,8,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(546,'5814867','SEASONS FRUIT MIX 432G X 12 ANGEL EVAP SAVE P5',45,5,'CASE','CASE',483,12,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(547,'950SW2','GENERAL PURPOSE D SIZE BLUE IN SHRINK WRAP',1,4,'PACKS','BUTAL',0,0,0,'FASTMOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(548,'1050SW2','HEAY DUTY D SIZE RED IN SHRINK WRAP',1,4,'PACKS','BUTAL',0,0,0,'FASTMOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(549,'1050BP2','HEAY DUTY D SIZE RED IN BLISTER PACK',1,4,'PACKS','BUTAL',0,0,0,'FASTMOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(550,'1250SW2N','SUPER HEAY DUTY D SIZE BLACK IN SHRINK WRAP',1,4,'PACKS','BUTAL',0,0,0,'FASTMOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(551,'1250BP2N','SUPER HEAY DUTY D SIZE BLACK IN BLISTER PACK',1,4,'PACKS','BUTAL',0,0,0,'FASTMOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(552,'1235SW2','SUPER HEAY DUTY C SIZE BLACK IN SHRINK WRAP',1,4,'PACKS','BUTAL',0,0,0,'FASTMOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(553,'1235BP2','SUPER HEAY DUTY C SIZE BLACK IN BLISTER PACK',1,4,'PACKS','BUTAL',0,0,0,'FASTMOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(554,'915SW2','GENERAL PURPOSE AA BLUE IN SHRINK WRAP',1,4,'PACKS','BUTAL',0,0,0,'FASTMOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(555,'1015SW2','HEAVY DUTY AA RED IN SHRINK WRAP',1,4,'PACKS','BUTAL',0,0,0,'FASTMOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(556,'1015BP4','HEAVY DUTY AA RED IN BLISTER PACK',1,4,'PACKS','BUTAL',0,0,0,'FASTMOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(557,'1215SW2','SUPER HEAVY DUTY AA BLACK IN SHRINK WRAP',1,4,'PACKS','BUTAL',0,0,0,'FASTMOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(558,'1215BP4','SUPER HEAVY DUTY AA BLACK IN BLISTER PACK',1,4,'PACKS','BUTAL',0,0,0,'FASTMOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(559,'912SW4','GENERAL PURPOSE AAA BLUE IN SHRINK WRAP',1,4,'PACKS','BUTAL',0,0,0,'FASTMOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(560,'1212SW2','SUPER HEAVY DUTY AAA BLACK IN SHRINK WRAP',1,4,'PACKS','BUTAL',0,0,0,'FASTMOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(561,'1212BP4','SUPER HEAVY DUTY AAA BLACK IN BLISTER PACK',1,4,'PACKS','BUTAL',0,0,0,'FASTMOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(562,'1222BP1','SUPER HEAVY DUTY 9V BLACK IN BLISTER PACK',1,4,'PACKS','BUTAL',0,0,0,'FASTMOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(563,'A91BP2','EVEREADY GOLD AA IN BLISTER PACK',1,4,'PACKS','BUTAL',0,0,0,'FASTMOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(564,'A91BP4','EVEREADY GOLD AA IN BLISTER PACK',1,4,'PACKS','BUTAL',0,0,0,'FASTMOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(565,'A92BP4','EVEREADY GOLD AAA IN BLISTER PACK',1,4,'PACKS','BUTAL',0,0,0,'FASTMOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(566,'1215H20','SUPER HEAVY DUTY HANGER CARD IN 20\'S',1,4,'PACKS','BUTAL',0,0,0,'FASTMOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(567,'EP91BP2','ENERGIZER MAX PLUS AA BLISTER PACK',1,4,'PACKS','BUTAL',0,0,0,'FASTMOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(568,'EP91BP4','ENERGIZER MAX PLUS AA BLISTER PACK',1,4,'PACKS','BUTAL',0,0,0,'FASTMOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(569,'E91MAXBP2','ENERGIZER MAX  AA BLISTER PACK',1,4,'PACKS','BUTAL',0,0,0,'FASTMOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(570,'E91MAXBP4','ENERGIZER MAX  AA BLISTER PACK',1,4,'PACKS','BUTAL',0,0,0,'FASTMOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(571,'EP92BP2','ENERGIZER MAX PLUS AAA BLISTER PACK',1,4,'PACKS','BUTAL',0,0,0,'FASTMOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(572,'E92MAXBP2','ENERGIZER MAX  AAA BLISTER PACK',1,4,'PACKS','BUTAL',0,0,0,'FASTMOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(573,'E92MAXBP4','ENERGIZER MAX  AAA BLISTER PACK',1,4,'PACKS','BUTAL',0,0,0,'FASTMOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(574,'E93MAXBP2','ENERGIZER MAX C 108/1',1,4,'PACKS','BUTAL',0,0,0,'FASTMOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(575,'E95MAXBP2','P2 ENERGIZER MAX D 72/1',1,4,'PACKS','BUTAL',0,0,0,'FASTMOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(576,'522MAXBP1','522 9V BP1 ENERGIZER MAX',1,4,'PACKS','BUTAL',0,0,0,'FASTMOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(577,'LC1L2A','EVEREADY AA LED LIGHTS',1,4,'PACKS','BUTAL',0,0,0,'FASTMOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(578,'3511BP','EVEREADY ESSENTIAL 2D BP W/O BATTERY',1,4,'PACKS','BUTAL',0,0,0,'FASTMOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(579,'VAL2AA','EVEREADY BRILLIANT BEAM 2AA LIGHT',1,4,'PACKS','BUTAL',0,0,0,'FASTMOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(580,'VAL2D','EVEREADY BRILLIANT BEAM 2D LIGHT',1,4,'PACKS','BUTAL',0,0,0,'FASTMOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(581,'DOLH411','EVEREADY DOLPHIN MINI 4AA LIGHT',1,4,'PACKS','BUTAL',0,0,0,'FASTMOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(582,'DLAH41','EVEREADY DOLPHIN 2 IN 1',1,4,'PACKS','BUTAL',0,0,0,'FASTMOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(583,'RHAPLA','EVEREADY MINI RECHARGEABLE FLASHLIGHT',1,4,'PACKS','BUTAL',0,0,0,'FASTMOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(584,'VMAHL8','EVEREADY VALUE METAL RECHARGEABLE HANDHELD',1,4,'PACKS','BUTAL',0,0,0,'FASTMOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(585,'HDLLP','EVEREADY VALUE REACHARGEABLE HEADLAMP',1,4,'PACKS','BUTAL',0,0,0,'FASTMOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(586,'MLHV32','EVEREADY COMPACT LED METAL LIGHT',1,4,'PACKS','BUTAL',0,0,0,'FASTMOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(587,'TAPR221','EVEREADY LED TAP LIGHT',1,4,'PACKS','BUTAL',0,0,0,'FASTMOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(588,'THH21','ENERGIZER TOUCHTECH FLASHLIGHT 2AA',1,4,'PACKS','BUTAL',0,0,0,'FASTMOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(589,'HCHH212','ENERGIZER HARD CASE TASK LIGHT W/2 E91',1,4,'PACKS','BUTAL',0,0,0,'FASTMOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(590,'GPSPL8','ENERGIZER RECHARGEABLE SPOTLIGHT',1,4,'PACKS','BUTAL',0,0,0,'FASTMOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(591,'HDCU22','ENERGIZER UNIVERSAL PLUS HEADLIGHT',1,4,'PACKS','BUTAL',0,0,0,'FASTMOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(592,'HDB323','ENERGIZER VISION HEADLIGHT',1,4,'PACKS','BUTAL',0,0,0,'FASTMOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(593,'MLHH32','ENERGIZER COMPACT METAL LIGHT',1,4,'PACKS','BUTAL',0,0,0,'FASTMOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(594,'PLM22','ENERGIZER METAL PENLITE',1,4,'PACKS','BUTAL',0,0,0,'FASTMOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(595,'PLMA22','ENERGIZER PENLIGHT',1,4,'PACKS','BUTAL',0,0,0,'FASTMOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(596,'RE12BP2','EVR. RE12 AAA NIMH 500MAH BLISTERPACK',1,4,'PACKS','BUTAL',0,0,0,'FASTMOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(597,'RE15BP2','EVR. RE15 AAA NIMH 1300MAH BLISTERPACK',1,4,'PACKS','BUTAL',0,0,0,'FASTMOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(598,'EV2PC4','EVR. MINI CHARGER W/ 2AA 1300MAH',1,4,'PACKS','BUTAL',0,0,0,'FASTMOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(599,'NH12PPBP2','ENR. POWERPLUS AAA NIMH BLISTERPACK',1,4,'PACKS','BUTAL',0,0,0,'FASTMOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(600,'NH15EBP2','ENR. EXTREME AA NIMH BLISTERPACK',1,4,'PACKS','BUTAL',0,0,0,'FASTMOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(601,'NH15PPBP2','ENR. POWERPLUS AA NIMH BLISTERPACK',1,4,'PACKS','BUTAL',0,0,0,'FASTMOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(602,'NH22BP1','ENR. NH22 9V 175MAH BLISTERPACK',1,4,'PACKS','BUTAL',0,0,0,'FASTMOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(603,'CH2PC4','ENR. MINI CHARGER W/ 2AAA',1,4,'PACKS','BUTAL',0,0,0,'FASTMOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(604,'CHVCM4','ENR. MAXI CHARGER',1,4,'PACKS','BUTAL',0,0,0,'FASTMOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(605,'CHPRO','ENR. PRO CHARGER W/ 2AA UNIVERSAL',1,4,'PACKS','BUTAL',0,0,0,'FASTMOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(606,'L91BP2','ENR. LITHIUM AA BLISTERPACK',1,4,'PACKS','BUTAL',0,0,0,'FASTMOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(607,'L92BP2','ENR. LITHIUM AAA BLISTERPACK',1,4,'PACKS','BUTAL',0,0,0,'FASTMOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(608,'CR2016BP2','CR2016 LITHIUM COIN 3V BLISTERPACK',1,4,'PACKS','BUTAL',0,0,0,'FASTMOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(609,'CR2025BP2','CR2025 LITHIUM COIN 3V BLISTERPACK',1,4,'PACKS','BUTAL',0,0,0,'FASTMOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(610,'CR2032BP2','CR2032 LITHIUM COIN 3V BLISTERPACK',1,4,'PACKS','BUTAL',0,0,0,'FASTMOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(611,'A23BP1','A23 MNG DIOXIDE 12V BLISTERPACK',1,4,'PACKS','BUTAL',0,0,0,'FASTMOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(612,'A27BP1','A27 MNG DIOXIDE 12V BLISTERPACK',1,4,'PACKS','BUTAL',0,0,0,'FASTMOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(613,'A76BP2','A76 MNG DIOXIDE  BLISTERPACK',1,4,'PACKS','BUTAL',0,0,0,'FASTMOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(614,'E303217600','ARMOR ALL PROTECTANT 120ML ',1,4,'PACKS','BUTAL',0,0,0,'FASTMOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(615,'E303217500','ARMOR ALL PROTECTANT 300ML ',1,4,'PACKS','BUTAL',0,0,0,'FASTMOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(616,'E303217700','ARMOR ALL PROTECTANT 500ML ',1,4,'PACKS','BUTAL',0,0,0,'FASTMOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(617,'E303225700','ARMOR ALL SHIELD PROTECTANT 120ML ',1,4,'PACKS','BUTAL',0,0,0,'FASTMOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(618,'E303217800','ARMOR ALL LEATHER CARE 530ML',1,4,'PACKS','BUTAL',0,0,0,'FASTMOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(619,'E302054800','ARMOR ALL PROTECTANT WIPES 30CT',1,4,'PACKS','BUTAL',0,0,0,'FASTMOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(620,'E302056700','ARMOR ALL LEATHER WIPES 24CT',1,4,'PACKS','BUTAL',0,0,0,'FASTMOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(621,'E303218300','ARMOR ALL CAR WASH 1LITER',1,4,'PACKS','BUTAL',0,0,0,'FASTMOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(622,'E303218200','ARMOR ALL WASH & WAX 500ML',1,4,'PACKS','BUTAL',0,0,0,'FASTMOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(623,'E303219000','ARMOR ALL SPEED WAX SPRAY 500ML',1,4,'PACKS','BUTAL',0,0,0,'FASTMOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(624,'E303219100','ARMOR ALL TIRE FOAM 600ML',1,4,'PACKS','BUTAL',0,0,0,'FASTMOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(625,'E303218700','ARMOR ALL WHEEL & TIRE CENTER 500ML',1,4,'PACKS','BUTAL',0,0,0,'FASTMOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(626,'E303218600','ARMOR ALL GLASS CLEANER 500ML',1,4,'PACKS','BUTAL',0,0,0,'FASTMOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(627,'E303211500','CALIFORNIA SCENTS COOL GEL CORONADO CHERRY 4.5OZ',1,4,'PACKS','BUTAL',0,0,0,'FASTMOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(628,'E303211300','CALIFORNIA SCENTS COOL GEL SHASTA STRAWBERRY 4.5OZ',1,4,'PACKS','BUTAL',0,0,0,'FASTMOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(629,'E303211400','CALIFORNIA SCENTS COOL GEL NEW PORT NEW CAR 4.5OZ',1,4,'PACKS','BUTAL',0,0,0,'FASTMOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(630,'E303211200','CALIFORNIA SCENTS COOL GEL CORONADO CHERRY 2.5OZ',1,4,'PACKS','BUTAL',0,0,0,'FASTMOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(631,'E303211000','CALIFORNIA SCENTS COOL GEL SHASTA STRAWBERRY 2.5OZ',1,4,'PACKS','BUTAL',0,0,0,'FASTMOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(632,'E303211100','CALIFORNIA SCENTS COOL GEL NEW PORT NEW CAR 2.5OZ',1,4,'PACKS','BUTAL',0,0,0,'FASTMOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(633,'E303213000','CALIFORNIA SCENTS MINI DIFFUSER CORONADO CHERRY 2\'S',1,4,'PACKS','BUTAL',0,0,0,'FASTMOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(634,'E303213200','CALIFORNIA SCENTS MINI DIFFUSER SHASTA STRAWBERRY 2\'S',1,4,'PACKS','BUTAL',0,0,0,'FASTMOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(635,'E303213300','CALIFORNIA SCENTS MINI DIFFUSER GOLDEN STATE DELIGHT 2\'S',1,4,'PACKS','BUTAL',0,0,0,'FASTMOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(636,'E303212600','CALIFORNIA SCENTS PALMS CORONADO CHERRY 4\'S',1,4,'PACKS','BUTAL',0,0,0,'FASTMOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(637,'E303212700','CALIFORNIA SCENTS PALMS  NEW PORT NEW CAR 4\'S',1,4,'PACKS','BUTAL',0,0,0,'FASTMOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(638,'E303212800','CALIFORNIA SCENTS PALMS  ICE  4\'S',1,4,'PACKS','BUTAL',0,0,0,'FASTMOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(639,'E303211600','CALIFORNIA SCENTS PALMS CORONADO CHERRY 1PC',1,4,'PACKS','BUTAL',0,0,0,'FASTMOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(640,'E303211700','CALIFORNIA SCENTS PALMS NEW PORT NEW CAR 1PC',1,4,'PACKS','BUTAL',0,0,0,'FASTMOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(641,'E303211800','CALIFORNIA SCENTS PALMS LAGUNA BREEZE 1PC',1,4,'PACKS','BUTAL',0,0,0,'FASTMOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(642,'E303212400','CALIFORNIA SCENTS PALMS ICE 1PC',1,4,'PACKS','BUTAL',0,0,0,'FASTMOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(643,'E303212500','CALIFORNIA SCENTS PALMS SHASTA STRAWBERRY 1PC',1,4,'PACKS','BUTAL',0,0,0,'FASTMOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(644,'E303210100','CALIFORNIA SCENTS SPILL PROOF CAN CORONADO CHERRY 1PC',1,4,'PACKS','BUTAL',0,0,0,'FASTMOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(645,'E303210300','CALIFORNIA SCENTS SPILL PROOF CAN NEW PORT NEW CAR 1PC',1,4,'PACKS','BUTAL',0,0,0,'FASTMOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(646,'E303210400','CALIFORNIA SCENTS SPILL PROOF CAN LA JOLLA LEMON 1PC',1,4,'PACKS','BUTAL',0,0,0,'FASTMOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(647,'E303210200','CALIFORNIA SCENTS SPILL PROOF CAN BLACK ICE 1PC',1,4,'PACKS','BUTAL',0,0,0,'FASTMOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(648,'E303210500','CALIFORNIA SCENTS SPILL PROOF CAN GOLDEN STATE DELIGHT 1PC',1,4,'PACKS','BUTAL',0,0,0,'FASTMOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(649,'E3032153200','CALIFORNIA SCENTS ASST. MINI SCENTS (ICE,LAGUNA BREEZE,NEWPORT NE CAE,CORONADO CHERRY)',1,4,'PACKS','BUTAL',0,0,0,'FASTMOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(650,'MAIN_1001','Champion Powder SUPRA POWER with Fab Con 2000g (1+6 PF 28ml) X 6',7,8,'Sack','BUTAL',803,6,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(651,'MAIN_1007','Champion Powder SUPRA POWER Citrus Fresh 2kg (1+1 CF 390g) X 6',7,8,'Sack','BUTAL',804,6,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(652,'MAIN_1009','Champion HYBRID SUPRA (FabCon Antibac FD 28ml + Powder Supra Clean 35g) X 96',8,8,'Case','BUTAL',805,96,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(653,'MAIN_1011','Calla HYBRID (FabCon Sunny Blue 28ml + Powder Floral Fresh 45g) X 96',7,8,'Case','BUTAL',806,96,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(654,'MAIN_1013','Champion Powder SUPRA POWER Original Supra Clean 2000g (1+1) X 3',7,8,'Sack','BUTAL',807,3,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(655,'MAIN_1015','Champion Powder SUPRA POWER with Fab Con 2000g (1+1) X 3',7,8,'Sack','BUTAL',808,3,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(656,'MAIN_1017','Calla Powder Fabric Conditioner Floral Fresh 1.6kg (1+1) X 3',7,8,'Sack','BUTAL',809,3,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(657,'MAIN_1019','Calla Powder Fabric Conditioner Rose Garden 1.6kg (1+1) X 3',7,8,'Sack','BUTAL',810,3,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(658,'MAIN_1023','Champion Powder SUPRA POWER Original Supra Clean 70g (twin) X 144',7,8,'Sack','BUTAL',811,144,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(659,'MAIN_1027','Calla Powder Special Fabric Conditioner Kalamansi Magic 45g X 240',7,8,'Sack','BUTAL',812,240,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(660,'MAIN_1029','Calla Powder Special Fabric Conditioner Kalamansi Magic 100g X 120',7,8,'Sack','BUTAL',813,120,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(661,'MAIN_1031','Calla Powder Special Fabric Conditioner Kalamansi Magic 800g X 12',7,8,'Sack','BUTAL',814,12,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(662,'MAIN_1033','Calla Powder Special Fabric Conditioner Kalamansi Magic 1.6kg X 6',7,8,'Sack','BUTAL',815,6,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(663,'MAIN_1035','Calla Bar Special Fabric Conditioner Floral Fresh 370g X 36',9,8,'Case','BUTAL',816,36,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(664,'MAIN_1037','Calla Bar Special Fabric Conditioner Blue 370g X 36',9,8,'Case','BUTAL',817,36,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(665,'MAIN_1039','Calla Bar Special Fabric Conditioner Rose Garden 370g X 36',9,8,'Case','BUTAL',818,36,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(666,'MAIN_1041','Calla Bar Special Fabric Conditioner Summer Fresh 370g X 36',9,8,'Case','BUTAL',819,36,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(667,'MAIN_1043','Champion Todo Pack Supra Power BLUE ORIGINAL 130g x 96',9,8,'Case','BUTAL',820,96,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(668,'MAIN_1045','Champion Todo Pack SUPRA POWER Citrus Fresh 130g x 96',9,8,'Case','BUTAL',821,96,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(669,'MAIN_1047','Champion Todo Pack SUPRA POWER Supra Clean 130g x 96',9,8,'Case','BUTAL',822,96,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(670,'MAIN_1049','Champion Todo Pack SUPRA POWER Sunny Fresh 130g x 96',9,8,'Case','BUTAL',823,96,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(671,'MAIN_1051','Champion Bar SUPRA POWER Sunny Fresh 370g X 36',9,8,'Case','BUTAL',824,36,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(672,'MAIN_1053','Champion Bar SUPRA POWER with Fabric Conditioner 370g X 36',9,8,'Case','BUTAL',825,36,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(673,'MAIN_1055','Champion Bar SUPRA POWER Blue Original 370g X 36',9,8,'Case','BUTAL',826,36,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(674,'MAIN_1057','Champion Powder SUPRA POWER Citrus Fresh 35g X 288',7,8,'Sack','BUTAL',827,288,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(675,'MAIN_1059','Champion Powder SUPRA POWER Original Supra Clean 35g X 288',7,8,'Sack','BUTAL',828,288,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(676,'MAIN_1061','Champion Powder SUPRA POWER with Fabric Conditioner 35g X 288',7,8,'Sack','BUTAL',829,288,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(677,'MAIN_1063','Champion Powder SUPRA POWER Citrus Fresh 105g X 96',7,8,'Sack','BUTAL',830,96,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(678,'MAIN_1065','Champion Powder SUPRA POWER Original Supra Clean 105g X 96',7,8,'Sack','BUTAL',831,96,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(679,'MAIN_1067','Champion Powder SUPRA POWER Sunny Fresh 105g X 96',7,8,'Sack','BUTAL',832,96,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(680,'MAIN_1069','Champion Powder SUPRA POWER with Fabric Conditioner 105g X 96',7,8,'Sack','BUTAL',833,96,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(681,'MAIN_408','Calla Powder  Summer Fresh 100g x 120',7,8,'Sack','BUTAL',834,120,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(682,'MAIN_414','Calla Powder  Rose Garden 100g x 120',7,8,'Sack','BUTAL',835,120,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(683,'MAIN_582','Calla Powder  Floral Fresh 45g x 240',7,8,'Sack','BUTAL',836,240,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(684,'MAIN_584','Calla Powder  Summer Fresh 45g x 240',7,8,'Sack','BUTAL',837,240,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(685,'MAIN_586','Calla Powder Rose Garden 45g x 240',7,8,'Sack','BUTAL',838,240,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(686,'MAIN_588','Champion Dishwashing Liquid Lemon Fresh 190ml x 36',11,8,'Case','BUTAL',839,36,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(687,'MAIN_590','Champion Dishwashing Liquid Lemon Fresh 275ml x 24',11,8,'Case','BUTAL',840,24,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(688,'MAIN_599','Champion Liquid FabCon HS Blue Serenity 28ml x 216',10,8,'Case','BUTAL',841,216,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(689,'MAIN_608','Calla Powder  Floral Fresh 100g x 120',7,8,'Sack','BUTAL',842,120,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(690,'MAIN_644','Champion Dishwashing Liquid Lemon Fresh 20ml x 216',11,8,'Case','BUTAL',843,216,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(691,'MAIN_646','Champion Dishwashing Liquid Kalamansi Fresh 20ml x 216',11,8,'Case','BUTAL',844,216,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(692,'MAIN_648','Champion Dishwashing Liquid Kalamansi Fresh 190ml x 36',11,8,'Case','BUTAL',845,36,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(693,'MAIN_650','Champion Dishwashing Liquid Kalamansi Fresh 275ml x 24',11,8,'Case','BUTAL',846,24,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(694,'MAIN_695','Champion Double Todo SUPRA CLEAN 290g x 48',9,8,'Case','BUTAL',847,48,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(695,'MAIN_699','Hana Shampoo Pink Roses & Berries 14ml x 384',12,8,'Case','BUTAL',848,384,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(696,'MAIN_701','Hana Shampoo Pink Roses & Berries 100ml x 48',12,8,'Case','BUTAL',849,48,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(697,'MAIN_703','Hana Shampoo Pink Roses & Berries 200ml x 24',12,8,'Case','BUTAL',850,24,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(698,'MAIN_707','Hana Shampoo Spring Flowers & Apples 14ml x 384',12,8,'Case','BUTAL',851,384,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(699,'MAIN_709','Hana Shampoo Spring Flowers & Apples 100ml x 48',12,8,'Case','BUTAL',852,48,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(700,'MAIN_711','Hana Shampoo Spring Flowers & Apples 200ml x 24',12,8,'Case','BUTAL',853,24,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(701,'MAIN_715','Hana Shampoo Garden Blooms & Lychees 14ml x 384',12,8,'Case','BUTAL',854,384,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(702,'MAIN_717','Hana Shampoo Garden Blooms & Lychees 100ml x 48',12,8,'Case','BUTAL',855,48,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(703,'MAIN_719','Hana Shampoo Garden Blooms & Lychees 200ml x 24',12,8,'Case','BUTAL',856,24,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(704,'MAIN_723','Champion Bar  BLUE SPECIAL 390g x 36',9,8,'Case','BUTAL',857,36,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(705,'MAIN_735','Hana Shampoo S & S Pink Roses & Berries 21ml x 192',12,8,'Case','BUTAL',858,192,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(706,'MAIN_741','Champion Powder  WHITE PROTECT 40g x 288',7,8,'Sack','BUTAL',859,288,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(707,'MAIN_747','Champion Powder Machine Wash 50g x 216',7,8,'Sack','BUTAL',860,216,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(708,'MAIN_749','Champion Powder Machine Wash 1.6kg x 6',7,8,'Sack','BUTAL',861,6,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(709,'MAIN_751','Calla Bar  Floral Fresh 390g x 36',9,8,'Case','BUTAL',862,36,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(710,'MAIN_757','HANA COMBO PACK (SHAM PR & BS 14ML +COND SOFT & SMOOTH 10ML)',12,8,'Case','BUTAL',863,192,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(711,'MAIN_767','CALLA BAR BLUE 390G',9,8,'Case','BUTAL',864,36,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(712,'MAIN_783','P-HANA SHAMPOO S&S PINK ROSES & BERRIES 21ML (10+2) x 16',12,8,'Case','BUTAL',865,16,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(713,'MAIN_801','Champion Powder  BLUE SPECKLES 40g x 288',7,8,'Sack','BUTAL',866,288,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(714,'MAIN_807','Champion Powder WHITE PROTECT 1.6kg x 6',7,8,'Sack','BUTAL',867,6,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(715,'MAIN_809','Calla Powder Floral Fresh 400g X 24',7,8,'Sack','BUTAL',868,24,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(716,'MAIN_811','Calla Powder Floral Fresh 800g X 12',7,8,'Sack','BUTAL',869,12,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(717,'MAIN_813','Calla Powder  Rose Garden 800g x 12',7,8,'Sack','BUTAL',870,12,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(718,'MAIN_815','Calla Powder  Summer Fresh 800g x 12',7,8,'Sack','BUTAL',871,12,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(719,'MAIN_819','Calla Powder Special Fabric Conditioner Floral Fresh 1.6kg x 6',7,8,'Sack','BUTAL',872,6,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(720,'MAIN_831','Calla Bar Rose Garden 390g x 36',9,8,'Case','BUTAL',873,36,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(721,'MAIN_833','Calla Bar Summer Fresh 390g x 36',9,8,'Case','BUTAL',874,36,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(722,'MAIN_835','Champion Bar SUPRA POWER Blue Original 390g x36',9,8,'Case','BUTAL',875,36,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(723,'MAIN_837','Champion Bar SUPRA POWER Citrus Fresh 390g x36',9,8,'Case','BUTAL',876,36,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(724,'MAIN_839','Champion Bar SUPRA POWER Sunny Fresh 390g x36',9,8,'Case','BUTAL',877,36,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(725,'MAIN_841','Champion Bar SUPRA POWER Original Supra Clean 390g x36',9,8,'Case','BUTAL',878,36,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(726,'MAIN_843','Champion Bar SUPRA POWER with Fabric Conditioner 390g x 36',9,8,'Case','BUTAL',879,36,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(727,'MAIN_845','Champion Todo Pack SUPRA POWER Blue Original 145g x96',9,8,'Case','BUTAL',880,96,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(728,'MAIN_847','Champion Todo Pack SUPRA POWER Citrus Fresh 145g x96',9,8,'Case','BUTAL',881,96,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(729,'MAIN_849','Champion Todo SUPRA POWER Supra Clean 145g X 96',9,8,'Case','BUTAL',882,96,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(730,'MAIN_851','Champion Todo Pack SUPRA POWER Sunny Fresh 145g x96',9,8,'Case','BUTAL',883,96,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(731,'MAIN_853','Champion Powder SUPRA POWER Supra Clean 40g x288',7,8,'Sack','BUTAL',884,288,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(732,'MAIN_855','Champion Powder SUPRA POWER Supra Clean 120g x96',7,8,'Sack','BUTAL',885,96,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(733,'MAIN_857','Champion Powder SUPRA POWER Supra Clean 400g x24',7,8,'Sack','BUTAL',886,24,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(734,'MAIN_859','Champion Powder SUPRA POWER Supra Clean 800g x12',7,8,'Sack','BUTAL',887,12,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(735,'MAIN_861','Champion Powder SUPRA POWER Supra Clean 2000g x6',7,8,'Sack','BUTAL',888,6,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(736,'MAIN_865','Champion Liquid FabCon ANTIBACTERIAL FRESH DAY 28ml x216',10,8,'Case','BUTAL',889,216,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(737,'MAIN_867','Champion Liquid FabCon ANTIBACTERIAL FRESH DAY 50ml x144',10,8,'Case','BUTAL',890,144,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(738,'MAIN_869','Champion Liquid FabCon ANTIBACTERIAL FRESH DAY 1000ml x12',10,8,'Case','BUTAL',891,12,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(739,'MAIN_871','Champion Liquid FabCon ANTIBACTERIAL PINK FRESH 28ml x216',10,8,'Case','BUTAL',892,216,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(740,'MAIN_873','Champion Liquid FabCon ANTIBACTERIAL PINK FRESH 50ml x144',10,8,'Case','BUTAL',893,144,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(741,'MAIN_875','Champion Liquid FabCon ANTIBACTERIAL PINK FRESH 1000ml x12',10,8,'Case','BUTAL',894,12,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(742,'MAIN_877','Champion Powder SUPRA POWER Citrus Fresh 40g x288',7,8,'Sack','BUTAL',895,288,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(743,'MAIN_879','Champion Powder SUPRA POWER Citrus Fresh 120g x96',7,8,'Sack','BUTAL',896,96,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(744,'MAIN_881','Champion Powder SUPRA POWER Citrus Fresh 400g x24',7,8,'Sack','BUTAL',897,24,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(745,'MAIN_883','Champion Powder SUPRA POWER Citrus Fresh 800g x12',7,8,'Sack','BUTAL',898,12,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(746,'MAIN_885','Champion Powder SUPRA POWER Citrus Fresh 2kg x6',7,8,'Sack','BUTAL',899,6,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(747,'MAIN_887','Champion Powder SUPRA POWER Sunny Fresh 40g x288',7,8,'Sack','BUTAL',900,288,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(748,'MAIN_889','Champion Powder SUPRA POWER Sunny Fresh 120g x96',7,8,'Sack','BUTAL',901,96,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(749,'MAIN_891','Champion Powder SUPRA POWER Sunny Fresh 800g x12',7,8,'Sack','BUTAL',902,12,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(750,'MAIN_893','Champion Powder SUPRA POWER Sunny Fresh 2000g x6',7,8,'Sack','BUTAL',903,6,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(751,'MAIN_895','Champion Powder SUPRA POWER w/ Fabric Conditioner 40g x288',7,8,'Sack','BUTAL',904,288,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(752,'MAIN_897','Champion Powder SUPRA POWER w/ Fabric Conditioner 120g x96',7,8,'Sack','BUTAL',905,96,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(753,'MAIN_899','Champion Powder SUPRA POWER w/ Fabric Conditioner 800g x12',7,8,'Sack','BUTAL',906,12,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(754,'MAIN_901','Champion Powder SUPRA POWER w/ Fabric Conditioner 2Kg x6',7,8,'Sack','BUTAL',907,6,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(755,'MAIN_903','Champion HYBRID SUPRA (FabCon AB FD 28ml + Pow Supra 40g) x96',7,8,'Case','BUTAL',908,96,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(756,'MAIN_905','Calla Powder Rose Garden 1.6kg x6',7,8,'Sack','BUTAL',909,6,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(757,'MAIN_907','Calla Powder Summer Fresh 1.6kg x6',7,8,'Sack','BUTAL',910,6,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(758,'MAIN_909','Champion Todo Tipid SUPRA POWER (TP145g & P40g)X 48',9,8,'Case','BUTAL',911,48,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(759,'MAIN_910','Hana Shampoo S & S Spring Flowers & Apples 21ml x 192',12,8,'Case','BUTAL',912,192,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(760,'MAIN_915','Champion Liquid Fabric Conditioner ANTIBACTERIAL FRESH DAY (SUP) 1000ml x 12',10,8,'Case','BUTAL',913,12,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(761,'MAIN_917','Champion Liquid Fabric Conditioner ANTIBACTERIAL PINK FRESH (SUP) 1000ml x 12',10,8,'Case','BUTAL',914,12,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(762,'MAIN_919','Champion Liquid Fabric Conditioner ANTIBAC BLUE SERENITY (SUP) 1000ml x 12',10,8,'Case','BUTAL',915,12,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(763,'MAIN_935','Champion Powder SUPRA POWER Supra Clean 40g (6pcs+1FREE) x 48',7,8,'Sack','BUTAL',916,48,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(764,'MAIN_937','Calla Powder Floral Fresh 45g (6pcs+1FREE)  x 40',7,8,'Sack','BUTAL',917,40,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(765,'MAIN_939','Calla Liquid Fabric Conditioner SUNNY BLUE 28ml X216',10,8,'Case','BUTAL',918,216,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(766,'MAIN_941','Calla Liquid Fabric Conditioner SUNNY BLUE (SUP) 1000ml X12',10,8,'Case','BUTAL',919,12,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(767,'MAIN_943','Calla Liquid Fabric Conditioner PINK PARADISE 28ml X216',10,8,'Case','BUTAL',920,216,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(768,'MAIN_945','Calla Liquid Fabric Conditioner PINK PARADISE (SUP) 1000ml X12',10,8,'Case','BUTAL',921,12,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(769,'MAIN_949','Champion Powder SUPRA POWER Supra Clean 800g (1+1DT290g) X12',7,8,'Sack','BUTAL',922,12,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(770,'MAIN_951','Champion Powder SUPRA POWER w/ Fabric Conditioner 800g (1+1DT290g) X 12',7,8,'Sack','BUTAL',923,12,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(771,'MAIN_957','Champion Powder SUPRA POWER Machine Wash 5000g X 2',7,8,'Sack','BUTAL',924,2,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(772,'MAIN_961','Champion Powder SUPRA POWER Sunny Fresh 35g X 288',7,8,'Sack','BUTAL',925,288,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(773,'MAIN_963','Champion Dishwashing Liquid Lemon Fresh (SUP) 1000ml X 12',11,8,'Case','BUTAL',926,12,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(774,'MAIN_965','Champion Powder SUPRA POWER Original Supra Clean 800g (1+4 SC 40g) X 12',7,8,'Bundle','BUTAL',927,12,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(775,'MAIN_967','Champion Powder SUPRA POWER with Fabric Conditioner 800g (1+4 FC 40g) X 12',7,8,'Bundle','BUTAL',928,12,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(776,'MAIN_969','Calla Powder Fabric Conditioner Floral Fresh 800g (1+4 Calla FF 45g) X 12',7,8,'Bundle','BUTAL',929,12,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(777,'MAIN_971','Calla Powder Fabric Conditioner Rose Garden 800g (1+4 Calla RG 45g) X 12',7,8,'Bundle','BUTAL',930,12,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(778,'MAIN_973','Champion Powder SUPRA POWER Citrus Fresh 800g (1+1DT290g) X 12',7,8,'Sack','BUTAL',931,12,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(779,'MAIN_975','Champion Powder SUPRA POWER Citrus Fresh 800g (1+2 TP CF 145g) X 12',7,8,'Sack','BUTAL',932,12,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(780,'MAIN_977','Champion Powder SUPRA POWER Original Supra Clean 800g (1+2 TP CF 145g) X 12',7,8,'Sack','BUTAL',933,12,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(781,'MAIN_979','Champion Powder SUPRA POWER w/ Fab Con 800g (1+2 TP CF 145g) X 12',7,8,'Sack','BUTAL',934,12,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(782,'MAIN_981','Champion Powder SUPRA POWER w/ Fab Con 2000g (1+2 DT290g) X 6',7,8,'Sack','BUTAL',935,6,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(783,'MAIN_983','Champion Powder SUPRA POWER Supra Clean 2000g (1+1 FabCon390g) X 6',7,8,'Sack','BUTAL',936,6,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(784,'MAIN_985','Champion Powder SUPRA POWER Citrus Fresh 2kg (1+2 DT290g) X 6',7,8,'Sack','BUTAL',937,6,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(785,'MAIN_987','Champion Liquid Detergent Top Load High Foam 80ml X 96',13,8,'Case','BUTAL',938,96,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(786,'MAIN_989','Champion Liquid Detergent Top Load High Foam (SUP) 1000ml X 12',13,8,'Case','BUTAL',939,12,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(787,'MAIN_991','Champion Liquid Detergent Top Load High Foam 1.6L X 6',13,8,'Case','BUTAL',940,6,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(788,'MAIN_993','Champion Liquid Detergent Front Load Low Foam 50ml X 144',13,8,'Case','BUTAL',941,144,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(789,'MAIN_995','Champion Liquid Detergent Front Load Low Foam (SUP) 1000ml X 12',13,8,'Case','BUTAL',942,12,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(790,'MAIN_997','Champion Liquid Detergent Front Load Low Foam 1.6L X 6',13,8,'Case','BUTAL',943,6,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(791,'MAIN_999','Champion Powder SUPRA POWER Original Supra Clean 2000g (1+6 FD 28ml) X 6',7,8,'Sack','BUTAL',944,6,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(792,'MAIN_1025','Calla Todo Special FabCon Floral Fresh 130g x 96',9,8,'Case','BUTAL',945,96,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(793,'MAIN_1103','Champion Powder Supra Power with FabCon 120g (6+1) x 16',7,8,'Sack','BUTAL',946,16,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(794,'MAIN_1105','Champion Powder Supra Power Sunny Fresh 120g (6+1) x 16',7,8,'Sack','BUTAL',947,16,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(795,'MAIN_1107','Champion Powder Supra Power Supra Clean 120g (6+1) x 16',7,8,'Sack','BUTAL',948,16,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(796,'MAIN_1109','Champion Powder Supra Power Citrus Fresh 120g (6+1) x 16',7,8,'Sack','BUTAL',949,16,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(797,'MAIN_1113','Champion Powder Supra Power with FabCon 40g (6+1) x 48',7,8,'Sack','BUTAL',950,48,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(798,'MAIN_1115','Calla Powder Rose Garden 45g (6+1) x 40',7,8,'Sack','BUTAL',951,40,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(799,'MAIN_1127','Champion Bar Supra Power Citrus Fresh 370g x 36',9,8,'Case','BUTAL',952,36,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(800,'MAIN_1129','Champion Bar Supra Power Supra Clean 370g x 36',9,8,'Case','BUTAL',953,36,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(801,'MAIN_1131','Calla Powder Fruity Fresh 45g x 240',7,8,'Sack','BUTAL',954,240,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(802,'MAIN_1125','Champion Todo Tipid Pack SUPRA POWER Original Supra Clean (TP130g & P35g) x 48',9,8,'Case','BUTAL',955,48,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(803,'MAIN_1001','Champion Powder SUPRA POWER with Fab Con 2000g (1+6 PF 28ml) X 6',7,8,'Bundle','CASE',650,6,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(804,'MAIN_1007','Champion Powder SUPRA POWER Citrus Fresh 2kg (1+1 CF 390g) X 6',7,8,'Bundle','CASE',650,6,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(805,'MAIN_1009','Champion HYBRID SUPRA (FabCon Antibac FD 28ml + Powder Supra Clean 35g) X 96',8,8,'Pack','CASE',650,96,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(806,'MAIN_1011','Calla HYBRID (FabCon Sunny Blue 28ml + Powder Floral Fresh 45g) X 96',7,8,'Piece','CASE',650,96,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(807,'MAIN_1013','Champion Powder SUPRA POWER Original Supra Clean 2000g (1+1) X 3',7,8,'Bundle','CASE',650,3,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(808,'MAIN_1015','Champion Powder SUPRA POWER with Fab Con 2000g (1+1) X 3',7,8,'Bundle','CASE',650,3,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(809,'MAIN_1017','Calla Powder Fabric Conditioner Floral Fresh 1.6kg (1+1) X 3',7,8,'Bundle','CASE',650,3,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(810,'MAIN_1019','Calla Powder Fabric Conditioner Rose Garden 1.6kg (1+1) X 3',7,8,'Bundle','CASE',650,3,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(811,'MAIN_1023','Champion Powder SUPRA POWER Original Supra Clean 70g (twin) X 144',7,8,'Sachet','CASE',650,144,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(812,'MAIN_1027','Calla Powder Special Fabric Conditioner Kalamansi Magic 45g X 240',7,8,'Sachet','CASE',650,240,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(813,'MAIN_1029','Calla Powder Special Fabric Conditioner Kalamansi Magic 100g X 120',7,8,'Sachet','CASE',650,120,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(814,'MAIN_1031','Calla Powder Special Fabric Conditioner Kalamansi Magic 800g X 12',7,8,'Sachet','CASE',650,12,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(815,'MAIN_1033','Calla Powder Special Fabric Conditioner Kalamansi Magic 1.6kg X 6',7,8,'Sachet','CASE',650,6,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(816,'MAIN_1035','Calla Bar Special Fabric Conditioner Floral Fresh 370g X 36',9,8,'Bar','CASE',650,36,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(817,'MAIN_1037','Calla Bar Special Fabric Conditioner Blue 370g X 36',9,8,'Bar','CASE',650,36,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(818,'MAIN_1039','Calla Bar Special Fabric Conditioner Rose Garden 370g X 36',9,8,'Bar','CASE',650,36,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(819,'MAIN_1041','Calla Bar Special Fabric Conditioner Summer Fresh 370g X 36',9,8,'Bar','CASE',650,36,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(820,'MAIN_1043','Champion Todo Pack Supra Power BLUE ORIGINAL 130g x 96',9,8,'Bar','CASE',650,96,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(821,'MAIN_1045','Champion Todo Pack SUPRA POWER Citrus Fresh 130g x 96',9,8,'Bar','CASE',650,96,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(822,'MAIN_1047','Champion Todo Pack SUPRA POWER Supra Clean 130g x 96',9,8,'Bar','CASE',650,96,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(823,'MAIN_1049','Champion Todo Pack SUPRA POWER Sunny Fresh 130g x 96',9,8,'BAR','CASE',650,96,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(824,'MAIN_1051','Champion Bar SUPRA POWER Sunny Fresh 370g X 36',9,8,'Bar','CASE',650,36,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(825,'MAIN_1053','Champion Bar SUPRA POWER with Fabric Conditioner 370g X 36',9,8,'Bar','CASE',650,36,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(826,'MAIN_1055','Champion Bar SUPRA POWER Blue Original 370g X 36',9,8,'Bar','CASE',650,36,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(827,'MAIN_1057','Champion Powder SUPRA POWER Citrus Fresh 35g X 288',7,8,'Sachet','CASE',650,288,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(828,'MAIN_1059','Champion Powder SUPRA POWER Original Supra Clean 35g X 288',7,8,'Sachet','CASE',650,288,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(829,'MAIN_1061','Champion Powder SUPRA POWER with Fabric Conditioner 35g X 288',7,8,'Sachet','CASE',650,288,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(830,'MAIN_1063','Champion Powder SUPRA POWER Citrus Fresh 105g X 96',7,8,'Sachet','CASE',650,96,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(831,'MAIN_1065','Champion Powder SUPRA POWER Original Supra Clean 105g X 96',7,8,'Sachet','CASE',650,96,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(832,'MAIN_1067','Champion Powder SUPRA POWER Sunny Fresh 105g X 96',7,8,'Sachet','CASE',650,96,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(833,'MAIN_1069','Champion Powder SUPRA POWER with Fabric Conditioner 105g X 96',7,8,'Sachet','CASE',650,96,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(834,'MAIN_408','Calla Powder  Summer Fresh 100g x 120',7,8,'Sachet','CASE',650,120,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(835,'MAIN_414','Calla Powder  Rose Garden 100g x 120',7,8,'Sachet','CASE',650,120,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(836,'MAIN_582','Calla Powder  Floral Fresh 45g x 240',7,8,'Sachet','CASE',650,240,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(837,'MAIN_584','Calla Powder  Summer Fresh 45g x 240',7,8,'Sachet','CASE',650,240,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(838,'MAIN_586','Calla Powder Rose Garden 45g x 240',7,8,'Sachet','CASE',650,240,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(839,'MAIN_588','Champion Dishwashing Liquid Lemon Fresh 190ml x 36',11,8,'Piece','CASE',650,36,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(840,'MAIN_590','Champion Dishwashing Liquid Lemon Fresh 275ml x 24',11,8,'Piece','CASE',650,24,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(841,'MAIN_599','Champion Liquid FabCon HS Blue Serenity 28ml x 216',10,8,'Piece','CASE',650,216,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(842,'MAIN_608','Calla Powder  Floral Fresh 100g x 120',7,8,'Sachet','CASE',650,120,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(843,'MAIN_644','Champion Dishwashing Liquid Lemon Fresh 20ml x 216',11,8,'Piece','CASE',650,216,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(844,'MAIN_646','Champion Dishwashing Liquid Kalamansi Fresh 20ml x 216',11,8,'Piece','CASE',650,216,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(845,'MAIN_648','Champion Dishwashing Liquid Kalamansi Fresh 190ml x 36',11,8,'Piece','CASE',650,36,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(846,'MAIN_650','Champion Dishwashing Liquid Kalamansi Fresh 275ml x 24',11,8,'Piece','CASE',650,24,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(847,'MAIN_695','Champion Double Todo SUPRA CLEAN 290g x 48',9,8,'0','CASE',650,48,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(848,'MAIN_699','Hana Shampoo Pink Roses & Berries 14ml x 384',12,8,'Piece','CASE',650,384,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(849,'MAIN_701','Hana Shampoo Pink Roses & Berries 100ml x 48',12,8,'Piece','CASE',650,48,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(850,'MAIN_703','Hana Shampoo Pink Roses & Berries 200ml x 24',12,8,'Piece','CASE',650,24,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(851,'MAIN_707','Hana Shampoo Spring Flowers & Apples 14ml x 384',12,8,'Piece','CASE',650,384,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(852,'MAIN_709','Hana Shampoo Spring Flowers & Apples 100ml x 48',12,8,'Piece','CASE',650,48,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(853,'MAIN_711','Hana Shampoo Spring Flowers & Apples 200ml x 24',12,8,'Bundle','CASE',650,24,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(854,'MAIN_715','Hana Shampoo Garden Blooms & Lychees 14ml x 384',12,8,'Piece','CASE',650,384,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(855,'MAIN_717','Hana Shampoo Garden Blooms & Lychees 100ml x 48',12,8,'Piece','CASE',650,48,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(856,'MAIN_719','Hana Shampoo Garden Blooms & Lychees 200ml x 24',12,8,'Piece','CASE',650,24,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(857,'MAIN_723','Champion Bar  BLUE SPECIAL 390g x 36',9,8,'Bar','CASE',650,36,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(858,'MAIN_735','Hana Shampoo S & S Pink Roses & Berries 21ml x 192',12,8,'Piece','CASE',650,192,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(859,'MAIN_741','Champion Powder  WHITE PROTECT 40g x 288',7,8,'Sachet','CASE',650,288,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(860,'MAIN_747','Champion Powder Machine Wash 50g x 216',7,8,'Sachet','CASE',650,216,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(861,'MAIN_749','Champion Powder Machine Wash 1.6kg x 6',7,8,'Sachet','CASE',650,6,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(862,'MAIN_751','Calla Bar  Floral Fresh 390g x 36',9,8,'Bar','CASE',650,36,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(863,'MAIN_757','HANA COMBO PACK (SHAM PR & BS 14ML +COND SOFT & SMOOTH 10ML)',12,8,'Pack','CASE',650,192,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(864,'MAIN_767','CALLA BAR BLUE 390G',9,8,'Bar','CASE',650,36,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(865,'MAIN_783','P-HANA SHAMPOO S&S PINK ROSES & BERRIES 21ML (10+2) x 16',12,8,'Bundle','CASE',650,16,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(866,'MAIN_801','Champion Powder  BLUE SPECKLES 40g x 288',7,8,'Sachet','CASE',650,288,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(867,'MAIN_807','Champion Powder WHITE PROTECT 1.6kg x 6',7,8,'Sachet','CASE',650,6,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(868,'MAIN_809','Calla Powder Floral Fresh 400g X 24',7,8,'Sachet','CASE',650,24,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(869,'MAIN_811','Calla Powder Floral Fresh 800g X 12',7,8,'Sachet','CASE',650,12,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(870,'MAIN_813','Calla Powder  Rose Garden 800g x 12',7,8,'Sachet','CASE',650,12,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(871,'MAIN_815','Calla Powder  Summer Fresh 800g x 12',7,8,'Sachet','CASE',650,12,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(872,'MAIN_819','Calla Powder Special Fabric Conditioner Floral Fresh 1.6kg x 6',7,8,'Sachet','CASE',650,6,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(873,'MAIN_831','Calla Bar Rose Garden 390g x 36',9,8,'Bar','CASE',650,36,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(874,'MAIN_833','Calla Bar Summer Fresh 390g x 36',9,8,'Bar','CASE',650,36,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(875,'MAIN_835','Champion Bar SUPRA POWER Blue Original 390g x36',9,8,'Bar','CASE',650,36,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(876,'MAIN_837','Champion Bar SUPRA POWER Citrus Fresh 390g x36',9,8,'Bar','CASE',650,36,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(877,'MAIN_839','Champion Bar SUPRA POWER Sunny Fresh 390g x36',9,8,'Bar','CASE',650,36,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(878,'MAIN_841','Champion Bar SUPRA POWER Original Supra Clean 390g x36',9,8,'Bar','CASE',650,36,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(879,'MAIN_843','Champion Bar SUPRA POWER with Fabric Conditioner 390g x 36',9,8,'Bar','CASE',650,36,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(880,'MAIN_845','Champion Todo Pack SUPRA POWER Blue Original 145g x96',9,8,'Bar','CASE',650,96,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(881,'MAIN_847','Champion Todo Pack SUPRA POWER Citrus Fresh 145g x96',9,8,'Bar','CASE',650,96,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(882,'MAIN_849','Champion Todo SUPRA POWER Supra Clean 145g X 96',9,8,'Bar','CASE',650,96,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(883,'MAIN_851','Champion Todo Pack SUPRA POWER Sunny Fresh 145g x96',9,8,'Bar','CASE',650,96,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(884,'MAIN_853','Champion Powder SUPRA POWER Supra Clean 40g x288',7,8,'Sachet','CASE',650,288,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(885,'MAIN_855','Champion Powder SUPRA POWER Supra Clean 120g x96',7,8,'Sachet','CASE',650,96,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(886,'MAIN_857','Champion Powder SUPRA POWER Supra Clean 400g x24',7,8,'Sachet','CASE',650,24,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(887,'MAIN_859','Champion Powder SUPRA POWER Supra Clean 800g x12',7,8,'Sachet','CASE',650,12,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(888,'MAIN_861','Champion Powder SUPRA POWER Supra Clean 2000g x6',7,8,'Sachet','CASE',650,6,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(889,'MAIN_865','Champion Liquid FabCon ANTIBACTERIAL FRESH DAY 28ml x216',10,8,'Piece','CASE',650,216,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(890,'MAIN_867','Champion Liquid FabCon ANTIBACTERIAL FRESH DAY 50ml x144',10,8,'Piece','CASE',650,144,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(891,'MAIN_869','Champion Liquid FabCon ANTIBACTERIAL FRESH DAY 1000ml x12',10,8,'Piece','CASE',650,12,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(892,'MAIN_871','Champion Liquid FabCon ANTIBACTERIAL PINK FRESH 28ml x216',10,8,'Piece','CASE',650,216,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(893,'MAIN_873','Champion Liquid FabCon ANTIBACTERIAL PINK FRESH 50ml x144',10,8,'Piece','CASE',650,144,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(894,'MAIN_875','Champion Liquid FabCon ANTIBACTERIAL PINK FRESH 1000ml x12',10,8,'Piece','CASE',650,12,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(895,'MAIN_877','Champion Powder SUPRA POWER Citrus Fresh 40g x288',7,8,'Sachet','CASE',650,288,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(896,'MAIN_879','Champion Powder SUPRA POWER Citrus Fresh 120g x96',7,8,'Sachet','CASE',650,96,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(897,'MAIN_881','Champion Powder SUPRA POWER Citrus Fresh 400g x24',7,8,'Sachet','CASE',650,24,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(898,'MAIN_883','Champion Powder SUPRA POWER Citrus Fresh 800g x12',7,8,'Sachet','CASE',650,12,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(899,'MAIN_885','Champion Powder SUPRA POWER Citrus Fresh 2kg x6',7,8,'Sachet','CASE',650,6,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(900,'MAIN_887','Champion Powder SUPRA POWER Sunny Fresh 40g x288',7,8,'Sachet','CASE',650,288,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(901,'MAIN_889','Champion Powder SUPRA POWER Sunny Fresh 120g x96',7,8,'Sachet','CASE',650,96,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(902,'MAIN_891','Champion Powder SUPRA POWER Sunny Fresh 800g x12',7,8,'Sachet','CASE',650,12,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(903,'MAIN_893','Champion Powder SUPRA POWER Sunny Fresh 2000g x6',7,8,'Sachet','CASE',650,6,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(904,'MAIN_895','Champion Powder SUPRA POWER w/ Fabric Conditioner 40g x288',7,8,'Sachet','CASE',650,288,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(905,'MAIN_897','Champion Powder SUPRA POWER w/ Fabric Conditioner 120g x96',7,8,'Sachet','CASE',650,96,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(906,'MAIN_899','Champion Powder SUPRA POWER w/ Fabric Conditioner 800g x12',7,8,'Sachet','CASE',650,12,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(907,'MAIN_901','Champion Powder SUPRA POWER w/ Fabric Conditioner 2Kg x6',7,8,'Sachet','CASE',650,6,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(908,'MAIN_903','Champion HYBRID SUPRA (FabCon AB FD 28ml + Pow Supra 40g) x96',7,8,'Pack','CASE',650,96,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(909,'MAIN_905','Calla Powder Rose Garden 1.6kg x6',7,8,'Sachet','CASE',650,6,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(910,'MAIN_907','Calla Powder Summer Fresh 1.6kg x6',7,8,'Sachet','CASE',650,6,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(911,'MAIN_909','Champion Todo Tipid SUPRA POWER (TP145g & P40g)X 48',9,8,'Bar','CASE',650,48,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(912,'MAIN_910','Hana Shampoo S & S Spring Flowers & Apples 21ml x 192',12,8,'Sachet','CASE',650,192,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(913,'MAIN_915','Champion Liquid Fabric Conditioner ANTIBACTERIAL FRESH DAY (SUP) 1000ml x 12',10,8,'Piece','CASE',650,12,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(914,'MAIN_917','Champion Liquid Fabric Conditioner ANTIBACTERIAL PINK FRESH (SUP) 1000ml x 12',10,8,'Piece','CASE',650,12,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(915,'MAIN_919','Champion Liquid Fabric Conditioner ANTIBAC BLUE SERENITY (SUP) 1000ml x 12',10,8,'Piece','CASE',650,12,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(916,'MAIN_935','Champion Powder SUPRA POWER Supra Clean 40g (6pcs+1FREE) x 48',7,8,'Bundle','CASE',650,48,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(917,'MAIN_937','Calla Powder Floral Fresh 45g (6pcs+1FREE)  x 40',7,8,'Bundle','CASE',650,40,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(918,'MAIN_939','Calla Liquid Fabric Conditioner SUNNY BLUE 28ml X216',10,8,'Sachet','CASE',650,216,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(919,'MAIN_941','Calla Liquid Fabric Conditioner SUNNY BLUE (SUP) 1000ml X12',10,8,'Pouch','CASE',650,12,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(920,'MAIN_943','Calla Liquid Fabric Conditioner PINK PARADISE 28ml X216',10,8,'Sachet','CASE',650,216,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(921,'MAIN_945','Calla Liquid Fabric Conditioner PINK PARADISE (SUP) 1000ml X12',10,8,'Pouch','CASE',650,12,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(922,'MAIN_949','Champion Powder SUPRA POWER Supra Clean 800g (1+1DT290g) X12',7,8,'Bundle','CASE',650,12,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(923,'MAIN_951','Champion Powder SUPRA POWER w/ Fabric Conditioner 800g (1+1DT290g) X 12',7,8,'Bundle','CASE',650,12,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(924,'MAIN_957','Champion Powder SUPRA POWER Machine Wash 5000g X 2',7,8,'Bag','CASE',650,2,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(925,'MAIN_961','Champion Powder SUPRA POWER Sunny Fresh 35g X 288',7,8,'Sachet','CASE',650,288,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(926,'MAIN_963','Champion Dishwashing Liquid Lemon Fresh (SUP) 1000ml X 12',11,8,'Piece','CASE',650,12,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(927,'MAIN_965','Champion Powder SUPRA POWER Original Supra Clean 800g (1+4 SC 40g) X 12',7,8,'Bundle','CASE',650,12,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(928,'MAIN_967','Champion Powder SUPRA POWER with Fabric Conditioner 800g (1+4 FC 40g) X 12',7,8,'Bundle','CASE',650,12,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(929,'MAIN_969','Calla Powder Fabric Conditioner Floral Fresh 800g (1+4 Calla FF 45g) X 12',7,8,'Bundle','CASE',650,12,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(930,'MAIN_971','Calla Powder Fabric Conditioner Rose Garden 800g (1+4 Calla RG 45g) X 12',7,8,'Bundle','CASE',650,12,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(931,'MAIN_973','Champion Powder SUPRA POWER Citrus Fresh 800g (1+1DT290g) X 12',7,8,'Bundle','CASE',650,12,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(932,'MAIN_975','Champion Powder SUPRA POWER Citrus Fresh 800g (1+2 TP CF 145g) X 12',7,8,'Bundle','CASE',650,12,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(933,'MAIN_977','Champion Powder SUPRA POWER Original Supra Clean 800g (1+2 TP CF 145g) X 12',7,8,'Bundle','CASE',650,12,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(934,'MAIN_979','Champion Powder SUPRA POWER w/ Fab Con 800g (1+2 TP CF 145g) X 12',7,8,'Bundle','CASE',650,12,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(935,'MAIN_981','Champion Powder SUPRA POWER w/ Fab Con 2000g (1+2 DT290g) X 6',7,8,'Bundle','CASE',650,6,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(936,'MAIN_983','Champion Powder SUPRA POWER Supra Clean 2000g (1+1 FabCon390g) X 6',7,8,'Bundle','CASE',650,6,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(937,'MAIN_985','Champion Powder SUPRA POWER Citrus Fresh 2kg (1+2 DT290g) X 6',7,8,'Bundle','CASE',650,6,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(938,'MAIN_987','Champion Liquid Detergent Top Load High Foam 80ml X 96',13,8,'Piece','CASE',650,96,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(939,'MAIN_989','Champion Liquid Detergent Top Load High Foam (SUP) 1000ml X 12',13,8,'Piece','CASE',650,12,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(940,'MAIN_991','Champion Liquid Detergent Top Load High Foam 1.6L X 6',13,8,'Piece','CASE',650,6,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(941,'MAIN_993','Champion Liquid Detergent Front Load Low Foam 50ml X 144',13,8,'Piece','CASE',650,144,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(942,'MAIN_995','Champion Liquid Detergent Front Load Low Foam (SUP) 1000ml X 12',13,8,'Piece','CASE',650,12,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(943,'MAIN_997','Champion Liquid Detergent Front Load Low Foam 1.6L X 6',13,8,'Piece','CASE',650,6,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(944,'MAIN_999','Champion Powder SUPRA POWER Original Supra Clean 2000g (1+6 FD 28ml) X 6',7,8,'Bundle','CASE',650,6,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(945,'MAIN_1025','Calla Todo Special FabCon Floral Fresh 130g x 96',9,8,'Bar','CASE',650,96,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(946,'MAIN_1103','Champion Powder Supra Power with FabCon 120g (6+1) x 16',7,8,'Bundle','CASE',650,16,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(947,'MAIN_1105','Champion Powder Supra Power Sunny Fresh 120g (6+1) x 16',7,8,'Bundle','CASE',650,16,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(948,'MAIN_1107','Champion Powder Supra Power Supra Clean 120g (6+1) x 16',7,8,'Bundle','CASE',650,16,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(949,'MAIN_1109','Champion Powder Supra Power Citrus Fresh 120g (6+1) x 16',7,8,'Bundle','CASE',650,16,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(950,'MAIN_1113','Champion Powder Supra Power with FabCon 40g (6+1) x 48',7,8,'Bundle','CASE',650,48,0,'SLOW MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(951,'MAIN_1115','Calla Powder Rose Garden 45g (6+1) x 40',7,8,'Bundle','CASE',650,40,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(952,'MAIN_1127','Champion Bar Supra Power Citrus Fresh 370g x 36',9,8,'Bar','CASE',650,36,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(953,'MAIN_1129','Champion Bar Supra Power Supra Clean 370g x 36',9,8,'Bar','CASE',650,36,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(954,'MAIN_1131','Calla Powder Fruity Fresh 45g x 240',7,8,'Sachet','CASE',650,240,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(955,'MAIN_1125','Champion Todo Tipid Pack SUPRA POWER Original Supra Clean (TP130g & P35g) x 48',9,8,'Bar','CASE',650,48,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(956,'SCG7','SUPER CRUNCH GREEN 7G',36,3,'PACK','BUTAL',1034,20,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(957,'SCBL7','SUPER CRUNCH BLUE 7G',36,3,'PACK','BUTAL',1035,20,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(958,'SCR7','SUPER CRUNC RED 7G',36,3,'PACK','BUTAL',1036,20,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(959,'SCY7','SUPER CRUNCH YELLOW 7G',36,3,'PACK','BUTAL',1037,20,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(960,'TCG7','TAGAY CHILI & GARLIC 7G',36,3,'PACK','BUTAL',1038,20,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(961,'RCBBQ7','RED CHILI BBQ 7G',36,3,'PACK','BUTAL',1039,20,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(962,'SCBBQ7','SWEET CHILI BBQ 7G',36,3,'PACK','BUTAL',1040,20,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(963,'BCBBQ7','BACK CHILI BBQ 7G',36,3,'PACK','BUTAL',1041,20,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(964,'HCL5','HITS CARAMEL 5G',36,3,'PACK','BUTAL',1042,20,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(965,'HCC5','HITS CHOCOLATE 5G',36,3,'PACK','BUTAL',1043,20,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(966,'HSS5','HITS STRAWBERRY 54G',36,3,'PACK','BUTAL',1044,20,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(967,'IC5 ','IKASHI CUTTLEFISH 5G',36,3,'PACK','BUTAL',1045,20,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(968,'ISS5','IKASHI SOY SAUCE 5G',36,3,'PACK','BUTAL',1046,20,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(969,'RCBBQ55','RED CHILI BBQ 55G',36,3,'PACK','BUTAL',1047,20,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(970,'SCBBQ55','SWEET CHILI BBQ 55G',36,3,'PACK','BUTAL',1048,5,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(971,'BCBBQ55','BACK CHILI BBQ 55G',36,3,'PACK','BUTAL',1049,5,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(972,'TCG55','TAGY CHILI & GARLIC 55G',36,3,'PACK','BUTAL',1050,5,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(973,'YSH18','YIPYAP SPEEDY HOT 18G',36,3,'PACK','BUTAL',1051,20,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(974,'YNC18','YIPYAP NACHO CHESE 18G',36,3,'PACK','BUTAL',1052,20,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(975,'YS18','YIPYAP SWEETCORN 18G',36,3,'PACK','BUTAL',1053,20,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(976,'YBP18','YIPYAP BLACK PEPPER 18G',36,3,'PACK','BUTAL',1054,20,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(977,'SCCH5','SUPER CRUNCH CHEESE 55G',36,3,'PACK','BUTAL',1055,5,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(978,'SCS55','SUPER CRUNCH SWEETCORN 55G',36,3,'PACK','BUTAL',1056,5,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(979,'SCR5','SUPER CRUNCH RED 55G',36,3,'PACK','BUTAL',1057,5,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(980,'SCCC5','SUPER CRUCNH CHEESE CHEDAR',36,3,'PACK','BUTAL',1058,5,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(981,'SCC120','SUPER CRUNCH CHEESE 120G',36,3,'PACK','BUTAL',1059,50,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(982,'SCG120','SUPER CRUNCH SWEETCORN 120G',36,3,'PACK','BUTAL',1060,50,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(983,'BMC110','BIG MUNCH CHEESE 110G',36,3,'PACK','BUTAL',1061,25,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(984,'BMB110','BIG MUNCH BBQ 110G',36,3,'PACK','BUTAL',1062,25,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(985,'YCRC14','YIPYAP CORN RING CHEESE 14G',36,3,'PACK','BUTAL',1063,20,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(986,'YCSS20','YIPYAP CORN RING SWEET & SPICY14G',36,3,'PACK','BUTAL',1064,20,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(987,'SCCF7 (BAG)','SUPER CRUNCH CHOCO FLAKES 7G',36,3,'PACK','BUTAL',1065,20,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(988,'SCCF7 (BAG)','SUPER CRUNCH CHOCO FLAKES 7G',36,3,'PACK','BUTAL',1066,20,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(989,'SBS180 (CASE)','S.D BROWNIE SCOTCH 180g',36,3,'PACK','BUTAL',1067,24,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(990,'SCCHLK415','SUPER CRUNCHCHICHARONLECHON',36,3,'PACK','BUTAL',1068,12,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(991,'SCCHR22','SUPER CRUNCH CHEESERING22Gx25',36,3,'PACK','BUTAL',1069,4,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(992,'SCCLK32','SUPER CRUNCH CHIPCHARON LECHON',36,3,'PACK','BUTAL',1070,10,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(993,'SCCP30','SUPER CRUNCH CHEESE PUFFS 30',36,3,'PACK','BUTAL',1071,10,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(994,'SCCP300','SUPER CRUNCH CHEESE PUFF300G',36,3,'PACK','BUTAL',1072,12,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(995,'SCCPB32','SUPER CRUNCH CHIPHARON PINOY',36,3,'PACK','BUTAL',1073,10,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(996,'SCCR370','SUPER CRUNCH CHEESE RING370G',36,3,'PACK','BUTAL',1074,12,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(997,'SCFC48','S.CRUNCH FISH CHARAP 32g.',36,3,'PACK','BUTAL',1075,10,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(998,'SCNB48','SUPER CRUNCH NACHO BBQ 48g',36,3,'PACK','BUTAL',1076,10,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(999,'SCNBHSB 25G','SUPER CRUNCH BLAZIN HOT 25G',36,3,'PACK','BUTAL',1077,4,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1000,'SCNC48','SUPER CRUNCH NACHO CHEESE 48g',36,3,'PACK','BUTAL',1078,5,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1001,'SCNC500','SUPER CRUNC NACHOS CHEESE 500G',36,3,'PACK','BUTAL',1079,12,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1002,'SCNPP','SUPER CRUNCH NACHOS PEPPER 25',36,3,'PACK','BUTAL',1080,4,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1003,'SCP330','SNACKERS CHEESY PUFF 330g',36,3,'PACK','BUTAL',1081,15,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1004,'SNCR400','SNACKERS CHEESE RING 400g',36,3,'PACK','BUTAL',1082,15,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1005,'SCS500','SUPER CRUNCH SWEETCORN500G',36,3,'PACK','BUTAL',1083,12,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1006,'SDBB14(CASE)','SUPER DELIGHTS BROWNIE BITE 14',36,3,'PACK','BUTAL',1084,12,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1007,'SDBB200 (CASE)','SUPER DELIGHT BROWNIE BITES',36,3,'PACK','BUTAL',1085,24,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1008,'SDBBCAN (CASE)','SUPER DELIGHT BROWNIE BITES CA',36,3,'PACK','BUTAL',1086,6,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1009,'SDBS14 (CASE)','SUPER DELIGTHS BROWNIES SCOTCH',36,3,'PACK','BUTAL',1087,12,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1010,'SDBS180 (CASE)','SUPER DELIGHT BROWNIE SCOTH',36,3,'PACK','BUTAL',1088,24,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1011,'SDBSB14 (CASE).','SUPER DELIGHTS BUTTERSCOTCH 14',36,3,'PACK','BUTAL',1089,12,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1012,'SDBSB180-CASE','S.D BUTTERSCOTCH BITES 180G',36,3,'PACK','BUTAL',1090,24,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1013,'SDCC120 (CASE)','SUPER DELIGHT REG. CHOCO CHIP',36,3,'PACK','BUTAL',1091,24,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1014,'SDMCC175 (CASE)','SUPER DELIGHT MINI CHOCO CHIP',36,3,'PACK','BUTAL',1092,24,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1015,'SDMCC28','super delight mini chochip 28g',36,3,'PACK','BUTAL',1093,100,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1016,'SDRCC400','super delight reg chocolate 40',36,3,'PACK','BUTAL',1094,100,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1017,'SNBBQ500','SNACKERS NACHOS BBQ 500G x 20s',36,3,'PACK','BUTAL',1095,20,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1018,'SNC500','SNACKERS NACHOS CHEESE 500g',36,3,'PACK','BUTAL',1096,20,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1019,'SNCLK415','SNACKER CHIPCHARON LECHON KAWA',36,3,'PACK','BUTAL',1097,15,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1020,'SNCPB415','SNACKER CHIPCHARON PINOY BAWAN',36,3,'PACK','BUTAL',1098,15,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1021,'SNCSS415','SNACKER CHIPCHARON SUKATSILI41',36,3,'PACK','BUTAL',1099,15,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1022,'SNP500','SNACKERS NACHOS PLAIN 500g',36,3,'PACK','BUTAL',1100,20,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1023,'SNS500','SNACKERS NACHOS SWEETCORN 500',36,3,'PACK','BUTAL',1101,20,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1024,'SNSS500','SNACKERS NACHOS SWEET & SPICY',36,3,'PACK','BUTAL',1102,20,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1025,'SPP500','SUPER PAMASKO PACK 500G',36,3,'PACK','BUTAL',1103,20,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1026,'YMCB5 ','YAPPEE MILK CHOCOLATE BAR 5G',36,3,'PACK','BUTAL',1104,20,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1027,'YNC18 ','YIPYAP NACHO CHEESE 18G',36,3,'PACK','BUTAL',1105,20,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1028,'YPBB5 ','YAPPEE PEANUT BUTTER BAR 5G',36,3,'PACK','BUTAL',1106,20,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1029,'YTCF5 ','YAPPEE TWINS C-FILLED SNACK 5G',36,3,'PACK','BUTAL',1107,20,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1030,'YTUF5 ','YAPPEE TWINS U-FILLED SNACK 5G',36,3,'PACK','BUTAL',1108,20,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1031,'YCSH55','YIPYAP CORNSNACK SPEEDY HOT 55',36,3,'PACK','BUTAL',1109,5,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1032,'CCER12 ','CHUMZ CHEESE RING 12G',36,3,'PACK','BUTAL',1110,10,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1033,'CCR55 ','CHUMZ CHEESE RING 55G',36,3,'PACK','BUTAL',1111,25,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1034,'SCG7','SUPER CRUNCH GREEN 7G',36,3,'BAG/PACKS','CASE',956,20,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1035,'SCBL7','SUPER CRUNCH BLUE 7G',36,3,'BAG/PACKS','CASE',957,20,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1036,'SCR7','SUPER CRUNC RED 7G',36,3,'BAG/PACKS','CASE',958,20,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1037,'SCY7','SUPER CRUNCH YELLOW 7G',36,3,'BAG/PACKS','CASE',959,20,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1038,'TCG7','TAGAY CHILI & GARLIC 7G',36,3,'BAG/PACKS','CASE',960,20,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1039,'RCBBQ7','RED CHILI BBQ 7G',36,3,'BAG/PACKS','CASE',961,20,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1040,'SCBBQ7','SWEET CHILI BBQ 7G',36,3,'BAG/PACKS','CASE',962,20,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1041,'BCBBQ7','BACK CHILI BBQ 7G',36,3,'BAG/PACKS','CASE',963,20,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1042,'HCL5','HITS CARAMEL 5G',36,3,'BAG/PACKS','CASE',964,20,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1043,'HCC5','HITS CHOCOLATE 5G',36,3,'BAG/PACKS','CASE',965,20,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1044,'HSS5','HITS STRAWBERRY 54G',36,3,'BAG/PACKS','CASE',966,20,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1045,'IC5 ','IKASHI CUTTLEFISH 5G',36,3,'BAG/PACKS','CASE',967,20,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1046,'ISS5','IKASHI SOY SAUCE 5G',36,3,'BAG/PACKS','CASE',968,20,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1047,'RCBBQ55','RED CHILI BBQ 55G',36,3,'BAG/PACKS','CASE',969,20,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1048,'SCBBQ55','SWEET CHILI BBQ 55G',36,3,'BAG/PACKS','CASE',970,5,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1049,'BCBBQ55','BACK CHILI BBQ 55G',36,3,'BAG/PACKS','CASE',971,5,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1050,'TCG55','TAGY CHILI & GARLIC 55G',36,3,'BAG/PACKS','CASE',972,5,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1051,'YSH18','YIPYAP SPEEDY HOT 18G',36,3,'BAG/PACKS','CASE',973,20,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1052,'YNC18','YIPYAP NACHO CHESE 18G',36,3,'BAG/PACKS','CASE',974,20,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1053,'YS18','YIPYAP SWEETCORN 18G',36,3,'BAG/PACKS','CASE',975,20,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1054,'YBP18','YIPYAP BLACK PEPPER 18G',36,3,'BAG/PACKS','CASE',976,20,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1055,'SCCH5','SUPER CRUNCH CHEESE 55G',36,3,'BAG/PACKS','CASE',977,5,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1056,'SCS55','SUPER CRUNCH SWEETCORN 55G',36,3,'BAG/PACKS','CASE',978,5,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1057,'SCR5','SUPER CRUNCH RED 55G',36,3,'BAG/PACKS','CASE',979,5,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1058,'SCCC5','SUPER CRUCNH CHEESE CHEDAR',36,3,'BAG/PACKS','CASE',980,5,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1059,'SCC120','SUPER CRUNCH CHEESE 120G',36,3,'BAG/PACKS','CASE',981,50,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1060,'SCG120','SUPER CRUNCH SWEETCORN 120G',36,3,'BAG/PACKS','CASE',982,50,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1061,'BMC110','BIG MUNCH CHEESE 110G',36,3,'BAG/PACKS','CASE',983,25,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1062,'BMB110','BIG MUNCH BBQ 110G',36,3,'BAG/PACKS','CASE',984,25,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1063,'YCRC14','YIPYAP CORN RING CHEESE 14G',36,3,'BAG/PACKS','CASE',985,20,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1064,'YCSS20','YIPYAP CORN RING SWEET & SPICY14G',36,3,'BAG/PACKS','CASE',986,20,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1065,'SCCF7 (BAG)','SUPER CRUNCH CHOCO FLAKES 7G',36,3,'BAG/PACKS','CASE',987,20,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1066,'SCCF7 (BAG)','SUPER CRUNCH CHOCO FLAKES 7G',36,3,'BAG/PACKS','CASE',988,20,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1067,'SBS180 (CASE)','S.D BROWNIE SCOTCH 180g',36,3,'BAG/PACKS','CASE',989,24,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1068,'SCCHLK415','SUPER CRUNCHCHICHARONLECHON',36,3,'BAG/PACKS','CASE',990,12,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1069,'SCCHR22','SUPER CRUNCH CHEESERING22Gx25',36,3,'BAG/PACKS','CASE',991,4,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1070,'SCCLK32','SUPER CRUNCH CHIPCHARON LECHON',36,3,'BAG/PACKS','CASE',992,10,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1071,'SCCP30','SUPER CRUNCH CHEESE PUFFS 30',36,3,'BAG/PACKS','CASE',993,10,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1072,'SCCP300','SUPER CRUNCH CHEESE PUFF300G',36,3,'CASE/ PACK','CASE',994,12,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1073,'SCCPB32','SUPER CRUNCH CHIPHARON PINOY',36,3,'BAG/PACKS','CASE',995,10,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1074,'SCCR370','SUPER CRUNCH CHEESE RING370G',36,3,'CASE/ PACK','CASE',996,12,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1075,'SCFC48','S.CRUNCH FISH CHARAP 32g.',36,3,'BAG/PACKS','CASE',997,10,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1076,'SCNB48','SUPER CRUNCH NACHO BBQ 48g',36,3,'BAG/PACKS','CASE',998,10,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1077,'SCNBHSB 25G','SUPER CRUNCH BLAZIN HOT 25G',36,3,'BAG/PACKS','CASE',999,4,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1078,'SCNC48','SUPER CRUNCH NACHO CHEESE 48g',36,3,'BAG/PACKS','CASE',1000,5,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1079,'SCNC500','SUPER CRUNC NACHOS CHEESE 500G',36,3,'BAG/PACKS','CASE',1001,12,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1080,'SCNPP','SUPER CRUNCH NACHOS PEPPER 25',36,3,'BAG/PACKS','CASE',1002,4,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1081,'SCP330','SNACKERS CHEESY PUFF 330g',36,3,'BAG/PACKS','CASE',1003,15,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1082,'SNCR400','SNACKERS CHEESE RING 400g',36,3,'CASE/ PACK','CASE',1004,15,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1083,'SCS500','SUPER CRUNCH SWEETCORN500G',36,3,'CASE/ PACK','CASE',1005,12,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1084,'SDBB14(CASE)','SUPER DELIGHTS BROWNIE BITE 14',36,3,'CASE/ PACKS','CASE',1006,12,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1085,'SDBB200 (CASE)','SUPER DELIGHT BROWNIE BITES',36,3,'CASE/ PACK ','CASE',1007,24,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1086,'SDBBCAN (CASE)','SUPER DELIGHT BROWNIE BITES CA',36,3,'CASE/ PACK','CASE',1008,6,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1087,'SDBS14 (CASE)','SUPER DELIGTHS BROWNIES SCOTCH',36,3,'CASE/ PACK ','CASE',1009,12,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1088,'SDBS180 (CASE)','SUPER DELIGHT BROWNIE SCOTH',36,3,'CASE/ PACK','CASE',1010,24,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1089,'SDBSB14 (CASE).','SUPER DELIGHTS BUTTERSCOTCH 14',36,3,'CASE/ PACK','CASE',1011,12,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1090,'SDBSB180-CASE','S.D BUTTERSCOTCH BITES 180G',36,3,'CASE/ PACK','CASE',1012,24,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1091,'SDCC120 (CASE)','SUPER DELIGHT REG. CHOCO CHIP',36,3,'CASE/ PACK','CASE',1013,24,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1092,'SDMCC175 (CASE)','SUPER DELIGHT MINI CHOCO CHIP',36,3,'CASE/ PACK','CASE',1014,24,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1093,'SDMCC28','super delight mini chochip 28g',36,3,'CASE/ PCS','CASE',1015,100,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1094,'SDRCC400','super delight reg chocolate 40',36,3,'CASE/ PCS','CASE',1016,100,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1095,'SNBBQ500','SNACKERS NACHOS BBQ 500G x 20s',36,3,'CASE/ PACK','CASE',1017,20,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1096,'SNC500','SNACKERS NACHOS CHEESE 500g',36,3,'CASE/ PACK','CASE',1018,20,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1097,'SNCLK415','SNACKER CHIPCHARON LECHON KAWA',36,3,'CASE/ PACK','CASE',1019,15,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1098,'SNCPB415','SNACKER CHIPCHARON PINOY BAWAN',36,3,'CASE/ PACK','CASE',1020,15,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1099,'SNCSS415','SNACKER CHIPCHARON SUKATSILI41',36,3,'CASE/ PACK','CASE',1021,15,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1100,'SNP500','SNACKERS NACHOS PLAIN 500g',36,3,'CASE/ PACK','CASE',1022,20,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1101,'SNS500','SNACKERS NACHOS SWEETCORN 500',36,3,'CASE/ PACK','CASE',1023,20,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1102,'SNSS500','SNACKERS NACHOS SWEET & SPICY',36,3,'CASE/ PACK','CASE',1024,20,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1103,'SPP500','SUPER PAMASKO PACK 500G',36,3,'CASE/ PACK','CASE',1025,20,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1104,'YMCB5 ','YAPPEE MILK CHOCOLATE BAR 5G',36,3,'BAG/PACKS','CASE',1026,20,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1105,'YNC18 ','YIPYAP NACHO CHEESE 18G',36,3,'BAG/PACKS','CASE',1027,20,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1106,'YPBB5 ','YAPPEE PEANUT BUTTER BAR 5G',36,3,'BAG/PACKS','CASE',1028,20,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1107,'YTCF5 ','YAPPEE TWINS C-FILLED SNACK 5G',36,3,'BAG/PACKS','CASE',1029,20,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1108,'YTUF5 ','YAPPEE TWINS U-FILLED SNACK 5G',36,3,'BAG/PACKS','CASE',1030,20,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1109,'YCSH55','YIPYAP CORNSNACK SPEEDY HOT 55',36,3,'BAG/PACKS','CASE',1031,5,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1110,'CCER12 ','CHUMZ CHEESE RING 12G',36,3,'BAG/PACKS','CASE',1032,10,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1111,'CCR55 ','CHUMZ CHEESE RING 55G',36,3,'BAG/PACKS','CASE',1033,25,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1112,'801','PINGPONG GUM',20,7,'BUTAL','BUTAL',1270,24,0,'FAST MOVING',NULL,'2023-04-20 06:24:52',0.10,0.00,'4800818808012',NULL,0),
(1113,'848','AMERICAN GUMBALL',20,7,'BUTAL','BUTAL',1271,40,0,'FAST MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'',NULL,0),
(1114,'802','CHERRY GUM',20,7,'BUTAL','BUTAL',1272,24,0,'FAST MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'4800818808029',NULL,0),
(1115,'816','GUMBALLS',20,7,'BUTAL','BUTAL',1273,40,0,'FAST MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'4800818808166',NULL,0),
(1116,'832','SUPER BUBBLE',20,7,'BUTAL','BUTAL',1274,40,0,'FAST MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'4800818808326',NULL,0),
(1117,'876','YAKEE SUPER ASIM GUM BALL',20,7,'BUTAL','BUTAL',1275,40,0,'FAST MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'4800818808760',NULL,0),
(1118,'877','PINTOORA GUMBALL',20,7,'BUTAL','BUTAL',1276,40,0,'FAST MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'4800818808777',NULL,0),
(1119,'980','JUMBO GOLF JAR',20,7,'BUTAL','BUTAL',1277,12,0,'SLOW MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'4800818809255',NULL,0),
(1120,'710','JUMBO CHERRI JAR',20,7,'BUTAL','BUTAL',1278,12,0,'FAST MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'4800818809316',NULL,0),
(1121,'979','JUMBO REG. JAR',20,7,'BUTAL','BUTAL',1279,12,0,'FAST MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'4800818809798',NULL,0),
(1122,'931','JUMBO CHERRI PACK',20,7,'BUTAL','BUTAL',1280,40,0,'FAST MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'4800818807107',NULL,0),
(1123,'839','JUMBO REG. PACK',20,7,'BUTAL','BUTAL',1281,40,0,'FAST MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'4800818808395',NULL,0),
(1124,'145','JUMBO EASTER EGG GUM BALL JAR',20,7,'BUTAL','BUTAL',1282,12,0,'FAST MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'4800818801457',NULL,0),
(1125,'146','JUMBO CRAYON GUM BALL JAR',20,7,'BUTAL','BUTAL',1283,12,0,'FAST MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'4800818801464',NULL,0),
(1126,'975','I COOL MENTHOLATED GUM',20,7,'BUTAL','BUTAL',1284,40,0,'FAST MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'4800818809750',NULL,0),
(1127,'1017','I COOL CHERRY MINT GUM',20,7,'BUTAL','BUTAL',1285,40,0,'FAST MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'4800818810176',NULL,0),
(1128,'135','I COOL TWIN HONEY LEMON',20,7,'BUTAL','BUTAL',1286,50,0,'SLOW MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'',NULL,0),
(1129,'943','I COOL MENTHOL BLISTER PACK',20,7,'BUTAL','BUTAL',1287,8,0,'SLOW MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'',NULL,0),
(1130,'1065','TINI WINI',20,7,'BUTAL','BUTAL',1288,60,0,'SLOW MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'',NULL,0),
(1131,'1087','BLOWEE TATTOO GUM',20,7,'BUTAL','BUTAL',1289,40,0,'FAST MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'4800818810879',NULL,0),
(1132,'947','V FRESH WINTER BLISTER PACK',20,7,'BUTAL','BUTAL',1290,8,0,'SLOW MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'',NULL,0),
(1133,'860','V FRESH JR.',20,7,'BUTAL','BUTAL',1291,60,0,'SLOW MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'',NULL,0),
(1134,'1988','V FRESH WINTERCOOL JAR',20,7,'BUTAL','BUTAL',1292,12,0,'FAST MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'4800818819889',NULL,0),
(1135,'988','V FRESH WINTER COOL GUM',20,7,'BUTAL','BUTAL',1293,40,0,'FAST MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'',NULL,0),
(1136,'678','V FRESH AQUA COOL',20,7,'BUTAL','BUTAL',1294,40,0,'FAST MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'4800818806780',NULL,0),
(1137,'773','V FRESH WINTER COOL BIG PACK',20,7,'BUTAL','BUTAL',1295,10,0,'SLOW MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'',NULL,0),
(1138,'1083','VFRESH XYLITOL SUGAR FREE',20,7,'BUTAL','BUTAL',1296,48,0,'FAST MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'4800818810831',NULL,0),
(1139,'1018','V FRESH SPEARMINT',20,7,'BUTAL','BUTAL',1297,40,0,'FAST MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'',NULL,0),
(1140,'837','BUTTERKIST',21,7,'BUTAL','BUTAL',1298,40,0,'FAST MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'4800818808371',NULL,0),
(1141,'930','I MILK',21,7,'BUTAL','BUTAL',1299,40,0,'FAST MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'4800818809309',NULL,0),
(1142,'965','MON\'AMI STRAWBERRY CREAM',21,7,'BUTAL','BUTAL',1300,40,0,'FAST MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'4800818809651',NULL,0),
(1143,'968','MON\'AMI BUTTERCREAM',21,7,'BUTAL','BUTAL',1301,40,0,'FAST MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'4800818809682',NULL,0),
(1144,'1102','MON\'AMI STRAWBERRY JAR',21,7,'BUTAL','BUTAL',1302,12,0,'FAST MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'4800818811029',NULL,0),
(1145,'1103','MON\'AMI BUTTER CARAMEL JAR',21,7,'BUTAL','BUTAL',1303,12,0,'FAST MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'4800818811036',NULL,0),
(1146,'1101','MONAMI HI CAF? JAR',21,7,'BUTAL','BUTAL',1304,12,0,'FAST MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'4800818811012',NULL,0),
(1147,'1099','MONAMI HI CAF? ',21,7,'BUTAL','BUTAL',1305,40,0,'FAST MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'4800818810992',NULL,0),
(1148,'890','POTCHI STRAWBERRY CREAM',26,7,'BUTAL','BUTAL',1306,40,0,'FAST MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'4800818808906',NULL,0),
(1149,'952','POTCHI MINI STRAWBERRY',26,7,'BUTAL','BUTAL',1307,50,0,'SLOW MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'4800818609527',NULL,0),
(1150,'750','POTCHI STRAWBERRY 50G SP (NEW PACKING)',26,7,'BUTAL','BUTAL',1308,10,0,'SLOW MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'4800818637506',NULL,0),
(1151,'111','POTCHI GUMMI POP JAR',26,7,'BUTAL','BUTAL',1309,12,0,'FAST MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'4800818801112',NULL,0),
(1152,'112','POTCHI HOOLA HOOP JAR',26,7,'BUTAL','BUTAL',1310,12,0,'FAST MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'4800818801129',NULL,0),
(1153,'749','POTCHI 26 WORMS JAR',26,7,'BUTAL','BUTAL',1311,12,0,'FAST MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'4800818807497',NULL,0),
(1154,'1755','POTCHI 26 WORMS STRAP 25G',26,7,'BUTAL','BUTAL',1312,20,0,'SLOW MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'4800818617553',NULL,0),
(1155,'2136','POTCHI DOTS JAR',26,7,'BUTAL','BUTAL',1313,12,0,'SLOW MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'',NULL,0),
(1156,'1136','POTCHI DOTS STRAP',26,7,'BUTAL','BUTAL',1314,20,0,'SLOW MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'',NULL,0),
(1157,'136','POTCHI DOTS SNACK PACK',26,7,'BUTAL','BUTAL',1315,10,0,'SLOW MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'',NULL,0),
(1158,'2142','POTCHI OCTOPUS JAR',26,7,'BUTAL','BUTAL',1316,12,0,'SLOW MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'',NULL,0),
(1159,'1142','POTCHI OCTOPUS STRAP',26,7,'BUTAL','BUTAL',1317,20,0,'SLOW MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'',NULL,0),
(1160,'2153','POTCHI CLOWN FISH JAR',26,7,'BUTAL','BUTAL',1318,12,0,'SLOW MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'',NULL,0),
(1161,'1750','POTCHI STRAWBERRY STRAP',26,7,'BUTAL','BUTAL',1319,20,0,'SLOW MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'',NULL,0),
(1162,'1071','POTCHI ORANGE PASTILLE',26,7,'BUTAL','BUTAL',1320,40,0,'SLOW MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'',NULL,0),
(1163,'1070','POTCHI CLOWN FISH STRAP',26,7,'BUTAL','BUTAL',1321,20,0,'SLOW MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'',NULL,0),
(1164,'1069','POTCHI HOOLA HOOP STRAP',26,7,'BUTAL','BUTAL',1322,20,0,'SLOW MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'',NULL,0),
(1165,'1859','POTCHI 26 WORMS REFILL PACK',26,7,'BUTAL','BUTAL',1323,24,0,'SLOW MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'',NULL,0),
(1166,'1860','POTCHI BERRY 26 REFILL PACK',26,7,'BUTAL','BUTAL',1324,24,0,'SLOW MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'',NULL,0),
(1167,'1861','POTCHI HOOLA HOOP REFILL PACK',26,7,'BUTAL','BUTAL',1325,24,0,'SLOW MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'',NULL,0),
(1168,'1862','POTCHI CLOWN FISH REFILL PACK',26,7,'BUTAL','BUTAL',1326,24,0,'SLOW MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'',NULL,0),
(1169,'1096','POTCHI FAN-FAN ',26,7,'BUTAL','BUTAL',1327,20,0,'SLOW MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'',NULL,0),
(1170,'1080','POTCHI 26 BEAR BARKADA PACK',26,7,'BUTAL','BUTAL',1328,20,0,'SLOW MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'',NULL,0),
(1171,'1076','POTCHI HOOLA HOOP BARKADA PACK',26,7,'BUTAL','BUTAL',1329,20,0,'SLOW MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'4800818810763',NULL,0),
(1172,'1078','POTCHI STRAWBERRY BARKADA PACK',26,7,'BUTAL','BUTAL',1330,20,0,'SLOW MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'4800818810787',NULL,0),
(1173,'1095','POTCHI 26 WORMS BARKADA PACK',26,7,'BUTAL','BUTAL',1331,20,0,'SLOW MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'',NULL,0),
(1174,'1079','POTCHI GUMMI POP BARKADA PACK',26,7,'BUTAL','BUTAL',1332,20,0,'SLOW MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'',NULL,0),
(1175,'188','POTCHI CHOCO MALLOWS',26,7,'BUTAL','BUTAL',1333,18,0,'FAST MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'4800818801884',NULL,0),
(1176,'149','POTCHI MALLOWS CHOCO BERRY',26,7,'BUTAL','BUTAL',1334,18,0,'FAST MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'',NULL,0),
(1177,'166','POTCHI CUPCAKE',26,7,'BUTAL','BUTAL',1335,20,0,'FAST MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'',NULL,0),
(1178,'755','POTCHI 26 WORM SP (NEW PACKING)',26,7,'BUTAL','BUTAL',1336,10,0,'SLOW MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'',NULL,0),
(1179,'1077','POTCHI GUMMI BLOCKS SP 45G ',26,7,'BUTAL','BUTAL',1337,10,0,'SLOW MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'',NULL,0),
(1180,'1093','POTCHI NUTRI JELLY ',26,7,'BUTAL','BUTAL',1338,10,0,'SLOW MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'',NULL,0),
(1181,'891','POTCHI 26 BEARS',26,7,'BUTAL','BUTAL',1339,40,0,'SLOW MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'',NULL,0),
(1182,'865','FROOTY RAINBOW POP',25,7,'BUTAL','BUTAL',1340,40,0,'FAST MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'4800818807190',NULL,0),
(1183,'1098','FROOTY RAINBOW POP SARI2X STORE',25,7,'BUTAL','BUTAL',1341,20,0,'SLOW MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'',NULL,0),
(1184,'772','FROOTY KISSY POP',25,7,'BUTAL','BUTAL',1342,50,0,'SLOW MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'4800818807725',NULL,0),
(1185,'760','FROOTY RAINBOW POP JAR',25,7,'BUTAL','BUTAL',1343,12,0,'FAST MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'4800818807602',NULL,0),
(1186,'725','FROOTY TWIN POP',25,7,'BUTAL','BUTAL',1344,50,0,'FAST MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'4800818807251',NULL,0),
(1187,'868','FROOTY CHOCOLICIOUS',25,7,'BUTAL','BUTAL',1345,50,0,'FAST MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'4800818808685',NULL,0),
(1188,'719','FROOTY PINTOORA POP',25,7,'BUTAL','BUTAL',1346,50,0,'FAST MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'4800818807190',NULL,0),
(1189,'829','FROOTY BUBBLE POP',25,7,'BUTAL','BUTAL',1347,40,0,'FAST MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'4800818828294',NULL,0),
(1190,'863','FROOTY CHOCO POP',25,7,'BUTAL','BUTAL',1348,40,0,'FAST MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'4800818808630',NULL,0),
(1191,'129','FROOTY CHOCO KISS',25,7,'BUTAL','BUTAL',1349,50,0,'SLOW MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'',NULL,0),
(1192,'1085','FROOTY MILKY POP',25,7,'BUTAL','BUTAL',1350,32,0,'FAST MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'4800818810855',NULL,0),
(1193,'969','FROOTY TROPI MIX ',25,7,'BUTAL','BUTAL',1351,50,0,'SLOW MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'',NULL,0),
(1194,'808','KOOL\'EM  22',22,7,'BUTAL','BUTAL',1352,40,0,'FAST MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'4800818808081',NULL,0),
(1195,'809','CHOCO JOY',22,7,'BUTAL','BUTAL',1353,40,0,'FAST MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'4800818808098',NULL,0),
(1196,'830','FRUTOS 22',22,7,'BUTAL','BUTAL',1354,40,0,'FAST MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'4800818808302',NULL,0),
(1197,'878','FRUTOS DOUBLICIOUS',22,7,'BUTAL','BUTAL',1355,40,0,'FAST MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'4800818808784',NULL,0),
(1198,'907','FRUTOS TROPICAL',22,7,'BUTAL','BUTAL',1356,40,0,'FAST MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'4800818809071',NULL,0),
(1199,'1081','FRUTOS SAMPALOK',22,7,'BUTAL','BUTAL',1357,40,0,'FAST MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'4800818810817',NULL,0),
(1200,'932','FRUTOS MINI BITS CHEWY STRAP',22,7,'BUTAL','BUTAL',1358,50,0,'SLOW MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'',NULL,0),
(1201,'726','FRUTOS MINI BITS SOUR S.P.',22,7,'BUTAL','BUTAL',1359,10,0,'FAST MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'',NULL,0),
(1202,'1082','FRUTOS SAMPALOK MINIBITS S.P',22,7,'BUTAL','BUTAL',1360,10,0,'FAST MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'',NULL,0),
(1203,'1086','FRUTOS MILK TEA',22,7,'BUTAL','BUTAL',1361,40,0,'FAST MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'4800818810862',NULL,0),
(1204,'717','FRUTOS CHEWY MINI BITS SP',22,7,'BUTAL','BUTAL',1362,10,0,'FAST MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'',NULL,0),
(1205,'169','FRUTOS STRAWBERRY MILK SAKE',22,7,'BUTAL','BUTAL',1363,40,0,'FAST MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'',NULL,0),
(1206,'128','FRIOO COOL CHEWY LEMON MINT',22,7,'BUTAL','BUTAL',1364,40,0,'SLOW MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'',NULL,0),
(1207,'787','CHAMPI CHOCO YEMA',22,7,'BUTAL','BUTAL',1365,60,0,'SLOW MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'4800818807879',NULL,0),
(1208,'791','CHAMPI CHOCO PREMIUM',22,7,'BUTAL','BUTAL',1366,48,0,'SLOW MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'',NULL,0),
(1209,'792','CHAMPI CHOCO YEMA PREMIUM',22,7,'BUTAL','BUTAL',1367,48,0,'SLOW MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'',NULL,0),
(1210,'971','CHAMPI CHOCOLATE CHEWY',22,7,'BUTAL','BUTAL',1368,40,0,'FAST MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'4800818809712',NULL,0),
(1211,'786','CHAMPI KAPE',22,7,'BUTAL','BUTAL',1369,60,0,'SLOW MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'',NULL,0),
(1212,'795','CHAMPI TSOKO PEANUT',22,7,'BUTAL','BUTAL',1370,48,0,'SLOW MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'',NULL,0),
(1213,'1075','CHAMPI TSOKO PEANUT',22,7,'BUTAL','BUTAL',1371,40,0,'SLOW MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'4800818810756',NULL,0),
(1214,'989','CHAMPI CHOCO ?CLAIR',22,7,'BUTAL','BUTAL',1372,40,0,'FAST MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'4800818809897',NULL,0),
(1215,'601','OTSO CHOCOLATE',24,7,'BUTAL','BUTAL',1373,20,0,'FAST MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'4800818826016',NULL,0),
(1216,'602','OTSO VANILLA',24,7,'BUTAL','BUTAL',1374,20,0,'FAST MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'4800818826023',NULL,0),
(1217,'605','OTSO ORANGE',24,7,'BUTAL','BUTAL',1375,20,0,'FAST MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'4800818826054',NULL,0),
(1218,'690','OTSO CHOCO CARAMEL',24,7,'BUTAL','BUTAL',1376,20,0,'SLOW MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'',NULL,0),
(1219,'172','OTSO STRAWBERRY',24,7,'BUTAL','BUTAL',1377,20,0,'FAST MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'4800818821721',NULL,0),
(1220,'610','SO LUCKY SODA CRACKER',24,7,'BUTAL','BUTAL',1378,18,0,'FAST MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'4800818826108',NULL,0),
(1221,'621','SO LUCKY CHOCOLATE',24,7,'BUTAL','BUTAL',1379,18,0,'FAST MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'4800818826214',NULL,0),
(1222,'622','SO LUCKY BUTTER CREAM',24,7,'BUTAL','BUTAL',1380,18,0,'FAST MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'4800818826221',NULL,0),
(1223,'623','SO LUCKY LEMON',24,7,'BUTAL','BUTAL',1381,18,0,'FAST MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'4800818826238',NULL,0),
(1224,'653','MYBIDA CHOCOLATE',24,7,'BUTAL','BUTAL',1382,20,0,'FAST MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'4800818826535',NULL,0),
(1225,'655','MYBIDA MOCHA',24,7,'BUTAL','BUTAL',1383,20,0,'FAST MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'4800818826566',NULL,0),
(1226,'656','MYBIDA PEANUT BUTTER',24,7,'BUTAL','BUTAL',1384,20,0,'FAST MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'4800818826566',NULL,0),
(1227,'657','MYBIDA COMBO MIX',24,7,'BUTAL','BUTAL',1385,20,0,'FAST MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'4800818826573',NULL,0),
(1228,'681','MYBIDA CRACKER',24,7,'BUTAL','BUTAL',1386,20,0,'FAST MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'4800818806810',NULL,0),
(1229,'685','CHOCQUIK COOKIE',24,7,'BUTAL','BUTAL',1387,20,0,'FAST MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'4800818826856',NULL,0),
(1230,'646','YUPYUP BAKED POTATO BARBEQUE',40,7,'BUTAL','BUTAL',1388,10,0,'SLOW MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'4800818806469',NULL,0),
(1231,'649','YUPYUP BAKED POTATO SOUR AND CREAM',40,7,'BUTAL','BUTAL',1389,10,0,'SLOW MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'4800818806490',NULL,0),
(1232,'108','TOPTOP CHOCO PEANUT',23,7,'BUTAL','BUTAL',1390,10,0,'SLOW MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'4800818801082',NULL,0),
(1233,'109','TOPTOP CHOCO JELLY',23,7,'BUTAL','BUTAL',1391,10,0,'SLOW MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'4800818801099',NULL,0),
(1234,'110','TOPTOP MILK CHOCOLATE',23,7,'BUTAL','BUTAL',1392,10,0,'SLOW MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'4800818801624',NULL,0),
(1235,'125','TOPTOP CHOCO CARAMEL',23,7,'BUTAL','BUTAL',1393,10,0,'SLOW MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'4800818601255',NULL,0),
(1236,'130','TOPTOP CHOCO BAR WITH MINI TOPTOP',23,7,'BUTAL','BUTAL',1394,12,0,'SLOW MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'4800818801303',NULL,0),
(1237,'140','TOPTOP CHOCO BAR WITH POTCHI JELLY',23,7,'BUTAL','BUTAL',1395,12,0,'SLOW MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'4800818801402',NULL,0),
(1238,'151','TOPTOP MILK CHOCOLATE SUKI PACK',23,7,'BUTAL','BUTAL',1396,24,0,'SLOW MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'4800818601514',NULL,0),
(1239,'152','TOPTOP CHOCO PEANUT SUKI PACK',23,7,'BUTAL','BUTAL',1397,24,0,'SLOW MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'4800818601521',NULL,0),
(1240,'1001','TOPTOP',23,7,'BUTAL','BUTAL',1398,60,0,'SLOW MOVING',NULL,'2023-04-20 06:24:52',2.00,0.00,'4800818810015',NULL,0),
(1241,'503','OOLA RICE CRISPY CHOCOLATE',23,7,'BUTAL','BUTAL',1399,24,0,'SLOW MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'4800818805035',NULL,0),
(1242,'645','CIOCO MARIE',23,7,'BUTAL','BUTAL',1400,12,0,'SLOW MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'4800818606458',NULL,0),
(1243,'641','CIOCO LUV-LOV CHOCO BALLS',23,7,'BUTAL','BUTAL',1401,40,0,'FAST MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'4800818806414',NULL,0),
(1244,'736','MYSNAK PEANUT',23,7,'BUTAL','BUTAL',1402,40,0,'SLOW MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'4800818807367',NULL,0),
(1245,'737','MYSNAK STRAWBERRY',23,7,'BUTAL','BUTAL',1403,40,0,'SLOW MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'4800818087370',NULL,0),
(1246,'763','KLICX CRUNCHER MINI',23,7,'BUTAL','BUTAL',1404,20,0,'SLOW MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'4800818807633',NULL,0),
(1247,'793','CHOCFY PEANUT CARAMEL',23,7,'BUTAL','BUTAL',1405,40,0,'SLOW MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'4800818087936',NULL,0),
(1248,'1057','CHOCFY CHOCO CARAMEL',23,7,'BUTAL','BUTAL',1406,40,0,'SLOW MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'4800818810572',NULL,0),
(1249,'2608','KOKOLA CHOCOLATE STRAP',23,7,'BUTAL','BUTAL',1407,20,0,'SLOW MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'',NULL,0),
(1250,'2640','KOKOLA ANIMALS',23,7,'BUTAL','BUTAL',1408,20,0,'SLOW MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'',NULL,0),
(1251,'5606','KOKOLA STRAWBERRY BARKADA SIZE',23,7,'BUTAL','BUTAL',1409,10,0,'FAST MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'4800818806063',NULL,0),
(1252,'5608','KOKOLA CHOCOLATE BARKADA SIZE',23,7,'BUTAL','BUTAL',1410,10,0,'FAST MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'4800818806087',NULL,0),
(1253,'912','MYCOCO W/ COOKIE BITS',23,7,'BUTAL','BUTAL',1411,24,0,'FAST MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'4800818809125',NULL,0),
(1254,'922','MYCOCO W/ TOFFEE BITS',23,7,'BUTAL','BUTAL',1412,24,0,'FAST MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'4800818809224',NULL,0),
(1255,'831','MYCOCO W/ COCONUT',23,7,'BUTAL','BUTAL',1413,24,0,'FAST MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'',NULL,0),
(1256,'843','CHOCQUIK CHOCOLATE BAR JR. PACK',23,7,'BUTAL','BUTAL',1414,24,0,'FAST MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'4800818808432',NULL,0),
(1257,'960','SCHOKO CARAMEL',23,7,'BUTAL','BUTAL',1415,40,0,'FAST MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'4800818809606',NULL,0),
(1258,'162','LUVLUV MILK CHOCOLATE SP',23,7,'BUTAL','BUTAL',1416,10,0,'SLOW MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'',NULL,0),
(1259,'995','CHOCFY BUTTER CARAMEL',23,7,'BUTAL','BUTAL',1417,40,0,'SLOW MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'',NULL,0),
(1260,'1048','CHOCQUIK\'O  CHOCO MALT TABLET',23,7,'BUTAL','BUTAL',1418,50,0,'SLOW MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'',NULL,0),
(1261,'8089','CHOCQUIK CHOCO BAR',23,7,'BUTAL','BUTAL',1419,40,0,'SLOW MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'',NULL,0),
(1262,'155','3 KINGS TRUFFLE',19,7,'BUTAL','BUTAL',1420,12,0,'SLOW MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'',NULL,0),
(1263,'156','3 KINGS PEANUT',19,7,'BUTAL','BUTAL',1421,12,0,'SLOW MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'',NULL,0),
(1264,'138','CIOCO LUV LUV (CHOCO WAFER BAR)',19,7,'BUTAL','BUTAL',1422,12,0,'FAST MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'4800818601385',NULL,0),
(1265,'658','TOFIKO CHOCO CRISP',19,7,'BUTAL','BUTAL',1423,12,0,'FAST MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'4800818606588',NULL,0),
(1266,'698','TOFIKO MINI BARKADA PACK',19,7,'BUTAL','BUTAL',1424,24,0,'SLOW MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'4800818606984',NULL,0),
(1267,'727','KLICX CRUNCHER BAR',19,7,'BUTAL','BUTAL',1425,20,0,'SLOW MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'4800818607271',NULL,0),
(1268,'799','MONMON CHOCOLATE',19,7,'BUTAL','BUTAL',1426,20,0,'SLOW MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'4800818607998',NULL,0),
(1269,'849','CHOCQUIK FIVE',19,7,'BUTAL','BUTAL',1427,20,0,'FAST MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'4800818608490',NULL,0),
(1270,'801','PINGPONG GUM',20,7,'CASE','CASE',1112,24,0,'FAST MOVING',NULL,'2023-04-20 06:24:51',1.00,0.00,'14800818808019',NULL,0),
(1271,'848','AMERICAN GUMBALL',20,7,'CASE','CASE',1113,40,0,'FAST MOVING',NULL,'2023-04-20 06:24:51',0.00,0.00,'14800818808484',NULL,0),
(1272,'802','CHERRY GUM',20,7,'CASE','CASE',1114,24,0,'FAST MOVING',NULL,'2023-04-20 06:24:51',0.00,0.00,'14800818808026',NULL,0),
(1273,'816','GUMBALLS',20,7,'CASE','CASE',1115,40,0,'FAST MOVING',NULL,'2023-04-20 06:24:51',0.00,0.00,'14800818808163',NULL,0),
(1274,'832','SUPER BUBBLE',20,7,'CASE','CASE',1116,40,0,'FAST MOVING',NULL,'2023-04-20 06:24:51',0.00,0.00,'14800818808323',NULL,0),
(1275,'876','YAKEE SUPER ASIM GUM BALL',20,7,'CASE','CASE',1117,40,0,'FAST MOVING',NULL,'2023-04-20 06:24:51',0.00,0.00,'14800818808767',NULL,0),
(1276,'877','PINTOORA GUMBALL',20,7,'CASE','CASE',1118,40,0,'FAST MOVING',NULL,'2023-04-20 06:24:51',0.00,0.00,'14800818808774',NULL,0),
(1277,'980','JUMBO GOLF JAR',20,7,'CASE','CASE',1119,12,0,'SLOW MOVING',NULL,'2023-04-20 06:24:51',0.00,0.00,'14900818809252',NULL,0),
(1278,'710','JUMBO CHERRI JAR',20,7,'CASE','CASE',1120,12,0,'FAST MOVING',NULL,'2023-04-20 06:24:51',0.00,0.00,'14800818809313',NULL,0),
(1279,'979','JUMBO REG. JAR',20,7,'CASE','CASE',1121,12,0,'FAST MOVING',NULL,'2023-04-20 06:24:51',0.00,0.00,'14800818809795',NULL,0),
(1280,'931','JUMBO CHERRI PACK',20,7,'CASE','CASE',1122,40,0,'FAST MOVING',NULL,'2023-04-20 06:24:51',0.00,0.00,'14800818807104',NULL,0),
(1281,'839','JUMBO REG. PACK',20,7,'CASE','CASE',1123,40,0,'FAST MOVING',NULL,'2023-04-20 06:24:51',0.00,0.00,'14800818808392',NULL,0),
(1282,'145','JUMBO EASTER EGG GUM BALL JAR',20,7,'CASE','CASE',1124,12,0,'FAST MOVING',NULL,'2023-04-20 06:24:51',0.00,0.00,'14800818801454',NULL,0),
(1283,'146','JUMBO CRAYON GUM BALL JAR',20,7,'CASE','CASE',1125,12,0,'FAST MOVING',NULL,'2023-04-20 06:24:51',0.00,0.00,'14800818801461',NULL,0),
(1284,'975','I COOL MENTHOLATED GUM',20,7,'CASE','CASE',1126,40,0,'FAST MOVING',NULL,'2023-04-20 06:24:51',0.00,0.00,'14800818809757',NULL,0),
(1285,'1017','I COOL CHERRY MINT GUM',20,7,'CASE','CASE',1127,40,0,'FAST MOVING',NULL,'2023-04-20 06:24:51',0.00,0.00,'14800818810173',NULL,0),
(1286,'135','I COOL TWIN HONEY LEMON',20,7,'CASE','CASE',1128,50,0,'SLOW MOVING',NULL,'2023-04-20 06:24:51',0.00,0.00,'',NULL,0),
(1287,'943','I COOL MENTHOL BLISTER PACK',20,7,'CASE','CASE',1129,8,0,'SLOW MOVING',NULL,'2023-04-20 06:24:51',0.00,0.00,'',NULL,0),
(1288,'1065','TINI WINI',20,7,'CASE','CASE',1130,60,0,'SLOW MOVING',NULL,'2023-04-20 06:24:51',0.00,0.00,'',NULL,0),
(1289,'1087','BLOWEE TATTOO GUM',20,7,'CASE','CASE',1131,40,0,'FAST MOVING',NULL,'2023-04-20 06:24:51',0.00,0.00,'14800818810876',NULL,0),
(1290,'947','V FRESH WINTER BLISTER PACK',20,7,'CASE','CASE',1132,8,0,'SLOW MOVING',NULL,'2023-04-20 06:24:51',0.00,0.00,'',NULL,0),
(1291,'860','V FRESH JR.',20,7,'CASE','CASE',1133,60,0,'SLOW MOVING',NULL,'2023-04-20 06:24:51',0.00,0.00,'',NULL,0),
(1292,'1988','V FRESH WINTERCOOL JAR',20,7,'CASE','CASE',1134,12,0,'FAST MOVING',NULL,'2023-04-20 06:24:51',0.00,0.00,'14800818819886',NULL,0),
(1293,'988','V FRESH WINTER COOL GUM',20,7,'CASE','CASE',1135,40,0,'FAST MOVING',NULL,'2023-04-20 06:24:51',0.00,0.00,'',NULL,0),
(1294,'678','V FRESH AQUA COOL',20,7,'CASE','CASE',1136,40,0,'FAST MOVING',NULL,'2023-04-20 06:24:51',0.00,0.00,'14800818806787',NULL,0),
(1295,'773','V FRESH WINTER COOL BIG PACK',20,7,'CASE','CASE',1137,10,0,'SLOW MOVING',NULL,'2023-04-20 06:24:51',0.00,0.00,'',NULL,0),
(1296,'1083','VFRESH XYLITOL SUGAR FREE',20,7,'CASE','CASE',1138,48,0,'FAST MOVING',NULL,'2023-04-20 06:24:51',0.00,0.00,'14800818810838',NULL,0),
(1297,'1018','V FRESH SPEARMINT',20,7,'CASE','CASE',1139,40,0,'FAST MOVING',NULL,'2023-04-20 06:24:51',0.00,0.00,'',NULL,0),
(1298,'837','BUTTERKIST',21,7,'CASE','CASE',1140,40,0,'FAST MOVING',NULL,'2023-04-20 06:24:51',0.00,0.00,'14800818808378',NULL,0),
(1299,'930','I MILK',21,7,'CASE','CASE',1141,40,0,'FAST MOVING',NULL,'2023-04-20 06:24:51',0.00,0.00,'14800818809306',NULL,0),
(1300,'965','MON\'AMI STRAWBERRY CREAM',21,7,'CASE','CASE',1142,40,0,'FAST MOVING',NULL,'2023-04-20 06:24:51',0.00,0.00,'14800818809658',NULL,0),
(1301,'968','MON\'AMI BUTTERCREAM',21,7,'CASE','CASE',1143,40,0,'FAST MOVING',NULL,'2023-04-20 06:24:51',0.00,0.00,'14800818809689',NULL,0),
(1302,'1102','MON\'AMI STRAWBERRY JAR',21,7,'CASE','CASE',1144,12,0,'FAST MOVING',NULL,'2023-04-20 06:24:51',0.00,0.00,'14800818811026',NULL,0),
(1303,'1103','MON\'AMI BUTTER CARAMEL JAR',21,7,'CASE','CASE',1145,12,0,'FAST MOVING',NULL,'2023-04-20 06:24:51',0.00,0.00,'14800818811033',NULL,0),
(1304,'1101','MONAMI HI CAF? JAR',21,7,'CASE','CASE',1146,12,0,'FAST MOVING',NULL,'2023-04-20 06:24:51',0.00,0.00,'14800818811019',NULL,0),
(1305,'1099','MONAMI HI CAF? ',21,7,'CASE','CASE',1147,40,0,'FAST MOVING',NULL,'2023-04-20 06:24:51',0.00,0.00,'14800818810999',NULL,0),
(1306,'890','POTCHI STRAWBERRY CREAM',26,7,'CASE','CASE',1148,40,0,'FAST MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'14800818808903',NULL,0),
(1307,'952','POTCHI MINI STRAWBERRY',26,7,'CASE','CASE',1149,50,0,'SLOW MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'14800818809528',NULL,0),
(1308,'750','POTCHI STRAWBERRY 50G SP (NEW PACKING)',26,7,'CASE','CASE',1150,10,0,'SLOW MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'14800818837507',NULL,0),
(1309,'111','POTCHI GUMMI POP JAR',26,7,'CASE','CASE',1151,12,0,'FAST MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'14800818831116',NULL,0),
(1310,'112','POTCHI HOOLA HOOP JAR',26,7,'CASE','CASE',1152,12,0,'FAST MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'14800818831123',NULL,0),
(1311,'749','POTCHI 26 WORMS JAR',26,7,'CASE','CASE',1153,12,0,'FAST MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'14800818807494',NULL,0),
(1312,'1755','POTCHI 26 WORMS STRAP 25G',26,7,'CASE','CASE',1154,20,0,'SLOW MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'14800818817554',NULL,0),
(1313,'2136','POTCHI DOTS JAR',26,7,'CASE','CASE',1155,12,0,'SLOW MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'',NULL,0),
(1314,'1136','POTCHI DOTS STRAP',26,7,'CASE','CASE',1156,20,0,'SLOW MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'',NULL,0),
(1315,'136','POTCHI DOTS SNACK PACK',26,7,'CASE','CASE',1157,10,0,'SLOW MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'',NULL,0),
(1316,'2142','POTCHI OCTOPUS JAR',26,7,'CASE','CASE',1158,12,0,'SLOW MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'',NULL,0),
(1317,'1142','POTCHI OCTOPUS STRAP',26,7,'CASE','CASE',1159,20,0,'SLOW MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'',NULL,0),
(1318,'2153','POTCHI CLOWN FISH JAR',26,7,'CASE','CASE',1160,12,0,'SLOW MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'14800818821537',NULL,0),
(1319,'1750','POTCHI STRAWBERRY STRAP',26,7,'CASE','CASE',1161,20,0,'SLOW MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'14800818817509',NULL,0),
(1320,'1071','POTCHI ORANGE PASTILLE',26,7,'CASE','CASE',1162,40,0,'SLOW MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'14800818810715',NULL,0),
(1321,'1070','POTCHI CLOWN FISH STRAP',26,7,'CASE','CASE',1163,20,0,'SLOW MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'',NULL,0),
(1322,'1069','POTCHI HOOLA HOOP STRAP',26,7,'CASE','CASE',1164,20,0,'SLOW MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'',NULL,0),
(1323,'1859','POTCHI 26 WORMS REFILL PACK',26,7,'CASE','CASE',1165,24,0,'SLOW MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'',NULL,0),
(1324,'1860','POTCHI BERRY 26 REFILL PACK',26,7,'CASE','CASE',1166,24,0,'SLOW MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'',NULL,0),
(1325,'1861','POTCHI HOOLA HOOP REFILL PACK',26,7,'CASE','CASE',1167,24,0,'SLOW MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'',NULL,0),
(1326,'1862','POTCHI CLOWN FISH REFILL PACK',26,7,'CASE','CASE',1168,24,0,'SLOW MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'',NULL,0),
(1327,'1096','POTCHI FAN-FAN ',26,7,'CASE','CASE',1169,20,0,'SLOW MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'',NULL,0),
(1328,'1080','POTCHI 26 BEAR BARKADA PACK',26,7,'CASE','CASE',1170,20,0,'SLOW MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'',NULL,0),
(1329,'1076','POTCHI HOOLA HOOP BARKADA PACK',26,7,'CASE','CASE',1171,20,0,'SLOW MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'14800818810760',NULL,0),
(1330,'1078','POTCHI STRAWBERRY BARKADA PACK',26,7,'CASE','CASE',1172,20,0,'SLOW MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'14800818810784',NULL,0),
(1331,'1095','POTCHI 26 WORMS BARKADA PACK',26,7,'CASE','CASE',1173,20,0,'SLOW MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'',NULL,0),
(1332,'1079','POTCHI GUMMI POP BARKADA PACK',26,7,'CASE','CASE',1174,20,0,'SLOW MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'',NULL,0),
(1333,'188','POTCHI CHOCO MALLOWS',26,7,'CASE','CASE',1175,18,0,'FAST MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'14800818801881',NULL,0),
(1334,'149','POTCHI MALLOWS CHOCO BERRY',26,7,'CASE','CASE',1176,18,0,'FAST MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'',NULL,0),
(1335,'166','POTCHI CUPCAKE',26,7,'CASE','CASE',1177,20,0,'FAST MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'',NULL,0),
(1336,'755','POTCHI 26 WORM SP (NEW PACKING)',26,7,'CASE','CASE',1178,10,0,'SLOW MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'',NULL,0),
(1337,'1077','POTCHI GUMMI BLOCKS SP 45G ',26,7,'CASE','CASE',1179,10,0,'SLOW MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'',NULL,0),
(1338,'1093','POTCHI NUTRI JELLY ',26,7,'CASE','CASE',1180,10,0,'SLOW MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'',NULL,0),
(1339,'891','POTCHI 26 BEARS',26,7,'CASE','CASE',1181,40,0,'SLOW MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'',NULL,0),
(1340,'865','FROOTY RAINBOW POP',25,7,'CASE','CASE',1182,40,0,'FAST MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'14800818807197',NULL,0),
(1341,'1098','FROOTY RAINBOW POP SARI2X STORE',25,7,'CASE','CASE',1183,20,0,'SLOW MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'',NULL,0),
(1342,'772','FROOTY KISSY POP',25,7,'CASE','CASE',1184,50,0,'SLOW MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'14800818807722',NULL,0),
(1343,'760','FROOTY RAINBOW POP JAR',25,7,'CASE','CASE',1185,12,0,'FAST MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'14800818807609',NULL,0),
(1344,'725','FROOTY TWIN POP',25,7,'CASE','CASE',1186,50,0,'FAST MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'14800818807258',NULL,0),
(1345,'868','FROOTY CHOCOLICIOUS',25,7,'CASE','CASE',1187,50,0,'FAST MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'14800818808682',NULL,0),
(1346,'719','FROOTY PINTOORA POP',25,7,'CASE','CASE',1188,50,0,'FAST MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'14800818807197',NULL,0),
(1347,'829','FROOTY BUBBLE POP',25,7,'CASE','CASE',1189,40,0,'FAST MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'14800818828291',NULL,0),
(1348,'863','FROOTY CHOCO POP',25,7,'CASE','CASE',1190,40,0,'FAST MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'14800818828635',NULL,0),
(1349,'129','FROOTY CHOCO KISS',25,7,'CASE','CASE',1191,50,0,'SLOW MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'',NULL,0),
(1350,'1085','FROOTY MILKY POP',25,7,'CASE','CASE',1192,32,0,'FAST MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'14800818810852',NULL,0),
(1351,'969','FROOTY TROPI MIX ',25,7,'CASE','CASE',1193,50,0,'SLOW MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'',NULL,0),
(1352,'808','KOOL\'EM  22',22,7,'CASE','CASE',1194,40,0,'FAST MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'14800818808088',NULL,0),
(1353,'809','CHOCO JOY',22,7,'CASE','CASE',1195,40,0,'FAST MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'14800818808095',NULL,0),
(1354,'830','FRUTOS 22',22,7,'CASE','CASE',1196,40,0,'FAST MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'14800818808309',NULL,0),
(1355,'878','FRUTOS DOUBLICIOUS',22,7,'CASE','CASE',1197,40,0,'FAST MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'14800818808781',NULL,0),
(1356,'907','FRUTOS TROPICAL',22,7,'CASE','CASE',1198,40,0,'FAST MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'14800818809078',NULL,0),
(1357,'1081','FRUTOS SAMPALOK',22,7,'CASE','CASE',1199,40,0,'FAST MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'14800818810814',NULL,0),
(1358,'932','FRUTOS MINI BITS CHEWY STRAP',22,7,'CASE','CASE',1200,50,0,'SLOW MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'',NULL,0),
(1359,'726','FRUTOS MINI BITS SOUR S.P.',22,7,'CASE','CASE',1201,10,0,'FAST MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'',NULL,0),
(1360,'1082','FRUTOS SAMPALOK MINIBITS S.P',22,7,'CASE','CASE',1202,10,0,'FAST MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'',NULL,0),
(1361,'1086','FRUTOS MILK TEA',22,7,'CASE','CASE',1203,40,0,'FAST MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'14800818810869',NULL,0),
(1362,'717','FRUTOS CHEWY MINI BITS SP',22,7,'CASE','CASE',1204,10,0,'FAST MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'',NULL,0),
(1363,'169','FRUTOS STRAWBERRY MILK SAKE',22,7,'CASE','CASE',1205,40,0,'FAST MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'',NULL,0),
(1364,'128','FRIOO COOL CHEWY LEMON MINT',22,7,'CASE','CASE',1206,40,0,'SLOW MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'',NULL,0),
(1365,'787','CHAMPI CHOCO YEMA',22,7,'CASE','CASE',1207,60,0,'SLOW MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'14800818807876',NULL,0),
(1366,'791','CHAMPI CHOCO PREMIUM',22,7,'CASE','CASE',1208,48,0,'SLOW MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'',NULL,0),
(1367,'792','CHAMPI CHOCO YEMA PREMIUM',22,7,'CASE','CASE',1209,48,0,'SLOW MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'',NULL,0),
(1368,'971','CHAMPI CHOCOLATE CHEWY',22,7,'CASE','CASE',1210,40,0,'FAST MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'14800818809719',NULL,0),
(1369,'786','CHAMPI KAPE',22,7,'CASE','CASE',1211,60,0,'SLOW MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'14800818807869',NULL,0),
(1370,'795','CHAMPI TSOKO PEANUT',22,7,'CASE','CASE',1212,48,0,'SLOW MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'',NULL,0),
(1371,'1075','CHAMPI TSOKO PEANUT',22,7,'CASE','CASE',1213,40,0,'SLOW MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'14800818810753',NULL,0),
(1372,'989','CHAMPI CHOCO ?CLAIR',22,7,'CASE','CASE',1214,40,0,'FAST MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'14800818809894',NULL,0),
(1373,'601','OTSO CHOCOLATE',24,7,'CASE','CASE',1215,20,0,'FAST MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'14800818806015',NULL,0),
(1374,'602','OTSO VANILLA',24,7,'CASE','CASE',1216,20,0,'FAST MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'14800818806022',NULL,0),
(1375,'605','OTSO ORANGE',24,7,'CASE','CASE',1217,20,0,'FAST MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'14800818806053',NULL,0),
(1376,'690','OTSO CHOCO CARAMEL',24,7,'CASE','CASE',1218,20,0,'SLOW MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'',NULL,0),
(1377,'172','OTSO STRAWBERRY',24,7,'CASE','CASE',1219,20,0,'FAST MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'14800818801720',NULL,0),
(1378,'610','SO LUCKY SODA CRACKER',24,7,'CASE','CASE',1220,18,0,'FAST MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'14800818806107',NULL,0),
(1379,'621','SO LUCKY CHOCOLATE',24,7,'CASE','CASE',1221,18,0,'FAST MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'14800818806213',NULL,0),
(1380,'622','SO LUCKY BUTTER CREAM',24,7,'CASE','CASE',1222,18,0,'FAST MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'14800818806220',NULL,0),
(1381,'623','SO LUCKY LEMON',24,7,'CASE','CASE',1223,18,0,'FAST MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'14800818806237',NULL,0),
(1382,'653','MYBIDA CHOCOLATE',24,7,'CASE','CASE',1224,20,0,'FAST MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'14800818806534',NULL,0),
(1383,'655','MYBIDA MOCHA',24,7,'CASE','CASE',1225,20,0,'FAST MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'14800818806565',NULL,0),
(1384,'656','MYBIDA PEANUT BUTTER',24,7,'CASE','CASE',1226,20,0,'FAST MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'14800818806565',NULL,0),
(1385,'657','MYBIDA COMBO MIX',24,7,'CASE','CASE',1227,20,0,'FAST MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'14800818806572',NULL,0),
(1386,'681','MYBIDA CRACKER',24,7,'CASE','CASE',1228,20,0,'FAST MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'14800818806817',NULL,0),
(1387,'685','CHOCQUIK COOKIE',24,7,'CASE','CASE',1229,20,0,'FAST MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'14800818806855',NULL,0),
(1388,'646','YUPYUP BAKED POTATO BARBEQUE',40,7,'CASE','CASE',1230,10,0,'SLOW MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'14800818806466',NULL,0),
(1389,'649','YUPYUP BAKED POTATO SOUR AND CREAM',40,7,'CASE','CASE',1231,10,0,'SLOW MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'14800818806497',NULL,0),
(1390,'108','TOPTOP CHOCO PEANUT',23,7,'CASE','CASE',1232,10,0,'SLOW MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'14800818801089',NULL,0),
(1391,'109','TOPTOP CHOCO JELLY',23,7,'CASE','CASE',1233,10,0,'SLOW MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'14800818801096',NULL,0),
(1392,'110','TOPTOP MILK CHOCOLATE',23,7,'CASE','CASE',1234,10,0,'SLOW MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'14800818801621',NULL,0),
(1393,'125','TOPTOP CHOCO CARAMEL',23,7,'CASE','CASE',1235,10,0,'SLOW MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'14800818801256',NULL,0),
(1394,'130','TOPTOP CHOCO BAR WITH MINI TOPTOP',23,7,'CASE','CASE',1236,12,0,'SLOW MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'14800818801300',NULL,0),
(1395,'140','TOPTOP CHOCO BAR WITH POTCHI JELLY',23,7,'CASE','CASE',1237,12,0,'SLOW MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'14800818801409',NULL,0),
(1396,'151','TOPTOP MILK CHOCOLATE SUKI PACK',23,7,'CASE','CASE',1238,24,0,'SLOW MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'14800818801515',NULL,0),
(1397,'152','TOPTOP CHOCO PEANUT SUKI PACK',23,7,'CASE','CASE',1239,24,0,'SLOW MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'14800818801522',NULL,0),
(1398,'1001','TOPTOP',23,7,'CASE','CASE',1240,60,0,'SLOW MOVING',NULL,'2023-04-20 06:24:52',1.00,0.00,'14800818810012',NULL,0),
(1399,'503','OOLA RICE CRISPY CHOCOLATE',23,7,'CASE','CASE',1241,24,0,'SLOW MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'14800818805032',NULL,0),
(1400,'645','CIOCO MARIE',23,7,'CASE','CASE',1242,12,0,'SLOW MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'14800818806459',NULL,0),
(1401,'641','CIOCO LUV-LOV CHOCO BALLS',23,7,'CASE','CASE',1243,40,0,'FAST MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'14800818806411',NULL,0),
(1402,'736','MYSNAK PEANUT',23,7,'CASE','CASE',1244,40,0,'SLOW MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'14800818807364',NULL,0),
(1403,'737','MYSNAK STRAWBERRY',23,7,'CASE','CASE',1245,40,0,'SLOW MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'14800818807371',NULL,0),
(1404,'763','KLICX CRUNCHER MINI',23,7,'CASE','CASE',1246,20,0,'SLOW MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'14800818807630',NULL,0),
(1405,'793','CHOCFY PEANUT CARAMEL',23,7,'CASE','CASE',1247,40,0,'SLOW MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'14800818807937',NULL,0),
(1406,'1057','CHOCFY CHOCO CARAMEL',23,7,'CASE','CASE',1248,40,0,'SLOW MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'14800818810579',NULL,0),
(1407,'2608','KOKOLA CHOCOLATE STRAP',23,7,'CASE','CASE',1249,20,0,'SLOW MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'',NULL,0),
(1408,'2640','KOKOLA ANIMALS',23,7,'CASE','CASE',1250,20,0,'SLOW MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'',NULL,0),
(1409,'5606','KOKOLA STRAWBERRY BARKADA SIZE',23,7,'CASE','CASE',1251,10,0,'FAST MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'14800818856065',NULL,0),
(1410,'5608','KOKOLA CHOCOLATE BARKADA SIZE',23,7,'CASE','CASE',1252,10,0,'FAST MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'14800818856089',NULL,0),
(1411,'912','MYCOCO W/ COOKIE BITS',23,7,'CASE','CASE',1253,24,0,'FAST MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'14800818809122',NULL,0),
(1412,'922','MYCOCO W/ TOFFEE BITS',23,7,'CASE','CASE',1254,24,0,'FAST MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'14800818809221',NULL,0),
(1413,'831','MYCOCO W/ COCONUT',23,7,'CASE','CASE',1255,24,0,'FAST MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'',NULL,0),
(1414,'843','CHOCQUIK CHOCOLATE BAR JR. PACK',23,7,'CASE','CASE',1256,24,0,'FAST MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'14800818808439',NULL,0),
(1415,'960','SCHOKO CARAMEL',23,7,'CASE','CASE',1257,40,0,'FAST MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'14800818809603',NULL,0),
(1416,'162','LUVLUV MILK CHOCOLATE SP',23,7,'CASE','CASE',1258,10,0,'SLOW MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'',NULL,0),
(1417,'995','CHOCFY BUTTER CARAMEL',23,7,'CASE','CASE',1259,40,0,'SLOW MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'',NULL,0),
(1418,'1048','CHOCQUIK\'O  CHOCO MALT TABLET',23,7,'CASE','CASE',1260,50,0,'SLOW MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'',NULL,0),
(1419,'8089','CHOCQUIK CHOCO BAR',23,7,'CASE','CASE',1261,40,0,'SLOW MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'',NULL,0),
(1420,'155','3 KINGS TRUFFLE',19,7,'CASE','CASE',1262,12,0,'SLOW MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'',NULL,0),
(1421,'156','3 KINGS PEANUT',19,7,'CASE','CASE',1263,12,0,'SLOW MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'',NULL,0),
(1422,'138','CIOCO LUV LUV (CHOCO WAFER BAR)',19,7,'CASE','CASE',1264,12,0,'FAST MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'14800818801386',NULL,0),
(1423,'658','TOFIKO CHOCO CRISP',19,7,'CASE','CASE',1265,12,0,'FAST MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'14800818806589',NULL,0),
(1424,'698','TOFIKO MINI BARKADA PACK',19,7,'CASE','CASE',1266,24,0,'SLOW MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'14800818806985',NULL,0),
(1425,'727','KLICX CRUNCHER BAR',19,7,'CASE','CASE',1267,20,0,'SLOW MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'14800818807272',NULL,0),
(1426,'799','MONMON CHOCOLATE',19,7,'CASE','CASE',1268,20,0,'SLOW MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'14800818867993',NULL,0),
(1427,'849','CHOCQUIK FIVE',19,7,'CASE','CASE',1269,20,0,'FAST MOVING',NULL,'2023-04-20 06:24:52',0.00,0.00,'14800818808491',NULL,0),
(1428,'PWB050','Lewis & Pearl Face and Body Powder White Bluch 50',32,2,'Case','Case',1429,36,0,'Fast Moving',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1429,'PWB050','Lewis & Pearl Face and Body Powder White Bluch 50',32,2,'Butal','Butal',1428,36,0,'Fast Moving',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1430,'LPS125M2A','BUY L&P SCENTSHOP PINK PASSION 125ML + 70D075 GTG',31,2,'CASE','CASE',1447,14,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1431,'LRU125M2A','BUY L&P SCENTSHOP RUSH 125ML + 70D075 GTG',31,2,'CASE','CASE',1448,14,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1432,'LIW125M2A','BUY L&P SCENTSHOP ICE WATER 125ML + 70D075 GTG',31,2,'CASE','CASE',1449,14,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1433,'LRN125M2A','BUY L&P SCENTSHOP RAIN 125ML + 70D075 GTG',31,2,'CASE','CASE',1450,14,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1434,'LCK125M2A','BUY L&P SCENTSHOP CANDY KISS 125ML + 70D075 GTG',31,2,'CASE','CASE',1451,14,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1435,'LCL125M2A','BUY L&P SCENTSHOP COOL FANTASY 125ML + 70D075 GTG',31,2,'CASE','CASE',1452,14,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1436,'LBN125M2A','BUY L&P SCENTSHOP BLUE NAVY 125ML + 70D075 GTG',31,2,'CASE','CASE',1453,14,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1437,'LNE125M2A','BUY L&P SCENTSHOPNEW YORK BEATS 125ML + 70D075 GTG',31,2,'CASE','CASE',1454,14,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1438,'LSE050','L&P SCENTSHOP COLOGNE SWEET PARIS 50ML',31,2,'CASE','CASE',1455,14,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1439,'LPS050','L&P SCENTSHOP PINK PASSION 50ML',31,2,'CASE','CASE',1456,14,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1440,'LRU050','L&P SCENTSHOP RUSH 50ML',31,2,'CASE','CASE',1457,14,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1441,'LIW050','L&P SCENTSHOP COLOGNE ICE WATER 50ML',31,2,'CASE','CASE',1458,14,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1442,'LRN050','L&P SCENTSHOP COLOGNE RAIN 50ML',31,2,'CASE','CASE',1459,14,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1443,'LCK050','L&P SCENTSHOP CANDY KISS 50ML',31,2,'CASE','CASE',1460,14,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1444,'LCL050','L&P SCENTSHOP COLOGNE COOL FANTASY 50ML',31,2,'CASE','CASE',1461,14,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1445,'LBN050','L&P SCENTSHOP COLOGNE BLUE NAVY 50ML',31,2,'CASE','CASE',1462,14,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1446,'LNE050','L&P SCENTSHOP COLOGNE NEW YORK BEATS 50ML',31,2,'CASE','CASE',1463,14,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1447,'LPS125M2A','BUY L&P SCENTSHOP PINK PASSION 125ML + 70D075 GTG',31,2,'BOTTLE','BUTAL',1430,14,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1448,'LRU125M2A','BUY L&P SCENTSHOP RUSH 125ML + 70D075 GTG',31,2,'BOTTLE','BUTAL',1431,14,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1449,'LIW125M2A','BUY L&P SCENTSHOP ICE WATER 125ML + 70D075 GTG',31,2,'BOTTLE','BUTAL',1432,14,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1450,'LRN125M2A','BUY L&P SCENTSHOP RAIN 125ML + 70D075 GTG',31,2,'BOTTLE','BUTAL',1433,14,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1451,'LCK125M2A','BUY L&P SCENTSHOP CANDY KISS 125ML + 70D075 GTG',31,2,'BOTTLE','BUTAL',1434,14,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1452,'LCL125M2A','BUY L&P SCENTSHOP COOL FANTASY 125ML + 70D075 GTG',31,2,'BOTTLE','BUTAL',1435,14,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1453,'LBN125M2A','BUY L&P SCENTSHOP BLUE NAVY 125ML + 70D075 GTG',31,2,'BOTTLE','BUTAL',1436,14,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1454,'LNE125M2A','BUY L&P SCENTSHOPNEW YORK BEATS 125ML + 70D075 GTG',31,2,'BOTTLE','BUTAL',1437,14,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1455,'LSE050','L&P SCENTSHOP COLOGNE SWEET PARIS 50ML',31,2,'BOTTLE','BUTAL',1438,14,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1456,'LPS050','L&P SCENTSHOP PINK PASSION 50ML',31,2,'BOTTLE','BUTAL',1439,14,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1457,'LRU05','L&P SCENTSHOP RUSH 50ML',31,2,'BOTTLE','BUTAL',1440,14,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1458,'LIW050','L&P SCENTSHOP COLOGNE ICE WATER 50ML',31,2,'BOTTLE','BUTAL',1441,14,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1459,'LRN050','L&P SCENTSHOP COLOGNE RAIN 50ML',31,2,'BOTTLE','BUTAL',1442,14,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1460,'LCK050','L&P SCENTSHOP CANDY KISS 50ML',31,2,'BOTTLE','BUTAL',1443,14,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1461,'LCL050','L&P SCENTSHOP COLOGNE COOL FANTASY 50ML',31,2,'BOTTLE','BUTAL',1444,14,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1462,'LBN050','L&P SCENTSHOP COLOGNE BLUE NAVY 50ML',31,2,'BOTTLE','BUTAL',1445,14,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1463,'LNE050','L&P SCENTSHOP COLOGNE NEW YORK BEATS 50ML',31,2,'BOTTLE','BUTAL',1446,14,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1464,'DBS033M3D','6 PCS DEL BLUE 33ML  FREE 1PC DEL BLUE 33ML',28,2,'PCK','BUTAL',1468,56,0,'FM',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1465,'DJS026M9D','6 PCS DEL FOREVER JOY 26ML  FREE 2 PCS DEL FOREVER JOY 26ML',28,2,'PCK','BUTAL',1469,80,0,'FM',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1466,'DLS033M3D','6 PCS DEL LAVENDER 33ML  FREE 1PC DEL LAVENDER 33ML',28,2,'PCK','BUTAL',1470,56,0,'FM',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1467,'DPS033M3D','6 PCS DEL PINK 33ML  FREE 1PC DEL PINK 33ML',28,2,'PCK','BUTAL',1471,56,0,'FM',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1468,'DBS033M3D','6 PCS DEL BLUE 33ML  FREE 1PC DEL BLUE 33ML',28,2,'CASE','CASE',1464,56,0,'FM',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1469,'DJS026M9D','6 PCS DEL FOREVER JOY 26ML  FREE 2 PCS DEL FOREVER JOY 26ML',28,2,'CASE','CASE',1465,80,0,'FM',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1470,'DLS033M3D','6 PCS DEL LAVENDER 33ML  FREE 1PC DEL LAVENDER 33ML',28,2,'CASE','CASE',1466,56,0,'FM',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1471,'DPS033M3D','6 PCS DEL PINK 33ML  FREE 1PC DEL PINK 33ML',28,2,'CASE','CASE',1467,56,0,'FM',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1472,'1015BP2','HEAVY DUTY SMALL RED BLISTER PACK 2PCS',1,4,'PCK','BUTAL',0,0,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1473,'HBL 100','HOLIDAY BEEF LOAF 100G',41,10,'PCS','BUTAL',1473,48,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1474,'HBL 150','HOLIDAY BEEF LOAF  150G',41,10,'PCS','BUTAL',1473,100,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1475,'HBL 215','HOLIDAY BEEF LOAF 215G',41,10,'PCS','BUTAL',1473,48,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1476,'HBLHS 100','HOLIDAY BEEF LOAF SPICY HOT 100G',41,10,'PCS','BUTAL',1473,48,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1477,'HBLHS 150','HOLIDAY BEEF LOAF SPICY HOT 150G',41,10,'PCS','BUTAL',1473,100,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1478,'HBLHS 215','HOLIDAY BEEF LOAF SPICY HOT 215G',41,10,'PCS','BUTAL',1473,48,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1479,'HBM 160','HOLIDAY BEEF MECHADO 160G',41,10,'PCS','BUTAL',1473,100,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1480,'HBM 210','HOLIDAY BEEF MECHADO 215G',41,10,'PCS','BUTAL',1473,48,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1481,'HCN 100','HOLIDAY CARNE NORTE 100G',41,10,'PCS','BUTAL',1473,48,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1482,'HCN 150','HOLIDAY CARNE NORTE 150G',41,10,'PCS','BUTAL',1473,100,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1483,'HCLM 160','HOLIDAY CHINESE LUNCHEON MEAT 160G',41,10,'PCS','BUTAL',1473,100,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1484,'HCLM 375','HOLIDAY CHINESE LUNCHEON MEAT 375G',41,10,'PCS','BUTAL',1473,48,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1485,'HCCB 190','HOLIDAY CHUNKY CORNED BEEF 190G',41,10,'PCS','BUTAL',1473,48,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1486,'HCB 160','HOLIDAY CORNED BEEF 160G',41,10,'PCS','BUTAL',1473,100,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1487,'HCB 215','HOLIDAY CORNED BEEF 215G',41,10,'PCS','BUTAL',1473,48,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1488,'HCB 1.9','HOLIDAY CORNED BEEF 1.9KG',41,10,'PCS','BUTAL',1473,6,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1489,'HLP 160','HOLIDAY LECHON PAKSIW 160G',41,10,'PCS','BUTAL',1473,100,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1490,'HLP 210','HOLIDAY LECHON PAKSIW 210G',41,10,'PCS','BUTAL',1473,48,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1491,'HLM 150','HOLIDAY LUNCHEON MEAT 150G',41,10,'PCS','BUTAL',1473,100,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1492,'HLM 360','HOLIDAY LUNCHEON MEAT 360G',41,10,'PCS','BUTAL',1473,48,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1493,'HMSCB 170','HOLIDAY MANDARIN STYLE CHORIZO & BEANS 170G',41,10,'PCS','BUTAL',1473,100,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1494,'HML 150','HOLIDAY MEAT LOAF 150G',41,10,'PCS','BUTAL',1473,100,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1495,'HML 360','HOLIDAY MEAT LOAF 360G',41,10,'PCS','BUTAL',1473,48,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1496,'HP&B 170','HOLIDAY PORK & BEANS  170G',41,10,'PCS','BUTAL',1473,100,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1497,'HP&B 220','HOLIDAY PORK & BEANS 220G',41,10,'PCS','BUTAL',1473,48,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1498,'HPB2K','HOLIDAY PORK & BEANS  2KG',41,10,'PCS','BUTAL',1473,6,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1499,'HSMS 380','HOLIDAY SPAGHETTI MEAT SAUCE 380G',41,10,'PCS','BUTAL',1473,24,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1500,'HSS 380','HOLIDAY SPAGHETTI SAUCE W/ SAUSAGE 380G',41,10,'PCS','BUTAL',1473,24,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1501,'HMMSS 380','HOLIDAY MEAT & MUSHROOM SPAGHETTI SAUCE 380G',41,10,'PCS','BUTAL',1473,24,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1502,'HSCB 160','HOLIDAY SPANISH STYLE CORNED BEEF 160G',41,10,'PCS','BUTAL',1473,100,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1503,'HVS 90','HOLIDAY VIENNA SAUSAGE 90G',41,10,'PCS','BUTAL',1473,100,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1504,'HVS 127','HOLIDAY VIENNA SAUSAGE 127G',41,10,'PCS','BUTAL',1473,48,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1505,'SPCB 150','SUNPRIDE PREMIUM CORNED BEEF 150G',41,10,'PCS','BUTAL',1473,100,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1506,'SPCB 210','SUNPRIDE PREMIUM CORNED BEEF 210G',41,10,'PCS','BUTAL',1473,48,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1507,'HBL 100','HOLIDAY BEEF LOAF 100G',41,10,'CASE','CASE',1473,48,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1508,'HBL 150','HOLIDAY BEEF LOAF ',41,10,'CASE','CASE',1474,100,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1509,'HBL 215','HOLIDAY BEEF LOAF ',41,10,'CASE','CASE',1475,48,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1510,'HBLHS 100','HOLIDAY BEEF LOAF SPICY HOT',41,10,'CASE','CASE',1476,48,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1511,'HBLHS 150','HOLIDAY BEEF LOAF SPICY HOT',41,10,'CASE','CASE',1477,100,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1512,'HBLHS 215','HOLIDAY BEEF LOAF SPICY HOT',41,10,'CASE','CASE',1478,48,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1513,'HBM 160','HOLIDAY BEEF MECHADO',41,10,'CASE','CASE',1479,100,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1514,'HBM 210','HOLIDAY BEEF MECHADO',41,10,'CASE','CASE',1480,48,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1515,'HCN 100','HOLIDAY CARNE NORTE',41,10,'CASE','CASE',1481,48,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1516,'HCN 150','HOLIDAY CARNE NORTE',41,10,'CASE','CASE',1482,100,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1517,'HCLM 160','HOLIDAY CHINESE LUNCHEON MEAT',41,10,'CASE','CASE',1483,100,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1518,'HCLM 375','HOLIDAY CHINESE LUNCHEON MEAT',41,10,'CASE','CASE',1484,48,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1519,'HCCB 190','HOLIDAY CHUNKY CORNED BEEF',41,10,'CASE','CASE',1485,48,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1520,'HCB 160','HOLIDAY CORNED BEEF',41,10,'CASE','CASE',1486,100,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1521,'HCB 215','HOLIDAY CORNED BEEF',41,10,'CASE','CASE',1487,48,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1522,'HCB 1.9','HOLIDAY CORNED BEEF',41,10,'CASE','CASE',1488,6,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1523,'HLP 160','HOLIDAY LECHON PAKSIW',41,10,'CASE','CASE',1489,100,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1524,'HLP 210','HOLIDAY LECHON PAKSIW',41,10,'CASE','CASE',1490,48,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1525,'HLM 150','HOLIDAY LUNCHEON MEAT',41,10,'CASE','CASE',1491,100,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1526,'HLM 360','HOLIDAY LUNCHEON MEAT',41,10,'CASE','CASE',1492,48,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1527,'HMSCB 170','HOLIDAY MANDARIN STYLE CHORIZO & BEANS',41,10,'CASE','CASE',1493,100,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1528,'HML 150','HOLIDAY MEAT LOAF',41,10,'CASE','CASE',1494,100,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1529,'HML 360','HOLIDAY MEAT LOAF',41,10,'CASE','CASE',1495,48,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1530,'HP&B 170','HOLIDAY PORK & BEANS ',41,10,'CASE','CASE',1496,100,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1531,'HP&B 220','HOLIDAY PORK & BEANS ',41,10,'CASE','CASE',1497,48,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1532,'HPB2K','HOLIDAY PORK & BEANS ',41,10,'CASE','CASE',1498,6,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1533,'HSMS 380','HOLIDAY SPAGHETTI MEAT SAUCE',41,10,'CASE','CASE',1499,24,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1534,'HSS 380','HOLIDAY SPAGHETTI SAUCE W/ SAUSAGE',41,10,'CASE','CASE',1500,24,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1535,'HMMSS 380','HOLIDAY MEAT & MUSHROOM SPAGHETTI SAUCE',41,10,'CASE','CASE',1501,24,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1536,'HSCB 160','HOLIDAY SPANISH STYLE CORNED BEEF',41,10,'CASE','CASE',1502,100,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1537,'HVS 90','HOLIDAY VIENNA SAUSAGE',41,10,'CASE','CASE',1503,100,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1538,'HVS 127','HOLIDAY VIENNA SAUSAGE',41,10,'CASE','CASE',1504,48,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1539,'SPCB 150','SUNPRIDE PREMIUM CORNED BEEF',41,10,'CASE','CASE',1505,100,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1540,'SPCB 210','SUNPRIDE PREMIUM CORNED BEEF',41,10,'CASE','CASE',1506,48,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1541,'PCH050MCB','L&P POWDER CHILL 50G FREE COMB & Bunnytail',32,2,'PCK','BUTAL',1546,15,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1542,'PJG050MCB','L&P POWDER JASMIN GARDEN 50G FREE COMB & Bunnytail',32,2,'PCK','BUTAL',1547,15,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1543,'PRL050MCB','L&P POWDER ROSE & LILY 50G FREE COMB & Bunnytail',32,2,'PCK','BUTAL',1548,15,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1544,'PRN050MCB','L&P POWDER RAIN 50G FREE COMB & Bunnytail',32,2,'PCK','BUTAL',1549,15,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1545,'PWB050MCB','L&P POWDER WHITE BLUSH 50G FREE COMB & Bunnytail',32,2,'PCK','BUTAL',1550,15,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1546,'PCH050MCB','L&P POWDER CHILL 50G FREE COMB & Bunnytail',32,2,'CASE','CASE',1541,15,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1547,'PJG050MCB','L&P POWDER JASMIN GARDEN 50G FREE COMB & Bunnytail',32,2,'CASE','CASE',1542,15,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1548,'PRL050MCB','L&P POWDER ROSE & LILY 50G FREE COMB & Bunnytail',32,2,'CASE','CASE',1543,15,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1549,'PRN050MCB','L&P POWDER RAIN 50G FREE COMB & Bunnytail',32,2,'CASE','CASE',1544,15,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1550,'PWB050MCB','L&P POWDER WHITE BLUSH 50G FREE COMB & Bunnytail',32,2,'CASE','CASE',1545,15,0,'FAST MOVING',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1553,'70D300','GREEN CROSS EHTYL ALCOHOL 70% 300 ML',27,2,'Case','Case',1554,12,0,'Fast Moving',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1554,'70D300','GREEN CROSS EHTYL ALCOHOL 70% 300 ML',27,2,'Butal','Butal',1553,12,0,'Fast Moving',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1555,'DBS033M7D','BUY 9PCS DEL BLUE 33ML FREE 3PCS DEL BLUE 33ML',10,2,'Case','Case',1556,28,0,'Fast Moving',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1556,'DBS033M7D','BUY 9PCS DEL BLUE 33ML FREE 3PCS DEL BLUE 33ML',10,2,'Butal','Butal',1555,28,0,'Fast Moving',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1559,'SCM055M3S','GC MOIST PROTECTION BAR COOL MOUNTAIN 55G 4+2',33,2,'Case','Case',1560,12,0,'Fast Moving',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1560,'SCM055M3S','GC MOIST PROTECTION BAR COOL MOUNTAIN 55G 4+2',33,2,'Butal','Butal',1559,12,0,'Fast Moving',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1561,'SPC055M3S','GC MOIST PROTECTION BAR PURE CARE 55G 4+2',33,2,'Case','Case',1562,12,0,'Fast Moving',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1562,'SPC055M3S','GC MOIST PROTECTION BAR PURE CARE 55G 4+2',33,2,'Butal','Butal',1561,12,0,'Fast Moving',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1563,'DLS033M7D','BUY 9PCS DEL LAVENDER 33ML FREE 3PCS DEL LAVENDER 33ML',28,2,'Case','Case',1564,28,0,'Fast Moving',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1564,'DLS033M7D','BUY 9PCS DEL LAVENDER 33ML FREE 3PCS DEL LAVENDER 33ML',28,2,'Butal','Butal',1563,28,0,'Fast Moving',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1565,'DHS026M1D','6 PCS DEL GENTLE PROTECT 26ML FREE 2PCS DEL GENTLE PROTECT 26ML',28,2,'Case','Case',1566,80,0,'Fast Moving',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1566,'DHS026M1D','6 PCS DEL GENTLE PROTECT 26ML FREE 2PCS DEL GENTLE PROTECT 26ML',28,2,'Butal','Butal',1565,80,0,'Fast Moving',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1567,'3512BP','ESSENTIALS (RED ALERT)2AA BP W/O BATTERY',4,4,'Case','Case',1568,48,0,'Fast Moving',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1568,'3512BP','ESSENTIALS (RED ALERT)2AA BP W/O BATTERY',4,4,'Butal','Butal',1567,48,0,'Fast Moving',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1569,'3512BP','ESSENTIALS (RED ALERT)2AA BP W/O BATTERY',4,4,'Case','Case',1570,48,0,'Fast Moving',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1570,'3512BP','ESSENTIALS (RED ALERT)2AA BP W/O BATTERY',4,4,'Butal','Butal',1569,48,0,'Fast Moving',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1571,'915','DOLE 100% P/A JUICE 177ML X24',16,5,'Case','Case',1572,48,0,'Fast Moving',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1572,'915','DOLE 100% P/A JUICE 177ML X24',16,5,'Butal','Butal',1571,48,0,'Fast Moving',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1573,'DPS033M7D','BUY 9PCS DEL PINK 33ML FREE 3PCS DEL PINK 33ML',28,2,'Case','Case',1574,28,0,'Fast Moving',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1574,'DPS033M7D','BUY 9PCS DEL PINK 33ML FREE 3PCS DEL PINK 33ML',28,2,'Butal','Butal',1573,28,0,'Fast Moving',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1575,'STM120','SUNPRIDE TOCINO MIX 120G X 120\'S',41,10,'Case','Case',1576,120,0,'Fast Moving',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1576,'STM120','SUNPRIDE TOCINO MIX 120G X 120\'S',41,10,'Butal','Butal',1575,120,0,'Fast Moving',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1577,'STM60','SUNPRIDE TOCINO MIX 60G X 240\'S',41,10,'Case','Case',1578,240,0,'Fast Moving',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1578,'STM60','SUNPRIDE TOCINO MIX 60G X 240\'S',41,10,'Butal','Butal',1577,240,0,'Fast Moving',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1579,'STM1KG','SUNPRIDE TOCINO MIX 1KG X 24',41,10,'Case','Case',1580,24,0,'Fast Moving',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1580,'STM1KG','SUNPRIDE TOCINO MIX 1KG X 24',41,10,'Butal','Butal',1579,24,0,'Fast Moving',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1581,'78516','DOLE 100% PINEAPPLE JUICE 240ML X 6 BUY 4 SAVE P10',41,5,'Case','Case',1582,6,0,'Fast Moving',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1582,'78516','DOLE 100% PINEAPPLE JUICE 240ML X 6 BUY 4 SAVE P10',41,5,'Butal','Butal',1581,6,0,'Fast Moving',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1583,'SBM100','SUNPRIDE BARBECUE MIX 100G X 120',41,10,'Case','Case',1584,120,0,'Fast Moving',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1584,'SBM100','SUNPRIDE BARBECUE MIX 100G X 120',41,10,'Butal','Butal',1583,120,0,'Fast Moving',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1585,'SBM50','SUNPRIDE BARBECUE MIX 50G X 240',41,10,'Case','Case',1586,240,0,'Fast Moving',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1586,'SBM50','SUNPRIDE BARBECUE MIX 50G X 240',41,10,'Butal','Butal',1585,240,0,'Fast Moving',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1587,'HBB170','HOLIDAY BAKED BEANS 170G X 100\'S',41,10,'Case','Case',1588,100,0,'Fast Moving',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1588,'HBB170','HOLIDAY BAKED BEANS 170G X 100\'S',41,10,'Butal','Butal',1587,100,0,'Fast Moving',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1589,'MAIN_1135','P-HANA SHAMPOO S & S PINK ROSES & BERRIES 14ML(6+6) x 32',12,8,'Case','Case',1590,32,0,'Fast Moving',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1590,'MAIN_1135','P-HANA SHAMPOO S & S PINK ROSES & BERRIES 14ML(6+6) x 32',12,8,'Butal','Butal',1589,32,0,'Fast Moving',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1591,'MAIN_1137','P-HANA SHAMPOO S & S SPRING FLOWERS & APPLES 14ML(6+6) x 32',12,8,'Case','Case',1592,32,0,'Fast Moving',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1592,'MAIN_1137','P-HANA SHAMPOO S & S SPRING FLOWERS & APPLES 14ML(6+6) x 32',12,8,'Butal','Butal',1591,32,0,'Fast Moving',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1593,'MAIN_1139','P-HANA SHAMPOO S & S GARDEN BLOOMS & LYCHEES 14ML(6+6) x 32',12,8,'Case','Case',1594,32,0,'Fast Moving',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1594,'MAIN_1139','P-HANA SHAMPOO S & S GARDEN BLOOMS & LYCHEES 14ML(6+6) x 32',12,8,'Butal','Butal',1593,32,0,'Fast Moving',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1595,'MAIN_1141','P-HANA SHAMPOO S & S PINK ROSES & BERRIES 21ML(12+12) x 8',12,8,'Case','Case',1596,8,0,'Fast Moving',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1596,'MAIN_1141','P-HANA SHAMPOO S & S PINK ROSES & BERRIES 21ML(12+12) x 8',12,8,'Butal','Butal',1595,8,0,'Fast Moving',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1597,'MAIN_1143','P-HANA SHAMPOO S & S SPRING FLOWERS & APPLES 21ML (12+12) x 8',12,8,'Case','Case',1598,8,0,'Fast Moving',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1598,'MAIN_1143','P-HANA SHAMPOO S & S SPRING FLOWERS & APPLES 21ML (12+12) x 8',12,8,'Butal','Butal',1597,8,0,'Fast Moving',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1599,'MAIN_1191','P-CHAMPION POWDER SUPRA POWER WITH FRABRIC CON 800G(1+3 LFC PF 28ML) x 12',10,8,'Case','Case',1600,12,0,'Fast Moving',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1600,'MAIN_1191','P-CHAMPION POWDER SUPRA POWER WITH FRABRIC CON 800G(1+3 LFC PF 28ML) x 12',10,8,'Butal','Butal',1599,12,0,'Fast Moving',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1601,'MAIN_1193','P-CHAMPION POWDER SUPRA POWER ORIGINAL SUPRA CLEAN 800G(1+3 LFC PF 28ML) x 12',10,8,'Case','Case',1602,12,0,'Fast Moving',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1602,'MAIN_1193','P-CHAMPION POWDER SUPRA POWER ORIGINAL SUPRA CLEAN 800G(1+3 LFC PF 28ML) x 12',10,8,'Butal','Butal',1601,12,0,'Fast Moving',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1603,'MAIN_1195','P-CALLA POWDER FABRIC CONDITIONER FLORAL FRESH 800G (1+3 LFC SB 28ML) x 12',10,8,'Case','Case',1604,12,0,'Fast Moving',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1604,'MAIN_1195','P-CALLA POWDER FABRIC CONDITIONER FLORAL FRESH 800G (1+3 LFC SB 28ML) x 12',10,8,'Butal','Butal',1603,12,0,'Fast Moving',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1605,'MAIN_1197','P-CALLA POWDER FABRIC CONDITIONER ROSE GARDEN 800G (1+3 LFC SB 28ML) x 12',10,8,'Case','Case',1606,12,0,'Fast Moving',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1606,'MAIN_1197','P-CALLA POWDER FABRIC CONDITIONER ROSE GARDEN 800G (1+3 LFC SB 28ML) x 12',10,8,'Butal','Butal',1605,12,0,'Fast Moving',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1607,'MAIN_1199','P-HANA SHAMPOO S & S PINK ROSES & BERRIES 200ML (1+1 100ML) x 16',12,8,'Case','Case',1608,16,0,'Fast Moving',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1608,'MAIN_1199','P-HANA SHAMPOO S & S PINK ROSES & BERRIES 200ML (1+1 100ML) x 16',12,8,'Butal','Butal',1607,16,0,'Fast Moving',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1609,'MAIN_1201','P-HANA SHAMPOO S & S SPRING FLOWERS & APPLES 200ML (1+1 100ML) x 16',12,8,'Case','Case',1610,16,0,'Fast Moving',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1610,'MAIN_1201','P-HANA SHAMPOO S & S SPRING FLOWERS & APPLES 200ML (1+1 100ML) x 16',12,8,'Butal','Butal',1609,16,0,'Fast Moving',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1611,'MAIN_1203','P-HANA SHAMPOO S & S GARDEN BLOOM & LYCHEES 200ML (1+1 100ML) x 16',12,8,'Case','Case',1612,16,0,'Fast Moving',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1612,'MAIN_1203','P-HANA SHAMPOO S & S GARDEN BLOOM & LYCHEES 200ML (1+1 100ML) x 16',12,8,'Butal','Butal',1611,16,0,'Fast Moving',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1613,'MAIN_1209','P-CHAMPION LIQ FAB CON ANTIBAC FRESH DAY 28ML (6+1) x 27',10,8,'Case','Case',1614,27,0,'Fast Moving',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1614,'MAIN_1209','P-CHAMPION LIQ FAB CON ANTIBAC FRESH DAY 28ML (6+1) x 27',10,8,'Butal','Butal',1613,27,0,'Fast Moving',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1615,'MAIN_1211','P-CALLA LIQ FAB CON SUNNY BLUE 28ML (6+1) x 27',10,8,'Case','Case',1616,27,0,'Fast Moving',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1616,'MAIN_1211','P-CALLA LIQ FAB CON SUNNY BLUE 28ML (6+1) x 27',10,8,'Butal','Butal',1615,27,0,'Fast Moving',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1617,'MAIN_1231','CHAMPION POWDER SUPRA POWER WITH FABRIC CONDITIONER 70G (TWIN) x 144',10,8,'Case','Case',1618,144,0,'Fast Moving',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1618,'MAIN_1231','CHAMPION POWDER SUPRA POWER WITH FABRIC CONDITIONER 70G (TWIN) x 144',10,8,'Butal','Butal',1617,144,0,'Fast Moving',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1619,'MAIN_1233','CHAMPION POWDER SUPRA POWER CITRUS FRESH 70G (TWIN) x 144',10,8,'Case','Case',1620,144,0,'Fast Moving',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1620,'MAIN_1233','CHAMPION POWDER SUPRA POWER CITRUS FRESH 70G (TWIN) x 144',10,8,'Butal','Butal',1619,144,0,'Fast Moving',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1621,'MAIN_1235','CHAMPION  LIQUID FABRIC CONDITIONER ANTIBACTERAIL FRESH DAY 84ML x 96',10,8,'Case','Case',1622,96,0,'Fast Moving',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1622,'MAIN_1235','CHAMPION  LIQUID FABRIC CONDITIONER ANTIBACTERAIL FRESH DAY 84ML x 96',10,8,'Butal','Butal',1621,96,0,'Fast Moving',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1623,'MAIN_1237','CALLA LIQUID FABRIC CONDITIONER SUNNY BLUE 84ML x 96',10,8,'Case','Case',1624,96,0,'Fast Moving',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1624,'MAIN_1237','CALLA LIQUID FABRIC CONDITIONER SUNNY BLUE 84ML x 96',10,8,'Butal','Butal',1623,96,0,'Fast Moving',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1625,'SPM50','SUNPRIDE  PORK BARBECUE MIX 50G X 240',41,10,'Case','Case',1626,240,0,'Fast Moving',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1626,'SPM50','SUNPRIDE  PORK BARBECUE MIX 50G X 240',41,10,'Butal','Butal',1625,240,0,'Fast Moving',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1627,'SPM100','SUNPRIDE  PORK BARBECUE MIX 100G X 120',41,10,'Case','Case',1628,120,0,'Fast Moving',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1628,'SPM100','SUNPRIDE  PORK BARBECUE MIX 100G X 120',41,10,'Butal','Butal',1627,120,0,'Fast Moving',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1629,'SPMK','SUNPRIDE  PORK BARBECUE MIX 1KG X 24',41,10,'Case','Case',1630,24,0,'Fast Moving',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1630,'SPMK','SUNPRIDE  PORK BARBECUE MIX 1KG X 24',41,10,'Butal','Butal',1629,24,0,'Fast Moving',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1631,'7701','PINEAPPLE JUICE 240ML. BUY 6 SAVE 15',16,5,'Case','Case',1632,4,0,'Fast Moving',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1632,'7701','PINEAPPLE JUICE 240ML. BUY 6 SAVE 15',16,5,'Butal','Butal',1631,4,0,'Fast Moving',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1633,'SCSS32','SUPER CRUNCH CHIPCHARON SUKA\'T SILI 32G.',36,3,'Case','Case',1634,10,0,'Fast Moving',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1634,'SCSS32','SUPER CRUNCH CHIPCHARON SUKA\'T SILI 32G.',36,3,'Butal','Butal',1633,10,0,'Fast Moving',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1635,'SCCBH24','SUPER CRUNCH CHIPCHARON BLAZIN HOT SILING LABUYO 24G X 4 X 25S',36,3,'Case','Case',1636,4,0,'Fast Moving',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1636,'SCCBH24','SUPER CRUNCH CHIPCHARON BLAZIN HOT SILING LABUYO 24G X 4 X 25S',36,3,'Butal','Butal',1635,4,0,'Fast Moving',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1637,'SCSPP22','SUPER CRUNCH SWEETCORN POPS 22G X 4 X 25s',36,3,'Case','Case',1638,4,0,'Fast Moving',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1638,'SCSPP22','SUPER CRUNCH SWEETCORN POPS 22G X 4 X 25s',36,3,'Butal','Butal',1637,4,0,'Fast Moving',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1639,'SCSCH35','SUPER CRUNCH SULIT PACK CHEESE 35G X 4 X 25s',36,3,'Case','Case',1640,4,0,'Fast Moving',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1640,'SCSCH35','SUPER CRUNCH SULIT PACK CHEESE 35G X 4 X 25s',36,3,'Butal','Butal',1639,4,0,'Fast Moving',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1641,'SCS35','SUPER CRUNCH SULIT PACK SWEETCORN 35G X 4 X 25s',36,3,'Case','Case',1642,4,0,'Fast Moving',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1642,'SCS35','SUPER CRUNCH SULIT PACK SWEETCORN 35G X 4 X 25s',36,3,'Butal','Butal',1641,4,0,'Fast Moving',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1643,'178','CIOCO LUV LUV CRISPY BALL',23,7,'Case','Case',1644,40,0,'Fast Moving',NULL,'2023-04-20 06:24:52',0.00,0.00,'14800818801782',NULL,0),
(1644,'178','CIOCO LUV LUV CRISPY BALL',23,7,'Butal','Butal',1643,40,0,'Fast Moving',NULL,'2023-04-20 06:24:52',0.00,0.00,'4800818801785',NULL,0),
(1645,'178','CIOCO LUV LUV CRISPY BALL',23,7,'Case','Case',1646,40,0,'Fast Moving',NULL,'2023-04-20 06:24:52',0.00,0.00,'14800818801782',NULL,0),
(1646,'178','CIOCO LUV LUV CRISPY BALL',23,7,'Butal','Butal',1645,40,0,'Fast Moving',NULL,'2023-04-20 06:24:52',0.00,0.00,'4800818801785',NULL,0),
(1647,'161','POTCHI CHOCO PEACH MANGO MALLOWS',19,7,'Case','Case',1648,18,0,'Fast Moving',NULL,'2023-04-20 06:24:52',0.00,0.00,'14800818801614',NULL,0),
(1648,'161','POTCHI CHOCO PEACH MANGO MALLOWS',19,7,'Butal','Butal',1647,18,0,'Fast Moving',NULL,'2023-04-20 06:24:52',0.00,0.00,'4800818801617',NULL,0),
(1649,'1163','SWEET TREATS',23,7,'Case','Case',1650,8,0,'Fast Moving',NULL,'2023-04-20 06:24:52',0.00,0.00,'',NULL,0),
(1650,'1163','SWEET TREATS',23,7,'Butal','Butal',1649,8,0,'Fast Moving',NULL,'2023-04-20 06:24:52',0.00,0.00,'',NULL,0),
(1651,'697','CHOCQUIK FIVE MINI',23,7,'Case','Case',1652,20,0,'Fast Moving',NULL,'2023-04-20 06:24:52',0.00,0.00,'14800818606974',NULL,0),
(1652,'697','CHOCQUIK FIVE MINI',23,7,'Butal','Butal',1651,20,0,'Fast Moving',NULL,'2023-04-20 06:24:52',0.00,0.00,'4800818606977',NULL,0),
(1653,'1168','FRUITY JUICY BUBBLE POP',25,7,'Case','Case',1654,20,0,'Fast Moving',NULL,'2023-04-20 06:24:52',0.00,0.00,'',NULL,0),
(1654,'1168','FRUITY JUICY BUBBLE POP',25,7,'Butal','Butal',1653,20,0,'Fast Moving',NULL,'2023-04-20 06:24:52',0.00,0.00,'',NULL,0),
(1655,'1169','FROOTY FRUIT SHAKE',25,7,'Case','Case',1656,20,0,'Fast Moving',NULL,'2023-04-20 06:24:52',0.00,0.00,'',NULL,0),
(1656,'1169','FROOTY FRUIT SHAKE',25,7,'Butal','Butal',1655,20,0,'Fast Moving',NULL,'2023-04-20 06:24:52',0.00,0.00,'',NULL,0),
(1657,'1170','FROOTY CHOCO FUDGE',25,7,'Case','Case',1658,20,0,'Fast Moving',NULL,'2023-04-20 06:24:52',0.00,0.00,'',NULL,0),
(1658,'1170','FROOTY CHOCO FUDGE',25,7,'Butal','Butal',1657,20,0,'Fast Moving',NULL,'2023-04-20 06:24:52',0.00,0.00,'',NULL,0),
(1659,'MAIN_1281','P-CHAMPION POWDER SUPRA POWER ORIGINAL SUPRA CLEAN 35G (5+1)',7,8,'Case','Case',1660,48,0,'Fast Moving',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1660,'MAIN_1281','P-CHAMPION POWDER SUPRA POWER ORIGINAL SUPRA CLEAN 35G (5+1)',7,8,'Butal','Butal',1659,48,0,'Fast Moving',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1661,'MAIN_1223','CHAMPION POWDER FABRICON 35G (6+1) CF 130G',7,8,'Case','Case',1662,32,0,'Fast Moving',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1662,'MAIN_1223','CHAMPION POWDER FABRICON 35G (6+1) CF 130G',7,8,'Butal','Butal',1661,32,0,'Fast Moving',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1663,'MAIN_1225','CHAMPION POWDER SUPRA CLEAN 35G (6+10)SC 130G',7,8,'Case','Case',1664,32,0,'Fast Moving',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1664,'MAIN_1225','CHAMPION POWDER SUPRA CLEAN 35G (6+10)SC 130G',7,8,'Butal','Butal',1663,32,0,'Fast Moving',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1665,'MAIN_1133','P-CHAMPION POWDER SUPRA POWER ORIGINAL SUPRA CLEAN 2000G (1+1 SC370G)',7,8,'Case','Case',1666,6,0,'Fast Moving',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1666,'MAIN_1133','P-CHAMPION POWDER SUPRA POWER ORIGINAL SUPRA CLEAN 2000G (1+1 SC370G)',7,8,'Butal','Butal',1665,6,0,'Fast Moving',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1667,'MAIN_1089','P-CALLA POWDER FABRIC CONDITIONER FLORAL FRESH 1.6KG (1+1 FF370G.)',7,8,'Case','Case',1668,6,0,'Fast Moving',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1668,'MAIN_1089','P-CALLA POWDER FABRIC CONDITIONER FLORAL FRESH 1.6KG (1+1 FF370G.)',7,8,'Butal','Butal',1667,6,0,'Fast Moving',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1669,'MAIN_1089','P-CALLA POWDER FABRIC CONDITIONER FLORAL FRESH 1.6KG (1+1 FF370G.)',7,8,'Case','Case',1670,6,0,'Fast Moving',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1670,'MAIN_1089','P-CALLA POWDER FABRIC CONDITIONER FLORAL FRESH 1.6KG (1+1 FF370G.)',7,8,'Butal','Butal',1669,6,0,'Fast Moving',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1671,'MAIN_1093','P-CALLA POWDER FABRIC CONDITIONER ROSE GARDEN 1.6KG (1+1 RG370G.)',7,8,'Case','Case',1672,6,0,'Fast Moving',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1672,'MAIN_1093','P-CALLA POWDER FABRIC CONDITIONER ROSE GARDEN 1.6KG (1+1 RG370G.)',7,8,'Butal','Butal',1671,6,0,'Fast Moving',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1673,'MAIN_1227','P-CALLA POWDER FABRIC CONDITIONER FLORAL FRESH 45G (6+1 FF370G.)',7,8,'Case','Case',1674,32,0,'Fast Moving',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1674,'MAIN_1227','P-CALLA POWDER FABRIC CONDITIONER FLORAL FRESH 45G (6+1 FF370G.)',7,8,'Butal','Butal',1673,32,0,'Fast Moving',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1675,'MAIN_705','HANA PINK ROSES & BERRIES SCENT 400ML + 180ML REFILL',12,8,'Case','Case',1676,12,0,'Fast Moving',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1676,'MAIN_705','HANA PINK ROSES & BERRIES SCENT 400ML + 180ML REFILL',12,8,'Butal','Butal',1675,12,0,'Fast Moving',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1677,'MAIN_911','HANA SPRING FLOWERS & APPLES SCENT 21ML',12,8,'Case','Case',1678,192,0,'Fast Moving',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1678,'MAIN_911','HANA SPRING FLOWERS & APPLES SCENT 21ML',12,8,'Butal','Butal',1677,192,0,'Fast Moving',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1679,'MAIN_713','HANA PINK SPRING FLOWERS & APPLES SCENT 400ML + 180ML REFILL',12,8,'Case','Case',1680,12,0,'Fast Moving',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1680,'MAIN_713','HANA PINK SPRING FLOWERS & APPLES SCENT 400ML + 180ML REFILL',12,8,'Butal','Butal',1679,12,0,'Fast Moving',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1681,'MAIN_817','HANA GARDEN BLOOMS & LYCHEES SCENT 400ML + 180ML REFILL',12,8,'Case','Case',1682,12,0,'Fast Moving',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1682,'MAIN_817','HANA GARDEN BLOOMS & LYCHEES SCENT 400ML + 180ML REFILL',12,8,'Butal','Butal',1681,12,0,'Fast Moving',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1683,'MAIN_755','HANA CONDITIONER SOFT & SMOOTH 12ML.',12,8,'Case','Case',1684,384,0,'Fast Moving',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1684,'MAIN_755','HANA CONDITIONER SOFT & SMOOTH 12ML.',12,8,'Butal','Butal',1683,384,0,'Fast Moving',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1685,'MAIN_727','HANA CONDITIONER SOFT & SMOOTH 180ML.',12,8,'Case','Case',1686,24,0,'Fast Moving',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1686,'MAIN_727','HANA CONDITIONER SOFT & SMOOTH 180ML.',12,8,'Butal','Butal',1685,24,0,'Fast Moving',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1687,'936','FRUTOS MINI BITS CHEWY SOUR STRAP',22,7,'Case','Case',1688,10,0,'Fast Moving',NULL,'2023-04-20 06:24:52',0.00,0.00,'',NULL,0),
(1688,'936','FRUTOS MINI BITS CHEWY SOUR STRAP',22,7,'Butal','Butal',1687,10,0,'Fast Moving',NULL,'2023-04-20 06:24:52',0.00,0.00,'',NULL,0),
(1689,'1108','BON GIORNO',26,7,'Case','Case',1690,20,0,'Fast Moving',NULL,'2023-04-20 06:24:52',0.00,0.00,'',NULL,0),
(1690,'1108','BON GIORNO',26,7,'Butal','Butal',1689,20,0,'Fast Moving',NULL,'2023-04-20 06:24:52',0.00,0.00,'',NULL,0),
(1691,'1161','LUVLUV CHOCO POLVORON',19,7,'Case','Case',1692,20,0,'Fast Moving',NULL,'2023-04-20 06:24:52',0.00,0.00,'14800818811613',NULL,0),
(1692,'1161','LUVLUV CHOCO POLVORON',19,7,'Butal','Butal',1691,20,0,'Fast Moving',NULL,'2023-04-20 06:24:52',0.00,0.00,'4800818811616',NULL,0),
(1693,'153','MYCHOCO MILK CHOCOLATE',23,7,'Case','Case',1694,20,0,'Fast Moving',NULL,'2023-04-20 06:24:52',0.00,0.00,'',NULL,0),
(1694,'153','MYCHOCO MILK CHOCOLATE',23,7,'Butal','Butal',1693,20,0,'Fast Moving',NULL,'2023-04-20 06:24:52',0.00,0.00,'',NULL,0),
(1695,'SCCBH24','SUPER CRUNCH CHIPCHARON BLAZIN HOT SILING LABUYO',40,3,'Case','Case',1696,4,0,'Fast Moving',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1696,'SCCBH24','SUPER CRUNCH CHIPCHARON BLAZIN HOT SILING LABUYO',40,3,'Butal','Butal',1695,4,0,'Fast Moving',NULL,NULL,0.00,0.00,NULL,NULL,0),
(1700,'176','PRETZEE CHOCOLATE 100PCSX28G',23,7,'Case','CASE',1701,1,0,'','2023-04-14 03:38:30','2023-04-20 06:24:52',0.00,0.00,'',NULL,NULL),
(1701,'176','PRETZEE CHOCOLATE 100PCSX28G',23,7,'Butal','BUTAL',1700,1,0,'','2023-04-14 03:38:30','2023-04-20 06:24:52',0.00,0.00,'',NULL,NULL),
(1702,'183','POTCHI MY JUIZ ORANGE SNACK PACK',22,7,'Case','CASE',1703,1,0,'','2023-04-14 03:40:10','2023-04-20 06:24:52',0.00,0.00,'',NULL,NULL),
(1703,'183','POTCHI MY JUIZ ORANGE SNACK PACK',22,7,'Butal','BUTAL',1702,1,0,'','2023-04-14 03:40:10','2023-04-20 06:24:52',0.00,0.00,'',NULL,NULL);

/*Table structure for table `sku_categories` */

DROP TABLE IF EXISTS `sku_categories`;

CREATE TABLE `sku_categories` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `category` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `principal_id` int unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sku_categories_principal_id_index` (`principal_id`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `sku_categories` */

insert  into `sku_categories`(`id`,`category`,`created_at`,`updated_at`,`principal_id`) values 
(1,'CARBON Z','2021-07-15 17:15:59','2021-07-15 17:15:59',4),
(2,'FLASHLIGHT','2021-07-15 17:16:04','2021-07-15 17:16:04',4),
(3,'ALKALINE','2021-07-15 17:16:15','2021-07-15 17:16:15',4),
(4,'SPECIAL BATTERY','2021-07-15 17:16:20','2021-07-15 17:16:20',4),
(5,'RECHARGEABLE','2021-07-15 17:16:26','2021-07-15 17:16:26',4),
(6,'AUTOCARE','2021-07-15 17:16:30','2021-07-15 17:16:30',4),
(7,'POWDER','2021-07-15 17:18:16','2021-07-15 17:18:16',8),
(8,'HYBRID','2021-07-15 17:18:20','2021-07-15 17:18:20',8),
(9,'BAR','2021-07-15 17:18:23','2021-07-15 17:18:23',8),
(10,'FABRICON','2021-07-15 17:18:40','2021-07-15 17:18:40',8),
(11,'DISHWASHING','2021-07-15 17:18:49','2021-07-15 17:18:49',8),
(12,'HAIR CARE','2021-07-15 17:18:58','2021-07-15 17:18:58',8),
(13,'LIQUID DETERGENT','2021-07-15 17:19:18','2021-07-15 17:19:18',8),
(14,'SOLIDS','2021-07-15 17:19:44','2021-07-15 17:19:44',5),
(15,'MIXED FRUITS','2021-07-15 17:19:49','2021-07-15 17:19:49',5),
(16,'PINEJUICE','2021-07-15 17:19:53','2021-07-15 17:19:53',5),
(17,'MIXED DRINKS','2021-07-15 17:19:57','2021-07-15 17:19:57',5),
(18,'BEGONIA','2021-07-15 17:20:02','2021-07-15 17:20:02',5),
(19,'CHOCOLATE BARS','2021-07-15 17:20:45','2021-07-15 17:20:45',7),
(20,'GUMBALLS & BUBBLE GUM','2021-07-15 17:20:49','2021-07-15 17:20:49',7),
(21,'HARD CANDIES','2021-07-15 17:20:52','2021-07-15 17:20:52',7),
(22,'SOFT CHEWY','2021-07-15 17:20:55','2021-07-15 17:20:55',7),
(23,'SPECIALTY CHOCOLATES','2021-07-15 17:21:03','2021-07-15 17:21:03',7),
(24,'BISCUITS','2021-07-15 17:21:07','2021-07-15 17:21:07',7),
(25,'LOLLIPOP','2021-07-15 17:21:23','2021-07-15 17:21:23',7),
(26,'GUMMY CANDIES','2021-07-15 17:21:48','2021-07-15 17:21:48',7),
(27,'ALCOHOL','2021-07-15 17:22:34','2021-07-15 17:22:34',2),
(28,'FABRIC SOFTENER','2021-07-15 17:22:38','2021-07-15 17:22:38',2),
(29,'SANITIZER','2021-07-15 17:22:42','2021-07-15 17:22:42',2),
(30,'HOME CARE','2021-07-15 17:22:45','2021-07-15 17:22:45',2),
(31,'COLOGNE','2021-07-15 17:22:49','2021-07-15 17:22:49',2),
(32,'FACE POWDER','2021-07-15 17:22:54','2021-07-15 17:22:54',2),
(33,'BATH SOAP','2021-07-15 17:22:57','2021-07-15 17:22:57',2),
(34,'BLEACH','2021-07-15 17:23:02','2021-07-15 17:23:02',2),
(35,'MULTI CLEAN','2021-07-15 17:23:05','2021-07-15 17:23:05',2),
(36,'CORNCHIP','2021-07-15 19:35:38','2021-07-15 19:35:38',3),
(37,'BAKED','2021-07-15 19:35:46','2021-07-15 19:35:46',3),
(38,'EXTRUSION','2021-07-15 19:35:55','2021-07-15 19:35:55',3),
(39,'BAKERY','2021-07-15 19:36:00','2021-07-15 19:36:00',3),
(40,'CHIPS','2021-10-09 03:50:20','2021-10-09 03:50:20',3),
(41,'CANNED GOODS','2022-01-04 18:52:55','2022-01-04 18:52:55',10);

/*Table structure for table `sku_ledgers` */

DROP TABLE IF EXISTS `sku_ledgers`;

CREATE TABLE `sku_ledgers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `sku_id` int unsigned NOT NULL,
  `quantity` int DEFAULT NULL,
  `running_balance` int NOT NULL,
  `user_id` int unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `transaction_type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `all_id` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `principal_id` int unsigned DEFAULT NULL,
  `sku_type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `adjustments` int DEFAULT NULL,
  `remarks` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` double(15,4) NOT NULL,
  `running_amount` double(15,4) DEFAULT NULL,
  `final_unit_cost` double(15,4) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sku_ledgers_sku_id_index` (`sku_id`),
  KEY `sku_ledgers_user_id_index` (`user_id`),
  KEY `sku_ledgers_principal_id_index` (`principal_id`)
) ENGINE=InnoDB AUTO_INCREMENT=86 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `sku_ledgers` */

insert  into `sku_ledgers`(`id`,`sku_id`,`quantity`,`running_balance`,`user_id`,`created_at`,`updated_at`,`transaction_type`,`all_id`,`principal_id`,`sku_type`,`adjustments`,`remarks`,`amount`,`running_amount`,`final_unit_cost`) values 
(1,211,500,500,1,'2023-10-29 01:01:15','2023-10-29 01:01:15','received','1',2,'CASE',NULL,NULL,188969.5080,188969.5080,377.9390),
(2,212,300,300,1,'2023-10-29 01:01:15','2023-10-29 01:01:15','received','1',2,'CASE',NULL,NULL,121174.7040,121174.7040,403.9157),
(3,213,400,400,1,'2023-10-29 01:01:15','2023-10-29 01:01:15','received','1',2,'CASE',NULL,NULL,149184.0000,149184.0000,372.9600),
(4,214,600,600,1,'2023-10-29 01:01:15','2023-10-29 01:01:15','received','1',2,'CASE',NULL,NULL,170629.2000,170629.2000,284.3820),
(5,215,1000,1000,1,'2023-10-29 01:01:15','2023-10-29 01:01:15','received','1',2,'CASE',NULL,NULL,340326.0000,340326.0000,340.3260),
(6,211,500,1000,1,'2023-10-29 01:30:52','2023-10-29 01:30:52','received','2',2,'CASE',NULL,NULL,188969.5080,377939.0160,377.9390),
(7,212,700,1000,1,'2023-10-29 01:30:52','2023-10-29 01:30:52','received','2',2,'CASE',NULL,NULL,282740.9760,403915.6800,403.9157),
(8,213,600,1000,1,'2023-10-29 01:30:52','2023-10-29 01:30:52','received','2',2,'CASE',NULL,NULL,223776.0000,372960.0000,372.9600),
(9,214,30,630,1,'2023-10-29 01:30:52','2023-10-29 01:30:52','received','2',2,'CASE',NULL,NULL,8531.4600,179160.6600,284.3820),
(10,214,370,1000,1,'2023-10-29 01:31:59','2023-10-29 01:31:59','received','3',2,'CASE',NULL,NULL,105221.3400,284382.0000,284.3820),
(11,211,-10,990,1,'2023-10-29 13:26:30','2023-10-29 13:26:30','returned','1',2,'CASE',NULL,NULL,-3779.3902,374159.6258,377.9390),
(12,212,-10,990,1,'2023-10-29 13:26:30','2023-10-29 13:26:30','returned','1',2,'CASE',NULL,NULL,-4039.1568,399876.5232,403.9157),
(13,213,-10,990,1,'2023-10-29 13:26:31','2023-10-29 13:26:31','returned','1',2,'CASE',NULL,NULL,-3729.6000,369230.4000,372.9600),
(14,214,-5,995,1,'2023-10-29 13:26:31','2023-10-29 13:26:31','returned','1',2,'CASE',NULL,NULL,-1421.9100,282960.0900,284.3820),
(15,215,-5,995,1,'2023-10-29 13:26:31','2023-10-29 13:26:31','returned','1',2,'CASE',NULL,NULL,-1701.6300,338624.3700,340.3260),
(16,211,0,990,1,'2023-10-29 13:26:51','2023-10-29 13:26:51','bo allowance adjustment','1',2,'CASE',0,NULL,-490.0000,373669.6258,0.0000),
(17,212,0,990,1,'2023-10-29 13:26:51','2023-10-29 13:26:51','bo allowance adjustment','1',2,'CASE',0,NULL,-290.0000,399586.5232,0.0000),
(18,213,0,990,1,'2023-10-29 13:26:51','2023-10-29 13:26:51','bo allowance adjustment','1',2,'CASE',0,NULL,-390.0000,368840.4000,0.0000),
(19,214,0,995,1,'2023-10-29 13:26:51','2023-10-29 13:26:51','bo allowance adjustment','1',2,'CASE',0,NULL,-595.0000,282365.0900,0.0000),
(20,215,0,995,1,'2023-10-29 13:26:51','2023-10-29 13:26:51','bo allowance adjustment','1',2,'CASE',0,NULL,-995.0000,337629.3700,0.0000),
(21,211,0,990,1,'2023-10-29 13:27:25','2023-10-29 13:27:25','invoice cost adjustment','1',2,'CASE',0,NULL,758.4142,374428.0400,0.0000),
(44,212,1,991,1,'2023-11-07 05:47:25','2023-11-07 05:47:25','booking cm','12',2,'CASE',NULL,NULL,470.0000,400056.5232,403.6228),
(45,213,2,992,1,'2023-11-07 05:47:25','2023-11-07 05:47:25','booking cm','12',2,'CASE',NULL,NULL,800.0000,369640.4000,372.5661),
(46,214,2,997,1,'2023-11-07 05:47:25','2023-11-07 05:47:25','booking cm','12',2,'CASE',NULL,NULL,610.0000,282975.0900,283.7840),
(47,215,1,996,1,'2023-11-07 05:47:25','2023-11-07 05:47:25','booking cm','12',2,'CASE',NULL,NULL,365.0000,337994.3700,339.3260),
(48,212,10,1001,1,'2023-11-08 11:06:03','2023-11-08 11:06:03','booking cm','13',2,'CASE',NULL,NULL,0.0000,NULL,0.0000),
(49,213,10,1002,1,'2023-11-08 11:06:03','2023-11-08 11:06:03','booking cm','13',2,'CASE',NULL,NULL,0.0000,NULL,0.0000),
(50,211,1000,1990,1,'2023-11-13 11:47:18','2023-11-13 11:47:18','received','1',2,'CASE',NULL,NULL,377939.0160,752367.0560,377.9390),
(51,212,1000,2001,1,'2023-11-13 11:47:18','2023-11-13 11:47:18','received','1',2,'CASE',NULL,NULL,403915.6800,403915.6800,403.9157),
(52,213,1000,2002,1,'2023-11-13 11:47:18','2023-11-13 11:47:18','received','1',2,'CASE',NULL,NULL,372960.0000,372960.0000,372.9600),
(53,214,1000,1997,1,'2023-11-13 11:47:18','2023-11-13 11:47:18','received','1',2,'CASE',NULL,NULL,284382.0000,567357.0900,284.3820),
(54,211,-10,1980,1,'2023-11-13 11:48:46','2023-11-13 11:48:46','returned','1',2,'CASE',NULL,NULL,-3779.3902,748587.6658,377.9390),
(55,212,-20,1981,1,'2023-11-13 11:48:46','2023-11-13 11:48:46','returned','1',2,'CASE',NULL,NULL,-8078.3136,395837.3664,403.9157),
(56,213,-30,1972,1,'2023-11-13 11:48:46','2023-11-13 11:48:46','returned','1',2,'CASE',NULL,NULL,-11188.8000,361771.2000,372.9600),
(57,214,-40,1957,1,'2023-11-13 11:48:46','2023-11-13 11:48:46','returned','1',2,'CASE',NULL,NULL,-11375.2800,555981.8100,284.3820),
(58,211,0,1980,1,'2023-11-13 11:57:43','2023-11-13 11:57:43','bo allowance adjustment','1',2,'CASE',0,NULL,-990.0000,747597.6658,0.0000),
(59,212,0,1981,1,'2023-11-13 11:57:43','2023-11-13 11:57:43','bo allowance adjustment','1',2,'CASE',0,NULL,-980.0000,394857.3664,0.0000),
(60,213,0,1972,1,'2023-11-13 11:57:43','2023-11-13 11:57:43','bo allowance adjustment','1',2,'CASE',0,NULL,-970.0000,360801.2000,0.0000),
(61,214,0,1957,1,'2023-11-13 11:57:43','2023-11-13 11:57:43','bo allowance adjustment','1',2,'CASE',0,NULL,-960.0000,555021.8100,0.0000),
(62,211,0,1980,1,'2023-11-13 12:15:09','2023-11-13 12:15:09','bo allowance adjustment','2',2,'CASE',0,NULL,990.0000,748587.6658,0.0000),
(63,212,0,1981,1,'2023-11-13 12:15:09','2023-11-13 12:15:09','bo allowance adjustment','2',2,'CASE',0,NULL,980.0000,395837.3664,0.0000),
(64,213,0,1972,1,'2023-11-13 12:15:09','2023-11-13 12:15:09','bo allowance adjustment','2',2,'CASE',0,NULL,970.0000,361771.2000,0.0000),
(65,214,0,1957,1,'2023-11-13 12:15:09','2023-11-13 12:15:09','bo allowance adjustment','2',2,'CASE',0,NULL,960.0000,555981.8100,0.0000),
(66,211,-5,1975,1,'2023-11-14 14:33:12','2023-11-14 14:33:12','out from warehouse booking','1',2,'CASE',NULL,NULL,-1890.3729,746697.2929,378.0746),
(67,212,-5,1976,1,'2023-11-14 14:33:12','2023-11-14 14:33:12','out from warehouse booking','1',2,'CASE',NULL,NULL,-999.0847,394838.2817,199.8169),
(68,213,-5,1967,1,'2023-11-14 14:33:12','2023-11-14 14:33:12','out from warehouse booking','1',2,'CASE',NULL,NULL,-917.2698,360853.9302,183.4540),
(69,214,-5,1952,1,'2023-11-14 14:33:12','2023-11-14 14:33:12','out from warehouse booking','1',2,'CASE',NULL,NULL,-1420.4952,554561.3148,284.0990),
(76,211,100,2075,1,'2023-12-23 05:16:19','2023-12-23 05:16:19','received','2',2,'CASE',NULL,NULL,37793.9016,784491.1945,377.9390),
(77,211,-10,2065,1,'2023-12-23 05:35:35','2023-12-23 05:35:35','returned','2',2,'CASE',NULL,NULL,-3779.3902,780711.8043,377.9390),
(78,211,0,2065,1,'2023-12-23 06:08:25','2023-12-23 06:08:25','bo allowance adjustment','3',2,'CASE',0,NULL,-90.0000,780621.8043,0.0000),
(79,211,1000,3065,1,'2023-12-28 04:46:33','2023-12-28 04:46:33','received','3',2,'CASE',NULL,NULL,377939.0160,1158560.8203,377.9390),
(82,211,-5,3060,1,'2024-02-05 16:43:22','2024-02-05 16:43:22','out from warehouse booking','2',2,'CASE',NULL,NULL,-1889.9850,1156670.8353,377.9970),
(83,212,-5,1971,1,'2024-02-05 16:43:22','2024-02-05 16:43:22','out from warehouse booking','2',2,'CASE',NULL,NULL,-999.0847,393839.1970,199.8169),
(84,213,-5,1962,1,'2024-02-05 16:43:22','2024-02-05 16:43:22','out from warehouse booking','2',2,'CASE',NULL,NULL,-917.2698,359936.6604,183.4540),
(85,214,-5,1947,1,'2024-02-05 16:43:22','2024-02-05 16:43:22','out from warehouse booking','2',2,'CASE',NULL,NULL,-1420.4952,553140.8196,284.0990);

/*Table structure for table `sku_price_details` */

DROP TABLE IF EXISTS `sku_price_details`;

CREATE TABLE `sku_price_details` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `sku_id` int NOT NULL,
  `unit_cost` double(15,4) NOT NULL,
  `price_1` double(15,4) DEFAULT NULL,
  `price_2` double(15,4) DEFAULT NULL,
  `price_3` double(15,4) DEFAULT NULL,
  `price_4` double(15,4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `price_5` double(15,4) DEFAULT NULL,
  `final_unit_cost` double(15,4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=533 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `sku_price_details` */

insert  into `sku_price_details`(`id`,`sku_id`,`unit_cost`,`price_1`,`price_2`,`price_3`,`price_4`,`created_at`,`updated_at`,`price_5`,`final_unit_cost`) values 
(1,1270,630.6443,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','2023-08-12 06:32:58',0.0000,643.9138),
(2,1271,865.6717,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','2023-08-08 13:35:52',0.0000,1054.6688),
(3,1272,630.6443,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(4,1273,865.6717,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(5,1274,1183.0162,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(6,1275,865.6717,1077.3600,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','2023-06-30 11:37:32',0.0000,0.0000),
(7,1276,865.6717,1077.3600,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','2023-06-30 11:37:32',0.0000,893.2963),
(8,1277,1061.3624,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(9,1278,1061.3624,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(10,1279,1061.3624,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(11,1280,802.1988,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(12,1281,802.1988,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(13,1282,1061.3624,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(14,1283,1061.3624,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(15,1284,1214.7477,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(16,1285,1214.7477,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(17,1286,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(18,1287,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(19,1288,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(20,1289,628.5315,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(21,1290,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(22,1291,823.3564,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(23,1292,632.9477,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(24,1293,1214.7477,1513.6000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','2023-06-30 11:37:32',0.0000,0.0000),
(25,1294,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(26,1295,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(27,1296,918.5608,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(28,1297,1214.7477,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(29,1298,1167.1505,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(30,1299,1167.1505,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(31,1300,1119.5433,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(32,1301,1119.5433,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(33,1302,1260.2321,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,1286.7741),
(34,1303,1260.2321,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(35,1304,1260.2321,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(36,1305,1119.5433,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(37,1306,1183.0162,1513.6000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','2023-06-30 11:37:32',0.0000,0.0000),
(38,1307,876.2455,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(39,1308,1204.1738,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(40,1309,1004.2476,1250.5400,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','2023-06-30 11:37:32',0.0000,0.0000),
(41,1310,1004.2476,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,1031.4920),
(42,1311,1004.2476,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,1031.4920),
(43,1312,558.9010,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(44,1313,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(45,1314,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(46,1315,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(47,1316,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(48,1317,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(49,1318,975.6854,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(50,1319,558.9010,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(51,1320,1183.0162,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(52,1321,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(53,1322,951.1808,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(54,1323,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(55,1324,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(56,1325,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(57,1326,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(58,1327,337.6364,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(59,1328,337.6364,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(60,1329,337.6364,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(61,1330,337.6364,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(62,1331,337.6364,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(63,1332,337.6364,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(64,1333,369.6345,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(65,1334,369.6345,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(66,1335,337.6364,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(67,1336,1204.1738,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(68,1337,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(69,1338,1204.1738,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(70,1339,1183.0162,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(71,1340,1024.3390,1275.6500,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','2023-06-30 11:37:32',0.0000,0.0000),
(72,1341,879.7702,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(73,1342,811.0153,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(74,1343,1251.7711,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(75,1344,995.2534,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(76,1345,995.2534,1239.3000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','2023-06-30 11:37:32',0.0000,1022.5225),
(77,1346,995.2534,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(78,1347,1024.3390,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,1051.5283),
(79,1348,1024.3390,1275.6500,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','2023-06-30 11:37:32',0.0000,1051.5283),
(80,1349,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(81,1350,977.7982,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(82,1351,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(83,1352,911.5115,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(84,1353,1183.0162,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(85,1354,1167.1505,1454.1100,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','2023-06-30 11:37:32',0.0000,1193.9479),
(86,1355,1167.1505,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(87,1356,1167.1505,1077.3600,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','2023-06-30 11:38:41',0.0000,0.0000),
(88,1357,1167.1505,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,1193.9479),
(89,1358,796.9168,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(90,1359,461.0476,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(91,1360,461.0476,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(92,1361,1167.1505,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(93,1362,461.0476,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(94,1363,1167.1505,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(95,1364,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(96,1365,678.7876,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(97,1366,705.2371,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(98,1367,705.2371,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(99,1368,1183.0162,1473.9400,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','2023-06-30 11:37:32',0.0000,1209.7701),
(100,1369,678.7876,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(101,1370,705.2371,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(102,1371,934.4265,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(103,1372,1183.0162,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(104,1373,796.9168,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(105,1374,796.9168,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(106,1375,796.9168,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(107,1376,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(108,1377,796.9168,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(109,1378,720.2241,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(110,1379,720.2241,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(111,1380,720.2241,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(112,1381,720.2241,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(113,1382,796.9168,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(114,1383,796.9168,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(115,1384,796.9168,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(116,1385,796.9168,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(117,1386,876.2455,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(118,1387,796.9168,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(119,1388,704.3584,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(120,1389,704.3584,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(121,1390,410.7946,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(122,1391,410.7946,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(123,1392,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(124,1393,410.7946,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(125,1394,802.1859,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(126,1395,802.1859,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(127,1396,652.3480,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(128,1397,652.3480,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(129,1398,550.0944,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(130,1399,352.6136,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(131,1400,522.7662,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(132,1401,833.9402,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(133,1402,675.2630,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(134,1403,675.2630,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(135,1404,684.0795,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(136,1405,590.6424,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(137,1406,590.6424,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(138,1407,467.2311,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(139,1408,467.2311,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(140,1409,1019.9227,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','2023-06-30 11:38:41',0.0000,0.0000),
(141,1410,1019.9227,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','2023-06-30 11:38:41',0.0000,1047.1241),
(142,1411,421.2006,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(143,1412,421.2006,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(144,1413,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(145,1414,402.1558,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(146,1415,1183.0162,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(147,1416,676.1287,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(148,1417,590.6424,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(149,1418,995.2534,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(150,1419,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(151,1420,468.9756,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(152,1421,468.9756,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(153,1422,598.9128,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(154,1423,598.9128,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(155,1424,680.5548,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(156,1425,955.5841,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(157,1426,784.5757,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(158,1427,1003.1814,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(159,1643,833.9402,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(160,1645,833.9402,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(161,1647,369.6345,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(162,1649,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(163,1651,680.5548,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(164,1653,977.7982,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(165,1655,977.7982,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(166,1657,977.7982,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(167,1687,796.9168,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(168,1689,622.3738,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(169,1691,740.8486,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(170,1693,421.2006,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(171,1700,492.7921,611.3600,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','2023-06-30 11:38:41',0.0000,521.4399),
(172,1702,951.1808,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(173,1112,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(174,1113,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(175,1114,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(176,1115,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(177,1116,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(178,1117,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','2023-06-30 11:37:31',0.0000,0.0000),
(179,1118,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','2023-06-30 11:37:32',0.0000,0.0000),
(180,1119,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(181,1120,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(182,1121,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(183,1122,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(184,1123,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(185,1124,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(186,1125,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(187,1126,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(188,1127,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(189,1128,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(190,1129,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(191,1130,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(192,1131,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(193,1132,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(194,1133,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(195,1134,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(196,1135,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','2023-06-30 11:37:32',0.0000,0.0000),
(197,1136,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(198,1137,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(199,1138,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(200,1139,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(201,1140,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(202,1141,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(203,1142,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(204,1143,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(205,1144,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(206,1145,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(207,1146,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(208,1147,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(209,1148,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','2023-06-30 11:37:32',0.0000,0.0000),
(210,1149,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(211,1150,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(212,1151,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','2023-06-30 11:37:32',0.0000,0.0000),
(213,1152,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(214,1153,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(215,1154,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(216,1155,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(217,1156,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(218,1157,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(219,1158,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(220,1159,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(221,1160,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(222,1161,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(223,1162,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(224,1163,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(225,1164,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(226,1165,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(227,1166,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(228,1167,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(229,1168,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(230,1169,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(231,1170,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(232,1171,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(233,1172,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(234,1173,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(235,1174,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(236,1175,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(237,1176,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(238,1177,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(239,1178,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(240,1179,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(241,1180,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(242,1181,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(243,1182,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','2023-06-30 11:37:32',0.0000,0.0000),
(244,1183,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(245,1184,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(246,1185,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(247,1186,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(248,1187,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','2023-06-30 11:37:32',0.0000,0.0000),
(249,1188,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(250,1189,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(251,1190,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','2023-06-30 11:37:32',0.0000,0.0000),
(252,1191,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(253,1192,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(254,1193,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(255,1194,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(256,1195,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(257,1196,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','2023-06-30 11:37:32',0.0000,0.0000),
(258,1197,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(259,1198,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','2023-06-30 11:38:41',0.0000,0.0000),
(260,1199,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(261,1200,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(262,1201,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(263,1202,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(264,1203,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(265,1204,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(266,1205,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(267,1206,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(268,1207,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(269,1208,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(270,1209,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(271,1210,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','2023-06-30 11:37:32',0.0000,0.0000),
(272,1211,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(273,1212,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(274,1213,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(275,1214,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(276,1215,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(277,1216,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(278,1217,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(279,1218,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(280,1219,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(281,1220,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(282,1221,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(283,1222,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(284,1223,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(285,1224,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(286,1225,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(287,1226,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(288,1227,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(289,1228,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(290,1229,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(291,1230,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(292,1231,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(293,1232,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(294,1233,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(295,1234,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(296,1235,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(297,1236,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(298,1237,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(299,1238,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(300,1239,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(301,1240,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(302,1241,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(303,1242,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(304,1243,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(305,1244,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(306,1245,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(307,1246,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(308,1247,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(309,1248,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(310,1249,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(311,1250,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(312,1251,128.8900,128.8900,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','2023-06-30 11:38:41',0.0000,0.0000),
(313,1252,128.8900,128.8900,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','2023-06-30 11:38:41',0.0000,0.0000),
(314,1253,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(315,1254,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(316,1255,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(317,1256,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(318,1257,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(319,1258,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(320,1259,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(321,1260,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(322,1261,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(323,1262,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(324,1263,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(325,1264,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(326,1265,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(327,1266,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(328,1267,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(329,1268,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(330,1269,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(331,1644,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(332,1646,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(333,1648,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(334,1650,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(335,1652,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(336,1654,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(337,1656,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(338,1658,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(339,1688,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(340,1690,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(341,1692,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(342,1694,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(343,1701,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','2023-06-30 11:38:41',0.0000,0.0000),
(344,1703,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(345,956,9.0200,10.4500,10.6600,10.9800,10.7700,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,9.3000),
(346,957,9.0200,10.4500,10.6600,10.9800,10.7700,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,9.3000),
(347,958,9.0200,10.4500,10.6600,10.9800,10.7700,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,9.3000),
(348,959,9.0200,10.4500,10.6600,10.9800,10.7700,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,9.3000),
(349,960,9.0200,10.4500,10.6600,10.9800,10.7700,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,9.3000),
(350,961,9.0200,10.4500,10.6600,10.9800,10.7700,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,9.3000),
(351,962,9.0200,10.4500,10.6600,10.9800,10.7700,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,9.3000),
(352,963,9.0200,10.4500,10.6600,10.9800,10.7700,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,9.3000),
(353,964,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(354,965,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(355,966,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(356,967,8.7500,10.3900,10.6000,10.9100,10.7000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,9.0200),
(357,968,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(358,969,71.2700,84.5900,86.2800,88.8200,87.1300,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,73.4800),
(359,970,71.2700,84.5900,86.2800,88.8200,87.1300,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,73.4800),
(360,971,71.2700,84.5900,86.2800,88.8200,87.1300,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,73.4800),
(361,972,71.2700,84.5900,86.2800,88.8200,87.1300,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,73.4800),
(362,973,18.8900,22.4200,22.8700,24.0400,23.1000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,19.4700),
(363,974,18.8900,22.4200,22.8700,24.0400,23.1000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,19.4700),
(364,975,18.8900,22.4200,22.8700,24.0400,23.1000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,19.4700),
(365,976,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(366,977,71.2500,84.5900,86.2800,88.8200,87.1300,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,73.4800),
(367,978,71.2500,84.5900,86.2800,88.8200,87.1300,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,73.4800),
(368,979,71.2500,84.5900,86.2800,88.8200,87.1300,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,73.4800),
(369,980,71.2500,84.5900,86.2800,88.8200,87.1300,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,73.4800),
(370,981,16.0900,19.1100,19.4900,20.0600,19.6800,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,16.6000),
(371,982,16.0900,19.1100,19.4900,20.0600,19.6800,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,16.6000),
(372,983,17.7200,21.0400,21.4600,22.0900,21.6700,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,18.2700),
(373,984,17.7200,21.0400,21.4600,22.0900,21.6700,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,18.2700),
(374,985,17.5000,20.7800,21.2000,21.8300,21.4000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,18.0500),
(375,986,17.5000,20.7800,21.2000,21.8300,21.4000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,18.0500),
(376,987,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(377,988,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(378,989,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(379,990,75.0000,89.0400,90.8300,93.5000,91.7200,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,77.3400),
(380,991,129.4700,153.7000,156.7800,161.3900,158.3100,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,133.5100),
(381,992,21.1500,25.1100,25.6200,26.3700,25.8700,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,21.8100),
(382,993,61.6100,73.1400,74.6100,76.8000,75.3400,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,63.5300),
(383,994,75.9700,90.1900,92.0000,94.7000,92.9000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,78.3400),
(384,995,135.3600,160.7000,163.9100,168.7300,165.5200,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,139.5800),
(385,996,75.0000,89.0400,90.8300,93.5000,91.7200,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,77.3400),
(386,997,58.0400,68.9000,70.2800,72.3500,70.9700,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,59.8500),
(387,998,71.2500,84.5900,86.2800,88.8200,87.1300,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,73.4800),
(388,999,129.4700,153.7000,156.7800,161.3900,158.3100,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,133.5100),
(389,1000,71.2500,84.5900,86.2800,88.8200,87.1300,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,73.4800),
(390,1001,70.3200,83.4800,85.1500,87.6500,85.9800,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,72.5100),
(391,1002,129.4700,153.7000,156.7800,161.3900,158.3100,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,133.5100),
(392,1003,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(393,1004,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(394,1005,70.3200,83.4800,85.1500,87.6500,85.9800,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,72.5100),
(395,1006,58.0400,68.9000,70.2800,72.3500,70.9700,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,59.8500),
(396,1007,43.7500,51.9400,52.9800,54.5400,53.5000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,45.1200),
(397,1008,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(398,1009,58.0400,68.9000,70.2800,72.3500,70.9700,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,59.8500),
(399,1010,43.7500,51.9400,52.9800,54.5400,53.5000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,45.1200),
(400,1011,58.0400,68.9000,70.2800,72.3500,70.9700,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,59.8500),
(401,1012,43.7500,51.9400,52.9800,54.5400,53.5000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,45.1200),
(402,1013,33.3400,39.5800,40.3700,41.5600,40.7700,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,34.3800),
(403,1014,41.0800,48.7600,49.7400,51.2000,50.2300,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,42.3600),
(404,1015,5.6700,6.7400,6.8700,7.0700,6.9400,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,5.8500),
(405,1016,92.8600,110.2400,112.4500,115.7600,113.5500,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,95.7600),
(406,1017,72.3300,85.8600,87.5800,90.1600,88.4400,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,74.5800),
(407,1018,72.3300,85.8600,87.5800,90.1600,88.4400,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,74.5800),
(408,1019,76.7900,91.1600,92.9900,95.7200,93.9000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,79.1800),
(409,1020,76.7900,91.1600,92.9900,95.7200,93.9000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,79.1800),
(410,1021,76.7900,91.1600,92.9900,95.7200,93.9000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,79.1800),
(411,1022,67.8600,80.5600,82.1800,84.5900,82.9800,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,69.9800),
(412,1023,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(413,1024,72.3300,85.8600,87.5800,90.1600,88.4400,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,74.5800),
(414,1025,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(415,1026,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(416,1027,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(417,1028,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(418,1029,14.9200,17.7100,18.0600,18.5900,18.2400,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,15.3800),
(419,1030,14.9200,17.7100,18.0600,18.5900,18.2400,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,15.3800),
(420,1031,71.2500,84.5900,86.2800,88.8200,87.1300,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,73.4800),
(421,1032,16.2100,19.2400,19.6300,20.2100,19.8200,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,16.7200),
(422,1033,29.7400,35.3000,36.0100,37.0700,36.3600,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,30.6600),
(423,1034,180.3600,209.0000,213.1800,219.4500,215.2700,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,185.9800),
(424,1035,180.3600,209.0000,213.1800,219.4500,215.2700,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,185.9800),
(425,1036,180.3600,209.0000,213.1800,219.4500,215.2700,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,185.9800),
(426,1037,180.3600,209.0000,213.1800,219.4500,215.2700,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,185.9800),
(427,1038,180.3600,209.0000,213.1800,219.4500,215.2700,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,185.9800),
(428,1039,180.3600,209.0000,213.1800,219.4500,215.2700,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,185.9800),
(429,1040,180.3600,209.0000,213.1800,219.4500,215.2700,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,185.9800),
(430,1041,180.3600,209.0000,213.1800,219.4500,215.2700,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,185.9800),
(431,1042,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(432,1043,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(433,1044,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(434,1045,175.0000,207.7600,211.9200,218.1500,213.9900,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,180.4600),
(435,1046,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(436,1047,356.3500,422.9400,431.4000,444.0900,435.6300,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,367.3600),
(437,1048,356.3500,422.9400,431.4000,444.0900,435.6300,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,367.3600),
(438,1049,356.3500,422.9400,431.4000,444.0900,435.6300,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,367.3600),
(439,1050,356.3500,422.9400,431.4000,444.0900,435.6300,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,367.3600),
(440,1051,377.6800,448.3800,457.3500,480.8000,461.8300,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,389.4600),
(441,1052,377.6800,448.3800,457.3500,480.8000,461.8300,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,389.4600),
(442,1053,377.6800,448.3800,457.3500,480.8000,461.8300,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,389.4600),
(443,1054,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(444,1055,356.2500,422.9400,431.4000,444.0900,435.6300,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,367.3600),
(445,1056,356.2500,422.9400,431.4000,444.0900,435.6300,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,367.3600),
(446,1057,356.2500,422.9400,431.4000,444.0900,435.6300,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,367.3600),
(447,1058,356.2500,422.9400,431.4000,444.0900,435.6300,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,367.3600),
(448,1059,804.4600,955.0600,974.1600,1002.8100,983.7100,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,829.5500),
(449,1060,804.4600,955.0600,974.1600,1002.8100,983.7100,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,829.5500),
(450,1061,442.8600,525.7600,536.2800,552.0500,541.5300,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,456.6700),
(451,1062,442.8600,525.7600,536.2800,552.0500,541.5300,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,456.6700),
(452,1063,350.0000,415.5200,423.8300,436.6000,427.9900,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,360.9100),
(453,1064,350.0000,415.5200,423.8300,436.6000,427.9900,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,360.9100),
(454,1065,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(455,1066,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(456,1067,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(457,1068,900.0000,1068.4800,1089.8500,1121.9000,1100.5300,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,928.0700),
(458,1069,517.8600,614.8000,627.1000,645.5400,633.2400,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,534.0100),
(459,1070,676.7900,803.4800,819.5500,843.6500,827.5800,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,697.8900),
(460,1071,308.0400,365.7000,373.0100,383.9900,376.6700,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,317.6400),
(461,1072,911.6100,1082.2600,1103.9100,1136.3700,1114.7300,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,940.0300),
(462,1073,676.7900,803.4800,819.5500,843.6500,827.5800,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,697.8900),
(463,1074,900.0000,1068.4800,1089.8500,1121.9000,1100.5300,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,928.0700),
(464,1075,290.1800,344.5000,351.3900,361.7300,354.8400,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,299.2300),
(465,1076,356.2500,422.9400,431.4000,444.0900,435.6300,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,367.3600),
(466,1077,517.8600,614.8000,627.1000,645.5400,633.2400,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,534.0100),
(467,1078,356.2500,422.9400,431.4000,444.0900,435.6300,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,367.3600),
(468,1079,843.7500,1001.7000,1021.7300,1051.7900,1031.7500,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,870.0600),
(469,1080,517.8600,614.8000,627.1000,645.5400,633.2400,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,534.0100),
(470,1081,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(471,1082,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(472,1083,843.7500,1001.7000,1021.7300,1051.7900,1031.7500,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,870.0600),
(473,1084,696.4300,826.8000,843.3400,868.1400,851.6000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,718.1500),
(474,1085,1050.0000,1246.5600,1271.4900,1308.8900,1283.9600,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,1082.7400),
(475,1086,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(476,1087,696.4300,826.8000,843.3400,868.1400,851.6000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,718.1500),
(477,1088,1050.0000,1246.5600,1271.4900,1308.8900,1283.9600,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,1082.7400),
(478,1089,696.4300,826.8000,843.3400,868.1400,851.6000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,718.1500),
(479,1090,1050.0000,1246.5600,1271.4900,1308.8900,1283.9600,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,1082.7400),
(480,1091,800.0000,949.7600,968.7600,997.2500,978.2500,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,824.9500),
(481,1092,985.7100,1170.2400,1193.6400,1228.7500,1205.3500,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,1016.4500),
(482,1093,566.9600,673.1000,686.5600,706.7600,693.2900,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,584.6400),
(483,1094,1485.7100,1763.8400,1799.1200,1852.0300,1816.7600,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,1532.0400),
(484,1095,1446.4300,1717.2000,1751.5400,1803.0600,1768.7200,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,1491.5300),
(485,1096,1446.4300,1717.2000,1751.5400,1803.0600,1768.7200,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,1491.5300),
(486,1097,1151.7900,1367.4000,1394.7500,1435.7700,1408.4200,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,1187.7000),
(487,1098,1151.7900,1367.4000,1394.7500,1435.7700,1408.4200,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,1187.7000),
(488,1099,1151.7900,1367.4000,1394.7500,1435.7700,1408.4200,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,1187.7000),
(489,1100,1357.1400,1611.2000,1643.4200,1691.7600,1659.5400,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,1399.4600),
(490,1101,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(491,1102,1446.4300,1717.2000,1751.5400,1803.0600,1768.7200,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,1491.5300),
(492,1103,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(493,1104,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(494,1105,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(495,1106,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(496,1107,298.2100,354.0400,361.1200,371.7400,364.6600,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,307.5100),
(497,1108,298.2100,354.0400,361.1200,371.7400,364.6600,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,307.5100),
(498,1109,356.2500,422.9400,431.4000,444.0900,435.6300,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,367.3600),
(499,1110,162.0500,192.3900,196.2400,202.0100,198.1600,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,167.1100),
(500,1111,297.3200,352.9800,360.0400,370.6300,363.5700,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,306.5900),
(501,1633,676.7900,803.4800,819.5500,843.6500,827.5800,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,697.8900),
(502,1634,67.6800,80.3500,81.9600,84.3700,82.7600,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,69.7900),
(503,1635,499.1100,592.5400,604.3900,622.1700,610.3200,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,514.6700),
(504,1636,124.7800,148.1400,151.1000,155.5400,152.5800,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,128.6700),
(505,1637,499.1000,592.5400,604.3900,622.1700,610.3200,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,514.6700),
(506,1638,124.7800,148.1400,151.1000,155.5500,152.5800,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,128.6700),
(507,1639,475.0000,563.9200,575.2000,592.1200,580.8400,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,489.8100),
(508,1640,118.7500,140.9800,143.8000,148.0300,145.2100,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,122.4600),
(509,1641,475.0000,563.9200,575.2000,592.1200,580.8400,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,489.8100),
(510,1642,118.7500,140.9800,143.8000,148.0300,145.2100,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,122.4600),
(511,1695,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(512,1696,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,0.0000),
(513,166,0.0000,0.0000,0.0000,0.0000,0.0000,'2023-06-30 11:40:20','2023-06-30 11:40:20',0.0000,NULL),
(514,194,0.0000,0.0000,0.0000,0.0000,0.0000,'2023-06-30 11:40:20','2023-06-30 11:40:20',0.0000,NULL),
(515,195,0.0000,0.0000,0.0000,0.0000,0.0000,'2023-06-30 11:40:20','2023-06-30 11:40:20',0.0000,NULL),
(516,196,0.0000,0.0000,0.0000,0.0000,0.0000,'2023-06-30 11:40:20','2023-06-30 11:40:20',0.0000,NULL),
(517,199,0.0000,0.0000,0.0000,0.0000,0.0000,'2023-06-30 11:40:20','2023-06-30 11:40:20',0.0000,NULL),
(518,376,693.9100,693.9100,0.0000,0.0000,0.0000,'2023-06-30 11:40:20','2023-06-30 11:40:20',0.0000,NULL),
(519,404,752.6200,752.6200,0.0000,0.0000,0.0000,'2023-06-30 11:40:20','2023-06-30 11:40:20',0.0000,NULL),
(520,405,602.0900,602.0900,0.0000,0.0000,0.0000,'2023-06-30 11:40:20','2023-06-30 11:40:20',0.0000,NULL),
(521,406,670.6300,670.6300,0.0000,0.0000,0.0000,'2023-06-30 11:40:20','2023-06-30 11:40:20',0.0000,NULL),
(522,409,870.6300,870.6300,0.0000,0.0000,0.0000,'2023-06-30 11:40:20','2023-06-30 11:40:20',0.0000,NULL),
(523,211,405.3400,450.0000,0.0000,0.0000,0.0000,'2023-08-12 02:27:16','2023-12-28 04:46:33',0.0000,377.9390),
(524,212,433.2000,470.0000,470.0000,470.0000,0.0000,'2023-08-12 02:27:16','2023-11-15 12:14:48',0.0000,403.9157),
(525,1,0.0000,0.0000,0.0000,0.0000,0.0000,'2023-10-02 12:50:16','2023-11-15 12:13:53',0.0000,NULL),
(526,2,433.2000,450.0000,450.0000,450.0000,0.0000,'2023-10-02 12:50:17','2023-11-15 12:14:48',0.0000,NULL),
(527,213,400.0000,400.0000,400.0000,400.0000,0.0000,'2023-10-29 01:01:15','2023-11-15 12:18:35',0.0000,372.9600),
(528,214,305.0000,305.0000,0.0000,0.0000,0.0000,'2023-10-29 01:01:15','2023-11-13 11:47:18',0.0000,284.3820),
(529,215,365.0000,365.0000,0.0000,0.0000,0.0000,'2023-10-29 01:01:15','2023-10-30 05:27:59',0.0000,340.3260),
(530,3,300.0000,300.0000,300.0000,300.0000,0.0000,'2023-10-30 05:27:59','2023-11-15 12:18:35',0.0000,NULL),
(531,4,0.0000,0.0000,0.0000,0.0000,0.0000,'2023-10-30 05:27:59','2023-10-30 05:27:59',0.0000,NULL),
(532,5,0.0000,0.0000,0.0000,0.0000,0.0000,'2023-10-30 05:27:59','2023-10-30 05:27:59',0.0000,NULL);

/*Table structure for table `sku_price_histories` */

DROP TABLE IF EXISTS `sku_price_histories`;

CREATE TABLE `sku_price_histories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `sku_id` int unsigned NOT NULL,
  `unit_cost` double(15,4) NOT NULL,
  `price_1` double(15,4) DEFAULT NULL,
  `price_2` double(15,4) DEFAULT NULL,
  `price_3` double(15,4) DEFAULT NULL,
  `price_4` double(15,4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `price_5` double(15,4) DEFAULT NULL,
  `user_id` int unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sku_price_histories_sku_id_index` (`sku_id`),
  KEY `sku_price_histories_user_id_index` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=579 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `sku_price_histories` */

insert  into `sku_price_histories`(`id`,`sku_id`,`unit_cost`,`price_1`,`price_2`,`price_3`,`price_4`,`created_at`,`updated_at`,`price_5`,`user_id`) values 
(1,1270,630.6443,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(2,1271,865.6717,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(3,1272,630.6443,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(4,1273,865.6717,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(5,1274,1183.0162,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(6,1275,865.6717,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(7,1276,865.6717,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(8,1277,1061.3624,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(9,1278,1061.3624,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(10,1279,1061.3624,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(11,1280,802.1988,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(12,1281,802.1988,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(13,1282,1061.3624,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(14,1283,1061.3624,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(15,1284,1214.7477,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(16,1285,1214.7477,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(17,1286,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(18,1287,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(19,1288,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(20,1289,628.5315,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(21,1290,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(22,1291,823.3564,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(23,1292,632.9477,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(24,1293,1214.7477,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(25,1294,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(26,1295,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(27,1296,918.5608,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(28,1297,1214.7477,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(29,1298,1167.1505,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(30,1299,1167.1505,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(31,1300,1119.5433,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(32,1301,1119.5433,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(33,1302,1260.2321,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(34,1303,1260.2321,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(35,1304,1260.2321,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(36,1305,1119.5433,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(37,1306,1183.0162,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(38,1307,876.2455,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(39,1308,1204.1738,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(40,1309,1004.2476,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(41,1310,1004.2476,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(42,1311,1004.2476,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(43,1312,558.9010,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(44,1313,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(45,1314,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(46,1315,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(47,1316,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(48,1317,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(49,1318,975.6854,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(50,1319,558.9010,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(51,1320,1183.0162,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(52,1321,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(53,1322,951.1808,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(54,1323,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(55,1324,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(56,1325,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(57,1326,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(58,1327,337.6364,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(59,1328,337.6364,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(60,1329,337.6364,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(61,1330,337.6364,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(62,1331,337.6364,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(63,1332,337.6364,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(64,1333,369.6345,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(65,1334,369.6345,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(66,1335,337.6364,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(67,1336,1204.1738,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(68,1337,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(69,1338,1204.1738,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(70,1339,1183.0162,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(71,1340,1024.3390,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(72,1341,879.7702,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(73,1342,811.0153,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(74,1343,1251.7711,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(75,1344,995.2534,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(76,1345,995.2534,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(77,1346,995.2534,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(78,1347,1024.3390,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(79,1348,1024.3390,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(80,1349,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(81,1350,977.7982,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(82,1351,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(83,1352,911.5115,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(84,1353,1183.0162,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(85,1354,1167.1505,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(86,1355,1167.1505,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(87,1356,1167.1505,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(88,1357,1167.1505,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(89,1358,796.9168,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(90,1359,461.0476,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(91,1360,461.0476,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(92,1361,1167.1505,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(93,1362,461.0476,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(94,1363,1167.1505,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(95,1364,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(96,1365,678.7876,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(97,1366,705.2371,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(98,1367,705.2371,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(99,1368,1183.0162,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(100,1369,678.7876,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(101,1370,705.2371,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(102,1371,934.4265,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(103,1372,1183.0162,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(104,1373,796.9168,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(105,1374,796.9168,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(106,1375,796.9168,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(107,1376,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(108,1377,796.9168,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(109,1378,720.2241,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(110,1379,720.2241,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(111,1380,720.2241,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(112,1381,720.2241,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(113,1382,796.9168,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(114,1383,796.9168,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(115,1384,796.9168,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(116,1385,796.9168,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(117,1386,876.2455,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(118,1387,796.9168,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(119,1388,704.3584,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(120,1389,704.3584,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(121,1390,410.7946,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(122,1391,410.7946,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(123,1392,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(124,1393,410.7946,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(125,1394,802.1859,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(126,1395,802.1859,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(127,1396,652.3480,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(128,1397,652.3480,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(129,1398,550.0944,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(130,1399,352.6136,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(131,1400,522.7662,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(132,1401,833.9402,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(133,1402,675.2630,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(134,1403,675.2630,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(135,1404,684.0795,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(136,1405,590.6424,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(137,1406,590.6424,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(138,1407,467.2311,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(139,1408,467.2311,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(140,1409,1019.9227,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(141,1410,1019.9227,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(142,1411,421.2006,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(143,1412,421.2006,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(144,1413,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(145,1414,402.1558,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(146,1415,1183.0162,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(147,1416,676.1287,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(148,1417,590.6424,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(149,1418,995.2534,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(150,1419,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(151,1420,468.9756,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(152,1421,468.9756,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(153,1422,598.9128,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(154,1423,598.9128,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(155,1424,680.5548,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(156,1425,955.5841,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(157,1426,784.5757,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(158,1427,1003.1814,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(159,1643,833.9402,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(160,1645,833.9402,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(161,1647,369.6345,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(162,1649,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(163,1651,680.5548,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(164,1653,977.7982,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(165,1655,977.7982,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(166,1657,977.7982,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(167,1687,796.9168,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(168,1689,622.3738,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(169,1691,740.8486,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(170,1693,421.2006,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(171,1700,492.7921,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(172,1702,951.1808,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(173,1112,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(174,1113,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(175,1114,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(176,1115,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(177,1116,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(178,1117,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(179,1118,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(180,1119,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(181,1120,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(182,1121,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(183,1122,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(184,1123,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(185,1124,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(186,1125,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(187,1126,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(188,1127,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(189,1128,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(190,1129,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(191,1130,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(192,1131,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(193,1132,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(194,1133,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(195,1134,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(196,1135,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(197,1136,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(198,1137,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(199,1138,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(200,1139,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(201,1140,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(202,1141,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(203,1142,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(204,1143,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(205,1144,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(206,1145,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(207,1146,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(208,1147,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(209,1148,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(210,1149,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(211,1150,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(212,1151,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(213,1152,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(214,1153,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(215,1154,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(216,1155,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(217,1156,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(218,1157,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(219,1158,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(220,1159,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(221,1160,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(222,1161,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(223,1162,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(224,1163,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(225,1164,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(226,1165,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(227,1166,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(228,1167,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(229,1168,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(230,1169,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(231,1170,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(232,1171,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(233,1172,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(234,1173,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(235,1174,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(236,1175,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(237,1176,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(238,1177,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(239,1178,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(240,1179,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(241,1180,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(242,1181,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(243,1182,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(244,1183,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(245,1184,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(246,1185,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(247,1186,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(248,1187,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(249,1188,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(250,1189,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(251,1190,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(252,1191,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(253,1192,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(254,1193,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(255,1194,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(256,1195,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(257,1196,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(258,1197,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(259,1198,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(260,1199,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(261,1200,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(262,1201,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(263,1202,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(264,1203,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(265,1204,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(266,1205,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(267,1206,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(268,1207,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(269,1208,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(270,1209,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(271,1210,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(272,1211,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(273,1212,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(274,1213,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(275,1214,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(276,1215,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(277,1216,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(278,1217,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(279,1218,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(280,1219,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(281,1220,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(282,1221,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(283,1222,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(284,1223,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(285,1224,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(286,1225,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(287,1226,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(288,1227,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(289,1228,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(290,1229,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(291,1230,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(292,1231,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(293,1232,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(294,1233,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(295,1234,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(296,1235,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(297,1236,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(298,1237,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(299,1238,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(300,1239,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(301,1240,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(302,1241,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(303,1242,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(304,1243,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(305,1244,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(306,1245,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(307,1246,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(308,1247,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(309,1248,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(310,1249,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(311,1250,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(312,1251,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(313,1252,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(314,1253,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(315,1254,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(316,1255,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(317,1256,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(318,1257,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(319,1258,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(320,1259,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(321,1260,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(322,1261,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(323,1262,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(324,1263,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(325,1264,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(326,1265,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(327,1266,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(328,1267,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(329,1268,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(330,1269,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(331,1644,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(332,1646,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(333,1648,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(334,1650,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(335,1652,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(336,1654,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(337,1656,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(338,1658,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(339,1688,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(340,1690,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(341,1692,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(342,1694,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(343,1701,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(344,1703,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(345,956,9.0200,10.4500,10.6600,10.9800,10.7700,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(346,957,9.0200,10.4500,10.6600,10.9800,10.7700,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(347,958,9.0200,10.4500,10.6600,10.9800,10.7700,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(348,959,9.0200,10.4500,10.6600,10.9800,10.7700,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(349,960,9.0200,10.4500,10.6600,10.9800,10.7700,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(350,961,9.0200,10.4500,10.6600,10.9800,10.7700,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(351,962,9.0200,10.4500,10.6600,10.9800,10.7700,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(352,963,9.0200,10.4500,10.6600,10.9800,10.7700,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(353,964,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(354,965,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(355,966,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(356,967,8.7500,10.3900,10.6000,10.9100,10.7000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(357,968,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(358,969,71.2700,84.5900,86.2800,88.8200,87.1300,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(359,970,71.2700,84.5900,86.2800,88.8200,87.1300,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(360,971,71.2700,84.5900,86.2800,88.8200,87.1300,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(361,972,71.2700,84.5900,86.2800,88.8200,87.1300,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(362,973,18.8900,22.4200,22.8700,24.0400,23.1000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(363,974,18.8900,22.4200,22.8700,24.0400,23.1000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(364,975,18.8900,22.4200,22.8700,24.0400,23.1000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(365,976,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(366,977,71.2500,84.5900,86.2800,88.8200,87.1300,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(367,978,71.2500,84.5900,86.2800,88.8200,87.1300,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(368,979,71.2500,84.5900,86.2800,88.8200,87.1300,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(369,980,71.2500,84.5900,86.2800,88.8200,87.1300,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(370,981,16.0900,19.1100,19.4900,20.0600,19.6800,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(371,982,16.0900,19.1100,19.4900,20.0600,19.6800,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(372,983,17.7200,21.0400,21.4600,22.0900,21.6700,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(373,984,17.7200,21.0400,21.4600,22.0900,21.6700,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(374,985,17.5000,20.7800,21.2000,21.8300,21.4000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(375,986,17.5000,20.7800,21.2000,21.8300,21.4000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(376,987,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(377,988,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(378,989,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(379,990,75.0000,89.0400,90.8300,93.5000,91.7200,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(380,991,129.4700,153.7000,156.7800,161.3900,158.3100,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(381,992,21.1500,25.1100,25.6200,26.3700,25.8700,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(382,993,61.6100,73.1400,74.6100,76.8000,75.3400,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(383,994,75.9700,90.1900,92.0000,94.7000,92.9000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(384,995,135.3600,160.7000,163.9100,168.7300,165.5200,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(385,996,75.0000,89.0400,90.8300,93.5000,91.7200,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(386,997,58.0400,68.9000,70.2800,72.3500,70.9700,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(387,998,71.2500,84.5900,86.2800,88.8200,87.1300,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(388,999,129.4700,153.7000,156.7800,161.3900,158.3100,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(389,1000,71.2500,84.5900,86.2800,88.8200,87.1300,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(390,1001,70.3200,83.4800,85.1500,87.6500,85.9800,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(391,1002,129.4700,153.7000,156.7800,161.3900,158.3100,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(392,1003,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(393,1004,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(394,1005,70.3200,83.4800,85.1500,87.6500,85.9800,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(395,1006,58.0400,68.9000,70.2800,72.3500,70.9700,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(396,1007,43.7500,51.9400,52.9800,54.5400,53.5000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(397,1008,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(398,1009,58.0400,68.9000,70.2800,72.3500,70.9700,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(399,1010,43.7500,51.9400,52.9800,54.5400,53.5000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(400,1011,58.0400,68.9000,70.2800,72.3500,70.9700,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(401,1012,43.7500,51.9400,52.9800,54.5400,53.5000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(402,1013,33.3400,39.5800,40.3700,41.5600,40.7700,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(403,1014,41.0800,48.7600,49.7400,51.2000,50.2300,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(404,1015,5.6700,6.7400,6.8700,7.0700,6.9400,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(405,1016,92.8600,110.2400,112.4500,115.7600,113.5500,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(406,1017,72.3300,85.8600,87.5800,90.1600,88.4400,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(407,1018,72.3300,85.8600,87.5800,90.1600,88.4400,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(408,1019,76.7900,91.1600,92.9900,95.7200,93.9000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(409,1020,76.7900,91.1600,92.9900,95.7200,93.9000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(410,1021,76.7900,91.1600,92.9900,95.7200,93.9000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(411,1022,67.8600,80.5600,82.1800,84.5900,82.9800,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(412,1023,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(413,1024,72.3300,85.8600,87.5800,90.1600,88.4400,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(414,1025,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(415,1026,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(416,1027,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(417,1028,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(418,1029,14.9200,17.7100,18.0600,18.5900,18.2400,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(419,1030,14.9200,17.7100,18.0600,18.5900,18.2400,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(420,1031,71.2500,84.5900,86.2800,88.8200,87.1300,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(421,1032,16.2100,19.2400,19.6300,20.2100,19.8200,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(422,1033,29.7400,35.3000,36.0100,37.0700,36.3600,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(423,1034,180.3600,209.0000,213.1800,219.4500,215.2700,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(424,1035,180.3600,209.0000,213.1800,219.4500,215.2700,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(425,1036,180.3600,209.0000,213.1800,219.4500,215.2700,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(426,1037,180.3600,209.0000,213.1800,219.4500,215.2700,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(427,1038,180.3600,209.0000,213.1800,219.4500,215.2700,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(428,1039,180.3600,209.0000,213.1800,219.4500,215.2700,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(429,1040,180.3600,209.0000,213.1800,219.4500,215.2700,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(430,1041,180.3600,209.0000,213.1800,219.4500,215.2700,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(431,1042,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(432,1043,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(433,1044,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(434,1045,175.0000,207.7600,211.9200,218.1500,213.9900,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(435,1046,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(436,1047,356.3500,422.9400,431.4000,444.0900,435.6300,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(437,1048,356.3500,422.9400,431.4000,444.0900,435.6300,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(438,1049,356.3500,422.9400,431.4000,444.0900,435.6300,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(439,1050,356.3500,422.9400,431.4000,444.0900,435.6300,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(440,1051,377.6800,448.3800,457.3500,480.8000,461.8300,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(441,1052,377.6800,448.3800,457.3500,480.8000,461.8300,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(442,1053,377.6800,448.3800,457.3500,480.8000,461.8300,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(443,1054,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(444,1055,356.2500,422.9400,431.4000,444.0900,435.6300,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(445,1056,356.2500,422.9400,431.4000,444.0900,435.6300,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(446,1057,356.2500,422.9400,431.4000,444.0900,435.6300,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(447,1058,356.2500,422.9400,431.4000,444.0900,435.6300,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(448,1059,804.4600,955.0600,974.1600,1002.8100,983.7100,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(449,1060,804.4600,955.0600,974.1600,1002.8100,983.7100,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(450,1061,442.8600,525.7600,536.2800,552.0500,541.5300,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(451,1062,442.8600,525.7600,536.2800,552.0500,541.5300,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(452,1063,350.0000,415.5200,423.8300,436.6000,427.9900,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(453,1064,350.0000,415.5200,423.8300,436.6000,427.9900,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(454,1065,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(455,1066,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(456,1067,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(457,1068,900.0000,1068.4800,1089.8500,1121.9000,1100.5300,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(458,1069,517.8600,614.8000,627.1000,645.5400,633.2400,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(459,1070,676.7900,803.4800,819.5500,843.6500,827.5800,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(460,1071,308.0400,365.7000,373.0100,383.9900,376.6700,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(461,1072,911.6100,1082.2600,1103.9100,1136.3700,1114.7300,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(462,1073,676.7900,803.4800,819.5500,843.6500,827.5800,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(463,1074,900.0000,1068.4800,1089.8500,1121.9000,1100.5300,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(464,1075,290.1800,344.5000,351.3900,361.7300,354.8400,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(465,1076,356.2500,422.9400,431.4000,444.0900,435.6300,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(466,1077,517.8600,614.8000,627.1000,645.5400,633.2400,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(467,1078,356.2500,422.9400,431.4000,444.0900,435.6300,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(468,1079,843.7500,1001.7000,1021.7300,1051.7900,1031.7500,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(469,1080,517.8600,614.8000,627.1000,645.5400,633.2400,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(470,1081,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(471,1082,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(472,1083,843.7500,1001.7000,1021.7300,1051.7900,1031.7500,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(473,1084,696.4300,826.8000,843.3400,868.1400,851.6000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(474,1085,1050.0000,1246.5600,1271.4900,1308.8900,1283.9600,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(475,1086,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(476,1087,696.4300,826.8000,843.3400,868.1400,851.6000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(477,1088,1050.0000,1246.5600,1271.4900,1308.8900,1283.9600,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(478,1089,696.4300,826.8000,843.3400,868.1400,851.6000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(479,1090,1050.0000,1246.5600,1271.4900,1308.8900,1283.9600,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(480,1091,800.0000,949.7600,968.7600,997.2500,978.2500,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(481,1092,985.7100,1170.2400,1193.6400,1228.7500,1205.3500,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(482,1093,566.9600,673.1000,686.5600,706.7600,693.2900,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(483,1094,1485.7100,1763.8400,1799.1200,1852.0300,1816.7600,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(484,1095,1446.4300,1717.2000,1751.5400,1803.0600,1768.7200,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(485,1096,1446.4300,1717.2000,1751.5400,1803.0600,1768.7200,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(486,1097,1151.7900,1367.4000,1394.7500,1435.7700,1408.4200,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(487,1098,1151.7900,1367.4000,1394.7500,1435.7700,1408.4200,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(488,1099,1151.7900,1367.4000,1394.7500,1435.7700,1408.4200,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(489,1100,1357.1400,1611.2000,1643.4200,1691.7600,1659.5400,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(490,1101,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(491,1102,1446.4300,1717.2000,1751.5400,1803.0600,1768.7200,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(492,1103,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(493,1104,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(494,1105,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(495,1106,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(496,1107,298.2100,354.0400,361.1200,371.7400,364.6600,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(497,1108,298.2100,354.0400,361.1200,371.7400,364.6600,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(498,1109,356.2500,422.9400,431.4000,444.0900,435.6300,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(499,1110,162.0500,192.3900,196.2400,202.0100,198.1600,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(500,1111,297.3200,352.9800,360.0400,370.6300,363.5700,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(501,1633,676.7900,803.4800,819.5500,843.6500,827.5800,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(502,1634,67.6800,80.3500,81.9600,84.3700,82.7600,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(503,1635,499.1100,592.5400,604.3900,622.1700,610.3200,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(504,1636,124.7800,148.1400,151.1000,155.5400,152.5800,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(505,1637,499.1000,592.5400,604.3900,622.1700,610.3200,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(506,1638,124.7800,148.1400,151.1000,155.5500,152.5800,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(507,1639,475.0000,563.9200,575.2000,592.1200,580.8400,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(508,1640,118.7500,140.9800,143.8000,148.0300,145.2100,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(509,1641,475.0000,563.9200,575.2000,592.1200,580.8400,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(510,1642,118.7500,140.9800,143.8000,148.0300,145.2100,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(511,1695,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(512,1696,0.0000,0.0000,0.0000,0.0000,0.0000,'0000-00-00 00:00:00','0000-00-00 00:00:00',0.0000,NULL),
(513,1117,0.0000,0.0000,0.0000,0.0000,0.0000,'2023-06-30 11:37:31','2023-06-30 11:37:31',0.0000,1),
(514,1118,0.0000,0.0000,0.0000,0.0000,0.0000,'2023-06-30 11:37:32','2023-06-30 11:37:32',0.0000,1),
(515,1135,0.0000,0.0000,0.0000,0.0000,0.0000,'2023-06-30 11:37:32','2023-06-30 11:37:32',0.0000,1),
(516,1148,0.0000,0.0000,0.0000,0.0000,0.0000,'2023-06-30 11:37:32','2023-06-30 11:37:32',0.0000,1),
(517,1151,0.0000,0.0000,0.0000,0.0000,0.0000,'2023-06-30 11:37:32','2023-06-30 11:37:32',0.0000,1),
(518,1182,0.0000,0.0000,0.0000,0.0000,0.0000,'2023-06-30 11:37:32','2023-06-30 11:37:32',0.0000,1),
(519,1187,0.0000,0.0000,0.0000,0.0000,0.0000,'2023-06-30 11:37:32','2023-06-30 11:37:32',0.0000,1),
(520,1190,0.0000,0.0000,0.0000,0.0000,0.0000,'2023-06-30 11:37:32','2023-06-30 11:37:32',0.0000,1),
(521,1196,0.0000,0.0000,0.0000,0.0000,0.0000,'2023-06-30 11:37:32','2023-06-30 11:37:32',0.0000,1),
(522,1198,0.0000,0.0000,0.0000,0.0000,0.0000,'2023-06-30 11:37:32','2023-06-30 11:37:32',0.0000,1),
(523,1210,0.0000,0.0000,0.0000,0.0000,0.0000,'2023-06-30 11:37:32','2023-06-30 11:37:32',0.0000,1),
(524,1275,865.6717,0.0000,0.0000,0.0000,0.0000,'2023-06-30 11:37:32','2023-06-30 11:37:32',0.0000,1),
(525,1276,865.6717,0.0000,0.0000,0.0000,0.0000,'2023-06-30 11:37:32','2023-06-30 11:37:32',0.0000,1),
(526,1293,1214.7477,0.0000,0.0000,0.0000,0.0000,'2023-06-30 11:37:32','2023-06-30 11:37:32',0.0000,1),
(527,1306,1183.0162,0.0000,0.0000,0.0000,0.0000,'2023-06-30 11:37:32','2023-06-30 11:37:32',0.0000,1),
(528,1309,1004.2476,0.0000,0.0000,0.0000,0.0000,'2023-06-30 11:37:32','2023-06-30 11:37:32',0.0000,1),
(529,1340,1024.3390,0.0000,0.0000,0.0000,0.0000,'2023-06-30 11:37:32','2023-06-30 11:37:32',0.0000,1),
(530,1345,995.2534,0.0000,0.0000,0.0000,0.0000,'2023-06-30 11:37:32','2023-06-30 11:37:32',0.0000,1),
(531,1348,1024.3390,0.0000,0.0000,0.0000,0.0000,'2023-06-30 11:37:32','2023-06-30 11:37:32',0.0000,1),
(532,1354,1167.1505,0.0000,0.0000,0.0000,0.0000,'2023-06-30 11:37:32','2023-06-30 11:37:32',0.0000,1),
(533,1356,1167.1505,0.0000,0.0000,0.0000,0.0000,'2023-06-30 11:37:32','2023-06-30 11:37:32',0.0000,1),
(534,1368,1183.0162,0.0000,0.0000,0.0000,0.0000,'2023-06-30 11:37:32','2023-06-30 11:37:32',0.0000,1),
(535,1198,0.0000,0.0000,0.0000,0.0000,0.0000,'2023-06-30 11:38:41','2023-06-30 11:38:41',0.0000,1),
(536,1251,0.0000,0.0000,0.0000,0.0000,0.0000,'2023-06-30 11:38:41','2023-06-30 11:38:41',0.0000,1),
(537,1252,0.0000,0.0000,0.0000,0.0000,0.0000,'2023-06-30 11:38:41','2023-06-30 11:38:41',0.0000,1),
(538,1356,1167.1505,1077.3600,0.0000,0.0000,0.0000,'2023-06-30 11:38:41','2023-06-30 11:38:41',0.0000,1),
(539,1409,1019.9227,0.0000,0.0000,0.0000,0.0000,'2023-06-30 11:38:41','2023-06-30 11:38:41',0.0000,1),
(540,1410,1019.9227,0.0000,0.0000,0.0000,0.0000,'2023-06-30 11:38:41','2023-06-30 11:38:41',0.0000,1),
(541,1700,492.7921,0.0000,0.0000,0.0000,0.0000,'2023-06-30 11:38:41','2023-06-30 11:38:41',0.0000,1),
(542,1701,0.0000,0.0000,0.0000,0.0000,0.0000,'2023-06-30 11:38:41','2023-06-30 11:38:41',0.0000,1),
(543,166,0.0000,0.0000,0.0000,0.0000,0.0000,'2023-06-30 11:40:20','2023-06-30 11:40:20',0.0000,1),
(544,194,0.0000,0.0000,0.0000,0.0000,0.0000,'2023-06-30 11:40:20','2023-06-30 11:40:20',0.0000,1),
(545,195,0.0000,0.0000,0.0000,0.0000,0.0000,'2023-06-30 11:40:20','2023-06-30 11:40:20',0.0000,1),
(546,196,0.0000,0.0000,0.0000,0.0000,0.0000,'2023-06-30 11:40:20','2023-06-30 11:40:20',0.0000,1),
(547,199,0.0000,0.0000,0.0000,0.0000,0.0000,'2023-06-30 11:40:20','2023-06-30 11:40:20',0.0000,1),
(548,376,693.9100,693.9100,0.0000,0.0000,0.0000,'2023-06-30 11:40:20','2023-06-30 11:40:20',0.0000,1),
(549,404,752.6200,752.6200,0.0000,0.0000,0.0000,'2023-06-30 11:40:20','2023-06-30 11:40:20',0.0000,1),
(550,405,602.0900,602.0900,0.0000,0.0000,0.0000,'2023-06-30 11:40:20','2023-06-30 11:40:20',0.0000,1),
(551,406,670.6300,670.6300,0.0000,0.0000,0.0000,'2023-06-30 11:40:20','2023-06-30 11:40:20',0.0000,1),
(552,409,870.6300,870.6300,0.0000,0.0000,0.0000,'2023-06-30 11:40:20','2023-06-30 11:40:20',0.0000,1),
(553,1,0.0000,0.0000,0.0000,0.0000,0.0000,'2023-10-02 12:50:16','2023-10-02 12:50:16',0.0000,1),
(554,2,0.0000,0.0000,0.0000,0.0000,0.0000,'2023-10-02 12:50:17','2023-10-02 12:50:17',0.0000,1),
(555,211,405.3400,0.0000,0.0000,0.0000,0.0000,'2023-10-02 12:50:17','2023-10-02 12:50:17',0.0000,1),
(556,212,433.2000,0.0000,0.0000,0.0000,0.0000,'2023-10-02 12:50:17','2023-10-02 12:50:17',0.0000,1),
(557,1,0.0000,0.0000,0.0000,0.0000,0.0000,'2023-10-30 05:27:59','2023-10-30 05:27:59',0.0000,1),
(558,2,0.0000,0.0000,0.0000,0.0000,0.0000,'2023-10-30 05:27:59','2023-10-30 05:27:59',0.0000,1),
(559,3,0.0000,0.0000,0.0000,0.0000,0.0000,'2023-10-30 05:27:59','2023-10-30 05:27:59',0.0000,1),
(560,4,0.0000,0.0000,0.0000,0.0000,0.0000,'2023-10-30 05:27:59','2023-10-30 05:27:59',0.0000,1),
(561,5,0.0000,0.0000,0.0000,0.0000,0.0000,'2023-10-30 05:27:59','2023-10-30 05:27:59',0.0000,1),
(562,211,405.3400,450.0000,0.0000,0.0000,0.0000,'2023-10-30 05:27:59','2023-10-30 05:27:59',0.0000,1),
(563,212,433.2000,470.0000,0.0000,0.0000,0.0000,'2023-10-30 05:27:59','2023-10-30 05:27:59',0.0000,1),
(564,213,400.0000,400.0000,400.0000,400.0000,0.0000,'2023-10-30 05:27:59','2023-10-30 05:27:59',0.0000,1),
(565,214,305.0000,0.0000,0.0000,0.0000,0.0000,'2023-10-30 05:27:59','2023-10-30 05:27:59',0.0000,1),
(566,215,365.0000,0.0000,0.0000,0.0000,0.0000,'2023-10-30 05:27:59','2023-10-30 05:27:59',0.0000,1),
(567,2,0.0000,0.0000,0.0000,0.0000,0.0000,'2023-11-15 12:11:55','2023-11-15 12:11:55',0.0000,1),
(568,212,433.2000,470.0000,0.0000,0.0000,0.0000,'2023-11-15 12:11:55','2023-11-15 12:11:55',0.0000,1),
(569,1,0.0000,0.0000,0.0000,0.0000,0.0000,'2023-11-15 12:13:53','2023-11-15 12:13:53',0.0000,1),
(570,2,433.2000,450.0000,0.0000,0.0000,0.0000,'2023-11-15 12:13:53','2023-11-15 12:13:53',0.0000,1),
(571,211,405.3400,450.0000,0.0000,0.0000,0.0000,'2023-11-15 12:13:53','2023-11-15 12:13:53',0.0000,1),
(572,212,433.2000,470.0000,0.0000,0.0000,0.0000,'2023-11-15 12:13:53','2023-11-15 12:13:53',0.0000,1),
(573,2,433.2000,450.0000,0.0000,0.0000,0.0000,'2023-11-15 12:14:48','2023-11-15 12:14:48',0.0000,1),
(574,212,433.2000,470.0000,0.0000,0.0000,0.0000,'2023-11-15 12:14:48','2023-11-15 12:14:48',0.0000,1),
(575,3,0.0000,0.0000,0.0000,0.0000,0.0000,'2023-11-15 12:17:03','2023-11-15 12:17:03',0.0000,1),
(576,213,400.0000,400.0000,0.0000,0.0000,0.0000,'2023-11-15 12:17:03','2023-11-15 12:17:03',0.0000,1),
(577,3,0.0000,0.0000,0.0000,0.0000,0.0000,'2023-11-15 12:18:35','2023-11-15 12:18:35',0.0000,1),
(578,213,400.0000,400.0000,400.0000,400.0000,0.0000,'2023-11-15 12:18:35','2023-11-15 12:18:35',0.0000,1);

/*Table structure for table `sku_principals` */

DROP TABLE IF EXISTS `sku_principals`;

CREATE TABLE `sku_principals` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `principal` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact_number` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `sku_principals` */

insert  into `sku_principals`(`id`,`principal`,`contact_number`,`created_at`,`updated_at`) values 
(1,'None','09533844872',NULL,NULL),
(2,'GCI','09455946843','2020-05-12 17:07:59','2020-05-12 17:07:59'),
(3,'PFC','09455946843','2020-05-20 16:50:32','2020-05-20 16:50:32'),
(4,'EPI','09455946843','2020-05-21 21:06:50','2020-05-21 21:06:50'),
(5,'DOLE','09455946843','2020-06-02 17:01:25','2020-06-02 17:01:25'),
(6,'ALASKA','09455946843','2020-06-07 18:28:54','2020-06-07 18:28:54'),
(7,'CIFPI','09455946843','2020-06-14 16:50:09','2020-06-14 16:50:09'),
(8,'PPMC','09455946843','2020-06-17 20:51:13','2020-06-17 20:51:13'),
(10,'SUNPRIDE FOODS','09533844872','2022-01-04 18:53:18','2022-01-04 18:53:18');

/*Table structure for table `sku_sub_categories` */

DROP TABLE IF EXISTS `sku_sub_categories`;

CREATE TABLE `sku_sub_categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `main_category_id` int unsigned NOT NULL,
  `sub_category` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sku_sub_categories_main_category_id_index` (`main_category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `sku_sub_categories` */

/*Table structure for table `transaction_entries` */

DROP TABLE IF EXISTS `transaction_entries`;

CREATE TABLE `transaction_entries` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `description` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `account_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `account_number` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `transaction` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `transaction_entries` */

insert  into `transaction_entries`(`id`,`description`,`account_name`,`account_number`,`created_at`,`updated_at`,`transaction`) values 
(1,'PAYROLL','SALARIES AND WAGES\r\n','',NULL,NULL,'DEBIT'),
(2,'PAYROLL','DUE TO BIR - Withholding Tax Compensation','',NULL,NULL,'CREDIT'),
(3,'PAYROLL','DUE TO SSS - Contribution\r\n','',NULL,NULL,'CREDIT'),
(4,'PAYROLL','DUE TO SSS - Employees Loan\r\n','',NULL,NULL,'CREDIT'),
(5,'PAYROLL','DUE TO PAG-IBIG - Contribution\r\n','',NULL,NULL,'CREDIT'),
(6,'PAYROLL','DUE TO PAG-IBIG - Employees Loan\r\n','',NULL,NULL,'CREDIT'),
(7,'PAYROLL','DUE TO PHILHEALTH - Contribution\r\n','',NULL,NULL,'CREDIT'),
(8,'PAYROLL','VALE DUE FROM OFFICERS AND  EMPLOYEES \r\n','',NULL,NULL,'CREDIT'),
(9,'PAYROLL','OTHER RECEIVABLES - CHARGES EMPLOYEES\r\n','',NULL,NULL,'CREDIT'),
(10,'PAYROLL','DUE TO OFFICERS AND  EMPLOYEES - DEPOSIT\r\n','',NULL,NULL,'CREDIT'),
(12,'WATER UTILITIES','UTILITIES EXPENSE - WATER UTILITIES\r\n','',NULL,NULL,'DEBIT'),
(13,'ELECTRICITY','UTILITIES EXPENSE - ELECTRICITY\r\n','',NULL,NULL,'DEBIT'),
(14,'COMMUNICATION ALLOWANCE','COMMUNICATION EXPENSES\r\n','',NULL,NULL,'DEBIT');

/*Table structure for table `transfer_to_bran_details` */

DROP TABLE IF EXISTS `transfer_to_bran_details`;

CREATE TABLE `transfer_to_bran_details` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `transfer_id` bigint unsigned NOT NULL,
  `sku_id` int unsigned NOT NULL,
  `quantity` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `final_unit_cost` double(15,4) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `transfer_to_bran_details_transfer_id_index` (`transfer_id`),
  KEY `transfer_to_bran_details_sku_id_index` (`sku_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `transfer_to_bran_details` */

/*Table structure for table `transfer_to_branch_jers` */

DROP TABLE IF EXISTS `transfer_to_branch_jers`;

CREATE TABLE `transfer_to_branch_jers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `received_id` bigint unsigned NOT NULL,
  `principal_id` int unsigned NOT NULL,
  `inventory_into_branch` double(15,4) NOT NULL,
  `inventory_out_origin` double(15,4) NOT NULL,
  `branch_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `transfer_to_branch_jers_received_id_index` (`received_id`),
  KEY `transfer_to_branch_jers_principal_id_index` (`principal_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `transfer_to_branch_jers` */

/*Table structure for table `transfer_to_brans` */

DROP TABLE IF EXISTS `transfer_to_brans`;

CREATE TABLE `transfer_to_brans` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `received_id` bigint unsigned NOT NULL,
  `principal_id` int unsigned NOT NULL,
  `user_id` int unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `transfer_from` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `transfer_to` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_amount` double(15,4) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `transfer_to_brans_received_id_index` (`received_id`),
  KEY `transfer_to_brans_principal_id_index` (`principal_id`),
  KEY `transfer_to_brans_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `transfer_to_brans` */

/*Table structure for table `truck_and_sales_invoice_details` */

DROP TABLE IF EXISTS `truck_and_sales_invoice_details`;

CREATE TABLE `truck_and_sales_invoice_details` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `truck_si_id` bigint unsigned NOT NULL,
  `sales_invoice_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `truck_and_sales_invoice_details_truck_si_id_index` (`truck_si_id`),
  KEY `truck_and_sales_invoice_details_sales_invoice_id_index` (`sales_invoice_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `truck_and_sales_invoice_details` */

/*Table structure for table `truck_and_sales_invoices` */

DROP TABLE IF EXISTS `truck_and_sales_invoices`;

CREATE TABLE `truck_and_sales_invoices` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `truck_id` bigint unsigned NOT NULL,
  `driver` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `assistant` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `departure_date` date DEFAULT NULL,
  `departure_time` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `arrival_date` date DEFAULT NULL,
  `arrival_time` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `truck_and_sales_invoices_truck_id_index` (`truck_id`),
  KEY `truck_and_sales_invoices_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `truck_and_sales_invoices` */

/*Table structure for table `trucks` */

DROP TABLE IF EXISTS `trucks`;

CREATE TABLE `trucks` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `plate_no` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `capacity` double(15,4) NOT NULL,
  `model` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `trucks` */

insert  into `trucks`(`id`,`plate_no`,`capacity`,`model`,`created_at`,`updated_at`,`status`) values 
(1,'12345678',100.0000,'model','2024-01-31 08:09:35','2024-01-31 08:09:35','');

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `position` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `secret_key` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `principal_id` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `users` */

insert  into `users`(`id`,`name`,`email`,`email_verified_at`,`position`,`secret_key`,`password`,`remember_token`,`created_at`,`updated_at`,`principal_id`) values 
(1,'Sidney Salazar','admin@gmail.com',NULL,'admin',NULL,'$2y$10$9xwSJ/ok.HcgU37NIEqtLeoylJTlkMFIczqbFyUuxOqceR/JVMpKW',NULL,'2023-02-10 05:57:38','2023-02-10 05:57:38','all'),
(2,'Geraldine Sajulan','sajulangeraldine@gmail.com',NULL,'admin',NULL,'$2y$10$yRE7JgsWsLw7TP8nKKO5deqj7JpjTp.dXqTw6iSY5Dg3/DoORX.22',NULL,'2023-02-17 17:12:41','2023-02-17 17:12:41','all'),
(3,'ARLYN FUENTES','fuentes_arlyn@yahoo.com',NULL,'warehouse',NULL,'$2y$10$XfDezXxhZNz6N9aV7Fy2zOlRxzj2MQIslP2C03oj9mJajk0FQVwRu',NULL,'2023-03-10 17:20:17','2023-03-10 17:20:17','7'),
(4,'welen','welen@gmail.com',NULL,'warehouse',NULL,'$2y$10$QJZeFQ/V8mK7P54hVHdT5.ybOG6SVsLzsQ5IsLXy72z09O6XEMgP6',NULL,'2023-06-08 03:33:03','2023-06-08 03:33:03','2');

/*Table structure for table `van_selling_adjustments` */

DROP TABLE IF EXISTS `van_selling_adjustments`;

CREATE TABLE `van_selling_adjustments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `van_selling_printed_id` bigint unsigned NOT NULL,
  `customer_id` bigint unsigned NOT NULL,
  `user_id` int unsigned NOT NULL,
  `approved_by` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `remarks` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `van_selling_adjustments_van_selling_printed_id_index` (`van_selling_printed_id`),
  KEY `van_selling_adjustments_customer_id_index` (`customer_id`),
  KEY `van_selling_adjustments_user_id_index` (`user_id`),
  KEY `van_selling_adjustments_date_index` (`date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `van_selling_adjustments` */

/*Table structure for table `van_selling_adjustments_details` */

DROP TABLE IF EXISTS `van_selling_adjustments_details`;

CREATE TABLE `van_selling_adjustments_details` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `vs_adjustments_id` bigint unsigned NOT NULL,
  `sku_id` int unsigned NOT NULL,
  `original_quantity` int NOT NULL,
  `adjusted_quantity` int NOT NULL,
  `price` double(15,4) NOT NULL,
  `remarks` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `van_selling_adjustments_details_vs_adjustments_id_index` (`vs_adjustments_id`),
  KEY `van_selling_adjustments_details_sku_id_index` (`sku_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `van_selling_adjustments_details` */

/*Table structure for table `van_selling_ar_ledgers` */

DROP TABLE IF EXISTS `van_selling_ar_ledgers`;

CREATE TABLE `van_selling_ar_ledgers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` bigint unsigned NOT NULL,
  `user_id` int unsigned NOT NULL,
  `principal_id` int unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `transaction` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `all_id` bigint DEFAULT NULL,
  `running_balance` double(15,4) DEFAULT NULL,
  `amount` double(15,4) DEFAULT NULL,
  `short` double(15,4) DEFAULT NULL,
  `outstanding_balance` double(15,4) DEFAULT NULL,
  `remarks` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `van_selling_ar_ledgers_customer_id_index` (`customer_id`),
  KEY `van_selling_ar_ledgers_user_id_index` (`user_id`),
  KEY `van_selling_ar_ledgers_principal_id_index` (`principal_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `van_selling_ar_ledgers` */

/*Table structure for table `van_selling_beginnings` */

DROP TABLE IF EXISTS `van_selling_beginnings`;

CREATE TABLE `van_selling_beginnings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` bigint unsigned NOT NULL,
  `date` date NOT NULL,
  `user_id` int unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `van_selling_beginnings_customer_id_index` (`customer_id`),
  KEY `van_selling_beginnings_date_index` (`date`),
  KEY `van_selling_beginnings_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `van_selling_beginnings` */

/*Table structure for table `van_selling_calls` */

DROP TABLE IF EXISTS `van_selling_calls`;

CREATE TABLE `van_selling_calls` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` int NOT NULL,
  `store_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remarks` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `van_selling_calls` */

/*Table structure for table `van_selling_customers` */

DROP TABLE IF EXISTS `van_selling_customers`;

CREATE TABLE `van_selling_customers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `location_id` bigint unsigned NOT NULL,
  `store_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `store_type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `barangay` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact_person` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact_number` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `latitude` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `longitude` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `location_details_id` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `van_selling_customers_location_id_index` (`location_id`),
  KEY `van_selling_customers_location_details_id_index` (`location_details_id`),
  CONSTRAINT `van_selling_customers_location_details_id_foreign` FOREIGN KEY (`location_details_id`) REFERENCES `location_details` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `van_selling_customers` */

insert  into `van_selling_customers`(`id`,`location_id`,`store_name`,`store_type`,`barangay`,`address`,`contact_person`,`contact_number`,`latitude`,`longitude`,`created_at`,`updated_at`,`location_details_id`) values 
(1,1,'Gerald','SSS','Kauswagan','Zone 1','GERALD','none','8.493255117','124.6321084','2023-04-19 18:51:34','2023-04-19 18:51:34',NULL),
(2,1,'Mary','SSS','Kauswagan','Zone 1','MARY','9256844321','8.499274428','124.6290324','2023-04-19 18:51:34','2023-04-19 18:51:34',NULL),
(3,1,'Jay','SSS','Kauswagan','Zone 1','JAY','none','8.499865706','124.6288798','2023-04-19 18:51:34','2023-04-19 18:51:34',NULL);

/*Table structure for table `van_selling_inventory_adjustments` */

DROP TABLE IF EXISTS `van_selling_inventory_adjustments`;

CREATE TABLE `van_selling_inventory_adjustments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int unsigned NOT NULL,
  `customer_id` bigint unsigned NOT NULL,
  `total_amount` double(15,4) NOT NULL,
  `date` date NOT NULL,
  `remarks` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `van_selling_inventory_adjustments_user_id_index` (`user_id`),
  KEY `van_selling_inventory_adjustments_customer_id_index` (`customer_id`),
  KEY `van_selling_inventory_adjustments_date_index` (`date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `van_selling_inventory_adjustments` */

/*Table structure for table `van_selling_inventory_adjustments_details` */

DROP TABLE IF EXISTS `van_selling_inventory_adjustments_details`;

CREATE TABLE `van_selling_inventory_adjustments_details` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `vs_inv_adj_id` bigint unsigned NOT NULL,
  `sku_code` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `beg` int NOT NULL,
  `total_van_load` int NOT NULL,
  `total_sales` int NOT NULL,
  `total_adjustments` int NOT NULL,
  `pcm` int NOT NULL,
  `end` int NOT NULL,
  `inventory_adjustments` int NOT NULL,
  `actual_stocks_on_hand` int NOT NULL,
  `unit_price` double(15,4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `remarks` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `van_selling_inventory_adjustments_details_vs_inv_adj_id_index` (`vs_inv_adj_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `van_selling_inventory_adjustments_details` */

/*Table structure for table `van_selling_inventory_clearings` */

DROP TABLE IF EXISTS `van_selling_inventory_clearings`;

CREATE TABLE `van_selling_inventory_clearings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` bigint unsigned NOT NULL,
  `vs_ar_ending_balance` double(15,4) NOT NULL,
  `vs_inventory_running_balance` double(15,4) NOT NULL,
  `adjustments` double(15,4) NOT NULL,
  `total_adjustments` double(15,4) NOT NULL,
  `date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `van_selling_inventory_clearings_customer_id_index` (`customer_id`),
  KEY `van_selling_inventory_clearings_date_index` (`date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `van_selling_inventory_clearings` */

/*Table structure for table `van_selling_ledger_models` */

DROP TABLE IF EXISTS `van_selling_ledger_models`;

CREATE TABLE `van_selling_ledger_models` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `principal_id` int unsigned NOT NULL,
  `category_id` int unsigned NOT NULL,
  `sku_type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `transaction` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sold_to` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` int NOT NULL,
  `sold` int NOT NULL,
  `running_balance` int NOT NULL,
  `price` double(15,4) NOT NULL,
  `amount` double(15,4) NOT NULL,
  `sales` double(15,4) NOT NULL,
  `accounts_payable` double(15,4) NOT NULL,
  `user_id` int unsigned NOT NULL,
  `date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `van_selling_ledger_models_principal_id_index` (`principal_id`),
  KEY `van_selling_ledger_models_category_id_index` (`category_id`),
  KEY `van_selling_ledger_models_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `van_selling_ledger_models` */

/*Table structure for table `van_selling_os_datas` */

DROP TABLE IF EXISTS `van_selling_os_datas`;

CREATE TABLE `van_selling_os_datas` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `store_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sku_code` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` int NOT NULL,
  `os_unit_price` double(15,4) NOT NULL,
  `os_sub_total` double(15,4) NOT NULL,
  `os_date` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `served_quantity` int DEFAULT NULL,
  `served_unit_price` double(15,4) DEFAULT NULL,
  `served_sub_total` double(15,4) DEFAULT NULL,
  `served_date` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `principal` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `os_code` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `customer_id` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `van_selling_os_datas` */

/*Table structure for table `van_selling_payment_details` */

DROP TABLE IF EXISTS `van_selling_payment_details`;

CREATE TABLE `van_selling_payment_details` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `van_selling_payment_id` bigint unsigned NOT NULL,
  `van_selling_printed_id` bigint unsigned NOT NULL,
  `amount` double(15,4) NOT NULL,
  `balance` double(15,4) NOT NULL,
  `remarks` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `van_selling_payment_details_van_selling_payment_id_index` (`van_selling_payment_id`),
  KEY `van_selling_payment_details_van_selling_printed_id_index` (`van_selling_printed_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `van_selling_payment_details` */

/*Table structure for table `van_selling_payments` */

DROP TABLE IF EXISTS `van_selling_payments`;

CREATE TABLE `van_selling_payments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` bigint unsigned NOT NULL,
  `cash_cheque` double(15,4) NOT NULL,
  `bank_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `cheque_number` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `cheque_date` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remitted_by` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int unsigned NOT NULL,
  `date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `van_selling_payments_customer_id_index` (`customer_id`),
  KEY `van_selling_payments_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `van_selling_payments` */

/*Table structure for table `van_selling_price_difference_details` */

DROP TABLE IF EXISTS `van_selling_price_difference_details`;

CREATE TABLE `van_selling_price_difference_details` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `vs_price_diff_id` bigint unsigned NOT NULL,
  `sku_id` int unsigned NOT NULL,
  `total_quantity` int NOT NULL,
  `price` double(15,4) NOT NULL,
  `price_update` double(15,4) NOT NULL,
  `difference` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `van_selling_price_difference_details_vs_price_diff_id_index` (`vs_price_diff_id`),
  KEY `van_selling_price_difference_details_sku_id_index` (`sku_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `van_selling_price_difference_details` */

/*Table structure for table `van_selling_price_differences` */

DROP TABLE IF EXISTS `van_selling_price_differences`;

CREATE TABLE `van_selling_price_differences` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `van_selling_printed_id` bigint unsigned NOT NULL,
  `user_id` int unsigned NOT NULL,
  `principal_id` int unsigned NOT NULL,
  `total_price_difference` double(15,4) NOT NULL,
  `date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `van_selling_price_differences_van_selling_printed_id_index` (`van_selling_printed_id`),
  KEY `van_selling_price_differences_user_id_index` (`user_id`),
  KEY `van_selling_price_differences_principal_id_index` (`principal_id`),
  KEY `van_selling_price_differences_date_index` (`date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `van_selling_price_differences` */

/*Table structure for table `van_selling_printed_details` */

DROP TABLE IF EXISTS `van_selling_printed_details`;

CREATE TABLE `van_selling_printed_details` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `van_selling_printed_id` bigint unsigned NOT NULL,
  `customer_id` bigint unsigned NOT NULL,
  `sales_order_number` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sku_id` int unsigned NOT NULL,
  `quantity` int NOT NULL,
  `butal_quantity` int NOT NULL,
  `amount_per_sku` double(15,4) NOT NULL,
  `remarks` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `price` double(15,4) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `van_selling_printed_details_van_selling_printed_id_index` (`van_selling_printed_id`),
  KEY `van_selling_printed_details_customer_id_index` (`customer_id`),
  KEY `van_selling_printed_details_sku_id_index` (`sku_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `van_selling_printed_details` */

/*Table structure for table `van_selling_printeds` */

DROP TABLE IF EXISTS `van_selling_printeds`;

CREATE TABLE `van_selling_printeds` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` bigint unsigned NOT NULL,
  `principal_id` int unsigned NOT NULL,
  `sales_order_number` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `mode_of_transaction` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `delivery_receipt` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `price_level` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remarks` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `date_paid_or_cancelled` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_amount` double(15,4) NOT NULL,
  `sku_type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `van_selling_printeds_customer_id_index` (`customer_id`),
  KEY `van_selling_printeds_principal_id_index` (`principal_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `van_selling_printeds` */

/*Table structure for table `van_selling_sales` */

DROP TABLE IF EXISTS `van_selling_sales`;

CREATE TABLE `van_selling_sales` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `vs_upload_id` bigint unsigned NOT NULL,
  `customer_id` bigint unsigned NOT NULL,
  `principal` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sku_code` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `unit_of_measurement` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sku_type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `butal_equivalent` int NOT NULL,
  `reference` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `store_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sales` int NOT NULL,
  `unit_price` double(15,4) NOT NULL,
  `total` double(15,4) NOT NULL,
  `date` date NOT NULL,
  `date_sold` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `van_selling_sales_vs_upload_id_index` (`vs_upload_id`),
  KEY `van_selling_sales_customer_id_index` (`customer_id`),
  KEY `van_selling_sales_date_sold_index` (`date_sold`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `van_selling_sales` */

/*Table structure for table `van_selling_transfer_inventories` */

DROP TABLE IF EXISTS `van_selling_transfer_inventories`;

CREATE TABLE `van_selling_transfer_inventories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` bigint unsigned NOT NULL,
  `transfered_amount` double NOT NULL,
  `user_id` int unsigned NOT NULL,
  `status` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `van_selling_transfer_inventories_customer_id_index` (`customer_id`),
  KEY `van_selling_transfer_inventories_user_id_index` (`user_id`),
  KEY `van_selling_transfer_inventories_date_index` (`date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `van_selling_transfer_inventories` */

/*Table structure for table `van_selling_transfer_inventory_details` */

DROP TABLE IF EXISTS `van_selling_transfer_inventory_details`;

CREATE TABLE `van_selling_transfer_inventory_details` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `vs_transfer_id` bigint unsigned NOT NULL,
  `sku_code` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `principal` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `unit_of_measurement` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` int NOT NULL,
  `unit_price` double(15,4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `sku_type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `butal_equivalent` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `van_selling_transfer_inventory_details_vs_transfer_id_index` (`vs_transfer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `van_selling_transfer_inventory_details` */

/*Table structure for table `van_selling_upload_ledgers` */

DROP TABLE IF EXISTS `van_selling_upload_ledgers`;

CREATE TABLE `van_selling_upload_ledgers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `van_selling_printed_id` bigint unsigned NOT NULL,
  `customer_id` bigint unsigned NOT NULL,
  `principal` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sku_code` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `unit_of_measurement` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sku_type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `butal_equivalent` int NOT NULL,
  `reference` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `beg` int NOT NULL,
  `van_load` int NOT NULL,
  `sales` int NOT NULL,
  `end` int NOT NULL,
  `unit_price` double(15,4) NOT NULL,
  `total` double(15,4) NOT NULL,
  `running_balance` double(15,4) NOT NULL,
  `date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `van_selling_upload_ledgers_van_selling_printed_id_index` (`van_selling_printed_id`),
  KEY `van_selling_upload_ledgers_customer_id_index` (`customer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `van_selling_upload_ledgers` */

/*Table structure for table `van_selling_uploads` */

DROP TABLE IF EXISTS `van_selling_uploads`;

CREATE TABLE `van_selling_uploads` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `van_selling_export_code` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_id` bigint unsigned NOT NULL,
  `date` date NOT NULL,
  `date_range` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `van_selling_uploads_customer_id_index` (`customer_id`),
  KEY `van_selling_uploads_date_index` (`date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `van_selling_uploads` */

/*Table structure for table `vs_collections` */

DROP TABLE IF EXISTS `vs_collections`;

CREATE TABLE `vs_collections` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int unsigned DEFAULT NULL,
  `customer_id` bigint unsigned DEFAULT NULL,
  `total_amount` double(15,4) NOT NULL,
  `bank` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `reference` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remarks` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `vs_collections_user_id_index` (`user_id`),
  KEY `vs_collections_customer_id_index` (`customer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `vs_collections` */

/*Table structure for table `vs_inventory_adjustments` */

DROP TABLE IF EXISTS `vs_inventory_adjustments`;

CREATE TABLE `vs_inventory_adjustments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int unsigned DEFAULT NULL,
  `customer_id` bigint unsigned DEFAULT NULL,
  `total_amount` double(15,4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `vs_inventory_adjustments_user_id_index` (`user_id`),
  KEY `vs_inventory_adjustments_customer_id_index` (`customer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `vs_inventory_adjustments` */

/*Table structure for table `vs_inventory_ledgers` */

DROP TABLE IF EXISTS `vs_inventory_ledgers`;

CREATE TABLE `vs_inventory_ledgers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int unsigned DEFAULT NULL,
  `principal_id` int unsigned DEFAULT NULL,
  `customer_id` bigint unsigned DEFAULT NULL,
  `transaction` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sku_id` int unsigned NOT NULL,
  `beginning_inventory` int NOT NULL,
  `quantity` int NOT NULL,
  `ending_inventory` int NOT NULL,
  `unit_price` double(15,4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `all_id` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sku_code` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `vs_inventory_ledgers_user_id_index` (`user_id`),
  KEY `vs_inventory_ledgers_principal_id_index` (`principal_id`),
  KEY `vs_inventory_ledgers_customer_id_index` (`customer_id`),
  KEY `vs_inventory_ledgers_sku_id_index` (`sku_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `vs_inventory_ledgers` */

/*Table structure for table `vs_os_datas` */

DROP TABLE IF EXISTS `vs_os_datas`;

CREATE TABLE `vs_os_datas` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `export_code` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int unsigned DEFAULT NULL,
  `customer_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `vs_os_datas_user_id_index` (`user_id`),
  KEY `vs_os_datas_customer_id_index` (`customer_id`),
  CONSTRAINT `vs_os_datas_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`),
  CONSTRAINT `vs_os_datas_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `vs_os_datas` */

/*Table structure for table `vs_os_details` */

DROP TABLE IF EXISTS `vs_os_details`;

CREATE TABLE `vs_os_details` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `vs_os_id` bigint unsigned DEFAULT NULL,
  `sku_id` int unsigned NOT NULL,
  `store_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `date` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `unit_price` double(15,4) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `vs_os_details_vs_os_id_index` (`vs_os_id`),
  KEY `vs_os_details_sku_id_index` (`sku_id`),
  CONSTRAINT `vs_os_details_sku_id_foreign` FOREIGN KEY (`sku_id`) REFERENCES `sku_adds` (`id`),
  CONSTRAINT `vs_os_details_vs_os_id_foreign` FOREIGN KEY (`vs_os_id`) REFERENCES `vs_os_datas` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `vs_os_details` */

/*Table structure for table `vs_pcm_details` */

DROP TABLE IF EXISTS `vs_pcm_details`;

CREATE TABLE `vs_pcm_details` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `vs_pcm_id` bigint unsigned DEFAULT NULL,
  `sku_id` int unsigned NOT NULL,
  `quantity` int NOT NULL,
  `unit_price` double(15,4) DEFAULT NULL,
  `remarks` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `vs_pcm_details_vs_pcm_id_index` (`vs_pcm_id`),
  KEY `vs_pcm_details_sku_id_index` (`sku_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `vs_pcm_details` */

/*Table structure for table `vs_pcms` */

DROP TABLE IF EXISTS `vs_pcms`;

CREATE TABLE `vs_pcms` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int unsigned DEFAULT NULL,
  `customer_id` bigint unsigned DEFAULT NULL,
  `principal_id` int unsigned DEFAULT NULL,
  `total_amount` double(15,4) NOT NULL,
  `reference` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `pcm_type` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `store_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remitted_by` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `posted_by` int unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `vs_pcms_user_id_index` (`user_id`),
  KEY `vs_pcms_customer_id_index` (`customer_id`),
  KEY `vs_pcms_principal_id_index` (`principal_id`),
  KEY `vs_pcms_posted_by_index` (`posted_by`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `vs_pcms` */

/*Table structure for table `vs_sales` */

DROP TABLE IF EXISTS `vs_sales`;

CREATE TABLE `vs_sales` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int unsigned DEFAULT NULL,
  `principal_id` int unsigned DEFAULT NULL,
  `customer_id` bigint unsigned DEFAULT NULL,
  `customer_store_name` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `reference` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sku_id` int unsigned NOT NULL,
  `quantity` int NOT NULL,
  `unit_price` double(15,4) NOT NULL,
  `area` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `location` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_sold` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `vs_sales_user_id_index` (`user_id`),
  KEY `vs_sales_principal_id_index` (`principal_id`),
  KEY `vs_sales_customer_id_index` (`customer_id`),
  KEY `vs_sales_sku_id_index` (`sku_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `vs_sales` */

/*Table structure for table `vs_withdrawal_details` */

DROP TABLE IF EXISTS `vs_withdrawal_details`;

CREATE TABLE `vs_withdrawal_details` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `vs_withdrawal_id` bigint unsigned NOT NULL,
  `sku_id` int unsigned NOT NULL,
  `quantity` int NOT NULL,
  `unit_price` double(15,4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `sku_type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sku_code` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remarks` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `vs_withdrawal_details_vs_withdrawal_id_index` (`vs_withdrawal_id`),
  KEY `vs_withdrawal_details_sku_id_index` (`sku_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `vs_withdrawal_details` */

/*Table structure for table `vs_withdrawals` */

DROP TABLE IF EXISTS `vs_withdrawals`;

CREATE TABLE `vs_withdrawals` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int unsigned DEFAULT NULL,
  `principal_id` int unsigned DEFAULT NULL,
  `customer_id` bigint unsigned DEFAULT NULL,
  `total_amount` double(15,4) NOT NULL,
  `delivery_receipt` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `vs_withdrawals_user_id_index` (`user_id`),
  KEY `vs_withdrawals_principal_id_index` (`principal_id`),
  KEY `vs_withdrawals_customer_id_index` (`customer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `vs_withdrawals` */

/*Table structure for table `warehouse_out_details` */

DROP TABLE IF EXISTS `warehouse_out_details`;

CREATE TABLE `warehouse_out_details` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `warehouse_out_id` bigint unsigned DEFAULT NULL,
  `sku_id` int unsigned DEFAULT NULL,
  `quantity` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `warehouse_out_details_warehouse_out_id_index` (`warehouse_out_id`),
  KEY `warehouse_out_details_sku_id_index` (`sku_id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `warehouse_out_details` */

insert  into `warehouse_out_details`(`id`,`warehouse_out_id`,`sku_id`,`quantity`,`created_at`,`updated_at`) values 
(8,2,214,5,'2024-02-05 16:43:22','2024-02-05 16:43:22'),
(7,2,213,5,'2024-02-05 16:43:22','2024-02-05 16:43:22'),
(6,2,212,5,'2024-02-05 16:43:22','2024-02-05 16:43:22'),
(5,2,211,5,'2024-02-05 16:43:22','2024-02-05 16:43:22');

/*Table structure for table `warehouse_outs` */

DROP TABLE IF EXISTS `warehouse_outs`;

CREATE TABLE `warehouse_outs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `principal_id` int unsigned DEFAULT NULL,
  `user_id` int unsigned DEFAULT NULL,
  `sales_invoice_id` int unsigned DEFAULT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `warehouse_outs_principal_id_index` (`principal_id`),
  KEY `warehouse_outs_user_id_index` (`user_id`),
  KEY `warehouse_outs_sales_invoice_id_index` (`sales_invoice_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `warehouse_outs` */

insert  into `warehouse_outs`(`id`,`principal_id`,`user_id`,`sales_invoice_id`,`status`,`created_at`,`updated_at`) values 
(2,2,1,2,'out','2024-02-05 16:43:22','2024-02-05 16:43:22');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
