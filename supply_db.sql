-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 19, 2024 at 12:27 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `supply_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `annual_procurement_plans`
--

CREATE TABLE `annual_procurement_plans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `document_id` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `document` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `annual_procurement_plans`
--

INSERT INTO `annual_procurement_plans` (`id`, `document_id`, `user_id`, `title`, `file_name`, `description`, `document`, `created_at`, `updated_at`) VALUES
(2, '00002', 1, 'In iste quis veritat', 'c4611_sample_explain.pdf', '<p>dfsadfasdfasdfsadf</p>', 'media/OVsOq7jFgL1lazBRAaGmt6bqUaAZUEs57gg8l4At.pdf', '2024-09-25 13:18:52', '2024-09-25 13:53:31'),
(3, '00003', 1, 'Consequatur Totam q', 'Sample-pdf.pdf', '<p>sdfsadfsadf</p>', 'media/yh7Tt27yggEEUa399UaKseq6cJSkjsoEF8jtO7dj.pdf', '2024-09-25 13:26:20', '2024-09-25 13:26:20'),
(4, '00004', 1, 'sadfsadf', 'c4611_sample_explain.pdf', '<p>sadfsadfsdf</p>', 'media/SsHsnZGNtkUN39yzNeFzcYVkEypQA26TF12TaWFV.pdf', '2024-09-25 13:47:20', '2024-09-25 13:47:20');

-- --------------------------------------------------------

--
-- Table structure for table `applicants`
--

CREATE TABLE `applicants` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `lastname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `firstname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `middlename` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `province` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `barangay` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `position` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `applicants`
--

INSERT INTO `applicants` (`id`, `user_id`, `lastname`, `firstname`, `middlename`, `province`, `city`, `barangay`, `email`, `contact_number`, `username`, `position`, `created_at`, `updated_at`) VALUES
(25, 26, 'Mcdaniel', 'Gisela', 'ere', NULL, NULL, NULL, 'hulej@mailinator.com', '093645123987', 'myqiqijyfi', 'Backend Developer', '2024-09-25 12:05:08', '2024-09-25 12:05:08'),
(26, 27, 'Galena', 'Xyla', 'Melinda', NULL, NULL, NULL, 'moqenihi@mailinator.com', '66', 'bubuvajin', 'Aute fugiat adipisi', '2024-09-25 16:08:09', '2024-09-25 16:08:09'),
(27, 28, 'Kirk', 'Jasper', 'Logan', NULL, NULL, NULL, 'dumurumyju@mailinator.com', '139', 'vycyvof', 'Deserunt non ullamco', '2024-09-25 16:49:51', '2024-09-25 16:49:51');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `status`, `number`, `created_at`, `updated_at`) VALUES
(1, 'sdfasdf', 'Active', '', '2024-09-26 09:31:03', '2024-09-26 11:53:49'),
(2, 'Office Supplies', 'Active', '', '2024-09-26 10:05:02', '2024-09-26 10:05:02'),
(3, 'Cleaning Supplies', 'Active', '', '2024-09-26 10:05:33', '2024-09-26 10:05:33'),
(4, 'Medical Supplies', 'Active', '', '2024-09-26 10:05:59', '2024-09-26 10:05:59'),
(5, 'Maintenance Supplies', 'Active', '', '2024-09-26 10:06:12', '2024-09-26 10:06:12'),
(6, 'Food and Beverage Supplies', 'Active', '', '2024-09-26 10:06:27', '2024-09-26 10:06:27'),
(7, 'Technology Supplies', 'Active', '', '2024-09-26 10:06:45', '2024-09-26 10:06:45'),
(8, 'Packaging Supplies', 'Active', '', '2024-09-26 10:07:00', '2024-09-26 10:07:00');

-- --------------------------------------------------------

--
-- Table structure for table `clien_pars`
--

