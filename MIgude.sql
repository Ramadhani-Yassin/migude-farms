-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Sep 12, 2025 at 04:21 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `migude`
--

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` decimal(20,8) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `created_at`, `updated_at`) VALUES
(27, 'Fresh Milk', '2025-09-11 04:41:23', '2025-09-12 10:15:53'),
(28, 'Fermented Products', '2025-09-11 04:41:23', '2025-09-12 10:16:16');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `name`, `email`, `phone`, `address`, `photo`, `created_at`, `updated_at`) VALUES
(1, 'Ramah Yasyn', 'yasynramah@gmail.com', '0621060107', 'Tanzania', 'cafe-maruujpg-17574405298429.jpg', '2025-09-10 00:55:29', '2025-09-10 00:55:29');

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `designation` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `salary` decimal(20,8) NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `nid` varchar(255) DEFAULT NULL,
  `joining_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `amount` decimal(20,8) NOT NULL,
  `expense_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `expenses`
--

INSERT INTO `expenses` (`id`, `name`, `description`, `amount`, `expense_date`, `created_at`, `updated_at`) VALUES
(14, 'Packaging Cost - Order O-odCys', 'Auto expense for packaging cost per unit sold', 2000.00000000, '2025-09-12', '2025-09-12 03:10:18', '2025-09-12 03:10:18'),
(15, 'mafuta', NULL, 20000.00000000, '2025-09-20', '2025-09-12 03:42:19', '2025-09-12 03:42:19'),
(18, 'Packaging Cost - Order O-XihV4', 'Auto expense for packaging cost per unit sold', 2500.00000000, '2025-09-12', '2025-09-12 04:58:12', '2025-09-12 04:58:12'),
(19, 'Milk Batch 5555UV Expenses', 'Auto-recorded expenses for milk batch #5555UV', 55000.00000000, '2025-09-20', '2025-09-12 06:36:24', '2025-09-12 06:36:24'),
(20, 'Banner', NULL, 500.00000000, '2025-09-12', '2025-09-12 06:40:01', '2025-09-12 06:40:01'),
(21, 'Packaging Cost - Order O-Oltxy', 'Auto expense for packaging cost per unit sold', 1000.00000000, '2025-09-12', '2025-09-12 06:40:39', '2025-09-12 06:40:39'),
(22, 'Milk Batch 55556hg Expenses', 'Auto-recorded expenses for milk batch #55556hg', 5000.00000000, '2025-09-13', '2025-09-12 10:06:14', '2025-09-12 10:06:14'),
(23, 'Milk Batch 555PTTZ Expenses', 'Auto-recorded expenses for milk batch #555PTTZ', 6000.00000000, '2025-09-13', '2025-09-12 10:17:44', '2025-09-12 10:17:44'),
(24, 'Packaging Cost - Order O-1tCQw', 'Auto expense for packaging cost per unit sold', 2000.00000000, '2025-09-12', '2025-09-12 10:19:55', '2025-09-12 10:19:55'),
(25, 'Banner', NULL, 5000.00000000, '2025-09-12', '2025-09-12 10:20:34', '2025-09-12 10:20:34'),
(26, 'Packaging Cost - Order O-GM7ZW', 'Auto expense for packaging cost per unit sold', 1000.00000000, '2025-09-12', '2025-09-12 10:20:58', '2025-09-12 10:20:58');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_00_000000_create_settings_table', 1),
(2, '2014_10_00_000001_add_group_column_on_settings_table', 1),
(3, '2014_10_12_000000_create_users_table', 1),
(4, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(5, '2019_08_19_000000_create_failed_jobs_table', 1),
(6, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(7, '2024_06_26_020636_create_categories_table', 1),
(8, '2024_07_12_094131_create_suppliers_table', 1),
(9, '2024_07_17_094527_create_unit_types_table', 1),
(10, '2024_07_18_094528_create_products_table', 1),
(11, '2024_07_21_014022_create_expenses_table', 1),
(12, '2024_07_21_075714_create_employees_table', 1),
(13, '2024_07_21_112837_create_customers_table', 1),
(14, '2024_07_22_103204_create_salaries_table', 1),
(15, '2024_09_05_013146_create_carts_table', 1),
(16, '2024_09_13_101423_create_orders_table', 1),
(17, '2024_09_13_102312_create_order_items_table', 1),
(18, '2024_09_21_105318_create_transactions_table', 1),
(19, '2025_09_10_180000_create_milk_batches_tables', 2),
(20, '2025_09_12_000001_add_unit_volume_to_unit_types_table', 3),
(21, '2025_09_12_000002_add_available_volume_to_milk_batches_table', 4),
(22, '2025_09_12_091448_add_milk_batch_id_to_products_table', 5),
(23, '2025_09_12_091835_add_milk_batch_id_to_products_table', 6),
(24, '2025_09_13_000003_add_milk_batch_id_to_products_table', 7);

-- --------------------------------------------------------

--
-- Table structure for table `milk_batches`
--

CREATE TABLE `milk_batches` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `batch_date` date NOT NULL,
  `batch_no` varchar(255) NOT NULL,
  `person` varchar(255) DEFAULT NULL,
  `volume_l` decimal(20,3) NOT NULL,
  `available_volume` decimal(20,8) NOT NULL DEFAULT 0.00000000,
  `milk_unit_price` decimal(20,3) DEFAULT NULL,
  `milk_purchase_cost` decimal(20,2) NOT NULL DEFAULT 0.00,
  `labour_cost` decimal(20,2) NOT NULL DEFAULT 0.00,
  `other_expenses_total` decimal(20,2) NOT NULL DEFAULT 0.00,
  `total_sales_expected` decimal(20,2) NOT NULL DEFAULT 0.00,
  `profit_margin` decimal(20,2) NOT NULL DEFAULT 0.00,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `milk_batches`
--

INSERT INTO `milk_batches` (`id`, `batch_date`, `batch_no`, `person`, `volume_l`, `available_volume`, `milk_unit_price`, `milk_purchase_cost`, `labour_cost`, `other_expenses_total`, `total_sales_expected`, `profit_margin`, `notes`, `created_at`, `updated_at`) VALUES
(13, '2025-09-20', '5555UV', 'Scola', 55.000, 45.00000000, 1000.000, 55000.00, 0.00, 0.00, 0.00, 0.00, NULL, '2025-09-12 06:36:24', '2025-09-12 06:37:12'),
(14, '2025-09-13', '55556hg', 'Scola', 5.000, 5.00000000, 1000.000, 5000.00, 0.00, 0.00, 0.00, 0.00, NULL, '2025-09-12 10:06:14', '2025-09-12 10:06:14'),
(15, '2025-09-13', '555PTTZ', 'Scola', 5.000, 1.50000000, 1000.000, 5000.00, 1000.00, 0.00, 0.00, 0.00, NULL, '2025-09-12 10:17:44', '2025-09-12 10:20:58');

-- --------------------------------------------------------

--
-- Table structure for table `milk_batch_expenses`
--

CREATE TABLE `milk_batch_expenses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `milk_batch_id` bigint(20) UNSIGNED NOT NULL,
  `cost_centre` varchar(255) NOT NULL,
  `item` varchar(255) NOT NULL,
  `unit_price` decimal(20,2) NOT NULL DEFAULT 0.00,
  `units` decimal(20,3) NOT NULL DEFAULT 0.000,
  `total` decimal(20,2) NOT NULL DEFAULT 0.00,
  `expense_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `milk_batch_labours`
--

CREATE TABLE `milk_batch_labours` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `milk_batch_id` bigint(20) UNSIGNED NOT NULL,
  `cost_centre` varchar(255) NOT NULL,
  `person` varchar(255) DEFAULT NULL,
  `job_title` varchar(255) DEFAULT NULL,
  `daily_wage` decimal(20,2) NOT NULL DEFAULT 0.00,
  `days` decimal(20,2) NOT NULL DEFAULT 0.00,
  `total` decimal(20,2) NOT NULL DEFAULT 0.00,
  `labour_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `milk_claims`
