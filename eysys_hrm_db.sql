-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 23, 2021 at 02:15 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.3.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `eysys_hrm_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `account_lists`
--

CREATE TABLE `account_lists` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `account_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `initial_balance` double NOT NULL DEFAULT 0,
  `account_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `branch_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bank_branch` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `allowances`
--

CREATE TABLE `allowances` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` int(11) NOT NULL,
  `allowance_option` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `allowance_options`
--

CREATE TABLE `allowance_options` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

CREATE TABLE `announcements` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `branch_id` int(11) NOT NULL,
  `department_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `employee_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `announcement_employees`
--

CREATE TABLE `announcement_employees` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `announcement_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `appraisals`
--

CREATE TABLE `appraisals` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `branch` int(11) NOT NULL DEFAULT 0,
  `employee` int(11) NOT NULL DEFAULT 0,
  `appraisal_date` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_experience` int(11) NOT NULL DEFAULT 0,
  `marketing` int(11) NOT NULL DEFAULT 0,
  `administration` int(11) NOT NULL DEFAULT 0,
  `professionalism` int(11) NOT NULL DEFAULT 0,
  `integrity` int(11) NOT NULL DEFAULT 0,
  `attendance` int(11) NOT NULL DEFAULT 0,
  `remark` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `assets`
--

CREATE TABLE `assets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `purchase_date` date NOT NULL,
  `supported_date` date NOT NULL,
  `amount` double NOT NULL DEFAULT 0,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `attendance_employees`
--

CREATE TABLE `attendance_employees` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `clock_in` time NOT NULL,
  `clock_out` time NOT NULL,
  `late` time NOT NULL,
  `early_leaving` time NOT NULL,
  `overtime` time NOT NULL,
  `total_rest` time NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `attendance_employees`
--

INSERT INTO `attendance_employees` (`id`, `employee_id`, `date`, `status`, `clock_in`, `clock_out`, `late`, `early_leaving`, `overtime`, `total_rest`, `created_by`, `created_at`, `updated_at`) VALUES
(3, 1, '2021-02-18', 'Present', '09:00:00', '17:00:00', '00:00:00', '01:00:00', '00:00:00', '00:00:00', 1, '2021-02-18 06:12:39', '2021-02-18 06:13:04'),
(4, 1, '2021-02-19', 'Present', '09:00:00', '18:00:00', '00:00:00', '00:00:00', '00:00:00', '00:00:00', 1, '2021-02-19 00:45:46', '2021-02-19 00:45:46'),
(5, 0, '2021-02-19', 'Present', '07:22:30', '11:10:38', '-00:00:02', '06:49:22', '00:00:00', '00:00:00', 3, '2021-02-19 01:52:30', '2021-02-19 05:40:38'),
(6, 1, '2021-02-22', 'Leave', '00:00:00', '00:00:00', '00:00:00', '00:00:00', '00:00:00', '00:00:00', 1, '2021-02-22 02:52:05', '2021-02-22 02:52:05'),
(7, 1, '2021-02-23', 'Present', '09:00:00', '18:00:00', '00:00:00', '00:00:00', '00:00:00', '00:00:00', 1, '2021-02-22 22:51:58', '2021-02-22 22:51:58');

-- --------------------------------------------------------

--
-- Table structure for table `awards`
--

CREATE TABLE `awards` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` int(11) NOT NULL,
  `award_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `gift` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `award_types`
--

CREATE TABLE `award_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `branches`
--

CREATE TABLE `branches` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `branch_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `branches`
--

INSERT INTO `branches` (`id`, `name`, `created_by`, `created_at`, `updated_at`, `branch_name`) VALUES
(1, 'KL', 1, '2021-02-17 00:19:48', '2021-02-17 00:23:51', 'Kerala'),
(2, 'KA', 1, '2021-02-17 00:24:56', '2021-02-17 00:24:56', 'Karnataka');

-- --------------------------------------------------------

--
-- Table structure for table `commissions`
--

CREATE TABLE `commissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `company_policies`
--

CREATE TABLE `company_policies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `branch` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `attachment` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `complaints`
--

CREATE TABLE `complaints` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `complaint_from` int(11) NOT NULL,
  `complaint_against` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `complaint_date` date NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `deduction_options`
--

CREATE TABLE `deduction_options` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `deduction_options`
--

INSERT INTO `deduction_options` (`id`, `name`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'Deduction1', 1, '2021-02-23 05:27:42', '2021-02-23 05:27:42');

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `branch_id`, `name`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 1, 'Med', 1, '2021-02-17 00:25:20', '2021-02-17 00:25:20');

-- --------------------------------------------------------

--
-- Table structure for table `deposits`
--

CREATE TABLE `deposits` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `account_id` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `date` date NOT NULL,
  `income_category_id` int(11) NOT NULL,
  `payer_id` int(11) NOT NULL,
  `payment_type_id` int(11) NOT NULL,
  `referal_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `designations`
--

CREATE TABLE `designations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `department_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `designations`
--

INSERT INTO `designations` (`id`, `department_id`, `name`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 1, 'Staff', 1, '2021-02-17 00:25:48', '2021-02-17 00:25:48'),
(2, 1, 'Zonal manager', 1, '2021-02-22 22:56:49', '2021-02-22 22:56:49');

-- --------------------------------------------------------

--
-- Table structure for table `documents`
--

CREATE TABLE `documents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_required` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `documents`
--

INSERT INTO `documents` (`id`, `name`, `is_required`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'PAN Card', '1', 1, '2021-02-17 00:52:27', '2021-02-17 00:52:27');

-- --------------------------------------------------------

--
-- Table structure for table `ducument_uploads`
--

CREATE TABLE `ducument_uploads` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `document` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dob` date DEFAULT NULL,
  `gender` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `state_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `state_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `blood_group` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `head_quarter` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `employee_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `branch_id` int(11) NOT NULL,
  `department_id` int(11) NOT NULL,
  `designation_id` int(11) NOT NULL,
  `company_doj` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `documents` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `account_holder_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `account_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_identifier_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `branch_location` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tax_payer_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `salary_type` int(11) DEFAULT NULL,
  `salary` double DEFAULT 0,
  `transfer_date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` int(11) NOT NULL DEFAULT 1,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `middle_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `employee_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pan_card_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `aadhaar_card_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `user_id`, `name`, `dob`, `gender`, `phone`, `address`, `state_id`, `state_code`, `email`, `blood_group`, `head_quarter`, `employee_id`, `branch_id`, `department_id`, `designation_id`, `company_doj`, `documents`, `account_holder_name`, `account_number`, `bank_name`, `bank_identifier_code`, `branch_location`, `tax_payer_id`, `salary_type`, `salary`, `transfer_date`, `is_active`, `created_by`, `created_at`, `updated_at`, `middle_name`, `last_name`, `employee_code`, `pan_card_number`, `aadhaar_card_number`) VALUES
(1, 3, 'Reshmin', '1992-01-17', 'Male', '9090909090', 'test address', '', '', 'reshmin.futura@gmail.com', 'B+', 'Calicuts', '1', 1, 1, 1, '2021-02-18', '1', 'Reshmin', '4564742342424', 'SBI', 'ifcv668999', 'Mpr', '254488', 1, 25000, NULL, 1, 1, '2021-02-18 03:18:34', '2021-02-23 06:34:03', '', 'DP', 'IHC/KL/01', 'SDA2213425', '2446747567');

-- --------------------------------------------------------

--
-- Table structure for table `employee_documents`
--

CREATE TABLE `employee_documents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` int(11) NOT NULL,
  `document_id` int(11) NOT NULL,
  `document_value` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `employee_documents`
--

INSERT INTO `employee_documents` (`id`, `employee_id`, `document_id`, `document_value`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'board_1613638114.jpg', 1, '2021-02-18 03:18:34', '2021-02-18 03:18:34');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` int(11) NOT NULL,
  `department_id` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `employee_id` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `color` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `branch_id`, `department_id`, `employee_id`, `title`, `start_date`, `end_date`, `color`, `description`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 1, '[\"1\"]', '[\"1\"]', 'Test Event', '2021-02-17', '2021-02-18', '#FF5630', 'test description', 1, '2021-02-18 04:37:57', '2021-02-18 04:37:57');

-- --------------------------------------------------------

--
-- Table structure for table `event_employees`
--

