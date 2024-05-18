-- phpMyAdmin SQL Dump
-- version 5.1.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 18, 2024 at 12:35 PM
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
(9, 'Hannelore', 'VB', 'h@vb.com', '$2y$10$h49W2zsUek5gQylWyGIRfO0Oen32YEEh4E/1dCWU4WmBfIIYccGIi', 'manager', 2, NULL);

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
(3, 'works', 'Zambia');

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
  `assigned_manager_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hub_tasks`
--

INSERT INTO `hub_tasks` (`id`, `task_name`, `task_description`, `task_type`, `task_status`, `task_start_date`, `task_end_date`, `assigned_to`, `hub_location_id`, `assigned_manager_id`) VALUES
(1, 'Office Duty', 'Be in the office', NULL, 'Open', NULL, NULL, NULL, NULL, NULL),
(2, 'cleaning', 'sweep, sweep, sweep', NULL, 'Open', NULL, NULL, NULL, NULL, NULL);

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
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `hub_location`
--
ALTER TABLE `hub_location`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `hub_tasks`
--
ALTER TABLE `hub_tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `employees`
--
ALTER TABLE `employees`
  ADD CONSTRAINT `fk_location_id` FOREIGN KEY (`location_id`) REFERENCES `hub_location` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