CREATE TABLE `clien_pars` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `par_id` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `client_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `clien_pars`
--

INSERT INTO `clien_pars` (`id`, `par_id`, `user_id`, `client_id`, `created_at`, `updated_at`) VALUES
(1, '00001', 1, '27', '2024-10-18 12:38:28', '2024-10-18 12:38:28'),
(2, '00002', 1, '26', '2024-10-18 12:38:39', '2024-10-18 12:38:39');

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `department_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `department_type` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `department_name`, `department_type`, `logo`, `name`, `created_at`, `updated_at`) VALUES
(41, 'Account Management', 'Office', 'media/YdBJmh9R5m4SS1hOImtvfKhFHnEUGbVMgz17h8zE.jpg', 'Account_Management', '2024-09-25 12:02:54', '2024-10-18 13:50:52'),
(42, 'School of Technology and Computer Studies', 'Office', 'media/kJUKR93xXGGeI1BY1rt87QqKA9ic2h21s3srUJyk.png', 'School_of_Technology_and_Computer_Studies', '2024-09-25 12:03:27', '2024-10-18 13:51:29'),
(43, 'School Criminal Justice', 'School', 'media/6tr4OYMBehDXYc5OEs3f1bSbwpaycPS8EcwWwtVW.png', 'Account_Managements', '2024-09-25 16:32:39', '2024-10-18 13:51:15');

-- --------------------------------------------------------

--
-- Table structure for table `documents`
--

CREATE TABLE `documents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `department_id` int(255) DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `document` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `deadline` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'for review',
  `file_name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_complied` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `documents`
--

INSERT INTO `documents` (`id`, `user_id`, `department_id`, `title`, `description`, `document`, `deadline`, `message`, `status`, `file_name`, `date_complied`, `created_at`, `updated_at`) VALUES
(12, 26, 41, 'Sample PPMP', '<p>sdfsadfasdfsdf</p>', 'media/8yxqG1jiMFlPQuyYsprVpyBbDy1WFWgSTbVo816W.pdf', NULL, NULL, 'consolidated', NULL, '2024-09-26 00:53:48', '2024-09-25 16:43:41', '2024-09-25 16:53:48'),
(13, 27, 42, 'Sample PPM', '<p>21232323</p>', 'media/93HYk7Vgj1zz3ixJAQkAljLZ8nXA6acS5Di1powM.pdf', NULL, NULL, 'consolidated', NULL, '2024-09-26 00:53:13', '2024-09-25 16:52:08', '2024-09-25 16:53:13'),
(14, 26, 41, 'RIS Sample', '<p>sadfsdf</p>', 'media/q8nmI8ariulhAPo6CzyEAknbOnvSk6ANN824gpSi.pdf', NULL, NULL, 'consolidated', 'c4611_sample_explain.pdf', '2024-09-26 20:18:26', '2024-09-26 12:07:18', '2024-09-26 12:18:26'),
(15, 26, 41, 'sdfsdf', '<p>sdafsdf</p>', 'media/PsaMPVY9XkPyTW5Rfmcr00rm9NBX7fDB0xK0oG3R.pdf', NULL, 'Incomplete of requierments', 'return', 'c4611_sample_explain.pdf', NULL, '2024-09-26 16:33:15', '2024-09-26 16:34:44');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `media`
--

CREATE TABLE `media` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `applicant_id` bigint(20) UNSIGNED NOT NULL,
  `profile_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sanitary_permit` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `barangay_clearance` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `media`
--

INSERT INTO `media` (`id`, `applicant_id`, `profile_image`, `sanitary_permit`, `barangay_clearance`, `created_at`, `updated_at`) VALUES
(23, 25, 'media/T0F6e1HbjQTDME8YtWLnttYgN6MFhMdEWqKmzRFF.jpg', '', '', '2024-09-25 12:05:08', '2024-09-26 15:35:02'),
(24, 26, 'media/vyjC5lFoAAKqELENs4pzXFeFJFoFvGfO1GprKJQx.jpg', '', '', '2024-09-25 16:08:09', '2024-09-25 16:08:09'),
(25, 27, 'media/8Hj05UmacNqdVuB6AttX4iC2XQr8gasYCumI2Rwk.jpg', '', '', '2024-09-25 16:49:51', '2024-09-25 16:49:51');

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
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2024_06_26_153053_create_applicants_table', 1),
(6, '2024_06_26_153104_create_media_table', 1),
(7, '2024_06_28_235508_create_departments_table', 1),
(8, '2024_07_13_151623_create_documents_table', 2),
(9, '2024_07_21_145626_create_transaction_logs_table', 3),
(10, '2024_07_23_144301_create_purchase_documents_table', 4),
(11, '0000_00_00_000000_create_websockets_statistics_entries_table', 5),
(12, '2024_09_22_015954_create_return_statuses_table', 6),
(13, '2024_09_25_205600_create_annual_procurement_plans_table', 7),
(14, '2024_09_26_031251_create_categories_table', 8),
(15, '2024_09_26_173329_create_supplies_table', 9),
(16, '2024_10_17_175524_create_signatures_table', 10),
(17, '2024_10_17_215909_create_suppliers_table', 10),
(18, '2024_10_17_232438_create_receivings_table', 10),
(19, '2024_10_18_043810_create_received_supplies_table', 10),
(20, '2024_10_18_065042_create_requisition_slops_table', 10),
(21, '2024_10_18_071843_create_ris_supplies_table', 10),
(22, '2024_10_18_201846_create_clien_pars_table', 11),
(23, '2024_10_18_204428_create_par_supplies_table', 12);

-- --------------------------------------------------------

--
-- Table structure for table `par_supplies`
--

CREATE TABLE `par_supplies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `supply_id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `par_id` int(255) DEFAULT NULL,
  `price` double(8,2) DEFAULT NULL,
  `total_price` double(8,2) DEFAULT NULL,
  `qnty` double(8,2) DEFAULT NULL,
  `supply_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `client_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `client_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `par_supplies`
