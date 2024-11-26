-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Loomise aeg: Nov 26, 2024 kell 11:31 EL
-- Serveri versioon: 10.4.32-MariaDB
-- PHP versioon: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Andmebaas: `tieto`
--

-- --------------------------------------------------------

--
-- Tabeli struktuur tabelile `firmad`
--

CREATE TABLE `firmad` (
  `id` int(11) NOT NULL,
  `firma` char(50) NOT NULL DEFAULT '',
  `aadress` char(50) NOT NULL DEFAULT '',
  `hinnang` int(10) NOT NULL,
  `grupp_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Andmete tõmmistamine tabelile `firmad`
--

INSERT INTO `firmad` (`id`, `firma`, `aadress`, `hinnang`, `grupp_id`) VALUES
(1, 'Pagar', 'Tehnika 5', 5, 0),
(2, 'Finedine', 'Kaeviku 4', 10, 0),
(3, 'Taksi', 'Rohe 4', 3, 0),
(4, 'Viigi', 'Metsa 4', 4, 0),
(5, 'Roheline', 'Silla 4', 6, 0),
(6, 'Hesburger', 'Viigi 1', 3, 0),
(7, 'Hall', 'Lahe 6', 7, 0),
(8, 'Mega', 'Silla 1', 9, 0),
(9, 'Sile Pann', 'Uus 8', 9, 0),
(10, 'KileKola', 'Toidu 9', 10, 0),
(11, 'Friikad', 'Roo 6', 6, 0);

--
-- Indeksid tõmmistatud tabelitele
--

--
-- Indeksid tabelile `firmad`
--
ALTER TABLE `firmad`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT tõmmistatud tabelitele
--

--
-- AUTO_INCREMENT tabelile `firmad`
--
ALTER TABLE `firmad`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
