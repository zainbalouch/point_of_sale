-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 05, 2025 at 05:37 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.3.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `invoices_manager_2`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_logs`
--

CREATE TABLE `activity_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `log_name` varchar(255) DEFAULT NULL,
  `description` text NOT NULL,
  `subject_type` varchar(255) DEFAULT NULL,
  `event` varchar(255) DEFAULT NULL,
  `subject_id` bigint(20) UNSIGNED DEFAULT NULL,
  `causer_type` varchar(255) DEFAULT NULL,
  `causer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `properties` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`properties`)),
  `batch_uuid` char(36) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `activity_logs`
--

INSERT INTO `activity_logs` (`id`, `log_name`, `description`, `subject_type`, `event`, `subject_id`, `causer_type`, `causer_id`, `properties`, `batch_uuid`, `created_at`, `updated_at`) VALUES
(1, 'default', 'created', 'App\\Models\\InvoiceStatus', 'created', 7, NULL, NULL, '{\"attributes\":{\"id\":7,\"name_en\":\"Refunded\",\"name_ar\":\"\\u0645\\u0633\\u062a\\u0631\\u062c\\u0639\",\"color\":\"#805ad5\",\"created_at\":\"2025-03-23T16:14:30.000000Z\",\"updated_at\":\"2025-03-23T16:14:30.000000Z\",\"deleted_at\":null}}', NULL, '2025-03-23 17:14:30', '2025-03-23 17:14:30'),
(2, 'default', 'created', 'App\\Models\\ProductCategory', 'created', 1, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":1,\"name_en\":\"Drinks\",\"name_ar\":\"\\u0642\\u0635 \\u0634\\u0639\\u0631 \\u0627\\u0644\\u0646\\u0633\\u0627\\u0621\",\"description_en\":null,\"description_ar\":\"<p>Drinks<\\/p>\",\"slug\":\"drinks\",\"parent_id\":null,\"is_active\":1,\"created_at\":\"2025-04-09T16:36:18.000000Z\",\"updated_at\":\"2025-04-09T16:36:18.000000Z\",\"deleted_at\":null}}', NULL, '2025-04-09 16:36:18', '2025-04-09 16:36:18'),
(3, 'default', 'created', 'App\\Models\\Product', 'created', 1, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":1,\"name_en\":\"Pepsi\",\"name_ar\":\"\\u0628\\u064a\\u0628\\u0633\\u064a\",\"description_en\":\"Pepsi\",\"description_ar\":null,\"slug\":\"bybsy\",\"sku\":null,\"code\":null,\"price\":2,\"sale_price\":22,\"currency_id\":1,\"product_category_id\":1,\"point_of_sale_id\":null,\"image_url\":null,\"is_active\":true,\"created_at\":\"2025-04-09T16:36:49.000000Z\",\"updated_at\":\"2025-04-09T16:36:49.000000Z\",\"deleted_at\":null}}', NULL, '2025-04-09 16:36:49', '2025-04-09 16:36:49'),
(4, 'default', 'created', 'App\\Models\\Customer', 'created', 1, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":1,\"first_name\":\"Zain\",\"last_name\":\"ul Eman\",\"email\":\"zainuleman786@gmail.com\",\"phone_number\":\"03146775616\",\"company_id\":null,\"is_active\":true,\"meta\":null,\"created_at\":\"2025-04-09T16:37:08.000000Z\",\"updated_at\":\"2025-04-09T16:37:08.000000Z\",\"deleted_at\":null,\"vat_number\":\"3452354\",\"address\":\"New Gulshan-e-Mehr Colony Multan near Masjid e Tasheer\"}}', NULL, '2025-04-09 16:37:08', '2025-04-09 16:37:08'),
(5, 'default', 'created', 'App\\Models\\Order', 'created', 1, 'App\\Models\\User', 1, '{\"attributes\":{\"number\":\"213\",\"customer_id\":1,\"user_id\":2,\"company_id\":null,\"order_status_id\":4,\"shipping_fee\":22,\"subtotal\":22,\"tax\":22,\"total\":null,\"payment_method_id\":2,\"currency_id\":1,\"billing_address_id\":null,\"shipping_address_id\":null,\"estimated_delivery_at\":null,\"delivered_at\":null,\"shipped_at\":null,\"meta\":[]}}', NULL, '2025-04-09 16:43:58', '2025-04-09 16:43:58'),
(6, 'default', 'created', 'App\\Models\\OrderItem', 'created', 1, 'App\\Models\\User', 1, '{\"attributes\":{\"order_id\":1,\"product_name_en\":\"Pepsi\",\"product_name_ar\":\"\\u0628\\u064a\\u0628\\u0633\\u064a\",\"product_description_en\":\"Pepsi\",\"product_description_ar\":null,\"product_sku\":null,\"product_code\":null,\"product_id\":1,\"quantity\":1,\"unit_price\":2,\"tax_id\":null,\"tax_amount\":null,\"discount_amount\":0,\"total_price\":2}}', NULL, '2025-04-09 16:43:58', '2025-04-09 16:43:58'),
(7, 'default', 'created', 'App\\Models\\Address', 'created', 1, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":1,\"address_type_id\":1,\"addressable_type\":null,\"addressable_id\":null,\"street\":null,\"city\":null,\"state\":null,\"country\":null,\"postal_code\":null,\"country_id\":null,\"contact_person_full_name\":null,\"contact_person_phone\":null,\"latitude\":null,\"longitude\":null,\"details\":null,\"created_at\":\"2025-04-09T16:43:58.000000Z\",\"updated_at\":\"2025-04-09T16:43:58.000000Z\",\"deleted_at\":null}}', NULL, '2025-04-09 16:43:58', '2025-04-09 16:43:58'),
(8, 'default', 'updated', 'App\\Models\\Order', 'updated', 1, 'App\\Models\\User', 1, '{\"attributes\":{\"shipping_address_id\":1},\"old\":{\"shipping_address_id\":null}}', NULL, '2025-04-09 16:43:58', '2025-04-09 16:43:58'),
(9, 'default', 'created', 'App\\Models\\Address', 'created', 2, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":2,\"address_type_id\":2,\"addressable_type\":null,\"addressable_id\":null,\"street\":null,\"city\":null,\"state\":null,\"country\":null,\"postal_code\":null,\"country_id\":null,\"contact_person_full_name\":null,\"contact_person_phone\":null,\"latitude\":null,\"longitude\":null,\"details\":null,\"created_at\":\"2025-04-09T16:43:58.000000Z\",\"updated_at\":\"2025-04-09T16:43:58.000000Z\",\"deleted_at\":null}}', NULL, '2025-04-09 16:43:58', '2025-04-09 16:43:58'),
(10, 'default', 'updated', 'App\\Models\\Order', 'updated', 1, 'App\\Models\\User', 1, '{\"attributes\":{\"billing_address_id\":2},\"old\":{\"billing_address_id\":null}}', NULL, '2025-04-09 16:43:58', '2025-04-09 16:43:58'),
(11, 'default', 'created', 'App\\Models\\Order', 'created', 2, 'App\\Models\\User', 1, '{\"attributes\":{\"number\":\"213\",\"customer_id\":1,\"user_id\":null,\"company_id\":null,\"order_status_id\":5,\"shipping_fee\":22,\"subtotal\":22,\"tax\":22,\"total\":null,\"payment_method_id\":3,\"currency_id\":1,\"billing_address_id\":null,\"shipping_address_id\":null,\"estimated_delivery_at\":null,\"delivered_at\":null,\"shipped_at\":null,\"meta\":[]}}', NULL, '2025-04-09 16:46:18', '2025-04-09 16:46:18'),
(12, 'default', 'created', 'App\\Models\\OrderItem', 'created', 2, 'App\\Models\\User', 1, '{\"attributes\":{\"order_id\":2,\"product_name_en\":\"Pepsi\",\"product_name_ar\":\"\\u0628\\u064a\\u0628\\u0633\\u064a\",\"product_description_en\":\"Pepsi\",\"product_description_ar\":null,\"product_sku\":null,\"product_code\":null,\"product_id\":1,\"quantity\":1,\"unit_price\":2,\"tax_id\":null,\"tax_amount\":null,\"discount_amount\":0,\"total_price\":2}}', NULL, '2025-04-09 16:46:18', '2025-04-09 16:46:18'),
(13, 'default', 'created', 'App\\Models\\Address', 'created', 3, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":3,\"address_type_id\":1,\"addressable_type\":null,\"addressable_id\":null,\"street\":null,\"city\":null,\"state\":null,\"country\":null,\"postal_code\":null,\"country_id\":null,\"contact_person_full_name\":null,\"contact_person_phone\":null,\"latitude\":null,\"longitude\":null,\"details\":null,\"created_at\":\"2025-04-09T16:46:18.000000Z\",\"updated_at\":\"2025-04-09T16:46:18.000000Z\",\"deleted_at\":null}}', NULL, '2025-04-09 16:46:18', '2025-04-09 16:46:18'),
(14, 'default', 'updated', 'App\\Models\\Order', 'updated', 2, 'App\\Models\\User', 1, '{\"attributes\":{\"shipping_address_id\":3},\"old\":{\"shipping_address_id\":null}}', NULL, '2025-04-09 16:46:18', '2025-04-09 16:46:18'),
(15, 'default', 'created', 'App\\Models\\Address', 'created', 4, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":4,\"address_type_id\":2,\"addressable_type\":null,\"addressable_id\":null,\"street\":null,\"city\":null,\"state\":null,\"country\":null,\"postal_code\":null,\"country_id\":null,\"contact_person_full_name\":null,\"contact_person_phone\":null,\"latitude\":null,\"longitude\":null,\"details\":null,\"created_at\":\"2025-04-09T16:46:18.000000Z\",\"updated_at\":\"2025-04-09T16:46:18.000000Z\",\"deleted_at\":null}}', NULL, '2025-04-09 16:46:18', '2025-04-09 16:46:18'),
(16, 'default', 'updated', 'App\\Models\\Order', 'updated', 2, 'App\\Models\\User', 1, '{\"attributes\":{\"billing_address_id\":4},\"old\":{\"billing_address_id\":null}}', NULL, '2025-04-09 16:46:18', '2025-04-09 16:46:18'),
(17, 'default', 'created', 'App\\Models\\Order', 'created', 3, 'App\\Models\\User', 1, '{\"attributes\":{\"number\":\"ORD-202504-Q9QQIW\",\"customer_id\":1,\"user_id\":null,\"company_id\":null,\"order_status_id\":1,\"shipping_fee\":22,\"subtotal\":22,\"tax\":32,\"total\":null,\"payment_method_id\":4,\"currency_id\":1,\"billing_address_id\":null,\"shipping_address_id\":null,\"estimated_delivery_at\":null,\"delivered_at\":null,\"shipped_at\":null,\"meta\":[]}}', NULL, '2025-04-09 16:49:53', '2025-04-09 16:49:53'),
(18, 'default', 'created', 'App\\Models\\OrderItem', 'created', 3, 'App\\Models\\User', 1, '{\"attributes\":{\"order_id\":3,\"product_name_en\":\"Pepsi\",\"product_name_ar\":\"\\u0628\\u064a\\u0628\\u0633\\u064a\",\"product_description_en\":\"Pepsi\",\"product_description_ar\":null,\"product_sku\":null,\"product_code\":null,\"product_id\":1,\"quantity\":1,\"unit_price\":2,\"tax_id\":null,\"tax_amount\":null,\"discount_amount\":0,\"total_price\":2}}', NULL, '2025-04-09 16:49:53', '2025-04-09 16:49:53'),
(19, 'default', 'created', 'App\\Models\\Address', 'created', 5, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":5,\"address_type_id\":1,\"addressable_type\":null,\"addressable_id\":null,\"street\":null,\"city\":null,\"state\":null,\"country\":null,\"postal_code\":null,\"country_id\":null,\"contact_person_full_name\":null,\"contact_person_phone\":null,\"latitude\":null,\"longitude\":null,\"details\":null,\"created_at\":\"2025-04-09T16:49:53.000000Z\",\"updated_at\":\"2025-04-09T16:49:53.000000Z\",\"deleted_at\":null}}', NULL, '2025-04-09 16:49:53', '2025-04-09 16:49:53'),
(20, 'default', 'updated', 'App\\Models\\Order', 'updated', 3, 'App\\Models\\User', 1, '{\"attributes\":{\"shipping_address_id\":5},\"old\":{\"shipping_address_id\":null}}', NULL, '2025-04-09 16:49:53', '2025-04-09 16:49:53'),
(21, 'default', 'created', 'App\\Models\\Address', 'created', 6, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":6,\"address_type_id\":2,\"addressable_type\":null,\"addressable_id\":null,\"street\":null,\"city\":null,\"state\":null,\"country\":null,\"postal_code\":null,\"country_id\":null,\"contact_person_full_name\":null,\"contact_person_phone\":null,\"latitude\":null,\"longitude\":null,\"details\":null,\"created_at\":\"2025-04-09T16:49:53.000000Z\",\"updated_at\":\"2025-04-09T16:49:53.000000Z\",\"deleted_at\":null}}', NULL, '2025-04-09 16:49:53', '2025-04-09 16:49:53'),
(22, 'default', 'updated', 'App\\Models\\Order', 'updated', 3, 'App\\Models\\User', 1, '{\"attributes\":{\"billing_address_id\":6},\"old\":{\"billing_address_id\":null}}', NULL, '2025-04-09 16:49:53', '2025-04-09 16:49:53'),
(23, 'default', 'created', 'App\\Models\\Company', 'created', 1, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":1,\"legal_name\":\"Estlo\",\"tax_number\":\"2423423\",\"website\":null,\"email\":\"Estlo@gmail.com\",\"phone_number\":\"24235432\",\"logo\":null,\"is_active\":true,\"meta\":null,\"created_at\":\"2025-04-09T17:20:03.000000Z\",\"updated_at\":\"2025-04-09T17:20:03.000000Z\",\"deleted_at\":null}}', NULL, '2025-04-09 17:20:03', '2025-04-09 17:20:03'),
(24, 'default', 'created', 'App\\Models\\Tax', 'created', 1, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":1,\"name_en\":\"VAT\",\"name_ar\":\"\\u0636\\u0631\\u064a\\u0628\\u0629 \\u0627\\u0644\\u0642\\u064a\\u0645\\u0629 \\u0627\\u0644\\u0645\\u0636\\u0627\\u0641\\u0629\",\"type\":\"percentage\",\"amount\":\"15.00\",\"company_id\":1,\"is_active\":1,\"created_at\":\"2025-04-09T17:21:04.000000Z\",\"updated_at\":\"2025-04-09T17:21:04.000000Z\",\"deleted_at\":null}}', NULL, '2025-04-09 17:21:04', '2025-04-09 17:21:04'),
(25, 'default', 'created', 'App\\Models\\Tax', 'created', 2, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":2,\"name_en\":\"Service Tax\",\"name_ar\":\"\\u0636\\u0631\\u064a\\u0628\\u0629 \\u0627\\u0644\\u062e\\u062f\\u0645\\u0629\",\"type\":\"percentage\",\"amount\":\"10.00\",\"company_id\":1,\"is_active\":1,\"created_at\":\"2025-04-09T17:21:43.000000Z\",\"updated_at\":\"2025-04-09T17:21:43.000000Z\",\"deleted_at\":null}}', NULL, '2025-04-09 17:21:43', '2025-04-09 17:21:43'),
(26, 'default', 'created', 'App\\Models\\Tax', 'created', 3, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":3,\"name_en\":\"Comission\",\"name_ar\":\"\\u0639\\u0645\\u0648\\u0644\\u0629\",\"type\":\"fixed\",\"amount\":\"100.00\",\"company_id\":1,\"is_active\":1,\"created_at\":\"2025-04-09T17:22:31.000000Z\",\"updated_at\":\"2025-04-09T17:22:31.000000Z\",\"deleted_at\":null}}', NULL, '2025-04-09 17:22:31', '2025-04-09 17:22:31'),
(27, 'default', 'deleted', 'App\\Models\\Product', 'deleted', 1, 'App\\Models\\User', 1, '{\"old\":{\"id\":1,\"name_en\":\"Pepsi\",\"name_ar\":\"\\u0628\\u064a\\u0628\\u0633\\u064a\",\"description_en\":\"Pepsi\",\"description_ar\":null,\"slug\":\"bybsy\",\"sku\":null,\"code\":null,\"price\":2,\"sale_price\":22,\"currency_id\":1,\"product_category_id\":1,\"point_of_sale_id\":null,\"image_url\":null,\"is_active\":true,\"created_at\":\"2025-04-09T16:36:49.000000Z\",\"updated_at\":\"2025-04-09T17:22:59.000000Z\",\"deleted_at\":\"2025-04-09T17:22:59.000000Z\"}}', NULL, '2025-04-09 17:22:59', '2025-04-09 17:22:59'),
(28, 'default', 'updated', 'App\\Models\\ProductCategory', 'updated', 1, 'App\\Models\\User', 1, '{\"attributes\":{\"company_id\":1,\"updated_at\":\"2025-04-09T18:07:32.000000Z\"},\"old\":{\"company_id\":null,\"updated_at\":\"2025-04-09T16:36:18.000000Z\"}}', NULL, '2025-04-09 18:07:32', '2025-04-09 18:07:32'),
(29, 'default', 'created', 'App\\Models\\Product', 'created', 2, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":2,\"company_id\":1,\"name_en\":\"Pepsi\",\"name_ar\":\"\\u0628\\u064a\\u0628\\u0633\\u064a\",\"description_en\":\"pepsi\",\"description_ar\":\"\\u0628\\u064a\\u0628\\u0633\\u064a ... \\u0628\\u064a\\u0628\\u0633\\u064a (\\u0628\\u0627\\u0644\\u0625\\u0646\\u062c\\u0644\\u064a\\u0632\\u064a\\u0629: Pepsi)\\u200f \\u0647\\u0648 \\u0645\\u0634\\u0631\\u0648\\u0628 \\u063a\\u0627\\u0632\\u064a \\u0645\\u0643\\u0631\\u0628\\u0646 \\u062a\\u0635\\u0646\\u0639\\u0647 \\u0634\\u0631\\u0643\\u0629 \\u0628\\u064a\\u0628\\u0633\\u064a\\u0643\\u0648 (\\u062d\\u0627\\u0644\\u064a\\u064b\\u0651\\u0627). ... \\u0648\\u064a\\u0631\\u062c\\u0639 \\u0625\\u0646\\u0634\\u0627\\u0624\\u0647 \\u0648\\u062a\\u0637\\u0648\\u064a\\u0631\\u0647 \\u0641\\u064a \\u0627\\u0644\\u0623\\u0635\\u0644 \\u0625\\u0644\\u0649 \\u0639\\u0627\\u0645 1893 \\u0639\\u0644\\u0649 \\u064a\\u062f \\u0627\\u0644\\u0635\\u064a\\u062f\\u0644\\u0627\\u0646\\u064a \\u0643\\u0627\\u0644\\u064a\\u0628 \\u0628\\u0631\\u0627\\u062f\\u0647\\u0627\\u0645\\u060c ...\\n\",\"slug\":\"bybsy\",\"sku\":\"23423\",\"code\":\"1231\",\"price\":2,\"sale_price\":2.5,\"currency_id\":1,\"product_category_id\":1,\"point_of_sale_id\":null,\"image_url\":null,\"is_active\":true,\"created_at\":\"2025-04-09T18:31:55.000000Z\",\"updated_at\":\"2025-04-09T18:31:55.000000Z\",\"deleted_at\":null}}', NULL, '2025-04-09 18:31:55', '2025-04-09 18:31:55'),
(30, 'default', 'updated', 'App\\Models\\OrderItem', 'updated', 3, 'App\\Models\\User', 1, '{\"attributes\":{\"product_description_en\":\"pepsi\",\"product_description_ar\":\"\\u0628\\u064a\\u0628\\u0633\\u064a ... \\u0628\\u064a\\u0628\\u0633\\u064a (\\u0628\\u0627\\u0644\\u0625\\u0646\\u062c\\u0644\\u064a\\u0632\\u064a\\u0629: Pepsi)\\u200f \\u0647\\u0648 \\u0645\\u0634\\u0631\\u0648\\u0628 \\u063a\\u0627\\u0632\\u064a \\u0645\\u0643\\u0631\\u0628\\u0646 \\u062a\\u0635\\u0646\\u0639\\u0647 \\u0634\\u0631\\u0643\\u0629 \\u0628\\u064a\\u0628\\u0633\\u064a\\u0643\\u0648 (\\u062d\\u0627\\u0644\\u064a\\u064b\\u0651\\u0627). ... \\u0648\\u064a\\u0631\\u062c\\u0639 \\u0625\\u0646\\u0634\\u0627\\u0624\\u0647 \\u0648\\u062a\\u0637\\u0648\\u064a\\u0631\\u0647 \\u0641\\u064a \\u0627\\u0644\\u0623\\u0635\\u0644 \\u0625\\u0644\\u0649 \\u0639\\u0627\\u0645 1893 \\u0639\\u0644\\u0649 \\u064a\\u062f \\u0627\\u0644\\u0635\\u064a\\u062f\\u0644\\u0627\\u0646\\u064a \\u0643\\u0627\\u0644\\u064a\\u0628 \\u0628\\u0631\\u0627\\u062f\\u0647\\u0627\\u0645\\u060c ...\\n\",\"product_sku\":\"23423\",\"product_id\":2},\"old\":{\"product_description_en\":\"Pepsi\",\"product_description_ar\":null,\"product_sku\":null,\"product_id\":null}}', NULL, '2025-04-09 18:43:32', '2025-04-09 18:43:32'),
(31, 'default', 'deleted', 'App\\Models\\OrderItem', 'deleted', 3, 'App\\Models\\User', 1, '{\"old\":{\"order_id\":3,\"product_name_en\":\"Pepsi\",\"product_name_ar\":\"\\u0628\\u064a\\u0628\\u0633\\u064a\",\"product_description_en\":\"pepsi\",\"product_description_ar\":\"\\u0628\\u064a\\u0628\\u0633\\u064a ... \\u0628\\u064a\\u0628\\u0633\\u064a (\\u0628\\u0627\\u0644\\u0625\\u0646\\u062c\\u0644\\u064a\\u0632\\u064a\\u0629: Pepsi)\\u200f \\u0647\\u0648 \\u0645\\u0634\\u0631\\u0648\\u0628 \\u063a\\u0627\\u0632\\u064a \\u0645\\u0643\\u0631\\u0628\\u0646 \\u062a\\u0635\\u0646\\u0639\\u0647 \\u0634\\u0631\\u0643\\u0629 \\u0628\\u064a\\u0628\\u0633\\u064a\\u0643\\u0648 (\\u062d\\u0627\\u0644\\u064a\\u064b\\u0651\\u0627). ... \\u0648\\u064a\\u0631\\u062c\\u0639 \\u0625\\u0646\\u0634\\u0627\\u0624\\u0647 \\u0648\\u062a\\u0637\\u0648\\u064a\\u0631\\u0647 \\u0641\\u064a \\u0627\\u0644\\u0623\\u0635\\u0644 \\u0625\\u0644\\u0649 \\u0639\\u0627\\u0645 1893 \\u0639\\u0644\\u0649 \\u064a\\u062f \\u0627\\u0644\\u0635\\u064a\\u062f\\u0644\\u0627\\u0646\\u064a \\u0643\\u0627\\u0644\\u064a\\u0628 \\u0628\\u0631\\u0627\\u062f\\u0647\\u0627\\u0645\\u060c ...\\n\",\"product_sku\":\"23423\",\"product_code\":null,\"product_id\":2,\"quantity\":1,\"unit_price\":2,\"tax_id\":null,\"tax_amount\":null,\"discount_amount\":0,\"total_price\":2}}', NULL, '2025-04-09 18:43:53', '2025-04-09 18:43:53'),
(32, 'default', 'created', 'App\\Models\\OrderItem', 'created', 4, 'App\\Models\\User', 1, '{\"attributes\":{\"order_id\":3,\"product_name_en\":\"Pepsi\",\"product_name_ar\":\"\\u0628\\u064a\\u0628\\u0633\\u064a\",\"product_description_en\":\"pepsi\",\"product_description_ar\":\"\\u0628\\u064a\\u0628\\u0633\\u064a ... \\u0628\\u064a\\u0628\\u0633\\u064a (\\u0628\\u0627\\u0644\\u0625\\u0646\\u062c\\u0644\\u064a\\u0632\\u064a\\u0629: Pepsi)\\u200f \\u0647\\u0648 \\u0645\\u0634\\u0631\\u0648\\u0628 \\u063a\\u0627\\u0632\\u064a \\u0645\\u0643\\u0631\\u0628\\u0646 \\u062a\\u0635\\u0646\\u0639\\u0647 \\u0634\\u0631\\u0643\\u0629 \\u0628\\u064a\\u0628\\u0633\\u064a\\u0643\\u0648 (\\u062d\\u0627\\u0644\\u064a\\u064b\\u0651\\u0627). ... \\u0648\\u064a\\u0631\\u062c\\u0639 \\u0625\\u0646\\u0634\\u0627\\u0624\\u0647 \\u0648\\u062a\\u0637\\u0648\\u064a\\u0631\\u0647 \\u0641\\u064a \\u0627\\u0644\\u0623\\u0635\\u0644 \\u0625\\u0644\\u0649 \\u0639\\u0627\\u0645 1893 \\u0639\\u0644\\u0649 \\u064a\\u062f \\u0627\\u0644\\u0635\\u064a\\u062f\\u0644\\u0627\\u0646\\u064a \\u0643\\u0627\\u0644\\u064a\\u0628 \\u0628\\u0631\\u0627\\u062f\\u0647\\u0627\\u0645\\u060c ...\\n\",\"product_sku\":\"23423\",\"product_code\":null,\"product_id\":2,\"quantity\":1,\"unit_price\":3,\"tax_id\":null,\"tax_amount\":null,\"discount_amount\":0,\"total_price\":3}}', NULL, '2025-04-09 18:43:54', '2025-04-09 18:43:54'),
(33, 'default', 'updated', 'App\\Models\\Order', 'updated', 3, 'App\\Models\\User', 1, '{\"attributes\":{\"shipping_fee\":0,\"subtotal\":0,\"tax\":0},\"old\":{\"shipping_fee\":22,\"subtotal\":22,\"tax\":32}}', NULL, '2025-04-09 18:44:28', '2025-04-09 18:44:28'),
(34, 'default', 'created', 'App\\Models\\OrderItem', 'created', 5, 'App\\Models\\User', 1, '{\"attributes\":{\"order_id\":3,\"product_name_en\":\"Pepsi\",\"product_name_ar\":\"\\u0628\\u064a\\u0628\\u0633\\u064a\",\"product_description_en\":\"pepsi\",\"product_description_ar\":\"\\u0628\\u064a\\u0628\\u0633\\u064a ... \\u0628\\u064a\\u0628\\u0633\\u064a (\\u0628\\u0627\\u0644\\u0625\\u0646\\u062c\\u0644\\u064a\\u0632\\u064a\\u0629: Pepsi)\\u200f \\u0647\\u0648 \\u0645\\u0634\\u0631\\u0648\\u0628 \\u063a\\u0627\\u0632\\u064a \\u0645\\u0643\\u0631\\u0628\\u0646 \\u062a\\u0635\\u0646\\u0639\\u0647 \\u0634\\u0631\\u0643\\u0629 \\u0628\\u064a\\u0628\\u0633\\u064a\\u0643\\u0648 (\\u062d\\u0627\\u0644\\u064a\\u064b\\u0651\\u0627). ... \\u0648\\u064a\\u0631\\u062c\\u0639 \\u0625\\u0646\\u0634\\u0627\\u0624\\u0647 \\u0648\\u062a\\u0637\\u0648\\u064a\\u0631\\u0647 \\u0641\\u064a \\u0627\\u0644\\u0623\\u0635\\u0644 \\u0625\\u0644\\u0649 \\u0639\\u0627\\u0645 1893 \\u0639\\u0644\\u0649 \\u064a\\u062f \\u0627\\u0644\\u0635\\u064a\\u062f\\u0644\\u0627\\u0646\\u064a \\u0643\\u0627\\u0644\\u064a\\u0628 \\u0628\\u0631\\u0627\\u062f\\u0647\\u0627\\u0645\\u060c ...\\n\",\"product_sku\":\"23423\",\"product_code\":null,\"product_id\":2,\"quantity\":1,\"unit_price\":3,\"tax_id\":null,\"tax_amount\":null,\"discount_amount\":0,\"total_price\":3}}', NULL, '2025-04-09 18:45:07', '2025-04-09 18:45:07'),
(35, 'default', 'deleted', 'App\\Models\\OrderItem', 'deleted', 4, 'App\\Models\\User', 1, '{\"old\":{\"order_id\":3,\"product_name_en\":\"Pepsi\",\"product_name_ar\":\"\\u0628\\u064a\\u0628\\u0633\\u064a\",\"product_description_en\":\"pepsi\",\"product_description_ar\":\"\\u0628\\u064a\\u0628\\u0633\\u064a ... \\u0628\\u064a\\u0628\\u0633\\u064a (\\u0628\\u0627\\u0644\\u0625\\u0646\\u062c\\u0644\\u064a\\u0632\\u064a\\u0629: Pepsi)\\u200f \\u0647\\u0648 \\u0645\\u0634\\u0631\\u0648\\u0628 \\u063a\\u0627\\u0632\\u064a \\u0645\\u0643\\u0631\\u0628\\u0646 \\u062a\\u0635\\u0646\\u0639\\u0647 \\u0634\\u0631\\u0643\\u0629 \\u0628\\u064a\\u0628\\u0633\\u064a\\u0643\\u0648 (\\u062d\\u0627\\u0644\\u064a\\u064b\\u0651\\u0627). ... \\u0648\\u064a\\u0631\\u062c\\u0639 \\u0625\\u0646\\u0634\\u0627\\u0624\\u0647 \\u0648\\u062a\\u0637\\u0648\\u064a\\u0631\\u0647 \\u0641\\u064a \\u0627\\u0644\\u0623\\u0635\\u0644 \\u0625\\u0644\\u0649 \\u0639\\u0627\\u0645 1893 \\u0639\\u0644\\u0649 \\u064a\\u062f \\u0627\\u0644\\u0635\\u064a\\u062f\\u0644\\u0627\\u0646\\u064a \\u0643\\u0627\\u0644\\u064a\\u0628 \\u0628\\u0631\\u0627\\u062f\\u0647\\u0627\\u0645\\u060c ...\\n\",\"product_sku\":\"23423\",\"product_code\":null,\"product_id\":2,\"quantity\":1,\"unit_price\":0.03,\"tax_id\":null,\"tax_amount\":null,\"discount_amount\":0,\"total_price\":0.03}}', NULL, '2025-04-09 18:49:46', '2025-04-09 18:49:46'),
(36, 'default', 'deleted', 'App\\Models\\OrderItem', 'deleted', 5, 'App\\Models\\User', 1, '{\"old\":{\"order_id\":3,\"product_name_en\":\"Pepsi\",\"product_name_ar\":\"\\u0628\\u064a\\u0628\\u0633\\u064a\",\"product_description_en\":\"pepsi\",\"product_description_ar\":\"\\u0628\\u064a\\u0628\\u0633\\u064a ... \\u0628\\u064a\\u0628\\u0633\\u064a (\\u0628\\u0627\\u0644\\u0625\\u0646\\u062c\\u0644\\u064a\\u0632\\u064a\\u0629: Pepsi)\\u200f \\u0647\\u0648 \\u0645\\u0634\\u0631\\u0648\\u0628 \\u063a\\u0627\\u0632\\u064a \\u0645\\u0643\\u0631\\u0628\\u0646 \\u062a\\u0635\\u0646\\u0639\\u0647 \\u0634\\u0631\\u0643\\u0629 \\u0628\\u064a\\u0628\\u0633\\u064a\\u0643\\u0648 (\\u062d\\u0627\\u0644\\u064a\\u064b\\u0651\\u0627). ... \\u0648\\u064a\\u0631\\u062c\\u0639 \\u0625\\u0646\\u0634\\u0627\\u0624\\u0647 \\u0648\\u062a\\u0637\\u0648\\u064a\\u0631\\u0647 \\u0641\\u064a \\u0627\\u0644\\u0623\\u0635\\u0644 \\u0625\\u0644\\u0649 \\u0639\\u0627\\u0645 1893 \\u0639\\u0644\\u0649 \\u064a\\u062f \\u0627\\u0644\\u0635\\u064a\\u062f\\u0644\\u0627\\u0646\\u064a \\u0643\\u0627\\u0644\\u064a\\u0628 \\u0628\\u0631\\u0627\\u062f\\u0647\\u0627\\u0645\\u060c ...\\n\",\"product_sku\":\"23423\",\"product_code\":null,\"product_id\":2,\"quantity\":1,\"unit_price\":0.03,\"tax_id\":null,\"tax_amount\":null,\"discount_amount\":0,\"total_price\":0.03}}', NULL, '2025-04-09 18:49:46', '2025-04-09 18:49:46'),
(37, 'default', 'created', 'App\\Models\\OrderItem', 'created', 6, 'App\\Models\\User', 1, '{\"attributes\":{\"order_id\":3,\"product_name_en\":\"Pepsi\",\"product_name_ar\":\"\\u0628\\u064a\\u0628\\u0633\\u064a\",\"product_description_en\":\"pepsi\",\"product_description_ar\":\"\\u0628\\u064a\\u0628\\u0633\\u064a ... \\u0628\\u064a\\u0628\\u0633\\u064a (\\u0628\\u0627\\u0644\\u0625\\u0646\\u062c\\u0644\\u064a\\u0632\\u064a\\u0629: Pepsi)\\u200f \\u0647\\u0648 \\u0645\\u0634\\u0631\\u0648\\u0628 \\u063a\\u0627\\u0632\\u064a \\u0645\\u0643\\u0631\\u0628\\u0646 \\u062a\\u0635\\u0646\\u0639\\u0647 \\u0634\\u0631\\u0643\\u0629 \\u0628\\u064a\\u0628\\u0633\\u064a\\u0643\\u0648 (\\u062d\\u0627\\u0644\\u064a\\u064b\\u0651\\u0627). ... \\u0648\\u064a\\u0631\\u062c\\u0639 \\u0625\\u0646\\u0634\\u0627\\u0624\\u0647 \\u0648\\u062a\\u0637\\u0648\\u064a\\u0631\\u0647 \\u0641\\u064a \\u0627\\u0644\\u0623\\u0635\\u0644 \\u0625\\u0644\\u0649 \\u0639\\u0627\\u0645 1893 \\u0639\\u0644\\u0649 \\u064a\\u062f \\u0627\\u0644\\u0635\\u064a\\u062f\\u0644\\u0627\\u0646\\u064a \\u0643\\u0627\\u0644\\u064a\\u0628 \\u0628\\u0631\\u0627\\u062f\\u0647\\u0627\\u0645\\u060c ...\\n\",\"product_sku\":\"23423\",\"product_code\":null,\"product_id\":2,\"quantity\":2,\"unit_price\":2.5,\"tax_id\":null,\"tax_amount\":null,\"discount_amount\":0,\"total_price\":5}}', NULL, '2025-04-09 18:49:46', '2025-04-09 18:49:46'),
(38, 'default', 'deleted', 'App\\Models\\OrderItem', 'deleted', 6, 'App\\Models\\User', 1, '{\"old\":{\"order_id\":3,\"product_name_en\":\"Pepsi\",\"product_name_ar\":\"\\u0628\\u064a\\u0628\\u0633\\u064a\",\"product_description_en\":\"pepsi\",\"product_description_ar\":\"\\u0628\\u064a\\u0628\\u0633\\u064a ... \\u0628\\u064a\\u0628\\u0633\\u064a (\\u0628\\u0627\\u0644\\u0625\\u0646\\u062c\\u0644\\u064a\\u0632\\u064a\\u0629: Pepsi)\\u200f \\u0647\\u0648 \\u0645\\u0634\\u0631\\u0648\\u0628 \\u063a\\u0627\\u0632\\u064a \\u0645\\u0643\\u0631\\u0628\\u0646 \\u062a\\u0635\\u0646\\u0639\\u0647 \\u0634\\u0631\\u0643\\u0629 \\u0628\\u064a\\u0628\\u0633\\u064a\\u0643\\u0648 (\\u062d\\u0627\\u0644\\u064a\\u064b\\u0651\\u0627). ... \\u0648\\u064a\\u0631\\u062c\\u0639 \\u0625\\u0646\\u0634\\u0627\\u0624\\u0647 \\u0648\\u062a\\u0637\\u0648\\u064a\\u0631\\u0647 \\u0641\\u064a \\u0627\\u0644\\u0623\\u0635\\u0644 \\u0625\\u0644\\u0649 \\u0639\\u0627\\u0645 1893 \\u0639\\u0644\\u0649 \\u064a\\u062f \\u0627\\u0644\\u0635\\u064a\\u062f\\u0644\\u0627\\u0646\\u064a \\u0643\\u0627\\u0644\\u064a\\u0628 \\u0628\\u0631\\u0627\\u062f\\u0647\\u0627\\u0645\\u060c ...\\n\",\"product_sku\":\"23423\",\"product_code\":null,\"product_id\":2,\"quantity\":2,\"unit_price\":2.5,\"tax_id\":null,\"tax_amount\":null,\"discount_amount\":0,\"total_price\":5}}', NULL, '2025-04-09 18:50:17', '2025-04-09 18:50:17'),
(39, 'default', 'created', 'App\\Models\\OrderItem', 'created', 7, 'App\\Models\\User', 1, '{\"attributes\":{\"order_id\":3,\"product_name_en\":\"Pepsi\",\"product_name_ar\":\"\\u0628\\u064a\\u0628\\u0633\\u064a\",\"product_description_en\":\"pepsi\",\"product_description_ar\":\"\\u0628\\u064a\\u0628\\u0633\\u064a ... \\u0628\\u064a\\u0628\\u0633\\u064a (\\u0628\\u0627\\u0644\\u0625\\u0646\\u062c\\u0644\\u064a\\u0632\\u064a\\u0629: Pepsi)\\u200f \\u0647\\u0648 \\u0645\\u0634\\u0631\\u0648\\u0628 \\u063a\\u0627\\u0632\\u064a \\u0645\\u0643\\u0631\\u0628\\u0646 \\u062a\\u0635\\u0646\\u0639\\u0647 \\u0634\\u0631\\u0643\\u0629 \\u0628\\u064a\\u0628\\u0633\\u064a\\u0643\\u0648 (\\u062d\\u0627\\u0644\\u064a\\u064b\\u0651\\u0627). ... \\u0648\\u064a\\u0631\\u062c\\u0639 \\u0625\\u0646\\u0634\\u0627\\u0624\\u0647 \\u0648\\u062a\\u0637\\u0648\\u064a\\u0631\\u0647 \\u0641\\u064a \\u0627\\u0644\\u0623\\u0635\\u0644 \\u0625\\u0644\\u0649 \\u0639\\u0627\\u0645 1893 \\u0639\\u0644\\u0649 \\u064a\\u062f \\u0627\\u0644\\u0635\\u064a\\u062f\\u0644\\u0627\\u0646\\u064a \\u0643\\u0627\\u0644\\u064a\\u0628 \\u0628\\u0631\\u0627\\u062f\\u0647\\u0627\\u0645\\u060c ...\\n\",\"product_sku\":\"23423\",\"product_code\":null,\"product_id\":2,\"quantity\":1,\"unit_price\":2.5,\"tax_id\":null,\"tax_amount\":null,\"discount_amount\":0,\"total_price\":2.5}}', NULL, '2025-04-09 18:50:17', '2025-04-09 18:50:17'),
(40, 'default', 'updated', 'App\\Models\\Order', 'updated', 3, 'App\\Models\\User', 1, '{\"attributes\":{\"shipping_fee\":1,\"tax\":1},\"old\":{\"shipping_fee\":0,\"tax\":0}}', NULL, '2025-04-09 18:51:36', '2025-04-09 18:51:36'),
(41, 'default', 'updated', 'App\\Models\\OrderItem', 'updated', 7, 'App\\Models\\User', 1, '{\"attributes\":{\"unit_price\":3.5,\"total_price\":3.5},\"old\":{\"unit_price\":2.5,\"total_price\":2.5}}', NULL, '2025-04-09 18:54:35', '2025-04-09 18:54:35'),
(42, 'default', 'updated', 'App\\Models\\Order', 'updated', 3, 'App\\Models\\User', 1, '{\"attributes\":{\"shipping_fee\":3},\"old\":{\"shipping_fee\":1}}', NULL, '2025-04-09 18:54:35', '2025-04-09 18:54:35'),
(43, 'default', 'deleted', 'App\\Models\\OrderItem', 'deleted', 7, 'App\\Models\\User', 1, '{\"old\":{\"order_id\":3,\"product_name_en\":\"Pepsi\",\"product_name_ar\":\"\\u0628\\u064a\\u0628\\u0633\\u064a\",\"product_description_en\":\"pepsi\",\"product_description_ar\":\"\\u0628\\u064a\\u0628\\u0633\\u064a ... \\u0628\\u064a\\u0628\\u0633\\u064a (\\u0628\\u0627\\u0644\\u0625\\u0646\\u062c\\u0644\\u064a\\u0632\\u064a\\u0629: Pepsi)\\u200f \\u0647\\u0648 \\u0645\\u0634\\u0631\\u0648\\u0628 \\u063a\\u0627\\u0632\\u064a \\u0645\\u0643\\u0631\\u0628\\u0646 \\u062a\\u0635\\u0646\\u0639\\u0647 \\u0634\\u0631\\u0643\\u0629 \\u0628\\u064a\\u0628\\u0633\\u064a\\u0643\\u0648 (\\u062d\\u0627\\u0644\\u064a\\u064b\\u0651\\u0627). ... \\u0648\\u064a\\u0631\\u062c\\u0639 \\u0625\\u0646\\u0634\\u0627\\u0624\\u0647 \\u0648\\u062a\\u0637\\u0648\\u064a\\u0631\\u0647 \\u0641\\u064a \\u0627\\u0644\\u0623\\u0635\\u0644 \\u0625\\u0644\\u0649 \\u0639\\u0627\\u0645 1893 \\u0639\\u0644\\u0649 \\u064a\\u062f \\u0627\\u0644\\u0635\\u064a\\u062f\\u0644\\u0627\\u0646\\u064a \\u0643\\u0627\\u0644\\u064a\\u0628 \\u0628\\u0631\\u0627\\u062f\\u0647\\u0627\\u0645\\u060c ...\\n\",\"product_sku\":\"23423\",\"product_code\":null,\"product_id\":2,\"quantity\":1,\"unit_price\":3.5,\"tax_id\":null,\"tax_amount\":null,\"discount_amount\":0,\"total_price\":3.5}}', NULL, '2025-04-09 18:55:14', '2025-04-09 18:55:14'),
(44, 'default', 'created', 'App\\Models\\OrderItem', 'created', 8, 'App\\Models\\User', 1, '{\"attributes\":{\"order_id\":3,\"product_name_en\":\"Pepsi\",\"product_name_ar\":\"\\u0628\\u064a\\u0628\\u0633\\u064a\",\"product_description_en\":\"pepsi\",\"product_description_ar\":\"\\u0628\\u064a\\u0628\\u0633\\u064a ... \\u0628\\u064a\\u0628\\u0633\\u064a (\\u0628\\u0627\\u0644\\u0625\\u0646\\u062c\\u0644\\u064a\\u0632\\u064a\\u0629: Pepsi)\\u200f \\u0647\\u0648 \\u0645\\u0634\\u0631\\u0648\\u0628 \\u063a\\u0627\\u0632\\u064a \\u0645\\u0643\\u0631\\u0628\\u0646 \\u062a\\u0635\\u0646\\u0639\\u0647 \\u0634\\u0631\\u0643\\u0629 \\u0628\\u064a\\u0628\\u0633\\u064a\\u0643\\u0648 (\\u062d\\u0627\\u0644\\u064a\\u064b\\u0651\\u0627). ... \\u0648\\u064a\\u0631\\u062c\\u0639 \\u0625\\u0646\\u0634\\u0627\\u0624\\u0647 \\u0648\\u062a\\u0637\\u0648\\u064a\\u0631\\u0647 \\u0641\\u064a \\u0627\\u0644\\u0623\\u0635\\u0644 \\u0625\\u0644\\u0649 \\u0639\\u0627\\u0645 1893 \\u0639\\u0644\\u0649 \\u064a\\u062f \\u0627\\u0644\\u0635\\u064a\\u062f\\u0644\\u0627\\u0646\\u064a \\u0643\\u0627\\u0644\\u064a\\u0628 \\u0628\\u0631\\u0627\\u062f\\u0647\\u0627\\u0645\\u060c ...\\n\",\"product_sku\":\"23423\",\"product_code\":null,\"product_id\":2,\"quantity\":1,\"unit_price\":2.5,\"tax_id\":null,\"tax_amount\":null,\"discount_amount\":0,\"total_price\":2.5}}', NULL, '2025-04-09 18:55:14', '2025-04-09 18:55:14'),
(45, 'default', 'updated', 'App\\Models\\Order', 'updated', 3, 'App\\Models\\User', 1, '{\"attributes\":{\"shipping_fee\":1},\"old\":{\"shipping_fee\":3}}', NULL, '2025-04-09 18:55:14', '2025-04-09 18:55:14'),
(46, 'default', 'created', 'App\\Models\\ProductCategory', 'created', 2, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":2,\"company_id\":1,\"name_en\":\"Fast food\",\"name_ar\":\"\\u0627\\u0644\\u0648\\u062c\\u0628\\u0627\\u062a \\u0627\\u0644\\u0633\\u0631\\u064a\\u0639\\u0629\",\"description_en\":\"<p>Fast food<\\/p>\",\"description_ar\":\"<p dir=\\\"rtl\\\">\\u0635\\u062d\\u064a\\u064b\\u0627: \\u062a\\u0639\\u0631\\u0641 \\u0627\\u0644\\u0648\\u062c\\u0628\\u0629 \\u0627\\u0644\\u0633\\u0631\\u064a\\u0639\\u0629 \\u0628\\u0623\\u0646\\u0647\\u0627 <strong><em>\\u0627\\u0644\\u0648\\u062c\\u0628\\u0629 \\u0627\\u0644\\u062a\\u064a \\u062a\\u062d\\u062a\\u0648\\u064a \\u0639\\u0644\\u0649 \\u0623\\u0637\\u0639\\u0645\\u0629 \\u0633\\u0631\\u064a\\u0639\\u0629 \\u0627\\u0644\\u062a\\u062d\\u0636\\u064a\\u0631<\\/em><\\/strong>\\u060c \\u0645\\u062b\\u0644: \\u0634\\u0637\\u0627\\u0626\\u0631 \\u0627\\u0644\\u0634\\u0627\\u0648\\u0631\\u0645\\u0627 \\u0648\\u0627\\u0644\\u0628\\u0631\\u062c\\u0631 \\u0648\\u0627\\u0644\\u0641\\u0644\\u0627\\u0641\\u0644 \\u0648\\u0627\\u0644\\u0641\\u0637\\u0627\\u0626\\u0631 \\u0648\\u0627\\u0644\\u0628\\u064a\\u062a\\u0632\\u0627\\u060c \\u0648\\u0642\\u0637\\u0639 \\u0627\\u0644\\u062f\\u062c\\u0627\\u062c \\u0627\\u0644\\u0645\\u0642\\u0644\\u064a\\u0629\\u060c \\u0645\\u0639 \\u0645\\u0634\\u0631\\u0648 ...<\\/p><p><a href=\\\"https:\\/\\/ar.wikipedia.org\\/wiki\\/%D9%88%D8%AC%D8%A8%D8%A9_%D8%B3%D8%B1%D9%8A%D8%B9%D8%A9\\\"><br><\\/a><br><\\/p>\",\"slug\":\"fast-food\",\"parent_id\":null,\"is_active\":1,\"created_at\":\"2025-04-09T19:00:55.000000Z\",\"updated_at\":\"2025-04-09T19:00:55.000000Z\",\"deleted_at\":null}}', NULL, '2025-04-09 19:00:55', '2025-04-09 19:00:55'),
(47, 'default', 'updated', 'App\\Models\\Tax', 'updated', 2, 'App\\Models\\User', 1, '{\"attributes\":{\"name_en\":\"Service \",\"updated_at\":\"2025-04-09T19:10:54.000000Z\"},\"old\":{\"name_en\":\"Service Tax\",\"updated_at\":\"2025-04-09T17:21:43.000000Z\"}}', NULL, '2025-04-09 19:10:54', '2025-04-09 19:10:54'),
(48, 'default', 'created', 'App\\Models\\Product', 'created', 3, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":3,\"company_id\":1,\"name_en\":\"Coke\",\"name_ar\":\"Coke\",\"description_en\":null,\"description_ar\":\"Coke\",\"slug\":\"coke\",\"sku\":\"32\",\"code\":\"342\",\"price\":3,\"sale_price\":3.45,\"currency_id\":1,\"product_category_id\":1,\"point_of_sale_id\":null,\"image_url\":null,\"is_active\":true,\"created_at\":\"2025-04-09T19:35:39.000000Z\",\"updated_at\":\"2025-04-09T19:35:39.000000Z\",\"deleted_at\":null}}', NULL, '2025-04-09 19:35:39', '2025-04-09 19:35:39'),
(49, 'default', 'deleted', 'App\\Models\\Product', 'deleted', 3, 'App\\Models\\User', 1, '{\"old\":{\"id\":3,\"company_id\":1,\"name_en\":\"Coke\",\"name_ar\":\"Coke\",\"description_en\":null,\"description_ar\":\"Coke\",\"slug\":\"coke\",\"sku\":\"32\",\"code\":\"342\",\"price\":3,\"sale_price\":3.45,\"currency_id\":1,\"product_category_id\":1,\"point_of_sale_id\":null,\"image_url\":null,\"is_active\":true,\"created_at\":\"2025-04-09T19:35:39.000000Z\",\"updated_at\":\"2025-04-09T19:38:21.000000Z\",\"deleted_at\":\"2025-04-09T19:38:21.000000Z\"}}', NULL, '2025-04-09 19:38:21', '2025-04-09 19:38:21'),
(50, 'default', 'created', 'App\\Models\\Product', 'created', 4, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":4,\"company_id\":1,\"name_en\":\"coke\",\"name_ar\":\"coke\",\"description_en\":null,\"description_ar\":null,\"slug\":\"coke-2\",\"sku\":\"coke\",\"code\":null,\"price\":3,\"sale_price\":3.45,\"currency_id\":1,\"product_category_id\":1,\"point_of_sale_id\":null,\"image_url\":null,\"is_active\":true,\"created_at\":\"2025-04-09T19:41:24.000000Z\",\"updated_at\":\"2025-04-09T19:41:24.000000Z\",\"deleted_at\":null}}', NULL, '2025-04-09 19:41:24', '2025-04-09 19:41:24'),
(51, 'default', 'deleted', 'App\\Models\\Product', 'deleted', 4, 'App\\Models\\User', 1, '{\"old\":{\"id\":4,\"company_id\":1,\"name_en\":\"coke\",\"name_ar\":\"coke\",\"description_en\":null,\"description_ar\":null,\"slug\":\"coke-2\",\"sku\":\"coke\",\"code\":null,\"price\":3,\"sale_price\":3.45,\"currency_id\":1,\"product_category_id\":1,\"point_of_sale_id\":null,\"image_url\":null,\"is_active\":true,\"created_at\":\"2025-04-09T19:41:24.000000Z\",\"updated_at\":\"2025-04-09T19:41:46.000000Z\",\"deleted_at\":\"2025-04-09T19:41:46.000000Z\"}}', NULL, '2025-04-09 19:41:46', '2025-04-09 19:41:46'),
(52, 'default', 'created', 'App\\Models\\Product', 'created', 5, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":5,\"company_id\":1,\"name_en\":\"coke\",\"name_ar\":\"coke\",\"description_en\":null,\"description_ar\":null,\"slug\":\"coke3\",\"sku\":\"234\",\"code\":\"532\",\"price\":3,\"sale_price\":3.45,\"currency_id\":1,\"product_category_id\":1,\"point_of_sale_id\":null,\"image_url\":null,\"is_active\":true,\"created_at\":\"2025-04-09T19:42:29.000000Z\",\"updated_at\":\"2025-04-09T19:42:29.000000Z\",\"deleted_at\":null}}', NULL, '2025-04-09 19:42:29', '2025-04-09 19:42:29'),
(53, 'default', 'created', 'App\\Models\\Product', 'created', 6, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":6,\"company_id\":1,\"name_en\":\"Water\",\"name_ar\":\"Water\",\"description_en\":null,\"description_ar\":null,\"slug\":\"water\",\"sku\":\"Water\",\"code\":\"Water\",\"price\":3,\"sale_price\":3.45,\"currency_id\":1,\"product_category_id\":1,\"point_of_sale_id\":null,\"image_url\":null,\"is_active\":true,\"created_at\":\"2025-04-09T19:44:35.000000Z\",\"updated_at\":\"2025-04-09T19:44:35.000000Z\",\"deleted_at\":null}}', NULL, '2025-04-09 19:44:35', '2025-04-09 19:44:35'),
(54, 'default', 'updated', 'App\\Models\\Product', 'updated', 6, 'App\\Models\\User', 1, '{\"attributes\":{\"currency_id\":4,\"updated_at\":\"2025-04-09T19:46:25.000000Z\"},\"old\":{\"currency_id\":1,\"updated_at\":\"2025-04-09T19:44:35.000000Z\"}}', NULL, '2025-04-09 19:46:25', '2025-04-09 19:46:25'),
(55, 'default', 'updated', 'App\\Models\\Product', 'updated', 6, 'App\\Models\\User', 1, '{\"attributes\":{\"currency_id\":1,\"updated_at\":\"2025-04-09T19:46:36.000000Z\"},\"old\":{\"currency_id\":4,\"updated_at\":\"2025-04-09T19:46:25.000000Z\"}}', NULL, '2025-04-09 19:46:36', '2025-04-09 19:46:36'),
(56, 'default', 'created', 'App\\Models\\Product', 'created', 7, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":7,\"company_id\":1,\"name_en\":\"juice\",\"name_ar\":\"juice\",\"description_en\":null,\"description_ar\":\"juice\",\"slug\":\"juice\",\"sku\":\"fdsa\",\"code\":\"423\",\"price\":5,\"sale_price\":5.75,\"currency_id\":1,\"product_category_id\":1,\"point_of_sale_id\":null,\"image_url\":null,\"is_active\":true,\"created_at\":\"2025-04-09T19:51:16.000000Z\",\"updated_at\":\"2025-04-09T19:51:16.000000Z\",\"deleted_at\":null}}', NULL, '2025-04-09 19:51:16', '2025-04-09 19:51:16'),
(57, 'default', 'created', 'App\\Models\\Order', 'created', 4, 'App\\Models\\User', 1, '{\"attributes\":{\"number\":\"ORD-202504-3PMYMG\",\"customer_id\":1,\"user_id\":null,\"company_id\":null,\"order_status_id\":1,\"shipping_fee\":null,\"subtotal\":null,\"tax\":null,\"total\":null,\"payment_method_id\":4,\"currency_id\":1,\"billing_address_id\":null,\"shipping_address_id\":null,\"estimated_delivery_at\":null,\"delivered_at\":null,\"shipped_at\":null,\"meta\":[]}}', NULL, '2025-04-10 12:11:47', '2025-04-10 12:11:47'),
(58, 'default', 'created', 'App\\Models\\OrderItem', 'created', 9, 'App\\Models\\User', 1, '{\"attributes\":{\"order_id\":4,\"product_name_en\":\"juice\",\"product_name_ar\":\"juice\",\"product_description_en\":null,\"product_description_ar\":\"juice\",\"product_sku\":\"fdsa\",\"product_code\":null,\"product_id\":7,\"quantity\":1,\"unit_price\":5.75,\"tax_id\":null,\"tax_amount\":null,\"discount_amount\":0,\"total_price\":5.75}}', NULL, '2025-04-10 12:11:47', '2025-04-10 12:11:47'),
(59, 'default', 'created', 'App\\Models\\Address', 'created', 7, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":7,\"address_type_id\":1,\"addressable_type\":null,\"addressable_id\":null,\"street\":null,\"city\":null,\"state\":null,\"country\":null,\"postal_code\":null,\"country_id\":null,\"contact_person_full_name\":null,\"contact_person_phone\":null,\"latitude\":null,\"longitude\":null,\"details\":null,\"created_at\":\"2025-04-10T12:11:47.000000Z\",\"updated_at\":\"2025-04-10T12:11:47.000000Z\",\"deleted_at\":null}}', NULL, '2025-04-10 12:11:47', '2025-04-10 12:11:47'),
(60, 'default', 'updated', 'App\\Models\\Order', 'updated', 4, 'App\\Models\\User', 1, '{\"attributes\":{\"shipping_address_id\":7},\"old\":{\"shipping_address_id\":null}}', NULL, '2025-04-10 12:11:47', '2025-04-10 12:11:47'),
(61, 'default', 'created', 'App\\Models\\Address', 'created', 8, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":8,\"address_type_id\":2,\"addressable_type\":null,\"addressable_id\":null,\"street\":null,\"city\":null,\"state\":null,\"country\":null,\"postal_code\":null,\"country_id\":null,\"contact_person_full_name\":null,\"contact_person_phone\":null,\"latitude\":null,\"longitude\":null,\"details\":null,\"created_at\":\"2025-04-10T12:11:47.000000Z\",\"updated_at\":\"2025-04-10T12:11:47.000000Z\",\"deleted_at\":null}}', NULL, '2025-04-10 12:11:47', '2025-04-10 12:11:47'),
(62, 'default', 'updated', 'App\\Models\\Order', 'updated', 4, 'App\\Models\\User', 1, '{\"attributes\":{\"billing_address_id\":8},\"old\":{\"billing_address_id\":null}}', NULL, '2025-04-10 12:11:47', '2025-04-10 12:11:47'),
(63, 'default', 'created', 'App\\Models\\Order', 'created', 5, 'App\\Models\\User', 1, '{\"attributes\":{\"number\":\"ORD-202504-SNZXZN\",\"customer_id\":1,\"user_id\":null,\"company_id\":1,\"order_status_id\":1,\"shipping_fee\":null,\"subtotal\":null,\"tax\":null,\"total\":null,\"payment_method_id\":4,\"currency_id\":1,\"billing_address_id\":null,\"shipping_address_id\":null,\"estimated_delivery_at\":null,\"delivered_at\":null,\"shipped_at\":null,\"meta\":[]}}', NULL, '2025-04-10 12:32:56', '2025-04-10 12:32:56'),
(64, 'default', 'created', 'App\\Models\\OrderItem', 'created', 10, 'App\\Models\\User', 1, '{\"attributes\":{\"order_id\":5,\"product_name_en\":\"juice\",\"product_name_ar\":\"juice\",\"product_description_en\":null,\"product_description_ar\":\"juice\",\"product_sku\":\"fdsa\",\"product_code\":null,\"product_id\":7,\"quantity\":1,\"unit_price\":5,\"tax_id\":null,\"tax_amount\":null,\"discount_amount\":0,\"total_price\":5.75}}', NULL, '2025-04-10 12:32:56', '2025-04-10 12:32:56'),
(65, 'default', 'created', 'App\\Models\\OrderItem', 'created', 11, 'App\\Models\\User', 1, '{\"attributes\":{\"order_id\":5,\"product_name_en\":\"Pepsi\",\"product_name_ar\":\"\\u0628\\u064a\\u0628\\u0633\\u064a\",\"product_description_en\":\"pepsi\",\"product_description_ar\":\"\\u0628\\u064a\\u0628\\u0633\\u064a ... \\u0628\\u064a\\u0628\\u0633\\u064a (\\u0628\\u0627\\u0644\\u0625\\u0646\\u062c\\u0644\\u064a\\u0632\\u064a\\u0629: Pepsi)\\u200f \\u0647\\u0648 \\u0645\\u0634\\u0631\\u0648\\u0628 \\u063a\\u0627\\u0632\\u064a \\u0645\\u0643\\u0631\\u0628\\u0646 \\u062a\\u0635\\u0646\\u0639\\u0647 \\u0634\\u0631\\u0643\\u0629 \\u0628\\u064a\\u0628\\u0633\\u064a\\u0643\\u0648 (\\u062d\\u0627\\u0644\\u064a\\u064b\\u0651\\u0627). ... \\u0648\\u064a\\u0631\\u062c\\u0639 \\u0625\\u0646\\u0634\\u0627\\u0624\\u0647 \\u0648\\u062a\\u0637\\u0648\\u064a\\u0631\\u0647 \\u0641\\u064a \\u0627\\u0644\\u0623\\u0635\\u0644 \\u0625\\u0644\\u0649 \\u0639\\u0627\\u0645 1893 \\u0639\\u0644\\u0649 \\u064a\\u062f \\u0627\\u0644\\u0635\\u064a\\u062f\\u0644\\u0627\\u0646\\u064a \\u0643\\u0627\\u0644\\u064a\\u0628 \\u0628\\u0631\\u0627\\u062f\\u0647\\u0627\\u0645\\u060c ...\\n\",\"product_sku\":\"23423\",\"product_code\":null,\"product_id\":2,\"quantity\":2,\"unit_price\":2,\"tax_id\":null,\"tax_amount\":null,\"discount_amount\":0,\"total_price\":5}}', NULL, '2025-04-10 12:32:56', '2025-04-10 12:32:56'),
(66, 'default', 'created', 'App\\Models\\Address', 'created', 9, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":9,\"address_type_id\":1,\"addressable_type\":null,\"addressable_id\":null,\"street\":null,\"city\":null,\"state\":null,\"country\":null,\"postal_code\":null,\"country_id\":null,\"contact_person_full_name\":null,\"contact_person_phone\":null,\"latitude\":null,\"longitude\":null,\"details\":null,\"created_at\":\"2025-04-10T12:32:56.000000Z\",\"updated_at\":\"2025-04-10T12:32:56.000000Z\",\"deleted_at\":null}}', NULL, '2025-04-10 12:32:56', '2025-04-10 12:32:56'),
(67, 'default', 'updated', 'App\\Models\\Order', 'updated', 5, 'App\\Models\\User', 1, '{\"attributes\":{\"shipping_address_id\":9},\"old\":{\"shipping_address_id\":null}}', NULL, '2025-04-10 12:32:56', '2025-04-10 12:32:56'),
(68, 'default', 'created', 'App\\Models\\Address', 'created', 10, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":10,\"address_type_id\":2,\"addressable_type\":null,\"addressable_id\":null,\"street\":null,\"city\":null,\"state\":null,\"country\":null,\"postal_code\":null,\"country_id\":null,\"contact_person_full_name\":null,\"contact_person_phone\":null,\"latitude\":null,\"longitude\":null,\"details\":null,\"created_at\":\"2025-04-10T12:32:56.000000Z\",\"updated_at\":\"2025-04-10T12:32:56.000000Z\",\"deleted_at\":null}}', NULL, '2025-04-10 12:32:56', '2025-04-10 12:32:56'),
(69, 'default', 'updated', 'App\\Models\\Order', 'updated', 5, 'App\\Models\\User', 1, '{\"attributes\":{\"billing_address_id\":10},\"old\":{\"billing_address_id\":null}}', NULL, '2025-04-10 12:32:56', '2025-04-10 12:32:56'),
(70, 'default', 'deleted', 'App\\Models\\OrderItem', 'deleted', 10, 'App\\Models\\User', 1, '{\"old\":{\"order_id\":5,\"product_name_en\":\"juice\",\"product_name_ar\":\"juice\",\"product_description_en\":null,\"product_description_ar\":\"juice\",\"product_sku\":\"fdsa\",\"product_code\":null,\"product_id\":7,\"quantity\":1,\"unit_price\":5,\"tax_id\":null,\"tax_amount\":null,\"discount_amount\":0,\"total_price\":5.75}}', NULL, '2025-04-10 12:36:36', '2025-04-10 12:36:36'),
(71, 'default', 'deleted', 'App\\Models\\OrderItem', 'deleted', 11, 'App\\Models\\User', 1, '{\"old\":{\"order_id\":5,\"product_name_en\":\"Pepsi\",\"product_name_ar\":\"\\u0628\\u064a\\u0628\\u0633\\u064a\",\"product_description_en\":\"pepsi\",\"product_description_ar\":\"\\u0628\\u064a\\u0628\\u0633\\u064a ... \\u0628\\u064a\\u0628\\u0633\\u064a (\\u0628\\u0627\\u0644\\u0625\\u0646\\u062c\\u0644\\u064a\\u0632\\u064a\\u0629: Pepsi)\\u200f \\u0647\\u0648 \\u0645\\u0634\\u0631\\u0648\\u0628 \\u063a\\u0627\\u0632\\u064a \\u0645\\u0643\\u0631\\u0628\\u0646 \\u062a\\u0635\\u0646\\u0639\\u0647 \\u0634\\u0631\\u0643\\u0629 \\u0628\\u064a\\u0628\\u0633\\u064a\\u0643\\u0648 (\\u062d\\u0627\\u0644\\u064a\\u064b\\u0651\\u0627). ... \\u0648\\u064a\\u0631\\u062c\\u0639 \\u0625\\u0646\\u0634\\u0627\\u0624\\u0647 \\u0648\\u062a\\u0637\\u0648\\u064a\\u0631\\u0647 \\u0641\\u064a \\u0627\\u0644\\u0623\\u0635\\u0644 \\u0625\\u0644\\u0649 \\u0639\\u0627\\u0645 1893 \\u0639\\u0644\\u0649 \\u064a\\u062f \\u0627\\u0644\\u0635\\u064a\\u062f\\u0644\\u0627\\u0646\\u064a \\u0643\\u0627\\u0644\\u064a\\u0628 \\u0628\\u0631\\u0627\\u062f\\u0647\\u0627\\u0645\\u060c ...\\n\",\"product_sku\":\"23423\",\"product_code\":null,\"product_id\":2,\"quantity\":2,\"unit_price\":2,\"tax_id\":null,\"tax_amount\":null,\"discount_amount\":0,\"total_price\":5}}', NULL, '2025-04-10 12:36:36', '2025-04-10 12:36:36'),
(72, 'default', 'created', 'App\\Models\\OrderItem', 'created', 12, 'App\\Models\\User', 1, '{\"attributes\":{\"order_id\":5,\"product_name_en\":\"juice\",\"product_name_ar\":\"juice\",\"product_description_en\":null,\"product_description_ar\":\"juice\",\"product_sku\":\"fdsa\",\"product_code\":null,\"product_id\":7,\"quantity\":1,\"unit_price\":5,\"tax_id\":null,\"tax_amount\":1,\"discount_amount\":0,\"total_price\":5.75}}', NULL, '2025-04-10 12:36:36', '2025-04-10 12:36:36'),
(73, 'default', 'deleted', 'App\\Models\\OrderItem', 'deleted', 12, 'App\\Models\\User', 1, '{\"old\":{\"order_id\":5,\"product_name_en\":\"juice\",\"product_name_ar\":\"juice\",\"product_description_en\":null,\"product_description_ar\":\"juice\",\"product_sku\":\"fdsa\",\"product_code\":null,\"product_id\":7,\"quantity\":1,\"unit_price\":5,\"tax_id\":null,\"tax_amount\":1,\"discount_amount\":0,\"total_price\":5.75}}', NULL, '2025-04-10 12:37:10', '2025-04-10 12:37:10'),
(74, 'default', 'created', 'App\\Models\\OrderItem', 'created', 13, 'App\\Models\\User', 1, '{\"attributes\":{\"order_id\":5,\"product_name_en\":\"Pepsi\",\"product_name_ar\":\"\\u0628\\u064a\\u0628\\u0633\\u064a\",\"product_description_en\":\"pepsi\",\"product_description_ar\":\"\\u0628\\u064a\\u0628\\u0633\\u064a ... \\u0628\\u064a\\u0628\\u0633\\u064a (\\u0628\\u0627\\u0644\\u0625\\u0646\\u062c\\u0644\\u064a\\u0632\\u064a\\u0629: Pepsi)\\u200f \\u0647\\u0648 \\u0645\\u0634\\u0631\\u0648\\u0628 \\u063a\\u0627\\u0632\\u064a \\u0645\\u0643\\u0631\\u0628\\u0646 \\u062a\\u0635\\u0646\\u0639\\u0647 \\u0634\\u0631\\u0643\\u0629 \\u0628\\u064a\\u0628\\u0633\\u064a\\u0643\\u0648 (\\u062d\\u0627\\u0644\\u064a\\u064b\\u0651\\u0627). ... \\u0648\\u064a\\u0631\\u062c\\u0639 \\u0625\\u0646\\u0634\\u0627\\u0624\\u0647 \\u0648\\u062a\\u0637\\u0648\\u064a\\u0631\\u0647 \\u0641\\u064a \\u0627\\u0644\\u0623\\u0635\\u0644 \\u0625\\u0644\\u0649 \\u0639\\u0627\\u0645 1893 \\u0639\\u0644\\u0649 \\u064a\\u062f \\u0627\\u0644\\u0635\\u064a\\u062f\\u0644\\u0627\\u0646\\u064a \\u0643\\u0627\\u0644\\u064a\\u0628 \\u0628\\u0631\\u0627\\u062f\\u0647\\u0627\\u0645\\u060c ...\\n\",\"product_sku\":\"23423\",\"product_code\":null,\"product_id\":2,\"quantity\":1,\"unit_price\":2,\"tax_id\":null,\"tax_amount\":1,\"discount_amount\":0,\"total_price\":2.5}}', NULL, '2025-04-10 12:37:10', '2025-04-10 12:37:10'),
(75, 'default', 'deleted', 'App\\Models\\OrderItem', 'deleted', 13, 'App\\Models\\User', 1, '{\"old\":{\"order_id\":5,\"product_name_en\":\"Pepsi\",\"product_name_ar\":\"\\u0628\\u064a\\u0628\\u0633\\u064a\",\"product_description_en\":\"pepsi\",\"product_description_ar\":\"\\u0628\\u064a\\u0628\\u0633\\u064a ... \\u0628\\u064a\\u0628\\u0633\\u064a (\\u0628\\u0627\\u0644\\u0625\\u0646\\u062c\\u0644\\u064a\\u0632\\u064a\\u0629: Pepsi)\\u200f \\u0647\\u0648 \\u0645\\u0634\\u0631\\u0648\\u0628 \\u063a\\u0627\\u0632\\u064a \\u0645\\u0643\\u0631\\u0628\\u0646 \\u062a\\u0635\\u0646\\u0639\\u0647 \\u0634\\u0631\\u0643\\u0629 \\u0628\\u064a\\u0628\\u0633\\u064a\\u0643\\u0648 (\\u062d\\u0627\\u0644\\u064a\\u064b\\u0651\\u0627). ... \\u0648\\u064a\\u0631\\u062c\\u0639 \\u0625\\u0646\\u0634\\u0627\\u0624\\u0647 \\u0648\\u062a\\u0637\\u0648\\u064a\\u0631\\u0647 \\u0641\\u064a \\u0627\\u0644\\u0623\\u0635\\u0644 \\u0625\\u0644\\u0649 \\u0639\\u0627\\u0645 1893 \\u0639\\u0644\\u0649 \\u064a\\u062f \\u0627\\u0644\\u0635\\u064a\\u062f\\u0644\\u0627\\u0646\\u064a \\u0643\\u0627\\u0644\\u064a\\u0628 \\u0628\\u0631\\u0627\\u062f\\u0647\\u0627\\u0645\\u060c ...\\n\",\"product_sku\":\"23423\",\"product_code\":null,\"product_id\":2,\"quantity\":1,\"unit_price\":2,\"tax_id\":null,\"tax_amount\":1,\"discount_amount\":0,\"total_price\":2.5}}', NULL, '2025-04-10 12:40:17', '2025-04-10 12:40:17');
INSERT INTO `activity_logs` (`id`, `log_name`, `description`, `subject_type`, `event`, `subject_id`, `causer_type`, `causer_id`, `properties`, `batch_uuid`, `created_at`, `updated_at`) VALUES
(76, 'default', 'created', 'App\\Models\\OrderItem', 'created', 14, 'App\\Models\\User', 1, '{\"attributes\":{\"order_id\":5,\"product_name_en\":\"juice\",\"product_name_ar\":\"juice\",\"product_description_en\":null,\"product_description_ar\":\"juice\",\"product_sku\":\"fdsa\",\"product_code\":null,\"product_id\":7,\"quantity\":2,\"unit_price\":5,\"tax_id\":null,\"tax_amount\":1,\"discount_amount\":0,\"total_price\":11.5}}', NULL, '2025-04-10 12:40:17', '2025-04-10 12:40:17'),
(77, 'default', 'deleted', 'App\\Models\\OrderItem', 'deleted', 14, 'App\\Models\\User', 1, '{\"old\":{\"order_id\":5,\"product_name_en\":\"juice\",\"product_name_ar\":\"juice\",\"product_description_en\":null,\"product_description_ar\":\"juice\",\"product_sku\":\"fdsa\",\"product_code\":null,\"product_id\":7,\"quantity\":2,\"unit_price\":5,\"tax_id\":null,\"tax_amount\":1,\"discount_amount\":0,\"total_price\":11.5}}', NULL, '2025-04-10 12:42:00', '2025-04-10 12:42:00'),
(78, 'default', 'created', 'App\\Models\\OrderItem', 'created', 15, 'App\\Models\\User', 1, '{\"attributes\":{\"order_id\":5,\"product_name_en\":\"Pepsi\",\"product_name_ar\":\"\\u0628\\u064a\\u0628\\u0633\\u064a\",\"product_description_en\":\"pepsi\",\"product_description_ar\":\"\\u0628\\u064a\\u0628\\u0633\\u064a ... \\u0628\\u064a\\u0628\\u0633\\u064a (\\u0628\\u0627\\u0644\\u0625\\u0646\\u062c\\u0644\\u064a\\u0632\\u064a\\u0629: Pepsi)\\u200f \\u0647\\u0648 \\u0645\\u0634\\u0631\\u0648\\u0628 \\u063a\\u0627\\u0632\\u064a \\u0645\\u0643\\u0631\\u0628\\u0646 \\u062a\\u0635\\u0646\\u0639\\u0647 \\u0634\\u0631\\u0643\\u0629 \\u0628\\u064a\\u0628\\u0633\\u064a\\u0643\\u0648 (\\u062d\\u0627\\u0644\\u064a\\u064b\\u0651\\u0627). ... \\u0648\\u064a\\u0631\\u062c\\u0639 \\u0625\\u0646\\u0634\\u0627\\u0624\\u0647 \\u0648\\u062a\\u0637\\u0648\\u064a\\u0631\\u0647 \\u0641\\u064a \\u0627\\u0644\\u0623\\u0635\\u0644 \\u0625\\u0644\\u0649 \\u0639\\u0627\\u0645 1893 \\u0639\\u0644\\u0649 \\u064a\\u062f \\u0627\\u0644\\u0635\\u064a\\u062f\\u0644\\u0627\\u0646\\u064a \\u0643\\u0627\\u0644\\u064a\\u0628 \\u0628\\u0631\\u0627\\u062f\\u0647\\u0627\\u0645\\u060c ...\\n\",\"product_sku\":\"23423\",\"product_code\":null,\"product_id\":2,\"quantity\":1,\"unit_price\":2,\"tax_id\":null,\"tax_amount\":1,\"discount_amount\":0,\"total_price\":2.5}}', NULL, '2025-04-10 12:42:00', '2025-04-10 12:42:00'),
(79, 'default', 'deleted', 'App\\Models\\OrderItem', 'deleted', 15, 'App\\Models\\User', 1, '{\"old\":{\"order_id\":5,\"product_name_en\":\"Pepsi\",\"product_name_ar\":\"\\u0628\\u064a\\u0628\\u0633\\u064a\",\"product_description_en\":\"pepsi\",\"product_description_ar\":\"\\u0628\\u064a\\u0628\\u0633\\u064a ... \\u0628\\u064a\\u0628\\u0633\\u064a (\\u0628\\u0627\\u0644\\u0625\\u0646\\u062c\\u0644\\u064a\\u0632\\u064a\\u0629: Pepsi)\\u200f \\u0647\\u0648 \\u0645\\u0634\\u0631\\u0648\\u0628 \\u063a\\u0627\\u0632\\u064a \\u0645\\u0643\\u0631\\u0628\\u0646 \\u062a\\u0635\\u0646\\u0639\\u0647 \\u0634\\u0631\\u0643\\u0629 \\u0628\\u064a\\u0628\\u0633\\u064a\\u0643\\u0648 (\\u062d\\u0627\\u0644\\u064a\\u064b\\u0651\\u0627). ... \\u0648\\u064a\\u0631\\u062c\\u0639 \\u0625\\u0646\\u0634\\u0627\\u0624\\u0647 \\u0648\\u062a\\u0637\\u0648\\u064a\\u0631\\u0647 \\u0641\\u064a \\u0627\\u0644\\u0623\\u0635\\u0644 \\u0625\\u0644\\u0649 \\u0639\\u0627\\u0645 1893 \\u0639\\u0644\\u0649 \\u064a\\u062f \\u0627\\u0644\\u0635\\u064a\\u062f\\u0644\\u0627\\u0646\\u064a \\u0643\\u0627\\u0644\\u064a\\u0628 \\u0628\\u0631\\u0627\\u062f\\u0647\\u0627\\u0645\\u060c ...\\n\",\"product_sku\":\"23423\",\"product_code\":null,\"product_id\":2,\"quantity\":1,\"unit_price\":2,\"tax_id\":null,\"tax_amount\":1,\"discount_amount\":0,\"total_price\":2.5}}', NULL, '2025-04-10 12:47:05', '2025-04-10 12:47:05'),
(80, 'default', 'created', 'App\\Models\\OrderItem', 'created', 16, 'App\\Models\\User', 1, '{\"attributes\":{\"order_id\":5,\"product_name_en\":\"coke\",\"product_name_ar\":\"coke\",\"product_description_en\":null,\"product_description_ar\":null,\"product_sku\":\"234\",\"product_code\":null,\"product_id\":5,\"quantity\":1,\"unit_price\":3,\"tax_id\":null,\"tax_amount\":0,\"discount_amount\":0,\"total_price\":3.45}}', NULL, '2025-04-10 12:47:05', '2025-04-10 12:47:05'),
(81, 'default', 'created', 'App\\Models\\Order', 'created', 6, 'App\\Models\\User', 1, '{\"attributes\":{\"number\":\"ORD-202504-IEFTFV\",\"customer_id\":1,\"user_id\":null,\"company_id\":1,\"order_status_id\":4,\"shipping_fee\":null,\"subtotal\":null,\"tax\":null,\"total\":null,\"payment_method_id\":1,\"currency_id\":1,\"billing_address_id\":null,\"shipping_address_id\":null,\"estimated_delivery_at\":null,\"delivered_at\":null,\"shipped_at\":null,\"meta\":[]}}', NULL, '2025-04-10 12:48:14', '2025-04-10 12:48:14'),
(82, 'default', 'created', 'App\\Models\\OrderItem', 'created', 17, 'App\\Models\\User', 1, '{\"attributes\":{\"order_id\":6,\"product_name_en\":\"Pepsi\",\"product_name_ar\":\"\\u0628\\u064a\\u0628\\u0633\\u064a\",\"product_description_en\":\"pepsi\",\"product_description_ar\":\"\\u0628\\u064a\\u0628\\u0633\\u064a ... \\u0628\\u064a\\u0628\\u0633\\u064a (\\u0628\\u0627\\u0644\\u0625\\u0646\\u062c\\u0644\\u064a\\u0632\\u064a\\u0629: Pepsi)\\u200f \\u0647\\u0648 \\u0645\\u0634\\u0631\\u0648\\u0628 \\u063a\\u0627\\u0632\\u064a \\u0645\\u0643\\u0631\\u0628\\u0646 \\u062a\\u0635\\u0646\\u0639\\u0647 \\u0634\\u0631\\u0643\\u0629 \\u0628\\u064a\\u0628\\u0633\\u064a\\u0643\\u0648 (\\u062d\\u0627\\u0644\\u064a\\u064b\\u0651\\u0627). ... \\u0648\\u064a\\u0631\\u062c\\u0639 \\u0625\\u0646\\u0634\\u0627\\u0624\\u0647 \\u0648\\u062a\\u0637\\u0648\\u064a\\u0631\\u0647 \\u0641\\u064a \\u0627\\u0644\\u0623\\u0635\\u0644 \\u0625\\u0644\\u0649 \\u0639\\u0627\\u0645 1893 \\u0639\\u0644\\u0649 \\u064a\\u062f \\u0627\\u0644\\u0635\\u064a\\u062f\\u0644\\u0627\\u0646\\u064a \\u0643\\u0627\\u0644\\u064a\\u0628 \\u0628\\u0631\\u0627\\u062f\\u0647\\u0627\\u0645\\u060c ...\\n\",\"product_sku\":\"23423\",\"product_code\":null,\"product_id\":2,\"quantity\":1,\"unit_price\":2,\"tax_id\":null,\"tax_amount\":0,\"discount_amount\":0,\"total_price\":2.5}}', NULL, '2025-04-10 12:48:14', '2025-04-10 12:48:14'),
(83, 'default', 'created', 'App\\Models\\Address', 'created', 11, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":11,\"address_type_id\":1,\"addressable_type\":null,\"addressable_id\":null,\"street\":null,\"city\":null,\"state\":null,\"country\":null,\"postal_code\":null,\"country_id\":null,\"contact_person_full_name\":null,\"contact_person_phone\":null,\"latitude\":null,\"longitude\":null,\"details\":null,\"created_at\":\"2025-04-10T12:48:14.000000Z\",\"updated_at\":\"2025-04-10T12:48:14.000000Z\",\"deleted_at\":null}}', NULL, '2025-04-10 12:48:14', '2025-04-10 12:48:14'),
(84, 'default', 'updated', 'App\\Models\\Order', 'updated', 6, 'App\\Models\\User', 1, '{\"attributes\":{\"shipping_address_id\":11},\"old\":{\"shipping_address_id\":null}}', NULL, '2025-04-10 12:48:14', '2025-04-10 12:48:14'),
(85, 'default', 'created', 'App\\Models\\Address', 'created', 12, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":12,\"address_type_id\":2,\"addressable_type\":null,\"addressable_id\":null,\"street\":null,\"city\":null,\"state\":null,\"country\":null,\"postal_code\":null,\"country_id\":null,\"contact_person_full_name\":null,\"contact_person_phone\":null,\"latitude\":null,\"longitude\":null,\"details\":null,\"created_at\":\"2025-04-10T12:48:14.000000Z\",\"updated_at\":\"2025-04-10T12:48:14.000000Z\",\"deleted_at\":null}}', NULL, '2025-04-10 12:48:14', '2025-04-10 12:48:14'),
(86, 'default', 'updated', 'App\\Models\\Order', 'updated', 6, 'App\\Models\\User', 1, '{\"attributes\":{\"billing_address_id\":12},\"old\":{\"billing_address_id\":null}}', NULL, '2025-04-10 12:48:14', '2025-04-10 12:48:14'),
(87, 'default', 'deleted', 'App\\Models\\OrderItem', 'deleted', 17, 'App\\Models\\User', 1, '{\"old\":{\"order_id\":6,\"product_name_en\":\"Pepsi\",\"product_name_ar\":\"\\u0628\\u064a\\u0628\\u0633\\u064a\",\"product_description_en\":\"pepsi\",\"product_description_ar\":\"\\u0628\\u064a\\u0628\\u0633\\u064a ... \\u0628\\u064a\\u0628\\u0633\\u064a (\\u0628\\u0627\\u0644\\u0625\\u0646\\u062c\\u0644\\u064a\\u0632\\u064a\\u0629: Pepsi)\\u200f \\u0647\\u0648 \\u0645\\u0634\\u0631\\u0648\\u0628 \\u063a\\u0627\\u0632\\u064a \\u0645\\u0643\\u0631\\u0628\\u0646 \\u062a\\u0635\\u0646\\u0639\\u0647 \\u0634\\u0631\\u0643\\u0629 \\u0628\\u064a\\u0628\\u0633\\u064a\\u0643\\u0648 (\\u062d\\u0627\\u0644\\u064a\\u064b\\u0651\\u0627). ... \\u0648\\u064a\\u0631\\u062c\\u0639 \\u0625\\u0646\\u0634\\u0627\\u0624\\u0647 \\u0648\\u062a\\u0637\\u0648\\u064a\\u0631\\u0647 \\u0641\\u064a \\u0627\\u0644\\u0623\\u0635\\u0644 \\u0625\\u0644\\u0649 \\u0639\\u0627\\u0645 1893 \\u0639\\u0644\\u0649 \\u064a\\u062f \\u0627\\u0644\\u0635\\u064a\\u062f\\u0644\\u0627\\u0646\\u064a \\u0643\\u0627\\u0644\\u064a\\u0628 \\u0628\\u0631\\u0627\\u062f\\u0647\\u0627\\u0645\\u060c ...\\n\",\"product_sku\":\"23423\",\"product_code\":null,\"product_id\":2,\"quantity\":1,\"unit_price\":2,\"tax_id\":null,\"tax_amount\":0,\"discount_amount\":0,\"total_price\":2.5}}', NULL, '2025-04-10 12:53:36', '2025-04-10 12:53:36'),
(88, 'default', 'created', 'App\\Models\\OrderItem', 'created', 18, 'App\\Models\\User', 1, '{\"attributes\":{\"order_id\":6,\"product_name_en\":\"Pepsi\",\"product_name_ar\":\"\\u0628\\u064a\\u0628\\u0633\\u064a\",\"product_description_en\":\"pepsi\",\"product_description_ar\":\"\\u0628\\u064a\\u0628\\u0633\\u064a ... \\u0628\\u064a\\u0628\\u0633\\u064a (\\u0628\\u0627\\u0644\\u0625\\u0646\\u062c\\u0644\\u064a\\u0632\\u064a\\u0629: Pepsi)\\u200f \\u0647\\u0648 \\u0645\\u0634\\u0631\\u0648\\u0628 \\u063a\\u0627\\u0632\\u064a \\u0645\\u0643\\u0631\\u0628\\u0646 \\u062a\\u0635\\u0646\\u0639\\u0647 \\u0634\\u0631\\u0643\\u0629 \\u0628\\u064a\\u0628\\u0633\\u064a\\u0643\\u0648 (\\u062d\\u0627\\u0644\\u064a\\u064b\\u0651\\u0627). ... \\u0648\\u064a\\u0631\\u062c\\u0639 \\u0625\\u0646\\u0634\\u0627\\u0624\\u0647 \\u0648\\u062a\\u0637\\u0648\\u064a\\u0631\\u0647 \\u0641\\u064a \\u0627\\u0644\\u0623\\u0635\\u0644 \\u0625\\u0644\\u0649 \\u0639\\u0627\\u0645 1893 \\u0639\\u0644\\u0649 \\u064a\\u062f \\u0627\\u0644\\u0635\\u064a\\u062f\\u0644\\u0627\\u0646\\u064a \\u0643\\u0627\\u0644\\u064a\\u0628 \\u0628\\u0631\\u0627\\u062f\\u0647\\u0627\\u0645\\u060c ...\\n\",\"product_sku\":\"23423\",\"product_code\":null,\"product_id\":2,\"quantity\":1,\"unit_price\":2,\"tax_id\":null,\"tax_amount\":0,\"discount_amount\":0,\"total_price\":2.5}}', NULL, '2025-04-10 12:53:36', '2025-04-10 12:53:36'),
(89, 'default', 'created', 'App\\Models\\OrderItem', 'created', 19, 'App\\Models\\User', 1, '{\"attributes\":{\"order_id\":6,\"product_name_en\":\"juice\",\"product_name_ar\":\"juice\",\"product_description_en\":null,\"product_description_ar\":\"juice\",\"product_sku\":\"fdsa\",\"product_code\":null,\"product_id\":7,\"quantity\":1,\"unit_price\":5,\"tax_id\":null,\"note\":\"hii everyone\",\"tax_amount\":\"0.75\",\"discount_amount\":0,\"total_price\":5.75}}', NULL, '2025-04-10 12:55:11', '2025-04-10 12:55:11'),
(90, 'default', 'updated', 'App\\Models\\OrderItem', 'updated', 19, 'App\\Models\\User', 1, '{\"attributes\":{\"tax_amount\":\"0.80\",\"total_price\":5.8},\"old\":{\"tax_amount\":\"0.75\",\"total_price\":5.75}}', NULL, '2025-04-10 12:55:35', '2025-04-10 12:55:35'),
(91, 'default', 'created', 'App\\Models\\Order', 'created', 7, 'App\\Models\\User', 1, '{\"attributes\":{\"number\":\"ORD-202504-CLA4TE\",\"customer_id\":1,\"user_id\":null,\"company_id\":1,\"order_status_id\":4,\"shipping_fee\":null,\"subtotal\":null,\"tax\":null,\"total\":null,\"payment_method_id\":4,\"currency_id\":1,\"billing_address_id\":null,\"shipping_address_id\":null,\"estimated_delivery_at\":null,\"delivered_at\":null,\"shipped_at\":null,\"meta\":[]}}', NULL, '2025-04-10 12:56:41', '2025-04-10 12:56:41'),
(92, 'default', 'created', 'App\\Models\\OrderItem', 'created', 20, 'App\\Models\\User', 1, '{\"attributes\":{\"order_id\":7,\"product_name_en\":\"juice\",\"product_name_ar\":\"juice\",\"product_description_en\":null,\"product_description_ar\":\"juice\",\"product_sku\":\"fdsa\",\"product_code\":null,\"product_id\":7,\"quantity\":1,\"unit_price\":5,\"tax_id\":null,\"note\":\"its updated\",\"tax_amount\":\"0.76\",\"discount_amount\":0,\"total_price\":5.76}}', NULL, '2025-04-10 12:56:41', '2025-04-10 12:56:41'),
(93, 'default', 'created', 'App\\Models\\Address', 'created', 13, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":13,\"address_type_id\":1,\"addressable_type\":null,\"addressable_id\":null,\"street\":null,\"city\":null,\"state\":null,\"country\":null,\"postal_code\":null,\"country_id\":null,\"contact_person_full_name\":null,\"contact_person_phone\":null,\"latitude\":null,\"longitude\":null,\"details\":null,\"created_at\":\"2025-04-10T12:56:41.000000Z\",\"updated_at\":\"2025-04-10T12:56:41.000000Z\",\"deleted_at\":null}}', NULL, '2025-04-10 12:56:41', '2025-04-10 12:56:41'),
(94, 'default', 'updated', 'App\\Models\\Order', 'updated', 7, 'App\\Models\\User', 1, '{\"attributes\":{\"shipping_address_id\":13},\"old\":{\"shipping_address_id\":null}}', NULL, '2025-04-10 12:56:41', '2025-04-10 12:56:41'),
(95, 'default', 'created', 'App\\Models\\Address', 'created', 14, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":14,\"address_type_id\":2,\"addressable_type\":null,\"addressable_id\":null,\"street\":null,\"city\":null,\"state\":null,\"country\":null,\"postal_code\":null,\"country_id\":null,\"contact_person_full_name\":null,\"contact_person_phone\":null,\"latitude\":null,\"longitude\":null,\"details\":null,\"created_at\":\"2025-04-10T12:56:41.000000Z\",\"updated_at\":\"2025-04-10T12:56:41.000000Z\",\"deleted_at\":null}}', NULL, '2025-04-10 12:56:41', '2025-04-10 12:56:41'),
(96, 'default', 'updated', 'App\\Models\\Order', 'updated', 7, 'App\\Models\\User', 1, '{\"attributes\":{\"billing_address_id\":14},\"old\":{\"billing_address_id\":null}}', NULL, '2025-04-10 12:56:41', '2025-04-10 12:56:41'),
(97, 'default', 'updated', 'App\\Models\\OrderItem', 'updated', 20, 'App\\Models\\User', 1, '{\"attributes\":{\"quantity\":2,\"tax_amount\":\"1.00\",\"total_price\":12},\"old\":{\"quantity\":1,\"tax_amount\":\"0.76\",\"total_price\":5.76}}', NULL, '2025-04-10 12:57:12', '2025-04-10 12:57:12'),
(98, 'default', 'updated', 'App\\Models\\OrderItem', 'updated', 20, 'App\\Models\\User', 1, '{\"attributes\":{\"note\":null},\"old\":{\"note\":\"its updated\"}}', NULL, '2025-04-10 13:06:56', '2025-04-10 13:06:56'),
(99, 'default', 'updated', 'App\\Models\\OrderItem', 'updated', 20, 'App\\Models\\User', 1, '{\"attributes\":{\"note\":\"this is not cold\"},\"old\":{\"note\":null}}', NULL, '2025-04-10 13:08:07', '2025-04-10 13:08:07'),
(100, 'default', 'updated', 'App\\Models\\OrderItem', 'updated', 20, 'App\\Models\\User', 1, '{\"attributes\":{\"tax_amount\":\"0.75\",\"total_price\":11.5},\"old\":{\"tax_amount\":\"1.00\",\"total_price\":12}}', NULL, '2025-04-10 13:08:27', '2025-04-10 13:08:27'),
(101, 'default', 'updated', 'App\\Models\\OrderItem', 'updated', 20, 'App\\Models\\User', 1, '{\"attributes\":{\"quantity\":3,\"note\":\"cold\",\"total_price\":17.25},\"old\":{\"quantity\":2,\"note\":\"this is not cold\",\"total_price\":11.5}}', NULL, '2025-04-10 13:21:35', '2025-04-10 13:21:35'),
(102, 'default', 'created', 'App\\Models\\OrderItem', 'created', 21, 'App\\Models\\User', 1, '{\"attributes\":{\"order_id\":7,\"product_name_en\":\"Pepsi\",\"product_name_ar\":\"\\u0628\\u064a\\u0628\\u0633\\u064a\",\"product_description_en\":\"pepsi\",\"product_description_ar\":\"\\u0628\\u064a\\u0628\\u0633\\u064a ... \\u0628\\u064a\\u0628\\u0633\\u064a (\\u0628\\u0627\\u0644\\u0625\\u0646\\u062c\\u0644\\u064a\\u0632\\u064a\\u0629: Pepsi)\\u200f \\u0647\\u0648 \\u0645\\u0634\\u0631\\u0648\\u0628 \\u063a\\u0627\\u0632\\u064a \\u0645\\u0643\\u0631\\u0628\\u0646 \\u062a\\u0635\\u0646\\u0639\\u0647 \\u0634\\u0631\\u0643\\u0629 \\u0628\\u064a\\u0628\\u0633\\u064a\\u0643\\u0648 (\\u062d\\u0627\\u0644\\u064a\\u064b\\u0651\\u0627). ... \\u0648\\u064a\\u0631\\u062c\\u0639 \\u0625\\u0646\\u0634\\u0627\\u0624\\u0647 \\u0648\\u062a\\u0637\\u0648\\u064a\\u0631\\u0647 \\u0641\\u064a \\u0627\\u0644\\u0623\\u0635\\u0644 \\u0625\\u0644\\u0649 \\u0639\\u0627\\u0645 1893 \\u0639\\u0644\\u0649 \\u064a\\u062f \\u0627\\u0644\\u0635\\u064a\\u062f\\u0644\\u0627\\u0646\\u064a \\u0643\\u0627\\u0644\\u064a\\u0628 \\u0628\\u0631\\u0627\\u062f\\u0647\\u0627\\u0645\\u060c ...\\n\",\"product_sku\":\"23423\",\"product_code\":null,\"product_id\":2,\"quantity\":1,\"unit_price\":2,\"tax_id\":null,\"note\":\" not cold\",\"tax_amount\":\"0.50\",\"discount_amount\":0,\"total_price\":2.5}}', NULL, '2025-04-10 13:21:35', '2025-04-10 13:21:35'),
(103, 'default', 'updated', 'App\\Models\\Order', 'updated', 7, 'App\\Models\\User', 1, '{\"attributes\":{\"subtotal\":17,\"tax\":3,\"total\":20},\"old\":{\"subtotal\":null,\"tax\":null,\"total\":null}}', NULL, '2025-04-10 13:21:35', '2025-04-10 13:21:35'),
(104, 'default', 'updated', 'App\\Models\\Product', 'updated', 2, 'App\\Models\\User', 1, '{\"attributes\":{\"sale_price\":2.3,\"updated_at\":\"2025-04-10T13:57:00.000000Z\"},\"old\":{\"sale_price\":2.5,\"updated_at\":\"2025-04-09T18:31:55.000000Z\"}}', NULL, '2025-04-10 13:57:00', '2025-04-10 13:57:00'),
(105, 'default', 'created', 'App\\Models\\Product', 'created', 8, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":8,\"company_id\":1,\"name_en\":\"Pepsin2\",\"name_ar\":\"Pepsin2\",\"description_en\":null,\"description_ar\":null,\"slug\":\"pepsin2\",\"sku\":null,\"code\":null,\"price\":5,\"sale_price\":5.75,\"currency_id\":1,\"product_category_id\":1,\"point_of_sale_id\":null,\"image_url\":null,\"is_active\":true,\"created_at\":\"2025-04-10T14:08:51.000000Z\",\"updated_at\":\"2025-04-10T14:08:51.000000Z\",\"deleted_at\":null}}', NULL, '2025-04-10 14:08:52', '2025-04-10 14:08:52'),
(106, 'default', 'updated', 'App\\Models\\Product', 'updated', 5, 'App\\Models\\User', 1, '{\"attributes\":{\"price\":100,\"sale_price\":115,\"updated_at\":\"2025-04-10T17:28:19.000000Z\"},\"old\":{\"price\":3,\"sale_price\":3.45,\"updated_at\":\"2025-04-09T19:42:29.000000Z\"}}', NULL, '2025-04-10 17:28:19', '2025-04-10 17:28:19'),
(107, 'default', 'updated', 'App\\Models\\Product', 'updated', 5, 'App\\Models\\User', 1, '{\"attributes\":{\"sale_price\":125,\"updated_at\":\"2025-04-10T17:52:25.000000Z\"},\"old\":{\"sale_price\":115,\"updated_at\":\"2025-04-10T17:28:19.000000Z\"}}', NULL, '2025-04-10 17:52:25', '2025-04-10 17:52:25'),
(108, 'default', 'created', 'App\\Models\\Order', 'created', 8, 'App\\Models\\User', 1, '{\"attributes\":{\"number\":\"ORD-202504-WNWQGP\",\"customer_id\":1,\"user_id\":null,\"company_id\":1,\"order_status_id\":1,\"shipping_fee\":null,\"subtotal\":\"120.00\",\"vat\":\"18.00\",\"other_taxes\":\"15.00\",\"discount\":\"53.00\",\"total\":\"100.00\",\"payment_method_id\":4,\"currency_id\":1,\"billing_address_id\":null,\"shipping_address_id\":null,\"estimated_delivery_at\":null,\"delivered_at\":null,\"shipped_at\":null,\"meta\":[]}}', NULL, '2025-04-10 18:13:26', '2025-04-10 18:13:26'),
(109, 'default', 'created', 'App\\Models\\OrderItem', 'created', 22, 'App\\Models\\User', 1, '{\"attributes\":{\"order_id\":8,\"product_name_en\":\"coke\",\"product_name_ar\":\"coke\",\"product_description_en\":null,\"product_description_ar\":null,\"product_sku\":\"234\",\"product_code\":null,\"product_id\":5,\"quantity\":1,\"unit_price\":100,\"tax_id\":null,\"note\":null,\"vat_amount\":\"15.00\",\"other_taxes_amount\":\"10.00\",\"discount_amount\":\"50.00\",\"total_price\":75}}', NULL, '2025-04-10 18:13:26', '2025-04-10 18:13:26'),
(110, 'default', 'created', 'App\\Models\\OrderItem', 'created', 23, 'App\\Models\\User', 1, '{\"attributes\":{\"order_id\":8,\"product_name_en\":\"Pepsi\",\"product_name_ar\":\"\\u0628\\u064a\\u0628\\u0633\\u064a\",\"product_description_en\":\"pepsi\",\"product_description_ar\":\"\\u0628\\u064a\\u0628\\u0633\\u064a ... \\u0628\\u064a\\u0628\\u0633\\u064a (\\u0628\\u0627\\u0644\\u0625\\u0646\\u062c\\u0644\\u064a\\u0632\\u064a\\u0629: Pepsi)\\u200f \\u0647\\u0648 \\u0645\\u0634\\u0631\\u0648\\u0628 \\u063a\\u0627\\u0632\\u064a \\u0645\\u0643\\u0631\\u0628\\u0646 \\u062a\\u0635\\u0646\\u0639\\u0647 \\u0634\\u0631\\u0643\\u0629 \\u0628\\u064a\\u0628\\u0633\\u064a\\u0643\\u0648 (\\u062d\\u0627\\u0644\\u064a\\u064b\\u0651\\u0627). ... \\u0648\\u064a\\u0631\\u062c\\u0639 \\u0625\\u0646\\u0634\\u0627\\u0624\\u0647 \\u0648\\u062a\\u0637\\u0648\\u064a\\u0631\\u0647 \\u0641\\u064a \\u0627\\u0644\\u0623\\u0635\\u0644 \\u0625\\u0644\\u0649 \\u0639\\u0627\\u0645 1893 \\u0639\\u0644\\u0649 \\u064a\\u062f \\u0627\\u0644\\u0635\\u064a\\u062f\\u0644\\u0627\\u0646\\u064a \\u0643\\u0627\\u0644\\u064a\\u0628 \\u0628\\u0631\\u0627\\u062f\\u0647\\u0627\\u0645\\u060c ...\\n\",\"product_sku\":\"23423\",\"product_code\":null,\"product_id\":2,\"quantity\":10,\"unit_price\":2,\"tax_id\":null,\"note\":null,\"vat_amount\":\"0.30\",\"other_taxes_amount\":\"0.50\",\"discount_amount\":\"3.00\",\"total_price\":25}}', NULL, '2025-04-10 18:13:26', '2025-04-10 18:13:26'),
(111, 'default', 'created', 'App\\Models\\Address', 'created', 15, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":15,\"address_type_id\":1,\"addressable_type\":null,\"addressable_id\":null,\"street\":null,\"city\":null,\"state\":null,\"country\":null,\"postal_code\":null,\"country_id\":null,\"contact_person_full_name\":null,\"contact_person_phone\":null,\"latitude\":null,\"longitude\":null,\"details\":null,\"created_at\":\"2025-04-10T18:13:26.000000Z\",\"updated_at\":\"2025-04-10T18:13:26.000000Z\",\"deleted_at\":null}}', NULL, '2025-04-10 18:13:26', '2025-04-10 18:13:26'),
(112, 'default', 'updated', 'App\\Models\\Order', 'updated', 8, 'App\\Models\\User', 1, '{\"attributes\":{\"shipping_address_id\":15},\"old\":{\"shipping_address_id\":null}}', NULL, '2025-04-10 18:13:26', '2025-04-10 18:13:26'),
(113, 'default', 'created', 'App\\Models\\Address', 'created', 16, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":16,\"address_type_id\":2,\"addressable_type\":null,\"addressable_id\":null,\"street\":null,\"city\":null,\"state\":null,\"country\":null,\"postal_code\":null,\"country_id\":null,\"contact_person_full_name\":null,\"contact_person_phone\":null,\"latitude\":null,\"longitude\":null,\"details\":null,\"created_at\":\"2025-04-10T18:13:26.000000Z\",\"updated_at\":\"2025-04-10T18:13:26.000000Z\",\"deleted_at\":null}}', NULL, '2025-04-10 18:13:26', '2025-04-10 18:13:26'),
(114, 'default', 'updated', 'App\\Models\\Order', 'updated', 8, 'App\\Models\\User', 1, '{\"attributes\":{\"billing_address_id\":16},\"old\":{\"billing_address_id\":null}}', NULL, '2025-04-10 18:13:27', '2025-04-10 18:13:27'),
(115, 'default', 'updated', 'App\\Models\\Order', 'updated', 8, 'App\\Models\\User', 1, '{\"attributes\":{\"amount_paid\":\"90.00\"},\"old\":{\"amount_paid\":\"0.00\"}}', NULL, '2025-04-10 18:23:45', '2025-04-10 18:23:45'),
(116, 'default', 'created', 'App\\Models\\Product', 'created', 9, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":9,\"company_id\":1,\"name_en\":\"Red bull\",\"name_ar\":\"Red bull\",\"description_en\":null,\"description_ar\":\"Red bull\",\"slug\":\"red-bull\",\"sku\":null,\"code\":null,\"price\":120,\"sale_price\":138,\"currency_id\":1,\"product_category_id\":1,\"point_of_sale_id\":null,\"image_url\":null,\"is_active\":true,\"created_at\":\"2025-04-10T18:31:15.000000Z\",\"updated_at\":\"2025-04-10T18:31:15.000000Z\",\"deleted_at\":null}}', NULL, '2025-04-10 18:31:15', '2025-04-10 18:31:15'),
(117, 'default', 'created', 'App\\Models\\OrderItem', 'created', 24, 'App\\Models\\User', 1, '{\"attributes\":{\"order_id\":8,\"product_name_en\":\"Red bull\",\"product_name_ar\":\"Red bull\",\"product_description_en\":null,\"product_description_ar\":\"Red bull\",\"product_sku\":null,\"product_code\":null,\"product_id\":9,\"quantity\":1,\"unit_price\":120,\"tax_id\":null,\"note\":null,\"vat_amount\":\"18.00\",\"other_taxes_amount\":\"0.00\",\"discount_amount\":\"0.00\",\"total_price\":138}}', NULL, '2025-04-10 18:31:52', '2025-04-10 18:31:52'),
(118, 'default', 'updated', 'App\\Models\\Order', 'updated', 8, 'App\\Models\\User', 1, '{\"attributes\":{\"subtotal\":\"240.00\",\"vat\":\"36.00\",\"total\":\"238.00\",\"amount_paid\":\"238.00\"},\"old\":{\"subtotal\":\"120.00\",\"vat\":\"18.00\",\"total\":\"100.00\",\"amount_paid\":\"90.00\"}}', NULL, '2025-04-10 18:31:52', '2025-04-10 18:31:52'),
(119, 'default', 'created', 'App\\Models\\Customer', 'created', 2, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":2,\"first_name\":\"Arsalan \",\"last_name\":\"Habib\",\"email\":\"arsalanhabib@gmail.com\",\"phone_number\":\"4326187\",\"company_id\":1,\"is_active\":true,\"meta\":null,\"created_at\":\"2025-04-10T18:39:23.000000Z\",\"updated_at\":\"2025-04-10T18:39:23.000000Z\",\"deleted_at\":null,\"vat_number\":\"23423\",\"address\":\"Saudi\"}}', NULL, '2025-04-10 18:39:23', '2025-04-10 18:39:23'),
(120, 'default', 'created', 'App\\Models\\Customer', 'created', 3, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":3,\"first_name\":\"Shani\",\"last_name\":\"Khan\",\"email\":\"shani@gmail.com\",\"phone_number\":\"2534523\",\"company_id\":1,\"is_active\":true,\"meta\":null,\"created_at\":\"2025-04-10T18:39:46.000000Z\",\"updated_at\":\"2025-04-10T18:39:46.000000Z\",\"deleted_at\":null,\"vat_number\":\"423\",\"address\":\"Multan\"}}', NULL, '2025-04-10 18:39:46', '2025-04-10 18:39:46'),
(121, 'default', 'created', 'App\\Models\\Product', 'created', 10, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":10,\"company_id\":1,\"name_en\":\"Marinda\",\"name_ar\":\"Marinda\",\"description_en\":\"Marinda\",\"description_ar\":\"Marinda\",\"slug\":\"marinda\",\"sku\":\"423\",\"code\":\"234\",\"price\":30,\"sale_price\":0,\"currency_id\":1,\"product_category_id\":1,\"point_of_sale_id\":null,\"image_url\":null,\"is_active\":true,\"created_at\":\"2025-04-10T18:46:38.000000Z\",\"updated_at\":\"2025-04-10T18:46:38.000000Z\",\"deleted_at\":null}}', NULL, '2025-04-10 18:46:38', '2025-04-10 18:46:38'),
(122, 'default', 'created', 'App\\Models\\Product', 'created', 11, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":11,\"company_id\":1,\"name_en\":\"Fanta\",\"name_ar\":\"Fanta\",\"description_en\":\"Fanta\",\"description_ar\":\"Fanta\",\"slug\":\"Fanta\",\"sku\":null,\"code\":null,\"price\":12,\"sale_price\":13.8,\"currency_id\":1,\"product_category_id\":1,\"point_of_sale_id\":null,\"image_url\":null,\"is_active\":true,\"created_at\":\"2025-04-10T18:55:02.000000Z\",\"updated_at\":\"2025-04-10T18:55:02.000000Z\",\"deleted_at\":null}}', NULL, '2025-04-10 18:55:02', '2025-04-10 18:55:02'),
(123, 'default', 'updated', 'App\\Models\\Product', 'updated', 10, 'App\\Models\\User', 1, '{\"attributes\":{\"sale_price\":34.5,\"updated_at\":\"2025-04-10T18:55:35.000000Z\"},\"old\":{\"sale_price\":0,\"updated_at\":\"2025-04-10T18:46:38.000000Z\"}}', NULL, '2025-04-10 18:55:35', '2025-04-10 18:55:35'),
(124, 'default', 'updated', 'App\\Models\\OrderItem', 'updated', 22, 'App\\Models\\User', 1, '{\"attributes\":{\"note\":\"this is the best\"},\"old\":{\"note\":null}}', NULL, '2025-04-12 15:52:07', '2025-04-12 15:52:07'),
(125, 'default', 'updated', 'App\\Models\\Order', 'updated', 8, 'App\\Models\\User', 1, '{\"attributes\":{\"amount_paid\":\"230.00\"},\"old\":{\"amount_paid\":\"238.00\"}}', NULL, '2025-04-12 17:40:31', '2025-04-12 17:40:31'),
(126, 'default', 'updated', 'App\\Models\\Order', 'updated', 8, 'App\\Models\\User', 1, '{\"attributes\":{\"amount_paid\":\"238.00\"},\"old\":{\"amount_paid\":\"230.00\"}}', NULL, '2025-04-12 17:41:07', '2025-04-12 17:41:07'),
(127, 'default', 'updated', 'App\\Models\\Order', 'updated', 8, 'App\\Models\\User', 1, '{\"attributes\":{\"amount_paid\":\"230.00\"},\"old\":{\"amount_paid\":\"238.00\"}}', NULL, '2025-04-12 17:41:20', '2025-04-12 17:41:20'),
(128, 'default', 'updated', 'App\\Models\\Order', 'updated', 8, 'App\\Models\\User', 1, '{\"attributes\":{\"amount_paid\":\"238.00\"},\"old\":{\"amount_paid\":\"230.00\"}}', NULL, '2025-04-12 17:41:28', '2025-04-12 17:41:28'),
(129, 'default', 'created', 'App\\Models\\InvoiceTemplateSetting', 'created', 1, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":1,\"key_name\":\"value\",\"company_id\":1,\"value_en\":\"<p><strong>Payment, return and exchange policy<\\/strong><\\/p><p><strong>First: Ready-made pieces<\\/strong><\\/p><p>If the piece is received as it is without modifications or repairs, the full amount will be paid and the amount can be refunded within one day and replaced within 3 days, provided that the piece is in good condition. In the event of repairs or modifications to the piece, the full amount is paid, non-refundable and exchangeable.<\\/p><p><strong>Second: Special design<\\/strong><\\/p><ol><li>50% of the design and implementation amount is paid as a non-refundable deposit after agreement and approval of the design.<\\/li><li>The full amount is paid for the value of the fabrics before they are cut after agreement and approval. It is non-refundable.<\\/li><li>The remaining 50% of the design and implementation value will be paid in addition to the resulting increases if any modifications are added to the design upon receipt of the piece.<\\/li><\\/ol>\",\"value_ar\":\"<p dir=\\\"rtl\\\"><strong>\\u0633\\u064a\\u0627\\u0633\\u0629 \\u0627\\u0644\\u062f\\u0641\\u0639 \\u0648\\u0627\\u0644\\u0625\\u0631\\u062c\\u0627\\u0639 \\u0648\\u0627\\u0644\\u0627\\u0633\\u062a\\u0628\\u062f\\u0627\\u0644<\\/strong><\\/p><p dir=\\\"rtl\\\"><strong>\\u0623\\u0648\\u0644\\u0627\\u064b: \\u0627\\u0644\\u0642\\u0637\\u0639 \\u0627\\u0644\\u062c\\u0627\\u0647\\u0632\\u0629<\\/strong><\\/p><p dir=\\\"rtl\\\">\\u0625\\u0630\\u0627 \\u062a\\u0645 \\u0627\\u0633\\u062a\\u0644\\u0627\\u0645 \\u0627\\u0644\\u0642\\u0637\\u0639\\u0629 \\u0643\\u0645\\u0627 \\u0647\\u064a \\u062f\\u0648\\u0646 \\u062a\\u0639\\u062f\\u064a\\u0644\\u0627\\u062a \\u0623\\u0648 \\u0625\\u0635\\u0644\\u0627\\u062d\\u0627\\u062a\\u060c \\u0633\\u064a\\u062a\\u0645 \\u062f\\u0641\\u0639 \\u0627\\u0644\\u0645\\u0628\\u0644\\u063a \\u0628\\u0627\\u0644\\u0643\\u0627\\u0645\\u0644 \\u0648\\u064a\\u0645\\u0643\\u0646 \\u0627\\u0633\\u062a\\u0631\\u062f\\u0627\\u062f \\u0627\\u0644\\u0645\\u0628\\u0644\\u063a \\u062e\\u0644\\u0627\\u0644 \\u064a\\u0648\\u0645 \\u0648\\u0627\\u062d\\u062f \\u0648\\u0627\\u0633\\u062a\\u0628\\u062f\\u0627\\u0644\\u0647 \\u062e\\u0644\\u0627\\u0644 3 \\u0623\\u064a\\u0627\\u0645\\u060c \\u0634\\u0631\\u064a\\u0637\\u0629 \\u0623\\u0646 \\u062a\\u0643\\u0648\\u0646 \\u0627\\u0644\\u0642\\u0637\\u0639\\u0629 \\u0641\\u064a \\u062d\\u0627\\u0644\\u0629 \\u062c\\u064a\\u062f\\u0629. \\u0641\\u064a \\u062d\\u0627\\u0644\\u0629 \\u0625\\u062c\\u0631\\u0627\\u0621 \\u0625\\u0635\\u0644\\u0627\\u062d\\u0627\\u062a \\u0623\\u0648 \\u062a\\u0639\\u062f\\u064a\\u0644\\u0627\\u062a \\u0639\\u0644\\u0649 \\u0627\\u0644\\u0642\\u0637\\u0639\\u0629\\u060c \\u064a\\u062a\\u0645 \\u062f\\u0641\\u0639 \\u0627\\u0644\\u0645\\u0628\\u0644\\u063a \\u0628\\u0627\\u0644\\u0643\\u0627\\u0645\\u0644\\u060c \\u063a\\u064a\\u0631 \\u0642\\u0627\\u0628\\u0644 \\u0644\\u0644\\u0627\\u0633\\u062a\\u0631\\u062f\\u0627\\u062f \\u0648\\u0627\\u0644\\u0627\\u0633\\u062a\\u0628\\u062f\\u0627\\u0644.<\\/p><p dir=\\\"rtl\\\"><strong>\\u062b\\u0627\\u0646\\u064a\\u0627\\u064b: \\u062a\\u0635\\u0645\\u064a\\u0645 \\u062e\\u0627\\u0635<\\/strong><\\/p><ol dir=\\\"rtl\\\"><li>\\u064a\\u062a\\u0645 \\u062f\\u0641\\u0639 50\\u066a \\u0645\\u0646 \\u0645\\u0628\\u0644\\u063a \\u0627\\u0644\\u062a\\u0635\\u0645\\u064a\\u0645 \\u0648\\u0627\\u0644\\u062a\\u0646\\u0641\\u064a\\u0630 \\u0643\\u0648\\u062f\\u064a\\u0639\\u0629 \\u063a\\u064a\\u0631 \\u0642\\u0627\\u0628\\u0644\\u0629 \\u0644\\u0644\\u0627\\u0633\\u062a\\u0631\\u062f\\u0627\\u062f \\u0628\\u0639\\u062f \\u0627\\u0644\\u0627\\u062a\\u0641\\u0627\\u0642 \\u0648\\u0627\\u0644\\u0645\\u0648\\u0627\\u0641\\u0642\\u0629 \\u0639\\u0644\\u0649 \\u0627\\u0644\\u062a\\u0635\\u0645\\u064a\\u0645.<\\/li><li>\\u064a\\u062a\\u0645 \\u062f\\u0641\\u0639 \\u0627\\u0644\\u0645\\u0628\\u0644\\u063a \\u0643\\u0627\\u0645\\u0644\\u0627\\u064b \\u0645\\u0642\\u0627\\u0628\\u0644 \\u0642\\u064a\\u0645\\u0629 \\u0627\\u0644\\u0623\\u0642\\u0645\\u0634\\u0629 \\u0642\\u0628\\u0644 \\u0642\\u0635\\u0647\\u0627 \\u0628\\u0639\\u062f \\u0627\\u0644\\u0627\\u062a\\u0641\\u0627\\u0642 \\u0648\\u0627\\u0644\\u0645\\u0648\\u0627\\u0641\\u0642\\u0629. \\u0648\\u0647\\u0648 \\u063a\\u064a\\u0631 \\u0642\\u0627\\u0628\\u0644 \\u0644\\u0644\\u0627\\u0633\\u062a\\u0631\\u062f\\u0627\\u062f.<\\/li><li>\\u0633\\u064a\\u062a\\u0645 \\u062f\\u0641\\u0639 \\u0627\\u0644\\u0640 50\\u066a \\u0627\\u0644\\u0645\\u062a\\u0628\\u0642\\u064a\\u0629 \\u0645\\u0646 \\u0642\\u064a\\u0645\\u0629 \\u0627\\u0644\\u062a\\u0635\\u0645\\u064a\\u0645 \\u0648\\u0627\\u0644\\u062a\\u0646\\u0641\\u064a\\u0630 \\u0628\\u0627\\u0644\\u0625\\u0636\\u0627\\u0641\\u0629 \\u0625\\u0644\\u0649 \\u0627\\u0644\\u0632\\u064a\\u0627\\u062f\\u0627\\u062a \\u0627\\u0644\\u0646\\u0627\\u062a\\u062c\\u0629 \\u0625\\u0630\\u0627 \\u062a\\u0645\\u062a \\u0625\\u0636\\u0627\\u0641\\u0629 \\u0623\\u064a \\u062a\\u0639\\u062f\\u064a\\u0644\\u0627\\u062a \\u0639\\u0644\\u0649 \\u0627\\u0644\\u062a\\u0635\\u0645\\u064a\\u0645 \\u0639\\u0646\\u062f \\u0627\\u0633\\u062a\\u0644\\u0627\\u0645 \\u0627\\u0644\\u0642\\u0637\\u0639\\u0629.<\\/li><\\/ol>\",\"created_at\":\"2025-04-12T19:10:26.000000Z\",\"updated_at\":\"2025-04-12T19:10:26.000000Z\"}}', NULL, '2025-04-12 19:10:26', '2025-04-12 19:10:26'),
(130, 'default', 'updated', 'App\\Models\\InvoiceTemplateSetting', 'updated', 1, 'App\\Models\\User', 1, '{\"attributes\":{\"value_en\":\"<p>a<\\/p>\",\"updated_at\":\"2025-04-12T19:11:45.000000Z\"},\"old\":{\"value_en\":\"<p><strong>Payment, return and exchange policy<\\/strong><\\/p><p><strong>First: Ready-made pieces<\\/strong><\\/p><p>If the piece is received as it is without modifications or repairs, the full amount will be paid and the amount can be refunded within one day and replaced within 3 days, provided that the piece is in good condition. In the event of repairs or modifications to the piece, the full amount is paid, non-refundable and exchangeable.<\\/p><p><strong>Second: Special design<\\/strong><\\/p><ol><li>50% of the design and implementation amount is paid as a non-refundable deposit after agreement and approval of the design.<\\/li><li>The full amount is paid for the value of the fabrics before they are cut after agreement and approval. It is non-refundable.<\\/li><li>The remaining 50% of the design and implementation value will be paid in addition to the resulting increases if any modifications are added to the design upon receipt of the piece.<\\/li><\\/ol>\",\"updated_at\":\"2025-04-12T19:10:26.000000Z\"}}', NULL, '2025-04-12 19:11:45', '2025-04-12 19:11:45'),
(131, 'default', 'updated', 'App\\Models\\InvoiceTemplateSetting', 'updated', 1, 'App\\Models\\User', 1, '{\"attributes\":{\"value_en\":\"<p><strong>Payment, return and exchange policy<\\/strong><\\/p><p><strong>First: Ready-made pieces<\\/strong><\\/p><p>If the piece is received as it is without modifications or repairs, the full amount will be paid and the amount can be refunded within one day and replaced within 3 days, provided that the piece is in good condition. In the event of repairs or modifications to the piece, the full amount is paid, non-refundable and exchangeable.<\\/p><p><strong>Second: Special design<\\/strong><\\/p><ol><li>50% of the design and implementation amount is paid as a non-refundable deposit after agreement and approval of the design.<\\/li><li>The full amount is paid for the value of the fabrics before they are cut after agreement and approval. It is non-refundable.<\\/li><li>The remaining 50% of the design and implementation value will be paid in addition to the resulting increases if any modifications are added to the design upon receipt of the piece.<\\/li><\\/ol>\",\"updated_at\":\"2025-04-12T19:11:52.000000Z\"},\"old\":{\"value_en\":\"<p>a<\\/p>\",\"updated_at\":\"2025-04-12T19:11:45.000000Z\"}}', NULL, '2025-04-12 19:11:52', '2025-04-12 19:11:52'),
(132, 'default', 'created', 'App\\Models\\InvoiceTemplateSetting', 'created', 2, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":2,\"key_name\":\"fds\",\"company_id\":1,\"value_en\":\"<p>fsda<\\/p>\",\"value_ar\":\"<p>gfsd<\\/p>\",\"created_at\":\"2025-04-12T19:12:06.000000Z\",\"updated_at\":\"2025-04-12T19:12:06.000000Z\"}}', NULL, '2025-04-12 19:12:06', '2025-04-12 19:12:06'),
(133, 'default', 'deleted', 'App\\Models\\InvoiceTemplateSetting', 'deleted', 2, 'App\\Models\\User', 1, '{\"old\":{\"id\":2,\"key_name\":\"fds\",\"company_id\":1,\"value_en\":\"<p>fsda<\\/p>\",\"value_ar\":\"<p>gfsd<\\/p>\",\"created_at\":\"2025-04-12T19:12:06.000000Z\",\"updated_at\":\"2025-04-12T19:12:06.000000Z\"}}', NULL, '2025-04-12 19:12:11', '2025-04-12 19:12:11'),
(134, 'default', 'created', 'App\\Models\\PointOfSale', 'created', 1, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":1,\"name_en\":\"Saloon pos\",\"name_ar\":\"\\u0635\\u0627\\u0644\\u0648\\u0646 \\u0628\\u0648\\u0641\",\"description_en\":\"<p>Saloon pos<\\/p>\",\"description_ar\":\"<p dir=\\\"rtl\\\">\\u0635\\u0627\\u0644\\u0648\\u0646 \\u0628\\u0648\\u0641<\\/p>\",\"company_id\":null,\"is_active\":true,\"meta\":[],\"created_at\":\"2025-04-13T13:23:02.000000Z\",\"updated_at\":\"2025-04-13T13:23:02.000000Z\",\"deleted_at\":null}}', NULL, '2025-04-13 13:23:02', '2025-04-13 13:23:02'),
(135, 'default', 'created', 'App\\Models\\PointOfSale', 'created', 2, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":2,\"name_en\":\"Saloon pos\",\"name_ar\":\"\\u0635\\u0627\\u0644\\u0648\\u0646 \\u0628\\u0648\\u0641\",\"description_en\":\"<p>Saloon pos<\\/p>\",\"description_ar\":\"<p dir=\\\"rtl\\\">\\u0635\\u0627\\u0644\\u0648\\u0646 \\u0628\\u0648\\u0641<\\/p>\",\"company_id\":null,\"is_active\":true,\"meta\":[],\"created_at\":\"2025-04-13T13:24:52.000000Z\",\"updated_at\":\"2025-04-13T13:24:52.000000Z\",\"deleted_at\":null}}', NULL, '2025-04-13 13:24:52', '2025-04-13 13:24:52'),
(136, 'default', 'deleted', 'App\\Models\\PointOfSale', 'deleted', 2, 'App\\Models\\User', 1, '{\"old\":{\"id\":2,\"name_en\":\"Saloon pos\",\"name_ar\":\"\\u0635\\u0627\\u0644\\u0648\\u0646 \\u0628\\u0648\\u0641\",\"description_en\":\"<p>Saloon pos<\\/p>\",\"description_ar\":\"<p dir=\\\"rtl\\\">\\u0635\\u0627\\u0644\\u0648\\u0646 \\u0628\\u0648\\u0641<\\/p>\",\"company_id\":null,\"is_active\":true,\"meta\":[],\"created_at\":\"2025-04-13T13:24:52.000000Z\",\"updated_at\":\"2025-04-13T13:25:50.000000Z\",\"deleted_at\":\"2025-04-13T13:25:50.000000Z\"}}', NULL, '2025-04-13 13:25:50', '2025-04-13 13:25:50'),
(137, 'default', 'created', 'App\\Models\\PointOfSale', 'created', 3, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":3,\"name_en\":\"\\u0635\\u0627\\u0644\\u0648\\u0646 \\u0628\\u0648\\u0641\",\"name_ar\":\"\\u0635\\u0627\\u0644\\u0648\\u0646 \\u0628\\u0648\\u0641\",\"description_en\":\"<p dir=\\\"rtl\\\">\\u0635\\u0627\\u0644\\u0648\\u0646 \\u0628\\u0648\\u0641<\\/p>\",\"description_ar\":\"<p dir=\\\"rtl\\\">\\u0635\\u0627\\u0644\\u0648\\u0646 \\u0628\\u0648\\u0641<\\/p>\",\"company_id\":1,\"is_active\":true,\"meta\":[],\"created_at\":\"2025-04-13T13:26:11.000000Z\",\"updated_at\":\"2025-04-13T13:26:11.000000Z\",\"deleted_at\":null}}', NULL, '2025-04-13 13:26:11', '2025-04-13 13:26:11'),
(138, 'default', 'updated', 'App\\Models\\PointOfSale', 'updated', 3, 'App\\Models\\User', 1, '{\"attributes\":{\"name_en\":\"Saloon pos\",\"description_en\":\"<p>Saloon pos<\\/p>\",\"updated_at\":\"2025-04-13T13:26:51.000000Z\"},\"old\":{\"name_en\":\"\\u0635\\u0627\\u0644\\u0648\\u0646 \\u0628\\u0648\\u0641\",\"description_en\":\"<p dir=\\\"rtl\\\">\\u0635\\u0627\\u0644\\u0648\\u0646 \\u0628\\u0648\\u0641<\\/p>\",\"updated_at\":\"2025-04-13T13:26:11.000000Z\"}}', NULL, '2025-04-13 13:26:51', '2025-04-13 13:26:51'),
(139, 'default', 'created', 'App\\Models\\PointOfSale', 'created', 4, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":4,\"name_en\":\"Saloon 2 POS\",\"name_ar\":\"\\u0635\\u0627\\u0644\\u0648\\u0646 2 \\u0646\\u0642\\u0637\\u0629 \\u0628\\u064a\\u0639\",\"description_en\":null,\"description_ar\":null,\"company_id\":null,\"is_active\":true,\"meta\":null,\"created_at\":\"2025-04-13T13:32:50.000000Z\",\"updated_at\":\"2025-04-13T13:32:50.000000Z\",\"deleted_at\":null}}', NULL, '2025-04-13 13:32:50', '2025-04-13 13:32:50'),
(140, 'default', 'updated', 'App\\Models\\Product', 'updated', 2, 'App\\Models\\User', 1, '{\"attributes\":{\"point_of_sale_id\":3,\"updated_at\":\"2025-04-13T13:34:36.000000Z\"},\"old\":{\"point_of_sale_id\":null,\"updated_at\":\"2025-04-10T13:57:00.000000Z\"}}', NULL, '2025-04-13 13:34:36', '2025-04-13 13:34:36'),
(141, 'default', 'created', 'App\\Models\\User', 'created', 3, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":3,\"first_name\":\"Zain\",\"last_name\":\"ul Eman\",\"email\":\"zainuleman786@gmail.com\",\"phone_number\":null,\"email_verified_at\":null,\"password\":\"$2y$10$YRIDYGcTaagYu96iq35vsueeVXimX62SiCabXpAjXKPIe0yGnvOrq\",\"remember_token\":null,\"created_at\":\"2025-04-13T13:53:21.000000Z\",\"updated_at\":\"2025-04-13T13:53:21.000000Z\",\"company_id\":1,\"point_of_sale_id\":3}}', NULL, '2025-04-13 13:53:21', '2025-04-13 13:53:21'),
(142, 'default', 'created', 'App\\Models\\PointOfSale', 'created', 5, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":5,\"name_en\":\"Saloon 2 POS\",\"name_ar\":\"\\u0635\\u0627\\u0644\\u0648\\u0646 2 \\u0646\\u0642\\u0637\\u0629 \\u0628\\u064a\\u0639\",\"description_en\":\"<p>Saloon 2 POS<\\/p>\",\"description_ar\":\"<p dir=\\\"rtl\\\">\\u0635\\u0627\\u0644\\u0648\\u0646 2 \\u0646\\u0642\\u0637\\u0629 \\u0628\\u064a\\u0639<\\/p>\",\"company_id\":1,\"is_active\":true,\"meta\":[],\"created_at\":\"2025-04-13T14:02:06.000000Z\",\"updated_at\":\"2025-04-13T14:02:06.000000Z\",\"deleted_at\":null}}', NULL, '2025-04-13 14:02:06', '2025-04-13 14:02:06'),
(143, 'default', 'updated', 'App\\Models\\Customer', 'updated', 1, 'App\\Models\\User', 1, '{\"attributes\":{\"updated_at\":\"2025-04-13T14:13:25.000000Z\",\"point_of_sale_id\":3},\"old\":{\"updated_at\":\"2025-04-09T16:37:08.000000Z\",\"point_of_sale_id\":null}}', NULL, '2025-04-13 14:13:25', '2025-04-13 14:13:25'),
(144, 'default', 'updated', 'App\\Models\\Order', 'updated', 8, 'App\\Models\\User', 1, '{\"attributes\":{\"point_of_sale_id\":3},\"old\":{\"point_of_sale_id\":5}}', NULL, '2025-04-13 14:37:39', '2025-04-13 14:37:39'),
(145, 'default', 'created', 'App\\Models\\Customer', 'created', 4, 'App\\Models\\User', 3, '{\"attributes\":{\"id\":4,\"first_name\":\"Talah\",\"last_name\":\"Hafeez\",\"email\":\"talah@gmail.com\",\"phone_number\":\"35345342\",\"company_id\":null,\"is_active\":true,\"meta\":null,\"created_at\":\"2025-04-13T14:42:38.000000Z\",\"updated_at\":\"2025-04-13T14:42:38.000000Z\",\"deleted_at\":null,\"vat_number\":\"4645364\",\"address\":\"Tauna\",\"point_of_sale_id\":null}}', NULL, '2025-04-13 14:42:38', '2025-04-13 14:42:38'),
(146, 'default', 'created', 'App\\Models\\Customer', 'created', 5, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":5,\"first_name\":\"Usama\",\"last_name\":\"Hafeeez\",\"email\":\"usama@gmail.com\",\"phone_number\":\"3534523\",\"company_id\":1,\"is_active\":true,\"meta\":null,\"created_at\":\"2025-04-13T14:43:07.000000Z\",\"updated_at\":\"2025-04-13T14:43:07.000000Z\",\"deleted_at\":null,\"vat_number\":\"3534523\",\"address\":\"taunsa sharif\",\"point_of_sale_id\":5}}', NULL, '2025-04-13 14:43:07', '2025-04-13 14:43:07'),
(147, 'default', 'created', 'App\\Models\\Customer', 'created', 6, 'App\\Models\\User', 3, '{\"attributes\":{\"id\":6,\"first_name\":\"Talah\",\"last_name\":\"Hageex\",\"email\":\"talah@gmail.com\",\"phone_number\":\"353453\",\"company_id\":null,\"is_active\":true,\"meta\":null,\"created_at\":\"2025-04-13T14:44:29.000000Z\",\"updated_at\":\"2025-04-13T14:44:29.000000Z\",\"deleted_at\":null,\"vat_number\":\"7t6868\",\"address\":\"Tausna\",\"point_of_sale_id\":null}}', NULL, '2025-04-13 14:44:29', '2025-04-13 14:44:29'),
(148, 'default', 'created', 'App\\Models\\Customer', 'created', 7, 'App\\Models\\User', 3, '{\"attributes\":{\"id\":7,\"first_name\":\"Talah\",\"last_name\":\"Hafeez\",\"email\":\"talah@gmail.com\",\"phone_number\":\"3534532\",\"company_id\":1,\"is_active\":true,\"meta\":null,\"created_at\":\"2025-04-13T14:45:43.000000Z\",\"updated_at\":\"2025-04-13T14:45:43.000000Z\",\"deleted_at\":null,\"vat_number\":\"353543\",\"address\":\"Tausna\",\"point_of_sale_id\":3}}', NULL, '2025-04-13 14:45:43', '2025-04-13 14:45:43'),
(149, 'default', 'created', 'App\\Models\\Customer', 'created', 8, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":8,\"first_name\":\"Usama\",\"last_name\":\"Hafeez\",\"email\":\"usama@gmail.com\",\"phone_number\":\"3253534\",\"company_id\":1,\"is_active\":true,\"meta\":null,\"created_at\":\"2025-04-13T14:46:30.000000Z\",\"updated_at\":\"2025-04-13T14:46:30.000000Z\",\"deleted_at\":null,\"vat_number\":\"7897897\",\"address\":\"Taunsa Shairf\",\"point_of_sale_id\":5}}', NULL, '2025-04-13 14:46:30', '2025-04-13 14:46:30'),
(150, 'default', 'updated', 'App\\Models\\Order', 'updated', 8, 'App\\Models\\User', 1, '{\"attributes\":{\"point_of_sale_id\":5},\"old\":{\"point_of_sale_id\":3}}', NULL, '2025-04-13 14:50:42', '2025-04-13 14:50:42'),
(151, 'default', 'updated', 'App\\Models\\Order', 'updated', 8, 'App\\Models\\User', 1, '{\"attributes\":{\"point_of_sale_id\":3},\"old\":{\"point_of_sale_id\":5}}', NULL, '2025-04-13 14:50:57', '2025-04-13 14:50:57'),
(152, 'default', 'created', 'App\\Models\\Invoice', 'created', 1, 'App\\Models\\User', 3, '{\"attributes\":{\"id\":1,\"number\":\"INV-000001\",\"customer_name\":\"Zain ul Eman\",\"customer_email\":\"zainuleman786@gmail.com\",\"customer_phone\":null,\"company_id\":1,\"customer_id\":1,\"billing_address_id\":null,\"shipping_address_id\":null,\"subtotal\":240,\"discount_amount\":53,\"total_amount\":238,\"issue_date\":\"2025-04-13T16:02:06.000000Z\",\"due_date\":\"2025-05-13T16:02:06.000000Z\",\"paid_date\":null,\"invoice_status_id\":1,\"currency_id\":null,\"issued_by_user\":3,\"meta\":null,\"created_at\":\"2025-04-13T16:02:06.000000Z\",\"updated_at\":\"2025-04-13T16:02:06.000000Z\",\"deleted_at\":null,\"amount_paid\":0,\"point_of_sale_id\":3,\"vat\":36,\"other_taxes\":15}}', NULL, '2025-04-13 16:02:06', '2025-04-13 16:02:06'),
(153, 'default', 'created', 'App\\Models\\InvoiceItem', 'created', 1, 'App\\Models\\User', 3, '{\"attributes\":{\"id\":1,\"invoice_id\":1,\"product_name_en\":\"coke\",\"product_name_ar\":\"coke\",\"product_description_en\":null,\"product_description_ar\":null,\"product_sku\":\"234\",\"product_code\":\"532\",\"quantity\":1,\"unit_price\":100,\"tax_id\":null,\"discount_amount\":50,\"subtotal\":0,\"total\":0,\"created_at\":\"2025-04-13T16:02:06.000000Z\",\"updated_at\":\"2025-04-13T16:02:06.000000Z\",\"deleted_at\":null,\"note\":null,\"vat_amount\":15,\"other_taxes_amount\":10}}', NULL, '2025-04-13 16:02:06', '2025-04-13 16:02:06'),
(154, 'default', 'created', 'App\\Models\\InvoiceItem', 'created', 2, 'App\\Models\\User', 3, '{\"attributes\":{\"id\":2,\"invoice_id\":1,\"product_name_en\":\"Pepsi\",\"product_name_ar\":\"\\u0628\\u064a\\u0628\\u0633\\u064a\",\"product_description_en\":\"pepsi\",\"product_description_ar\":\"\\u0628\\u064a\\u0628\\u0633\\u064a ... \\u0628\\u064a\\u0628\\u0633\\u064a (\\u0628\\u0627\\u0644\\u0625\\u0646\\u062c\\u0644\\u064a\\u0632\\u064a\\u0629: Pepsi)\\u200f \\u0647\\u0648 \\u0645\\u0634\\u0631\\u0648\\u0628 \\u063a\\u0627\\u0632\\u064a \\u0645\\u0643\\u0631\\u0628\\u0646 \\u062a\\u0635\\u0646\\u0639\\u0647 \\u0634\\u0631\\u0643\\u0629 \\u0628\\u064a\\u0628\\u0633\\u064a\\u0643\\u0648 (\\u062d\\u0627\\u0644\\u064a\\u064b\\u0651\\u0627). ... \\u0648\\u064a\\u0631\\u062c\\u0639 \\u0625\\u0646\\u0634\\u0627\\u0624\\u0647 \\u0648\\u062a\\u0637\\u0648\\u064a\\u0631\\u0647 \\u0641\\u064a \\u0627\\u0644\\u0623\\u0635\\u0644 \\u0625\\u0644\\u0649 \\u0639\\u0627\\u0645 1893 \\u0639\\u0644\\u0649 \\u064a\\u062f \\u0627\\u0644\\u0635\\u064a\\u062f\\u0644\\u0627\\u0646\\u064a \\u0643\\u0627\\u0644\\u064a\\u0628 \\u0628\\u0631\\u0627\\u062f\\u0647\\u0627\\u0645\\u060c ...\\n\",\"product_sku\":\"23423\",\"product_code\":\"1231\",\"quantity\":10,\"unit_price\":2,\"tax_id\":null,\"discount_amount\":3,\"subtotal\":0,\"total\":0,\"created_at\":\"2025-04-13T16:02:06.000000Z\",\"updated_at\":\"2025-04-13T16:02:06.000000Z\",\"deleted_at\":null,\"note\":null,\"vat_amount\":0.3,\"other_taxes_amount\":0.5}}', NULL, '2025-04-13 16:02:06', '2025-04-13 16:02:06'),
(155, 'default', 'created', 'App\\Models\\InvoiceItem', 'created', 3, 'App\\Models\\User', 3, '{\"attributes\":{\"id\":3,\"invoice_id\":1,\"product_name_en\":\"Red bull\",\"product_name_ar\":\"Red bull\",\"product_description_en\":null,\"product_description_ar\":\"Red bull\",\"product_sku\":null,\"product_code\":null,\"quantity\":1,\"unit_price\":120,\"tax_id\":null,\"discount_amount\":0,\"subtotal\":0,\"total\":0,\"created_at\":\"2025-04-13T16:02:06.000000Z\",\"updated_at\":\"2025-04-13T16:02:06.000000Z\",\"deleted_at\":null,\"note\":null,\"vat_amount\":18,\"other_taxes_amount\":0}}', NULL, '2025-04-13 16:02:06', '2025-04-13 16:02:06');
INSERT INTO `activity_logs` (`id`, `log_name`, `description`, `subject_type`, `event`, `subject_id`, `causer_type`, `causer_id`, `properties`, `batch_uuid`, `created_at`, `updated_at`) VALUES
(156, 'default', 'created', 'App\\Models\\Invoice', 'created', 2, 'App\\Models\\User', 3, '{\"attributes\":{\"id\":2,\"number\":\"INV-000002\",\"customer_name\":\"Zain ul Eman\",\"customer_email\":\"zainuleman786@gmail.com\",\"customer_phone\":null,\"company_id\":1,\"customer_id\":1,\"billing_address_id\":null,\"shipping_address_id\":null,\"subtotal\":240,\"discount_amount\":53,\"total_amount\":238,\"issue_date\":\"2025-04-13T13:02:06.000000Z\",\"due_date\":\"2025-05-13T13:02:06.000000Z\",\"paid_date\":null,\"invoice_status_id\":1,\"currency_id\":null,\"issued_by_user\":3,\"meta\":null,\"created_at\":\"2025-04-13T16:02:06.000000Z\",\"updated_at\":\"2025-04-13T16:02:06.000000Z\",\"deleted_at\":null,\"amount_paid\":0,\"point_of_sale_id\":3,\"vat\":36,\"other_taxes\":15}}', NULL, '2025-04-13 16:02:06', '2025-04-13 16:02:06'),
(157, 'default', 'deleted', 'App\\Models\\Invoice', 'deleted', 1, 'App\\Models\\User', 3, '{\"old\":{\"id\":1,\"number\":\"INV-000001\",\"customer_name\":\"Zain ul Eman\",\"customer_email\":\"zainuleman786@gmail.com\",\"customer_phone\":null,\"company_id\":1,\"customer_id\":1,\"billing_address_id\":null,\"shipping_address_id\":null,\"subtotal\":240,\"discount_amount\":53,\"total_amount\":238,\"issue_date\":\"2025-04-13T16:02:06.000000Z\",\"due_date\":\"2025-05-13T16:02:06.000000Z\",\"paid_date\":null,\"invoice_status_id\":1,\"currency_id\":null,\"issued_by_user\":3,\"meta\":null,\"created_at\":\"2025-04-13T16:02:06.000000Z\",\"updated_at\":\"2025-04-13T16:02:46.000000Z\",\"deleted_at\":\"2025-04-13T16:02:46.000000Z\",\"amount_paid\":0,\"point_of_sale_id\":3,\"vat\":36,\"other_taxes\":15}}', NULL, '2025-04-13 16:02:46', '2025-04-13 16:02:46'),
(158, 'default', 'deleted', 'App\\Models\\Invoice', 'deleted', 2, 'App\\Models\\User', 3, '{\"old\":{\"id\":2,\"number\":\"INV-000002\",\"customer_name\":\"Zain ul Eman\",\"customer_email\":\"zainuleman786@gmail.com\",\"customer_phone\":null,\"company_id\":1,\"customer_id\":1,\"billing_address_id\":null,\"shipping_address_id\":null,\"subtotal\":240,\"discount_amount\":53,\"total_amount\":238,\"issue_date\":\"2025-04-13T13:02:06.000000Z\",\"due_date\":\"2025-05-13T13:02:06.000000Z\",\"paid_date\":null,\"invoice_status_id\":1,\"currency_id\":null,\"issued_by_user\":3,\"meta\":null,\"created_at\":\"2025-04-13T16:02:06.000000Z\",\"updated_at\":\"2025-04-13T16:02:46.000000Z\",\"deleted_at\":\"2025-04-13T16:02:46.000000Z\",\"amount_paid\":0,\"point_of_sale_id\":3,\"vat\":36,\"other_taxes\":15}}', NULL, '2025-04-13 16:02:46', '2025-04-13 16:02:46'),
(159, 'default', 'created', 'App\\Models\\Invoice', 'created', 3, 'App\\Models\\User', 3, '{\"attributes\":{\"id\":3,\"number\":\"INV-000001\",\"customer_name\":\"Zain ul Eman\",\"customer_email\":\"zainuleman786@gmail.com\",\"customer_phone\":null,\"company_id\":1,\"customer_id\":1,\"billing_address_id\":null,\"shipping_address_id\":null,\"subtotal\":240,\"discount_amount\":53,\"total_amount\":238,\"issue_date\":\"2025-04-13T16:03:28.000000Z\",\"due_date\":\"2025-05-13T16:03:28.000000Z\",\"paid_date\":null,\"invoice_status_id\":1,\"currency_id\":null,\"issued_by_user\":3,\"meta\":null,\"created_at\":\"2025-04-13T16:03:28.000000Z\",\"updated_at\":\"2025-04-13T16:03:28.000000Z\",\"deleted_at\":null,\"amount_paid\":0,\"point_of_sale_id\":3,\"vat\":36,\"other_taxes\":15}}', NULL, '2025-04-13 16:03:28', '2025-04-13 16:03:28'),
(160, 'default', 'created', 'App\\Models\\InvoiceItem', 'created', 4, 'App\\Models\\User', 3, '{\"attributes\":{\"id\":4,\"invoice_id\":3,\"product_name_en\":\"coke\",\"product_name_ar\":\"coke\",\"product_description_en\":null,\"product_description_ar\":null,\"product_sku\":\"234\",\"product_code\":\"532\",\"quantity\":1,\"unit_price\":100,\"tax_id\":null,\"discount_amount\":50,\"subtotal\":0,\"total\":0,\"created_at\":\"2025-04-13T16:03:28.000000Z\",\"updated_at\":\"2025-04-13T16:03:28.000000Z\",\"deleted_at\":null,\"note\":null,\"vat_amount\":15,\"other_taxes_amount\":10}}', NULL, '2025-04-13 16:03:28', '2025-04-13 16:03:28'),
(161, 'default', 'created', 'App\\Models\\InvoiceItem', 'created', 5, 'App\\Models\\User', 3, '{\"attributes\":{\"id\":5,\"invoice_id\":3,\"product_name_en\":\"Pepsi\",\"product_name_ar\":\"\\u0628\\u064a\\u0628\\u0633\\u064a\",\"product_description_en\":\"pepsi\",\"product_description_ar\":\"\\u0628\\u064a\\u0628\\u0633\\u064a ... \\u0628\\u064a\\u0628\\u0633\\u064a (\\u0628\\u0627\\u0644\\u0625\\u0646\\u062c\\u0644\\u064a\\u0632\\u064a\\u0629: Pepsi)\\u200f \\u0647\\u0648 \\u0645\\u0634\\u0631\\u0648\\u0628 \\u063a\\u0627\\u0632\\u064a \\u0645\\u0643\\u0631\\u0628\\u0646 \\u062a\\u0635\\u0646\\u0639\\u0647 \\u0634\\u0631\\u0643\\u0629 \\u0628\\u064a\\u0628\\u0633\\u064a\\u0643\\u0648 (\\u062d\\u0627\\u0644\\u064a\\u064b\\u0651\\u0627). ... \\u0648\\u064a\\u0631\\u062c\\u0639 \\u0625\\u0646\\u0634\\u0627\\u0624\\u0647 \\u0648\\u062a\\u0637\\u0648\\u064a\\u0631\\u0647 \\u0641\\u064a \\u0627\\u0644\\u0623\\u0635\\u0644 \\u0625\\u0644\\u0649 \\u0639\\u0627\\u0645 1893 \\u0639\\u0644\\u0649 \\u064a\\u062f \\u0627\\u0644\\u0635\\u064a\\u062f\\u0644\\u0627\\u0646\\u064a \\u0643\\u0627\\u0644\\u064a\\u0628 \\u0628\\u0631\\u0627\\u062f\\u0647\\u0627\\u0645\\u060c ...\\n\",\"product_sku\":\"23423\",\"product_code\":\"1231\",\"quantity\":10,\"unit_price\":2,\"tax_id\":null,\"discount_amount\":3,\"subtotal\":0,\"total\":0,\"created_at\":\"2025-04-13T16:03:28.000000Z\",\"updated_at\":\"2025-04-13T16:03:28.000000Z\",\"deleted_at\":null,\"note\":null,\"vat_amount\":0.3,\"other_taxes_amount\":0.5}}', NULL, '2025-04-13 16:03:28', '2025-04-13 16:03:28'),
(162, 'default', 'created', 'App\\Models\\InvoiceItem', 'created', 6, 'App\\Models\\User', 3, '{\"attributes\":{\"id\":6,\"invoice_id\":3,\"product_name_en\":\"Red bull\",\"product_name_ar\":\"Red bull\",\"product_description_en\":null,\"product_description_ar\":\"Red bull\",\"product_sku\":null,\"product_code\":null,\"quantity\":1,\"unit_price\":120,\"tax_id\":null,\"discount_amount\":0,\"subtotal\":0,\"total\":0,\"created_at\":\"2025-04-13T16:03:28.000000Z\",\"updated_at\":\"2025-04-13T16:03:28.000000Z\",\"deleted_at\":null,\"note\":null,\"vat_amount\":18,\"other_taxes_amount\":0}}', NULL, '2025-04-13 16:03:28', '2025-04-13 16:03:28'),
(163, 'default', 'created', 'App\\Models\\Invoice', 'created', 4, 'App\\Models\\User', 3, '{\"attributes\":{\"id\":4,\"number\":\"INV-000002\",\"customer_name\":\"Zain ul Eman\",\"customer_email\":\"zainuleman786@gmail.com\",\"customer_phone\":null,\"company_id\":1,\"customer_id\":1,\"billing_address_id\":null,\"shipping_address_id\":null,\"subtotal\":240,\"discount_amount\":53,\"total_amount\":238,\"issue_date\":\"2025-04-13T13:03:28.000000Z\",\"due_date\":\"2025-05-13T13:03:28.000000Z\",\"paid_date\":null,\"invoice_status_id\":1,\"currency_id\":null,\"issued_by_user\":3,\"meta\":null,\"created_at\":\"2025-04-13T16:03:28.000000Z\",\"updated_at\":\"2025-04-13T16:03:28.000000Z\",\"deleted_at\":null,\"amount_paid\":0,\"point_of_sale_id\":3,\"vat\":36,\"other_taxes\":15}}', NULL, '2025-04-13 16:03:28', '2025-04-13 16:03:28'),
(164, 'default', 'created', 'App\\Models\\Invoice', 'created', 5, 'App\\Models\\User', 3, '{\"attributes\":{\"id\":5,\"number\":\"INV-000001\",\"customer_name\":\"Zain ul Eman\",\"customer_email\":\"zainuleman786@gmail.com\",\"customer_phone\":null,\"company_id\":1,\"customer_id\":1,\"billing_address_id\":null,\"shipping_address_id\":null,\"subtotal\":240,\"discount_amount\":53,\"total_amount\":238,\"issue_date\":\"2025-04-13T16:05:12.000000Z\",\"due_date\":\"2025-05-13T16:05:12.000000Z\",\"paid_date\":null,\"invoice_status_id\":1,\"currency_id\":null,\"issued_by_user\":3,\"meta\":null,\"created_at\":\"2025-04-13T16:05:12.000000Z\",\"updated_at\":\"2025-04-13T16:05:12.000000Z\",\"deleted_at\":null,\"amount_paid\":0,\"point_of_sale_id\":3,\"vat\":36,\"other_taxes\":15}}', NULL, '2025-04-13 16:05:12', '2025-04-13 16:05:12'),
(165, 'default', 'created', 'App\\Models\\InvoiceItem', 'created', 7, 'App\\Models\\User', 3, '{\"attributes\":{\"id\":7,\"invoice_id\":5,\"product_name_en\":\"coke\",\"product_name_ar\":\"coke\",\"product_description_en\":null,\"product_description_ar\":null,\"product_sku\":\"234\",\"product_code\":\"532\",\"quantity\":1,\"unit_price\":100,\"tax_id\":null,\"discount_amount\":50,\"subtotal\":0,\"total\":0,\"created_at\":\"2025-04-13T16:05:12.000000Z\",\"updated_at\":\"2025-04-13T16:05:12.000000Z\",\"deleted_at\":null,\"note\":null,\"vat_amount\":15,\"other_taxes_amount\":10}}', NULL, '2025-04-13 16:05:12', '2025-04-13 16:05:12'),
(166, 'default', 'created', 'App\\Models\\InvoiceItem', 'created', 8, 'App\\Models\\User', 3, '{\"attributes\":{\"id\":8,\"invoice_id\":5,\"product_name_en\":\"Pepsi\",\"product_name_ar\":\"\\u0628\\u064a\\u0628\\u0633\\u064a\",\"product_description_en\":\"pepsi\",\"product_description_ar\":\"\\u0628\\u064a\\u0628\\u0633\\u064a ... \\u0628\\u064a\\u0628\\u0633\\u064a (\\u0628\\u0627\\u0644\\u0625\\u0646\\u062c\\u0644\\u064a\\u0632\\u064a\\u0629: Pepsi)\\u200f \\u0647\\u0648 \\u0645\\u0634\\u0631\\u0648\\u0628 \\u063a\\u0627\\u0632\\u064a \\u0645\\u0643\\u0631\\u0628\\u0646 \\u062a\\u0635\\u0646\\u0639\\u0647 \\u0634\\u0631\\u0643\\u0629 \\u0628\\u064a\\u0628\\u0633\\u064a\\u0643\\u0648 (\\u062d\\u0627\\u0644\\u064a\\u064b\\u0651\\u0627). ... \\u0648\\u064a\\u0631\\u062c\\u0639 \\u0625\\u0646\\u0634\\u0627\\u0624\\u0647 \\u0648\\u062a\\u0637\\u0648\\u064a\\u0631\\u0647 \\u0641\\u064a \\u0627\\u0644\\u0623\\u0635\\u0644 \\u0625\\u0644\\u0649 \\u0639\\u0627\\u0645 1893 \\u0639\\u0644\\u0649 \\u064a\\u062f \\u0627\\u0644\\u0635\\u064a\\u062f\\u0644\\u0627\\u0646\\u064a \\u0643\\u0627\\u0644\\u064a\\u0628 \\u0628\\u0631\\u0627\\u062f\\u0647\\u0627\\u0645\\u060c ...\\n\",\"product_sku\":\"23423\",\"product_code\":\"1231\",\"quantity\":10,\"unit_price\":2,\"tax_id\":null,\"discount_amount\":3,\"subtotal\":0,\"total\":0,\"created_at\":\"2025-04-13T16:05:12.000000Z\",\"updated_at\":\"2025-04-13T16:05:12.000000Z\",\"deleted_at\":null,\"note\":null,\"vat_amount\":0.3,\"other_taxes_amount\":0.5}}', NULL, '2025-04-13 16:05:12', '2025-04-13 16:05:12'),
(167, 'default', 'created', 'App\\Models\\InvoiceItem', 'created', 9, 'App\\Models\\User', 3, '{\"attributes\":{\"id\":9,\"invoice_id\":5,\"product_name_en\":\"Red bull\",\"product_name_ar\":\"Red bull\",\"product_description_en\":null,\"product_description_ar\":\"Red bull\",\"product_sku\":null,\"product_code\":null,\"quantity\":1,\"unit_price\":120,\"tax_id\":null,\"discount_amount\":0,\"subtotal\":0,\"total\":0,\"created_at\":\"2025-04-13T16:05:12.000000Z\",\"updated_at\":\"2025-04-13T16:05:12.000000Z\",\"deleted_at\":null,\"note\":null,\"vat_amount\":18,\"other_taxes_amount\":0}}', NULL, '2025-04-13 16:05:12', '2025-04-13 16:05:12'),
(168, 'default', 'updated', 'App\\Models\\Invoice', 'updated', 5, 'App\\Models\\User', 3, '{\"attributes\":{\"issue_date\":\"2025-04-12T21:00:00.000000Z\",\"updated_at\":\"2025-04-13T16:12:57.000000Z\",\"order_id\":8},\"old\":{\"issue_date\":\"2025-04-13T16:05:12.000000Z\",\"updated_at\":\"2025-04-13T16:05:12.000000Z\",\"order_id\":null}}', NULL, '2025-04-13 16:12:57', '2025-04-13 16:12:57'),
(169, 'default', 'deleted', 'App\\Models\\Invoice', 'deleted', 5, 'App\\Models\\User', 3, '{\"old\":{\"id\":5,\"number\":\"INV-000001\",\"customer_name\":\"Zain ul Eman\",\"customer_email\":\"zainuleman786@gmail.com\",\"customer_phone\":null,\"company_id\":1,\"customer_id\":1,\"billing_address_id\":null,\"shipping_address_id\":null,\"subtotal\":240,\"discount_amount\":53,\"total_amount\":238,\"issue_date\":\"2025-04-12T21:00:00.000000Z\",\"due_date\":\"2025-05-13T16:05:12.000000Z\",\"paid_date\":null,\"invoice_status_id\":1,\"currency_id\":null,\"issued_by_user\":3,\"meta\":null,\"created_at\":\"2025-04-13T16:05:12.000000Z\",\"updated_at\":\"2025-04-13T16:16:29.000000Z\",\"deleted_at\":\"2025-04-13T16:16:29.000000Z\",\"amount_paid\":0,\"point_of_sale_id\":3,\"vat\":36,\"other_taxes\":15,\"order_id\":8}}', NULL, '2025-04-13 16:16:29', '2025-04-13 16:16:29'),
(170, 'default', 'created', 'App\\Models\\Invoice', 'created', 7, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":7,\"number\":\"C001-INV-000001\",\"customer_name\":\"Zain ul Eman\",\"customer_email\":\"zainuleman786@gmail.com\",\"customer_phone\":null,\"company_id\":1,\"customer_id\":1,\"billing_address_id\":null,\"shipping_address_id\":null,\"subtotal\":240,\"discount_amount\":53,\"total_amount\":238,\"issue_date\":\"2025-04-13T16:19:19.000000Z\",\"due_date\":\"2025-05-13T16:19:19.000000Z\",\"paid_date\":null,\"invoice_status_id\":1,\"currency_id\":null,\"issued_by_user\":1,\"meta\":null,\"created_at\":\"2025-04-13T16:19:19.000000Z\",\"updated_at\":\"2025-04-13T16:19:19.000000Z\",\"deleted_at\":null,\"amount_paid\":0,\"point_of_sale_id\":3,\"vat\":36,\"other_taxes\":15,\"order_id\":null}}', NULL, '2025-04-13 16:19:19', '2025-04-13 16:19:19'),
(171, 'default', 'created', 'App\\Models\\Invoice', 'created', 8, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":8,\"number\":\"C001-INV-000002\",\"customer_name\":\"Zain ul Eman\",\"customer_email\":\"zainuleman786@gmail.com\",\"customer_phone\":null,\"company_id\":1,\"customer_id\":1,\"billing_address_id\":null,\"shipping_address_id\":null,\"subtotal\":240,\"discount_amount\":53,\"total_amount\":238,\"issue_date\":\"2025-04-13T16:20:43.000000Z\",\"due_date\":\"2025-05-13T16:20:43.000000Z\",\"paid_date\":null,\"invoice_status_id\":1,\"currency_id\":null,\"issued_by_user\":1,\"meta\":null,\"created_at\":\"2025-04-13T16:20:43.000000Z\",\"updated_at\":\"2025-04-13T16:20:43.000000Z\",\"deleted_at\":null,\"amount_paid\":0,\"point_of_sale_id\":3,\"vat\":36,\"other_taxes\":15,\"order_id\":null}}', NULL, '2025-04-13 16:20:43', '2025-04-13 16:20:43'),
(172, 'default', 'created', 'App\\Models\\InvoiceItem', 'created', 10, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":10,\"invoice_id\":8,\"product_name_en\":\"coke\",\"product_name_ar\":\"coke\",\"product_description_en\":null,\"product_description_ar\":null,\"product_sku\":\"234\",\"product_code\":\"532\",\"quantity\":1,\"unit_price\":100,\"tax_id\":null,\"discount_amount\":50,\"subtotal\":0,\"total\":0,\"created_at\":\"2025-04-13T16:20:43.000000Z\",\"updated_at\":\"2025-04-13T16:20:43.000000Z\",\"deleted_at\":null,\"note\":null,\"vat_amount\":15,\"other_taxes_amount\":10}}', NULL, '2025-04-13 16:20:43', '2025-04-13 16:20:43'),
(173, 'default', 'created', 'App\\Models\\InvoiceItem', 'created', 11, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":11,\"invoice_id\":8,\"product_name_en\":\"Pepsi\",\"product_name_ar\":\"\\u0628\\u064a\\u0628\\u0633\\u064a\",\"product_description_en\":\"pepsi\",\"product_description_ar\":\"\\u0628\\u064a\\u0628\\u0633\\u064a ... \\u0628\\u064a\\u0628\\u0633\\u064a (\\u0628\\u0627\\u0644\\u0625\\u0646\\u062c\\u0644\\u064a\\u0632\\u064a\\u0629: Pepsi)\\u200f \\u0647\\u0648 \\u0645\\u0634\\u0631\\u0648\\u0628 \\u063a\\u0627\\u0632\\u064a \\u0645\\u0643\\u0631\\u0628\\u0646 \\u062a\\u0635\\u0646\\u0639\\u0647 \\u0634\\u0631\\u0643\\u0629 \\u0628\\u064a\\u0628\\u0633\\u064a\\u0643\\u0648 (\\u062d\\u0627\\u0644\\u064a\\u064b\\u0651\\u0627). ... \\u0648\\u064a\\u0631\\u062c\\u0639 \\u0625\\u0646\\u0634\\u0627\\u0624\\u0647 \\u0648\\u062a\\u0637\\u0648\\u064a\\u0631\\u0647 \\u0641\\u064a \\u0627\\u0644\\u0623\\u0635\\u0644 \\u0625\\u0644\\u0649 \\u0639\\u0627\\u0645 1893 \\u0639\\u0644\\u0649 \\u064a\\u062f \\u0627\\u0644\\u0635\\u064a\\u062f\\u0644\\u0627\\u0646\\u064a \\u0643\\u0627\\u0644\\u064a\\u0628 \\u0628\\u0631\\u0627\\u062f\\u0647\\u0627\\u0645\\u060c ...\\n\",\"product_sku\":\"23423\",\"product_code\":\"1231\",\"quantity\":10,\"unit_price\":2,\"tax_id\":null,\"discount_amount\":3,\"subtotal\":0,\"total\":0,\"created_at\":\"2025-04-13T16:20:43.000000Z\",\"updated_at\":\"2025-04-13T16:20:43.000000Z\",\"deleted_at\":null,\"note\":null,\"vat_amount\":0.3,\"other_taxes_amount\":0.5}}', NULL, '2025-04-13 16:20:43', '2025-04-13 16:20:43'),
(174, 'default', 'created', 'App\\Models\\InvoiceItem', 'created', 12, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":12,\"invoice_id\":8,\"product_name_en\":\"Red bull\",\"product_name_ar\":\"Red bull\",\"product_description_en\":null,\"product_description_ar\":\"Red bull\",\"product_sku\":null,\"product_code\":null,\"quantity\":1,\"unit_price\":120,\"tax_id\":null,\"discount_amount\":0,\"subtotal\":0,\"total\":0,\"created_at\":\"2025-04-13T16:20:43.000000Z\",\"updated_at\":\"2025-04-13T16:20:43.000000Z\",\"deleted_at\":null,\"note\":null,\"vat_amount\":18,\"other_taxes_amount\":0}}', NULL, '2025-04-13 16:20:43', '2025-04-13 16:20:43'),
(175, 'default', 'created', 'App\\Models\\Invoice', 'created', 9, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":9,\"number\":\"C001-INV-000001\",\"customer_name\":\"Zain ul Eman\",\"customer_email\":\"zainuleman786@gmail.com\",\"customer_phone\":null,\"company_id\":1,\"customer_id\":1,\"billing_address_id\":null,\"shipping_address_id\":null,\"subtotal\":240,\"discount_amount\":53,\"total_amount\":238,\"issue_date\":\"2025-04-13T16:22:18.000000Z\",\"due_date\":\"2025-05-13T16:22:18.000000Z\",\"paid_date\":null,\"invoice_status_id\":1,\"currency_id\":null,\"issued_by_user\":1,\"meta\":null,\"created_at\":\"2025-04-13T16:22:18.000000Z\",\"updated_at\":\"2025-04-13T16:22:18.000000Z\",\"deleted_at\":null,\"amount_paid\":0,\"point_of_sale_id\":3,\"vat\":36,\"other_taxes\":15,\"order_id\":8}}', NULL, '2025-04-13 16:22:18', '2025-04-13 16:22:18'),
(176, 'default', 'created', 'App\\Models\\InvoiceItem', 'created', 13, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":13,\"invoice_id\":9,\"product_name_en\":\"coke\",\"product_name_ar\":\"coke\",\"product_description_en\":null,\"product_description_ar\":null,\"product_sku\":\"234\",\"product_code\":\"532\",\"quantity\":1,\"unit_price\":100,\"tax_id\":null,\"discount_amount\":50,\"subtotal\":0,\"total\":0,\"created_at\":\"2025-04-13T16:22:18.000000Z\",\"updated_at\":\"2025-04-13T16:22:18.000000Z\",\"deleted_at\":null,\"note\":null,\"vat_amount\":15,\"other_taxes_amount\":10}}', NULL, '2025-04-13 16:22:18', '2025-04-13 16:22:18'),
(177, 'default', 'created', 'App\\Models\\InvoiceItem', 'created', 14, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":14,\"invoice_id\":9,\"product_name_en\":\"Pepsi\",\"product_name_ar\":\"\\u0628\\u064a\\u0628\\u0633\\u064a\",\"product_description_en\":\"pepsi\",\"product_description_ar\":\"\\u0628\\u064a\\u0628\\u0633\\u064a ... \\u0628\\u064a\\u0628\\u0633\\u064a (\\u0628\\u0627\\u0644\\u0625\\u0646\\u062c\\u0644\\u064a\\u0632\\u064a\\u0629: Pepsi)\\u200f \\u0647\\u0648 \\u0645\\u0634\\u0631\\u0648\\u0628 \\u063a\\u0627\\u0632\\u064a \\u0645\\u0643\\u0631\\u0628\\u0646 \\u062a\\u0635\\u0646\\u0639\\u0647 \\u0634\\u0631\\u0643\\u0629 \\u0628\\u064a\\u0628\\u0633\\u064a\\u0643\\u0648 (\\u062d\\u0627\\u0644\\u064a\\u064b\\u0651\\u0627). ... \\u0648\\u064a\\u0631\\u062c\\u0639 \\u0625\\u0646\\u0634\\u0627\\u0624\\u0647 \\u0648\\u062a\\u0637\\u0648\\u064a\\u0631\\u0647 \\u0641\\u064a \\u0627\\u0644\\u0623\\u0635\\u0644 \\u0625\\u0644\\u0649 \\u0639\\u0627\\u0645 1893 \\u0639\\u0644\\u0649 \\u064a\\u062f \\u0627\\u0644\\u0635\\u064a\\u062f\\u0644\\u0627\\u0646\\u064a \\u0643\\u0627\\u0644\\u064a\\u0628 \\u0628\\u0631\\u0627\\u062f\\u0647\\u0627\\u0645\\u060c ...\\n\",\"product_sku\":\"23423\",\"product_code\":\"1231\",\"quantity\":10,\"unit_price\":2,\"tax_id\":null,\"discount_amount\":3,\"subtotal\":0,\"total\":0,\"created_at\":\"2025-04-13T16:22:18.000000Z\",\"updated_at\":\"2025-04-13T16:22:18.000000Z\",\"deleted_at\":null,\"note\":null,\"vat_amount\":0.3,\"other_taxes_amount\":0.5}}', NULL, '2025-04-13 16:22:18', '2025-04-13 16:22:18'),
(178, 'default', 'created', 'App\\Models\\InvoiceItem', 'created', 15, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":15,\"invoice_id\":9,\"product_name_en\":\"Red bull\",\"product_name_ar\":\"Red bull\",\"product_description_en\":null,\"product_description_ar\":\"Red bull\",\"product_sku\":null,\"product_code\":null,\"quantity\":1,\"unit_price\":120,\"tax_id\":null,\"discount_amount\":0,\"subtotal\":0,\"total\":0,\"created_at\":\"2025-04-13T16:22:18.000000Z\",\"updated_at\":\"2025-04-13T16:22:18.000000Z\",\"deleted_at\":null,\"note\":null,\"vat_amount\":18,\"other_taxes_amount\":0}}', NULL, '2025-04-13 16:22:18', '2025-04-13 16:22:18'),
(179, 'default', 'deleted', 'App\\Models\\Invoice', 'deleted', 9, 'App\\Models\\User', 1, '{\"old\":{\"id\":9,\"number\":\"C001-INV-000001\",\"customer_name\":\"Zain ul Eman\",\"customer_email\":\"zainuleman786@gmail.com\",\"customer_phone\":null,\"company_id\":1,\"customer_id\":1,\"billing_address_id\":null,\"shipping_address_id\":null,\"subtotal\":240,\"discount_amount\":53,\"total_amount\":238,\"issue_date\":\"2025-04-13T16:22:18.000000Z\",\"due_date\":\"2025-05-13T16:22:18.000000Z\",\"paid_date\":null,\"invoice_status_id\":1,\"currency_id\":null,\"issued_by_user\":1,\"meta\":null,\"created_at\":\"2025-04-13T16:22:18.000000Z\",\"updated_at\":\"2025-04-13T16:22:47.000000Z\",\"deleted_at\":\"2025-04-13T16:22:47.000000Z\",\"amount_paid\":0,\"point_of_sale_id\":3,\"vat\":36,\"other_taxes\":15,\"order_id\":8}}', NULL, '2025-04-13 16:22:47', '2025-04-13 16:22:47'),
(180, 'default', 'created', 'App\\Models\\Invoice', 'created', 11, 'App\\Models\\User', 3, '{\"attributes\":{\"id\":11,\"number\":\"C001-INV-000002\",\"customer_name\":\"Zain ul Eman\",\"customer_email\":\"zainuleman786@gmail.com\",\"customer_phone\":null,\"company_id\":1,\"customer_id\":1,\"billing_address_id\":null,\"shipping_address_id\":null,\"subtotal\":240,\"discount_amount\":53,\"total_amount\":238,\"issue_date\":\"2025-04-13T16:25:00.000000Z\",\"due_date\":\"2025-05-13T16:25:00.000000Z\",\"paid_date\":null,\"invoice_status_id\":1,\"currency_id\":null,\"issued_by_user\":3,\"meta\":null,\"created_at\":\"2025-04-13T16:25:00.000000Z\",\"updated_at\":\"2025-04-13T16:25:00.000000Z\",\"deleted_at\":null,\"amount_paid\":0,\"point_of_sale_id\":3,\"vat\":36,\"other_taxes\":15,\"order_id\":8}}', NULL, '2025-04-13 16:25:00', '2025-04-13 16:25:00'),
(181, 'default', 'created', 'App\\Models\\InvoiceItem', 'created', 16, 'App\\Models\\User', 3, '{\"attributes\":{\"id\":16,\"invoice_id\":11,\"product_name_en\":\"coke\",\"product_name_ar\":\"coke\",\"product_description_en\":null,\"product_description_ar\":null,\"product_sku\":\"234\",\"product_code\":\"532\",\"quantity\":1,\"unit_price\":100,\"tax_id\":null,\"discount_amount\":50,\"subtotal\":0,\"total\":0,\"created_at\":\"2025-04-13T16:25:00.000000Z\",\"updated_at\":\"2025-04-13T16:25:00.000000Z\",\"deleted_at\":null,\"note\":null,\"vat_amount\":15,\"other_taxes_amount\":10}}', NULL, '2025-04-13 16:25:00', '2025-04-13 16:25:00'),
(182, 'default', 'created', 'App\\Models\\InvoiceItem', 'created', 17, 'App\\Models\\User', 3, '{\"attributes\":{\"id\":17,\"invoice_id\":11,\"product_name_en\":\"Pepsi\",\"product_name_ar\":\"\\u0628\\u064a\\u0628\\u0633\\u064a\",\"product_description_en\":\"pepsi\",\"product_description_ar\":\"\\u0628\\u064a\\u0628\\u0633\\u064a ... \\u0628\\u064a\\u0628\\u0633\\u064a (\\u0628\\u0627\\u0644\\u0625\\u0646\\u062c\\u0644\\u064a\\u0632\\u064a\\u0629: Pepsi)\\u200f \\u0647\\u0648 \\u0645\\u0634\\u0631\\u0648\\u0628 \\u063a\\u0627\\u0632\\u064a \\u0645\\u0643\\u0631\\u0628\\u0646 \\u062a\\u0635\\u0646\\u0639\\u0647 \\u0634\\u0631\\u0643\\u0629 \\u0628\\u064a\\u0628\\u0633\\u064a\\u0643\\u0648 (\\u062d\\u0627\\u0644\\u064a\\u064b\\u0651\\u0627). ... \\u0648\\u064a\\u0631\\u062c\\u0639 \\u0625\\u0646\\u0634\\u0627\\u0624\\u0647 \\u0648\\u062a\\u0637\\u0648\\u064a\\u0631\\u0647 \\u0641\\u064a \\u0627\\u0644\\u0623\\u0635\\u0644 \\u0625\\u0644\\u0649 \\u0639\\u0627\\u0645 1893 \\u0639\\u0644\\u0649 \\u064a\\u062f \\u0627\\u0644\\u0635\\u064a\\u062f\\u0644\\u0627\\u0646\\u064a \\u0643\\u0627\\u0644\\u064a\\u0628 \\u0628\\u0631\\u0627\\u062f\\u0647\\u0627\\u0645\\u060c ...\\n\",\"product_sku\":\"23423\",\"product_code\":\"1231\",\"quantity\":10,\"unit_price\":2,\"tax_id\":null,\"discount_amount\":3,\"subtotal\":0,\"total\":0,\"created_at\":\"2025-04-13T16:25:00.000000Z\",\"updated_at\":\"2025-04-13T16:25:00.000000Z\",\"deleted_at\":null,\"note\":null,\"vat_amount\":0.3,\"other_taxes_amount\":0.5}}', NULL, '2025-04-13 16:25:00', '2025-04-13 16:25:00'),
(183, 'default', 'created', 'App\\Models\\InvoiceItem', 'created', 18, 'App\\Models\\User', 3, '{\"attributes\":{\"id\":18,\"invoice_id\":11,\"product_name_en\":\"Red bull\",\"product_name_ar\":\"Red bull\",\"product_description_en\":null,\"product_description_ar\":\"Red bull\",\"product_sku\":null,\"product_code\":null,\"quantity\":1,\"unit_price\":120,\"tax_id\":null,\"discount_amount\":0,\"subtotal\":0,\"total\":0,\"created_at\":\"2025-04-13T16:25:00.000000Z\",\"updated_at\":\"2025-04-13T16:25:00.000000Z\",\"deleted_at\":null,\"note\":null,\"vat_amount\":18,\"other_taxes_amount\":0}}', NULL, '2025-04-13 16:25:00', '2025-04-13 16:25:00'),
(184, 'default', 'updated', 'App\\Models\\Order', 'updated', 8, 'App\\Models\\User', 3, '{\"attributes\":{\"customer_id\":2},\"old\":{\"customer_id\":1}}', NULL, '2025-04-13 16:32:07', '2025-04-13 16:32:07'),
(185, 'default', 'updated', 'App\\Models\\Order', 'updated', 8, 'App\\Models\\User', 3, '{\"attributes\":{\"customer_id\":1},\"old\":{\"customer_id\":2}}', NULL, '2025-04-13 16:32:41', '2025-04-13 16:32:41'),
(186, 'default', 'updated', 'App\\Models\\Order', 'updated', 8, 'App\\Models\\User', 3, '{\"attributes\":{\"customer_name\":\"Zain ul Eman\",\"customer_email\":\"zainuleman786@gmail.com\",\"customer_phone_number\":\"03146775616\"},\"old\":{\"customer_name\":null,\"customer_email\":null,\"customer_phone_number\":null}}', NULL, '2025-04-13 16:35:19', '2025-04-13 16:35:19'),
(187, 'default', 'updated', 'App\\Models\\Order', 'updated', 8, 'App\\Models\\User', 1, '{\"attributes\":{\"customer_id\":3,\"customer_phone_number\":\"2534523\"},\"old\":{\"customer_id\":1,\"customer_phone_number\":\"03146775616\"}}', NULL, '2025-04-13 18:17:37', '2025-04-13 18:17:37'),
(188, 'default', 'updated', 'App\\Models\\Order', 'updated', 8, 'App\\Models\\User', 1, '{\"attributes\":{\"customer_id\":2,\"customer_name\":\"Arsalan  Habib\",\"customer_email\":\"arsalanhabib@gmail.com\",\"customer_phone_number\":\"4326187\"},\"old\":{\"customer_id\":3,\"customer_name\":\"Zain ul Eman\",\"customer_email\":\"zainuleman786@gmail.com\",\"customer_phone_number\":\"2534523\"}}', NULL, '2025-04-13 18:18:25', '2025-04-13 18:18:25'),
(189, 'default', 'updated', 'App\\Models\\Order', 'updated', 8, 'App\\Models\\User', 1, '{\"attributes\":{\"user_id\":3},\"old\":{\"user_id\":null}}', NULL, '2025-04-13 18:18:43', '2025-04-13 18:18:43'),
(190, 'default', 'updated', 'App\\Models\\Order', 'updated', 8, 'App\\Models\\User', 3, '{\"attributes\":{\"customer_id\":1,\"customer_name\":\"Zain ul Eman\",\"customer_email\":\"zainuleman786@gmail.com\",\"customer_phone_number\":\"03146775616\"},\"old\":{\"customer_id\":2,\"customer_name\":\"Arsalan  Habib\",\"customer_email\":\"arsalanhabib@gmail.com\",\"customer_phone_number\":\"4326187\"}}', NULL, '2025-04-13 18:27:37', '2025-04-13 18:27:37'),
(191, 'default', 'created', 'App\\Models\\Invoice', 'created', 12, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":12,\"number\":\"C001-INV-000001\",\"customer_name\":\"Zain ul Eman\",\"customer_email\":\"zainuleman786@gmail.com\",\"customer_phone\":null,\"company_id\":1,\"customer_id\":1,\"billing_address_id\":null,\"shipping_address_id\":null,\"subtotal\":240,\"discount_amount\":53,\"total_amount\":238,\"issue_date\":\"2025-04-13T18:32:15.000000Z\",\"due_date\":\"2025-05-13T18:32:15.000000Z\",\"paid_date\":null,\"invoice_status_id\":1,\"currency_id\":null,\"issued_by_user\":1,\"meta\":null,\"created_at\":\"2025-04-13T18:32:15.000000Z\",\"updated_at\":\"2025-04-13T18:32:15.000000Z\",\"deleted_at\":null,\"amount_paid\":0,\"point_of_sale_id\":3,\"vat\":36,\"other_taxes\":15,\"order_id\":8}}', NULL, '2025-04-13 18:32:15', '2025-04-13 18:32:15'),
(192, 'default', 'created', 'App\\Models\\InvoiceItem', 'created', 19, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":19,\"invoice_id\":12,\"product_name_en\":\"coke\",\"product_name_ar\":\"coke\",\"product_description_en\":null,\"product_description_ar\":null,\"product_sku\":\"234\",\"product_code\":\"532\",\"quantity\":1,\"unit_price\":100,\"tax_id\":null,\"discount_amount\":50,\"subtotal\":0,\"total\":0,\"created_at\":\"2025-04-13T18:32:15.000000Z\",\"updated_at\":\"2025-04-13T18:32:15.000000Z\",\"deleted_at\":null,\"note\":null,\"vat_amount\":15,\"other_taxes_amount\":10}}', NULL, '2025-04-13 18:32:15', '2025-04-13 18:32:15'),
(193, 'default', 'created', 'App\\Models\\InvoiceItem', 'created', 20, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":20,\"invoice_id\":12,\"product_name_en\":\"Pepsi\",\"product_name_ar\":\"\\u0628\\u064a\\u0628\\u0633\\u064a\",\"product_description_en\":\"pepsi\",\"product_description_ar\":\"\\u0628\\u064a\\u0628\\u0633\\u064a ... \\u0628\\u064a\\u0628\\u0633\\u064a (\\u0628\\u0627\\u0644\\u0625\\u0646\\u062c\\u0644\\u064a\\u0632\\u064a\\u0629: Pepsi)\\u200f \\u0647\\u0648 \\u0645\\u0634\\u0631\\u0648\\u0628 \\u063a\\u0627\\u0632\\u064a \\u0645\\u0643\\u0631\\u0628\\u0646 \\u062a\\u0635\\u0646\\u0639\\u0647 \\u0634\\u0631\\u0643\\u0629 \\u0628\\u064a\\u0628\\u0633\\u064a\\u0643\\u0648 (\\u062d\\u0627\\u0644\\u064a\\u064b\\u0651\\u0627). ... \\u0648\\u064a\\u0631\\u062c\\u0639 \\u0625\\u0646\\u0634\\u0627\\u0624\\u0647 \\u0648\\u062a\\u0637\\u0648\\u064a\\u0631\\u0647 \\u0641\\u064a \\u0627\\u0644\\u0623\\u0635\\u0644 \\u0625\\u0644\\u0649 \\u0639\\u0627\\u0645 1893 \\u0639\\u0644\\u0649 \\u064a\\u062f \\u0627\\u0644\\u0635\\u064a\\u062f\\u0644\\u0627\\u0646\\u064a \\u0643\\u0627\\u0644\\u064a\\u0628 \\u0628\\u0631\\u0627\\u062f\\u0647\\u0627\\u0645\\u060c ...\\n\",\"product_sku\":\"23423\",\"product_code\":\"1231\",\"quantity\":10,\"unit_price\":2,\"tax_id\":null,\"discount_amount\":3,\"subtotal\":0,\"total\":0,\"created_at\":\"2025-04-13T18:32:15.000000Z\",\"updated_at\":\"2025-04-13T18:32:15.000000Z\",\"deleted_at\":null,\"note\":null,\"vat_amount\":0.3,\"other_taxes_amount\":0.5}}', NULL, '2025-04-13 18:32:15', '2025-04-13 18:32:15'),
(194, 'default', 'created', 'App\\Models\\InvoiceItem', 'created', 21, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":21,\"invoice_id\":12,\"product_name_en\":\"Red bull\",\"product_name_ar\":\"Red bull\",\"product_description_en\":null,\"product_description_ar\":\"Red bull\",\"product_sku\":null,\"product_code\":null,\"quantity\":1,\"unit_price\":120,\"tax_id\":null,\"discount_amount\":0,\"subtotal\":0,\"total\":0,\"created_at\":\"2025-04-13T18:32:15.000000Z\",\"updated_at\":\"2025-04-13T18:32:15.000000Z\",\"deleted_at\":null,\"note\":null,\"vat_amount\":18,\"other_taxes_amount\":0}}', NULL, '2025-04-13 18:32:15', '2025-04-13 18:32:15'),
(195, 'default', 'updated', 'App\\Models\\Invoice', 'updated', 12, 'App\\Models\\User', 1, '{\"attributes\":{\"issue_date\":\"2025-04-12T21:00:00.000000Z\",\"updated_at\":\"2025-04-13T19:11:34.000000Z\"},\"old\":{\"issue_date\":\"2025-04-13T18:32:15.000000Z\",\"updated_at\":\"2025-04-13T18:32:15.000000Z\"}}', NULL, '2025-04-13 19:11:34', '2025-04-13 19:11:34'),
(196, 'default', 'deleted', 'App\\Models\\Invoice', 'deleted', 12, 'App\\Models\\User', 1, '{\"old\":{\"id\":12,\"number\":\"C001-INV-000001\",\"customer_name\":\"Zain ul Eman\",\"customer_email\":\"zainuleman786@gmail.com\",\"customer_phone\":null,\"company_id\":1,\"customer_id\":1,\"billing_address_id\":null,\"shipping_address_id\":null,\"subtotal\":240,\"discount_amount\":53,\"total_amount\":238,\"issue_date\":\"2025-04-12T21:00:00.000000Z\",\"due_date\":\"2025-05-13T18:32:15.000000Z\",\"paid_date\":null,\"invoice_status_id\":1,\"currency_id\":null,\"issued_by_user\":1,\"meta\":null,\"created_at\":\"2025-04-13T18:32:15.000000Z\",\"updated_at\":\"2025-04-13T19:14:17.000000Z\",\"deleted_at\":\"2025-04-13T19:14:17.000000Z\",\"amount_paid\":0,\"point_of_sale_id\":3,\"vat\":36,\"other_taxes\":15,\"order_id\":8}}', NULL, '2025-04-13 19:14:17', '2025-04-13 19:14:17'),
(197, 'default', 'created', 'App\\Models\\Invoice', 'created', 13, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":13,\"number\":\"C001-INV-000001\",\"customer_name\":\"Zain ul Eman\",\"customer_email\":\"zainuleman786@gmail.com\",\"customer_phone\":null,\"company_id\":1,\"customer_id\":1,\"billing_address_id\":null,\"shipping_address_id\":null,\"subtotal\":240,\"discount\":53,\"total\":238,\"issue_date\":\"2025-04-13T19:35:46.000000Z\",\"due_date\":\"2025-05-13T19:35:46.000000Z\",\"paid_date\":null,\"invoice_status_id\":1,\"currency_id\":null,\"issued_by_user\":1,\"meta\":null,\"created_at\":\"2025-04-13T19:35:46.000000Z\",\"updated_at\":\"2025-04-13T19:35:46.000000Z\",\"deleted_at\":null,\"amount_paid\":0,\"point_of_sale_id\":3,\"vat\":36,\"other_taxes\":15,\"order_id\":8}}', NULL, '2025-04-13 19:35:46', '2025-04-13 19:35:46'),
(198, 'default', 'created', 'App\\Models\\InvoiceItem', 'created', 22, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":22,\"invoice_id\":13,\"product_name_en\":\"coke\",\"product_name_ar\":\"coke\",\"product_description_en\":null,\"product_description_ar\":null,\"product_sku\":\"234\",\"product_code\":\"532\",\"quantity\":1,\"unit_price\":100,\"tax_id\":null,\"discount_amount\":50,\"created_at\":\"2025-04-13T19:35:46.000000Z\",\"updated_at\":\"2025-04-13T19:35:46.000000Z\",\"deleted_at\":null,\"note\":null,\"vat_amount\":15,\"other_taxes_amount\":10,\"total_price\":0}}', NULL, '2025-04-13 19:35:46', '2025-04-13 19:35:46'),
(199, 'default', 'created', 'App\\Models\\InvoiceItem', 'created', 23, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":23,\"invoice_id\":13,\"product_name_en\":\"Pepsi\",\"product_name_ar\":\"\\u0628\\u064a\\u0628\\u0633\\u064a\",\"product_description_en\":\"pepsi\",\"product_description_ar\":\"\\u0628\\u064a\\u0628\\u0633\\u064a ... \\u0628\\u064a\\u0628\\u0633\\u064a (\\u0628\\u0627\\u0644\\u0625\\u0646\\u062c\\u0644\\u064a\\u0632\\u064a\\u0629: Pepsi)\\u200f \\u0647\\u0648 \\u0645\\u0634\\u0631\\u0648\\u0628 \\u063a\\u0627\\u0632\\u064a \\u0645\\u0643\\u0631\\u0628\\u0646 \\u062a\\u0635\\u0646\\u0639\\u0647 \\u0634\\u0631\\u0643\\u0629 \\u0628\\u064a\\u0628\\u0633\\u064a\\u0643\\u0648 (\\u062d\\u0627\\u0644\\u064a\\u064b\\u0651\\u0627). ... \\u0648\\u064a\\u0631\\u062c\\u0639 \\u0625\\u0646\\u0634\\u0627\\u0624\\u0647 \\u0648\\u062a\\u0637\\u0648\\u064a\\u0631\\u0647 \\u0641\\u064a \\u0627\\u0644\\u0623\\u0635\\u0644 \\u0625\\u0644\\u0649 \\u0639\\u0627\\u0645 1893 \\u0639\\u0644\\u0649 \\u064a\\u062f \\u0627\\u0644\\u0635\\u064a\\u062f\\u0644\\u0627\\u0646\\u064a \\u0643\\u0627\\u0644\\u064a\\u0628 \\u0628\\u0631\\u0627\\u062f\\u0647\\u0627\\u0645\\u060c ...\\n\",\"product_sku\":\"23423\",\"product_code\":\"1231\",\"quantity\":10,\"unit_price\":2,\"tax_id\":null,\"discount_amount\":3,\"created_at\":\"2025-04-13T19:35:46.000000Z\",\"updated_at\":\"2025-04-13T19:35:46.000000Z\",\"deleted_at\":null,\"note\":null,\"vat_amount\":0.3,\"other_taxes_amount\":0.5,\"total_price\":0}}', NULL, '2025-04-13 19:35:46', '2025-04-13 19:35:46'),
(200, 'default', 'created', 'App\\Models\\InvoiceItem', 'created', 24, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":24,\"invoice_id\":13,\"product_name_en\":\"Red bull\",\"product_name_ar\":\"Red bull\",\"product_description_en\":null,\"product_description_ar\":\"Red bull\",\"product_sku\":null,\"product_code\":null,\"quantity\":1,\"unit_price\":120,\"tax_id\":null,\"discount_amount\":0,\"created_at\":\"2025-04-13T19:35:46.000000Z\",\"updated_at\":\"2025-04-13T19:35:46.000000Z\",\"deleted_at\":null,\"note\":null,\"vat_amount\":18,\"other_taxes_amount\":0,\"total_price\":0}}', NULL, '2025-04-13 19:35:46', '2025-04-13 19:35:46'),
(201, 'default', 'updated', 'App\\Models\\Order', 'updated', 8, 'App\\Models\\User', 1, '{\"attributes\":{\"amount_paid\":\"230.00\"},\"old\":{\"amount_paid\":\"238.00\"}}', NULL, '2025-04-13 19:39:29', '2025-04-13 19:39:29'),
(202, 'default', 'created', 'App\\Models\\Invoice', 'created', 14, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":14,\"number\":\"C001-INV-000001\",\"customer_name\":\"Zain ul Eman\",\"customer_email\":\"zainuleman786@gmail.com\",\"customer_phone\":null,\"company_id\":1,\"customer_id\":1,\"billing_address_id\":null,\"shipping_address_id\":null,\"subtotal\":240,\"discount\":53,\"total\":238,\"issue_date\":\"2025-04-13T19:43:04.000000Z\",\"due_date\":\"2025-05-13T19:43:04.000000Z\",\"paid_date\":null,\"invoice_status_id\":1,\"currency_id\":null,\"issued_by_user\":1,\"meta\":null,\"created_at\":\"2025-04-13T19:43:04.000000Z\",\"updated_at\":\"2025-04-13T19:43:04.000000Z\",\"deleted_at\":null,\"amount_paid\":0,\"point_of_sale_id\":3,\"vat\":36,\"other_taxes\":15,\"order_id\":8}}', NULL, '2025-04-13 19:43:04', '2025-04-13 19:43:04'),
(203, 'default', 'created', 'App\\Models\\InvoiceItem', 'created', 25, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":25,\"invoice_id\":14,\"product_name_en\":\"coke\",\"product_name_ar\":\"coke\",\"product_description_en\":null,\"product_description_ar\":null,\"product_sku\":\"234\",\"product_code\":\"532\",\"quantity\":1,\"unit_price\":100,\"tax_id\":null,\"discount_amount\":50,\"created_at\":\"2025-04-13T19:43:04.000000Z\",\"updated_at\":\"2025-04-13T19:43:04.000000Z\",\"deleted_at\":null,\"note\":null,\"vat_amount\":15,\"other_taxes_amount\":10,\"total_price\":0}}', NULL, '2025-04-13 19:43:04', '2025-04-13 19:43:04'),
(204, 'default', 'created', 'App\\Models\\InvoiceItem', 'created', 26, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":26,\"invoice_id\":14,\"product_name_en\":\"Pepsi\",\"product_name_ar\":\"\\u0628\\u064a\\u0628\\u0633\\u064a\",\"product_description_en\":\"pepsi\",\"product_description_ar\":\"\\u0628\\u064a\\u0628\\u0633\\u064a ... \\u0628\\u064a\\u0628\\u0633\\u064a (\\u0628\\u0627\\u0644\\u0625\\u0646\\u062c\\u0644\\u064a\\u0632\\u064a\\u0629: Pepsi)\\u200f \\u0647\\u0648 \\u0645\\u0634\\u0631\\u0648\\u0628 \\u063a\\u0627\\u0632\\u064a \\u0645\\u0643\\u0631\\u0628\\u0646 \\u062a\\u0635\\u0646\\u0639\\u0647 \\u0634\\u0631\\u0643\\u0629 \\u0628\\u064a\\u0628\\u0633\\u064a\\u0643\\u0648 (\\u062d\\u0627\\u0644\\u064a\\u064b\\u0651\\u0627). ... \\u0648\\u064a\\u0631\\u062c\\u0639 \\u0625\\u0646\\u0634\\u0627\\u0624\\u0647 \\u0648\\u062a\\u0637\\u0648\\u064a\\u0631\\u0647 \\u0641\\u064a \\u0627\\u0644\\u0623\\u0635\\u0644 \\u0625\\u0644\\u0649 \\u0639\\u0627\\u0645 1893 \\u0639\\u0644\\u0649 \\u064a\\u062f \\u0627\\u0644\\u0635\\u064a\\u062f\\u0644\\u0627\\u0646\\u064a \\u0643\\u0627\\u0644\\u064a\\u0628 \\u0628\\u0631\\u0627\\u062f\\u0647\\u0627\\u0645\\u060c ...\\n\",\"product_sku\":\"23423\",\"product_code\":\"1231\",\"quantity\":10,\"unit_price\":2,\"tax_id\":null,\"discount_amount\":3,\"created_at\":\"2025-04-13T19:43:04.000000Z\",\"updated_at\":\"2025-04-13T19:43:04.000000Z\",\"deleted_at\":null,\"note\":null,\"vat_amount\":0.3,\"other_taxes_amount\":0.5,\"total_price\":0}}', NULL, '2025-04-13 19:43:04', '2025-04-13 19:43:04'),
(205, 'default', 'created', 'App\\Models\\InvoiceItem', 'created', 27, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":27,\"invoice_id\":14,\"product_name_en\":\"Red bull\",\"product_name_ar\":\"Red bull\",\"product_description_en\":null,\"product_description_ar\":\"Red bull\",\"product_sku\":null,\"product_code\":null,\"quantity\":1,\"unit_price\":120,\"tax_id\":null,\"discount_amount\":0,\"created_at\":\"2025-04-13T19:43:04.000000Z\",\"updated_at\":\"2025-04-13T19:43:04.000000Z\",\"deleted_at\":null,\"note\":null,\"vat_amount\":18,\"other_taxes_amount\":0,\"total_price\":0}}', NULL, '2025-04-13 19:43:04', '2025-04-13 19:43:04'),
(206, 'default', 'created', 'App\\Models\\Invoice', 'created', 15, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":15,\"number\":\"C001-INV-000001\",\"customer_name\":\"Zain ul Eman\",\"customer_email\":\"zainuleman786@gmail.com\",\"customer_phone\":null,\"company_id\":1,\"customer_id\":1,\"billing_address_id\":null,\"shipping_address_id\":null,\"subtotal\":240,\"discount\":53,\"total\":238,\"issue_date\":\"2025-04-13T19:43:58.000000Z\",\"due_date\":\"2025-05-13T19:43:58.000000Z\",\"paid_date\":null,\"invoice_status_id\":1,\"currency_id\":null,\"issued_by_user\":1,\"meta\":null,\"created_at\":\"2025-04-13T19:43:58.000000Z\",\"updated_at\":\"2025-04-13T19:43:58.000000Z\",\"deleted_at\":null,\"amount_paid\":0,\"point_of_sale_id\":3,\"vat\":36,\"other_taxes\":15,\"order_id\":8}}', NULL, '2025-04-13 19:43:58', '2025-04-13 19:43:58'),
(207, 'default', 'created', 'App\\Models\\InvoiceItem', 'created', 28, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":28,\"invoice_id\":15,\"product_name_en\":\"coke\",\"product_name_ar\":\"coke\",\"product_description_en\":null,\"product_description_ar\":null,\"product_sku\":\"234\",\"product_code\":\"532\",\"quantity\":1,\"unit_price\":100,\"tax_id\":null,\"discount_amount\":50,\"created_at\":\"2025-04-13T19:43:58.000000Z\",\"updated_at\":\"2025-04-13T19:43:58.000000Z\",\"deleted_at\":null,\"note\":null,\"vat_amount\":15,\"other_taxes_amount\":10,\"total_price\":0}}', NULL, '2025-04-13 19:43:58', '2025-04-13 19:43:58'),
(208, 'default', 'created', 'App\\Models\\InvoiceItem', 'created', 29, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":29,\"invoice_id\":15,\"product_name_en\":\"Pepsi\",\"product_name_ar\":\"\\u0628\\u064a\\u0628\\u0633\\u064a\",\"product_description_en\":\"pepsi\",\"product_description_ar\":\"\\u0628\\u064a\\u0628\\u0633\\u064a ... \\u0628\\u064a\\u0628\\u0633\\u064a (\\u0628\\u0627\\u0644\\u0625\\u0646\\u062c\\u0644\\u064a\\u0632\\u064a\\u0629: Pepsi)\\u200f \\u0647\\u0648 \\u0645\\u0634\\u0631\\u0648\\u0628 \\u063a\\u0627\\u0632\\u064a \\u0645\\u0643\\u0631\\u0628\\u0646 \\u062a\\u0635\\u0646\\u0639\\u0647 \\u0634\\u0631\\u0643\\u0629 \\u0628\\u064a\\u0628\\u0633\\u064a\\u0643\\u0648 (\\u062d\\u0627\\u0644\\u064a\\u064b\\u0651\\u0627). ... \\u0648\\u064a\\u0631\\u062c\\u0639 \\u0625\\u0646\\u0634\\u0627\\u0624\\u0647 \\u0648\\u062a\\u0637\\u0648\\u064a\\u0631\\u0647 \\u0641\\u064a \\u0627\\u0644\\u0623\\u0635\\u0644 \\u0625\\u0644\\u0649 \\u0639\\u0627\\u0645 1893 \\u0639\\u0644\\u0649 \\u064a\\u062f \\u0627\\u0644\\u0635\\u064a\\u062f\\u0644\\u0627\\u0646\\u064a \\u0643\\u0627\\u0644\\u064a\\u0628 \\u0628\\u0631\\u0627\\u062f\\u0647\\u0627\\u0645\\u060c ...\\n\",\"product_sku\":\"23423\",\"product_code\":\"1231\",\"quantity\":10,\"unit_price\":2,\"tax_id\":null,\"discount_amount\":3,\"created_at\":\"2025-04-13T19:43:58.000000Z\",\"updated_at\":\"2025-04-13T19:43:58.000000Z\",\"deleted_at\":null,\"note\":null,\"vat_amount\":0.3,\"other_taxes_amount\":0.5,\"total_price\":0}}', NULL, '2025-04-13 19:43:58', '2025-04-13 19:43:58'),
(209, 'default', 'created', 'App\\Models\\InvoiceItem', 'created', 30, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":30,\"invoice_id\":15,\"product_name_en\":\"Red bull\",\"product_name_ar\":\"Red bull\",\"product_description_en\":null,\"product_description_ar\":\"Red bull\",\"product_sku\":null,\"product_code\":null,\"quantity\":1,\"unit_price\":120,\"tax_id\":null,\"discount_amount\":0,\"created_at\":\"2025-04-13T19:43:58.000000Z\",\"updated_at\":\"2025-04-13T19:43:58.000000Z\",\"deleted_at\":null,\"note\":null,\"vat_amount\":18,\"other_taxes_amount\":0,\"total_price\":0}}', NULL, '2025-04-13 19:43:58', '2025-04-13 19:43:58'),
(210, 'default', 'created', 'App\\Models\\Invoice', 'created', 16, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":16,\"number\":\"C001-INV-000001\",\"customer_name\":\"Zain ul Eman\",\"customer_email\":\"zainuleman786@gmail.com\",\"customer_phone\":null,\"company_id\":1,\"customer_id\":1,\"billing_address_id\":null,\"shipping_address_id\":null,\"subtotal\":240,\"discount\":53,\"total\":238,\"issue_date\":\"2025-04-13T19:46:07.000000Z\",\"due_date\":\"2025-05-13T19:46:07.000000Z\",\"paid_date\":null,\"invoice_status_id\":1,\"currency_id\":null,\"issued_by_user\":1,\"meta\":null,\"created_at\":\"2025-04-13T19:46:07.000000Z\",\"updated_at\":\"2025-04-13T19:46:07.000000Z\",\"deleted_at\":null,\"amount_paid\":230,\"point_of_sale_id\":3,\"vat\":36,\"other_taxes\":15,\"order_id\":8}}', NULL, '2025-04-13 19:46:07', '2025-04-13 19:46:07'),
(211, 'default', 'created', 'App\\Models\\InvoiceItem', 'created', 31, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":31,\"invoice_id\":16,\"product_name_en\":\"coke\",\"product_name_ar\":\"coke\",\"product_description_en\":null,\"product_description_ar\":null,\"product_sku\":\"234\",\"product_code\":\"532\",\"quantity\":1,\"unit_price\":100,\"tax_id\":null,\"discount_amount\":50,\"created_at\":\"2025-04-13T19:46:07.000000Z\",\"updated_at\":\"2025-04-13T19:46:07.000000Z\",\"deleted_at\":null,\"note\":null,\"vat_amount\":15,\"other_taxes_amount\":10,\"total_price\":0}}', NULL, '2025-04-13 19:46:07', '2025-04-13 19:46:07'),
(212, 'default', 'created', 'App\\Models\\InvoiceItem', 'created', 32, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":32,\"invoice_id\":16,\"product_name_en\":\"Pepsi\",\"product_name_ar\":\"\\u0628\\u064a\\u0628\\u0633\\u064a\",\"product_description_en\":\"pepsi\",\"product_description_ar\":\"\\u0628\\u064a\\u0628\\u0633\\u064a ... \\u0628\\u064a\\u0628\\u0633\\u064a (\\u0628\\u0627\\u0644\\u0625\\u0646\\u062c\\u0644\\u064a\\u0632\\u064a\\u0629: Pepsi)\\u200f \\u0647\\u0648 \\u0645\\u0634\\u0631\\u0648\\u0628 \\u063a\\u0627\\u0632\\u064a \\u0645\\u0643\\u0631\\u0628\\u0646 \\u062a\\u0635\\u0646\\u0639\\u0647 \\u0634\\u0631\\u0643\\u0629 \\u0628\\u064a\\u0628\\u0633\\u064a\\u0643\\u0648 (\\u062d\\u0627\\u0644\\u064a\\u064b\\u0651\\u0627). ... \\u0648\\u064a\\u0631\\u062c\\u0639 \\u0625\\u0646\\u0634\\u0627\\u0624\\u0647 \\u0648\\u062a\\u0637\\u0648\\u064a\\u0631\\u0647 \\u0641\\u064a \\u0627\\u0644\\u0623\\u0635\\u0644 \\u0625\\u0644\\u0649 \\u0639\\u0627\\u0645 1893 \\u0639\\u0644\\u0649 \\u064a\\u062f \\u0627\\u0644\\u0635\\u064a\\u062f\\u0644\\u0627\\u0646\\u064a \\u0643\\u0627\\u0644\\u064a\\u0628 \\u0628\\u0631\\u0627\\u062f\\u0647\\u0627\\u0645\\u060c ...\\n\",\"product_sku\":\"23423\",\"product_code\":\"1231\",\"quantity\":10,\"unit_price\":2,\"tax_id\":null,\"discount_amount\":3,\"created_at\":\"2025-04-13T19:46:07.000000Z\",\"updated_at\":\"2025-04-13T19:46:07.000000Z\",\"deleted_at\":null,\"note\":null,\"vat_amount\":0.3,\"other_taxes_amount\":0.5,\"total_price\":0}}', NULL, '2025-04-13 19:46:07', '2025-04-13 19:46:07'),
(213, 'default', 'created', 'App\\Models\\InvoiceItem', 'created', 33, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":33,\"invoice_id\":16,\"product_name_en\":\"Red bull\",\"product_name_ar\":\"Red bull\",\"product_description_en\":null,\"product_description_ar\":\"Red bull\",\"product_sku\":null,\"product_code\":null,\"quantity\":1,\"unit_price\":120,\"tax_id\":null,\"discount_amount\":0,\"created_at\":\"2025-04-13T19:46:07.000000Z\",\"updated_at\":\"2025-04-13T19:46:07.000000Z\",\"deleted_at\":null,\"note\":null,\"vat_amount\":18,\"other_taxes_amount\":0,\"total_price\":0}}', NULL, '2025-04-13 19:46:07', '2025-04-13 19:46:07'),
(214, 'default', 'created', 'App\\Models\\Invoice', 'created', 17, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":17,\"number\":\"C001-INV-000001\",\"customer_name\":\"Zain ul Eman\",\"customer_email\":\"zainuleman786@gmail.com\",\"customer_phone\":null,\"company_id\":1,\"customer_id\":1,\"billing_address_id\":null,\"shipping_address_id\":null,\"subtotal\":240,\"discount\":53,\"total\":238,\"issue_date\":\"2025-04-13T19:46:50.000000Z\",\"due_date\":\"2025-05-13T19:46:50.000000Z\",\"paid_date\":null,\"invoice_status_id\":1,\"currency_id\":null,\"issued_by_user\":1,\"meta\":null,\"created_at\":\"2025-04-13T19:46:50.000000Z\",\"updated_at\":\"2025-04-13T19:46:50.000000Z\",\"deleted_at\":null,\"amount_paid\":230,\"point_of_sale_id\":3,\"vat\":36,\"other_taxes\":15,\"order_id\":8}}', NULL, '2025-04-13 19:46:50', '2025-04-13 19:46:50'),
(215, 'default', 'created', 'App\\Models\\InvoiceItem', 'created', 34, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":34,\"invoice_id\":17,\"product_name_en\":\"coke\",\"product_name_ar\":\"coke\",\"product_description_en\":null,\"product_description_ar\":null,\"product_sku\":\"234\",\"product_code\":\"532\",\"quantity\":1,\"unit_price\":100,\"tax_id\":null,\"discount_amount\":50,\"created_at\":\"2025-04-13T19:46:50.000000Z\",\"updated_at\":\"2025-04-13T19:46:50.000000Z\",\"deleted_at\":null,\"note\":null,\"vat_amount\":15,\"other_taxes_amount\":10,\"total_price\":0}}', NULL, '2025-04-13 19:46:50', '2025-04-13 19:46:50');
INSERT INTO `activity_logs` (`id`, `log_name`, `description`, `subject_type`, `event`, `subject_id`, `causer_type`, `causer_id`, `properties`, `batch_uuid`, `created_at`, `updated_at`) VALUES
(216, 'default', 'created', 'App\\Models\\InvoiceItem', 'created', 35, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":35,\"invoice_id\":17,\"product_name_en\":\"Pepsi\",\"product_name_ar\":\"\\u0628\\u064a\\u0628\\u0633\\u064a\",\"product_description_en\":\"pepsi\",\"product_description_ar\":\"\\u0628\\u064a\\u0628\\u0633\\u064a ... \\u0628\\u064a\\u0628\\u0633\\u064a (\\u0628\\u0627\\u0644\\u0625\\u0646\\u062c\\u0644\\u064a\\u0632\\u064a\\u0629: Pepsi)\\u200f \\u0647\\u0648 \\u0645\\u0634\\u0631\\u0648\\u0628 \\u063a\\u0627\\u0632\\u064a \\u0645\\u0643\\u0631\\u0628\\u0646 \\u062a\\u0635\\u0646\\u0639\\u0647 \\u0634\\u0631\\u0643\\u0629 \\u0628\\u064a\\u0628\\u0633\\u064a\\u0643\\u0648 (\\u062d\\u0627\\u0644\\u064a\\u064b\\u0651\\u0627). ... \\u0648\\u064a\\u0631\\u062c\\u0639 \\u0625\\u0646\\u0634\\u0627\\u0624\\u0647 \\u0648\\u062a\\u0637\\u0648\\u064a\\u0631\\u0647 \\u0641\\u064a \\u0627\\u0644\\u0623\\u0635\\u0644 \\u0625\\u0644\\u0649 \\u0639\\u0627\\u0645 1893 \\u0639\\u0644\\u0649 \\u064a\\u062f \\u0627\\u0644\\u0635\\u064a\\u062f\\u0644\\u0627\\u0646\\u064a \\u0643\\u0627\\u0644\\u064a\\u0628 \\u0628\\u0631\\u0627\\u062f\\u0647\\u0627\\u0645\\u060c ...\\n\",\"product_sku\":\"23423\",\"product_code\":\"1231\",\"quantity\":10,\"unit_price\":2,\"tax_id\":null,\"discount_amount\":3,\"created_at\":\"2025-04-13T19:46:50.000000Z\",\"updated_at\":\"2025-04-13T19:46:50.000000Z\",\"deleted_at\":null,\"note\":null,\"vat_amount\":0.3,\"other_taxes_amount\":0.5,\"total_price\":0}}', NULL, '2025-04-13 19:46:50', '2025-04-13 19:46:50'),
(217, 'default', 'created', 'App\\Models\\InvoiceItem', 'created', 36, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":36,\"invoice_id\":17,\"product_name_en\":\"Red bull\",\"product_name_ar\":\"Red bull\",\"product_description_en\":null,\"product_description_ar\":\"Red bull\",\"product_sku\":null,\"product_code\":null,\"quantity\":1,\"unit_price\":120,\"tax_id\":null,\"discount_amount\":0,\"created_at\":\"2025-04-13T19:46:50.000000Z\",\"updated_at\":\"2025-04-13T19:46:50.000000Z\",\"deleted_at\":null,\"note\":null,\"vat_amount\":18,\"other_taxes_amount\":0,\"total_price\":0}}', NULL, '2025-04-13 19:46:50', '2025-04-13 19:46:50'),
(218, 'default', 'created', 'App\\Models\\Invoice', 'created', 18, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":18,\"number\":\"C001-INV-000001\",\"customer_name\":\"Zain ul Eman\",\"customer_email\":\"zainuleman786@gmail.com\",\"customer_phone\":null,\"company_id\":1,\"customer_id\":1,\"billing_address_id\":null,\"shipping_address_id\":null,\"subtotal\":240,\"discount\":53,\"total\":238,\"issue_date\":\"2025-04-13T19:51:46.000000Z\",\"due_date\":\"2025-05-13T19:51:46.000000Z\",\"paid_date\":null,\"invoice_status_id\":1,\"currency_id\":null,\"issued_by_user\":1,\"meta\":null,\"created_at\":\"2025-04-13T19:51:46.000000Z\",\"updated_at\":\"2025-04-13T19:51:46.000000Z\",\"deleted_at\":null,\"amount_paid\":230,\"point_of_sale_id\":3,\"vat\":36,\"other_taxes\":15,\"order_id\":8}}', NULL, '2025-04-13 19:51:46', '2025-04-13 19:51:46'),
(219, 'default', 'created', 'App\\Models\\InvoiceItem', 'created', 37, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":37,\"invoice_id\":18,\"product_name_en\":\"coke\",\"product_name_ar\":\"coke\",\"product_description_en\":null,\"product_description_ar\":null,\"product_sku\":\"234\",\"product_code\":\"532\",\"quantity\":1,\"unit_price\":100,\"tax_id\":null,\"discount_amount\":50,\"created_at\":\"2025-04-13T19:51:46.000000Z\",\"updated_at\":\"2025-04-13T19:51:46.000000Z\",\"deleted_at\":null,\"note\":null,\"vat_amount\":15,\"other_taxes_amount\":10,\"total_price\":0}}', NULL, '2025-04-13 19:51:46', '2025-04-13 19:51:46'),
(220, 'default', 'created', 'App\\Models\\InvoiceItem', 'created', 38, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":38,\"invoice_id\":18,\"product_name_en\":\"Pepsi\",\"product_name_ar\":\"\\u0628\\u064a\\u0628\\u0633\\u064a\",\"product_description_en\":\"pepsi\",\"product_description_ar\":\"\\u0628\\u064a\\u0628\\u0633\\u064a ... \\u0628\\u064a\\u0628\\u0633\\u064a (\\u0628\\u0627\\u0644\\u0625\\u0646\\u062c\\u0644\\u064a\\u0632\\u064a\\u0629: Pepsi)\\u200f \\u0647\\u0648 \\u0645\\u0634\\u0631\\u0648\\u0628 \\u063a\\u0627\\u0632\\u064a \\u0645\\u0643\\u0631\\u0628\\u0646 \\u062a\\u0635\\u0646\\u0639\\u0647 \\u0634\\u0631\\u0643\\u0629 \\u0628\\u064a\\u0628\\u0633\\u064a\\u0643\\u0648 (\\u062d\\u0627\\u0644\\u064a\\u064b\\u0651\\u0627). ... \\u0648\\u064a\\u0631\\u062c\\u0639 \\u0625\\u0646\\u0634\\u0627\\u0624\\u0647 \\u0648\\u062a\\u0637\\u0648\\u064a\\u0631\\u0647 \\u0641\\u064a \\u0627\\u0644\\u0623\\u0635\\u0644 \\u0625\\u0644\\u0649 \\u0639\\u0627\\u0645 1893 \\u0639\\u0644\\u0649 \\u064a\\u062f \\u0627\\u0644\\u0635\\u064a\\u062f\\u0644\\u0627\\u0646\\u064a \\u0643\\u0627\\u0644\\u064a\\u0628 \\u0628\\u0631\\u0627\\u062f\\u0647\\u0627\\u0645\\u060c ...\\n\",\"product_sku\":\"23423\",\"product_code\":\"1231\",\"quantity\":10,\"unit_price\":2,\"tax_id\":null,\"discount_amount\":3,\"created_at\":\"2025-04-13T19:51:46.000000Z\",\"updated_at\":\"2025-04-13T19:51:46.000000Z\",\"deleted_at\":null,\"note\":null,\"vat_amount\":0.3,\"other_taxes_amount\":0.5,\"total_price\":0}}', NULL, '2025-04-13 19:51:46', '2025-04-13 19:51:46'),
(221, 'default', 'created', 'App\\Models\\InvoiceItem', 'created', 39, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":39,\"invoice_id\":18,\"product_name_en\":\"Red bull\",\"product_name_ar\":\"Red bull\",\"product_description_en\":null,\"product_description_ar\":\"Red bull\",\"product_sku\":null,\"product_code\":null,\"quantity\":1,\"unit_price\":120,\"tax_id\":null,\"discount_amount\":0,\"created_at\":\"2025-04-13T19:51:46.000000Z\",\"updated_at\":\"2025-04-13T19:51:46.000000Z\",\"deleted_at\":null,\"note\":null,\"vat_amount\":18,\"other_taxes_amount\":0,\"total_price\":0}}', NULL, '2025-04-13 19:51:46', '2025-04-13 19:51:46'),
(222, 'default', 'created', 'App\\Models\\Invoice', 'created', 19, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":19,\"number\":\"C001-INV-000001\",\"customer_name\":\"Zain ul Eman\",\"customer_email\":\"zainuleman786@gmail.com\",\"customer_phone\":null,\"company_id\":1,\"customer_id\":1,\"billing_address_id\":null,\"shipping_address_id\":null,\"subtotal\":240,\"discount\":53,\"total\":238,\"issue_date\":\"2025-04-13T19:53:46.000000Z\",\"due_date\":\"2025-05-13T19:53:46.000000Z\",\"paid_date\":null,\"invoice_status_id\":1,\"currency_id\":null,\"issued_by_user\":1,\"meta\":null,\"created_at\":\"2025-04-13T19:53:46.000000Z\",\"updated_at\":\"2025-04-13T19:53:46.000000Z\",\"deleted_at\":null,\"amount_paid\":230,\"point_of_sale_id\":3,\"vat\":36,\"other_taxes\":15,\"order_id\":8}}', NULL, '2025-04-13 19:53:46', '2025-04-13 19:53:46'),
(223, 'default', 'created', 'App\\Models\\InvoiceItem', 'created', 40, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":40,\"invoice_id\":19,\"product_name_en\":\"coke\",\"product_name_ar\":\"coke\",\"product_description_en\":null,\"product_description_ar\":null,\"product_sku\":\"234\",\"product_code\":\"532\",\"quantity\":1,\"unit_price\":100,\"tax_id\":null,\"discount_amount\":50,\"created_at\":\"2025-04-13T19:53:46.000000Z\",\"updated_at\":\"2025-04-13T19:53:46.000000Z\",\"deleted_at\":null,\"note\":null,\"vat_amount\":15,\"other_taxes_amount\":10,\"total_price\":0}}', NULL, '2025-04-13 19:53:46', '2025-04-13 19:53:46'),
(224, 'default', 'created', 'App\\Models\\InvoiceItem', 'created', 41, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":41,\"invoice_id\":19,\"product_name_en\":\"Pepsi\",\"product_name_ar\":\"\\u0628\\u064a\\u0628\\u0633\\u064a\",\"product_description_en\":\"pepsi\",\"product_description_ar\":\"\\u0628\\u064a\\u0628\\u0633\\u064a ... \\u0628\\u064a\\u0628\\u0633\\u064a (\\u0628\\u0627\\u0644\\u0625\\u0646\\u062c\\u0644\\u064a\\u0632\\u064a\\u0629: Pepsi)\\u200f \\u0647\\u0648 \\u0645\\u0634\\u0631\\u0648\\u0628 \\u063a\\u0627\\u0632\\u064a \\u0645\\u0643\\u0631\\u0628\\u0646 \\u062a\\u0635\\u0646\\u0639\\u0647 \\u0634\\u0631\\u0643\\u0629 \\u0628\\u064a\\u0628\\u0633\\u064a\\u0643\\u0648 (\\u062d\\u0627\\u0644\\u064a\\u064b\\u0651\\u0627). ... \\u0648\\u064a\\u0631\\u062c\\u0639 \\u0625\\u0646\\u0634\\u0627\\u0624\\u0647 \\u0648\\u062a\\u0637\\u0648\\u064a\\u0631\\u0647 \\u0641\\u064a \\u0627\\u0644\\u0623\\u0635\\u0644 \\u0625\\u0644\\u0649 \\u0639\\u0627\\u0645 1893 \\u0639\\u0644\\u0649 \\u064a\\u062f \\u0627\\u0644\\u0635\\u064a\\u062f\\u0644\\u0627\\u0646\\u064a \\u0643\\u0627\\u0644\\u064a\\u0628 \\u0628\\u0631\\u0627\\u062f\\u0647\\u0627\\u0645\\u060c ...\\n\",\"product_sku\":\"23423\",\"product_code\":\"1231\",\"quantity\":10,\"unit_price\":2,\"tax_id\":null,\"discount_amount\":3,\"created_at\":\"2025-04-13T19:53:46.000000Z\",\"updated_at\":\"2025-04-13T19:53:46.000000Z\",\"deleted_at\":null,\"note\":null,\"vat_amount\":0.3,\"other_taxes_amount\":0.5,\"total_price\":0}}', NULL, '2025-04-13 19:53:46', '2025-04-13 19:53:46'),
(225, 'default', 'created', 'App\\Models\\InvoiceItem', 'created', 42, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":42,\"invoice_id\":19,\"product_name_en\":\"Red bull\",\"product_name_ar\":\"Red bull\",\"product_description_en\":null,\"product_description_ar\":\"Red bull\",\"product_sku\":null,\"product_code\":null,\"quantity\":1,\"unit_price\":120,\"tax_id\":null,\"discount_amount\":0,\"created_at\":\"2025-04-13T19:53:46.000000Z\",\"updated_at\":\"2025-04-13T19:53:46.000000Z\",\"deleted_at\":null,\"note\":null,\"vat_amount\":18,\"other_taxes_amount\":0,\"total_price\":0}}', NULL, '2025-04-13 19:53:46', '2025-04-13 19:53:46'),
(226, 'default', 'created', 'App\\Models\\Invoice', 'created', 20, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":20,\"number\":\"C001-INV-000001\",\"customer_name\":\"Zain ul Eman\",\"customer_email\":\"zainuleman786@gmail.com\",\"customer_phone\":null,\"company_id\":1,\"customer_id\":1,\"billing_address_id\":null,\"shipping_address_id\":null,\"subtotal\":240,\"discount\":53,\"total\":238,\"issue_date\":\"2025-04-13T19:55:28.000000Z\",\"due_date\":\"2025-05-13T19:55:28.000000Z\",\"paid_date\":null,\"invoice_status_id\":1,\"currency_id\":null,\"issued_by_user\":1,\"meta\":null,\"created_at\":\"2025-04-13T19:55:28.000000Z\",\"updated_at\":\"2025-04-13T19:55:28.000000Z\",\"deleted_at\":null,\"amount_paid\":238,\"point_of_sale_id\":3,\"vat\":36,\"other_taxes\":15,\"order_id\":8}}', NULL, '2025-04-13 19:55:28', '2025-04-13 19:55:28'),
(227, 'default', 'created', 'App\\Models\\InvoiceItem', 'created', 43, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":43,\"invoice_id\":20,\"product_name_en\":\"coke\",\"product_name_ar\":\"coke\",\"product_description_en\":null,\"product_description_ar\":null,\"product_sku\":\"234\",\"product_code\":\"532\",\"quantity\":1,\"unit_price\":100,\"tax_id\":null,\"discount_amount\":50,\"created_at\":\"2025-04-13T19:55:28.000000Z\",\"updated_at\":\"2025-04-13T19:55:28.000000Z\",\"deleted_at\":null,\"note\":null,\"vat_amount\":15,\"other_taxes_amount\":10,\"total_price\":0}}', NULL, '2025-04-13 19:55:28', '2025-04-13 19:55:28'),
(228, 'default', 'created', 'App\\Models\\InvoiceItem', 'created', 44, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":44,\"invoice_id\":20,\"product_name_en\":\"Pepsi\",\"product_name_ar\":\"\\u0628\\u064a\\u0628\\u0633\\u064a\",\"product_description_en\":\"pepsi\",\"product_description_ar\":\"\\u0628\\u064a\\u0628\\u0633\\u064a ... \\u0628\\u064a\\u0628\\u0633\\u064a (\\u0628\\u0627\\u0644\\u0625\\u0646\\u062c\\u0644\\u064a\\u0632\\u064a\\u0629: Pepsi)\\u200f \\u0647\\u0648 \\u0645\\u0634\\u0631\\u0648\\u0628 \\u063a\\u0627\\u0632\\u064a \\u0645\\u0643\\u0631\\u0628\\u0646 \\u062a\\u0635\\u0646\\u0639\\u0647 \\u0634\\u0631\\u0643\\u0629 \\u0628\\u064a\\u0628\\u0633\\u064a\\u0643\\u0648 (\\u062d\\u0627\\u0644\\u064a\\u064b\\u0651\\u0627). ... \\u0648\\u064a\\u0631\\u062c\\u0639 \\u0625\\u0646\\u0634\\u0627\\u0624\\u0647 \\u0648\\u062a\\u0637\\u0648\\u064a\\u0631\\u0647 \\u0641\\u064a \\u0627\\u0644\\u0623\\u0635\\u0644 \\u0625\\u0644\\u0649 \\u0639\\u0627\\u0645 1893 \\u0639\\u0644\\u0649 \\u064a\\u062f \\u0627\\u0644\\u0635\\u064a\\u062f\\u0644\\u0627\\u0646\\u064a \\u0643\\u0627\\u0644\\u064a\\u0628 \\u0628\\u0631\\u0627\\u062f\\u0647\\u0627\\u0645\\u060c ...\\n\",\"product_sku\":\"23423\",\"product_code\":\"1231\",\"quantity\":10,\"unit_price\":2,\"tax_id\":null,\"discount_amount\":3,\"created_at\":\"2025-04-13T19:55:28.000000Z\",\"updated_at\":\"2025-04-13T19:55:28.000000Z\",\"deleted_at\":null,\"note\":null,\"vat_amount\":0.3,\"other_taxes_amount\":0.5,\"total_price\":0}}', NULL, '2025-04-13 19:55:28', '2025-04-13 19:55:28'),
(229, 'default', 'created', 'App\\Models\\InvoiceItem', 'created', 45, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":45,\"invoice_id\":20,\"product_name_en\":\"Red bull\",\"product_name_ar\":\"Red bull\",\"product_description_en\":null,\"product_description_ar\":\"Red bull\",\"product_sku\":null,\"product_code\":null,\"quantity\":1,\"unit_price\":120,\"tax_id\":null,\"discount_amount\":0,\"created_at\":\"2025-04-13T19:55:28.000000Z\",\"updated_at\":\"2025-04-13T19:55:28.000000Z\",\"deleted_at\":null,\"note\":null,\"vat_amount\":18,\"other_taxes_amount\":0,\"total_price\":0}}', NULL, '2025-04-13 19:55:28', '2025-04-13 19:55:28'),
(230, 'default', 'created', 'App\\Models\\Invoice', 'created', 21, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":21,\"number\":\"C001-INV-000001\",\"customer_name\":\"Zain ul Eman\",\"customer_email\":\"zainuleman786@gmail.com\",\"customer_phone\":null,\"company_id\":1,\"customer_id\":1,\"billing_address_id\":null,\"shipping_address_id\":null,\"subtotal\":240,\"discount\":53,\"total\":238,\"issue_date\":\"2025-04-13T19:56:09.000000Z\",\"due_date\":\"2025-05-13T19:56:09.000000Z\",\"paid_date\":null,\"invoice_status_id\":1,\"currency_id\":null,\"issued_by_user\":1,\"meta\":null,\"created_at\":\"2025-04-13T19:56:09.000000Z\",\"updated_at\":\"2025-04-13T19:56:09.000000Z\",\"deleted_at\":null,\"amount_paid\":238,\"point_of_sale_id\":3,\"vat\":36,\"other_taxes\":15,\"order_id\":8}}', NULL, '2025-04-13 19:56:09', '2025-04-13 19:56:09'),
(231, 'default', 'created', 'App\\Models\\InvoiceItem', 'created', 46, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":46,\"invoice_id\":21,\"product_name_en\":\"coke\",\"product_name_ar\":\"coke\",\"product_description_en\":null,\"product_description_ar\":null,\"product_sku\":\"234\",\"product_code\":\"532\",\"quantity\":1,\"unit_price\":100,\"tax_id\":null,\"discount_amount\":50,\"created_at\":\"2025-04-13T19:56:09.000000Z\",\"updated_at\":\"2025-04-13T19:56:09.000000Z\",\"deleted_at\":null,\"note\":null,\"vat_amount\":15,\"other_taxes_amount\":10,\"total_price\":0}}', NULL, '2025-04-13 19:56:09', '2025-04-13 19:56:09'),
(232, 'default', 'created', 'App\\Models\\InvoiceItem', 'created', 47, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":47,\"invoice_id\":21,\"product_name_en\":\"Pepsi\",\"product_name_ar\":\"\\u0628\\u064a\\u0628\\u0633\\u064a\",\"product_description_en\":\"pepsi\",\"product_description_ar\":\"\\u0628\\u064a\\u0628\\u0633\\u064a ... \\u0628\\u064a\\u0628\\u0633\\u064a (\\u0628\\u0627\\u0644\\u0625\\u0646\\u062c\\u0644\\u064a\\u0632\\u064a\\u0629: Pepsi)\\u200f \\u0647\\u0648 \\u0645\\u0634\\u0631\\u0648\\u0628 \\u063a\\u0627\\u0632\\u064a \\u0645\\u0643\\u0631\\u0628\\u0646 \\u062a\\u0635\\u0646\\u0639\\u0647 \\u0634\\u0631\\u0643\\u0629 \\u0628\\u064a\\u0628\\u0633\\u064a\\u0643\\u0648 (\\u062d\\u0627\\u0644\\u064a\\u064b\\u0651\\u0627). ... \\u0648\\u064a\\u0631\\u062c\\u0639 \\u0625\\u0646\\u0634\\u0627\\u0624\\u0647 \\u0648\\u062a\\u0637\\u0648\\u064a\\u0631\\u0647 \\u0641\\u064a \\u0627\\u0644\\u0623\\u0635\\u0644 \\u0625\\u0644\\u0649 \\u0639\\u0627\\u0645 1893 \\u0639\\u0644\\u0649 \\u064a\\u062f \\u0627\\u0644\\u0635\\u064a\\u062f\\u0644\\u0627\\u0646\\u064a \\u0643\\u0627\\u0644\\u064a\\u0628 \\u0628\\u0631\\u0627\\u062f\\u0647\\u0627\\u0645\\u060c ...\\n\",\"product_sku\":\"23423\",\"product_code\":\"1231\",\"quantity\":10,\"unit_price\":2,\"tax_id\":null,\"discount_amount\":3,\"created_at\":\"2025-04-13T19:56:09.000000Z\",\"updated_at\":\"2025-04-13T19:56:09.000000Z\",\"deleted_at\":null,\"note\":null,\"vat_amount\":0.3,\"other_taxes_amount\":0.5,\"total_price\":0}}', NULL, '2025-04-13 19:56:09', '2025-04-13 19:56:09'),
(233, 'default', 'created', 'App\\Models\\InvoiceItem', 'created', 48, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":48,\"invoice_id\":21,\"product_name_en\":\"Red bull\",\"product_name_ar\":\"Red bull\",\"product_description_en\":null,\"product_description_ar\":\"Red bull\",\"product_sku\":null,\"product_code\":null,\"quantity\":1,\"unit_price\":120,\"tax_id\":null,\"discount_amount\":0,\"created_at\":\"2025-04-13T19:56:09.000000Z\",\"updated_at\":\"2025-04-13T19:56:09.000000Z\",\"deleted_at\":null,\"note\":null,\"vat_amount\":18,\"other_taxes_amount\":0,\"total_price\":0}}', NULL, '2025-04-13 19:56:10', '2025-04-13 19:56:10'),
(234, 'default', 'created', 'App\\Models\\Invoice', 'created', 22, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":22,\"number\":\"C001-INV-000001\",\"customer_name\":\"Zain ul Eman\",\"customer_email\":\"zainuleman786@gmail.com\",\"customer_phone\":null,\"company_id\":1,\"customer_id\":1,\"billing_address_id\":null,\"shipping_address_id\":null,\"subtotal\":240,\"discount\":53,\"total\":238,\"issue_date\":\"2025-04-13T19:59:40.000000Z\",\"due_date\":\"2025-05-13T19:59:40.000000Z\",\"paid_date\":null,\"invoice_status_id\":1,\"currency_id\":null,\"issued_by_user\":1,\"meta\":null,\"created_at\":\"2025-04-13T19:59:40.000000Z\",\"updated_at\":\"2025-04-13T19:59:40.000000Z\",\"deleted_at\":null,\"amount_paid\":238,\"point_of_sale_id\":3,\"vat\":36,\"other_taxes\":15,\"order_id\":8}}', NULL, '2025-04-13 19:59:40', '2025-04-13 19:59:40'),
(235, 'default', 'created', 'App\\Models\\InvoiceItem', 'created', 49, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":49,\"invoice_id\":22,\"product_name_en\":\"coke\",\"product_name_ar\":\"coke\",\"product_description_en\":null,\"product_description_ar\":null,\"product_sku\":\"234\",\"product_code\":\"532\",\"quantity\":1,\"unit_price\":100,\"tax_id\":null,\"discount_amount\":50,\"created_at\":\"2025-04-13T19:59:40.000000Z\",\"updated_at\":\"2025-04-13T19:59:40.000000Z\",\"deleted_at\":null,\"note\":null,\"vat_amount\":15,\"other_taxes_amount\":10,\"total_price\":0}}', NULL, '2025-04-13 19:59:41', '2025-04-13 19:59:41'),
(236, 'default', 'created', 'App\\Models\\InvoiceItem', 'created', 50, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":50,\"invoice_id\":22,\"product_name_en\":\"Pepsi\",\"product_name_ar\":\"\\u0628\\u064a\\u0628\\u0633\\u064a\",\"product_description_en\":\"pepsi\",\"product_description_ar\":\"\\u0628\\u064a\\u0628\\u0633\\u064a ... \\u0628\\u064a\\u0628\\u0633\\u064a (\\u0628\\u0627\\u0644\\u0625\\u0646\\u062c\\u0644\\u064a\\u0632\\u064a\\u0629: Pepsi)\\u200f \\u0647\\u0648 \\u0645\\u0634\\u0631\\u0648\\u0628 \\u063a\\u0627\\u0632\\u064a \\u0645\\u0643\\u0631\\u0628\\u0646 \\u062a\\u0635\\u0646\\u0639\\u0647 \\u0634\\u0631\\u0643\\u0629 \\u0628\\u064a\\u0628\\u0633\\u064a\\u0643\\u0648 (\\u062d\\u0627\\u0644\\u064a\\u064b\\u0651\\u0627). ... \\u0648\\u064a\\u0631\\u062c\\u0639 \\u0625\\u0646\\u0634\\u0627\\u0624\\u0647 \\u0648\\u062a\\u0637\\u0648\\u064a\\u0631\\u0647 \\u0641\\u064a \\u0627\\u0644\\u0623\\u0635\\u0644 \\u0625\\u0644\\u0649 \\u0639\\u0627\\u0645 1893 \\u0639\\u0644\\u0649 \\u064a\\u062f \\u0627\\u0644\\u0635\\u064a\\u062f\\u0644\\u0627\\u0646\\u064a \\u0643\\u0627\\u0644\\u064a\\u0628 \\u0628\\u0631\\u0627\\u062f\\u0647\\u0627\\u0645\\u060c ...\\n\",\"product_sku\":\"23423\",\"product_code\":\"1231\",\"quantity\":10,\"unit_price\":2,\"tax_id\":null,\"discount_amount\":3,\"created_at\":\"2025-04-13T19:59:41.000000Z\",\"updated_at\":\"2025-04-13T19:59:41.000000Z\",\"deleted_at\":null,\"note\":null,\"vat_amount\":0.3,\"other_taxes_amount\":0.5,\"total_price\":0}}', NULL, '2025-04-13 19:59:41', '2025-04-13 19:59:41'),
(237, 'default', 'created', 'App\\Models\\InvoiceItem', 'created', 51, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":51,\"invoice_id\":22,\"product_name_en\":\"Red bull\",\"product_name_ar\":\"Red bull\",\"product_description_en\":null,\"product_description_ar\":\"Red bull\",\"product_sku\":null,\"product_code\":null,\"quantity\":1,\"unit_price\":120,\"tax_id\":null,\"discount_amount\":0,\"created_at\":\"2025-04-13T19:59:41.000000Z\",\"updated_at\":\"2025-04-13T19:59:41.000000Z\",\"deleted_at\":null,\"note\":null,\"vat_amount\":18,\"other_taxes_amount\":0,\"total_price\":0}}', NULL, '2025-04-13 19:59:41', '2025-04-13 19:59:41'),
(238, 'default', 'created', 'App\\Models\\Invoice', 'created', 23, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":23,\"number\":\"C001-INV-000001\",\"customer_name\":\"Zain ul Eman\",\"customer_email\":\"zainuleman786@gmail.com\",\"customer_phone\":null,\"company_id\":1,\"customer_id\":1,\"billing_address_id\":null,\"shipping_address_id\":null,\"subtotal\":240,\"discount\":53,\"total\":238,\"issue_date\":\"2025-04-13T20:22:24.000000Z\",\"due_date\":\"2025-05-13T20:22:24.000000Z\",\"paid_date\":null,\"invoice_status_id\":1,\"currency_id\":null,\"issued_by_user\":1,\"meta\":null,\"created_at\":\"2025-04-13T20:22:24.000000Z\",\"updated_at\":\"2025-04-13T20:22:24.000000Z\",\"deleted_at\":null,\"amount_paid\":230,\"point_of_sale_id\":3,\"vat\":36,\"other_taxes\":15,\"order_id\":8}}', NULL, '2025-04-13 20:22:24', '2025-04-13 20:22:24'),
(239, 'default', 'created', 'App\\Models\\InvoiceItem', 'created', 52, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":52,\"invoice_id\":23,\"product_name_en\":\"coke\",\"product_name_ar\":\"coke\",\"product_description_en\":null,\"product_description_ar\":null,\"product_sku\":\"234\",\"product_code\":\"532\",\"quantity\":1,\"unit_price\":100,\"tax_id\":null,\"discount_amount\":50,\"created_at\":\"2025-04-13T20:22:24.000000Z\",\"updated_at\":\"2025-04-13T20:22:24.000000Z\",\"deleted_at\":null,\"note\":null,\"vat_amount\":15,\"other_taxes_amount\":10,\"total_price\":0}}', NULL, '2025-04-13 20:22:24', '2025-04-13 20:22:24'),
(240, 'default', 'created', 'App\\Models\\InvoiceItem', 'created', 53, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":53,\"invoice_id\":23,\"product_name_en\":\"Pepsi\",\"product_name_ar\":\"\\u0628\\u064a\\u0628\\u0633\\u064a\",\"product_description_en\":\"pepsi\",\"product_description_ar\":\"\\u0628\\u064a\\u0628\\u0633\\u064a ... \\u0628\\u064a\\u0628\\u0633\\u064a (\\u0628\\u0627\\u0644\\u0625\\u0646\\u062c\\u0644\\u064a\\u0632\\u064a\\u0629: Pepsi)\\u200f \\u0647\\u0648 \\u0645\\u0634\\u0631\\u0648\\u0628 \\u063a\\u0627\\u0632\\u064a \\u0645\\u0643\\u0631\\u0628\\u0646 \\u062a\\u0635\\u0646\\u0639\\u0647 \\u0634\\u0631\\u0643\\u0629 \\u0628\\u064a\\u0628\\u0633\\u064a\\u0643\\u0648 (\\u062d\\u0627\\u0644\\u064a\\u064b\\u0651\\u0627). ... \\u0648\\u064a\\u0631\\u062c\\u0639 \\u0625\\u0646\\u0634\\u0627\\u0624\\u0647 \\u0648\\u062a\\u0637\\u0648\\u064a\\u0631\\u0647 \\u0641\\u064a \\u0627\\u0644\\u0623\\u0635\\u0644 \\u0625\\u0644\\u0649 \\u0639\\u0627\\u0645 1893 \\u0639\\u0644\\u0649 \\u064a\\u062f \\u0627\\u0644\\u0635\\u064a\\u062f\\u0644\\u0627\\u0646\\u064a \\u0643\\u0627\\u0644\\u064a\\u0628 \\u0628\\u0631\\u0627\\u062f\\u0647\\u0627\\u0645\\u060c ...\\n\",\"product_sku\":\"23423\",\"product_code\":\"1231\",\"quantity\":10,\"unit_price\":2,\"tax_id\":null,\"discount_amount\":3,\"created_at\":\"2025-04-13T20:22:24.000000Z\",\"updated_at\":\"2025-04-13T20:22:24.000000Z\",\"deleted_at\":null,\"note\":null,\"vat_amount\":0.3,\"other_taxes_amount\":0.5,\"total_price\":0}}', NULL, '2025-04-13 20:22:24', '2025-04-13 20:22:24'),
(241, 'default', 'created', 'App\\Models\\InvoiceItem', 'created', 54, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":54,\"invoice_id\":23,\"product_name_en\":\"Red bull\",\"product_name_ar\":\"Red bull\",\"product_description_en\":null,\"product_description_ar\":\"Red bull\",\"product_sku\":null,\"product_code\":null,\"quantity\":1,\"unit_price\":120,\"tax_id\":null,\"discount_amount\":0,\"created_at\":\"2025-04-13T20:22:24.000000Z\",\"updated_at\":\"2025-04-13T20:22:24.000000Z\",\"deleted_at\":null,\"note\":null,\"vat_amount\":18,\"other_taxes_amount\":0,\"total_price\":0}}', NULL, '2025-04-13 20:22:24', '2025-04-13 20:22:24'),
(242, 'default', 'created', 'App\\Models\\Invoice', 'created', 24, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":24,\"number\":\"C001-INV-000001\",\"customer_name\":\"Zain ul Eman\",\"customer_email\":\"zainuleman786@gmail.com\",\"customer_phone\":null,\"company_id\":1,\"customer_id\":1,\"billing_address_id\":null,\"shipping_address_id\":null,\"subtotal\":240,\"discount\":53,\"total\":238,\"issue_date\":\"2025-04-13T20:23:51.000000Z\",\"due_date\":\"2025-05-13T20:23:51.000000Z\",\"paid_date\":null,\"invoice_status_id\":1,\"currency_id\":null,\"issued_by_user\":1,\"meta\":null,\"created_at\":\"2025-04-13T20:23:51.000000Z\",\"updated_at\":\"2025-04-13T20:23:51.000000Z\",\"deleted_at\":null,\"amount_paid\":230,\"point_of_sale_id\":3,\"vat\":36,\"other_taxes\":15,\"order_id\":8}}', NULL, '2025-04-13 20:23:51', '2025-04-13 20:23:51'),
(243, 'default', 'created', 'App\\Models\\InvoiceItem', 'created', 55, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":55,\"invoice_id\":24,\"product_name_en\":\"coke\",\"product_name_ar\":\"coke\",\"product_description_en\":null,\"product_description_ar\":null,\"product_sku\":\"234\",\"product_code\":\"532\",\"quantity\":1,\"unit_price\":100,\"tax_id\":null,\"discount_amount\":50,\"created_at\":\"2025-04-13T20:23:51.000000Z\",\"updated_at\":\"2025-04-13T20:23:51.000000Z\",\"deleted_at\":null,\"note\":null,\"vat_amount\":15,\"other_taxes_amount\":10,\"total_price\":0}}', NULL, '2025-04-13 20:23:51', '2025-04-13 20:23:51'),
(244, 'default', 'created', 'App\\Models\\InvoiceItem', 'created', 56, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":56,\"invoice_id\":24,\"product_name_en\":\"Pepsi\",\"product_name_ar\":\"\\u0628\\u064a\\u0628\\u0633\\u064a\",\"product_description_en\":\"pepsi\",\"product_description_ar\":\"\\u0628\\u064a\\u0628\\u0633\\u064a ... \\u0628\\u064a\\u0628\\u0633\\u064a (\\u0628\\u0627\\u0644\\u0625\\u0646\\u062c\\u0644\\u064a\\u0632\\u064a\\u0629: Pepsi)\\u200f \\u0647\\u0648 \\u0645\\u0634\\u0631\\u0648\\u0628 \\u063a\\u0627\\u0632\\u064a \\u0645\\u0643\\u0631\\u0628\\u0646 \\u062a\\u0635\\u0646\\u0639\\u0647 \\u0634\\u0631\\u0643\\u0629 \\u0628\\u064a\\u0628\\u0633\\u064a\\u0643\\u0648 (\\u062d\\u0627\\u0644\\u064a\\u064b\\u0651\\u0627). ... \\u0648\\u064a\\u0631\\u062c\\u0639 \\u0625\\u0646\\u0634\\u0627\\u0624\\u0647 \\u0648\\u062a\\u0637\\u0648\\u064a\\u0631\\u0647 \\u0641\\u064a \\u0627\\u0644\\u0623\\u0635\\u0644 \\u0625\\u0644\\u0649 \\u0639\\u0627\\u0645 1893 \\u0639\\u0644\\u0649 \\u064a\\u062f \\u0627\\u0644\\u0635\\u064a\\u062f\\u0644\\u0627\\u0646\\u064a \\u0643\\u0627\\u0644\\u064a\\u0628 \\u0628\\u0631\\u0627\\u062f\\u0647\\u0627\\u0645\\u060c ...\\n\",\"product_sku\":\"23423\",\"product_code\":\"1231\",\"quantity\":10,\"unit_price\":2,\"tax_id\":null,\"discount_amount\":3,\"created_at\":\"2025-04-13T20:23:51.000000Z\",\"updated_at\":\"2025-04-13T20:23:51.000000Z\",\"deleted_at\":null,\"note\":null,\"vat_amount\":0.3,\"other_taxes_amount\":0.5,\"total_price\":0}}', NULL, '2025-04-13 20:23:51', '2025-04-13 20:23:51'),
(245, 'default', 'created', 'App\\Models\\InvoiceItem', 'created', 57, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":57,\"invoice_id\":24,\"product_name_en\":\"Red bull\",\"product_name_ar\":\"Red bull\",\"product_description_en\":null,\"product_description_ar\":\"Red bull\",\"product_sku\":null,\"product_code\":null,\"quantity\":1,\"unit_price\":120,\"tax_id\":null,\"discount_amount\":0,\"created_at\":\"2025-04-13T20:23:51.000000Z\",\"updated_at\":\"2025-04-13T20:23:51.000000Z\",\"deleted_at\":null,\"note\":null,\"vat_amount\":18,\"other_taxes_amount\":0,\"total_price\":0}}', NULL, '2025-04-13 20:23:51', '2025-04-13 20:23:51'),
(246, 'default', 'created', 'App\\Models\\Invoice', 'created', 25, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":25,\"number\":\"C001-INV-000001\",\"customer_name\":\"Zain ul Eman\",\"customer_email\":\"zainuleman786@gmail.com\",\"customer_phone\":null,\"company_id\":1,\"customer_id\":1,\"billing_address_id\":null,\"shipping_address_id\":null,\"subtotal\":240,\"discount\":53,\"total\":238,\"issue_date\":\"2025-04-13T20:26:04.000000Z\",\"due_date\":\"2025-05-13T20:26:04.000000Z\",\"paid_date\":null,\"invoice_status_id\":1,\"currency_id\":null,\"issued_by_user\":1,\"meta\":null,\"created_at\":\"2025-04-13T20:26:04.000000Z\",\"updated_at\":\"2025-04-13T20:26:04.000000Z\",\"deleted_at\":null,\"amount_paid\":236,\"point_of_sale_id\":3,\"vat\":36,\"other_taxes\":15,\"order_id\":8}}', NULL, '2025-04-13 20:26:04', '2025-04-13 20:26:04'),
(247, 'default', 'created', 'App\\Models\\InvoiceItem', 'created', 58, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":58,\"invoice_id\":25,\"product_name_en\":\"coke\",\"product_name_ar\":\"coke\",\"product_description_en\":null,\"product_description_ar\":null,\"product_sku\":\"234\",\"product_code\":\"532\",\"quantity\":1,\"unit_price\":100,\"tax_id\":null,\"discount_amount\":50,\"created_at\":\"2025-04-13T20:26:04.000000Z\",\"updated_at\":\"2025-04-13T20:26:04.000000Z\",\"deleted_at\":null,\"note\":null,\"vat_amount\":15,\"other_taxes_amount\":10,\"total_price\":0}}', NULL, '2025-04-13 20:26:04', '2025-04-13 20:26:04'),
(248, 'default', 'created', 'App\\Models\\InvoiceItem', 'created', 59, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":59,\"invoice_id\":25,\"product_name_en\":\"Pepsi\",\"product_name_ar\":\"\\u0628\\u064a\\u0628\\u0633\\u064a\",\"product_description_en\":\"pepsi\",\"product_description_ar\":\"\\u0628\\u064a\\u0628\\u0633\\u064a ... \\u0628\\u064a\\u0628\\u0633\\u064a (\\u0628\\u0627\\u0644\\u0625\\u0646\\u062c\\u0644\\u064a\\u0632\\u064a\\u0629: Pepsi)\\u200f \\u0647\\u0648 \\u0645\\u0634\\u0631\\u0648\\u0628 \\u063a\\u0627\\u0632\\u064a \\u0645\\u0643\\u0631\\u0628\\u0646 \\u062a\\u0635\\u0646\\u0639\\u0647 \\u0634\\u0631\\u0643\\u0629 \\u0628\\u064a\\u0628\\u0633\\u064a\\u0643\\u0648 (\\u062d\\u0627\\u0644\\u064a\\u064b\\u0651\\u0627). ... \\u0648\\u064a\\u0631\\u062c\\u0639 \\u0625\\u0646\\u0634\\u0627\\u0624\\u0647 \\u0648\\u062a\\u0637\\u0648\\u064a\\u0631\\u0647 \\u0641\\u064a \\u0627\\u0644\\u0623\\u0635\\u0644 \\u0625\\u0644\\u0649 \\u0639\\u0627\\u0645 1893 \\u0639\\u0644\\u0649 \\u064a\\u062f \\u0627\\u0644\\u0635\\u064a\\u062f\\u0644\\u0627\\u0646\\u064a \\u0643\\u0627\\u0644\\u064a\\u0628 \\u0628\\u0631\\u0627\\u062f\\u0647\\u0627\\u0645\\u060c ...\\n\",\"product_sku\":\"23423\",\"product_code\":\"1231\",\"quantity\":10,\"unit_price\":2,\"tax_id\":null,\"discount_amount\":3,\"created_at\":\"2025-04-13T20:26:04.000000Z\",\"updated_at\":\"2025-04-13T20:26:04.000000Z\",\"deleted_at\":null,\"note\":null,\"vat_amount\":0.3,\"other_taxes_amount\":0.5,\"total_price\":0}}', NULL, '2025-04-13 20:26:04', '2025-04-13 20:26:04'),
(249, 'default', 'created', 'App\\Models\\InvoiceItem', 'created', 60, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":60,\"invoice_id\":25,\"product_name_en\":\"Red bull\",\"product_name_ar\":\"Red bull\",\"product_description_en\":null,\"product_description_ar\":\"Red bull\",\"product_sku\":null,\"product_code\":null,\"quantity\":1,\"unit_price\":120,\"tax_id\":null,\"discount_amount\":0,\"created_at\":\"2025-04-13T20:26:04.000000Z\",\"updated_at\":\"2025-04-13T20:26:04.000000Z\",\"deleted_at\":null,\"note\":null,\"vat_amount\":18,\"other_taxes_amount\":0,\"total_price\":0}}', NULL, '2025-04-13 20:26:04', '2025-04-13 20:26:04'),
(250, 'default', 'updated', 'App\\Models\\Invoice', 'updated', 25, 'App\\Models\\User', 1, '{\"attributes\":{\"issue_date\":\"2025-04-12T21:00:00.000000Z\",\"updated_at\":\"2025-04-13T20:26:41.000000Z\"},\"old\":{\"issue_date\":\"2025-04-13T20:26:04.000000Z\",\"updated_at\":\"2025-04-13T20:26:04.000000Z\"}}', NULL, '2025-04-13 20:26:41', '2025-04-13 20:26:41'),
(251, 'default', 'created', 'App\\Models\\Invoice', 'created', 26, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":26,\"number\":\"C001-INV-000001\",\"customer_name\":\"Zain ul Eman\",\"customer_email\":\"zainuleman786@gmail.com\",\"customer_phone\":null,\"company_id\":1,\"customer_id\":1,\"billing_address_id\":null,\"shipping_address_id\":null,\"subtotal\":240,\"discount\":53,\"total\":238,\"issue_date\":\"2025-04-13T20:29:53.000000Z\",\"due_date\":\"2025-05-13T20:29:53.000000Z\",\"paid_date\":null,\"invoice_status_id\":1,\"currency_id\":null,\"issued_by_user\":1,\"meta\":null,\"created_at\":\"2025-04-13T20:29:53.000000Z\",\"updated_at\":\"2025-04-13T20:29:53.000000Z\",\"deleted_at\":null,\"amount_paid\":235,\"point_of_sale_id\":3,\"vat\":36,\"other_taxes\":15,\"order_id\":8}}', NULL, '2025-04-13 20:29:53', '2025-04-13 20:29:53'),
(252, 'default', 'created', 'App\\Models\\InvoiceItem', 'created', 61, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":61,\"invoice_id\":26,\"product_name_en\":\"coke\",\"product_name_ar\":\"coke\",\"product_description_en\":null,\"product_description_ar\":null,\"product_sku\":\"234\",\"product_code\":\"532\",\"quantity\":1,\"unit_price\":100,\"tax_id\":null,\"discount_amount\":50,\"created_at\":\"2025-04-13T20:29:53.000000Z\",\"updated_at\":\"2025-04-13T20:29:53.000000Z\",\"deleted_at\":null,\"note\":null,\"vat_amount\":15,\"other_taxes_amount\":10,\"total_price\":0}}', NULL, '2025-04-13 20:29:53', '2025-04-13 20:29:53'),
(253, 'default', 'created', 'App\\Models\\InvoiceItem', 'created', 62, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":62,\"invoice_id\":26,\"product_name_en\":\"Pepsi\",\"product_name_ar\":\"\\u0628\\u064a\\u0628\\u0633\\u064a\",\"product_description_en\":\"pepsi\",\"product_description_ar\":\"\\u0628\\u064a\\u0628\\u0633\\u064a ... \\u0628\\u064a\\u0628\\u0633\\u064a (\\u0628\\u0627\\u0644\\u0625\\u0646\\u062c\\u0644\\u064a\\u0632\\u064a\\u0629: Pepsi)\\u200f \\u0647\\u0648 \\u0645\\u0634\\u0631\\u0648\\u0628 \\u063a\\u0627\\u0632\\u064a \\u0645\\u0643\\u0631\\u0628\\u0646 \\u062a\\u0635\\u0646\\u0639\\u0647 \\u0634\\u0631\\u0643\\u0629 \\u0628\\u064a\\u0628\\u0633\\u064a\\u0643\\u0648 (\\u062d\\u0627\\u0644\\u064a\\u064b\\u0651\\u0627). ... \\u0648\\u064a\\u0631\\u062c\\u0639 \\u0625\\u0646\\u0634\\u0627\\u0624\\u0647 \\u0648\\u062a\\u0637\\u0648\\u064a\\u0631\\u0647 \\u0641\\u064a \\u0627\\u0644\\u0623\\u0635\\u0644 \\u0625\\u0644\\u0649 \\u0639\\u0627\\u0645 1893 \\u0639\\u0644\\u0649 \\u064a\\u062f \\u0627\\u0644\\u0635\\u064a\\u062f\\u0644\\u0627\\u0646\\u064a \\u0643\\u0627\\u0644\\u064a\\u0628 \\u0628\\u0631\\u0627\\u062f\\u0647\\u0627\\u0645\\u060c ...\\n\",\"product_sku\":\"23423\",\"product_code\":\"1231\",\"quantity\":10,\"unit_price\":2,\"tax_id\":null,\"discount_amount\":3,\"created_at\":\"2025-04-13T20:29:53.000000Z\",\"updated_at\":\"2025-04-13T20:29:53.000000Z\",\"deleted_at\":null,\"note\":null,\"vat_amount\":0.3,\"other_taxes_amount\":0.5,\"total_price\":0}}', NULL, '2025-04-13 20:29:53', '2025-04-13 20:29:53'),
(254, 'default', 'created', 'App\\Models\\InvoiceItem', 'created', 63, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":63,\"invoice_id\":26,\"product_name_en\":\"Red bull\",\"product_name_ar\":\"Red bull\",\"product_description_en\":null,\"product_description_ar\":\"Red bull\",\"product_sku\":null,\"product_code\":null,\"quantity\":1,\"unit_price\":120,\"tax_id\":null,\"discount_amount\":0,\"created_at\":\"2025-04-13T20:29:53.000000Z\",\"updated_at\":\"2025-04-13T20:29:53.000000Z\",\"deleted_at\":null,\"note\":null,\"vat_amount\":18,\"other_taxes_amount\":0,\"total_price\":0}}', NULL, '2025-04-13 20:29:53', '2025-04-13 20:29:53'),
(255, 'default', 'updated', 'App\\Models\\Invoice', 'updated', 26, 'App\\Models\\User', 1, '{\"attributes\":{\"issue_date\":\"2025-04-12T21:00:00.000000Z\",\"updated_at\":\"2025-04-13T20:30:12.000000Z\"},\"old\":{\"issue_date\":\"2025-04-13T20:29:53.000000Z\",\"updated_at\":\"2025-04-13T20:29:53.000000Z\"}}', NULL, '2025-04-13 20:30:12', '2025-04-13 20:30:12'),
(256, 'default', 'created', 'App\\Models\\Invoice', 'created', 27, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":27,\"number\":\"C001-INV-000001\",\"customer_name\":\"Zain ul Eman\",\"customer_email\":\"zainuleman786@gmail.com\",\"customer_phone\":null,\"company_id\":1,\"customer_id\":1,\"billing_address_id\":null,\"shipping_address_id\":null,\"subtotal\":240,\"discount\":53,\"total\":238,\"issue_date\":\"2025-04-13T23:29:52.000000Z\",\"due_date\":\"2025-05-13T23:29:52.000000Z\",\"paid_date\":null,\"invoice_status_id\":1,\"currency_id\":null,\"issued_by_user\":1,\"meta\":null,\"created_at\":\"2025-04-13T23:29:52.000000Z\",\"updated_at\":\"2025-04-13T23:29:52.000000Z\",\"deleted_at\":null,\"amount_paid\":236,\"point_of_sale_id\":3,\"vat\":36,\"other_taxes\":15,\"order_id\":8}}', NULL, '2025-04-13 23:29:52', '2025-04-13 23:29:52'),
(257, 'default', 'created', 'App\\Models\\InvoiceItem', 'created', 64, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":64,\"invoice_id\":27,\"product_name_en\":\"coke\",\"product_name_ar\":\"coke\",\"product_description_en\":null,\"product_description_ar\":null,\"product_sku\":\"234\",\"product_code\":\"532\",\"quantity\":1,\"unit_price\":100,\"tax_id\":null,\"discount_amount\":50,\"created_at\":\"2025-04-13T23:29:52.000000Z\",\"updated_at\":\"2025-04-13T23:29:52.000000Z\",\"deleted_at\":null,\"note\":null,\"vat_amount\":15,\"other_taxes_amount\":10,\"total_price\":0}}', NULL, '2025-04-13 23:29:52', '2025-04-13 23:29:52'),
(258, 'default', 'created', 'App\\Models\\InvoiceItem', 'created', 65, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":65,\"invoice_id\":27,\"product_name_en\":\"Pepsi\",\"product_name_ar\":\"\\u0628\\u064a\\u0628\\u0633\\u064a\",\"product_description_en\":\"pepsi\",\"product_description_ar\":\"\\u0628\\u064a\\u0628\\u0633\\u064a ... \\u0628\\u064a\\u0628\\u0633\\u064a (\\u0628\\u0627\\u0644\\u0625\\u0646\\u062c\\u0644\\u064a\\u0632\\u064a\\u0629: Pepsi)\\u200f \\u0647\\u0648 \\u0645\\u0634\\u0631\\u0648\\u0628 \\u063a\\u0627\\u0632\\u064a \\u0645\\u0643\\u0631\\u0628\\u0646 \\u062a\\u0635\\u0646\\u0639\\u0647 \\u0634\\u0631\\u0643\\u0629 \\u0628\\u064a\\u0628\\u0633\\u064a\\u0643\\u0648 (\\u062d\\u0627\\u0644\\u064a\\u064b\\u0651\\u0627). ... \\u0648\\u064a\\u0631\\u062c\\u0639 \\u0625\\u0646\\u0634\\u0627\\u0624\\u0647 \\u0648\\u062a\\u0637\\u0648\\u064a\\u0631\\u0647 \\u0641\\u064a \\u0627\\u0644\\u0623\\u0635\\u0644 \\u0625\\u0644\\u0649 \\u0639\\u0627\\u0645 1893 \\u0639\\u0644\\u0649 \\u064a\\u062f \\u0627\\u0644\\u0635\\u064a\\u062f\\u0644\\u0627\\u0646\\u064a \\u0643\\u0627\\u0644\\u064a\\u0628 \\u0628\\u0631\\u0627\\u062f\\u0647\\u0627\\u0645\\u060c ...\\n\",\"product_sku\":\"23423\",\"product_code\":\"1231\",\"quantity\":10,\"unit_price\":2,\"tax_id\":null,\"discount_amount\":3,\"created_at\":\"2025-04-13T23:29:52.000000Z\",\"updated_at\":\"2025-04-13T23:29:52.000000Z\",\"deleted_at\":null,\"note\":null,\"vat_amount\":0.3,\"other_taxes_amount\":0.5,\"total_price\":0}}', NULL, '2025-04-13 23:29:52', '2025-04-13 23:29:52'),
(259, 'default', 'created', 'App\\Models\\InvoiceItem', 'created', 66, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":66,\"invoice_id\":27,\"product_name_en\":\"Red bull\",\"product_name_ar\":\"Red bull\",\"product_description_en\":null,\"product_description_ar\":\"Red bull\",\"product_sku\":null,\"product_code\":null,\"quantity\":1,\"unit_price\":120,\"tax_id\":null,\"discount_amount\":0,\"created_at\":\"2025-04-13T23:29:52.000000Z\",\"updated_at\":\"2025-04-13T23:29:52.000000Z\",\"deleted_at\":null,\"note\":null,\"vat_amount\":18,\"other_taxes_amount\":0,\"total_price\":0}}', NULL, '2025-04-13 23:29:52', '2025-04-13 23:29:52'),
(260, 'default', 'updated', 'App\\Models\\Invoice', 'updated', 27, 'App\\Models\\User', 1, '{\"attributes\":{\"issue_date\":\"2025-04-13T21:00:00.000000Z\",\"updated_at\":\"2025-04-13T23:30:08.000000Z\"},\"old\":{\"issue_date\":\"2025-04-13T23:29:52.000000Z\",\"updated_at\":\"2025-04-13T23:29:52.000000Z\"}}', NULL, '2025-04-13 23:30:08', '2025-04-13 23:30:08'),
(261, 'default', 'updated', 'App\\Models\\Invoice', 'updated', 27, 'App\\Models\\User', 1, '{\"attributes\":{\"updated_at\":\"2025-04-13T23:38:24.000000Z\",\"amount_paid\":238},\"old\":{\"updated_at\":\"2025-04-13T23:30:08.000000Z\",\"amount_paid\":236}}', NULL, '2025-04-13 23:38:24', '2025-04-13 23:38:24'),
(262, 'default', 'updated', 'App\\Models\\Invoice', 'updated', 27, 'App\\Models\\User', 1, '{\"attributes\":{\"updated_at\":\"2025-04-13T23:39:14.000000Z\",\"amount_paid\":243},\"old\":{\"updated_at\":\"2025-04-13T23:38:24.000000Z\",\"amount_paid\":238}}', NULL, '2025-04-13 23:39:14', '2025-04-13 23:39:14'),
(263, 'default', 'updated', 'App\\Models\\Order', 'updated', 8, 'App\\Models\\User', 1, '{\"attributes\":{\"amount_paid\":\"238.00\"},\"old\":{\"amount_paid\":\"230.00\"}}', NULL, '2025-04-13 23:41:00', '2025-04-13 23:41:00'),
(264, 'default', 'created', 'App\\Models\\Invoice', 'created', 28, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":28,\"number\":\"C001-INV-000001\",\"customer_name\":\"Zain ul Eman\",\"customer_email\":\"zainuleman786@gmail.com\",\"customer_phone\":null,\"company_id\":1,\"customer_id\":1,\"billing_address_id\":null,\"shipping_address_id\":null,\"subtotal\":240,\"discount\":53,\"total\":238,\"issue_date\":\"2025-04-13T23:43:31.000000Z\",\"due_date\":\"2025-05-13T23:43:31.000000Z\",\"paid_date\":null,\"invoice_status_id\":1,\"currency_id\":null,\"issued_by_user\":1,\"meta\":null,\"created_at\":\"2025-04-13T23:43:31.000000Z\",\"updated_at\":\"2025-04-13T23:43:31.000000Z\",\"deleted_at\":null,\"amount_paid\":238,\"point_of_sale_id\":3,\"vat\":36,\"other_taxes\":15,\"order_id\":8}}', NULL, '2025-04-13 23:43:31', '2025-04-13 23:43:31'),
(265, 'default', 'created', 'App\\Models\\InvoiceItem', 'created', 67, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":67,\"invoice_id\":28,\"product_name_en\":\"coke\",\"product_name_ar\":\"coke\",\"product_description_en\":null,\"product_description_ar\":null,\"product_sku\":\"234\",\"product_code\":\"532\",\"quantity\":1,\"unit_price\":100,\"tax_id\":null,\"discount_amount\":50,\"created_at\":\"2025-04-13T23:43:31.000000Z\",\"updated_at\":\"2025-04-13T23:43:31.000000Z\",\"deleted_at\":null,\"note\":null,\"vat_amount\":15,\"other_taxes_amount\":10,\"total_price\":0}}', NULL, '2025-04-13 23:43:31', '2025-04-13 23:43:31'),
(266, 'default', 'created', 'App\\Models\\InvoiceItem', 'created', 68, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":68,\"invoice_id\":28,\"product_name_en\":\"Pepsi\",\"product_name_ar\":\"\\u0628\\u064a\\u0628\\u0633\\u064a\",\"product_description_en\":\"pepsi\",\"product_description_ar\":\"\\u0628\\u064a\\u0628\\u0633\\u064a ... \\u0628\\u064a\\u0628\\u0633\\u064a (\\u0628\\u0627\\u0644\\u0625\\u0646\\u062c\\u0644\\u064a\\u0632\\u064a\\u0629: Pepsi)\\u200f \\u0647\\u0648 \\u0645\\u0634\\u0631\\u0648\\u0628 \\u063a\\u0627\\u0632\\u064a \\u0645\\u0643\\u0631\\u0628\\u0646 \\u062a\\u0635\\u0646\\u0639\\u0647 \\u0634\\u0631\\u0643\\u0629 \\u0628\\u064a\\u0628\\u0633\\u064a\\u0643\\u0648 (\\u062d\\u0627\\u0644\\u064a\\u064b\\u0651\\u0627). ... \\u0648\\u064a\\u0631\\u062c\\u0639 \\u0625\\u0646\\u0634\\u0627\\u0624\\u0647 \\u0648\\u062a\\u0637\\u0648\\u064a\\u0631\\u0647 \\u0641\\u064a \\u0627\\u0644\\u0623\\u0635\\u0644 \\u0625\\u0644\\u0649 \\u0639\\u0627\\u0645 1893 \\u0639\\u0644\\u0649 \\u064a\\u062f \\u0627\\u0644\\u0635\\u064a\\u062f\\u0644\\u0627\\u0646\\u064a \\u0643\\u0627\\u0644\\u064a\\u0628 \\u0628\\u0631\\u0627\\u062f\\u0647\\u0627\\u0645\\u060c ...\\n\",\"product_sku\":\"23423\",\"product_code\":\"1231\",\"quantity\":10,\"unit_price\":2,\"tax_id\":null,\"discount_amount\":3,\"created_at\":\"2025-04-13T23:43:31.000000Z\",\"updated_at\":\"2025-04-13T23:43:31.000000Z\",\"deleted_at\":null,\"note\":null,\"vat_amount\":0.3,\"other_taxes_amount\":0.5,\"total_price\":0}}', NULL, '2025-04-13 23:43:31', '2025-04-13 23:43:31'),
(267, 'default', 'created', 'App\\Models\\InvoiceItem', 'created', 69, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":69,\"invoice_id\":28,\"product_name_en\":\"Red bull\",\"product_name_ar\":\"Red bull\",\"product_description_en\":null,\"product_description_ar\":\"Red bull\",\"product_sku\":null,\"product_code\":null,\"quantity\":1,\"unit_price\":120,\"tax_id\":null,\"discount_amount\":0,\"created_at\":\"2025-04-13T23:43:31.000000Z\",\"updated_at\":\"2025-04-13T23:43:31.000000Z\",\"deleted_at\":null,\"note\":null,\"vat_amount\":18,\"other_taxes_amount\":0,\"total_price\":0}}', NULL, '2025-04-13 23:43:31', '2025-04-13 23:43:31'),
(268, 'default', 'updated', 'App\\Models\\Invoice', 'updated', 28, 'App\\Models\\User', 1, '{\"attributes\":{\"issue_date\":\"2025-04-13T21:00:00.000000Z\",\"updated_at\":\"2025-04-14T00:04:36.000000Z\"},\"old\":{\"issue_date\":\"2025-04-13T23:43:31.000000Z\",\"updated_at\":\"2025-04-13T23:43:31.000000Z\"}}', NULL, '2025-04-14 00:04:36', '2025-04-14 00:04:36'),
(269, 'default', 'created', 'App\\Models\\Invoice', 'created', 29, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":29,\"number\":\"C001-INV-000001\",\"customer_name\":\"Zain ul Eman\",\"customer_email\":\"zainuleman786@gmail.com\",\"customer_phone\":null,\"company_id\":1,\"customer_id\":1,\"billing_address_id\":null,\"shipping_address_id\":null,\"subtotal\":240,\"discount\":53,\"total\":238,\"issue_date\":\"2025-04-14T00:05:07.000000Z\",\"due_date\":\"2025-05-14T00:05:07.000000Z\",\"paid_date\":null,\"invoice_status_id\":1,\"currency_id\":null,\"issued_by_user\":1,\"meta\":null,\"created_at\":\"2025-04-14T00:05:07.000000Z\",\"updated_at\":\"2025-04-14T00:05:07.000000Z\",\"deleted_at\":null,\"amount_paid\":238,\"point_of_sale_id\":3,\"vat\":36,\"other_taxes\":15,\"order_id\":8}}', NULL, '2025-04-14 00:05:07', '2025-04-14 00:05:07'),
(270, 'default', 'created', 'App\\Models\\InvoiceItem', 'created', 70, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":70,\"invoice_id\":29,\"product_name_en\":\"coke\",\"product_name_ar\":\"coke\",\"product_description_en\":null,\"product_description_ar\":null,\"product_sku\":\"234\",\"product_code\":\"532\",\"quantity\":1,\"unit_price\":100,\"tax_id\":null,\"discount_amount\":50,\"created_at\":\"2025-04-14T00:05:07.000000Z\",\"updated_at\":\"2025-04-14T00:05:07.000000Z\",\"deleted_at\":null,\"note\":null,\"vat_amount\":15,\"other_taxes_amount\":10,\"total_price\":75}}', NULL, '2025-04-14 00:05:07', '2025-04-14 00:05:07'),
(271, 'default', 'created', 'App\\Models\\InvoiceItem', 'created', 71, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":71,\"invoice_id\":29,\"product_name_en\":\"Pepsi\",\"product_name_ar\":\"\\u0628\\u064a\\u0628\\u0633\\u064a\",\"product_description_en\":\"pepsi\",\"product_description_ar\":\"\\u0628\\u064a\\u0628\\u0633\\u064a ... \\u0628\\u064a\\u0628\\u0633\\u064a (\\u0628\\u0627\\u0644\\u0625\\u0646\\u062c\\u0644\\u064a\\u0632\\u064a\\u0629: Pepsi)\\u200f \\u0647\\u0648 \\u0645\\u0634\\u0631\\u0648\\u0628 \\u063a\\u0627\\u0632\\u064a \\u0645\\u0643\\u0631\\u0628\\u0646 \\u062a\\u0635\\u0646\\u0639\\u0647 \\u0634\\u0631\\u0643\\u0629 \\u0628\\u064a\\u0628\\u0633\\u064a\\u0643\\u0648 (\\u062d\\u0627\\u0644\\u064a\\u064b\\u0651\\u0627). ... \\u0648\\u064a\\u0631\\u062c\\u0639 \\u0625\\u0646\\u0634\\u0627\\u0624\\u0647 \\u0648\\u062a\\u0637\\u0648\\u064a\\u0631\\u0647 \\u0641\\u064a \\u0627\\u0644\\u0623\\u0635\\u0644 \\u0625\\u0644\\u0649 \\u0639\\u0627\\u0645 1893 \\u0639\\u0644\\u0649 \\u064a\\u062f \\u0627\\u0644\\u0635\\u064a\\u062f\\u0644\\u0627\\u0646\\u064a \\u0643\\u0627\\u0644\\u064a\\u0628 \\u0628\\u0631\\u0627\\u062f\\u0647\\u0627\\u0645\\u060c ...\\n\",\"product_sku\":\"23423\",\"product_code\":\"1231\",\"quantity\":10,\"unit_price\":2,\"tax_id\":null,\"discount_amount\":3,\"created_at\":\"2025-04-14T00:05:07.000000Z\",\"updated_at\":\"2025-04-14T00:05:07.000000Z\",\"deleted_at\":null,\"note\":null,\"vat_amount\":0.3,\"other_taxes_amount\":0.5,\"total_price\":25}}', NULL, '2025-04-14 00:05:07', '2025-04-14 00:05:07'),
(272, 'default', 'created', 'App\\Models\\InvoiceItem', 'created', 72, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":72,\"invoice_id\":29,\"product_name_en\":\"Red bull\",\"product_name_ar\":\"Red bull\",\"product_description_en\":null,\"product_description_ar\":\"Red bull\",\"product_sku\":null,\"product_code\":null,\"quantity\":1,\"unit_price\":120,\"tax_id\":null,\"discount_amount\":0,\"created_at\":\"2025-04-14T00:05:07.000000Z\",\"updated_at\":\"2025-04-14T00:05:07.000000Z\",\"deleted_at\":null,\"note\":null,\"vat_amount\":18,\"other_taxes_amount\":0,\"total_price\":138}}', NULL, '2025-04-14 00:05:07', '2025-04-14 00:05:07'),
(273, 'default', 'created', 'App\\Models\\Invoice', 'created', 30, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":30,\"number\":\"C001-INV-000001\",\"customer_name\":\"Zain ul Eman\",\"customer_email\":\"zainuleman786@gmail.com\",\"customer_phone\":null,\"company_id\":1,\"customer_id\":1,\"billing_address_id\":null,\"shipping_address_id\":null,\"subtotal\":240,\"discount\":53,\"total\":238,\"issue_date\":\"2025-04-14T00:08:05.000000Z\",\"due_date\":\"2025-05-14T00:08:05.000000Z\",\"paid_date\":null,\"invoice_status_id\":1,\"currency_id\":null,\"issued_by_user\":1,\"meta\":null,\"created_at\":\"2025-04-14T00:08:05.000000Z\",\"updated_at\":\"2025-04-14T00:08:05.000000Z\",\"deleted_at\":null,\"amount_paid\":238,\"point_of_sale_id\":3,\"vat\":36,\"other_taxes\":15,\"order_id\":8}}', NULL, '2025-04-14 00:08:05', '2025-04-14 00:08:05');
INSERT INTO `activity_logs` (`id`, `log_name`, `description`, `subject_type`, `event`, `subject_id`, `causer_type`, `causer_id`, `properties`, `batch_uuid`, `created_at`, `updated_at`) VALUES
(274, 'default', 'created', 'App\\Models\\InvoiceItem', 'created', 73, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":73,\"invoice_id\":30,\"product_name_en\":\"coke\",\"product_name_ar\":\"coke\",\"product_description_en\":null,\"product_description_ar\":null,\"product_sku\":\"234\",\"product_code\":\"532\",\"quantity\":1,\"unit_price\":100,\"tax_id\":null,\"discount_amount\":50,\"created_at\":\"2025-04-14T00:08:05.000000Z\",\"updated_at\":\"2025-04-14T00:08:05.000000Z\",\"deleted_at\":null,\"note\":\"this is the best\",\"vat_amount\":15,\"other_taxes_amount\":10,\"total_price\":75}}', NULL, '2025-04-14 00:08:05', '2025-04-14 00:08:05'),
(275, 'default', 'created', 'App\\Models\\InvoiceItem', 'created', 74, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":74,\"invoice_id\":30,\"product_name_en\":\"Pepsi\",\"product_name_ar\":\"\\u0628\\u064a\\u0628\\u0633\\u064a\",\"product_description_en\":\"pepsi\",\"product_description_ar\":\"\\u0628\\u064a\\u0628\\u0633\\u064a ... \\u0628\\u064a\\u0628\\u0633\\u064a (\\u0628\\u0627\\u0644\\u0625\\u0646\\u062c\\u0644\\u064a\\u0632\\u064a\\u0629: Pepsi)\\u200f \\u0647\\u0648 \\u0645\\u0634\\u0631\\u0648\\u0628 \\u063a\\u0627\\u0632\\u064a \\u0645\\u0643\\u0631\\u0628\\u0646 \\u062a\\u0635\\u0646\\u0639\\u0647 \\u0634\\u0631\\u0643\\u0629 \\u0628\\u064a\\u0628\\u0633\\u064a\\u0643\\u0648 (\\u062d\\u0627\\u0644\\u064a\\u064b\\u0651\\u0627). ... \\u0648\\u064a\\u0631\\u062c\\u0639 \\u0625\\u0646\\u0634\\u0627\\u0624\\u0647 \\u0648\\u062a\\u0637\\u0648\\u064a\\u0631\\u0647 \\u0641\\u064a \\u0627\\u0644\\u0623\\u0635\\u0644 \\u0625\\u0644\\u0649 \\u0639\\u0627\\u0645 1893 \\u0639\\u0644\\u0649 \\u064a\\u062f \\u0627\\u0644\\u0635\\u064a\\u062f\\u0644\\u0627\\u0646\\u064a \\u0643\\u0627\\u0644\\u064a\\u0628 \\u0628\\u0631\\u0627\\u062f\\u0647\\u0627\\u0645\\u060c ...\\n\",\"product_sku\":\"23423\",\"product_code\":\"1231\",\"quantity\":10,\"unit_price\":2,\"tax_id\":null,\"discount_amount\":3,\"created_at\":\"2025-04-14T00:08:05.000000Z\",\"updated_at\":\"2025-04-14T00:08:05.000000Z\",\"deleted_at\":null,\"note\":null,\"vat_amount\":0.3,\"other_taxes_amount\":0.5,\"total_price\":25}}', NULL, '2025-04-14 00:08:05', '2025-04-14 00:08:05'),
(276, 'default', 'created', 'App\\Models\\InvoiceItem', 'created', 75, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":75,\"invoice_id\":30,\"product_name_en\":\"Red bull\",\"product_name_ar\":\"Red bull\",\"product_description_en\":null,\"product_description_ar\":\"Red bull\",\"product_sku\":null,\"product_code\":null,\"quantity\":1,\"unit_price\":120,\"tax_id\":null,\"discount_amount\":0,\"created_at\":\"2025-04-14T00:08:05.000000Z\",\"updated_at\":\"2025-04-14T00:08:05.000000Z\",\"deleted_at\":null,\"note\":null,\"vat_amount\":18,\"other_taxes_amount\":0,\"total_price\":138}}', NULL, '2025-04-14 00:08:05', '2025-04-14 00:08:05'),
(277, 'default', 'created', 'App\\Models\\Order', 'created', 9, 'App\\Models\\User', 1, '{\"attributes\":{\"number\":\"ORD-202504-GGLVJL\",\"customer_id\":2,\"customer_name\":\"Arsalan  Habib\",\"customer_email\":\"arsalanhabib@gmail.com\",\"customer_phone_number\":\"4326187\",\"user_id\":3,\"company_id\":1,\"order_status_id\":1,\"shipping_fee\":null,\"subtotal\":\"304.00\",\"vat\":\"45.60\",\"other_taxes\":\"30.00\",\"discount\":\"10.00\",\"total\":\"370.00\",\"amount_paid\":\"369.60\",\"payment_method_id\":4,\"currency_id\":1,\"billing_address_id\":null,\"shipping_address_id\":null,\"estimated_delivery_at\":null,\"delivered_at\":null,\"shipped_at\":null,\"meta\":[],\"point_of_sale_id\":3}}', NULL, '2025-04-14 00:10:28', '2025-04-14 00:10:28'),
(278, 'default', 'created', 'App\\Models\\OrderItem', 'created', 25, 'App\\Models\\User', 1, '{\"attributes\":{\"order_id\":9,\"product_name_en\":\"coke\",\"product_name_ar\":\"coke\",\"product_description_en\":null,\"product_description_ar\":null,\"product_sku\":\"234\",\"product_code\":null,\"product_id\":5,\"quantity\":3,\"unit_price\":100,\"tax_id\":null,\"note\":null,\"vat_amount\":\"15.00\",\"other_taxes_amount\":\"10.00\",\"discount_amount\":\"10.00\",\"total_price\":\"365.00\"}}', NULL, '2025-04-14 00:10:28', '2025-04-14 00:10:28'),
(279, 'default', 'created', 'App\\Models\\OrderItem', 'created', 26, 'App\\Models\\User', 1, '{\"attributes\":{\"order_id\":9,\"product_name_en\":\"Pepsi\",\"product_name_ar\":\"\\u0628\\u064a\\u0628\\u0633\\u064a\",\"product_description_en\":\"pepsi\",\"product_description_ar\":\"\\u0628\\u064a\\u0628\\u0633\\u064a ... \\u0628\\u064a\\u0628\\u0633\\u064a (\\u0628\\u0627\\u0644\\u0625\\u0646\\u062c\\u0644\\u064a\\u0632\\u064a\\u0629: Pepsi)\\u200f \\u0647\\u0648 \\u0645\\u0634\\u0631\\u0648\\u0628 \\u063a\\u0627\\u0632\\u064a \\u0645\\u0643\\u0631\\u0628\\u0646 \\u062a\\u0635\\u0646\\u0639\\u0647 \\u0634\\u0631\\u0643\\u0629 \\u0628\\u064a\\u0628\\u0633\\u064a\\u0643\\u0648 (\\u062d\\u0627\\u0644\\u064a\\u064b\\u0651\\u0627). ... \\u0648\\u064a\\u0631\\u062c\\u0639 \\u0625\\u0646\\u0634\\u0627\\u0624\\u0647 \\u0648\\u062a\\u0637\\u0648\\u064a\\u0631\\u0647 \\u0641\\u064a \\u0627\\u0644\\u0623\\u0635\\u0644 \\u0625\\u0644\\u0649 \\u0639\\u0627\\u0645 1893 \\u0639\\u0644\\u0649 \\u064a\\u062f \\u0627\\u0644\\u0635\\u064a\\u062f\\u0644\\u0627\\u0646\\u064a \\u0643\\u0627\\u0644\\u064a\\u0628 \\u0628\\u0631\\u0627\\u062f\\u0647\\u0627\\u0645\\u060c ...\\n\",\"product_sku\":\"23423\",\"product_code\":null,\"product_id\":2,\"quantity\":2,\"unit_price\":2,\"tax_id\":null,\"note\":null,\"vat_amount\":\"0.30\",\"other_taxes_amount\":\"0.00\",\"discount_amount\":\"0.00\",\"total_price\":\"5.00\"}}', NULL, '2025-04-14 00:10:28', '2025-04-14 00:10:28'),
(280, 'default', 'created', 'App\\Models\\Address', 'created', 17, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":17,\"address_type_id\":1,\"addressable_type\":null,\"addressable_id\":null,\"street\":null,\"city\":null,\"state\":null,\"country\":null,\"postal_code\":null,\"country_id\":null,\"contact_person_full_name\":null,\"contact_person_phone\":null,\"latitude\":null,\"longitude\":null,\"details\":null,\"created_at\":\"2025-04-14T00:10:28.000000Z\",\"updated_at\":\"2025-04-14T00:10:28.000000Z\",\"deleted_at\":null}}', NULL, '2025-04-14 00:10:28', '2025-04-14 00:10:28'),
(281, 'default', 'updated', 'App\\Models\\Order', 'updated', 9, 'App\\Models\\User', 1, '{\"attributes\":{\"total\":\"370.00\",\"shipping_address_id\":17},\"old\":{\"total\":\"369.60\",\"shipping_address_id\":null}}', NULL, '2025-04-14 00:10:28', '2025-04-14 00:10:28'),
(282, 'default', 'created', 'App\\Models\\Address', 'created', 18, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":18,\"address_type_id\":2,\"addressable_type\":null,\"addressable_id\":null,\"street\":null,\"city\":null,\"state\":null,\"country\":null,\"postal_code\":null,\"country_id\":null,\"contact_person_full_name\":null,\"contact_person_phone\":null,\"latitude\":null,\"longitude\":null,\"details\":null,\"created_at\":\"2025-04-14T00:10:28.000000Z\",\"updated_at\":\"2025-04-14T00:10:28.000000Z\",\"deleted_at\":null}}', NULL, '2025-04-14 00:10:28', '2025-04-14 00:10:28'),
(283, 'default', 'updated', 'App\\Models\\Order', 'updated', 9, 'App\\Models\\User', 1, '{\"attributes\":{\"total\":\"370.00\",\"billing_address_id\":18},\"old\":{\"total\":\"369.60\",\"billing_address_id\":null}}', NULL, '2025-04-14 00:10:28', '2025-04-14 00:10:28'),
(284, 'default', 'updated', 'App\\Models\\Order', 'updated', 9, 'App\\Models\\User', 1, '{\"attributes\":{\"amount_paid\":\"370.00\"},\"old\":{\"amount_paid\":\"369.60\"}}', NULL, '2025-04-14 00:11:21', '2025-04-14 00:11:21'),
(285, 'default', 'created', 'App\\Models\\Invoice', 'created', 31, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":31,\"number\":\"C001-INV-000002\",\"customer_name\":\"Arsalan  Habib\",\"customer_email\":\"arsalanhabib@gmail.com\",\"customer_phone\":null,\"company_id\":1,\"customer_id\":2,\"billing_address_id\":null,\"shipping_address_id\":null,\"subtotal\":304,\"discount\":10,\"total\":370,\"issue_date\":\"2025-04-14T00:11:36.000000Z\",\"due_date\":\"2025-05-14T00:11:36.000000Z\",\"paid_date\":null,\"invoice_status_id\":1,\"currency_id\":null,\"issued_by_user\":1,\"meta\":null,\"created_at\":\"2025-04-14T00:11:36.000000Z\",\"updated_at\":\"2025-04-14T00:11:36.000000Z\",\"deleted_at\":null,\"amount_paid\":370,\"point_of_sale_id\":3,\"vat\":45.6,\"other_taxes\":30,\"order_id\":9}}', NULL, '2025-04-14 00:11:36', '2025-04-14 00:11:36'),
(286, 'default', 'created', 'App\\Models\\InvoiceItem', 'created', 76, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":76,\"invoice_id\":31,\"product_name_en\":\"coke\",\"product_name_ar\":\"coke\",\"product_description_en\":null,\"product_description_ar\":null,\"product_sku\":\"234\",\"product_code\":\"532\",\"quantity\":3,\"unit_price\":100,\"tax_id\":null,\"discount_amount\":10,\"created_at\":\"2025-04-14T00:11:36.000000Z\",\"updated_at\":\"2025-04-14T00:11:36.000000Z\",\"deleted_at\":null,\"note\":null,\"vat_amount\":15,\"other_taxes_amount\":10,\"total_price\":365}}', NULL, '2025-04-14 00:11:36', '2025-04-14 00:11:36'),
(287, 'default', 'created', 'App\\Models\\InvoiceItem', 'created', 77, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":77,\"invoice_id\":31,\"product_name_en\":\"Pepsi\",\"product_name_ar\":\"\\u0628\\u064a\\u0628\\u0633\\u064a\",\"product_description_en\":\"pepsi\",\"product_description_ar\":\"\\u0628\\u064a\\u0628\\u0633\\u064a ... \\u0628\\u064a\\u0628\\u0633\\u064a (\\u0628\\u0627\\u0644\\u0625\\u0646\\u062c\\u0644\\u064a\\u0632\\u064a\\u0629: Pepsi)\\u200f \\u0647\\u0648 \\u0645\\u0634\\u0631\\u0648\\u0628 \\u063a\\u0627\\u0632\\u064a \\u0645\\u0643\\u0631\\u0628\\u0646 \\u062a\\u0635\\u0646\\u0639\\u0647 \\u0634\\u0631\\u0643\\u0629 \\u0628\\u064a\\u0628\\u0633\\u064a\\u0643\\u0648 (\\u062d\\u0627\\u0644\\u064a\\u064b\\u0651\\u0627). ... \\u0648\\u064a\\u0631\\u062c\\u0639 \\u0625\\u0646\\u0634\\u0627\\u0624\\u0647 \\u0648\\u062a\\u0637\\u0648\\u064a\\u0631\\u0647 \\u0641\\u064a \\u0627\\u0644\\u0623\\u0635\\u0644 \\u0625\\u0644\\u0649 \\u0639\\u0627\\u0645 1893 \\u0639\\u0644\\u0649 \\u064a\\u062f \\u0627\\u0644\\u0635\\u064a\\u062f\\u0644\\u0627\\u0646\\u064a \\u0643\\u0627\\u0644\\u064a\\u0628 \\u0628\\u0631\\u0627\\u062f\\u0647\\u0627\\u0645\\u060c ...\\n\",\"product_sku\":\"23423\",\"product_code\":\"1231\",\"quantity\":2,\"unit_price\":2,\"tax_id\":null,\"discount_amount\":0,\"created_at\":\"2025-04-14T00:11:36.000000Z\",\"updated_at\":\"2025-04-14T00:11:36.000000Z\",\"deleted_at\":null,\"note\":null,\"vat_amount\":0.3,\"other_taxes_amount\":0,\"total_price\":5}}', NULL, '2025-04-14 00:11:36', '2025-04-14 00:11:36'),
(288, 'default', 'created', 'App\\Models\\InvoiceTemplateSetting', 'created', 3, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":3,\"key_name\":\"logo\",\"company_id\":1,\"value_en\":\"<p><figure data-trix-attachment=\\\"{&quot;contentType&quot;:&quot;image\\/png&quot;,&quot;filename&quot;:&quot;estilo_logo.png&quot;,&quot;filesize&quot;:20787,&quot;height&quot;:308,&quot;href&quot;:&quot;http:\\/\\/localhost\\/storage\\/3a0RBcROFOFOt5o7atgZvflBXjpyMn1QoARfmrhN.png&quot;,&quot;url&quot;:&quot;http:\\/\\/localhost\\/storage\\/3a0RBcROFOFOt5o7atgZvflBXjpyMn1QoARfmrhN.png&quot;,&quot;width&quot;:631}\\\" data-trix-content-type=\\\"image\\/png\\\" data-trix-attributes=\\\"{&quot;presentation&quot;:&quot;gallery&quot;}\\\" class=\\\"attachment attachment--preview attachment--png\\\"><a href=\\\"http:\\/\\/localhost\\/storage\\/3a0RBcROFOFOt5o7atgZvflBXjpyMn1QoARfmrhN.png\\\"><img src=\\\"http:\\/\\/localhost\\/storage\\/3a0RBcROFOFOt5o7atgZvflBXjpyMn1QoARfmrhN.png\\\" width=\\\"631\\\" height=\\\"308\\\"><figcaption class=\\\"attachment__caption\\\"><span class=\\\"attachment__name\\\">estilo_logo.png<\\/span> <span class=\\\"attachment__size\\\">20.3 KB<\\/span><\\/figcaption><\\/a><\\/figure><\\/p>\",\"value_ar\":\"<p>&nbsp;<figure data-trix-attachment=\\\"{&quot;contentType&quot;:&quot;image\\/png&quot;,&quot;filename&quot;:&quot;estilo_logo.png&quot;,&quot;filesize&quot;:20787,&quot;height&quot;:308,&quot;href&quot;:&quot;http:\\/\\/localhost\\/storage\\/jxDwOW9kb3dAEuBk63XLkk09Lqi4OZM40RLA6Est.png&quot;,&quot;url&quot;:&quot;http:\\/\\/localhost\\/storage\\/jxDwOW9kb3dAEuBk63XLkk09Lqi4OZM40RLA6Est.png&quot;,&quot;width&quot;:631}\\\" data-trix-content-type=\\\"image\\/png\\\" data-trix-attributes=\\\"{&quot;presentation&quot;:&quot;gallery&quot;}\\\" class=\\\"attachment attachment--preview attachment--png\\\"><a href=\\\"http:\\/\\/localhost\\/storage\\/jxDwOW9kb3dAEuBk63XLkk09Lqi4OZM40RLA6Est.png\\\"><img src=\\\"http:\\/\\/localhost\\/storage\\/jxDwOW9kb3dAEuBk63XLkk09Lqi4OZM40RLA6Est.png\\\" width=\\\"631\\\" height=\\\"308\\\"><figcaption class=\\\"attachment__caption\\\"><span class=\\\"attachment__name\\\">estilo_logo.png<\\/span> <span class=\\\"attachment__size\\\">20.3 KB<\\/span><\\/figcaption><\\/a><\\/figure>&nbsp;<\\/p>\",\"created_at\":\"2025-04-14T00:16:06.000000Z\",\"updated_at\":\"2025-04-14T00:16:06.000000Z\"}}', NULL, '2025-04-14 00:16:06', '2025-04-14 00:16:06'),
(289, 'default', 'updated', 'App\\Models\\InvoiceTemplateSetting', 'updated', 3, 'App\\Models\\User', 1, '{\"attributes\":{\"value_en\":\"<p><figure data-trix-attachment=\\\"{&quot;contentType&quot;:&quot;image\\/png&quot;,&quot;filename&quot;:&quot;estilo_logo.png&quot;,&quot;filesize&quot;:20787,&quot;height&quot;:308,&quot;href&quot;:&quot;http:\\/\\/127.0.0.1:8000\\/storage\\/k7XeDq2VAOBc0rhSGZxSWnQCy6kozGxig1K2CQWL.png&quot;,&quot;url&quot;:&quot;http:\\/\\/127.0.0.1:8000\\/storage\\/k7XeDq2VAOBc0rhSGZxSWnQCy6kozGxig1K2CQWL.png&quot;,&quot;width&quot;:631}\\\" data-trix-content-type=\\\"image\\/png\\\" data-trix-attributes=\\\"{&quot;presentation&quot;:&quot;gallery&quot;}\\\" class=\\\"attachment attachment--preview attachment--png\\\"><a href=\\\"http:\\/\\/127.0.0.1:8000\\/storage\\/k7XeDq2VAOBc0rhSGZxSWnQCy6kozGxig1K2CQWL.png\\\"><img src=\\\"http:\\/\\/127.0.0.1:8000\\/storage\\/k7XeDq2VAOBc0rhSGZxSWnQCy6kozGxig1K2CQWL.png\\\" width=\\\"631\\\" height=\\\"308\\\"><figcaption class=\\\"attachment__caption\\\"><span class=\\\"attachment__name\\\">estilo_logo.png<\\/span> <span class=\\\"attachment__size\\\">20.3 KB<\\/span><\\/figcaption><\\/a><\\/figure><\\/p>\",\"value_ar\":\"<p>&nbsp;<figure data-trix-attachment=\\\"{&quot;contentType&quot;:&quot;image\\/png&quot;,&quot;filename&quot;:&quot;estilo_logo.png&quot;,&quot;filesize&quot;:20787,&quot;height&quot;:308,&quot;href&quot;:&quot;http:\\/\\/127.0.0.1:8000\\/storage\\/2gjQurTcFxCnSCuzCegc3rkz7RgW6e4cYpAnngKe.png&quot;,&quot;url&quot;:&quot;http:\\/\\/127.0.0.1:8000\\/storage\\/2gjQurTcFxCnSCuzCegc3rkz7RgW6e4cYpAnngKe.png&quot;,&quot;width&quot;:631}\\\" data-trix-content-type=\\\"image\\/png\\\" data-trix-attributes=\\\"{&quot;presentation&quot;:&quot;gallery&quot;}\\\" class=\\\"attachment attachment--preview attachment--png\\\"><a href=\\\"http:\\/\\/127.0.0.1:8000\\/storage\\/2gjQurTcFxCnSCuzCegc3rkz7RgW6e4cYpAnngKe.png\\\"><img src=\\\"http:\\/\\/127.0.0.1:8000\\/storage\\/2gjQurTcFxCnSCuzCegc3rkz7RgW6e4cYpAnngKe.png\\\" width=\\\"631\\\" height=\\\"308\\\"><figcaption class=\\\"attachment__caption\\\"><span class=\\\"attachment__name\\\">estilo_logo.png<\\/span> <span class=\\\"attachment__size\\\">20.3 KB<\\/span><\\/figcaption><\\/a><\\/figure>&nbsp;<\\/p>\",\"updated_at\":\"2025-04-14T00:23:43.000000Z\"},\"old\":{\"value_en\":\"<p><figure data-trix-attachment=\\\"{&quot;contentType&quot;:&quot;image\\/png&quot;,&quot;filename&quot;:&quot;estilo_logo.png&quot;,&quot;filesize&quot;:20787,&quot;height&quot;:308,&quot;href&quot;:&quot;http:\\/\\/localhost\\/storage\\/3a0RBcROFOFOt5o7atgZvflBXjpyMn1QoARfmrhN.png&quot;,&quot;url&quot;:&quot;http:\\/\\/localhost\\/storage\\/3a0RBcROFOFOt5o7atgZvflBXjpyMn1QoARfmrhN.png&quot;,&quot;width&quot;:631}\\\" data-trix-content-type=\\\"image\\/png\\\" data-trix-attributes=\\\"{&quot;presentation&quot;:&quot;gallery&quot;}\\\" class=\\\"attachment attachment--preview attachment--png\\\"><a href=\\\"http:\\/\\/localhost\\/storage\\/3a0RBcROFOFOt5o7atgZvflBXjpyMn1QoARfmrhN.png\\\"><img src=\\\"http:\\/\\/localhost\\/storage\\/3a0RBcROFOFOt5o7atgZvflBXjpyMn1QoARfmrhN.png\\\" width=\\\"631\\\" height=\\\"308\\\"><figcaption class=\\\"attachment__caption\\\"><span class=\\\"attachment__name\\\">estilo_logo.png<\\/span> <span class=\\\"attachment__size\\\">20.3 KB<\\/span><\\/figcaption><\\/a><\\/figure><\\/p>\",\"value_ar\":\"<p>&nbsp;<figure data-trix-attachment=\\\"{&quot;contentType&quot;:&quot;image\\/png&quot;,&quot;filename&quot;:&quot;estilo_logo.png&quot;,&quot;filesize&quot;:20787,&quot;height&quot;:308,&quot;href&quot;:&quot;http:\\/\\/localhost\\/storage\\/jxDwOW9kb3dAEuBk63XLkk09Lqi4OZM40RLA6Est.png&quot;,&quot;url&quot;:&quot;http:\\/\\/localhost\\/storage\\/jxDwOW9kb3dAEuBk63XLkk09Lqi4OZM40RLA6Est.png&quot;,&quot;width&quot;:631}\\\" data-trix-content-type=\\\"image\\/png\\\" data-trix-attributes=\\\"{&quot;presentation&quot;:&quot;gallery&quot;}\\\" class=\\\"attachment attachment--preview attachment--png\\\"><a href=\\\"http:\\/\\/localhost\\/storage\\/jxDwOW9kb3dAEuBk63XLkk09Lqi4OZM40RLA6Est.png\\\"><img src=\\\"http:\\/\\/localhost\\/storage\\/jxDwOW9kb3dAEuBk63XLkk09Lqi4OZM40RLA6Est.png\\\" width=\\\"631\\\" height=\\\"308\\\"><figcaption class=\\\"attachment__caption\\\"><span class=\\\"attachment__name\\\">estilo_logo.png<\\/span> <span class=\\\"attachment__size\\\">20.3 KB<\\/span><\\/figcaption><\\/a><\\/figure>&nbsp;<\\/p>\",\"updated_at\":\"2025-04-14T00:16:06.000000Z\"}}', NULL, '2025-04-14 00:23:43', '2025-04-14 00:23:43'),
(290, 'default', 'created', 'App\\Models\\Company', 'created', 2, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":2,\"legal_name\":\"Adeel\",\"tax_number\":\"32142314\",\"website\":null,\"email\":\"adeel@gmao.com\",\"phone_number\":\"2423423423423\",\"logo\":\"company-logos\\/01JTCJQRRCW33Y0RXK5MWBA7EY.jpeg\",\"is_active\":true,\"meta\":null,\"created_at\":\"2025-05-04T02:41:52.000000Z\",\"updated_at\":\"2025-05-04T02:41:52.000000Z\",\"deleted_at\":null}}', NULL, '2025-05-04 04:41:52', '2025-05-04 04:41:52'),
(291, 'default', 'created', 'App\\Models\\PointOfSale', 'created', 6, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":6,\"name_en\":\"Chungi No 6\",\"name_ar\":\"Chungi No 6\",\"description_en\":null,\"description_ar\":null,\"company_id\":1,\"is_active\":true,\"meta\":[],\"created_at\":\"2025-05-04T05:17:19.000000Z\",\"updated_at\":\"2025-05-04T05:17:19.000000Z\",\"deleted_at\":null}}', NULL, '2025-05-04 07:17:19', '2025-05-04 07:17:19'),
(292, 'default', 'updated', 'App\\Models\\PointOfSale', 'updated', 6, 'App\\Models\\User', 1, '{\"attributes\":{\"company_id\":2,\"updated_at\":\"2025-05-04T05:19:12.000000Z\"},\"old\":{\"company_id\":1,\"updated_at\":\"2025-05-04T05:17:19.000000Z\"}}', NULL, '2025-05-04 07:19:12', '2025-05-04 07:19:12'),
(293, 'default', 'created', 'App\\Models\\User', 'created', 4, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":4,\"first_name\":\"Adeel\",\"last_name\":\"Khan\",\"email\":\"adeel@gamil.com\",\"phone_number\":null,\"email_verified_at\":null,\"password\":\"$2y$10$QqP6zFidvA0s35r1weUSHOHhvLuqu1kKzrMvtTghY22My0rAxqSXm\",\"remember_token\":null,\"created_at\":\"2025-05-04T05:20:26.000000Z\",\"updated_at\":\"2025-05-04T05:20:26.000000Z\",\"company_id\":2,\"point_of_sale_id\":6}}', NULL, '2025-05-04 07:20:26', '2025-05-04 07:20:26'),
(294, 'default', 'created', 'App\\Models\\Customer', 'created', 9, 'App\\Models\\User', 4, '{\"attributes\":{\"id\":9,\"first_name\":\"Guest\",\"last_name\":\"Guest\",\"email\":\"guest@gmail.com\",\"phone_number\":\"12345678\",\"company_id\":2,\"is_active\":true,\"meta\":null,\"created_at\":\"2025-05-04T05:22:32.000000Z\",\"updated_at\":\"2025-05-04T05:22:32.000000Z\",\"deleted_at\":null,\"vat_number\":null,\"address\":null,\"point_of_sale_id\":6}}', NULL, '2025-05-04 07:22:32', '2025-05-04 07:22:32'),
(295, 'default', 'created', 'App\\Models\\ProductCategory', 'created', 3, 'App\\Models\\User', 4, '{\"attributes\":{\"id\":3,\"company_id\":null,\"name_en\":\" Cases\",\"name_ar\":\" Cases\",\"description_en\":null,\"description_ar\":null,\"slug\":\"cases\",\"parent_id\":null,\"is_active\":1,\"created_at\":\"2025-05-04T05:36:20.000000Z\",\"updated_at\":\"2025-05-04T05:36:20.000000Z\",\"deleted_at\":null}}', NULL, '2025-05-04 07:36:20', '2025-05-04 07:36:20'),
(296, 'default', 'created', 'App\\Models\\ProductCategory', 'created', 4, 'App\\Models\\User', 4, '{\"attributes\":{\"id\":4,\"company_id\":null,\"name_en\":\"Chargers\",\"name_ar\":\"Chargers\",\"description_en\":null,\"description_ar\":null,\"slug\":\"chargers\",\"parent_id\":null,\"is_active\":1,\"created_at\":\"2025-05-04T05:36:35.000000Z\",\"updated_at\":\"2025-05-04T05:36:35.000000Z\",\"deleted_at\":null}}', NULL, '2025-05-04 07:36:35', '2025-05-04 07:36:35'),
(297, 'default', 'deleted', 'App\\Models\\ProductCategory', 'deleted', 4, 'App\\Models\\User', 4, '{\"old\":{\"id\":4,\"company_id\":null,\"name_en\":\"Chargers\",\"name_ar\":\"Chargers\",\"description_en\":null,\"description_ar\":null,\"slug\":\"chargers\",\"parent_id\":null,\"is_active\":1,\"created_at\":\"2025-05-04T05:36:35.000000Z\",\"updated_at\":\"2025-05-04T05:38:36.000000Z\",\"deleted_at\":\"2025-05-04T05:38:36.000000Z\"}}', NULL, '2025-05-04 07:38:36', '2025-05-04 07:38:36'),
(298, 'default', 'deleted', 'App\\Models\\ProductCategory', 'deleted', 3, 'App\\Models\\User', 4, '{\"old\":{\"id\":3,\"company_id\":null,\"name_en\":\" Cases\",\"name_ar\":\" Cases\",\"description_en\":null,\"description_ar\":null,\"slug\":\"cases\",\"parent_id\":null,\"is_active\":1,\"created_at\":\"2025-05-04T05:36:20.000000Z\",\"updated_at\":\"2025-05-04T05:38:36.000000Z\",\"deleted_at\":\"2025-05-04T05:38:36.000000Z\"}}', NULL, '2025-05-04 07:38:36', '2025-05-04 07:38:36'),
(299, 'default', 'created', 'App\\Models\\ProductCategory', 'created', 5, 'App\\Models\\User', 4, '{\"attributes\":{\"id\":5,\"company_id\":2,\"point_of_sale_id\":6,\"name_en\":\"Chargers\",\"name_ar\":\"Chargers\",\"description_en\":null,\"description_ar\":null,\"slug\":\"chargers\",\"parent_id\":null,\"is_active\":1,\"created_at\":\"2025-05-04T05:40:19.000000Z\",\"updated_at\":\"2025-05-04T05:40:19.000000Z\",\"deleted_at\":null}}', NULL, '2025-05-04 07:40:19', '2025-05-04 07:40:19'),
(300, 'default', 'created', 'App\\Models\\ProductCategory', 'created', 6, 'App\\Models\\User', 4, '{\"attributes\":{\"id\":6,\"company_id\":2,\"point_of_sale_id\":6,\"name_en\":\" Cases\",\"name_ar\":\" Cases\",\"description_en\":null,\"description_ar\":null,\"slug\":\"cases\",\"parent_id\":null,\"is_active\":1,\"created_at\":\"2025-05-04T05:41:02.000000Z\",\"updated_at\":\"2025-05-04T05:41:02.000000Z\",\"deleted_at\":null}}', NULL, '2025-05-04 07:41:02', '2025-05-04 07:41:02'),
(301, 'default', 'created', 'App\\Models\\ProductCategory', 'created', 7, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":7,\"company_id\":2,\"point_of_sale_id\":6,\"name_en\":\"Cables\",\"name_ar\":\"Cables\",\"description_en\":null,\"description_ar\":null,\"slug\":\"cables\",\"parent_id\":null,\"is_active\":1,\"created_at\":\"2025-05-04T05:58:15.000000Z\",\"updated_at\":\"2025-05-04T05:58:15.000000Z\",\"deleted_at\":null}}', NULL, '2025-05-04 07:58:15', '2025-05-04 07:58:15'),
(302, 'default', 'created', 'App\\Models\\Currency', 'created', 5, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":5,\"name\":\"Pakistani Rupees\",\"code\":\"PKR\",\"symbol\":\"Rs\",\"created_at\":\"2025-05-04T06:38:26.000000Z\",\"updated_at\":\"2025-05-04T06:38:26.000000Z\",\"deleted_at\":null}}', NULL, '2025-05-04 08:38:26', '2025-05-04 08:38:26'),
(303, 'default', 'created', 'App\\Models\\Product', 'created', 12, 'App\\Models\\User', 4, '{\"attributes\":{\"id\":12,\"company_id\":2,\"name_en\":\"Iphone cable\",\"name_ar\":\"Iphone cable\",\"description_en\":null,\"description_ar\":null,\"slug\":\"iphone-cable\",\"sku\":null,\"code\":null,\"price\":15,\"sale_price\":15,\"currency_id\":5,\"product_category_id\":7,\"point_of_sale_id\":6,\"image_url\":\"products\\/shopping.webp\",\"is_active\":true,\"created_at\":\"2025-05-04T06:45:54.000000Z\",\"updated_at\":\"2025-05-04T06:45:54.000000Z\",\"deleted_at\":null}}', NULL, '2025-05-04 08:45:54', '2025-05-04 08:45:54'),
(304, 'default', 'created', 'App\\Models\\Product', 'created', 13, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":13,\"company_id\":2,\"name_en\":\"Iphone Charger\",\"name_ar\":\"Iphone Charger\",\"description_en\":null,\"description_ar\":null,\"slug\":\"iphone-charger\",\"sku\":null,\"code\":null,\"price\":500,\"sale_price\":500,\"currency_id\":5,\"product_category_id\":5,\"point_of_sale_id\":6,\"image_url\":\"products\\/61CZrgz-DsL._AC_UF894,1000_QL80_.jpg\",\"is_active\":true,\"created_at\":\"2025-05-04T06:50:40.000000Z\",\"updated_at\":\"2025-05-04T06:50:40.000000Z\",\"deleted_at\":null}}', NULL, '2025-05-04 08:50:40', '2025-05-04 08:50:40'),
(305, 'default', 'updated', 'App\\Models\\Product', 'updated', 12, 'App\\Models\\User', 4, '{\"attributes\":{\"quantity\":15,\"updated_at\":\"2025-05-04T07:29:21.000000Z\"},\"old\":{\"quantity\":0,\"updated_at\":\"2025-05-04T06:45:54.000000Z\"}}', NULL, '2025-05-04 09:29:21', '2025-05-04 09:29:21'),
(306, 'default', 'created', 'App\\Models\\Order', 'created', 10, 'App\\Models\\User', 4, '{\"attributes\":{\"number\":\"ORD-202505-XE5S0K\",\"customer_id\":9,\"customer_name\":null,\"customer_email\":null,\"customer_phone_number\":null,\"user_id\":null,\"company_id\":2,\"order_status_id\":1,\"shipping_fee\":null,\"subtotal\":\"400.00\",\"vat\":\"0.00\",\"other_taxes\":\"0.00\",\"discount\":\"0.00\",\"total\":\"400.00\",\"amount_paid\":\"0.00\",\"payment_method_id\":4,\"currency_id\":1,\"billing_address_id\":null,\"shipping_address_id\":null,\"estimated_delivery_at\":null,\"delivered_at\":null,\"shipped_at\":null,\"meta\":[],\"point_of_sale_id\":6}}', NULL, '2025-05-04 09:33:38', '2025-05-04 09:33:38'),
(307, 'default', 'created', 'App\\Models\\OrderItem', 'created', 27, 'App\\Models\\User', 4, '{\"attributes\":{\"order_id\":10,\"product_name_en\":\"Iphone cable\",\"product_name_ar\":\"Iphone cable\",\"product_description_en\":null,\"product_description_ar\":null,\"product_sku\":null,\"product_code\":null,\"product_id\":12,\"quantity\":2,\"unit_price\":200,\"tax_id\":null,\"note\":null,\"vat_amount\":\"0.00\",\"other_taxes_amount\":\"0.00\",\"discount_amount\":\"0.00\",\"total_price\":\"400.00\"}}', NULL, '2025-05-04 09:33:38', '2025-05-04 09:33:38'),
(308, 'default', 'created', 'App\\Models\\Address', 'created', 19, 'App\\Models\\User', 4, '{\"attributes\":{\"id\":19,\"address_type_id\":1,\"addressable_type\":null,\"addressable_id\":null,\"street\":null,\"city\":null,\"state\":null,\"country\":null,\"postal_code\":null,\"country_id\":null,\"contact_person_full_name\":null,\"contact_person_phone\":null,\"latitude\":null,\"longitude\":null,\"details\":null,\"created_at\":\"2025-05-04T07:33:38.000000Z\",\"updated_at\":\"2025-05-04T07:33:38.000000Z\",\"deleted_at\":null}}', NULL, '2025-05-04 09:33:38', '2025-05-04 09:33:38'),
(309, 'default', 'updated', 'App\\Models\\Order', 'updated', 10, 'App\\Models\\User', 4, '{\"attributes\":{\"shipping_address_id\":19},\"old\":{\"shipping_address_id\":null}}', NULL, '2025-05-04 09:33:38', '2025-05-04 09:33:38'),
(310, 'default', 'created', 'App\\Models\\Address', 'created', 20, 'App\\Models\\User', 4, '{\"attributes\":{\"id\":20,\"address_type_id\":2,\"addressable_type\":null,\"addressable_id\":null,\"street\":null,\"city\":null,\"state\":null,\"country\":null,\"postal_code\":null,\"country_id\":null,\"contact_person_full_name\":null,\"contact_person_phone\":null,\"latitude\":null,\"longitude\":null,\"details\":null,\"created_at\":\"2025-05-04T07:33:38.000000Z\",\"updated_at\":\"2025-05-04T07:33:38.000000Z\",\"deleted_at\":null}}', NULL, '2025-05-04 09:33:38', '2025-05-04 09:33:38'),
(311, 'default', 'updated', 'App\\Models\\Order', 'updated', 10, 'App\\Models\\User', 4, '{\"attributes\":{\"billing_address_id\":20},\"old\":{\"billing_address_id\":null}}', NULL, '2025-05-04 09:33:38', '2025-05-04 09:33:38'),
(312, 'default', 'created', 'App\\Models\\Order', 'created', 11, 'App\\Models\\User', 4, '{\"attributes\":{\"number\":\"ORD-202505-BA6DAF\",\"customer_id\":9,\"customer_name\":null,\"customer_email\":null,\"customer_phone_number\":null,\"user_id\":null,\"company_id\":2,\"order_status_id\":1,\"shipping_fee\":null,\"subtotal\":\"30.00\",\"vat\":\"0.00\",\"other_taxes\":\"0.00\",\"discount\":\"0.00\",\"total\":\"30.00\",\"amount_paid\":\"0.00\",\"payment_method_id\":4,\"currency_id\":5,\"billing_address_id\":null,\"shipping_address_id\":null,\"estimated_delivery_at\":null,\"delivered_at\":null,\"shipped_at\":null,\"meta\":[],\"point_of_sale_id\":6}}', NULL, '2025-05-04 09:54:11', '2025-05-04 09:54:11'),
(313, 'default', 'created', 'App\\Models\\OrderItem', 'created', 28, 'App\\Models\\User', 4, '{\"attributes\":{\"order_id\":11,\"product_name_en\":\"Iphone cable\",\"product_name_ar\":\"Iphone cable\",\"product_description_en\":null,\"product_description_ar\":null,\"product_sku\":null,\"product_code\":null,\"product_id\":12,\"quantity\":2,\"unit_price\":15,\"tax_id\":null,\"note\":null,\"vat_amount\":\"0.00\",\"other_taxes_amount\":\"0.00\",\"discount_amount\":\"0.00\",\"total_price\":\"30.00\"}}', NULL, '2025-05-04 09:54:11', '2025-05-04 09:54:11'),
(314, 'default', 'created', 'App\\Models\\Address', 'created', 21, 'App\\Models\\User', 4, '{\"attributes\":{\"id\":21,\"address_type_id\":1,\"addressable_type\":null,\"addressable_id\":null,\"street\":null,\"city\":null,\"state\":null,\"country\":null,\"postal_code\":null,\"country_id\":null,\"contact_person_full_name\":null,\"contact_person_phone\":null,\"latitude\":null,\"longitude\":null,\"details\":null,\"created_at\":\"2025-05-04T07:54:11.000000Z\",\"updated_at\":\"2025-05-04T07:54:11.000000Z\",\"deleted_at\":null}}', NULL, '2025-05-04 09:54:11', '2025-05-04 09:54:11'),
(315, 'default', 'updated', 'App\\Models\\Order', 'updated', 11, 'App\\Models\\User', 4, '{\"attributes\":{\"shipping_address_id\":21},\"old\":{\"shipping_address_id\":null}}', NULL, '2025-05-04 09:54:11', '2025-05-04 09:54:11'),
(316, 'default', 'created', 'App\\Models\\Address', 'created', 22, 'App\\Models\\User', 4, '{\"attributes\":{\"id\":22,\"address_type_id\":2,\"addressable_type\":null,\"addressable_id\":null,\"street\":null,\"city\":null,\"state\":null,\"country\":null,\"postal_code\":null,\"country_id\":null,\"contact_person_full_name\":null,\"contact_person_phone\":null,\"latitude\":null,\"longitude\":null,\"details\":null,\"created_at\":\"2025-05-04T07:54:11.000000Z\",\"updated_at\":\"2025-05-04T07:54:11.000000Z\",\"deleted_at\":null}}', NULL, '2025-05-04 09:54:11', '2025-05-04 09:54:11'),
(317, 'default', 'updated', 'App\\Models\\Order', 'updated', 11, 'App\\Models\\User', 4, '{\"attributes\":{\"billing_address_id\":22},\"old\":{\"billing_address_id\":null}}', NULL, '2025-05-04 09:54:11', '2025-05-04 09:54:11'),
(318, 'default', 'created', 'App\\Models\\Order', 'created', 12, 'App\\Models\\User', 4, '{\"attributes\":{\"number\":\"ORD-202505-FPEK0G\",\"customer_id\":9,\"customer_name\":null,\"customer_email\":null,\"customer_phone_number\":null,\"user_id\":null,\"company_id\":2,\"order_status_id\":1,\"shipping_fee\":null,\"subtotal\":\"15.00\",\"vat\":\"0.00\",\"other_taxes\":\"0.00\",\"discount\":\"0.00\",\"total\":\"15.00\",\"amount_paid\":\"0.00\",\"payment_method_id\":4,\"currency_id\":5,\"billing_address_id\":null,\"shipping_address_id\":null,\"estimated_delivery_at\":null,\"delivered_at\":null,\"shipped_at\":null,\"meta\":[],\"point_of_sale_id\":6}}', NULL, '2025-05-04 09:56:35', '2025-05-04 09:56:35'),
(319, 'default', 'created', 'App\\Models\\OrderItem', 'created', 29, 'App\\Models\\User', 4, '{\"attributes\":{\"order_id\":12,\"product_name_en\":\"Iphone cable\",\"product_name_ar\":\"Iphone cable\",\"product_description_en\":null,\"product_description_ar\":null,\"product_sku\":null,\"product_code\":null,\"product_id\":12,\"quantity\":1,\"unit_price\":15,\"tax_id\":null,\"note\":null,\"vat_amount\":\"0.00\",\"other_taxes_amount\":\"0.00\",\"discount_amount\":\"0.00\",\"total_price\":\"15.00\"}}', NULL, '2025-05-04 09:56:35', '2025-05-04 09:56:35'),
(320, 'default', 'created', 'App\\Models\\Address', 'created', 23, 'App\\Models\\User', 4, '{\"attributes\":{\"id\":23,\"address_type_id\":1,\"addressable_type\":null,\"addressable_id\":null,\"street\":null,\"city\":null,\"state\":null,\"country\":null,\"postal_code\":null,\"country_id\":null,\"contact_person_full_name\":null,\"contact_person_phone\":null,\"latitude\":null,\"longitude\":null,\"details\":null,\"created_at\":\"2025-05-04T07:56:35.000000Z\",\"updated_at\":\"2025-05-04T07:56:35.000000Z\",\"deleted_at\":null}}', NULL, '2025-05-04 09:56:35', '2025-05-04 09:56:35'),
(321, 'default', 'updated', 'App\\Models\\Order', 'updated', 12, 'App\\Models\\User', 4, '{\"attributes\":{\"shipping_address_id\":23},\"old\":{\"shipping_address_id\":null}}', NULL, '2025-05-04 09:56:35', '2025-05-04 09:56:35'),
(322, 'default', 'created', 'App\\Models\\Address', 'created', 24, 'App\\Models\\User', 4, '{\"attributes\":{\"id\":24,\"address_type_id\":2,\"addressable_type\":null,\"addressable_id\":null,\"street\":null,\"city\":null,\"state\":null,\"country\":null,\"postal_code\":null,\"country_id\":null,\"contact_person_full_name\":null,\"contact_person_phone\":null,\"latitude\":null,\"longitude\":null,\"details\":null,\"created_at\":\"2025-05-04T07:56:35.000000Z\",\"updated_at\":\"2025-05-04T07:56:35.000000Z\",\"deleted_at\":null}}', NULL, '2025-05-04 09:56:35', '2025-05-04 09:56:35'),
(323, 'default', 'updated', 'App\\Models\\Order', 'updated', 12, 'App\\Models\\User', 4, '{\"attributes\":{\"billing_address_id\":24},\"old\":{\"billing_address_id\":null}}', NULL, '2025-05-04 09:56:35', '2025-05-04 09:56:35'),
(324, 'default', 'updated', 'App\\Models\\Product', 'updated', 12, 'App\\Models\\User', 4, '{\"attributes\":{\"quantity\":14,\"updated_at\":\"2025-05-04T07:56:36.000000Z\"},\"old\":{\"quantity\":15,\"updated_at\":\"2025-05-04T07:29:21.000000Z\"}}', NULL, '2025-05-04 09:56:36', '2025-05-04 09:56:36'),
(325, 'default', 'updated', 'App\\Models\\Product', 'updated', 13, 'App\\Models\\User', 4, '{\"attributes\":{\"quantity\":10,\"updated_at\":\"2025-05-04T08:08:49.000000Z\"},\"old\":{\"quantity\":0,\"updated_at\":\"2025-05-04T06:50:40.000000Z\"}}', NULL, '2025-05-04 10:08:49', '2025-05-04 10:08:49'),
(326, 'default', 'created', 'App\\Models\\Order', 'created', 13, 'App\\Models\\User', 4, '{\"attributes\":{\"number\":\"ORD-202505-TJJMQD\",\"customer_id\":9,\"customer_name\":null,\"customer_email\":null,\"customer_phone_number\":null,\"user_id\":null,\"company_id\":2,\"order_status_id\":1,\"shipping_fee\":null,\"subtotal\":\"630.00\",\"vat\":\"0.00\",\"other_taxes\":\"0.00\",\"discount\":\"0.00\",\"total\":\"630.00\",\"amount_paid\":\"630.00\",\"payment_method_id\":4,\"currency_id\":5,\"billing_address_id\":null,\"shipping_address_id\":null,\"estimated_delivery_at\":null,\"delivered_at\":null,\"shipped_at\":null,\"meta\":[],\"point_of_sale_id\":6}}', NULL, '2025-05-04 10:09:20', '2025-05-04 10:09:20'),
(327, 'default', 'created', 'App\\Models\\OrderItem', 'created', 30, 'App\\Models\\User', 4, '{\"attributes\":{\"order_id\":13,\"product_name_en\":\"Iphone cable\",\"product_name_ar\":\"Iphone cable\",\"product_description_en\":null,\"product_description_ar\":null,\"product_sku\":null,\"product_code\":null,\"product_id\":12,\"quantity\":2,\"unit_price\":15,\"tax_id\":null,\"note\":null,\"vat_amount\":\"0.00\",\"other_taxes_amount\":\"0.00\",\"discount_amount\":\"0.00\",\"total_price\":\"30.00\"}}', NULL, '2025-05-04 10:09:20', '2025-05-04 10:09:20'),
(328, 'default', 'created', 'App\\Models\\OrderItem', 'created', 31, 'App\\Models\\User', 4, '{\"attributes\":{\"order_id\":13,\"product_name_en\":\"Iphone Charger\",\"product_name_ar\":\"Iphone Charger\",\"product_description_en\":null,\"product_description_ar\":null,\"product_sku\":null,\"product_code\":null,\"product_id\":13,\"quantity\":2,\"unit_price\":300,\"tax_id\":null,\"note\":null,\"vat_amount\":\"0.00\",\"other_taxes_amount\":\"0.00\",\"discount_amount\":\"0.00\",\"total_price\":\"600.00\"}}', NULL, '2025-05-04 10:09:20', '2025-05-04 10:09:20'),
(329, 'default', 'created', 'App\\Models\\Address', 'created', 25, 'App\\Models\\User', 4, '{\"attributes\":{\"id\":25,\"address_type_id\":1,\"addressable_type\":null,\"addressable_id\":null,\"street\":null,\"city\":null,\"state\":null,\"country\":null,\"postal_code\":null,\"country_id\":null,\"contact_person_full_name\":null,\"contact_person_phone\":null,\"latitude\":null,\"longitude\":null,\"details\":null,\"created_at\":\"2025-05-04T08:09:20.000000Z\",\"updated_at\":\"2025-05-04T08:09:20.000000Z\",\"deleted_at\":null}}', NULL, '2025-05-04 10:09:20', '2025-05-04 10:09:20'),
(330, 'default', 'updated', 'App\\Models\\Order', 'updated', 13, 'App\\Models\\User', 4, '{\"attributes\":{\"shipping_address_id\":25},\"old\":{\"shipping_address_id\":null}}', NULL, '2025-05-04 10:09:20', '2025-05-04 10:09:20'),
(331, 'default', 'created', 'App\\Models\\Address', 'created', 26, 'App\\Models\\User', 4, '{\"attributes\":{\"id\":26,\"address_type_id\":2,\"addressable_type\":null,\"addressable_id\":null,\"street\":null,\"city\":null,\"state\":null,\"country\":null,\"postal_code\":null,\"country_id\":null,\"contact_person_full_name\":null,\"contact_person_phone\":null,\"latitude\":null,\"longitude\":null,\"details\":null,\"created_at\":\"2025-05-04T08:09:20.000000Z\",\"updated_at\":\"2025-05-04T08:09:20.000000Z\",\"deleted_at\":null}}', NULL, '2025-05-04 10:09:20', '2025-05-04 10:09:20'),
(332, 'default', 'updated', 'App\\Models\\Order', 'updated', 13, 'App\\Models\\User', 4, '{\"attributes\":{\"billing_address_id\":26},\"old\":{\"billing_address_id\":null}}', NULL, '2025-05-04 10:09:20', '2025-05-04 10:09:20'),
(333, 'default', 'updated', 'App\\Models\\Product', 'updated', 12, 'App\\Models\\User', 4, '{\"attributes\":{\"quantity\":12,\"updated_at\":\"2025-05-04T08:09:20.000000Z\"},\"old\":{\"quantity\":14,\"updated_at\":\"2025-05-04T07:56:36.000000Z\"}}', NULL, '2025-05-04 10:09:20', '2025-05-04 10:09:20'),
(334, 'default', 'updated', 'App\\Models\\Product', 'updated', 13, 'App\\Models\\User', 4, '{\"attributes\":{\"quantity\":8,\"updated_at\":\"2025-05-04T08:09:20.000000Z\"},\"old\":{\"quantity\":10,\"updated_at\":\"2025-05-04T08:08:49.000000Z\"}}', NULL, '2025-05-04 10:09:20', '2025-05-04 10:09:20'),
(335, 'default', 'deleted', 'App\\Models\\ProductCategory', 'deleted', 7, 'App\\Models\\User', 1, '{\"old\":{\"id\":7,\"company_id\":2,\"point_of_sale_id\":6,\"name_en\":\"Cables\",\"name_ar\":\"Cables\",\"description_en\":null,\"description_ar\":null,\"slug\":\"cables\",\"parent_id\":null,\"is_active\":1,\"created_at\":\"2025-05-04T07:58:15.000000Z\",\"updated_at\":\"2025-05-04T13:29:31.000000Z\",\"deleted_at\":\"2025-05-04T13:29:31.000000Z\"}}', NULL, '2025-05-04 13:29:31', '2025-05-04 13:29:31'),
(336, 'default', 'deleted', 'App\\Models\\ProductCategory', 'deleted', 6, 'App\\Models\\User', 1, '{\"old\":{\"id\":6,\"company_id\":2,\"point_of_sale_id\":6,\"name_en\":\" Cases\",\"name_ar\":\" Cases\",\"description_en\":null,\"description_ar\":null,\"slug\":\"cases\",\"parent_id\":null,\"is_active\":1,\"created_at\":\"2025-05-04T07:41:02.000000Z\",\"updated_at\":\"2025-05-04T13:29:31.000000Z\",\"deleted_at\":\"2025-05-04T13:29:31.000000Z\"}}', NULL, '2025-05-04 13:29:31', '2025-05-04 13:29:31'),
(337, 'default', 'deleted', 'App\\Models\\ProductCategory', 'deleted', 5, 'App\\Models\\User', 1, '{\"old\":{\"id\":5,\"company_id\":2,\"point_of_sale_id\":6,\"name_en\":\"Chargers\",\"name_ar\":\"Chargers\",\"description_en\":null,\"description_ar\":null,\"slug\":\"chargers\",\"parent_id\":null,\"is_active\":1,\"created_at\":\"2025-05-04T07:40:19.000000Z\",\"updated_at\":\"2025-05-04T13:29:31.000000Z\",\"deleted_at\":\"2025-05-04T13:29:31.000000Z\"}}', NULL, '2025-05-04 13:29:31', '2025-05-04 13:29:31'),
(338, 'default', 'deleted', 'App\\Models\\ProductCategory', 'deleted', 2, 'App\\Models\\User', 1, '{\"old\":{\"id\":2,\"company_id\":1,\"point_of_sale_id\":null,\"name_en\":\"Fast food\",\"name_ar\":\"\\u0627\\u0644\\u0648\\u062c\\u0628\\u0627\\u062a \\u0627\\u0644\\u0633\\u0631\\u064a\\u0639\\u0629\",\"description_en\":\"<p>Fast food<\\/p>\",\"description_ar\":\"<p dir=\\\"rtl\\\">\\u0635\\u062d\\u064a\\u064b\\u0627: \\u062a\\u0639\\u0631\\u0641 \\u0627\\u0644\\u0648\\u062c\\u0628\\u0629 \\u0627\\u0644\\u0633\\u0631\\u064a\\u0639\\u0629 \\u0628\\u0623\\u0646\\u0647\\u0627 <strong><em>\\u0627\\u0644\\u0648\\u062c\\u0628\\u0629 \\u0627\\u0644\\u062a\\u064a \\u062a\\u062d\\u062a\\u0648\\u064a \\u0639\\u0644\\u0649 \\u0623\\u0637\\u0639\\u0645\\u0629 \\u0633\\u0631\\u064a\\u0639\\u0629 \\u0627\\u0644\\u062a\\u062d\\u0636\\u064a\\u0631<\\/em><\\/strong>\\u060c \\u0645\\u062b\\u0644: \\u0634\\u0637\\u0627\\u0626\\u0631 \\u0627\\u0644\\u0634\\u0627\\u0648\\u0631\\u0645\\u0627 \\u0648\\u0627\\u0644\\u0628\\u0631\\u062c\\u0631 \\u0648\\u0627\\u0644\\u0641\\u0644\\u0627\\u0641\\u0644 \\u0648\\u0627\\u0644\\u0641\\u0637\\u0627\\u0626\\u0631 \\u0648\\u0627\\u0644\\u0628\\u064a\\u062a\\u0632\\u0627\\u060c \\u0648\\u0642\\u0637\\u0639 \\u0627\\u0644\\u062f\\u062c\\u0627\\u062c \\u0627\\u0644\\u0645\\u0642\\u0644\\u064a\\u0629\\u060c \\u0645\\u0639 \\u0645\\u0634\\u0631\\u0648 ...<\\/p><p><a href=\\\"https:\\/\\/ar.wikipedia.org\\/wiki\\/%D9%88%D8%AC%D8%A8%D8%A9_%D8%B3%D8%B1%D9%8A%D8%B9%D8%A9\\\"><br><\\/a><br><\\/p>\",\"slug\":\"fast-food\",\"parent_id\":null,\"is_active\":1,\"created_at\":\"2025-04-09T19:00:55.000000Z\",\"updated_at\":\"2025-05-04T13:29:31.000000Z\",\"deleted_at\":\"2025-05-04T13:29:31.000000Z\"}}', NULL, '2025-05-04 13:29:31', '2025-05-04 13:29:31'),
(339, 'default', 'deleted', 'App\\Models\\ProductCategory', 'deleted', 1, 'App\\Models\\User', 1, '{\"old\":{\"id\":1,\"company_id\":1,\"point_of_sale_id\":null,\"name_en\":\"Drinks\",\"name_ar\":\"\\u0642\\u0635 \\u0634\\u0639\\u0631 \\u0627\\u0644\\u0646\\u0633\\u0627\\u0621\",\"description_en\":null,\"description_ar\":\"<p>Drinks<\\/p>\",\"slug\":\"drinks\",\"parent_id\":null,\"is_active\":1,\"created_at\":\"2025-04-09T16:36:18.000000Z\",\"updated_at\":\"2025-05-04T13:29:32.000000Z\",\"deleted_at\":\"2025-05-04T13:29:32.000000Z\"}}', NULL, '2025-05-04 13:29:32', '2025-05-04 13:29:32'),
(340, 'default', 'deleted', 'App\\Models\\Order', 'deleted', 13, 'App\\Models\\User', 1, '{\"old\":{\"number\":\"ORD-202505-TJJMQD\",\"customer_id\":9,\"customer_name\":null,\"customer_email\":null,\"customer_phone_number\":null,\"user_id\":null,\"company_id\":2,\"order_status_id\":1,\"shipping_fee\":null,\"subtotal\":\"630.00\",\"vat\":\"0.00\",\"other_taxes\":\"0.00\",\"discount\":\"0.00\",\"total\":\"630.00\",\"amount_paid\":\"630.00\",\"payment_method_id\":4,\"currency_id\":5,\"billing_address_id\":26,\"shipping_address_id\":25,\"estimated_delivery_at\":null,\"delivered_at\":null,\"shipped_at\":null,\"meta\":[],\"point_of_sale_id\":6}}', NULL, '2025-05-04 13:29:45', '2025-05-04 13:29:45'),
(341, 'default', 'deleted', 'App\\Models\\Order', 'deleted', 12, 'App\\Models\\User', 1, '{\"old\":{\"number\":\"ORD-202505-FPEK0G\",\"customer_id\":9,\"customer_name\":null,\"customer_email\":null,\"customer_phone_number\":null,\"user_id\":null,\"company_id\":2,\"order_status_id\":1,\"shipping_fee\":null,\"subtotal\":\"15.00\",\"vat\":\"0.00\",\"other_taxes\":\"0.00\",\"discount\":\"0.00\",\"total\":\"15.00\",\"amount_paid\":\"0.00\",\"payment_method_id\":4,\"currency_id\":5,\"billing_address_id\":24,\"shipping_address_id\":23,\"estimated_delivery_at\":null,\"delivered_at\":null,\"shipped_at\":null,\"meta\":[],\"point_of_sale_id\":6}}', NULL, '2025-05-04 13:29:45', '2025-05-04 13:29:45'),
(342, 'default', 'deleted', 'App\\Models\\Order', 'deleted', 11, 'App\\Models\\User', 1, '{\"old\":{\"number\":\"ORD-202505-BA6DAF\",\"customer_id\":9,\"customer_name\":null,\"customer_email\":null,\"customer_phone_number\":null,\"user_id\":null,\"company_id\":2,\"order_status_id\":1,\"shipping_fee\":null,\"subtotal\":\"30.00\",\"vat\":\"0.00\",\"other_taxes\":\"0.00\",\"discount\":\"0.00\",\"total\":\"30.00\",\"amount_paid\":\"0.00\",\"payment_method_id\":4,\"currency_id\":5,\"billing_address_id\":22,\"shipping_address_id\":21,\"estimated_delivery_at\":null,\"delivered_at\":null,\"shipped_at\":null,\"meta\":[],\"point_of_sale_id\":6}}', NULL, '2025-05-04 13:29:45', '2025-05-04 13:29:45'),
(343, 'default', 'deleted', 'App\\Models\\Order', 'deleted', 10, 'App\\Models\\User', 1, '{\"old\":{\"number\":\"ORD-202505-XE5S0K\",\"customer_id\":9,\"customer_name\":null,\"customer_email\":null,\"customer_phone_number\":null,\"user_id\":null,\"company_id\":2,\"order_status_id\":1,\"shipping_fee\":null,\"subtotal\":\"400.00\",\"vat\":\"0.00\",\"other_taxes\":\"0.00\",\"discount\":\"0.00\",\"total\":\"400.00\",\"amount_paid\":\"0.00\",\"payment_method_id\":4,\"currency_id\":1,\"billing_address_id\":20,\"shipping_address_id\":19,\"estimated_delivery_at\":null,\"delivered_at\":null,\"shipped_at\":null,\"meta\":[],\"point_of_sale_id\":6}}', NULL, '2025-05-04 13:29:45', '2025-05-04 13:29:45'),
(344, 'default', 'deleted', 'App\\Models\\Order', 'deleted', 9, 'App\\Models\\User', 1, '{\"old\":{\"number\":\"ORD-202504-GGLVJL\",\"customer_id\":2,\"customer_name\":\"Arsalan  Habib\",\"customer_email\":\"arsalanhabib@gmail.com\",\"customer_phone_number\":\"4326187\",\"user_id\":3,\"company_id\":1,\"order_status_id\":1,\"shipping_fee\":null,\"subtotal\":\"304.00\",\"vat\":\"45.60\",\"other_taxes\":\"30.00\",\"discount\":\"10.00\",\"total\":\"370.00\",\"amount_paid\":\"370.00\",\"payment_method_id\":4,\"currency_id\":1,\"billing_address_id\":18,\"shipping_address_id\":17,\"estimated_delivery_at\":null,\"delivered_at\":null,\"shipped_at\":null,\"meta\":[],\"point_of_sale_id\":3}}', NULL, '2025-05-04 13:29:45', '2025-05-04 13:29:45'),
(345, 'default', 'deleted', 'App\\Models\\Order', 'deleted', 8, 'App\\Models\\User', 1, '{\"old\":{\"number\":\"ORD-202504-WNWQGP\",\"customer_id\":1,\"customer_name\":\"Zain ul Eman\",\"customer_email\":\"zainuleman786@gmail.com\",\"customer_phone_number\":\"03146775616\",\"user_id\":3,\"company_id\":1,\"order_status_id\":1,\"shipping_fee\":null,\"subtotal\":\"240.00\",\"vat\":\"36.00\",\"other_taxes\":\"15.00\",\"discount\":\"53.00\",\"total\":\"238.00\",\"amount_paid\":\"238.00\",\"payment_method_id\":4,\"currency_id\":1,\"billing_address_id\":16,\"shipping_address_id\":15,\"estimated_delivery_at\":null,\"delivered_at\":null,\"shipped_at\":null,\"meta\":[],\"point_of_sale_id\":3}}', NULL, '2025-05-04 13:29:45', '2025-05-04 13:29:45'),
(346, 'default', 'deleted', 'App\\Models\\Product', 'deleted', 2, 'App\\Models\\User', 1, '{\"old\":{\"id\":2,\"company_id\":1,\"name_en\":\"Pepsi\",\"name_ar\":\"\\u0628\\u064a\\u0628\\u0633\\u064a\",\"description_en\":\"pepsi\",\"description_ar\":\"\\u0628\\u064a\\u0628\\u0633\\u064a ... \\u0628\\u064a\\u0628\\u0633\\u064a (\\u0628\\u0627\\u0644\\u0625\\u0646\\u062c\\u0644\\u064a\\u0632\\u064a\\u0629: Pepsi)\\u200f \\u0647\\u0648 \\u0645\\u0634\\u0631\\u0648\\u0628 \\u063a\\u0627\\u0632\\u064a \\u0645\\u0643\\u0631\\u0628\\u0646 \\u062a\\u0635\\u0646\\u0639\\u0647 \\u0634\\u0631\\u0643\\u0629 \\u0628\\u064a\\u0628\\u0633\\u064a\\u0643\\u0648 (\\u062d\\u0627\\u0644\\u064a\\u064b\\u0651\\u0627). ... \\u0648\\u064a\\u0631\\u062c\\u0639 \\u0625\\u0646\\u0634\\u0627\\u0624\\u0647 \\u0648\\u062a\\u0637\\u0648\\u064a\\u0631\\u0647 \\u0641\\u064a \\u0627\\u0644\\u0623\\u0635\\u0644 \\u0625\\u0644\\u0649 \\u0639\\u0627\\u0645 1893 \\u0639\\u0644\\u0649 \\u064a\\u062f \\u0627\\u0644\\u0635\\u064a\\u062f\\u0644\\u0627\\u0646\\u064a \\u0643\\u0627\\u0644\\u064a\\u0628 \\u0628\\u0631\\u0627\\u062f\\u0647\\u0627\\u0645\\u060c ...\\n\",\"slug\":\"bybsy\",\"sku\":\"23423\",\"code\":\"1231\",\"price\":2,\"quantity\":0,\"sale_price\":2.3,\"currency_id\":1,\"product_category_id\":1,\"point_of_sale_id\":3,\"image_url\":null,\"is_active\":true,\"created_at\":\"2025-04-09T18:31:55.000000Z\",\"updated_at\":\"2025-05-04T13:30:06.000000Z\",\"deleted_at\":\"2025-05-04T13:30:06.000000Z\"}}', NULL, '2025-05-04 13:30:06', '2025-05-04 13:30:06'),
(347, 'default', 'deleted', 'App\\Models\\Product', 'deleted', 5, 'App\\Models\\User', 1, '{\"old\":{\"id\":5,\"company_id\":1,\"name_en\":\"coke\",\"name_ar\":\"coke\",\"description_en\":null,\"description_ar\":null,\"slug\":\"coke3\",\"sku\":\"234\",\"code\":\"532\",\"price\":100,\"quantity\":0,\"sale_price\":125,\"currency_id\":1,\"product_category_id\":1,\"point_of_sale_id\":3,\"image_url\":null,\"is_active\":true,\"created_at\":\"2025-04-09T19:42:29.000000Z\",\"updated_at\":\"2025-05-04T13:30:06.000000Z\",\"deleted_at\":\"2025-05-04T13:30:06.000000Z\"}}', NULL, '2025-05-04 13:30:06', '2025-05-04 13:30:06'),
(348, 'default', 'deleted', 'App\\Models\\Product', 'deleted', 6, 'App\\Models\\User', 1, '{\"old\":{\"id\":6,\"company_id\":1,\"name_en\":\"Water\",\"name_ar\":\"Water\",\"description_en\":null,\"description_ar\":null,\"slug\":\"water\",\"sku\":\"Water\",\"code\":\"Water\",\"price\":3,\"quantity\":0,\"sale_price\":3.45,\"currency_id\":1,\"product_category_id\":1,\"point_of_sale_id\":3,\"image_url\":null,\"is_active\":true,\"created_at\":\"2025-04-09T19:44:35.000000Z\",\"updated_at\":\"2025-05-04T13:30:06.000000Z\",\"deleted_at\":\"2025-05-04T13:30:06.000000Z\"}}', NULL, '2025-05-04 13:30:06', '2025-05-04 13:30:06');
INSERT INTO `activity_logs` (`id`, `log_name`, `description`, `subject_type`, `event`, `subject_id`, `causer_type`, `causer_id`, `properties`, `batch_uuid`, `created_at`, `updated_at`) VALUES
(349, 'default', 'deleted', 'App\\Models\\Product', 'deleted', 7, 'App\\Models\\User', 1, '{\"old\":{\"id\":7,\"company_id\":1,\"name_en\":\"juice\",\"name_ar\":\"juice\",\"description_en\":null,\"description_ar\":\"juice\",\"slug\":\"juice\",\"sku\":\"fdsa\",\"code\":\"423\",\"price\":5,\"quantity\":0,\"sale_price\":5.75,\"currency_id\":1,\"product_category_id\":1,\"point_of_sale_id\":3,\"image_url\":null,\"is_active\":true,\"created_at\":\"2025-04-09T19:51:16.000000Z\",\"updated_at\":\"2025-05-04T13:30:06.000000Z\",\"deleted_at\":\"2025-05-04T13:30:06.000000Z\"}}', NULL, '2025-05-04 13:30:06', '2025-05-04 13:30:06'),
(350, 'default', 'deleted', 'App\\Models\\Product', 'deleted', 8, 'App\\Models\\User', 1, '{\"old\":{\"id\":8,\"company_id\":1,\"name_en\":\"Pepsin2\",\"name_ar\":\"Pepsin2\",\"description_en\":null,\"description_ar\":null,\"slug\":\"pepsin2\",\"sku\":null,\"code\":null,\"price\":5,\"quantity\":0,\"sale_price\":5.75,\"currency_id\":1,\"product_category_id\":1,\"point_of_sale_id\":3,\"image_url\":null,\"is_active\":true,\"created_at\":\"2025-04-10T14:08:51.000000Z\",\"updated_at\":\"2025-05-04T13:30:06.000000Z\",\"deleted_at\":\"2025-05-04T13:30:06.000000Z\"}}', NULL, '2025-05-04 13:30:06', '2025-05-04 13:30:06'),
(351, 'default', 'deleted', 'App\\Models\\Product', 'deleted', 9, 'App\\Models\\User', 1, '{\"old\":{\"id\":9,\"company_id\":1,\"name_en\":\"Red bull\",\"name_ar\":\"Red bull\",\"description_en\":null,\"description_ar\":\"Red bull\",\"slug\":\"red-bull\",\"sku\":null,\"code\":null,\"price\":120,\"quantity\":0,\"sale_price\":138,\"currency_id\":1,\"product_category_id\":1,\"point_of_sale_id\":3,\"image_url\":null,\"is_active\":true,\"created_at\":\"2025-04-10T18:31:15.000000Z\",\"updated_at\":\"2025-05-04T13:30:06.000000Z\",\"deleted_at\":\"2025-05-04T13:30:06.000000Z\"}}', NULL, '2025-05-04 13:30:06', '2025-05-04 13:30:06'),
(352, 'default', 'deleted', 'App\\Models\\Product', 'deleted', 10, 'App\\Models\\User', 1, '{\"old\":{\"id\":10,\"company_id\":1,\"name_en\":\"Marinda\",\"name_ar\":\"Marinda\",\"description_en\":\"Marinda\",\"description_ar\":\"Marinda\",\"slug\":\"marinda\",\"sku\":\"423\",\"code\":\"234\",\"price\":30,\"quantity\":0,\"sale_price\":34.5,\"currency_id\":1,\"product_category_id\":1,\"point_of_sale_id\":3,\"image_url\":null,\"is_active\":true,\"created_at\":\"2025-04-10T18:46:38.000000Z\",\"updated_at\":\"2025-05-04T13:30:06.000000Z\",\"deleted_at\":\"2025-05-04T13:30:06.000000Z\"}}', NULL, '2025-05-04 13:30:06', '2025-05-04 13:30:06'),
(353, 'default', 'deleted', 'App\\Models\\Product', 'deleted', 11, 'App\\Models\\User', 1, '{\"old\":{\"id\":11,\"company_id\":1,\"name_en\":\"Fanta\",\"name_ar\":\"Fanta\",\"description_en\":\"Fanta\",\"description_ar\":\"Fanta\",\"slug\":\"Fanta\",\"sku\":null,\"code\":null,\"price\":12,\"quantity\":0,\"sale_price\":13.8,\"currency_id\":1,\"product_category_id\":1,\"point_of_sale_id\":3,\"image_url\":null,\"is_active\":true,\"created_at\":\"2025-04-10T18:55:02.000000Z\",\"updated_at\":\"2025-05-04T13:30:06.000000Z\",\"deleted_at\":\"2025-05-04T13:30:06.000000Z\"}}', NULL, '2025-05-04 13:30:06', '2025-05-04 13:30:06'),
(354, 'default', 'deleted', 'App\\Models\\Product', 'deleted', 12, 'App\\Models\\User', 1, '{\"old\":{\"id\":12,\"company_id\":2,\"name_en\":\"Iphone cable\",\"name_ar\":\"Iphone cable\",\"description_en\":null,\"description_ar\":null,\"slug\":\"iphone-cable\",\"sku\":null,\"code\":null,\"price\":15,\"quantity\":12,\"sale_price\":15,\"currency_id\":5,\"product_category_id\":7,\"point_of_sale_id\":6,\"image_url\":\"products\\/shopping.webp\",\"is_active\":true,\"created_at\":\"2025-05-04T08:45:54.000000Z\",\"updated_at\":\"2025-05-04T13:30:06.000000Z\",\"deleted_at\":\"2025-05-04T13:30:06.000000Z\"}}', NULL, '2025-05-04 13:30:06', '2025-05-04 13:30:06'),
(355, 'default', 'deleted', 'App\\Models\\Product', 'deleted', 13, 'App\\Models\\User', 1, '{\"old\":{\"id\":13,\"company_id\":2,\"name_en\":\"Iphone Charger\",\"name_ar\":\"Iphone Charger\",\"description_en\":null,\"description_ar\":null,\"slug\":\"iphone-charger\",\"sku\":null,\"code\":null,\"price\":500,\"quantity\":8,\"sale_price\":500,\"currency_id\":5,\"product_category_id\":5,\"point_of_sale_id\":6,\"image_url\":\"products\\/61CZrgz-DsL._AC_UF894,1000_QL80_.jpg\",\"is_active\":true,\"created_at\":\"2025-05-04T08:50:40.000000Z\",\"updated_at\":\"2025-05-04T13:30:06.000000Z\",\"deleted_at\":\"2025-05-04T13:30:06.000000Z\"}}', NULL, '2025-05-04 13:30:06', '2025-05-04 13:30:06'),
(356, 'default', 'deleted', 'App\\Models\\Order', 'deleted', 13, 'App\\Models\\User', 1, '{\"old\":{\"number\":\"ORD-202505-TJJMQD\",\"customer_id\":9,\"customer_name\":null,\"customer_email\":null,\"customer_phone_number\":null,\"user_id\":null,\"company_id\":2,\"order_status_id\":1,\"shipping_fee\":null,\"subtotal\":\"630.00\",\"vat\":\"0.00\",\"other_taxes\":\"0.00\",\"discount\":\"0.00\",\"total\":\"630.00\",\"amount_paid\":\"630.00\",\"payment_method_id\":4,\"currency_id\":5,\"billing_address_id\":26,\"shipping_address_id\":25,\"estimated_delivery_at\":null,\"delivered_at\":null,\"shipped_at\":null,\"meta\":[],\"point_of_sale_id\":6}}', NULL, '2025-05-04 13:30:21', '2025-05-04 13:30:21'),
(357, 'default', 'deleted', 'App\\Models\\Order', 'deleted', 12, 'App\\Models\\User', 1, '{\"old\":{\"number\":\"ORD-202505-FPEK0G\",\"customer_id\":9,\"customer_name\":null,\"customer_email\":null,\"customer_phone_number\":null,\"user_id\":null,\"company_id\":2,\"order_status_id\":1,\"shipping_fee\":null,\"subtotal\":\"15.00\",\"vat\":\"0.00\",\"other_taxes\":\"0.00\",\"discount\":\"0.00\",\"total\":\"15.00\",\"amount_paid\":\"0.00\",\"payment_method_id\":4,\"currency_id\":5,\"billing_address_id\":24,\"shipping_address_id\":23,\"estimated_delivery_at\":null,\"delivered_at\":null,\"shipped_at\":null,\"meta\":[],\"point_of_sale_id\":6}}', NULL, '2025-05-04 13:30:21', '2025-05-04 13:30:21'),
(358, 'default', 'deleted', 'App\\Models\\Order', 'deleted', 11, 'App\\Models\\User', 1, '{\"old\":{\"number\":\"ORD-202505-BA6DAF\",\"customer_id\":9,\"customer_name\":null,\"customer_email\":null,\"customer_phone_number\":null,\"user_id\":null,\"company_id\":2,\"order_status_id\":1,\"shipping_fee\":null,\"subtotal\":\"30.00\",\"vat\":\"0.00\",\"other_taxes\":\"0.00\",\"discount\":\"0.00\",\"total\":\"30.00\",\"amount_paid\":\"0.00\",\"payment_method_id\":4,\"currency_id\":5,\"billing_address_id\":22,\"shipping_address_id\":21,\"estimated_delivery_at\":null,\"delivered_at\":null,\"shipped_at\":null,\"meta\":[],\"point_of_sale_id\":6}}', NULL, '2025-05-04 13:30:21', '2025-05-04 13:30:21'),
(359, 'default', 'deleted', 'App\\Models\\Order', 'deleted', 10, 'App\\Models\\User', 1, '{\"old\":{\"number\":\"ORD-202505-XE5S0K\",\"customer_id\":9,\"customer_name\":null,\"customer_email\":null,\"customer_phone_number\":null,\"user_id\":null,\"company_id\":2,\"order_status_id\":1,\"shipping_fee\":null,\"subtotal\":\"400.00\",\"vat\":\"0.00\",\"other_taxes\":\"0.00\",\"discount\":\"0.00\",\"total\":\"400.00\",\"amount_paid\":\"0.00\",\"payment_method_id\":4,\"currency_id\":1,\"billing_address_id\":20,\"shipping_address_id\":19,\"estimated_delivery_at\":null,\"delivered_at\":null,\"shipped_at\":null,\"meta\":[],\"point_of_sale_id\":6}}', NULL, '2025-05-04 13:30:21', '2025-05-04 13:30:21'),
(360, 'default', 'deleted', 'App\\Models\\Order', 'deleted', 9, 'App\\Models\\User', 1, '{\"old\":{\"number\":\"ORD-202504-GGLVJL\",\"customer_id\":2,\"customer_name\":\"Arsalan  Habib\",\"customer_email\":\"arsalanhabib@gmail.com\",\"customer_phone_number\":\"4326187\",\"user_id\":3,\"company_id\":1,\"order_status_id\":1,\"shipping_fee\":null,\"subtotal\":\"304.00\",\"vat\":\"45.60\",\"other_taxes\":\"30.00\",\"discount\":\"10.00\",\"total\":\"370.00\",\"amount_paid\":\"370.00\",\"payment_method_id\":4,\"currency_id\":1,\"billing_address_id\":18,\"shipping_address_id\":17,\"estimated_delivery_at\":null,\"delivered_at\":null,\"shipped_at\":null,\"meta\":[],\"point_of_sale_id\":3}}', NULL, '2025-05-04 13:30:21', '2025-05-04 13:30:21'),
(361, 'default', 'deleted', 'App\\Models\\Order', 'deleted', 8, 'App\\Models\\User', 1, '{\"old\":{\"number\":\"ORD-202504-WNWQGP\",\"customer_id\":1,\"customer_name\":\"Zain ul Eman\",\"customer_email\":\"zainuleman786@gmail.com\",\"customer_phone_number\":\"03146775616\",\"user_id\":3,\"company_id\":1,\"order_status_id\":1,\"shipping_fee\":null,\"subtotal\":\"240.00\",\"vat\":\"36.00\",\"other_taxes\":\"15.00\",\"discount\":\"53.00\",\"total\":\"238.00\",\"amount_paid\":\"238.00\",\"payment_method_id\":4,\"currency_id\":1,\"billing_address_id\":16,\"shipping_address_id\":15,\"estimated_delivery_at\":null,\"delivered_at\":null,\"shipped_at\":null,\"meta\":[],\"point_of_sale_id\":3}}', NULL, '2025-05-04 13:30:21', '2025-05-04 13:30:21'),
(362, 'default', 'deleted', 'App\\Models\\User', 'deleted', 3, 'App\\Models\\User', 1, '{\"old\":{\"id\":3,\"first_name\":\"Zain\",\"last_name\":\"ul Eman\",\"email\":\"zainuleman786@gmail.com\",\"phone_number\":null,\"email_verified_at\":null,\"password\":\"$2y$10$YRIDYGcTaagYu96iq35vsueeVXimX62SiCabXpAjXKPIe0yGnvOrq\",\"remember_token\":null,\"created_at\":\"2025-04-13T13:53:21.000000Z\",\"updated_at\":\"2025-04-13T13:53:21.000000Z\",\"company_id\":1,\"point_of_sale_id\":3}}', NULL, '2025-05-04 13:30:44', '2025-05-04 13:30:44'),
(363, 'default', 'deleted', 'App\\Models\\User', 'deleted', 4, 'App\\Models\\User', 1, '{\"old\":{\"id\":4,\"first_name\":\"Adeel\",\"last_name\":\"Khan\",\"email\":\"adeel@gamil.com\",\"phone_number\":null,\"email_verified_at\":null,\"password\":\"$2y$10$QqP6zFidvA0s35r1weUSHOHhvLuqu1kKzrMvtTghY22My0rAxqSXm\",\"remember_token\":null,\"created_at\":\"2025-05-04T07:20:26.000000Z\",\"updated_at\":\"2025-05-04T07:20:26.000000Z\",\"company_id\":2,\"point_of_sale_id\":6}}', NULL, '2025-05-04 13:30:50', '2025-05-04 13:30:50'),
(364, 'default', 'deleted', 'App\\Models\\Invoice', 'deleted', 30, 'App\\Models\\User', 1, '{\"old\":{\"id\":30,\"number\":\"C001-INV-000001\",\"customer_name\":\"Zain ul Eman\",\"customer_email\":\"zainuleman786@gmail.com\",\"customer_phone\":null,\"company_id\":1,\"customer_id\":1,\"billing_address_id\":null,\"shipping_address_id\":null,\"subtotal\":240,\"discount\":53,\"total\":238,\"issue_date\":\"2025-04-14T00:08:05.000000Z\",\"due_date\":\"2025-05-14T00:08:05.000000Z\",\"paid_date\":null,\"invoice_status_id\":1,\"currency_id\":null,\"issued_by_user\":1,\"meta\":null,\"created_at\":\"2025-04-14T00:08:05.000000Z\",\"updated_at\":\"2025-05-04T13:31:55.000000Z\",\"deleted_at\":\"2025-05-04T13:31:55.000000Z\",\"amount_paid\":238,\"point_of_sale_id\":3,\"vat\":36,\"other_taxes\":15,\"order_id\":8}}', NULL, '2025-05-04 13:31:55', '2025-05-04 13:31:55'),
(365, 'default', 'deleted', 'App\\Models\\Invoice', 'deleted', 31, 'App\\Models\\User', 1, '{\"old\":{\"id\":31,\"number\":\"C001-INV-000002\",\"customer_name\":\"Arsalan  Habib\",\"customer_email\":\"arsalanhabib@gmail.com\",\"customer_phone\":null,\"company_id\":1,\"customer_id\":2,\"billing_address_id\":null,\"shipping_address_id\":null,\"subtotal\":304,\"discount\":10,\"total\":370,\"issue_date\":\"2025-04-14T00:11:36.000000Z\",\"due_date\":\"2025-05-14T00:11:36.000000Z\",\"paid_date\":null,\"invoice_status_id\":1,\"currency_id\":null,\"issued_by_user\":1,\"meta\":null,\"created_at\":\"2025-04-14T00:11:36.000000Z\",\"updated_at\":\"2025-05-04T13:31:55.000000Z\",\"deleted_at\":\"2025-05-04T13:31:55.000000Z\",\"amount_paid\":370,\"point_of_sale_id\":3,\"vat\":45.6,\"other_taxes\":30,\"order_id\":9}}', NULL, '2025-05-04 13:31:55', '2025-05-04 13:31:55'),
(366, 'default', 'deleted', 'App\\Models\\PointOfSale', 'deleted', 6, 'App\\Models\\User', 1, '{\"old\":{\"id\":6,\"name_en\":\"Chungi No 6\",\"name_ar\":\"Chungi No 6\",\"description_en\":null,\"description_ar\":null,\"company_id\":2,\"is_active\":true,\"meta\":[],\"created_at\":\"2025-05-04T07:17:19.000000Z\",\"updated_at\":\"2025-05-04T13:32:14.000000Z\",\"deleted_at\":\"2025-05-04T13:32:14.000000Z\"}}', NULL, '2025-05-04 13:32:14', '2025-05-04 13:32:14'),
(367, 'default', 'deleted', 'App\\Models\\PointOfSale', 'deleted', 5, 'App\\Models\\User', 1, '{\"old\":{\"id\":5,\"name_en\":\"Saloon 2 POS\",\"name_ar\":\"\\u0635\\u0627\\u0644\\u0648\\u0646 2 \\u0646\\u0642\\u0637\\u0629 \\u0628\\u064a\\u0639\",\"description_en\":\"<p>Saloon 2 POS<\\/p>\",\"description_ar\":\"<p dir=\\\"rtl\\\">\\u0635\\u0627\\u0644\\u0648\\u0646 2 \\u0646\\u0642\\u0637\\u0629 \\u0628\\u064a\\u0639<\\/p>\",\"company_id\":1,\"is_active\":true,\"meta\":[],\"created_at\":\"2025-04-13T14:02:06.000000Z\",\"updated_at\":\"2025-05-04T13:32:14.000000Z\",\"deleted_at\":\"2025-05-04T13:32:14.000000Z\"}}', NULL, '2025-05-04 13:32:14', '2025-05-04 13:32:14'),
(368, 'default', 'deleted', 'App\\Models\\PointOfSale', 'deleted', 3, 'App\\Models\\User', 1, '{\"old\":{\"id\":3,\"name_en\":\"Saloon pos\",\"name_ar\":\"\\u0635\\u0627\\u0644\\u0648\\u0646 \\u0628\\u0648\\u0641\",\"description_en\":\"<p>Saloon pos<\\/p>\",\"description_ar\":\"<p dir=\\\"rtl\\\">\\u0635\\u0627\\u0644\\u0648\\u0646 \\u0628\\u0648\\u0641<\\/p>\",\"company_id\":1,\"is_active\":true,\"meta\":[],\"created_at\":\"2025-04-13T13:26:11.000000Z\",\"updated_at\":\"2025-05-04T13:32:14.000000Z\",\"deleted_at\":\"2025-05-04T13:32:14.000000Z\"}}', NULL, '2025-05-04 13:32:14', '2025-05-04 13:32:14'),
(369, 'default', 'deleted', 'App\\Models\\Order', 'deleted', 13, 'App\\Models\\User', 1, '{\"old\":{\"number\":\"ORD-202505-TJJMQD\",\"customer_id\":9,\"customer_name\":null,\"customer_email\":null,\"customer_phone_number\":null,\"user_id\":null,\"company_id\":2,\"order_status_id\":1,\"shipping_fee\":null,\"subtotal\":\"630.00\",\"vat\":\"0.00\",\"other_taxes\":\"0.00\",\"discount\":\"0.00\",\"total\":\"630.00\",\"amount_paid\":\"630.00\",\"payment_method_id\":4,\"currency_id\":5,\"billing_address_id\":26,\"shipping_address_id\":25,\"estimated_delivery_at\":null,\"delivered_at\":null,\"shipped_at\":null,\"meta\":[],\"point_of_sale_id\":6}}', NULL, '2025-05-04 13:40:57', '2025-05-04 13:40:57'),
(370, 'default', 'deleted', 'App\\Models\\Order', 'deleted', 13, 'App\\Models\\User', 1, '{\"old\":{\"number\":\"ORD-202505-TJJMQD\",\"customer_id\":9,\"customer_name\":null,\"customer_email\":null,\"customer_phone_number\":null,\"user_id\":null,\"company_id\":2,\"order_status_id\":1,\"shipping_fee\":null,\"subtotal\":\"630.00\",\"vat\":\"0.00\",\"other_taxes\":\"0.00\",\"discount\":\"0.00\",\"total\":\"630.00\",\"amount_paid\":\"630.00\",\"payment_method_id\":4,\"currency_id\":5,\"billing_address_id\":26,\"shipping_address_id\":25,\"estimated_delivery_at\":null,\"delivered_at\":null,\"shipped_at\":null,\"meta\":[],\"point_of_sale_id\":6}}', NULL, '2025-05-04 13:41:15', '2025-05-04 13:41:15'),
(371, 'default', 'deleted', 'App\\Models\\Order', 'deleted', 12, 'App\\Models\\User', 1, '{\"old\":{\"number\":\"ORD-202505-FPEK0G\",\"customer_id\":9,\"customer_name\":null,\"customer_email\":null,\"customer_phone_number\":null,\"user_id\":null,\"company_id\":2,\"order_status_id\":1,\"shipping_fee\":null,\"subtotal\":\"15.00\",\"vat\":\"0.00\",\"other_taxes\":\"0.00\",\"discount\":\"0.00\",\"total\":\"15.00\",\"amount_paid\":\"0.00\",\"payment_method_id\":4,\"currency_id\":5,\"billing_address_id\":24,\"shipping_address_id\":23,\"estimated_delivery_at\":null,\"delivered_at\":null,\"shipped_at\":null,\"meta\":[],\"point_of_sale_id\":6}}', NULL, '2025-05-04 13:41:15', '2025-05-04 13:41:15'),
(372, 'default', 'deleted', 'App\\Models\\Order', 'deleted', 13, 'App\\Models\\User', 1, '{\"old\":{\"number\":\"ORD-202505-TJJMQD\",\"customer_id\":9,\"customer_name\":null,\"customer_email\":null,\"customer_phone_number\":null,\"user_id\":null,\"company_id\":2,\"order_status_id\":1,\"shipping_fee\":null,\"subtotal\":\"630.00\",\"vat\":\"0.00\",\"other_taxes\":\"0.00\",\"discount\":\"0.00\",\"total\":\"630.00\",\"amount_paid\":\"630.00\",\"payment_method_id\":4,\"currency_id\":5,\"billing_address_id\":26,\"shipping_address_id\":25,\"estimated_delivery_at\":null,\"delivered_at\":null,\"shipped_at\":null,\"meta\":[],\"point_of_sale_id\":6}}', NULL, '2025-05-04 13:41:32', '2025-05-04 13:41:32'),
(373, 'default', 'deleted', 'App\\Models\\Order', 'deleted', 12, 'App\\Models\\User', 1, '{\"old\":{\"number\":\"ORD-202505-FPEK0G\",\"customer_id\":9,\"customer_name\":null,\"customer_email\":null,\"customer_phone_number\":null,\"user_id\":null,\"company_id\":2,\"order_status_id\":1,\"shipping_fee\":null,\"subtotal\":\"15.00\",\"vat\":\"0.00\",\"other_taxes\":\"0.00\",\"discount\":\"0.00\",\"total\":\"15.00\",\"amount_paid\":\"0.00\",\"payment_method_id\":4,\"currency_id\":5,\"billing_address_id\":24,\"shipping_address_id\":23,\"estimated_delivery_at\":null,\"delivered_at\":null,\"shipped_at\":null,\"meta\":[],\"point_of_sale_id\":6}}', NULL, '2025-05-04 13:41:32', '2025-05-04 13:41:32'),
(374, 'default', 'deleted', 'App\\Models\\Order', 'deleted', 13, 'App\\Models\\User', 1, '{\"old\":{\"number\":\"ORD-202505-TJJMQD\",\"customer_id\":9,\"customer_name\":null,\"customer_email\":null,\"customer_phone_number\":null,\"user_id\":null,\"company_id\":2,\"order_status_id\":1,\"shipping_fee\":null,\"subtotal\":\"630.00\",\"vat\":\"0.00\",\"other_taxes\":\"0.00\",\"discount\":\"0.00\",\"total\":\"630.00\",\"amount_paid\":\"630.00\",\"payment_method_id\":4,\"currency_id\":5,\"billing_address_id\":26,\"shipping_address_id\":25,\"estimated_delivery_at\":null,\"delivered_at\":null,\"shipped_at\":null,\"meta\":[],\"point_of_sale_id\":6}}', NULL, '2025-05-04 13:44:39', '2025-05-04 13:44:39'),
(375, 'default', 'deleted', 'App\\Models\\Order', 'deleted', 12, 'App\\Models\\User', 1, '{\"old\":{\"number\":\"ORD-202505-FPEK0G\",\"customer_id\":9,\"customer_name\":null,\"customer_email\":null,\"customer_phone_number\":null,\"user_id\":null,\"company_id\":2,\"order_status_id\":1,\"shipping_fee\":null,\"subtotal\":\"15.00\",\"vat\":\"0.00\",\"other_taxes\":\"0.00\",\"discount\":\"0.00\",\"total\":\"15.00\",\"amount_paid\":\"0.00\",\"payment_method_id\":4,\"currency_id\":5,\"billing_address_id\":24,\"shipping_address_id\":23,\"estimated_delivery_at\":null,\"delivered_at\":null,\"shipped_at\":null,\"meta\":[],\"point_of_sale_id\":6}}', NULL, '2025-05-04 13:48:59', '2025-05-04 13:48:59'),
(376, 'default', 'deleted', 'App\\Models\\Order', 'deleted', 11, 'App\\Models\\User', 1, '{\"old\":{\"number\":\"ORD-202505-BA6DAF\",\"customer_id\":9,\"customer_name\":null,\"customer_email\":null,\"customer_phone_number\":null,\"user_id\":null,\"company_id\":2,\"order_status_id\":1,\"shipping_fee\":null,\"subtotal\":\"30.00\",\"vat\":\"0.00\",\"other_taxes\":\"0.00\",\"discount\":\"0.00\",\"total\":\"30.00\",\"amount_paid\":\"0.00\",\"payment_method_id\":4,\"currency_id\":5,\"billing_address_id\":22,\"shipping_address_id\":21,\"estimated_delivery_at\":null,\"delivered_at\":null,\"shipped_at\":null,\"meta\":[],\"point_of_sale_id\":6}}', NULL, '2025-05-04 13:48:59', '2025-05-04 13:48:59'),
(377, 'default', 'deleted', 'App\\Models\\Order', 'deleted', 10, 'App\\Models\\User', 1, '{\"old\":{\"number\":\"ORD-202505-XE5S0K\",\"customer_id\":9,\"customer_name\":null,\"customer_email\":null,\"customer_phone_number\":null,\"user_id\":null,\"company_id\":2,\"order_status_id\":1,\"shipping_fee\":null,\"subtotal\":\"400.00\",\"vat\":\"0.00\",\"other_taxes\":\"0.00\",\"discount\":\"0.00\",\"total\":\"400.00\",\"amount_paid\":\"0.00\",\"payment_method_id\":4,\"currency_id\":1,\"billing_address_id\":20,\"shipping_address_id\":19,\"estimated_delivery_at\":null,\"delivered_at\":null,\"shipped_at\":null,\"meta\":[],\"point_of_sale_id\":6}}', NULL, '2025-05-04 13:48:59', '2025-05-04 13:48:59'),
(378, 'default', 'deleted', 'App\\Models\\Order', 'deleted', 9, 'App\\Models\\User', 1, '{\"old\":{\"number\":\"ORD-202504-GGLVJL\",\"customer_id\":2,\"customer_name\":\"Arsalan  Habib\",\"customer_email\":\"arsalanhabib@gmail.com\",\"customer_phone_number\":\"4326187\",\"user_id\":null,\"company_id\":1,\"order_status_id\":1,\"shipping_fee\":null,\"subtotal\":\"304.00\",\"vat\":\"45.60\",\"other_taxes\":\"30.00\",\"discount\":\"10.00\",\"total\":\"370.00\",\"amount_paid\":\"370.00\",\"payment_method_id\":4,\"currency_id\":1,\"billing_address_id\":18,\"shipping_address_id\":17,\"estimated_delivery_at\":null,\"delivered_at\":null,\"shipped_at\":null,\"meta\":[],\"point_of_sale_id\":3}}', NULL, '2025-05-04 13:48:59', '2025-05-04 13:48:59'),
(379, 'default', 'deleted', 'App\\Models\\Order', 'deleted', 8, 'App\\Models\\User', 1, '{\"old\":{\"number\":\"ORD-202504-WNWQGP\",\"customer_id\":1,\"customer_name\":\"Zain ul Eman\",\"customer_email\":\"zainuleman786@gmail.com\",\"customer_phone_number\":\"03146775616\",\"user_id\":null,\"company_id\":1,\"order_status_id\":1,\"shipping_fee\":null,\"subtotal\":\"240.00\",\"vat\":\"36.00\",\"other_taxes\":\"15.00\",\"discount\":\"53.00\",\"total\":\"238.00\",\"amount_paid\":\"238.00\",\"payment_method_id\":4,\"currency_id\":1,\"billing_address_id\":16,\"shipping_address_id\":15,\"estimated_delivery_at\":null,\"delivered_at\":null,\"shipped_at\":null,\"meta\":[],\"point_of_sale_id\":3}}', NULL, '2025-05-04 13:48:59', '2025-05-04 13:48:59'),
(380, 'default', 'deleted', 'App\\Models\\Company', 'deleted', 1, 'App\\Models\\User', 1, '{\"old\":{\"id\":1,\"legal_name\":\"Estlo\",\"tax_number\":\"367566758985743\",\"website\":null,\"email\":\"Estlo@gmail.com\",\"phone_number\":\"24235432\",\"logo\":null,\"is_active\":true,\"meta\":null,\"created_at\":\"2025-04-09T17:20:03.000000Z\",\"updated_at\":\"2025-05-04T13:52:07.000000Z\",\"deleted_at\":\"2025-05-04T13:52:07.000000Z\"}}', NULL, '2025-05-04 13:52:07', '2025-05-04 13:52:07'),
(381, 'default', 'deleted', 'App\\Models\\Company', 'deleted', 2, 'App\\Models\\User', 1, '{\"old\":{\"id\":2,\"legal_name\":\"Adeel\",\"tax_number\":\"32142314\",\"website\":null,\"email\":\"adeel@gmao.com\",\"phone_number\":\"2423423423423\",\"logo\":\"company-logos\\/01JTCJQRRCW33Y0RXK5MWBA7EY.jpeg\",\"is_active\":true,\"meta\":null,\"created_at\":\"2025-05-04T04:41:52.000000Z\",\"updated_at\":\"2025-05-04T13:52:07.000000Z\",\"deleted_at\":\"2025-05-04T13:52:07.000000Z\"}}', NULL, '2025-05-04 13:52:07', '2025-05-04 13:52:07'),
(382, 'default', 'created', 'App\\Models\\Company', 'created', 3, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":3,\"legal_name\":\"Alyaa\",\"tax_number\":\"123123123123123\",\"website\":\"http:\\/\\/alyaa.sa\\/\",\"email\":\"info@alyaa.sa\",\"phone_number\":\"23413243123412\",\"logo\":\"company-logos\\/01JTDS8QVH6KBFB7MMRPX2ZS9E.png\",\"is_active\":true,\"meta\":null,\"created_at\":\"2025-05-04T13:55:14.000000Z\",\"updated_at\":\"2025-05-04T13:55:14.000000Z\",\"deleted_at\":null}}', NULL, '2025-05-04 13:55:14', '2025-05-04 13:55:14'),
(383, 'default', 'created', 'App\\Models\\PointOfSale', 'created', 7, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":7,\"name_en\":\"alyaa\",\"name_ar\":\"\\u0639\\u0644\\u064a\\u0627\\u0621\",\"description_en\":null,\"description_ar\":null,\"company_id\":null,\"is_active\":true,\"meta\":[],\"created_at\":\"2025-05-04T13:55:53.000000Z\",\"updated_at\":\"2025-05-04T13:55:53.000000Z\",\"deleted_at\":null}}', NULL, '2025-05-04 13:55:53', '2025-05-04 13:55:53'),
(384, 'default', 'updated', 'App\\Models\\PointOfSale', 'updated', 7, 'App\\Models\\User', 1, '{\"attributes\":{\"company_id\":3},\"old\":{\"company_id\":null}}', NULL, '2025-05-04 13:55:53', '2025-05-04 13:55:53'),
(385, 'default', 'created', 'App\\Models\\User', 'created', 5, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":5,\"first_name\":\"Aliyaa\",\"last_name\":\"Raza\",\"email\":\"aliyaa@gmail.com\",\"phone_number\":null,\"email_verified_at\":null,\"password\":\"$2y$10$\\/Eba1R3tH2Znenu59MsB5usq7neD9OAZYefkdFbLxyMmuH9y4fi3a\",\"remember_token\":null,\"created_at\":\"2025-05-04T13:57:25.000000Z\",\"updated_at\":\"2025-05-04T13:57:25.000000Z\",\"company_id\":3,\"point_of_sale_id\":7}}', NULL, '2025-05-04 13:57:25', '2025-05-04 13:57:25'),
(386, 'default', 'created', 'App\\Models\\ProductCategory', 'created', 8, 'App\\Models\\User', 5, '{\"attributes\":{\"id\":8,\"company_id\":3,\"point_of_sale_id\":7,\"name_en\":\"Building Materials\",\"name_ar\":\"\\u0645\\u0648\\u0627\\u062f \\u0627\\u0644\\u0628\\u0646\\u0627\\u0621\",\"description_en\":null,\"description_ar\":null,\"slug\":\"building-materials\",\"parent_id\":null,\"is_active\":1,\"created_at\":\"2025-05-04T13:59:21.000000Z\",\"updated_at\":\"2025-05-04T13:59:21.000000Z\",\"deleted_at\":null}}', NULL, '2025-05-04 13:59:21', '2025-05-04 13:59:21'),
(387, 'default', 'created', 'App\\Models\\ProductCategory', 'created', 9, 'App\\Models\\User', 5, '{\"attributes\":{\"id\":9,\"company_id\":3,\"point_of_sale_id\":7,\"name_en\":\"Hardware & Fasteners\",\"name_ar\":\" \\u0627\\u0644\\u0639\\u062f\\u062f \\u0648\\u0627\\u0644\\u0645\\u062b\\u0628\\u062a\\u0627\\u062a\",\"description_en\":null,\"description_ar\":null,\"slug\":\"hardware-fasteners\",\"parent_id\":null,\"is_active\":1,\"created_at\":\"2025-05-04T13:59:35.000000Z\",\"updated_at\":\"2025-05-04T13:59:35.000000Z\",\"deleted_at\":null}}', NULL, '2025-05-04 13:59:35', '2025-05-04 13:59:35'),
(388, 'default', 'created', 'App\\Models\\ProductCategory', 'created', 10, 'App\\Models\\User', 5, '{\"attributes\":{\"id\":10,\"company_id\":3,\"point_of_sale_id\":7,\"name_en\":\"Safety Gear\",\"name_ar\":\"\\u0645\\u0639\\u062f\\u0627\\u062a \\u0627\\u0644\\u0633\\u0644\\u0627\\u0645\\u0629\",\"description_en\":null,\"description_ar\":null,\"slug\":\"safety-gear\",\"parent_id\":null,\"is_active\":1,\"created_at\":\"2025-05-04T13:59:51.000000Z\",\"updated_at\":\"2025-05-04T13:59:51.000000Z\",\"deleted_at\":null}}', NULL, '2025-05-04 13:59:51', '2025-05-04 13:59:51'),
(389, 'default', 'created', 'App\\Models\\Tax', 'created', 4, 'App\\Models\\User', 1, '{\"attributes\":{\"id\":4,\"name_en\":\"VAT\",\"name_ar\":\"\\u0636\\u0631\\u064a\\u0628\\u0629 \\u0627\\u0644\\u0642\\u064a\\u0645\\u0629 \\u0627\\u0644\\u0645\\u0636\\u0627\\u0641\\u0629\",\"type\":\"percentage\",\"amount\":\"15.00\",\"company_id\":3,\"is_active\":1,\"created_at\":\"2025-05-04T14:01:18.000000Z\",\"updated_at\":\"2025-05-04T14:01:18.000000Z\",\"deleted_at\":null}}', NULL, '2025-05-04 14:01:18', '2025-05-04 14:01:18'),
(390, 'default', 'created', 'App\\Models\\Product', 'created', 14, 'App\\Models\\User', 5, '{\"attributes\":{\"id\":14,\"company_id\":3,\"name_en\":\"Cement\",\"name_ar\":\"\\u0627\\u0644\\u0623\\u0633\\u0645\\u0646\\u062a\",\"description_en\":null,\"description_ar\":null,\"slug\":\"alasmnt\",\"sku\":null,\"code\":null,\"price\":20,\"quantity\":10,\"sale_price\":20,\"currency_id\":1,\"product_category_id\":8,\"point_of_sale_id\":7,\"image_url\":null,\"is_active\":true,\"created_at\":\"2025-05-04T14:01:24.000000Z\",\"updated_at\":\"2025-05-04T14:01:24.000000Z\",\"deleted_at\":null}}', NULL, '2025-05-04 14:01:24', '2025-05-04 14:01:24'),
(391, 'default', 'updated', 'App\\Models\\Product', 'updated', 14, 'App\\Models\\User', 5, '{\"attributes\":{\"sale_price\":23,\"updated_at\":\"2025-05-04T14:01:34.000000Z\"},\"old\":{\"sale_price\":20,\"updated_at\":\"2025-05-04T14:01:24.000000Z\"}}', NULL, '2025-05-04 14:01:34', '2025-05-04 14:01:34'),
(392, 'default', 'created', 'App\\Models\\Product', 'created', 15, 'App\\Models\\User', 5, '{\"attributes\":{\"id\":15,\"company_id\":3,\"name_en\":\"Sand\",\"name_ar\":\"\\u0627\\u0644\\u0631\\u0645\\u0644\",\"description_en\":null,\"description_ar\":null,\"slug\":\"alrml\",\"sku\":null,\"code\":null,\"price\":40,\"quantity\":10,\"sale_price\":46,\"currency_id\":1,\"product_category_id\":8,\"point_of_sale_id\":7,\"image_url\":null,\"is_active\":true,\"created_at\":\"2025-05-04T14:02:08.000000Z\",\"updated_at\":\"2025-05-04T14:02:08.000000Z\",\"deleted_at\":null}}', NULL, '2025-05-04 14:02:08', '2025-05-04 14:02:08'),
(393, 'default', 'created', 'App\\Models\\Product', 'created', 16, 'App\\Models\\User', 5, '{\"attributes\":{\"id\":16,\"company_id\":3,\"name_en\":\"Helmets\",\"name_ar\":\"\\u0627\\u0644\\u062e\\u0648\\u0630\",\"description_en\":null,\"description_ar\":null,\"slug\":\"alkhoth\",\"sku\":null,\"code\":null,\"price\":20,\"quantity\":50,\"sale_price\":23,\"currency_id\":1,\"product_category_id\":10,\"point_of_sale_id\":7,\"image_url\":null,\"is_active\":true,\"created_at\":\"2025-05-04T14:02:38.000000Z\",\"updated_at\":\"2025-05-04T14:02:38.000000Z\",\"deleted_at\":null}}', NULL, '2025-05-04 14:02:38', '2025-05-04 14:02:38'),
(394, 'default', 'created', 'App\\Models\\Product', 'created', 17, 'App\\Models\\User', 5, '{\"attributes\":{\"id\":17,\"company_id\":3,\"name_en\":\"Boots \",\"name_ar\":\" \\u0627\\u0644\\u0623\\u062d\\u0630\\u064a\\u0629 \\u0627\\u0644\\u0648\\u0627\\u0642\\u064a\\u0629\",\"description_en\":null,\"description_ar\":null,\"slug\":\"alahthy-aloaky\",\"sku\":null,\"code\":null,\"price\":55,\"quantity\":0,\"sale_price\":55,\"currency_id\":1,\"product_category_id\":10,\"point_of_sale_id\":7,\"image_url\":null,\"is_active\":true,\"created_at\":\"2025-05-04T14:03:09.000000Z\",\"updated_at\":\"2025-05-04T14:03:09.000000Z\",\"deleted_at\":null}}', NULL, '2025-05-04 14:03:09', '2025-05-04 14:03:09'),
(395, 'default', 'created', 'App\\Models\\Product', 'created', 18, 'App\\Models\\User', 5, '{\"attributes\":{\"id\":18,\"company_id\":3,\"name_en\":\"Hinges\",\"name_ar\":\"\\u0627\\u0644\\u0645\\u0641\\u0635\\u0644\\u0627\\u062a\",\"description_en\":null,\"description_ar\":null,\"slug\":\"almfslat\",\"sku\":null,\"code\":null,\"price\":55,\"quantity\":10,\"sale_price\":63.25,\"currency_id\":1,\"product_category_id\":9,\"point_of_sale_id\":7,\"image_url\":null,\"is_active\":true,\"created_at\":\"2025-05-04T14:03:44.000000Z\",\"updated_at\":\"2025-05-04T14:03:44.000000Z\",\"deleted_at\":null}}', NULL, '2025-05-04 14:03:44', '2025-05-04 14:03:44'),
(396, 'default', 'created', 'App\\Models\\Product', 'created', 19, 'App\\Models\\User', 5, '{\"attributes\":{\"id\":19,\"company_id\":3,\"name_en\":\"Anchors\",\"name_ar\":\"\\u0627\\u0644\\u0645\\u0631\\u0627\\u0628\\u0637\",\"description_en\":null,\"description_ar\":null,\"slug\":\"almrabt\",\"sku\":null,\"code\":null,\"price\":85,\"quantity\":30,\"sale_price\":97.75,\"currency_id\":1,\"product_category_id\":9,\"point_of_sale_id\":7,\"image_url\":null,\"is_active\":true,\"created_at\":\"2025-05-04T14:04:20.000000Z\",\"updated_at\":\"2025-05-04T14:04:20.000000Z\",\"deleted_at\":null}}', NULL, '2025-05-04 14:04:20', '2025-05-04 14:04:20'),
(397, 'default', 'created', 'App\\Models\\Customer', 'created', 10, 'App\\Models\\User', 5, '{\"attributes\":{\"id\":10,\"first_name\":\"Guest\",\"last_name\":\"Customer\",\"email\":\"guest@gmail.com\",\"phone_number\":\"243253453\",\"company_id\":3,\"is_active\":true,\"meta\":null,\"created_at\":\"2025-05-04T14:05:40.000000Z\",\"updated_at\":\"2025-05-04T14:05:40.000000Z\",\"deleted_at\":null,\"vat_number\":null,\"address\":null,\"point_of_sale_id\":7}}', NULL, '2025-05-04 14:05:40', '2025-05-04 14:05:40'),
(398, 'default', 'created', 'App\\Models\\Order', 'created', 14, 'App\\Models\\User', 5, '{\"attributes\":{\"number\":\"ORD-202505-YHBOXB\",\"customer_id\":10,\"customer_name\":null,\"customer_email\":null,\"customer_phone_number\":null,\"user_id\":5,\"company_id\":3,\"order_status_id\":1,\"shipping_fee\":null,\"subtotal\":\"465.00\",\"vat\":\"70.00\",\"other_taxes\":\"0.00\",\"discount\":\"14.00\",\"total\":\"521.00\",\"amount_paid\":\"0.00\",\"payment_method_id\":4,\"currency_id\":1,\"billing_address_id\":null,\"shipping_address_id\":null,\"estimated_delivery_at\":null,\"delivered_at\":null,\"shipped_at\":null,\"meta\":[],\"point_of_sale_id\":7}}', NULL, '2025-05-04 14:16:41', '2025-05-04 14:16:41'),
(399, 'default', 'created', 'App\\Models\\OrderItem', 'created', 32, 'App\\Models\\User', 5, '{\"attributes\":{\"order_id\":14,\"product_name_en\":\"Cement\",\"product_name_ar\":\"\\u0627\\u0644\\u0623\\u0633\\u0645\\u0646\\u062a\",\"product_description_en\":null,\"product_description_ar\":null,\"product_sku\":null,\"product_code\":null,\"product_id\":14,\"quantity\":2,\"unit_price\":20,\"tax_id\":null,\"note\":null,\"vat_amount\":\"3.00\",\"other_taxes_amount\":\"0.00\",\"discount_amount\":\"6.00\",\"total_price\":\"40.00\"}}', NULL, '2025-05-04 14:16:41', '2025-05-04 14:16:41'),
(400, 'default', 'created', 'App\\Models\\OrderItem', 'created', 33, 'App\\Models\\User', 5, '{\"attributes\":{\"order_id\":14,\"product_name_en\":\"Anchors\",\"product_name_ar\":\"\\u0627\\u0644\\u0645\\u0631\\u0627\\u0628\\u0637\",\"product_description_en\":null,\"product_description_ar\":null,\"product_sku\":null,\"product_code\":null,\"product_id\":19,\"quantity\":5,\"unit_price\":85,\"tax_id\":null,\"note\":null,\"vat_amount\":\"12.80\",\"other_taxes_amount\":\"0.00\",\"discount_amount\":\"8.00\",\"total_price\":\"481.00\"}}', NULL, '2025-05-04 14:16:41', '2025-05-04 14:16:41'),
(401, 'default', 'created', 'App\\Models\\Address', 'created', 27, 'App\\Models\\User', 5, '{\"attributes\":{\"id\":27,\"address_type_id\":1,\"addressable_type\":null,\"addressable_id\":null,\"street\":null,\"city\":null,\"state\":null,\"country\":null,\"postal_code\":null,\"country_id\":null,\"contact_person_full_name\":null,\"contact_person_phone\":null,\"latitude\":null,\"longitude\":null,\"details\":null,\"created_at\":\"2025-05-04T14:16:41.000000Z\",\"updated_at\":\"2025-05-04T14:16:41.000000Z\",\"deleted_at\":null}}', NULL, '2025-05-04 14:16:41', '2025-05-04 14:16:41'),
(402, 'default', 'updated', 'App\\Models\\Order', 'updated', 14, 'App\\Models\\User', 5, '{\"attributes\":{\"shipping_address_id\":27},\"old\":{\"shipping_address_id\":null}}', NULL, '2025-05-04 14:16:41', '2025-05-04 14:16:41'),
(403, 'default', 'created', 'App\\Models\\Address', 'created', 28, 'App\\Models\\User', 5, '{\"attributes\":{\"id\":28,\"address_type_id\":2,\"addressable_type\":null,\"addressable_id\":null,\"street\":null,\"city\":null,\"state\":null,\"country\":null,\"postal_code\":null,\"country_id\":null,\"contact_person_full_name\":null,\"contact_person_phone\":null,\"latitude\":null,\"longitude\":null,\"details\":null,\"created_at\":\"2025-05-04T14:16:41.000000Z\",\"updated_at\":\"2025-05-04T14:16:41.000000Z\",\"deleted_at\":null}}', NULL, '2025-05-04 14:16:41', '2025-05-04 14:16:41'),
(404, 'default', 'updated', 'App\\Models\\Order', 'updated', 14, 'App\\Models\\User', 5, '{\"attributes\":{\"billing_address_id\":28},\"old\":{\"billing_address_id\":null}}', NULL, '2025-05-04 14:16:41', '2025-05-04 14:16:41'),
(405, 'default', 'updated', 'App\\Models\\Product', 'updated', 14, 'App\\Models\\User', 5, '{\"attributes\":{\"quantity\":8,\"updated_at\":\"2025-05-04T14:16:41.000000Z\"},\"old\":{\"quantity\":10,\"updated_at\":\"2025-05-04T14:01:34.000000Z\"}}', NULL, '2025-05-04 14:16:41', '2025-05-04 14:16:41'),
(406, 'default', 'updated', 'App\\Models\\Product', 'updated', 19, 'App\\Models\\User', 5, '{\"attributes\":{\"quantity\":25,\"updated_at\":\"2025-05-04T14:16:41.000000Z\"},\"old\":{\"quantity\":30,\"updated_at\":\"2025-05-04T14:04:20.000000Z\"}}', NULL, '2025-05-04 14:16:41', '2025-05-04 14:16:41'),
(407, 'default', 'updated', 'App\\Models\\Order', 'updated', 14, 'App\\Models\\User', 5, '{\"attributes\":{\"customer_name\":\"Guest Customer\",\"customer_email\":\"guest@gmail.com\",\"customer_phone_number\":\"243253453\",\"amount_paid\":\"521.00\"},\"old\":{\"customer_name\":null,\"customer_email\":null,\"customer_phone_number\":null,\"amount_paid\":\"0.00\"}}', NULL, '2025-05-04 14:18:10', '2025-05-04 14:18:10'),
(408, 'default', 'created', 'App\\Models\\Invoice', 'created', 1, 'App\\Models\\User', 5, '{\"attributes\":{\"id\":1,\"number\":\"C003-INV-000001\",\"order_id\":14,\"company_id\":3,\"point_of_sale_id\":7,\"customer_id\":10,\"issued_by_user\":5,\"customer_name\":\"Guest Customer\",\"customer_email\":\"guest@gmail.com\",\"customer_phone\":null,\"subtotal\":465,\"discount\":14,\"vat\":70,\"other_taxes\":0,\"total\":521,\"amount_paid\":521,\"due_date\":\"2025-06-03T15:03:05.000000Z\",\"paid_date\":null,\"issue_date\":\"2025-05-04T15:03:05.000000Z\",\"meta\":null,\"billing_address_id\":null,\"shipping_address_id\":null,\"invoice_status_id\":1,\"currency_id\":null,\"created_at\":\"2025-05-04T15:03:05.000000Z\",\"updated_at\":\"2025-05-04T15:03:05.000000Z\",\"deleted_at\":null}}', NULL, '2025-05-04 15:03:05', '2025-05-04 15:03:05'),
(409, 'default', 'created', 'App\\Models\\InvoiceItem', 'created', 78, 'App\\Models\\User', 5, '{\"attributes\":{\"id\":78,\"invoice_id\":1,\"product_name_en\":\"Cement\",\"product_name_ar\":\"\\u0627\\u0644\\u0623\\u0633\\u0645\\u0646\\u062a\",\"product_description_en\":null,\"product_description_ar\":null,\"product_sku\":null,\"product_code\":null,\"quantity\":2,\"unit_price\":20,\"tax_id\":null,\"discount_amount\":6,\"created_at\":\"2025-05-04T15:03:05.000000Z\",\"updated_at\":\"2025-05-04T15:03:05.000000Z\",\"deleted_at\":null,\"note\":null,\"vat_amount\":3,\"other_taxes_amount\":0,\"total_price\":40}}', NULL, '2025-05-04 15:03:05', '2025-05-04 15:03:05'),
(410, 'default', 'created', 'App\\Models\\InvoiceItem', 'created', 79, 'App\\Models\\User', 5, '{\"attributes\":{\"id\":79,\"invoice_id\":1,\"product_name_en\":\"Anchors\",\"product_name_ar\":\"\\u0627\\u0644\\u0645\\u0631\\u0627\\u0628\\u0637\",\"product_description_en\":null,\"product_description_ar\":null,\"product_sku\":null,\"product_code\":null,\"quantity\":5,\"unit_price\":85,\"tax_id\":null,\"discount_amount\":8,\"created_at\":\"2025-05-04T15:03:05.000000Z\",\"updated_at\":\"2025-05-04T15:03:05.000000Z\",\"deleted_at\":null,\"note\":null,\"vat_amount\":12.8,\"other_taxes_amount\":0,\"total_price\":481}}', NULL, '2025-05-04 15:03:05', '2025-05-04 15:03:05'),
(411, 'default', 'created', 'App\\Models\\InvoiceTemplateSetting', 'created', 4, 'App\\Models\\User', 5, '{\"attributes\":{\"id\":4,\"key_name\":\"note\",\"company_id\":3,\"value_en\":\"<p>&nbsp;Thank you for your business. Please review all materials and services provided. For any questions or concerns, feel free to contact us.&nbsp;<\\/p>\",\"value_ar\":\"<p dir=\\\"rtl\\\"><strong>\\u0645\\u0644\\u0627\\u062d\\u0638\\u0629:<\\/strong> \\u0634\\u0643\\u0631\\u064b\\u0627 \\u0644\\u062a\\u0639\\u0627\\u0645\\u0644\\u0643\\u0645 \\u0645\\u0639\\u0646\\u0627. \\u064a\\u0631\\u062c\\u0649 \\u0645\\u0631\\u0627\\u062c\\u0639\\u0629 \\u062c\\u0645\\u064a\\u0639 \\u0627\\u0644\\u0645\\u0648\\u0627\\u062f \\u0648\\u0627\\u0644\\u062e\\u062f\\u0645\\u0627\\u062a \\u0627\\u0644\\u0645\\u0642\\u062f\\u0645\\u0629. \\u0625\\u0630\\u0627 \\u0643\\u0627\\u0646 \\u0644\\u062f\\u064a\\u0643\\u0645 \\u0623\\u064a \\u0627\\u0633\\u062a\\u0641\\u0633\\u0627\\u0631\\u0627\\u062a \\u0623\\u0648 \\u0645\\u0644\\u0627\\u062d\\u0638\\u0627\\u062a\\u060c \\u0644\\u0627 \\u062a\\u062a\\u0631\\u062f\\u062f\\u0648\\u0627 \\u0641\\u064a \\u0627\\u0644\\u062a\\u0648\\u0627\\u0635\\u0644 \\u0645\\u0639\\u0646\\u0627.&nbsp;<\\/p>\",\"created_at\":\"2025-05-04T15:15:53.000000Z\",\"updated_at\":\"2025-05-04T15:15:53.000000Z\"}}', NULL, '2025-05-04 15:15:53', '2025-05-04 15:15:53'),
(412, 'default', 'created', 'App\\Models\\Customer', 'created', 11, 'App\\Models\\User', 5, '{\"attributes\":{\"id\":11,\"first_name\":\"Zain\",\"last_name\":\"ul Eman\",\"email\":\"zainuleman786@gmail.com\",\"phone_number\":\"03146775616\",\"company_id\":3,\"is_active\":true,\"meta\":null,\"created_at\":\"2025-05-04T15:50:38.000000Z\",\"updated_at\":\"2025-05-04T15:50:38.000000Z\",\"deleted_at\":null,\"vat_number\":null,\"address\":\"New Gulshan-e-Mehr Colony Multan near Masjid e Tasheer\",\"point_of_sale_id\":7}}', NULL, '2025-05-04 15:50:38', '2025-05-04 15:50:38'),
(413, 'default', 'created', 'App\\Models\\Order', 'created', 15, 'App\\Models\\User', 5, '{\"attributes\":{\"number\":\"ORD-202505-5PPPDK\",\"customer_id\":10,\"customer_name\":null,\"customer_email\":null,\"customer_phone_number\":null,\"user_id\":5,\"company_id\":3,\"order_status_id\":1,\"shipping_fee\":null,\"subtotal\":\"150.00\",\"vat\":\"20.26\",\"other_taxes\":\"0.00\",\"discount\":\"15.00\",\"total\":\"155.00\",\"amount_paid\":\"155.26\",\"payment_method_id\":4,\"currency_id\":1,\"billing_address_id\":null,\"shipping_address_id\":null,\"estimated_delivery_at\":null,\"delivered_at\":null,\"shipped_at\":null,\"meta\":[],\"point_of_sale_id\":7}}', NULL, '2025-05-04 15:55:39', '2025-05-04 15:55:39'),
(414, 'default', 'created', 'App\\Models\\OrderItem', 'created', 34, 'App\\Models\\User', 5, '{\"attributes\":{\"order_id\":15,\"product_name_en\":\"Hinges\",\"product_name_ar\":\"\\u0627\\u0644\\u0645\\u0641\\u0635\\u0644\\u0627\\u062a\",\"product_description_en\":null,\"product_description_ar\":null,\"product_sku\":null,\"product_code\":null,\"product_id\":18,\"quantity\":2,\"unit_price\":55,\"tax_id\":null,\"note\":null,\"vat_amount\":\"7.88\",\"other_taxes_amount\":\"0.00\",\"discount_amount\":\"5.00\",\"total_price\":\"121.00\"}}', NULL, '2025-05-04 15:55:39', '2025-05-04 15:55:39'),
(415, 'default', 'created', 'App\\Models\\OrderItem', 'created', 35, 'App\\Models\\User', 5, '{\"attributes\":{\"order_id\":15,\"product_name_en\":\"Sand\",\"product_name_ar\":\"\\u0627\\u0644\\u0631\\u0645\\u0644\",\"product_description_en\":null,\"product_description_ar\":null,\"product_sku\":null,\"product_code\":null,\"product_id\":15,\"quantity\":1,\"unit_price\":40,\"tax_id\":null,\"note\":null,\"vat_amount\":\"4.50\",\"other_taxes_amount\":\"0.00\",\"discount_amount\":\"10.00\",\"total_price\":\"35.00\"}}', NULL, '2025-05-04 15:55:39', '2025-05-04 15:55:39'),
(416, 'default', 'created', 'App\\Models\\Address', 'created', 29, 'App\\Models\\User', 5, '{\"attributes\":{\"id\":29,\"address_type_id\":1,\"addressable_type\":null,\"addressable_id\":null,\"street\":null,\"city\":null,\"state\":null,\"country\":null,\"postal_code\":null,\"country_id\":null,\"contact_person_full_name\":null,\"contact_person_phone\":null,\"latitude\":null,\"longitude\":null,\"details\":null,\"created_at\":\"2025-05-04T15:55:39.000000Z\",\"updated_at\":\"2025-05-04T15:55:39.000000Z\",\"deleted_at\":null}}', NULL, '2025-05-04 15:55:39', '2025-05-04 15:55:39'),
(417, 'default', 'updated', 'App\\Models\\Order', 'updated', 15, 'App\\Models\\User', 5, '{\"attributes\":{\"total\":\"155.00\",\"shipping_address_id\":29},\"old\":{\"total\":\"155.26\",\"shipping_address_id\":null}}', NULL, '2025-05-04 15:55:39', '2025-05-04 15:55:39'),
(418, 'default', 'created', 'App\\Models\\Address', 'created', 30, 'App\\Models\\User', 5, '{\"attributes\":{\"id\":30,\"address_type_id\":2,\"addressable_type\":null,\"addressable_id\":null,\"street\":null,\"city\":null,\"state\":null,\"country\":null,\"postal_code\":null,\"country_id\":null,\"contact_person_full_name\":null,\"contact_person_phone\":null,\"latitude\":null,\"longitude\":null,\"details\":null,\"created_at\":\"2025-05-04T15:55:39.000000Z\",\"updated_at\":\"2025-05-04T15:55:39.000000Z\",\"deleted_at\":null}}', NULL, '2025-05-04 15:55:39', '2025-05-04 15:55:39'),
(419, 'default', 'updated', 'App\\Models\\Order', 'updated', 15, 'App\\Models\\User', 5, '{\"attributes\":{\"total\":\"155.00\",\"billing_address_id\":30},\"old\":{\"total\":\"155.26\",\"billing_address_id\":null}}', NULL, '2025-05-04 15:55:39', '2025-05-04 15:55:39'),
(420, 'default', 'updated', 'App\\Models\\Product', 'updated', 18, 'App\\Models\\User', 5, '{\"attributes\":{\"quantity\":8,\"updated_at\":\"2025-05-04T15:55:40.000000Z\"},\"old\":{\"quantity\":10,\"updated_at\":\"2025-05-04T14:03:44.000000Z\"}}', NULL, '2025-05-04 15:55:40', '2025-05-04 15:55:40'),
(421, 'default', 'updated', 'App\\Models\\Product', 'updated', 15, 'App\\Models\\User', 5, '{\"attributes\":{\"quantity\":9,\"updated_at\":\"2025-05-04T15:55:40.000000Z\"},\"old\":{\"quantity\":10,\"updated_at\":\"2025-05-04T14:02:08.000000Z\"}}', NULL, '2025-05-04 15:55:40', '2025-05-04 15:55:40'),
(422, 'default', 'updated', 'App\\Models\\Order', 'updated', 15, 'App\\Models\\User', 5, '{\"attributes\":{\"customer_name\":\"Guest Customer\",\"customer_email\":\"guest@gmail.com\",\"customer_phone_number\":\"243253453\",\"amount_paid\":\"155.00\"},\"old\":{\"customer_name\":null,\"customer_email\":null,\"customer_phone_number\":null,\"amount_paid\":\"155.26\"}}', NULL, '2025-05-04 15:56:19', '2025-05-04 15:56:19'),
(423, 'default', 'created', 'App\\Models\\Invoice', 'created', 2, 'App\\Models\\User', 5, '{\"attributes\":{\"id\":2,\"number\":\"C003-INV-000002\",\"order_id\":15,\"company_id\":3,\"point_of_sale_id\":7,\"customer_id\":10,\"issued_by_user\":5,\"customer_name\":\"Guest Customer\",\"customer_email\":\"guest@gmail.com\",\"customer_phone\":null,\"subtotal\":150,\"discount\":15,\"vat\":20.26,\"other_taxes\":0,\"total\":155,\"amount_paid\":155,\"due_date\":\"2025-06-03T16:11:48.000000Z\",\"paid_date\":null,\"issue_date\":\"2025-05-04T16:11:48.000000Z\",\"meta\":null,\"billing_address_id\":null,\"shipping_address_id\":null,\"invoice_status_id\":1,\"currency_id\":null,\"created_at\":\"2025-05-04T16:11:48.000000Z\",\"updated_at\":\"2025-05-04T16:11:48.000000Z\",\"deleted_at\":null}}', NULL, '2025-05-04 16:11:48', '2025-05-04 16:11:48'),
(424, 'default', 'created', 'App\\Models\\InvoiceItem', 'created', 80, 'App\\Models\\User', 5, '{\"attributes\":{\"id\":80,\"invoice_id\":2,\"product_name_en\":\"Hinges\",\"product_name_ar\":\"\\u0627\\u0644\\u0645\\u0641\\u0635\\u0644\\u0627\\u062a\",\"product_description_en\":null,\"product_description_ar\":null,\"product_sku\":null,\"product_code\":null,\"quantity\":2,\"unit_price\":55,\"tax_id\":null,\"discount_amount\":5,\"created_at\":\"2025-05-04T16:11:48.000000Z\",\"updated_at\":\"2025-05-04T16:11:48.000000Z\",\"deleted_at\":null,\"note\":null,\"vat_amount\":7.88,\"other_taxes_amount\":0,\"total_price\":121}}', NULL, '2025-05-04 16:11:48', '2025-05-04 16:11:48'),
(425, 'default', 'created', 'App\\Models\\InvoiceItem', 'created', 81, 'App\\Models\\User', 5, '{\"attributes\":{\"id\":81,\"invoice_id\":2,\"product_name_en\":\"Sand\",\"product_name_ar\":\"\\u0627\\u0644\\u0631\\u0645\\u0644\",\"product_description_en\":null,\"product_description_ar\":null,\"product_sku\":null,\"product_code\":null,\"quantity\":1,\"unit_price\":40,\"tax_id\":null,\"discount_amount\":10,\"created_at\":\"2025-05-04T16:11:48.000000Z\",\"updated_at\":\"2025-05-04T16:11:48.000000Z\",\"deleted_at\":null,\"note\":null,\"vat_amount\":4.5,\"other_taxes_amount\":0,\"total_price\":35}}', NULL, '2025-05-04 16:11:49', '2025-05-04 16:11:49'),
(426, 'default', 'created', 'App\\Models\\Invoice', 'created', 3, 'App\\Models\\User', 5, '{\"attributes\":{\"id\":3,\"number\":\"C003-INV-000003\",\"order_id\":14,\"company_id\":3,\"point_of_sale_id\":7,\"customer_id\":10,\"issued_by_user\":5,\"customer_name\":\"Guest Customer\",\"customer_email\":\"guest@gmail.com\",\"customer_phone\":null,\"subtotal\":465,\"discount\":14,\"vat\":70,\"other_taxes\":0,\"total\":521,\"amount_paid\":521,\"due_date\":\"2025-06-03T16:13:57.000000Z\",\"paid_date\":null,\"issue_date\":\"2025-05-04T16:13:57.000000Z\",\"meta\":null,\"billing_address_id\":null,\"shipping_address_id\":null,\"invoice_status_id\":1,\"currency_id\":null,\"created_at\":\"2025-05-04T16:13:57.000000Z\",\"updated_at\":\"2025-05-04T16:13:57.000000Z\",\"deleted_at\":null}}', NULL, '2025-05-04 16:13:57', '2025-05-04 16:13:57'),
(427, 'default', 'created', 'App\\Models\\InvoiceItem', 'created', 82, 'App\\Models\\User', 5, '{\"attributes\":{\"id\":82,\"invoice_id\":3,\"product_name_en\":\"Cement\",\"product_name_ar\":\"\\u0627\\u0644\\u0623\\u0633\\u0645\\u0646\\u062a\",\"product_description_en\":null,\"product_description_ar\":null,\"product_sku\":null,\"product_code\":null,\"quantity\":2,\"unit_price\":20,\"tax_id\":null,\"discount_amount\":6,\"created_at\":\"2025-05-04T16:13:58.000000Z\",\"updated_at\":\"2025-05-04T16:13:58.000000Z\",\"deleted_at\":null,\"note\":null,\"vat_amount\":3,\"other_taxes_amount\":0,\"total_price\":40}}', NULL, '2025-05-04 16:13:58', '2025-05-04 16:13:58'),
(428, 'default', 'created', 'App\\Models\\InvoiceItem', 'created', 83, 'App\\Models\\User', 5, '{\"attributes\":{\"id\":83,\"invoice_id\":3,\"product_name_en\":\"Anchors\",\"product_name_ar\":\"\\u0627\\u0644\\u0645\\u0631\\u0627\\u0628\\u0637\",\"product_description_en\":null,\"product_description_ar\":null,\"product_sku\":null,\"product_code\":null,\"quantity\":5,\"unit_price\":85,\"tax_id\":null,\"discount_amount\":8,\"created_at\":\"2025-05-04T16:13:58.000000Z\",\"updated_at\":\"2025-05-04T16:13:58.000000Z\",\"deleted_at\":null,\"note\":null,\"vat_amount\":12.8,\"other_taxes_amount\":0,\"total_price\":481}}', NULL, '2025-05-04 16:13:58', '2025-05-04 16:13:58'),
(429, 'default', 'created', 'App\\Models\\Invoice', 'created', 4, 'App\\Models\\User', 5, '{\"attributes\":{\"id\":4,\"number\":\"C003-INV-000004\",\"order_id\":14,\"company_id\":3,\"point_of_sale_id\":7,\"customer_id\":10,\"issued_by_user\":5,\"customer_name\":\"Guest Customer\",\"customer_email\":\"guest@gmail.com\",\"customer_phone\":null,\"subtotal\":465,\"discount\":14,\"vat\":70,\"other_taxes\":0,\"total\":521,\"amount_paid\":521,\"due_date\":\"2025-06-03T16:41:01.000000Z\",\"paid_date\":null,\"issue_date\":\"2025-05-04T16:41:01.000000Z\",\"meta\":null,\"billing_address_id\":null,\"shipping_address_id\":null,\"invoice_status_id\":1,\"currency_id\":null,\"created_at\":\"2025-05-04T16:41:01.000000Z\",\"updated_at\":\"2025-05-04T16:41:01.000000Z\",\"deleted_at\":null}}', NULL, '2025-05-04 16:41:01', '2025-05-04 16:41:01');
INSERT INTO `activity_logs` (`id`, `log_name`, `description`, `subject_type`, `event`, `subject_id`, `causer_type`, `causer_id`, `properties`, `batch_uuid`, `created_at`, `updated_at`) VALUES
(430, 'default', 'created', 'App\\Models\\InvoiceItem', 'created', 84, 'App\\Models\\User', 5, '{\"attributes\":{\"id\":84,\"invoice_id\":4,\"product_name_en\":\"Cement\",\"product_name_ar\":\"\\u0627\\u0644\\u0623\\u0633\\u0645\\u0646\\u062a\",\"product_description_en\":null,\"product_description_ar\":null,\"product_sku\":null,\"product_code\":null,\"quantity\":2,\"unit_price\":20,\"tax_id\":null,\"discount_amount\":6,\"created_at\":\"2025-05-04T16:41:01.000000Z\",\"updated_at\":\"2025-05-04T16:41:01.000000Z\",\"deleted_at\":null,\"note\":null,\"vat_amount\":3,\"other_taxes_amount\":0,\"total_price\":40}}', NULL, '2025-05-04 16:41:01', '2025-05-04 16:41:01'),
(431, 'default', 'created', 'App\\Models\\InvoiceItem', 'created', 85, 'App\\Models\\User', 5, '{\"attributes\":{\"id\":85,\"invoice_id\":4,\"product_name_en\":\"Anchors\",\"product_name_ar\":\"\\u0627\\u0644\\u0645\\u0631\\u0627\\u0628\\u0637\",\"product_description_en\":null,\"product_description_ar\":null,\"product_sku\":null,\"product_code\":null,\"quantity\":5,\"unit_price\":85,\"tax_id\":null,\"discount_amount\":8,\"created_at\":\"2025-05-04T16:41:01.000000Z\",\"updated_at\":\"2025-05-04T16:41:01.000000Z\",\"deleted_at\":null,\"note\":null,\"vat_amount\":12.8,\"other_taxes_amount\":0,\"total_price\":481}}', NULL, '2025-05-04 16:41:01', '2025-05-04 16:41:01'),
(432, 'default', 'created', 'App\\Models\\Invoice', 'created', 5, 'App\\Models\\User', 5, '{\"attributes\":{\"id\":5,\"number\":\"C003-INV-000005\",\"order_id\":14,\"company_id\":3,\"point_of_sale_id\":7,\"customer_id\":10,\"issued_by_user\":5,\"customer_name\":\"Guest Customer\",\"customer_email\":\"guest@gmail.com\",\"customer_phone\":null,\"subtotal\":465,\"discount\":14,\"vat\":70,\"other_taxes\":0,\"total\":521,\"amount_paid\":521,\"due_date\":\"2025-06-03T16:43:06.000000Z\",\"paid_date\":null,\"issue_date\":\"2025-05-04T16:43:06.000000Z\",\"meta\":null,\"billing_address_id\":null,\"shipping_address_id\":null,\"invoice_status_id\":1,\"currency_id\":null,\"created_at\":\"2025-05-04T16:43:06.000000Z\",\"updated_at\":\"2025-05-04T16:43:06.000000Z\",\"deleted_at\":null}}', NULL, '2025-05-04 16:43:06', '2025-05-04 16:43:06'),
(433, 'default', 'created', 'App\\Models\\InvoiceItem', 'created', 86, 'App\\Models\\User', 5, '{\"attributes\":{\"id\":86,\"invoice_id\":5,\"product_name_en\":\"Cement\",\"product_name_ar\":\"\\u0627\\u0644\\u0623\\u0633\\u0645\\u0646\\u062a\",\"product_description_en\":null,\"product_description_ar\":null,\"product_sku\":null,\"product_code\":null,\"quantity\":2,\"unit_price\":20,\"tax_id\":null,\"discount_amount\":6,\"created_at\":\"2025-05-04T16:43:06.000000Z\",\"updated_at\":\"2025-05-04T16:43:06.000000Z\",\"deleted_at\":null,\"note\":null,\"vat_amount\":3,\"other_taxes_amount\":0,\"total_price\":40}}', NULL, '2025-05-04 16:43:06', '2025-05-04 16:43:06'),
(434, 'default', 'created', 'App\\Models\\InvoiceItem', 'created', 87, 'App\\Models\\User', 5, '{\"attributes\":{\"id\":87,\"invoice_id\":5,\"product_name_en\":\"Anchors\",\"product_name_ar\":\"\\u0627\\u0644\\u0645\\u0631\\u0627\\u0628\\u0637\",\"product_description_en\":null,\"product_description_ar\":null,\"product_sku\":null,\"product_code\":null,\"quantity\":5,\"unit_price\":85,\"tax_id\":null,\"discount_amount\":8,\"created_at\":\"2025-05-04T16:43:06.000000Z\",\"updated_at\":\"2025-05-04T16:43:06.000000Z\",\"deleted_at\":null,\"note\":null,\"vat_amount\":12.8,\"other_taxes_amount\":0,\"total_price\":481}}', NULL, '2025-05-04 16:43:06', '2025-05-04 16:43:06'),
(435, 'default', 'created', 'App\\Models\\Invoice', 'created', 6, 'App\\Models\\User', 5, '{\"attributes\":{\"id\":6,\"number\":\"C003-INV-000006\",\"order_id\":14,\"company_id\":3,\"point_of_sale_id\":7,\"customer_id\":10,\"issued_by_user\":5,\"customer_name\":\"Guest Customer\",\"customer_email\":\"guest@gmail.com\",\"customer_phone\":null,\"subtotal\":465,\"discount\":14,\"vat\":70,\"other_taxes\":0,\"total\":521,\"amount_paid\":521,\"due_date\":\"2025-06-03T16:52:06.000000Z\",\"paid_date\":null,\"issue_date\":\"2025-05-04T16:52:06.000000Z\",\"meta\":null,\"billing_address_id\":null,\"shipping_address_id\":null,\"invoice_status_id\":1,\"currency_id\":null,\"created_at\":\"2025-05-04T16:52:06.000000Z\",\"updated_at\":\"2025-05-04T16:52:06.000000Z\",\"deleted_at\":null}}', NULL, '2025-05-04 16:52:06', '2025-05-04 16:52:06'),
(436, 'default', 'created', 'App\\Models\\InvoiceItem', 'created', 88, 'App\\Models\\User', 5, '{\"attributes\":{\"id\":88,\"invoice_id\":6,\"product_name_en\":\"Cement\",\"product_name_ar\":\"\\u0627\\u0644\\u0623\\u0633\\u0645\\u0646\\u062a\",\"product_description_en\":null,\"product_description_ar\":null,\"product_sku\":null,\"product_code\":null,\"quantity\":2,\"unit_price\":20,\"tax_id\":null,\"discount_amount\":6,\"created_at\":\"2025-05-04T16:52:06.000000Z\",\"updated_at\":\"2025-05-04T16:52:06.000000Z\",\"deleted_at\":null,\"note\":null,\"vat_amount\":3,\"other_taxes_amount\":0,\"total_price\":40}}', NULL, '2025-05-04 16:52:06', '2025-05-04 16:52:06'),
(437, 'default', 'created', 'App\\Models\\InvoiceItem', 'created', 89, 'App\\Models\\User', 5, '{\"attributes\":{\"id\":89,\"invoice_id\":6,\"product_name_en\":\"Anchors\",\"product_name_ar\":\"\\u0627\\u0644\\u0645\\u0631\\u0627\\u0628\\u0637\",\"product_description_en\":null,\"product_description_ar\":null,\"product_sku\":null,\"product_code\":null,\"quantity\":5,\"unit_price\":85,\"tax_id\":null,\"discount_amount\":8,\"created_at\":\"2025-05-04T16:52:06.000000Z\",\"updated_at\":\"2025-05-04T16:52:06.000000Z\",\"deleted_at\":null,\"note\":null,\"vat_amount\":12.8,\"other_taxes_amount\":0,\"total_price\":481}}', NULL, '2025-05-04 16:52:06', '2025-05-04 16:52:06'),
(438, 'default', 'created', 'App\\Models\\Order', 'created', 16, 'App\\Models\\User', 5, '{\"attributes\":{\"number\":\"ORD-202505-QZXT4P\",\"customer_id\":10,\"customer_name\":null,\"customer_email\":null,\"customer_phone_number\":null,\"user_id\":5,\"company_id\":3,\"order_status_id\":1,\"shipping_fee\":null,\"subtotal\":\"100.00\",\"vat\":\"7.50\",\"other_taxes\":\"0.00\",\"discount\":\"50.00\",\"total\":\"58.00\",\"amount_paid\":\"0.00\",\"payment_method_id\":4,\"currency_id\":1,\"billing_address_id\":null,\"shipping_address_id\":null,\"estimated_delivery_at\":null,\"delivered_at\":null,\"shipped_at\":null,\"meta\":[],\"point_of_sale_id\":7}}', NULL, '2025-05-04 17:12:24', '2025-05-04 17:12:24'),
(439, 'default', 'created', 'App\\Models\\OrderItem', 'created', 36, 'App\\Models\\User', 5, '{\"attributes\":{\"order_id\":16,\"product_name_en\":\"Cement\",\"product_name_ar\":\"\\u0627\\u0644\\u0623\\u0633\\u0645\\u0646\\u062a\",\"product_description_en\":null,\"product_description_ar\":null,\"product_sku\":null,\"product_code\":null,\"product_id\":14,\"quantity\":1,\"unit_price\":100,\"tax_id\":null,\"note\":null,\"vat_amount\":\"7.50\",\"other_taxes_amount\":\"0.00\",\"discount_amount\":\"50.00\",\"total_price\":\"58.00\"}}', NULL, '2025-05-04 17:12:24', '2025-05-04 17:12:24'),
(440, 'default', 'created', 'App\\Models\\Address', 'created', 31, 'App\\Models\\User', 5, '{\"attributes\":{\"id\":31,\"address_type_id\":1,\"addressable_type\":null,\"addressable_id\":null,\"street\":null,\"city\":null,\"state\":null,\"country\":null,\"postal_code\":null,\"country_id\":null,\"contact_person_full_name\":null,\"contact_person_phone\":null,\"latitude\":null,\"longitude\":null,\"details\":null,\"created_at\":\"2025-05-04T17:12:24.000000Z\",\"updated_at\":\"2025-05-04T17:12:24.000000Z\",\"deleted_at\":null}}', NULL, '2025-05-04 17:12:24', '2025-05-04 17:12:24'),
(441, 'default', 'updated', 'App\\Models\\Order', 'updated', 16, 'App\\Models\\User', 5, '{\"attributes\":{\"total\":\"58.00\",\"shipping_address_id\":31},\"old\":{\"total\":\"57.50\",\"shipping_address_id\":null}}', NULL, '2025-05-04 17:12:24', '2025-05-04 17:12:24'),
(442, 'default', 'created', 'App\\Models\\Address', 'created', 32, 'App\\Models\\User', 5, '{\"attributes\":{\"id\":32,\"address_type_id\":2,\"addressable_type\":null,\"addressable_id\":null,\"street\":null,\"city\":null,\"state\":null,\"country\":null,\"postal_code\":null,\"country_id\":null,\"contact_person_full_name\":null,\"contact_person_phone\":null,\"latitude\":null,\"longitude\":null,\"details\":null,\"created_at\":\"2025-05-04T17:12:24.000000Z\",\"updated_at\":\"2025-05-04T17:12:24.000000Z\",\"deleted_at\":null}}', NULL, '2025-05-04 17:12:24', '2025-05-04 17:12:24'),
(443, 'default', 'updated', 'App\\Models\\Order', 'updated', 16, 'App\\Models\\User', 5, '{\"attributes\":{\"total\":\"58.00\",\"billing_address_id\":32},\"old\":{\"total\":\"57.50\",\"billing_address_id\":null}}', NULL, '2025-05-04 17:12:24', '2025-05-04 17:12:24'),
(444, 'default', 'updated', 'App\\Models\\Product', 'updated', 14, 'App\\Models\\User', 5, '{\"attributes\":{\"quantity\":7,\"updated_at\":\"2025-05-04T17:12:24.000000Z\"},\"old\":{\"quantity\":8,\"updated_at\":\"2025-05-04T14:16:41.000000Z\"}}', NULL, '2025-05-04 17:12:24', '2025-05-04 17:12:24'),
(445, 'default', 'created', 'App\\Models\\Order', 'created', 17, 'App\\Models\\User', 5, '{\"attributes\":{\"number\":\"ORD-202505-CTFBO2\",\"customer_id\":10,\"customer_name\":null,\"customer_email\":null,\"customer_phone_number\":null,\"user_id\":5,\"company_id\":3,\"order_status_id\":1,\"shipping_fee\":null,\"subtotal\":\"400.00\",\"vat\":\"52.20\",\"other_taxes\":\"20.00\",\"discount\":\"52.00\",\"total\":\"420.00\",\"amount_paid\":\"0.00\",\"payment_method_id\":4,\"currency_id\":1,\"billing_address_id\":null,\"shipping_address_id\":null,\"estimated_delivery_at\":null,\"delivered_at\":null,\"shipped_at\":null,\"meta\":[],\"point_of_sale_id\":7}}', NULL, '2025-05-04 17:48:41', '2025-05-04 17:48:41'),
(446, 'default', 'created', 'App\\Models\\OrderItem', 'created', 37, 'App\\Models\\User', 5, '{\"attributes\":{\"order_id\":17,\"product_name_en\":\"Helmets\",\"product_name_ar\":\"\\u0627\\u0644\\u062e\\u0648\\u0630\",\"product_description_en\":null,\"product_description_ar\":null,\"product_sku\":null,\"product_code\":null,\"product_id\":16,\"quantity\":1,\"unit_price\":200,\"tax_id\":null,\"note\":null,\"vat_amount\":\"26.10\",\"other_taxes_amount\":\"10.00\",\"discount_amount\":\"26.00\",\"total_price\":\"210.00\"}}', NULL, '2025-05-04 17:48:41', '2025-05-04 17:48:41'),
(447, 'default', 'created', 'App\\Models\\OrderItem', 'created', 38, 'App\\Models\\User', 5, '{\"attributes\":{\"order_id\":17,\"product_name_en\":\"Cement\",\"product_name_ar\":\"\\u0627\\u0644\\u0623\\u0633\\u0645\\u0646\\u062a\",\"product_description_en\":null,\"product_description_ar\":null,\"product_sku\":null,\"product_code\":null,\"product_id\":14,\"quantity\":1,\"unit_price\":200,\"tax_id\":null,\"note\":null,\"vat_amount\":\"26.10\",\"other_taxes_amount\":\"10.00\",\"discount_amount\":\"26.00\",\"total_price\":\"210.00\"}}', NULL, '2025-05-04 17:48:41', '2025-05-04 17:48:41'),
(448, 'default', 'created', 'App\\Models\\Address', 'created', 33, 'App\\Models\\User', 5, '{\"attributes\":{\"id\":33,\"address_type_id\":1,\"addressable_type\":null,\"addressable_id\":null,\"street\":null,\"city\":null,\"state\":null,\"country\":null,\"postal_code\":null,\"country_id\":null,\"contact_person_full_name\":null,\"contact_person_phone\":null,\"latitude\":null,\"longitude\":null,\"details\":null,\"created_at\":\"2025-05-04T17:48:41.000000Z\",\"updated_at\":\"2025-05-04T17:48:41.000000Z\",\"deleted_at\":null}}', NULL, '2025-05-04 17:48:41', '2025-05-04 17:48:41'),
(449, 'default', 'updated', 'App\\Models\\Order', 'updated', 17, 'App\\Models\\User', 5, '{\"attributes\":{\"total\":\"420.00\",\"shipping_address_id\":33},\"old\":{\"total\":\"420.20\",\"shipping_address_id\":null}}', NULL, '2025-05-04 17:48:41', '2025-05-04 17:48:41'),
(450, 'default', 'created', 'App\\Models\\Address', 'created', 34, 'App\\Models\\User', 5, '{\"attributes\":{\"id\":34,\"address_type_id\":2,\"addressable_type\":null,\"addressable_id\":null,\"street\":null,\"city\":null,\"state\":null,\"country\":null,\"postal_code\":null,\"country_id\":null,\"contact_person_full_name\":null,\"contact_person_phone\":null,\"latitude\":null,\"longitude\":null,\"details\":null,\"created_at\":\"2025-05-04T17:48:41.000000Z\",\"updated_at\":\"2025-05-04T17:48:41.000000Z\",\"deleted_at\":null}}', NULL, '2025-05-04 17:48:41', '2025-05-04 17:48:41'),
(451, 'default', 'updated', 'App\\Models\\Order', 'updated', 17, 'App\\Models\\User', 5, '{\"attributes\":{\"total\":\"420.00\",\"billing_address_id\":34},\"old\":{\"total\":\"420.20\",\"billing_address_id\":null}}', NULL, '2025-05-04 17:48:41', '2025-05-04 17:48:41'),
(452, 'default', 'updated', 'App\\Models\\Product', 'updated', 16, 'App\\Models\\User', 5, '{\"attributes\":{\"quantity\":49,\"updated_at\":\"2025-05-04T17:48:41.000000Z\"},\"old\":{\"quantity\":50,\"updated_at\":\"2025-05-04T14:02:38.000000Z\"}}', NULL, '2025-05-04 17:48:41', '2025-05-04 17:48:41'),
(453, 'default', 'updated', 'App\\Models\\Product', 'updated', 14, 'App\\Models\\User', 5, '{\"attributes\":{\"quantity\":6,\"updated_at\":\"2025-05-04T17:48:41.000000Z\"},\"old\":{\"quantity\":7,\"updated_at\":\"2025-05-04T17:12:24.000000Z\"}}', NULL, '2025-05-04 17:48:41', '2025-05-04 17:48:41'),
(454, 'default', 'created', 'App\\Models\\Invoice', 'created', 7, 'App\\Models\\User', 5, '{\"attributes\":{\"id\":7,\"number\":\"C003-INV-000007\",\"order_id\":17,\"company_id\":3,\"point_of_sale_id\":7,\"customer_id\":10,\"issued_by_user\":5,\"customer_name\":\"Guest Customer\",\"customer_email\":\"guest@gmail.com\",\"customer_phone\":null,\"subtotal\":400,\"discount\":52,\"vat\":52.2,\"other_taxes\":20,\"total\":420,\"amount_paid\":420,\"due_date\":\"2025-06-03T17:54:53.000000Z\",\"paid_date\":null,\"issue_date\":\"2025-05-04T17:54:53.000000Z\",\"meta\":null,\"billing_address_id\":null,\"shipping_address_id\":null,\"invoice_status_id\":1,\"currency_id\":null,\"created_at\":\"2025-05-04T17:54:53.000000Z\",\"updated_at\":\"2025-05-04T17:54:53.000000Z\",\"deleted_at\":null}}', NULL, '2025-05-04 17:54:53', '2025-05-04 17:54:53'),
(455, 'default', 'created', 'App\\Models\\InvoiceItem', 'created', 90, 'App\\Models\\User', 5, '{\"attributes\":{\"id\":90,\"invoice_id\":7,\"product_name_en\":\"Helmets\",\"product_name_ar\":\"\\u0627\\u0644\\u062e\\u0648\\u0630\",\"product_description_en\":null,\"product_description_ar\":null,\"product_sku\":null,\"product_code\":null,\"quantity\":1,\"unit_price\":200,\"tax_id\":null,\"discount_amount\":26,\"created_at\":\"2025-05-04T17:54:53.000000Z\",\"updated_at\":\"2025-05-04T17:54:53.000000Z\",\"deleted_at\":null,\"note\":null,\"vat_amount\":26.1,\"other_taxes_amount\":10,\"total_price\":210}}', NULL, '2025-05-04 17:54:53', '2025-05-04 17:54:53'),
(456, 'default', 'created', 'App\\Models\\InvoiceItem', 'created', 91, 'App\\Models\\User', 5, '{\"attributes\":{\"id\":91,\"invoice_id\":7,\"product_name_en\":\"Cement\",\"product_name_ar\":\"\\u0627\\u0644\\u0623\\u0633\\u0645\\u0646\\u062a\",\"product_description_en\":null,\"product_description_ar\":null,\"product_sku\":null,\"product_code\":null,\"quantity\":1,\"unit_price\":200,\"tax_id\":null,\"discount_amount\":26,\"created_at\":\"2025-05-04T17:54:53.000000Z\",\"updated_at\":\"2025-05-04T17:54:53.000000Z\",\"deleted_at\":null,\"note\":null,\"vat_amount\":26.1,\"other_taxes_amount\":10,\"total_price\":210}}', NULL, '2025-05-04 17:54:53', '2025-05-04 17:54:53'),
(457, 'default', 'created', 'App\\Models\\ProductCategory', 'created', 11, 'App\\Models\\User', 5, '{\"attributes\":{\"id\":11,\"company_id\":3,\"point_of_sale_id\":7,\"name_en\":\"testing\",\"name_ar\":\"fdsjal\",\"description_en\":null,\"description_ar\":null,\"slug\":\"testing\",\"parent_id\":null,\"is_active\":1,\"created_at\":\"2025-05-04T19:11:26.000000Z\",\"updated_at\":\"2025-05-04T19:11:26.000000Z\",\"deleted_at\":null}}', NULL, '2025-05-04 19:11:26', '2025-05-04 19:11:26'),
(458, 'default', 'created', 'App\\Models\\Product', 'created', 20, 'App\\Models\\User', 5, '{\"attributes\":{\"id\":20,\"company_id\":3,\"name_en\":\"testing\",\"name_ar\":\"gisdn\",\"description_en\":null,\"description_ar\":null,\"slug\":\"gisdn\",\"sku\":null,\"code\":null,\"price\":10,\"quantity\":10,\"sale_price\":11.5,\"currency_id\":1,\"product_category_id\":11,\"point_of_sale_id\":7,\"image_url\":null,\"is_active\":true,\"created_at\":\"2025-05-04T19:11:56.000000Z\",\"updated_at\":\"2025-05-04T19:11:56.000000Z\",\"deleted_at\":null}}', NULL, '2025-05-04 19:11:56', '2025-05-04 19:11:56'),
(459, 'default', 'created', 'App\\Models\\Product', 'created', 21, 'App\\Models\\User', 5, '{\"attributes\":{\"id\":21,\"company_id\":3,\"name_en\":\"Testing\",\"name_ar\":\"Testing\",\"description_en\":null,\"description_ar\":null,\"slug\":\"tesitng\",\"sku\":null,\"code\":null,\"price\":20,\"quantity\":0,\"sale_price\":23,\"currency_id\":1,\"product_category_id\":9,\"point_of_sale_id\":7,\"image_url\":null,\"is_active\":true,\"created_at\":\"2025-05-04T19:19:13.000000Z\",\"updated_at\":\"2025-05-04T19:19:13.000000Z\",\"deleted_at\":null}}', NULL, '2025-05-04 19:19:13', '2025-05-04 19:19:13'),
(460, 'default', 'created', 'App\\Models\\Customer', 'created', 12, 'App\\Models\\User', 5, '{\"attributes\":{\"id\":12,\"first_name\":\"Testing\",\"last_name\":\"Cusomer\",\"email\":null,\"phone_number\":\"797987\",\"company_id\":3,\"is_active\":true,\"meta\":null,\"created_at\":\"2025-05-04T19:20:00.000000Z\",\"updated_at\":\"2025-05-04T19:20:00.000000Z\",\"deleted_at\":null,\"vat_number\":null,\"address\":null,\"point_of_sale_id\":7}}', NULL, '2025-05-04 19:20:00', '2025-05-04 19:20:00'),
(461, 'default', 'created', 'App\\Models\\Order', 'created', 18, 'App\\Models\\User', 5, '{\"attributes\":{\"number\":\"ORD-202505-BHZ2FP\",\"customer_id\":10,\"customer_name\":null,\"customer_email\":null,\"customer_phone_number\":null,\"user_id\":5,\"company_id\":3,\"order_status_id\":1,\"shipping_fee\":null,\"subtotal\":\"200.00\",\"vat\":\"25.50\",\"other_taxes\":\"10.00\",\"discount\":\"30.00\",\"total\":\"206.00\",\"amount_paid\":\"205.50\",\"payment_method_id\":4,\"currency_id\":1,\"billing_address_id\":null,\"shipping_address_id\":null,\"estimated_delivery_at\":null,\"delivered_at\":null,\"shipped_at\":null,\"meta\":[],\"point_of_sale_id\":7}}', NULL, '2025-05-04 19:27:53', '2025-05-04 19:27:53'),
(462, 'default', 'created', 'App\\Models\\OrderItem', 'created', 39, 'App\\Models\\User', 5, '{\"attributes\":{\"order_id\":18,\"product_name_en\":\"Hinges\",\"product_name_ar\":\"\\u0627\\u0644\\u0645\\u0641\\u0635\\u0644\\u0627\\u062a\",\"product_description_en\":null,\"product_description_ar\":null,\"product_sku\":null,\"product_code\":null,\"product_id\":18,\"quantity\":2,\"unit_price\":100,\"tax_id\":null,\"note\":null,\"vat_amount\":\"12.75\",\"other_taxes_amount\":\"5.00\",\"discount_amount\":\"30.00\",\"total_price\":\"206.00\"}}', NULL, '2025-05-04 19:27:53', '2025-05-04 19:27:53'),
(463, 'default', 'created', 'App\\Models\\Address', 'created', 35, 'App\\Models\\User', 5, '{\"attributes\":{\"id\":35,\"address_type_id\":1,\"addressable_type\":null,\"addressable_id\":null,\"street\":null,\"city\":null,\"state\":null,\"country\":null,\"postal_code\":null,\"country_id\":null,\"contact_person_full_name\":null,\"contact_person_phone\":null,\"latitude\":null,\"longitude\":null,\"details\":null,\"created_at\":\"2025-05-04T19:27:53.000000Z\",\"updated_at\":\"2025-05-04T19:27:53.000000Z\",\"deleted_at\":null}}', NULL, '2025-05-04 19:27:53', '2025-05-04 19:27:53'),
(464, 'default', 'updated', 'App\\Models\\Order', 'updated', 18, 'App\\Models\\User', 5, '{\"attributes\":{\"total\":\"206.00\",\"shipping_address_id\":35},\"old\":{\"total\":\"205.50\",\"shipping_address_id\":null}}', NULL, '2025-05-04 19:27:53', '2025-05-04 19:27:53'),
(465, 'default', 'created', 'App\\Models\\Address', 'created', 36, 'App\\Models\\User', 5, '{\"attributes\":{\"id\":36,\"address_type_id\":2,\"addressable_type\":null,\"addressable_id\":null,\"street\":null,\"city\":null,\"state\":null,\"country\":null,\"postal_code\":null,\"country_id\":null,\"contact_person_full_name\":null,\"contact_person_phone\":null,\"latitude\":null,\"longitude\":null,\"details\":null,\"created_at\":\"2025-05-04T19:27:53.000000Z\",\"updated_at\":\"2025-05-04T19:27:53.000000Z\",\"deleted_at\":null}}', NULL, '2025-05-04 19:27:53', '2025-05-04 19:27:53'),
(466, 'default', 'updated', 'App\\Models\\Order', 'updated', 18, 'App\\Models\\User', 5, '{\"attributes\":{\"total\":\"206.00\",\"billing_address_id\":36},\"old\":{\"total\":\"205.50\",\"billing_address_id\":null}}', NULL, '2025-05-04 19:27:53', '2025-05-04 19:27:53'),
(467, 'default', 'updated', 'App\\Models\\Product', 'updated', 18, 'App\\Models\\User', 5, '{\"attributes\":{\"quantity\":6,\"updated_at\":\"2025-05-04T19:27:53.000000Z\"},\"old\":{\"quantity\":8,\"updated_at\":\"2025-05-04T15:55:40.000000Z\"}}', NULL, '2025-05-04 19:27:53', '2025-05-04 19:27:53'),
(468, 'default', 'created', 'App\\Models\\Order', 'created', 19, 'App\\Models\\User', 5, '{\"attributes\":{\"number\":\"ORD-202505-UT04CI\",\"customer_id\":10,\"customer_name\":null,\"customer_email\":null,\"customer_phone_number\":null,\"user_id\":5,\"company_id\":3,\"order_status_id\":1,\"shipping_fee\":null,\"subtotal\":\"100.00\",\"vat\":\"15.00\",\"other_taxes\":\"0.00\",\"discount\":\"0.00\",\"total\":\"115.00\",\"amount_paid\":\"0.00\",\"payment_method_id\":4,\"currency_id\":1,\"billing_address_id\":null,\"shipping_address_id\":null,\"estimated_delivery_at\":null,\"delivered_at\":null,\"shipped_at\":null,\"meta\":[],\"point_of_sale_id\":7}}', NULL, '2025-05-05 09:49:07', '2025-05-05 09:49:07'),
(469, 'default', 'created', 'App\\Models\\OrderItem', 'created', 40, 'App\\Models\\User', 5, '{\"attributes\":{\"order_id\":19,\"product_name_en\":\"Cement\",\"product_name_ar\":\"\\u0627\\u0644\\u0623\\u0633\\u0645\\u0646\\u062a\",\"product_description_en\":null,\"product_description_ar\":null,\"product_sku\":null,\"product_code\":null,\"product_id\":14,\"quantity\":1,\"unit_price\":100,\"tax_id\":null,\"note\":null,\"vat_amount\":\"15.00\",\"other_taxes_amount\":\"0.00\",\"discount_amount\":\"0.00\",\"total_price\":\"115.00\"}}', NULL, '2025-05-05 09:49:07', '2025-05-05 09:49:07'),
(470, 'default', 'created', 'App\\Models\\Address', 'created', 37, 'App\\Models\\User', 5, '{\"attributes\":{\"id\":37,\"address_type_id\":1,\"addressable_type\":null,\"addressable_id\":null,\"street\":null,\"city\":null,\"state\":null,\"country\":null,\"postal_code\":null,\"country_id\":null,\"contact_person_full_name\":null,\"contact_person_phone\":null,\"latitude\":null,\"longitude\":null,\"details\":null,\"created_at\":\"2025-05-05T09:49:07.000000Z\",\"updated_at\":\"2025-05-05T09:49:07.000000Z\",\"deleted_at\":null}}', NULL, '2025-05-05 09:49:07', '2025-05-05 09:49:07'),
(471, 'default', 'updated', 'App\\Models\\Order', 'updated', 19, 'App\\Models\\User', 5, '{\"attributes\":{\"shipping_address_id\":37},\"old\":{\"shipping_address_id\":null}}', NULL, '2025-05-05 09:49:07', '2025-05-05 09:49:07'),
(472, 'default', 'created', 'App\\Models\\Address', 'created', 38, 'App\\Models\\User', 5, '{\"attributes\":{\"id\":38,\"address_type_id\":2,\"addressable_type\":null,\"addressable_id\":null,\"street\":null,\"city\":null,\"state\":null,\"country\":null,\"postal_code\":null,\"country_id\":null,\"contact_person_full_name\":null,\"contact_person_phone\":null,\"latitude\":null,\"longitude\":null,\"details\":null,\"created_at\":\"2025-05-05T09:49:07.000000Z\",\"updated_at\":\"2025-05-05T09:49:07.000000Z\",\"deleted_at\":null}}', NULL, '2025-05-05 09:49:07', '2025-05-05 09:49:07'),
(473, 'default', 'updated', 'App\\Models\\Order', 'updated', 19, 'App\\Models\\User', 5, '{\"attributes\":{\"billing_address_id\":38},\"old\":{\"billing_address_id\":null}}', NULL, '2025-05-05 09:49:07', '2025-05-05 09:49:07'),
(474, 'default', 'updated', 'App\\Models\\Product', 'updated', 14, 'App\\Models\\User', 5, '{\"attributes\":{\"quantity\":5,\"updated_at\":\"2025-05-05T09:49:07.000000Z\"},\"old\":{\"quantity\":6,\"updated_at\":\"2025-05-04T17:48:41.000000Z\"}}', NULL, '2025-05-05 09:49:07', '2025-05-05 09:49:07'),
(475, 'default', 'created', 'App\\Models\\Order', 'created', 20, 'App\\Models\\User', 5, '{\"attributes\":{\"number\":\"ORD-202505-2XN2LI\",\"customer_id\":10,\"customer_name\":null,\"customer_email\":null,\"customer_phone_number\":null,\"user_id\":5,\"company_id\":3,\"order_status_id\":1,\"shipping_fee\":null,\"subtotal\":\"100.00\",\"vat\":\"15.00\",\"other_taxes\":\"0.00\",\"discount\":\"0.00\",\"total\":\"115.00\",\"amount_paid\":\"0.00\",\"payment_method_id\":4,\"currency_id\":1,\"billing_address_id\":null,\"shipping_address_id\":null,\"estimated_delivery_at\":null,\"delivered_at\":null,\"shipped_at\":null,\"meta\":[],\"point_of_sale_id\":7}}', NULL, '2025-05-05 09:49:50', '2025-05-05 09:49:50'),
(476, 'default', 'created', 'App\\Models\\OrderItem', 'created', 41, 'App\\Models\\User', 5, '{\"attributes\":{\"order_id\":20,\"product_name_en\":\"Cement\",\"product_name_ar\":\"\\u0627\\u0644\\u0623\\u0633\\u0645\\u0646\\u062a\",\"product_description_en\":null,\"product_description_ar\":null,\"product_sku\":null,\"product_code\":null,\"product_id\":14,\"quantity\":1,\"unit_price\":100,\"tax_id\":null,\"note\":null,\"vat_amount\":\"15.00\",\"other_taxes_amount\":\"0.00\",\"discount_amount\":\"0.00\",\"total_price\":\"115.00\"}}', NULL, '2025-05-05 09:49:50', '2025-05-05 09:49:50'),
(477, 'default', 'created', 'App\\Models\\Address', 'created', 39, 'App\\Models\\User', 5, '{\"attributes\":{\"id\":39,\"address_type_id\":1,\"addressable_type\":null,\"addressable_id\":null,\"street\":null,\"city\":null,\"state\":null,\"country\":null,\"postal_code\":null,\"country_id\":null,\"contact_person_full_name\":null,\"contact_person_phone\":null,\"latitude\":null,\"longitude\":null,\"details\":null,\"created_at\":\"2025-05-05T09:49:50.000000Z\",\"updated_at\":\"2025-05-05T09:49:50.000000Z\",\"deleted_at\":null}}', NULL, '2025-05-05 09:49:50', '2025-05-05 09:49:50'),
(478, 'default', 'updated', 'App\\Models\\Order', 'updated', 20, 'App\\Models\\User', 5, '{\"attributes\":{\"shipping_address_id\":39},\"old\":{\"shipping_address_id\":null}}', NULL, '2025-05-05 09:49:50', '2025-05-05 09:49:50'),
(479, 'default', 'created', 'App\\Models\\Address', 'created', 40, 'App\\Models\\User', 5, '{\"attributes\":{\"id\":40,\"address_type_id\":2,\"addressable_type\":null,\"addressable_id\":null,\"street\":null,\"city\":null,\"state\":null,\"country\":null,\"postal_code\":null,\"country_id\":null,\"contact_person_full_name\":null,\"contact_person_phone\":null,\"latitude\":null,\"longitude\":null,\"details\":null,\"created_at\":\"2025-05-05T09:49:51.000000Z\",\"updated_at\":\"2025-05-05T09:49:51.000000Z\",\"deleted_at\":null}}', NULL, '2025-05-05 09:49:51', '2025-05-05 09:49:51'),
(480, 'default', 'updated', 'App\\Models\\Order', 'updated', 20, 'App\\Models\\User', 5, '{\"attributes\":{\"billing_address_id\":40},\"old\":{\"billing_address_id\":null}}', NULL, '2025-05-05 09:49:51', '2025-05-05 09:49:51'),
(481, 'default', 'updated', 'App\\Models\\Product', 'updated', 14, 'App\\Models\\User', 5, '{\"attributes\":{\"quantity\":4,\"updated_at\":\"2025-05-05T09:49:51.000000Z\"},\"old\":{\"quantity\":5,\"updated_at\":\"2025-05-05T09:49:07.000000Z\"}}', NULL, '2025-05-05 09:49:51', '2025-05-05 09:49:51'),
(482, 'default', 'created', 'App\\Models\\Order', 'created', 21, 'App\\Models\\User', 5, '{\"attributes\":{\"number\":\"ORD-202505-EKIJ7J\",\"customer_id\":10,\"customer_name\":null,\"customer_email\":null,\"customer_phone_number\":null,\"user_id\":5,\"company_id\":3,\"order_status_id\":1,\"shipping_fee\":null,\"subtotal\":null,\"vat\":\"30.00\",\"other_taxes\":null,\"discount\":\"400.00\",\"discount_type\":\"fixed\",\"discount_totals\":\"0.00\",\"total\":\"230.00\",\"amount_paid\":\"0.00\",\"payment_method_id\":4,\"currency_id\":1,\"billing_address_id\":null,\"shipping_address_id\":null,\"estimated_delivery_at\":null,\"delivered_at\":null,\"shipped_at\":null,\"meta\":[],\"point_of_sale_id\":7}}', NULL, '2025-05-05 11:53:57', '2025-05-05 11:53:57'),
(483, 'default', 'created', 'App\\Models\\OrderItem', 'created', 42, 'App\\Models\\User', 5, '{\"attributes\":{\"order_id\":21,\"product_name_en\":\"Helmets\",\"product_name_ar\":\"\\u0627\\u0644\\u062e\\u0648\\u0630\",\"product_description_en\":null,\"product_description_ar\":null,\"product_sku\":null,\"product_code\":null,\"product_id\":16,\"quantity\":2,\"tax_id\":null,\"note\":\"it has 2 quantities each unit of 200\",\"unit_price\":200,\"vat_amount\":\"15.00\",\"other_taxes_amount\":\"0.00\",\"discount_amount\":\"50.00\",\"discount_type\":\"percentage\",\"total_price\":\"230.00\"}}', NULL, '2025-05-05 11:53:57', '2025-05-05 11:53:57'),
(484, 'default', 'created', 'App\\Models\\OrderItem', 'created', 43, 'App\\Models\\User', 5, '{\"attributes\":{\"order_id\":21,\"product_name_en\":\"Hinges\",\"product_name_ar\":\"\\u0627\\u0644\\u0645\\u0641\\u0635\\u0644\\u0627\\u062a\",\"product_description_en\":null,\"product_description_ar\":null,\"product_sku\":null,\"product_code\":null,\"product_id\":18,\"quantity\":1,\"tax_id\":null,\"note\":\"it has 1 quantity of price 400\",\"unit_price\":400,\"vat_amount\":\"30.00\",\"other_taxes_amount\":\"0.00\",\"discount_amount\":\"50.00\",\"discount_type\":\"percentage\",\"total_price\":\"230.00\"}}', NULL, '2025-05-05 11:53:57', '2025-05-05 11:53:57'),
(485, 'default', 'created', 'App\\Models\\Address', 'created', 41, 'App\\Models\\User', 5, '{\"attributes\":{\"id\":41,\"address_type_id\":1,\"addressable_type\":null,\"addressable_id\":null,\"street\":null,\"city\":null,\"state\":null,\"country\":null,\"postal_code\":null,\"country_id\":null,\"contact_person_full_name\":null,\"contact_person_phone\":null,\"latitude\":null,\"longitude\":null,\"details\":null,\"created_at\":\"2025-05-05T11:53:57.000000Z\",\"updated_at\":\"2025-05-05T11:53:57.000000Z\",\"deleted_at\":null}}', NULL, '2025-05-05 11:53:57', '2025-05-05 11:53:57'),
(486, 'default', 'updated', 'App\\Models\\Order', 'updated', 21, 'App\\Models\\User', 5, '{\"attributes\":{\"discount_type\":\"fixed\",\"discount_totals\":\"0.00\",\"shipping_address_id\":41},\"old\":{\"discount_type\":null,\"discount_totals\":null,\"shipping_address_id\":null}}', NULL, '2025-05-05 11:53:57', '2025-05-05 11:53:57'),
(487, 'default', 'created', 'App\\Models\\Address', 'created', 42, 'App\\Models\\User', 5, '{\"attributes\":{\"id\":42,\"address_type_id\":2,\"addressable_type\":null,\"addressable_id\":null,\"street\":null,\"city\":null,\"state\":null,\"country\":null,\"postal_code\":null,\"country_id\":null,\"contact_person_full_name\":null,\"contact_person_phone\":null,\"latitude\":null,\"longitude\":null,\"details\":null,\"created_at\":\"2025-05-05T11:53:57.000000Z\",\"updated_at\":\"2025-05-05T11:53:57.000000Z\",\"deleted_at\":null}}', NULL, '2025-05-05 11:53:57', '2025-05-05 11:53:57'),
(488, 'default', 'updated', 'App\\Models\\Order', 'updated', 21, 'App\\Models\\User', 5, '{\"attributes\":{\"discount_type\":\"fixed\",\"discount_totals\":\"0.00\",\"billing_address_id\":42},\"old\":{\"discount_type\":null,\"discount_totals\":null,\"billing_address_id\":null}}', NULL, '2025-05-05 11:53:57', '2025-05-05 11:53:57'),
(489, 'default', 'updated', 'App\\Models\\Product', 'updated', 16, 'App\\Models\\User', 5, '{\"attributes\":{\"quantity\":47,\"updated_at\":\"2025-05-05T11:53:57.000000Z\"},\"old\":{\"quantity\":49,\"updated_at\":\"2025-05-04T17:48:41.000000Z\"}}', NULL, '2025-05-05 11:53:57', '2025-05-05 11:53:57'),
(490, 'default', 'updated', 'App\\Models\\Product', 'updated', 18, 'App\\Models\\User', 5, '{\"attributes\":{\"quantity\":5,\"updated_at\":\"2025-05-05T11:53:57.000000Z\"},\"old\":{\"quantity\":6,\"updated_at\":\"2025-05-04T19:27:53.000000Z\"}}', NULL, '2025-05-05 11:53:57', '2025-05-05 11:53:57'),
(491, 'default', 'created', 'App\\Models\\Order', 'created', 22, 'App\\Models\\User', 5, '{\"attributes\":{\"number\":\"ORD-202505-06WUB3\",\"customer_id\":10,\"customer_name\":null,\"customer_email\":null,\"customer_phone_number\":null,\"user_id\":5,\"company_id\":3,\"order_status_id\":1,\"shipping_fee\":null,\"subtotal\":null,\"vat\":\"30.00\",\"other_taxes\":null,\"discount\":\"50.00\",\"discount_type\":\"fixed\",\"discount_totals\":\"0.00\",\"total\":\"230.00\",\"amount_paid\":\"230.00\",\"payment_method_id\":4,\"currency_id\":1,\"billing_address_id\":null,\"shipping_address_id\":null,\"estimated_delivery_at\":null,\"delivered_at\":null,\"shipped_at\":null,\"meta\":[],\"point_of_sale_id\":7}}', NULL, '2025-05-05 12:29:12', '2025-05-05 12:29:12'),
(492, 'default', 'created', 'App\\Models\\OrderItem', 'created', 44, 'App\\Models\\User', 5, '{\"attributes\":{\"order_id\":22,\"product_name_en\":\"Helmets\",\"product_name_ar\":\"\\u0627\\u0644\\u062e\\u0648\\u0630\",\"product_description_en\":null,\"product_description_ar\":null,\"product_sku\":null,\"product_code\":null,\"product_id\":16,\"quantity\":2,\"tax_id\":null,\"note\":null,\"unit_price\":200,\"vat_amount\":\"15.00\",\"other_taxes_amount\":\"0.00\",\"discount_amount\":\"50.00\",\"discount_type\":\"percentage\",\"total_price\":\"230.00\"}}', NULL, '2025-05-05 12:29:12', '2025-05-05 12:29:12'),
(493, 'default', 'created', 'App\\Models\\OrderItem', 'created', 45, 'App\\Models\\User', 5, '{\"attributes\":{\"order_id\":22,\"product_name_en\":\"Anchors\",\"product_name_ar\":\"\\u0627\\u0644\\u0645\\u0631\\u0627\\u0628\\u0637\",\"product_description_en\":null,\"product_description_ar\":null,\"product_sku\":null,\"product_code\":null,\"product_id\":19,\"quantity\":1,\"tax_id\":null,\"note\":null,\"unit_price\":400,\"vat_amount\":\"30.00\",\"other_taxes_amount\":\"0.00\",\"discount_amount\":\"50.00\",\"discount_type\":\"percentage\",\"total_price\":\"230.00\"}}', NULL, '2025-05-05 12:29:12', '2025-05-05 12:29:12'),
(494, 'default', 'created', 'App\\Models\\Address', 'created', 43, 'App\\Models\\User', 5, '{\"attributes\":{\"id\":43,\"address_type_id\":1,\"addressable_type\":null,\"addressable_id\":null,\"street\":null,\"city\":null,\"state\":null,\"country\":null,\"postal_code\":null,\"country_id\":null,\"contact_person_full_name\":null,\"contact_person_phone\":null,\"latitude\":null,\"longitude\":null,\"details\":null,\"created_at\":\"2025-05-05T12:29:12.000000Z\",\"updated_at\":\"2025-05-05T12:29:12.000000Z\",\"deleted_at\":null}}', NULL, '2025-05-05 12:29:12', '2025-05-05 12:29:12'),
(495, 'default', 'updated', 'App\\Models\\Order', 'updated', 22, 'App\\Models\\User', 5, '{\"attributes\":{\"discount_type\":\"fixed\",\"discount_totals\":\"0.00\",\"shipping_address_id\":43},\"old\":{\"discount_type\":null,\"discount_totals\":null,\"shipping_address_id\":null}}', NULL, '2025-05-05 12:29:12', '2025-05-05 12:29:12'),
(496, 'default', 'created', 'App\\Models\\Address', 'created', 44, 'App\\Models\\User', 5, '{\"attributes\":{\"id\":44,\"address_type_id\":2,\"addressable_type\":null,\"addressable_id\":null,\"street\":null,\"city\":null,\"state\":null,\"country\":null,\"postal_code\":null,\"country_id\":null,\"contact_person_full_name\":null,\"contact_person_phone\":null,\"latitude\":null,\"longitude\":null,\"details\":null,\"created_at\":\"2025-05-05T12:29:12.000000Z\",\"updated_at\":\"2025-05-05T12:29:12.000000Z\",\"deleted_at\":null}}', NULL, '2025-05-05 12:29:12', '2025-05-05 12:29:12'),
(497, 'default', 'updated', 'App\\Models\\Order', 'updated', 22, 'App\\Models\\User', 5, '{\"attributes\":{\"discount_type\":\"fixed\",\"discount_totals\":\"0.00\",\"billing_address_id\":44},\"old\":{\"discount_type\":null,\"discount_totals\":null,\"billing_address_id\":null}}', NULL, '2025-05-05 12:29:12', '2025-05-05 12:29:12'),
(498, 'default', 'updated', 'App\\Models\\Product', 'updated', 16, 'App\\Models\\User', 5, '{\"attributes\":{\"quantity\":45,\"updated_at\":\"2025-05-05T12:29:12.000000Z\"},\"old\":{\"quantity\":47,\"updated_at\":\"2025-05-05T11:53:57.000000Z\"}}', NULL, '2025-05-05 12:29:12', '2025-05-05 12:29:12'),
(499, 'default', 'updated', 'App\\Models\\Product', 'updated', 19, 'App\\Models\\User', 5, '{\"attributes\":{\"quantity\":24,\"updated_at\":\"2025-05-05T12:29:12.000000Z\"},\"old\":{\"quantity\":25,\"updated_at\":\"2025-05-04T14:16:41.000000Z\"}}', NULL, '2025-05-05 12:29:12', '2025-05-05 12:29:12'),
(500, 'default', 'created', 'App\\Models\\Order', 'created', 23, 'App\\Models\\User', 5, '{\"attributes\":{\"number\":\"ORD-202505-EEP4PR\",\"customer_id\":10,\"customer_name\":null,\"customer_email\":null,\"customer_phone_number\":null,\"user_id\":5,\"company_id\":3,\"order_status_id\":1,\"shipping_fee\":null,\"subtotal\":null,\"vat\":\"30.00\",\"other_taxes\":null,\"discount\":\"50.00\",\"discount_type\":\"fixed\",\"discount_totals\":\"0.00\",\"total\":\"230.00\",\"amount_paid\":\"0.00\",\"payment_method_id\":4,\"currency_id\":1,\"billing_address_id\":null,\"shipping_address_id\":null,\"estimated_delivery_at\":null,\"delivered_at\":null,\"shipped_at\":null,\"meta\":[],\"point_of_sale_id\":7}}', NULL, '2025-05-05 12:33:24', '2025-05-05 12:33:24'),
(501, 'default', 'created', 'App\\Models\\OrderItem', 'created', 46, 'App\\Models\\User', 5, '{\"attributes\":{\"order_id\":23,\"product_name_en\":\"Cement\",\"product_name_ar\":\"\\u0627\\u0644\\u0623\\u0633\\u0645\\u0646\\u062a\",\"product_description_en\":null,\"product_description_ar\":null,\"product_sku\":null,\"product_code\":null,\"product_id\":14,\"quantity\":2,\"tax_id\":null,\"note\":null,\"unit_price\":200,\"vat_amount\":\"15.00\",\"other_taxes_amount\":\"0.00\",\"discount_amount\":\"50.00\",\"discount_type\":\"percentage\",\"total_price\":\"230.00\"}}', NULL, '2025-05-05 12:33:24', '2025-05-05 12:33:24'),
(502, 'default', 'created', 'App\\Models\\OrderItem', 'created', 47, 'App\\Models\\User', 5, '{\"attributes\":{\"order_id\":23,\"product_name_en\":\"Anchors\",\"product_name_ar\":\"\\u0627\\u0644\\u0645\\u0631\\u0627\\u0628\\u0637\",\"product_description_en\":null,\"product_description_ar\":null,\"product_sku\":null,\"product_code\":null,\"product_id\":19,\"quantity\":1,\"tax_id\":null,\"note\":null,\"unit_price\":400,\"vat_amount\":\"30.00\",\"other_taxes_amount\":\"0.00\",\"discount_amount\":\"50.00\",\"discount_type\":\"percentage\",\"total_price\":\"230.00\"}}', NULL, '2025-05-05 12:33:24', '2025-05-05 12:33:24'),
(503, 'default', 'created', 'App\\Models\\Address', 'created', 45, 'App\\Models\\User', 5, '{\"attributes\":{\"id\":45,\"address_type_id\":1,\"addressable_type\":null,\"addressable_id\":null,\"street\":null,\"city\":null,\"state\":null,\"country\":null,\"postal_code\":null,\"country_id\":null,\"contact_person_full_name\":null,\"contact_person_phone\":null,\"latitude\":null,\"longitude\":null,\"details\":null,\"created_at\":\"2025-05-05T12:33:25.000000Z\",\"updated_at\":\"2025-05-05T12:33:25.000000Z\",\"deleted_at\":null}}', NULL, '2025-05-05 12:33:25', '2025-05-05 12:33:25'),
(504, 'default', 'updated', 'App\\Models\\Order', 'updated', 23, 'App\\Models\\User', 5, '{\"attributes\":{\"discount_type\":\"fixed\",\"discount_totals\":\"0.00\",\"shipping_address_id\":45},\"old\":{\"discount_type\":null,\"discount_totals\":null,\"shipping_address_id\":null}}', NULL, '2025-05-05 12:33:25', '2025-05-05 12:33:25'),
(505, 'default', 'created', 'App\\Models\\Address', 'created', 46, 'App\\Models\\User', 5, '{\"attributes\":{\"id\":46,\"address_type_id\":2,\"addressable_type\":null,\"addressable_id\":null,\"street\":null,\"city\":null,\"state\":null,\"country\":null,\"postal_code\":null,\"country_id\":null,\"contact_person_full_name\":null,\"contact_person_phone\":null,\"latitude\":null,\"longitude\":null,\"details\":null,\"created_at\":\"2025-05-05T12:33:25.000000Z\",\"updated_at\":\"2025-05-05T12:33:25.000000Z\",\"deleted_at\":null}}', NULL, '2025-05-05 12:33:25', '2025-05-05 12:33:25'),
(506, 'default', 'updated', 'App\\Models\\Order', 'updated', 23, 'App\\Models\\User', 5, '{\"attributes\":{\"discount_type\":\"fixed\",\"discount_totals\":\"0.00\",\"billing_address_id\":46},\"old\":{\"discount_type\":null,\"discount_totals\":null,\"billing_address_id\":null}}', NULL, '2025-05-05 12:33:25', '2025-05-05 12:33:25'),
(507, 'default', 'updated', 'App\\Models\\Product', 'updated', 14, 'App\\Models\\User', 5, '{\"attributes\":{\"quantity\":2,\"updated_at\":\"2025-05-05T12:33:25.000000Z\"},\"old\":{\"quantity\":4,\"updated_at\":\"2025-05-05T09:49:51.000000Z\"}}', NULL, '2025-05-05 12:33:25', '2025-05-05 12:33:25'),
(508, 'default', 'updated', 'App\\Models\\Product', 'updated', 19, 'App\\Models\\User', 5, '{\"attributes\":{\"quantity\":23,\"updated_at\":\"2025-05-05T12:33:25.000000Z\"},\"old\":{\"quantity\":24,\"updated_at\":\"2025-05-05T12:29:12.000000Z\"}}', NULL, '2025-05-05 12:33:25', '2025-05-05 12:33:25'),
(509, 'default', 'created', 'App\\Models\\Order', 'created', 24, 'App\\Models\\User', 5, '{\"attributes\":{\"number\":\"ORD-202505-WPJ0OR\",\"customer_id\":10,\"customer_name\":null,\"customer_email\":null,\"customer_phone_number\":null,\"user_id\":5,\"company_id\":3,\"order_status_id\":1,\"shipping_fee\":null,\"subtotal\":null,\"vat\":\"30.00\",\"other_taxes\":null,\"discount\":\"50.00\",\"discount_type\":\"fixed\",\"discount_totals\":\"0.00\",\"total\":\"230.00\",\"amount_paid\":\"0.00\",\"payment_method_id\":4,\"currency_id\":1,\"billing_address_id\":null,\"shipping_address_id\":null,\"estimated_delivery_at\":null,\"delivered_at\":null,\"shipped_at\":null,\"meta\":[],\"point_of_sale_id\":7}}', NULL, '2025-05-05 12:34:57', '2025-05-05 12:34:57'),
(510, 'default', 'created', 'App\\Models\\OrderItem', 'created', 48, 'App\\Models\\User', 5, '{\"attributes\":{\"order_id\":24,\"product_name_en\":\"Helmets\",\"product_name_ar\":\"\\u0627\\u0644\\u062e\\u0648\\u0630\",\"product_description_en\":null,\"product_description_ar\":null,\"product_sku\":null,\"product_code\":null,\"product_id\":16,\"quantity\":2,\"tax_id\":null,\"note\":null,\"unit_price\":200,\"vat_amount\":\"15.00\",\"other_taxes_amount\":\"0.00\",\"discount_amount\":\"50.00\",\"discount_type\":\"percentage\",\"total_price\":\"230.00\"}}', NULL, '2025-05-05 12:34:57', '2025-05-05 12:34:57'),
(511, 'default', 'created', 'App\\Models\\OrderItem', 'created', 49, 'App\\Models\\User', 5, '{\"attributes\":{\"order_id\":24,\"product_name_en\":\"Anchors\",\"product_name_ar\":\"\\u0627\\u0644\\u0645\\u0631\\u0627\\u0628\\u0637\",\"product_description_en\":null,\"product_description_ar\":null,\"product_sku\":null,\"product_code\":null,\"product_id\":19,\"quantity\":1,\"tax_id\":null,\"note\":null,\"unit_price\":400,\"vat_amount\":\"30.00\",\"other_taxes_amount\":\"0.00\",\"discount_amount\":\"50.00\",\"discount_type\":\"percentage\",\"total_price\":\"230.00\"}}', NULL, '2025-05-05 12:34:57', '2025-05-05 12:34:57'),
(512, 'default', 'created', 'App\\Models\\Address', 'created', 47, 'App\\Models\\User', 5, '{\"attributes\":{\"id\":47,\"address_type_id\":1,\"addressable_type\":null,\"addressable_id\":null,\"street\":null,\"city\":null,\"state\":null,\"country\":null,\"postal_code\":null,\"country_id\":null,\"contact_person_full_name\":null,\"contact_person_phone\":null,\"latitude\":null,\"longitude\":null,\"details\":null,\"created_at\":\"2025-05-05T12:34:57.000000Z\",\"updated_at\":\"2025-05-05T12:34:57.000000Z\",\"deleted_at\":null}}', NULL, '2025-05-05 12:34:57', '2025-05-05 12:34:57'),
(513, 'default', 'updated', 'App\\Models\\Order', 'updated', 24, 'App\\Models\\User', 5, '{\"attributes\":{\"discount_type\":\"fixed\",\"discount_totals\":\"0.00\",\"shipping_address_id\":47},\"old\":{\"discount_type\":null,\"discount_totals\":null,\"shipping_address_id\":null}}', NULL, '2025-05-05 12:34:57', '2025-05-05 12:34:57'),
(514, 'default', 'created', 'App\\Models\\Address', 'created', 48, 'App\\Models\\User', 5, '{\"attributes\":{\"id\":48,\"address_type_id\":2,\"addressable_type\":null,\"addressable_id\":null,\"street\":null,\"city\":null,\"state\":null,\"country\":null,\"postal_code\":null,\"country_id\":null,\"contact_person_full_name\":null,\"contact_person_phone\":null,\"latitude\":null,\"longitude\":null,\"details\":null,\"created_at\":\"2025-05-05T12:34:57.000000Z\",\"updated_at\":\"2025-05-05T12:34:57.000000Z\",\"deleted_at\":null}}', NULL, '2025-05-05 12:34:57', '2025-05-05 12:34:57'),
(515, 'default', 'updated', 'App\\Models\\Order', 'updated', 24, 'App\\Models\\User', 5, '{\"attributes\":{\"discount_type\":\"fixed\",\"discount_totals\":\"0.00\",\"billing_address_id\":48},\"old\":{\"discount_type\":null,\"discount_totals\":null,\"billing_address_id\":null}}', NULL, '2025-05-05 12:34:57', '2025-05-05 12:34:57'),
(516, 'default', 'updated', 'App\\Models\\Product', 'updated', 16, 'App\\Models\\User', 5, '{\"attributes\":{\"quantity\":43,\"updated_at\":\"2025-05-05T12:34:57.000000Z\"},\"old\":{\"quantity\":45,\"updated_at\":\"2025-05-05T12:29:12.000000Z\"}}', NULL, '2025-05-05 12:34:57', '2025-05-05 12:34:57'),
(517, 'default', 'updated', 'App\\Models\\Product', 'updated', 19, 'App\\Models\\User', 5, '{\"attributes\":{\"quantity\":22,\"updated_at\":\"2025-05-05T12:34:57.000000Z\"},\"old\":{\"quantity\":23,\"updated_at\":\"2025-05-05T12:33:25.000000Z\"}}', NULL, '2025-05-05 12:34:57', '2025-05-05 12:34:57'),
(518, 'default', 'created', 'App\\Models\\Order', 'created', 25, 'App\\Models\\User', 5, '{\"attributes\":{\"number\":\"ORD-202505-CJBDWS\",\"customer_id\":10,\"customer_name\":null,\"customer_email\":null,\"customer_phone_number\":null,\"user_id\":5,\"company_id\":3,\"order_status_id\":1,\"shipping_fee\":null,\"subtotal\":null,\"vat\":\"30.00\",\"other_taxes\":null,\"discount\":\"200.00\",\"discount_type\":\"fixed\",\"discount_totals\":\"0.00\",\"total\":\"230.00\",\"amount_paid\":\"0.00\",\"payment_method_id\":4,\"currency_id\":1,\"billing_address_id\":null,\"shipping_address_id\":null,\"estimated_delivery_at\":null,\"delivered_at\":null,\"shipped_at\":null,\"meta\":[],\"point_of_sale_id\":7}}', NULL, '2025-05-05 12:49:02', '2025-05-05 12:49:02'),
(519, 'default', 'created', 'App\\Models\\OrderItem', 'created', 50, 'App\\Models\\User', 5, '{\"attributes\":{\"order_id\":25,\"product_name_en\":\"Hinges\",\"product_name_ar\":\"\\u0627\\u0644\\u0645\\u0641\\u0635\\u0644\\u0627\\u062a\",\"product_description_en\":null,\"product_description_ar\":null,\"product_sku\":null,\"product_code\":null,\"product_id\":18,\"quantity\":2,\"tax_id\":null,\"note\":null,\"unit_price\":200,\"vat_amount\":\"15.00\",\"other_taxes_amount\":\"0.00\",\"discount_amount\":\"50.00\",\"discount_type\":\"percentage\",\"total_price\":\"230.00\"}}', NULL, '2025-05-05 12:49:02', '2025-05-05 12:49:02'),
(520, 'default', 'created', 'App\\Models\\Address', 'created', 49, 'App\\Models\\User', 5, '{\"attributes\":{\"id\":49,\"address_type_id\":1,\"addressable_type\":null,\"addressable_id\":null,\"street\":null,\"city\":null,\"state\":null,\"country\":null,\"postal_code\":null,\"country_id\":null,\"contact_person_full_name\":null,\"contact_person_phone\":null,\"latitude\":null,\"longitude\":null,\"details\":null,\"created_at\":\"2025-05-05T12:49:02.000000Z\",\"updated_at\":\"2025-05-05T12:49:02.000000Z\",\"deleted_at\":null}}', NULL, '2025-05-05 12:49:02', '2025-05-05 12:49:02'),
(521, 'default', 'updated', 'App\\Models\\Order', 'updated', 25, 'App\\Models\\User', 5, '{\"attributes\":{\"discount_type\":\"fixed\",\"discount_totals\":\"0.00\",\"shipping_address_id\":49},\"old\":{\"discount_type\":null,\"discount_totals\":null,\"shipping_address_id\":null}}', NULL, '2025-05-05 12:49:02', '2025-05-05 12:49:02'),
(522, 'default', 'created', 'App\\Models\\Address', 'created', 50, 'App\\Models\\User', 5, '{\"attributes\":{\"id\":50,\"address_type_id\":2,\"addressable_type\":null,\"addressable_id\":null,\"street\":null,\"city\":null,\"state\":null,\"country\":null,\"postal_code\":null,\"country_id\":null,\"contact_person_full_name\":null,\"contact_person_phone\":null,\"latitude\":null,\"longitude\":null,\"details\":null,\"created_at\":\"2025-05-05T12:49:02.000000Z\",\"updated_at\":\"2025-05-05T12:49:02.000000Z\",\"deleted_at\":null}}', NULL, '2025-05-05 12:49:02', '2025-05-05 12:49:02'),
(523, 'default', 'updated', 'App\\Models\\Order', 'updated', 25, 'App\\Models\\User', 5, '{\"attributes\":{\"discount_type\":\"fixed\",\"discount_totals\":\"0.00\",\"billing_address_id\":50},\"old\":{\"discount_type\":null,\"discount_totals\":null,\"billing_address_id\":null}}', NULL, '2025-05-05 12:49:02', '2025-05-05 12:49:02'),
(524, 'default', 'updated', 'App\\Models\\Product', 'updated', 18, 'App\\Models\\User', 5, '{\"attributes\":{\"quantity\":3,\"updated_at\":\"2025-05-05T12:49:02.000000Z\"},\"old\":{\"quantity\":5,\"updated_at\":\"2025-05-05T11:53:57.000000Z\"}}', NULL, '2025-05-05 12:49:02', '2025-05-05 12:49:02'),
(525, 'default', 'created', 'App\\Models\\Order', 'created', 26, 'App\\Models\\User', 5, '{\"attributes\":{\"number\":\"ORD-202505-0OKPXK\",\"customer_id\":10,\"customer_name\":null,\"customer_email\":null,\"customer_phone_number\":null,\"user_id\":5,\"company_id\":3,\"order_status_id\":1,\"shipping_fee\":null,\"subtotal\":null,\"vat\":\"30.00\",\"other_taxes\":null,\"discount\":\"200.00\",\"discount_type\":\"fixed\",\"discount_totals\":\"0.00\",\"total\":\"230.00\",\"amount_paid\":\"0.00\",\"payment_method_id\":4,\"currency_id\":1,\"billing_address_id\":null,\"shipping_address_id\":null,\"estimated_delivery_at\":null,\"delivered_at\":null,\"shipped_at\":null,\"meta\":[],\"point_of_sale_id\":7}}', NULL, '2025-05-05 12:51:14', '2025-05-05 12:51:14');
INSERT INTO `activity_logs` (`id`, `log_name`, `description`, `subject_type`, `event`, `subject_id`, `causer_type`, `causer_id`, `properties`, `batch_uuid`, `created_at`, `updated_at`) VALUES
(526, 'default', 'created', 'App\\Models\\OrderItem', 'created', 51, 'App\\Models\\User', 5, '{\"attributes\":{\"order_id\":26,\"product_name_en\":\"Hinges\",\"product_name_ar\":\"\\u0627\\u0644\\u0645\\u0641\\u0635\\u0644\\u0627\\u062a\",\"product_description_en\":null,\"product_description_ar\":null,\"product_sku\":null,\"product_code\":null,\"product_id\":18,\"quantity\":2,\"tax_id\":null,\"note\":null,\"unit_price\":200,\"vat_amount\":\"15.00\",\"other_taxes_amount\":\"0.00\",\"discount_amount\":\"50.00\",\"discount_type\":\"percentage\",\"total_price\":\"230.00\"}}', NULL, '2025-05-05 12:51:14', '2025-05-05 12:51:14'),
(527, 'default', 'created', 'App\\Models\\Address', 'created', 51, 'App\\Models\\User', 5, '{\"attributes\":{\"id\":51,\"address_type_id\":1,\"addressable_type\":null,\"addressable_id\":null,\"street\":null,\"city\":null,\"state\":null,\"country\":null,\"postal_code\":null,\"country_id\":null,\"contact_person_full_name\":null,\"contact_person_phone\":null,\"latitude\":null,\"longitude\":null,\"details\":null,\"created_at\":\"2025-05-05T12:51:14.000000Z\",\"updated_at\":\"2025-05-05T12:51:14.000000Z\",\"deleted_at\":null}}', NULL, '2025-05-05 12:51:14', '2025-05-05 12:51:14'),
(528, 'default', 'updated', 'App\\Models\\Order', 'updated', 26, 'App\\Models\\User', 5, '{\"attributes\":{\"discount_type\":\"fixed\",\"discount_totals\":\"0.00\",\"shipping_address_id\":51},\"old\":{\"discount_type\":null,\"discount_totals\":null,\"shipping_address_id\":null}}', NULL, '2025-05-05 12:51:14', '2025-05-05 12:51:14'),
(529, 'default', 'created', 'App\\Models\\Address', 'created', 52, 'App\\Models\\User', 5, '{\"attributes\":{\"id\":52,\"address_type_id\":2,\"addressable_type\":null,\"addressable_id\":null,\"street\":null,\"city\":null,\"state\":null,\"country\":null,\"postal_code\":null,\"country_id\":null,\"contact_person_full_name\":null,\"contact_person_phone\":null,\"latitude\":null,\"longitude\":null,\"details\":null,\"created_at\":\"2025-05-05T12:51:14.000000Z\",\"updated_at\":\"2025-05-05T12:51:14.000000Z\",\"deleted_at\":null}}', NULL, '2025-05-05 12:51:14', '2025-05-05 12:51:14'),
(530, 'default', 'updated', 'App\\Models\\Order', 'updated', 26, 'App\\Models\\User', 5, '{\"attributes\":{\"discount_type\":\"fixed\",\"discount_totals\":\"0.00\",\"billing_address_id\":52},\"old\":{\"discount_type\":null,\"discount_totals\":null,\"billing_address_id\":null}}', NULL, '2025-05-05 12:51:14', '2025-05-05 12:51:14'),
(531, 'default', 'updated', 'App\\Models\\Product', 'updated', 18, 'App\\Models\\User', 5, '{\"attributes\":{\"quantity\":1,\"updated_at\":\"2025-05-05T12:51:14.000000Z\"},\"old\":{\"quantity\":3,\"updated_at\":\"2025-05-05T12:49:02.000000Z\"}}', NULL, '2025-05-05 12:51:14', '2025-05-05 12:51:14'),
(532, 'default', 'created', 'App\\Models\\Order', 'created', 27, 'App\\Models\\User', 5, '{\"attributes\":{\"number\":\"ORD-202505-7AEQHY\",\"customer_id\":10,\"customer_name\":null,\"customer_email\":null,\"customer_phone_number\":null,\"user_id\":5,\"company_id\":3,\"order_status_id\":1,\"shipping_fee\":null,\"subtotal\":null,\"vat\":\"0.75\",\"other_taxes\":null,\"discount\":\"10.00\",\"discount_type\":\"fixed\",\"discount_totals\":\"0.00\",\"total\":\"6.00\",\"amount_paid\":\"0.00\",\"payment_method_id\":4,\"currency_id\":1,\"billing_address_id\":null,\"shipping_address_id\":null,\"estimated_delivery_at\":null,\"delivered_at\":null,\"shipped_at\":null,\"meta\":[],\"point_of_sale_id\":7}}', NULL, '2025-05-05 13:01:53', '2025-05-05 13:01:53'),
(533, 'default', 'created', 'App\\Models\\OrderItem', 'created', 52, 'App\\Models\\User', 5, '{\"attributes\":{\"order_id\":27,\"product_name_en\":\"Helmets\",\"product_name_ar\":\"\\u0627\\u0644\\u062e\\u0648\\u0630\",\"product_description_en\":null,\"product_description_ar\":null,\"product_sku\":null,\"product_code\":null,\"product_id\":16,\"quantity\":1,\"tax_id\":null,\"note\":null,\"unit_price\":20,\"vat_amount\":\"1.50\",\"other_taxes_amount\":\"0.00\",\"discount_amount\":\"50.00\",\"discount_type\":\"percentage\",\"total_price\":\"12.00\"}}', NULL, '2025-05-05 13:01:53', '2025-05-05 13:01:53'),
(534, 'default', 'created', 'App\\Models\\Address', 'created', 53, 'App\\Models\\User', 5, '{\"attributes\":{\"id\":53,\"address_type_id\":1,\"addressable_type\":null,\"addressable_id\":null,\"street\":null,\"city\":null,\"state\":null,\"country\":null,\"postal_code\":null,\"country_id\":null,\"contact_person_full_name\":null,\"contact_person_phone\":null,\"latitude\":null,\"longitude\":null,\"details\":null,\"created_at\":\"2025-05-05T13:01:53.000000Z\",\"updated_at\":\"2025-05-05T13:01:53.000000Z\",\"deleted_at\":null}}', NULL, '2025-05-05 13:01:53', '2025-05-05 13:01:53'),
(535, 'default', 'updated', 'App\\Models\\Order', 'updated', 27, 'App\\Models\\User', 5, '{\"attributes\":{\"discount_type\":\"fixed\",\"discount_totals\":\"0.00\",\"total\":\"6.00\",\"shipping_address_id\":53},\"old\":{\"discount_type\":null,\"discount_totals\":null,\"total\":\"5.75\",\"shipping_address_id\":null}}', NULL, '2025-05-05 13:01:53', '2025-05-05 13:01:53'),
(536, 'default', 'created', 'App\\Models\\Address', 'created', 54, 'App\\Models\\User', 5, '{\"attributes\":{\"id\":54,\"address_type_id\":2,\"addressable_type\":null,\"addressable_id\":null,\"street\":null,\"city\":null,\"state\":null,\"country\":null,\"postal_code\":null,\"country_id\":null,\"contact_person_full_name\":null,\"contact_person_phone\":null,\"latitude\":null,\"longitude\":null,\"details\":null,\"created_at\":\"2025-05-05T13:01:53.000000Z\",\"updated_at\":\"2025-05-05T13:01:53.000000Z\",\"deleted_at\":null}}', NULL, '2025-05-05 13:01:53', '2025-05-05 13:01:53'),
(537, 'default', 'updated', 'App\\Models\\Order', 'updated', 27, 'App\\Models\\User', 5, '{\"attributes\":{\"discount_type\":\"fixed\",\"discount_totals\":\"0.00\",\"total\":\"6.00\",\"billing_address_id\":54},\"old\":{\"discount_type\":null,\"discount_totals\":null,\"total\":\"5.75\",\"billing_address_id\":null}}', NULL, '2025-05-05 13:01:53', '2025-05-05 13:01:53'),
(538, 'default', 'updated', 'App\\Models\\Product', 'updated', 16, 'App\\Models\\User', 5, '{\"attributes\":{\"quantity\":42,\"updated_at\":\"2025-05-05T13:01:53.000000Z\"},\"old\":{\"quantity\":43,\"updated_at\":\"2025-05-05T12:34:57.000000Z\"}}', NULL, '2025-05-05 13:01:53', '2025-05-05 13:01:53'),
(539, 'default', 'created', 'App\\Models\\Order', 'created', 28, 'App\\Models\\User', 5, '{\"attributes\":{\"number\":\"ORD-202505-TZYKWB\",\"customer_id\":10,\"customer_name\":null,\"customer_email\":null,\"customer_phone_number\":null,\"user_id\":5,\"company_id\":3,\"order_status_id\":1,\"shipping_fee\":null,\"subtotal\":null,\"vat\":\"15.00\",\"other_taxes\":null,\"discount\":\"50.00\",\"discount_type\":\"fixed\",\"discount_totals\":\"300.00\",\"total\":\"115.00\",\"amount_paid\":\"0.00\",\"payment_method_id\":4,\"currency_id\":1,\"billing_address_id\":null,\"shipping_address_id\":null,\"estimated_delivery_at\":null,\"delivered_at\":null,\"shipped_at\":null,\"meta\":[],\"point_of_sale_id\":7}}', NULL, '2025-05-05 13:18:04', '2025-05-05 13:18:04'),
(540, 'default', 'created', 'App\\Models\\OrderItem', 'created', 53, 'App\\Models\\User', 5, '{\"attributes\":{\"order_id\":28,\"product_name_en\":\"Cement\",\"product_name_ar\":\"\\u0627\\u0644\\u0623\\u0633\\u0645\\u0646\\u062a\",\"product_description_en\":null,\"product_description_ar\":null,\"product_sku\":null,\"product_code\":null,\"product_id\":14,\"quantity\":2,\"tax_id\":null,\"note\":null,\"unit_price\":200,\"vat_amount\":\"15.00\",\"other_taxes_amount\":\"0.00\",\"discount_amount\":\"50.00\",\"discount_type\":\"percentage\",\"total_price\":\"230.00\"}}', NULL, '2025-05-05 13:18:04', '2025-05-05 13:18:04'),
(541, 'default', 'created', 'App\\Models\\Address', 'created', 55, 'App\\Models\\User', 5, '{\"attributes\":{\"id\":55,\"address_type_id\":1,\"addressable_type\":null,\"addressable_id\":null,\"street\":null,\"city\":null,\"state\":null,\"country\":null,\"postal_code\":null,\"country_id\":null,\"contact_person_full_name\":null,\"contact_person_phone\":null,\"latitude\":null,\"longitude\":null,\"details\":null,\"created_at\":\"2025-05-05T13:18:04.000000Z\",\"updated_at\":\"2025-05-05T13:18:04.000000Z\",\"deleted_at\":null}}', NULL, '2025-05-05 13:18:04', '2025-05-05 13:18:04'),
(542, 'default', 'updated', 'App\\Models\\Order', 'updated', 28, 'App\\Models\\User', 5, '{\"attributes\":{\"discount_type\":\"fixed\",\"shipping_address_id\":55},\"old\":{\"discount_type\":null,\"shipping_address_id\":null}}', NULL, '2025-05-05 13:18:04', '2025-05-05 13:18:04'),
(543, 'default', 'created', 'App\\Models\\Address', 'created', 56, 'App\\Models\\User', 5, '{\"attributes\":{\"id\":56,\"address_type_id\":2,\"addressable_type\":null,\"addressable_id\":null,\"street\":null,\"city\":null,\"state\":null,\"country\":null,\"postal_code\":null,\"country_id\":null,\"contact_person_full_name\":null,\"contact_person_phone\":null,\"latitude\":null,\"longitude\":null,\"details\":null,\"created_at\":\"2025-05-05T13:18:04.000000Z\",\"updated_at\":\"2025-05-05T13:18:04.000000Z\",\"deleted_at\":null}}', NULL, '2025-05-05 13:18:04', '2025-05-05 13:18:04'),
(544, 'default', 'updated', 'App\\Models\\Order', 'updated', 28, 'App\\Models\\User', 5, '{\"attributes\":{\"discount_type\":\"fixed\",\"billing_address_id\":56},\"old\":{\"discount_type\":null,\"billing_address_id\":null}}', NULL, '2025-05-05 13:18:04', '2025-05-05 13:18:04'),
(545, 'default', 'updated', 'App\\Models\\Product', 'updated', 14, 'App\\Models\\User', 5, '{\"attributes\":{\"quantity\":0,\"updated_at\":\"2025-05-05T13:18:04.000000Z\"},\"old\":{\"quantity\":2,\"updated_at\":\"2025-05-05T12:33:25.000000Z\"}}', NULL, '2025-05-05 13:18:04', '2025-05-05 13:18:04'),
(546, 'default', 'created', 'App\\Models\\Order', 'created', 29, 'App\\Models\\User', 5, '{\"attributes\":{\"number\":\"ORD-202505-IHL5SE\",\"customer_id\":10,\"customer_name\":null,\"customer_email\":null,\"customer_phone_number\":null,\"user_id\":5,\"company_id\":3,\"order_status_id\":1,\"shipping_fee\":null,\"subtotal\":null,\"vat\":\"26.25\",\"other_taxes\":null,\"discount\":\"50.00\",\"discount_type\":\"fixed\",\"discount_totals\":\"225.00\",\"total\":\"201.00\",\"amount_paid\":\"0.00\",\"payment_method_id\":4,\"currency_id\":1,\"billing_address_id\":null,\"shipping_address_id\":null,\"estimated_delivery_at\":null,\"delivered_at\":null,\"shipped_at\":null,\"meta\":[],\"point_of_sale_id\":7}}', NULL, '2025-05-05 13:38:02', '2025-05-05 13:38:02'),
(547, 'default', 'created', 'App\\Models\\OrderItem', 'created', 54, 'App\\Models\\User', 5, '{\"attributes\":{\"order_id\":29,\"product_name_en\":\"Helmets\",\"product_name_ar\":\"\\u0627\\u0644\\u062e\\u0648\\u0630\",\"product_description_en\":null,\"product_description_ar\":null,\"product_sku\":null,\"product_code\":null,\"product_id\":16,\"quantity\":2,\"tax_id\":null,\"note\":null,\"unit_price\":200,\"vat_amount\":\"15.00\",\"other_taxes_amount\":\"0.00\",\"discount_amount\":\"50.00\",\"discount_type\":\"percentage\",\"total_price\":\"230.00\"}}', NULL, '2025-05-05 13:38:02', '2025-05-05 13:38:02'),
(548, 'default', 'created', 'App\\Models\\Address', 'created', 57, 'App\\Models\\User', 5, '{\"attributes\":{\"id\":57,\"address_type_id\":1,\"addressable_type\":null,\"addressable_id\":null,\"street\":null,\"city\":null,\"state\":null,\"country\":null,\"postal_code\":null,\"country_id\":null,\"contact_person_full_name\":null,\"contact_person_phone\":null,\"latitude\":null,\"longitude\":null,\"details\":null,\"created_at\":\"2025-05-05T13:38:02.000000Z\",\"updated_at\":\"2025-05-05T13:38:02.000000Z\",\"deleted_at\":null}}', NULL, '2025-05-05 13:38:02', '2025-05-05 13:38:02'),
(549, 'default', 'updated', 'App\\Models\\Order', 'updated', 29, 'App\\Models\\User', 5, '{\"attributes\":{\"discount_type\":\"fixed\",\"total\":\"201.00\",\"shipping_address_id\":57},\"old\":{\"discount_type\":null,\"total\":\"201.25\",\"shipping_address_id\":null}}', NULL, '2025-05-05 13:38:02', '2025-05-05 13:38:02'),
(550, 'default', 'created', 'App\\Models\\Address', 'created', 58, 'App\\Models\\User', 5, '{\"attributes\":{\"id\":58,\"address_type_id\":2,\"addressable_type\":null,\"addressable_id\":null,\"street\":null,\"city\":null,\"state\":null,\"country\":null,\"postal_code\":null,\"country_id\":null,\"contact_person_full_name\":null,\"contact_person_phone\":null,\"latitude\":null,\"longitude\":null,\"details\":null,\"created_at\":\"2025-05-05T13:38:02.000000Z\",\"updated_at\":\"2025-05-05T13:38:02.000000Z\",\"deleted_at\":null}}', NULL, '2025-05-05 13:38:02', '2025-05-05 13:38:02'),
(551, 'default', 'updated', 'App\\Models\\Order', 'updated', 29, 'App\\Models\\User', 5, '{\"attributes\":{\"discount_type\":\"fixed\",\"total\":\"201.00\",\"billing_address_id\":58},\"old\":{\"discount_type\":null,\"total\":\"201.25\",\"billing_address_id\":null}}', NULL, '2025-05-05 13:38:02', '2025-05-05 13:38:02'),
(552, 'default', 'updated', 'App\\Models\\Product', 'updated', 16, 'App\\Models\\User', 5, '{\"attributes\":{\"quantity\":40,\"updated_at\":\"2025-05-05T13:38:02.000000Z\"},\"old\":{\"quantity\":42,\"updated_at\":\"2025-05-05T13:01:53.000000Z\"}}', NULL, '2025-05-05 13:38:02', '2025-05-05 13:38:02'),
(553, 'default', 'created', 'App\\Models\\Order', 'created', 30, 'App\\Models\\User', 5, '{\"attributes\":{\"number\":\"ORD-202505-SCY9ZD\",\"customer_id\":10,\"customer_name\":null,\"customer_email\":null,\"customer_phone_number\":null,\"user_id\":5,\"company_id\":3,\"order_status_id\":1,\"shipping_fee\":null,\"subtotal\":null,\"vat\":\"26.25\",\"other_taxes\":null,\"discount\":\"50.00\",\"discount_type\":\"fixed\",\"discount_totals\":\"0.00\",\"total\":\"201.00\",\"amount_paid\":\"0.00\",\"payment_method_id\":4,\"currency_id\":1,\"billing_address_id\":null,\"shipping_address_id\":null,\"estimated_delivery_at\":null,\"delivered_at\":null,\"shipped_at\":null,\"meta\":[],\"point_of_sale_id\":7}}', NULL, '2025-05-05 13:43:39', '2025-05-05 13:43:39'),
(554, 'default', 'created', 'App\\Models\\OrderItem', 'created', 55, 'App\\Models\\User', 5, '{\"attributes\":{\"order_id\":30,\"product_name_en\":\"Hinges\",\"product_name_ar\":\"\\u0627\\u0644\\u0645\\u0641\\u0635\\u0644\\u0627\\u062a\",\"product_description_en\":null,\"product_description_ar\":null,\"product_sku\":null,\"product_code\":null,\"product_id\":18,\"quantity\":2,\"tax_id\":null,\"note\":null,\"unit_price\":200,\"vat_amount\":\"15.00\",\"other_taxes_amount\":\"0.00\",\"discount_amount\":\"50.00\",\"discount_type\":\"percentage\",\"total_price\":\"230.00\"}}', NULL, '2025-05-05 13:43:39', '2025-05-05 13:43:39'),
(555, 'default', 'created', 'App\\Models\\Address', 'created', 59, 'App\\Models\\User', 5, '{\"attributes\":{\"id\":59,\"address_type_id\":1,\"addressable_type\":null,\"addressable_id\":null,\"street\":null,\"city\":null,\"state\":null,\"country\":null,\"postal_code\":null,\"country_id\":null,\"contact_person_full_name\":null,\"contact_person_phone\":null,\"latitude\":null,\"longitude\":null,\"details\":null,\"created_at\":\"2025-05-05T13:43:39.000000Z\",\"updated_at\":\"2025-05-05T13:43:39.000000Z\",\"deleted_at\":null}}', NULL, '2025-05-05 13:43:39', '2025-05-05 13:43:39'),
(556, 'default', 'updated', 'App\\Models\\Order', 'updated', 30, 'App\\Models\\User', 5, '{\"attributes\":{\"discount_type\":\"fixed\",\"discount_totals\":\"0.00\",\"total\":\"201.00\",\"shipping_address_id\":59},\"old\":{\"discount_type\":null,\"discount_totals\":null,\"total\":\"201.25\",\"shipping_address_id\":null}}', NULL, '2025-05-05 13:43:39', '2025-05-05 13:43:39'),
(557, 'default', 'created', 'App\\Models\\Address', 'created', 60, 'App\\Models\\User', 5, '{\"attributes\":{\"id\":60,\"address_type_id\":2,\"addressable_type\":null,\"addressable_id\":null,\"street\":null,\"city\":null,\"state\":null,\"country\":null,\"postal_code\":null,\"country_id\":null,\"contact_person_full_name\":null,\"contact_person_phone\":null,\"latitude\":null,\"longitude\":null,\"details\":null,\"created_at\":\"2025-05-05T13:43:39.000000Z\",\"updated_at\":\"2025-05-05T13:43:39.000000Z\",\"deleted_at\":null}}', NULL, '2025-05-05 13:43:39', '2025-05-05 13:43:39'),
(558, 'default', 'updated', 'App\\Models\\Order', 'updated', 30, 'App\\Models\\User', 5, '{\"attributes\":{\"discount_type\":\"fixed\",\"discount_totals\":\"0.00\",\"total\":\"201.00\",\"billing_address_id\":60},\"old\":{\"discount_type\":null,\"discount_totals\":null,\"total\":\"201.25\",\"billing_address_id\":null}}', NULL, '2025-05-05 13:43:39', '2025-05-05 13:43:39'),
(559, 'default', 'updated', 'App\\Models\\Product', 'updated', 18, 'App\\Models\\User', 5, '{\"attributes\":{\"quantity\":0,\"updated_at\":\"2025-05-05T13:43:39.000000Z\"},\"old\":{\"quantity\":1,\"updated_at\":\"2025-05-05T12:51:14.000000Z\"}}', NULL, '2025-05-05 13:43:39', '2025-05-05 13:43:39'),
(560, 'default', 'created', 'App\\Models\\Order', 'created', 31, 'App\\Models\\User', 5, '{\"attributes\":{\"number\":\"ORD-202505-20BUDC\",\"customer_id\":10,\"customer_name\":null,\"customer_email\":null,\"customer_phone_number\":null,\"user_id\":5,\"company_id\":3,\"order_status_id\":1,\"shipping_fee\":null,\"subtotal\":null,\"vat\":\"15.00\",\"other_taxes\":null,\"discount\":\"200.00\",\"discount_type\":\"percentage\",\"discount_totals\":\"0.00\",\"total\":\"115.00\",\"amount_paid\":\"0.00\",\"payment_method_id\":4,\"currency_id\":1,\"billing_address_id\":null,\"shipping_address_id\":null,\"estimated_delivery_at\":null,\"delivered_at\":null,\"shipped_at\":null,\"meta\":[],\"point_of_sale_id\":7}}', NULL, '2025-05-05 13:48:43', '2025-05-05 13:48:43'),
(561, 'default', 'created', 'App\\Models\\OrderItem', 'created', 56, 'App\\Models\\User', 5, '{\"attributes\":{\"order_id\":31,\"product_name_en\":\"Helmets\",\"product_name_ar\":\"\\u0627\\u0644\\u062e\\u0648\\u0630\",\"product_description_en\":null,\"product_description_ar\":null,\"product_sku\":null,\"product_code\":null,\"product_id\":16,\"quantity\":2,\"tax_id\":null,\"note\":null,\"unit_price\":200,\"vat_amount\":\"15.00\",\"other_taxes_amount\":\"0.00\",\"discount_amount\":\"50.00\",\"discount_type\":\"percentage\",\"total_price\":\"230.00\"}}', NULL, '2025-05-05 13:48:43', '2025-05-05 13:48:43'),
(562, 'default', 'created', 'App\\Models\\Address', 'created', 61, 'App\\Models\\User', 5, '{\"attributes\":{\"id\":61,\"address_type_id\":1,\"addressable_type\":null,\"addressable_id\":null,\"street\":null,\"city\":null,\"state\":null,\"country\":null,\"postal_code\":null,\"country_id\":null,\"contact_person_full_name\":null,\"contact_person_phone\":null,\"latitude\":null,\"longitude\":null,\"details\":null,\"created_at\":\"2025-05-05T13:48:43.000000Z\",\"updated_at\":\"2025-05-05T13:48:43.000000Z\",\"deleted_at\":null}}', NULL, '2025-05-05 13:48:43', '2025-05-05 13:48:43'),
(563, 'default', 'updated', 'App\\Models\\Order', 'updated', 31, 'App\\Models\\User', 5, '{\"attributes\":{\"discount_totals\":\"0.00\",\"shipping_address_id\":61},\"old\":{\"discount_totals\":null,\"shipping_address_id\":null}}', NULL, '2025-05-05 13:48:43', '2025-05-05 13:48:43'),
(564, 'default', 'created', 'App\\Models\\Address', 'created', 62, 'App\\Models\\User', 5, '{\"attributes\":{\"id\":62,\"address_type_id\":2,\"addressable_type\":null,\"addressable_id\":null,\"street\":null,\"city\":null,\"state\":null,\"country\":null,\"postal_code\":null,\"country_id\":null,\"contact_person_full_name\":null,\"contact_person_phone\":null,\"latitude\":null,\"longitude\":null,\"details\":null,\"created_at\":\"2025-05-05T13:48:43.000000Z\",\"updated_at\":\"2025-05-05T13:48:43.000000Z\",\"deleted_at\":null}}', NULL, '2025-05-05 13:48:43', '2025-05-05 13:48:43'),
(565, 'default', 'updated', 'App\\Models\\Order', 'updated', 31, 'App\\Models\\User', 5, '{\"attributes\":{\"discount_totals\":\"0.00\",\"billing_address_id\":62},\"old\":{\"discount_totals\":null,\"billing_address_id\":null}}', NULL, '2025-05-05 13:48:43', '2025-05-05 13:48:43'),
(566, 'default', 'updated', 'App\\Models\\Product', 'updated', 16, 'App\\Models\\User', 5, '{\"attributes\":{\"quantity\":38,\"updated_at\":\"2025-05-05T13:48:43.000000Z\"},\"old\":{\"quantity\":40,\"updated_at\":\"2025-05-05T13:38:02.000000Z\"}}', NULL, '2025-05-05 13:48:43', '2025-05-05 13:48:43'),
(567, 'default', 'created', 'App\\Models\\Order', 'created', 32, 'App\\Models\\User', 5, '{\"attributes\":{\"number\":\"ORD-202505-ODYP7G\",\"customer_id\":10,\"customer_name\":null,\"customer_email\":null,\"customer_phone_number\":null,\"user_id\":5,\"company_id\":3,\"order_status_id\":1,\"shipping_fee\":null,\"subtotal\":null,\"vat\":\"15.00\",\"other_taxes\":null,\"discount\":\"200.00\",\"discount_type\":\"percentage\",\"discount_totals\":\"300.00\",\"total\":\"115.00\",\"amount_paid\":\"0.00\",\"payment_method_id\":4,\"currency_id\":1,\"billing_address_id\":null,\"shipping_address_id\":null,\"estimated_delivery_at\":null,\"delivered_at\":null,\"shipped_at\":null,\"meta\":[],\"point_of_sale_id\":7}}', NULL, '2025-05-05 13:51:16', '2025-05-05 13:51:16'),
(568, 'default', 'created', 'App\\Models\\OrderItem', 'created', 57, 'App\\Models\\User', 5, '{\"attributes\":{\"order_id\":32,\"product_name_en\":\"Sand\",\"product_name_ar\":\"\\u0627\\u0644\\u0631\\u0645\\u0644\",\"product_description_en\":null,\"product_description_ar\":null,\"product_sku\":null,\"product_code\":null,\"product_id\":15,\"quantity\":2,\"tax_id\":null,\"note\":null,\"unit_price\":200,\"vat_amount\":\"15.00\",\"other_taxes_amount\":\"0.00\",\"discount_amount\":\"50.00\",\"discount_type\":\"percentage\",\"total_price\":\"230.00\"}}', NULL, '2025-05-05 13:51:16', '2025-05-05 13:51:16'),
(569, 'default', 'created', 'App\\Models\\Address', 'created', 63, 'App\\Models\\User', 5, '{\"attributes\":{\"id\":63,\"address_type_id\":1,\"addressable_type\":null,\"addressable_id\":null,\"street\":null,\"city\":null,\"state\":null,\"country\":null,\"postal_code\":null,\"country_id\":null,\"contact_person_full_name\":null,\"contact_person_phone\":null,\"latitude\":null,\"longitude\":null,\"details\":null,\"created_at\":\"2025-05-05T13:51:16.000000Z\",\"updated_at\":\"2025-05-05T13:51:16.000000Z\",\"deleted_at\":null}}', NULL, '2025-05-05 13:51:16', '2025-05-05 13:51:16'),
(570, 'default', 'updated', 'App\\Models\\Order', 'updated', 32, 'App\\Models\\User', 5, '{\"attributes\":{\"shipping_address_id\":63},\"old\":{\"shipping_address_id\":null}}', NULL, '2025-05-05 13:51:16', '2025-05-05 13:51:16'),
(571, 'default', 'created', 'App\\Models\\Address', 'created', 64, 'App\\Models\\User', 5, '{\"attributes\":{\"id\":64,\"address_type_id\":2,\"addressable_type\":null,\"addressable_id\":null,\"street\":null,\"city\":null,\"state\":null,\"country\":null,\"postal_code\":null,\"country_id\":null,\"contact_person_full_name\":null,\"contact_person_phone\":null,\"latitude\":null,\"longitude\":null,\"details\":null,\"created_at\":\"2025-05-05T13:51:16.000000Z\",\"updated_at\":\"2025-05-05T13:51:16.000000Z\",\"deleted_at\":null}}', NULL, '2025-05-05 13:51:16', '2025-05-05 13:51:16'),
(572, 'default', 'updated', 'App\\Models\\Order', 'updated', 32, 'App\\Models\\User', 5, '{\"attributes\":{\"billing_address_id\":64},\"old\":{\"billing_address_id\":null}}', NULL, '2025-05-05 13:51:16', '2025-05-05 13:51:16'),
(573, 'default', 'updated', 'App\\Models\\Product', 'updated', 15, 'App\\Models\\User', 5, '{\"attributes\":{\"quantity\":7,\"updated_at\":\"2025-05-05T13:51:16.000000Z\"},\"old\":{\"quantity\":9,\"updated_at\":\"2025-05-04T15:55:40.000000Z\"}}', NULL, '2025-05-05 13:51:16', '2025-05-05 13:51:16'),
(574, 'default', 'created', 'App\\Models\\Order', 'created', 33, 'App\\Models\\User', 5, '{\"attributes\":{\"number\":\"ORD-202505-CBAXWS\",\"customer_id\":10,\"customer_name\":null,\"customer_email\":null,\"customer_phone_number\":null,\"user_id\":5,\"company_id\":3,\"order_status_id\":1,\"shipping_fee\":null,\"subtotal\":null,\"vat\":\"15.00\",\"other_taxes\":null,\"discount\":\"50.00\",\"discount_type\":\"percentage\",\"discount_totals\":\"300.00\",\"total\":\"115.00\",\"amount_paid\":\"115.00\",\"payment_method_id\":4,\"currency_id\":1,\"billing_address_id\":null,\"shipping_address_id\":null,\"estimated_delivery_at\":null,\"delivered_at\":null,\"shipped_at\":null,\"meta\":[],\"point_of_sale_id\":7}}', NULL, '2025-05-05 14:16:36', '2025-05-05 14:16:36'),
(575, 'default', 'created', 'App\\Models\\OrderItem', 'created', 58, 'App\\Models\\User', 5, '{\"attributes\":{\"order_id\":33,\"product_name_en\":\"Helmets\",\"product_name_ar\":\"\\u0627\\u0644\\u062e\\u0648\\u0630\",\"product_description_en\":null,\"product_description_ar\":null,\"product_sku\":null,\"product_code\":null,\"product_id\":16,\"quantity\":2,\"tax_id\":null,\"note\":null,\"unit_price\":200,\"vat_amount\":\"15.00\",\"other_taxes_amount\":\"0.00\",\"discount_amount\":\"50.00\",\"discount_type\":\"percentage\",\"total_price\":\"230.00\"}}', NULL, '2025-05-05 14:16:36', '2025-05-05 14:16:36'),
(576, 'default', 'created', 'App\\Models\\Address', 'created', 65, 'App\\Models\\User', 5, '{\"attributes\":{\"id\":65,\"address_type_id\":1,\"addressable_type\":null,\"addressable_id\":null,\"street\":null,\"city\":null,\"state\":null,\"country\":null,\"postal_code\":null,\"country_id\":null,\"contact_person_full_name\":null,\"contact_person_phone\":null,\"latitude\":null,\"longitude\":null,\"details\":null,\"created_at\":\"2025-05-05T14:16:36.000000Z\",\"updated_at\":\"2025-05-05T14:16:36.000000Z\",\"deleted_at\":null}}', NULL, '2025-05-05 14:16:36', '2025-05-05 14:16:36'),
(577, 'default', 'updated', 'App\\Models\\Order', 'updated', 33, 'App\\Models\\User', 5, '{\"attributes\":{\"shipping_address_id\":65},\"old\":{\"shipping_address_id\":null}}', NULL, '2025-05-05 14:16:36', '2025-05-05 14:16:36'),
(578, 'default', 'created', 'App\\Models\\Address', 'created', 66, 'App\\Models\\User', 5, '{\"attributes\":{\"id\":66,\"address_type_id\":2,\"addressable_type\":null,\"addressable_id\":null,\"street\":null,\"city\":null,\"state\":null,\"country\":null,\"postal_code\":null,\"country_id\":null,\"contact_person_full_name\":null,\"contact_person_phone\":null,\"latitude\":null,\"longitude\":null,\"details\":null,\"created_at\":\"2025-05-05T14:16:36.000000Z\",\"updated_at\":\"2025-05-05T14:16:36.000000Z\",\"deleted_at\":null}}', NULL, '2025-05-05 14:16:36', '2025-05-05 14:16:36'),
(579, 'default', 'updated', 'App\\Models\\Order', 'updated', 33, 'App\\Models\\User', 5, '{\"attributes\":{\"billing_address_id\":66},\"old\":{\"billing_address_id\":null}}', NULL, '2025-05-05 14:16:36', '2025-05-05 14:16:36'),
(580, 'default', 'updated', 'App\\Models\\Product', 'updated', 16, 'App\\Models\\User', 5, '{\"attributes\":{\"quantity\":36,\"updated_at\":\"2025-05-05T14:16:36.000000Z\"},\"old\":{\"quantity\":38,\"updated_at\":\"2025-05-05T13:48:43.000000Z\"}}', NULL, '2025-05-05 14:16:36', '2025-05-05 14:16:36'),
(581, 'default', 'created', 'App\\Models\\Order', 'created', 34, 'App\\Models\\User', 5, '{\"attributes\":{\"number\":\"ORD-202505-NITJT4\",\"customer_id\":10,\"customer_name\":null,\"customer_email\":null,\"customer_phone_number\":null,\"user_id\":5,\"company_id\":3,\"order_status_id\":1,\"shipping_fee\":null,\"subtotal\":\"400.00\",\"vat\":\"30.00\",\"other_taxes\":null,\"discount\":\"50.00\",\"discount_type\":\"percentage\",\"discount_totals\":\"600.00\",\"total\":\"230.00\",\"amount_paid\":\"230.00\",\"payment_method_id\":4,\"currency_id\":1,\"billing_address_id\":null,\"shipping_address_id\":null,\"estimated_delivery_at\":null,\"delivered_at\":null,\"shipped_at\":null,\"meta\":[],\"point_of_sale_id\":7}}', NULL, '2025-05-05 14:29:44', '2025-05-05 14:29:44'),
(582, 'default', 'created', 'App\\Models\\OrderItem', 'created', 59, 'App\\Models\\User', 5, '{\"attributes\":{\"order_id\":34,\"product_name_en\":\"Helmets\",\"product_name_ar\":\"\\u0627\\u0644\\u062e\\u0648\\u0630\",\"product_description_en\":null,\"product_description_ar\":null,\"product_sku\":null,\"product_code\":null,\"product_id\":16,\"quantity\":2,\"tax_id\":null,\"note\":null,\"unit_price\":200,\"vat_amount\":\"15.00\",\"other_taxes_amount\":\"0.00\",\"discount_amount\":\"50.00\",\"discount_type\":\"percentage\",\"total_price\":\"230.00\"}}', NULL, '2025-05-05 14:29:44', '2025-05-05 14:29:44'),
(583, 'default', 'created', 'App\\Models\\OrderItem', 'created', 60, 'App\\Models\\User', 5, '{\"attributes\":{\"order_id\":34,\"product_name_en\":\"Anchors\",\"product_name_ar\":\"\\u0627\\u0644\\u0645\\u0631\\u0627\\u0628\\u0637\",\"product_description_en\":null,\"product_description_ar\":null,\"product_sku\":null,\"product_code\":null,\"product_id\":19,\"quantity\":1,\"tax_id\":null,\"note\":null,\"unit_price\":400,\"vat_amount\":\"30.00\",\"other_taxes_amount\":\"0.00\",\"discount_amount\":\"50.00\",\"discount_type\":\"percentage\",\"total_price\":\"230.00\"}}', NULL, '2025-05-05 14:29:44', '2025-05-05 14:29:44'),
(584, 'default', 'created', 'App\\Models\\Address', 'created', 67, 'App\\Models\\User', 5, '{\"attributes\":{\"id\":67,\"address_type_id\":1,\"addressable_type\":null,\"addressable_id\":null,\"street\":null,\"city\":null,\"state\":null,\"country\":null,\"postal_code\":null,\"country_id\":null,\"contact_person_full_name\":null,\"contact_person_phone\":null,\"latitude\":null,\"longitude\":null,\"details\":null,\"created_at\":\"2025-05-05T14:29:44.000000Z\",\"updated_at\":\"2025-05-05T14:29:44.000000Z\",\"deleted_at\":null}}', NULL, '2025-05-05 14:29:44', '2025-05-05 14:29:44'),
(585, 'default', 'updated', 'App\\Models\\Order', 'updated', 34, 'App\\Models\\User', 5, '{\"attributes\":{\"shipping_address_id\":67},\"old\":{\"shipping_address_id\":null}}', NULL, '2025-05-05 14:29:44', '2025-05-05 14:29:44'),
(586, 'default', 'created', 'App\\Models\\Address', 'created', 68, 'App\\Models\\User', 5, '{\"attributes\":{\"id\":68,\"address_type_id\":2,\"addressable_type\":null,\"addressable_id\":null,\"street\":null,\"city\":null,\"state\":null,\"country\":null,\"postal_code\":null,\"country_id\":null,\"contact_person_full_name\":null,\"contact_person_phone\":null,\"latitude\":null,\"longitude\":null,\"details\":null,\"created_at\":\"2025-05-05T14:29:44.000000Z\",\"updated_at\":\"2025-05-05T14:29:44.000000Z\",\"deleted_at\":null}}', NULL, '2025-05-05 14:29:44', '2025-05-05 14:29:44'),
(587, 'default', 'updated', 'App\\Models\\Order', 'updated', 34, 'App\\Models\\User', 5, '{\"attributes\":{\"billing_address_id\":68},\"old\":{\"billing_address_id\":null}}', NULL, '2025-05-05 14:29:44', '2025-05-05 14:29:44'),
(588, 'default', 'updated', 'App\\Models\\Product', 'updated', 16, 'App\\Models\\User', 5, '{\"attributes\":{\"quantity\":34,\"updated_at\":\"2025-05-05T14:29:44.000000Z\"},\"old\":{\"quantity\":36,\"updated_at\":\"2025-05-05T14:16:36.000000Z\"}}', NULL, '2025-05-05 14:29:44', '2025-05-05 14:29:44'),
(589, 'default', 'updated', 'App\\Models\\Product', 'updated', 19, 'App\\Models\\User', 5, '{\"attributes\":{\"quantity\":21,\"updated_at\":\"2025-05-05T14:29:44.000000Z\"},\"old\":{\"quantity\":22,\"updated_at\":\"2025-05-05T12:34:57.000000Z\"}}', NULL, '2025-05-05 14:29:44', '2025-05-05 14:29:44'),
(590, 'default', 'created', 'App\\Models\\Order', 'created', 35, 'App\\Models\\User', 5, '{\"attributes\":{\"number\":\"ORD-202505-QIURGS\",\"customer_id\":10,\"customer_name\":null,\"customer_email\":null,\"customer_phone_number\":null,\"user_id\":5,\"company_id\":3,\"order_status_id\":1,\"shipping_fee\":null,\"subtotal\":\"800.00\",\"vat\":\"30.00\",\"other_taxes\":null,\"discount\":\"50.00\",\"discount_type\":\"percentage\",\"discount_totals\":\"600.00\",\"total\":\"230.00\",\"amount_paid\":\"0.00\",\"payment_method_id\":4,\"currency_id\":1,\"billing_address_id\":null,\"shipping_address_id\":null,\"estimated_delivery_at\":null,\"delivered_at\":null,\"shipped_at\":null,\"meta\":[],\"point_of_sale_id\":7}}', NULL, '2025-05-05 14:43:46', '2025-05-05 14:43:46'),
(591, 'default', 'created', 'App\\Models\\OrderItem', 'created', 61, 'App\\Models\\User', 5, '{\"attributes\":{\"order_id\":35,\"product_name_en\":\"Sand\",\"product_name_ar\":\"\\u0627\\u0644\\u0631\\u0645\\u0644\",\"product_description_en\":null,\"product_description_ar\":null,\"product_sku\":null,\"product_code\":null,\"product_id\":15,\"quantity\":2,\"tax_id\":null,\"note\":null,\"unit_price\":200,\"vat_amount\":\"15.00\",\"other_taxes_amount\":\"0.00\",\"discount_amount\":\"50.00\",\"discount_type\":\"percentage\",\"total_price\":\"230.00\"}}', NULL, '2025-05-05 14:43:46', '2025-05-05 14:43:46'),
(592, 'default', 'created', 'App\\Models\\OrderItem', 'created', 62, 'App\\Models\\User', 5, '{\"attributes\":{\"order_id\":35,\"product_name_en\":\"Anchors\",\"product_name_ar\":\"\\u0627\\u0644\\u0645\\u0631\\u0627\\u0628\\u0637\",\"product_description_en\":null,\"product_description_ar\":null,\"product_sku\":null,\"product_code\":null,\"product_id\":19,\"quantity\":1,\"tax_id\":null,\"note\":null,\"unit_price\":400,\"vat_amount\":\"30.00\",\"other_taxes_amount\":\"0.00\",\"discount_amount\":\"50.00\",\"discount_type\":\"percentage\",\"total_price\":\"230.00\"}}', NULL, '2025-05-05 14:43:46', '2025-05-05 14:43:46'),
(593, 'default', 'created', 'App\\Models\\Address', 'created', 69, 'App\\Models\\User', 5, '{\"attributes\":{\"id\":69,\"address_type_id\":1,\"addressable_type\":null,\"addressable_id\":null,\"street\":null,\"city\":null,\"state\":null,\"country\":null,\"postal_code\":null,\"country_id\":null,\"contact_person_full_name\":null,\"contact_person_phone\":null,\"latitude\":null,\"longitude\":null,\"details\":null,\"created_at\":\"2025-05-05T14:43:46.000000Z\",\"updated_at\":\"2025-05-05T14:43:46.000000Z\",\"deleted_at\":null}}', NULL, '2025-05-05 14:43:46', '2025-05-05 14:43:46'),
(594, 'default', 'updated', 'App\\Models\\Order', 'updated', 35, 'App\\Models\\User', 5, '{\"attributes\":{\"shipping_address_id\":69},\"old\":{\"shipping_address_id\":null}}', NULL, '2025-05-05 14:43:46', '2025-05-05 14:43:46'),
(595, 'default', 'created', 'App\\Models\\Address', 'created', 70, 'App\\Models\\User', 5, '{\"attributes\":{\"id\":70,\"address_type_id\":2,\"addressable_type\":null,\"addressable_id\":null,\"street\":null,\"city\":null,\"state\":null,\"country\":null,\"postal_code\":null,\"country_id\":null,\"contact_person_full_name\":null,\"contact_person_phone\":null,\"latitude\":null,\"longitude\":null,\"details\":null,\"created_at\":\"2025-05-05T14:43:46.000000Z\",\"updated_at\":\"2025-05-05T14:43:46.000000Z\",\"deleted_at\":null}}', NULL, '2025-05-05 14:43:46', '2025-05-05 14:43:46'),
(596, 'default', 'updated', 'App\\Models\\Order', 'updated', 35, 'App\\Models\\User', 5, '{\"attributes\":{\"billing_address_id\":70},\"old\":{\"billing_address_id\":null}}', NULL, '2025-05-05 14:43:46', '2025-05-05 14:43:46'),
(597, 'default', 'updated', 'App\\Models\\Product', 'updated', 15, 'App\\Models\\User', 5, '{\"attributes\":{\"quantity\":5,\"updated_at\":\"2025-05-05T14:43:46.000000Z\"},\"old\":{\"quantity\":7,\"updated_at\":\"2025-05-05T13:51:16.000000Z\"}}', NULL, '2025-05-05 14:43:46', '2025-05-05 14:43:46'),
(598, 'default', 'updated', 'App\\Models\\Product', 'updated', 19, 'App\\Models\\User', 5, '{\"attributes\":{\"quantity\":20,\"updated_at\":\"2025-05-05T14:43:46.000000Z\"},\"old\":{\"quantity\":21,\"updated_at\":\"2025-05-05T14:29:44.000000Z\"}}', NULL, '2025-05-05 14:43:46', '2025-05-05 14:43:46'),
(599, 'default', 'created', 'App\\Models\\Invoice', 'created', 8, 'App\\Models\\User', 5, '{\"attributes\":{\"id\":8,\"number\":\"C003-INV-000001\",\"order_id\":35,\"company_id\":3,\"point_of_sale_id\":7,\"customer_id\":10,\"issued_by_user\":5,\"customer_name\":\"Guest Customer\",\"customer_email\":\"guest@gmail.com\",\"customer_phone\":null,\"subtotal\":800,\"discount\":600,\"vat\":30,\"other_taxes\":0,\"total\":230,\"amount_paid\":230,\"due_date\":\"2025-06-04T14:44:58.000000Z\",\"paid_date\":null,\"issue_date\":\"2025-05-05T14:44:58.000000Z\",\"meta\":null,\"billing_address_id\":null,\"shipping_address_id\":null,\"invoice_status_id\":1,\"currency_id\":null,\"created_at\":\"2025-05-05T14:44:58.000000Z\",\"updated_at\":\"2025-05-05T14:44:58.000000Z\",\"deleted_at\":null}}', NULL, '2025-05-05 14:44:58', '2025-05-05 14:44:58'),
(600, 'default', 'created', 'App\\Models\\InvoiceItem', 'created', 92, 'App\\Models\\User', 5, '{\"attributes\":{\"id\":92,\"invoice_id\":8,\"product_name_en\":\"Sand\",\"product_name_ar\":\"\\u0627\\u0644\\u0631\\u0645\\u0644\",\"product_description_en\":null,\"product_description_ar\":null,\"product_sku\":null,\"product_code\":null,\"quantity\":2,\"unit_price\":200,\"tax_id\":null,\"discount_amount\":200,\"created_at\":\"2025-05-05T14:44:58.000000Z\",\"updated_at\":\"2025-05-05T14:44:58.000000Z\",\"deleted_at\":null,\"note\":null,\"vat_amount\":15,\"other_taxes_amount\":0,\"total_price\":230}}', NULL, '2025-05-05 14:44:58', '2025-05-05 14:44:58'),
(601, 'default', 'created', 'App\\Models\\InvoiceItem', 'created', 93, 'App\\Models\\User', 5, '{\"attributes\":{\"id\":93,\"invoice_id\":8,\"product_name_en\":\"Anchors\",\"product_name_ar\":\"\\u0627\\u0644\\u0645\\u0631\\u0627\\u0628\\u0637\",\"product_description_en\":null,\"product_description_ar\":null,\"product_sku\":null,\"product_code\":null,\"quantity\":1,\"unit_price\":400,\"tax_id\":null,\"discount_amount\":200,\"created_at\":\"2025-05-05T14:44:58.000000Z\",\"updated_at\":\"2025-05-05T14:44:58.000000Z\",\"deleted_at\":null,\"note\":null,\"vat_amount\":30,\"other_taxes_amount\":0,\"total_price\":230}}', NULL, '2025-05-05 14:44:58', '2025-05-05 14:44:58');

-- --------------------------------------------------------

--
-- Table structure for table `addresses`
--

CREATE TABLE `addresses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `address_type_id` bigint(20) UNSIGNED DEFAULT NULL,
  `addressable_type` varchar(255) DEFAULT NULL,
  `addressable_id` bigint(20) UNSIGNED DEFAULT NULL,
  `street` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `postal_code` varchar(255) DEFAULT NULL,
  `country_id` bigint(20) UNSIGNED DEFAULT NULL,
  `contact_person_full_name` varchar(255) DEFAULT NULL,
  `contact_person_phone` varchar(255) DEFAULT NULL,
  `latitude` decimal(10,8) DEFAULT NULL,
  `longitude` decimal(11,8) DEFAULT NULL,
  `details` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `addresses`
--

INSERT INTO `addresses` (`id`, `address_type_id`, `addressable_type`, `addressable_id`, `street`, `city`, `state`, `country`, `postal_code`, `country_id`, `contact_person_full_name`, `contact_person_phone`, `latitude`, `longitude`, `details`, `created_at`, `updated_at`, `deleted_at`) VALUES
(5, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-04-09 16:49:53', '2025-04-09 16:49:53', NULL),
(6, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-04-09 16:49:53', '2025-04-09 16:49:53', NULL),
(7, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-04-10 12:11:47', '2025-04-10 12:11:47', NULL),
(8, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-04-10 12:11:47', '2025-04-10 12:11:47', NULL),
(9, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-04-10 12:32:56', '2025-04-10 12:32:56', NULL),
(10, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-04-10 12:32:56', '2025-04-10 12:32:56', NULL),
(11, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-04-10 12:48:14', '2025-04-10 12:48:14', NULL),
(12, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-04-10 12:48:14', '2025-04-10 12:48:14', NULL),
(13, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-04-10 12:56:41', '2025-04-10 12:56:41', NULL),
(14, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-04-10 12:56:41', '2025-04-10 12:56:41', NULL),
(15, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-04-10 18:13:26', '2025-04-10 18:13:26', NULL),
(16, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-04-10 18:13:26', '2025-04-10 18:13:26', NULL),
(17, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-04-14 00:10:28', '2025-04-14 00:10:28', NULL),
(18, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-04-14 00:10:28', '2025-04-14 00:10:28', NULL),
(19, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-05-04 09:33:38', '2025-05-04 09:33:38', NULL),
(20, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-05-04 09:33:38', '2025-05-04 09:33:38', NULL),
(21, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-05-04 09:54:11', '2025-05-04 09:54:11', NULL),
(22, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-05-04 09:54:11', '2025-05-04 09:54:11', NULL),
(23, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-05-04 09:56:35', '2025-05-04 09:56:35', NULL),
(24, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-05-04 09:56:35', '2025-05-04 09:56:35', NULL),
(25, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-05-04 10:09:20', '2025-05-04 10:09:20', NULL),
(26, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-05-04 10:09:20', '2025-05-04 10:09:20', NULL),
(27, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-05-04 14:16:41', '2025-05-04 14:16:41', NULL),
(28, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-05-04 14:16:41', '2025-05-04 14:16:41', NULL),
(29, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-05-04 15:55:39', '2025-05-04 15:55:39', NULL),
(30, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-05-04 15:55:39', '2025-05-04 15:55:39', NULL),
(31, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-05-04 17:12:24', '2025-05-04 17:12:24', NULL),
(32, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-05-04 17:12:24', '2025-05-04 17:12:24', NULL),
(33, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-05-04 17:48:41', '2025-05-04 17:48:41', NULL),
(34, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-05-04 17:48:41', '2025-05-04 17:48:41', NULL),
(35, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-05-04 19:27:53', '2025-05-04 19:27:53', NULL),
(36, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-05-04 19:27:53', '2025-05-04 19:27:53', NULL),
(37, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-05-05 09:49:07', '2025-05-05 09:49:07', NULL),
(38, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-05-05 09:49:07', '2025-05-05 09:49:07', NULL),
(39, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-05-05 09:49:50', '2025-05-05 09:49:50', NULL),
(40, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-05-05 09:49:51', '2025-05-05 09:49:51', NULL),
(41, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-05-05 11:53:57', '2025-05-05 11:53:57', NULL),
(42, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-05-05 11:53:57', '2025-05-05 11:53:57', NULL),
(43, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-05-05 12:29:12', '2025-05-05 12:29:12', NULL),
(44, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-05-05 12:29:12', '2025-05-05 12:29:12', NULL),
(45, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-05-05 12:33:25', '2025-05-05 12:33:25', NULL),
(46, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-05-05 12:33:25', '2025-05-05 12:33:25', NULL),
(47, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-05-05 12:34:57', '2025-05-05 12:34:57', NULL),
(48, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-05-05 12:34:57', '2025-05-05 12:34:57', NULL),
(49, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-05-05 12:49:02', '2025-05-05 12:49:02', NULL),
(50, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-05-05 12:49:02', '2025-05-05 12:49:02', NULL),
(51, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-05-05 12:51:14', '2025-05-05 12:51:14', NULL),
(52, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-05-05 12:51:14', '2025-05-05 12:51:14', NULL),
(53, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-05-05 13:01:53', '2025-05-05 13:01:53', NULL),
(54, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-05-05 13:01:53', '2025-05-05 13:01:53', NULL),
(55, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-05-05 13:18:04', '2025-05-05 13:18:04', NULL),
(56, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-05-05 13:18:04', '2025-05-05 13:18:04', NULL),
(57, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-05-05 13:38:02', '2025-05-05 13:38:02', NULL),
(58, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-05-05 13:38:02', '2025-05-05 13:38:02', NULL),
(59, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-05-05 13:43:39', '2025-05-05 13:43:39', NULL),
(60, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-05-05 13:43:39', '2025-05-05 13:43:39', NULL),
(61, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-05-05 13:48:43', '2025-05-05 13:48:43', NULL),
(62, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-05-05 13:48:43', '2025-05-05 13:48:43', NULL),
(63, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-05-05 13:51:16', '2025-05-05 13:51:16', NULL),
(64, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-05-05 13:51:16', '2025-05-05 13:51:16', NULL),
(65, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-05-05 14:16:36', '2025-05-05 14:16:36', NULL),
(66, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-05-05 14:16:36', '2025-05-05 14:16:36', NULL),
(67, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-05-05 14:29:44', '2025-05-05 14:29:44', NULL),
(68, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-05-05 14:29:44', '2025-05-05 14:29:44', NULL),
(69, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-05-05 14:43:46', '2025-05-05 14:43:46', NULL),
(70, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-05-05 14:43:46', '2025-05-05 14:43:46', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `address_types`
--

CREATE TABLE `address_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name_en` varchar(255) NOT NULL,
  `name_ar` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `address_types`
--

INSERT INTO `address_types` (`id`, `name_en`, `name_ar`, `created_at`, `updated_at`) VALUES
(1, 'Shipping', 'شحن', '2025-03-23 17:14:16', '2025-03-23 17:14:16'),
(2, 'Billing', 'فواتير', '2025-03-23 17:14:16', '2025-03-23 17:14:16');

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `state_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `companies`
--

CREATE TABLE `companies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `legal_name` varchar(255) NOT NULL,
  `tax_number` varchar(255) NOT NULL,
  `website` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `phone_number` varchar(255) NOT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `meta` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`meta`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `companies`
--

INSERT INTO `companies` (`id`, `legal_name`, `tax_number`, `website`, `email`, `phone_number`, `logo`, `is_active`, `meta`, `created_at`, `updated_at`, `deleted_at`) VALUES
(3, 'Alyaa', '123123123123123', 'http://alyaa.sa/', 'info@alyaa.sa', '23413243123412', 'company-logos/01JTDS8QVH6KBFB7MMRPX2ZS9E.png', 1, NULL, '2025-05-04 13:55:14', '2025-05-04 13:55:14', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `country_iso_code` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `currencies`
--

CREATE TABLE `currencies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `symbol` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `currencies`
--

INSERT INTO `currencies` (`id`, `name`, `code`, `symbol`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Saudi Riyal', 'SAR', 'ر.س', '2025-03-23 17:14:16', '2025-03-23 17:14:16', NULL),
(2, 'US Dollar', 'USD', '$', '2025-03-23 17:14:16', '2025-03-23 17:14:16', NULL),
(3, 'Euro', 'EUR', '€', '2025-03-23 17:14:16', '2025-03-23 17:14:16', NULL),
(4, 'British Pound', 'GBP', '£', '2025-03-23 17:14:16', '2025-03-23 17:14:16', NULL),
(5, 'Pakistani Rupees', 'PKR', 'Rs', '2025-05-04 08:38:26', '2025-05-04 08:38:26', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone_number` varchar(255) DEFAULT NULL,
  `company_id` bigint(20) UNSIGNED DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `meta` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`meta`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `vat_number` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `point_of_sale_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `first_name`, `last_name`, `email`, `phone_number`, `company_id`, `is_active`, `meta`, `created_at`, `updated_at`, `deleted_at`, `vat_number`, `address`, `point_of_sale_id`) VALUES
(10, 'Guest', 'Customer', 'guest@gmail.com', '243253453', 3, 1, NULL, '2025-05-04 14:05:40', '2025-05-04 14:05:40', NULL, NULL, NULL, 7),
(11, 'Zain', 'ul Eman', 'zainuleman786@gmail.com', '03146775616', 3, 1, NULL, '2025-05-04 15:50:38', '2025-05-04 15:50:38', NULL, NULL, 'New Gulshan-e-Mehr Colony Multan near Masjid e Tasheer', 7),
(12, 'Testing', 'Cusomer', NULL, '797987', 3, 1, NULL, '2025-05-04 19:20:00', '2025-05-04 19:20:00', NULL, NULL, NULL, 7);

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
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `number` varchar(255) NOT NULL,
  `order_id` bigint(20) UNSIGNED DEFAULT NULL,
  `company_id` bigint(20) UNSIGNED DEFAULT NULL,
  `point_of_sale_id` bigint(20) UNSIGNED DEFAULT NULL,
  `customer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `issued_by_user` bigint(20) UNSIGNED DEFAULT NULL,
  `customer_name` varchar(255) NOT NULL,
  `customer_email` varchar(255) NOT NULL,
  `customer_phone` varchar(255) DEFAULT NULL,
  `subtotal` bigint(20) UNSIGNED NOT NULL,
  `discount` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `vat` decimal(10,2) DEFAULT NULL,
  `other_taxes` decimal(10,2) DEFAULT NULL,
  `total` bigint(20) UNSIGNED NOT NULL,
  `amount_paid` decimal(10,2) DEFAULT 0.00,
  `due_date` datetime DEFAULT NULL,
  `paid_date` datetime DEFAULT NULL,
  `issue_date` datetime NOT NULL,
  `meta` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`meta`)),
  `billing_address_id` bigint(20) UNSIGNED DEFAULT NULL,
  `shipping_address_id` bigint(20) UNSIGNED DEFAULT NULL,
  `invoice_status_id` bigint(20) UNSIGNED DEFAULT NULL,
  `currency_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `invoices`
--

INSERT INTO `invoices` (`id`, `number`, `order_id`, `company_id`, `point_of_sale_id`, `customer_id`, `issued_by_user`, `customer_name`, `customer_email`, `customer_phone`, `subtotal`, `discount`, `vat`, `other_taxes`, `total`, `amount_paid`, `due_date`, `paid_date`, `issue_date`, `meta`, `billing_address_id`, `shipping_address_id`, `invoice_status_id`, `currency_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(8, 'C003-INV-000001', 35, 3, 7, 10, 5, 'Guest Customer', 'guest@gmail.com', NULL, 80000, 60000, 3000.00, 0.00, 23000, 23000.00, '2025-06-04 17:44:58', NULL, '2025-05-05 17:44:58', NULL, NULL, NULL, 1, NULL, '2025-05-05 14:44:58', '2025-05-05 14:44:58', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `invoice_items`
--

CREATE TABLE `invoice_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `invoice_id` bigint(20) UNSIGNED NOT NULL,
  `product_name_en` varchar(255) NOT NULL,
  `product_name_ar` varchar(255) NOT NULL,
  `product_description_en` text DEFAULT NULL,
  `product_description_ar` text DEFAULT NULL,
  `product_sku` varchar(255) DEFAULT NULL,
  `product_code` varchar(255) DEFAULT NULL,
  `quantity` int(10) UNSIGNED NOT NULL,
  `unit_price` bigint(20) UNSIGNED NOT NULL,
  `tax_id` bigint(20) UNSIGNED DEFAULT NULL,
  `discount_amount` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `note` text DEFAULT NULL,
  `vat_amount` decimal(10,2) DEFAULT NULL,
  `other_taxes_amount` decimal(10,2) DEFAULT NULL,
  `total_price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `invoice_items`
--

INSERT INTO `invoice_items` (`id`, `invoice_id`, `product_name_en`, `product_name_ar`, `product_description_en`, `product_description_ar`, `product_sku`, `product_code`, `quantity`, `unit_price`, `tax_id`, `discount_amount`, `created_at`, `updated_at`, `deleted_at`, `note`, `vat_amount`, `other_taxes_amount`, `total_price`) VALUES
(92, 8, 'Sand', 'الرمل', NULL, NULL, NULL, NULL, 2, 20000, NULL, 20000, '2025-05-05 14:44:58', '2025-05-05 14:44:58', NULL, NULL, 1500.00, 0.00, 23000.00),
(93, 8, 'Anchors', 'المرابط', NULL, NULL, NULL, NULL, 1, 40000, NULL, 20000, '2025-05-05 14:44:58', '2025-05-05 14:44:58', NULL, NULL, 3000.00, 0.00, 23000.00);

-- --------------------------------------------------------

--
-- Table structure for table `invoice_statuses`
--

CREATE TABLE `invoice_statuses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name_en` varchar(255) NOT NULL,
  `name_ar` varchar(255) NOT NULL,
  `color` varchar(10) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `invoice_statuses`
--

INSERT INTO `invoice_statuses` (`id`, `name_en`, `name_ar`, `color`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Draft', 'مسودة', '#95a5a6', '2025-03-23 17:14:16', '2025-03-23 17:14:16', NULL),
(2, 'Sent', 'مرسلة', '#3498db', '2025-03-23 17:14:16', '2025-03-23 17:14:16', NULL),
(3, 'Paid', 'مدفوعة', '#2ecc71', '2025-03-23 17:14:16', '2025-03-23 17:14:16', NULL),
(4, 'Overdue', 'متأخرة', '#e74c3c', '2025-03-23 17:14:16', '2025-03-23 17:14:16', NULL),
(5, 'Cancelled', 'ملغاة', '#7f8c8d', '2025-03-23 17:14:16', '2025-03-23 17:14:16', NULL),
(6, 'Partially Paid', 'مدفوعة جزئيا', '#f39c12', '2025-03-23 17:14:16', '2025-03-23 17:14:16', NULL),
(7, 'Refunded', 'مسترجع', '#805ad5', '2025-03-23 17:14:30', '2025-03-23 17:14:30', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `invoice_template_settings`
--

CREATE TABLE `invoice_template_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `key_name` varchar(255) NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `value_en` text DEFAULT NULL,
  `value_ar` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `invoice_template_settings`
--

INSERT INTO `invoice_template_settings` (`id`, `key_name`, `company_id`, `value_en`, `value_ar`, `created_at`, `updated_at`) VALUES
(4, 'note', 3, '<p>&nbsp;Thank you for your business. Please review all materials and services provided. For any questions or concerns, feel free to contact us.&nbsp;</p>', '<p dir=\"rtl\"><strong>ملاحظة:</strong> شكرًا لتعاملكم معنا. يرجى مراجعة جميع المواد والخدمات المقدمة. إذا كان لديكم أي استفسارات أو ملاحظات، لا تترددوا في التواصل معنا.&nbsp;</p>', '2025-05-04 15:15:53', '2025-05-04 15:15:53');

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
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2014_10_12_100000_create_password_resets_table', 1),
(4, '2019_08_19_000000_create_failed_jobs_table', 1),
(5, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(6, '2024_02_26_193729_create_notifications_table', 1),
(7, '2024_06_20_000719_create_countries_table', 1),
(8, '2024_06_20_000720_create_states_table', 1),
(9, '2024_06_20_000721_create_cities_table', 1),
(10, '2024_06_20_001954_create_activity_log_table', 1),
(11, '2024_06_20_001955_add_event_column_to_activity_log_table', 1),
(12, '2024_06_20_001956_add_batch_uuid_column_to_activity_log_table', 1),
(13, '2024_09_28_040706_create_currencies_table', 1),
(14, '2025_03_16_025020_create_companies_table', 1),
(15, '2025_03_16_025021_create_customers_table', 1),
(16, '2025_03_16_025046_create_address_types_table', 1),
(17, '2025_03_16_025141_create_taxes_table', 1),
(18, '2025_03_16_025315_create_addresses_table', 1),
(19, '2025_03_16_025341_create_point_of_sales_table', 1),
(20, '2025_03_16_025407_create_product_categories_table', 1),
(21, '2025_03_16_025427_create_products_table', 1),
(22, '2025_03_16_025455_create_order_statuses_table', 1),
(23, '2025_03_16_025522_create_payment_methods_table', 1),
(24, '2025_03_16_025601_create_payment_statuses_table', 1),
(25, '2025_03_16_025704_create_transaction_statuses_table', 1),
(26, '2025_03_16_025728_create_invoice_statuses_table', 1),
(27, '2025_03_16_025754_create_orders_table', 1),
(28, '2025_03_16_025826_create_order_items_table', 1),
(30, '2025_03_16_025921_create_invoice_items_table', 1),
(31, '2025_03_16_025945_create_payments_table', 1),
(32, '2025_03_16_030009_create_transactions_table', 1),
(33, '2025_03_16_030028_create_notes_table', 1),
(34, '2025_03_16_030448_add_company_id_and_indexes_to_users_table', 1),
(35, '2025_03_17_221841_alter_customers_table', 1),
(36, '2025_03_23_190655_create_permission_tables', 1),
(37, '2025_04_09_174933_add_vat_number_and_address_to_customers', 2),
(38, '2025_04_09_184028_make_order_fields_nullable', 3),
(39, '2025_04_09_210352_add_company_id_to_products_and_product_categories_tables', 4),
(41, '2025_04_09_211436_create_product_tax_table', 5),
(42, '2025_04_10_154325_update_order_items_table_tax_amount_and_add_note', 6),
(43, '2025_04_10_205824_update_order_items_add_vat_amount_rename_tax_amount', 7),
(44, '2025_04_10_205833_update_orders_add_vat_rename_tax', 7),
(45, '2025_04_12_214628_create_invoice_template_settings_table', 8),
(46, '2025_04_13_163822_add_point_of_sale_id_to_users_table', 9),
(47, '2025_04_09_175000_add_point_of_sale_id_to_customers', 10),
(48, '2025_04_13_172054_add_point_of_sale_id_to_orders_table', 11),
(53, '2025_04_13_183502_update_invoice_items_table_add_note_vat_other_taxes', 14),
(54, '2025_04_13_183457_update_invoices_table_add_amount_paid_pos_vat_other_taxes', 15),
(55, '2025_05_04_102801_add_point_of_sale_id_to_product_categories_table', 16),
(56, '2025_04_07_151902_create_settings_table', 17),
(57, '2025_05_04_120814_add_quantity_to_products_table', 18),
(60, '2025_03_16_025849_create_invoices_table', 19),
(65, '2025_05_05_144705_add_discount_type_and_discount_totals_to_orders_table', 20),
(66, '2025_05_05_144721_add_discount_type_to_order_items_table', 21);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1),
(2, 'App\\Models\\User', 2),
(3, 'App\\Models\\User', 5);

-- --------------------------------------------------------

--
-- Table structure for table `notes`
--

CREATE TABLE `notes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `note` text NOT NULL,
  `notable_type` varchar(255) NOT NULL,
  `notable_id` bigint(20) UNSIGNED NOT NULL,
  `created_by_user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` char(36) NOT NULL,
  `type` varchar(255) NOT NULL,
  `notifiable_type` varchar(255) NOT NULL,
  `notifiable_id` bigint(20) UNSIGNED NOT NULL,
  `data` text NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `number` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `customer_name` varchar(255) DEFAULT NULL,
  `customer_email` varchar(255) DEFAULT NULL,
  `customer_phone_number` varchar(255) DEFAULT NULL,
  `company_id` bigint(20) UNSIGNED DEFAULT NULL,
  `customer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `order_status_id` bigint(20) UNSIGNED DEFAULT NULL,
  `shipping_fee` bigint(20) UNSIGNED DEFAULT NULL,
  `subtotal` bigint(20) UNSIGNED DEFAULT NULL,
  `subtotal_after_discount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `other_taxes` decimal(10,2) DEFAULT NULL,
  `discount_totals` decimal(15,2) NOT NULL DEFAULT 0.00,
  `total` bigint(20) UNSIGNED DEFAULT NULL,
  `payment_method_id` bigint(20) UNSIGNED DEFAULT NULL,
  `currency_id` bigint(20) UNSIGNED DEFAULT NULL,
  `billing_address_id` bigint(20) UNSIGNED DEFAULT NULL,
  `shipping_address_id` bigint(20) UNSIGNED DEFAULT NULL,
  `estimated_delivery_at` timestamp NULL DEFAULT NULL,
  `delivered_at` timestamp NULL DEFAULT NULL,
  `shipped_at` timestamp NULL DEFAULT NULL,
  `meta` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`meta`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `vat` decimal(10,2) DEFAULT NULL,
  `discount` decimal(10,2) DEFAULT NULL,
  `discount_type` varchar(255) NOT NULL DEFAULT 'fixed',
  `amount_paid` decimal(10,2) DEFAULT NULL,
  `point_of_sale_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `number`, `user_id`, `customer_name`, `customer_email`, `customer_phone_number`, `company_id`, `customer_id`, `order_status_id`, `shipping_fee`, `subtotal`, `subtotal_after_discount`, `other_taxes`, `discount_totals`, `total`, `payment_method_id`, `currency_id`, `billing_address_id`, `shipping_address_id`, `estimated_delivery_at`, `delivered_at`, `shipped_at`, `meta`, `created_at`, `updated_at`, `deleted_at`, `vat`, `discount`, `discount_type`, `amount_paid`, `point_of_sale_id`) VALUES
(35, 'ORD-202505-QIURGS', 5, NULL, NULL, NULL, 3, 10, 1, NULL, 800, 0.00, NULL, 600.00, 230, 4, 1, 70, 69, NULL, NULL, NULL, '[]', '2025-05-05 14:43:46', '2025-05-05 14:43:46', NULL, 30.00, 50.00, 'percentage', 0.00, 7);

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `product_name_en` varchar(255) NOT NULL,
  `product_name_ar` varchar(255) NOT NULL,
  `product_description_en` text DEFAULT NULL,
  `product_description_ar` text DEFAULT NULL,
  `product_sku` varchar(255) DEFAULT NULL,
  `product_code` varchar(255) DEFAULT NULL,
  `product_id` bigint(20) UNSIGNED DEFAULT NULL,
  `quantity` int(10) UNSIGNED DEFAULT NULL,
  `unit_price` bigint(20) UNSIGNED DEFAULT NULL,
  `tax_id` bigint(20) UNSIGNED DEFAULT NULL,
  `other_taxes_amount` decimal(10,2) DEFAULT NULL,
  `discount_amount` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `discount_type` varchar(255) NOT NULL DEFAULT 'fixed',
  `total_price` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `note` text DEFAULT NULL,
  `vat_amount` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_name_en`, `product_name_ar`, `product_description_en`, `product_description_ar`, `product_sku`, `product_code`, `product_id`, `quantity`, `unit_price`, `tax_id`, `other_taxes_amount`, `discount_amount`, `discount_type`, `total_price`, `created_at`, `updated_at`, `deleted_at`, `note`, `vat_amount`) VALUES
(61, 35, 'Sand', 'الرمل', NULL, NULL, NULL, NULL, 15, 2, 20000, NULL, 0.00, 50, 'percentage', 230, '2025-05-05 14:43:46', '2025-05-05 14:43:46', NULL, NULL, 15.00),
(62, 35, 'Anchors', 'المرابط', NULL, NULL, NULL, NULL, 19, 1, 40000, NULL, 0.00, 50, 'percentage', 230, '2025-05-05 14:43:46', '2025-05-05 14:43:46', NULL, NULL, 30.00);

-- --------------------------------------------------------

--
-- Table structure for table `order_statuses`
--

CREATE TABLE `order_statuses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name_en` varchar(255) NOT NULL,
  `name_ar` varchar(255) NOT NULL,
  `color` varchar(10) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_statuses`
--

INSERT INTO `order_statuses` (`id`, `name_en`, `name_ar`, `color`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'New', 'جديد', '#3498db', '2025-03-23 17:14:16', '2025-03-23 17:14:16', NULL),
(2, 'Processing', 'قيد المعالجة', '#f39c12', '2025-03-23 17:14:16', '2025-03-23 17:14:16', NULL),
(3, 'Shipped', 'تم الشحن', '#9b59b6', '2025-03-23 17:14:16', '2025-03-23 17:14:16', NULL),
(4, 'Delivered', 'تم التسليم', '#2ecc71', '2025-03-23 17:14:16', '2025-03-23 17:14:16', NULL),
(5, 'Cancelled', 'ملغي', '#e74c3c', '2025-03-23 17:14:16', '2025-03-23 17:14:16', NULL);

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
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED DEFAULT NULL,
  `invoice_id` bigint(20) UNSIGNED DEFAULT NULL,
  `payment_status_id` bigint(20) UNSIGNED DEFAULT NULL,
  `payment_method_id` bigint(20) UNSIGNED DEFAULT NULL,
  `currency_id` bigint(20) UNSIGNED DEFAULT NULL,
  `amount` bigint(20) UNSIGNED NOT NULL,
  `payment_date` datetime DEFAULT NULL,
  `transaction_reference` varchar(255) DEFAULT NULL,
  `meta` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`meta`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment_methods`
--

CREATE TABLE `payment_methods` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name_en` varchar(255) NOT NULL,
  `name_ar` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payment_methods`
--

INSERT INTO `payment_methods` (`id`, `name_en`, `name_ar`, `code`, `icon`, `is_active`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Credit Card', 'بطاقة ائتمان', 'credit_card', 'credit-card', 1, '2025-03-23 17:14:16', '2025-03-23 17:14:16', NULL),
(2, 'PayPal', 'باي بال', 'paypal', 'paypal', 1, '2025-03-23 17:14:16', '2025-03-23 17:14:16', NULL),
(3, 'Bank Transfer', 'تحويل بنكي', 'bank_transfer', 'bank', 1, '2025-03-23 17:14:16', '2025-03-23 17:14:16', NULL),
(4, 'Cash on Delivery', 'الدفع عند الاستلام', 'cod', 'money', 1, '2025-03-23 17:14:16', '2025-03-23 17:14:16', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `payment_statuses`
--

CREATE TABLE `payment_statuses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name_en` varchar(255) NOT NULL,
  `name_ar` varchar(255) NOT NULL,
  `color` varchar(10) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payment_statuses`
--

INSERT INTO `payment_statuses` (`id`, `name_en`, `name_ar`, `color`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Pending', 'قيد الانتظار', '#f39c12', '2025-03-23 17:14:16', '2025-03-23 17:14:16', NULL),
(2, 'Completed', 'مكتمل', '#2ecc71', '2025-03-23 17:14:16', '2025-03-23 17:14:16', NULL),
(3, 'Failed', 'فشل', '#e74c3c', '2025-03-23 17:14:16', '2025-03-23 17:14:16', NULL),
(4, 'Refunded', 'مسترجع', '#3498db', '2025-03-23 17:14:16', '2025-03-23 17:14:16', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'view_address::type', 'web', '2025-03-23 17:19:21', '2025-03-23 17:19:21'),
(2, 'view_any_address::type', 'web', '2025-03-23 17:19:21', '2025-03-23 17:19:21'),
(3, 'create_address::type', 'web', '2025-03-23 17:19:21', '2025-03-23 17:19:21'),
(4, 'update_address::type', 'web', '2025-03-23 17:19:21', '2025-03-23 17:19:21'),
(5, 'restore_address::type', 'web', '2025-03-23 17:19:21', '2025-03-23 17:19:21'),
(6, 'restore_any_address::type', 'web', '2025-03-23 17:19:21', '2025-03-23 17:19:21'),
(7, 'replicate_address::type', 'web', '2025-03-23 17:19:21', '2025-03-23 17:19:21'),
(8, 'reorder_address::type', 'web', '2025-03-23 17:19:21', '2025-03-23 17:19:21'),
(9, 'delete_address::type', 'web', '2025-03-23 17:19:21', '2025-03-23 17:19:21'),
(10, 'delete_any_address::type', 'web', '2025-03-23 17:19:21', '2025-03-23 17:19:21'),
(11, 'force_delete_address::type', 'web', '2025-03-23 17:19:21', '2025-03-23 17:19:21'),
(12, 'force_delete_any_address::type', 'web', '2025-03-23 17:19:21', '2025-03-23 17:19:21'),
(13, 'view_currency', 'web', '2025-03-23 17:19:21', '2025-03-23 17:19:21'),
(14, 'view_any_currency', 'web', '2025-03-23 17:19:21', '2025-03-23 17:19:21'),
(15, 'create_currency', 'web', '2025-03-23 17:19:21', '2025-03-23 17:19:21'),
(16, 'update_currency', 'web', '2025-03-23 17:19:21', '2025-03-23 17:19:21'),
(17, 'restore_currency', 'web', '2025-03-23 17:19:21', '2025-03-23 17:19:21'),
(18, 'restore_any_currency', 'web', '2025-03-23 17:19:21', '2025-03-23 17:19:21'),
(19, 'replicate_currency', 'web', '2025-03-23 17:19:21', '2025-03-23 17:19:21'),
(20, 'reorder_currency', 'web', '2025-03-23 17:19:21', '2025-03-23 17:19:21'),
(21, 'delete_currency', 'web', '2025-03-23 17:19:21', '2025-03-23 17:19:21'),
(22, 'delete_any_currency', 'web', '2025-03-23 17:19:21', '2025-03-23 17:19:21'),
(23, 'force_delete_currency', 'web', '2025-03-23 17:19:21', '2025-03-23 17:19:21'),
(24, 'force_delete_any_currency', 'web', '2025-03-23 17:19:21', '2025-03-23 17:19:21'),
(25, 'view_customer', 'web', '2025-03-23 17:19:21', '2025-03-23 17:19:21'),
(26, 'view_any_customer', 'web', '2025-03-23 17:19:21', '2025-03-23 17:19:21'),
(27, 'create_customer', 'web', '2025-03-23 17:19:21', '2025-03-23 17:19:21'),
(28, 'update_customer', 'web', '2025-03-23 17:19:21', '2025-03-23 17:19:21'),
(29, 'restore_customer', 'web', '2025-03-23 17:19:21', '2025-03-23 17:19:21'),
(30, 'restore_any_customer', 'web', '2025-03-23 17:19:21', '2025-03-23 17:19:21'),
(31, 'replicate_customer', 'web', '2025-03-23 17:19:21', '2025-03-23 17:19:21'),
(32, 'reorder_customer', 'web', '2025-03-23 17:19:21', '2025-03-23 17:19:21'),
(33, 'delete_customer', 'web', '2025-03-23 17:19:21', '2025-03-23 17:19:21'),
(34, 'delete_any_customer', 'web', '2025-03-23 17:19:21', '2025-03-23 17:19:21'),
(35, 'force_delete_customer', 'web', '2025-03-23 17:19:21', '2025-03-23 17:19:21'),
(36, 'force_delete_any_customer', 'web', '2025-03-23 17:19:21', '2025-03-23 17:19:21'),
(37, 'view_invoice', 'web', '2025-03-23 17:19:21', '2025-03-23 17:19:21'),
(38, 'view_any_invoice', 'web', '2025-03-23 17:19:21', '2025-03-23 17:19:21'),
(39, 'create_invoice', 'web', '2025-03-23 17:19:21', '2025-03-23 17:19:21'),
(40, 'update_invoice', 'web', '2025-03-23 17:19:21', '2025-03-23 17:19:21'),
(41, 'restore_invoice', 'web', '2025-03-23 17:19:21', '2025-03-23 17:19:21'),
(42, 'restore_any_invoice', 'web', '2025-03-23 17:19:21', '2025-03-23 17:19:21'),
(43, 'replicate_invoice', 'web', '2025-03-23 17:19:21', '2025-03-23 17:19:21'),
(44, 'reorder_invoice', 'web', '2025-03-23 17:19:21', '2025-03-23 17:19:21'),
(45, 'delete_invoice', 'web', '2025-03-23 17:19:21', '2025-03-23 17:19:21'),
(46, 'delete_any_invoice', 'web', '2025-03-23 17:19:21', '2025-03-23 17:19:21'),
(47, 'force_delete_invoice', 'web', '2025-03-23 17:19:21', '2025-03-23 17:19:21'),
(48, 'force_delete_any_invoice', 'web', '2025-03-23 17:19:21', '2025-03-23 17:19:21'),
(49, 'view_order', 'web', '2025-03-23 17:19:21', '2025-03-23 17:19:21'),
(50, 'view_any_order', 'web', '2025-03-23 17:19:21', '2025-03-23 17:19:21'),
(51, 'create_order', 'web', '2025-03-23 17:19:21', '2025-03-23 17:19:21'),
(52, 'update_order', 'web', '2025-03-23 17:19:21', '2025-03-23 17:19:21'),
(53, 'restore_order', 'web', '2025-03-23 17:19:21', '2025-03-23 17:19:21'),
(54, 'restore_any_order', 'web', '2025-03-23 17:19:21', '2025-03-23 17:19:21'),
(55, 'replicate_order', 'web', '2025-03-23 17:19:21', '2025-03-23 17:19:21'),
(56, 'reorder_order', 'web', '2025-03-23 17:19:21', '2025-03-23 17:19:21'),
(57, 'delete_order', 'web', '2025-03-23 17:19:21', '2025-03-23 17:19:21'),
(58, 'delete_any_order', 'web', '2025-03-23 17:19:21', '2025-03-23 17:19:21'),
(59, 'force_delete_order', 'web', '2025-03-23 17:19:21', '2025-03-23 17:19:21'),
(60, 'force_delete_any_order', 'web', '2025-03-23 17:19:21', '2025-03-23 17:19:21'),
(61, 'view_order::status', 'web', '2025-03-23 17:19:21', '2025-03-23 17:19:21'),
(62, 'view_any_order::status', 'web', '2025-03-23 17:19:21', '2025-03-23 17:19:21'),
(63, 'create_order::status', 'web', '2025-03-23 17:19:21', '2025-03-23 17:19:21'),
(64, 'update_order::status', 'web', '2025-03-23 17:19:21', '2025-03-23 17:19:21'),
(65, 'restore_order::status', 'web', '2025-03-23 17:19:21', '2025-03-23 17:19:21'),
(66, 'restore_any_order::status', 'web', '2025-03-23 17:19:21', '2025-03-23 17:19:21'),
(67, 'replicate_order::status', 'web', '2025-03-23 17:19:21', '2025-03-23 17:19:21'),
(68, 'reorder_order::status', 'web', '2025-03-23 17:19:21', '2025-03-23 17:19:21'),
(69, 'delete_order::status', 'web', '2025-03-23 17:19:21', '2025-03-23 17:19:21'),
(70, 'delete_any_order::status', 'web', '2025-03-23 17:19:21', '2025-03-23 17:19:21'),
(71, 'force_delete_order::status', 'web', '2025-03-23 17:19:21', '2025-03-23 17:19:21'),
(72, 'force_delete_any_order::status', 'web', '2025-03-23 17:19:21', '2025-03-23 17:19:21'),
(73, 'view_payment::method', 'web', '2025-03-23 17:19:21', '2025-03-23 17:19:21'),
(74, 'view_any_payment::method', 'web', '2025-03-23 17:19:21', '2025-03-23 17:19:21'),
(75, 'create_payment::method', 'web', '2025-03-23 17:19:21', '2025-03-23 17:19:21'),
(76, 'update_payment::method', 'web', '2025-03-23 17:19:22', '2025-03-23 17:19:22'),
(77, 'restore_payment::method', 'web', '2025-03-23 17:19:22', '2025-03-23 17:19:22'),
(78, 'restore_any_payment::method', 'web', '2025-03-23 17:19:22', '2025-03-23 17:19:22'),
(79, 'replicate_payment::method', 'web', '2025-03-23 17:19:22', '2025-03-23 17:19:22'),
(80, 'reorder_payment::method', 'web', '2025-03-23 17:19:22', '2025-03-23 17:19:22'),
(81, 'delete_payment::method', 'web', '2025-03-23 17:19:22', '2025-03-23 17:19:22'),
(82, 'delete_any_payment::method', 'web', '2025-03-23 17:19:22', '2025-03-23 17:19:22'),
(83, 'force_delete_payment::method', 'web', '2025-03-23 17:19:22', '2025-03-23 17:19:22'),
(84, 'force_delete_any_payment::method', 'web', '2025-03-23 17:19:22', '2025-03-23 17:19:22'),
(85, 'view_payment::status', 'web', '2025-03-23 17:19:22', '2025-03-23 17:19:22'),
(86, 'view_any_payment::status', 'web', '2025-03-23 17:19:22', '2025-03-23 17:19:22'),
(87, 'create_payment::status', 'web', '2025-03-23 17:19:22', '2025-03-23 17:19:22'),
(88, 'update_payment::status', 'web', '2025-03-23 17:19:22', '2025-03-23 17:19:22'),
(89, 'restore_payment::status', 'web', '2025-03-23 17:19:22', '2025-03-23 17:19:22'),
(90, 'restore_any_payment::status', 'web', '2025-03-23 17:19:22', '2025-03-23 17:19:22'),
(91, 'replicate_payment::status', 'web', '2025-03-23 17:19:22', '2025-03-23 17:19:22'),
(92, 'reorder_payment::status', 'web', '2025-03-23 17:19:22', '2025-03-23 17:19:22'),
(93, 'delete_payment::status', 'web', '2025-03-23 17:19:22', '2025-03-23 17:19:22'),
(94, 'delete_any_payment::status', 'web', '2025-03-23 17:19:22', '2025-03-23 17:19:22'),
(95, 'force_delete_payment::status', 'web', '2025-03-23 17:19:22', '2025-03-23 17:19:22'),
(96, 'force_delete_any_payment::status', 'web', '2025-03-23 17:19:22', '2025-03-23 17:19:22'),
(97, 'view_point::of::sale', 'web', '2025-03-23 17:19:22', '2025-03-23 17:19:22'),
(98, 'view_any_point::of::sale', 'web', '2025-03-23 17:19:22', '2025-03-23 17:19:22'),
(99, 'create_point::of::sale', 'web', '2025-03-23 17:19:22', '2025-03-23 17:19:22'),
(100, 'update_point::of::sale', 'web', '2025-03-23 17:19:22', '2025-03-23 17:19:22'),
(101, 'restore_point::of::sale', 'web', '2025-03-23 17:19:22', '2025-03-23 17:19:22'),
(102, 'restore_any_point::of::sale', 'web', '2025-03-23 17:19:22', '2025-03-23 17:19:22'),
(103, 'replicate_point::of::sale', 'web', '2025-03-23 17:19:22', '2025-03-23 17:19:22'),
(104, 'reorder_point::of::sale', 'web', '2025-03-23 17:19:22', '2025-03-23 17:19:22'),
(105, 'delete_point::of::sale', 'web', '2025-03-23 17:19:22', '2025-03-23 17:19:22'),
(106, 'delete_any_point::of::sale', 'web', '2025-03-23 17:19:22', '2025-03-23 17:19:22'),
(107, 'force_delete_point::of::sale', 'web', '2025-03-23 17:19:22', '2025-03-23 17:19:22'),
(108, 'force_delete_any_point::of::sale', 'web', '2025-03-23 17:19:22', '2025-03-23 17:19:22'),
(109, 'view_product', 'web', '2025-03-23 17:19:22', '2025-03-23 17:19:22'),
(110, 'view_any_product', 'web', '2025-03-23 17:19:22', '2025-03-23 17:19:22'),
(111, 'create_product', 'web', '2025-03-23 17:19:22', '2025-03-23 17:19:22'),
(112, 'update_product', 'web', '2025-03-23 17:19:22', '2025-03-23 17:19:22'),
(113, 'restore_product', 'web', '2025-03-23 17:19:22', '2025-03-23 17:19:22'),
(114, 'restore_any_product', 'web', '2025-03-23 17:19:22', '2025-03-23 17:19:22'),
(115, 'replicate_product', 'web', '2025-03-23 17:19:22', '2025-03-23 17:19:22'),
(116, 'reorder_product', 'web', '2025-03-23 17:19:22', '2025-03-23 17:19:22'),
(117, 'delete_product', 'web', '2025-03-23 17:19:22', '2025-03-23 17:19:22'),
(118, 'delete_any_product', 'web', '2025-03-23 17:19:22', '2025-03-23 17:19:22'),
(119, 'force_delete_product', 'web', '2025-03-23 17:19:22', '2025-03-23 17:19:22'),
(120, 'force_delete_any_product', 'web', '2025-03-23 17:19:22', '2025-03-23 17:19:22'),
(121, 'view_product::category', 'web', '2025-03-23 17:19:22', '2025-03-23 17:19:22'),
(122, 'view_any_product::category', 'web', '2025-03-23 17:19:22', '2025-03-23 17:19:22'),
(123, 'create_product::category', 'web', '2025-03-23 17:19:22', '2025-03-23 17:19:22'),
(124, 'update_product::category', 'web', '2025-03-23 17:19:22', '2025-03-23 17:19:22'),
(125, 'restore_product::category', 'web', '2025-03-23 17:19:22', '2025-03-23 17:19:22'),
(126, 'restore_any_product::category', 'web', '2025-03-23 17:19:22', '2025-03-23 17:19:22'),
(127, 'replicate_product::category', 'web', '2025-03-23 17:19:22', '2025-03-23 17:19:22'),
(128, 'reorder_product::category', 'web', '2025-03-23 17:19:22', '2025-03-23 17:19:22'),
(129, 'delete_product::category', 'web', '2025-03-23 17:19:22', '2025-03-23 17:19:22'),
(130, 'delete_any_product::category', 'web', '2025-03-23 17:19:22', '2025-03-23 17:19:22'),
(131, 'force_delete_product::category', 'web', '2025-03-23 17:19:22', '2025-03-23 17:19:22'),
(132, 'force_delete_any_product::category', 'web', '2025-03-23 17:19:22', '2025-03-23 17:19:22'),
(133, 'view_role', 'web', '2025-03-23 17:19:22', '2025-03-23 17:19:22'),
(134, 'view_any_role', 'web', '2025-03-23 17:19:22', '2025-03-23 17:19:22'),
(135, 'create_role', 'web', '2025-03-23 17:19:22', '2025-03-23 17:19:22'),
(136, 'update_role', 'web', '2025-03-23 17:19:22', '2025-03-23 17:19:22'),
(137, 'delete_role', 'web', '2025-03-23 17:19:22', '2025-03-23 17:19:22'),
(138, 'delete_any_role', 'web', '2025-03-23 17:19:22', '2025-03-23 17:19:22'),
(139, 'view_tax', 'web', '2025-03-23 17:19:22', '2025-03-23 17:19:22'),
(140, 'view_any_tax', 'web', '2025-03-23 17:19:22', '2025-03-23 17:19:22'),
(141, 'create_tax', 'web', '2025-03-23 17:19:22', '2025-03-23 17:19:22'),
(142, 'update_tax', 'web', '2025-03-23 17:19:22', '2025-03-23 17:19:22'),
(143, 'restore_tax', 'web', '2025-03-23 17:19:22', '2025-03-23 17:19:22'),
(144, 'restore_any_tax', 'web', '2025-03-23 17:19:22', '2025-03-23 17:19:22'),
(145, 'replicate_tax', 'web', '2025-03-23 17:19:22', '2025-03-23 17:19:22'),
(146, 'reorder_tax', 'web', '2025-03-23 17:19:22', '2025-03-23 17:19:22'),
(147, 'delete_tax', 'web', '2025-03-23 17:19:22', '2025-03-23 17:19:22'),
(148, 'delete_any_tax', 'web', '2025-03-23 17:19:22', '2025-03-23 17:19:22'),
(149, 'force_delete_tax', 'web', '2025-03-23 17:19:22', '2025-03-23 17:19:22'),
(150, 'force_delete_any_tax', 'web', '2025-03-23 17:19:22', '2025-03-23 17:19:22'),
(151, 'view_invoice::template::setting', 'web', '2025-04-13 13:55:36', '2025-04-13 13:55:36'),
(152, 'view_any_invoice::template::setting', 'web', '2025-04-13 13:55:36', '2025-04-13 13:55:36'),
(153, 'create_invoice::template::setting', 'web', '2025-04-13 13:55:36', '2025-04-13 13:55:36'),
(154, 'update_invoice::template::setting', 'web', '2025-04-13 13:55:36', '2025-04-13 13:55:36'),
(155, 'restore_invoice::template::setting', 'web', '2025-04-13 13:55:36', '2025-04-13 13:55:36'),
(156, 'restore_any_invoice::template::setting', 'web', '2025-04-13 13:55:36', '2025-04-13 13:55:36'),
(157, 'replicate_invoice::template::setting', 'web', '2025-04-13 13:55:36', '2025-04-13 13:55:36'),
(158, 'reorder_invoice::template::setting', 'web', '2025-04-13 13:55:36', '2025-04-13 13:55:36'),
(159, 'delete_invoice::template::setting', 'web', '2025-04-13 13:55:36', '2025-04-13 13:55:36'),
(160, 'delete_any_invoice::template::setting', 'web', '2025-04-13 13:55:36', '2025-04-13 13:55:36'),
(161, 'force_delete_invoice::template::setting', 'web', '2025-04-13 13:55:36', '2025-04-13 13:55:36'),
(162, 'force_delete_any_invoice::template::setting', 'web', '2025-04-13 13:55:36', '2025-04-13 13:55:36'),
(163, 'view_user', 'web', '2025-04-13 13:55:36', '2025-04-13 13:55:36'),
(164, 'view_any_user', 'web', '2025-04-13 13:55:36', '2025-04-13 13:55:36'),
(165, 'create_user', 'web', '2025-04-13 13:55:36', '2025-04-13 13:55:36'),
(166, 'update_user', 'web', '2025-04-13 13:55:36', '2025-04-13 13:55:36'),
(167, 'restore_user', 'web', '2025-04-13 13:55:36', '2025-04-13 13:55:36'),
(168, 'restore_any_user', 'web', '2025-04-13 13:55:36', '2025-04-13 13:55:36'),
(169, 'replicate_user', 'web', '2025-04-13 13:55:36', '2025-04-13 13:55:36'),
(170, 'reorder_user', 'web', '2025-04-13 13:55:36', '2025-04-13 13:55:36'),
(171, 'delete_user', 'web', '2025-04-13 13:55:36', '2025-04-13 13:55:36'),
(172, 'delete_any_user', 'web', '2025-04-13 13:55:36', '2025-04-13 13:55:36'),
(173, 'force_delete_user', 'web', '2025-04-13 13:55:36', '2025-04-13 13:55:36'),
(174, 'force_delete_any_user', 'web', '2025-04-13 13:55:36', '2025-04-13 13:55:36'),
(175, 'view_company', 'web', '2025-05-04 04:39:32', '2025-05-04 04:39:32'),
(176, 'view_any_company', 'web', '2025-05-04 04:39:32', '2025-05-04 04:39:32'),
(177, 'create_company', 'web', '2025-05-04 04:39:32', '2025-05-04 04:39:32'),
(178, 'update_company', 'web', '2025-05-04 04:39:32', '2025-05-04 04:39:32'),
(179, 'restore_company', 'web', '2025-05-04 04:39:32', '2025-05-04 04:39:32'),
(180, 'restore_any_company', 'web', '2025-05-04 04:39:32', '2025-05-04 04:39:32'),
(181, 'replicate_company', 'web', '2025-05-04 04:39:32', '2025-05-04 04:39:32'),
(182, 'reorder_company', 'web', '2025-05-04 04:39:32', '2025-05-04 04:39:32'),
(183, 'delete_company', 'web', '2025-05-04 04:39:32', '2025-05-04 04:39:32'),
(184, 'delete_any_company', 'web', '2025-05-04 04:39:32', '2025-05-04 04:39:32'),
(185, 'force_delete_company', 'web', '2025-05-04 04:39:32', '2025-05-04 04:39:32'),
(186, 'force_delete_any_company', 'web', '2025-05-04 04:39:32', '2025-05-04 04:39:32'),
(187, 'view_setting', 'web', '2025-05-04 08:34:57', '2025-05-04 08:34:57'),
(188, 'view_any_setting', 'web', '2025-05-04 08:34:57', '2025-05-04 08:34:57'),
(189, 'create_setting', 'web', '2025-05-04 08:34:57', '2025-05-04 08:34:57'),
(190, 'update_setting', 'web', '2025-05-04 08:34:57', '2025-05-04 08:34:57'),
(191, 'restore_setting', 'web', '2025-05-04 08:34:57', '2025-05-04 08:34:57'),
(192, 'restore_any_setting', 'web', '2025-05-04 08:34:57', '2025-05-04 08:34:57'),
(193, 'replicate_setting', 'web', '2025-05-04 08:34:57', '2025-05-04 08:34:57'),
(194, 'reorder_setting', 'web', '2025-05-04 08:34:57', '2025-05-04 08:34:57'),
(195, 'delete_setting', 'web', '2025-05-04 08:34:57', '2025-05-04 08:34:57'),
(196, 'delete_any_setting', 'web', '2025-05-04 08:34:57', '2025-05-04 08:34:57'),
(197, 'force_delete_setting', 'web', '2025-05-04 08:34:57', '2025-05-04 08:34:57'),
(198, 'force_delete_any_setting', 'web', '2025-05-04 08:34:57', '2025-05-04 08:34:57');

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
-- Table structure for table `point_of_sales`
--

CREATE TABLE `point_of_sales` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name_en` varchar(255) NOT NULL,
  `name_ar` varchar(255) NOT NULL,
  `description_en` text DEFAULT NULL,
  `description_ar` text DEFAULT NULL,
  `company_id` bigint(20) UNSIGNED DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `meta` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`meta`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `point_of_sales`
--

INSERT INTO `point_of_sales` (`id`, `name_en`, `name_ar`, `description_en`, `description_ar`, `company_id`, `is_active`, `meta`, `created_at`, `updated_at`, `deleted_at`) VALUES
(7, 'alyaa', 'علياء', NULL, NULL, 3, 1, '[]', '2025-05-04 13:55:53', '2025-05-04 13:55:53', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `point_of_sale_user`
--

CREATE TABLE `point_of_sale_user` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `point_of_sale_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name_en` varchar(255) NOT NULL,
  `name_ar` varchar(255) NOT NULL,
  `description_en` text DEFAULT NULL,
  `description_ar` text DEFAULT NULL,
  `slug` varchar(255) NOT NULL,
  `sku` varchar(255) DEFAULT NULL,
  `code` varchar(255) DEFAULT NULL,
  `price` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 0,
  `sale_price` bigint(20) UNSIGNED DEFAULT NULL,
  `currency_id` bigint(20) UNSIGNED DEFAULT NULL,
  `product_category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `point_of_sale_id` bigint(20) UNSIGNED DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `company_id`, `name_en`, `name_ar`, `description_en`, `description_ar`, `slug`, `sku`, `code`, `price`, `quantity`, `sale_price`, `currency_id`, `product_category_id`, `point_of_sale_id`, `image_url`, `is_active`, `created_at`, `updated_at`, `deleted_at`) VALUES
(14, 3, 'Cement', 'الأسمنت', NULL, NULL, 'alasmnt', NULL, NULL, 2000, 0, 2300, 1, 8, 7, NULL, 1, '2025-05-04 14:01:24', '2025-05-05 13:18:04', NULL),
(15, 3, 'Sand', 'الرمل', NULL, NULL, 'alrml', NULL, NULL, 4000, 5, 4600, 1, 8, 7, NULL, 1, '2025-05-04 14:02:08', '2025-05-05 14:43:46', NULL),
(16, 3, 'Helmets', 'الخوذ', NULL, NULL, 'alkhoth', NULL, NULL, 2000, 34, 2300, 1, 10, 7, NULL, 1, '2025-05-04 14:02:38', '2025-05-05 14:29:44', NULL),
(17, 3, 'Boots ', ' الأحذية الواقية', NULL, NULL, 'alahthy-aloaky', NULL, NULL, 5500, 0, 5500, 1, 10, 7, NULL, 1, '2025-05-04 14:03:09', '2025-05-04 14:03:09', NULL),
(18, 3, 'Hinges', 'المفصلات', NULL, NULL, 'almfslat', NULL, NULL, 5500, 0, 6325, 1, 9, 7, NULL, 1, '2025-05-04 14:03:44', '2025-05-05 13:43:39', NULL),
(19, 3, 'Anchors', 'المرابط', NULL, NULL, 'almrabt', NULL, NULL, 8500, 20, 9775, 1, 9, 7, NULL, 1, '2025-05-04 14:04:20', '2025-05-05 14:43:46', NULL),
(20, 3, 'testing', 'gisdn', NULL, NULL, 'gisdn', NULL, NULL, 1000, 10, 1150, 1, 11, 7, NULL, 1, '2025-05-04 19:11:56', '2025-05-04 19:11:56', NULL),
(21, 3, 'Testing', 'Testing', NULL, NULL, 'tesitng', NULL, NULL, 2000, 0, 2300, 1, 9, 7, NULL, 1, '2025-05-04 19:19:13', '2025-05-04 19:19:13', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `product_categories`
--

CREATE TABLE `product_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED DEFAULT NULL,
  `point_of_sale_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name_en` varchar(255) NOT NULL,
  `name_ar` varchar(255) NOT NULL,
  `description_en` text DEFAULT NULL,
  `description_ar` text DEFAULT NULL,
  `slug` varchar(255) NOT NULL,
  `parent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_categories`
--

INSERT INTO `product_categories` (`id`, `company_id`, `point_of_sale_id`, `name_en`, `name_ar`, `description_en`, `description_ar`, `slug`, `parent_id`, `is_active`, `created_at`, `updated_at`, `deleted_at`) VALUES
(8, 3, 7, 'Building Materials', 'مواد البناء', NULL, NULL, 'building-materials', NULL, 1, '2025-05-04 13:59:21', '2025-05-04 13:59:21', NULL),
(9, 3, 7, 'Hardware & Fasteners', ' العدد والمثبتات', NULL, NULL, 'hardware-fasteners', NULL, 1, '2025-05-04 13:59:35', '2025-05-04 13:59:35', NULL),
(10, 3, 7, 'Safety Gear', 'معدات السلامة', NULL, NULL, 'safety-gear', NULL, 1, '2025-05-04 13:59:51', '2025-05-04 13:59:51', NULL),
(11, 3, 7, 'testing', 'fdsjal', NULL, NULL, 'testing', NULL, 1, '2025-05-04 19:11:26', '2025-05-04 19:11:26', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `product_tax`
--

CREATE TABLE `product_tax` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `tax_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_tax`
--

INSERT INTO `product_tax` (`id`, `product_id`, `tax_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(13, 14, 4, '2025-05-04 14:01:34', '2025-05-04 14:01:34', NULL),
(14, 15, 4, '2025-05-04 14:02:08', '2025-05-04 14:02:08', NULL),
(15, 16, 4, '2025-05-04 14:02:38', '2025-05-04 14:02:38', NULL),
(16, 18, 4, '2025-05-04 14:03:44', '2025-05-04 14:03:44', NULL),
(17, 19, 4, '2025-05-04 14:04:20', '2025-05-04 14:04:20', NULL),
(18, 20, 4, '2025-05-04 19:11:56', '2025-05-04 19:11:56', NULL),
(19, 21, 4, '2025-05-04 19:19:13', '2025-05-04 19:19:13', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'super_admin', 'web', '2025-03-23 17:19:21', '2025-03-23 17:19:21'),
(2, 'user', 'web', '2025-03-23 17:57:09', '2025-03-23 17:57:09'),
(3, 'point_of_sale', 'web', '2025-04-13 13:55:36', '2025-04-13 13:55:36');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 1),
(1, 2),
(2, 1),
(3, 1),
(3, 2),
(4, 1),
(4, 2),
(5, 1),
(5, 2),
(6, 1),
(7, 1),
(7, 2),
(8, 1),
(8, 2),
(9, 1),
(9, 2),
(10, 1),
(11, 1),
(11, 2),
(12, 1),
(12, 2),
(13, 1),
(13, 2),
(14, 1),
(15, 1),
(15, 2),
(16, 1),
(16, 2),
(17, 1),
(17, 2),
(18, 1),
(19, 1),
(19, 2),
(20, 1),
(20, 2),
(21, 1),
(21, 2),
(22, 1),
(23, 1),
(23, 2),
(24, 1),
(24, 2),
(25, 1),
(25, 2),
(25, 3),
(26, 1),
(26, 3),
(27, 1),
(27, 2),
(27, 3),
(28, 1),
(28, 2),
(28, 3),
(29, 1),
(29, 2),
(29, 3),
(30, 1),
(30, 3),
(31, 1),
(31, 2),
(31, 3),
(32, 1),
(32, 2),
(32, 3),
(33, 1),
(33, 2),
(33, 3),
(34, 1),
(34, 3),
(35, 1),
(35, 2),
(35, 3),
(36, 1),
(36, 2),
(36, 3),
(37, 1),
(37, 2),
(37, 3),
(38, 1),
(38, 3),
(39, 1),
(39, 2),
(39, 3),
(40, 1),
(40, 2),
(40, 3),
(41, 1),
(41, 2),
(41, 3),
(42, 1),
(42, 3),
(43, 1),
(43, 2),
(43, 3),
(44, 1),
(44, 2),
(44, 3),
(45, 1),
(45, 2),
(45, 3),
(46, 1),
(46, 3),
(47, 1),
(47, 2),
(47, 3),
(48, 1),
(48, 2),
(48, 3),
(49, 1),
(49, 2),
(49, 3),
(50, 1),
(50, 3),
(51, 1),
(51, 2),
(51, 3),
(52, 1),
(52, 2),
(52, 3),
(53, 1),
(53, 2),
(53, 3),
(54, 1),
(54, 3),
(55, 1),
(55, 2),
(55, 3),
(56, 1),
(56, 2),
(56, 3),
(57, 1),
(57, 2),
(57, 3),
(58, 1),
(58, 3),
(59, 1),
(59, 2),
(59, 3),
(60, 1),
(60, 2),
(60, 3),
(61, 1),
(61, 2),
(61, 3),
(62, 1),
(62, 3),
(63, 1),
(63, 2),
(63, 3),
(64, 1),
(64, 2),
(64, 3),
(65, 1),
(65, 2),
(65, 3),
(66, 1),
(66, 3),
(67, 1),
(67, 2),
(67, 3),
(68, 1),
(68, 2),
(68, 3),
(69, 1),
(69, 2),
(69, 3),
(70, 1),
(70, 3),
(71, 1),
(71, 2),
(71, 3),
(72, 1),
(72, 2),
(72, 3),
(73, 1),
(73, 2),
(73, 3),
(74, 1),
(74, 3),
(75, 1),
(75, 2),
(75, 3),
(76, 1),
(76, 2),
(76, 3),
(77, 1),
(77, 2),
(77, 3),
(78, 1),
(78, 3),
(79, 1),
(79, 2),
(79, 3),
(80, 1),
(80, 2),
(80, 3),
(81, 1),
(81, 2),
(81, 3),
(82, 1),
(82, 3),
(83, 1),
(83, 2),
(83, 3),
(84, 1),
(84, 2),
(84, 3),
(85, 1),
(85, 2),
(85, 3),
(86, 1),
(86, 3),
(87, 1),
(87, 2),
(87, 3),
(88, 1),
(88, 2),
(88, 3),
(89, 1),
(89, 2),
(89, 3),
(90, 1),
(90, 3),
(91, 1),
(91, 2),
(91, 3),
(92, 1),
(92, 2),
(92, 3),
(93, 1),
(93, 2),
(93, 3),
(94, 1),
(94, 3),
(95, 1),
(95, 2),
(95, 3),
(96, 1),
(96, 2),
(96, 3),
(97, 1),
(97, 2),
(98, 1),
(99, 1),
(99, 2),
(100, 1),
(100, 2),
(101, 1),
(101, 2),
(102, 1),
(103, 1),
(103, 2),
(104, 1),
(104, 2),
(105, 1),
(105, 2),
(106, 1),
(107, 1),
(107, 2),
(108, 1),
(108, 2),
(109, 1),
(109, 2),
(109, 3),
(110, 1),
(110, 3),
(111, 1),
(111, 2),
(111, 3),
(112, 1),
(112, 2),
(112, 3),
(113, 1),
(113, 2),
(113, 3),
(114, 1),
(114, 3),
(115, 1),
(115, 2),
(115, 3),
(116, 1),
(116, 2),
(116, 3),
(117, 1),
(117, 2),
(117, 3),
(118, 1),
(118, 3),
(119, 1),
(119, 2),
(119, 3),
(120, 1),
(120, 2),
(120, 3),
(121, 1),
(121, 2),
(121, 3),
(122, 1),
(122, 3),
(123, 1),
(123, 2),
(123, 3),
(124, 1),
(124, 2),
(124, 3),
(125, 1),
(125, 2),
(125, 3),
(126, 1),
(126, 3),
(127, 1),
(127, 2),
(127, 3),
(128, 1),
(128, 2),
(128, 3),
(129, 1),
(129, 2),
(129, 3),
(130, 1),
(130, 3),
(131, 1),
(131, 2),
(131, 3),
(132, 1),
(132, 2),
(132, 3),
(133, 1),
(134, 1),
(135, 1),
(136, 1),
(137, 1),
(138, 1),
(139, 1),
(139, 2),
(139, 3),
(140, 1),
(140, 3),
(141, 1),
(141, 2),
(141, 3),
(142, 1),
(142, 2),
(142, 3),
(143, 1),
(143, 2),
(143, 3),
(144, 1),
(144, 3),
(145, 1),
(145, 2),
(145, 3),
(146, 1),
(146, 2),
(146, 3),
(147, 1),
(147, 2),
(147, 3),
(148, 1),
(148, 3),
(149, 1),
(149, 2),
(149, 3),
(150, 1),
(150, 2),
(150, 3),
(151, 1),
(151, 3),
(152, 1),
(152, 3),
(153, 1),
(153, 3),
(154, 1),
(154, 3),
(155, 1),
(155, 3),
(156, 1),
(156, 3),
(157, 1),
(157, 3),
(158, 1),
(158, 3),
(159, 1),
(159, 3),
(160, 1),
(160, 3),
(161, 1),
(161, 3),
(162, 1),
(162, 3),
(163, 1),
(164, 1),
(165, 1),
(166, 1),
(167, 1),
(168, 1),
(169, 1),
(170, 1),
(171, 1),
(172, 1),
(173, 1),
(174, 1),
(175, 1),
(176, 1),
(177, 1),
(178, 1),
(179, 1),
(180, 1),
(181, 1),
(182, 1),
(183, 1),
(184, 1),
(185, 1),
(186, 1),
(187, 1),
(188, 1),
(189, 1),
(190, 1),
(191, 1),
(192, 1),
(193, 1),
(194, 1),
(195, 1),
(196, 1),
(197, 1),
(198, 1);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `key` varchar(255) NOT NULL,
  `value` text NOT NULL,
  `field_type` varchar(255) NOT NULL DEFAULT 'text',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `key`, `value`, `field_type`, `created_at`, `updated_at`) VALUES
(1, 'default_currency', 'SAR', 'currency', '2025-05-04 08:45:11', '2025-05-04 08:45:11'),
(2, 'default_payment_methode', 'Cash on Delivery', 'payment_method', '2025-05-04 09:44:22', '2025-05-04 09:46:18'),
(3, 'logo_light', 'settings/01JTE0XS8WDHCJY07NB1CZJY3K.jpg', 'image', '2025-05-04 15:13:21', '2025-05-04 16:09:04'),
(4, 'logo_dark', 'settings/01JTE0Z5VEXTVPBXPHKF1H2FQ5.jpg', 'image', '2025-05-04 15:13:46', '2025-05-04 16:09:49');

-- --------------------------------------------------------

--
-- Table structure for table `states`
--

CREATE TABLE `states` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `country_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `taxes`
--

CREATE TABLE `taxes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name_en` varchar(255) NOT NULL,
  `name_ar` varchar(255) NOT NULL,
  `type` enum('percentage','fixed') NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `taxes`
--

INSERT INTO `taxes` (`id`, `name_en`, `name_ar`, `type`, `amount`, `company_id`, `is_active`, `created_at`, `updated_at`, `deleted_at`) VALUES
(4, 'VAT', 'ضريبة القيمة المضافة', 'percentage', 15.00, 3, 1, '2025-05-04 14:01:18', '2025-05-04 14:01:18', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `transaction_id` varchar(255) NOT NULL,
  `date` datetime DEFAULT NULL,
  `transaction_status_id` bigint(20) UNSIGNED DEFAULT NULL,
  `payment_id` bigint(20) UNSIGNED DEFAULT NULL,
  `meta_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`meta_data`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transaction_statuses`
--

CREATE TABLE `transaction_statuses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name_en` varchar(255) NOT NULL,
  `name_ar` varchar(255) NOT NULL,
  `color` varchar(10) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transaction_statuses`
--

INSERT INTO `transaction_statuses` (`id`, `name_en`, `name_ar`, `color`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Pending', 'قيد الانتظار', '#f39c12', '2025-03-23 17:14:16', '2025-03-23 17:14:16', NULL),
(2, 'Completed', 'مكتمل', '#2ecc71', '2025-03-23 17:14:16', '2025-03-23 17:14:16', NULL),
(3, 'Failed', 'فشل', '#e74c3c', '2025-03-23 17:14:16', '2025-03-23 17:14:16', NULL),
(4, 'Refunded', 'مسترجع', '#3498db', '2025-03-23 17:14:16', '2025-03-23 17:14:16', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone_number` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `company_id` bigint(20) UNSIGNED DEFAULT NULL,
  `point_of_sale_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `phone_number`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `company_id`, `point_of_sale_id`) VALUES
(1, 'Super', 'Admin', 'super_admin@alyaa.sa', NULL, NULL, '$2y$10$FivzpG39ml21bz1/mDHzOeEpNXhODy70VgrurOFcsKBcXXF/gpSMG', NULL, '2025-03-23 16:19:52', '2025-03-23 16:19:52', NULL, NULL),
(5, 'Aliyaa', 'Raza', 'aliyaa@gmail.com', NULL, NULL, '$2y$10$/Eba1R3tH2Znenu59MsB5usq7neD9OAZYefkdFbLxyMmuH9y4fi3a', NULL, '2025-05-04 13:57:25', '2025-05-04 13:57:25', 3, 7);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subject` (`subject_type`,`subject_id`),
  ADD KEY `causer` (`causer_type`,`causer_id`),
  ADD KEY `activity_logs_log_name_index` (`log_name`);

--
-- Indexes for table `addresses`
--
ALTER TABLE `addresses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `addresses_address_type_id_foreign` (`address_type_id`),
  ADD KEY `addresses_addressable_type_addressable_id_index` (`addressable_type`,`addressable_id`),
  ADD KEY `addresses_country_id_foreign` (`country_id`);

--
-- Indexes for table `address_types`
--
ALTER TABLE `address_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cities_state_id_foreign` (`state_id`);

--
-- Indexes for table `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `companies_legal_name_unique` (`legal_name`),
  ADD UNIQUE KEY `companies_tax_number_unique` (`tax_number`),
  ADD UNIQUE KEY `companies_email_unique` (`email`),
  ADD UNIQUE KEY `companies_phone_number_unique` (`phone_number`),
  ADD KEY `companies_legal_name_index` (`legal_name`),
  ADD KEY `companies_tax_number_index` (`tax_number`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `currencies`
--
ALTER TABLE `currencies`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `currencies_code_unique` (`code`),
  ADD KEY `currencies_code_index` (`code`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `customers_email_unique` (`email`),
  ADD KEY `customers_company_id_foreign` (`company_id`),
  ADD KEY `customers_point_of_sale_id_foreign` (`point_of_sale_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `invoices_company_id_number_unique` (`company_id`,`number`),
  ADD KEY `invoices_order_id_foreign` (`order_id`),
  ADD KEY `invoices_point_of_sale_id_foreign` (`point_of_sale_id`),
  ADD KEY `invoices_issued_by_user_foreign` (`issued_by_user`),
  ADD KEY `invoices_billing_address_id_foreign` (`billing_address_id`),
  ADD KEY `invoices_shipping_address_id_foreign` (`shipping_address_id`),
  ADD KEY `invoices_currency_id_foreign` (`currency_id`),
  ADD KEY `invoices_number_index` (`number`),
  ADD KEY `invoices_company_id_number_index` (`company_id`,`number`),
  ADD KEY `invoices_customer_id_created_at_index` (`customer_id`,`created_at`),
  ADD KEY `invoices_invoice_status_id_index` (`invoice_status_id`);

--
-- Indexes for table `invoice_items`
--
ALTER TABLE `invoice_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `invoice_items_tax_id_foreign` (`tax_id`),
  ADD KEY `invoice_items_invoice_id_index` (`invoice_id`);

--
-- Indexes for table `invoice_statuses`
--
ALTER TABLE `invoice_statuses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invoice_template_settings`
--
ALTER TABLE `invoice_template_settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `invoice_template_settings_key_name_company_id_unique` (`key_name`,`company_id`),
  ADD KEY `invoice_template_settings_company_id_foreign` (`company_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `notes`
--
ALTER TABLE `notes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notes_notable_type_notable_id_index` (`notable_type`,`notable_id`),
  ADD KEY `notes_created_by_user_id_index` (`created_by_user_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `orders_number_unique` (`number`),
  ADD UNIQUE KEY `orders_company_id_number_unique` (`company_id`,`number`),
  ADD KEY `orders_user_id_foreign` (`user_id`),
  ADD KEY `orders_payment_method_id_foreign` (`payment_method_id`),
  ADD KEY `orders_currency_id_foreign` (`currency_id`),
  ADD KEY `orders_billing_address_id_foreign` (`billing_address_id`),
  ADD KEY `orders_shipping_address_id_foreign` (`shipping_address_id`),
  ADD KEY `orders_number_index` (`number`),
  ADD KEY `orders_company_id_number_index` (`company_id`,`number`),
  ADD KEY `orders_customer_id_created_at_index` (`customer_id`,`created_at`),
  ADD KEY `orders_order_status_id_index` (`order_status_id`),
  ADD KEY `orders_point_of_sale_id_foreign` (`point_of_sale_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_items_tax_id_foreign` (`tax_id`),
  ADD KEY `order_items_order_id_index` (`order_id`),
  ADD KEY `order_items_product_id_index` (`product_id`);

--
-- Indexes for table `order_statuses`
--
ALTER TABLE `order_statuses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payments_payment_method_id_foreign` (`payment_method_id`),
  ADD KEY `payments_currency_id_foreign` (`currency_id`),
  ADD KEY `payments_order_id_index` (`order_id`),
  ADD KEY `payments_invoice_id_index` (`invoice_id`),
  ADD KEY `payments_payment_status_id_index` (`payment_status_id`),
  ADD KEY `payments_transaction_reference_index` (`transaction_reference`);

--
-- Indexes for table `payment_methods`
--
ALTER TABLE `payment_methods`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `payment_methods_code_unique` (`code`),
  ADD KEY `payment_methods_code_index` (`code`);

--
-- Indexes for table `payment_statuses`
--
ALTER TABLE `payment_statuses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `point_of_sales`
--
ALTER TABLE `point_of_sales`
  ADD PRIMARY KEY (`id`),
  ADD KEY `point_of_sales_company_id_is_active_index` (`company_id`,`is_active`);

--
-- Indexes for table `point_of_sale_user`
--
ALTER TABLE `point_of_sale_user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `point_of_sale_user_user_id_point_of_sale_id_unique` (`user_id`,`point_of_sale_id`),
  ADD KEY `point_of_sale_user_point_of_sale_id_foreign` (`point_of_sale_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `products_slug_unique` (`slug`),
  ADD KEY `products_currency_id_foreign` (`currency_id`),
  ADD KEY `products_sku_index` (`sku`),
  ADD KEY `products_code_index` (`code`),
  ADD KEY `products_slug_index` (`slug`),
  ADD KEY `products_point_of_sale_id_is_active_index` (`point_of_sale_id`,`is_active`),
  ADD KEY `products_product_category_id_index` (`product_category_id`),
  ADD KEY `products_company_id_foreign` (`company_id`);

--
-- Indexes for table `product_categories`
--
ALTER TABLE `product_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `product_categories_slug_unique` (`slug`),
  ADD KEY `product_categories_slug_index` (`slug`),
  ADD KEY `product_categories_parent_id_index` (`parent_id`),
  ADD KEY `product_categories_company_id_foreign` (`company_id`),
  ADD KEY `product_categories_point_of_sale_id_foreign` (`point_of_sale_id`);

--
-- Indexes for table `product_tax`
--
ALTER TABLE `product_tax`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `product_tax_product_id_tax_id_unique` (`product_id`,`tax_id`),
  ADD KEY `product_tax_tax_id_foreign` (`tax_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `settings_key_unique` (`key`);

--
-- Indexes for table `states`
--
ALTER TABLE `states`
  ADD PRIMARY KEY (`id`),
  ADD KEY `states_country_id_foreign` (`country_id`);

--
-- Indexes for table `taxes`
--
ALTER TABLE `taxes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `taxes_company_id_is_active_index` (`company_id`,`is_active`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `transactions_transaction_id_unique` (`transaction_id`),
  ADD KEY `transactions_transaction_id_index` (`transaction_id`),
  ADD KEY `transactions_transaction_status_id_index` (`transaction_status_id`),
  ADD KEY `transactions_payment_id_index` (`payment_id`);

--
-- Indexes for table `transaction_statuses`
--
ALTER TABLE `transaction_statuses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_email_index` (`email`),
  ADD KEY `users_phone_number_index` (`phone_number`),
  ADD KEY `users_company_id_email_index` (`company_id`,`email`),
  ADD KEY `users_point_of_sale_id_foreign` (`point_of_sale_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_logs`
--
ALTER TABLE `activity_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=602;

--
-- AUTO_INCREMENT for table `addresses`
--
ALTER TABLE `addresses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT for table `address_types`
--
ALTER TABLE `address_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `companies`
--
ALTER TABLE `companies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `currencies`
--
ALTER TABLE `currencies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `invoice_items`
--
ALTER TABLE `invoice_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=94;

--
-- AUTO_INCREMENT for table `invoice_statuses`
--
ALTER TABLE `invoice_statuses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `invoice_template_settings`
--
ALTER TABLE `invoice_template_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT for table `notes`
--
ALTER TABLE `notes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `order_statuses`
--
ALTER TABLE `order_statuses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payment_methods`
--
ALTER TABLE `payment_methods`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `payment_statuses`
--
ALTER TABLE `payment_statuses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=199;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `point_of_sales`
--
ALTER TABLE `point_of_sales`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `point_of_sale_user`
--
ALTER TABLE `point_of_sale_user`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `product_categories`
--
ALTER TABLE `product_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `product_tax`
--
ALTER TABLE `product_tax`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `states`
--
ALTER TABLE `states`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `taxes`
--
ALTER TABLE `taxes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transaction_statuses`
--
ALTER TABLE `transaction_statuses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `addresses`
--
ALTER TABLE `addresses`
  ADD CONSTRAINT `addresses_address_type_id_foreign` FOREIGN KEY (`address_type_id`) REFERENCES `address_types` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `addresses_country_id_foreign` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `cities`
--
ALTER TABLE `cities`
  ADD CONSTRAINT `cities_state_id_foreign` FOREIGN KEY (`state_id`) REFERENCES `states` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `customers`
--
ALTER TABLE `customers`
  ADD CONSTRAINT `customers_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `customers_point_of_sale_id_foreign` FOREIGN KEY (`point_of_sale_id`) REFERENCES `point_of_sales` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `invoices`
--
ALTER TABLE `invoices`
  ADD CONSTRAINT `invoices_billing_address_id_foreign` FOREIGN KEY (`billing_address_id`) REFERENCES `addresses` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `invoices_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `invoices_currency_id_foreign` FOREIGN KEY (`currency_id`) REFERENCES `currencies` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `invoices_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `invoices_invoice_status_id_foreign` FOREIGN KEY (`invoice_status_id`) REFERENCES `invoice_statuses` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `invoices_issued_by_user_foreign` FOREIGN KEY (`issued_by_user`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `invoices_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `invoices_point_of_sale_id_foreign` FOREIGN KEY (`point_of_sale_id`) REFERENCES `point_of_sales` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `invoices_shipping_address_id_foreign` FOREIGN KEY (`shipping_address_id`) REFERENCES `addresses` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `invoice_items`
--
ALTER TABLE `invoice_items`
  ADD CONSTRAINT `invoice_items_invoice_id_foreign` FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `invoice_items_tax_id_foreign` FOREIGN KEY (`tax_id`) REFERENCES `taxes` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `invoice_template_settings`
--
ALTER TABLE `invoice_template_settings`
  ADD CONSTRAINT `invoice_template_settings_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `notes`
--
ALTER TABLE `notes`
  ADD CONSTRAINT `notes_created_by_user_id_foreign` FOREIGN KEY (`created_by_user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_billing_address_id_foreign` FOREIGN KEY (`billing_address_id`) REFERENCES `addresses` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `orders_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `orders_currency_id_foreign` FOREIGN KEY (`currency_id`) REFERENCES `currencies` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `orders_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `orders_order_status_id_foreign` FOREIGN KEY (`order_status_id`) REFERENCES `order_statuses` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `orders_payment_method_id_foreign` FOREIGN KEY (`payment_method_id`) REFERENCES `payment_methods` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `orders_point_of_sale_id_foreign` FOREIGN KEY (`point_of_sale_id`) REFERENCES `point_of_sales` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `orders_shipping_address_id_foreign` FOREIGN KEY (`shipping_address_id`) REFERENCES `addresses` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `order_items_tax_id_foreign` FOREIGN KEY (`tax_id`) REFERENCES `taxes` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_currency_id_foreign` FOREIGN KEY (`currency_id`) REFERENCES `currencies` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `payments_invoice_id_foreign` FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `payments_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `payments_payment_method_id_foreign` FOREIGN KEY (`payment_method_id`) REFERENCES `payment_methods` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `payments_payment_status_id_foreign` FOREIGN KEY (`payment_status_id`) REFERENCES `payment_statuses` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `point_of_sales`
--
ALTER TABLE `point_of_sales`
  ADD CONSTRAINT `point_of_sales_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `point_of_sale_user`
--
ALTER TABLE `point_of_sale_user`
  ADD CONSTRAINT `point_of_sale_user_point_of_sale_id_foreign` FOREIGN KEY (`point_of_sale_id`) REFERENCES `point_of_sales` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `point_of_sale_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `products_currency_id_foreign` FOREIGN KEY (`currency_id`) REFERENCES `currencies` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `products_point_of_sale_id_foreign` FOREIGN KEY (`point_of_sale_id`) REFERENCES `point_of_sales` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `products_product_category_id_foreign` FOREIGN KEY (`product_category_id`) REFERENCES `product_categories` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `product_categories`
--
ALTER TABLE `product_categories`
  ADD CONSTRAINT `product_categories_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `product_categories_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `product_categories` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `product_categories_point_of_sale_id_foreign` FOREIGN KEY (`point_of_sale_id`) REFERENCES `point_of_sales` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `product_tax`
--
ALTER TABLE `product_tax`
  ADD CONSTRAINT `product_tax_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_tax_tax_id_foreign` FOREIGN KEY (`tax_id`) REFERENCES `taxes` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `states`
--
ALTER TABLE `states`
  ADD CONSTRAINT `states_country_id_foreign` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `taxes`
--
ALTER TABLE `taxes`
  ADD CONSTRAINT `taxes_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_payment_id_foreign` FOREIGN KEY (`payment_id`) REFERENCES `payments` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `transactions_transaction_status_id_foreign` FOREIGN KEY (`transaction_status_id`) REFERENCES `transaction_statuses` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `users_point_of_sale_id_foreign` FOREIGN KEY (`point_of_sale_id`) REFERENCES `point_of_sales` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
