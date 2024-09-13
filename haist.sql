-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 10, 2023 at 12:13 AM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `haist`
--

-- --------------------------------------------------------

--
-- Table structure for table `assessments`
--

CREATE TABLE `assessments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `facility_id` bigint(20) UNSIGNED NOT NULL,
  `patient_id` bigint(20) UNSIGNED NOT NULL,
  `heart_rate` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `temperature` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `o2_saturation` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `base_o2_saturation` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `respiratory_rate` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `blood_pressure` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `blood_pressure_down_value` double(8,2) DEFAULT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Pending',
  `diagnose_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `diagnosed_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `assessments`
--

INSERT INTO `assessments` (`id`, `facility_id`, `patient_id`, `heart_rate`, `temperature`, `o2_saturation`, `base_o2_saturation`, `respiratory_rate`, `blood_pressure`, `blood_pressure_down_value`, `status`, `diagnose_id`, `created_at`, `updated_at`, `diagnosed_at`) VALUES
(1, 2, 8, '1', '37', '1', '1', '1', '1', 1.00, 'Completed', 18, '2023-07-31 17:59:34', '2023-07-31 17:59:34', '2023-08-01 11:35:00'),
(2, 2, 8, '1', '37', '1', '1', '1', '1', 1.00, 'Pending', NULL, '2023-07-31 18:00:11', '2023-07-31 18:00:11', NULL),
(3, 2, 8, '1', '37', '1', '1', '1', '1', 1.00, 'Pending', NULL, '2023-07-31 18:00:12', '2023-07-31 18:00:12', NULL),
(4, 2, 8, '1', '37', '1', '1', '1', '1', 1.00, 'Pending', NULL, '2023-07-31 18:00:13', '2023-07-31 18:00:13', NULL),
(5, 2, 8, '1', '37', '1', '1', '1', '1', 1.00, 'Pending', NULL, '2023-07-31 18:00:14', '2023-07-31 18:00:14', NULL),
(6, 2, 8, '1', '37', '1', '1', '1', '1', 1.00, 'Pending', NULL, '2023-07-31 18:00:14', '2023-07-31 18:00:14', NULL),
(7, 2, 8, '1', '37', '1', '1', '1', '1', 1.00, 'Pending', NULL, '2023-07-31 18:00:15', '2023-07-31 18:00:15', NULL),
(8, 2, 8, '1', '37', '1', '1', '1', '1', 1.00, 'Pending', NULL, '2023-07-31 18:00:16', '2023-07-31 18:00:16', NULL),
(9, 2, 8, '1', '37', '1', '1', '1', '1', 1.00, 'Pending', NULL, '2023-07-31 18:00:16', '2023-07-31 18:00:16', NULL),
(10, 2, 8, '1', '37', '1', '1', '1', '1', 1.00, 'Pending', NULL, '2023-07-31 18:00:17', '2023-07-31 18:00:17', NULL),
(11, 2, 8, '1', '37', '1', '1', '1', '1', 1.00, 'Pending', NULL, '2023-07-31 18:00:18', '2023-07-31 18:00:18', NULL),
(12, 2, 8, '1', '37', '1', '1', '1', '1', 1.00, 'Pending', NULL, '2023-07-31 18:00:19', '2023-07-31 18:00:19', NULL),
(13, 2, 8, '1', '37', '1', '1', '1', '1', 1.00, 'Pending', NULL, '2023-07-31 18:00:19', '2023-07-31 18:00:19', NULL),
(14, 2, 8, '1', '37', '1', '1', '1', '1', 1.00, 'Pending', NULL, '2023-07-31 18:00:20', '2023-07-31 18:00:20', NULL),
(15, 2, 8, '1', '37', '1', '1', '1', '1', 1.00, 'Pending', NULL, '2023-07-31 18:00:21', '2023-07-31 18:00:21', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `assessment_possible_diseases`
--

CREATE TABLE `assessment_possible_diseases` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `assessment_id` bigint(20) UNSIGNED NOT NULL,
  `disease_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `assessment_possible_diseases`
--

