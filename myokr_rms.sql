-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 30, 2024 at 08:06 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `myokr_rms`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`myokr`@`localhost` PROCEDURE `UpdateHierarchyProcedure` (IN `updated_child` INT)   BEGIN
  -- Create a temporary table to store the updated values
  CREATE TEMPORARY TABLE IF NOT EXISTS TempUpdate AS
  WITH RECURSIVE UpdateHierarchy AS (
    -- Base case: Start with the child node that was updated
    SELECT child, parent_id, value
    FROM t_okr_relation
    WHERE child = updated_child
    UNION ALL
    -- Recursive step: Update parent nodes with the sum of their children's values
    SELECT t.child, t.parent_id, SUM(u.value) AS new_value
    FROM t_okr_relation t
    INNER JOIN UpdateHierarchy u ON t.child = u.parent_id
    WHERE t.child <> updated_child -- Exclude the updated child node itself
  )
  SELECT * FROM UpdateHierarchy;

  -- Update the original table with the calculated values for parent nodes
  UPDATE t_okr_relation
  JOIN TempUpdate u ON t_okr_relation.child = u.child
  SET t_okr_relation.value = u.new_value;

  -- Drop the temporary table
  DROP TEMPORARY TABLE IF EXISTS TempUpdate;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `t_activity_result`
--

