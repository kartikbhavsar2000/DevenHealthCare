-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 14, 2024 at 08:38 AM
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

--
-- Dumping data for table `advance_salary`
--

INSERT INTO `advance_salary` (`id`, `staff_id`, `month`, `amount`, `description`, `status`, `added_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 97, 'Sep 2024', '0', 'Advance', 0, 1, 1, '2024-09-04 04:12:37', '2024-09-04 04:13:11', NULL);

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

--
-- Dumping data for table `advance_salary_history`
--

INSERT INTO `advance_salary_history` (`id`, `adv_id`, `staff_id`, `month`, `amount`, `type`, `description`, `is_salary`, `added_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 97, 'Sep 2024', '500', 1, 'Advance', 0, 1, '2024-09-04 04:12:37', '2024-09-04 04:12:37', NULL),
(2, 1, 97, 'Sep 2024', '500', 0, 'Deducted from the salary.', 1, 1, '2024-09-04 04:13:11', '2024-09-04 04:13:11', NULL);

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
(1, 'Ambulance', 0, 0, 0, '2024-05-21 07:37:16', '2024-05-21 02:37:30', NULL);

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
(1, 'PALDI', 125, 1, '2024-06-18 15:01:20', '2024-06-18 15:01:20', NULL),
(2, 'VASTRAPUR', 125, 1, '2024-06-18 15:01:36', '2024-06-18 15:01:36', NULL),
(3, 'BOPAL', 125, 1, '2024-06-18 15:01:49', '2024-06-18 15:01:49', NULL),
(4, 'SOLA', 125, 1, '2024-06-18 15:15:57', '2024-06-18 15:15:57', NULL),
(5, 'SHAMSHABAD', 515, 1, '2024-06-18 17:56:17', '2024-06-18 17:56:17', NULL),
(6, 'VAISHNODEVI', 125, 1, '2024-06-18 18:15:10', '2024-06-18 18:15:10', NULL),
(7, 'SASTRINAGAR', 431, 1, '2024-06-18 18:21:20', '2024-06-18 18:21:20', NULL),
(8, 'Jodhpur', 125, 1, '2024-06-24 20:31:06', '2024-06-24 20:34:56', '2024-06-24 20:34:56'),
(9, 'TEST', 125, 1, '2024-06-24 20:32:08', '2024-06-24 20:35:01', '2024-06-24 20:35:01'),
(10, 'CHANKYAPURI', 125, 1, '2024-07-04 17:36:13', '2024-07-04 17:36:13', NULL),
(11, 'GHATLODIYA', 125, 1, '2024-07-04 17:36:13', '2024-07-04 17:36:13', NULL),
(12, 'SECTOR 19', 133, 1, '2024-07-06 13:44:03', '2024-07-06 13:44:03', NULL),
(13, 'HALOL', 148, 1, '2024-07-06 13:54:15', '2024-07-06 13:54:15', NULL),
(14, 'SATELLITE', 125, 1, '2024-07-06 13:59:13', '2024-07-06 13:59:13', NULL),
(15, 'MANINAGAR', 125, 1, '2024-07-06 14:03:54', '2024-07-06 14:03:54', NULL),
(16, 'VAISHNODEVI CRICLE', 125, 1, '2024-07-06 14:05:11', '2024-07-06 14:05:11', NULL),
(17, 'BHILMAAN', 448, 1, '2024-07-06 14:10:20', '2024-07-06 14:10:20', NULL),
(18, 'MAHALON KI PIPLI', 458, 1, '2024-07-06 18:29:19', '2024-07-06 18:29:19', NULL),
(19, 'CHITARIYA', 145, 1, '2024-07-09 12:59:40', '2024-07-09 12:59:40', NULL),
(20, 'Narayan pura', 125, 1, '2024-07-11 12:42:32', '2024-07-11 12:42:32', NULL),
(21, 'RAMDEVNAGAR', 125, 1, '2024-07-18 13:17:54', '2024-07-18 13:17:54', NULL),
(22, 'ISCON', 125, 1, '2024-07-18 13:17:54', '2024-07-18 13:17:54', NULL),
(23, 'SARKHEJ', 125, 1, '2024-07-18 13:17:54', '2024-07-18 13:17:54', NULL),
(24, 'SATTELITE', 125, 1, '2024-07-18 13:17:54', '2024-07-18 13:17:54', NULL),
(25, 'AANAND NAGAR', 125, 1, '2024-07-18 13:26:28', '2024-07-18 13:26:28', NULL),
(26, 'VISHNAGAR', 138, 1, '2024-07-18 13:34:48', '2024-07-18 13:34:48', NULL),
(27, 'VIJAY NAGAR', 125, 1, '2024-07-18 14:06:39', '2024-07-18 14:06:39', NULL),
(28, 'KUMBELA', 444, 1, '2024-07-18 14:19:24', '2024-07-18 14:19:24', NULL),
(29, 'JETAPUR', 524, 1, '2024-07-18 14:31:57', '2024-07-18 14:31:57', NULL),
(30, 'PANKOR NAKA', 125, 1, '2024-07-18 15:39:47', '2024-07-18 15:39:47', NULL),
(31, 'SHAHPUR', 125, 1, '2024-07-18 15:49:37', '2024-07-18 15:49:37', NULL),
(32, 'KANKARIYA', 125, 1, '2024-07-18 15:59:31', '2024-07-18 15:59:31', NULL),
(33, 'CIVIL', 125, 1, '2024-07-18 16:07:01', '2024-07-18 16:07:01', NULL),
(34, 'RUSABHGHAT', 463, 1, '2024-07-18 16:13:28', '2024-07-18 16:13:28', NULL),
(35, 'DARIYAPUR', 125, 1, '2024-07-18 16:18:44', '2024-07-18 16:18:44', NULL),
(36, 'VISNAGAR', 145, 1, '2024-07-18 16:20:56', '2024-07-18 16:20:56', NULL),
(37, 'RAKHIYAL', 125, 1, '2024-07-18 16:45:19', '2024-07-18 16:45:19', NULL),
(38, 'CHANDLODIA', 125, 1, '2024-07-18 16:55:40', '2024-07-18 16:55:40', NULL),
(39, 'DAIYAA', 463, 1, '2024-07-18 17:03:14', '2024-07-18 17:03:14', NULL),
(40, 'NAVA VADAJ', 125, 1, '2024-07-18 17:05:48', '2024-07-18 17:05:48', NULL),
(41, 'CHIROLA', 435, 1, '2024-07-18 17:09:39', '2024-07-18 17:09:39', NULL),
(42, 'NARODA', 125, 1, '2024-07-18 17:16:00', '2024-07-18 17:16:00', NULL),
(43, 'KAALEDA', 128, 1, '2024-07-18 17:21:30', '2024-07-18 17:21:30', NULL),
(44, 'VEJALPUR', 125, 1, '2024-07-18 17:26:38', '2024-07-18 17:26:38', NULL),
(45, 'VATVA', 125, 1, '2024-07-18 17:28:22', '2024-07-18 17:28:22', NULL),
(46, 'NAROL', 125, 1, '2024-07-18 17:36:42', '2024-07-18 17:36:42', NULL),
(47, 'METWALA', 125, 1, '2024-07-22 14:29:08', '2024-07-22 14:29:08', NULL),
(48, 'METWALA', 435, 1, '2024-07-22 14:31:44', '2024-07-22 14:31:44', NULL),
(49, 'RISHABADEV', 463, 1, '2024-07-22 15:26:58', '2024-07-22 15:26:58', NULL),
(50, 'PUNJPUR', 444, 1, '2024-07-22 15:40:57', '2024-07-22 15:40:57', NULL),
(51, 'GARNALA KOTARA', 463, 1, '2024-07-22 15:49:17', '2024-07-22 15:49:17', NULL),
(52, 'JHADOL', 463, 1, '2024-07-22 15:57:40', '2024-07-22 15:57:40', NULL),
(53, 'BHAVANGARH', 128, 1, '2024-07-22 16:09:25', '2024-07-22 16:09:25', NULL),
(54, 'VANOD', 146, 1, '2024-07-22 16:15:05', '2024-07-22 16:15:05', NULL),
(55, 'NADIAD', 137, 1, '2024-07-22 16:23:55', '2024-07-22 16:23:55', NULL),
(56, 'LICHHA', 145, 1, '2024-07-22 16:36:02', '2024-07-22 16:36:02', NULL),
(57, 'RAMGARH', 444, 1, '2024-07-22 16:41:37', '2024-07-22 16:41:37', NULL),
(58, 'PALODA', 435, 1, '2024-07-22 16:47:43', '2024-07-22 16:47:43', NULL),
(59, 'SHISHOD', 444, 1, '2024-07-22 17:17:15', '2024-07-22 17:17:15', NULL),
(60, 'TOKAR', 463, 1, '2024-07-23 16:56:24', '2024-07-23 16:56:24', NULL),
(61, 'GHODASAR', 125, 1, '2024-07-23 17:01:52', '2024-07-23 17:01:52', NULL),
(62, 'PETHAPUR', 133, 1, '2024-07-23 17:21:39', '2024-07-23 17:21:39', NULL),
(63, 'GHOGHAVADA', 142, 1, '2024-07-23 17:32:08', '2024-07-23 17:32:08', NULL),
(64, 'SARDA SARARA', 463, 1, '2024-07-23 17:38:36', '2024-07-23 17:38:36', NULL),
(65, 'LALPURIYA', 463, 1, '2024-07-23 17:47:09', '2024-07-23 17:47:09', NULL),
(66, 'RUPAREL', 293, 1, '2024-07-23 17:52:00', '2024-07-23 17:52:00', NULL),
(67, 'KALOL', 133, 1, '2024-07-23 17:56:30', '2024-07-23 17:56:30', NULL),
(68, 'GAMDI DEVKI', 444, 1, '2024-07-24 15:16:30', '2024-07-24 15:16:30', NULL),
(69, 'KOSHITWALA', 439, 1, '2024-07-24 15:32:40', '2024-07-24 15:32:40', NULL),
(70, 'NEEMODA', 463, 1, '2024-07-24 15:43:03', '2024-07-24 15:43:03', NULL),
(71, 'NOKHNA', 444, 1, '2024-07-24 15:50:52', '2024-07-24 15:50:52', NULL),
(72, 'VARDA', 444, 1, '2024-07-24 16:01:32', '2024-07-24 16:01:32', NULL),
(73, 'MEMNAGAR', 125, 1, '2024-07-24 17:27:11', '2024-07-24 17:27:11', NULL),
(74, 'KHERVADA', 463, 1, '2024-07-24 17:34:41', '2024-07-24 17:34:41', NULL),
(75, 'DEODAR', 128, 1, '2024-07-25 14:28:05', '2024-07-25 14:28:05', NULL),
(76, 'NARANPURA', 125, 1, '2024-07-25 17:24:09', '2024-07-25 17:24:09', NULL),
(77, 'MITHAKALI', 125, 1, '2024-07-25 17:26:56', '2024-07-25 17:26:56', NULL),
(78, 'JAGATPUR', 125, 1, '2024-07-25 17:29:00', '2024-07-25 17:29:00', NULL),
(79, 'CHANDKHEDA', 125, 1, '2024-07-25 17:45:10', '2024-07-25 17:45:10', NULL),
(80, 'GOTA', 125, 1, '2024-07-25 17:46:51', '2024-07-25 17:46:51', NULL),
(81, 'AMBAWADI', 125, 1, '2024-07-25 17:55:59', '2024-07-25 17:55:59', NULL),
(82, 'SG HIGHWAY', 125, 1, '2024-07-25 17:57:49', '2024-07-25 17:57:49', NULL),
(83, 'VAVOL', 133, 1, '2024-07-25 18:00:21', '2024-07-25 18:00:21', NULL),
(84, 'THALTEJ', 125, 1, '2024-07-25 18:03:42', '2024-07-25 18:03:42', NULL),
(85, 'SHILAJ', 125, 1, '2024-07-25 18:07:20', '2024-07-25 18:07:20', NULL),
(86, 'ELLISHBRIDGE', 125, 1, '2024-07-25 18:12:54', '2024-07-25 18:12:54', NULL),
(87, 'VIJAPUR', 138, 1, '2024-07-26 13:22:27', '2024-07-26 13:22:27', NULL),
(88, 'VANSOL', 137, 1, '2024-07-26 13:36:34', '2024-07-26 13:36:34', NULL),
(89, 'ADANI SHANTIGRAM', 125, 1, '2024-07-26 14:00:58', '2024-07-26 14:00:58', NULL),
(90, 'SECTOR 7B', 133, 1, '2024-07-26 14:06:55', '2024-07-26 14:06:55', NULL),
(91, 'VASNA', 125, 1, '2024-07-26 14:08:28', '2024-07-26 14:08:28', NULL),
(92, 'SOUTH BOPAL', 125, 1, '2024-07-26 14:10:21', '2024-07-26 14:10:21', NULL),
(93, 'BODAKDEV', 125, 1, '2024-07-26 14:14:39', '2024-07-26 14:14:39', NULL),
(94, 'AMLI BOPAL', 125, 1, '2024-07-26 14:30:30', '2024-07-26 14:30:30', NULL),
(95, 'SCIENCE CITY', 125, 1, '2024-07-26 15:23:33', '2024-07-26 15:23:33', NULL),
(96, 'SINGARWA', 125, 1, '2024-07-26 15:26:12', '2024-07-26 15:26:12', NULL),
(97, 'PRAHLADNAGAR', 125, 1, '2024-07-26 15:36:16', '2024-07-26 15:36:16', NULL),
(98, 'KUDASAN', 133, 1, '2024-07-26 15:40:33', '2024-07-26 15:40:33', NULL),
(99, 'NAVRANGPURA', 125, 1, '2024-07-26 15:43:55', '2024-07-26 15:43:55', NULL),
(100, 'KUBERNAGAR', 125, 1, '2024-07-26 15:45:50', '2024-07-26 15:45:50', NULL),
(101, 'MANDWA', 444, 1, '2024-07-27 12:38:06', '2024-07-27 12:38:06', NULL),
(102, 'BANDHANA', 145, 1, '2024-07-27 12:43:19', '2024-07-27 12:43:19', NULL),
(103, 'AMBASA', 463, 1, '2024-07-27 18:03:56', '2024-07-27 18:03:56', NULL),
(104, 'GAMDI DEVAL', 444, 1, '2024-07-29 13:17:41', '2024-07-29 13:17:41', NULL),
(105, 'KHEDBARHMA', 145, 1, '2024-07-29 13:23:57', '2024-07-29 13:23:57', NULL),
(106, 'KHERWARA SIDARI', 444, 1, '2024-07-29 13:36:30', '2024-07-29 13:36:30', NULL),
(107, 'CHORAL', 463, 1, '2024-07-29 14:12:53', '2024-07-29 14:12:53', NULL),
(108, 'VIRPUR', 145, 1, '2024-07-29 14:39:26', '2024-07-29 14:39:26', NULL),
(109, 'DHEDHUKI', 144, 1, '2024-07-29 14:47:12', '2024-07-29 14:47:12', NULL),
(110, 'CHIKHLI', 444, 1, '2024-07-29 15:11:05', '2024-07-29 15:11:05', NULL),
(111, 'VASTRAL', 125, 1, '2024-07-29 15:18:23', '2024-07-29 15:18:23', NULL),
(112, 'KASNAU', 455, 1, '2024-07-29 17:42:42', '2024-07-29 17:42:42', NULL),
(113, 'SAHIBAGH', 125, 1, '2024-08-02 14:04:23', '2024-08-02 14:04:23', NULL),
(114, 'ODHAV', 125, 1, '2024-08-09 13:36:05', '2024-08-09 13:36:05', NULL),
(115, 'GIR SOMNATH', 134, 1, '2024-08-09 13:44:16', '2024-08-09 13:44:16', NULL);

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
  `status` int(11) NOT NULL DEFAULT 0 COMMENT '0=pending, 1=assigned	',
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
(1, 'DHCB20241', 4, 'Corporate', '2024-09-02', '2024-09-03', 1, 0, 0, 0, '1000', '1000', '0', NULL, 1, 1, 1, 1, 1, '2024-09-04 03:59:14', '2024-10-09 02:11:03', NULL),
(2, 'DHCB20242', 83, 'Patient', '2024-10-08', '2024-10-09', 1, 0, 0, 0, '1600', '1600', '1600', 'don\'t want staff any more.', 0, 1, 1, NULL, 1, '2024-10-09 00:50:58', '2024-10-10 00:37:04', NULL),
(3, 'DHCB20243', 4, 'Corporate', '2024-10-09', '2024-10-31', 1, 0, 0, 0, '11500', '11500', '11500', NULL, 0, 1, 1, NULL, 1, '2024-10-09 00:51:29', '2024-10-09 06:25:07', NULL),
(4, 'DHCB20244', 82, 'Patient', '2024-10-09', '2024-10-09', 1, 0, 0, 0, '1100', '1100', '1100', 'nothing', 0, 2, 1, NULL, NULL, '2024-10-09 02:17:02', '2024-10-10 00:20:38', NULL),
(5, 'DHCB20245', 82, 'Patient', '2024-10-09', '2024-10-18', 1, 0, 0, 0, '5000', '5000', '5000', NULL, 1, 0, 1, 1, NULL, '2024-10-10 00:28:57', '2024-10-10 00:31:02', NULL),
(6, 'DHCB20246', 83, 'Patient', '2024-10-10', '2024-10-19', 1, 0, 0, 0, '8000', '8000', '8000', NULL, 0, 0, 2, NULL, NULL, '2024-10-10 04:02:08', '2024-10-10 04:02:08', NULL),
(7, 'DHCB20247', 6, 'Corporate', '2024-10-10', '2024-10-19', 1, 0, 0, 0, '5000', '5000', '5000', NULL, 0, 0, 2, NULL, NULL, '2024-10-10 04:02:35', '2024-10-10 04:02:35', NULL);

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
  `booking_status` int(11) NOT NULL DEFAULT 0 COMMENT '	0=Open, 1=Closed',
  `staff_payment` int(11) NOT NULL DEFAULT 0 COMMENT '0=Pending, 1=Done',
  `is_cancled` int(11) NOT NULL DEFAULT 0 COMMENT '0=No, 1=Yes',
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `booking_assign`
--

