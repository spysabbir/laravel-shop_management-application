-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 05, 2023 at 07:18 PM
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
-- Database: `inventory_project_one`
--

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
(1, 'Walton', 'walton-photo.jpg', 'Active', 1, 1, NULL, '2023-02-20 06:04:18', '2023-03-05 14:50:09', NULL),
(2, 'Basundhara', 'basundhara-photo.jpg', 'Active', 1, 1, NULL, '2023-02-20 06:04:23', '2023-03-05 14:47:55', NULL),
(3, 'Arong', 'arong-photo.webp', 'Active', 1, 1, NULL, '2023-02-20 06:04:29', '2023-03-05 14:35:14', NULL),
(4, 'Aci', 'aci-photo.jpg', 'Active', 1, 1, NULL, '2023-02-20 06:04:34', '2023-03-05 14:37:43', NULL),
(5, 'Ispahani', 'ispahani-photo.jpg', 'Active', 1, 1, NULL, '2023-02-20 06:04:39', '2023-03-05 14:47:15', NULL),
(6, 'Local', 'local-photo.jpg', 'Active', 1, 1, NULL, '2023-02-20 06:04:45', '2023-03-05 14:57:30', NULL),
(7, 'Matador', 'matador-photo.png', 'Active', 1, 1, NULL, '2023-02-20 06:04:52', '2023-03-05 14:40:35', NULL),
(8, 'Nestle', 'nestle-photo.jpg', 'Active', 1, 1, NULL, '2023-02-20 06:04:58', '2023-03-05 14:41:33', NULL),
(9, 'Nivea', 'nivea-photo.png', 'Active', 1, 1, NULL, '2023-02-20 06:05:04', '2023-03-05 14:44:11', NULL),
(10, 'Olympic', 'olympic-photo.png', 'Active', 1, 1, NULL, '2023-02-20 06:05:10', '2023-03-05 14:46:10', NULL),
(11, 'Pran', 'pran-photo.jpg', 'Active', 1, 1, NULL, '2023-02-20 06:08:57', '2023-03-05 14:46:56', NULL);

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
(1, 'Beverages', 'beverages-photo.webp', 'Active', 1, 1, NULL, '2023-02-20 06:05:19', '2023-03-05 14:28:26', NULL),
(2, 'Cooking Ingredients', 'cooking-ingredients-photo.jpg', 'Active', 1, 1, NULL, '2023-02-20 06:05:26', '2023-03-05 14:29:15', NULL),
(3, 'Breakfast & Snacks', 'breakfast-snacks-photo.jpg', 'Active', 1, 1, NULL, '2023-02-20 06:05:33', '2023-03-05 14:30:12', NULL),
(4, 'Women\'s Fashion', 'woman-cloth-photo.webp', 'Active', 1, 1, NULL, '2023-03-05 15:09:03', '2023-03-05 15:13:44', NULL),
(5, 'Electronic Devices', 'electronic-photo.jpg', 'Active', 1, 1, NULL, '2023-03-05 15:12:57', '2023-03-05 15:13:58', NULL),
(6, 'Health & Beauty', 'health-beauty-photo.webp', 'Active', 1, NULL, NULL, '2023-03-05 15:15:20', NULL, NULL);

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
(1, 'Shovon', 'shovon@gmail.com', '01878136530', 'Dhaka, BD', 'Active', 1, NULL, NULL, '2023-02-20 06:03:52', NULL, NULL);

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
(1, 1, 'SI-1', 595.00, 'Partially Paid', 'Online', 150.00, 1, '2023-02-20 08:17:40', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `default_settings`
--

CREATE TABLE `default_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `app_name` varchar(255) DEFAULT NULL,
  `app_url` varchar(255) DEFAULT NULL,
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

INSERT INTO `default_settings` (`id`, `app_name`, `app_url`, `favicon`, `logo_photo`, `main_phone`, `support_phone`, `main_email`, `support_email`, `address`, `facebook_link`, `twitter_link`, `instagram_link`, `linkedin_link`, `youtube_link`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'Spy Market', 'http://127.0.0.1:8000/', 'Favicon.png', 'Logo-Photo.png', '01878136530', '01878136530', 'info@spyzone', 'support@spyzone.com', 'Dhaka, BD', 'spymarket', 'spymarket', 'spymarket', 'spymarket', 'spymarket', 1, 1, '2023-02-20 11:55:46', '2023-02-20 05:58:34');

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `expense_category_id` int(11) NOT NULL,
  `expense_date` date NOT NULL,
  `expense_title` varchar(255) NOT NULL,
  `expense_cost` double(8,2) NOT NULL,
  `expense_description` longtext NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Active',
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

INSERT INTO `expenses` (`id`, `expense_category_id`, `expense_date`, `expense_title`, `expense_cost`, `expense_description`, `status`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, '2023-02-20', '2023 January Salary', 200000.00, '2023 January Salary', 'Active', 1, NULL, NULL, '2023-02-20 06:01:26', NULL, NULL),
(2, 1, '2023-02-20', 'January', 25000.00, 'Shop Rant', 'Active', 1, NULL, NULL, '2023-02-20 06:02:36', NULL, NULL);

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
(1, 'Shop Rant', 'Active', 1, NULL, NULL, '2023-02-20 06:01:50', NULL, NULL);

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
(1, 'smtp', 'smtp.mailtrap.io', '2525', '071aa50653a80d', '8dd8b67f9819e0', 'tls', 'info@spymarket.com', 1, 1, '2023-02-20 11:56:12', '2023-02-20 05:59:30');

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
(5, '2022_12_21_064509_create_mail_settings_table', 1),
(6, '2022_12_21_064946_create_default_settings_table', 1),
(7, '2023_01_05_133843_create_categories_table', 1),
(8, '2023_01_19_050647_create_contact_messages_table', 1),
(9, '2023_01_23_060842_create_customers_table', 1),
(10, '2023_01_23_062824_create_staff_table', 1),
(11, '2023_01_23_151359_create_suppliers_table', 1),
(12, '2023_01_23_171611_create_brands_table', 1),
(13, '2023_01_24_110546_create_products_table', 1),
(14, '2023_01_24_112059_create_units_table', 1),
(15, '2023_01_24_170220_create_purchase_summaries_table', 1),
(16, '2023_01_24_170510_create_purchase_details_table', 1),
(17, '2023_01_26_042515_create_purchase_carts_table', 1),
(18, '2023_01_30_171425_create_selling_carts_table', 1),
(19, '2023_01_30_171936_create_selling_details_table', 1),
(20, '2023_01_30_174600_create_selling_summaries_table', 1),
(21, '2023_02_02_152041_create_expenses_table', 1),
(22, '2023_02_02_153657_create_expense_categories_table', 1),
(23, '2023_02_03_120054_create_suppliers_payment_summaries_table', 1),
(24, '2023_02_03_120344_create_customers_payment_summaries_table', 1),
(25, '2023_02_11_150634_create_staff_salaries_table', 1);

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
(1, 1, '7up', 'S7AZBGTNYk', 11, 3, 20, 11, 18.00, 20.00, '1-7up-Photo.jpg', 'Active', 1, 1, NULL, '2023-02-20 06:07:40', '2023-03-05 14:52:41', NULL),
(2, 2, 'Ludies', '2HgZP8zSYj', 1, 5, 45, 10, 28.00, 30.00, '2-Ludies-Photo.jpg', 'Active', 1, 1, NULL, '2023-02-20 06:08:25', '2023-03-05 14:25:05', NULL),
(3, 3, 'Biskut', '0MQooJF41b', 10, 5, 55, 5, 12.00, 15.00, '3-Biskut-Photo.webp', 'Active', 1, 1, NULL, '2023-02-20 06:09:29', '2023-03-05 14:25:59', NULL),
(4, 3, 'Ispahani Tea Bag', 'Q3PoDkCIPV', 5, 2, 0, 0, 0.00, 0.00, '4-Ispahani Tea Bag-Photo.jpg', 'Active', 1, 1, NULL, '2023-03-05 15:17:41', '2023-03-05 15:17:41', NULL),
(5, 6, 'Body Lotion', 'MZdFrUDj1K', 9, 3, 0, 0, 0.00, 0.00, '5-Body Lotion-Photo.png', 'Active', 1, 1, NULL, '2023-03-05 15:23:21', '2023-03-05 15:23:22', NULL),
(6, 5, 'Primo NF5', '1yQGTGHYU4', 1, 3, 0, 0, 0.00, 0.00, '6-Primo NF5-Photo.jpg', 'Active', 1, 1, NULL, '2023-03-05 16:41:15', '2023-03-05 16:41:15', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `purchase_carts`
--

CREATE TABLE `purchase_carts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `purchase_invoice_no` varchar(255) NOT NULL,
  `purchase_date` date NOT NULL,
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
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `purchase_details`
--

INSERT INTO `purchase_details` (`id`, `purchase_invoice_no`, `product_id`, `purchase_quantity`, `purchase_price`, `created_at`, `updated_at`) VALUES
(1, 'PI-1', 1, 20, 18.00, '2023-02-20 08:13:39', NULL),
(2, 'PI-1', 2, 45, 28.00, '2023-02-20 08:13:39', NULL),
(3, 'PI-1', 3, 55, 12.00, '2023-02-20 08:13:39', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `purchase_summaries`
--

CREATE TABLE `purchase_summaries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `purchase_invoice_no` varchar(255) NOT NULL,
  `purchase_date` date NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `sub_total` double(8,2) NOT NULL,
  `discount` double(8,2) DEFAULT NULL,
  `grand_total` double(8,2) NOT NULL,
  `payment_status` varchar(255) NOT NULL,
  `payment_amount` double(8,2) NOT NULL,
  `purchase_agent_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `purchase_summaries`
--

INSERT INTO `purchase_summaries` (`id`, `purchase_invoice_no`, `purchase_date`, `supplier_id`, `sub_total`, `discount`, `grand_total`, `payment_status`, `payment_amount`, `purchase_agent_id`, `created_at`, `updated_at`) VALUES
(1, 'PI-1', '2023-02-20', 1, 2280.00, 0.00, 2280.00, 'Paid', 2280.00, 1, '2023-02-20 08:13:39', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `selling_carts`
--

CREATE TABLE `selling_carts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `selling_invoice_no` varchar(255) NOT NULL,
  `selling_date` date NOT NULL,
  `customer_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `selling_quantity` int(11) DEFAULT NULL,
  `selling_price` double(8,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `selling_details`
--

INSERT INTO `selling_details` (`id`, `selling_invoice_no`, `product_id`, `selling_quantity`, `selling_price`, `created_at`, `updated_at`) VALUES
(1, 'SI-1', 1, 11, 20.00, '2023-02-20 08:17:40', NULL),
(2, 'SI-1', 2, 10, 30.00, '2023-02-20 08:17:40', NULL),
(3, 'SI-1', 3, 5, 15.00, '2023-02-20 08:17:40', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `selling_summaries`
--

CREATE TABLE `selling_summaries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `selling_invoice_no` varchar(255) NOT NULL,
  `selling_date` date NOT NULL,
  `customer_id` int(11) NOT NULL,
  `sub_total` double(8,2) NOT NULL,
  `discount` double(8,2) DEFAULT NULL,
  `grand_total` double(8,2) NOT NULL,
  `payment_status` varchar(255) NOT NULL,
  `payment_amount` double(8,2) NOT NULL,
  `selling_agent_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `selling_summaries`
--

INSERT INTO `selling_summaries` (`id`, `selling_invoice_no`, `selling_date`, `customer_id`, `sub_total`, `discount`, `grand_total`, `payment_status`, `payment_amount`, `selling_agent_id`, `created_at`, `updated_at`) VALUES
(1, 'SI-1', '2023-02-20', 1, 595.00, 0.00, 595.00, 'Partially Paid', 150.00, 1, '2023-02-20 08:17:40', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `profile_photo` varchar(255) NOT NULL DEFAULT 'default_profile_photo.png',
  `staff_name` varchar(255) NOT NULL,
  `staff_position` varchar(255) NOT NULL,
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

INSERT INTO `staff` (`id`, `profile_photo`, `staff_name`, `staff_position`, `staff_email`, `staff_phone_number`, `staff_gender`, `staff_nid_no`, `staff_date_of_birth`, `staff_address`, `staff_salary`, `status`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'default_profile_photo.png', 'Staff 1', 'Manager', 'staff1@gmail.com', '01878136530', 'Male', '123456789', '2023-02-20', 'Dhaka, BD', 200000.00, 'Active', 1, NULL, NULL, '2023-02-20 06:01:17', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `staff_salaries`
--

CREATE TABLE `staff_salaries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `staff_id` int(11) NOT NULL,
  `salary_year` varchar(255) NOT NULL,
  `salary_month` varchar(255) NOT NULL,
  `payment_salary` double(8,2) NOT NULL,
  `payment_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `staff_salaries`
--

INSERT INTO `staff_salaries` (`id`, `staff_id`, `salary_year`, `salary_month`, `payment_salary`, `payment_date`) VALUES
(1, 1, '2023', 'January', 200000.00, '2023-02-20');

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
(1, 'Alif International', 'alifinternational@gmail.com', '01878136530', 'Dhaka, BD', 'Active', 1, NULL, NULL, '2023-02-20 06:03:25', NULL, NULL);

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
(1, 1, 'PI-1', 2280.00, 'Paid', 'Hand Cash', 2280.00, 1, '2023-02-20 08:13:39', NULL);

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
(1, 'Kg', 'Active', 1, NULL, NULL, '2023-02-20 06:05:56', NULL, NULL),
(2, 'Box', 'Active', 1, NULL, NULL, '2023-02-20 06:06:02', NULL, NULL),
(3, 'Pcs', 'Active', 1, NULL, NULL, '2023-02-20 06:06:10', NULL, NULL),
(4, 'Ltr', 'Active', 1, NULL, NULL, '2023-02-20 06:06:22', NULL, NULL),
(5, 'Pack', 'Active', 1, NULL, NULL, '2023-02-20 06:06:38', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'Manager',
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone_number` varchar(255) DEFAULT NULL,
  `gender` varchar(255) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `address` text DEFAULT NULL,
  `profile_photo` varchar(255) NOT NULL DEFAULT 'default_profile_photo.png',
  `status` varchar(255) NOT NULL DEFAULT 'Active',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `last_active` timestamp NOT NULL DEFAULT current_timestamp(),
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `role`, `name`, `email`, `phone_number`, `gender`, `date_of_birth`, `address`, `profile_photo`, `status`, `email_verified_at`, `last_active`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', 'Sabbir Ahammed', 'superadmin@gmail.com', NULL, NULL, NULL, NULL, 'default_profile_photo.png', 'Active', NULL, '2023-03-05 16:38:40', '$2y$10$LgNgJw99dWRsEUg4xq2hpek5ES19uX4cvp1C11G7Rq1bbAhjp6IEe', NULL, '2023-02-20 05:53:43', '2023-03-05 16:38:40'),
(2, 'Adnin', 'Sabbir Ahammed', 'admin@gmail.com', NULL, NULL, NULL, NULL, 'default_profile_photo.png', 'Active', NULL, '2023-02-20 05:54:10', '$2y$10$FOuNZtkwfZMQANHbnO6UmOyF6KYlwUtOIjItXSOdkb/bm2Kll3GoK', NULL, '2023-02-20 05:54:07', '2023-02-20 05:54:10'),
(3, 'Manager', 'Sabbir Ahammed', 'manager@gmail.com', NULL, NULL, NULL, NULL, 'default_profile_photo.png', 'Active', NULL, '2023-02-20 05:54:41', '$2y$10$jQ9KGbUpyM9EK0IFNZvuZOxnAKLz7uEWQJ2nspl3oJcvT377agYJi', NULL, '2023-02-20 05:54:41', '2023-02-20 05:54:41');

--
-- Indexes for dumped tables
--

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
-- Indexes for table `staff`
--
ALTER TABLE `staff`
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
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `expense_categories`
--
ALTER TABLE `expense_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `purchase_carts`
--
ALTER TABLE `purchase_carts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchase_details`
--
ALTER TABLE `purchase_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `purchase_summaries`
--
ALTER TABLE `purchase_summaries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `selling_carts`
--
ALTER TABLE `selling_carts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `selling_details`
--
ALTER TABLE `selling_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `selling_summaries`
--
ALTER TABLE `selling_summaries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `staff_salaries`
--
ALTER TABLE `staff_salaries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `suppliers_payment_summaries`
--
ALTER TABLE `suppliers_payment_summaries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `units`
--
ALTER TABLE `units`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