--

INSERT INTO `par_supplies` (`id`, `user_id`, `supply_id`, `category_id`, `par_id`, `price`, `total_price`, `qnty`, `supply_name`, `client_id`, `client_name`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 7, 1, NULL, 0.00, 2.00, 'Laptop', '27', 'Xyla Galena', 'unserviceable', '2024-10-18 13:07:52', '2024-10-18 13:43:44'),
(2, 1, 4, 2, 1, NULL, 500.00, 1.00, 'A4 Printing Paper', '27', 'Xyla Galena', 'return', '2024-10-18 13:16:30', '2024-10-18 13:44:33'),
(3, 1, 3, 2, 1, NULL, 800.00, 1.00, 'Ballpoint Pen', '27', 'Xyla Galena', 'issued', '2024-10-18 13:18:10', '2024-10-18 13:18:10'),
(4, 1, 2, 7, 2, NULL, 0.00, 1.00, 'Laptop', '26', 'Gisela Mcdaniel', 'issued', '2024-10-18 13:46:44', '2024-10-18 13:46:44');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(4, 'App\\Models\\User', 1, 'main', 'fda07e1df9de49774618831d5854321d158facd7a99cf81be691cca312aefd0d', '[\"*\"]', '2024-07-01 02:43:47', NULL, '2024-06-30 19:45:36', '2024-07-01 02:43:47'),
(6, 'App\\Models\\User', 1, 'main', 'cae5c940014a058169445f97ed0c1fb3d64476b73d1b6cea008d02d5e8e7ccb9', '[\"*\"]', '2024-07-13 05:48:07', NULL, '2024-07-09 23:18:03', '2024-07-13 05:48:07'),
(10, 'App\\Models\\User', 17, 'main', '3b6c7711e030ddb6147e0e44b58bd1417f4e702ab65b2693aec18382588fc169', '[\"*\"]', '2024-07-22 04:26:39', NULL, '2024-07-20 17:25:02', '2024-07-22 04:26:39'),
(12, 'App\\Models\\User', 1, 'main', '3d459c87772157e44e6c705e8816bcd4720c50c3e31f043b28cb9fff3a271b74', '[\"*\"]', '2024-07-23 14:17:33', NULL, '2024-07-22 09:27:58', '2024-07-23 14:17:33'),
(14, 'App\\Models\\User', 20, 'main', '74ae292f312e2527abc4bd1ab1957f9b545375d8ea0eddbc01b03a2233284e65', '[\"*\"]', '2024-07-23 14:17:39', NULL, '2024-07-22 14:36:18', '2024-07-23 14:17:39'),
(15, 'App\\Models\\User', 20, 'main', '4339e07273f6f9cdadecfeb417d248461f6a5ba7791d068edf3db2c98272e3b6', '[\"*\"]', '2024-07-24 18:59:36', NULL, '2024-07-23 17:31:11', '2024-07-24 18:59:36'),
(16, 'App\\Models\\User', 1, 'main', '1656ba99fc0d5073709b463aec1072286b47d8e08da01ed400a10ff4b68a6988', '[\"*\"]', '2024-07-29 13:16:12', NULL, '2024-07-27 22:59:04', '2024-07-29 13:16:12'),
(17, 'App\\Models\\User', 1, 'main', 'bc477123acd7507b4f2a4669f272e6d2eb012f6f1407c5f167e74a4323cb9e80', '[\"*\"]', '2024-07-28 06:05:47', NULL, '2024-07-28 06:01:32', '2024-07-28 06:05:47'),
(18, 'App\\Models\\User', 1, 'main', 'e8ab5b6c63b29c8decdc75118d1cdcfa16935ba8d8b3165d4f4baf44972a33c0', '[\"*\"]', '2024-09-25 02:48:24', NULL, '2024-09-21 16:37:53', '2024-09-25 02:48:24'),
(19, 'App\\Models\\User', 22, 'main', 'fbfc22775df78962774319d0166ff081e532dbb6e47fecc33b5537a7b1f53f15', '[\"*\"]', '2024-09-21 17:41:04', NULL, '2024-09-21 16:42:08', '2024-09-21 17:41:04'),
(20, 'App\\Models\\User', 24, 'main', 'bf683202fd77bb97070fc1b9038134b70f51b48700df8e00865b469948b656ea', '[\"*\"]', '2024-09-25 02:48:26', NULL, '2024-09-21 16:44:54', '2024-09-25 02:48:26'),
(23, 'App\\Models\\User', 27, 'main', 'ae556a523a88e7702eb776e37cf9b6c28bdedd4301298994515eb975ad1ec153', '[\"*\"]', '2024-09-25 16:54:28', NULL, '2024-09-25 16:51:52', '2024-09-25 16:54:28'),
(24, 'App\\Models\\User', 1, 'main', '9e39dde6bf63f0b3911f5009a65eee435bce9a22666ee03f9766c5645a866aef', '[\"*\"]', '2024-09-26 04:46:21', NULL, '2024-09-26 03:18:23', '2024-09-26 04:46:21'),
(26, 'App\\Models\\User', 1, 'main', '0d3f8ec3292a409bfe0a48674d7071cba4336973218cdd500f279495e934be0c', '[\"*\"]', '2024-09-26 16:41:36', NULL, '2024-09-26 11:49:11', '2024-09-26 16:41:36'),
(28, 'App\\Models\\User', 26, 'main', '0a6879c89c2b9a2fd3d023a76b7d181176bb222c96e6a3c40e543d832dbc6dc4', '[\"*\"]', '2024-09-26 16:41:36', NULL, '2024-09-26 15:35:25', '2024-09-26 16:41:36'),
(29, 'App\\Models\\User', 1, 'main', '0057e681fc53854d95838c24d2cc083d81ddddddf0a33df57be7b0f90a436db1', '[\"*\"]', '2024-10-18 14:14:29', NULL, '2024-10-18 05:05:06', '2024-10-18 14:14:29'),
(30, 'App\\Models\\User', 27, 'main', '1f5ea9953f36f3027bf4842382311035d5b4767695b983c50e66f0e18d106e2d', '[\"*\"]', '2024-10-18 14:26:03', NULL, '2024-10-18 05:11:30', '2024-10-18 14:26:03');

