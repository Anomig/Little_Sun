-- phpMyAdmin SQL Dump
-- version 5.1.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 12, 2024 at 08:51 AM
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
-- Database: `littlesun`
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
  `task_start_date` datetime NOT NULL,
  `task_end_date` datetime NOT NULL,
  `assigned_to` int(11) DEFAULT NULL,
  `hub_location_id` int(11) DEFAULT NULL,
  `assigned_manager_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hub_tasks`
--

INSERT INTO `hub_tasks` (`id`, `task_name`, `task_description`, `task_type`, `task_status`, `task_start_date`, `task_end_date`, `assigned_to`, `hub_location_id`, `assigned_manager_id`) VALUES
(1, 'cleaning', 'cleaning', 'cleaning', 'Open', '2024-05-05 21:38:11', '2024-05-05 21:38:11', NULL, NULL, NULL),
(7, 'hygiene', 'hygiene', NULL, 'Open', '2024-05-05 23:32:28', '2024-05-05 23:32:28', NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `hub_tasks`
--
ALTER TABLE `hub_tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_hub_task_location` (`hub_location_id`),
  ADD KEY `fk_hub_task_manager` (`assigned_manager_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `hub_tasks`
--
ALTER TABLE `hub_tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `hub_tasks`
--
ALTER TABLE `hub_tasks`
  ADD CONSTRAINT `fk_hub_task_location` FOREIGN KEY (`hub_location_id`) REFERENCES `hub_location` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_hub_task_manager` FOREIGN KEY (`assigned_manager_id`) REFERENCES `hub_managers` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