--

CREATE TABLE `milk_claims` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `claim_date` date NOT NULL,
  `person` varchar(255) NOT NULL,
  `cost_centre` varchar(255) NOT NULL,
  `item` varchar(255) NOT NULL,
  `price` decimal(20,2) NOT NULL DEFAULT 0.00,
  `units` decimal(20,3) NOT NULL DEFAULT 0.000,
  `amount` decimal(20,2) NOT NULL DEFAULT 0.00,
  `paid_amount` decimal(20,2) NOT NULL DEFAULT 0.00,
  `balance` decimal(20,2) NOT NULL DEFAULT 0.00,
  `batch_no` varchar(255) DEFAULT NULL,
  `notice` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `milk_productions`
--

CREATE TABLE `milk_productions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `milk_batch_id` bigint(20) UNSIGNED NOT NULL,
  `milk_product_id` bigint(20) UNSIGNED NOT NULL,
  `produced_units` decimal(20,3) NOT NULL DEFAULT 0.000,
  `milk_consumed_l` decimal(20,3) NOT NULL DEFAULT 0.000,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `milk_products`
--

CREATE TABLE `milk_products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `base_quantity_l` decimal(20,3) NOT NULL,
  `unit_label` varchar(255) NOT NULL,
  `selling_price` decimal(20,2) NOT NULL,
  `packaging_cost` decimal(20,2) NOT NULL DEFAULT 0.00,
  `net_price` decimal(20,2) NOT NULL DEFAULT 0.00,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `milk_stock_movements`
--

CREATE TABLE `milk_stock_movements` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `reference_type` varchar(255) NOT NULL,
  `reference_id` bigint(20) UNSIGNED NOT NULL,
  `milk_product_id` bigint(20) UNSIGNED NOT NULL,
  `milk_batch_id` bigint(20) UNSIGNED DEFAULT NULL,
  `direction` enum('in','out') NOT NULL,
  `quantity_units` decimal(20,3) NOT NULL,
  `milk_equiv_l` decimal(20,3) NOT NULL DEFAULT 0.000,
  `note` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `order_number` varchar(255) NOT NULL,
  `sub_total` decimal(20,8) NOT NULL,
  `tax_total` decimal(20,8) DEFAULT NULL,
  `discount_total` decimal(20,8) DEFAULT NULL,
  `total` decimal(20,8) NOT NULL,
  `paid` decimal(20,8) NOT NULL,
  `due` decimal(20,8) NOT NULL,
  `profit` decimal(20,8) NOT NULL,
  `loss` decimal(20,8) NOT NULL,
  `status` varchar(50) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `customer_id`, `order_number`, `sub_total`, `tax_total`, `discount_total`, `total`, `paid`, `due`, `profit`, `loss`, `status`, `created_at`, `updated_at`) VALUES