-- --------------------------------------------------------

--
-- Table structure for table `purchase_documents`
--

CREATE TABLE `purchase_documents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'pending',
  `pr_status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `po_status` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT 'for review',
  `pr_request_date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `purchase_request` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `purchase_order` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order_description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `request_description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `return_status` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `po_request_date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `received_supplies`
--

CREATE TABLE `received_supplies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `supply_id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `price` double(8,2) NOT NULL,
  `total_price` double(8,2) NOT NULL,
  `qnty` double(8,2) NOT NULL,
  `supply_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `receive_id` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `received_supplies`
--

INSERT INTO `received_supplies` (`id`, `user_id`, `supply_id`, `category_id`, `price`, `total_price`, `qnty`, `supply_name`, `receive_id`, `created_at`, `updated_at`) VALUES
(1, 1, 3, 2, 800.00, 4800.00, 6.00, 'Ballpoint Pen', '1', '2024-10-18 05:09:51', '2024-10-18 05:09:51');

-- --------------------------------------------------------

--
-- Table structure for table `receivings`
--

CREATE TABLE `receivings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `doc_id` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_arrived` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `supplier` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `receivings`
--

INSERT INTO `receivings` (`id`, `user_id`, `doc_id`, `date_arrived`, `supplier`, `created_at`, `updated_at`) VALUES
(1, 1, '00001', '2024-10-19', 'Raphael Craft', '2024-10-18 05:07:19', '2024-10-18 05:07:19');