CREATE TABLE `event_employees` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `event_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `event_employees`
--

INSERT INTO `event_employees` (`id`, `event_id`, `employee_id`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, '2021-02-18 04:37:57', '2021-02-18 04:37:57');

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `account_id` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `date` date NOT NULL,
  `expense_category_id` int(11) NOT NULL,
  `payee_id` int(11) NOT NULL,
  `payment_type_id` int(11) NOT NULL,
  `referal_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `expense_types`
--

CREATE TABLE `expense_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `favorites`
--

CREATE TABLE `favorites` (
  `id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `favorite_id` bigint(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `genrate_payslip_options`
--

CREATE TABLE `genrate_payslip_options` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `goal_trackings`
--

CREATE TABLE `goal_trackings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `branch` int(11) NOT NULL,
  `goal_type` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `target_achievement` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `progress` int(11) NOT NULL DEFAULT 0,
  `created_by` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `goal_types`
--

CREATE TABLE `goal_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `holidays`
--

CREATE TABLE `holidays` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `occasion` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `holidays`
--

INSERT INTO `holidays` (`id`, `date`, `occasion`, `created_by`, `created_at`, `updated_at`) VALUES
(1, '2021-02-21', 'Sunday', 1, '2021-02-20 01:46:00', '2021-02-20 01:46:00');

-- --------------------------------------------------------

--
-- Table structure for table `income_types`
--

CREATE TABLE `income_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `indicators`
--

CREATE TABLE `indicators` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `branch` int(11) NOT NULL DEFAULT 0,
  `department` int(11) NOT NULL DEFAULT 0,
  `designation` int(11) NOT NULL DEFAULT 0,
  `customer_experience` int(11) NOT NULL DEFAULT 0,
  `marketing` int(11) NOT NULL DEFAULT 0,
  `administration` int(11) NOT NULL DEFAULT 0,
  `professionalism` int(11) NOT NULL DEFAULT 0,
  `integrity` int(11) NOT NULL DEFAULT 0,
  `attendance` int(11) NOT NULL DEFAULT 0,
  `created_user` int(11) NOT NULL DEFAULT 0,
  `created_by` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `leaves`
--

CREATE TABLE `leaves` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` int(11) NOT NULL,
  `leave_type_id` int(11) NOT NULL,
  `applied_on` date NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `total_leave_days` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `leave_reason` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remark` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `leave_types`
--

CREATE TABLE `leave_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `days` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `loans`
--

CREATE TABLE `loans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` int(11) NOT NULL,
  `loan_option` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `reason` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `loan_options`
--

CREATE TABLE `loan_options` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `loan_options`
--

INSERT INTO `loan_options` (`id`, `name`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'house', 1, '2021-02-18 00:27:16', '2021-02-18 00:27:16');

-- --------------------------------------------------------

--
-- Table structure for table `managers`
--

CREATE TABLE `managers` (
  `manager_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `manager_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `manager_email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `manager_contact` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `manager_type` int(11) NOT NULL,
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `manager_last_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `manager_branch_id` int(11) NOT NULL,
  `date_of_birth` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `manager_department_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `managers`
--

INSERT INTO `managers` (`manager_id`, `user_id`, `manager_name`, `manager_email`, `manager_contact`, `manager_type`, `created_by`, `created_at`, `updated_at`, `manager_last_name`, `manager_branch_id`, `date_of_birth`, `gender`, `address`, `manager_department_id`) VALUES
(1, 5, 'ZManager', 'reshminsouparnam@gmail.com', '9047871111', 2, '1', '2021-02-22 23:47:24', '2021-02-23 05:25:22', 'DP', 1, '1990-03-01', 'Male', 'my addressrr', 1);

-- --------------------------------------------------------

--
-- Table structure for table `meetings`
--

CREATE TABLE `meetings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` int(11) NOT NULL,
  `department_id` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `employee_id` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `note` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `meeting_employees`
--

CREATE TABLE `meeting_employees` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `meeting_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` bigint(20) NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `from_id` bigint(20) NOT NULL,
  `to_id` bigint(20) NOT NULL,
  `body` varchar(5000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `attachment` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `seen` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(248, '2014_10_12_000000_create_users_table', 1),
(249, '2014_10_12_100000_create_password_resets_table', 1),
(250, '2019_08_19_000000_create_failed_jobs_table', 1),
(251, '2019_09_22_192348_create_messages_table', 1),
(252, '2019_09_28_102009_create_settings_table', 1),
(253, '2019_10_16_211433_create_favorites_table', 1),
(254, '2019_10_18_223259_add_avatar_to_users', 1),
(255, '2019_10_20_211056_add_messenger_color_to_users', 1),
(256, '2019_10_22_000539_add_dark_mode_to_users', 1),
(257, '2019_10_25_214038_add_active_status_to_users', 1),
(258, '2019_12_26_101754_create_departments_table', 1),
(259, '2019_12_26_101814_create_designations_table', 1),
(260, '2019_12_26_105721_create_documents_table', 1),
(261, '2019_12_27_083751_create_branches_table', 1),
(262, '2019_12_27_090831_create_employees_table', 1),
(263, '2019_12_27_112922_create_employee_documents_table', 1),
(264, '2019_12_28_050508_create_awards_table', 1),
(265, '2019_12_28_050919_create_award_types_table', 1),
(266, '2019_12_31_060916_create_termination_types_table', 1),
(267, '2019_12_31_062259_create_terminations_table', 1),
(268, '2019_12_31_070521_create_resignations_table', 1),
(269, '2019_12_31_072252_create_travels_table', 1),
(270, '2019_12_31_090637_create_promotions_table', 1),
(271, '2019_12_31_092838_create_transfers_table', 1),
(272, '2019_12_31_100319_create_warnings_table', 1),
(273, '2019_12_31_103019_create_complaints_table', 1),
(274, '2020_01_02_090837_create_payslip_types_table', 1),
(275, '2020_01_02_093331_create_allowance_options_table', 1),
(276, '2020_01_02_102558_create_loan_options_table', 1),
(277, '2020_01_02_103822_create_deduction_options_table', 1),
(278, '2020_01_02_110828_create_genrate_payslip_options_table', 1),
(279, '2020_01_02_111807_create_set_salaries_table', 1),
(280, '2020_01_03_084302_create_allowances_table', 1),
(281, '2020_01_03_101735_create_commissions_table', 1),
(282, '2020_01_03_105019_create_loans_table', 1),
(283, '2020_01_03_105046_create_saturation_deductions_table', 1),
(284, '2020_01_03_105100_create_other_payments_table', 1),
(285, '2020_01_03_105111_create_overtimes_table', 1),
(286, '2020_01_04_072527_create_pay_slips_table', 1),
(287, '2020_01_06_045425_create_account_lists_table', 1),
(288, '2020_01_06_062213_create_payees_table', 1),
(289, '2020_01_06_070037_create_payers_table', 1),
(290, '2020_01_06_072939_create_income_types_table', 1),
(291, '2020_01_06_073055_create_expense_types_table', 1),
(292, '2020_01_06_085218_create_deposits_table', 1),
(293, '2020_01_06_090709_create_payment_types_table', 1),
(294, '2020_01_06_121442_create_expenses_table', 1),
(295, '2020_01_06_124036_create_transfer_balances_table', 1),
(296, '2020_01_13_084720_create_events_table', 1),
(297, '2020_01_16_041720_create_announcements_table', 1),
(298, '2020_01_16_090747_create_leave_types_table', 1),
(299, '2020_01_16_093256_create_leaves_table', 1),
(300, '2020_01_16_110357_create_meetings_table', 1),
(301, '2020_01_17_051906_create_tickets_table', 1),
(302, '2020_01_17_112647_create_ticket_replies_table', 1),
(303, '2020_01_23_101613_create_meeting_employees_table', 1),
(304, '2020_01_23_123844_create_event_employees_table', 1),
(305, '2020_01_24_062752_create_announcement_employees_table', 1),
(306, '2020_01_27_052503_create_attendance_employees_table', 1),
(307, '2020_02_28_051636_create_time_sheets_table', 1),
(308, '2020_04_21_115823_create_assets_table', 1),
(309, '2020_05_01_122144_create_ducument_uploads_table', 1),
(310, '2020_05_04_070452_create_indicators_table', 1),
(311, '2020_05_05_023742_create_appraisals_table', 1),
(312, '2020_05_05_061241_create_goal_types_table', 1),
(313, '2020_05_05_095926_create_goal_trackings_table', 1),
(314, '2020_05_07_093520_create_company_policies_table', 1),
(315, '2020_05_07_131311_create_training_types_table', 1),
(316, '2020_05_08_023838_create_trainers_table', 1),
(317, '2020_05_08_043039_create_trainings_table', 1),
(318, '2020_05_21_065337_create_permission_tables', 1),
(319, '2020_07_18_065859_create_messageses_table', 1),
(320, '2020_07_22_131715_change_amount_type_size', 1),
(321, '2020_10_07_034726_create_holidays_table', 1),
(322, '2021_02_15_090829_create_managers_table', 1),
(324, '2021_02_17_054018_add_branch_name_to_branches_table', 2),
(326, '2021_02_17_063101_add_employee_details_to_employeess_table', 3),
(331, '2021_02_20_103029_add_manager_details_to_managers_table', 4);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\User', 1),
(2, 'App\\User', 2),
(3, 'App\\User', 3),
(4, 'App\\User', 5);

-- --------------------------------------------------------

--
-- Table structure for table `other_payments`
--

CREATE TABLE `other_payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `overtimes`
--

CREATE TABLE `overtimes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `number_of_days` int(11) NOT NULL,
  `hours` int(11) NOT NULL,
  `rate` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payees`
--

CREATE TABLE `payees` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `payee_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payers`
--

CREATE TABLE `payers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `payer_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment_types`
--

CREATE TABLE `payment_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payslip_types`
--

CREATE TABLE `payslip_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payslip_types`
--

INSERT INTO `payslip_types` (`id`, `name`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'emp', 1, '2021-02-18 00:26:22', '2021-02-18 00:26:22');

-- --------------------------------------------------------

--
-- Table structure for table `pay_slips`
--

CREATE TABLE `pay_slips` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` int(11) NOT NULL,
  `net_payble` int(11) NOT NULL,
  `salary_month` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int(11) NOT NULL,
  `basic_salary` int(11) NOT NULL,
  `allowance` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `commission` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `loan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `saturation_deduction` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `other_payment` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `overtime` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pay_slips`
--

INSERT INTO `pay_slips` (`id`, `employee_id`, `net_payble`, `salary_month`, `status`, `basic_salary`, `allowance`, `commission`, `loan`, `saturation_deduction`, `other_payment`, `overtime`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 1, 25000, '2021-02', 1, 25000, '[]', '[]', '[]', '[]', '[]', '[]', 1, '2021-02-19 01:12:50', '2021-02-19 01:17:37'),
(2, 1, 25000, '2020-02', 0, 25000, '[]', '[]', '[]', '[]', '[]', '[]', 1, '2021-02-19 01:53:14', '2021-02-19 01:53:14'),
(3, 1, 25000, '2021-01', 0, 25000, '[]', '[]', '[]', '[]', '[]', '[]', 1, '2021-02-19 01:53:26', '2021-02-19 01:53:26'),
(4, 1, 24500, '2022-02', 0, 25000, '[]', '[]', '[]', '[{\"id\":1,\"employee_id\":1,\"deduction_option\":1,\"title\":\"a\",\"amount\":500,\"created_by\":1,\"created_at\":\"2021-02-23T10:58:13.000000Z\",\"updated_at\":\"2021-02-23T10:58:13.000000Z\"}]', '[]', '[]', 1, '2021-02-23 06:08:01', '2021-02-23 06:08:01');

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'Manage User', 'web', '2021-02-16 23:57:56', '2021-02-16 23:57:56'),
(2, 'Create User', 'web', '2021-02-16 23:57:56', '2021-02-16 23:57:56'),
(3, 'Edit User', 'web', '2021-02-16 23:57:57', '2021-02-16 23:57:57'),
(4, 'Delete User', 'web', '2021-02-16 23:57:59', '2021-02-16 23:57:59'),
(5, 'Manage Role', 'web', '2021-02-16 23:57:59', '2021-02-16 23:57:59'),
(6, 'Create Role', 'web', '2021-02-16 23:57:59', '2021-02-16 23:57:59'),
(7, 'Delete Role', 'web', '2021-02-16 23:58:00', '2021-02-16 23:58:00'),
(8, 'Edit Role', 'web', '2021-02-16 23:58:00', '2021-02-16 23:58:00'),
(9, 'Manage Award', 'web', '2021-02-16 23:58:01', '2021-02-16 23:58:01'),
(10, 'Create Award', 'web', '2021-02-16 23:58:02', '2021-02-16 23:58:02'),
(11, 'Delete Award', 'web', '2021-02-16 23:58:02', '2021-02-16 23:58:02'),
(12, 'Edit Award', 'web', '2021-02-16 23:58:03', '2021-02-16 23:58:03'),
(13, 'Manage Transfer', 'web', '2021-02-16 23:58:03', '2021-02-16 23:58:03'),
(14, 'Create Transfer', 'web', '2021-02-16 23:58:03', '2021-02-16 23:58:03'),
(15, 'Delete Transfer', 'web', '2021-02-16 23:58:04', '2021-02-16 23:58:04'),
(16, 'Edit Transfer', 'web', '2021-02-16 23:58:04', '2021-02-16 23:58:04'),
(17, 'Manage Resignation', 'web', '2021-02-16 23:58:05', '2021-02-16 23:58:05'),
(18, 'Create Resignation', 'web', '2021-02-16 23:58:05', '2021-02-16 23:58:05'),
(19, 'Edit Resignation', 'web', '2021-02-16 23:58:05', '2021-02-16 23:58:05'),
(20, 'Delete Resignation', 'web', '2021-02-16 23:58:05', '2021-02-16 23:58:05'),
(21, 'Manage Travel', 'web', '2021-02-16 23:58:06', '2021-02-16 23:58:06'),
(22, 'Create Travel', 'web', '2021-02-16 23:58:06', '2021-02-16 23:58:06'),
(23, 'Edit Travel', 'web', '2021-02-16 23:58:06', '2021-02-16 23:58:06'),
(24, 'Delete Travel', 'web', '2021-02-16 23:58:07', '2021-02-16 23:58:07'),
(25, 'Manage Promotion', 'web', '2021-02-16 23:58:07', '2021-02-16 23:58:07'),
(26, 'Create Promotion', 'web', '2021-02-16 23:58:07', '2021-02-16 23:58:07'),
(27, 'Edit Promotion', 'web', '2021-02-16 23:58:09', '2021-02-16 23:58:09'),
(28, 'Delete Promotion', 'web', '2021-02-16 23:58:09', '2021-02-16 23:58:09'),
(29, 'Manage Complaint', 'web', '2021-02-16 23:58:10', '2021-02-16 23:58:10'),
(30, 'Create Complaint', 'web', '2021-02-16 23:58:10', '2021-02-16 23:58:10'),
(31, 'Edit Complaint', 'web', '2021-02-16 23:58:10', '2021-02-16 23:58:10'),
(32, 'Delete Complaint', 'web', '2021-02-16 23:58:11', '2021-02-16 23:58:11'),
(33, 'Manage Warning', 'web', '2021-02-16 23:58:11', '2021-02-16 23:58:11'),
(34, 'Create Warning', 'web', '2021-02-16 23:58:12', '2021-02-16 23:58:12'),
(35, 'Edit Warning', 'web', '2021-02-16 23:58:12', '2021-02-16 23:58:12'),
(36, 'Delete Warning', 'web', '2021-02-16 23:58:14', '2021-02-16 23:58:14'),
(37, 'Manage Termination', 'web', '2021-02-16 23:58:14', '2021-02-16 23:58:14'),
(38, 'Create Termination', 'web', '2021-02-16 23:58:14', '2021-02-16 23:58:14'),
(39, 'Edit Termination', 'web', '2021-02-16 23:58:15', '2021-02-16 23:58:15'),
(40, 'Delete Termination', 'web', '2021-02-16 23:58:15', '2021-02-16 23:58:15'),
(41, 'Manage Department', 'web', '2021-02-16 23:58:16', '2021-02-16 23:58:16'),
(42, 'Create Department', 'web', '2021-02-16 23:58:16', '2021-02-16 23:58:16'),
(43, 'Edit Department', 'web', '2021-02-16 23:58:16', '2021-02-16 23:58:16'),
(44, 'Delete Department', 'web', '2021-02-16 23:58:17', '2021-02-16 23:58:17'),
(45, 'Manage Designation', 'web', '2021-02-16 23:58:17', '2021-02-16 23:58:17'),
(46, 'Create Designation', 'web', '2021-02-16 23:58:17', '2021-02-16 23:58:17'),
(47, 'Edit Designation', 'web', '2021-02-16 23:58:17', '2021-02-16 23:58:17'),
(48, 'Delete Designation', 'web', '2021-02-16 23:58:18', '2021-02-16 23:58:18'),
(49, 'Manage Document Type', 'web', '2021-02-16 23:58:19', '2021-02-16 23:58:19'),
(50, 'Create Document Type', 'web', '2021-02-16 23:58:20', '2021-02-16 23:58:20'),
(51, 'Edit Document Type', 'web', '2021-02-16 23:58:20', '2021-02-16 23:58:20'),
(52, 'Delete Document Type', 'web', '2021-02-16 23:58:21', '2021-02-16 23:58:21'),
(53, 'Manage Branch', 'web', '2021-02-16 23:58:21', '2021-02-16 23:58:21'),
(54, 'Create Branch', 'web', '2021-02-16 23:58:22', '2021-02-16 23:58:22'),
(55, 'Edit Branch', 'web', '2021-02-16 23:58:22', '2021-02-16 23:58:22'),
(56, 'Delete Branch', 'web', '2021-02-16 23:58:23', '2021-02-16 23:58:23'),
(57, 'Manage Award Type', 'web', '2021-02-16 23:58:24', '2021-02-16 23:58:24'),
(58, 'Create Award Type', 'web', '2021-02-16 23:58:25', '2021-02-16 23:58:25'),
(59, 'Edit Award Type', 'web', '2021-02-16 23:58:25', '2021-02-16 23:58:25'),
(60, 'Delete Award Type', 'web', '2021-02-16 23:58:25', '2021-02-16 23:58:25'),
(61, 'Manage Termination Type', 'web', '2021-02-16 23:58:26', '2021-02-16 23:58:26'),
(62, 'Create Termination Type', 'web', '2021-02-16 23:58:27', '2021-02-16 23:58:27'),
(63, 'Edit Termination Type', 'web', '2021-02-16 23:58:27', '2021-02-16 23:58:27'),
(64, 'Delete Termination Type', 'web', '2021-02-16 23:58:27', '2021-02-16 23:58:27'),
(65, 'Manage Employee', 'web', '2021-02-16 23:58:28', '2021-02-16 23:58:28'),
(66, 'Create Employee', 'web', '2021-02-16 23:58:28', '2021-02-16 23:58:28'),
(67, 'Edit Employee', 'web', '2021-02-16 23:58:29', '2021-02-16 23:58:29'),
(68, 'Delete Employee', 'web', '2021-02-16 23:58:29', '2021-02-16 23:58:29'),
(69, 'Show Employee', 'web', '2021-02-16 23:58:30', '2021-02-16 23:58:30'),
(70, 'Manage Payslip Type', 'web', '2021-02-16 23:58:31', '2021-02-16 23:58:31'),
(71, 'Create Payslip Type', 'web', '2021-02-16 23:58:31', '2021-02-16 23:58:31'),
(72, 'Edit Payslip Type', 'web', '2021-02-16 23:58:32', '2021-02-16 23:58:32'),
(73, 'Delete Payslip Type', 'web', '2021-02-16 23:58:33', '2021-02-16 23:58:33'),
(74, 'Manage Allowance Option', 'web', '2021-02-16 23:58:34', '2021-02-16 23:58:34'),
(75, 'Create Allowance Option', 'web', '2021-02-16 23:58:34', '2021-02-16 23:58:34'),
(76, 'Edit Allowance Option', 'web', '2021-02-16 23:58:34', '2021-02-16 23:58:34'),
(77, 'Delete Allowance Option', 'web', '2021-02-16 23:58:35', '2021-02-16 23:58:35'),
(78, 'Manage Loan Option', 'web', '2021-02-16 23:58:36', '2021-02-16 23:58:36'),
(79, 'Create Loan Option', 'web', '2021-02-16 23:58:37', '2021-02-16 23:58:37'),
(80, 'Edit Loan Option', 'web', '2021-02-16 23:58:37', '2021-02-16 23:58:37'),
(81, 'Delete Loan Option', 'web', '2021-02-16 23:58:38', '2021-02-16 23:58:38'),
(82, 'Manage Deduction Option', 'web', '2021-02-16 23:58:38', '2021-02-16 23:58:38'),
(83, 'Create Deduction Option', 'web', '2021-02-16 23:58:38', '2021-02-16 23:58:38'),
(84, 'Edit Deduction Option', 'web', '2021-02-16 23:58:39', '2021-02-16 23:58:39'),
(85, 'Delete Deduction Option', 'web', '2021-02-16 23:58:39', '2021-02-16 23:58:39'),
(86, 'Manage Set Salary', 'web', '2021-02-16 23:58:40', '2021-02-16 23:58:40'),
(87, 'Create Set Salary', 'web', '2021-02-16 23:58:40', '2021-02-16 23:58:40'),
(88, 'Edit Set Salary', 'web', '2021-02-16 23:58:40', '2021-02-16 23:58:40'),
(89, 'Delete Set Salary', 'web', '2021-02-16 23:58:40', '2021-02-16 23:58:40'),
(90, 'Manage Allowance', 'web', '2021-02-16 23:58:41', '2021-02-16 23:58:41'),
(91, 'Create Allowance', 'web', '2021-02-16 23:58:41', '2021-02-16 23:58:41'),
(92, 'Edit Allowance', 'web', '2021-02-16 23:58:41', '2021-02-16 23:58:41'),
(93, 'Delete Allowance', 'web', '2021-02-16 23:58:41', '2021-02-16 23:58:41'),
(94, 'Create Commission', 'web', '2021-02-16 23:58:41', '2021-02-16 23:58:41'),
(95, 'Create Loan', 'web', '2021-02-16 23:58:41', '2021-02-16 23:58:41'),
(96, 'Create Saturation Deduction', 'web', '2021-02-16 23:58:41', '2021-02-16 23:58:41'),
(97, 'Create Other Payment', 'web', '2021-02-16 23:58:41', '2021-02-16 23:58:41'),
(98, 'Create Overtime', 'web', '2021-02-16 23:58:41', '2021-02-16 23:58:41'),
(99, 'Edit Commission', 'web', '2021-02-16 23:58:41', '2021-02-16 23:58:41'),
(100, 'Delete Commission', 'web', '2021-02-16 23:58:41', '2021-02-16 23:58:41'),
(101, 'Edit Loan', 'web', '2021-02-16 23:58:41', '2021-02-16 23:58:41'),
(102, 'Delete Loan', 'web', '2021-02-16 23:58:42', '2021-02-16 23:58:42'),
(103, 'Edit Saturation Deduction', 'web', '2021-02-16 23:58:42', '2021-02-16 23:58:42'),
(104, 'Delete Saturation Deduction', 'web', '2021-02-16 23:58:42', '2021-02-16 23:58:42'),
(105, 'Edit Other Payment', 'web', '2021-02-16 23:58:42', '2021-02-16 23:58:42'),
(106, 'Delete Other Payment', 'web', '2021-02-16 23:58:42', '2021-02-16 23:58:42'),
(107, 'Edit Overtime', 'web', '2021-02-16 23:58:42', '2021-02-16 23:58:42'),
(108, 'Delete Overtime', 'web', '2021-02-16 23:58:42', '2021-02-16 23:58:42'),
(109, 'Manage Pay Slip', 'web', '2021-02-16 23:58:42', '2021-02-16 23:58:42'),
(110, 'Create Pay Slip', 'web', '2021-02-16 23:58:42', '2021-02-16 23:58:42'),
(111, 'Edit Pay Slip', 'web', '2021-02-16 23:58:42', '2021-02-16 23:58:42'),
(112, 'Delete Pay Slip', 'web', '2021-02-16 23:58:42', '2021-02-16 23:58:42'),
(113, 'Manage Account List', 'web', '2021-02-16 23:58:42', '2021-02-16 23:58:42'),
(114, 'Create Account List', 'web', '2021-02-16 23:58:42', '2021-02-16 23:58:42'),
(115, 'Edit Account List', 'web', '2021-02-16 23:58:42', '2021-02-16 23:58:42'),
(116, 'Delete Account List', 'web', '2021-02-16 23:58:42', '2021-02-16 23:58:42'),
(117, 'View Balance Account List', 'web', '2021-02-16 23:58:42', '2021-02-16 23:58:42'),
(118, 'Manage Payee', 'web', '2021-02-16 23:58:42', '2021-02-16 23:58:42'),
(119, 'Create Payee', 'web', '2021-02-16 23:58:42', '2021-02-16 23:58:42'),
(120, 'Edit Payee', 'web', '2021-02-16 23:58:42', '2021-02-16 23:58:42'),
(121, 'Delete Payee', 'web', '2021-02-16 23:58:42', '2021-02-16 23:58:42'),
(122, 'Manage Payer', 'web', '2021-02-16 23:58:42', '2021-02-16 23:58:42'),
(123, 'Create Payer', 'web', '2021-02-16 23:58:42', '2021-02-16 23:58:42'),
(124, 'Edit Payer', 'web', '2021-02-16 23:58:42', '2021-02-16 23:58:42'),
(125, 'Delete Payer', 'web', '2021-02-16 23:58:42', '2021-02-16 23:58:42'),
(126, 'Manage Expense Type', 'web', '2021-02-16 23:58:42', '2021-02-16 23:58:42'),
(127, 'Create Expense Type', 'web', '2021-02-16 23:58:42', '2021-02-16 23:58:42'),
(128, 'Edit Expense Type', 'web', '2021-02-16 23:58:42', '2021-02-16 23:58:42'),
(129, 'Delete Expense Type', 'web', '2021-02-16 23:58:42', '2021-02-16 23:58:42'),
(130, 'Manage Income Type', 'web', '2021-02-16 23:58:42', '2021-02-16 23:58:42'),
(131, 'Edit Income Type', 'web', '2021-02-16 23:58:42', '2021-02-16 23:58:42'),
(132, 'Delete Income Type', 'web', '2021-02-16 23:58:42', '2021-02-16 23:58:42'),
(133, 'Create Income Type', 'web', '2021-02-16 23:58:42', '2021-02-16 23:58:42'),
(134, 'Manage Payment Type', 'web', '2021-02-16 23:58:42', '2021-02-16 23:58:42'),
(135, 'Create Payment Type', 'web', '2021-02-16 23:58:42', '2021-02-16 23:58:42'),
(136, 'Edit Payment Type', 'web', '2021-02-16 23:58:42', '2021-02-16 23:58:42'),
(137, 'Delete Payment Type', 'web', '2021-02-16 23:58:43', '2021-02-16 23:58:43'),
(138, 'Manage Deposit', 'web', '2021-02-16 23:58:43', '2021-02-16 23:58:43'),
(139, 'Create Deposit', 'web', '2021-02-16 23:58:43', '2021-02-16 23:58:43'),
(140, 'Edit Deposit', 'web', '2021-02-16 23:58:43', '2021-02-16 23:58:43'),
(141, 'Delete Deposit', 'web', '2021-02-16 23:58:43', '2021-02-16 23:58:43'),
(142, 'Manage Expense', 'web', '2021-02-16 23:58:43', '2021-02-16 23:58:43'),
(143, 'Create Expense', 'web', '2021-02-16 23:58:43', '2021-02-16 23:58:43'),
(144, 'Edit Expense', 'web', '2021-02-16 23:58:43', '2021-02-16 23:58:43'),
(145, 'Delete Expense', 'web', '2021-02-16 23:58:43', '2021-02-16 23:58:43'),
(146, 'Manage Transfer Balance', 'web', '2021-02-16 23:58:43', '2021-02-16 23:58:43'),
(147, 'Create Transfer Balance', 'web', '2021-02-16 23:58:43', '2021-02-16 23:58:43'),
(148, 'Edit Transfer Balance', 'web', '2021-02-16 23:58:43', '2021-02-16 23:58:43'),
(149, 'Delete Transfer Balance', 'web', '2021-02-16 23:58:43', '2021-02-16 23:58:43'),
(150, 'Manage Event', 'web', '2021-02-16 23:58:43', '2021-02-16 23:58:43'),
(151, 'Create Event', 'web', '2021-02-16 23:58:43', '2021-02-16 23:58:43'),
(152, 'Edit Event', 'web', '2021-02-16 23:58:43', '2021-02-16 23:58:43'),
(153, 'Delete Event', 'web', '2021-02-16 23:58:43', '2021-02-16 23:58:43'),
(154, 'Manage Announcement', 'web', '2021-02-16 23:58:43', '2021-02-16 23:58:43'),
(155, 'Create Announcement', 'web', '2021-02-16 23:58:43', '2021-02-16 23:58:43'),
(156, 'Edit Announcement', 'web', '2021-02-16 23:58:43', '2021-02-16 23:58:43'),
(157, 'Delete Announcement', 'web', '2021-02-16 23:58:43', '2021-02-16 23:58:43'),
(158, 'Manage Leave Type', 'web', '2021-02-16 23:58:43', '2021-02-16 23:58:43'),
(159, 'Create Leave Type', 'web', '2021-02-16 23:58:43', '2021-02-16 23:58:43'),
(160, 'Edit Leave Type', 'web', '2021-02-16 23:58:43', '2021-02-16 23:58:43'),
(161, 'Delete Leave Type', 'web', '2021-02-16 23:58:43', '2021-02-16 23:58:43'),
(162, 'Manage Leave', 'web', '2021-02-16 23:58:43', '2021-02-16 23:58:43'),
(163, 'Create Leave', 'web', '2021-02-16 23:58:43', '2021-02-16 23:58:43'),
(164, 'Edit Leave', 'web', '2021-02-16 23:58:43', '2021-02-16 23:58:43'),
(165, 'Delete Leave', 'web', '2021-02-16 23:58:43', '2021-02-16 23:58:43'),
(166, 'Manage Meeting', 'web', '2021-02-16 23:58:43', '2021-02-16 23:58:43'),
(167, 'Create Meeting', 'web', '2021-02-16 23:58:43', '2021-02-16 23:58:43'),
(168, 'Edit Meeting', 'web', '2021-02-16 23:58:43', '2021-02-16 23:58:43'),
(169, 'Delete Meeting', 'web', '2021-02-16 23:58:43', '2021-02-16 23:58:43'),
(170, 'Manage Ticket', 'web', '2021-02-16 23:58:43', '2021-02-16 23:58:43'),
(171, 'Create Ticket', 'web', '2021-02-16 23:58:43', '2021-02-16 23:58:43'),
(172, 'Edit Ticket', 'web', '2021-02-16 23:58:43', '2021-02-16 23:58:43'),
(173, 'Delete Ticket', 'web', '2021-02-16 23:58:43', '2021-02-16 23:58:43'),
(174, 'Manage Attendance', 'web', '2021-02-16 23:58:43', '2021-02-16 23:58:43'),
(175, 'Create Attendance', 'web', '2021-02-16 23:58:44', '2021-02-16 23:58:44'),
(176, 'Edit Attendance', 'web', '2021-02-16 23:58:44', '2021-02-16 23:58:44'),
(177, 'Delete Attendance', 'web', '2021-02-16 23:58:44', '2021-02-16 23:58:44'),
(178, 'Manage Language', 'web', '2021-02-16 23:58:44', '2021-02-16 23:58:44'),
(179, 'Create Language', 'web', '2021-02-16 23:58:44', '2021-02-16 23:58:44'),
(180, 'Manage Company Settings', 'web', '2021-02-16 23:58:44', '2021-02-16 23:58:44'),
(181, 'Manage TimeSheet', 'web', '2021-02-16 23:58:44', '2021-02-16 23:58:44'),
(182, 'Create TimeSheet', 'web', '2021-02-16 23:58:44', '2021-02-16 23:58:44'),
(183, 'Edit TimeSheet', 'web', '2021-02-16 23:58:44', '2021-02-16 23:58:44'),
(184, 'Delete TimeSheet', 'web', '2021-02-16 23:58:44', '2021-02-16 23:58:44'),
(185, 'Manage Assets', 'web', '2021-02-16 23:58:44', '2021-02-16 23:58:44'),
(186, 'Create Assets', 'web', '2021-02-16 23:58:44', '2021-02-16 23:58:44'),
(187, 'Edit Assets', 'web', '2021-02-16 23:58:44', '2021-02-16 23:58:44'),
(188, 'Delete Assets', 'web', '2021-02-16 23:58:44', '2021-02-16 23:58:44'),
(189, 'Manage Document', 'web', '2021-02-16 23:58:44', '2021-02-16 23:58:44'),
(190, 'Create Document', 'web', '2021-02-16 23:58:44', '2021-02-16 23:58:44'),
(191, 'Edit Document', 'web', '2021-02-16 23:58:44', '2021-02-16 23:58:44'),
(192, 'Delete Document', 'web', '2021-02-16 23:58:44', '2021-02-16 23:58:44'),
(193, 'Manage Employee Profile', 'web', '2021-02-16 23:58:44', '2021-02-16 23:58:44'),
(194, 'Show Employee Profile', 'web', '2021-02-16 23:58:44', '2021-02-16 23:58:44'),
(195, 'Manage Employee Last Login', 'web', '2021-02-16 23:58:44', '2021-02-16 23:58:44'),
(196, 'Manage Indicator', 'web', '2021-02-16 23:58:44', '2021-02-16 23:58:44'),
(197, 'Create Indicator', 'web', '2021-02-16 23:58:44', '2021-02-16 23:58:44'),
(198, 'Edit Indicator', 'web', '2021-02-16 23:58:44', '2021-02-16 23:58:44'),
(199, 'Delete Indicator', 'web', '2021-02-16 23:58:44', '2021-02-16 23:58:44'),
(200, 'Show Indicator', 'web', '2021-02-16 23:58:44', '2021-02-16 23:58:44'),
(201, 'Manage Appraisal', 'web', '2021-02-16 23:58:44', '2021-02-16 23:58:44'),
(202, 'Create Appraisal', 'web', '2021-02-16 23:58:44', '2021-02-16 23:58:44'),
(203, 'Edit Appraisal', 'web', '2021-02-16 23:58:44', '2021-02-16 23:58:44'),
(204, 'Delete Appraisal', 'web', '2021-02-16 23:58:44', '2021-02-16 23:58:44'),
(205, 'Show Appraisal', 'web', '2021-02-16 23:58:44', '2021-02-16 23:58:44'),
(206, 'Manage Goal Type', 'web', '2021-02-16 23:58:44', '2021-02-16 23:58:44'),
(207, 'Create Goal Type', 'web', '2021-02-16 23:58:44', '2021-02-16 23:58:44'),
(208, 'Edit Goal Type', 'web', '2021-02-16 23:58:44', '2021-02-16 23:58:44'),
(209, 'Delete Goal Type', 'web', '2021-02-16 23:58:44', '2021-02-16 23:58:44'),
(210, 'Manage Goal Tracking', 'web', '2021-02-16 23:58:44', '2021-02-16 23:58:44'),
(211, 'Create Goal Tracking', 'web', '2021-02-16 23:58:45', '2021-02-16 23:58:45'),
(212, 'Edit Goal Tracking', 'web', '2021-02-16 23:58:45', '2021-02-16 23:58:45'),
(213, 'Delete Goal Tracking', 'web', '2021-02-16 23:58:45', '2021-02-16 23:58:45'),
(214, 'Manage Company Policy', 'web', '2021-02-16 23:58:45', '2021-02-16 23:58:45'),
(215, 'Create Company Policy', 'web', '2021-02-16 23:58:45', '2021-02-16 23:58:45'),
(216, 'Edit Company Policy', 'web', '2021-02-16 23:58:45', '2021-02-16 23:58:45'),
(217, 'Delete Company Policy', 'web', '2021-02-16 23:58:45', '2021-02-16 23:58:45'),
(218, 'Manage Trainer', 'web', '2021-02-16 23:58:45', '2021-02-16 23:58:45'),
(219, 'Create Trainer', 'web', '2021-02-16 23:58:45', '2021-02-16 23:58:45'),
(220, 'Edit Trainer', 'web', '2021-02-16 23:58:45', '2021-02-16 23:58:45'),
(221, 'Delete Trainer', 'web', '2021-02-16 23:58:45', '2021-02-16 23:58:45'),
(222, 'Show Trainer', 'web', '2021-02-16 23:58:45', '2021-02-16 23:58:45'),
(223, 'Manage Training', 'web', '2021-02-16 23:58:45', '2021-02-16 23:58:45'),
(224, 'Create Training', 'web', '2021-02-16 23:58:45', '2021-02-16 23:58:45'),
(225, 'Edit Training', 'web', '2021-02-16 23:58:45', '2021-02-16 23:58:45'),
(226, 'Delete Training', 'web', '2021-02-16 23:58:45', '2021-02-16 23:58:45'),
(227, 'Show Training', 'web', '2021-02-16 23:58:45', '2021-02-16 23:58:45'),
(228, 'Manage Training Type', 'web', '2021-02-16 23:58:45', '2021-02-16 23:58:45'),
(229, 'Create Training Type', 'web', '2021-02-16 23:58:45', '2021-02-16 23:58:45'),
(230, 'Edit Training Type', 'web', '2021-02-16 23:58:45', '2021-02-16 23:58:45'),
(231, 'Delete Training Type', 'web', '2021-02-16 23:58:45', '2021-02-16 23:58:45'),
(232, 'Manage Report', 'web', '2021-02-16 23:58:45', '2021-02-16 23:58:45'),
(233, 'Manage Holiday', 'web', '2021-02-16 23:58:45', '2021-02-16 23:58:45'),
(234, 'Create Holiday', 'web', '2021-02-16 23:58:45', '2021-02-16 23:58:45'),
(235, 'Edit Holiday', 'web', '2021-02-16 23:58:45', '2021-02-16 23:58:45'),
(236, 'Delete Holiday', 'web', '2021-02-16 23:58:45', '2021-02-16 23:58:45');

-- --------------------------------------------------------

--
-- Table structure for table `promotions`
--

CREATE TABLE `promotions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` int(11) NOT NULL,
  `designation_id` int(11) NOT NULL,
  `promotion_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `promotion_date` date NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `resignations`
--

CREATE TABLE `resignations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` int(11) NOT NULL,
  `notice_date` date NOT NULL,
  `resignation_date` date NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'company', 'web', 0, '2021-02-16 23:58:45', '2021-02-16 23:58:45'),
(2, 'hr', 'web', 1, '2021-02-16 23:59:31', '2021-02-16 23:59:31'),
(3, 'employee', 'web', 1, '2021-02-16 23:59:44', '2021-02-16 23:59:44'),
(4, 'Manager', 'web', 1, '2021-02-22 23:45:12', '2021-02-22 23:45:12');

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
(1, 4),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(7, 1),
(8, 1),
(9, 1),
(9, 2),
(9, 3),
(10, 1),
(10, 2),
(11, 1),
(11, 2),
(12, 1),
(12, 2),
(13, 1),
(13, 2),
(13, 3),
(13, 4),
(14, 1),
(14, 2),
(14, 4),
(15, 1),
(15, 2),
(15, 4),
(16, 1),
(16, 2),
(16, 4),
(17, 1),
(17, 2),
(17, 3),
(17, 4),
(18, 1),
(18, 2),
(18, 3),
(19, 1),
(19, 2),
(19, 3),
(20, 1),
(20, 2),
(20, 3),
(21, 1),
(21, 2),
(21, 3),
(22, 1),
(22, 2),
(23, 1),
(23, 2),
(24, 1),
(24, 2),
(25, 1),
(25, 2),
(25, 3),
(25, 4),
(26, 1),
(26, 2),
(27, 1),
(27, 2),
(28, 1),
(28, 2),
(29, 1),
(29, 2),
(29, 3),
(29, 4),
(30, 1),
(30, 2),
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
(34, 2),
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
(37, 4),
(38, 1),
(38, 2),
(38, 4),
(39, 1),
(39, 2),
(39, 4),
(40, 1),
(40, 2),
(40, 4),
(41, 1),
(41, 2),
(42, 1),
(42, 2),
(43, 1),
(43, 2),
(44, 1),
(44, 2),
(45, 1),
(45, 2),
(46, 1),
(46, 2),
(47, 1),
(47, 2),
(48, 1),
(48, 2),
(49, 1),
(49, 2),
(50, 1),
(50, 2),
(51, 1),
(51, 2),
(52, 1),
(52, 2),
(53, 1),
(53, 2),
(54, 1),
(54, 2),
(55, 1),
(55, 2),
(56, 1),
(56, 2),
(57, 1),
(57, 2),
(58, 1),
(58, 2),
(59, 1),
(59, 2),
(60, 1),
(60, 2),
(61, 1),
(61, 2),
(62, 1),
(62, 2),
(63, 1),
(63, 2),
(64, 1),
(64, 2),
(65, 1),
(65, 2),
(65, 3),
(65, 4),
(66, 1),
(66, 2),
(67, 1),
(67, 2),
(67, 3),
(68, 1),
(68, 2),
(69, 1),
(69, 2),
(69, 3),
(69, 4),
(70, 1),
(70, 2),
(71, 1),
(71, 2),
(72, 1),
(72, 2),
(73, 1),
(73, 2),
(74, 1),
(74, 2),
(75, 1),
(75, 2),
(76, 1),
(76, 2),
(77, 1),
(77, 2),
(78, 1),
(78, 2),
(79, 1),
(79, 2),
(80, 1),
(80, 2),
(81, 1),
(81, 2),
(82, 1),
(82, 2),
(83, 1),
(83, 2),
(84, 1),
(84, 2),
(85, 1),
(85, 2),
(86, 1),
(86, 2),
(87, 1),
(87, 2),
(88, 1),
(88, 2),
(89, 1),
(89, 2),
(90, 1),
(90, 2),
(90, 3),
(91, 1),
(91, 2),
(92, 1),
(92, 2),
(93, 1),
(93, 2),
(94, 1),
(94, 2),
(95, 1),
(95, 2),
(96, 1),
(96, 2),
(97, 1),
(97, 2),
(98, 1),
(98, 2),
(99, 1),
(99, 2),
(100, 1),
(100, 2),
(101, 1),
(101, 2),
(102, 1),
(102, 2),
(103, 1),
(103, 2),
(104, 1),
(104, 2),
(105, 1),
(105, 2),
(106, 1),
(106, 2),
(107, 1),
(107, 2),
(108, 1),
(108, 2),
(109, 1),
(109, 2),
(109, 4),
(110, 1),
(110, 2),
(111, 1),
(111, 2),
(112, 1),
(112, 2),
(113, 1),
(114, 1),
(115, 1),
(116, 1),
(117, 1),
(118, 1),
(119, 1),
(120, 1),
(121, 1),
(122, 1),
(123, 1),
(124, 1),
(125, 1),
(126, 1),
(127, 1),
(128, 1),
(129, 1),
(130, 1),
(131, 1),
(132, 1),
(133, 1),
(134, 1),
(135, 1),
(136, 1),
(137, 1),
(138, 1),
(139, 1),
(140, 1),
(141, 1),
(142, 1),
(143, 1),
(144, 1),
(145, 1),
(146, 1),
(146, 4),
(147, 1),
(148, 1),
(149, 1),
(150, 1),
(150, 2),
(150, 3),
(151, 1),
(151, 2),
(152, 1),
(152, 2),
(153, 1),
(153, 2),
(154, 1),
(154, 2),
(154, 3),
(155, 1),
(155, 2),
(156, 1),
(156, 2),
(157, 1),
(157, 2),
(158, 1),
(158, 2),
(159, 1),
(159, 2),
(160, 1),
(160, 2),
(161, 1),
(161, 2),
(162, 1),
(162, 2),
(162, 3),
(162, 4),
(163, 1),
(163, 2),
(163, 3),
(163, 4),
(164, 1),
(164, 2),
(164, 3),
(164, 4),
(165, 1),
(165, 2),
(165, 3),
(165, 4),
(166, 1),
(166, 2),
(166, 3),
(167, 1),
(167, 2),
(168, 1),
(168, 2),
(169, 1),
(169, 2),
(170, 1),
(170, 2),
(170, 3),
(171, 1),
(171, 2),
(171, 3),
(172, 1),
(172, 2),
(172, 3),
(173, 1),
(173, 2),
(173, 3),
(174, 1),
(174, 2),
(174, 3),
(174, 4),
(175, 1),
(175, 2),
(176, 1),
(176, 2),
(177, 1),
(177, 2),
(178, 1),
(178, 2),
(178, 3),
(180, 1),
(181, 1),
(181, 2),
(181, 3),
(182, 1),
(182, 2),
(182, 3),
(183, 1),
(183, 2),
(183, 3),
(184, 1),
(184, 2),
(184, 3),
(185, 1),
(185, 2),
(186, 1),
(186, 2),
(187, 1),
(187, 2),
(188, 1),
(188, 2),
(189, 1),
(189, 2),
(189, 3),
(190, 1),
(191, 1),
(192, 1),
(193, 1),
(193, 2),
(193, 4),
(194, 1),
(194, 2),
(194, 4),
(195, 1),
(195, 2),
(195, 4),
(196, 1),
(196, 2),
(197, 1),
(197, 2),
(198, 1),
(198, 2),
(199, 1),
(199, 2),
(200, 1),
(200, 2),
(201, 1),
(201, 2),
(201, 4),
(202, 1),
(202, 2),
(203, 1),
(203, 2),
(204, 1),
(204, 2),
(205, 1),
(205, 2),
(205, 4),
(206, 1),
(206, 2),
(207, 1),
(207, 2),
(208, 1),
(208, 2),
(209, 1),
(209, 2),
(210, 1),
(210, 2),
(211, 1),
(211, 2),
(212, 1),
(212, 2),
(213, 1),
(213, 2),
(214, 1),
(214, 2),
(215, 1),
(215, 2),
(216, 1),
(216, 2),
(217, 1),
(217, 2),
(218, 1),
(218, 2),
(219, 1),
(219, 2),
(220, 1),
(220, 2),
(221, 1),
(221, 2),
(222, 1),
(222, 2),
(223, 1),
(223, 2),
(224, 1),
(224, 2),
(225, 1),
(225, 2),
(226, 1),
(226, 2),
(227, 1),
(227, 2),
(228, 1),
(228, 2),
(229, 1),
(229, 2),
(230, 1),
(230, 2),
(231, 1),
(231, 2),
(232, 1),
(232, 4),
(233, 1),
(233, 2),
(233, 3),
(234, 1),
(234, 2),
(235, 1),
(235, 2),
(236, 1),
(236, 2);

-- --------------------------------------------------------

--
-- Table structure for table `saturation_deductions`
--

CREATE TABLE `saturation_deductions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` int(11) NOT NULL,
  `deduction_option` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `saturation_deductions`
--

INSERT INTO `saturation_deductions` (`id`, `employee_id`, `deduction_option`, `title`, `amount`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'a', 500, 1, '2021-02-23 05:28:13', '2021-02-23 05:28:13');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `set_salaries`
--

CREATE TABLE `set_salaries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `terminations`
--

CREATE TABLE `terminations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` int(11) NOT NULL,
  `notice_date` date NOT NULL,
  `termination_date` date NOT NULL,
  `termination_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `termination_types`
--

CREATE TABLE `termination_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `employee_id` int(11) NOT NULL,
  `priority` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `end_date` date NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ticket_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` int(11) NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ticket_replies`
--

CREATE TABLE `ticket_replies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ticket_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` int(11) NOT NULL,
  `is_read` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `time_sheets`
--

CREATE TABLE `time_sheets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` int(11) NOT NULL DEFAULT 0,
  `date` date NOT NULL,
  `hours` double(8,2) NOT NULL DEFAULT 0.00,
  `remark` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `time_sheets`
--

INSERT INTO `time_sheets` (`id`, `employee_id`, `date`, `hours`, `remark`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 3, '2021-02-18', 5.00, '', 1, '2021-02-18 05:11:31', '2021-02-18 05:11:31');

-- --------------------------------------------------------

--
-- Table structure for table `trainers`
--

CREATE TABLE `trainers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `branch` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `firstname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `expertise` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `trainings`
--

CREATE TABLE `trainings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `branch` int(11) NOT NULL,
  `trainer_option` int(11) NOT NULL,
  `training_type` int(11) NOT NULL,
  `trainer` int(11) NOT NULL,
  `training_cost` double(8,2) NOT NULL DEFAULT 0.00,
  `employee` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `performance` int(11) NOT NULL DEFAULT 0,
  `status` int(11) NOT NULL DEFAULT 0,
  `remarks` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `training_types`
--

CREATE TABLE `training_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transfers`
--

CREATE TABLE `transfers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `department_id` int(11) NOT NULL,
  `transfer_date` date NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transfer_balances`
--

CREATE TABLE `transfer_balances` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `from_account_id` int(11) NOT NULL,
  `to_account_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `amount` int(11) NOT NULL,
  `payment_type_id` int(11) NOT NULL,
  `referal_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `travels`
--

CREATE TABLE `travels` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `purpose_of_visit` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `place_of_visit` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active_status` tinyint(1) NOT NULL DEFAULT 0,
  `dark_mode` tinyint(1) NOT NULL DEFAULT 0,
  `messenger_color` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '#2180f3',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lang` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_login` timestamp NULL DEFAULT NULL,
  `is_active` int(11) NOT NULL DEFAULT 1,
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `active_status`, `dark_mode`, `messenger_color`, `email_verified_at`, `password`, `type`, `avatar`, `lang`, `last_login`, `is_active`, `created_by`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'company', 'company@example.com', 0, 0, '#2180f3', NULL, '$2y$10$/eqQrvaS82F2dD8f.t6M6ekSNLJuzOHoATPpjqra/ZhbFpA91pLJW', 'company', '', 'en', '2021-02-22 23:41:26', 1, '0', NULL, '2021-02-16 23:59:31', '2021-02-22 23:41:26'),
(2, 'hr', 'hr@example.com', 0, 0, '#2180f3', NULL, '$2y$10$FCF/5PagK8eD9DeLUmUF.ubu4Hq1iqbYz/nV9/y1M3McO2xJ3HjCG', 'hr', '', 'en', '2021-02-23 03:58:02', 1, '1', NULL, '2021-02-16 23:59:44', '2021-02-23 03:58:02'),
(3, 'Reshmin', 'reshmin.futura@gmail.com', 0, 0, '#2180f3', NULL, '$2y$10$BVrbAXVTqmt/eR3MSWiHHu/h4QODG2iIcNiPIbIHykLn3UwZv4.5W', 'employee', NULL, 'en', '2021-02-19 03:13:58', 1, '1', NULL, '2021-02-18 03:18:33', '2021-02-19 03:13:58'),
(5, 'ZManager', 'reshminsouparnam@gmail.com', 0, 0, '#2180f3', NULL, '$2y$10$fpB4zRglmQ5jRrVz3iS8KeUZdy9MOV5p/T9iVkKK7TesiW9647SS.', 'manager', NULL, 'en', '2021-02-23 03:53:23', 1, '1', NULL, '2021-02-22 23:47:24', '2021-02-23 03:53:23');