(3, NULL, 'O-JQmUS', 500000.00000000, 0.00000000, 0.00000000, 500000.00000000, 500000.00000000, 0.00000000, 80000.00000000, 0.00000000, 'paid', '2025-09-07 09:39:19', '2025-09-07 09:39:19'),
(4, NULL, 'O-mQeCB', 165000.00000000, 0.00000000, 0.00000000, 165000.00000000, 165000.00000000, 0.00000000, 21500.00000000, 0.00000000, 'paid', '2025-09-10 00:48:55', '2025-09-10 00:48:55'),
(5, NULL, 'O-olQEg', 105000.00000000, 0.00000000, 0.00000000, 105000.00000000, 105000.00000000, 0.00000000, 7000.00000000, 0.00000000, 'paid', '2025-09-10 00:51:10', '2025-09-10 00:51:10'),
(6, NULL, 'O-py5fc', 40000.00000000, 0.00000000, 40000.00000000, 0.00000000, 0.00000000, 0.00000000, 0.00000000, 38500.00000000, 'unpaid', '2025-09-10 00:52:44', '2025-09-10 00:52:44'),
(7, NULL, 'O-3V5U6', 40000.00000000, 0.00000000, 40000.00000000, 0.00000000, 0.00000000, 0.00000000, 0.00000000, 38500.00000000, 'unpaid', '2025-09-10 00:54:07', '2025-09-10 00:54:07'),
(8, NULL, 'O-XMZg2', 210000.00000000, 0.00000000, 0.00000000, 210000.00000000, 210000.00000000, 0.00000000, 14000.00000000, 0.00000000, 'paid', '2025-09-10 11:30:12', '2025-09-10 11:30:12'),
(9, NULL, 'O-56rJk', 40000.00000000, 0.00000000, 0.00000000, 40000.00000000, 40000.00000000, 0.00000000, 1500.00000000, 0.00000000, 'paid', '2025-09-10 16:08:41', '2025-09-10 16:08:41'),
(10, NULL, 'O-nqZcH', 3000.00000000, 0.00000000, 0.00000000, 3000.00000000, 3000.00000000, 0.00000000, 1000.00000000, 0.00000000, 'paid', '2025-09-10 12:19:33', '2025-09-10 12:19:33'),
(11, 1, 'O-wgQrC', 40000.00000000, 0.00000000, 0.00000000, 40000.00000000, 40000.00000000, 0.00000000, 1500.00000000, 0.00000000, 'paid', '2025-09-11 04:30:30', '2025-09-11 04:30:37'),
(12, 1, 'O-2DRdm', 4000.00000000, 0.00000000, 0.00000000, 4000.00000000, 4000.00000000, 0.00000000, 2000.00000000, 0.00000000, 'paid', '2025-09-11 04:59:38', '2025-09-11 04:59:38'),
(13, NULL, 'O-4X6ZJ', 2000.00000000, 0.00000000, 0.00000000, 2000.00000000, 2000.00000000, 0.00000000, 1000.00000000, 0.00000000, 'paid', '2025-09-11 11:53:03', '2025-09-11 11:53:03'),
(14, NULL, 'O-jrtTB', 5000.00000000, 0.00000000, 0.00000000, 5000.00000000, 5000.00000000, 0.00000000, 4500.00000000, 0.00000000, 'paid', '2025-09-11 11:55:46', '2025-09-11 11:55:46'),
(15, NULL, 'O-FlASa', 10000.00000000, 0.00000000, 0.00000000, 10000.00000000, 10000.00000000, 0.00000000, 9000.00000000, 0.00000000, 'paid', '2025-09-11 12:20:47', '2025-09-11 12:20:47'),
(16, NULL, 'O-6JFZH', 5000.00000000, 0.00000000, 0.00000000, 5000.00000000, 5000.00000000, 0.00000000, 4500.00000000, 0.00000000, 'paid', '2025-09-11 12:21:11', '2025-09-11 12:21:11'),
(17, NULL, 'O-QNrpP', 11110.00000000, 0.00000000, 0.00000000, 11110.00000000, 11110.00000000, 0.00000000, 10000.00000000, 0.00000000, 'paid', '2025-09-12 02:49:55', '2025-09-12 02:49:55'),
(18, NULL, 'O-odCys', 10000.00000000, 0.00000000, 0.00000000, 10000.00000000, 10000.00000000, 0.00000000, 8000.00000000, 0.00000000, 'paid', '2025-09-12 03:10:18', '2025-09-12 03:10:18'),
(19, NULL, 'O-XihV4', 25000.00000000, 0.00000000, 0.00000000, 25000.00000000, 25000.00000000, 0.00000000, 22500.00000000, 0.00000000, 'paid', '2025-09-12 04:58:11', '2025-09-12 04:58:11'),
(20, NULL, 'O-Oltxy', 10000.00000000, 0.00000000, 0.00000000, 10000.00000000, 10000.00000000, 0.00000000, 9000.00000000, 0.00000000, 'paid', '2025-09-12 06:40:39', '2025-09-12 06:40:39'),
(21, NULL, 'O-1tCQw', 12000.00000000, 0.00000000, 0.00000000, 12000.00000000, 12000.00000000, 0.00000000, 10000.00000000, 0.00000000, 'paid', '2025-09-12 10:19:55', '2025-09-12 10:19:55'),
(22, 1, 'O-GM7ZW', 6000.00000000, 0.00000000, 0.00000000, 6000.00000000, 6000.00000000, 0.00000000, 5000.00000000, 0.00000000, 'paid', '2025-09-12 10:20:58', '2025-09-12 10:20:58');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED DEFAULT NULL,
  `milk_batch_id` bigint(20) UNSIGNED DEFAULT NULL,
  `product_json` longtext NOT NULL,
  `quantity` decimal(20,8) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `milk_batch_id`, `product_json`, `quantity`, `created_at`, `updated_at`) VALUES