-- --------------------------------------------------------

--
-- Table structure for table `requisition_slops`
--

CREATE TABLE `requisition_slops` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `ris_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `submit` int(50) NOT NULL DEFAULT 0,
  `approved_by` int(255) DEFAULT NULL,
  `approved_date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `requisition_slops`
--

INSERT INTO `requisition_slops` (`id`, `user_id`, `ris_number`, `status`, `submit`, `approved_by`, `approved_date`, `created_at`, `updated_at`) VALUES
(1, 27, '00001', 'issued', 1, 1, '2024-10-18 19:21:33', '2024-10-18 05:11:38', '2024-10-18 11:21:33'),
(2, 27, '00002', 'issued', 1, 1, '2024-10-18 19:09:05', '2024-10-18 10:32:32', '2024-10-18 11:09:05'),
(3, 27, '00003', 'issued', 1, 1, '2024-10-18 19:30:59', '2024-10-18 11:28:32', '2024-10-18 11:30:59'),
(4, 27, '00004', 'issued', 1, 1, '2024-10-18 21:47:28', '2024-10-18 11:32:54', '2024-10-18 13:47:28'),
(5, 27, '00005', 'issued', 1, 1, '2024-10-18 20:06:57', '2024-10-18 11:49:49', '2024-10-18 12:06:57'),
(6, 27, '00006', 'issued', 1, 1, '2024-10-18 20:00:58', '2024-10-18 11:57:01', '2024-10-18 12:00:58');

-- --------------------------------------------------------

--
-- Table structure for table `return_statuses`
--

CREATE TABLE `return_statuses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `return_status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `return_statuses`
--

INSERT INTO `return_statuses` (`id`, `return_status`, `status`, `name`, `created_at`, `updated_at`) VALUES
(10, 'Incomplete of requierments', 'Active', 'Active_10', '2024-09-24 23:02:41', '2024-09-24 23:02:41'),
(11, 'Exceed of Budget', 'Active', 'Active_11', '2024-09-25 00:24:10', '2024-09-25 00:24:10');

-- --------------------------------------------------------

--
-- Table structure for table `ris_supplies`
--

CREATE TABLE `ris_supplies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `supply_id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `price` double(8,2) NOT NULL,
  `total_price` double(8,2) NOT NULL,
  `qnty` int(50) NOT NULL,
  `supply_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `submit` int(50) NOT NULL DEFAULT 0,
  `availbale` int(50) NOT NULL DEFAULT 0,
  `issued_qnty` int(255) DEFAULT NULL,
  `issued_total_price` double(10,2) DEFAULT NULL,
  `ris_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ris_supplies`
--

INSERT INTO `ris_supplies` (`id`, `user_id`, `supply_id`, `category_id`, `price`, `total_price`, `qnty`, `supply_name`, `submit`, `availbale`, `issued_qnty`, `issued_total_price`, `ris_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 27, 3, 2, 800.00, 4000.00, 5, 'Ballpoint Pen', 0, 1, 5, 4000.00, '1', 'issued', '2024-10-18 05:14:24', '2024-10-18 10:29:54'),
(2, 27, 2, 7, 0.00, 0.00, 0, 'Laptop', 0, 2, 0, 0.00, '2', 'not available', '2024-10-18 10:36:31', '2024-10-18 10:40:42'),
(3, 27, 4, 2, 0.00, 0.00, 0, 'A4 Printing Paper', 0, 2, 0, 0.00, '2', 'not available', '2024-10-18 10:36:42', '2024-10-18 10:40:58'),
(4, 27, 3, 2, 800.00, 6400.00, 1, 'Ballpoint Pen', 0, 1, 1, 800.00, '2', 'issued', '2024-10-18 10:36:51', '2024-10-18 10:41:06'),
(5, 27, 2, 7, 0.00, 0.00, 0, 'Laptop', 0, 2, 0, 0.00, '3', 'not available', '2024-10-18 11:28:43', '2024-10-18 11:30:26'),
(6, 27, 4, 2, 0.00, 0.00, 0, 'A4 Printing Paper', 0, 2, 0, 0.00, '3', 'not available', '2024-10-18 11:28:52', '2024-10-18 11:30:32'),
(7, 27, 3, 2, 800.00, 8000.00, 10, 'Ballpoint Pen', 0, 1, 10, 8000.00, '3', 'issued', '2024-10-18 11:28:59', '2024-10-18 11:30:47'),
(8, 27, 2, 7, 0.00, 0.00, 0, 'Laptop', 0, 2, 0, 0.00, '4', 'not available', '2024-10-18 11:33:09', '2024-10-18 11:48:59'),
(9, 27, 2, 7, 0.00, 0.00, 2, 'Laptop', 0, 2, 0, 0.00, '5', 'not available', '2024-10-18 11:50:01', '2024-10-18 12:02:00'),
(10, 27, 3, 2, 800.00, 1600.00, 0, 'Ballpoint Pen', 0, 2, 0, 0.00, '5', 'not available', '2024-10-18 11:50:21', '2024-10-18 12:04:20'),
(11, 27, 1, 5, 0.00, 0.00, 0, 'sdfsdf', 0, 2, 0, 0.00, '5', 'not available', '2024-10-18 11:50:27', '2024-10-18 12:02:10'),
(12, 27, 5, 2, 0.00, 0.00, 2, 'Post-it Notes', 0, 2, 0, 0.00, '5', 'not available', '2024-10-18 11:50:32', '2024-10-18 12:06:47'),
(13, 27, 4, 2, 500.00, 1000.00, 0, 'A4 Printing Paper', 0, 2, 0, 0.00, '5', 'not available', '2024-10-18 11:50:39', '2024-10-18 12:06:20'),
(14, 27, 3, 2, 800.00, 800.00, 1, 'Ballpoint Pen', 0, 1, 1, 800.00, '6', 'issued', '2024-10-18 11:59:50', '2024-10-18 12:00:52');