INSERT INTO `booking_assign` (`id`, `booking_id`, `booking_detail_id`, `staff_id`, `type`, `shift`, `cost_rate`, `sell_rate`, `date`, `att_date_time`, `lat`, `lng`, `att_proof`, `rej_reason`, `att_marked`, `status`, `booking_status`, `staff_payment`, `is_cancled`, `updated_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 1, 97, 'BABY CARE', 1, '400', '500', '2024-09-02', '2024-09-04 15:11:32', NULL, NULL, NULL, NULL, 1, 1, 1, 1, 0, 1, '2024-09-04 03:59:14', '2024-10-09 05:11:29', NULL),
(2, 1, 1, 97, 'BABY CARE', 1, '400', '500', '2024-09-03', '2024-09-04 15:11:38', NULL, NULL, NULL, NULL, 1, 1, 1, 1, 0, 1, '2024-09-04 03:59:14', '2024-10-09 05:11:29', NULL),
(3, 2, 2, 95, 'ATTENDANT STAFF', 1, '500', '800', '2024-10-08', '2024-10-09 14:24:41', NULL, NULL, NULL, NULL, 0, 0, 1, 1, 0, 1, '2024-10-09 00:50:58', '2024-10-10 00:37:04', NULL),
(4, 2, 2, 95, 'ATTENDANT STAFF', 1, '500', '800', '2024-10-09', NULL, NULL, NULL, NULL, NULL, 0, 0, 1, 0, 0, NULL, '2024-10-09 00:50:58', '2024-10-10 00:37:04', NULL),
(5, 2, 2, NULL, 'ATTENDANT STAFF', 1, NULL, '800', '2024-10-10', NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, NULL, '2024-10-09 00:50:58', '2024-10-10 00:18:19', '2024-10-10 00:18:19'),
(6, 2, 2, NULL, 'ATTENDANT STAFF', 1, NULL, '800', '2024-10-11', NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, NULL, '2024-10-09 00:50:58', '2024-10-10 00:18:19', '2024-10-10 00:18:19'),
(7, 2, 2, NULL, 'ATTENDANT STAFF', 1, NULL, '800', '2024-10-12', NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, NULL, '2024-10-09 00:50:58', '2024-10-10 00:18:19', '2024-10-10 00:18:19'),
(8, 2, 2, NULL, 'ATTENDANT STAFF', 1, NULL, '800', '2024-10-13', NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, NULL, '2024-10-09 00:50:58', '2024-10-10 00:18:19', '2024-10-10 00:18:19'),
(9, 2, 2, NULL, 'ATTENDANT STAFF', 1, NULL, '800', '2024-10-14', NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, NULL, '2024-10-09 00:50:58', '2024-10-10 00:18:19', '2024-10-10 00:18:19'),
(10, 2, 2, NULL, 'ATTENDANT STAFF', 1, NULL, '800', '2024-10-15', NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, NULL, '2024-10-09 00:50:58', '2024-10-10 00:18:19', '2024-10-10 00:18:19'),
(11, 2, 2, NULL, 'ATTENDANT STAFF', 1, NULL, '800', '2024-10-16', NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, NULL, '2024-10-09 00:50:59', '2024-10-10 00:18:19', '2024-10-10 00:18:19'),
(12, 2, 2, NULL, 'ATTENDANT STAFF', 1, NULL, '800', '2024-10-17', NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, NULL, '2024-10-09 00:50:59', '2024-10-10 00:18:19', '2024-10-10 00:18:19'),
(13, 2, 2, NULL, 'ATTENDANT STAFF', 1, NULL, '800', '2024-10-18', NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, NULL, '2024-10-09 00:50:59', '2024-10-10 00:18:19', '2024-10-10 00:18:19'),
(14, 2, 2, NULL, 'ATTENDANT STAFF', 1, NULL, '800', '2024-10-19', NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, NULL, '2024-10-09 00:50:59', '2024-10-10 00:18:19', '2024-10-10 00:18:19'),
(15, 2, 2, NULL, 'ATTENDANT STAFF', 1, NULL, '800', '2024-10-20', NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, NULL, '2024-10-09 00:50:59', '2024-10-10 00:18:19', '2024-10-10 00:18:19'),
(16, 2, 2, NULL, 'ATTENDANT STAFF', 1, NULL, '800', '2024-10-21', NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, NULL, '2024-10-09 00:50:59', '2024-10-10 00:18:19', '2024-10-10 00:18:19'),
(17, 2, 2, NULL, 'ATTENDANT STAFF', 1, NULL, '800', '2024-10-22', NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, NULL, '2024-10-09 00:50:59', '2024-10-10 00:18:19', '2024-10-10 00:18:19'),
(18, 2, 2, NULL, 'ATTENDANT STAFF', 1, NULL, '800', '2024-10-23', NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, NULL, '2024-10-09 00:50:59', '2024-10-10 00:18:19', '2024-10-10 00:18:19'),
(19, 2, 2, NULL, 'ATTENDANT STAFF', 1, NULL, '800', '2024-10-24', NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, NULL, '2024-10-09 00:50:59', '2024-10-10 00:18:19', '2024-10-10 00:18:19'),
(20, 2, 2, NULL, 'ATTENDANT STAFF', 1, NULL, '800', '2024-10-25', NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, NULL, '2024-10-09 00:50:59', '2024-10-10 00:18:19', '2024-10-10 00:18:19'),
(21, 2, 2, NULL, 'ATTENDANT STAFF', 1, NULL, '800', '2024-10-26', NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, NULL, '2024-10-09 00:50:59', '2024-10-10 00:18:19', '2024-10-10 00:18:19'),
(22, 2, 2, NULL, 'ATTENDANT STAFF', 1, NULL, '800', '2024-10-27', NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, NULL, '2024-10-09 00:50:59', '2024-10-10 00:18:19', '2024-10-10 00:18:19'),
(23, 2, 2, NULL, 'ATTENDANT STAFF', 1, NULL, '800', '2024-10-28', NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, NULL, '2024-10-09 00:50:59', '2024-10-10 00:18:19', '2024-10-10 00:18:19'),
(24, 2, 2, NULL, 'ATTENDANT STAFF', 1, NULL, '800', '2024-10-29', NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, NULL, '2024-10-09 00:50:59', '2024-10-10 00:18:19', '2024-10-10 00:18:19'),
(25, 2, 2, NULL, 'ATTENDANT STAFF', 1, NULL, '800', '2024-10-30', NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, NULL, '2024-10-09 00:50:59', '2024-10-10 00:18:19', '2024-10-10 00:18:19'),
(26, 2, 2, NULL, 'ATTENDANT STAFF', 1, NULL, '800', '2024-10-31', NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, NULL, '2024-10-09 00:50:59', '2024-10-10 00:18:19', '2024-10-10 00:18:19'),
(27, 3, 3, 97, 'BABY CARE', 1, '400', '500', '2024-10-09', NULL, NULL, NULL, NULL, NULL, 0, 0, 1, 0, 0, NULL, '2024-10-09 00:51:29', '2024-10-09 06:25:06', NULL),
(28, 3, 3, NULL, 'BABY CARE', 1, NULL, '500', '2024-10-10', NULL, NULL, NULL, NULL, NULL, 0, 0, 1, 0, 0, NULL, '2024-10-09 00:51:29', '2024-10-09 06:25:06', NULL),
(29, 3, 3, NULL, 'BABY CARE', 1, NULL, '500', '2024-10-11', NULL, NULL, NULL, NULL, NULL, 0, 0, 1, 0, 0, NULL, '2024-10-09 00:51:30', '2024-10-09 06:25:07', NULL),
(30, 3, 3, NULL, 'BABY CARE', 1, NULL, '500', '2024-10-12', NULL, NULL, NULL, NULL, NULL, 0, 0, 1, 0, 0, NULL, '2024-10-09 00:51:30', '2024-10-09 06:25:07', NULL),
(31, 3, 3, NULL, 'BABY CARE', 1, NULL, '500', '2024-10-13', NULL, NULL, NULL, NULL, NULL, 0, 0, 1, 0, 0, NULL, '2024-10-09 00:51:30', '2024-10-09 06:25:07', NULL),
(32, 3, 3, NULL, 'BABY CARE', 1, NULL, '500', '2024-10-14', NULL, NULL, NULL, NULL, NULL, 0, 0, 1, 0, 0, NULL, '2024-10-09 00:51:30', '2024-10-09 06:25:07', NULL),
(33, 3, 3, NULL, 'BABY CARE', 1, NULL, '500', '2024-10-15', NULL, NULL, NULL, NULL, NULL, 0, 0, 1, 0, 0, NULL, '2024-10-09 00:51:30', '2024-10-09 06:25:07', NULL),
(34, 3, 3, NULL, 'BABY CARE', 1, NULL, '500', '2024-10-16', NULL, NULL, NULL, NULL, NULL, 0, 0, 1, 0, 0, NULL, '2024-10-09 00:51:30', '2024-10-09 06:25:07', NULL),
(35, 3, 3, NULL, 'BABY CARE', 1, NULL, '500', '2024-10-17', NULL, NULL, NULL, NULL, NULL, 0, 0, 1, 0, 0, NULL, '2024-10-09 00:51:30', '2024-10-09 06:25:07', NULL),
(36, 3, 3, NULL, 'BABY CARE', 1, NULL, '500', '2024-10-18', NULL, NULL, NULL, NULL, NULL, 0, 0, 1, 0, 0, NULL, '2024-10-09 00:51:30', '2024-10-09 06:25:07', NULL),
(37, 3, 3, NULL, 'BABY CARE', 1, NULL, '500', '2024-10-19', NULL, NULL, NULL, NULL, NULL, 0, 0, 1, 0, 0, NULL, '2024-10-09 00:51:30', '2024-10-09 06:25:07', NULL),
(38, 3, 3, NULL, 'BABY CARE', 1, NULL, '500', '2024-10-20', NULL, NULL, NULL, NULL, NULL, 0, 0, 1, 0, 0, NULL, '2024-10-09 00:51:30', '2024-10-09 06:25:07', NULL),
(39, 3, 3, NULL, 'BABY CARE', 1, NULL, '500', '2024-10-21', NULL, NULL, NULL, NULL, NULL, 0, 0, 1, 0, 0, NULL, '2024-10-09 00:51:30', '2024-10-09 06:25:07', NULL),
(40, 3, 3, NULL, 'BABY CARE', 1, NULL, '500', '2024-10-22', NULL, NULL, NULL, NULL, NULL, 0, 0, 1, 0, 0, NULL, '2024-10-09 00:51:30', '2024-10-09 06:25:07', NULL),
(41, 3, 3, NULL, 'BABY CARE', 1, NULL, '500', '2024-10-23', NULL, NULL, NULL, NULL, NULL, 0, 0, 1, 0, 0, NULL, '2024-10-09 00:51:31', '2024-10-09 06:25:07', NULL),
(42, 3, 3, NULL, 'BABY CARE', 1, NULL, '500', '2024-10-24', NULL, NULL, NULL, NULL, NULL, 0, 0, 1, 0, 0, NULL, '2024-10-09 00:51:31', '2024-10-09 06:25:07', NULL),
(43, 3, 3, NULL, 'BABY CARE', 1, NULL, '500', '2024-10-25', NULL, NULL, NULL, NULL, NULL, 0, 0, 1, 0, 0, NULL, '2024-10-09 00:51:31', '2024-10-09 06:25:07', NULL),
(44, 3, 3, NULL, 'BABY CARE', 1, NULL, '500', '2024-10-26', NULL, NULL, NULL, NULL, NULL, 0, 0, 1, 0, 0, NULL, '2024-10-09 00:51:31', '2024-10-09 06:25:07', NULL),
(45, 3, 3, NULL, 'BABY CARE', 1, NULL, '500', '2024-10-27', NULL, NULL, NULL, NULL, NULL, 0, 0, 1, 0, 0, NULL, '2024-10-09 00:51:31', '2024-10-09 06:25:07', NULL),
(46, 3, 3, NULL, 'BABY CARE', 1, NULL, '500', '2024-10-28', NULL, NULL, NULL, NULL, NULL, 0, 0, 1, 0, 0, NULL, '2024-10-09 00:51:31', '2024-10-09 06:25:07', NULL),
(47, 3, 3, NULL, 'BABY CARE', 1, NULL, '500', '2024-10-29', NULL, NULL, NULL, NULL, NULL, 0, 0, 1, 0, 0, NULL, '2024-10-09 00:51:31', '2024-10-09 06:25:07', NULL),
(48, 3, 3, NULL, 'BABY CARE', 1, NULL, '500', '2024-10-30', NULL, NULL, NULL, NULL, NULL, 0, 0, 1, 0, 0, NULL, '2024-10-09 00:51:31', '2024-10-09 06:25:07', NULL),
(49, 3, 3, NULL, 'BABY CARE', 1, NULL, '500', '2024-10-31', NULL, NULL, NULL, NULL, NULL, 0, 0, 1, 0, 0, NULL, '2024-10-09 00:51:31', '2024-10-09 06:25:07', NULL),
(50, 4, 4, 79, 'NURSING STAFF', 1, '500', '1100', '2024-10-09', NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, NULL, '2024-10-09 02:17:02', '2024-10-09 08:06:27', NULL),
(51, 4, 4, NULL, 'NURSING STAFF', 1, NULL, '1100', '2024-10-10', NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, NULL, '2024-10-09 02:17:02', '2024-10-10 00:20:38', '2024-10-10 00:20:38'),
(52, 4, 4, NULL, 'NURSING STAFF', 1, NULL, '1100', '2024-10-11', NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, NULL, '2024-10-09 02:17:02', '2024-10-10 00:20:38', '2024-10-10 00:20:38'),
(53, 4, 4, NULL, 'NURSING STAFF', 1, NULL, '1100', '2024-10-12', NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, NULL, '2024-10-09 02:17:03', '2024-10-10 00:20:38', '2024-10-10 00:20:38'),
(54, 4, 4, NULL, 'NURSING STAFF', 1, NULL, '1100', '2024-10-13', NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, NULL, '2024-10-09 02:17:03', '2024-10-10 00:20:38', '2024-10-10 00:20:38'),
(55, 4, 4, NULL, 'NURSING STAFF', 1, NULL, '1100', '2024-10-14', NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, NULL, '2024-10-09 02:17:03', '2024-10-10 00:20:38', '2024-10-10 00:20:38'),
(56, 4, 4, NULL, 'NURSING STAFF', 1, NULL, '1100', '2024-10-15', NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, NULL, '2024-10-09 02:17:03', '2024-10-10 00:20:38', '2024-10-10 00:20:38'),
(57, 4, 4, NULL, 'NURSING STAFF', 1, NULL, '1100', '2024-10-16', NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, NULL, '2024-10-09 02:17:03', '2024-10-10 00:20:38', '2024-10-10 00:20:38'),
(58, 4, 4, NULL, 'NURSING STAFF', 1, NULL, '1100', '2024-10-17', NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, NULL, '2024-10-09 02:17:03', '2024-10-10 00:20:38', '2024-10-10 00:20:38'),
(59, 4, 4, NULL, 'NURSING STAFF', 1, NULL, '1100', '2024-10-18', NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, NULL, '2024-10-09 02:17:03', '2024-10-10 00:20:38', '2024-10-10 00:20:38'),
(60, 4, 4, NULL, 'NURSING STAFF', 1, NULL, '1100', '2024-10-19', NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, NULL, '2024-10-09 02:17:03', '2024-10-10 00:20:38', '2024-10-10 00:20:38'),
(61, 4, 4, NULL, 'NURSING STAFF', 1, NULL, '1100', '2024-10-20', NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, NULL, '2024-10-09 02:17:03', '2024-10-10 00:20:38', '2024-10-10 00:20:38'),
(62, 4, 4, NULL, 'NURSING STAFF', 1, NULL, '1100', '2024-10-21', NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, NULL, '2024-10-09 02:17:03', '2024-10-10 00:20:38', '2024-10-10 00:20:38'),
(63, 4, 4, NULL, 'NURSING STAFF', 1, NULL, '1100', '2024-10-22', NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, NULL, '2024-10-09 02:17:03', '2024-10-10 00:20:38', '2024-10-10 00:20:38'),
(64, 4, 4, NULL, 'NURSING STAFF', 1, NULL, '1100', '2024-10-23', NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, NULL, '2024-10-09 02:17:03', '2024-10-10 00:20:38', '2024-10-10 00:20:38'),
(65, 4, 4, NULL, 'NURSING STAFF', 1, NULL, '1100', '2024-10-24', NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, NULL, '2024-10-09 02:17:03', '2024-10-10 00:20:38', '2024-10-10 00:20:38'),
(66, 4, 4, NULL, 'NURSING STAFF', 1, NULL, '1100', '2024-10-25', NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, NULL, '2024-10-09 02:17:03', '2024-10-10 00:20:38', '2024-10-10 00:20:38'),
(67, 4, 4, NULL, 'NURSING STAFF', 1, NULL, '1100', '2024-10-26', NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, NULL, '2024-10-09 02:17:03', '2024-10-10 00:20:38', '2024-10-10 00:20:38'),
(68, 4, 4, NULL, 'NURSING STAFF', 1, NULL, '1100', '2024-10-27', NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, NULL, '2024-10-09 02:17:03', '2024-10-10 00:20:38', '2024-10-10 00:20:38'),
(69, 4, 4, NULL, 'NURSING STAFF', 1, NULL, '1100', '2024-10-28', NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, NULL, '2024-10-09 02:17:03', '2024-10-10 00:20:38', '2024-10-10 00:20:38'),
(70, 4, 4, NULL, 'NURSING STAFF', 1, NULL, '1100', '2024-10-29', NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, NULL, '2024-10-09 02:17:03', '2024-10-10 00:20:38', '2024-10-10 00:20:38'),
(71, 4, 4, NULL, 'NURSING STAFF', 1, NULL, '1100', '2024-10-30', NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, NULL, '2024-10-09 02:17:04', '2024-10-10 00:20:38', '2024-10-10 00:20:38'),
(72, 4, 4, NULL, 'NURSING STAFF', 1, NULL, '1100', '2024-10-31', NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, NULL, '2024-10-09 02:17:04', '2024-10-10 00:20:38', '2024-10-10 00:20:38'),
(73, 5, 5, NULL, 'ATTENDANT STAFF', 1, NULL, '500', '2024-10-09', NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, NULL, '2024-10-10 00:28:57', '2024-10-10 00:28:57', NULL),
(74, 5, 5, NULL, 'ATTENDANT STAFF', 1, NULL, '500', '2024-10-10', NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 1, '2024-10-10 00:28:57', '2024-10-10 00:40:01', NULL),
(75, 5, 5, 94, 'ATTENDANT STAFF', 1, '500', '500', '2024-10-11', NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, NULL, '2024-10-10 00:28:57', '2024-10-10 00:31:02', NULL),
(76, 5, 5, 94, 'ATTENDANT STAFF', 1, '500', '500', '2024-10-12', NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, NULL, '2024-10-10 00:28:57', '2024-10-10 00:31:02', NULL),
(77, 5, 5, 94, 'ATTENDANT STAFF', 1, '500', '500', '2024-10-13', NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, NULL, '2024-10-10 00:28:57', '2024-10-10 00:31:02', NULL),
(78, 5, 5, 94, 'ATTENDANT STAFF', 1, '500', '500', '2024-10-14', NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, NULL, '2024-10-10 00:28:57', '2024-10-10 00:31:02', NULL),
(79, 5, 5, 94, 'ATTENDANT STAFF', 1, '500', '500', '2024-10-15', NULL, NULL, NULL, NULL, NULL, 1, 2, 0, 0, 0, 1, '2024-10-10 00:28:57', '2024-10-10 00:34:44', NULL),
(80, 5, 5, 94, 'ATTENDANT STAFF', 1, '500', '500', '2024-10-16', NULL, NULL, NULL, NULL, NULL, 1, 2, 0, 0, 0, 1, '2024-10-10 00:28:57', '2024-10-10 00:34:44', NULL),
(81, 5, 5, 94, 'ATTENDANT STAFF', 1, '500', '500', '2024-10-17', NULL, NULL, NULL, NULL, NULL, 1, 1, 0, 1, 0, 1, '2024-10-10 00:28:57', '2024-10-10 06:33:38', NULL),
(82, 5, 5, 94, 'ATTENDANT STAFF', 1, '500', '500', '2024-10-18', NULL, NULL, NULL, NULL, NULL, 1, 1, 0, 1, 0, 1, '2024-10-10 00:28:57', '2024-10-10 06:33:38', NULL),
(83, 6, 6, NULL, 'BABY CARE', 2, NULL, '800', '2024-10-10', NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, NULL, '2024-10-10 04:02:08', '2024-10-10 04:02:08', NULL),
(84, 6, 6, NULL, 'BABY CARE', 2, NULL, '800', '2024-10-11', NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, NULL, '2024-10-10 04:02:08', '2024-10-10 04:02:08', NULL),
(85, 6, 6, NULL, 'BABY CARE', 2, NULL, '800', '2024-10-12', NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, NULL, '2024-10-10 04:02:08', '2024-10-10 04:02:08', NULL),
(86, 6, 6, NULL, 'BABY CARE', 2, NULL, '800', '2024-10-13', NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, NULL, '2024-10-10 04:02:08', '2024-10-10 04:02:08', NULL),
(87, 6, 6, NULL, 'BABY CARE', 2, NULL, '800', '2024-10-14', NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, NULL, '2024-10-10 04:02:08', '2024-10-10 04:02:08', NULL),
(88, 6, 6, NULL, 'BABY CARE', 2, NULL, '800', '2024-10-15', NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, NULL, '2024-10-10 04:02:08', '2024-10-10 04:02:08', NULL),
(89, 6, 6, NULL, 'BABY CARE', 2, NULL, '800', '2024-10-16', NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, NULL, '2024-10-10 04:02:08', '2024-10-10 04:02:08', NULL),
(90, 6, 6, NULL, 'BABY CARE', 2, NULL, '800', '2024-10-17', NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, NULL, '2024-10-10 04:02:08', '2024-10-10 04:02:08', NULL),
(91, 6, 6, NULL, 'BABY CARE', 2, NULL, '800', '2024-10-18', NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, NULL, '2024-10-10 04:02:08', '2024-10-10 04:02:08', NULL),
(92, 6, 6, NULL, 'BABY CARE', 2, NULL, '800', '2024-10-19', NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, NULL, '2024-10-10 04:02:08', '2024-10-10 04:02:08', NULL),
(93, 7, 7, NULL, 'NURSING STAFF', 1, NULL, '500', '2024-10-10', NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, NULL, '2024-10-10 04:02:35', '2024-10-10 04:02:35', NULL),
(94, 7, 7, NULL, 'NURSING STAFF', 1, NULL, '500', '2024-10-11', NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, NULL, '2024-10-10 04:02:35', '2024-10-10 04:02:35', NULL),
(95, 7, 7, NULL, 'NURSING STAFF', 1, NULL, '500', '2024-10-12', NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, NULL, '2024-10-10 04:02:35', '2024-10-10 04:02:35', NULL),
(96, 7, 7, NULL, 'NURSING STAFF', 1, NULL, '500', '2024-10-13', NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, NULL, '2024-10-10 04:02:35', '2024-10-10 04:02:35', NULL),
(97, 7, 7, NULL, 'NURSING STAFF', 1, NULL, '500', '2024-10-14', NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, NULL, '2024-10-10 04:02:35', '2024-10-10 04:02:35', NULL),
(98, 7, 7, NULL, 'NURSING STAFF', 1, NULL, '500', '2024-10-15', NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, NULL, '2024-10-10 04:02:35', '2024-10-10 04:02:35', NULL),
(99, 7, 7, NULL, 'NURSING STAFF', 1, NULL, '500', '2024-10-16', NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, NULL, '2024-10-10 04:02:35', '2024-10-10 04:02:35', NULL),
(100, 7, 7, NULL, 'NURSING STAFF', 1, NULL, '500', '2024-10-17', NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, NULL, '2024-10-10 04:02:35', '2024-10-10 04:02:35', NULL),
(101, 7, 7, NULL, 'NURSING STAFF', 1, NULL, '500', '2024-10-18', NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, NULL, '2024-10-10 04:02:35', '2024-10-10 04:02:35', NULL),
(102, 7, 7, NULL, 'NURSING STAFF', 1, NULL, '500', '2024-10-19', NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, NULL, '2024-10-10 04:02:35', '2024-10-10 04:02:35', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `booking_details`
--

CREATE TABLE `booking_details` (
  `id` int(11) NOT NULL,
  `booking_id` int(11) NOT NULL,
  `type` int(11) NOT NULL COMMENT '1 = staff, 2 = equipment, 3 = doctor, 4 = ambulance',
  `date` date DEFAULT NULL,
  `shift` int(11) DEFAULT NULL,
  `cost_rate` text DEFAULT NULL,
  `sell_rate` text DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `qnt` int(11) DEFAULT NULL,
  `is_assigned` int(11) NOT NULL DEFAULT 0 COMMENT '0=No, 1=Yes',
  `status` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `booking_details`
--

INSERT INTO `booking_details` (`id`, `booking_id`, `type`, `date`, `shift`, `cost_rate`, `sell_rate`, `name`, `qnt`, `is_assigned`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 1, NULL, 1, NULL, '500', 'BABY CARE', 2, 1, 0, '2024-09-04 03:59:14', '2024-09-04 04:11:03', NULL),
(2, 2, 1, NULL, 1, NULL, '800', 'ATTENDANT STAFF', 2, 0, 0, '2024-10-09 00:50:58', '2024-10-10 00:18:19', NULL),
(3, 3, 1, NULL, 1, NULL, '500', 'BABY CARE', 23, 0, 0, '2024-10-09 00:51:29', '2024-10-09 00:51:29', NULL),
(4, 4, 1, NULL, 1, NULL, '1100', 'NURSING STAFF', 1, 0, 0, '2024-10-09 02:17:02', '2024-10-10 00:20:38', NULL),
(5, 5, 1, NULL, 1, NULL, '500', 'ATTENDANT STAFF', 10, 1, 0, '2024-10-10 00:28:57', '2024-10-10 00:31:02', NULL),
(6, 6, 1, NULL, 2, NULL, '800', 'BABY CARE', 10, 0, 0, '2024-10-10 04:02:08', '2024-10-10 04:02:08', NULL),
(7, 7, 1, NULL, 1, NULL, '500', 'NURSING STAFF', 10, 0, 0, '2024-10-10 04:02:35', '2024-10-10 04:02:35', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `booking_invoice`
--

CREATE TABLE `booking_invoice` (
  `id` int(11) NOT NULL,
  `booking_id` int(11) DEFAULT NULL,
  `inv_no` text DEFAULT NULL,
  `file` text DEFAULT NULL,
  `amount` text DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `added_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `booking_invoice`
--

INSERT INTO `booking_invoice` (`id`, `booking_id`, `inv_no`, `file`, `amount`, `start_date`, `end_date`, `added_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'INV202411', 'INV202411.pdf', '1000', '2024-09-02', '2024-09-03', 1, '2024-10-09 02:10:18', '2024-10-09 02:10:20', NULL),
(2, 1, 'INV202412', 'INV202412.pdf', '500', '2024-09-03', '2024-09-03', 1, '2024-10-09 06:14:15', '2024-10-09 06:14:17', NULL),
(3, 1, 'INV202413', 'INV202413.pdf', '500', '2024-09-02', '2024-09-02', 1, '2024-10-09 06:21:18', '2024-10-09 06:21:20', NULL);

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

--
-- Dumping data for table `booking_payments`
--

INSERT INTO `booking_payments` (`id`, `booking_id`, `amount`, `date`, `start_date`, `end_date`, `added_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, '1000', '2024-10-09', '2024-09-02', '2024-09-03', 1, '2024-10-09 02:10:09', '2024-10-09 02:10:09', NULL),
(2, 3, '0', '2024-10-09', '2024-10-09', '2024-10-31', 1, '2024-10-09 06:24:46', '2024-10-09 06:24:46', NULL),
(3, 2, '0', '2024-10-10', '2024-10-08', '2024-10-09', 1, '2024-10-10 00:36:43', '2024-10-10 00:36:43', NULL);

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
(4, 'Adilabad', 1, 0, NULL, '2024-07-04 13:37:00', NULL),
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
(249, 'Alappuzha', 10, 0, NULL, '2024-07-04 13:37:30', NULL),
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
(313, 'Ahmednagar', 12, 0, NULL, '2024-06-18 15:02:06', NULL),
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
(364, 'Aizawl', 15, 0, NULL, '2024-07-04 13:37:10', NULL),
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
(431, 'Ajmer', 19, 0, NULL, '2024-07-04 13:37:21', NULL),
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
(515, 'Agra', 23, 0, NULL, '2024-07-04 13:37:04', NULL),
(516, 'Allahabad', 23, 0, NULL, '2024-07-04 13:38:05', NULL),
(517, 'Aligarh', 23, 0, NULL, '2024-07-04 13:37:45', NULL),
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
(1, 'CIMS HOSPITAL HOME CARE', 'SOLA', '125', '5', '4', '8401764903', '9099067988', '2024-06-18 18:38:38', '2024-07-29 17:11:19', '2024-07-29 17:11:19'),
(2, 'HOPE HOSPITAL', 'SURENDRA MANGALDAS RD, NR WAG BAKRI BUN. ELLISBRIDGE AHMEDABAD', '125', '5', '1', '9099039571', '0000000000', '2024-07-16 13:55:17', '2024-07-16 14:53:29', '2024-07-16 14:53:29'),
(3, 'SHALBY HOSPITAL SG RD', 'RAMDEVNAGAR CROSS RD', '125', '5', '21', '9723999927', '9512049598', '2024-07-18 13:20:08', '2024-07-25 15:02:22', '2024-07-25 15:02:22'),
(4, 'HOPE HOSPITAL', 'HOPE NEUROCARE HOSPITAL ELLISBRIDGE PALDI AHMEDABAD', '125', '5', '1', '9099039571', NULL, '2024-07-25 15:04:41', '2024-07-25 15:04:41', NULL),
(5, 'KRISHNA SHALBY', 'BOPAL', '125', '5', '3', '9512049760', NULL, '2024-07-25 18:28:07', '2024-07-29 17:11:02', '2024-07-29 17:11:02'),
(6, 'AVRON HOSPITAL', 'NAVRANGPURA', '125', '5', '76', '9713375863', NULL, '2024-07-29 17:14:02', '2024-07-29 17:14:02', NULL);

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
  `status` int(11) NOT NULL DEFAULT 1 COMMENT '0=inactive, 1=active	',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `doctor`
--

INSERT INTO `doctor` (`id`, `doctor_id`, `name`, `email`, `mobile`, `address`, `state`, `city`, `area`, `gender`, `age`, `dob`, `doj`, `experience`, `reference`, `qualification`, `specification`, `bank_name`, `branch`, `ifsc_code`, `acc_no`, `day_cost`, `night_cost`, `full_cost`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'DHCD202401', 'Kartik Bhavsar', 'kartik.budtech@gmail.com', '8141614389', '350, Kotfali', '5', '133', '12', 'Male', NULL, NULL, '2024-07-11', '2', NULL, NULL, 'physio', 'BOB', 'Gandhinagar', 'KBSH123', 'BOB123456', 500, 500, 1000, 1, '2024-07-11 15:02:05', '2024-07-11 15:03:15', NULL);

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
  `status` int(11) NOT NULL DEFAULT 1 COMMENT '0=inactive, 1=active	',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `equipment`
--

INSERT INTO `equipment` (`id`, `name`, `type`, `cost_price`, `sell_price`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'VENTILATOR', 'Rent', 1000, 800, 1, '2024-06-18 15:04:33', '2024-06-18 22:54:44', NULL),
(2, 'REMOTE BED', 'Rent', 1000, 800, 1, '2024-06-18 18:16:39', '2024-06-18 18:16:39', NULL),
(3, 'AIR BED', 'Rent', 1000, 800, 1, '2024-07-29 17:00:25', '2024-07-29 17:00:25', NULL),
(4, 'DVT PUMP', 'Rent', 100, 200, 1, '2024-07-29 17:02:15', '2024-07-29 17:02:15', NULL);

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
(1, 'CIMS HOSPITAL HOME CARE', 'Bhavika.jhiriwar@marengoasia.com', '9724289683', '9979295555', '2024-06-18 14:56:25', '2024-07-25 15:02:03', NULL),
(2, 'SHALBY HOSPITAL SG RD', 'HOMECARE1.SG@shalby.in', '9723999927', '9512049598', '2024-06-18 15:13:22', '2024-06-18 18:18:18', NULL),
(3, 'cims', 'sola', '9668735472', '9776524237', '2024-06-18 22:56:24', '2024-06-18 22:56:36', '2024-06-18 22:56:36'),
(4, 'Kartik Bhavsar', '350, Kotfali', '8141614389', '5689584758', '2024-07-11 14:08:18', '2024-07-11 14:08:26', '2024-07-11 14:08:26');

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
(1, 'DHCP202401', 'DHC', 'ARUNA J PANCHAL', NULL, '80', 'Female', 'SHIVRANJANI', '5', '125', '1', '9913210772', NULL, NULL, 'LOPA PANCHAL', '2024-06-18 18:36:20', '2024-06-18 18:36:20', NULL),
(2, 'DHCP202402', 'SHALBY HOSPITAL SG RD', 'SHRUTI CHUDGAR', NULL, '23', 'Female', '64 SUNRISE PARK RD B1 NR VASTRAPUR LAKE', '5', '125', '2', '9587133204', NULL, NULL, 'BHAVIK SIR', '2024-06-21 15:50:24', '2024-07-27 14:29:22', '2024-07-27 14:29:22'),
(3, 'DHCP202403', 'DHC', 'MR. VIJAY SINGH CHAMPAWAT', NULL, NULL, 'Male', '1 PRASHAN -1 BUNGALOW NEAR SAYONA CITY ROAD, BEHAIND NIRMAN COMLEX, ID PATEL SCHOOL CHANKYAPURI, GHATLODIYA', '5', '125', '10', '8758609883', NULL, NULL, 'MR. JIMIT', '2024-07-04 17:36:45', '2024-07-06 14:19:14', NULL),
(4, 'DHCP202404', 'DHC', 'MRS. PRAMILA DOSHI', NULL, NULL, 'Female', 'PLOT NO. 23, SEC.19, NEAR GYMKHANA GANDHINAGAR', '5', '133', '12', '9824445975', NULL, NULL, 'DR. RUPAL', '2024-07-06 13:46:28', '2024-07-06 13:46:28', NULL),
(5, 'DHCP202405', 'DHC', 'MR. JAIMIN R PATEL', NULL, NULL, 'Male', 'SCIENCE CITY, SOLA', '5', '125', '4', '7043887645', NULL, NULL, 'MR. MEHUL', '2024-07-06 13:49:38', '2024-07-06 13:49:38', NULL),
(6, 'DHCP202406', 'DHC', 'MR. BHAVA LAL SHAH', NULL, NULL, 'Male', 'JAWAHARNAGAR, HALOL', '5', '148', '13', '9327798979', NULL, NULL, 'NILESH LUNKAR', '2024-07-06 13:55:49', '2024-07-06 13:55:49', NULL),
(7, 'DHCP202407', 'DHC', 'MRS.MANI WRITER', NULL, NULL, 'Female', 'G-42, SATELLITE APARTMENTS ,JODHPUR CHAR RASTA .', '5', '125', '14', '6357790009', NULL, NULL, NULL, '2024-07-06 14:01:43', '2024-07-06 14:01:43', NULL),
(8, 'DHCP202408', 'DHC', 'MR. HARISH THAKKAR', NULL, NULL, 'Male', '4 IDEAL COLONY ,NEAR UTTAM NAGAR PARK, MANINAGAR,AHED', '5', '125', '15', '7567404536', NULL, NULL, 'DHRUVI THAKAR', '2024-07-06 14:07:20', '2024-07-06 14:07:20', NULL),
(9, 'DHCP202409', 'DHC', 'MR. TEJARAM VHIMARAM DEVASI', NULL, '62', 'Male', 'BHILMAAN , JALOR,RAJAATHAN', '19', '448', '17', '9983135505', '8849631984', NULL, 'VIJAY DEVASI', '2024-07-06 14:12:30', '2024-07-06 14:12:30', NULL),
(10, 'DHCP202410', 'DHC', 'MRS.SAROJ MAPARA', NULL, NULL, 'Female', 'C 204, SURAMYA COMPLEX, NR RENAISSANCE HOTEL, GHATLODIYA,OPP. KARGIL PETROL PUMP, SG HIGHWAY,AHED', '5', '125', '11', '9909923903', NULL, NULL, 'MR. VIVEK N MAPARA (DISTRICT JUDGE)', '2024-07-06 14:16:25', '2024-07-15 14:53:09', NULL),
(11, 'DHCP202411', 'DHC', 'MRS. KIRAN TIWARI', NULL, NULL, 'Female', 'GALA HEAVEN,', '5', '125', '16', '9979622299', NULL, NULL, 'AMIT TIWARI', '2024-07-06 14:17:42', '2024-07-15 14:52:32', '2024-07-15 14:52:32'),
(12, 'DHCP202412', 'DHC', 'Abhishek Chaturvedi', NULL, '28', 'Male', '303 Vedanta, Opp. Oosmanpura Garden', '5', '125', '3', '7999200504', NULL, 'abhishek.budtech@gmail.com', NULL, '2024-07-11 12:20:36', '2024-07-15 14:50:23', '2024-07-15 14:50:23'),
(13, 'DHCP202413', 'DHC', 'Rinkal', NULL, '24', 'Female', '303 Vedanta, Opp. Oosmanpura Garden', '5', '125', '1', '6367967862', NULL, 'rinkal.budtech@gmail.com', NULL, '2024-07-11 12:21:41', '2024-07-12 13:39:12', '2024-07-12 13:39:12'),
(14, 'DHCP202414', 'DHC', 'Kartik', NULL, '25', 'Male', '303, The pearl', '5', '125', '14', '6478965234', NULL, 'kartik.budtech@gmail.com', NULL, '2024-07-11 12:25:43', '2024-07-15 14:50:16', '2024-07-15 14:50:16'),
(15, 'DHCP202415', 'DHC', 'test', NULL, '25', 'Male', '303, The pearl', '5', '125', '1', '6367967862', NULL, 'kartik.budtech@gmail.com', NULL, '2024-07-11 13:34:09', '2024-07-15 14:50:03', '2024-07-15 14:50:03'),
(16, 'DHCP202411', 'SHALBY HOSPITAL SG RD', 'RAJKUMAR SANEJA', NULL, NULL, 'Male', 'NO.1 AMRAKADAM SOCIETY BUN. 1 OPP. RAMDEVNAGAR TEKRA AANAND NAGAR RD AHMEDABAD', '5', '125', '25', '9825660898', NULL, NULL, 'BHAVIK SIR', '2024-07-18 13:26:56', '2024-07-27 14:28:52', '2024-07-27 14:28:52'),
(17, 'DHCP202412', 'DHC', 'MR. DILIPKUMAR SAWLANI', NULL, NULL, 'Male', 'LIFE CARE HOSPITAL', '5', '125', '20', '9016124882', NULL, NULL, 'SANAJY SAWALANI', '2024-07-18 15:02:09', '2024-07-18 15:02:09', NULL),
(18, 'DHCP202413', 'DHC', 'RAVI SANGHI', NULL, NULL, 'Male', 'B/H SAKET-1,NEAR SP RING ROAD BOPAL CHAR RASTA,AHMEDABAD,GUJARAT', '5', '125', '3', '9755722679', NULL, NULL, 'DEVEN SIR', '2024-07-25 14:34:51', '2024-07-25 14:34:51', NULL),
(19, 'DHCP202414', 'DHC', 'MRS.ARUNA J. PANCHAL', NULL, NULL, 'Female', 'JUSTICE J.M.PANCHAL,BUNGLOWS NO.50.SHREENATH PARK SOCIETY,OPP.PUNIT NAGARSOCIETY, NEAR SHALIGRAM BUILDING,UMIYAVIJAY LANE, JASI KI RANI STATUE,SATELLITE', '5', '125', '14', '9913210772', NULL, NULL, 'DEVEN SIR', '2024-07-25 15:37:19', '2024-07-25 15:37:19', NULL),
(20, 'DHCP202415', 'DHC', 'JAYSHREE BEN D SHAH', NULL, NULL, 'Female', 'B/1002,PARISHRAM TOWER,ANKUR NARANPUR NARANPURA AHEMDABAD', '5', '125', '76', '9426289822', NULL, NULL, 'MEGHNA SHAH', '2024-07-25 17:25:01', '2024-07-25 17:25:01', NULL),
(21, 'DHCP202416', 'DHC', 'MR. RAMESHBHAI KOTHARI', NULL, NULL, 'Male', 'SHREY HOMES, OPP STHANAKWASI UPASHRAY,NEAR MERITORIOUS HOTEL COMMERCE SIX ROAD,AHMEDABAD', '5', '125', '77', '9558111375', NULL, NULL, 'ANSHI KOTHARI', '2024-07-25 17:27:28', '2024-07-25 17:27:28', NULL),
(22, 'DHCP202417', 'DHC', 'V.K. IYER', NULL, NULL, 'Male', 'K/1201 ORCHARD APARTMENT, GODREJ GARDEN CITY,JAGATPUR, AHEMDABAD', '5', '125', '78', '9898362557', NULL, NULL, 'JANARDHAN', '2024-07-25 17:29:24', '2024-07-25 17:29:24', NULL),
(23, 'DHCP202418', 'DHC', 'HASMUKH MEWADA', NULL, NULL, 'Male', 'PLOT NO 98 SECTOR NO.19 GANDHINAGAR', '5', '133', '12', '9824014021', NULL, NULL, 'MIHIR GANDHINAGAR', '2024-07-25 17:31:23', '2024-07-25 17:31:23', NULL),
(24, 'DHCP202419', 'DHC', 'SONAM AILANI', NULL, NULL, 'Female', 'B-503 SAMARPAN TOWER,132FT RING ROAD NARANPURA, AHMEDABAD', '5', '125', '76', '7202880899', NULL, NULL, 'KIRAN MA\'AM', '2024-07-25 17:32:42', '2024-07-25 17:32:42', NULL),
(25, 'DHCP202420', 'DHC', 'DHRUVKUMAR MEHTA', NULL, NULL, 'Male', '302.HIMALAYA OASIS,	OPP SHRADHHA SCHOOL  BH  VATSRAJ FLATS,JODHPUR GAM ROAD,SATELLITE AHMEDABAD', '5', '125', '14', '9428508380', NULL, NULL, 'MITTAL MEHTA', '2024-07-25 17:34:30', '2024-07-25 17:34:30', NULL),
(26, 'DHCP202421', 'DHC', 'MR.JSK.DHIREN BHATT/JAYESH BHATT', NULL, NULL, 'Male', 'SHIVNAGAR SOCIETY,CHANAKYAPURI BRIDGENICHE,MUNICIPAL OFFICE SAME,AHMEDABAD', '5', '125', '10', '9427333299', NULL, NULL, 'DHIREN BHATT', '2024-07-25 17:36:40', '2024-07-25 17:36:40', NULL),
(27, 'DHCP202422', 'DHC', 'ARJINDER KAUR', NULL, NULL, 'Female', 'E 301 DEV VRUSHTINAGAR	 CHANDKHEDA,AHMEDABAD', '5', '125', '79', '7284011257', NULL, NULL, 'SALU', '2024-07-25 17:45:30', '2024-07-25 17:45:30', NULL),
(28, 'DHCP202423', 'DHC', 'KRUPABEN BHATT', NULL, NULL, 'Female', 'A-404/SHUKAN STATUS(A TO E),BEHIND PHONE WALA SHOP, OPP SHUKAN RESIDENCY,NEAR VANDEMATARAM CROSS ROAD, NEW S.G.ROAD, GOTA, AHMEDABAD', '5', '125', '80', '9426253275', NULL, NULL, 'ASHVINBHAI G. BHATT', '2024-07-25 17:47:21', '2024-07-25 17:47:21', NULL),
(29, 'DHCP202424', 'DHC', 'MR MUPAJI M CHANDORA', NULL, NULL, 'Male', 'E 102 SHRI HARI ARJUN CHANAKYAPURI BRIDGE KE NICHE GHATLODIYA ,AHMEDABAD', '5', '125', '11', '8849388303', NULL, NULL, 'KANTI LAL GARG', '2024-07-25 17:54:58', '2024-07-25 17:54:58', NULL),
(30, 'DHCP202425', 'DHC', 'MR. MUKESHBHAI MAKATI', NULL, NULL, 'Male', 'A/3, MANIBHADRA APPT.,NEW GIRDHAR PARK SOCIETY, S.M. ROAD ,AMBAWADI,AHMEDABAD', '5', '125', '81', '9427215481', NULL, NULL, 'BHAKTI MAKATI', '2024-07-25 17:56:28', '2024-07-25 17:56:28', NULL),
(31, 'DHCP202426', 'DHC', 'KAMLA SINHA', NULL, NULL, 'Female', 'B7-402 WATER LILY SHANTIGRAM TOWNSHIP SG HIGHWAY, AHMEDABAD', '5', '125', '82', '798265669', NULL, NULL, 'ASHA KUMARI', '2024-07-25 17:57:59', '2024-07-25 17:57:59', NULL),
(32, 'DHCP202427', 'DHC', 'BABULAL PATHAK', NULL, NULL, 'Male', 'A 701, SHALIN 6, NEAR SMART BAZAR,VAVOL ,GANDHINAGAR', '5', '133', '83', '9328578094', NULL, NULL, 'POOJA PATHAK', '2024-07-25 18:01:15', '2024-07-25 18:01:15', NULL),
(33, 'DHCP202428', 'SHALBY HOSPITAL SG RD', 'RAJKUMAR SANEJA', NULL, NULL, 'Male', '1 AMRAKADAM SOC. BUN. 1 OPP. RAMDEVNAGAR TEKRO NR. PLENATE HEALTH', '5', '125', '82', '9825660898', NULL, NULL, 'BHAVIK SIR', '2024-07-25 18:03:55', '2024-07-27 14:28:05', '2024-07-27 14:28:05'),
(34, 'DHCP202429', 'DHC', 'HETAL SHAH', NULL, NULL, 'Female', '901,SHARANYA BELLEVUE,	OPP HARIHARASHRA BUNGLOW, NEAR BAGBAN PARTY PLOT,THALTEJ,AHMEDABAD', '5', '125', '84', '8128486677', NULL, NULL, 'DR.HETAL SHAH', '2024-07-25 18:03:59', '2024-07-27 14:24:35', '2024-07-27 14:24:35'),
(35, 'DHCP202430', 'SHALBY HOSPITAL SG RD', 'VIKRAM SING', NULL, NULL, 'Male', 'C-1201 SWATI CRIMON NR VENETIAN VILLAS SHILAJ', '5', '125', '85', '9879001771', NULL, NULL, 'MOMITA MEDAM', '2024-07-25 18:07:43', '2024-07-27 14:27:52', '2024-07-27 14:27:52'),
(36, 'DHCP202431', 'SHALBY HOSPITAL SG RD', 'INDRADEV SINGH', NULL, NULL, 'Male', 'C-501 MALABAR COUNTY 2 BEHIND NIRMA UNIVERSITY', '5', '125', '16', NULL, NULL, NULL, 'MEET SIR', '2024-07-25 18:09:23', '2024-07-27 14:27:41', '2024-07-27 14:27:41'),
(37, 'DHCP202432', 'SHALBY HOSPITAL SG RD', 'SARYUBALA SHAH', NULL, NULL, 'Male', '18 NEETI BAUGH  JUDGES BUNGLOW SOLA', '5', '125', '4', NULL, NULL, NULL, 'MEET SIR', '2024-07-25 18:10:36', '2024-07-27 14:27:33', '2024-07-27 14:27:33'),
(38, 'DHCP202433', 'SHALBY HOSPITAL SG RD', 'GULABBHAI PARIKH', NULL, NULL, 'Male', 'UPPER FLOOR  SATKAR BUILDING BEHIND SWAGAT BLDG CG ROAD ELLISHBRIDGE', '5', '125', '86', NULL, NULL, NULL, 'BHAVIK SIR', '2024-07-25 18:13:16', '2024-07-27 14:27:20', '2024-07-27 14:27:20'),
(39, 'DHCP202434', 'SHALBY HOSPITAL SG RD', 'SANDIT SHAH', NULL, NULL, 'Female', 'B-81 ZODIAC ASTER  NR INTERNATIONAL SCHOOL MANALI TOWER BODAKDEV', '5', '125', '3', NULL, NULL, NULL, 'BHAVIK SIR', '2024-07-25 18:15:31', '2024-07-27 14:28:15', '2024-07-27 14:28:15'),
(40, 'DHCP202435', 'SHALBY HOSPITAL SG RD', 'MUHAMMAD ARBAAZ MASTER', NULL, NULL, 'Male', '807 TAJ HOTEL BOPAL', '5', '125', '3', NULL, NULL, NULL, 'MOMITA MEDAM', '2024-07-25 18:16:58', '2024-07-27 14:27:08', '2024-07-27 14:27:08'),
(41, 'DHCP202436', 'SHALBY HOSPITAL SG RD', 'MINABEN', NULL, NULL, 'Female', 'B/402 15 THE ADDRESS NR ANTRIKSH NAGAR', '5', '125', '22', NULL, NULL, NULL, 'BHAVIK SIR', '2024-07-25 18:18:26', '2024-07-27 14:28:23', '2024-07-27 14:28:23'),
(42, 'DHCP202437', 'SHALBY HOSPITAL SG RD', 'A U PATEL', NULL, NULL, 'Male', 'KISHOR COLONY VIJAYNAGAR METRO STATION NARANPURA', '5', '125', '76', NULL, NULL, NULL, 'ANUKRUTI MEDAM', '2024-07-25 18:21:24', '2024-07-25 18:21:24', NULL),
(43, 'DHCP202438', 'SHALBY HOSPITAL SG RD', 'NANDINI NAYAN', NULL, NULL, 'Female', '1 SHIVALIK GREENS NR SHARDA SCHOOL AMBLI', '5', '125', '3', NULL, NULL, NULL, 'ANUKRUTI MEDAM', '2024-07-25 18:23:13', '2024-07-25 18:23:13', NULL),
(44, 'DHCP202439', 'SHALBY HOSPITAL SG RD', 'BHUDHISHCHANDRA MODI', NULL, NULL, 'Male', 'MANEKBAUGH GATE NO 7 AMBAVADI', '5', '125', '81', NULL, NULL, NULL, 'ANUKRUTI MEDAM', '2024-07-25 18:24:55', '2024-07-27 14:24:12', '2024-07-27 14:24:12'),
(45, 'DHCP202440', 'DHC', 'MRS.DALJIT SINGH', NULL, NULL, 'Female', 'C-16,THE NORTH PARK,ADANI SHANTIGRAM', '5', '125', '89', '991033813', NULL, NULL, 'DEVEN SIR', '2024-07-26 14:01:12', '2024-07-26 14:01:12', NULL),
(46, 'DHCP202441', 'DHC', 'MR.PANKAJ J SHAH', NULL, NULL, 'Female', '506,5TH FLOOR ARTHAM HOSPITAL,AMBAWADI AHMEDABAD', '5', '125', '81', '9909950009', NULL, NULL, 'RIKIN SHAH', '2024-07-26 14:05:25', '2024-07-26 14:05:25', NULL),
(47, 'DHCP202442', 'DHC', 'MR.RAJESH M. MUNSHI', NULL, NULL, 'Male', '479/1,SEC.7B GANDHINAGAR', '5', '133', '90', '9724326427', NULL, NULL, 'RUTVI BIN 9825725285', '2024-07-26 14:07:19', '2024-07-26 14:07:19', NULL),
(48, 'DHCP202443', 'DHC', 'MR.JATIN J SHAH', NULL, NULL, 'Male', '58,LAVANYA SOC.NEAR JIVRAJ, HOSPITAL VASNA ,AHMEDABAD', '5', '125', '91', '9574015520', NULL, NULL, 'JATIN PATIN', '2024-07-26 14:08:52', '2024-07-26 14:08:52', NULL),
(49, 'DHCP202444', 'DHC', 'MR.RAJKUMAR PATHAK', NULL, NULL, 'Male', 'C-802, GALA AURA NEAR AAROHI CHREST SOUTH BOPAL,AHMEDABAD', '5', '125', '92', '9925000497', NULL, NULL, 'MONIKA MAAM', '2024-07-26 14:10:43', '2024-07-26 14:10:43', NULL),
(50, 'DHCP202445', 'DHC', 'MRS. MEENA AGRWAL', NULL, NULL, 'Female', 'BUNGLOW NO. 7 NISHANT PART 2 OPP. AMBIKA PAN PARLOUR NR. BILESHWAR MAHADEV MANDIR SHYAMAL CROSS RD SATTLITE, AHED', '5', '125', '14', '9327015311', '9825034995', NULL, 'MINA BEN', '2024-07-26 14:12:22', '2024-07-26 14:12:22', NULL),
(51, 'DHCP202446', 'DHC', 'MRS.NIRMALA JAIN', NULL, NULL, 'Female', 'A 401,PRAYAG RESIDANCY B/H GRAND BHAGWATI OPP.NIRMA HIGH SCHOOL BADAKDEV,AHMEDABAD', '5', '125', '93', '9879275525', NULL, NULL, 'ANUJ SHAH', '2024-07-26 14:14:57', '2024-07-26 14:14:57', NULL),
(52, 'DHCP202447', 'DHC', 'KOKILABEN SHASHIKANTBHAI SHAH', NULL, NULL, 'Female', '25 DARSHAN BUNGLOWS,OPP-NAGAR PALIKA	 OFFICE, BOPAL,AHMEDABAD', '5', '125', '3', '7622960891', NULL, NULL, 'SWATI DIDI', '2024-07-26 14:23:56', '2024-07-26 14:23:56', NULL),
(53, 'DHCP202448', 'DHC', 'MRS.MUKULNANDA /68', NULL, NULL, 'Female', '2,THAKOR PARK SOCIETY B/H ANKUR SCHOOL FETEHPURA PALDI ,AHEMDABAD', '5', '125', '1', '9825005005', '9737054443', NULL, 'RAMENDRA', '2024-07-26 14:25:58', '2024-07-26 14:25:58', NULL),
(54, 'DHCP202449', 'DHC', 'MRS.ASHA VERMA', NULL, '83', 'Female', 'D404,SATYAM STATUS JODHPUR GAM SATELLITE,AHMEDABAD', '5', '125', '24', '8320442944', NULL, NULL, 'KANIKA MAAM', '2024-07-26 14:28:18', '2024-07-26 14:28:18', NULL),
(55, 'DHCP202450', 'DHC', 'MOHINI CHADHA', NULL, '86', 'Female', '1 JAYANTILAL PARK AMLI BOPAL ROAD OPP BRTS, AHEMDABAD ,380058', '5', '125', '94', '5713313130', NULL, NULL, 'ARPANA PURI', '2024-07-26 14:30:46', '2024-07-26 14:30:46', NULL),
(56, 'DHCP202451', 'DHC', 'DIPAK KUMAR PATEL', NULL, NULL, 'Male', 'D 401 SATYAMEV VISTA GOTA CROSS ROAD, GOTA,AHMEDABAD', '5', '125', '80', '9581810001', NULL, NULL, 'DHRUTI MAM', '2024-07-26 14:33:17', '2024-07-26 14:33:17', NULL),
(57, 'DHCP202452', 'DHC', 'FALGUN PATEL', NULL, NULL, 'Female', '26,,27 PANCHMRUT VASTU VILLA,NEAR MURLITHER PARTY PLOT SOLA SCIENCE CITY,AHMEDABAD', '5', '125', '95', '9825435626', NULL, NULL, 'DR.DINESH', '2024-07-26 15:24:25', '2024-07-26 15:24:25', NULL),
(58, 'DHCP202453', 'DHC', 'LEELA MOHANDAS GULWANI', NULL, NULL, 'Female', 'KHUSHRAAZI BRAHMAKUMARIS,SINGARWA,AHMEDABAD', '5', '125', '96', '9561818340', NULL, NULL, 'KAVITA MA\'AM', '2024-07-26 15:26:37', '2024-07-26 15:26:37', NULL),
(59, 'DHCP202454', 'DHC', 'CHHIMACHHARI DEVI HAGAR', NULL, NULL, 'Female', '32,PARK HILL BUNGLOW ,OPP SATYA TRIVENI TOWER,OPP. KARNAVATI CLUB,BEHIND SHALBY HOSPITAL, RAMDEVNAGAR', '5', '125', '21', '9898098900', NULL, NULL, 'SANJEEV SIR', '2024-07-26 15:27:46', '2024-07-26 15:27:46', NULL),
(60, 'DHCP202455', 'DHC', 'MR MADAN MOHAN PRASAD', NULL, NULL, 'Male', 'A/1202 RATNAKAAR VERTE, NEAR S.P. ROAD, OPP.AROHI HOMES BUNGALOWS,SOUTH BOPAL,AHMEDABAD', '5', '125', '92', '9867791435', NULL, NULL, 'MANISH PRASAD', '2024-07-26 15:29:14', '2024-07-26 15:29:14', NULL),
(61, 'DHCP202456', 'DHC', 'ARUNA SHAH', NULL, '75', 'Female', '804,ACHAL REPOSE, OPP SARDAR PATEL SEVA SAMAJ HALL,NEAR GIRISH COLDDRINK CROSS ROADS,	MITHAKHALI,AHMEDABAD', '5', '125', '77', '982403312', NULL, NULL, 'ADIT MA\'AM', '2024-07-26 15:33:08', '2024-07-26 15:33:08', NULL),
(62, 'DHCP202457', 'DHC', 'SHAILESH SHETH', NULL, NULL, 'Male', '601 ARIHANT AURA NAVYUG SOCIETY PATEL COLONY AMBAWADI ,AHMEDABAD GUJARAT', '5', '125', '81', '9920407566', NULL, NULL, 'USHMA', '2024-07-26 15:35:06', '2024-07-26 15:35:06', NULL),
(63, 'DHCP202458', 'DHC', 'MRS.MIRABEN CHAUDHARY', NULL, NULL, 'Female', '402 SEPAL GARNET,DHS HOSPITAL 601 NEAR SHELL PETROLEUM 100FEET ROAD  PRAHLADNAGAR, AHMEDABAD', '5', '125', '97', NULL, NULL, NULL, 'LILESH CHOUDHURY', '2024-07-26 15:36:44', '2024-07-26 15:36:44', NULL),
(64, 'DHCP202459', 'DHC', 'BIPINBHAI SHETH', NULL, NULL, 'Male', 'D- 301 ASAWARI TOWERS BEHIND WIDE ANGLE AHMEDABAD,ZYDUS HOSPITAL 1040', '5', '125', '82', '9687652900', NULL, NULL, 'FALGUNI MA\'AM', '2024-07-26 15:38:44', '2024-07-26 15:38:44', NULL),
(65, 'DHCP202460', 'DHC', 'JYOTI GURBAXANI', NULL, NULL, 'Female', 'B-304,3RD FLOOR,JAY YOGESHWAR COMPLEX,NEAR SHUKAN SKY, KUDASAN,GHANDHINAGAR', '5', '133', '98', '8849847976', NULL, NULL, 'SHILPA MA\'AM', '2024-07-26 15:40:52', '2024-07-26 15:40:52', NULL),
(66, 'DHCP202461', 'DHC', 'MEENA KAPOOR', NULL, NULL, 'Female', 'B-2/1602, MEADOWS ,ADANI SHANTIGRAM,AHMEDABAD', '5', '125', '89', '9099914304', NULL, NULL, 'DEVEN SIR', '2024-07-26 15:42:28', '2024-07-26 15:42:28', NULL),
(67, 'DHCP202462', 'DHC', 'DHARA VASA', NULL, NULL, 'Female', '4/A RAGHAV FALTS, 55 CHAITNYANAGAR SOCIETY NEAR LAKHUDI TALAV, OPP SEVIOUR HOSPITAL, STEDIUM,NAVRANGPURA ,AHMEDABAD', '5', '125', '99', '9558356636', NULL, NULL, 'MAYA HOPE', '2024-07-26 15:44:23', '2024-07-26 15:44:23', NULL),
(68, 'DHCP202463', 'DHC', 'LAKHIRAM P', NULL, NULL, 'Male', '18/AWAMI TEORAM PARK SOCIETY,OPP KISHORE ENGLISH SCHOOL,BUNGLOW AREA,KUBERNAGAR,AHMEDABAD', '5', '125', '100', NULL, NULL, NULL, 'PT KAPIL', '2024-07-26 15:46:20', '2024-07-26 15:46:20', NULL),
(69, 'DHCP202464', 'DHC', 'BHIKHA BHAI', NULL, NULL, 'Male', 'D/402,HELICONIA APARTMENTS	 NEAR THALTEJ SHILAY OVER BRIDGE,SHILAJ,	AHMEDABAD', '5', '125', '85', '9727722720', NULL, NULL, 'SWETA PATEL', '2024-07-27 13:39:44', '2024-07-27 13:39:44', NULL),
(70, 'DHCP202465', 'DHC', 'HETAL SHAH', NULL, NULL, 'Female', '901,SHARANYA BELLEVUE,	OPP HARIHARASHRA BUNGLOW, NEAR BAGBAN PARTY PLOT,THALTEJ,AHMEDABAD', '5', '125', '84', '8128486677', NULL, NULL, 'HETAL SHAH', '2024-07-27 15:01:31', '2024-07-27 15:01:31', NULL),
(71, 'DHCP202466', 'SHALBY HOSPITAL SG RD', 'RAJKUMAR SANEJA', NULL, NULL, 'Male', 'NO. 1 AMRAKADAM SOC. BUN. 1 OPP. RAMDEVNAGAR TEKRO NR. PLENATE HEALTH AANDNAGAR RD.', '5', '125', '25', '9825660898', NULL, NULL, 'BHAVIK SIR', '2024-07-27 15:50:32', '2024-07-27 15:50:32', NULL),
(72, 'DHCP202467', 'SHALBY HOSPITAL SG RD', 'MR.VIKRAM SING', NULL, NULL, 'Male', 'C -1201,SWATI CRIMON ,NR,VENETIAN VILLAS,SHILAJ DASKROJ', '5', '125', '85', '9879001771', NULL, NULL, 'MOMITA MAAM', '2024-07-27 15:53:06', '2024-07-27 15:53:06', NULL),
(73, 'DHCP202468', 'SHALBY HOSPITAL SG RD', 'MR INDRADEV SINGH', NULL, NULL, 'Male', 'C-501 MALABAR COUNTY 2 BEHIND NIRMA UNIVERSITY  SG ROAD', '5', '125', '82', '9879001771', NULL, NULL, 'MEET SIR', '2024-07-27 15:54:52', '2024-07-27 15:54:52', NULL),
(74, 'DHCP202469', 'SHALBY HOSPITAL SG RD', 'MRS SARYUBALA SHAH', NULL, NULL, 'Female', '18 NEETI BAUGH  JUDGES BUNGLOW SOLA AHMEDABAD', '5', '125', '4', '9879001771', NULL, NULL, 'MEET SIR', '2024-07-27 15:56:03', '2024-07-27 15:56:03', NULL),
(75, 'DHCP202470', 'SHALBY HOSPITAL SG RD', 'MR GULABBHAI PARIKH', NULL, NULL, 'Male', 'UPPER FLOOR  SATKAR BUILDING BEHIND SWAGAT BLDG CG ROAD ELLISHBRIDGE', '5', '125', '86', '9825660898', NULL, NULL, 'BHAVIK SIR', '2024-07-27 15:57:23', '2024-07-27 15:57:23', NULL),
(76, 'DHCP202471', 'SHALBY HOSPITAL SG RD', 'MRS SANDIT SHAH', NULL, NULL, 'Female', 'B-81 ZODIAC ASTER  NR INTERNATIONAL SCHOOL		 MANALI TOWER BODAKDEV', '5', '125', '93', NULL, NULL, NULL, 'BHAVIK SIR', '2024-07-27 15:58:31', '2024-07-27 15:58:31', NULL),
(77, 'DHCP202472', 'SHALBY HOSPITAL SG RD', '9.MR MUHAMMAD ARBAAZ MASTER  807', NULL, NULL, 'Male', 'TAJ HOTEL BOPAL', '5', '125', '3', NULL, NULL, NULL, 'MOMITA MAAM', '2024-07-27 15:59:17', '2024-07-27 15:59:17', NULL),
(78, 'DHCP202473', 'SHALBY HOSPITAL SG RD', 'BHAVIK SIR', NULL, NULL, 'Female', 'B/402 15 THE ADDRESS NR ANTRIKSH NAGAR', '5', '125', '22', NULL, NULL, NULL, 'BHAVIK SIR', '2024-07-27 16:00:42', '2024-07-27 16:00:42', NULL),
(79, 'DHCP202474', 'SHALBY HOSPITAL SG RD', 'MR A U PATEL', NULL, NULL, 'Male', 'KISHOR COLONY VIJAYNAGAR METRO STATION NARANPURA', '5', '125', '76', NULL, NULL, NULL, 'ANUKRUTI MAAM', '2024-07-27 16:01:49', '2024-07-27 16:01:49', NULL),
(80, 'DHCP202475', 'SHALBY HOSPITAL SG RD', 'MRS.JASODA KARANCHANDANI', NULL, NULL, 'Female', 'ROOM NO :711', '5', '125', '82', NULL, NULL, NULL, 'ANUKRUTI MAAM', '2024-07-27 16:04:47', '2024-07-27 16:04:47', NULL),
(81, 'DHCP202476', 'SHALBY HOSPITAL SG RD', 'MRS NITA HANSOTI', NULL, NULL, 'Female', '7 SHIVALIKA GREEN AMBALI VILLAGE', '5', '125', '94', NULL, NULL, NULL, 'BHAVIK SIR', '2024-07-27 16:05:49', '2024-07-27 16:05:49', NULL),
(82, 'DHCP202477', 'SHALBY HOSPITAL SG RD', 'VIRAL BEN', NULL, NULL, 'Female', 'ROOM NO SHALBY HOSPITAL', '5', '125', '22', NULL, NULL, NULL, 'ANUKRUTI MEDAM', '2024-07-29 14:40:40', '2024-07-29 14:40:40', NULL),
(83, 'DHCP202478', 'DHC', 'PRAVIN KUMAR', NULL, NULL, 'Male', 'B-32, ORCHID PARK NEAR ANJANI TOWER, BEHIND SHALBY HOSPITAL, RAMDEV NAGAR,AHMEDABAD,GUJARAT', '5', '125', '21', '8866444040', NULL, NULL, 'RATHI SIR', '2024-07-29 17:52:46', '2024-07-29 17:52:46', NULL),
(84, 'DHCP202479', 'DHC', 'ANJANA  SHAH', NULL, NULL, 'Female', 'AKSHARDHAM TOWERS,NEAR SAHIBAGH UNDERBRIDGE,AHMEDABAD', '5', '125', '113', '9811468935', NULL, NULL, 'DR.VIKASH', '2024-08-02 14:04:44', '2024-08-02 14:04:44', NULL);

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
(1, 'S-Admin', '[\"dashboard\",\"dhc_dashboard\",\"hsp_dashboard\",\"crp_dashboard\",\"analytics\",\"create_booking\",\"bookings\",\"closed_bookings\",\"assign_bookings\",\"staff_attendance\",\"booking_reviews\",\"active_invoice\",\"closed_invoice\",\"salary\",\"advance_salary\",\"staff\",\"doctors\",\"patients\",\"corporates\",\"users\",\"roles\",\"staff_salary_report\",\"started_booking_report\",\"paused_booking_report\",\"hospitals\",\"shifts\",\"equipments\",\"ambulance\",\"staff_type\",\"states\",\"cities\",\"area\"]', '2024-05-10 13:05:29', '2024-08-09 15:19:26', NULL),
(2, 'Admin', '[\"dhc_dashboard\",\"hsp_dashboard\",\"crp_dashboard\",\"analytics\",\"create_booking\",\"bookings\",\"closed_bookings\",\"assign_bookings\",\"staff_attendance\",\"booking_reviews\",\"active_invoice\",\"closed_invoice\",\"salary\",\"advance_salary\",\"staff\",\"doctors\",\"patients\",\"corporates\",\"staff_salary_report\",\"started_booking_report\",\"paused_booking_report\",\"hospitals\",\"shifts\",\"equipments\",\"ambulance\",\"staff_type\",\"states\",\"cities\",\"area\"]', '2024-05-10 07:47:32', '2024-10-10 02:18:40', NULL),
(7, 'DARSHNA JI SHALBY MANAGER', '[\"hsp_dashboard\",\"crp_dashboard\",\"analytics\",\"create_booking\",\"bookings\",\"closed_bookings\",\"assign_bookings\",\"staff_attendance\",\"booking_reviews\",\"active_invoice\",\"closed_invoice\",\"salary\",\"staff\",\"doctors\",\"patients\",\"corporates\",\"staff_salary_report\",\"paused_booking_report\",\"hospitals\",\"shifts\",\"staff_type\",\"states\",\"cities\",\"area\"]', '2024-06-18 22:59:08', '2024-07-16 14:54:53', NULL),
(8, 'Manager', '[\"dhc_dashboard\",\"create_booking\",\"active_invoice\",\"closed_invoice\"]', '2024-07-11 14:20:33', '2024-07-16 14:05:15', '2024-07-16 14:05:15'),
(9, 'NISHA PATEL ACCOUNTANT', '[\"dhc_dashboard\",\"hsp_dashboard\",\"crp_dashboard\",\"analytics\",\"create_booking\",\"bookings\",\"closed_bookings\",\"assign_bookings\",\"staff_attendance\",\"booking_reviews\",\"active_invoice\",\"closed_invoice\",\"salary\",\"advance_salary\",\"staff\",\"doctors\",\"patients\",\"corporates\",\"staff_salary_report\",\"paused_booking_report\",\"hospitals\",\"shifts\",\"equipments\",\"ambulance\",\"staff_type\",\"states\",\"cities\",\"area\"]', '2024-07-16 14:51:34', '2024-08-09 13:00:14', NULL),
(10, 'PRASHANT JI DHC', '[\"dhc_dashboard\",\"create_booking\",\"bookings\",\"closed_bookings\",\"assign_bookings\",\"staff_attendance\",\"booking_reviews\",\"staff\",\"doctors\",\"patients\",\"corporates\",\"staff_salary_report\",\"paused_booking_report\",\"shifts\",\"states\",\"cities\",\"area\"]', '2024-07-16 14:52:17', '2024-08-03 18:22:52', NULL),
(11, 'test', '[\"dhc_dashboard\",\"hsp_dashboard\",\"crp_dashboard\",\"analytics\",\"create_booking\",\"bookings\",\"assign_bookings\",\"staff_attendance\",\"active_invoice\",\"salary\",\"advance_salary\",\"staff\",\"doctors\",\"patients\",\"corporates\",\"staff_salary_report\",\"paused_booking_report\",\"ambulance\"]', '2024-08-06 17:20:09', '2024-08-06 17:22:42', '2024-08-06 17:22:42');

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
  `status` int(11) NOT NULL DEFAULT 1 COMMENT '0=inactive, 1=active	',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`id`, `staff_id`, `f_name`, `m_name`, `l_name`, `password`, `type`, `email`, `mobile`, `mobile2`, `dob`, `gender`, `address`, `state`, `city`, `area`, `bank_name`, `branch`, `ifsc_code`, `acc_no`, `day_cost`, `night_cost`, `full_cost`, `age`, `doj`, `experience`, `reference`, `qualification`, `specification`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'DHCS202401', 'VIKRAM', NULL, 'SINGH', '$2y$12$vqPC0PZw1QIxfWtQTDOkCOIkl9TAX3qFgI7VKCZZ5p03dpU2T0M.K', 2, 'superadmin@gmail.com', '9720243449', NULL, '1995-01-01', 'Male', 'BHIMSEN, PURA BANJARA ATMADPUR AJNERAAAGRA SAMSHADBAD', '23', '515', '5', 'VIKRAM SINGH', 'KOTEK MAHINDRA', 'KKBK0002560', '4948532708', 500, 500, 733, '30', '2021-06-01', '5', 'SELF', '12TH PASS', NULL, 1, '2024-06-18 17:58:40', '2024-06-18 17:58:40', NULL),
