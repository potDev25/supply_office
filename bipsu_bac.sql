-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 26, 2024 at 02:58 AM
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
-- Database: `bipsu_bac`
--

-- --------------------------------------------------------

--
-- Table structure for table `annual_procurement_plans`
--

CREATE TABLE `annual_procurement_plans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `document_id` varchar(50) DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `file_name` varchar(50) DEFAULT NULL,
  `description` text NOT NULL,
  `document` text NOT NULL,
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
  `lastname` varchar(255) DEFAULT NULL,
  `firstname` varchar(255) DEFAULT NULL,
  `middlename` varchar(255) DEFAULT NULL,
  `province` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `barangay` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `contact_number` varchar(255) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `position` varchar(255) DEFAULT NULL,
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
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `department_name` varchar(255) NOT NULL,
  `department_type` varchar(50) NOT NULL,
  `logo` varchar(255) NOT NULL,
  `name` varchar(50) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `department_name`, `department_type`, `logo`, `name`, `created_at`, `updated_at`) VALUES
(41, 'Account Management', 'Office', 'media/7HJtEQUjErNeu4iVEoGv8w3Jbp2yZlumbdT3ciqD.jpg', 'Account_Management', '2024-09-25 12:02:54', '2024-09-25 12:02:54'),
(42, 'School of Technology and Computer Studies', 'Office', 'media/iasXhfS27WaNjLF2fQLNgrV3ajtzWmj4aUx0Thzr.jpg', 'School_of_Technology_and_Computer_Studies', '2024-09-25 12:03:27', '2024-09-25 12:03:27'),
(43, 'School Criminal Justice', 'School', 'media/PdqCR74vOGrRuOFkiu3Vbca70NfjjVCosSIGo1kl.jpg', 'Account_Managements', '2024-09-25 16:32:39', '2024-09-25 16:33:22');

-- --------------------------------------------------------

--
-- Table structure for table `documents`
--

CREATE TABLE `documents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `department_id` int(255) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `document` text NOT NULL,
  `deadline` varchar(255) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'for review',
  `date_complied` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `documents`
--

INSERT INTO `documents` (`id`, `user_id`, `department_id`, `title`, `description`, `document`, `deadline`, `message`, `status`, `date_complied`, `created_at`, `updated_at`) VALUES
(12, 26, 41, 'Sample PPMP', '<p>sdfsadfasdfsdf</p>', 'media/8yxqG1jiMFlPQuyYsprVpyBbDy1WFWgSTbVo816W.pdf', NULL, NULL, 'consolidated', '2024-09-26 00:53:48', '2024-09-25 16:43:41', '2024-09-25 16:53:48'),
(13, 27, 42, 'Sample PPM', '<p>21232323</p>', 'media/93HYk7Vgj1zz3ixJAQkAljLZ8nXA6acS5Di1powM.pdf', NULL, NULL, 'consolidated', '2024-09-26 00:53:13', '2024-09-25 16:52:08', '2024-09-25 16:53:13');

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
-- Table structure for table `media`
--

CREATE TABLE `media` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `applicant_id` bigint(20) UNSIGNED NOT NULL,
  `profile_image` varchar(255) DEFAULT NULL,
  `sanitary_permit` varchar(255) NOT NULL,
  `barangay_clearance` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `media`
--

INSERT INTO `media` (`id`, `applicant_id`, `profile_image`, `sanitary_permit`, `barangay_clearance`, `created_at`, `updated_at`) VALUES
(23, 25, 'media/QJCzYYNs25hqV3qaRyq9r5qxHHRjRlVuRtzVcJxL.jpg', '', '', '2024-09-25 12:05:08', '2024-09-25 15:52:07'),
(24, 26, 'media/vyjC5lFoAAKqELENs4pzXFeFJFoFvGfO1GprKJQx.jpg', '', '', '2024-09-25 16:08:09', '2024-09-25 16:08:09'),
(25, 27, 'media/8Hj05UmacNqdVuB6AttX4iC2XQr8gasYCumI2Rwk.jpg', '', '', '2024-09-25 16:49:51', '2024-09-25 16:49:51');

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
(13, '2024_09_25_205600_create_annual_procurement_plans_table', 7);

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
(21, 'App\\Models\\User', 1, 'main', '524c3b7cf0feb8cb588141e598551e9c45e36d6da62aab210c30516ddd6e011a', '[\"*\"]', '2024-09-25 16:56:53', NULL, '2024-09-25 10:29:26', '2024-09-25 16:56:53'),
(22, 'App\\Models\\User', 26, 'main', 'f98979fb0e907c8a3ac786870deb35658eeb24ead0f415a8240ad1b19fe7b245', '[\"*\"]', '2024-09-25 16:43:43', NULL, '2024-09-25 12:05:24', '2024-09-25 16:43:43'),
(23, 'App\\Models\\User', 27, 'main', 'ae556a523a88e7702eb776e37cf9b6c28bdedd4301298994515eb975ad1ec153', '[\"*\"]', '2024-09-25 16:54:28', NULL, '2024-09-25 16:51:52', '2024-09-25 16:54:28');