INSERT INTO `assessment_possible_diseases` (`id`, `assessment_id`, `disease_id`, `created_at`, `updated_at`) VALUES
(1, 1, 18, '2023-07-31 17:59:34', '2023-07-31 17:59:34'),
(2, 2, 18, '2023-07-31 18:00:11', '2023-07-31 18:00:11'),
(3, 3, 18, '2023-07-31 18:00:12', '2023-07-31 18:00:12'),
(4, 4, 18, '2023-07-31 18:00:13', '2023-07-31 18:00:13'),
(5, 5, 18, '2023-07-31 18:00:14', '2023-07-31 18:00:14'),
(6, 6, 18, '2023-07-31 18:00:14', '2023-07-31 18:00:14'),
(7, 7, 18, '2023-07-31 18:00:15', '2023-07-31 18:00:15'),
(8, 8, 18, '2023-07-31 18:00:16', '2023-07-31 18:00:16'),
(9, 9, 18, '2023-07-31 18:00:16', '2023-07-31 18:00:16'),
(10, 10, 18, '2023-07-31 18:00:17', '2023-07-31 18:00:17'),
(11, 11, 18, '2023-07-31 18:00:18', '2023-07-31 18:00:18'),
(12, 12, 18, '2023-07-31 18:00:19', '2023-07-31 18:00:19'),
(13, 13, 18, '2023-07-31 18:00:19', '2023-07-31 18:00:19'),
(14, 14, 18, '2023-07-31 18:00:20', '2023-07-31 18:00:20'),
(15, 15, 18, '2023-07-31 18:00:21', '2023-07-31 18:00:21');

-- --------------------------------------------------------

--
-- Table structure for table `assessment_symptoms`
--

CREATE TABLE `assessment_symptoms` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `assessment_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `symptom_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `assessment_symptoms`
--

INSERT INTO `assessment_symptoms` (`id`, `assessment_id`, `user_id`, `symptom_id`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, 1, '2023-07-31 17:59:34', '2023-07-31 17:59:34'),
(2, 1, NULL, 2, '2023-07-31 17:59:34', '2023-07-31 17:59:34'),
(3, 2, NULL, 1, '2023-07-31 18:00:11', '2023-07-31 18:00:11'),
(4, 2, NULL, 2, '2023-07-31 18:00:11', '2023-07-31 18:00:11'),
(5, 3, NULL, 1, '2023-07-31 18:00:12', '2023-07-31 18:00:12'),
(6, 3, NULL, 2, '2023-07-31 18:00:12', '2023-07-31 18:00:12'),
(7, 4, NULL, 1, '2023-07-31 18:00:13', '2023-07-31 18:00:13'),
(8, 4, NULL, 2, '2023-07-31 18:00:13', '2023-07-31 18:00:13'),
(9, 5, NULL, 1, '2023-07-31 18:00:14', '2023-07-31 18:00:14'),
(10, 5, NULL, 2, '2023-07-31 18:00:14', '2023-07-31 18:00:14'),
(11, 6, NULL, 1, '2023-07-31 18:00:14', '2023-07-31 18:00:14'),
(12, 6, NULL, 2, '2023-07-31 18:00:14', '2023-07-31 18:00:14'),
(13, 7, NULL, 1, '2023-07-31 18:00:15', '2023-07-31 18:00:15'),
(14, 7, NULL, 2, '2023-07-31 18:00:15', '2023-07-31 18:00:15'),
(15, 8, NULL, 1, '2023-07-31 18:00:16', '2023-07-31 18:00:16'),
(16, 8, NULL, 2, '2023-07-31 18:00:16', '2023-07-31 18:00:16'),
(17, 9, NULL, 1, '2023-07-31 18:00:16', '2023-07-31 18:00:16'),
(18, 9, NULL, 2, '2023-07-31 18:00:16', '2023-07-31 18:00:16'),
(19, 10, NULL, 1, '2023-07-31 18:00:17', '2023-07-31 18:00:17'),
(20, 10, NULL, 2, '2023-07-31 18:00:17', '2023-07-31 18:00:17'),
(21, 11, NULL, 1, '2023-07-31 18:00:18', '2023-07-31 18:00:18'),
(22, 11, NULL, 2, '2023-07-31 18:00:18', '2023-07-31 18:00:18'),
(23, 12, NULL, 1, '2023-07-31 18:00:19', '2023-07-31 18:00:19'),
(24, 12, NULL, 2, '2023-07-31 18:00:19', '2023-07-31 18:00:19'),
(25, 13, NULL, 1, '2023-07-31 18:00:19', '2023-07-31 18:00:19'),
(26, 13, NULL, 2, '2023-07-31 18:00:19', '2023-07-31 18:00:19'),
(27, 14, NULL, 1, '2023-07-31 18:00:20', '2023-07-31 18:00:20'),
(28, 14, NULL, 2, '2023-07-31 18:00:20', '2023-07-31 18:00:20'),
(29, 15, NULL, 1, '2023-07-31 18:00:21', '2023-07-31 18:00:21'),
(30, 15, NULL, 2, '2023-07-31 18:00:21', '2023-07-31 18:00:21');