-- --------------------------------------------------------

--
-- Table structure for table `warnings`
--

CREATE TABLE `warnings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `warning_to` int(11) NOT NULL,
  `warning_by` int(11) NOT NULL,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `warning_date` date NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account_lists`
--
ALTER TABLE `account_lists`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `allowances`
--
ALTER TABLE `allowances`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `allowance_options`
--
ALTER TABLE `allowance_options`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `announcement_employees`
--
ALTER TABLE `announcement_employees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `appraisals`
--
ALTER TABLE `appraisals`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `assets`
--
ALTER TABLE `assets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `attendance_employees`
--
ALTER TABLE `attendance_employees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `awards`
--
ALTER TABLE `awards`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `award_types`
--
ALTER TABLE `award_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `branches`
--
ALTER TABLE `branches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `commissions`
--
ALTER TABLE `commissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `company_policies`
--
ALTER TABLE `company_policies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `complaints`
--
ALTER TABLE `complaints`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `deduction_options`
--
ALTER TABLE `deduction_options`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `deposits`
--
ALTER TABLE `deposits`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `designations`
--
ALTER TABLE `designations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ducument_uploads`
--
ALTER TABLE `ducument_uploads`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employee_documents`
--
ALTER TABLE `employee_documents`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `event_employees`
--
ALTER TABLE `event_employees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `expense_types`
--
ALTER TABLE `expense_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `favorites`
--
ALTER TABLE `favorites`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `genrate_payslip_options`
--
ALTER TABLE `genrate_payslip_options`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `goal_trackings`
--
ALTER TABLE `goal_trackings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `goal_types`
--
ALTER TABLE `goal_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `holidays`
--
ALTER TABLE `holidays`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `income_types`
--
ALTER TABLE `income_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `indicators`
--
ALTER TABLE `indicators`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `leaves`
--
ALTER TABLE `leaves`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `leave_types`
--
ALTER TABLE `leave_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `loans`
--
ALTER TABLE `loans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `loan_options`
--
ALTER TABLE `loan_options`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `managers`
--
ALTER TABLE `managers`
  ADD PRIMARY KEY (`manager_id`);

--
-- Indexes for table `meetings`
--
ALTER TABLE `meetings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `meeting_employees`
--
ALTER TABLE `meeting_employees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `other_payments`
--
ALTER TABLE `other_payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `overtimes`
--
ALTER TABLE `overtimes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `payees`
--
ALTER TABLE `payees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payers`
--
ALTER TABLE `payers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment_types`
--
ALTER TABLE `payment_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payslip_types`
--
ALTER TABLE `payslip_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pay_slips`
--
ALTER TABLE `pay_slips`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `promotions`
--
ALTER TABLE `promotions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `resignations`
--
ALTER TABLE `resignations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `saturation_deductions`
--
ALTER TABLE `saturation_deductions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `settings_name_created_by_unique` (`name`,`created_by`);

