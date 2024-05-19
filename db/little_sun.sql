-- phpMyAdmin SQL Dump
-- version 5.1.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 19, 2024 at 06:11 PM
-- Server version: 5.7.24
-- PHP Version: 8.0.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `little_sun`
--

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` int(11) NOT NULL,
  `firstname` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastname` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `function` enum('admin','manager','user') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `location_id` int(11) DEFAULT NULL,
  `task_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `firstname`, `lastname`, `email`, `password`, `function`, `location_id`, `task_id`) VALUES
(2, 'admin', 'admin', '@dmin.com', '$2y$10$Uifh.906br0ajEF6YcXk9.HIxhETnCCCKf/LFWHSlwIFS79Z9Pzwy', 'admin', NULL, NULL),
(3, 'man', 'eger', '@manager.com', '$2y$10$BfL3D9HeNhASTKLeo49xtuZLhALtI3uxWGqZp7ww5W1Nq5ff/vBlS', 'manager', NULL, NULL),
(5, 'user', 'user', '@user.com', '$2y$10$x8zxsxAYOUYksl4MeVnZh.4toHxcnxNyImVu.1HRlDQaf2DMbz4wO', 'user', NULL, NULL),
(6, 'stu', 'dent', 'stu@dent.com', '$2y$10$uedRWdcFLF2o1lCfWV0glOGARaruDkwUSeLnkN6lcnXf3LJPiDiny', 'manager', 1, NULL),
(7, 'Naomi', 'Goyvaerts', 'na@goy.com', '$2y$10$NVYXwDRYDdSiQauACxovTu7RPLK3J8.Gl5pclrCoGh./sVPwrbHHi', 'manager', 1, NULL),
(8, 'me', 'ma', 'me@ma.com', '$2y$10$Qw6hw4Ys4AG5ZcpVXxIpKuVxNMM2AkCcRY0ibI1/i8yclfvxFZQve', 'manager', 1, NULL),
(9, 'Hannelore', 'VB', 'h@vb.com', '$2y$10$h49W2zsUek5gQylWyGIRfO0Oen32YEEh4E/1dCWU4WmBfIIYccGIi', 'manager', 2, NULL),
(10, 'amy', 'amy', '@my.com', '$2y$10$bxj3jTav3qQQXx1KdOweVugg7rv7nnPd.CtcW4My7q/Syd5oNCSkS', 'user', 2, NULL),
(11, 'na', 'omi', '@omi.com', '$2y$10$Ni9UjgXpLwUeIAfLlVF4SOH7AlHfjAzl83S6wg/U4qUtyBeBov.mG', 'user', 3, NULL),
(12, 'Hannelore', 'Van Buynderen', 'hannelorevb@hotmail.be', '$2y$10$XWd96hckaagVDoc1w4D9YelcZJbQQIjcpOObYWOk6Ocfdqov4TgPq', 'manager', 3, NULL),
(13, 'little', 'sun', 'little@sun.com', '$2y$10$pNZsgMEVs85g55ysQbEQtusmcPE2iLOVhtgfC13j7ljVUGDfcz946', 'manager', 1, NULL),
(15, 'bla', 'bla', 'bla@blah.com', '$2y$10$Tm82o03khd7IbmulD8bLo..gNWFOOCOABDFVuUGIT5uYXHY.1OulS', 'manager', 1, NULL),
(16, 'ellio', 'doggo', 'ellio@doggo.com', '$2y$10$gl1qQipFJxHn8kdR0G/iyutbKnjlLALhnFzJ.OOuYoIQX0hTKt7XS', 'user', 3, NULL),
(17, 'test', 'test', 'test@test.com', '$2y$10$hZzdXc2vfEdro5LZCcRMS.LPoQd8LBmZYMWy.xm0MIXhMWwxYevEu', 'user', NULL, 1),
(18, 'cruella', 'deville', 'cruella@deville', '$2y$10$nZ2XuwxWyD230HB6QC.3hOd2t4pw.Vb0QebWw7o9s9fM9kNV.Bscu', 'user', NULL, 2);

-- --------------------------------------------------------

--
-- Table structure for table `hub_location`
--

CREATE TABLE `hub_location` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `hub_location`
--

INSERT INTO `hub_location` (`id`, `name`, `country`) VALUES
(1, 'Little sun', 'Zambia'),
(2, 'School', 'Zambia'),
(3, 'work', 'Zambia');

-- --------------------------------------------------------

--
-- Table structure for table `hub_tasks`
--

CREATE TABLE `hub_tasks` (
  `id` int(11) NOT NULL,
  `task_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `task_description` text COLLATE utf8mb4_unicode_ci,
  `task_type` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `task_status` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Open',
  `task_start_date` datetime DEFAULT NULL,
  `task_end_date` datetime DEFAULT NULL,
  `assigned_to` int(11) DEFAULT NULL,
  `hub_location_id` int(11) DEFAULT NULL,
  `assigned_manager_id` int(11) DEFAULT NULL,
  `color` varchar(7) COLLATE utf8mb4_unicode_ci DEFAULT '#3788D8'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hub_tasks`
--

INSERT INTO `hub_tasks` (`id`, `task_name`, `task_description`, `task_type`, `task_status`, `task_start_date`, `task_end_date`, `assigned_to`, `hub_location_id`, `assigned_manager_id`, `color`) VALUES
(1, 'Office Duty', 'Be in the office', NULL, 'Open', NULL, NULL, 18, NULL, NULL, '#3788D8'),
(2, 'cleaning', 'sweep, sweep, sweep', NULL, 'Open', NULL, NULL, NULL, NULL, NULL, '#3788D8'),
(8, 'zjeltgbk', 'ueohb', NULL, 'Open', NULL, NULL, NULL, NULL, NULL, '#3788D8'),
(9, 'deadline', 'at 23.59u', NULL, 'Open', '2024-05-19 09:40:00', '2024-05-19 23:59:00', NULL, NULL, NULL, '#3788D8'),
(12, 'typing', 'on the computer', NULL, 'Open', '2024-05-19 15:51:00', '2024-05-19 16:51:00', 12, NULL, NULL, '#3788D8'),
(13, 'new', 'task', NULL, 'Open', '2024-05-19 16:01:00', '2024-05-19 17:01:00', 3, NULL, NULL, '#3788D8'),
(14, 'newest ', 'task', NULL, 'Open', '2024-05-21 16:03:00', '2024-05-21 17:03:00', 16, NULL, NULL, '#3788D8'),
(15, 'newer', 'task', NULL, 'Open', '2024-05-23 16:04:00', '2024-05-23 18:04:00', 17, NULL, NULL, '#3788D8'),
(21, 'fvdsb', 'bvdbg', NULL, 'Open', '2024-05-24 19:44:00', '2024-05-24 22:44:00', 2, 1, NULL, '#3788D8'),
(22, 'celebrate', 'birthday', NULL, 'Open', '2024-05-22 16:54:00', '2024-05-22 16:54:00', 2, 1, NULL, '#3788D8'),
(23, 'lfucyvzqk', 'bzvrsbdv', NULL, 'Open', '2024-05-09 17:09:00', '2024-05-10 17:09:00', 2, 1, NULL, '#3788D8'),
(24, 'ynthbgfrqds', 'u,yjnfdssq', NULL, 'Open', '2024-05-01 18:27:00', '2024-05-01 19:27:00', 2, 1, NULL, '#3788D8'),
(25, 'brtvercseqx', 'nbyrsvfqw', NULL, 'Open', '2024-05-02 18:32:00', '2024-05-02 19:32:00', 2, 2, NULL, '#3788D8'),
(26, 'Development 4', 'coding', NULL, 'Open', '2024-05-07 19:34:00', '2024-05-07 22:34:00', 2, 1, NULL, '#3788D8'),
(27, 'tbrgvefqcsd', ';iku,tyjrngdfs qs', NULL, 'Open', '2024-05-03 21:45:00', '2024-05-03 22:45:00', 3, 2, NULL, '#3788D8'),
(28, 'yrgteqzcexQW', '6UNTEYBRVEQ', NULL, 'Open', '2024-05-19 23:00:00', '2024-05-19 23:10:00', 8, 2, NULL, '#3788D8'),
(29, 'tybrvefczdxsqw', 'U?YRNTHEBGRVDQFS', NULL, 'Open', '2024-05-19 18:59:00', '2024-05-19 19:59:00', 3, 2, NULL, '#3788D8'),
(30, 'ièyjugtbrefqcsD', 'I.YU?TNYJRTHBGFDS', NULL, 'Open', '2024-05-19 18:59:00', '2024-05-19 20:59:00', 5, 3, NULL, '#3788D8'),
(31, 'ynhtbgfvd', 'utyntdbvs', NULL, 'Open', '2024-05-19 23:00:00', '2024-05-19 23:04:00', 15, 3, NULL, '#3788D8'),
(32, 'uk,ynjrthbgfrdqs', ';kjgfdiuyjnhtbgfvd', NULL, 'Open', '2024-05-08 12:30:00', '2024-05-08 13:00:00', 18, 2, NULL, '#3788D8');

-- --------------------------------------------------------

--
-- Table structure for table `time_off`
--

CREATE TABLE `time_off` (
  `id` int(11) NOT NULL,
  `start_date` varchar(300) NOT NULL,
  `end_date` varchar(300) NOT NULL,
  `reason` varchar(300) NOT NULL,
  `comments` varchar(300) NOT NULL,
  `status` varchar(300) NOT NULL,
  `is_sick` tinyint(1) NOT NULL DEFAULT '0',
  `employee_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `time_off`