-- --------------------------------------------------------

--
-- Table structure for table `assessment_tests`
--

CREATE TABLE `assessment_tests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `facility_id` bigint(20) UNSIGNED NOT NULL,
  `assessment_id` bigint(20) UNSIGNED NOT NULL,
  `test_id` bigint(20) UNSIGNED NOT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `notes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Symptom',
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `category_type`, `name`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Symptom', 'Category 1', NULL, '2023-07-02 00:07:00', '2023-07-02 00:07:00');

-- --------------------------------------------------------

--
-- Table structure for table `diagnoses`
--

CREATE TABLE `diagnoses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `diagnoses`
--

INSERT INTO `diagnoses` (`id`, `name`, `created_at`, `updated_at`) VALUES
(18, 'a', '2023-07-03 23:36:39', '2023-07-03 23:36:39');

-- --------------------------------------------------------

--
-- Table structure for table `diagnose_cases`
--

CREATE TABLE `diagnose_cases` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `diagnose_id` bigint(20) UNSIGNED NOT NULL,
  `diagnose_condition_id` bigint(20) UNSIGNED NOT NULL,
  `case_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `case_id` bigint(20) UNSIGNED NOT NULL,
  `must_include` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `diagnose_cases`
--

INSERT INTO `diagnose_cases` (`id`, `diagnose_id`, `diagnose_condition_id`, `case_type`, `case_id`, `must_include`, `created_at`, `updated_at`) VALUES
(12, 18, 21, 'App\\Models\\Symptom', 1, 0, '2023-07-03 23:36:39', '2023-07-03 23:36:39'),
(13, 18, 21, 'App\\Models\\Symptom', 2, 0, '2023-07-03 23:36:39', '2023-07-03 23:36:39'),
(14, 18, 21, 'App\\Models\\DiagnoseCriteria', 1, 1, '2023-07-03 23:36:39', '2023-07-03 23:36:39'),
(15, 18, 22, 'App\\Models\\Symptom', 1, 0, '2023-07-03 23:36:39', '2023-07-03 23:36:39'),
(16, 18, 22, 'App\\Models\\Symptom', 2, 0, '2023-07-03 23:36:39', '2023-07-03 23:36:39'),
(17, 18, 22, 'App\\Models\\DiagnoseCriteria', 1, 1, '2023-07-03 23:36:39', '2023-07-03 23:36:39');

-- --------------------------------------------------------

--
-- Table structure for table `diagnose_conditions`
--

