-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 24, 2023 at 09:21 PM
-- Server version: 10.3.39-MariaDB-cll-lve
-- PHP Version: 8.1.16

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
  `presence_id` int(11) DEFAULT NULL,
  `okr_result_id` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_date` date DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `modified_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `t_customer`
--

CREATE TABLE `t_customer` (
  `id` int(11) NOT NULL,
  `company_id` int(11) DEFAULT NULL,
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
  `modified_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `modified_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `t_group`
--

INSERT INTO `t_group` (`id`, `company_id`, `name`, `type`, `description`, `created_by`, `created_date`, `modified_by`, `modified_date`) VALUES
(1, 1, 'hrd', 'group', 'gg', 1, '2023-07-24', 1, '2023-07-24'),
(2, 1, 'tim', 'teams', 'tjm gg', 1, '2023-07-24', 1, '2023-07-24');

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

-- --------------------------------------------------------

--
-- Table structure for table `t_okr`
--

CREATE TABLE `t_okr` (
  `id` int(11) NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_date` date DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `modified_date` date DEFAULT NULL,
  `alert_achievement` int(11) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `objective_id` int(11) DEFAULT NULL,
  `objective_type` varchar(255) DEFAULT NULL,
  `sheet_url` varchar(255) DEFAULT NULL,
  `skala_point` int(11) DEFAULT NULL,
  `survey_url` varchar(255) DEFAULT NULL,
  `target_point` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `t_presence`
--

CREATE TABLE `t_presence` (
  `id` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_date` date DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `modified_date` date DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `approval` varchar(255) DEFAULT NULL,
  `clock_in` datetime DEFAULT NULL,
  `clock_out` datetime DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `evidence` varchar(255) DEFAULT NULL,
  `group_id` int(11) DEFAULT NULL,
  `location_clock_in` varchar(255) DEFAULT NULL,
  `location_clock_out` varchar(255) DEFAULT NULL,
  `note` varchar(255) DEFAULT NULL,
  `okr_result_id` int(11) DEFAULT NULL,
  `point` int(11) DEFAULT NULL,
  `presence_type` varchar(255) DEFAULT NULL,
  `progress` int(11) DEFAULT NULL,
  `status` varchar(255) DEFAULT 'pending',
  `title` varchar(255) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `value` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(1, 1, '2020-10-09', 1, '2020-10-09', 'www.google.com', 1, 'admin@okr.id', 'admin', '123', 1, 'Admin', '2023-07-24 21:13:43', 'Admin System', 'Admin1', '21232f297a57a5a743894a0e4a801fc3', '0812312323', 'img_profile_1_20230724210951.jpg', 2, 'active', '0'),
(2, 1, '2023-07-24', 1, '2023-07-24', NULL, 1, 'user1@okr.id', 'Field Employee', NULL, 0, NULL, NULL, 'User 1', 'A000001', 'ee11cbb19052e40b07aac0ca060c23ee', '085466565635655', 'default.png', 1, NULL, NULL);

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
(1, '2023-07-24', 1, '2023-07-24', 'android', '1.0.0', '2023-07-31 21:03:47', 0, 'hFo2viPoQTtDwO5UnFcR', 1, 1),
(1, '2023-07-24', 1, '2023-07-24', 'android', '1.0.0', '2023-07-31 21:04:25', 0, 'sQQydREkm1aLbp+EIaG', 1, 2),
(1, '2023-07-24', 1, '2023-07-24', 'android', '1.0.0', '2023-07-31 21:09:51', 0, 'jhC6mXk1Wjt1TBRqxCtK', 1, 3),
(1, '2023-07-24', 1, '2023-07-24', 'android', '1.0.0', '2023-07-31 21:10:00', 0, 'lOjFRPkuVazaztCKZLXx', 1, 4),
(1, '2023-07-24', 1, '2023-07-24', 'android', '1.0.0', '2023-07-31 21:12:45', 0, 'iWA8PsU0ZAt5OzIT6CYM', 1, 5),
(1, '2023-07-24', 1, '2023-07-24', 'android', '1.0.0', '2023-07-31 21:16:00', 1, 'UtJhqyLNPPObTC5FVOIc', 1, 6);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `t_activity_result`
--
ALTER TABLE `t_activity_result`
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
-- AUTO_INCREMENT for table `t_customer`
--
ALTER TABLE `t_customer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `t_group`
--
ALTER TABLE `t_group`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `t_group_assignment`
--
ALTER TABLE `t_group_assignment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `t_okr`
--
ALTER TABLE `t_okr`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `t_user`
--
ALTER TABLE `t_user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `t_user_token`
--
ALTER TABLE `t_user_token`
  MODIFY `user_token` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