-- --------------------------------------------------------

--
-- Table structure for table `signatures`
--

CREATE TABLE `signatures` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `supplier_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`id`, `user_id`, `supplier_name`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'Raphael Craft', 'Active', '2024-10-18 05:05:34', '2024-10-18 05:05:34');

-- --------------------------------------------------------

--
-- Table structure for table `supplies`
--

CREATE TABLE `supplies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `supply_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `unit` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `qnty` int(11) NOT NULL DEFAULT 0,
  `price` double DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `supplies`
--

INSERT INTO `supplies` (`id`, `user_id`, `supply_name`, `category_id`, `description`, `unit`, `image_url`, `qnty`, `price`, `created_at`, `updated_at`) VALUES
(1, '', 'sdfsdf', '5', 'sdfsdf', 'pack', 'media/2sH7aKJI9bhpzxIZNwp9744v365WB11zbqmB57lI.jpg', 0, NULL, '2024-09-26 10:13:15', '2024-09-26 10:13:15'),
(2, '', 'Laptop', '7', 'Lenovo', 'piece', 'media/t3NvAH3GfwkAXq9Fquglk8e8oVZybJhwYPeBTw3f.jpg', -3, NULL, '2024-09-26 10:33:34', '2024-10-18 13:46:44'),
(3, '', 'Ballpoint Pen', '2', 'Blue ink, medium tip ballpoint pen.', 'box', 'media/lAJ44yZBPBvj3QeuXdm6zaurRMKB8DIxEd8juqyY.png', 3, 800, '2024-09-26 10:34:35', '2024-10-18 13:18:10'),
(4, '', 'A4 Printing Paper', '2', '500 sheets per ream, 80 GSM, white.', 'box', 'media/3jaXAlUZXmMksA5qjilaIu8Q76xJG3AUs8WWamC6.jpg', 9, 500, '2024-09-26 10:35:09', '2024-10-18 13:16:30'),
(5, '', 'Post-it Notes', '2', '3x3 inch sticky notes, 100 sheets per pad, yellow.', 'piece', 'media/5TzoaODWbfafMSrAiA2AvBSX7UC3kp4S9uRTHZ3f.jpg', 0, NULL, '2024-09-26 10:36:25', '2024-09-26 10:36:25');

-- --------------------------------------------------------

--
-- Table structure for table `transaction_logs`
--

CREATE TABLE `transaction_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `document_id` bigint(20) UNSIGNED DEFAULT NULL,
  `deadline` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_submitted` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transaction_logs`
--