CREATE TABLE `diagnose_conditions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `diagnose_id` bigint(20) UNSIGNED NOT NULL,
  `compulsory_cases` int(10) UNSIGNED DEFAULT 0,
  `type` enum('main','or','and') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'main',
  `check_o2_saturation` tinyint(1) NOT NULL DEFAULT 0,
  `o2_saturation_difference_value` float NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `diagnose_conditions`
--

INSERT INTO `diagnose_conditions` (`id`, `diagnose_id`, `compulsory_cases`, `type`, `check_o2_saturation`, `o2_saturation_difference_value`, `created_at`, `updated_at`) VALUES
(21, 18, 2, 'main', 0, 0, '2023-07-03 23:36:39', '2023-07-03 23:36:39'),
(22, 18, 2, 'or', 0, 0, '2023-07-03 23:36:39', '2023-07-03 23:36:39');

-- --------------------------------------------------------

--
-- Table structure for table `diagnose_criterias`
--

CREATE TABLE `diagnose_criterias` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `criteria_key` enum('heart_rate','temperature','o2_saturation','base_o2_saturation','respiratory_rate','blood_pressure') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `criteria_comparison_operator` enum('gt','lt','eq','gte','lte') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `criteria_value` double(8,2) DEFAULT NULL,
  `blood_pressure_down_value` double(8,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `diagnose_criterias`
--

INSERT INTO `diagnose_criterias` (`id`, `name`, `criteria_key`, `criteria_comparison_operator`, `criteria_value`, `blood_pressure_down_value`, `created_at`, `updated_at`) VALUES
(1, 'Fever', 'temperature', 'gt', 36.00, NULL, '2023-07-02 00:07:39', '2023-07-02 00:07:39');

-- --------------------------------------------------------

--
-- Table structure for table `diagnose_tests`
--

CREATE TABLE `diagnose_tests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `diagnose_id` bigint(20) UNSIGNED NOT NULL,
  `test_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `diagnose_tests`
--

INSERT INTO `diagnose_tests` (`id`, `diagnose_id`, `test_id`, `created_at`, `updated_at`) VALUES
(7, 18, 1, '2023-07-03 23:36:39', '2023-07-03 23:36:39');

-- --------------------------------------------------------

--
-- Table structure for table `disease_tests`
--

CREATE TABLE `disease_tests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `disease_tests`
--

INSERT INTO `disease_tests` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'test 1', NULL, '2023-07-03 03:35:28', '2023-07-03 03:35:28'),
(2, 'test 2', NULL, '2023-07-03 03:35:32', '2023-07-03 03:35:32');

-- --------------------------------------------------------

--
-- Table structure for table `facilities`
--

CREATE TABLE `facilities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bio` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `facilities`
--

INSERT INTO `facilities` (`id`, `name`, `phone`, `email`, `bio`, `created_at`, `updated_at`) VALUES
(1, 'a', '1231231234', 'a@facility.com', NULL, '2023-07-18 18:44:02', '2023-07-18 18:44:02'),
(2, 'Another Facility', '1231231234', 'someone@example.com', 'abcd', '2023-07-31 17:24:12', '2023-07-31 17:24:12');

-- --------------------------------------------------------

--
-- Table structure for table `facility_admins`
--

CREATE TABLE `facility_admins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `facility_id` bigint(20) UNSIGNED NOT NULL,
  `admin_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `facility_admins`
--