--

INSERT INTO `time_off` (`id`, `start_date`, `end_date`, `reason`, `comments`, `status`, `is_sick`, `employee_id`) VALUES
(1, '2024-05-18', '2024-05-25', 'vacation', 'holiday', 'requested', 0, 5),
(2, '2024-05-19', '2024-05-25', 'birthday', 'happy me', 'requested', 0, 5),
(5, '2024-05-19', '2024-05-21', 'sickness', '', 'requested', 1, 5),
(6, '2024-05-20', '2024-05-21', 'vacation', 'vacay timee!', 'requested', 0, 5),
(7, '2024-05-19', '2024-05-20', 'vacation', 'vacay timee', 'requested', 0, 5);

-- --------------------------------------------------------

--
-- Table structure for table `work_times`
--

CREATE TABLE `work_times` (
  `id` int(11) NOT NULL,
  `clock_in` datetime NOT NULL,
  `clock_out` datetime DEFAULT NULL,
  `overtime` decimal(5,2) DEFAULT '0.00',
  `total_hours` time DEFAULT '00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `work_times`
--

INSERT INTO `work_times` (`id`, `clock_in`, `clock_out`, `overtime`, `total_hours`) VALUES
(30, '2024-05-18 15:49:13', '2024-05-18 15:49:18', '0.00', '00:00:05'),
(31, '2024-05-18 15:52:29', '2024-05-18 15:52:31', '0.00', '00:00:02'),
(32, '2024-05-18 17:32:39', '2024-05-18 17:32:42', '0.00', '00:00:03'),
(33, '2024-05-18 17:32:57', '2024-05-18 17:32:58', '0.00', '00:00:01'),
(34, '2024-05-18 17:36:03', '2024-05-18 17:36:08', '0.00', '00:00:05'),
(35, '2024-05-18 17:36:19', '2024-05-18 17:36:36', '0.00', '00:00:17'),
(36, '2024-05-18 19:24:51', '2024-05-18 19:25:01', '0.00', '00:00:10');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_location_id` (`location_id`);

--
-- Indexes for table `hub_location`
--
ALTER TABLE `hub_location`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hub_tasks`
--
ALTER TABLE `hub_tasks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `time_off`
--
ALTER TABLE `time_off`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_employee_id` (`employee_id`);

--
-- Indexes for table `work_times`
--
ALTER TABLE `work_times`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `hub_location`
--
ALTER TABLE `hub_location`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `hub_tasks`
--
ALTER TABLE `hub_tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `time_off`
--
ALTER TABLE `time_off`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `work_times`
--
ALTER TABLE `work_times`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `employees`
--
ALTER TABLE `employees`
  ADD CONSTRAINT `fk_location_id` FOREIGN KEY (`location_id`) REFERENCES `hub_location` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `time_off`
--
ALTER TABLE `time_off`
  ADD CONSTRAINT `fk_employee_id` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
