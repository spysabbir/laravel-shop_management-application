-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 12, 2023 at 05:08 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shop_inventory-application`
--

-- --------------------------------------------------------

--
-- Table structure for table `branches`
--

CREATE TABLE `branches` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `branch_name` varchar(255) NOT NULL,
  `branch_email` varchar(255) NOT NULL,
  `branch_phone_number` varchar(255) NOT NULL,
  `branch_address` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Active',
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `branches`
--

INSERT INTO `branches` (`id`, `branch_name`, `branch_email`, `branch_phone_number`, `branch_address`, `status`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Dhaka Branch', 'dhakabranch@email.com', '01878136530', 'Dhaka, BD', 'Active', 1, NULL, NULL, '2023-05-15 00:51:11', NULL, NULL),
(2, 'Khulna Branch', 'khulnabranch@email.com', '01878136530', 'Khulna, BD', 'Active', 2, NULL, NULL, '2023-05-15 04:38:30', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `brand_name` varchar(255) NOT NULL,
  `brand_photo` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Active',
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`id`, `brand_name`, `brand_photo`, `status`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'BBB', 'bbb-photo.png', 'Active', 3, NULL, NULL, '2023-05-15 05:11:53', NULL, NULL),
(2, 'AAA', 'aaa-photo.webp', 'Active', 3, NULL, NULL, '2023-06-22 22:08:24', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `category_photo` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Active',
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `category_name`, `category_photo`, `status`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'AAA', 'aaa-photo.png', 'Active', 3, NULL, NULL, '2023-05-15 05:11:37', NULL, NULL),
(2, 'BBB', 'bbb-photo.webp', 'Active', 3, NULL, NULL, '2023-06-22 22:08:05', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone_number` varchar(255) NOT NULL,
  `subject` text NOT NULL,
  `message` longtext NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Unread',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contact_messages`
--