INSERT INTO `transaction_logs` (`id`, `document_id`, `deadline`, `date_submitted`, `status`, `created_at`, `updated_at`) VALUES
(17, 13, NULL, '2024-09-26 00:52:08', 'consolidated', '2024-09-25 16:53:13', '2024-09-25 16:53:13'),
(18, 12, NULL, '2024-09-26 00:43:41', 'consolidated', '2024-09-25 16:53:48', '2024-09-25 16:53:48'),
(19, 14, NULL, '2024-09-26 20:07:18', 'consolidated', '2024-09-26 12:18:26', '2024-09-26 12:18:26'),
(20, 15, NULL, '2024-09-27 00:33:15', 'return', '2024-09-26 16:34:44', '2024-09-26 16:34:44');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `department_id` int(255) DEFAULT NULL,
  `lastname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `firstname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `middle_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `position` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact_number` varchar(12) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `department_id`, `lastname`, `firstname`, `middle_name`, `position`, `role`, `email`, `contact_number`, `username`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, NULL, 'General', 'Admin', NULL, 'supply office officer', 'general admin', 'admin@gmail.com', NULL, '', NULL, '$2y$10$jT8C2A3nQBXYN4y6/lBg5.dI39BXRNekX6u5wfwCJi9bGmEdzas1e', NULL, NULL, NULL),
(26, 41, 'Mcdaniel', 'Gisela', 'sdfsadfsadf', 'Backend Developer', 'admin', 'hulej@mailinator.com', '1232323', 'myqiqijyfi', NULL, '$2y$12$q5RGk7d.BXZ0.7EeZrP2texrqZjKY0XzWkqWB21HoCJwhQkxGEGGS', NULL, '2024-09-25 12:05:08', '2024-09-26 15:35:23'),
(27, 42, 'Galena', 'Xyla', 'mamamam', 'Aute fugiat adipisi', 'admin', 'moqenihi@mailinator.com', '66', 'bubuvajin', NULL, '$2y$12$Bbnac9kN2r1aE1ClwBlK..Xad/ANs8jeVr1ep6vgtJKJnTPgYX4zK', NULL, '2024-09-25 16:08:09', '2024-09-25 16:51:44'),
(28, NULL, 'Kirk', 'Jasper', NULL, 'Deserunt non ullamco', 'supply office', 'dumurumyju@mailinator.com', '139', 'vycyvof', NULL, '$2y$12$QYjVyFj9Hg6Xnn7ewHdKze07bjdWQRm7r/lNZ39prvaoInMEGGVGy', NULL, '2024-09-25 16:49:51', '2024-09-26 12:34:23');

-- --------------------------------------------------------

--
-- Table structure for table `websockets_statistics_entries`
--