--
-- Indexes for table `set_salaries`
--
ALTER TABLE `set_salaries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `terminations`
--
ALTER TABLE `terminations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `termination_types`
--
ALTER TABLE `termination_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ticket_replies`
--
ALTER TABLE `ticket_replies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `time_sheets`
--
ALTER TABLE `time_sheets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `trainers`
--
ALTER TABLE `trainers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `trainings`
--
ALTER TABLE `trainings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `training_types`
--
ALTER TABLE `training_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transfers`
--
ALTER TABLE `transfers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transfer_balances`
--
ALTER TABLE `transfer_balances`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `travels`
--
ALTER TABLE `travels`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `warnings`
--
ALTER TABLE `warnings`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account_lists`
--
ALTER TABLE `account_lists`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `allowances`
--
ALTER TABLE `allowances`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `allowance_options`
--
ALTER TABLE `allowance_options`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `announcements`
--
ALTER TABLE `announcements`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `announcement_employees`
--
ALTER TABLE `announcement_employees`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `appraisals`
--
ALTER TABLE `appraisals`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `assets`
--
ALTER TABLE `assets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `attendance_employees`
--
ALTER TABLE `attendance_employees`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `awards`
--
ALTER TABLE `awards`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `award_types`
--
ALTER TABLE `award_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `branches`
--
ALTER TABLE `branches`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `commissions`
--
ALTER TABLE `commissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `company_policies`
--
ALTER TABLE `company_policies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `complaints`
--
ALTER TABLE `complaints`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `deduction_options`
--
ALTER TABLE `deduction_options`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `deposits`
--
ALTER TABLE `deposits`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `designations`
--
ALTER TABLE `designations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `documents`
--
ALTER TABLE `documents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `ducument_uploads`
--
ALTER TABLE `ducument_uploads`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `employee_documents`
--
ALTER TABLE `employee_documents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `event_employees`
--
ALTER TABLE `event_employees`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `expense_types`
--
ALTER TABLE `expense_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `genrate_payslip_options`
--
ALTER TABLE `genrate_payslip_options`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `goal_trackings`
--
ALTER TABLE `goal_trackings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `goal_types`
--
ALTER TABLE `goal_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `holidays`
--
ALTER TABLE `holidays`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `income_types`
--
ALTER TABLE `income_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `indicators`
--
ALTER TABLE `indicators`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `leaves`
--
ALTER TABLE `leaves`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `leave_types`
--
ALTER TABLE `leave_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `loans`
--
ALTER TABLE `loans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `loan_options`
--
ALTER TABLE `loan_options`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `managers`
--
ALTER TABLE `managers`
  MODIFY `manager_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `meetings`
--
ALTER TABLE `meetings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `meeting_employees`
--
ALTER TABLE `meeting_employees`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=332;

