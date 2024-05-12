-- phpMyAdmin SQL Dump
-- version 5.1.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 12, 2024 at 02:24 PM
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
-- Table structure for table `hub_location`
--

CREATE TABLE `hub_location` (
  `id` int(11) NOT NULL,
  `name` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hub_location`
--

INSERT INTO `hub_location` (`id`, `name`, `country`) VALUES
(28, 'Little sun', 'Zambia'),
(33, 'XD2', 'Zambia');

-- --------------------------------------------------------

--
-- Table structure for table `hub_managers`
--

CREATE TABLE `hub_managers` (
  `id` int(11) NOT NULL,
  `firstname` varchar(300) NOT NULL,
  `lastname` varchar(300) NOT NULL,
  `email` varchar(300) NOT NULL,
  `password` varchar(300) NOT NULL,
  `profile_picture` varchar(300) NOT NULL,
  `hub_location` varchar(300) NOT NULL,
  `hub_location_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `hub_managers`
--

INSERT INTO `hub_managers` (`id`, `firstname`, `lastname`, `email`, `password`, `profile_picture`, `hub_location`, `hub_location_id`) VALUES
(8, 'Elliot', 'VB', '@dmin.be', '$2y$10$umaqTC0.GnPma8cgSLtRz.ZndoC2kMs2Zru8L5HCrgPTaREq6S6xu', 'Afbeelding van WhatsApp op 2024-03-24 om 22.42.10_c7257563.jpg', 'Boechout', NULL),
(9, 'Nieuwe', 'Manager', 'manager@example.com', 'wachtwoord', 'afbeelding.jpg', 'Hub locatie', NULL),
(11, 'elliot', 'vb', 'h@llo.com', '$2y$10$Gd7F1OGrmlcW73Wnhekd4uZg1GRS9qx2HO6UZvqRa9kBEM17rRjJm', 'vuhvoibm', 'eulenlv', NULL),
(12, 'elliot', 'de hond', 'elliot@dehond.be', '$2y$10$HxCd3YRJyDUAhcJ3xUHvsedVG4m9UyhXuTjU/nfuXRVqKPu8EA4eK', 'at the beach', 'in de zetel', NULL),
(13, 'P', 'T', 'pt@.be', '$2y$10$.y40FFXIuRAo0Uha35lLke1oGqNM3h7kU6KvU6lix54p4JcuNnxJC', 'IMG_4062.jpg', 'leuven', NULL),
(16, 'Amy', 'XD', 'amy@XD.be', '$2y$10$jpul..4d5i2cyI.Wei9qhOCFPDdG6zKkXkeWTAfK4U4iKIIX8epkq', 'achtergrond.png', 'Lier', NULL),
(17, 'Elliot', 'VB', 'Elliot@vb.be', '$2y$10$RBElhBUhhjF9xyjMHh.SiuFzBMlM6Q58Q3Ve7k1TI.2kLbrKFh2pq', 'achtergrond.png', 'Boechout', NULL),
(18, 'Pommelien', 'Thijs', 'Pommelien@thijs.be', '1234', 'https://image.demorgen.be/240472015/width/2480/pommelien-thijs', 'Leuven', NULL),
(19, 'Hannelore', 'Van Buynderen', 'hannelorevb04', '$2y$10$ttNVCxVo/Pb1Ie2wKABb0eW95wLKY43S90JnI.59LxfkG7M3sOCLi', 'achtergrond.png', 'Mechelen', NULL),
(20, 'Hannelore', 'Van Buynderen', 'hannelorevb@hotmail.be', '$2y$10$YeF7v44Wrv1yYWMKMRZ.xevEp0t2yU0foe.twWoIm4bM0qhwqeS4i', 'Afbeelding van WhatsApp op 2024-03-24 om 22.44.59_ad3dfd8f.jpg', 'Zambia', NULL),
(21, 'hub', 'manager', 'hub@manager.be', '$2y$10$kQxYVk4SJIa2LMYaXAz77.tQBSNkWxd6sbuVjAORjHWxOYZhh8Dz2', 'Afbeelding van WhatsApp op 2024-03-24 om 23.03.02_f29099e3.jpg', '10', NULL),
(25, 'Pommelien', 'Thijs', 'info@pommelien.be', '$2y$10$9rp6H2axbBUHky6auBdnoOEbVQn9VgX0Fj2EZNimh50ihQEWFQAzm', 'IMG_4073.jpg', '28', NULL),
(57, 'Mer', 'Grey', '@Mer@grey.be', '$2y$10$H2hQsOcNkWuo4H3yl3gpVuWn1tEJbxVdZb0SrE7MRInlecxc9pLUC', '6cebf17c-1a14-4ad9-b4d3-b04b9ca7cd97-screen-shot-2020-02-21-at-52105-pm.jpeg', '28', NULL),
(58, 'Jo', 'Wilson', 'jo@wilson.be', '$2y$10$X4SOSoexmn94W38v/W1rieykyRVunpGPj/FQ0XdRkjiur9ID24wDG', 'Afbeelding van WhatsApp op 2023-08-26 om 15.44.31_1.jpg', '28', NULL),
(59, 'Alex', 'Karev', 'Alex@Karev.be', '$2y$10$gQAimr2ruwMDreI/LqvAV.hvddS1aAO0XOxhWVd91q.4tcnmYl2C.', 'Afbeelding van WhatsApp op 2023-08-26 om 15.44.31_1.jpg', '28', NULL),
(60, 'Amelia ', 'Sheperd', 'Amelia@sheperd.be', '$2y$10$eTnxClvAxlOALqpfQi0ROe0C78Vi.EXRTjrzo/CieR1Cv03ZdePw2', '6cebf17c-1a14-4ad9-b4d3-b04b9ca7cd97-screen-shot-2020-02-21-at-52105-pm.jpeg', '28', NULL),
(61, 'Amelia ', 'Sheperd', 'Amelia@sheperd.be', '$2y$10$ubuvRyaTlvWuqC7NFWzZwua4A3W3VFTlTlzhEONZ75.NXWRah5/UW', '6cebf17c-1a14-4ad9-b4d3-b04b9ca7cd97-screen-shot-2020-02-21-at-52105-pm.jpeg', '28', NULL),
(62, 'ellio', 'Derupo', '@dmin.be', '$2y$10$JdyU5GQ1b4OF6D8MnY7KROYvgDyBojvGZeewxwKLSht1GcHtFV0GS', 'Afbeelding van WhatsApp op 2024-03-24 om 22.55.29_03020481.jpg', '28', NULL),
(63, 'bloem', 'bak', 'bloem@bak.be', '$2y$10$mJf/mMAhG..Otu2Nv2itGu77Z78wQZ5ktxml0IVdfQty9zW5d5m9.', '4feeed27-6081-4d03-a1a6-299e2605b62d-getty-480064040.jpg', '28', NULL),
(64, 'maura', 'isles', 'maura@isles.be', '$2y$10$Qrh4sCyjiCSRimkuOEk.xufVzHyOvrynQlAT4eYhl6HIFyy15t9TG', 'Afbeelding van WhatsApp op 2024-03-24 om 23.07.23_ef82121f.jpg', '28', NULL);

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
(7, 'hygiene', 'hygiene', NULL, 'Open', '2024-05-05 23:32:28', '2024-05-05 23:32:28', NULL, NULL, NULL),
(17, 'bloembakken ', NULL, NULL, 'Open', '2024-05-09 00:00:00', '2024-05-12 00:00:00', NULL, NULL, NULL),
(18, 'bloembakken ', NULL, NULL, 'Open', '2024-05-09 00:00:00', '2024-05-12 00:00:00', NULL, NULL, NULL),
(19, 'bloembakken ', NULL, NULL, 'Open', '2024-05-14 00:00:00', '2024-05-15 00:00:00', NULL, NULL, NULL),
(20, 'Joost Klein', NULL, NULL, 'Open', '2024-05-07 00:00:00', '2024-05-08 00:00:00', NULL, NULL, NULL),
(21, 'AH', NULL, NULL, 'Open', '2024-05-15 00:00:00', '2024-05-16 00:00:00', NULL, NULL, NULL),
(22, 'AH', NULL, NULL, 'Open', '2024-05-12 00:00:00', '2024-05-13 00:00:00', NULL, NULL, NULL),
(23, 'cnmdfovj', NULL, NULL, 'Open', '2024-05-08 00:00:00', '2024-05-09 00:00:00', NULL, NULL, NULL),
(24, 'uhvuer', NULL, NULL, 'Open', '2024-05-15 00:00:00', '2024-05-16 00:00:00', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `hub_users`
--

CREATE TABLE `hub_users` (
  `id` int(11) NOT NULL,
  `firstname` varchar(300) NOT NULL,
  `lastname` varchar(300) NOT NULL,
  `email` varchar(300) NOT NULL,
  `password` varchar(300) NOT NULL,
  `profile_picture` varchar(300) NOT NULL,
  `hub_location_id` int(11) DEFAULT NULL,
  `hub_tasks_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `hub_users`
--

INSERT INTO `hub_users` (`id`, `firstname`, `lastname`, `email`, `password`, `profile_picture`, `hub_location_id`, `hub_tasks_id`) VALUES
(1, 'Amy', 'Bruyninckx', 'Amy@hotmail.com', '$2y$10$YHZjzfR32YI0leJDCcZRDe19ZYAz45yYvmfHTdrKA9Nc5jc.VKm0G', 'hub_users (1).sql', NULL, NULL),
(2, 'Senne', 'Winkelmans', 'sen@win.be', '$2y$10$GTJoxwrfZaiAi6tZp66/jOvJvft43mqFpVPYSwhrFOPfRzvMqIusa', '', NULL, NULL),
(19, 'user', 'user', '@user.be', '$2y$10$xrRI.5sc7jo3f/Dft.v/3eHo4JlhCh70blFc19N9Uknu7FFmiq8cC', '', NULL, NULL),
(20, 'admin', 'admin', '@dmin.be', '$2y$10$XgzgAZJbaupZXxLvz61bFOiJg6DsXpUEpsdj5.mooFmi7JmA4F84K', '', NULL, NULL),
(25, 'Hannelore', 'Van Buynderen', 'hannelorevb@hotmail.be', '$2y$10$hUw.h/ReOgoIHsrw1axhK.zzoCSoGTS1A8H7fVJlN9JLtfuZsZaLO', 'Afbeelding van WhatsApp op 2024-03-24 om 22.42.10_c7257563.jpg', NULL, NULL),
(31, 'elliot', 'vb', 'elliot@vb.be', '$2y$10$O1UrlsulI8/El86IFdD8d.NLx66EzQI1kRrQN37NphhJ1qH1Xo3Hy', 'Afbeelding van WhatsApp op 2024-03-24 om 22.42.10_c7257563.jpg', NULL, NULL),
(35, 'Temperance', 'Brennan', '@dmin.be', '$2y$10$AQf.XAWM5NHXOtigc8iYbeuodE65NnT.FnmTMD6bBGnanq/N.rHiq', 'Afbeelding van WhatsApp op 2024-03-24 om 23.06.04_dfde317b.jpg', NULL, NULL),
(36, '', '', '', '$2y$10$oOC8A4KMfz00rAYq0uL5AeXHR0WMx52e1PfLdSQKTCdh9ah3US5G.', '', NULL, NULL);

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
  `status` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `user_tasks`
--

CREATE TABLE `user_tasks` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `task_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_tasks`
--

INSERT INTO `user_tasks` (`id`, `user_id`, `task_id`) VALUES
(1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `work_times`
--

CREATE TABLE `work_times` (
  `id` int(11) NOT NULL,
  `clock_in` datetime NOT NULL,
  `clock_out` datetime DEFAULT NULL,
  `overtime` decimal(5,2) DEFAULT '0.00',
  `total_hours` decimal(5,2) DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `hub_location`
--
ALTER TABLE `hub_location`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hub_managers`
--
ALTER TABLE `hub_managers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_hub_manager_location` (`hub_location_id`);

--
-- Indexes for table `hub_tasks`
--
ALTER TABLE `hub_tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_hub_task_location` (`hub_location_id`),
  ADD KEY `fk_hub_task_manager` (`assigned_manager_id`);

--
-- Indexes for table `hub_users`
--
ALTER TABLE `hub_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_hub_user_location` (`hub_location_id`),
  ADD KEY `fk_hub_user_tasks` (`hub_tasks_id`);

--
-- Indexes for table `time_off`
--
ALTER TABLE `time_off`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_tasks`
--
ALTER TABLE `user_tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `task_id` (`task_id`);

--
-- Indexes for table `work_times`
--
ALTER TABLE `work_times`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `hub_location`
--
ALTER TABLE `hub_location`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `hub_managers`
--
ALTER TABLE `hub_managers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `hub_tasks`
--
ALTER TABLE `hub_tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `hub_users`
--
ALTER TABLE `hub_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `time_off`
--
ALTER TABLE `time_off`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_tasks`
--
ALTER TABLE `user_tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `work_times`
--
ALTER TABLE `work_times`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `hub_managers`
--
ALTER TABLE `hub_managers`
  ADD CONSTRAINT `fk_hub_manager_location` FOREIGN KEY (`hub_location_id`) REFERENCES `hub_location` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `hub_tasks`
--
ALTER TABLE `hub_tasks`
  ADD CONSTRAINT `fk_hub_task_location` FOREIGN KEY (`hub_location_id`) REFERENCES `hub_location` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_hub_task_manager` FOREIGN KEY (`assigned_manager_id`) REFERENCES `hub_managers` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `hub_users`
--
ALTER TABLE `hub_users`
  ADD CONSTRAINT `fk_hub_user_location` FOREIGN KEY (`hub_location_id`) REFERENCES `hub_location` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_hub_user_tasks` FOREIGN KEY (`hub_tasks_id`) REFERENCES `hub_tasks` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `user_tasks`
--
ALTER TABLE `user_tasks`
  ADD CONSTRAINT `user_tasks_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `hub_users` (`id`),
  ADD CONSTRAINT `user_tasks_ibfk_2` FOREIGN KEY (`task_id`) REFERENCES `hub_tasks` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
