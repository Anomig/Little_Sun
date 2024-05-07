 -- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Gegenereerd op: 07 mei 2024 om 11:15
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
-- Database: `littlesun`
--

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
(1, 'Amy', 'Bruyninckx', 'Amy@hotmail.com', '$2y$10$YHZjzfR32YI0leJDCcZRDe19ZYAz45yYvmfHTdrKA9Nc5jc.VKm0G', 'hub_users (1).sql'),
(2, 'Senne', 'Winkelmans', 'sen@win.be', '$2y$10$GTJoxwrfZaiAi6tZp66/jOvJvft43mqFpVPYSwhrFOPfRzvMqIusa', ''),
(19, 'user', 'user', '@user.be', '$2y$10$xrRI.5sc7jo3f/Dft.v/3eHo4JlhCh70blFc19N9Uknu7FFmiq8cC', ''),
(20, 'admin', 'admin', '@dmin.be', '$2y$10$XgzgAZJbaupZXxLvz61bFOiJg6DsXpUEpsdj5.mooFmi7JmA4F84K', '');

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `hub_users`
--
ALTER TABLE `hub_users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `hub_users`
--
ALTER TABLE `hub_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