(2, 'DHCS202402', 'MAGAN', 'JAGADISH', 'BHAGORA', '$2y$12$Ab4l28ErUaFCv3Vk8SAWyuP2fJlYBDnUung1IHyB/1xkFUelLsKT.', 2, 'superadmin@gmail.com', '9863422234', NULL, '2001-07-01', 'Male', 'GARANWAS, PO, SOM UDAIPUR RAJ', '5', '125', '4', 'MAGAN LAL', 'PNB', 'PUNB0070700', '0707001700357898', 450, 450, 666, '25', '2023-06-01', '4', 'SELF', '12TH PASS', NULL, 1, '2024-06-18 18:10:22', '2024-06-18 18:10:22', NULL),
(3, 'DHCS202403', 'PAYAL', NULL, 'PARMAR', '$2y$12$3wZN2CZJtdkZ4x.v2ztkzuekqnjuWLuxzno4jf1oSs4i7caqC0agS', 2, NULL, '9510844199', '9653791543', '2001-06-01', 'Female', 'SOLA', '5', '125', '4', '-', '-', '-', '-', 466, 466, NULL, '23', '2023-06-02', '3', 'REETU PARMAR', '12TH', NULL, 1, '2024-06-18 23:36:16', '2024-06-18 23:36:16', NULL),
(4, 'DHCS202404', 'REETU', 'PRABHULAL', 'JOGI', '$2y$12$s7Y4XlJyT2J3gGCi3FmYVOJl2h6G4/B/9G.jp8J.1L8QzQsqrQQEi', 2, NULL, '9104654996', NULL, NULL, 'Female', 'SOLA', '5', '125', '1', '-', '-', '-', '-', 466, 466, NULL, '25', '2023-06-01', '4', 'SELF', '12TH', NULL, 1, '2024-06-18 23:40:27', '2024-06-18 23:40:27', NULL),
(5, 'DHCS202405', 'TEST', NULL, NULL, '$2y$12$8kLRaOjxdtCxuKY8MT81YOEzU2PQNqElwFPsY7f1LH447hssI8L1e', 4, NULL, NULL, NULL, NULL, 'Male', 'Dummy address', '5', '125', '9', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-06-24', '1', NULL, NULL, NULL, 1, '2024-06-24 20:32:44', '2024-06-24 20:36:25', '2024-06-24 20:36:25'),
(6, 'DHCS202405', 'PAWAN', NULL, 'GUJRATI', '$2y$12$t4KqP3MZiyWiYuLQulIONuV8Z.E2aucEXWizPJLDsqu41NX6be1Ua', 1, 'superadmin@gmail.com', '9510650243', NULL, '1999-12-28', 'Male', 'C/O: GRAM MUKHAJI RMARG JAWAD, TAHSIL JAWAD, JAWAD,NEEMUCH', '5', '125', '4', 'SBI', 'JAWAD', 'SBIN0030059', '42448927932', 800, 800, 1300, '24', '2022-06-03', '2', NULL, 'GNM  NURSING', NULL, 1, '2024-07-04 14:11:01', '2024-07-04 14:11:01', NULL),
(7, 'DHCS202406', 'NITIN', 'DAYABHAI', 'RATHOD', '$2y$12$G5BetWkyJ56ykx/ao1/0wexkus9s45CF4xNDD.AHhKidQSrasJ.uW', 2, 'superadmin@gmail.com', '7203939028', NULL, '1989-11-04', 'Male', 'W-4, SHIVKEDAR FLAT, CHANDLODIA,CHANDLODIA- 382481,TAL CITY,AHEMDABAD', '5', '125', '4', 'SBI', 'CHANDLODIYA', 'SBIN000015', '20130671459', 550, 500, 700, NULL, '2024-06-02', '3', NULL, '12TH', NULL, 1, '2024-07-04 14:32:28', '2024-07-12 20:11:18', NULL),
(8, 'DHCS202407', 'PAWAN', 'KUMAR', 'DESHANTRI', '$2y$12$pQ2LyJuDThIGEWC1ZcDFxuLPmITTv6iWONEmTwdyI1Qc.DK6SyY6m', 1, 'superadmin@gmail.com', '8824579296', NULL, '1996-06-19', 'Male', 'SADAR BAZAR, PIPLI ACHARYAN, RAJSAMAND, MAHALON KI PIPLI,RAJ.', '19', '458', '18', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '28', '2024-03-12', '5', NULL, 'GNM  NURSING', NULL, 1, '2024-07-06 18:29:58', '2024-07-06 18:29:58', NULL),
(9, 'DHCS202408', 'PAWAN', 'KUMAR', 'DESHANTRI', '$2y$12$0DVYvxHT7dRKUFzyLlvKY.h7hQBdXrEOwl8fnDVYw2h78gO5ASAM6', 1, 'superadmin@gmail.com', '8824579296', NULL, '1996-06-19', 'Male', 'SADAR BAZAR, PIPLI ACHARYAN, RAJSAMAND, MAHALON KI PIPLI,RAJ.', '19', '458', '18', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '28', '2024-03-12', '5', NULL, 'GNM  NURSING', NULL, 1, '2024-07-06 18:29:58', '2024-07-11 15:55:30', '2024-07-11 15:55:30'),
(10, 'DHCS202409', 'VANDANA', 'BHANUBHAI', 'TARAL', '$2y$12$m7Q6K6E3npjVmG196hPCxOBxh.qVRerYTMtpsYpK3iAVUXwno5yZi', 1, 'superadmin@gmail.com', NULL, NULL, '1997-06-22', 'Female', 'CHITARIYA, SABARKANTHA,JAB CHITARIYA,GUJRAT', '5', '145', '19', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '27', '2022-06-08', '5', NULL, NULL, NULL, 1, '2024-07-09 13:04:34', '2024-07-09 13:04:34', NULL),
(11, 'DHCS202410', 'Ayush', NULL, 'Kartik', '$2y$12$hYBbmTca8VTPEgFpna2a0eW/hspEiczgmY32F4cphex.IKF/qxTaG', 4, NULL, '4452646666', NULL, NULL, 'Male', '303, The pearl', '5', '125', '1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-05-01', '7', NULL, NULL, NULL, 1, '2024-07-11 12:39:54', '2024-07-11 13:21:37', '2024-07-11 13:21:37'),
(12, 'DHCS202411', 'Aryan', NULL, NULL, '$2y$12$UUlYBawGrKzXSOUj82EYTu47alSHnCTERMMcH/u7JDQBk5.O/zPhq', 4, NULL, '5578945621', NULL, NULL, 'Male', '12, tejendra aprk narayan pura', '5', '125', '20', NULL, NULL, NULL, NULL, 1000, 1500, 1800, NULL, '2024-06-01', '15', NULL, NULL, NULL, 1, '2024-07-11 12:44:23', '2024-07-11 13:21:31', '2024-07-11 13:21:31'),
(13, 'DHCS202410', 'Aryan', NULL, NULL, '$2y$12$3HKaLip/gtDo9vzjS3pmVe5kv84CXKtrTIdAOfBYlMOyoDySTLyzi', 1, NULL, '5578945621', NULL, NULL, 'Male', '12, tejendra aprk narayan pura', '5', '125', '3', NULL, NULL, NULL, NULL, 1000, 1500, 1800, NULL, '2024-05-01', '15', NULL, NULL, NULL, 1, '2024-07-11 13:46:40', '2024-07-15 15:08:20', '2024-07-15 15:08:20'),
(14, 'DHCS202410', 'VINOD', 'KANJIBHAI', 'PARMAR', '$2y$12$rWxPuCjfcss/dTsKPBq6jeNKA7MhmijBqEUmY.aeWNMH9EGwWWm5u', 2, 'VINODPARMAR@GMAIL.COM', '9408325172', NULL, '1974-04-27', 'Male', '4-110 VANKARVAS, VISNAGAR, MAHESANA,GUJRAT', '5', '138', '26', 'BANK OF INDIA', 'MEHSANA', 'BKID0002211', '221110410000658', 500, 500, 733, '50', '2022-06-01', '8', 'NAVIN', '10TH', 'RT FIDING', 1, '2024-07-18 13:41:13', '2024-07-18 13:41:13', NULL),
(15, 'DHCS202411', 'TORALBEN', 'TURPASHBHAI', 'BODAR', '$2y$12$PnGdnpDAVPiDxOxUBet0XOF6Hqe26.j4IaYl8BGgJy.7vbEFz06UW', 2, 'TORALBODAR@GMAIL.COM', '9408333178', '9638084590', '2003-01-02', 'Female', 'TINTARAN NULSARI VIJAY NAGAR', '5', '125', '27', NULL, NULL, NULL, NULL, 500, 500, 700, '21', '2024-07-01', '2', 'DEVEN SIR', 'GNM', 'RT FEEDING,SUCTION', 1, '2024-07-18 14:15:32', '2024-07-18 14:15:32', NULL),
(16, 'DHCS202412', 'KIRAN', 'BALA', 'ROAT', '$2y$12$KRhAzr/1mTo91law3SOBLu6t13zfPLxmJIkSYLCysrmiW0m8kK6Jm', 2, 'KIRANBALA@GMAIL.COM', '9024753695', '6376398718', '1999-06-28', 'Female', 'VILLAGE-KUMBELA,DUNGARPUR,RAJASTHAN', '19', '444', '28', NULL, NULL, NULL, NULL, 500, 500, 633, '25', '2024-07-01', '6', 'JAYDEEP', 'GNM', 'RT FEEDING,SUCTION', 1, '2024-07-18 14:23:39', '2024-07-18 14:23:39', NULL),
(17, 'DHCS202413', 'NIDHI', 'DINESH', NULL, '$2y$12$OoGFv75EeIHCeynbTDwCuOE9q4Rzm29M9vAxMHPC7kf65D3uodFpG', 2, 'NIDHI@GMAIL.COM', '6393784593', NULL, '1993-01-01', 'Female', 'JETAPUR', '23', '524', '29', NULL, NULL, NULL, NULL, 500, 500, 700, '21', '2024-02-01', '2', 'DEVEN SIR', '12 TH', 'DIAPER SPONGING RT FEEDING', 1, '2024-07-18 14:38:59', '2024-07-18 14:38:59', NULL),
(18, 'DHCS202414', 'VIKRAM', 'BHIMSEN', 'SINGH', '$2y$12$7t3DgEic1dJ7ue43ta0uQ.G55RmkKK6lXA.7qGfkrEMvItd2dKVwO', 2, 'VIKRAMSINGH@GMAIL.COM', '9720243449', NULL, '1994-01-01', 'Male', 'PURA BANJARA  AJNERA AGRA SAMSHADABAD AGRA', '23', '515', '5', NULL, NULL, NULL, NULL, NULL, NULL, 733, '28', '2023-07-01', '5', 'DEVEN SIR', '12 TH', 'RT FEEDING SUCTION', 1, '2024-07-18 14:48:10', '2024-07-18 14:48:10', NULL),
(19, 'DHCS202415', 'FARUKH', 'MOHOMAD', 'SINDHI', '$2y$12$rykcGZ6TOLox3Ha6Ms9U7uS.mgnzbUFnZwkMi8ZQHC.SNpBuUiicO', 2, NULL, '9023005116', '6325500850', '1978-06-20', 'Male', '1633 CHUDI OLE DAWA BAZAR PANKOR NAKA,AHMEDABAD,GUJARAT', '5', '125', '30', NULL, NULL, NULL, NULL, 466, 466, NULL, '46', '2024-07-15', '25', 'DEVEN SIR', '10TH', NULL, 1, '2024-07-18 15:46:14', '2024-07-18 15:46:14', NULL),
(20, 'DHCS202416', 'CHETAN', 'AMRUTBHAI', 'PANCHAL', '$2y$12$tZmMdPLss552Sd5BA/9v5uNwDCNvlCsuBHbjA5qKjkrgA.7THQGO.', 2, NULL, '8140683376', '9081811648', '1983-04-12', 'Male', '1002/2,CHELLO KHANCHO,NARIYA WAD NI POLE,SHAHPUR,AHMEDABAD,GUJARAT', '5', '125', '31', NULL, NULL, NULL, NULL, 466, 466, NULL, '41', '2024-07-15', '2', 'DEVEN SIR', '7 TH', NULL, 1, '2024-07-18 15:54:07', '2024-07-18 15:54:07', NULL),
(21, 'DHCS202417', 'HITENDRA', 'BADHABHAI', 'VADHER', '$2y$12$eiQNX90lmdOKeC23YKeDbOvTEwaziu8uuYWJKn0OcAnswLBaOYJvm', 2, NULL, '9638845548', '9726216170', '1969-07-21', 'Male', '120/62,CHORASHINI CHALI,OPP CHHIPA KABARSTAN,KANKARIYA,AHMEDABAD,GUJARAT', '5', '125', '32', NULL, NULL, NULL, NULL, 466, 466, NULL, '55', '2024-07-15', '22', 'DEVEN SIR', '10 TH', NULL, 1, '2024-07-18 16:03:42', '2024-07-18 16:03:42', NULL),
(22, 'DHCS202418', 'PRIYANKA', 'SUKHRAM', 'DIWAKAR', '$2y$12$9E0l/j9ceiVLWJE.ke19BuY24J9Qi/I/LP60vd5580epnyTTpls82', 2, NULL, '6359830695', NULL, '2002-11-05', 'Female', 'PARIDA NAGAR CIVIL AHMEDABAD', '5', '125', '33', NULL, NULL, NULL, NULL, 500, 500, 733, '20', '2022-12-06', '3', 'DEVEN SIR', '10TH', 'DIAPER SPONGING RT FEEDING', 1, '2024-07-18 16:09:35', '2024-07-18 16:09:35', NULL),
(23, 'DHCS202419', 'RATILAL', 'DALABHAI', 'CHAUHAN', '$2y$12$pZcSunWtta4edjO0HWYiGeSckVUuGJe9xFO.a86QHDjAbMeym6QS.', 2, NULL, '7863032389', '8128048929', '1983-12-01', 'Male', 'AHMEDABAD,GUJARAT', '5', '125', '31', NULL, NULL, NULL, NULL, 466, 466, NULL, '41', '2024-07-15', '7', 'DEVEN SIR', '11 TH', NULL, 1, '2024-07-18 16:12:35', '2024-07-18 16:12:35', NULL),
(24, 'DHCS202420', 'VARSHA', 'KANTILAL', 'MEENA', '$2y$12$mpncGc8eCg7EigjJ1J9bue9Q8LzYpBCIXKKTibQ634EOXrd1/hILa', 2, NULL, '8829816288', NULL, '2001-03-02', 'Female', 'GHATI DARWAJA RUSABH GHAT UDAIPUR RAJASTHAN', '19', '463', '34', NULL, NULL, NULL, NULL, NULL, NULL, 700, '23', '2024-01-12', '2', 'VIKRAM SINGH', '12 TH', 'DIAPER SPONGING', 1, '2024-07-18 16:15:52', '2024-07-18 16:15:52', NULL),
(25, 'DHCS202421', 'HASUMATI', 'JASWANT', 'SOLANKI', '$2y$12$Ox/p5iJn.wRN3UGX54eomuSHTq9lgID9ySqamDYMro/HlISnwE.Lm', 2, NULL, '9173433262', NULL, NULL, 'Female', 'AHMEDABAD,GUJARAT', '5', '125', '22', NULL, NULL, NULL, NULL, 466, 466, NULL, NULL, '2024-07-15', '22', 'DEVEN SIR', '10 TH', NULL, 1, '2024-07-18 16:17:15', '2024-07-18 16:17:15', NULL),
(26, 'DHCS202422', 'MANISH', 'BALDEVBHAI', 'RAMI', '$2y$12$RBZ0bm9mKM.BxAyaObXFPus5a9q684H8QrE1X51Qe.g5UMYjm964K', 2, NULL, '9106769103', NULL, '1980-07-29', 'Male', 'DARIYAPUR,AHMEDABAD', '5', '125', '35', NULL, NULL, NULL, NULL, 466, 466, NULL, '40', '2024-07-15', '22', 'DEVEN SIR', 'M.COM', NULL, 1, '2024-07-18 16:20:48', '2024-07-24 16:04:12', NULL),
(27, 'DHCS202423', 'SARSWATI', 'DHARMENDRA', 'BANDA', '$2y$12$j2L7O7JlOEazQHxb9gxYG.TKr6SrQbd.bbUJH0VdnityFQrXZJ9ky', 2, NULL, '8733913207', NULL, '1977-12-16', 'Female', '344,PATEL PARMANAND NI CHALI,,NEAR VIVEKANAND MILL,RAKHIYAL,AHMEDABAD', '5', '125', '37', NULL, NULL, NULL, NULL, 466, 466, NULL, '47', '2024-07-15', '13', 'DEVEN SIR', '6 TH', NULL, 1, '2024-07-18 16:49:14', '2024-07-18 16:49:14', NULL),
(28, 'DHCS202424', 'VIJAYABEN', 'VIJAYBHAI', 'MAKWANA', '$2y$12$T0UnwnDVgwhBzw9pHuN40OvmZd07vH2QkFPNt9XSwbfkfzxMKyoFS', 2, NULL, '9173478419', NULL, '1983-01-01', 'Female', '22/684,RAMBAUG AVAS YOJANA BEHIND DURGA SCHOOL,NEAR RANCHODRAI NAGAR PART -4 CHANDLODIA,DASKROI,AHMEDABAD', '5', '125', '38', NULL, NULL, NULL, NULL, 466, 466, NULL, '41', '2024-07-15', '6', 'DEVEN SIR', '5 TH', NULL, 1, '2024-07-18 16:58:05', '2024-07-18 16:58:05', NULL),
(29, 'DHCS202425', 'SHITAL', 'SETANSINH', 'PARMAR', '$2y$12$p5iqT0KNqBmE4ArXC2/er.maIlbao6e970c.oBw8//gbKc1YlBaxe', 2, 'superadmin@gmail.com', '7096734781', NULL, '1982-06-01', 'Female', 'PARMAR FALIYU RADHIVAAD SABARKANTHA', '5', '145', '36', NULL, NULL, NULL, NULL, NULL, 500, NULL, '31', '2022-03-16', '5', 'DEVEN SIR', '8TH', 'DIAPER SPONGING RT FEEDING', 1, '2024-07-18 16:59:13', '2024-07-18 16:59:13', NULL),
(30, 'DHCS202426', 'ASHOK', 'DEVILAL', 'KATARA', '$2y$12$TPLEba2.2/Dg7HWxtZjYNum94brrU5Tf7ubyrEQE88zDjw9idCh6a', 2, NULL, '7990506251', NULL, '2000-02-20', 'Female', 'DAIYA  UDAIPUR RAJASTHAN', '19', '463', '39', NULL, NULL, NULL, NULL, 433, 500, 700, NULL, '2024-04-11', '3', 'DEVEN SIR', '8TH', 'DIAPER SPONGING', 1, '2024-07-18 17:05:59', '2024-07-18 17:05:59', NULL),
(31, 'DHCS202427', 'RAMILABEN', 'AMBALAL', 'PARMAR', '$2y$12$7b/pssn/K/Gso8EbBbXWdeAJtwnc8yO9XSBeICHdLQtMoSc6O.fku', 2, NULL, '9173725718', NULL, '1960-06-01', 'Female', '65/594,CHANDRA BHAGA HOUSING BOARD BHAVSAR HOSTEL NR,SHRINATH APARTMENT NAVA VADAJ,AHMEDABAD', '5', '125', '40', NULL, NULL, NULL, NULL, 466, 466, NULL, '60', '2024-07-15', '16', 'DEVEN SIR', NULL, NULL, 1, '2024-07-18 17:11:31', '2024-07-18 17:11:31', NULL),
(32, 'DHCS202428', 'MANOJ', 'SHANKARLAL', 'YADAV', '$2y$12$Dap483MkcYz6UspGy2rNJe0fO8mrXjO3P43tYDfqkvau/nTYX9cdG', 2, NULL, '7023293964', NULL, '1993-05-29', 'Male', 'YADAV MAHOLLA CHIROLA BAANSVADA RAJASTHAN', '19', '435', '41', NULL, NULL, NULL, NULL, 500, NULL, 733, NULL, '2024-02-14', '5', 'DEVEN SIR', '10TH', 'DIAPER SPONGING RT FEEDING', 1, '2024-07-18 17:11:37', '2024-07-18 17:11:37', NULL),
(33, 'DHCS202429', 'MEHUL', 'LAXMAN', 'RATHOD', '$2y$12$.bkW872XMI3PYkjLvTp.WeJDpkTa1jPDuc4dCI.S/P9Hezqk.1/JS', 2, NULL, '7069131690', NULL, '1993-07-22', 'Male', 'D-12 DWARKA NAGAR,NR NOBAL NAGAR KOTARPUR,NARODA,AHMEDABAD', '5', '125', '42', NULL, NULL, NULL, NULL, 466, 466, NULL, '31', '2024-07-15', '3', 'DEVEN SIR', '11 TH', NULL, 1, '2024-07-18 17:17:51', '2024-07-18 17:17:51', NULL),
(34, 'DHCS202430', 'KAILASH', 'NARENDRABHAI', 'NINAMA', '$2y$12$GhOWE4Wkl.qXsSjoFAYGLu1FnypgvNCkE0ry0kF2FvTVLPnfc8O/C', 2, NULL, '6352513592', NULL, '1983-07-15', 'Female', 'VIJAY NAGAR CHITARIYA SABARKANTHA', '5', '145', '19', NULL, NULL, NULL, NULL, NULL, NULL, 700, NULL, '2023-11-22', '6', 'DEVEN SIR', '8TH', 'DIAPER SPONGING RT FEEDING', 0, '2024-07-18 17:18:43', '2024-07-27 17:48:37', NULL),
(35, 'DHCS202431', 'JASHWANT', 'LAKSHMANBHAI', 'SENMA', '$2y$12$3tEhpYkKIH29YjTaY/.QHubqy0VnELBg36vN/XHtyxcThn2Bl//M.', 2, NULL, '8141705785', NULL, '2000-03-31', 'Male', 'SENMA VAS KAALEDA BANASKANTHA', '5', '128', '43', NULL, NULL, NULL, NULL, 500, NULL, 700, '24', '2023-10-11', '4', 'DEVEN SIR', '5TH', 'DIAPER SPONGING', 1, '2024-07-18 17:24:36', '2024-07-18 17:24:36', NULL),
(36, 'DHCS202432', 'SHEETAL', 'JITENDRABHAI', 'CHAUHAN', '$2y$12$iK8/T929HjCLv8p/JCjz8usWNaX0aGH.hYNwezkTJEBjb6gOO6vzW', 2, NULL, '9104175220', '9664522682', '1984-04-25', 'Female', '290,BECHAR LASHKARI DAWAKHANA ANDAR JADAN ROAD,DARIYAPUR,AHMEDABAD', '5', '125', '35', NULL, NULL, NULL, NULL, 466, 466, NULL, '40', '2024-07-15', '10', 'DEVEN SIR', '9 TH', NULL, 1, '2024-07-18 17:24:57', '2024-07-18 17:24:57', NULL),
(37, 'DHCS202433', 'SAHIN', 'RAHIMBHAI', 'MANSURI', '$2y$12$ilIEn1m1mF0.aXNM6U86/eH8yB0bxDIt0l/pn.f5kyvSWqUy1SNYC', 2, NULL, '7802061543', NULL, '1989-11-26', 'Female', '13,SEHBAJ PARK,NR EKTA MEDAN VEJALPUR,AHMEDABAD', '5', '125', '44', NULL, NULL, NULL, NULL, 466, 466, NULL, '34', '2024-07-15', '10', NULL, '8 TH', NULL, 1, '2024-07-18 17:30:13', '2024-07-18 17:30:13', NULL),
(38, 'DHCS202434', 'REKHA', 'BHIKHABHAI', 'RATHOD', '$2y$12$orqS0t2BXEZHEhMmBpuMAuRwpc6tBhuwHwkGWa2.4cWwgvJ8PFAxK', 2, NULL, '9824760249', NULL, '1983-02-05', 'Female', 'VATVA', '5', '125', '45', NULL, NULL, NULL, NULL, 500, 500, NULL, NULL, '2018-01-11', '9', 'DEVEN SIR', '5TH', 'DIAPER SPONGING RT FEEDING', 1, '2024-07-18 17:32:11', '2024-07-18 17:32:11', NULL),
(39, 'DHCS202435', 'TARANA', 'IMRAN', 'AJMERI', '$2y$12$0q8xtYEXWaPp/bIGKzyiselUZYy61tlJ4U0e8o7oZUoYKFcKJbngK', 2, NULL, '8141629386', '8141629399', '1987-09-27', 'Female', '320,JUMMAN MIYA NI CHALI SHAHPUR,AHMEDABAD', '5', '125', '31', NULL, NULL, NULL, NULL, 466, 466, NULL, '37', '2024-07-15', '6', 'DEVEN SIR', '6 TH', NULL, 1, '2024-07-18 17:34:24', '2024-07-18 17:34:24', NULL),
(40, 'DHCS202436', 'DAKSHABEN', 'SIDHATBHAI', 'RATHOD', '$2y$12$WoNjUA.Nb/CkFxH.7zUpf.aLW1PQX71wiehvoM1R5dToe.VjRmTMW', 2, NULL, '9023215466', '9023207669', '1980-10-11', 'Female', 'LAXMI NIWAS G-208, SECOND FLOOR,NAROL,AHMEDABAD', '5', '125', '46', NULL, NULL, NULL, NULL, 466, 466, NULL, '44', '2024-07-15', '4', 'DEVEN SIR', NULL, NULL, 1, '2024-07-18 17:46:01', '2024-07-18 17:46:01', NULL),
(41, 'DHCS202437', 'RAJESH', 'NATH', 'RAVAL', '$2y$12$MCqxDG9JZWHyADsMyMulJe2LbiuEZPSXnRy27EOpoSYFMEJFvK3WW', 2, NULL, '9057241349', NULL, '1989-01-01', 'Male', 'METWALA ,BANSWARA,RAJASTHAN', '19', '435', '48', NULL, NULL, NULL, NULL, 500, 500, 700, '35', '2024-05-28', '3', NULL, NULL, 'RT FEEDING,SUCTION', 1, '2024-07-22 14:35:04', '2024-07-22 14:35:04', NULL),
(42, 'DHCS202438', 'PAYAL', 'KISHAN', 'MEENA', '$2y$12$9UOUqyLaBMxYrUOi20oGduLQo0rfpLql/ncsSw3gEq8SIkYw5J/OK', 2, 'nishapatel@gmail.com', '742493908', NULL, '2003-09-14', 'Female', 'PAGLYAJI ROAD,RISHABHADEV,UDAIPUR,RAJASTHAN', '19', '463', '49', NULL, NULL, NULL, NULL, 500, 500, 700, '21', '2024-07-01', '2', 'VIKRAM SINGH', NULL, 'RT FEEDING,SUCTION', 1, '2024-07-22 15:37:35', '2024-07-22 15:37:35', NULL),
(43, 'DHCS202439', 'RAHUL', 'RATANJI', 'NAI', '$2y$12$vmqejuOHmpqUHuvYvIH9eukmtN6okfrY2Yw703yfssQQcoKVMUjgS', 2, NULL, '977253633', NULL, '1997-03-17', 'Male', 'PUNJPUR,DUNGARPUR,RAJASTHAN', '19', '444', '50', NULL, NULL, NULL, NULL, 500, 500, 700, '27', '2022-07-01', '4', 'SELF', NULL, 'RT FEEDING,SUCTION', 1, '2024-07-22 15:43:23', '2024-07-22 15:43:23', NULL),
(44, 'DHCS202440', 'RINKU', 'PAPPU', 'MEENA', '$2y$12$qGvEDxYJn4W3LUAeoCTmdeoKDiG1v9R2bhSFjov.hNDi6VS82nHOW', 2, NULL, '9601892072', NULL, '2007-02-18', 'Female', 'GARNALAKOTARA,RAJASTHAN', '19', '463', '51', NULL, NULL, NULL, NULL, 500, 500, 666, '18', '2024-03-01', '1', 'VIKRAM SINGH', NULL, NULL, 1, '2024-07-22 15:52:03', '2024-07-22 15:52:03', NULL),
(45, 'DHCS202441', 'MANJULADEVI', 'DHARMA', 'BARANDA', '$2y$12$p3Mb0XqO7cm2mhtaJCLY/.GMWAg7wZNXOoex2bziqOPOyTCnxqQu2', 2, NULL, '9408374153', NULL, '1983-01-01', 'Female', 'BAHIGHATIYA DAIYA UDAIPUR JHADOL,RAJASTHAN', '19', '463', '39', NULL, NULL, NULL, NULL, NULL, NULL, 600, '41', '2024-04-01', '1', 'PRAVIN BATODRA', NULL, NULL, 1, '2024-07-22 16:03:26', '2024-07-22 16:03:26', NULL),
(46, 'DHCS202442', 'LAXMIBEN', 'BHAGVATSINH', 'RANA', '$2y$12$x9qFeTvKRGFo6B1qNrvElumljclilN4jXhNnCq.BXec5KOxzs/Yqq', 2, NULL, '7698687065', NULL, NULL, 'Female', 'DANTA DHOLIVAS BANASKATHA BHAVANGARH,GUJARAT', '5', '128', '53', NULL, NULL, NULL, NULL, NULL, NULL, 666, '52', '2024-01-01', '2', 'NIMISHA MEER', NULL, NULL, 1, '2024-07-22 16:11:05', '2024-07-22 16:11:05', NULL),
(47, 'DHCS202443', 'NIRUBEN', 'ASHWINBHAI', 'PATEL', '$2y$12$aI5Eb6I1O2KeQegJqdWNPObuS9nr3phgZFYZVtYQO08q4Pa1UWAS.', 2, NULL, '9687135413', NULL, '1976-05-22', 'Female', '9-145,PATEL SHERI VANOD,SURENDRA NAGAR,GUJARAT', '5', '146', '54', NULL, NULL, NULL, NULL, NULL, NULL, 666, '48', '2024-07-01', '10', 'SELF', NULL, 'RT FEEDING,SUCTION', 1, '2024-07-22 16:17:58', '2024-07-22 16:17:58', NULL),
(48, 'DHCS202444', 'NEHABEN', 'PRAVINBHAI', 'BHATIYA', '$2y$12$virzmWb6MBpe95WsmDeeMuzLgvaJq5uHN16sLIp31JozqDjgjOs9G', 2, NULL, '9327037236', NULL, '2000-02-11', 'Female', 'KHRISTI VAS,NADIAD KHEDA', '5', '137', '55', NULL, NULL, NULL, NULL, 500, 500, 666, '24', '2024-03-01', '4', 'DEVEN SIR', 'GNM', 'RT FEEDING,SUCTION', 1, '2024-07-22 16:26:12', '2024-07-22 16:26:12', NULL),
(49, 'DHCS202445', 'LEELA', 'BHARTBHAI', 'ASARI', '$2y$12$5UhYalz.BtqOlH.B9JOAWOoS1ShxbtOLgUD.WsIvOAFzXL1HPiS6C', 2, NULL, '6356745660', NULL, '1989-01-01', 'Female', 'ASARI FALI BHILODA GHANTI,SABARKANTHA,LICHHA,GUJARAT', '5', '145', '56', NULL, NULL, NULL, NULL, 500, 500, 666, '35', '2024-02-01', '2', NULL, NULL, 'RT FEEDING,SU', 1, '2024-07-22 16:38:29', '2024-07-22 16:38:29', NULL),
(50, 'DHCS202446', 'GOPAL', 'TEJPAL', 'MEGHWAL', '$2y$12$7IB/R6j1B02YKTTQ8To0Puu4BdEoJAbVYfT5EvS0hMMjc3tuLc0em', 2, 'nishapatel@gmail.com', '9662606283', NULL, '2004-06-19', 'Male', 'RAMGARH,DUNGARPUR,RAJASTHAN', '19', '444', '57', NULL, NULL, NULL, NULL, 500, 500, 666, '20', '2024-01-01', '3', 'SELF', NULL, NULL, 1, '2024-07-22 16:44:25', '2024-07-22 16:44:25', NULL),
(51, 'DHCS202447', 'NARESH', 'SOMA', 'CHANDRA', '$2y$12$RN4I4pL7DOtzUpGrfu1l0ur.3Z1k48xHv.DC.CkHkWC4yuxPUKpMu', 2, NULL, '6378049078', NULL, NULL, 'Male', '1056,ADIVASI PHALA,PALODA,BANSWARA,RAJASTHAN', '19', '435', '58', NULL, NULL, NULL, NULL, NULL, NULL, 666, '42', '2023-01-01', '5', NULL, NULL, 'RT FEEDING,SUCTION', 1, '2024-07-22 16:49:32', '2024-07-22 16:49:32', NULL),
(52, 'DHCS202448', 'KAILASHBEN', 'NARENDRABHAI', 'NINAMA', '$2y$12$hem8N.ZeWrgaTPUEWuvXdenAGTXdL1RxBz3k6fAkhg7ux2rhlYhrq', 2, NULL, '6357304349', NULL, '1984-07-15', 'Female', 'TALUKA-VIJAYNAGAR,CHITARIYA,SABARKANTHA,GUJARAT', '5', '145', '19', NULL, NULL, NULL, NULL, NULL, NULL, 700, '40', '2024-06-01', '5', NULL, NULL, 'RT FEEDING,SUCTION', 1, '2024-07-22 17:00:45', '2024-07-22 17:00:45', NULL),
(53, 'DHCS202449', 'AMRITLAL', 'HIRA', 'YADAV', '$2y$12$FZ.nck7t3eLPYEVfqPgJAOEBOamudbylLsBWwOF0kk9VjS5UF792q', 2, NULL, '9725681228', NULL, '1977-07-04', 'Male', 'UMEDRA FALA SHISHOD,DUNGARPUR,RAJASTHAN', '19', '444', '59', NULL, NULL, NULL, NULL, NULL, NULL, 666, '47', '2024-05-01', '10', NULL, NULL, 'RT FEEDING,SUCTION', 0, '2024-07-22 17:19:28', '2024-07-27 17:49:26', NULL),
(54, 'DHCS202450', 'AMRITLAL', 'HIRA', 'YADAV', '$2y$12$sryKCv/7FqJ7t5XJga7m8.s6N99uhJqF2zTsUPVqP241Gx0MBcjeu', 2, NULL, '9725681228', NULL, '1977-07-04', 'Male', 'UMEDRA FALA SHISHOD,DUNGARPUR,RAJASTHAN', '19', '444', '59', NULL, NULL, NULL, NULL, 500, 500, 666, '47', '2024-05-01', '10', NULL, NULL, 'RT FEEDING,SUCTION', 1, '2024-07-22 17:19:30', '2024-07-25 15:00:00', NULL),
(55, 'DHCS202451', 'PRIYANKA', 'NAHARSINH', 'KUNVAR', '$2y$12$UQQNEugXq9WCFFnQcnqrG.HLVfNPw8E2UoKkITePyKpu5UywILB/S', 2, NULL, '6367042913', NULL, '1993-01-01', 'Female', 'NAVA GHARA TOKAR,UDAIPUR,RAJASTHAN', '19', '463', '60', NULL, NULL, NULL, NULL, NULL, NULL, 666, '31', '2024-07-01', '5', NULL, NULL, NULL, 1, '2024-07-23 16:58:12', '2024-07-23 16:58:12', NULL),
(56, 'DHCS202452', 'ISE', 'SEEMA', 'RAVIBHAI', '$2y$12$VF7ofxMZogQqLT4NecRFoOCC8d7ZEXt7eL3RZwLG6tEYq.aTdu1bC', 2, NULL, '951077226', NULL, '1979-07-18', 'Female', 'C-701 AVOLONFLOR DHC AYODHYA APPARTMENT NR VATVA GAMDI RD', '5', '125', '45', NULL, NULL, NULL, NULL, 433, 433, 666, '44', '2024-07-02', '6', 'RAKESH SIR', '12 TH', 'DIAPER SPONGING RT FEEDING', 1, '2024-07-23 17:01:07', '2024-07-23 17:43:41', NULL),
(57, 'DHCS202453', 'SUKHJIVANKOUR', 'KASHMIRSINGH', 'VIRK', '$2y$12$78QgmfvoEipUSqR1I6qbF.gux2AqegCkF9RWkLTg9UtZSqyvyQUFm', 2, NULL, '9016093886', NULL, NULL, 'Female', '45,KRISHNA PARK SOCIETY,P.D. COLLEGE ROAD,NR. ARADHNA PARK,GHODASAR,AHMEDABAD,GUJARAT', '5', '125', '61', NULL, NULL, NULL, NULL, NULL, NULL, 666, '44', '2024-01-01', '7', 'DEVEN SIR', NULL, 'RT FEEDING,SUCTION', 1, '2024-07-23 17:04:39', '2024-07-23 17:04:39', NULL),
(58, 'DHCS202454', 'VAISHALI', 'PANKAJKUMAR', 'BHAVSAR', '$2y$12$To06WNWrjpjksg7UXoDD9etbvvVHZRAhU2TzO2L5XXAF9Y8lXjYKe', 2, NULL, '878042501', NULL, '1983-05-23', 'Female', '9,SOMNATH SOCIETY,PETHAPUR,GANDHINAGR,GUJARAT', '5', '133', '62', NULL, NULL, NULL, NULL, NULL, NULL, 666, '42', '2024-07-01', '3', NULL, NULL, 'RT FEEDING,SUCTION', 1, '2024-07-23 17:24:20', '2024-07-23 17:24:20', NULL),
(59, 'DHCS202455', 'NARESH', 'DUDHABHAI', 'CHAMAR', '$2y$12$7on5DILwREy5q8IN2EeHv.FjWU0cYRTvo4pFY0/XcQCPiN.Dwl7CW', 2, NULL, '8238869716', NULL, '1991-05-12', 'Male', 'GHOGHAVADA BHADROD PANCHMAHAL,GUJARAT', '5', '142', '63', NULL, NULL, NULL, NULL, 500, 500, NULL, '33', '2023-07-01', '8', NULL, NULL, NULL, 1, '2024-07-23 17:34:07', '2024-07-23 17:41:39', NULL),
(60, 'DHCS202456', 'URMILA', 'PUJARAM', 'DEVI', '$2y$12$e0BqWLiFKn9RP6b3LU8kgOi.K/mHE8T7NLO7rxrsmhzibCSs089X6', 2, NULL, '6375604700', NULL, '1991-01-01', 'Female', 'KUMHAR BASATI SARDA SARARA,UDAIPUR,RAJASTHAN', '19', '463', '64', NULL, NULL, NULL, NULL, 500, 500, 666, '33', '2023-07-01', '2', NULL, NULL, NULL, 1, '2024-07-23 17:40:57', '2024-07-23 17:40:57', NULL),
(61, 'DHCS202457', 'MONIKA', 'MOGAJI', 'MEENA', '$2y$12$ZoViKrUGornZRWXJsxkmG.RWmY2eYuUuWgsdzaOcDk/VY4Suht142', 2, NULL, '7073262699', NULL, '2004-04-05', 'Female', 'LALPURIYA,UDAIPUR,RAJASTHAN', '19', '463', '65', NULL, NULL, NULL, NULL, 500, 500, 666, '20', '2024-07-01', '2', NULL, NULL, NULL, 1, '2024-07-23 17:49:02', '2024-07-23 17:49:02', NULL),
(62, 'DHCS202458', 'NILU', 'RAMPRASAD', 'GAYRI', '$2y$12$ZhoN8QuDWljffJ4Fen24EOLtMEjF1M3o9tio.ztg1wTxYdZ/jA4/O', 2, NULL, '9111900448', NULL, '2003-04-03', 'Female', 'RUPAREL,JAWAD,NEEMUCH,MADHYA PRADESH', '11', '293', '66', NULL, NULL, NULL, NULL, 500, 500, 666, '21', '2024-01-01', '1', NULL, 'GNM', 'RT FEEDING,SUCTION', 1, '2024-07-23 17:53:28', '2024-07-23 17:53:28', NULL),
(63, 'DHCS202459', 'DINESHKUMAR', 'NATVARBHAI', 'PARMAR', '$2y$12$qZVpIyMLUPNYmrQCHUFaD.FUQATSe.Acqnwk4pQmh8fy6/Ml/Tzeu', 2, NULL, '9974376236', NULL, '1987-06-12', 'Male', '1-125,PARMAR VAS HAJIPURA TA KALOL,GANDHINAGAR', '5', '133', '67', NULL, NULL, NULL, NULL, 500, NULL, NULL, '37', '2024-06-01', '2', NULL, NULL, NULL, 1, '2024-07-23 17:57:48', '2024-07-23 17:57:48', NULL),
(64, 'DHCS202460', 'CHANCHAL', 'MOGAJI', 'MEENA', '$2y$12$zOXxTwOLWMbTPkEPXl4Oz.M2A3B/xJYyIukjDU5pQPaH4tceOHXaC', 2, NULL, NULL, NULL, '2002-02-12', 'Female', 'LALPURIA MEDI DHANI SARADA UDAIPUR', '19', '463', '65', NULL, NULL, NULL, NULL, NULL, NULL, 666, '23', '2023-03-07', '1', 'DEVEN SIR', '8TH', 'DIAPER SPONGING', 1, '2024-07-23 18:07:11', '2024-07-23 18:07:11', NULL),
(65, 'DHCS202461', 'RONAL', 'NANAJI', 'NINAMA', '$2y$12$YoR3IWSdlueNrNbn49bfBe6jGxjuarhQBEvUmz5z1QwKqntwVFDg.', 2, NULL, '7600138847', NULL, '1997-01-01', 'Female', 'DAIYA  UDAIPUR RAJASTHAN', '19', '463', '39', NULL, NULL, NULL, NULL, NULL, NULL, 666, NULL, '2024-03-01', '1', 'DEVEN SIR', '12 TH', 'DIAPER SPONGING', 1, '2024-07-23 18:14:52', '2024-07-23 18:14:52', NULL),
(66, 'DHCS202462', 'ASHA', 'DHIRUBHAI', 'DAVE', '$2y$12$IPADkgH.tUUREk7Fx0HVlenTw8nV2QtyB25GXYrFaFa/.DDaLuYAi', 2, NULL, '8849629118', NULL, '1999-07-09', 'Female', 'JIVRAJPARK AHMEDABAD', '5', '125', '44', NULL, NULL, NULL, NULL, 500, NULL, NULL, '24', '2023-12-07', '4', 'RAKESH SIR', '8TH', 'DIAPER SPONGING', 1, '2024-07-23 18:18:56', '2024-07-23 18:18:56', NULL),
(67, 'DHCS202463', 'LILA', 'BABULAL', 'MEENA', '$2y$12$07Zq3Mv0YjSjTPhWb0WzvuAqmijZ5fRAv31JMO5ptIQon8UFtR6nq', 2, NULL, '7877982975', NULL, '2000-08-12', 'Female', 'GAMDI DEVKI,DUNGARPUR,RAJASTHAN', '19', '444', '68', NULL, NULL, NULL, NULL, 500, 500, NULL, '24', '2024-01-01', '2', 'RAKESH SIR', NULL, 'RT FEEDING,SUCTION', 1, '2024-07-24 15:18:57', '2024-07-24 15:18:57', NULL),
(68, 'DHCS202464', 'MEERABEN', 'MAHESHKUMAR', 'JADAV', '$2y$12$HiKKkM6079M7hgIyMag3Buh1XR97cTZEiogLIahmcYvvb6PtVQTuK', 2, NULL, '9723434868', NULL, '1983-07-15', 'Female', '3,KHODIYAR NAGAR,NOBALNAGAR KHIRANI FACTORY PASE ,AHMEDABAD,GUJARAT', '5', '125', '42', NULL, NULL, NULL, NULL, 500, NULL, NULL, '31', '2024-03-01', '1', 'DEVEN SIR', NULL, NULL, 1, '2024-07-24 15:27:24', '2024-07-24 15:27:24', NULL),
(69, 'DHCS202465', 'SITADEVI', 'NARAYANLAL', 'SAHU', '$2y$12$br.TODTyI7d29u/wGWgFn..ShHVc7z.vUVgBsWDL.MN/.8DV5t0PW', 2, NULL, '7014729375', NULL, '1984-10-16', 'Female', 'BHATI KA MOHLLA KOSHITLAL,BHILWARA,RAJASTHAN', '19', '439', '69', NULL, NULL, NULL, NULL, 500, NULL, NULL, '40', '2024-06-01', '2', NULL, NULL, 'RT FEEDING,SUCTION', 1, '2024-07-24 15:34:07', '2024-07-24 15:34:07', NULL),
(70, 'DHCS202466', 'MANGI', 'LAL', 'JOGI', '$2y$12$IGLR.6ixBW9gIOe8BiM.BefS01dpDA96hieT.IzCFuG/LGEMvonuG', 2, NULL, '8890911859', NULL, '1967-01-01', 'Female', 'WARD NO. 4,JOGI MOHALLA,PAL NEEMODA,RAJASTHAN', '19', '463', '70', NULL, NULL, NULL, NULL, 500, NULL, NULL, '57', '2024-03-01', '3', 'DEVEN SIR', NULL, 'RT FEEDING,SUCTION', 1, '2024-07-24 15:45:47', '2024-07-24 15:45:47', NULL),
(71, 'DHCS202467', 'KRISHNA', 'GATU', 'ROAT', '$2y$12$saRKJ97ePvlOswV.yuvX2.g8k8qJRv1UF38I7efaFgF4adXduVVvW', 2, 'nishapatel@gmail.com', '9016272533', NULL, '2000-02-12', 'Female', 'DUNGARPUR,RAJSTHAN', '19', '444', '71', NULL, NULL, NULL, NULL, 500, 500, NULL, '24', '2024-05-01', '2', 'SUMITRA PARMAR', NULL, NULL, 1, '2024-07-24 15:54:52', '2024-07-24 15:54:52', NULL),
(72, 'DHCS202468', 'DILIP', 'HAJURI', 'SINGH', '$2y$12$/GBEbk45asYoEzVmPrRXF.a9zAcEW/02TJGaw4hkRvev53L..AF62', 2, NULL, '7424855393', NULL, '1992-01-01', 'Male', 'VAGHELA BASATI,DUNGARPUR,RAJASTHAN', '19', '444', '72', NULL, NULL, NULL, NULL, 500, 500, NULL, '32', '2024-04-01', '5', NULL, NULL, 'RT FEEDING,SUCTION', 1, '2024-07-24 16:03:15', '2024-07-27 16:40:41', NULL),
(73, 'DHCS202469', 'JIGNESH', 'AMRA', 'YADAV', '$2y$12$x7DrAs7fMaxrgOBEuMsF.ecnfXymqQQX0n7AMgFatAPZ5zOn0X2sC', 2, NULL, '9928307105', NULL, '1992-02-10', 'Male', 'NARANPURA', '5', '125', '20', NULL, NULL, NULL, NULL, 500, NULL, NULL, '31', '2022-03-09', '5', 'DEVEN SIR', '10TH', 'DIAPER SPONGING RT FEEDING', 1, '2024-07-24 17:21:34', '2024-07-24 17:21:34', NULL),
(74, 'DHCS202470', 'HEMENDRA', 'AVADHNARAYAN', 'PRAJAPATI', '$2y$12$eflCSKdVWdYCw0f0vpwP8u28YZ.02pS7RAdxICs5SGN40hRTWEnZi', 2, NULL, '6263380177', NULL, '1989-02-15', 'Male', 'MEMNAGAR', '5', '125', '73', NULL, NULL, NULL, NULL, 500, 500, NULL, '35', '2021-02-09', '5', 'DEVEN SIR', '12 TH', 'DIAPER SPONGING RT FEEDING', 1, '2024-07-24 17:30:55', '2024-07-24 17:30:55', NULL),
(75, 'DHCS202471', 'SANGITA', NULL, 'DAMOR', '$2y$12$yBIagrcSrcVJw.fyRXSb4eBx0oR9/pN.PRKfa01pJ4PtP9svgErQO', 2, NULL, '9664777802', NULL, '1998-01-02', 'Female', 'RAANI RD KHERVAD', '19', '463', '74', NULL, NULL, NULL, NULL, 500, 500, 700, NULL, '2022-01-04', '3', 'DEVEN SIR', '10TH', 'DIAPER SPONGING RT FEEDING', 1, '2024-07-24 17:37:32', '2024-07-24 17:37:32', NULL),
(76, 'DHCS202472', 'RAGINI', 'SANAT', 'BAJPAI', '$2y$12$6CJSQ2Mp2IPDKvYz5/4vGOXjeWS1OBM.uzf1GPykBe8RFuICwrW2K', 2, NULL, '6306244103', NULL, '2001-07-05', 'Female', 'BOPAL', '5', '125', '3', NULL, NULL, NULL, NULL, 500, 500, NULL, NULL, '2023-01-03', '2', 'DEVEN SIR', '10TH', 'DIAPER SPONGING RT FEEDING', 1, '2024-07-24 17:54:32', '2024-07-24 17:54:32', NULL),
(77, 'DHCS202473', 'DASHRATHBHAI', 'LEBABHAI', 'BUKOLIYA', '$2y$12$pzkDibDdOllWfWadpNlrlet076EWCxQI1Ty2h6EHLBswSRDVxEMPq', 2, NULL, '8128027797', NULL, '1994-07-10', 'Male', 'BANASKTHA,DEODAR,GUJARAT', '5', '128', '75', NULL, NULL, NULL, NULL, 500, 500, 700, '30', '2023-07-01', '3', 'DEVEN SIR', '12 TH', 'RT FEEDING,SUCTION', 1, '2024-07-25 14:30:02', '2024-07-25 14:30:02', NULL),
(78, 'DHCS202474', 'SAHIL', 'GIRISHBHAI', 'MAKWANA', '$2y$12$8XJqktH5fQWOxmAHpF5c6e2gk0udatlWKb4Rye.UOfprIyDNCHQt.', 2, NULL, '8347251345', NULL, '1998-03-27', 'Male', 'VIJAPUR,MEHSANA,,GUJARAT', '5', '138', '87', NULL, NULL, NULL, NULL, 500, 500, 700, '26', '2024-05-01', '5', 'RAKESH SIR', '12 TH', 'RT FEEDING,SU', 1, '2024-07-26 13:24:43', '2024-07-26 13:32:11', NULL),
(79, 'DHCS202475', 'STAVAN', 'BHANUBHAI', 'CHRIATIAN', '$2y$12$BAsenHD9ycW2wEm3DpNUKeCXdVZkGTVU9GrhPrqBeOSqif3vBhvXC', 1, NULL, '8849396493', NULL, '1998-11-09', 'Male', '252,KHRISTI FALIYU MU-NAVCHETAN,VANSOL,KHEDA,GUJARAT', '5', '137', '88', NULL, NULL, NULL, NULL, 500, 500, 700, '26', '2024-07-01', '1', 'DEVEN SIR', 'GNM', 'RT FEEDING,SUCTION', 1, '2024-07-26 13:39:37', '2024-07-26 13:39:37', NULL),
(80, 'DHCS202476', 'ANITA', 'MANILAL', 'GHOGHARA', '$2y$12$X6/qT/eXRxQIYjbCPqV8I.z9WAX5uOOZOSsoyOBatqwUtibqsEqZW', 2, NULL, '9602589049', NULL, '2003-01-01', 'Female', 'VILLAGE-MANDWA,DUNGARPU,RAJASTHAN', '19', '444', '101', NULL, NULL, NULL, NULL, NULL, NULL, 733, '21', '2023-01-01', '3', 'RAKESH SIR', '11 TH', 'RT FEEDING,SUCTION', 1, '2024-07-27 12:40:24', '2024-07-29 13:40:24', NULL),
(81, 'DHCS202477', 'JYOTI', 'VINODBHAI', 'DAMOR', '$2y$12$H3Nd3zkx/rlIsA8zv7qCU.rE0O5KG1peyt5DrYjbRcTOiX2rIIcnK', 2, NULL, '7621897529', NULL, '1999-06-26', 'Female', 'VIJAYNAGAR BANDHANA,SABARKANTHA,GUJARAT', '5', '145', '102', NULL, NULL, NULL, NULL, NULL, NULL, 700, '28', '2023-01-01', '3', NULL, '10 TH', 'RT FEEDING,SUCTION', 1, '2024-07-27 12:45:30', '2024-07-27 12:45:30', NULL),
(82, 'DHCS202478', 'MAHESH', NULL, 'PARMAR', '$2y$12$LKkJsrSaBhJi7MaSC352K.UrUjmeD3FAcNPsAi7BHAOmuTZvx1jyO', 2, NULL, NULL, NULL, '1978-08-10', 'Male', 'ANIL VAKIL NI CHALI PREMNAGAR NARODA', '5', '125', '42', NULL, NULL, NULL, NULL, NULL, NULL, 700, '41', '2021-03-09', '8', 'DEVEN SIR', NULL, 'DIAPER SPONGING RT FEEDING', 1, '2024-07-27 16:43:58', '2024-07-27 16:43:58', NULL),
(83, 'DHCS202479', 'ALPESH', 'MOHANLAL', 'GARASIA', '$2y$12$FwChy4nFS01ejy96tExXoue7YxnsfdKOhu7UuCX0XQjVAbBePZB4m', 2, NULL, '7340162936', NULL, '1989-07-25', 'Male', 'SHISOD,DUNGARPUR,RAJASTHAN', '19', '444', '59', NULL, NULL, NULL, NULL, 500, 500, 700, '35', '2024-04-02', '2', 'DEVEN SIR', '10 TH', 'RT FEEDING,SUCTION', 1, '2024-07-27 18:00:13', '2024-07-27 18:00:13', NULL),
(84, 'DHCS202480', 'PUSHPA', 'KARMA', 'MAKWANA', '$2y$12$f8H7UtKuo/xV4N7WkXgGCOZc/0FaChHkhS6mASmrp7le5Usu.SVZC', 2, NULL, '7990306326', NULL, '1999-01-01', 'Female', 'AMBASA UDAIPUR,RAJASTHAN', '19', '463', '103', NULL, NULL, NULL, NULL, 500, 500, 666, '25', '2024-04-03', '3', NULL, '10 TH', 'RT FEEDING,SUCTION', 1, '2024-07-27 18:06:09', '2024-07-27 18:06:09', NULL),
(85, 'DHCS202481', 'LALITAKUMARI', 'NANDULAL', 'GAMETI', '$2y$12$SpKruIUn.jipwkTrLhnDOudcKp/qSOwy2GzkVXLQEYUAKTOe8w/Xu', 2, NULL, '8890437571', NULL, '1995-01-01', 'Female', 'GAMDI DEVAL,DUNGARPUR,RAJASTHAN', '19', '444', '104', NULL, NULL, NULL, NULL, 500, 500, 666, '25', '2024-04-01', '2', NULL, '11 TH', 'RT FEEDING,SUCTION', 1, '2024-07-29 13:19:36', '2024-07-29 13:19:36', NULL),
(86, 'DHCS202482', 'ANANDIBEN', 'MANHARLAL', 'DAMOR', '$2y$12$0r2EkaW9y.5IleMJQ7WKhOD7KQEOnmdfktYCDJ/7AlsmKZXV9x2XK', 2, NULL, '9409720837', NULL, '1999-12-08', 'Female', 'DWARKESH SOCIETY ROAD NO. 3 KHEDBARBHMA,SABARKANTHA,GUJARAT', '5', '145', '105', NULL, NULL, NULL, NULL, 500, 500, 666, '25', '2024-03-01', '2', NULL, '10 TH', 'RT FEEDING,SUCTION', 1, '2024-07-29 13:26:12', '2024-07-29 14:08:31', NULL),
(87, 'DHCS202483', 'JAMNA', 'NARAYAN', 'PARMAR', '$2y$12$c00Xp5WaH8W7sEh7sSiuu.IgJ/hBc8wMYQEMO2mc2wXcBdAV3DKBS', 2, NULL, '6353887626', NULL, '1996-12-11', 'Female', 'KERWARA,SEEDRI,DUNGARPUR,RAJASTHAN', '19', '444', '106', NULL, NULL, NULL, NULL, 500, 500, 666, '28', '2024-01-01', '3', NULL, '6 TH', 'RT FEEDING,SUCTION', 1, '2024-07-29 13:38:05', '2024-07-29 13:38:05', NULL),
(88, 'DHCS202484', 'NIRMALA', 'VIJAYPAL', 'SINGH', '$2y$12$YlpA9cOgs2aGZ6UUoMKMAucvyuAj5zINqcB7v0BknjoV.JDEmkR4W', 2, NULL, '6354425980', NULL, '1993-01-01', 'Female', 'CHORAL,UDAIPUR,RAJASTHAN', '19', '463', '107', NULL, NULL, NULL, NULL, 500, 500, 700, '31', '2023-12-01', '2', 'VIKRAM SINGH', '10 TH', 'RT FEEDING,SUCTION', 1, '2024-07-29 14:14:42', '2024-07-29 14:14:42', NULL),
(89, 'DHCS202485', 'JAINESH', 'AMRUTBHAI', 'DAMOR', '$2y$12$3NyI2XPABhQZXaAN2qMwFeD4n0QYxxhEWjfwLtDybY7pL6EIugcBa', 2, NULL, '9328372049', NULL, '2000-05-04', 'Male', 'VIRPUR,SABARKANTHA,GUJARAT', '5', '145', '108', NULL, NULL, NULL, NULL, 500, 500, 666, '24', '2023-01-01', '2', NULL, '11 TH', 'RT FEEDING,SUCTION', 1, '2024-07-29 14:41:18', '2024-07-29 14:41:18', NULL),
(90, 'DHCS202486', 'MANISHABEN', 'JAYANTIBHAI', 'DHORALIYA', '$2y$12$niMISVebRlKq0Lr4WGrYeuiWNAV5eHoVbJuygjCn07eY0oevISEEm', 2, NULL, '9664618605', NULL, '2002-03-27', 'Female', 'HOUSE NO 542,AJMER ROAD,DHEDHUKI,RAJKOT,GUJARAT', '5', '144', '109', NULL, NULL, NULL, NULL, 500, 500, 666, '22', '2023-10-01', '2', NULL, '10 TH', 'RT FEEDING,SUCTION', 1, '2024-07-29 14:50:14', '2024-07-29 14:50:14', NULL),
(91, 'DHCS202487', 'NILESH', NULL, 'NINAMA', '$2y$12$LTRjiLjBpKPlaZh6fMeM2O.8m7cXw4y7hn1wgcNZh7/2jMmouzBOq', 2, NULL, '9510299762', NULL, '2000-07-22', 'Male', 'VIRPUR  BHILODA SABAR KANTHA', '5', '145', '108', NULL, NULL, NULL, NULL, 500, 500, NULL, NULL, '2022-03-08', '3', 'DEVEN SIR', '8TH', 'DIAPER SPONGING', 1, '2024-07-29 14:53:34', '2024-07-29 14:53:34', NULL),
(92, 'DHCS202488', 'URMILA', 'PUJARAM', NULL, '$2y$12$pQ86T5AtdKYfDBWtLFgKXOg04bBm0AORWQtMx9fGhoYmk2jmEXO2S', 2, NULL, '6375604700', NULL, '1991-01-01', 'Male', 'KUMHAR BASTI SARADA  UDAIPUR', '19', '463', '64', NULL, NULL, NULL, NULL, 500, 500, 666, NULL, '2023-07-04', '4', 'DEVEN SIR', '5TH', 'DIAPER SPONGING', 1, '2024-07-29 15:03:09', '2024-07-29 15:03:09', NULL),
(93, 'DHCS202489', 'REKHA', 'BHURA', 'TAVIYAD', '$2y$12$M0.aFPXO4ibjBuUjjcrTkO6ZWQD9aIQ0qgycNnVbIQ8R8.wCejxdS', 2, NULL, '8690809794', NULL, '1998-09-15', 'Female', 'SALERA CHIKHLI DUNGARPUR', '19', '444', '110', NULL, NULL, NULL, NULL, 500, 500, NULL, NULL, '2022-07-12', '3', 'SAILESH DAMOR ROY', '8TH', 'DIAPER SPONGING RT FEEDING', 1, '2024-07-29 15:13:09', '2024-07-29 15:13:09', NULL),
(94, 'DHCS202490', 'HEMRAJ', 'SAITANRAM', 'JAJRA', '$2y$12$e/gUdhR1oJbYBfgz9Lf2IOuvFIlrtYeOnJWIbxZp/SgsMQiNjl.Q6', 2, NULL, '9166407463', NULL, '1995-02-03', 'Male', 'IGYAR,KASNAU,NAGAUR,RAJASTHAN', '19', '455', '112', NULL, NULL, NULL, NULL, 500, 500, 700, '29', '2023-12-01', '5', NULL, '11 TH', 'RT FEEDING,SUCTION', 1, '2024-07-29 17:45:59', '2024-07-29 17:45:59', NULL),
(95, 'DHCS202491', 'DEEPIKA', NULL, 'MEENA', '$2y$12$7bH3GEgvl0eg2dvrqCqjV.Q65CNTNyp1Dru0HpaDLF3eBov5Onn.O', 2, NULL, '8619072058', NULL, '2002-02-02', 'Female', 'LALPURIYA SEMARI UDAIPUR', '5', '125', '93', NULL, NULL, NULL, NULL, 500, 500, 666, '22', '2024-03-11', '2', NULL, '10TH', 'DIAPER SPONGING RT FEEDING', 1, '2024-08-03 18:33:43', '2024-08-03 18:33:43', NULL),
(96, 'DHCS202492', 'JASTEEN', NULL, 'RATHOD', '$2y$12$w08x.IwGPNk18G8PbL0Jc.FyJk1d5msHsWd2BbuCeCtT1gNKNOgpO', 2, NULL, '9726098732', NULL, '1973-01-26', 'Male', 'SAMIRNAGAR MAHESWARI NAGAR OPP TAKSHSHILA SCHOOL ,ODHAV,AHMEDABAD', '5', '125', '114', NULL, NULL, NULL, NULL, 500, NULL, NULL, NULL, '2023-12-01', '2', NULL, '10 TH', 'RT FEEDING,SUCTION', 1, '2024-08-09 13:38:50', '2024-08-09 13:38:50', NULL),
(97, 'DHCS202493', 'HIREN', 'KARSHANBHAI', 'AJANA', '$2y$12$xbT7QVikEnnb6eAaqXgreO3UldbbpXPH42aM5BePegmwOzBlfrSJG', 4, NULL, '9313940245', NULL, '1998-04-25', 'Male', 'MAIN ROAD KHATRIVADA GIR SOMNATH,GUJARAT', '5', '134', '115', NULL, NULL, NULL, NULL, 400, 400, 733, '26', '2024-02-01', '2', 'KANA KHAMBHALIYA', '11 TH', 'RT FEEDING,SUCTION', 1, '2024-08-09 13:46:27', '2024-09-04 04:00:22', NULL);

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
(1, 5, '1719236041_0.png', '2024-06-24 20:34:01', '2024-06-24 20:34:09', '2024-06-24 20:34:09'),
(2, 15, '1721286932_0.jpg', '2024-07-18 14:15:32', '2024-07-18 14:15:32', NULL),
(3, 16, '1721287419_0.jpg', '2024-07-18 14:23:39', '2024-07-18 14:23:39', NULL),
(4, 17, '1721288339_0.jpg', '2024-07-18 14:38:59', '2024-07-18 14:38:59', NULL),
(5, 18, '1721288890_0.jpg', '2024-07-18 14:48:10', '2024-07-18 14:48:10', NULL),
(6, 19, '1721292374_0.jpg', '2024-07-18 15:46:14', '2024-07-18 15:46:14', NULL),
(7, 19, '1721292374_1.jpg', '2024-07-18 15:46:14', '2024-07-18 15:46:14', NULL),
(8, 19, '1721292374_2.jpg', '2024-07-18 15:46:14', '2024-07-18 15:46:14', NULL),
(9, 20, '1721292847_0.jpg', '2024-07-18 15:54:07', '2024-07-18 15:54:07', NULL),
(10, 20, '1721292847_1.jpg', '2024-07-18 15:54:07', '2024-07-18 15:54:07', NULL),
(11, 21, '1721293422_0.jpg', '2024-07-18 16:03:42', '2024-07-18 16:03:42', NULL),
(12, 21, '1721293422_1.jpg', '2024-07-18 16:03:42', '2024-07-18 16:03:42', NULL),
(13, 21, '1721293422_2.jpg', '2024-07-18 16:03:42', '2024-07-18 16:03:42', NULL),
(14, 22, '1721293775_0.jpg', '2024-07-18 16:09:35', '2024-07-18 16:09:35', NULL),
(15, 23, '1721294099_0.jpg', '2024-07-18 16:14:59', '2024-07-18 16:14:59', NULL),
(16, 23, '1721294099_1.jpg', '2024-07-18 16:14:59', '2024-07-18 16:14:59', NULL),
(17, 24, '1721294152_0.jpg', '2024-07-18 16:15:52', '2024-07-18 16:15:52', NULL),
(18, 26, '1721294448_0.jpg', '2024-07-18 16:20:48', '2024-07-18 16:20:48', NULL),
(19, 26, '1721294448_1.jpg', '2024-07-18 16:20:48', '2024-07-18 16:20:48', NULL),
(20, 26, '1721294448_2.jpg', '2024-07-18 16:20:48', '2024-07-18 16:20:48', NULL),
(21, 27, '1721296154_0.jpg', '2024-07-18 16:49:14', '2024-07-18 16:49:14', NULL),
(22, 27, '1721296154_1.jpg', '2024-07-18 16:49:14', '2024-07-18 16:49:14', NULL),
(23, 27, '1721296154_2.jpg', '2024-07-18 16:49:14', '2024-07-18 16:49:14', NULL),
(24, 28, '1721296685_0.jpg', '2024-07-18 16:58:05', '2024-07-18 16:58:05', NULL),
(25, 28, '1721296685_1.jpg', '2024-07-18 16:58:05', '2024-07-18 16:58:05', NULL),
(26, 28, '1721296685_2.jpg', '2024-07-18 16:58:05', '2024-07-18 16:58:05', NULL),
(27, 30, '1721297159_0.jpg', '2024-07-18 17:05:59', '2024-07-18 17:05:59', NULL),
(28, 31, '1721297491_0.jpg', '2024-07-18 17:11:31', '2024-07-18 17:11:31', NULL),
(29, 31, '1721297491_1.jpg', '2024-07-18 17:11:31', '2024-07-18 17:11:31', NULL),
(30, 33, '1721297871_0.jpg', '2024-07-18 17:17:51', '2024-07-18 17:17:51', NULL),
(31, 33, '1721297871_1.jpg', '2024-07-18 17:17:51', '2024-07-18 17:17:51', NULL),
(32, 33, '1721297871_2.jpg', '2024-07-18 17:17:51', '2024-07-18 17:17:51', NULL),
(33, 36, '1721298297_0.jpg', '2024-07-18 17:24:57', '2024-07-18 17:24:57', NULL),
(34, 36, '1721298297_1.jpg', '2024-07-18 17:24:58', '2024-07-18 17:24:58', NULL),
(35, 36, '1721298298_2.jpg', '2024-07-18 17:24:58', '2024-07-18 17:24:58', NULL),
(36, 37, '1721298613_0.jpg', '2024-07-18 17:30:13', '2024-07-18 17:30:13', NULL),
(37, 37, '1721298613_1.jpg', '2024-07-18 17:30:13', '2024-07-18 17:30:13', NULL),
(38, 37, '1721298613_2.jpg', '2024-07-18 17:30:13', '2024-07-18 17:30:13', NULL),
(39, 37, '1721298613_3.jpg', '2024-07-18 17:30:13', '2024-07-18 17:30:13', NULL),
(40, 39, '1721298864_0.jpg', '2024-07-18 17:34:24', '2024-07-18 17:34:24', NULL),
(41, 40, '1721299561_0.jpg', '2024-07-18 17:46:01', '2024-07-18 17:46:01', NULL),
(42, 40, '1721299561_1.jpg', '2024-07-18 17:46:01', '2024-07-18 17:46:01', NULL),
(43, 40, '1721299561_2.jpg', '2024-07-18 17:46:01', '2024-07-18 17:46:01', NULL),
(44, 41, '1721633704_0.jpg', '2024-07-22 14:35:04', '2024-07-22 14:35:04', NULL),
(45, 41, '1721633704_1.jpg', '2024-07-22 14:35:04', '2024-07-22 14:35:04', NULL),
(46, 43, '1721637803_0.jpg', '2024-07-22 15:43:24', '2024-07-22 15:43:24', NULL),
(47, 43, '1721637804_1.jpg', '2024-07-22 15:43:24', '2024-07-22 15:43:24', NULL),
(48, 44, '1721638323_0.jpg', '2024-07-22 15:52:03', '2024-07-22 15:52:03', NULL),
(49, 44, '1721638323_1.jpg', '2024-07-22 15:52:03', '2024-07-22 15:52:03', NULL),
(50, 45, '1721639006_0.jpg', '2024-07-22 16:03:26', '2024-07-22 16:03:26', NULL),
(51, 45, '1721639006_1.jpg', '2024-07-22 16:03:26', '2024-07-22 16:03:26', NULL),
(52, 46, '1721639465_0.jpg', '2024-07-22 16:11:05', '2024-07-22 16:11:05', NULL),
(53, 46, '1721639465_1.jpg', '2024-07-22 16:11:05', '2024-07-22 16:11:05', NULL),
(54, 47, '1721639878_0.jpg', '2024-07-22 16:17:58', '2024-07-22 16:17:58', NULL),
(55, 47, '1721639878_1.jpg', '2024-07-22 16:17:58', '2024-07-22 16:17:58', NULL),
(56, 48, '1721640372_0.jpg', '2024-07-22 16:26:12', '2024-07-22 16:26:12', NULL),
(57, 48, '1721640372_1.jpg', '2024-07-22 16:26:12', '2024-07-22 16:26:12', NULL),
(58, 48, '1721640372_2.jpg', '2024-07-22 16:26:12', '2024-07-22 16:26:12', NULL),
(59, 49, '1721641109_0.jpg', '2024-07-22 16:38:29', '2024-07-22 16:38:29', NULL),
(60, 49, '1721641109_1.jpg', '2024-07-22 16:38:29', '2024-07-22 16:38:29', NULL),
(61, 51, '1721641772_0.jpg', '2024-07-22 16:49:32', '2024-07-22 16:49:32', NULL),
(62, 51, '1721641772_1.jpg', '2024-07-22 16:49:32', '2024-07-22 16:49:32', NULL),
(63, 51, '1721641772_2.jpg', '2024-07-22 16:49:32', '2024-07-22 16:49:32', NULL),
(64, 52, '1721642445_0.jpg', '2024-07-22 17:00:45', '2024-07-22 17:00:45', NULL),
(65, 52, '1721642445_1.jpg', '2024-07-22 17:00:45', '2024-07-22 17:00:45', NULL),
(66, 52, '1721642445_2.jpg', '2024-07-22 17:00:45', '2024-07-22 17:00:45', NULL),
(67, 53, '1721643568_0.jpg', '2024-07-22 17:19:28', '2024-07-22 17:19:28', NULL),
(68, 53, '1721643568_1.jpg', '2024-07-22 17:19:28', '2024-07-22 17:19:28', NULL),
(69, 53, '1721643568_2.jpg', '2024-07-22 17:19:28', '2024-07-22 17:19:28', NULL),
(70, 54, '1721643570_0.jpg', '2024-07-22 17:19:30', '2024-07-22 17:19:30', NULL),
(71, 54, '1721643570_1.jpg', '2024-07-22 17:19:30', '2024-07-22 17:19:30', NULL),
(72, 54, '1721643570_2.jpg', '2024-07-22 17:19:30', '2024-07-22 17:19:30', NULL),
(73, 55, '1721728692_0.jpg', '2024-07-23 16:58:12', '2024-07-23 16:58:12', NULL),
(74, 55, '1721728692_1.jpg', '2024-07-23 16:58:12', '2024-07-23 16:58:12', NULL),
(75, 55, '1721728692_2.jpg', '2024-07-23 16:58:12', '2024-07-23 16:58:12', NULL),
(76, 56, '1721728868_0.jpg', '2024-07-23 17:01:08', '2024-07-23 17:01:08', NULL),
(77, 57, '1721729079_0.jpg', '2024-07-23 17:04:39', '2024-07-23 17:04:39', NULL),
(78, 57, '1721729079_1.jpg', '2024-07-23 17:04:39', '2024-07-23 17:04:39', NULL),
(79, 58, '1721730260_0.jpg', '2024-07-23 17:24:20', '2024-07-23 17:24:20', NULL),
(80, 58, '1721730260_1.jpg', '2024-07-23 17:24:20', '2024-07-23 17:24:20', NULL),
(81, 59, '1721730847_0.jpg', '2024-07-23 17:34:07', '2024-07-23 17:34:07', NULL),
(82, 59, '1721730847_1.jpg', '2024-07-23 17:34:07', '2024-07-23 17:34:07', NULL),
(83, 60, '1721731257_0.jpg', '2024-07-23 17:40:57', '2024-07-23 17:40:57', NULL),
(84, 60, '1721731257_1.jpg', '2024-07-23 17:40:57', '2024-07-23 17:40:57', NULL),
(85, 61, '1721731742_0.jpg', '2024-07-23 17:49:02', '2024-07-23 17:49:02', NULL),
(86, 61, '1721731742_1.jpg', '2024-07-23 17:49:02', '2024-07-23 17:49:02', NULL),
(87, 62, '1721732008_0.jpg', '2024-07-23 17:53:28', '2024-07-23 17:53:28', NULL),
(88, 62, '1721732008_1.jpg', '2024-07-23 17:53:28', '2024-07-23 17:53:28', NULL),
(89, 63, '1721732268_0.jpg', '2024-07-23 17:57:48', '2024-07-23 17:57:48', NULL),
(90, 63, '1721732268_1.jpg', '2024-07-23 17:57:48', '2024-07-23 17:57:48', NULL),
(91, 63, '1721732268_2.jpg', '2024-07-23 17:57:48', '2024-07-23 17:57:48', NULL),
(92, 64, '1721732831_0.jpg', '2024-07-23 18:07:11', '2024-07-23 18:07:11', NULL),
(93, 65, '1721733292_0.jpg', '2024-07-23 18:14:52', '2024-07-23 18:14:52', NULL),
(94, 65, '1721733292_1.jpg', '2024-07-23 18:14:52', '2024-07-23 18:14:52', NULL),
(95, 66, '1721733536_0.jpg', '2024-07-23 18:18:56', '2024-07-23 18:18:56', NULL),
(96, 66, '1721733536_1.jpg', '2024-07-23 18:18:56', '2024-07-23 18:18:56', NULL),
(97, 67, '1721809137_0.jpg', '2024-07-24 15:18:57', '2024-07-24 15:18:57', NULL),
(98, 67, '1721809137_1.jpg', '2024-07-24 15:18:57', '2024-07-24 15:18:57', NULL),
(99, 68, '1721809644_0.jpg', '2024-07-24 15:27:24', '2024-07-24 15:27:24', NULL),
(100, 68, '1721809644_1.jpg', '2024-07-24 15:27:24', '2024-07-24 15:27:24', NULL),
(101, 68, '1721809644_2.jpg', '2024-07-24 15:27:24', '2024-07-24 15:27:24', NULL),
(102, 69, '1721810047_0.jpg', '2024-07-24 15:34:07', '2024-07-24 15:34:07', NULL),
(103, 69, '1721810047_1.jpg', '2024-07-24 15:34:07', '2024-07-24 15:34:07', NULL),
(104, 69, '1721810047_2.jpg', '2024-07-24 15:34:07', '2024-07-24 15:34:07', NULL),
(105, 70, '1721810747_0.jpg', '2024-07-24 15:45:47', '2024-07-24 15:45:47', NULL),
(106, 70, '1721810747_1.jpg', '2024-07-24 15:45:47', '2024-07-24 15:45:47', NULL),
(107, 70, '1721810747_2.jpg', '2024-07-24 15:45:47', '2024-07-24 15:45:47', NULL),
(108, 72, '1721811795_0.jpg', '2024-07-24 16:03:15', '2024-07-24 16:03:15', NULL),
(109, 72, '1721811795_1.jpg', '2024-07-24 16:03:15', '2024-07-24 16:03:15', NULL),
(110, 75, '1721817452_0.jpg', '2024-07-24 17:37:32', '2024-07-24 17:37:32', NULL),
(111, 75, '1721817452_1.jpg', '2024-07-24 17:37:32', '2024-07-24 17:37:32', NULL),
(112, 76, '1721818472_0.jpg', '2024-07-24 17:54:32', '2024-07-24 17:54:32', NULL),
(113, 76, '1721818472_1.jpg', '2024-07-24 17:54:32', '2024-07-24 17:54:32', NULL),
(114, 78, '1721975083_0.jpg', '2024-07-26 13:24:43', '2024-07-26 13:24:43', NULL),
(115, 79, '1721975977_0.jpg', '2024-07-26 13:39:37', '2024-07-26 13:39:37', NULL),
(116, 79, '1721975977_1.jpg', '2024-07-26 13:39:37', '2024-07-26 13:39:37', NULL),
(117, 80, '1722058824_0.jpg', '2024-07-27 12:40:24', '2024-07-27 12:40:24', NULL),
(118, 80, '1722058824_1.jpg', '2024-07-27 12:40:24', '2024-07-27 12:40:24', NULL),
(119, 80, '1722058824_2.jpg', '2024-07-27 12:40:24', '2024-07-27 12:40:24', NULL),
(120, 81, '1722059130_0.jpg', '2024-07-27 12:45:30', '2024-07-27 12:45:30', NULL),
(121, 81, '1722059130_1.jpg', '2024-07-27 12:45:30', '2024-07-27 12:45:30', NULL),
(122, 83, '1722078013_0.jpg', '2024-07-27 18:00:13', '2024-07-27 18:00:13', NULL),
(123, 83, '1722078013_1.jpg', '2024-07-27 18:00:13', '2024-07-27 18:00:13', NULL),
(124, 83, '1722078013_2.jpg', '2024-07-27 18:00:13', '2024-07-27 18:00:13', NULL),
(125, 85, '1722233976_0.jpg', '2024-07-29 13:19:36', '2024-07-29 13:19:36', NULL),
(126, 85, '1722233976_1.jpg', '2024-07-29 13:19:36', '2024-07-29 13:19:36', NULL),
(127, 85, '1722233976_2.jpg', '2024-07-29 13:19:36', '2024-07-29 13:19:36', NULL),
(128, 86, '1722234372_0.jpg', '2024-07-29 13:26:12', '2024-07-29 13:26:12', NULL),
(129, 86, '1722234372_1.jpg', '2024-07-29 13:26:12', '2024-07-29 13:26:12', NULL),
(130, 86, '1722234372_2.jpg', '2024-07-29 13:26:12', '2024-07-29 13:26:12', NULL),
(131, 87, '1722235085_0.jpg', '2024-07-29 13:38:05', '2024-07-29 13:38:05', NULL),
(132, 87, '1722235085_1.jpg', '2024-07-29 13:38:05', '2024-07-29 13:38:05', NULL),
(133, 88, '1722237282_0.jpg', '2024-07-29 14:14:42', '2024-07-29 14:14:42', NULL),
(134, 88, '1722237282_1.jpg', '2024-07-29 14:14:42', '2024-07-29 14:14:42', NULL),
(135, 89, '1722238878_0.jpg', '2024-07-29 14:41:18', '2024-07-29 14:41:18', NULL),
(136, 89, '1722238878_1.jpg', '2024-07-29 14:41:18', '2024-07-29 14:41:18', NULL),
(137, 90, '1722239414_0.jpg', '2024-07-29 14:50:14', '2024-07-29 14:50:14', NULL),
(138, 90, '1722239414_1.jpg', '2024-07-29 14:50:14', '2024-07-29 14:50:14', NULL),
(139, 91, '1722239614_0.jpg', '2024-07-29 14:53:34', '2024-07-29 14:53:34', NULL),
(140, 91, '1722239614_1.jpg', '2024-07-29 14:53:34', '2024-07-29 14:53:34', NULL),
(141, 92, '1722240189_0.jpg', '2024-07-29 15:03:09', '2024-07-29 15:03:09', NULL),
(142, 92, '1722240189_1.jpg', '2024-07-29 15:03:09', '2024-07-29 15:03:09', NULL),
(143, 93, '1722240789_0.jpg', '2024-07-29 15:13:09', '2024-07-29 15:13:09', NULL),
(144, 93, '1722240789_1.jpg', '2024-07-29 15:13:09', '2024-07-29 15:13:09', NULL),
(145, 94, '1722249959_0.jpg', '2024-07-29 17:45:59', '2024-07-29 17:45:59', NULL),
(146, 94, '1722249959_1.jpg', '2024-07-29 17:45:59', '2024-07-29 17:45:59', NULL),
(147, 95, '1722684823_0.jpg', '2024-08-03 18:33:43', '2024-08-03 18:33:43', NULL),
(148, 95, '1722684823_1.jpg', '2024-08-03 18:33:43', '2024-08-03 18:33:43', NULL),
(149, 96, '1723185530_0.jpg', '2024-08-09 13:38:50', '2024-08-09 13:38:50', NULL),
(150, 96, '1723185530_1.jpg', '2024-08-09 13:38:50', '2024-08-09 13:38:50', NULL),
(151, 97, '1723185987_0.jpg', '2024-08-09 13:46:27', '2024-08-09 13:46:27', NULL),
(152, 97, '1723185987_1.jpg', '2024-08-09 13:46:27', '2024-08-09 13:46:27', NULL);

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
(1, 'NURSING STAFF', '2024-06-18 14:59:00', '2024-06-18 14:59:00', NULL),
(2, 'ATTENDANT STAFF', '2024-06-18 14:59:25', '2024-06-18 14:59:25', NULL),
(3, 'PHYSIO', '2024-06-18 18:15:41', '2024-07-12 20:17:09', '2024-07-12 20:17:09'),
(4, 'BABY CARE', '2024-06-18 18:15:50', '2024-06-18 18:15:50', NULL),
(5, 'Test', '2024-07-11 14:51:12', '2024-07-11 14:51:29', '2024-07-11 14:51:29');

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
(23, 'UTTAR PRADESH', 1, NULL, '2024-06-18 17:44:25', NULL),
(24, 'WEST BENGAL', 0, NULL, NULL, NULL),
(25, 'DELHI', 0, NULL, '2024-07-04 13:36:29', NULL),
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
  `type` text NOT NULL,
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

INSERT INTO `users` (`id`, `role_id`, `name`, `type`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'DHC', 'ALL', 'superadmin@gmail.com', '2024-10-10 07:15:06', '$2y$12$rXd32Rd/H29ZzQAWhW.Vie7ZvE.RlqTBs36dGdSfgdYaV.0egBPeq', NULL, '2024-05-10 12:18:33', '2024-05-10 12:18:33', NULL),
(2, 2, 'Kartik Bhavsar', 'ALL', 'kartik.budtech@gmail.com', NULL, '$2y$12$rXd32Rd/H29ZzQAWhW.Vie7ZvE.RlqTBs36dGdSfgdYaV.0egBPeq', NULL, '2024-05-10 07:48:09', '2024-10-10 06:28:50', NULL),
(13, 2, 'Kartik Bhavsar', 'HSP', 'kartikbhavsar1757@gmail.com', NULL, '$2y$12$FdBNf3ktzaaI/pNNftlRm.4wdr3q/LocK.WdbXerraSxcQh7QGaOG', NULL, '2024-05-17 01:26:00', '2024-05-17 05:59:56', '2024-05-17 05:59:56'),
(14, 2, 'Stephen Jordan', 'DHC', 'gakyvux@mailinator.com', NULL, '$2y$12$ohIOWu3tocfN1JDzRZvPPuhnrBQJr8IpZLjDslBnd2rOgj7fPsfNa', NULL, '2024-05-17 06:08:18', '2024-05-17 06:08:30', '2024-05-17 06:08:30'),
(15, 7, 'DARSHNA JI SHALBY MANAGER', 'HSP', 'darshnatrivedi@gmail.com', NULL, '$2y$12$oBcQnyG2Zcz4v1f/ULBtqupAsIoegqgOZH0u8B8xL2MehSlNgawtS', NULL, '2024-07-16 14:56:46', '2024-07-16 14:56:46', NULL),
(16, 9, 'NISHA PATEL ACCOUNTANT', 'CRP', 'nishapatel@gmail.com', NULL, '$2y$12$5uB8vD6y3mD.ntNyvNcZheJAuRkO3zfQzLSeFY7qhzoR0SghADw2W', NULL, '2024-07-16 14:57:35', '2024-07-16 14:57:35', NULL),
(17, 10, 'PRASHANT JI', 'DHC', 'prashantchouhan@gmail.com', NULL, '$2y$12$5ekIM0Qa4sWNMroAPfX6se56.jfZfnpewPrX0O34IA4TZ0ezdd06O', NULL, '2024-07-16 14:59:18', '2024-10-10 01:58:00', NULL),
(18, 2, 'Abhishek Chaturvedi', 'DHC', 'abhishek.budtech@gmail.com', NULL, '$2y$12$rXd32Rd/H29ZzQAWhW.Vie7ZvE.RlqTBs36dGdSfgdYaV.0egBPeq', NULL, '2024-08-06 17:20:52', '2024-10-10 01:58:52', NULL),
(19, 2, 'Test Admin', 'HSP', 'testad@gmail.com', NULL, '$2y$12$3QS/esHKY0HBxmtpH7INfuAKmNB1fsmZiSiFwavIdVm88vAI/.uRa', NULL, '2024-10-10 01:58:39', '2024-10-10 01:58:39', NULL);

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
-- Indexes for table `booking_invoice`
--
ALTER TABLE `booking_invoice`
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `advance_salary_history`
--
ALTER TABLE `advance_salary_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `ambulance`
--
ALTER TABLE `ambulance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `area`
--
ALTER TABLE `area`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=116;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `booking_assign`
--
ALTER TABLE `booking_assign`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

--
-- AUTO_INCREMENT for table `booking_details`
--
ALTER TABLE `booking_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `booking_invoice`
--
ALTER TABLE `booking_invoice`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `booking_payments`
--
ALTER TABLE `booking_payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `booking_rating`
--
ALTER TABLE `booking_rating`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=605;

--
-- AUTO_INCREMENT for table `corporate`
--
ALTER TABLE `corporate`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `doctor`
--
ALTER TABLE `doctor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `equipment`
--
ALTER TABLE `equipment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hospital`
--
ALTER TABLE `hospital`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `patient`
--
ALTER TABLE `patient`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `shift`
--
ALTER TABLE `shift`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=98;

--
-- AUTO_INCREMENT for table `staff_documents`
--
ALTER TABLE `staff_documents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=153;

--
-- AUTO_INCREMENT for table `staff_type`
--
ALTER TABLE `staff_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `states`
--
ALTER TABLE `states`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