INSERT INTO `facility_admins` (`id`, `facility_id`, `admin_id`, `created_at`, `updated_at`) VALUES
(2, 1, 2, '2023-07-31 17:23:45', '2023-07-31 17:23:45'),
(3, 2, 2, '2023-07-31 17:24:12', '2023-07-31 17:24:12');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `admin_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `facility_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin CHECK (json_valid(`facility_ids`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `admin_id`, `name`, `facility_ids`, `created_at`, `updated_at`) VALUES
(1, 2, 'Group 1', '[\"1\",\"2\"]', '2023-08-05 08:19:06', '2023-08-05 08:19:06');

-- --------------------------------------------------------

--
-- Table structure for table `hand_washes`
--

CREATE TABLE `hand_washes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `screen_wash_counter` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `hand_wash_counter` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `date_at` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2013_00_12_170610_create_roles_table', 1),
(2, '2014_10_12_000000_create_users_table', 1),
(3, '2014_10_12_100000_create_password_resets_table', 1),
(4, '2019_08_19_000000_create_failed_jobs_table', 1),
(5, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(6, '2023_02_20_215556_create_categories_table', 1),
(7, '2023_02_20_215718_create_symptoms_table', 1),
(8, '2023_04_02_180031_create_facilities_table', 1),
(9, '2023_04_02_182554_add_facility_id_to_users_table', 1),
(10, '2023_05_08_154340_create_assessments_table', 1),
(11, '2023_05_08_161435_create_assessment_symptoms_table', 1),
(12, '2023_05_08_172622_create_diagnoses_table', 1),
(13, '2023_05_08_172631_create_diagnose_criterias_table', 1),
(14, '2023_05_08_214233_add_otp_to_users_table', 1),
(15, '2023_05_10_170213_add_last_criteria_if_all_fails_to_diagnoses_table', 1),
(16, '2023_05_20_170712_create_assessment_possible_diseases_table', 1),
(17, '2023_05_29_152715_create_disease_tests_table', 1),
(18, '2023_06_06_160704_create_diagnose_tests_table', 1),
(19, '2023_06_06_160801_create_assessment_tests_table', 1),
(20, '2023_06_14_135549_add_must_include_criteria_to_diagnoses_table', 1),
(21, '2023_06_15_163932_add_must_include_symptom_ids_to_diagnoses_table', 1),
(22, '2023_06_21_170152_add_o2_saturation_fields_to_diagnoses_table', 1),
(23, '2023_06_26_194413_add_criteria_ids_to_diagnoses_table', 1),
(24, '2023_06_27_171855_add_compulsory_criteria_to_diagnoses_table', 1),
(25, '2023_06_27_173153_add_user_id_to_assessment_symptoms_table', 1),
(26, '2023_06_28_005428_new_table_diagnoses', 1),
(27, '2023_06_28_010105_create_diagnose_conditions_table', 1),
(28, '2023_07_02_050507_create_diagnose_cases_table', 1),
(29, '2023_07_13_191259_add_diagnose_id_to_assessments_table', 2),
(30, '2023_07_13_191703_add_fields_to_assessment_tests_table', 3),
(31, '2023_07_18_222355_add_down_blood_pressure_value_to_diagnose_criterias_table', 4),
(32, '2023_07_18_222527_add_blood_pressure_down_value_to_assessments_table', 5),
(33, '2023_07_19_000756_create_patient_symptoms_table', 6),
(34, '2023_07_19_001509_create_notifications_table', 7),
(35, '2023_07_19_003601_add_doctor_id_to_users_table', 8),
(36, '2023_07_27_132023_create_hand_washes_table', 9),
(38, '2023_07_31_221047_create_facility_admins_table', 10),
(39, '2023_08_05_112942_add_diagnosed_at_to_assessments_table', 11),
(41, '2023_08_05_130508_create_groups_table', 12),
(42, '2023_08_05_140522_add_assessment_id_to_patient_symptoms_table', 13);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_id` bigint(20) UNSIGNED NOT NULL,
  `data` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `patient_symptoms`
--

CREATE TABLE `patient_symptoms` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `facility_id` bigint(20) UNSIGNED NOT NULL,
  `assistant_nurse_id` bigint(20) UNSIGNED NOT NULL,
  `patient_id` bigint(20) UNSIGNED NOT NULL,
  `symptom_id` bigint(20) UNSIGNED NOT NULL,
  `assessment_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
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
(1, 'App\\Models\\User', 6, 'Login', '79b08ed918a6fcfe997487519e727aaf3d2e5323b957194855adf9108b781fa5', '[\"*\"]', '2023-07-31 18:00:21', NULL, '2023-07-31 17:53:30', '2023-07-31 18:00:21');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Haist Admin', '2023-07-02 00:06:42', '2023-07-02 00:06:42'),
(2, 'Admin', '2023-07-02 00:06:42', '2023-07-02 00:06:42'),
(3, 'Manager', '2023-07-02 00:06:42', '2023-07-02 00:06:42'),
(4, 'Nurse', '2023-07-02 00:06:42', '2023-07-02 00:06:42'),
(5, 'Assistant Nurse', '2023-07-02 00:06:42', '2023-07-02 00:06:42'),
(6, 'Worker', '2023-07-02 00:06:42', '2023-07-02 00:06:42'),
(7, 'Patient', '2023-07-02 00:06:42', '2023-07-02 00:06:42'),
(8, 'Doctor', '2023-07-02 00:06:42', '2023-07-02 00:06:42');

-- --------------------------------------------------------

--
-- Table structure for table `symptoms`
--

CREATE TABLE `symptoms` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `symptoms`
--

INSERT INTO `symptoms` (`id`, `category_id`, `name`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 1, 'Symptom 1', NULL, '2023-07-02 00:07:07', '2023-07-02 00:07:07'),
(2, 1, 'Symptom 2', NULL, '2023-07-02 00:07:13', '2023-07-02 00:07:13');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `doctor_id` bigint(20) UNSIGNED DEFAULT NULL,
  `first_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` enum('Male','Female','Others') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `otp` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `room_number` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `facility_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `role_id`, `doctor_id`, `first_name`, `last_name`, `email`, `email_verified_at`, `password`, `avatar`, `phone`, `gender`, `dob`, `otp`, `room_number`, `remember_token`, `created_at`, `updated_at`, `facility_id`) VALUES