CREATE TABLE `websockets_statistics_entries` (
  `id` int(10) UNSIGNED NOT NULL,
  `app_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `peak_connection_count` int(11) NOT NULL,
  `websocket_message_count` int(11) NOT NULL,
  `api_message_count` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `annual_procurement_plans`
--
ALTER TABLE `annual_procurement_plans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `annual_procurement_plans_user_id_foreign` (`user_id`);

--
-- Indexes for table `applicants`
--
ALTER TABLE `applicants`
  ADD PRIMARY KEY (`id`),
  ADD KEY `applicants_user_id_foreign` (`user_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `clien_pars`
--
ALTER TABLE `clien_pars`
  ADD PRIMARY KEY (`id`),
  ADD KEY `clien_pars_user_id_foreign` (`user_id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `documents_user_id_foreign` (`user_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `media`
--
ALTER TABLE `media`
  ADD PRIMARY KEY (`id`),
  ADD KEY `media_applicant_id_foreign` (`applicant_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `par_supplies`
--
ALTER TABLE `par_supplies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `par_supplies_user_id_foreign` (`user_id`),
  ADD KEY `par_supplies_supply_id_foreign` (`supply_id`),
  ADD KEY `par_supplies_category_id_foreign` (`category_id`);

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
-- Indexes for table `purchase_documents`
--
ALTER TABLE `purchase_documents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `purchase_documents_user_id_foreign` (`user_id`);

--
-- Indexes for table `received_supplies`
--
ALTER TABLE `received_supplies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `received_supplies_user_id_foreign` (`user_id`),
  ADD KEY `received_supplies_supply_id_foreign` (`supply_id`),
  ADD KEY `received_supplies_category_id_foreign` (`category_id`);

--
-- Indexes for table `receivings`
--
ALTER TABLE `receivings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `receivings_user_id_foreign` (`user_id`);

--
-- Indexes for table `requisition_slops`
--
ALTER TABLE `requisition_slops`
  ADD PRIMARY KEY (`id`),
  ADD KEY `requisition_slops_user_id_foreign` (`user_id`);

--
-- Indexes for table `return_statuses`
--
ALTER TABLE `return_statuses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ris_supplies`
--
ALTER TABLE `ris_supplies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ris_supplies_user_id_foreign` (`user_id`),
  ADD KEY `ris_supplies_supply_id_foreign` (`supply_id`),
  ADD KEY `ris_supplies_category_id_foreign` (`category_id`);

--
-- Indexes for table `signatures`
--
ALTER TABLE `signatures`
  ADD PRIMARY KEY (`id`),
  ADD KEY `signatures_user_id_foreign` (`user_id`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `suppliers_user_id_foreign` (`user_id`);

--
-- Indexes for table `supplies`
--
ALTER TABLE `supplies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaction_logs`
--
ALTER TABLE `transaction_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transaction_logs_document_id_foreign` (`document_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_username_unique` (`username`);

--
-- Indexes for table `websockets_statistics_entries`
--
ALTER TABLE `websockets_statistics_entries`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `annual_procurement_plans`
--
ALTER TABLE `annual_procurement_plans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `applicants`
--
ALTER TABLE `applicants`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `clien_pars`
--
ALTER TABLE `clien_pars`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `documents`
--
ALTER TABLE `documents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `media`
--
ALTER TABLE `media`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `par_supplies`
--
ALTER TABLE `par_supplies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `purchase_documents`
--
ALTER TABLE `purchase_documents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `received_supplies`
--
ALTER TABLE `received_supplies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `receivings`
--
ALTER TABLE `receivings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `requisition_slops`
--
ALTER TABLE `requisition_slops`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `return_statuses`
--
ALTER TABLE `return_statuses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `ris_supplies`
--
ALTER TABLE `ris_supplies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `signatures`
--
ALTER TABLE `signatures`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `supplies`
--
ALTER TABLE `supplies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `transaction_logs`
--
ALTER TABLE `transaction_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `websockets_statistics_entries`
--
ALTER TABLE `websockets_statistics_entries`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `annual_procurement_plans`
--
ALTER TABLE `annual_procurement_plans`
  ADD CONSTRAINT `annual_procurement_plans_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `applicants`
--
ALTER TABLE `applicants`
  ADD CONSTRAINT `applicants_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `clien_pars`
--
ALTER TABLE `clien_pars`
  ADD CONSTRAINT `clien_pars_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `documents`
--
ALTER TABLE `documents`
  ADD CONSTRAINT `documents_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `media`
--
ALTER TABLE `media`
  ADD CONSTRAINT `media_applicant_id_foreign` FOREIGN KEY (`applicant_id`) REFERENCES `applicants` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `par_supplies`
--
ALTER TABLE `par_supplies`
  ADD CONSTRAINT `par_supplies_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `par_supplies_supply_id_foreign` FOREIGN KEY (`supply_id`) REFERENCES `supplies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `par_supplies_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `purchase_documents`
--
ALTER TABLE `purchase_documents`
  ADD CONSTRAINT `purchase_documents_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `received_supplies`
--
ALTER TABLE `received_supplies`
  ADD CONSTRAINT `received_supplies_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `received_supplies_supply_id_foreign` FOREIGN KEY (`supply_id`) REFERENCES `supplies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `received_supplies_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `receivings`
--
ALTER TABLE `receivings`
  ADD CONSTRAINT `receivings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `requisition_slops`
--
ALTER TABLE `requisition_slops`
  ADD CONSTRAINT `requisition_slops_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `ris_supplies`
--
ALTER TABLE `ris_supplies`
  ADD CONSTRAINT `ris_supplies_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ris_supplies_supply_id_foreign` FOREIGN KEY (`supply_id`) REFERENCES `supplies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ris_supplies_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `signatures`
--
ALTER TABLE `signatures`
  ADD CONSTRAINT `signatures_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD CONSTRAINT `suppliers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `transaction_logs`
--
ALTER TABLE `transaction_logs`
  ADD CONSTRAINT `transaction_logs_document_id_foreign` FOREIGN KEY (`document_id`) REFERENCES `documents` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