--
-- AUTO_INCREMENT for table `other_payments`
--
ALTER TABLE `other_payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `overtimes`
--
ALTER TABLE `overtimes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payees`
--
ALTER TABLE `payees`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payers`
--
ALTER TABLE `payers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payment_types`
--
ALTER TABLE `payment_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payslip_types`
--
ALTER TABLE `payslip_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pay_slips`
--
ALTER TABLE `pay_slips`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=237;

--
-- AUTO_INCREMENT for table `promotions`
--
ALTER TABLE `promotions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `resignations`
--
ALTER TABLE `resignations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `saturation_deductions`
--
ALTER TABLE `saturation_deductions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `set_salaries`
--
ALTER TABLE `set_salaries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `terminations`
--
ALTER TABLE `terminations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `termination_types`
--
ALTER TABLE `termination_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ticket_replies`
--
ALTER TABLE `ticket_replies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `time_sheets`
--
ALTER TABLE `time_sheets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `trainers`
--
ALTER TABLE `trainers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `trainings`
--
ALTER TABLE `trainings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `training_types`
--
ALTER TABLE `training_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transfers`
--
ALTER TABLE `transfers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transfer_balances`
--
ALTER TABLE `transfer_balances`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `travels`
--
ALTER TABLE `travels`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `warnings`
--
ALTER TABLE `warnings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

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
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