(1, 1, NULL, 'Syed', 'Azlan Ali', 'azlanali076@gmail.com', NULL, '$2y$10$DPEtUZ.A0br5V/DuRlKw2ukNPb0hlRobhgJ/QM0YJp19VHdah2UfC', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-07-02 00:06:42', '2023-07-02 00:06:42', NULL),
(2, 2, NULL, 'a', 'b', 'ab@facility.com', NULL, '$2y$10$OngZAYSqW68yuj8r./WIlOKvzrcn9gF3cJHhWZ5Dm5hDwpzeWUGvW', NULL, '1231231234', 'Male', '2001-03-25', NULL, NULL, NULL, '2023-07-18 18:44:21', '2023-07-18 18:44:21', NULL),
(3, 3, NULL, 'manaager', 'facility', 'manager@facility.com', NULL, '$2y$10$es2UBVzf1lQArHcvZhpDT.nN8TrlkCAzljk2XnF7vfPtMVggLza1y', NULL, '1231231234', 'Male', '2001-03-25', NULL, NULL, NULL, '2023-07-18 18:47:04', '2023-07-31 17:36:15', 2),
(5, 8, NULL, 'a', 'b', 'a@b.com', NULL, '$2y$10$lHROgl0j60dUVbk.ojdv4um39DKHN4GN.sh8TcPFOPPodk6gBZ8By', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-07-18 19:03:40', '2023-07-18 19:03:40', 1),
(6, 4, NULL, 'nurse', 'test', 'nurse@gmail.com', NULL, '$2y$10$jDeNgaqkfBnuQZODG9INeupjL7e1YFJnYCBrHPQDYtNcy71EflXBq', NULL, '1231231234', 'Female', '2001-03-25', NULL, NULL, NULL, '2023-07-31 17:38:49', '2023-07-31 17:38:59', 2),
(7, 8, NULL, 'Doctor', '1', 'doctor1@gmail.com', NULL, '$2y$10$2f8njSsUVkLbmshHSsZ0L.6X9J8Tv8wa/tvRH8au7QroekFIvwARm', NULL, NULL, 'Female', '2001-03-25', NULL, NULL, NULL, '2023-07-31 17:56:14', '2023-07-31 17:57:41', 2),
(8, 7, 7, 'patient', '1', 'patient1@gmail.com', NULL, '$2y$10$4MrDnIP1RioOhIW5gCUvX.GepivHYBMIvri.qrLYDJtqSTn.JAB5S', NULL, NULL, 'Male', '2001-03-25', NULL, '1', NULL, '2023-07-31 17:58:14', '2023-07-31 17:58:14', 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `assessments`
--
ALTER TABLE `assessments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `assessments_facility_id_foreign` (`facility_id`),
  ADD KEY `assessments_patient_id_foreign` (`patient_id`),
  ADD KEY `assessments_diagnose_id_foreign` (`diagnose_id`);

--
-- Indexes for table `assessment_possible_diseases`
--
ALTER TABLE `assessment_possible_diseases`
  ADD PRIMARY KEY (`id`),
  ADD KEY `assessment_possible_diseases_assessment_id_foreign` (`assessment_id`),
  ADD KEY `assessment_possible_diseases_disease_id_foreign` (`disease_id`);

--
-- Indexes for table `assessment_symptoms`
--
ALTER TABLE `assessment_symptoms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `assessment_symptoms_assessment_id_foreign` (`assessment_id`),
  ADD KEY `assessment_symptoms_symptom_id_foreign` (`symptom_id`),
  ADD KEY `assessment_symptoms_user_id_foreign` (`user_id`);

--
-- Indexes for table `assessment_tests`
--
ALTER TABLE `assessment_tests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `assessment_tests_facility_id_foreign` (`facility_id`),
  ADD KEY `assessment_tests_assessment_id_foreign` (`assessment_id`),
  ADD KEY `assessment_tests_test_id_foreign` (`test_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `diagnoses`
--
ALTER TABLE `diagnoses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `diagnose_cases`
--
ALTER TABLE `diagnose_cases`
  ADD PRIMARY KEY (`id`),
  ADD KEY `diagnose_cases_diagnose_id_foreign` (`diagnose_id`),
  ADD KEY `diagnose_cases_diagnose_condition_id_foreign` (`diagnose_condition_id`),
  ADD KEY `diagnose_cases_case_type_case_id_index` (`case_type`,`case_id`);

--
-- Indexes for table `diagnose_conditions`
--
ALTER TABLE `diagnose_conditions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `diagnose_conditions_diagnose_id_foreign` (`diagnose_id`);

--
-- Indexes for table `diagnose_criterias`
--
ALTER TABLE `diagnose_criterias`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `diagnose_tests`
--
ALTER TABLE `diagnose_tests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `diagnose_tests_diagnose_id_foreign` (`diagnose_id`),
  ADD KEY `diagnose_tests_test_id_foreign` (`test_id`);

--
-- Indexes for table `disease_tests`
--
ALTER TABLE `disease_tests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `facilities`
--
ALTER TABLE `facilities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `facility_admins`
--
ALTER TABLE `facility_admins`
  ADD PRIMARY KEY (`id`),
  ADD KEY `facility_admins_facility_id_foreign` (`facility_id`),
  ADD KEY `facility_admins_admin_id_foreign` (`admin_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `groups_admin_id_foreign` (`admin_id`);

--
-- Indexes for table `hand_washes`
--
ALTER TABLE `hand_washes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `hand_washes_user_id_foreign` (`user_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `patient_symptoms`
--
ALTER TABLE `patient_symptoms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `patient_symptoms_facility_id_foreign` (`facility_id`),
  ADD KEY `patient_symptoms_assistant_nurse_id_foreign` (`assistant_nurse_id`),
  ADD KEY `patient_symptoms_patient_id_foreign` (`patient_id`),
  ADD KEY `patient_symptoms_symptom_id_foreign` (`symptom_id`),
  ADD KEY `patient_symptoms_assessment_id_foreign` (`assessment_id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `symptoms`
--
ALTER TABLE `symptoms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `symptoms_category_id_foreign` (`category_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_role_id_foreign` (`role_id`),
  ADD KEY `users_facility_id_foreign` (`facility_id`),
  ADD KEY `users_doctor_id_foreign` (`doctor_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `assessments`
--
ALTER TABLE `assessments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `assessment_possible_diseases`
--
ALTER TABLE `assessment_possible_diseases`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `assessment_symptoms`
--
ALTER TABLE `assessment_symptoms`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `assessment_tests`
--
ALTER TABLE `assessment_tests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `diagnoses`
--
ALTER TABLE `diagnoses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `diagnose_cases`
--
ALTER TABLE `diagnose_cases`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `diagnose_conditions`
--
ALTER TABLE `diagnose_conditions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `diagnose_criterias`
--
ALTER TABLE `diagnose_criterias`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `diagnose_tests`
--
ALTER TABLE `diagnose_tests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `disease_tests`
--
ALTER TABLE `disease_tests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `facilities`
--
ALTER TABLE `facilities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `facility_admins`
--
ALTER TABLE `facility_admins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `hand_washes`
--
ALTER TABLE `hand_washes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `patient_symptoms`
--
ALTER TABLE `patient_symptoms`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `symptoms`
--
ALTER TABLE `symptoms`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `assessments`
--
ALTER TABLE `assessments`
  ADD CONSTRAINT `assessments_diagnose_id_foreign` FOREIGN KEY (`diagnose_id`) REFERENCES `diagnoses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `assessments_facility_id_foreign` FOREIGN KEY (`facility_id`) REFERENCES `facilities` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `assessments_patient_id_foreign` FOREIGN KEY (`patient_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `assessment_possible_diseases`
--
ALTER TABLE `assessment_possible_diseases`
  ADD CONSTRAINT `assessment_possible_diseases_assessment_id_foreign` FOREIGN KEY (`assessment_id`) REFERENCES `assessments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `assessment_possible_diseases_disease_id_foreign` FOREIGN KEY (`disease_id`) REFERENCES `diagnoses` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `assessment_symptoms`
--
ALTER TABLE `assessment_symptoms`
  ADD CONSTRAINT `assessment_symptoms_assessment_id_foreign` FOREIGN KEY (`assessment_id`) REFERENCES `assessments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `assessment_symptoms_symptom_id_foreign` FOREIGN KEY (`symptom_id`) REFERENCES `symptoms` (`id`),
  ADD CONSTRAINT `assessment_symptoms_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `assessment_tests`
--
ALTER TABLE `assessment_tests`
  ADD CONSTRAINT `assessment_tests_assessment_id_foreign` FOREIGN KEY (`assessment_id`) REFERENCES `assessments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `assessment_tests_facility_id_foreign` FOREIGN KEY (`facility_id`) REFERENCES `facilities` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `assessment_tests_test_id_foreign` FOREIGN KEY (`test_id`) REFERENCES `disease_tests` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `diagnose_cases`
--
ALTER TABLE `diagnose_cases`
  ADD CONSTRAINT `diagnose_cases_diagnose_condition_id_foreign` FOREIGN KEY (`diagnose_condition_id`) REFERENCES `diagnose_conditions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `diagnose_cases_diagnose_id_foreign` FOREIGN KEY (`diagnose_id`) REFERENCES `diagnoses` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `diagnose_conditions`
--
ALTER TABLE `diagnose_conditions`
  ADD CONSTRAINT `diagnose_conditions_diagnose_id_foreign` FOREIGN KEY (`diagnose_id`) REFERENCES `diagnoses` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `diagnose_tests`
--
ALTER TABLE `diagnose_tests`
  ADD CONSTRAINT `diagnose_tests_diagnose_id_foreign` FOREIGN KEY (`diagnose_id`) REFERENCES `diagnoses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `diagnose_tests_test_id_foreign` FOREIGN KEY (`test_id`) REFERENCES `disease_tests` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `facility_admins`
--
ALTER TABLE `facility_admins`
  ADD CONSTRAINT `facility_admins_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `facility_admins_facility_id_foreign` FOREIGN KEY (`facility_id`) REFERENCES `facilities` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `groups`
--
ALTER TABLE `groups`
  ADD CONSTRAINT `groups_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `hand_washes`
--
ALTER TABLE `hand_washes`
  ADD CONSTRAINT `hand_washes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `patient_symptoms`
--
ALTER TABLE `patient_symptoms`
  ADD CONSTRAINT `patient_symptoms_assessment_id_foreign` FOREIGN KEY (`assessment_id`) REFERENCES `assessments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `patient_symptoms_assistant_nurse_id_foreign` FOREIGN KEY (`assistant_nurse_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `patient_symptoms_facility_id_foreign` FOREIGN KEY (`facility_id`) REFERENCES `facilities` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `patient_symptoms_patient_id_foreign` FOREIGN KEY (`patient_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `patient_symptoms_symptom_id_foreign` FOREIGN KEY (`symptom_id`) REFERENCES `symptoms` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `symptoms`
--
ALTER TABLE `symptoms`
  ADD CONSTRAINT `symptoms_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_doctor_id_foreign` FOREIGN KEY (`doctor_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `users_facility_id_foreign` FOREIGN KEY (`facility_id`) REFERENCES `facilities` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
