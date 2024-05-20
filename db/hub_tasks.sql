-- phpMyAdmin SQL Dump
-- version 5.1.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 19, 2024 at 08:12 PM
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
(1, 'Office Duty', 'Be in the office', NULL, 'Open', NULL, NULL, 5, NULL, NULL, '#3788D8'),
(2, 'cleaning', 'sweep, sweep, sweep', NULL, 'Open', NULL, NULL, NULL, NULL, NULL, '#3788D8'),
(9, 'deadline', 'at 23.59u', NULL, 'Open', '2024-05-19 09:40:00', '2024-05-19 23:59:00', NULL, NULL, NULL, '#3788D8'),
(12, 'typing', 'on the computer', NULL, 'Open', '2024-05-19 15:51:00', '2024-05-19 16:51:00', 12, NULL, NULL, '#3788D8'),
(26, 'Development 4', 'coding', NULL, 'Open', '2024-05-07 19:34:00', '2024-05-07 22:34:00', 2, 1, NULL, '#3788D8'),
(34, 'test', 'test', NULL, 'Open', '2024-05-15 20:22:00', '2024-05-16 20:22:00', 13, 1, NULL, '#3788D8'),
(35, 'little sun ', 'deadline', NULL, 'Open', '2024-05-22 20:23:00', '2024-05-22 22:23:00', 5, 1, NULL, '#3788D8'),
(36, 'Development 4', 'deadline F', NULL, 'Open', '2024-05-19 20:25:00', '2024-05-19 23:25:00', 5, 1, NULL, '#3788D8');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `hub_tasks`
--
ALTER TABLE `hub_tasks`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `hub_tasks`
--
ALTER TABLE `hub_tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