CREATE TABLE `t_activity_result` (
  `id` int(11) NOT NULL,
  `company_id` int(11) DEFAULT NULL,
  `group_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `total_point` int(11) DEFAULT NULL,
  `progress` int(11) DEFAULT NULL,
  `presence_id` varchar(25) DEFAULT NULL,
  `okr_result_id` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_date` date DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `modified_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `t_company`
--

CREATE TABLE `t_company` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `created_date` date NOT NULL,
  `created_by` int(11) NOT NULL,
  `modified_date` date NOT NULL,
  `modified_by` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `t_company`
--

INSERT INTO `t_company` (`id`, `name`, `address`, `created_date`, `created_by`, `modified_date`, `modified_by`, `status`) VALUES
(1, 'PT Graha Persada', 'JL Imam Bonjol 23 Jakarta', '2024-11-24', 1, '2024-11-24', 1, 1),
(2, 'PT Graha Persada', 'JL Imam Bonjol 23 Jakarta', '2024-11-24', 1, '2024-11-24', 1, 1),
(3, 'PT Graha Persada', 'JL Imam Bonjol 23 Jakarta', '2024-11-24', 1, '2024-11-24', 1, 1),
(4, 'Sales', '', '2024-11-24', 1, '2024-11-24', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `t_customer`
--

CREATE TABLE `t_customer` (
  `id` int(11) NOT NULL,
  `company_id` int(11) DEFAULT NULL,
  `owner_name` varchar(50) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `owner` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_date` date DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `modified_date` date DEFAULT NULL,
  `group_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `t_customer`
--

INSERT INTO `t_customer` (`id`, `company_id`, `owner_name`, `address`, `description`, `image`, `location`, `name`, `owner`, `phone`, `status`, `created_by`, `created_date`, `modified_by`, `modified_date`, `group_id`) VALUES
(1, 1, '123', '1.0.0', 'android', 'default.png', '0,0', 'Kantor Cabang', NULL, '08872637623', 'calon_mitra', 1, '2023-07-29', 1, '2023-07-29', 0),
(2, 1, 'Kantor Pusat', 'Jl. Bina Asih II No.09, RT.001/RW.009, Jatiasih, Kec. Jatiasih, Kota Bks, Jawa Barat 17423, Indonesia', 'ndnd', 'default.png', '-6.3025995, 106.9530531', 'Kantor Pusat', NULL, '989986895', 'calon mitra', 2, '2023-07-30', 2, '2023-07-30', 0);

-- --------------------------------------------------------

--
-- Table structure for table `t_group`
--

CREATE TABLE `t_group` (
  `id` int(11) NOT NULL,
  `company_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_date` date DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `modified_date` date DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `t_group`
--

INSERT INTO `t_group` (`id`, `company_id`, `name`, `type`, `description`, `created_by`, `created_date`, `modified_by`, `modified_date`, `status`) VALUES
(1, 1, 'Sales', 'group', 'Group of sales', 1, '2024-11-24', 1, '2024-11-24', 1),
(2, 1, 'Sales', 'group', 'Group of sales', 1, '2024-11-24', 1, '2024-11-24', 1),
(3, 1, 'Sales', 'group', 'Group of sales', 1, '2024-11-24', 1, '2024-11-24', 1);

-- --------------------------------------------------------

--
-- Table structure for table `t_group_assignment`
--

CREATE TABLE `t_group_assignment` (
  `id` int(11) NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_date` date DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `modified_date` date DEFAULT NULL,
  `group_id` int(11) DEFAULT NULL,
  `role` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `t_group_assignment`
--

INSERT INTO `t_group_assignment` (`id`, `created_by`, `created_date`, `modified_by`, `modified_date`, `group_id`, `role`, `user_id`) VALUES
(3, 3, '2023-11-06', 3, '2023-11-06', 1, 1, 7),
(4, 3, '2023-11-06', 3, '2023-11-06', 3, 1, 6);

-- --------------------------------------------------------

--
-- Table structure for table `t_okr`
--

CREATE TABLE `t_okr` (
  `id` int(11) NOT NULL,
  `okr_type` varchar(50) NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_date` date DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `modified_date` date DEFAULT NULL,
  `alert_achievement` int(11) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `objective_id` int(11) DEFAULT NULL,
  `objective_type` varchar(255) DEFAULT NULL,
  `skala_point` int(11) DEFAULT NULL,
  `target_point` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `year` int(11) DEFAULT NULL,
  `q_type` varchar(2) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `organization_id` int(11) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `unit` varchar(30) DEFAULT NULL,
  `type` varchar(25) DEFAULT NULL,
  `current_value` varchar(125) DEFAULT NULL,
  `target_value` varchar(125) DEFAULT NULL,
  `weight` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `point` int(11) DEFAULT NULL,
  `owner_id` int(11) DEFAULT NULL,
  `owner_type` int(11) DEFAULT NULL COMMENT '1 = group, 2 = employee'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `t_okr`
--

INSERT INTO `t_okr` (`id`, `okr_type`, `created_by`, `created_date`, `modified_by`, `modified_date`, `alert_achievement`, `company_id`, `description`, `objective_id`, `objective_type`, `skala_point`, `target_point`, `title`, `year`, `q_type`, `start_date`, `end_date`, `organization_id`, `parent_id`, `unit`, `type`, `current_value`, `target_value`, `weight`, `user_id`, `point`, `owner_id`, `owner_type`) VALUES
(1, 'objective', 3, '2023-11-06', 3, '2023-11-06', NULL, 1, 'hz', 0, 'Objective Aspirational', NULL, NULL, 'bbd', 2011, 'Q1', '2020-01-01', '2020-01-01', 1, 0, '-', '-', '', '0', 0, NULL, 0, 0, 0),
(2, 'keyresult', 3, '2023-11-06', 3, '2023-11-06', NULL, 1, 'hdhd', 0, 'Objective Aspirational', NULL, NULL, ' zbzj', 2023, '', '2023-11-06', '2023-11-15', 1, 1, 'Currency (Rp)', 'Should increase to', '19', '100', 1, NULL, 1, 0, 1),
(3, 'keyresult', 3, '2023-11-06', 3, '2023-11-06', NULL, 1, 'hd', 0, 'Objective Aspirational', NULL, NULL, 'hd', 2023, '', '2023-11-06', '2023-11-29', 2, 2, 'Currency (Rp)', 'Should increase to', '17', '100', 1, NULL, 1, 7, 2);

-- --------------------------------------------------------

--
-- Table structure for table `t_okr_assignment`
--

CREATE TABLE `t_okr_assignment` (
  `id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `child_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `t_okr_relation`
--

CREATE TABLE `t_okr_relation` (
  `id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `child` int(11) NOT NULL,
  `organization_id` int(11) NOT NULL,
  `value` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `t_okr_relation`
--

INSERT INTO `t_okr_relation` (`id`, `parent_id`, `child`, `organization_id`, `value`) VALUES
(2, 1, 2, 1, NULL),
(4, 2, 0, 3, NULL),
(5, 2, 3, 2, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `t_okr_result`
--

CREATE TABLE `t_okr_result` (
  `id` int(11) NOT NULL,
  `okr_assignment_id` int(11) NOT NULL,
  `presence_id` varchar(25) NOT NULL,
  `addition_value` varchar(100) NOT NULL,
  `addition_percentage` double NOT NULL,
  `status` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `t_okr_suggest`
--

CREATE TABLE `t_okr_suggest` (
  `id` int(11) NOT NULL,
  `okr_id` int(11) NOT NULL,
  `new_target` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0 COMMENT '0=pending, 1=approve',
  `created_by` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `modified_by` int(11) NOT NULL,
  `modified_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `t_okr_suggest`
--

INSERT INTO `t_okr_suggest` (`id`, `okr_id`, `new_target`, `status`, `created_by`, `created_date`, `modified_by`, `modified_date`) VALUES
(1, 3, '345', 0, 7, '2023-11-07 16:22:52', 7, '2023-11-07 16:22:52');

-- --------------------------------------------------------

--
-- Table structure for table `t_organization`
--

CREATE TABLE `t_organization` (
  `id` int(11) NOT NULL,
  `parent` int(11) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `description` varchar(125) NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_date` timestamp NULL DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `modified_date` timestamp NULL DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `type` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `t_organization`
--

INSERT INTO `t_organization` (`id`, `parent`, `name`, `description`, `created_by`, `created_date`, `modified_by`, `modified_date`, `company_id`, `type`, `user_id`) VALUES
(1, 0, 'ceo', 'gr', 3, '2023-11-06 07:24:44', 3, '2023-11-06 07:24:44', 1, 1, 0),
(2, 1, 'Aries', '', 3, '2023-11-06 07:24:53', 3, '2023-11-06 07:24:53', 1, 2, 7),
(3, 1, 'hr', 'hr gr', 3, '2023-11-06 07:25:10', 3, '2023-11-06 07:25:10', 1, 1, 0),
(4, 3, 'steven', '', 3, '2023-11-06 07:25:22', 3, '2023-11-06 07:25:22', 1, 2, 6);

-- --------------------------------------------------------

--
-- Table structure for table `t_presence`
--

CREATE TABLE `t_presence` (
  `id` varchar(25) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_date` date DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `modified_date` date DEFAULT NULL,
  `approval` varchar(255) DEFAULT 'pending',
  `clock_in` datetime DEFAULT NULL,
  `clock_out` datetime DEFAULT NULL,
  `evidence` varchar(255) DEFAULT NULL,
  `location_clock_in` varchar(255) DEFAULT NULL,
  `location_clock_out` varchar(255) DEFAULT NULL,
  `note` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `okr_impact` varchar(10) NOT NULL DEFAULT 'false',
  `activity` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `t_presence`
--

INSERT INTO `t_presence` (`id`, `created_by`, `created_date`, `modified_by`, `modified_date`, `approval`, `clock_in`, `clock_out`, `evidence`, `location_clock_in`, `location_clock_out`, `note`, `status`, `user_id`, `okr_impact`, `activity`) VALUES
('123', 1, '2024-10-10', 1, '2024-11-24', 'pending', '2024-10-10 12:00:01', '2024-10-10 12:00:00', 'img_evidence_1_20241124111240.jpg', '0,0', '0,0', NULL, 'out', 1, 'false', 'site visit'),
('123', 1, '2024-10-10', 1, '2024-11-24', 'pending', '2024-10-10 12:00:01', '2024-10-10 12:00:00', 'img_evidence_1_20241124111240.jpg', '0,0', '0,0', NULL, 'out', 1, 'false', 'site visit');

-- --------------------------------------------------------

--
-- Table structure for table `t_user`
--

CREATE TABLE `t_user` (
  `user_id` int(11) NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_date` date DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `modified_date` date DEFAULT NULL,
  `apps_script_url` varchar(255) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `employee_type` varchar(255) DEFAULT NULL,
  `firebase_token` varchar(255) DEFAULT NULL,
  `group_id` int(11) DEFAULT NULL,
  `jabatan` varchar(255) DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `nama_lengkap` varchar(255) DEFAULT NULL,
  `nik` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `role_id` int(11) DEFAULT 1,
  `status_user` varchar(255) DEFAULT NULL,
  `token` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `t_user`
--

INSERT INTO `t_user` (`user_id`, `created_by`, `created_date`, `modified_by`, `modified_date`, `apps_script_url`, `company_id`, `email`, `employee_type`, `firebase_token`, `group_id`, `jabatan`, `last_login`, `nama_lengkap`, `nik`, `password`, `phone`, `photo`, `role_id`, `status_user`, `token`) VALUES
(1, 1, '2020-10-09', 1, '2020-10-09', 'www.google.com', 1, 'admin@okr.id', 'admin', 'xz', 0, 'Admin', '2024-11-24 09:18:53', 'Admin System', 'Admin1', '21232f297a57a5a743894a0e4a801fc3', '0812312323', 'img_profile_1_20230724210951.jpg', 2, 'active', '0'),
(2, 1, '2023-07-24', 1, '2023-07-24', NULL, 1, 'user1@okr.id', 'Field Employee', '123', 0, NULL, '2023-09-21 16:24:48', 'User 1', 'A000001', 'ee11cbb19052e40b07aac0ca060c23ee', '085466565635655', 'img_profile_2_20230730095130.jpg', 1, NULL, NULL),
(3, 1, '2023-07-31', 1, '2023-07-31', NULL, 1, 'user@okr.id', 'Field Employee', '123', 0, NULL, '2023-12-21 09:19:44', 'user2', 'gdhdjsjejjedd', 'ee11cbb19052e40b07aac0ca060c23ee', '67646955', 'default.png', 2, NULL, NULL),
(4, 1, '2023-08-18', 1, '2023-08-18', NULL, 1, 'bambang@okr.id', 'Non Field Employee', '123', 0, NULL, '2023-09-20 22:13:35', 'bambang', 'A12334', 'ee11cbb19052e40b07aac0ca060c23ee', '08386434', 'default.png', 1, NULL, NULL),
(5, 1, '2023-08-18', 1, '2023-08-18', NULL, 1, 'rudi@okr.id', 'Non Field Employee', '123', 0, NULL, '2023-10-14 14:11:40', 'rudi', 'A23434', 'ee11cbb19052e40b07aac0ca060c23ee', '08386434', 'default.png', 1, NULL, NULL),
(6, 1, '2023-08-18', 1, '2023-08-18', NULL, 1, 'steven@okr.id', 'Non Field Employee', '123', 3, NULL, '2023-09-21 17:19:19', 'steven', 'A4343434', 'ee11cbb19052e40b07aac0ca060c23ee', '08386434', 'default.png', 1, NULL, NULL),
(7, 3, '2023-08-27', 3, '2023-08-27', NULL, 1, 'aries@okr.id', 'Field Employee', '123', 1, NULL, '2023-11-07 14:22:56', 'Aries', 'OKR001', 'ee11cbb19052e40b07aac0ca060c23ee', '0885213664645', 'default.png', 1, NULL, NULL),
(8, 3, '2023-09-21', 3, '2023-09-21', NULL, 1, 'user3@okr.id', 'Field Employee', '123', 0, NULL, '2023-09-21 17:18:44', 'user3', ' bananid', 'ee11cbb19052e40b07aac0ca060c23ee', '95956568668', 'default.png', 1, NULL, NULL),
(9, NULL, NULL, NULL, NULL, NULL, 1, 'test1@okr.id', NULL, '123', 0, NULL, '2023-12-21 09:19:05', 'user test 1', NULL, 'ee11cbb19052e40b07aac0ca060c23ee', NULL, NULL, 1, NULL, NULL),
(10, NULL, NULL, NULL, NULL, NULL, 1, 'test2@okr.id', NULL, '123', 0, NULL, '2023-11-06 13:55:59', 'user test 2', NULL, 'ee11cbb19052e40b07aac0ca060c23ee', '081289537549', 'img_profile_10_20230923195414.jpg', 1, NULL, NULL),
(11, NULL, NULL, NULL, NULL, NULL, 1, 'test3@okr.id', NULL, '123', 0, NULL, '2023-10-08 20:53:43', 'user test 3', NULL, 'ee11cbb19052e40b07aac0ca060c23ee', NULL, NULL, 1, NULL, NULL),
(12, NULL, NULL, NULL, NULL, NULL, 1, 'test4@okr.id', NULL, NULL, 0, NULL, NULL, 'user test 4', NULL, 'ee11cbb19052e40b07aac0ca060c23ee', NULL, NULL, 1, NULL, NULL),
(13, NULL, NULL, NULL, NULL, NULL, 1, 'test5@okr.id', NULL, NULL, 0, NULL, NULL, 'user test 5', NULL, 'ee11cbb19052e40b07aac0ca060c23ee', NULL, NULL, 1, NULL, NULL),
(14, NULL, NULL, NULL, NULL, NULL, 1, 'test6@okr.id', NULL, NULL, 0, NULL, NULL, 'user test 6', NULL, 'ee11cbb19052e40b07aac0ca060c23ee', NULL, NULL, 1, NULL, NULL),
(15, NULL, NULL, NULL, NULL, NULL, 1, 'test7@okr.id', NULL, '123', 0, NULL, '2023-10-08 21:00:18', 'user test 7', NULL, 'ee11cbb19052e40b07aac0ca060c23ee', NULL, NULL, 1, NULL, NULL),
(16, NULL, NULL, NULL, NULL, NULL, 1, 'test8@okr.id', NULL, '123', 0, NULL, '2023-10-08 21:01:06', 'user test 8', NULL, 'ee11cbb19052e40b07aac0ca060c23ee', NULL, NULL, 1, NULL, NULL),
(17, NULL, NULL, NULL, NULL, NULL, 1, 'test9@okr.id', NULL, '123', 0, NULL, '2023-10-02 10:04:29', 'user test 9', NULL, 'ee11cbb19052e40b07aac0ca060c23ee', NULL, NULL, 1, NULL, NULL),
(18, NULL, NULL, NULL, NULL, NULL, 1, 'test10@okr.id', NULL, NULL, 0, NULL, NULL, 'user test 10', NULL, 'ee11cbb19052e40b07aac0ca060c23ee', NULL, NULL, 1, NULL, NULL),
(19, NULL, NULL, NULL, NULL, NULL, 1, 'test11@okr.id', NULL, NULL, 0, NULL, NULL, 'user test 11', NULL, 'ee11cbb19052e40b07aac0ca060c23ee', NULL, NULL, 1, NULL, NULL),
(20, NULL, NULL, NULL, NULL, NULL, 1, 'test12@okr.id', NULL, NULL, 0, NULL, NULL, 'user test 12', NULL, 'ee11cbb19052e40b07aac0ca060c23ee', NULL, NULL, 1, NULL, NULL),
(21, 3, '2023-10-14', 3, '2023-10-14', NULL, 1, 'gun@okr.id', 'Field Employee', '123', 0, NULL, '2023-10-14 14:30:59', 'Gunawan', 'E098723', 'ee11cbb19052e40b07aac0ca060c23ee', '081289537549', 'default.png', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `t_user_token`
--

CREATE TABLE `t_user_token` (
  `created_by` int(11) DEFAULT NULL,
  `created_date` date DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `modified_date` date DEFAULT NULL,
  `device_name` varchar(255) DEFAULT NULL,
  `device_version` varchar(255) DEFAULT NULL,
  `expired_at` datetime DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `token` varchar(255) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_token` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `t_user_token`
--

INSERT INTO `t_user_token` (`created_by`, `created_date`, `modified_by`, `modified_date`, `device_name`, `device_version`, `expired_at`, `status`, `token`, `user_id`, `user_token`) VALUES
(1, '2023-07-24', 1, '2024-11-24', 'android', '1.0.0', '2023-07-31 21:03:47', 0, 'hFo2viPoQTtDwO5UnFcR', 1, 1),
(1, '2023-07-24', 1, '2024-11-24', 'android', '1.0.0', '2023-07-31 21:04:25', 0, 'sQQydREkm1aLbp+EIaG', 1, 2),
(1, '2023-07-24', 1, '2024-11-24', 'android', '1.0.0', '2023-07-31 21:09:51', 0, 'jhC6mXk1Wjt1TBRqxCtK', 1, 3),
(1, '2023-07-24', 1, '2024-11-24', 'android', '1.0.0', '2023-07-31 21:10:00', 0, 'lOjFRPkuVazaztCKZLXx', 1, 4),
(1, '2023-07-24', 1, '2024-11-24', 'android', '1.0.0', '2023-07-31 21:12:45', 0, 'iWA8PsU0ZAt5OzIT6CYM', 1, 5),
(1, '2023-07-24', 1, '2024-11-24', 'android', '1.0.0', '2023-07-31 21:16:00', 0, 'UtJhqyLNPPObTC5FVOIc', 1, 6),
(1, '2023-07-24', 1, '2024-11-24', 'android', '1.0.0', '2023-08-02 14:49:27', 0, 'rXDWnaOHW1IZQNEvhhO1', 1, 7),
(1, '2023-07-27', 1, '2024-11-24', 'android', '1.0.0', '2023-08-05 11:41:22', 0, 'CiaeIkQuamIp+04+nNO9', 1, 8),
(1, '2023-07-29', 1, '2024-11-24', 'android', '1.0.0', '2023-08-05 11:43:20', 0, 'ZXiGqQjf4jItqaoYvbK5', 1, 9),
(1, '2023-07-29', 1, '2024-11-24', 'android', '1.0.0', '2023-08-05 11:52:26', 0, 'QY360QCz4vgwY5vrFvQT', 1, 10),
(1, '2023-07-29', 1, '2024-11-24', 'android', '1.0.0', '2023-08-05 11:52:56', 0, 'OviXEKAPOujzrmGydTHd', 1, 11),
(2, '2023-07-29', 2, '2023-09-21', 'android', '1.0.0', '2023-08-05 11:54:04', 0, 'JSyDAWgnfZSHn1wC9hy', 2, 12),
(2, '2023-07-29', 2, '2023-09-21', 'android', '1.0.0', '2023-08-05 14:30:22', 0, 'b7HJT1B1r5bh7p8HaaFt', 2, 13),
(1, '2023-07-29', 1, '2024-11-24', 'android', '1.0.0', '2023-08-05 13:58:58', 0, '7fYDiGuM69NlpR4V1d9n', 1, 14),
(1, '2023-07-29', 1, '2024-11-24', 'android', '1.0.0', '2023-08-05 14:01:04', 0, 'Jj2V4iaSL9hLvlYNsZbk', 1, 15),
(1, '2023-07-29', 1, '2024-11-24', 'android', '1.0.0', '2023-08-05 14:06:40', 0, 'sGGAea+NcpyheR9YfR3n', 1, 16),
(1, '2023-07-29', 1, '2024-11-24', 'android', '1.0.0', '2023-08-05 14:34:58', 0, 'JpRVDSucsSbWACiEZ3jT', 1, 17),
(2, '2023-07-29', 2, '2023-09-21', 'android', '1.0.0', '2023-08-05 15:22:24', 0, 'YxTw20xPDmXXCGC8Ysy3', 2, 18),
(1, '2023-07-29', 1, '2024-11-24', 'android', '1.0.0', '2023-08-05 15:52:06', 0, 'MIAo94XFpatVbbsQX0AU', 1, 19),
(1, '2023-07-29', 1, '2024-11-24', 'android', '1.0.0', '2023-08-05 16:15:55', 0, 'beWW5t8DAhTjpflhYRG', 1, 20),
(2, '2023-07-30', 2, '2023-09-21', 'android', '1.0.0', '2023-08-06 06:15:55', 0, 'MYpRhyiyzr+z+Ihc+YTA', 2, 21),
(1, '2023-07-30', 1, '2024-11-24', 'android', '1.0.0', '2023-08-06 06:22:16', 0, 'tnZCDEsMGdwScdqj54ZN', 1, 22),
(2, '2023-07-30', 2, '2023-09-21', 'android', '1.0.0', '2023-08-06 06:18:45', 0, 'e+coqLDfIVanO9rQ7xXq', 2, 23),
(2, '2023-07-30', 2, '2023-09-21', 'android', '1.0.0', '2023-08-06 07:09:23', 0, 'WeThdzHkPe6ruMkXIdj', 2, 24),
(2, '2023-07-30', 2, '2023-09-21', 'android', '1.0.0', '2023-08-06 09:26:16', 0, '+AL0QQhqRXSrjA5nrwH', 2, 25),
(1, '2023-07-30', 1, '2024-11-24', 'android', '1.0.0', '2023-08-06 08:59:15', 0, '2v7rYhJ+DEf8y2uRcHpm', 1, 26),
(2, '2023-07-30', 2, '2023-09-21', 'android', '1.0.0', '2023-08-06 09:26:40', 0, 'wkNE4ODuD2UAGfcSihyV', 2, 27),
(2, '2023-07-30', 2, '2023-09-21', 'android', '1.0.0', '2023-08-06 09:51:43', 0, 'W1UGpyOPgCgxgK+zWXcm', 2, 28),
(2, '2023-07-30', 2, '2023-09-21', 'android', '1.0.0', '2023-08-06 16:30:07', 0, 'Chhzq1OaFFN5H7qCuXm', 2, 29),
(2, '2023-07-30', 2, '2023-09-21', 'android', '1.0.0', '2023-08-07 06:38:04', 0, '1qJlh2MEjhgrL74p6pEb', 2, 30),
(2, '2023-07-31', 2, '2023-09-21', 'android', '1.0.0', '2023-08-07 06:38:27', 0, 'PyntAUDJDyJtMkjcpGZk', 2, 31),
(1, '2023-07-31', 1, '2024-11-24', 'android', '1.0.0', '2023-08-07 10:32:07', 0, 'PGawZeY8kLEnfJugXj2', 1, 32),
(2, '2023-07-31', 2, '2023-09-21', 'android', '1.0.0', '2023-08-07 10:46:26', 0, 'cTrD3eoHSpdx1L55UVI', 2, 33),
(2, '2023-07-31', 2, '2023-09-21', 'android', '1.0.0', '2023-08-07 10:49:19', 0, 'YvdHAgpwNq7JvavpXjMh', 2, 34),
(2, '2023-07-31', 2, '2023-09-21', 'android', '1.0.0', '2023-08-07 10:52:19', 0, 'soSZJ0wW7ky+2b7n3B7L', 2, 35),
(1, '2023-07-31', 1, '2024-11-24', 'android', '1.0.0', '2023-08-07 10:55:31', 0, 'EwGIXxAmistQpzdG1uNv', 1, 36),
(3, '2023-07-31', 3, '2023-12-21', 'android', '1.0.0', '2023-08-07 10:57:15', 0, 'n0E3cnFxI4g5j6vQHbS', 3, 37),
(2, '2023-07-31', 2, '2023-09-21', 'android', '1.0.0', '2023-08-07 11:13:24', 0, '8KJ0uaHTVnYqDUW+VX', 2, 38),
(2, '2023-07-31', 2, '2023-09-21', 'android', '1.0.0', '2023-08-13 13:54:40', 0, 'nftGQFs9Bl8Pvp27kVXa', 2, 39),
(1, '2023-08-01', 1, '2024-11-24', 'android', '1.0.0', '2023-08-08 13:35:21', 0, 'w7L3YUgj5nEzdVu3how', 1, 40),
(1, '2023-08-06', 1, '2024-11-24', 'android', '1.0.0', '2023-08-13 13:57:34', 0, 'r0TTNdVGWA9g4j8R1500', 1, 41),
(2, '2023-08-07', 2, '2023-09-21', 'android', '1.0.0', '2023-08-14 09:25:33', 0, 'fk5G4MVx2k4vkrcQ0BKc', 2, 42),
(1, '2023-08-07', 1, '2024-11-24', 'android', '1.0.0', '2023-08-14 10:37:52', 0, '8tz7t6GT7AHtJ3HWShRt', 1, 43),
(1, '2023-08-07', 1, '2024-11-24', 'android', '1.0.0', '2023-08-14 11:01:57', 0, 'Qecv4iCE7XRCqgKuCpv', 1, 44),
(1, '2023-08-07', 1, '2024-11-24', 'android', '1.0.0', '2023-08-14 11:05:19', 0, 'BgXeMP9jacJqCGvkMl', 1, 45),
(1, '2023-08-07', 1, '2024-11-24', 'android', '1.0.0', '2023-08-14 14:43:46', 0, 'shnSu+980nY3M1IYInVM', 1, 46),
(3, '2023-08-07', 3, '2023-12-21', 'android', '1.0.0', '2023-08-14 14:44:26', 0, 'kz8aemYYj28Nbxq55S', 3, 47),
(2, '2023-08-07', 2, '2023-09-21', 'android', '1.0.0', '2023-08-14 14:48:12', 0, 'AxGCHi66gIvrInmzC9tI', 2, 48),
(1, '2023-08-07', 1, '2024-11-24', 'android', '1.0.0', '2023-08-14 14:48:55', 0, '3EP6j663Ks1krCokazY', 1, 49),
(2, '2023-08-07', 2, '2023-09-21', 'android', '1.0.0', '2023-08-14 14:53:57', 0, 'd0l+kaezpGmSx7BlLkbp', 2, 50),
(1, '2023-08-07', 1, '2024-11-24', 'android', '1.0.0', '2023-08-14 14:54:46', 0, 'iDfBNmd8qEcXDDJ6ZEH', 1, 51),
(1, '2023-08-07', 1, '2024-11-24', 'android', '1.0.0', '2023-08-14 23:41:52', 0, 'ZLXj5lerxj8+9+hbUagd', 1, 52),
(2, '2023-08-08', 2, '2023-09-21', 'android', '1.0.0', '2023-08-15 11:32:11', 0, 'StHV4H85ITezwWM0K6Nn', 2, 53),
(1, '2023-08-08', 1, '2024-11-24', 'android', '1.0.0', '2023-08-15 21:16:52', 0, 'WO0fejSUt5xL2jKLpihb', 1, 54),
(1, '2023-08-09', 1, '2024-11-24', 'android', '1.0.0', '2023-08-16 09:57:27', 0, 'LrPoSeIrx5qpsGJAICwU', 1, 55),
(1, '2023-08-12', 1, '2024-11-24', 'android', '1.0.0', '2023-08-20 10:31:58', 0, 'td5mqKNwNJxf4Cd6AF8', 1, 56),
(3, '2023-08-12', 3, '2023-12-21', 'android', '1.0.0', '2023-08-19 09:15:38', 0, 'btA071sZDSTCCNhMyEM', 3, 57),
(3, '2023-08-12', 3, '2023-12-21', 'android', '1.0.0', '2023-08-19 13:23:30', 0, 'jtyjA5bYdAtd2TA8y0cs', 3, 58),
(3, '2023-08-12', 3, '2023-12-21', 'android', '1.0.0', '2023-08-25 07:58:35', 0, 'xDDp1WXWGXfY0anqvA2j', 3, 59),
(1, '2023-08-15', 1, '2024-11-24', 'android', '1.0.0', '2023-08-22 20:18:35', 0, 'ATmuz2X1uyDhmWCO7MDu', 1, 60),
(3, '2023-08-18', 3, '2023-12-21', 'android', '1.0.0', '2023-08-25 15:05:20', 0, 'Gd8O4IJfgjpzYxAZsOMP', 3, 61),
(1, '2023-08-18', 1, '2024-11-24', 'android', '1.0.0', '2023-08-27 14:13:59', 0, 'RWIQe7npOqzSJQMua+Dp', 1, 62),
(3, '2023-08-18', 3, '2023-12-21', 'android', '1.0.0', '2023-08-25 17:09:23', 0, 'VZGg9imtqKoCHGjH1DPZ', 3, 63),
(3, '2023-08-18', 3, '2023-12-21', 'android', '1.0.0', '2023-08-27 09:27:33', 0, 'IPeaEw7UYlNBDDjT+IyW', 3, 64),
(3, '2023-08-20', 3, '2023-12-21', 'android', '1.0.0', '2023-08-27 13:58:50', 0, 'XubJISwuWWLnBNIA1Hh5', 3, 65),
(3, '2023-08-20', 3, '2023-12-21', 'android', '1.0.0', '2023-08-27 14:31:12', 0, 'PynK4tELu0qTNrepgx9C', 3, 66),
(3, '2023-08-20', 3, '2023-12-21', 'android', '1.0.0', '2023-08-27 15:01:34', 0, '4RIe6PPPrGjpmQhmqDV', 3, 67),
(3, '2023-08-20', 3, '2023-12-21', 'android', '1.0.0', '2023-08-27 19:25:53', 0, 'QNXHlgtj4G7OETGtLYF', 3, 68),
(1, '2023-08-20', 1, '2024-11-24', 'android', '1.0.0', '2023-08-27 20:03:56', 0, '2cSpyarVpUsqnbqLlhc', 1, 69),
(1, '2023-08-20', 1, '2024-11-24', 'android', '1.0.0', '2023-08-27 20:53:18', 0, 'LHeXZHSsZd0NNjjFX7Vg', 1, 70),
(1, '2023-08-20', 1, '2024-11-24', NULL, NULL, '2023-08-27 20:54:02', 0, '4Gm5PCLu6wKTWchvjPBg', 1, 71),
(3, '2023-08-20', 3, '2023-12-21', NULL, NULL, '2023-08-27 20:54:18', 0, '+YeiDZwGdQF80PY8LfIb', 3, 72),
(3, '2023-08-20', 3, '2023-12-21', NULL, NULL, '2023-08-27 20:58:18', 0, 'L06AQw5Ryw20Qgck3Dp9', 3, 73),
(3, '2023-08-20', 3, '2023-12-21', NULL, NULL, '2023-08-27 20:59:24', 0, 'U8J14dCsRwaeYFJYiLtO', 3, 74),
(3, '2023-08-20', 3, '2023-12-21', NULL, NULL, '2023-08-27 21:04:19', 0, 'sdKrJu7pjgcXfA7DTbXg', 3, 75),
(3, '2023-08-20', 3, '2023-12-21', NULL, NULL, '2023-08-27 21:04:37', 0, 'TdiWNGGwdTqgRLxLzCqw', 3, 76),
(3, '2023-08-20', 3, '2023-12-21', NULL, NULL, '2023-08-27 21:08:35', 0, 'YOg2hRO7iP62twOcKXtv', 3, 77),
(3, '2023-08-20', 3, '2023-12-21', NULL, NULL, '2023-08-27 21:10:24', 0, 'ujm6CO9MQbNnAKpOJhSz', 3, 78),
(3, '2023-08-20', 3, '2023-12-21', NULL, NULL, '2023-08-27 21:57:45', 0, 'Nl34XHtfUFn8OEr+dY0m', 3, 79),
(1, '2023-08-20', 1, '2024-11-24', NULL, NULL, '2023-08-28 19:30:06', 0, 'VntlPh00YHW02pxNbain', 1, 80),
(3, '2023-08-20', 3, '2023-12-21', NULL, NULL, '2023-08-27 22:26:53', 0, 'nXl8s+dd6jFf533MIf4', 3, 81),
(3, '2023-08-21', 3, '2023-12-21', 'android', '1.0.0', '2023-08-28 09:12:06', 0, 'OSKTljWLgbnSh58MOCWe', 3, 82),
(3, '2023-08-21', 3, '2023-12-21', 'android', '1.0.0', '2023-08-28 19:33:10', 0, 'WIlG4BRaer5MxhFVjwQq', 3, 83),
(3, '2023-08-23', 3, '2023-12-21', 'android', '1.0.0', '2023-09-03 21:07:26', 0, 'TiIwNszsBjwQMbVpr2yP', 3, 84),
(1, '2023-08-23', 1, '2024-11-24', 'android', '1.0.0', '2023-08-31 22:33:29', 0, 'TJyBgkQTYrBnkl8mDOPK', 1, 85),
(1, '2023-08-25', 1, '2024-11-24', 'android', '1.0.0', '2023-09-03 21:57:47', 0, '0ywifmBX7ygZElQiUh9X', 1, 86),
(2, '2023-08-27', 2, '2023-09-21', 'android', '1.0.0', '2023-09-03 21:30:41', 0, 'Vomm5Kcvykt4Mzg3o+Fh', 2, 87),
(3, '2023-08-27', 3, '2023-12-21', 'android', '1.0.0', '2023-09-03 22:05:31', 0, 'q7CDd4w+JDnWqIoKXOxf', 3, 88),
(7, '2023-08-27', 7, '2023-11-07', 'android', '1.0.0', '2023-09-08 20:58:16', 0, 'ePvQJlMwsEqzPqhV9FIJ', 7, 89),
(1, '2023-09-01', 1, '2024-11-24', 'android', '1.0.0', '2023-09-17 09:20:08', 0, 'XVIKj2O6UFr9fGqSFDwc', 1, 90),
(3, '2023-09-01', 3, '2023-12-21', 'android', '1.0.0', '2023-09-09 09:50:20', 0, 'TyljHZzfdt3GFSgTE7jv', 3, 91),
(7, '2023-09-02', 7, '2023-11-07', 'android', '1.0.0', '2023-09-09 21:26:21', 0, 'dkSlc5kzKi5GpYH7vXlW', 7, 92),
(3, '2023-09-02', 3, '2023-12-21', 'android', '1.0.0', '2023-09-09 21:28:03', 0, '3jxa5dMmOi8DvvQ1vTJ', 3, 93),
(7, '2023-09-02', 7, '2023-11-07', 'android', '1.0.0', '2023-09-13 10:36:25', 0, '9apQPYdlvUm3Jvo4VBC', 7, 94),
(7, '2023-09-08', 7, '2023-11-07', 'android', '1.0.0', '2023-09-15 20:57:02', 0, 'jaXen8l3PfW4x3J0UPM', 7, 95),
(7, '2023-09-09', 7, '2023-11-07', 'android', '1.0.0', '2023-09-17 09:03:57', 0, 'QxeVam02FREi7qJhEEaC', 7, 96),
(3, '2023-09-10', 3, '2023-12-21', 'android', '1.0.0', '2023-09-17 09:12:20', 0, 'QFqOnkGbgjPo2Et4YLXc', 3, 97),
(4, '2023-09-10', 4, '2023-09-20', 'android', '1.0.0', '2023-09-17 09:12:47', 0, 'pH0GvlMYbj0ngTiyE+tO', 4, 98),
(7, '2023-09-10', 7, '2023-11-07', 'android', '1.0.0', '2023-09-17 09:28:49', 0, 'Q0VF374H0Wwgar52ZJGV', 7, 99),
(4, '2023-09-10', 4, '2023-09-20', 'android', '1.0.0', '2023-09-17 09:29:29', 0, 'm117V3YgTdEmMQnLRzq2', 4, 100),
(7, '2023-09-10', 7, '2023-11-07', 'android', '1.0.0', '2023-09-17 12:24:00', 0, 'U2RiaVWmBE5UJhV4Yz2S', 7, 101),
(7, '2023-09-11', 7, '2023-11-07', 'android', '1.0.0', '2023-09-19 14:43:26', 0, 'eN7xwVqcoKkAUEDov85', 7, 102),
(1, '2023-09-11', 1, '2024-11-24', NULL, NULL, '2023-09-18 16:24:39', 0, 'eu9Qzf0MZQl502YjuiRd', 1, 103),
(3, '2023-09-12', 3, '2023-12-21', 'android', '1.0.0', '2023-09-19 14:44:07', 0, 'vcRvc0eg27wyi80Y2dSh', 3, 104),
(3, '2023-09-13', 3, '2023-12-21', 'android', '1.0.0', '2023-09-20 14:33:27', 0, 'V9kEJmxk7E+d7n9VU5Xl', 3, 105),
(5, '2023-09-13', 5, '2023-10-14', 'android', '1.0.0', '2023-09-20 16:36:10', 0, 'sxeIDnm6hwxc1OLFrRX', 5, 106),
(6, '2023-09-13', 6, '2023-09-21', 'android', '1.0.0', '2023-09-21 08:58:55', 0, 'wpZxiFnZPpCSw1VaflW', 6, 107),
(1, '2023-09-13', 1, '2024-11-24', NULL, NULL, '2023-09-21 08:41:18', 0, 'i3TWaVdpglCK+gkae1nx', 1, 108),
(1, '2023-09-14', 1, '2024-11-24', NULL, NULL, '2023-09-28 09:19:34', 0, 'cgteFjVVST86uG1N39Z', 1, 109),
(6, '2023-09-14', 6, '2023-09-21', 'android', '1.0.0', '2023-09-21 09:07:12', 0, '1Sy+AUEuM6uadpUcb57N', 6, 110),
(6, '2023-09-14', 6, '2023-09-21', 'android', '1.0.0', '2023-09-21 11:24:59', 0, 'z7zaM+DbLzmgNUcQk3X', 6, 111),
(5, '2023-09-14', 5, '2023-10-14', 'android', '1.0.0', '2023-09-21 11:25:43', 0, 'wKOpnT1J2qZ1eu8ZDuaQ', 5, 112),
(6, '2023-09-14', 6, '2023-09-21', 'android', '1.0.0', '2023-09-21 11:31:48', 0, '0CE8fUS0d17vC4Gt0Hm', 6, 113),
(5, '2023-09-14', 5, '2023-10-14', 'android', '1.0.0', '2023-09-21 11:32:13', 0, 'Vs0RY0z9thR7nLvAbdLM', 5, 114),
(6, '2023-09-14', 6, '2023-09-21', 'android', '1.0.0', '2023-09-21 11:35:21', 0, 'UFnqMYVGahFk4EfbnNYc', 6, 115),
(5, '2023-09-14', 5, '2023-10-14', 'android', '1.0.0', '2023-09-21 11:35:50', 0, '7kvcW9H4jXuZD8+qbHXP', 5, 116),
(6, '2023-09-14', 6, '2023-09-21', 'android', '1.0.0', '2023-09-21 14:10:04', 0, '5BVr1hfAMLfOiOr8yODJ', 6, 117),
(5, '2023-09-14', 5, '2023-10-14', 'android', '1.0.0', '2023-09-21 14:27:29', 0, 'Euxty8JTJCSQP8U0XJ3o', 5, 118),
(6, '2023-09-14', 6, '2023-09-21', 'android', '1.0.0', '2023-09-21 14:29:52', 0, 'uKrITHohi+fpXnVIUJYT', 6, 119),
(3, '2023-09-14', 3, '2023-12-21', 'android', '1.0.0', '2023-09-21 14:37:50', 0, 'Rv2a6p89Wp1WFn3NPGs', 3, 120),
(5, '2023-09-14', 5, '2023-10-14', 'android', '1.0.0', '2023-09-21 14:39:13', 0, '+fNuwCoxhP45d66I4A6l', 5, 121),
(4, '2023-09-14', 4, '2023-09-20', 'android', '1.0.0', '2023-09-21 14:39:49', 0, '+1EZT6UQrJVPe2jiRKg', 4, 122),
(6, '2023-09-14', 6, '2023-09-21', 'android', '1.0.0', '2023-09-21 14:41:15', 0, 'JgGcgxQTnu2tfpNAatF5', 6, 123),
(5, '2023-09-14', 5, '2023-10-14', 'android', '1.0.0', '2023-09-21 14:42:30', 0, '6f4IKbyb5OAX0sqSd6w3', 5, 124),
(4, '2023-09-14', 4, '2023-09-20', 'android', '1.0.0', '2023-09-21 14:43:08', 0, 'uyRKOwVMOpigcrizznWj', 4, 125),
(6, '2023-09-14', 6, '2023-09-21', 'android', '1.0.0', '2023-09-21 14:46:59', 0, 'prIgnHTMCa1d75smiKJj', 6, 126),
(3, '2023-09-14', 3, '2023-12-21', 'android', '1.0.0', '2023-09-21 15:59:07', 0, 'a11JXOf7nTrXG21oVkFb', 3, 127),
(6, '2023-09-14', 6, '2023-09-21', 'android', '1.0.0', '2023-09-21 15:59:22', 0, 'TMvrzdLdoNNb4Zzeqmh5', 6, 128),
(3, '2023-09-14', 3, '2023-12-21', 'android', '1.0.0', '2023-09-21 16:14:07', 0, 'J53xuXF7hUCdztT2Sum3', 3, 129),
(3, '2023-09-14', 3, '2023-12-21', 'android', '1.0.0', '2023-09-21 16:23:58', 0, 'Vlr3UYspwTxNhtvd9NAp', 3, 130),
(5, '2023-09-14', 5, '2023-10-14', 'android', '1.0.0', '2023-09-21 16:24:31', 0, 'gPTO72X0nlvNPvCzk436', 5, 131),
(3, '2023-09-14', 3, '2023-12-21', 'android', '1.0.0', '2023-09-21 16:30:02', 0, 'G0OELaE1iIcX0C85pfTY', 3, 132),
(5, '2023-09-14', 5, '2023-10-14', 'android', '1.0.0', '2023-09-21 16:31:01', 0, 'iQv0iscAzHH4PwJdtGYE', 5, 133),
(3, '2023-09-14', 3, '2023-12-21', 'android', '1.0.0', '2023-09-21 16:50:31', 0, 'uc2nBmYM8C657Fyygi+e', 3, 134),
(5, '2023-09-14', 5, '2023-10-14', 'android', '1.0.0', '2023-09-21 16:53:32', 0, 'PryXAvv8uFsPqAIWXI48', 5, 135),
(6, '2023-09-14', 6, '2023-09-21', 'android', '1.0.0', '2023-09-21 16:58:59', 0, 'KFFrLJdpfvEcW2GzkU3', 6, 136),
(3, '2023-09-14', 3, '2023-12-21', 'android', '1.0.0', '2023-09-25 09:55:38', 0, 'yzLplBVSIRnr+jmSEnw', 3, 137),
(5, '2023-09-18', 5, '2023-10-14', 'android', '1.0.0', '2023-09-25 09:59:11', 0, 'Wi3MVVKjhLq++mli+sC', 5, 138),
(3, '2023-09-18', 3, '2023-12-21', 'android', '1.0.0', '2023-09-27 14:55:49', 0, 'Ca6+a2bu1Pe8kcuBwDH', 3, 139),
(4, '2023-09-20', 4, '2023-09-20', 'android', '1.0.0', '2023-09-27 14:58:06', 0, 'sp3aZ7WZeBK+++n5022a', 4, 140),
(3, '2023-09-20', 3, '2023-12-21', 'android', '1.0.0', '2023-09-27 15:04:52', 0, '7XFhwTfa6fFPKEOPuqA', 3, 141),
(4, '2023-09-20', 4, '2023-09-20', 'android', '1.0.0', '2023-09-27 15:30:20', 0, '0T88ootx6QQyBrAtlvlo', 4, 142),
(4, '2023-09-20', 4, '2023-09-20', 'android', '1.0.0', '2023-09-27 15:40:04', 0, '91x0jkME8hqtqjvhDfnU', 4, 143),
(7, '2023-09-20', 7, '2023-11-07', 'android', '1.0.0', '2023-09-27 16:54:23', 0, 'AxoyUugCUnzdjOAqFloP', 7, 144),
(3, '2023-09-20', 3, '2023-12-21', 'android', '1.0.0', '2023-09-27 17:03:19', 0, 'KfHF8TtIuQ4mzLSQaOv', 3, 145),
(7, '2023-09-20', 7, '2023-11-07', 'android', '1.0.0', '2023-09-27 17:03:30', 0, 'kOHg51hNBjO1PPniVag', 7, 146),
(4, '2023-09-20', 4, '2023-09-20', 'android', '1.0.0', '2023-09-27 17:03:59', 0, 'XkQQRfo+whHAet6n83qA', 4, 147),
(7, '2023-09-20', 7, '2023-11-07', 'android', '1.0.0', '2023-09-27 22:13:20', 0, 'Ertf00PLox5OqK+MfaZ', 7, 148),
(4, '2023-09-20', 4, '2023-09-20', 'android', '1.0.0', '2023-09-27 22:28:58', 1, 'vkeLtdJdMBNQKpvXwTK5', 4, 149),
(3, '2023-09-20', 3, '2023-12-21', 'android', '1.0.0', '2023-09-27 22:29:21', 0, 'F8WNPQQ5ahOo14xkm2u+', 3, 150),
(3, '2023-09-20', 3, '2023-12-21', 'android', '1.0.0', '2023-09-27 22:39:18', 0, 'ax2jQf5tuYAEtfVN1n7', 3, 151),
(5, '2023-09-20', 5, '2023-10-14', 'android', '1.0.0', '2023-09-27 22:39:49', 0, '0ebe7rzy0E+n1xK9PXaQ', 5, 152),
(7, '2023-09-20', 7, '2023-11-07', 'android', '1.0.0', '2023-09-28 08:50:26', 0, 'BmemtQuFb97l7rk4bPY7', 7, 153),
(3, '2023-09-21', 3, '2023-12-21', 'android', '1.0.0', '2023-09-28 16:12:51', 0, 'ZyXjmyWkoB13fhNpF+h5', 3, 154),
(6, '2023-09-21', 6, '2023-09-21', 'android', '1.0.0', '2023-09-28 16:13:21', 0, 'GEp+Pk2RDa0aClezixEh', 6, 155),
(7, '2023-09-21', 7, '2023-11-07', 'android', '1.0.0', '2023-09-28 16:23:38', 0, 'On7QXBMumNWLEMwXC3BM', 7, 156),
(3, '2023-09-21', 3, '2023-12-21', 'android', '1.0.0', '2023-09-28 16:24:39', 0, 'tZF7CO7XmXHTPkIVLp1I', 3, 157),
(2, '2023-09-21', 2, '2023-09-21', 'android', '1.0.0', '2023-09-28 16:25:01', 1, 'W6b4mbfX6XlDcbo1BTXr', 2, 158),
(7, '2023-09-21', 7, '2023-11-07', 'android', '1.0.0', '2023-09-28 16:32:01', 0, 'lYCk+Ctnl2RwCbKDj8U', 7, 159),
(3, '2023-09-21', 3, '2023-12-21', 'android', '1.0.0', '2023-09-28 16:32:27', 0, 'epvVQxSi1hCZqqvTUwL', 3, 160),
(5, '2023-09-21', 5, '2023-10-14', 'android', '1.0.0', '2023-09-28 16:32:52', 0, 'paqqigPyaHlcRXLgQrgT', 5, 161),
(7, '2023-09-21', 7, '2023-11-07', 'android', '1.0.0', '2023-09-28 17:09:32', 0, 'Ge1yKRigyX1MXsTt4u', 7, 162),
(6, '2023-09-21', 6, '2023-09-21', 'android', '1.0.0', '2023-09-28 17:09:59', 0, '9KJTcCufnHy6g22ie3tn', 6, 163),
(3, '2023-09-21', 3, '2023-12-21', 'android', '1.0.0', '2023-09-28 17:10:19', 0, '98p7vinFU5plbKDEtv8g', 3, 164),
(6, '2023-09-21', 6, '2023-09-21', 'android', '1.0.0', '2023-09-28 17:11:41', 0, '+cZ4ukZQIg2WIkJvjvf', 6, 165),
(3, '2023-09-21', 3, '2023-12-21', 'android', '1.0.0', '2023-09-28 17:13:32', 0, 'XBp8WmwncjRYvYqDOoml', 3, 166),
(3, '2023-09-21', 3, '2023-12-21', 'android', '1.0.0', '2023-09-28 17:18:23', 0, 'k2gOxGvefg3HeaZDj5jh', 3, 167),
(8, '2023-09-21', 8, '2023-09-21', 'android', '1.0.0', '2023-09-28 17:19:00', 1, 't0CoMDP+IyenVaseCw+2', 8, 168),
(6, '2023-09-21', 6, '2023-09-21', 'android', '1.0.0', '2023-09-28 21:04:59', 1, 'Scf679fDssMUdqTWBVj', 6, 169),
(7, '2023-09-21', 7, '2023-11-07', 'android', '1.0.0', '2023-09-28 21:05:50', 0, 'ShryA9x8xnc3no7dKihq', 7, 170),
(3, '2023-09-21', 3, '2023-12-21', 'android', '1.0.0', '2023-09-28 21:19:28', 0, '3EvjGk6vOYq5a5HDq3kh', 3, 171),
(3, '2023-09-22', 3, '2023-12-21', 'android', '1.0.0', '2023-09-29 07:25:02', 0, 'hCS0bJHcomtcR1D+Xufu', 3, 172),
(9, '2023-09-22', 9, '2023-12-21', 'android', '1.0.0', '2023-09-29 07:25:56', 0, 'AckKK8FQYosoNQtcIJvf', 9, 173),
(3, '2023-09-22', 3, '2023-12-21', 'android', '1.0.0', '2023-09-30 10:11:12', 0, 'jHZe2qzg9DnCQb836wO', 3, 174),
(3, '2023-09-23', 3, '2023-12-21', 'android', '1.0.0', '2023-09-30 10:21:47', 0, 'B8kfDhCTq07igcXLjHHJ', 3, 175),
(10, '2023-09-23', 10, '2023-11-06', 'android', '1.0.0', '2023-09-30 10:22:34', 0, '3QM9BvVMNHnqH7T89BNV', 10, 176),
(10, '2023-09-23', 10, '2023-11-06', 'android', '1.0.0', '2023-09-30 10:28:29', 0, 'dHP1ZNjEsrD3Dt+09VCd', 10, 177),
(3, '2023-09-23', 3, '2023-12-21', 'android', '1.0.0', '2023-09-30 11:30:32', 0, 'pOVBLkW0YKMQQqT2eiZ+', 3, 178),
(10, '2023-09-23', 10, '2023-11-06', 'android', '1.0.0', '2023-09-30 15:44:47', 0, 'OY7TrzIqPlVnqt2CsH1n', 10, 179),
(3, '2023-09-23', 3, '2023-12-21', 'android', '1.0.0', '2023-09-30 15:46:01', 0, 'mbKosLtbQYx7DFa3sJaJ', 3, 180),
(10, '2023-09-23', 10, '2023-11-06', 'android', '1.0.0', '2023-09-30 15:48:05', 0, 'maodhUWvWpooAdEniFtW', 10, 181),
(10, '2023-09-23', 10, '2023-11-06', 'android', '1.0.0', '2023-09-30 19:51:21', 0, '9G6p9EnxoqrsapzgR7WB', 10, 182),
(10, '2023-09-23', 10, '2023-11-06', 'android', '1.0.0', '2023-09-30 19:55:00', 0, 'ucyth5L4aYq6fn2y821', 10, 183),
(3, '2023-09-23', 3, '2023-12-21', 'android', '1.0.0', '2023-09-30 19:56:06', 0, '2YyuArAWuUD2e2BpTl5C', 3, 184),
(11, '2023-09-23', 11, '2023-10-08', 'android', '1.0.0', '2023-09-30 19:56:53', 0, 's32HJpvLNr1+wltEjthX', 11, 185),
(10, '2023-09-23', 10, '2023-11-06', 'android', '1.0.0', '2023-09-30 19:57:16', 0, 'wTvZsR37TfVCZgfIvII2', 10, 186),
(3, '2023-09-23', 3, '2023-12-21', 'android', '1.0.0', '2023-09-30 20:02:50', 0, 'R1nnff9OvVrjED8lZgvg', 3, 187),
(10, '2023-09-23', 10, '2023-11-06', 'android', '1.0.0', '2023-09-30 20:03:22', 0, 'OCL5SC47IvBLhvFAYb0V', 10, 188),
(10, '2023-09-23', 10, '2023-11-06', 'android', '1.0.0', '2023-09-30 20:03:27', 0, 'yjRb61Pf9LPWKSyBPE4i', 10, 189),
(10, '2023-09-23', 10, '2023-11-06', 'android', '1.0.0', '2023-09-30 20:05:43', 0, 'hbTG8PgrlhlDtFWWpJh5', 10, 190),
(3, '2023-09-23', 3, '2023-12-21', 'android', '1.0.0', '2023-09-30 20:36:57', 0, 'XZIPm7oAMDWE3bcSGiPY', 3, 191),
(10, '2023-09-23', 10, '2023-11-06', 'android', '1.0.0', '2023-10-01 10:42:57', 0, 'cizdH5qwmVCtAoi5eVPG', 10, 192),
(3, '2023-09-24', 3, '2023-12-21', 'android', '1.0.0', '2023-10-01 10:44:43', 0, '4u9lqRdEQfM3VfA203C', 3, 193),
(10, '2023-09-24', 10, '2023-11-06', 'android', '1.0.0', '2023-10-01 12:55:31', 0, 'BgSq4954V9nnX+kZDMSl', 10, 194),
(3, '2023-09-24', 3, '2023-12-21', 'android', '1.0.0', '2023-10-01 13:35:32', 0, 'lflA7csZcT2kI7nN05zP', 3, 195),
(3, '2023-09-24', 3, '2023-12-21', 'android', '1.0.0', '2023-10-01 13:39:01', 0, '9KStL79UjVe4BbT1+zRl', 3, 196),
(3, '2023-09-24', 3, '2023-12-21', 'android', '1.0.0', '2023-10-01 13:39:07', 0, '3yww5R0d5H8gyG5oHRG', 3, 197),
(10, '2023-09-24', 10, '2023-11-06', 'android', '1.0.0', '2023-10-01 13:41:37', 0, 'QYhCy2NPtvSGvRBB+bZZ', 10, 198),
(11, '2023-09-24', 11, '2023-10-08', 'android', '1.0.0', '2023-10-01 13:42:13', 0, 'DTfy6RCmbdqPquKuD5x+', 11, 199),
(10, '2023-09-24', 10, '2023-11-06', 'android', '1.0.0', '2023-10-01 13:42:27', 0, '2UGSLntQR6Ja8JYd5LaY', 10, 200),
(3, '2023-09-24', 3, '2023-12-21', 'android', '1.0.0', '2023-10-01 13:44:07', 0, 'Mj80Ts30CXQ6T5jEM8Dk', 3, 201),
(10, '2023-09-24', 10, '2023-11-06', 'android', '1.0.0', '2023-10-01 14:46:14', 0, 'RGcVJhMXUWdWnjI+rDWk', 10, 202),
(10, '2023-09-24', 10, '2023-11-06', 'android', '1.0.0', '2023-10-01 14:49:01', 0, 'EjcMLeHSAYMtH5cCoCdC', 10, 203),
(3, '2023-09-25', 3, '2023-12-21', 'android', '1.0.0', '2023-10-02 14:22:03', 0, 'odAL6au1xnjUGfchghIX', 3, 204),
(10, '2023-09-25', 10, '2023-11-06', 'android', '1.0.0', '2023-10-02 14:45:58', 0, 'vvxZC491G5UjlOHfMug', 10, 205),
(3, '2023-09-25', 3, '2023-12-21', 'android', '1.0.0', '2023-10-02 14:50:00', 0, 'i7VcXsuzGMKkzm003vSO', 3, 206),
(3, '2023-09-28', 3, '2023-12-21', 'android', '1.0.0', '2023-10-07 08:22:35', 0, 'Ov7flLkckbInPuVOvP6P', 3, 207),
(1, '2023-09-28', 1, '2024-11-24', NULL, NULL, '2023-10-07 08:27:05', 0, 'jVHciLtDx3fwY+Hmehr1', 1, 208),
(3, '2023-09-30', 3, '2023-12-21', 'android', '1.0.0', '2023-10-07 08:27:14', 0, 'h0KmRUis0R5Xj259yNz', 3, 209),
(3, '2023-09-30', 3, '2023-12-21', 'android', '1.0.0', '2023-10-07 13:01:13', 0, 'eU5YX4n7nwCTgt0j0YSH', 3, 210),
(3, '2023-09-30', 3, '2023-12-21', 'android', '1.0.0', '2023-10-07 13:06:15', 0, '0xMc3F9NItBfzLstulJN', 3, 211),
(10, '2023-09-30', 10, '2023-11-06', 'android', '1.0.0', '2023-10-07 13:06:49', 0, '3CDkg0hypAHngmJq1NrL', 10, 212),
(3, '2023-09-30', 3, '2023-12-21', 'android', '1.0.0', '2023-10-07 13:41:42', 0, '10p1wqa6VDBMzuUgQAxX', 3, 213),
(10, '2023-09-30', 10, '2023-11-06', 'android', '1.0.0', '2023-10-08 07:06:16', 0, 'ZSh9kFQ1fAvjNAcKpMFq', 10, 214),
(3, '2023-09-30', 3, '2023-12-21', 'android', '1.0.0', '2023-10-07 23:03:15', 0, 'iACcBmBdDIIs6+NZyalp', 3, 215),
(3, '2023-10-01', 3, '2023-12-21', 'android', '1.0.0', '2023-10-08 07:08:55', 0, 'Hog7yk0ZoqWm+28mkTLY', 3, 216),
(3, '2023-10-02', 3, '2023-12-21', 'android', '1.0.0', '2023-10-09 10:02:50', 0, 'VXxwJjOua6EbDputP3DR', 3, 217),
(10, '2023-10-02', 10, '2023-11-06', 'android', '1.0.0', '2023-10-09 10:04:14', 0, 'U8Yua+Fo2RMociErFynM', 10, 218),
(17, '2023-10-02', 17, '2023-10-02', 'android', '1.0.0', '2023-10-09 10:06:19', 1, 'RboAh2akeDTHxUFqBAVX', 17, 219),
(3, '2023-10-02', 3, '2023-12-21', 'android', '1.0.0', '2023-10-09 10:06:38', 0, 'pjQ13pqXCXCNgfBt6VON', 3, 220),
(11, '2023-10-02', 11, '2023-10-08', 'android', '1.0.0', '2023-10-09 10:24:21', 0, 'QQCQ85jVnh7AF8fwPxUb', 11, 221),
(3, '2023-10-02', 3, '2023-12-21', 'android', '1.0.0', '2023-10-09 10:25:26', 0, 'HtmlcwcP5noTsZ6QX7U', 3, 222),
(3, '2023-10-08', 3, '2023-12-21', 'android', '1.0.0', '2023-10-15 20:50:52', 0, 'nqVYWy29T2jI0dgBRi2S', 3, 223),
(3, '2023-10-08', 3, '2023-12-21', 'android', '1.0.0', '2023-10-15 20:51:16', 0, 'kxZ7WP7w8sfgq0TvW5nr', 3, 224),
(11, '2023-10-08', 11, '2023-10-08', 'android', '1.0.0', '2023-10-15 20:55:09', 1, '+ANXnvLLqI4CZl13d7dn', 11, 225),
(3, '2023-10-08', 3, '2023-12-21', 'android', '1.0.0', '2023-10-15 21:00:05', 0, 'J16CyMkJ9VVbDmTDjrd6', 3, 226),
(15, '2023-10-08', 15, '2023-10-08', 'android', '1.0.0', '2023-10-15 21:00:44', 1, 'mrI1TJbRkihH1+Q0yh8S', 15, 227),
(16, '2023-10-08', 16, '2023-10-11', 'android', '1.0.0', '2023-10-18 09:36:18', 1, 'c8OvXHpirpbPxCd+Haus', 16, 228),
(3, '2023-10-09', 3, '2023-12-21', 'android', '1.0.0', '2023-10-16 10:19:51', 0, 's67hNNyyyVu6mSyIDmC0', 3, 229),
(10, '2023-10-09', 10, '2023-11-06', 'android', '1.0.0', '2023-10-16 11:01:31', 0, 'O84+Y0kTDvVsp58Enl', 10, 230),
(3, '2023-10-09', 3, '2023-12-21', 'android', '1.0.0', '2023-10-17 13:06:27', 0, 'TQCaspoLCWkV6E8NL28J', 3, 231),
(3, '2023-10-11', 3, '2023-12-21', 'android', '1.0.0', '2023-10-18 09:37:21', 0, 'qnrg1J1cmN44556k9XTk', 3, 232),
(10, '2023-10-11', 10, '2023-11-06', 'android', '1.0.0', '2023-10-21 10:27:13', 0, 'No6aC4OrIWKpr2EFM0ZX', 10, 233),
(3, '2023-10-14', 3, '2023-12-21', 'android', '1.0.0', '2023-10-21 10:32:03', 0, 'kcGNNpId+gIacv3r58+m', 3, 234),
(3, '2023-10-14', 3, '2023-12-21', 'android', '1.0.0', '2023-10-21 10:50:21', 0, 'QzmTgkmMCxy7UiCZuh3', 3, 235),
(3, '2023-10-14', 3, '2023-12-21', 'android', '1.0.0', '2023-10-21 11:05:07', 0, '6ljB4HLJRaNpLEj2QKZU', 3, 236),
(10, '2023-10-14', 10, '2023-11-06', 'android', '1.0.0', '2023-10-21 11:05:33', 0, 'MpYmEVKWfjXlwPgJsWsO', 10, 237),
(3, '2023-10-14', 3, '2023-12-21', 'android', '1.0.0', '2023-10-21 11:13:14', 0, 'VPQJz70yxffMdKPbue46', 3, 238),
(10, '2023-10-14', 10, '2023-11-06', 'android', '1.0.0', '2023-10-21 11:14:24', 0, 'Z7T7ZzjE7IAeAiiF8FvQ', 10, 239),
(3, '2023-10-14', 3, '2023-12-21', 'android', '1.0.0', '2023-10-21 11:15:32', 0, 'GnrkLZH0wQveE6JltlS+', 3, 240),
(10, '2023-10-14', 10, '2023-11-06', 'android', '1.0.0', '2023-10-21 11:29:56', 0, 'V7ZxY3TqWNG32fsuoEu9', 10, 241),
(3, '2023-10-14', 3, '2023-12-21', 'android', '1.0.0', '2023-10-21 13:22:10', 0, 'U2FTgUB8AoBPO6jPCejN', 3, 242),
(3, '2023-10-14', 3, '2023-12-21', 'android', '1.0.0', '2023-10-21 13:39:43', 0, 'l1ACddW1v7cjkEmag1i', 3, 243),
(21, '2023-10-14', 21, '2023-10-14', 'android', '1.0.0', '2023-10-21 13:39:36', 0, 'Y+PjUtLzManKfsFlDK1G', 21, 244),
(3, '2023-10-14', 3, '2023-12-21', 'android', '1.0.0', '2023-10-21 13:43:57', 0, 'BAmrWCeepgoEKgchTF4g', 3, 245),
(21, '2023-10-14', 21, '2023-10-14', 'android', '1.0.0', '2023-10-21 13:44:10', 0, 'aN3g0OV7vmv4qoj7Yzuf', 21, 246),
(21, '2023-10-14', 21, '2023-10-14', 'android', '1.0.0', '2023-10-21 13:46:08', 0, 'FKdIlcdRau2ewDK8jC9', 21, 247),
(3, '2023-10-14', 3, '2023-12-21', 'android', '1.0.0', '2023-10-21 13:51:06', 0, 'Z2xcfzICg8zdtzzQjst+', 3, 248),
(3, '2023-10-14', 3, '2023-12-21', 'android', '1.0.0', '2023-10-21 14:03:22', 0, '9DRUsyjCaFENfEQEoW0o', 3, 249),
(21, '2023-10-14', 21, '2023-10-14', 'android', '1.0.0', '2023-10-21 14:05:57', 0, '0zU7xcAdtCQXAY4d9vrv', 21, 250),
(3, '2023-10-14', 3, '2023-12-21', 'android', '1.0.0', '2023-10-21 14:05:23', 0, 'oKcufIc1n57LLvLpachg', 3, 251),
(5, '2023-10-14', 5, '2023-10-14', 'android', '1.0.0', '2023-10-21 14:05:51', 0, 'VQvTK24AoWTtTqY6EdBk', 5, 252),
(3, '2023-10-14', 3, '2023-12-21', 'android', '1.0.0', '2023-10-21 14:08:29', 0, 'yWcsAHOCvRvggBnGXP', 3, 253),
(21, '2023-10-14', 21, '2023-10-14', 'android', '1.0.0', '2023-10-21 14:14:39', 0, 'HbulOtwHaGbqzdGikd', 21, 254),
(5, '2023-10-14', 5, '2023-10-14', 'android', '1.0.0', '2023-10-21 14:29:06', 1, 'WerlMg0Vmsx+2AZqdYLh', 5, 255),
(3, '2023-10-14', 3, '2023-12-21', 'android', '1.0.0', '2023-10-21 14:29:05', 0, 'L9C07nS+lFloMSu9Qcrk', 3, 256),
(3, '2023-10-14', 3, '2023-12-21', 'android', '1.0.0', '2023-10-21 14:41:09', 0, 'ZOs+mOii2HaJgj9VzDJz', 3, 257),
(21, '2023-10-14', 21, '2023-10-14', 'android', '1.0.0', '2023-10-21 14:43:37', 1, 'Yt85ANkAhcpRgLZMHIF3', 21, 258),
(3, '2023-10-14', 3, '2023-12-21', 'android', '1.0.0', '2023-10-21 14:44:08', 0, 'bLdRBgTlLO0U+wHI9cuj', 3, 259),
(3, '2023-10-14', 3, '2023-12-21', 'android', '1.0.0', '2023-10-21 16:06:34', 0, 'AKHrr3znSW8Pb28zMcau', 3, 260),
(3, '2023-10-21', 3, '2023-12-21', 'android', '1.0.0', '2023-10-28 17:08:23', 0, 'UUWExumwx1Qi6oWXyiVr', 3, 261),
(3, '2023-10-21', 3, '2023-12-21', 'android', '1.0.0', '2023-10-28 19:53:22', 0, '9fO536pwo+0RMuopt6Fs', 3, 262),
(3, '2023-10-23', 3, '2023-12-21', 'android', '1.0.0', '2023-11-13 13:55:19', 0, 'OcCVw8vaEoMbEgrZXNZk', 3, 263),
(10, '2023-11-06', 10, '2023-11-06', 'android', '1.0.0', '2023-11-13 14:05:14', 1, '7MA7iBSzNl9lfrc+HoBS', 10, 264),
(3, '2023-11-06', 3, '2023-12-21', 'android', '1.0.0', '2023-11-13 14:40:17', 0, 'DgNmJDNuveaylekJo7J8', 3, 265),
(3, '2023-11-06', 3, '2023-12-21', 'android', '1.0.0', '2023-11-13 15:22:20', 0, '7Xr7x7DCbGowMXISJXb4', 3, 266),
(7, '2023-11-06', 7, '2023-11-07', 'android', '1.0.0', '2023-11-13 15:57:12', 0, 'dgcF3KQNOrJYIS9Wtqn0', 7, 267),
(3, '2023-11-06', 3, '2023-12-21', 'android', '1.0.0', '2023-11-13 16:01:33', 0, 'HdEIFaYsQAMqwErJoyTx', 3, 268),
(7, '2023-11-06', 7, '2023-11-07', 'android', '1.0.0', '2023-11-13 19:17:08', 0, 'qoN0YAsVChC6qSwi8ek0', 7, 269),
(7, '2023-11-07', 7, '2023-11-07', 'android', '1.0.0', '2023-11-14 14:11:11', 0, '+mD6jtj2cpRucObRLgLR', 7, 270),
(3, '2023-11-07', 3, '2023-12-21', 'android', '1.0.0', '2023-11-14 14:11:46', 0, 'QTlBXQi9t5Pi8Qt8fv9', 3, 271),
(7, '2023-11-07', 7, '2023-11-07', 'android', '1.0.0', '2023-11-14 14:12:04', 0, 'ScrovDDjZoHjHdYfhT+', 7, 272),
(7, '2023-11-07', 7, '2023-11-14', 'android', '1.0.0', '2023-11-21 14:06:32', 1, '2MwhMufqXBhDjoBHudYF', 7, 273),
(9, '2023-12-21', 9, '2023-12-21', 'android', '1.0.0', '2023-12-28 09:19:22', 1, 'OxJ2eEGiK7r8e+DTQ', 9, 274),
(3, '2023-12-21', 3, '2023-12-21', 'android', '1.0.0', '2023-12-28 09:19:59', 1, 'mOU4J1tWJbqVJEBG9QRC', 3, 275),
(1, '2024-11-23', 1, '2024-11-24', 'web', '12', '2024-11-30 16:50:50', 0, 'bwbjeRwA18pjoKG0taPy', 1, 276),
(1, '2024-11-23', 1, '2024-11-24', 'web', '12', '2024-11-30 16:56:41', 0, 'ox0dnywAa8qP9DP2ECL', 1, 277),
(1, '2024-11-23', 1, '2024-11-24', 'web', '12', '2024-11-30 17:09:20', 0, 'Ej0fwgr3whZLmQ+d9Coy', 1, 278),
(1, '2024-11-23', 1, '2024-11-24', 'web', '12', '2024-11-30 17:09:22', 0, 'V7FQzM5H+vrzwG29Caz5', 1, 279),
(1, '2024-11-23', 1, '2024-11-24', 'web', '12', '2024-11-30 17:09:27', 0, '4G2DEiecZQj7pLyBX410', 1, 280),
(1, '2024-11-23', 1, '2024-11-24', 'web', '12', '2024-11-30 17:13:20', 0, 'IMLaRm2u1nzlew3uQvhX', 1, 281),
(1, '2024-11-23', 1, '2024-11-24', 'web', '12', '2024-11-30 17:14:31', 0, 'tl5Yi6zBn10bfOtKJYLW', 1, 282),
(1, '2024-11-23', 1, '2024-11-24', 'web', '12', '2024-11-30 17:14:32', 0, 'GtNwVK4gwX2J9DLti4', 1, 283),
(1, '2024-11-23', 1, '2024-11-24', 'web', '12', '2024-11-30 17:29:28', 0, 'Cb+uqA2bKtJSiCtUyLrl', 1, 284),
(1, '2024-11-24', 1, '2024-11-24', 'web', '12', '2024-12-01 11:12:59', 1, 'P1jnAzF4gdxQyVrAQlUS', 1, 285);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `t_activity_result`
--
ALTER TABLE `t_activity_result`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_company`
--
ALTER TABLE `t_company`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_customer`
--
ALTER TABLE `t_customer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_group`
--
ALTER TABLE `t_group`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_group_assignment`
--
ALTER TABLE `t_group_assignment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_okr`
--
ALTER TABLE `t_okr`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_okr_assignment`
--
ALTER TABLE `t_okr_assignment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_okr_relation`
--
ALTER TABLE `t_okr_relation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_okr_result`
--
ALTER TABLE `t_okr_result`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_okr_suggest`
--
ALTER TABLE `t_okr_suggest`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_organization`
--
ALTER TABLE `t_organization`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_user`
--
ALTER TABLE `t_user`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `t_user_token`
--
ALTER TABLE `t_user_token`
  ADD PRIMARY KEY (`user_token`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `t_activity_result`
--
ALTER TABLE `t_activity_result`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `t_company`
--
ALTER TABLE `t_company`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `t_customer`
--
ALTER TABLE `t_customer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `t_group`
--
ALTER TABLE `t_group`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `t_group_assignment`
--
ALTER TABLE `t_group_assignment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `t_okr`
--
ALTER TABLE `t_okr`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `t_okr_assignment`
--
ALTER TABLE `t_okr_assignment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `t_okr_relation`
--
ALTER TABLE `t_okr_relation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `t_okr_result`
--
ALTER TABLE `t_okr_result`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `t_okr_suggest`
--
ALTER TABLE `t_okr_suggest`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `t_organization`
--
ALTER TABLE `t_organization`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `t_user`
--
ALTER TABLE `t_user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `t_user_token`
--
ALTER TABLE `t_user_token`
  MODIFY `user_token` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=286;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
