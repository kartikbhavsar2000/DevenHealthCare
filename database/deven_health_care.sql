-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 18, 2024 at 03:33 PM
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
-- Database: `deven_health_care`
--

-- --------------------------------------------------------

--
-- Table structure for table `advance_salary`
--

CREATE TABLE `advance_salary` (
  `id` int(11) NOT NULL,
  `staff_id` int(11) DEFAULT NULL,
  `month` text DEFAULT NULL,
  `amount` text DEFAULT NULL,
  `description` text DEFAULT NULL,
  `status` int(11) DEFAULT 0 COMMENT '0=Unpaid, 1=Paid',
  `added_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `advance_salary_history`
--

CREATE TABLE `advance_salary_history` (
  `id` int(11) NOT NULL,
  `adv_id` int(11) DEFAULT NULL,
  `staff_id` int(11) DEFAULT NULL,
  `month` text DEFAULT NULL,
  `amount` text DEFAULT NULL,
  `type` int(11) DEFAULT NULL COMMENT '0=Deducted,1=Added',
  `description` text DEFAULT NULL,
  `is_salary` int(11) NOT NULL DEFAULT 0 COMMENT 'If deducted from salary then 1 else 0.',
  `added_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ambulance`
--

CREATE TABLE `ambulance` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `day_cost` int(20) DEFAULT NULL,
  `night_cost` int(20) DEFAULT NULL,
  `full_cost` int(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ambulance`
--

INSERT INTO `ambulance` (`id`, `name`, `day_cost`, `night_cost`, `full_cost`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Ambulance', 500, 500, 500, '2024-05-21 07:37:16', '2024-06-18 06:59:09', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `area`
--

CREATE TABLE `area` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `city_id` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `area`
--

INSERT INTO `area` (`id`, `name`, `city_id`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Pethapur', 133, 1, '2024-05-24 06:44:35', '2024-05-27 07:48:06', NULL),
(2, 'Sec-1', 133, 1, '2024-05-26 23:31:00', '2024-05-26 23:31:00', NULL),
(3, 'Sec-2', 133, 1, '2024-05-26 23:31:11', '2024-05-26 23:31:11', NULL),
(4, 'Sec-3', 133, 1, '2024-05-26 23:31:27', '2024-05-26 23:31:27', NULL),
(5, 'Ranip', 125, 1, '2024-05-26 23:38:02', '2024-05-26 23:38:02', NULL),
(6, 'Vadaj', 125, 1, '2024-05-26 23:38:11', '2024-05-26 23:38:11', NULL),
(7, 'Usmanpura', 125, 1, '2024-05-26 23:38:21', '2024-05-26 23:38:21', NULL),
(8, 'Chandkheda', 125, 1, '2024-05-26 23:38:33', '2024-05-26 23:38:33', NULL),
(9, 'Vastrapur', 125, 1, '2024-05-26 23:38:49', '2024-05-26 23:38:49', NULL),
(18, 'Himmatnagar', 125, 1, '2024-05-31 10:37:54', '2024-05-31 10:37:54', NULL),
(19, 'Memnagar', 125, 1, '2024-05-31 10:45:10', '2024-05-31 10:45:10', NULL),
(20, 'ZHALOD UDAIPUR', 125, 1, '2024-05-31 10:55:52', '2024-05-31 10:55:52', NULL),
(21, 'Vastra', 125, 1, '2024-05-31 11:02:41', '2024-05-31 11:02:41', NULL),
(22, 'TESTTT', 125, 1, '2024-06-24 08:08:25', '2024-06-24 08:08:25', NULL),
(23, 'dddd', 125, 1, '2024-07-16 00:07:02', '2024-07-16 00:07:11', '2024-07-16 00:07:11'),
(24, 'abcd', 364, 1, '2024-07-16 00:07:32', '2024-07-16 00:07:36', '2024-07-16 00:07:36'),
(25, 'aaa', 515, 1, '2024-07-16 00:10:37', '2024-07-16 00:10:48', '2024-07-16 00:10:48'),
(26, 'bbb', 515, 1, '2024-07-16 00:10:37', '2024-07-16 00:10:51', '2024-07-16 00:10:51');

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `unique_id` text NOT NULL,
  `customer_id` int(11) NOT NULL,
  `booking_type` text NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `is_staff` int(11) NOT NULL DEFAULT 0,
  `is_equipment` int(11) NOT NULL DEFAULT 0,
  `is_doctor` int(11) NOT NULL DEFAULT 0,
  `is_ambulance` int(11) NOT NULL DEFAULT 0,
  `sub_total` text NOT NULL,
  `total` text NOT NULL,
  `pending_payment` text DEFAULT NULL,
  `pause_reason` text DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0 COMMENT '0=pending, 1=assigned',
  `booking_status` int(11) NOT NULL DEFAULT 0 COMMENT '0=Open, 1=Closed, 2=Paused',
  `created_by` int(11) DEFAULT NULL,
  `assigned_by` int(11) DEFAULT NULL,
  `closed_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `unique_id`, `customer_id`, `booking_type`, `start_date`, `end_date`, `is_staff`, `is_equipment`, `is_doctor`, `is_ambulance`, `sub_total`, `total`, `pending_payment`, `pause_reason`, `status`, `booking_status`, `created_by`, `assigned_by`, `closed_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'DHCB202401', 11, 'Patient', '2024-07-12', '2024-07-17', 1, 1, 1, 1, '16700', '16700', '16700', NULL, 1, 0, 1, 1, NULL, '2024-07-18 05:59:14', '2024-07-18 05:59:35', NULL),
(2, 'DHCB202402', 8, 'Patient', '2024-07-16', '2024-07-17', 1, 0, 0, 0, '1000', '1000', '1000', NULL, 1, 0, 1, 1, NULL, '2024-07-18 07:39:26', '2024-07-18 07:39:46', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `booking_assign`
--

CREATE TABLE `booking_assign` (
  `id` int(11) NOT NULL,
  `booking_id` int(11) NOT NULL,
  `booking_detail_id` int(11) DEFAULT NULL,
  `staff_id` int(11) DEFAULT NULL,
  `type` text DEFAULT NULL,
  `shift` int(11) DEFAULT NULL,
  `cost_rate` text DEFAULT NULL,
  `sell_rate` text DEFAULT NULL,
  `date` date DEFAULT NULL,
  `att_date_time` datetime DEFAULT NULL,
  `lat` text DEFAULT NULL,
  `lng` text DEFAULT NULL,
  `att_proof` text DEFAULT NULL,
  `rej_reason` text DEFAULT NULL,
  `att_marked` int(11) NOT NULL DEFAULT 0 COMMENT '0 = No, 1 = Yes',
  `status` int(11) DEFAULT 0 COMMENT '0 = Pending, 1 = Approve, 2 = Rejected',
  `booking_status` int(11) NOT NULL DEFAULT 0 COMMENT '0=Open, 1=Closed',
  `staff_payment` int(11) NOT NULL DEFAULT 0 COMMENT '0=Pending, 1=Done',
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `booking_assign`
--

INSERT INTO `booking_assign` (`id`, `booking_id`, `booking_detail_id`, `staff_id`, `type`, `shift`, `cost_rate`, `sell_rate`, `date`, `att_date_time`, `lat`, `lng`, `att_proof`, `rej_reason`, `att_marked`, `status`, `booking_status`, `staff_payment`, `updated_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 1, 6, 'Nurse', 1, '1000', '1500', '2024-07-12', '2024-07-18 11:30:49', NULL, NULL, NULL, NULL, 1, 1, 0, 1, 1, '2024-07-18 05:59:14', '2024-07-18 06:14:41', NULL),
(2, 1, 1, 6, 'Nurse', 1, '1000', '1500', '2024-07-13', '2024-07-18 11:31:03', NULL, NULL, NULL, NULL, 1, 1, 0, 1, 1, '2024-07-18 05:59:14', '2024-07-18 06:14:41', NULL),
(3, 1, 1, 6, 'Nurse', 1, '1000', '1500', '2024-07-14', '2024-07-18 11:30:35', NULL, NULL, NULL, NULL, 1, 1, 0, 1, 1, '2024-07-18 05:59:14', '2024-07-18 06:14:41', NULL),
(4, 1, 1, 6, 'Nurse', 1, '1000', '1500', '2024-07-15', '2024-07-18 11:30:24', NULL, NULL, NULL, NULL, 1, 1, 0, 1, 1, '2024-07-18 05:59:14', '2024-07-18 06:14:41', NULL),
(5, 1, 1, 6, 'Nurse', 1, '1000', '1500', '2024-07-16', '2024-07-18 11:30:11', NULL, NULL, NULL, NULL, 1, 1, 0, 1, 1, '2024-07-18 05:59:14', '2024-07-18 06:14:41', NULL),
(6, 1, 1, 6, 'Nurse', 1, '1000', '1500', '2024-07-17', '2024-07-18 11:29:58', NULL, NULL, NULL, NULL, 1, 1, 0, 1, 1, '2024-07-18 05:59:14', '2024-07-18 06:14:41', NULL),
(7, 1, 2, 4, 'Caretaker', 1, '1000', '500', '2024-07-12', '2024-07-18 11:30:55', NULL, NULL, NULL, NULL, 1, 1, 0, 1, 1, '2024-07-18 05:59:14', '2024-07-18 06:14:41', NULL),
(8, 1, 2, 4, 'Caretaker', 1, '1000', '500', '2024-07-13', '2024-07-18 11:30:42', NULL, NULL, NULL, NULL, 1, 1, 0, 1, 1, '2024-07-18 05:59:14', '2024-07-18 06:14:41', NULL),
(9, 1, 2, 4, 'Caretaker', 1, '1000', '500', '2024-07-14', '2024-07-18 11:30:30', NULL, NULL, NULL, NULL, 1, 1, 0, 1, 1, '2024-07-18 05:59:14', '2024-07-18 06:14:41', NULL),
(10, 1, 2, 4, 'Caretaker', 1, '1000', '500', '2024-07-15', '2024-07-18 11:30:18', NULL, NULL, NULL, NULL, 1, 1, 0, 1, 1, '2024-07-18 05:59:14', '2024-07-18 06:14:41', NULL),
(11, 1, 2, 4, 'Caretaker', 1, '1000', '500', '2024-07-16', '2024-07-18 11:30:04', NULL, NULL, NULL, NULL, 1, 1, 0, 1, 1, '2024-07-18 05:59:14', '2024-07-18 06:14:41', NULL),
(12, 1, 2, 4, 'Caretaker', 1, '1000', '500', '2024-07-17', '2024-07-18 11:29:50', NULL, NULL, NULL, NULL, 1, 1, 0, 1, 1, '2024-07-18 05:59:14', '2024-07-18 06:14:41', NULL),
(13, 1, 6, 1, 'Doctor', 1, '1500', '1000', '2024-07-13', NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, NULL, '2024-07-18 05:59:14', '2024-07-18 06:01:40', NULL),
(14, 1, 7, 1, 'Doctor', 1, '600', '1000', '2024-07-15', NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, NULL, '2024-07-18 05:59:14', '2024-07-18 06:01:28', NULL),
(15, 2, 9, 10, 'Caretaker', 1, '1000', '500', '2024-07-16', '2024-07-18 13:09:59', NULL, NULL, NULL, NULL, 1, 1, 0, 0, 1, '2024-07-18 07:39:26', '2024-07-18 07:39:59', NULL),
(16, 2, 9, 10, 'Caretaker', 1, '1000', '500', '2024-07-17', '2024-07-18 13:10:05', NULL, NULL, NULL, NULL, 1, 1, 0, 0, 1, '2024-07-18 07:39:26', '2024-07-18 07:40:05', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `booking_details`
--

CREATE TABLE `booking_details` (
  `id` int(11) NOT NULL,
  `booking_id` int(11) NOT NULL,
  `type` int(11) NOT NULL COMMENT '1 = staff, 2 = equipment, 3 = doctor, 4 = ambulance',
  `shift` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `cost_rate` text DEFAULT NULL,
  `sell_rate` text DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `qnt` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `booking_details`
--

INSERT INTO `booking_details` (`id`, `booking_id`, `type`, `shift`, `date`, `cost_rate`, `sell_rate`, `name`, `qnt`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 1, 1, NULL, NULL, '1500', 'Nurse', 6, 0, '2024-07-18 05:59:14', '2024-07-18 05:59:14', NULL),
(2, 1, 1, 1, NULL, NULL, '500', 'Caretaker', 6, 0, '2024-07-18 05:59:14', '2024-07-18 05:59:14', NULL),
(3, 1, 2, NULL, '2024-07-12', '500', '500', 'Patient Bed', 1, 0, '2024-07-18 05:59:14', '2024-07-18 05:59:14', NULL),
(4, 1, 2, NULL, '2024-07-12', '1200', '800', 'Glucose meter', 1, 0, '2024-07-18 05:59:14', '2024-07-18 05:59:14', NULL),
(5, 1, 2, NULL, '2024-07-12', '900', '900', 'Oximeter', 1, 0, '2024-07-18 05:59:14', '2024-07-18 05:59:14', NULL),
(6, 1, 3, 1, '2024-07-13', NULL, '1000', 'Doctor', 1, 0, '2024-07-18 05:59:14', '2024-07-18 05:59:14', NULL),
(7, 1, 3, 1, '2024-07-15', NULL, '1000', 'Doctor', 1, 0, '2024-07-18 05:59:14', '2024-07-18 05:59:14', NULL),
(8, 1, 4, 1, '2024-07-12', NULL, '500', 'Ambulance', 1, 0, '2024-07-18 05:59:14', '2024-07-18 05:59:14', NULL),
(9, 2, 1, 1, NULL, NULL, '500', 'Caretaker', 2, 0, '2024-07-18 07:39:26', '2024-07-18 07:39:26', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `booking_payments`
--

CREATE TABLE `booking_payments` (
  `id` int(11) NOT NULL,
  `booking_id` int(11) DEFAULT NULL,
  `amount` text DEFAULT NULL,
  `date` date DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `added_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `booking_rating`
--

CREATE TABLE `booking_rating` (
  `id` int(11) NOT NULL,
  `booking_id` int(11) DEFAULT NULL,
  `staff_id` int(11) DEFAULT NULL,
  `type` text DEFAULT NULL,
  `rating` int(11) DEFAULT 0,
  `description` text DEFAULT NULL,
  `added_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `state_id` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`id`, `name`, `state_id`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'North and Middle Andaman', 32, 1, NULL, NULL, NULL),
(2, 'South Andaman', 32, 1, NULL, NULL, NULL),
(3, 'Nicobar', 32, 1, NULL, NULL, NULL),
(4, 'Adilabad', 1, 1, NULL, NULL, NULL),
(5, 'Anantapur', 1, 1, NULL, NULL, NULL),
(6, 'Chittoor', 1, 1, NULL, NULL, NULL),
(7, 'East Godavari', 1, 1, NULL, NULL, NULL),
(8, 'Guntur', 1, 1, NULL, NULL, NULL),
(9, 'Hyderabad', 1, 1, NULL, NULL, NULL),
(10, 'Kadapa', 1, 1, NULL, NULL, NULL),
(11, 'Karimnagar', 1, 1, NULL, NULL, NULL),
(12, 'Khammam', 1, 1, NULL, NULL, NULL),
(13, 'Krishna', 1, 1, NULL, NULL, NULL),
(14, 'Kurnool', 1, 1, NULL, NULL, NULL),
(15, 'Mahbubnagar', 1, 1, NULL, NULL, NULL),
(16, 'Medak', 1, 1, NULL, NULL, NULL),
(17, 'Nalgonda', 1, 1, NULL, NULL, NULL),
(18, 'Nellore', 1, 1, NULL, NULL, NULL),
(19, 'Nizamabad', 1, 1, NULL, NULL, NULL),
(20, 'Prakasam', 1, 1, NULL, NULL, NULL),
(21, 'Rangareddi', 1, 1, NULL, NULL, NULL),
(22, 'Srikakulam', 1, 1, NULL, NULL, NULL),
(23, 'Vishakhapatnam', 1, 1, NULL, NULL, NULL),
(24, 'Vizianagaram', 1, 1, NULL, NULL, NULL),
(25, 'Warangal', 1, 1, NULL, NULL, NULL),
(26, 'West Godavari', 1, 1, NULL, NULL, NULL),
(27, 'Anjaw', 3, 1, NULL, NULL, NULL),
(28, 'Changlang', 3, 1, NULL, NULL, NULL),
(29, 'East Kameng', 3, 1, NULL, NULL, NULL),
(30, 'Lohit', 3, 1, NULL, NULL, NULL),
(31, 'Lower Subansiri', 3, 1, NULL, NULL, NULL),
(32, 'Papum Pare', 3, 1, NULL, NULL, NULL),
(33, 'Tirap', 3, 1, NULL, NULL, NULL),
(34, 'Dibang Valley', 3, 1, NULL, NULL, NULL),
(35, 'Upper Subansiri', 3, 1, NULL, NULL, NULL),
(36, 'West Kameng', 3, 1, NULL, NULL, NULL),
(37, 'Barpeta', 2, 1, NULL, NULL, NULL),
(38, 'Bongaigaon', 2, 1, NULL, NULL, NULL),
(39, 'Cachar', 2, 1, NULL, NULL, NULL),
(40, 'Darrang', 2, 1, NULL, NULL, NULL),
(41, 'Dhemaji', 2, 1, NULL, NULL, NULL),
(42, 'Dhubri', 2, 1, NULL, NULL, NULL),
(43, 'Dibrugarh', 2, 1, NULL, NULL, NULL),
(44, 'Goalpara', 2, 1, NULL, NULL, NULL),
(45, 'Golaghat', 2, 1, NULL, NULL, NULL),
(46, 'Hailakandi', 2, 1, NULL, NULL, NULL),
(47, 'Jorhat', 2, 1, NULL, NULL, NULL),
(48, 'Karbi Anglong', 2, 1, NULL, NULL, NULL),
(49, 'Karimganj', 2, 1, NULL, NULL, NULL),
(50, 'Kokrajhar', 2, 1, NULL, NULL, NULL),
(51, 'Lakhimpur', 2, 1, NULL, NULL, NULL),
(52, 'Marigaon', 2, 1, NULL, NULL, NULL),
(53, 'Nagaon', 2, 1, NULL, NULL, NULL),
(54, 'Nalbari', 2, 1, NULL, NULL, NULL),
(55, 'North Cachar Hills', 2, 1, NULL, NULL, NULL),
(56, 'Sibsagar', 2, 1, NULL, NULL, NULL),
(57, 'Sonitpur', 2, 1, NULL, NULL, NULL),
(58, 'Tinsukia', 2, 1, NULL, NULL, NULL),
(59, 'Araria', 4, 1, NULL, NULL, NULL),
(60, 'Aurangabad', 4, 1, NULL, NULL, NULL),
(61, 'Banka', 4, 1, NULL, NULL, NULL),
(62, 'Begusarai', 4, 1, NULL, NULL, NULL),
(63, 'Bhagalpur', 4, 1, NULL, NULL, NULL),
(64, 'Bhojpur', 4, 1, NULL, NULL, NULL),
(65, 'Buxar', 4, 1, NULL, NULL, NULL),
(66, 'Darbhanga', 4, 1, NULL, NULL, NULL),
(67, 'Purba Champaran', 4, 1, NULL, NULL, NULL),
(68, 'Gaya', 4, 1, NULL, NULL, NULL),
(69, 'Gopalganj', 4, 1, NULL, NULL, NULL),
(70, 'Jamui', 4, 1, NULL, NULL, NULL),
(71, 'Jehanabad', 4, 1, NULL, NULL, NULL),
(72, 'Khagaria', 4, 1, NULL, NULL, NULL),
(73, 'Kishanganj', 4, 1, NULL, NULL, NULL),
(74, 'Kaimur', 4, 1, NULL, NULL, NULL),
(75, 'Katihar', 4, 1, NULL, NULL, NULL),
(76, 'Lakhisarai', 4, 1, NULL, NULL, NULL),
(77, 'Madhubani', 4, 1, NULL, NULL, NULL),
(78, 'Munger', 4, 1, NULL, NULL, NULL),
(79, 'Madhepura', 4, 1, NULL, NULL, NULL),
(80, 'Muzaffarpur', 4, 1, NULL, NULL, NULL),
(81, 'Nalanda', 4, 1, NULL, NULL, NULL),
(82, 'Nawada', 4, 1, NULL, NULL, NULL),
(83, 'Patna', 4, 1, NULL, NULL, NULL),
(84, 'Purnia', 4, 1, NULL, NULL, NULL),
(85, 'Rohtas', 4, 1, NULL, NULL, NULL),
(86, 'Saharsa', 4, 1, NULL, NULL, NULL),
(87, 'Samastipur', 4, 1, NULL, NULL, NULL),
(88, 'Sheohar', 4, 1, NULL, NULL, NULL),
(89, 'Sheikhpura', 4, 1, NULL, NULL, NULL),
(90, 'Saran', 4, 1, NULL, NULL, NULL),
(91, 'Sitamarhi', 4, 1, NULL, NULL, NULL),
(92, 'Supaul', 4, 1, NULL, NULL, NULL),
(93, 'Siwan', 4, 1, NULL, NULL, NULL),
(94, 'Vaishali', 4, 1, NULL, NULL, NULL),
(95, 'Pashchim Champaran', 4, 1, NULL, NULL, NULL),
(96, 'Bastar', 36, 1, NULL, NULL, NULL),
(97, 'Bilaspur', 36, 1, NULL, NULL, NULL),
(98, 'Dantewada', 36, 1, NULL, NULL, NULL),
(99, 'Dhamtari', 36, 1, NULL, NULL, NULL),
(100, 'Durg', 36, 1, NULL, NULL, NULL),
(101, 'Jashpur', 36, 1, NULL, NULL, NULL),
(102, 'Janjgir-Champa', 36, 1, NULL, NULL, NULL),
(103, 'Korba', 36, 1, NULL, NULL, NULL),
(104, 'Koriya', 36, 1, NULL, NULL, NULL),
(105, 'Kanker', 36, 1, NULL, NULL, NULL),
(106, 'Kawardha', 36, 1, NULL, NULL, NULL),
(107, 'Mahasamund', 36, 1, NULL, NULL, NULL),
(108, 'Raigarh', 36, 1, NULL, NULL, NULL),
(109, 'Rajnandgaon', 36, 1, NULL, NULL, NULL),
(110, 'Raipur', 36, 1, NULL, NULL, NULL),
(111, 'Surguja', 36, 1, NULL, NULL, NULL),
(112, 'Diu', 29, 1, NULL, NULL, NULL),
(113, 'Daman', 29, 1, NULL, NULL, NULL),
(114, 'Central Delhi', 25, 1, NULL, NULL, NULL),
(115, 'East Delhi', 25, 1, NULL, NULL, NULL),
(116, 'New Delhi', 25, 1, NULL, NULL, NULL),
(117, 'North Delhi', 25, 1, NULL, NULL, NULL),
(118, 'North East Delhi', 25, 1, NULL, NULL, NULL),
(119, 'North West Delhi', 25, 1, NULL, NULL, NULL),
(120, 'South Delhi', 25, 1, NULL, NULL, NULL),
(121, 'South West Delhi', 25, 1, NULL, NULL, NULL),
(122, 'West Delhi', 25, 1, NULL, NULL, NULL),
(123, 'North Goa', 26, 1, NULL, NULL, NULL),
(124, 'South Goa', 26, 1, NULL, NULL, NULL),
(125, 'Ahmedabad', 5, 1, NULL, NULL, NULL),
(126, 'Amreli District', 5, 1, NULL, NULL, NULL),
(127, 'Anand', 5, 1, NULL, NULL, NULL),
(128, 'Banaskantha', 5, 1, NULL, NULL, NULL),
(129, 'Bharuch', 5, 1, NULL, NULL, NULL),
(130, 'Bhavnagar', 5, 1, NULL, NULL, NULL),
(131, 'Dahod', 5, 1, NULL, NULL, NULL),
(132, 'The Dangs', 5, 1, NULL, NULL, NULL),
(133, 'Gandhinagar', 5, 1, NULL, NULL, NULL),
(134, 'Jamnagar', 5, 1, NULL, NULL, NULL),
(135, 'Junagadh', 5, 1, NULL, NULL, NULL),
(136, 'Kutch', 5, 1, NULL, NULL, NULL),
(137, 'Kheda', 5, 1, NULL, NULL, NULL),
(138, 'Mehsana', 5, 1, NULL, NULL, NULL),
(139, 'Narmada', 5, 1, NULL, NULL, NULL),
(140, 'Navsari', 5, 1, NULL, NULL, NULL),
(141, 'Patan', 5, 1, NULL, NULL, NULL),
(142, 'Panchmahal', 5, 1, NULL, NULL, NULL),
(143, 'Porbandar', 5, 1, NULL, NULL, NULL),
(144, 'Rajkot', 5, 1, NULL, NULL, NULL),
(145, 'Sabarkantha', 5, 1, NULL, NULL, NULL),
(146, 'Surendranagar', 5, 1, NULL, NULL, NULL),
(147, 'Surat', 5, 1, NULL, NULL, NULL),
(148, 'Vadodara', 5, 1, NULL, NULL, NULL),
(149, 'Valsad', 5, 1, NULL, NULL, NULL),
(150, 'Ambala', 6, 1, NULL, NULL, NULL),
(151, 'Bhiwani', 6, 1, NULL, NULL, NULL),
(152, 'Faridabad', 6, 1, NULL, NULL, NULL),
(153, 'Fatehabad', 6, 1, NULL, NULL, NULL),
(154, 'Gurgaon', 6, 1, NULL, NULL, NULL),
(155, 'Hissar', 6, 1, NULL, NULL, NULL),
(156, 'Jhajjar', 6, 1, NULL, NULL, NULL),
(157, 'Jind', 6, 1, NULL, NULL, NULL),
(158, 'Karnal', 6, 1, NULL, NULL, NULL),
(159, 'Kaithal', 6, 1, NULL, NULL, NULL),
(160, 'Kurukshetra', 6, 1, NULL, NULL, NULL),
(161, 'Mahendragarh', 6, 1, NULL, NULL, NULL),
(162, 'Mewat', 6, 1, NULL, NULL, NULL),
(163, 'Panchkula', 6, 1, NULL, NULL, NULL),
(164, 'Panipat', 6, 1, NULL, NULL, NULL),
(165, 'Rewari', 6, 1, NULL, NULL, NULL),
(166, 'Rohtak', 6, 1, NULL, NULL, NULL),
(167, 'Sirsa', 6, 1, NULL, NULL, NULL),
(168, 'Sonepat', 6, 1, NULL, NULL, NULL),
(169, 'Yamuna Nagar', 6, 1, NULL, NULL, NULL),
(170, 'Palwal', 6, 1, NULL, NULL, NULL),
(171, 'Bilaspur', 7, 1, NULL, NULL, NULL),
(172, 'Chamba', 7, 1, NULL, NULL, NULL),
(173, 'Hamirpur', 7, 1, NULL, NULL, NULL),
(174, 'Kangra', 7, 1, NULL, NULL, NULL),
(175, 'Kinnaur', 7, 1, NULL, NULL, NULL),
(176, 'Kulu', 7, 1, NULL, NULL, NULL),
(177, 'Lahaul and Spiti', 7, 1, NULL, NULL, NULL),
(178, 'Mandi', 7, 1, NULL, NULL, NULL),
(179, 'Shimla', 7, 1, NULL, NULL, NULL),
(180, 'Sirmaur', 7, 1, NULL, NULL, NULL),
(181, 'Solan', 7, 1, NULL, NULL, NULL),
(182, 'Una', 7, 1, NULL, NULL, NULL),
(183, 'Anantnag', 8, 1, NULL, NULL, NULL),
(184, 'Badgam', 8, 1, NULL, NULL, NULL),
(185, 'Bandipore', 8, 1, NULL, NULL, NULL),
(186, 'Baramula', 8, 1, NULL, NULL, NULL),
(187, 'Doda', 8, 1, NULL, NULL, NULL),
(188, 'Jammu', 8, 1, NULL, NULL, NULL),
(189, 'Kargil', 8, 1, NULL, NULL, NULL),
(190, 'Kathua', 8, 1, NULL, NULL, NULL),
(191, 'Kupwara', 8, 1, NULL, NULL, NULL),
(192, 'Leh', 8, 1, NULL, NULL, NULL),
(193, 'Poonch', 8, 1, NULL, NULL, NULL),
(194, 'Pulwama', 8, 1, NULL, NULL, NULL),
(195, 'Rajauri', 8, 1, NULL, NULL, NULL),
(196, 'Srinagar', 8, 1, NULL, NULL, NULL),
(197, 'Samba', 8, 1, NULL, NULL, NULL),
(198, 'Udhampur', 8, 1, NULL, NULL, NULL),
(199, 'Bokaro', 34, 1, NULL, NULL, NULL),
(200, 'Chatra', 34, 1, NULL, NULL, NULL),
(201, 'Deoghar', 34, 1, NULL, NULL, NULL),
(202, 'Dhanbad', 34, 1, NULL, NULL, NULL),
(203, 'Dumka', 34, 1, NULL, NULL, NULL),
(204, 'Purba Singhbhum', 34, 1, NULL, NULL, NULL),
(205, 'Garhwa', 34, 1, NULL, NULL, NULL),
(206, 'Giridih', 34, 1, NULL, NULL, NULL),
(207, 'Godda', 34, 1, NULL, NULL, NULL),
(208, 'Gumla', 34, 1, NULL, NULL, NULL),
(209, 'Hazaribagh', 34, 1, NULL, NULL, NULL),
(210, 'Koderma', 34, 1, NULL, NULL, NULL),
(211, 'Lohardaga', 34, 1, NULL, NULL, NULL),
(212, 'Pakur', 34, 1, NULL, NULL, NULL),
(213, 'Palamu', 34, 1, NULL, NULL, NULL),
(214, 'Ranchi', 34, 1, NULL, NULL, NULL),
(215, 'Sahibganj', 34, 1, NULL, NULL, NULL),
(216, 'Seraikela and Kharsawan', 34, 1, NULL, NULL, NULL),
(217, 'Pashchim Singhbhum', 34, 1, NULL, NULL, NULL),
(218, 'Ramgarh', 34, 1, NULL, NULL, NULL),
(219, 'Bidar', 9, 1, NULL, NULL, NULL),
(220, 'Belgaum', 9, 1, NULL, NULL, NULL),
(221, 'Bijapur', 9, 1, NULL, NULL, NULL),
(222, 'Bagalkot', 9, 1, NULL, NULL, NULL),
(223, 'Bellary', 9, 1, NULL, NULL, NULL),
(224, 'Bangalore Rural District', 9, 1, NULL, NULL, NULL),
(225, 'Bangalore Urban District', 9, 1, NULL, NULL, NULL),
(226, 'Chamarajnagar', 9, 1, NULL, NULL, NULL),
(227, 'Chikmagalur', 9, 1, NULL, NULL, NULL),
(228, 'Chitradurga', 9, 1, NULL, NULL, NULL),
(229, 'Davanagere', 9, 1, NULL, NULL, NULL),
(230, 'Dharwad', 9, 1, NULL, NULL, NULL),
(231, 'Dakshina Kannada', 9, 1, NULL, NULL, NULL),
(232, 'Gadag', 9, 1, NULL, NULL, NULL),
(233, 'Gulbarga', 9, 1, NULL, NULL, NULL),
(234, 'Hassan', 9, 1, NULL, NULL, NULL),
(235, 'Haveri District', 9, 1, NULL, NULL, NULL),
(236, 'Kodagu', 9, 1, NULL, NULL, NULL),
(237, 'Kolar', 9, 1, NULL, NULL, NULL),
(238, 'Koppal', 9, 1, NULL, NULL, NULL),
(239, 'Mandya', 9, 1, NULL, NULL, NULL),
(240, 'Mysore', 9, 1, NULL, NULL, NULL),
(241, 'Raichur', 9, 1, NULL, NULL, NULL),
(242, 'Shimoga', 9, 1, NULL, NULL, NULL),
(243, 'Tumkur', 9, 1, NULL, NULL, NULL),
(244, 'Udupi', 9, 1, NULL, NULL, NULL),
(245, 'Uttara Kannada', 9, 1, NULL, NULL, NULL),
(246, 'Ramanagara', 9, 1, NULL, NULL, NULL),
(247, 'Chikballapur', 9, 1, NULL, NULL, NULL),
(248, 'Yadagiri', 9, 1, NULL, NULL, NULL),
(249, 'Alappuzha', 10, 1, NULL, NULL, NULL),
(250, 'Ernakulam', 10, 1, NULL, NULL, NULL),
(251, 'Idukki', 10, 1, NULL, NULL, NULL),
(252, 'Kollam', 10, 1, NULL, NULL, NULL),
(253, 'Kannur', 10, 1, NULL, NULL, NULL),
(254, 'Kasaragod', 10, 1, NULL, NULL, NULL),
(255, 'Kottayam', 10, 1, NULL, NULL, NULL),
(256, 'Kozhikode', 10, 1, NULL, NULL, NULL),
(257, 'Malappuram', 10, 1, NULL, NULL, NULL),
(258, 'Palakkad', 10, 1, NULL, NULL, NULL),
(259, 'Pathanamthitta', 10, 1, NULL, NULL, NULL),
(260, 'Thrissur', 10, 1, NULL, NULL, NULL),
(261, 'Thiruvananthapuram', 10, 1, NULL, NULL, NULL),
(262, 'Wayanad', 10, 1, NULL, NULL, NULL),
(263, 'Alirajpur', 11, 1, NULL, NULL, NULL),
(264, 'Anuppur', 11, 1, NULL, NULL, NULL),
(265, 'Ashok Nagar', 11, 1, NULL, NULL, NULL),
(266, 'Balaghat', 11, 1, NULL, NULL, NULL),
(267, 'Barwani', 11, 1, NULL, NULL, NULL),
(268, 'Betul', 11, 1, NULL, NULL, NULL),
(269, 'Bhind', 11, 1, NULL, NULL, NULL),
(270, 'Bhopal', 11, 1, NULL, NULL, NULL),
(271, 'Burhanpur', 11, 1, NULL, NULL, NULL),
(272, 'Chhatarpur', 11, 1, NULL, NULL, NULL),
(273, 'Chhindwara', 11, 1, NULL, NULL, NULL),
(274, 'Damoh', 11, 1, NULL, NULL, NULL),
(275, 'Datia', 11, 1, NULL, NULL, NULL),
(276, 'Dewas', 11, 1, NULL, NULL, NULL),
(277, 'Dhar', 11, 1, NULL, NULL, NULL),
(278, 'Dindori', 11, 1, NULL, NULL, NULL),
(279, 'Guna', 11, 1, NULL, NULL, NULL),
(280, 'Gwalior', 11, 1, NULL, NULL, NULL),
(281, 'Harda', 11, 1, NULL, NULL, NULL),
(282, 'Hoshangabad', 11, 1, NULL, NULL, NULL),
(283, 'Indore', 11, 1, NULL, NULL, NULL),
(284, 'Jabalpur', 11, 1, NULL, NULL, NULL),
(285, 'Jhabua', 11, 1, NULL, NULL, NULL),
(286, 'Katni', 11, 1, NULL, NULL, NULL),
(287, 'Khandwa', 11, 1, NULL, NULL, NULL),
(288, 'Khargone', 11, 1, NULL, NULL, NULL),
(289, 'Mandla', 11, 1, NULL, NULL, NULL),
(290, 'Mandsaur', 11, 1, NULL, NULL, NULL),
(291, 'Morena', 11, 1, NULL, NULL, NULL),
(292, 'Narsinghpur', 11, 1, NULL, NULL, NULL),
(293, 'Neemuch', 11, 1, NULL, NULL, NULL),
(294, 'Panna', 11, 1, NULL, NULL, NULL),
(295, 'Rewa', 11, 1, NULL, NULL, NULL),
(296, 'Rajgarh', 11, 1, NULL, NULL, NULL),
(297, 'Ratlam', 11, 1, NULL, NULL, NULL),
(298, 'Raisen', 11, 1, NULL, NULL, NULL),
(299, 'Sagar', 11, 1, NULL, NULL, NULL),
(300, 'Satna', 11, 1, NULL, NULL, NULL),
(301, 'Sehore', 11, 1, NULL, NULL, NULL),
(302, 'Seoni', 11, 1, NULL, NULL, NULL),
(303, 'Shahdol', 11, 1, NULL, NULL, NULL),
(304, 'Shajapur', 11, 1, NULL, NULL, NULL),
(305, 'Sheopur', 11, 1, NULL, NULL, NULL),
(306, 'Shivpuri', 11, 1, NULL, NULL, NULL),
(307, 'Sidhi', 11, 1, NULL, NULL, NULL),
(308, 'Singrauli', 11, 1, NULL, NULL, NULL),
(309, 'Tikamgarh', 11, 1, NULL, NULL, NULL),
(310, 'Ujjain', 11, 1, NULL, NULL, NULL),
(311, 'Umaria', 11, 1, NULL, NULL, NULL),
(312, 'Vidisha', 11, 1, NULL, NULL, NULL),
(313, 'Ahmednagar', 12, 1, NULL, NULL, NULL),
(314, 'Akola', 12, 1, NULL, NULL, NULL),
(315, 'Amrawati', 12, 1, NULL, NULL, NULL),
(316, 'Aurangabad', 12, 1, NULL, NULL, NULL),
(317, 'Bhandara', 12, 1, NULL, NULL, NULL),
(318, 'Beed', 12, 1, NULL, NULL, NULL),
(319, 'Buldhana', 12, 1, NULL, NULL, NULL),
(320, 'Chandrapur', 12, 1, NULL, NULL, NULL),
(321, 'Dhule', 12, 1, NULL, NULL, NULL),
(322, 'Gadchiroli', 12, 1, NULL, NULL, NULL),
(323, 'Gondiya', 12, 1, NULL, NULL, NULL),
(324, 'Hingoli', 12, 1, NULL, NULL, NULL),
(325, 'Jalgaon', 12, 1, NULL, NULL, NULL),
(326, 'Jalna', 12, 1, NULL, NULL, NULL),
(327, 'Kolhapur', 12, 1, NULL, NULL, NULL),
(328, 'Latur', 12, 1, NULL, NULL, NULL),
(329, 'Mumbai City', 12, 1, NULL, NULL, NULL),
(330, 'Mumbai suburban', 12, 1, NULL, NULL, NULL),
(331, 'Nandurbar', 12, 1, NULL, NULL, NULL),
(332, 'Nanded', 12, 1, NULL, NULL, NULL),
(333, 'Nagpur', 12, 1, NULL, NULL, NULL),
(334, 'Nashik', 12, 1, NULL, NULL, NULL),
(335, 'Osmanabad', 12, 1, NULL, NULL, NULL),
(336, 'Parbhani', 12, 1, NULL, NULL, NULL),
(337, 'Pune', 12, 1, NULL, NULL, NULL),
(338, 'Raigad', 12, 1, NULL, NULL, NULL),
(339, 'Ratnagiri', 12, 1, NULL, NULL, NULL),
(340, 'Sindhudurg', 12, 1, NULL, NULL, NULL),
(341, 'Sangli', 12, 1, NULL, NULL, NULL),
(342, 'Solapur', 12, 1, NULL, NULL, NULL),
(343, 'Satara', 12, 1, NULL, NULL, NULL),
(344, 'Thane', 12, 1, NULL, NULL, NULL),
(345, 'Wardha', 12, 1, NULL, NULL, NULL),
(346, 'Washim', 12, 1, NULL, NULL, NULL),
(347, 'Yavatmal', 12, 1, NULL, NULL, NULL),
(348, 'Bishnupur', 13, 1, NULL, NULL, NULL),
(349, 'Churachandpur', 13, 1, NULL, NULL, NULL),
(350, 'Chandel', 13, 1, NULL, NULL, NULL),
(351, 'Imphal East', 13, 1, NULL, NULL, NULL),
(352, 'Senapati', 13, 1, NULL, NULL, NULL),
(353, 'Tamenglong', 13, 1, NULL, NULL, NULL),
(354, 'Thoubal', 13, 1, NULL, NULL, NULL),
(355, 'Ukhrul', 13, 1, NULL, NULL, NULL),
(356, 'Imphal West', 13, 1, NULL, NULL, NULL),
(357, 'East Garo Hills', 14, 1, NULL, NULL, NULL),
(358, 'East Khasi Hills', 14, 1, NULL, NULL, NULL),
(359, 'Jaintia Hills', 14, 1, NULL, NULL, NULL),
(360, 'Ri-Bhoi', 14, 1, NULL, NULL, NULL),
(361, 'South Garo Hills', 14, 1, NULL, NULL, NULL),
(362, 'West Garo Hills', 14, 1, NULL, NULL, NULL),
(363, 'West Khasi Hills', 14, 1, NULL, NULL, NULL),
(364, 'Aizawl', 15, 1, NULL, '2024-05-27 07:17:01', NULL),
(365, 'Champhai', 15, 1, NULL, NULL, NULL),
(366, 'Kolasib', 15, 1, NULL, NULL, NULL),
(367, 'Lawngtlai', 15, 1, NULL, NULL, NULL),
(368, 'Lunglei', 15, 1, NULL, NULL, NULL),
(369, 'Mamit', 15, 1, NULL, NULL, NULL),
(370, 'Saiha', 15, 1, NULL, NULL, NULL),
(371, 'Serchhip', 15, 1, NULL, NULL, NULL),
(372, 'Dimapur', 16, 1, NULL, NULL, NULL),
(373, 'Kohima', 16, 1, NULL, NULL, NULL),
(374, 'Mokokchung', 16, 1, NULL, NULL, NULL),
(375, 'Mon', 16, 1, NULL, NULL, NULL),
(376, 'Phek', 16, 1, NULL, NULL, NULL),
(377, 'Tuensang', 16, 1, NULL, NULL, NULL),
(378, 'Wokha', 16, 1, NULL, NULL, NULL),
(379, 'Zunheboto', 16, 1, NULL, NULL, NULL),
(380, 'Angul', 17, 1, NULL, NULL, NULL),
(381, 'Boudh', 17, 1, NULL, NULL, NULL),
(382, 'Bhadrak', 17, 1, NULL, NULL, NULL),
(383, 'Bolangir', 17, 1, NULL, NULL, NULL),
(384, 'Bargarh', 17, 1, NULL, NULL, NULL),
(385, 'Baleswar', 17, 1, NULL, NULL, NULL),
(386, 'Cuttack', 17, 1, NULL, NULL, NULL),
(387, 'Debagarh', 17, 1, NULL, NULL, NULL),
(388, 'Dhenkanal', 17, 1, NULL, NULL, NULL),
(389, 'Ganjam', 17, 1, NULL, NULL, NULL),
(390, 'Gajapati', 17, 1, NULL, NULL, NULL),
(391, 'Jharsuguda', 17, 1, NULL, NULL, NULL),
(392, 'Jajapur', 17, 1, NULL, NULL, NULL),
(393, 'Jagatsinghpur', 17, 1, NULL, NULL, NULL),
(394, 'Khordha', 17, 1, NULL, NULL, NULL),
(395, 'Kendujhar', 17, 1, NULL, NULL, NULL),
(396, 'Kalahandi', 17, 1, NULL, NULL, NULL),
(397, 'Kandhamal', 17, 1, NULL, NULL, NULL),
(398, 'Koraput', 17, 1, NULL, NULL, NULL),
(399, 'Kendrapara', 17, 1, NULL, NULL, NULL),
(400, 'Malkangiri', 17, 1, NULL, NULL, NULL),
(401, 'Mayurbhanj', 17, 1, NULL, NULL, NULL),
(402, 'Nabarangpur', 17, 1, NULL, NULL, NULL),
(403, 'Nuapada', 17, 1, NULL, NULL, NULL),
(404, 'Nayagarh', 17, 1, NULL, NULL, NULL),
(405, 'Puri', 17, 1, NULL, NULL, NULL),
(406, 'Rayagada', 17, 1, NULL, NULL, NULL),
(407, 'Sambalpur', 17, 1, NULL, NULL, NULL),
(408, 'Subarnapur', 17, 1, NULL, NULL, NULL),
(409, 'Sundargarh', 17, 1, NULL, NULL, NULL),
(410, 'Karaikal', 27, 1, NULL, NULL, NULL),
(411, 'Mahe', 27, 1, NULL, NULL, NULL),
(412, 'Puducherry', 27, 1, NULL, NULL, NULL),
(413, 'Yanam', 27, 1, NULL, NULL, NULL),
(414, 'Amritsar', 18, 1, NULL, NULL, NULL),
(415, 'Bathinda', 18, 1, NULL, NULL, NULL),
(416, 'Firozpur', 18, 1, NULL, NULL, NULL),
(417, 'Faridkot', 18, 1, NULL, NULL, NULL),
(418, 'Fatehgarh Sahib', 18, 1, NULL, NULL, NULL),
(419, 'Gurdaspur', 18, 1, NULL, NULL, NULL),
(420, 'Hoshiarpur', 18, 1, NULL, NULL, NULL),
(421, 'Jalandhar', 18, 1, NULL, NULL, NULL),
(422, 'Kapurthala', 18, 1, NULL, NULL, NULL),
(423, 'Ludhiana', 18, 1, NULL, NULL, NULL),
(424, 'Mansa', 18, 1, NULL, NULL, NULL),
(425, 'Moga', 18, 1, NULL, NULL, NULL),
(426, 'Mukatsar', 18, 1, NULL, NULL, NULL),
(427, 'Nawan Shehar', 18, 1, NULL, NULL, NULL),
(428, 'Patiala', 18, 1, NULL, NULL, NULL),
(429, 'Rupnagar', 18, 1, NULL, NULL, NULL),
(430, 'Sangrur', 18, 1, NULL, NULL, NULL),
(431, 'Ajmer', 19, 1, NULL, '2024-05-24 06:06:55', NULL),
(432, 'Alwar', 19, 1, NULL, NULL, NULL),
(433, 'Bikaner', 19, 1, NULL, NULL, NULL),
(434, 'Barmer', 19, 1, NULL, NULL, NULL),
(435, 'Banswara', 19, 1, NULL, NULL, NULL),
(436, 'Bharatpur', 19, 1, NULL, NULL, NULL),
(437, 'Baran', 19, 1, NULL, NULL, NULL),
(438, 'Bundi', 19, 1, NULL, NULL, NULL),
(439, 'Bhilwara', 19, 1, NULL, NULL, NULL),
(440, 'Churu', 19, 1, NULL, NULL, NULL),
(441, 'Chittorgarh', 19, 1, NULL, NULL, NULL),
(442, 'Dausa', 19, 1, NULL, NULL, NULL),
(443, 'Dholpur', 19, 1, NULL, NULL, NULL),
(444, 'Dungapur', 19, 1, NULL, NULL, NULL),
(445, 'Ganganagar', 19, 1, NULL, NULL, NULL),
(446, 'Hanumangarh', 19, 1, NULL, NULL, NULL),
(447, 'Juhnjhunun', 19, 1, NULL, NULL, NULL),
(448, 'Jalore', 19, 1, NULL, NULL, NULL),
(449, 'Jodhpur', 19, 1, NULL, NULL, NULL),
(450, 'Jaipur', 19, 1, NULL, NULL, NULL),
(451, 'Jaisalmer', 19, 1, NULL, NULL, NULL),
(452, 'Jhalawar', 19, 1, NULL, NULL, NULL),
(453, 'Karauli', 19, 1, NULL, NULL, NULL),
(454, 'Kota', 19, 1, NULL, NULL, NULL),
(455, 'Nagaur', 19, 1, NULL, NULL, NULL),
(456, 'Pali', 19, 1, NULL, NULL, NULL),
(457, 'Pratapgarh', 19, 1, NULL, NULL, NULL),
(458, 'Rajsamand', 19, 1, NULL, NULL, NULL),
(459, 'Sikar', 19, 1, NULL, NULL, NULL),
(460, 'Sawai Madhopur', 19, 1, NULL, NULL, NULL),
(461, 'Sirohi', 19, 1, NULL, NULL, NULL),
(462, 'Tonk', 19, 1, NULL, NULL, NULL),
(463, 'Udaipur', 19, 1, NULL, NULL, NULL),
(464, 'East Sikkim', 20, 1, NULL, NULL, NULL),
(465, 'North Sikkim', 20, 1, NULL, NULL, NULL),
(466, 'South Sikkim', 20, 1, NULL, NULL, NULL),
(467, 'West Sikkim', 20, 1, NULL, NULL, NULL),
(468, 'Ariyalur', 21, 1, NULL, NULL, NULL),
(469, 'Chennai', 21, 1, NULL, NULL, NULL),
(470, 'Coimbatore', 21, 1, NULL, NULL, NULL),
(471, 'Cuddalore', 21, 1, NULL, NULL, NULL),
(472, 'Dharmapuri', 21, 1, NULL, NULL, NULL),
(473, 'Dindigul', 21, 1, NULL, NULL, NULL),
(474, 'Erode', 21, 1, NULL, NULL, NULL),
(475, 'Kanchipuram', 21, 1, NULL, NULL, NULL),
(476, 'Kanyakumari', 21, 1, NULL, NULL, NULL),
(477, 'Karur', 21, 1, NULL, NULL, NULL),
(478, 'Madurai', 21, 1, NULL, NULL, NULL),
(479, 'Nagapattinam', 21, 1, NULL, NULL, NULL),
(480, 'The Nilgiris', 21, 1, NULL, NULL, NULL),
(481, 'Namakkal', 21, 1, NULL, NULL, NULL),
(482, 'Perambalur', 21, 1, NULL, NULL, NULL),
(483, 'Pudukkottai', 21, 1, NULL, NULL, NULL),
(484, 'Ramanathapuram', 21, 1, NULL, NULL, NULL),
(485, 'Salem', 21, 1, NULL, NULL, NULL),
(486, 'Sivagangai', 21, 1, NULL, NULL, NULL),
(487, 'Tiruppur', 21, 1, NULL, NULL, NULL),
(488, 'Tiruchirappalli', 21, 1, NULL, NULL, NULL),
(489, 'Theni', 21, 1, NULL, NULL, NULL),
(490, 'Tirunelveli', 21, 1, NULL, NULL, NULL),
(491, 'Thanjavur', 21, 1, NULL, NULL, NULL),
(492, 'Thoothukudi', 21, 1, NULL, NULL, NULL),
(493, 'Thiruvallur', 21, 1, NULL, NULL, NULL),
(494, 'Thiruvarur', 21, 1, NULL, NULL, NULL),
(495, 'Tiruvannamalai', 21, 1, NULL, NULL, NULL),
(496, 'Vellore', 21, 1, NULL, NULL, NULL),
(497, 'Villupuram', 21, 1, NULL, NULL, NULL),
(498, 'Dhalai', 22, 1, NULL, NULL, NULL),
(499, 'North Tripura', 22, 1, NULL, NULL, NULL),
(500, 'South Tripura', 22, 1, NULL, NULL, NULL),
(501, 'West Tripura', 22, 1, NULL, NULL, NULL),
(502, 'Almora', 33, 1, NULL, NULL, NULL),
(503, 'Bageshwar', 33, 1, NULL, NULL, NULL),
(504, 'Chamoli', 33, 1, NULL, NULL, NULL),
(505, 'Champawat', 33, 1, NULL, NULL, NULL),
(506, 'Dehradun', 33, 1, NULL, NULL, NULL),
(507, 'Haridwar', 33, 1, NULL, NULL, NULL),
(508, 'Nainital', 33, 1, NULL, NULL, NULL),
(509, 'Pauri Garhwal', 33, 1, NULL, NULL, NULL),
(510, 'Pithoragharh', 33, 1, NULL, NULL, NULL),
(511, 'Rudraprayag', 33, 1, NULL, NULL, NULL),
(512, 'Tehri Garhwal', 33, 1, NULL, NULL, NULL),
(513, 'Udham Singh Nagar', 33, 1, NULL, NULL, NULL),
(514, 'Uttarkashi', 33, 1, NULL, NULL, NULL),
(515, 'Agra', 23, 1, NULL, NULL, NULL),
(516, 'Allahabad', 23, 1, NULL, NULL, NULL),
(517, 'Aligarh', 23, 1, NULL, NULL, NULL),
(518, 'Ambedkar Nagar', 23, 1, NULL, NULL, NULL),
(519, 'Auraiya', 23, 1, NULL, NULL, NULL),
(520, 'Azamgarh', 23, 1, NULL, NULL, NULL),
(521, 'Barabanki', 23, 1, NULL, NULL, NULL),
(522, 'Badaun', 23, 1, NULL, NULL, NULL),
(523, 'Bagpat', 23, 1, NULL, NULL, NULL),
(524, 'Bahraich', 23, 1, NULL, NULL, NULL),
(525, 'Bijnor', 23, 1, NULL, NULL, NULL),
(526, 'Ballia', 23, 1, NULL, NULL, NULL),
(527, 'Banda', 23, 1, NULL, NULL, NULL),
(528, 'Balrampur', 23, 1, NULL, NULL, NULL),
(529, 'Bareilly', 23, 1, NULL, NULL, NULL),
(530, 'Basti', 23, 1, NULL, NULL, NULL),
(531, 'Bulandshahr', 23, 1, NULL, NULL, NULL),
(532, 'Chandauli', 23, 1, NULL, NULL, NULL),
(533, 'Chitrakoot', 23, 1, NULL, NULL, NULL),
(534, 'Deoria', 23, 1, NULL, NULL, NULL),
(535, 'Etah', 23, 1, NULL, NULL, NULL),
(536, 'Kanshiram Nagar', 23, 1, NULL, NULL, NULL),
(537, 'Etawah', 23, 1, NULL, NULL, NULL),
(538, 'Firozabad', 23, 1, NULL, NULL, NULL),
(539, 'Farrukhabad', 23, 1, NULL, NULL, NULL),
(540, 'Fatehpur', 23, 1, NULL, NULL, NULL),
(541, 'Faizabad', 23, 1, NULL, NULL, NULL),
(542, 'Gautam Buddha Nagar', 23, 1, NULL, NULL, NULL),
(543, 'Gonda', 23, 1, NULL, NULL, NULL),
(544, 'Ghazipur', 23, 1, NULL, NULL, NULL),
(545, 'Gorkakhpur', 23, 1, NULL, NULL, NULL),
(546, 'Ghaziabad', 23, 1, NULL, NULL, NULL),
(547, 'Hamirpur', 23, 1, NULL, NULL, NULL),
(548, 'Hardoi', 23, 1, NULL, NULL, NULL),
(549, 'Mahamaya Nagar', 23, 1, NULL, NULL, NULL),
(550, 'Jhansi', 23, 1, NULL, NULL, NULL),
(551, 'Jalaun', 23, 1, NULL, NULL, NULL),
(552, 'Jyotiba Phule Nagar', 23, 1, NULL, NULL, NULL),
(553, 'Jaunpur District', 23, 1, NULL, NULL, NULL),
(554, 'Kanpur Dehat', 23, 1, NULL, NULL, NULL),
(555, 'Kannauj', 23, 1, NULL, NULL, NULL),
(556, 'Kanpur Nagar', 23, 1, NULL, NULL, NULL),
(557, 'Kaushambi', 23, 1, NULL, NULL, NULL),
(558, 'Kushinagar', 23, 1, NULL, NULL, NULL),
(559, 'Lalitpur', 23, 1, NULL, NULL, NULL),
(560, 'Lakhimpur Kheri', 23, 1, NULL, NULL, NULL),
(561, 'Lucknow', 23, 1, NULL, NULL, NULL),
(562, 'Mau', 23, 1, NULL, NULL, NULL),
(563, 'Meerut', 23, 1, NULL, NULL, NULL),
(564, 'Maharajganj', 23, 1, NULL, NULL, NULL),
(565, 'Mahoba', 23, 1, NULL, NULL, NULL),
(566, 'Mirzapur', 23, 1, NULL, NULL, NULL),
(567, 'Moradabad', 23, 1, NULL, NULL, NULL),
(568, 'Mainpuri', 23, 1, NULL, NULL, NULL),
(569, 'Mathura', 23, 1, NULL, NULL, NULL),
(570, 'Muzaffarnagar', 23, 1, NULL, NULL, NULL),
(571, 'Pilibhit', 23, 1, NULL, NULL, NULL),
(572, 'Pratapgarh', 23, 1, NULL, NULL, NULL),
(573, 'Rampur', 23, 1, NULL, NULL, NULL),
(574, 'Rae Bareli', 23, 1, NULL, NULL, NULL),
(575, 'Saharanpur', 23, 1, NULL, NULL, NULL),
(576, 'Sitapur', 23, 1, NULL, NULL, NULL),
(577, 'Shahjahanpur', 23, 1, NULL, NULL, NULL),
(578, 'Sant Kabir Nagar', 23, 1, NULL, NULL, NULL),
(579, 'Siddharthnagar', 23, 1, NULL, NULL, NULL),
(580, 'Sonbhadra', 23, 1, NULL, NULL, NULL),
(581, 'Sant Ravidas Nagar', 23, 1, NULL, NULL, NULL),
(582, 'Sultanpur', 23, 1, NULL, NULL, NULL),
(583, 'Shravasti', 23, 1, NULL, NULL, NULL),
(584, 'Unnao', 23, 1, NULL, NULL, NULL),
(585, 'Varanasi', 23, 1, NULL, NULL, NULL),
(586, 'Birbhum', 24, 1, NULL, NULL, NULL),
(587, 'Bankura', 24, 1, NULL, NULL, NULL),
(588, 'Bardhaman', 24, 1, NULL, NULL, NULL),
(589, 'Darjeeling', 24, 1, NULL, NULL, NULL),
(590, 'Dakshin Dinajpur', 24, 1, NULL, NULL, NULL),
(591, 'Hooghly', 24, 1, NULL, NULL, NULL),
(592, 'Howrah', 24, 1, NULL, NULL, NULL),
(593, 'Jalpaiguri', 24, 1, NULL, NULL, NULL),
(594, 'Cooch Behar', 24, 1, NULL, NULL, NULL),
(595, 'Kolkata', 24, 1, NULL, NULL, NULL),
(596, 'Malda', 24, 1, NULL, NULL, NULL),
(597, 'Midnapore', 24, 1, NULL, NULL, NULL),
(598, 'Murshidabad', 24, 1, NULL, NULL, NULL),
(599, 'Nadia', 24, 1, NULL, NULL, NULL),
(600, 'North 24 Parganas', 24, 1, NULL, NULL, NULL),
(601, 'South 24 Parganas', 24, 1, NULL, NULL, NULL),
(602, 'Purulia', 24, 1, NULL, NULL, NULL),
(603, 'Uttar Dinajpur', 24, 1, NULL, NULL, NULL),
(604, 'TESTINGGGG123', 5, 1, '2024-05-27 07:15:03', '2024-05-27 07:15:42', '2024-05-27 07:15:42');

-- --------------------------------------------------------

--
-- Table structure for table `corporate`
--

CREATE TABLE `corporate` (
  `id` int(11) NOT NULL,
  `name` text DEFAULT NULL,
  `address` text DEFAULT NULL,
  `city` text DEFAULT NULL,
  `state` text DEFAULT NULL,
  `area` text DEFAULT NULL,
  `mobile1` text DEFAULT NULL,
  `mobile2` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `corporate`
--

INSERT INTO `corporate` (`id`, `name`, `address`, `city`, `state`, `area`, `mobile1`, `mobile2`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Test Corporate', '6006 Kunze Heights', '125', '5', '19', '6740206713', '6740206713', '2024-06-04 00:16:06', '2024-06-07 06:28:40', NULL),
(2, 'Gage Odom', 'Ad ut placeat maxim', '125', '5', '7', '2222222222', '1111111111', '2024-06-04 08:03:16', '2024-07-16 01:09:41', '2024-07-16 01:09:41'),
(3, 'Aline Woods', 'Debitis ipsum praese', '133', '5', '1', '1111111111', '2222222222', '2024-06-04 08:04:09', '2024-06-07 06:28:11', NULL),
(4, 'Timothy Rodriquez', 'Omnis aut magni aut dddddddd dwdqwv vqwfvv eqvewv eqdvefs edfeqffef eqfefewffv e', '125', '5', '8', '2222222222', '2222222222', '2024-06-04 08:07:05', '2024-06-14 06:56:51', NULL),
(5, 'Calista Dooley', '6006 Kunze Heights', '125', '5', '18', '6740206713', NULL, '2024-06-12 05:02:23', '2024-07-11 05:57:03', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `doctor`
--

CREATE TABLE `doctor` (
  `id` int(11) NOT NULL,
  `doctor_id` text NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` text DEFAULT NULL,
  `mobile` text DEFAULT NULL,
  `address` text DEFAULT NULL,
  `state` text DEFAULT NULL,
  `city` text DEFAULT NULL,
  `area` text DEFAULT NULL,
  `gender` text DEFAULT NULL,
  `age` text DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `doj` date DEFAULT NULL,
  `experience` text DEFAULT NULL,
  `reference` text DEFAULT NULL,
  `qualification` text DEFAULT NULL,
  `specification` text DEFAULT NULL,
  `bank_name` text DEFAULT NULL,
  `branch` text DEFAULT NULL,
  `ifsc_code` text DEFAULT NULL,
  `acc_no` text DEFAULT NULL,
  `day_cost` int(20) DEFAULT NULL,
  `night_cost` int(20) DEFAULT NULL,
  `full_cost` int(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `doctor`
--

INSERT INTO `doctor` (`id`, `doctor_id`, `name`, `email`, `mobile`, `address`, `state`, `city`, `area`, `gender`, `age`, `dob`, `doj`, `experience`, `reference`, `qualification`, `specification`, `bank_name`, `branch`, `ifsc_code`, `acc_no`, `day_cost`, `night_cost`, `full_cost`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'DHCD202401', 'Dr. Kartik Bhavsar', 'kartikbhavsar1757@gmail.com', '8141614389', '350, Kotfali, Nr. Jain Derasar, Pethapur', '5', '133', '1', 'Male', '25', '2000-03-14', '2024-05-23', '0.5', NULL, NULL, NULL, 'BOB', 'Gandhinagar', 'KBSH123', 'BOB123456', 600, 800, 2000, '2024-05-24 04:40:40', '2024-06-16 23:45:43', NULL),
(2, 'DHCD202402', 'Kartik Bhavsar', 'kartik.budtech@gmail.com', '8141614389', NULL, '5', '133', '2', 'Male', NULL, NULL, NULL, '2', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 500, 500, 1000, '2024-07-11 05:39:30', '2024-07-11 05:39:30', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `equipment`
--

CREATE TABLE `equipment` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `type` text DEFAULT NULL,
  `cost_price` bigint(20) NOT NULL,
  `sell_price` bigint(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `equipment`
--

INSERT INTO `equipment` (`id`, `name`, `type`, `cost_price`, `sell_price`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Anesthesia', 'Sale', 255, 255, '2024-05-14 04:11:04', '2024-06-14 06:07:23', NULL),
(2, 'Bradley Wong', NULL, 260, 775, '2024-05-14 04:21:04', '2024-05-14 04:21:10', '2024-05-14 04:21:10'),
(3, 'Ventilator', 'Rent', 12000, 2000, '2024-05-14 04:24:29', '2024-06-14 06:07:09', NULL),
(4, 'Oximeter', 'Sale', 750, 900, '2024-05-14 04:25:20', '2024-06-14 06:07:02', NULL),
(5, 'Thermometer', 'Sale', 430, 600, '2024-05-14 04:25:40', '2024-06-14 06:06:54', NULL),
(6, 'Glucose meter', 'Sale', 820, 1200, '2024-05-14 04:26:44', '2024-06-14 06:06:40', NULL),
(7, 'Ambulance', NULL, 0, 500, '2024-05-14 04:28:16', '2024-05-21 02:19:11', '2024-05-21 02:19:11'),
(8, 'Test', 'Sale', 255, 400, '2024-06-14 06:05:58', '2024-06-14 06:06:31', '2024-06-14 06:06:31'),
(9, 'Patient Bed', 'Rent', 5000, 500, '2024-06-14 06:07:58', '2024-06-14 06:07:58', NULL);

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
-- Table structure for table `hospital`
--

CREATE TABLE `hospital` (
  `id` int(11) NOT NULL,
  `name` text DEFAULT NULL,
  `address` text DEFAULT NULL,
  `mobile1` text DEFAULT NULL,
  `mobile2` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hospital`
--

INSERT INTO `hospital` (`id`, `name`, `address`, `mobile1`, `mobile2`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Life Care - Stadium', 'Sardar Patel Statue Cir, Nathalal Colony, Naranpura, Ahmedabad, Gujarat 380014', '1234567890', '0987654321', '2024-05-15 06:36:39', '2024-05-31 10:19:23', NULL),
(2, 'Testtttinggggg', '350, Kotfali,jjjjjjjjj', '2222222222', '2222222222', '2024-05-15 06:37:50', '2024-05-15 06:38:09', NULL),
(3, 'Shalby Hospital', 'Haridarshan cross road, Nr. Airport', '1232455612', '1236541236', '2024-05-31 08:02:00', '2024-05-31 08:02:00', NULL);

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
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1);

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
-- Table structure for table `patient`
--

CREATE TABLE `patient` (
  `id` int(11) NOT NULL,
  `patient_id` text NOT NULL,
  `h_type` text DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `age` text DEFAULT NULL,
  `gender` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `area` text DEFAULT NULL,
  `mobile` text DEFAULT NULL,
  `mobile2` text DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `reference` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patient`
--

INSERT INTO `patient` (`id`, `patient_id`, `h_type`, `name`, `dob`, `age`, `gender`, `address`, `state`, `city`, `area`, `mobile`, `mobile2`, `email`, `reference`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'DHCP202401', 'DHC', 'Kartik Bhavsar', '2000-03-14', '25', 'Male', '350, Kotfali', '5', '133', '1', '8141614389', NULL, 'kartik.budtech@gmail.com', NULL, '2024-05-24 04:31:35', '2024-06-06 09:57:47', NULL),
(2, 'DHCP202402', 'Life Care - Stadium', 'Urvashi', NULL, '22', 'Female', 'B-203, Near Ved Arcade', '5', '125', '9', '7853321433', NULL, NULL, NULL, '2024-05-31 11:02:29', '2024-06-06 09:58:10', NULL),
(3, 'DHCP202403', 'Shalby Hospital', 'Rinkal', NULL, '26', 'Female', 'Mig-17, cg road, near stadium', '5', '125', '5', '7521546231', NULL, NULL, NULL, '2024-05-31 11:06:37', '2024-06-06 09:57:57', NULL),
(4, 'DHCP202404', 'Life Care - Stadium', 'Ayush', NULL, '25', 'Male', '303, Green city, Appartment', '5', '125', '6', '6324578950', NULL, 'jinesh.budtech@gmail.com', NULL, '2024-05-31 11:09:12', '2024-06-06 09:56:28', NULL),
(5, 'DHCP202405', 'Shalby Hospital', 'Akashy', NULL, '26', 'Male', '303, The pearl, Baner', '5', '125', '20', '6478965234', NULL, NULL, NULL, '2024-05-31 11:10:24', '2024-06-04 08:02:22', NULL),
(6, 'DHCP202406', 'DHC', 'Abhishek', NULL, '28', 'Male', '303 , Arcade city, River front', '5', '125', '9', '7999200504', NULL, NULL, NULL, '2024-05-31 11:11:43', '2024-06-06 09:56:37', NULL),
(7, 'DHCP202407', 'Shalby Hospital', 'Yugansh', NULL, '52', 'Male', '510, Pride city', '5', '125', '5', '7624049852', NULL, 'veenayadav.budtech@gmail.com', NULL, '2024-05-31 11:14:25', '2024-06-06 09:56:47', NULL),
(8, 'DHCP202408', 'DHC', 'Rai', NULL, '26', 'Female', '789, Utkarsh apartment', '5', '125', '6', '6324857123', NULL, NULL, NULL, '2024-05-31 11:15:41', '2024-06-06 09:57:34', NULL),
(9, 'DHCP202409', 'Life Care - Stadium', 'Rahul', NULL, '45', 'Male', '303 , Arcade city, River front', '5', '125', '8', '7752762000', NULL, NULL, NULL, '2024-05-31 11:16:59', '2024-06-06 09:57:26', NULL),
(10, 'DHCP202410', 'DHC', 'Jenul', NULL, '28', 'Male', '303, The pearl, High Street', '5', '125', '9', '8974562580', NULL, NULL, NULL, '2024-05-31 11:18:32', '2024-06-06 09:57:08', NULL),
(11, 'DHCP202411', 'DHC', 'Rahil', NULL, '58', 'Male', '708, Shail Heights', '5', '125', '19', '8874125896', NULL, NULL, NULL, '2024-05-31 11:19:52', '2024-06-18 07:43:00', NULL),
(12, 'DHCP202412', 'Life Care - Stadium', 'Sajid', NULL, '30', 'Male', '576, Opp. NABARD Tower', '5', '125', '9', '8457963214', '5555555555', 'Mukesh.budtech@gmail.com', NULL, '2024-05-31 11:21:24', '2024-06-23 23:46:25', NULL),
(13, 'DHCP202413', 'DHC', 'Hiren', NULL, NULL, 'Male', '576, Beside MY MY store', '5', '125', '5', '7258964122', NULL, NULL, NULL, '2024-05-31 11:23:29', '2024-07-16 01:00:42', '2024-07-16 01:00:42'),
(14, 'DHCP202414', 'Life Care - Stadium', 'Calista Dooley', '2024-06-11', '13', 'Female', '6006 Kunze Heights', '5', '125', '19', '6740206713', NULL, 'r1@gmail.com', NULL, '2024-06-12 06:47:51', '2024-06-12 06:48:18', '2024-06-12 06:48:18');

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
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `permission` longtext DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `permission`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Super Admin', '[\"dashboard\",\"dhc_dashboard\",\"hsp_dashboard\",\"crp_dashboard\",\"analytics\",\"create_booking\",\"bookings\",\"closed_bookings\",\"assign_bookings\",\"staff_attendance\",\"booking_reviews\",\"active_invoice\",\"closed_invoice\",\"salary\",\"advance_salary\",\"staff\",\"doctors\",\"patients\",\"corporates\",\"users\",\"roles\",\"staff_salary_report\",\"paused_booking_report\",\"hospitals\",\"shifts\",\"equipments\",\"ambulance\",\"staff_type\",\"states\",\"cities\",\"area\"]', '2024-05-10 13:05:29', '2024-07-10 23:54:00', NULL),
(2, 'Admin', '[\"bookings\",\"assign_bookings\",\"staff_attendance\",\"advance_salary\",\"staff\",\"doctors\",\"patients\",\"corporates\",\"hospitals\",\"shifts\",\"equipments\",\"ambulance\",\"staff_type\",\"states\",\"cities\",\"area\"]', '2024-05-10 07:47:32', '2024-06-19 04:07:15', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `shift`
--

CREATE TABLE `shift` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `hours` text NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `shift`
--

INSERT INTO `shift` (`id`, `name`, `hours`, `start_time`, `end_time`, `created_at`, `updated_at`) VALUES
(1, 'Day Shift', '12', '06:00:00', '18:00:00', '2024-05-13 13:02:48', '2024-05-14 00:03:00'),
(2, 'Night Shift', '12', '18:00:00', '06:00:00', '2024-05-13 13:02:48', '2024-05-13 13:02:48'),
(3, 'Full Day Shift', '24', '06:00:00', '06:00:00', '2024-05-13 13:03:39', '2024-05-13 13:03:39');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `id` int(11) NOT NULL,
  `staff_id` text NOT NULL,
  `f_name` varchar(255) DEFAULT NULL,
  `m_name` varchar(255) DEFAULT NULL,
  `l_name` varchar(255) DEFAULT NULL,
  `password` text DEFAULT NULL,
  `type` int(11) DEFAULT NULL,
  `email` text DEFAULT NULL,
  `mobile` text DEFAULT NULL,
  `mobile2` text DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `gender` text DEFAULT NULL,
  `address` text DEFAULT NULL,
  `state` text DEFAULT NULL,
  `city` text DEFAULT NULL,
  `area` text DEFAULT NULL,
  `bank_name` text DEFAULT NULL,
  `branch` text DEFAULT NULL,
  `ifsc_code` text DEFAULT NULL,
  `acc_no` text DEFAULT NULL,
  `day_cost` int(20) DEFAULT NULL,
  `night_cost` int(20) DEFAULT NULL,
  `full_cost` int(20) DEFAULT NULL,
  `age` text DEFAULT NULL,
  `doj` date DEFAULT NULL,
  `experience` text DEFAULT NULL,
  `reference` text DEFAULT NULL,
  `qualification` text DEFAULT NULL,
  `specification` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`id`, `staff_id`, `f_name`, `m_name`, `l_name`, `password`, `type`, `email`, `mobile`, `mobile2`, `dob`, `gender`, `address`, `state`, `city`, `area`, `bank_name`, `branch`, `ifsc_code`, `acc_no`, `day_cost`, `night_cost`, `full_cost`, `age`, `doj`, `experience`, `reference`, `qualification`, `specification`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'DHCS202401', 'Kartik', 'Rajendrakumar', 'Bhavsar', '$2y$12$vQC5JqC6jbPjY2fAAJrJLevoRI3axHCWv10esdV.Cg8fI741C8Eru', 2, 'kartikbhavsar1757@gmail.com', '8141614389', NULL, '2000-03-14', 'Male', '350, Kotfali, Nr. Jain Derasar, Pethapur', '5', '125', '7', 'BOB', 'Gandhinagar', 'KBSH123', 'BOB123456', 500, 500, 1000, '25', '2024-05-24', '2.5', NULL, 'B.E Greduate', NULL, '2024-05-24 04:36:13', '2024-05-31 11:53:01', '2024-05-31 11:53:01'),
(2, 'DHCS202402', 'Hyacinth', 'Lars', 'Samuel', '$2y$12$vQC5JqC6jbPjY2fAAJrJLevoRI3axHCWv10esdV.Cg8fI741C8Eru', 2, 'jery@mailinator.com', '5555555555', NULL, '2024-05-01', 'Male', 'Iste quasi laboriosa', '5', '125', '8', 'Yen Shelton', 'Autem culpa magna na', 'Molestiae ut consect', 'Facilis asperiores c', 600, 600, 1200, '31', '2024-05-27', '2', 'Dolorem ex ut nisi i', 'Qui id exercitation', 'Animi totam velit', '2024-05-27 00:24:35', '2024-05-27 00:50:34', NULL),
(3, 'DHCS202403', 'ANJU', NULL, 'BEN', '$2y$12$vQC5JqC6jbPjY2fAAJrJLevoRI3axHCWv10esdV.Cg8fI741C8Eru', 2, 'anju.budtech@gmail.com', '7990161705', NULL, '2022-05-01', 'Female', '303 Vedanta, Opp. Oosmanpura Garden', '5', '125', '9', 'BOI', 'Ashramraoad', 'BOIB47851', '8444484487871', 1000, 1500, 2000, '26', '2024-05-01', '5', NULL, NULL, NULL, '2024-05-31 10:15:32', '2024-05-31 10:15:49', '2024-05-31 10:15:49'),
(4, 'DHCS202404', 'ANJU', NULL, 'BEN', '$2y$12$vQC5JqC6jbPjY2fAAJrJLevoRI3axHCWv10esdV.Cg8fI741C8Eru', 2, 'anju.budtech@gmail.com', '7990161705', NULL, '2022-05-01', 'Female', '303 Vedanta, Opp. Oosmanpura Garden', '5', '125', '9', 'BOI', 'Ashramraoad', 'BOIB47851', '8444484487871', 1000, 1500, 2000, '26', '2024-05-01', '5', NULL, NULL, NULL, '2024-05-31 10:15:39', '2024-05-31 10:15:39', NULL),
(5, 'DHCS202405', 'JIGNESH', NULL, 'BATOT', '$2y$12$vQC5JqC6jbPjY2fAAJrJLevoRI3axHCWv10esdV.Cg8fI741C8Eru', 1, 'jinesh.budtech@gmail.com', '6367964951', NULL, NULL, 'Male', '303 Vedanta, Opp. Oosmanpura Garden', '5', '125', '5', 'BOI', 'usmanpura', 'BOIB47851', '783584487871', 1500, 1500, 2000, '29', '2024-05-09', '15', NULL, NULL, NULL, '2024-05-31 10:23:20', '2024-06-18 00:26:37', NULL),
(6, 'DHCS202406', 'MUKESH', NULL, 'KUMAR', '$2y$12$vQC5JqC6jbPjY2fAAJrJLevoRI3axHCWv10esdV.Cg8fI741C8Eru', 1, 'Mukesh.budtech@gmail.com', '6367967862', NULL, NULL, 'Male', '303 Vedanta, Opp. Oosmanpura Garden', '5', '125', '6', 'BOI', 'usmanpura', 'BOIB47851', '725484487871', 1000, NULL, 0, '29', '2024-02-01', '15', NULL, NULL, NULL, '2024-05-31 10:25:14', '2024-07-16 05:21:07', NULL),
(7, 'DHCS202407', 'ANISHA', NULL, 'GAMETI', '$2y$12$vQC5JqC6jbPjY2fAAJrJLevoRI3axHCWv10esdV.Cg8fI741C8Eru', 4, NULL, '9638480848', NULL, NULL, 'Female', '303 Vedanta, Opp. Oosmanpura Garden', '5', '125', '18', 'BOI', 'Himmat Nagar', 'BOIB47851', '8444484487871', 1000, 2500, 3000, NULL, '2022-05-01', '7', '10th', NULL, NULL, '2024-05-31 10:42:22', '2024-06-26 05:17:07', NULL),
(8, 'DHCS202408', 'DIPIKABEN', NULL, NULL, '$2y$12$vQC5JqC6jbPjY2fAAJrJLevoRI3axHCWv10esdV.Cg8fI741C8Eru', 4, NULL, '7869686852', NULL, NULL, 'Female', '303 Vedanta, Opp. Oosmanpura Garden', '5', '125', '19', 'BOI', 'Memnagar', 'BOIB47851', '8444484487871', 1000, 1500, 1800, NULL, '2024-03-07', '3', NULL, NULL, NULL, '2024-05-31 10:44:25', '2024-05-31 10:46:14', NULL),
(9, 'DHCS202409', 'VEENA', 'BEN', 'YADAV', '$2y$12$vQC5JqC6jbPjY2fAAJrJLevoRI3axHCWv10esdV.Cg8fI741C8Eru', 4, 'veenayadav.budtech@gmail.com', '7624049852', NULL, NULL, 'Female', '303 Vedanta, Opp. Oosmanpura Garden', '5', '125', '9', 'BOI', 'Memnagar', 'BOIB47851', '8444484487871', 1000, 1000, 2800, NULL, '2024-01-04', '7', NULL, NULL, NULL, '2024-05-31 10:52:57', '2024-06-16 23:37:04', NULL),
(10, 'DHCS202410', 'URMILA', 'BEN', 'DEVI', '$2y$12$vQC5JqC6jbPjY2fAAJrJLevoRI3axHCWv10esdV.Cg8fI741C8Eru', 2, 'urmila.budtech@gmail.com', '6375604700', NULL, NULL, 'Female', '303 Vedanta, Opp. Oosmanpura Garden', '5', '125', '19', 'BOI', 'Memnagar', 'BOIB47851', '8444484487871', 1000, 2100, 2800, NULL, '2024-05-01', '7', NULL, NULL, NULL, '2024-05-31 10:55:15', '2024-05-31 10:55:15', NULL),
(11, 'DHCS202411', 'VARSHA', 'BEN', 'GAMETHI', '$2y$12$vQC5JqC6jbPjY2fAAJrJLevoRI3axHCWv10esdV.Cg8fI741C8Eru', 2, 'Varsha.budtech@gmail.com', '9328233006', NULL, NULL, 'Female', '303 Vedanta, Opp. Oosmanpura Garden', '5', '125', '20', 'BOI', 'Memnagar', 'BOIB47851', '8444484487871', 1000, 2100, 2800, NULL, '2024-01-30', '7', NULL, NULL, NULL, '2024-05-31 10:59:40', '2024-05-31 10:59:40', NULL),
(12, 'DHCS202412', 'tinkal', 'Rajendrakumar', 'bhavsar', '$2y$12$vQC5JqC6jbPjY2fAAJrJLevoRI3axHCWv10esdV.Cg8fI741C8Eru', 4, 'kartikbhavsar1757@gmail.com', '8141614389', NULL, '1967-04-03', 'Female', '350,kotfali, Nr. jain derasar, pethapur', '5', '133', '1', 'BOB', 'Gandhinagar', 'KBSH123', 'BOB123456', 500, 500, 1000, '45', '2024-06-06', '2', NULL, NULL, NULL, '2024-06-07 01:59:44', '2024-06-07 01:59:44', NULL),
(13, 'DHCS202413', 'Hamilton', 'Katelyn', 'Cherokee', '$2y$12$ZQpO5pZA1nJfagFtS5Tt1Ojboj5GD7UG00jbK7y1UbbHfIKPGjNji', 5, 'nimukeku@mailinator.com', '5555555555', NULL, NULL, 'Male', 'Distinctio Similiqu', '5', '125', '18', 'Oleg Olsen', 'Aut similique in mol', 'Officia quisquam dol', 'Ducimus sit sed an', 700, 700, 1400, '23', '2024-06-10', '2', 'Nostrud velit volupt', 'Aut vel iste quaerat', 'Nihil tempor ut labo', '2024-06-17 07:10:36', '2024-06-17 07:10:36', NULL),
(14, 'DHCS202414', 'Cole', 'Hermione', 'Maris', '$2y$12$fnjTvCuEE7w1Z3GPd2zHy.YtfIDxerV3nNgzepXVGXf.dUcxGY8Ku', 1, 'cole@gmail.com', '5555555555', NULL, '1984-06-13', 'Male', 'Qui explicabo Maior', '5', '125', '5', 'Whilemina Haynes', 'Nam est in quas aliq', 'Aut dolor accusamus', 'Sed qui in ipsum con', 500, 500, 1000, '48', '2024-06-01', '2.3', 'Qui rerum elit et e', 'Irure laborum At ni', 'Hic ab eius esse so', '2024-06-19 02:18:34', '2024-06-19 02:18:34', NULL),
(15, 'DHCS202415', 'Channing', 'Nola', NULL, '$2y$12$wNqudhUex6ND/gzfP//dR.HfloZ/lNXvpyG5SmBrVJY6Hw83d/43e', 4, 'tevoci@mailinator.com', '1111111111', '2222222222', NULL, 'Male', 'Voluptate molestiae', '5', '125', '9', 'Maisie Kelly', 'Pariatur Dolor sed', 'Architecto magna rei', 'Libero mollitia accu', 500, 5000, NULL, '33', '2024-06-17', '2', 'Ut proident praesen', 'Aliquip beatae quos', 'Qui consequatur sit', '2024-06-24 01:33:30', '2024-07-16 01:22:19', '2024-07-16 01:22:19'),
(16, 'DHCS202416', 'Veda', 'Quyn', 'Karly', '$2y$12$4CGxvItrZz2q7VD/4u1LAuEaMnc8h8GlwHfpKnP4P3tf.iP06ElR6', 1, 'vimi@mailinator.com', NULL, NULL, NULL, 'Male', 'Qui ea qui repudiand', '5', '125', '8', 'Graiden Drake', 'Qui nihil similique', 'Qui enim esse volup', 'Maxime ad ex ad alia', 1000, 1200, 1500, '32', '2024-07-12', '64', 'Et rem ea ad eum ani', 'Fugiat expedita et p', 'Quibusdam fugiat mo', '2024-07-12 04:25:30', '2024-07-12 07:28:59', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `staff_documents`
--

CREATE TABLE `staff_documents` (
  `id` int(11) NOT NULL,
  `staff_id` int(11) DEFAULT NULL,
  `name` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staff_documents`
--

INSERT INTO `staff_documents` (`id`, `staff_id`, `name`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 15, '1719212610_0.png', '2024-06-24 01:33:30', '2024-06-24 02:15:57', '2024-06-24 02:15:57'),
(2, 15, '1719212610_1.png', '2024-06-24 01:33:30', '2024-06-24 02:16:01', '2024-06-24 02:16:01'),
(3, 15, '1719212610_2.png', '2024-06-24 01:33:30', '2024-06-24 02:16:05', '2024-06-24 02:16:05'),
(4, 15, '1719212811_0.png', '2024-06-24 01:36:51', '2024-06-24 02:16:08', '2024-06-24 02:16:08'),
(5, 15, '1719213394_0.png', '2024-06-24 01:46:34', '2024-06-24 02:15:45', '2024-06-24 02:15:45'),
(6, 15, '1719213412_0.png', '2024-06-24 01:46:52', '2024-06-24 02:16:12', '2024-06-24 02:16:12'),
(7, 15, '1719213728_0.jpg', '2024-06-24 01:52:08', '2024-06-24 02:16:16', '2024-06-24 02:16:16'),
(8, 15, '1719215282_0.png', '2024-06-24 02:18:02', '2024-07-16 01:22:19', '2024-07-16 01:22:19'),
(9, 15, '1719215304_0.jpg', '2024-06-24 02:18:24', '2024-07-16 01:22:19', '2024-07-16 01:22:19'),
(10, 15, '1719220029_0.pdf', '2024-06-24 03:37:10', '2024-07-16 01:22:19', '2024-07-16 01:22:19');

-- --------------------------------------------------------

--
-- Table structure for table `staff_type`
--

CREATE TABLE `staff_type` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staff_type`
--

INSERT INTO `staff_type` (`id`, `title`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Nurse', '2024-05-20 02:35:05', '2024-06-19 04:23:42', NULL),
(2, 'Caretaker', '2024-05-20 02:35:14', '2024-05-20 07:19:09', NULL),
(3, 'Test', '2024-05-21 06:38:57', '2024-05-21 06:39:18', '2024-05-21 06:39:18'),
(4, 'Baby Care', '2024-05-31 10:27:09', '2024-05-31 10:27:09', NULL),
(5, 'Physiotherapist', '2024-06-14 00:34:03', '2024-06-14 06:01:12', NULL),
(6, 'Test123', '2024-06-14 05:27:52', '2024-06-14 05:30:31', '2024-06-14 05:30:31'),
(7, 'Testt', '2024-06-14 05:59:45', '2024-06-16 23:06:46', '2024-06-16 23:06:46'),
(8, 'Testt', '2024-06-14 06:00:57', '2024-06-16 23:06:42', '2024-06-16 23:06:42');

-- --------------------------------------------------------

--
-- Table structure for table `states`
--

CREATE TABLE `states` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `states`
--

INSERT INTO `states` (`id`, `name`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Andhra Pradesh', 0, NULL, '2024-05-27 06:43:24', NULL),
(2, 'ASSAM', 0, NULL, NULL, NULL),
(3, 'ARUNACHAL PRADESH', 0, NULL, NULL, NULL),
(4, 'BIHAR', 0, NULL, NULL, NULL),
(5, 'GUJARAT', 1, NULL, '2024-05-31 06:12:30', NULL),
(6, 'HARYANA', 0, NULL, NULL, NULL),
(7, 'HIMACHAL PRADESH', 0, NULL, NULL, NULL),
(8, 'JAMMU & KASHMIR', 0, NULL, NULL, NULL),
(9, 'KARNATAKA', 0, NULL, NULL, NULL),
(10, 'KERALA', 0, NULL, NULL, NULL),
(11, 'MADHYA PRADESH', 1, NULL, NULL, NULL),
(12, 'MAHARASHTRA', 1, NULL, NULL, NULL),
(13, 'MANIPUR', 0, NULL, NULL, NULL),
(14, 'MEGHALAYA', 0, NULL, NULL, NULL),
(15, 'MIZORAM', 0, NULL, NULL, NULL),
(16, 'NAGALAND', 0, NULL, NULL, NULL),
(17, 'ORISSA', 0, NULL, NULL, NULL),
(18, 'PUNJAB', 0, NULL, NULL, NULL),
(19, 'RAJASTHAN', 1, NULL, NULL, NULL),
(20, 'SIKKIM', 0, NULL, NULL, NULL),
(21, 'TAMIL NADU', 0, NULL, NULL, NULL),
(22, 'TRIPURA', 0, NULL, NULL, NULL),
(23, 'UTTAR PRADESH', 0, NULL, NULL, NULL),
(24, 'WEST BENGAL', 0, NULL, NULL, NULL),
(25, 'DELHI', 0, NULL, NULL, NULL),
(26, 'GOA', 0, NULL, NULL, NULL),
(27, 'PONDICHERY', 0, NULL, NULL, NULL),
(28, 'LAKSHDWEEP', 0, NULL, NULL, NULL),
(29, 'DAMAN & DIU', 0, NULL, NULL, NULL),
(30, 'DADRA & NAGAR', 0, NULL, NULL, NULL),
(31, 'CHANDIGARH', 0, NULL, NULL, NULL),
(32, 'Andaman & Nicobar', 0, NULL, '2024-05-27 06:42:54', NULL),
(33, 'UTTARANCHAL', 0, NULL, NULL, NULL),
(34, 'JHARKHAND', 0, NULL, NULL, NULL),
(35, 'CHATTISGARH', 0, NULL, NULL, NULL),
(36, 'TEST', 0, '2024-05-27 06:37:12', '2024-05-27 06:41:20', '2024-05-27 06:41:20'),
(37, 'Test2', 0, '2024-05-27 06:37:46', '2024-05-27 06:41:28', '2024-05-27 06:41:28'),
(38, 'Test3', 0, '2024-05-27 06:38:10', '2024-05-27 06:41:35', '2024-05-27 06:41:35');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role_id` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `role_id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'DHC', 'superadmin@gmail.com', NULL, '$2y$12$rXd32Rd/H29ZzQAWhW.Vie7ZvE.RlqTBs36dGdSfgdYaV.0egBPeq', NULL, '2024-05-10 12:18:33', '2024-05-10 12:18:33', NULL),
(2, 2, 'Kartik Bhavsar', 'kartik.budtech@gmail.com', NULL, '$2y$12$rXd32Rd/H29ZzQAWhW.Vie7ZvE.RlqTBs36dGdSfgdYaV.0egBPeq', NULL, '2024-05-10 07:48:09', '2024-05-17 05:59:17', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `advance_salary`
--
ALTER TABLE `advance_salary`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `advance_salary_history`
--
ALTER TABLE `advance_salary_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ambulance`
--
ALTER TABLE `ambulance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `area`
--
ALTER TABLE `area`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `booking_assign`
--
ALTER TABLE `booking_assign`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `booking_details`
--
ALTER TABLE `booking_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `booking_payments`
--
ALTER TABLE `booking_payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `booking_rating`
--
ALTER TABLE `booking_rating`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `state_id` (`state_id`);

--
-- Indexes for table `corporate`
--
ALTER TABLE `corporate`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `doctor`
--
ALTER TABLE `doctor`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `equipment`
--
ALTER TABLE `equipment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `hospital`
--
ALTER TABLE `hospital`
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
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `patient`
--
ALTER TABLE `patient`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `shift`
--
ALTER TABLE `shift`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `staff_documents`
--
ALTER TABLE `staff_documents`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `staff_type`
--
ALTER TABLE `staff_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `states`
--
ALTER TABLE `states`
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
-- AUTO_INCREMENT for table `advance_salary`
--
ALTER TABLE `advance_salary`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `advance_salary_history`
--
ALTER TABLE `advance_salary_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ambulance`
--
ALTER TABLE `ambulance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `area`
--
ALTER TABLE `area`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `booking_assign`
--
ALTER TABLE `booking_assign`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `booking_details`
--
ALTER TABLE `booking_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `booking_payments`
--
ALTER TABLE `booking_payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `booking_rating`
--
ALTER TABLE `booking_rating`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=605;

--
-- AUTO_INCREMENT for table `corporate`
--
ALTER TABLE `corporate`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `doctor`
--
ALTER TABLE `doctor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `equipment`
--
ALTER TABLE `equipment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hospital`
--
ALTER TABLE `hospital`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `patient`
--
ALTER TABLE `patient`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `shift`
--
ALTER TABLE `shift`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `staff_documents`
--
ALTER TABLE `staff_documents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `staff_type`
--
ALTER TABLE `staff_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `states`
--
ALTER TABLE `states`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