(3, 3, NULL, NULL, '{\"id\":148,\"category_id\":16,\"supplier_id\":5,\"name\":\"Chumvi\",\"product_number\":\"P-wVvWD\",\"description\":\"SALT\",\"product_code\":\"H0001\",\"root\":\"Dar Es Salaam\",\"buying_price\":10500,\"selling_price\":12500,\"buying_date\":\"2025-09-01 00:00:00\",\"unit_type_id\":20,\"quantity\":1600,\"photo\":\"http:\\/\\/localhost\\/storage\\/products\\/logo-png-17572485902630.png\",\"status\":\"active\",\"created_at\":\"2025-09-07T12:36:30.000000Z\",\"updated_at\":\"2025-09-07T12:37:54.000000Z\"}', 40.00000000, NULL, NULL),
(4, 4, NULL, NULL, '{\"id\":149,\"category_id\":5,\"supplier_id\":5,\"name\":\"NGANO - AZANIA\",\"product_number\":\"P-iZ2sH\",\"description\":\"Ngano\",\"product_code\":\"N-0001\",\"root\":\"Njombe\",\"buying_price\":38500,\"selling_price\":40000,\"buying_date\":\"2025-09-10 00:00:00\",\"unit_type_id\":17,\"quantity\":60,\"photo\":\"https:\\/\\/chuga-kariakoo.ct.ws\\/storage\\/products\\/chwaka-house-logopng-17574209255023.png\",\"status\":\"active\",\"created_at\":\"2025-09-09T12:28:45.000000Z\",\"updated_at\":\"2025-09-09T12:28:45.000000Z\"}', 1.00000000, NULL, NULL),
(5, 4, NULL, NULL, '{\"id\":148,\"category_id\":16,\"supplier_id\":5,\"name\":\"Chumvi\",\"product_number\":\"P-wVvWD\",\"description\":\"SALT\",\"product_code\":\"H0001\",\"root\":\"Dar Es Salaam\",\"buying_price\":10500,\"selling_price\":12500,\"buying_date\":\"2025-08-31 14:00:00\",\"unit_type_id\":20,\"quantity\":1560,\"photo\":\"https:\\/\\/chuga-kariakoo.ct.ws\\/storage\\/products\\/logo-png-17572485902630.png\",\"status\":\"active\",\"created_at\":\"2025-09-07T02:36:30.000000Z\",\"updated_at\":\"2025-09-07T02:39:19.000000Z\"}', 10.00000000, NULL, NULL),
(6, 5, NULL, NULL, '{\"id\":149,\"category_id\":5,\"supplier_id\":5,\"name\":\"NGANO - AZANIA\",\"product_number\":\"P-iZ2sH\",\"description\":\"Ngano\",\"product_code\":\"N-0001\",\"root\":\"Njombe\",\"buying_price\":38500,\"selling_price\":40000,\"buying_date\":\"2025-09-10 00:00:00\",\"unit_type_id\":17,\"quantity\":59,\"photo\":\"https:\\/\\/chuga-kariakoo.ct.ws\\/storage\\/products\\/chwaka-house-logopng-17574209255023.png\",\"status\":\"active\",\"created_at\":\"2025-09-09T12:28:45.000000Z\",\"updated_at\":\"2025-09-09T17:48:55.000000Z\"}', 2.00000000, NULL, NULL),
(7, 5, NULL, NULL, '{\"id\":148,\"category_id\":16,\"supplier_id\":5,\"name\":\"Chumvi\",\"product_number\":\"P-wVvWD\",\"description\":\"SALT\",\"product_code\":\"H0001\",\"root\":\"Dar Es Salaam\",\"buying_price\":10500,\"selling_price\":12500,\"buying_date\":\"2025-08-31 14:00:00\",\"unit_type_id\":20,\"quantity\":1550,\"photo\":\"https:\\/\\/chuga-kariakoo.ct.ws\\/storage\\/products\\/logo-png-17572485902630.png\",\"status\":\"active\",\"created_at\":\"2025-09-07T02:36:30.000000Z\",\"updated_at\":\"2025-09-09T17:48:55.000000Z\"}', 2.00000000, NULL, NULL),
(8, 6, NULL, NULL, '{\"id\":149,\"category_id\":5,\"supplier_id\":5,\"name\":\"NGANO - AZANIA\",\"product_number\":\"P-iZ2sH\",\"description\":\"Ngano\",\"product_code\":\"N-0001\",\"root\":\"Njombe\",\"buying_price\":38500,\"selling_price\":40000,\"buying_date\":\"2025-09-10 00:00:00\",\"unit_type_id\":17,\"quantity\":57,\"photo\":\"https:\\/\\/chuga-kariakoo.ct.ws\\/storage\\/products\\/chwaka-house-logopng-17574209255023.png\",\"status\":\"active\",\"created_at\":\"2025-09-09T12:28:45.000000Z\",\"updated_at\":\"2025-09-09T17:51:10.000000Z\"}', 1.00000000, NULL, NULL),
(9, 7, NULL, NULL, '{\"id\":149,\"category_id\":5,\"supplier_id\":5,\"name\":\"NGANO - AZANIA\",\"product_number\":\"P-iZ2sH\",\"description\":\"Ngano\",\"product_code\":\"N-0001\",\"root\":\"Njombe\",\"buying_price\":38500,\"selling_price\":40000,\"buying_date\":\"2025-09-10 00:00:00\",\"unit_type_id\":17,\"quantity\":56,\"photo\":\"https:\\/\\/chuga-kariakoo.ct.ws\\/storage\\/products\\/chwaka-house-logopng-17574209255023.png\",\"status\":\"active\",\"created_at\":\"2025-09-09T12:28:45.000000Z\",\"updated_at\":\"2025-09-09T17:52:44.000000Z\"}', 1.00000000, NULL, NULL),
(10, 8, NULL, NULL, '{\"id\":148,\"category_id\":16,\"supplier_id\":5,\"name\":\"Chumvi\",\"product_number\":\"P-wVvWD\",\"description\":\"SALT\",\"product_code\":\"H0001\",\"root\":\"Dar Es Salaam\",\"buying_price\":10500,\"selling_price\":12500,\"buying_date\":\"2025-08-31 14:00:00\",\"unit_type_id\":20,\"quantity\":1548,\"photo\":\"https:\\/\\/chuga-kariakoo.ct.ws\\/storage\\/products\\/logo-png-17572485902630.png\",\"status\":\"active\",\"created_at\":\"2025-09-07T02:36:30.000000Z\",\"updated_at\":\"2025-09-09T17:51:10.000000Z\"}', 4.00000000, NULL, NULL),
(11, 8, NULL, NULL, '{\"id\":149,\"category_id\":5,\"supplier_id\":5,\"name\":\"NGANO - AZANIA\",\"product_number\":\"P-iZ2sH\",\"description\":\"Ngano\",\"product_code\":\"N-0001\",\"root\":\"Njombe\",\"buying_price\":38500,\"selling_price\":40000,\"buying_date\":\"2025-09-10 00:00:00\",\"unit_type_id\":17,\"quantity\":55,\"photo\":\"https:\\/\\/chuga-kariakoo.ct.ws\\/storage\\/products\\/chwaka-house-logopng-17574209255023.png\",\"status\":\"active\",\"created_at\":\"2025-09-09T12:28:45.000000Z\",\"updated_at\":\"2025-09-09T17:54:07.000000Z\"}', 4.00000000, NULL, NULL),
(12, 9, NULL, NULL, '{\"id\":149,\"category_id\":5,\"supplier_id\":5,\"name\":\"NGANO - AZANIA\",\"product_number\":\"P-iZ2sH\",\"description\":\"Ngano\",\"product_code\":\"N-0001\",\"root\":\"Njombe\",\"buying_price\":38500,\"selling_price\":40000,\"buying_date\":\"2025-09-10 00:00:00\",\"unit_type_id\":17,\"quantity\":51,\"photo\":\"https:\\/\\/chuga-kariakoo.ct.ws\\/storage\\/products\\/chwaka-house-logopng-17574209255023.png\",\"status\":\"active\",\"created_at\":\"2025-09-09T12:28:45.000000Z\",\"updated_at\":\"2025-09-10T04:30:12.000000Z\"}', 1.00000000, NULL, NULL),
(13, 10, NULL, NULL, '{\"id\":151,\"category_id\":15,\"supplier_id\":5,\"name\":\"Ivory\",\"product_number\":\"P-GYxFa\",\"description\":\"okay\",\"product_code\":\"C0001\",\"root\":\"kIBAIGWA\",\"buying_price\":2000,\"selling_price\":3000,\"buying_date\":\"2025-09-05 10:00:00\",\"unit_type_id\":21,\"quantity\":60,\"photo\":\"http:\\/\\/127.0.0.1:8001\\/assets\\/img\\/default-image.jpg\",\"status\":\"active\",\"created_at\":\"2025-09-10T20:49:54.000000Z\",\"updated_at\":\"2025-09-10T20:49:54.000000Z\"}', 1.00000000, NULL, NULL),
(14, 11, NULL, NULL, '{\"id\":149,\"category_id\":5,\"supplier_id\":5,\"name\":\"NGANO - AZANIA\",\"product_number\":\"P-iZ2sH\",\"description\":\"Ngano\",\"product_code\":\"N-0001\",\"root\":\"Njombe\",\"buying_price\":38500,\"selling_price\":40000,\"buying_date\":\"2025-09-10 10:00:00\",\"unit_type_id\":17,\"quantity\":50,\"photo\":\"\\/storage\\/products\\/chwaka-house-logopng-17574209255023.png\",\"status\":\"active\",\"created_at\":\"2025-09-09T22:28:45.000000Z\",\"updated_at\":\"2025-09-10T19:08:41.000000Z\"}', 1.00000000, NULL, NULL),
(15, 12, 161, NULL, '{\"id\":161,\"category_id\":28,\"supplier_id\":7,\"name\":\"MILK\",\"product_number\":\"P-kiomK\",\"description\":\"OKAY\",\"product_code\":\"H0001\",\"root\":\"KONGWA\",\"buying_price\":1000,\"selling_price\":2000,\"buying_date\":\"2025-09-10 00:00:00\",\"unit_type_id\":4,\"quantity\":20,\"photo\":\"http:\\/\\/127.0.0.1:8001\\/assets\\/img\\/default-image.jpg\",\"status\":\"active\",\"created_at\":\"2025-09-11T07:58:49.000000Z\",\"updated_at\":\"2025-09-11T07:58:49.000000Z\"}', 2.00000000, NULL, NULL),
(16, 13, 161, NULL, '{\"id\":161,\"category_id\":28,\"supplier_id\":7,\"name\":\"MILK\",\"product_number\":\"P-kiomK\",\"description\":\"OKAY\",\"product_code\":\"H0001\",\"root\":\"KONGWA\",\"buying_price\":1000,\"selling_price\":2000,\"buying_date\":\"2025-09-10 00:00:00\",\"unit_type_id\":null,\"quantity\":18,\"photo\":\"http:\\/\\/127.0.0.1:8000\\/assets\\/img\\/default-image.jpg\",\"status\":\"active\",\"created_at\":\"2025-09-11T07:58:49.000000Z\",\"updated_at\":\"2025-09-11T07:59:38.000000Z\"}', 1.00000000, NULL, NULL),
(17, 14, NULL, NULL, '{\"id\":162,\"category_id\":31,\"supplier_id\":null,\"name\":\"YOGHURT\",\"product_number\":\"P-yzZ65\",\"description\":null,\"product_code\":\"202020\",\"root\":null,\"buying_price\":500,\"selling_price\":5000,\"buying_date\":\"2025-09-13 00:00:00\",\"unit_type_id\":24,\"quantity\":20,\"photo\":\"http:\\/\\/127.0.0.1:8000\\/assets\\/img\\/default-image.jpg\",\"status\":\"active\",\"created_at\":\"2025-09-11T14:55:06.000000Z\",\"updated_at\":\"2025-09-11T14:55:06.000000Z\"}', 1.00000000, NULL, NULL),
(18, 15, NULL, NULL, '{\"id\":162,\"category_id\":31,\"supplier_id\":null,\"name\":\"YOGHURT\",\"product_number\":\"P-yzZ65\",\"description\":null,\"product_code\":\"202020\",\"root\":null,\"buying_price\":500,\"selling_price\":5000,\"buying_date\":\"2025-09-13 00:00:00\",\"unit_type_id\":24,\"quantity\":19,\"photo\":\"http:\\/\\/127.0.0.1:8000\\/assets\\/img\\/default-image.jpg\",\"status\":\"active\",\"created_at\":\"2025-09-11T14:55:06.000000Z\",\"updated_at\":\"2025-09-11T14:55:46.000000Z\"}', 2.00000000, NULL, NULL),
(19, 16, NULL, NULL, '{\"id\":162,\"category_id\":31,\"supplier_id\":null,\"name\":\"YOGHURT\",\"product_number\":\"P-yzZ65\",\"description\":null,\"product_code\":\"202020\",\"root\":null,\"buying_price\":500,\"selling_price\":5000,\"buying_date\":\"2025-09-13 00:00:00\",\"unit_type_id\":24,\"quantity\":17,\"photo\":\"http:\\/\\/127.0.0.1:8000\\/assets\\/img\\/default-image.jpg\",\"status\":\"active\",\"created_at\":\"2025-09-11T14:55:06.000000Z\",\"updated_at\":\"2025-09-11T15:20:47.000000Z\"}', 1.00000000, NULL, NULL),
(20, 17, 163, NULL, '{\"id\":163,\"category_id\":28,\"supplier_id\":null,\"name\":\"GEAR\",\"product_number\":\"P-ToVyO\",\"description\":null,\"product_code\":\"202020\",\"root\":null,\"buying_price\":555,\"selling_price\":5555,\"buying_date\":\"2025-09-12 00:00:00\",\"unit_type_id\":25,\"quantity\":60,\"photo\":\"http:\\/\\/127.0.0.1:8000\\/assets\\/img\\/default-image.jpg\",\"status\":\"active\",\"created_at\":\"2025-09-11T15:45:45.000000Z\",\"updated_at\":\"2025-09-11T15:45:45.000000Z\"}', 2.00000000, NULL, NULL),
(21, 18, 163, NULL, '{\"id\":163,\"category_id\":28,\"supplier_id\":null,\"name\":\"CHIA YOGHURT\",\"product_number\":\"P-ToVyO\",\"description\":null,\"product_code\":\"202020\",\"root\":null,\"buying_price\":1000,\"selling_price\":5000,\"buying_date\":\"2025-09-12 00:00:00\",\"unit_type_id\":25,\"quantity\":58,\"photo\":\"http:\\/\\/127.0.0.1:8000\\/assets\\/img\\/default-image.jpg\",\"status\":\"active\",\"created_at\":\"2025-09-11T15:45:45.000000Z\",\"updated_at\":\"2025-09-12T06:09:59.000000Z\"}', 2.00000000, NULL, NULL),
(22, 19, NULL, NULL, '{\"id\":165,\"category_id\":28,\"supplier_id\":null,\"name\":\"GEAR\",\"product_number\":\"P-8mMHa\",\"description\":null,\"product_code\":\"202020\",\"root\":null,\"buying_price\":500,\"selling_price\":5000,\"buying_date\":\"2025-09-12 00:00:00\",\"unit_type_id\":25,\"quantity\":5,\"photo\":\"http:\\/\\/127.0.0.1:8000\\/assets\\/img\\/default-image.jpg\",\"status\":\"active\",\"created_at\":\"2025-09-12T07:56:45.000000Z\",\"updated_at\":\"2025-09-12T07:56:45.000000Z\"}', 5.00000000, NULL, NULL),
(23, 20, 164, NULL, '{\"id\":164,\"category_id\":28,\"supplier_id\":null,\"milk_batch_id\":null,\"name\":\"yoghurt\",\"product_number\":\"P-POeZw\",\"description\":null,\"product_code\":\"H0001\",\"root\":null,\"buying_price\":500,\"selling_price\":5000,\"buying_date\":\"2025-09-13 00:00:00\",\"unit_type_id\":26,\"quantity\":6,\"photo\":\"http:\\/\\/127.0.0.1:8000\\/assets\\/img\\/default-image.jpg\",\"status\":\"active\",\"created_at\":\"2025-09-12T07:54:35.000000Z\",\"updated_at\":\"2025-09-12T07:55:12.000000Z\"}', 2.00000000, NULL, NULL),
(24, 21, 173, NULL, '{\"id\":173,\"category_id\":28,\"supplier_id\":null,\"milk_batch_id\":15,\"name\":\"YOGHURT\",\"product_number\":\"P-Lh9n5\",\"description\":null,\"product_code\":\"YG56\",\"root\":null,\"buying_price\":500,\"selling_price\":3000,\"buying_date\":\"2025-09-25 00:00:00\",\"unit_type_id\":27,\"quantity\":20,\"photo\":\"http:\\/\\/127.0.0.1:8000\\/assets\\/img\\/default-image.jpg\",\"status\":\"active\",\"created_at\":\"2025-09-12T13:18:57.000000Z\",\"updated_at\":\"2025-09-12T13:18:57.000000Z\"}', 4.00000000, NULL, NULL),
(25, 22, 173, NULL, '{\"id\":173,\"category_id\":28,\"supplier_id\":null,\"milk_batch_id\":15,\"name\":\"YOGHURT\",\"product_number\":\"P-Lh9n5\",\"description\":null,\"product_code\":\"YG56\",\"root\":null,\"buying_price\":500,\"selling_price\":3000,\"buying_date\":\"2025-09-25 00:00:00\",\"unit_type_id\":27,\"quantity\":16,\"photo\":\"http:\\/\\/127.0.0.1:8000\\/assets\\/img\\/default-image.jpg\",\"status\":\"active\",\"created_at\":\"2025-09-12T13:18:57.000000Z\",\"updated_at\":\"2025-09-12T13:19:55.000000Z\"}', 2.00000000, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `supplier_id` bigint(20) UNSIGNED DEFAULT NULL,
  `milk_batch_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `product_number` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `product_code` varchar(255) DEFAULT NULL,
  `root` varchar(255) DEFAULT NULL,
  `buying_price` decimal(20,8) NOT NULL,
  `selling_price` decimal(20,8) NOT NULL,
  `buying_date` timestamp NULL DEFAULT NULL,
  `unit_type_id` bigint(20) UNSIGNED DEFAULT NULL,
  `quantity` decimal(20,8) NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `category_id`, `supplier_id`, `milk_batch_id`, `name`, `product_number`, `description`, `product_code`, `root`, `buying_price`, `selling_price`, `buying_date`, `unit_type_id`, `quantity`, `photo`, `status`, `created_at`, `updated_at`) VALUES
(152, 28, 7, NULL, 'Cow Milk (Fresh)', 'P-vN7sR', 'Cow Milk (Fresh)', 'SRKTB', 'Dairy', 1200.00000000, 1500.00000000, '2025-08-31 21:00:00', 23, 500.00000000, 'default-image.jpg', 'active', '2025-09-11 04:44:46', '2025-09-11 12:46:50'),
(161, 28, 7, NULL, 'MILK', 'P-kiomK', 'OKAY', 'H0001', 'KONGWA', 1000.00000000, 2000.00000000, '2025-09-09 21:00:00', 26, 17.00000000, NULL, 'active', '2025-09-11 04:58:49', '2025-09-11 12:46:41'),
(163, 28, NULL, NULL, 'CHIA YOGHURT', 'P-ToVyO', NULL, '202020', NULL, 1000.00000000, 5000.00000000, '2025-09-11 21:00:00', 25, 56.00000000, NULL, 'active', '2025-09-11 12:45:45', '2025-09-12 03:10:18'),
(164, 28, NULL, NULL, 'yoghurt', 'P-POeZw', NULL, 'H0001', NULL, 500.00000000, 5000.00000000, '2025-09-12 21:00:00', 26, 4.00000000, NULL, 'active', '2025-09-12 04:54:35', '2025-09-12 06:40:39'),
(173, 28, NULL, 15, 'YOGHURT', 'P-Lh9n5', NULL, 'YG56', NULL, 500.00000000, 3000.00000000, '2025-09-24 21:00:00', 27, 14.00000000, NULL, 'active', '2025-09-12 10:18:57', '2025-09-12 10:20:58');

-- --------------------------------------------------------

--
-- Table structure for table `salaries`
--

CREATE TABLE `salaries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `amount` decimal(20,8) NOT NULL,
  `salary_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `val` text DEFAULT NULL,
  `group` varchar(255) NOT NULL DEFAULT 'default',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `name`, `val`, `group`, `created_at`, `updated_at`) VALUES
(1, 'currency_symbol', 'TZS', 'default', '2025-09-06 06:14:45', '2025-09-06 06:14:45');

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `shop_name` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`id`, `name`, `email`, `phone`, `address`, `photo`, `shop_name`, `created_at`, `updated_at`) VALUES
(5, 'Takbir Company Limited', 'takbir@gmail.com', '0753066086', 'Dar Es Salaam, Tanzania', 'logo-png-17572483556290.png', 'Takbir Enterprises', '2025-09-07 09:32:35', '2025-09-07 09:32:35'),
(7, 'Supplier 1', 'supplier-1@example.com', '0700119519', 'Local Supplier', 'supplier-1.jpg', 'Dairy Supplies Co.', '2025-09-11 04:44:45', '2025-09-11 04:44:45'),
(8, 'Supplier 2', 'supplier-2@example.com', '0700947292', 'Local Supplier', 'supplier-2.jpg', 'Dairy Supplies Co.', '2025-09-11 04:44:46', '2025-09-11 04:44:46'),
(9, 'Supplier 3', 'supplier-3@example.com', '0700786927', 'Local Supplier', 'supplier-3.jpg', 'Dairy Supplies Co.', '2025-09-11 04:44:46', '2025-09-11 04:44:46');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `transaction_number` varchar(255) NOT NULL,
  `amount` varchar(255) NOT NULL,
  `paid_through` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `order_id`, `transaction_number`, `amount`, `paid_through`, `created_at`, `updated_at`) VALUES
(3, 3, 'TRX-ps22g', '500000', 'cash', '2025-09-07 09:39:19', '2025-09-07 09:39:19'),
(4, 4, 'TRX-sy1e2', '165000', 'cash', '2025-09-10 00:48:55', '2025-09-10 00:48:55'),
(5, 5, 'TRX-ZDha9', '105000', 'cash', '2025-09-10 00:51:10', '2025-09-10 00:51:10'),
(6, 6, 'TRX-Skoqo', '0', 'cash', '2025-09-10 00:52:44', '2025-09-10 00:52:44'),
(7, 7, 'TRX-lVPPl', '0', 'gift_card', '2025-09-10 00:54:07', '2025-09-10 00:54:07'),
(8, 8, 'TRX-SdWEc', '210000', 'cash', '2025-09-10 11:30:12', '2025-09-10 11:30:12'),
(9, 9, 'TRX-WlMcF', '40000', 'cash', '2025-09-10 16:08:41', '2025-09-10 16:08:41'),
(10, 10, 'TRX-hNsab', '3000', 'cash', '2025-09-10 12:19:33', '2025-09-10 12:19:33'),
(11, 11, 'TRX-uHmbj', '0', 'loan', '2025-09-11 04:30:30', '2025-09-11 04:30:30'),
(12, 11, 'TRX-E3yw1', '40000', 'cash', '2025-09-11 04:30:37', '2025-09-11 04:30:37'),
(13, 12, 'TRX-iTgSz', '4000', 'cash', '2025-09-11 04:59:39', '2025-09-11 04:59:39'),
(14, 13, 'TRX-n5J3f', '2000', 'cash', '2025-09-11 11:53:03', '2025-09-11 11:53:03'),
(15, 14, 'TRX-Suadg', '5000', 'cash', '2025-09-11 11:55:46', '2025-09-11 11:55:46'),
(16, 15, 'TRX-jvjVK', '10000', 'cash', '2025-09-11 12:20:47', '2025-09-11 12:20:47'),
(17, 16, 'TRX-J9JS9', '5000', 'cash', '2025-09-11 12:21:11', '2025-09-11 12:21:11'),
(18, 17, 'TRX-zT4yM', '11110', 'cash', '2025-09-12 02:49:55', '2025-09-12 02:49:55'),
(19, 18, 'TRX-4yzhW', '10000', 'cash', '2025-09-12 03:10:18', '2025-09-12 03:10:18'),
(20, 19, 'TRX-23EQG', '25000', 'cash', '2025-09-12 04:58:12', '2025-09-12 04:58:12'),
(21, 20, 'TRX-j0BzK', '10000', 'cash', '2025-09-12 06:40:39', '2025-09-12 06:40:39'),
(22, 21, 'TRX-kKhGW', '12000', 'cash', '2025-09-12 10:19:55', '2025-09-12 10:19:55'),
(23, 22, 'TRX-PXkRK', '6000', 'cash', '2025-09-12 10:20:58', '2025-09-12 10:20:58');

-- --------------------------------------------------------

--
-- Table structure for table `unit_types`
--

CREATE TABLE `unit_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `symbol` varchar(255) NOT NULL,
  `unit_volume` decimal(20,8) NOT NULL DEFAULT 1.00000000,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `unit_types`
--

INSERT INTO `unit_types` (`id`, `name`, `symbol`, `unit_volume`, `created_at`, `updated_at`) VALUES
(22, 'Five Litres', 'L5', 5.00000000, '2025-09-11 04:41:23', '2025-09-12 04:59:44'),
(23, 'Three Litres', 'L3', 3.00000000, '2025-09-11 04:41:23', '2025-09-12 04:59:52'),
(24, 'Two Litres', 'L2', 2.00000000, '2025-09-11 04:41:23', '2025-09-12 04:59:59'),
(25, 'One Litre', 'L', 1.00000000, '2025-09-11 04:41:23', '2025-09-11 08:54:23'),
(26, 'Half Litre', 'Ml500', 0.50000000, '2025-09-11 04:41:23', '2025-09-12 05:00:24'),
(27, 'Quarter Litre', 'Ml250', 0.25000000, '2025-09-11 04:41:23', '2025-09-12 05:00:35');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `photo`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'RAMADHANI RAMADHANI', 'yasynramah@gmail.com', NULL, '$2y$12$uUaEdJwJXzw9UJdWJDJLqeOpZ/qAKE0bzKOYfalb8fCH708LyJG9.', 'logo-png-17571501257791.png', NULL, '2025-09-06 06:13:04', '2025-09-06 06:15:25'),
(2, 'Japhary Nduko', 'japharynduko11@gmail.com', NULL, '$2y$12$QkdPGrq5FTNPgInPOvLoHuguaTJVe15/ejfgwImjjxS7xgfYqV22O', NULL, NULL, '2025-09-09 19:50:32', '2025-09-09 19:50:32');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `carts_user_id_foreign` (`user_id`),
  ADD KEY `carts_product_id_foreign` (`product_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_name_unique` (`name`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `employees_email_unique` (`email`),
  ADD KEY `employees_name_index` (`name`);

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `expenses_amount_index` (`amount`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `milk_batches`
--
ALTER TABLE `milk_batches`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `milk_batches_batch_no_unique` (`batch_no`);

--
-- Indexes for table `milk_batch_expenses`
--
ALTER TABLE `milk_batch_expenses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `milk_batch_expenses_milk_batch_id_foreign` (`milk_batch_id`);

--
-- Indexes for table `milk_batch_labours`
--
ALTER TABLE `milk_batch_labours`
  ADD PRIMARY KEY (`id`),
  ADD KEY `milk_batch_labours_milk_batch_id_foreign` (`milk_batch_id`);

--
-- Indexes for table `milk_claims`
--
ALTER TABLE `milk_claims`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `milk_productions`
--
ALTER TABLE `milk_productions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `milk_productions_milk_batch_id_foreign` (`milk_batch_id`),
  ADD KEY `milk_productions_milk_product_id_foreign` (`milk_product_id`);

--
-- Indexes for table `milk_products`
--
ALTER TABLE `milk_products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `milk_stock_movements`
--
ALTER TABLE `milk_stock_movements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `milk_stock_movements_reference_type_reference_id_index` (`reference_type`,`reference_id`),
  ADD KEY `milk_stock_movements_milk_product_id_foreign` (`milk_product_id`),
  ADD KEY `milk_stock_movements_milk_batch_id_foreign` (`milk_batch_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `orders_order_number_unique` (`order_number`),
  ADD KEY `orders_customer_id_foreign` (`customer_id`),
  ADD KEY `orders_due_index` (`due`),
  ADD KEY `orders_profit_index` (`profit`),
  ADD KEY `orders_loss_index` (`loss`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_items_order_id_foreign` (`order_id`),
  ADD KEY `order_items_product_id_foreign` (`product_id`),
  ADD KEY `order_items_milk_batch_id_foreign` (`milk_batch_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `products_category_id_foreign` (`category_id`),
  ADD KEY `products_supplier_id_foreign` (`supplier_id`),
  ADD KEY `products_unit_type_id_foreign` (`unit_type_id`),
  ADD KEY `products_milk_batch_id_foreign` (`milk_batch_id`);

--
-- Indexes for table `salaries`
--
ALTER TABLE `salaries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `salaries_employee_id_foreign` (`employee_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transactions_order_id_foreign` (`order_id`);

--
-- Indexes for table `unit_types`
--
ALTER TABLE `unit_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `milk_batches`
--
ALTER TABLE `milk_batches`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `milk_batch_expenses`
--
ALTER TABLE `milk_batch_expenses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `milk_batch_labours`
--
ALTER TABLE `milk_batch_labours`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `milk_claims`
--
ALTER TABLE `milk_claims`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `milk_productions`
--
ALTER TABLE `milk_productions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `milk_products`
--
ALTER TABLE `milk_products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `milk_stock_movements`
--
ALTER TABLE `milk_stock_movements`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=174;

--
-- AUTO_INCREMENT for table `salaries`
--
ALTER TABLE `salaries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `unit_types`
--
ALTER TABLE `unit_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `carts_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `carts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `milk_batch_expenses`
--
ALTER TABLE `milk_batch_expenses`
  ADD CONSTRAINT `milk_batch_expenses_milk_batch_id_foreign` FOREIGN KEY (`milk_batch_id`) REFERENCES `milk_batches` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `milk_batch_labours`
--
ALTER TABLE `milk_batch_labours`
  ADD CONSTRAINT `milk_batch_labours_milk_batch_id_foreign` FOREIGN KEY (`milk_batch_id`) REFERENCES `milk_batches` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `milk_productions`
--
ALTER TABLE `milk_productions`
  ADD CONSTRAINT `milk_productions_milk_batch_id_foreign` FOREIGN KEY (`milk_batch_id`) REFERENCES `milk_batches` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `milk_productions_milk_product_id_foreign` FOREIGN KEY (`milk_product_id`) REFERENCES `milk_products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `milk_stock_movements`
--
ALTER TABLE `milk_stock_movements`
  ADD CONSTRAINT `milk_stock_movements_milk_batch_id_foreign` FOREIGN KEY (`milk_batch_id`) REFERENCES `milk_batches` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `milk_stock_movements_milk_product_id_foreign` FOREIGN KEY (`milk_product_id`) REFERENCES `milk_products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_milk_batch_id_foreign` FOREIGN KEY (`milk_batch_id`) REFERENCES `milk_batches` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `products_milk_batch_id_foreign` FOREIGN KEY (`milk_batch_id`) REFERENCES `milk_batches` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `products_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `products_unit_type_id_foreign` FOREIGN KEY (`unit_type_id`) REFERENCES `unit_types` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `salaries`
--
ALTER TABLE `salaries`
  ADD CONSTRAINT `salaries_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
