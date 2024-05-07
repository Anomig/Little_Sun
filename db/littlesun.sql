-- phpMyAdmin SQL Dump
-- version 5.1.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Gegenereerd op: 07 mei 2024 om 08:13
-- Serverversie: 5.7.24
-- PHP-versie: 8.0.1

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
-- Tabelstructuur voor tabel `hub_location`
--

CREATE TABLE `hub_location` (
  `id` int(11) NOT NULL,
  `name` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `hub_location`
--

INSERT INTO `hub_location` (`id`, `name`, `country`) VALUES
(28, 'Little sun', 'Zambia');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `hub_managers`
--

CREATE TABLE `hub_managers` (
  `id` int(11) NOT NULL,
  `firstname` varchar(300) NOT NULL,
  `lastname` varchar(300) NOT NULL,
  `email` varchar(300) NOT NULL,
  `password` varchar(300) NOT NULL,
  `profile_picture` varchar(300) NOT NULL,
  `hub_location` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Gegevens worden geëxporteerd voor tabel `hub_managers`
--

INSERT INTO `hub_managers` (`id`, `firstname`, `lastname`, `email`, `password`, `profile_picture`, `hub_location`) VALUES
(1, 'Hannelore', 'Van Buynderen', '@dmin', '$2y$10$0prOcO787d6Yafq/l9Tpa.FPnA6R5c98o1oJwc4WVGyQPQhvezQ5S', '', ''),
(2, 'Hannelore', 'Van Buynderen', '@dmin.be', '$2y$10$gEEsQuYmYfNDtxXb.VvjguroOLsCjUI3QEQZHATMB55kI92xDlyiO', 'bla bla', 'boechout'),
(3, 'Hannelore', 'Van Buynderen', '@dmin.be', '$2y$10$ROi21mojrCiKqGxtigu1Mu3vGoM8IS3UOKWpakkrB2LFDEHiyEBfi', 'bla bla', 'boechout'),
(4, 'Hannelore', 'Van Buynderen', '@dmin.be', '$2y$10$nKadzeeAo/S/oXzfOdGQ5u.fhV8CYIiU/E2mG8xYfDw5rDkMlRkw6', 'bla bla', 'boechout'),
(5, 'Hannelore', 'Van Buynderen', '@dmin.be', '$2y$10$ZvFbjFWBUa3UraqemvpEIuTR4W3k7xcYClEUP6b/vcqRZ1Bd4qhvS', 'bla bla', 'boechout'),
(6, 'Hannelore', 'Van Buynderen', '@dmin.be', '$2y$10$LWA0nzYWl0qkBhSsIT6zGOgx9Vy3Z44UtVfWjyIj6DfTuffD7n.oq', 'bla bla', 'boechout'),
(7, 'Hannelore', 'Van Buynderen', '@dmin.be', '$2y$10$c6P/O5wfSMJr6aZ6nZ5cG.t8SbLXM2udcaVhDgfncvmPbXRTVsX4i', 'bla bla', 'boechout'),
(8, 'Elliot', 'VB', '@dmin.be', '$2y$10$umaqTC0.GnPma8cgSLtRz.ZndoC2kMs2Zru8L5HCrgPTaREq6S6xu', 'Afbeelding van WhatsApp op 2024-03-24 om 22.42.10_c7257563.jpg', 'Boechout'),
(9, 'Nieuwe', 'Manager', 'manager@example.com', 'wachtwoord', 'afbeelding.jpg', 'Hub locatie'),
(11, 'elliot', 'vb', 'h@llo.com', '$2y$10$Gd7F1OGrmlcW73Wnhekd4uZg1GRS9qx2HO6UZvqRa9kBEM17rRjJm', 'vuhvoibm', 'eulenlv'),
(12, 'elliot', 'de hond', 'elliot@dehond.be', '$2y$10$HxCd3YRJyDUAhcJ3xUHvsedVG4m9UyhXuTjU/nfuXRVqKPu8EA4eK', 'at the beach', 'in de zetel'),
(13, 'P', 'T', 'pt@.be', '$2y$10$.y40FFXIuRAo0Uha35lLke1oGqNM3h7kU6KvU6lix54p4JcuNnxJC', 'IMG_4062.jpg', 'leuven'),
(14, 'Hannelore', 'Van Buynderen', 'hannelorevb@hotmail.be', '$2y$10$7J.VukooC88.EfmB7teRV.SEQseNxhgfVS4tdC6cdhW5DvaqXVgTq', '5E99A7F2.jpg', 'Lier'),
(15, 'Amy', 'XD', 'amy@XD.be', '$2y$10$4InImDu4I.d0lzrT8u7m.OK1t9S8y2gQ2lbSLo1/3NEaOGfddowR.', 'achtergrond.png', 'Lier'),
(16, 'Amy', 'XD', 'amy@XD.be', '$2y$10$jpul..4d5i2cyI.Wei9qhOCFPDdG6zKkXkeWTAfK4U4iKIIX8epkq', 'achtergrond.png', 'Lier'),
(17, 'Elliot', 'VB', 'Elliot@vb.be', '$2y$10$RBElhBUhhjF9xyjMHh.SiuFzBMlM6Q58Q3Ve7k1TI.2kLbrKFh2pq', 'achtergrond.png', 'Boechout'),
(18, 'Pommelien', 'Thijs', 'Pommelien@thijs.be', '1234', 'https://image.demorgen.be/240472015/width/2480/pommelien-thijs', 'Leuven'),
(19, 'Hannelore', 'Van Buynderen', 'hannelorevb04', '$2y$10$ttNVCxVo/Pb1Ie2wKABb0eW95wLKY43S90JnI.59LxfkG7M3sOCLi', 'achtergrond.png', 'Mechelen'),
(20, 'Hannelore', 'Van Buynderen', 'hannelorevb@hotmail.be', '$2y$10$YeF7v44Wrv1yYWMKMRZ.xevEp0t2yU0foe.twWoIm4bM0qhwqeS4i', 'Afbeelding van WhatsApp op 2024-03-24 om 22.44.59_ad3dfd8f.jpg', 'Zambia'),
(21, 'hub', 'manager', 'hub@manager.be', '$2y$10$kQxYVk4SJIa2LMYaXAz77.tQBSNkWxd6sbuVjAORjHWxOYZhh8Dz2', 'Afbeelding van WhatsApp op 2024-03-24 om 23.03.02_f29099e3.jpg', '10'),
(22, 'hub', 'manager', 'hub@manager.be', '$2y$10$5VWTIUcOkqxUTv/MTF5s8Okv0fBXrP4msB3B5nGvphHhZ0Lp3BiyC', 'Afbeelding van WhatsApp op 2024-03-24 om 23.03.02_f29099e3.jpg', '10'),
(23, 'hub', 'manager', 'hub@manager.be', '$2y$10$mo36S0/6KJZ1cqqrRmclH.yMo312k6wwJvcvOMJn3pLG0P57rVxpu', 'Afbeelding van WhatsApp op 2024-03-24 om 23.03.02_f29099e3.jpg', '10'),
(24, 'hub', 'manager', 'hub@manager.be', '$2y$10$EdU5crS.iddjyhUjJl7sjuElcyWHTb6fcisMM99n8gR1wkdFfQGPy', 'Afbeelding van WhatsApp op 2024-03-24 om 23.03.02_f29099e3.jpg', '10'),
(25, 'Pommelien', 'Thijs', 'info@pommelien.be', '$2y$10$9rp6H2axbBUHky6auBdnoOEbVQn9VgX0Fj2EZNimh50ihQEWFQAzm', 'IMG_4073.jpg', '28');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `hub_tasks`
--

CREATE TABLE `hub_tasks` (
  `id` int(11) NOT NULL,
  `task_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `task_description` text COLLATE utf8mb4_unicode_ci,
  `task_type` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `task_status` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Open',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `hub_tasks`
--

INSERT INTO `hub_tasks` (`id`, `task_name`, `task_description`, `task_type`, `task_status`, `created_at`, `updated_at`) VALUES
(1, 'cleaning', 'cleaning', 'cleaning', 'Open', '2024-05-05 19:38:11', '2024-05-05 19:38:11'),
(6, 'hygiene', 'hygiene', NULL, 'Open', '2024-05-05 21:19:26', '2024-05-05 21:19:26'),
(7, 'hygiene', 'hygiene', NULL, 'Open', '2024-05-05 21:32:28', '2024-05-05 21:32:28');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `hub_users`
--

CREATE TABLE `hub_users` (
  `id` int(11) NOT NULL,
  `firstname` varchar(300) NOT NULL,
  `lastname` varchar(300) NOT NULL,
  `email` varchar(300) NOT NULL,
  `password` varchar(300) NOT NULL,
  `profile_picture` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Gegevens worden geëxporteerd voor tabel `hub_users`
--

INSERT INTO `hub_users` (`id`, `firstname`, `lastname`, `email`, `password`, `profile_picture`) VALUES
(1, 'Hannelore', 'Van Buynderen', 'hannelorevb@hotmail.be', '$2y$10$vPHv2WIadCzhSpZ7apRVkeX.PwTI9bruB.N0p4Hsun8nCA/yUaHem', 'IMG_4013.jpg'),
(2, 'Hannelore', 'Van Buynderen', 'hannelorevb@hotmail.be', '$2y$10$KuwkrIQud3n76Aqz8KSKFu/.X1cBlfHtO0F92RxLUQnC05Z8GQOKG', 'IMG_4013.jpg'),
(3, 'Hannelore', 'Van Buynderen', 'hannelorevb@hotmail.be', '$2y$10$/2jVrTfU3JmBFAoSJT5CkO8RfHxlBDaJIf3j/ry30kCMp4cu0ZIk2', 'Afbeelding van WhatsApp op 2024-03-24 om 22.42.10_c7257563.jpg'),
(4, 'Hannelore', 'Van Buynderen', 'elliot@dehond.be', '$2y$10$gpelQXb3JZanE9laroagceL4dRxs6CrtGAJCRPmxqMUrjA4i57qzS', 'Afbeelding van WhatsApp op 2024-03-24 om 23.04.09_febbe64b.jpg'),
(5, 'Pommelien', 'Thijs', 'Pommelien@thijs.be', '$2y$10$6KH4m4Wj9iXpn81hGg9ZW.w8TY4tfaHPUXHi77KVKrYnIlE/j2Eq6', 'Afbeelding van WhatsApp op 2023-08-26 om 15.44.28.jpg'),
(6, 'Jane', 'Rizzoli', 'jane@rizzoli.be', '$2y$10$Q45qluDlQeiwK2AxiMOdmuVVs0FKsUGdqaT2PRyVLxlZ.usNMDlie', 'Screenshot_2023-05-17-21-30-17-524_com.miui.gallery.jpg'),
(7, 'Jane', 'Rizzoli', 'jane@rizzoli.be', '$2y$10$CEaHJb1xgpgwZtSge51nDepaMB02y31SFKkx/OKiPRy3tqiCwhHOC', 'Screenshot_2023-05-17-21-30-17-524_com.miui.gallery.jpg'),
(8, 'jane', 'rizzoli', 'jane@rizzoli.be', '$2y$10$3woZ/emUKl1PpSU2dB0Aa.Nttbs3338F0VFiRfLBKQmDGbFpzSaKS', 'Afbeelding van WhatsApp op 2024-03-24 om 22.55.29_03020481.jpg'),
(9, 'jane', 'rizzoli', 'jane@rizzoli.be', '$2y$10$u5Z14F1KBErSde057PGKHumia0vYVgE4ipJ96VbsP9rzfXt0NhWO6', 'Afbeelding van WhatsApp op 2024-03-24 om 22.55.29_03020481.jpg'),
(10, 'Naomi', 'XD', 'Naomi@XD.be', '$2y$10$D3L3Y0CAD7T/xyXOOm1fle0AqOQcBRtT162qcRORpIw1IWpV3Ygeq', 'Afbeelding van WhatsApp op 2024-03-24 om 22.42.10_c7257563.jpg');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `time_off`
--

CREATE TABLE `time_off` (
  `id` int(11) NOT NULL,
  `start_date` varchar(300) NOT NULL,
  `end_date` varchar(300) NOT NULL,
  `reason` varchar(300) NOT NULL,
  `comments` varchar(300) NOT NULL,
  `status` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `hub_location`
--
ALTER TABLE `hub_location`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `hub_managers`
--
ALTER TABLE `hub_managers`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `hub_tasks`
--
ALTER TABLE `hub_tasks`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `hub_users`
--
ALTER TABLE `hub_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `time_off`
--
ALTER TABLE `time_off`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `hub_location`
--
ALTER TABLE `hub_location`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT voor een tabel `hub_managers`
--
ALTER TABLE `hub_managers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT voor een tabel `hub_tasks`
--
ALTER TABLE `hub_tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT voor een tabel `hub_users`
--
ALTER TABLE `hub_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT voor een tabel `time_off`
--
ALTER TABLE `time_off`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
