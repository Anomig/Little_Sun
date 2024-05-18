-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Gegenereerd op: 18 mei 2024 om 08:46
-- Serverversie: 5.7.39
-- PHP-versie: 8.2.0

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
-- Tabelstructuur voor tabel `employees`
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
-- Gegevens worden geëxporteerd voor tabel `employees`
--

INSERT INTO `employees` (`id`, `firstname`, `lastname`, `email`, `password`, `function`, `location_id`, `task_id`) VALUES
(2, 'admin', 'admin', '@dmin.com', '$2y$10$Uifh.906br0ajEF6YcXk9.HIxhETnCCCKf/LFWHSlwIFS79Z9Pzwy', 'admin', NULL, NULL),
(3, 'man', 'eger', '@manager.com', '$2y$10$BfL3D9HeNhASTKLeo49xtuZLhALtI3uxWGqZp7ww5W1Nq5ff/vBlS', 'manager', NULL, NULL),
(5, 'user', 'user', '@user.com', '$2y$10$x8zxsxAYOUYksl4MeVnZh.4toHxcnxNyImVu.1HRlDQaf2DMbz4wO', 'user', NULL, NULL);

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