INSERT INTO `contact_messages` (`id`, `name`, `email`, `phone_number`, `subject`, `message`, `status`, `created_at`, `updated_at`) VALUES
(1, 'a', 'a', 'a', 'a', 'a', 'Read', '2023-05-15 10:35:55', '2023-12-10 21:30:06');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `customer_email` varchar(255) NOT NULL,
  `customer_phone_number` varchar(255) NOT NULL,
  `customer_address` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Active',
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `customer_name`, `customer_email`, `customer_phone_number`, `customer_address`, `status`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Sovon', 'sovon@email.com', '01878136530', 'Dhaka, Bd', 'Active', 3, NULL, NULL, '2023-05-15 05:10:06', NULL, NULL),
(2, 'Alif', 'alif@gmail.com', '01517805999', 'Dhaka bD', 'Active', 4, NULL, NULL, '2023-12-10 21:56:24', NULL, NULL),
(12, 'Alif', 'alifkhan@gmail.com', '01517805999', 'dsfdsfds', 'Active', 3, NULL, NULL, '2023-12-10 22:56:40', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `customers_payment_summaries`
--

CREATE TABLE `customers_payment_summaries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` int(11) NOT NULL,
  `selling_invoice_no` varchar(255) NOT NULL,
  `grand_total` double(8,2) NOT NULL,
  `payment_status` varchar(255) NOT NULL,
  `payment_method` varchar(255) DEFAULT NULL,
  `payment_amount` double(8,2) NOT NULL,
  `payment_agent_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customers_payment_summaries`
--

INSERT INTO `customers_payment_summaries` (`id`, `customer_id`, `selling_invoice_no`, `grand_total`, `payment_status`, `payment_method`, `payment_amount`, `payment_agent_id`, `created_at`, `updated_at`) VALUES
(1, 2, 'SI-1', 260.00, 'Paid', 'Hand Cash', 260.00, 3, '2023-12-10 23:02:23', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `default_settings`
--

CREATE TABLE `default_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `app_name` varchar(255) NOT NULL,
  `app_url` varchar(255) NOT NULL,
  `time_zone` varchar(255) NOT NULL DEFAULT 'UTC',
  `favicon` varchar(255) DEFAULT NULL,
  `logo_photo` varchar(255) DEFAULT NULL,
  `main_phone` varchar(255) DEFAULT NULL,
  `support_phone` varchar(255) DEFAULT NULL,
  `main_email` varchar(255) DEFAULT NULL,
  `support_email` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `facebook_link` varchar(255) DEFAULT NULL,
  `twitter_link` varchar(255) DEFAULT NULL,
  `instagram_link` varchar(255) DEFAULT NULL,
  `linkedin_link` varchar(255) DEFAULT NULL,
  `youtube_link` varchar(255) DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `default_settings`
--

INSERT INTO `default_settings` (`id`, `app_name`, `app_url`, `time_zone`, `favicon`, `logo_photo`, `main_phone`, `support_phone`, `main_email`, `support_email`, `address`, `facebook_link`, `twitter_link`, `instagram_link`, `linkedin_link`, `youtube_link`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'Spy Market', 'http://127.0.0.1:8000', 'UTC', 'Favicon.png', 'Logo-Photo.png', '01878136530', '01878136530', 'info@market.com', 'support@market.com', 'Dhaka, BD', 'market', 'market', 'market', 'market', 'market', 1, 1, '2023-05-15 06:21:35', '2023-05-15 00:56:51');

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` int(11) NOT NULL,
  `expense_category_id` int(11) NOT NULL,
  `expense_date` date NOT NULL,
  `expense_title` varchar(255) NOT NULL,
  `expense_cost` double(8,2) NOT NULL,
  `expense_description` longtext NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `expenses`
--

INSERT INTO `expenses` (`id`, `branch_id`, `expense_category_id`, `expense_date`, `expense_title`, `expense_cost`, `expense_description`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 2, '2023-12-10', '2023 November Payment', 600.00, '2023 November Payment', 3, NULL, NULL, '2023-12-10 04:29:16', '2023-12-10 04:29:22', NULL),
(2, 1, 1, '2023-12-10', '2023 November Payment', 600.00, '2023 November Payment', 3, NULL, NULL, '2023-12-10 04:30:32', NULL, NULL),
(3, 2, 1, '2023-12-11', '2023 November Payment', 15000.00, '2023 November Payment', 4, NULL, NULL, '2023-12-10 21:55:53', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `expense_categories`
--

CREATE TABLE `expense_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `expense_category_name` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Active',
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `expense_categories`
--

INSERT INTO `expense_categories` (`id`, `expense_category_name`, `status`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Staff Salary', 'Active', 1, NULL, NULL, '2023-12-10 04:14:35', NULL, NULL),
(2, 'Staff Bonus', 'Active', 1, NULL, NULL, '2023-12-10 04:14:35', NULL, NULL);

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
-- Table structure for table `mail_settings`
--

CREATE TABLE `mail_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `mailer` varchar(255) DEFAULT NULL,
  `host` varchar(255) DEFAULT NULL,
  `port` varchar(255) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `encryption` varchar(255) DEFAULT NULL,
  `from_address` varchar(255) DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mail_settings`
--

INSERT INTO `mail_settings` (`id`, `mailer`, `host`, `port`, `username`, `password`, `encryption`, `from_address`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'smtp', 'sandbox.smtp.mailtrap.io', '2525', '071aa50653a80d', '8dd8b67f9819e0', 'tls', 'info@gmail.com', 1, 1, '2023-05-15 06:21:35', '2023-05-20 05:31:28');

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
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2023_01_05_133843_create_categories_table', 1),
(6, '2023_01_19_050647_create_contact_messages_table', 1),
(7, '2023_01_23_060842_create_customers_table', 1),
(8, '2023_01_23_062824_create_staff_table', 1),
(9, '2023_01_23_151359_create_suppliers_table', 1),
(10, '2023_01_23_171611_create_brands_table', 1),
(11, '2023_01_24_110546_create_products_table', 1),
(12, '2023_01_24_112059_create_units_table', 1),
(13, '2023_01_24_170220_create_purchase_summaries_table', 1),
(14, '2023_01_24_170510_create_purchase_details_table', 1),
(15, '2023_01_26_042515_create_purchase_carts_table', 1),
(16, '2023_01_30_171425_create_selling_carts_table', 1),
(17, '2023_01_30_171936_create_selling_details_table', 1),
(18, '2023_01_30_174600_create_selling_summaries_table', 1),
(19, '2023_02_02_152041_create_expenses_table', 1),
(20, '2023_02_02_153657_create_expense_categories_table', 1),
(21, '2023_02_03_120054_create_suppliers_payment_summaries_table', 1),
(22, '2023_02_03_120344_create_customers_payment_summaries_table', 1),
(24, '2023_05_07_111325_create_branches_table', 1),
(25, '2023_05_07_153520_create_sms_settings_table', 1),
(26, '2023_05_07_153605_create_mail_settings_table', 1),
(27, '2023_05_07_153648_create_default_settings_table', 1),
(28, '2023_05_16_030442_create_staff_designations_table', 2),
(30, '2023_02_11_150634_create_staff_salaries_table', 3),
(31, '2023_06_20_043015_create_staff_payments_table', 3);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
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
  `category_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_code` varchar(255) NOT NULL,
  `brand_id` int(11) NOT NULL,
  `unit_id` int(11) NOT NULL,
  `purchase_quantity` int(11) NOT NULL DEFAULT 0,
  `selling_quantity` int(11) NOT NULL DEFAULT 0,
  `purchase_price` double(8,2) NOT NULL DEFAULT 0.00,
  `selling_price` double(8,2) NOT NULL DEFAULT 0.00,
  `product_photo` varchar(255) NOT NULL DEFAULT 'default_product_photo.jpg',
  `status` varchar(255) NOT NULL DEFAULT 'Active',
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `category_id`, `product_name`, `product_code`, `brand_id`, `unit_id`, `purchase_quantity`, `selling_quantity`, `purchase_price`, `selling_price`, `product_photo`, `status`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'A Product', 'uW2xAliEB3', 2, 1, 16, 2, 450.00, 500.00, 'default_product_photo.jpg', 'Active', 3, 3, NULL, '2023-05-15 05:12:33', '2023-12-10 21:57:05', NULL),
(2, 2, 'B Product', 'khisv99sXT', 1, 2, 27, 18, 250.00, 260.00, '2-B Product-Photo.webp', 'Active', 3, 3, NULL, '2023-06-22 22:09:19', '2023-12-10 23:02:24', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `purchase_carts`
--

CREATE TABLE `purchase_carts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `purchase_quantity` int(11) DEFAULT NULL,
  `purchase_price` double(8,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_details`
--

CREATE TABLE `purchase_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `purchase_invoice_no` varchar(255) NOT NULL,
  `product_id` int(11) NOT NULL,
  `purchase_quantity` int(11) NOT NULL,
  `purchase_price` double(8,2) NOT NULL,
  `branch_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `purchase_details`
--

INSERT INTO `purchase_details` (`id`, `purchase_invoice_no`, `product_id`, `purchase_quantity`, `purchase_price`, `branch_id`) VALUES
(1, 'PI-1', 1, 2, 450.00, 1),
(2, 'PI-2', 1, 1, 450.00, 2),
(3, 'PI-3', 2, 2, 250.00, 2),
(4, 'PI-4', 2, 1, 250.00, 1);

-- --------------------------------------------------------

--
-- Table structure for table `purchase_summaries`
--

CREATE TABLE `purchase_summaries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `purchase_invoice_no` varchar(255) NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `sub_total` double(8,2) NOT NULL,
  `discount` double(8,2) DEFAULT NULL,
  `grand_total` double(8,2) NOT NULL,
  `payment_status` varchar(255) NOT NULL,
  `payment_amount` double(8,2) NOT NULL,
  `purchase_agent_id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `purchase_summaries`
--

INSERT INTO `purchase_summaries` (`id`, `purchase_invoice_no`, `supplier_id`, `sub_total`, `discount`, `grand_total`, `payment_status`, `payment_amount`, `purchase_agent_id`, `branch_id`, `created_at`, `updated_at`) VALUES
(1, 'PI-1', 1, 900.00, 100.00, 800.00, 'Partially Paid', 700.00, 3, 1, '2023-12-10 21:35:53', NULL),
(2, 'PI-2', 1, 450.00, 0.00, 450.00, 'Paid', 450.00, 4, 2, '2023-12-10 21:57:04', NULL),
(3, 'PI-3', 2, 500.00, 0.00, 500.00, 'Paid', 500.00, 4, 2, '2023-12-10 21:58:14', NULL),
(4, 'PI-4', 2, 250.00, 0.00, 250.00, 'Unpaid', 0.00, 3, 1, '2023-12-10 22:00:41', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `selling_carts`
--

CREATE TABLE `selling_carts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `selling_quantity` int(11) DEFAULT NULL,
  `selling_price` double(8,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `selling_carts`
--

INSERT INTO `selling_carts` (`id`, `customer_id`, `product_id`, `selling_quantity`, `selling_price`, `created_at`, `updated_at`) VALUES
(16, 12, 1, 1, 500.00, '2023-12-10 22:56:40', NULL),
(18, 1, 1, 2, 500.00, '2023-12-10 23:07:55', '2023-12-10 23:12:23');

-- --------------------------------------------------------

--
-- Table structure for table `selling_details`
--

CREATE TABLE `selling_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `selling_invoice_no` varchar(255) NOT NULL,
  `product_id` int(11) NOT NULL,
  `selling_quantity` int(11) NOT NULL,
  `selling_price` double(8,2) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `selling_details`
--

INSERT INTO `selling_details` (`id`, `selling_invoice_no`, `product_id`, `selling_quantity`, `selling_price`, `branch_id`, `created_at`, `updated_at`) VALUES
(1, 'SI-1', 2, 1, 260.00, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `selling_summaries`
--

CREATE TABLE `selling_summaries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `selling_invoice_no` varchar(255) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `sub_total` double(8,2) NOT NULL,
  `discount` double(8,2) DEFAULT NULL,
  `grand_total` double(8,2) NOT NULL,
  `payment_status` varchar(255) NOT NULL,
  `payment_amount` double(8,2) NOT NULL,
  `selling_agent_id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `selling_summaries`
--

INSERT INTO `selling_summaries` (`id`, `selling_invoice_no`, `customer_id`, `sub_total`, `discount`, `grand_total`, `payment_status`, `payment_amount`, `selling_agent_id`, `branch_id`, `created_at`, `updated_at`) VALUES
(1, 'SI-1', 2, 260.00, 0.00, 260.00, 'Paid', 260.00, 3, 1, '2023-12-10 23:02:23', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sms_settings`
--

CREATE TABLE `sms_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `api_key` text NOT NULL,
  `sender_id` text NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sms_settings`
--

INSERT INTO `sms_settings` (`id`, `api_key`, `sender_id`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'VjkIEblFGYFP7yH5NyOk', '8809601004416', 1, 1, '2023-05-15 06:21:35', '2023-05-20 05:31:35');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` int(11) NOT NULL,
  `profile_photo` varchar(255) NOT NULL DEFAULT 'default_profile_photo.png',
  `staff_name` varchar(255) NOT NULL,
  `staff_designation_id` int(11) NOT NULL,
  `staff_email` varchar(255) NOT NULL,
  `staff_phone_number` varchar(255) NOT NULL,
  `staff_gender` varchar(255) NOT NULL,
  `staff_nid_no` varchar(255) DEFAULT NULL,
  `staff_date_of_birth` date DEFAULT NULL,
  `staff_address` text NOT NULL,
  `staff_salary` double(8,2) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Active',
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`id`, `branch_id`, `profile_photo`, `staff_name`, `staff_designation_id`, `staff_email`, `staff_phone_number`, `staff_gender`, `staff_nid_no`, `staff_date_of_birth`, `staff_address`, `staff_salary`, `status`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, '1-Sovon-Photo.jpg', 'Sovon', 1, 'sovon@mailinator.com', '01878136530', 'Male', '123456789', '2023-06-21', 'Dhaka BD', 600.00, 'Active', 3, 3, NULL, '2023-06-21 04:56:46', '2023-12-10 04:16:43', NULL),
(2, 2, '2-Alif-Photo.jpg', 'Alif', 1, 'alif@gmail.com', '0151780599', 'Male', '123456789', '2023-12-11', 'Khulna', 15000.00, 'Active', 4, 4, NULL, '2023-12-10 21:48:40', '2023-12-10 21:48:41', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `staff_designations`
--

CREATE TABLE `staff_designations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `designation_name` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Active',
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `staff_designations`
--

INSERT INTO `staff_designations` (`id`, `designation_name`, `status`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Supervisor', 'Active', 1, 1, NULL, '2023-05-15 21:27:02', '2023-05-15 21:27:45', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `staff_payments`
--

CREATE TABLE `staff_payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `staff_id` int(11) NOT NULL,
  `payment_type` varchar(255) NOT NULL,
  `payment_year` varchar(255) NOT NULL,
  `payment_month` varchar(255) NOT NULL,
  `payment_amount` double(8,2) NOT NULL,
  `payment_note` text DEFAULT NULL,
  `payment_by` int(11) NOT NULL,
  `payment_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `staff_payments`
--

INSERT INTO `staff_payments` (`id`, `staff_id`, `payment_type`, `payment_year`, `payment_month`, `payment_amount`, `payment_note`, `payment_by`, `payment_at`) VALUES
(1, 1, 'Staff Bonus', '2023', 'November', 300.00, NULL, 3, '2023-12-10 10:29:16'),
(2, 1, 'Staff Bonus', '2023', 'November', 300.00, NULL, 3, '2023-12-10 10:29:22'),
(3, 1, 'Staff Salary', '2023', 'November', 600.00, NULL, 3, '2023-12-10 10:30:31'),
(4, 2, 'Staff Salary', '2023', 'November', 15000.00, NULL, 4, '2023-12-11 03:55:53');

-- --------------------------------------------------------

--
-- Table structure for table `staff_salaries`
--

CREATE TABLE `staff_salaries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `staff_id` int(11) NOT NULL,
  `new_salary` double(8,2) NOT NULL,
  `assign_date` date NOT NULL,
  `assign_by` int(11) NOT NULL,
  `assign_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `staff_salaries`
--

INSERT INTO `staff_salaries` (`id`, `staff_id`, `new_salary`, `assign_date`, `assign_by`, `assign_at`) VALUES
(1, 1, 600.00, '2024-01-01', 3, '2023-12-10 10:16:43'),
(2, 2, 15000.00, '2023-12-11', 4, '2023-12-11 03:48:40');

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `supplier_name` varchar(255) NOT NULL,
  `supplier_email` varchar(255) NOT NULL,
  `supplier_phone_number` varchar(255) NOT NULL,
  `supplier_address` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Active',
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`id`, `supplier_name`, `supplier_email`, `supplier_phone_number`, `supplier_address`, `status`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Alif International', 'alif@email.com', '01878136530', 'Dhaka, BD', 'Active', 3, 3, NULL, '2023-05-15 05:09:30', '2023-06-18 23:10:46', NULL),
(2, 'Sovon Ltd', 'sovon@gmail.com', '01953321402', 'Khulna', 'Active', 1, NULL, NULL, '2023-12-10 21:44:19', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `suppliers_payment_summaries`
--

CREATE TABLE `suppliers_payment_summaries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `purchase_invoice_no` varchar(255) NOT NULL,
  `grand_total` double(8,2) NOT NULL,
  `payment_status` varchar(255) NOT NULL,
  `payment_method` varchar(255) DEFAULT NULL,
  `payment_amount` double(8,2) NOT NULL,
  `payment_agent_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `suppliers_payment_summaries`
--

INSERT INTO `suppliers_payment_summaries` (`id`, `supplier_id`, `purchase_invoice_no`, `grand_total`, `payment_status`, `payment_method`, `payment_amount`, `payment_agent_id`, `created_at`, `updated_at`) VALUES
(1, 1, 'PI-1', 800.00, 'Partially Paid', 'Online', 700.00, 3, '2023-12-10 21:35:53', NULL),
(2, 1, 'PI-2', 450.00, 'Paid', 'Hand Cash', 450.00, 4, '2023-12-10 21:57:05', NULL),
(3, 2, 'PI-3', 500.00, 'Paid', 'Hand Cash', 500.00, 4, '2023-12-10 21:58:15', NULL),
(4, 2, 'PI-4', 250.00, 'Unpaid', NULL, 0.00, 3, '2023-12-10 22:00:41', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `units`
--

CREATE TABLE `units` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `unit_name` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Active',
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `units`
--

INSERT INTO `units` (`id`, `unit_name`, `status`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Kg', 'Active', 3, NULL, NULL, '2023-05-15 05:12:00', NULL, NULL),
(2, 'Gram', 'Active', 3, NULL, NULL, '2023-05-15 05:12:04', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone_number` varchar(255) DEFAULT NULL,
  `gender` varchar(255) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `address` text DEFAULT NULL,
  `profile_photo` varchar(255) NOT NULL DEFAULT 'default_profile_photo.png',
  `status` varchar(255) NOT NULL DEFAULT 'Active',
  `last_active` timestamp NOT NULL DEFAULT current_timestamp(),
  `password` varchar(255) NOT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `role`, `name`, `email`, `phone_number`, `gender`, `date_of_birth`, `address`, `profile_photo`, `status`, `last_active`, `password`, `branch_id`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', 'Super Admin', 'superadmin@email.com', '01878136530', 'Male', '2023-05-15', 'Dhaka, BD', 'default_profile_photo.png', 'Active', '2023-12-10 22:02:28', '$2y$10$r2pYwcGnBhRuPKpgQMHUj..f/KoPRDWNBl9cJu.z6ncB6Qr0D4Vti', NULL, 'GCf77dC1FDQI2uMTbIL8h0byOKJX70cHFrROplyVy20CAaGbMCNNhMnpcQi5', '2023-05-15 06:21:36', '2023-12-10 22:02:28'),
(2, 'Admin', 'Admin', 'admin@email.com', NULL, NULL, NULL, NULL, 'default_profile_photo.png', 'Active', '2023-12-10 21:44:35', '$2y$10$qM5IJZbPpdUq8hB5j00FIe1Aem6I0tQU/oyzXtweMVVWFtztkpm1S', NULL, NULL, '2023-05-15 06:21:36', '2023-12-10 21:44:35'),
(3, 'Manager', 'Dhaka Manager', 'dhakamanager@email.com', '01878136530', 'Male', '2023-05-09', 'Dhaka BD', 'default_profile_photo.png', 'Active', '2023-12-10 23:20:37', '$2y$10$IJYTqudMGEwUGX/lyrEoaOPXVAUtNykrg1V6edLv6e3HDZSYUuyxa', 1, '1cvImjwxAf0ianBWdUoKEmAaO9OMN8uptPj0rz6h74gcpRYCBKdSoJ33WjH3', '2023-05-15 06:21:36', '2023-12-10 23:20:37'),
(4, 'Manager', 'Khulna Manager', 'khulnamanager@email.com', '01878136530', 'Male', '2023-05-09', 'KhulnaBD', 'default_profile_photo.png', 'Active', '2023-12-10 21:59:29', '$2y$10$IJYTqudMGEwUGX/lyrEoaOPXVAUtNykrg1V6edLv6e3HDZSYUuyxa', 2, '2S3JDYcaZu5yTp9vleLLglcvoiXL4NfMEoN2lS53uYSOHsR9VPqzNLpBCvVu', '2023-05-15 06:21:36', '2023-12-10 21:59:29');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `branches`
--
ALTER TABLE `branches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers_payment_summaries`
--
ALTER TABLE `customers_payment_summaries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `default_settings`
--
ALTER TABLE `default_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `expense_categories`
--
ALTER TABLE `expense_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `mail_settings`
--
ALTER TABLE `mail_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
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
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchase_carts`
--
ALTER TABLE `purchase_carts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchase_details`
--
ALTER TABLE `purchase_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchase_summaries`
--
ALTER TABLE `purchase_summaries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `selling_carts`
--
ALTER TABLE `selling_carts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `selling_details`
--
ALTER TABLE `selling_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `selling_summaries`
--
ALTER TABLE `selling_summaries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sms_settings`
--
ALTER TABLE `sms_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `staff_designations`
--
ALTER TABLE `staff_designations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `staff_payments`
--
ALTER TABLE `staff_payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `staff_salaries`
--
ALTER TABLE `staff_salaries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `suppliers_payment_summaries`
--
ALTER TABLE `suppliers_payment_summaries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `units`
--
ALTER TABLE `units`
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
-- AUTO_INCREMENT for table `branches`
--
ALTER TABLE `branches`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `customers_payment_summaries`
--
ALTER TABLE `customers_payment_summaries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `default_settings`
--
ALTER TABLE `default_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `expense_categories`
--
ALTER TABLE `expense_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mail_settings`
--
ALTER TABLE `mail_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `purchase_carts`
--
ALTER TABLE `purchase_carts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `purchase_details`
--
ALTER TABLE `purchase_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `purchase_summaries`
--
ALTER TABLE `purchase_summaries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `selling_carts`
--
ALTER TABLE `selling_carts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `selling_details`
--
ALTER TABLE `selling_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `selling_summaries`
--
ALTER TABLE `selling_summaries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sms_settings`
--
ALTER TABLE `sms_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `staff_designations`
--
ALTER TABLE `staff_designations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `staff_payments`
--
ALTER TABLE `staff_payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `staff_salaries`
--
ALTER TABLE `staff_salaries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `suppliers_payment_summaries`
--
ALTER TABLE `suppliers_payment_summaries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `units`
--
ALTER TABLE `units`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