-- --------------------------------------------------------

--
-- Table structure for table `purchase_documents`
--

CREATE TABLE `purchase_documents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `status` varchar(255) DEFAULT 'pending',
  `pr_status` varchar(20) NOT NULL DEFAULT 'pending',
  `po_status` varchar(20) DEFAULT 'for review',
  `pr_request_date` varchar(255) DEFAULT NULL,
  `purchase_request` varchar(255) DEFAULT NULL,
  `purchase_order` varchar(255) DEFAULT NULL,
  `order_description` text DEFAULT NULL,
  `request_description` text DEFAULT NULL,
  `return_status` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `po_request_date` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `return_statuses`
--

CREATE TABLE `return_statuses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `return_status` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
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
-- Table structure for table `transaction_logs`
--

CREATE TABLE `transaction_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `document_id` bigint(20) UNSIGNED DEFAULT NULL,
  `deadline` varchar(255) DEFAULT NULL,
  `date_submitted` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transaction_logs`
--

INSERT INTO `transaction_logs` (`id`, `document_id`, `deadline`, `date_submitted`, `status`, `created_at`, `updated_at`) VALUES
(17, 13, NULL, '2024-09-26 00:52:08', 'consolidated', '2024-09-25 16:53:13', '2024-09-25 16:53:13'),
(18, 12, NULL, '2024-09-26 00:43:41', 'consolidated', '2024-09-25 16:53:48', '2024-09-25 16:53:48');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `department_id` int(255) DEFAULT NULL,
  `lastname` varchar(255) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `middle_name` varchar(255) DEFAULT NULL,
  `position` varchar(255) DEFAULT NULL,
  `role` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `contact_number` varchar(12) DEFAULT NULL,
  `username` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `department_id`, `lastname`, `firstname`, `middle_name`, `position`, `role`, `email`, `contact_number`, `username`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, NULL, 'General', 'Admin', NULL, NULL, 'general admin', 'admin@gmail.com', NULL, '', NULL, '$2y$10$jT8C2A3nQBXYN4y6/lBg5.dI39BXRNekX6u5wfwCJi9bGmEdzas1e', NULL, NULL, NULL),
(26, 41, 'Mcdaniel', 'Gisela', 'sdfsadfsadf', 'Backend Developer', 'admin', 'hulej@mailinator.com', '1232323', 'myqiqijyfi', NULL, '$2y$12$pwLuwiSnmeFXXpW.zSGG5e/DtLPsVT4opD6Rirt5nbKejMICfOjx6', NULL, '2024-09-25 12:05:08', '2024-09-25 16:04:41'),
(27, 42, 'Galena', 'Xyla', 'mamamam', 'Aute fugiat adipisi', 'admin', 'moqenihi@mailinator.com', '66', 'bubuvajin', NULL, '$2y$12$Bbnac9kN2r1aE1ClwBlK..Xad/ANs8jeVr1ep6vgtJKJnTPgYX4zK', NULL, '2024-09-25 16:08:09', '2024-09-25 16:51:44'),
(28, NULL, 'Kirk', 'Jasper', NULL, 'Deserunt non ullamco', 'supply office', 'dumurumyju@mailinator.com', '139', 'vycyvof', NULL, '$2y$12$ZGt7J8WczlvWVMi8pOg5lOSgPygn5ZmgPVuAdZ9DgyApEB8Qvyq62', NULL, '2024-09-25 16:49:51', '2024-09-25 16:49:51');

-- --------------------------------------------------------

--
-- Table structure for table `websockets_statistics_entries`
--

CREATE TABLE `websockets_statistics_entries` (
  `id` int(10) UNSIGNED NOT NULL,
  `app_id` varchar(255) NOT NULL,
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
-- Indexes for table `return_statuses`
--
ALTER TABLE `return_statuses`
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
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `documents`
--
ALTER TABLE `documents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `purchase_documents`
--
ALTER TABLE `purchase_documents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `return_statuses`
--
ALTER TABLE `return_statuses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `transaction_logs`
--
ALTER TABLE `transaction_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

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
-- Constraints for table `purchase_documents`
--
ALTER TABLE `purchase_documents`
  ADD CONSTRAINT `purchase_documents_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `transaction_logs`
--
ALTER TABLE `transaction_logs`
  ADD CONSTRAINT `transaction_logs_document_id_foreign` FOREIGN KEY (`document_id`) REFERENCES `documents` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
